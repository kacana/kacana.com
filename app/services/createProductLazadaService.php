<?php namespace App\services;

use App\models\productModel;
use Kacana\ArrayToXML;
use App\services\thirdPartyTrade\lazada;
/**
 * Class productService
 * @package App\services
 */
class createProductLazadaService {

    private $_product;

    private $_productPost;

    private $_productGalleries;

    private $_properties;

    private $_productProperties;

    public function __construct($productId, $properties, $catId)
    {
        $productModel = new productModel();
        $this->_productPost = [];
        $this->_product = $productModel->getProductById($productId, [KACANA_PRODUCT_STATUS_ACTIVE]);
        $this->formatGalleryProduct();
        $this->formatPropertiesProduct();
        $this->parseProductSize($this->_product);
        $this->_properties = $properties;
        if(!$this->_product)
            throw new \Exception('BAD product ID');

        $this->_productPost['PrimaryCategory'] = $catId;
    }

    public function createProductAttributes(){
        $attributes = [];

        $attributes['name'] = $this->_product->name;
        $attributes['short_description'] = $this->_product->short_description;
        $attributes['brand'] = 'OEM';
        $attributes['model'] = 'NEW '.date('Y');
        $attributes['warranty_type'] = '63508';

        $this->_productPost['Attributes'] = $attributes;

        return $this;
    }

    public function createProductProperties(){
        $this->_productPost['Skus']['Sku'] = [];

        foreach ($this->_properties as $property){
            $productProperty = $this->_productProperties[$property['propertiesId']];
            $sku = [];
            $sku['SellerSku'] = $productProperty['product_id'].'_'.$property['propertiesId'];
            $sku['color_family'] = $productProperty['nameProperty'];
            $sku['quantity'] = 3;
            $sku['price'] = $productProperty['price'];

            $sku['package_length'] = $this->_product->length;
            $sku['package_height'] = $this->_product->height;
            $sku['package_weight'] = $this->_product->weight;
            $sku['package_width'] = $this->_product->width;
            $sku['package_content'] = '1 sản phẩm';

            $image['Image'] = [];

            foreach ($property['images'] as $imageId)
            {
                $galleryImage = $this->_productGalleries[$imageId];
                $imageMigrate = 'http:'.$galleryImage['image'];
                $imagePost = $this->migrateImageProperties($imageMigrate);
                if($imagePost)
                    array_push($image['Image'], $imagePost->Url);
            }

            $sku['Images'] = $image;

            array_push($this->_productPost['Skus']['Sku'], $sku);
        }

        return $this;
    }

    public function formatGalleryProduct(){
        $galleries = [];

        foreach ($this->_product->galleries->toArray() as $gallery)
        {
            $galleries[$gallery['id']] = $gallery;
        }

        $this->_productGalleries = $galleries;
    }

    public function formatPropertiesProduct(){
        $properties = [];

        foreach ($this->_product->productProperties->toArray() as $property)
        {
            $properties[$property['id']] = $property;
        }

        $this->_productProperties = $properties;
    }

    public function generateXmlFile(){
        $this->_productPost = ['Product' => $this->_productPost];
        $xml = new ArrayToXML();
        return $xml->buildXML($this->_productPost, 'Request');
    }


    public function parseProductSize(&$product){
        $propertyProduct = trim($product->property_description);
        preg_match_all('!\d+\.*\d*!', $propertyProduct, $matches);
        $matches = $matches[0];
        $product->width = $matches[0];
        $product->height = $matches[1];
        $product->length = $matches[2];
        $product->weight = 1;
    }

    public function migrateImageProperties($image){
        $contentMigrate = [];
        $contentMigrate['Image']['Url'] = str_replace(' ', '%20', $image);
        ;
        $xml = new ArrayToXML();
        $content = $xml->buildXML($contentMigrate, 'Request');

        $lazada = new lazada();
         return $lazada->migrateImage($content);
    }
}
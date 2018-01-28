<?php namespace App\services;

use App\models\baseModel;
use UAParser\Parser;
use Carbon\Carbon;

/**
 * Class baseService
 * @package App\services
 */
class baseService
{

    /**
     * @var baseModel
     */
    public $_baseModel;

    /**
     * baseService constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param $id
     * @param $status
     * @return mixed
     */
    public function changefieldDropdown($id, $status, $field, $table)
    {
        $baseModel = new baseModel();
        return $baseModel->changefieldDropdown($id, $status, $field, $table);
    }

    public function updateField($id, $content, $field, $table)
    {
        $baseModel = new baseModel();
        return $baseModel->updateField($id, $content, $field, $table);
    }

    public function getIpInformation($ip)
    {
        return json_decode(file_get_contents('http://freegeoip.net/json/' . $ip));;
    }

    public function parserUserAgent($userAgent)
    {
        $parser = Parser::create();
        $result = $parser->parse($userAgent);

        return $result;
    }

    public function fixStyleFormat($description)
    {
        $regEx = '/style=(.*?)>/';
        preg_match_all($regEx, $description, $data);

        $dataElements = $data[0];
        $dataStrings = $data[1];

        for ($i = 0; $i < count($dataElements); $i++) {
            $newStyle = 'style="' . str_replace(['"', '='], '', $dataStrings[$i]) . '">';
            $description = str_replace(($dataElements[$i]), $newStyle, $description);
        }

        return str_replace('text-align:justify;background:white"=""', '', $description);
    }

    public function trimElementDesc($description)
    {
        if (!trim($description))
            return '';

        $description = $this->fixStyleFormat($description);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding(trim($description), 'HTML-ENTITIES', "UTF-8"));

        $xpath = new \DOMXPath($dom);
        $nodeList = $xpath->evaluate('//p');

        for ($i = 0; $i < $nodeList->length; $i++) {

            $node = $nodeList->item($i);
            $childNode = $node->childNodes;
            $firstChildNode = $childNode->item(0);
            $parentNode = $node->parentNode;
            if (!(trim($node->textContent) || $node->getElementsByTagName('img')->length))
                $parentNode->removeChild($node);
            else if(isset($firstChildNode->tagName) && ($firstChildNode->tagName == 'figure')) {
                $node->parentNode->replaceChild($firstChildNode, $node);
            }
        }

        $nodeFigureList = $xpath->evaluate('//figure');

        for ($i = 0; $i < $nodeFigureList->length; $i++) {

            $node = $nodeFigureList->item($i);
            $childNode = $node->childNodes;
            $firstChildNode = $childNode->item(0);

            if (isset($firstChildNode) && $firstChildNode->tagName != 'img') {
                $node->parentNode->replaceChild($firstChildNode, $node);
            }

        }

        $nodeFigcaptionList = $xpath->evaluate('//figcaption');

        for ($i = 0; $i < $nodeFigcaptionList->length; $i++) {

            $node = $nodeFigcaptionList->item($i);
            $childNode = $node->childNodes;
            $firstChildNode = $childNode->item(0);
            $previousNode = $node->previousSibling;

            if(isset($firstChildNode) && !trim($firstChildNode->textContent))
                $node->parentNode->removeChild($node);
            else if(isset($firstChildNode->tagName) && ($firstChildNode->tagName == 'figure' || $firstChildNode->tagName == 'figcaption')) {
                $node->parentNode->replaceChild($firstChildNode, $node);
            }

        }

        $description = $this->parseToCurrentString($dom);

        $description = str_replace('<b>', '<strong>', $description);
        $description = str_replace('</b>', '</strong>', $description);

        return trim($description);
    }

    public function parseToCurrentString($doc)
    {
        $xpath = new \DOMXPath($doc);
        $nodeList = $xpath->evaluate('//body');
        $body = $doc->saveHTML($nodeList->item(0));

        $body = str_replace('<body>', '', $body);
        $body = str_replace('</body>', '', $body);

        return $body;
    }

    public function optimizeImage($image){

        if(trim($image))
            \Log::info('------- PROCESS COMPRESS IMAGE : '.$image.' -----------');
        else
        {
            \Log::warning('------- IMAGE NULL -----------');
            return false;
        }

        $longitude = HEAD_COMPANY_LOCATION_LONGITUDE;
        $latitude = HEAD_COMPANY_LOCATION_LATITUDE;
        $path = '/images/product/';
        $imageName = str_replace($path, '', $image);

        //optimize sie file
        try {

            $tinyKey = $this->getTinyfySecretKey();
            \Tinify\setKey($tinyKey);
            $source = \Tinify\fromUrl("https:".AWS_CDN_URL.$path.urlencode($imageName));
            $copyrighted = $source->preserve("copyright", "creation", 'location');
            $copyrighted->toFile("/app/public$path$imageName");

        } catch(\Tinify\AccountException $e) {
            \Log::error("The AccountException error message is: " . $e->getMessage());
            \Log::info('---FAILED COMPRESS IMAGE: '. $image .'-----');
            // Verify your API key and account limit.
        } catch(\Tinify\ClientException $e) {
            \Log::error("The ClientException error message is: " . $e->getMessage());
            \Log::info('---FAILED COMPRESS IMAGE: '. $image .'-----');
            // Check your source image and request options.
        } catch(\Tinify\ServerException $e) {
            \Log::error("The ServerException error message is: " . $e->getMessage());
            \Log::info('---FAILED COMPRESS IMAGE: '. $image .'-----');
            // Temporary issue with the Tinify API.
        } catch(\Tinify\ConnectionException $e) {
            \Log::error("The ConnectionException error message is: " . $e->getMessage());
            \Log::info('---FAILED COMPRESS IMAGE: '. $image .'-----');
            // A network connection error occurred.
        } catch(\Exception $e) {
            \Log::error("The Exception error message is: " . $e->getMessage());
            \Log::info('---FAILED COMPRESS IMAGE: '. $image .'-----');
            // Something else went wrong, unrelated to the Tinify API.
        }


        // add location for image file
        $imageFileName = str_replace(' ', '\\ ', $imageName);
        $command = "/app/Image-ExifTool-10.75/exiftool -GPSLongitudeRef=E -GPSLongitude=$longitude -GPSLatitudeRef=N -GPSLatitude=$latitude /app/public$path$imageFileName";
        exec($command);

        $productGalleryService = new productGalleryService();

        $productGalleryService->uploadToS3($image);
    }

    public function getTinyfySecretKey(){
        $keys = explode('|', TINYFY_SECRET_KEY);
        $keyAvailable = $keys[0]; // main key if free key is over limit 500
        foreach ($keys  as $key)
        {
            \Tinify\setKey($key);
            \Tinify\validate();
            $compressionsThisMonth = \Tinify\compressionCount();
            \Log::info('__Key: ' .$key.'__'.$compressionsThisMonth);
            if($compressionsThisMonth < 500 )
            {
                $keyAvailable = $key;
                return $keyAvailable;
            }

        }

        return $keyAvailable;
    }

    public function fixImageSize(){
        $basicService = new baseService();
        $productService = new productService();

        $products = $productService->getAllProductAvailable();
        \Log::debug('-----PRODUCT NAME: '.' ------');
        foreach ($products as $product){
            if($product->id >= 2137)
            {
                \Log::debug('-----PRODUCT ID: '.$product->id.' ------');

                \Log::debug('-----PRODUCT NAME: '.$product->name.' ------');
                foreach ($product->galleries as $gallery){
                    $image = $gallery->getOriginal('image');
                    $basicService->optimizeImage($image);

                    if($gallery->getOriginal('thumb'))
                    {
                        $image = $gallery->getOriginal('thumb');
                        $basicService->optimizeImage($image);
                    }
                }
                $basicService->optimizeImage($product->getOriginal('image'));
            }
        }
        \Log::info('--- DONE ROI ---');
    }


}


?>
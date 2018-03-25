<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\models\productModel;
use App\services\addressService;
use App\services\baseService;
use App\services\campaignService;
use App\services\productGalleryService;
use App\services\productService;
use App\services\tagService;
use App\models\productGalleryModel;
use Illuminate\Http\Request;

/**
 * Class ProductController
 * @package App\Http\Controllers\Admin
 */
class ProductController extends BaseController {

	/**
	 * Show products.
	 *
	 * @return Response
	 */
	public function index()
	{
	    $campaignService = new campaignService();
	    $campaigns = $campaignService->getCampaigns();
        return view('admin.product.index', ['campaigns' => $campaigns]);
	}

    /**
     * Generate table for product
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateProductTable(Request $request){
        $params = $request->all();
        $productService = new productService();

        try {
            $return = $productService->generateProductTable($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function generateImportProductTable(Request $request){
        $params = $request->all();
        $productService = new productService();

        try {
            $return = $productService->generateImportProductTable($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function generateProductTagTable(Request $request){
        $params = $request->all();
        $productService = new productService();

        try {
            $return = $productService->generateProductTagTable($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    /**
     *  edit product
     *
     * @param $domain
     * @param $id
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function editProduct($domain, $id, Request $request)
    {
        $productService = new productService();
        $addressService = new addressService();
        $productGalleryModel = new productGalleryModel();
        $tagService = new tagService();
        $results = [];

        try{
            if($request->isMethod('post')){
                $productService->updateProduct($request->all(), $id);
                return redirect('/product/editProduct/'.$id)->with('success', 'Cập nhật sản phẩm thành công!');
            }
            $product = $productService->getProductById($id, 0, false);

            $results['product'] = $productService->getProductById($id, 0, false);
            $results['tagColor'] = $tagService->getColorTag();
            $results['groupTag'] = $tagService->getTagGroup();
            $results['tagSize'] = $tagService->getSizeTag();
            $results['tagStyle'] = $tagService->getStyleTag();
            $results['countries'] = $addressService->getListCountry();
            $results['images'] = $productGalleryModel->getImagesProductByProductId($id);
            return view('admin.product.edit-product', $results);

        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }
    }

    public function exProduct(Request $request)
    {
        $productService = new productService();
        $addressService = new addressService();
        $productGalleryModel = new productGalleryModel();
        $tagService = new tagService();

        return view('admin.product.ex-product', ['user'=> $this->_user]);
    }

    public function imProduct(Request $request)
    {
        $productService = new productService();
        $addressService = new addressService();
        $productGalleryModel = new productGalleryModel();
        $tagService = new tagService();

        return view('admin.product.im-product');
    }

    public function addProductImage(Request $request){
        $productGalleryService = new productGalleryService();

        $return['ok'] = 0;
        $id = $request->input('productId');
        $imageName = $request->input('name');
        $type = $request->input('type', PRODUCT_IMAGE_TYPE_NORMAL);

        try {

            $return['data'] = $productGalleryService->addProductImage($id, $imageName, $type);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }
    public function updateProductImageType(Request $request){
        $productId = $request->input('productId');
        $imageId = $request->input('imageId');
        $action = $request->input('action');
        $productGallery = new productGalleryModel();
        $productGalleryService = new productGalleryService();
        $return['ok'] = 0;
        try {
            $image = $productGallery->getImageById($imageId);

            if($action == 'setPrimaryImage')
            {
                $return['data'] = $productGallery->setPrimaryImage($imageId, $productId);
            }
            elseif($action == 'deleteImage')
            {
                $productGalleryService->deleteImage($imageId);
                $return['data'] = true;

            }
            elseif($action == 'setSlideImage')
            {
                $return['data'] = $productGallery->setSlideImage($imageId);
            }

            $return['ok'] = 1;

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    public function createBaseProduct(Request $request){

        $productService = new ProductService();

        $productName = $request->input('productName');
        $productPriceIm = $request->input('productPriceIm');
        $productPriceEx = $request->input('productPriceEx');

        try {
            $product = $productService->createBaseProduct($productName, $productPriceIm, $productPriceEx);
            return redirect('/product/editProduct/'.$product->id);
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }
    }

    public function getProductTreeMenu(Request $request){
        $productService = new ProductService();

        $typeId = $request->input('typeId');
        $productId = $request->input('productId');
        $tagId = $request->get('node', 0);
        try {
            $return = $productService->getProductTreeMenu($tagId, $typeId, $productId);
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    public function updateImage(Request $request){
        $productId = $request->input('productId');
        $imageName = $request->input('name');

        try {
            $productService = new productService();
            $return['data'] = $productService->updateImage($productId, $imageName);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    public function countSearchProductByTagId(Request $request){
        $tagId = $request->input('tagId');
        $return['ok'] = 0;

        try {
            $productService = new productService();
            $return['data'] = $productService->countSearchProductByTagId($tagId);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    public function createCSVForRemarketing(){
        $productService = new productService();
        $return['ok'] = 0;

        try {
            $return['data'] = $productService->createCsvBD();
            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    public function sortProductGallery(Request $request){
        $productService = new productService();

        $imageIds = $request->input('imageIds');
        $productId =  $request->input('productId');

        try {
            $return['data'] = $productService->sortProductGallery($imageIds, $productId);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    public function deleteProductProperty(Request $request){
        $productService = new productService();
        $propertyId = $request->input('propertyId');

        try {
            $return['data'] = $productService->deleteProductProperty($propertyId);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    public function printBarcode($domain, $productId, $propertyId, Request $request){
        $productService = new productService();

        try {
            $product = $productService->getProductById($productId, 0, false);
            $product->tag_id = 387;
            $property = $productService->getProductProperty($propertyId);
            return view('admin.product.print_barcode', ['product' => $product, 'property' => $property]);
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
    }

    public function getProductInfoByPropertyId(Request $request){
        $productService = new productService();
        $return['ok'] = 0;
        $propertyId = $request->input('propertyId');
        $property = $productService->getProductProperty($propertyId);
        if($property)
        {
            $return['data'] = $property;
            $return['ok'] = 1;
        }

        return response()->json($return);

    }

    public function importProduct(Request $request){
        $productService = new productService();
        $return['ok'] = 0;

        $propertyId = $request->input('propertyId');
        $quantity = $request->input('quantity');
        $price = $request->input('price');
        $userId = $this->_user->id;

        $import = $productService->createImportProduct($propertyId, $quantity, $price, $userId);
        if ($import)
        {
            $return['ok'] = 1;
            $return['data'] = $import;
            $return['property'] = $productService->getProductProperty($propertyId);
            $return['user'] = $this->_user;
        }
        return response()->json($return);
    }

    public function updateImportProduct(Request $request){
        $productService = new productService();

        $importId = $request->input('importId');
        $quantity = $request->input('quantity');
        $price = $request->input('price');

        $return['ok'] = 0;

        $userId = $this->_user->id;

        $import = $productService->updateImportProduct($importId, $quantity, $price, $userId);

        if ($import)
        {
            $return['ok'] = 1;
        }
        return response()->json($return);
    }

    public function getProductAjax(Request $request){
        $productService = new productService();
        $productId = $request->input('product_id');
        $return['ok'] = 0;

        if ($productId) {
            $return['data'] = $productService->getProductAjaxById($productId);
            $return['ok'] = 1;
        }
        return response()->json($return);
    }
}

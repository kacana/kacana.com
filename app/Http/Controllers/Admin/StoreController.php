<?php namespace App\Http\Controllers\Admin;

use App\models\productGalleryModel;
use App\services\addressService;
use App\services\productService;
use App\services\storeService;
use App\services\tagService;
use Illuminate\Http\Request;

class StoreController extends BaseController
{

    public function index($domain, $storeId, Request $request)
    {
        $storeService = new storeService();
        $store = $storeService->getStoreById($storeId);
        return view('admin.store.index', array('store' => $store));
    }

    public function generateStoreProductTable($domain, $storeId, Request $request)
    {
        $storeService = new storeService();

        $params = $request->all();

        try {
            $return = $storeService->generateStoreProductTable($storeId, $params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function import($domain, $storeId, Request $request)
    {
        $productService = new productService();
        $addressService = new addressService();
        $productGalleryModel = new productGalleryModel();
        $tagService = new tagService();

        return view('admin.store.import');
    }

    public function history($domain, $storeId, Request $request)
    {
        $productService = new productService();
        $addressService = new addressService();
        $productGalleryModel = new productGalleryModel();
        $tagService = new tagService();

        return view('admin.store.history');
    }
}

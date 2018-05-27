<?php namespace App\Http\Controllers\Client;

use App\models\addressReceiveModel;
use App\models\addressCityModel;
use App\models\addressWardModel;
use App\models\orderDetailModel;
use App\models\productGalleryModel;
use App\models\User;
use App\services\addressService;
use App\services\productService;
use App\services\cartService;
use App\services\tagService;
use Cart;
use Form;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CartRequest;
use Illuminate\Http\Request;


/**
 * Class CartController
 * @package App\Http\Controllers\Client
 */
class CartController extends BaseController {


    /**
     * function mame: productDetail
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addProductToCart(Request $request)
    {
        $cartService = new cartService();
        $productService = new productService();

        $result = array();
        $result['ok'] = false;
        try{
            if ($request->isMethod('post')) {
                $productId = $request->get('productId', 0);
                $tagId = $request->get('tagId', 1);
                $colorId = $request->get('colorId', 0);
                $sizeId = $request->get('sizeId', 0);
                $quantity = $request->get('quantity', 1);
                $result['ok'] = true;
                $userId = (\Kacana\Util::isLoggedIn())?$this->_user->id:0;
                $result['item'] = $cartService->addProductToCart($productId, $colorId, $sizeId, $quantity, $tagId);
                $result['products'] = $productService->getProductRelated($tagId, 3, $userId, ['product_tag_type_id' => false]);
                $result['cart'] = $cartService->cartInformation();
            }
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }

        return response()->json($result);
    }

    /**
     * load data for cart
     *
     * @param Request $request
     * @return array|\BladeView|bool|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function loadCart(Request $request){
        $cartService = new cartService();

        $result = array();
        $result['ok'] = false;

        try{
                $result['ok'] = true;
                $result['cart'] = $cartService->cartInformation();
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }

        return response()->json($result);
    }

    /**
     * update Cart item
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateCart(Request $request)
    {
        $cartService = new cartService();

        $rowId = $request->get('rowId', 0);
        $quantity = $request->get('quantity', 0);
        $result = array();
        $result['ok'] = false;

        try{
            $cartService->updateCartItemQuantity($rowId, $quantity);
            $result['ok'] = true;
            $result['cart'] = $cartService->cartInformation();

        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }
        return response()->json($result);
    }


    /**
     * Action remove cart item
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeCart(Request $request)
    {
        $cartService = new cartService();

        $rowId = $request->get('rowId', 0);
        $result = array();
        $result['ok'] = false;

        try{
            $cartService->removeCartItem($rowId);
            $result['ok'] = true;
            $result['cart'] = $cartService->cartInformation();

        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }
        return response()->json($result);
    }

    /**
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function showCart()
    {
        $cartService = new cartService();
        return view('client.cart.index', ['cart' => $cartService->cartInformation()]);
    }

    /**
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function checkout(Request $request){
        $cartService = new cartService();

        $step = $request->get('step', 'login');
        $data = array();

        try{
            $data['step'] = $step;

            if($step == 'login')
            {
                return view('client.checkout.login', $data);
            }


        }
        catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $result['error'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($result);

    }

    public function getWardByDistrictId(Request $request){
        $addressService = new addressService();

        $districtId = $request->input('districtId');
        $result['ok'] = 0;
        try{
            $result['data'] = $addressService->getListWardByDistrictId($districtId);
            $result['ok'] = 1;
        }
        catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $result['error'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($result);

    }

    public function quickOrder(Request $request){
        $cartService = new cartService();

        $productId = $request->get('productId', 0);
        $tagId = $request->get('tagId', 1);
        $colorId = $request->get('colorId', 0);
        $sizeId = $request->get('sizeId', 0);
        $quantity = $request->get('quantity', 1);
        $phoneQuickOrderNumber = $request->input('phoneQuickOrderNumber');
        $quickOrder = true;
        $result['ok'] = 0;
        try{
            $cartService->addProductToCart($productId, $colorId, $sizeId, $quantity, $tagId, $quickOrder);
            $result['ok'] = 1;
            if($request->ajax())
            {
                return response()->json($result);
            }
            else
                return view('client.cart.index', ['phoneQuickOrderNumber' => $phoneQuickOrderNumber, 'cart' => $cartService->cartInformation()]);
        }
        catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }
    }

}

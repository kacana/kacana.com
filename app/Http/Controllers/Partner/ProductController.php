<?php namespace App\Http\Controllers\Partner;

use App\Commands\PostToSocial;
use App\services\productService;
use App\services\socialService;
use App\services\tagService;
use App\services\trackingService;
use App\services\userService;
use Illuminate\Http\Request;
use App\services\orderService;
use Kacana\Util;
use Auth;
use App\services\thirdPartyTrade\lazada;

/**
 * Class SocialController
 * @package App\Http\Controllers\Partner
 */
class ProductController extends BaseController {

    public function index(Request $request)
    {
        $userService = new userService();
        $lazada = new lazada();

        $user = Auth::user();
        $facebookAccountBusiness = $userService->getUserAccountBusinessSocial($user->id, KACANA_SOCIAL_TYPE_FACEBOOK);

        $lazadaCat = $lazada->getCategoryTree();
        return view('partner.product.index', ['facebookAccountBusiness' => $facebookAccountBusiness, 'user'=> $user, 'lazadaCat' => $lazadaCat]);
    }

    /**
     * Generate table for product
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateProductBootTable(Request $request){
        $params = $request->all();
        $productService = new productService();

        try {
            $return = $productService->generateProductBootTable($params);
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function productSupperBoot(Request $request){
        $productIds = $request->input('productIds', 0);
        $productService = new productService();
        $saleRule = '<br><br>🛫 Giao hàng toàn quốc<br>💵 Thanh toán khi nhận hàng<br>🏍 Miễn phí vận chuyển với đơn hàng trên 500k<br>📱 Mua hàng:'.$this->_user->phone;
        $return['ok'] = 0;

        try {
            $return['data'] = $productService->getProductsToBoot($productIds, $this->_user->id);
            $return['saleRule'] = $saleRule;
            $return['ok'] = 1;
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return response()->json($return);
    }

    public function postToSocial(Request $request){
        $socialService = new socialService();
        $socials = $request->input('socials', 0);
        $desc = $request->input('desc', '');
        $products = $request->input('products', 0);
        try {
            $return['data'] = $socialService->superPostToSocial($this->_user->id, $socials, $products, $desc);
            $return['ok'] = 1;

        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return response()->json($return);
    }
}

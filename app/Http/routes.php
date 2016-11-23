<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::pattern('id', '\d+');
Route::pattern('pid', '\d+');
Route::pattern('status', '[0-1]+');
Route::pattern('keyword', '[a-z0-9-]+');
Route::pattern('slug', '[a-zA-Z0-9-]+');

Route::pattern('nameDomain', '(www.kacana.com|kacana.com|dev.kacana.com|staging.kacana.com|www.kacana.vn|kacana.vn|dev.kacana.vn|staging.kacana.vn)');


Route::group(['prefix' => 'auth/'], function(){
    // Authentication routes...
    Route::get('login', array('as'=>'authGetLogin', 'uses' => 'Auth\AuthController@getLogin'));
    Route::post('login', 'Auth\AuthController@authLogin');
    Route::get('sign-out', 'Auth\AuthController@getLogout');

    // Registration routes...
    Route::any('signup', array('as'=>'authGetSignup', 'uses' =>  'Auth\SignupController@signup'));
    Route::any('signup/socialLoginCallback', 'Auth\SignupController@socialLoginCallback');
    Route::any('signup/facebookCallbackAllowPost', 'Auth\SignupController@facebookCallbackAllowPost');
});

Route::any('/sitemap.xml',                                      array('as'=>'sitemap',                   'uses'=>'Client\SitemapController@index'));
Route::any('/sitemap-tags.xml',                                 array('as'=>'sitemap-tags.xml',          'uses'=>'Client\SitemapController@sitemapTags'));
Route::any('/sitemap-products.xml',                             array('as'=>'sitemap-products.xml',      'uses'=>'Client\SitemapController@sitemapProducts'));
Route::any('/sitemap-pages.xml',                               array('as'=>'sitemap-pages.xml',        'uses'=>'Client\SitemapController@sitemapPages'));

/*********************************************************
 *
 *                  ROUTE FOR ADMIN MODULE
 *
 *********************************************************/

Route::group(['domain'=>KACANA_AUTH_ADMIN_NAME.'.{nameDomain}','middleware' => 'auth'], function () {

    Route::any('/', 'Admin\IndexController@index');
    Route::post('/index/reportChartUser',                   array('as'=>'index-report-chart-user',              'uses'=>'Admin\IndexController@reportChartUser'));
    Route::post('/index/reportChartOrder',                  array('as'=>'index-report-chart-order',             'uses'=>'Admin\IndexController@reportChartOrder'));
    Route::post('/index/reportChartProductLike',            array('as'=>'index-report-chart-product-like',      'uses'=>'Admin\IndexController@reportChartProductLike'));
    Route::post('/index/reportChartProductView',            array('as'=>'index-report-chart-product-view',      'uses'=>'Admin\IndexController@reportChartProductView'));
    Route::post('/index/reportChartTrackingSearch',         array('as'=>'index-report-chart-tracking-search',   'uses'=>'Admin\IndexController@reportChartTrackingSearch'));
    Route::any('/index/reportDetailTableUser',              array('as'=>'reportDetailTableUser',                'uses'=>'Admin\IndexController@reportDetailTableUser'));
    Route::any('/index/reportDetailTableOrder',             array('as'=>'reportDetailTableOrder',               'uses'=>'Admin\IndexController@reportDetailTableOrder'));
    Route::any('/index/reportDetailTableProductLike',       array('as'=>'reportDetailTableProductLike',         'uses'=>'Admin\IndexController@reportDetailTableProductLike'));
    Route::any('/index/reportDetailTableProductView',       array('as'=>'reportDetailTableProductView',         'uses'=>'Admin\IndexController@reportDetailTableProductView'));
    Route::any('/index/reportDetailTableTrackingSearch',    array('as'=>'reportDetailTableTrackingSearch',      'uses'=>'Admin\IndexController@reportDetailTableTrackingSearch'));

    //product
    Route::any('/product',                                  array('as'=>'listProducts',             'uses'=>'Admin\ProductController@index'));
    Route::any('/product/generateProductTable',             array('as'=>'generateProductTable',     'uses'=>'Admin\ProductController@generateProductTable'));
    Route::any('/product/generateProductTagTable',          array('as'=>'generateProductTagTable',  'uses'=>'Admin\ProductController@generateProductTagTable'));
    Route::any('/product/getProductTreeMenu',               array('as'=>'getProductTreeMenu',       'uses'=>'Admin\ProductController@getProductTreeMenu'));
    Route::any('/product/getProduct',                       array('as'=>'getProducts',              'uses'=>'Admin\ProductController@getProduct'));
    Route::any('/product/createProduct',                    array('as'=>'createProduct',            'uses'=>'Admin\ProductController@createProduct'));
    Route::any('/product/editProduct/{id}',                 array('as'=>'editProduct',              'uses'=>'Admin\ProductController@editProduct'));
    Route::get('/product/removeProduct/{id}',               array('as'=>'removeProduct',            'uses'=>'Admin\ProductController@removeProduct'));
    Route::any('/product/uploadImageDescription',           array('as'=>'uploadImageDescription',   'uses'=>'Admin\ProductController@uploadImageDescription'));
    Route::any('/product/listTags/',                        array('as'=>'ProductTags',              'uses'=>'Admin\ProductController@listTags'));
    Route::get('/product/setStatus/{id}/{status}',          array('as'=>'setStatusProduct',         'uses'=>'Admin\ProductController@setStatus'));
    Route::post('/product/addProductImage',                 array('as'=>'addProductImage',          'uses'=>'Admin\ProductController@addProductImage'));
    Route::post('/product/updateProductImageType',          array('as'=>'updateProductImageType',   'uses'=>'Admin\ProductController@updateProductImageType'));
    Route::post('/product/updateImage',                     array('as'=>'updateImage',              'uses'=>'Admin\ProductController@updateImage'));
    Route::post('/product/createBaseProduct',               array('as'=>'CreateBaseProduct',        'uses'=>'Admin\ProductController@createBaseProduct'));
    Route::post('/product/countSearchProductByTagId',       array('as'=>'countSearchProductByTagId','uses'=>'Admin\ProductController@countSearchProductByTagId'));
    Route::post('/product/createCSVForRemarketing',         array('as'=>'createCSVForRemarketing','uses'=>'Admin\ProductController@createCSVForRemarketing'));

    //branch
    Route::any('/product/branch',                           array('as'=>'listBranches',             'uses'=>'Admin\BranchController@index'));
    Route::any('/branch/getBranch',                         array('as'=>'getBranches',              'uses'=>'Admin\BranchController@getBranch'));
    Route::post('/branch/createBranch',                     array('as'=>'createBranch',             'uses'=>'Admin\BranchController@createBranch'));
    Route::get('/branch/showEditFormBranch/{id}',           array('as'=>'showEditFormBranch',       'uses'=>'Admin\BranchController@showEditFormBranch'));
    Route::post('/branch/editBranch',                       array('as'=>'editBranch',               'uses'=>'Admin\BranchController@editBranch'));
    Route::get('/branch/setStatusBranch/{id}/{status}',     array('as'=>'setStatusBranch',          'uses'=>'Admin\BranchController@setStatusBranch'));
    Route::get('/branch/removeBranch/{id}',                 array('as'=>'removeBranch',             'uses'=>'Admin\BranchController@removeBranch'));

    //tag
    Route::any('/product/tag',                              array('as'=>'listTags',                 'uses'=>'Admin\TagController@index'));
    Route::any('/tag/relation/{typeId}',                    array('as'=>'relationtag',              'uses'=>'Admin\TagController@relation'));
    Route::any('/tag/getTreeTag',                           array('as'=>'getTreeTag',               'uses'=>'Admin\TagController@getTreeTag'));
    Route::post('/tag/createTag',                           array('as'=>'createTag',                'uses'=>'Admin\TagController@createTag'));
    Route::post('/tag/addTagToRoot',                        array('as'=>'addTagToRoot',             'uses'=>'Admin\TagController@addTagToRoot'));
    Route::post('/tag/addTagToParent',                      array('as'=>'addTagToParent',           'uses'=>'Admin\TagController@addTagToParent'));
    Route::post('/tag/editTag',                             array('as'=>'editTag',                  'uses'=>'Admin\TagController@editTag'));
    Route::post('/tag/removeTagRelation',                   array('as'=>'removeTagRelation',        'uses'=>'Admin\TagController@removeTagRelation'));
    Route::post('/tag/searchTagRelation',                   array('as'=>'searchTagRelation',        'uses'=>'Admin\TagController@searchTagRelation'));
    Route::any('/tag/searchTagProduct',                     array('as'=>'tag_search_tag_product',   'uses'=>'Admin\TagController@searchTagProduct'));
    Route::any('/tag/searchTag',                            array('as'=>'tag_search_tag',           'uses'=>'Admin\TagController@searchTag'));
    Route::post('/tag/processTagMove',                      array('as'=>'processTagMove',           'uses'=>'Admin\TagController@processTagMove'));
    Route::post('/tag/updateImage',                         array('as'=>'updateImage',              'uses'=>'Admin\TagController@updateImage'));
    Route::get('/tag/generateTagTable',                     array('as'=>'generateTagTable',         'uses'=>'Admin\TagController@generateTagTable'));
    Route::get('/tag/getTag',                               array('as'=>'tag-get-tag',              'uses'=>'Admin\TagController@getTag'));
    Route::any('/tag/fullEditTag/{id}',                     array('as'=>'tag-full-edit-tag',        'uses'=>'Admin\TagController@fullEditTag'));
    Route::any('/tag/getGroupTag',                          array('as'=>'tag-get-group-tag',        'uses'=>'Admin\TagController@getGroupTag'));
    Route::post('/tag/changeTagStatusRelation',             array('as'=>'tag-change-status-relation-tag',        'uses'=>'Admin\TagController@changeTagStatusRelation'));

    //user
    Route::any('/user',                                     array('as'=>'listUsers',                 'uses'=>'Admin\UserController@index'));
    Route::any('/user/generateUserTable',                   array('as'=>'generateUserTable',         'uses'=>'Admin\UserController@generateUserTable'));
//    Route::any('/user/generateDetailTable',                   array('as'=>'generateDetailTable',         'uses'=>'Admin\UserController@generateDetailTable'));
    Route::post('/user/create',                             array('as'=>'createUser',                'uses'=>'Admin\UserController@create'));
    Route::any('/user/edit/{pid}',                          array('as'=>'editUser',                  'uses'=>'Admin\UserController@edit'));
    Route::get('/user/setStatus/{id}/{status}',             array('as'=>'setStatusUser',             'uses'=>'Admin\UserController@setStatus'));
    Route::get('/user/remove/{id}',                         array('as'=>'removeUser',                'uses'=>'Admin\UserController@destroy'));
    Route::get('/user/showCreateForm',                      array('as'=>'showCreateForm',            'uses'=>'Admin\UserController@showCreateForm'));
    Route::get('/user/getUserAddress/{id}',                 array('as'=>'listUserAddress',           'uses'=>'Admin\UserController@getUserAddress'));
    Route::get('/user/showFormEditUserAddress/{id}',        array('as'=>'showFormEditUserAddress',   'uses'=>'Admin\UserController@showFormEditUserAddress'));
    Route::post('/user/editUserAddress',                    array('as'=>'editUserAddress',           'uses'=>'Admin\UserController@editUserAddress'));
    Route::get('/user/showListWards/{id}',                  array('as'=>'showListWards',             'uses'=>'Admin\UserController@showListWards'));

    //Info request
    Route::any('/advisory',                                  array('as'=>'index',                           'uses'=>'Admin\AdvisoryController@index'));
    Route::any('/advisory/getAdvisory',                      array('as'=>'getAdvisory',                     'uses'=>'Admin\AdvisoryController@getAdvisory'));

    //Order Request
    Route::any('/order',                                     array('as'=>'listOrder',                       'uses'=>'Admin\OrderController@index'));
    Route::any('/order/generateOrderTable',                  array('as'=>'generateOrderTable',              'uses'=>'Admin\OrderController@generateOrderTable'));
    Route::any('/order/edit/{id}',                           array('as'=>'edit',                            'uses'=>'Admin\OrderController@edit'));
    Route::any('/order/orderDetails/{id}',                   array('as'=>'orderDetails',                    'uses'=>'Admin\OrderController@getListOrderDetail'));
    Route::get('/order/deleteOrderDetail/{id}',              array('as'=>'orderDetails',                    'uses'=>'Admin\OrderController@deleteOrderDetail'));
    Route::post('/order/updateOrderService',                 array('as'=>'updateOrderService',              'uses'=>'Admin\OrderController@updateOrderService'));
    Route::any('/order/getOrderDetailisOrdered',             array('as'=>'getOrderDetailisOrdered',         'uses'=>'Admin\OrderController@getOrderDetailisOrdered'));
    Route::any('/order/checkFeeShipping',                    array('as'=>'checkFeeShipping',                'uses'=>'Admin\OrderController@checkFeeShipping'));
    Route::any('/order/searchAddressDelivery',               array('as'=>'searchAddressDelivery',           'uses'=>'Admin\OrderController@searchAddressDelivery'));
    Route::any('/order/createOrder',                         array('as'=>'OrderCreateOrder',                'uses'=>'Admin\OrderController@createOrder'));
    Route::post('/order/updateOrderDetail/{orderId}/{orderDetailId}', array('as'=>'OrderUpdateOrderDetail', 'uses'=>'Admin\OrderController@updateOrderDetail'));
    Route::post('/order/searchProduct',                      array('as'=>'OrderSearchProduct',              'uses'=>'Admin\OrderController@searchProduct'));
    Route::get('/order/addProductToOrder',                   array('as'=>'OrderAddProductToOrder',           'uses'=>'Admin\OrderController@addProductToOrder'));
    Route::get('/order/deleteOrderDetail',                   array('as'=>'OrderDeleteOrderDetail',           'uses'=>'Admin\OrderController@deleteOrderDetail'));
    Route::get('/order/getWardByDistrictId',                 array('as'=>'OrderGetWardByDistrictId',         'uses'=>'Admin\OrderController@getWardByDistrictId'));

    //Shipping Controller
    Route::any('/shipping',                                  array('as'=>'listShipping',                 'uses'=>'Admin\ShippingController@index'));
    Route::any('/shipping/createShipping',                   array('as'=>'createShipping',               'uses'=>'Admin\ShippingController@createShipping'));
    Route::any('/shipping/generateShippingTable',            array('as'=>'generateShippingTable',        'uses'=>'Admin\ShippingController@generateShippingTable'));
    Route::get('/shipping/detail/',                          array('as'=>'detailShipping',               'uses'=>'Admin\ShippingController@detail'));
    Route::get('/shipping/printOrder/',                      array('as'=>'ShippingPrintOrder',               'uses'=>'Admin\ShippingController@printOrder'));

    Route::any('/upload/chunk',                              array('as'=>'upload',     'uses'=>'Client\UploadController@chunk'));

    // General request

    Route::any('/base/changeStatus',                         array('as'=>'changeStatus',     'uses'=>'Admin\BaseController@changeStatus'));


});

Route::group(['domain'=>KACANA_AUTH_PARTNER_NAME.'.{nameDomain}','middleware' => 'auth'], function () {

    Route::get('/',                                         array('as'=>'partner_index',                                        'uses'=>'Partner\IndexController@index'));

    // SOCIAL CONTROLLER
    Route::get('/social_account',                           array('as'=>'partner_social_account',                               'uses'=>'Partner\SocialController@index'));
    Route::post('/social_account/addFacebookAccount',       array('as'=>'partner_social_account_add_facebook_account',          'uses'=>'Partner\SocialController@addFacebookAccount'));
    Route::post('/social_account/changeNameSocialItem',     array('as'=>'partner_social_account_change_name_social-item',       'uses'=>'Partner\SocialController@changeNameSocialItem'));
    Route::post('/social_account/deleteSocialItem',         array('as'=>'partner_social_account_delete_social_item',            'uses'=>'Partner\SocialController@deleteSocialItem'));

    //PRODUCT CONTROLLER
    Route::get('/product',                                  array('as'=>'partner_product',                                      'uses'=>'Partner\ProductController@index'));


    //upload function
    Route::any('/upload/chunk',                              array('as'=>'upload',     'uses'=>'Client\UploadController@chunk'));
});


/*********************************************************
 *
 *
 *                  ROUTE FOR CLIENT MODULE
 *
 *
 *
 *********************************************************/

Route::group(['domain'=>'{nameDomain}', 'middleware' => 'client'], function () {
    Route::any('/',                                         array('as'=>'homepage',                         'uses'=>'Client\IndexController@index'));
    Route::post('/index/saveProductLike',                   array('as'=>'homepage-save-product-like',       'uses'=>'Client\IndexController@saveProductLike'));
    Route::any('/tim-kiem/{search}',                        array('as'=>'homepage-search',                  'uses'=>'Client\IndexController@searchProduct'));

    //product
    Route::group(['prefix'=>'san-pham'], function(){
        Route::get('{slug}--{id}--{tagId}',                 array('as'=>'productDetail',                        'uses'=>'Client\ProductController@productDetail'));
        Route::any('suggestSearchProduct',                  array('as'=>'product-suggest-search-product',       'uses'=>'Client\ProductController@suggestSearchProduct'));
        Route::post('loadMoreProductWithType',              array('as'=>'product-load-more-product-with-type',  'uses'=>'Client\ProductController@loadMoreProductWithType'));
        Route::post('postProductToFacebook',                array('as'=>'product-post-product-to-facebook',     'uses'=>'Client\ProductController@postProductToFacebook'));
        Route::post('trackUserProductView',                 array('as'=>'product-track-user-product-view',      'uses'=>'Client\ProductController@trackUserProductView'));
    });
    Route::get('{slug}--{id}',                              array('as'=>'listProductByCate',                'uses'=>'Client\ProductController@listProductByCate'));
    Route::post('loadListProducts',                         array('as'=>'loadListProducts',                 'uses'=>'Client\ProductController@loadListProducts'));
    Route::post('loadFilter',                               array('as'=>'filterProduct',                    'uses'=>'Client\ProductController@filterProduct'));

    //cart
    Route::post('cart/addProductToCart',                    array('as'=>'addProductToCart',                 'uses'=>'Client\CartController@addProductToCart'));
    Route::get('/thanh-toan',                               array('as'=>'showCart',                         'uses'=>'Client\CartController@showCart'));
    Route::get('/cart/loadCart',                            array('as'=>'loadCart',                         'uses'=>'Client\CartController@loadCart'));
    Route::post('cart/removeCart',                          array('as'=>'removeCart',                       'uses'=>'Client\CartController@removeCart'));
    Route::post('cart/updateCart',                          array('as'=>'updateCart',                       'uses'=>'Client\CartController@updateCart'));
    Route::post('cart/processCart',                         array('as'=>'processCart',                      'uses'=>'Client\CartController@processCart'));
    Route::get('cart/don-dat-hang/{id}',                    array('as'=>'orderDetail',                      'uses'=>'Client\CartController@orderDetail'));
    Route::get('/cart/getWardByDistrictId',                array('as'=>'cart_getWardByDistrictId',         'uses'=>'Client\CartController@getWardByDistrictId'));

    //Contact Controller
    Route::any('/contact/gioi-thieu',                       array('as'=>'CompanyIntroduction',              'uses'=>'Client\ContactController@introduction'));
    Route::any('/contact/thong-tin-lien-he',                array('as'=>'CompanyContactInformation',        'uses'=>'Client\ContactController@contactInformation'));
    Route::any('/contact/chinh-sach-doi-hang',              array('as'=>'CompanyReturnRule',                'uses'=>'Client\ContactController@returnRule'));
    Route::any('/contact/chinh-sach-bao-mat',               array('as'=>'CompanyPrivacyRule',               'uses'=>'Client\ContactController@privacyRule'));
    Route::any('/contact/chinh-sach-khach-hang',            array('as'=>'CompanyCustomerRule',              'uses'=>'Client\ContactController@customerRule'));
    Route::any('/contact/ban-hang-voi-chung-toi',           array('as'=>'CompanySaleWithUsRule',            'uses'=>'Client\ContactController@saleWithUs'));

    //checkout
    Route::any('/checkout',                                 array('as'=>'checkout',                         'uses'=>'Client\CheckoutController@index'));
    Route::any('/checkout/success',                         array('as'=>'checkout',                         'uses'=>'Client\CheckoutController@processOrder'));
    Route::any('/upload/chunk',                             array('as'=>'upload',                           'uses'=>'Client\UploadController@chunk'));

    //Customer Controller
    Route::any('/khach-hang/kiem-tra-don-hang',             array('as'=>'CustomerTrackingOrder',            'uses'=>'Client\CustomerController@trackingOrder'));
    Route::any('/khach-hang/quen-mat-khau',                 array('as'=>'CustomerForgotPassword',           'uses'=>'Client\CustomerController@forgotPassword'));
    Route::any('/khach-hang/quen-mat-khau-gui-email',       array('as'=>'CustomerForgotPasswordEmailSent',  'uses'=>'Client\CustomerController@forgotPasswordEmailSent'));
    Route::any('/khach-hang/mat-khau-moi',                  array('as'=>'CustomerNewPassword',              'uses'=>'Client\CustomerController@newPassword'));

    Route::group(['prefix'=>'khach-hang', 'middleware' => 'auth'], function(){
        Route::any('tai-khoan',                             array('as'=>'CustomerAccount',                  'uses'=>'Client\CustomerController@account'));
        Route::any('don-hang-cua-toi',                      array('as'=>'CustomerMyOrder',                  'uses'=>'Client\CustomerController@myOrder'));
        Route::any('so-dia-chi',                            array('as'=>'CustomerMyAddess',                 'uses'=>'Client\CustomerController@myAddress'));
        Route::any('so-dia-chi/{id}',                       array('as'=>'CustomerMyAddessDetail',           'uses'=>'Client\CustomerController@myAddressDetail'));
        Route::any('thiet-lap-dia-chi-mac-dinh/{id}',       array('as'=>'CustomerMakeDefaultAddess',        'uses'=>'Client\CustomerController@makeDefaultAddess'));
        Route::any('xoa-dia-chi/{id}',                      array('as'=>'CustomerDeleteMyAddress',          'uses'=>'Client\CustomerController@deleteMyAddress'));
        Route::any('them-dia-chi',                          array('as'=>'CustomerAddNewAddressReceive',     'uses'=>'Client\CustomerController@addNewAddressReceive'));
        Route::any('/kiem-tra-don-hang/{orderCode}',        array('as'=>'CustomerTrackingMyOrder',          'uses'=>'Client\CustomerController@trackingMyOrder'));
        Route::post('cap-nhat-thong-tin',                   array('as'=>'CustomerAccountUpdateInformation', 'uses'=>'Client\CustomerController@accountUpdateInformation'));
        Route::post('cap-nhat-mat-khau',                    array('as'=>'CustomerAccountUpdatePassword',    'uses'=>'Client\CustomerController@accountUpdatePassword'));
        Route::get('danh-sach-yeu-thich',                  array('as'=>'CustomerProductLike',              'uses'=>'Client\CustomerController@productLike'));
        Route::post('saveProductLike',                      array('as'=>'CustomerSaveProductLike',          'uses'=>'Client\CustomerController@saveProductLike'));
        Route::post('removeProductLike',                    array('as'=>'CustomerRemoveProductLike',        'uses'=>'Client\CustomerController@removeProductLike'));
    });
});
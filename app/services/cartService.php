<?php namespace App\services;

use Cart;
use App\services\orderService;

/**
 * Class shipService
 * @package App\services
 */
class cartService {

    /**
     * @param $productId
     * @param $colorId
     * @param $sizeId
     * @param $quantity
     * @param $tagId
     * @return \Gloudemans\Shoppingcart\Gloudemans\Shoppingcart\CartCollection
     * @throws \Exception
     */
    public function addProductToCart($productId, $colorId, $sizeId, $quantity, $tagId){
        $productService = new productService();
        $tagService = new tagService();

        if(!$productId)
            throw new \Exception('có lỗi xảy ra trong quá trình đặt hàng!');

        $product = $productService->getProductById($productId);

        if(!$product)
            throw new \Exception('sản phẩm không tồn tại!');

        $productName = $product->name;
        $productPrice = $product->sell_price - $product->discount;
        $cartId = $this->generateCartId($productId, $colorId, $sizeId);
        $productImage = $product->image;
        $properties = $product->properties;
        $options = [];

        $options['url'] = urlProductDetail($product).$tagId;
        $options['priceShow'] = formatMoney($productPrice);
        $options['productId'] = $productId;

        // check properties of product
        if(count($properties))
        {
            if(!isset($properties[$colorId]))
            {
                throw new \Exception('sản phẩm không tồn tại colorId: '.$colorId.'!');
            }
            else{
                $colorTag = $tagService->getTagById($colorId, TAG_RELATION_TYPE_COLOR);
                $property =  $properties[$colorId];
                $sizeIds = $property->sizeIds;
                if($colorTag)
                {
                    $options['colorId'] = $colorId;
                    $options['colorName'] = $colorTag->name;

                    if($property->product_gallery_id)
                    {
                        $galleries = $product->galleries;

                        if($galleries && count($galleries))
                            foreach($galleries as $gallery)
                            {
                                if($gallery->id == $property->product_gallery_id)
                                    $productImage = $gallery->image;
                            }
                    }

                    if(count($sizeIds) && !in_array($sizeId, $sizeIds))
                    {
                        throw new \Exception('sản phẩm không tồn tại colorId: '.$colorId.' với sizeId: '.$sizeId.'!');
                    }
                    else if(count($sizeIds) && in_array($sizeId, $sizeIds))
                    {
                        $sizeTag = $tagService->getTagById($sizeId, TAG_RELATION_TYPE_SIZE);
                        if($sizeTag)
                        {
                            $options['sizeId'] = $sizeId;
                            $options['sizeName'] = $sizeTag->name;
                        }
                        else{
                            throw new \Exception('sizeId: '.$sizeId.' không tồn tại trong hệ thống hoặc bị tắt!');
                        }
                    }
                }
                else{
                    throw new \Exception('colorId: '.$colorId.' không tồn tại trong hệ thống hoặc bị tắt!');
                }
            }
        }

        $options['image'] = $productImage;
        $options['discount'] = ($product->discount)?$product->discount:0;
        $options['origin_price'] = $product->sell_price;

        $order = Cart::add(
            array(
                'id' => $cartId,
                'name' => $productName,
                'qty' => $quantity,
                'price' => $productPrice,
                'options'=>$options
            )
        );

        return Cart::get(Cart::search(['id' => $cartId])[0]);
    }


    /**
     * important function to generate cartId - please don't change if not necessary
     *
     * @param $productId
     * @param $colorId
     * @param $sizeId
     * @return string
     */
    public function generateCartId($productId, $colorId, $sizeId){
        return $productId.'_'.$colorId.'_'.$sizeId;
    }

    /**
     * re-format cart information
     *
     * @return bool|\stdClass
     */
    public function cartInformation(){
        $cartInformation = new \stdClass();
        $cartInformation->total = Cart::total();
        $cartInformation->totalShow = formatMoney(Cart::total());
        $cartInformation->items = array();
        $quantity = 0;
        if(Cart::content()->count())
        {
            foreach(Cart::content() as $row){
                $item = new \stdClass();
                $item->name = $row->get('name');
                $item->quantity = $row->get('qty');
                $item->rowId = $row->get('rowid');
                $item->id = $row->get('id');
                $item->price = $row->get('price');
                $item->subTotal = $row->get('subtotal');
                $item->options = new \stdClass();
                foreach($row->get('options') as $key => $value)
                {
                    $item->options->{$key} = $value;
                }
                $item->options->subtotalShow = formatMoney($item->subTotal);
                $quantity += $row->get('qty');

                array_push($cartInformation->items, $item);
            }
            $cartInformation->quantity = $quantity;

            return $cartInformation;
        }

        return false;

    }

    /**
     * update cart item quantity
     *
     * @param $rowId
     * @param $quantity
     * @return bool
     * @throws \Exception
     */
    public function updateCartItemQuantity($rowId, $quantity){

        if(!$rowId)
            throw new \Exception('bad rowId');

        if($quantity < 1)
            throw new \Exception('bad quantity');

        if(!Cart::update($rowId, $quantity))
            throw new \Exception('not exists rowId');

        return true;
    }

    /**
     * remove cart item with row id
     *
     * @param $rowId
     * @return bool
     * @throws \Exception
     */
    public function removeCartItem($rowId){
        if(!$rowId)
            throw new \Exception('bad rowId');

        return Cart::remove($rowId);
    }

    public function processCart($order){
        $addressService = new addressService();
        $userService = new userService();
        $orderService = new orderService();

        $cart = $this->cartInformation();

        if(!$cart)
            throw new \Exception('bad Cart items');
        if(!$order['email'])
            throw new \Exception('bad email');

        if(!$order['name'])
            throw new \Exception('bad user name');

        if(!$order['street'])
            throw new \Exception('bad street');

        if(!$order['city_id'])
            throw new \Exception('bad cityId');

        if(!$order['district_id'])
            throw new \Exception('bad districtId');

//        if(!$order['ward_id'])
//            throw new \Exception('bad ward_id');

        if(!$order['phone'])
            throw new \Exception('bad phone number');

        // check user if exists - we not create new user
        $user = $userService->getUserByEmail($order['email']);
        if(!$user)
        {
            $order['role'] = KACANA_USER_ROLE_BUYER;
            $order['status'] = KACANA_USER_STATUS_CREATE_BY_SYSTEM;
            $user = $userService->createUser($order);
        }
        $addressDefault = 1;
        if(count($user->userAddress))
            $addressDefault = 0;
        // create new address for user
        $addressReceive = $addressService->createUserAddress($user->id, $order, $addressDefault);

        // create new order for user
        $order = $orderService->createOrder($user->id, $addressReceive->id, $cart->total, $cart->quantity);
        $items = $cart->items;
        foreach($items as $item)
        {
            $orderService->createOrderDetail($order->id, $item);
        }

        // destroy CART

        Cart::destroy();

        //send email for user
        $mailService = new mailService();

        if($mailService->sendEmailOrder($user->email, $order->id))
            return $order;
        else
            throw new \Exception('Bị lỗi trong quá trình gửi mail');

        // send zalo message for user

        return $order;
    }

    public function processCartWithAddressId($userEmail, $addressId){
        $addressService = new addressService();
        $userService = new userService();
        $orderService = new orderService();

        $cart = $this->cartInformation();

        if(!$cart)
            throw new \Exception('bad Cart items');

        $checkAddressUser = false;
        $user = $userService->getUserByEmail($userEmail);

        foreach($user->userAddress as $userAddres) {
            if($userAddres->id == $addressId)
            {
                $checkAddressUser = true;
            }
        }

        if(!$checkAddressUser)
            throw new \Exception('bad address id');


        // create new order for user
        $order = $orderService->createOrder($user->id, $addressId, $cart->total, $cart->quantity);
        $items = $cart->items;
        foreach($items as $item)
        {
            $orderService->createOrderDetail($order->id, $item);
        }

        // destroy CART

        Cart::destroy();

        //send email for user
        $mailService = new mailService();

        if($mailService->sendEmailOrder($user->email, $order->id))
            return $order;
        else
            throw new \Exception('Bị lỗi trong quá trình gửi mail');

        // send zalo message for user

        return $order;
    }
}

?>
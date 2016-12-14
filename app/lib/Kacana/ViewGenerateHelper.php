<?php namespace Kacana;
use Illuminate\Support\Facades\Auth;


class ViewGenerateHelper {

    static function dropdownView ($tableName, $id, $value, $field = 'status', $options = null)
    {
        if(!$options)
            $options =array(KACANA_GENERAL_STATUS_INACTIVE,KACANA_GENERAL_STATUS_ACTIVE);

        //Dropdown for status column
        $statusStr = '<div class="btn-group">
                            <a class="btn btn-default kacana-dropdown btn-xs dropdown-toggle" data-toggle="dropdown" href="#" id="'.$tableName.'-status-btn-'.$id.'">'.
            self::getDropdownIcon($tableName.'_'.$field.'_'.$value).
            '<span class="caret"></span>
                            </a>
                    <ul class="dropdown-menu">';

                        foreach($options as $key)
                        {
                            $statusStr.=    '<li>
                                                <a href="#change-kacana-dropdown" data-field="'.$field.'" data-table-name="'.$tableName.'" data-id="'.$id.'" data-value="'.$key.'">'.
                                                    self::getDropdownIcon($tableName.'_'.$field.'_'.$key).
                                                '</a>
                                            </li>';
                        }
                $statusStr .= '</ul><div>';

         return $statusStr;
    }

    static function getDropdownIcon($key){

        switch($key){
            case 'products_status_'.KACANA_PRODUCT_STATUS_ACTIVE:
            case 'users_status_'.KACANA_USER_STATUS_ACTIVE:
            case 'tags_status_'.KACANA_TAG_STATUS_ACTIVE:
                $iconStatus = '<i class="fa fa-chevron-down"></i> Active ';
                break;
            case 'products_status_'.KACANA_PRODUCT_STATUS_INACTIVE:
            case 'users_status_'.KACANA_USER_STATUS_INACTIVE:
            case 'tags_status_'.KACANA_TAG_STATUS_INACTIVE:
                $iconStatus = '<i class="fa fa-minus"></i> Inactive ';
                break;
            case 'users_status_'.KACANA_USER_STATUS_BLOCK:
                $iconStatus = '<i class="fa fa-ban"></i> block ';
                break;
            case KACANA_GENERAL_STATUS_REQUIREMENT:
                $iconStatus = '<i class="fa fa-question-circle-o"></i> Activation Required ';
                break;
            case 'users_status_'.KACANA_USER_STATUS_CREATE_BY_SYSTEM:
                $iconStatus = '<i class="fa fa-gears"></i> create by sys ';
                break;
            case 'users_role_'.KACANA_USER_ROLE_ADMIN:
                $iconStatus = '<i class="fa fa-user-secret"></i> Admin ';
                break;
            case 'users_role_'.KACANA_USER_ROLE_BUYER:
                $iconStatus = '<i class="fa fa-user"></i> Buyer ';
                break;
            case 'users_role_'.KACANA_USER_ROLE_PARTNER:
                $iconStatus = '<i class="fa fa-user"></i> Partner ';
                break;
            case 'orders_status_'.KACANA_ORDER_STATUS_NEW:
                $iconStatus = '<span class="label label-primary"><i class="fa fa-smile-o"></i> new</span>';
                break;
            case 'orders_status_'.KACANA_ORDER_STATUS_PROCESSING:
                $iconStatus = '<span class="label label-warning"><i class="fa fa-plane"></i> processing</span>';
                break;
            case 'orders_status_'.KACANA_ORDER_STATUS_CANCEL:
                $iconStatus = '<span class="label label-danger"><i class="fa fa-meh-o"></i> cancel</span>';
                break;
            case 'orders_status_'.KACANA_ORDER_STATUS_COMPLETE:
                $iconStatus = '<span class="label label-success"><i class="fa fa-chevron-down"></i> complete</span>';
                break;
            case 'products_boot_priority_'.KACANA_PRODUCT_BOOT_PRIORITY_LEVEL_0:
                $iconStatus = '<i class="fa fa-circle"></i> priority 0';
                break;
            case 'products_boot_priority_'.KACANA_PRODUCT_BOOT_PRIORITY_LEVEL_1:
                $iconStatus = '<i class="fa fa-rocket"></i> priority 1';
                break;
            case 'products_boot_priority_'.KACANA_PRODUCT_BOOT_PRIORITY_LEVEL_2:
                $iconStatus = '<i class="fa fa-rocket"></i> priority 2';
                break;
            case 'products_boot_priority_'.KACANA_PRODUCT_BOOT_PRIORITY_LEVEL_3:
                $iconStatus = '<i class="fa fa-rocket"></i> priority 3';
                break;
            case 'products_boot_priority_'.KACANA_PRODUCT_BOOT_PRIORITY_LEVEL_4:
                $iconStatus = '<i class="fa fa-rocket"></i> priority 4';
                break;
            case 'products_boot_priority_'.KACANA_PRODUCT_BOOT_PRIORITY_LEVEL_5:
                $iconStatus = '<i class="fa fa-rocket"></i> priority 5';
                break;
            default:
                $iconStatus = '<i class="fa fa-ban-circle"></i> Disabled ';
                break;
        }

        return $iconStatus;
    }

    static function getStatusDescriptionShip($status, $shipId){
        $desc = '';
        switch ($status){
            case KACANA_SHIP_STATUS_CANCEL:
                $desc = '<a target="_blank" href="https://5sao.ghn.vn/Tracking/ViewTracking/'.$shipId.'" class="label label-danger">đã huỷ</a>';
                break;
            case KACANA_SHIP_STATUS_STORE_TO_REDELIVERING:
                $desc = '<a target="_blank" href="https://5sao.ghn.vn/Tracking/ViewTracking/'.$shipId.'" class="label label-warning">Chờ giao lại</a>';
                break;
            case KACANA_SHIP_STATUS_STORING:
                $desc = '<a target="_blank" href="https://5sao.ghn.vn/Tracking/ViewTracking/'.$shipId.'" class="label label-info">đã lấy hàng</a>';
                break;
            case KACANA_SHIP_STATUS_DELIVERING:
                $desc = '<a target="_blank" href="https://5sao.ghn.vn/Tracking/ViewTracking/'.$shipId.'" class="label label-info">đang giao hàng</a>';
                break;
            case KACANA_SHIP_STATUS_RETURN:
                $desc = '<a target="_blank" href="https://5sao.ghn.vn/Tracking/ViewTracking/'.$shipId.'" class="label label-danger">Chờ trả hàng</a>';
                break;
            case KACANA_SHIP_STATUS_WAITING_TO_FINISH:
                $desc = '<a target="_blank" href="https://5sao.ghn.vn/Tracking/ViewTracking/'.$shipId.'" class="label label-success">Chờ Chuyển COD</a>';
                break;
            case KACANA_SHIP_STATUS_RETURNED:
                $desc = '<a target="_blank" href="https://5sao.ghn.vn/Tracking/ViewTracking/'.$shipId.'" class="label label-danger">đã hoàn trả hàng</a>';
                break;
            case KACANA_SHIP_STATUS_FINISH;
                $desc = '<a target="_blank" href="https://5sao.ghn.vn/Tracking/ViewTracking/'.$shipId.'" class="label label-success">hoàn thành</a>';
                break;
            default:
                $desc = '<a target="_blank" href="https://5sao.ghn.vn/Tracking/ViewTracking/'.$shipId.'" class="label label-primary">mới giao</a>';
        }
        return $desc;
    }

    static function getStatusDescriptionOrderDetail($orderDetail){

        $statusStr = '';

        if($orderDetail->order_service_status == NULL)
            $statusStr = '<label class="label label-primary" >chưa xử lý</label>';
        elseif($orderDetail->order_service_status == KACANA_ORDER_SERVICE_STATUS_ORDERED)
            $statusStr = '<label class="label label-info" >đã mua hàng</label>';
        elseif($orderDetail->order_service_status == KACANA_ORDER_SERVICE_STATUS_SOLD_OUT)
            $statusStr = '<label class="label label-danger" >hết hàng</label>';
        elseif($orderDetail->order_service_status == KACANA_ORDER_SERVICE_STATUS_SHIPPING)
        {
            $statusStr = '<a target="_blank"  class="label label-success">đã ship: '.$orderDetail->shipping_service_code.'</a><br><br><p>tình trạng ship hàng</p>';
            $shippingItem = $orderDetail->shipping;
            $statusStr .= self::getStatusDescriptionShip($shippingItem->status, $shippingItem->id);

        }

        return $statusStr;
    }
}
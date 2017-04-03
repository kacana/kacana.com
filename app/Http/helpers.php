<?php
/**
 * Created by PhpStorm.
 * User: chile
 * Date: 9/24/15
 * Time: 6:32 AM
 */
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
/*
 * show Image
 */
function showImage($image)
{
    return "<img width='50' height='50' src='". $image ."'/>";
}

function showProductImg($image, $id)
{
    return PRODUCT_IMAGE . $id . '/'.$image;
}

/*
 * format date
 */
function showDate($date, $is_date=0)
{
    if($is_date==0){
        return date('Y-m-d H:i', strtotime($date));
    }else{
        return date('Y-m-d', strtotime($date));
    }

}

/*
 * show edit, delete button
 */
function showActionButton($link_edit, $link_delete, $is_edit_popup=false, $is_delete=false)
{
    if($is_edit_popup == true){
        $str = "<a class='btn btn-default btn-xs' href='javascript:void(0)' onclick='".$link_edit."'><i class='fa fa-pencil'></i></a>";
    }else{
        $str = "<a class='btn btn-default btn-xs' href='".$link_edit."'><i class='fa fa-pencil'></i></a>";
    }

    if($is_delete == true) {
        $str ="<a href='javascript:void(0)' onclick='".$link_delete."'><i class='fa fa-remove'></i></a>";
    }
    return $str;
}

/*
 * show select status
 */
function showSelectStatus($id, $status, $active, $inactive){
    $str = "<div class='btn-group'>";
    $str .= "<a class='btn btn-default btn-xs dropdown-toggle' data-toggle='dropdown' id='status-btn-".$id."'>";
    if($status == 1){
        $str .= "<i class='glyphicon glyphicon-ok'></i> <span class='status'>Active</span> <span class='caret'></span></a>";
    }else{
        $str .= "<i class='glyphicon glyphicon-minus'></i> Inactive <span class='caret'></span></a>";
    }
    $str.= "<ul class='dropdown-menu'>";
    $str.= "<li><a href='#change_status' onclick='$active'><i class='glyphicon glyphicon-ok'></i>Active</a></li>";
    $str.= "<li><a href='#change_status' onclick='$inactive'><i class='glyphicon glyphicon-minus'></i>Inactive</a></li>";
    $str.= "</ul>";
    $str.= "</div>";
    return $str;
}

function showSelectStatusOrder($id, $status){
    $str = "<div class='btn-group' data-id='".$id."'>";

    $statusProperty = [];
    $statusProperty['text'] = 'Lỗi';
    $statusProperty['class'] = 'btn-danger';
    $statusProperty['icon'] = 'fa-info';

    switch ($status){
        case 0 :{
            $statusProperty['text'] = 'Khách đặt hàng';
            $statusProperty['class'] = 'btn-info';
            $statusProperty['icon'] = 'fa-arrow-right';
            break;
        }
        case 1 :{
            $statusProperty['text'] = 'đơn hàng đã confirm';
            $statusProperty['class'] = 'btn-primary';
            $statusProperty['icon'] = 'fa-arrow-circle-o-right';
            break;
        }
        case 2 :{
            $statusProperty['text'] = 'Đặt Hàng';
            $statusProperty['class'] = 'btn-primary';
            $statusProperty['icon'] = 'fa-check';
            break;
        }
        case 3:{
            $statusProperty['text'] = 'Về tới kho';
            $statusProperty['class'] = 'btn-primary';
            $statusProperty['icon'] = 'fa-check-circle';
            break;
        }
        case 12 :
        {
            $statusProperty['text'] = 'Chờ duyệt';
            $statusProperty['class'] = 'btn-primary';
            $statusProperty['icon'] = 'fa-send';
            break;
        }
        case 13 :{
            $statusProperty['text'] = 'Đã duyệt';
            $statusProperty['class'] = 'btn-primary';
            $statusProperty['icon'] = 'fa-send';
            break;
        }
        case 14 :{
            $statusProperty['text'] = 'Đang lấy hàng';
            $statusProperty['class'] = 'btn-primary';
            $statusProperty['icon'] = 'fa-send';
            break;
        }
        case 15 :{
            $statusProperty['text'] = 'Lấy không thành công';
            $statusProperty['class'] = 'btn-primary';
            $statusProperty['icon'] = 'fa-send';
            break;
        }
        case 16 :{
            $statusProperty['text'] = 'Đã lấy hàng';
            $statusProperty['class'] = 'btn-primary';
            $statusProperty['icon'] = 'fa-send';
            break;
        }
        case 17 :{
            $statusProperty['text'] = 'Đang phát hàng';
            $statusProperty['class'] = 'btn-primary';
            $statusProperty['icon'] = 'fa-send';
            break;
        }
        case 18 :{
            $statusProperty['text'] = 'Phát không thành công';
            $statusProperty['class'] = 'btn-primary';
            $statusProperty['icon'] = 'fa-send';
            break;
        }
        case 19 :{
            $statusProperty['text'] = 'Đã phát thành công';
            $statusProperty['class'] = 'btn-success';
            $statusProperty['icon'] = 'fa-smile-o';
            break;
        }
        case 20 :{
            $statusProperty['text'] = 'Chờ XN chuyển hoàn';
            $statusProperty['class'] = 'btn-danger';
            $statusProperty['icon'] = 'fa-send';
            break;
        }
        case 21 :{
            $statusProperty['text'] = 'Chuyển hoàn';
            $statusProperty['class'] = 'btn-danger';
            $statusProperty['icon'] = 'fa-send';
            break;
        }
        case 22 :{
            $statusProperty['text'] = 'Hủy đơn hàng';
            $statusProperty['class'] = 'btn-danger';
            $statusProperty['icon'] = 'fa-question';
            break;
        }
        case 46 :{
            $statusProperty['text'] = 'Phát lại lần 2';
            $statusProperty['class'] = 'btn-warning';
            $statusProperty['icon'] = 'fa-question';
            break;
        }
        case 32 :{
            $statusProperty['text'] = 'Chuyển hoàn thành công';
            $statusProperty['class'] = 'btn-warning';
            $statusProperty['icon'] = 'fa-question';
            break;
        }
        case 28 :{
            $statusProperty['text'] = 'Xác nhận chuyển hoàn';
            $statusProperty['class'] = 'btn-warning';
            $statusProperty['icon'] = 'fa-question';
            break;
        }
    }

    $str .= "<a class='btn ".$statusProperty['class']." btn-sm dropdown-toggle' data-toggle='dropdown'>";
    $str .= "<i class='fa ".$statusProperty['icon']."'></i> <span class='status'>".$statusProperty['text']."</span> <span class='caret'></span></a>";
    $str.= "<ul class='dropdown-menu'>";
    $str.= "<li><a href='#change_status' data-status='1' ><i class='fa fa-arrow-circle-o-right'></i>đơn hàng đã confirm</a></li>";
    $str.= "<li><a href='#change_status' data-status='1' ><i class='fa fa-question'></i>huỷ đơn hàng</a></li>";
    $str.= "</ul>";
    $str.= "</div>";

    return $str;
}

/*
 * get controller name base on Route::currentRouteAction()
 */
function getControllerName($route_action)
{
    $temp = explode( '@',$route_action);
    return $temp['0'];
}

function getActionName($route_action){
    $temp = explode( '@',$route_action);
    return $temp['1'];
}


function createResponseExc($e){
    $exc = new \Symfony\Component\Debug\ExceptionHandler;
    return $exc->createResponse($e);
}

/*
 * format money
 */
function formatMoney($number, $symbol=' đ')
{
    if($number)
    {
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number) {
                $number = $replaced;
            } else {
                break;
            }
        }
        if(!empty($symbol)) $number .= $symbol;
        return $number;
    }
    else
        return 0;


}

function generateBarcode($code, $width = 2, $height = 40){
    $codeEan = str_pad($code, 12, '0', STR_PAD_LEFT);
    $barcodeService = new DNS1D();
    return $barcodeService->getBarcodePNG($codeEan, "EAN13", $width, $height);
}

function generateQrcode($string, $width = 2.5, $height = 2.5){
    $barcodeService = new DNS2D();
    return $barcodeService->getBarcodePNG($string, "QRCODE", $width, $height);
}

function getProductIds($products){
    $productIds = array();

    foreach ($products as $product){
        array_push($productIds, $product->id);
    }

    return $productIds;
}

/*
 * urlProductDetail
 * @params: product item
 */
function urlProductDetail($item)
{
    if(!empty($item)){
        if(!empty($item->name)){
            return URL::to('san-pham/' . str_slug($item->name) . '--' . $item->id . '--' . $item->tag_id);
        }
    }else{
        return '';
    }
}

function urlTagProduct($item){
    if(!empty($item)){
        return URL::to($item['slug'] . '--' . $item['tag_id']);
    }
    else
        return '';
}

function urlTag($item){
    if(!empty($item)){
        return URL::to(str_slug($item->name) . '--' . $item->id);
    }
    else
        return '';
}

function limitString($str, $len = 100){
    $strLen = strlen($str);
    $re = $str;
    if($strLen <= $len){
        $re = $str;
    }else{
        $re = substr($str, 0, $len);
        $re .= "...";
    }
    return $re;
}

function fixHtml($html) {

    $htmlFixer = new Kacana\HtmlFixer();
    if(trim($html))
        return $htmlFixer->getFixedHtml($html);
    else
        return $html;
}

function isEmailAdress($email){

    if(!$email)
        return false;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        return true;
    } else {
        return false;
    }
}

function formatTimeAgo($date){
    $date = \Carbon\Carbon::parse($date);

    $humanTime = '';

    if($date->isToday())
    {
        if($date->diffInHours() < 1)
        {
            $humanTime = $date->diffInMinutes().' phút trước';
        }
        else{
            $humanTime = $date->format('H:i').' hôm nay';
        }
    }
    else if($date->isYesterday())
    {
        $humanTime = $date->format('H:i').' hôm qua';
    }
    else{
        $humanTime = $date->format('H:i'). ' ngày '.  $date->format('j/n/y');
    }

    return $humanTime;
}

function trim_text($input, $length, $ellipses = true, $strip_tag = true,$strip_style = true) {
    //strip tags, if desired
    if ($strip_tag) {
        $input = strip_tags($input, '<br>');
    }

    //strip tags, if desired
    if ($strip_style) {
        $input = preg_replace('/(<[^>]+) style=".*?"/i', '$1',$input);
    }

    if($length=='full')
    {

        $trimmed_text=$input;

    }
    else
    {
        //no need to trim, already shorter than trim length
        if (strlen($input) <= $length) {
            return $input;
        }

        //find last space within length
        $last_space = strrpos(substr($input, 0, $length), ' ');
        $trimmed_text = substr($input, 0, $last_space);

        //add ellipses (...)
        if ($ellipses) {
            $trimmed_text .= '...';
        }
    }

    return $trimmed_text;
}




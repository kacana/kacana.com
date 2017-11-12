<?php namespace App\services;

use App\Http\Requests\Request;
use App\models\facebookCommentModel;
use App\models\orderDetailModel;
use App\models\User;
use App\models\userBusinessSocialModel;
use App\models\userProductLikeModel;
use App\models\userSocialModel;
use Kacana\DataTables;
use Kacana\ViewGenerateHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\services\mailService;
use Auth;
use Carbon\Carbon;
/**
 * Class userService
 * @package App\services
 */
class userService extends baseService {

    /**
     * @var User
     */
    protected $_userModel;


    /**
     * @var userProductLikeModel
     */
    protected $_userProductLike;

    /**
     * @var userSocialModel
     */
    protected $_userSocial;

    /**
     * @var
     */
    protected $_userBusinessSocial;

    /**
     * userService constructor.
     */
    public function __construct()
    {
        $this->_userModel = new User();
        $this->_userProductLike = new userProductLikeModel();
        $this->_userSocial = new userSocialModel();
        $this->_userBusinessSocial = new userBusinessSocialModel();
    }

    /**
     * get User by email
     *
     * @param $email
     * @return bool
     */
    public function getUserByEmail($email){
        return ($this->_userModel->getUserByEmail($email))?$this->_userModel->getUserByEmail($email):false;
    }

    public function getUserById($id){
        return $this->_userModel->getUserById($id);
    }

    /**
     * create user
     *
     * @param $data
     * @return User
     */
    public function createUser($data){
        return $this->_userModel->createItem($data);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function updateItem($id, $data){
        return $this->_userModel->updateItem($id, $data);
    }

    /**
     * @param $request
     * @return array
     */
    public function generateUserTable($request){
        $userModel = new User();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'users.id', 'dt' => 0 ),
            array( 'db' => 'users.name', 'dt' => 1 ),
            array( 'db' => 'users.email', 'dt' => 2 ),
            array( 'db' => 'users.phone', 'dt' => 3 ),
            array( 'db' => 'users.role', 'dt' => 4 ),
            array( 'db' => 'users.status', 'dt' => 5 ),
            array( 'db' => 'users.created', 'dt' => 6 ),
            array( 'db' => 'users.updated_at', 'dt' => 7 ),
            array( 'db' => 'users.role AS role_value', 'dt' => 8 ),
        );

        $return = $userModel->generateUserTable($request, $columns);

        if(count($return['data'])) {
            $optionStatus = [KACANA_TAG_STATUS_ACTIVE ,KACANA_USER_STATUS_INACTIVE, KACANA_USER_STATUS_BLOCK, KACANA_USER_STATUS_CREATE_BY_SYSTEM];
            $optionRole = [KACANA_USER_ROLE_ADMIN, KACANA_USER_ROLE_BUYER, KACANA_USER_ROLE_PARTNER, KACANA_USER_ROLE_KCNER];

            foreach ($return['data'] as &$res) {
                $res->status = $viewHelper->dropdownView('users', $res->id, $res->status, 'status', $optionStatus);
                $res->role = $viewHelper->dropdownView('users', $res->id, $res->role, 'role', $optionRole);
            }
        }



        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    public function generateFacebookCommentTable($request){
        $facebookCommentModel = new facebookCommentModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'facebook_comments.id', 'dt' => 0 ),
            array( 'db' => 'facebook_comments.sender_name', 'dt' => 1 ),
            array( 'db' => 'facebook_comments.sender_id', 'dt' => 2 ),
            array( 'db' => 'facebook_comments.post_id', 'dt' => 3 ),
            array( 'db' => 'facebook_comments.item', 'dt' => 4 ),
            array( 'db' => 'facebook_comments.message', 'dt' => 5 ),
            array( 'db' => 'facebook_comments.created_at', 'dt' => 6 )
        );

        $return = $facebookCommentModel->generateUserTable($request, $columns);

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    /**
     * @param $request
     * @return array
     */
    public function reportDetailTableUser($request){
        $userModel = new User();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'users.id', 'dt' => 0 ),
            array( 'db' => 'users.name', 'dt' => 1 ),
            array( 'db' => 'users.email', 'dt' => 2 ),
            array( 'db' => 'users.phone', 'dt' => 3 ),
            array( 'db' => 'users.role', 'dt' => 4 ),
            array( 'db' => 'users.status', 'dt' => 5 ),
            array( 'db' => 'users.created', 'dt' => 6 ),
            array( 'db' => 'users.updated_at', 'dt' => 7 )
        );

        $return = $userModel->reportDetailTableUser($request, $columns);

        if(count($return['data'])) {
            $optionStatus = [KACANA_TAG_STATUS_ACTIVE ,KACANA_USER_STATUS_INACTIVE, KACANA_USER_STATUS_BLOCK, KACANA_USER_STATUS_CREATE_BY_SYSTEM];
            $optionRole = [KACANA_USER_ROLE_ADMIN, KACANA_USER_ROLE_BUYER];

            foreach ($return['data'] as &$res) {
                $res->status = $viewHelper->dropdownView('users', $res->id, $res->status, 'status', $optionStatus);
                $res->role = $viewHelper->dropdownView('users', $res->id, $res->role, 'role', $optionRole);
            }
        }



        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    /**
     * @param $id
     * @param $name
     * @param $phone
     * @return mixed
     */
    public function accountUpdateInformation($id, $name, $phone){

        $result['ok'] = 0;

        if(!Validator::make(['name' => $name], ['name' => 'required|min:2'])){
            $result['error_code'] = KACANA_AUTH_ERROR_BAD_NAME;
            $result['error_message'] = 'name không đúng định dạng !';
            return $result;
        }

        if(!Validator::make(['phone' => $phone], ['phone' => 'required|min:8'])){
            $result['error_code'] = KACANA_AUTH_SIGNUP_ERROR_BAD_PHONE;
            $result['error_message'] = 'phone không đúng định dạng !';
            return $result;
        }

        $result['ok'] = 1;
        $result['user']= $this->updateItem($id, ['name'=>$name, 'phone'=>$phone]);

        return $result;
    }

    /**
     * @param $user
     * @param $currentPassword
     * @param $password
     * @param $confirmPassword
     * @return mixed
     */
    public function accountUpdatePassword($user, $currentPassword, $password, $confirmPassword){

        $result['ok'] = 0;
        if(!Hash::check(md5($currentPassword),$user->password))
        {
            $result['error_code'] = KACANA_AUTH_LOGIN_ERROR_PASSWORD_WRONG;
            $result['error_message'] = 'vui lòng nhập đúng mật khẩu';
        }
        elseif($password != $confirmPassword){
            $result['error_code'] = KACANA_AUTH_SIGNUP_ERROR_PASSWORD_NOT_MATCH;
            $result['error_message'] = 'password và confirm password không giống nhau !';
        }
        else{
            $result['ok'] = 1;
            $result['user']= $this->updateItem($user->id, ['password'=>Hash::make(md5($password))]);
        }

        return $result;
    }

    /**
     * @param $userId
     * @param $productId
     * @return mixed
     */
    public function saveProductLike($userId, $productId, $url){
        $result['ok'] = 0;
        $data = $this->_userProductLike->createItem($userId, $productId, $url);
        if($result){
            $result['ok'] = 1;
            $result['data'] = $data;
            return $result;
        }

        return $result;
    }

    /**
     * @param $userId
     * @param $productId
     * @return mixed
     */
    public function removeProductLike($userId, $productId){
        $result['ok'] = 0;
        $data = $this->_userProductLike->removeItem($userId, $productId);
        if($result){
            $result['ok'] = 1;
            $result['data'] = $data;
            return $result;
        }

        return $result;
    }

    /**
     * @param $profiles
     * @param $accessToken
     * @return mixed
     */
    public function createUserFromFacebookProfile($profiles, $accessToken){

        $userService = new userService();
        $emailService = new mailService();
        $userSocialModel = new userSocialModel();
        $result['ok'] = 0;

        if(!$profiles)
        {
            $result['error_code'] = KACANA_AUTH_SIGNUP_BAD_FACEBOOK_PROFILE;
            $result['error_message'] = 'Chúng tôi không thể lấy thông tin từ facebook của bạn!';
            return $result;
        }

        $userSocial = $userSocialModel->getItemBySocialId($profiles['id'], KACANA_SOCIAL_TYPE_FACEBOOK);

        if($userSocial)
            $profiles['email'] = $userSocial->user->email;

        if(!isset($profiles['email']) || !$profiles['email'])
        {
            $result['error_code'] = KACANA_AUTH_SIGNUP_BAD_FACEBOOK_EMAIL;
            $result['error_message'] = 'Chúng tôi không thể lấy email từ facebook của bạn!';
            return $result;
        }

        if(!isset($profiles['name']))
        {
            $tempName = explode('@', $profiles['email']);
            $profiles['name'] = $tempName[0];
        }

        if(!isset($profiles['phone']))
            $profiles['phone'] = '';

        $data = array(
                    'password' => Hash::make(md5(time())),
                    'email' => $profiles['email'],
                    'name' => $profiles['name'],
                    'role' => KACANA_USER_ROLE_BUYER,
                    'status' => KACANA_USER_STATUS_ACTIVE,
                    'phone' => $profiles['phone'],
                    'image' => 'http://graph.facebook.com/'.$profiles['id'].'/picture?type=large'
                );

        $user = $this->getUserByEmail($profiles['email']);

        if($user){
            $user = $this->updateItem($user->id, ['status'=>KACANA_USER_STATUS_ACTIVE, 'image' => $data['image']]);
        }
        else{
            $user = $this->createUser($data);
            $emailService->sendEmailNewUser($profiles['email']);
        }

        $userSocial = $this->_userSocial->getItem($user->id, KACANA_SOCIAL_TYPE_FACEBOOK);

        if($userSocial)
        {
            $userSocial = $this->_userSocial->updateItem($user->id, KACANA_SOCIAL_TYPE_FACEBOOK, ['token'=>$accessToken]);
        }
        else
        {
            $userSocial = $this->_userSocial->createItem($user->id, KACANA_SOCIAL_TYPE_FACEBOOK, $accessToken, $profiles['id']);
        }

        if(Auth::loginUsingId($user->id, true))
        {
            $result['ok'] = 1;
            $result['user'] = $user;
            $result['userSocial'] = $userSocial;
        }
        else
        {
            $result['error_code'] = KACANA_AUTH_LOGIN_FAILED;
            $result['error_message'] = 'login failed';
        }

        return $result;

    }

    /**
     * @param $profiles
     * @param $accessToken
     * @return mixed
     */
    public function createUserFromGoogleProfile($profiles, $accessToken){

        $userService = new userService();
        $emailService = new mailService();
        $result['ok'] = 0;

        if(!$profiles)
        {
            $result['error_code'] = KACANA_AUTH_SIGNUP_BAD_GOOGLE_PROFILE;
            $result['error_message'] = 'google profile is empty';
            return $result;
        }

        if(!$profiles->email)
        {
            $result['error_code'] = KACANA_AUTH_SIGNUP_BAD_GOOGLE_EMAIL;
            $result['error_message'] = 'google email is empty';
            return $result;
        }

        if(!isset($profiles->name))
        {
            $result['error_code'] = KACANA_AUTH_SIGNUP_BAD_GOOGLE_NAME;
            $result['error_message'] = 'google first name is empty';
            return $result;
        }

        if(!isset($profiles->phone))
            $profiles->phone = '';

        $data = array(
            'password' => Hash::make(md5(time())),
            'email' => $profiles->email,
            'name' => $profiles->name,
            'role' => KACANA_USER_ROLE_BUYER,
            'status' => KACANA_USER_STATUS_ACTIVE,
            'phone' => $profiles->phone,
            'image' => $profiles->picture
        );

        $user = $this->getUserByEmail($profiles['email']);

        if($user){
            $user = $this->updateItem($user->id, ['status'=>KACANA_USER_STATUS_ACTIVE, 'image' => $data['image']]);
        }
        else{
            $user = $this->createUser($data);
            $emailService->sendEmailNewUser($profiles->email);
        }

        $userSocial = $this->_userSocial->getItem($user->id, KACANA_SOCIAL_TYPE_GOOGLE);

        if($userSocial)
        {
            $userSocial = $this->_userSocial->updateItem($user->id, KACANA_SOCIAL_TYPE_GOOGLE, ['token'=>$accessToken]);
        }
        else
        {
            $userSocial = $this->_userSocial->createItem($user->id, KACANA_SOCIAL_TYPE_GOOGLE, $accessToken, $profiles->id);
        }

        if(Auth::loginUsingId($user->id, true))
        {
            $result['ok'] = 1;
            $result['user'] = $user;
            $result['userSocial'] = $userSocial;
        }
        else
        {
            $result['error_code'] = KACANA_AUTH_LOGIN_FAILED;
            $result['error_message'] = 'login failed';
        }

        return $result;
    }

    /**
     * @param $email
     * @return bool|mixed
     * @throws \Exception
     */
    public function forgotPassword($email){
        $userModel = new User();
        $emailService = new mailService();
        if(!Validator::make(['email' => $email], ['email' => 'required|email'])){
            throw new \Exception('Email is not format');
        }

        $user = $this->getUserByEmail($email);
        $data = array();
        $data['temp_password'] = md5($user->password.time());
        $data['temp_password_expire'] = date('Y-m-d H:i:s',(strtotime('+1 day'))); // expire 1 day

        $user = $userModel->updateItem($user->id, $data);
        if($user)
        {
            $emailService->sendEmailForgotPassword($email);
            return $user;
        }

        return false;

    }

    /**
     * @param $email
     * @param $password
     * @return bool
     * @throws \Exception
     */
    public function checkResetPassword($email, $password){

        if(!Validator::make(['email' => $email], ['email' => 'required|email'])){
            throw new \Exception('Email is not format');
        }

        $user = $this->getUserByEmail($email);

        if($user->temp_password != $password)
            return false;

        if($user->temp_password_expire < date('Y-m-d H:i:s'))
            return false;

        return true;
    }

    /**
     * @param $user
     * @param $password
     * @param $confirmPassword
     * @return mixed
     */
    public function accountResetPassword($user, $password, $confirmPassword){

        $result['ok'] = 0;

        if($password != $confirmPassword){
            $result['error_code'] = KACANA_AUTH_SIGNUP_ERROR_PASSWORD_NOT_MATCH;
            $result['error_message'] = 'password và confirm password không giống nhau !';
        }
        else{
            $result['ok'] = 1;
            $result['user']= $this->updateItem($user->id, ['password'=>Hash::make(md5($password)), 'temp_password' => '', 'temp_password_expire' => '']);
            Auth::loginUsingId($user->id, true);
        }

        return $result;
    }

    /**
     * @param bool $duration
     * @return mixed
     */
    public function getCountLike($duration = false){
        return $this->_userProductLike->countLike($duration);
    }

    /**
     * @param bool $duration
     * @return mixed
     */
    public function getCountUser($duration = false){
        return $this->_userModel->countUser($duration);
    }

    /**
     * @param $dateRange
     * @param $type
     * @return mixed
     */
    public function getUserReport($dateRange, $type){
        if(!$dateRange)
        {
            $startTime = Carbon::now()->subDays(KACANA_REPORT_DURATION_DEFAULT);
            $endTime = Carbon::now();

        }else{
            $dateRange = explode(' - ', $dateRange);
            $startTime = $dateRange[0];
            $endTime = Carbon::createFromFormat('Y-m-d', $dateRange[1])->addDay();
        }


        return $this->_userModel->reportUser($startTime, $endTime, $type);
    }

    /**
     * @param $dateSelected
     * @param $type
     * @return mixed
     */
    public function getUserReportDetail($dateSelected, $type){


//            $dateSelected = Carbon::createFromFormat('Y-m-d', $dateSelected)->addDay();


        return $this->_userModel->reportUserDetail($dateSelected, $type);
    }


    /**
     * @param $dateRange
     * @param $type
     * @return mixed
     */
    public function getUserProductLikeReport($dateRange, $type){
        if(!$dateRange)
        {
            $startTime = Carbon::now()->subDays(KACANA_REPORT_DURATION_DEFAULT);
            $endTime = Carbon::now();

        }else{
            $dateRange = explode(' - ', $dateRange);
            $startTime = $dateRange[0];
            $endTime = Carbon::createFromFormat('Y-m-d', $dateRange[1])->addDay();
        }


        return $this->_userProductLike->reportUserProductLike($startTime, $endTime, $type);
    }

    /**
     * @param $profiles
     * @param $accessToken
     * @param $user
     * @return mixed
     */
    public function updateFacebookAccessToken($profiles, $accessToken, $user){
        $userSocialModel = new userSocialModel();
        $result['ok'] = 0;

        if(!$profiles)
        {
            $result['error_code'] = KACANA_AUTH_SIGNUP_BAD_FACEBOOK_PROFILE;
            $result['error_message'] = 'Chúng tôi không thể lấy thông tin từ facebook của bạn!';
            return $result;
        }

        $userSocial = $userSocialModel->getItemBySocialId($profiles['id'], KACANA_SOCIAL_TYPE_FACEBOOK);

        if($userSocial)
        {
            if($userSocial->user_id == $user->id){
                $items = [
                    'ref' => 1,
                    'token' => $accessToken,
                    'social_id' => $profiles['id']
                ];
                $userSocialModel->updateItem($user->id, KACANA_SOCIAL_TYPE_FACEBOOK, $items);
                $result['ok'] = 1;
            }
            else
            {
                $result['error_code'] = KACANA_AUTH_SIGNUP_EXISTS_SOCIAL_ACCOUNT;
                $result['error_message'] = 'Tài khoản facebook này đã được sử dụng vui lòng đăng nhập lại!';
                return $result;
            }

        }
        else{
            $userSocialModel->createItem($user->id, KACANA_SOCIAL_TYPE_FACEBOOK, $accessToken, $profiles['id']);
            $result['ok'] = 1;
        }
        return $result;
    }

    /**
     * @param $userId
     * @param int $type
     * @return mixed
     */
    public function getUserAccountBusinessSocial($userId, $type = KACANA_SOCIAL_TYPE_FACEBOOK){
        return $this->_userBusinessSocial->getItemsByUserId($userId, $type);
    }

    /**
     * @param $profiles
     * @param $accessToken
     * @param $user
     * @return mixed
     */
    public function createBusinessSocialAccount($profiles, $accessToken, $user){
        $userBusinessSocialModel = new userBusinessSocialModel();
        $userId = $user->id;
        $userSocials = $userBusinessSocialModel->getItemsByUserId($userId, KACANA_SOCIAL_TYPE_FACEBOOK);

        $result['ok'] = 0;

        if(!$profiles)
        {
            $result['error_code'] = KACANA_AUTH_SIGNUP_BAD_FACEBOOK_PROFILE;
            $result['error_message'] = 'Chúng tôi không thể lấy thông tin từ facebook của bạn!';
            return $result;
        }
        $data = array(
            'social_id' => $profiles['id'],
            'type' => KACANA_SOCIAL_TYPE_FACEBOOK,
            'user_id' => $userId,
            'email' => isset($profiles['email'])?$profiles['email']:'',
            'name' => $profiles['name'],
            'token' => $accessToken->getValue(),
            'token_expire' => $accessToken->getExpiresAt()->format('Y-m-d H:i:s'),
            'status' => KACANA_USER_BUSINESS_SOCIAL_STATUS_ACTIVE,
            'image' => 'http://graph.facebook.com/'.$profiles['id'].'/picture?type=large'
        );

        $userSocial = $userBusinessSocialModel->getItemBySocialId($profiles['id'], KACANA_SOCIAL_TYPE_FACEBOOK);

        if($userSocial)
        {
            if($userSocial->user_id != $userId)
            {
                $result['error_code'] = KACANA_AUTH_SIGNUP_EXISTS_SOCIAL_ACCOUNT;
                $result['error_message'] = 'tài khoản facebook này đã sử dụng trong hệ thống!';
                return $result;
            }
            elseif($userSocial->user_id == $userId &&
                (count($userSocials) > KACANA_USER_BUSINESS_ACCOUNT_LIMIT ||
                    ($userSocial->status != KACANA_USER_BUSINESS_SOCIAL_STATUS_ACTIVE && count($userSocials) == KACANA_USER_BUSINESS_ACCOUNT_LIMIT )
                ))
            {
                $result['error_code'] = KACANA_AUTH_LIMIT_BUSINESS_ACCOUNT;
                $result['error_message'] = 'Bạn chỉ có thể thêm '.KACANA_USER_BUSINESS_ACCOUNT_LIMIT.' tài khoản facebook! Vui lòng xoá một tài khoản để thêm vào hoặc liên hệ với admin 0906.054.206';
                return $result;
            }
            elseif ($userSocial->user_id == $userId && count($userSocials) <= KACANA_USER_BUSINESS_ACCOUNT_LIMIT)
            {
                $result['ok'] = 1;
                $result['data'] = $userBusinessSocialModel->updateItem($userId, KACANA_SOCIAL_TYPE_FACEBOOK, $data['social_id'], $data);

                return $result;
            }

        }

        if(count($userSocials) >= KACANA_USER_BUSINESS_ACCOUNT_LIMIT)
        {
            $result['error_code'] = KACANA_AUTH_LIMIT_BUSINESS_ACCOUNT;
            $result['error_message'] = 'Bạn chỉ có thể thêm '.KACANA_USER_BUSINESS_ACCOUNT_LIMIT.' tài khoản facebook! Vui lòng xoá một tài khoản để thêm vào hoặc liên hệ với admin 0906.054.206';
            return $result;
        }
        else
        {
            $result['ok'] = 1;
            $result['data'] = $userBusinessSocialModel->createItem($data);

            return $result;
        }
    }

    /**
     * @param $name
     * @param $socialId
     * @param $type
     * @param $userId
     * @return mixed
     */
    public function updateNameBusinessSocialAccount($name, $socialId, $type, $userId){
        $userBusinessSocialModel = new userBusinessSocialModel();
        return $userBusinessSocialModel->updateItem($userId, $type, $socialId, ['name' => $name]);
    }

    public function deleteBusinessSocialAccount($socialId, $type, $userId){
        return $this->_userBusinessSocial->updateItem($userId, $type, $socialId, ['status' => KACANA_USER_BUSINESS_SOCIAL_STATUS_INACTIVE]);
    }

    public function generateUserWaitingTransferTable($request){
        $userModel = new User();
        $datatables = new DataTables();
        $orderDetailModel = new orderDetailModel();
        $commissionService = new commissionService();

        $columns = array(
            array( 'db' => 'users.id', 'dt' => 0 ),
            array( 'db' => 'users.name', 'dt' => 1 ),
            array( 'db' => 'users.phone', 'dt' => 2 ),
            array( 'db' => 'orders.order_code AS product_quantity', 'dt' => 3 ),
            array( 'db' => 'orders.discount AS commission_total', 'dt' => 4 ),
            array( 'db' => 'users.created', 'dt' => 5 ),
            array( 'db' => 'users.updated_at', 'dt' => 6 )
        );

        $return = $userModel->generateUserWaitingTransferTable($request, $columns);

        if(count($return['data'])) {

            foreach ($return['data'] as &$res) {
                $validCommission = $orderDetailModel->validCommission($res->id);
                $trimCommission = $commissionService->trimCommission($validCommission);

                $res->product_quantity = count($validCommission);
                $res->commission_total = formatMoney($trimCommission['total']);
            }
        }

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }
}

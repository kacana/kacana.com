<?php namespace App\services;

use App\Http\Requests\Request;
use App\models\User;
use App\models\userProductLikeModel;
use App\models\userSocialModel;
use Kacana\DataTables;
use Kacana\ViewGenerateHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Auth;

/**
 * Class userService
 * @package App\services
 */
class userService {

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
     * userService constructor.
     */
    public function __construct()
    {
        $this->_userModel = new User();
        $this->_userProductLike = new userProductLikeModel();
        $this->_userSocial = new userSocialModel();
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
            array( 'db' => 'users.updated_at', 'dt' => 7 )
        );

        $return = $userModel->generateUserTable($request, $columns);

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
        $result['ok'] = 0;

        if(!$profiles)
        {
            $result['error_code'] = KACANA_AUTH_SIGNUP_BAD_FACEBOOK_PROFILE;
            $result['error_message'] = 'facebook profile is empty';
            return $result;
        }

        if(!isset($profiles['email']) || $profiles['email'])
        {
            $profiles['email'] = $profiles['id'].'@kacana.com';
        }

        if(!isset($profiles['first_name']))
        {
            $result['error_code'] = KACANA_AUTH_SIGNUP_BAD_FACEBOOK_NAME;
            $result['error_message'] = 'facebook first name is empty';
            return $result;
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
}

<?php namespace App\services;

use Illuminate\Support\Facades\Validator;
use Auth;
use App\services\userService;
use Illuminate\Support\Facades\Hash;

/**
 * Class authService
 * @package App\services
 */
class authService extends baseService {

    /**
     * @var \App\User|null
     */
    private $_user;

    /**
     * authService constructor.
     */
    public function __construct()
    {
        $this->_user = Auth::user();
    }

    /**
     * @param $email
     * @param $password
     * @param $role
     * @return mixed
     */
    public function login($email, $password, $role){
        if($this->_user)
            return false;

        $permissions = [KACANA_AUTH_ADMIN_NAME, KACANA_AUTH_CUS_NAME];

        $attempt = ['email' => $email, 'password' => md5($password), 'status' => KACANA_USER_STATUS_ACTIVE];

        if(in_array($role, $permissions))
            $attempt['role'] = $role;


        $result['ok'] = 0;

        if(!Validator::make(['email' => $email], ['email' => 'required|email'])){
            $result['error_code'] = KACANA_AUTH_ERROR_BAD_EMAIL;
            $result['error_message'] = 'email không đúng định dạng !';
            return $result;
        }

        $result['email'] = $email;

        if (Auth::attempt($attempt))
        {
            $result['ok'] = 1;
        }
        else
        {
            $userModel = new userService();
            $user = $userModel->getUserByEmail($email);
            if($user)
            {
                if(Hash::check(md5($password),$user->password))
                {
                    if($user->status != KACANA_USER_STATUS_ACTIVE)
                    {
                        $result['error_code'] = KACANA_AUTH_LOGIN_ERROR_ACCOUNT_BLOCK;
                        $result['error_message'] = 'account '.$email.' chưa được active hoặc bị khoá - vui lòng liên hệ với admin@kacana.com';
                    }
                    else{
                        $result['error_code'] = KACANA_AUTH_LOGIN_ERROR_NOT_PERMISSION;
                        $result['error_message'] = 'account '.$email.' không được phép truy cập vào page này';
                    }
                }
                else
                {
                    $result['error_code'] = KACANA_AUTH_LOGIN_ERROR_PASSWORD_WRONG;
                    $result['error_message'] = 'vui lòng nhập đúng mật khẩu';
                }
            }
            else
            {
                $result['error_code'] = KACANA_AUTH_LOGIN_ERROR_EMAIL_NOT_EXISTS;
                $result['error_message'] = 'email không tồn tại';
            }
        }

        return $result;
    }

    /**
     * @param $name
     * @param $email
     * @param $phone
     * @param $password
     * @param $confirmPassword
     * @param string $role
     * @return mixed
     */
    public function signup($name, $email, $phone, $password, $confirmPassword, $role = KACANA_AUTH_BUYER_NAME){
        $userService = new userService();

        $result['ok'] = 0;

        $permissions = [KACANA_AUTH_ADMIN_NAME, KACANA_AUTH_CUS_NAME, KACANA_AUTH_BUYER_NAME];

        if($this->_user)
            return false;

        if(!in_array($role, $permissions))
        {
            $result['error_code'] = KACANA_AUTH_SIGNUP_ERROR_NOT_EXISTS_PERMISSION;
            $result['error_message'] = 'Không tồn tại role '. $role . ' trong hệ thống !';
            return $result;
        }

        if($password != $confirmPassword){
            $result['error_code'] = KACANA_AUTH_SIGNUP_ERROR_PASSWORD_NOT_MATCH;
            $result['error_message'] = 'password và confirm password không giống nhau !';
            return $result;
        }

        if(!Validator::make(['email' => $email], ['email' => 'required|email'])){
            $result['error_code'] = KACANA_AUTH_ERROR_BAD_EMAIL;
            $result['error_message'] = 'email không đúng định dạng !';
            return $result;
        }

        if(!Validator::make(['name' => $name], ['name' => 'required|min:2'])){
            $result['error_code'] = KACANA_AUTH_ERROR_BAD_NAME;
            $result['error_message'] = 'name không đúng định dạng !';
            return $result;
        }
        //Validate phone

        $userModel = new userService();
        $user = $userModel->getUserByEmail($email);

        if($user && $user->status == KACANA_USER_STATUS_ACTIVE){
            $result['error_code'] = KACANA_AUTH_SIGNUP_ERROR_EMAIL_EXISTS;
            $result['error_message'] = 'email "'.$email.'" đã tồn tại trong hệ thống !';
            return $result;
        }
        else if($user && $user->status == KACANA_USER_STATUS_CREATE_BY_SYSTEM){
            // user is created when user buy product on system - so update it when they sign up
            $userData = array();
            $userData['name'] = $name;
            $userData['phone'] = $phone;
            $userData['password'] = Hash::make(md5($password));
            $userData['role'] = $role;
            $userData['status'] = KACANA_USER_STATUS_ACTIVE;
            $user = $userService->updateItem($user->id, $userData);

            $result['ok'] = 1;
            $result['data'] = $user;

            return $result;
        }
        else{
            // create new user
            $userData = array();
            $userData['name'] = $name;
            $userData['email'] = $email;
            $userData['phone'] = $phone;
            $userData['password'] = Hash::make(md5($password));
            $userData['role'] = $role;
            $userData['status'] = KACANA_USER_STATUS_ACTIVE;

            $user = $userService->createUser($userData);
            if($user)
            {
                $result['ok'] = 1;
                $result['data'] = $user;

                return $result;
            }
        }

    }

}
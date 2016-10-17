<?php namespace App\services;

use App\models\addressCityModel;
use App\models\addressCountryModel;
use App\models\addressReceiveModel;
use App\models\addressWardModel;
use App\models\addressDistrictModel;
use App\models\userAddressModel;
/**
 * Class shipService
 * @package App\services
 */
class addressService {

    /**
     * @var addressCountryModel
     */
    private $_countryModel;

    /**
     * @var addressCityModel
     */
    private $_cityModel;

    /**
     * @var addressDistrictModel
     */
    private $_districtModel;

    /**
     * @var addressWardModel
     */
    private $_wardModel;

    /**
     * @var addressReceiveModel
     */
    private $_receiveModel;

    /**
     * @var userAddressModel
     */
    private $_userAddressModel;

    /**
     * addressService constructor.
     */
    public function __construct()
    {
        $this->_countryModel = new addressCountryModel();
        $this->_cityModel = new addressCityModel();
        $this->_districtModel = new addressDistrictModel();
        $this->_wardModel = new addressWardModel();
        $this->_receiveModel = new addressReceiveModel();
        $this->_userAddressModel = new userAddressModel();
    }

    public function getListCountry(){
        return $this->_countryModel->getAll();
    }

    /**
     * get list city to show when order
     */
    public function getListCity(){
        return $this->_cityModel->getAll();
    }

    /**
     * get list district to show when order
     */
    public function getListDistrict(){
        return $this->_districtModel->getAll();
    }

    /**
     * get list ward to show when order
     */
    public function getListWard(){
        return $this->_wardModel->getAll();
    }

    /**
     * get city by id
     *
     * @param $id
     * @return bool|\Illuminate\Support\Collection|null|static
     */
    public function getCityById($id){
        return ($this->_cityModel->getById($id))?$this->_cityModel->getById($id):false;
    }

    /**
     * get district by id
     *
     * @param $id
     * @return bool|\Illuminate\Support\Collection|null|static
     */
    public function getDistrictById($id){
        return ($this->_districtModel->getById($id))?$this->_cityModel->getById($id):false;
    }

    /**
     * get ward by id
     *
     * @param $id
     * @return bool|\Illuminate\Support\Collection|null|static
     */
    public function getWardById($id){
        return ($this->_wardModel->getById($id))?$this->_wardModel->getById($id):false;
    }

    /**
     * @param $id
     * @return bool|\Illuminate\Support\Collection|null|static
     */
    public function getAddressReceiveById($id)
    {
        return ($this->_receiveModel->getById($id))?$this->_receiveModel->getById($id):false;
    }

    /**
     * Create new address receive for user
     *
     * @param $userId
     * @param $data
     * @param $default
     * @return addressReceiveModel
     */
    public function createUserAddress($userId, $data, $default = 0){
        $addressReceive = $this->_receiveModel->createItem($userId, $data, $default);
        return $addressReceive;

    }

    /**
     * @param $data
     * @return true
     */
    public function updateAddressReceive($data){
        $addressReceive = $this->_receiveModel->updateItem($data['id'], $data);
        return $addressReceive;
    }

    /**
     * @param $name
     * @param $type
     * @param $code
     * @return addressCityModel
     */
    public function createCity($name, $type, $code){
        return $this->_cityModel->createCity($name, $type, $code);
    }

    /**
     * @param $name
     * @param $cityId
     * @param $code
     * @param $type
     * @return addressDistrictModel
     */
    public function createDistrict($name, $cityId, $code, $type){
        return $this->_districtModel->createDistrict($name, $cityId, $code, $type);
    }

    /**
     * @param $userId
     * @param $id
     * @return true
     */
    public function makeAddressReceiveDefault($userId, $id){
        $this->_receiveModel->removeAllDefaultByUserId($userId);
        return $this->updateAddressReceive(['id'=>$id, 'default'=>true]);
    }

    /**
     * @param $userId
     * @param $id
     */
    public function deleteMyAddress($userId, $id){
        return $this->_receiveModel->deleteMyAddress($userId, $id);
    }

}

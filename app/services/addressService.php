<?php namespace App\services;

use App\models\addressCityModel;
use App\models\addressCountryModel;
use App\models\addressReceiveModel;
use App\models\addressWardModel;
use App\models\addressDistrictModel;
use App\models\userAddressModel;
use Kacana\DataTables;
use Kacana\ViewGenerateHelper;

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

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
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
     * @param $districtId
     * get list ward to show when order
     */
    public function getListWardByDistrictId($districtId){
        return $this->_wardModel->getItemsByDistrictId($districtId);
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

    public function createUserAddressForQuickOrder($userId, $phone, $default = 0){
        $addressReceive = $this->_receiveModel->createItemForQuickOrder($userId, $phone, $default);
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
     * @param $name
     * @param $cityId
     * @param $districtId
     * @param $code
     * @param $type
     * @return addressDistrictModel
     */
    public function createWard($name, $cityId, $districtId, $code, $type){
        return $this->_wardModel->createWard($name, $cityId, $districtId, $code, $type);
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

    /**
     * @param $search
     * @param $type
     * @param bool $userId
     * @return bool
     */
    public function searchAddressDelivery($search, $type, $userId = false){
        $items = false;

        if($type == 'name')
            $items = $this->_receiveModel->searchAddressDeliveryByName($search, $userId);
        else if($type == 'phone')
            $items = $this->_receiveModel->searchAddressDeliveryByPhone($search, $userId);
        if ($items)
            foreach ($items as &$item){
                $item->district = $item->district;
                $item->city = $item->city;
                $item->ward = $item->ward;
            }

        return $items;
    }

    /**
     * @param $code
     * @param $typeService
     * @return mixed
     */
    public function getDistrictByCode($code, $typeService){
        return $this->_districtModel->getDistrictByCode($code, $typeService);
    }

    /**
     * @param $code
     * @param $typeService
     * @return mixed
     */
    public function getCityByCode($code, $typeService){
        return $this->_cityModel->getCityByCode($code, $typeService);
    }

    /**
     * @param $request
     * @param $userId
     * @return array
     */
    public function generateCustomerTable($request, $userId){

        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'address_receive.name AS customer_name', 'dt' => 0 ),
            array( 'db' => 'address_receive.phone', 'dt' => 1 ),
            array( 'db' => 'address_receive.email', 'dt' => 2 ),
            array( 'db' => 'address_city.name', 'dt' => 3 ),
            array( 'db' => 'address_receive.created', 'dt' => 4 ),
            array( 'db' => 'address_receive.id', 'dt' => 5 )
        );

        $return = $this->_receiveModel->generateCustomerTable($request, $columns, $userId);

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    /**
     * @param $request
     * @param $userId
     * @return array
     */
    public function generateAddressReceiveByUserId($request, $userId){

        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'address_receive.id', 'dt' => 0 ),
            array( 'db' => 'address_receive.name AS customer_name', 'dt' => 1 ),
            array( 'db' => 'address_receive.phone', 'dt' => 2 ),
            array( 'db' => 'address_receive.email', 'dt' => 3 ),
            array( 'db' => 'address_receive.street', 'dt' => 4 ),
            array( 'db' => 'address_city.name AS city_name', 'dt' => 5 ),
            array( 'db' => 'address_district.name AS district_name', 'dt' => 6 ),
            array( 'db' => 'address_receive.created', 'dt' => 7 )
        );

        $return = $this->_receiveModel->generateAddressReceiveByUserId($request, $columns, $userId);

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    /**
     * @param $phone
     * @param bool $userId
     */
    public function getAddressReceiveByPhone($phone, $userId = false){
        return $this->_receiveModel->getAddressByPhone($phone, $userId);
    }
}

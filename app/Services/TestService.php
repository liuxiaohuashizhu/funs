<?php
/**
 *
 * @package   base
 * @filename  UserService.php
 * @license   http://www.kmf.com/ kmf license
 * @datetime  17/2/9 下午3:54
 */
namespace App\Services;

use App\Repositories\TestRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class TestService
 */
class TestService
{


    /**
     * UserService constructor.
     * @param UserRepository $userRepo
     */
    public function __construct()
    {
        $this->user_rep = new TestRepository();
    }


    /**
     * @param $id
     * @return bool
     */
    public function getInfoById($id){
        $ret = [];
        if(is_numeric($id) && $id>0){
            $ret = $this->user_rep->getInfoById($id);
        }
        return $ret;
    }

    /*
     * 将用户信息插入到本地
     * $passportUser passport下的用户信息
     */
    public function insertLocal($data){
        $ret = [];
        if(isset($data['user_name']) && isset($data['user_pwd'])){
            $ret  = $this->user_rep->insertLocal($data);
        }
        return $ret;
    }









}

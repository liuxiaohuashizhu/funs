<?php
/**
 *
 * @package   base
 * @filename  UserService.php
 * @license   http://www.kmf.com/ kmf license
 * @datetime  17/2/9 下午3:54
 */
namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class TestService
 */
class UserService
{


    /**
     * UserService constructor.
     * @param UserRepository $userRepo
     */
    public function __construct(
        UserRepository $rep
    )
    {
        $this->rep = $rep;
    }


    /**
     * @param $id
     * @return bool
     */
    public function getInfoById($id){
        $ret = [];
        if(is_numeric($id) && $id>0){
            $ret = $this->rep->getInfoById($id);
        }
        return $ret;
    }


    public function insertRecord($data){
        $ret = [];
        if(isset($data['user_name'])){
            $ret  = $this->rep->add($data);
        }
        return $ret;
    }

    public function getDataList($where){
        $ret = $this->rep->getDataList($where);
        return $ret;
    }









}

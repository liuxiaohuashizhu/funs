<?php
/**
 *
 * @package   User
 * @filename  UserRepository.php
 * @author    renyineng <renyineng@kmf.com>
 * @license   http://www.kmf.com/ kmf license
 * @datetime  17/2/20 上午10:36
 */
namespace App\Repositories;

use App\Models\test;

class TestRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new test();
    }

    public function getInfoById($id){
        $ret = [];
        if(is_numeric($id) && $id>0){
            $ret = $this->model->where('id',$id)->get();
        }
        return $ret;
    }

    /*
     * 将用户信息插入到本地
     */
    public function insertLocal($data){
        $arrInsert = array(
            "user_name" => $data['user_name'],
            "user_pwd" => $data['user_pwd'],
        );
        $ret = $this->model->create($arrInsert);
        return $ret;
    }
}
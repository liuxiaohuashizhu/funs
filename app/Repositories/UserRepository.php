<?php

namespace App\Repositories;

use App\Models\user;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new user();
    }

    public function getInfoById($id){
        $ret = [];
        if(is_numeric($id) && $id>0){
            $ret = $this->model->where('id',$id)->get();
        }
        return $ret;
    }

    /**
     * 根据条件获取数据
     * @param $where
     * @return mixed
     */
    public function getInfo($where){
        $ret = $this->model->where($where)->get();
        return $ret;
    }


    /**
     * @param $data
     * @return bool|static
     */
    public function add($data){
        if(empty($data)){
            return false;
        }
        $arrInsert = array(
            "user_name" => $data['user_name'],
            "tel" => $data['tel'],
        );
        $ret = $this->model->create($arrInsert);
        return $ret;
    }

    /**
     * 向表中写入唯一的一条数据
     * @param $data
     * @return bool
     */
    public function insertUniqueRecord($data){
        if(empty($data)){
            return false;
        }
        $record = $this->getInfo(['tel'=>$data['tel']]);
        if(!empty($record)){
            return false;
        }
        $judge = $this->add($data);
        return $judge;
    }
}
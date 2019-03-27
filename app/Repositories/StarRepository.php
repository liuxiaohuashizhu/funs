<?php

namespace App\Repositories;

use App\Models\star;

class StarRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new star();
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
            "star_name" => $data['star_name'],
            "star_nike_name" => $data['star_nike_name'],
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
        $record = $this->getInfo(['star_name'=>$data['star_name']]);
        if(!empty($record)){
            return false;
        }
        $judge = $this->add($data);
        return $judge;
    }
}
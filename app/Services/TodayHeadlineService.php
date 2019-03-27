<?php

namespace App\Services;

use App\Repositories\TodayHeadlineRepository;

/**
 * Class StarService
 */
class TodayHeadlineService
{

    protected  $rep;
    public function __construct(TodayHeadlineRepository $rep)
    {
        $this->rep = $rep;
    }
    public function getInfoById($id){
        $ret = [];
        if(is_numeric($id) && $id>0){
            $ret = $this->rep->getInfoById($id);
        }
        return $ret;
    }
    public function insertLocal($data){
        $ret  = $this->rep->add($data);
        return $ret;
    }

    public function getDataList($where){
        $ret = $this->rep->getDataList($where);
        return $ret;
    }
}

<?php

namespace App\Services;

use App\Repositories\StarRepository;

/**
 * Class StarService
 */
class StarService
{

    private $star_rep;
    public function __construct(StarRepository $star_rep)
    {
        $this->star_rep = $star_rep;
    }
    public function getInfoById($id){
        $ret = [];
        if(is_numeric($id) && $id>0){
            $ret = $this->star_rep->getInfoById($id);
        }
        return $ret;
    }
    public function insertRecord($data){
        $ret  = $this->star_rep->add($data);
        return $ret;
    }

    public function getDataList($where){
        $ret = $this->star_rep->getDataList($where);
        return $ret;
    }
}

<?php
/**
 * 用于参数校验
 */
namespace App\Common;




class Check
{

    /**
     * @param string $tel
     * @return bool
     */
    public function checkTel($tel = ''){
        if(strlen($tel) == 11){
            preg_match("/13[123569]{1}\d{8}|15[1235689]\d{8}|188\d{8}|188\d{8}/",$tel,$array);
            if(!empty($array)){
                return true;
            }
        }
        return false;
    }
}
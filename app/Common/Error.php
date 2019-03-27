<?php
/**
 * @func 错误信息类
 * @author liulile
 * @date 2016/09/23
 */
namespace App\Common;

class Error{
    CONST ERROR_NORMAL = 1;
    CONST ERROR_ERROR = 0;
    CONST ERROR_TEL_ILLEGAL = -1001;//手机号码非法
    CONST ERROR_PARAM_ILLEGAL = -1002;//参数错误
    CONST ERROR_CODE_ILLEGAL = -1003;//验证码错误
    CONST ERROR_CODE_EXPIRE = -1004;//验证码过期


}
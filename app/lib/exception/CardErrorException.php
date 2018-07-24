<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/7/23
 * Time: 23:17
 */

namespace app\lib\exception;


class CardErrorException extends BaseException
{
    public $code = 404;
    public $msg = '身份证信息与学生不符,请检查身份证照片是否正确且清晰';
    public $errorCode = 50002;
}
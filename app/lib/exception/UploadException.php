<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/7/24
 * Time: 10:35
 */

namespace app\lib\exception;


class UploadException extends BaseException
{
    public $code = 500 ;
    public $msg = '上传图片出错';
    public $errorCode = 60000;
}
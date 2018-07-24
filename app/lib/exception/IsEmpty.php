<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/7/22
 * Time: 21:40
 */

namespace app\lib\exception;


class IsEmpty extends BaseException
{
    public $code = 404;
    public $msg = '分类不存在';
    public $errorCode = 20000;
}
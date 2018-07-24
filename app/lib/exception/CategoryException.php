<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/6/11
 * Time: 19:19
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 404;
    public $msg = '指定类目不存在,请检查ID';
    public $errorCode = 20000;
}
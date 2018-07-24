<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/7/23
 * Time: 12:50
 */

namespace app\lib\exception;


class StuIDException extends BaseException
{
    public $code = 404;
    public $msg = '指定学生不存在,请检查stu_id';
    public $errorCode = 30001;
}
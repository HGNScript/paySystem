<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/7/23
 * Time: 19:41
 */

namespace app\lib\exception;


class CardException extends BaseException
{
    public $code = 404;
    public $msg = '需要检测的证件类型不存在,请检查card_flag';
    public $errorCode = 50000;
}
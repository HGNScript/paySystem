<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/6/10
 * Time: 12:01
 */

namespace app\api\validate;



use app\lib\exception\ParameterException;

class IDvalidate extends BaseValidate
{
    protected $rule = [
        'pid' => 'require|isPositiveInteger'
    ];

    protected $message = [
        'pid.isPositiveInteger' => 'id要求是正整数'
    ];


}
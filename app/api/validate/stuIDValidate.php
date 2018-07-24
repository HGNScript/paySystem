<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/7/23
 * Time: 11:48
 */

namespace app\api\validate;


class stuIDValidate extends BaseValidate
{
    protected $rule = [
        'stu_id' => 'require|isPositiveInteger'
    ];

    protected $message = [
        'stu_id.isPositiveInteger' => 'stu_id要求是正整数'
    ];
}
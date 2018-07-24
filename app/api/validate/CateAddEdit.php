<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/7/22
 * Time: 21:17
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class CateAddEdit extends BaseValidate
{
    protected $rule = [
        'cateData' => 'require|isArray'
    ];

    protected $message = [
        'cateData.isArray' => 'cateData只能为数组'
    ];
}
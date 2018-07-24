<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/6/10
 * Time: 13:51
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck(){
        //获取http参数
        //验证参数
         $request = Request::instance();
         $params = $request->param();

         $result = $this->check($params);
         if (!$result) {
             $error = $this->error;
                 throw new ParameterException([
                 'msg' => is_array($this->error) ? implode(
                     ';', $this->error) : $this->error,
             ]);
         } else {
             return true;
         }
    }

    //提交的值是正整数
    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        else{
            return false;
        }
    }

    //值不能为空
    protected  function inNotEmpty($value) {
        if (empty($value)) {
            return false;
        } else {
            return true;
        }
    }

    //验证电话号码
    protected function isMobile($value) {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //判断获取的值是否是数组
    protected function isArray($value){
        if (is_array($value)) {
            return true;

        } else {

            return false;
        }
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/7/23
 * Time: 10:47
 */

namespace app\api\model;


use app\lib\exception\StuIDException;
use think\Model;

class Student extends Model
{
    protected $autoWriteTimestamp = true;

    public function photo()
    {
        return $this->hasOne('Photo', 'stu_id', 'stu_id');
    }
    //

    /**
     * 获取所有学生数据
     * @return false|static[]
     */
    public static function getStuData(){

        $stuData = self::with(['photo'])->select();

        return $stuData;

    }

    /**
     * 获取指定的学生数据
     * @param $stu_id
     * @return array|false|\PDOStatement|string|Model
     */
    public static function getIDStuData($stu_id) {
        return self::with(['photo'])->where('stu_id', '=', $stu_id)->find();
    }


    /**
     * @return mixed
     * @param: {stu_id, stu_name, stu_number, stu_sex, stu_phone, stu_identity, class_name}
     * 【当 stu_id 不存在时添加数据，否则时编辑数据】
     */
    public static function addEditStu($stuData){

        if (isset($stuData['stu_id'])) {
            $result = self::update($stuData);

            $stu = self::get([$result['stu_id']]);
            if (!$stu) {
                throw new StuIDException([
                    "msg" => "指定学生数据不存在,请检查stu_id",
                ]);
            }

        } else {
            $result = self::create($stuData);
        }

        return $result;
    }


    /**
     * 根据身份证上的数据，获取学生数据
     * @param $stuInfo
     * @return array|false|\PDOStatement|string|Model
     */
    public static function checkStuInfo($stuInfo){
        $stu_name = $stuInfo[0];
        $stu_identity = $stuInfo[3];
        $stu_sex = $stuInfo[4];

        $result = self::where("stu_name", "=", $stu_name)
            ->where("stu_identity", "=", $stu_identity)
            ->where("stu_sex", "=", $stu_sex)
            ->where("stu_id", "=", $stuInfo['stu_id'])
            ->find();

        return $result;
    }

}
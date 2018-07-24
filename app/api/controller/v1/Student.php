<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/7/23
 * Time: 10:47
 */

namespace app\api\controller\v1;

use app\api\service\Card as cardService;
use app\api\model\Student as stuModel;
use app\api\service\Upload;
use app\api\validate\stuIDValidate;
use app\lib\exception\StuIDException;

class Student
{
    /**
     * 获取所有学生数据
     * @return \think\response\Json
     * @url:/stu/getStuData
     */
    public function getStuData()
    {
        $result = stuModel::getStuData();
        if (!$result) {
            throw new StuIDException([
                'msg' => '学生数据不存在',
            ]);
        }
        return json($result);
    }

    /**
     * 获取指定的学生数据
     * @param $id
     * @return \think\response\Json
     * @url:/stu/getIDStuData/:id
     */
    public function getIDStuData($stu_id)
    {
        $validate = new stuIDValidate();
        $validate->goCheck();

        $result = stuModel::getIDStuData($stu_id);

        if (!$result) {
            throw new StuIDException();
        }

        return json($result);
    }

    /**
     * @return mixed
     * @param: {stu_id, stu_name, stu_number, stu_sex, stu_phone, stu_identity, class_name}
     * 【当 stu_id 不存在时添加数据，否则时编辑数据】
     * @url:/stu/addEditStu
     */
    public function addEditStu()
    {
        $stuData = input('post.stuData/a');

        $result = stuModel::addEditStu($stuData);

        return json($result);
    }

    /**
     * 判断身份证是否合法
     * @return \think\response\Json
     *      * 【正面参数：
     * "cardInfo" : {
     * "log_id": 3756301097889342401,
     * "words_result_num": 5,
     * "words_result": [
     * {
     * "words": "难名白富美"
     * },
     * {
     * "words": "性别女民族汉"
     * },
     * {
     * "words": "出生「年8月2日"
     * },
     * {
     * "words": "住址"
     * },
     * {
     * "words": "公民身份号码"
     * },
     * {
     * "words": "@半岛晨报"
     * }
     * ]
     * },
     * "card_flag" : "card",
     * "flag" : "false"
     *
     * }
     * 】
     * 【反面参数：
     *  "cardInfo" : {
     * "log_id": 3756301097889342401,
     * "words_result_num": 5,
     * "words_result": [
     * {
     * "words": "中华人民共和国"
     * },
     * {
     * "words": "居民身份证"
     * },
     * {
     * "words": "签发机关乐安县公安局"
     * },
     * {
     * "words": "有效期限2012.0806-2017,0806"
     * }
     *
     *
     * ]
     * },
     * "card_flag" : "card",
     * "flag" : "false"
     * 】
     */
    public function checkCard()
    {

        $cardInfo = input('post.cardInfo/a');
        $card_flag = input('post.card_flag');
        $flag = input('post.flag');


        $result = (new cardService)->checkCardInfo($cardInfo, $card_flag, $flag);

        return json($result);

    }


    /**
     * 上传图片
     * @return \think\response\Json
     * Url:/Student/photoUpload
     */
    public function imgUpload($flag){

        $img = request()->file('images');

        $result = (new Upload())->uploadImg($img, $flag);

        return json($result);
    }

}
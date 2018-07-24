<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/7/23
 * Time: 16:17
 */

namespace app\api\service;

use app\api\model\Student;
use app\lib\exception\CardErrorException;
use app\lib\exception\CardException;
use think\Session;

class Card
{
    protected $oppositeInfo = [
        '中华人民共和国',
        '居民身份证',
        '签发机关',
        '有效期限'
    ];

    protected $frontInfo = [
        '姓名',
        '出生',
        '住址',
        '公民身份号码',
        '性别',
        '民族',
    ];

    /**
     * 判断校验的证件类型
     * @param $cardInfo
     * @param $card_falg
     * @return int
     */
    public function checkCardInfo($cardInfo, $card_flag, $flag) {

        if ($card_flag == "card") {
            $result = $this->checkCard($cardInfo, $flag);
        } else {
            throw new CardException();
        }

        return $result;
    }



    public function checkCard($cardInfo, $flag)
    {

        if ($flag == true) {
            $result = $this->checkFront($cardInfo);
        } else {
            $result = $this->checkOpposte($cardInfo);
        }

        return $result;


    }

    /**
     * 检测身份证反面是否符合规范
     * @param $cardInfo
     * @return bool
     */
    private function checkOpposte($cardInfo)
    {
        $result = $this->checkFormat($cardInfo, $this->oppositeInfo);

        if (!$result) {
            throw new CardErrorException([
                'msg' => "身份证照片不符合规范",
                '$errorCode' => "50001"
            ]);
        }

        return $result;
    }

    /**
     * 检测身份证正面是否符合规范，且数据正确
     * @param $cardInfo
     * @return bool
     */
    private function checkFront($cardInfo)
    {

        $cardInfo = $this->setSexNation($cardInfo);

        if ($cardInfo) {
            $result = $this->checkFormat($cardInfo, $this->frontInfo);

            if ($result) {
                $result = $this->checkStuInfo($cardInfo);

                if (!$result) {
                    throw new CardErrorException();
                } else {
                    $result = true;
                }
            } else {
                if (!$result) {
                    throw new CardErrorException([
                        'msg' => "身份证照片不符合规范",
                        '$errorCode' => "50001"
                    ]);
                }
            }

        } else {
            $result = false;
        }


        return $result;
    }

    /**
     * 判断身份证照片的格式是否正确
     * @param $cardInfo
     * @param $thisArr
     * @return bool
     */
    private function checkFormat($cardInfo, $thisArr)
    {
        $result = true;

        foreach ($cardInfo['words_result'] as $key => &$value) {

            $flag = strpos($value['words'], $thisArr[$key]);

            if ($flag === false) {
                $result = false;
            }

        }
        return $result;
    }

    /**
     *判断身份证照片的信息是否与学生一致
     * @param $cardInfo
     * @return array|false|\PDOStatement|string|\think\Model
     */
    private function checkStuInfo($cardInfo){

        $stuInfo = [];

        foreach ($this->frontInfo as $key => $value) {

            $str = $cardInfo['words_result'][$key]['words'];

            $nameIndex = mb_strpos($str, $value, null, 'utf-8') + mb_strlen($value, 'utf-8');

            $data = mb_substr($str, $nameIndex, mb_strlen($str), 'utf-8');

            array_push($stuInfo, $data);
        }

        $stu_id = Session::get('stu_id');

        $stuInfo['stu_id'] = $stu_id;


        $result = Student::checkStuInfo($stuInfo);

        return $result;

    }


    /**
     * 将传入的性别，民族按要求排序
     * @param $cardInfo
     * @return mixed
     */
    private function setSexNation($cardInfo)
    {
        $sexIndex = null;

        $str = $cardInfo['words_result'][1]['words'];

        if (strpos($str, "男")) {
            $sexIndex = mb_strpos($cardInfo['words_result'][1]['words'], "男", null, 'utf-8');
        } else {
            $sexIndex = mb_strpos($cardInfo['words_result'][1]['words'], "女", null, 'utf-8');
        }

        if ($sexIndex) {
            $sex = mb_substr($str, 0, $sexIndex + 1, 'utf-8');
            $nation = mb_substr($str, $sexIndex + 1, mb_strlen($str, "utf-8"), 'utf-8');

            unset($cardInfo['words_result'][1]);

            array_push($cardInfo['words_result'], ['words' => $sex]);
            array_push($cardInfo['words_result'], ['words' => $nation]);

            $cardInfo['words_result'] = array_values($cardInfo['words_result']);

            return $cardInfo;

        } else {
            $result = false;
        }
    }


}
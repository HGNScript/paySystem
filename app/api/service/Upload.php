<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/7/24
 * Time: 10:13
 */

namespace app\api\service;


use app\api\model\Student;
use app\lib\config\Url;
use app\lib\exception\UploadException;
use think\Session;

class Upload
{
    protected $url = Url::Localhost_Url;


    public function uploadImg($img, $flag) {

        // 移动到框架应用根目录/public/uploads/ 目录下

        if($img){
            $img_name = $this->setImageName($flag);

            $date = (date('Ymd',time()));

            if ($flag) {
                $folder_name = '/uploads/photo/';
            } else {
                $folder_name = '/uploads/card/';
            }


            $info = $img->validate(['ext'=>'jpg,png'])->move(ROOT_PATH . 'public' . $folder_name . $date, $img_name);

            if($info){
                //处理跨域请求
                header('content-type:application:json;charset=utf8');
                header('Access-Control-Allow-Origin:*');
                header('Access-Control-Allow-Methods:POST');
                header('Access-Control-Allow-Headers:x-requested-with,content-type');

                return $res = ['url' => $this->url . $folder_name . $date . '/' . iconv('gbk', 'utf-8', $info->getSaveName())];

            }else{
                throw new UploadException();
            }
        }
    }

    protected function setImageName($flag){
        $stu_id = Session::get('stu_id');
        $stu_name = Student::getIDStuData($stu_id);

        if ($flag) {
            $img_name = $stu_name['stu_name'] . '个人照ID' . $stu_id;
        } else {
            $img_name = $stu_name['stu_name'] . '身份证ID' . $stu_id;
        }

        $img_name = iconv('utf-8', 'gbk', $img_name);

        return $img_name;
    }
}
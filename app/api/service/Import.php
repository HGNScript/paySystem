<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/7/24
 * Time: 9:31
 */

namespace app\api\service;


use app\api\model\Cate;

class Import
{
    public static function cateImpot($file)
    {
        $info = $file->validate(['size' => 80000, 'ext' => 'xlsx,xls,csv'])->move(ROOT_PATH . 'public' . DS . 'cateExcel');
        if ($info) {
            $exclePath = $info->getSaveName();  //获取文件名
            $file_name = ROOT_PATH . 'public' . DS . 'excel' . DS . $exclePath;   //上传文件的地址
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            $obj_PHPExcel = $objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8
            $excel_array = $obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式
            array_shift($excel_array);  //删除第一个数组(标题);
            $data = [];

//            $len = sizeof($excel_array);

            foreach ($excel_array as $k => $v) {
                $n = db('class')->where('class_name', $v[1])->select();
                if (!$n) {
                    $data[$k]['class_grade'] = $v[0];
                    $data[$k]['class_name'] = $v[1];
                    $data[$k]['class_staffRoom'] = $v[2];
                    $data[$k]['class_specialty'] = $v[3];
                }
            }

//            $data = $this->arrOnly($data);
            $data = Cate::insertAllCate($data);

            $success = db('class')->insertAll($data);
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/7/22
 * Time: 12:58
 */

namespace app\api\controller\v1;

use app\api\model\Cate as cateModel;
use app\api\service\Import;
use app\api\validate\CateAddEdit;
use app\api\validate\IDvalidate;
use app\lib\exception\CategoryException;
use app\lib\exception\IsEmpty;

class Cate
{
    /**
     * 获取一级分类
     * @url: cate/:key
     * @return \think\response\Json
     * Client
     */
    public function getTopCate(){
        $topCate = cateModel::getTopCate();

        if (empty($topCate)) {
            throw new IsEmpty();
        }

        return json($topCate);
    }

    /**
     * 获取指定一级分类下的子分类
     * @param $pid
     * @url: cate/:key
     * @return \think\response\Json
     * Client
     */
    public function getSonCate($pid){
        $validate = new IDvalidate();
        $validate->goCheck();

        $result = cateModel::getSonCate($pid);

        if (!$result ) {
            throw new CategoryException();
        }
        return json($result);
    }

    /**
     * 添加或更新分类
     * @param [type: Array,$cate_name, $cate_price, $pid, $cate_starTime, $cate_entTime, $cate_id]
     * @url: cate/addEditCate
     */
    public function addEditCate(){
        (new CateAddEdit())->goCheck();

        $cateData = input('post.cateData/a');

        $result = cateModel::addEditCate($cateData);

        return $result;

    }

    /**
     * 根据提交的id单删除数据【如果删除的分类是一级分类，则将下一级分类提升为一级分类】
     * @return \think\response\Json
     * @url: cate/delCate
     */
    public function delCate(){
        $delID = input('post.delID/a');

        $result = cateModel::delID($delID);

        return json($result);
    }


    public function import() {
        vendor("PHPExcel.PHPExcel");
        $objPHPExcel = new \PHPExcel();
        $file = request()->file('excel');

        Import::cateImpot($file);

    }



}
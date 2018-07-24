<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/7/22
 * Time: 13:04
 */

namespace app\api\model;


use app\lib\exception\BaseException;
use app\lib\exception\CategoryException;
use think\Db;
use think\Exception;
use think\Model;

class Cate extends Model
{
    protected $autoWriteTimestamp = true;

    //获取一级分类
    public static function getTopCate(){

        $topCate = self::where('cate_pid', null)->select();

        return $topCate;
    }

    /**
     * 获取指定父级分类
     * @param $pid 父子分类
     * @return array|\PDOStatement|string|\think\Collection
     */
    public static function getSonCate($pid){
        $topCate = self::where('cate_pid', '=', $pid)->select();

        return $topCate;
    }

    /**
     * 添加或更新分类
     * @param [type: Array,$cate_name, $cate_price, $pid, $cate_starTime, $cate_entTime, $cate_id]
     */
    public static function addEditCate($cateData) {

        if (isset($cateData['cate_pid'])) {
            $pCate = self::get($cateData['cate_pid']);

            if (!$pCate) {
                throw new CategoryException([
                    "msg" => "指定上一级类目不存在,请检查cate_pid",
                ]);
            }
        }

        if (isset($cateData['cate_id'])) {
            $res = self::update($cateData);

            $cate = self::get([$res['cate_id']]);
            if (!$cate) {
                throw new CategoryException([
                    "msg" => "指定类目不存在,请检查cate_id",
                ]);
            }

        } else {
            $res = self::create($cateData);
        }

        return $res;
    }


    /**
     * @param $delID
     * @return int
     * @throws Exception
     * 根据提交的id单删除数据【如果删除的分类是一级分类，则将下一级分类提升为一级分类】
     */
    public static function delID($delID){

        Db::startTrans();

        try{
            $result = self::destroy($delID);

            foreach ($delID as $key => &$v) {
                $sonCate = self::where('cate_pid', $v)->update(['cate_pid' => null]);
            }

            Db::commit();

        } catch (\Exception $e) {
            throw new Exception($e);
        }


        return $result;
    }

    //导入项目数据
    public static function insertAllCate($data){
        return self::insert($data);
    }
}
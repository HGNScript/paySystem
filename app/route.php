<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;


##项目接口

//获取一级项目
Route::get('api/:version/cate/topCate','api/:version.Cate/getTopCate');

//获取指定一级分类下的子分类
Route::get('api/:version/cate/getSonCate/:pid','api/:version.Cate/getSonCate');

//添加分类【一级分类，或者子分类】【分类价格，上架时间，下架时间】
Route::post('api/:version/cate/addEditCate','api/:version.Cate/addEditCate');

//删除分类
Route::post('api/:version/cate/delCate','api/:version.Cate/delCate');

//导入分类
Route::post('api/:version/cate/import','api/:version.Cate/import');






##学生接口

//获取所有学生数据
Route::get('api/:version/stu/getStuData','api/:version.Student/getStuData');

//获取指定学生数据
Route::get('api/:version/stu/getIDStuData/:stu_id','api/:version.Student/getIDStuData');

//添加或编辑学生数据
Route::post('api/:version/stu/addEditStu','api/:version.Student/addEditStu');

//判断身份证是否合法
Route::post('api/:version/stu/checkCard','api/:version.Student/checkCard');

//上传个人照片或身份证照片
Route::post('api/:version/Student/imgUpload/:flag','api/:version.Student/imgUpload');


##缴费接口

//获取订所有缴费数据

//获取指定缴费数据[根据缴费ID, 或学生ID]

//根据筛选条件获取缴费数据

//获取所有缴费数据

//获取所有未支出缴费数据

//获取所有审核支出成功的缴费数据

//缴费付款接口










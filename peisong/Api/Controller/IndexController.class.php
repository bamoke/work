<?php
/*
 * @Author: Joy wang
 * @Date: 2020-10-08 07:54:16
 * @LastEditTime: 2021-04-17 22:18:16
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
namespace Api\Controller;

use Think\Controller;

class IndexController extends Controller
{
    protected $tableName = array(
        "类别" => "自定义类设置；where:自定义类型=配件类别",
        "产品" => "物品管理",
    );
    public function index()
    {
        $YB = new \Common\Common\YbApi();
        $productModel = D("Product");
        // 获取类别
        $cateList = $productModel->getCate($YB);

        // 选取前9个类别

        //获取产品

        $proInfo = $productModel->getList("", "1", "15");

        if ($proInfo === false) {
            $backData = array(
                "code" => 13001,
                "msg" => "系统错误",
            );
            $this->ajaxReturn($backData);
        }
        $backData = array(
            "code" => 200,
            "msg" => "success",
            "data" => array(
                "banner" => array(
                    array(
                        "id" => 1,
                        "img" => "http://www.bamoke.com/peisong/ps-banner.jpg",
                    ),
                ),
                "proList" => $proInfo["list"],
                "cateList" => array_slice($cateList, 1, 9),
                "pageInfo" => $proInfo["pageInfo"],
            ),
        );
        $this->ajaxReturn($backData);
    }
}

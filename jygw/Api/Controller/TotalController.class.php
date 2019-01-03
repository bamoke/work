<?php
namespace Api\Controller;
use Api\Common\Controller\BaseController;
use Think\Controller;
class TotalController extends Controller {
    public function index(){
        $firstList = M()->query("SELECT count(*) as total, f_uid as uid FROM `x_mycard_folder` WHERE 1 GROUP BY f_uid ORDER BY COUNT(*) desc limit 0,20");
        $secondList = M()->query("SELECT count(*) as total, s_uid as uid FROM `x_mycard_folder` WHERE 1 GROUP BY s_uid ORDER BY COUNT(*) desc limit 0,20");
        $newList =array_merge($firstList,$secondList);
        // array_unique($newList);
        $idArr = array();
        var_dump($newList);
        exit();
        foreach($newList as $key=>$val) {
            array_push($idArr,$val['uid']);
        }
        $newIdArr = array_unique($idArr);
        sort($newIdArr);
        $newIdStr = implode(",",$newIdArr);
        // array_unique($idArr);
        print_r($newIdStr);
/*         $test = array("2","23","984","10","23");
        array_unique($test);
        sort($test);
        print_r(array_unique($test)); */
/*         $backData = array(
            "code"  =>200,
            "msg"   =>"success",
            "data"  =>array(
                "cardInfo"      =>$friendList
            )
        );
        $this->ajaxReturn($backData); */
    }


}
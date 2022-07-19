<?php
namespace Admin\Controller;

use Admin\Common\AuthController;

class IndustryHangyeController extends AuthController
{

    public function upload()
    {

    }

    public function get_data()
    {
        $cate = I("get.cate");

        if($cate == 'all') {
            return $this->get_data_all();
        }

        $modelName = "IndustryHangye" . \ucfirst($cate);
        $model = D($modelName);

        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );
        $result = $model->getList($where);

        $backData = array(
            "code" => 200,
            "data" => array_merge(array("title" => ""), $result),
        );

        $this->ajaxReturn($backData);

    }


    // for big screen
    public function get_data_all(){
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );
        $zjzList = D("IndustryHangyeZjz")->getList($where);
        $zczList = D("IndustryHangyeZcz")->getList($where);
        $backData = array(
            "code" => 200,
            "data" => array(
                "zjz"=>$zjzList,
                "zcz"=>$zczList
            )
        );

        $this->ajaxReturn($backData);
    }

}

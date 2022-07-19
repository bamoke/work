<?php
namespace Admin\Controller;

use Admin\Common\AuthController;

class IndustryXdmyController extends AuthController
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
        $modelName = "IndustryXdmy" . \ucfirst($cate);
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

    public function get_data_all(){
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );
        $zjzList = D("IndustryXdmyZjz")->getList($where);
        $zczList = D("IndustryXdmyZcz")->getList($where);
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

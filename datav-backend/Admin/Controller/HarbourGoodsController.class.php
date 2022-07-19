<?php
namespace Admin\Controller;

use Admin\Common\AuthController;

class HarbourGoodsController extends AuthController
{


    public function upload()
    {

    }

    public function get_data()
    {
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
            "title"=>array("neq",'合计')
        );
        $model = D("HarbourGoods");
        $result = $model->getList($where);
        $backData = array(
            "code" => 200,
            "data" => $result,
        );

        $this->ajaxReturn($backData);
    }



}

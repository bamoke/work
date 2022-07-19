<?php
namespace Admin\Controller;

use Admin\Common\AuthController;

class FinanceController extends AuthController
{


    public function upload()
    {

    }

    public function get_data()
    {
        $cate = I("get.cate");
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );
        $model = D("Finance");
        if($cate == 'income') {
            $where["parent_name"] = array(
                array("eq","收入"),
                array("eq","税收收入"),
                "or"
            );
            $result = $model->getIncomeList($where);
        }else {
            $where["parent_name"] = $cate;
            $result = $model->getMainList($where);
        }

        
        


        $backData = array(
            "code" => 200,
            "data" => $result,
        );

        $this->ajaxReturn($backData);
    }



}

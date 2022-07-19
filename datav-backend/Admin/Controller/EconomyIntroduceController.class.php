<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

class EconomyIntroduceController extends AuthController {

    public function upload(){

        
    }


    public function get_data(){
        $where = array(
            "year"  =>$this->curYear,
            "month" =>$this->curMonth
        );

        $modelName = "EconomyIntroduce";
        $model = D($modelName);
        $resultData = $model->getData($where);

        $backData = array(
            "code"  =>200,
            "data"  =>array(
                "info" =>$resultData,
            )
        );

        $this->ajaxReturn($backData);

    }

    /*** */
    public function edit(){
        $this->display();
    }




}
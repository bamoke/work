<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 */

namespace Enadmin\Controller;


use Enadmin\Common\Controller\AuthController;

class ContactController extends AuthController
{


    public function index(){

        $info= M("Contact")->where('id=1')->find();
        $output['script'] = CONTROLLER_NAME."/main";
        $this->assign("output",$output);
        $this->assign("info",$info);
        $this->display();
    }

    public function save(){
        if(IS_POST){
            $model = M('Contact');
            $data = $_POST;
            $result = $model->where('id=1')->fetchSql(false)->save($data);
            if($result !==false){
                $backData = array(
                    "status"    =>1,
                    "msg"       =>"success"
                );
            }else {
                $backData = array(
                    "status"    =>0,
                    "msg"       =>"error"
                );
            }
            $this->ajaxReturn($backData);
        }
    }


}
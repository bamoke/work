<?php
namespace Admin\Controller;
use Admin\Common\Auth;
// use Think\Controller;
class IndexController extends Auth {
    public function index(){
        $backData = array(
            "code"  =>200,
            "msg"   =>'success',
            'data'  =>""
        );
        $this->ajaxReturn($backData);
    }

    /**
     * 
     */
    public function setting_get(){
        $info = M("Setting")->find("1");
        $backData = array(
            'code'      => 200,
            "msg"       => "ok",
            'data'      => array(
              "info"  =>$info
          )
          );
          $this->ajaxReturn($backData);
    }

    /**
     * 
     */
    public function setting_save(){
        $mainModel = M("Setting");
        $createResult = $mainModel->create($this->requestData);
        if(!$createResult) {
            $backData = array(
                "code"  =>13001,
                "msg"   =>'数据创建错误'

            );
            $this->ajaxReturn($backData);
        }
        $result = $mainModel->save();
        if($result !== false) {
            $backData = array(
                "code"  =>200,
                "msg"   =>'success'

            );
            $this->ajaxReturn($backData);
        }else {
            $backData = array(
                "code"  =>13001,
                "msg"   =>'数据保存错误'

            );
            $this->ajaxReturn($backData);
        }
    }
}
<?php
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-08-08 22:33:40 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-08-08 22:55:22
 */

namespace Manage\Common;
class AdminSession
{
    protected $Model;
    public function __construct(){
       $this->Model = M("AdminSession");
    }

    protected function update($token){
        $data = array(
            "expires_time"  =>time()+3600
        );
        $condition = array(
            "token" =>$token
        );
        $updateResult = $this->Model->where($condition)->data($data)->save();
    }
    /**
     * 检测是否登录
     * @return bool
     */
    protected function _checkLogin()
    {
        if (!isset($_SESSION['uid'])) {
            $backData = array(
                "code"  =>'11001',
                "msg"   =>'请登录后再操作'
            );
            $this->ajaxReturn($backData);
        } else {
            return true;
        }
    }

  

}
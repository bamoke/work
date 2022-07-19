<?php
/*
 * @Author: Joy wang
 * @Date: 2020-11-22 04:51:28
 * @LastEditTime: 2021-04-17 22:19:26
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
namespace Api\Controller;

use Api\Common\Auth;

class UnbindController extends Auth
{


    /**
     * 解除账号绑定
     */
    public function index()
    {
        $accountInfo = $this->accountInfo;

        $uid = $accountInfo["uid"];


        $condition = array(
            "id"=>$uid
        );

        $upData = array(
            "object_id"=>'',
            "phone" =>''
        );
        $result = M("User")
        ->where($condition)
        ->save($upData);

        if($result) {
            
            $backData = array(
                "code"   =>200,
                "msg"    =>"success"
            );
        }else {
            $backData = array(
                "code"   =>13001,
                "msg"    =>"系统错误"
            );
        }

        $this->ajaxReturn($backData);   
    }



}

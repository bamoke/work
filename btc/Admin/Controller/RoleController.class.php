<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2015/12/2
 * Time: 21:20
 */

namespace Admin\Controller;
use Think\Controller;

class RoleController extends Controller
{
    public function _initialize(){
        B('Admin\Behavior\LoginCheck');
    }
    public function index(){
        $pageVariable=array(
            'curPageName'=>'角色管理',
            'curJsModule'=>'role_index'
        );
        $roleData=M('role')->select();
        $emptyData='<tr><td colspan="3"><p class="noData">暂无数据</p> </td></tr>';
        $this->assign('pageVariable',$pageVariable);
        $this->assign('list',$roleData);
        $this->assign('emptyData',$emptyData);

        $this->display('list');
    }

    public function test(){
        $pageVariable=array(
            'curPageName'=>'测试',
            'curJsModule'=>'role_index'
        );
        $this->assign('pageVariable',$pageVariable);
        $this->display('test');
    }

    public function _empty(){
        echo "404";
    }
}
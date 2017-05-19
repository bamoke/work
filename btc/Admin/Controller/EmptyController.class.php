<?php
/**
 * 空控制器测试
 * User: joy.wangxiangyin
 * Date: 2015/12/2
 * Time: 9:58
 */

namespace Admin\Controller;
use Think\Controller;

class EmptyController extends Controller
{
    public function index(){
        echo "empty";
    }
}
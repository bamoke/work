<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2016/9/14
 * Time: 11:52
 */

namespace Business\Common\Controller;

use Think\Controller;

class AuthController extends Controller
{

    /**
     * 权限类初始化，检测用户是否登录以及访问权限,创建用户菜单
     */
    function _initialize()
    {
        if ($this->_checkLogin()) {
            $this->emptyHtml();
        };

    }

    /**
     * 检测是否登录
     * @return bool
     */
    protected function _checkLogin()
    {
        if (!isset($_SESSION['uid'])) {
            $this->redirect("Main/login");
            return false;
        } else {
            $where = array(
                "id"    =>session("bid")
            );
            $ossBase = C("OSS_BASE_URL")."/";
            $businessInfo = M("Welfare")
            ->field("id,title,start_date,end_date,create_time,CONCAT('$ossBase',thumb) as thumb")
            ->where($where)
            ->find();
            $this->assign("businessInfo",$businessInfo);
            return true;
        }
    }




    /*
     * 通过controller与action生成url
     * @param string controller
     * @param string action
     * @return string url
     * */
    private function _transformUrl($c,$a){
        return ucwords(strtolower($c))."/".strtolower($a);
    }

    /**
     * 空数据页面
     * @param string
    */
    protected function emptyHtml($tips="暂无相关数据！"){
        $emptyHtml = '<div class="m-empty"><img src="'.C("MODULE_ASSET").'/images/rest.png"><p class="tips">'.$tips.'</p></div>';
        $this->assign("emptyHtml",$emptyHtml);
    }


}
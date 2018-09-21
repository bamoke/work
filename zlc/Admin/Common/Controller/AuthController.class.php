<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2016/9/14
 * Time: 11:52
 */

namespace Admin\Common\Controller;

use Think\Controller;

class AuthController extends Controller
{
    protected $menu = array();

    /**
     * 权限类初始化，检测用户是否登录以及访问权限,创建用户菜单
     */
    function _initialize()
    {
        if ($this->_checkLogin()) {
            $this->menu = $this->_getMenu();
            $this->_create_menu($this->menu);
            if(strtolower(CONTROLLER_NAME) != 'content'){
                $this->_create_top($this->menu);
            }
            $this->emptyHtml();
            $this->_conten_nav();
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
            return true;
        }
    }


    /**
     * 获取后台菜单设置
     */
    private function _getMenu(){
        $model = M("AdminRule");
        $where = array(
            "status"  =>array("eq",1),
            "type"  =>1
        );
        $menu = $model->where($where)->order('sort asc,id')->select();
        return $menu;
    }
    /*
     * 创建主导航菜单
     * */
    protected function _create_menu($menu,$uid=null)
    {
        $navHtml = '';
        $curController =strtolower(CONTROLLER_NAME);
        foreach ($menu as $key=>$val){

            if(0 == $val['parent_id']){
                $url = $this->_get_first_url($val['id'],$menu);
                $className = $curController == strtolower($val['controller']) ? "cur" : "";
                $navHtml .= '<li class="'.$className.'"><a href="'.U($url).'"><i class="glyphicon glyphicon-'.$val['icon'].'"></i>'.$val['short_name'].'</a><i class="arrow"></i>  </li>';
            }
        }

        //输出头部信息
        $this->assign("nav",$navHtml);

    }

    /**
     * 创建内容管理菜单
     */
    private function _conten_nav(){
        $conditon = array(
            "pid"       =>0,
            "status"    =>1
        );
        
        $contentNav = M("ContentCate")->field("id,title")->where($conditon)->order("sort,id")->select();
        $html = "<li class='parent'><a href='javascript:'>内容管理<i class='glyphicon glyphicon-arrow-down'></i></a><ul class='child'>";
        foreach($contentNav as $k=>$v){
            $className = '';
            if(strtolower(CONTROLLER_NAME) == 'content' && $_GET['pid'] == $v['id']){
                $className = "cur";
            }
            $html .= '<li class="'.$className.'"><a href="'.U("Content/index/pid/".$v['id']).'">'.$v['title'].'</a><i class="arrow"></i>  </li>';
        }
        $html .= '</ul></li>';
        $this->assign("contentNav",$html);
    }

    /*
     * 生成头部内容,页面标题
     * @param
     * */
    private function _create_top($menu){
        $controllerName = strtolower(CONTROLLER_NAME);
        $bigTitle='';
        $pid='';
        foreach ($menu as $k=>$v){
            if($v['parent_id'] == 0 && strtolower($v['controller']) == $controllerName){
                $bigTitle = $v['title'];
                $pid = $v['id'];
                break;
            }
        }
        $childMenu = '';
        $pageName = "";
        foreach ($menu as $key=>$val){
            $className = "";
            $url = $this->_transformUrl($val['controller'],$val['action']);
            if($val['parent_id'] == $pid){
                if(strtolower(CONTROLLER_NAME."/".ACTION_NAME) == strtolower($val['controller']."/".$val["action"])){
                    $className = "cur";
                    $pageName = $val['title'];
                }
                $childMenu .='<li class="'.$className.'"><a href="'. U($url) .'">'. $val['title'] .'</a></li>';
            }
        }
        $mainTop['bigTitle'] =$bigTitle;
        $mainTop['childMenu'] =$childMenu;
        $this->assign("mainTop",$mainTop);
        $this->assign("pageName",$pageName);

    }

    /*
     * 获取导航的链接地址,默认获取第一个子菜单地址
     * @param int
     * @param array
     * @return string
     * */
    private function _get_first_url($pid,$menu){
        $url ='';
        if(is_array($menu)){
            foreach($menu as $k=>$v){
                if($pid == $v['parent_id']){
                    $url = $this->_transformUrl($v['controller'],$v['action']);
                    break;
                }
            }
        }
        return $url;
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
        $emptyHtml = '<div class="m-empty"><img src="'.MODULE_ASSET.'Images/rest.png"><p class="tips">'.$tips.'</p></div>';
        $this->assign("emptyHtml",$emptyHtml);
    }


}
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
        
        // 1.2 筛选出每个导航下的第一个子类，若有子类，通过第一个子类确定URL
        // navid
        $allCate = M("ContentCate")->field("id,pid,title,type,controller_name,action_name")->where(array('status'=>1))->order("sort,id")->select();
        $navCate = array();
        foreach ($allCate as $k=>$v){
            if($v['pid'] == 0){
                $newCate = array(
                    "id"    =>$v['id'],
                    "title" =>$v['title']
                );
                foreach($allCate as $key=>$val){

                    if($val['pid'] == $v['id']) {
                        $routeParam = array("navid"=>$v['id'],"cid"=>$val['id']);
                        switch($val['type']){
                            case "news":
                            $url = U("News/index",$routeParam);
                            break;
                            case "single":
                            $url = U("Single/index",$routeParam);
                            break;
                            case "download":
                            $url = U("Download/index",$routeParam);
                            break;
                            case "custom":
                            $url = U(ucfirst($val['controller_name'])."/".$val['action_name'],$routeParam);
                            break;                            
                        }
                        $newCate['url'] = $url;
                        break;
                    }
                }
                $navCate[] = $newCate;
            }
        }
        // 1.3 渲染html
        $html = "<li class='parent'><a href='javascript:'>内容管理<i class='glyphicon glyphicon-arrow-down'></i></a><ul class='child'>";
        foreach($navCate as $k=>$v){
            $className = '';
            if($_GET['navid'] == $v['id']){
                $className = "cur";
            }
            $html .= '<li class="'.$className.'"><a href="'.$v['url'].'">'.$v['title'].'</a><i class="arrow"></i>  </li>';
        }
        $html .= '</ul></li>';
        $this->assign("contentNav",$html);

        // 1.4 如果是内容管理模块,生产头部子导航信息
        if(isset($_GET['navid']) && isset($_GET['cid'])){
            $navid = I("get.navid");
            $curCid = I("get.cid");
            $childCate = array();
            foreach($allCate as $key=>$val){
                if($val['id'] == $navid) {
                    $bigTitle = $val['title'];
                }
                if($val['pid'] == $navid) {
                    $routeParam = array("navid"=>$navid,"cid"=>$val['id']);
                    switch($val['type']){
                        case "news":
                        $url = U("News/index",$routeParam);
                        break;
                        case "single":
                        $url = U("Single/index",$routeParam);
                        break;
                        case "download":
                        $url = U("Download/index",$routeParam);
                        break;
                        case "custom":
                        $url = U(ucfirst($val['controller_name'])."/".$val['action_name'],$routeParam);
                        break;                            
                    }
                    $newCate['url'] = $url;
                    $childCate[] = array(
                        "id"    =>$val['id'],
                        "title" =>$val['title'],
                        "url"   =>$url
                    );
                    continue;
                }
            }

            $childNavHtml = '';
            foreach($childCate as $k=>$v){
                // set class name
                if($curCid == $v["id"]) {
                    $className = 'cur';
                    $pageName = $v["title"];
                }else {
                    $className = '';
                }
                $childNavHtml .= '<li class="'.$className.'"><a href="'. $v['url'] .'">'. $v['title'] .'</a></li>';
            }
      
            $mainTop = array(
                "bigTitle"      =>$bigTitle,
                "childMenu"     =>$childNavHtml
            );
            $this->assign("mainTop",$mainTop);
        }
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
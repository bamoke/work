<?php
/**
 * User: joy.wangxiangyin
 * Date: 2018/8/6
 * Time: 23:52
 * back data code
 * 200 success
 * 1000*  request error
 * 1100*  login error
 * 1200*  auth error
 * 1300*  business logic error
 */

namespace Admin\Common;
use Think\Controller;
class Auth extends Controller
{

    /**
     * 1.初始化检测登录状态;
     * 2.检测访问权限 validate access promise
     */
    public $accessToken;
    protected $sessionModel;
    public $requestData;
    public $uid;
    public function _initialize(){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods:POST,GET'); 
        header("Access-Control-Allow-Headers:Content-type,accept,X-URL-PATH,x-access-token");
        if($_SERVER['REQUEST_METHOD'] != "OPTIONS") {
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $this->requestData = json_decode(file_get_contents("php://input"),true);
            }elseif($_SERVER['REQUEST_METHOD'] == "GET") {
                $this->requestData = $_GET;
            }
            $this->accessToken = $_SERVER["HTTP_X_ACCESS_TOKEN"];
            $this->sessionModel = M("AdminSession");
            $this->_checkLogin($this->accessToken);
            $this->uid = M("AdminSession")->where(array('token'=>$this->accessToken))->getField('uid');
        }else {
            header("HTTP/1.0 204 Not Content");
            // exit;
        }
    }

    /**
     * 检测是否登录
     * @return bool
     */
    protected function _checkLogin($token)
    {
        // If token is null;
        if(is_null($token)){
            $backData = array(
                "code"  =>11001,
                "msg"   =>"请先登录"
            );
            $this->ajaxReturn($backData);
        }else {

            // check time if expires
            $sessionCondistion = array(
                "token" =>$token
            );
            $expiresTime = $this->sessionModel->where($sessionCondistion)->fetchSql(false)->getField("expires_time");
            if(!$expiresTime || $expiresTime < time()){
                $backData = array(
                    "code"  =>11002,
                    "msg"   =>"登录状态已过期"
                );
                $this->ajaxReturn($backData);
            }
            // update expires
            $updateData = array(
                "expires_time"  =>time() + 3600
            );
            $updateResult = $this->sessionModel->where($sessionCondistion)->data($updateData)->save();
        }
    }


    /**
     * 返回json格式数据
     * @param  array
     */
    protected function ajaxReturn($data){
        exit(json_encode($data));
    }

    /*
     * 创建主导航菜单
     * */
    protected function _create_menu($uid=null)
    {

        $model = M("AdminRule");
        $where = array(
            "status"  =>array("eq",1),
            "type"  =>1
        );
        $menu = $model->where($where)->order('sort asc,id')->select();
        $navHtml = '';
        $curController =strtolower(CONTROLLER_NAME);
        foreach ($menu as $key=>$val){

            if(0 == $val['parent_id']){
                $url = $this->_get_first_url($val['id'],$menu);
                $className = $curController == strtolower($val['controller']) ? "cur" : "";
                $navHtml .= '<li class="'.$className.'"><a href="'.U($url).'"><i class="icon '.$val['icon'].'"></i>'.$val['short_name'].'</a><i class="arrow"></i>  </li>';
            }
        }

        //输出头部信息
        $this->_create_top($menu);
        $this->assign("nav",$navHtml);

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
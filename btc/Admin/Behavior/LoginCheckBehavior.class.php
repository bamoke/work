<?php
/* 权限管理,采用RBAC模式，基于角色访问控制，加入用户组功能
 * User: joy.wangxiangyin
 * Date: 2015/11/26
 * 1._get_role_list：获取角色集合，其中包括用户自身的角色及所属用户组的角色，
 * 2._get_auth_list：通过角色集合作为参数获取权限规则集合
 * 3.权限规则类型分为"menu、action、view",menu为菜单权限，action为页面当中的操作权限，view为页面中的元素显示权限
 * 4.按分类获取权限规则，通过session机制缓存


 */

namespace Admin\Behavior;
use Think\Controller;

class LoginCheckBehavior extends Controller
{
    public function run(&$params){
        //验证是否已经登录
        $this->checklogin();
    }

    /*
     * 登录检测
     * */
    private function checklogin(){
        if(!isset($_SESSION['uid'])){
            $this->error("请先登录",U('User/login'),5);
        }else {
            if(!session('?authid')){
                $roleList=$this->_get_role_list($_SESSION['uid']);
                $authList=$this->_get_auth_list($roleList);
            }

            $sideMenu=$this->_create_menu(session('authid.menu'));
            $this->assign('sideMenu',$sideMenu);
        }

    }



    /*
     * 获取角色集合
     * @param int 用户ID
     * */
    private function _get_role_list($uid){
        $roleList=array();

        //取得用户所属角色ID
        $userMap['id']=$uid;
        $aUser=M('admin')->where($userMap)->field('usergroup,role_id')->find();
        $aUserRole=array();
        if($aUser['role_id'] != '') {
            $aUserRole = explode(',', trim($aUser['role_id'], ','));
        }

        //取得用户所属用户组的角色ID
        $groupMap['id']=$aUser['usergroup'];
        $aGroup=M('admin_group')->where($groupMap)->field('role_id')->find();
        $aGroupRole=array();
        if($aGroup['role_id'] != '') {
            $aGroupRole = explode(',', trim($aGroup['role_id'], ','));
        }
        $roleList=array_merge($aUserRole,$aGroupRole);
        return array_unique($roleList);
    }

    /*
     * 获取权限规则集合
     * 通过角色与权限关联表，查找出所有权限规则ID
     * 对权限规则进行分类，（分类：menu、view、action）
     * session分类权限
     * @param array 角色集合
     *
     * */
    private function _get_auth_list ($roleList){
        $map['r.role_id']=array('IN',$roleList);
        $list=M('role_auth')
            ->alias('r')
            ->join('__AUTH__ as a ON a.id=r.auth_id')
            ->where($map)
            ->field('a.type,a.relation_id')
            ->select();
        $authId=array();
        $authId['menu']='';
        $authId['elemview']='';
        $authId['action']='';
        foreach ($list as $val){
            if($val['type'] == 'menu'){
                $authId['menu'] .=$val['relation_id'].',';
            }elseif($val['type'] == 'elemview'){
                $authId['elemview'] .=$val['relation_id'].',';
            }elseif($val['type'] == 'action'){
                $authId['action'] .=$val['relation_id'].',';
            }
        }
        session('authid.menu',trim($authId['menu'],','));
        session('authid.elemview',trim($authId['elemview'],','));
        session('authid.action',trim($authId['action'],','));
    }


/*********************************************************************************/

    /*
     * 获取当前用户菜单
     * @param str 菜单ID集合
    */
    private function _create_menu($menuList){
        $menu=array();
        $map=array(
          'a.type'=>'menu',
          'a.status'=>1,
          'a.id'=>array('IN',$menuList)
        );
//        $menuQuery=M('auth')->where($map)->field('relation_id')->select(false);
        //取得menu集合
        $menu=M('menu')
            ->alias('m')
            ->join('__AUTH__ as a ON m.id=a.relation_id')
            ->where($map)
            ->field('m.*')
            ->select();

        //返回menuDOM
        return $this->_menu_tree($menu,1,0);
    }

    /* 菜单树(？？应该是文件系统‘目录/文件’模式？？)
     * @param   array   当前权限下的菜单集合
     * @param   int     菜单层级，默认不超过2级
     * @param   int     菜单父id
     * */
    private function _menu_tree($list,$level,$pid){
        if($level > 2) return;
        $menuHtml='';
        foreach($list as $v){
            $url="";
            $curStyle='';
            $displayStyle='';
            $url=$this->firstToUpper($v['module']).'/'.$this->firstToUpper($v['controller']).'/'.$v['action'];
            $url=U($url);
            $curUrl=MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
            if(stripos($url,$curUrl)){
                $curStyle='cur';
                $displayStyle='style="display:block"';
            }
            if($pid == $v['parent_id']){
                if($level==1){
                    $menuHtml .='<div class="cateName"><i class="fa fa-user"></i>'.$v['title'].'</div>';
                }else {
                    $menuHtml .='<li class="'.$curStyle.'"><a data-test="'.$curUrl.'" href="'.$url.'">'.$v['title'].'</a></li>';
                }
                $curLevel=$level+1;
                $childMenuHtml =$this->_menu_tree($list,$curLevel,$v['id']);
                if($childMenuHtml !=''){
                    $menuHtml .='<ul class="childCateList level_'.$curLevel.'"' .$displayStyle.'>'.$childMenuHtml.'</ul>';
                }
            }
        }

        return $menuHtml;
    }


    /* 获取当前页面的显示元素权限
     * 1.找出当前页面元素显示权限
     * @param   array     权限规则集合
     * */
    private function _get_elemkey($authList){
        $curPage=strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME);
        $map=array(
            'a.type'=>'elemview',
            'a.status'=>1,
            'a.id'=>array('IN',$authList),
            'e.fileurl'=>$curPage
        );
        $aKey=M('elemview')
            ->alias('e')
            ->join('__AUTH__ as a ON e.id=a.relation_id')
            ->where($map)
            ->field('e.elemkey')
            ->select();
        foreach ($aKey as $v){
            $aElemKey[]=$v['elemkey'];
        }
        return $aElemKey;
    }

    //首字母转换为大写
    private function firstToUpper($str){
        if($str == '') return;
        $newStr=ucfirst(strtolower($str));
        return $newStr;
    }


}
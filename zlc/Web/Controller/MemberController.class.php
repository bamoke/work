<?php
namespace Web\Controller;
use Web\Common\WebController;
class MemberController extends WebController {

    protected function _checklogin(){
        if(!isset($_SESSION['webuid'])) {
            $this->redirect("Other/login");
        }
    }
    public function index(){
        $this->_checklogin();
        $uid = session("webuid");
        layout('Template/home');
        $accountInfo = M("Member")
        ->field("username,login_ip,FROM_UNIXTIME(reg_time) as regdate")
        ->where(array("id"=>$uid))
        ->find();

        $businessList = M("Business")
        ->where(array("uid"=>$uid))
        ->field("id,cid,title,status,FROM_UNIXTIME(create_time) as date")
        ->order("id desc")
        ->limit(5)
        ->select();
        $this->assign("business",$businessList);
        $this->assign("account",$accountInfo);
        $this->display();
    }
    

    public function business(){
        layout('Template/home');
        $this->_checklogin();
        $curModel = M("Business");
        $conditon = array(
            "uid" =>session("webuid")
        );
        $count = $curModel->where($conditon)->count();
        $Page = new \Think\Page($count,15);
        $Page->setConfig("next","下一页");
        $Page->setConfig("prev","上一页");
        $show = $Page->show();
        $mainList = $curModel
        ->field("id,cid,title,status,FROM_UNIXTIME(create_time) as date")
        ->where($conditon)
        ->limit($Page->firstRow.",".$Page->listRows)
        ->order("id desc")
        ->select();
        $this->assign("data",$mainList);
        $this->assign("page",$show);
        $this->display();
    }
    public function business_detail($id){
        layout('Template/home');
        $info = M("Business")
        ->field("*,FROM_UNIXTIME(create_time) as date")
        ->where("id=$id")
        ->find();
        $this->assign("info",$info);
        $this->display();
    }

    public function business_add(){
        layout('Template/home');
        $this->_checklogin();
        $uid = session("webuid");
        $accountInfo = M("Member")
        ->field("username,phone,contact")
        ->where(array("id"=>$uid))
        ->find();
        $cateInfo = M("ContentCate")->field("id,title")->where("pid=4")->select();
        $this->assign("cateInfo",$cateInfo);
        $this->assign("accountInfo",$accountInfo);
        $this->display();
    }
    public function business_edit($id){
        layout('Template/home');
        $this->_checklogin();
        $info = M("Business")
        ->where(array("id"=>$id))
        ->find();
        $cateInfo = M("ContentCate")->field("id,title")->where("pid=4")->select();
        $this->assign("cateInfo",$cateInfo);
        $this->assign("info",$info);
        $this->display();
    }

    public function reset(){
        layout('Template/home');
        $this->_checklogin();
        $this->display();
    }
        /*
         * 验证码
         * */
        public function code()
        {
            $config = array(
                'expire' => 600,//验证码过期时间
                'useImgBg' => false,//是否使用背景图,默认false;
                'useCurve' => false,//是否使用混淆曲线,默认true;
                'useNoise' => false,//是否添加杂点；默认true;
                'fontSize' => '16px',//设置字体大小，默认25px;
                'imageW' => '120px',//验证码宽度;
                'imageH' => '34px',//验证码高度;
                'length' => 4,//验证码字符数
                'bg' => array(190, 190, 190)
            );
            $verify = new \Think\Verify($config);
            $verify->entry();
        }
    

        /**
         * Action
         */
    // 发布商机
    public function business_save(){
        if(!isset($_SESSION['webuid'])) {
            $backData=array(
                'status'    =>false,
                'msg'       =>"请登录后操作",
            );
            return $this->ajaxReturn($backData); 
        }
        if(IS_POST){
            $curModel = M("Business");
            $createResult = $curModel->create();
            if(!$createResult) {
                $backData=array(
                    'status'    =>false,
                    'msg'       =>"数据错误",
                );
                return $this->ajaxReturn($backData);  
            }
            $curModel->uid = session("webuid");
            $curModel->create_time = time();
            $insertResult = $curModel->add();
            if($insertResult){
                $backData=array(
                    'status'    =>true,
                    'msg'       =>"发布成功，请等待审核",
                    "jump"      =>U("business")
                );
            }else {
                $backData=array(
                    'status'    =>false,
                    'msg'       =>"发布失败请稍后再试",
                );
            }
            $this->ajaxReturn($backData);
        }
    }    

    // 修改商机
    public function business_update($id){
            if(!isset($_SESSION['webuid'])) {
                $backData=array(
                    'status'    =>false,
                    'msg'       =>"请登录后操作",
                );
                return $this->ajaxReturn($backData); 
            }
            if(IS_POST){
                $curModel = M("Business");
                $createResult = $curModel->create();
                if(!$createResult) {
                    $backData=array(
                        'status'    =>false,
                        'msg'       =>"数据错误",
                    );
                    return $this->ajaxReturn($backData);  
                }
                $updateResult = $curModel->where("id=$id")->save();
                if($updateResult){
                    $backData=array(
                        'status'    =>true,
                        'msg'       =>"修改成功",
                        "jump"      =>U("business")
                    );
                }else {
                    $backData=array(
                        'status'    =>false,
                        'msg'       =>"修改失败请稍后再试",
                    );
                }
                $this->ajaxReturn($backData);
            }
        }  


        public function business_delone($id){
            $result = M("Business")->delete($id);
            if($result !== false){
                $backData=array(
                    'status'    =>true,
                    'msg'       =>"已删除",
                    "jump"      =>U("business")
                );
            }else {
                $backData=array(
                    'status'    =>false,
                    'msg'       =>"删除失败",
                );
            }
            $this->ajaxReturn($backData);
        }

        // 密码重置
        public function doreset(){
            if(!isset($_SESSION['webuid'])) {
                $backData=array(
                    'status'    =>false,
                    'msg'       =>"请登录后操作",
                );
                return $this->ajaxReturn($backData); 
            }
            $curModel = M("Member");
            $uid = session("webuid");
            $oldPassword = md5(I("post.oldpassword"));
            if(I('post.newpassword') !== I('post.newpassword2')) {
                $backData=array(
                    'status'    =>false,
                    'msg'       =>"两次密码不一致",
                );
                return $this->ajaxReturn($backData);                
            }
            $condition = array(
                "id"       =>$uid,
                "password"  =>$oldPassword
            );
            $result = $curModel->field("id")->where($condition)->find();
            if(!$result) {
                $backData=array(
                    'status'    =>false,
                    'msg'       =>"密码错误",
                );
                return $this->ajaxReturn($backData);                
            }
            $newPassword = md5(I("post.newpassword"));
            $updateData = array(
                "password"  =>$newPassword
            );
            $update = $curModel->where("id=$uid")->fetchSql(false)->save($updateData);
            if($update){
                $backData=array(
                'status'    =>true,
                'msg'       =>"修改成功",
                "jump"      =>U("index")
                );
            }else {
                $backData=array(
                    'status'    =>false,
                    'msg'       =>"修改失败",
                );
            }
            $this->ajaxReturn($backData);
        }

        public function logout(){
            session(null);
            $this->redirect("Index/index");
        }

    }
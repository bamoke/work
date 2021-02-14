<?php
namespace Adviser\Controller;
// use Think\Controller;
use Adviser\Common\Controller\AuthController;
class UserhomeController extends AuthController {
    public function profile(){
        $userWhere = array(
            "id"  =>session("uid")
        );
        $userFullInfo = M("AdviserUser")
        ->where($userWhere)    
        ->find();
        if($userFullInfo["avatar"]){
            $userFullInfo['avatarUrl'] = C("OSS_BASE_URL")."/".$userFullInfo["avatar"];
        }
        $this->assign("userFullInfo",$userFullInfo);
        $this->display();
    }

    /**
     * 修改密码
     */
    public function doreset(){
        $oldPassword = I("post.oldpassword");
        $where = array(
            "id"    =>session("uid")
        );
        if(I("post.newpassword") !== I("post.newpassword2")) {
            $backData=array(
                'status'    =>false,
                'msg'       =>"两次密码不一致"
            );
            $this->ajaxReturn($backData);  
        }
        $info = M("AdviserUser")
        ->where($where)
        ->find();
        if($info["password"] !== md5(I("post.oldpassword"))) {
            $backData=array(
                'status'    =>false,
                'msg'       =>"密码错误"
            );
            $this->ajaxReturn($backData);  
        }

        $updateData = array(
            "password"  => md5(I("post.newpassword"))
        );
        $updateResult = M("AdviserUser")
        ->where($where)
        ->data($updateData)
        ->fetchSql(false)
        ->save();
        if($updateResult !== false) {
            $backData=array(
                'status'    =>true,
                'msg'       =>"操作成功"
            );
            $this->ajaxReturn($backData);   
        }
        $backData=array(
            'status'    =>false,
            'msg'       =>"操作失败"
        );
        $this->ajaxReturn($backData);   
    }

    /**
     * 
     */
    public function doupdate(){
        if(!IS_POST) {
            $backData=array(
                'status'    =>false,
                'msg'       =>"非法操作",
            );
            $this->ajaxReturn($backData);  
        }

        $where = array(
            "id"  =>session("uid")
        );

        $model = M("AdviserUser");
        if(!$model->create()){
            $backData=array(
                'status'    =>false,
                'msg'       =>"数据错误",
            );
            $this->ajaxReturn($backData);  
        }

        //图片处理
        
        if($_FILES['img']['tmp_name']){
            $uploadResult = $this->uploadImg($_FILES['img']);
            if($uploadResult['code'] == 200){
                $model->avatar = $uploadResult['file'];
                if(isset($_POST['old_img']) && $_POST['old_img'] == '') {
                    $this->deleteImg($_POST['avatar']);
                }
            }else {
                $backData = array(
                    "status"  =>false,
                    "msg"   =>$uploadResult["msg"]
                  );
                  $this->ajaxReturn($backData); 
            }
    
        }else {
            if($_POST['old_img'] == ''){
                $backData = array(
                    "status"  =>false,
                    "msg"   =>"请选择头像图片"
                  );
                  $this->ajaxReturn($backData); 
            }
        }       

        $avatar = $model->avatar;
        // update
        $result = $model
        ->where($where)
        ->save();

        if($result !==  false) {
            session("realname",I("post.realname"));
            session("avatar",C("OSS_BASE_URL")."/".$avatar);
            $backData=array(
                'status'    =>true,
                'msg'       =>"操作成功"
            );
            $this->ajaxReturn($backData);  
        }

        $backData=array(
            'status'    =>false,
            'msg'       =>"更新错误"
        );
        $this->ajaxReturn($backData);  


    }

    protected function uploadImg($uploadObject){
        $folder = "avatar";
        $fileSaveName = md5(time().$this->uid);
        Vendor("AliOss.autoload");
        $OssClient = new \OSS\OssClient(C("OSS_ACCESS_ID"),C("OSS_ACCESS_KEY"),C("OSS_ENDPOINT"));
        
        $exts = array('jpg', 'gif', 'png', 'jpeg');
        $maxSize = 2097152;
        $curExts = end(explode(".",$uploadObject['name']));
        $curSize = $uploadObject['size'];
        $object = $folder.'/'.$fileSaveName.".".$curExts;
        // check extension and file size
        if(!in_array($curExts,$exts)) {
          $backData = array(
            "code" =>10009,
            "msg"   =>"图片只支持jpg,gif,png,jpeg文件格式"
          );
          return $backData;
        }
        if($curSize > $maxSize) {
          $backData = array(
            "code" =>10009,
            "msg"   =>"头像大小在2M以内"
          );
          return $backData;
        }
  
        try{
            $ossUpload = $OssClient->uploadFile(C('OSS_BUCKET'),$object,$uploadObject['tmp_name']);
            $getOssObjUrl = $ossUpload['info']['url'];
            $backData = array(
                "code"  =>200,
                "file"   =>$object
              );
              return $backData;

        }catch(OssException $e){
            // printf($e->getMessage() . "\n");
            $backData = array(
              "code"  =>10009,
              "msg"   =>$e->getMessage()
            );
            return $backData;
        }
    }

    protected function deleteImg($object){
        Vendor("AliOss.autoload");
        $OssClient = new \OSS\OssClient(C("OSS_ACCESS_ID"),C("OSS_ACCESS_KEY"),C("OSS_ENDPOINT"));
        try{
          $result = $OssClient->deleteObject(C("OSS_BUCKET"),$object);
          $backData = array(
            "code"  =>200,
            "msg"   =>"success"
          );
          return ($backData); 
         }catch(OssException $e){
        //   printf($e->getMessage() . "\n");
          $backData = array(
            "code"  =>13001,
            "msg"   =>$e->getMessage()
          );
          return ($backData); 
          }
    
      }
}
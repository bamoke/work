<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2017/6/26
 * Time: 16:59
 */

namespace Manage\Controller;
use Manage\Common\Controller\AuthController;

class CourseController extends AuthController
{

    public function wangtest(){
        $idArr = "";
        // $sectionCondition = array(
        //     "id"    =>array("in",$idArr)
        // );
        // $sectionList = M("CourseSection")
        // ->field("title,duration,source")
        // ->where($sectionCondition)
        // ->select();
        $courseCondition = array(
            "id"    =>array("in",$idArr)
        );
        $courseList = M("Course")
        ->where($courseCondition)
        ->select();
        $insertDataArr = array();
        foreach($courseList as $key=>$val){
            $insertDataArr[] = array(
                "class_id"  =>4,
                "teacher_id"    =>$val["teacher_id"],
                "type"      =>2,
                "source"    =>$val["source"],
                "duration"  =>$val["duration"],
                "title"     =>$val["title"],
                "period"    =>1,
                "description"   =>$val["description"],
                "thumb"     =>$val["thumb"]
            );
        }
        // var_dump($insertDataArr);
        // $insertAll = M("Course")->addAll($insertDataArr);
        // var_dump($insertAll);
    }

    public function wangtestsection(){
        $idArr = "73,19,35,69,59,55,60,48,47,57,51,56,58,49,52";
        $sectionCondition = array(
            "id"    =>array("in",$idArr)
        );
        $sectionList = M("CourseSection")
        ->field("title,duration,source")
        ->where($sectionCondition)
        ->select();
        $insertDataArr = array();
        foreach($sectionList as $key=>$val){
            $insertDataArr[] = array(
                "class_id"  =>4,
                "teacher_id"    =>2,
                "type"      =>2,
                "source"    =>$val["source"],
                "duration"  =>$val["duration"],
                "title"     =>$val["title"],
                "period"    =>1,
            );
        }
        // var_dump($insertDataArr);
        // $insertAll = M("Course")->addAll($insertDataArr);
        // var_dump($insertAll);
    }

    public function index(){
        $courseModel = M("Course");
        // paging set
        $thumbUrl = OSS_BASE_URL .'/images/';
        $where = array();
        $classId =I("get.classid");
        if(!empty($classId)) {
            $where["c.class_id"] = $classId;
        }
        $count = $courseModel->alias("c")->where($where)->count();
        $page = new \Think\Page($count,10);
        $page->setConfig('next','下一页');
        $page->setConfig('prev','上一页');
        $paging = $page->show();

        
        $courseList = $courseModel
            ->alias("c")
            ->field("c.id,c.title,IF(c.thumb != '',CONCAT('$thumbUrl',c.thumb),'') as thumb,c.type,IF(c.type=1,'专题系列','单节课程') as typename,c.recommend,c.sort,c.period,c.status,t.name as teacher_name,DATE(c.create_time) as create_date")
            ->join("__TEACHER__ as t on c.teacher_id = t.id")
            ->where($where)
            ->order('c.recommend desc,c.sort,c.id desc')
            ->limit($page->firstRow.",".$page->listRows)
            ->fetchSql(false)
            ->select();
        $outData = array(
            'list'      => $courseList,
            'paging'    => $paging,
            "script"    =>CONTROLLER_NAME.'/index'
        );
        $this->assign('output',$outData);
        $this->display();
    }

    /**
     * 修改课程排序
    */
    public function changeorder($id,$order_val){
        $updateData = array(
            'sort'  =>$order_val
        );
        $update = M("Course")->where("id=$id")->data($updateData)->save();
    }


    /***编辑 View**/
    public function edit($id){
        $thumbUrl = OSS_BASE_URL .'/images/';
        $teacherList = M("Teacher")->field('id,name')->where(array("status"=>1))->select();
        $courseInfo = M("Course")
        ->field("*,IF(thumb !='',CONCAT('$thumbUrl',thumb),'') as thumb,IF(type=1,'专题系列','单节课程') as typename")
        ->where(array('id'=>$id))
        ->find();
        $outData = array(
            'courseInfo'      => $courseInfo,
            "script"=>CONTROLLER_NAME."/main",
            "teacherList"  =>$teacherList,
        );
        $this->assign('output',$outData);
        $this->assign('pageName',"编辑课程");
        $this->display();

    }

    /***View add**/
    public function add(){
        // $cateModel = D('Category');
        // $cateList = $cateModel->getCate('course');
        $teacherList = M("Teacher")->field('id,name')->where(array("status"=>1))->select();
        // $orgList = M("Org")->field('id,name')->where(array("status"=>1))->select();
        $outData = array(
            "script"=>CONTROLLER_NAME."/main",
            "cateList"=>$cateList,
            "teacherList"=>$teacherList
            // "orgList"=>$orgList
        );
        $this->assign('output',$outData);
        $this->assign('pageName',"添加课程");
        $this->display();
    }



    /***action ****/
    public function a_update($id){
        if(IS_POST){
            $backData = array();
            $model = D("Course");
            $courseInfo = $model->field("thumb")->find($id);
            $result = $model->create($_POST);
            
            if($result){
                if($_FILES['thumb']['tmp_name']){
                    //图片处理
                    $upload_conf=$this->_upload_conf();
                    $upload = new \Think\Upload($upload_conf);
                    $uploadResult = $upload->uploadOne($_FILES["thumb"]);
                    if(!$uploadResult){
                        $backData['imgErr'] = $upload->getError();
                    }else {

                       // 上传阿里云OSS
                       Vendor("AliOss.autoload");
                       $OssClient = new \OSS\OssClient(C("OSS_ACCESS_ID"),C("OSS_ACCESS_KEY"),C("OSS_ENDPOINT"));
                       $object = 'images/'.$uploadResult['savename'];
                       $file = $upload_conf["rootPath"].$upload_conf["savePath"].$uploadResult['savename'];

                       try{
                           $ossUpload = $OssClient->uploadFile(C('OSS_BUCKET'),$object,$file);
                           $getOssObjUrl = $ossUpload['info']['url'];
                           if($getOssObjUrl){
                               unlink($file);
                           }
                       }catch(OssException $e){
                           printf($e->getMessage() . "\n");
                           return;
                       }
                       // 上传结束
                       $model->thumb = $uploadResult['savename'];
                       // 删除旧图片
                       if($courseInfo['thumb']){
                           try{
                            $OssClient->deleteObject(C("OSS_BUCKET"),"images/".$courseInfo['thumb']);
                           }catch(OssException $e){
                            printf($e->getMessage() . "\n");
                            return;
                            }
                        
                       }

                    }
                }else {
                    // 删除旧图片
                    if(isset($_POST['oldthumb']) && $_POST['oldthumb'] == ''){
                        $model->thumb = '';
                        // $this->del_thumb($id,'Course');
                    }
                }

                $update = $model->where('id='.$id)->fetchSql(false)->save();
                if($update !== false){
                    $backData['status'] = 1;
                    $backData['msg'] = $update === 0 ? "数据没有变动":"修改成功";
                    $backData['jump'] = U('index');
//                    $backData['data'] = $result;

                }else {
                    $backData['status'] = 0;
                    $backData['msg'] = $model->getError();
                }

            }else {
                $backData['status'] = 0;
                $backData['msg'] = $model->getError();
            }


            $this->ajaxReturn($backData);

        }
    }


    public function a_add(){
        if(IS_POST){
            $backData = array();
            if($_POST['isfree'] == 0 && !is_numeric($_POST['price'])){
                return  $this->ajaxReturn(array("status"=>0,"msg"=>"请填写合法的价格数值"));
            }
            $model = M("Course");
            $result = $model->create($_POST);

            if($_POST['isfree'] == 1) {
                $model->price= 0.00;
            }
            if($result){
                if($_FILES['thumb']['tmp_name']){
                    //图片处理
                    $upload_conf=$this->_upload_conf();
                    $upload = new \Think\Upload($upload_conf);
                    $uploadResult = $upload->uploadOne($_FILES["thumb"]);
                    if(!$uploadResult){
                        $backData['imgErr'] = $upload->getError();
                    }else{

                       // 上传阿里云OSS
                       Vendor("AliOss.autoload");
                       $OssClient = new \OSS\OssClient(C("OSS_ACCESS_ID"),C("OSS_ACCESS_KEY"),C("OSS_ENDPOINT"));
                       $object = 'images/'.$uploadResult['savename'];
                       $file = $upload_conf["rootPath"].$upload_conf["savePath"].$uploadResult['savename'];
                       try{
                           $ossUpload = $OssClient->uploadFile(C('OSS_BUCKET'),$object,$file);
                           $getOssObjUrl = $ossUpload['info']['url'];
                           if($getOssObjUrl){
                               unlink($file);
                           }
                       }catch(OssException $e){
                           printf($e->getMessage() . "\n");
                           return;
                       }
                       // 上传结束
                       $model->thumb = $uploadResult['savename'];

                    }
                }
                $add = $model->fetchSql(false)->add();
                if($add){
                    $backData['status'] = 1;
                    $backData['msg'] = "添加成功";
                    $backData['jump'] = U('index');

                }else {
                    $backData['status'] = 0;
                    $backData['msg'] = $model->getError();
                }

            }else {
                $backData['status'] = 0;
                $backData['msg'] = $model->getError();
            }


            $this->ajaxReturn($backData);

        }
    }

    /***章节列表***/
    function section($cid){
        $typeArr = array('',"图文","音频","视频");
        $sectionModel = M("CourseSection");
        $sectionList = $sectionModel->field('*')->where(array('course_id'=>$cid))->select();
        $courseInfo = M("Course")->field('id,title,status,thumb,description')->where(array('id'=>$cid))->find();
        $outData = array(
            "script"=>CONTROLLER_NAME."/main"
        );
        $this->assign('output',$outData);
        $this->assign('sectionList',$sectionList);
        $this->assign('courseInfo',$courseInfo);
        $this->assign('typeArr',$typeArr);
        $this->assign('pageName',"课程章节");
        $this->display();
    }

    /***添加课程章节***/
    public function addsection($cid){
        $outData = array(
            "script"=>CONTROLLER_NAME."/main"
        );
        $this->assign('output',$outData);
        $this->assign('pageName',"添加课程章节");
        $this->display();
    }

    /***修改课程章节***/
    public function updatesection($id){
        $sectionInfo = M("CourseSection")->where(array('id'=>$id))->find();
        $outData = array(
            "info"  =>$sectionInfo,
            "script"=>CONTROLLER_NAME."/main"
        );
        $this->assign('output',$outData);
        $this->assign('pageName',"编辑课程章节");
        $this->display();
    }



    /***保存课程章节内容***/
    function a_add_section(){
        if(IS_POST){
            $curModel = M("CourseSection");
            $result = $curModel->create($_POST);
            if($result){
                $model =M();
                $model->startTrans();
                $add = $curModel->add();
                $updateSql = "update __COURSE__ set `period` = period+1 where id=".I('post.course_id');
                $update = $model->execute($updateSql);
                if($add && $update){
                    $model->commit();
                    $backData['status'] = 1;
                    $backData['msg'] = "保存成功";
                    $backData['jump'] = U('section',array('cid'=>I('post.course_id')));
                }else {
                    $model->rollback();
                    $backData['status'] = 0;
                    $backData['msg'] = $curModel->getError();
                }
            }else {
                $backData['status'] = 0;
                $backData['msg'] = $curModel->getError();
            }

            $this->ajaxReturn($backData);
        }

    }




    /***保存章节修改***/
    public function a_update_section(){
        if(IS_POST){
            $backData = array();
            $model = M("CourseSection");
            $result = $model->create($_POST);
            if($result){
                if(!isset($_POST['isfree'])) {
                    $model->isfree = 0;
                }
                $update = $model->where('id='.$_POST['id'])->fetchSql(false)->save();
                if($update !== false){
                    $backData['status'] = 1;
                    $backData['msg'] = $update === 0 ? "数据没有变动":"修改成功";
                }else {
                    $backData['status'] = 0;
                    $backData['msg'] = $model->getError();
                }

            }else {
                $backData['status'] = 0;
                $backData['msg'] = $model->getError();
            }

            $this->ajaxReturn($backData);

        }
    }

    /****修改课程状态***/
    public function change_course_status($id,$status){
        $model = M("Course");
        $newData = array(
            "status"    =>$status
        );
        $result = $model->where(array('id'=>$id))->save($newData);
        if($result !== false ){
            $backData['status'] = 1;
            $backData['msg'] = "修改成功";
        }else {
            $backData['status'] = 0;
            $backData['msg'] = $model->getError();
        }
        $this->ajaxReturn($backData);
    }



    /**
     * Delete old thumbnail
     * @param   $id     int product ID
     * @param   $table  string
    */
    protected function del_thumb($id,$table='Columnist'){
        $dir = ROOT_DIR."/Upload/thumb/";
        $result = M($table)->field("thumb")->where('id='.$id)->find();
        @unlink($dir.$result['thumb']);
    }


    /**
     * set default upload config
    */
    private function _upload_conf (){
        return array(
            'maxSize' => 3145728,
            'rootPath' => ROOT_DIR.'/Upload/',
            'savePath' => 'thumb/',
            'saveName' => time().I("session.uid"),
            'exts' => array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub' => false,
            'subName' => date("Ym",time())
        );
    }



    /*=============================*/
}
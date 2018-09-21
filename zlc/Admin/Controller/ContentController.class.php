<?php
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-09-13 23:22:23 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-09-15 01:50:48
 */
namespace Admin\Controller;
use Admin\Common\Controller\AuthController;

class ContentController extends AuthController
{

    /**
     * all handel throw index dispatch;
     * @params 
     * @params
     * @params  action type add or edit
     */
    public function index($pid,$cid=null,$actype=null){

        // 1.Initialization data
        $parentInfo = M("ContentCate")->field("id,title")->where("id=$pid")->find();
        // ==
        $childCate = M("ContentCate")
        ->field("id,pid,title,type,controller_name,action_name")
        ->where(array('pid'=>$pid,'status'=>1))
        ->order("sort,id")
        ->select();
        
        // fetch current cate id
        if(is_null($cid)){
            $curCateInfo = $childCate[0];
            $curCateId = $childCate[0]["id"];
        }else {
            $curCateId = $cid;
        }
        $childNavHtml = '';
        foreach($childCate as $k=>$v){
            // set class name
            if($curCateId == $v["id"]) {
                $className = 'cur';
                $pageName = $v["title"];
                $curCateInfo = $v;
            }else {
                $className = '';
            }
            // set url
            if($v['type'] === 'custom'){
                // $url = U(ucfirst($v['controller_name'])."/".$v['action_name'])
            }else {
                // $url = U("index")
            }
            $url = U("index",array("pid"=>$pid,"cid"=>$v['id']));
            $childNavHtml .= '<li class="'.$className.'"><a href="'. $url .'">'. $v['title'] .'</a></li>';
        }
  
        $mainTop = array(
            "bigTitle"      =>$parentInfo['title'],
            "childMenu"     =>$childNavHtml
        );
        $this->assign("mainTop",$mainTop);
        $this->assign("pageName",$pageName);
        
        // 2. Actype validate
        if(is_null($actype)){
            // if is custom
            $this->manager($curCateInfo);
            exit();
        }
        switch($actype){
            case "add":
            $this->_addContent($curCateInfo);
            break;
            case "edit":
            $id = I("get.id/d");
            $this->_editContent($id,$curCateInfo);
            break;
            
        }
    }


    /***
     * VIEW
     * 编辑列表类型内容
     * @param int \ID
     * @param string 页面类型，对应模型
    ***/
    protected function _editContent($id,$cateInfo){
        $type = $cateInfo["type"];
        // 2. 依据类型分发操作
        if($type === 'custom'){
            // do something
            $controllerName = ucfirst($cateInfo['controller_name']);
            A($controllerName)->edit($id);
            $output['script'] = $controllerName."/main";
            $this->assign('output',$output);
            $this->display($controllerName."/edit");
            return;
        }       

        $tableName = ucfirst($type);
        $model = M($tableName);
        $where = array('id'=>$id);
        $data = $model->where($where)->find();

        $output['script'] = CONTROLLER_NAME."/main";
        $this->assign('data',$data);
        $this->assign('output',$output);
        $this->display($type."-edit");
    }

    /***
     * VIEW
     * 添加列表类型内容
     * @param 
     * @param string 页面类型，对应模型
     ***/
    protected function _addContent($cateInfo){
        $type = $cateInfo["type"];
        // 2. 依据类型分发操作
        $this->assign('cid',$cateInfo['id']);//将新增内容的category id (cid)输出
        if($type === 'custom'){
            $controllerName = ucfirst($cateInfo['controller_name']);
            $output['script'] = $controllerName."/main";
            $this->assign('output',$output);
            $this->display($controllerName."/add");
            return;
        }  
        $output['script'] = CONTROLLER_NAME."/main";
        $this->assign('output',$output);
        $this->display($cateInfo['type']."-add");
    }


    /***
     * ACTION
     * 修改保存
     * @param int \ID
     ***/
    public function update($pid,$id){
        if(IS_POST){
            $cateInfo = M("ContentCate")
            ->field("id,title,type,controller_name,action_name")
            ->where(array("id"=>I("post.cid")))
            ->find();

            $backData =array();
            $page_type = $cateInfo["type"];
            $tableName = ucfirst($page_type);

            // 2. 依据类型分发操作
            if($page_type === 'custom'){
                // 自定义栏目数据更新
                $controllerName = ucfirst($cateInfo["controller_name"]);
                $backData = A($controllerName)->do_update($id);
                if($backData['status']) {
                    $backData['jump'] = U('index',array('pid'=>$pid,'cid'=>I('post.cid')));
                }
                $this->ajaxReturn($backData);
                return;
            }

            $model = D($tableName);
            $info = $model->field('thumb')->where("id=$id")->find();
            
            $create = $model->create($_POST);
            if($create){
                $upload_conf=array(
                    'maxSize' => 3145728,
                    'rootPath' => ROOT.'/Uploads/',
                    'savePath' => 'thumb/',
                    'saveName' => time().I("session.uid"),
                    'exts' => array('jpg', 'gif', 'png', 'jpeg'),
                    'autoSub' => false,
                    'subName' => date("Ym",time())
                );
                //图片上传
                if($_FILES['thumb']['tmp_name']){
                    //图片处理
                    $upload = new \Think\Upload($upload_conf);
                    $uploadResult = $upload->uploadOne($_FILES['thumb']);
                    if(!$uploadResult){
                        $backData['status'] = 0;
                        $backData['msg'] = $upload->getError();
                        return $this->ajaxReturn($backData);
                    }else {
                        $model->thumb = $uploadResult['savename'];
                        //删除旧图片
                        if(isset($_POST['old_img']) && $_POST['old_img'] == ''){
                            unlink($upload_conf['rootPath'].$upload_conf['savePath'].$info['thumb']);
                        }
                    }

                }else {
                    // 删除旧图片
                    if(isset($_POST['old_img']) && $_POST['old_img'] == ''){
                        $model->thumb = '';
                        @unlink($upload_conf['rootPath'].$upload_conf['savePath'].$info['thumb']);
                    }
                }

                $result = $model->where('id='.$id)->fetchSql(false)->save();
                if($result !==false){
                    $backData['status'] =1;
                    $backData['msg'] = "修改成功";
                    $backData['sql'] = $model->getLast;
                    switch($page_type){
                        case 'single':
                        case 'news':
                            $backData['jump'] = U('index',array('pid'=>$pid,'cid'=>I('post.cid')));
                            break;
                    }
                }else {
                    $backData['status'] =0;
                    $backData['msg'] = $model->getError();
                }
            }else {
                $backData['status'] =0;
                $backData['msg'] = $model->getError();
            }

            $this->ajaxReturn($backData);
        }
    }

    /***
     * ACTION
     * 添加保存,必须有pid,作为返回跳转的路由参数
     * 提交的数据必须有cid,作为返回跳转的路由参数
     * @param string 对应模型
     ***/
    public function save($pid){
        if(IS_POST){
            // 1. 获取父类信息
            $cateInfo = M("ContentCate")
            ->field("id,title,type,controller_name,action_name")
            ->where(array("id"=>I("post.cid")))
            ->find();
            $type = $cateInfo["type"];
            // 2. 依据类型分发操作
            if($type === 'custom'){
                // 自定义栏目内容添加 
                $controllerName = ucfirst($cateInfo["controller_name"]);
                $backData = A($controllerName)->do_add();
                if($backData['status']) {
                    $backData['jump'] = U('index',array('pid'=>$pid,'cid'=>I('post.cid')));
                }
                $this->ajaxReturn($backData);
                return;
            }
            
            // 3.常规页面操作
            $tableName = ucfirst($type);
            $model = M($tableName);
            $result = $model->create($_POST);
            $backData = array();
            if(!$result) {
                $backData['status'] = 0;
                $backData['msg'] = $model->getError();
                return $this->ajaxReturn($backData);
            }

            //图片上传
            if($_FILES['thumb']['tmp_name']){
                //图片处理
                $upload_conf=array(
                    'maxSize' => 3145728,
                    'rootPath' => ROOT.'/Uploads/',
                    'savePath' => 'thumb/',
                    'saveName' => time().I("session.uid"),
                    'exts' => array('jpg', 'gif', 'png', 'jpeg'),
                    'autoSub' => false,
                    'subName' => date("Ym",time())
                );
                $upload = new \Think\Upload($upload_conf);
                $uploadResult = $upload->uploadOne($_FILES['thumb']);
                if(!$uploadResult){
                    $backData['status'] = 0;
                    $backData['msg'] = $upload->getError();
                    return $this->ajaxReturn($backData);
                }else {
                    $model->thumb = $uploadResult['savename'];
                }
            }else {
                if($type == 'banner'){
                    $backData['status'] = 0;
                    $backData['msg'] = "必须上传图片";
                    return $this->ajaxReturn($backData);
                }
            }
            if($type == "news") {
                $model->init_click = mt_rand(200,500);
            }
            if($model->add()){
                $backData['status'] = 1;
                $backData['msg'] = "保存成功";
                $backData['jump'] = U('index',array('pid'=>$pid,'cid'=>I('post.cid')));
            }else {
                $backData['status'] = 0;
                $backData['msg'] = $model->getError();
            }
            $this->ajaxReturn($backData);
        }
    }


    /***
     * del
     * @param int ID
     * @param string
    ***/
    public function del($id,$type){
        $tabelName = ucfirst($type);
        $model = M($tabelName);
        $info = $model->field('id,title,thumb')->where('id = '.$id)->find();
        $resutl = $model->where('id = '.$id)->delete();
        if($resutl){
            $backData['status'] = 1;
            $backData['msg'] = "删除成功";
            $backData['test'] = $info['thumb'];
            if(isset($info['thumb']) &&  $info['thumb']!= ''){
                $file = ROOT."/Uploads/thumb/".$info['thumb'];
                unlink($file);
            }
        }else {
            $backData['status'] = 0;
            $backData['msg'] = $model->getError();
        }
        $this->ajaxReturn($backData);
    }


    /***
     * Protected VIEW
     * 针对不同栏目类型，选择对应的模板
     * @param int cateID
    ***/
    protected function manager($cateInfo){
        $cid = $cateInfo["id"];
        $tableName = ucfirst($cateInfo['type']);
        $data =array();
        $this->assign('pageType',$cateInfo['type']);
        switch ($cateInfo['type']){
            case 'custom':
            $controllerName = ucfirst($cateInfo["controller_name"]);
            $actionName = $cateInfo["action_name"];
            var_dump($controllerName);
            A($controllerName)->$actionName();
            $this->display($controllerName."/".$actionName);
            break;
            case 'single':
                $dataModel = M($tableName);
                $data = $dataModel->where("cid=".$cid)->fetchSql(false)->find();
                // 单页面需要输出脚本
                $output['script'] = CONTROLLER_NAME."/main";
                $this->assign('output',$output);
                $this->assign('data',$data);
                $this->display($cateInfo['type']);
                break;
            case 'news':
                $dataModel = M($tableName);
                $count = $dataModel->where("cid=".$cid)->count();
                $Page = new \Think\Page($count,15);
                $Page->setConfig("next","下一页");
                $Page->setConfig("prev","上一页");
                $show = $Page->show();
                $data = $dataModel
                    ->where("cid=".$cid)
                    ->order('recommend desc,id desc')
                    ->limit($Page->firstRow.','.$Page->listRows)
                    ->select();
                $this->assign('page',$show);
                $this->assign('data',$data);
                $this->display($cateInfo['type']);
                break;
        }

        

    }



    /***
     * 删除图片
     * @param string 模型名称
     * @param int ID
    ***/

    protected function del_img($tableName,$id){
        $dir = ROOT."/Uploads/images/";
        $result = M($tableName)->field('img')->where('id='.$id)->find();
        @unlink($dir.$result['img']);
    }


    protected function _get_banner_position (){
        $navCate = M("Content_cate")->field("id,title")->where("is_nav = 1")->select();
        $position = array(
            '0'=>'首页'
        );
        foreach($navCate as $key=>$val){
            $position[$val['id']] =$val['title'];
        }
        return $position;
    }

    protected function _get_cate_array($array,$level =1,$pid =0,$max = 3){
        $cateArr = array();
        if($level > $max) return array();
        foreach ($array as $key=>$val){
            if($val['pid'] == $pid){
                $cateArr[] = array(
                    'id'        =>$val['id'],
                    'title'     =>$val['title'],
                    'type'      =>$val['page_type'],
                    'level'      =>$level,
                    'child'     =>$this->_get_cate_array($array,$level+1,$val['id'])
                );
            }
        }
        return $cateArr;
    }

    protected function _get_cate_html($array,$level =1,$pid =0,$max = 3){
        $cateHtml = '';
        if($level > $max) return '';
        foreach ($array as $key=>$val){
            if($val['pid'] == $pid){
                $child = $this->_get_cate_html($array,$level+1,$val['id']);


                if($child != ''){
                    $cateHtml = $cateHtml .'<li class="level-'.$level.'">+<span class="caption">'.$val['title']."</span>";
                    $cateHtml .= '<ul>'.$child."</ul>";
                }else {
                    $cateHtml = $cateHtml .'<li class="level-'.$level.'"> <a href="'.U("index",array('cid'=>$val['id'])).'" class="caption">'.$val['title']."</a>";
                }
                $cateHtml .= "</li>";
            }
        }
        return $cateHtml;
    }
}
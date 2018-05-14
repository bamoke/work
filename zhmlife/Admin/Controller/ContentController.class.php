<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2017/6/28
 * Time: 15:10
 */

namespace Admin\Controller;
use Admin\Common\Controller\AuthController;

class ContentController extends AuthController
{

    public function index($cid = null){
        $output['script'] = CONTROLLER_NAME."/main";
        $cate = M('Content_cate')->where('status = 1 and id !=2')->select();
        $cateHtml = $this->_get_cate_Html($cate);
        $this->assign('cateHtml',$cateHtml);
        $this->assign('output',$output);

        if($cid == null){
            $this->display();
        }else {
            $this->manager($cid);
        }

    }


    /***
     * VIEW
     * 编辑列表类型内容
     * @param int \ID
     * @param string 页面类型，对应模型
    ***/
    function edit($id,$type){
        $tableName = ucfirst($type);
        $model = M($tableName);
        $where = array('id'=>$id);
        $data = $model->where($where)->find();

        $output['script'] = CONTROLLER_NAME."/main";
        if(strtolower($type) == 'banner'){
            $this->assign('position',$this->_get_banner_position());
        }
        $this->assign('data',$data);
        $this->assign('output',$output);
        $this->display($type."-edit");
    }

    /***
     * VIEW
     * 添加列表类型内容
     * @param string 页面类型，对应模型
     ***/
    function add($type){
        $output['script'] = CONTROLLER_NAME."/main";
        if(strtolower($page_type) == 'banner'){
            $this->assign('position',$this->_get_banner_position());
        }
        $this->assign('output',$output);
        $this->display($type."-add");
    }


    /***
     * ACTION
     * 修改保存
     * @param int \ID
     ***/
    public function update($id){
        if(IS_POST){
            $backData =array();
            $page_type = I('post.type');
            $tableName = ucfirst($page_type);
            $model = D($tableName);
            $create = $model->create($_POST);
            if($create){

                //图片上传
                if($_FILES['img']['tmp_name']){
                    //图片处理
                    $upload_conf=array(
                        'maxSize' => 3145728,
                        'rootPath' => ROOT_DIR.'/Uploads/',
                        'savePath' => 'thumb/',
                        'saveName' => md5(time().I("session.uid")),
                        'exts' => array('jpg', 'gif', 'png', 'jpeg'),
                        'autoSub' => false,
                        'subName' => date("Ym",time())
                    );
                    $upload = new \Think\Upload($upload_conf);
                    $uploadResult = $upload->uploadOne($_FILES['img']);
                    if(!$uploadResult){
                        $backData['status'] = 0;
                        $backData['msg'] = $upload->getError();
                        return $this->ajaxReturn($backData);
                    }else {
                        $model->img = $uploadResult['savename'];
                    }

                }else {
                    // 删除旧图片
                    if(isset($_POST['old_img']) && $_POST['old_img'] == ''){
                        if($page_type == 'banner'){
                            $backData['status'] = 0;
                            $backData['msg'] = "必须上传图片";
                            return $this->ajaxReturn($backData);
                        }
                    }
                }

                $result = $model->where('id='.$id)->fetchSql(false)->save();
                if($result !==false){
                    $backData['status'] =1;
                    $backData['msg'] = "修改成功";
                    $backData['sql'] = $model->getLast;
                    switch($page_type){
                        case 'single':
                            $backData['jump'] = U('index');
                            break;
                        case 'banner':
                        case 'news':
                            $backData['jump'] = U('index',array('cid'=>I('post.cid')));
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
     * 添加保存
     * @param string 对应模型
     ***/
    public function save($type){
        if(IS_POST){
            $tableName = ucfirst($type);
            $model = M($tableName);
            $result = $model->create();
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
                    'saveName' => md5(time().I("session.uid")),
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
                }
            }else {
                if($type == 'banner'){
                    $backData['status'] = 0;
                    $backData['msg'] = "必须上传图片";
                    return $this->ajaxReturn($backData);
                }
            }
            
            $model->thumb = $uploadResult['savename'];
            if($model->add()){
                $backData['status'] = 1;
                $backData['msg'] = "保存成功";
                $backData['jump'] = U('index',array('cid'=>I('post.cid')));
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
    public function del($id,$page_type){
        $tabelName = ucfirst($page_type);
        $model = M($tabelName);
        $info = $model->where('id = '.$id)->find();
        $resutl = $model->where('id = '.$id)->delete();
        if($resutl){
            $backData['status'] = 1;
            $backData['msg'] = "删除成功";
            $backData['test'] = $info['img'];
            if(isset($info['img']) &&  $info['img']!= ''){
                $file = ROOT_DIR."/Upload/images/".$info['img'];
                unlink($file);
            }
        }else {
            $backData['status'] = 0;
            $backData['msg'] = $model->getError();
        }
        $this->ajaxReturn($backData);
    }


    /***
     * Protected
     * 针对不同栏目类型，选择对应的模板
     * @param int cateID
    ***/
    protected function manager($cid){
        $cateInfo = M('ContentCate')->field("type,title")->where("id=".$cid)->find();
        $tableName = ucfirst($cateInfo['type']);
        $dataModel = M($tableName);
        $data =array();
        switch ($cateInfo['type']){
            case 'single':
                $data = $dataModel->where("cid=".$cid)->fetchSql(false)->find();
                if(!$data){
                    $data= array(
                        "title"=>$cateInfo['title'],
                        "id"    =>$cid
                    );
                }
                break;
            case 'news':
                $count = $dataModel->where("cid=".$cid)->count();
                $Page = new \Think\Page($count,15);
                $Page->setConfig("next","下一页");
                $Page->setConfig("prev","上一页");
                $show = $Page->show();
                $data = $dataModel
                    ->order('recommend desc,id asc')
                    ->where("cid=".$cid)
                    ->order('recommend desc,id asc')
                    ->limit($Page->firstRow.','.$Page->listRows)
                    ->select();
                $this->assign('pageTitle',$cateInfo['title']);
                $this->assign('page',$show);
                break;
            case 'banner':
                $data = $dataModel->select();

                $this->assign('position',$this->_get_banner_position());
                $this->assign('pageTitle',$cateInfo['title']);
                break;
        }

        $this->assign('pageType',$cateInfo['type']);
        $this->assign('data',$data);
        $this->display($cateInfo['type']);
    }


    /**
     * 上传图片
     * @param object 文件对象;
     * @return \ArrayObject，成功返回图片信息数组，否则返回Upload对象;
    **/
    protected function _upload($File){
        $upload_conf=array(
            'maxSize' => 3145728,
            'rootPath' => ROOT_DIR.'/Upload/',
            'savePath' => 'images/',
            'saveName' => md5(time().I("session.uid")),
            'exts' => array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub' => false,
            'subName' => date("Ym",time())
        );
        $upload = new \Think\Upload($upload_conf);
        $uploadResult = $upload->uploadOne($File);
        if($uploadResult){
            return $uploadResult;
        }else {
            return $upload;
        }

    }

    /***
     * 删除图片
     * @param string 模型名称
     * @param int ID
    ***/

    protected function del_img($tableName,$id){
        $dir = ROOT_DIR."/Upload/images/";
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
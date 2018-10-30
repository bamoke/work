<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 */

namespace Enadmin\Controller;


use Enadmin\Common\Controller\AuthController;

class CategoryController extends AuthController
{


    public function index(){
        $info = M("ContentCate")->where("status=1")->order("sort,id")->select();
        $this->assign("info",$info);
        $output = array(
            "script"    =>CONTROLLER_NAME."/main",
            "tree"      =>$this->_createTree($info)
        );
        $this->assign("output",$output);
        $this->display('cate');
    }

    // create or modify

    public function main(){
        if(isset($_GET['id'])){
            $id= I("get.id/d");
            $info = M('ContentCate')->where("id=$id")->find();
            $actype = "edit";
        }else if(isset($_GET['pid'])){
            $info=array(
                "pid"   =>I("get.pid")
            );
            $actype = "add";
        }
        $cate = M('ContentCate')->where("pid=0")->select();

        $output['script'] = CONTROLLER_NAME."/main";
        $output['info'] = $info;
        $this->assign("output",$output);
        $this->assign("cate",$cate);
        $this->assign("actype",$actype);
        $this->display('main');
    }

    // save data
    public function save_cate(){
        $model = M("ContentCate");
        if(IS_POST){
            if($model->create()){
                if(I("post.id")){
                    $result = $model->save();
                }else {
                    $result = $model->add();
                }
                if($result !== false){
                    if(I('post.type') == 'single' && empty($_POST['id'])){
                        $inserData = array(
                            "cid"   =>$result,
                            "title" =>I("post.title"),
                            "pid"   =>I("post.pid")
                        );
                        $addPage = M("Single")->data($inserData)->add();
                    }
                    $backData = array(
                        "status"    =>1,
                        "msg"       =>"修改成功",
                        "jump"      =>U("index")
                    );
                }else {
                    $backData = array(
                        "status"    =>0,
                        "msg"       =>$model->getError()
                    );
                }
            }else {
                $backData = array(
                    "status"    =>0,
                    "msg"       =>$model->getError()
                );
            }
            $this->ajaxReturn($backData);
        }
    }


       /**
     * 创建分类树
     * @param   $list   array
     * @param   $pid    number
     * @param   number
     * @param   number
     * @return  string
     */
    private function _createTree($list,$pid=0,$level=1,$max=3)
    {
        $tree = '';
        if (is_array($list) && $level <= $max) {
            foreach ($list as $k => $v) {
                if ($v['pid'] == $pid) {
                    if($level == 1 ){
                        $tree .='
                            <div class="list">
                                <div class="parent">
                                    <div class="item" data-id="' . $v["id"] . '" data-key="' . $v['identification'] . '">
                                        <div class="caption">' . $v['title'] . '</div>
                                        <div class="operation">
                                            <a href="'.U('main?pid='.$v['id']).'">添加子栏目</a><a href="'.U('main?id='.$v['id']).'">修改</a><a href="javascript:void(0)" class="js-del-item" data-id="'.$v["id"].'">删除</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="child">'.$this->_createTree($list,$v['id'],$level+1).'</div>
                            </div>';
                    }elseif($level == 2){
                        $tree .= '
                        <div class="item" data-id="' . $v["id"] . '" data-key="' . $v['identification'] . '">
                        <div class="caption"><span>——</span>'.$v["title"].'</div>
                            <div class="operation">
                                <a href="'.U('main?id='.$v['id']).'">修改</a>
                                <a href="javascript:void(0)" class="js-del-item" data-id="'.$v["id"].'">删除</a>
                            </div>
                        </div>
                        ';
                    }
                }

            }
        }
        return $tree;
    }

}
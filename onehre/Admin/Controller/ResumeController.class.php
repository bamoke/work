<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2017/6/26
 * Time: 16:59
 */

namespace Admin\Controller;
use Admin\Common\Auth;

class ResumeController extends Auth
{

    public function vlist(){
        // paging set
        $model = M("Resume");
        $pageSize = 15;
        $page = empty($_GET["p"]) ? 1 : (int)$_GET["p"];
        $where = array();
        if(!empty($_GET['keyword'])){
            $where['realname'] = array('like','%'.I('get.keyword').'%');
        }
        $total = $model->where($where)->count();
        $list = $model
            ->field("id,realname,sex,edu,birth,experince,phone,email,FROM_UNIXTIME(last_update) as date")
            ->where($where)
            ->page($page,$pageSize)
            ->order("id desc")
            ->fetchSql(false)
            ->order('id desc')
            ->select();
        if($list === false){
            $backData = array(
                'code'      => 13001,
                "msg"       => "系统错误"    
              );
            $this->ajaxReturn($backData);
        }

        // 
        if(count($list)) {
            $sexNameArr = C('DATA_SEX_NAME');
            $eduNameArr = C('DATA_EDU_NAME');
            $expNameArr = C('DATA_EXP_NAME');
            foreach($list as $key=>$val){
              $list[$key]['sex_name'] = $sexNameArr[$val['sex']];
              $list[$key]['edu_name'] = $eduNameArr[$val['edu']];
              $list[$key]['exp_name'] = $expNameArr[$val['experince']];
            }
        }

        $backData = array(
            'code'      => 200,
            "msg"       => "ok",
            'data'      => array(
                "list"  =>$list,
                "total" =>intval($total),
                "pageSize"  =>$pageSize
            )
          );
        $this->ajaxReturn($backData);
    }


    public function detail($id){
        if(empty($_GET['id'])) {
            $backData = array(
                'code'      => 10001,
                "msg"       => "非法请求"    
              );
            $this->ajaxReturn($backData);   
        }
        $id = I("get.id");
        $sexNameArr = C('DATA_SEX_NAME');
        $eduNameArr = C('DATA_EDU_NAME');
        $expNameArr = C('DATA_EXP_NAME');
        $baseInfo = M("Resume")->where(array('id'=>$id))->find();
        $condition = array(
            "rid"=>$id
        );
        $eduInfo = M("ResumeEdu")->where($condition)->select();
        $workInfo = M("ResumeWork")->where($condition)->select();

        // 数据转换
        $baseInfo['sex'] = $sexNameArr[$baseInfo['sex']];
        $baseInfo['edu'] = $eduNameArr[$baseInfo['edu']];
        $baseInfo['experince'] = $expNameArr[$baseInfo['experince']];
        if(count($eduInfo)) {
            foreach($eduInfo as $key=>$val){
              $eduInfo[$key]['level'] = $eduNameArr[$val['level']];
            }
        }
        $backData = array(
            'code'      => 200,
            "msg"       => "ok",
            'data'      => array(
                "baseInfo"      =>$baseInfo,
                "eduInfo"       =>$eduInfo,
                "workInfo"      =>$workInfo
            )
          );
        $this->ajaxReturn($backData);      
    }


 






    /*=============================*/
}
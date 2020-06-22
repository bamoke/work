<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2017/06/12
 * Time: 10:27
 */

namespace Manage\Controller;


use Manage\Common\Controller\AuthController;

class MemberController extends AuthController
{

    /**
     * 总学习时长汇总更新
     */
    public function wangtest($classid){
        $classId = $classid;
        $courseList = M("Course")->where(array("class_id"=>$classId))->getField("id",true);
        // var_dump($courseList);
        // exit();
        $studentsList = M("ClassStudents")->field("id")->where(array("class_id"=>$classId))->select();
        $newList = array();
        foreach($studentsList as $key=>$val) {
            $processTotal = M("MyCourse")
            ->where(array(
                "member_id" =>$val["id"],
                "course_id" =>array("in",$courseList)
            ))
            ->sum("progress");
            if($processTotal == null ) {
                $processTotal = 0;
            }
            $update = M("ClassStudents")
            ->where(
                array(
                "member_id" =>$val["id"],
                "class_id"  =>$classId
                )
            )
            ->data(array(
                "progress"  =>floor($processTotal / count($courseList))
            ))
            ->save();
            $newList[] =array(
                "uid"   =>$val["id"],
                "total" =>$processTotal,
                "update"    =>$update
            );
        }
        var_dump($newList);

    }

    /***View  Index**/
    public function index(){
        $model = M('ClassStudents');
        $condition = array();
        $keywordCondition = array();
        $className = "";
        if(!empty($_GET["classid"])) {
            $condition['M.class_id'] =I("get.classid");
            $className = M("Class")->where(array("id"=>I('get.classid')))->getField("name");
        }
        if(!empty($_GET['keywords'])) {
            $keywords = I("get.keywords");
            $keywordCondition["M.realname"] = array("like","%".$keywords."%");
            $keywordCondition["M.mobile"] = array("like","%".$keywords."%");
            $keywordCondition["_logic"] = "or";
            $condition["_complex"] = $keywordCondition;
        }
        if(!empty($_GET['study_stage'])) {
            $statudyStage = I("get.study_stage");
            if($statudyStage == 1) {
                $condition["M.process"] = array("neq",100);
            }elseif($statudyStage == 2) {
                $condition["M.process"] = 100;
            }
        }
        
        // paging set
        $count = $model->alias("M")->where($condition)->count();
        $pageSize = 20;
        $page = new \Think\Page($count,$pageSize);
        $page->setConfig('next','下一页');
        $page->setConfig('prev','上一页');
        $paging = $page->show();

        $result = $model
            ->alias("M")
            ->field("M.*,MI.avatar,C.name as class_name")
            ->join("__CLASS__ as C on C.id=M.class_id")
            ->join("LEFT JOIN __MEMBER_INFO__ as MI on MI.member_id = M.id")
            ->page(I('get.p').',$pageSize')
            ->where($condition)
            ->select();



        $outData = array(
            'list'      => $result,
            "className" =>$className,
            'paging'    => $paging
        );
        $this->assign('output',$outData);
        $this->display();
    }


    /***View  detail page**/
    public function detail($id){
        $model = M('Member');
        $result = $model
            ->alias("a")
            ->field("a.*,b.*")
            ->join("__MEMBER_INFO__ as b ON b.member_id = a.id","LEFT")
            ->where('a.id='.$id)
            ->find();
        $outData['info'] = $result;
        $this->assign('output',$outData);
        $this->display();
    }

        /***
         * 观看记录
         * 
         * **/
        public function study_record($memberid){
            $model = M('StudyRecord');
            $condition = array(
                "SR.member_id" =>$memberid
            );
            $classId = I("get.classid");
            if(!empty($classId)){
                $courseIdArr = M("Course")->where(array("class_id"=>$classId))->getField("id",true);
                $condition["SR.course_id"] = array("in",$courseIdArr);
            }
            $memberName = M("ClassStudents")->where(array(
                "member_id" =>$memberid,
                "class_id"  =>$classId
            ))->fetchSql(false)
            ->getField("realname");
            // paging set
            $count = $model->alias("SR")->where($condition)->count();
            $curPage = I("get.p/d",1);
            $pageSize = 20;
            $page = new \Think\Page($count,$pageSize);
            $page->setConfig('next','下一页');
            $page->setConfig('prev','上一页');
            $paging = $page->show();

            $result = $model
                ->alias("SR")
                ->field("SR.*,SEC_TO_TIME(SR.play_time) as record_time,FROM_UNIXTIME(SR.time) as update_time,C.title as course_name")
                ->join("__COURSE__ as C ON C.id = SR.course_id")
                ->where($condition)
                ->fetchSql(false)
                ->page($curPage.','.$pageSize)
                ->select();

            $outData = array(
                'list'      => $result,
                "memberName"    =>$memberName,
                'paging'    => $paging
            );
            $this->assign('output',$outData);
            $this->display();
        }


    /***Operation 禁用***/
    public function disable($id,$v){
        $model = M('Member');
        $data = array('status'=>$v);
        $result = $model->where('id = '.$id)->save($data);
        if($result){
            $this->ajaxReturn(array('status'=>1,'info'=>'success'));
        }else {
            $this->ajaxReturn(array('status'=>0,'info'=>$model->getError()));
        }
    }

    public function cash(){
        $model = M("Cash");
        $where = array();
        if(!empty($_GET['keyword'])){
            $where['member_name'] = I('get.keyword');
        }
        if(isset($_GET['status']) && $_GET['status'] !== '') {
            $where['status'] = I('get.status');
        }

        $count = $model->where($where)->count();
        $Page = new \Think\Page($count,15);
        $Page->setConfig("next","下一页");
        $Page->setConfig("prev","上一页");
        $show = $Page->show();

        $list = $model
            ->where($where)
            ->field("id,member_name,amount,account_num,bank,pay_way,date(pay_time) as pay_time,date(create_time) as create_time,status")
            ->order("create_time desc")
            ->limit($Page->firstRow.",".$Page->listRows)
            ->select();
        $output['script'] = CONTROLLER_NAME."/main";
        $output['page'] = $show;
        $accountType = array(
            "1"     =>"支付宝",
            "2"     =>"微信",
            "3"     =>"银行卡"
        );
        $this->assign('output',$output);
        $this->assign('cashData',$list);
        $this->assign('accountType',$accountType);
        $this->display();
    }


    public function confirm_cash ($id){
        $cashModel = M('Cash');
        $where = array(
            "id"    =>$id,
            "status"    =>0
        );
        $cashUpdateData = array(
            "status"    =>1,
            "pay_time"  =>date("Y-m-d H:i:s")
        );
        $cashInfo = $cashModel->where($where)->find();
        $cashModel->startTrans();
        $cashUpdate = $cashModel->where($where)->fetchSql(false)->save($cashUpdateData);
        $memberUpdate = M()->execute("update __MEMBER__ set `capital` = (`capital` - ".$cashInfo['amount'].") where id = ".$cashInfo['member_id']);
        if($cashUpdate && $memberUpdate){
            $cashModel->commit();
                $backData['status'] = 1;
            $backData['msg'] = "操纵成功";
            $backData['cashsql'] = $cashUpdate;
            $backData['sql'] = $memberUpdate;
        }else {
            $cashModel->rollback();
            $backData['status'] = 0;
            $backData['msg'] = "数据错误";
        }
        $this->ajaxReturn($backData);

    }


    public function recharge(){
        $model = M("Recharge");
        $where = array();
        if(!empty($_GET['keyword'])){
            $where['member_name'] = I('get.keyword');
        }
        if(isset($_GET['status']) && $_GET['status'] !== '') {
            $where['status'] = I('get.status');
        }

        $count = $model->where($where)->count();
        $Page = new \Think\Page($count,15);
        $Page->setConfig("next","下一页");
        $Page->setConfig("prev","上一页");
        $show = $Page->show();

        $list = $model
            ->where($where)
            ->field("id,member_name,amount,date(create_time) as create_time,status")
            ->order("create_time desc")
            ->limit($Page->firstRow.",".$Page->listRows)
            ->select();
        $output['script'] = CONTROLLER_NAME."/main";
        $output['page'] = $show;
        $this->assign('output',$output);
        $this->assign('rechargeData',$list);
        $this->display();
    }

    public function confirm_recharge($id){
        $reModel = M("Recharge");
        $reUpdateData = array('status'=>1);
        $reWhere = array('id'=>$id,'status'=>0);
        $reInfo = $reModel->where($reWhere)->find();
        if(!$reInfo){
            $backData = array('status'=>0,"msg"=>"已确认支付的记录");
            return $this->ajaxReturn($backData);
        }
        $reModel->startTrans();
        $reUpdate = $reModel->where($reWhere)->save($reUpdateData);
        $membUpdate = M()->execute("Update __MEMBER__ set `capital` = (`capital` + ".$reInfo['amount'].") where id =".$reInfo['member_id']);
        if($reUpdate && $membUpdate){
            $backData = array(
                "status"    =>1,
                "msg"       =>"操作成功"
            );
            $reModel->commit();
        }else {
            $backData = array(
                "status"    =>0,
                "msg"       =>"数据错误"
            );
            $reModel->rollback();
        }
        $this->ajaxReturn($backData);
    }

    /**
     * 导出excel表格
     * @params page 
     */
    public function download($classid){
        $downType = I("get.downtype");//1.导出当前页，2：全部导出
        $page = I("get.page/d,1");
        $pageSize = 20;
        $model = M('ClassStudents');
        $condition = array(
            "class_id"  =>$classid
        );

        if(!empty($_GET['realname'])) {
            $condition["realname"] = array("like","%".I("get.realname")."%");
        }
        if(!empty($_GET['study_stage'])) {
            $statudyStage = I("get.study_stage");
            if($statudyStage == 1) {
                $condition["process"] = array("neq",100);
            }elseif($statudyStage == 2) {
                $condition["process"] = 100;
            }
        }
        if($downType == 1) {
            $list = $model
            ->field("id,realname,mobile,progress,IF(bind_time,'1','0') as isreport")
            ->page(I('get.p').',$pageSize')
            ->where($condition)
            ->order("isreport desc,progress desc")
            ->select();
        }else {
            $list = $model
            ->field("id,realname,mobile,progress,IF(bind_time,'1','0') as isreport")
            ->limit("2000")
            ->where($condition)
            ->order("isreport desc,progress desc")
            ->select();
        }
        if(count($list) == 0) {
            $this->error('无记录导出失败');
            exit();
        }
        // 班级信息
        $className = M("Class")->where(array("id"=>$classid))->getField("name");

        $xlsTitle = iconv('utf-8', 'gb2312', $className);
        $fileName = $className."学员学习进度统计";
        
        $cellKey = array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M',
            'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM',
            'AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'
        );


        vendor("PHPExcel.PHPExcel");
        $objPHPExcel = new \PHPExcel();

            //处理表头标题
        $objPHPExcel->getActiveSheet()->mergeCells('A1:'.$cellKey[4].'1');//合并单元格（如果要拆分单元格是需要先合并再拆分的，否则程序会报错）
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','统计信息');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        // $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('A2', '姓名!');
        $objPHPExcel->getActiveSheet()->SetCellValue('B2', '手机号');
        $objPHPExcel->getActiveSheet()->SetCellValue('C2', '是否报到');
        $objPHPExcel->getActiveSheet()->SetCellValue('D2', '总学习进度');


        // 处理数据
        $i = 3;
        foreach($list as $key=>$val){
            $isreportTxt = $val['isreport']?"是":"否";
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $val['realname']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $val['mobile']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $isreportTxt);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $val['progress']);
            $i++;
        }


        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }


}
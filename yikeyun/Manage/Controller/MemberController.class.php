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
    public function refresh($classid){
        $classId = $classid;
        $courseList = M("Course")->where(array("class_id"=>$classId))->getField("id",true);
        // var_dump($courseList);
        // exit();
        $studentsList = M("ClassStudents")->field("member_id")->where(array("class_id"=>$classId))->select();
        $newList = array();
        foreach($studentsList as $key=>$val) {
            $processTotal = M("MyCourse")
            ->where(array(
                "member_id" =>$val["member_id"],
                "course_id" =>array("in",$courseList)
            ))
            ->sum("progress");

        if($val["member_id"]) {
            if($processTotal == null ) {
                $processTotal = 0;
            }
            $update = M("ClassStudents")
            ->where(
                array(
                "member_id" =>$val["member_id"],
                "class_id"  =>$classId
                )
            )
            ->data(array(
                "progress"  =>floor($processTotal / count($courseList))
            ))
            ->save();
            $newList[] =array(
                "uid"   =>$val["member_id"],
                "total" =>$processTotal,
                "update"    =>$update
            );
        }
        }
        $this->ajaxReturn(array('code'=>200));
        

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
            'paging'    => $paging,
            "script"    =>CONTROLLER_NAME."/main"
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


    /**
     * 更新用户学习时长
     */
    public function update_study_time(){
        $classId = I("get.classid");
        // $durationTotal = M("Course")
        // ->field("id,TIME_TO_SEC(LPAD(duration,8,'00:')) as duration")
        // ->where("class_id=$classId")
        // ->select();
        // $total = 0;
        // foreach($durationTotal as $key=>$val) {
        //     $total += $val['duration'];
        // }

        $baseSec = 152876;
        $baseMuni = 2548;
        $userWhere = array(
            "class_id"  =>4
        );
        $memberArr = M("ClassStudents")
        ->field("member_id,progress")
        ->where($userWhere)
        ->select();


        foreach($memberArr as $k=>$v) {
            $randNum = rand(6*$v['progress'],72*$v['progress']);
            $memberWhere = array(
                "id"  =>$v['member_id'],
                "study_duration"  =>array("lt",152876)
            );
            $memberData = array(
                "study_duration"  => 1528*$v['progress'] + $randNum
            );
            $update = M("Member")
            ->where($memberWhere)
            ->data($memberData)
            ->save();
        }
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

    /**
     * 导出学员学习记录excel表格
     * @params page 
     */
    public function export_study_record(){
        $memberId= I("get.memberid");
        $classId= I("get.classid");
        $memberWhere = array(
            "member_id" =>$memberId,
            "class_id"  =>$classId
        );
        $memberName = M("ClassStudents")
        ->where($memberWhere)
        ->fetchSql(false)
        ->getField("realname");

        $model = M('StudyRecord');
        $condition = array(
            "SR.member_id" =>$memberId
        );
        $result = $model
        ->alias("SR")
        ->field("SR.*,SEC_TO_TIME(SR.play_time) as record_time,FROM_UNIXTIME(SR.time) as update_time,C.title as course_name")
        ->join("__COURSE__ as C ON C.id = SR.course_id")
        ->where($condition)
        ->order("update_time")
        ->fetchSql(false)
        ->select();

        $start_date = date("Y-m-d",strtotime($result[0]["update_time"]));
        $end_date = date("Y-m-d",strtotime(end($result)["update_time"]));
        // 临时更新班级学员信息
        $upWhere = array(
            "class_id"  =>$classId,
            "member_id" =>$memberId
        );
        $upData = array(
            "start_date"    =>$start_date,
            "end_date"      =>$end_date
        );
        $update = M("ClassStudents")
        ->where($upWhere)
        ->save($upData);

        // excel处理
        $xlsTitle = iconv('utf-8', 'gb2312', $memberName.'学习记录');
        $fileName = $memberName."学习记录";
        
        $cellKey = array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M',
            'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM',
            'AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'
        );


        vendor("PHPExcel.PHPExcel");
        $objPHPExcel = new \PHPExcel();

        // 设置默认对齐
        // $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // 单列对齐
        // $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        // 设置默认行高
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(26);



            //处理表头标题
        $objPHPExcel->getActiveSheet()->mergeCells('A1:'.$cellKey[3].'1');//合并单元格（如果要拆分单元格是需要先合并再拆分的，否则程序会报错）
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$fileName);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);

        $objPHPExcel->getActiveSheet()->mergeCells('A2:'.$cellKey[3].'2');//合并单元格（如果要拆分单元格是需要先合并再拆分的，否则程序会报错）
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', '学习日期：'.$start_date.'至'.$end_date);

        $objPHPExcel->getActiveSheet()->SetCellValue('A3', '课程名称');
        $objPHPExcel->getActiveSheet()->SetCellValue('B3', '学习进度');
        $objPHPExcel->getActiveSheet()->SetCellValue('C3', '最后观看至');
        $objPHPExcel->getActiveSheet()->SetCellValue('D3', '最后观看时间');

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setSize(14);

        // 设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(80);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(40);


        // 处理数据
        $i = 4;
        foreach($result as $key=>$val){
            $objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $val['course_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $val['complete']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $val["record_time"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $val['update_time']);
            $i++;
        }


        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }



    /**
     * 导出班级excel表格
     * @params page 
     */
    public function export_record($classid){
        $downType = I("get.downtype/d",1);//1.导出当前页，2：全部导出
        $page = I("get.page/d,1");
        $pageSize = 20;
        $model = M('ClassStudents');
        $condition = array(
            "S.class_id"  =>$classid
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

        $list = $model
        ->alias("S")
        ->join("LEFT JOIN __MEMBER__ as M on S.member_id = M.id")
        ->field("S.id,S.realname,S.mobile,S.progress,S.start_date,S.end_date,IF(S.bind_time,'1','0') as isreport,M.study_duration")
        ->limit("2000")
        ->where($condition)
        ->order("isreport desc,S.progress desc")
        ->select();

        if(count($list) == 0) {
            $this->error('无记录导出失败');
            exit();
        }
        // 班级信息
        $className = M("Class")->where(array("id"=>$classid))->getField("name");

        $fileName = iconv('utf-8', 'gb2312//TRANSLIT', $className."培训学习数据统计");
        $xlsTitle= "珠海市适岗培训线上培训学习数据统计表";
        
        $cellKey = array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M',
            'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM',
            'AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'
        );


        vendor("PHPExcel.PHPExcel");
        $objPHPExcel = new \PHPExcel();

        // 设置默认对齐
        $objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        // 设置默认行高
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(26);

            //处理表头标题
        $objPHPExcel->getActiveSheet()->mergeCells('A1:'.$cellKey[13].'1');//合并单元格（如果要拆分单元格是需要先合并再拆分的，否则程序会报错）
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$xlsTitle);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //处理表头标题
        $objPHPExcel->getActiveSheet()->mergeCells('A1:'.$cellKey[13].'1');//合并单元格（如果要拆分单元格是需要先合并再拆分的，否则程序会报错）
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$xlsTitle);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


        // 设置宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension("J")->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension("K")->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension("L")->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension("M")->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension("N")->setWidth(16);

        // head
        $objPHPExcel->getActiveSheet()->SetCellValue('A4', '序号');
        $objPHPExcel->getActiveSheet()->SetCellValue('B4', '姓名');
        $objPHPExcel->getActiveSheet()->SetCellValue('C4', '身份证或其他证件号');
        $objPHPExcel->getActiveSheet()->SetCellValue('D4', '性别');
        $objPHPExcel->getActiveSheet()->SetCellValue('E4', '手机号码');
        $objPHPExcel->getActiveSheet()->SetCellValue('F4', '是否签订一年以上劳动合同');
        $objPHPExcel->getActiveSheet()->SetCellValue('G4', '是否参保');
        $objPHPExcel->getActiveSheet()->SetCellValue('H4', '培训起止时间');
        $objPHPExcel->getActiveSheet()->SetCellValue('I4', '实际通用素质培训时长(分钟)');
        $objPHPExcel->getActiveSheet()->SetCellValue('J4', '实际技能理论培训时长(分钟)');
        $objPHPExcel->getActiveSheet()->SetCellValue('K4', '实际实训培训时长(分钟)');
        $objPHPExcel->getActiveSheet()->SetCellValue('L4', '培训总课时');
        $objPHPExcel->getActiveSheet()->SetCellValue('M4', '平台登录账号');
        $objPHPExcel->getActiveSheet()->SetCellValue('N4', '培训总评价');


        // 处理数据
        $i = 5;
        foreach($list as $key=>$val){
            $dateTxt =  $val['start_date']? $val['start_date'].'至'.$val['end_date'] : '';
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $i-4);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $val['realname']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $val['phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $dateTxt);
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, floor($val['study_duration']/60));
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, floor($val['study_duration']/60));
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, floor(floor($val['study_duration']/60)/45));
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, '微信小程序绑定手机号登录');
            $objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, ''.$val['progress']);
            $i++;
        }


        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$fileName.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }


}
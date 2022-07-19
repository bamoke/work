<?php
/*
 * @Author: Joy wang
 * @Date: 2021-04-09 05:49:58
 * @LastEditTime: 2021-05-01 15:26:10
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */
namespace Home\Controller;

use Think\Controller;

class SignupController extends Controller {

    public function index(){

        
        $this->display();
        
    }


    public function save(){

        $model = M("Signup");

        $deadline = strtotime("2021-11-03 23:59:59");

        $curTime = time();

        if($deadline <= $curTime) {

            $backData = array(
                "status"    =>0,
                "msg"       =>"报名时间已经截止"
            );
            
            $this->ajaxReturn($backData);
            
        }

        $insertData = $_POST;

        

        // 检测手机号是否存在
        $where = array(
            "phone"     =>$insertData["phone"],
            "mid"       =>$insertData["mid"]
        );
        
        $isExist = $model->where($where)->count();

        if($isExist) {
            $backData = array(
                "status"    =>0,
                "msg"       =>"手机号已经存在"
            );
            $this->ajaxReturn($backData);
        }
        
        $insertResult = $model->add($insertData);

        if(!$insertResult) {

            $backData = array(
                "status"    =>0,
                "msg"       =>"数据保存错误"
            );
            
            $this->ajaxReturn($backData);

        }

        $backData = array(
            "status"    =>1,
            "msg"       =>"success"
        );
        
        $this->ajaxReturn($backData);
    }

    public function enrol () {
        
        
        $this->display();

    }

    public function enrol_data () {

        // $viewCode = session("vcode");

        // if(!$viewCode) {
            
        //     $backData = array(
        //         "code"  =>13001,
        //         "msg"   =>"非法请求"
        //     );
            
        //     $this->ajaxReturn($backData);
        // }
        
        $Model = M("Signup");
        
        $mid = 2;
        $page = I("get.page/d",1);

        $pageSize = 20;

        $where = array (
            "mid"=>$mid
        );

        $total = $Model->where($where)->count();
        
        $list = $Model->where($where)->page($page,$pageSize)->select();

        $pageInfo = array(
            "total"     =>intval($total),
            "page"      =>$page,
            "pageSize"  =>$pageSize
        );
        
        $backData = array(
            "code"  =>200,
            "data"  =>array(
                "pageInfo"  =>$pageInfo,
                "list"      =>$list
            )
        );
        
        $this->ajaxReturn($backData);
        
    }

    /**
     * 
     */

     public function download(){

        $where = array(
            "mid"=>2
        );
        $list = M("Signup")
        ->where($where)
        ->limit("10000")
        ->select();
         
        $xlsTitle = iconv('utf-8', 'gb2312', "第19届妇科恶性肿瘤规范化诊治及新进展学习班");
        $fileName = "第19届妇科恶性肿瘤规范化诊治及新进展学习班";
        
        $cellKey = array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M',
            'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM',
            'AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'
        );


        vendor("PHPExcel.PHPExcel");
        $objPHPExcel = new \PHPExcel();

            //处理表头标题
        $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');//合并单元格（如果要拆分单元格是需要先合并再拆分的，否则程序会报错）
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','第19届妇科恶性肿瘤规范化诊治及新进展学习班');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);


        $objPHPExcel->getActiveSheet()->SetCellValue('A2', '序号');
        $objPHPExcel->getActiveSheet()->SetCellValue('B2', '姓名');
        $objPHPExcel->getActiveSheet()->SetCellValue('C2', '单位');
        $objPHPExcel->getActiveSheet()->SetCellValue('D2', '职务');
        $objPHPExcel->getActiveSheet()->SetCellValue('E2', '职称');
        $objPHPExcel->getActiveSheet()->SetCellValue('F2', '手机号码');
        // $objPHPExcel->getActiveSheet()->SetCellValue('G2', '是否提供午餐');
        $objPHPExcel->getActiveSheet()->SetCellValue('G2', '建议');

        // 处理数据
        $i = 3;
        foreach($list as $key=>$val){
            $isLunchTxt = $val['lunch'] == 1 ?"是":"否";
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $val['id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $val['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $val['company']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $val['position']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $val['title']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $val['phone']);
            // $objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $isLunchTxt);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $val['feedback']);
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
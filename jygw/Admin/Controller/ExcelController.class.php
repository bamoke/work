<?php
namespace Admin\Controller;
use Think\Controller;
class ExcelController extends Controller {
    public function index(){
        $file = ROOT . "\Uploads\mingdan.xls";
        vendor("PHPExcel.PHPExcel");
        // Vendor('PHPExcel.PHPExcel.IOFactory');
        // $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($file,$encode='utf-8');
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        for($i=3;$i<=$highestRow;$i++)
        {
            $data['realname'] = $objPHPExcel -> getActiveSheet() -> getCell("B".$i)->getValue();
            $data['company']   = $objPHPExcel -> getActiveSheet() -> getCell("C".$i)->getValue();
            $data['position']  = $objPHPExcel -> getActiveSheet() -> getCell("D".$i)->getValue();
            $data['phone']    = $objPHPExcel -> getActiveSheet() -> getCell("E".$i)->getValue();
            $data['sex']      = $objPHPExcel -> getActiveSheet() -> getCell("F".$i)->getValue();
            $data['type'] = 1;
            $phoneList[] = $data['phone'];
            $insertAllData[] = $data;
        }
     
        // $hasId = M("Card")->field("id,realname,phone,company")->where(array('phone'=>array('in',$phoneList)))->select();
        
        $insertResult = M("Card")->fetchSql(true)->addAll($insertAllData);
        print_R($insertResult);
        $backData = array(
            "code"  =>200,
            "msg"   =>'success',
            'data'  =>""
        );
        $this->ajaxReturn($backData);
    }
}
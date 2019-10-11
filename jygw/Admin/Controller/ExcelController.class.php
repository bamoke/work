<?php
namespace Admin\Controller;
use Think\Controller;
class ExcelController extends Controller {
    public function index($f){
        $file = ROOT . "\Uploads\\".$f;

        vendor("PHPExcel.PHPExcel");
        // Vendor('PHPExcel.PHPExcel.IOFactory');
        // $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($file,$encode='utf-8');
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        $insertAllData = array();
        $existArr = array();
        for($i=3;$i<=$highestRow;$i++)
        {
            $position = $objPHPExcel -> getActiveSheet() -> getCell("D".$i)->getValue();
            $data['company']   = $objPHPExcel -> getActiveSheet() -> getCell("B".$i)->getValue();
            $data['realname'] = $objPHPExcel -> getActiveSheet() -> getCell("C".$i)->getValue();
            $data['position']  = $position == NULL ? '未填写' : $position;
            $data['phone']    = $objPHPExcel -> getActiveSheet() -> getCell("E".$i)->getValue();
            $data['type'] = 1;

            $exist = M("Card")->where(array('phone'=>$data['phone']))->count();
            if($exist) {
                $existArr[] = $data;
            }else {
                $insertAllData[] = $data;
            }
        }

        
        // $insertResult = M("Card")->fetchSql(false)->addAll($insertAllData);
        var_dump($existArr);
        exit();
        $backData = array(
            "code"  =>200,
            "msg"   =>'success',
            'data'  =>""
        );
        $this->ajaxReturn($backData);
    }
}
<?php
namespace Admin\Common;

class ExcelSheet 
{
    protected $rows;
    protected $columns;
    protected $sheetTitle;
    protected $sheetTimeStamp;
    public $insertData;

    function __construct($file,$tableField,$offset,$uid){
        vendor("PHPExcel.PHPExcel");
        vendor("PHPExcel.PHPExcel.Shared.Date");

        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($file,$encode='utf-8');
        $sheet = $objPHPExcel->getSheet(0);
        $this->sheetTitle = $objPHPExcel -> getActiveSheet() -> getCell("A1")->getValue();
        $this->sheetTimeStamp = \PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell("A2")->getValue());

        $this->rows = $sheet->getHighestRow(); // 取得总行数
        $this->columns = $sheet->getHighestColumn(); // 取得总列数
        for($i=$offset;$i<=$this->rows;$i++)
        {
            foreach($tableField as $key=>$val){
                if($key == 'year') {
                    $data['year'] = date("Y",$this->sheetTimeStamp);
                }elseif($key == 'month') {
                    $data['month'] = date("m",$this->sheetTimeStamp);
                }elseif($key == 'create_by'){
                    $data['create_by'] = $uid;
                }elseif($key == 'data_date'){
                    $data["data_date"] = date("Y-m-d",$this->sheetTimeStamp);
                }else {
                    $sheetVal = trim($objPHPExcel -> getActiveSheet() -> getCell($key.$i)->getValue());
                    if($sheetVal == '--' || $sheetVal == '——' || $sheetVal == '' || $sheetVal == '#DIV/0!' || $sheetVal == '#N/A' || $sheetVal == '-' || $sheetVal == '=#REF!' || $sheetVal == '—') {
                        $data[$val] = array('exp','null');
                    }else{
                        $data[$val]   = trim($sheetVal,"#");
                    }

                }
            }
            $this->insertData[] = $data;
        }
        
    }
    
}

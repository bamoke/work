<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

class EconomyController extends AuthController {

    public function upload(){

        
    }

    public function get_town(){
        $where = array(
            "year"  =>$this->curYear,
            "month" =>$this->curMonth
        );
        $cate = I("get.cate");
        if($cate){
            $where["title"] = $cate;
        }
        $modelName = "EconomyTown";
        $model = D($modelName);
        $townData = $model->getList($where);

        $backData = array(
            "code"  =>200,
            "data"  =>array(
                "title" =>"",
                "measure"=>$townData["measure"],
                "columns"   =>$townData["columns"],
                "list"  =>$townData['list']
            )
        );

        $this->ajaxReturn($backData);

    }

    public function get_county(){
        $cate = I("get.cate");
        $title = "";
        if($cate == '地区生产总值') {
            $gdpTimestamp = format_gdp_timestamp($this->curYear,$this->curMonth);
            $gdpYear = idate("Y", $gdpTimestamp);
            $gdpMonth = idate("m", $gdpTimestamp);
            $where = array(
                "year" => $gdpYear,
                "month" => $gdpMonth,
                "title" => "地区生产总值",
            );
            $title = $gdpYear."年1-".$gdpMonth."月";
        }else {
            $where = array(
                "year"  =>$this->curYear,
                "month" =>$this->curMonth,
                "title" =>$cate
            );
        }

        $model = D("EconomyCounty");
        $countyData = $model->getList($where);

        $backData = array(
            "code"  =>200,
            "data"  =>array(
                "title"=>$title,
                "measure"   =>"",
                "columns"   =>$countyData['columns'],
                "list"      =>$countyData['list']
            )
        );

        $this->ajaxReturn($backData);
    }


    public function get_domestic(){

        $cate = I("get.cate");
        
        if($cate =='地区生产总值'){
            $gdpTimestamp = format_gdp_timestamp($this->curYear,$this->curMonth-1);
            $gdpYear = idate("Y", $gdpTimestamp);
            $gdpMonth = idate("m", $gdpTimestamp);
            $dateWhere = array(
                "year" => $gdpYear,
                "month" => $gdpMonth,
                "title" => "地区生产总值",
            );

        }else {
            // 国内部分区域取当前月份最近的一个月
            $dateWhere = array(
                "data_date"  =>array("elt",date_format($this->curDateObj,'Y-m-d')),
                "title"     =>$cate
            );
        }


        $modelName = "EconomyDomestic";
        $model = D($modelName);
        $lastDate = $model
        ->fetchSql(false)
        ->field("data_date,year,month")
        ->where($dateWhere)
        ->order("data_date desc")
        ->find();

        $where = array(
            "title" =>$cate,
            "data_date" =>$lastDate["data_date"]
        );

        $list = $model->fetchSql(false)->field("area,gross,rise")->where($where)->limit(20)->select();


        
        $columns = array(
            array(
                "title" =>"区域",
                "key"   =>"area"
            ),
            array(
                "title" =>"总量",
                "key"   =>"gross"
            ),
            array(
                "title" =>"同比(%)",
                "key"   =>"rise"
            ),
        );

        $backData = array(
            "code"  =>200,
            "data"  =>array(
                "title"=>"1-".idate("m",strtotime($lastDate["data_date"]))."月",
                "measure"   =>"",
                "columns"   =>$columns,
                "list"      =>$list
            )
        );

        $this->ajaxReturn($backData);
    }


}
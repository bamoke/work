<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class FinanceModel extends BaseUploadModel {
    protected $tableName = 'finance';
    protected $dataOffset = 5;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"title",
        "B" =>"measure",
        "C" =>"parent_name",
        "D" =>"gross",
        "E" =>"rise",
    );


    public function getIncomeList($condition){
        $list = $this->field("title,parent_name,gross,rise")->where($condition)->fetchSql(false)->select();
        $newList = array();
        foreach($list as $key=>$val) {
            if($val["parent_name"] == "收入") {
                $newList["parent"][] = array(
                    "title" =>$val["title"],
                    "gross" =>$val["gross"],
                    "rise" =>$val["rise"],
                );
 
            }else {
                $newList["child"][] = array(
                    "title" =>$val["title"],
                    "gross" =>$val["gross"],
                    "rise" =>$val["rise"],
                );

            }
        }

        $columns = array(
            array(
                "title" =>"指标名称",
                "key"   =>"title"
            ),
            array(
                "title" =>"总量(万元)",
                "key"   =>"gross"
            ),
            array(
                "title" =>"同比(%)",
                "key"   =>"rise"
            )
        );
        return array(
            "measure"   =>"万元",
            "columns"  =>$columns,
            "list"=>$newList
        );

    }

    public function getMainList($condition){
        $list = $this->field("title,gross,rise")->where($condition)->fetchSql(false)->select();

        $columns = array(
            array(
                "title" =>"指标名称",
                "key"   =>"title"
            ),
            array(
                "title" =>"总量(万元)",
                "key"   =>"gross"
            ),
            array(
                "title" =>"同比(%)",
                "key"   =>"rise"
            )
        );
        return array(
            "measure"   =>"万元",
            "columns"  =>$columns,
            "list"=>$list
        );

    }
}
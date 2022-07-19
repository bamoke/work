<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class EconomyTownModel extends BaseUploadModel {
    protected $tableName = 'economy_town';
    protected $dataOffset = 5;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"title",
        "B" =>"parent_name",
        "C" =>"measure",
        "D" =>"sz_gross",
        "E" =>"sz_rise",
        "F" =>"hq_gross",
        "G" =>"hq_rise",
        "H" =>"ns_gross",
        "I" =>"ns_rise",
        "J" =>"ps_gross",
        "K" =>"ps_rise"
    );


    public function getList($condition){
        $info = $this->where($condition)->fetchSql(false)->find();
        if($info) {
            $list = array(
                array(
                    "town"  =>"三灶",
                    "gross" =>$info["sz_gross"],
                    "rise"  =>$info["sz_rise"]
                ),
                array(
                    "town"  =>"红旗",
                    "gross" =>$info["hq_gross"],
                    "rise"  =>$info["hq_rise"]
                ),
                array(
                    "town"  =>"南水",
                    "gross" =>$info["ns_gross"],
                    "rise"  =>$info["ns_rise"]
                ),
                array(
                    "town"  =>"平沙",
                    "gross" =>$info["ps_gross"],
                    "rise"  =>$info["ps_rise"]
                )
            );
        }else {
            $list = array();
        }
        $columns = array(
            array(
                "title" =>"镇街",
                "key"   =>"town"
            ),
            array(
                "title" =>"总量(".$info['measure'].")",
                "key"   =>"gross"
            ),
            array(
                "title" =>"同比(%)",
                "key"   =>"rise"
            )
        );
        return array(
            "measure"=>$info['measure'],
            "title"=>$condition['title'],
            "columns"=>$columns,
            "list"=>$list
        );
    }
}
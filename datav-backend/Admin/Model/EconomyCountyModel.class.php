<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class EconomyCountyModel extends BaseUploadModel {
    protected $tableName = 'economy_county';
    protected $dataOffset = 5;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"county",
        "B" =>"title",
        "C" =>"measure",
        "D" =>"gross",
        "E" =>"rise",
        "F" =>"proportion",
        "G" =>"zs_ranking"
    );


    public function getList($condition){

        $list = $this->field("county, gross,rise,proportion,zs_ranking,measure")->where($condition)->select();

        $columns = array(
            array(
                "title" =>"区域",
                "key"   =>"county"
            ),
            array(
                "title" =>"总量(".$list[0]['measure'].")",
                "key"   =>"gross"
            ),
            array(
                "title" =>"同比(%)",
                "key"   =>"rise"
            ),
            array(
                "title" =>"比重",
                "key"   =>"proportion"
            ),
            array(
                "title" =>"增速位次",
                "key"   =>"zs_ranking"
            )
        );

        return array(
            "title"=>$condition['title'],
            "columns"=>$columns,
            "list"=>$list
        );
    }
}
<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class WholeCountryModel extends BaseUploadModel {
    protected $tableName = 'whole_country';
    protected $dataOffset = 5;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"title",
        "B" =>"parent_name",
        "C" =>"measure",
        "D" =>"country_gross",
        "E" =>"country_rise",
        "F" =>"province_gross",
        "G" =>"province_rise",
        "H" =>"city_gross",
        "I" =>"city_rise",
    );


    public function getList($condition){
        $selfWhere = array(
            "title" =>array("neq","合计")
        );
        $where = array_merge($selfWhere,$condition);

        $list = $this
        ->fetchSql(false)
        ->field("title,comnum,CEIL(jw_gross) as gross,jw_rise as rise")
        ->where($where)
        ->select();

        $columns = array(
            array(
                "title" =>"行业",
                "key"   =>"title"
            ),
            array(
                "title" =>"企业数",
                "key"   =>"comnum"
            ),
            array(
                "title" =>"总产值(万元)",
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
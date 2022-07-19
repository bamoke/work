<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class IndustryHangyeZczModel extends BaseUploadModel {
    protected $tableName = 'industry_hangye_zcz';
    protected $dataOffset = 6;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"title",
        "B" =>"comnum",
        "C" =>"jw_gross",
        "D" =>"jw_rise",
        "E" =>"zs_gross",
        "F" =>"zs_rise",
        "G" =>"kfq_gross",
        "H" =>"kfq_rise",
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
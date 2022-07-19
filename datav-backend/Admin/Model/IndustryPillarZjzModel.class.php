<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class IndustryPillarZjzModel extends BaseUploadModel {
    protected $tableName = 'industry_pillar_zjz';
    protected $dataOffset = 6;
    protected $tableField =array(
        "year"  =>"",
        "month"  =>"",
        "create_by" =>"",
        "data_date" =>"",
        "A" =>"title",
        "B" =>"parent_name",
        "C" =>"com_num",
        "D" =>"gross",
        "E" =>"rise",
        "F" =>"proportion",

    );


    /**
     * for frontend api
     * 表格模式数据输出
     */
    public function getList($condition){


        // 2021-6月开始分类更改了
        if($condition["year"] >= 2021 && $condition['month'] >=0 ){
            $selfWhere = array(
                "title" =>array(array("neq","合计"),array('neq','传统优势'),'and')
            );
        }else {
            $selfWhere = array(
                "title" =>array("neq","合计")
            );
        }
        $where = array_merge($selfWhere,$condition);

        $list = $this
        ->field("title,com_num,CEIL(gross) as gross,rise,proportion")
        ->where($where)
        ->fetchSql(false)
        ->select();

        $columns = array(
            array(
                "title" =>"行业",
                "key"   =>"title",
            ),
            array(
                "title" =>"企业数",
                "key"   =>"com_num"
            ),
            array(
                "title" =>"增加值(万元)",
                "key"   =>"gross"
            ),
            array(
                "title" =>"同比",
                "key"   =>"rise"
            ),
            array(
                "title" =>"比重",
                "key"   =>"proportion"
            ),
            array(
                "title" =>"查看",
                "width" =>60,
                "slot"=>'view',
            )
        );
        return array(
            "measure"   =>"亿元",
            "columns"  =>$columns,
            "list"=>$list
        );
    }

    /**
     * 输出 cate
     */
    public function getDataForcate($condition){
        $result = $this->field("title")->distinct(true)->where($condition)->select();
        $cate = array();
        foreach($result as $key=>$val) {
            $cate[] = array(
                "text"  =>$val["title"],
                "value"  =>$val["title"],
            );
        }
        return $cate;

    }

}
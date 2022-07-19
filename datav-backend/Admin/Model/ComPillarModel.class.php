<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class ComPillarModel extends BaseUploadModel
{
    protected $tableName = 'com_pillar';
    protected $dataOffset = 5;
    protected $tableField = array(
        "year" => "",
        "month" => "",
        "create_by" => "",
        "data_date" => "",
        "A" => "industry",
        "B" => "comname",
        "C" => "zcz_gross",
        "D" => "zcz_prev_gross",
        "E" => "zcz_kbj_gross",
        "F" => "zcz_rise",
        "G" => "zjz_gross",
        "H" => "zjz_prev_gross",
        "I" => "zjz_kbj_gross",
        "J" => "zjz_rise",
    );



    public function getList($condition, $pageSize=20)
    {
        $page = I("get.page/d",1);
        $total = $this->where($condition)->count();
        $list = $this
        ->field("comname,industry,CEIL(zcz_gross) as zcz_gross,CEIL(zcz_prev_gross) as zcz_prev_gross,ROUND(zcz_rise*100,1) as zcz_rise,CEIL(zjz_gross) as zjz_gross,CEIL(zjz_prev_gross) as zjz_prev_gross,ROUND(zjz_rise*100,1) as zjz_rise")
        ->fetchSql(false)
        ->where($condition)
        ->page($page, $pageSize)
        ->select();
        $pageInfo = array(
            "page"      =>$page,
            "pageSize"  =>$pageSize,
            "total"     =>$total
        );


        $columns = array(
            array(
                "title" => "序号",
                "type" => "index",
                "width"=>70,
            ),
            array(
                "title" => "企业名称",
                "key" => "comname",
                "minWidth" => 120,
                "maxWidth"=>600
            ),
            array(
                "title" =>"总产值(千元)",
                "align"=> 'center',
                "children"  =>array(

                    array(
                        "title" => "总量",
                        "key" => "zcz_gross",
                        "align"=>"right",

                    ),
                    array(
                        "title" => "上年同期",
                        "key" => "zcz_prev_gross",
                        "align"=>"right"
                    ),
                    array(
                        "title" => "同比(%)",
                        "key" => "zcz_rise",
                        "align"=>"right"
                    ),
                )
            ),

            array(
                "title" =>"增加值(千元)",
                "align"=> 'center',
                "children"  =>array(

                    array(
                        "title" => "总量",
                        "key" => "zjz_gross",
                        "align"=>"right"
                    ),
                    array(
                        "title" => "上年同期",
                        "key" => "zjz_prev_gross",
                        "align"=>"right"
                    ),
                    array(
                        "title" => "同比(%)",
                        "key" => "zjz_rise",
                        "align"=>"right"
                    ),
                )
            ),


        );
        return array(
            "measure" => "千元",
            "pageInfo"  =>$pageInfo,
            "columns" => $columns,
            "list" => $list,
        );
    }

    
}

<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

/**
 * 金湾区（开发区）固定资产项目情况-企业信息
 */

class ComInvestmentModel extends BaseUploadModel
{
    protected $tableName = 'com_investment';
    protected $dataOffset = 4;
    protected $tableField = array(
        "year" => "",
        "month" => "",
        "create_by" => "",
        "data_date" => "",


        "B" => "comname",
        "C" => "project_name",
        "D" => "cate",
        "E" => "gross",
        "F" => "all_complete",
        "G" => "year_complete",
        "H" => "land_cost",
        "I" => "left_land_cost",
        "J" => "month_complete",
        "K" => "town",
    );


    public function getList($condition, $pageSize=20)
    {
        $page = I("get.page/d",1);
        $total = $this->where($condition)->count();
        $list = $this
        ->field("comname,town,project_name,cate,gross,all_complete,year_complete,month_complete,land_cost,left_land_cost")
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
                "title" => "项目名称",
                "key" => "project_name",
                "fixed"=> 'left',
                "minWidth" => 200,
                "maxWidth"=>320
            ),
            array(
                "title" => "企业名称",
                "key" => "comname",
                "minWidth" => 200,
                "maxWidth"=>320
            ),

            array(
                "title" => "项目类别",
                "key" => "cate",
                "width" =>120,
            ),
            array(
                "title" => "计划总投资(万元)",
                "key" => "gross",
                "width" =>120,
            ),
            array(
                "title" => "累计完成投资(万元)",
                "key" => "all_complete",
                "width" =>120,
            ),
            array(
                "title" => "本年完成投资(万元)",
                "key" => "year_complete",
                "minWidth" => 120,
                "maxWidth"=>200
            ),
            array(
                "title" => "本月完成投资(万元)",
                "key" => "month_complete",
                "minWidth" => 120,
                "maxWidth"=>200
            ),
            array(
                "title" => "土地购置费(万元)",
                "key" => "land_cost",
                "minWidth" => 100,
                "maxWidth"=>160
            ),
            array(
                "title" => "剩余土地购置费(万元)",
                "key" => "left_land_cost",
                "minWidth" => 100,
                "maxWidth"=>160
            ),
            array(
                "title" => "街镇",
                "key" => "town",
                "minWidth" => 80,
                "maxWidth"=>160
            ),
        );
        return array(
            "measure" => "万元",
            "pageInfo"  =>$pageInfo,
            "columns" => $columns,
            "list" => $list,
        );
    }

    
}

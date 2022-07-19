<?php
namespace Admin\Model;

use \Admin\Common\BaseUploadModel;

class TimelineTransportModel extends BaseUploadModel
{
    protected $tableName = 'timeline_transport';
    protected $dataOffset = 4;
    protected $tableField = array(
        "year" => "",
        "month" => "",
        "create_by" => "",
        "data_date" => "",
        "A" => "title",
        "B" => "measure",
        "C" => "gross",
        "D" => "rise",
    );


    public function getList($condition)
    {
        $keyArr = array(
            "jclk" => "珠海机场旅客吞吐量",
            "jchy" => "珠海机场货邮吞吐量",
            "gk" => "高栏港港口吞吐量",
            "gkjzx" => "高栏港集装箱吞吐量",
        );

        $list = $this->field("title,year,month,measure,gross,rise")->where($condition)->select();

        $columns = array(
            array(
                "title" => "年月",
                "key" => "title",
            ),
            array(
                "title" => "总量",
                "key" => "gross",
            ),
            array(
                "title" => "同比(%)",
                "key" => "rise",
            ),
        );
        $newList = array();
        foreach ($list as $key => $val) {
            foreach ($keyArr as $k => $v) {
                if ($val["title"] == $v) {
                    $newList[$k]['title'] = "";
                    $newList[$k]['measure'] = $val["measure"];
                    $newList[$k]['columns'] = $columns;
                    $newList[$k]["list"][] = array(
                        "title" => $val['year'] . "-" . $val["month"],
                        "gross" => $val["gross"],
                        "rise" => $val["rise"],
                    );
                }
            }

        }

        
        return $newList;
    }
}

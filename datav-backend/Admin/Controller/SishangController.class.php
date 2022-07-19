<?php
namespace Admin\Controller;

use Admin\Common\AuthController;

class SishangController extends AuthController
{

    public function get_total()
    {
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );

        $modelName = "ComSishang";
        $model = D($modelName);
        $total = $model->where($where)->count();
        $totalList = $model->field('count(*) as total,cate,town')->where($where)->group('cate,town')->select();
        // $townTotalList = $model->field('count(*) as total,town')->where($where)->group('town')->select();
        // var_dump($totalList);
        // exit();
        $formatData = array();

        $tableData = array();

        $townList = array("三灶", '红旗', "南水", "平沙");
        $cateList = $model->distinct(true)->field('cate')->where($where)->select();
        $list = array();

        foreach ($cateList as $ckey => $cate) {
            $list[$ckey]["name"] = $cate["cate"];
            $list[$ckey]["total"] = 0;
            foreach ($townList as $townKey => $town) {
                $list[$ckey]["town"][$townKey]["name"] = $town;
                $list[$ckey]["town"][$townKey]["total"] = 0;
                foreach ($totalList as $tkey => $total) {
                    if ($total['cate'] == $cate["cate"] && $total["town"] == $town) {
                        $list[$ckey]["total"] += \floatval($total["total"]);
                        $list[$ckey]["town"][$townKey]["total"] = $total["total"];
                    }
                }
            }
        }

        // $backData = array(
        //     "code" => 200,
        //     "data" => array(
        //         "tableColumn" => $tableColumn,
        //         "tableData" => $tableData,
        //     ),
        // );

        $backData = array(
            "code" => 200,
            "data" => array(
                "total" => $total,
                "list" => $list,
            ),
        );

        $this->ajaxReturn($backData);
    }

    public function get_cate()
    {
        $modelName = "ComSishang";
        $model = D($modelName);
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );

        $result = $model->distinct(true)->field("cate")->where($where)->select();
        $cateList = array(
            array("text" => "全部行业", "value" => "全部行业"),
        );
        foreach ($result as $key => $val) {
            $cateList[] = array(
                "text" => $val['cate'],
                "value" => $val["cate"],
            );
        }
        $townList = array(
            array("text" => "金湾区", "value" => ""),
            array("text" => "三灶", "value" => "三灶"),
            array("text" => "红旗", "value" => "红旗"),
            array("text" => "南水", "value" => "南水"),
            array("text" => "平沙", "value" => "平沙"),
        );

        $filterTypeList = array(
            array(
                "key"   =>"cur_gross",
                "title"=>"当月"
            ),
            array(
                "key"   =>"lj_gross",
                "title"=>"本年累计"
            ),
            array(
                "key"   =>"prev_year_gross",
                "title"=>"去年止累计"
            )

        );
        $backData = array(
            "code" => 200,
            "data" => array(
                "cateList" => $cateList,
                "townList" => $townList,
                "filterType"=>$filterTypeList
            ),
        );

        $this->ajaxReturn($backData);
    }

    /**
     *
     */
    public function get_list()
    {
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );

        
        $cate = I("get.cate", '');
        $town = I("get.town", '');
        $comname = I("get.keyword", '');
        $grossFilterType = I("get.gross_filter_type");
        $grossVal = I("get.gross_val", '');
        $grossType = I("get.gross_type", '');
        $riseVal = I("get.rise_val", '');
        $riseType = I("get.rise_type", '');
        $electricVal = I("get.electric_val", '');
        $electricType = I("get.electric_type", '');

        /////////==////
        get_accessauth_for_sishang($this->uid,$cate,$town);
        // exit();

        if ($cate && $cate != '全部行业') {
            $where['cate'] = $cate;
        }
        if ($town && $town != '金湾区') {
            $where['town'] = $town;
        }
        if ($comname) {
            $where['comname'] = array("like", '%' . $comname . '%');
        }

        if ($grossVal !== '' && $grossType) {
            $where[$grossFilterType] = array($grossType, $grossVal);
        }

        if ($riseVal !== '' && $riseType) {
            $where['ls_rise'] = array($riseType, $riseVal);
        }

        if ($electricVal !== '' && $electricType) {
            $where['electric_gross'] = array($electricType, $electricVal);
        }

        $page = I("get.page/d", 1);
        $pageSize = 20;

        $modelName = "ComSishang";
        $model = D($modelName);

        $total = $model->where($where)->fetchSql(false)->count();

        $list = $model
            ->field("comname,cate,IFNULL(cur_gross,'--') as cur_gross,
            IFNULL(lj_gross,'--') as lj_gross,
            IFNULL(prev_year_gross,'--') as prev_year_gross,
            IFNULL(lj_rise,'--') as lj_rise,
            IFNULL(electric_gross,'--') as electric_gross,
            IFNULL(electric_rise,'--') as electric_rise,
            IFNULL(other,'--') as other")
            ->fetchSql(false)
            ->where($where)
            ->page($page, $pageSize)
            ->select();

        $pageInfo = array(
            "page" => $page,
            "pageSize" => $pageSize,
            "total" => $total,
        );

        // total info
        $summaryInfo = array();
        if($cate != '全部行业') {
            $totalInfo = $model
            ->field("SUM(cur_gross) as cur_gross,SUM(lj_gross) as lj_gross,SUM(prev_year_gross) as prev_year_gross,SUM(electric_gross) as electric_gross")
            ->where($where)
            ->select();
            $totalInfo[0]['lj_rise'] = number_format((($totalInfo[0]["lj_gross"] / $totalInfo[0]["prev_year_gross"])-1)*100,1);
    
            foreach($totalInfo[0] as $key=>$val) {
                $summaryInfo[$key] = $val;
            }
        }

        $otherName = "";
        $grossName = "指标";
        $measure = "产值/销售额/营业收入/面积(万元、平方米)";
        switch ($cate) {
            case "工业":
            case "建筑业":
                $grossName = "产值";
                $measure = "万元";
                break;
            case "批发业":
            case "零售业":
                $grossName = "销售额";
                $measure = "万元";
                break;
            case "住宿业":
            case "餐饮业":
                $grossName = "营业收入";
                $measure = "万元";
                break;
            case "服务业":
                $grossName = "营业额";
                $measure = "万元";
                break;
            case "房地产":
                $grossName = "销售面积";
                $measure = "平方米";
                break;

        }
        // $hangyeList = $model->distinct(true)->field("cate")->select();

        $grossColumn = array(
            "title" => $grossName . "(" . $measure . ")",
            "align" => 'center',
            "children" => array(

                array(
                    "title" => "当月",
                    "key" => "cur_gross",
                    "align" => "right",
                ),
                array(
                    "title" => "1-" . intval($this->curMonth) . "月",
                    "key" => "lj_gross",
                    "align" => "right",
                ),
                array(
                    "title" => "去年止累计",
                    "key" => "prev_year_gross",
                    "align" => "right",
                ),
                array(
                    "title" => "累计增速(%)",
                    "key" => "lj_rise",
                ),
            ),
        );
        $electricColumn = 
        array(
            "title" => "用电量(万千瓦时)",
            "align" => "center",
            "children" => array(
                array(
                    "title" => "总量",
                    "key" => "electric_gross",
                    "align" => "right",
                ),
                array(
                    "title" => "增速(%)",
                    "key" => "electric_rise",
                ),
            ),
        );
        $tableColumn = array(
            array(
                "title" => "序号",
                "type" => "index",
                "width" => 70,
            ),
            array(
                "title" => "企业名称",
                "key" => "comname",
                "minWidth" => 120,
                "maxWidth" => 600,
            ),

        );
        if ($cate == "全部行业") {
            $cateColumn = array(
                "title" => "行业",
                "key" => "cate",
                "width" => "80",
            );
            array_push($tableColumn, $cateColumn);
        }
        $tableColumn[] =$grossColumn;
        $tableColumn[] =$electricColumn;
        if ($cate == "工业") {
            $otherColumn = array(
                "title" => "增加值率",
                "key" => "other",
            );
            array_push($tableColumn, $otherColumn);
        }

        if ($cate == "房地产") {
            $otherColumn = array(
                "title" => "房地产项目名称",
                "key" => "other",
            );
            array_push($tableColumn, $otherColumn);
        }

        $titleCate = $cate == '小计' ? "" : "——" . $cate . "(企业总数:" . $total . ")";
        $titleTown = $town;
        $title = $titleTown . "在库'四上'企业情况" . $titleCate;

        $backData = array(
            "code" => 200,
            "data" => array(
                "title" => $title,
                "tips" => "",
                "grossName" => $grossName,
                "measure" => $measure,
                "tableColumn" => $tableColumn,
                "tableData" => $list,
                "pageInfo" => $pageInfo,
                "summaryInfo"=>$summaryInfo
            ),
        );

        $this->ajaxReturn($backData);
    }

}

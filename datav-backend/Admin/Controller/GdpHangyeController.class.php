<?php
namespace Admin\Controller;

use Admin\Common\AuthController;

class GdpHangyeController extends AuthController
{
    protected $modelName = "GdpHangye";

    protected function format_date()
    {
        $month = $this->curMonth;
        $modNum = $month % 3;

        $timestamp = strtotime("-" . $modNum . " months", strtotime($this->curYear . "-" . $month));
        return $timestamp;
    }
    public function upload()
    {

    }

    public function get_data()
    {
        $timestamp = $this->format_date();
        $cate = I("get.cate");
        $where = array(
            "year" => date("Y", $timestamp),
            "month" => date("m", $timestamp),
            "parent_name" => $cate,
        );

        $model = D($this->modelName);
        $list = $model->where($where)->fetchSql(false)->select();

        $formatData[] = ["product", "总量(万元)", "同比", "比重", "GDP贡献", "拉动GDP增长点"];
        foreach ($list as $key => $val) {
            $formatData[] = [$val['title'], $val['gross'], $val['rise'], $val['proportion'], $val['gdp_gx'], $val['gdp_point']];
        }

        $comCate = array(
            array(
                "name" => "农林牧渔业",
            ),
            array(
                "name" => "工业",
                "comCate" => "工业",
            ),
            array(
                "name" => "建筑业",
                "comCate" => "建筑业",
            ),
            array(
                "name" => "批发和零售业",
                "comCate" => array('批发业','零售业'),
            ),
            array(
                "name" => "交通运输、仓储和邮政业",
            ),
            array(
                "name" => "住宿和餐饮业",
                "comCate" => array('住宿业','餐饮业'),
            ),
            array(
                "name" => "金融业业",
            ),
            array(
                "name" => "房地产业",
                "comCate" => "房地产",
            ),
            array(
                "name" => "营利性服务业",
                "comCate" => "服务业",
            ),
            array(
                "name" => "非营利性服务业",
            ),
        );

        $backData = array(
            "code" => 200,
            "data" => array(
                "list" => $formatData,
                "comCate" => $comCate,
            ),
        );

        $this->ajaxReturn($backData);
    }

    /**
     * 行业子类数据
     */
    public function get_child()
    {
        $modelMap = array(
            "农林牧渔业" => 'GdpNongye',
            "批发和零售业" => 'GdpPflszscy',
            "住宿和餐饮业" => 'GdpPflszscy',
            "交通运输、仓储和邮政业" => "GdpServiceHangye",
            "房地产业" => "GdpRealEstate",
            "营利性服务业" => "GdpServiceHangye",
            "非营利性服务业" => "GdpServiceHangye",
        );
        $cate = I("get.cate");
        if (!$cate) {
            $backData = array(
                "code" => 130001,
                "msg" => "参数错误",
            );
            $this->ajaxReturn($backData);
        }

        if (!\in_array($cate, array_keys($modelMap))) {
            $backData = array(
                "code" => 130001,
                "msg" => "数据更新中",
            );
            $this->ajaxReturn($backData);
        }

        // 分发到不同模型
        $timestamp = $this->format_date();
        $cateMeasure = '万元';
        switch ($cate) {
            case "农林牧渔业":
                $where = array(
                    "year" => date("Y", $timestamp),
                    "month" => date("m", $timestamp),
                );
                $model = D("GdpNongye");
                break;
            case "批发和零售业":
                $where = array(
                    "year" => $this->curYear,
                    "month" => $this->curMonth,
                    "parent_name" => "批发零售业",
                );
                $cateMeasure = "亿元";
                $model = D("GdpPflszscy");
                break;
            case "住宿和餐饮业":
                $where = array(
                    "year" => $this->curYear,
                    "month" => $this->curMonth,
                    "parent_name" => "住宿餐饮业",
                );
                $cateMeasure = "亿元";
                $model = D("GdpPflszscy");
                break;
            case "交通运输、仓储和邮政业":
            case "营利性服务业":
            case "非营利性服务业":
                $where = array(
                    "year" => $this->curYear,
                    "month" => $this->curMonth,
                    "parent_name" => $cate,
                );
                $model = D("GdpServiceHangye");
                break;
            case "房地产业":
                $where = array(
                    "year" => $this->curYear,
                    "month" => $this->curMonth,
                    "parent_name" => "一级",
                );
                $cateMeasure = "万平方米";
                $model = D("GdpRealEstate");
                break;

        }
        $childData = $model->getList($where);

        //各镇数据
        $townWhere = array(
            "year"  =>$this->curYear,
            "month" =>$this->curMonth
        );
        $townDataTwo = null;
        $townModel = D("EconomyTown");
        if($cate =='批发和零售业') {
            $townWhere['title'] = "限额以上批发业销售额";
            $townData = $townModel->getList($townWhere);

            $townWhere['title'] = '限额以上零售业销售额';
            $townDataTwo = $townModel->getList($townWhere);
        }elseif($cate == '住宿和餐饮业') {
            $townWhere['title'] = "限额以上住宿业营业额";
            $townData = $townModel->getList($townWhere);

            $townWhere['title'] = '限额以上餐饮业营业额';
            $townDataTwo = $townModel->getList($townWhere);
        }elseif($cate == '营利性服务业') {
            $townWhere['title'] = "营利性服务业营业收入";
            $townData = $townModel->getList($townWhere);
        }elseif($cate == '房地产业'){
            $townWhere['title'] = "商品房销售面积";
            $townData = $townModel->getList($townWhere);
        }else {
            $townWhere['title'] = $cate;
            $townData = $townModel->getList($townWhere);
        }


        //各区数据
        $countyWhere = array(
            "year"  =>$this->curYear,
            "month" =>$this->curMonth,
        );
        if($cate == '房地产业') {
            $countyWhere['title'] = '商品房销售面积';
        }else {
            $countyWhere['title'] = $cate;
        }

        $countyData = D("EconomyCounty")->getList($countyWhere);


        // 近一年数据
        $startMonth = date("Y-m", strtotime('-12 months', strtotime($this->curYear . '-' . $this->curMonth)));
        $monthWhere = array(
            "data_date" => array('egt', $startMonth),
            "title" => $cate,
        );
        $monthList = M("GdpHangye")
        ->field("CONCAT(year,'年1-',month) as date,gross,rise")
        ->where($monthWhere)
        ->order('data_date asc')
        ->select();
        $monthColumns = array(
            array(
                "title" => "年月",
                "key" => "date",
            ),
            array(
                "title" => "总量(万元)",
                "key" => "gross",
            ),
            array(
                "title" => "同比(%)",
                "key" => "rise",
            ),
        );

        $cateData = array(
            "title"=>"",
            "list"=>$childData["list"]
        );
        $backData = array(
            "code" => 200,
            "msg" => "success",
            "data" => array(
                "title" => $cate,
                "cateData"=>$cateData,
                'countyData' =>$countyData,
                "monthData"=>array(
                    "title"=>'近一年'.$cate.'累计增速',
                    "list"=>$monthList,
                    "columns"=>$monthColumns
                ),
                "townData"=>$townData,
                "townDataTwo"=>$townDataTwo,
                
            ),
        );
        $this->ajaxReturn($backData);

    }

}

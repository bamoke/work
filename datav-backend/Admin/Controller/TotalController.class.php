<?php
namespace Admin\Controller;

use Admin\Common\AuthController;

class TotalController extends AuthController
{

    public function upload()
    {

    }

    public function get_data()
    {
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );
        $cate = I("get.cate");

        // 经济总览全部指标
        if ($cate == "all") {
            return $this->get_all();
        }

        $model = D("Total");
        if ($cate == "地区生产总值") {
            // 单独获取地区生产总值数据
            $gdpYear = idate("Y", $this->format_gdp_timestamp());
            $gdpMonth = idate("m", $this->format_gdp_timestamp());
            $gdpWhere = array(
                "year" => $gdpYear,
                "month" => $gdpMonth,
                "title" => "地区生产总值",
            );
            $info = $model
            ->field("CONCAT(title,'".$gdpYear.'年1-'.$gdpMonth."月') as title,
            IFNULL(jw_gross,'--') as jw_gross,
            IFNULL(jw_rise,'--') as jw_rise,
            IFNULL(zs_gross,'--') as zs_gross,
            IFNULL(zs_rise,'--') as zs_rise,
            IFNULL(kfq_gross,'--') as kfq_gross,
            IFNULL(kfq_rise,'--') as kfq_rise,
            measure
            ")
            ->where($gdpWhere)
            ->fetchSql(false)
            ->find();
        }else {

            $where["title"] = $cate;
    
            $info = $model->field("title,
            IFNULL(jw_gross,'--') as jw_gross,
            IFNULL(jw_rise,'--') as jw_rise,
            IFNULL(zs_gross,'--') as zs_gross,
            IFNULL(zs_rise,'--') as zs_rise,
            IFNULL(kfq_gross,'--') as kfq_gross,
            IFNULL(kfq_rise,'--') as kfq_rise,
            measure
            ")->where($where)->find();
        }
        $formatData = array(
            "jw" => array(
                "title" => $info["title"],
                "area"=>"金湾区",
                "gross" => $info['jw_gross'],
                "rise" => $info['jw_rise'],
                "measure" => $info['measure'],
            ),
            "zs" => array(
                "title" => $info["title"],
                "area"=>"金湾直属",
                "gross" => $info['zs_gross'],
                "rise" => $info['zs_rise'],
                "measure" => $info['measure'],
            ),
            "kfq" => array(
                "title" => $info["title"],
                "area"=>"经济开发区",
                "gross" => $info['kfq_gross'],
                "rise" => $info['kfq_rise'],
                "measure" => $info['measure'],
            ),
        );



        $backData = array(
            "code" => 200,
            "data" => $formatData,
        );

        $this->ajaxReturn($backData);
    }

    /**
     * 获取金湾区所有指标
     */
    public function get_all()
    {
        $filterFieldIcon = array(
            "地区生产总值" => "./assets/icon/icon-gdp.png",
            "规模以上工业增加值" => "./assets/icon/icon-gongye-zjz.png",
            "规模以上工业总产值" => "./assets/icon/icon-gongye-zcz.png",
            "全社会固定资产投资" => "./assets/icon/icon-investment-fixed.png",
            "外贸进出口总额" => "./assets/icon/icon-waimao.png",
            "实际吸收外商投资" => "./assets/icon/icon-waishangtouzi.png",
            "社会消费品零售总额" => "./assets/icon/icon-xiaofei.png",
            "一般公共预算收入" => "./assets/icon/icon-shouru.png",
            "一般公共预算支出" => "./assets/icon/icon-zhichu.png",
            "珠海机场旅客吞吐量" => "./assets/icon/icon-jichang-lvke.png",
            "珠海机场货邮吞吐量" => "./assets/icon/icon-jichang-huoyou.png",
            "高栏港港口吞吐量" => "./assets/icon/icon-gangkou.png",
        );
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
            "title" => array("in", array_keys($filterFieldIcon)),
        );
        $model = D("Total");
        $gdpYear = idate("Y", $this->format_gdp_timestamp());
        $gdpMonth = idate("m", $this->format_gdp_timestamp());
        $list = $model
            ->field("title,measure,jw_gross as gross,jw_rise as rise, before_last_rise,two_year_rise")
            ->where($where)
            ->fetchSql(false)
            ->select();

        foreach ($list as $key => $val) {
            if ($val["title"] == '地区生产总值') {
                $list[$key]["title"] = $val["title"] . $gdpYear . '年1-' . $gdpMonth . '月';
            }
            $list[$key]['icon'] = $filterFieldIcon[$val['title']];
        }
        $backData = array(
            "code" => 200,
            "data" => array(
                "beforeLastYear" => "2019",
                "list" => $list,
            ),
        );

        $this->ajaxReturn($backData);
    }

    /**
     * 各镇的所有指标
     */
    public function get_all_by_town()
    {
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );
        $model = D("EconomyTown");
        $gdpMonth = idate("m", $this->format_gdp_timestamp());
        $list = $model
            ->field("title,measure,sz_gross,sz_rise,hq_gross,hq_rise,ns_gross,ns_rise,ps_gross,ps_rise")
            ->where($where)
            ->fetchSql(false)
            ->order("id asc")
            ->select();

        $columns = array();
        foreach($list as $key=>$val) {
            if($val["measure"] == '万元') {
                $list[$key]['sz_gross'] = \intval($val["sz_gross"]);
                $list[$key]['hq_gross'] = \intval($val["hq_gross"]);
                $list[$key]['ns_gross'] = \intval($val["ns_gross"]);
                $list[$key]['ps_gross'] = \intval($val["ps_gross"]);
            }
        }
        $backData = array(
            "code" => 200,
            "data" => array(
                "columns" => $columns,
                "list" => $list,
            ),
        );

        $this->ajaxReturn($backData);
    }

    /**
     * 全国、广东省、珠海市的所有指标
     */
    public function get_all_by_country()
    {
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );
        $model = D("WholeCountry");

        $gdpMonth = idate("m", $this->format_gdp_timestamp());

        $list = $model
            ->field("title,measure,IFNULL(country_gross,'--') as country_gross,country_rise,IFNULL(province_gross,'--') as province_gross,province_rise,IFNULL(city_gross,'--') as city_gross,city_rise")
            ->where($where)
            ->fetchSql(false)
            ->order("id asc")
            ->select();

        $columns = array();
        $backData = array(
            "code" => 200,
            "data" => array(
                "columns" => $columns,
                "list" => $list,
            ),
        );

        $this->ajaxReturn($backData);
    }

    /**
     * 各区的所有指标
     */
    public function get_all_by_county()
    {
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );
        $model = D("EconomyCounty");

        // 所有指标名称
        $titleArr = $model->field("distinct title,measure")->where($where)->select();

        // 单独获取地区生产总值数据
        $gdpYear = idate("Y", $this->format_gdp_timestamp());
        $gdpMonth = idate("m", $this->format_gdp_timestamp());
        $gdpWhere = array(
            "year" => $gdpYear,
            "month" => $gdpMonth,
            "title" => "地区生产总值",
        );
        $gdpData = $model
            ->field("title,measure,county,gross,rise,proportion,zs_ranking")
            ->where($gdpWhere)
            ->fetchSql(false)
            ->select();

        // 过滤掉地区生产总值
        $where["title"] = array("neq", "地区生产总值");
        $listAll = $model
            ->field("title,measure,county,gross,rise,proportion,zs_ranking")
            ->where($where)
            ->fetchSql(false)
            ->select();

        $listAll = array_merge($gdpData, $listAll);
        $list = array();

        foreach ($titleArr as $key => $val) {
            $tempArr = $val;
            if ($val["title"] == '地区生产总值') {
                $yearText = "";
                $monthText = "";
                if ($gdpYear != $this->curYear) {
                    $yearText = $gdpYear . "年";
                }
                if ($yearText == "") {
                    $monthText = "1-" . $gdpMonth . "月";
                }
                $tempArr["title"] = "地区生产总值(" . $yearText . $monthText . ")";
            }
            foreach ($listAll as $k => $v) {
                if ($v["title"] == $val["title"]) {
                    $tempArr["child"][] = array(
                        "county" => $v['county'],
                        "gross" => $v['gross'],
                        "rise" => $v['rise'],
                        "proportion" => $v['proportion'],
                        "zs_ranking" => $v['zs_ranking'],
                    );
                }
            }
            $list[] = $tempArr;
        }

        $columns = array();
        $backData = array(
            "code" => 200,
            "data" => array(
                "columns" => $columns,
                "list" => $list,
            ),
        );

        $this->ajaxReturn($backData);
    }

    /**
     * 机场
     */
    public function get_data_for_transport()
    {
        $cate = I("get.cate");
        $keyArr = array(
            "jclk" => "珠海机场旅客吞吐量",
            "jchy" => "珠海机场货邮吞吐量",
            "gk" => "高栏港港口吞吐量",
            "jzx" => "高栏港集装箱吞吐量",
        );
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );

        if($cate == 'transport') {
            $where["title"] = array("in", array_values($keyArr));
        }else {
            $where["title"] = array("like", $cate . "%");
        }
        $model = D("Total");
        $list = $model->where($where)->select();
        $newList = array();
        foreach ($list as $key => $val) {
            foreach ($keyArr as $k => $v) {
                if ($val["title"] == $v) {
                    $newList[$k] = array(
                        "title" => $val["title"],
                        "measure" => $val["measure"],
                        "gross" => $val["jw_gross"],
                        "rise" => $val["jw_rise"],
                    );
                }
            }
        }
        $backData = array(
            "code" => 200,
            "data" => $newList,
        );

        $this->ajaxReturn($backData);
    }

    /**
     * gpd 年月取3月6月9月12月
     */
    protected function format_gdp_timestamp()
    {
        $month = $this->curMonth;
        $modNum = $month % 3;

        $timestamp = strtotime("-" . $modNum . " months", strtotime($this->curYear . "-" . $month));
        return $timestamp;
    }
}

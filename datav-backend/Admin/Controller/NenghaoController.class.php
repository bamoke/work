<?php
namespace Admin\Controller;

use Admin\Common\AuthController;

class NenghaoController extends AuthController
{

    public function upload()
    {

    }

    /**
     * 用电量
     */
    public function get_electric()
    {
        $cate = I("get.cate"); //指标名称
        $parentName = I("get.parent");

        $modelName = "Electric";
        $model = D($modelName);

        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );
        if ($cate) {
            $where["title"] = $cate;
        }
        if ($parentName) {
            $where["parent_name"] = $parentName;
        }
        $result = $model->getList($where);

        $backData = array(
            "code" => 200,
            "data" => $result[0],
        );

        $this->ajaxReturn($backData);

    }

    /**
     * 用电量
     */
    public function get_electric_all()
    {

        $modelName = "Electric";
        $model = D($modelName);

        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
            "parent_name" => "全社会",
        );

        $result = $model->getList($where);

        $list = array();
        foreach ($result as $key => $val) {
            if ($val['title'] == '工业用电量') {
                $k = 'gy';
            } else {
                $k = 'fgy';
            }
            $list[$k] = $val;
        }
        $backData = array(
            "code" => 200,
            "data" => $list,
        );

        $this->ajaxReturn($backData);

    }

    /**
     * GDP能耗
     */
    public function get_gdp_nenghao()
    {
        $cate = I("get.cate"); //指标名称

        $modelName = "GdpNenghao";
        $model = D($modelName);

        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );
        if ($cate) {
            $where["title"] = $cate;
        }

        $result = $model->getList($where);

        $backData = array(
            "code" => 200,
            "data" => $result[0],
        );

        $this->ajaxReturn($backData);

    }

    /**
     * 能源消费
     * @type [all,swl,bzl]
     */
    public function get_nengyuan_use($type = "all")
    {

        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
            "title" => array('neq', "合计"),
        );
        if ($type == 'all') {
            $swlResult = D("NengyuanUseSwl")->getList($where);
            $bzlResult = D("NengyuanUseBzl")->getList($where);
        }

        $backData = array(
            "code" => 200,
            "data" => array(
                "swl" => $swlResult,
                "bzl" => $bzlResult,
            ),
        );

        $this->ajaxReturn($backData);

    }

    /**
     * pub
     * 工业增加值、用电量、能源消耗比较
     */
    public function get_rise_compare()
    {
        $startDate = date("Y-m-d", strtotime("-1 year", date_timestamp_get($this->curDateObj)));
        $endDate = date("Y-m-d", date_timestamp_get($this->curDateObj));
        $where = array(
            "data_date" => array(array('egt', $startDate),array('elt',$endDate)),
        );
        $field = "CONCAT(year,'年',month,'月') as month,jw_rise as rise";
        $orderBy = "data_date asc";
        $gongyeList = M("IndustryZjz")->field($field)->where($where)->where(array("title" => "工业增加值"))->order($orderBy)->select();
        $electricList = M("Electric")->field($field)->where($where)->where(array("title" => "规上工业用电量"))->order($orderBy)->select();
        $nenghaoList = M("GdpNenghao")->field($field)->where($where)->where(array("title" => "规上工业能源消费总量"))->order($orderBy)->select();

        $monthList = array();

        foreach ($gongyeList as $key => $val) {
            $monthList[] = $val["month"];
        }

        $list = [
            ["product","工业增加值增速","用电量增速","能源消耗增速"]
        ];
        foreach ($monthList as $month) {
            $tempArray = [$month];
            //
            foreach ($gongyeList as $key => $val) {
                if ($val["month"] == $month) {
                    $tempArray[] = $val["rise"];
                    break;
                }
            }

            //
            foreach ($electricList as $key => $val) {
                if ($val["month"] == $month) {
                    $tempArray[] = $val["rise"];
                    break;
                }
            }

            //
            foreach ($nenghaoList as $key => $val) {
                if ($val["month"] == $month) {
                    $tempArray[] = $val["rise"];
                    break;
                }
            }
            $list[] = $tempArray;
        }
        
        $backData = array(
            "code" => 200,
            "msg" => "success",
            "data" => $list,
        );
        $this->ajaxReturn($backData);
    }

}

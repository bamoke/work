<?php
namespace Admin\Controller;

use Admin\Common\AuthController;

/**
 * 固定资产投资
 */
class InvestmentFixedController extends AuthController
{

    public function upload()
    {

    }

    public function get_com_list()
    {
        $cate = I("get.cate");

        $modelName = "ComInvestment";
        $model = D($modelName);

        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );

        $filterTypeList = array(
            array(
                "key" => "gross",
                "title" => "计划总投资",
            ),
            array(
                "key" => "all_complete",
                "title" => "累计完成投资",
            ),
            array(
                "key" => "year_complete",
                "title" => "本年度完成投资",
            ),
            array(
                "key" => "month_complete",
                "title" => "本月完成投资",
            ),

        );

        $curFilterType = I("get.filter_type");
        $grossType = I("get.gross_type");
        $grossVal = I("get.gross_val");
        $keyword = I("get.keyword", '');
        $town = I("get.town");

        ////////////
        if($cate == '全部类别') {

            $cate = get_default_cate_for_touzi($this->uid);
        }

        if($town == '所有街镇') {
            $town = get_default_town_for_touzi($this->uid);
        }

        get_accessauth_for_touzi($this->uid, $cate, $town);

        if ($cate && $cate != '全部类别') {
            $where['cate'] = array("like", "%" . $cate . "%");
        }
        if ($grossVal !== '' && $grossType) {
            $where[$curFilterType] = array($grossType, $grossVal);
        }
        if ($town && $town !== '所有街镇') {
            $where["town"] = $town;
        }

        if ($keyword) {
            $keyWhere['comname'] = array("like", '%' . $keyword . '%');
            $keyWhere['project_name'] = array("like", '%' . $keyword . '%');
            $keyWhere["_logic"] = 'OR';
            $where["_complex"] = $keyWhere;
        }

        $result = $model->getList($where);

        $title = "固定资产投资项目情况——" . $town . "—" . $cate . "(总数:" . $result["pageInfo"]['total'] . "条)";
        $backData = array(
            "code" => 200,
            "data" => array_merge(array("title" => $title, "curTown" => $town, "curCate" => $cate, "filterTypeList" => $filterTypeList), $result),
        );

        $this->ajaxReturn($backData);

    }

    public function get_cate_total()
    {
        $modelName = "InvestmentFixed";
        $model = D($modelName);
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
            "cate_key" => I("get.cate"),
        );
        $result = $model->getList($where);
        $backData = array(
            "code" => 200,
            "data" => array_merge(array("title" => ""), $result),
        );

        $this->ajaxReturn($backData);

    }

    public function get_cate()
    {

        $modelName = "InvestmentFixed";
        $model = D($modelName);
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
            "cate_key" => 2,
        );

        $cateList = array(
            array(
                "text" => "全部类别",
                "value" => '全部类别',
            ),
        );
        $result = $model->distinct(true)->field("title")->where($where)->select();
        foreach ($result as $key => $val) {
            $cateList[] = array(
                "text" => $val["title"],
                "value" => rtrim($val['title'], "投资"),
            );
        }
        $townList = array(
            array("text" => "所有街镇", "value" => "所有街镇"),
            array("text" => "三灶镇", "value" => "三灶"),
            array("text" => "红旗镇", "value" => "红旗"),
            array("text" => "南水镇", "value" => "南水"),
            array("text" => "平沙镇", "value" => "平沙"),
        );
        $backData = array(
            "code" => 200,
            "data" => array(
                "cateList" => $cateList,
                "townList" => $townList,
            ),
        );
        $this->ajaxReturn($backData);
        // $this->ajaxReturn($backData);
    }

}

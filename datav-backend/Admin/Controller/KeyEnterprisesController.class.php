<?php
/**
 * 重点企业经营情况
 */
namespace Admin\Controller;

use Admin\Common\AuthController;

// use Think\Controller;

class KeyEnterprisesController extends AuthController
{

    protected $modelName = 'ComKey';

    public function get_cate()
    {
        $model = D($this->modelName);
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );
        $cateList = array();
        $result = $model->distinct(true)->field("cate")->where($where)->select();
        foreach ($result as $key => $val) {
            $cateList[] = array(
                "text" => $val['cate'],
                "value" => $val["cate"],
            );
        }

        $backData = array(
            "code" => 200,
            "data" => array(
                "cateList" => $cateList,
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

        $defaultCate = get_default_cate_for_zhongdian($this->uid);
        $cate = I("get.cate");

        // var_dump($this->uid);

        //////
        get_accessauth_for_zhongdian($this->uid,$cate);
        ////////

        $comname = I("get.keyword", '');
        $grossVal = I("get.gross_val", '');
        $grossType = I("get.gross_type", '');
        $riseVal = I("get.rise_val", '');
        $riseType = I("get.rise_type", '');

        if ($cate && $cate != '全部行业') {
            $where['cate'] = $cate;
        }

        if ($comname) {
            $where['comname'] = array("like", '%' . $comname . '%');
        }

        if ($grossVal !== '' && $grossType) {
            $where['cur_gross'] = array($grossType, $grossVal);
        }

        if ($riseVal !== '' && $riseType) {
            $where['rise'] = array($riseType, $riseVal);
        }

        $page = I("get.page/d", 1);
        $pageSize = 20;

        $model = D($this->modelName);

        $total = $model->where($where)->count();
        $list = $model
            ->field("id,comname,cate,
            IFNULL(cur_gross,'--') as cur_gross,
            IFNULL(rise,'--') as rise,
            IFNULL(before_last_rise,'--') as before_last_rise,
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

        $otherName = "";
        $grossName = "";
        $measure = "万元";
        switch ($cate) {
            case "工业":
            case "建筑业":
                $grossName = "产值";
                break;
            case "批发":
            case "零售":
                $grossName = "销售额";
                break;
            case "住宿":
            case "餐饮":
                $grossName = "营业收入";
                break;
            case "服务业":
                $grossName = "营业额";
                break;
            case "房地产":
                $grossName = "销售面积";
                $measure = "万平方米";
                break;
            case "全部行业":
                $grossName = "量|值";
                break;
        }
        // $hangyeList = $model->distinct(true)->field("cate")->select();
        $grossColumn = array(
            "title" => $grossName . "(" . $measure . ")",
            "align" => 'center',
            "children" => array(
                array(
                    "title" => "1-" . intval($this->curMonth) . "月累计",
                    "key" => "cur_gross",
                    "minWidth" => 100,
                    "maxWidth" => 200,
                    "align" => "right",
                ),
                array(
                    "title" => "同比(%)",
                    "key" => "rise",
                    "minWidth" => 100,
                    "maxWidth" => 200,
                ),

            ),
        );
        $electricColumn = array(
            "title" => "用电量(万千瓦时)",
            "align" => 'center',
            "children" => array(
                array(
                    "title" => "总量",
                    "key" => "electric_gross",
                    "align" => "right",
                    "minWidth" => 80,
                    "maxWidth" => 200,
                ),
                array(
                    "title" => "增速",
                    "key" => "electric_rise",
                    "minWidth" => 100,
                    "maxWidth" => 200,
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
                "minWidth" => 180,
                "maxWidth" => 600,
            ),

        );

        if ($this->curYear == '2021') {
            $grossColumn['children'][] = array(
                "title" => "较2019年同期增长(%)",
                "key" => "before_last_rise",
                "minWidth" => 120,
                "maxWidth" => 200,
            );
        }
        $tableColumn[] = $grossColumn;
        $tableColumn[] = $electricColumn;

        if ($cate == '工业') {
            $tableColumn[] = array(
                "title" => "增加值率",
                "minWidth" => 120,
                "maxWidth" => 320,
                "key" => "other",
            );
        }

        if ($cate == '房地产') {
            $tableColumn[] = array(
                "title" => "项目名称",
                "minWidth" => 120,
                "maxWidth" => 320,
                "key" => "other",
            );
        }

        $tableColumn[] = array(
            "title" => "情况说明",
            "fixed" => "right",
            "width" => 100,
            "slot" => 'view',
        );

        $backData = array(
            "code" => 200,
            "data" => array(
                "measure" => $measure,
                "grossName" => $grossName,
                "tableColumn" => $tableColumn,
                "tableData" => $list,
                "pageInfo" => $pageInfo,
            ),
        );

        $this->ajaxReturn($backData);
    }

    /**
     *
     */
    public function get_list_by_map()
    {
        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
            "_string" => "lng IS NOT NULL",
        );

        $page = I("get.page/d", 1);
        $pageSize = 200;

        $model = D($this->modelName);

        $total = $model->where($where)->count();
        $list = $model
            ->field("id,comname,cate,lng,lat")
            ->fetchSql(false)
            ->where($where)
            ->page($page, $pageSize)
            ->select();
        $pageInfo = array(
            "page" => $page,
            "pageSize" => $pageSize,
            "total" => $total,
        );

        $backData = array(
            "code" => 200,
            "data" => array(
                "list" => $list,
                "pageInfo" => $pageInfo,
            ),
        );

        $this->ajaxReturn($backData);
    }

    /**
     *
     */
    public function get_detail()
    {
        $id = I("get.id");
        if (!$id) {
            $backData = array(
                "code" => 130001,
                "errmsg" => "参数错误",
            );
            $this->ajaxReturn($backData);
        }
        $model = D($this->modelName);
        $info = $model
            ->field("id,comname,cate,
        IFNULL(cur_gross,'--') as gross,
        IFNULL(rise,'--') as rise,
        IFNULL(before_last_rise,'--') as before_last_rise,
        IFNULL(electric_gross,'--') as electric_gross,
        IFNULL(electric_rise,'--') as electric_rise,
        IFNULL(other,'--') as other,description")
            ->find($id);

        $otherName = "";
        $grossName = "";
        $measure = "万元";
        switch ($info["cate"]) {
            case "工业":
            case "建筑业":
                $grossName = "产值";
                break;
            case "批发":
            case "零售":
                $grossName = "销售额";
                break;
            case "住宿":
            case "餐饮":
                $grossName = "营业收入";
                break;
            case "服务业":
                $grossName = "营业额";
                break;
            case "房地产":
                $grossName = "销售面积";
                $measure = "万平方米";
                break;
        }

        if ($info['cate'] == '工业') {
            $otherName = '增加值率';
        } elseif ($info['cate'] == '房地产') {
            $otherName = '项目名称';
        }

        $backData = array(
            "code" => 200,
            "msg" => "success",
            "data" => array(
                "info" => $info,
                "grossName" => $grossName,
                "otherName" => $otherName,
                "measure" => $measure,
            ),
        );
        $this->ajaxReturn($backData);
    }



}

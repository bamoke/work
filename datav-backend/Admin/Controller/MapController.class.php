<?php
/**
 * 重点企业经营情况
 */
namespace Admin\Controller;

use Think\Controller;

class MapController extends Controller {


        /**
     *
     */
    public function update()
    {
        $year = I("get.year");
        $month = I("get.month");
        $where = array(
            "year" => $year,
            "month" => $month,
            "_string" => "lng is null",
        );
        $list = M("ComKey")->field("distinct comname,id,lng,lat")->where($where)->select();
        $total = count($list);
        $this->assign("list", $list);
        $this->assign("total", $total);
        $this->display("/keycom/update");
    }

    // 通过公司名称自动获取坐标
    public function auto_zuobiao()
    {
        $comname = I("post.comname");
        $id = I("post.id");

        $findWhere = array(
            "comname" => $comname,
            "_string" => "lng is not null",
        );
        $findResult = M("ComKey")->where($findWhere)->fetchSql(false)->find();
        if (!$findResult) {
            $backData = array(
                "status" => 0,
                "msg" => "无此企业坐标",
            );
            $this->ajaxReturn($backData);
        }

        $updateData = array(
            "lng" => $findResult["lng"],
            "lat" => $findResult["lat"],
        );
        $updateResult = M("ComKey")->data($updateData)->where(array("id" => $id))->fetchSql(false)->save();
        if ($updateResult) {
            $backData = array(
                "status" => 1,
            );
        } else {
            $backData = array(
                "status" => 0,
                "msg" => "更新失败",
            );
        }
        $this->ajaxReturn($backData);
    }

    public function do_update()
    {
        if ($_POST['zuobiao']) {
            $zuobiao = explode(",", I('post.zuobiao'));
            $updateData = array(
                "lng" => $zuobiao[0],
                "lat" => $zuobiao[1],
            );
            $where = array(
                "comname" => I("post.comname"),
            );
            $result = M("ComKey")->data($updateData)->where($where)->fetchSql(false)->save();
            if ($result) {
                $backData = array(
                    "status" => 1,
                );
            } else {
                $backData = array(
                    "status" => 0,
                    "msg" => "更新失败",

                );
            }
            $this->ajaxReturn($backData);

        } else {
            return $this->auto_zuobiao();
        }

    }
}
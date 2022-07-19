<?php
/*
 * @Author: Joy wang
 * @Date: 2021-02-16 21:47:06
 * @LastEditTime: 2021-02-28 09:41:04
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 */



namespace Manage\Controller;
use Manage\Common\Auth;

class DataTableController extends Auth
{

    /***View  Index**/
    public function getlist(){
        $tableArr = array(
            "total" => "主要经济指标总表",
            "industry_zcz" => "规模以上工业总产值及销售产值",
            "industry_zjz" => "规模以上工业增加值",
            "industry_hangye_zcz" => "规模以上工业分行业工业总产值",
            "industry_hangye_zjz" => "规模以上工业分行业工业增加值",
            "industry_benefit" => "规模以上工业经济效益",
            "industry_pillar_zcz" => "重点支柱产业工业总产值",
            "industry_pillar_zjz" => "重点支柱产业工业增加值",
            "industry_xdmy_zcz" => "现代产业和规上民营工业企业总产值",
            "industry_xdmy_zjz" => "现代产业和规上民营工业企业增加值",
            "economy_county" => "各区主要经济指标",
            "economy_town" => "各镇主要经济指标",
            "economy_domestic" => "金湾区与国内部分区域主要指标对比表",
            "whole_country"=>"国家、省、市主要经济指标",
            "electric" => "全社会用电量情况",
            "timeline_year" => "主要经济指标时间系列（年）",
            "timeline_month" => "主要经济指标时间系列（月）",
            "timeline_transport" => "机场港口时间系列（月）",
            "nengyuan_use_swl" => "能源品种实物量消费情况",
            "nengyuan_use_bzl" => "能源品种标准量消费情况",
            "gdp_hangye" => "金湾区地区生产总值分行业情况",
            "gdp_nongye" => "金湾区农业总产值完成情况表",
            "gdp_real_estate" => "房地产开发与经营",
            "gdp_pflszscy" => "限额以上批发零售业、住宿餐饮业",
            "gdp_service_hangye" => "规模以上服务业分行业营业收入",
            "gdp_chanye_history" => "金湾区历年三次产业比重",
            "com_sishang" => "金湾区（开发区）四上企业情况表",
            "com_pillar" => "重点支柱产业企业情况表",
            "com_key" => "金湾区（珠海经济技术开发区）重点企业经营情况",
            "gdp_nenghao"   =>"GDP能耗及规上工业能源消费情况",
            "com_investment"=>"金湾区（开发区）固定资产项目情况",
            "investment_fixed"=>"固定资产投资完成情况",
            "finance"=>"一般公共预算收入和支出情况",
            "harbour_goods"=>"高栏港港口吞吐量分类统计情况",
        );

        $backList =array();
        foreach($tableArr as $key=>$val) {
            $where = array(
                "table_name"=>C("DB_PREFIX").$key
            );
            $result = M("TableDate")->field("year,month")->where($where)->order("year desc,month desc")->limit(1)->fetchSql(false)->select();
            $backList[]=array(
                "key"   =>$key,
                "name"=>$val,
                "date"=>$result[0]['year'].'年'.$result[0]['month'].'月'
            );
        }
        $backData = array(
            'code'      => 200,
            "msg"       => "ok",
            'data'      => array(
                "list"  =>$backList,
            )
        );
        $this->ajaxReturn($backData);
    }


    /***View  edit user page**/
    public function edit($id){
        $outData['script']= CONTROLLER_NAME."/add";
        $model = M('user');
        $result = $model->field('id,username,email,realname')->where('id='.$id)->find();
        $outData['info'] = $result;
        $this->assign("pageName",'编辑用户');
        $this->assign('output',$outData);
        $this->display();
    }


    /***action***/
    public function save(){
        $postData = $this->requestData;
        if(IS_POST){
            $model = D('Admin');
            if($model->create($postData)){
                if(empty($postData['id'])) {
                    $model->password = md5($postData['password']);
                    $result = $model->add();
                    $userId = $result;
                }else {
                    $userId = $postData['id'];
                    $where = array(
                        "id"    =>$userId
                    );
                    $result = $model->where($where)->fetchSql(false)->save();
                }
                if($result !== false){
                    $userInfo = $model
                    ->alias("U")
                    ->join("__ADMIN_GROUPS__ as G on U.group_id = G.id","LEFT")
                    ->field("U.id,U.username,U.realname,U.group_id,Date(U.create_time) as create_time,U.status,G.name as group_name")
                    ->where("U.id=$userId")
                    ->fetchSql(false)
                    ->find();
                    $backData = array(
                        'code'      => 200,
                        "msg"       => "ok",
                        'info'      => $userInfo
                    );
                    $this->ajaxReturn($backData);
                }
            }else {
                $backData = array(
                    'code'      => 13001,
                    "msg"       => "数据参数错误"
                );
                $this->ajaxReturn($backData);
            }
  
        }

    }

    public function deleteone(){
        if(empty($_GET["id"])){
            $backData = array(
                'code'      => 13001,
                "msg"       => "参数未定义"
            );
        }else {
            $id = $_GET['id'];
            $result = M("Admin")->delete($id);
            if($result !== false) {
                $backData = array(
                    'code'      => 200,
                    "msg"       => "ok"
                );
            }else {
                $backData = array(
                    'code'      => 13001,
                    "msg"       => "服务器错误"
                );
            }
        }
        $this->ajaxReturn($backData);  
    }

    public function update(){
        $backData = array();
        if(IS_POST){
            $model = D('Admin');
            if($model->create($_POST,2)){
                $result = $model->save();
                if($result === false){
                    $backData['status'] = 0;
                    $backData['info'] = $model->getError();
                }elseif ($result === 0){
                    $backData['status'] = 1;
                    $backData['info'] = "没有变动";
                }else {
                    $backData['status'] = 1;
                    $backData['info'] = 'ok';
                }
                $this->ajaxReturn($backData);
            }
        }

    }

    /**密码重置**/
    public function reset($id){
        $model = M('Admin');
        $data=array('password'=>md5('123456'));
        $result = $model->where('id = '.$id)->save($data);
        if($result){
            $this->ajaxReturn(array('status'=>1,'info'=>'success'));
        }else {
            $this->ajaxReturn(array('status'=>0,'info'=>$model->getError()));
        }
    }

    /***禁用***/
    public function disable($id,$v){
        $model = M('Admin');
        $data = array('status'=>$v);
        $result = $model->where('id = '.$id)->save($data);
        if($result){
            $this->ajaxReturn(array('status'=>1,'info'=>'success'));
        }else {
            $this->ajaxReturn(array('status'=>0,'info'=>$model->getError()));
        }
    }



}
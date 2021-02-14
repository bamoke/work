<?php
namespace Api\Controller;
use Think\Controller;
class JinwanController extends Controller {
    protected $isEnd = false;
    protected $curCookie = "Dlisessionid=B979A982319C4349B13765B10A2AD8F2; Hm_lvt_ed8c26fcb67d89ae188fda7777058609=1604530399,1604640679,1604703403; Hm_lpvt_ed8c26fcb67d89ae188fda7777058609=1604731681";
    public function show_new_fair(){
        if($this->isEnd) {
            exit("Is end");
        }
        $where = array(
            "company_num"   =>array("gt",0),
            "joined_company_num"    =>0
        );
        $list = M("JwrcNewjobfair")->where($where)->select();
        $this->assign("list",$list);
        $this->display("fair");
    }
    /**
     * 更新招聘会ID
     */
    public function update_id(){
        if($this->isEnd) {
            exit("Is end");
        }
        
        $curHttp = new \Org\Net\Http();
        $url = "http://www.jinwanrc.com/dynamicJson.action?query.currPage=1&query.rowCount=30&query.modelCode=000042&query.modelName=jobFairInformation";

        // 本地招聘会信息
        $id = I("get.id");
        $fairInfo = M("JwrcNewjobfair")
        ->field("*")
        ->find($id);
        $queryStr = array(
            "jobFairName"   =>($fairInfo['fair_name'].$fairInfo["hold_date"])
        );
        $url = $url . "&queryjson=".urlencode(json_encode($queryStr));
        // var_dump($url);
        // exit();
        $cookie = $this->curCookie;
        $result = json_decode($curHttp->sendHttpRequest($url,"get",$postData,"",$cookie),true);

        if(!$result["success"]) {
            var_dump($result);
            exit();
        }
        $fairID = $result["data"][0]["ID"];
        $update = M("JwrcNewjobfair")
        ->where("id=$id")
        ->setField("fair_id",$fairID);
        var_dump($update);
    }

    /**
     * 金湾人力资源网，本地数据插入到金湾人力网招聘会
     */
    public function add_fair(){
        if($this->isEnd) {
            exit("Is end");
        }

        // 本地招聘会信息
        $id = I("get.id");
        $fairInfo = M("JwrcNewjobfair")
        ->field("*,DATE(registration_date) as end_date")
        ->find($id);


        $curHttp = new \Org\Net\Http();
        $url = "http://www.jinwanrc.com/dynamicJson!create.action?query.modelCode=000042&query.modelName=jobFairInformation";
        $type="post";
        $cookie = $this->curCookie;
        $data = array(
            "ID"            =>"",//
            "jobFairName"   =>$fairInfo['fair_name'].$fairInfo["hold_date"],//招聘会名称
            "holdStatus"    =>"3",//举办状态
            "hostUnit"      =>$fairInfo['host_unit'],//举办单位
            "holdDate"      =>$fairInfo['hold_date'],//举办日期
            "boothTotal"    =>$fairInfo['booth_totel'],//展位数量
            "address"       =>$fairInfo['address'],//举办地点
            "registrationDate"  =>$fairInfo['registration_date'],//截至报名时间
            "releaseTime"   =>$fairInfo['release_time'],//发布时间s
            "liaisonName"   =>$fairInfo['liaison_name'],//联系人
            "phone"         =>$fairInfo['phone'],//咨询电话
            "email"         =>"",
            "fairjj"        =>$fairInfo['fair_jj'],//招聘会简介
            "cclx"          =>$fairInfo['cclx'],//乘车路线
            "codeNum"       =>"",//排序
            "status"        =>"0"//显示状态
        );

        $postData = array(
            "jsons"=>urldecode(json_encode($data)),
            "ID"    =>"",
            "access_token"=>""
        );


        $insertFair = json_decode($curHttp->sendHttpRequest($url,$type,$postData,"",$cookie),true);
        var_dump($insertFair['data']["holdDate"]);
        exit();
        if(!$insertFair["success"]) {
            var_dump("ss");
            exit();
        }


    }



    /***
     * 获取企业数据保存到本地
     */
    public function fetch_company(){
        if($this->isEnd) {
            exit("Is end");
        }

        $url = "http://www.jinwanrc.com/dynamicJson.action?query.modelCode=000003&query.rowCount=9999&access_token=";
        $curHttp = new \Org\Net\Http();
        $type="get";
        $cookie = $this->curCookie;
        $result = json_decode($curHttp->sendHttpRequest($url,$type,$postData,"",$cookie),true);
        $list = $result['data'];
        $insertAllData = array();
        foreach($list as $key=>$val){
            $data = array(
                "name"  =>$val['name'],
                "orgid" =>$val["ID"],
                "address"   =>$val['address'],
                "manager"   =>$val["manager"],
                "telephone"   =>$val["telephone"],
                "agency_code"    =>$val["agencyCode"],
                "create_date"   =>$val["createDate"]
            );
            $insertAllData[] = $data;
        }
        $insertResult = M("JwrcCompany")->fetchSql(false)->addAll($insertAllData);
        var_dump($insertResult);
        exit();
    }

    /**
     * 写入参展企业
     */
    public function join_jobfair(){
        if($this->isEnd) {
            exit("Is end");
        }

        $fairId = I("get.id");
        $fairInfo = M("JwrcNewjobfair")
        ->field("*,DATE(registration_date) as end_date")
        ->find($fairId);

        // 插入参展企业
        $companyCondition =array(
            "create_date"   =>array("lt",$fairInfo['end_date'])
        );
        $companyList = M("JwrcCompany")
        ->where($companyCondition)
        ->fetchSql(false)
        ->select();

        shuffle($companyList);
        $sliceNum = $fairInfo['company_num'] - $fairInfo['joined_company_num'];
        $newComlist = array_slice($companyList,0,$sliceNum);



        foreach($newComlist as $key=>$val) {
            $data = array(
                "ID"            =>"",//
                "orgID"   =>$val["orgid"],//企业ID
                "holdDate"      =>$fairInfo['hold_date'],//举办日期
                "jobFairID"       =>$fairInfo['fair_id'],//招聘会ID
                "booth"    =>$key + 1,//展位位置
                "file"    =>"",
                "status"        =>"2"//审核状态;2:审核通过
            );
            $this->do_insert_companytofair($data,$fairId);
            sleep(2);
        }


    }

    protected function do_insert_companytofair($data,$fairId){
        $curHttp = new \Org\Net\Http();
        $url = "http://www.jinwanrc.com/dynamicJson!create.action?query.modelCode=000112&query.modelName=jobFairSign";
        $type="post";
        $cookie = $this->curCookie;
        $postData = array(
            "jsons"=>urldecode(json_encode($data)),
            "ID"    =>"",
            "access_token"=>""
        );
        $insert = json_decode($curHttp->sendHttpRequest($url,$type,$postData,"",$cookie),true);
        if($insert['success']) {
            $updateFair = M("JwrcNewjobfair")
            ->where("id=$fairId")
            ->setInc("joined_company_num");
        }
    }


    /**
     * 导入excel数据到本地
     */
    public function jorfair_local(){
        if($this->isEnd) {
            exit("Is end");
        }
        
        $file = ROOT_DIR . "\Uploads\my.xlsx";

        vendor("PHPExcel.PHPExcel");
        vendor("PHPExcel.PHPExcel.Shared.Date");
        // Vendor('PHPExcel.PHPExcel.IOFactory');
        // $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($file,$encode='utf-8');
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        $insertAllData = array();
        $existArr = array();
        $data = array();
        for($i=2;$i<=$highestRow;$i++)
        {
            $holdDate = \PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue());
            $data['hold_date']   = date("Y-m-d",$holdDate);
            $data['fair_name']   = $objPHPExcel -> getActiveSheet() -> getCell("B".$i)->getValue();
            $data['host_unit']     = "珠海市金湾区人力资源和社会保障局";
            $data['release_time']   = date("Y-m-d",strtotime("-6 days",$holdDate));
            $data["registration_date"]   = date("Y-m-d H:i:s",strtotime("-1 days",$holdDate));
            $data['address'] = "珠海市金湾区红旗镇南翔路313号金湾区人社局门口（海祥湾酒店旁）";
            $data['company_num'] = $objPHPExcel -> getActiveSheet() -> getCell("E".$i)->getValue();
            $insertAllData[] = $data;
        }
        var_dump($insertAllData);
        exit();
        
        // $insertResult = M("JwrcNewjobfair")->fetchSql(true)->addAll($insertAllData);
        // var_dump($insertResult);
        // exit();
 
        // $backData = array(
        //     "code"  =>200,
        //     "msg"   =>'success',
        //     'data'  =>""
        // );
        // $this->ajaxReturn($backData);
    }

}
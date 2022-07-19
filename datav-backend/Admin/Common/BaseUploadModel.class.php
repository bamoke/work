<?php
namespace Admin\Common;

use Think\Model;
use \Admin\Common\ExcelSheet;

class BaseUploadModel extends Model
{
    public function import_data($filePath,$originFileName)
    {

        $uid = session("uid");
        if (!$uid) {
            return array(
                "code" => 11001,
                "msg" => "请登陆后再操作",
            );
        }

        $tableDateModel = M("TableDate");

        // 解析表格文件数据
        $ExcelSheet = new ExcelSheet($filePath, $this->tableField, $this->dataOffset, $uid);

        $insertData = $ExcelSheet->insertData;

        // table date
        $tableDataWhere = array(
            "year" => $insertData[0]["year"],
            "table_name" => C("DB_PREFIX") . $this->tableName,
        );
        if ($insertData[0]["month"]) {
            $tableDataWhere["month"] = $insertData[0]["month"];
        }
        $tableDateIsExisted = $tableDateModel->where($tableDataWhere)->fetchSql(false)->count();

        if ($tableDateIsExisted > 0) {
            return array(
                "code" => 13001,
                "msg" => "本期数据已存在,请删除后再上传",
            );
        }

        $transModel = M();
        $transModel->startTrans();

        $uploadInsertResult = $this->fetchSql(false)->addAll($insertData);

        $tableDateInsertData = array_merge(array("create_by" => $uid, "table_name_cn" => $originFileName), $tableDataWhere);
        $tableDateInsertResult = $tableDateModel->data($tableDateInsertData)->add();

        if ($uploadInsertResult && $tableDateInsertResult) {
            $transModel->commit();
            return array(
                "code" => 200,
                "msg" => "上传成功",
            );
        } else {
            $transModel->rollback();
            return array(
                "code" => 13002,
                "msg" => "数据有误，上传失败",
            );
        }
        ; // 数据表

    }
}

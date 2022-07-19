<?php
namespace Common\Model;
use \Think\Model;
use Common\ExcelSheet;
class TotalModel extends Model {
    protected $tableName = 'total';

    public function insert($data){
        var_dump("insert");
        
    }

    public function getList($pageInfo){

    }
}
<?php
namespace Admin\Model;
use Think\Model;

/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2015/12/1
 * Time: 15:12
 */
class UserModel extends  Model
{
    protected $tablePrefix='wc_';//重新定义表前缀；
    protected $tableName='admin';//重新定义当前模型指向的数据表，不含表前缀;
    protected $trueTableName='wc_admin';//重新定义当前模型类指向的完整数据表名，包含表前缀
    protected $dbName='webcms';//……数据库名
}
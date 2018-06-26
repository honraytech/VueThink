<?php
// +----------------------------------------------------------------------
// | Author: zhouhaipeng <zhouhaipeng@honraytech.com>
// +----------------------------------------------------------------------

namespace com;

use think\Config;
use think\Db;

// 数据表
/*
-- ----------------------------
-- Table structure for `oa_sys_log`
-- 日志主表
-- ----------------------------
DROP TABLE IF EXISTS `oa_sys_log`;
CREATE TABLE `oa_sys_log` (
  `sys_log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sys_log_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '操作人名字',
  `sys_log_type` enum('新增','修改','删除') COLLATE utf8_unicode_ci DEFAULT '新增' COMMENT '操作类型：1新增2修改3删除',
  `sys_log_en_table` varchar(100) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '英文表名',
  `sys_log_time` int(11) DEFAULT NULL COMMENT '操作时间',
  `sys_log_ch_table` varchar(100) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '中文表名',
  PRIMARY KEY (`sys_log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for `oa_log_content`
-- 日志从表
-- ----------------------------
DROP TABLE IF EXISTS `oa_log_content`;
CREATE TABLE `oa_log_content` (
  `log_ct_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sys_log_id` bigint(20) DEFAULT NULL,
  `log_ct_en_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '数据库字段',
  `log_ct_new_value` longtext COLLATE utf8_unicode_ci COMMENT '新值',
  `log_ct_old_value` longtext COLLATE utf8_unicode_ci COMMENT '旧值',
  `log_ct_ch_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '字段注释',
  PRIMARY KEY (`log_ct_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
 */

class SystemLog 
{

    // 构造函数
	private $__time;
	private $__db_prefix;
    public function __construct()
    {
		$this->__time = time();
		$this->__db_prefix = Config::get('database.prefix');
    }

    /**
     * [__getType 获取类型]
     * @linchuangbin
     * @DateTime     2017-02-22T10:58:43+0800
     * @param        integer                  $type [description]
     * @return       [type]                         [description]
     */
	private function __getType($type = 1)
	{
		switch($type){
			case 1:
				return '新增';
			break;
			case 2:
				return '修改';
			break;
			case 3:
				return '删除';
			break;
		}
	}

    /**
     * [addData 添加数据]
     * @linchuangbin
     * @DateTime     2017-02-22T10:57:06+0800
     * @param        string                   $tableName [表名]
     * @param        string                   $adminName [操作人]
     * @param        array                    $newData   [新数据]
     * @param        array                    $oldData   [旧数据]
     */
	public function addData($tableName = '', $adminName = '', $newData = [], $oldData = [])
	{
		//主表处理
		$log_id = $this->__hostTable($adminName, 1, $tableName);
		//从表处理
		$status = $this->__subordinateTable($log_id, $newData, $tableName, $oldData);
		
		return $status;
	}

	
	/**
	 * [beforeUpdate 获取更新前的数据]
	 * @zhouhaipeng
	 * @DateTime     2017-02-22T11:35:39+0800
	 * @param        [type]                   $tableName [表名]
	 * @param        [type]                   $where     [条件]
	 * @return       [type]                              [返回数组]
	 */
	public function beforeUpdate($tableName, $where)
	{
		$oldData = DB::name($tableName)->where($where)->select();
		return $oldData;
	}

	/**
	 * [afterUpdate 记录更新后的数据]
	 * @zhouhaipeng
	 * @DateTime     2017-02-22T11:37:47+0800
	 * @param        [type]                   $tableName [表名]
	 * @param        [type]                   $adminName [操作人]
	 * @param        array                    $newData   [新数据]
	 * @param        array                    $oldData   [旧数据]
	 * @return       [type]                              
	 */
	public function afterUpdate($tableName, $adminName, $newData = [], $oldData = [])
	{
		//主表处理
		$log_id = $this->__hostTable($adminName, 2, $tableName, $oldData);
		//从表处理
		$status = $this->__subordinateTable($log_id, $newData, $tableName, $oldData);
		return true;
	}	

	/**
	 * [afterUpdate 记录删除后的数据]
	 * @zhouhaipeng
	 * @DateTime     2017-02-22T11:37:47+0800
	 * @param        [type]                   $tableName [表名]
	 * @param        [type]                   $adminName [操作人]
	 * @param        array                    $newData   [新数据]
	 * @param        array                    $oldData   [旧数据]
	 * @return       [type]                              
	 */
	public function delData($tableName, $adminName, $newData = [], $oldData = [])
	{
		$log_id = $this->__hostTable($adminName, 3, $tableName);
		//从表处理
		$status = $this->__subordinateTable($log_id, $newData, $tableName, $oldData);
		return true;
	}

	/**
	 * [__getFieldInfo 获取所有字段信息]
	 * @zhouhaipeng
	 * @DateTime     2017-02-22T11:42:44+0800
	 * @param        [array]                   $tableName [表名]
	 * @return       [type]                              
	 */
	private function __getFieldInfo($tableName = '')
	{
		//获取单个表的字段信息
		$fieldInfo = Db::query('show full columns from '.$this->__db_prefix.$tableName);
		foreach($fieldInfo as $key => $val){
			$list[$val['Field']]['Comment'] = $val['Comment'];
			$list[$val['Field']]['Default'] = $val['Default'];
		}
		return $list;
	}

	/**
	 * [__hostTable 主表处理]
	 * @zhouhaipeng
	 * @DateTime     2017-02-22T13:30:51+0800
	 * @param        [type]                   $adminName [操作人]
	 * @param        [type]                   $type      [类型]
	 * @param        [type]                   $tableName [表名]
	 * @return       [type]                              [description]
	 */
	private function __hostTable($adminName , $type, $tableName)
	{
		if(!$adminName){
			//运行自动脚本的操作人
			$adminName = '系统脚本操作';
		}
		$data = [
			'sys_log_name' 		=> $adminName,
			'sys_log_type' 		=> $this->__getType($type),
			'sys_log_en_table' 	=> $tableName,
			'sys_log_ch_table' 	=> $this->__getTableName($tableName),
			'sys_log_time' 		=> $this->__time
		];
		$log_id = Db::name('sys_log')->insert($data);
		return $log_id;
	}

	/**
	 * [__subordinateTable 从表处理]
	 * @zhouhaipeng
	 * @DateTime     2017-02-22T13:33:19+0800
	 * @param        [type]                   $log_id    [主表主键]
	 * @param        [type]                   $newData   [新数据]
	 * @param        [type]                   $tableName [表名]
	 * @param        [type]                   $oldData   [旧数据]
	 * @return       [type]                              
	 */
	private function __subordinateTable($log_id, $newData, $tableName, $oldData)
	{
		$fieldInfo = $this->__getFieldInfo($tableName);
		if($newData[1] || $oldData[1]){
			//批量处理
			$addData = $this->__manyData($log_id, $newData, $fieldInfo, $oldData);
		}else{
			//单条记录处理
			$addData = $this->__oneData($log_id, $newData, $fieldInfo, $oldData);
		}
		$status = Db::name('log_content')->insertAll($addData);
		
		return $status;
	}


	/**
	 * [__oneData 单条记录处理]
	 * @zhouhaipeng
	 * @DateTime     2017-02-22T13:36:47+0800
	 * @param        [type]                   $log_id    [主表主键]
	 * @param        [type]                   $newData   [新数据]
	 * @param        [type]                   $fieldInfo [数据字段信息]
	 * @param        [type]                   $oldData   [旧数据]
	 * @return       [type]                              [description]
	 */
	private function __oneData($log_id, $newData, $fieldInfo, $oldData)
	{
		$temp_data = [];
		$k = 0;//数组下标
		$status = 1;
		if (!$newData) {
			//删除的时候，没有新值
			$newData = $oldData[0];
			$status = 0;
		}
		foreach ($newData as $key => $val) {
			$temp_data[$k]['sys_log_id'] = $log_id;
			$temp_data[$k]['log_ct_en_key'] = $key;
			$temp_data[$k]['log_ct_ch_key'] = $fieldInfo[$key]['Comment'];
			$temp_data[$k]['log_ct_new_value'] = ($val == 0 || $val)?$val:$fieldInfo[$key]['Default'];
			$temp_data[$k]['log_ct_new_value'] = ($status)?$temp_data[$k]['log_ct_new_value']:'';
			$temp_data[$k]['log_ct_old_value'] = $oldData[0][$key];
			$k ++;
		}
		return $temp_data;
	}

	/**
	 * [__manyData 多组记录处理]
	 * @zhouhaipeng
	 * @DateTime     2017-02-22T13:36:47+0800
	 * @param        [type]                   $log_id    [主表主键]
	 * @param        [type]                   $newData   [新数据]
	 * @param        [type]                   $fieldInfo [数据字段信息]
	 * @param        [type]                   $oldData   [旧数据]
	 * @return       [type]                              [description]
	 */
	private function __manyData($log_id, $newData, $fieldInfo, $oldData)
	{
		$temp_data = [];
		$k = 0;
		$status = 1;
		if(!$newData){
			//删除的时候，没有新值
			$newData = $oldData;
			$status = 0;
		}
		foreach($newData as $key => $val){
			foreach($val as $key2 => $val2){
				$temp_data[$k]['sys_log_id'] 	= $log_id;
				$temp_data[$k]['log_ct_en_key'] = $key2;
				$temp_data[$k]['log_ct_ch_key'] = $fieldInfo[$key2]['Comment'];
				$temp_data[$k]['log_ct_new_value'] = ($val2 == 0 || $val2)?$val2:$fieldInfo[$key2]['Default'];
				$temp_data[$k]['log_ct_new_value'] = ($status)?$temp_data[$k]['log_ct_new_value']:'';
				$temp_data[$k]['log_ct_old_value'] = $oldData[$key][$key2];
				$k++;
			}
		}
		return $temp_data;
	}

	/**
	 * [__manyData 获取数据表表名注释]
	 * @zhouhaipeng
	 * @DateTime     2017-02-22T13:36:47+0800
	 * @param        [type]                   $tableName    [表明]
	 * @return       [type]                              	[description]
	 */
	private function __getTableName($tableName)
	{
		$tabelInfo = DB::query("Select TABLE_COMMENT from INFORMATION_SCHEMA.TABLES Where table_name LIKE '".$this->__db_prefix.$tableName."'");

		return $tabelInfo[0]['TABLE_COMMENT'];
	}
}
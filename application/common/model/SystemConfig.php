<?php
// +----------------------------------------------------------------------
// | Description: 系统配置
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\common\model;

use think\Model;

class SystemConfig extends Model 
{

	/**
	 * 获取配置列表
	 * @param  array   $param  [description]
	 */
	public function getDataList()
	{
		$list = $this->select();
		$data = array();
        foreach ($list as $key => $val) {
            $data[$val['name']] = $val['value'];
        }
        return $data;
	}

	/**
	 * 批量修改配置
	 * @param  array   $param  [description]
	 */
	public function createData($param)
	{
		$list = [
		    ['id' => 1, 'value' => $param['SYSTEM_NAME']],
		    ['id' => 2, 'value' => $param['SYSTEM_LOGO']],
		    ['id' => 3, 'value' => $param['LOGIN_SESSION_VALID']],
		    ['id' => 4, 'value' => $param['IDENTIFYING_CODE']],	
		    ['id' => 5, 'value' => $param['LOGO_TYPE']],			
		];
		if ($this->saveAll($list)) {
			$data = $this->getDataList();
			cache('DB_CONFIG_DATA', $data, 3600);
			return $data;
		}
		$this->error = '更新失败';
		return false;
	}
}
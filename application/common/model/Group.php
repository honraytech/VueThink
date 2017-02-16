<?php
// +----------------------------------------------------------------------
// | Description: 用户组
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\common\model;

use app\common\model\Common;

class Group extends Common 
{

	/**
	 * [getDataList 获取列表]
	 * @linchuangbin
	 * @DateTime  2017-02-10T21:07:18+0800
	 * @return    [array]                         
	 */
	public function getDataList()
	{
		$cat = new \com\Category('group', array('group_id', 'pid', 'title', 'title'));
		$data = $cat->getList('', 0, 'group_id');
		
		return $data;
	}
}
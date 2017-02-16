<?php
// +----------------------------------------------------------------------
// | Description: 规则
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\common\model;

use app\common\model\Common;

class Rule extends Common 
{

	/**
	 * [getDataList 获取列表]
	 * @linchuangbin
	 * @DateTime  2017-02-10T21:07:18+0800
	 * @param     string                   $type [是否为树状结构]
	 * @return    [array]                         
	 */
	public function getDataList($type = '')
	{
		$cat = new \com\Category('Rule', array('id', 'pid', 'title', 'title'));
		$data = $cat->getList('', 0, 'id');
		// 若type为tree，则返回树状结构
		if ($type == 'tree') {
			foreach ($data as $k => $v) {
				$data[$k]['check'] = false;
			}
			$tree = new \com\Tree();
			$data = $tree->list_to_tree($data, 'id', 'pid', 'child', 0, true, array('pid'));
		}
		
		return $data;
	}

}
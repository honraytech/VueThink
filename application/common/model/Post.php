<?php
// +----------------------------------------------------------------------
// | Description: 岗位
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\common\model;

use app\common\model\Common;

class Post extends Common 
{

	protected $updateTime  = 'create_time';
	protected $autoWriteTimestamp = true;
	protected $insert = [
		'status' => 1,
	];  

	/**
	 * [getDataList 获取列表]
	 * @linchuangbin
	 * @DateTime  2017-02-10T21:07:18+0800
	 * @return    [array]                         
	 */
	public function getDataList($keywords)
	{
		$map = [];
		if ($param['keywords']) {
			$map['p_name'] = ['like', '%'.$keywords.'%'];
		}
		$data = $this->where($map)->select();
		return $data;
	}
}
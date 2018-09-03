<?php
// +----------------------------------------------------------------------
// | Description: 岗位
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\admin\model\Common;

class Post extends Common 
{

    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
	protected $name = 'admin_post';
    protected $createTime = 'create_time';
    protected $updateTime = false;
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
		if ($keywords) {
			$map['name'] = ['like', '%'.$keywords.'%'];
		}
		$data = $this->where($map)->select();
		return $data;
	}
}
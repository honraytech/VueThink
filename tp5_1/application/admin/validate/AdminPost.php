<?php

namespace app\admin\validate;
use think\Validate;
/**
* 设置模型
*/
class AdminPost extends Validate{

	protected $rule = array(
		'name'   => 'require',
	);
	protected $message = array(
		'name.require'    => '部门名称必须填写',
	);
}
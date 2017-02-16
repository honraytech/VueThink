<?php

namespace app\common\validate;
use think\Validate;
/**
* 设置模型
*/
class Post extends Validate{

	protected $rule = array(
		'p_name'   => 'require',
	);
	protected $message = array(
		'p_name.require'    => '部门名称必须填写',
	);
}
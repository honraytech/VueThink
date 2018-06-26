<?php

namespace app\admin\validate;
use think\Validate;
/**
* 设置模型
*/
class AdminGroup extends Validate{

	protected $rule = array(
		'title'   => 'require',
		'rules'      => 'require',
	);
	protected $message = array(
		'title.require'    => '标题必须填写',
		'rules.require'    => '规则必须填写',
	);
}
<?php

namespace app\common\validate;
use think\Validate;
/**
* 设置模型
*/
class User extends Validate{

	protected $rule = array(
		'u_username'  		=> 'require|length:6,12|unique:user',
		'u_pwd'      		=> 'require',
		'u_realname'      	=> 'require',
		's_id'      		=> 'require',
	);
	protected $message = array(
		'u_username.require'    => '用户名必须填写',
		'u_username.length'    	=> '用户名长度在6到12位',
		'u_username.unique'    	=> '用户名已存在',
		'u_pwd.require'    		=> '密码必须填写',
		'u_realname.require'    => '真实姓名必须填写',
		's_id.require'    		=> '组织架构必须填写',
	);
}
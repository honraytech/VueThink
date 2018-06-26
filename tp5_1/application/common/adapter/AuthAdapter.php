<?php
namespace app\common\adapter;
use com\HonrayAuth;
class AuthAdapter
{
	private static $_instance;

	/**
	 * 验证码
	 * @var string
	 */
	private $auth_key;

	public function __construct($auth_key) 
	{
		$this->auth_key = $auth_key; 
	}

	//实例化权限类
	public static function getInstance($auth_key)
	 {
		if (!(self::$_instance instanceof HonrayAuth)) {
			self::$_instance = new HonrayAuth($auth_key);
		}
		return self::$_instance; 
	}
	//登录认证
	public function checkLogin($names, $uid, $relation='or') 
	{
		self::getInstance($this->auth_key)->_config['AUTH_TYPE'] = 2;
		if ($uid == 1){ 
			return true;
		}
		if (!self::getInstance($this->auth_key)->check($names, $uid, $relation)) {
			return false;
		} else {
			return true;
		}
	}
	//实时认证
	public function checkIntime($names, $uid, $relation='or') 
	{
		self::getInstance($this->auth_key)->_config['AUTH_TYPE'] = 1;
		if ($uid == 1) {
			return true;
		}
		if (!self::getInstance($this->auth_key)->check($names, $uid, $relation)) {
			return false;
		} else {
			return true;
		}
	}
	//更新缓存auth_list
	public function updateCacheAuth() 
	{
		$res = self::getInstance($this->auth_key)->updateCacheAuth();
		return $res;
	}
}
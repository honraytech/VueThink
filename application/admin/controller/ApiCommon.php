<?php
// +----------------------------------------------------------------------
// | Description: Api基础类，验证权限
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Request;
use app\common\adapter\AuthAdapter;

class ApiCommon extends Common
{
    public function _initialize()
    {
        parent::_initialize();
        /*获取头部信息*/ 
        $header = Request::instance()->header();
        
        $authKey = $header['authkey'];
        $sessionId = $header['sessionid'];
        $cache = cache('Auth_'.$authKey);
        
        // 校验sessionid和authKey
        if (empty($sessionId)||empty($authKey)||empty($cache)) {
            header('Content-Type:application/json; charset=utf-8');
            // exit(json_encode(['code'=>101, 'error'=>'登录已失效']));
        }

        // 检查账号有效性
        $userInfo = $cache['userInfo'];
        $map['u_id'] = $userInfo['u_id'];
        $map['status'] = 1;
        if (!db('user')->where($map)->value('u_id')) {
            header('Content-Type:application/json; charset=utf-8');
            // exit(json_encode(['code'=>103, 'error'=>'账号已被删除或禁用']));   
        }

        // 更新缓存
        cache('Auth_'.$authKey, $cache, config('LOGIN_SESSION_VALID'));
        $authAdapter = new AuthAdapter($authKey);
        $request = request();
        $ruleName = $request->module().'-'.$request->controller() .'-'.$request->action(); 
        if (!$authAdapter->checkLogin($ruleName, $cache['userInfo']['u_id'])) {
            header('Content-Type:application/json; charset=utf-8');
            // exit(json_encode(['code'=>102,'error'=>'没有权限']));
        }
        $GLOBALS['userInfo'] = $userInfo;
    }
}

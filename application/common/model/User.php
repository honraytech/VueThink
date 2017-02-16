<?php
// +----------------------------------------------------------------------
// | Description: 用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\common\model;

use app\common\model\Common;
use com\verify\HonrayVerify;

class User extends Common 
{

	protected $updateTime  = 'create_time';
	protected $autoWriteTimestamp = true;
	protected $insert = [
		'status' => 1,
	];  
	/**
	 * 获取用户所属所有用户组
	 * @param  array   $param  [description]
	 */
    public function groups()
    {
        return $this->belongsToMany('Group','__USER_GROUP__','group_id','u_id');
    }

    /**
     * [getDataList 列表]
     * @AuthorHTL
     * @DateTime  2017-02-10T22:19:57+0800
     * @param     [string]                   $keywords [关键字]
     * @param     [number]                   $page     [当前页数]
     * @param     [number]                   $limit    [t每页数量]
     * @return    [array]                             [description]
     */
	public function getDataList($keywords, $page, $limit)
	{
		$map = [];
		if ($keywords) {
			$map['u_username|u_realname'] = ['like', '%'.$keywords.'%'];
		}

		// 默认除去超级管理员
		$map['u_id'] = array('neq', 1);
		$dataCount = $this->where($map)->count('u_id');
		
		$list = $this
				->where($map)
				->alias('user')
				->join('__STRUCTURE__ structure', 'structure.id=user.s_id', 'LEFT')
				->join('__POST__ post', 'post.p_id=user.p_id', 'LEFT');
		
		// 若有分页
		if ($page && $limit) {
			$list = $list->page($page, $limit);
		}

		$list = $list 
				->field('user.*,structure.name as s_name, post.p_name')
				->select();
		
		$data['list'] = $list;
		$data['dataCount'] = $dataCount;
		
		return $data;
	}

	/**
	 * [getDataById 根据主键获取详情]
	 * @linchuangbin
	 * @DateTime  2017-02-10T21:16:34+0800
	 * @param     string                   $id [主键]
	 * @return    [array]                       
	 */
	public function getDataById($id = '')
	{
		$data = $this->get($id);
		if (!$data) {
			$this->error = '暂无此数据';
			return false;
		}
		$data['groups'] = $this->get($id)->groups;
		return $data;
	}
	/**
	 * 创建用户
	 * @param  array   $param  [description]
	 */
	public function createData($param)
	{
		if (empty($param['groups'])) {
			$this->error = '请至少勾选一个用户组';
			return false;
		}

		// 验证
		$validate = validate('user');
		if (!$validate->check($param)) {
			$this->error = $validate->getError();
			return false;
		}

		$this->startTrans();
		try {
			$param['u_pwd'] = user_md5($param['u_pwd']);
			$this->data($param)->allowField(true)->save();

			foreach ($param['groups'] as $k => $v) {
				$userGroup['u_id'] = $this->u_id;
				$userGroup['group_id'] = $v;
				$userGroups[] = $userGroup;
			}
			db('user_group')->insertAll($userGroups);

			$this->commit();
			return true;
		} catch(\Exception $e) {
			$this->rollback();
			$this->error = '添加失败';
			return false;
		}
	}

	/**
	 * 通过id修改用户
	 * @param  array   $param  [description]
	 */
	public function updateDataById($param, $id)
	{
		// 不能操作超级管理员
		if ($id == 1) {
			$this->error = '非法操作';
			return false;
		}
		$checkData = $this->get($id);
		if (!$checkData) {
			$this->error = '暂无此数据';
			return false;
		}
		if (empty($param['groups'])) {
			$this->error = '请至少勾选一个用户组';
			return false;
		}
		$this->startTrans();

		try {
			db('user_group')->where('u_id',$id)->delete();
			foreach ($param['groups'] as $k => $v) {
				$userGroup['u_id'] = $checkData['u_id'];
				$userGroup['group_id'] = $v;
				$userGroups[] = $userGroup;
			}
			db('user_group')->insertAll($userGroups);

			if (!empty($param['u_pwd'])) {
				$param['u_pwd'] = user_md5($param['u_pwd']);
			}
			 $this->allowField(true)->save($param, ['u_id' => $id]);
			 $this->commit();
			 return true;

		} catch(\Exception $e) {
			$this->rollback();
			$this->error = '编辑失败';
			return false;
		}
	}

	/**
	 * [login 登录]
	 * @AuthorHTL
	 * @DateTime  2017-02-10T22:37:49+0800
	 * @param     [string]                   $u_username [账号]
	 * @param     [string]                   $u_pwd      [密码]
	 * @param     [string]                   $verifyCode [验证码]
	 * @param     Boolean                  	 $isRemember [是否记住密码]
	 * @param     Boolean                    $type       [是否重复登录]
	 * @return    [type]                               [description]
	 */
	public function login($u_username, $u_pwd, $verifyCode = '', $isRemember = false, $type = false)
	{
        if (!$u_username) {
			$this->error = '帐号不能为空';
			return false;
		}
		if (!$u_pwd){
			$this->error = '密码不能为空';
			return false;
		}
        if (config('IDENTIFYING_CODE') && !$type) {
            if (!$verifyCode) {
				$this->error = '验证码不能为空';
				return false;
            }
            $captcha = new HonrayVerify(config('captcha'));
            if (!$captcha->check($verifyCode)) {
				$this->error = '验证码错误';
				return false;
            }
        }

		$map['u_username'] = $u_username;
		$userInfo = $this->where($map)->find();
    	if (!$userInfo) {
			$this->error = '帐号不存在';
			return false;
    	}
    	if (user_md5($u_pwd) !== $userInfo['u_pwd']) {
			$this->error = '密码错误';
			return false;
    	}
    	if ($userInfo['status'] === 0) {
			$this->error = '帐号已被禁用';
			return false;
    	}
        // 获取菜单和权限
        $dataList = $this->getMenuAndRule($userInfo['u_id']);

        if (!$dataList['menusList']) {
			$this->error = '没有权限';
			return false;
        }

        if ($isRemember || $type) {
        	$secret['u_username'] = $u_username;
        	$secret['u_pwd'] = $u_pwd;
        	$data['rememberKey'] = encrypt($secret);
        }

        // 保存缓存        
        session_start();
        $info['userInfo'] = $userInfo;
        $info['sessionId'] = session_id();
        $authKey = user_md5($userInfo['u_username'].$userInfo['u_pwd'].$info['sessionId']);
        $info['_AUTH_LIST_'] = $dataList['rulesList'];
        $info['authKey'] = $authKey;
        cache('Auth_'.$authKey, null);
        cache('Auth_'.$authKey, $info, config('LOGIN_SESSION_VALID'));
        // 返回信息
        $data['authKey']		= $authKey;
        $data['sessionId']		= $info['sessionId'];
        $data['userInfo']		= $userInfo;
        $data['authList']		= $dataList['rulesList'];
        $data['menusList']		= $dataList['menusList'];
        return $data;
    }

	/**
	 * 修改密码
	 * @param  array   $param  [description]
	 */
    public function setInfo($auth_key, $old_pwd, $new_pwd)
    {
        $cache = cache('Auth_'.$auth_key);
        if (!$cache) {
			$this->error = '请先进行登录';
			return false;
        }
        if (!$old_pwd) {
			$this->error = '请输入旧密码';
			return false;
        }
        if (!$new_pwd) {
            $this->error = '请输入新密码';
			return false; 
        }
        if ($new_pwd == $old_pwd) {
            $this->error = '新旧密码不能一致';
			return false; 
        }

        $userInfo = $cache['userInfo'];
        $password = $this->where('u_id',$userInfo['u_id'])->value('u_pwd');
        if (user_md5($old_pwd) != $password) {
            $this->error = '原密码错误';
			return false; 
        }
        if (user_md5($new_pwd) == $password) {
            $this->error = '密码没改变';
			return false;
        }
        if ($this->where('u_id', $userInfo['u_id'])->setField('u_pwd', user_md5($new_pwd))) {
            $userInfo = $this->where('u_id',$userInfo['u_id'])->find();
            // 重新设置缓存
            session_start();
            $cache['userInfo'] = $userInfo;
            $cache['authKey'] = user_md5($userInfo['u_username'].$userInfo['u_pwd'].session_id());
            cache('Auth_'.$auth_key, null);
            cache('Auth_'.$cache['authKey'], $cache, config('LOGIN_SESSION_VALID'));
            return $cache['authKey'];//把auth_key传回给前端
        }
        
        $this->error = '修改失败';
		return false;
    }

	/**
	 * 获取菜单和权限
	 * @param  array   $param  [description]
	 */
    protected function getMenuAndRule($u_id)
    {
    	if ($u_id === 1) {
            $map['status'] = 1;
    		$menusList = db('menu')->where($map)->order('sort asc')->select();
    	} else {
    		$groups = $this->get($u_id)->groups;
    		
            $ruleIds = [];
    		foreach($groups as $k => $v) {
    			$ruleIds = array_unique(array_merge($ruleIds, explode(',', $v['rules'])));
    		}

            $ruleMap['id'] = array('in', $ruleIds);
            $ruleMap['status'] = 1;
            // 重新设置ruleIds，除去部分已删除或禁用的权限。
            $rules = db('rule')->where($ruleMap)->select();
            foreach ($rules as $k => $v) {
            	$ruleIds[] = $v['id'];
            	$rules[$k]['name'] = strtolower($v['name']);
            }
            empty($ruleIds)&&$ruleIds = '';
    		$menuMap['status'] = 1;
            $menuMap['rule_id'] = array('in',$ruleIds);
            $menusList = db('menu')->where($menuMap)->order('sort asc')->select();
        }
        if (!$menusList) {
            return null;
        }
        //处理菜单成树状
        $tree = new \com\Tree();
        $ret['menusList'] = $tree->list_to_tree($menusList, 'id', 'pid', 'child', 0, true, array('pid'));
        $ret['menusList'] = memuLevelClear($ret['menusList']);
        // 处理规则成树状
        $ret['rulesList'] = $tree->list_to_tree($rules, 'id', 'pid', 'child', 0, true, array('pid'));
        $ret['rulesList'] = rulesDeal($ret['rulesList']);

        return $ret;
    }
}
<?php
// +----------------------------------------------------------------------
// | Description: 用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\model;

use think\Db;
use app\admin\model\Common;
use com\verify\HonrayVerify;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;

class User extends Common 
{	
    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
	protected $name = 'admin_user';
    protected $createTime = 'create_time';
    protected $updateTime = false;
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
        return $this->belongsToMany('group', '__ADMIN_ACCESS__', 'group_id', 'user_id');
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
			$map['username|realname'] = ['like', '%'.$keywords.'%'];
		}

		// 默认除去超级管理员
		$map['user.id'] = array('neq', 1);
		$dataCount = $this->alias('user')->where($map)->count('id');
		
		$list = $this
				->where($map)
				->alias('user')
				->join('__ADMIN_STRUCTURE__ structure', 'structure.id=user.structure_id', 'LEFT')
				->join('__ADMIN_POST__ post', 'post.id=user.post_id', 'LEFT');
		
		// 若有分页
		if ($page && $limit) {
			$list = $list->page($page, $limit);
		}

		$list = $list 
				->field('user.*,structure.name as s_name, post.name as p_name')
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
		$validate = validate($this->name);
		if (!$validate->check($param)) {
			$this->error = $validate->getError();
			return false;
		}

		$this->startTrans();
		try {
			$param['password'] = user_md5($param['password']);
			$this->data($param)->allowField(true)->save();

			foreach ($param['groups'] as $k => $v) {
				$userGroup['user_id'] = $this->id;
				$userGroup['group_id'] = $v;
				$userGroups[] = $userGroup;
			}
			Db::name('admin_access')->insertAll($userGroups);

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
			Db::name('admin_access')->where('user_id', $id)->delete();
			foreach ($param['groups'] as $k => $v) {
				$userGroup['user_id'] = $id;
				$userGroup['group_id'] = $v;
				$userGroups[] = $userGroup;
			}
			Db::name('admin_access')->insertAll($userGroups);

			if (!empty($param['password'])) {
				$param['password'] = user_md5($param['password']);
			}
			 $this->allowField(true)->save($param, ['id' => $id]);
			 $this->commit();
			 return true;

		} catch(\Exception $e) {
			$this->rollback();
			$this->error = '编辑失败';
			return false;
		}
	}
	/**
	 * [getUserById 获取用户信息]
	 * @AuthorHTL
	 * @DateTime  2018-02-11
	 * @param     [string]                   $uid [账号id]
	 * @return    [type]                               [description]
	 */
	public function getUserById($uid){
		$map = array(
			'id' => $uid,
		);
		return $this->where($map)->find();
	}
	/**
	 * [根据uid返回用户信息(权限，菜单，用户信息)]
	 * @AuthorHTL
	 * @DateTime  2018-02-12
	 * @param     [string]                   $uid [账号id]
	 * @return    [type]                               [description]
	 */
	public function getInfo($uid){
		$map['id'] = $uid;
		$userInfo = $this->where($map)->find();
		$dataList = $this->getMenuAndRule($userInfo['id']);
		$data['userInfo']		= $userInfo;
        $data['authList']		= $dataList['rulesList'];
		$data['menusList']		= $dataList['menusList'];
		return $data;
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
	public function login($username, $password, $verifyCode = '', $isRemember = false, $type = false)
	{
        if (!$username) {
			$this->error = '帐号不能为空';
			return false;
		}
		if (!$password){
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

		$map['username'] = $username;
		$userInfo = $this->where($map)->find();
    	if (!$userInfo) {
			$this->error = '帐号不存在';
			return false;
    	}
    	if (user_md5($password) !== $userInfo['password']) {
			$this->error = '密码错误';
			return false;
    	}
    	if ($userInfo['status'] === 0) {
			$this->error = '帐号已被禁用';
			return false;
    	}
        // 获取菜单和权限
        $dataList = $this->getMenuAndRule($userInfo['id']);

        if (!$dataList['menusList']) {
			$this->error = '没有权限';
			return false;
        }

        if ($isRemember || $type) {
        	$secret['username'] = $username;
        	$secret['password'] = $password;
        	$data['rememberKey'] = encrypt($secret);
        }
		$jwt = $this->createJwt($userInfo['id']);
        $data['userInfo']		= $userInfo;
        $data['authList']		= $dataList['rulesList'];
		$data['menusList']		= $dataList['menusList'];
		$data = array_merge($data,$jwt);
        return $data;
	}
	/**
	 * 通过jwt获取uid
	 * @param  string   $jwt  [jwt]
	 */
	public function getUid($jwt){
        $token = (new Parser())->parse((string)$jwt);
        $valid = new ValidationData();
        $signer = new Sha256();
        if($token->validate($valid) && $token->verify($signer, '5802b372c71d009efaf37c866730c09d')){
			return $token->getClaim('uid');
		}else{
			return false;
		}
	}
	/**
	 * 生成jwt
	 * @param  int   $uid  [用户id]
	 */
	public function createJwt($uid){
		$nbf = time();
		$expire = time() + config('LOGIN_SESSION_VALID');
		$signer = new Sha256();
		$authKey = (new Builder())->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
		->setNotBefore($nbf) // Configures the time that the token can be used (nbf claim)
		->setExpiration($expire) // Configures the expiration time of the token (nbf claim)
		->set('uid', $uid) // Configures a new claim, called "uid"
		->sign($signer, '5802b372c71d009efaf37c866730c09d') // creates a signature using "testing" 
		->getToken(); // Retrieves the generated token
		$result = array(
			'authKey' => (string)$authKey,
			'expire' =>	$expire,
		);
		return $result;
	}

	/**
	 * 修改密码
	 * @param  array   $param  [description]
	 */
    public function setInfo($auth_key, $old_pwd, $new_pwd)
    {
        $uid = $this->getUid($auth_key);
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

        $password = $this->where('id', $uid)->value('password');
        if (user_md5($old_pwd) != $password) {
            $this->error = '原密码错误';
			return false; 
        }
        if (user_md5($new_pwd) == $password) {
            $this->error = '密码没改变';
			return false;
        }
        if ($this->where('id', $uid)->setField('password', user_md5($new_pwd))) {
            return $auth_key;//把auth_key传回给前端
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
    		$menusList = Db::name('admin_menu')->where($map)->order('sort asc')->select();
    	} else {
    		$groups = $this->get($u_id)->groups;
            $ruleIds = [];
    		foreach($groups as $k => $v) {
    			$ruleIds = array_unique(array_merge($ruleIds, explode(',', $v['rules'])));
    		}

            $ruleMap['id'] = array('in', $ruleIds);
            $ruleMap['status'] = 1;
            // 重新设置ruleIds，除去部分已删除或禁用的权限。
            $rules =Db::name('admin_rule')->where($ruleMap)->select();
            foreach ($rules as $k => $v) {
            	$ruleIds[] = $v['id'];
            	$rules[$k]['name'] = strtolower($v['name']);
            }
            empty($ruleIds)&&$ruleIds = '';
    		$menuMap['status'] = 1;
            $menuMap['rule_id'] = array('in',$ruleIds);
            $menusList = Db::name('admin_menu')->where($menuMap)->order('sort asc')->select();
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
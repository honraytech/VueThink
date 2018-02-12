<?php
// +----------------------------------------------------------------------
// | Author: linchuangbin
// +----------------------------------------------------------------------
namespace com;

use think\Db;

class HonrayAuth{

    //默认配置
    public $_config = array(
        'AUTH_ON'           => true,                        // 认证开关
        'AUTH_TYPE'         => 1,                           // 认证方式，2为登录认证。
        'AUTH_GROUP'        => 'admin_group',                     // 用户组数据表名
        'AUTH_GROUP_ACCESS' => 'admin_access',                // 用户-用户组关系表
        'AUTH_RULE'         => 'admin_rule',                      // 权限规则表
        'AUTH_USER'         => 'admin_user'                       // 用户信息表
    );

    private $uid; 

    public function __construct($uid) {
        $this->uid = $uid;
        if (config('AUTH_CONFIG')) {
            //可设置配置项 AUTH_CONFIG, 此配置项为数组。
            $this->_config = array_merge($this->_config, config('AUTH_CONFIG'));
        }
    }

    /**
      * 检查权限
      * @param name string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
      * @param uid  int           认证用户的id
      * @return boolean           通过验证返回true;失败返回false
     */
    public function check($name, $uid, $relation = 'or') {
        if (!$this->_config['AUTH_ON'])
            return true;
        $authList = $this->getAuthList($uid); //获取用户需要验证的所有有效规则列表

        if (is_string($name)) {
            $name = strtolower($name);
            if (strpos($name, ',') !== false) {
                $name = explode(',', $name);
            } else {
                $name = array($name);
            }
        }

        if (is_array($name)) {
           foreach ($name as $k => $v) {
               $name[$k] = strtolower($v);
           }
        }

        $list = array(); //保存验证通过的规则名
        foreach ( $authList as $auth ) {
            if (in_array($auth , $name)){
                $list[] = $auth ;
            }
        }
        if ($relation == 'or' and !empty($list)) {
            return true;
        }

        $diff = array_diff($name, $list);
        if ($relation == 'and' and empty($diff)) {
            return true;
        }
        return false;
    }

    /**
     * 根据用户id获取用户组,返回值为数组
     * @param  uid int     用户id
     * @return array       用户所属的用户组 array(
     *     array('uid'=>'用户id','group_id'=>'用户组id','title'=>'用户组名称','rules'=>'用户组拥有的规则id,多个,号隔开'),
     *     ...)   
     */
    public function getGroups($uid) { 
        static $groups = array();
        if (isset($groups[$uid]))
            return $groups[$uid];
        $user_groups = model('admin/User')->get($uid)->groups;
        $groups[$uid] = $user_groups?:array();
        return $groups[$uid];
    }

    /**
     * 获得权限列表
     * @param integer $uid  用户id
     */
    protected function getAuthList($uid) {
        //读取用户所属用户组
        $groups = $this->getGroups($uid);
        $ids = [];//保存用户所属用户组设置的所有权限规则id
        foreach ($groups as $g) {
            $ids = array_merge($ids, explode(',', trim($g['rules'], ',')));
        }

        $ids = array_unique($ids);
        if (empty($ids)) {
            return [];
        }

        $map = [
            'id' => array('in', $ids),
            'status' => 1,
        ];

        //读取用户组所有权限规则
        $rules = Db::name($this->_config['AUTH_RULE'])->where($map)->select();

        foreach ($rules as $k => $v) {
            $rules[$k]['name'] = strtolower($v['name']);
        }
        $tree = new \com\Tree();
        $authList = $tree->list_to_tree($rules, 'id', 'pid', 'child', 0, true, array('pid'));
        $authList = rulesDeal($authList);

        return $authList; 
    }
}

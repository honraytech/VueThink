<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\common\model;

use app\common\model\Common;

class Menu extends Common 
{

	/**
	 * [getDataList 获取列表]
	 * @linchuangbin
	 * @DateTime  2017-02-10T21:07:18+0800
	 * @return    [array]                         
	 */
	public function getDataList()
	{	
        $cat = new \com\Category('Menu', array('id', 'pid', 'title', 'title'));     
        $data = $cat->getList('', 0, 'sort'); 
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
		$data = $this
				->alias('menu')
				->where('menu.id', $id)
				->join('__RULE__ rule', 'menu.rule_id=rule.id', 'LEFT')
				->field('menu.*, rule.title as rule_name')
				->find();
		if (!$data) {
			$this->error = '暂无此数据';
			return false;
		}
		return $data;
	}


	/**
	 * 整理菜单树形结构
	 * @param  array   $param  [description]
	 */
    protected function getMenuTree()
    {	
    	$userInfo = $GLOBALS['userInfo'];
    	if (!$userInfo) {
    		return [];
    	}
    	
    	$u_id = $userInfo['u_id'];
    	if ($u_id === 1) {
    		$map['status'] = 1;
    		$menusList = db('menu')->where($map)->order('sort asc')->select();
    	} else {
    		$groups = model('Common/User')->get($u_id)->groups;
    		
            $ruleIds = [];
    		foreach($groups as $k => $v) {
    			$ruleIds = array_unique(array_merge($ruleIds, explode(',', $v['rules'])));
    		}
            $ruleMap['id'] = array('in', $ruleIds);
            $ruleMap['status'] = 1;
            // 重新设置ruleIds，除去部分已删除或禁用的权限。
            $ruleIds = db('rule')->where($ruleMap)->column('id');
            empty($ruleIds)&&$ruleIds = '';
    		$menuMap['status'] = 1;
            $menuMap['rule_id'] = array('in',$ruleIds);
            $menusList = db('menu')->where($menuMap)->order('sort asc')->select();
        }
        if (!$menusList) {
            return [];
        }
        //处理成树状
        $tree = new \com\Tree();
        $menusList = $tree->list_to_tree($menusList, 'id', 'pid', 'child', 0, true, array('pid'));
        $menusList = memuLevelClear($menusList);
        
        return $menusList? $menusList: [];
    }

}
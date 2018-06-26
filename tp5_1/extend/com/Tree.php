<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <59821125@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------
namespace com;
/**
 * 列表树生成工具类
 * 该类里的方法一部分来自OneThink，一部分来自网络，最后加上作者的修改形成完善的Tree类
 * @author jry <598821125@qq.com>
 */
class Tree{
    /**
     * 用于树型数组完成递归格式的全局变量
     * @author jry <598821125@qq.com>
     */
    private $formatTree;

    /**
    * 将格式数组转换为基于标题的树（实际还是列表，只是通过在相应字段加前缀实现类似树状结构）
    * @param array $list
    * @param integer $level 进行递归时传递用的参数
    */
    private function _toFormatTree($list, $level = 0, $title = 'title'){
        foreach($list as $key=>$val){
            $title_prefix = str_repeat("&nbsp;", $level*4);
            $title_prefix .= "┝ ";
            $val['level'] = $level;
            $val['title_prefix'] = $level == 0 ? '' : $title_prefix;
            $val['title_show'] = $level == 0 ? $val[$title] : $title_prefix.$val[$title];
            if(!array_key_exists('_child', $val)){
                array_push($this->formatTree, $val);
            }else{
                $child = $val['_child'];
                unset($val['_child']);
                array_push($this->formatTree, $val);
                $this->_toFormatTree($child, $level+1, $title); //进行下一层递归
            }
        }
        return;
    }

    /**
    * 将格式数组转换为树
    * @param array $list
    * @param integer $level 进行递归时传递用的参数
    */
    public function toFormatTree($list, $title = 'title', $pk='id', $pid = 'pid', $root = 0, $strict = true){
        $list = $this->list_to_tree($list, $pk, $pid, '_child', $root, $strict);
        $this->formatTree = array();
        $this->_toFormatTree($list, 0, $title);
        return $this->formatTree;
    }

    /**
     * 将数据集转换成Tree（真正的Tree结构）
     * @param array $list 要转换的数据集
     * @param string $pk ID标记字段
     * @param string $pid parent标记字段
     * @param string $child 子代key名称
     * @param string $root 返回的根节点ID
     * @param string $strict 默认严格模式
     * @param array $filter 要剔除掉的字段
     * @return array
     */
    public function list_to_tree($list, $pk='id', $pid = 'pid', $child = 'child', $root = 0, $strict = true,$filter = array()){
        // 创建Tree
        $tree = array();
        if(is_array($list)){
            // 创建基于主键的数组引用
            $refer = array();
            foreach($list as $key => $data){
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach($list as $key => $data){
                // 判断是否存在parent
                $parent_id = $data[$pid];
                if($parent_id === null || (int)$root === $parent_id){
                    $tree[] =& $list[$key];
                }else{
                    if(isset($refer[$parent_id])){
                        $parent =& $refer[$parent_id];
                        $parent[$child][] =& $list[$key];
                    }else{
                        if($strict === false){
                            $tree[] =& $list[$key];
                        }
                    }
                }
            }
            //剔除数据
            if(count($filter) > 0){
                foreach($refer as $key => $data){
                    foreach ($data as $k => $v) {
                        if(in_array($k, $filter)) unset($refer[$key][$k]);
                    }
                }
            }
        }
        return $tree;
    }

    /**
     * 将list_to_tree的树还原成列表
     * @param    array $tree    原来的树
     * @param    string $child 孩子节点的键
     * @param    string $order 排序显示的键，一般是主键 升序排列
     * @param    array $list 过渡用的中间数组，
     * @return array 返回排过序的列表数组
     */
    public function tree_to_list($tree, $child = '_child', $order='id', &$list = array()){
        if(is_array($tree)){
            foreach ($tree as $key => $value){
                $reffer = $value;
                if(isset($reffer[$child])){
                    unset($reffer[$child]);
                    tree_to_list($value[$child], $child, $order, $list);
                }
                $list[] = $reffer;
            }
            $list = $this->list_sort_by($list, $order, $sortby='asc');
        }
        return $list;
    }

    /**
    * 对查询结果集进行排序
    * @access public
    * @param array $list 查询结果
    * @param string $field 排序的字段名
    * @param array $sortby 排序类型 asc正向排序 desc逆向排序 nat自然排序
    * @return array
    */
    public function list_sort_by($list,$field, $sortby='asc'){
        if(is_array($list)){
            $refer = $resultSet = array();
            foreach($list as $i => $data)
                $refer[$i] = &$data[$field];
            switch($sortby){
                case 'asc': // 正向排序
                    asort($refer);
                    break;
                case 'desc':// 逆向排序
                    arsort($refer);
                    break;
                case 'nat': // 自然排序
                    natcasesort($refer);
                    break;
            }
            foreach ($refer as $key=> $val)
                $resultSet[] = &$list[$key];
            return $resultSet;
        }
        return false;
    }

    /**
     * 在数据列表中搜索
     * @access public
     * @param array $list 数据列表
     * @param mixed $condition 查询条件
     * 支持 array('name'=>$value) 或者 name=$value
     * @return array
     */
    function list_search($list,$condition){
        if(is_string($condition))
            parse_str($condition, $condition);
            //返回的结果集合
            $resultSet = array();
            foreach ($list as $key => $data){
                $find = false;
                foreach ($condition as $field=>$value){
                    if(isset($data[$field])){
                        if(0 === strpos($value,'/')){
                            $find = preg_match($value,$data[$field]);
                        }elseif($data[$field]==$value){
                            $find = true;
                        }
                    }
                }
            if($find){
                $resultSet[] = &$list[$key];
            }
        }
        return $resultSet;
    }
}

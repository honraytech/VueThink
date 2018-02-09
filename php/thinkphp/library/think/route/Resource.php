<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace think\route;

use think\Route;

class Resource extends RuleGroup
{
    // 资源路由名称
    protected $resource;
    // 资源路由地址
    protected $route;
    // REST路由方法定义
    protected $rest = [];

    /**
     * 架构函数
     * @access public
     * @param  Route         $router     路由对象
     * @param  RuleGroup     $group      路由所属分组对象
     * @param  string        $name       资源名称
     * @param  string        $route      路由地址
     * @param  array         $option     路由参数
     * @param  array         $pattern    变量规则
     * @param  array         $rest       资源定义
     */
    public function __construct(Route $router, RuleGroup $group = null, $name = '', $route = '', $option = [], $pattern = [], $rest = [])
    {
        $this->router   = $router;
        $this->parent   = $group;
        $this->resource = $name;
        $this->route    = $route;
        $this->name     = strpos($name, '.') ? strstr($name, '.', true) : $name;

        $this->setFullName();

        // 资源路由默认为完整匹配
        $option['complete_match'] = true;

        $this->pattern = $pattern;
        $this->option  = $option;
        $this->rest    = $rest;
    }

    /**
     * 检测分组路由
     * @access public
     * @param  Request      $request  请求对象
     * @param  string       $url      访问地址
     * @param  string       $depr     路径分隔符
     * @param  bool         $completeMatch   路由是否完全匹配
     * @return Dispatch
     */
    public function check($request, $url, $depr = '/', $completeMatch = false)
    {
        // 生成资源路由的路由规则
        $this->buildResourceRule($this->resource, $this->option);

        return parent::check($request, $url, $depr, $completeMatch);
    }

    /**
     * 生成资源路由规则
     * @access protected
     * @param  string    $rule       路由规则
     * @param  array     $option     路由参数
     * @return void
     */
    protected function buildResourceRule($rule, $option = [])
    {
        if (strpos($rule, '.')) {
            // 注册嵌套资源路由
            $array = explode('.', $rule);
            $last  = array_pop($array);
            $item  = [];

            foreach ($array as $val) {
                $item[] = $val . '/:' . (isset($option['var'][$val]) ? $option['var'][$val] : $val . '_id');
            }

            $rule = implode('/', $item) . '/' . $last;
        }

        // 注册分组
        $group = $this->router->getGroup();

        $this->router->setGroup($this);

        // 注册资源路由
        foreach ($this->rest as $key => $val) {
            if ((isset($option['only']) && !in_array($key, $option['only']))
                || (isset($option['except']) && in_array($key, $option['except']))) {
                continue;
            }

            if (isset($last) && strpos($val[1], ':id') && isset($option['var'][$last])) {
                $val[1] = str_replace(':id', ':' . $option['var'][$last], $val[1]);
            } elseif (strpos($val[1], ':id') && isset($option['var'][$rule])) {
                $val[1] = str_replace(':id', ':' . $option['var'][$rule], $val[1]);
            }

            $option['rest'] = $key;

            $this->router->rule(trim($val[1], '/'), $this->route . '/' . $val[2], $val[0], $option);
        }

        $this->router->setGroup($group);
    }

    /**
     * rest方法定义和修改
     * @access public
     * @param  string        $name 方法名称
     * @param  array|bool    $resource 资源
     * @return $this
     */
    public function rest($name, $resource = [])
    {
        if (is_array($name)) {
            $this->rest = $resource ? $name : array_merge($this->rest, $name);
        } else {
            $this->rest[$name] = $resource;
        }

        return $this;
    }

    /**
     * 设置资源允许
     * @access public
     * @param  array     $only
     * @return $this
     */
    public function only($only)
    {
        return $this->option('only', $only);
    }

    /**
     * 设置资源排除
     * @access public
     * @param  array     $except
     * @return $this
     */
    public function except($except)
    {
        return $this->option('except', $except);
    }

    /**
     * 设置资源路由的变量
     * @access public
     * @param  array     $vars
     * @return $this
     */
    public function vars($vars)
    {
        return $this->option('var', $vars);
    }

}

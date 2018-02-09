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

use think\Container;
use think\Request;
use think\Response;
use think\Route;
use think\route\dispatch\Response as ResponseDispatch;
use think\route\dispatch\Url as UrlDispatch;

class RuleGroup extends Rule
{
    // 分组路由（包括子分组）
    protected $rules = [
        '*'       => [],
        'get'     => [],
        'post'    => [],
        'put'     => [],
        'patch'   => [],
        'delete'  => [],
        'head'    => [],
        'options' => [],
    ];

    protected $rule;

    // MISS路由
    protected $miss;

    // 自动路由
    protected $auto;

    // 完整名称
    protected $fullName;

    /**
     * 架构函数
     * @access public
     * @param  Route       $router   路由对象
     * @param  RuleGroup   $group    路由所属分组对象
     * @param  string      $name     分组名称
     * @param  mixed       $rule     分组路由
     * @param  array       $option   路由参数
     * @param  array       $pattern  变量规则
     */
    public function __construct(Route $router, RuleGroup $group = null, $name = '', $rule = [], $option = [], $pattern = [])
    {
        $this->router  = $router;
        $this->parent  = $group;
        $this->rule    = $rule;
        $this->name    = trim($name, '/');
        $this->option  = $option;
        $this->pattern = $pattern;

        $this->setFullName();
    }

    /**
     * 设置分组的路由规则
     * @access public
     * @return $this
     */
    protected function setFullName()
    {
        if ($this->parent && $this->parent->getFullName()) {
            $this->fullName = $this->parent->getFullName() . ($this->name ? '/' . $this->name : '');
        } else {
            $this->fullName = $this->name;
        }
    }

    /**
     * 设置分组的路由规则
     * @access public
     * @param  mixed      $rule     路由规则
     * @return $this
     */
    public function setRule($rule)
    {
        $this->rule = $rule;
        return $this;
    }

    /**
     * 检测分组路由
     * @access public
     * @param  Request      $request  请求对象
     * @param  string       $url      访问地址
     * @param  string       $depr     路径分隔符
     * @param  bool         $completeMatch   路由是否完全匹配
     * @return Dispatch|false
     */
    public function check($request, $url, $depr = '/', $completeMatch = false)
    {
        if ($dispatch = $this->checkCrossDomain($request)) {
            // 允许跨域
            return $dispatch;
        }

        // 检查参数有效性
        if (!$this->checkOption($this->option, $request)) {
            return false;
        }

        if ($this->fullName) {
            // 分组URL匹配检查
            $pos = strpos(str_replace('<', ':', $this->fullName), ':');

            if (false !== $pos) {
                $str = substr($this->fullName, 0, $pos);
            } else {
                $str = $this->fullName;
            }

            if (0 !== stripos(str_replace('|', '/', $url), $str)) {
                return false;
            }
        }

        if ($this->rule) {
            // 延迟解析分组路由
            if ($this->rule instanceof Response) {
                return new ResponseDispatch($this->rule);
            }

            $group = $this->router->getGroup();

            $this->router->setGroup($this);

            $this->router->parseGroupRule($this, $this->rule);

            $this->router->setGroup($group);

            $this->rule = null;
        }

        // 分组匹配后执行的行为

        // 指定Response响应数据
        if (!empty($this->option['response'])) {
            Container::get('hook')->add('response_send', $this->option['response']);
        }

        // 开启请求缓存
        if (isset($this->option['cache']) && $request->isGet()) {
            $this->parseRequestCache($request, $this->option['cache']);
        }

        // 获取当前路由规则
        $method = strtolower($request->method());
        $rules  = array_merge($this->rules['*'], $this->rules[$method]);

        if ($this->parent) {
            // 合并分组参数
            $this->mergeGroupOptions();
        }

        if (isset($this->option['complete_match'])) {
            $completeMatch = $this->option['complete_match'];
        }

        if (!empty($this->option['append'])) {
            $request->route($this->option['append']);
        }

        if (isset($rules[$url])) {
            // 快速定位
            $item   = $rules[$url];
            $result = $item->check($request, $url, $depr, $completeMatch);

            if (false !== $result) {
                return $result;
            }
        }

        // 遍历分组路由
        foreach ($rules as $key => $item) {
            $result = $item->check($request, $url, $depr, $completeMatch);

            if (false !== $result) {
                return $result;
            }
        }

        if (isset($this->auto)) {
            // 自动解析URL地址
            $result = new UrlDispatch($this->auto->getRoute() . '/' . $url, ['depr' => $depr, 'auto_search' => false]);
        } elseif (isset($this->miss)) {
            // 未匹配所有路由的路由规则处理
            $result = $this->parseRule($request, '', $this->miss->getRoute(), $url, $this->miss->getOption());
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * 设置自动路由
     * @access public
     * @param  RuleItem     $rule   路由规则
     * @return $this
     */
    public function setAutoRule(RuleItem $rule)
    {
        $this->auto = $rule;
        return $this;
    }

    /**
     * 设置为MISS路由
     * @access public
     * @param  RuleItem     $rule   路由规则
     * @return $this
     */
    public function setMissRule(RuleItem $rule)
    {
        $this->miss = $rule;
        return $this;
    }

    /**
     * 添加分组下的路由规则或者子分组
     * @access public
     * @param  Rule     $rule   路由规则
     * @param  string   $method 请求类型
     * @return $this
     */
    public function addRule($rule, $method = '*')
    {
        if (strpos($method, '|')) {
            $rule->method($method);
            $method = '*';
        }

        $this->rules[$method][] = $rule;

        return $this;
    }

    /**
     * 设置分组的路由前缀
     * @access public
     * @param  string     $prefix
     * @return $this
     */
    public function prefix($prefix)
    {
        if ($this->parent->getOption('prefix')) {
            $prefix = $this->parent->getOption('prefix') . $prefix;
        }

        return $this->option('prefix', $prefix);
    }

    /**
     * 获取完整分组Name
     * @access public
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * 获取分组的路由规则
     * @access public
     * @param  string     $method
     * @return array
     */
    public function getRules($method = '')
    {
        if ('' === $method) {
            return $this->rules;
        } else {
            return isset($this->rules[strtolower($method)]) ? $this->rules[strtolower($method)] : [];
        }
    }

}

# VueThink
### 简介
```
VueThink是一套基于Vue全家桶（Vue2.x + Vue-router2.x + Vuex）+ Thinkphp的前后端分离框架。
脚手架构建也可以通过vue官方的vue-cli脚手架工具构建
实现了一般后台所需要的功能模块

* 登录、退出登录
* 修改密码、记住密码
* 菜单管理
* 系统参数
* 权限节点
* 岗位管理
* 部门管理
* 用户组管理
* 用户管理
```
### Demo
演示地址：<http://demo.vuethink.com>

用户名：user01

密码：user01

### 开发依赖
* vue <https://vuefe.cn/v2/guide/>
* element-ui@1.1.3  <http://element.eleme.io/1.1/#/zh-CN/component/installation>
* axios  <https://github.com/mzabriskie/axios>
* fontawesome <http://fontawesome.io/icons/>
* js-cookie  <https://github.com/js-cookie/js-cookie>
* lockr  <https://github.com/tsironis/lockr>
* lodash  <http://lodashjs.com/docs/>
* moment  <http://momentjs.cn/>


### 数据交互
数据交互通过axios以及RESTful架构来实现

用户校验通过登录返回的auth_key放在header

值得注意的一点是：跨域的情况下，会有预请求OPTION的情况

附上接口文档：<http://rap.taobao.org/workspace/myWorkspace.do?projectId=15385#128405>

### Server搭建
参考地址：<https://github.com/honraytech/VueThink/tree/master/php>

### 运行程序
```
程序运行之前需搭建好Server端
npm install
npm run dev
```

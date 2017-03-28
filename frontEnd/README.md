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


### 前端部署
```
部署前准备
1.安装node.js
  前端部分是基于node.js上运行的，所以必须先安装node.js，版本要求为6.9.0以上(推荐安装官方推荐版本)，下载地址：https://nodejs.org/zh-cn/
2.程序运行之前需搭建好Server端
  vueThink的后端搭建请参考这里（https://github.com/honraytech/VueThink/tree/master/php），此处不再多述。
  
完成以上两个步骤之后，我们进入到frontEnd这个目录，然后按顺序执行以下两行代码就可以愉快地玩耍了。
npm install
npm run dev

注意：前端服务启动，默认会占用8080端口，所以在启动前端服务之前，请确认8080端口没有被占用。如果想替换前端默认端口，可修改config/index.js里面的dev对象的port参数，但不建议这么做。另外接口请求本地服务的端口是80端口，如果配置后端服务的时候启动的不是80端口，可在build/webpack.base.conf.js里修改DEV_HOST（开发环境请求地址）。
```

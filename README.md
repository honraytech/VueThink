VueThink
===============
## 注意事项

该项目fork自：https://github.com/honraytech/VueThink

## 项目介绍
这个项目主要是改进了当时VueThink中存在的一些问题
* 1：修复添加菜单无法刷新，必须重新登录才能出现
* 2：修复菜单没有滚动条，当菜单过多的时候无法显示
* 3：修复对用户组编辑权限，按钮还显示
* 4：用jwt登录验证代替原有的登录验证机制
* 5：改进一部分样式问题
* 6：将webpack1升级至webpack3,提高了编译后的性能（webpack1没有treeShaking）
* 7: 将elementUI版本升级到elementUI2.x
* 8: 升级了项目前端使用vue-cli的版本
## 使用许可：
VueThink是基于MIT协议的开源框架，它完全免费。你可以免费下载VueThink，用来搭建自己的或者团体的软件。

##主要适用技术栈
* 后端框架：ThinkPHP 5.x
* 前端MVVM框架：Vue.JS 2.5.2
* 开发工作流：Webpack 3.6.0
* 路由：Vue-Router 3.0.1
* 数据交互：Axios
* 代码风格检测：Eslint
* UI框架：Element-UI 2.1.0
* JS函数库：Lodash

> VueThink的运行环境要求PHP5.4以上。

详细开发文档参考 [ThinkPHP5完全开发手册](http://www.kancloud.cn/manual/thinkphp5)

* 登录、退出登录
* 修改密码、记住密码
* 菜单管理
* 系统参数
* 权限节点
* 岗位管理
* 部门管理
* 用户组管理
* 用户管理

### 开发依赖
* vue <https://cn.vuejs.org/v2/guide/>
* element-ui@2.1.0 <http://element.eleme.io/#/zh-CN/component/installation>
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

附上接口文档：<http://api.vuethink.com>

### Server搭建
服务端使用的框架为thinkphp5.搭建前请确保拥有lamp/lnmp/wamp环境。

集成环境推荐使用phpstudy：<http://www.phpstudy.net/> 

这里所说的搭建其实就是把server框架放入WEB运行环境，并使用80端口。

导入服务端根文件夹数据库文件install.sql，(数据库内用户表账号admin，密码123456)并修改config/database.php配置文件。

* PHP >= 5.4.0
* PDO PHP Extension
* MBstring PHP Extension
* CURL PHP Extension

服务端开发手册请参考：<http://www.kancloud.cn/manual/thinkphp5/118003>

当访问 <http://localhost>, 出现“vuethink接口”即代表后端接口搭建成功。

p.s 如果使用的nginx服务，请设置重写规则
```
location / {

    if (!-e $request_filename) {

        rewrite ^(.*)$ /index.php?s=$1 last;

        break;

    }
}
```


### 前端搭建
```
cd frontEnd
npm run dev
```


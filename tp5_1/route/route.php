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

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');

Route::group('admin', function () {
    Route::group('base', function () {
        // 【基础】登录
        Route::rule('login', 'admin/base/login', 'POST|OPTIONS');
        // 【基础】记住登录
        Route::rule('relogin', 'admin/base/relogin', 'POST|OPTIONS');
        // 【基础】修改密码
        Route::rule('setInfo', 'admin/base/setInfo', 'POST|OPTIONS');
        // 【基础】退出登录
        Route::rule('logout', 'admin/base/logout', 'POST|OPTIONS');
        // 【基础】获取配置
        Route::rule('getConfigs', 'admin/base/getConfigs', 'POST|GET|OPTIONS');
        Route::rule('saveConfigs', 'admin/base/saveConfigs', 'POST|GET|OPTIONS');

        // 【基础】获取验证码
        Route::rule('getVerify', 'admin/base/getVerify', 'GET|OPTIONS');
    });
    Route::group('upload', function () {
        // 【基础】上传图片
        Route::rule('', 'admin/upload/index', 'POST|OPTIONS');
    });
    Route::group('systemconfigs', function () {
        // 保存系统配置
        Route::rule('save', 'admin/systemconfigs/save', 'POST|OPTIONS');
    });
    // 【规则】
    Route::group('rules', function () {
        // 获取全部
        Route::rule('', 'admin/rules/index', 'GET|POST|OPTIONS');
        Route::rule('/:id', 'admin/rules/read', 'GET|POST|OPTIONS')->pattern(['id' => '\d+']);
        // 批量删除
        Route::rule('deletes', 'admin/rules/deletes', 'POST|OPTIONS');
        Route::group('delete', function () {
            Route::rule('/:id', 'admin/rules/delete', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
        // 批量启用/禁用
        Route::rule('enables', 'admin/rules/enables', 'POST|OPTIONS');
        Route::rule('save', 'admin/rules/save', 'POST|OPTIONS');
        Route::group('update', function () {
            Route::rule('/:id', 'admin/rules/update', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
    });
    // 【用户组】
    Route::group('groups', function () {
        // 获取全部
        Route::rule('', 'admin/groups/index', 'GET|POST|OPTIONS');
        Route::rule('/:id', 'admin/groups/read', 'GET|POST|OPTIONS')->pattern(['id' => '\d+']);
        // 批量删除
        Route::rule('deletes', 'admin/groups/deletes', 'POST|OPTIONS');
        Route::group('delete', function () {
            Route::rule('/:id', 'admin/groups/delete', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
        // 批量启用/禁用
        Route::rule('enables', 'admin/groups/enables', 'POST|OPTIONS');
        Route::rule('save', 'admin/groups/save', 'POST|OPTIONS');
        Route::group('update', function () {
            Route::rule('/:id', 'admin/groups/update', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
    });
    // 【用户组】
    Route::group('users', function () {
        // 获取全部用户信息
        Route::rule('', 'admin/users/index', 'GET|POST|OPTIONS');
        // 获取全部用户信息
        Route::rule('/:id', 'admin/users/read', 'GET|POST|OPTIONS')->pattern(['id' => '\d+']);
        // 批量删除
        Route::rule('deletes', 'admin/users/deletes', 'POST|OPTIONS');
        Route::group('delete', function () {
            Route::rule('/:id', 'admin/users/delete', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
        // 批量启用/禁用
        Route::rule('enables', 'admin/users/enables', 'POST|OPTIONS');
        // 保存
        Route::rule('save', 'admin/users/save', 'POST|OPTIONS');
        // 修改
        Route::group('update', function () {
            Route::rule('/:id', 'admin/users/update', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
    });
    // 【菜单】
    Route::group('menus', function () {
        // 获取全部
        Route::rule('', 'admin/menus/index', 'GET|POST|OPTIONS');
        Route::rule('/:id', 'admin/menus/read', 'GET|POST|OPTIONS')->pattern(['id' => '\d+']);
        // 批量删除
        Route::rule('deletes', 'admin/menus/deletes', 'POST|OPTIONS');
        Route::group('delete', function () {
            Route::rule('/:id', 'admin/menus/delete', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
        // 批量启用/禁用
        Route::rule('enables', 'admin/menus/enables', 'POST|OPTIONS');
        Route::rule('save', 'admin/menus/save', 'POST|OPTIONS');
        Route::group('update', function () {
            Route::rule('/:id', 'admin/menus/update', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
    });
    // 【组织架构】
    Route::group('structures', function () {
        // 获取全部
        Route::rule('', 'admin/structures/index', 'GET|POST|OPTIONS');
        Route::rule('/:id', 'admin/structures/read', 'GET|POST|OPTIONS')->pattern(['id' => '\d+']);
        // 批量删除
        Route::rule('deletes', 'admin/structures/deletes', 'POST|OPTIONS');
        Route::group('delete', function () {
            Route::rule('/:id', 'admin/structures/delete', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
        // 批量启用/禁用
        Route::rule('enables', 'admin/structures/enables', 'POST|OPTIONS');
        Route::rule('save', 'admin/structures/save', 'POST|OPTIONS');
        Route::group('update', function () {
            Route::rule('/:id', 'admin/structures/update', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
    });
    // 【部门】
    Route::group('posts', function () {
        // 获取全部
        Route::rule('', 'admin/posts/index', 'GET|POST|OPTIONS');
        Route::rule('/:id', 'admin/posts/read', 'GET|POST|OPTIONS')->pattern(['id' => '\d+']);
        // 批量删除
        Route::rule('deletes', 'admin/posts/deletes', 'POST|OPTIONS');
        Route::group('delete', function () {
            Route::rule('/:id', 'admin/posts/delete', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
        // 批量启用/禁用
        Route::rule('enables', 'admin/posts/enables', 'POST|OPTIONS');
        Route::rule('save', 'admin/posts/save', 'POST|OPTIONS');
        Route::group('update', function () {
            Route::rule('/:id', 'admin/posts/update', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
    });
})->header('Access-Control-Allow-Origin', '*')
    ->header('Access-Control-Allow-Credentials', 'true')
    ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
    ->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, sessionId, authKey')
    ->allowCrossDomain();

Route::group('index', function () {
    Route::group('base', function () {
        // 【基础】登录
        Route::rule('login', 'index/base/login', 'POST|OPTIONS');
        // 【基础】记住登录
        Route::rule('relogin', 'index/base/relogin', 'POST|OPTIONS');
        // 【基础】修改密码
        Route::rule('setInfo', 'index/base/setInfo', 'POST|OPTIONS');
        // 【基础】退出登录
        Route::rule('logout', 'index/base/logout', 'POST|OPTIONS');
        // 【基础】获取配置
        Route::rule('getConfigs', 'index/base/getConfigs', 'POST|GET|OPTIONS');
        Route::rule('saveConfigs', 'index/base/saveConfigs', 'POST|GET|OPTIONS');

        // 【基础】获取验证码
        Route::rule('getVerify', 'index/base/getVerify', 'GET|OPTIONS');
    });
    Route::group('upload', function () {
        // 【基础】上传图片
        Route::rule('', 'index/upload/index', 'POST|OPTIONS');
    });
    Route::group('systemconfigs', function () {
        // 保存系统配置
        Route::rule('save', 'index/systemconfigs/save', 'POST|OPTIONS');
    });
    // 【规则】
    Route::group('rules', function () {
        // 获取全部
        Route::rule('', 'index/rules/index', 'GET|POST|OPTIONS');
        Route::rule('/:id', 'index/rules/read', 'GET|POST|OPTIONS')->pattern(['id' => '\d+']);
        // 批量删除
        Route::rule('deletes', 'index/rules/deletes', 'POST|OPTIONS');
        Route::group('delete', function () {
            Route::rule('/:id', 'index/rules/delete', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
        // 批量启用/禁用
        Route::rule('enables', 'index/rules/enables', 'POST|OPTIONS');
        Route::rule('save', 'index/rules/save', 'POST|OPTIONS');
        Route::group('update', function () {
            Route::rule('/:id', 'index/rules/update', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
    });
    // 【用户组】
    Route::group('groups', function () {
        // 获取全部
        Route::rule('', 'index/groups/index', 'GET|POST|OPTIONS');
        Route::rule('/:id', 'index/groups/read', 'GET|POST|OPTIONS')->pattern(['id' => '\d+']);
        // 批量删除
        Route::rule('deletes', 'index/groups/deletes', 'POST|OPTIONS');
        Route::group('delete', function () {
            Route::rule('/:id', 'index/groups/delete', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
        // 批量启用/禁用
        Route::rule('enables', 'index/groups/enables', 'POST|OPTIONS');
        Route::rule('save', 'index/groups/save', 'POST|OPTIONS');
        Route::group('update', function () {
            Route::rule('/:id', 'index/groups/update', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
    });
    // 【用户组】
    Route::group('users', function () {
        // 获取全部用户信息
        Route::rule('', 'index/users/index', 'GET|POST|OPTIONS');
        // 获取全部用户信息
        Route::rule('/:id', 'index/users/read', 'GET|POST|OPTIONS')->pattern(['id' => '\d+']);
        // 批量删除
        Route::rule('deletes', 'index/users/deletes', 'POST|OPTIONS');
        Route::group('delete', function () {
            Route::rule('/:id', 'index/users/delete', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
        // 批量启用/禁用
        Route::rule('enables', 'index/users/enables', 'POST|OPTIONS');
        // 保存
        Route::rule('save', 'index/users/save', 'POST|OPTIONS');
        // 修改
        Route::group('update', function () {
            Route::rule('/:id', 'index/users/update', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
    });
    // 【菜单】
    Route::group('menus', function () {
        // 获取全部
        Route::rule('', 'index/menus/index', 'GET|POST|OPTIONS');
        Route::rule('/:id', 'index/menus/read', 'GET|POST|OPTIONS')->pattern(['id' => '\d+']);
        // 批量删除
        Route::rule('deletes', 'index/menus/deletes', 'POST|OPTIONS');
        Route::group('delete', function () {
            Route::rule('/:id', 'index/menus/delete', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
        // 批量启用/禁用
        Route::rule('enables', 'index/menus/enables', 'POST|OPTIONS');
        Route::rule('save', 'index/menus/save', 'POST|OPTIONS');
        Route::group('update', function () {
            Route::rule('/:id', 'index/menus/update', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
    });
    // 【组织架构】
    Route::group('structures', function () {
        // 获取全部
        Route::rule('', 'index/structures/index', 'GET|POST|OPTIONS');
        Route::rule('/:id', 'index/structures/read', 'GET|POST|OPTIONS')->pattern(['id' => '\d+']);
        // 批量删除
        Route::rule('deletes', 'index/structures/deletes', 'POST|OPTIONS');
        Route::group('delete', function () {
            Route::rule('/:id', 'index/structures/delete', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
        // 批量启用/禁用
        Route::rule('enables', 'index/structures/enables', 'POST|OPTIONS');
        Route::rule('save', 'index/structures/save', 'POST|OPTIONS');
        Route::group('update', function () {
            Route::rule('/:id', 'index/structures/update', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
    });
    // 【部门】
    Route::group('posts', function () {
        // 获取全部
        Route::rule('', 'index/posts/index', 'GET|POST|OPTIONS');
        Route::rule('/:id', 'index/posts/read', 'GET|POST|OPTIONS')->pattern(['id' => '\d+']);
        // 批量删除
        Route::rule('deletes', 'index/posts/deletes', 'POST|OPTIONS');
        Route::group('delete', function () {
            Route::rule('/:id', 'index/posts/delete', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
        // 批量启用/禁用
        Route::rule('enables', 'index/posts/enables', 'POST|OPTIONS');
        Route::rule('save', 'index/posts/save', 'POST|OPTIONS');
        Route::group('update', function () {
            Route::rule('/:id', 'index/posts/update', 'PUT|POST|OPTIONS')->pattern(['id' => '\d+']);
        });
    });
})->header('Access-Control-Allow-Origin', '*')
    ->header('Access-Control-Allow-Credentials', 'true')
    ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
    ->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, sessionId, authKey')
    ->allowCrossDomain();


return [
// 定义资源路由
    '__rest__' => [
        'admin/rules' => 'admin/rules',
        'admin/groups' => 'admin/groups',
        'admin/users' => 'admin/users',
        'admin/menus' => 'admin/menus',
        'admin/structures' => 'admin/structures',
        'admin/posts' => 'admin/posts',
    ],

    // MISS路由
    '__miss__' => 'admin/base/miss',
];

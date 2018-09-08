<?php

/**
 * 行为绑定
 */
//\think\facade\Hook::add('app_init','app\common\behavior\InitConfigBehavior');

\think\facade\Hook::add('app_init', function () {
    // $host_name = isset($_SERVER['HTTP_ORIGIN'])?$_SERVER['HTTP_ORIGIN']:"*"; 
    // header("Access-Control-Allow-Origin", $host_name); 
    // header("Access-Control-Allow-Credentials", "true"); 
    // header("Access-Control-Allow-Headers", "x-token,x-uid,x-token-check,x-requested-with,content-type,Host"); 

    //读取数据库中的配置
    $system_config = cache('DB_CONFIG_DATA'); 
    if ( ! $system_config) {
        //获取所有系统配置
        $system_config = model('common/SystemConfig') -> getDataList(); 
        cache('DB_CONFIG_DATA', null); 
        cache('DB_CONFIG_DATA', $system_config, 36000); //缓存配置
}
    config($system_config); //添加配置
}); 

/**
 * 返回对象
 * @param $array 响应数据
 */
function resultArray($array) {
    if (isset($array['data'])) {
        $array['error'] = ''; 
        $code = 200; 
    }elseif (isset($array['error'])) {
        $code = 400; 
        $array['data'] = ''; 
    }
    return json([
        'code' => $code, 
        'data' => $array['data'], 
        'error' => $array['error'], 
    ]); 
}

/**
 * 调试方法
 * @param  array   $data  [description]
 */
function p($data, $die = 1) {
    echo "<pre>"; 
    print_r($data); 
    echo "</pre>"; 
    if ($die) {
        die; 
    }

}

/**
 * 用户密码加密方法
 * @param  string $str      加密的字符串
 * @param  [type] $auth_key 加密符
 * @return string           加密后长度为32的字符串
 */
function user_md5($str, $auth_key = '') {
    return '' === $str?'':md5(sha1($str) . $auth_key); 
}

<?php
return array(
	//'配置项'=>'配置值'
	/* 数据库设置 */
    'DB_HOST' => '127.0.0.1',//"203.130.44.170", //session存数据库必须参数
    'DB_NAME' => "cszb_syncdb", //session存数据库必须参数
    'DB_TYPE' => 'mysql',     // 数据库类型
    'DB_USER' => 'root',      // 用户名
    'DB_PWD' => 'liulinyan',// 密码
    'DB_PORT' => '3306',        // 端口
    'DB_PREFIX' => '',    // 数据库表前缀
    'DB_FIELDS_CACHE' => true,        // 启用字段缓存
    'DB_DEBUG' => TRUE,
    'DB_DSN' => 'mysql:host=127.0.0.1;dbname=cszb_syncdb;charset=UTF8;',
    'DB_PARAMS' => array(
        PDO::ATTR_PERSISTENT => true
        //PDO::ATTR_TIMEOUT => 5,
        //PDO::ATTR_CASE => \PDO::CASE_NATURAL
    ),
    /* 模板引擎设置 */
    'LAYOUT_ON' => false,    // 开启模板
    //'LAYOUT_NAME' => 'layout',    //定义模板文件

	/* Cookie设置 */
    'COOKIE_EXPIRE' => 24*60*60,    // Coodie有效期
    //'COOKIE_DOMAIN' => '.kela.cn',      // Cookie有效域名
    'COOKIE_PATH' => '/',     // Cookie路径
    'COOKIE_SECURITY_KEY' => 'cn.lly',
	
	// 加载扩展配置文件
	//'LOAD_EXT_CONFIG' => array('USER'=>'user','DB'=>'db'),
	//URL地址不区分大小写
	'URL_CASE_INSENSITIVE'  =>  true,
	//0普通模式、1PATHINFO、2REWRITE和3兼容模式，可以设置URL_MODEL参数改变URL模式
	'URL_MODEL' =>2,
	'ACTION_SUFFIX'=>  'Action',
	// URL禁止访问的后缀设置
	'URL_DENY_SUFFIX' => 'pdf|ico|png|gif|jpg',

    'URL_PARAMS_BIND' => true,
    'URL_PARAMS_BIND_TYPE' => 0,
    'URL_HTML_SUFFIX' => "",
	// 系统默认的变量过滤机制
	'DEFAULT_FILTER' => 'strip_tags,htmlspecialchars',
	//自动加载其他的类库
	'AUTOLOAD_NAMESPACE' => array(
        'Common'     => ROOT.'/Common',
        'Think' => ROOT.'/Corlib/Libarary/Think'
    )
);
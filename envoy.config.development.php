<?php
/**
 * Envoy deployment script config file
 */
/**
 * application name
 */

$app_name = 'mijia-api';

/**
 * server settings
 * conn : remote server connection string

 * owner : (optional) remote server service user/owner(group) that run the php-fpm/nginx and the application files
 * permissions.
 *
 * @example row set: 'webserver1'=>['conn'=>'-p 2222 vagrant@127.0.0.1','owner'=>'vagrant'],
 * @example row set: 'webserver2'=>['user@191.168.1.10 -p2222','user'],
 * @example row set: 'root@example.com',
 */
$server_connections = [

    'she-test-01' => 'deployUser@deployIP',
    //    'webserver1'=>['conn'=>'-p 2222 vagrant@127.0.0.1','owner'=>'vagrant'],
    //    'webserver2'=>['user@191.168.1.10 -p2222','user'],
    //    'root@example.com',
];

/**
 * @notice  http/https protocol might be ask for password for your private repos
 *  and that will break the git clone progress,use git protocol instead
 * @example 'git@localhost:user/myrepo.git'
 */
$source_repo = 'ssh://git@47.52.28.117:10022/shaozeming/mijia-api.git';

$source_name = 'source';

/**
 * deployment base path
 *
 * @example '/var/www'
 */
$deploy_basepath = '/home/sheye/deploy';

$php_fpm_bin = '/etc/init.d/php7.1-fpm';

$apidoc_command = 'apidoc -i app/Http/Controllers/ -o public/apidoc';  //生成文档命令,需要目标服务器上已安装 apidoc 否则报错


/**
 * pack mode local | remote

 * local : checkout code and prepare the app code package locally,then pack and rsync/scp packed files to remote and
 * extract on remote (good for small vps but scp cost bandwidth) remote : checkout code and prepare the app code
 * package on remote server (fast for good network connection)
 */
$pack_mode = 'remote';

/**
 * deploy mode incr | link

 * incr : sync new code to current running path (if you have lot of code and resource files in your project ,you may
 * choose this mode) link : link new release path to current running path (if you want light and quick code deployment,
 * you may choose this mode)
 */
$deploy_mode = 'link';

/**
 * number of releases keep on remote
 */

$release_keep_count = 3;

/**
 * git sub-module deployed path map source-tree subdir-path -> sub-module deployed path.
 */
$submodule_pathmap = [
    //'lib/mymod'=>'/var/www/mysubmodproject/current',
];

/**
 * shared sub-directories name , eg: storage
 */
$shared_subdirs = [
    'storage',
    'public/uploads',
];


//公共文件上传目录，确保您有权限
$upload_dir = $deploy_basepath.'/uploads';
/**
 * addon exclude pattens , eg: /node_modules/
 */
$exclude_addon_pattens = [

     'node_modules',
     'vendor',
];

/**
 * Misc. Settings
 */
$settings = [
    // default env set

    'env_default'                         => 'development',
    //执行npm选择
    'env_npm' => 'production',
    // default branch set
    'branch_default'                      => 'develop',
//    'branch_default'                      => 'develop_swoole',
    // default remote server service user(group) that run the php-fpm/nginx and the application files permissions.
    // @example 'www-data'
    'service_owner_default'               => 'www-data',
    // default server prefix for named user at host alias.
    // @example 'server'
    'server_prefix_default'               => '',
    // vcs update local workingcopy before deployment.
    'workingcopy_update'                  => false,
    // depends install for local workingcopy before deployment.
    'workingcopy_deps_install'            => false,
    // use shared base app_path env file.
    'use_appbase_envfile'                 => true,
    // depends install components settings.
    'deps_install_component'              => [
        'composer' => true,
        'npm'      => false,
        'bower'    => false,
        'gulp'     => false,
    ],
    'deps_install_command'                => [
        'composer' => 'composer install --prefer-dist --no-dev --no-scripts --no-interaction && composer dump-autoload --optimize',
        'npm'      => 'npm install',
        'bower'    => 'bower install',
        'gulp'     => 'gulp',

    ],
    'runtime_optimize_component'          => [
        'composer' => true,
        'artisan'  => [
            'optimize'     => true,
            'config_cache' => true,
            'route_cache'  => true,
        ],
    ],
    'runtime_optimize_command'            => [
        'composer' => 'composer dump-autoload --optimize',
        'artisan'  => [
            'optimize'     => 'php artisan clear-compiled && php artisan optimize',
            'config_cache' => 'php artisan config:clear && php artisan config:cache',
            'route_cache'  => 'php artisan route:clear && php artisan api:cache',   //这人使用api:cache 是用的dingo 命令，
        ],
    ],
    // do database migrate on deploy
    'databasemigrate_on_deploy'           => false,
    // allow extra custom files overwrite.
    'extracustomoverwrite_enable'         => false,
    // depends reinstall on remote release.
    'deps_reinstall_on_remote_release'    => true,
    // do database migrate rollback on rollback
    'databasemigraterollback_on_rollback' => false,
    // enable custom task after deploy
    'enable_custom_task_after_deploy'     => true,
];

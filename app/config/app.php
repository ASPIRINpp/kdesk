<?php defined('APP_PATH') or die('Access denied!');

return [
    'app_name' => 'Super test',
    'lang' => 'ru',
    'locale' => 'russian',
    'components' => [
        'core:cookie' => [
            'enable_salt' => FALSE,
            // WARNING: change this value
            'salt' => '\Gm!Ud№Qy_lrXwBa3Htd}"),Tw}>AX>3'
        ],
        'core:session' => [
            'enable' => TRUE
        ],
        'core:route' => [
            'default_controller' => 'default',
            'default_action' => 'index',
            'routes' => [
                'finance' => [['controller' => 'finance', 'action' => 'index']],
                'profile(/<login>)' => [['controller' => 'profile', 'action' => 'index'], ['login' => '\w+']],
                'project/<id>' => [['controller' => 'project', 'action' => 'index'], ['id' => '\d+']],
                'manage/<id>' => [['controller' => 'project', 'action' => 'manage'], ['id' => '\d+']],
            ]
        ],
        'db:mysql' => [
            'srv_global' => ['h' => 'localhost', 'd' => 'kdesk', 'u' => 'root', 'p' => '', 'charset' => 'utf8'],
            'srv_users' => ['h' => 'localhost', 'd' => 'kdesk_users', 'u' => 'root', 'p' => '', 'charset' => 'utf8'],
            'srv_projects_1' => ['h' => 'localhost', 'd' => 'kdesk_projects_1', 'u' => 'root', 'p' => '', 'charset' => 'utf8'],
            'srv_projects_2' => ['h' => 'localhost', 'd' => 'kdesk_projects_2', 'u' => 'root', 'p' => '', 'charset' => 'utf8'],
            'srv_search' => ['h' => 'localhost', 'd' => 'kdesk_search', 'u' => 'root', 'p' => '', 'charset' => 'utf8'],
        ]
    ]
];

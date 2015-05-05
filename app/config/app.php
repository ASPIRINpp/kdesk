<?php defined('APP_PATH') or die('Access denied!');

return [
    'app_name' => 'Super test',
    'lang' => 'ru',
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
                'project/<id>' => [['controller' => 'project', 'action' => 'index'], ['id' => '\d+']],
                'manage/<id>' => [['controller' => 'project', 'action' => 'manage'], ['id' => '\d+']],
            ]
        ],
        'db:mysql' => [
            'srv0' => ['h' => 'localhost', 'd' => 'kdesk', 'u' => 'root', 'p' => '']
        ]
    ]
];

<?php defined('APP_PATH') or die('Access denied!');

return [
    'app_name' => 'Super test',
    'components' => [
        'core:route' => [
            'default_controller' => 'default',
            'default_action' => 'index',
            'routes' => []
        ],
        'db:mysql' => [
            'srv0' => ['h' => 'localhost', 'd' => 'kdesk', 'u' => 'root', 'p' => '']
        ]
    ]
];

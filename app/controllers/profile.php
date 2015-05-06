<?php defined('APP_PATH') or die('Access denied!');

return [
    'action:index' => function($params) {
        $login = f('helpers:arr:get', 'login', $params, f('core:session:get', 'login'));
         f('core:view:render', 'profile/index', ['profile' => m('sys_users:get_data_by_login', $login)]);
    }
];
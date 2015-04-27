<?php defined('APP_PATH') or die('Access denied!');

return [
    'action:index' => function() {
        $r = null;
        if(!empty($_GET['email'])) {
            $email = f('helpers:arr:get', 'email', $_GET);
            $r = m('sys_users:email_exist', $email);
        }
        f('core:view:compile', 'default/index', ['r' => $r]);
        f('core:view:render');
    },
    'action:test' => function() {
        echo 'Action test!';
    }
];

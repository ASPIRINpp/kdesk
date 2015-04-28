<?php defined('APP_PATH') or die('Access denied!');

return [
    'action:index' => function() {
        $r = FALSE;
        $msg = '';
        if (!empty($_GET['email'])) {
            $email = f('helpers:arr:get', 'email', $_GET);
            if (!f('helpers:validation:email', $email)) {
                $msg = 'Email not valid';
            }
            $r = !m('sys_users:email_exist', $email);
            if (!$r) {
                $msg = 'Email already exist';
            }
        }
        f('core:view:render', 'default/index', ['r' => $r, 'msg' => $msg]);
    },
    'action:test' => function() {
        echo 'Action test!';
    }
];
        
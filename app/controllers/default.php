<?php defined('APP_PATH') or die('Access denied!');

return [
    'action:index' => function() {
        $sql = 'INSERT'
            . ' INTO sys_users (email, `password`, surname, `name`, middlename, sex, date_reg, deleted)'
            . ' VALUES (:email, :password, :surname, :name, :middlename, :sex, :date_reg, :deleted);';
        $r = f('db:mysql:q_insert', $sql, [
            ':email' => uniqid('Tester_') . '@example.com',
            ':password' => f('helpers:password:hash', '123123'),
            ':surname' => NULL,
            ':name' => uniqid('Tester_'),
            ':middlename' => NULL,
            ':sex' => rand(0, 1),
            ':date_reg' => time(),
            ':deleted' => FALSE
        ]);
        f('core:view:compile', 'default/index', ['r' => $r]);
        f('core:view:render');
    },
    'action:test' => function() {
        echo 'Action test!';
    }
];

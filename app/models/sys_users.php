<?php

return [
    'sys_users:email_exist' => function($email) {
        $sql = 'SELECT COUNT(id) AS bool FROM sys_users WHERE email = :email;';
        return (bool) f('db:mysql:q_scalar', $sql, [':email' => $email], 'bool');
    }
];
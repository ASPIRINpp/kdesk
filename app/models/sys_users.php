<?php defined('APP_PATH') or die('Access denied!');

return [
    'sys_users:email_exist' => function($email) {
        $sql = 'SELECT COUNT(id) AS bool FROM sys_users WHERE email = :email;';
        return (bool) f('db:mysql:q_scalar', $sql, [':email' => $email], 'bool');
    },
    'sys_users:login_exist' => function($login) {
        $sql = 'SELECT COUNT(id) AS bool FROM sys_users WHERE login = :login;';
        return (bool) f('db:mysql:q_scalar', $sql, [':login' => $login], 'bool');
    },
    'sys_users:check_password' => function($email, $password) {
        $sql = 'SELECT password FROM sys_users WHERE email = :email;';
        $hash =  f('db:mysql:q_scalar', $sql, [':email' => $email], 'password');
        return f('helpers:password:verify', $password, $hash);
    },
    'sys_users:get_data_by_email' => function($email) {
        $sql = 'SELECT * FROM sys_users WHERE email = :email;';
        return f('db:mysql:q_current', $sql, [':email' => $email]);
    },
    'sys_users:get_data_by_login' => function($login) {
        $sql = 'SELECT * FROM sys_users WHERE login = :login;';
        return f('db:mysql:q_current', $sql, [':login' => $login]);
    },
    'sys_users:add_user' => function($email, $login, $password, $name, $sex, $surname = NULL, $middlename = NULL) {
        $password = f('helpers:password:hash', $password);
        $sql = 'INSERT INTO sys_users'
            .' (email, login, password, surname, name, middlename, sex, time_reg) VALUES'
            .' (:email, :login, :password, :surname, :name, :middlename, :sex, :time_reg)';
        return f('db:mysql:q_insert', $sql, [
            ':email' => $email,
            ':login' => $login,
            ':password' => $password,
            ':surname' => $surname,
            ':name' => $name,
            ':middlename' => $middlename,
            ':sex' => $sex,
            ':time_reg' => time(),
        ]);
    },
    'sys_users:set_authkey' => function($id, $key) {
        $sql = 'UPDATE sys_users'
            .' SET auth_key = :auth_key, time_last_login = :time_last_login, time_last_activity = :time_last_activity'
            .' WHERE id = :id;';
        $t = time();
        return f('db:mysql:q_insert', $sql, [
            ':id' => (int) $id,
            ':auth_key' => $key,
            ':time_last_login' => $t,
            ':time_last_activity' => $t,
        ]);
    },
    'sys_users:get_money' => function($id, $key = FALSE) {
        $sql = 'SELECT money, money_reserve FROM sys_users WHERE id = :id;';
        $data = f('db:mysql:q_current', $sql, [':id' => (int) $id]);
        return $key ? $data[$key] : $data;
    },
    'sys_users:reserve_money' => function($id, $amount) {
        $sql = 'UPDATE sys_users SET money = money - :amount, money_reserve = money_reserve + :amount WHERE id = :id;';
        return f('db:mysql:q_update', $sql, [':id' => (int) $id, ':amount' => (int) $amount]);
    },
    'sys_users:dec_reserve_money' => function($id, $amount) {
        $sql = 'UPDATE sys_users SET money_reserve = money_reserve - :amount WHERE id = :id;';
        return f('db:mysql:q_update', $sql, [':id' => (int) $id, ':amount' => (int) $amount]);
    },
    'sys_users:inc_money' => function($id, $amount) {
        $sql = 'UPDATE sys_users SET money = money + :amount WHERE id = :id;';
        return f('db:mysql:q_update', $sql, [':id' => (int) $id, ':amount' => (int) $amount]);
    }
];
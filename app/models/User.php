<?php defined('APP_PATH') or die('Access denied!');

return [
    /**
     * 
     */
    'User:reg' => function($data) {
        // Validation
        $r = f('helpers:validation:check', $data, [
            // Not empty
            ['email', 'not_empty'],
            ['login', 'not_empty'],
            ['name', 'not_empty'],
            ['password', 'not_empty'],
            ['repeatPassword', 'not_empty'],
            ['sex', 'not_empty'],
            // Check values
            ['email', 'email'],
            ['email', 'callback', [function($email) {
                // @todo optimize this if statement
                if(f('helpers:validation:email', $email)) {
                    return !m('sys_users:email_exist', $email);
                }
            }, 'email_exist']],
            ['login', 'login'],
            ['login', 'callback', [function($login) {
                // @todo optimize this if statement
                if(f('helpers:validation:login', $login)) {
                    return !m('sys_users:login_exist', $login);
                }
            }, 'login_exist']],
            ['name', 'alpha', [TRUE]],
            ['middleName', 'alpha', [TRUE]],
            ['surname', 'alpha', [TRUE]],
            ['sex', 'range', [0, 1]],
            ['repeatPassword', 'equals', [f('helpers:arr:get', 'password', $data)]],
        ]);

        if($r['success']) {
            // Woohoo
            list($id, $rows) = m('sys_users:add_user'
                , $data['email']
                , $data['login']
                , $data['password']
                , $data['name']
                , $data['sex']
                , f('helpers:arr:get', 'surname', $data)
                , f('helpers:arr:get', 'middlename', $data));
            if($rows) {
                // @todo Send email
                $data['id'] = $id;
                return ['success' => TRUE, 'data' => $data];
            } else {
                // Uknown error
                return ['success' => FALSE];
            }
        } else {
            // Validation errors
            return $r;
        }
    },
    /**
     * 
     */
    'User:login' => function($data) {
        // @todo optimization sql queries
        $r = f('helpers:validation:check', $data, [
            ['email', 'not_empty'],
            ['password', 'not_empty'],
            ['email', 'email'],
            ['email', 'callback', [function($email) {
                // @todo optimize this if statement
                if(f('helpers:validation:email', $email)) {
                    return m('sys_users:email_exist', $email);
                }
            }, 'email_exist']]
        ]);

        if($r['success']) {
            if(!m('sys_users:check_password', $data['email'], $data['password'])) {
                return ['success' => FALSE, 'password' => ['check']];
            } else {
                $user = m('sys_users:get_data_by_email', $data['email']);
                f('core:auth:login', $user['id'], [
                    'email' => $user['email'], 
                    'login' => $user['login'], 
                    'money' => $user['money'], 
                    'money_reserve' => $user['money_reserve']
                ]);
                return ['success' => TRUE];
            }
        } else {
            return $r;
        }
    }
];
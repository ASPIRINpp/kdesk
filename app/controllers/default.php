<?php defined('APP_PATH') or die('Access denied!');

return [
    'action:index' => function() {
        // Profiling
        f('core:profiling:start');

        // Get form data
        // @todo optimization sql queries
        if(isset($_POST['Login'])) {
            $r = f('helpers:validation:check', $_POST['Login'], [
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
                $r['success'] = m('sys_users:check_password', $_POST['Login']['email'], $_POST['Login']['password']);
                if(!$r['success']) {
                    $r['errors']['password'] = ['check'];
                } else {
                    $user = m('sys_users:get_data_by_email', $_POST['Login']['email']);
                    f('core:auth:login', $user['id'], [
                        'email' => $user['email'], 
                        'login' => $user['login'], 
                        'money' => $user['money'], 
                        'money_reserve' => $user['money_reserve']
                    ]);
                    f('core:response:redirect', '/');
                    return;
                }
            }
        }

        // Render
        if(!f('core:auth:logged')) {
            f('core:view:compile', 'elements/_howitworks');
        }
        f('core:view:render', 'default/index', ['projects' => m('dk_projects:get_last'), 'r' => $r]);

        f('core:profiling:end');
        echo f('core:profiling:js_log');
    },
    /**
     * Logout
     */
    'action:logout' => function() {
        f('core:auth:logout');
        f('core:response:redirect', '/');
    },
    /**
     * Registration new user
     */
    'action:registration' => function() {
        if(f('core:auth:logged')) {
            f('core:response:redirect', '/');
            return;
        }

        // Get form data
        if(isset($_POST['Reg'])) {
            // Validation
            // @todo check email & login already used
            $r = f('helpers:validation:check', $_POST['Reg'], [
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
                ['repeatPassword', 'equals', [f('helpers:arr:get', 'password', $_POST['Reg'])]],
            ]);

            if($r['success']) {
                // Woohoo
                // @todo Maybe rewrite in to model?
                list($id, $rows) = m('sys_users:add_user'
                    , $_POST['Reg']['email']
                    , $_POST['Reg']['login']
                    , $_POST['Reg']['password']
                    , $_POST['Reg']['name']
                    , $_POST['Reg']['sex']
                    , f('helpers:arr:get', 'surname', $_POST['Reg'])
                    , f('helpers:arr:get', 'middlename', $_POST['Reg']));
                if($rows) {
                    // @todo Send email
                    f('core:auth:login', $id, ['email' => $_POST['Reg']['email'], 'login' => $_POST['Reg']['login']]);
                    f('core:response:redirect', '/');
                } else {
                    // Send error page
                    f('core:response:redirect', '/error/500');
                }
            } else {
                // Something wrong... Encode values...
                foreach ($_POST['Reg'] as &$val) {
                    $val = f('helpers:string:html_encode', $val);
                }
            }
        }

        // Render
        f('core:view:render', 'default/registration', ['res' => $r['errors']]);
    }
];


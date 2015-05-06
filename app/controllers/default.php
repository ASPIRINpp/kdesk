<?php defined('APP_PATH') or die('Access denied!');

return [
    'action:index' => function() {
        // Start profiling
        f('core:profiling:start');
        
        $alerts = '';
        // Get form data
        if(isset($_POST['Login'])) {
            $r = m('User:login', $_POST['Login']);
            if($r['success']) {
                f('core:response:redirect', '/');
            } else {
                if(isset($_POST['Reg']['email'])) {
                    $_POST['Reg']['email'] = f('helpers:string:html_encode', $_POST['Reg']['email']);
                }
                // Create alert
                $alerts .= f('core:view:print', 'elements/_alert', [
                    'type' => 'danger',
                    'text' => '<b>Validation errors!</b>'
                    . ' Please check next errors:' .
                    f('helpers:validation:compile_errors', $r['errors'], TRUE)
                ], TRUE);
            }
        }

        // Render
        f('core:view:set_global', 'alerts', $alerts);
        if(!f('core:auth:logged')) {
            f('core:view:compile', 'elements/_howitworks');
        }
        f('core:view:render', 'default/index', ['projects' => m('dk_projects:get_last')]);
        
        // End profiling
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
            return f('core:response:redirect', '/');
        }
        
        $alerts = '';
        // Get form data
        if (isset($_POST['Reg'])) {
            $r = m('User:reg', $_POST['Reg']);
            if ($r['success']) {
                f('core:auth:login', $r['data']['id'], ['email' => $r['data']['email'], 'login' => $r['data']['login']]);
                f('core:response:redirect', '/');
            } elseif (isset($r['errors'])) {
                foreach ($_POST['Reg'] as &$val) {
                    $val = f('helpers:string:html_encode', $val);
                }
                // Create alert
                $alerts .= f('core:view:print', 'elements/_alert', [
                    'type' => 'danger',
                    'text' => '<b>Validation errors!</b>'
                    . ' Please check next errors:' .
                    f('helpers:validation:compile_errors', $r['errors'], TRUE)
                ], TRUE);
            } else {
                return f('core:view:render', 'error/index', ['code' => 500, 'msg' => 'Server error!']);
            }
        }
        // Render
        f('core:view:render', 'default/registration', ['alerts' => $alerts]);
    }
];


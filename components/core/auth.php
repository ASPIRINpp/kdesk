<?php defined('APP_PATH') or die('Access denied!');

/**
 * Auth component
 *
 * @since 0.1
 * @author Bogomazov Bogdan (ASPIRIN++) <b.bogomazov@gamil.com>
 */
return [
    'core:auth:_ver' => '0.1',
    'core:auth:logged' => function() {
        if(!defined('AUTH_LOGGED')) {
            define('AUTH_LOGGED', (bool) f('core:session:get', 'id', FALSE));
        }
        return AUTH_LOGGED;
    },
    'core:auth:login' => function($id, $params = NULL) {
        f('core:session:set', 'id', $id);

        // Set auth key in db
        m('sys_users:set_authkey' , $id, f('core:session:id'));
        
        if(is_array($params)) {
            foreach($params as $key => $val) {
                f('core:session:set', $key, $val);
            }
        }

        return TRUE;
    },
    'core:auth:logout' => function() {
        m('sys_users:set_authkey' , f('core:session:get', 'id'), NULL);
        return f('core:session:close');
    },
    'core:auth:update_moneys' => function() {
        if(f('core:auth:logged')) {
            $d = m('sys_users:get_money', f('core:session:get', 'id'));
            foreach ($d as $k => $v) {
                f('core:session:set', $k, $v);
            }
        }
    }
];
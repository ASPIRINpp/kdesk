<?php defined('DOC_ROOT') or die('Access denied!');

/**
 * This is you awersome app!
 */
$app = [];

/**
 * Init you app
 * @global array $app Link to you app
 * @param string $app_dir Applicaton directory
 * @param string $components_dir Components directory
 */
function init($app_dir, $components_dir) {
    global $app;

    if (!is_dir($components_dir) AND is_dir(DOC_ROOT . $components_dir)) {
        $components_dir = DOC_ROOT . $components_dir;
    }

    if (!is_dir($app_dir) AND is_dir(DOC_ROOT . $app_dir)) {
        $app_dir = DOC_ROOT . $app_dir;
    }

    // Define path consts (APP_PATH used for check direct script access)
    define('APP_PATH', realpath($app_dir) . DIRECTORY_SEPARATOR);
    define('COM_PATH', realpath($components_dir) . DIRECTORY_SEPARATOR);

    /**
     * Build app structure
     */
    $app = [
        'components' => [],
        'controller' => [],
        'config' => include APP_PATH . 'config' . DIRECTORY_SEPARATOR . 'app.php',
    ];
}


/**
 * Load controller
 * @global array $app
 * @param string $name Controller name
 */
function lc ($name) {
    global $app;
    $app['components'] = array_merge($app['components'], include COM_PATH . str_replace(':', DIRECTORY_SEPARATOR, $name) . '.php');
}

/**
 * Get any function from any component
 * @global array $app
 * @param type $f
 * @return array
 */
function gf($f) {
    global $app;
    if (!isset($app['components'][$f])) {
        $arr = explode(':', $f);
        if (count($arr) > 1) {
            lc("{$arr[0]}:{$arr[1]}");
        }
    }
    return $app['components'][$f];
}

/**
 * Call any function from any component
 * @param string $f Group:Component:Function name
 * @param mixed $_ [optional]  Variable list of arguments to callable function
 * @example f('helpers:test:say_hi', 'Bill');
 */
function f($f) {
    $args = [];
    if (func_num_args() > 1) {
        $args = func_get_args();
        unset($args[0]);
    }
    return call_user_func_array(gf($f), $args);
}


<?php defined('APP_PATH') or die('Access denied!');

return [
    'action:index' => function() {
        f('core:profiling:start', 'views');
        f('core:cookie:set', 'test', 'Hello!');
        f('core:view:compile', 'elements/_howitworks');
        f('core:view:render', 'default/index', ['projects' => m('dk_projects:get_last')]);
        f('core:profiling:end', 'views');
        echo f('core:profiling:js_log');
    },
    'action:registration' => function() {
        f('core:session:open');
        //f('core:session:set', 'name', 'test');
        f('core:view:render', 'default/registration', ['t' => f('core:session:get', 'name')]);
    }
];
        
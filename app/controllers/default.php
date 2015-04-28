<?php defined('APP_PATH') or die('Access denied!');

return [
    'action:index' => function() {
        f('core:view:compile', 'elements/_howitworks');
        f('core:view:render', 'default/index', ['projects' => m('dk_projects:get_last')]);
    },
    'action:test' => function() {
        echo 'Action test!';
    }
];
        
<?php defined('APP_PATH') or die('Access denied!');

return [
    'action:index' => function() {
        f('core:auth:update_moneys');
        $range = [f('helpers:arr:get', 'day', $_GET, date('d.m.Y')) . ' 00:00', f('helpers:arr:get', 'day', $_GET, date('d.m.Y')) . ' 23:59'];
        f('core:view:render', 'finance/index', ['rows' => m('fn_logs:get_logs', f('core:session:get', 'id'), strtotime($range[0]), strtotime($range[1]))]);
    }
];
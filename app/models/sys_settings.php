<?php
/**
 * type: 'string', 'byte', 'int', 'percent', 'bool'
 */
return [
    'sys_settings:set' => function($key, $value, $type) {
        $sql = 'REPLACE sys_settings SET `key` = :key, value = :value, type = :type;';
        return f('db:mysql:q_update', $sql, [':key' => $key, ':value' => $value, ':type' => $type]);
    },
    'sys_settings:get' => function($key, $default = NULL) {
        $sql = 'SELECT value FROM sys_settings WHERE `key` = :key;';
        $v = f('db:mysql:q_scalar', $sql, [':key' => $key], 'value');
        return is_null($v) ? $default : $v;
    },
    'sys_settings:inc' => function($key, $amount = 1) {
        $sql = 'UPDATE sys_settings SET value = value + :value WHERE `key` = :key && type IN :type;';
        return f('db:mysql:q_update', $sql, [':key' => $key, ':value' => (int) $amount, ':type' => ['int', 'percent']]);
    },
    'sys_settings:dec' => function($key, $amount = 1) {
        $sql = 'UPDATE sys_settings SET value = value - :value WHERE `key` = :key && type IN :type;';
        return f('db:mysql:q_update', $sql, [':key' => $key, ':value' => (int) $amount, ':type' => ['int', 'percent']]);
    },
];
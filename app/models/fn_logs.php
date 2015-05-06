<?php defined('APP_PATH') or die('Access denied!');
/**
 * type: 0 - debit, 1 - credit, 2 - inreseve, 3 - outreserve
 */
return [
    'fn_logs:add' => function($id_sys_users, $type, $sum, $comment) {
        $sql = 'INSERT INTO fn_logs'
            . ' (id_sys_users, type, sum, comment, time) VALUES'
            . ' (:id_sys_users, :type, :sum, :comment, :time);';
        return f('db:mysql:q_insert', $sql, [
            ':id_sys_users' => $id_sys_users, 
            ':type' => $type, 
            ':sum' => $sum, 
            ':comment' => $comment, 
            ':time' => time()
        ]);
    },
    'fn_logs:add_rows' => function($rows) {
        if(count($rows) == 1) {
            $r = array_keys($rows);
            return [$r[0] => m('fn_logs:add', $rows[$r[0]]['id_sys_users'], $rows[$r[0]]['type'], $rows[$r[0]]['sum'], $rows[$r[0]]['comment'])];
        }
        $values = '';
        $p = [':time' => time()];
        foreach ($rows as $key => $row) {
            foreach ($row as $col => $val) {
                $p[":$col_$key"] = $val;
            }
            $values .= " ,(:id_sys_users_$key, :type_$key, :sum_$key, :comment_$key, :time)";
        }
        $sql = 'INSERT INTO fn_logs'
            . ' (id_sys_users, type, sum, comment, time) VALUES ' . substr($values, 2) . ';';
        return f('db:mysql:q_insert', $sql, $p);
    },
    'fn_logs:get_logs' => function($id_sys_users, $time_start, $time_end) {
        $sql = 'SELECT * FROM fn_logs WHERE id_sys_users = :id_sys_users && time BETWEEN :time_start AND :time_end;';
        return f('db:mysql:q_all', $sql, [
            ':id_sys_users' => (int) $id_sys_users, 
            ':time_start' => (int) $time_start, 
            ':time_end' => (int) $time_end,
        ]);
    }
];
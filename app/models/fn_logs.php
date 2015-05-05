<?php
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
];
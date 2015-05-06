<?php defined('APP_PATH') or die('Access denied!');

return [
    'dk_projects_comments:get_last' => function($id, $limit = 5, $offset = 0) {
        $sql = 'SELECT dpc.*, su.login AS author_login, su.name AS author_name'
            .' FROM dk_projects_comments AS dpc'
            .' LEFT JOIN sys_users AS su ON (su.id = dpc.id_sys_users)'
            .' WHERE dpc.id_dk_projects = :id'
            .' ORDER BY dpc.time DESC LIMIT '.(int) $offset.', '.(int) $limit;
        return f('db:mysql:q_all', $sql, [':id' => $id]);
    },
    'dk_projects_comments:comment' => function($id, $comment, $id_author) {
        $sql = 'INSERT INTO dk_projects_comments'
            .' (id_dk_projects, id_sys_users, comment, time) VALUES'
            .' (:id_dk_projects, :id_sys_users, :comment, :time)';
        return f('db:mysql:q_insert', $sql, [
            ':id_dk_projects' => $id,
            ':comment' => $comment,
            ':id_sys_users' => $id_author,
            ':time' => time()
        ]);
    }
];
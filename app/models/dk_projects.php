<?php defined('APP_PATH') or die('Access denied!');

return [
    'dk_projects:get_last' => function($count = 5) {
        $sql = 'SELECT * FROM dk_projects WHERE status = \'open\' ORDER BY id DESC LIMIT '.(int) $count;
        return f('db:mysql:q_all', $sql);
    },
    'dk_projects:get_inwork' => function($id_performer, $limit = 10, $offset =0) {
        $sql = 'SELECT * FROM dk_projects'
            . ' WHERE status = \'inwork\' && id_sys_users_performer = :id_sys_users_performer'
            . ' ORDER BY time_created DESC LIMIT :offset, :limit;';
        return f('db:mysql:q_all', $sql, [':id_sys_users_performer' => $id_performer, ":limit" => (int) $limit, ':offset' => (int) $offset]);
    },
    'dk_projects:search' => function($q, $limit = 10, $offset =0) {
        $sql = 'SELECT * FROM dk_projects'
                . ' WHERE status = \'open\' && (title LIKE :q || description_short LIKE :q)'
                . ' ORDER BY time_created DESC LIMIT :offset, :limit;';
        return f('db:mysql:q_all', $sql, [':q' => "%$q%", ":limit" => (int) $limit, ':offset' => (int) $offset]);
    },
    'dk_projects:get_by_id' => function($id) {
        $sql = 'SELECT dp.*, sua.login AS author_login, sua.name AS author_name'
            .' FROM dk_projects AS dp'
            .' LEFT JOIN sys_users AS sua ON (dp.id_sys_users_author = sua.id)'
            .' WHERE dp.id = :id;';
        return f('db:mysql:q_current', $sql, [':id' => $id]);
    },
    'dk_projects:inc_views' => function($id) {
        $sql = 'UPDATE dk_projects SET views = views + 1 WHERE id = :id;';
        return f('db:mysql:q_update', $sql, [':id' => $id]);
    },
    'dk_projects:update_status' => function($id, $status, $id_performer = FALSE) {
        $sql = 'UPDATE dk_projects SET'
            .($id_performer === FALSE ? '' : ' id_sys_users_performer = :performer,')
            .' status = :status WHERE id = :id;';
        return f('db:mysql:q_update', $sql, [':id' => $id, ':status' => $status, ':performer' => $id_performer]);
    },
    'dk_projects:add' => function($id_author, $title, $description, $cost, $tax) {
        $sql = 'INSERT INTO dk_projects'
                . ' (id_sys_users_author, title, description_short, description, status, cost, tax, time_created) VALUES'
                . ' (:id_sys_users_author, :title, :description_short, :description, :status, :cost, :tax, :time_created)';
        $description = f('helpers:string:markup', $description);
        return f('db:mysql:q_insert', $sql, [
            ':id_sys_users_author' => $id_author, 
            ':title' => $title,
            ':description_short' => (strlen($description) > 255) ? f('helpers:string:limit_chars', $description, 253): $description,
            ':description' => $description,
            ':status' => 'open',
            ':cost' => $cost,
            ':tax' => $tax,
            ':time_created' => time()
        ]);
    }
];
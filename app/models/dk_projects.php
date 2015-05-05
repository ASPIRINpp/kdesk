<?php

return [
    'dk_projects:get_last' => function($count = 5) {
        $sql = 'SELECT * FROM dk_projects WHERE status = \'open\' ORDER BY id DESC LIMIT '.(int) $count;
        return f('db:mysql:q_all', $sql);
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
    'dk_projects:add' => function($id_author, $title, $description, $cost) {
        $sql = 'INSERT INTO dk_projects'
                . ' (id_sys_users_author, title, description_short, description, status, cost, time_created) VALUES'
                . ' (:id_sys_users_author, :title, :description_short, :description, :status, :cost, :time_created)';
        return f('db:mysql:q_insert', $sql, [
            ':id_sys_users_author' => $id_author, 
            ':title' => $title,
            ':description_short' => (strlen($description) > 255) ? substr($description, 0, 252).'...' : $description,
            ':description' => $description,
            ':status' => 'open',
            ':cost' => $cost,
            ':time_created' => time()
        ]);
    }
];
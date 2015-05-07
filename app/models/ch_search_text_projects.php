<?php defined('APP_PATH') or die('Access denied!');
// Vertical sharding for ch_search_text_projects table
define('CH_PROJECTS_TEXT_LINK', 'srv_search');
/**
 * Model for ch_search_text_projects table
 */
return [
    'ch_search_text_projects:search' => function($q, $limit = 10, $offset = 0) {
        $sql = 'SELECT'
                . ' id_dk_project AS id, title, description_short, status, cost, time_created'
                . '  FROM ch_search_text_projects'
                . ' WHERE status = \'open\' && (title LIKE :q || description LIKE :q)'
                . ' ORDER BY time_created DESC LIMIT :offset, :limit;';
        return f('db:mysql:q_all', $sql, [':q' => "%$q%", ":limit" => (int) $limit, ':offset' => (int) $offset], CH_PROJECTS_TEXT_LINK);
    },
    'ch_search_text_projects:add' => function($params) {
        $sql = 'INSERT INTO ch_search_text_projects'
                . ' (id_dk_project, title, description_short, description, status, cost, time_created) VALUES'
                . ' (:id_dk_projects, :title, :description_short, :description, :status, :cost, :time_created)';
        return f('db:mysql:q_insert', $sql, $params, CH_PROJECTS_TEXT_LINK);
    },
    'ch_search_text_projects:update_status' => function($params) {
        $sql = 'UPDATE ch_search_text_projects SET'
            .($params[':performer'] === FALSE ? '' : ' id_sys_users_performer = :performer,')
            .' status = :status WHERE id_dk_project = :id;';
        return f('db:mysql:q_update', $sql, $params, CH_PROJECTS_TEXT_LINK);
    },
    'ch_search_text_projects:get_inwork' => function($id_performer, $limit = 10, $offset =0) {
        $sql = 'SELECT'
                . ' id_dk_project AS id, title, description_short, status, cost, time_created'
                . ' FROM ch_search_text_projects'
            . ' WHERE status = \'inwork\' && id_sys_users_performer = :id_sys_users_performer'
            . ' ORDER BY time_created DESC LIMIT :offset, :limit;';
        return f('db:mysql:q_all', $sql, [':id_sys_users_performer' => $id_performer, ":limit" => (int) $limit, ':offset' => (int) $offset], CH_PROJECTS_TEXT_LINK);
    },
];
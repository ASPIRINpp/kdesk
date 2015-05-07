<?php defined('APP_PATH') or die('Access denied!');
// Horizontal sharding for dk_projects table
// Config db groups names for servers with dk_projects tables
define('DK_PROJECTS_LINK1', 'srv_projects_1');
define('DK_PROJECTS_LINK2', 'srv_projects_2');
/**
 * Model for dk_projects tables
 */
return [
    /**
     * Simple select link for two servers
     * @params int $id Project id
     */
    'dk_projects:select_link' => function($id) {
        return $id % 2 == 0 ? DK_PROJECTS_LINK1 : DK_PROJECTS_LINK2;
    },
    'dk_projects:get_id' => function() {
        $id = m('sys_settings:get', 'sh_last_project_id', FALSE);
        if($id === FALSE) {
            trigger_error('Check setting row "sh_last_project_id" in sys_settings table!');
        }
        return ++$id;
    },
    'dk_projects:set_last_id' => function($id) {
        return m('sys_settings:set', 'sh_last_project_id', $id, 'int');
    },
    'dk_projects:get_last' => function($count = 5) {
        return m('ch_last_projects:get_last', $count);
    },
    'dk_projects:get_inwork' => function($id_performer, $limit = 10, $offset = 0) {
        return m('ch_search_text_projects:get_inwork', $id_performer, $limit, $offset);
    },
    'dk_projects:search' => function($q, $limit = 10, $offset = 0) {
        return m('ch_search_text_projects:search', $q, $limit, $offset);
    },
    'dk_projects:get_by_id' => function($id) {
        $sql = 'SELECT * FROM dk_projects WHERE id = :id;';
        $row = f('db:mysql:q_current', $sql, [':id' => $id], m('dk_projects:select_link', $id));
        if(!empty($row)) {
            $row = array_merge($row, m('sys_users:get_for_project', $row['id_sys_users_author']));
        }
        return $row;
    },
    'dk_projects:inc_views' => function($id) {
        $sql = 'UPDATE dk_projects SET views = views + 1 WHERE id = :id;';
        return f('db:mysql:q_update', $sql, [':id' => $id], m('dk_projects:select_link', $id));
    },
    'dk_projects:update_status' => function($id, $status, $id_performer = FALSE) {
        $sql = 'UPDATE dk_projects SET'
            .($id_performer === FALSE ? '' : ' id_sys_users_performer = :performer,')
            .' status = :status WHERE id = :id;';
        $params = [':id' => $id, ':status' => $status, ':performer' => $id_performer];
        // Update in ch_last_projects
        m('ch_last_projects:update_status',$params);
        // Update in ch_search_text_projects
        m('ch_search_text_projects:update_status',$params);
        return f('db:mysql:q_update', $sql, $params, m('dk_projects:select_link', $id));
    },
    'dk_projects:add' => function($id_author, $title, $description, $cost, $tax) {
        $id = m('dk_projects:get_id');
        $sql = 'INSERT INTO dk_projects'
                . ' (id, id_sys_users_author, title, description_short, description, status, cost, tax, time_created) VALUES'
                . ' (:id_dk_projects, :id_sys_users_author, :title, :description_short, :description, :status, :cost, :tax, :time_created)';
        $params = [
            ':id_dk_projects' => $id,
            ':id_sys_users_author' => $id_author, 
            ':title' => $title,
            ':description_short' => f('helpers:string:markup', (strlen($description) > 255) ? f('helpers:string:limit_chars', $description, 253): $description),
            ':description' => f('helpers:string:markup', $description),
            ':status' => 'open',
            ':cost' => $cost,
            ':tax' => $tax,
            ':time_created' => time()
        ];
        list($id_db, $ar) = f('db:mysql:q_insert', $sql, $params, m('dk_projects:select_link', $id));
        if($ar > 0) {
            // Update last project id
            m('dk_projects:set_last_id', $id);
            // Add to ch_last_projects
            m('ch_last_projects:add', $params);
            // Add to ch_search_text_projects
            m('ch_search_text_projects:add', $params);
        }
        return [$id_db, $ar];
    }
];
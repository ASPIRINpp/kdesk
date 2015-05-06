<?php defined('APP_PATH') or die('Access denied!');

return [
    /**
     * 
     */
    'Project:do' => function($action, $project) {
        $alerts = '';
        $user_id = f('core:session:get', 'id');
        switch($action) {
            case 'take':
                if($project['status'] === 'open' 
                && $r = m('dk_projects:update_status', $project['id'], 'inwork', $user_id) != FALSE) {
                   $project['status'] = 'inwork';
                   $project['id_sys_users_performer'] = $user_id;
                   // Decrement count open projects
                   m('sys_settings:dec', 'count_open_projects');
                }
                break;
            case 'done':
                if($project['status'] === 'inwork' 
                && $project['id_sys_users_performer'] === $user_id 
                && $r = m('dk_projects:update_status', $project['id'], 'closed', FALSE) != FALSE) {
                    $project['status'] = 'closed';
                    if($project['cost'] > 0) {
                        // Remove reserve
                        m('sys_users:dec_reserve_money', $project['id_sys_users_author'], $project['cost']+$project['tax']);
                        // Pay for job
                        m('sys_users:inc_money', $user_id, $project['cost']);
                        // Pay tax
                        m('sys_settings:inc', 'project_money', $project['tax']);
                        // Logs pay
                        m('fn_logs:add_rows', [
                            ['id_sys_users' => $project['id_sys_users_author'], 'type' => 1, 'sum' => $project['cost'], 'comment' => "Pay for project #{$project['id']} from reserve"],
                            ['id_sys_users' => $project['id_sys_users_author'], 'type' => 1, 'sum' => $project['tax'], 'comment' => "Tax for project #{$project['id']} from reserve"],
                            ['id_sys_users' => $user_id, 'type' => 0, 'sum' => $project['cost'], 'comment' => "Pay for project #{$project['id']} from reserve"],
                        ]);
                    }
                }
                break;
            case 'cancel':
                if($project['status'] === 'inwork' 
                && $project['id_sys_users_performer'] === $user_id
                && $r = m('dk_projects:update_status', $project['id'], 'open', NULL) != FALSE) {
                    $project['status'] = 'open';
                    $project['id_sys_users_performer'] = NULL;
                    // Increment count open projects
                    m('sys_settings:inc', 'count_open_projects');
                }
                break;
        }
        if (!isset($r) || !$r) {
            $alerts .= f('core:view:print', 'elements/_alert', ['type' => 'danger', 'text' => '<b>Sorry!</b>This project already takes...'], TRUE);
        }
        
        // Update money
        f('core:auth:update_moneys');
        
        return [$project, $alerts];
    },
    /**
     * 
     */
    'Project:create' => function($data) {
        // Validation
        $r = f('helpers:validation:check', $data, [
            ['title', 'not_empty'],
            ['description', 'not_empty'],
            ['cost', 'digit'],
            ['cost', 'min', [0]],
            // Check tags
            ['tags', 'callback', [function($tags) {
                // @todo rewrite?
                $tags = trim(str_replace([',', ' '], '', $tags));
                if(f('helpers:validation:alpha_dash', $tags) 
                && f('helpers:validation:alpha_numeric', $tags)) {
                    return TRUE;
                }
                return FALSE;
            }, 'tags_err']],
            // Check money
            ['cost', 'callback', [function($amount) {
                f('core:auth:update_moneys');
                if($amount == 0) {
                    return TRUE;
                }
                $money = m('sys_users:get_money', f('core:session:get', 'id'), 'money');
                $tax = m('sys_settings:get', 'tax', 0);
                if($tax) {
                    $amount += f('helpers:currency:precent', $amount, $tax);
                }
                return ($money - $amount)>=0;
            }, 'no_money_no_honey']]
        ]);
        
        // Check validation status
        if($r['success']) {
            // Prepare additions data
            $id_user = f('core:session:get', 'id');
            $cost = f('helpers:currency:normalize', $data['cost']);
            $tax = ($cost > 0) ? f('helpers:currency:precent', $cost, m('sys_settings:get', 'tax', 0)) : 0;
            // Crate project
            list($id) = m('dk_projects:add', $id_user, $data['title'], $data['description'], $cost, $tax);
            // Check id
            if ($id) {
                // Make tags
                if(!empty($data['tags'])) {
                    m('dk_tags:bind_tags', $id, explode(', ', $data['tags']));
                }
                // Make money & Reserve money
                if($cost > 0) {
                    m('sys_users:reserve_money', $id_user, $cost+$tax);
                    f('core:auth:update_moneys');
                    m('fn_logs:add_rows', [
                        ['id_sys_users' => $id_user, 'type' => 2, 'sum' => $cost, 'comment' => "Reserve for project #$id"],
                        ['id_sys_users' => $id_user, 'type' => 2, 'sum' => $tax, 'comment' => "Reserve tax for project #$id"],
                    ]);
                }
                // Increment count open projects
                m('sys_settings:inc', 'count_open_projects');
                return ['success'=>TRUE, 'id' => $id];
            }
            // Create errors
            return ['success'=>FALSE];
        } else {
            // Validation errors
            return $r;
        }
    }
];
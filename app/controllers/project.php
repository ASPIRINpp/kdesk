<?php defined('APP_PATH') or die('Access denied!');

return [
    'action:index' => function($params) {
        // Get from db
        $project = m('dk_projects:get_by_id', $params['id']);
        
        // Empty?
        if (empty($project)) {
            die('404');
        }

        // Get comment post data
        if (isset($_POST['Comment']) && f('core:auth:logged')) {
            m('dk_projects_comments:comment',$params['id'], $_POST['Comment']['text'], f('core:session:get', 'id'));
        }
        
        // Select form view
        $form = FALSE;
        if (f('core:auth:logged')) {
            if ($project['id_sys_users_author'] === f('core:session:get', 'id')) {
                $form = 'manage';
            } elseif ($project['status'] === 'open') {
                $form = 'open';
            } elseif ($project['status'] === 'inwork' && $project['id_sys_users_performer'] === f('core:session:get', 'id')) {
                $form = 'inwork';
            }
        }

        // Load tags
        $tags = m('dk_tags:get_by_project_id', $params['id']);
        // Load comments
        $comments = m('dk_projects_comments:get_last', $params['id']);

        $alerts = '';

        // Get project post data
        if (isset($_POST['Project']) && f('core:auth:logged')) {
            switch(f('helpers:arr:get', 'do', $_POST['Project'])) {
                case 'take':
                    if($project['status'] === 'open') {
                        $r = m('dk_projects:update_status', $params['id'], 'inwork', f('core:session:get', 'id'));
                    }
                    break;
                case 'done':
                    if($project['status'] === 'inwork' && $project['id_sys_users_performer'] === f('core:session:get', 'id')) {
                        $r = m('dk_projects:update_status', $params['id'], 'closed', FALSE);
                    }
                break;
                case 'cancel':
                    if($project['status'] === 'inwork' && $project['id_sys_users_performer'] === f('core:session:get', 'id')) {
                        $r = m('dk_projects:update_status', $params['id'], 'open', NULL);
                    }
                    break;
            }
            if (!isset($r) || !$r) {
                $alerts .= f('core:view:print', 'elements/_alert', ['type' => 'danger', 'text' => '<b>Sorry!</b>This project already takes...'], TRUE);
            }
        }
        
        if ($project['status'] === 'closed') {
            $alerts .= f('core:view:print', 'elements/_alert', ['type' => 'danger', 'text' => '<b>Sorry!</b>This project already closed...'], TRUE);
        }elseif ($project['status'] === 'inwork' && $project['id_sys_users_performer'] === f('core:session:get', 'id')) {
            $alerts .= f('core:view:print', 'elements/_alert', ['type' => 'warning', 'text' => '<b>Sorry!</b>This project already in work...'], TRUE);
        }

        // Render
        f('core:view:render', 'project/index', [
            'project' => $project,
            'tags' => $tags,
            'form' => $form,
            'alerts' => $alerts,
            'comments' => $comments
        ]);
        
        // Finish him
        finish();

        // Increment views
        if ($form != 'manage') {
            m('dk_projects:inc_views', $params['id']);
        }
    },
    'action:manage' => function($params) {
        // Get from db
        $project = m('dk_projects:get_by_id', $params['id']);
        
         // Empty?
        if (empty($project)) {
            die('404');
        }
        
        // This is not author
        if($project['id_sys_users_author'] !== f('core:session:get', 'id')) {
            return f('core:response:redirect', '/project/'.$params['id']);
        }
        
         // Load tags
        $tags = m('dk_tags:get_by_project_id', $params['id']);
        // Load comments
        $comments = m('dk_projects_comments:get_last', $params['id']);
        
         // Render
        f('core:view:render', 'project/index', [
            'project' => $project,
            'tags' => $tags,
            'alerts' => '',
            'comments' => $comments]);
    },
    'action:create' => function() {
        if(!f('core:auth:logged')) {
            return f('core:response:redirect', '/');
        }
        
        if(isset($_POST['Project'])) {
            $r = f('helpers:validation:check', $_POST['Project'], [
                ['title', 'not_empty'],
                ['description', 'not_empty'],
                ['cost', 'digit'],
                ['cost', 'min', [0]],
                ['tags', 'callback', [function($tags) {
                    // @todo rewrite?
                    $tags = trim(str_replace(', ', '', $tags));
                    if(f('helpers:validation:alpha_dash', $tags) && f('helpers:validation:alpha_numeric', $tags)) {
                        return TRUE;
                    }
                    return FALSE;
                }, 'tags_err']]
            ]);

            if($r['success']) {
                list($id, $ar) = m('dk_projects:add', f('core:session:get', 'id'), $_POST['Project']['title'], $_POST['Project']['description'], f('helpers:currency:normalize', $_POST['Project']['cost']));
                if ($id) {
                    m('dk_tags:bind_tags', $id, explode(', ', $_POST['Project']['tags']));
                    return f('core:response:redirect', "/project/$id");
                }
                return f('core:response:redirect', '/error/500');
            } else {
                var_dump($r);
            } 
        }
        
        f('core:view:render', 'project/form');
    }
];
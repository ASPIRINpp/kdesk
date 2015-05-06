<?php defined('APP_PATH') or die('Access denied!');

return [
    'action:index' => function($params) {
        // Get from db
        $project = m('dk_projects:get_by_id', $params['id']);

        // Empty?
        if (empty($project)) {
            die('404');
        }

        $project_id = $params['id'];
        $loogged = f('core:auth:logged');
        if ($looged) {
            $user_id = f('core:session:get', 'id');
        }
        
        // Get comment post data
        if (isset($_POST['Comment']) && !empty($_POST['Comment']['text']) && $looged) {
            m('dk_projects_comments:comment',$project_id, f('helpers:string:markup', $_POST['Comment']['text']), $user_id);
        }

        // Load tags
        $tags = m('dk_tags:get_by_project_id', $project_id);
        // Load comments
        $comments = m('dk_projects_comments:get_last', $project_id);

        $alerts = '';

        // Get project post data
        if (isset($_POST['Project']) && $loogged) {
             list($project, $alerts) = m('Project:do', f('helpers:arr:get', 'do', $_POST['Project']), $project);
        }
        
        // Select form view
        $form = FALSE;
        if ($loogged) {
            if ($project['id_sys_users_author'] === $user_id) {
                $form = 'manage';
            } elseif ($project['status'] === 'open') {
                $form = 'open';
            } elseif ($project['status'] === 'inwork' && $project['id_sys_users_performer'] === $user_id) {
                $form = 'inwork';
            }
        }
        
        if ($project['status'] === 'closed') {
            $alerts .= f('core:view:print', 'elements/_alert', ['type' => 'danger', 'text' => '<b>Sorry!</b>This project already closed...'], TRUE);
        }elseif ($project['status'] === 'inwork' && $project['id_sys_users_performer'] !== $user_id) {
            $alerts .= f('core:view:print', 'elements/_alert', ['type' => 'warning', 'text' => '<b>Sorry!</b>This project already in work...'], TRUE);
        }elseif ($project['status'] === 'inwork' && $project['id_sys_users_performer'] === $user_id) {
            $alerts .= f('core:view:print', 'elements/_alert', ['type' => 'success', 'text' => '<b>Greate!</b>You are work on this project...'], TRUE);
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
            m('dk_projects:inc_views', $project_id);
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
        $alerts = '';
        if(isset($_POST['Project'])) {
            $r = m('Project:create', $data);
            if($r['success']) {
                // All ok
                return f('core:response:redirect', "/project/{$r['id']}");
            } elseif(isset($r['errors'])) {
                // Validation not pass
                // Encode value for render in form
                foreach ($_POST['Project'] as &$val) {
                    $val = f('helpers:string:html_encode', $val);
                }
                // Create alert
                $alerts .= f('core:view:print', 'elements/_alert', [
                    'type' => 'danger',
                    'text' => '<b>Validation errors!</b>'
                    . ' Please check next errors:'. 
                    f('helpers:validation:compile_errors', $r['errors'], TRUE)
                ], TRUE);
            } else {
                // Something went wrong
                f('core:response:redirect', '/error/500');
            }
        }
        
        f('core:view:render', 'project/form', ['alerts' => $alerts]);
    },
    'action:search' => function() {
        $rows = !empty($_GET['q']) ? m('dk_projects:search', $_GET['q']) : [];
        f('core:view:render', 'project/search',[
            'count_open' => m('sys_settings:get', 'count_open_projects', 0),
            'rows' => $rows
        ]);
    },
    'action:inwork' => function() {
        f('core:view:render', 'project/inwork',[
            'count_open' => m('sys_settings:get', 'count_open_projects', 0),
            'rows' => m('dk_projects:get_inwork', f('core:session:get', 'id'))
        ]);
        
    }
];
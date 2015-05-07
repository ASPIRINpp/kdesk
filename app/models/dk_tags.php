<?php defined('APP_PATH') or die('Access denied!');

return [
    'dk_tags:get_by_project_id' => function($id) {
        $sql = 'SELECT dt.tag'
            . ' FROM dk_projects_has_dk_tags AS dphdt'
            . ' LEFT JOIN dk_tags AS dt ON (dt.id = dphdt.id_dk_tags)'
            . ' WHERE dphdt.id_dk_projects = :id;';
        return f('db:mysql:q_column', $sql, [':id' => $id], 'tag');
    },
    'dk_tags:add' => function($tag) {
        $sql = 'INSERT INTO dk_tags (tag) VALUES (:tag);';
        list($id) = f('db:mysql:q_insert', $sql, [':tag' => $tag]);
        return $id;
    },
    'dk_tags:get_tags_id' => function($tags) {
        $sql = 'SELECT id, LOWER(tag) AS tag FROM dk_tags WHERE tag IN :tags;';
        return f('db:mysql:q_all', $sql, [':tags' => $tags]);
    },
    'dk_tags:bind_tags' => function($id_project, $tags) {
        if (empty($tags)) {
            return;
        }
        // Trim all values
        $tags = array_map('trim', $tags);
        
        // Fill ids array & values string
        $ids = f('helpers:arr:pluck_key', m('dk_tags:get_tags_id', $tags), 'tag');
        
        $values = '';
        foreach ($tags as $k => $tag) {
            $tag = mb_strtolower($tag, 'utf-8');
            $ids[":id_dk_tags_$k"] = (int) (!isset($ids[$tag]) ? m('dk_tags:add', $tag) : $ids[$tag]['id']);
            unset($ids[$tag]);
            $values .= " ,(:id_dk_projects, :id_dk_tags_$k)";
        }
        $values = substr($values, 2);
        
        // Add id project ;)
        $ids[':id_dk_projects'] = $id_project;
        
        // Insert
        $sql = "INSERT INTO dk_projects_has_dk_tags (id_dk_projects, id_dk_tags) VALUES $values;";
        return f('db:mysql:q_insert', $sql, $ids);
    }
];

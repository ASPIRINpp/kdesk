<?php

return [
    'dk_projects:get_last' => function($count = 5) {
        $count = (int) $count;
        $sql = 'SELECT * FROM dk_projects ORDER BY id DESC LIMIT '.$count;
        return f('db:mysql:q_all', $sql);
    }
];
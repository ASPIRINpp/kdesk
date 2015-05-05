<?php defined('APP_PATH') or die('Access denied!');

return [
    'action:500' => function() {
        echo '500 error';
    },
    'action:404' => function() {
        echo '404 error';
    },
];


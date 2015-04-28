<h1><?=__('Last projects')?></h1>
<?php
if (is_array($projects)) {
    foreach($projects as $project) {
        f('core:view:print', 'elements/_project_thumb', $project);
    }
}
?>
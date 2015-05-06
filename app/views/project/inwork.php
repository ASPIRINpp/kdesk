<div class="page-header">
    <h1>Projects in work</h1>
</div>

<?php 
    if(!empty($rows)){
        foreach ($rows as $row) {
            echo f('core:view:print', 'elements/_project_thumb', $row, TRUE);
        }
    }
?>


<div class="page-header">
    <?php if (f('core:auth:logged')): ?>
        <a href="/project/create" type="button" class="btn btn-primary btn-lg pull-right">Create new project</a>
    <?php endif; ?>
    <h1><?= __('Last projects') ?></h1>
</div>


<?php
if (is_array($projects)) {
    foreach ($projects as $project) {
        f('core:view:print', 'elements/_project_thumb', $project);
    }
}
?>
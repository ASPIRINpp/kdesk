<div class="page-header">
    <?php if (f('core:auth:logged')): ?>
        <a href="/project/create" type="button" class="btn btn-primary btn-lg pull-right">Create new project</a>
    <?php endif; ?>
    <h1><?= __('Last projects') ?></h1>
</div>
<?php
if (is_array($projects) && !empty($projects)) :
    foreach ($projects as $project) {
        f('core:view:print', 'elements/_project_thumb', $project);
    }
else:
    ?>
    <div class="jumbotron jumbotron-center">
        <span class="glyphicon glyphicon-briefcase glyphicon-big" aria-hidden="true"></span>
        <h1>Нет открытых проектов!</h1>
        <p>Пора это исправить!</p>
        <?php if (f('core:auth:logged')): ?>
            <p><a class="btn btn-success btn-lg" href="/project/create" role="button">Создать проект</a></p>
        <?php endif; ?>
    </div>
<?php endif; ?>
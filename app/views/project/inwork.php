<?php
if (!empty($rows)) {
    echo '<div class="page-header"><h1>Projects in work</h1></div>';
    foreach ($rows as $row) {
        echo f('core:view:print', 'elements/_project_thumb', $row, TRUE);
    }
} else {
    ?>
    <div class="jumbotron jumbotron-center">
        <span class="glyphicon glyphicon-briefcase glyphicon-big" aria-hidden="true"></span>
        <h1>Нет проектов в работе!</h1>
        <p>Пора это исправить!</p>
        <p><a class="btn btn-success btn-lg" href="/" role="button">Отправится за проектами</a></p>
    </div>
<?php } ?>


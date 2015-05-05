<div class="page-header">
    <h1><?= $project['title'] ?> <small>от <a href="/profile/<?= $project['author_login'] ?>"><?= $project['author_name'] ?></a></small></h1>
    <?php
    if (!empty($tags)) {
        foreach ($tags as $tag) {
            echo "<span class=\"label label-primary\">$tag</span> ";
        }
    }
    ?>
</div>
<?= $alerts; ?>
<p><?= $project['description'] ?></p>

<div class="row">
    <?php
    $cost = !$project['cost'] ? FALSE : f('helpers:currency:format', $project['cost'], 0, ',', ' ');
    ?>
    <div class="col-md-2">Date: <?= date(__('d.m.Y H:i'), $project['time_created']) ?></div>
    <div class="col-md-2">Cost: <strong><?= $cost ?></strong> р.</div>
    <div class="col-md-2">Views: <?= $project['views'] ?></div>
    <div class="col-md-6"><?= $form ? f('core:view:print', "project/_form_$form", ['project' => $project], TRUE) : ''; ?></div>
</div>

<h3>Comments</h3>

<?php
echo f('core:view:print', 'project/comment_form', [], TRUE);
if (!empty($comments)) {
    foreach ($comments as $comment) {
        echo f('core:view:print', 'project/comment', ['author' => $comment['author_name'], 'time' => date(__('d.m.Y H:i'), $comment['time']), 'text' => $comment['comment']], TRUE);
    }
}
?>
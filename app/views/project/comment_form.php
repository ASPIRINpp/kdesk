<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Comment'); ?></h3>
    </div>
    <div id="containerComment" class="panel-body">
        <form id="formComment" method="post">
            <textarea id="textComment" name="Comment[text]" class="form-control" rows="3" placeholder="<?= __('Enter you comment...'); ?>"></textarea>
            <button id="sendComment" type="submit" class="btn btn-primary"><?= __('Send'); ?></button>
        </form>
    </div>
</div>
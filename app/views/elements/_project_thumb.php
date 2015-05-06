<?php
$cost = !$cost ? FALSE : f('helpers:currency:dec_nformat', $cost, 0, ',', ' ');
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <a href="/project/<?=$id?>" class="panel-title"><?=$title;?></a>
        <?php if($cost): ?>
            <span class="hidden-xs pull-right"><?=$cost?> р.</span>
        <?php endif; ?>
    </div>
    <div class="panel-body">
        <?php if($cost): ?>
            <p class="visible-xs">Цена: <?=$cost?> р.</p>
        <?php endif; ?>
        <?=$description_short;?>
    </div>
</div>
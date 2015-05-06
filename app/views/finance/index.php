<?php
$types = [__('Debit'), __('Credit'), __('In reseve'), __('Outreserve')];
$colors = ['success', 'danger', 'warning', 'info'];
if (!empty($rows)):
    ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Comment</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <th scope="row"><?= $row['id']; ?></th>
                    <td class="text-<?= $colors[$row['type']]; ?>"><?= $types[$row['type']]; ?></td>
                    <td><?= f('helpers:currency:dec_nformat', $row['sum'], 2, ',', ' '); ?></td>
                    <td><?= $row['comment']; ?></td>
                    <td><?= date('H:i:s d.m.Y', $row['time']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="jumbotron jumbotron-center">
        <span class="glyphicon glyphicon-rub glyphicon-big" aria-hidden="true"></span>
        <h1>Нет денежных движений!</h1>
        <p>За этот день у вас пока нет денежных движений... Пора это исправить!</p>
        <p><a class="btn btn-success btn-lg" href="/" role="button">Отправится за проектами</a></p>
    </div>    
<?php endif;


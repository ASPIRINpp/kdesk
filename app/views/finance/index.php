<?php
$types = [__('Debit'), __('Credit'), __('In reseve'), __('Outreserve')];
$colors = ['success', 'danger', 'warning', 'info'];
?><table class="table table-striped">
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
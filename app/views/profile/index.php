<h1><?= $profile['login']; ?></h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Filed</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">Surname</th>
            <td><?= f('helpers:arr:get', 'surname', $profile, '<span class="text-muted">'.__('None').'</span>'); ?></td>
        </tr>
        <tr>
            <th scope="row">Name</th>
            <td><?= f('helpers:arr:get', 'name', $profile, '<span class="text-muted">'.__('None').'</span>'); ?></td>
        </tr>
        <tr>
            <th scope="row">Middlename</th>
            <td><?= f('helpers:arr:get', 'middlename', $profile, '<span class="text-muted">'.__('None').'</span>'); ?></td>
        </tr>
        <tr>
            <th scope="row">Sex</th>
            <td><?= ['Female', 'Male'][$profile['sex']]; ?></td>
        </tr>
        <tr>
            <th scope="row">Time registration</th>
            <td><?= date('H:i:s d.m.Y', $profile['time_reg']); ?></td>
        </tr>
        <tr>
            <th scope="row">Time last login</th>
            <td><?= date('H:i:s d.m.Y', $profile['time_last_login']); ?></td>
        </tr>
        <tr>
            <th scope="row">Time last activity</th>
            <td><?= date('H:i:s d.m.Y', $profile['time_last_activity']); ?></td>
        </tr>
        
    </tbody>
</table>
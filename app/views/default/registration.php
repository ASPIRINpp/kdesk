<h1><?=__('Sing up')?></h1>
<?php
    if(isset($res)) {
        echo '<pre>';
        var_dump($res);
        echo '</pre>';
    }
?>

<form id="regForm" method="post">
    <div class="form-group">
        <label for="inputLogin"><?=__('Login')?></label>
        <input type="text" name='Reg[login]' class="form-control" id="inputLogin" placeholder="<?=__('Enter login')?>" value="<?=f('helpers:arr:get', 'login', $_POST['Reg']);?>">
    </div>
    <div class="form-group">
        <label for="inputEmail"><?=__('Email address')?></label>
        <input type="email" name='Reg[email]' class="form-control" id="inputEmail" placeholder="<?=__('Enter email')?>" value="<?=f('helpers:arr:get', 'email', $_POST['Reg']);?>">
    </div>
    <div class="form-group">
        <label for="inputSex"><?=__('Sex')?></label>
        <select name='Reg[sex]' class="form-control" id="inputSex">
            <option <?=f('helpers:arr:get', 'sex', $_POST['Reg'], 0)==0?'selected':'';?> value="0"><?=__('Male')?></option>
            <option <?=f('helpers:arr:get', 'sex', $_POST['Reg'], 1)==1?'selected':'';?> value="1"><?=__('Female')?></option>
        </select>
    </div>
    <div class="form-group">
        <label for="inputSurname"><?=__('Surname')?></label>
        <input type="text" name='Reg[surname]' class="form-control" id="inputSurname" placeholder="<?=__('Enter surname')?>" value="<?=f('helpers:arr:get', 'surname', $_POST['Reg']);?>">
    </div>
    <div class="form-group">
        <label for="inputName"><?=__('Name')?></label>
        <input type="text" name='Reg[name]' class="form-control" id="inputName" placeholder="<?=__('Enter name')?>" value="<?=f('helpers:arr:get', 'name', $_POST['Reg']);?>">
    </div>
    <div class="form-group">
        <label for="inputMiddleName"><?=__('Middle name')?></label>
        <input type="text" name='Reg[middleName]' class="form-control" id="inputMiddleName" placeholder="<?=__('Enter middle name')?>" value="<?=f('helpers:arr:get', 'middleName', $_POST['Reg']);?>">
    </div>
    <div class="form-group">
        <label for="inputPassword"><?=__('Password')?></label>
        <input type="password" name='Reg[password]' class="form-control" id="inputPassword" placeholder="<?=__('Password')?>" value="<?=f('helpers:arr:get', 'password', $_POST['Reg']);?>">
    </div>
    <div class="form-group">
        <label for="inputRepeatPassword"><?=__('Repeat')?></label>
        <input type="password" name='Reg[repeatPassword]' class="form-control" id="inputRepeatPassword" placeholder="<?=__('Repeat password')?>">
    </div>
    <button type="submit" class="btn btn-default"><?=__('Submit')?></button>
</form>
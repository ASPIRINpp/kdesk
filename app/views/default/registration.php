<h1><?=__('Sing up')?></h1>
<?=$t?>
<form method="post">
    <div class="form-group">
        <label for="exampleInputEmail1"><?=__('Email address')?></label>
        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="<?=__('Enter email')?>">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1"><?=__('Password')?></label>
        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="<?=__('Password')?>">
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox"> <?=__('Check me out')?>
        </label>
    </div>
    <button type="submit" class="btn btn-default"><?=__('Submit')?></button>
</form>
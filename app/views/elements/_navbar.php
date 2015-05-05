<nav class="navbar navbar-inverse navbar-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">kDesk</a>
        </div>
        <?php if(!f('core:auth:logged')):?>
            <div id="navbar" class="navbar-collapse collapse">
                <form method="post" action="/" class="navbar-form navbar-right">
                    <div class="form-group">
                        <input type="text" name="Login[email]" placeholder="<?=__('Email')?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" name="Login[password]" placeholder="<?=__('Password')?>" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success"><?=__('Sign in')?></button>
                </form>
            </div><!--/.navbar-collapse -->
        <?php else: ?>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#">Projects</a></li>
                    <li><a href="#">In work</a></li>
                    <li><a href="#">Finance</a></li>
                    <li><a href="#">Account</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/logout"><?= ucfirst(strtolower(f('core:session:get', 'login'))) ?>, logout</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</nav>
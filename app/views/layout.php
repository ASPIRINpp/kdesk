<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>kDesk</title>
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <!-- Bootstrap -->
        <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/css/style.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php f('core:view:print', 'elements/_navbar'); ?>
        <?php if(!f('core:auth:logged')) {f('core:view:print', 'elements/_jumbotron');} ?>
        <div class="container">
            <?php if(isset($alerts)) echo $alerts;?>
            <?= $content; ?>
            <hr>
            <footer><p>&copy; kDesk <?= date('Y'); ?></p></footer>
        </div>
        <script src="/assets/js/app.js"></script>
    </body>
</html>
<?php use app\core\Application;

/**
 * @var Application::$app->user->getUserName() \app\core\DBModel
 */
?>
<!doctype html>
<html lang="ar">
    <head>
        <meta dir="rtl">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PHPMVC</title>
        <!-- <link rel="stylesheet" href="/main.css"> -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <script defer src="/js/app.js"></script>
    </head>
    <header>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Mohammed's Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="/contact">Contact us</a>
                </li>
            </ul>
            <?php if(Application::$app->isGust()): ;?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/login">Login</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="/register">Register</a>
                </li>
            </ul>
            <?php else: ?>
                <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/logout"><?php echo Application::$app->user->getUserName() ;?> Logout </a>
                </li>
            </ul
            <?php endif; ?>

            </div>
        </div>
</nav>
    </header>
    <body>
        <div class="container mt-4">
            <?php if(Application::$app->session->getFlash('success')): ;?>
                <div class="alert alert-success">
                    <?php echo Application::$app->session->getFlash('success') ;?>
                </div>
            <?php endif; ;?>
            {{content}}
        </div>
            
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>

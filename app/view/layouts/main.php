<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? SecurityHelper::e($title) . ' — ' : '' ?><?= SecurityHelper::e(Config::get('name') ?? 'Khumba') ?></title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, sans-serif; font-size: 16px; color: #1a1a1a; background: #f9f9f9; }
        .container { max-width: 1100px; margin: 0 auto; padding: 0 1.5rem; }
        header { background: #fff; border-bottom: 1px solid #e5e5e5; padding: .75rem 0; }
        header nav a { margin-right: 1rem; color: #555; text-decoration: none; font-size: .9rem; }
        header nav a:hover { color: #000; }
        main { padding: 2rem 0; }
        footer { border-top: 1px solid #e5e5e5; padding: 1rem 0; text-align: center; font-size: .8rem; color: #999; margin-top: 3rem; }
    </style>
</head>
<body>

<header>
    <div class="container">
        <nav>
            <a href="/">Home</a>
            <?php if (Auth::check()): ?>
                <a href="/logout">Logout</a>
            <?php else: ?>
                <a href="/login">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main>
    <div class="container">
        <?= $content ?>
    </div>
</main>

<footer>
    <div class="container">
        &copy; <?= date('Y') ?> <?= SecurityHelper::e(Config::get('name') ?? 'Khumba') ?>
    </div>
</footer>

</body>
</html>

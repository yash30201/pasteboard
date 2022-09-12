<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo url_for('index.css') ?>">
    <title>Pasteboard</title>
</head>

<body>
    <header>
        <h1>Pasteboard</h1>
    </header>
    <nav>
        <a href="<?php echo url_for('index.php') ?>" style="
    padding: 0 2rem;
">Create Paste</a>
        <?php if (!isset($_SESSION['logged']) || $_SESSION['logged'] == 'false') { ?>
            <a href="<?php echo url_for('/pages/authenticate.php') ?>" style="
padding: 0 2rem;">Authenticate</a>
        <?php } ?>
        <?php if (isset($_SESSION['logged']) && $_SESSION['logged'] == 'true') { ?>
            <a href="<?php echo url_for('pages/dashboard.php') ?>" style="
    padding: 0 2rem;
">Your pastes</a>
            <a href="<?php echo url_for('/Private/logout.php') ?>" style="
    padding: 0 2rem;">Log out</a>
        <?php } ?>
    </nav>
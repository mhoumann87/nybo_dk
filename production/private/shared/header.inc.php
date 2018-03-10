<?php
    if(!isset($title)) { $title = 'Admin'; }
    if(!isset($side)) { $side = ""; }

?>

<!doctype html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Dette er det oficielle online portfolio for fotograf Theis Nybo.">
    <title><?php echo($title); ?></title>
    <link rel="stylesheet" href="<?php echo url_for('/css/style.css'); ?>" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="<?php echo url_for('/images/favicon.png')?>" type="image/x-icon')>">
</head>

<body>

<header>
    <div class="logo">
        <a href="<?php echo url_for('/index.php'); ?>"><img src="<?php echo url_for('/images/nybo_logo.svg'); ?>" class="logo_head" alt="Theis Nybo Foto logo"></a>
        <h1 class="vis-ikke">Theis Nybo Fotografi</h1>
    </div>
    <div class="menu">
        <nav id="nav" class="nav" role="navigation">
            <input class="menu-btn" type="checkbox" id="menu-btn">
            <label class="menu-icon show" for="menu-btn"><span class="navicon"></span></label>
            <div id="show" class="menubar noshow">
                <div class="menu-item <?php echo ($side == 'index') ? 'active' : ' '; ?>"><a href="<?php echo url_for('/index.php'); ?>">Forside</a></div>
                <div class="menu-item <?php echo ($side == 'foto') ? 'active' : ' '; ?>"><a href="<?php echo url_for('/foto.php'); ?>">Fotografi</a></div>
                <div class="menu-item <?php echo ($side == 'nyheder') ? ' active' : ' '; ?>"><a href="<?php echo url_for('/nyheder.php'); ?>">Nyheder</a></div>
                <div class="menu-item <?php echo ($side == 'kontakt') ? ' active' : ' '; ?>"><a href="<?php echo url_for('/kontakt.php'); ?>">Kontakt</a></div>
            </div>
        </nav>
    </div>
</header>
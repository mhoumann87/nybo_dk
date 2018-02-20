<?php
    if(!isset($title)) { $title = 'Admin'; }
    if(!isset($page)) { $page = ""; }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title; ?></title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="<?php echo url_for('/css/style.css'); ?>">
</head>
<body>

<header>
    <div class="logo">
        <a href="<?php echo url_for('/admin/index.php'); ?>"><img src="<?php echo url_for('/images/nybo_logo.svg'); ?>" class="logo_head" alt="Theis Nybo Foto logo"></a>
        <h1 class="usynlig">Theis Nybo Fotografi</h1>
    </div>
    <div class="menu">
        <nav id="nav" role="navigation">
            <input class="menu-btn" type="checkbox" id="menu-btn">
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
            <div id="show" class="menubar noshow">
                <div class="menu-item <?php echo ($side == 'index') ? 'active' : ' '; ?>"><a href="<?php echo url_for('/admin/index.php'); ?>">Upload Foto</a></div>
                <div class="menu-item <?php echo ($side == 'nyhed') ? ' active' : ' '; ?>"><a href="<?php echo url_for('/admin/skriv_nyhed.php'); ?>">Skriv Nyhed</a></div>
                <div class="menu-item <?php echo ($side == 'bruger') ? 'active' : ' '; ?>"><a href="<?php echo url_for('/admin/opret_bruger'); ?>">Opret Bruger</a></div>
                <div class="menu-item <?php echo ($side == 'kontakt') ? ' active' : ' '; ?>"><a href="<?php echo url_for('/admin/logout.php'); ?>">Logout</a></div>
            </div>
        </nav>
    </div>
</header>
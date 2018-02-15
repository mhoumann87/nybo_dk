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
    <link rel="stylesheet" href="./css/style.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<header>
    <div class="logo" role="logo">
        <a href="index.php"><img src="./images/nybo_logo.svg" class="logo_head" alt="Theis Nybo Foto logo"></a>
        <h1 class="usynlig">Theis Nybo Fotografi</h1>
    </div>
    <div class="menu">
        <nav id="nav" role="navigation">
            <input class="menu-btn" type="checkbox" id="menu-btn">
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
            <div id="show" class="menubar noshow">
                <div class="menu-item <?php echo ($side == 'index') ? 'active' : ' '; ?>"><a href="index.php">Forside</a></div>
                <div class="menu-item <?php echo ($side == 'foto') ? 'active' : ' '; ?>"><a href="foto.php">Fotografi</a></div>
                <div class="menu-item <?php echo ($side == 'nyheder') ? ' active' : ' '; ?>"><a href="nyheder.php">Nyheder</a></div>
                <div class="menu-item <?php echo ($side == 'kontakt') ? ' active' : ' '; ?>"><a href="kontakt.php">Kontakt</a></div>
            </div>
        </nav>
    </div>
</header>
<?php

require_once ('./../../private/initialize.inc.php');
require_login();

$side = 'nyhed';
$title = 'Theis Nybo Foto - Skriv nyhed';

require_once (SHARED_PATH.'/admin_header.inc.php');

?>

<main>

    <nav class="sidebar_nav">

        <div class="velkommen">
            <p class="space-under">Velkommen&nbsp;<?php echo h($_SESSION['username']); ?></p>
        </div>

    </nav>


</main>

<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
<?php
require_once ('./../private/initialize.inc.php');

if(isset($_GET['id'])) {
    if (is_get_request() && $_GET['id'] === 'admin') {
        require_once(SHARED_PATH . '/admin_header.inc.php');
        $prev = url_for('/admin/index.php');
       // echo $prev;
    } else {
        require_once(SHARED_PATH . '/header.inc.php');
        $prev = url_for('/index.php');
    }
} else {
    require_once(SHARED_PATH . '/header.inc.php');
    $prev = url_for('/index.php');
}
?>

<main>



    <section class="centered_box">
        <h2 class="space-under">404</h2>
        <h2 class="space-under">UPS, vi kan ikke finde den side du kigger efter</h2>
        <img src="<?php echo url_for('/images/not_found.svg'); ?>" class="not_found_svg">
        <p>Tag mig tilbage til <a href="<?php echo $prev; ?>">sikker grund</a></p>
    </section>
</main>




<?php
if(isset($_GET['id'])) {
    if (is_get_request() && $_GET['id'] === 'admin') {
        require_once(SHARED_PATH . '/admin_footer.inc.php');
    } else {
        require_once(SHARED_PATH . '/footer.inc.php');
    }
} else {
    require_once(SHARED_PATH . '/footer.inc.php');
}

?>

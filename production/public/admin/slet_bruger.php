<?php
require_once ('./../../private/initialize.inc.php');
require_login();

$side = 'bruger';
$title = 'Theis Nybo Foto - Slet Bruger';

require_once (SHARED_PATH.'/admin_header.inc.php');

if (isset($_GET['id'])) {

    $id = trim(clean_input($db, $_GET['id']));
    $admin = find_admin_by_id($id);

    if(!$admin) {

       error_404('admin');
    }

} else if(is_post_request()) {

    if (array_key_exists('delete', $_POST)) {
        $sql = "DELETE FROM admins WHERE admin_id = '".trim(clean_input($db,$_POST['id']))."' LIMIT 1";

        if(query_sql($sql)) {
            redirect(url_for('/admin/opret_bruger'));
        } else {
            $msg = 'Der opstod en fejl. Prøv igen.';
        }

    } else if (array_key_exists('clear', $_POST)) {
        redirect(url_for('/admin/opret_bruger.php'));
    }
} else {
    redirect(url_for('/admin/index.php'));
}




?>

<main>

    <nav class="sidebar_nav">

        <div class="velkommen">
            <p class="space-under">Velkommen&nbsp;<?php echo h($_SESSION['username']); ?></p>
        </div>

    </nav>

    <section class="login_box">

        <h3 class="space">Slet Admin</h3>

        <div class="content-box">
        <h5 class="space">Vil du slette denne bruger</h5>

        <p class="space-under"><?php echo $admin['admin_firstname'];?>&nbsp;<?php echo $admin['admin_lastname'];?>&nbsp;<?php echo $admin['admin_mail'];?></p>

        </div>

        <form class="form_buttons" name="submit" action="<?php echo url_for('/admin/slet_bruger.php');?>" method="post">
            <input type="hidden" name="id" value="<?php echo $admin['admin_id']; ?>">
            <input class="del_button" type="submit" name="delete" value="Slet Admin">
            <input class="loginknap" type="submit" name="clear" value="Fortryd">
        </form>



        <p class="error"><?php echo $msg ?? ''; ?></p>

    </section>

</main>

<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>

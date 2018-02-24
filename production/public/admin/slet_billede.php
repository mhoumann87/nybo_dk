<?php
require_once ('./../../private/initialize.inc.php');
require_login();

$side = 'bruger';
$title = 'Theis Nybo Foto - Slet Bruger';

//require_once (SHARED_PATH.'/admin_header.inc.php');

if (isset($_GET['id'])) {

    $id = trim(clean_input($db, $_GET['id']));
    $photo = find_photo_by_id($id);
//    var_dump($photo);

    if(!$photo) {

        error_404('admin');
    }

} else if(is_post_request()) {

    if (array_key_exists('delete', $_POST)) {
        $sql = "DELETE FROM billeder WHERE billede_id = '".trim(clean_input($db,$_POST['id']))."' LIMIT 1";
        unlink('../images/uploads/'.$_POST['filename'].'');
        if(query_sql($sql)) {
           redirect(url_for('/admin/vis_billeder.php'));
        } else {
            $msg = 'Der opstod en fejl. Prøv igen.';
        }

    } else if (array_key_exists('clear', $_POST)) {
        redirect(url_for('/admin/vis_billeder.php'));
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

            <h3 class="space">Slet Billede</h3>

            <h4 class="space">Vil du slette dette billede?</h4>

            <div class="del_photo">
            <img src="<?php echo $photo['billede_link']; ?>">
                <h5><?php echo h($photo['billede_titel']); ?></h5>
            </div>
            <div class="box-space">

                <form class="slet_billede" name="submit" action="<?php echo url_for('/admin/slet_billede.php');?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $photo['billede_id']; ?>">
                    <input type="hidden" name="filename" value="<?php echo $photo['billede_filename']; ?>">
                    <input class="del_button" type="submit" name="delete" value="Slet Billede">
                    <input class="loginknap" type="submit" name="clear" value="Fortryd">
                </form>

            </div>

            <p class="error"><?php echo $msg ?? ''; ?></p>

        </section>

    </main>

<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
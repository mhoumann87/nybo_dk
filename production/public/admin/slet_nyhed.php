<?php
require_once ('./../../private/initialize.inc.php');
require_login();

$side = 'nyhed';
$title = 'Theis Nybo Foto - Slet Nyhed';

require_once (SHARED_PATH.'/admin_header.inc.php');

if (isset($_GET['id'])) {

    $id = trim(clean_input($db, $_GET['id']));
    $news = mysqli_fetch_assoc(find_news_by_id($id));
    $img = mysqli_fetch_assoc(find_newsImg_by_id(trim(clean_input($db, $news['newsImg_id']))));

    if($img['newsImg_height'] > $img['newsImg_width']) {
        $photo_class = 'port';
    } else {
        $photo_class =  'lands';
    }

    if(!$news) {

        error_404('admin');
    }

} else if(is_post_request()) {

    if (array_key_exists('delete', $_POST)) {
        $sql = "DELETE FROM news WHERE news_id = '".trim(clean_input($db,$_POST['id']))."' LIMIT 1";

            if(query_sql($sql)) {

                $sql ="DELETE FROM newsimgs WHERE newsImg_navn = '".$_POST['filename']."' LIMIT 1";
                echo $sql;
                unlink('../images/news/'.$_POST['filename'].'');

                if(query_sql($sql)) {
                    redirect(url_for('/admin/vis_nyheder.php'));
                } else {
                    $msg = 'Der opstod en fejl. Prøv igen.';
                }

            } else {
                $msg = 'Der opstod en fejl. Prøv igen.';
           }

    } else if (array_key_exists('clear', $_POST)) {
        redirect(url_for('/admin/vis_nyheder.php'));
    }
} else {
    redirect(url_for('/admin/vis_nyheder.php'));
}

?>

    <main>

        <nav class="sidebar_nav">

            <div class="velkommen">
                <p class="space-under">Velkommen&nbsp;<?php echo h($_SESSION['username']); ?></p>
            </div>

        </nav>

        <h3 class="side-titel space-under">Slet Nyhed</h3>

        <section class="en-nyhed-box">

            <div class="vis-nyheder">
                <div class="slet-nyhed-head">
                <h4>Vil du slette denne nyhed?</h4>
                </div>

                <div class="nyhed-head">
                <h5><?php echo h($news['news_overskrift']); ?></h5>
                </div>

                <div class="nyhed-foto">
                <img src="<?php echo $img['newsImg_link']; ?>" class="<?php echo $photo_class ?? ''; ?>" alt="<?php echo $img['newsImg_navn'] ?? ''; ?>">
                </div>

                <div class="nyhed-text">
                <p><?php echo $news['news_text'] ?></p>
                </div>

                <div class="store-knapper">
            <form class="form_buttons" name="submit" action="<?php echo url_for('/admin/slet_nyhed.php');?>" method="post">
                <input type="hidden" name="id" value="<?php echo $news['news_id']; ?>">
                <input type="hidden" name="filename" value="<?php echo $img['newsImg_navn']; ?>">
                <input class="del_button" type="submit" name="delete" value="Slet Nyhed">
                <input class="loginknap" type="submit" name="clear" value="Fortryd">
            </form>
                </div>
            </div>
        </section>

    </main>


<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
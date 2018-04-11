<?php
require_once('./../../private/initialize.inc.php');
require_login();

$side = 'vis_nyhed';
$title = 'Theis Nybo Foto - Vis Nyheder';

require_once(SHARED_PATH . '/admin_header.inc.php');

if (is_get_request()) {

    if (isset($_GET['newsid'])) {

        $news = mysqli_fetch_assoc(find_news_by_id(trim(clean_input($db, $_GET['newsid']))));

        if ($news) {

            $cat = mysqli_fetch_assoc(find_news_cat_by_id(trim(clean_input($db, $news['newskat_id']))));
            $cat = h($cat['newskat_navn']);

            $img = mysqli_fetch_assoc(find_newsImg_by_id(trim(clean_input($db, $news['newsImg_id']))));
            $foto = h($img['newsImg_link']);

            if ($img['newsImg_width'] < $img['newsImg_height']) {
                $photo_class = 'port';
            } else {
                $photo_class = 'lands';
            }

        } else {
            error_404('admin');
        }

    } else {

        redirect(url_for('/admin/vis_nyheder.php'));
    }

}//post_requset
?>

    <main>


        <nav class="sidebar_nav">

            <div class="velkommen">
                <p class="space-under">Velkommen&nbsp;<?php echo h($_SESSION['username']); ?></p>
            </div>

            <div class="sidebar_menu">

            </div>

        </nav>

        <h3 class="side-titel space-under">Læs nyhed</h3>

        <div class="en-nyhed-box">


            <div class="vis-nyheder">

                <div class="nyhed-head">
                    <h5><?php echo $news['news_overskrift']; ?></h5>
                </div>

                <div class="nyhed-foto">
                    <img src="<?php echo $foto; ?>" class="<?php echo $photo_class ?? ''; ?>"
                         alt="<?php echo $img['newsImg_navn']; ?>">
                </div>

                <div class="nyhed-info">
                    <p class="small">Uploaded <?php echo $news['news_dato'] ?></p>
                    <p class="small">Kategori: <a href="<?php echo url_for('/admin/vis_nyheder.php?cat=' . $news['newskat_id'] . ''); ?>"><?php echo $cat; ?></a></p>
                </div>

                <div class="nyhed-text">
                <p><?php echo $news['news_text']; ?></p>
                </div>

                <div class="nyhed-slet">
                    <p><a href="<?php echo url_for('/admin/slet_nyhed.php?id=' . $news['news_id'] . '') ?>">Slet Nyhed</a></p>
                    <p><a href="<?php echo url_for('/admin/ret_nyhed.php?id=' . $news['news_id'] . '') ?>">Ret Nyhed</a></p>
                </div>
            </div>

        </div>

    </main>

<?php require_once(SHARED_PATH . '/admin_footer.inc.php'); ?>
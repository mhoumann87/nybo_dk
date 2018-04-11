<?php
require_once ('./../../private/initialize.inc.php');
require_login();

$side = 'vis_nyhed';
$title = 'Theis Nybo Foto - Vis Nyheder';

require_once (SHARED_PATH.'/admin_header.inc.php');

if(is_get_request()) {

    if(isset($_GET['newsid'])) {

        $news = mysqli_fetch_assoc(find_news_by_id(trim(clean_input($db, $_GET['newsid']))));

        if($news) {

            $cat = mysqli_fetch_assoc(find_news_cat_by_id(trim(clean_input($db, $news['newskat_id']))));
            $cat = h($cat['newskat_navn']);

            $img = mysqli_fetch_assoc(find_newsImg_by_id(trim(clean_input($db, $news['newsImg_id']))));
            $foto = h($img['newsImg_link']);

            if($img['newsImg_width'] < $img['newsImg_height']) {
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

            <div><a href="<?php echo url_for('/admin/vis_nyheder.php');?>">Alle Nyheder</div>
            <?php $categories = find_all_news_categories();
            if($categories) {
                while($category = mysqli_fetch_assoc($categories)) { ?>
                    <div class="sb_menu_item"><a href="<?php echo url_for('/admin/vis_nyheder.php?cat='.h($news['newskat_id']).'')?>"><?php echo h($cat); ?></a> </div>

                    <?php
                }
            }

            ?>

        </div>

    </nav>

    <div class="login_box">

        <h3>Læs nyhed</h3>

        <div class="content-box">

                    <div class="news_box box-space">

                        <img src="<?php echo $foto; ?>" class="<?php echo $photo_class ?? '';?>" alt="<?php echo $img['newsImg_navn']; ?>">
                        <h5><?php echo $news['news_overskrift']; ?></h5>
                        <p class="small">Uploaded <?php echo $news['news_dato'] ?> Kategori: <a href="<?php echo url_for('/admin/vis_nyheder.php?cat='.$news['newskat_id'].'');?>"><?php echo $cat; ?></a></p>

                            <p><?php echo $news['news_text']; ?></p>

                    </div>

            <p class="form_buttons"> <a href="<?php echo url_for('/admin/slet_nyhed.php?id='.$nyhed['news_id'].'')?>">Slet Nyhed</a><a href="<?php echo url_for('/admin/ret_nyhed.php?id='.$nyhed['news_id'].'')?>">Ret Nyhed</a></p>

        </div>

    </div>

</main>

<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
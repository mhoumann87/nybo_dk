<?php
require_once ('./../../private/initialize.inc.php');
require_login();

$side = 'vis_nyhed';
$title = 'Theis Nybo Foto - Vis Nyheder';

require_once (SHARED_PATH.'/admin_header.inc.php');

if(is_get_request()) {

    if (isset($_GET['cat'])) {

        $news = find_news_by_cat(trim(clean_input($db, $_GET['cat'])));
        $kategori = mysqli_fetch_assoc(find_news_cat_by_id(trim(clean_input($db, $_GET['cat'] ))));
        $cat = h(ucfirst($kategori['newskat_navn']));

        if (!$news) {
            error_404('admin');
        }
    } else {
        $news = find_all_news();

        if(!$news) {
            $msg = 'Der er ikke uploaded nogle billeder endnu';
        }

    }

}
?>


    <main>

        <nav class="sidebar_nav">

            <div class="velkommen">
                <p class="space-under">Velkommen&nbsp;<?php echo h($_SESSION['username']); ?></p>
            </div>

            <div class="sidebar_menu">

                <div class="sidebar_nav-item"><a href="<?php echo url_for('/admin/vis_nyheder.php');?>">Alle Nyheder</div>
                <?php $categories = find_all_news_categories();
                if($categories) {
                    while($category = mysqli_fetch_assoc($categories)) { ?>
                        <div class="sidebar_nav-item"><a href="<?php echo url_for('/admin/vis_nyheder.php?cat='.h($category['newskat_id']).'')?>"><?php echo h(ucfirst($category['newskat_navn'])); ?></a> </div>

                        <?php
                    }
                }

                ?>

            </div>

        </nav>

        <div class="login_box">

            <h3 class="space-under"><?php echo $cat ?? 'Alle nyheder'; ?></h3>

            <div class="content-box">
                <?php
                if(isset($msg)) {
                    echo '<p class="error">'.$msg.'</p>';
                } else {

                    while($nyhed = mysqli_fetch_assoc($news)) { ?>
                        <div class="news_box">
                            <?php
                                $img = mysqli_fetch_assoc(find_newsImg_by_id(trim(clean_input($db, $nyhed['newsImg_id']))));

                                if(!$img) {
                                    $msg = 'Kunne ikke finde image';
                                } else {
                                    if($img['newsImg_width'] < $img['newsImg_height']) {
                                        $img_class = 'port';
                                    } else {
                                        $img_class = 'lands';
                                    }
                                }

                                $kat = mysqli_fetch_assoc(find_news_cat_by_id(trim(clean_input($db, $nyhed['newskat_id']))));
                                $kat = h($kat['newskat_navn']);
                            ?>
                            <img src="<?php echo $img['newsImg_link']; ?>" class="<?php echo $img_class ?? '';?>" alt="<?php echo $img['newsImg_navn']; ?>">
                            <h5><?php echo $nyhed['news_overskrift']; ?></h5>
                            <p class="small space-under">Uploaded <?php echo $nyhed['news_dato'] ?> Kategori: <a href="<?php echo url_for('/admin/vis_nyheder.php?cat='.$nyhed['newskat_id'].'');?>"><?php echo $kat; ?></a></p>
                            <?php
                                if(strlen($nyhed['news_text'] >= '250')) {
                                    $url = url_for('/admin/vis_nyhed.php?newsid=').$nyhed['news_id'];
                                    $content = substr($nyhed['news_text'], 0, 250).'... <a href="'.$url.'">Læs mere</a>';
                                } else {
                                    $content = $nyhed['news_text'];
                                }

                            ?>
                            <p><?php echo $content; ?></p>

                            <br><br>

                            <p class="form_buttons"> <a href="<?php echo url_for('/admin/slet_nyhed.php?id='.$nyhed['news_id'].'')?>">Slet Nyhed</a><a href="<?php echo url_for('/admin/ret_nyhed.php?id='.$nyhed['news_id'].'')?>">Ret Nyhed</a></p>

                        </div>
                        <?php
                    }
                }
                ?>
            </div>

        </div>

    </main>



<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
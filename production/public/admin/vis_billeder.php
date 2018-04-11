<?php
require_once ('./../../private/initialize.inc.php');
require_login();

$side = 'vis_foto';
$title = 'Theis Nybo Foto - Vis billeder';

require_once (SHARED_PATH.'/admin_header.inc.php');

if(is_get_request()) {

    if (isset($_GET['cat'])) {

        $photos = find_photos_by_category(trim(clean_input($db, $_GET['cat'])));
        $kategori = find_category_by_id(trim(clean_input($db, $_GET['cat'] )));
        $cat = h(ucfirst($kategori['kategori_navn']));

        if (!$photos) {
            error_404('admin');
        }
    } else {
        $photos = find_all_photos();

        if(!$photos) {
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

            <div class="sidebar_nav-item"><a href="<?php echo url_for('/admin/vis_billeder.php');?>">Alle Billeder</div>
        <?php $categories = find_all_categories();
            if($categories) {
            while($category = mysqli_fetch_assoc($categories)) { ?>
                <div class="sidebar_nav-item"><a href="<?php echo url_for('/admin/vis_billeder.php?cat='.h($category['kategori_id']).'')?>"><?php echo h(ucfirst($category['kategori_navn'])); ?></a> </div>

        <?php
                }
            }

        ?>

        </div>

    </nav>

    <h3 class="side-titel space-under"><?php echo $cat ?? 'Alle billeder'; ?></h3>

    <div class="admin-photo-box">

        <?php
        if(isset($msg)) {
            echo '<p class="error">'.$msg.'</p>';
        } else {

            while($photo = mysqli_fetch_assoc($photos)) { ?>

            <?php

            if($photo['billede_height'] > $photo['billede_width']) {
                $photo_class = 'port';
            } else {
                 $photo_class =  'lands';
            }
            ?>

                <div class="photo_box">

                    <div class="vis-foto">
                        <img src="<?php echo $photo['billede_link']; ?>" class="<?php echo $photo_class ?? '';?>" alt="<?php echo $photo['billede_titel']; ?>">
                    </div>
                    <div class="foto-caption">
                        <h5><?php echo $photo['billede_titel']; ?></h5>
                    </div>

                    <div class="slet-foto">
                        <p><a href="<?php echo url_for('/admin/slet_billede.php?id='.h($photo['billede_id']).'')?>" class="center">Slet</a></p>
                    </div>

                </div>
                <?php
            }
        }
    ?>
    </div>




</main>


<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
<?php
require_once ('./../../private/initialize.inc.php');
//require_login();

$side = 'foto';
$title = 'Theis Nybo Foto - Vis billeder';

//require_once (SHARED_PATH.'/admin_header.inc.php');

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

        <?php $categories = find_all_categories();
            if($categories) {
             echo '<ul class="sidebar_menu">';
            while($category = mysqli_fetch_assoc($categories)) { ?>
                <li class="sb_menu_item"><a href="<?php echo url_for('/admin/vis_billeder.php?cat='.h($category['kategori_id']).'')?>"><?php echo h(ucfirst($category['kategori_navn'])); ?></a> </li>

        <?php
                }
            }
            echo '</ul>';
        ?>

    </nav>
    <h3 class="space-under"><?php echo $cat ?? 'Alle billeder'; ?></h3>
    <?php
        if(isset($msg)) {
            echo '<p class="error">'.$msg.'</p>';
        } else {

            while($photo = mysqli_fetch_assoc($photos)) { ?>
                <div class="photo_box">
                    <img src="<?php echo $photo['billede_link']; ?>" alt="<?php echo $photo['billede_navn']; ?>">
                    <h5><?php echo $photo['billede_titel']; ?></h5>
                    <a href="<?php echo url_for('/admin/slet_billede.php?id='.h($photo['billede_id']).'')?>">Slet</a>
                </div>
                <?php
            }
        }
    ?>

</main>


<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
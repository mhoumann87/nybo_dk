<?php
require_once ('./../../private/initialize.inc.php');
//require_login();

$side = 'foto';
$title = 'Theis Nybo Foto - Vis billeder';

//require_once (SHARED_PATH.'/admin_header.inc.php');

if(is_get_request()) {

    if (isset($_GET['cat'])) {

        $photos = find_photos_by_category(trim(clean_input($db, $_GET['cat'])));

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
    <h3 class="space-under"><?php echo $_GET['cat'] ?? 'Alle billeder'; ?></h3>
    <?php
        if(isset($msg)) {
            echo '<p class="error">'.$msg.'</p>';
        } else {




            while($photo = mysqli_fetch_assoc($photos)) { ?>



                <?php
            }
        }
    ?>

</main>


<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
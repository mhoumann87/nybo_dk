<?php
require_once ('./../../private/initialize.inc.php');
require_login();

$side = 'foto';
$title = 'Theis Nybo Foto - Upload billede';


require_once (SHARED_PATH.'/admin_header.inc.php');

$maxsize = 2048000;

if (is_post_request()) {

    $name = trim(clean_input($db, $_POST['name']));
    $cat = trim(clean_input($db, $_POST['cat']));
    $dato = time();

    $target_dir = '../images/uploads/';
    $link_dir = url_for('images/uploads/');

if(empty($_FILES['pic']['name'])) {
    $errors['photo'] = ' - Der skal vælges et foto';
} else if($_FILES['pic']['error'] === 2) {
    $errors['photo']  = ' - Billed filen er for stor, den må max være '.ini_get('upload_max_filesize').'B';
} else {
    $filename = basename($_FILES["pic"]["name"]);
    $target_file = $target_dir . basename($_FILES["pic"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $image_size = getimagesize($_FILES['pic']['tmp_name']);
    $file_size = $_FILES['pic']['size'];
    $dimensions = explode('"', $image_size[3]);
    $width = $dimensions[1];
    $height = $dimensions[3];
    $link = $link_dir.basename($_FILES["pic"]["name"]);

    if (!is_filled($name)) {
        $errors['name'] = ' - Du skal angive en title';
    } else if(title_exist($name) !== 0) {
        $errors['name'] = ' - Der findes allerede et billede med den titel i databasen';
    } else if(!is_filled($cat)) {
        $errors['cat'] = ' - Kategori skal angives';
    } else if($filename === '') {
        $errors['photo'] = ' - Der skal vælges et billede';
    } else if(file_exists($target_file)) {
        $errors['photo'] = ' - Der findes allerede et billede med det navn på siden';
    } else if($image_size === false) {
        $errors['photo'] = ' - Dette er ikke et foto';
    } else if($file_size > $maxsize) {
        $errors['photo'] = ' - Billedefilen  er for stor';
    } else if($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'gif') {
        $errors['photo'] = ' - Kun filer af typen JPG, GIF eller PNG er tilladt';
    }
}

    $kategorier = find_all_categories();


if(empty($errors)) {
       // echo $cat;
        $cat_name = mysqli_fetch_assoc(find_category_by_name(trim(clean_input($db, $cat))));

        if($cat_name) {

            $category = $cat_name['kategori_id'];

        } else {
            $sql = "INSERT INTO kategorier (kategori_navn) VALUES ('".trim(clean_input($db, $cat))."')";
            if(query_sql($sql)) {
                $category = mysqli_insert_id($db);
            } else {
                $msg = 'Noget gik galt under overførelser (cat)';
            }
        }

        if(move_uploaded_file($_FILES['pic']['tmp_name'], $target_file)) {
            $sql = "INSERT INTO billeder (billede_link, billede_filename, billede_titel, kategori_id, billede_width, billede_height, billede_upload) ";
            $sql .= "VALUES ('".$link."', '".$filename."', '".$name."', '".$category."', '".$width."', '".$height."', '".$dato."')";

            if(query_sql($sql)) {
                redirect(url_for('/admin/vis_billeder.php'));
            } else {
                $msg = 'Noget gik galt under overførelsen, prøv igen';
            }
        } else {
            $msg = 'Billedet kunne ikke uploades, prøv igen';
            echo $target_file;
        }
        }

}


?>

<main>

    <nav class="sidebar_nav">

        <div class="velkommen">
            <p>Velkommen <?php echo h($_SESSION['username']); ?></p>
        </div>

        <div class="sidebar_menu">

            <div class="sb_menu_item"><a href="<?php echo url_for('/admin/vis_billeder.php');?>">Alle Billeder</a></div>

            <?php $categories = find_all_categories();
            if($categories) {
                while($category = mysqli_fetch_assoc($categories)) { ?>
                    <div class="sb_menu_item"><a href="<?php echo url_for('/admin/vis_billeder.php?cat='.h($category['kategori_id']).'')?>"><?php echo h(ucfirst($category['kategori_navn'])); ?></a> </div>
                    <?php
                }
            }
            ?>

        </div>

    </nav>

    <div class="login_box">
        <h3 class="space-under">Upload billede</h3>

        <form name="form-box" action="<?php echo url_for('/admin/index.php'); ?>" method="post" enctype="multipart/form-data">

            <div class="form_item">
                <label for="name" class="formnavn<?php if(isset($errors['name'])) {echo ' error';}?>">Billedets Titel</label><span class="error"><?php echo $errors['name'] ?? ''; ?></span><br>
                <input type="text" name="name" class="textfelt<?php if(isset($errors['name'])) {echo ' error_border';}?>" placeholder="Indtast titel på billede" value="<?php echo $name ?? ''; ?>">
            </div>

            <div class="form_item">
                <label for="cat" class="formnavn<?php if(isset($errors['cat'])) {echo ' error';}?>">Billedets Kategori</label><span class="error"><?php echo $errors['cat'] ?? ''; ?></span><br>
                <input type="text" list="cat" name="cat" class="textfelt<?php if(isset($errors['cat'])) {echo ' error_border';}?>" placeholder="Indtast kategori" value="<?php echo $cat ?? ''; ?>">
                <datalist id="cat">
                    <?php
                    if($kategorier) {
                    while($kategori = mysqli_fetch_assoc($kategorier)) { ?>
                    <option value="<?php echo h($kategori['kategori_navn']); ?>">
                    <?php }
                    } else {
                        echo '';
                    }?>
                </datalist>
            </div>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxsize ;?>">
            <div class="form_item">
                <label for="pic" class="formnavn<?php if(isset($errors['photo'])) {echo ' error';}?>">Vælg billede (max. 2 MB)</label><span class="error"><?php echo $errors['photo'] ?? ''; ?></span><br>
                <input class=textfelt type="file" name="pic" accept="image/*">
            </div>

            <div class="form_item form_buttons">
                <input type="submit" name="submit" class="loginknap" value="Upload Billede">
            </div>

        </form>

            <p class="error"><?php echo $msg ?? ''; ?></p>

            <p class="error"><?php if(!empty($errors)) {
                    echo '<h6>Ret disse fejl:</h6>';
                    echo '<ul>';
                    foreach ($errors as $error) {
                        echo '<li>'.h($error).'</li>';
                    }
                    echo '</ul>';
                } ?></p>


    </div>

</main>

<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
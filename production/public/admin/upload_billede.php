<?php
require_once ('./../../private/initialize.inc.php');
//require_login();

$side = 'foto';
$title = 'Theis Nybo Foto - Upload billede';


require_once (SHARED_PATH.'/admin_header.inc.php');

if (is_post_request()) {

    $name = trim(clean_input($db, $_POST['name']));
    $cat = trim(clean_input($db, $_POST['cat']));
    $target_dir = '../images/uploads/';
    $target_file = $target_dir . basename($_FILES["pic"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $image_size = getimagesize($_FILES['pic']['tmp_name']);
    $dimensions = explode('"', $image_size[3]);
    $width = $dimensions[1];
    $height = $dimensions[3];
    $link = trim(clean_input($db, $target_file));
    $dato = time();

    if(!is_filled($name)) {
        $errors['name'] = ' - Du skal angive en title';
    } else if(title_exist($name) !== 0) {
        $errors['name'] = ' - Der findes allerede et billede med den titel i databasen';
    } else if(!is_filled($cat)) {
        $errors['cat'] = ' - Kategori skal angives';
    } else if(file_exists($target_file)) {
        $errors['photo'] = ' - Der findes allerede et billede med det navn på siden';
    } else if($image_size === false) {
        $errors['photo'] = ' - Dette er ikke et foto';
    } else if($_FILES['pic']['size'] > 2048000) {
        $errors['photo'] = ' - Billedefilen  er for stor';
    } else if($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'gif') {
        $errors['photo'] = ' - Kun filer af typen JPG, GIF eller PNG er tilladt';
    }

if(empty($errors)) {

        if(move_uploaded_file($_FILES['pic']['tmp_name'], $target_file)) {
            $sql = "INSERT INTO billeder (billede_link, billede_titel, billede_kategori, billede_width, billede_height, billede_upload) ";
            $sql .= "VALUES ('".$link."', '".$name."', '".$cat."', '".$width."', '".$height."', '".$dato."')";

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

    <div class="login_box">
        <h3 class="space-under">Upload billede</h3>

        <form name="upload" action="<?php echo url_for('/admin/upload_billede.php'); ?>" method="post" enctype="multipart/form-data">

            <div class="form_item">
                <label for="name" class="formnavn<?php if(isset($errors['name'])) {echo ' error';}?>">Billedets Titel</label><span class="error"><?php echo $errors['name'] ?? ''; ?></span><br>
                <input type="text" name="name" class="textfelt<?php if(isset($errors['name'])) {echo ' error_border';}?>" placeholder="Indtast titel på billede" value="<?php echo $name ?? ''; ?>">
            </div>

            <div class="form_item">
                <label for="cat" class="formnavn<?php if(isset($errors['cat'])) {echo ' error';}?>">Billedets Kategori</label><span class="error"><?php echo $errors['cat'] ?? ''; ?></span><br>
                <input type="text" name="cat" class="textfelt<?php if(isset($errors['cat'])) {echo ' error_border';}?>" placeholder="Indtast kategori" value="<?php echo $cat ?? ''; ?>">
            </div>

            <div class="form_itme">
                <label for="pic" class="formnavn<?php if(isset($errors['photo'])) {echo ' error';}?>">Vælg billede (max. 2 MB)</label><span class="error"><?php echo $errors['photo'] ?? ''; ?></span><br>
                <input class=textfelt type="file" name="pic" accept="image/*">
            </div>

            <div class="">
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

    <img src="<?php echo url_for('/images/uploads/260902-002_0002.jpg');?>" alt="test">

</main>

<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
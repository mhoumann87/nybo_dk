<?php

require_once ('./../../private/initialize.inc.php');
//require_login();

$side = 'nyhed';
$title = 'Theis Nybo Foto - Skriv nyhed';

require_once (SHARED_PATH.'/admin_header.inc.php');

$allowed_tags = '<ol><ul><li><strong><em><p><a>';


if(is_post_request()) {

    $name = trim(clean_input($db, $_POST['titel']));
    $cat = trim(clean_input($db, $_POST['cat']));
    $target_dir = '../images//';
    $filename = basename($_FILES["pic"]["name"]);
    $target_file = $target_dir . basename($_FILES["pic"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $image_size = getimagesize($_FILES['pic']['tmp_name']);
    $dimensions = explode('"', $image_size[3]);
    $width = $dimensions[1];
    $height = $dimensions[3];
    $link = trim(clean_input($db, $target_file));
    $dato = time();

    $kategorier = find_all_categories();

    echo $text;
}

?>
    <script src="./ckeditor/ckeditor.js"></script>
<main>

    <form name="skriv" action="<?php url_for('/admin/skriv_nyhed.php');?>" method="post" enctype="multipart/form-data">

        <div class="form_item">
            <label for="titel" class="formnavn<?php if(isset($errors['titel'])) {echo ' error';}?>">Titel</label><span class="error"><?php echo $errors['titel'] ?? ''; ?></span><br>
            <input class=textfelt type="text" name="titel" placeholder="Indtast titel" value="<?php echo $titel ?? '' ;?>">
        </div>

        <div class="form_item">

            <label for="indhold" class="formnavn<?php if(isset($errors['indhold'])) {echo ' error';}?>">Indhold</label><span class="error"><?php echo $errors['indhold'] ?? ''; ?></span><br>
            <textarea name="editor1" id="editor1" rows="10" cols="80"><?php echo $text ?? 'Skriv nyhed'?></textarea>
            <script>
                CKEDITOR.replace( 'editor1' );
            </script>
        </div>

        <div class="form_item">
            <label for="cat" class="formnavn<?php if(isset($errors['cat'])) {echo ' error';}?>">Kategori</label><span class="error"><?php echo $errors['cat'] ?? ''; ?></span><br>
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

        <div class="form_itme">
            <label for="pic" class="formnavn<?php if(isset($errors['photo'])) {echo ' error';}?>">Vælg billede (max. 2 MB)</label><span class="error"><?php echo $errors['photo'] ?? ''; ?></span><br>
            <input class=textfelt type="file" name="pic" accept="image/*">
        </div>

        <div class="">
            <input type="submit" name="submit" class="loginknap" value="Opret Nyhed">
        </div>

    </form>
</main>

<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
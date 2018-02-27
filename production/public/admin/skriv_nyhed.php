<?php

require_once ('./../../private/initialize.inc.php');
require_login();

$side = 'nyhed';
$title = 'Theis Nybo Foto - Skriv nyhed';

require_once (SHARED_PATH.'/admin_header.inc.php');

$allowed_tags = '<ol><ul><li><strong><em><p><a>';


if(is_post_request()) {

    $titel = trim(clean_input($db, $_POST['titel']));
    $cat = trim(clean_input($db, $_POST['cat']));
    $dato = date('H:i j/n/Y');
    $time = time();
    $text = strip_tags(stripslashes($_POST['editor1']), $allowed_tags);
    $indhold = trim(clean_input($db, $text));

    $target_dir = '../images/news/';

    if(!empty($_FILES['pic']['name'])) {
        $filename = basename($_FILES["pic"]["name"]);
        $target_file = $target_dir . basename($_FILES["pic"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $image_size = getimagesize($_FILES['pic']['tmp_name']);
        $dimensions = explode('"', $image_size[3]);
        $width = $dimensions[1];
        $height = $dimensions[3];
        $link = trim(clean_input($db, $target_file));

    } else {
        $filename = '';
        $target_file = '';
        $imageFileType = '';
        $image_size = '';
        $dimensions = '';
        $width = '';
        $height = '';
        $link = '';
    }



    $kategorier = find_all_news_categories();

    if(!is_filled($titel)) {
        $errors['titel'] = ' - Titel skal udfyldes';
    } else if(!is_filled($text)) {
        $errors['text'] = ' - Indhold skal udfyldes';
    } else if(!is_filled($cat)) {
        $errors['cat'] = ' - Kategori skal udfyldes';
    } else if($filename === '') {
        $errors['photo'] = ' - Der skal vælges et billede';
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

        $cat_name = mysqli_fetch_assoc(find_news_cat_by_name(trim(clean_input($db, $cat))));

        if($cat_name) {
            $katid = $cat_name['newskat_id'];
        } else {
            $sql = "INSERT INTO newskat (newskat_navn) VALUES('".trim(clean_input($db, $cat))."')";
            if(query_sql($sql)) {
                $katid = mysqli_insert_id($db);

            } else $msg = 'Noget gik galt under overførelsen';
        }// if($cat_name)

        if(move_uploaded_file($_FILES['pic']['tmp_name'], $target_file)) {
            $sql = "INSERT INTO newsimgs (newsImg_navn, newsImg_link, newsImg_width, newsImg_height) ";
            $sql .= "VALUES ('".$filename."', '".$link."', '".$width."', '".$height."')";

            if(query_sql($sql)) {
                $photoid = mysqli_insert_id($db);

            } else {
                $msg = 'Noget gik galt under overførelsen, prøv igen';
            }
        } else {
            $msg = 'Billedet kunne ikke uploades, prøv igen';
            echo $target_file;
        }// if(move_uploaded_file

        $sql = "INSERT INTO news (news_overskrift, news_text, news_dato, news_time, newskat_id, newsImg_id) ";
        $sql .= "VALUES ('".$titel."', '".$indhold."', '".$dato."', '".$time."', '".$katid."', '".$photoid."')";

        if(query_sql($sql)) {
            redirect(url_for('/admin/vis_nyheder.php'));
        } else {
            $msg = 'Noget gik galt under overførelsen';
        }
        }//if(empty($errors))

}// if(is_post_request)


?>
    <script src="./ckeditor/ckeditor.js"></script>
<main>

    <nav class="sidebar_nav">

        <div class="velkommen">
            <p>Velkommen <?php echo h($_SESSION['username']); ?></p>
        </div>

        <div class="sidebar_menu">

            <div class="sb_menu_item"><a href="<?php echo url_for('/admin/vis_nyheder.php');?>">Alle Nyheder</a></div>

            <?php $categories = find_all_news_categories();
            if($categories) {
                while($category = mysqli_fetch_assoc($categories)) { ?>
                    <div class="sb_menu_item"><a href="<?php echo url_for('/admin/vis_nyheder.php?cat='.h($category['newskat_id']).'')?>"><?php echo h(ucfirst($category['newskat_navn'])); ?></a> </div>
                    <?php
                }
            }
            ?>

        </div>

    </nav>


    <sectiom class="login_box">
        <h3 class="space-under">Skriv Nyhed</h3>
    <form name="form-box" action="<?php url_for('/admin/skriv_nyhed.php');?>" method="post" enctype="multipart/form-data">

        <div class="form_item">
            <label for="titel" class="formnavn<?php if(isset($errors['titel'])) {echo ' error';}?>">Titel</label><span class="error"><?php echo $errors['titel'] ?? ''; ?></span><br>
            <input class=textfelt type="text" name="titel" placeholder="Indtast titel" value="<?php echo $titel ?? '' ;?>">
        </div>

        <div class="form_item">

            <label for="indhold" class="formnavn<?php if(isset($errors['indhold'])) {echo ' error';}?>">Indhold</label><span class="error"><?php echo $errors['indhold'] ?? ''; ?></span><br>
            <textarea name="editor1" id="editor1" rows="10" cols="80"><?php echo $text ?? ''?></textarea>
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

        <div class="form_item">
            <label for="pic" class="formnavn<?php if(isset($errors['photo'])) {echo ' error';}?>">Vælg billede (max. 2 MB)</label><span class="error"><?php echo $errors['photo'] ?? ''; ?></span><br>
            <input class=textfelt type="file" name="pic" accept="image/*">
        </div>

        <div class="form_item">
            <input type="submit" name="submit" class="loginknap" value="Opret Nyhed">
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


    </sectiom>

</main>

<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
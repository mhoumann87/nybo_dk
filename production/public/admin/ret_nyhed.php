<?php
require_once ('./../../private/initialize.inc.php');
require_login();

$side = 'nyhed';
$title = 'Theis Nybo Foto - Ret Nyhed';

require_once (SHARED_PATH.'/admin_header.inc.php');
require_login();


if(is_get_request()) {

    if(isset($_GET['id'])) {

        $cat = mysqli_fetch_assoc(find_news_by_id(trim(clean_input($db, $_GET['id']))));

        if($cat) {
            $overskrift = trim(clean_input($db, $cat['news_overskrift']));
            $indhold = strip_tags(stripslashes(trim(clean_input($db, $cat['news_text']))));
            $img = mysqli_fetch_assoc(find_newsImg_by_id(trim(clean_input($db, $cat['newsImg_id']))));
            $imgscr = $img['newsImg_link'];
            $id = $cat['news_id'];
            $imgid = $cat['newsImg_id'];

            //echo $imgid.'<br>'.$id;

            if($img['newsImg_width']> $img['newsImg_height']) {
                $img_class = 'port';
            } else {
                $img_class = 'lands';
            }
        } else {
            error_404('admin');
        }

    } else {
        redirect(url_for('/admin/vis_nyheder.php'));
    }

} else if(is_post_request()) {

    if(isset($_POST['id'])) {

        $allowed_tags = '<ol><ul><li><strong><em><p><a>';

        $img = mysqli_fetch_assoc(find_newsImg_by_id(trim(clean_input($db, $_POST['img']))));
        $imgscr = $img['newsImg_link'];

        if($img['newsImg_width']> $img['newsImg_height']) {
            $img_class = 'port';
        } else {
            $img_class = 'lands';
        }

        $id = trim(clean_input($db, $_POST['id']));
        $overskrift = strip_tags(stripslashes($_POST['overskrift']));
        $overskrift = trim(clean_input($db, $overskrift));

        $text = strip_tags(stripslashes($_POST['editor1']), $allowed_tags);
        $indhold = trim(clean_input($db, $text));

        if(!is_filled($overskrift)) {
            $errors['overskrift'] = ' - Overskrift skal udfyldes';
        } else if(!is_filled($indhold)) {
            $errors['indhold'] = ' - Indhold slal udfyldes';
        }

        if(empty($errors)) {

            $sql = "UPDATE news SET news_overskrift = '".$overskrift."', news_text = '".$indhold."' WHERE news_id = '".$id."' LIMIT 1";

            if(query_sql($sql)) {
                $msg = '<p class="success space-under">Nyheder er ændret</p>';
            } else {
                $msg = '<p class="error space-under">Noget gik galt under overførelsen</p>';
            }

        } else {
            echo 'fejl';
        }


    } else {
        echo 'virker ikke';
    }
}

?>

    <main>

        <section class="login_box">
            <h3>Ret Nyhed</h3>

            <article class="content-box box-space">

                <img src="<?php echo $imgscr; ?>" class="<?php echo $img_class; ?> space-under" alt="<?php $img['newsImg_navn'];?>">
                <form name="change" action="<?php echo url_for('/admin/ret_nyhed.php');?>" method="post">


                    <input type="hidden" name="img" value="<?php echo $imgid;?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <div class="form_item">

                        <label for="overskrift" class="<?php if(isset($errors['overskrift'])) {echo 'error';}?>">Overskrift</label><span class="error"><?php echo $errors['overskrift'] ?? ''; ?></span><br>
                        <input type="text" name="overskrift" class="textfelt" value="<?php echo $overskrift ?? ''; ?>">

                    </div>

                    <div class="form_item">

                        <label for="indhold" class="formnavn<?php if(isset($errors['indhold'])) {echo ' error';}?>">Indhold</label><span class="error"><?php echo $errors['indhold'] ?? ''; ?></span><br>
                        <textarea name="editor1" id="editor1" rows="10" cols="80"><?php echo $indhold ?? ''?></textarea>
                        <script>
                            CKEDITOR.replace( 'editor1' );
                        </script>
                    </div>

                    <div class="form_item">

                        <input type="submit" name="submit" class="loginknap" value="Ret Nyhed">
                    </div>

                    <?php

                    ?>

                </form>

                <?php echo $msg ?? ''; ?>

                <p class="error"><?php if(!empty($errors)) {
                        echo '<h6>Ret disse fejl:</h6>';
                        echo '<ul>';
                        foreach ($errors as $error) {
                            echo '<li>'.h($error).'</li>';
                        }
                        echo '</ul>';
                    } ?></p>

            </article>

            <a href="<?php echo url_for('/admin/slet_nyhed.php?id='.$cat['news_id'].'')?>">Slet Nyhed</a>

        </section>

    </main>


<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
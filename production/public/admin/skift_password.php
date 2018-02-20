<?php
require_once ('./../../private/initialize.inc.php');

$side = 'bruger';
$title = 'Theis Nybo Foto - Skift password';

require_once (SHARED_PATH.'/admin_header.inc.php');

if(isset($_GET['id'])) {

    if($_GET['id'] === 'first') {
        $velkommen = 'Første gang du logger ind, skal du vælge et nyt password.';
    } else {
        redirect(url_for('/admin/index.php'));
    }
}

$id = trim(clean_input($db, $_SESSION['admin_id']));
$admin = find_admin_by_id($id);

if (is_post_request()) {

    $old_pass = trim(clean_input($db, $_POST['old_pass']));
    $pass = trim(clean_input($db, $_POST['pass']));
    $pass2 = trim(clean_input($db, $_POST['pass2']));
    $hashed_password = password_hash(trim(clean_input($db, $pass)), PASSWORD_BCRYPT);
    $dato = time();





    if (!is_filled($old_pass)) {
        $errors['old_pass'] = ' - Password skal udfyldes';
    } else if (!password_verify($old_pass, $admin['admin_password'])) {
        $errors['old_pass'] = ' - Password er forkert';
    } else if(!is_filled($pass)) {
        $errors['pass'] = ' - Nyt password skal udfyldes';
    } else if(!min_length($pass, 8)) {
        $errors['pass'] = ' - Nyt password skal mindst 8 tegn';
    } else if(!is_filled($pass2)) {
        $errors['$pass2'] = ' - Password skal gentages';
    } else if($pass !== $pass2) {
        $errors['pass'] = ' - De to password skal være ens';
        $errors['pass2'] = ' - De to password skal være ens';
    }

    if (empty($errors)) {

        $sql = "UPDATE admins SET admin_password ='".$hashed_password."', admin_changed='".$dato."' WHERE admin_id='".$id."' LIMIT 1";

        if(query_sql($sql)) {
            $cls = 'success';
            $msg = 'Password er skiftet.';
        } else {
            $cls = 'error';
            $msg = 'Noget gik galt, prøv igen';
        }
    }


}//Post_request

?>

    <main>
        <section class="login_box">
            <h3 class="space-under">Skift Password</h3>
            <p class="space-under"><?php echo $velkommen ?? ''; ?></p>
            <div class="table-box">

            <div class="opret-box">

                <form name="login" class="login_form" action="" method="post">

                    <div class="form_item">
                        <label for="old_pass" class="formnavn<?php if(isset($errors['old_pass'])) {echo ' error';} ?>">Nuværende password</label><span class="error"><?php echo $errors['old_pass'] ?? ''; ?></span><br>
                        <input type="password" name="old_pass" class="textfelt<?php if(isset($errors['oldmail'])) {echo ' error_border';} ?>" placeholder="Indtast nuværende password">
                    </div>

                    <div class="form_item">
                        <label for="pass" class="formnavn<?php if(isset($errors['pass'])) {echo ' error';} ?>">Nyt password (min. 8 tegn)</label><span class="error"><?php echo $errors['pass'] ?? ''; ?></span><br>
                        <input type="password" name="pass" class="textfelt<?php if(isset($errors['pass'])) {echo ' error_border';} ?>" placeholder="Indtast nyt password">
                    </div>

                    <div class="form_item">
                        <label for="pass2" class="formnavn<?php if(isset($errors['lastname'])) {echo ' error';} ?>">Gentag password</label><span class="error"><?php echo $errors['pass2'] ?? ''; ?></span><br>
                        <input type="password" name="pass2" class="textfelt<?php if(isset($errors['lastname'])) {echo ' error_border';} ?>" placeholder="Indtast nyt password igen">
                    </div>

                    <div>
                        <input type="submit" name="submit" class="loginknap" value="Skift Password">
                    </div>

                    <p class="<?php echo $cls ?? ''?>>"><?php echo $msg ?? ''; ?></p>
                    <p class="error"><?php if(!empty($errors)) {
                            echo '<h6>Ret disse fejl:</h6>';
                            echo '<ul>';
                            foreach ($errors as $error) {
                                echo '<li>'.h($error).'</li>';
                            }
                            echo '</ul>';
                        } ?></p>

                </form>

            </div>
        </section>
    </main>

<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
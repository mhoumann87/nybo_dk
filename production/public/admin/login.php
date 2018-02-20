<?php
require_once ('./../../private/initialize.inc.php');

$page = 'login';
$title = 'Theis Nybo Foto - Login';

require_once (SHARED_PATH.'/admin_header.inc.php');


if(is_post_request()) {

    $email = trim(clean_input($db, $_POST['email']));
    $pass = trim(clean_input($db, $_POST['pass']));

    if (!is_filled($email)) {
        $errors['email'] = ' - Email skal udfyldes';
    }
    else if (!valid_email($email)) {
        $errors['email'] = ' - Dette er ikke en valid email adresse';
    } else if (!is_filled($pass)) {
        $errors['pass'] = ' - Password skal udfyldes';
    }

    if (empty($errors)) {

       $admin =  find_admin_by_email($email);

        if($admin) {
            if(password_verify($pass, $admin['admin_password'])) {

                log_in_admin($admin);

                if($admin['admin_created'] === $admin['admin_changed']) {
                    redirect(url_for('/admin/skift_password.php?id=first'));
                } else {
                    redirect(url_for('/admin/index.php'));
                }

            } else {

                $errors['email'] = ' - Email eller bruger navn er forkert';
                $errors['pass'] = ' - Email eller bruger navn er forkert';
                $email = '';
            }

        } else {
            $errors['email'] = ' - Email eller bruger navn er forkert';
            $errors['pass'] = ' - Email eller bruger navn er forkert';
            $email = '';
        }
    }

}

?>

    <main>



        <section class="login_box">

            <div class="tom-box"></div>
            <form name="login" class="login_form" action="<?php echo url_for('/admin/login.php'); ?>" method="post">
                <h3 class="space-under">Log In</h3>
                <div class="form_item">
                    <label for="email" class="formnavn<?php if(isset($errors['email'])) {echo ' error';} ?>">E-mail</label><span class="error"><?php echo $errors['email'] ?? ''; ?></span><br>
                    <input type="text" name="email" class="textfelt<?php if(isset($errors['email'])) {echo ' error_border';} ?>" placeholder="Indtast din email" value="<?php echo $email ?? ''; ?>">
                </div>

                <div class="form_item">
                    <label for="pass" class="formnavn<?php if(isset($errors['pass'])) {echo ' error';} ?>">Password</label><span class="error"><?php echo $errors['pass'] ?? ''; ?></span><br>
                    <input type="password" name="pass" class="textfelt<?php if(isset($errors['pass'])) {echo ' error_border';} ?>" placeholder="Indtast dit password">
                </div>

                <div class="">
                    <input type="submit" name="submit" class="loginknap" value="Login">
                </div>
                <span class="error"><?php echo $message ?? ''; ?></span>
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
            <div class="tom-box"></div>
        </section>

    </main>



<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
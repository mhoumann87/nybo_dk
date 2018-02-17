<?php
require_once ('./../../private/initialize.inc.php');

$page = 'login';
$title = 'Theis Nybo Foto - Login';

require_once (SHARED_PATH.'/admin_header.inc.php');

$error = [];
$mail_status = '';
$mail_error =  '';
$mail_border = '';
$mail_place = 'Indtast din email';
$pass_status = '';
$pass_error =  '';
$pass_border = '';


if(is_post_request()) {

    $email = $_POST['email'];
    $pass = $_POST['pass'];

    if (!is_filled($email)) {
        $mail_border = 'error_border';
        $mail_status = 'error';
        $mail_error = ' - Email skal udfyldes';
        $error = 1;
    }
    else if (!valid_email($email)) {
        $mail_place = $email;
        $mail_border = 'error_border';
        $mail_status = 'error';
        $mail_error = ' - Dette er ikke en valid email adresse';
        $error = 1;
    } else if (!is_filled($pass)) {
        $mail_place = $email;
        $pass_border = 'error_border';
        $pass_status = 'error';
        $pass_error = ' - Password skal udfyldes';
        $error = 1;
    }

    if (empty($error)) {
        $message = 'ok';
    } else {
        $message = "Ret fejl";
    }

}

?>

    <main>

        <section class="login_box">

            <form name="login" class="login_form" action="<?php echo url_for('/admin/login.php'); ?>" method="post">

                <div class="form_item">
                    <label for="email" class="formnavn <?php echo $mail_status; ?>">E-mail</label><span class="<?php echo $mail_status; ?>"><?php echo $mail_error; ?></span><br>
                    <input type="text" name="email" class="textfelt <?php echo $mail_border; ?>" placeholder="<?php echo $mail_place; ?>">
                </div>

                <div class="form_item">
                    <label for="pass" class="formnavn <?php echo $pass_status; ?>">Password</label><span class="<?php echo $pass_status; ?>"><?php echo $pass_error; ?></span><br>
                    <input type="password" name="pass" class="textfelt <?php echo $pass_border; ?>" placeholder="Indtast dit password">
                </div>

                <div class="">
                    <input type="submit" name="submit" class="loginknap" value="Login">
                </div>
                <span class="error"><?php echo $message ?? ''; ?></span>
            </form>

        </section>

        <?php



        ?>


    </main>



<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
<?php
require_once ('./../../private/initialize.inc.php');

$page = 'login';
$title = 'Theis Nybo Foto - Login';

require_once (SHARED_PATH.'/admin_header.inc.php');

$error = [];
$mail_status = '';
$mail_error =  '';
$mail_border = '';
$pass_status = '';
$pass_error =  '';
$pass_border = '';

?>

    <main>

        <section class="login_box">

            <form name="login" class="login_form" action="./login.php" method="post">

                <div class="form_item">
                    <label for="email" class="formnavn <?php echo $mail_status; ?>">E-mail</label><span class="<?php echo $mail_status; ?>"><?php echo $mail_error; ?></span><br>
                    <input type="email" name="email" class="textfelt <?php echo $mail_border; ?>" placeholder="Indtast din email">
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

        if(is_post_request()) {

                $email = $_POST['email'];
                $pass = $_POST['pass'];

                echo $email . ' ' . $pass;
        }

        ?>


    </main>



<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
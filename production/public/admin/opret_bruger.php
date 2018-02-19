<?php
require_once ('./../../private/initialize.inc.php');

$side = 'bruger';
$title = 'Theis Nybo Foto - Opret bruger';

require_once (SHARED_PATH.'/admin_header.inc.php');

if (is_post_request()) {

    $firstname = trim(clean_input($db, $_POST['firstname']));
    $lastname = trim(clean_input($db, $_POST['lastname']));
    $email = trim(clean_input($db, $_POST['email']));
    $pass = 'Kode1234';
    $hashed_password = password_hash(trim(clean_input($db, $pass)), PASSWORD_BCRYPT);
    $dato = time();





    if (!is_filled($firstname)) {
        $errors['firstname'] = ' - Fornavn skal udfyldes';
    } else if (!only_letters($firstname)) {
        $errors['firstname'] = ' - Fornavn må kun indholde bogstaver';
    } else if(!is_filled($lastname)) {
        $errors['lastname'] = ' - Efternavn skal udfyldes';
    } else if(!only_letters($lastname)) {
        $errors['lastname'] = ' - Efternavn må kun indholde bogstaver';
    } else if(!is_filled($email)) {
        $errors['$email'] = ' - Email skal udfyldes';
    } else if(!valid_email($email)) {
        $errors['email'] = ' - Dette er ikke en valid email';
    } else if (admin_exist($email) !== 0) {
        $errors['email'] = " - Email er allerede i databasen";
    }

    if (empty($errors)) {

        $sql = "INSERT INTO admins ";
        $sql .= "(admin_firstname, admin_lastname, admin_mail, admin_created, admin_changed, admin_password) ";
        $sql .= "VALUES (";
        $sql .= "'".$firstname."',";
        $sql .= "'".$lastname."',";
        $sql .= "'".$email."',";
        $sql .= "'".$dato."',";
        $sql .= "'".$dato."',";
        $sql .= "'".$hashed_password."')";

        if (create_post($sql)) {
            redirect(url_for('/admin/opret_bruger.php'));
        } else {
            $msg = "Der opstod en fejl, prøv igen";
        }

    }


}//Post_request

?>

<main>
    <section class="login_box">
    <h4>Brugere i dataabasen</h4>

    <table class="admin_tabel">

        <tr>
            <th>Fornavn</th>
            <th>Efternavn</th>
            <th>Email</th>
            <th>Skift Password</th>
            <th>Slet Bruger</th>
        </tr>
        <?php

        $admin_set = find_all_admins();

        while($admin = mysqli_fetch_assoc($admin_set)) { ?>
            <tr>
                <td><?php echo h($admin['admin_firstname']); ?></td>
                <td><?php echo h($admin['admin_lastname']); ?></td>
                <td><?php echo h($admin['admin_mail']); ?></td>
                <td><a href="<?php echo url_for('/admin/skift_password.php');?>?id=<?php echo h($admin['admin_id']);?>">Skift Password</a></td>
                <td><a href="<?php echo url_for('/admin/slet_bruger.php');?>?id=<?php echo h($admin['admin_id']);?>">Slet Bruger</a></td>
            </tr>
            <?php }?>
    </table>

    </section>

    <section class="login_box">
        <h4>Opret ny bruger</h4>
        <p class="space-under">Når der oprettes en bruger, vil password automatisk blive sat til Kode1234. Første gang brugeren logger ind, vil vedkommende blive bedt om at ændre det.</p>
        <form name="login" class="login_form" action="" method="post">

        <div class="form_item">
            <label for="firstname" class="formnavn<?php if(isset($errors['firstname'])) {echo ' error';} ?>">Fornavn</label><span class="error"><?php echo $errors['firstname'] ?? ''; ?></span><br>
            <input type="text" name="firstname" class="textfelt<?php if(isset($errors['firstname'])) {echo ' error_border';} ?>" placeholder="Indtast fornavn" value="<?php echo $firstname ?? '';?>">
        </div>

        <div class="form_item">
            <label for="lastname" class="formnavn<?php if(isset($errors['lastname'])) {echo ' error';} ?>">Efternavn</label><span class="error"><?php echo $errors['lastname'] ?? ''; ?></span><br>
            <input type="text" name="lastname" class="textfelt<?php if(isset($errors['lastname'])) {echo ' error_border';} ?>" placeholder="Indtast efternavn" value="<?php echo $lastname ?? '';?>">
        </div>

        <div class="form_item">
            <label for="email" class="formnavn<?php if(isset($errors['lastname'])) {echo ' error';} ?>">Email</label><span class="error"><?php echo $errors['email'] ?? ''; ?></span><br>
            <input type="text" name="email" class="textfelt<?php if(isset($errors['lastname'])) {echo ' error_border';} ?>" placeholder="Indtast email" value="<?php echo $email ?? '';?>">
        </div>

        <div>
            <input type="submit" name="submit" class="loginknap" value="Opret bruger">
        </div>

            <p class="error"><?php echo $msg ?? ''; ?></p>
            <p class="error"><?php if(!empty($errors)) {
                echo '<h6>Ret disse fejl:</h6>';
                echo '<ul>';
                foreach ($errors as $error) {
                    echo '<li>'.h($error).'</li>';
                }
                echo '</ul>';
                } ?></p>


    </form>

    </section>


<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
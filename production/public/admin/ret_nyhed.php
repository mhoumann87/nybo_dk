<?php
require_once ('./../../private/initialize.inc.php');
require_login();

$side = 'nyhed';
$title = 'Theis Nybo Foto - Ret Nyhed';

if(is_get_request()) {

    if(isset($_GET['id'])) {

        $cat = mysqli_fetch_assoc(find_news_by_id(trim(clean_input($db, $_GET['id']))));

        if($cat) {
            var_dump($cat);
        } else {
            echo 'Ikke Fundet';
        }

    } else {
        echo 'bad';
    }


}//is_get_request()

?>

    <main>


    </main>


<?php require_once (SHARED_PATH.'/admin_footer.inc.php'); ?>
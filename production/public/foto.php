<?php
$title = "Theis Nybo Foto - Fotografi";
$side = 'foto';
require_once ('./../private/initialize.inc.php');
require_once('./../private/shared/header.inc.php');
?>

<main>

    <section class="foto-side">

    <aside class="sidebar">

        <?php
if(is_get_request()) {


        if(isset($_GET['id'])) {

            $id = trim(clean_input($db, $_GET['id']));
            $test = category_exists($id);

            if($test !== 0) {

                echo '<nav>';
                echo '<div class="side-nav">';
                echo '<div class="side_nav_item"><a href="' . url_for('/foto.php') . '">Alle Billeder</div>';

            $kategori = find_all_categories();

            while($kat = mysqli_fetch_assoc($kategori)) {

                if($kat['kategori_id'] === $id) {

                    $active =  'class="active"';
                } else {
                    $active = '';
                }

                $sql = "SELECT * FROM billeder WHERE kategori_id = '" . $kat['kategori_id'] . "'";
                $result = mysqli_query($db, $sql);
                if (mysqli_num_rows($result) != '0') {

                    echo '<div class="side_nav_item"><a '.$active.' href="' . url_for('/foto.php?id=') . '' . $kat['kategori_id'] . '">' . h($kat['kategori_navn']) . '</a> </div>';

                }


            }
            echo '</div>';
            echo '</nav>';
            echo '</aside>';

            } else {
                redirect(url_for('/err_404.php/'));
            }

                echo '<section class="fotos">';

$billeder = find_photos_by_category($id);

while($billede = mysqli_fetch_assoc($billeder)) {

    if($billede['billede_width'] > $billede['billede_height']) {
        $photo_class = 'lands';
    } else {
        $photo_class = 'port';
    }

    echo '<article class="fotoside_fotobox">';

    echo '<a href="'.$billede['billede_link'].'" data-lightbox="photo" data-title="'.$billede['billede_titel'].'"><img src="'.$billede['billede_link'].'" class="'.$photo_class.'" alt="'.$billede['billede_titel'].'"></a>';
    //echo '<div class="foto_caption"><h3>'.$billede['billede_titel'].'</h3></div>';

    echo '</article>';
}
   echo '</section>';

        } else {

            echo '<nav>';
            echo '<div class="side-nav">';
            echo '<div class="side_nav_item"><a class="active" href="' . url_for('/foto.php') . '">Alle Billeder</div>';

            $kategori = find_all_categories();

            while ($cat = mysqli_fetch_assoc($kategori)) {

                $sql = "SELECT * FROM billeder WHERE kategori_id = '" . $cat['kategori_id'] . "'";
                $result = mysqli_query($db, $sql);
                if (mysqli_num_rows($result) != '0') {

                    echo '<div class="side_nav_item"><a href="' . url_for('/foto.php?id=') . '' . $cat['kategori_id'] . '">' . h($cat['kategori_navn']) . '</a> </div>';

                }
            }

            echo '</div>';
            echo '</nav>';

    echo '</aside>';

    echo '<section class="fotos">';

$billeder = find_all_photos();

while($billede = mysqli_fetch_assoc($billeder)) {

    if($billede['billede_width'] > $billede['billede_height']) {
        $photo_class = 'lands';
    } else {
        $photo_class = 'port';
    }

    echo '<article class="fotoside_fotobox">';

    echo '<a href="'.$billede['billede_link'].'" data-lightbox="all"><img src="'.$billede['billede_link'].'" class="'.$photo_class.'" alt="'.$billede['billede_titel'].'"></a>';


    echo '</article>';
}



   echo '</section>';

        }

        } else {
    redirect(url_for('/err_404.php/'));
}
        ?>

    </section>



</main>


<?php

require_once('./../private/shared/footer.inc.php')

?>
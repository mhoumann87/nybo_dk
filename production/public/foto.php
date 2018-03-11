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

        if(isset($_POST['id'])) {



        } else {

            echo '<nav>';
            echo '<div class="side-nav">';
            echo '<div class="side_nav_item"><a class="active" href="' . url_for('/foto.php/') . '">Alle Billeder</div>';

            $kategori = find_all_categories();

            while ($cat = mysqli_fetch_assoc($kategori)) {

                $sql = "SELECT * FROM billeder WHERE kategori_id = '" . $cat['kategori_id'] . "'";
                $result = mysqli_query($db, $sql);
                if (mysqli_num_rows($result) != '0') {

                    echo '<div class="side_nav_item"><a href="' . url_for('/foto.php?id=/') . '' . $cat['kategori_id'] . '">' . h($cat['kategori_navn']) . '</a> </div>';

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

    echo '<div class="foto_fill"><img src="'.$billede['billede_link'].'" class="'.$photo_class.'" alt="'.$billede['billede_titel'].'"></div>';
    echo '<div class="foto_caption"><h3>'.$billede['billede_titel'].'</h3></div>';

    echo '</article>';
}



   echo '</section>';

        }
        ?>

    </section>



</main>


<?php

require_once('./../private/shared/footer.inc.php')

?>
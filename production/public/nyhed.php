<?php
$title = "Theis Nybo Foto - Nyhed";
$side = 'nyheder';
require_once ('./../private/initialize.inc.php');
require_once('./../private/shared/header.inc.php');
?>

    <main>

        <section class="onenews-side">

            <aside class="sidebar">

                <?php
                if(is_get_request()) {


                    if (isset($_GET['id'])) {

                        $id = trim(clean_input($db, $_GET['id']));
                        $test = newskat_exists($id);

                        if ($test !== 0) {

                            echo '<nav>';
                            echo '<div class="side-nav">';
                            echo '<div class="side_nav_item"><a href="' . url_for('/nyheder.php/') . '">Alle Nyheder</div>';

                            $kategori = find_all_news_categories();

                            while ($kat = mysqli_fetch_assoc($kategori)) {

                                if ($kat['newskat_id'] === $id) {

                                    $active = 'class="active"';
                                } else {
                                    $active = '';
                                }

                                $sql = "SELECT * FROM news WHERE newskat_id = '" . $kat['newskat_id'] . "'";
                                $result = mysqli_query($db, $sql);
                                if (mysqli_num_rows($result) != '0') {

                                    echo '<div class="side_nav_item"><a ' . $active . ' href="' . url_for('/nyheder.php?id=') . '' . $kat['newskat_id'] . '">' . h($kat['newskat_navn']) . '</a> </div>';

                                }

                            }
                            echo '</div>';
                            echo '</nav>';
                            echo '</aside>';

                        } else {
                            redirect(url_for('/err_404.php/'));
                        }

                        echo '<section class="one_news">';

                        $news_array = find_news_by_id(trim(clean_input($db, $_GET['newsid'])));
                        $news = mysqli_fetch_assoc($news_array);
                        if(news_exists(trim(clean_input($db, $_GET['newsid'])))) {

                            $foto = find_newsImg_by_id(trim(clean_input($db, $news['newsImg_id'])));
                            $foto = mysqli_fetch_assoc($foto);

                            if($foto['newsImg_width'] > $foto['newsImg_height']) {

                            $photo_class = 'news-lands';
                            } else {
                                $photo_class = 'port';
                            }

                            $cat = mysqli_fetch_assoc(find_news_cat_by_id($news['newskat_id']));

                            echo '<div class="stor_nyhed">';

                               echo '<img src="'.$foto['newsImg_link'].'" class="'.$photo_class.'" alt="Billede for '.h($news['news_overskrift']).'">';

                            echo '<div class="overskrift">';
                            echo '<h3>'.h($news['news_overskrift']).'</h3>';
                            echo '</div>';

                            echo '<div class="news_subline">';
                            echo '<p class="small">Kategori: <a href="'.url_for('/nyheder.php?id=').''.$cat['newskat_id'].'"> '.h($cat['newskat_navn']).'</a></p>';
                            echo '<p class="small">Uploaded: '.h($news['news_dato']).'</p>';
                            echo '</div>';

                            echo '<p>'.$news['news_text'].'</p>';

                            echo '</div>';

                        } else {
                            redirect(url_for('/nyheder.php/'));
                        }






//                        while($news = mysqli_fetch_assoc($nyhed)) {
//
//
//
//
//                            echo '</article>';
//                        }
//                        echo '</section>';
//
//                    } else {
//                        redirect(url_for('/err_404.php/'));
//                    }

                    } else {
                        redirect(url_for('/err_404.php/'));
                    }
                }
                ?>

        </section>

    </main>


<?php

require_once('./../private/shared/footer.inc.php')

?>
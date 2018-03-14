<?php
$title = "Theis Nybo Foto - Forside";
$side = 'index';
require_once ('./../private/initialize.inc.php');
require_once('./../private/shared/header.inc.php');
?>

<main>



    <section class="forside">

        <section class="front-foto">

            <?php

            $sql = "SELECT * FROM billeder ORDER BY billede_upload DESC LIMIT 8";
            $result = mysqli_query($db, $sql);
            confirm_result_set($result);

            while($photo = mysqli_fetch_assoc($result)) {

                $kategori = find_category_by_id(trim(clean_input($db, $photo['kategori_id'])));
                $cat = $kategori['kategori_navn'];

                if($photo['billede_width'] < $photo['billede_height']) {
                    $photo_class = 'port';
                } else {
                    $photo_class = 'lands';
                }


                ?>
                <article class="photo-card">

                    <img src="<?php echo $photo['billede_link'] ?? '';?>" class="space-under <?php echo $photo_class ?? '';?>" alt="<?php echo $photo['photo_title'] ?? '';?>">
                    <h3 class="space-under"><?php echo h($photo['billede_titel']) ?? '';?></h3>
                    <p>Kategori : <a href="<?php echo url_for('/foto.php?id='.$photo['kategori_id'].'');?>"><?php echo $cat ?? ''; ?></a></p>

                </article>

                <?php
            }
            ?>

        </section>

        <section class="front-news">

            <?php

            $sql = "SELECT * FROM news ORDER BY news_time DESC LIMIT 4";
            $result = mysqli_query($db, $sql);
            confirm_result_set($result);

            while($news = mysqli_fetch_assoc($result) ) {

                $kategori = mysqli_fetch_assoc(find_news_cat_by_id(trim(clean_input($db, $news['newskat_id']))));
                $kat = $kategori['newskat_navn'];

                $photos = mysqli_fetch_assoc(find_newsImg_by_id(trim(clean_input($db, $news['newsImg_id']))));
                $photo = $photos['newsImg_link'];

                if($photos['newsImg_width'] < $photos['newsImg_height']) {
                    $photo_class = 'port';
                } else {
                    $photo_class = 'lands';
                }
                ?>

                <article class="news-card">

                    <div class="top">
                        <div class="front_newsfoto_box">
                            <img src="<?php echo $photo ?? ''; ?>" class="front_newsfoto <?php echo $photo_class ?? ''; ?>" alt="<?php echo $news['news_overskrift'] ?? ''; ?>">
                        </div>

                        <div class="front_newsbox">
                            <h4 class="headline"><?php echo $news['news_overskrift'] ?? ''; ?></h4>
                            <div class="news_info">
                                <h6>Uploaded <?php echo $news['news_dato'] ?? ''; ?></h6>
                                <h6>Kategori <a href="<?php echo url_for('/nyheder.php?id='.$kategori['newskat_id'].'');?>"><?php echo $kat ?? ''; ?></a></h6>
                            </div>
                        </div>

                    </div>
                    <div class="front_news_content">

                        <p><?php echo substr($news['news_text'], 0 , 150); ?>... <a href="<?php echo url_for('/nyhed.php?id='.$kategori['newskat_id'].'&newsid='.$news['news_id'].'') ;?>">Læs mere</a> </P>
                    </div>

                </article>

                <?php
            }
            mysqli_free_result($result);
            ?>


        </section>

        <aside class="about">

            <div class="af-box">
                <img src="<?php echo url_for('/images/theis_placeholder.jpg'); ?>" class="about-foto" alt="Theis Nybo">
            </div>

            <div class="about-headline">
                <h4>Theis Nybo</h4>
            </div>

            <div class="about-content">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    Ab ipsam iusto laborum, officiis soluta unde voluptas voluptate?
                    A amet cum, distinctio facilis iusto nemo neque, perspiciatis quaerat, quas quasi unde!</p>
            </div>
        </aside>

    </section>

</main>


<?php

require_once('./../private/shared/footer.inc.php')

?>

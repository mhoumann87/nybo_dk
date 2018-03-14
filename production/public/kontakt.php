<?php
$title = "Theis Nybo Foto - Kontakt";
$side = 'kontakt';
require_once ('./../private/initialize.inc.php');
require_once('./../private/shared/header.inc.php');
?>

<main>

    <div class="kontakt-side">

        <div class="kontakt-box">

        <h3>Send mig en besked</h3>

        <section id="meddelse-fra-form" class="meddelse">

            <div class="kontakt_form">
                <div class="form_item">
                    <label for="navn" class="formnavn">Navn:&nbsp;;</label><span id="navn-info"></span><br>
                    <input type="text" id="navn" name="navn" placeholder="Indtast dit navn" class="textfelt">
                </div>
                <div class="form_item">
                    <label for="email" class="formnavn">E-mail:&nbsp;</label><span id="email-info"></span><br>
                    <input type="email" id="email" name="email" placeholder="Indtast din email" class="textfelt">
                </div>
                <div class="form_item vis-ikke">
                    <label for="website" class="formnavn">Website:&nbsp;</label><span id="website"></span><br>
                    <input type="url" id="website" name="website" placeholder="Spamkontrol, skal efterlades tom" class="textfelt">
                </div>
                <div class="form_item">
                    <label for="besked" class="formnavn">Besked:&nbsp;</label><span id="besked"></span>
                    <textarea id="besked" name="besked" placeholder="Indtast din besked" class="textboks"></textarea><br/>
                </div>
                <div class="form_item">
                    <button name="submit" class="sendknap" id="sendKontakt">Send din besked</button>
                </div>

            </div>

        </section>

        </div>

        <div class="con_about">

            <h3>Kontakt mig:</h3>
<div class="flex-con">
        <section class="kontakt_info">

            <div class="adr">
                <p>Theis Nybo</p>
                <p>Adresse (hvis ønskes)</p>
                <p>Post Nummer og By</p>
            </div>

            <div class="adr">
                <p>Send mig en mail (åbner dit mail program): <a href="mailto:theis@domæne.dk">theis@domæne.dk</a></p>
                <br><br>
                <p>Ring til mig (Hvis du er på mobilen, ringes der automatisk op når du trykker på linket): <a href="tel:88776655">88776655</a> </p>
            </div>

        </section>

        <div class="con-about">

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

        </div>
</div>


        </div>

        <div class="soc">
        <h3>Sociale medier:</h3>

        <section class="kontakt-soc">

            <div class="kontakt-icon">
                <a href="https://www.facebook.com/TheisNyboPhotography" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
            </div>

            <div class="kontakt-icon">
                <a href="https://www.instagram.com/theisnybo/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            </div>

            <div class="kontakt-icon">
                <a href="https://dk.linkedin.com/in/theis-nybo-8167033b" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
            </div>

            <div class="kontakt-icon">
                <a href="https://www.snapchat.com" target="_blank"><i class="fa fa-snapchat" aria-hidden="true"></i></a>
            </div>

        </section>

        </div>

    </div>


</main>


<?php

require_once('./../private/shared/footer.inc.php')

?>
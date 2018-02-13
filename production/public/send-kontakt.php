<?php

$sendTil =  "admin@michael-h.dk";
$subject = "Henvendelse fra  hjemmesiden.";
$besked = htmlspecialchars($_POST['besked']);


$headers = "From: " .$_POST['navn']."<".strip_tags($_POST['email']) . ">\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=utf-8\r\n";

$message = '<html><body>';
$message .= '<h1>'.$subject.'</h1>';
$message .='<p>Der er kommet en henvendelse fra '.$_POST["navn"].' der skriver:</p>';
$message .='<div style="border:1px solid #1a1a1a; padding:10px; margin-top:20px; margin-bottom:20px; margin-left:20px;">'.$besked.'</div>';

$message .='<p>'.$_POST["navn"].' kan kontaktes på email: <a href="mailto:'.$_POST["email"].'">'.$_POST["email"].'</a></p>';
$message .= '</body></html>';

if(mail($sendTil, $subject, $message, $headers)) {
    print "<p class='success'>Din besked er blevet afsendt,<br/>vi vender hurtigt tilbage.</p>";
} else {
    print "<p class='error'>Der opstod et problem ved afsendelse af beskeden.</p>";
}


?>
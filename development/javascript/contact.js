var $ = require('jquery');

$("#sendKontakt").click(function sendKontakt() {

    console.log('Clicked');

    var valid;
    valid = validateContact();
    if(valid) {
        jQuery.ajax({
            url: "send-kontakt.php",
            data:'navn='+$("#navn").val()
            +'&email='+$("#email").val()
            +'&swebsite='+$("#website").val()
            +'&besked='+$("#besked").val(),
            type: "POST",
            success:function(data){
                $("#meddelse-fra-form").html(data);
            },
            error:function (){}
        });
    }
});

function validateContact() {
    var valid = true;
    $(".textfelt").css('background-color','');
    $(".info").html('');

    if(!$("#navn").val()) {
        $("#navn-info").html("(Skal indtastes)");
        $("#navn").css('background-color','#FFFFDF');
        valid = false;
    }
    if(!$("#email").val()) {
        $("#email-info").html(" (Skal indtastes)");
        $("#email").css('background-color','#FFFFDF');
        valid = false;
    }
    if(!$("#email").val().match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
        $("#email-info").html(" (Ikke gyldig)");
        $("#email").css('background-color','#FFFFDF');
        valid = false;
    }
    if($("#website").val()) {
        $("#web-info").html(" (Skal være tom)");
        $("#website").css('background-color','#FFFFDF');
        valid = false;
    }
    if(!$("#besked").val()) {
        $("#besked-info").html(" (Skal udfyldes)");
        $("#besked").css('background-color','#FFFFDF');
        valid = false;
    }

    return valid;
}


$(document).ready( function() {
    $(".tempalert").fadeTo(2000, 500).slideUp(500, function(){
        $(".tempalert").slideUp(500);
    });

    $( "#share" ).change(function() {
        $( "#savemessage" ).html("Opslaan vereist");
    });
});
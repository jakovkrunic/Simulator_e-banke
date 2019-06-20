$(document).ready(function (){

    $('#oib').on("keyup", function(){

        var OibValue = $("#oib").val();

        if(OibValue.length !== 11) $("#OIBerror").html("<span style='color:red;'>OIB se mora sastojati od točno 11 znakova!</span>");
        else $("#OIBerror").html('');

    });
});

$(document).ready(function (){

    function dodajValute (){
           console.log($("#odabirRacuna").val());
           JSON.stringify($("#odabirRacuna").val());
            var opcije =
                "<option value='AUD'>AUD</option>"
                + "<option value='BAM'>BAM</option>"
                + "<option value='CAD'>CAD</option>"
                + "<option value='CHF'>CHF</option>"
                + "<option value='DKK'>DKK</option>"
                + "<option value='EUR'>EUR</option>"
                + "<option value='GBP'>GBP</option>"
                + "<option value='JPY'>JPY</option>"
                + "<option value='NOK'>NOK</option>"
                + "<option value='RSD'>RSD</option>"
                + "<option value='SEK'>SEK</option>"
                + "<option value='USD'>USD</option>";

            $("#valutaRacuna").html(opcije);

        $("#minus").html($("#raspon").val() + " " + $("#valutaRacuna").val());
    }

    dodajValute();

    $("#odabirRacuna").on('change', dodajValute);

    //$("#raspon").on('change', function(){
    //    $("#minus").html($("#raspon").val() + " " + $("#valutaRacuna").val());
    //});

    //$("#minus").html($("#raspon").val() + " " + $("#valutaRacuna").val());

    //$("#valutaRacuna").on('change', function(){

    //    $("#minus").html($("#raspon").val() + " " + $("#valutaRacuna").val());
    //});
});

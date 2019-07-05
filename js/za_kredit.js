$(document).ready(function (){

    $("#iznos").val('100000');
    $("#kamatna_stopa").val('0.05');
    $("#godine").val('10');

    function racunajRatu (){
        var iznos = Number($("#iznos").val());
        var kamatna_stopa = Number($("#kamatna_stopa").val());
        var godine = Number($("#godine").val());
        
        //k=g⋅s⋅v
        kamate = godine * iznos * kamatna_stopa;
        $("#ukupne_kamate").html("Ukupni iznos kamata za uneseno vrijeme u godinama, iznos i kamatnu stopu: " + kamate + " " + $("#valutaRacuna").val());

        var ukupni_iznos = kamate + iznos;

        $("#ukupni_iznos").html("Ukupni iznos kredita za uneseno vrijeme u godinama, iznos i kamatnu stopu: " + ukupni_iznos + " " + $("#valutaRacuna").val());
        var rata = ukupni_iznos/(12*godine);

        $("#rata").val(rata);
    }

    racunajRatu();

    $("#iznos").on('change', racunajRatu);
    $("#kamatna_stopa").on('change', racunajRatu);
    $("#godine").on('change', racunajRatu);


    
});
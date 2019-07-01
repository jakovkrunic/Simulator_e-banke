$(document).ready(function (){
  $("#TiC").change(function() {

    if(this.checked) {
    $("#klik").prop("disabled",false).css('opacity',1);;
    }
    else{
    $("#klik").prop("disabled",true).css('opacity',0.5);;
    }
});
});

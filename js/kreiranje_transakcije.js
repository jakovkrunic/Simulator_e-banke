
$(document).ready(function (){

      $("#iznos").on("input",function(){
        check();
      }
      );

      $("#primatelj").on("input",function(){
        check();
      }
      );
});

function check(){
  if( $("#primatelj").val()>=0 && $("#iznos").val()>=0){
    $("#klik").prop("disabled",false).css('opacity',1);
  }
  else{
  $("#klik").prop("disabled",true).css('opacity',0.5);
  }
}

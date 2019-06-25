$(document).ready(function ()
{
  $(".brisanje").on("click",function()
  {
    var odg = confirm("Jeste li sigurni da želite obrisati predložak?");
    if(!odg)
      return false;
  });


});

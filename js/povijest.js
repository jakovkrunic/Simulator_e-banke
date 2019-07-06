var update = function() {

  var trs = tablica_povijesti.getElementsByTagName("tr");
  for (var i = 1; i < trs.length;) tablica_povijesti.removeChild(trs[i]);

  var var_vrsta_transakcije = vrsta_transakcije.options[vrsta_transakcije.selectedIndex].value;

  var var_od_dan = od_dan.options[od_dan.selectedIndex].value;
  var var_od_mjesec = od_mjesec.options[od_mjesec.selectedIndex].value;
  var var_od_godina = od_godina.options[od_godina.selectedIndex].value;

  var var_do_dan = do_dan.options[do_dan.selectedIndex].value;
  var var_do_mjesec = do_mjesec.options[do_mjesec.selectedIndex].value;
  var var_do_godina = do_godina.options[do_godina.selectedIndex].value;

  var _od = var_od_godina + "-" + var_od_mjesec + "-" + var_od_dan;
  var _do = var_do_godina + "-" + var_do_mjesec + "-" + var_do_dan;

  //console.log(var_vrsta_transakcije, _od, _do);

  if (var_vrsta_transakcije === "poslane") {
    var ths = header_povijesti.getElementsByTagName("th");
    var found = false;
    for (var i = 0; i < ths.length && !found; ++i) {
      if (ths[i].innerHTML === "Poništi") found = true;
    }
    if (!found) {
      var el = document.createElement("th");
      el.innerHTML = "Poništi";
      header_povijesti.appendChild(el);
    }
  }

  if (var_vrsta_transakcije === "primljene") {
    var ths = header_povijesti.getElementsByTagName("th");
    var found = false;
    for (var i = 0; i < ths.length && !found; ++i) {
      if (ths[i].innerHTML === "Poništi") {
        found = true;
        header_povijesti.removeChild(ths[i]);
      }
    }
  }
  var url = window.location.href;
  url = url.replace("index.php?rt=transaction/save", "");
  url = url.replace("index.php?rt=transaction/undo", "");
  url = url.replace("index.php?rt=transaction", "");
  $.get(
    url + "/js/povijest.php",
    {
      vrsta: var_vrsta_transakcije,
      od: _od,
      do: _do
    },

    function(data, status) {
      console.log(data);
      console.log(status);
      if (status === "success") {
        for (var d in data) {
          var row = data[d];
          // Opis je 1. element (krecemo od 0.!)
          var td1 = document.createElement("td");
          td1.innerHTML = row[1];

          // Pošiljatelj je 2. element
          var td2 = document.createElement("td");
          td2.innerHTML = row[2];

          // Primatelj je 3. element
          var td3 = document.createElement("td");
          td3.innerHTML = row[3];

          // Iznos je 5. element
          var td4 = document.createElement("td");
          td4.innerHTML = row[5];

          // Valuta je 4. element
          var td5 = document.createElement("td");
          td5.innerHTML = row[4];

          // Status je 6. element; ovdje radimo switch
          var td6 = document.createElement("td");
          var str;
          switch(row[6]) {
            case "1": str = "Approved"; break;
            case "0": str = "Pending"; break;
            case "-1": str = "Denied"; break;
          }
          td6.innerHTML = str;

          // Datum je 7. element
          var td7 = document.createElement("td");
          td7.innerHTML = row[7];

          var new_tr = document.createElement("tr");
          new_tr.appendChild(td1);
          new_tr.appendChild(td2);
          new_tr.appendChild(td3);
          new_tr.appendChild(td4);
          new_tr.appendChild(td5);
          new_tr.appendChild(td6);
          new_tr.appendChild(td7);

          if (var_vrsta_transakcije === "poslane" && row[6] === "0") {
            var new_td = document.createElement("td");
            var str = '<form style = "text-align: center" method="post" action="' + url + 'index.php?rt=transaction/undo">'
                 + '<input type="hidden" name="ponisti" value="' + row[0] + '">'
                 + '<button class="button" type="submit">Poništi</button>'
                 + '</form>';

            new_td.innerHTML = str;
            new_tr.appendChild(new_td);
          }

          tablica_povijesti.appendChild(new_tr);
        }
      }

      else {
      }
    }
  );
}

$(document).ready( function() {

  var tablica_povijesti = document.getElementById("tablica_povijesti");
  var header_povijesti = document.getElementById("header_povijesti");
  var vrsta_transakcije = document.getElementById("vrsta_transakcije");

  var od_dan = document.getElementById("od_dan");
  var od_mjesec = document.getElementById("od_mjesec");
  var od_godina = document.getElementById("od_godina");

  var do_dan = document.getElementById("do_dan");
  var do_mjesec = document.getElementById("do_mjesec");
  var do_godina = document.getElementById("do_godina");

  vrsta_transakcije.addEventListener("change", update, false);

  od_dan.addEventListener("change", update, false);
  od_mjesec.addEventListener("change", update, false);
  od_godina.addEventListener("change", update, false);

  do_dan.addEventListener("change", update, false);
  do_mjesec.addEventListener("change", update, false);
  do_godina.addEventListener("change", update, false);

  update();
});

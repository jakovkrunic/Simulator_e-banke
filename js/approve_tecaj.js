function getTecaj(valuta1, valuta2) {
  $.get(
  "https://api.exchangeratesapi.io/latest",
  {
    base: valuta1
  },
  function(data, status) {
    if (status === "success") {
      var found = false;

      for (var key in data.rates) {
        if (found) break;
        if (key == valuta2) {
          found = true;
          tecaj = data.rates[key];
        }
      }

      var expires;
      var date = new Date();
      date.setTime(date.getTime() + 24 * 60 * 60 * 1000);
      expires = "; expires=" + date.toGMTString();
      document.cookie = escape("tecaj") + "=" + escape(tecaj) + expires + "; path=/";
    }

    else {

    }
  }
  )
}

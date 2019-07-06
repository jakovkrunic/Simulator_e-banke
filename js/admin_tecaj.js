$.get(
"https://api.exchangeratesapi.io/latest",
{
  base: "HRK"
},
function(data, status) {
  if (status === "success") {
    var table_exchange = document.getElementById("table_exchange");
  for (var key in data.rates) {
    if (data.rates.hasOwnProperty(key)) {
      //if (key == "HRK") continue;

      var expires;
      var date = new Date();
      date.setTime(date.getTime() + 24 * 60 * 60 * 1000);
      expires = "; expires=" + date.toGMTString();
      document.cookie = escape(String(key)) + "=" + String(data.rates[key]) + expires + "; path=/";
  }
  }
  }

  else {

  }
}
);

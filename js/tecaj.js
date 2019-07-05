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
      if (key == "HRK") continue;
      var tr = document.createElement("tr");
      var th = document.createElement("th");
      th.innerHTML = key;
      th.style.border = "1px solid black";

      var td1 = document.createElement("td");
      td1.innerHTML = data.rates[key];
      td1.style.border = "1px solid black";

      var td2 = document.createElement("td");
      td2.innerHTML = 1 / parseFloat(data.rates[key]);
      td2.style.border = "1px solid black";

      tr.appendChild(th);
      tr.appendChild(td1);
      tr.appendChild(td2);

      table_exchange.appendChild(tr);
  }
  }
  }

  else {

  }
}
)

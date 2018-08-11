//config somente numeros em textbox
$(".numeric").numeric();
$(".integer").numeric(false, function() { alert("Somente numeros inteiros."); this.value = ""; this.focus(); });
$(".positive").numeric({ negative: false }, function() { alert("Sem valor negativo."); this.value = ""; this.focus(); });
$(".positive-integer").numeric({ decimal: false, negative: false }, function() { alert("Somente números inteiros positivos"); this.value = ""; this.focus(); });
$(".decimal-2-places").numeric({ decimalPlaces: 2 });
$('.moeda').numeric({ negative : false, decimalPlaces : 2 });
$('.numIntPositivo').numeric({ decimal: false, negative: false });
$('.numPositivo').numeric({ decimal: '.', negative: false });

/** @example  $(".numeric").numeric(","); // use , as separator
* @example  $(".numeric").numeric({ decimal : "," }); // use , as separator
* @example  $(".numeric").numeric({ negative : false }); // do not allow negative values
* @example  $(".numeric").numeric({ decimalPlaces : 2 }); // only allow 2 decimal places
* @example  $(".numeric").numeric(null, callback); // use default values, pass on the 'callback' function
*/
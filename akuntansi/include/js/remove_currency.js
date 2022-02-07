// JavaScript Document
function remove_currency(nilai){
	//var nil   = nilai.replace(',','');
	var nil   = nilai.replace(/,/g,'');
	var nilaix  = nil.split('.'); 
	return nilaix[0];
}
function remove_currency_koma(nilai){
	//var nil   = nilai.replace(',','');
	var nil   = nilai.replace(/,/g,'');
	var nil  = nil*1;
	return nil;
}

function currency(n) {
    return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}
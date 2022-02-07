window.onload = init;
function init() {
	getStrTime();
	getToday();
}

function getStrTime() {
	var datetime = new Date();
	var ele = document.getElementById("strTime");
	var strTime = datetime.toString().split(" ");
	strTime = strTime[4];
	ele.value = strTime;
}

function getToday() {
	var datetime = new Date();
	var month = datetime.getMonth() + 1;
	var elem = document.getElementById("today");
	var today = datetime.getFullYear().toString() + "/" + month.toString() + "/" + datetime.getDate().toString();
	elem.value = today;
}

function validateForm() {
	var a = document.getElementById("username").value;
	var b = document.getElementById("password").value;
	
	if(a == null || b == ""){
		alert ("Masukkan username dan password dengan benar");
		return false;
	}
}
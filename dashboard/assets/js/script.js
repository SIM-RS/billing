var containerPage = document.getElementById("loadPage");
function loadDoc(url){
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET",url,true);
    xhttp.onload = function(){
        console.log(xhttp.response);
    }
    xhttp.send();
}
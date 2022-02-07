<html>
<head>
<title>
click target/srcElement
</title>
<script type="text/javascript">
if (document.layers) {
  document.captureEvents(Event.MOUSEUP);
  document.onmouseup = clickHandler;
}
else if (document.attachEvent) {
  document.attachEvent('onclick', clickHandler);
}
else if (document.addEventListener) {
  document.addEventListener('click', clickHandler, false);
}
else 
  document.onclick = clickHandler;

function clickHandler (evt) {
  if (document.layers)
    alert(evt.target + ': ' + evt.target.constructor + ': ' + 
evt.target.id);
  else if (window.event && window.event.srcElement)
    alert(window.event.srcElement + ': ' + 
window.event.srcElement.tagName + ': ' + window.event.srcElement.id);
  else if (evt && evt.stopPropagation && !window.opera) {
    if (evt.target.nodeType == 1)
      alert(evt.target + ': ' + evt.target.nodeName + ': ' + 
evt.target.id);
    else 
      alert(evt.target.parentNode + ': ' + 
evt.target.parentNode.nodeName + ': ' + evt.target.parentNode.id)
  }
  else if (window.opera && evt)
    alert(evt.target + ': ' + evt.target.tagName + ': ' + 
evt.target.id);
}
</script>
<style type="text/css">
#layer0 {
  position: absolute;
  z-index: 5;
  left: 100px; top: 200px;
  width: 100px; height: 100px;
  clip: rect(0 100px 100px 0);
  background-color: lightblue;
  layer-background-color: lightblue;
}
#layer1 {
  position: absolute;
  z-index: 1;
  left: 150px; top: 200px;
  width: 100px; height: 100px;
  clip: rect(0 100px 100px 0);
  background-color: lightyellow;
  layer-background-color: lightyellow;
}
</style>
</head>
<body>
<p id="p0">
Kibology for all.<img src="kiboInside.gif" alt="Kibo inside" 
id="img0" />
<a href="http://www.kibo.com/" target="_blank">Visit GOD</a>
</p>
<div id="layer0">Kibology</div>
<div id="layer1">Kibology</div>
</body>
</html>
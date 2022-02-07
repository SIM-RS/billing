<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Tab-View Sample</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" type="text/css" href="theme/tab-view.css" />
<script type="text/javascript" src="theme/js/tab-view.js"></script>
</head>
<body>
<?php $id = isset($_GET['id']) ? $_GET['id'] : 1; ?>
<br>
<div class="TabView" id="TabView" style="width: 850px; height: 500px;"></div>
<!--input type="button" value="Tes" onclick="alert(document.getElementById('page_TabView_0').innerHTML);" /-->
</body>
<script>
var mTab=new TabView("TabView");
mTab.setTabCaption("Umum,Jamkesmas,Askes");
mTab.setTabCaptionWidth("90,130,90");
mTab.setTabPage("page1.php,page2.php,page3.php");
//tabview_width("TabView","60,90,60");
</script>
</html>
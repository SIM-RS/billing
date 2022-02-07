<!DOCTYPE html>
<html>
<head>
<title>Manajemen Asuhan Kebidanan</title>
<link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
<style>
body {
	padding: 10px;
}
</style>
</head>
<body>
<ul class="nav nav-tabs" id="tabs">
	<li class="active"><a href="#tab1" data-toggle="tab">ANAMNESA (DATA SUBYEKTIF)</a></li>
	<li><a href="#tab2" data-toggle="tab">PEMERIKSAAN FISIK / UMUM (DATA OBYEKTIF)</a></li>
	<li><a href="#tab3" data-toggle="tab">PEMERIKSAAN PENUNJANG</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="tab1"><?php include('tab1.php'); ?></div>
	<div class="tab-pane" id="tab2"><?php include('tab2.php'); ?></div>
	<div class="tab-pane" id="tab3"><?php include('tab3.php'); ?></div>
</div>

<script src="assets/js/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script>
$(function(){
	$('#tabs a').click(function(e) {
		e.preventDefault();
		$(this).tab('show');
	})
});
</script>
</body>
</html>
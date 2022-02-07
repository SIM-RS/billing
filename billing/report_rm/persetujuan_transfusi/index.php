<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="Author" content="Sinra" />
	<meta name="Copyright" content="&copy; 2013 Sinra" />
	<link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
	<style type="text/css">
		<!--
			body{
				background:#fff;
				font-family:Tahoma;
			}
			#persetujuan_transfusi input[type="radio"] + label{
				cursor:pointer;
			}
			#persetujuan_transfusi input[type="text"]{
				width:300px;
			}
			#persetujuan_transfusi input[type="button"]{
				cursor:pointer;
			}
		-->
	</style>
	<title>Persetujuan Transfusi</title>
</head>
<body>
	<table width=800 align=center cellspacing=5 cellpadding=0 style='border:.5pt solid windowtext;'>
		<tr>
			<td style='font-size:16px; text-align:center; font-weight:bold; text-decoration:underline;'>Form Persetujuan Transfusi</td>
		</tr>
		<tr>
			<td><? include 'form.php'; ?></td>
		</tr>
		<tr>
			<td align=center>
				<div id="gridbox" style="width:750px; height:230px; background-color:white; overflow:hidden;"></div>
				<div id="paging" style="width:750px;"></div>
			</td>
		</tr>
	</table>
</body>
<script type="text/JavaScript" language="JavaScript" src="javascript.js"></script>
</html>
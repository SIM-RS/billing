<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-Equiv="Cache-Control" Content="no-cache">
    <meta http-Equiv="Pragma" Content="no-cache">
    <meta http-Equiv="Expires" Content="0">
	<meta name="Author" content="Sinra" />
	<meta name="Copyright" content="&copy; 2013 Sinra" />
	<link type="text/css" rel="stylesheet" href="style.css" />
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
	<!--script type="text/JavaScript" language="JavaScript" src="../../include/jquery/iframeheight.min.js"></script-->
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/dynatree/jquery-ui.custom.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/dynatree/jquery.cookie.js"></script>	
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/dynatree/jquery.dynatree.js"></script>
	<link type="text/css" rel="stylesheet" href="../../include/jquery/dynatree/skin-vista/ui.dynatree.css" />
	<title>Tindakan LAB</title>
	<? 
		$date_now = gmdate('d-m-Y',mktime(date('H')+7)); 
		if($_REQUEST['view'] == "tidak"){
			if($_REQUEST['tmpLayLab'] == 58){			
				include 'data.php';
			}
		}
	?>
</head>
<body>
	<form id="tindakanLab" action="action.php" type="post">
		<table align=center cellspacing=5 cellpadding=0 style='border:.5pt solid windowtext; width:100%; height:auto; overflow:hidden;'>
			<tr>
				<td style='font-size:16px; text-align:center; font-weight:bold; text-decoration:underline;'>List Pemeriksaan LAB</td>
			</tr>
			<tr>
				<td>
					<div id="treeTindakanLab"></div>
				<? if($_REQUEST['view'] == "tidak"){
					 if($_REQUEST['tmpLayLab'] == 58){
				?>
					<center>
						<input type="hidden" id="key" name="key" />
						<input type="button" value="<?=($_REQUEST['idPel'] == 0)?'Simpan':'Update'?>" onClick="simpan()" />
						<input type="hidden" id="act" name="act" value="<?=($_REQUEST['idPel'] == 0)?'save':'edit'?>" />
						<input type="hidden" id="idPel" name="idPel" value="<?=$_REQUEST['idPel']?>" />
						<input type="hidden" id="idKunj" name="idKunj" value="<?=$_REQUEST['idKunj']?>" />
						<input type="hidden" id="idUsr" name="idUsr" value="<?=$_REQUEST['idUsr']?>" />
						<input type="hidden" id="tgl" name="tgl" value="<?=$date_now?>" />
					</center>
					<!--div>Selected keys: <span id="echoSelection3">-</span></div>
					<div>Selected root keys: <span id="echoSelectionRootKeys3">-</span></div>
					<div>Selected root nodes: <span id="echoSelectionRoots3">-</span></div-->
				<? 
					 }else{}
				   }else{
						include 'view.php';
				   } 
				 ?>
				</td>
			</tr>
		</table>
	</form>
    <br/>
</body>
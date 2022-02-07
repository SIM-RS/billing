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
	<title>Insiden Tertusuk Jarum / Terpajan Cairan Tubuh</title>
</head>
<body>
	<iframe height="193" width="168" name="gToday:normal:agenda.js"
		id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
		style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
	</iframe>
	<table id="tblSerahTerima" width=850 align=center cellspacing=5 cellpadding=0 style='border:.5pt solid windowtext;'>
		<tr>
			<td style='font-size:16px; text-align:center; font-weight:bold; text-decoration:underline;'>
				<?=strtoupper("formulir laporan insiden tertusuk jarum/terpajan cairan tubuh")?>
			</td>
		</tr>
		<tr>
			<td><? include 'form.php'; ?></td>
		</tr>
	</table>
</body>
<script type="text/JavaScript" language="JavaScript" src="javascript.js"></script>
<script type="text/javascript">
	function setPajanManual(){
		if(jQuery('#chkPajan').is(':checked')){
			jQuery('#btnTglPajan').prop('disabled', false);
			jQuery('#jam_pajan').prop('readonly', false);
		}else{
			jQuery('#tgl_pajan').val('<?=$tglPajan?>');
			jQuery('#jam_pajan').val('<?=$timePajan?>');
			jQuery('#btnTglPajan').prop('disabled', true);
			jQuery('#jam_pajan').prop('readonly', true);
		}
	}
	function setLapManual(){
		if(jQuery('#chkLap').is(':checked')){
			jQuery('#btnTglLap').prop('disabled', false);
			jQuery('#jam_lap').prop('readonly', false);
		}else{
			jQuery('#tgl_lap').val('<?=$tglLap?>');
			jQuery('#jam_lap').val('<?=$timeLap?>');
			jQuery('#btnTglLap').prop('disabled', true);
			jQuery('#jam_lap').prop('readonly', true);
		}
	}
</script>
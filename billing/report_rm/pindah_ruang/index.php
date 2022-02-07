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
	<title>Serah Terima Pindah Ruang</title>
</head>
<body>
	<iframe height="193" width="168" name="gToday:normal:agenda.js"
		id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
		style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
	</iframe>
	<table id="tblSerahTerima" width=850 align=center cellspacing=5 cellpadding=0 style='border:.5pt solid windowtext;'>
		<tr>
			<td style='font-size:16px; text-align:center; font-weight:bold; text-decoration:underline;'>Form Serah Terima Pindah Ruang</td>
		</tr>
		<tr>
			<td><? include 'form.php'; ?></td>
		</tr>
	</table>
</body>
<script type="text/JavaScript" language="JavaScript" src="javascript.js"></script>
<script type="text/javascript">
	function setRawatManual(){
		if(jQuery('#chkRawat').is(':checked')){
			jQuery('#btnTglRawat').prop('disabled', false);
			jQuery('#jam_rawat').prop('readonly', false);
		}else{
			jQuery('#tgl_rawat').val('<?=$tglRawat?>');
			jQuery('#jam_rawat').val('<?=$timeRawat?>');
			jQuery('#btnTglRawat').prop('disabled', true);
			jQuery('#jam_rawat').prop('readonly', true);
		}
	}
	function setPindahManual(){
		if(jQuery('#chkPindah').is(':checked')){
			jQuery('#btnTglPindah').prop('disabled', false);
			jQuery('#jam_pindah').prop('readonly', false);
		}else{
			jQuery('#tgl_pindah').val('<?=$tglPindah?>');
			jQuery('#jam_pindah').val('<?=$timePindah?>');
			jQuery('#btnTglPindah').prop('disabled', true);
			jQuery('#jam_pindah').prop('readonly', true);
		}
	}
</script>
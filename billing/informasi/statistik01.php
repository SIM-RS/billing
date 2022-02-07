<?php 
session_start();
if(!isset($_SESSION['userId']))
{
	header('Location: ../index.php');
}else{
?>
<html>
<head>
	<title>Statistik BOR, ALOS, BTO dan TOI</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">		
	<link type="text/css" rel="stylesheet" href="../theme/mod.css">
	<style type="text/css">
		.txtinput{
			 background-color: #E5F4D2;
		}
	</style>
	<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
	
	<!--dibawah ini diperlukan untuk menampilkan popup-->
	<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
	<script type="text/javascript" src="../theme/prototype.js"></script>
	<script type="text/javascript" src="../theme/effects.js"></script>
	<script type="text/javascript" src="../theme/popup.js"></script>
	<!--diatas ini diperlukan untuk menampilkan popup-->
	
	<!-- untuk ajax-->
	<script type="text/javascript" src="../theme/js/ajax.js"></script>
	<!-- end untuk ajax-->
	<script type="text/JavaScript">
		var arrRange = depRange = [];
	</script>
</head>

<body>
	<iframe height="193" width="168" name="gToday:normal:agenda.js"
		id="gToday:normal:agenda.js"
		src="../theme/popcjs.php" scrolling="no"
		frameborder="1"
		style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
	</iframe>
	<?php 
		include("../koneksi/konek.php");
		include("../header1.php");
	?>
	<div align="center">
		<table width="1000" class="hd2">
			<tr>
				<td height="30">Statistik BOR, ALOS, BTO dan TOI</td>
			</tr>
		</table>
		<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
			<tr>
				<td height="20"></td>
			</tr>
			<tr>
				<td>
					<table width="436" align="center" cellpadding="3" cellspacing="0" style="font-size:12px">
						<tr>
							<td>Jenis Layanan</td>
							<td>
								<!--<select name="JnsLayanan" id="JnsLayanan" tabindex="26" class="txtinput" onchange="change()"></select>-->
								<select id="JnsLayanan" name="JnsLayanan" onChange="showTmpLay();" class="txtinput">
											<option value="0">RAWAT INAP (GROUP KAMAR)</option>
									<?php
										$query = "select id,nama from b_ms_unit where aktif=1 and level=1 and inap = 1 and id<>68";
										$rs = mysql_query($query);
										while($row=mysql_fetch_array($rs)){
									?>
											<option value="<?php echo $row['id'];?>"><?php echo $row['nama']; ?></option>
									<?php
										}
									?>
										<option value="">ALL UNIT</option>
								</select>
							</td>
						</tr>
						<!--<tr id="tr_tmpLay">
							<td>Tempat Layanan</td>
							<td>
								<select name="TmpLayanan" id="TmpLayanan" tabindex="27" class="txtinput">
								</select>
							</td>
						</tr>-->
						<tr>
							<td>Periode</td>
							<td>
								<select name="tahun" id="tahun">
									<option value="2017">2017</option>
									<option value="2018">2018</option>
								</select>
								<!--<input type="text" id="tgl1" name="tgl1" size="10" class="txtinput" onClick="gfPop.fPopCalendar(document.getElementById('tgl1'),depRange);">
									&nbsp;s/d&nbsp;
								<input type="text" id="tgl2" name="tgl2" size="10" class="txtinput" onClick="gfPop.fPopCalendar(document.getElementById('tgl2'),depRange);">-->
								
							</td>
						</tr>
                        <tr style="display:none">
							<td>Jumlah Tempat Tidur Aktif</td>
							<td>
                            <input type="text" id="jml" class="txtinput" size="10" value="0" style="text-align:right;">
                            <input type="hidden" id="status" class="status" value="0">
                            </td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><button id="tampil" name="tampil" onClick="cetak()" style="cursor:pointer"><img src="../icon/lihat.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Cetak </button></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td height="20"></td>
			</tr>
		</table>
		<table border="0" class="hd2" width="1000">
			<tr>
				<td>&nbsp;</td>
				<td></td>
				<td></td>
				<td></td>
				<td align="right">&nbsp;</td>
			</tr>
		</table>
	</div>
</body>
</html>
<script type="text/javascript">
	function showTmpLay(){
		var x = document.getElementById('JnsLayanan').value;
		
		if(x==''){
			document.getElementById('tr_tmpLay').hide();
		}else{
			document.getElementById('tr_tmpLay').show();
		}
		
		if(x=='0'){
		isiCombo('TmpLayananGroupInap',document.getElementById('JnsLayanan').value,'','TmpLayanan');
		}else{
		isiCombo('TmpLayananInapSaja',document.getElementById('JnsLayanan').value,'','TmpLayanan');
		}
		
		
	}
	function isiCombo(id,val,defaultId,targetId,evloaded){
		if(targetId=='' || targetId==undefined){
			targetId=id;
		}
		Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId+'&all=0',targetId,'','GET',evloaded);
	}
	showTmpLay();
	
	
	function cetak()
	{
		//if(document.getElementById('tgl1').value == '' || document.getElementById('tgl2').value == ''){
			//alert('Tanggal tidak boleh kosong !');
			//return false;
		//}else{
			simpan1();
		//}
		
	}
	
	function simpan1()
	{
		//alert("");
		cetak1();
		//Request('simpan_bed.php?tmp='+document.getElementById('TmpLayanan').value+'&tgl1='+document.getElementById('tgl1').value+'&tgl2='+document.getElementById('tgl2').value+'&jmlB='+document.getElementById('jml').value,'status','','GET',cetak1);
	}
	
	function cetak1()
	{
		//if(document.getElementById('tgl1').value == '' || document.getElementById('tgl2').value == ''){
			//alert('Tanggal tidak boleh kosong !');
			//return false;
		//}else{
			window.open('cetak_statistik2.php?tahun='+document.getElementById('tahun').value);
											//'jns='+document.getElementById('JnsLayanan').value+
											//'&tmp='+document.getElementById('TmpLayanan').value+
											//'&tgl1='+document.getElementById('tgl1').value+
											//'&tgl2='+document.getElementById('tgl2').value+
											//'&tahun='+document.getElementById('tahun').value+
											//'&jmlB='+document.getElementById('jml').value);
		//}
	}
</script>
<? } ?>
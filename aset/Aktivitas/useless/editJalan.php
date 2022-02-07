
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
	<title>Edit KIB Jalan</title>
</head>

<body>
<script type="text/javascript">
	var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
		id="gToday:normal:agenda.js"
		src="../theme/popcjs.php" scrolling="no"
		frameborder="1"
		style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<div align="center">
<?php
	include("../header.php");
	include("../koneksi/konek.php");
	$id_kib = $_REQUEST['id_kib'];
	$tgldisetujui = explode('-',$_REQUEST['txttgldisetujui']);
	$tgldisetujui = $tgldisetujui[2].'-'.$tgldisetujui[1].'-'.$tgldisetujui[0];
	$tgldiisi = explode('-',$_REQUEST['txttgldiisi']);
	$tgldiisi = $tgldiisi[2].'-'.$tgldiisi[1].'-'.$tgldiisi[0];
	if($_REQUEST["act"]=="save")
	{
        $sql_update="UPDATE as_kib SET panjang='".$_REQUEST["txtpanjang"]."',lebar='".$_REQUEST["txtlebar"]."',nokibtanah='".$_REQUEST["txtnokibtanah"]."',suratlain='".$_REQUEST["txtsuratlain"]."',alamat='".$_REQUEST["txtalamat"]."',kelurahan='".$_REQUEST["txtkelurahan"]."',kecamatan='".$_REQUEST["txtkecamatan"]."',kotamadya='".$_REQUEST["txtkotamadya"]."',caraperolehan='".$_REQUEST["cmbcaraperolehan"]."',diperolehdari='".$_REQUEST["txtdiperolehdari"]."',hargasatuan='".$_REQUEST["txthargasatuan"]."',dasarharga='".$_REQUEST["cmbdasarharga"]."',mano='".$_REQUEST["txtmano"]."',namapengurus='".$_REQUEST["txtnamapengurus"]."',alamatpengurus='".$_REQUEST["txtalamatpengurus"]."',catpengisi='".$_REQUEST["txtcatpengisi"]."',namapetugas='".$_REQUEST["txtnamapetugas"]."',jabatanpetugas='".$_REQUEST["txtjabatanpetugas"]."',tgldisetujui='".$tgldisetujui."',namapetugas2='".$_REQUEST["txtnamapetugas2"]."',jabatanpetugas2='".$_REQUEST["txtjabatanpetugas2"]."',tgldiisi='".$tgldiisi."' WHERE id_kib=$id_kib";
        $exe_update=mysql_query($sql_update);
        if($exe_update>0)
		{ 
			echo "<script>alert('Data Telah Berhasil Tersimpan..');
			window.location= 'jalan.php';
			</script>";
		}
   }
	
	$sqltnh = "SELECT b.kodebarang,b.namabarang,u.namaunit,u.kodeunit,k.id_kib,
			k.panjang,k.lebar,k.nokibtanah,k.suratlain,k.alamat,k.kelurahan,k.kecamatan,k.kotamadya,
			k.caraperolehan,k.diperolehdari,DATE_FORMAT(k.tglperolehan,'%d-%m-%Y') AS tglperolehan,
			k.hargasatuan,k.dasarharga,k.mano,k.namapengurus,k.alamatpengurus,k.catpengisi,
			k.namapetugas,k.jabatanpetugas,DATE_FORMAT(k.tgldisetujui,'%d-%m-%Y') AS tgldisetujui,
			k.namapetugas2,k.jabatanpetugas2,DATE_FORMAT(k.tgldiisi,'%d-%m-%Y') AS tgldiisi
			FROM as_kib k
			INNER JOIN as_transaksi t ON t.idtransaksi = k.idtransaksi
			INNER JOIN as_ms_barang b ON b.idbarang = t.idbarang
			INNER JOIN as_ms_unit u ON u.idunit = t.idunit
			WHERE LEFT(b.kodebarang,2) = 04 AND k.id_kib = '".$id_kib."'";
	$dttnh = mysql_query($sqltnh);
	$rwtnh = mysql_fetch_array($dttnh);
	
?>
<form name="form1" id="form1" action="" method="post">
    <input name="act" id="act" type="hidden" />
    <div>
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>

  </tr>
  <tr>
<td align="center">
<table width="625" bordercolor="#000000" border="0" cellspacing="0" cellpadding="2" align="center">
	<tr>
		<td height="30" colspan="2" valign="bottom" align="right">
			<button class="Enabledbutton" id="backbutton" type="button" onClick="location='jalan.php'" title="Back" style="cursor:pointer">
        			<img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                		Back to List
            </button>
	  		<button class="Enabledbutton" id="btnSimpan" name="btnSimpan" onclick="document.getElementById('act').value='save';form1.submit()" title="Save" style="cursor:pointer">
      			<img  src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Save Record
			</button>
            <button class="Disabledbutton" id="undobutton" disabled="true" onClick="location='editTanah.php'" title="Cancel / Refresh" style="cursor:pointer">
                	<img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
      					Undo/Refresh
            </button></td>
	</tr>	 
		 <tr>
		<td colspan="2" class="header">.: Kartu Inventaris Barang : Jalan, Irigasi Dan Jaringan :. (Edit Mode)</td>
	  </tr>
	  <tr>
		<td width="40%" class="label">&nbsp;Unit Kerja</td>
		<td width="60%" class="content">&nbsp;<input id="txtkodeunit" name="txtkodeunit" value="<?php echo $rwtnh['kodeunit']; ?>" style="background-color:#99FFFF;" size="24"/></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Kode Barang - Seri</td>
		<td class="content">&nbsp;<input id="txtkodebarang" name="txtkodebarang" value="<?php echo $rwtnh['kodebarang'];?>" size="24" style="background-color:#99FFFF;"/></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Nama Barang</td>
		<td class="content">&nbsp;<input id="txtnamabarang" name="txtnamabarang" value="<?php echo $rwtnh['namabarang'];?>" size="50" style="background-color:#99FFFF;" /></td>
	  </tr>
	  <tr>
		<td colspan="2" class="header2">&nbsp;I. UNIT BARANG</td>
		</tr>
	  <tr>
	  	<td class="label">&nbsp;Konstruksi</td>
		<td class="content">&nbsp;<select id="cmbkonstruksi" name="cmbkonstruksi">
							<option value="0"></option>
							<option value="1">1 - Aspal</option>
							<option value="2">2 - Beton</option>
							<option value="3">3 - Paving</option>
							<option value="4">4 - Makadam</option>
							<option value="5">5 - Semen</option>
							<option value="6">6 - Beton Beraspal</option>
							<option value="7">7 - Tanah Liat</option>
							<option value="8">8 - Lainnya</option>
						</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Panjang</td>
		<td class="content">&nbsp;<input id="txtpanjang" name="txtpanjang" size="16" value="<?php echo $rwtnh['panjang'];?>" />&nbsp;Km</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Lebar</td>
		<td class="content">&nbsp;<input id="txtlebar" name="txtlebar" size="16" value="<?php echo $rwtnh['lebar'];?>" />&nbsp;m</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Kondisi Barang</td>
		<td class="content">&nbsp;<select id="cmbkondisibarang" name="cmbkondisibarang">
							<option value="0"></option>
							<option value="1">1 - Baik</option>
							<option value="2">2 - Kurang Baik</option>
							<option value="3">3 - Rusak Berat</option>
							<option value="4">4 - Tidak Berfungsi</option>
						</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Status Tanah</td>
		<td class="content">&nbsp;<select id="cmbstatustanah" name="cmbstatustanah">
							<option value="0"></option>
							<option value="1">1 - Tanah Pemda/Pemkot</option>
							<option value="2">2 - Tanah Negara</option>
							<option value="3">3 - Tanah Hak Ulayat</option>
							<option value="4">4 - Tanah Hak Milik</option>
							<option value="5">5 - Tanah Hak Guna Bangunan</option>
							<option value="6">6 - Tanah Hak Pakai</option>
							<option value="7">7 - Tanah Hak Pengelolaan</option>
							<option value="8">8 - Lainnya</option>
						</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;No KIB Tanah</td>
		<td class="content">&nbsp;<input id="txtnokibtanah" name="txtnokibtanah" size="50" value="<?php echo $rwtnh['nokibtanah'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Surat Kepemilikan No</td>
		<td class="content">&nbsp;<input id="txtsuratkepemno" name="txtsuratkepemno" size="60" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Surat Kepemilikan Tgl</td>
		<td class="content">&nbsp;<input id="txtsuratkepemtgl" name="txtsuratkepemtgl" size="24" class="txtunedited" readonly readonly />
			<img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtsuratkepemtgl'),depRange);"> 
			<font size=1 color=gray><i>(dd-mm-yyyy)</i></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Surat-Surat Lainnya</td>
		<td class="content">&nbsp;<input id="txtsuratlain" name="txtsuratlain" size="60" value="<?php echo $rwjln['suratlain']; ?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Alamat</td>
		<td class="content">&nbsp;<input id="txtalamat" name="txtalamat" size="50" value="<?php echo $rwjln['alamat'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Kelurahan</td>
		<td class="content">&nbsp;<input id="txtkelurahan" name="txtkelurahan" size="50" value="<?php echo $rwjln['kelurahan'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Kecamatan</td>
		<td class="content">&nbsp;<input id="txtkecamatan" name="txtkecamatan" size="50" value="<?php echo $rwjln['kecamatan'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Kab/Kodya</td>
		<td class="content">&nbsp;<input id="txtkotamadya" name="txtkotamadya" size="50" value="<?php echo $rwjln['kotamadya'];?>" /></td>
	  </tr>
	  <tr>
		<td colspan="2" class="header2">&nbsp;II. PENGADAAN</td>
	</tr>
	<tr>
	  	<td class="label">&nbsp;Cara Perolehan</td>
		<td class="content">&nbsp;<select id="cmbcaraperolehan" name="cmbcaraperolehan">
				<option <?php if($rwtnh['caraperolehan'] == 0) echo 'selected'; ?> value="0"></option>
				<option <?php if($rwtnh['caraperolehan'] == 1) echo 'selected'; ?> value="1">1 - Pembelian</option>
				<option <?php if($rwtnh['caraperolehan'] == 2) echo 'selected'; ?> value="2">2 - Hibah</option>
				<option <?php if($rwtnh['caraperolehan'] == 3) echo 'selected'; ?> value="3">3 - dll</option>
				</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Diperoleh Dari</td>
		<td class="content">&nbsp;<input id="txtdiperolehdari" name="txtdiperolehdari" value="<?php echo $rwtnh['diperolehdari'];?>" size="50" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Kondisi Perolehan</td>
		<td class="content">&nbsp;<select id="cmbkondisiperolehan" name="cmbkondisiperolehan">
					<option value="0"></option>
					<option value="1">1 - Baik</option>
					<option value="2">2 - Kurang Baik</option>
					<option value="3">3 - Rusak Berat</option>
					<option value="4">4 - Tidak Berfungsi</option>
				</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Harga</td>
		<td class="content">&nbsp;<input id="txthargasatuan" name="txthargasatuan" value="<?php echo $rwtnh['hargasatuan'];?>" size="24" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Dasar Harga</td>
		<td class="content">&nbsp;<select id="cmbdasarharga" name="cmbdasarharga">
				<option <?php if($rwtnh['dasarharga'] == 0) echo 'selected'; ?> value="0"></option>
				<option <?php if($rwtnh['dasarharga'] == 1) echo 'selected'; ?> value="1">1 - Pemborongan</option>
				<option <?php if($rwtnh['dasarharga'] == 2) echo 'selected'; ?> value="2">2 - Taksiran</option>
				</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Mata Anggaran</td>
		<td class="content">&nbsp;<select name="cmbmataanggaran" id="cmbmataanggaran">
								<?php
								  $sqlma=mysql_query("SELECT idsumberdana,keterangan FROM as_ms_sumberdana");
								  while($showma=mysql_fetch_array($sqlma)){
								  ?>
								<option value="<?=$showma['idsumberdana'];?>"><?=$showma['keterangan'];?></option>
								<?php } ?>
								</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;No MA</td>
		<td class="content">&nbsp;<input id="txtmano" name="txtmano" value="<?php echo $rwtnh['mano'];?>" size="50" /></td>
	  </tr>
	  <tr>
	  	<td colspan="2" class="header2">&nbsp;III. PENGURUS BARANG</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Nama/Jabatan</td>
		<td class="content">&nbsp;<input id="txtnamapengurus" name="txtnamapengurus" value="<?php echo $rwtnh['namapengurus'];?>" size="50" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Alamat</td>
		<td class="content">&nbsp;<input id="txtalamatpengurus" name="txtalamatpengurus" value="<?php echo $rwtnh['alamatpengurus'];?>" size="50" /></td>
	  </tr>
	  <tr>
	  	<td colspan="2" class="header2">&nbsp;IV. BAGIAN-BAGIAN LAIN/PERLENGKAPAN</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Catatan Perlengkapan</td>
		<td class="content">&nbsp;<textarea id="txtcatperlengkapan" name="txtcatperlengkapan" cols="50"></textarea></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Catatan Pengisi</td>
		<td class="content">&nbsp;<textarea id="txtcatpengisi" name="txtcatpengisi" cols="50"><?php echo $rwtnh['catpengisi'];?></textarea></td>
	  </tr>
	  <tr>
	  	<td colspan="2" class="header2">&nbsp;DISETUJUI OLEH</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Nama</td>
		<td class="content">&nbsp;<input id="txtnamapetugas" name="txtnamapetugas" value="<?php echo $rwtnh['namapetugas'];?>" size="50" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Jabatan</td>
		<td class="content">&nbsp;<input id="txtjabatanpetugas" name="txtjabatanpetugas" size="50" value="<?php echo $rwtnh['jabatanpetugas'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Tanggal</td>
		<td class="content">&nbsp;<input id="txttgldisetujui" name="txttgldisetujui" value="<?php echo $rwtnh['tgldisetujui'];?>" size="24" class="txtunedited" readonly readonly />
			<img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txttgldisetujui'),depRange);"> 
			<font size=1 color=gray><i>(dd-mm-yyyy)</i></font></td>
	  </tr>
	  <tr>
	  	<td colspan="2" class="header2">&nbsp;DIISI OLEH</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Nama</td>
		<td class="content">&nbsp;<input id="txtnamapetugas2" name="txtnamapetugas2" value="<?php echo $rwtnh['namapetugas2'];?>" size="50" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Jabatan</td>
		<td class="content">&nbsp;<input id="txtjabatanpetugas2" name="txtjabatanpetugas2" size="50" value="<?php echo $rwtnh['jabatanpetugas2'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Tanggal</td>
		<td class="content">&nbsp;<input id="txttgldiisi" name="txttgldiisi" value="<?php echo $rwtnh['tgldiisi'];?>" size="24" class="txtunedited" readonly readonly />
			<img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txttgldiisi'),depRange);"> 
			<font size=1 color=gray><i>(dd-mm-yyyy)</i></font></td>
	  </tr>
	<tr>
		<td colspan="2" class="header2">&nbsp;</td>
		</tr>
	</table>
    <table><tr><td height="10"></td></tr></table>
            <div><img src="../images/foot.gif" width="1000" height="45"></div>
            </td>

  </tr>
</table>
            </div>
</form>
</div>
</body>
<script type="text/javascript" language="javascript">
</html>

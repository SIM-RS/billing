<?
include '../sesi.php';
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
	<title>Edit KIB Tanah</title>
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
	$sertifikattgl = explode('-',$_REQUEST['txtsertifikattgl']);
	$sertifikattgl = $sertifikattgl[2].'-'.$sertifikattgl[1].'-'.$sertifikattgl[0];
	$tglperolehan = explode('-',$_REQUEST['txttglperolehan']);
	$tglperolehan = $tglperolehan[2].'-'.$tglperolehan[1].'-'.$tglperolehan[0];
	$tgldisetujui = explode('-',$_REQUEST['txttgldisetujui']);
	$tgldisetujui = $tgldisetujui[2].'-'.$tgldisetujui[1].'-'.$tgldisetujui[0];
	$tgldiisi = explode('-',$_REQUEST['txttgldiisi']);
	$tgldiisi = $tgldiisi[2].'-'.$tgldiisi[1].'-'.$tgldiisi[0];
	if($_REQUEST["act"]=="save")
	{
        $sql_update="UPDATE as_kib SET jenistanah='".$_REQUEST["cmbjenistanah"]."',peruntukan='".$_REQUEST["cmbperuntukkan"]."',luastanah='".$_REQUEST["txtluastanah"]."',alamat='".$_REQUEST["txtalamat"]."',statushukum='".$_REQUEST["cmbstatushukum"]."',suratukur='".$_REQUEST["txtsuratukur"]."',suratgirik='".$_REQUEST["txtsuratgirik"]."',suratsertifikat='".$_REQUEST["txtsuratsertifikat"]."',sertifikattgl='".$sertifikattgl."',suratakte='".$_REQUEST["txtsuratakte"]."',suratskpt='".$_REQUEST["txtsuratskpt"]."',suratlain='".$_REQUEST["txtsuratlain"]."',gambarno='".$_REQUEST["txtgambarno"]."',gambarmacam='".$_REQUEST["txtgambarmacam"]."',gambarskala='".$_REQUEST["txtgambarskala"]."',gambarjumlah='".$_REQUEST["txtgambarjumlah"]."',macampersil='".$_REQUEST["cmbmacampersil"]."',macampemanfaatan='".$_REQUEST["cmbmacampemanfaatan"]."',macamnonpersil='".$_REQUEST["cmbmacamnonpersil"]."',macamjenisnonpersil='".$_REQUEST["cmbmacamjenisnonpersil"]."',caraperolehan='".$_REQUEST["cmbcaraperolehan"]."',diperolehdari='".$_REQUEST["txtdiperolehdari"]."',tglperolehan='".$tglperolehan."',hargasatuan='".$_REQUEST["txthargasatuan"]."',dasarharga='".$_REQUEST["cmbdasarharga"]."',mano='".$_REQUEST["txtmano"]."',namapengurus='".$_REQUEST["txtnamapengurus"]."',alamatpengurus='".$_REQUEST["txtalamatpengurus"]."',catpengisi='".$_REQUEST["txtcatpengisi"]."',namapetugas='".$_REQUEST["txtnamapetugas"]."',jabatanpetugas='".$_REQUEST["txtjabatanpetugas"]."',tgldisetujui='".$tgldisetujui."',namapetugas2='".$_REQUEST["txtnamapetugas2"]."',jabatanpetugas2='".$_REQUEST["txtjabatanpetugas2"]."',tgldiisi='".$tgldiisi."' WHERE id_kib=$id_kib";
        $exe_update=mysql_query($sql_update);
        if($exe_update>0)
		{ 
			echo "<script>alert('Data Telah Berhasil Tersimpan..');
			window.location= 'tanah.php';
			</script>";
		}
   }
	
	$sqltnh = "SELECT b.kodebarang,b.namabarang,u.namaunit,u.kodeunit,k.id_kib,
k.jenistanah,k.peruntukan,k.luastanah,k.alamat,k.statushukum,k.suratukur,k.suratgirik,
k.suratsertifikat,date_format(k.sertifikattgl,'%d-%m-%Y') as sertifikattgl,k.suratakte,k.suratskpt,k.suratlain,
k.gambarno,k.gambarmacam,k.gambarskala,k.gambarjumlah,k.macampersil,k.macampemanfaatan,k.macamnonpersil,k.macamjenisnonpersil,
k.caraperolehan,k.diperolehdari,date_format(k.tglperolehan,'%d-%m-%Y') as tglperolehan,k.hargasatuan,k.dasarharga,k.mano,k.namapengurus,k.alamatpengurus,k.catpengisi,k.namapetugas,k.jabatanpetugas,date_format(k.tgldisetujui,'%d-%m-%Y') as tgldisetujui,k.namapetugas2,k.jabatanpetugas2,date_format(k.tgldiisi,'%d-%m-%Y') as tgldiisi
FROM as_kib k
INNER JOIN as_transaksi t ON t.idtransaksi = k.idtransaksi
INNER JOIN as_ms_barang b ON b.idbarang = t.idbarang
INNER JOIN as_ms_unit u ON u.idunit = t.idunit
WHERE LEFT(b.kodebarang,2) = 01 AND k.id_kib = '".$id_kib."'";
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
			<button class="Enabledbutton" id="backbutton" type="button" onClick="location='tanah.php'" title="Back" style="cursor:pointer">
        			<img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                		Back to List
            </button>
	  		<button class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="document.getElementById('act').value='save';form1.submit()" title="Save" style="cursor:pointer">
      			<img  src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Save Record
			</button>
            <button class="Disabledbutton" id="undobutton" disabled="true" onClick="location='editTanah.php'" title="Cancel / Refresh" style="cursor:pointer">
                	<img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
      					Undo/Refresh
            </button></td>
	</tr>	 
		 <tr>
		<td colspan="2" class="header">.: Kartu Inventaris Barang : Tanah :. (Edit Mode)</td>
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
	  	<td class="label">&nbsp;Jenis Tanah</td>
		<td class="content">&nbsp;<select id="cmbjenistanah" name="cmbjenistanah">
								<option <?php if($rwtnh['jenistanah'] == 1) echo 'selected'; ?> value="1">1 - Persil</option>
								<option <?php if($rwtnh['jenistanah'] == 2) echo 'selected'; ?> value="2">2 - Non Persil</option>
								</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Peruntukkan</td>
		<td class="content">&nbsp;<select id="cmbperuntukkan" name="cmbperuntukkan">
						<option <?php if($rwtnh['peruntukkan'] == 1) echo 'selected'; ?> value="1">1 - Kantor</option>
						<option <?php if($rwtnh['peruntukkan'] == 2) echo 'selected'; ?> value="2">2 - Gudang</option>
						<option <?php if($rwtnh['peruntukkan'] == 3) echo 'selected'; ?> value="3">3 - Bengkel</option>
						<option <?php if($rwtnh['peruntukkan'] == 4) echo 'selected'; ?> value="4">4 - Laboratorium</option>
						<option <?php if($rwtnh['peruntukkan'] == 5) echo 'selected'; ?> value="5">5 - Rumah</option>
						<option <?php if($rwtnh['peruntukkan'] == 6) echo 'selected'; ?> value="6">6 - Mess</option>
						<option <?php if($rwtnh['peruntukkan'] == 7) echo 'selected'; ?> value="7">7 - Gd Pendidikan</option>
						<option <?php if($rwtnh['peruntukkan'] == 8) echo 'selected'; ?> value="8">8 - Poliklinik</option>
						<option <?php if($rwtnh['peruntukkan'] == 9) echo 'selected'; ?> value="9">9 - Jalan</option>
						<option <?php if($rwtnh['peruntukkan'] == 10) echo 'selected'; ?> value="10">10 - Lapangan</option>
						<option <?php if($rwtnh['peruntukkan'] == 11) echo 'selected'; ?> value="11">11 - Lainnya</option>
						</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Luas Tanah</td>
		<td class="content">&nbsp;<input id="txtluastanah" name="txtluastanah" value="<?php echo $rwtnh['luastanah'];?>"  size="16"/>&nbsp;m2</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Kondisi Tanah</td>
		<td class="content">&nbsp;<select id="cmbkondisitanah" name="cmbkondisitanah">
								<option value="1">1 - Ada Bangunan</option>
								<option value="2">2 - Siap Dibangun</option>
								<option value="3">3 - Belum Dibangun</option>
								<option value="4">4 - Tidak Dapat Dibangun</option>
							</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Alamat/Lokasi</td>
		<td class="content">&nbsp;<input id="txtalamat" name="txtalamat" value="<?php echo $rwtnh['alamat'];?>" size="60" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Status Hukum</td>
		<td class="content">&nbsp;<select id="cmbstatushukum" name="cmbstatushukum">
			<option <?php if($rwtnh['statushukum'] == 1) echo 'selected'; ?> value="1">1 - Hak Guna Usaha</option>
			<option <?php if($rwtnh['statushukum'] == 2) echo 'selected'; ?> value="2">2 - Hak Milik</option>
			<option <?php if($rwtnh['statushukum'] == 3) echo 'selected'; ?> value="3">3 - Hak Guna Bangunan</option>
			<option <?php if($rwtnh['statushukum'] == 4) echo 'selected'; ?> value="4">4 - Hak Pakai</option>
			<option <?php if($rwtnh['statushukum'] == 5) echo 'selected'; ?> value="5">5 - Hak Sewa untuk Bangunan</option>
			<option <?php if($rwtnh['statushukum'] == 6) echo 'selected'; ?> value="6">6 - Hak Membuka Tanah</option>
			<option <?php if($rwtnh['statushukum'] == 7) echo 'selected'; ?> value="7">7 - Hak Sewa Tanah Pertanian</option>
								</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Surat Ukur No.</td>
		<td class="content">&nbsp;<input id="txtsuratukur" name="txtsuratukur" size="60" value="<?php echo $rwtnh['suratukur'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Surat Girik No</td>
		<td class="content">&nbsp;<input id="txtsuratgirik" name="txtsuratgirik" size="60" value="<?php echo $rwtnh['suratgirik'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Surat Sertifikat No.</td>
		<td class="content">&nbsp;<input id="txtsuratsertifikat" name="txtsuratsertifikat" value="<?php echo $rwtnh['suratsertifikat'];?>" size="60" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Surat Sertifikat Tgl.</td>
		<td class="content">&nbsp;<input id="txtsertifikattgl" name="txtsertifikattgl" value="<?php echo $rwtnh['sertifikattgl'];?>" size="24" class="txtunedited" readonly readonly />
			<img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtsertifikattgl'),depRange);"> 
			<font size=1 color=gray><i>(dd-mm-yyyy)</i></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Surat Akte No.</td>
		<td class="content">&nbsp;<input id="txtsuratakte" name="txtsuratakte" value="<?php echo $rwtnh['suratakte'];?>" size="60" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;SKPT No.</td>
		<td class="content">&nbsp;<input id="txtsuratskpt" name="txtsuratskpt" value="<?php echo $rwtnh['suratskpt'];?>" size="60" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Surat Lain</td>
		<td class="content">&nbsp;<input id="txtsuratlain" name="txtsuratlain" value="<?php echo $rwtnh['suratlain'];?>" size="60" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Gambar No</td>
		<td class="content">&nbsp;<input id="txtgambarno" name="txtgambarno" value="<?php echo $rwtnh['gambarno'];?>" size="50" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Gambar Macam</td>
		<td class="content">&nbsp;<input id="txtgambarmacam" name="txtgambarmacam" value="<?php echo $rwtnh['gambarmacam'];?>" size="50" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Gambar Skala</td>
		<td class="content">&nbsp;<input id="txtgambarskala" name="txtgambarskala" value="<?php echo $rwtnh['gambarskala'];?>" size="50" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Gambar Jumlah</td>
		<td class="content">&nbsp;<input id="txtgambarjumlah" name="txtgambarjumlah" value="<?php echo $rwtnh['gambarjumlah'];?>" size="50" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Macam Persil</td>
		<td class="content">&nbsp;<select id="cmbmacampersil" name="cmbmacampersil">
				<option <?php if($rwtnh['macampersil'] == 1) echo 'selected'; ?> value="1">Kelas I</option>
				<option <?php if($rwtnh['macampersil'] == 2) echo 'selected'; ?> value="2">Kelas II</option>
				<option <?php if($rwtnh['macampersil'] == 3) echo 'selected'; ?> value="3">Kelas III</option>
				<option <?php if($rwtnh['macampersil'] == 4) echo 'selected'; ?> value="4">Kelas IV</option>
				</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Pemanfaatan</td>
		<td class="content">&nbsp;<select id="cmbpemanfaatan" name="cmbpemanfaatan">
					<option <?php if($rwtnh['pemanfaatan'] == 1) echo 'selected'; ?> value="1">1 - Rumah</option>
					<option <?php if($rwtnh['pemanfaatan'] == 2) echo 'selected'; ?> value="2">2 - Kantor</option>
					<option <?php if($rwtnh['pemanfaatan'] == 3) echo 'selected'; ?> value="3">3 - Lainnya</option>
					</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Macam Non Persil</td>
		<td class="content">&nbsp;<select id="cmbmacamnonpersil" name="cmbmacamnonpersil">
				<option <?php if($rwtnh['macamnonpersil'] == 1) echo 'selected'; ?> value="1">Kelas I</option>
				<option <?php if($rwtnh['macamnonpersil'] == 2) echo 'selected'; ?> value="2">Kelas II</option>
				<option <?php if($rwtnh['macamnonpersil'] == 3) echo 'selected'; ?> value="3">Kelas III</option>
				<option <?php if($rwtnh['macamnonpersil'] == 4) echo 'selected'; ?> value="4">Kelas IV</option>
				</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Jenis Kelas</td>
		<td class="content">&nbsp;<select id="cmbmacamjenisnonpersil" name="cmbmacamjenisnonpersil">
				<option <?php if($rwtnh['macamjenisnonpersil'] == 1) echo 'selected'; ?> value="1">1 - Tanah Kering</option>
				<option <?php if($rwtnh['macamjenisnonpersil'] == 2) echo 'selected'; ?> value="2">2 - Tanah Basah</option>
				</select></td>
	  </tr>
	  <tr>
		<td colspan="2" class="header2">&nbsp;II. PENGADAAN</td>
	</tr>
	<tr>
	  	<td class="label">&nbsp;Cara Perolehan</td>
		<td class="content">&nbsp;<select id="cmbcaraperolehan" name="cmbcaraperolehan">
				<option <?php if($rwtnh['caraperolehan'] == 1) echo 'selected'; ?> value="1">1 - Pembelian</option>
				<option <?php if($rwtnh['caraperolehan'] == 2) echo 'selected'; ?> value="2">2 - Hibah</option>
				<option <?php if($rwtnh['caraperolehan'] == 3) echo 'selected'; ?> value="3">3 - Pembebasan</option>
				<option <?php if($rwtnh['caraperolehan'] == 4) echo 'selected'; ?> value="4">4 - Sebelum 1945</option>
				<option <?php if($rwtnh['caraperolehan'] == 5) echo 'selected'; ?> value="5">5 - Tukar Menukar</option>
				<option <?php if($rwtnh['caraperolehan'] == 6) echo 'selected'; ?> value="6">6 - Cara Lain</option>
				</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Diperoleh Dari</td>
		<td class="content">&nbsp;<input id="txtdiperolehdari" name="txtdiperolehdari" value="<?php echo $rwtnh['diperolehdari'];?>" size="50" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Kondisi Perolehan</td>
		<td class="content">&nbsp;<select id="cmbkondisiperolehan" name="cmbkondisiperolehan">
					<option value="1">1 - Ada Bangunan</option>
					<option value="2">2 - Siap Dibangun</option>
					<option value="3">3 - Belum Dibangun</option>
					<option value="4">4 - Tidak Dapat Dibangun</option>
				</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Tgl Perolehan</td>
		<td class="content">&nbsp;<input id="txttglperolehan" name="txttglperolehan" value="<?php echo $rwtnh['tglperolehan'];?>" size="24" class="txtunedited" readonly readonly />
			<img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txttglperolehan'),depRange);"> 
			<font size=1 color=gray><i>(dd-mm-yyyy)</i></font>
		</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Harga</td>
		<td class="content">&nbsp;<input id="txthargasatuan" name="txthargasatuan" value="<?php echo $rwtnh['hargasatuan'];?>" size="24" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Dasar Harga</td>
		<td class="content">&nbsp;<select id="cmbdasarharga" name="cmbdasarharga">
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

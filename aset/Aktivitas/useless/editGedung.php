
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
	<title>Edit KIB Gedung</title>
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
	$ijinbangtgl = explode('-',$_REQUEST['txtijinbangtgl']);
	$ijinbangtgl = $ijinbangtgl[2].'-'.$ijinbangtgl[1].'-'.$ijinbangtgl[0];
	$tgldisetujui = explode('-',$_REQUEST['txttgldisetujui']);
	$tgldisetujui = $tgldisetujui[2].'-'.$tgldisetujui[1].'-'.$tgldisetujui[0];
	$tgldiisi = explode('-',$_REQUEST['txttgldiisi']);
	$tgldiisi = $tgldiisi[2].'-'.$tgldiisi[1].'-'.$tgldiisi[0];
	if($_REQUEST["act"]=="save")
	{
        $sql_update="UPDATE as_kib SET jenisbang='".$_REQUEST['cmbjenisbang']."',tipebang='".$_REQUEST['cmbtipebang']."',golbang='".$_REQUEST['cmbgolbang']."',kelasbang='".$_REQUEST['cmbkelasbang']."',tahun='".$_REQUEST['txttahun']."',statushukum='".$_REQUEST['cmbstatushukum']."',nopersil='".$_REQUEST['txtnopersil']."',ijinbangno='".$_REQUEST['txtijinbangno']."',ijinbangtgl='".$txtijinbangtgl."',gambarno='".$_REQUEST['txtgambarno']."',gambarmacam='".$_REQUEST['txtgambarmacam']."',gambarskala='".$_REQUEST['txtgambarskala']."',gambarjumlah='".$_REQUEST['txtgambarjumlah']."',nokibtanah='".$_REQUEST['txtnokibtanah']."',surat1='".$_REQUEST['txtsurat1']."',surat2='".$_REQUEST['txtsurat2']."',surat3='".$_REQUEST['txtsurat3']."',alamat='".$_REQUEST['txtalamat']."',kelurahan='".$_REQUEST['txtkelurahan']."',kecamatan='".$_REQUEST['txtkecamatan']."',kotamadya='".$_REQUEST['txtkotamadya']."',konskategori='".$_REQUEST['cmbkonskategori']."',konsatap='".$_REQUEST['cmbkonsatap']."',konskusen='".$_REQUEST['cmbkonskusen']."',konsrangka='".$_REQUEST['cmbkonsrangka']."',konspondasi='".$_REQUEST['cmbkonspondasi']."',konsdinding='".$_REQUEST['cmbkonsdinding']."',konsplafon='".$_REQUEST['cmbkonsplafon']."',konslantai='".$_REQUEST['cmbkonslantai']."',jumlahlantai='".$_REQUEST['txtjumlahlantai']."',luaslantai='".$_REQUEST['txtluaslantai']."',luasbangunan='".$_REQUEST['txtluasbangunan']."',luaslantai1='".$_REQUEST['txtluaslantai1']."',luaslantai2='".$_REQUEST['txtluaslantai2']."',luaslantai3='".$_REQUEST['txtluaslantai3']."',luaslantai4='".$_REQUEST['txtluaslantai4']."',luaslantai5='".$_REQUEST['txtluaslantai5']."',luaslantai6='".$_REQUEST['txtluaslantai6']."',luaslantai7='".$_REQUEST['txtluaslantai7']."',luaslantai8='".$_REQUEST['txtluaslantai8']."',caraperolehan='".$_REQUEST['cmbcaraperolehan']."',diperolehdari='".$_REQUEST['txtdiperolehdari']."',hargasatuan='".$_REQUEST['txthargasatuan']."',dasarharga='".$_REQUEST['cmbdasarharga']."',sumberdana='".$_REQUEST['cmbsumberdana']."',mano='".$_REQUEST['txtmano']."',namapengurus='".$_REQUEST['txtnamapengurus']."',alamatpengurus='".$_REQUEST['txtalamatpengurus']."',catpengisi='".$_REQUEST['txtcatpengisi']."',namapetugas='".$_REQUEST['txtnamapetugas']."',jabatanpetugas='".$_REQUEST['txtjabatanpetugas']."',tgldisetujui='".$tgldisetujui."',namapetugas2='".$_REQUEST['txtnamapetugas2']."',jabatanpetugas2='".$_REQUEST['txtjabatanpetugas2']."',tgldiisi='".$tgldiisi."' WHERE id_kib=$id_kib";
        $exe_update=mysql_query($sql_update);
        if($exe_update>0)
		{ 
			echo "<script>alert('Data Telah Berhasil Tersimpan..');
			window.location= 'gedung.php';
			</script>";
		}
   }
	
	$sqlgdg = "SELECT b.kodebarang,b.namabarang,u.namaunit,u.kodeunit,k.id_kib,
				k.jenisbang,k.tipebang,k.golbang,k.kelasbang,YEAR(k.tglbangun) AS tahun,k.statushukum,
				k.nopersil,k.ijinbangno,k.ijinbangtgl,k.gambarno,k.gambarmacam,k.gambarskala,k.gambarjumlah,
				k.nokibtanah,k.surat1,k.surat2,k.surat3,k.alamat,k.kelurahan,k.kecamatan,k.kotamadya,
				k.konskategori,k.konsatap,k.konskusen,k.konsrangka,k.konspondasi,k.konsdinding,k.konsplafon,
				k.konslantai,k.jumlahlantai,k.luaslantai,k.luasbangunan,k.luaslantai1,k.luaslantai2,k.luaslantai3,
				k.luaslantai4,k.luaslantai5,k.luaslantai6,k.luaslantai7,k.luaslantai8,
				k.caraperolehan,k.diperolehdari,k.hargasatuan,k.dasarharga,k.idsumberdana,k.mano,
				k.namapengurus,k.alamatpengurus,k.catpengisi,k.namapetugas,k.jabatanpetugas,k.tgldisetujui,
				k.namapetugas2,k.jabatanpetugas2,k.tgldiisi
				FROM as_kib k
				INNER JOIN as_transaksi t ON t.idtransaksi = k.idtransaksi
				INNER JOIN as_ms_barang b ON b.idbarang = t.idbarang
				INNER JOIN as_ms_unit u ON u.idunit = t.idunit
				LEFT JOIN as_ms_sumberdana s ON s.idsumberdana = k.idsumberdana
				WHERE LEFT(b.kodebarang,2) = 03 AND k.id_kib AND k.id_kib = '".$id_kib."'";
	$dtgdg = mysql_query($sqlgdg);
	$rwgdg = mysql_fetch_array($dtgdg);
	
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
			<button class="Enabledbutton" id="backbutton" type="button" onClick="location='gedung.php'" title="Back" style="cursor:pointer">
        			<img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                		Back to List
            </button>
	  		<button class="Enabledbutton" id="btnSimpan" name="btnSimpan" onclick="document.getElementById('act').value='save';form1.submit()" title="Save" style="cursor:pointer">
      			<img  src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Save Record
			</button>
            <button class="Disabledbutton" id="undobutton" disabled="true" onClick="location='editGedung.php'" title="Cancel / Refresh" style="cursor:pointer">
                	<img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
      					Undo/Refresh
            </button></td>
	</tr>	 
		 <tr>
		<td colspan="2" class="header">.: Kartu Inventaris Barang : Gedung Dan Bangunan :. (Edit Mode)</td>
	  </tr>
	  <tr>
		<td width="40%" class="label">&nbsp;Unit Kerja</td>
		<td width="60%" class="content">&nbsp;<input id="txtkodeunit" name="txtkodeunit" value="<?php echo $rwgdg['kodeunit']; ?>" style="background-color:#99FFFF;" size="24"/></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Kode Barang - Seri</td>
		<td class="content">&nbsp;<input id="txtkodebarang" name="txtkodebarang" value="<?php echo $rwgdg['kodebarang'];?>" size="24" style="background-color:#99FFFF;"/></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Nama Barang</td>
		<td class="content">&nbsp;<input id="txtnamabarang" name="txtnamabarang" value="<?php echo $rwgdg['namabarang'];?>" size="50" style="background-color:#99FFFF;" /></td>
	  </tr>
	  <tr>
		<td colspan="2" class="header2">&nbsp;I. UNIT BARANG</td>
		</tr>
	  <tr>
	  	<td class="label">&nbsp;Jenis Bangunan</td>
		<td class="content">&nbsp;<select id="cmbjenisbang" name="cmbjenisbang">
			<option <?php if($rwgdg['jenisbang'] == 1) echo 'selected'; ?> value="1">1 - Rumah Tinggal</option>
			<option <?php if($rwgdg['jenisbang'] == 2) echo 'selected'; ?> value="2">2 - Rumah Sementara</option>
			<option <?php if($rwgdg['jenisbang'] == 3) echo 'selected'; ?> value="3">3 - Wisma</option>
			<option <?php if($rwgdg['jenisbang'] == 4) echo 'selected'; ?> value="4">4 - Asrama</option>
			<option <?php if($rwgdg['jenisbang'] == 5) echo 'selected'; ?> value="5">5 - Mess</option>
			</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Tipe Bangunan</td>
		<td class="content">&nbsp;<select id="cmbtipebang" name="cmbtipebang">
			<option <?php if($rwgdg['tipebang'] == 1) echo 'selected'; ?> value="1">1 - A</option>
			<option <?php if($rwgdg['tipebang'] == 2) echo 'selected'; ?> value="2">2 - B</option>
			<option <?php if($rwgdg['tipebang'] == 3) echo 'selected'; ?> value="3">3 - C</option>
			<option <?php if($rwgdg['tipebang'] == 4) echo 'selected'; ?> value="4">4 - D</option>
			<option <?php if($rwgdg['tipebang'] == 5) echo 'selected'; ?> value="5">5 - E</option>
			</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Golongan</td>
		<td class="content">&nbsp;<select id="cmbgolbang" name="cmbgolbang">
			<option <?php if($rwgdg['golbang'] == 1) echo 'selected'; ?> value="1">1 - I</option>
			<option <?php if($rwgdg['golbang'] == 2) echo 'selected'; ?> value="2">2 - II</option>
			<option <?php if($rwgdg['golbang'] == 3) echo 'selected'; ?> value="3">3 - III</option>
			</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Kelas</td>
		<td class="content">&nbsp;<select id="cmbkelasbang" name="cmbkelasbang">
			<option <?php if($rwgdg['kelasbang'] == 1) echo 'selected'; ?> value="1">1 - IA</option>
			<option <?php if($rwgdg['kelasbang'] == 2) echo 'selected'; ?> value="2">2 - I</option>
			<option <?php if($rwgdg['kelasbang'] == 3) echo 'selected'; ?> value="3">3 - II</option>
			<option <?php if($rwgdg['kelasbang'] == 4) echo 'selected'; ?> value="4">4 - III</option>
			<option <?php if($rwgdg['kelasbang'] == 5) echo 'selected'; ?> value="5">5 - IV</option>
			</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Kondisi Bangunan</td>
		<td class="content">&nbsp;<select id="cmbkondisibangunan" name="cmbkondisibangunan">
			<option value="1">1 - Baik</option>
			<option value="2">2 - Rusak Ringan</option>
			<option value="4">3 - Rusak Berat</option>
			<option value="4">4 - Tidak Berfungsi</option>
			</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Tahun Bangun</td>
		<td class="content">&nbsp;<input id="txttahun" name="txttahun" value="<?php echo $rwgdg['tahun'];?>" size="16" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Status Tanah</td>
		<td class="content">&nbsp;<select id="cmbstatushukum" name="cmbstatushukum">
			<option <?php if($rwgdg['statushukum'] == 1) echo 'selected'; ?> value="1">1 - Hak Guna Usaha</option>
			<option <?php if($rwgdg['statushukum'] == 2) echo 'selected'; ?> value="2">2 - Hak Milik</option>
			<option <?php if($rwgdg['statushukum'] == 3) echo 'selected'; ?> value="3">3 - Hak Guna Bangunan</option>
			<option <?php if($rwgdg['statushukum'] == 4) echo 'selected'; ?> value="4">4 - Hak Pakai</option>
			<option <?php if($rwgdg['statushukum'] == 5) echo 'selected'; ?> value="5">5 - Hak Sewa untuk Bangunan</option>
			<option <?php if($rwgdg['statushukum'] == 6) echo 'selected'; ?> value="6">6 - Hak Membuka Tanah</option>
			<option <?php if($rwgdg['statushukum'] == 7) echo 'selected'; ?> value="7">7 - Hak Sewa Tanah Pertanian</option>
								</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;No. Persil</td>
		<td class="content">&nbsp;<input id="txtnopersil" name="txtnopersil" value="<?php echo $rwgdg['nopersil'];?>" size="50" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Ijin Bangunan No</td>
		<td class="content">&nbsp;<input id="txtijinbangno" name="txtijinbangno" size="50" value="<?php echo $rwgdg['ijinbangno'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Ijin Bangunan Tgl</td>
		<td class="content">&nbsp;<input id="txtijinbangtgl" name="txtijinbangtgl" size="24" value="<?php echo $rwgdg['ijinbangtgl'];?>" class="txtunedited" readonly readonly />
			<img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtijinbangtgl'),depRange);"> 
			<font size=1 color=gray><i>(dd-mm-yyyy)</i></font></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Gambar No</td>
		<td class="content">&nbsp;<input id="txtgambarno" name="txtgambarno" size="50" value="<?php echo $rwgdg['gambarno'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Gambar Macam</td>
		<td class="content">&nbsp;<input id="txtgambarmacam" name="txtgambarmacam" size="50" value="<?php echo $rwgdg['gambarmacam'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Gambar Skala</td>
		<td class="content">&nbsp;<input id="txtgambarskala" name="txtgambarskala" size="50" value="<?php echo $rwgdg['gambarskala'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Gambar Jumlah</td>
		<td class="content">&nbsp;<input id="txtgambarjumlah" name="txtgambarjumlah" size="50" value="<?php echo $rwgdg['gambarjumlah'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Nomor KIB Tanah</td>
		<td class="content">&nbsp;<input id="txtnokibtanah" name="txtnokibtanah" size="50" value="<?php echo $rwgdg['nokibtanah'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Surat-Surat 1</td>
		<td class="content">&nbsp;<input id="txtsurat1" name="txtsurat1" size="60" value="<?php echo $rwgdg['surat1'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Surat-Surat 2</td>
		<td class="content">&nbsp;<input id="txtsurat2" name="txtsurat2" size="60" value="<?php echo $rwgdg['surat2'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Surat-Surat 3</td>
		<td class="content">&nbsp;<input id="txtsurat3" name="txtsurat3" size="60" value="<?php echo $rwgdg['surat3'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Alamat</td>
		<td class="content">&nbsp;<input id="txtalamat" name="txtalamat" size="60" value="<?php echo $rwgdg['alamat'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Kelurahan</td>
		<td class="content">&nbsp;<input id="txtkelurahan" name="txtkelurahan" size="50" value="<?php echo $rwgdg['kelurahan'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Kecamatan</td>
		<td class="content">&nbsp;<input id="txtkecamatan" name="txtkecamatan" size="50" value="<?php echo $rwgdg['kecamatan'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Kab/Kodya</td>
		<td class="content">&nbsp;<input id="txtkotamadya" name="txtkotamadya" size="50" value="<?php echo $rwgdg['kotamadya'];?>" /></td>
	  </tr>
	  <tr>
		<td colspan="2" class="header2">&nbsp;II. KONSTRUKSI</td>
		</tr>
	  <tr>
	  	<td class="label">&nbsp;Kategori</td>
		<td class="content">&nbsp;<select id="cmbkonskategori" name="cmbkonskategori">
				<option <?php if($rwgdg['konskategori'] == 1) echo 'selected'; ?> value="1">1 - Permanen</option>
				<option <?php if($rwgdg['konskategori'] == 2) echo 'selected'; ?> value="2">2 - Semi Permanen</option>
				<option <?php if($rwgdg['konskategori'] == 3) echo 'selected'; ?> value="3">3 - Darurat</option>
			</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Atap</td>
		<td class="content">&nbsp;<select id="cmbkonsatap" name="cmbkonsatap">
				<option <?php if($rwgdg['konsatap'] == 1) echo 'selected'; ?> value="1">1 - Beton</option>
				<option <?php if($rwgdg['konsatap'] == 2) echo 'selected'; ?> value="2">2 - Seng</option>
				<option <?php if($rwgdg['konsatap'] == 3) echo 'selected'; ?> value="3">3 - Asbes</option>
				<option <?php if($rwgdg['konsatap'] == 4) echo 'selected'; ?> value="4">4 - Sirap</option>
				<option <?php if($rwgdg['konsatap'] == 5) echo 'selected'; ?> value="5">5 - Genteng</option>
				<option <?php if($rwgdg['konsatap'] == 6) echo 'selected'; ?> value="6">6 - Lainnya</option>
			</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Kusen</td>
		<td class="content">&nbsp;<select id="cmbkonskusen" name="cmbkonskusen">
				<option <?php if($rwgdg['konskusen'] == 1) echo 'selected'; ?> value="1">1 - Kayu</option>
				<option <?php if($rwgdg['konskusen'] == 2) echo 'selected'; ?> value="2">2 - Alumunium</option>
				<option <?php if($rwgdg['konskusen'] == 3) echo 'selected'; ?> value="3">3 - Lainnya</option>
			</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Rangka</td>
		<td class="content">&nbsp;<select id="cmbkonsrangka" name="cmbkonsrangka">
			<option <?php if($rwgdg['konsrangka'] == 1) echo 'selected'; ?> value="1">1 - Besi</option>
			<option <?php if($rwgdg['konsrangka'] == 2) echo 'selected'; ?> value="2">2 - Kayu Lapis</option>
			<option <?php if($rwgdg['konsrangka'] == 3) echo 'selected'; ?> value="3">3 - Beton</option>
			<option <?php if($rwgdg['konsrangka'] == 4) echo 'selected'; ?> value="4">4 - Lainnya</option>
			</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Pondasi</td>
		<td class="content">&nbsp;<select id="cmbkonspondasi" name="cmbkonspondasi">
			<option <?php if($rwgdg['konspondasi'] == 1) echo 'selected'; ?> value="1">1 - Beton</option>
			<option <?php if($rwgdg['konspondasi'] == 2) echo 'selected'; ?> value="2">2 - Batu Kali</option>
			<option <?php if($rwgdg['konspondasi'] == 3) echo 'selected'; ?> value="3">3 - Tiang Pancang</option>
			<option <?php if($rwgdg['konspondasi'] == 4) echo 'selected'; ?> value="4">4 - Lainnya</option>
			</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Dinding</td>
		<td class="content">&nbsp;<select id="cmbkonsdinding" name="cmbkonsdinding">
			<option <?php if($rwgdg['konsdinding'] == 1) echo 'selected'; ?> value="1">1 - Kayu</option>
			<option <?php if($rwgdg['konsdinding'] == 2) echo 'selected'; ?> value="2">2 - Tembok</option>
			<option <?php if($rwgdg['konsdinding'] == 3) echo 'selected'; ?> value="3">3 - Bambu</option>
			<option <?php if($rwgdg['konsdinding'] == 4) echo 'selected'; ?> value="4">4 - Lainnya</option>
			</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Plafon</td>
		<td class="content">&nbsp;<select id="cmbkonsplafon" name="cmbkonsplafon">
				<option <?php if($rwgdg['konsplafon'] == 1) echo 'selected'; ?> value="1">1 - Beton</option>
				<option <?php if($rwgdg['konsplafon'] == 2) echo 'selected'; ?> value="2">2 - Kayu</option>
				<option <?php if($rwgdg['konsplafon'] == 3) echo 'selected'; ?> value="3">3 - Bambu</option>
				<option <?php if($rwgdg['konsplafon'] == 4) echo 'selected'; ?> value="4">4 - Asbes</option>
				<option <?php if($rwgdg['konsplafon'] == 5) echo 'selected'; ?> value="5">5 - Akustik</option>
				<option <?php if($rwgdg['konsplafon'] == 6) echo 'selected'; ?> value="6">6 - Lainnya</option>
			</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Lantai</td>
		<td class="content">&nbsp;<select id="cmbkonslantai" name="cmbkonslantai">
				<option <?php if($rwgdg['konslantai'] == 1) echo 'selected'; ?> value="1">1 - Tegel</option>
				<option <?php if($rwgdg['konslantai'] == 2) echo 'selected'; ?> value="2">2 - Flur</option>
				<option <?php if($rwgdg['konslantai'] == 3) echo 'selected'; ?> value="3">3 - Bambu</option>
				<option <?php if($rwgdg['konslantai'] == 4) echo 'selected'; ?> value="4">4 - Teraso</option>
				<option <?php if($rwgdg['konslantai'] == 5) echo 'selected'; ?> value="5">5 - Keramik</option>
				<option <?php if($rwgdg['konslantai'] == 6) echo 'selected'; ?> value="6">6 - Lainnya</option>
			</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Jumlah Lantai</td>
		<td class="content">&nbsp;<input id="txtjumlahlantai" name="txtjumlahlantai" size="16" value="<?php echo $rwgdg['jumlahlantai'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Luas Lantai Total</td>
		<td class="content">&nbsp;<input id="txtluaslantai" name="txtluaslantai" size="24" value="<?php echo $rwgdg['luaslantai'];?>" />&nbsp;m2</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Luas Bangunan Total</td>
		<td class="content">&nbsp;<input id="txtluasbangunan" name="txtluasbangunan" size="24" value="<?php echo $rwgdg['luaslantai'];?>" />&nbsp;m2</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Luas Lt 1</td>
		<td class="content">&nbsp;<input id="txtluaslantai1" name="txtluaslantai1" size="24" value="<?php echo $rwgdg['luaslantai'];?>" />&nbsp;m2</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Luas Lt 2</td>
		<td class="content">&nbsp;<input id="txtluaslantai2" name="txtluaslantai2" size="24" value="<?php echo $rwgdg['luaslantai'];?>" />&nbsp;m2</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Luas Lt 3</td>
		<td class="content">&nbsp;<input id="txtluaslantai3" name="txtluaslantai3" size="24" value="<?php echo $rwgdg['luaslantai'];?>" />&nbsp;m2</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Luas Lt 4</td>
		<td class="content">&nbsp;<input id="txtluaslantai4" name="txtluaslantai4" size="24" value="<?php echo $rwgdg['luaslantai'];?>" />&nbsp;m2</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Luas Lt 5</td>
		<td class="content">&nbsp;<input id="txtluaslantai5" name="txtluaslantai5" size="24" value="<?php echo $rwgdg['luaslantai'];?>" />&nbsp;m2</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Luas Lt 6</td>
		<td class="content">&nbsp;<input id="txtluaslantai6" name="txtluaslantai6" size="24" value="<?php echo $rwgdg['luaslantai'];?>" />&nbsp;m2</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Luas Lt 7</td>
		<td class="content">&nbsp;<input id="txtluaslantai7" name="txtluaslantai7" size="24" value="<?php echo $rwgdg['luaslantai'];?>" />&nbsp;m2</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Luas Lt 8</td>
		<td class="content">&nbsp;<input id="txtluaslantai8" name="txtluaslantai8" size="24" value="<?php echo $rwgdg['luaslantai'];?>" />&nbsp;m2</td>
	  </tr>
	  <tr>
	  	<td colspan="2" class="header2">&nbsp;III. PENGADAAN</td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Cara Perolehan</td>
		<td class="content">&nbsp;<select id="cmbcaraperolehan" name="cmbcaraperolehan">
				<option <?php if($rwgdg['caraperolehan'] == 1) echo 'selected'; ?> value="1">1 - dibeli</option>
				<option <?php if($rwgdg['caraperolehan'] == 2) echo 'selected'; ?> value="2">2 - hibah</option>
				<option <?php if($rwgdg['caraperolehan'] == 3) echo 'selected'; ?> value="3">3 - dll</option>
			</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Diperoleh Dari</td>
		<td class="content">&nbsp;<input id="txtdiperolehdari" name="txtdiperolehdari" size="50" value="<?php echo $rwgdg['diperolehdari'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Kondisi Perolehan</td>
		<td class="content">&nbsp;<select>
				<option value="1">1 - Baik</option>
				<option value="2">2 - Rusak Ringan</option>
				<option value="3">3 - Rusak Berat</option>
				<option value="4">4 - Tidak Berfungsi</option>
			</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Harga</td>
		<td class="content">&nbsp;<input id="txthargasatuan" name="txthargasatuan" size="24" value="<?php echo $rwgdg['hargasatuan'];?>" /></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Dasar Harga</td>
		<td class="content">&nbsp;<select id="cmbdasarharga" name="cmbdasarharga">
				<option <?php if($rwgdg['dasarharga'] == 1) echo 'selected'; ?> value="1">1 - Pemborongan</option>
				<option <?php if($rwgdg['dasarharga'] == 2) echo 'selected'; ?> value="2">2 - Taksiran</option>
				</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;Mata Anggaran</td>
		<td class="content">&nbsp;<select name="cmbsumberdana" id="cmbsumberdana">
								<?php
								  $sqlsd=mysql_query("SELECT idsumberdana,keterangan FROM as_ms_sumberdana");
								  while($showsd=mysql_fetch_array($sqlsd)){
								  ?>
								<option <?php if($rwgdg['sumberdana'] == $showsd['idsumberdana']) echo 'selected';?> value="<?=$showsd['idsumberdana'];?>"><?=$showsd['keterangan'];?></option>
								<?php } ?>
								</select></td>
	  </tr>
	  <tr>
	  	<td class="label">&nbsp;No MA</td>
		<td class="content">&nbsp;<input id="txtmano" name="txtmano" size="50" value="<?php echo $rwgdg['mano'];?>" /></td>
	  </tr>
		  <tr>
			<td colspan="2" class="header2">&nbsp;IV. PENGURUS BARANG</td>
		  </tr>
		  <tr>
			<td class="label">&nbsp;Nama/Jabatan</td>
			<td class="content">&nbsp;<input id="txtnamapengurus" name="txtnamapengurus" value="<?php echo $rwgdg['namapengurus'];?>" size="50" /></td>
		  </tr>
		  <tr>
			<td class="label">&nbsp;Alamat</td>
			<td class="content">&nbsp;<input id="txtalamatpengurus" name="txtalamatpengurus" value="<?php echo $rwgdg['alamatpengurus'];?>" size="50" /></td>
		  </tr>
		  <tr>
			<td colspan="2" class="header2">&nbsp;V. BAGIAN-BAGIAN LAIN/PERLENGKAPAN</td>
		  </tr>
		  <tr>
			<td class="label">&nbsp;Catatan Perlengkapan</td>
			<td class="content">&nbsp;<textarea id="txtcatperlengkapan" name="txtcatperlengkapan" cols="50"></textarea></td>
		  </tr>
		  <tr>
			<td class="label">&nbsp;Catatan Pengisi</td>
			<td class="content">&nbsp;<textarea id="txtcatpengisi" name="txtcatpengisi" cols="50"><?php echo $rwgdg['catpengisi'];?></textarea></td>
		  </tr>
		  <tr>
			<td colspan="2" class="header2">&nbsp;DISETUJUI OLEH</td>
		  </tr>
		  <tr>
			<td class="label">&nbsp;Nama</td>
			<td class="content">&nbsp;<input id="txtnamapetugas" name="txtnamapetugas" value="<?php echo $rwgdg['namapetugas'];?>" size="50" /></td>
		  </tr>
		  <tr>
			<td class="label">&nbsp;Jabatan</td>
			<td class="content">&nbsp;<input id="txtjabatanpetugas" name="txtjabatanpetugas" size="50" value="<?php echo $rwgdg['jabatanpetugas'];?>" /></td>
		  </tr>
		  <tr>
			<td class="label">&nbsp;Tanggal</td>
			<td class="content">&nbsp;<input id="txttgldisetujui" name="txttgldisetujui" value="<?php echo $rwgdg['tgldisetujui'];?>" size="24" class="txtunedited" readonly readonly />
			<img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txttgldisetujui'),depRange);"> 
			<font size=1 color=gray><i>(dd-mm-yyyy)</i></font></td>
		  </tr>
		  <tr>
			<td colspan="2" class="header2">&nbsp;DIISI OLEH</td>
		  </tr>
		  <tr>
			<td class="label">&nbsp;Nama</td>
			<td class="content">&nbsp;<input id="txtnamapetugas2" name="txtnamapetugas2" value="<?php echo $rwgdg['namapetugas2'];?>" size="50" /></td>
		  </tr>
		  <tr>
			<td class="label">&nbsp;Jabatan</td>
			<td class="content">&nbsp;<input id="txtjabatanpetugas2" name="txtjabatanpetugas2" size="50" value="<?php echo $rwgdg['jabatanpetugas2'];?>" /></td>
		  </tr>
		  <tr>
			<td class="label">&nbsp;Tanggal</td>
			<td class="content">&nbsp;<input id="txttgldiisi" name="txttgldiisi" value="<?php echo $rwgdg['tgldiisi'];?>" size="24" class="txtunedited" readonly readonly />
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
</html>
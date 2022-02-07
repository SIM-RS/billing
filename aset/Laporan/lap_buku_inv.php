<?php
session_start();
$jml = 0;
function indonesian_date ($timestamp = '', $date_format = ' j F Y', $suffix = '') {
	if (trim ($timestamp) == '')
	{
			$timestamp = time ();
	}
	elseif (!ctype_digit ($timestamp))
	{
		$timestamp = strtotime ($timestamp);
	}
	# remove S (st,nd,rd,th) there are no such things in indonesia :p
	$date_format = preg_replace ("/S/", "", $date_format);
	$pattern = array (
		'/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
		'/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
		'/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
		'/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
		'/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
		'/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
		'/April/','/June/','/July/','/August/','/September/','/October/',
		'/November/','/December/',
	);
	$replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
		'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
		'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
		'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
		'Oktober','November','Desember',
	);
	$date = date ($date_format, $timestamp);
	$date = preg_replace ($pattern, $replace, $date);
	$date = "{$date} {$suffix}";
	return $date;
} 
// is valid users
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
$r_formatlap = $_POST["formatlap"];
$alphabet=array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");

switch ($r_formatlap) {
	case "XLS" :
			Header("Content-Type: application/vnd.ms-excel");
			header('Content-Disposition: attachment; filename="Laporan_Buku_Inventaris_'.date('d-m-Y').'.xls"');
			break;
	case "WORD" :
			Header("Content-Type: application/msword");
			header('Content-Disposition: attachment; filename="Laporan_Buku_Inventaris_'.date('d-m-Y').'.doc"');
			break;
	default :
			Header("Content-Type: text/html");
			break;
}
$r_formatlap = $_REQUEST['jenislap'];

 if (isset($_POST["submit"])) {
 	$r_cmbperolehan = $_POST["cmbperolehan"];
/*	if ($r_cmbperolehan=="1"){
	 	$strTGL="select min(tgltransaksi) as awal,max(tgltransaksi) as akhir from as_transaksi";
		$rsTGL=mysql_query($strTGL);
		if ($rowTGL = mysql_fetch_array($rsTGL)){
			$r_tglawal=$rowTGL["awal"];
			$r_tglakhir=$rowTGL["akhir"];
		}
	}else{*/
		$r_tglawal = tglSQL($_POST["tglawal"]);
		$r_tglakhir = tglSQL($_POST["tglakhir"]);
	//}
	$r_idunit = $_POST["idunit"];
	$r_kodeunit = $_POST["kodeunit"];
	$rkodeunit=$r_kodeunit;
	//echo $r_idunit."<br />";
	$strUnit="select * from as_ms_unit where idunit=$r_idunit";
	$rsUnit=mysql_query($strUnit);
	//if ($rowUnit = mysql_fetch_array($rsUnit))
                //$r_namaunit=$rowUnit["namaunit"];
        
	if ($_POST['cmb_buku_inv']=="1")
            $label="BUKU INVENTARIS";
        else
            $label="REKAPITULASI BUKU INVENTARIS";
  }
?>
<html>
<head>
<title>Laporan Buku Inventaris</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php if($r_formatlap != 'XLS' && $r_formatlap != 'WORD'){ ?>
	<link href="../theme/report.css" rel="stylesheet" type="text/css" />
<?php } ?>
</head>
<body>
<p align="center"><strong><font size="3" face="Times New Roman, Times, serif"><?php echo $label; ?></font></strong></p>
<?php
	$strSetting="select * from as_setting";
	$rsSetting=mysql_query($strSetting);
	$r_kodepropinsi=13;
	$r_kodepemda=26;
	$r_namapropinsi="JAWA TIMUR";
	$r_namapemda="Sidoarjo";
	if ($rowSetting = mysql_fetch_array($rsSetting)){
		$r_kodepropinsi=$rowSetting["kodepropinsi"];
		$r_kodepemda=$rowSetting["kodekota"];
		$r_namapropinsi=$rowSetting["namapropinsi"];
		$r_namapemda=$rowSetting["namakota"];
	}

	//echo $r_tglakhir."<br />";
	$jmlth = substr($r_tglakhir,0,4)-substr($r_tglawal,0,4);
	//echo $jmlth;

for ($jm=0;$jm<=$jmlth;$jm++){
	if ($jm==$jmlth){
		if ($jmlth==0){
			$awl=$r_tglawal;
			$akhr=$r_tglakhir;
		}else{
			$awl=(substr($akhr,0,4)+1)."-01-01";
			$akhr=$r_tglakhir;
		}
	}else{
		if ($jm==0){
			$awl=$r_tglawal;
			$akhr=substr($awl,0,4)."-12-31";
		}else{
			$awl=(substr($akhr,0,4)+1)."-01-01";
			$akhr=substr($awl,0,4)."-12-31";
		}
	}
	$flt="tgltransaksi between '$awl' and '$akhr'";
	//echo $flt."<br />";
	$th = substr($awl,2,2);

		if ($r_kodeunit=="0") $r_kodeunit ="00.00.00";
		if (strlen($r_kodeunit)==2) $r_kodeunit .=".00.00";
		elseif (strlen($r_kodeunit)==5) $r_kodeunit .=".00";
		$r_unit=$r_kodeunit;
                $r_kodeunit="12.".$r_kodepropinsi.".".$r_kodepemda.".".substr($r_kodeunit,0,6).$th.substr($r_kodeunit,5,3);
	//	echo $r_kodeunit;
		switch ($_POST['cmb_buku_inv']) {
			case "1" :		// BUKU INVENTARIS
			?>
<table border=0 cellpadding="0" cellspacing="0" width="1100">
  <tr>
	<td width="130"><strong>SKPD</strong></td>
	<td width="700"><strong>&nbsp;:&nbsp;<?php echo $rowSetting["namadepartemen"]; ?></strong></td>
	<td width="320">&nbsp;</td>
  </tr>
  <tr>
	<td><strong>KABUPATEN</strong></td>
	<td><strong>&nbsp;:&nbsp;<?php echo $rowSetting["namakota"]; ?></strong></td>	<td>&nbsp;</td>
  </tr>
  <tr>
	<td><strong>PROPINSI</strong></td>
	<td><strong>&nbsp;:&nbsp;<?php echo $rowSetting["namapropinsi"]; ?></strong></td>
	<td><strong>&nbsp;</strong></td>
  </tr>
</table>
<br />
<table border=1 cellspacing="0" cellpadding="4" class="GridStyle" width="1100">
  <tr align="center" valign="top" bordercolor="#000000" bgcolor="#CCCCCC" height=15 class="HeaderBW">
    <td height="22" colspan="3" valign="middle"><font size="-2"> NOMOR</font></td>
    <td colspan="3" valign="middle"> SPESIFIKASI BARANG<font size="-2">&nbsp;</font></td>
    <td width="70" rowspan="2" valign="middle"><font size="-2">Bahan</font></td>
    <td width="70" rowspan="2" valign="middle"><font size="-2"> Asal/Cara<br>
      Perolehan<br>
      Barang</font></td>
    <td width="40" rowspan="2" valign="middle"><font size="-2"> Tahun<br>
      Perolehan</font></td>
    <td width="50" rowspan="2" valign="middle"><font size="-2"> Ukuran<br>
      Barang/<br />
      Konstruksi<br>
      (P, S, D)</font></td>
    <td width="60" rowspan="2" valign="middle"><font size="-2"> Satuan</font></td>
    <td width="50" rowspan="2" valign="middle"><font size="-2"> Keadaan<br>
      Barang<br>(B, KB, RB)</font></td>
    <td colspan="2" valign="middle"><font size="-2"> JUMLAH</font></td>
    <td rowspan="2" valign="middle"><font size="-2"> Keterangan</font></td>
  </tr>
  <tr align="center" valign="top" bordercolor="#000000" bgcolor="#CCCCCC" height=15 class="HeaderBW">
    <td width="40" valign="middle"><font size="-2"> No<br>
      Urut</font></td>
    <td width="82" valign="middle"><font size="-2"> Kode<br>
      Barang</font></td>
    <td width="30" height="22" valign="middle"><font size="-2">Register</font></td>
    <td width="150" valign="middle">Nama/Jenis Barang</td>
    <td width="70" valign="middle"><font size="-2">Merk/Type</font></td>
    <td width="100" valign="middle"><font size="-2">No. Sertifikat<br>
      No. Pabrik<br>
      No. Chasis<br>
      No. Mesin</font></td>
    <td width="55" valign="middle"><font size="-2"> Barang</font></td>
    <td width="110" valign="middle"><font size="-2"> Harga<br>
      (Rp)</font></td>
  </tr>
  <tr align="center" valign="top" bgcolor="#FFFFCC" height=15 class="SubHeaderBW">
    <td height="10"><font size="-2">1</font></td>
    <td height="10"><font size="-2">2</font></td>
    <td height="10"><font size="-2">3</font></td>
    <td height="10"><font size="-2">4</font></td>
    <td height="10"><font size="-2">5</font></td>
    <td height="10"><font size="-2">6</font></td>
    <td height="10"><font size="-2">7</font></td>
    <td height="10"><font size="-2">8</font></td>
    <td height="10"><font size="-2">9</font></td>
    <td height="10"><font size="-2">10</font></td>
    <td height="10"><font size="-2">11</font></td>
    <td height="10"><font size="-2">12</font></td>
    <td height="10"><font size="-2">13</font></td>
    <td height="10"><font size="-2">14</font></td>
    <td height="10"><font size="-2">15</font></td>
  </tr>
  <?php
				if ($rkodeunit=="0")
				$strSQL = "SELECT mb.kodebarang,s.idseri,s.noseri, mb.namabarang,s.asalusul,s.thn_pengadaan,mb.idsatuan,s.harga_perolehan,s.kondisi
FROM as_ms_barang mb INNER JOIN as_seri2 s ON mb.idbarang=s.idbarang
WHERE ISNULL(s.tgl_hapus) AND mb.tipe=1 ORDER BY mb.kodebarang,s.noseri";
                                   // $strSQL="select kodeunit,namapanjang,namabarang,kodebarang,noseri,k.merk,bahan,tgltransaksi,tahunperolehan,suratsertifikat,nopabrik,nomesin,caraperolehan as asalusul,konskategori,t.idsatuan,keadaanalat,hargasatuan,catpengisi as ket from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit inner join as_kib k on t.idtransaksi=k.idtransaksi inner join as_ms_barang b on t.idbarang=b.idbarang inner join as_seri s on t.idtransaksi=s.idtransaksi where $flt and b.tipe=1 order by id_kib,noseri";
				else
				$strSQL = "SELECT mb.kodebarang,s.idseri,s.noseri, mb.namabarang,s.asalusul,s.thn_pengadaan,mb.idsatuan,s.harga_perolehan,s.kondisi
FROM as_ms_barang mb INNER JOIN as_seri2 s ON mb.idbarang=s.idbarang
WHERE ISNULL(s.tgl_hapus) AND mb.tipe=1 ORDER BY mb.kodebarang,s.noseri";
                                   // $strSQL="select kodeunit,namapanjang,namabarang,kodebarang,noseri,k.merk,bahan,tgltransaksi,tahunperolehan,suratsertifikat,nopabrik,nomesin,caraperolehan as asalusul,konskategori,t.idsatuan,keadaanalat,hargasatuan,catpengisi as ket from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit inner join as_kib k on t.idtransaksi=k.idtransaksi inner join as_ms_barang b on t.idbarang=b.idbarang inner join as_seri s on t.idtransaksi=s.idtransaksi where $flt and substring(kodeunit,1,".strlen($rkodeunit).")='$rkodeunit' and b.tipe=1 order by id_kib,noseri";
				//echo $strSQL."<br />";
				$rs = mysql_query($strSQL);
				if(mysql_affected_rows() > 0) {

				  	// Iterating through record
				  	$j = 0;
				  	$totalharga=0;
					while($rows = mysql_fetch_array($rs)) {
						if(substr($rows["kodebarang"],0,2)=="02"){
								$qw = mysql_query("select merk,ukuran,bahan,no_pabrik,no_rangka,no_mesin,no_polisi,no_bpkb,ket from kib02 where idseri ='".$rows["idseri"]."'");
								$msn = mysql_fetch_array($qw);							
							}
						if ($j % 2) $rowStyle = "NormalBG";  else $rowStyle = "AlternateBG";
						$j++;
						$totalharga +=$rows["harga_perolehan"];
  ?>
  <tr class="<?php echo $rowStyle ?>" valign="top">
    <td align="center"><?php echo $j ?></td>
    <td align="center"><?php echo $rows["kodebarang"]; ?></td>
    <td align="center"><?php echo str_pad($rows["noseri"], 4, "0", STR_PAD_LEFT); ?></td>
    <td align="left"><?php echo $rows["namabarang"]; ?></td>
    <td align="center"><?php echo $msn["merk"]; ?></td>
    <td align="center"><font size=1>
      <?php
      
	  for($r=3;$r<8;$r++){
				if($msn[$r]!=''){
						
							if($r== 3)
							echo "No Pabrik : ".$msn[$r]."<br>";
							//break;
							if($r== 4)
							echo "No Rangka : ".$msn[$r]."<br>";
							//break;
							if($r== 5)
							echo "No Mesin : ".$msn[$r]."<br>";
							//break;
							if($r== 6)
							echo "No Polisi : ".$msn[$r]."<br>";
						//	break;
							if($r== 7)
							echo "No Bpkb : ".$msn[$r]."<br>";
							//break;
							} 					
					  	
	  	}
	  ?>
      </font></td>
    <td align="center" class="<?php echo $cellStyle ?>">
      <?php echo $msn["bahan"]; ?>
    </td>
    <td align="center" class="<?php echo $cellStyle ?>">
      <?php
	  if (substr($rows["asalusul"],0,2)=="01"){
		  switch ($rows["asalusul"]) {
			  case 1 : echo "Pembelian"; break;
			  case 2 : echo "Hibah"; break;
			  case 3 : echo "Pembebasan"; break;
			  case 4 : echo "Sebelum 1945"; break;
			  case 5 : echo "Tukar Menukar"; break;
			  case 6 : echo "Cara Lain"; break;
			  default : echo "Cara Lain"; break;
		  }
	  }
          else if (substr($rows["asalusul"],0,2)=="02"){
		  switch ($rows["asalusul"]) {
			  case 1 : echo "Hadiah"; break;
			  case 2 : echo "Beli"; break;
			  case 3 : echo "Dibuat"; break;
			  case 4 : echo "dll"; break;
			  default : echo "dll"; break;
		  }
	  }
          else{
	  		switch ($rows["asalusul"]) {
			  case 1 : echo "dibeli"; break;
			  case 2 : echo "hibah"; break;
			  case 3 : echo "dll"; break;
			  default : echo $rows["asalusul"]; break;
		  	}
	  }
	 // echo $rows["asalusul"]; 
	  ?>
    </td>
    <td align="center" class="<?php echo $cellStyle ?>"><?php echo $rows["thn_pengadaan"]; ?></td>
    <td align="center">
      <?php
	  switch ($rows["konskategori"]) {
	  case 1 : echo "P"; break;
 	  case 2 : echo "SP"; break;
	  case 3 : echo "D"; break;
	  }
          ?>
    </td>
    <td align="center"><?php echo $rows["idsatuan"]; ?></td>
    <td align="center">
      <?php
	  switch ($rows["kondisi"]) {
	  case 1 : echo "B"; break;
	  case 2 : echo "RR"; break;
 	  case 3 : echo "RB"; break;
 	  case 4 : echo "TB"; break;
 	  default: echo $rows["kondisi"]; break;
	  }
          ?>
    </td>
    <td align="center">
      1
    </td>
    <td align="right">
      <?php      
       echo number_format($rows["harga_perolehan"],0,",",".") ?>
    </td>
    <td align="left">
      <?php echo $rows["ket"]; ?>
    </td>
  </tr>
  <?php
  					} // end while
 ?>
  <tr>
    <td class="HeaderBW" colspan="2">&nbsp;</td>
    <td class="HeaderBW" colspan="10" align="left">J U M L A H ................................................................</td>
    <td class="HeaderBW">&nbsp;</td>
	<td align="right" class="HeaderBW">
      <?php echo number_format($totalharga,0,",","."); ?>
    </td>
    <td class="HeaderBW">&nbsp;</td>
  </tr>
</table>
<br />
<br />
<table width="1000" align="left" border="0" style="margin-left:50px">
<tr>
	<td colspan="4"><br /></td>
</tr>
<tr>
	<td width="70">&nbsp;</td>
	<td width="247" align="center"><strong>Mengetahui,</strong></td>
	<td width="750">&nbsp;</td>
	<td width="247" align="center"><strong>Sidoarjo, <?php echo indonesian_date(); ?></strong></td>
</tr>
<tr>
	<td width="70">&nbsp;</td>
	<td width="247"align="center"><strong>DIREKTUR RSUD </strong></td>
	<td width="750">&nbsp;</td>
	<td width="247" align="center"><strong>Pengurus Barang</strong></td>
</tr>
<tr>
	<td >&nbsp;</td>
	<td align="center"><strong>KABUPATEN SIDOARJO </strong></td>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="4"><p>&nbsp;</p>
    <p>&nbsp;</p></td>
</tr>
<?php 
$sqldirek=mysql_query("select * from as_setting");
$r=mysql_fetch_array($sqldirek);
?>
<tr>
	<td width="70">&nbsp;</td>
	<td width="247" align="center"><strong><?php echo $r['dir_nama'] ?></strong></td>
	<td width="750">&nbsp;</td>
	<td width="247" align="center"><strong><?php echo $r['pengurus_nama'] ?></strong></td>
</tr>

<tr>
	<td width="70">&nbsp;</td>
	<td width="247" align="center" style="text-decoration: overline;"><strong>NIP.
    <?php echo $r['dir_nip'] ?></strong></td>
	<td width="750">&nbsp;</td>
	<td width="247" align="center" style="text-decoration: overline;"><strong>NIP.
    <?php echo $r['pengurus_nip'] ?></strong></td>
</tr>
</table>
<br /><br /><br /><br />
<?php
				} // end if
				break;
			case "2" :
			?>
<table border=0 cellpadding="0" cellspacing="0" width="1100">
  <tr>
	<td width="130"><strong>SKPD</strong></td>
	<td width="700"><strong>&nbsp;:&nbsp;
      <?php echo $r_unit; ?> - <?php echo $r_namaunit; ?>
      </strong></td>
	<td width="320">&nbsp;</td>
  </tr>
  <tr>
	<td><strong>KABUPATEN / KOTA</strong></td>
	<td><strong>&nbsp;:&nbsp;<?php echo $r_namapemda; ?></strong></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td><strong>PROPINSI</strong></td>
	<td><strong>&nbsp;:&nbsp;<?php echo $r_namapropinsi; ?></strong></td>
	<td><strong>KODE LOKASI : <?php echo $r_kodeunit; ?></strong></td>
  </tr>
</table>
<br />
<table border=1 cellspacing="0" cellpadding="4" class="GridStyle" width="1100">
  <tr align="center" valign="top" bordercolor="#000000" bgcolor="#CCCCCC" height=15 class="HeaderBW">
	<td width="40" valign="middle"><font size="-2">NO<br>
      URUT</font></td>
	<td width="60" valign="middle"><font size="-2">GOLONGAN</font></td>
	<td width="75" valign="middle"><font size="-2">KODE<br>BIDANG<br>BARANG</font></td>
	<td height="10" valign="middle"><font size="-2">NAMA BIDANG BARANG</font></td>
	<td width="82" valign="middle"><font size="-2">JUMLAH BARANG</font></td>
	<td width="130" valign="middle"><font size="-2">JUMLAH HARGA</font></td>
	<td width="100" valign="middle"><font size="-2">KETERANGAN</font></td>
  </tr>
  <tr align="center" valign="top" bgcolor="#FFFFCC" height=15 class="SubHeaderBW">
	<td height="10"><font size="-2">1</font></td>
	<td height="10"><font size="-2">2</font></td>
	<td height="10"><font size="-2">3</font></td>
	<td height="10"><font size="-2">4</font></td>
	<td height="10"><font size="-2">5</font></td>
	<td height="10"><font size="-2">6</font></td>
	<td height="10"><font size="-2">7</font></td>
  </tr>
<?php

//				$strCheck="select t.idtransaksi from as_transaksi t inner join as_seri s on t.idtransaksi=s.idtransaksi where $flt and idunit=$r_idunit and s.void=0 and t.void=0";
				if ($rkodeunit=="0")
                                    $strCheck="select t.idtransaksi,kodeunit from as_transaksi t inner join as_seri s on t.idtransaksi=s.idtransaksi inner join as_ms_unit u on t.idunit=u.idunit where $flt and s.void=0 and t.void=0";
				else
                                    $strCheck="select t.idtransaksi,kodeunit from as_transaksi t inner join as_seri s on t.idtransaksi=s.idtransaksi inner join as_ms_unit u on t.idunit=u.idunit where $flt and substring(kodeunit,1,".strlen($rkodeunit).")='$rkodeunit' and s.void=0 and t.void=0";
				//echo $strCheck."<br />";
				$rsChk=mysql_query($strCheck);
				if(mysql_affected_rows() > 0){
	$strRkp="select * from as_ms_barang where level<3 and tipe=1 order by kodebarang";
	$rsRkp=mysql_query($strRkp);
	$j=0;
	$totalharga=0;
	while($rows = mysql_fetch_array($rsRkp)){
?>
  <tr class="<?php echo $rowStyle ?>" valign="top">
    <td align="center">
      <?php if ($rows["level"]==1){
	  		$j++;
			$item=0;
			echo $j;
		 }
	  ?>
    </td>
    <td align="center">
      <?php if ($rows["level"]==1){
			echo substr($rows["kodebarang"],0,2);
		 }
	  ?>
    </td>
    <td align="center">
      <?php if ($rows["level"]==2){
			echo substr($rows["kodebarang"],3,2);
		 }
	  ?>
    </td>
    <td align="left">
      <?php if ($rows["level"]==1){
	  		$brg=$rows["namabarang"];
			if(substr($brg,0,8)=='GOLONGAN') {
				echo substr($brg,8,strlen($brg)-8);
			}else{
				echo $brg;
			}
		 }else{
		 	$r_kodebrg=substr($rows["kodebarang"],0,5);
		 	$item++;
		 	echo $alphabet[$item-1].".&nbsp;&nbsp;&nbsp;&nbsp;".$rows["namabarang"];
			if ($rkodeunit=="0")
                            $strTotal="select sum(subtotal) as total,sum(qtytransaksi) as jmltotal from (select kodeunit,kodebarang,tgltransaksi,hargasatuan,qtytransaksi,hargasatuan*qtytransaksi as subtotal,b.tipe from as_transaksi t inner join as_ms_barang b on t.idbarang=b.idbarang inner join as_kib k on t.idtransaksi=k.idtransaksi inner join as_ms_unit u on u.idunit=t.idunit) as tmp where substring(kodebarang,1,5)='$r_kodebrg' and $flt and tmp.tipe=1 ";
			else
                            $strTotal="select sum(subtotal) as total,sum(qtytransaksi) as jmltotal from (select kodeunit,kodebarang,tgltransaksi,hargasatuan,qtytransaksi,hargasatuan*qtytransaksi as subtotal,b.tipe from as_transaksi t inner join as_ms_barang b on t.idbarang=b.idbarang inner join as_kib k on t.idtransaksi=k.idtransaksi inner join as_ms_unit u on u.idunit=t.idunit) as tmp where substring(kodeunit,1,".strlen($rkodeunit).")='$rkodeunit' and substring(kodebarang,1,5)='$r_kodebrg' and $flt and tmp.tipe=1 ";
			//echo $strTotal."<br />";
			$rsTotal=mysql_query($strTotal);
			if($rowTotal = mysql_fetch_array($rsTotal)){
				$jmlbarang=$rowTotal["jmltotal"];
				$jmlharga=$rowTotal["total"];
			}
		 }
	  ?>
    </td>
    <td align="center">
      <?php if ($rows["level"]==2){
			if ($jmlbarang=="") $jmlbarang="0";
			echo $jmlbarang;
		 }
	  ?>
    </td>
    <td align="right"><font size=1>
      <?php if ($rows["level"]==2){
			if ($jmlharga!=""){
				$totalharga +=$jmlharga;
			}else{
				$jmlharga="0.00";
			}
			echo number_format($jmlharga,0,",",".");
		 }
	  ?>
      </font></td>
    <td align="center" class="<?php echo $cellStyle ?>">&nbsp;</td>
  </tr>
<?php
	}
?>
  <tr>
    <td class="HeaderBW" colspan="4">&nbsp;</td>
    <td class="HeaderBW" align="center">TOTAL</td>
	<td align="right" class="HeaderBW"><?php echo number_format($totalharga,0,",","."); ?></td>
    <td class="HeaderBW">&nbsp;</td>
  </tr>
</table>
<br />
<br />
<table width="1000" align="left" border="0" style="margin-left:50px">
<tr>
	<td colspan="4"><br /></td>
</tr>
<tr>
	<td width="70">&nbsp;</td>
	<td width="247" align="center"><strong>Mengetahui,</strong></td>
	<td width="750">&nbsp;</td>
	<td width="247" align="center"><strong>Sidoarjo, <?php echo indonesian_date(); ?></strong></td>
</tr>
<tr>
	<td width="70">&nbsp;</td>
	<td width="247"align="center"><strong>DIREKTUR RSUD </strong></td>
	<td width="750">&nbsp;</td>
	<td width="247" align="center"><strong>Pengurus Barang</strong></td>
</tr>
<tr>
	<td >&nbsp;</td>
	<td align="center"><strong>KABUPATEN SIDOARJO </strong></td>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="4"><p>&nbsp;</p>
    <p>&nbsp;</p></td>
</tr>
<?php 
$sqldirek=mysql_query("select * from as_setting");
$r=mysql_fetch_array($sqldirek);
?>
<tr>
	<td width="70">&nbsp;</td>
	<td width="247" align="center"><strong><?php echo $r['dir_nama'] ?></strong></td>
	<td width="750">&nbsp;</td>
	<td width="247" align="center"><strong><?php echo $r['pengurus_nama'] ?></strong></td>
</tr>

<tr>
	<td width="70">&nbsp;</td>
	<td width="247" align="center" style="text-decoration: overline;"><strong>NIP.
    <?php echo $r['dir_nip'] ?></strong></td>
	<td width="750">&nbsp;</td>
	<td width="247" align="center" style="text-decoration: overline;"><strong>NIP.
    <?php echo $r['pengurus_nip'] ?></strong></td>
</tr>
</table>
<br /><br /><br /><br />
<?php
				}
				break;
			default :
				break;
		} // end switch
} // end for
?>
</body>
</html>
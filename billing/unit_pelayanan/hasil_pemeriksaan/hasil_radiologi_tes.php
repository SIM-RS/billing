<?php
session_start();
include '../../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$id_rad=$_REQUEST['id'];
if($_REQUEST['excel']=="yes"){
header("Content-type: application/vnd.ms-excel");
header("Content--Disposition:attachment; filename='hasilLab.xls'");
}

$date_now=gmdate('d-m-Y H:i',mktime(date('H')+7));

$month = array('','Januari','Februari','Maret','April','Mei',"Juni",'Juli','Agustus','September','Oktober','November','Desember');
$bulan = (isset($_GET['bulan']) && !empty($_GET['bulan']) ? $_GET['bulan'] : date('m') );
$tahun = (isset($_GET['tahun']) && !empty($_GET['tahun']) ? $_GET['tahun'] : date('Y') );

if($bulan < 10){
	$bln = str_replace("0","",$bulan);
}else{
	$bln = $bulan;
}

if($bulan=='01' || $bulan=='03' || $bulan=='05' || $bulan=='07' || $bulan=='08' || $bulan=='10' || $bulan=='12'){
	$tgl = 31;
}else if($bulan == '02'){
	if(($tahun%4 == 0) && ($tahun%100 != 0)){
		$tgl = 29;
	}else{
		$tgl = 28;
	}
}else{
	$tgl = 30;
}


$sqlPas="SELECT 
  a.hasil,
  a.judul,
  a.ket_klinis,
  a.kesimpulan,
  c.no_lab,
  DATE_FORMAT(c.tgl_act,'%d-%m-%Y %H:%i') AS tgl_kunjungan,
  DATE_FORMAT(a.tgl_act,'%d-%m-%Y %H:%i') AS tgl_act,
  DATE_FORMAT(b.tgl_act,'%d-%m-%Y %H:%i') AS tgl,
  e.nama AS pasien,
  DATE_FORMAT(e.tgl_lahir,'%d-%m-%Y') AS tgl_lahir,
  e.no_rm,
  d.umur_thn,
  g.nama,
  f.nama AS dpeng,
  h.nama AS drad,
  mt.nama AS nama_tindakan,
  kso.nama AS status,
  mk.nama AS hakkelas
FROM
  b_hasil_rad a 
  INNER JOIN b_tindakan b 
    ON a.tindakan_id = b.id 
  INNER JOIN b_pelayanan c 
    ON c.id = b.pelayanan_id 
  INNER JOIN b_kunjungan d 
    ON d.id = c.kunjungan_id
  INNER JOIN b_ms_kso kso
    ON kso.id = d.kso_id
  INNER JOIN b_ms_kelas mk
    ON mk.id = d.kso_kelas_id 
  INNER JOIN b_ms_pasien e 
    ON e.id = c.pasien_id 
  LEFT JOIN b_ms_pegawai f 
    ON f.id = c.dokter_id 
  INNER JOIN b_ms_unit g 
    ON g.id = c.unit_id_asal 
  INNER JOIN b_ms_pegawai h 
    ON h.id = a.user_id
  INNER JOIN b_tindakan t 
      ON t.id = a.tindakan_id
  INNER JOIN b_ms_tindakan_kelas mtk 
      ON mtk.id = t.ms_tindakan_kelas_id 
  INNER JOIN b_ms_tindakan mt 
      ON mt.id = mtk.ms_tindakan_id WHERE a.id = ".$id_rad."
";
//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$rw = mysql_fetch_array($rs1);
//$drPeng = str_replace('Dr','dr',$rw['dpeng']); 
//$drRad = str_replace('Dr','dr',$rw['drad']); 

?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/print.css" />
        <title>.: Rincian Hasil Radiologi :.</title>
    </head>
	
    <body>
    <table width="900" border="0" cellspacing="0" cellpadding="0" align="left" class="kwi" style="" >
  <tr>
    <td height="5" colspan="2" style="border-bottom:#000000 solid 1px; border-top:#000000 solid 1px"></td>
  </tr>
  <tr>
  	<td align="center" colspan="2" style="font-size:14px"><b>HASIL PEMERIKSAAN RADIOLOGI</b></td>
  </tr>
  <tr>
  	<td align="center" colspan="2" style="font-size:14px"><b>No. Photo : <?php echo $rw["no_lab"]; ?></b></td>
  </tr>
  <!--tr>
  	<td colspan="2" width="">Rincian Hasil Radiologi</td>
  </tr-->
  <tr class="kwi">
    <td height="30" colspan="2" align="center" style="font-weight:bold;font-size:13px"><!--<u>&nbsp;Rincian Hasil Laboratorium Pasien&nbsp;</u>-->
        <table width="885" style="" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <td style="font-size:18px">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td style="font-size:18px">&nbsp;</td>
            <td  style="font-size:18px">&nbsp;</td>
            <td>&nbsp;</td>
            <td style="font-size:18px">&nbsp;</td>
          </tr>
          <tr>
            <td width="128" style="font-size:12px">&nbsp;&nbsp;Tgl. Kunjungan </td>
            <td width="14" align="center">:</td>
            <td width="381" style="font-size:12px">&nbsp;<?php echo $rw['tgl_kunjungan'];?></td>
            <td width="122" style="font-size:12px">Rujukan Dari</td>
            <td width="12">:</td>
            <td width="226" style="font-size:12px">&nbsp;<?php echo $rw['nama'];?></td>
          </tr>
          <tr>
            <td style="font-size:12px">&nbsp;&nbsp;No. RM</td>
            <td align="center">:</td>
            <td style="font-size:12px">&nbsp;<?php echo strtoupper($rw['no_rm']); ?></td>
            <td style="font-size:12px">Dokter Pengirim</td>
            <td>:</td>
            <td style="font-size:12px">&nbsp;<?php echo $rw['dpeng'];?></td>
          </tr>
          <tr>
            <td style="font-size:12px">&nbsp;&nbsp;Nama Pasien </td>
            <td align="center">:</td>
            <td style="font-size:12px">&nbsp;<?php echo $rw['pasien'];?></td>
            <td style="font-size:12px">Tgl. Pemeriksaan</td>
            <td>:</td>
            <td style="font-size:12px">&nbsp;<?php echo $rw['tgl'];?></td>
          </tr>
          <tr>
            <td style="font-size:12px">&nbsp;&nbsp;Tgl. Lahir</td>
            <td align="center">:</td>
            <td style="font-size:12px">&nbsp;<?php echo $rw['tgl_lahir'];?></td>
            <td style="font-size:12px">Tgl. Hasil</td>
            <td>:</td>
            <td style="font-size:12px">&nbsp;<?php echo $rw['tgl_act'];?></td>
          </tr>
          <tr>
            <td style="font-size:12px">&nbsp;&nbsp;Status Pasien</td>
            <td align="center">:</td>
            <td style="font-size:12px">&nbsp;<?php echo $rw['status'];?></td>
            <td><span style="font-size:12px">Radiolog</span></td>
            <td>:&nbsp;</td>
            <td style="font-size:12px">&nbsp;<?php echo $rw['drad'];?></td>
          </tr>
          <tr>
            <td style="font-size:12px">&nbsp;&nbsp;Hak Kelas</td>
            <td align="center">:</td>
            <td style="font-size:12px">&nbsp;<?php echo $rw['hakkelas'];?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="font-size:12px">&nbsp;&nbsp;</td>
            <td align="center"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="2">
		<table width="900" border="0">
        <!--tr>
          <td style="font-size:12px; padding-left:18px; font-weight:bold;">Uraian Hasil Pemeriksaan&nbsp;&nbsp;</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
          <td style="font-size:12px; padding-left:18px; font-weight:bold;">Klinis :&nbsp;<?php echo $rw['nama_tindakan']; ?>&nbsp;</td>
        </tr-->
        <tr>
          <td style="font-size:12px; padding-left:18px; max-width:900px; word-wrap:break-word"><?php echo $rw['hasil'];?></td>
        </tr>
		</table>
	</td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="898" border="0">
      <tr>
        <td width="145" style="font-size:12px; padding-left:18px; font-weight:bold;">Kesan :</td>
      </tr>
      <tr>
        <td width="737" style="font-size:12px; padding-left:18px;"><?php echo $rw['kesimpulan'];?></td>
      </tr>
      <tr>
      	<td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr class="kwi">
    <?php
		 
			$sqlPet = "select nama from b_ms_pegawai where id = $_SESSION[userId]";
			$dt = mysql_query($sqlPet);
			$rt = mysql_fetch_array($dt);
			?>
    <td width="603" style="font-weight:bold;font-size:12px"><br/>
        <!--Petugas
                    <br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php echo $rt[0];?> )--></td>
    <td width="293" style="font-size:12px;" align="center"><p>Sidoarjo, <?php echo $date_now;?><br/>
        <!--Penanggungjawab
                    <br/>&nbsp;<br/>&nbsp;<br/>&nbsp;( <?php echo $pegawai;?> )</td>-->
        Radiolog, </p>
        <br/><br/><br/>&nbsp;&nbsp;
        ( <?php echo $rw['drad'];?> )</td>
  </tr>
  <tr >
    <td align="center" class="noline" style="font-size:12px"><div align="right"></div></td>
    <td align="center" class="noline" style="font-size:12px">&nbsp;</td>
  </tr>
  <tr id="trTombol">
    <td colspan="2" class="noline" align="center"><input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
        <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>    </td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
<tr class="kwi"></tr>
    </table>
<script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Mencetak Rician hasil Radiologi ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
      </script>

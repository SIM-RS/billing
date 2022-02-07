<?php
session_start();
include '../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$jml=$_REQUEST['jml'];
$jns1=$_REQUEST['jns1'];
if($jns1=="Istirahat")
{
	$jns1="Istirahat";
}else{
	$jns1="Kerja RIngan";
}
if($_REQUEST['excel']=="yes"){
header("Content-type: application/vnd.ms-excel");
header("Content--Disposition:attachment; filename='hasilLab.xls'");
}
$sqlPas="SELECT DISTINCT
  no_rm,
  mp.nama nmPas,
  mp.alamat,
  mp.rt,
  mp.rw,
  CASE mp.sex WHEN 'P' THEN 'Perempuan' ELSE 'Laki - Laki' END AS sex,
  mk.nama kelas,
  md.nama AS diag,
  peg.nama AS dokter,
  kso.nama nmKso,
  CONCAT(
    DATE_FORMAT(p.tgl, '%d-%m-%Y'),
    ' ',
    DATE_FORMAT(p.tgl_act, '%H:%i')
  ) tgljam,
  DATE_FORMAT(
    IFNULL(p.tgl_krs, NOW()),
    '%d-%m-%Y %H:%i'
  ) tglP,
  mp.desa_id,
  mp.kec_id,
  (SELECT 
    nama 
  FROM
    b_ms_wilayah 
  WHERE id = mp.kec_id) nmKec,
  (SELECT 
    nama 
  FROM
    b_ms_wilayah 
  WHERE id = mp.desa_id) nmDesa,
  k.kso_id,
  k.kso_kelas_id,
  p.kelas_id,
  un.nama nmUnit,
  p.no_lab,
  mp.tgl_lahir,
  peg1.nama AS dok_rujuk,
  k.umur_thn, k.id, p.id, mp.nama_satuan, bmp.nama as nm_pangkat, DATE_FORMAT(CURDATE(), '%d %M %Y') AS tgl1, DATE_FORMAT(DATE_ADD(CURDATE(),INTERVAL $jml DAY),'%d %M %Y') AS tgl2,   CASE WHEN bmpk.nama = 'LAIN-LAIN' THEN '-' ELSE bmpk.nama END AS nm_pekerjaan 
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  INNER JOIN b_ms_pangkat bmp
    ON mp.pangkat_id = bmp.id
  INNER JOIN b_ms_pekerjaan bmpk 
    ON mp.pekerjaan_id = bmpk.id
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id 
  INNER JOIN b_tindakan bmt
    ON k.id = bmt.kunjungan_id AND p.id = bmt.pelayanan_id
  LEFT JOIN b_ms_kelas mk 
    ON k.kso_kelas_id = mk.id 
  INNER JOIN b_ms_kso kso 
    ON k.kso_id = kso.id 
  LEFT JOIN b_ms_unit un 
    ON un.id = p.unit_id
  LEFT JOIN b_diagnosa diag 
    ON diag.kunjungan_id = k.id 
  LEFT JOIN b_ms_diagnosa md 
    ON md.id = diag.ms_diagnosa_id 
  LEFT JOIN b_ms_pegawai peg 
    ON peg.id = bmt.user_act
  LEFT JOIN b_ms_pegawai peg1 
    ON bmt.user_id = peg1.id  
WHERE k.id='$idKunj' AND p.id='$idPel'";
//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$rw = mysql_fetch_array($rs1);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/print.css" />
        <title>.: Rincian Hasil Laboratorium :.</title>
    </head>
    <body style="margin-top:0px">
        <table width="500" border="0" cellspacing="0" cellpadding="0" align="left" class="kwi">
            <tr>
                <td colspan="2" style="font-size:12px" align="center"><img height="100" width="120" src="../images/logo rs.bmp"><b><br>POLRI DAERAH JAWA TIMUR<br>BIDANG KEDOKTERAN DAN KESEHATAN<br>RS. BHAYANGKARA TK II  H.S. SAMSOERI MERTOJOSO</b><br />Jalan Achmad Yani No.116 Surabaya 60231</td>
            </tr>
            <tr>
                <td height="5" colspan="2" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
            </tr>
            <tr class="kwi">
                <td height="30" colspan="2" align="center" style="font-weight:bold;font-size:13px">
                    <u>&nbsp;Surat-Keterangan</u></td>
            </tr>
            <tr class="kwi">
                <td height="" colspan="2" align="left" style="font-size:13px">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yang bertanda tangan dibawah ini menerangkan dengan sebenarnya bahwa : &nbsp;
                   <br> Seorang <?php echo strtolower($rw['sex']);?> bernama : <?php echo $rw['nmPas'];?> umur : <?php echo $rw['umur_thn'];?> pekerjaan :<?php echo $rw['nm_pekerjaan'];?> Alamat : <?php echo strtolower($rw['alamat']);?>. Karena sakitnya ia dirawat di RS.BHAYANGKARA H.S.SAMSOERI MERTOJOSO dari tanggal &nbsp; <?php echo strtolower($rw['tgl1']);?> s/d. <?php echo $rw['tgl2'];?> dengan Nomor Reg : <?php echo $rw['no_rm'];?>. <br>
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian di buatnya surat keterangan ini dapatnya digunakan seperlunya.
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr class="kwi">
			<?php
			$sqlPet = "select nama from b_ms_pegawai where id = $_SESSION[userId]";
			$dt = mysql_query($sqlPet);
			$rt = mysql_fetch_array($dt);
			//echo $pegawai;
			?>
                <td width="603" style="font-weight:bold;font-size:12px"><br/>
               
				<!--Petugas
                    <br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php echo $rt[0];?> )--></td>
                <td width="293" style="font-weight:bold;font-size:12px"><center>Surabaya, <?php echo gmdate('d F Y',mktime(date('H')+7));?></center><br/>
                <center>Kepala Ruangan</center><br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/><center>
                  (.........................................)
                </center></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr id="trTombol">
                <td colspan="2" class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
                    <input id="btnExpExcl" type="button" value="Export --> Excell" onClick="window.location = '?idKunj=<?php echo $idKunj; ?>&idPel=<?php echo $idPel; ?>&excel=<?php echo "yes"; ?>';"/>
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
                </td>
            </tr>
        </table>
        <script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Mencetak Rician hasil Laboratorium ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
        </script>
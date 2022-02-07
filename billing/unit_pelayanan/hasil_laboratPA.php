<?php
session_start();
include("../sesi.php");
$tgl_sekarang = getdate();
?>
<?php
//session_start();
include '../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
if($_REQUEST['excel']=="yes"){
header("Content-type: application/vnd.ms-excel");
header("Content--Disposition:attachment; filename='Laporan Radiologi.xls'");
}
$sql = "SELECT c.*,b.metode,DATE_FORMAT(a.tgl_act,'%d-%m-%Y') AS tgl_act,CONCAT(a.hasil,' ',d.nama_satuan) hasilc,
CONCAT(b.normal1,' - ',b.normal2, ' ',d.nama_satuan) normal,a.ket,mp.nama dok, mp1.nama dokN 
FROM (SELECT * FROM b_hasil_lab WHERE id_pelayanan='$idPel') AS a 
INNER JOIN b_ms_normal_lab b ON a.id_normal=b.id
INNER JOIN b_ms_pemeriksaan_lab c ON b.id_pemeriksaan_lab=c.id
INNER JOIN b_ms_satuan_lab d ON b.id_satuan=d.id
INNER JOIN b_ms_pegawai mp ON a.user_act=mp.id
INNER JOIN b_pelayanan bp ON a.id_pelayanan = bp.id
 INNER JOIN b_ms_pegawai mp1 ON bp.dokter_tujuan_id = mp1.id
limit 1";
$rs=mysql_query($sql);
$tmpNm =mysql_fetch_array($rs);
$pegawai = $tmpNm['dokN'];

$sql = "SELECT DATE_FORMAT(tgl_act, '%d-%m-%Y %h:%i:%s') AS tgl_act FROM b_hasil_lab WHERE id_pelayanan = $idPel AND tgl_act = (SELECT MAX(tgl_act) FROM b_hasil_lab WHERE id_pelayanan = $idPel)";
$rs=mysql_query($sql);
$tmpNm =mysql_fetch_array($rs);

$sqlPas="SELECT no_rm,mp.nama nmPas,mp.alamat, k.umur_thn, mp.rt,mp.rw,DATE_FORMAT(mp.tgl_lahir, '%d-%m-%Y') AS tgl_lahir,mp.sex,mk.nama kelas,md.nama as diag,peg.nama as dokter,
kso.nama nmKso,CONCAT(DATE_FORMAT(p.tgl_sampel, '%d-%m-%Y'),' ',p.jam_sampel) AS tgl_sampel,CONCAT(DATE_FORMAT(p.tgl,'%d-%m-%Y'),' ',DATE_FORMAT(p.tgl_act,'%H:%i')) tgljam, CONCAT(DATE_FORMAT(bhll.tgl_act, '%d-%m-%Y'),' ',DATE_FORMAT(bhll.tgl_act, '%H:%i')) tgljamJ,
DATE_FORMAT(IFNULL(p.tgl_krs,NOW()),'%d-%m-%Y %H:%i') tglP, mp.desa_id,mp.kec_id, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) nmKec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) nmDesa, k.kso_id,k.kso_kelas_id,p.kelas_id,un.nama nmUnit, p.user_acc, p.no_lab
FROM b_kunjungan k 
INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id 
INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
LEFT JOIN b_ms_kelas mk ON k.kso_kelas_id=mk.id 
INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
INNER JOIN b_hasil_lab bhll on bhll.id_pelayanan=p.id
left join b_ms_unit un on un.id=p.unit_id_asal
left join b_diagnosa diag on diag.kunjungan_id=k.id
left join b_ms_diagnosa md on md.id = diag.ms_diagnosa_id
left join b_ms_pegawai peg on peg.id = diag.user_id
WHERE k.id='$idKunj' AND p.id='$idPel'";
//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$jmlTot = mysql_num_rows($rs1);
$rw = mysql_fetch_array($rs1);
$jmlTot = 1;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/print.css" />
        <title>.: Rincian Hasil Laboratorium :.</title>
    </head>
    <body style="margin-top:0px">
    <?
		if($jmlTot > 0)
		{
	?>
        <table width="900" border="0" cellspacing="0" cellpadding="0" align="left" class="kwi">
            <tr>
                <!--<td colspan="2" style="font-size:14px">
                    <b><?=$pemkabRS?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font size="-3">Penanggung Jawab :&nbsp;<?php echo $pegawai;?></font><br />
		<?=$namaRS?><br />
		Instalasi Laboratorium Klinik<br />
		<?=$alamatRS?> Telepon <?=$tlpRS?><br/></b>&nbsp;
                </td>-->
                <!--<td style="font-size:8px" align="left">
                Penanggungjawab : <?php echo $pegawai;?> 
                </td>-->
<!--                <td colspan="2" style="font-size:14px" align="right">
                    <b><font size="-3">Penanggung Jawab :&nbsp;<?php echo $pegawai;?></font></b>
                </td>
-->                <!--<td style="font-size:8px" align="left">
                Penanggungjawab : <?php echo $pegawai;?> 
                </td>-->
            </tr>
            <tr>
                <td height="5" colspan="2" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
            </tr>
            <tr class="kwi">
                <td colspan="2">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="12%" style="font-size:12px">Nama Pasien</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="46%" style="font-size:12px">&nbsp;<?php echo $rw['nmPas'];?></td>
                            <td width="10%" style="font-size:12px">No Lab PA</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo str_pad($rw['no_lab'],8,"0",STR_PAD_LEFT);?></td>
                        </tr>
                        <tr>
                            <td width="12%" style="font-size:12px">Alamat</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="46%" style="font-size:12px">&nbsp;<?php echo $rw['alamat'];?></td>
                            <td width="10%" style="font-size:12px">No RM</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $rw['no_rm'];?></td>
                        </tr>
                        <tr>
                            <td width="12%" style="font-size:12px">Tgl Lahir / Umur</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="46%" style="font-size:12px">&nbsp;<?php echo $rw['tgl_lahir'];?> / <?php echo strtolower($rw['umur_thn']." Tahun");;?></td>
                            <td width="10%" style="font-size:12px">Tgl Terima</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $rw['tgljam'];?></td>
                        </tr>
                        <tr>
                            <td width="12%" style="font-size:12px">Jenis Kelamin</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="46%" style="font-size:12px">&nbsp;<?php echo strtolower($rw['sex']);?></td>
                            <td width="10%" style="font-size:12px">Tgl Jawab</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $rw['tgljamJ'];?></td>
                        </tr>
                        <tr>
                            <td width="12%" style="font-size:12px">Dokter Pengirim</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="46%" style="font-size:12px">&nbsp;<?php echo $rw['dokter'];?></td>
                            <td width="10%" style="font-size:12px">&nbsp;</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                            <td width="30%" style="font-size:12px">&nbsp;</td>
                        </tr>
              </table>	</td>
            </tr>
            <tr class="kwi">
                 <td height="30" colspan="2" align="center" style="font-weight:bold;font-size:13px"><b>&nbsp;Hasil Pemeriksaan Patologi Anatomi&nbsp;</b></td>
            </tr>
            <tr class="kwi">
                <td height="30" colspan="2">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <?
						$queryB="SELECT a.*, b.ket FROM b_hasil_lab a INNER JOIN b_pelayanan b ON a.id_pelayanan = b.id WHERE a.id_pelayanan = $idPel";
						$qBaru1=mysql_query($queryB);
						$execQB1=mysql_fetch_array($qBaru1);
                    ?>
                     <tr>
                     	<td width="20%">Diagnosa Klinik</td>
                        <td width="1%">:</td>
                        <td>&nbsp;<? echo $execQB1['ket'];?></td>
                     </tr>
                     <tr>
                     	<td height="10" colspan="3">&nbsp;</td>
                     </tr>
                     <tr>
                     	<td width="20%">Makroskopik</td>
                        <td width="1%">:</td>
                        <td>&nbsp;<? echo $execQB1['makroskopik'];?></td>
                     </tr>
                     <tr>
                     	<td height="10" colspan="3">&nbsp;</td>
                     </tr>
                     <tr>
                     	<td width="20%">Mikroskopik</td>
                        <td width="1%">:</td>
                        <td>&nbsp;<? echo $execQB1['mikroskopik'];?></td>
                     </tr>
                     <tr>
                     	<td height="10" colspan="3">&nbsp;</td>
                     </tr>
                      <tr>
                     	<td width="20%">Kesimpulan</td>
                        <td width="1%">:</td>
                        <td>&nbsp;<? echo $execQB1['kesimpulan'];?></td>
                     </tr>
                     <tr>
                     	<td height="10" colspan="3">&nbsp;</td>
                     </tr>
                     <tr>
                     	<td width="20%">Anjuran</td>
                        <td width="1%">:</td>
                        <td>&nbsp;<? echo $execQB1['anjuran'];?></td>
                     </tr>
					</table>
					</td>
			</tr>
			 <tr>
                <td height="5" colspan="2" style="border-bottom:#000000 double 0.1px; border-top:#000000 solid 0.1px">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr class="kwi">
			<?php
			$sqlPet = "select nama from b_ms_pegawai where id = $_SESSION[userId]";
			$dt = mysql_query($sqlPet);
			$rt = mysql_fetch_array($dt);
			?>
                <td width="608" style="font-weight:bold;font-size:12px">
                Tgl Cetak Hasil : <?php echo date("d-m-Y H:i:s");?>
                <br/>
				<!--Petugas-->
                    <br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/><!--( <?php echo $rt[0];?> )--></td>
                <td width="292" style="font-weight:bold;font-size:12px"><?=$kotaRS?>, <?php echo gmdate('d F Y',mktime(date('H')+7));?><br/>
                    <br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php 
					$qP1 = "select nama from b_ms_pegawai where id =$rw[user_acc]";
					$dqp1 = mysql_fetch_array(mysql_query($qP1));
					if($rw['user_acc']==0)
					{
						echo $_SESSION['nm_pegawai'];
					}else{
						echo $dqp1['nama'];
					}?> )</td>
            </tr>
            <tr id="trTombol">
                <td colspan="2" class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
                    <input id="btnExpExcl" type="button" value="Export --> Excell" onClick="window.location = '?idKunj=<?php echo $idKunj; ?>&idPel=<?php echo $idPel; ?>&excel=<?php echo "yes"; ?>';"/>
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
                </td>
            </tr>
            <tfoot>
            	<tr>
                	<td colspan="2" class="noline">
                    &nbsp;Catatan : &nbsp;
                    <?
						$queryCPasien = "SELECT * FROM b_pelayanan WHERE id = $idPel";
						$dcPasien = mysql_fetch_array(mysql_query($queryCPasien));
						echo $dcPasien['cpasien'];
                    ?>
                    </td>
                </tr>
            </tfoot>
        </table>
          <?
				}else{
					echo "Masih dilakukan pemeriksaan....";
				}
			?>
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
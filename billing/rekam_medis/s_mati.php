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
$idUser=$_REQUEST['idUser'];
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUser'"));
/*$sqlPas="SELECT DISTINCT
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
  k.umur_thn, k.id, p.id, mp.nama_satuan, bmp.nama as nm_pangkat, DATE_FORMAT(CURDATE(), '%d %M %Y') AS tgl1, DATE_FORMAT(DATE_ADD(CURDATE(),INTERVAL $jml DAY),'%d %M %Y') AS tgl2, mp.nip
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  INNER JOIN b_ms_pangkat bmp
    ON mp.pangkat_id = bmp.id
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
WHERE k.id='$idKunj' AND p.id='$idPel'";*/
/*$sqlPas="SELECT DISTINCT 
  no_rm,
  mp.nama nmPas,
  mp.alamat,
  mp.rt,
  mp.rw,
  CASE
    mp.sex 
    WHEN 'P' 
    THEN 'Perempuan' 
    ELSE 'Laki - Laki' 
  END AS sex,
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
  k.umur_thn,
  k.id,
  p.id,
  DATE_FORMAT(CURDATE(), '%d %M %Y') AS tgl1,
  bpek.nama AS kerjaan
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  LEFT JOIN b_ms_pekerjaan bpek 
    ON bpek.id = mp.pekerjaan_id 
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id 
  INNER JOIN b_tindakan bmt 
    ON k.id = bmt.kunjungan_id 
    AND p.id = bmt.pelayanan_id 
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
WHERE k.id='$idKunj' AND p.id='$idPel'";*/
$sqlPas="SELECT DISTINCT 
  no_rm,
  mp.nama nmPas,
  mp.alamat,
  mp.rt,
  mp.rw,
  CASE
    mp.sex 
    WHEN 'P' 
    THEN 'Perempuan' 
    ELSE 'Laki - Laki' 
  END AS sex,
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
  k.umur_thn,
  k.id,
  p.id,
  DATE_FORMAT(CURDATE(), '%d %M %Y') AS tgl1,
  bpek.nama AS kerjaan,
  DATE_FORMAT(p.tgl_act, '%d %M %Y') tglawal,
  DATE_FORMAT(p.tgl_act, '%H:%i') jamawal,
  DATE_FORMAT(bkel.tgl_act, '%d %M %Y') tglmati,
  DATE_FORMAT(bkel.tgl_act, '%H:%i') jammati,
  peg3.nama dktrmati,
  bagm.agama
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  LEFT JOIN b_ms_pekerjaan bpek 
    ON bpek.id = mp.pekerjaan_id
  LEFT JOIN b_ms_agama bagm
    ON bagm.id = mp.agama 
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id 
  INNER JOIN b_tindakan bmt 
    ON k.id = bmt.kunjungan_id 
    AND p.id = bmt.pelayanan_id 
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
  INNER JOIN b_pasien_keluar bkel
    ON bkel.pelayanan_id = p.id
  INNER JOIN b_ms_pegawai peg3
    ON peg3.id = bkel.dokter_id
WHERE k.id='$idKunj' AND p.id='$idPel' AND bkel.cara_keluar like '%Meninggal%'";

//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$rw = mysql_fetch_array($rs1);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/print.css" />
        <title>.: Surat Keterangan Meninggal :.</title>
    </head>
    <body style="margin-top:0px">
        <table width="600" style="font:tahoma;" border="0" cellspacing="0" cellpadding="0" align="left" class="kwi">
            <tr>
                <td colspan="2" style="font-size:12px; border:1px solid #000;" align="center"><table border="0">
                  <tr>
                    <td style="font:26px bold tahoma" height="100" width="316">RS PELINDO I</td>
                    <td width="272"><table border="0">
  <tr>
    <td style="border:1px solid #000;font:16px bold tahoma;" height="50" width="266">SURAT KETERANGAN MENINGGAL</td>
  </tr>
</table>
</td>
                  </tr>
                </table></td>
            </tr>
            <tr>
                <td height="5" colspan="2" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
            </tr>
            <tr class="kwi">
                <td height="30" colspan="2" align="center" style="font-size:13px">
                <strong>KETERANGAN MENINGGAL</strong></td>
            </tr>
            <tr class="kwi">
                <td height="10" colspan="2" align="left" style="font-size:13px">
                    
                </td>
            </tr>
            <tr class="kwi">
                <td colspan="2">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                      <td style="font-size:12px">Ruangan</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td width="27%" style="font-size:12px"><?php echo $rw['nmUnit'];?></td>
                      <td style="font-size:12px">&nbsp;</td>
                      <td align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                      <td style="font-size:12px">&nbsp;</td>
                    </tr>
                    <tr>
                      <td style="font-size:12px">No Rekam Medik</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['no_rm'];?></td>
                      <td style="font-size:12px">&nbsp;</td>
                      <td align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                      <td style="font-size:12px">&nbsp;</td>
                    </tr>
                    <tr>
                      <td style="font-size:12px">Dokter</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['dktrmati'];?></td>
                      <td style="font-size:12px">&nbsp;</td>
                      <td align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                      <td style="font-size:12px">&nbsp;</td>
                    </tr>
                    <tr>
                      <td style="font-size:12px">Pada tanggal</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td colspan="4" style="font-size:12px"><?php echo $rw['jammati'];?>&nbsp;&nbsp;&nbsp;menerangkan bahwa :</td>
                      </tr>
                    <tr>
                      <td style="font-size:12px">Nama</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['nmPas'];?></td>
                      <td style="font-size:12px">&nbsp;</td>
                      <td align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                      <td style="font-size:12px">&nbsp;</td>
                    </tr>
                    <tr>
                      <td style="font-size:12px">Jenis Kelamin</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['sex'];?></td>
                      <td style="font-size:12px">&nbsp;</td>
                      <td align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                      <td style="font-size:12px">&nbsp;</td>
                    </tr>
                    <tr>
                      <td style="font-size:12px">Umur</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['umur_thn'];?></td>
                      <td style="font-size:12px">&nbsp;</td>
                      <td align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                      <td style="font-size:12px">&nbsp;</td>
                    </tr>
                    <tr>
                      <td style="font-size:12px">Agama</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['agama'];?></td>
                      <td style="font-size:12px">&nbsp;</td>
                      <td align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                      <td style="font-size:12px">&nbsp;</td>
                    </tr>
                    <tr>
                      <td style="font-size:12px">Alamat</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td colspan="4" style="font-size:12px"><?php echo $rw['alamat'];?>&nbsp;RT <?php echo $rw['rt'];?> / RW <?php echo $rw['rw'];?>, Desa <?php echo $rw['nmDesa'];?>, Kecamatan <?php echo $rw['nmKec'];?></td>
                      </tr>
                    <tr>
                      <td style="font-size:12px">Tanggal Masuk</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['tglawal'];?></td>
                      <td style="font-size:12px">Jam</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['jamawal'];?>&nbsp;WIB</td>
                    </tr>
                    <tr>
                      <td style="font-size:12px">Tanggal Meninggal</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['tglmati'];?></td>
                      <td style="font-size:12px">Jam</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['jammati'];?>&nbsp;WIB</td>
                    </tr>
                    <tr>
                            <td width="24%" style="font-size:12px">Diagnosa</td>
                            <td width="4%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px"><?php echo $rw['diag'];?></td>
                            <td width="8%" style="font-size:12px">&nbsp;</td>
                            <td width="4%" align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                            <td width="33%" style="font-size:12px">&nbsp;</td>
                    </tr>
                    <tr>
                            <td colspan="6" style="font-size:12px">&nbsp;</td>
                      </tr>
                    <!--     <tr>
                            <td width="11%" style="font-size:12px">No RM</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo $rw['no_rm'];?></td>
                            <td width="10%" style="font-size:12px">Tgl Periksa</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $rw['tgljam'];?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px">Nama Pasien </td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmPas']);?></td>
                            <td width="10%" style="font-size:12px">Unit </td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $rw['nmUnit'];?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px">Alamat</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px;">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['alamat']);?></td>
                            <td width="10%" style="font-size:12px">Diagnosa</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['diag']);?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px">Kel. / Desa</td>
                          <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmDesa']);?></td>
                          <td width="10%" style="font-size:12px">Dokter</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['dokter']);?></td>
                        </tr>
                        <tr>
                            <td width="11%"><span style="font-size:12px">RT / RW</span></td>
                          <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['rt']." / ".$rw['rw']);?></td>
                          <td width="10%" style="font-size:12px">Status Pasien</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmKso'])?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px">Jenis Kelamin </td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['sex']);?></td>
                            <td width="10%" style="font-size:12px">Hak Kelas</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $rw['kelas'];?></td>
                        </tr>-->
              </table>	</td>
            </tr>
			 <tr>
                <td colspan="2" >&nbsp;</td>
            </tr>
            <tr class="kwi">
			<?php
			/*$sqlPet = "select nama from b_ms_pegawai where id = $_REQUEST[idUser]";
			//echo $sqlPet;
			$dt = mysql_query($sqlPet);
			$rt = mysql_fetch_array($dt);*/
			//echo $pegawai;
			?>
                <td width="603" style="font-weight:bold;font-size:12px"><br/>
               
				<!--Petugas
                    <br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php //echo $rt[0];?> )--></td>
                <td width="293" style="font-size:12px"><center>
                    Medan, <?php echo gmdate('d F Y',mktime(date('H')+7));?>
                </center><br/>
                <center>Dokter yang Memeriksa</center><br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/><center>(<strong><?php echo $usr['nama'];?></strong>)</center></td>
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
                    if(confirm('Anda Yakin Mau Mencetak Surat Keterangan Meninggal ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
        </script>
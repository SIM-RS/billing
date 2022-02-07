<?php
session_start();
include("../sesi.php");
?>
<title>Resume Medis</title>
<?php
include("../koneksi/konek.php");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("G:i:s");

//$userId = $_SESSION['userId'];
$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['userId']."'";
$rsPeg = mysql_query($sqlPeg);
$rwPeg = mysql_fetch_array($rsPeg);

$sqlPas = "SELECT k.id AS kunjungan_id,k.kso_id, pl.id AS pelayanan_id, p.nama, p.sex, k.umur_thn, p.no_rm,
kso.nama_peserta, (SELECT nama FROM b_ms_kso WHERE id = k.kso_id) AS perusahaan,
kso.st_anggota, kso.no_anggota, (SELECT agama FROM b_ms_agama WHERE id = p.agama) AS agama,
DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl, (SELECT nama FROM b_ms_pekerjaan WHERE id = p.pekerjaan_id) AS pekerjaan, 
DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_pulang, p.alamat,
(SELECT nama FROM b_ms_pegawai WHERE id = t.user_id) AS dokterMerawat,
(SELECT nama FROM b_ms_pegawai WHERE id = pl.dokter_id) AS dokterPengirim,
(SELECT nama FROM b_ms_kamar WHERE id = k.kamar_id) AS kamar,
(SELECT nama FROM b_ms_kelas WHERE id = k.kelas_id) AS kelas,
(SELECT keadaan_keluar FROM b_pasien_keluar WHERE kunjungan_id=k.id limit 1) AS keadaan_keluar
FROM b_ms_pasien p
INNER JOIN b_kunjungan k ON k.pasien_id = p.id
INNER JOIN b_ms_kso_pasien kso ON kso.pasien_id = p.id
INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
INNER JOIN b_ms_unit u ON u.id = pl.unit_id
left JOIN b_tindakan t ON t.pelayanan_id = pl.id
WHERE p.id = '".$_REQUEST['idPasien']."' AND k.id = '".$_REQUEST['idKunj']."' AND pl.id = '".$_REQUEST['idPel']."'";
//echo $sqlPas."<br>";
$rsPas = mysql_query($sqlPas);
$rwPas = mysql_fetch_array($rsPas);

$sql="SELECT nama FROM b_tindakan_kamar WHERE pelayanan_id='".$_REQUEST['idPel']."'";
$rsKamar=mysql_query($sql);
$rwkamar=mysql_fetch_array($rsKamar);

$sqlSOAP="SELECT a.* FROM $dbaskep.ask_soap a
INNER JOIN b_pelayanan b ON a.pelayanan_id = b.id
WHERE b.kunjungan_id = ".$_REQUEST['idKunj']."
ORDER BY a.id DESC LIMIT 1";
$dsqlSOAP = mysql_query($sqlSOAP);
$rsqlSOAP = mysql_fetch_array($dsqlSOAP);
/*
INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id
inner join b_ms_tindakan mt on tk.ms_tindakan_id = mt.id*/
?>
<div align="center">
    <table width="950" border="0" cellpadding="0" cellspacing="0">
        <tr height="50">
            <td width="20%" align="center" style="border-top:1px solid; border-left:1px solid; border-bottom:1px solid;font-size: 14px; font-weight: bold">RSUD<br /><?php echo strtoupper($kotaRS);?></td>
            <td width="60%" align="center" style="border-top:1px solid; border-left:1px solid; border-bottom:1px solid;font-size: 14px; font-weight: bold"><b>RESUME MEDIS (RIWAYAT PENYAKIT)</b></td>
            <td width="20%" align="center" style="border-top:1px solid; border-left:1px solid; border-bottom:1px solid; border-right:1px solid;font-size: 14px; font-weight: bold"><i>LRM. 7</i></td>
        </tr>
        <tr>
            <td colspan="3">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="30">
                        <td width="3%" style="border-left:1px solid; border-bottom:1px solid;">&nbsp;</td>
                        <td width="45%" style="border-bottom:1px solid;font-size: 13px; font-weight: bold">&nbsp;Nama Pasien&nbsp;:&nbsp;&nbsp;&nbsp;<b><?php echo $rwPas['nama'];?></b></td>
                        <td width="25%" style="border-bottom:1px solid;font-size: 13px; font-weight: bold">&nbsp;( <?php echo $rwPas['sex'];?> )&nbsp;Umur&nbsp;:&nbsp;<?php echo $rwPas['umur_thn'];?>&nbsp;tahun</td>
                        <td width="25%" style="border-bottom:1px solid;font-size: 13px; font-weight: bold">&nbsp;NO RM&nbsp;:&nbsp;<?php echo $rwPas['no_rm'];?></td>
                        <td width="2%" style="border-bottom:1px solid; border-right:1px solid;font-size: 13px; font-weight: bold">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr style="font-size: 13px; ">
                        <td width="1%" style="border-left:1px solid;">&nbsp;</td>
                        <td width="20%">&nbsp;Nama Peserta</td>
                        <td width="30%">:&nbsp;<?php if ($rwPas['kso_id']!=1) echo $rwPas['nama_peserta'];?></td>
                        <td width="23%">&nbsp;Nama Perusahaan</td>
                        <td width="25%">:&nbsp;<?php echo $rwPas['perusahaan'];?></td>
                        <td width="1%" style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>&nbsp;Hubungan Keluarga</td>
                        <td>:&nbsp;<?php if ($rwPas['kso_id']!=1) echo $rwPas['st_anggota'];?></td>
                        <td>&nbsp;No. Asuransi</td>
                        <td>:&nbsp;<?php echo $rwPas['no_anggota'];?></td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>&nbsp;Agama</td>
                        <td>:&nbsp;<?php echo $rwPas['agama'];?></td>
                        <td>&nbsp;Tanggal Masuk</td>
                        <td>:&nbsp;<?php echo $rwPas['tgl'];?></td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>&nbsp;Pekerjaan</td>
                        <td>:&nbsp;<?php echo $rwPas['pekerjaan'];?></td>
                        <td>&nbsp;Tgl. Keluar/Meninggal</td>
                        <td>:&nbsp;<?php echo $rwPas['tgl_pulang'];?></td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>&nbsp;Alamat</td>
                        <td>:&nbsp;<?php echo $rwPas['alamat'];?></td>
                        <td>&nbsp;Dokter yang merawat</td>
                        <td>:&nbsp;<?php echo $rwPas['dokterMerawat'];?></td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>&nbsp;Dokter Pengirim</td>
                        <td>:&nbsp;<?php echo $rwPas['dokterPengirim'];?></td>
                        <td>&nbsp;Dokter Konsultan</td>
                        <td>:&nbsp;</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid; border-bottom:1px solid;">&nbsp;</td>
                        <td style="border-bottom:1px solid;">&nbsp;Nama Kamar</td>
                        <td style="border-bottom:1px solid;">:&nbsp;<?php echo $rwKamar['nama'];?></td>
                        <td style="border-bottom:1px solid;">&nbsp;Nomor Kamar</td>
                        <td style="border-bottom:1px solid;">:&nbsp;<span style="padding-left: 60px" />Kelas&nbsp;:&nbsp;<?php echo $rwPas['kelas'];?></td>
                        <td style="border-right:1px solid; border-bottom:1px solid;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <?php
		if($_REQUEST['id_anamnesa']==''){
			/*$sAnam = "SELECT * 
					FROM anamnese a
					WHERE a.KUNJ_ID = '".$_REQUEST['idKunj']."' ORDER BY a.anamnese_id DESC LIMIT 1";*/
			$sAnam = "SELECT * 
					FROM anamnese a
					WHERE a.PASIEN_ID = '".$_REQUEST['idPasien']."' ORDER BY a.anamnese_id DESC LIMIT 1";	
		}
		else{
			$sAnam = "SELECT * 
					FROM anamnese a
					WHERE a.ANAMNESE_ID = '".$_REQUEST['id_anamnesa']."'";	
		}
		
		//echo $sAnam;
		$qAnam = mysql_query($sAnam);
		$rwAnam = mysql_fetch_array($qAnam);
		?>
        <tr>
            <td colspan="3">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr style="font-size: 13px; ">
                        <td width="7%" style="border-left:1px solid; border-top:1px solid;">&nbsp;</td>
                        <td width="27%" style="border-top:1px solid;">&nbsp;</td>
                        <td width="3%" style="border-top:1px solid;">&nbsp;</td>
                        <td width="63%" style="border-top:1px solid; border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">1.</td>
                        <td>Keluhan penyakit / anamnesa</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['KU']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; display:none">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Lama penyakit</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; display:none">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Lama penyakit</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; display:none">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Lain - lain</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">2.</td>
                        <td>Penyakit Sekarang</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['RPS']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">3.</td>
                        <td>Penyakit dahulu</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['RPD']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Kapan</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Pengobatannya</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Faktor Etiologi</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">4.</td>
                        <td>Riwayat Penyakit Keluarga</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['RPK']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">5.</td>
                        <td>Anamnesa Sosial</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['SOS']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">6.</td>
                        <td>Keadaan Umum</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['KUM']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">7.</td>
                        <td>Hasil pemeriksaan waktu MRS</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Fisik</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Laboratorium</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Radiologi</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Genitalia</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['GENITALIA']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Lain - lain</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">8.</td>
                        <td>Diagnosa Masuk</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <?php
					$sDA="SELECT GROUP_CONCAT(md.nama) AS da 
FROM b_ms_diagnosa md
INNER JOIN b_diagnosa d ON md.id=d.ms_diagnosa_id
WHERE d.akhir=1 AND d.kunjungan_id = '".$_REQUEST['idKunj']."'";
					$qDA=mysql_query($sDA);
					$rwDA=mysql_fetch_array($qDA);
					?>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Diagnose Akhir</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwDA['da']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Diagnose PA</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">9.</td>
                        <td>GCS</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['GCS']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">10.</td>
                        <td>KESADARAN</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['KESADARAN']; ?></td>
                    </tr>
                      <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">11.</td>
                        <td>Status Gizi</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['GIZI']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">12.</td>
                        <td>RR</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['RR']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">13.</td>
                        <td>Suhu</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['SUHU']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">14.</td>
                        <td>Tensi Sistolik</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['TENSI']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">15.</td>
                        <td>Tensi Diastolik</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['TENSI_DIASTOLIK']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">16.</td>
                        <td>Nadi</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['NADI']; ?></td>
                    </tr>
                     <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">17.</td>
                        <td>Berat Badan</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['BB']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">18.</td>
                        <td>Tinggi Badan</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['TB']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">19.</td>
                        <td>Pulmo</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['PULMO']; ?></td>
                    </tr>
                     <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">20.</td>
                        <td>Thorax</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['THORAX']; ?></td>
                    </tr>
                    <!--<tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">19.</td>
                        <td>Auskultasi</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['AUSKULTASI']; ?></td>
                    </tr>-->
                     <!--<tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">20.</td>
                        <td>Perkusi</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['PERKUSI']; ?></td>
                    </tr>-->
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">21.</td>
                        <td>Kepala</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['KL']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">22.</td>
                        <td>Cor</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['COR']; ?></td>
                    </tr>
                    <!--<tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">23.</td>
                        <td>Inspeksi</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['INSPEKSI']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">24.</td>
                        <td>Palpasi</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['PALPASI']; ?></td>
                    </tr>-->
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">23.</td>
                        <td>Ekstremitas</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['EXT']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">24.</td>
                        <td>Leher</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['LEHER']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">25.</td>
                        <td>Abdomen</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['ABDOMEN']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">26.</td>
                        <td>S O A P I E R</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
                            	<td width="10%" style="border-bottom:solid 1px #000;">S</td>
                                <td width="90%" style="border-bottom:solid 1px #000;">:&nbsp;<? echo $rsqlSOAP['ket_S'];?></td>
                            </tr>
                            <tr>
                            	<td width="10%" style="border-bottom:solid 1px #000;">O</td>
                                <td width="90%" style="border-bottom:solid 1px #000;">:&nbsp;<? echo $rsqlSOAP['ket_O'];?></td>
                            </tr>
                            <tr>
                            	<td width="10%" style="border-bottom:solid 1px #000;">A</td>
                                <td width="90%" style="border-bottom:solid 1px #000;">:&nbsp;<? echo $rsqlSOAP['ket_A'];?></td>
                            </tr>
                            <tr>
                            	<td width="10%" style="border-bottom:solid 1px #000;">P</td>
                                <td width="90%" style="border-bottom:solid 1px #000;">:&nbsp;<? echo $rsqlSOAP['ket_P'];?></td>
                            </tr>
                            <tr>
                            	<td width="10%" style="border-bottom:solid 1px #000;">I</td>
                                <td width="90%" style="border-bottom:solid 1px #000;">:&nbsp;<? echo $rsqlSOAP['ket_I'];?></td>
                            </tr>
                            <tr>
                            	<td width="10%" style="border-bottom:solid 1px #000;">E</td>
                                <td width="90%" style="border-bottom:solid 1px #000;">:&nbsp;<? echo $rsqlSOAP['ket_E'];?></td>
                            </tr>
                            <tr>
                            	<td width="10%" style="border-bottom:solid 1px #000;">R</td>
                                <td width="90%" style="border-bottom:solid 1px #000;">:&nbsp;<? echo $rsqlSOAP['ket_R'];?></td>
                            </tr>
                        </table>
                        </td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">27.</td>
                        <td>Masalah yang dihadapi</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">28.</td>
                        <td>Konsultasi</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">29.</td>
                        <td>Pengobatan dan tindakan</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">
                         <table width="100%" border="0">
        <?php $sqlT="select * from
        (SELECT t.id, t.qty, t.biaya, t.qty * t.biaya as subtotal, t.kunjungan_id, t.ms_tindakan_kelas_id, t.pelayanan_id, t.ket, t.unit_act, tk.tarip, tin.nama
        , tin.kode,ifnull(p.nama,'-') as dokter,t.ms_tindakan_unit_id,t.user_id,k.nama as kelas, t.type_dokter,t.tgl_act as tanggal, tin.klasifikasi_id, peg.nama AS petugas
	FROM b_tindakan t
	INNER JOIN b_pelayanan pl ON pl.id = t.pelayanan_id
	INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id
	INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
	INNER JOIN b_ms_tindakan tin ON tin.id = tk.ms_tindakan_id
	LEFT JOIN b_ms_pegawai p ON p.id=t.user_id
	LEFT JOIN b_ms_pegawai peg ON peg.id=t.user_act
	WHERE t.pelayanan_id = '".$_REQUEST['idPel']."') as gab";
$exT=mysql_query($sqlT);
while($dT=mysql_fetch_array($exT)){
?>
          <tr>
            <td class="gb" style="font-size: 13px; "><?=$dT['nama'];?></td>
          </tr>
        <?php }?>  
<?php $sqlT="SELECT ab.OBAT_NAMA FROM b_resep a
INNER JOIN $dbapotek.a_obat ab ON a.obat_id = ab.OBAT_ID
WHERE id_pelayanan = ".$_REQUEST['idPel']."";
$exT=mysql_query($sqlT);
while($dT=mysql_fetch_array($exT)){
?>
          <tr>
            <td class="gb" style="font-size: 13px; "><?=$dT['OBAT_NAMA'];?></td>
          </tr>
        <?php }?>  
		<tr>
<?php $sqlM="SELECT a.obat_manual FROM b_resep a
WHERE id_pelayanan = ".$_REQUEST['idPel']." AND a.obat_manual IS NOT NULL";
$exM=mysql_query($sqlM);
while($dT=mysql_fetch_array($exM)){
?>
			<td class="gb" style="font-size: 13px; "><?=$dT['obat_manual'];?></td>
          </tr>
        <?php }?> 
          <tr>
            <td class="gb">&nbsp;</td>
          </tr>
        </table>
                        </td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">30.</td>
                        <td>Perjalanan penyakit selama perawatan</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">31.</td>
                        <td>Keadaan waktu keluar RS</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwPas['keadaan_keluar'];?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">32.</td>
                        <td>Prognosis</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['PROGNOSIS']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">33.</td>
                        <td>Sebab meninggal</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;">34.</td>
                        <td>Usul tindakan lanjut/anjuran</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['UTINLANJUT']; ?></td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;" height="50%">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <?php
					//$sDok="select * from b_ms_pegawai where id='".$_REQUEST['userId']."'";
					$sDok="SELECT mp.nama FROM anamnese a INNER JOIN b_ms_pegawai mp ON a.PEGAWAI_ID=mp.id WHERE a.PEL_ID='".$_REQUEST['idPel']."'";
					$qDok=mysql_query($sDok);
					$rwDok=mysql_fetch_array($qDok);
					?>
                    <tr style="font-size: 13px; ">
                        <td colspan="4" style="border-left:1px solid; border-right:1px solid;">
                            <table width="85%" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr style="font-size: 13px; ">
                                    <td width="30%" align="center">Dokter Supervisor</td>
                                    <td width="40%">&nbsp;</td>
                                    <td width="30%"><?=$kotaRS?>,&nbsp;<?php echo $date_now;?><br />Dokter yang merawat</td>
                                </tr>
                                <tr style="font-size: 13px; ">
                                    <td height="50%">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr style="font-size: 13px; ">
                                    <td style="padding-top: 60px" align="center">
                                        (<span style="padding-left: 120px" />)
                                    </td>
                                    <td>&nbsp;</td>
                                    <td align="left" style="padding-left: 20px; padding-top: 60px">
                                        (&nbsp;<?php echo $rwDok['nama']; ?>&nbsp;)
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="border-left:1px solid; border-bottom:1px solid; border-right:1px solid;">&nbsp;</td>
        </tr>
        <!--tr id="trTombol">
            <td colspan="4" class="noline" align="center">
                <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
                <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
            </td>
        </tr-->
    </table>
	<script type="text/JavaScript">

        function cetak(tombol){
            tombol.style.visibility='collapse';
            if(tombol.style.visibility=='collapse'){
                if(confirm('Anda Yakin Mau Mencetak Resume Medis Pasien ?')){
                    setTimeout('window.print()','1000');
                    setTimeout('window.close()','2000');
                }
                else{
                    tombol.style.visibility='visible';
                }

            }
        }
    </script>
</div>
<?php 
mysql_close($konek);
?>
<?php

header("Location:../rekam_medis/rm_16_pasien_pulang/new/check.php?idKunj={$_REQUEST['idKunj']}&idPel={$_REQUEST['idPel']}&idPasien=&idUser={$_REQUEST['userId']}&tmpLay=");

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

if($_REQUEST['rm']==1){
	$sLogA = "insert into b_cetak_anamnesa_log(id_anamnesa,pasien_id,user_act,tgl_act) values ('".$_REQUEST['id_anamnesa']."','".$_REQUEST['idPasien']."','".$_REQUEST['userId']."',NOW())";
	$qLogA = mysql_query($sLogA);
}


$sqlPas = "SELECT k.id AS kunjungan_id,k.kso_id, pl.id AS pelayanan_id, p.nama, p.sex, k.umur_thn, p.no_rm,
p.nama AS nama_peserta, (SELECT nama FROM b_ms_kso WHERE id = k.kso_id) AS perusahaan,
kso.st_anggota, kso.no_anggota, (SELECT agama FROM b_ms_agama WHERE id = p.agama) AS agama,
DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl, (SELECT nama FROM b_ms_pekerjaan WHERE id = p.pekerjaan_id) AS pekerjaan, 
DATE_FORMAT(pl.tgl_keluar,'%d-%m-%Y') AS tgl_pulang, p.alamat,
(SELECT nama FROM b_ms_pegawai WHERE id = pl.dokter_tujuan_id) AS dokterMerawat,
(SELECT nama FROM b_ms_pegawai WHERE id = pl.dokter_id) AS dokterPengirim,
(SELECT nama FROM b_ms_kamar WHERE id = k.kamar_id) AS kamar,
(SELECT nama FROM b_ms_kelas WHERE id = k.kelas_id) AS kelas,
(SELECT keadaan_keluar FROM b_pasien_keluar WHERE kunjungan_id=k.id limit 1) AS keadaan_keluar,
k.umur_bln,k.umur_hr, DATE_FORMAT(p.tgl_lahir,'%d-%m-%Y') AS tgl_lahir, pl.unit_id
FROM b_ms_pasien p
INNER JOIN b_kunjungan k ON k.pasien_id = p.id
INNER JOIN b_ms_kso_pasien kso ON kso.pasien_id = p.id
INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
INNER JOIN b_ms_unit u ON u.id = pl.unit_id
left JOIN b_tindakan t ON t.pelayanan_id = pl.id
WHERE 
k.id = '".$_REQUEST['idKunj']."' 
AND pl.jenis_kunjungan = 1 AND pl.id = '".$_REQUEST['idPel']."'";
//echo $sqlPas."<br>";
$rsPas = mysql_query($sqlPas);
$rwPas = mysql_fetch_array($rsPas);

$sKRS="SELECT keadaan_keluar,DATE_FORMAT(tgl_act,'%d-%m-%Y') as tgl_krs FROM b_pasien_keluar WHERE kunjungan_id='".$_REQUEST['idKunj']."'";
$rsKRS=mysql_query($sKRS);
$rwKRS=mysql_fetch_array($rsKRS);
						
?>
<style>

.gb{
	border-bottom:1px solid #000000;
}
</style>
<div align="center">
    <table width="950" border="0" cellpadding="0" cellspacing="0">
        <tr height="50">
            <td width="20%" align="center" style="border-top:1px solid; border-left:1px solid; border-bottom:1px solid;font-size: 14px; font-weight: bold"><?=$namaRS?> <?php echo strtoupper($kotaRS);?></td>
            <td width="58%" align="center" style="border-top:1px solid; border-left:1px solid; border-bottom:1px solid;font-size: 14px; font-weight: bold"><b>RESUME MEDIS (RIWAYAT PENYAKIT)</b></td>
            <td width="22%" align="center" style="border-top:1px solid; border-left:1px solid; border-bottom:1px solid; border-right:1px solid;font-size: 14px; font-weight: bold"><i>LRM. 7</i></td>
        </tr>
        <tr>
            <td colspan="3">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="30">
                        <td width="3%" style="border-left:1px solid; border-bottom:1px solid;">&nbsp;</td>
                        <td width="45%" style="border-bottom:1px solid;font-size: 13px; font-weight: bold">&nbsp;Nama Pasien&nbsp;:&nbsp;&nbsp;&nbsp;<b><?php echo $rwPas['nama'];?>&nbsp;( <?php echo $rwPas['sex'];?> )</b></td>
                        <td width="25%" style="border-bottom:1px solid;font-size: 13px; font-weight: bold">&nbsp;Tgl. Lahir&nbsp;:&nbsp;<?php echo $rwPas['tgl_lahir'];?><br />(<?php echo $rwPas['umur_thn'];?>&nbsp;tahun&nbsp;&nbsp;<?php echo $rwPas['umur_bln'];?>&nbsp;bulan&nbsp;&nbsp;<?php echo $rwPas['umur_hr'];?>&nbsp;hari)</td>
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
                        <td width="14%">&nbsp;Nama Peserta</td>
                        <td width="35%">:&nbsp;<?php /*if ($rwPas['kso_id']==1)*/ echo $rwPas['nama_peserta'];?></td>
                        <td width="17%">&nbsp;Nama Perusahaan</td>
                        <td width="32%">:&nbsp;<?php echo $rwPas['perusahaan'];?></td>
                        <td width="1%" style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>&nbsp;Agama</td>
                        <td>:&nbsp;<?php echo $rwPas['agama'];?></td>
                        <td>&nbsp;No. Asuransi</td>
                        <td>:&nbsp;<?php echo $rwPas['no_anggota'];?></td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>&nbsp;Pekerjaan</td>
                        <td>:&nbsp;<?php echo $rwPas['pekerjaan'];?></td>
                        <td>&nbsp;Tanggal Masuk</td>
                        <td>:&nbsp;<?php echo $rwPas['tgl'];?></td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>&nbsp;Alamat</td>
                        <td>:&nbsp;<?php echo $rwPas['alamat'];?></td>
                        <td>&nbsp;Tgl. Keluar/Meninggal</td>
                        <td>:&nbsp;
						<?php 
							if($rwKRS['tgl_krs']=="")
							{
								echo $rwPas['tgl'];
							}else{
								echo $rwKRS['tgl_krs'];
							}
						?>
                        </td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>&nbsp;Dokter Pengirim</td>
                        <td>:&nbsp;<?php echo $rwPas['dokterPengirim'];?></td>
                        <td>&nbsp;Dokter yang merawat</td>
                        <td>:&nbsp;<?php echo $rwPas['dokterMerawat'];?></td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;border-bottom:1px solid;">&nbsp;</td>
                        <td style="border-bottom:1px solid;">&nbsp;Kelas</td>
                        <td style="border-bottom:1px solid;">:&nbsp;<?php echo $rwPas['kelas'];?></td>
                        <td style="border-bottom:1px solid;">&nbsp;Kunjungan</td>
                        <td style="border-bottom:1px solid;">:&nbsp;RAWAT JALAN</td>
                        <td style="border-right:1px solid;border-bottom:1px solid;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <?php
		$no=0;
		?>
        <tr>
            <td colspan="3">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr style="font-size: 13px; ">
                        <td width="7%" style="border-left:1px solid; border-top:1px solid;">&nbsp;</td>
                        <td width="21%" style="border-top:1px solid;">&nbsp;</td>
                        <td width="2%" style="border-top:1px solid;">&nbsp;</td>
                        <td width="70%" style="border-top:1px solid; border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;"><?php  $no++; echo $no; ?>.</td>
                        <td>Riwayat Perjalanan Penyakit</td>
                        <td align="center">&nbsp;</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <?php
					if($_REQUEST['id_anamnesa']!=''){
						$sAnam = "SELECT a.*,b.nama 
					FROM anamnese a
					INNER JOIN b_ms_pegawai b ON a.PEGAWAI_ID = b.id
					WHERE a.ANAMNESE_ID = '".$_REQUEST['id_anamnesa']."'";
					}
					else{
						$sAnam="SELECT a.*,b.nama 
					FROM anamnese a
					INNER JOIN b_ms_pegawai b ON a.PEGAWAI_ID = b.id
					WHERE a.PASIEN_ID = '".$_REQUEST['idPasien']."' ORDER BY a.TGL DESC LIMIT 1";	
					}
					$qAnam=mysql_query($sAnam);//echo $sAnam;
					$rwAnam=mysql_fetch_array($qAnam);
					?>
                    
                    <?php
					if($rwAnam['KU']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Keluhan Utama</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['KU']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['RPS']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Riwayat Sekarang</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['RPS']; ?></td>
                    </tr>
                    <?php
					}
					?>
					
                    <?php
					if($rwAnam['RPD']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Riwayat Dahulu</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['RPD']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <tr style="font-size: 13px;">
                        <td align="center" style="border-left:1px solid;"><?php  $no++; echo $no; ?>.</td>
                        <td>Pemeriksaan Fisik</td>
                        <td align="center">&nbsp;</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    
                    <?php
					if($rwAnam['KL']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Kepala</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['KL']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['LEHER']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Leher</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['LEHER']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['THORAX']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Thorax</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['THORAX']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['PULMO']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Pulmo</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['PULMO']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['COR']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Cor</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['COR']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['ABDOMEN']!=''){
					?>
                   <!-- <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Abdomen</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['ABDOMEN']; ?></td>
                    </tr>-->
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Abdomen</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['ABDOMEN']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['GENITALIA']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Genitalia</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['GENITALIA']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['EXT']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Extremitas</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['EXT']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['KTELINGA']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Telinga</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['KTELINGA']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['KHIDUNG']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Hidung</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['KHIDUNG']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['KTENGGOROKAN']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Tenggorok</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['KTENGGOROKAN']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['AMATA']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Mata</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['AMATA']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['KKELAMIN']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Kulit Kelamin</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['KKELAMIN']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['TENSI']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Tensi Sistolik</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['TENSI']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                     <?php
					if($rwAnam['TENSI_DIASTOLIK']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Tensi Diastolik</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['TENSI_DIASTOLIK']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['RR']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">RR</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['RR']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['SUHU']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Suhu</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['SUHU']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['NADI']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Nadi</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['NADI']; ?></td>
                    </tr>
                    <?php
					}
					?>
                	
                    <?php
					if($rwAnam['NPS']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">NPS</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['NPS']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['TB']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Tinggi Badan</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['TB']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['BB']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td valign="top">Berat Badan</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwAnam['BB']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['PUPIL']!='' || $rwAnam['TRMENINGGAL']!='' || $rwAnam['NCRAINALES'] || $rwAnam['MOTOKIA']!='' || $rwAnam['MOTOKAA']!='' || $rwAnam['MOTOKIB']!='' || $rwAnam['MOTOKAB']!='' || $rwAnam['RFKIA']!='' || $rwAnam['RFKAA']!='' || $rwAnam['RFKIB']!='' || $rwAnam['RFKAB']!='' || $rwAnam['RPATOLOGIS']!='' || $rwAnam['SENSORIK']!='' || $rwAnam['OTONOM'] || $rwAnam['PKHUSUS']){
					?>    
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Pemeriksaan Neurologi</td>
                        <td align="center">&nbsp;</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['PUPIL']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Pupil</td>
                        <td align="center">:</td>
                        <?php
						if($rwAnam['PUPIL']=='dbm'){
							$xpupil=$rwAnam['PUPIL'];	
						}
						else{
							$pupil=explode(",",$rwAnam['PUPIL']);
							$bentuk=$pupil[0];
							$ukuran=$pupil[1];
							$cahaya=$pupil[2];							
							$xpupil="Bentuk=".$bentuk.", Ukuran=".$ukuran.", Cahaya=".$cahaya;
						}
						
						?>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $xpupil; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['TRMENINGGAL']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Tanda Rangsang Meningeal</td>
                        <td align="center">:</td>
                        <?php
						$trmeninggal=$rwAnam['TRMENINGGAL'];
						if($trmeninggal=='dbm'){
							$xtrmeninggal=$trmeninggal;					
						}
						else{
							$trmeninggal=explode(",",$rwAnam['TRMENINGGAL']);
							if($trmeninggal[0]=='kaku'){
								$xtrmeninggal="Kaku Kuduk ".$trmeninggal[1];
							}
							else if($trmeninggal[0]=='laseque'){
								$xtrmeninggal="Laseque ".$trmeninggal[1];
							}
							else if($trmeninggal[0]=='karning'){
								$xtrmeninggal="Kerning ".$trmeninggal[1];
							}
						}
						?>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $xtrmeninggal; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['NCRAINALES']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Nervi Cranialis</td>
                        <td align="center">:</td>
                        <?php
						$nevicra=$rwAnam['NCRAINALES'];
						if($nevicra=='Dbn'){
							$xnevicra=$nevicra;	
						}
						else{
							$xnevicra="Paresis ".$nevicra;
						}
						?>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $xnevicra; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['MOTOKIA']!='' || $rwAnam['MOTOKAA']!='' || $rwAnam['MOTOKIB']!='' || $rwAnam['MOTOKAB']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Motorik</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;
                        <table width="339" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td width="162" style="border-right:1px solid; border-bottom:1px solid; font-size: 13px;" align="right"><?php echo $rwAnam['MOTOKIA']; ?>&nbsp;</td>
                                <td width="175" style="border-bottom:1px solid; font-size: 13px;" align="left">&nbsp;<?php echo $rwAnam['MOTOKAA']; ?></td>
                            </tr>
                            <tr>
                            	<td style="border-right:1px solid; font-size: 13px;" align="right"><?php echo $rwAnam['MOTOKIB']; ?>&nbsp;</td>
                                <td align="left" style="font-size: 13px;">&nbsp;<?php echo $rwAnam['MOTOKAB']; ?></td>
                            </tr>
                        </table>
                        </td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['RFKIA']!='' || $rwAnam['RFKAA']!='' || $rwAnam['RFKIB']!='' || $rwAnam['RFKAB']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Reflek Fisiologis</td>
                      	<td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;
                        <table width="339" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td width="162" style="border-right:1px solid; border-bottom:1px solid; font-size: 13px;" align="right"><?php echo $rwAnam['RFKIA']; ?>&nbsp;</td>
                                <td width="175" style="border-bottom:1px solid; font-size: 13px;" align="left">&nbsp;<?php echo $rwAnam['RFKAA']; ?></td>
                            </tr>
                            <tr>
                            	<td style="border-right:1px solid; font-size: 13px;" align="right"><?php echo $rwAnam['RFKIB']; ?>&nbsp;</td>
                                <td align="left" style="font-size: 13px;">&nbsp;<?php echo $rwAnam['RFKAB']; ?></td>
                            </tr>
                        </table>
                      </td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['RPATOLOGIS']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Reflek Patologis</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['RPATOLOGIS']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['SENSORIK']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Sensorik</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['SENSORIK']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['OTONOM']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Otonom</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['OTONOM']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwAnam['PKHUSUS']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>Pemeriksaan Khusus</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['PKHUSUS']; ?></td>
                    </tr>
                    <?php
					}
                    ?>
                    
                    <?php
					if($rwAnam['PPENUNJANG']!=''){
					?>
                    <tr style="font-size: 13px;">
                        <td align="center" style="border-left:1px solid;"><?php  $no++; echo $no; ?>.</td>
                        <td>Pemeriksaan Penunjang</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['PPENUNJANG']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
						$sqlT="select * from
                                        (SELECT t.id, t.qty, t.biaya, t.qty * t.biaya as subtotal, t.kunjungan_id, t.ms_tindakan_kelas_id, t.pelayanan_id, t.ket, t.unit_act, tk.tarip, tin.nama
                                        , tin.kode,ifnull(p.nama,'-') as dokter,t.ms_tindakan_unit_id,t.user_id,k.nama as kelas, t.type_dokter,t.tgl_act as tanggal, tin.klasifikasi_id, peg.nama AS petugas
                                        FROM b_tindakan t
                                        INNER JOIN b_pelayanan pl ON pl.id = t.pelayanan_id
                                        INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id
                                        INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
                                        INNER JOIN b_ms_tindakan tin ON tin.id = tk.ms_tindakan_id
                                        LEFT JOIN b_ms_pegawai p ON p.id=t.user_id
                                        LEFT JOIN b_ms_pegawai peg ON peg.id=t.user_act
                                        WHERE 
										t.kunjungan_id = '".$_REQUEST['idKunj']."' AND pl.jenis_kunjungan=1) as gab";
                    $exT=mysql_query($sqlT);
					$nexT=mysql_num_rows($exT);
					if($nexT>0){
					?>
                    <tr style="font-size: 13px;">
                        <td align="center" style="border-left:1px solid;" valign="top"><?php  $no++; echo $no; ?>.</td>
                        <td valign="top">Tindakan</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;">
                         	<table width="100%" border="0">
							<?php 
                                    while($dT=mysql_fetch_array($exT)){
                                        $queryB = "SELECT concat('[',kode_icd_9cm,']') as kode_icd_9cm FROM b_tindakan_icd9cm WHERE b_tindakan_id = $dT[id]";
                                        $execB = mysql_fetch_array(mysql_query($queryB));
                            ?>
          						<tr>
            						<td style="font-size: 13px; "><?=$dT['nama']." ".$execB['kode_icd_9cm'];?></td>
          						</tr>
        						<?php }?>	
        					</table>
                        </td>
                    </tr>
                    <?php
					}
					?>
					
                    <?php
					$sqlNoResep = "SELECT b_resep.id_pelayanan,b_resep.no_resep 
					FROM b_resep 
					INNER JOIN b_pelayanan ON b_pelayanan.id = b_resep.id_pelayanan
					WHERE b_resep.kunjungan_id='".$_REQUEST['idKunj']."' 
					AND b_pelayanan.jenis_kunjungan=1
					ORDER BY b_resep.id DESC LIMIT 1";
					$rsNoResep = mysql_query($sqlNoResep);
					$rwNoResep = mysql_fetch_array($rsNoResep);
					
					/*
					$sqlO = "SELECT 
							b_resep.id, 
							IFNULL($dbapotek.a_obat.OBAT_NAMA,b_resep.obat_manual) OBAT_NAMA, 
							b_resep.qty, 
							b_resep.ket_dosis 
							FROM b_resep
							INNER JOIN b_pelayanan ON b_pelayanan.id = b_resep.id_pelayanan
							LEFT JOIN $dbapotek.a_obat ON $dbapotek.a_obat.OBAT_ID=b_resep.obat_id
							WHERE b_resep.kunjungan_id = '".$_REQUEST['idKunj']."' AND b_resep.id_pelayanan = '".$rwNoResep['id_pelayanan']."' AND b_resep.no_resep='".$rwNoResep['no_resep']."' AND b_pelayanan.jenis_kunjungan=1";
					*/	
					/* echo $sqlO = "SELECT 
							b_resep.id, 
							IFNULL($dbapotek.a_obat.OBAT_NAMA,b_resep.obat_manual) OBAT_NAMA, 
							b_resep.qty, 
							b_resep.ket_dosis 
							FROM b_resep
							INNER JOIN b_pelayanan ON b_pelayanan.id = b_resep.id_pelayanan
							LEFT JOIN $dbapotek.a_obat ON $dbapotek.a_obat.OBAT_ID=b_resep.obat_id
							WHERE b_resep.kunjungan_id = '".$_REQUEST['idKunj']."' AND b_pelayanan.jenis_kunjungan=1"; */
					
					$sqlO = "SELECT a.id, IFNULL(ab.OBAT_NAMA,a.obat_manual) OBAT_NAMA, a.qty, a.ket_dosis,
IFNULL((SELECT distinct $dbapotek.a_penerimaan.OBAT_ID FROM $dbapotek.a_penjualan 
INNER JOIN $dbapotek.a_penerimaan 
ON $dbapotek.a_penjualan.PENERIMAAN_ID = $dbapotek.a_penerimaan.ID
WHERE $dbapotek.a_penjualan.NO_KUNJUNGAN= b.id 
AND $dbapotek.a_penerimaan.OBAT_ID = a.obat_id),'true') AS dilayani
FROM b_resep a INNER JOIN b_pelayanan b ON b.id = a.id_pelayanan 
LEFT JOIN $dbapotek.a_obat ab ON ab.OBAT_ID=a.obat_id
WHERE a.kunjungan_id = '".$_REQUEST['idKunj']."' AND b.jenis_kunjungan=1
UNION
SELECT '0' AS id, ab.OBAT_NAMA, a.QTY, ' ' AS ket_dosis, 'false' AS dilayani FROM $dbapotek.a_penjualan a 
INNER JOIN $dbapotek.a_penerimaan b ON a.PENERIMAAN_ID = b.ID
INNER JOIN $dbapotek.a_obat ab ON b.OBAT_ID = ab.OBAT_ID
INNER JOIN b_pelayanan ac on ac.id = a.NO_KUNJUNGAN and ac.kunjungan_id = ".$_REQUEST['idKunj']." AND ac.jenis_kunjungan=1
WHERE b.OBAT_ID NOT IN (SELECT obat_id FROM b_resep WHERE kunjungan_id = '".$_REQUEST['idKunj']."');";
					//echo $sqlO;
                    $rsO=mysql_query($sqlO);
					?>
                    
                    <?php
					$qDiagAkhir = "SELECT GROUP_CONCAT(CONCAT(b_ms_diagnosa.kode,' ',IFNULL(b_diagnosa.diagnosa_manual,b_ms_diagnosa2.nama)) SEPARATOR '<br>&nbsp;') as diagnosa, b_diagnosa.diagnosa_id, ' ' as kode
						FROM b_diagnosa_rm 
						INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
						INNER JOIN b_ms_pegawai ON b_diagnosa_rm.user_id = b_ms_pegawai.id
						inner join b_diagnosa ON b_diagnosa.diagnosa_id = b_diagnosa_rm.diagnosa_id
						inner join b_pelayanan ON b_pelayanan.id = b_diagnosa.pelayanan_id
						left join b_ms_diagnosa as b_ms_diagnosa2 ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id 
						WHERE 
						b_diagnosa_rm.kunjungan_id = '".$_REQUEST['idKunj']."' AND b_diagnosa.akhir = 1 AND b_pelayanan.jenis_kunjungan=1
						GROUP BY b_diagnosa_rm.kunjungan_id";
					$rsDiagAkhir = mysql_query($qDiagAkhir);
					$nDiagAkhir = mysql_num_rows($rsDiagAkhir);
					if($nDiagAkhir==0){
						/*
						$qDiagAkhir = "SELECT GROUP_CONCAT(CONCAT(b_ms_diagnosa.kode,' ',IFNULL(b_diagnosa_rm.diagnosa_manual,b_ms_diagnosa2.nama)) SEPARATOR '<br>&nbsp;') as diagnosa
						FROM b_diagnosa_rm 
						INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
						INNER JOIN b_ms_pegawai ON b_diagnosa_rm.user_id = b_ms_pegawai.id
						inner join b_diagnosa ON b_diagnosa.diagnosa_id = b_diagnosa_rm.diagnosa_id
						left join b_ms_diagnosa as b_ms_diagnosa2 ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id 
						WHERE 
						b_diagnosa_rm.kunjungan_id = '".$_REQUEST['idKunj']."'  AND b_diagnosa.primer = 1
						GROUP BY b_diagnosa_rm.kunjungan_id";
						*/
						$qDiagAkhir = "SELECT IFNULL(b_diagnosa.diagnosa_manual,b_ms_diagnosa2.nama) as diagnosa, b_diagnosa.diagnosa_id, b_ms_diagnosa.kode
						from b_diagnosa
  LEFT JOIN b_ms_diagnosa AS b_ms_diagnosa2 
    ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id 
  LEFT JOIN b_diagnosa_rm  
    ON b_diagnosa.diagnosa_id = b_diagnosa_rm.diagnosa_id 
  LEFT JOIN b_ms_pegawai 
    ON b_diagnosa_rm.user_id = b_ms_pegawai.id 
  INNER JOIN b_pelayanan 
    ON b_pelayanan.id = b_diagnosa.pelayanan_id 
  LEFT JOIN b_ms_diagnosa 
    ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id 
						WHERE 
						b_diagnosa.kunjungan_id = '".$_REQUEST['idKunj']."' AND b_diagnosa.primer = 1 AND b_pelayanan.jenis_kunjungan=1
						ORDER BY b_diagnosa.diagnosa_id DESC
						LIMIT 1";
						$rsDiagAkhir = mysql_query($qDiagAkhir);	
					}
					$rwDiagAkhir = mysql_fetch_array($rsDiagAkhir);
					$idamb = 0;
					if($rwDiagAkhir['diagnosa']!=''){
						//$idamb = $rwDiagAkhir['diagnosa_id'];
					?>
                    <!--<tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;" valign="top"><?php  $no++; echo $no; ?>.</td>
                        <td valign="top">Diagnosa Akhir</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">&nbsp;<?php echo $rwDiagAkhir['kode']; ?>&nbsp;<?php echo $rwDiagAkhir['diagnosa']; ?></td>
                    </tr>-->
                    <?php
					}
					?>
                    
                    <?php
					$qDiagAkhir = "SELECT IFNULL(b_diagnosa.diagnosa_manual,b_ms_diagnosa2.nama) as diagnosa, b_ms_diagnosa.kode, b_diagnosa.diagnosa_id
						from b_diagnosa
  LEFT JOIN b_ms_diagnosa AS b_ms_diagnosa2 
    ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id 
  LEFT JOIN b_diagnosa_rm  
    ON b_diagnosa.diagnosa_id = b_diagnosa_rm.diagnosa_id 
  LEFT JOIN b_ms_pegawai 
    ON b_diagnosa_rm.user_id = b_ms_pegawai.id 
  INNER JOIN b_pelayanan 
    ON b_pelayanan.id = b_diagnosa.pelayanan_id 
  LEFT JOIN b_ms_diagnosa 
    ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id 
						WHERE 
						b_diagnosa.kunjungan_id = '".$_REQUEST['idKunj']."' AND b_diagnosa.primer = 1 AND b_pelayanan.jenis_kunjungan=1 AND b_diagnosa.diagnosa_id <> '$idamb'";
					$rsDiagAkhir = mysql_query($qDiagAkhir);	
					$nDiagAkhir = mysql_num_rows($rsDiagAkhir);
					
					if($nDiagAkhir == 0)
					{
						$qDiagAkhir = "SELECT IFNULL(b_diagnosa.diagnosa_manual,b_ms_diagnosa2.nama) as diagnosa, b_ms_diagnosa.kode, b_diagnosa.diagnosa_id
						from b_diagnosa
  LEFT JOIN b_ms_diagnosa AS b_ms_diagnosa2 
    ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id 
  LEFT JOIN b_diagnosa_rm  
    ON b_diagnosa.diagnosa_id = b_diagnosa_rm.diagnosa_id 
  LEFT JOIN b_ms_pegawai 
    ON b_diagnosa_rm.user_id = b_ms_pegawai.id 
  INNER JOIN (SELECT b_pelayanan.id, b_pelayanan.jenis_kunjungan
FROM b_pelayanan INNER JOIN b_diagnosa ON b_pelayanan.id = b_diagnosa.pelayanan_id
WHERE pasien_id = '".$_REQUEST['idPasien']."' and b_pelayanan.id <= '".$_REQUEST['idPel']."'
ORDER BY id DESC 
LIMIT 1) AS tb1 
    ON tb1.id = b_diagnosa.pelayanan_id 
  LEFT JOIN b_ms_diagnosa 
    ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id 
WHERE b_diagnosa.primer = 1 AND b_diagnosa.diagnosa_id <> '$idamb'";	
					$rsDiagAkhir = mysql_query($qDiagAkhir);	
					$nDiagAkhirLM = mysql_num_rows($rsDiagAkhir);
					}
					
					//echo $qDiagAkhir;
					if($nDiagAkhir > 0 || $nDiagAkhirLM > 0){
						?>
                        <tr style="font-size: 13px; ">
                            <td align="center" style="border-left:1px solid;" valign="top"><?php  $no++; echo $no; ?>.</td>
                            <td valign="top">Diagnosa Utama</td>
                            <td align="center" valign="top">:</td>
                            <td style="border-right:1px solid;" valign="top">
							<?php 
							while($rwDiagAkhir = mysql_fetch_array($rsDiagAkhir))
							{
								$queryB = "SELECT diagnosa_manual FROM b_diagnosa WHERE diag_banding_id = ".$rwDiagAkhir['diagnosa_id']." AND diagnosa_manual <> ''";
								$ExqueryB = mysql_query($queryB);
								if($rwDiagAkhir['kode']=="")echo " ".$rwDiagAkhir['diagnosa'];
								else echo " ".$rwDiagAkhir['diagnosa']."&nbsp;[".$rwDiagAkhir['kode']."]";
								while($DqueryB = mysql_fetch_array($ExqueryB))
								{
									echo "/".$DqueryB['diagnosa_manual'];
								}
								echo "<br>";
							} 
							?></td>
                    	</tr>
                        <?
					}
					?>
                    
                    <?php
					$qDiagAkhir = "SELECT IFNULL(b_diagnosa.diagnosa_manual,b_ms_diagnosa2.nama) as diagnosa, b_ms_diagnosa.kode, b_diagnosa.diagnosa_id
						from b_diagnosa
  LEFT JOIN b_ms_diagnosa AS b_ms_diagnosa2 
    ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id 
  LEFT JOIN b_diagnosa_rm  
    ON b_diagnosa.diagnosa_id = b_diagnosa_rm.diagnosa_id 
  LEFT JOIN b_ms_pegawai 
    ON b_diagnosa_rm.user_id = b_ms_pegawai.id 
  INNER JOIN b_pelayanan 
    ON b_pelayanan.id = b_diagnosa.pelayanan_id 
  LEFT JOIN b_ms_diagnosa 
    ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id 
						WHERE 
						b_diagnosa.kunjungan_id = '".$_REQUEST['idKunj']."' AND b_diagnosa.primer = 0 AND b_pelayanan.jenis_kunjungan=1 AND b_diagnosa.diagnosa_id <> '$idamb' AND diag_banding_id = 0";
					$rsDiagAkhir = mysql_query($qDiagAkhir);	
					$nDiagAkhir2 = mysql_num_rows($rsDiagAkhir);
					
					if($nDiagAkhir == 0 && $nDiagAkhir2 == 0 && $nDiagAkhirLM != 0)
					{
						$qDiagAkhir = "SELECT IFNULL(b_diagnosa.diagnosa_manual,b_ms_diagnosa2.nama) as diagnosa, b_ms_diagnosa.kode, b_diagnosa.diagnosa_id
						from b_diagnosa
  LEFT JOIN b_ms_diagnosa AS b_ms_diagnosa2 
    ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id 
  LEFT JOIN b_diagnosa_rm  
    ON b_diagnosa.diagnosa_id = b_diagnosa_rm.diagnosa_id 
  LEFT JOIN b_ms_pegawai 
    ON b_diagnosa_rm.user_id = b_ms_pegawai.id 
  INNER JOIN (SELECT b_pelayanan.id, b_pelayanan.jenis_kunjungan
FROM b_pelayanan INNER JOIN b_diagnosa ON b_pelayanan.id = b_diagnosa.pelayanan_id
WHERE pasien_id = '".$_REQUEST['idPasien']."' and b_pelayanan.id <= '".$_REQUEST['idPel']."'
ORDER BY id DESC 
LIMIT 1) AS tb1 
    ON tb1.id = b_diagnosa.pelayanan_id 
  LEFT JOIN b_ms_diagnosa 
    ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id 
WHERE b_diagnosa.primer = 0 AND tb1.jenis_kunjungan=1 AND b_diagnosa.diagnosa_id <> '$idamb' AND diag_banding_id = 0";
					$rsDiagAkhir = mysql_query($qDiagAkhir);	
					$nDiagAkhir2 = mysql_num_rows($rsDiagAkhir);
					}
					
					//echo $qDiagAkhir."<br>";
					if($nDiagAkhir2 > 0){
						?>
                        <tr style="font-size: 13px; ">
                            <td align="center" style="border-left:1px solid;" valign="top"><?php  $no++; echo $no; ?>.</td>
                            <td valign="top">Diagnosa Sekunder</td>
                            <td align="center" valign="top">:</td>
                            <td style="border-right:1px solid;" valign="top">
							<?php 
							while($rwDiagAkhir = mysql_fetch_array($rsDiagAkhir))
							{
								$queryB = "SELECT diagnosa_manual FROM b_diagnosa WHERE diag_banding_id = ".$rwDiagAkhir['diagnosa_id']." AND diagnosa_manual <> ''";
								$ExqueryB = mysql_query($queryB);
								if($rwDiagAkhir['kode']=="")echo " ".$rwDiagAkhir['diagnosa'];
								else echo $rwDiagAkhir['diagnosa']."&nbsp;[".$rwDiagAkhir['kode']."]";
								while($DqueryB = mysql_fetch_array($ExqueryB))
								{
									echo "/".$DqueryB['diagnosa_manual'];
								}
								echo "<br>";
							} 
							?></td>
                    	</tr>
                        <?
					}
					?>
                    
                    <?
                    if(mysql_num_rows($rsO)>0){
					?>                    
                    <tr style="font-size: 13px;">
                        <td align="center" style="border-left:1px solid;" valign="top"><?php  $no++; echo $no; ?>.</td>
                        <td valign="top">Pengobatan</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;">
                        	<table width="100%" border="0">
							<?php		
                            while($rwO=mysql_fetch_array($rsO)){
								
								if($rwO['dilayani']!='false')
								{
                            ?>
          						<tr>
            						<td style="font-size: 13px; "><?=$rwO['OBAT_NAMA']." (".$rwO['ket_dosis'].")";?>
                                    <?
										if($rwO['dilayani']=='true'){
											echo "[obat diubah]";
										}
                                    ?>
                                    </td>
          						</tr>
        						<?php }else{
									?>
                                    <tr>
            						<td style="font-size: 13px; "><span style="color:#F00"><?=$rwO['OBAT_NAMA']." (".$rwO['ket_dosis'].")";?></span>
                                    </td>
          						</tr>
                                    <?
									}
								}?>	
        					</table>
                        </td>
                    </tr>
                    <?php
					}
					?>
                    
                     <?php
					if($rwAnam['UTINLANJUT']!=''){
					?>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;"><?php  $no++; echo $no; ?>.</td>
                        <td>Anjuran/Usul Tindakan Lanjut</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwAnam['UTINLANJUT']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <?php
					if($rwKRS['keadaan_keluar']!=''){
					?>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;"><?php  $no++; echo $no; ?>.</td>
                        <td>Keadaan waktu pulang</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rwKRS['keadaan_keluar']; ?></td>
                    </tr>
                    <?php
					}
					?>
                    
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;" height="50%">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td colspan="4" style="border-left:1px solid; border-right:1px solid;">
                            <table width="85%" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr style="font-size: 13px;">
                                    <td width="30%" align="center">&nbsp;</td>
                                    <td width="35%">&nbsp;</td>
                                    <td width="35%" align="center"><? $kotaRS; ?>&nbsp;<?php $date_now;?><br />Dokter yang merawat</td>
                                </tr>
                                <tr style="font-size: 13px; ">
                                    <td height="50%">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr style="font-size: 13px; ">
                                    <td style="padding-top: 60px" align="center">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="center" style="padding-top: 60px">
                                        (&nbsp;<?php 
										if(($rwPas['unit_id']!=58) && ($rwPas['unit_id']!=61))
										{
											echo $rwPas['dokterMerawat']; 	
										}else{
											echo $rwPas['dokterPengirim']; 	
										}
										?>&nbsp;)
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
        <?php
        	$queryReg = "SELECT b.nama FROM b_kunjungan a
							INNER JOIN b_ms_pegawai b ON a.user_act = b.id
							WHERE a.id = '".$_REQUEST['idKunj']."';";
			$dqueryReg = mysql_fetch_array(mysql_query($queryReg));
			$querCoding = "SELECT DISTINCT b.nama FROM b_diagnosa_rm a
							INNER JOIN b_ms_pegawai b ON a.user_act = b.id 
							WHERE a.kunjungan_id = '".$_REQUEST['idKunj']."' ORDER BY a.id DESC;";
			$dquerCoding = mysql_fetch_array(mysql_query($querCoding));
		?>
        <!--<tr>
        	<td colspan="2" style="border-left:1px solid; border-top:1px solid; font-size:14px; vertical-align: top; text-align: left;" align="left">
            Dibuat di: Medan &nbsp;&nbsp;&nbsp;&nbsp; Tanggal: <?php echo $rwPas['tgl'];?> <br />
            Resume Elektronik Ini Syah Tanpa Tanda Tangan <br />
            UU Praktek Kedokteran No. 29/2004 Penjelasan Pasal 46(3)
            </td>
            <td colspan="2" style="border-top:1px solid; border-right:1px solid;" align="right">
            Printed By : <? echo $_SESSION['nm_pegawai'];?> <br />
            Registration By : <? echo $dqueryReg['nama'];?> <br />
            Coding By : <? echo $dquerCoding['nama'];?> <br />
            Dokter By : <? $rwAnam['nama']; echo $rwPas['dokterMerawat']; ?> <br />
            </td>
        </tr>-->
        <tr>
            <td colspan="4">
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            	<tr>
                    <td style="border-left:1px solid; border-top:1px solid; font-size:14px; vertical-align: top; text-align: left;" align="left">
                    Dibuat di: <?php echo strtoupper($kotaRS);?> &nbsp;&nbsp;&nbsp;&nbsp; Tanggal: <?php echo $rwPas['tgl'];?> <br />
                    Resume Elektronik Ini Syah Tanpa Tanda Tangan <br />
                    UU Praktek Kedokteran No. 29/2004 Penjelasan Pasal 46(3)
                    </td>
                    <td style="border-top:1px solid; border-right:1px solid;" align="right">
                    Printed By : <? echo $_SESSION['nm_pegawai'];?> <br />
                    Registration By : <? echo $dqueryReg['nama'];?> <br />
                    Coding By : <? echo $dquerCoding['nama'];?> <br />
                    Dokter By : <? $rwAnam['nama']; echo $rwPas['dokterMerawat']; ?> <br />
                    </td>
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
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

if($_REQUEST['rm']==1){
	$sLogA = "insert into b_cetak_anamnesa_log(id_anamnesa,pasien_id,user_act,tgl_act) values ('".$_REQUEST['id_anamnesa']."','".$_REQUEST['idPasien']."','".$_REQUEST['userId']."',NOW())";
	$qLogA = mysql_query($sLogA);
}


$sqlPas = "SELECT k.id AS kunjungan_id,k.kso_id, pl.id AS pelayanan_id, p.nama, p.sex, k.umur_thn, p.no_rm,
p.nama AS nama_peserta, (SELECT nama FROM b_ms_kso WHERE id = k.kso_id) AS perusahaan,
kso.st_anggota, kso.no_anggota, (SELECT agama FROM b_ms_agama WHERE id = p.agama) AS agama,
DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl, (SELECT nama FROM b_ms_pekerjaan WHERE id = p.pekerjaan_id) AS pekerjaan, 
DATE_FORMAT(pl.tgl_keluar,'%d-%m-%Y') AS tgl_pulang, p.alamat,
(SELECT nama FROM b_ms_pegawai WHERE id = t.user_id) AS dokterMerawat,
(SELECT nama FROM b_ms_pegawai WHERE id = pl.dokter_id) AS dokterPengirim,
(SELECT nama FROM b_ms_pegawai WHERE id = pl.dokter_tujuan_id) AS dokterTujuan,
(SELECT nama FROM b_ms_kamar WHERE id = k.kamar_id) AS kamar,
(SELECT nama FROM b_ms_kelas WHERE id = k.kelas_id) AS kelas,
(SELECT keadaan_keluar FROM b_pasien_keluar WHERE kunjungan_id=k.id limit 1) AS keadaan_keluar,
k.umur_bln,k.umur_hr, DATE_FORMAT(p.tgl_lahir, '%d-%m-%Y') AS tgl_lahir
FROM b_ms_pasien p
INNER JOIN b_kunjungan k ON k.pasien_id = p.id
LEFT JOIN b_ms_kso_pasien kso ON kso.pasien_id = p.id
INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
INNER JOIN b_ms_unit u ON u.id = pl.unit_id
left JOIN b_tindakan t ON t.pelayanan_id = pl.id
WHERE 
k.id = '".$_REQUEST['idKunj']."' 
AND pl.jenis_kunjungan = 2";
//echo $sqlPas."<br>";
$rsPas = mysql_query($sqlPas);
$rwPas = mysql_fetch_array($rsPas);

$dokter=$rwPas['dokterMerawat'];	
					
$sqlSOAP="SELECT a.*,pg.nama 
FROM $dbaskep.ask_soap a
INNER JOIN b_pelayanan b ON a.pelayanan_id = b.id
INNER JOIN b_ms_pegawai pg ON pg.id=a.user_id
WHERE 
b.kunjungan_id = ".$_REQUEST['idKunj']."
AND b.jenis_kunjungan = 2
/*AND pg.spesialisasi_id<>0*/
ORDER BY a.id DESC LIMIT 1";
$dsqlSOAP = mysql_query($sqlSOAP);//echo $sqlSOAP;
$rsqlSOAP = mysql_fetch_array($dsqlSOAP);


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
            <td width="20%" align="center" style="border-top:1px solid; border-left:1px solid; border-bottom:1px solid;font-size: 14px; font-weight: bold">RSUD<br /><?php echo strtoupper($kotaRS);?></td>
            <td width="60%" align="center" style="border-top:1px solid; border-left:1px solid; border-bottom:1px solid;font-size: 14px; font-weight: bold"><b>RESUME MEDIS (RIWAYAT PENYAKIT)</b></td>
            <td width="20%" align="center" style="border-top:1px solid; border-left:1px solid; border-bottom:1px solid; border-right:1px solid;font-size: 14px; font-weight: bold"><i>LRM. 7</i></td>
        </tr>
        <tr>
            <td colspan="3">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="30">
                        <td width="3%" style="border-left:1px solid; border-bottom:1px solid;">&nbsp;</td>
                        <td width="45%" style="border-bottom:1px solid;font-size: 13px; font-weight: bold">&nbsp;Nama Pasien&nbsp;:&nbsp;&nbsp;&nbsp;<b><?php echo $rwPas['nama'];?> &nbsp;( <?php echo $rwPas['sex'];?> )</b></td>
                        <td width="25%" style="border-bottom:1px solid;font-size: 13px; font-weight: bold">&nbsp;Tgl. Lahiir&nbsp;:&nbsp;<?php echo $rwPas['tgl_lahir'];?><br />(<?php echo $rwPas['umur_thn'];?>&nbsp;tahun&nbsp;&nbsp;<?php echo $rwPas['umur_bln'];?>&nbsp;bulan&nbsp;&nbsp;<?php echo $rwPas['umur_hr'];?>)&nbsp;hari</td>
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
                        <td width="15%">&nbsp;Nama Peserta</td>
                        <td width="36%">:&nbsp;<?php /*if ($rwPas['kso_id']==1)*/ echo $rwPas['nama_peserta'];?></td>
                        <td width="17%">&nbsp;Nama Perusahaan</td>
                        <td width="30%">:&nbsp;<?php echo $rwPas['perusahaan'];?></td>
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
                        <td>:&nbsp;<?php echo $rwKRS['tgl_krs'];?></td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px; ">
                        <td style="border-left:1px solid;">&nbsp;</td>
                        <td>&nbsp;Dokter Pengirim</td>
                        <td>:&nbsp;<?php echo $rwPas['dokterPengirim'];?></td>
                        <td>&nbsp;Dokter yang merawat</td>
                        <td>:&nbsp;<?php echo $dokter;?></td>
                        <td style="border-right:1px solid;">&nbsp;</td>
                    </tr>
                    <tr style="font-size: 13px;">
                        <td style="border-left:1px solid; border-bottom:1px solid;">&nbsp;</td>
                        <td style="border-bottom:1px solid;">&nbsp;Kelas</td>
                        <td style="border-bottom:1px solid;">:&nbsp;<?php echo $rwPas['kelas'];?></td>
                        <td style="border-bottom:1px solid;">&nbsp;Kunjungan</td>
                        <td style="border-bottom:1px solid;">:&nbsp;IGD</td>
                        <td style="border-right:1px solid; border-bottom:1px solid;">&nbsp;</td>
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
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rsqlSOAP['ket_S']; ?></td>
                    </tr>
                    <tr style="font-size: 13px;">
                        <td align="center" style="border-left:1px solid;"><?php  $no++; echo $no; ?>.</td>
                        <td>Pemeriksaan Fisik</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;<?php echo $rsqlSOAP['ket_O']."<br>".$rsqlSOAP['ket_P']; ?></td>
                    </tr>                    
                    <?php
					$sqlL="SELECT d.id,d.nama_kelompok,c.nama,b.metode,IF(b.normal2='',b.normal1,CONCAT(b.normal1,' - ',b.normal2)) AS normal,
a.id_pelayanan,DATE_FORMAT(a.tgl_act, '%d-%m-%Y') tglHasil,msl.nama_satuan,a.hasil as hasilc,a.hasil,a.ket, IFNULL((SELECT nama_kelompok FROM b_ms_kelompok_lab WHERE id = d.`parent_id`),d.nama_kelompok) AS parent 
, IFNULL((SELECT id FROM b_ms_kelompok_lab WHERE id = d.`parent_id`),d.id) AS parentId, b.normal1, b.normal2 
FROM (SELECT bhp.* FROM b_hasil_lab bhp INNER JOIN b_pelayanan bp ON bhp.id_pelayanan = bp.id AND bp.accLab = 3
WHERE id_kunjungan='".$_REQUEST['idKunj']."' AND bp.jenis_kunjungan=2) AS a 
INNER JOIN b_ms_normal_lab b ON a.id_normal=b.id 
INNER JOIN b_ms_pemeriksaan_lab c ON b.id_pemeriksaan_lab=c.id 
INNER JOIN b_ms_kelompok_lab d ON c.kelompok_lab_id=d.id 
INNER JOIN b_ms_satuan_lab msl ON b.id_satuan=msl.id ORDER BY a.id_pelayanan,c.kode_urut";
					$exL=mysql_query($sqlL);
					if(mysql_num_rows($exL)>0){
					?>
                    <tr style="font-size: 13px;">
                        <td align="center" style="border-left:1px solid;"><?php  $no++; echo $no; ?>.</td>
                        <td>Pemeriksaan Penunjang</td>
                        <td align="center">:</td>
                        <td style="border-right:1px solid;">&nbsp;
                        <table width="100%" border="0">
        				<?php 
						while($dL=mysql_fetch_array($exL)){
							$normal=$dL['normal'];
							if ($dL['nama_satuan']!="" && $dL['nama_satuan']!="-") $normal.=" ".$dL['nama_satuan'];
						?>
                          <tr style="font-size: 13px;">
                            <td width="40%" class="gb"><?php echo $dL['nama'];?></td>
                            <td width="30%" class="gb"><?php echo "Hasil : ".$dL['hasil'];?></td>
                            <td width="30%" class="gb"><?php echo "Normal : ".$normal;?></td>
                          </tr>
        				<?php }?>  
        				</table>
                        </td>
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
                                        WHERE t.kunjungan_id = '".$_REQUEST['idKunj']."' AND pl.jenis_kunjungan=2) as gab";
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
					AND b_pelayanan.jenis_kunjungan=2
					ORDER BY b_resep.id DESC LIMIT 1";
					$rsNoResep = mysql_query($sqlNoResep);
					$rwNoResep = mysql_fetch_array($rsNoResep);
					
					$sqlO = "SELECT 
							b_resep.id, 
							IFNULL($dbapotek.a_obat.OBAT_NAMA,b_resep.obat_manual) OBAT_NAMA, 
							b_resep.qty, 
							b_resep.ket_dosis 
							FROM b_resep
							INNER JOIN b_pelayanan ON b_pelayanan.id = b_resep.id_pelayanan
							LEFT JOIN $dbapotek.a_obat ON $dbapotek.a_obat.OBAT_ID=b_resep.obat_id
							WHERE b_resep.kunjungan_id = '".$_REQUEST['idKunj']."' 
							AND b_resep.id_pelayanan = '".$rwNoResep['id_pelayanan']."' 
							AND b_resep.no_resep='".$rwNoResep['no_resep']."'
							AND b_pelayanan.jenis_kunjungan=2";
                    $rsO=mysql_query($sqlO);
					?>
                    
                    <?php
					/*
					$qDiagAkhir = "SELECT 
						GROUP_CONCAT(CONCAT(b_ms_diagnosa.kode,' ',IFNULL(b_diagnosa_rm.diagnosa_manual,b_ms_diagnosa2.nama)) SEPARATOR '<br>&nbsp;') as diagnosa
						FROM b_diagnosa_rm 
						INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
						INNER JOIN b_ms_pegawai ON b_diagnosa_rm.user_id = b_ms_pegawai.id
						inner join b_diagnosa ON b_diagnosa.diagnosa_id = b_diagnosa_rm.diagnosa_id
						inner join b_pelayanan ON b_pelayanan.id = b_diagnosa.pelayanan_id
						left join b_ms_diagnosa as b_ms_diagnosa2 ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id 
						WHERE 
						b_diagnosa_rm.kunjungan_id = '".$_REQUEST['idKunj']."'
						AND b_pelayanan.jenis_kunjungan=2
						GROUP BY b_diagnosa_rm.kunjungan_id";
					$rsDiagAkhir = mysql_query($qDiagAkhir);
					*/
					
					/*$qDiagAkhir = "SELECT 
					  GROUP_CONCAT(CONCAT(IFNULL(a.diagnosa_manual, b_ms_diagnosa.nama),' ',IFNULL((SELECT IFNULL(CONCAT('/',diagnosa_manual),'') FROM b_diagnosa a WHERE diag_banding_id = a.diagnosa_id),' '),' ', IFNULL(CONCAT(' [',bmd.kode,'] '),' ')) SEPARATOR '<br>&nbsp;') AS diagnosa, bmd.kode
					FROM
					   b_diagnosa a
					  LEFT JOIN b_ms_diagnosa
						ON a.ms_diagnosa_id = b_ms_diagnosa.id 
					  LEFT JOIN b_pelayanan 
						ON b_pelayanan.id = a.pelayanan_id 
					  LEFT JOIN b_ms_pegawai 
						ON a.user_id = b_ms_pegawai.id 
					  LEFT JOIN b_diagnosa_rm bdr ON a.diagnosa_id = bdr.diagnosa_id
					  LEFT JOIN b_ms_diagnosa bmd ON bmd.id = bdr.ms_diagnosa_id
					WHERE a.kunjungan_id = '".$_REQUEST['idKunj']."'
					  AND b_pelayanan.jenis_kunjungan = 2
					  AND a.diag_banding_id = 0
					GROUP BY a.kunjungan_id";*/
					
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
						b_diagnosa.kunjungan_id = '".$_REQUEST['idKunj']."' AND b_diagnosa.primer = 1 AND b_pelayanan.jenis_kunjungan=2";
					
					$rsDiagAkhir = mysql_query($qDiagAkhir);
					$nDiagAkhir = mysql_num_rows($rsDiagAkhir);
					//echo $qDiagAkhir;
					//$nDiagAkhir = mysql_num_rows($rsDiagAkhir);
					//if($nDiagAkhir==0){
						/*
						$qDiagAkhir = "SELECT GROUP_CONCAT(CONCAT(b_ms_diagnosa.kode,' ',IFNULL(b_diagnosa_rm.diagnosa_manual,b_ms_diagnosa2.nama)) SEPARATOR '<br>&nbsp;') as diagnosa
						FROM b_diagnosa_rm 
						INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
						INNER JOIN b_ms_pegawai ON b_diagnosa_rm.user_id = b_ms_pegawai.id
						inner join b_diagnosa ON b_diagnosa.diagnosa_id = b_diagnosa_rm.diagnosa_id
						inner join b_pelayanan ON b_pelayanan.id = b_diagnosa.pelayanan_ids
						left join b_ms_diagnosa as b_ms_diagnosa2 ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id 
						WHERE 
						b_diagnosa_rm.kunjungan_id = '".$_REQUEST['idKunj']."'  AND b_diagnosa.primer = 1 $fDiag
						GROUP BY b_diagnosa_rm.kunjungan_id";
						*/
						/*
						$qDiagAkhir = "SELECT CONCAT(b_ms_diagnosa.kode,' ',IFNULL(b_diagnosa_rm.diagnosa_manual,b_ms_diagnosa2.nama)) as diagnosa
						FROM b_diagnosa_rm 
						INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
						INNER JOIN b_ms_pegawai ON b_diagnosa_rm.user_id = b_ms_pegawai.id
						inner join b_diagnosa ON b_diagnosa.diagnosa_id = b_diagnosa_rm.diagnosa_id
						inner join b_pelayanan ON b_pelayanan.id = b_diagnosa.pelayanan_id
						left join b_ms_diagnosa as b_ms_diagnosa2 ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id 
						WHERE 
						b_diagnosa_rm.kunjungan_id = '".$_REQUEST['idKunj']."'  
						AND b_diagnosa.primer = 1
						AND b_pelayanan.jenis_kunjungan=2
						ORDER BY b_diagnosa.diagnosa_id DESC
						LIMIT 1";
						$rsDiagAkhir = mysql_query($qDiagAkhir);
						*/	
					//}
					//$rwDiagAkhir = mysql_fetch_array($rsDiagAkhir);
					
					
					if($nDiagAkhir > 0){
					?>
                    <tr style="font-size: 13px; ">
                        <td align="center" style="border-left:1px solid;" valign="top"><?php  $no++; echo $no; ?>.</td>
                        <td valign="top">Diagnosa Utama</td>
                        <td align="center" valign="top">:</td>
                        <td style="border-right:1px solid;" valign="top">
                        <?
						while($rwDiagAkhir = mysql_fetch_array($rsDiagAkhir))
							{
								$queryB = "SELECT diagnosa_manual FROM b_diagnosa WHERE diag_banding_id = ".$rwDiagAkhir['diagnosa_id']."";
								$ExqueryB = mysql_query($queryB);
								if($rwDiagAkhir['kode']=="")echo " ".$rwDiagAkhir['diagnosa'];
								else echo " ".$rwDiagAkhir['diagnosa']."&nbsp;[".$rwDiagAkhir['kode']."]";
								while($DqueryB = mysql_fetch_array($ExqueryB))
								{
									echo "/".$DqueryB['diagnosa_manual'];
								}
								echo "<br>";
							} 
						?>
                        </td>
                    </tr>
                    <?php
					}
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
						b_diagnosa.kunjungan_id = '".$_REQUEST['idKunj']."' AND b_diagnosa.primer = 0 AND b_pelayanan.jenis_kunjungan=2 AND b_diagnosa.diagnosa_id <> '$idamb' AND diag_banding_id = 0";
					$rsDiagAkhir = mysql_query($qDiagAkhir);	
					$nDiagAkhir = mysql_num_rows($rsDiagAkhir);
					if($nDiagAkhir > 0){
					?>
                    <tr style="font-size: 13px; ">
                            <td align="center" style="border-left:1px solid;" valign="top"><?php  $no++; echo $no; ?>.</td>
                            <td valign="top">Diagnosa Sekunder</td>
                            <td align="center" valign="top">:</td>
                            <td style="border-right:1px solid;" valign="top">
							<?php 
							while($rwDiagAkhir = mysql_fetch_array($rsDiagAkhir))
							{
								$queryB = "SELECT diagnosa_manual FROM b_diagnosa WHERE diag_banding_id = ".$rwDiagAkhir['diagnosa_id']."";
								$ExqueryB = mysql_query($queryB);
								echo $rwDiagAkhir['diagnosa']."&nbsp;[".$rwDiagAkhir['kode']."]";
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
							$sqlNoResep = "SELECT distinct b_resep.id_pelayanan,b_resep.no_resep 
								FROM b_resep 
								INNER JOIN b_pelayanan ON b_pelayanan.id = b_resep.id_pelayanan
								WHERE b_resep.kunjungan_id='".$_REQUEST['idKunj']."'
								AND b_pelayanan.jenis_kunjungan=2
								ORDER BY b_resep.id DESC";
							$rsNoResep = mysql_query($sqlNoResep);
							while($rwNoResep=mysql_fetch_array($rsNoResep)){
								$sqlO2 = "select distinct * from (SELECT 
									a.id, 
									IFNULL($dbapotek.a_obat.OBAT_NAMA,a.obat_manual) OBAT_NAMA, 
									a.qty, 
									a.ket_dosis,
									IFNULL((SELECT distinct $dbapotek.a_penerimaan.OBAT_ID FROM $dbapotek.a_penjualan 
INNER JOIN $dbapotek.a_penerimaan 
ON $dbapotek.a_penjualan.PENERIMAAN_ID = $dbapotek.a_penerimaan.ID 
WHERE $dbapotek.a_penjualan.NO_KUNJUNGAN = '".$rwNoResep['id_pelayanan']."' 
AND $dbapotek.a_penerimaan.OBAT_ID = a.obat_id),'true') AS dilayani 
									FROM b_resep a
									INNER JOIN b_pelayanan b ON b.id = a.id_pelayanan
									LEFT JOIN $dbapotek.a_obat ON $dbapotek.a_obat.OBAT_ID=a.obat_id
									WHERE a.kunjungan_id = '".$_REQUEST['idKunj']."' 
									AND a.id_pelayanan = '".$rwNoResep['id_pelayanan']."' 
									AND a.no_resep='".$rwNoResep['no_resep']."'
									AND b.jenis_kunjungan=2
									UNION 
SELECT '0' AS id, ab.OBAT_NAMA, a.QTY, ' ' AS ket_dosis, 'false' AS dilayani 
FROM $dbapotek.a_penjualan a 
INNER JOIN $dbapotek.a_penerimaan b ON a.PENERIMAAN_ID = b.ID 
INNER JOIN $dbapotek.a_obat ab ON b.OBAT_ID = ab.OBAT_ID 
INNER JOIN b_pelayanan ac ON ac.id = a.NO_KUNJUNGAN AND ac.kunjungan_id = '".$_REQUEST['idKunj']."' AND ac.jenis_kunjungan=2
WHERE b.OBAT_ID NOT IN (SELECT obat_id FROM b_resep WHERE kunjungan_id = '".$_REQUEST['idKunj']."' AND id_pelayanan = '".$rwNoResep['id_pelayanan']."' AND no_resep = '".$rwNoResep['no_resep']."') AND a.no_resep = '".$rwNoResep['no_resep']."'
									) as t1";
									
								//echo $sqlO2."<br>";
								$rsO2=mysql_query($sqlO2);
	                            while($rwO=mysql_fetch_array($rsO2)){
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
        						<?php 
									}else{
										?>
                                        <tr>
                                            <td style="font-size: 13px; ">
                                                <span style="color:#F00"><?=$rwO['OBAT_NAMA']." (".$rwO['ket_dosis'].")";?></span>
                                            </td>
                                        </tr>
										<?
									}
								}
							}
								?>	
        					</table>
                        </td>
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
                                        (&nbsp;<?php echo $dokter; ?>&nbsp;)
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
            <td colspan="4" style="border-left:1px solid; border-top:1px solid; border-right:1px solid;" align="right">
            Printed By : <? echo $_SESSION['nm_pegawai'];?> <br />
            Registration By : <? echo $dqueryReg['nama'];?> <br />
            Coding By : <? echo $dquerCoding['nama'];?> <br />
            Dokter By : <? echo $dokter; ?> <br />
            </td>
        </tr>-->
        <tr>
            <td colspan="4">
            	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            	<tr>
                    <td style="border-left:1px solid; border-top:1px solid; font-size:14px; vertical-align: top; text-align: left;" align="left">
                    Dibuat di: Medan &nbsp;&nbsp;&nbsp;&nbsp; Tanggal: <?php echo $rwPas['tgl'];?> <br />
                    Resume Elektronik Ini Syah Tanpa Tanda Tangan <br />
                    UU Praktek Kedokteran No. 29/2004 Penjelasan Pasal 46(3)
                    </td>
                    <td style="border-top:1px solid; border-right:1px solid;" align="right">
                    Printed By : <? echo $_SESSION['nm_pegawai'];?> <br />
		            Registration By : <? echo $dqueryReg['nama'];?> <br />
        		    Coding By : <? echo $dquerCoding['nama'];?> <br />
            		Dokter By : <? echo $dokter; ?> <br />
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
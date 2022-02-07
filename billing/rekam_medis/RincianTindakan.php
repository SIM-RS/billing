<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
include ("../koneksi/konek.php");
$idKunj=$_REQUEST['idKunj'];
$jeniskasir=$_REQUEST['jenisKasir'];
$idPel=$_REQUEST['idPel'];
$inap=$_REQUEST['inap'];
$all = $_REQUEST['all'];
$idUser=$_REQUEST['idUser'];
//----------------------------------
if ($inap=="1"){
	$sqlPas="SELECT no_rm,mp.nama nmPas,mp.alamat, mp.rt,mp.rw,mp.sex,mk.nama kelas, 
kso.nama nmKso,mp.desa_id,mp.kec_id, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) nmKec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) nmDesa, k.kso_id,k.kso_kelas_id,p.kelas_id 
FROM b_kunjungan k INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
LEFT JOIN b_ms_kelas mk ON k.kso_kelas_id=mk.id INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
WHERE k.id=$idKunj AND p.id=$idPel";
}else{
	$sqlPas="SELECT no_rm,mp.nama nmPas,mp.alamat, mp.rt,mp.rw,mp.sex,mk.nama kelas, 
kso.nama nmKso,CONCAT(DATE_FORMAT(p.tgl,'%d-%m-%Y'),' ',DATE_FORMAT(p.tgl_act,'%H:%i')) tgljam, 
DATE_FORMAT(IFNULL(p.tgl_krs,NOW()),'%d-%m-%Y %H:%i') tglP, mp.desa_id,mp.kec_id, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) nmKec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) nmDesa, k.kso_id,k.kso_kelas_id,p.kelas_id 
FROM b_kunjungan k INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
LEFT JOIN b_ms_kelas mk ON k.kso_kelas_id=mk.id INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
WHERE k.id='$idKunj' AND p.id='$idPel'";
}
//echo $sqlPas."<br>";
$qPas=mysql_query($sqlPas);
$rw=mysql_fetch_array($qPas);
$ksoid=$rw['kso_id'];
if ($inap=="1"){
	$sql="SELECT DATE_FORMAT(IFNULL(tk.tgl_in,p.tgl),'%d-%m-%Y %H:%i') tgljam FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
	WHERE p.kunjungan_id='$idKunj' AND mu.inap=1 ORDER BY p.id LIMIT 1";
	$rsInap=mysql_query($sql);
	$rwInap=mysql_fetch_array($rsInap);
	$tglIn=$rwInap['tgljam'];
	$sql="SELECT DATE_FORMAT(IFNULL(tk.tgl_out,NOW()),'%d-%m-%Y %H:%i') tglP FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
WHERE p.kunjungan_id='$idKunj' AND mu.inap=1 ORDER BY tk.id DESC LIMIT 1";
	$rsInap=mysql_query($sql);
	$rwInap=mysql_fetch_array($rsInap);
	$tglOut=$rwInap['tglP'];
}else{
	$tglIn=$rw['tgljam'];
	$tglOut=$rw['tglP'];
}

$sql="SELECT * FROM b_ms_kelas WHERE id=(SELECT kelas_id FROM b_pelayanan WHERE id='$idPel')";
//echo $sql."<br>";
$rs=mysql_query($sql);
$rw1=mysql_fetch_array($rs);
//$tglP=$rw['tglP'];
//echo "SELECT nama,id FROM b_ms_pegawai WHERE id=".$_SESSION['userId'];
$qUsr = mysql_query("SELECT nama,id FROM b_ms_pegawai WHERE id=".$_SESSION['userId']);
$rwUsr = mysql_fetch_array($qUsr);
$kls=$rw1['nama'];
//echo $kls."<br>";

/*if ($inap=="1" && $rw1['id']==1){
	$sql="SELECT mk.nama FROM b_pelayanan p INNER JOIN b_ms_kelas mk ON p.kelas_id=mk.id WHERE p.id=$idPel";
	//echo $sql."<br>";
	$rsKls=mysql_query($sql);
	$rwKls=mysql_fetch_array($rsKls);
	$kls=$rwKls['nama'];
}*/

if ($kls=="" || $kls==" "){
	$kls="Non Kelas";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/print.css" />
        <title>.: Rincian Tagihan Pasien :.</title>
    </head>

    <body style="margin-top:0px">
        <table id="tbl1" width="1225" border="0" cellspacing="0" cellpadding="0" align="left" class="kwi">
            <tr>
                <td colspan="2" style="font-size:14px">
                    <b><?=$pemkabRS?><br />
		<?=$namaRS?><br />
		<?=$alamatRS?><br />
		Telepon <?=$tlpRS?><br/></b>&nbsp;
                </td>
            </tr>
            <tr>
                <td height="5" colspan="2" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
            </tr>
            <tr class="kwi">
                <td height="30" colspan="2" align="center" style="font-weight:bold;font-size:13px">
                    <u>&nbsp;Laporan Rincian Tagihan Pasien&nbsp;</u>
                </td>
            </tr>
            <tr class="kwi">
                <td colspan="2">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="11%" style="font-size:12px">No RM</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo $rw['no_rm'];?></td>
                            <td width="10%" style="font-size:12px">Tgl Mulai</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $tglIn;?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px">Nama Pasien </td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmPas']);?></td>
                            <td width="10%" style="font-size:12px">Tgl Selesai </td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $tglOut;?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px">Alamat</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px;">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['alamat']);?></td>
                            <td width="10%" style="font-size:12px">Kelas</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo strtolower($kls);?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px">Kel. / Desa</td>
                          <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmDesa']);?></td>
                          <td width="10%" style="font-size:12px">&nbsp;</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                            <td width="30%"></td>
                        </tr>
                        <tr>
                            <td width="11%"><span style="font-size:12px">RT / RW</span></td>
                          <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['rt']." / ".$rw['rw']);?></td>
                          <td width="10%" style="font-size:12px">Status Pasien</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%">&nbsp;<?php echo strtolower($rw['nmKso']);?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px">Jenis Kelamin </td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['sex']);?></td>
                            <td width="10%" style="font-size:12px">Hak Kelas</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $rw['kelas'];?></td>
                        </tr>
              </table>	</td>
            </tr>
            <tr class="kwi">
                <td height="30" colspan="2">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="center" style="border:#000000 solid 1px; font-weight:bold;font-size:12px">Tindakan</td>
                            <td align="center" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Tanggal</td>
                            <td align="center" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Jumlah</td>
                            <td align="center" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Biaya</td>
                        </tr>
                        <?php
						$idUnitAmbulan=0;
						$idUnitJenazah=0;
						$sql="SELECT * FROM b_ms_reference WHERE stref=26";
						$rsRef=mysql_query($sql);
						if ($rwRef=mysql_fetch_array($rsRef)){
							$idUnitAmbulan=$rwRef["nama"];
						}
						$sql="SELECT * FROM b_ms_reference WHERE stref=27";
						$rsRef=mysql_query($sql);
						if ($rwRef=mysql_fetch_array($rsRef)){
							$idUnitJenazah=$rwRef["nama"];
						}

						if ($all=="true"){
							if ($inap=="1") {
									$sUnit="SELECT DISTINCT p.id,mu.nama nmUnit,mu.id idUnit,mu.parent_id,mu.inap FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
INNER JOIN b_tindakan t ON p.id=t.pelayanan_id 
WHERE p.kunjungan_id='$idKunj' AND p.id>=$idPel AND mu.kategori<>5 ORDER BY p.id";
							}else {
								$sUnit="SELECT DISTINCT p.id,mu.nama nmUnit ,mu.id idUnit,mu.parent_id,mu.inap FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
WHERE (p.id='$idPel' OR p.unit_id_asal=(SELECT unit_id FROM b_pelayanan WHERE id='$idPel')) AND p.kunjungan_id='$idKunj' AND mu.inap=0 AND mu.kategori<>5 ORDER BY p.id";
							}
						}else{
							if ($inap=="1") {
								$sUnit="SELECT DISTINCT p.id,mu.nama nmUnit,mu.id idUnit,mu.parent_id,mu.inap FROM b_pelayanan p
							INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan t ON p.id=t.pelayanan_id
							WHERE p.kunjungan_id='$idKunj' AND mu.kategori<>5 AND p.unit_id<>$idUnitAmbulan AND p.unit_id<>$idUnitJenazah ORDER BY p.id";
							}else {
								$sUnit="SELECT distinct p.id,mu.nama nmUnit ,mu.id idUnit,mu.parent_id,mu.inap FROM b_pelayanan p
								INNER JOIN b_ms_unit mu ON p.unit_id=mu.id INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
								WHERE p.id='$idPel' AND mu.kategori<>5 ORDER BY p.id";
							}
						}
                        //echo $sUnit."<br>";
                        $qUnit=mysql_query($sUnit);
                        $sByr=0;
                        $sBiaya=0;
						$sIurBiaya=0;
                        $sJaminKso=0;
                        while($rwUnit=mysql_fetch_array($qUnit)) {?>
                        <tr>
                            <td align="left" style="padding-left:25px;font-size:12px"><?php echo $rwUnit['nmUnit']?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <?php
                            $cHari=0;
                            $bKmr=0;
                            $sTot=0;
                            $bTot=0;
							$sSdhBayar=0;
							
							if ($rwUnit["inap"]==1){
								$sKmr="SELECT tk.id,mk.id idKmr,mk.kode kdKmr,mk.nama nmKmr, mKls.nama nmKls,
	DATE_FORMAT(tk.tgl_in,'%d-%m-%Y') tgl_in, 
	IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*(tk.tarip), 
	IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*(tk.tarip)) biaya, 
	IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*tk.beban_kso, 
	IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*tk.beban_kso) biaya_kso,
	IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*tk.beban_pasien, 
	IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*tk.beban_pasien) biaya_pasien,tk.bayar, 
	IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)),
	IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))) cHari 
	FROM b_tindakan_kamar tk INNER JOIN b_pelayanan p ON tk.pelayanan_id=p.id LEFT JOIN b_ms_kamar mk ON tk.kamar_id=mk.id 
	LEFT JOIN b_ms_kelas mKls ON tk.kelas_id=mKls.id WHERE kunjungan_id='$idKunj' AND p.id='".$rwUnit['id']."'";
								//echo $sKmr."<br>";
								//echo $ksoid."<br>";
								//echo $rwUnit['id']."<br>";
								$lblKamar="Kamar";
								$isUnit_ICU_HCU=0;
								$UnitId_ICU_HCU1=explode(",",$UnitId_ICU_HCU);
								for ($j=0;$j<count($UnitId_ICU_HCU1);$j++){
									if ($rwUnit['idUnit']==$UnitId_ICU_HCU1[$j]){
										$lblKamar="Jasa RS & AHP Dasar";
										$isUnit_ICU_HCU=1;
									}
								}
								$kamarIdHCU1=explode(",",$kamarIdHCU);
								
								$qKmr=mysql_query($sKmr);
								while($rwKmr=mysql_fetch_array($qKmr)) {
									/*if ($rwUnit['idUnit']==48 || $rwUnit['idUnit']==112 || $rwUnit['parent_id']==94){
										$lblKamar="Jasa RS & AHP Dasar";
									}*/
								//==============tambahan kamar hcu============
									if ($isUnit_ICU_HCU==0){
										$lblKamar="Kamar";
										for ($j=0;$j<count($kamarIdHCU1);$j++){
											if ($rwKmr['idKmr']==$kamarIdHCU1[$j]){
												$lblKamar="Jasa RS & AHP Dasar";
											}
										}
									}
								//==============tambahan kamar hcu============
									$bKmr+=$rwKmr['biaya'];
									if ($ksoid==1){
										$sIurBiaya+=$rwKmr['biaya'];
									}else{
										$sJaminKso+=$rwKmr['biaya_kso'];
										$sIurBiaya+=$rwKmr['biaya_pasien'];
									}
									//echo $sJaminKso."<br>";
									$sByr+=$rwKmr['bayar'];
									$sSdhBayar+=$rwKmr['bayar'];
                        	?>
                        <tr>
                            <td align="left" style="padding-left:50px;font-size:12px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lblKamar; ?></td>
                            <td align="center" style="font-size:12px"><?php echo $rwKmr['tgl_in']?></td>
                            <td align="center" style="font-size:12px"><?php echo $rwKmr['cHari']?></td>
                            <td align="right" style="font-size:12px"><?php echo number_format($rwKmr['biaya'],0,",",".")?>&nbsp;</td>
                        </tr>
                            <?php 
								}
							}else{
								$sqlCekKamar="SELECT * FROM b_tindakan_kamar WHERE pelayanan_id=".$rwUnit['id'];
								$rsCekKamar=mysql_query($sqlCekKamar);
								if (mysql_num_rows($rsCekKamar)>0){
									$sqlDelKamar="DELETE FROM b_tindakan_kamar WHERE pelayanan_id=".$rwUnit['id'];
									$rsDelKamar=mysql_query($sqlDelKamar);
								}
							}
							
                            $sKonsul="SELECT user_id,IFNULL(b_ms_pegawai.nama,'-') konsul FROM b_tindakan LEFT JOIN b_ms_pegawai ON b_tindakan.user_id=b_ms_pegawai.id WHERE b_tindakan.pelayanan_id='".$rwUnit['id']."' GROUP BY b_tindakan.user_id";
                            //echo $sKonsul."<br>";
                            $qKonsul=mysql_query($sKonsul);
                            while($rwKonsul=mysql_fetch_array($qKonsul)) {?>
                        <tr>
                            <td align="left" style="padding-left:50px;font-size:12px"><?php echo $rwKonsul['konsul'];?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                <?php
                                if ($ksoid==1) {
										$sTind="SELECT t.id,DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,mt.nama nmTind, SUM(t.biaya*t.qty) AS biaya, SUM(t.biaya*t.qty) AS iurbiaya,0 AS biaya_kso,SUM(t.bayar) bayar,SUM(t.qty) cTind 
FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id INNER JOIN b_ms_tindakan mt 
ON mtk.ms_tindakan_id=mt.id INNER JOIN b_ms_unit mu ON t.unit_act=mu.id 
WHERE t.pelayanan_id='".$rwUnit['id']."' AND user_id='".$rwKonsul['user_id']."' GROUP BY mt.nama ORDER BY t.id";
                                }else {
										$sTind="SELECT t.id,DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,mt.nama nmTind, SUM((t.biaya)*t.qty) AS biaya,SUM(t.biaya_kso*t.qty) AS biaya_kso,SUM(t.biaya_pasien*t.qty) AS iurbiaya,SUM(t.bayar) bayar,SUM(t.qty) cTind FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id 
WHERE t.kunjungan_id=".$idKunj." AND t.pelayanan_id=".$rwUnit['id']." AND user_id='".$rwKonsul['user_id']."' GROUP BY mt.nama ORDER BY t.id";
                                }
                                //echo $sTind."<br>";
                                $qTind=mysql_query($sTind);
                                while($rwTind=mysql_fetch_array($qTind)) {
                                	$sqlPegAnastesi="SELECT mp.nip,mp.nama FROM b_tindakan_dokter_anastesi bta INNER JOIN b_ms_pegawai mp ON bta.dokter_id=mp.id WHERE bta.tindakan_id=".$rwTind["id"];
									$rsPegAnastesi=mysql_query($sqlPegAnastesi);
									$dokAnastesi="";
									while ($rwPegAnastesi=mysql_fetch_array($rsPegAnastesi)){
										$dokAnastesi .=$rwPegAnastesi["nama"].", ";
									}
									if ($dokAnastesi!="") $dokAnastesi=" - (".substr($dokAnastesi,0,strlen($dokAnastesi)-2).")"; 
								?>
                        <tr>
                            <td align="left" style="padding-left:85px"><?php echo strtolower($rwTind['nmTind']).$dokAnastesi;?></td>
                            <td align="center" style="font-size:12px">&nbsp;<?php echo $rwTind['tgl'];?></td>
                            <td align="center" style="font-size:12px">&nbsp;<?php echo $rwTind['cTind'];?></td>
                            <td align="right" style="font-size:12px"><?php echo number_format($rwTind['biaya'],0,",",".");?>&nbsp;</td>
                        </tr>
                                    <?php
                                    $sTot+=$rwTind['biaya'];
                                    $sByr+=$rwTind['bayar'];
									$sSdhBayar+=$rwTind['bayar'];
									/*if ($ksoid==4){
										$sIurBiaya+=$rwTind['iurbiaya'];
										$sJaminKso+=$rwTind['biaya_kso'];*/
									if ($ksoid==1){
										$sIurBiaya+=$rwTind['iurbiaya'];
									}else{
										$sJaminKso+=$rwTind['biaya_kso'];
										$sIurBiaya+=$rwTind['iurbiaya'];
									}
									//echo $sJaminKso."<br>";
                                }
                                ?>
                                <?php
                                
                                //echo "kamar=".$bKmr."<br>";
                                //$sBiaya+=$bTot;
                            }
							$bTot+=$sTot;
                            $bTot+=$bKmr;
                            $sBiaya+=$bTot;
                            ?>
                        <tr>
                            <td align="left" style="padding-left:60px;font-size:12px">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:12px">Sub Total&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:12px"><?php echo number_format($bTot,0,",",".");?>&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" style="padding-left:60px;font-size:12px">&nbsp;</td>
                          <td align="center">&nbsp;</td>
                          <td align="right" style="font-weight:bold; border-bottom:solid #000000 1px;font-size:12px">Bayar&nbsp;</td>
                          <td align="right" style="font-weight:bold; border-bottom:solid #000000 1px;font-size:12px"><?php echo number_format($sSdhBayar,0,",",".");?>&nbsp;</td>
                        </tr>
                            <?php
                            //$sBayar=$sByr;
                        }
						
						if ($ksoid==4){
							$selisih=$sIurBiaya;
						}else{
							$selisih=$sBiaya-$sJaminKso-$sByr-$keringanan-$titipan;
						}
						?>
                        <tr>
                            <td align="left" style="padding-left:60px; border-top:#000000 solid 1px; font-size:12px">&nbsp;</td>
                            <td align="center" style="border-top:solid #000000 1px; font-size:12px;">&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px; font-size:12px">Total Biaya&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px; font-size:12px"><?php echo number_format($sBiaya,0,",",".")?>&nbsp;</td>
                        </tr>
                        <?php
                        if ($sJaminKso>0) {
                            ?>
                        <tr>
                            <td height="19" align="left" style="padding-left:60px;">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:12px">Dijamin KSO&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:12px"><?php echo number_format($sJaminKso,0,",","."); ?>&nbsp;</td>
                        </tr>
                            <?php }?>
                        <?php
                        if ($titipan>0) {
                            ?>
                        <tr>
                            <td height="19" align="left" style="padding-left:60px;font-size:12px;">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:12px">Titipan&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:12px"><?php echo number_format($titipan,0,",","."); ?>&nbsp;</td>
                        </tr>
                            <?php }?>
                        <?php
                        if ($keringanan>0) {
                            ?>
                        <tr>
                            <td height="19" align="left" style="padding-left:60px;font-size:12px">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:12px">Keringanan&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:12px"><?php echo number_format($keringanan,0,",","."); ?>&nbsp;</td>
                        </tr>
                            <?php }?>
                        <tr>
                            <td height="19" align="left" style="padding-left:60px;font-size:12px">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:12px">Total Bayar&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:12px"><?php echo number_format($sByr,0,",",".");?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="left" style="padding-left:60px;font-size:12px;" height="2"></td>
                            <td align="center"></td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:12px"></td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:12px"></td>
                        </tr>
                        <tr>
                            <td align="left" style="padding-left:60px;font-size:12px">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:12px">Kurang&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:12px"><?php if ($selisih<0) echo number_format(0,0,",","."); else echo number_format($selisih,0,",",".");?>&nbsp;</td>
                        </tr>
                    </table>
              </td>
            </tr>
            <tr>
                <td height="5" colspan="2" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight:bold;font-size:14px">Terbilang : <?php echo terbilang($selisih); ?> Rupiah</td>
            </tr>
            <tr class="kwi">
                <td width="607">&nbsp;</td>
                <td width="293" style="font-weight:bold;font-size:12px"><?=$kotaRS?>, <?php echo gmdate('d F Y',mktime(date('H')+7));?><br/>
                    Petugas,<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php echo $rwUsr['nama']?> )</td>
            </tr>
            <tr id="trTombol">
                <td colspan="2" class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
                    <input id="btnExpExcl" type="button" value="Export --> Excell" onClick="window.open('RincianTindakanExcell.php?idKunj=<?php echo $idKunj; ?>&idPel=<?php echo $idPel; ?>&all=<?php echo $all;?>&idUser=<?php echo $idUser; ?>&inap=<?php echo $inap; ?>');"/>
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
                </td>
            </tr>
        </table>
	   <?php
	   $sql = "SELECT * FROM b_ms_kamar k
			 INNER JOIN b_ms_kamar_tarip kt ON k.id = kt.kamar_id
			 inner join b_tindakan_kamar tk on tk.kamar_id = k.id
			 inner join b_pelayanan p on p.id = tk.pelayanan_id
			 WHERE kt.kelas_id = 2 and p.id = '$idPel'";
	   $rs = mysql_query($sql);
	   $res = mysql_num_rows($rs);
	   ?>
        <script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Mencetak Rician Tagihan Pembayaran ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
		  if('<?php echo $res; ?>' > 0){
			 document.getElementById('tbl1').width = 800;
		  }
        </script>
    </body>
</html>
<?php 
mysql_close($konek);
?>
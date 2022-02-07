<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
include ("../koneksi/konek.php");
include '../theme/numberConversion.php';
$idKunj=$_REQUEST['idKunj'];
$jeniskasir=$_REQUEST['jenisKasir'];
$idPel=$_REQUEST['idPel'];
$inap=$_REQUEST['jenisKasir'];
if ($inap=="0") $inap="1"; else $inap="0";
$idUser=$_REQUEST['idUser'];
//----------------------------------
if ($inap=="1"){
	$sqlPas="SELECT no_rm,mp.nama nmPas,mp.alamat, mp.rt,mp.rw,mp.sex,mk.nama kelas, 
kso.nama nmKso,DATE_FORMAT(IFNULL(tk.tgl_in,p.tgl),'%d-%m-%Y %H:%i') tgljam, 
DATE_FORMAT(IFNULL(k.tgl_pulang,NOW()),'%d-%m-%Y %H:%i') tglP, mp.desa_id,mp.kec_id, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) nmKec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) nmDesa, k.kso_id,k.kso_kelas_id,p.kelas_id 
FROM b_kunjungan k INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
INNER JOIN b_ms_kelas mk ON p.kelas_id=mk.id INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
LEFT JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
WHERE k.id=$idKunj";
}else{
	$sqlPas="SELECT no_rm,mp.nama nmPas,mp.alamat, mp.rt,mp.rw,mp.sex,mk.nama kelas, 
kso.nama nmKso,CONCAT(DATE_FORMAT(p.tgl,'%d-%m-%Y'),' ',DATE_FORMAT(p.tgl_act,'%H:%i')) tgljam, 
DATE_FORMAT(IFNULL(p.tgl_krs,NOW()),'%d-%m-%Y %H:%i') tglP, mp.desa_id,mp.kec_id, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) nmKec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) nmDesa, k.kso_id,k.kso_kelas_id,p.kelas_id 
FROM b_kunjungan k INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
INNER JOIN b_ms_kelas mk ON p.kelas_id=mk.id INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
WHERE k.id=$idKunj";
}
//echo $sqlPas."<br>";
$qPas=mysql_query($sqlPas);
$rw=mysql_fetch_array($qPas);
$ksoid=$rw['kso_id'];
$sql="SELECT * FROM b_ms_kelas WHERE id='".$rw['kso_kelas_id']."'";
$rs=mysql_query($sql);
$rw1=mysql_fetch_array($rs);
$tglP=$rw['tglP'];
//echo "SELECT nama,id FROM b_ms_pegawai WHERE id=".$_SESSION['userId'];
$qUsr = mysql_query("SELECT nama,id FROM b_ms_pegawai WHERE id=".$idUser);
$rwUsr = mysql_fetch_array($qUsr);
$kls=$rw['kelas'];
//$jam = date("G:i");

if ($inap=="1" && $rw['kelas_id']==1){
	$sql="SELECT mk.nama FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id INNER JOIN b_ms_kelas mk ON p.kelas_id=mk.id WHERE p.kelas_id>1 AND k.id=$idKunj ORDER BY p.id LIMIT 1";
	//echo $sql."<br>";
	$rsKls=mysql_query($sql);
	$rwKls=mysql_fetch_array($rsKls);
	$kls=$rwKls['nama'];
}
if ($kls=" ") $kls="Non Kelas";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/print.css" />
        <title>.: Rincian Tagihan Pasien :.</title>
    </head>

    <body style="margin-top:0px">
        <table width="1225" border="0" cellspacing="0" cellpadding="0" align="left" class="kwi">
            <tr>
                <td colspan="2" style="font-size:16px">
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
                <td height="30" colspan="2" align="center" style="font-weight:bold;font-size:16px">
                    <u>&nbsp;Kwitansi Rincian Tagihan Pasien&nbsp;</u>
                </td>
            </tr>
            <tr class="kwi">
                <td colspan="2">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="11%" style="font-size:16px">No RM</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:16px">:</td>
                            <td style="font-size:16px">&nbsp;<?php echo $rw['no_rm'];?></td>
                            <td width="10%" style="font-size:16px">Tgl Mulai</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:16px">:</td>
                            <td width="30%" style="font-size:16px">&nbsp;<?php echo $rw['tgljam'];?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:16px">Nama Pasien </td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:16px">:</td>
                            <td style="font-size:16px">&nbsp;<?php echo strtolower($rw['nmPas']);?></td>
                            <td width="10%" style="font-size:16px">Tgl Selesai </td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:16px">:</td>
                            <td width="30%" style="font-size:16px">&nbsp;<?php echo $rw['tglP'];?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:16px">Alamat</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:16px;">:</td>
                            <td style="font-size:16px">&nbsp;<?php echo strtolower($rw['alamat']);?></td>
                            <td width="10%" style="font-size:16px">Kelas</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:16px">:</td>
                            <td width="30%" style="font-size:16px">&nbsp;<?php echo strtolower($kls);?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:16px">Kel. / Desa</td>
                          <td width="2%" align="center" style="font-weight:bold;font-size:16px">:</td>
                            <td style="font-size:16px">&nbsp;<?php echo strtolower($rw['nmDesa']);?></td>
                          <td width="10%" style="font-size:16px">&nbsp;</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:16px">&nbsp;</td>
                            <td width="30%"></td>
                        </tr>
                        <tr>
                            <td width="11%"><span style="font-size:16px">RT / RW</span></td>
                          <td width="2%" align="center" style="font-weight:bold;font-size:16px">:</td>
                            <td style="font-size:16px">&nbsp;<?php echo strtolower($rw['rt']." / ".$rw['rw']);?></td>
                          <td width="10%" style="font-size:16px">Status Pasien</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:16px">:</td>
                            <td width="30%" style="font-size:16px">&nbsp;<?php echo strtolower($rw['nmKso']);?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:16px">Jenis Kelamin </td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:16px">:</td>
                            <td style="font-size:16px">&nbsp;<?php echo strtolower($rw['sex']);?></td>
                            <td width="10%" style="font-size:16px">Hak Kelas</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:16px">:</td>
                            <td width="30%" style="font-size:16px">&nbsp;<?php echo $rw1['nama'];?></td>
                        </tr>
              </table>	</td>
            </tr>
            <tr class="kwi">
                <td height="30" colspan="2">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="center" style="border:#000000 solid 1px; font-weight:bold;font-size:16px">Tindakan</td>
                            <td align="center" width="100" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:16px">Tanggal</td>
                            <td align="center" width="100" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:16px">Jumlah</td>
                            <td align="center" width="110" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:16px"> <?php if ($for<>"1"){?>Biaya<?php }?></td>
                            <td align="center" width="110" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:16px">Dijamin KSO</td>
                            <td align="center" width="110" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:16px">Iur Biaya</td>
                        </tr>
                        <?php
                        if ($inap=="1") {
                        		$sUnit="SELECT DISTINCT p.id,mu.nama nmUnit,mu.id idUnit FROM b_pelayanan p
						INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan t ON p.id=t.pelayanan_id
						WHERE p.kunjungan_id='$idKunj'";
                        }else {
                        	$sUnit="SELECT distinct p.id,mu.nama nmUnit ,mu.id idUnit FROM b_pelayanan p
							INNER JOIN b_ms_unit mu ON p.unit_id=mu.id left JOIN b_tindakan t ON p.id=t.pelayanan_id
							WHERE p.id='$idPel'";
                        }
                        //echo $sUnit."<br>";
                        $qUnit=mysql_query($sUnit);
                        $sByr=0;
                        $sBiaya=0;
						$sIurBiaya=0;
                        $sJaminKso=0;
                        while($rwUnit=mysql_fetch_array($qUnit)) {?>
                        <tr>
                            <td align="left" style="padding-left:25px;font-size:16px"><?php echo $rwUnit['nmUnit']?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <?php	
							$cHari=0;
                            $bKmr=0;
							$bKmrKSO=0;
							$bKmrIur=0;
                            $sTot=0;
							$sTotKSO=0;
							$sTotIur=0;
                            $bTot=0;
							$bTotKSO=0;
							$bTotIur=0;
							$sSdhBayar=0;
							$sSdhBayarKSO=0;
							$sKmrIur=0;
							$sKmr="SELECT tk.id,mk.id idKmr,mk.kode kdKmr,mk.nama nmKmr, mKls.nama nmKls,
DATE_FORMAT(tk.tgl_in,'%d-%m-%Y') tgl_in, 
IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*(tk.tarip), 
IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*(tk.tarip)) biaya, 
IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*tk.beban_kso, 
IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*tk.beban_kso) biaya_kso, tk.bayar, 
IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)),
IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))) cHari 
FROM b_tindakan_kamar tk INNER JOIN b_pelayanan p ON tk.pelayanan_id=p.id INNER JOIN b_ms_kamar mk ON tk.kamar_id=mk.id 
INNER JOIN b_ms_kelas mKls ON tk.kelas_id=mKls.id WHERE kunjungan_id='$idKunj' AND mk.unit_id='".$rwUnit['idUnit']."' AND p.id='".$rwUnit['id']."'";
                            //echo $sKmr."<br>";
							//echo $ksoid."<br>";
							//echo $rwUnit['id']."<br>";
                            $qKmr=mysql_query($sKmr);
                            while($rwKmr=mysql_fetch_array($qKmr)) {
                                //==============tambahan kamar hcu============
								for ($j=0;$j<count($kamarIdHCU1);$j++){
									if ($rwKmr['idKmr']==$kamarIdHCU1[$j]){
										$lblKamar="Jasa RS & AHP Dasar";
									}
								}
							//==============tambahan kamar hcu============
                                $bKmr+=$rwKmr['biaya'];
								$bKmrKSO+=$rwKmr['biaya_kso'];
								if ($ksoid==1){
									$sIurBiaya+=$rwKmr['biaya'];
									$bKmrIur+=$rwKmr['biaya'];
									$sKmrIur=$rwKmr['biaya'];
								}else{
                                	$sJaminKso+=$rwKmr['biaya_kso'];
									if ($rwKmr['biaya']>$rwKmr['biaya_kso']){
										$sIurBiaya+=$rwKmr['biaya']-$rwKmr['biaya_kso'];
										$bKmrIur+=$rwKmr['biaya']-$rwKmr['biaya_kso'];
										$sKmrIur=$rwKmr['biaya']-$rwKmr['biaya_kso'];
									}else{
										$sKmrIur=0;
									}
								}
								//echo $sJaminKso."<br>";
                                $sByr+=$rwKmr['bayar'];
								$sSdhBayar+=$rwKmr['bayar'];
								$sSdhBayarKSO+=$rwKmr['bayar_kso'];
                                ?>
                        <tr>
                            <td align="left" style="padding-left:50px;font-size:16px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lblKamar; ?></td>
                            <td align="center" style="font-size:16px"><?php echo $rwKmr['tgl_in']?></td>
                            <td align="center" style="font-size:16px"><?php echo $rwKmr['cHari']?></td>
                            <td align="right" style="font-size:16px"><?php if ($for<>"1") echo number_format($rwKmr['biaya'],0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-size:16px"><?php echo number_format($rwKmr['biaya_kso'],0,",",".")?>&nbsp;</td>
                            <td align="right" style="font-size:16px"><?php echo number_format($sKmrIur,0,",",".")?>&nbsp;</td>
                        </tr>
                                <?php 
							}
							
                            $sKonsul="SELECT user_id,IFNULL(b_ms_pegawai.nama,'-') konsul FROM b_tindakan LEFT JOIN b_ms_pegawai ON b_tindakan.user_id=b_ms_pegawai.id WHERE b_tindakan.pelayanan_id='".$rwUnit['id']."' GROUP BY b_tindakan.user_id";
                            //echo $sKonsul."<br>";
                            $qKonsul=mysql_query($sKonsul);
                            while($rwKonsul=mysql_fetch_array($qKonsul)) {?>
                        <tr>
                            <td align="left" style="padding-left:50px;font-size:16px"><?php echo $rwKonsul['konsul'];?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                <?php
                                if ($ksoid==1) {
										$sTind="SELECT t.id,DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,mt.nama nmTind, SUM(t.biaya*t.qty) AS biaya, SUM(t.biaya*t.qty) AS iurbiaya,0 AS biaya_kso,SUM(t.bayar) bayar,SUM(t.bayar_kso) bayarKSO,SUM(t.qty) cTind 
FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id INNER JOIN b_ms_tindakan mt 
ON mtk.ms_tindakan_id=mt.id INNER JOIN b_ms_unit mu ON t.unit_act=mu.id 
WHERE t.pelayanan_id='".$rwUnit['id']."' AND user_id='".$rwKonsul['user_id']."' GROUP BY mt.nama ORDER BY t.id";
                                }else {
										$sTind="SELECT t.id,DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,mt.nama nmTind, SUM((t.biaya)*t.qty) AS biaya,SUM(t.biaya_kso*t.qty) AS biaya_kso,SUM(t.biaya_pasien*t.qty) AS iurbiaya,SUM(t.bayar) bayar,SUM(t.bayar_kso) bayarKSO,SUM(t.qty) cTind FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id 
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
                            <td align="left" style="padding-left:85px; font-size:16px"><?php echo strtolower($rwTind['nmTind']).$dokAnastesi;?></td>
                            <td align="center" style="font-size:16px">&nbsp;<?php echo $rwTind['tgl'];?></td>
                            <td align="center" style="font-size:16px">&nbsp;<?php echo $rwTind['cTind'];?></td>
                            <td align="right" style="font-size:16px"><?php if ($for<>"1") echo number_format($rwTind['biaya'],0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-size:16px"><?php echo number_format($rwTind['biaya_kso'],0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-size:16px"><?php echo number_format($rwTind['iurbiaya'],0,",",".");?>&nbsp;</td>
                        </tr>
                                    <?php
                                    $sTot+=$rwTind['biaya'];
									$sTotKSO+=$rwTind['biaya_kso'];
									$sTotIur+=$rwTind['iurbiaya'];
                                    $sByr+=$rwTind['bayar'];
									$sSdhBayar+=$rwTind['bayar'];
									$sSdhBayarKSO+=$rwTind['bayarKSO'];
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
							$bTotKSO+=$sTotKSO;
							$bTotKSO+=$bKmrKSO;
							$bTotIur+=$sTotIur;
							$bTotIur+=$bKmrIur;
                            $sBiaya+=$bTot;
                            ?>
                        <tr>
                            <td align="left" style="padding-left:60px;font-size:16px">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:16px">Sub Total&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:16px"><?php if ($for<>"1") echo number_format($bTot,0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:16px"><?php echo number_format($bTotKSO,0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:16px"><?php echo number_format($bTotIur,0,",",".");?>&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" style="padding-left:60px;font-size:16px">&nbsp;</td>
                          <td align="center">&nbsp;</td>
                          <td align="right" style="font-weight:bold; border-bottom:solid #000000 1px;font-size:16px">Bayar&nbsp;</td>
                          <td align="right" style="font-weight:bold; border-bottom:solid #000000 1px;font-size:16px"><?php if ($for<>"1") echo number_format($sSdhBayar,0,",",".");?>&nbsp;</td>
                          <td align="right" style="font-weight:bold; border-bottom:solid #000000 1px;font-size:16px"><?php echo number_format($sSdhBayarKSO,0,",",".");?>&nbsp;</td>
                          <td align="right" style="font-weight:bold; border-bottom:solid #000000 1px;font-size:16px"><?php echo number_format($sSdhBayar,0,",",".");?>&nbsp;</td>
                        </tr>
                            <?php
                            //$sBayar=$sByr;
                        }
						
						if ($ksoid==4){
							$selisih=$sIurBiaya;
						}else{
							$selisih=$sBiaya-$sJaminKso-$sByr-$keringanan-$titipan;
						}
						$krgTind=$selisih;
						if ($krgTind<0) $krgTind=0;
						?>
                        <tr>
                            <td align="left" style="padding-left:60px; border-top:#000000 solid 1px; font-size:16px">&nbsp;</td>
                            <td align="right" colspan="2" style="font-weight:bold; border-top:solid #000000 1px; font-size:16px">Total Biaya&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px; font-size:16px"><?php if ($for<>"1") echo number_format($sBiaya,0,",","."); else echo number_format($sJaminKso+$sIurBiaya,0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px; font-size:16px"><span style="font-weight:bold;font-size:16px"><?php echo number_format($sJaminKso,0,",","."); ?></span>&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px; font-size:16px"><span style="font-weight:bold;font-size:16px"><?php echo number_format($sIurBiaya,0,",","."); ?></span>&nbsp;</td>
                        </tr>
						<?php
							if ($sJaminKso>0) {
                        ?>
                        <tr>
                            <td height="19" align="left" style="padding-left:60px;">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:16px">Dijamin KSO&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:16px"><?php echo number_format($sJaminKso,0,",","."); ?>&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:16px">&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:16px">&nbsp;</td>
                        </tr>
                            <?php }?>
                        <?php
                        if ($titipan>0) {
                            ?>
                        <tr>
                            <td height="19" align="left" style="padding-left:60px;font-size:16px;">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:16px">Titipan&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:16px"><?php echo number_format($titipan,0,",","."); ?>&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:16px">&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:16px">&nbsp;</td>
                        </tr>
                            <?php }?>
                        <?php
                        if ($keringanan>0) {
                            ?>
                        <tr>
                            <td height="19" align="left" style="padding-left:60px;font-size:16px">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:16px">Keringanan&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:16px"><?php echo number_format($keringanan,0,",","."); ?>&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:16px">&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:16px">&nbsp;</td>
                        </tr>
                            <?php }?>
                        <tr>
                            <td height="19" align="left" style="padding-left:60px;font-size:16px">&nbsp;</td>
                            <td align="right" colspan="2" style="font-weight:bold;font-size:16px">Total Bayar&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:16px"><?php echo number_format($sByr,0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:16px">&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:16px">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="left" style="padding-left:60px;font-size:16px;" height="2"></td>
                            <td align="center"></td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:16px"></td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:16px"></td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:16px"></td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:16px"></td>
                        </tr>
                        <tr>
                            <td align="left" height="20" style="padding-left:60px;font-size:16px">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:16px">Kurang (Tind)&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:16px"><?php if ($selisih<0) echo number_format(0,0,",","."); else echo number_format($selisih,0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:16px">&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:16px">&nbsp;</td>
                        </tr>
                    </table>
              </td>
            </tr>
			<?php ### obat ?>
			<tr>
                <td colspan="2" style="border-top:2px solid #000;">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
                        <tr>
                            <td align="center" style="border:#000000 solid 1px; font-weight:bold;font-size:16px">Nama Obat</td>
                            <td align="center" width="100" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:16px">Cara Bayar</td>
                            <td align="center" width="100" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:16px">Tanggal</td>
                            <td align="center" width="100" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:16px">Jumlah</td>
                            <td align="center" width="110" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:16px">Biaya</td>
                        </tr>
                        <?php
                        //=====tipe=2-->RJ+RI, tipe=1-->RI, tipe=0-->RJ======
						if ($tipe=="2") {
                        	$sUnit="SELECT DISTINCT t2.* FROM (SELECT DISTINCT p.id,p.jenis_kunjungan,p.kelas_id,mu.nama nmUnit,mu.id idUnit,mu.parent_id 
FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan t ON p.id=t.pelayanan_id 
WHERE p.kunjungan_id='$idKunj') AS t2 INNER JOIN $dbapotek.a_penjualan ap ON t2.id=ap.NO_KUNJUNGAN WHERE ap.NO_PASIEN='".$rw['no_rm']."'";
                        }elseif ($tipe=="1") {
                        	$sUnit="SELECT DISTINCT t2.* FROM (SELECT DISTINCT p.id,p.jenis_kunjungan,p.kelas_id,mu.nama nmUnit,mu.id idUnit,mu.parent_id 
FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan t ON p.id=t.pelayanan_id 
WHERE p.kunjungan_id='$idKunj' AND p.jenis_kunjungan=3) AS t2 INNER JOIN $dbapotek.a_penjualan ap ON t2.id=ap.NO_KUNJUNGAN WHERE ap.NO_PASIEN='".$rw['no_rm']."'";
                        }elseif ($tipe=="0") {
                        		$sUnit="SELECT DISTINCT t2.* FROM (SELECT DISTINCT p.id,p.jenis_kunjungan,p.kelas_id,mu.nama nmUnit,mu.id idUnit,mu.parent_id 
FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan t ON p.id=t.pelayanan_id 
WHERE p.kunjungan_id='$idKunj' AND p.jenis_kunjungan<>3) AS t2 INNER JOIN $dbapotek.a_penjualan ap ON t2.id=ap.NO_KUNJUNGAN WHERE ap.NO_PASIEN='".$rw['no_rm']."'";
							//}
                        }
                        //echo $sUnit."<br>";
                        $qUnit=mysql_query($sUnit);
						$byrTot=0;
						$bTot=0;
						$jaminKSOTot=0;
                        while($rwUnit=mysql_fetch_array($qUnit)) {?>
                        <tr>
                            <td align="left" style="padding-left:25px;font-size:16px"><?php echo $rwUnit['nmUnit']?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <?php
							$jenis_kunjungan=$rwUnit["jenis_kunjungan"];
							$klsId=$rwUnit["kelas_id"];
							//echo $klsId."<br>";
							$sKonsul="SELECT DISTINCT ap.NO_PENJUALAN,ap.DOKTER,ap.CARA_BAYAR,ac.nama FROM $dbapotek.a_penjualan ap inner join $dbapotek.a_cara_bayar ac on ap.CARA_BAYAR=ac.id WHERE ap.NO_PASIEN='".$rw['no_rm']."' AND ap.NO_KUNJUNGAN='".$rwUnit['id']."'";
                            //echo $sKonsul."<br>";
                            $qKonsul=mysql_query($sKonsul);
                            while($rwKonsul=mysql_fetch_array($qKonsul)) {
                            	$sTot=0;
								$sbyrTot=0;
								$sJaminKSO=0;
								$sIurBHP=0;
								$caraBayar=$rwKonsul["nama"];
							?>
                        <tr>
                            <td align="left" style="padding-left:50px;font-size:16px"><?php echo $rwKonsul['DOKTER']." - ".$rwKonsul['NO_PENJUALAN'];?></td>
                            <td align="center" style="font-size:16px"><?php echo $caraBayar; ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                <?php
								$sObat="SELECT SUM(t2.QTY_JUAL) QTY_JUAL,SUM(t2.QTY_RETUR) QTY_RETUR,ao.OBAT_ID,ao.OBAT_NAMA,DATE_FORMAT(t2.TGL,'%d-%m-%Y') AS TGL, t2.HARGA_SATUAN,
SUM((t2.QTY_JUAL-t2.QTY_RETUR) * t2.HARGA_SATUAN) AS SUBTOTAL,ao.OBAT_KELOMPOK 
FROM (SELECT * FROM $dbapotek.a_penjualan WHERE NO_KUNJUNGAN='".$rwUnit['id']."' AND NO_PENJUALAN='".$rwKonsul['NO_PENJUALAN']."') AS t2 
INNER JOIN $dbapotek.a_penerimaan ap ON t2.PENERIMAAN_ID=ap.ID INNER JOIN $dbapotek.a_obat ao ON ap.OBAT_ID=ao.OBAT_ID 
GROUP BY ao.OBAT_ID";
                                //echo $sObat."<br>";
                                $qObat=mysql_query($sObat);
                                while($rwObat=mysql_fetch_array($qObat)) {?>
                        <tr>
                            <td align="left" style="padding-left:85px;font-size:16px"><?php echo strtolower($rwObat['OBAT_NAMA']).' @ Rp '.number_format($rwObat['HARGA_SATUAN'],2,",",".");?></td>
                            <td align="center" style="font-size:16px">&nbsp;</td>
                            <td align="center" style="font-size:16px">&nbsp;<?php echo $rwObat['TGL'];?></td>
                            <td align="center" style="font-size:16px">&nbsp;<?php if ($rwObat['QTY_RETUR']>0) echo $rwObat['QTY_JUAL']." - ".$rwObat['QTY_RETUR']; else echo $rwObat['QTY_JUAL'];?></td>
                            <td align="right" style="font-size:16px"><?php if ($for<>"1") echo number_format($rwObat['SUBTOTAL'],0,",",".");?>&nbsp;</td>
                        </tr>
                                    <?php
                                    $sTot+=$rwObat['SUBTOTAL'];
									if ($jenis_kunjungan==3 && $ksoid==4 && $klsId!=$kso_kelas_id && $rwObat['OBAT_KELOMPOK']==2){
										$sIurBHP+=$rwObat['SUBTOTAL'];
									}
                                }
								
								if ($rwKonsul["CARA_BAYAR"]==1){
									$sbyrTot=$sTot;
								}elseif ($rwKonsul["CARA_BAYAR"]==2){
									$sJaminKSO=$sTot;
									if ($sIurBHP>0){
										$sJaminKSO=$sTot-$sIurBHP;
									}
								}
							?>
                        <tr>
                            <td align="left" style="padding-left:60px;font-size:16px">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:16px">Sub Total&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:16px"><?php echo number_format($sTot,0,",",".");?>&nbsp;</td>
                        </tr>
                        <?php 
						if ($sJaminKSO>0){
						?>
                        <tr>
                            <td align="left" style="padding-left:60px;font-size:16px">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" colspan="2" style="font-weight:bold; border-bottom:solid #000000 1px;font-size:16px">Jamin KSO&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-bottom:solid #000000 1px;font-size:16px"><?php echo number_format($sJaminKSO,0,",",".");?>&nbsp;</td>
                        </tr>
                        <?php 
						}else{
						?>
                        <tr>
                            <td align="left" style="padding-left:60px;font-size:16px">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-bottom:solid #000000 1px;font-size:16px">Bayar&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-bottom:solid #000000 1px;font-size:16px"><?php echo number_format($sbyrTot,0,",",".");?>&nbsp;</td>
                        </tr>
                        <?php 
						}
						?>
							<?php
								$bTot+=$sTot;
								$jaminKSOTot+=$sJaminKSO;
								$byrTot+=$sbyrTot;
                            }
                        }
						$krgObat=$bTot-$byrTot-$jaminKSOTot;
						$krgTindObat=$krgTind+$krgObat;
						?>
                        <tr>
                            <td align="left" style="padding-left:60px; border-top:#000000 solid 1px; font-size:16px">&nbsp;</td>
                            <td align="center" style="border-top:solid #000000 1px; font-size:16px;">&nbsp;</td>
                            <td align="right" colspan="2" style="font-weight:bold; border-top:solid #000000 1px; font-size:16px">Total Biaya&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px; font-size:16px"><?php echo number_format($bTot,0,",",".");?>&nbsp;</td>
                        </tr>
                        <?php 
						if ($jaminKSOTot>0){
						?>
                        <tr>
                            <td align="left">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td colspan="2" align="right" style="font-weight:bold; font-size:16px">Total Jamin KSO&nbsp;</td>
                            <td align="right" style="font-weight:bold; font-size:16px"><?php echo number_format($jaminKSOTot,0,",",".");?>&nbsp;</td>
                        </tr>
                        <?php 
						}
						?>
                        <tr>
                            <td align="left">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" colspan="2" style="font-weight:bold; font-size:16px">Total Bayar&nbsp;</td>
                            <td align="right" style="font-weight:bold; font-size:16px"><?php echo number_format($byrTot,0,",",".");?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="left" height="2"></td>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px; font-size:16px"></td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px; font-size:16px"></td>
                        </tr>
                        <tr>
                            <td align="left" height="20">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px; font-size:16px">Kurang (Obat)&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px; font-size:16px"><?php echo number_format($krgObat,0,",",".");?>&nbsp;</td>
                        </tr>
						<tr>
                            <td align="left" height="20">&nbsp;</td>
                            <td colspan="3" align="right" style="font-weight:bold; border-top:solid #000000 1px; font-size:16px">Grand Total (Tind + Obat)&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px; font-size:16px"><?php echo number_format(($bTot+$sBiaya),0,",",".");?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="left" height="20">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td colspan="2" align="right" style="font-weight:bold; border-top:solid #000000 1px; font-size:16px">Kurang (Tind + Obat)&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px; font-size:16px"><?php echo number_format($krgTindObat,0,",",".");?>&nbsp;</td>
                        </tr>
                        <tr>
                            <!--td align="left" style="padding-left:60px;font-size:16px;" height="2"></td-->
                            <td align="right" colspan="5" style="font-size:16px" >
							Terbilang : 
							<?php
								$bilangan=($bTot+$sBiaya);//$krgTindObat;
								$bilangan=terbilang($bilangan,3);
								echo $bilangan;
							?> Rupiah
							</td>
                        </tr>
                        <tr>
                            <td align="left" style="padding-left:60px;font-size:16px;" height="2"></td>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="right"></td>
                            <td align="right"></td>
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
            <tr class="kwi" style="display:none">
                <td width="607">&nbsp;</td>
                <td width="293" style="font-weight:bold;font-size:16px"><?=$kotaRS?>, <?php echo gmdate('d F Y',mktime(date('H')+7));?><br/>
                    Petugas,<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php echo $rwUsr['nama']?> )</td>
            </tr>
            <tr>
            	<td colspan="2">
                <table width="100%" cellpadding="0" cellspacing="0" style="font-weight:bold;font-size:16px">
                	<tr>
                    	<td width="25%" align="center">&nbsp;</td>
                        <td width="10%">&nbsp;</td>
                        <td width="30%" align="center">&nbsp;</td>
                        <td width="10%">&nbsp;</td>
                        <td width="25%" align="center"><?=$kotaRS?>, <?php echo gmdate('d F Y',mktime(date('H')+7));?></td>
                    </tr>
                    <tr>
						<td align="center">Kasir</td>
                        <td>&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td>&nbsp;</td>
						<td align="center">Pasien</td>
                    </tr>
                    <tr>
                    	<td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                    </tr>
                    <tr>
                    	
                        <?php
							/* $sDok="SELECT 
								  IFNULL(
									(SELECT 
									  pg.nama 
									FROM
									  b_pelayanan p 
									  INNER JOIN b_ms_pegawai pg 
										ON pg.id = p.dokter_id 
									WHERE p.kunjungan_id = '".$idKunj."' 
									  AND p.jenis_kunjungan = 3 
									ORDER BY p.id ASC 
									LIMIT 1), 
									(SELECT 
									  pg.nama 
									FROM
									  b_pelayanan p 
									  INNER JOIN b_tindakan t 
										ON t.pelayanan_id = p.id
									  INNER JOIN b_ms_pegawai pg 
										ON pg.id = t.user_id  
									WHERE p.kunjungan_id = '".$idKunj."' 
									ORDER BY p.id ASC 
									LIMIT 1)
								  ) AS nama"; */
							$sDok = "SELECT p.nama FROM b_ms_pegawai p WHERE p.id = '{$idUser}'";
						$qDok=mysql_query($sDok);
						$rwDok=mysql_fetch_array($qDok);
						?>
						<td align="center">(&nbsp;<?php echo $rwDok['nama']?>&nbsp;)</td>
                        <td>&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td>&nbsp;</td>
						<td align="center">(&nbsp;<?php echo strtolower($rw['nmPas']);?>&nbsp;)</td>
                    </tr>
                </table>
                </td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr id="trTombol">
                <td colspan="2" class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
                    <input id="btnExpExcl" type="button" value="Export --> Excell" onClick="window.open('RincianTindakanExcell.php?idKunj=<?php echo $idKunj; ?>&idPel=<?php echo $idPel; ?>&idUser=<?php echo $idUser; ?>&inap=<?php echo $inap; ?>');"/>
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
                </td>
            </tr>
        </table>
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
        </script>
    </body>
</html>
<?php 
mysql_close($konek);
?>
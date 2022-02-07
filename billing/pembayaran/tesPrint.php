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
$idbayar=$_REQUEST['idbayar'];
	$dibayar=0;
	$titipan=0;
	$keringanan=0;
	$jaminan=0;
	$sql = "SELECT b.* FROM b_bayar b WHERE b.id = '$idbayar'";
	$rs = mysql_query($sql);
	if (mysql_num_rows($rs)>0){
		$rows=mysql_fetch_array($rs);
		$dibayar=$rows["nilai"];
		$titipan=$rows["titipan"];
		$keringanan=$rows["keringanan"];
	}
//----------------------------------
  $sqlPas="SELECT no_rm,b_ms_pasien.nama nmPas,b_ms_pasien.alamat,
  b_ms_pasien.rt,b_ms_pasien.rw,b_ms_pasien.sex,b_ms_kelas.nama kelas,
  b_ms_kso.nama nmKso,DATE_FORMAT(b_kunjungan.tgl,'%d %M %Y') tglM,
  DATE_FORMAT(b_kunjungan.tgl_pulang,'%d %M %Y') tglP,
  b_ms_pasien.desa_id,b_ms_pasien.kec_id,
  (SELECT nama FROM b_ms_wilayah WHERE id=b_ms_pasien.kec_id) nmKec,
  (SELECT nama FROM b_ms_wilayah WHERE id=b_ms_pasien.desa_id) nmDesa,
  b_kunjungan.kso_id,b_kunjungan.kso_kelas_id FROM b_kunjungan
  INNER JOIN b_ms_pasien ON b_kunjungan.pasien_id=b_ms_pasien.id
  INNER JOIN b_ms_kelas ON b_kunjungan.kelas_id=b_ms_kelas.id
  INNER JOIN b_ms_kso ON b_kunjungan.kso_id=b_ms_kso.id
  WHERE b_kunjungan.id=$idKunj";

$qPas=mysql_query($sqlPas);
$rw=mysql_fetch_array($qPas);
$ksoid=$rw['kso_id'];
$qUsr = mysql_query("SELECT nama,id FROM b_ms_pegawai WHERE id=".$_SESSION['userId']);
$rwUsr = mysql_fetch_array($qUsr);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/print.css" media="print">
<title>.: Rincian Tagihan Pasien :.</title>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="left" class="kwi">
  <tr>
    <td colspan="2"><b><br/><?=$pemkabRS?><br>
							<?=$namaRS?><br>
							<?=$alamatRS?><br>
							Telepon <?=$tlpRS?><br/></b>&nbsp;</td>
  </tr>
  <tr>
    <td height="5" colspan="2" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
  </tr>
  <tr class="kwi">
    <td height="30" colspan="2" align="center" style="font-weight:bold"><u>&nbsp;Laporan Rincian Tagihan Pasien&nbsp;</u></td>
  </tr>
  <tr class="kwi">
    <td colspan="2">
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="11%">No RM</td>
				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td colspan="3">&nbsp;<?php echo $rw['no_rm']?></td>
				<td width="10%">Tgl Mulai</td>
				<td width="1%" align="center" style="font-weight:bold">:</td>
				<td width="30%">&nbsp;<?php echo $rw['tglM']?></td>
			</tr>
			<tr>
				<td width="11%">Nama Pasien </td>
				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td colspan="3">&nbsp;<?php echo strtolower($rw['nmPas'])?></td>
				<td width="10%">Tgl Selesai </td>
				<td width="1%" align="center" style="font-weight:bold">:</td>
				<td width="30%">&nbsp;<?php echo $rw['tglP']?></td>
			</tr>
			<tr>
				<td width="11%">Alamat</td>
				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td colspan="3">&nbsp;<?php echo strtolower($rw['alamat'])?></td>
				<td width="10%">Kelas</td>
				<td width="1%" align="center" style="font-weight:bold">:</td>
				<td width="30%">&nbsp;<?php echo strtolower($rw['kelas'])?></td>
			</tr>
			<tr>
				<td width="11%">&nbsp;</td>
				<td width="2%" align="center" style="font-weight:bold">&nbsp;</td>
				<td width="8%">Kel. / Desa </td>
				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td width="36%">&nbsp;<?php echo strtolower($rw['nmDesa']);?></td>
				<td width="10%">&nbsp;</td>
				<td width="1%" align="center" style="font-weight:bold">&nbsp;</td>
				<td width="30%"></td>
			</tr>
			<tr>
				<td width="11%">&nbsp;</td>
				<td width="2%" align="center" style="font-weight:bold"></td>
				<td width="8%">RT / RW </td>
				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td width="36%">&nbsp;<?php echo strtolower($rw['rt']." / ".$rw['rw']);?></td>
				<td width="10%">&nbsp;</td>
				<td width="1%" align="center" style="font-weight:bold">&nbsp;</td>
				<td width="30%"></td>
			</tr>
			<tr>
				<td width="11%">Jenis Kelamin </td>
				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td colspan="3">&nbsp;<?php echo strtolower($rw['sex'])?></td>
				<td width="10%">Status Pasien </td>
				<td width="1%" align="center" style="font-weight:bold">:</td>
				<td width="30%">&nbsp;<?php echo strtolower($rw['nmKso'])?></td>
			</tr>
		</table>	</td>
  </tr>
  <tr class="kwi">
    <td height="30" colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" style="border:#000000 solid 1px; font-weight:bold">Tindakan</td>
				<td align="center" style="border:#000000 solid 1px; border-left:none; font-weight:bold">Tanggal</td>
				<td align="center" style="border:#000000 solid 1px; border-left:none; font-weight:bold">Jumlah</td>
				<td align="center" style="border:#000000 solid 1px; border-left:none; font-weight:bold">Biaya</td>
			</tr>
			<?php
/*				if($idPel!=''){
				  	$sUnit="SELECT mu.nama nmUnit,mu.id idUnit,p.id FROM b_pelayanan p			  
				  INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
				  WHERE p.id='$idPel'";
				}else{
				  if($jeniskasir=='0'){
					$sUnit="SELECT mu.nama nmUnit,mu.id idUnit,p.id FROM b_pelayanan p			  
				  INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
				  WHERE p.kunjungan_id='$idKunj'";
				  }else{			    
				  $sUnit="SELECT mu.nama nmUnit,mu.id idUnit,p.id FROM b_pelayanan p			  
				  INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
				  WHERE mu.parent_id in ($jeniskasir) AND p.kunjungan_id='$idKunj'";			  
				  }
				}*/
			if ($ksoid!=1){
				if($idPel!=''){
					$sUnit="SELECT p.id,mu.nama nmUnit,mu.id idUnit FROM b_pelayanan p			  
					INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
					WHERE p.id='$idPel'";
				}else{
					if($jeniskasir=='0'){
						$sUnit="SELECT p.id,mu.nama nmUnit,mu.id idUnit FROM b_pelayanan p			  
						INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
						WHERE p.kunjungan_id='$idKunj'";
					}else{			    
						$sUnit="SELECT p.id,mu.nama nmUnit,mu.id idUnit FROM b_pelayanan p			  
						INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
						WHERE mu.parent_id in ($jeniskasir) AND p.kunjungan_id='$idKunj'";			  
					}
				}
			}else{
				if ($idbayar!=""){
					$sUnit="SELECT DISTINCT p.id,mu.id idUnit,mu.nama nmUnit FROM b_bayar b INNER JOIN b_bayar_tindakan bt ON b.id=bt.bayar_id 
INNER JOIN b_tindakan t ON bt.tindakan_id=t.id INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE b.id=$idbayar";
				}else{
					if($idPel!=''){
						$sUnit="SELECT p.id,mu.nama nmUnit,mu.id idUnit FROM b_pelayanan p			  
						INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
						WHERE p.id='$idPel'";
					}else{
						if($jeniskasir=='0'){
							$sUnit="SELECT p.id,mu.nama nmUnit,mu.id idUnit FROM b_pelayanan p			  
							INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
							WHERE p.kunjungan_id='$idKunj'";
						}else{			    
							$sUnit="SELECT p.id,mu.nama nmUnit,mu.id idUnit FROM b_pelayanan p			  
							INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
							WHERE mu.parent_id in ($jeniskasir) AND p.kunjungan_id='$idKunj'";			  
						}
					}
				}
			}
			//echo $sUnit."<br>";
			$qUnit=mysql_query($sUnit);
			$sByr=0;
			$sBiaya=0;
			$sJaminKso=0;
			while($rwUnit=mysql_fetch_array($qUnit)){?>
			<tr>
				<td align="left" style="padding-left:25px"><?php echo $rwUnit['nmUnit']?></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<?php
			$cHari=0;
			$bKmr=0;
			$sTot=0;
			$bTot=0;
			/*$sKmr="SELECT tk.id,mk.id idKmr,mk.kode kdKmr,mk.nama nmKmr,
			mKls.nama nmKls,DATE_FORMAT(tk.tgl_in,'%d-%m-%Y') tgl_in,
			(datediff(ifnull(tk.tgl_out,now()),tk.tgl_in)+1)*(tk.beban_kso+tk.beban_pasien) biaya,
			datediff(ifnull(tk.tgl_out,now()),tk.tgl_in)+1 cHari
			FROM b_tindakan_kamar tk
			INNER JOIN b_pelayanan p ON tk.pelayanan_id=p.id
			INNER JOIN b_ms_kamar mk ON tk.kamar_id=mk.id
			INNER JOIN b_ms_kelas mKls ON tk.kelas_id=mKls.id
			WHERE kunjungan_id=$idKunj AND mk.unit_id='".$rwUnit['idUnit']."'";*/
			$sKmr="SELECT tk.id,mk.id idKmr,mk.kode kdKmr,mk.nama nmKmr, mKls.nama nmKls,DATE_FORMAT(tk.tgl_in,'%d-%m-%Y') tgl_in,
IF(tk.status_out=0,(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)+1)*(tk.beban_kso+tk.beban_pasien),
(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*(tk.beban_kso+tk.beban_pasien)) biaya,
IF(tk.status_out=0,(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)+1)*tk.beban_kso,
(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*tk.beban_kso) biaya_kso,tk.bayar, 
IF(tk.status_out=0,(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)+1),DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)) cHari 
FROM b_tindakan_kamar tk INNER JOIN b_pelayanan p ON tk.pelayanan_id=p.id INNER JOIN b_ms_kamar mk ON tk.kamar_id=mk.id 
INNER JOIN b_ms_kelas mKls ON tk.kelas_id=mKls.id WHERE kunjungan_id='$idKunj' AND mk.unit_id='".$rwUnit['idUnit']."'";
			//echo $sKmr."<br>";
			$qKmr=mysql_query($sKmr);
			while($rwKmr=mysql_fetch_array($qKmr)){
				$bKmr+=$rwKmr['biaya'];
				$sJaminKso+=$rwKmr['biaya_kso'];
				$sByr+=$rwKmr['bayar'];
			//$jKmr+=1;
			//$cHari+=$rwKmr['cHari'];
			?>
			<tr>
			  <td align="left" style="padding-left:50px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kamar :&nbsp;<?php echo $rwKmr['nmKmr']?></td>
				<td align="center"><?php echo $rwKmr['tgl_in']?></td>
				<td align="center"><?php echo $rwKmr['cHari']?></td>
				<td align="right"><?php echo number_format($rwKmr['biaya'],0,",",".")?>&nbsp;</td>
			</tr>
			<?php }
			if ($idbayar!=""){
				$sKonsul="SELECT DISTINCT t.user_id,IFNULL(mp.nama,'-') konsul
FROM b_bayar_tindakan bt INNER JOIN b_tindakan t ON bt.tindakan_id=t.id 
LEFT JOIN b_ms_pegawai mp ON t.user_id=mp.id 
WHERE bt.bayar_id=$idbayar AND t.pelayanan_id='".$rwUnit['id']."'";
			}else{
				$sKonsul="SELECT user_id,IFNULL(b_ms_pegawai.nama,'-') konsul FROM b_tindakan LEFT JOIN b_ms_pegawai ON b_tindakan.user_id=b_ms_pegawai.id WHERE b_tindakan.pelayanan_id='".$rwUnit['id']."' GROUP BY b_tindakan.user_id";
			}
			//echo $sKonsul."<br>";
			 $qKonsul=mysql_query($sKonsul);
			while($rwKonsul=mysql_fetch_array($qKonsul)){?>
			<tr>
				<td align="left" style="padding-left:50px"><?php echo strtolower($rwKonsul['konsul'])?></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<?php
			if ($ksoid==1){
				if ($idbayar!=""){
					$sTind="SELECT DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,mt.nama nmTind, t.biaya*t.qty AS biaya,0 AS biaya_kso,t.bayar,t.qty cTind 
FROM b_bayar_tindakan bt INNER JOIN b_tindakan t ON bt.tindakan_id=t.id INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id 
INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id INNER JOIN b_ms_unit mu ON t.unit_act=mu.id 
WHERE bt.bayar_id='$idbayar' AND t.pelayanan_id='".$rwUnit['id']."' AND t.user_id=".$rwKonsul['user_id']." AND mu.kategori<>1 ORDER BY t.id";
				}else{
					$sTind="SELECT DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,mt.nama nmTind,
				t.biaya*t.qty as biaya,0 as biaya_kso,t.bayar,t.qty cTind
				FROM b_tindakan t
				INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
				INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id INNER JOIN b_ms_unit mu ON t.unit_act=mu.id
				WHERE t.pelayanan_id='".$rwUnit['id']."'
				AND user_id='".$rwKonsul['user_id']."' AND mu.kategori<>1 AND t.lunas=0 ORDER BY t.id";
				}
			}else{
				if ($idbayar!=""){
					$sTind="SELECT DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,mt.nama nmTind,
(t.biaya_kso+t.biaya_pasien)*t.qty AS biaya,t.biaya_kso*t.qty AS biaya_kso,t.bayar,t.qty cTind
FROM b_bayar_tindakan bt INNER JOIN b_tindakan t ON bt.tindakan_id=t.id
INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
WHERE bt.bayar_id='$idbayar' AND t.pelayanan_id='".$rwUnit['id']."' AND user_id='".$rwKonsul['user_id']."' ORDER BY t.id";
				}else{
					$sTind="SELECT DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,mt.nama nmTind,
				(t.biaya_kso+t.biaya_pasien)*t.qty as biaya,t.biaya_kso*t.qty as biaya_kso,t.bayar,t.qty cTind
				FROM b_tindakan t
				INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
				INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
				WHERE t.kunjungan_id=$idKunj AND t.pelayanan_id=".$rwUnit['id']."
				AND user_id='".$rwKonsul['user_id']."' AND t.lunas=0 ORDER BY t.id";
				}
			}
			//echo $sTind."<br>";
			$qTind=mysql_query($sTind);
			while($rwTind=mysql_fetch_array($qTind)){?>
			<tr>
				<td align="left" style="padding-left:85px"><?php echo strtolower($rwTind['nmTind'])?></td>
				<td align="center">&nbsp;<?php echo $rwTind['tgl']?></td>
				<td align="center">&nbsp;<?php echo $rwTind['cTind']?></td>
				<td align="right"><?php echo number_format($rwTind['biaya'],0,",",".")?>&nbsp;</td>
			</tr>
			<?php 
					$sTot+=$rwTind['biaya'];
					$sJaminKso+=$rwTind['biaya_kso'];
					$sByr+=$rwTind['bayar'];
			}
			?>
			<?php
			    $bTot+=$sTot;
				//echo "kamar=".$bKmr."<br>";
				//$sBiaya+=$bTot;
			}
			$bTot+=$bKmr;
			$sBiaya+=$bTot;
			?>
			<tr>
				<td align="left" style="padding-left:60px">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px">Sub Total&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px"><?php echo number_format($bTot,0,",",".")?>&nbsp;</td>
			</tr>
			<?php
				//$sBayar=$sByr;
			}?>
			<tr>
				<td align="left" style="padding-left:60px; border-top:#000000 dotted 1px">&nbsp;</td>
				<td align="center" style="border-top:dotted #000000 1px">&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px">Total Biaya&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px"><?php echo number_format($sBiaya,0,",",".")?>&nbsp;</td>
			</tr>
			<?php
			/*
			$qJam=mysql_query("SELECT jaminan FROM b_ms_kso_paket_hp WHERE b_ms_kso_id=".$rw['kso_id']." AND b_ms_kelas_id=".$rw['kso_kelas_id']);
			$rwJam= mysql_fetch_array($qJam);
			if($cHari=="" or $chari=='0')
				$cHari=1;
			else
				$cHari=$cHari-$jKmr+1;
			*/
				?>
			<!--tr>
				<td align="left" style="padding-left:60px;">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="right" style="font-weight:bold">Jaminan&nbsp;</td>
				<td align="right" style="font-weight:bold"><?php //echo number_format($jaminan=$cHari*$rwJam['jaminan'],2,",",".")?>&nbsp;</td>
			</tr-->
            <?php 
			if ($sJaminKso>0){
			?>
			<tr>
			  <td height="19" align="left" style="padding-left:60px;">&nbsp;</td>
			  <td align="center">&nbsp;</td>
			  <td align="right" style="font-weight:bold">Dijamin KSO&nbsp;</td>
			  <td align="right" style="font-weight:bold"><?php echo number_format($sJaminKso,0,",","."); ?>&nbsp;</td>
		  </tr>
          <?php }?>
            <?php 
			if ($titipan>0){
			?>
			<tr>
			  <td height="19" align="left" style="padding-left:60px;">&nbsp;</td>
			  <td align="center">&nbsp;</td>
			  <td align="right" style="font-weight:bold">Titipan&nbsp;</td>
			  <td align="right" style="font-weight:bold"><?php echo number_format($titipan,0,",","."); ?>&nbsp;</td>
		  </tr>
          <?php }?>
            <?php 
			if ($keringanan>0){
			?>
			<tr>
			  <td height="19" align="left" style="padding-left:60px;">&nbsp;</td>
			  <td align="center">&nbsp;</td>
			  <td align="right" style="font-weight:bold">Keringanan&nbsp;</td>
			  <td align="right" style="font-weight:bold"><?php echo number_format($keringanan,0,",","."); ?>&nbsp;</td>
		  </tr>
          <?php }?>
			<tr>
				<td height="19" align="left" style="padding-left:60px;">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="right" style="font-weight:bold">Bayar&nbsp;</td>
				<td align="right" style="font-weight:bold"><?php echo number_format($dibayar,0,",",".");?>&nbsp;</td>
			</tr>
			<tr>
				<td align="left" style="padding-left:60px;" height="2"></td>
				<td align="center"></td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px"></td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px"></td>
			<tr>
				<td align="left" style="padding-left:60px;">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px">Kurang&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px"><?php echo number_format(($sBiaya-$sJaminKso-$dibayar-$keringanan-$titipan),0,",",".")?>&nbsp;</td>
			</tr>
	</table>	</td>
  </tr>
  <tr>
    <td height="5" colspan="2" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr class="kwi">
    <td width="607">&nbsp;</td>
    <td width="293" style="font-weight:bold"><?=$kotaRS?>, <?php echo gmdate('d F Y',mktime(date('H')+7));?><br/>
    Petugas,<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php echo $rwUsr['nama']?> )</td>
  </tr>
    <tr id="trTombol">
        <td colspan="2" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
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

<?php 
session_start();
if($_POST['excel']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="penerimaan_pasien.xls"');
}
?>
<title>.: Rekapitulasi Penerimaan Pasien :.</title>
<?php
	//session_start();
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$txtJam1=$_REQUEST['txtJam1'];
	$txtJam2=$_REQUEST['txtJam2'];
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	
	$sqlUnit1 = "SELECT nama,inap FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	$inap = $rwUnit1['inap'];
	
if($_REQUEST['TmpLayanan']!=0){
	$sqlUnit2 = "SELECT nama,inap FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	$fTmpLay = " AND p.unit_id=".$_REQUEST['TmpLayanan'];
	$inap = $rwUnit2['inap'];
}else
	$fTmpLay = " AND p.jenis_layanan=".$_REQUEST['JnsLayanan'];

	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);

?>
<table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td><b>
      <?=$_SESSION['namaP'] ?>
      <br />
      <?=$_SESSION['alamatP']?>
      <br />
      Telepon <?=$_SESSION['tlpP'] ?>
      <br />
      <?=$_SESSION['kotaP']?>
    </b></td>
  </tr>
  <tr>
    <td align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase;"><b>Laporan Penerimaan Kasir<br />Jenis Layanan <?php echo $rwUnit1['nama'] ?> <br/>Tempat Layanan <?php if($rwUnit2['nama']=="") echo 'Semua'; else echo $rwUnit2['nama'] ?><br />Periode <?php echo $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2]?></b></td>
  </tr>
  <tr>
    <td height="30" align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  <tr>
    <td>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr style="font-weight:bold; text-align:center;">
				<td width="5%" style="border-bottom:1px solid; border-top:1px solid;">No</td>
				<td width="10%" style="border-bottom:1px solid; border-top:1px solid;">Tgl Bayar</td>
				<td width="7%" style="border-bottom:1px solid; border-top:1px solid;">Jam</td>
				<td width="9%" style="border-bottom:1px solid; border-top:1px solid;">No Kwitansi</td>
				<td width="9%" style="border-bottom:1px solid; border-top:1px solid;">No.RM</td>
				<td width="30%" style="border-bottom:1px solid; border-top:1px solid;">Nama Pasien</td>
				<td width="10%" style="border-bottom:1px solid; border-top:1px solid;">Retribusi/<br>Kamar</td>
				<td width="10%" style="border-bottom:1px solid; border-top:1px solid;">Tindakan</td>
				<td width="10%" style="border-bottom:1px solid; border-top:1px solid;">Total</td>
			</tr>
			<?php
					if($_REQUEST['TmpLayanan']==0){
						$fTmp = "b_ms_unit.parent_id = '".$_REQUEST['JnsLayanan']."'";
					}else{
						$fTmp = "b_ms_unit.id = '".$_REQUEST['TmpLayanan']."'";
					}
					
					//if($_REQUEST['StatusPas']!=0) $fKso = "AND b_tindakan.kso_id = '".$_REQUEST['StatusPas']."'";
					if($_REQUEST['StatusPas']!=0) $fKso = "AND b_bayar_tindakan.kso_id = '".$_REQUEST['StatusPas']."'";
					
					$sqlUn = "SELECT t.id, t.nama, t.inap FROM (SELECT b_ms_unit.id, b_ms_unit.nama, b_ms_unit.inap FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_bayar.user_act INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE $fTmp $fKso AND b_bayar_tindakan.tipe=0 AND b_bayar_tindakan.nilai<>0 AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' AND TIME_FORMAT(b_bayar.tgl_act,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2'
					UNION
					SELECT b_ms_unit.id, b_ms_unit.nama, b_ms_unit.inap FROM b_pelayanan LEFT JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan_kamar.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_bayar.user_act INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE $fTmp $fKso AND b_bayar_tindakan.tipe=1 AND b_bayar_tindakan.nilai<>0 AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' AND TIME_FORMAT(b_bayar.tgl_act,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2') AS t GROUP BY t.id";
					//echo $sqlUn.";<br>";
					$rsUn = mysql_query($sqlUn);
					$ttot1 = 0;
					$ttot2 = 0;
					$ttot3 = 0;
					while($rwUn = mysql_fetch_array($rsUn))
					{
			?>
			<tr>
			  <td colspan="9" style="text-transform:uppercase; text-decoration:underline; font-weight:bold; padding-left:10px"><?php echo $rwUn['nama']?></td>
		  	</tr>
		  	<?php
					$sqlTmp = "SELECT t.id, t.nama FROM (SELECT b_ms_pegawai.id, b_ms_pegawai.nama FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_bayar.user_act INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE b_pelayanan.unit_id = '".$rwUn['id']."' AND b_bayar_tindakan.tipe=0 AND b_bayar_tindakan.nilai<>0 $fKso AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' AND TIME_FORMAT(b_bayar.tgl_act,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2'
					UNION 
					SELECT b_ms_pegawai.id, b_ms_pegawai.nama FROM b_pelayanan LEFT JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan_kamar.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_bayar.user_act INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE b_pelayanan.unit_id = '".$rwUn['id']."' AND b_bayar_tindakan.nilai<>0 AND b_bayar_tindakan.tipe=1 $fKso AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' AND TIME_FORMAT(b_bayar.tgl_act,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2') AS t GROUP BY t.id";
					$rsTmp = mysql_query($sqlTmp);
					$tot1 = 0;
					$tot2 = 0;
					$tot3 = 0;
					while($rwTmp = mysql_fetch_array($rsTmp))
					{
			?>
			<tr>
				<td colspan="9" style="text-transform:uppercase; text-decoration:underline; font-weight:bold; padding-left:20px"><?php echo $rwTmp['nama']?></td>
			</tr>
			<?php
					$sqlKso = "SELECT t.id, t.nama FROM (SELECT b_ms_kso.id, b_ms_kso.nama FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id INNER JOIN b_ms_kso ON b_ms_kso.id = b_bayar_tindakan.kso_id WHERE b_pelayanan.unit_id = '".$rwUn['id']."' AND b_bayar_tindakan.tipe=0 AND b_bayar_tindakan.nilai<>0 AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' AND TIME_FORMAT(b_bayar.tgl_act,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2' AND b_bayar.user_act = '".$rwTmp['id']."' $fKso
					UNION 
					SELECT b_ms_kso.id, b_ms_kso.nama FROM b_pelayanan LEFT JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan_kamar.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id INNER JOIN b_ms_kso ON b_ms_kso.id = b_bayar_tindakan.kso_id WHERE b_pelayanan.unit_id = '".$rwUn['id']."' AND b_bayar_tindakan.tipe=1 AND b_bayar_tindakan.nilai<>0 AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' AND TIME_FORMAT(b_bayar.tgl_act,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2' AND b_bayar.user_act = '".$rwTmp['id']."' $fKso) AS t GROUP BY t.id ";
					$rsKso = mysql_query($sqlKso);
					$t1 = 0;
					$t2 = 0;
					$t3 = 0;
					while($rwKso = mysql_fetch_array($rsKso))
					{
			?>
			<tr>
				<td colspan="9" style="text-transform:uppercase; font-weight:bold; padding-left:30px"><?php echo $rwKso['nama']?></td>
			</tr>
			<?php
					$sql = "SELECT t.id,t.pelayanan_id, t.tgl, t.tglb, t.jam, t.kwi, t.no_rm, t.nama,  t.nilai, t.tindakan_id FROM (SELECT DATE_FORMAT(b_bayar.tgl,'%d-%m-%Y') AS tgl,b_bayar.tgl tglb, TIME_FORMAT(b_bayar.tgl_act,'%H:%i') AS jam, b_bayar.nobukti AS kwi, b_ms_pasien.id,b_ms_pasien.no_rm, b_ms_pasien.nama, b_pelayanan.id AS pelayanan_id, b_bayar.nilai, b_bayar_tindakan.tindakan_id FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_pelayanan.pasien_id WHERE b_pelayanan.unit_id = '".$rwUn['id']."'  AND b_bayar_tindakan.tipe=0 AND b_bayar_tindakan.nilai<>0 AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' AND TIME_FORMAT(b_bayar.tgl_act,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2' AND b_bayar.user_act = '".$rwTmp['id']."' AND b_bayar_tindakan.kso_id = '".$rwKso['id']."'
					UNION 
					SELECT DATE_FORMAT(b_bayar.tgl,'%d-%m-%Y') AS tgl,b_bayar.tgl tglb, TIME_FORMAT(b_bayar.tgl_act,'%H:%i') AS jam, b_bayar.nobukti AS kwi, b_ms_pasien.id,b_ms_pasien.no_rm, b_ms_pasien.nama, b_pelayanan.id AS pelayanan_id, b_bayar.nilai, b_bayar_tindakan.tindakan_id FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id LEFT JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan_kamar.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_pelayanan.pasien_id WHERE b_pelayanan.unit_id = '".$rwUn['id']."' AND b_bayar_tindakan.tipe=1 AND b_bayar_tindakan.nilai<>0 AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' AND TIME_FORMAT(b_bayar.tgl_act,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2' AND b_bayar.user_act = '".$rwTmp['id']."' AND b_bayar_tindakan.kso_id = '".$rwKso['id']."') AS t GROUP BY t.pelayanan_id,t.tglb";
					//echo $sql."<br>";
					$rs = mysql_query($sql);
					$no = 1;
					$sub1 = 0;
					$sub2 = 0;
					$sub3 = 0;
					while($rw = mysql_fetch_array($rs))
					{ 
						if($rwUn['inap']==0){
							$q = "SELECT SUM(b_bayar_tindakan.nilai) AS nilai FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id WHERE b_pelayanan.id = '".$rw['pelayanan_id']."' AND b_ms_tindakan.klasifikasi_id = '11' AND b_bayar_tindakan.tipe = 0 AND b_bayar.user_act = '".$rwTmp['id']."' AND b_bayar.tgl = '".$rw['tglb']."' GROUP BY b_pelayanan.id ";
						}else{
							$q = "SELECT SUM(b_tindakan_kamar.bayar_pasien) AS nilai FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan_kamar.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id WHERE b_pelayanan.id = '".$rw['pelayanan_id']."' AND b_bayar_tindakan.tipe = 1 AND b_bayar.user_act = '".$rwTmp['id']."' AND b_bayar.tgl = '".$rw['tglb']."' GROUP BY b_pelayanan.id";
						}
						//echo $q."<br>";
						$rs1 = mysql_query($q);
						$rw1 = mysql_fetch_array($rs1);
						
						$qTind = "SELECT SUM(b_bayar_tindakan.nilai) AS nilai FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id WHERE b_pelayanan.id = '".$rw['pelayanan_id']."'  AND b_bayar_tindakan.tipe = 0 AND b_bayar.user_act = '".$rwTmp['id']."' AND b_bayar.tgl = '".$rw['tglb']."' AND b_ms_tindakan.klasifikasi_id <> '11' GROUP BY b_pelayanan.id";
						//echo $qTind."<br>";
						$sTind = mysql_query($qTind);
						$wTind = mysql_fetch_array($sTind);
			?>
			<tr>
				<td style="text-align:center"><?php echo $no;?></td>
				<td style="text-align:center"><?php echo $rw['tgl']?></td>
				<td style="text-align:center"><?php echo $rw['jam']?></td>
				<td style="text-align:center"><?php echo $rw['kwi']?></td>
				<td style="text-align:center"><?php echo $rw['no_rm']?></td>
				<td style="text-transform:uppercase; padding-left:5px;"><?php echo $rw['nama']?></td>
				<td style="text-align:right; padding-right:10px;"><?php echo number_format($rw1['nilai'],0,",",".")?></td>
				<td style="text-align:right; padding-right:10px;"><?php echo number_format($wTind['nilai'],0,",",".")?></td>
				<td style="text-align:right; padding-right:10px;"><?php echo number_format($rw1['nilai']+$wTind['nilai'],0,",",".")?></td>
			</tr>
			<?php
					$no++;
					$sub1 = $sub1 + $rw1['nilai'];
					$sub2 = $sub2 + $wTind['nilai'];
					$sub3 = $sub3 + $rw1['nilai']+$wTind['nilai'];
					}
			?>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">Subtotal&nbsp;</td>
				<td style="text-align:right; padding-right:10px; border-top:1px solid;"><?php echo number_format($sub1,0,",",".")?></td>
				<td style="text-align:right; padding-right:10px; border-top:1px solid;"><?php echo number_format($sub2,0,",",".")?></td>
				<td style="text-align:right; padding-right:10px; border-top:1px solid;"><?php echo number_format($sub3,0,",",".")?></td>
			</tr>
			<?php
					$t1 = $t1 + $sub1;
					$t2 = $t2 + $sub2;
					$t3 = $t3 + $sub3;
					}
			?>
			<tr>
				<td colspan="6" style="text-align:right; font-weight:bold;">Total&nbsp;</td>
				<td style="text-align:right; border-top:1px solid; font-weight:bold; padding-right:10px;"><?php echo number_format($t1,0,",",".")?></td>
				<td style="text-align:right; border-top:1px solid; font-weight:bold; padding-right:10px;"><?php echo number_format($t2,0,",",".")?></td>
				<td style="text-align:right; border-top:1px solid; font-weight:bold; padding-right:10px;"><?php echo number_format($t3,0,",",".")?></td>
			</tr>
			<?php
					$tot1 = $tot1 + $t1;
					$tot2 = $tot2 + $t2;
					$tot3 = $tot3 + $t3;
					}
			?>
			<tr>
				<td height="25" colspan="6" style="text-align:right; border-top:1px solid; font-weight:bold;">Total&nbsp;</td>
				<td style="text-align:right; border-top:1px solid; font-weight:bold; padding-right:10px;"><?php echo number_format($tot1,0,",",".")?></td>
				<td style="text-align:right; border-top:1px solid; font-weight:bold; padding-right:10px;"><?php echo number_format($tot2,0,",",".")?></td>
				<td style="text-align:right; border-top:1px solid; font-weight:bold; padding-right:10px;"><?php echo number_format($tot3,0,",",".")?></td>
			</tr>
			<?php
					$ttot1 = $ttot1 + $tot1;
					$ttot2 = $ttot2 + $tot2;
					$ttot3 = $ttot3 + $tot3;
					} 
			?>
			<tr style="font-size:12px;">
			  <td height="25" colspan="6" style="text-align:right; border-top:1px solid; border-bottom:1px solid; font-weight:bold;">TOTAL&nbsp;</td>
			  <td style="text-align:right; border-top:1px solid; border-bottom:1px solid; font-weight:bold; padding-right:10px;"><?php echo number_format($ttot1,0,",",".")?></td>
			  <td style="text-align:right; border-top:1px solid; border-bottom:1px solid; font-weight:bold; padding-right:10px;"><?php echo number_format($ttot2,0,",",".")?></td>
			  <td style="text-align:right; border-top:1px solid; border-bottom:1px solid; font-weight:bold; padding-right:10px;"><?php echo number_format($ttot3,0,",",".")?></td>
		  </tr>
		</table>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td align="right">Tgl Cetak:&nbsp;<?php echo $date_now;?>&nbsp;Jam:&nbsp;<?php echo $jam?></td>
  </tr>
  <tr>
	<td align="right">Yang Mencetak</td>
  </tr>
  <tr>
  	<td height="50">&nbsp;</td>
  </tr>
  <tr>
	<td align="right"><b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  <tr>
  	<td height="50">
	 <tr id="trTombol">
       <td colspan="3" class="noline" align="center">
	   		<?php 
			if($_POST['excel']!='excel'){
			?>
            <select  name="select" id="cmbPrint2an" onchange="changeSize(this.value)">
              <option value="0">Printer non-Kretekan</option>
              <option value="1">Printer Kretekan</option>
            </select>
			<br />
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
            <?php } ?></td>
    </tr>
	</td>
  </tr>
</table>
<script type="text/JavaScript">

/*try{	
formatF4Portrait();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
}*/
function changeSize(par){
	if(par == 1){
		document.getElementById('tblPrint').width = 1200;
	}
	else{
		document.getElementById('tblPrint').width = 800;
	}
}

    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		/*try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		}*/
		window.print();
		window.close();
        }
    }
</script>
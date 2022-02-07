<?php
	include("../sesi.php");
    include("../koneksi/konek.php");
    
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
	//echo $_REQUEST['tglAwal2']."<br>";
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = "b.tgl = '$tglAwal2' ";
		$waktu2 = "keuangan.k_transaksi.tgl = '$tglAwal2' ";
		$waktuL = "AND k.tgl = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
		$cbln = ($bln<10)?"0".$bln:$bln;;
        $thn = $_POST['cmbThn'];
        $waktu = "month(b.tgl) = '$bln' AND year(b.tgl) = '$thn' ";
		$waktu2 = "month(keuangan.k_transaksi.tgl) = '$bln' AND year(keuangan.k_transaksi.tgl) = '$thn' ";
		$waktuL = "AND month(k.tgl) = '$bln' AND year(k.tgl) = '$thn' ";
        $Periode = "Bulan $arrBln[$cbln] Tahun $thn";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $_REQUEST['tglAkhir'];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = "b.tgl between '$tglAwal2' and '$tglAkhir2' ";
		$waktu2 = "keuangan.k_transaksi.tgl between '$tglAwal2' and '$tglAkhir2' ";
		$waktuL = "AND k.tgl between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	
	$tipe=$_REQUEST['tipe'];
	$kso = $_REQUEST['cmbKsoRep'];
	$qKso = "";
	if($kso==0){
		$fKso = "SEMUA";
	}else{
		$qKso = "SELECT $dbbilling.b_ms_kso.id, $dbbilling.b_ms_kso.nama FROM $dbbilling.b_ms_kso
WHERE $dbbilling.b_ms_kso.id = '".$kso."'";
		$sKso = mysql_query($qKso);
		$wKso = mysql_fetch_array($sKso);
		$fKso = $wKso['nama'];
		$qKso = " AND t.kso_id='".$kso."'";
	}
?>
<title>.: Rekap Penerimaan Billing :.</title>
<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
    <tr>
        <td><b>
          <?=$pemkabRS;?>
          <br />
          <?=$namaRS;?>
          <br />
          <?=$alamatRS;?>
          <br />
Telepon
<?=$tlpRS;?>
        </b></td>
    </tr>
    <tr>
        <td style="font-size:14px; height:70px; text-transform:uppercase; text-align:center; font-weight:bold;" valign="top">rekapitulasi penerimaan<?php if ($tipe!="all") echo " Billing";?><br />
        KSO : <?php echo $fKso?><br><?php echo $Periode;?></td>
    </tr>
	<tr>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr style="text-align:center; font-weight:bold">
				  	<td width="30" rowspan="2" style="border-top:1px solid #000000; border-right:1px solid #000000; border-left:1px solid #000000; border-bottom:1px solid #000000;">NO</td>
					<td width="250px" style="border-top:1px solid #000000; border-right:1px solid #000000; border-bottom:1px solid #000000;">URAIAN</td>
                	<?php 
					$sql="SELECT DISTINCT kso.id,kso.nama FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id 
INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id LEFT JOIN $dbbilling.b_ms_kso kso ON t.kso_id=kso.id 
WHERE $waktu $qKso ORDER BY kso.id";
					$rsKso=mysql_query($sql);
					$jmlKso=mysql_num_rows($rsKso);
					if ($jmlKso>1) $cspan='colspan="'.$jmlKso.'"';
					?>
					<td <?php echo $cspan; ?> style="border-top:1px solid #000000; border-right:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;JENIS PASIEN&nbsp;</td>
					<td width="120" rowspan="3" style="border-top:1px solid #000000; border-right:1px solid #000000; border-bottom:1px solid #000000;">TOTAL</td>
				</tr>
				<tr style="text-align:center; font-weight:bold">
				  	<td style="border-bottom:1px solid; border-right:1px solid;">PENERIMAAN</td>
                    <?php 
					$arIdxKso=array();
					$arJmlPerKso=array();
					$GrandTotPerKso=array();
					$idxKso=0;
					while ($rwKso=mysql_fetch_array($rsKso)){
						$idxKso++;
						$arIdxKso[$idxKso]=$rwKso["id"];
						$arJmlPerKso[$idxKso]=0;
						$GrandTotPerKso[$idxKso]=0;
					?>
					<td rowspan="2" width="100" style="border-bottom:1px solid #000000; border-right:1px solid;"><?php echo $rwKso["nama"]; ?></td>
                    <?php 
					}
					?>
				</tr>
				<tr style="text-align:center; font-weight:bold">
				  	<td style="border-bottom:1px solid #000000; border-right:1px solid #000000; border-left:1px solid #000000;">1</td>
					<td style="border-bottom:1px solid #000000; border-right:1px solid #000000;">2</td>
				</tr>
                <?php 
				$sql="SELECT * FROM $dbbilling.b_ms_unit mu WHERE mu.level=1 AND mu.kategori=2";
				$rsJPel=mysql_query($sql);
				$GrandTot=0;
				while($rwJPel=mysql_fetch_array($rsJPel)){
				?>
				<tr>
				 	<td colspan="2" bgcolor="#FF7777" style="border-left:1px solid #000000; border-right:1px solid #000000; padding-left:50px; font-weight:bold; text-decoration:underline;">&nbsp;<?php echo $rwJPel["nama"]; ?></td>
                    <?php 
					for ($i=1;$i<=count($arIdxKso);$i++){
						$arJmlPerKso[$i]=0;
					?>
					<td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
                    <?php 
					}
					?>
					<td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				</tr>
                <?php 
				$sql="SELECT * FROM $dbbilling.b_ms_unit mu WHERE mu.parent_id='".$rwJPel["id"]."' AND mu.aktif=1 ORDER BY mu.nama";
				$rsUnit=mysql_query($sql);
				$j=0;
				$TotPerJPel=0;
				while($rwUnit=mysql_fetch_array($rsUnit)){
					$j++;
				?>
				<tr>
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000;; text-align:center"><?php echo $j; ?></td>
					<td style="border-right:1px solid #000000; text-transform:uppercase">&nbsp;<?php echo $rwUnit["nama"]; ?></td>
                    <?php 
					$TotPerUnit=0;
					for ($i=1;$i<=count($arIdxKso);$i++){
						$sql="SELECT IFNULL(SUM(bt.nilai),0) AS jml FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id 
INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
WHERE $waktu AND t.kso_id='".$arIdxKso[$i]."' AND bt.tipe=0 AND p.unit_id='".$rwUnit["id"]."'";
						$rsByr=mysql_query($sql);
						$rwByr=mysql_fetch_array($rsByr);
						$jmlPen=$rwByr["jml"];
						
						if ($rwUnit["inap"]==1){
							$sql="SELECT IFNULL(SUM(bt.nilai),0) AS jml FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id 
INNER JOIN $dbbilling.b_tindakan_kamar t ON bt.tindakan_id=t.id INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
WHERE $waktu AND bt.tipe=1 AND p.kso_id='".$arIdxKso[$i]."' AND p.unit_id='".$rwUnit["id"]."'";
							$rsKmr=mysql_query($sql);
							$rwKmr=mysql_fetch_array($rsKmr);
							$jmlPen+=$rwKmr["jml"];
						}
						$TotPerUnit+=$jmlPen;
						$arJmlPerKso[$i]+=$jmlPen;
					?>
					<td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($jmlPen,0,",","."); ?>&nbsp;</td>
                    <?php 
					}
					?>
					<td style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($TotPerUnit,0,",","."); ?>&nbsp;</td>
				</tr>
                <?php 
					$TotPerJPel+=$TotPerUnit;
				}
				?>
				<tr style="font-weight:bold;">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;JUMLAH</td>
                    <?php 
					for ($i=1;$i<=count($arIdxKso);$i++){
					?>
					<td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($arJmlPerKso[$i],0,",","."); ?>&nbsp;</td>
                    <?php 
						$GrandTotPerKso[$i]+=$arJmlPerKso[$i];
					}
					?>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($TotPerJPel,0,",","."); ?>&nbsp;</td>
				</tr>
                <?php 
					$GrandTot+=$TotPerJPel;
				}
				?>
				<tr>
				 	<td colspan="2" bgcolor="#FF7777" style="border-left:1px solid #000000; border-right:1px solid #000000; padding-left:50px; font-weight:bold; text-decoration:underline;">&nbsp;PENUNJANG LAINNYA</td>
                    <?php 
					for ($i=1;$i<=count($arIdxKso);$i++){
						$arJmlPerKso[$i]=0;
					?>
					<td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
                    <?php 
					}
					?>
					<td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				</tr>
                <?php 
				$sql="SELECT * FROM k_ms_transaksi WHERE tipe=1 AND jenisLay=1";
				$rsLain2=mysql_query($sql);
				$j=0;
				$TotPerJPel=0;
				while ($rwLain2=mysql_fetch_array($rsLain2)){
					$j++;
				?>
				<tr>
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000;; text-align:center"><?php echo $j; ?></td>
					<td style="border-right:1px solid #000000; text-transform:uppercase">&nbsp;<?php echo $rwLain2["nama"]; ?></td>
                    <?php 
					$TotPerUnit=0;
					for ($i=1;$i<=count($arIdxKso);$i++){
						if ($arIdxKso[$i]==1){
							$sql="SELECT IFNULL(SUM(k.nilai),0) AS nilai FROM k_transaksi k WHERE k.id_trans='".$rwLain2["id"]."' $waktuL";
							$rsnLain2=mysql_query($sql);
							$rwnLain2=mysql_fetch_array($rsnLain2);
							$nLain2=$rwnLain2["nilai"];
						}else{
							$nLain2=0;
						}
						$TotPerUnit+=$nLain2;
						$arJmlPerKso[$i]+=$nLain2;
					?>
					<td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($nLain2,0,",","."); ?>&nbsp;</td>
                    <?php 
					}
					?>
					<td style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($TotPerUnit,0,",","."); ?>&nbsp;</td>
				</tr>
                <?php 
					$TotPerJPel+=$TotPerUnit;
				}
				?>
				<tr style="font-weight:bold;">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;JUMLAH</td>
                    <?php 
					for ($i=1;$i<=count($arIdxKso);$i++){
					?>
					<td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($arJmlPerKso[$i],0,",","."); ?>&nbsp;</td>
                    <?php 
						$GrandTotPerKso[$i]+=$arJmlPerKso[$i];
					}
					?>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($TotPerJPel,0,",","."); ?>&nbsp;</td>
				</tr>
                <?php 
				$GrandTot+=$TotPerJPel;
				?>
				<tr>
				 	<td colspan="2" style="border-left:1px solid #000000; border-right:1px solid #000000; padding-left:50px; font-weight:bold; text-decoration:underline;">&nbsp;</td>
                    <?php 
					for ($i=1;$i<=count($arIdxKso);$i++){
						$arJmlPerKso[$i]=0;
					?>
					<td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
                    <?php 
					}
					?>
					<td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				</tr>
				<tr style="font-weight:bold;">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;GRAND TOTAL</td>
                    <?php 
					for ($i=1;$i<=count($arIdxKso);$i++){
					?>
					<td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTotPerKso[$i],0,",","."); ?>&nbsp;</td>
                    <?php 
					}
					?>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot,0,",","."); ?>&nbsp;</td>
				</tr>
              <?php 
			  if ($tipe=="all"){
			  ?>
				<tr>
				 	<td colspan="2" bgcolor="#FF7777" style="border-left:1px solid #000000; border-right:1px solid #000000; padding-left:50px; font-weight:bold; text-decoration:underline;">&nbsp;PENERIMAAN LAIN-LAIN</td>
                    <?php 
					for ($i=1;$i<=count($arIdxKso);$i++){
						$arJmlPerKso[$i]=0;
					?>
					<td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
                    <?php 
					}
					?>
					<td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				</tr>
                <?php 
				$sql="SELECT * FROM k_ms_transaksi WHERE tipe=1 AND jenisLay<>1 AND aktif=1";
				$rsLain2=mysql_query($sql);
				$j=0;
				$TotPerJPel=0;
				while ($rwLain2=mysql_fetch_array($rsLain2)){
					$j++;
				?>
				<tr>
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000;; text-align:center"><?php echo $j; ?></td>
					<td style="border-right:1px solid #000000; text-transform:uppercase">&nbsp;<?php echo $rwLain2["nama"]; ?></td>
                    <?php 
					$TotPerUnit=0;
					for ($i=1;$i<=count($arIdxKso);$i++){
						if ($i==1){
							$sql="SELECT IFNULL(SUM(k.nilai),0) AS nilai FROM k_transaksi k WHERE k.id_trans='".$rwLain2["id"]."' $waktuL";
							$rsnLain2=mysql_query($sql);
							$rwnLain2=mysql_fetch_array($rsnLain2);
							$nLain2=$rwnLain2["nilai"];
						}else{
							$nLain2=0;
						}
						$TotPerUnit+=$nLain2;
						$arJmlPerKso[$i]+=$nLain2;
					?>
					<td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($nLain2,0,",","."); ?>&nbsp;</td>
                    <?php 
					}
					?>
					<td style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($TotPerUnit,0,",","."); ?>&nbsp;</td>
				</tr>
                <?php 
					$TotPerJPel+=$TotPerUnit;
				}
				?>
				<tr style="font-weight:bold;">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;JUMLAH</td>
                    <?php 
					for ($i=1;$i<=count($arIdxKso);$i++){
					?>
					<td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($arJmlPerKso[$i],0,",","."); ?>&nbsp;</td>
                    <?php 
						$GrandTotPerKso[$i]+=$arJmlPerKso[$i];
					}
					?>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($TotPerJPel,0,",","."); ?>&nbsp;</td>
				</tr>
                <?php 
				$GrandTot+=$TotPerJPel;
				?>
				<tr style="font-weight:bold;">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;TOTAL</td>
                    <?php 
					for ($i=1;$i<=count($arIdxKso);$i++){
					?>
					<td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTotPerKso[$i],0,",","."); ?>&nbsp;</td>
                    <?php 
					}
					?>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot,0,",","."); ?>&nbsp;</td>
				</tr>
              <?php 
			  }
			  ?>
			</table>
	  </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
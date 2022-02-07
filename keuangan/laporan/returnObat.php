<?php
	include("../sesi.php");
	$excell = $_REQUEST['excell'];
	if ($excell=="1"){
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Lap Pengajuan Klaim.xls"');		
	}
	
    include("../koneksi/konek.php");
    
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
	//echo $_REQUEST['tglAwal2']."<br>";
	$cwaktu=$waktu;
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = "DATE(tgl_retur)='$tglAwal2' ";
		$waktu2 = "keuangan.k_transaksi.tgl = '$tglAwal2' ";
		$waktuL = "AND k_transaksi.tgl = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
		$cbln = ($bln<10)?"0".$bln:$bln;
        $waktu = "month(tgl_retur) = '$bln' AND year(tgl_retur) = '$thn' ";
		$waktu2 = "month(keuangan.k_transaksi.tgl) = '$bln' AND year(keuangan.k_transaksi.tgl) = '$thn' ";
		$waktuL = "AND month(k_transaksi.tgl) = '$bln' AND year(k_transaksi.tgl) = '$thn' ";
        $Periode = "Bulan $arrBln[$cbln] Tahun $thn";
		$tglAkhir2="$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		$tglAwal2="$thn-$cbln-01";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $_REQUEST['tglAkhir'];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = "DATE(tgl_retur) between '$tglAwal2' and '$tglAkhir2' ";
		$waktu2 = "keuangan.k_transaksi.tgl between '$tglAwal2' and '$tglAkhir2' ";
		$waktuL = "AND k_transaksi.tgl between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	/*for($i = 2000; $i < 2009; $i++) {
		echo "$i: ", cal_days_in_month(CAL_GREGORIAN, 2, $i), "\n";
	}*/
	
	$kso = $_REQUEST['cmbKsoRep'];
	//echo "kso=".$kso."<br>";
	$qKso = "";
	if($kso==0){
		$fKso = "SEMUA";
		$qKso = "SELECT DISTINCT kso.id,kso.nama FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_ms_kso kso ON t.kso_id=kso.id WHERE $waktu ORDER BY kso.id";
		$sKso = mysql_query($qKso);
	}else{
		$qKso = "SELECT $dbbilling.b_ms_kso.id, $dbbilling.b_ms_kso.nama FROM $dbbilling.b_ms_kso
WHERE $dbbilling.b_ms_kso.id = '".$kso."'";
		$sKso = mysql_query($qKso);
	}
?>
<title>.: Rekap Pengembalian Return Obat :.</title>
<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
    <tr>
        <td><b><?=$pemkabRS;?><br /><?=$namaRS;?><br /><?=$alamatRS;?><br />Telepon <?=$tlpRS;?></b></td>
    </tr>
    <tr>
        <td style="font-size:14px; height:70px; text-transform:uppercase; text-align:center; font-weight:bold;" valign="top">rekapitulasi Return Obat<br /><?php echo $Periode;?></td>
    </tr>
	<tr>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				
				<tr style="text-align:center; font-weight:bold">
				  <td width="30" style="border-top:1px solid #000000; border-right:1px solid #000000; border-left:1px solid #000000; border-bottom:1px solid #000000;">NO</td>
				  	<td width="250" style="border-top:1px solid #000000; border-bottom:1px solid; border-right:1px solid;">UNIT PELAYANAN</td>
					<td width="100" style="border-top:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid;">NILAI RETURN</td>
				    <td width="100" style="border-top:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid;">NILAI HPP</td>
			    </tr>
				<tr style="text-align:center; font-weight:bold">
				  	<td style="border-bottom:1px solid #000000; border-right:1px solid #000000; border-left:1px solid #000000;">1</td>
					<td style="border-bottom:1px solid #000000; border-right:1px solid #000000;">2</td>
				    <td width="100" style="border-bottom:1px solid #000000; border-right:1px solid;">3</td>
				    <td width="100" style="border-bottom:1px solid #000000; border-right:1px solid;">4</td>
			    </tr>
                <?php 
				$GrandTot1=0;
				$GrandTot2=0;
				while ($wKso = mysql_fetch_array($sKso)){
				?>
				<tr bgcolor="#4F71F9">
				  <td colspan="2" style="border-left:1px solid #000000; border-right:1px solid #000000; font-weight:bold; text-decoration:underline;font-size:12px">&nbsp;&nbsp;<?php echo $wKso["nama"]; ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000;">&nbsp;</td>
				  <td style="border-right:1px solid #000000;">&nbsp;</td>
			    </tr>
					<?php 
                    $sql="SELECT * FROM $dbbilling.b_ms_unit mu WHERE mu.level=1 AND mu.kategori=2";
                    $rsJPel=mysql_query($sql);
					$SubTot1=0;
					$SubTot2=0;
                    while($rwJPel=mysql_fetch_array($rsJPel)){
                    ?>
				<tr>
				 	<td colspan="2" bgcolor="#FF7777" style="border-left:1px solid #000000; border-right:1px solid #000000; padding-left:50px; font-weight:bold; text-decoration:underline;">&nbsp;<?php echo $rwJPel["nama"]; ?></td>
					<td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
			    </tr>
						<?php 
                        $sql="SELECT * FROM $dbbilling.b_ms_unit mu WHERE mu.parent_id='".$rwJPel["id"]."' AND mu.aktif=1 ORDER BY mu.nama";
                        $rsUnit=mysql_query($sql);
                        $j=0;
                        $TotPerJPel1=0;
                        $TotPerJPel2=0;
                        while($rwUnit=mysql_fetch_array($rsUnit)){
                            $j++;
                            $sql="SELECT IFNULL(SUM(rp.nilai),0) AS nReturn,IFNULL(SUM(IF(ap.NILAI_PAJAK>0,rp.qty_retur*ap.HARGA_BELI_SATUAN * (1-(ap.DISKON/100)) * 1.1,rp.qty_retur*ap.HARGA_BELI_SATUAN * (1-(ap.DISKON/100)))),0) nHPP FROM (SELECT * FROM $dbapotek.a_return_penjualan WHERE $waktu) rp 
INNER JOIN $dbapotek.a_penjualan p ON rp.idpenjualan=p.ID INNER JOIN $dbapotek.a_unit u ON p.RUANGAN=u.UNIT_ID
INNER JOIN $dbapotek.a_penerimaan ap ON p.PENERIMAAN_ID=ap.ID
WHERE u.kdunitfar='".$rwUnit["kode"]."'";
							$rsReturn=mysql_query($sql);
							$rwReturn=mysql_fetch_array($rsReturn);
							$nReturn=$rwReturn["nReturn"];
							$nHPP=$rwReturn["nHPP"];
                            $TotPerJPel1+=$nReturn;
                            $TotPerJPel2+=$nHPP;
                        ?>
				<tr>
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000;; text-align:center"><?php echo $j; ?></td>
					<td style="border-right:1px solid #000000; text-transform:uppercase">&nbsp;<?php echo $rwUnit["nama"]; ?></td>
					<td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($nReturn,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($nHPP,0,",","."); ?>&nbsp;</td>
			    </tr>
						<?php 
                        }
                        ?>
				<tr style="font-weight:bold;">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;JUMLAH</td>
					<td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($TotPerJPel1,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($TotPerJPel2,0,",","."); ?>&nbsp;</td>
			    </tr>
					<?php 
                        $SubTot1+=$TotPerJPel1;
                        $SubTot2+=$TotPerJPel2;
                    }
                    ?>
				<tr style="font-weight:bold;">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;SUB TOTAL</td>
					<td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($SubTot1,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($SubTot2,0,",","."); ?>&nbsp;</td>
			    </tr>
				<?php 
					$GrandTot1+=$SubTot1;
					$GrandTot2+=$SubTot2;
                }
                ?>
				<tr style="font-weight:bold;">
                  <td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;GRAND TOTAL</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot1,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot2,0,",","."); ?>&nbsp;</td>
			  </tr>
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
<?php
	include("../sesi.php");
    include("../koneksi/konek.php");
    
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
	//echo $_REQUEST['tglAwal2']."<br>";
	$cwaktu=$waktu;
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = "p.TGL = '$tglAwal2' ";
		$waktu2 = " AND DATE(ar.tgl_retur)='$tglAwal2'";
		$waktuL = "AND k_transaksi.tgl = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
		$cbln = ($bln<10)?"0".$bln:$bln;;
        $thn = $_POST['cmbThn'];
        $waktu = "month(p.TGL) = '$bln' AND year(p.TGL) = '$thn' ";
		$waktu2 = " AND month(ar.tgl_retur) = '$bln' AND year(ar.tgl_retur) = '$thn' ";
		$waktuL = "AND month(k_transaksi.tgl) = '$bln' AND year(k_transaksi.tgl) = '$thn' ";
        $Periode = "Bulan $arrBln[$cbln] Tahun $thn";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $_REQUEST['tglAkhir'];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = "p.TGL between '$tglAwal2' and '$tglAkhir2' ";
		$waktu2 = " AND DATE(ar.tgl_retur) between '$tglAwal2' and '$tglAkhir2' ";
		$waktuL = "AND k_transaksi.tgl between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	
	$kso = $_REQUEST['cmbKsoRep'];
	$qKso = "";
	if($kso==0){
		$fKso = "SEMUA";
		$qKso = "SELECT DISTINCT m.IDMITRA id,mkso.nama FROM $dbapotek.a_penjualan p INNER JOIN $dbapotek.a_mitra m ON p.KSO_ID=m.IDMITRA
INNER JOIN $dbbilling.b_ms_kso mkso ON m.KODE_MITRA=mkso.kode WHERE $waktu";
		$sKso = mysql_query($qKso);
	}else{
		$qKso = "SELECT DISTINCT m.IDMITRA id,mkso.nama FROM $dbapotek.a_mitra m INNER JOIN $dbbilling.b_ms_kso mkso ON m.KODE_MITRA=mkso.kode WHERE mkso.id='".$kso."'";
		$sKso = mysql_query($qKso);
	}
?>
<title>.: Rekap Pendapatan Harian :.</title>
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
        <td style="font-size:14px; height:70px; text-transform:uppercase; text-align:center; font-weight:bold;" valign="top">rekapitulasi penDAPATan FARMASI<br /><?php echo $Periode;?></td>
    </tr>
	<tr>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				
				<tr style="text-align:center; font-weight:bold">
				  <td width="30" style="border-top:1px solid #000000; border-right:1px solid #000000; border-left:1px solid #000000; border-bottom:1px solid #000000;">NO</td>
				  	<td width="250" style="border-top:1px solid #000000; border-bottom:1px solid; border-right:1px solid;">UNIT PELAYANAN</td>
					<td width="100" style="border-top:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid;">NILAI JUAL</td>
				    <td width="100" style="border-top:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid;">NILAI BAHAN JUAL</td>
				    <td width="100" style="border-top:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid;">NILAI RETURN</td>
				    <td width="100" style="border-top:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid;">NILAI BAHAN RETURN</td>
				    <td width="100" style="border-top:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid;">SELISIH<br>JUAL - RETURN</td>
				    <td width="100" style="border-top:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid;">SELISIH<br>B JUAL - B RETURN</td>
				</tr>
				<tr style="text-align:center; font-weight:bold">
				  	<td style="border-bottom:1px solid #000000; border-right:1px solid #000000; border-left:1px solid #000000;">1</td>
					<td style="border-bottom:1px solid #000000; border-right:1px solid #000000;">2</td>
				    <td width="100" style="border-bottom:1px solid #000000; border-right:1px solid;">3</td>
				    <td width="100" style="border-bottom:1px solid #000000; border-right:1px solid;">4</td>
				    <td width="100" style="border-bottom:1px solid #000000; border-right:1px solid;">5</td>
				    <td width="100" style="border-bottom:1px solid #000000; border-right:1px solid;">6</td>
				    <td width="100" style="border-bottom:1px solid #000000; border-right:1px solid;">7</td>
				    <td width="100" style="border-bottom:1px solid #000000; border-right:1px solid;">&nbsp;</td>
				</tr>
                <?php 
				$GrandTot1=0;
				$GrandTot2=0;
				$GrandTot3=0;
				$GrandTot4=0;
				$GrandTot5=0;
				$GrandTot6=0;
				while ($wKso = mysql_fetch_array($sKso)){
					$qKso = " AND p.KSO_ID='".$wKso["id"]."'";
				?>
				<tr bgcolor="#4F71F9">
				  <td colspan="2" style="border-left:1px solid #000000; border-right:1px solid #000000; font-weight:bold; text-decoration:underline;font-size:12px">&nbsp;&nbsp;<?php echo $wKso["nama"]; ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000;">&nbsp;</td>
				  <td style="border-right:1px solid #000000;">&nbsp;</td>
				  <td style="border-right:1px solid #000000;">&nbsp;</td>
				  <td style="border-right:1px solid #000000;">&nbsp;</td>
				  <td style="border-right:1px solid #000000;">&nbsp;</td>
			      <td style="border-right:1px solid #000000;">&nbsp;</td>
				</tr>
					<?php 
                    $sql="SELECT * FROM $dbbilling.b_ms_unit mu WHERE mu.level=1 AND mu.kategori=2";
                    $rsJPel=mysql_query($sql);
					$SubTot1=0;
					$SubTot2=0;
					$SubTot3=0;
					$SubTot4=0;
					$SubTot5=0;
					$SubTot6=0;
                    while($rwJPel=mysql_fetch_array($rsJPel)){
                    ?>
				<tr>
				 	<td colspan="2" bgcolor="#FF7777" style="border-left:1px solid #000000; border-right:1px solid #000000; padding-left:50px; font-weight:bold; text-decoration:underline;">&nbsp;<?php echo $rwJPel["nama"]; ?></td>
					<td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				</tr>
						<?php 
                        $sql="SELECT * FROM $dbbilling.b_ms_unit mu WHERE mu.parent_id='".$rwJPel["id"]."' AND mu.aktif=1 ORDER BY mu.nama";
                        $rsUnit=mysql_query($sql);
                        $j=0;
                        $TotPerJPel1=0;
                        $TotPerJPel2=0;
                        $TotPerJPel3=0;
                        $TotPerJPel4=0;
                        $TotPerJPel5=0;
                        $TotPerJPel6=0;
                        while($rwUnit=mysql_fetch_array($rsUnit)){
                            $j++;
							$sqlJual="SELECT SUM(p.SUB_TOTAL) AS nJual,SUM(p.QTY_JUAL * IF(ap.NILAI_PAJAK=0,(ap.HARGA_BELI_SATUAN * (1-(ap.DISKON/100))),1.1 * (ap.HARGA_BELI_SATUAN * (1-(ap.DISKON/100))))) nBahan FROM $dbapotek.a_penjualan p INNER JOIN $dbapotek.a_unit u ON p.RUANGAN=u.UNIT_ID INNER JOIN $dbapotek.a_penerimaan ap ON p.PENERIMAAN_ID=ap.ID WHERE u.kdunitfar='".$rwUnit["kode"]."' $qKso AND $waktu";
							$rsJual=mysql_query($sqlJual);
							$rwJual=mysql_fetch_array($rsJual);
							$nJual=$rwJual["nJual"];
							$bJual=$rwJual["nBahan"];

							$sqlReturn="SELECT IFNULL(SUM(ar.qty_retur * ar.nilai),0) AS nReturn,IFNULL(SUM(ar.qty_retur * IF(ap.NILAI_PAJAK=0,(ap.HARGA_BELI_SATUAN * (1-(ap.DISKON/100))),1.1 * (ap.HARGA_BELI_SATUAN * (1-(ap.DISKON/100))))),0) nBahan 
FROM $dbapotek.a_penjualan p INNER JOIN $dbapotek.a_unit u ON p.RUANGAN=u.UNIT_ID 
INNER JOIN $dbapotek.a_penerimaan ap ON p.PENERIMAAN_ID=ap.ID INNER JOIN $dbapotek.a_return_penjualan ar ON p.ID=ar.idpenjualan
WHERE u.kdunitfar='".$rwUnit["kode"]."' $qKso $waktu2";
							$rsReturn=mysql_query($sqlReturn);
							$rwReturn=mysql_fetch_array($rsReturn);
							$nReturn=$rwReturn["nReturn"];
							$bReturn=$rwReturn["nBahan"];

                            $selisihN=$nJual-$nReturn;
                            $selisihB=$bJual-$bReturn;
                            $TotPerJPel1+=$nJual;
                            $TotPerJPel2+=$bJual;
                            $TotPerJPel3+=$nReturn;
                            $TotPerJPel4+=$bReturn;
                            $TotPerJPel5+=$selisihN;
                            $TotPerJPel6+=$selisihB;
                        ?>
				<tr>
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000;; text-align:center"><?php echo $j; ?></td>
					<td style="border-right:1px solid #000000; text-transform:uppercase">&nbsp;<?php echo $rwUnit["nama"]; ?></td>
					<td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($nJual,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($bJual,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($nReturn,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($bReturn,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($selisihN,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($selisihB,0,",","."); ?>&nbsp;</td>
				</tr>
						<?php 
                        }
                        ?>
				<tr style="font-weight:bold;">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;JUMLAH</td>
					<td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($TotPerJPel1,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($TotPerJPel2,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($TotPerJPel3,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($TotPerJPel4,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($TotPerJPel5,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($TotPerJPel6,0,",","."); ?>&nbsp;</td>
				</tr>
					<?php 
                        $SubTot1+=$TotPerJPel1;
                        $SubTot2+=$TotPerJPel2;
                        $SubTot3+=$TotPerJPel3;
                        $SubTot4+=$TotPerJPel4;
                        $SubTot5+=$TotPerJPel5;
                        $SubTot6+=$TotPerJPel6;
                    }
                    ?>
				<tr style="font-weight:bold;">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;SUB TOTAL</td>
					<td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($SubTot1,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($SubTot2,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($SubTot3,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($SubTot4,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($SubTot5,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($SubTot6,0,",","."); ?>&nbsp;</td>
				</tr>
				<?php 
					$GrandTot1+=$SubTot1;
					$GrandTot2+=$SubTot2;
					$GrandTot3+=$SubTot3;
					$GrandTot4+=$SubTot4;
					$GrandTot5+=$SubTot5;
					$GrandTot6+=$SubTot6;
                }
                ?>
				<tr style="font-weight:bold;">
                  <td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;GRAND TOTAL</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot1,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot2,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot3,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot4,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot5,0,",","."); ?>&nbsp;</td>
			      <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot6,0,",","."); ?>&nbsp;</td>
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
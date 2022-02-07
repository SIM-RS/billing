<?php
	include("../sesi.php");
    include("../koneksi/konek.php");
    
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = "k_transaksi.tgl = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
		
		$tgl1=GregorianToJD($tglAwal[1],$tglAwal[0],$tglAwal[2]);
		$tgl2=GregorianToJD($tglAwal[1],$tglAwal[0],$tglAwal[2]);
		$selisih=$tgl2-$tgl1;
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
        $waktu = "month(k_transaksi.tgl) = '$bln' AND year(k_transaksi.tgl) = '$thn' ";
        $Periode = "Bulan $arrBln[$bln] Tahun $thn";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $arrBln[$tglAwal[1]];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = "k_transaksi.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$tgl1=GregorianToJD($tglAwal[1],$tglAwal[0],$tglAwal[2]);
		$tgl2=GregorianToJD($tglAkhir[1],$tglAkhir[0],$tglAkhir[2]);
		$selisih=$tgl2-$tgl1;
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
?>
<title>Rekapitulasi Pendapatan</title>
<table id="tbl1" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
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
        <td style="font-size:14px; height:70px; text-transform:uppercase; text-align:center; font-weight:bold;" valign="top">rekapitulasi pendapatan<br><?php echo $Periode;?></td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                <tr style="font-weight:bold">
					<td width="100">&nbsp;</td>
					<td colspan="2">PENDAPATAN/TANGGAL</td>
				</tr>
                <tr style="font-weight:bold">
					<td width="100" style="border-bottom:1px solid">&nbsp;JENIS TRANSAKSI</td>
					<?php
						/*$bln=$tglAwal[1];
						$th=$tglAwal[2];
						for($i=$tglAwal[0];$i<=($tglAwal[0]+$selisih);$i++)
						{ 
							if($th%4==0 and $th%100!=0)
								$arrHari=array('01'=>'31','02'=>'29','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31');
							else
								$arrHari=array('01'=>'31','02'=>'28','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31');
							if($i==$tglAwal[0])
								$hari=$i;
							else
								$hari=$hari+1;		
							if($hari>$arrHari[$bln])
							{
								$hari=$hari-$arrHari[$bln];
								$bln=$bln+1;
							}
							if($bln>12)
							{
								$bln=$bln-12;
								$th=$th+1;
							}*/
					   $sql = "SELECT tgl,date_format(tgl,'%d/%m') as f_tgl
							 FROM k_transaksi INNER JOIN k_ms_transaksi ON k_transaksi.id_trans = k_ms_transaksi.id 
							 WHERE $waktu AND k_ms_transaksi.tipe = '1' group by tgl";
					   $rs = mysql_query($sql);
						while($row=mysql_fetch_array($rs)){
					?>
					<td width="60" align="right" style="border-bottom:1px solid; border-left:1px solid; border-top:1px solid"><b><?php echo $row['f_tgl'];?></b>&nbsp;</td>
					<?php 
						}
					?>
					<td width="70" style="text-align:right; border-bottom:1px solid; border-left:1px solid; border-right:1px solid; border-top:1px solid;">TOTAL&nbsp;</td>
				</tr>
				<?php
						$qPend = "SELECT k_ms_transaksi.id, k_ms_transaksi.nama
							 FROM k_transaksi INNER JOIN k_ms_transaksi ON k_transaksi.id_trans = k_ms_transaksi.id 
							 WHERE $waktu AND k_ms_transaksi.tipe = '1'";
						$rsPend = mysql_query($qPend);
						while($rwPend = mysql_fetch_array($rsPend))
						{
				?>
                <tr>
					<td width="100" style="border-left:1px solid; border-bottom:1px solid;">&nbsp;<?php echo $rwPend['nama'];?></td>
					<?php
							/*$bln=$tglAwal[1];
							$th=$tglAwal[2];
							$tot = 0;
							for($i=$tglAwal[0];$i<=($tglAwal[0]+$selisih);$i++)
							{ 
								if($th%4==0 and $th%100!=0)
									$arrHari=array('01'=>'31','02'=>'29','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31');
								else
									$arrHari=array('01'=>'31','02'=>'28','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31');
								if($i==$tglAwal[0])
									$hari=$i;
								else
									$hari=$hari+1;		
								if($hari>$arrHari[$bln])
								{
									$hari=$hari-$arrHari[$bln];
									$bln=$bln+1;
								}
								if($bln>12)
								{
									$bln=$bln-12;
									$th=$th+1;
								}*/
							$sql = "SELECT tgl,date_format(tgl,'%d/%m') as f_tgl
							 FROM k_transaksi INNER JOIN k_ms_transaksi ON k_transaksi.id_trans = k_ms_transaksi.id 
							 WHERE $waktu AND k_ms_transaksi.tipe = '1' group by tgl";
					   $rs = mysql_query($sql);
					   $colspan = 0;
							 while($row=mysql_fetch_array($rs)){
								$qNilai= "SELECT if(nilai is null,0,nilai) nilai
								FROM k_transaksi
								WHERE id_trans=".$rwPend['id']." AND tgl = '".$row['tgl']."'";
								//tgl=CONCAT_WS('-','$th','$bln','$hari')
								$rsNilai = mysql_query($qNilai);
								$rwNilai = mysql_fetch_array($rsNilai);
					?>
					<td width="60" align="right" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rwNilai['nilai']=='') echo 0; else echo number_format($rwNilai['nilai'],0,",",".")?>&nbsp;</td>
					<?php 
							$tot=$tot+$rwNilai['nilai'];
							$colspan++;
								}
						?>	
					<td width="70" align="right" style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid;"><?php echo number_format($tot,0,",",".")?>&nbsp;</td>
				</tr>
				<?php
                    $totAll += $tot;
						}
				?>
                <tr>
					<td width="100">&nbsp;</td>
					<td colspan="<?php echo $colspan; ?>" align="right">Total</td>
					<td width="70" align="right"><?php echo number_format($totAll,0,",",".");?></td>
				</tr>
        </table></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
<script>
    document.getElementById('tbl1').width = "<?php echo (100+70+$colspan*60)>400?(100+70+$colspan*60):400; ?>px";
</script>
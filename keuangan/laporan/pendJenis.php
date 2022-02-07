<?php
	include("../sesi.php");
    include("../koneksi/konek.php");
    
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = "AND k_transaksi.tgl = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
        $waktu = "AND month(k_transaksi.tgl) = '$bln' AND year(k_transaksi.tgl) = '$thn' ";
        $Periode = "Bulan $arrBln[$bln] Tahun $thn";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $arrBln[$tglAwal[1]];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = "AND k_transaksi.tgl between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	
	$jnsTransaksi = $_REQUEST['cmbJnsPend'];
	$qJns = "SELECT id, nama FROM k_ms_transaksi WHERE id = '".$jnsTransaksi."'";
	$rsJns = mysql_query($qJns);
	$rwJns = mysql_fetch_array($rsJns);
?>
<title>.: Laporan Pendapatan :.</title>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
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
        <td style="font-size:14px; height:70px; text-transform:uppercase; text-align:center; font-weight:bold;" valign="top">laporan pendapatan transaksi <?php echo $rwJns['nama'];?><br><?php echo $Periode;?></td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                <tr height="30">
                    <td width="5%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center;">NO</td>   
                    <td width="10%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center;">TANGGAL</td>  
                    <td width="10%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center;">NO. BUKTI</td>  
                    <td width="35%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold;">JENIS TRANSAKSI</td>  
                    <td width="10%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:right; padding-right:10px;">NILAI</td>  
                    <td width="30%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; padding-left:10px;">KETERANGAN</td>  
                </tr>
                <?php
                        $sql = "SELECT DATE_FORMAT(k_transaksi.tgl,'%d-%m-%Y') AS tgl,
                                k_transaksi.no_bukti, k_ms_transaksi.nama, k_transaksi.nilai, k_transaksi.ket
                                FROM k_transaksi 
                                INNER JOIN k_ms_transaksi ON k_transaksi.id_trans = k_ms_transaksi.id
                                WHERE k_ms_transaksi.id = '".$jnsTransaksi."' $waktu";
                        $rs = mysql_query($sql);
                        $no = 1;
						$tot = 0;
                        while($rw = mysql_fetch_array($rs))
                        {
                ?>
                <tr>
                    <td align="center"><?php echo $no;?></td>
                    <td align="center">&nbsp;<?php echo $rw['tgl'];?></td>
                    <td align="center">&nbsp;<?php echo $rw['no_bukti'];?></td>
                    <td>&nbsp;<?php echo $rw['nama'];?></td>
                    <td align="right" style="padding-right:10px;"><?php echo number_format($rw['nilai'],0,",",".");?></td>
                    <td style="padding-left:10px; text-transform:capitalize"><?php echo $rw['ket'];?></td>
                </tr>
                <?php
                        $no++;
						$tot = $tot + $rw['nilai'];
                        }
                ?>
                <tr style="font-weight:bold" height="30">
                    <td colspan="4" align="right" style="border-bottom:1px solid; border-top:1px solid;">Total&nbsp;</td>
                    <td align="right" style="padding-right:10px; border-bottom:1px solid; border-top:1px solid;"><?php echo number_format($tot,0,",",".");?></td>
                    <td style="border-bottom:1px solid; border-top:1px solid;">&nbsp;</td>
                </tr>
        </table></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
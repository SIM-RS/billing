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
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
?>
<title>Rekapitulasi Pendapatan Harian</title>
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
        <td style="font-size:14px; height:70px; text-transform:uppercase; text-align:center; font-weight:bold;" valign="top">rekapitulasi pendapatan bulanan<br><?php echo $Periode;?></td>
    </tr>
    <tr>
        <td>
            <table width="80%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;" align="center">
                <tr style="font-weight:bold">
					<td width="100">&nbsp;</td>
					<td>PENDAPATAN/TANGGAL</td>
				</tr>
                <tr style="font-weight:bold">
					<td width="60%" style="border-bottom:1px solid;">&nbsp;JENIS TRANSAKSI</td>
					<td width="40%" align="right" style="border-bottom:1px solid; border-left:1px solid; border-top:1px solid; border-right:1px solid;">NILAI&nbsp;</td>
				</tr>
				<?php
						$qPend = "SELECT k_ms_transaksi.id, k_ms_transaksi.nama, k_transaksi.nilai FROM k_transaksi INNER JOIN k_ms_transaksi ON k_transaksi.id_trans = k_ms_transaksi.id WHERE $waktu AND k_ms_transaksi.tipe = '1'";
						$rsPend = mysql_query($qPend);
						$tot = 0;
						while($rwPend = mysql_fetch_array($rsPend))
						{
				?>
                <tr>
					<td style="border-left:1px solid; border-bottom:1px solid;">&nbsp;<?php echo $rwPend['nama'];?></td>
					<td align="right" style="border-left:1px solid; border-bottom:1px solid;"><?php echo number_format($rwPend['nilai'],0,",",".")?>&nbsp;</td>
				</tr>
				<?php
						$tot = $tot + $rwPend['nilai'];
						}
				?>
                <tr>
					<td style="border-left:1px solid; border-bottom:1px solid; border-right:1px solid; font-weight:bold; text-align:right" height="28">TOTAL&nbsp;</td>
					<td style="border-bottom:1px solid; border-right:1px solid; text-align:right"><?php echo number_format($tot,0,",",".")?>&nbsp;</td>
				</tr>
        </table></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
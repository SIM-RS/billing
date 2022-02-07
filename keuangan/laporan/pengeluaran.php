<?php
	include("../sesi.php");
	$excell = $_REQUEST['excell'];
	if ($excell=="1"){
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Lap Pengajuan Klaim.xls"');		
	}
	
    include("../koneksi/konek.php");
    
    $arrBln = array('1'=>'Januari','2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$arrBln2 = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = "AND t.tgl = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln2[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
        $waktu = "AND month(t.tgl) = '$bln' AND year(t.tgl) = '$thn' ";
        $Periode = "Bulan $arrBln[$bln] Tahun $thn";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $arrBln[$tglAwal[1]];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = "AND t.tgl between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln2[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln2[$tglAkhir[1]]." ".$tglAkhir[2];
    }
?>
<title>.: Laporan Pengeluaran :.</title>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
    <tr>
        <td><b><?=$pemkabRS;?><br><?=$namaRS;?><br><?=$alamatRS;?><br>Telepon <?=$tlpRS;?></b></td>
    </tr>
    <tr>
        <td style="font-size:14px; height:70px; text-transform:uppercase; text-align:center; font-weight:bold;" valign="top">laporan pengeluaran<br><?php echo $Periode;?></td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                <tr height="30">
                    <td width="5%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center;">NO</td>   
                    <td width="10%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center;">TANGGAL</td>  
                    <td width="10%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center;">NO. BUKTI</td>  
                    <td style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center;">JENIS TRANSAKSI</td>
                    <td width="25%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center;">MATA ANGGARAN</td>  
                    <td width="10%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:right; padding-right:10px; text-align:center;">NILAI</td>  
                    <td width="20%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; padding-left:10px; text-align:center;">KETERANGAN</td>
                    <td width="10%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; padding-left:10px; text-align:center;">VERIFIKASI</td>  
                </tr>
                <?php
				$jns = '';
				if($_POST['cmbJnsPend'] != 0){
				    $jns = " and k_ms_transaksi.id = '".$_POST['cmbJnsPend']."'";
				}
				/*
                        $sql = "SELECT DATE_FORMAT(t.tgl,'%d-%m-%Y') AS tgl,
                                t.no_bukti,
								jt.JTRANS_NAMA AS nama ,
								ma.ma_nama, 
								t.nilai, 
								IF(
								  (
									t.no_faktur = '' 
									OR t.no_faktur IS NULL
								  ),
								  t.ket,
								  CONCAT(t.ket, ' (', t.no_faktur, ')')
								) ket,
                                FROM k_transaksi t
                                LEFT JOIN ".$dbanggaran.".ms_ma ma 
								  ON t.id_ma_dpa = ma.ma_id 
								LEFT JOIN ".$dbakuntansi.".ak_ms_unit uj 
								  ON t.jenis_layanan = uj.id 
								LEFT JOIN ".$dbakuntansi.".ak_ms_unit ut 
								  ON t.unit_id = ut.id 
								LEFT JOIN ".$dbakuntansi.".jenis_transaksi jt 
								  ON jt.JTRANS_ID = t.id_trans
                                WHERE k_ms_transaksi.tipe = '2' $waktu $jns";
						*/
								
						$sql = "SELECT 
								  DATE_FORMAT(t.tgl, '%d-%m-%Y') AS tgl,
								  t.no_bukti,
								  jt.JTRANS_NAMA AS nama,
								  ma.ma_nama,
								  t.nilai,
								  IF(
									(
									  t.no_faktur = '' 
									  OR t.no_faktur IS NULL
									),
									t.ket,
									CONCAT(t.ket, ' (', t.no_faktur, ')')
								  ) ket,
								  IF(
									jenis_supplier = '1',
									'(Supplier Obat)',
									IF(
									  jenis_supplier = '2',
									  '(Supplier Barang)',
									  ''
									)
								  ) AS nama_jenis_supplier,
								  IF(t.verifikasi = 1, 'Sudah', 'Belum') verifikasi
								FROM
								  k_transaksi t 
								  LEFT JOIN ".$dbanggaran.".ms_ma ma 
									ON t.id_ma_dpa = ma.ma_id 
								  LEFT JOIN ".$dbakuntansi.".ak_ms_unit uj 
									ON t.jenis_layanan = uj.id 
								  LEFT JOIN ".$dbakuntansi.".ak_ms_unit ut 
									ON t.unit_id = ut.id 
								  LEFT JOIN ".$dbakuntansi.".jenis_transaksi jt 
									ON jt.JTRANS_ID = t.id_trans 
								WHERE t.tipe_trans = '2' AND t.flag = '$flag'
								  $waktu";
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
                    <td>&nbsp;<?php echo $rw['ma_nama'].$rw['nama_jenis_supplier'];?></td>
                    <td align="right" style="padding-right:10px;"><?php echo number_format($rw['nilai'],0,",",".");?></td>
                    <td style="padding-left:10px; text-transform:capitalize"><?php echo $rw['ket'];?></td>
                    <td style="padding-left:10px; text-transform:capitalize"><?php echo $rw['verifikasi'];?></td>
                </tr>
                <?php
                        $no++;
						$tot = $tot + $rw['nilai'];
                        }
                ?>
                <tr style="font-weight:bold" height="30">
                    <td colspan="5" align="right" style="border-bottom:1px solid; border-top:1px solid;">Total&nbsp;</td>
                    <td align="right" style="padding-right:10px; border-bottom:1px solid; border-top:1px solid;"><?php echo number_format($tot,0,",",".");?></td>
                    <td style="border-bottom:1px solid; border-top:1px solid;">&nbsp;</td>
                    <td style="border-bottom:1px solid; border-top:1px solid;">&nbsp;</td>
                </tr>
        </table></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
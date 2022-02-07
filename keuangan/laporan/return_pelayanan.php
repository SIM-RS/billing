<?php
	include("../sesi.php");
	$excell = $_REQUEST['excell'];
	if ($excell=="1"){
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Lap Pengajuan Klaim.xls"');		
	}
	
    include("../koneksi/konek.php");
    
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$arrBln2 = array('1'=>'Januari','2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = "AND r.tgl_return = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
        $waktu = "AND month(r.tgl_return) = '$bln' AND year(r.tgl_return) = '$thn' ";
        $Periode = "Bulan $arrBln2[$bln] Tahun $thn";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = "AND r.tgl_return between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }

?>
<title>.: Laporan Return Pelayanan :.</title>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
    <tr>
        <td><b><?=$pemkabRS;?><br><?=$namaRS;?><br><?=$alamatRS;?><br>Telepon <?=$tlpRS;?></b></td>
    </tr>
    <tr>
        <td style="font-size:14px; height:70px; text-transform:uppercase; text-align:center; font-weight:bold;" valign="top">laporan return Pelayanan<br><?php echo $Periode;?></td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                <tr height="30">
                    <td width="2%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center;">NO</td>   
                    <td width="8%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center;">TANGGAL</td>  
                    <td width="16%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center;">NO. RETURN</td>  
                    <td width="9%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center">NO RM</td>  
                    <td width="16%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:right; padding-right:10px; text-align:center">NAMA PASIEN</td>  
                    <td width="13%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; padding-left:0px; text-align:center">UNIT</td>
                    <td width="9%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; padding-left:00px; text-align:center">KSO</td>
                    <td width="18%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; padding-left:00px; text-align:center">TINDAKAN</td>
                    <td width="9%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; padding-left:00px; text-align:center">BIAYA</td>  
                </tr>
                <?php
				
				if($_REQUEST['cmbKsoRep']=='0'){
					$fKso = "";
				}
				else{
					$fKso = " AND kso.id=".$_REQUEST['cmbKsoRep'];
				}
				$sql="SELECT * FROM (SELECT 
					  DATE_FORMAT(r.tgl_return, '%d/%m/%Y') AS tgl,
					  r.no_return,
					  ps.no_rm,
					  ps.nama,
					  u.nama AS unit,
					  kso.nama AS kso,
					  mt.nama AS tindakan,
					  bt.nilai AS biaya 
					FROM
					  $dbbilling.b_return r 
					  INNER JOIN $dbbilling.b_bayar_tindakan bt 
						ON bt.id = r.bayar_tindakan_id 
					  INNER JOIN $dbbilling.b_tindakan t 
						ON t.id = bt.tindakan_id 
					  INNER JOIN $dbbilling.b_ms_tindakan_kelas mtk 
						ON mtk.id = t.ms_tindakan_kelas_id 
					  INNER JOIN $dbbilling.b_ms_tindakan mt 
						ON mt.id = mtk.ms_tindakan_id 
					  INNER JOIN $dbbilling.b_pelayanan pl 
						ON pl.id = t.pelayanan_id 
					  INNER JOIN $dbbilling.b_ms_pasien ps 
						ON ps.id = pl.pasien_id 
					  INNER JOIN $dbbilling.b_ms_unit u 
						ON u.id = pl.unit_id 
					  INNER JOIN $dbbilling.b_ms_kso kso 
						ON kso.id = pl.kso_id 
					WHERE bt.tipe = 0 $waktu $fKso AND r.flag = '$flag'
					UNION ALL
					SELECT 
					  DATE_FORMAT(r.tgl_return, '%d/%m/%Y') AS tgl,
					  r.no_return,
					  ps.no_rm,
					  ps.nama,
					  mu.nama AS unit,
					  kso.nama AS kso,
					  mt.nama AS tindakan,
					  bt.nilai AS biaya 
					FROM
					  $dbbilling.b_pelayanan p 
					  INNER JOIN $dbbilling.b_ms_unit mu 
						ON p.unit_id = mu.id 
					  INNER JOIN $dbbilling.b_tindakan_kamar t 
						ON p.id = t.pelayanan_id 
					  LEFT JOIN $dbbilling.b_ms_unit n 
						ON n.id = mu.parent_id 
					  INNER JOIN $dbbilling.b_ms_kamar tk 
						ON tk.id = t.kamar_id 
					  INNER JOIN $dbbilling.b_bayar_tindakan bt 
						ON bt.tindakan_id = t.id 
					  INNER JOIN $dbbilling.b_tindakan ti 
						ON ti.id = bt.tindakan_id 
					  INNER JOIN $dbbilling.b_ms_tindakan_kelas btk 
						ON btk.id = ti.ms_tindakan_kelas_id 
					  INNER JOIN $dbbilling.b_ms_tindakan mt 
						ON mt.id = btk.ms_tindakan_id 
					  INNER JOIN $dbbilling.b_ms_kelas mk 
						ON mk.id = btk.ms_kelas_id 
					  INNER JOIN $dbbilling.b_return r 
						ON r.bayar_tindakan_id = bt.id 
					  INNER JOIN $dbbilling.b_ms_pasien ps 
						ON ps.id = p.pasien_id 
					  INNER JOIN $dbbilling.b_ms_kso kso 
						ON kso.id = p.kso_id 
					WHERE bt.tipe = 1 
					  AND p.jenis_kunjungan = 3 $waktu $fKso) AS tbl1 ORDER BY no_return";
				$kueri=mysql_query($sql);
				$no=0;
				$tot=0;
				while($rows=mysql_fetch_array($kueri)){
				$no++;
				?>
                <tr>
                    <td align="center"><?php echo $no;?></td>
                    <td align="center">&nbsp;<?php echo $rows['tgl'];?></td>
                    <td align="center">&nbsp;<?php echo $rows['no_return'];?></td>
                    <td align="center">&nbsp;<?php echo $rows['no_rm'];?></td>
                    <td align="left" style="padding-left:5px;"><?php echo $rows['nama'];?></td>
                    <td align="left" style="padding-left:5px;"><?php echo $rows['unit'];?></td>
                    <td align="center"><?php echo $rows['kso'];?></td>
                    <td align="left" style="padding-left:5px"><?php echo $rows['tindakan'];?></td>
                    <td align="right" style="padding-right:10px;"><?php echo number_format($rows['biaya'],0,',','.');?></td>
                </tr>
                <?php
				$tot=$tot+$rows['biaya'];
				}
				?>
                <tr style="font-weight:bold" height="30">
                    <td colspan="8" align="center" style="border-bottom:1px solid; border-top:1px solid;">Total&nbsp;</td>
                    <td align="right" style="padding-right:10px; border-bottom:1px solid; border-top:1px solid;"><?php echo number_format($tot,0,",",".");?></td>
                </tr>
        </table></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
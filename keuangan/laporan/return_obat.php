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
        $waktu = "DATE(tgl_retur) = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
        $waktu = "month(tgl_retur) = '$bln' AND year(tgl_retur) = '$thn' ";
        $Periode = "Bulan $arrBln2[$bln] Tahun $thn";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = "DATE(tgl_retur) between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }

?>
<title>.: Laporan Return Obat :.</title>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
    <tr>
        <td><b><?=$pemkabRS;?><br><?=$namaRS;?><br><?=$alamatRS;?><br>Telepon <?=$tlpRS;?></b></td>
    </tr>
    <tr>
        <td style="font-size:14px; height:70px; text-transform:uppercase; text-align:center; font-weight:bold;" valign="top">laporan return obat<br><?php echo $Periode;?></td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                <tr height="30">
                    <td width="3%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center;">NO</td>   
                    <td width="7%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center;">TANGGAL</td>  
                    <td width="10%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center;">NO. RETURN</td>  
                    <td width="10%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center">NO PENJUALAN</td>  
                    <td width="9%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:center">KSO</td>  
                    <td width="12%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; text-align:right; padding-right:10px; text-align:center">UNIT PELAYANAN</td>  
                    <td width="11%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; padding-left:0px; text-align:center">FARMASI</td>
                    <td width="21%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; padding-left:00px; text-align:center">OBAT</td>
                    <td width="6%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; padding-left:00px; text-align:center">QTY</td>
                    <td width="11%" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; padding-left:00px; text-align:center">NILAI</td>  
                </tr>
                <?php
				
				/*$s_kso="SELECT DISTINCT 
				  m.IDMITRA id,
				  mkso.nama 
				FROM
				  $dbapotek.a_mitra m 
				  INNER JOIN $dbbilling.b_ms_kso mkso 
					ON m.KODE_MITRA = mkso.kode 
				WHERE mkso.id = ".$_REQUEST['cmbKsoRep'];*/
				
				$s_kso="SELECT DISTINCT 
				  m.IDMITRA id,
				  mkso.nama 
				FROM
				  $dbapotek.a_mitra m 
				  INNER JOIN $dbbilling.b_ms_kso mkso 
					ON m.kso_id_billing = mkso.id 
				WHERE mkso.id = ".$_REQUEST['cmbKsoRep'];
				$q_kso=mysql_query($s_kso);
				$r_kso=mysql_fetch_array($q_kso);
				
				if($_REQUEST['cmbKsoRep']=='0'){
					$fKso = "";
				}
				else{
					$fKso = " where p.KSO_ID=".$r_kso['id'];
				}
				
				$sql="SELECT 
				  DATE_FORMAT(rp.tgl_retur, '%d/%m/%Y') tgl,
				  rp.no_retur,
				  p.NO_PENJUALAN,
				  mu.nama,
				  au.UNIT_NAME,
				  ao.OBAT_NAMA,
				  rp.qty_retur,
				  rp.nilai,
				  mkso.nama AS kso
				FROM
				  (SELECT 
					* 
				  FROM
					$dbapotek.a_return_penjualan 
				  WHERE $waktu) rp 
				  INNER JOIN $dbapotek.a_penjualan p 
					ON rp.idpenjualan = p.ID 
				  INNER JOIN $dbapotek.a_unit u 
					ON p.RUANGAN = u.UNIT_ID 
				  INNER JOIN $dbapotek.a_penerimaan ap 
					ON p.PENERIMAAN_ID = ap.ID 
				  INNER JOIN $dbapotek.a_obat ao 
					ON ap.OBAT_ID = ao.OBAT_ID 
				  INNER JOIN $dbapotek.a_unit au 
					ON au.UNIT_ID = p.UNIT_ID 
				  INNER JOIN $dbapotek.a_mitra am 
					ON am.IDMITRA = p.KSO_ID 
				  INNER JOIN $dbbilling.b_ms_kso mkso 
					ON am.kso_id_billing = mkso.id
				  INNER JOIN 
					(SELECT 
					  * 
					FROM
					  $dbbilling.b_ms_unit 
					WHERE aktif = 1 
					  AND kategori = 2 
					  AND LEVEL = 2) mu 
					ON mu.id = u.unit_billing $fKso ORDER BY rp.tgl_retur";				
				
				//$sql="";
				$kueri=mysql_query($sql);
				$no=0;
				while($rows=mysql_fetch_array($kueri)){
				$no++;
								
				?>
                <tr>
                    <td align="center"><?php echo $no;?></td>
                    <td align="center">&nbsp;<?php echo $rows['tgl'];?></td>
                    <td align="center">&nbsp;<?php echo $rows['no_retur'];?></td>
                    <td align="center">&nbsp;<?php echo $rows['NO_PENJUALAN'];?></td>
                     <td align="left" style="padding-left:5px"><?php echo $rows['kso'];?></td>
                    <td align="left" style="padding-left:5px;"><?php echo $rows['nama'];?></td>
                    <td align="left" style="padding-left:5px;"><?php echo $rows['UNIT_NAME'];?></td>
                    <td align="left" style="padding-left:5px"><?php echo $rows['OBAT_NAMA'];?></td>
                    <td align="center" style="padding-left:0px"><?php echo $rows['qty_retur'];?></td>
                    <td align="right" style="padding-right:10px;"><?php echo number_format($rows['nilai'],0,',','.');?></td>
                </tr>
                <?php
				$tot=$tot+$rows['nilai'];
				
				}
				?>
                <tr style="font-weight:bold" height="30">
                    <td colspan="9" align="center" style="border-bottom:1px solid; border-top:1px solid;">Total&nbsp;</td>
                    <td align="right" style="padding-right:10px; border-bottom:1px solid; border-top:1px solid;"><?php echo number_format($tot,0,",",".");?></td>
                </tr>
        </table></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
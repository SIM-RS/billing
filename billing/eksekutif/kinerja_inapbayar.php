<?php
	session_start();
	include "../sesi.php";
	$userId = $_SESSION['userId'];
	$jnsLay = $_REQUEST['JnsLayananInapSaja'];
	$tmpLay = $_REQUEST['TmpLayananInapSaja'];
    $bln = $_REQUEST['cmbBln'];
    $thn = $_REQUEST['cmbThn'];
    include("../koneksi/konek.php");
		$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	if($tmpLay==0){
		$fUnit = "b_ms_unit.id = '".$jnsLay."'";
	}else{
		$fUnit = "b_ms_unit.id = '".$tmpLay."'";
	}
	
	$qUn = "SELECT id, nama FROM b_ms_unit WHERE $fUnit ";
	$sUn = mysql_query($qUn);
	$wUn = mysql_fetch_array($sUn);
?>
<html>
    <style>
        .jdl{
            text-transform:uppercase;
            font-size:18px;
            font-weight:bold;
        }
        .tblJdl
        {
            text-align:center;
            border-top:1px solid #000000;
            border-bottom:1px solid #000000;
            border-left:1px solid #000000;
            font-weight:bold;
			background-color:#00FF00;
        }
        .tblJdlBwh
        {
            text-align:center;            
            border-bottom:1px solid #000000;
            border-left:1px solid #000000;
            font-weight:bold;
			background-color:#00FF00;
        }
        .tblJdlKn
        {
            text-align:center;
            border-top:1px solid #000000;
            border-bottom:1px solid #000000;
            border-left:1px solid #000000;
            font-weight:bold;
            border-right:1px solid #000000;
			background-color:#00FF00;
        }
        .tblIsi
        {
            border-bottom:1px solid #000000;
            border-left:1px solid #000000;
            padding:1px 1px 1px 2px;
        }
        .tblIsiKn
        {
            border-bottom:1px solid #000000;
            border-left:1px solid #000000;
            border-right:1px solid #000000;
        }
    </style>
    <head>
        <title>.: Kinerja Instalasi Rawat Inap Berdasar Cara Bayar :.</title>
    </head>
    <body>
        <table width="800" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;" cellpadding="0" cellspacing="0">
            <tr>
				<td><b><?=$namaRS;?><br /><?=$alamatRS;?><br />Telepon <?=$tlpRS;?><br /><?=$kotaRS;?></b></td>
			</tr>
			<tr>
                <td align="center" class="jdl" height="75" valign="middle"><?php echo "kinerja instalasi&nbsp;".$wUn['nama']."&nbsp;berdasarkan cara bayar<br>".$thn;?></td>
            </tr>
            <tr>
                <td align="center">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                        <tr>
                            <td class="tblJdl" rowspan="2" align="center">NO</td>
                            <td class="tblJdl" rowspan="2" align="center">TAHUN<br><?php echo $thn?></td>
                            <td class="tblJdl" colspan="3" align="center">KELAS</td>
                            <td class="tblJdl" rowspan="2" align="center">TOTAL</td>
                            <td class="tblJdlKn" rowspan="2" align="center">%</td>
                        </tr>
                        <tr>
                            <td class="tblJdlBwh" align="center">KLS I</td>
                            <td class="tblJdlBwh" align="center">KLS II</td>
                            <td class="tblJdlBwh" align="center">KLS III</td>
                        </tr>
						<?php
								if($tmpLay==0){
									$fTmp = "b_pelayanan.jenis_layanan = '".$jnsLay."'";
								}else{
									$fTmp = "b_pelayanan.unit_id = '".$tmpLay."'";
								}
								$qt = "SELECT COUNT(b_pelayanan.id) AS jml, b_ms_kelas.nama FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id INNER JOIN b_ms_kelas ON b_ms_kelas.id = b_pelayanan.kelas_id WHERE YEAR(b_pelayanan.tgl)='$thn' AND $fTmp AND (b_ms_kelas.id=2 OR b_ms_kelas.id=3 OR b_ms_kelas.id=4) ";
								if($bln!=''){
									$sql1.=" AND MONTH(b_pelayanan.tgl)=$bln";
								}
								$st = mysql_query($qt);
								$wt = mysql_fetch_array($st);
								
								$sql = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id INNER JOIN b_ms_kelas ON b_ms_kelas.id = b_pelayanan.kelas_id WHERE $fTmp AND (b_ms_kelas.id=2 OR b_ms_kelas.id=3 OR b_ms_kelas.id=4) AND YEAR(b_pelayanan.tgl)='$thn' GROUP BY b_ms_kso.id ";
								if($bln!=''){
									$sql.=" AND MONTH(b_pelayanan.tgl)=$bln";
								}
								$rs = mysql_query($sql);
								$no = 1;
								$tot1 = 0;
								$tot2 = 0;
								$tot3 = 0;
								while($rw = mysql_fetch_array($rs))
								{
									$sql1 = "SELECT SUM(IF(b_ms_kelas.id=2,1,0)) AS satu, SUM(IF(b_ms_kelas.id=3,1,0)) AS dua, SUM(IF(b_ms_kelas.id=4,1,0)) AS tiga FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id INNER JOIN b_ms_kelas ON b_ms_kelas.id = b_pelayanan.kelas_id WHERE b_pelayanan.kso_id = '".$rw['id']."' AND YEAR(b_pelayanan.tgl)='$thn' AND $fTmp";
									if($bln!=''){
										$sql1.=" AND MONTH(b_pelayanan.tgl)=$bln";
									}
									$rs1 = mysql_query($sql1);
									$rw1 = mysql_fetch_array($rs1);
						?>
                        <tr>
                            <td class="tblIsi" align="center" width="5%"><?php echo $no;?></td>
                            <td class="tblIsi" style="text-transform:uppercase;" width="33%">&nbsp;<?php echo $rw['nama']?></td>
                            <td class="tblIsi" width="12%" style="text-align:right; padding-right:10px;"><?php echo number_format($rw1['satu'],0,",",".");?></td>
                            <td class="tblIsi" width="12%" style="text-align:right; padding-right:10px;"><?php echo number_format($rw1['dua'],0,",",".");?></td>
                            <td class="tblIsi" width="12%" style="text-align:right; padding-right:10px;"><?php echo number_format($rw1['tiga'],0,",",".");?></td>
							<?php $jml = $rw1['satu'] + $rw1['dua'] + $rw1['tiga']?>
                            <td class="tblIsi" width="13%" style="text-align:right; padding-right:10px;"><?php echo number_format($jml,0,",",".")?></td>
                            <td class="tblIsiKn" width="13%" style="text-align:right; padding-right:10px;"><?php  echo number_format($jml/$wt['jml']*100,2,",",".");?>&nbsp;%</td>
                        </tr>
						<?php
								$no++;
								$tot1=$tot1 + $rw1['satu'];
								$tot2=$tot2 + $rw1['dua'];
								$tot3=$tot3 + $rw1['tiga'];
								}
						?>
                        <tr>
                            <td class="tblIsi" colspan="2" align="right" style="background-color:#FFFF00; font-weight:bold;">TOTAL&nbsp;</td>
                            <td class="tblIsi" style="background-color:#FFFF00; font-weight:bold; text-align:right; padding-right:10px;"><?php echo number_format($tot1,0,",",".");?></td>
                            <td class="tblIsi" style="background-color:#FFFF00; font-weight:bold; text-align:right; padding-right:10px;"><?php echo number_format($tot2,0,",",".");?></td>
                            <td class="tblIsi" style="background-color:#FFFF00; font-weight:bold; text-align:right; padding-right:10px;"><?php echo number_format($tot3,0,",",".");?></td>
							<?php $tot = $tot1 + $tot2 + $tot3?>
                             <td class="tblIsi" style="background-color:#FFFF00; font-weight:bold; text-align:right; padding-right:10px;"><?php echo number_format($tot,0,",",".");?></td>
                            <td class="tblIsiKn" style="background-color:#FFFF00; font-weight:bold; text-align:right; padding-right:10px;">100&nbsp;%</td>    
                        </tr>
                    </table>                </td>
            </tr>
        </table>
    </body>
</html>
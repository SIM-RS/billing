<?php
	session_start();
	include "../sesi.php";
	$userId = $_SESSION['userId'];
	$sts = $_REQUEST['StatusPas'];
    $bln = $_REQUEST['cmbBln'];
    $thn = $_REQUEST['cmbThn'];
    include("../koneksi/konek.php");
		$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	
	$qUn = "SELECT id, nama FROM b_ms_kso WHERE id='".$sts."' ";
	$sUn = mysql_query($qUn);
	$wUn = mysql_fetch_array($sUn);
?>
<html>
    <style>
        .jdl{
            text-transform:uppercase;
            font-size:large;
            font-weight:bold;
        }
        .tblJdl
        {
            text-align:center;
            border-top:1px solid #000000;
            border-bottom:1px solid #000000;
            border-left:1px solid #000000;
            font-weight:bold;
			background-color:#CCFFFF;
        }
        .tblJdlBwh
        {
            text-align:center;            
            border-bottom:1px solid #000000;
            border-left:1px solid #000000;
            font-weight:bold;
			background-color:#CCFFFF;
        }
        .tblJdlKn
        {
            text-align:center;
            border-top:1px solid #000000;
            border-bottom:1px solid #000000;
            border-left:1px solid #000000;
            font-weight:bold;
            border-right:1px solid #000000;
			background-color:#CCFFFF;
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
        <title>.: Rekapitulasi Data Kunjungan Berdasarkan Jenis Pembayaran :.</title>
    </head>
    <body>
        <table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            <tr>
				<td><b><?=$namaRS;?><br /><?=$alamatRS;?><br />Telepon <?=$tlpRS;?><br /><?=$kotaRS;?></b></td>
			</tr>
			<tr>
                <td align="center" class="jdl" height="75"><?php echo "pola penyakit terbanyak&nbsp;".$wUn['nama']."&nbsp;<br>".$thn;?></td>
            </tr>
			<tr>
				<td>
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="48%" valign="top">
								<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
								<tr>
									<td height="30" colspan="3" style="text-align:center; font-weight:bold; background-color:#00FFFF;">TAHUN <?php echo $thn-1;?></td>
								</tr>
								<tr>
									<td width="10%">&nbsp;</td>
									<td width="60%">&nbsp;</td>
									<td width="30%">&nbsp;</td>
								</tr>
								<tr>
									<td style="text-align:center; background-color:#00FF00; font-weight:bold; border-bottom:1px solid; border-left:1px solid; border-top:1px solid;">NO</td>
									<td style="text-align:center; background-color:#00FF00; font-weight:bold; border-bottom:1px solid; border-left:1px solid; border-top:1px solid;" height="25">JENIS PENYAKIT</td>
									<td style="text-align:center; background-color:#00FF00; font-weight:bold; border-bottom:1px solid; border-left:1px solid; border-top:1px solid; border-right:1px solid;">JUMLAH PASIEN</td>
								</tr>
								<?php
										$sql1 = "SELECT b_ms_diagnosa.id, b_ms_diagnosa.nama, COUNT(b_diagnosa.pelayanan_id) AS jml FROM b_pelayanan INNER JOIN b_diagnosa ON b_diagnosa.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_diagnosa.ms_diagnosa_id = b_ms_diagnosa.id WHERE b_pelayanan.kso_id = '".$wUn['id']."' AND YEAR(b_diagnosa.tgl)=($thn-1) GROUP BY b_ms_diagnosa.id ORDER BY COUNT(b_diagnosa.pelayanan_id) DESC LIMIT 10 ";
										if($bln!=''){
											$sql1.=" AND MONTH(b_diagnosa.tgl)=$bln";
										}
										$rs1 = mysql_query($sql1);
										$no = 1;
										while($rw1 = mysql_fetch_array($rs1))
										{
											$qt= "SELECT SUM(t.jml) AS tot FROM(SELECT b_pelayanan.kso_id, COUNT(b_diagnosa.pelayanan_id) AS jml FROM b_pelayanan INNER JOIN b_diagnosa ON b_diagnosa.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_diagnosa.ms_diagnosa_id = b_ms_diagnosa.id WHERE YEAR(b_diagnosa.tgl)=($thn-1) AND b_ms_diagnosa.id='".$rw1['id']."' GROUP BY b_pelayanan.kso_id ORDER BY COUNT(b_diagnosa.pelayanan_id) DESC LIMIT 10) AS t";
											if($bln!=''){
												$qt.=" AND MONTH(b_diagnosa.tgl)=$bln";
											}
											$st = mysql_query($qt);
											$wt = mysql_fetch_array($st);
								?>
								<tr>
									<td style="border-left:1px solid; border-bottom:1px solid; text-align:center"><?php echo $no;?></td>
									<td style="border-left:1px solid; border-bottom:1px solid; padding-left:5px"><?php echo $rw1['nama']?></td>
									<td style="border-left:1px solid; border-bottom:1px solid; text-align:right; border-right:1px solid; padding-right:10px;"><?php echo number_format($rw1['jml']/$wt['tot']*100,2,",",".")?>&nbsp;%</td>
								</tr>
								<?php 	
										$no++;
										}	
								?>
								</table>
							</td>
							<td width="4%">&nbsp;</td>
							<td width="48%" valign="top">
							<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
								<tr>
									<td height="30" colspan="3" style="text-align:center; font-weight:bold; background-color:#00FFFF;">TAHUN <?php echo $thn;?></td>
								</tr>
								<tr>
									<td width="10%">&nbsp;</td>
									<td width="60%">&nbsp;</td>
									<td width="30%">&nbsp;</td>
								</tr>
								<tr>
									<td style="text-align:center; background-color:#00FF00; font-weight:bold; border-bottom:1px solid; border-left:1px solid; border-top:1px solid;">NO</td>
									<td style="text-align:center; background-color:#00FF00; font-weight:bold; border-bottom:1px solid; border-left:1px solid; border-top:1px solid;" height="25">JENIS PENYAKIT</td>
									<td style="text-align:center; background-color:#00FF00; font-weight:bold; border-bottom:1px solid; border-left:1px solid; border-top:1px solid; border-right:1px solid;">JUMLAH PASIEN</td>
								</tr>
								<?php
										$sql2 = "SELECT b_ms_diagnosa.id, b_ms_diagnosa.nama, COUNT(b_diagnosa.pelayanan_id) AS jml FROM b_pelayanan INNER JOIN b_diagnosa ON b_diagnosa.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_diagnosa.ms_diagnosa_id = b_ms_diagnosa.id WHERE b_pelayanan.kso_id = '".$wUn['id']."' AND YEAR(b_diagnosa.tgl)=$thn GROUP BY b_ms_diagnosa.id ORDER BY COUNT(b_diagnosa.pelayanan_id) DESC LIMIT 10 ";
										if($bln!=''){
											$sql2.=" AND MONTH(b_diagnosa.tgl)=$bln";
										}
										$rs2 = mysql_query($sql2);
										$no = 1;
										while($rw2 = mysql_fetch_array($rs2))
										{
											
											$qt2= "SELECT SUM(t.jml) AS tot FROM(SELECT b_pelayanan.kso_id, COUNT(b_diagnosa.pelayanan_id) AS jml FROM b_pelayanan INNER JOIN b_diagnosa ON b_diagnosa.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_diagnosa.ms_diagnosa_id = b_ms_diagnosa.id WHERE YEAR(b_diagnosa.tgl)=$thn AND b_ms_diagnosa.id='".$rw2['id']."' GROUP BY b_pelayanan.kso_id ORDER BY COUNT(b_diagnosa.pelayanan_id) DESC LIMIT 10) AS t";
											if($bln!=''){
												$qt2.=" AND MONTH(b_diagnosa.tgl)=$bln";
											}
											$st2 = mysql_query($qt2);
											$wt2 = mysql_fetch_array($st2);
								?>
								<tr>
									<td style="border-left:1px solid; border-bottom:1px solid; text-align:center"><?php echo $no;?></td>
									<td style="border-left:1px solid; border-bottom:1px solid; padding-left:5px"><?php echo $rw2['nama']?></td>
									<td style="border-left:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:right; padding-right:10px;"><?php echo number_format($rw2['jml']/$wt['tot']*100,2,",",".")?>&nbsp;%</td>
								</tr>
								<?php 	
										$no++;
										}	
								?>
								</table>
							</td>
						</tr>					</table>
				</td>
			</tr>
        </table>
    </body>
</html>
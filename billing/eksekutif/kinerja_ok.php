<?php
	session_start();
	include "../sesi.php";
	$userId = $_SESSION['userId'];
	$jnsLay = $_REQUEST['cmbJnsPenunjang'];
	$tmpLay = $_REQUEST['cmbTmpPenunjang'];
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
            font-size:large;
            font-weight:bold;
        }
        .tblJdl
        {
            text-align:center;
            border-top:1px solid #FFFFFF;
            border-bottom:1px solid #FFFFFF;
            border-left:1px solid #FFFFFF;
            font-weight:bold;
			background-color:#00FF00;
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
            border-top:1px solid #FFFFFF;
            border-bottom:1px solid #FFFFFF;
            border-left:1px solid #FFFFFF;
            font-weight:bold;
            border-right:1px solid #FFFFFF;
			background-color:#99FFFF;
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
        <title>.: Kinerja Instalasi Bedah Sentral :.</title>
    </head>
    <body>
        <table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
             <tr>
				<td><b><?=$namaRS;?><br /><?=$alamatRS;?><br />Telepon <?=$tlpRS;?><br /><?=$kotaRS;?></b></td>
			</tr>
			<tr>
                <td align="center" class="jdl" height="75"><?php echo "kinerja instalasi&nbsp;".$wUn['nama']."&nbsp;".$thn."<br>pasien rawat inap non pavilyun<br>berdasar dokter operator";?>&nbsp;</td>
            </tr>
            <tr>
                <td align="center">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                        <tr>
							<td class="tblJdl" height="25" width="5%">NO</td>
							<td class="tblJdl" width="55%">DOKTER OPERATOR</td>
							<td class="tblJdl" width="20%">TAHUN <?php echo $thn-1;?></td>
							<td class="tblJdl" width="20%">TAHUN <?php echo $thn;?></td>
						</tr>
						<?php
								if($tmpLay==0){
									$fTmp = "b_ms_unit.parent_id = '".$jnsLay."'";
								}else{
									$fTmp = "b_ms_unit.id = '".$tmpLay."'";
								}
								$sql = "SELECT b_ms_pegawai.id, b_ms_pegawai.nama FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_tindakan.user_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal WHERE b_pelayanan.unit_id = 63 AND (YEAR(b_tindakan.tgl)=($thn-1) OR YEAR(b_tindakan.tgl)=$thn) AND b_ms_unit.inap=1 GROUP BY b_ms_pegawai.id";
								if($bln!=''){
									$sql.=" AND MONTH(b_tindakan.tgl)=$bln";
								}
								$rs = mysql_query($sql);
								$no = 1;
								$totlm = 0;
								$totbr = 0;
								while($rw = mysql_fetch_array($rs))
								{
									$thnlama = ($thn-1);
									$sql1 = "SELECT t.id, t.nama, SUM(IF(t.thn='$thnlama',1,0)) AS lama, SUM(IF(t.thn='$thn',1,0)) AS baru
FROM (SELECT b_ms_pegawai.id, b_ms_pegawai.nama, YEAR(b_tindakan.tgl) AS thn FROM b_pelayanan
INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_tindakan.user_id
INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
WHERE b_pelayanan.unit_id = 63 AND b_ms_unit.inap=1 AND b_ms_pegawai.id='".$rw['id']."') AS t
GROUP BY t.id";
									if($bln!=''){
										$sql1.=" AND MONTH(b_tindakan.tgl)=$bln";
									}
									$rs1 = mysql_query($sql1);
									$rw1 = mysql_fetch_array($rs1);
						?>
						<tr>
							<td style="text-align:center"><?php echo $no;?></td>
							<td style="padding-left:10px; text-transform:uppercase;"><?php echo $rw['nama']?></td>
							<td style="text-align:right; padding-right:30px;"><?php echo number_format($rw1['lama'],0,",",".")?></td>
							<td style="padding-right:30px; text-align:right;"><?php echo number_format($rw1['baru'],0,",",".")?></td>
						</tr>
						<?php
								$no++; 
								$totlm = $totlm + $rw1['lama']; 
								$totbr = $totbr + $rw1['baru']; 
								}
						?>
						<tr style="font-weight:bold; background-color:#FFFF00">
							<td height="25">&nbsp;</td>
							<td>&nbsp;JUMLAH</td>
							<td style="text-align:right; padding-right:30px;"><?php echo number_format($totlm,0,",",".")?></td>
							<td style="padding-right:30px; text-align:right;"><?php echo number_format($totbr,0,",",".")?></td>
						</tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
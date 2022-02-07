<?php
session_start();
include "../sesi.php";
?>
<?php
	//session_start();
	$userId = $_SESSION['userId'];
	$jnsLay = $_REQUEST['JnsLayanan'];
	$tmpLay = $_REQUEST['TmpLayanan'];
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
        <title>.: Rekapitulasi Data Kegiatan :.</title>
    </head>
    <body>
        <table width="1000" border="0">
            <tr>
                <td align="center" class="jdl" height="50"><?php echo "kegiatan&nbsp;".$wUn['nama']."<br>".$thn;?></td>
            </tr>
            <tr>
                <td align="center">
                    <table width="90%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="tblJdl" rowspan="2" align="center">NO</td>
                            <td class="tblJdl" rowspan="2" align="center">URAIAN</td>
                            <td class="tblJdl" colspan="2" align="center">TAHUN</td>
                            <td class="tblJdl" rowspan="2" align="center">TREN</td>
                            <td class="tblJdlKn" rowspan="2" align="center">%</td>
                        </tr>
                        <tr>
                            <td class="tblJdlBwh" align="center"><?php echo $thn-1;?></td>
                            <td class="tblJdlBwh" align="center"><?php echo $thn;?></td>
                        </tr>
						<?php
								$sql = "SELECT b_ms_cara_keluar.id, b_ms_cara_keluar.nama FROM b_ms_cara_keluar";
								$rs = mysql_query($sql);
								$no = 1;
								$tot1=0;
								$tot2=0;
								while($rw = mysql_fetch_array($rs))
								{
									if($tmpLay==0){
										$fTmp = "AND b_pelayanan.jenis_layanan = '".$jnsLay."'";
									}else{
										$fTmp = "AND b_pelayanan.unit_id = '".$tmpLay."'";
									}
									$sql1="SELECT COUNT(b_pasien_keluar.kunjungan_id) AS jml FROM b_pasien_keluar INNER JOIN b_ms_cara_keluar ON b_ms_cara_keluar.nama = b_pasien_keluar.cara_keluar INNER JOIN b_pelayanan ON b_pasien_keluar.pelayanan_id = b_pelayanan.id WHERE b_ms_cara_keluar.id = '".$rw['id']."' $fTmp AND YEAR(b_pasien_keluar.tgl_act)=$thn";    
									if($bln!=''){
										$sql1.=" AND MONTH(b_pasien_keluar.tgl_act)=$bln";
									}
									$rs1=mysql_query($sql1);
									$rw1=mysql_fetch_array($rs1);
									
									$sql2="SELECT COUNT(b_pasien_keluar.kunjungan_id) AS jml FROM b_pasien_keluar INNER JOIN b_ms_cara_keluar ON b_ms_cara_keluar.nama = b_pasien_keluar.cara_keluar INNER JOIN b_pelayanan ON b_pasien_keluar.pelayanan_id = b_pelayanan.id WHERE b_ms_cara_keluar.id = '".$rw['id']."' $fTmp AND YEAR(b_pasien_keluar.tgl_act)=".($thn-1);   
									if($bln!=''){
										$sql2.=" AND MONTH(tgl)=$bln";
									}
									$rs2=mysql_query($sql2);
									$rw2=mysql_fetch_array($rs2);
									
									
									if($rw1['jml']<$rw2['jml']){
										echo 'Naik';
										$selisih=$rw2['jml']-$rw1['jml'];
									}
									else if($rw1['jml']>$rw2['jml']){
										echo 'Turun';
										$selisih=$rw1['jml']-$rw2['jml'];
									}
									else{
										echo 'Tetap';
										$selisih=0;
									}
						?>
						<tr>
							<td class="tblIsi" align="center" width="5%">1</td>
							<td class="tblIsi" width="50%">&nbsp;JUMLAH PASIEN DIRAWAT</td>
							<td class="tblIsi" width="10%" style="padding-right:10px; text-align:right;">&nbsp;</td>
							<td class="tblIsi" width="10%" style="padding-right:10px; text-align:right;">&nbsp;</td>
							<td class="tblIsi" width="15%" style="text-align:center;">&nbsp;</td>
							<td class="tblIsiKn" width="10%" style="padding-right:10px; text-align:right;">&nbsp;</td>
						</tr>
						<tr>
							<td class="tblIsi" align="center">2</td>
							<td class="tblIsi">&nbsp;JUMLAH HARI PERAWATAN</td>
							<td class="tblIsi" style="padding-right:10px; text-align:right;">&nbsp;</td>
							<td class="tblIsi" style="padding-right:10px; text-align:right;">&nbsp;</td>
							<td class="tblIsi" style="text-align:center;">&nbsp;</td>
							<td class="tblIsiKn" style="padding-right:10px; text-align:right;">&nbsp;</td>
						</tr>
						<tr>
							<td class="tblIsi" align="center">3</td>
							<td class="tblIsi">&nbsp;PASIEN MENINGGAL < 48 JAM</td>
							<td class="tblIsi" style="padding-right:10px; text-align:right;">&nbsp;</td>
							<td class="tblIsi" style="padding-right:10px; text-align:right;">&nbsp;</td>
							<td class="tblIsi" style="text-align:center;">&nbsp;</td>
							<td class="tblIsiKn" style="padding-right:10px; text-align:right;">&nbsp;</td>
						</tr>
						<tr>
							<td class="tblIsi" align="center">4</td>
							<td class="tblIsi">&nbsp;PASIEN MENINGGAL > 48 JAM</td>
							<td class="tblIsi" style="padding-right:10px; text-align:right;">&nbsp;</td>
							<td class="tblIsi" style="padding-right:10px; text-align:right;">&nbsp;</td>
							<td class="tblIsi" style="text-align:center;">&nbsp;</td>
							<td class="tblIsiKn" style="padding-right:10px; text-align:right;">&nbsp;</td>
						</tr>
						<tr>
							<td class="tblIsi" align="center">5</td>
							<td class="tblIsi">&nbsp;BOR (TEMPAT TIDUR)</td>
							<td class="tblIsi" style="padding-right:10px; text-align:right;">&nbsp;</td>
							<td class="tblIsi" style="padding-right:10px; text-align:right;">&nbsp;</td>
							<td class="tblIsi" style="text-align:center;">&nbsp;</td>
							<td class="tblIsiKn" style="padding-right:10px; text-align:right;">&nbsp;</td>
						</tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
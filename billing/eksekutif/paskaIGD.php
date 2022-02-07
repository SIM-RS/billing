<?php
	session_start();
	include "../sesi.php";
	$userId = $_SESSION['userId'];
    $bln = $_REQUEST['cmbBln'];
    $thn = $_REQUEST['cmbThn'];
    $judul = 'data paska kunjungan igd';
    include("../koneksi/konek.php");
		$date_now=gmdate('d-m-Y',mktime(date('H')+7));
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
        <title><?php echo $judul;?></title>
    </head>
    <body>
        <table width="1000" border="0">
            <tr>
                <td align="center" class="jdl"><?php echo $judul." ".$thn;?></td>
            </tr>
            <tr height="20">
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="center">
                    <table width="700" border="0" cellpadding="0" cellspacing="0">
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
									$sql1="SELECT COUNT(b_pasien_keluar.kunjungan_id) AS jml FROM b_pasien_keluar
INNER JOIN b_ms_cara_keluar ON b_ms_cara_keluar.nama = b_pasien_keluar.cara_keluar
WHERE b_ms_cara_keluar.id = '".$rw['id']."' AND YEAR(b_pasien_keluar.tgl_act)=$thn";    
									if($bln!=''){
										$sql1.=" AND MONTH(b_pasien_keluar.tgl_act)=$bln";
									}
									$rs1=mysql_query($sql1);
									$rw1=mysql_fetch_array($rs1);
									
									$sql2="SELECT COUNT(b_pasien_keluar.kunjungan_id) AS jml FROM b_pasien_keluar
INNER JOIN b_ms_cara_keluar ON b_ms_cara_keluar.nama = b_pasien_keluar.cara_keluar
WHERE b_ms_cara_keluar.id = '".$rw['id']."' AND YEAR(b_pasien_keluar.tgl_act)=".($thn-1);   
									if($bln!=''){
										$sql2.=" AND MONTH(tgl)=$bln";
									}
									$rs2=mysql_query($sql2);
									$rw2=mysql_fetch_array($rs2);
						?>
                        <tr>
                            <td class="tblIsi" align="center" width="5%"><?php echo $no;?></td>
                            <td class="tblIsi" style="text-transform:uppercase;" width="35%"><?php echo $rw['nama']?></td>
                            <td class="tblIsi" width="15%" style="text-align:right; padding-right:15px;"><?php echo $rw1['jml'];?></td>
                            <td class="tblIsi" width="15%" style="text-align:right; padding-right:15px;"><?php echo $rw2['jml'];?></td>
                            <td class="tblIsi" width="10%" style="text-align:right; padding-right:15px;">
                            <?php
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
                            ?></td>
                            <td class="tblIsiKn" width="20%" style="text-align:right; padding-right:15px;"><?php  echo number_format($selisih/$rw1['jml']*100,2,",",".");?>&nbsp;%</td>                            
                        </tr>
						<?php
								$no++;
								$tot1=$tot1 + $rw1['jml'];
								$tot2=$tot2 + $rw2['jml'];
								}
						?>
                        <tr>
                            <td class="tblIsi" colspan="2" align="right" style="background-color:#FFFF99; font-weight:bold;">JUMLAH&nbsp;</td>
                            <td class="tblIsi" style="background-color:#FFFF99; font-weight:bold; text-align:right; padding-right:15px;"><?php echo $tot1;?></td>
                            <td class="tblIsi" style="background-color:#FFFF99; font-weight:bold; text-align:right; padding-right:15px;">&nbsp;<?php echo $tot2;?></td>
                             <td class="tblIsi" style="background-color:#FFFF99; font-weight:bold; text-align:right; padding-right:15px;">
                            <?php
                            if($tot1<$tot2){
                                echo 'Naik';
                                $selisih=$tot2-$tot1;
                            }
                            else if($tot1>$tot2){
                                echo 'Turun';
                                $selisih=$tot1-$tot2;
                            }
                            else{
                                echo 'Tetap';
                                $selisih=0;
                            }
                            ?></td>
                            <td class="tblIsiKn" style="background-color:#FFFF99; font-weight:bold; text-align:right; padding-right:15px;"><?php  echo number_format($selisih/$tot1*100,2,",",".");?>%</td>    
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
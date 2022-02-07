<title>Rekap Pendapatan Lain-Lain</title>
<?php
	include("../sesi.php");
    include("../koneksi/konek.php");
    
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
		$cwidthTbl=600;
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = "AND k_transaksi.tgl = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
		$cwidthTbl=600;
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
        $waktu = "AND month(k_transaksi.tgl) = '$bln' AND year(k_transaksi.tgl) = '$thn' ";
        $Periode = "Bulan $arrBln[$bln] Tahun $thn";
    }else{
		$cwidthTbl=950;
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $arrBln[$tglAwal[1]];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $tgl1=GregorianToJD($tglAwal[1],$tglAwal[0],$tglAwal[2]);
    	$tgl2=GregorianToJD($tglAkhir[1],$tglAkhir[0],$tglAkhir[2]);
    	$selisih=$tgl2-$tgl1;
        $waktu = "AND k_transaksi.tgl between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
?>
<style>
    .jdl{
        border-left: 1px solid black;
        border-top: 1px solid black;
        border-bottom: 1px solid black;
        text-align: center;
        text-transform: uppercase;
        height: 28;
        font-weight: bold;
    }
    .isi{
        border-left: 1px solid black;
        border-bottom: 1px solid black;
        height: 25;
    }
</style>
<table width="<?php echo $cwidthTbl; ?>" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;" align="left">
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
        <td height="15" valign="top" style="font-size: 14px; text-transform: uppercase; text-align: center; font-weight: bold;" align="center">&nbsp;</td>
    </tr>
    <tr>
        <td>
            <?php
                if($_REQUEST['cmbWaktu'] == 'Rentang Waktu'){
            ?>
            <table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                <tr>
                  <td colspan="<?php echo $selisih+4; ?>" class="jdl" style="border:none;font-size: 14px; text-transform: uppercase;">rekapitulasi pendapatan lain-lain<br /><?php echo $Periode;?></td>
                </tr>
                <tr>
                    <td class="jdl" width="30">no</td>
                    <td class="jdl" width="130">jenis transaksi</td>
                    <?php
        				$bln=$tglAwal[1];
        				$th=$tglAwal[2];
        				for($i=$tglAwal[0];$i<=($tglAwal[0]+$selisih);$i++)
        				{ 
        					if($th%4==0 and $th%100!=0)
        						$arrHari=array('01'=>'31','02'=>'29','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31');
        					else
        						$arrHari=array('01'=>'31','02'=>'28','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31');
        					if($i==$tglAwal[0])
        						$hari=$i;
        					else
        						$hari=$hari+1;		
        					if($hari>$arrHari[$bln])
        					{
        						$hari=$hari-$arrHari[$bln];
        						$bln=$bln+1;
        					}
        					if($bln>12)
        					{
        						$bln=$bln-12;
        						$th=$th+1;
        					}
                    ?>
                    <td width="80" class="jdl"><b><?php echo $hari;?></b></td>
                    <?php 
                            }
                    ?>
                    <td class="jdl" style="border-right: 1px solid black;" width="120">total</td>
                </tr>
                <?php
                        $sql = "SELECT DISTINCT k_ms_transaksi.id, k_ms_transaksi.nama 
                                FROM k_transaksi INNER JOIN k_ms_transaksi ON k_transaksi.id_trans = k_ms_transaksi.id 
                                WHERE k_ms_transaksi.tipe = '1' $waktu ";
                        $rs = mysql_query($sql);
						$totSum=0;
                        $no = 1;
                        while($rw = mysql_fetch_array($rs)){
                ?>
                <tr>
                    <td class="isi" style="text-align: center;"><?php echo $no;?></td>
                    <td class="isi" style="padding-left: 5px;"><?php echo $rw['nama'];?></td>
                    <?php
        					$bln=$tglAwal[1];
        					$th=$tglAwal[2];
        					$tot = 0;
        					for($i=$tglAwal[0];$i<=($tglAwal[0]+$selisih);$i++)
        					{ 
        						if($th%4==0)
        							$arrHari=array('01'=>'31','02'=>'29','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31');
        						else
        							$arrHari=array('01'=>'31','02'=>'28','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31');
        						if($i==$tglAwal[0])
        							$hari=$i;
        						else
        							$hari=$hari+1;		
        						if($hari>$arrHari[$bln])
        						{
        							$hari=$hari-$arrHari[$bln];
        							$bln=$bln+1;
        						}
        						if($bln>12)
        						{
        							$bln=$bln-12;
        							$th=$th+1;
        						}
        						$qNilai= "SELECT IFNULL(SUM(k_transaksi.nilai),0) nilai FROM k_transaksi WHERE k_transaksi.id_trans='".$rw['id']."' AND tgl=CONCAT_WS('-','$th','$bln','$hari')";
								//echo $qNilai."<br>";
                                $rsNilai = mysql_query($qNilai);
        						$rwNilai = mysql_fetch_array($rsNilai);
        			?>
                    <td class="isi" style="text-align: right; padding-right: 5px;"><?php if($rwNilai['nilai']=='') echo 0; else echo number_format($rwNilai['nilai'],0,",",".")?></td>
                    <?php
                            	$tot=$tot+$rwNilai['nilai'];
                            }
                    ?>
                    <td class="isi" style="border-right: 1px solid black; text-align: right; padding-right: 5px;"><?php echo number_format($tot,2,",",".")?></td>
                </tr>
                <?php
                    $no++;
                    }
                ?>
                <tr>
                    <td colspan="2" height="28" style="border-left: 1px solid black; border-bottom: 1px solid black; text-align: center; font-weight: bold;">TOTAL</td>
					<?php
        					$bln=$tglAwal[1];
        					$th=$tglAwal[2];
        					$tot = 0;
        					for($i=$tglAwal[0];$i<=($tglAwal[0]+$selisih);$i++)
        					{ 
        						if($th%4==0 and $th%100!=0)
        							$arrHari=array('01'=>'31','02'=>'29','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31');
        						else
        							$arrHari=array('01'=>'31','02'=>'28','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31');
        						if($i==$tglAwal[0])
        							$hari=$i;
        						else
        							$hari=$hari+1;		
        						if($hari>$arrHari[$bln])
        						{
        							$hari=$hari-$arrHari[$bln];
        							$bln=$bln+1;
        						}
        						if($bln>12)
        						{
        							$bln=$bln-12;
        							$th=$th+1;
        						}
								$qNilaiSum= "SELECT SUM(IF(k_transaksi.nilai IS NULL,0,k_transaksi.nilai)) nilai FROM k_transaksi INNER JOIN k_ms_transaksi ON k_ms_transaksi.id=k_transaksi.id_trans
WHERE tgl=CONCAT_WS('-','$th','$bln','$hari') AND k_ms_transaksi.tipe='1'";
                                $rsNilaiSum = mysql_query($qNilaiSum);
        						$rwNilaiSum = mysql_fetch_array($rsNilaiSum);
					?>
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black; text-align: right; font-weight: bold; padding-right:5px;"><?php if($rwNilaiSum['nilai']=='') echo 0; else echo number_format($rwNilaiSum['nilai'],0,",",".")?></td>
					<?php
					 	$totSum=$totSum+$rwNilaiSum['nilai'];
						}
                    ?>
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black; text-align: right; padding-right:5px; font-weight: bold; border-right: 1px solid black;"><?php echo number_format($totSum,2,",",".")?></td>
                </tr>
            </table>
        <?php
                }else{
            ?>
            <table width="600" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;" align="center">
                <tr>
                  <td colspan="3" class="jdl" style="border:none;font-size: 14px; text-transform: uppercase;">rekapitulasi pendapatan lain-lain<br /><?php echo $Periode;?></td>
                </tr>
                <tr>
                    <td class="jdl" width="30">no</td>
                    <td class="jdl">jenis transaksi</td>
                    <td class="jdl" style="border-right: 1px solid black;" width="130">total</td>
                </tr>
                <?php
                        $sql2 = "SELECT DISTINCT k_ms_transaksi.id, k_ms_transaksi.nama
                                FROM k_transaksi INNER JOIN k_ms_transaksi ON k_transaksi.id_trans = k_ms_transaksi.id 
                                WHERE k_ms_transaksi.tipe = '1' $waktu ";
						//echo $sql2."<br>";
                        $rs2 = mysql_query($sql2);
						$totSum2=0;
                        $no2 = 1;
                        while($rw2 = mysql_fetch_array($rs2)){
							$qSum2 = "SELECT SUM(IF(k_transaksi.nilai IS NULL,0,k_transaksi.nilai)) nilai FROM k_transaksi
										WHERE k_transaksi.id_trans='".$rw2['id']."' $waktu ";
							$sSum2 = mysql_query($qSum2);
							$wSum2 = mysql_fetch_array($sSum2);
                ?>
                <tr>
                    <td class="isi" style="text-align: center;"><?php echo $no2;?></td>
                    <td class="isi" style="padding-left: 5px;"><?php echo $rw2['nama'];?></td>
                    <td class="isi" style="border-right: 1px solid black; text-align: right; padding-right: 5px;"><?php echo number_format($wSum2['nilai'],2,",",".")?></td>
                </tr>
                <?php
                    $no2++;
					$totSum2 = $totSum2 + $wSum2['nilai'];
                    }
                ?>
                <tr>
                    <td colspan="2" height="28" style="border-left: 1px solid black; border-bottom: 1px solid black; text-align: center; font-weight: bold;">TOTAL</td>					
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black; text-align: right; padding-right:5px; font-weight: bold; border-right: 1px solid black;"><?php echo number_format($totSum2,2,",",".")?></td>
                </tr>
            </table>
          <?php
                }
            ?>
        </td>
    </tr>
</table>
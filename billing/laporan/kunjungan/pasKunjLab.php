<?php
session_start();
include ("../../koneksi/konek.php");
include("../../sesi.php");
//session_start();
//=====================================
$tglAwal1=explode('-',$_REQUEST['tglAwal']);
$tglAwal=$tglAwal1[2]."-".$tglAwal1[1]."-".$tglAwal1[0];
$tglAkhir1=explode('-',$_REQUEST['tglAkhir']);
$tglAkhir=$tglAkhir1[2]."-".$tglAkhir1[1]."-".$tglAkhir1[0];
$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$jnsLayanan = $_POST['JnsLayanan'];
$tmpLayanan = $_REQUEST['TmpLayanan'];
$id = $tmpLayanan;
$fKso = '';
if($_REQUEST['StatusPas']!=0) {
    $fKso = " AND p.kso_id = ".$_REQUEST['StatusPas'];
    $status = "select nama from b_ms_kso where id = ".$_POST['StatusPas'];
    $status = mysql_query($status);
    $status = mysql_fetch_array($status);mysql_free_result($status);
    $status = $status['nama'];
	
}
else{
    $status = 'semua';
}
if($tmpLayanan == 0) {
    $id = $jnsLayanan;
    $fTmp = " p.jenis_layanan = $jnsLayanan ";
}
else {
    $fTmp = " p.unit_id = $tmpLayanan ";
}
$query = "select nama from b_ms_unit where id = $id";
$qUnit=mysql_query($query);
$rwUnit=mysql_fetch_array($qUnit);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>.: Laporan Kunjungan :.</title>
    </head>

    <body>
        <table width="750" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
             <tr id="trTombol1">
                <td colspan="2" class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak();"/>
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
                </td>
            </tr>
            <tr>
                <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
            </tr>
            <tr>
                <td valign="top" align="center" style="font-weight:bold; text-transform:uppercase; font-size:12px;" height="75">laporan kunjungan <?php echo $rwUnit['nama']; ?><br />status pasien <?php echo $status; ?><br/>periode <?php echo $tglAwal1[0]." ".$arrBln[$tglAwal1[1]]." ".$tglAwal1[2]." s/d ".$tglAkhir1[0]." ".$arrBln[$tglAkhir1[1]]." ".$tglAkhir1[2];?>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="text-transform:capitalize;">
                        <tr style="font-size: 10px; font-weight:bold; text-transform:uppercase">
                            <td width="5%" align="center" style="border:#FF99FF 1px solid;" height="28">No</td>
                            <td width="10%" align="center" style="border:#FF99FF 1px solid; border-left:none">No RM</td>
                            <td width="10%" align="center" style="border:#FF99FF 1px solid; border-left:none">Waktu</td>
                            <td width="25%" align="center" style="border:#FF99FF 1px solid; border-left:none">Nama Pasien</td>
                            <td width="20%" align="center" style="border:#FF99FF 1px solid; border-left:none">Alamat</td>
                            <td width="15%" align="center" style="border:#FF99FF 1px solid; border-left: none">Status Pasien</td>
                            <td width="15%" align="center" style="border:#FF99FF 1px solid; border-left:none">Tempat Layanan</td>
                        </tr>
                        <?php
                        $query = "SELECT mp.nama,mp.no_rm,mp.alamat,DATE_FORMAT(p.tgl_act,'%d-%m-%Y %H:%i') wkt,mu.nama nmUnit, kso.nama as kso_nama
                        FROM b_pelayanan p LEFT JOIN b_ms_unit mu ON p.unit_id_asal=mu.id
                        inner join b_kunjungan k on p.kunjungan_id = k.id
                        inner join b_ms_kso kso on p.kso_id = kso.id
                        INNER JOIN b_ms_pasien mp ON p.pasien_id=mp.id
                        WHERE $fTmp $fKso and p.tgl BETWEEN '$tglAwal' AND '$tglAkhir'
                        group by p.id
						order by p.tgl_act";
                                                
                        $qPas=mysql_query($query);
                        while($rwPas=mysql_fetch_array($qPas)) {
                            $i++;
                            ?>
                        <tr>
                            <td align="center" style="font-size: 10px; border-bottom:#FF99FF solid 1px; border-left:#FF99FF 1px solid; border-right:#FF99FF 1px solid">
                                &nbsp;
                                    <?php
                                    echo $i;
                                    ?>                            </td>
                            <td align="center" style="font-size: 10px; border-bottom:#FF99FF solid 1px; border-right:#FF99FF 1px solid">
                                    <?php
                                    echo $rwPas['no_rm'];
                                    ?>                            </td>
                            <td align="center" style="font-size: 10px; border-bottom:#FF99FF solid 1px; border-right:#FF99FF 1px solid">
                                    <?php
                                    echo $rwPas['wkt'];
                                    ?>                            </td>
                            <td align="left" style="font-size: 10px; border-bottom:#FF99FF solid 1px; border-right:#FF99FF 1px solid; padding-left:5px; text-transform:uppercase;">
                                    <?php
                                    echo $rwPas['nama'];
                                    ?>                            </td>
                            <td align="left" style="font-size: 10px; border-bottom:#FF99FF solid 1px; border-right:#FF99FF 1px solid; padding-left:5px; text-transform:uppercase;">
                                    <?php
                                    echo $rwPas['alamat'];
                                    ?>                            </td>
                            <td align="center" style="font-size: 10px; border-bottom:#FF99FF solid 1px; border-right: #FF99FF 1px solid; text-transform:uppercase;">
                                &nbsp;
                                    <?php
                                    echo $rwPas['kso_nama'];
                                    ?>                            </td>
                            <td align="center" style="font-size: 10px; border-bottom:#FF99FF solid 1px; border-right:#FF99FF 1px solid; text-transform:uppercase;">
                                &nbsp;
                                    <?php
                                    if($rwPas['nmUnit']=='') echo $rwUnit['nama']; else echo $rwPas['nmUnit'];
                                    ?>                            </td>
                        </tr>
                            <?php
                        }
                        ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <table>
                    <?php
                    	$query = "SELECT kso.nama AS kso_nama, COUNT(p.id) AS jml FROM b_kunjungan k 
								INNER JOIN b_pelayanan p ON p.kunjungan_id=k.id
								INNER JOIN b_ms_kso kso ON kso.id=p.kso_id
								WHERE $fTmp $fKso and p.tgl BETWEEN '$tglAwal' AND '$tglAkhir' GROUP BY kso.id";
                        $rs = mysql_query($query);
                        $jml = 0;
                        while($row = mysql_fetch_array($rs)){
                            echo "<tr><td style='font-size:11px' width='300'>Jumlah Pasien ".$row['kso_nama']." </td><td style='font-size:11px' width='100px'><span style='float:left'>:</span> <span style='float:right'>".$row['jml']."</span><td><td width='600'>&nbsp;</td></tr>";
                            $jml += $row['jml'];
                        }
                    ?>
                    <tr>
                        <td style="font-size: 12px; font-weight: bold">
                            Jumlah Total Pasien
                        </td>
                        <td style="font-size: 11px">
                            <span style='float:left'>:</span> <?php
                            echo  "<span style='float:right'>$jml</span>";
                            ?>
                        </td>
                    </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr id="trTombol">
                <td colspan="2" class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak();"/>
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
                </td>
            </tr>
        </table>
<?php
	mysql_free_result($qUnit);
	mysql_free_result($qPas);
	mysql_free_result($rs);
	mysql_close($konek);
?>
         <script type="text/JavaScript">

            function cetak(){
                var tombol=document.getElementById('trTombol').style.visibility='collapse';
                var tombol1=document.getElementById('trTombol1').style.visibility='collapse';
                if(tombol=='collapse' || tombol1=='collapse'){
                    
                        window.print();
                        window.close();
                   

                }
            }
        </script>
    </body>
</html>
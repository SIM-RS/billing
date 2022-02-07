<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
include '../koneksi/konek.php';
include '../theme/numberConversion.php';

$kunjungan_id = $_GET['kunjungan_id'];
$userId = $_GET['idUser'];

    $bayarId = $_GET['idbayar'];
    
	$query="SELECT p.no_rm,p.nama,b.kunjungan_id,b.dibayaroleh,b.nilai,b.keringanan,b.titipan,b.tagihan,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,DATE_FORMAT(IFNULL(k.tgl_pulang,NOW()),'%d-%m-%Y') AS tgl_pulang FROM b_bayar b INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id INNER JOIN b_ms_pasien p ON k.pasien_id=p.id WHERE b.id=$bayarId";
    //echo $query."<br>";
        //, beban_pasien, beban_kso inner join b_tindakan_kamar tk on tk.pelayanan_id = pe.id
    $rs = mysql_query($query);
    $row = mysql_fetch_array($rs);

    $tgl = $row['tgl'];
    $tgl_pulang = $row['tgl_pulang'];
    $nama_pasien = $row['nama'];
	$no_rm = $row['no_rm'];
	$dibayaroleh=$row['dibayaroleh'];
	if ($dibayaroleh=="") $dibayaroleh=$nama_pasien;
	$kunjId=$row['kunjungan_id'];
	$biayaTot=$row['tagihan'];
	$bayar=$row['nilai'];
	$keringanan=$row['keringanan'];
	$titipan=$row['titipan'];
	$cbiaya=0;
	
	$sql="SELECT tk.id idtk,p.id,mu.nama,mk.nama nama_kelas,
IF(status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in))), 
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))) AS qtyHari, 
IF(status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso+beban_pasien), 
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso+beban_pasien)) AS biayaKamar, 
IF(status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso), 
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso)) AS biayaKSO 
FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id INNER JOIN b_ms_kelas mk ON p.kelas_id=mk.id 
INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id WHERE p.kunjungan_id=$kunjId AND mu.inap=1";
	//echo $sql."<br>";
    $rs = mysql_query($sql);
	$nama_unit="";
	$nama_kelas="";
	$lama_dirawat=0;
	$biayaKamar=0;
	$byrKamar=0;
	$biayaKSO=0;
	//$lama_dirawat = $row['qtyHari'];
    while ($row = mysql_fetch_array($rs)){
		$nama_unit .= $row['nama'].",";
		$nama_kelas .= $row['nama_kelas'].",";
		$lama_dirawat += $row['qtyHari'];
		$biayaKamar += $row['biayaKamar'];
		$biayaKSO += $row['biayaKSO'];
		$sql="SELECT bt.* FROM b_bayar_tindakan bt INNER JOIN b_tindakan_kamar tk ON bt.tindakan_id=tk.id WHERE bt.tipe=1 AND tk.id=".$row['idtk']." AND bt.bayar_id<$bayarId";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			$rw1=mysql_fetch_array($rs1);
			$byrKamar=$rw1['nilai'];
		}
	}
	
	$sqlLamadiRawt="SELECT DATEDIFF(IFNULL(k.tgl_pulang,NOW()),p.tgl) AS jmlhari FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id=$kunjId AND mu.inap=1 ORDER BY p.id LIMIT 1";
	$rsdrwt=mysql_query($sqlLamadiRawt);
	$rwdrwt=mysql_fetch_array($rsdrwt);
	$lama_dirawat=$rwdrwt['jmlhari'];
	$nama_unit=substr($nama_unit,0,strlen($nama_unit)-1);
	$nama_kelas=substr($nama_kelas,0,strlen($nama_kelas)-1);
	$cbiaya +=$biayaKamar;

	$sql="SELECT IFNULL(SUM(t.qty*t.biaya_kso),0) AS biayaKSO 
FROM b_tindakan t INNER JOIN b_bayar_tindakan bt ON t.id=bt.tindakan_id
INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
WHERE bt.bayar_id=$bayarId AND bt.tipe=0";
	//echo $sql."<br>";
    $rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	$biayaKSO += $row['biayaKSO'];
	
//to get staying fee
	$bilangan=$bayar;
	$bilangan=terbilang($bilangan,3);
  	//=====Bilangan setelah koma=====
  	$sakKomane=explode(".",$bayar);
  	$koma=$sakKomane[1];
  	$koma=terbilang($koma,3);
  	if($sakKomane[1]<>"") $koma= "Koma ".$koma;

//to get officer's name
$query = "select nama from b_ms_pegawai where id = '$userId'";
$rs = mysql_query($query);
$rowPetugas = mysql_fetch_array($rs);

mysql_free_result($rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link type="text/css" rel="stylesheet" href="../theme/print.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/formatPrint.js"></script>
        <title>Kwitansi Kurang Bayar</title>
    </head>
<?php
        $printer = $_REQUEST['kasir'];       
        if($printer!='83'){ //untuk selain printer di kasir rawat jalan
            $lebar='1200';
        }else{
            $lebar='650';// khusus printer besar di kasir rawat jalan.
        }
        ?>
    <body>
        <table width="<?php echo $lebar;?>" class="kwi" border="0" cellpadding="1" cellspacing="0" style="font-size:12px;">
            <tr id="header1">
                <td colspan="7" align="center" style="font-size:16px;padding-top:10px;">
                    <?=$pemkabRS?>                </td>
            </tr>
            <tr id="header2">
                <td colspan="7" align="center" style="font-weight:bold; font-size:20px">
                    <?php echo strtoupper($namaRS);?>                </td>
            </tr>
            <tr id="header3">
                <td colspan="7" align="center" style="text-decoration:underline; font-size:16px">
                    <?php echo $alamatRS.", Telp. ".$tlpRS;?>                </td>
            </tr>
            <tr>
                <td width="22%" style="font-size:14px;padding-top:1px;">
                    Sudah terima dari                </td>
                <td width="50%" colspan="6" style="">
                    :&nbsp;<strong style="text-transform: uppercase"><?php echo $dibayaroleh;?></strong>                </td>
            </tr>
            <tr>
                <td style="">
                    Banyak Uang                </td>
                <td colspan="6" style="">
                    : Rp. <?php echo number_format($bayar,0,",",".")."<br>&nbsp;&nbsp;".$bilangan." ".$koma." Rupiah";?></td>
            </tr>
            <tr>
                <td valign="top" style="">
                    Untuk Pembayaran                </td>
                <td colspan="6" >
                    :&nbsp;Biaya pemeriksaan dan perawatan A.n. <?php echo $nama_pasien;?><br/>
                    &nbsp;&nbsp;dirawat di ruang : <?php echo $nama_unit;?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kelas : <?php echo $nama_kelas;?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. RM : <?php echo $no_rm;?>
                    <br/>
                    &nbsp;&nbsp;selama : <?php echo $lama_dirawat.' hari &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$tgl.' s.d '.$tgl_pulang;?>
                    <br/>
                    &nbsp;&nbsp;(Biaya Pemeriksaan dan Perawatan yang harus dibayar keseluruhan <br />&nbsp;&nbsp;Rp. <?php echo number_format($biayaTot,0,",",".");?>)</td>
            </tr>
            <tr>
            <td colspan="7">&nbsp;</td>
            </tr>
            <?php if ($keringanan>0){?>
            <tr>
                <td>Keringanan</td>
                <td width="50%">: Rp. <?php echo number_format($keringanan,0,",",".");?></td>
                <td width="50%" align="right">&nbsp;</td>
                <td width="50%">&nbsp;</td>
                <td width="50%" style="">&nbsp;</td>
                <td width="50%" align="left">&nbsp;</td>
                <td align="right">&nbsp;</td>
            </tr>
            <?php }?>
            <tr>
                <td style="">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td  align="right">&nbsp;</td>
                <td colspan="4">&nbsp;</td>                
            </tr>
            <tr>
                <td style="">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td  align="right">&nbsp;</td>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td style=""><b>Keterangan :</b></td>
                <td align="left">&nbsp;</td>
                <td align="right">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="7" align="left">Masih ada kekurangan biaya perawatan sebesar Rp. <?php echo number_format(($biayaTot-$bayar-$keringanan),0,",",".");?></td>
            </tr>
            
            <tr>
              <td colspan="7" style="padding-top: 5px; font-size: 14px" align="right">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="7" style="padding-top: 5px; font-size: 14px" align="right">Tanggal cetak&nbsp;&nbsp;<?php echo $date_now=gmdate('d-m-Y H:i',mktime(date('H')+7))." Jam ".gmdate('H:i',mktime(date('H')+7));?></td>
            </tr>
            <tr>
                <td colspan="7" style="padding-top: 2px; font-size: 14px" align="right">Petugas Cetak</td>
            </tr>
            <tr>                
                <td colspan="7" style="padding-top: 30px; font-size: 14px" align="right"><?php echo $rowPetugas['nama'];?></td>
            </tr>
            <tr id="trTombol">
                <td colspan="7" class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();" /></td>
            </tr>
        </table>
</body>
    <script language="JavaScript" type="text/JavaScript">
        try{
	formatTagihan();
	}catch(e){
	window.location='../addon/jsprintsetup.xpi';
	}
        
        function cetak(tombol){
            tombol.style.visibility='collapse';
            document.getElementById('header1').style.visibility = 'hidden';
            document.getElementById('header2').style.visibility = 'hidden';
            document.getElementById('header3').style.visibility = 'hidden';
           
            if(tombol.style.visibility=='collapse'){
                //if(confirm('Anda Yakin Mau Mencetak Tagihan ?')){
                    //window.print();
                    //setTimeout('window.close()','2000');
                    try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		}
            }
        }
    </script>
</html>
<?php 
mysql_close($konek);
?>
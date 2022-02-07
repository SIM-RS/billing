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
    
	$query="SELECT p.no_rm,p.nama,k.id kunjungan_id,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,DATE_FORMAT(IFNULL(k.tgl_pulang,NOW()),'%d-%m-%Y') AS tgl_pulang FROM b_kunjungan k INNER JOIN b_ms_pasien p ON k.pasien_id=p.id WHERE k.id=$kunjungan_id";
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
	
	$stylekw='';
	
	$fkunj=" AND p.jenis_kunjungan=3";
	
	$sql="SELECT IFNULL(SUM((t.biaya_kso+t.biaya_pasien)*t.qty),0) AS tagihan,IFNULL(SUM(t.bayar_pasien),0) AS bayar 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
WHERE p.kunjungan_id=$kunjId".$fkunj;
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$rw=mysql_fetch_array($rs);
	$biayaTot=$rw['tagihan'];
	$bayar=$rw['bayar'];
	
	$stylekw=' style="visibility:collapse"';

	$sql="SELECT tk.id idtk,p.id,mu.nama,mk.nama nama_kelas,
IF(status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in))), 
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))) AS qtyHari, 
IF(status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso+beban_pasien), 
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso+beban_pasien)) AS biayaKamar, 
IF(status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso), 
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso)) AS biayaKSO 
FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_ms_kelas mk ON p.kelas_id=mk.id 
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
	
	$biayaTot+=$biayaKamar;
	
	$sqlLamadiRawt="SELECT DATEDIFF(IFNULL(k.tgl_pulang,NOW()),p.tgl) AS jmlhari FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id=$kunjId AND mu.inap=1 ORDER BY p.id LIMIT 1";
	$rsdrwt=mysql_query($sqlLamadiRawt);
	$rwdrwt=mysql_fetch_array($rsdrwt);
	$lama_dirawat=($rwdrwt['jmlhari']==0)?1:$rwdrwt['jmlhari'];
	$nama_unit=substr($nama_unit,0,strlen($nama_unit)-1);
	$nama_kelas=substr($nama_kelas,0,strlen($nama_kelas)-1);
	$cbiaya +=$biayaKamar;
	
	$sql="SELECT IFNULL(SUM(t.qty*t.biaya_kso),0) AS biayaKSO 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
WHERE p.kunjungan_id=$kunjId".$fkunj;
	//echo $sql."<br>";
    $rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	$biayaKSO += $row['biayaKSO'];
	
//to get staying fee
//to get lab fee
    $query = "SELECT IFNULL(SUM(t.biaya_kso+t.biaya_pasien),0) AS biayaLab,IFNULL(SUM(t.biaya_kso),0) AS biayaLabKSO 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
WHERE p.kunjungan_id=$kunjId AND mu.parent_id=57".$fkunj;
	//echo $query."<br>";
    $rs = mysql_query($query);
    $rowDetil = mysql_fetch_array($rs);
    $biayaLab = $rowDetil['biayaLab'];
    //$biayaKSO += $rowDetil['biayaLabKSO'];
	$cbiaya +=$biayaLab;

//to get rad fee
    $query = "SELECT IFNULL(SUM(t.biaya_kso+t.biaya_pasien),0) AS biayaRad,IFNULL(SUM(t.biaya_kso),0) AS biayaRadKSO 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
WHERE p.kunjungan_id=$kunjId AND mu.parent_id=60".$fkunj;
	//echo $query."<br>";
    $rs = mysql_query($query);
    $rowDetil = mysql_fetch_array($rs);
    $biayaRad = $rowDetil['biayaRad'];
    //$biayaRadKSO = $rowDetil['biayaRadKSO'];
	$cbiaya +=$biayaRad;

/*//to get usg fee
    $query = "SELECT IFNULL(SUM(t.biaya_kso+t.biaya_pasien),0) AS biayaUSG,IFNULL(SUM(t.biaya_kso),0) AS biayaUSGKSO 
FROM b_tindakan t INNER JOIN b_bayar_tindakan bt ON t.id=bt.tindakan_id INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
INNER JOIN b_ms_tindakan_kelas tk ON t.ms_tindakan_kelas_id = tk.id INNER JOIN b_ms_tindakan mt ON tk.ms_tindakan_id = mt.id
WHERE bt.bayar_id=$bayarId AND bt.tipe=0 AND mt.nama LIKE '%usg%'";
	//echo $query."<br>";
    $rs = mysql_query($query);
    $rowDetil = mysql_fetch_array($rs);
    $biayaUSG = $rowDetil['biayaUSG'];
    //$biayaUSGKSO = $rowDetil['biayaUSGKSO'];
	$cbiaya +=$biayaUSG;*/

//to get HD fee
    $query = "SELECT IFNULL(SUM(t.biaya_kso+t.biaya_pasien),0) AS biayaHD,IFNULL(SUM(t.biaya_kso),0) AS biayaHDKSO 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
WHERE p.kunjungan_id=$kunjId AND p.unit_id=65".$fkunj;
	//echo $query."<br>";
    $rs = mysql_query($query);
    $rowDetil = mysql_fetch_array($rs);
    $biayaHD = $rowDetil['biayaHD'];
    //$biayaUSGKSO = $rowDetil['biayaUSGKSO'];
	$cbiaya +=$biayaHD;

//to get endoscopy fee
    $query = "SELECT IFNULL(SUM(t.biaya_kso+t.biaya_pasien),0) AS biayaEND,IFNULL(SUM(t.biaya_kso),0) AS biayaENDKSO 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
WHERE p.kunjungan_id=$kunjId AND mu.parent_id=66".$fkunj;
	//echo $query."<br>";
    $rs = mysql_query($query);
    $rowDetil = mysql_fetch_array($rs);
    $biayaEND = $rowDetil['biayaEND'];
    //$biayaENDKSO = $rowDetil['biayaENDKSO'];
	$cbiaya +=$biayaEND;

//to get operation fee
	$query = "SELECT SUM(t1.biayaOP) biayaOP,SUM(t1.biayaOPKSO) biayaOPKSO FROM (
SELECT tk.ms_tindakan_id,IFNULL((t.biaya_kso+t.biaya_pasien),0) AS biayaOP,IFNULL((t.biaya_kso),0) AS biayaOPKSO 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
INNER JOIN b_ms_tindakan_kelas tk ON t.ms_tindakan_kelas_id = tk.id 
WHERE p.kunjungan_id=$kunjId".$fkunj.") AS t1 INNER JOIN (SELECT DISTINCT ms_tindakan_id FROM b_ms_tindakan_operasi) mto ON t1.ms_tindakan_id = mto.ms_tindakan_id";
	//echo $query."<br>";
    $rs = mysql_query($query);
    $rowDetil = mysql_fetch_array($rs);
    $biayaOP = $rowDetil['biayaOP'];
    //$biayaOPKSO = $rowDetil['biayaOPKSO'];
	$cbiaya +=$biayaOP;

//to get visite fee
    $query = "SELECT IFNULL(SUM(t.biaya_kso+t.biaya_pasien),0) AS biayaVisit,IFNULL(SUM(t.biaya_kso),0) AS biayaVisitKSO 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
INNER JOIN b_ms_tindakan_kelas tk ON t.ms_tindakan_kelas_id = tk.id
INNER JOIN b_ms_tindakan mt ON tk.ms_tindakan_id = mt.id
WHERE p.kunjungan_id=$kunjId AND mt.klasifikasi_id=13".$fkunj;
	//echo $query."<br>";
    $rs = mysql_query($query);
    $rowDetil = mysql_fetch_array($rs);
    $biayaVisit = $rowDetil['biayaVisit'];
    //$biayaVisitKSO = $rowDetil['biayaVisitKSO'];
	$cbiaya +=$biayaVisit;

//to get consul fee
    $query = "SELECT IFNULL(SUM(t.biaya_kso+t.biaya_pasien),0) AS biayaKonsul,IFNULL(SUM(t.biaya_kso),0) AS biayaKonsulKSO 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
INNER JOIN b_ms_tindakan_kelas tk ON t.ms_tindakan_kelas_id = tk.id
INNER JOIN b_ms_tindakan mt ON tk.ms_tindakan_id = mt.id
WHERE p.kunjungan_id=$kunjId AND mt.klasifikasi_id=14".$fkunj;
	//echo $query."<br>";
    $rs = mysql_query($query);
    $rowDetil = mysql_fetch_array($rs);
    $biayaKonsul = $rowDetil['biayaKonsul'];
    //$biayaKonsulKSO = $rowDetil['biayaKonsulKSO'];
	$cbiaya +=$biayaKonsul;

//to get medical rehab fee
    $query = "SELECT IFNULL(SUM(t.biaya_kso+t.biaya_pasien),0) AS biayaMed,IFNULL(SUM(t.biaya_kso),0) AS biayaMedKSO 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
WHERE p.kunjungan_id=$kunjId AND p.unit_id=16".$fkunj;
	//echo $query."<br>";
    $rs = mysql_query($query);
    $rowDetil = mysql_fetch_array($rs);
    $biayaMed = $rowDetil['biayaMed'];
    //$biayaMedKSO = $rowDetil['biayaMedKSO'];
	$cbiaya +=$biayaMed;

//to get persalinan fee
    $query = "SELECT IFNULL(SUM(t.biaya_kso+t.biaya_pasien),0) AS biayaSalin,IFNULL(SUM(t.biaya_kso),0) AS biayaSalinKSO 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
INNER JOIN b_ms_tindakan_kelas tk ON t.ms_tindakan_kelas_id = tk.id
INNER JOIN b_ms_tindakan mt ON tk.ms_tindakan_id = mt.id
WHERE p.kunjungan_id=$kunjId AND mt.nama LIKE '%salin%' AND mt.klasifikasi_id=1".$fkunj;
	//echo $query."<br>";
    $rs = mysql_query($query);
    $rowDetil = mysql_fetch_array($rs);
    $biayaSalin = $rowDetil['biayaSalin'];
    //$biayaSalinKSO = $rowDetil['biayaSalinKSO'];
	$cbiaya +=$biayaSalin;

    //to get other medical treatment
	$biayaLain=$biayaTot-$cbiaya;
    $dibayar = 0;
//}

	//$kurangBayar = $biayaTot-($keringanan+$titipan+$bayar+$biayaKSO+$byrKamar);
	$kurangBayar = $biayaTot-($keringanan+$titipan+$bayar+$biayaKSO);
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
        <title>Tagihan Pasien</title>
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
            <tr<?php echo $stylekw; ?>>
                <td width="22%" style="font-size:14px;padding-top:1px;">
                    Sudah terima dari                </td>
                <td width="50%" colspan="6" style="">
                    :&nbsp;<strong style="text-transform: uppercase"><?php echo $dibayaroleh;?></strong>                </td>
            </tr>
            <tr<?php echo $stylekw; ?>>
                <td style="">
                    Banyak Uang</td>
                <td colspan="6" style="">
                    : <?php echo $bilangan." ".$koma." Rupiah";?></td>
            </tr>
            <?php 
			if ($bayarId==0 || $bayarId==""){
			?>
            <tr>
                <td style="">&nbsp;</td>
                <td colspan="6" style="">&nbsp;</td>
            </tr>
            <?php 
			}
			?>
            <tr>
                <td valign="top" style="">
                    Tagihan Pembayaran                </td>
                <td colspan="6" >
                    :&nbsp;Biaya pemeriksaan dan perawatan A.n. <?php echo $nama_pasien;?><br/>
                    &nbsp;&nbsp;dirawat di ruang : <?php echo $nama_unit;?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kelas : <?php echo $nama_kelas;?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. RM : <?php echo $no_rm;?>
                    <br/>
                    &nbsp;&nbsp;selama : <?php echo $lama_dirawat.' hari &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$tgl.' s.d '.$tgl_pulang;?>
                    <br/>
                    &nbsp;&nbsp;Tarif Rp. <?php echo number_format($biayaTot,0,",",".");?> dengan rincian :                </td>
            </tr>
            <tr>
            <td colspan="7">&nbsp;</td>
            </tr>
            <tr>
                <td style="">
                    <?php echo 'Perawatan '.$lama_dirawat.' hari';?>                </td>
                <td width="3%" style="">
                    :&nbsp;Rp.                    </td>
                <td width="" align="right">
                    <?php echo number_format($biayaKamar,0,",",".");?>                </td>
                <td width="1%">&nbsp;</td>
                <td width="20%" style="">
                    Tindakan Rehab Medik                </td>
                <td width="3%" align="left">
                    :&nbsp;Rp.                </td>
                <td align="right">
                    <?php echo number_format($biayaMed,0,",",".");?>                </td>
            </tr>
            <tr>
                <td style="">
                    Pemeriksaan laborat                </td>
                <td align="left">:&nbsp;Rp.</td>
                <td align="right"><?php echo number_format($biayaLab,0,",",".");?></td>
                <td>&nbsp;</td>
                <td style="">
                    Tindakan medik lain                </td>
                <td align="left">:&nbsp;Rp.</td>
                <td align="right" ><?php echo number_format($biayaLain,0,",",".");?></td>
            </tr>
            <tr>
                <td style="">
                    Pemeriksaan Radiologi                </td>
                <td align="left">:&nbsp;Rp.</td>
                    <td align="right"><?php echo number_format($biayaRad,0,",",".");?></td>
                <td>&nbsp;                </td>
                <td style="">
                    Visite                </td>
                <td align="left">:&nbsp;Rp.</td>
                    <td align="right"><?php echo number_format($biayaVisit,0,",",".");?></td>
            </tr>
            <tr>
                <td style="">
                    Pemeriksaan Hemodialisa</td>
                <td align="left">:&nbsp;Rp.</td>
                    <td  align="right"><?php echo number_format($biayaHD,0,",",".");?></td>
                <td>&nbsp;                </td>
                <td style="">
                    Konsul Dokter                </td>
                <td align="left">:&nbsp;Rp.</td>
                    <td  align="right"><?php echo number_format($biayaKonsul,0,",",".");?></td>
            </tr>
            <!--tr>
                <td style="">
                    Pemeriksaan USG/UKG                </td>
                <td align="left">:&nbsp;Rp.</td>
                    <td  align="right">< ?php echo number_format($biayaUSG,0,",",".");?></td>
                <td>&nbsp;                </td>
                <td style="">
                    Konsul Dokter                </td>
                <td align="left">:&nbsp;Rp.</td>
                    <td  align="right">< ?php echo number_format($biayaKonsul,0,",",".");?></td>
            </tr-->
            <tr>
                <td style="">
                    Pemeriksaan ECG/Endoscopy                </td>
                <td align="left">:&nbsp;Rp.</td>
                <td  align="right"><?php echo number_format($biayaEND,0,",",".");?></td>
                <td colspan="4"></td>                
            </tr>
            <tr>
                <td style="">
                    Tindakan Operasi<br />(sederhana, kecil, sedang, besar)                </td>
                <td align="left">:&nbsp;Rp.</td>
                <td  align="right"><?php echo number_format($biayaOP,0,",",".");?></td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td style="">
                    Persalinan (normal/abnormal)                </td>
                <td align="left">:&nbsp;Rp.</td>
                    <td  align="right"><?php echo number_format($biayaSalin,0,",",".");?></td>
                <td></td>
                <td style="border-top: 1px solid black; font-size: 14px" align="right">Jumlah</td>
                 <td style="border-top: 1px solid black; font-size: 14px; float:left;">:&nbsp;Rp.</td>
                    <td  align="right"><?php echo number_format($biayaTot,0,",",".");?></td>
            </tr>
            
            <?php 
			if ($keringanan>0){
			?>
            <tr>              
              <td colspan="5" style="border-bottom: 1px solid black; font-size: 14px" align="right">Keringanan</td>
              <td style="border-bottom: 1px solid black; font-size: 14px">:&nbsp;Rp.</td>
            <td  align="right"><?php echo number_format($keringanan,0,",",".");?></td>
            </tr>
            <?php }?>
            <?php 
			if ($titipan>0){
			?>
            <tr>
              <td colspan="5" style="border-bottom: 1px solid black; font-size: 14px" align="right">Titipan</td>
              <td style="border-bottom: 1px solid black; font-size: 14px">
              	:&nbsp;Rp.</td>
                <td  align="right"><?php echo number_format($titipan,0,",",".");?></td>
            </tr>
            <?php }?>
            <?php 
			if ($biayaKSO>0){
			?>
            <tr style="visibility:collapse">              
              <td colspan="5" style="border-bottom: 1px solid black; font-size: 14px" align="right">Dijamin KSO</td>
              <td style="border-bottom: 1px solid black; font-size: 14px">
              	:&nbsp;Rp.</td>
                <td  align="right"><?php echo number_format($biayaKSO,0,",",".");?></td>
            </tr>
            <?php }?>
            <tr style="visibility:collapse">
                <td colspan="5" style="border-bottom: 1px solid black; font-size: 14px" align="right">
                    Dibayar                </td>
                <td style="border-bottom: 1px solid black; font-size: 14px">
                    :&nbsp;Rp.</td>
                    <td  align="right"><?php echo number_format($bayar,0,",",".");?></td>
            </tr>
            <tr style="visibility:collapse">
                <td colspan="5" align="right" style="">
                    Kurang Bayar                </td>
                <td style="">
                    :&nbsp;Rp.</span>
                    <td  align="right"><?php echo number_format($kurangBayar,0,",",".");?></td>
            </tr>
            <tr>
                
                <td colspan="7" style="padding-top: 5px; font-size: 14px" colspan="2" align="right">
                    Tanggal cetak 
                    <?php
                    echo $date = date('d-m-Y').' Jam '.date('H:i');
                    ?>                </td>
            </tr>
            <tr>
                <td colspan="7" style="padding-top: 2px; font-size: 14px" colspan="2" align="right">
                    Petugas Cetak                </td>
            </tr>
            <tr>                
                <td colspan="7" style="padding-top: 20px; font-size: 14px" colspan="2" align="right">
                    <?php echo $rowPetugas['nama'];?>                </td>
            </tr>
            <tr id="trTombol">
                <td colspan="7" class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();" />                </td>
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
                    
                /*}
                else{
                    tombol.style.visibility='visible';
                    document.getElementById('header1').style.visibility = 'visible';
                    document.getElementById('header2').style.visibility = 'visible';
                    document.getElementById('header3').style.visibility = 'visible';
                    
                }*/

            }
        }
    </script>
</html>
<?php 
mysql_close($konek);
?>
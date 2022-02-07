<?php
session_start();
if($_REQUEST['excel']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="penerimaan_pasien.xls"');
}
include "../sesi.php";
include("../koneksi/konek.php");
$th=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_s=$_REQUEST["tgl_s"];
if ($tgl_s=="") $tgl_s="01-01-".substr($th,6,4);
$cbln=(substr($tgl_s,3,1)=="0")?substr($tgl_s,4,1):substr($tgl_s,3,2);
$cthn=substr($tgl_s,6,4);
$tgl_d=$_REQUEST["tgl_d"];
if ($tgl_d=="") $tgl_d=$th;
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$th=explode("-",$th);
$ta=$_REQUEST['ta'];
if ($ta=="") $ta=$th[2];
$bulan=$_REQUEST["bulan"];

if ($bulan==""){
  $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
}

$id=$_REQUEST["id"];
$it=$_REQUEST["it"];
$iunit=$_REQUEST["iunit"];
if ($iunit==""){
  $iunit=$idunit."|".$usrname;
}else{
  $usrname=explode("|",$iunit);
  $usrname=$usrname[1];
}

$dsp_view="none";
$dsp_export="table-row";
$tampilback=0;

//laba rugi

$ta_lr=$_REQUEST['ta_lr'];

if ($ta_lr=="") $ta_lr=$th[2];

$bulan_l=$_REQUEST["bulan_lr"];
$bulan_ll=explode("|",$bulan_l);



$bulan_lr=$bulan_ll[0];
$nm_bulan=$bulan_ll[1];
$title_tgl =" BULAN $nm_bulan $ta_lr";


if ($bulan_lr==""){
  $bulan_lr=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
}
$a=1;

//$title_tgl=$_REQUEST["bulan_lr"];

// end laba rugi

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<script type="text/javascript" src="../include/js/jquery-1.7.2.min.js"></script>
<script type="text/JavaScript" language="JavaScript" src="../include/js/jquery-1.9.1.js"></script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Rugi Laba</title>
</head>

<body>
<style>

tr a{
text-decoration:none;
color:#000000;
}

.tblheaderkiri {
  border: 1px solid #003520;
  background-color: #CCCCCC;
}

.tblheader {
  border-top: 1px solid #003520;
  border-right: 1px solid #003520;
  border-bottom: 1px solid #003520;
  border-left: none;
  background-color: #CCCCCC;
}

.tblfooterkiri {
  border: 1px solid #003520;
}

.tblfooter{
  border-top: 1px solid #003520;
  border-right: 1px solid #003520;
  border-bottom: 1px solid #003520;
  border-left: none;
}
.jumlah {
  border-top: 1px dashed #003520;

  border-bottom: 1px dashed #003520;
  border-right: 1px solid #203C42;

}

.tdisi {
  border-top: none;
  border-right: 1px solid #203C42;
  border-left: none;
  /*font-size: 11px;
  /*text-align: left;*/
}
.tdisikiri {
  border-top: none;
  border-right: 1px solid #203C42;
  border-left: 1px solid #203C42;
}
.tdisibawah{
  border-top: 1px solid #003520;
  border-bottom: 1px solid #003520;
  border-right: 1px solid #003520;
}
table, td {
   padding-right:2px;
}

</style>



  <?php 
    $sak_sap=$_REQUEST["sak_sap"];
    if ($sak_sap=="") $sak_sap="1";
    if ($sak_sap=="1"){
      $jdl_lap="Laporan Rekapitulasi Laba/Rugi";
      $tbl_lap="lap_arus_kas";
    }else{
      $jdl_lap="Laporan Rekapitulasi Laba/Rugi";
      $tbl_lap="lap_lak_sap";
      
    }
    
    $jbeban=$_REQUEST["jbeban"];
    
    $tipe=$_REQUEST["tipe"];
    $ma_kode=$_REQUEST["ma_kode"];
  ?>
  
<p align="center" style="font-size:17px;font-weight:bold">LAPORAN REKAPITULASI RUGI/LABA
<br/>
<?php echo $title_tgl; ?>

</p>
            
            
              <table width="1500" cellspacing="0" cellpadding="0" border="1" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; border-collapse:collapse; padding-right:">
                <tr style="font-weight:bold" bgcolor="#E6E6E6">
                  <td rowspan="3" align="center">No</td>
                  <td rowspan="3" align="center">Uraian</td>
                  <td colspan="6" align="center">ANGGARAN</td>
                  <td colspan="3" align="center">REALISASI</td>
                  <td rowspan="3" align="center">DEVIASI (11-7)</td>
                  <td colspan="4" align="center">RASIO</td>
                </tr>
                
                <tr style="font-weight:bold" bgcolor="#E6E6E6">
                  <td rowspan="2" align="center">TAHUN <?php echo $ta_lr; ?></td>
                  <td rowspan="2" align="center">S/D TRIWULAN LALU</td>
                  <td colspan="3" align="center">TRIWULAN BERJALAN</td>
                  <td rowspan="2" align="center">S/D TRIWULAN INI</td>
                  <td colspan="3" align="center">TRIWULAN BERJALAN</td>
                  <td rowspan="2" align="center">12/8</td>
                  <td rowspan="2" align="center">10/6</td>
                  <td rowspan="2" align="center">11/8</td>
                  <td rowspan="2" align="center">11/3</td>
                </tr>
                
                <tr style="font-weight:bold" bgcolor="#E6E6E6">
                  <td align="center">S/D BULAN LALU</td>
                  <td align="center">BULAN INI</td>
                  <td align="center">S/D BULAN INI</td>
                  <td align="center">S/D BULAN LALU</td>
          <td align="center">BULAN INI</td>
                  <td align="center">S/D BULAN INI</td>
                </tr>
                <tr>
                  <td width="43" align="center">1</td>
                  <td width="221" align="center">2</td>
                  <td width="96" align="center">3</td>
                  <td width="84" align="center">4</td>
                  <td width="92" align="center">5</td>
                  <td width="86" align="center">6</td>
                  <td width="83" align="center">7</td>
                  <td width="96" align="center">8</td>
                  <td width="93" align="center">9</td>
                  <td width="91" align="center">10</td>
                  <td width="95" align="center">11</td>
                  <td width="87" align="center">12</td>
                  <td width="83" align="center">13</td>
                  <td width="81" align="center">14</td>
                  <td width="76" align="center">15</td>
                  <td width="59" align="center">16</td>
                </tr>
                <tr>
                  <td align="center">4.1.00.00.00.00</td><!--*decybe perubahan ke COA baru-->
                  <td align="left">&nbsp;Pendapatan Pelayanan RS PHCM</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
          <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
                <?php 
                //decyber Merubah kode pendapatan dari 710 ke 4.1
                $sql="SELECT * FROM ma_sak WHERE MA_LEVEL=3 AND MA_KODE LIKE '4.%'";
        // echo $sql."<br>".$flag;
                $rs=mysql_query($sql);
                $i=0;
                $stotOp=$stotOp2=$stotOp3=0;
                $stotBiayaOp=$stotBiayaOp2=$stotBiayaOp3=0;
        $stotBiayaOTL=$stotBiayaOTL2=$stotBiayaOTL3=0;
        $stotBiayaPO=$stotBiayaPO2=$stotBiayaPO3=0;
        $stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
        $stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
                while ($rw=mysql_fetch_array($rs)){
                    $i++;
                    $sql="SELECT
               IFNULL(SUM(j.NILAI), 0) AS nilai
             FROM anggaran j
               INNER JOIN ma_sak ma
               ON j.FK_MAID = ma.MA_ID
             WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
               AND j.TAHUN = $ta_lr";
                    $rsAngTh1=mysql_query($sql);
                    $rwAngTh1=mysql_fetch_array($rsAngTh1);
                    $stotAngThOp+=$rwAngTh1["nilai"];

                    $sql="SELECT
                SUM(t.nilai) AS nilai,
                SUM(t.nilai2) AS nilai2
              FROM (SELECT
                  IFNULL(SUM(j.NILAI), 0) AS nilai,
                  '0' AS nilai2
                  FROM anggaran j
                  INNER JOIN ma_sak ma
                    ON j.FK_MAID = ma.MA_ID
                  WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
                    AND j.BULAN < $bulan_lr
                    AND j.TAHUN = $ta_lr AND j.flag = '$flag'
                  UNION 
                  SELECT
                   '0'  AS nilai,
                   IFNULL(SUM(j.NILAI), 0) AS nilai2
                 FROM anggaran j
                   INNER JOIN ma_sak ma
                   ON j.FK_MAID = ma.MA_ID
                 WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
                   AND j.BULAN = $bulan_lr
                   AND j.TAHUN = $ta_lr AND j.flag = '$flag') t";
                    $rsAng1=mysql_query($sql);
                    $rwAng1=mysql_fetch_array($rsAng1);
                    $stotAngOp +=$rwAng1["nilai"];
          $stotAngOp2 +=$rwAng1["nilai2"];
          $AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
          $stotAngOp3 +=$AngOp3;

                    $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag' 
          UNION
          SELECT '0' AS nilai, IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
                    $rs1=mysql_query($sql);
                    $rw1=mysql_fetch_array($rs1);
                    // echo $sql;
                    $stotOp+=$rw1["nilai"];
          $stotOp2+=$rw1["nilai2"];
          $Op3=$rw1["nilai"]+$rw1["nilai2"];
          //$stotOp3+=$rw1["nilai"]+$rw1["nilai2"];
          $Deviasi=$Op3-$AngOp3;
          $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
          
          $stotDeviasi +=$Deviasi;
          $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
          
          $Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
          
          $Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
          $Rasio3=($AngOp3==0)?0:$Op3/$AngOp3 * 100;
          $Rasio4=($rwAngTh1["nilai"]==0)?0:$Op3/$rwAngTh1["nilai"] * 100;
          
          $stotRasio1 +=$Rasio1;
          $stotRasio2 +=$Rasio2;
          $stotRasio3 +=$Rasio3;
          $stotRasio4 +=$Rasio4;
          
          $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
          $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
          $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
          $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
                ?>
                <tr>
                  <td align="center"><?php echo $rw["MA_KODE_VIEW"]; ?></td><!--*decyber , brubah pelayanan ke view-->
           <?php 
                  /*if ( (($rw1["nilai"]>0) && ($rw["MA_ISLAST"]==0)) or (($rw1["nilai2"]>0) && ($rw["MA_ISLAST"]==0)) ){
                  ?>
                  <td>&nbsp;&nbsp;&nbsp;<a href="?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $rw["MA_KODE"]; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>"><?php echo $rw["MA_NAMA"]; ?></a></td>
                  <?php 
                  }else{*/
                  ?>
                  <td>&nbsp;&nbsp;&nbsp;<?php echo $rw["MA_NAMA"]; ?></td>
                  <?php 
                  //}
                  // var_dump($rw1);
                  ?>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
           <td align="right"> <?php echo number_format($rw1["nilai"],0,",","."); ?><!--nilai yang akan diambil--></td>
           <td align="right"> <?php echo number_format($rw1["nilai2"],0,",","."); ?></td>
           <td align="right"><?php echo number_format($Op3,0,",","."); ?><!--nilai yang akan diambil--></td>
           <td align="right"><?php echo $lblDeviasi; ?></td>
           <td align="right"><?php echo $lblRasio1; ?></td>
           <td align="right"><?php echo $lblRasio2; ?></td>
           <td align="right"><?php echo $lblRasio3; ?></td>
           <td align="right"><?php echo $lblRasio4; ?></td>
                </tr>
                <?php 
                }
        
        $stotOp3=$stotOp+$stotOp2;
        
        $stotRasio2=$stotRasio2/$i;
        $stotRasio3=$stotRasio3/$i;
        $stotRasio4=$stotRasio4/$i;
        
        $lblstotRasio1=($stotRasio1<0)?"(".number_format(abs($stotRasio1),0,",",".").")":number_format($stotRasio1,0,",",".");
        $lblstotRasio2=($stotRasio2<0)?"(".number_format(abs($stotRasio2),0,",",".").")":number_format($stotRasio2,0,",",".");
        $lblstotRasio3=($stotRasio3<0)?"(".number_format(abs($stotRasio3),0,",",".").")":number_format($stotRasio3,0,",",".");
        $lblstotRasio4=($stotRasio4<0)?"(".number_format(abs($stotRasio4),0,",",".").")":number_format($stotRasio4,0,",",".");
        
        $stotAngThPOp=$stotAngThOp;
        $stotAngPOp=$stotAngOp;
        $stotAngPOp2=$stotAngOp2;
        $stotAngPOp3=$stotAngOp3;
        
        //simpan pendapatanPend = an pendapatan
        $stotAngThOpPend  = $stotAngThOp;
        $stotAngOpPend = $stotAngOp;
        $stotAngOp2Pend = $stotAngOp2;
        $stotAngOp3Pend = $stotAngOp3;
        $stotOpPend = $stotOp;
        $stotOp2Pend = $stotOp2;
        $stotOp3Pend = $stotOp3;
        $lbltotDeviasiPend = $stotDeviasi;
        $lblstotRasio1Pend = $lblstotRasio1;
        $lblstotRasio2Pend = $lblstotRasio2;
        $lblstotRasio3Pend = $lblstotRasio3;
        $lblstotRasio4Pend = $lblstotRasio4;
        

                ?>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;JUMLAH : </td>
                  <td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotOp,0,",","."); ?></td>
          <td align="right"><?php echo number_format($stotOp2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotOp3,0,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
          <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
                <?php 
        if ($jbeban=="0" || $jbeban==""){
        $kodeMaOp="5"; //*decyber ganti ke COA baru yg awalnya 810
                $sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaOp'";
        //echo $sql."<br>";
                $rsB=mysql_query($sql);
        $rwB=mysql_fetch_array($rsB);
        
        $cma_id=$rwB["MA_KODE"];
        ?>
                <tr>
                  <td align="center">5.0.00.00.00.00</td> <!--*decyber , ganti ke kode COA baru-->
                  <td align="left">&nbsp;Biaya Pelayanan RS PHCM</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center">5.1.00.00.00.00</td> <!--*decyber , ganti ke kode COA baru-->
                  <td align="left">&nbsp;<b>Beban Pokok</b></td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
                <?php 
        // $kodeMaUmum="826";
        // $kodeMaBPOKawaka="831";
        // $kodeMaBPOUmum="832";
        // $kodeMaBPOKeu="833";
        // $kodeMaBPOTeknik="834";
        
        $i=0;
                $sqln="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id' ORDER BY MA_KODE"; //*decyber penambahan untuk memunculkan semua beban anak kedua
                $rsBn=mysql_query($sqln); //decyber
                // while ($rwBn=mysql_fetch_array($rsBn)){//decyber
                  $rwBn=mysql_fetch_array($rsBn);
                  // $nama_MA_BPO=$rwBn["MA_NAMA"];
                  $cma_id_new=$rwBn['MA_KODE'];
                // $sql="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id_new' OR MA_KODE = '$cma_id_new' ORDER BY MA_ID";//decyber, penambahan kondisi
                // var_dump($rwBn);
                $sql="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id_new' ORDER BY MA_ID";//decyber, penambahan kondisi

        // echo $sql."<br>";
                $rsB=mysql_query($sql);
        
        $stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
        $stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
        while ($rwB=mysql_fetch_array($rsB)){
        //  echo '<pre>';
        // var_dump($rwB);
        // echo '</pre>';
        // echo '---------------------------------------------------------------';
          $i++;
          $kode_MA_BPO=$rwB["MA_KODE"];
          $kode_MA_BPO_VIEW=$rwB["MA_KODE_VIEW"]; //*decyber ganti ma_kode jd ma_kode_view
          $kode_MA_BPO_KP=$rwB["MA_KODE_KP"];
          $nama_MA_BPO=$rwB["MA_NAMA"];
          
                    $sql="SELECT
               IFNULL(SUM(j.NILAI), 0) AS nilai
             FROM anggaran j
               INNER JOIN ma_sak ma
               ON j.FK_MAID = ma.MA_ID
             WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
               AND j.TAHUN = $ta_lr AND j.flag = '$flag'";
                    $rsAngTh1=mysql_query($sql);
                    $rwAngTh1=mysql_fetch_array($rsAngTh1);
                    $stotAngThOp+=$rwAngTh1["nilai"];

                    $sql="SELECT
                SUM(t.nilai) AS nilai,
                SUM(t.nilai2) AS nilai2
              FROM (SELECT
                  IFNULL(SUM(j.NILAI), 0) AS nilai,
                  '0' AS nilai2
                  FROM anggaran j
                  INNER JOIN ma_sak ma
                    ON j.FK_MAID = ma.MA_ID
                  WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
                    AND j.BULAN < $bulan_lr
                    AND j.TAHUN = $ta_lr AND j.flag = '$flag'
                  UNION 
                  SELECT
                   '0'  AS nilai,
                   IFNULL(SUM(j.NILAI), 0) AS nilai2
                 FROM anggaran j
                   INNER JOIN ma_sak ma
                   ON j.FK_MAID = ma.MA_ID
                 WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
                   AND j.BULAN = $bulan_lr
                   AND j.TAHUN = $ta_lr AND j.flag = '$flag') t";
                    $rsAng1=mysql_query($sql);
                    $rwAng1=mysql_fetch_array($rsAng1);
                    $stotAngOp +=$rwAng1["nilai"];
          $stotAngOp2 +=$rwAng1["nilai2"];
          $AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
          $stotAngOp3 =$stotAngOp+$stotAngOp2;
          
          $sqlBPOSub="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
          
          
          $rsBPOSub=mysql_query($sqlBPOSub);
          $rwBPOSub=mysql_fetch_array($rsBPOSub);
          $biayaBPO=$rwBPOSub["nilai"];
          $biayaBPO2=$rwBPOSub["nilai2"];
          $biayaBPO3=$biayaBPO+$biayaBPO2;
          
          $stotBiayaOp +=$biayaBPO;
          $stotBiayaOp2 +=$biayaBPO2;
          
          $Deviasi=$biayaBPO3-$AngOp3;
          $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
          
          $stotDeviasi +=$Deviasi;
          $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
          
          $Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
          $Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
          $Rasio3=($AngOp3==0)?0:$biayaBPO3/$AngOp3 * 100;
          $Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPO3/$rwAngTh1["nilai"] * 100;
          
          $stotRasio1 +=$Rasio1;
          $stotRasio2 +=$Rasio2;
          $stotRasio3 +=$Rasio3;
          $stotRasio4 +=$Rasio4;
          
          $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
          $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
          $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
          $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
        ?>
                <tr>
                  <td align="center"><?php 
                  if($rwB['MA_KODE'] == $cma_id_new){
                    echo "<b>".$kode_MA_BPO_VIEW."</b>";//decyber, ksih kondisi biar agak tebal
                  }else{
                  echo $kode_MA_BPO_VIEW;
                  } ?></td>
           <?php 
                  /*if ($biayaBPO>0 || $biayaBPO2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kode_MA_BPO; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>"><?php echo $nama_MA_BPO; ?></a></td>
                  <?php 
                  }else{*/
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;
                  <?php   
                  if($rwB['MA_KODE'] == $cma_id_new){
                    echo "<b><font size=1.5>".$nama_MA_BPO."</font></b>";//decyber, ksih kondisi biar agak tebal
                  }else{
                  echo $nama_MA_BPO;
                  } ?></td>
                  <?php 
                  //}
                  ?>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO3,0,",","."); ?></td>
                  <td align="right"><?php echo $lblDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <?php 
        }
      // }
        $stotBiayaOp3=$stotBiayaOp+$stotBiayaOp2;
        
        $stotRasio2=$stotRasio2/$i;
        $stotRasio3=$stotRasio3/$i;
        $stotRasio4=$stotRasio4/$i;
        
        $lblstotRasio1=($stotRasio1<0)?"(".number_format(abs($stotRasio1),0,",",".").")":number_format($stotRasio1,0,",",".");
        $lblstotRasio2=($stotRasio2<0)?"(".number_format(abs($stotRasio2),0,",",".").")":number_format($stotRasio2,0,",",".");
        $lblstotRasio3=($stotRasio3<0)?"(".number_format(abs($stotRasio3),0,",",".").")":number_format($stotRasio3,0,",",".");
        $lblstotRasio4=($stotRasio4<0)?"(".number_format(abs($stotRasio4),0,",",".").")":number_format($stotRasio4,0,",",".");


           //simpan beban ben = an pendapatan
           $stotAngThOpBenPok  = $stotAngThOp;
           $stotAngOpBenPok = $stotAngOp;
           $stotAngOp2BenPok = $stotAngOp2;
           $stotAngOp3BenPok = $stotAngOp3;
           $stotOpBenPok = $stotBiayaOp;
           $stotOp2BenPok = $stotBiayaOp2;
           $stotOp3BenPok = $stotBiayaOp3;
           $lbltotDeviasiBenPok = $stotDeviasi;
           $lblstotRasio1BenPok = $lblstotRasio1;
           $lblstotRasio2BenPok = $lblstotRasio2;
           $lblstotRasio3BenPok = $lblstotRasio3;
           $lblstotRasio4BenPok = $lblstotRasio4;

        ?>

                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;JUMLAH BEBAN POKOK: </td>
                  <td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotBiayaOp,0,",","."); ?></td>
          <td align="right"><?php echo number_format($stotBiayaOp2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotBiayaOp3,0,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>

                
        <!--*decyber Start_Line Beban Pemasaran -->
        <tr>
                  <td align="center">5.2.00.00.00.00</td> <!--*decyber , ganti ke kode COA baru-->
                  <td align="left">&nbsp;<b>Beban Pemasaran</b></td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
        <?php
        
        $kodeMaOp="5.2"; //*decyber ganti ke COA baru yg awalnya 810
        $kodeMaOp2="5.2."; //*decyber ganti ke COA baru yg awalnya 810
//        $sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaOp'";
// echo $sql."<br>";
//        $rsB=mysql_query($sql);
// $rwB=mysql_fetch_array($rsB);

// $cma_id=$rwB["MA_KODE"];

        $sqln="SELECT * FROM ma_sak WHERE MA_KODE Like '$kodeMaOp%' ORDER BY MA_KODE"; //*decyber penambahan untuk memunculkan semua beban anak kedua
        // echo $sqln;
                $rsBn=mysql_query($sqln); //decyber
                // while ($rwBn=mysql_fetch_array($rsBn)){//decyber
                  $rwBn=mysql_fetch_array($rsBn);
                  // $nama_MA_BPO=$rwBn["MA_NAMA"];
                  $cma_id_new=$rwBn['MA_KODE'];
                // $sql="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id_new' OR MA_KODE = '$cma_id_new' ORDER BY MA_ID";//decyber, penambahan kondisi
                // var_dump($rwBn);
                $sql="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id_new' OR MA_KODE LIKE '$kodeMaOp2%' ORDER BY MA_ID";//decyber, penambahan kondisi

        // echo $sql."<br>";
                $rsB=mysql_query($sql);
        
        $stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
        $stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
        $stotBiayaOp=$stotBiayaOp2=$stotBiayaOp3=0;
        while ($rwB=mysql_fetch_array($rsB)){
        //  echo '<pre>';
        // var_dump($rwB);
        // echo '</pre>';
        // echo '---------------------------------------------------------------';
          $i++;
          $kode_MA_BPO=$rwB["MA_KODE"];
          $kode_MA_BPO_VIEW=$rwB["MA_KODE_VIEW"]; //*decyber ganti ma_kode jd ma_kode_view
          $kode_MA_BPO_KP=$rwB["MA_KODE_KP"];
          $nama_MA_BPO=$rwB["MA_NAMA"];
          
                    $sql="SELECT
               IFNULL(SUM(j.NILAI), 0) AS nilai
             FROM anggaran j
               INNER JOIN ma_sak ma
               ON j.FK_MAID = ma.MA_ID
             WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
               AND j.TAHUN = $ta_lr AND j.flag = '$flag'";
                    $rsAngTh1=mysql_query($sql);
                    $rwAngTh1=mysql_fetch_array($rsAngTh1);
                    $stotAngThOp+=$rwAngTh1["nilai"];

                    $sql="SELECT
                SUM(t.nilai) AS nilai,
                SUM(t.nilai2) AS nilai2
              FROM (SELECT
                  IFNULL(SUM(j.NILAI), 0) AS nilai,
                  '0' AS nilai2
                  FROM anggaran j
                  INNER JOIN ma_sak ma
                    ON j.FK_MAID = ma.MA_ID
                  WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
                    AND j.BULAN < $bulan_lr
                    AND j.TAHUN = $ta_lr AND j.flag = '$flag'
                  UNION 
                  SELECT
                   '0'  AS nilai,
                   IFNULL(SUM(j.NILAI), 0) AS nilai2
                 FROM anggaran j
                   INNER JOIN ma_sak ma
                   ON j.FK_MAID = ma.MA_ID
                 WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
                   AND j.BULAN = $bulan_lr
                   AND j.TAHUN = $ta_lr AND j.flag = '$flag') t";
                    $rsAng1=mysql_query($sql);
                    $rwAng1=mysql_fetch_array($rsAng1);
                    $stotAngOp +=$rwAng1["nilai"];
          $stotAngOp2 +=$rwAng1["nilai2"];
          $AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
          $stotAngOp3 =$stotAngOp + $stotAngOp2;
          
          $sqlBPOSub="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag'UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
          
          
          $rsBPOSub=mysql_query($sqlBPOSub);
          $rwBPOSub=mysql_fetch_array($rsBPOSub);
          $biayaBPO=$rwBPOSub["nilai"];
          $biayaBPO2=$rwBPOSub["nilai2"];
          $biayaBPO3=$biayaBPO+$biayaBPO2;
          
          $stotBiayaOp +=$biayaBPO;
          $stotBiayaOp2 +=$biayaBPO2;
          
          $Deviasi=$biayaBPO3-$AngOp3;
          $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
          
          $stotDeviasi +=$Deviasi;
          $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
          
          $Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
          $Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
          $Rasio3=($AngOp3==0)?0:$biayaBPO3/$AngOp3 * 100;
          $Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPO3/$rwAngTh1["nilai"] * 100;
          
          $stotRasio1 +=$Rasio1;
          $stotRasio2 +=$Rasio2;
          $stotRasio3 +=$Rasio3;
          $stotRasio4 +=$Rasio4;
          
          $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
          $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
          $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
          $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
        ?>
                <tr>
                  <td align="center"><?php 
                  if($rwB['MA_KODE'] == $cma_id_new){
                    echo "<b>".$kode_MA_BPO_VIEW."</b>";//decyber, ksih kondisi biar agak tebal
                  }else{
                  echo $kode_MA_BPO_VIEW;
                  } ?></td>
           <?php 
                  /*if ($biayaBPO>0 || $biayaBPO2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kode_MA_BPO; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>"><?php echo $nama_MA_BPO; ?></a></td>
                  <?php 
                  }else{*/
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;
                  <?php   
                  if($rwB['MA_KODE'] == $cma_id_new){
                    echo "<b><font size=1.5>".$nama_MA_BPO."</font></b>";//decyber, ksih kondisi biar agak tebal
                  }else{
                  echo $nama_MA_BPO;
                  } ?></td>
                  <?php 
                  //}
                  ?>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO3,0,",","."); ?></td>
                  <td align="right"><?php echo $lblDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <?php 
        }
      // }
        $stotBiayaOp3=$stotBiayaOp+$stotBiayaOp2;
        
        $stotRasio2=$stotRasio2/$i;
        $stotRasio3=$stotRasio3/$i;
        $stotRasio4=$stotRasio4/$i;
        
        $lblstotRasio1=($stotRasio1<0)?"(".number_format(abs($stotRasio1),0,",",".").")":number_format($stotRasio1,0,",",".");
        $lblstotRasio2=($stotRasio2<0)?"(".number_format(abs($stotRasio2),0,",",".").")":number_format($stotRasio2,0,",",".");
        $lblstotRasio3=($stotRasio3<0)?"(".number_format(abs($stotRasio3),0,",",".").")":number_format($stotRasio3,0,",",".");
        $lblstotRasio4=($stotRasio4<0)?"(".number_format(abs($stotRasio4),0,",",".").")":number_format($stotRasio4,0,",",".");

        //simpan Pemasaran pem = an pendapatan
        $stotAngThOpPem  = $stotAngThOp;
        $stotAngOpPem = $stotAngOp;
        $stotAngOp2Pem = $stotAngOp2;
        $stotAngOp3Pem = $stotAngOp3;
        $stotOpPem = $stotOp;
        // $stotOp2Pem = $stotOp2;
        $stotOp3Pem = $stotOp3;
        $lbltotDeviasiPem = $lbltotDeviasi;
        $lblstotRasio1Pem = $lblstotRasio1;
        $lblstotRasio2Pem = $lblstotRasio2;
        $lblstotRasio3Pem = $lblstotRasio3;
        $lblstotRasio4Pem = $lblstotRasio4;

        // echo $stotAngOp3;
        ?>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;JUMLAH Beban Pemasaran: </td>
                  <td align="right"><?php echo number_format($stotAngThOpPem=$stotAngThOp,0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($stotAngOpPem=$stotAngOp,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp2Pem=$stotAngOp2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3Pem=$stotAngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3Pem=$stotAngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotOpPem=$stotBiayaOp,0,",","."); ?></td>
          <td align="right"><?php echo number_format($stotOp2Pem=$stotBiayaOp2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotOp3Pem=$stotBiayaOp3,0,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
        <!--*decyber END_Line Beban Pemasaran -->


        <!--*decyber Start_Line Beban Umum dan Administrasi -->
        <tr>
                  <td align="center">5.3.00.00.00.00</td> <!--*decyber , ganti ke kode COA baru-->
                  <td align="left">&nbsp;<b>Beban Umum dan Administrasi</b></td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
        <?php 
        $kodeMaOp="5.3"; //*decyber ganti ke COA baru yg awalnya 810
//        $sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaOp'";
// echo $sql."<br>";
//        $rsB=mysql_query($sql);
// $rwB=mysql_fetch_array($rsB);

// $cma_id=$rwB["MA_KODE"];

        $sqln="SELECT * FROM ma_sak WHERE MA_KODE Like '$kodeMaOp%' ORDER BY MA_KODE"; //*decyber penambahan untuk memunculkan semua beban anak kedua
                $rsBn=mysql_query($sqln); //decyber
                // while ($rwBn=mysql_fetch_array($rsBn)){//decyber
                  $rwBn=mysql_fetch_array($rsBn);
                  // $nama_MA_BPO=$rwBn["MA_NAMA"];
                  $cma_id_new=$rwBn['MA_KODE'];
                // $sql="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id_new' OR MA_KODE = '$cma_id_new' ORDER BY MA_ID";//decyber, penambahan kondisi
                // var_dump($rwBn);
                $sql="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id_new' ORDER BY MA_ID";//decyber, penambahan kondisi

        // echo $sql."<br>";
                $rsB=mysql_query($sql);
        
        $stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
        $stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
        $stotBiayaOp=$stotBiayaOp2=$stotBiayaOp3=0;

        while ($rwB=mysql_fetch_array($rsB)){
        //  echo '<pre>';
        // var_dump($rwB);
        // echo '</pre>';
        // echo '---------------------------------------------------------------';
          $i++;
          $kode_MA_BPO=$rwB["MA_KODE"];
          $kode_MA_BPO_VIEW=$rwB["MA_KODE_VIEW"]; //*decyber ganti ma_kode jd ma_kode_view
          $kode_MA_BPO_KP=$rwB["MA_KODE_KP"];
          $nama_MA_BPO=$rwB["MA_NAMA"];
          
                    $sql="SELECT
               IFNULL(SUM(j.NILAI), 0) AS nilai
             FROM anggaran j
               INNER JOIN ma_sak ma
               ON j.FK_MAID = ma.MA_ID
             WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
               AND j.TAHUN = $ta_lr AND j.flag = '$flag'";
                    $rsAngTh1=mysql_query($sql);
                    $rwAngTh1=mysql_fetch_array($rsAngTh1);
                    $stotAngThOp+=$rwAngTh1["nilai"];

                    $sql="SELECT
                SUM(t.nilai) AS nilai,
                SUM(t.nilai2) AS nilai2
              FROM (SELECT
                  IFNULL(SUM(j.NILAI), 0) AS nilai,
                  '0' AS nilai2
                  FROM anggaran j
                  INNER JOIN ma_sak ma
                    ON j.FK_MAID = ma.MA_ID
                  WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
                    AND j.BULAN < $bulan_lr
                    AND j.TAHUN = $ta_lr AND j.flag = '$flag'
                  UNION 
                  SELECT
                   '0'  AS nilai,
                   IFNULL(SUM(j.NILAI), 0) AS nilai2
                 FROM anggaran j
                   INNER JOIN ma_sak ma
                   ON j.FK_MAID = ma.MA_ID
                 WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
                   AND j.BULAN = $bulan_lr
                   AND j.TAHUN = $ta_lr AND j.flag = '$flag') t";
                  //  echo $sql."<br>";
                    $rsAng1=mysql_query($sql);
                    $rwAng1=mysql_fetch_array($rsAng1);
                    $stotAngOp +=$rwAng1["nilai"];
          $stotAngOp2 +=$rwAng1["nilai2"];
          $AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
          // $stotAngOp3 +=$AngOp3;
          $stotAngOpketiga +=$AngOp3;
          
          $sqlBPOSub="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
          // echo 'Ini query 5.3 : '.$sqlBPOSub.'<br>';
          
          $rsBPOSub=mysql_query($sqlBPOSub);
          $rwBPOSub=mysql_fetch_array($rsBPOSub);
          $biayaBPO=$rwBPOSub["nilai"];
          $biayaBPO2=$rwBPOSub["nilai2"];
          // echo $biayaBPO2."<br>";
          $stotBiayaOpkedua += $biayaBPO2;
          // echo " Total ".$biayaTotal."</br>";
          $biayaBPO3=$biayaBPO+$biayaBPO2;
          
          $stotBiayaOp +=$biayaBPO;
          // $stotBiayaOpkedua += $biayaBPO2;
          
          $Deviasi=$biayaBPO3-$AngOp3;
          $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
          
          $stotDeviasi +=$Deviasi;
          $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
          
          $Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
          $Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
          $Rasio3=($AngOp3==0)?0:$biayaBPO3/$AngOp3 * 100;
          $Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPO3/$rwAngTh1["nilai"] * 100;
          
          $stotRasio1 +=$Rasio1;
          $stotRasio2 +=$Rasio2;
          $stotRasio3 +=$Rasio3;
          $stotRasio4 +=$Rasio4;
          
          $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
          $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
          $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
          $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
        ?>
                <tr>
                  <td align="center"><?php 
                  if($rwB['MA_KODE'] == $cma_id_new){
                    echo "<b>".$kode_MA_BPO_VIEW."</b>";//decyber, ksih kondisi biar agak tebal
                  }else{
                  echo $kode_MA_BPO_VIEW;
                  } ?></td>
           <?php 
                  /*if ($biayaBPO>0 || $biayaBPO2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kode_MA_BPO; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>"><?php echo $nama_MA_BPO; ?></a></td>
                  <?php 
                  }else{*/
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;
                  <?php   
                  if($rwB['MA_KODE'] == $cma_id_new){
                    echo "<b><font size=1.5>".$nama_MA_BPO."</font></b>";//decyber, ksih kondisi biar agak tebal
                  }else{
                  echo $nama_MA_BPO;
                  } ?></td>
                  <?php 
                  //}
                  ?>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO3,0,",","."); ?></td>
                  <td align="right"><?php echo $lblDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <?php 
        }
      // }
        $stotBiayaOp3=$stotBiayaOp+$stotBiayaOpkedua;
        
        $stotRasio2=$stotRasio2/$i;
        $stotRasio3=$stotRasio3/$i;
        $stotRasio4=$stotRasio4/$i;
        
        $lblstotRasio1=($stotRasio1<0)?"(".number_format(abs($stotRasio1),0,",",".").")":number_format($stotRasio1,0,",",".");
        $lblstotRasio2=($stotRasio2<0)?"(".number_format(abs($stotRasio2),0,",",".").")":number_format($stotRasio2,0,",",".");
        $lblstotRasio3=($stotRasio3<0)?"(".number_format(abs($stotRasio3),0,",",".").")":number_format($stotRasio3,0,",",".");
        $lblstotRasio4=($stotRasio4<0)?"(".number_format(abs($stotRasio4),0,",",".").")":number_format($stotRasio4,0,",",".");
         //simpan Beban pem = an pendapatan
         $stotAngThOpBenAdm  = $stotAngThOp;
         $stotAngOpBenAdm = $stotAngOp;
         $stotAngOp2BenAdm = $stotAngOp2;
         $stotAngOp3BenAdm = $stotAngOpketiga;
         $stotOpBenAdm = $stotBiayaOp;
         $stotOp2BenAdm = $stotBiayaOpkedua;
         $stotOp3BenAdm = $stotBiayaOp3;
         $lbltotDeviasiBenAdm = $lbltotDeviasi;
         $lblstotRasio1BenAdm = $lblstotRasio1;
         $lblstotRasio2BenAdm = $lblstotRasio2;
         $lblstotRasio3BenAdm = $lblstotRasio3;
         $lblstotRasio4BenAdm = $lblstotRasio4;
        ?>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;JUMLAH Beban Umum dan Administrasi: </td>
                  <td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOpketiga,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOpketiga,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotBiayaOp,0,",","."); ?></td>
          <td align="right"><?php echo number_format($stotBiayaOpkedua,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotBiayaOp3,0,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
        <!-- untuk menghitung beban decyber -->

                <?php 
        $kodeMaOp="5"; //*decyber ganti ke COA baru yg awalnya 810
        // $sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaOp'";
// echo $sql."<br>";
//        $rsB=mysql_query($sql);
// $rwB=mysql_fetch_array($rsB);

// $cma_id=$rwB["MA_KODE"];

        $sqln="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaOp' ORDER BY MA_KODE"; //*decyber penambahan untuk memunculkan semua beban anak kedua
                $rsBn=mysql_query($sqln); //decyber
                while ($rwBn=mysql_fetch_array($rsBn)){//decyber
                  // $rwBn=mysql_fetch_array($rsBn);
                  // $nama_MA_BPO=$rwBn["MA_NAMA"];
                  $cma_id_new=$rwBn['MA_KODE'];
                // $sql="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id_new' OR MA_KODE = '$cma_id_new' ORDER BY MA_ID";//decyber, penambahan kondisi
                // var_dump($rwBn);
                $sql="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id_new' ORDER BY MA_ID";//decyber, penambahan kondisi

        // echo $sql."<br>";
                $rsB=mysql_query($sql);
        
        $stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
        $stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
        $stotBiayaOp=$stotBiayaOp2=$stotBiayaOp3=0;

        while ($rwB=mysql_fetch_array($rsB)){
        //  echo '<pre>';
        // var_dump($rwB);
        // echo '</pre>';
        // echo '---------------------------------------------------------------';
          $i++;
          $kode_MA_BPO=$rwB["MA_KODE"];
          $kode_MA_BPO_VIEW=$rwB["MA_KODE_VIEW"]; //*decyber ganti ma_kode jd ma_kode_view
          $kode_MA_BPO_KP=$rwB["MA_KODE_KP"];
          $nama_MA_BPO=$rwB["MA_NAMA"];
          
                    $sql="SELECT
               IFNULL(SUM(j.NILAI), 0) AS nilai
             FROM anggaran j
               INNER JOIN ma_sak ma
               ON j.FK_MAID = ma.MA_ID
             WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
               AND j.TAHUN = $ta_lr AND j.flag = '$flag'";
                    $rsAngTh1=mysql_query($sql);
                    $rwAngTh1=mysql_fetch_array($rsAngTh1);
                    $stotAngThOp+=$rwAngTh1["nilai"];

                    $sql="SELECT
                SUM(t.nilai) AS nilai,
                SUM(t.nilai2) AS nilai2
              FROM (SELECT
                  IFNULL(SUM(j.NILAI), 0) AS nilai,
                  '0' AS nilai2
                  FROM anggaran j
                  INNER JOIN ma_sak ma
                    ON j.FK_MAID = ma.MA_ID
                  WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
                    AND j.BULAN < $bulan_lr
                    AND j.TAHUN = $ta_lr AND j.flag = '$flag'
                  UNION 
                  SELECT
                   '0'  AS nilai,
                   IFNULL(SUM(j.NILAI), 0) AS nilai2
                 FROM anggaran j
                   INNER JOIN ma_sak ma
                   ON j.FK_MAID = ma.MA_ID
                 WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
                   AND j.BULAN = $bulan_lr
                   AND j.TAHUN = $ta_lr) t";
                    $rsAng1=mysql_query($sql);
                    $rwAng1=mysql_fetch_array($rsAng1);
                    $stotAngOp +=$rwAng1["nilai"];
          $stotAngOp2 +=$rwAng1["nilai2"];
          $AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
          $stotAngOp3 +=$AngOp3;
          
          $sqlBPOSub="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
          
          
          $rsBPOSub=mysql_query($sqlBPOSub);
          $rwBPOSub=mysql_fetch_array($rsBPOSub);
          $biayaBPO=$rwBPOSub["nilai"];
          $biayaBPO2=$rwBPOSub["nilai2"];
          $biayaBPO3=$biayaBPO+$biayaBPO2;
          
          $stotBiayaOp +=$biayaBPO;
          $stotBiayaOp2 +=$biayaBPO2;
          
          $Deviasi=$biayaBPO3-$AngOp3;
          $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
          
          $stotDeviasi +=$Deviasi;
          $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
          
          $Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
          $Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
          $Rasio3=($AngOp3==0)?0:$biayaBPO3/$AngOp3 * 100;
          $Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPO3/$rwAngTh1["nilai"] * 100;
          
          $stotRasio1 +=$Rasio1;
          $stotRasio2 +=$Rasio2;
          $stotRasio3 +=$Rasio3;
          $stotRasio4 +=$Rasio4;
          
          $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
          $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
          $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
          $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
        ?>
                <!-- <tr> -->
                  <!-- <td align="center">  --><?php
                  // if($rwB['MA_KODE'] == $cma_id_new){
                    // echo "<b>".$kode_MA_BPO_VIEW."</b>";//decyber, ksih kondisi biar agak tebal
                  // }else{
                  // echo $kode_MA_BPO_VIEW;
                  // } ?></td>
           <?php 
                  /*if ($biayaBPO>0 || $biayaBPO2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kode_MA_BPO; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>"><?php echo $nama_MA_BPO; ?></a></td>
                  <?php 
                  }else{*/
                  ?>
                  <!-- <td align="left">&nbsp;&nbsp;&nbsp; -->
                  <?php   
                //  if($rwB['MA_KODE'] == $cma_id_new){
                  //  echo "<b><font size=1.5>".$nama_MA_BPO."</font></b>";//decyber, ksih kondisi biar agak tebal
                  //}else{
                  //echo $nama_MA_BPO;
                  //} ?></td>
                  <?php 
                  //}
                  ?>
                  <!-- <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO3,0,",","."); ?></td>
                  <td align="right"><?php echo $lblDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr> -->
                <?php 
        }
      }
        $stotBiayaOp3=$stotBiayaOp+$stotBiayaOp2;
        
        $stotRasio2=$stotRasio2/$i;
        $stotRasio3=$stotRasio3/$i;
        $stotRasio4=$stotRasio4/$i;
        
        $lblstotRasio1=($stotRasio1<0)?"(".number_format(abs($stotRasio1),0,",",".").")":number_format($stotRasio1,0,",",".");
        $lblstotRasio2=($stotRasio2<0)?"(".number_format(abs($stotRasio2),0,",",".").")":number_format($stotRasio2,0,",",".");
        $lblstotRasio3=($stotRasio3<0)?"(".number_format(abs($stotRasio3),0,",",".").")":number_format($stotRasio3,0,",",".");
        $lblstotRasio4=($stotRasio4<0)?"(".number_format(abs($stotRasio4),0,",",".").")":number_format($stotRasio4,0,",",".");

        //simpan beban ben = an pendapatan
        $stotAngThOpBeban  =$stotAngThOpBenPok+$stotAngThOpPem+$stotAngThOpBenAdm;
        $stotAngOpBeban=$stotAngOpBenPok+$stotAngOpPem+$stotAngOpBenAdm;
        $stotAngOp2Beban=$stotAngOp2BenPok+$stotAngOp2Pem+$stotAngOp2BenAdm;
        $stotAngOp3Beban=$stotAngOpBeban+$stotAngOp2Beban;
        $stotOpBeban=$stotOpBenPok+$stotOpPem+$stotOpBenAdm;
        $stotOp2Beban=$stotOp2BenPok+$stotOp2Pem+$stotOp2BenAdm;
        // echo "Total = ".$stotOp2Beban." dari ".$stotOp2BenPok." + ".$stotOp2Pem." + ".$stotOp2BenAdm;
        $stotOp3Beban=$stotOp3BenPok+$stotOp3Pem+$stotOp3BenAdm;
        $lbltotDeviasiBeban=$lbltotDeviasiBenPok+$lbltotDeviasiPem+$lbltotDeviasiBenAdm;
        $lblstotRasio1Beban=$lblstotRasio1BenPok+$lblstotRasio1Pem+$lblstotRasio1BenAdm;
        $lblstotRasio2Beban=$lblstotRasio2BenPok+$lblstotRasio2Pem+$lblstotRasio2BenAdm;
        $lblstotRasio3Beban=$lblstotRasio3BenPok+$lblstotRasio3Pem+$lblstotRasio3BenAdm;
        $lblstotRasio4Beban=$lblstotRasio4BenPok+$lblstotRasio4Pem+$lblstotRasio4BenAdm;
        $$lbltotDeviasiBebanCust = $stotDeviasi;
        ?>

        <!-- untuk menghitung beban decyber -->
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;JUMLAH Beban: </td>
                  <td align="right"><?php echo number_format($stotAngThOpBeban,0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($stotAngOpBeban,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp2Beban,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3Beban,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3Beban,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotOpBeban,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotOp2Beban,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotOp3Beban,0,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <!-- $stotAngThOpPend  = $stotAngThOp
        $stotAngOpPend = $stotAngOp
        $stotAngOp2Pend = $stotAngOp2
        $stotAngOp3Pend = $stotAngOp3
        $stotOpPend = $stotOp
        $stotOp2Pend = $stotOp2
        $stotOp3Pend = $stotOp3
        $lbltotDeviasiPend = $lbltotDeviasi
        $lblstotRasio1Pend = $lblstotRasio1
        $lblstotRasio2Pend = $lblstotRasio2
        $lblstotRasio3Pend = $lblstotRasio3
        $lblstotRasio4Pend = $lblstotRasio4 -->
        <?php
//nilai laba rugi *decyber
        $totLRTh1 = $stotAngThOpPend-$stotAngThOpBeban;
        $totLROp = $stotAngOpPend-$stotAngOpBeban;
        $totLROp2 = $stotAngOp2Pend-$stotAngOp2Beban;
        $totLROp3 = $stotAngOp3Pend-$stotAngOp3Beban;
        $totLROpBi = $stotOpPend-$stotOpBeban;
        $totLROpBi2 = $stotOp2Pend-$stotOp2Beban;
        $totLROpBi3 = $stotOp3Pend-$stotOp3Beban;
         $DeviasiLblTot=$lbltotDeviasiPend-$$lbltotDeviasiBebanCust;
          $totLRD1=($DeviasiLblTot<0)?"(".number_format(abs($DeviasiLblTot),0,",",".").")":number_format($DeviasiLblTot,0,",",".");
        
        // echo 'Total '.$totLRD1.' = '.$lbltotDeviasiPend.' - '.$$lbltotDeviasiBebanCust;
        $totLRR1 = $lblstotRasio1Pend-$lblstotRasio1Beban;
        $totLRR2 = $lblstotRasio2Pend-$lblstotRasio2Beban;
        $totLRR3 = $lblstotRasio3Pend-$lblstotRasio3Beban;
        $totLRR4 = $lblstotRasio4Pend-$lblstotRasio4Beban;



        ?>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;Laba (Rugi) Usaha: </td>
                  <td align="right"><?php echo number_format($totLRTh1,0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($totLROp,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($totLROp2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($totLROp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($totLROp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($totLROpBi,0,",","."); ?></td>
          <td align="right"><?php echo number_format($totLROpBi2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($totLROpBi3,0,",","."); ?></td>
                  <td align="right"><?php echo $totLRD1; ?></td>
                  <td align="right"><?php echo $totLRR1; ?></td>
                  <td align="right"><?php echo $totLRR2; ?></td>
                  <td align="right"><?php echo $totLRR3; ?></td>
                  <td align="right"><?php echo $totLRR4; ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
        <!--*decyber END_Line Beban Umum dan Administrasi -->

          <!--*decyber Start_Line PENDAPATAN (BEBAN) NON USAHA -->

          <tr>
                  <td align="center">6.0.00.00.00.00</td> <!--*decyber , ganti ke kode COA baru-->
                  <td align="left">&nbsp;<b>PENDAPATAN (BEBAN) NON USAHA</b></td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
          <?php 

          $kodePend_Dluar="6.1"; //decyber pendapatan diluar usaha,, kodenya dirubah ke coa baru
        $kodeBiaya_Dluar="6.2";
        $kodePos_Dluar="6.3"; //decyber, not_fix kode pos masih ambigu
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.KREDIT-j.DEBIT), 0) AS nilai ,'0' AS nilai2
            FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodePend_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag'
            UNION
            SELECT '0' AS nilai, IFNULL(SUM(j.KREDIT-j.DEBIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
            WHERE ma.MA_KODE LIKE '$kodePend_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
        
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
        $Pend_DLuarUsaha=$rw1["nilai"];
        $Pend_DLuarUsaha2=$rw1["nilai2"];
        $Pend_DLuarUsaha3=$Pend_DLuarUsaha+$Pend_DLuarUsaha2;
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
            FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeBiaya_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag'
            UNION
            SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
            WHERE ma.MA_KODE LIKE '$kodeBiaya_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
        
        
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
        $Biaya_DLuarUsaha=$rw1["nilai"];
        $Biaya_DLuarUsaha2=$rw1["nilai2"];
        $Biaya_DLuarUsaha3=$Biaya_DLuarUsaha+$Biaya_DLuarUsaha2;
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
            FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodePos_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag'
            UNION
            SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
            WHERE ma.MA_KODE LIKE '$kodePos_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
        $Pos_DLuarUsaha=$rw1["nilai"];
        $Pos_DLuarUsaha2=$rw1["nilai2"];
        $Pos_DLuarUsaha3=$Pos_DLuarUsaha+$Pos_DLuarUsaha2;
        
        $SelPendBiaya_DLuar = $Pend_DLuarUsaha - $Biaya_DLuarUsaha;
        $SelPendBiaya_DLuar2 = $Pend_DLuarUsaha2 - $Biaya_DLuarUsaha2;
        $SelPendBiaya_DLuar3 = $SelPendBiaya_DLuar + $SelPendBiaya_DLuar2;
        
        $LR_SblmPajak = $LB_Op + $SelPendBiaya_DLuar - $Pos_DLuarUsaha;
        $LR_SblmPajak2 = $LB_Op2 + $SelPendBiaya_DLuar2 - $Pos_DLuarUsaha2;
        $LR_SblmPajak3 = $LR_SblmPajak + $LR_SblmPajak2;
        
        $lblSelPendBiaya_DLuar=($SelPendBiaya_DLuar<0)?"(".number_format(abs($SelPendBiaya_DLuar),0,",",".").")":number_format($SelPendBiaya_DLuar,0,",",".");
        $lblSelPendBiaya_DLuar2=($SelPendBiaya_DLuar2<0)?"(".number_format(abs($SelPendBiaya_DLuar2),0,",",".").")":number_format($SelPendBiaya_DLuar2,0,",",".");
        $lblSelPendBiaya_DLuar3=($SelPendBiaya_DLuar3<0)?"(".number_format(abs($SelPendBiaya_DLuar3),0,",",".").")":number_format($SelPendBiaya_DLuar3,0,",",".");
        
        $lblLR_SblmPajak=($LR_SblmPajak<0)?"(".number_format(abs($LR_SblmPajak),0,",",".").")":number_format($LR_SblmPajak,0,",",".");
        $lblLR_SblmPajak2=($LR_SblmPajak2<0)?"(".number_format(abs($LR_SblmPajak2),0,",",".").")":number_format($LR_SblmPajak2,0,",",".");
        $lblLR_SblmPajak3=($LR_SblmPajak3<0)?"(".number_format(abs($LR_SblmPajak3),0,",",".").")":number_format($LR_SblmPajak3,0,",",".");
        $lblLR_SblmPajak22=$LR_SblmPajak2;
                ?>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="center">6.0.00.00.00.00</td>
                  <td align="left">&nbsp;PENDAPATAN (BEBAN) NON USAHA</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
          <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
                <?php         
        $stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
        $stotAngPend_DLuarUsaha=$stotAngPend_DLuarUsaha2=$stotAngPend_DLuarUsaha3=$stotDeviasi=0;
        $stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
          
        $sql="SELECT
             IFNULL(SUM(j.NILAI), 0) AS nilai
           FROM anggaran j
             INNER JOIN ma_sak ma
             ON j.FK_MAID = ma.MA_ID
           WHERE ma.MA_KODE LIKE '".$kodePend_Dluar."%'
             AND j.TAHUN = $ta_lr";
        $rsAngTh1=mysql_query($sql);
        $rwAngTh1=mysql_fetch_array($rsAngTh1);
        $stotAngThOp+=$rwAngTh1["nilai"];
        //$stotAngThBOTL_BPO +=$rwAngTh1["nilai"];

        $sql="SELECT
              SUM(t.nilai) AS nilai,
              SUM(t.nilai2) AS nilai2
            FROM (SELECT
                IFNULL(SUM(j.NILAI), 0) AS nilai,
                '0' AS nilai2
                FROM anggaran j
                INNER JOIN ma_sak ma
                  ON j.FK_MAID = ma.MA_ID
                WHERE ma.MA_KODE LIKE '".$kodePend_Dluar."%'
                  AND j.BULAN < $bulan_lr
                  AND j.TAHUN = $ta_lr AND j.flag = '$flag'
                UNION 
                SELECT
                 '0'  AS nilai,
                 IFNULL(SUM(j.NILAI), 0) AS nilai2
               FROM anggaran j
                 INNER JOIN ma_sak ma
                 ON j.FK_MAID = ma.MA_ID
               WHERE ma.MA_KODE LIKE '".$kodePend_Dluar."%'
                 AND j.BULAN = $bulan_lr
                 AND j.TAHUN = $ta_lr AND j.flag = '$flag') t";
        $rsAng1=mysql_query($sql);
        $rwAng1=mysql_fetch_array($rsAng1);
        $stotAngOp +=$rwAng1["nilai"];
        $stotAngOp2 +=$rwAng1["nilai2"];
        $AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
        $stotAngOp3 +=$AngOp3;
        
        $stotAngPend_DLuarUsaha +=$rwAng1["nilai"];
        $stotAngPend_DLuarUsaha2 +=$rwAng1["nilai2"];
        $stotAngPend_DLuarUsaha3 +=$AngOp3;
          
        $Deviasi=$Pend_DLuarUsaha3-$AngOp3;
        $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
        
        $stotDeviasi +=$Deviasi;
        $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
        
        $Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
        $Rasio2=($rwAng1["nilai2"]==0)?0:$Pend_DLuarUsaha2/$rwAng1["nilai2"] * 100;
        $Rasio3=($AngOp3==0)?0:$Pend_DLuarUsaha3/$AngOp3 * 100;
        $Rasio4=($rwAngTh1["nilai"]==0)?0:$Pend_DLuarUsaha3/$rwAngTh1["nilai"] * 100;
        
        $stotRasio1 +=$Rasio1;
        $stotRasio2 +=$Rasio2;
        $stotRasio3 +=$Rasio3;
        $stotRasio4 +=$Rasio4;
        
        $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
        $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
        $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
        $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");

        $SelAngThPendBiaya_DLuar = $rwAngTh1["nilai"];
        $SelAngPendBiaya_DLuar = $rwAng1["nilai"];
        $SelAngPendBiaya_DLuar2 = $rwAng1["nilai2"];
        $SelAngPendBiaya_DLuar3 = $AngOp3;

        ?>
                <tr>
                  <td align="center">6.1.00.00.00.00</td>
                  <td align="left">&nbsp;&nbsp;&nbsp;PENDAPATAN NON USAHA</td>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($Pend_DLuarUsaha,0,",","."); ?></td>
          <td align="right"><?php echo number_format($Pend_DLuarUsaha2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($Pend_DLuarUsaha3,0,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <?php         
        $stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
        $stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
          
        $sql="SELECT
             IFNULL(SUM(j.NILAI), 0) AS nilai
           FROM anggaran j
             INNER JOIN ma_sak ma
             ON j.FK_MAID = ma.MA_ID
           WHERE ma.MA_KODE LIKE '".$kodeBiaya_Dluar."%'
             AND j.TAHUN = $ta_lr AND j.flag = '$flag'";
        $rsAngTh1=mysql_query($sql);
        $rwAngTh1=mysql_fetch_array($rsAngTh1);
        $stotAngThOp+=$rwAngTh1["nilai"];
        //$stotAngThBOTL_BPO +=$rwAngTh1["nilai"];

        $sql="SELECT
              SUM(t.nilai) AS nilai,
              SUM(t.nilai2) AS nilai2
            FROM (SELECT
                IFNULL(SUM(j.NILAI), 0) AS nilai,
                '0' AS nilai2
                FROM anggaran j
                INNER JOIN ma_sak ma
                  ON j.FK_MAID = ma.MA_ID
                WHERE ma.MA_KODE LIKE '".$kodeBiaya_Dluar."%'
                  AND j.BULAN < $bulan_lr
                  AND j.TAHUN = $ta_lr AND j.flag = '$flag'
                UNION 
                SELECT
                 '0'  AS nilai,
                 IFNULL(SUM(j.NILAI), 0) AS nilai2
               FROM anggaran j
                 INNER JOIN ma_sak ma
                 ON j.FK_MAID = ma.MA_ID
               WHERE ma.MA_KODE LIKE '".$kodeBiaya_Dluar."%'
                 AND j.BULAN = $bulan_lr
                 AND j.TAHUN = $ta_lr AND j.flag = '$flag') t";
        $rsAng1=mysql_query($sql);
        $rwAng1=mysql_fetch_array($rsAng1);
        $stotAngOp +=$rwAng1["nilai"];
        $stotAngOp2 +=$rwAng1["nilai2"];
        $AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
        $stotAngOp3 +=$AngOp3;
          
        $Deviasi=$Biaya_DLuarUsaha3-$AngOp3;
        $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
        
        $stotDeviasi +=$Deviasi;
        $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
        
        $Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
        $Rasio2=($rwAng1["nilai2"]==0)?0:$Biaya_DLuarUsaha2/$rwAng1["nilai2"] * 100;
        $Rasio3=($AngOp3==0)?0:$Biaya_DLuarUsaha3/$AngOp3 * 100;
        $Rasio4=($rwAngTh1["nilai"]==0)?0:$Biaya_DLuarUsaha3/$rwAngTh1["nilai"] * 100;
        
        $stotRasio1 +=$Rasio1;
        $stotRasio2 +=$Rasio2;
        $stotRasio3 +=$Rasio3;
        $stotRasio4 +=$Rasio4;
        
        $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
        $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
        $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
        $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");

           $SelAngThBeban_DLuar = $rwAngTh1["nilai"];
        $SelAngBeban_DLuar = $rwAng1["nilai"];
        $SelAngBeban_DLuar2 = $rwAng1["nilai2"];
        $SelAngBeban_DLuar3 = $AngOp3;
        ?>
                <tr>
                  <td align="center">6.2.00.00.00.00</td>
                  <td align="left">&nbsp;&nbsp;&nbsp;BEBAN NON USAHA	</td>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($Biaya_DLuarUsaha,0,",","."); ?></td>
          <td align="right"><?php echo number_format($Biaya_DLuarUsaha2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($Biaya_DLuarUsaha3,0,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
               <?php 
          
        // echo $rwAngTh1["nilai"];
       

        $SelPendBiaya_DLuar=$Pend_DLuarUsaha-$Biaya_DLuarUsaha;
        $SelPendBiaya_DLuar2=$Pend_DLuarUsaha2-$Biaya_DLuarUsaha2;
        $SelPendBiaya_DLuar3=$Pend_DLuarUsaha3-$Biaya_DLuarUsaha3;
          
        $Deviasi=$SelPendBiaya_DLuar3-$SelAngPendBiaya_DLuar3;
        $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
        
        $stotDeviasi +=$Deviasi;
        $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
        
        $Rasio1=($Biaya_DLuarUsaha3==0)?0:$Deviasi/$Biaya_DLuarUsaha3 * 100;
        $Rasio2=($SelAngPendBiaya_DLuar2==0)?0:$SelPendBiaya_DLuar2/$SelAngPendBiaya_DLuar2 * 100;
        $Rasio3=($SelAngPendBiaya_DLuar3==0)?0:$SelPendBiaya_DLuar3/$SelAngPendBiaya_DLuar3 * 100;
        $Rasio4=($SelAngThPendBiaya_DLuar==0)?0:$SelPendBiaya_DLuar3/$SelAngThPendBiaya_DLuar * 100;
        
        $stotRasio1 +=$Rasio1;
        $stotRasio2 +=$Rasio2;
        $stotRasio3 +=$Rasio3;
        $stotRasio4 +=$Rasio4;
        
        $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
        $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
        $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
        $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
        ?>
               <!-- disini sebelumnya jumlah selisih pendapatan -->
                <?php         
        $stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
        $stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
          
        $sql="SELECT
             IFNULL(SUM(j.NILAI), 0) AS nilai
           FROM anggaran j
             INNER JOIN ma_sak ma
             ON j.FK_MAID = ma.MA_ID
           WHERE ma.MA_KODE LIKE '".$kodePos_Dluar."%'
             AND j.TAHUN = $ta_lr AND j.flag = '$flag'";
        $rsAngTh1=mysql_query($sql);
        $rwAngTh1=mysql_fetch_array($rsAngTh1);
        $stotAngThOp+=$rwAngTh1["nilai"];
        $stotAngThBOTL_BPO +=$rwAngTh1["nilai"];
        $AngThPos_DLuarUsaha=$rwAngTh1["nilai"];

        $sql="SELECT
              SUM(t.nilai) AS nilai,
              SUM(t.nilai2) AS nilai2
            FROM (SELECT
                IFNULL(SUM(j.NILAI), 0) AS nilai,
                '0' AS nilai2
                FROM anggaran j
                INNER JOIN ma_sak ma
                  ON j.FK_MAID = ma.MA_ID
                WHERE ma.MA_KODE LIKE '".$kodePos_Dluar."%'
                  AND j.BULAN < $bulan_lr
                  AND j.TAHUN = $ta_lr AND j.flag = '$flag' 
                UNION 
                SELECT
                 '0'  AS nilai,
                 IFNULL(SUM(j.NILAI), 0) AS nilai2
               FROM anggaran j
                 INNER JOIN ma_sak ma
                 ON j.FK_MAID = ma.MA_ID
               WHERE ma.MA_KODE LIKE '".$kodePos_Dluar."%'
                 AND j.BULAN = $bulan_lr
                 AND j.TAHUN = $ta_lr AND j.flag = '$flag') t";
        $rsAng1=mysql_query($sql);
        $rwAng1=mysql_fetch_array($rsAng1);
        $stotAngOp +=$rwAng1["nilai"];
        $stotAngOp2 +=$rwAng1["nilai2"];
        $AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
        $stotAngOp3 +=$AngOp3;
        
        $AngPos_DLuarUsaha=$rwAng1["nilai"];
        $AngPos_DLuarUsaha2=$rwAng1["nilai2"];
        $AngPos_DLuarUsaha3=$AngPos_DLuarUsaha+$AngPos_DLuarUsaha2;
        
        $stotAngPend_DLuarUsaha +=$rwAng1["nilai"];
        $stotAngPend_DLuarUsaha2 +=$rwAng1["nilai2"];
        $stotAngPend_DLuarUsaha3 +=$AngOp3;
          
        $Deviasi=$Pos_DLuarUsaha3-$AngOp3;
        $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
        
        $stotDeviasi +=$Deviasi;
        $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
        
        $Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
        $Rasio2=($rwAng1["nilai2"]==0)?0:$Pos_DLuarUsaha2/$rwAng1["nilai2"] * 100;
        $Rasio3=($AngOp3==0)?0:$Pos_DLuarUsaha3/$AngOp3 * 100;
        $Rasio4=($rwAngTh1["nilai"]==0)?0:$Pos_DLuarUsaha3/$rwAngTh1["nilai"] * 100;
        
        $stotRasio1 +=$Rasio1;
        $stotRasio2 +=$Rasio2;
        $stotRasio3 +=$Rasio3;
        $stotRasio4 +=$Rasio4;
        
        $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
        $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
        $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
        $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");

     $SelAngThPendBiaya_DLuar=$SelAngThPendBiaya_DLuar-$SelAngThBeban_DLuar-$rwAngTh1["nilai"];
         $SelAngPendBiaya_DLuar=$SelAngPendBiaya_DLuar-$SelAngBeban_DLuar-$rwAng1["nilai"];
        $SelAngPendBiaya_DLuar2=$SelAngPendBiaya_DLuar2-$SelAngBeban_DLuar2-$rwAng1["nilai2"];
        $SelAngPendBiaya_DLuar3=$SelAngPendBiaya_DLuar3-$SelAngBeban_DLuar3-$AngOp3;

        $SelPendBiaya_DLuar=$Pend_DLuarUsaha-$Biaya_DLuarUsaha-$Pos_DLuarUsaha;
        $SelPendBiaya_DLuar2=$Pend_DLuarUsaha2-$Biaya_DLuarUsaha2-$Pos_DLuarUsaha2;
        $SelPendBiaya_DLuar3=$Pend_DLuarUsaha3-$Biaya_DLuarUsaha3-$Pos_DLuarUsaha3;
          
        
        ?>
                <tr>
                  <td align="center">6.3.00.00.00.00</td>
                  <td align="left">&nbsp;BEBAN KEUANGAN</td>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($Pos_DLuarUsaha,0,",","."); ?></td>
          <td align="right"><?php echo number_format($Pos_DLuarUsaha2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($Pos_DLuarUsaha3,0,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                 <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp; JUMLAH Pendapatan (Beban) Non Usaha: </td>
                  <td align="right"><?php echo number_format($SelAngThPendBiaya_DLuar,0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($SelAngPendBiaya_DLuar,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelAngPendBiaya_DLuar2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelAngPendBiaya_DLuar3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelAngPendBiaya_DLuar3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelPendBiaya_DLuar,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelPendBiaya_DLuar2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelPendBiaya_DLuar3,0,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>

                <?php
        $kodeMaOp="6"; //*decyber ganti ke COA baru yg awalnya 810
//        $sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaOp'";
// echo $sql."<br>";
//        $rsB=mysql_query($sql);
// $rwB=mysql_fetch_array($rsB);

// $cma_id=$rwB["MA_KODE"];

        $sqln="SELECT * FROM ma_sak WHERE MA_KODE Like '$kodeMaOp%' ORDER BY MA_KODE"; //*decyber penambahan untuk memunculkan semua beban anak kedua
                $rsBn=mysql_query($sqln); //decyber
                // while ($rwBn=mysql_fetch_array($rsBn)){//decyber
                  $rwBn=mysql_fetch_array($rsBn);
                  // $nama_MA_BPO=$rwBn["MA_NAMA"];
                  $cma_id_new=$rwBn['MA_KODE'];
                // $sql="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id_new' OR MA_KODE = '$cma_id_new' ORDER BY MA_ID";//decyber, penambahan kondisi
                // var_dump($rwBn);
                $sql="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id_new'  AND MA_KODE != '6.4'  ORDER BY MA_ID";//decyber, penambahan kondisi

        // echo $sql."<br>";
                $rsB=mysql_query($sql);
        
        $stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
        $stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
        $stotBiayaOp=$stotBiayaOp2=$stotBiayaOp3=0;
        while ($rwB=mysql_fetch_array($rsB)){
        //  echo '<pre>';
        // var_dump($rwB);
        // echo '</pre>';
        // echo '---------------------------------------------------------------';
          $i++;
          $kode_MA_BPO=$rwB["MA_KODE"];
          $kode_MA_BPO_VIEW=$rwB["MA_KODE_VIEW"]; //*decyber ganti ma_kode jd ma_kode_view
          $kode_MA_BPO_KP=$rwB["MA_KODE_KP"];
          $nama_MA_BPO=$rwB["MA_NAMA"];
          
                    $sql="SELECT
               IFNULL(SUM(j.NILAI), 0) AS nilai
             FROM anggaran j
               INNER JOIN ma_sak ma
               ON j.FK_MAID = ma.MA_ID
             WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
               AND j.TAHUN = $ta_lr AND j.flag = '$flag'";
                    $rsAngTh1=mysql_query($sql);
                    $rwAngTh1=mysql_fetch_array($rsAngTh1);
                    if($stotAngThOp == 0){
                    $stotAngThOp=$rwAngTh1["nilai"];
                    // echo "Total ".$stotAngThOp;
                  }else{
                    $stotAngThOp-=$rwAngTh1["nilai"];
                    // echo "haha ".$stotAngThOp;

                    }
                    // $stotAngThOp=$stotAngThOp-$rwAngTh1["nilai"];
                    // echo "Nilai ".$rwAngTh1["nilai"]."<br>";
                    $sql="SELECT
                SUM(t.nilai) AS nilai,
                SUM(t.nilai2) AS nilai2
              FROM (SELECT
                  IFNULL(SUM(j.NILAI), 0) AS nilai,
                  '0' AS nilai2
                  FROM anggaran j
                  INNER JOIN ma_sak ma
                    ON j.FK_MAID = ma.MA_ID
                  WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
                    AND j.BULAN < $bulan_lr
                    AND j.TAHUN = $ta_lr AND j.flag = '$flag'
                  UNION 
                  SELECT
                   '0'  AS nilai,
                   IFNULL(SUM(j.NILAI), 0) AS nilai2
                 FROM anggaran j
                   INNER JOIN ma_sak ma
                   ON j.FK_MAID = ma.MA_ID
                 WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
                   AND j.BULAN = $bulan_lr
                   AND j.TAHUN = $ta_lr AND j.flag = '$flag') t";
                    $rsAng1=mysql_query($sql);
                    $rwAng1=mysql_fetch_array($rsAng1);
                    if($stotAngOp == 0){
                      $stotAngOp=$rwAng1["nilai"];
                    }else{
                      $stotAngOp-=$rwAng1["nilai"];
                      }
                    // $stotAngOp -=$rwAng1["nilai"];
                    
                    if($stotAngOp2 == 0){
                      $stotAngOp2=$rwAng1["nilai2"];
                    }else{
                      $stotAngOp2-=$rwAng1["nilai2"];
                      }
          // $stotAngOp2 -=$rwAng1["nilai2"];
          $AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
          $stotAngOp3 =$stotAngOp + $stotAngOp2;
          
          $sqlBPOSub="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
          
          
          $rsBPOSub=mysql_query($sqlBPOSub);
          $rwBPOSub=mysql_fetch_array($rsBPOSub);
          $biayaBPO=$rwBPOSub["nilai"];
          $biayaBPO2=$rwBPOSub["nilai2"];
          $biayaBPO3=$biayaBPO+$biayaBPO2;
          

          if($stotBiayaOp == 0){
            $stotBiayaOp=$biayaBPO;
          }else{
            $stotBiayaOp-=$biayaBPO;
            }
          // echo $stotBiayaOp." Biaya";
          // $stotBiayaOp +=$biayaBPO;
          if($stotBiayaOp2 == 0){
            $stotBiayaOp2=$biayaBPO2;
          }else{
            $stotBiayaOp2-=$biayaBPO2;
            }
          // $stotBiayaOp2 +=$biayaBPO2;
          
          $Deviasi=$biayaBPO3-$AngOp3;
          $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
          
          $stotDeviasi +=$Deviasi;
          $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
          
          $Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
          $Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
          $Rasio3=($AngOp3==0)?0:$biayaBPO3/$AngOp3 * 100;
          $Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPO3/$rwAngTh1["nilai"] * 100;
          
          $stotRasio1 +=$Rasio1;
          $stotRasio2 +=$Rasio2;
          $stotRasio3 +=$Rasio3;
          $stotRasio4 +=$Rasio4;
          
          $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
          $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
          $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
          $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
        ?>
                <!-- <tr>
                  <td align="center"><?php 
                  if($rwB['MA_KODE'] == $cma_id_new){
                    echo "<b>".$kode_MA_BPO_VIEW."</b>";//decyber, ksih kondisi biar agak tebal
                  }else{
                  echo $kode_MA_BPO_VIEW;
                  } ?></td> -->
           <?php 
                  /*if ($biayaBPO>0 || $biayaBPO2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kode_MA_BPO; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>"><?php echo $nama_MA_BPO; ?></a></td>
                  <?php 
                  }else{*/
                  ?>
                  <!-- <td align="left">&nbsp;&nbsp;&nbsp;
                  <?php   
                  // if($rwB['MA_KODE'] == $cma_id_new){
                    // echo "<b><font size=1.5>".$nama_MA_BPO."</font></b>";//decyber, ksih kondisi biar agak tebal
                  // }else{
                  // echo $nama_MA_BPO;
                  // } ?></td>
                  <?php 
                  //}
                  ?>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO3,0,",","."); ?></td>
                  <td align="right"><?php echo $lblDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr> -->
                <?php 
        }
      // }
        $stotBiayaOp3=$stotBiayaOp+$stotBiayaOp2;
        
        $stotRasio2=$stotRasio2/$i;
        $stotRasio3=$stotRasio3/$i;
        $stotRasio4=$stotRasio4/$i;
        
        $lblstotRasio1=($stotRasio1<0)?"(".number_format(abs($stotRasio1),0,",",".").")":number_format($stotRasio1,0,",",".");
        $lblstotRasio2=($stotRasio2<0)?"(".number_format(abs($stotRasio2),0,",",".").")":number_format($stotRasio2,0,",",".");
        $lblstotRasio3=($stotRasio3<0)?"(".number_format(abs($stotRasio3),0,",",".").")":number_format($stotRasio3,0,",",".");
        $lblstotRasio4=($stotRasio4<0)?"(".number_format(abs($stotRasio4),0,",",".").")":number_format($stotRasio4,0,",",".");

        $stotAngThPjk = $stotAngThOp+$totLRTh1;
        $stotAngPjk = $stotAngOp+$totLROp;
        $stotAngPjk2 = $stotAngOp2+$totLROp2;
        $stotAngPjk3 = $stotAngOp3+$totLROp3;
        $stotAngPjk3 = $stotAngOp3+$totLROp3;
        $stotBiayaPjk = $SelPendBiaya_DLuar+$totLROpBi;
        $stotBiayaPjk2 = $SelPendBiaya_DLuar2+$totLROpBi2;
        $stotBiayaPjk3 = $SelPendBiaya_DLuar3+$totLROpBi3;

        $Deviasi = $stotBiayaOp3-$stotAngOp3;
        $lbltotDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");

        $DeviasiLrSp = $stotBiayaPjk3-$stotAngPjk3;
        $deviasiLrSp=($DeviasiLrSp<0)?"(".number_format(abs($DeviasiLrSp),0,",",".").")":number_format($DeviasiLrSp,0,",",".");
        
        // $lbltotDeviasi = $stotDeviasi+$DeviasiLblTot;
        // echo $stotBiayaOp3;
        $lblstotRasio1 = $lblstotRasio1+$totLRR1;
        $lblstotRasio2 = $lblstotRasio2+$totLRR2;
        $lblstotRasio3 = $lblstotRasio3+$totLRR3;
        $lblstotRasio4 = $lblstotRasio4+$totLRR4;


        ?>
                <!-- <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;JUMLAH Pendapatan (Beban) Non Usaha: </td>
                  <td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotBiayaOp,0,",","."); ?></td>
          <td align="right"><?php echo number_format($stotBiayaOp2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotBiayaOp3,0,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr> -->

              

                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;Laba Rugi Sebelum Pajak: </td>
                  <td align="right"><?php echo number_format($stotAngThPjk,0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($stotAngPjk,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngPjk2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngPjk3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngPjk3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotBiayaPjk,0,",","."); ?></td>
          <td align="right"><?php echo number_format($stotBiayaPjk2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotBiayaPjk3,0,",","."); ?></td>
                  <td align="right"><?php echo $deviasiLrSp ?></td>
                  <td align="right"><?php echo $lblstotRasio1+$totLRR1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2+$totLRR2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3+$totLRR3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4+$totLRR4; ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
        <!--*decyber END_Line PENDAPATAN (BEBAN) NON USAHA -->


        <?php 

        


        $kodeMaOp="6"; //*decyber ganti ke COA baru yg awalnya 810
//        $sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaOp'";
// echo $sql."<br>";
//        $rsB=mysql_query($sql);
// $rwB=mysql_fetch_array($rsB);

// $cma_id=$rwB["MA_KODE"];

        $sqln="SELECT * FROM ma_sak WHERE MA_KODE Like '$kodeMaOp%' ORDER BY MA_KODE"; //*decyber penambahan untuk memunculkan semua beban anak kedua
                $rsBn=mysql_query($sqln); //decyber
                // while ($rwBn=mysql_fetch_array($rsBn)){//decyber
                  $rwBn=mysql_fetch_array($rsBn);
                  // $nama_MA_BPO=$rwBn["MA_NAMA"];
                  $cma_id_new=$rwBn['MA_KODE'];
                // $sql="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id_new' OR MA_KODE = '$cma_id_new' ORDER BY MA_ID";//decyber, penambahan kondisi
                // var_dump($rwBn);
                $sql="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id_new'  AND MA_KODE = '6.4'  ORDER BY MA_ID";//decyber, penambahan kondisi

        // echo $sql."<br>";
                $rsB=mysql_query($sql);
        
        $stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
        $stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
        $stotBiayaOp=$stotBiayaOp2=$stotBiayaOp3=0;
        while ($rwB=mysql_fetch_array($rsB)){
        //  echo '<pre>';
        // var_dump($rwB);
        // echo '</pre>';
        // echo '---------------------------------------------------------------';
          $i++;
          $kode_MA_BPO=$rwB["MA_KODE"];
          $kode_MA_BPO_VIEW=$rwB["MA_KODE_VIEW"]; //*decyber ganti ma_kode jd ma_kode_view
          $kode_MA_BPO_KP=$rwB["MA_KODE_KP"];
          $nama_MA_BPO=$rwB["MA_NAMA"];
          
                    $sql="SELECT
               IFNULL(SUM(j.NILAI), 0) AS nilai
             FROM anggaran j
               INNER JOIN ma_sak ma
               ON j.FK_MAID = ma.MA_ID
             WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
               AND j.TAHUN = $ta_lr AND j.flag = '$flag'";
                    $rsAngTh1=mysql_query($sql);
                    $rwAngTh1=mysql_fetch_array($rsAngTh1);
                  //   if($stotAngThOp == 0){
                  //   $stotAngThOp=$rwAngTh1["nilai"];
                  //   // echo "Total ".$stotAngThOp;
                  // }else{
                    $stotAngThOp+=$rwAngTh1["nilai"];
                  //   // echo "haha ".$stotAngThOp;

                  //   }
                    // $stotAngThOp=$stotAngThOp-$rwAngTh1["nilai"];
                    // echo "Nilai ".$rwAngTh1["nilai"]."<br>";
                    $sql="SELECT
                SUM(t.nilai) AS nilai,
                SUM(t.nilai2) AS nilai2
              FROM (SELECT
                  IFNULL(SUM(j.NILAI), 0) AS nilai,
                  '0' AS nilai2
                  FROM anggaran j
                  INNER JOIN ma_sak ma
                    ON j.FK_MAID = ma.MA_ID
                  WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
                    AND j.BULAN < $bulan_lr
                    AND j.TAHUN = $ta_lr AND j.flag = '$flag'
                  UNION 
                  SELECT
                   '0'  AS nilai,
                   IFNULL(SUM(j.NILAI), 0) AS nilai2
                 FROM anggaran j
                   INNER JOIN ma_sak ma
                   ON j.FK_MAID = ma.MA_ID
                 WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
                   AND j.BULAN = $bulan_lr
                   AND j.TAHUN = $ta_lr AND j.flag = '$flag') t";
                    $rsAng1=mysql_query($sql);
                    $rwAng1=mysql_fetch_array($rsAng1);
                    // if($stotAngOp == 0){
                    //   $stotAngOp=$rwAng1["nilai"];
                    // }else{
                    //   $stotAngOp-=$rwAng1["nilai"];
                    //   }
                    $stotAngOp +=$rwAng1["nilai"];
                    
                    // if($stotAngOp2 == 0){
                    //   $stotAngOp2=$rwAng1["nilai2"];
                    // }else{
                    //   $stotAngOp2-=$rwAng1["nilai2"];
                    //   }
          $stotAngOp2 +=$rwAng1["nilai2"];
          $AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
          $stotAngOp3 =$stotAngOp + $stotAngOp2;
          
          $sqlBPOSub="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
          
          
          $rsBPOSub=mysql_query($sqlBPOSub);
          $rwBPOSub=mysql_fetch_array($rsBPOSub);
          $biayaBPO=$rwBPOSub["nilai"];
          $biayaBPO2=$rwBPOSub["nilai2"];
          $biayaBPO3=$biayaBPO+$biayaBPO2;
          
          $stotAngThPjk += $stotAngThOp;
          $stotAngPjk += $stotAngOp;
          $stotAngPjk2 += $stotAngOp2;
          $stotAngPjk3 += $stotAngOp3;
          $stotAngPjk3 += $stotAngOp3;
          $stotBiayaPjk += $stotBiayaOp;
          $stotBiayaPjk2 += $stotBiayaOp2;
          $stotBiayaPjk3 += $stotBiayaOp3;
          $lbltotDeviasi = $lbltotDeviasi;
          $lblstotRasio1 = $lblstotRasio1;
          $lblstotRasio2 = $lblstotRasio2;
          $lblstotRasio3 = $lblstotRasio3;
          $lblstotRasio4 = $lblstotRasio4;

          // if($stotBiayaOp == 0){
          //   $stotBiayaOp=$biayaBPO;
          // }else{
          //   $stotBiayaOp-=$biayaBPO;
          //   }
          // echo $stotBiayaOp." Biaya";
          $stotBiayaOp +=$biayaBPO;
          // if($stotBiayaOp2 == 0){
          //   $stotBiayaOp2=$biayaBPO2;
          // }else{
          //   $stotBiayaOp2-=$biayaBPO2;
          //   }
          $stotBiayaOp2 +=$biayaBPO2;
          
          $Deviasi=$biayaBPO3-$AngOp3;
          $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
          
          $stotDeviasi +=$Deviasi;
          $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
          
          $Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
          $Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
          $Rasio3=($AngOp3==0)?0:$biayaBPO3/$AngOp3 * 100;
          $Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPO3/$rwAngTh1["nilai"] * 100;
          
          $stotRasio1 +=$Rasio1;
          $stotRasio2 +=$Rasio2;
          $stotRasio3 +=$Rasio3;
          $stotRasio4 +=$Rasio4;
          
          $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
          $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
          $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
          $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
        ?>
                <tr>
                  <td align="center"><?php 
                  if($rwB['MA_KODE'] == $cma_id_new){
                    echo "<b>".$kode_MA_BPO_VIEW."</b>";//decyber, ksih kondisi biar agak tebal
                  }else{
                  echo $kode_MA_BPO_VIEW;
                  } ?></td>
           <?php 
                  /*if ($biayaBPO>0 || $biayaBPO2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kode_MA_BPO; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>"><?php echo $nama_MA_BPO; ?></a></td>
                  <?php 
                  }else{*/
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;
                  <?php   
                  if($rwB['MA_KODE'] == $cma_id_new){
                    echo "<b><font size=1.5>".$nama_MA_BPO."</font></b>";//decyber, ksih kondisi biar agak tebal
                  }else{
                  echo $nama_MA_BPO;
                  } ?></td>
                  <?php 
                  //}
                  ?>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO3,0,",","."); ?></td>
                  <td align="right"><?php echo $lblDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <?php 
        }
      // }
        $stotBiayaOp3=$stotBiayaOp+$stotBiayaOp2;
        
        $stotRasio2=$stotRasio2/$i;
        $stotRasio3=$stotRasio3/$i;
        $stotRasio4=$stotRasio4/$i;
        
        $lblstotRasio1=($stotRasio1<0)?"(".number_format(abs($stotRasio1),0,",",".").")":number_format($stotRasio1,0,",",".");
        $lblstotRasio2=($stotRasio2<0)?"(".number_format(abs($stotRasio2),0,",",".").")":number_format($stotRasio2,0,",",".");
        $lblstotRasio3=($stotRasio3<0)?"(".number_format(abs($stotRasio3),0,",",".").")":number_format($stotRasio3,0,",",".");
        $lblstotRasio4=($stotRasio4<0)?"(".number_format(abs($stotRasio4),0,",",".").")":number_format($stotRasio4,0,",",".");

         $DeviasiVentura = $DeviasiLrSp-$stotDeviasi;
        $deviasiVenturaLbl=($DeviasiVentura<0)?"(".number_format(abs($DeviasiVentura),0,",",".").")":number_format($DeviasiVentura,0,",",".");
        ?>

                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;Jumlah Laba (Rugi) dari Entitas Asosiasi/Ventura Bersama </td>
                  <td align="right"><?php echo number_format($stotAngThPjk,0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($stotAngPjk,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngPjk2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngPjk3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngPjk3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotBiayaPjk,0,",","."); ?></td>
          <td align="right"><?php echo number_format($stotBiayaPjk2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotBiayaPjk3,0,",","."); ?></td>
                  <td align="right"><?php echo $deviasiVenturaLbl; ?></td>
                  <td align="right"><?php echo $lblstotRasio1+$totLRR1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2+$totLRR2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3+$totLRR3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4+$totLRR4; ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>


            <!--*decyber Start_Line PENDAPATAN (BEBAN) NON USAHA -->
            <?php 
        // $kodeMaOp="6"; //*decyber ganti ke COA baru yg awalnya 810
//        $sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaOp'";
// echo $sql."<br>";
//        $rsB=mysql_query($sql);
// $rwB=mysql_fetch_array($rsB);

// $cma_id=$rwB["MA_KODE"];

        $sqln="SELECT * FROM ma_sak WHERE MA_LEVEL IN (1,2) AND (MA_KODE Like '7%' OR MA_KODE LIKE '8%' OR MA_KODE LIKE '9%') ORDER BY MA_KODE"; //*decyber penambahan untuk memunculkan semua beban anak kedua
        // echo $sqln;
                $rsB=mysql_query($sqln); //decyber
        //         while ($rwBn=mysql_fetch_array($rsBn)){//decyber
        //           // $rwBn=mysql_fetch_array($rsBn);
        //           // $nama_MA_BPO=$rwBn["MA_NAMA"];
        //           $cma_id_new=$rwBn['MA_KODE'];
        //         // $sql="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id_new' OR MA_KODE = '$cma_id_new' ORDER BY MA_ID";//decyber, penambahan kondisi
        //         // var_dump($rwBn);
        //         $sql="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id_new' OR MA_KODE = '$cma_id_new' ORDER BY MA_ID";//decyber, penambahan kondisi

        // echo $sql."<br>";
        //         $rsB=mysql_query($sql);
        $stotAngOp=$stotAngOp2=$stotDeviasi=0;
        $stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
        $stotBiayaOp=$stotBiayaOp2=$stotBiayaOp3=0;

        $stotAngThOp=$stotAngThPjk;
        $stotAngOp=$stotAngPjk;
        $stotAngOp2=$stotAngPjk2;
        $stotAngOp3=$stotAngPjk3;
        while ($rwB=mysql_fetch_array($rsB)){
        //  echo '<pre>';
        // var_dump($rwB);
        // echo '</pre>';
        // echo '---------------------------------------------------------------';
          $i++;
          $kode_MA_BPO=$rwB["MA_KODE"];
          $kode_MA_BPO_VIEW=$rwB["MA_KODE_VIEW"]; //*decyber ganti ma_kode jd ma_kode_view
          $kode_MA_BPO_KP=$rwB["MA_KODE_KP"];
          $nama_MA_BPO=$rwB["MA_NAMA"];
          
                    $sql="SELECT
               IFNULL(SUM(j.NILAI), 0) AS nilai
             FROM anggaran j
               INNER JOIN ma_sak ma
               ON j.FK_MAID = ma.MA_ID
             WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
               AND j.TAHUN = $ta_lr AND j.flag = '$flag'";
                    $rsAngTh1=mysql_query($sql);
                    $rwAngTh1=mysql_fetch_array($rsAngTh1);
                    if($rwB["MA_KODE"] == '7'){
                    $stotAngThOp=$stotAngThOp-$rwAngTh1["nilai"];
                    }
                    $sql="SELECT
                SUM(t.nilai) AS nilai,
                SUM(t.nilai2) AS nilai2
              FROM (SELECT
                  IFNULL(SUM(j.NILAI), 0) AS nilai,
                  '0' AS nilai2
                  FROM anggaran j
                  INNER JOIN ma_sak ma
                    ON j.FK_MAID = ma.MA_ID
                  WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
                    AND j.BULAN < $bulan_lr
                    AND j.TAHUN = $ta_lr AND j.flag = '$flag'
                  UNION 
                  SELECT
                   '0'  AS nilai,
                   IFNULL(SUM(j.NILAI), 0) AS nilai2
                 FROM anggaran j
                   INNER JOIN ma_sak ma
                   ON j.FK_MAID = ma.MA_ID
                 WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
                   AND j.BULAN = $bulan_lr
                   AND j.TAHUN = $ta_lr) t";
                    $rsAng1=mysql_query($sql);
                    $rwAng1=mysql_fetch_array($rsAng1);
                    if($rwB["MA_KODE"] == '7'){
                      // $stotAngThOp=$stotAngThOp-$rwAngTh1["nilai"];
                    $stotAngOp -=$rwAng1["nilai"];

                      }
                    if($rwB["MA_KODE"] == '7'){
          $stotAngOp2 -=$rwAng1["nilai2"];
                    }
          $AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
          if($rwB["MA_KODE"] == '7'){
          $stotAngOp3 -=$AngOp3;
          }
          $sqlBPOSub="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
          
          
          $rsBPOSub=mysql_query($sqlBPOSub);
          $rwBPOSub=mysql_fetch_array($rsBPOSub);
          $biayaBPO=$rwBPOSub["nilai"];
          $biayaBPO2=$rwBPOSub["nilai2"];
          $biayaBPO3=$biayaBPO+$biayaBPO2;
          
          $stotBiayaOp +=$biayaBPO;
          $stotBiayaOp2 +=$biayaBPO2;
          
          $Deviasi=$biayaBPO3-$AngOp3;
          $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
          
          $stotDeviasi +=$Deviasi;
          $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
          
          $Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
          $Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
          $Rasio3=($AngOp3==0)?0:$biayaBPO3/$AngOp3 * 100;
          $Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPO3/$rwAngTh1["nilai"] * 100;
          
          $stotRasio1 +=$Rasio1;
          $stotRasio2 +=$Rasio2;
          $stotRasio3 +=$Rasio3;
          $stotRasio4 +=$Rasio4;
          
          $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
          $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
          $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
          $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
        ?>
                <tr>
                  <td align="center"><?php 
                  if($rwB['MA_KODE'] == $cma_id_new){
                    echo "<b>".$kode_MA_BPO_VIEW."</b>";//decyber, ksih kondisi biar agak tebal
                  }else{
                  echo $kode_MA_BPO_VIEW;
                  } ?></td>
           <?php 
                  /*if ($biayaBPO>0 || $biayaBPO2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kode_MA_BPO; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr AND j.flag = '$flag'=<?php echo $ta_lr AND j.flag = '$flag'; ?>"><?php echo $nama_MA_BPO; ?></a></td>
                  <?php 
                  }else{*/
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;
                  <?php   
                  if($rwB['MA_KODE'] == $cma_id_new){
                    echo "<b><font size=1.5>".$nama_MA_BPO."</font></b>";//decyber, ksih kondisi biar agak tebal
                  }else{
                  echo $nama_MA_BPO;
                  } ?></td>
                  <?php 
                  //}
                  ?>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO3,0,",","."); ?></td>
                  <td align="right"><?php echo $lblDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <?php 
        }
      // }
        $stotBiayaOp3=$stotBiayaOp+$stotBiayaOp2;
        
        $stotRasio2=$stotRasio2/$i;
        $stotRasio3=$stotRasio3/$i;
        $stotRasio4=$stotRasio4/$i;
        
        $lblstotRasio1=($stotRasio1<0)?"(".number_format(abs($stotRasio1),0,",",".").")":number_format($stotRasio1,0,",",".");
        $lblstotRasio2=($stotRasio2<0)?"(".number_format(abs($stotRasio2),0,",",".").")":number_format($stotRasio2,0,",",".");
        $lblstotRasio3=($stotRasio3<0)?"(".number_format(abs($stotRasio3),0,",",".").")":number_format($stotRasio3,0,",",".");
        $lblstotRasio4=($stotRasio4<0)?"(".number_format(abs($stotRasio4),0,",",".").")":number_format($stotRasio4,0,",",".");
        
        ?>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;Laba (Rugi) Komprehensif Tahun Berjalan: </td>
                  <td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotBiayaPjk,0,",","."); ?></td>
          <td align="right"><?php echo number_format($stotBiayaPjk2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotBiayaPjk3,0,",","."); ?></td>
                  <td align="right"><?php echo $deviasiVenturaLbl; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <!-- <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr> -->
        <!--*decyber END_Line PENDAPATAN (BEBAN) NON USAHA -->




        
                <?php 
        }elseif($jbeban=="1"){
        ?>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left" style="text-transform:uppercase;">&nbsp;Beban Usaha Menurut Jenis</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
          <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
        <?php
          $stotbJneis=$stotbJneisb=$stotbJneisa=0;
          $sql="SELECT * FROM ak_ms_beban_jenis WHERE level=1 AND aktif=1 ORDER BY kode";
          $rsBJenis=mysql_query($sql);
          while ($rwBJenis=mysql_fetch_array($rsBJenis)){
            $cidbJenis=$rwBJenis["id"];
            $ckode=explode(".",$rwBJenis["kode"]);
            $clvl=$rwBJenis["level"];
            $lblnama=$rwBJenis["nama"];
            $cislast=$rwBJenis["islast"];
            
            $skode=$ckode[0];
            $lblkode=$ckode[0];
            
            $stotAngThBJenis=$stotAngBJenis=$stotAngBJenis2=$stotAngBJenis3=$stotDeviasi=0;
            $stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
              
            $sql="SELECT
                 IFNULL(SUM(j.NILAI), 0) AS nilai
               FROM anggaran j
                 INNER JOIN ma_sak ma
                 ON j.FK_MAID = ma.MA_ID
               WHERE ma.MA_KODE LIKE '".$lblkode."%'
                 AND j.TAHUN = $ta_lr AND j.flag = '$flag'";
            $rsAngTh1=mysql_query($sql);
            $rwAngTh1=mysql_fetch_array($rsAngTh1);
            $stotAngThBJenis+=$rwAngTh1["nilai"];
    
            $sql="SELECT
                  SUM(t.nilai) AS nilai,
                  SUM(t.nilai2) AS nilai2
                FROM (SELECT
                    IFNULL(SUM(j.NILAI), 0) AS nilai,
                    '0' AS nilai2
                    FROM anggaran j
                    INNER JOIN ma_sak ma
                      ON j.FK_MAID = ma.MA_ID
                    WHERE ma.MA_KODE LIKE '".$lblkode."%'
                      AND j.BULAN < $bulan_lr
                      AND j.TAHUN = $ta_lr AND j.flag = '$flag'
                    UNION 
                    SELECT
                     '0'  AS nilai,
                     IFNULL(SUM(j.NILAI), 0) AS nilai2
                   FROM anggaran j
                     INNER JOIN ma_sak ma
                     ON j.FK_MAID = ma.MA_ID
                   WHERE ma.MA_KODE LIKE '".$lblkode."%'
                     AND j.BULAN = $bulan_lr
                     AND j.TAHUN = $ta_lr AND j.flag = '$flag') t";
            $rsAng1=mysql_query($sql);
            $rwAng1=mysql_fetch_array($rsAng1);
            $stotAngBJenis +=$rwAng1["nilai"];
            $stotAngBJenis2 +=$rwAng1["nilai2"];
            $AngBJenis3=$rwAng1["nilai"]+$rwAng1["nilai2"];
            $stotAngBJenis3 +=$AngBJenis3;
            
            $sqlbJenis="SELECT *
                  FROM ((SELECT
                       IFNULL(SUM(j.DEBIT),0) AS nilaib
                       FROM jurnal j
                       INNER JOIN ak_ms_beban_jenis mbj
                         ON j.MS_BEBAN_JENIS_ID = mbj.id
                       WHERE mbj.kode LIKE '$lblkode%'
                         AND MONTH(j.TGL) < $bulan_lr
                         AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') AS nilaib,
                     (SELECT
                      IFNULL(SUM(j.DEBIT),0) AS nilai
                    FROM jurnal j
                      INNER JOIN ak_ms_beban_jenis mbj
                      ON j.MS_BEBAN_JENIS_ID = mbj.id
                    WHERE mbj.kode LIKE '$lblkode%'
                      AND MONTH(j.TGL) = $bulan_lr
                      AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') AS nilai)";
            $rsnilaibJenis=mysql_query($sqlbJenis);
            $rwnilaibJenis=mysql_fetch_array($rsnilaibJenis);
            $cnilaibJenisb=$rwnilaibJenis["nilaib"];
            $cnilaibJenis=$rwnilaibJenis["nilai"];
            $cnilaibJenisa=$cnilaibJenisb+$cnilaibJenis;
            $stotbJneisb +=$cnilaibJenisb;
            $stotbJneis +=$cnilaibJenis;
            $stotbJneisa +=$cnilaibJenisa;
              
            $Deviasi=$cnilaibJenisa-$AngBJenis3;
            $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
            
            $stotDeviasi +=$Deviasi;
            $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
            
            $Rasio1=($AngBJenis3==0)?0:$Deviasi/$AngBJenis3 * 100;
            $Rasio2=($rwAng1["nilai2"]==0)?0:$cnilaibJenis/$rwAng1["nilai2"] * 100;
            $Rasio3=($AngBJenis3==0)?0:$cnilaibJenisa/$AngBJenis3 * 100;
            $Rasio4=($rwAngTh1["nilai"]==0)?0:$cnilaibJenisa/$rwAngTh1["nilai"] * 100;
            
            $stotRasio1 +=$Rasio1;
            $stotRasio2 +=$Rasio2;
            $stotRasio3 +=$Rasio3;
            $stotRasio4 +=$Rasio4;
            
            $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
            $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
            $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
            $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
        ?>
                <!-- <tr>
                  <td align="center"><?php echo $lblkode; ?></td>
                  <td align="left">&nbsp;<?php echo $lblnama; ?></td>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngBJenis3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngBJenis3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($cnilaibJenisb,0,",","."); ?></td>
          <td align="right"><?php echo number_format($cnilaibJenis,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($cnilaibJenisa,0,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblRasio1; ?></td>
                  <td align="right"><?php echo $lblRasio2; ?></td>
                  <td align="right"><?php echo $lblRasio3; ?></td>
                  <td align="right"><?php echo $lblRasio4; ?></td>
                </tr> -->
        <?php
          }
          
          $LB_Op=$stotOp-$stotbJneisb;
          $LB_Op2=$stotOp2-$stotbJneis;
          $LB_Op3=$LB_Op+$LB_Op2;
          
          $lblLB_Op=($LB_Op<0)?"(".number_format(abs($LB_Op),0,",",".").")":number_format($LB_Op,0,",",".");
          $lblLB_Op2=($LB_Op2<0)?"(".number_format(abs($LB_Op2),0,",",".").")":number_format($LB_Op2,0,",",".");
          $lblLB_Op3=($LB_Op3<0)?"(".number_format(abs($LB_Op3),0,",",".").")":number_format($LB_Op3,0,",",".");
        ?>
                <!-- <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;JUMLAH BEBAN MENURUT JENIS : </td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($stotbJneisb,0,",","."); ?></td>
          <td align="right"><?php echo number_format($stotbJneis,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotbJneisa,0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;LABA / RUGI MENURUT JENIS : </td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo $lblLB_Op; ?></td>
          <td align="right"><?php echo $lblLB_Op2; ?></td>
                  <td align="right"><?php echo $lblLB_Op3; ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr> -->
        <?php
        } 
        $kodePend_Dluar="6.1"; //decyber pendapatan diluar usaha,, kodenya dirubah ke coa baru
        $kodeBiaya_Dluar="6.2";
        $kodePos_Dluar="6.3"; //decyber, not_fix kode pos masih ambigu
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.KREDIT-j.DEBIT), 0) AS nilai ,'0' AS nilai2
            FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodePend_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag'
            UNION
            SELECT '0' AS nilai, IFNULL(SUM(j.KREDIT-j.DEBIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
            WHERE ma.MA_KODE LIKE '$kodePend_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
        
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
        $Pend_DLuarUsaha=$rw1["nilai"];
        $Pend_DLuarUsaha2=$rw1["nilai2"];
        $Pend_DLuarUsaha3=$Pend_DLuarUsaha+$Pend_DLuarUsaha2;
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
            FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeBiaya_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag'
            UNION
            SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
            WHERE ma.MA_KODE LIKE '$kodeBiaya_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
        
        
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
        $Biaya_DLuarUsaha=$rw1["nilai"];
        $Biaya_DLuarUsaha2=$rw1["nilai2"];
        $Biaya_DLuarUsaha3=$Biaya_DLuarUsaha+$Biaya_DLuarUsaha2;
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
            FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodePos_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag'
            UNION
            SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
            WHERE ma.MA_KODE LIKE '$kodePos_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
        $Pos_DLuarUsaha=$rw1["nilai"];
        $Pos_DLuarUsaha2=$rw1["nilai2"];
        $Pos_DLuarUsaha3=$Pos_DLuarUsaha+$Pos_DLuarUsaha2;
        
        $SelPendBiaya_DLuar = $Pend_DLuarUsaha - $Biaya_DLuarUsaha;
        $SelPendBiaya_DLuar2 = $Pend_DLuarUsaha2 - $Biaya_DLuarUsaha2;
        $SelPendBiaya_DLuar3 = $SelPendBiaya_DLuar + $SelPendBiaya_DLuar2;
        
        $LR_SblmPajak = $LB_Op + $SelPendBiaya_DLuar - $Pos_DLuarUsaha;
        $LR_SblmPajak2 = $LB_Op2 + $SelPendBiaya_DLuar2 - $Pos_DLuarUsaha2;
        $LR_SblmPajak3 = $LR_SblmPajak + $LR_SblmPajak2;
        
        $lblSelPendBiaya_DLuar=($SelPendBiaya_DLuar<0)?"(".number_format(abs($SelPendBiaya_DLuar),0,",",".").")":number_format($SelPendBiaya_DLuar,0,",",".");
        $lblSelPendBiaya_DLuar2=($SelPendBiaya_DLuar2<0)?"(".number_format(abs($SelPendBiaya_DLuar2),0,",",".").")":number_format($SelPendBiaya_DLuar2,0,",",".");
        $lblSelPendBiaya_DLuar3=($SelPendBiaya_DLuar3<0)?"(".number_format(abs($SelPendBiaya_DLuar3),0,",",".").")":number_format($SelPendBiaya_DLuar3,0,",",".");
        
        $lblLR_SblmPajak=($LR_SblmPajak<0)?"(".number_format(abs($LR_SblmPajak),0,",",".").")":number_format($LR_SblmPajak,0,",",".");
        $lblLR_SblmPajak2=($LR_SblmPajak2<0)?"(".number_format(abs($LR_SblmPajak2),0,",",".").")":number_format($LR_SblmPajak2,0,",",".");
        $lblLR_SblmPajak3=($LR_SblmPajak3<0)?"(".number_format(abs($LR_SblmPajak3),0,",",".").")":number_format($LR_SblmPajak3,0,",",".");
        $lblLR_SblmPajak22=$LR_SblmPajak2;
                ?>
                <!-- <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="center">6.0.00.00.00.00</td>
                  <td align="left">&nbsp;PENDAPATAN (BEBAN) NON USAHA</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
          <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr> -->
                <?php         
        $stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
        $stotAngPend_DLuarUsaha=$stotAngPend_DLuarUsaha2=$stotAngPend_DLuarUsaha3=$stotDeviasi=0;
        $stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
          
        $sql="SELECT
             IFNULL(SUM(j.NILAI), 0) AS nilai
           FROM anggaran j
             INNER JOIN ma_sak ma
             ON j.FK_MAID = ma.MA_ID
           WHERE ma.MA_KODE LIKE '".$kodePend_Dluar."%'
             AND j.TAHUN = $ta_lr AND j.flag = '$flag'";
        $rsAngTh1=mysql_query($sql);
        $rwAngTh1=mysql_fetch_array($rsAngTh1);
        $stotAngThOp+=$rwAngTh1["nilai"];
        //$stotAngThBOTL_BPO +=$rwAngTh1["nilai"];

        $sql="SELECT
              SUM(t.nilai) AS nilai,
              SUM(t.nilai2) AS nilai2
            FROM (SELECT
                IFNULL(SUM(j.NILAI), 0) AS nilai,
                '0' AS nilai2
                FROM anggaran j
                INNER JOIN ma_sak ma
                  ON j.FK_MAID = ma.MA_ID
                WHERE ma.MA_KODE LIKE '".$kodePend_Dluar."%'
                  AND j.BULAN < $bulan_lr
                  AND j.TAHUN = $ta_lr AND j.flag = '$flag' 
                UNION 
                SELECT
                 '0'  AS nilai,
                 IFNULL(SUM(j.NILAI), 0) AS nilai2
               FROM anggaran j
                 INNER JOIN ma_sak ma
                 ON j.FK_MAID = ma.MA_ID
               WHERE ma.MA_KODE LIKE '".$kodePend_Dluar."%'
                 AND j.BULAN = $bulan_lr
                 AND j.TAHUN = $ta_lr AND j.flag = '$flag') t";
        $rsAng1=mysql_query($sql);
        $rwAng1=mysql_fetch_array($rsAng1);
        $stotAngOp +=$rwAng1["nilai"];
        $stotAngOp2 +=$rwAng1["nilai2"];
        $AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
        $stotAngOp3 +=$AngOp3;
        
        $stotAngPend_DLuarUsaha +=$rwAng1["nilai"];
        $stotAngPend_DLuarUsaha2 +=$rwAng1["nilai2"];
        $stotAngPend_DLuarUsaha3 +=$AngOp3;
          
        $Deviasi=$Pend_DLuarUsaha3-$AngOp3;
        $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
        
        $stotDeviasi +=$Deviasi;
        $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
        
        $Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
        $Rasio2=($rwAng1["nilai2"]==0)?0:$Pend_DLuarUsaha2/$rwAng1["nilai2"] * 100;
        $Rasio3=($AngOp3==0)?0:$Pend_DLuarUsaha3/$AngOp3 * 100;
        $Rasio4=($rwAngTh1["nilai"]==0)?0:$Pend_DLuarUsaha3/$rwAngTh1["nilai"] * 100;
        
        $stotRasio1 +=$Rasio1;
        $stotRasio2 +=$Rasio2;
        $stotRasio3 +=$Rasio3;
        $stotRasio4 +=$Rasio4;
        
        $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
        $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
        $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
        $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");

        $SelAngThPendBiaya_DLuar = $rwAngTh1["nilai"];
        $SelAngPendBiaya_DLuar = $rwAng1["nilai"];
        $SelAngPendBiaya_DLuar2 = $rwAng1["nilai2"];
        $SelAngPendBiaya_DLuar3 = $AngOp3;

        ?>
                <!-- <tr>
                  <td align="center">6.1.00.00.00.00</td>
                  <td align="left">&nbsp;&nbsp;&nbsp;PENDAPATAN NON USAHA</td>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($Pend_DLuarUsaha,0,",","."); ?></td>
          <td align="right"><?php echo number_format($Pend_DLuarUsaha2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($Pend_DLuarUsaha3,0,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr> -->
                <?php         
        $stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
        $stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
          
        $sql="SELECT
             IFNULL(SUM(j.NILAI), 0) AS nilai
           FROM anggaran j
             INNER JOIN ma_sak ma
             ON j.FK_MAID = ma.MA_ID
           WHERE ma.MA_KODE LIKE '".$kodeBiaya_Dluar."%'
             AND j.TAHUN = $ta_lr AND j.flag = '$flag'";
        $rsAngTh1=mysql_query($sql);
        $rwAngTh1=mysql_fetch_array($rsAngTh1);
        $stotAngThOp+=$rwAngTh1["nilai"];
        //$stotAngThBOTL_BPO +=$rwAngTh1["nilai"];

        $sql="SELECT
              SUM(t.nilai) AS nilai,
              SUM(t.nilai2) AS nilai2
            FROM (SELECT
                IFNULL(SUM(j.NILAI), 0) AS nilai,
                '0' AS nilai2
                FROM anggaran j
                INNER JOIN ma_sak ma
                  ON j.FK_MAID = ma.MA_ID
                WHERE ma.MA_KODE LIKE '".$kodeBiaya_Dluar."%'
                  AND j.BULAN < $bulan_lr
                  AND j.TAHUN = $ta_lr AND j.flag = '$flag' 
                UNION 
                SELECT
                 '0'  AS nilai,
                 IFNULL(SUM(j.NILAI), 0) AS nilai2
               FROM anggaran j
                 INNER JOIN ma_sak ma
                 ON j.FK_MAID = ma.MA_ID
               WHERE ma.MA_KODE LIKE '".$kodeBiaya_Dluar."%'
                 AND j.BULAN = $bulan_lr
                 AND j.TAHUN = $ta_lr AND j.flag = '$flag') t";
        $rsAng1=mysql_query($sql);
        $rwAng1=mysql_fetch_array($rsAng1);
        $stotAngOp +=$rwAng1["nilai"];
        $stotAngOp2 +=$rwAng1["nilai2"];
        $AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
        $stotAngOp3 +=$AngOp3;
          
        $Deviasi=$Biaya_DLuarUsaha3-$AngOp3;
        $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
        
        $stotDeviasi +=$Deviasi;
        $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
        
        $Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
        $Rasio2=($rwAng1["nilai2"]==0)?0:$Biaya_DLuarUsaha2/$rwAng1["nilai2"] * 100;
        $Rasio3=($AngOp3==0)?0:$Biaya_DLuarUsaha3/$AngOp3 * 100;
        $Rasio4=($rwAngTh1["nilai"]==0)?0:$Biaya_DLuarUsaha3/$rwAngTh1["nilai"] * 100;
        
        $stotRasio1 +=$Rasio1;
        $stotRasio2 +=$Rasio2;
        $stotRasio3 +=$Rasio3;
        $stotRasio4 +=$Rasio4;
        
        $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
        $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
        $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
        $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");

           $SelAngThBeban_DLuar = $rwAngTh1["nilai"];
        $SelAngBeban_DLuar = $rwAng1["nilai"];
        $SelAngBeban_DLuar2 = $rwAng1["nilai2"];
        $SelAngBeban_DLuar3 = $AngOp3;
        ?>
                <!-- <tr>
                  <td align="center">6.2.00.00.00.00</td>
                  <td align="left">&nbsp;&nbsp;&nbsp;BEBAN NON USAHA	</td>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($Biaya_DLuarUsaha,0,",","."); ?></td>
          <td align="right"><?php echo number_format($Biaya_DLuarUsaha2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($Biaya_DLuarUsaha3,0,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr> -->
               <?php 
          
        // echo $rwAngTh1["nilai"];
       

        $SelPendBiaya_DLuar=$Pend_DLuarUsaha-$Biaya_DLuarUsaha;
        $SelPendBiaya_DLuar2=$Pend_DLuarUsaha2-$Biaya_DLuarUsaha2;
        $SelPendBiaya_DLuar3=$Pend_DLuarUsaha3-$Biaya_DLuarUsaha3;
          
        $Deviasi=$SelPendBiaya_DLuar3-$SelAngPendBiaya_DLuar3;
        $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
        
        $stotDeviasi +=$Deviasi;
        $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
        
        $Rasio1=($Biaya_DLuarUsaha3==0)?0:$Deviasi/$Biaya_DLuarUsaha3 * 100;
        $Rasio2=($SelAngPendBiaya_DLuar2==0)?0:$SelPendBiaya_DLuar2/$SelAngPendBiaya_DLuar2 * 100;
        $Rasio3=($SelAngPendBiaya_DLuar3==0)?0:$SelPendBiaya_DLuar3/$SelAngPendBiaya_DLuar3 * 100;
        $Rasio4=($SelAngThPendBiaya_DLuar==0)?0:$SelPendBiaya_DLuar3/$SelAngThPendBiaya_DLuar * 100;
        
        $stotRasio1 +=$Rasio1;
        $stotRasio2 +=$Rasio2;
        $stotRasio3 +=$Rasio3;
        $stotRasio4 +=$Rasio4;
        
        $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
        $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
        $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
        $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
        ?>
               <!-- disini sebelumnya jumlah selisih pendapatan -->
                <?php         
        $stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
        $stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
          
        $sql="SELECT
             IFNULL(SUM(j.NILAI), 0) AS nilai
           FROM anggaran j
             INNER JOIN ma_sak ma
             ON j.FK_MAID = ma.MA_ID
           WHERE ma.MA_KODE LIKE '".$kodePos_Dluar."%'
             AND j.TAHUN = $ta_lr AND j.flag = '$flag'";
        $rsAngTh1=mysql_query($sql);
        $rwAngTh1=mysql_fetch_array($rsAngTh1);
        $stotAngThOp+=$rwAngTh1["nilai"];
        $stotAngThBOTL_BPO +=$rwAngTh1["nilai"];
        $AngThPos_DLuarUsaha=$rwAngTh1["nilai"];

        $sql="SELECT
              SUM(t.nilai) AS nilai,
              SUM(t.nilai2) AS nilai2
            FROM (SELECT
                IFNULL(SUM(j.NILAI), 0) AS nilai,
                '0' AS nilai2
                FROM anggaran j
                INNER JOIN ma_sak ma
                  ON j.FK_MAID = ma.MA_ID
                WHERE ma.MA_KODE LIKE '".$kodePos_Dluar."%'
                  AND j.BULAN < $bulan_lr
                  AND j.TAHUN = $ta_lr AND j.flag = '$flag' 
                UNION 
                SELECT
                 '0'  AS nilai,
                 IFNULL(SUM(j.NILAI), 0) AS nilai2
               FROM anggaran j
                 INNER JOIN ma_sak ma
                 ON j.FK_MAID = ma.MA_ID
               WHERE ma.MA_KODE LIKE '".$kodePos_Dluar."%'
                 AND j.BULAN = $bulan_lr
                 AND j.TAHUN = $ta_lr AND j.flag = '$flag') t";
        $rsAng1=mysql_query($sql);
        $rwAng1=mysql_fetch_array($rsAng1);
        $stotAngOp +=$rwAng1["nilai"];
        $stotAngOp2 +=$rwAng1["nilai2"];
        $AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
        $stotAngOp3 +=$AngOp3;
        
        $AngPos_DLuarUsaha=$rwAng1["nilai"];
        $AngPos_DLuarUsaha2=$rwAng1["nilai2"];
        $AngPos_DLuarUsaha3=$AngPos_DLuarUsaha+$AngPos_DLuarUsaha2;
        
        $stotAngPend_DLuarUsaha +=$rwAng1["nilai"];
        $stotAngPend_DLuarUsaha2 +=$rwAng1["nilai2"];
        $stotAngPend_DLuarUsaha3 +=$AngOp3;
          
        $Deviasi=$Pos_DLuarUsaha3-$AngOp3;
        $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
        
        $stotDeviasi +=$Deviasi;
        $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
        
        $Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
        $Rasio2=($rwAng1["nilai2"]==0)?0:$Pos_DLuarUsaha2/$rwAng1["nilai2"] * 100;
        $Rasio3=($AngOp3==0)?0:$Pos_DLuarUsaha3/$AngOp3 * 100;
        $Rasio4=($rwAngTh1["nilai"]==0)?0:$Pos_DLuarUsaha3/$rwAngTh1["nilai"] * 100;
        
        $stotRasio1 +=$Rasio1;
        $stotRasio2 +=$Rasio2;
        $stotRasio3 +=$Rasio3;
        $stotRasio4 +=$Rasio4;
        
        $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
        $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
        $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
        $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");

     $SelAngThPendBiaya_DLuar=$SelAngThPendBiaya_DLuar-$SelAngThBeban_DLuar-$rwAngTh1["nilai"];
         $SelAngPendBiaya_DLuar=$SelAngPendBiaya_DLuar-$SelAngBeban_DLuar-$rwAng1["nilai"];
        $SelAngPendBiaya_DLuar2=$SelAngPendBiaya_DLuar2-$SelAngBeban_DLuar2-$rwAng1["nilai2"];
        $SelAngPendBiaya_DLuar3=$SelAngPendBiaya_DLuar3-$SelAngBeban_DLuar3-$AngOp3;

        $SelPendBiaya_DLuar=$Pend_DLuarUsaha-$Biaya_DLuarUsaha-$Pos_DLuarUsaha;
        $SelPendBiaya_DLuar2=$Pend_DLuarUsaha2-$Biaya_DLuarUsaha2-$Pos_DLuarUsaha2;
        $SelPendBiaya_DLuar3=$Pend_DLuarUsaha3-$Biaya_DLuarUsaha3-$Pos_DLuarUsaha3;

          $SellblDeviasi = $SelPendBiaya_DLuar3-$SelAngPendBiaya_DLuar3;
          $SellbltotDeviasi=($SellblDeviasi<0)?"(".number_format(abs($SellblDeviasi),0,",",".").")":number_format($SellblDeviasi,0,",",".");
        
        ?>
                <!-- <tr>
                  <td align="center">6.3.00.00.00.00</td>
                  <td align="left">&nbsp;BEBAN KEUANGAN</td>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($Pos_DLuarUsaha,0,",","."); ?></td>
          <td align="right"><?php echo number_format($Pos_DLuarUsaha2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($Pos_DLuarUsaha3,0,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                 <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp; JUMLAH Pendapatan (Beban) Non Usaha: </td>
                  <td align="right"><?php echo number_format($SelAngThPendBiaya_DLuar,0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($SelAngPendBiaya_DLuar,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelAngPendBiaya_DLuar2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelAngPendBiaya_DLuar3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelAngPendBiaya_DLuar3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelPendBiaya_DLuar,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelPendBiaya_DLuar2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelPendBiaya_DLuar3,0,",","."); ?></td>
                  <td align="right"><?php echo $SellbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr> -->
                <!-- <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr> -->
                <?php 
        $stotDeviasi=0;
        $stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
        
        $AngThLB_SblmPajak=$AngThLB_Op+$SelAngThPendBiaya_DLuar-$AngThPos_DLuarUsaha;
        $AngLB_SblmPajak=$AngLB_Op+$SelAngThPendBiaya_DLuar-$AngPos_DLuarUsaha;
        $AngLB_SblmPajak2=$AngLB_Op2+$SelAngThPendBiaya_DLuar2-$AngPos_DLuarUsaha2;
        $AngLB_SblmPajak3=$AngLB_Op3+$SelAngThPendBiaya_DLuar3-$AngPos_DLuarUsaha3;
        
        
        $Deviasi=$LR_SblmPajak3-$AngLB_SblmPajak3;
        $lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
        
        $stotDeviasi +=$Deviasi;
        $lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
        
        $Rasio1=($AngLB_SblmPajak3==0)?0:$Deviasi/$AngLB_SblmPajak3 * 100;
        $Rasio2=($AngLB_Op2==0)?0:$Pos_DLuarUsaha2/$AngLB_Op2 * 100;
        $Rasio3=($AngLB_SblmPajak3==0)?0:$LR_SblmPajak3/$AngLB_SblmPajak3 * 100;
        $Rasio4=($AngThLB_Op==0)?0:$LR_SblmPajak3/$AngThLB_Op * 100;
        
        $stotRasio1 +=$Rasio1;
        $stotRasio2 +=$Rasio2;
        $stotRasio3 +=$Rasio3;
        $stotRasio4 +=$Rasio4;
        
        $lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
        $lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
        $lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
        $lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
        ?>
                <!-- <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;LABA / RUGI SEBELUM PAJAK : </td> //decyber, laba rugi -->
                  <!-- <td align="right"><?php echo number_format($AngThLB_SblmPajak,0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($AngLB_SblmPajak,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngLB_SblmPajak2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngLB_SblmPajak3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngLB_SblmPajak3,0,",","."); ?></td>
                  <td align="right"><?php echo $lblLR_SblmPajak; ?></td>
          <td align="right"><?php echo $lblLR_SblmPajak2; ?></td>
                  <td align="right"><?php echo $lblLR_SblmPajak3; ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr> -->
              </table>
    <?php 
    if($_REQUEST['excel']!='excel'){
    ?>        
          <p id="p_print" align="center"> 
          
          <button type="button" onclick="document.getElementById('p_print').style.display='none';window.print();window.close();"><img src="../icon/printer.png" height="16" width="16" border="0" align="absmiddle" />&nbsp; Cetak</button> &nbsp;
          
          
          <button type="button" onclick="simpanReal();" >Simpan Realisasi</button></p>
          
          </div>
          
          
    <? } ?>
</body>
</html>






<script language="javascript">

function simpanReal(){

   url = "simpanReal.php?bulan="+<?php echo $bulan_lr; ?>+"&ta="+<?php echo $ta_lr; ?>+"&nilai="+<?php echo $lblLR_SblmPajak22; ?>;
  
  jQuery.get(url,function(data){
    alert('Proses data '+data);
  }); 
  //alert('Proses data');


}

</script>

<?php 
mysql_close($konek);
?>

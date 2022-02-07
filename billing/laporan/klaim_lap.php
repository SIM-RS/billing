<?php
session_start();
include "../sesi.php";
include("../koneksi/konek.php");
$unit=$_REQUEST['unit'];
$tglAwal=$_REQUEST['tglAwal'];
$tglAkhir=$_REQUEST['tglAkhir'];
$penjamin=$_REQUEST['penjamin'];

$getUnit="select nama from b_ms_unit where id=$unit";
$rsUnit=mysql_query($getUnit);
$rwUnit=mysql_fetch_array($rsUnit);

$getKso="select nama from b_ms_kso where id=$penjamin";
$rsKso=mysql_query($getKso);
$rwKso=mysql_fetch_array($rsKso);

$temp=explode('-',$tglAwal);
$tump=explode('-',$tglAkhir);
$namaBulan= array ('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
$dateAwal=$temp[0]." ".$namaBulan[$temp[1]]." ".$temp[2];
$dateAkhir=$tump[0]." ".$namaBulan[$tump[1]]." ".$tump[2];

$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$time_now=gmdate('H:i:s',mktime(date('H')+7));
?>
<html>
   <head>
      <title>Laporan Klaim Pasien</title>
      <style>
         .withline{
            border:1px solid #000000;
         }
         .noline{
            border:none;
         }
         .tableHeader{
            font:10 bold;
            border:1px solid #000000;
            text-align:center;
         }
         .tableContent{
            font:10 sans-serif normal;
            border:1px solid #000000;            
         }
      </style>
   </head>
   <body>
      <table width="1000" align="center" cellpadding=0 cellspacing=0>
         <tr>
            <td class="noline" colspan="2" style="font:12 sans-serif normal"><?=$namaRS?></td>            
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>            
         </tr>
         <tr>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
         </tr>
         <tr>
            <td class="noline" style="font:small sans-serif bold"><?=$alamatRS?></td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>            
         </tr>
         <tr>
            <td class="noline" style="font:small sans-serif bold">Telepon <?=$tlpRS?></td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
         </tr>
         <tr>
            <td class="noline" style="font:small sans-serif bold"><?=$kotaRS?></td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
         </tr>
         <tr>
            <td class="noline" style="font:small sans-serif bold"></td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
         </tr>
         <tr>
            <td class="noline" colspan="4" align="center" style="font:14 sans-serif bolder;">Laporan Pengajuan Klaim Pasien Non Inap (<?php echo $rwUnit['nama'];?>) Periode <?php echo $dateAwal.' - '.$dateAkhir;?></td>            
         </tr>
         <tr>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
         </tr>
         <tr>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
         </tr>
          <tr>
            <td class="noline"  style="font:12 sans-serif bolder;">
               Penjamin Pasien : <?php echo $rwKso['nama'];?>
            </td>
            <td class="noline"></td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
         </tr>
          <tr>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
         </tr>
          <tr>
            <td class="noline" align="center" colspan="4">
               <table class="withline" width="100%" cellpadding=0 cellspacing=0>
                  <tr>
                     <td width="5%" class="tableHeader"><strong>No</strong></td>
                     <td width="10%" class="tableHeader"><strong>Tgl Kunjungan</strong></td>
                     <td width="5%" class="tableHeader"><strong>No. RM</strong></td>
                     <td width="15%" class="tableHeader"><strong>Nama Pasien</strong></td>
                     <td width="7%" class="tableHeader"><strong>Retribusi</strong></td>
                     <td width="7%" class="tableHeader"><strong>Tindakan</strong></td>
                     <td width="7%" class="tableHeader"><strong>PA</strong></td>
                     <td width="7%" class="tableHeader"><strong>PK</strong></td>
                     <td width="7%" class="tableHeader"><strong>Rad</strong></td>
                     <td width="7%" class="tableHeader"><strong>Konsul Poli</strong></td>
                     <td width="7%" class="tableHeader"><strong>Obat</strong></td>
                     <td width="7%" class="tableHeader"><strong>Total</strong></td>
                  </tr>
                  <?php
                  echo $Qdata="select k.tgl,p.no_rm,p.nama,
IF(t1.ms_tindakan_unit_id=0,t1.biaya,0) as retribusi,
IF(kk.ms_klasifikasi_id<>11 or kk.ms_klasifikasi_id<>14,t1.biaya,0) as tindakan,
IF(t1.ms_tindakan_unit_id=59,t1.biaya,0) as PA,
IF(t1.ms_tindakan_unit_id=58,t1.biaya,0) as PK,
IF(t1.ms_tindakan_unit_id=60,t1.biaya,0) as rad,
IF(t.kel_tindakan_id=68,t1.biaya,0) as konsul
from (SELECT * FROM b_tindakan b where b.ms_tindakan_unit_id='".$unit."' and b.tgl between '".tglSQL($tglAwal)."' and '".tglSQL($tglAkhir)."') as t1
inner join b_kunjungan k on k.id=t1.kunjungan_id
inner join b_ms_pasien p on k.pasien_id=p.id
inner join b_ms_tindakan_kelas tk on tk.id=t1.ms_tindakan_kelas_id
inner join b_ms_tindakan t on t.id=tk.ms_tindakan_id
inner join b_ms_kelompok_tindakan kk on kk.id=t.kel_tindakan_id
where k.kso_id='".$penjamin."' order by p.nama";
                  $RSdata=mysql_query($Qdata);
                  $no=1;
                  while($RWdata=mysql_fetch_array($RSdata)){
                     $jml[$no][1]+=$RWdata['retribusi'];
                     $jml[$no][2]+=$RWdata['tindakan'];
                     $jml[$no][3]+=$RWdata['PA'];
                     $jml[$no][4]+=$RWdata['PK'];
                     $jml[$no][5]+=$RWdata['rad'];
                     $jml[$no][6]+=$RWdata['konsul'];
                     
                     $tot[1][$no]+=$RWdata['retribusi'];
                     $tot[2][$no]+=$RWdata['tindakan'];
                     $tot[3][$no]+=$RWdata['PA'];
                     $tot[4][$no]+=$RWdata['PK'];
                     $tot[5][$no]+=$RWdata['rad'];
                     $tot[6][$no]+=$RWdata['konsul'];
                     ?>
                     <tr>
                        <td class="tableContent" align="center"><?php echo $no;?></td>
                        <td class="tableContent" align="center"><?php echo $RWdata['tgl']?></td>
                        <td class="tableContent" align="center"><?php echo $RWdata['no_rm']?></td>
                        <td class="tableContent" align="left"><?php echo $RWdata['nama']?></td>
                        <td class="tableContent" align="right"><?php echo $RWdata['retribusi']?></td>
                        <td class="tableContent" align="right"><?php echo $RWdata['tindakan']?></td>
                        <td class="tableContent" align="right"><?php echo $RWdata['PA']?></td>
                        <td class="tableContent" align="right"><?php echo $RWdata['PK']?></td>
                        <td class="tableContent" align="right"><?php echo $RWdata['rad']?></td>
                        <td class="tableContent" align="right"><?php echo $RWdata['konsul']?></td>
                        <td class="tableContent">&nbsp;</td>
                        <td class="tableContent" align="right"><?php echo (isset($jml[$no]))?array_sum($jml[$no]):0;?></td>
                     </tr>
                     <?php
                     $no++;
                  }
                  $total=((isset($tot[1]))?array_sum($tot[1]):0)+
                           ((isset($tot[2]))?array_sum($tot[2]):0)+
                           ((isset($tot[3]))?array_sum($tot[3]):0)+
                           ((isset($tot[4]))?array_sum($tot[4]):0)+
                           ((isset($tot[5]))?array_sum($tot[5]):0)+
                           ((isset($tot[6]))?array_sum($tot[6]):0);
                  ?>
                  <tr>
                        <td class="tableContent" align="center"></td>
                        <td class="tableContent" align="center"></td>
                        <td class="tableContent" align="center"></td>
                        <td class="tableContent" align="left">Jumlah Sub total</td>
                        <td class="tableContent" align="right"><strong><?php echo ((isset($tot[1]))?array_sum($tot[1]):0);?></strong></td>
                        <td class="tableContent" align="right"><strong><?php echo ((isset($tot[2]))?array_sum($tot[2]):0);?></strong></td>
                        <td class="tableContent" align="right"><strong><?php echo ((isset($tot[3]))?array_sum($tot[3]):0);?></strong></td>
                        <td class="tableContent" align="right"><strong><?php echo ((isset($tot[4]))?array_sum($tot[4]):0);?></strong></td>
                        <td class="tableContent" align="right"><strong><?php echo ((isset($tot[5]))?array_sum($tot[5]):0);?></strong></td>
                        <td class="tableContent" align="right"><strong><?php echo ((isset($tot[6]))?array_sum($tot[6]):0);?></strong></td>
                        <td class="tableContent">&nbsp;</td>
                        <td class="tableContent" align="right"><strong><?php echo $total;?></strong></td>
                     </tr>
               </table>
               
            </td>            
         </tr>
          <tr>
             <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline"></td>
            <td class="noline" align="right" style="font:12 sans-serif bolder;">Tgl. cetak : <?php echo $date_now;?> Jam <?php echo $time_now;?></td>
          </tr>
          <tr>
             <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline" align="right" style="font:12 sans-serif bolder;">Yang mencetak, </td>            
          </tr>
      </table>
   </body>
</html>
<?php 
mysql_close($konek);
?>
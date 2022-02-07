<?php
session_start();
include("../sesi.php");
?>
<?php
include("../koneksi/konek.php");
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idPasien=$_REQUEST['idPasien'];

$qPasien="select p.no_rm,p.nama,p.alamat,p.rt,p.rw,w.nama as desa,i.nama as kec,l.nama as kab,a.nama as prop 
from b_ms_pasien p
inner join b_ms_wilayah w on w.id=p.desa_id
inner join b_ms_wilayah i on i.id=p.kec_id
inner join b_ms_wilayah l on l.id=p.kab_id
inner join b_ms_wilayah a on a.id=p.prop_id where p.id='".$idPasien."'";
$rsPasien=mysql_query($qPasien);
$rwPasien=mysql_fetch_array($rsPasien);
?>
<html>
   <head>
      <title>KRS</title>
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
            padding-left:5px;
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
            <td class="noline" style="font:small sans-serif bold"><?=$alamatRS?> </td>
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
            <td class="noline" colspan="4" align="center" style="font:14 sans-serif bolder;">Rekam Medis Pasien</td>            
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
               No Rekam Medis : <?php echo $rwPasien['no_rm'];?>
            </td>
            <td class="noline"></td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
         </tr>
           <tr>
            <td class="noline"  style="font:12 sans-serif bolder;">
               Nama Pasien : <?php echo $rwPasien['nama'];?>
            </td>
            <td class="noline"></td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
         </tr>
            <tr>
            <td class="noline"  style="font:12 sans-serif bolder;">
               Alamat : <?php echo $rwPasien['alamat']." RT.".$rwPasien['rt']." RW.".$rwPasien['rw']." Desa/Kel.".$rwPasien['desa']." Kec.".$rwPasien['kec']." Kab.".$rwPasien['kab'];?>
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
                     <td width="3%" class="tableHeader"><strong>No</strong></td>
                     <td width="12%" class="tableHeader"><strong>Kunjungan</strong></td>
                     <td width="25%" class="tableHeader"><strong>Tindakan</strong></td>
                     <td width="20%" class="tableHeader"><strong>Diagnosa</strong></td>
                     <td width="20%" class="tableHeader"><strong>Obat</strong></td>
                     <td width="15%" class="tableHeader"><strong>Status Keluar</strong></td>                     
                  </tr>
                  <?php
                  $qKunj="select k.id,k.tgl_act from b_kunjungan k where k.pasien_id='".$idPasien."'";
                  $rsKunj=mysql_query($qKunj);
                  $no=1;
                  $tempUnit='';
                  $tempUnit2='';
                  while($rwKunj=mysql_fetch_array($rsKunj)){
                     $tanggal=explode(" ",$rwKunj['tgl_act']);
                     ?>
                     <tr>
                        <td class="tableContent" align="center"><?php echo $no;?></td>
                        <td class="tableContent" align="center" valign="top"><?php echo tglSQL($tanggal[0])." ".$tanggal[1];?>&nbsp;</td>
                        <td class="tableContent" align="left" valign="top">
                           <?php
                              $qTind="select u.nama as unit,mt.nama as tindakan,if(p.unit_id_asal <> 0,n.nama,'') as rujuk_dari
                              ,if(p.unit_id_asal <> 0,p.tgl,'') as tgl_rujuk
                                    from (select * from b_tindakan t where t.kunjungan_id='".$rwKunj['id']."') as t1
                                    inner join b_ms_unit u on u.id=t1.ms_tindakan_unit_id
                                    inner join b_ms_tindakan_kelas tk on tk.id=t1.ms_tindakan_kelas_id
                                    inner join b_ms_tindakan mt on mt.id=tk.ms_tindakan_id
                                    inner join b_pelayanan p on p.id=t1.pelayanan_id
                                    left join b_ms_unit n on n.id=p.unit_id_asal";
                              $rsTind=mysql_query($qTind);
                              while($rwTind=mysql_fetch_array($rsTind)){
                                 if($tempUnit!=$rwTind['unit']){
                                    $tempUnit=$rwTind['unit'];
                                 ?>
                                    </ul><ul style="list-style-position:inside;list-style-type:square;padding-left:2px;"><?php echo $rwTind['unit'].(($rwTind['rujuk_dari']!='')?" (Dirujuk dari: ".$rwTind['rujuk_dari']:'').(($rwTind['tgl_rujuk']!='')?" tanggal: ".tglSQL($rwTind['tgl_rujuk']).")":'')?>
                                    <li><?php echo $rwTind['tindakan'];?></li>
                                 <?php
                                 }
                                 else{
                                    ?>
                                       <li><?php echo $rwTind['tindakan'];?></li>
                                    <?php
                                 }                                 
                              }
                           ?>
                           &nbsp;
                        </td>
                        <td class="tableContent" align="left" valign="top">
                           <?php
                            $qDiag="select d.diagnosa_id,u.nama as unit,md.nama as diagnosa from b_diagnosa d
                                    inner join b_ms_diagnosa md on md.id=d.ms_diagnosa_id
                                    inner join b_pelayanan l on l.id=d.pelayanan_id
                                    inner join b_ms_unit u on u.id=l.unit_id
                                    where l.kunjungan_id='".$rwKunj['id']."'";
                              $rsDiag=mysql_query($qDiag);
                              while($rwDiag=mysql_fetch_array($rsDiag)){
                                 if($tempUnit2!=$rwDiag['unit']){
                                    $tempUnit2=$rwDiag['unit'];
                                 ?>
                                    </ul><ul style="list-style-position:inside;list-style-type:square;padding-left:2px;"><?php echo $rwDiag['unit']?>
                                    <li><?php echo $rwDiag['diagnosa'];?></li>
                                 <?php
                                 }
                                 else{
                                    ?>
                                       <li><?php echo $rwDiag['diagnosa'];?></li>
                                    <?php
                                 }                                 
                              }
                           ?>
                           &nbsp;
                        </td>
                        <td class="tableContent" align="left" valign="top">&nbsp;</td>
                        <td class="tableContent" align="left" valign="top">
                           <?php
                           $qKeluar="select p.cara_keluar,p.keadaan_keluar from b_pasien_keluar p
                                    where p.kunjungan_id='".$rwKunj['id']."'";
                           $rsKeluar=mysql_query($qKeluar);
                           while($rwKeluar=mysql_fetch_array($rsKeluar)){
                              echo "cara keluar: ".$rwKeluar['cara_keluar']."<br> keadaan keluar: ".$rwKeluar['keadaan_keluar'];
                           }
                           ?>
                           &nbsp;
                        </td>                        
                     </tr>
                     <?php
                     $no++;
                  }
                  
                  ?>
               </table>
            </td>
         </tr>
         <tr>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
            <td class="noline" align="right"><input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(this);"/></td>
         </tr>
   </body>
</html>
<script>
   function cetak(tombol){
      tombol.style.display='none';
      if(tombol.style.display=='none'){
         if(confirm('Anda yakin mau mencetak Rekam Medis ini?')){
            setTimeout('window.print()','1000');
            setTimeout('window.close()','2000');
         }
         else{
            document.getElementById('btnPrint').style.display='block';
         }
         
      }
   }   

</script>
<?php 
mysql_close($konek);
?>
<?php
include("../koneksi/konek.php");
include("../sesi.php");
$norm=$_REQUEST['norm'];
$tglAwal=$_REQUEST['tglAwal'];
$tglAkhir=$_REQUEST['tglAkhir'];
?>
<style>
   
   .itemtableReq{
      background-color:#F28F52;
   }
   .itemtableReq th{
      background-color:#FF0B07;
   }
   .itemtableMOverReq td{
      background-color:#CAF736;
      cursor:pointer;
   }
</style>
<?php
switch (strtolower($_REQUEST['act']))
{
      case 'cari':
         ?>
         
         <table id="pasien_table">	   
            <tr class="itemtableReq">		 
			<th width="80">Tgl Kunjungan</th>
			<th width="60">Tempat Layanan</th>
			<th width="160">Nama Pasien</th>
			<th width="200">Alamat</th>
			<th align="right">
		  <img alt="close" src="../icon/x.png" style="cursor: pointer;" width="24" onclick="tutupDivPasien()"/>
	       </th>
           </tr>
            <?php           
			$sql="SELECT DISTINCT p.id,p.nama,p.alamat,p.rt,p.rw,w.nama AS desa,i.nama AS kec, l.nama AS kab,p.tgl_lahir,p.sex,
			k.tgl,k.umur_thn,n.nama as unit,k.id as kunjungan_id,k.verifikasi,k.note_verifikasi FROM b_ms_pasien p
        INNER JOIN b_kunjungan k ON k.pasien_id=p.id	
        LEFT JOIN b_ms_wilayah w ON w.id=p.desa_id
        LEFT JOIN b_ms_wilayah i ON i.id=p.kec_id
        LEFT JOIN b_ms_wilayah l ON l.id=p.kab_id
        LEFT JOIN b_ms_unit n ON n.id=k.unit_id	
        WHERE no_rm = '$norm' AND k.flag = '$flag' AND k.tgl between '".tglSQL($tglAwal)."' AND '".tglSQL($tglAkhir)."'";
		//echo $sql;
			$rs=mysql_query($sql);
            $i=1;
            while($rw=mysql_fetch_array($rs)){
				
		  $qPel="select id from b_pelayanan where kunjungan_id='".$rw['kunjungan_id']."' limit 1";
		  $rsPel=mysql_query($qPel);
		  $rwPel=mysql_fetch_array($rsPel);
				
               	 $val=$rw['id']."|".$rw['nama']
            ."|".$rw['alamat'].($rw['rt']!=''?" RT.".$rw['rt']:"")
            .($rw['rw']!=''?" RW.".$rw['rw']:"").($rw['desa']!=''?" Desa/Kel.".$rw['desa']:"")
            .($rw['kec']!=''?" Kec.".$rw['kec']:"").($rw['kab']!=''?" Kab.".$rw['kab']:"")
            ."|".tglSQL($rw['tgl_lahir'])."|".tglSQL($rw['tgl'])."|".$rw['umur_thn']."|".$rw['sex']."|".$rw['tgl']."|".$rw['kunjungan_id']."|".$rwPel['id']."|".$rw['verifikasi']."|".$rw['note_verifikasi'];
               ?>
               <tr id="<?php echo $i;?>" lang="<?php echo $val;?>" title="<?php echo $val;?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="setPasien(this.lang);">
		     <td>&nbsp;<?php echo tglSQL($rw['tgl']);?></td>
		     <td>&nbsp;<?php echo $rw['unit'];?></td>
		     <td>&nbsp;<?php echo $rw['nama'];?></td>
		     <td>&nbsp;<?php echo $rw['alamat'];?></td>			   			
               </tr>
               <?php
		   $i++;
            }
	    mysql_free_result($rs);
            ?>
         </table>
         <?php
         break;      
}
?>
<?php 
mysql_close($konek);
?>
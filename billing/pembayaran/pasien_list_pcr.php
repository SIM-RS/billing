<?php
include("../koneksi/konek.php");
include("../sesi.php");
$kasir=$_REQUEST['kasir'];
$qCab = mysql_query("select cabang_id from b_ms_unit where id = '{$kasir}'");
if($qCab && mysql_num_rows($qCab) > 0){
	$dCab = mysql_fetch_array($qCab);
	$cabang = $dCab['cabang_id'];
} else {
	$cabang = 2 ;
}
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
         
         <table id="pasien_table_pcr">
            <tr class="itemtableReq">
			<th width="80">Tgl Kunjungan</th>
			<th width="60">No RM</th>
			<th width="160">Nama Pasien</th>
			<th width="200">Alamat</th>
			<th width="160">Tempat Layanan</th>
			<th width="130">Status</th>
		   </tr>
            <?php
            $kataKunci=$_REQUEST['keyword'];
			$status=$_REQUEST['status'];
		
			$idUnitAmbulan=0;
			$idUnitJenazah=0;
			$sql="SELECT * FROM b_ms_reference WHERE stref=26";
			$rsRef=mysql_query($sql);
			if ($rwRef=mysql_fetch_array($rsRef)){
				$idUnitAmbulan=$rwRef["nama"];
			}
			$sql="SELECT * FROM b_ms_reference WHERE stref=27";
			$rsRef=mysql_query($sql);
			if ($rwRef=mysql_fetch_array($rsRef)){
				$idUnitJenazah=$rwRef["nama"];
			}
			$sql="SELECT
						DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
						p.id as id_pasien,
						p.no_rm,
						pel.id as id_pelayanan,
						k.id as id_kunjungan,
						p.nama,
						p.alamat,
						mu.nama as nama_unit,
						kso.nama as nama_kso
					FROM 
						b_ms_pasien p
						LEFT JOIN b_kunjungan k ON k.pasien_id = p.id
						LEFT JOIN b_pelayanan pel ON pel.kunjungan_id = k.id
						LEFT JOIN b_ms_unit mu ON mu.id = k.unit_id
						LEFT JOIN b_ms_kso kso ON kso.id = k.kso_id
					WHERE
						k.unit_id = 232
						AND (p.nama LIKE '$kataKunci%' OR p.no_rm = '$kataKunci')
						AND k.pulang = 0
						AND p.cabang_id = 1
						AND k.kso_id = 1
					ORDER BY k.tgl DESC";
			// echo $sql.";<br/>";
			$rs=mysql_query($sql);
            $i=1;
            while($rw=mysql_fetch_array($rs)){
				
			//akhir cek konsul+MRS
				
               	$val = $rw['id_pasien']."|".$rw['id_pelayanan'].'|'.$rw['id_kunjungan'].'|'.$rw['nama'].'|'.$rw['alamat'].'|'.$rw['nama_unit'].'|'.$rw['nama_kso'].'|'.$rw['no_rm'];
               ?>
               <tr id="<?php echo $i;?>" lang="<?php echo $val;?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="setPasienPcr(this.lang);">
			   <td>&nbsp;<?php echo $rw['tgl'];?></td>
			   <td>&nbsp;<?php echo $rw['no_rm'];?></td>
			   <td>&nbsp;<?php echo $rw['nama'];?></td>
			   <td>&nbsp;<?php echo $rw['alamat'];?></td>
			   <td>&nbsp;<?php echo $rw['nama_unit'];?></td>
			   <td>&nbsp;<?php echo $rw['nama_kso'];?></td>
               </tr>
               <?php
		   			$i++;
				//}
            }
            ?>
         </table>
         <?php
         	break;      
	}
?>
<?php 
mysql_close($konek);
?>
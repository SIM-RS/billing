<?php
include("../koneksi/konek.php");

switch (strtolower($_REQUEST['act']))
{
      case 'cari':
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
         
         <table id="kasir_table" width="300">
            <tr class="itemtableReq">
               <th>Nama Kasir</th>
            </tr>
            <?php
            $kataKunci=$_REQUEST['keyword'];
            $sql = "SELECT DISTINCT
					  mp.id,
					  mp.nama
					FROM b_ms_pegawai_unit mpu
					  INNER JOIN b_ms_pegawai mp
						ON mpu.ms_pegawai_id = mp.id
					  INNER JOIN b_ms_unit mu
						ON mpu.unit_id = mu.id
					WHERE mu.kategori = 4
						AND mp.nama LIKE '$kataKunci%'
					ORDER BY mp.nama";
            //echo $sql;
			$rs=mysql_query($sql);
            $i=0;
            while($rw=mysql_fetch_array($rs)){
               $val=$rw['id']."|".$rw['nama'];
               $i++;
               ?>
               <tr id="<?php echo $i;?>" lang="<?php echo $val;?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="setKasir(this.lang);">
                  <td>&nbsp;<?php echo $rw['nama'];?></td>
               </tr>
               <?php
            }
            ?>
         </table>
         <?php
         break;
}
mysql_close($konek);
?>
<?php
session_start();
include "../sesi.php";
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
         
         <table id="pasien_table" width="500">
            <tr class="itemtableReq">
               <th style="width:10%;">No RM</th>
               <th style="width:30%;">Nama Pasien</th>
               <th style="width:60%;">Alamat</th>
            </tr>
            <?php
            $kataKunci=$_REQUEST['keyword'];
            $sql = "SELECT DISTINCT p.id AS pasienId, k.id AS kunjId, p.no_rm, p.nama, p.nama_ortu, p.alamat, p.sex
					FROM b_kunjungan k
					INNER JOIN b_pelayanan pel ON pel.kunjungan_id = k.id
					INNER JOIN b_ms_pasien p ON p.id = k.pasien_id
					WHERE (nama like '%$kataKunci%' or no_rm like '%$kataKunci%') AND pel.unit_id = 61
					GROUP BY p.nama
					ORDER BY p.id";
            //echo $sql;
			$rs=mysql_query($sql);
            $i=0;
            while($rw=mysql_fetch_array($rs)){
               $val=$rw['pasienId']."|".$rw['kunjId']."|".$rw['no_rm']."|".$rw['nama']."|".
               $rw['nama_ortu']."|".$rw['alamat']."|".$rw['sex'];
               $i++;
               ?>
               <tr id="<?php echo $i;?>" lang="<?php echo $val;?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="setPasien(this.lang);">
                  <td>&nbsp;<?php echo $rw['no_rm'];?></td>
                  <td>&nbsp;<?php echo $rw['nama'];?></td>
				  <td>&nbsp;<?php echo $rw['alamat'];?></td>
               </tr>
               <?php
            }
            ?>
         </table>
         <?php
         break;
	case 'kiriman':
		$sql = "SELECT DISTINCT p.id AS pasienId, k.id AS kunjId, p.no_rm, p.nama, p.nama_ortu, p.alamat, p.sex
			FROM b_kunjungan k
			INNER JOIN b_ms_pasien p ON p.id = k.pasien_id
			WHERE k.id = '".$_GET['kunjungan_id']."'
			GROUP BY p.nama
			ORDER BY p.id";
		$rs=mysql_query($sql);
		$rw = mysql_fetch_array($rs);
		$val=$rw['pasienId']."|".$rw['kunjId']."|".$rw['no_rm']."|".$rw['nama']."|".
               $rw['nama_ortu']."|".$rw['alamat']."|".$rw['sex'];
		echo $val;
		break;
}
mysql_close($konek);
?>
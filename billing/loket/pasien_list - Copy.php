<?php
//include("../sesi.php");
?>
<?php
include("../koneksi/konek.php");
$tgl=gmdate('Y-m-d',mktime(date('H')+7));
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
	   if($_REQUEST['txt']=='NoRm')
			{
				$sql="SELECT p.id,p.no_rm,p.no_ktp,p.nama,p.tgl_lahir,p.alamat,p.rt,p.rw,p.desa_id,p.kec_id,p.kab_id,p.prop_id,
p.nama_ortu,p.nama_suami_istri,p.sex,p.pendidikan_id,p.pekerjaan_id,p.agama,p.telp
FROM b_ms_pasien p WHERE p.no_rm = '".$_REQUEST['keyword']."'";
            }
			else if($_REQUEST['txt']=='NoKTP')
			{
			$keyword = explode(chr(3),$_GET['keyword']);
				$sql="SELECT p.id,p.no_rm,p.no_ktp,p.nama,p.tgl_lahir,p.alamat,p.rt,p.rw,p.desa_id,p.kec_id,p.kab_id,p.prop_id,p.nama_ortu,p.nama_suami_istri,
               p.sex,p.pendidikan_id,p.pekerjaan_id,p.agama,p.telp
	       FROM b_ms_pasien p
WHERE p.nama LIKE '".$keyword[0]."%' AND p.no_ktp LIKE '%".$keyword[2]."%' ORDER BY p.nama, p.alamat LIMIT 250";
            }
            else
			{
                $keyword = explode(chr(3),$_GET['keyword']);
				$sql="SELECT p.id,p.no_rm,p.no_ktp,p.nama,p.tgl_lahir,p.alamat,p.rt,p.rw,p.desa_id,p.kec_id,p.kab_id,p.prop_id,p.nama_ortu,p.nama_suami_istri,
               p.sex,p.pendidikan_id,p.pekerjaan_id,p.agama,p.telp
	       FROM b_ms_pasien p
WHERE p.nama LIKE '".$keyword[0]."%' AND p.alamat LIKE '%".$keyword[1]."%' ORDER BY p.nama, p.alamat LIMIT 250";
            }
			//echo $sql."<br>";
            $rs=mysql_query($sql);
			$total = mysql_num_rows($rs);
			if($total==0 && $_REQUEST['txt']=='NoKTP') //jika tidak ada datanya
			{
				include("../koneksi/konek_siakdba.php");
				$no_ktp = $keyword[2];
				$q = "SELECT a.*,IF(a.JENIS_KLMIN=1,'L','P')AS GENDER,b.NO_KK,b.ALAMAT,b.NO_RT,b.NO_RW,b.TELP FROM t_biodata_wni AS a 
				INNER JOIN t_data_keluarga AS b ON b.NIK_KK=a.NIK where a.NO_KTP like '%$no_ktp%'"; //echo $q;
				$s = mysql_query($q,$konek2); //echo mysql_error();
			?>
				<table id="pasien_table" width="800">
				<tr class="itemtableReq">
				   <th style="width:10%;">No KTP</th>
				   <th style="width:20%;">Nama Lengkap</th>
				   <th style="width:10%;">Jenis Kelamin</th>
				   <th style="width:10%;">Tempat Lahir</th>
				   <th style="width:10%;">Tanggal Lahir</th>
				   <th style="width:20%;">Alamat</th>
				   <th style="width:10%;">NIK</th>
				   <th style="width:10%;">NO KK</th>
				</tr>
			<?
				
				$no=1;
				//var_dump($konek);
				while($d = mysql_fetch_array($s))
				{
					$PROP = mysql_fetch_array(mysql_query("SELECT id from b_ms_wilayah where kode_siak='$d[NO_PROP]'",$konek)); //echo mysql_error();
					$KAB = mysql_fetch_array(mysql_query("SELECT id from b_ms_wilayah where kode_siak='$d[NO_PROP].$d[NO_KAB]'",$konek)); 
					$KEC = mysql_fetch_array(mysql_query("SELECT id from b_ms_wilayah where kode_siak='$d[NO_PROP].$d[NO_KAB].$d[NO_KEC]'",$konek));
					$KEL = mysql_fetch_array(mysql_query("SELECT id from b_ms_wilayah where kode_siak='$d[NO_PROP].$d[NO_KAB].$d[NO_KEC].$d[NO_KEL]'",$konek));
					
				 $val="||".$d['NAMA_LGKP']."|".tglSQL($d['TGL_LHR'])."|".$d['ALAMAT']."|".
				   $d['NO_RT']."|".$d['NO_RW']."|".$KEL[0]."|".$KEC[0]."|".$KAB[0]."|".$PROP[0]."|".$d['NAMA_LGKP_AYAH']."||".$d['GENDER']."|".$d['PDDK_AKH']."|".$d['JENIS_PKRJN']."|".$d['AGAMA']."|".$d['TELP']."|||||".$d['NO_KTP']; //echo $val;
			?>
					<tr id="<?php echo $no;?>" lang="<?php echo $val;?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="setPasien(this.lang);getNoRM()">
					  <td>&nbsp;<?php echo $d['NO_KTP'];?></td>
					  <td>&nbsp;<?php echo $d['NAMA_LGKP'];?></td>
					  <td>&nbsp;<?php echo $d['GENDER'];?></td>
					  <td>&nbsp;<?php echo $d['TMPT_LHR'];?></td>
					  <td>&nbsp;<?php echo tglSQL($d['TGL_LHR']);?></td>
					  <td>&nbsp;<?php echo $d['ALAMAT'];?></td>
					  <td>&nbsp;<?php echo $d['NIK'];?></td>
					  <td>&nbsp;<?php echo $d['NO_KK'];?></td>
					</tr>
			<?
				
					$no++;
				}
				mysql_close($konek2);
			}
			else
			{
         ?>
         
         <table id="pasien_table" width="500">
            <tr class="itemtableReq">
               <th style="width:10%;">No RM</th>
               <th style="width:30%;">Nama Pasien</th>
               <th style="width:60%;">Alamat</th>
            </tr>
            <?php
            $i=0;
            while($rw=mysql_fetch_array($rs))
			{
				$sqlKunj="SELECT DISTINCT id,no_billing,pasien_id,asal_kunjungan,ket,jenis_layanan,unit_id,loket_id,retribusi,tgl,umur_thn,umur_bln,kel_umur,
kelas_id,kamar_id,kso_id,kso_kelas_id,tgl_sjp,no_sjp,no_anggota,pendidikan_id,pekerjaan_id,alamat,rt,rw,desa_id,kec_id,kab_id,
prop_id,pulang,tgl_pulang,isbaru,tgl_act,user_act,idkamar,ret FROM
(SELECT k.*,IFNULL(tk.kamar_id,0) idkamar,0 ret,p.id idpel FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE k.pasien_id='".$rw['id']."' AND k.pulang=0 AND mu.inap=1 AND k.id=(SELECT MAX(id) FROM b_kunjungan WHERE pasien_id='".$rw['id']."') 
UNION
SELECT k.*,0 idkamar,k.retribusi ret,p.id idpel FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE k.pasien_id='".$rw['id']."' AND p.tgl='$tgl' AND mu.inap=0) t1 WHERE t1.pulang=0 ORDER BY t1.idpel";
				//echo $sqlKunj."<br>";
               $rsKunj=mysql_query($sqlKunj);
               //echo mysql_error();
               if(mysql_num_rows($rsKunj)>0)
			   {
				   $rwKunj=mysql_fetch_array($rsKunj);
				   
				   $val=$rw['id']."|".$rw['no_rm']."|".$rw['nama']."|".tglSQL($rw['tgl_lahir'])."|".$rw['alamat']."|".
				   $rw['rt']."|".$rw['rw']."|".$rw['desa_id']."|".$rw['kec_id']."|".$rw['kab_id']."|".$rw['prop_id']."|".$rw['nama_ortu']."|".$rw['nama_suami_istri']."|".$rw['sex']."|".$rw['pendidikan_id']."|".$rw['pekerjaan_id']."|".$rw['agama']."|".$rw['telp']."|".$rwKunj['kso_id']."|".$rwKunj['no_anggota']."|".$rw['kelas_id']."|".$rw['st_anggota']."|".$rwKunj['id']."|".tglSQL($rwKunj['tgl'])."|".$rwKunj['asal_kunjungan']."|".tglSQL($rwKunj['tgl_sjp'])."|".$rwKunj['no_sjp']."|".$rwKunj['jenis_layanan']."|".$rwKunj['unit_id']."|".$rwKunj['idkamar']."|".$rwKunj['kelas_id']."|".$rwKunj['retribusi']."|".$rw['no_ktp'];
			   }
			   else
			   {
				   $sqlPenjamin="select id, kso_id,pasien_id,kelas_id,no_anggota,st_anggota from b_ms_kso_pasien where pasien_id=".$rw['id'];
				   //echo $sqlPenjamin."<br>";
				   $rsPenjamin=mysql_query($sqlPenjamin);
				   if(mysql_num_rows($rsPenjamin)>0)
				   {
						$rwPenjamin=mysql_fetch_array($rsPenjamin);
						$ksoid=$rwPenjamin['kso_id'];
						$no_anggota=$rwPenjamin['no_anggota'];
						$kelas_id=$rwPenjamin['kelas_id'];
						$st_anggota=$rwPenjamin['st_anggota'];
				   }
				   else
				   {
						$ksoid=1;
						$no_anggota='';
						$kelas_id=1;
						$st_anggota=0;
				   }
				   $val=$rw['id']."|".$rw['no_rm']."|".$rw['nama']."|".tglSQL($rw['tgl_lahir'])."|".$rw['alamat']."|".
				   $rw['rt']."|".$rw['rw']."|".$rw['desa_id']."|".$rw['kec_id']."|".$rw['kab_id']."|".$rw['prop_id']."|".$rw['nama_ortu']."|".$rw['nama_suami_istri']."|".$rw['sex']."|".$rw['pendidikan_id']."|".$rw['pekerjaan_id']."|".$rw['agama']."|".$rw['telp']."|".$ksoid."|".$no_anggota."|".$kelas_id."|".$st_anggota."|".$rw['no_ktp'];
			   }
               $i++;
               ?>
               <tr id="<?php echo $i;?>" lang="<?php echo $val;?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="setPasien(this.lang);">
                  <td>&nbsp;<?php echo $rw['no_rm'];?></td>
                  <td>&nbsp;<?php echo $rw['nama'];?></td>
                  <td>&nbsp;<?php echo $rw['alamat']." RT.".$rw['rt']." RW.".$rw['rw']." ".$rw['desa'];?></td>
               </tr>
               <?php
            }
			mysql_free_result($rs);
            ?>
         </table>
         <?php
		 }
         break;      
}
mysql_close($konek);
?>
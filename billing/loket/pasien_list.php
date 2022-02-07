<?php
//include("../sesi.php");
?>
<?php
include("../koneksi/konek.php");
$url_siak="http://103.4.167.188:8181/apimuflih/index.php/api/siak/wni/nik/";
$url_siak_kk="http://103.4.167.188:8181/apimuflih/index.php/api/siak/wni/no_kk/";
//$url_siak="http://103.4.167.188:8181/siakapi/index.php/api/siak/wni/nik/";
$usernameSIAKN='admin';
$passwordSIAKN='1234567';
//$usernameSIAKN='adminrsud';
//$passwordSIAKN='3671011006';
$tgl=gmdate('Y-m-d',mktime(date('H')+7));
$cabang = ($_REQUEST['cabang'] > 0) ? $_REQUEST['cabang'] : 1 ;
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
p.nama_ortu,p.nama_suami_istri,p.sex,p.pendidikan_id,p.pekerjaan_id,p.agama,p.telp, p.gol_darah,
(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop
FROM b_ms_pasien p WHERE p.no_rm = '".$_REQUEST['keyword']."' AND cabang_id = '{$cabang}'";
				$rs=mysql_query($sql);
				$total = mysql_num_rows($rs);
            }
			else if($_REQUEST['txt']=='NoKTP')
			{
				$keyword = explode(chr(3),$_GET['keyword']);
				$sql="SELECT p.id,p.no_rm,p.no_ktp,p.nama,p.tgl_lahir,p.alamat,p.rt,p.rw,p.desa_id,p.kec_id,p.kab_id,p.prop_id,p.nama_ortu,p.nama_suami_istri,
				p.sex,p.pendidikan_id,p.pekerjaan_id,p.agama,p.telp, p.gol_darah,
				(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
				(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
				(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
				(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop
				FROM b_ms_pasien p WHERE p.no_ktp = '".$keyword[2]."' AND cabang_id = '{$cabang}'
				ORDER BY p.nama, p.alamat LIMIT 1";
            }
            else
			{
                $keyword = explode(chr(3),$_GET['keyword']);
				$sql="SELECT p.id,p.no_rm,p.no_ktp,p.nama,p.tgl_lahir,p.alamat,p.rt,p.rw,p.desa_id,p.kec_id,p.kab_id,p.prop_id,p.nama_ortu,p.nama_suami_istri,
					p.sex,p.pendidikan_id,p.pekerjaan_id,p.agama,p.telp, p.gol_darah,
					(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
					(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
					(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
					(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop
				FROM b_ms_pasien p
				WHERE p.nama LIKE '%".$keyword[0]."%' AND p.alamat LIKE '%".$keyword[1]."%' AND cabang_id = '{$cabang}'
				ORDER BY p.nama, p.alamat LIMIT 250";
            }
			//echo $sql."<br>";
            $rs=mysql_query($sql);
			$total = mysql_num_rows($rs);
			
			if($total==0 && $_REQUEST['txt']=='NoKTP') //jika tidak ada datanya
			{
				//include("../koneksi/konek_siakdba.php");
				$no_ktp = $keyword[2];
				if($_REQUEST['status']=='all'){
					$json_url = $url_siak.$no_ktp;
					$ch = curl_init( $json_url );
					$options = array(
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
							//CURLOPT_POSTFIELDS => $json_string
					);
					curl_setopt($ch, CURLOPT_USERPWD, $usernameSIAKN . ':' . $passwordSIAKN);
					curl_setopt_array( $ch, $options ); 
					$result =  curl_exec($ch);
					//echo $result."<br>";
					$decode = json_decode($result, true);
					$no_kk = '0';
					if($decode[0]['NO_KK']!=''){
						$no_kk = $decode[0]['NO_KK'];	 
					}
					//$no_kk = $decode[0]['NO_KK'];
					$json_url2 = $url_siak_kk.$no_kk;
					$ch2 = curl_init( $json_url2 );
					$options2 = array(
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
							//CURLOPT_POSTFIELDS => $json_string
					);
					
					curl_setopt($ch2, CURLOPT_USERPWD, $usernameSIAKN . ':' . $passwordSIAKN);
					curl_setopt_array( $ch2, $options2 ); //Setting curl options
					$result2 =  curl_exec($ch2); //Getting jSON result string
					$decode2 = json_decode($result2, true);
					//print_r($decode2);
					$jum2 = count($decode2);
					
					//Kerjaanne raga
					
					/*$qKK = "SELECT * FROM BIODATA_WNI WHERE NIK = '".$no_ktp."'";
					$kKK = oci_parse($koneksi, $qKK);
					oci_execute($kKK);
					$row = oci_fetch_array($kKK);
					
					$nokk = '0';
					if($row['NO_KK']!=''){
						$nokk = $row['NO_KK'];	 
					}
					 
					$q = "SELECT a.*,
						TO_CHAR(a.TGL_LHR, 'DD-MM-YYYY') TGL_LHR,
						CASE
						WHEN a.JENIS_KLMIN='1' THEN 'L'
						 ELSE 'P'
						END GENDER,
						b.ALAMAT,b.NO_RT,b.NO_RW,b.TELP FROM BIODATA_WNI a 
					LEFT JOIN DATA_KELUARGA b ON b.NO_KK=a.NO_KK where a.NO_KK = '".$nokk."'"; */
					
					//Kerjaanne raga
				}
				else{
					$json_url = $url_siak.$no_ktp;
					$ch = curl_init( $json_url );
					$options = array(
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
							//CURLOPT_POSTFIELDS => $json_string
					);
					curl_setopt($ch, CURLOPT_USERPWD, $usernameSIAKN . ':' . $passwordSIAKN);
					curl_setopt_array( $ch, $options ); 
					$result =  curl_exec($ch);
					//echo $result."<br>";
					$decode = json_decode($result, true);
					$jum1 = count($decode);
				//Kerjaanne raga
				
					/*$q = "SELECT a.*,
						TO_CHAR(a.TGL_LHR, 'DD-MM-YYYY') TGL_LHR,
						CASE
						WHEN a.JENIS_KLMIN='1' THEN 'L'
						 ELSE 'P'
						END GENDER,
						b.ALAMAT,b.NO_RT,b.NO_RW,b.TELP FROM BIODATA_WNI a 
					LEFT JOIN DATA_KELUARGA b ON b.NO_KK=a.NO_KK where a.NIK = '".$no_ktp."'"; */
				
				//Kerjaanne raga
				}//echo $q;
				//Kerjaanne raga
				
				//$kueri = oci_parse($koneksi, $q);
				//oci_execute($kueri);
				
				//Kerjaanne raga
			?>
				<table id="pasien_table" width="800">
				<tr class="itemtableReq">
				   <th style="width:10%;">No RM</th>
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
				
				if($_REQUEST['status']=='all')
				{
					//echo "1. aaaa <br>";
					for($i=0;$i<$jum2;$i++){
						$sql="SELECT p.id,p.no_rm,p.no_ktp,p.nama,p.tgl_lahir,p.alamat,p.rt,p.rw,p.desa_id,p.kec_id,p.kab_id,p.prop_id,p.nama_ortu,
									p.nama_suami_istri, p.sex,p.pendidikan_id,p.pekerjaan_id,p.agama,p.telp
								FROM b_ms_pasien p
								WHERE p.no_ktp = '".$decode2[$i]['NIK']."' AND p.cabang_id = '{$cabang}'
								LIMIT 1";
						$queri=mysql_query($sql);
						if(mysql_num_rows($queri)){
							//echo "1. aaaa1";
							$rw=mysql_fetch_array($queri);
							$sqlKunj="SELECT DISTINCT id,no_billing,pasien_id,asal_kunjungan,ket,jenis_layanan,unit_id,loket_id,retribusi,tgl,umur_thn,umur_bln,kel_umur,
	kelas_id,kamar_id,kso_id,kso_kelas_id,tgl_sjp,no_sjp,no_anggota,pendidikan_id,pekerjaan_id,alamat,rt,rw,desa_id,kec_id,kab_id,
	prop_id,pulang,tgl_pulang,isbaru,tgl_act,user_act,idkamar,ret, 
(SELECT nama FROM b_ms_wilayah WHERE id=t1.desa_id) desa, 
(SELECT nama FROM b_ms_wilayah WHERE id=t1.kec_id) kec, 
(SELECT nama FROM b_ms_wilayah WHERE id=t1.kab_id) kab, 
(SELECT nama FROM b_ms_wilayah WHERE id=t1.prop_id) prop  FROM
	(SELECT k.*,IFNULL(tk.kamar_id,0) idkamar,0 ret,p.id idpel FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
	INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE k.pasien_id='".$rw['id']."' AND k.pulang=0 AND mu.inap=1 AND k.id=(SELECT MAX(id) FROM b_kunjungan WHERE pasien_id='".$rw['id']."') AND k.cabang_id = '{$cabang}'
	UNION
	SELECT k.*,0 idkamar,k.retribusi ret,p.id idpel FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
	INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE k.pasien_id='".$rw['id']."' AND p.tgl='$tgl' AND mu.inap=0 AND k.cabang_id = '{$cabang}') t1 WHERE t1.pulang=0 ORDER BY t1.idpel";
							$rsKunj=mysql_query($sqlKunj);
							if(mysql_num_rows($rsKunj)>0)
							{
							   $rwKunj=mysql_fetch_array($rsKunj);
							   $val=$rw['id']."|".$rw['no_rm']."|".$rw['nama']."|".tglSQL($rw['tgl_lahir'])."|".$rw['alamat']."|".
							   $rw['rt']."|".$rw['rw']."|".$rw['desa_id']."|".$rw['kec_id']."|".$rw['kab_id']."|".$rw['prop_id']."|".$rw['nama_ortu']."|".$rw['nama_suami_istri']."|".$rw['sex']."|".$rw['pendidikan_id']."|".$rw['pekerjaan_id']."|".$rw['agama']."|".$rw['telp']."|".$rwKunj['kso_id']."|".$rwKunj['no_anggota']."|".$rw['kelas_id']."|".$rw['st_anggota']."|".$rwKunj['id']."|".tglSQL($rwKunj['tgl'])."|".$rwKunj['asal_kunjungan']."|".tglSQL($rwKunj['tgl_sjp'])."|".$rwKunj['no_sjp']."|".$rwKunj['jenis_layanan']."|".$rwKunj['unit_id']."|".$rwKunj['idkamar']."|".$rwKunj['kelas_id']."|".$rwKunj['retribusi']."|".$rw['no_ktp']."|".$rw['desa']."|".$rw['kec']."|".$rw['kab']."|".$rw['prop']."|".$rw['gol_darah'];
							}
							else
							{
							   $sqlPenjamin="select id, kso_id,pasien_id,kelas_id,no_anggota,st_anggota from b_ms_kso_pasien where pasien_id=".$rw['id'];
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
							   $rw['rt']."|".$rw['rw']."|".$rw['desa_id']."|".$rw['kec_id']."|".$rw['kab_id']."|".$rw['prop_id']."|".$rw['nama_ortu']."|".$rw['nama_suami_istri']."|".$rw['sex']."|".$rw['pendidikan_id']."|".$rw['pekerjaan_id']."|".$rw['agama']."|".$rw['telp']."|".$ksoid."|".$no_anggota."|".$kelas_id."|".$st_anggota."|".$rw['no_ktp']."|".$rw['desa']."|".$rw['kec']."|".$rw['kab']."|".$rw['prop']."|".$rw['gol_darah'];
							}
							$i++;
						   ?>
						   <tr id="<?php echo $no;?>" lang="<?php echo $val;?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="setPasien(this.lang);">
							  <td>&nbsp;<?php echo $rw['no_rm'];?></td>
							  <td>&nbsp;<?php echo $rw['nama'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['JENIS_KLMIN'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['TMPT_LHR'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['TGL_LHR'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['ALAMAT']." RT.".$decode2[$i]['NO_RT']." RW.".$decode2[$i]['NO_RW']." ".$decode2[$i]['NAMA_KEL'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['NIK'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['NO_KK'];?></td>
						   </tr>
						   <?php
						}
						else
						{
							//echo "1. aaaa2";
							//PENDING
							
							$PROP = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='".$decode2[$i]['NO_PROP']."'",$konek)); 
							$KAB = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='".$decode2[$i]['NO_PROP'].".".$decode2[$i][NO_KAB]."'",$konek)); 
							$KEC = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='".$decode2[$i]['NO_PROP'].".".$decode2[$i]['NO_KAB'].".".$decode2[$i]['NO_KEC']."'",$konek));
							$KEL = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='".$decode2[$i]['NO_PROP'].".".$decode2[$i]['NO_KAB'].".".$decode2[$i]['NO_KEC'].".".$decode2[$i]['NO_KEL']."'",$konek));
							
							/*$PROP = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='36'",$konek)); 
							$KAB = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='36.71'",$konek)); 
							$KEC = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='36.71.7'",$konek));
							$KEL = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='36.71.7.1004'",$konek)); */
							
							//PENDING
							
							//PENDING
							
							$val="||".$decode2[$i]['NAMA_LGKP']."|".$decode2[$i]['TGL_LHR']."|".$decode2[$i]['ALAMAT']."|".
					   $decode2[$i]['NO_RT']."|".$decode2[$i]['NO_RW']."|".$KEL[0]."|".$KEC[0]."|".$KAB[0]."|".$PROP[0]."|".$decode2[$i]['NAMA_LGKP_AYAH']."||".$decode2[$i]['JENIS_KLMIN']."|".$decode2[$i]['PDDK_AKH']."|".$decode2[$i]['JENIS_PKRJN']."|".$decode2[$i]['AGAMA']."|123456789012|||||".$decode2[$i]['NIK']."|".$KEL[1]."|".$KEC[1]."|".$KAB[1]."|".$PROP[1];
							/*$val="||".$decode2[$i]['NAMA_LGKP']."|".$decode2[$i]['TGL_LHR']."|".$decode2[$i]['ALAMAT']."|".
					   $decode2[$i]['NO_RT']."|".$decode2[$i]['NO_RW']."|".$KEL[0]."|".$KEC[0]."|".$KAB[0]."|".$PROP[0]."|".$decode2[$i]['NAMA_LGKP_AYAH']."||".$decode2[$i]['JENIS_KLMIN']."|".$decode2[$i]['PDDK_AKH']."|".$decode2[$i]['JENIS_PKRJN']."|".$decode2[$i]['AGAMA']."|123456789012|||||".$decode2[$i]['NIK']."|".$KEL[1]."|".$KEC[1]."|".$KAB[1]."|".$PROP[1];*/

							//PENDING
							?>
							<tr id="<?php echo $no;?>" lang="<?php echo $val;?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="setPasien(this.lang);getNoRM()">
							  <td>&nbsp;<?php echo '-';?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['NAMA_LGKP'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['JENIS_KLMIN'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['TMPT_LHR'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['TGL_LHR'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['ALAMAT'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['NIK'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['NO_KK'];?></td>
							</tr>
							<?
						}
						$no++;
					}
				}
				else
				{
					//echo "2. aaaa <br>";
					for($y=0;$y<$jum1;$y++)
					{
					
					//PENDING
						$j_kelamin="L";
						if ($decode[$y]['JENIS_KLMIN']=="2") $j_kelamin="P";
						
						$no_rt=$decode[$y]['NO_RT'];
						$pjg=strlen($no_rt);
						for ($ij=$pjg;$ij<3;$ij++) $no_rt="0".$no_rt;
						
						$no_rw=$decode[$y]['NO_RW'];
						$pjg=strlen($no_rw);
						for ($ij=$pjg;$ij<3;$ij++) $no_rw="0".$no_rw;
						
						$PROP = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='".$decode[$y]['NO_PROP']."'",$konek)); //echo mysql_error();
						$KAB = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='".$decode[$y]['NO_PROP'].".".$decode[$y]['NO_KAB']."'",$konek)); 
						$KEC = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='".$decode[$y]['NO_PROP'].".".$decode[$y]['NO_KAB'].".".$decode[$y]['NO_KEC']."'",$konek));
						$KEL = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='".$decode[$y]['NO_PROP'].".".$decode[$y]['NO_KAB'].".".$decode[$y]['NO_KEC'].".".$decode[$y][NO_KEL]."'",$konek));
						
						/*$PROP = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='36'",$konek)); 
						$KAB = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='36.71'",$konek)); 
						$KEC = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='36.71.7'",$konek));
						$KEL = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='36.71.7.1004'",$konek));*/
					
					//PENDING
					
					//PENDING
					
					 /*$val="||".$decode[$y]['NAMA_LGKP']."|".$decode[$y]['TGL_LHR']."|".$decode[$y]['ALAMAT']."|".
					   $decode[$y]['NO_RT']."|".$decode[$y]['NO_RW']."|".$KEL[0]."|".$KEC[0]."|".$KAB[0]."|".$PROP[0]."|".$decode[$y]['NAMA_LGKP_AYAH']."||".$decode[$y]['JENIS_KLMIN']."|".$decode[$y]['PDDK_AKH']."|".$decode[$y]['JENIS_PKRJN']."|".$decode[$y]['AGAMA']."|".$d['TELP']."|||||".$decode[$y]['NIK']."|".$KEL[1]."|".$KEC[1]."|".$KAB[1]."|".$PROP[1]; *///echo $val;
					 $val="||".$decode[$y]['NAMA_LGKP']."|".$decode[$y]['TGL_LHR']."|".$decode[$y]['ALAMAT']."|".
					   $no_rt."|".$no_rw."|".$KEL[0]."|".$KEC[0]."|".$KAB[0]."|".$PROP[0]."|".$decode[$y]['NAMA_LGKP_AYAH']."||".$j_kelamin."|".$decode[$y]['PDDK_AKH']."|".$decode[$y]['JENIS_PKRJN']."|".$decode[$y]['AGAMA']."|123456789012|||||".$decode[$y]['NIK']."|".$KEL[1]."|".$KEC[1]."|".$KAB[1]."|".$PROP[1]; //echo $val;  

					//PENDING
				?>
						<tr id="<?php echo $no;?>" lang="<?php echo $val;?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="setPasien(this.lang);getNoRM()">
						  <td>&nbsp;<?php echo '-';?></td>
						  <td>&nbsp;<?php echo $decode[$y]['NAMA_LGKP'];?></td>
						  <td>&nbsp;<?php echo $j_kelamin;?></td>
						  <td>&nbsp;<?php echo $decode[$y]['TMPT_LHR'];?></td>
						  <td>&nbsp;<?php echo $decode[$y]['TGL_LHR'];?></td>
						  <td>&nbsp;<?php echo $decode[$y]['ALAMAT'];?></td>
						  <td>&nbsp;<?php echo $decode[$y]['NIK'];?></td>
						  <td>&nbsp;<?php echo $decode[$y]['NO_KK'];?></td>
						</tr>
				<?
					
						$no++;
					}
				}
			}
			else // 
			{
				if($_REQUEST['status']=='all')
				{
					//echo "3. aaaa <br>";
					//include("../koneksi/konek_siakdba.php");
					$no_ktp=$keyword[2];
					
					$json_url = $url_siak.$no_ktp;
					$ch = curl_init( $json_url );
					$options = array(
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
							//CURLOPT_POSTFIELDS => $json_string
					);
					curl_setopt($ch, CURLOPT_USERPWD, $usernameSIAKN . ':' . $passwordSIAKN);
					curl_setopt_array( $ch, $options ); //Setting curl options
					$result =  curl_exec($ch); //Getting jSON result string
					$decode = json_decode($result, true);
					
					$nokk = '0';
					if($decode[0]['NO_KK']!=''){
						$nokk = $decode[0]['NO_KK'];	 
					}
					
					$json_url2 = $url_siak_kk.$no_kk;
					$ch2 = curl_init( $json_url2 );
					$options2 = array(
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
							//CURLOPT_POSTFIELDS => $json_string
					);
					curl_setopt($ch2, CURLOPT_USERPWD, $usernameSIAKN . ':' . $passwordSIAKN);
					curl_setopt_array( $ch2, $options2 ); //Setting curl options
					$result2 =  curl_exec($ch2); //Getting jSON result string
					$decode2 = json_decode($result2, true);
					//print_r($decode2);
					$jum2 = count($decode2);
					// KERJAAN RAGA
					
					/* $qKK = "SELECT * FROM BIODATA_WNI WHERE NIK = '".$no_ktp."'";
					$kKK = oci_parse($koneksi, $qKK);
					oci_execute($kKK);
					$row = oci_fetch_array($kKK);
					
					$nokk = '0';
					if($row['NO_KK']!=''){
						$nokk = $row['NO_KK'];	 
					}
					 
					$q = "SELECT a.*,
						TO_CHAR(a.TGL_LHR, 'DD-MM-YYYY') TGL_LHR,
						CASE
						WHEN a.JENIS_KLMIN='1' THEN 'L'
						 ELSE 'P'
						END GENDER,
						b.ALAMAT,b.NO_RT,b.NO_RW,b.TELP FROM BIODATA_WNI a 
						LEFT JOIN DATA_KELUARGA b ON b.NO_KK=a.NO_KK where a.NO_KK = '".$nokk."'";
					$kueri = oci_parse($koneksi, $q);
					oci_execute($kueri); */
				?>
					<table id="pasien_table" width="800">
					<tr class="itemtableReq">
						<th style="width:10%;">No RM</th>
						<th style="width:20%;">Nama Lengkap</th>
						<th style="width:10%;">Jenis Kelamin</th>
						<th style="width:10%;">Tempat Lahir</th>
						<th style="width:10%;">Tanggal Lahir</th>
						<th style="width:20%;">Alamat</th>
						<th style="width:10%;">NIK</th>
						<th style="width:10%;">NO KK</th>
					</tr>
				<?php
					/* ================================= */
					$no=1;
					for($i=0;$i<=$jum2;$i++){
						$sql="SELECT p.id,p.no_rm,p.no_ktp,p.nama,p.tgl_lahir,p.alamat,p.rt,p.rw,p.desa_id,p.kec_id,p.kab_id,p.prop_id,p.nama_ortu,p.nama_suami_istri,
					p.sex,p.pendidikan_id,p.pekerjaan_id,p.agama,p.telp
				   FROM b_ms_pasien p
		WHERE p.no_ktp = '".$decode2[$i]['NIK']."' AND p.cabang_id = '{$cabang}' LIMIT 1";
						$queri=mysql_query($sql);
						if(mysql_num_rows($queri)){
							//echo "3. aaaa1";
							$rw=mysql_fetch_array($queri);
							$sqlKunj="SELECT DISTINCT id,no_billing,pasien_id,asal_kunjungan,ket,jenis_layanan,unit_id,loket_id,retribusi,tgl,umur_thn,umur_bln,kel_umur,
	kelas_id,kamar_id,kso_id,kso_kelas_id,tgl_sjp,no_sjp,no_anggota,pendidikan_id,pekerjaan_id,alamat,rt,rw,desa_id,kec_id,kab_id,
	prop_id,pulang,tgl_pulang,isbaru,tgl_act,user_act,idkamar,ret, 
(SELECT nama FROM b_ms_wilayah WHERE id=t1.desa_id) desa, 
(SELECT nama FROM b_ms_wilayah WHERE id=t1.kec_id) kec, 
(SELECT nama FROM b_ms_wilayah WHERE id=t1.kab_id) kab, 
(SELECT nama FROM b_ms_wilayah WHERE id=t1.prop_id) prop  FROM
	(SELECT k.*,IFNULL(tk.kamar_id,0) idkamar,0 ret,p.id idpel FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
	INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE k.pasien_id='".$rw['id']."' AND k.pulang=0 AND mu.inap=1 AND k.id=(SELECT MAX(id) FROM b_kunjungan WHERE pasien_id='".$rw['id']."') AND k.cabang_id = '{$cabang}'
	UNION
	SELECT k.*,0 idkamar,k.retribusi ret,p.id idpel FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
	INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE k.pasien_id='".$rw['id']."' AND p.tgl='$tgl' AND mu.inap=0 AND k.cabang_id = '{$cabang}') t1 WHERE t1.pulang=0 ORDER BY t1.idpel";
							$rsKunj=mysql_query($sqlKunj);
							if(mysql_num_rows($rsKunj)>0)
							{
							   $rwKunj=mysql_fetch_array($rsKunj);
							   $val=$rw['id']."|".$rw['no_rm']."|".$rw['nama']."|".tglSQL($rw['tgl_lahir'])."|".$rw['alamat']."|".
							   $rw['rt']."|".$rw['rw']."|".$rw['desa_id']."|".$rw['kec_id']."|".$rw['kab_id']."|".$rw['prop_id']."|".$rw['nama_ortu']."|".$rw['nama_suami_istri']."|".$rw['sex']."|".$rw['pendidikan_id']."|".$rw['pekerjaan_id']."|".$rw['agama']."|".$rw['telp']."|".$rwKunj['kso_id']."|".$rwKunj['no_anggota']."|".$rw['kelas_id']."|".$rw['st_anggota']."|".$rwKunj['id']."|".tglSQL($rwKunj['tgl'])."|".$rwKunj['asal_kunjungan']."|".tglSQL($rwKunj['tgl_sjp'])."|".$rwKunj['no_sjp']."|".$rwKunj['jenis_layanan']."|".$rwKunj['unit_id']."|".$rwKunj['idkamar']."|".$rwKunj['kelas_id']."|".$rwKunj['retribusi']."|".$rw['no_ktp']."|".$rw['desa']."|".$rw['kec']."|".$rw['kab']."|".$rw['prop']."|".$rw['gol_darah'];
							}
							else
							{
							   $sqlPenjamin="select id, kso_id,pasien_id,kelas_id,no_anggota,st_anggota from b_ms_kso_pasien where pasien_id=".$rw['id'];
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
							   $rw['rt']."|".$rw['rw']."|".$rw['desa_id']."|".$rw['kec_id']."|".$rw['kab_id']."|".$rw['prop_id']."|".$rw['nama_ortu']."|".$rw['nama_suami_istri']."|".$rw['sex']."|".$rw['pendidikan_id']."|".$rw['pekerjaan_id']."|".$rw['agama']."|".$rw['telp']."|".$ksoid."|".$no_anggota."|".$kelas_id."|".$st_anggota."|".$rw['no_ktp']."|".$rw['desa']."|".$rw['kec']."|".$rw['kab']."|".$rw['prop']."|".$rw['gol_darah'];
							}

							$j_kelamin="L";
							if ($decode2[$i]['JENIS_KLMIN']=="2") $j_kelamin="P";
							
							$i++;
						   ?>
						   <tr id="<?php echo $no;?>" lang="<?php echo $val;?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="setPasien(this.lang);">
							  <td>&nbsp;<?php echo $rw['no_rm'];?></td>
							  <td>&nbsp;<?php echo $rw['nama'];?></td>
							  <td>&nbsp;<?php echo $j_kelamin;?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['TMPT_LHR'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['TGL_LHR'];?></td>
							  <td>&nbsp;<?php echo $rw['alamat']." RT.".$rw['rt']." RW.".$rw['rw']." ".$rw['desa'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['NIK'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['NO_KK'];?></td>
						   </tr>
						   <?php
						}
						else
						{
							//echo "3. aaaa2";
							// PENDING 		
							$j_kelamin="L";
							if ($decode2[$i]['JENIS_KLMIN']=="2") $j_kelamin="P";
						
							$no_rt=$decode2[$i]['NO_RT'];
							$pjg=strlen($no_rt);
							for ($ij=$pjg;$ij<3;$ij++) $no_rt="0".$no_rt;
							
							$no_rw=$decode2[$i]['NO_RW'];
							$pjg=strlen($no_rw);
							for ($ij=$pjg;$ij<3;$ij++) $no_rw="0".$no_rw;
							
							$PROP = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='".$decode2[$i]['NO_PROP']."'",$konek)); 
							$KAB = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='".$decode2[$i]['NO_PROP'].".".$decode2[$i]['NO_KAB']."'",$konek)); 
							$KEC = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='".$decode2[$i]['NO_PROP'].".".$decode2[$i]['NO_KAB'].".".$decode2[$i]['NO_KEC']."'",$konek));
							$KEL = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='".$decode2[$i]['NO_PROP'].".".$decode2[$i]['NO_KAB'].".".$decode2[$i]['NO_KEC'].".".$decode2[$i]['NO_KEL']."'",$konek));
							
							/*$PROP = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='36'",$konek)); 
							$KAB = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='36.71'",$konek)); 
							$KEC = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='36.71.7'",$konek));
							$KEL = mysql_fetch_array(mysql_query("SELECT id,nama from b_ms_wilayah where kode_siak='36.71.7.1004'",$konek));*/
							
							// PENDING 
						
							// PENDING 
							
							/*$val="||".$decode2[$i]['NAMA_LGKP']."|".$decode2[$i]['TGL_LHR']."|".$decode2[$i]['ALAMAT']."|".
					   $decode2[$i]['NO_RT']."|".$decode2[$i]['NO_RW']."|".$KEL[0]."|".$KEC[0]."|".$KAB[0]."|".$PROP[0]."|".$decode2[$i]['NAMA_LGKP_AYAH']."||".$decode2[$i]['JENIS_KLMIN']."|".$decode2[$i]['PDDK_AKH']."|".$decode2[$i]['JENIS_PKRJN']."|".$decode2[$i]['AGAMA']."|".$d['TELP']."|||||".$decode2[$i]['NIK']."|".$KEL[1]."|".$KEC[1]."|".$KAB[1]."|".$PROP[1];*/
							$val="||".$decode2[$i]['NAMA_LGKP']."|".$decode2[$i]['TGL_LHR']."|".$decode2[$i]['ALAMAT']."|".
					   $no_rt."|".$no_rw."|".$KEL[0]."|".$KEC[0]."|".$KAB[0]."|".$PROP[0]."|".$decode2[$i]['NAMA_LGKP_AYAH']."||".$j_kelamin."|".$decode2[$i]['PDDK_AKH']."|".$decode2[$i]['JENIS_PKRJN']."|".$decode2[$i]['AGAMA']."|123456789012|||||".$decode2[$i]['NIK']."|".$KEL[1]."|".$KEC[1]."|".$KAB[1]."|".$PROP[1];
							
							// PENDING 
							
							?>
							<tr id="<?php echo $no;?>" lang="<?php echo $val;?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="setPasien(this.lang);getNoRM()">
							  <td>&nbsp;<?php echo '-';?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['NAMA_LGKP'];?></td>
							  <td>&nbsp;<?php echo $j_kelamin;?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['TMPT_LHR'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['TGL_LHR'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['ALAMAT'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['NIK'];?></td>
							  <td>&nbsp;<?php echo $decode2[$i]['NO_KK'];?></td>
							</tr>
							<?
						}
						$no++;
					}
					/* ================================= */
				}
			else
			{
         ?>
         
         <table id="pasien_table" width="700">
            <tr class="itemtableReq">
               <th width="6%" style="width:10%;">No RM</th>
               <th width="40%" style="width:30%;">Nama Pasien</th>
               <th width="30%" style="width:20%;">Tanggal Lahir</th>
               <th width="50%" style="width:30%;">Alamat</th>
			   <th width="50%" style="width:20%;">Nama Ortu</th>
			   <th width="28%" style="width:20%;">NIK</th>
            </tr>
            <?php
            $i=0;
			//echo "4. aaaa <br>";
            while($rw=mysql_fetch_array($rs))
			{
				$sqlKunj="SELECT DISTINCT id,no_billing,pasien_id,asal_kunjungan,ket,jenis_layanan,unit_id,loket_id,retribusi,tgl,umur_thn,umur_bln,kel_umur,
kelas_id,kamar_id,kso_id,kso_kelas_id,tgl_sjp,no_sjp,no_anggota,pendidikan_id,pekerjaan_id,alamat,rt,rw,desa_id,kec_id,kab_id,
prop_id,pulang,tgl_pulang,isbaru,tgl_act,user_act,idkamar,ret, 
(SELECT nama FROM b_ms_wilayah WHERE id=t1.desa_id) desa, 
(SELECT nama FROM b_ms_wilayah WHERE id=t1.kec_id) kec, 
(SELECT nama FROM b_ms_wilayah WHERE id=t1.kab_id) kab, 
(SELECT nama FROM b_ms_wilayah WHERE id=t1.prop_id) prop 
FROM
(SELECT k.*,IFNULL(tk.kamar_id,0) idkamar,0 ret,p.id idpel FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE k.pasien_id='".$rw['id']."' AND k.pulang=0 AND mu.inap=1 AND k.id=(SELECT MAX(id) FROM b_kunjungan WHERE pasien_id='".$rw['id']."') AND k.cabang_id = '{$cabang}'
UNION
SELECT k.*,0 idkamar,k.retribusi ret,p.id idpel FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE k.pasien_id='".$rw['id']."' AND p.tgl='$tgl' AND mu.inap=0 AND k.cabang_id = '{$cabang}') t1 WHERE t1.pulang=0 ORDER BY t1.idpel";
				//echo $sqlKunj."<br>";
               $rsKunj=mysql_query($sqlKunj);
               //echo mysql_error();
               if(mysql_num_rows($rsKunj)>0)
			   {
				   $rwKunj=mysql_fetch_array($rsKunj);
				   
				   $val=$rw['id']."|".$rw['no_rm']."|".$rw['nama']."|".tglSQL($rw['tgl_lahir'])."|".$rw['alamat']."|".
				   $rw['rt']."|".$rw['rw']."|".$rw['desa_id']."|".$rw['kec_id']."|".$rw['kab_id']."|".$rw['prop_id']."|".$rw['nama_ortu']."|".$rw['nama_suami_istri']."|".$rw['sex']."|".$rw['pendidikan_id']."|".$rw['pekerjaan_id']."|".$rw['agama']."|".$rw['telp']."|".$rwKunj['kso_id']."|".$rwKunj['no_anggota']."|".$rw['kelas_id']."|".$rw['st_anggota']."|".$rwKunj['id']."|".tglSQL($rwKunj['tgl'])."|".$rwKunj['asal_kunjungan']."|".tglSQL($rwKunj['tgl_sjp'])."|".$rwKunj['no_sjp']."|".$rwKunj['jenis_layanan']."|".$rwKunj['unit_id']."|".$rwKunj['idkamar']."|".$rwKunj['kelas_id']."|".$rwKunj['retribusi']."|".$rw['no_ktp']."|".$rw['desa']."|".$rw['kec']."|".$rw['kab']."|".$rw['prop']."|".$rw['gol_darah'];
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
				   $rw['rt']."|".$rw['rw']."|".$rw['desa_id']."|".$rw['kec_id']."|".$rw['kab_id']."|".$rw['prop_id']."|".$rw['nama_ortu']."|".$rw['nama_suami_istri']."|".$rw['sex']."|".$rw['pendidikan_id']."|".$rw['pekerjaan_id']."|".$rw['agama']."|".$rw['telp']."|".$ksoid."|".$no_anggota."|".$kelas_id."|".$st_anggota."|".$rw['no_ktp']."|".$rw['desa']."|".$rw['kec']."|".$rw['kab']."|".$rw['prop']."|".$rw['gol_darah'];
			   }
               $i++;
               ?>
               <tr id="<?php echo $i;?>" lang="<?php echo $val;?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="setPasien(this.lang);">
                  <td>&nbsp;<?php echo $rw['no_rm'];?></td>
                  <td>&nbsp;<?php echo $rw['nama'];?></td>
                  <td>&nbsp;<?php echo tglSQL($rw['tgl_lahir']);?></td>
                  <td><?php echo $rw['alamat']." RT.".$rw['rt']." RW.".$rw['rw']." ".$rw['desa'];?></td>
				  <td>&nbsp;<?php echo $rw['nama_ortu'];?></td>
                  <td>&nbsp;<?php echo $rw['no_ktp'];?></td>
               </tr>
               <?php
            }
			mysql_free_result($rs);
            ?>
         </table>
         <?php
			}
		 }
         break;      
}
mysql_close($konek);
?>
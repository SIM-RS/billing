<?
include("../sesi.php");
?>
<?php
include("../koneksi/konek.php");
$kasir=$_REQUEST['kasir'];
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
		   <?php
		   	if($_REQUEST['jenisKasir']=='0'){
		   ?>
			<th width="80">Tgl Kunjungan</th>
			<th width="60">No RM</th>
			<th width="160">Nama Pasien</th>
			<th width="200">Alamat</th>
		   <?php
		   }else{
		   ?>
			<th width="80">Tgl Pelayanan</th>
			<th width="60">No RM</th>
			<th width="160">Nama Pasien</th>
			<th width="200">Alamat</th>
			<th width="160">Tempat Layanan</th>
		   <?php
		   }
		   ?>
               
           </tr>
            <?php
            $kataKunci=$_REQUEST['keyword'];
			$status=$_REQUEST['status'];
		
		if($_REQUEST['jenisKasir']=='0'){
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
			if ($status==""){
		   		$sql="select DISTINCT k.id as kunj_id,k.kso_id,k.kso_kelas_id,mp.id,DATE_FORMAT(k.tgl,'%d-%m-%Y') as tglkunj,
mp.no_rm,mp.nama,mp.alamat,mp.nama_ortu,mp.sex,k.no_billing
from b_kunjungan k
inner join b_ms_pasien mp on mp.id=k.pasien_id INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id INNER JOIN b_tindakan t ON p.id=t.pelayanan_id LEFT JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
where (mp.nama like '$kataKunci%' or mp.no_rm = '$kataKunci') AND (t.biaya_pasien>t.bayar_pasien OR tk.beban_pasien>tk.bayar_pasien) ORDER BY k.id DESC";
			}elseif($status=="all"){
		   		$sql="select DISTINCT k.id as kunj_id,k.kso_id,k.kso_kelas_id,mp.id,DATE_FORMAT(k.tgl,'%d-%m-%Y') as tglkunj,
mp.no_rm,mp.nama,mp.alamat,mp.nama_ortu,mp.sex,k.no_billing
from b_kunjungan k
inner join b_ms_pasien mp on mp.id=k.pasien_id
where (mp.nama like '$kataKunci%' or mp.no_rm like '$kataKunci%') ORDER BY k.id DESC";
			}
		}
		else{
			if ($status==""){
		   		$sql="select k.id as kunj_id,k.kso_id,k.kso_kelas_id,mp.id,p.id as pelayanan_id,DATE_FORMAT(p.tgl,'%d-%m-%Y') as tglpel,DATE_FORMAT(k.tgl,'%d-%m-%Y') as tglkunj,
mp.no_rm,mp.nama,mp.alamat,mp.nama_ortu,mp.sex,u.nama as unit,k.no_billing
from b_kunjungan k
inner join b_ms_pasien mp on mp.id=k.pasien_id
inner join b_pelayanan p on p.kunjungan_id=k.id
inner join b_ms_unit u on u.id=p.unit_id INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
where (mp.nama like '$kataKunci%' or mp.no_rm like '$kataKunci%') AND t.biaya_pasien>t.bayar_pasien and u.parent_id in (".$_REQUEST['jenisKasir'].") GROUP BY p.id ORDER BY mp.nama,p.id DESC";
			}elseif($status=="all"){
		   		$sql="select k.id as kunj_id,k.kso_id,k.kso_kelas_id,mp.id,p.id as pelayanan_id,DATE_FORMAT(p.tgl,'%d-%m-%Y') as tglpel,DATE_FORMAT(k.tgl,'%d-%m-%Y') as tglkunj,
mp.no_rm,mp.nama,mp.alamat,mp.nama_ortu,mp.sex,u.nama as unit,k.no_billing
from b_kunjungan k
inner join b_ms_pasien mp on mp.id=k.pasien_id
inner join b_pelayanan p on p.kunjungan_id=k.id
inner join b_ms_unit u on u.id=p.unit_id INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
where (mp.nama like '$kataKunci%' or mp.no_rm like '$kataKunci%') AND u.parent_id in (".$_REQUEST['jenisKasir'].") GROUP BY p.id ORDER BY mp.nama,p.id DESC";
			}
		}
		//echo $sql;
			$rs=mysql_query($sql);
            $i=1;
            while($rw=mysql_fetch_array($rs)){
				$jaminan=0;
				$ksoid=$rw['kso_id'];
				$kso_kelas_id=$rw['kso_kelas_id'];
				if($_REQUEST['jenisKasir']=='0'){
					/*if ($ksoid==1){
						$sqlTinIGD="SELECT IFNULL(SUM(t.biaya*t.qty),0) AS total,IFNULL(SUM((t.biaya*t.qty)-t.bayar),0) AS kurang 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
WHERE p.kunjungan_id='".$rw['kunj_id']."' AND (p.unit_id=45 OR p.unit_id_asal=45) AND p.unit_id<>$idUnitAmbulan AND p.unit_id<>$idUnitJenazah AND 
mu.inap=0 AND t.bayar<(t.qty*t.biaya)";
						//echo $sqlTinIGD."<br>";
						$rsTinIGD=mysql_query($sqlTinIGD);
						$rwTinIGD=mysql_fetch_array($rsTinIGD);
						$igdTot=$rwTinIGD["total"];
						$igdKurang=$rwTinIGD["kurang"];

						$sqlTinAmbulan="SELECT IFNULL(SUM(t.biaya*t.qty),0) AS total,IFNULL(SUM((t.biaya*t.qty)-t.bayar),0) AS kurang 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
WHERE p.kunjungan_id='".$rw['kunj_id']."' AND p.unit_id=$idUnitAmbulan AND t.bayar<(t.qty*t.biaya)";
						//echo $sqlTinAmbulan."<br>";
						$rsTinAmbulan=mysql_query($sqlTinAmbulan);
						$rwTinAmbulan=mysql_fetch_array($rsTinAmbulan);
						$AmbulanTot=$rwTinAmbulan["total"];
						$AmbulanKurang=$rwTinAmbulan["kurang"];

						$sqlTinJenazah="SELECT IFNULL(SUM(t.biaya*t.qty),0) AS total,IFNULL(SUM((t.biaya*t.qty)-t.bayar),0) AS kurang 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
WHERE p.kunjungan_id='".$rw['kunj_id']."' AND p.unit_id=$idUnitJenazah AND t.bayar<(t.qty*t.biaya)";
						//echo $sqlTinJenazah."<br>";
						$rsTinJenazah=mysql_query($sqlTinJenazah);
						$rwTinJenazah=mysql_fetch_array($rsTinJenazah);
						$JenazahTot=$rwTinJenazah["total"];
						$JenazahKurang=$rwTinJenazah["kurang"];
						
						$sqlTin="select IFNULL(sum(t.biaya*t.qty),0) as total,IFNULL(sum((t.biaya*t.qty)-t.bayar),0) as kurang from b_tindakan t
	inner join b_pelayanan p on t.pelayanan_id=p.id
	where p.kunjungan_id='".$rw['kunj_id']."' AND p.unit_id<>$idUnitAmbulan AND p.unit_id<>$idUnitJenazah AND t.bayar < (t.biaya*t.qty)";
						//echo $sqlTin."<br/>";
						$rsTin=mysql_query($sqlTin);
						$rwTin=mysql_fetch_array($rsTin);
						
						$sql="SELECT IFNULL(SUM(b.titipan-b.titipan_terpakai),0) AS titip FROM b_bayar b WHERE b.kunjungan_id='".$rw['kunj_id']."' AND b.kasir_id='".$_REQUEST['kasir']."' AND b.tipe=1";
						//echo $sql."<br/>";
						$rsTitip=mysql_query($sql);
						$rwTitip=mysql_fetch_array($rsTitip);
						
						$sqlKamar="SELECT IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*tarip,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*tarip)),0) AS kamar, 
IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*tarip-bayar,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*tarip-bayar)),0) AS kurang_kamar,SUM(IFNULL(bayar,0)) bayar 
FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id 
WHERE p.kunjungan_id='".$rw['kunj_id']."' AND b.aktif=1";
						//echo $sqlKamar."<br/>";
						$rsKamar=mysql_query($sqlKamar);
						$rwKamar=mysql_fetch_array($rsKamar);
						//$total=$rwTin['total']+$rwKamar['kamar']-$rwKamar['bayar'];
						$total=$rwTin['kurang']+$rwKamar['kamar']-$rwKamar['bayar'];
						$kurang=$rwTin['kurang']+$rwKamar['kurang_kamar']-$rwTitip['titip'];
					}else{*/
						$sqlTinIGD="SELECT IFNULL(SUM((t.biaya_pasien+t.biaya_kso)*t.qty),0) AS total,IFNULL(SUM((t.biaya_pasien*t.qty)-t.bayar),0) AS kurang 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
WHERE p.kunjungan_id='".$rw['kunj_id']."' AND (p.unit_id=45 OR p.unit_id_asal=45) AND p.unit_id<>$idUnitAmbulan AND p.unit_id<>$idUnitJenazah AND 
mu.inap=0 AND t.lunas=0";
						//echo $sqlTinIGD."<br/>";
						$rsTinIGD=mysql_query($sqlTinIGD);
						$rwTinIGD=mysql_fetch_array($rsTinIGD);
						$igdTot=$rwTinIGD["total"];
						$igdKurang=$rwTinIGD["kurang"];
						$igdJaminan=$igdTot-$igdKurang;

						$sqlTinAmbulan="SELECT IFNULL(SUM(t.biaya*t.qty),0) AS total,IFNULL(SUM((t.biaya*t.qty)-t.bayar),0) AS kurang 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
WHERE p.kunjungan_id='".$rw['kunj_id']."' AND p.unit_id=$idUnitAmbulan AND t.bayar<(t.qty*t.biaya)";
						//echo $sqlTinAmbulan."<br>";
						$rsTinAmbulan=mysql_query($sqlTinAmbulan);
						$rwTinAmbulan=mysql_fetch_array($rsTinAmbulan);
						$AmbulanTot=$rwTinAmbulan["total"];
						$AmbulanKurang=$rwTinAmbulan["kurang"];
						$AmbulanJaminan=$AmbulanTot-$AmbulanKurang;

						$sqlTinJenazah="SELECT IFNULL(SUM(t.biaya*t.qty),0) AS total,IFNULL(SUM((t.biaya*t.qty)-t.bayar),0) AS kurang 
FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
WHERE p.kunjungan_id='".$rw['kunj_id']."' AND p.unit_id=$idUnitJenazah AND t.bayar<(t.qty*t.biaya)";
						//echo $sqlTinJenazah."<br>";
						$rsTinJenazah=mysql_query($sqlTinJenazah);
						$rwTinJenazah=mysql_fetch_array($rsTinJenazah);
						$JenazahTot=$rwTinJenazah["total"];
						$JenazahKurang=$rwTinJenazah["kurang"];
						$JenazahJaminan=$JenazahTot-$JenazahKurang;

						$sqlTin="SELECT IFNULL(SUM(t.biaya_kso*t.qty),0) AS jaminan FROM b_tindakan t
INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
WHERE p.kunjungan_id='".$rw['kunj_id']."' AND p.unit_id<>$idUnitAmbulan AND p.unit_id<>$idUnitJenazah AND t.lunas=0 AND t.id NOT IN 
(SELECT tindakan_id FROM b_bayar_tindakan bt INNER JOIN b_bayar b ON bt.bayar_id=b.id WHERE b.kunjungan_id='".$rw['kunj_id']."')";
						//echo $sqlTin."<br/>";
						$rsTin=mysql_query($sqlTin);
						$rwTin=mysql_fetch_array($rsTin);
						$jaminan=$rwTin['jaminan'];
						
						if ($kasir==127){
							$sqlTin="select IFNULL(sum((t.biaya_kso+t.biaya_pasien)*t.qty),0) as total,IFNULL(sum(((t.biaya_kso+t.biaya_pasien)*t.qty)-t.bayar),0) as kurang from b_tindakan t
	inner join b_pelayanan p on t.pelayanan_id=p.id
	where p.kunjungan_id='".$rw['kunj_id']."' AND p.unit_id<>$idUnitAmbulan AND p.unit_id<>$idUnitJenazah AND t.lunas=0 AND t.ms_tindakan_kelas_id IN (7513) AND t.id NOT IN 
(SELECT tindakan_id FROM b_bayar_tindakan bt INNER JOIN b_bayar b ON bt.bayar_id=b.id WHERE b.kunjungan_id='".$rw['kunj_id']."')";
						}else{
							$sqlTin="select IFNULL(sum((t.biaya_kso+t.biaya_pasien)*t.qty),0) as total,IFNULL(sum(((t.biaya_kso+t.biaya_pasien)*t.qty)-t.bayar),0) as kurang from b_tindakan t
	inner join b_pelayanan p on t.pelayanan_id=p.id
	where p.kunjungan_id='".$rw['kunj_id']."' AND p.unit_id<>$idUnitAmbulan AND p.unit_id<>$idUnitJenazah AND t.lunas=0 AND t.id NOT IN 
(SELECT tindakan_id FROM b_bayar_tindakan bt INNER JOIN b_bayar b ON bt.bayar_id=b.id WHERE b.kunjungan_id='".$rw['kunj_id']."')";
						}
						//echo $sqlTin."<br/>";
						$rsTin=mysql_query($sqlTin);
						$rwTin=mysql_fetch_array($rsTin);
						
						$sql="SELECT IFNULL(SUM(b.titipan-b.titipan_terpakai),0) AS titip FROM b_bayar b WHERE b.kunjungan_id='".$rw['kunj_id']."' AND b.kasir_id='".$_REQUEST['kasir']."' AND b.tipe=1";
						$rsTitip=mysql_query($sql);
						$rwTitip=mysql_fetch_array($rsTitip);
				
						$sqlKamar="SELECT IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso+beban_pasien),
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso+beban_pasien))),0) AS kamar,
IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso),
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso))),0) AS kamar_kso,
IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso+beban_pasien)-bayar,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso+beban_pasien)-bayar)),0) AS kurang_kamar,SUM(IFNULL(bayar,0)) bayar 
FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id 
WHERE p.kunjungan_id='".$rw['kunj_id']."' AND b.aktif=1";
						//echo $sqlKamar."<br/>";
						$rsKamar=mysql_query($sqlKamar);
						$rwKamar=mysql_fetch_array($rsKamar);
						$jaminan+=$rwKamar['kamar_kso'];
						$total=$rwTin['total']+$rwKamar['kamar']-$rwKamar['bayar'];
						$kurang=$rwTin['kurang']+$rwKamar['kurang_kamar']-$rwTitip['titip']-$jaminan;
						
						//======Tambahan u/ BHP Askes naik Kelas, diambil dr Farmasi======
						if ($ksoid==4){
							$sqlCekNaikKls="SELECT DISTINCT p.id,p.kelas_id FROM b_pelayanan p WHERE p.kunjungan_id='".$rw['kunj_id']."' AND p.jenis_kunjungan=3 AND p.kelas_id<>10 AND p.kelas_id<>35 AND p.kelas_id<>36";
							//echo $sqlCekNaikKls."<br/>";
							$rsCekNaikKls=mysql_query($sqlCekNaikKls);
							while ($rwCekNaikKls=mysql_fetch_array($rsCekNaikKls)){
								if ($kso_kelas_id!=$rwCekNaikKls["kelas_id"]){
									$sqlBHP_Askes="SELECT ap.CARA_BAYAR,
SUM(IF(bhp.id IS NULL,(ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN,0)) JAMINBHP,
SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL 
FROM ".$dbapotek.".a_penjualan ap INNER JOIN ".$dbapotek.".a_cara_bayar ac ON ap.CARA_BAYAR=ac.id
INNER JOIN ".$dbapotek.".a_penerimaan p ON ap.PENERIMAAN_ID=p.ID
LEFT JOIN ".$dbapotek.".a_obat_askes_bhp bhp ON p.OBAT_ID=bhp.obat_id
WHERE ap.NO_PASIEN='".$rw['no_rm']."' AND ap.NO_KUNJUNGAN='".$rwCekNaikKls['id']."'";
									//echo $sqlBHP_Askes."<br/>";
									$rsBHP_Askes=mysql_query($sqlBHP_Askes);
									$rwBHP_Askes=mysql_fetch_array($rsBHP_Askes);
									if ($rwBHP_Askes["CARA_BAYAR"]==2){
										$BHPTot=$rwBHP_Askes["SUBTOTAL"];
										$BHPJaminan=$rwBHP_Askes["JAMINBHP"];
										$BHPKurang=$BHPTot-$BHPJaminan;
										
										$total+=$BHPTot;
										$jaminan+=$BHPJaminan;
										$kurang+=$BHPKurang;
									}
								}
							}
						}
					//}
				}else{
					/*if ($ksoid==1){
						$sqlTin="SELECT IFNULL(SUM(t.biaya*t.qty),0) AS total,SUM((t.biaya*t.qty)-t.bayar) AS kurang FROM b_tindakan t WHERE t.pelayanan_id='".$rw['pelayanan_id']."' AND bayar < (biaya*qty)";
						//echo $sqlTin."<br/>";
					}else{*/
						$sqlTin="SELECT IFNULL(SUM(biaya_kso*qty),0) AS jaminan FROM b_tindakan WHERE pelayanan_id='".$rw['pelayanan_id']."' AND biaya_kso > 0";
						//echo $sqlTin."<br/>";
						$rsTin=mysql_query($sqlTin);
						$rwTin=mysql_fetch_array($rsTin);
						$jaminan=$rwTin['jaminan'];
						
						$sqlTin="SELECT IFNULL(SUM((t.biaya_kso+t.biaya_pasien)*t.qty),0) AS total,SUM(((t.biaya_kso+t.biaya_pasien)*t.qty)-t.bayar) AS kurang FROM b_tindakan t WHERE t.pelayanan_id='".$rw['pelayanan_id']."' AND t.lunas=0";
						//echo $sqlTin."<br/>";
					//}
					$rsTin=mysql_query($sqlTin);
					$rwTin=mysql_fetch_array($rsTin);
					
					$sql="SELECT IFNULL(SUM(b.titipan-b.titipan_terpakai),0) AS titip FROM b_bayar b WHERE b.kunjungan_id='".$rw['kunj_id']."' AND b.kasir_id='".$_REQUEST['kasir']."' AND b.tipe=1";
					$rsTitip=mysql_query($sql);
					$rwTitip=mysql_fetch_array($rsTitip);
			   		$total=$rwTin['total'];
			   		$kurang=$rwTin['kurang']-$rwTitip['titip']-$jaminan;
				}
               	$val=$rw['id']."|".$rw['no_rm']."|".$rw['nama']."|".$rw['alamat']."|".
               	$rw['nama_ortu']."|".$rw['sex']."|".$rw['no_billing']."|".$total."|".
		   		$kurang."|".$rw['kunj_id']."|".$rw['tglkunj']."|".$rw['pelayanan_id']."|".$rwTitip['titip']."|".$rw['kso_id']."|".$jaminan."|".$rw['no_billing']."|".$igdTot."|".$igdKurang."|".$igdJaminan."|".$AmbulanTot."|".$AmbulanKurang."|".$AmbulanJaminan."|".$JenazahTot."|".$JenazahKurang."|".$JenazahJaminan;
               ?>
               <tr id="<?php echo $i;?>" lang="<?php echo $val;?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="setPasien(this.lang);">
                   <?php
				if($_REQUEST['jenisKasir']=='0'){
			?>
			   <td>&nbsp;<?php echo $rw['tglkunj'];?></td>
			   <td>&nbsp;<?php echo $rw['no_rm'];?></td>
			   <td>&nbsp;<?php echo $rw['nama'];?></td>
			   <td>&nbsp;<?php echo $rw['alamat'];?></td>			   
			<?php
				}else{
			?>
			   <td>&nbsp;<?php echo $rw['tglpel'];?></td>
			   <td>&nbsp;<?php echo $rw['no_rm'];?></td>
			   <td>&nbsp;<?php echo $rw['nama'];?></td>
			   <td>&nbsp;<?php echo $rw['alamat'];?></td>
			   <td>&nbsp;<?php echo $rw['unit'];?></td>
			<?php
				}
			?>
               </tr>
               <?php
		   $i++;
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
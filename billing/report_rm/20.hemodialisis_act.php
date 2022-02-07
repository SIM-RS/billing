
<?php
include("../koneksi/konek.php");
$idUsr=$_REQUEST['idUsr'];	
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$idPsn=$_REQUEST['idPsn'];
$act=$_REQUEST['act'];

$tanggal1=tglSQL($_REQUEST['tanggal1']);
$pukul1=$_REQUEST['pukul1'];
$riwayat=$_REQUEST['riwayat'];
$bmi=$_REQUEST['bmi'];
$mata=$_REQUEST['mata'];
$bb_pre_hd=$_REQUEST['bb_pre_hd'];
$bb_post_hd=$_REQUEST['bb_post_hd'];
$iwg=$_REQUEST['iwg'];
$lama=$_REQUEST['lama'];
$qb_program=$_REQUEST['qb_program'];
$qd_program=$_REQUEST['qd_program'];
$ufg_program=$_REQUEST['ufg_program'];
$dosis_awal=$_REQUEST['dosis_awal'];
$maintenance=$_REQUEST['maintenance'];
$mesin_no=$_REQUEST['mesin_no'];
$jenis_dialiser=$_REQUEST['jenis_dialiser'];
$tipe_dialiser=$_REQUEST['tipe_dialiser'];
$reuse_ke=$_REQUEST['reuse_ke'];
$volume_priming=$_REQUEST['volume_priming'];
$cairan_keluar=$_REQUEST['cairan_keluar'];
$sisa_priming=$_REQUEST['sisa_priming'];
$cairan_drip=$_REQUEST['cairan_drip'];
$darah=$_REQUEST['darah'];
$wash_out=$_REQUEST['wash_out'];
$jumlah=$volume_priming+$cairan_keluar+$sisa_priming+$cairan_drip+$darah+$wash_out;
$jenis_transfusi=$_REQUEST['jenis_transfusi'];
$cc_transfusi=$_REQUEST['cc_transfusi'];
$jumlah_transfusi=$_REQUEST['jumlah_transfusi'];
$no_seri1=$_REQUEST['no_seri1'];
$no_seri2=$_REQUEST['no_seri2'];
$no_seri3=$_REQUEST['no_seri3'];
$laboratorium=$_REQUEST['laboratorium'];
$foto_thorax=$_REQUEST['foto_thorax'];
$ekg=$_REQUEST['ekg'];
$jam_pemberian=$_REQUEST['jam_pemberian'];
$jam_setelah=$_REQUEST['jam_setelah'];
$kondisi_setelah=$_REQUEST['kondisi_setelah'];
$td_setelah=$_REQUEST['td_setelah'];
$nadi_setelah=$_REQUEST['nadi_setelah'];
$rr_setelah=$_REQUEST['rr_setelah'];
$suhu_setelah=$_REQUEST['suhu_setelah'];
$catatan_hemodialisis1=$_REQUEST['catatan_hemodialisis1'];
$catatan_hemodialisis2=$_REQUEST['catatan_hemodialisis2'];
$tgl_selanjutnya=tglSQL($_REQUEST['tgl_selanjutnya']);
$jam_selanjutnya=$_REQUEST['jam_selanjutnya'];
$terapi=$_REQUEST['terapi'];
$hemodialisis_pertama=$_REQUEST['hemodialisis_pertama'];
$hemodialisis_terakhir=$_REQUEST['hemodialisis_terakhir'];
$dializer=$_REQUEST['dializer'];
$jenis_dialisat=$_REQUEST['jenis_dialisat'];
$lama_dialisis=$_REQUEST['lama_dialisis'];
$kecepatan_darah=$_REQUEST['kecepatan_darah'];
$akses_vaskuler=$_REQUEST['akses_vaskuler'];
$heparinisasi=$_REQUEST['heparinisasi'];
$transfusi_terakhir=$_REQUEST['transfusi_terakhir'];
$lab_terakhir=$_REQUEST['lab_terakhir'];
$tgl_traveling=tglSQL($_REQUEST['tgl_traveling']);
$hb_traveling=$_REQUEST['hb_traveling'];
$ureum_traveling=$_REQUEST['ureum_traveling'];
$hiv_traveling=$_REQUEST['hiv_traveling'];
$gds_traveling=$_REQUEST['gds_traveling'];
$creatinin_traveling=$_REQUEST['creatinin_traveling'];
$hbs_traveling=$_REQUEST['hbs_traveling'];
$hcv_traveling=$_REQUEST['hcv_traveling'];
$catatan=$_REQUEST['catatan'];

$urine=$_REQUEST['OUrine'];
$muntah=$_REQUEST['OMuntah'];
$ultra=$_REQUEST['OUltra'];

$tcv=$_REQUEST['tcv'];
$avbl=$_REQUEST['avbl'];
$total_volume=$tcv+$avbl;

$jam=$_REQUEST['jam'];
$td=$_REQUEST['td'];
$nadi=$_REQUEST['nadi'];
$rr=$_REQUEST['rr'];
$suhu=$_REQUEST['suhu'];
$qb=$_REQUEST['qb'];
$ufg=$_REQUEST['ufg'];
$ufr=$_REQUEST['ufr'];
$uf=$_REQUEST['uf'];
$tek=$_REQUEST['tek'];
$tmp=$_REQUEST['tmp'];
$heparin=$_REQUEST['heparin'];
$keterangan=$_REQUEST['keterangan'];
$minum=$_REQUEST['minum'];
$bbkering=$_REQUEST['bbkering'];
$tbadan=$_REQUEST['tbadan'];
$ktv=$_REQUEST['ktv'];
$dokter=$_REQUEST['dokter'];

$check=$_REQUEST['check'];

for($i=0;$i<=48;$i++){
	$cek.=$check[$i].',';
}


switch(strtolower($_REQUEST['act'])){
	case 'tambah':
	/*$sql="INSERT INTO b_ms_hemodialisis VALUES ('','$idUsr', CURDATE(),'$idPel','$idPsn','$idKunj','$cek','$tanggal1','$pukul1','$riwayat','$bmi','$mata','$bb_pre_hd','$bb_post_hd','$iwg','$lama','$qb_program','$qd_program','$ufg_program','$dosis_awal','$maintenance','$mesin_no','$jenis_dialiser','$tipe_dialiser','$volume_priming','$cairan_keluar','$sisa_priming','$cairan_drip','$darah','$wash_out','$jumlah','$jenis_transfusi','$jumlah_transfusi','$no_seri1','$no_seri2','$no_seri3','$laboratorium','$foto_thorax','$ekg','$jam_pemberian','$kondisi_setelah','$jam_setelah','$td_setelah','$nadi_setelah','$suhu_setelah','$rr_setelah','$catatan_hemodialisis1','$catatan_hemodialisis2','$tgl_selanjutnya','$jam_selanjutnya','$terapi','$hemodialisis_pertama','$hemodialisis_terakhir','$dializer','$jenis_dialisat','$lama_dialisis','$kecepatan_darah','$akses_vaskuler','$heparinisasi','$transfusi_terakhir','$lab_terakhir','$tgl_traveling','$hb_traveling','$ureum_traveling','$hiv_traveling','$gds_traveling','$creatinin_traveling','$hbs_traveling','$hcv_traveling','$catatan','$urine','$muntah','$ultra','$minum','$bbkering','$tbadan','$ktv','$dokter','$reuse_ke','$tcv','$avbl','$total_volume','$cc_transfusi')";*/
	$sql="INSERT INTO b_ms_hemodialisis
(user_act,tgl_act,id_pelayanan,id_pasien,id_kunjungan,checked,tanggal1,pukul1,riwayat,bmi,mata,bb_pre_hd,bb_post_hd,iwg,lama,qb_program,qd_program,
ufg_program,dosis_awal,maintenance,mesin_no,jenis_dialiser,tipe_dialiser,volume_priming,cairan_keluar,sisa_priming,cairan_drip,darah,wash_out,jumlah,
jenis_transfusi,jumlah_transfusi,no_seri1,no_seri2,no_seri3,laboratorium,foto_thorax,ekg,jam_pemberian,kondisi_setelah,jam_setelah,td_setelah,nadi_setelah,
suhu_setelah,rr_setelah,catatan_hemodialisis1,catatan_hemodialisis2,tgl_selanjutnya,jam_selanjutnya,terapi,hemodialisis_pertama,hemodialisis_terakhir,
dializer,jenis_dialisat,lama_dialisis,kecepatan_darah,akses_vaskuler,heparinisasi,transfusi_terakhir,lab_terakhir,tgl_traveling,hb_traveling,ureum_traveling,
hiv_traveling,gds_traveling,creatinin_traveling,hbs_traveling,hcv_traveling,catatan,urine,muntah,ultra,minum,bbkering,tbadan,ktv,dokter,reuse,tcv,
avbl,total_volume,cc_transfusi)
VALUES ('$idUsr',CURDATE(),'$idPel','$idPsn','$idKunj','$cek','$tanggal1','$pukul1','$riwayat','$bmi','$mata','$bb_pre_hd','$bb_post_hd','$iwg','$lama',
'$qb_program','$qd_program','$ufg_program','$dosis_awal','$maintenance','$mesin_no','$jenis_dialiser','$tipe_dialiser','$volume_priming','$cairan_keluar',
'$sisa_priming','$cairan_drip','$darah','$wash_out','$jumlah','$jenis_transfusi','$jumlah_transfusi','$no_seri1','$no_seri2','$no_seri3','$laboratorium',
'$foto_thorax','$ekg','$jam_pemberian','$kondisi_setelah','$jam_setelah','$td_setelah','$nadi_setelah','$suhu_setelah','$rr_setelah','$catatan_hemodialisis1',
'$catatan_hemodialisis2','$tgl_selanjutnya','$jam_selanjutnya','$terapi','$hemodialisis_pertama','$hemodialisis_terakhir','$dializer','$jenis_dialisat',
'$lama_dialisis','$kecepatan_darah','$akses_vaskuler','$heparinisasi','$transfusi_terakhir','$lab_terakhir','$tgl_traveling','$hb_traveling','$ureum_traveling','$hiv_traveling','$gds_traveling','$creatinin_traveling','$hbs_traveling','$hcv_traveling','$catatan','$urine','$muntah','$ultra','$minum','$bbkering',
'$tbadan','$ktv','$dokter','$reuse_ke','$tcv','$avbl','$total_volume','$cc_transfusi');";
		//echo $sql;
		$ex=mysql_query($sql);
		if($ex){
			$idx=mysql_insert_id();
			$i=0;
			foreach($jam as $key){
				 $sqlD="INSERT INTO b_ms_hemodialisis_detail VALUES ('','$idx','$jam[$i]','$td[$i]','$nadi[$i]','$rr[$i]','$suhu[$i]','$qb[$i]','$ufg[$i]','$ufr[$i]','$uf[$i]','$tek[$i]','$tmp[$i]','$heparin[$i]','$keterangan[$i]')";		
				mysql_query($sqlD);
				$i++;
				}
			echo mysql_error();
				
			echo "Data berhasil disimpan !";
			}else{
				echo mysql_error();
				echo "Data gagal disimpan !";
			}
	break;
	case 'edit':
  
  $sql="UPDATE b_ms_hemodialisis set tgl_act=CURDATE(), checked='$cek', tanggal1='$tanggal1', pukul1='$pukul1',riwayat='$riwayat',bmi='$bmi',mata='$mata',bb_pre_hd='$bb_pre_hd',bb_post_hd='$bb_post_hd',iwg='$iwg',lama='$lama',qb_program='$qb_program',qd_program='$qd_program',ufg_program='$ufg_program',dosis_awal='$dosis_awal',maintenance='$maintenance',mesin_no='$mesin_no',jenis_dialiser='$jenis_dialiser',tipe_dialiser='$tipe_dialiser',volume_priming='$volume_priming',cairan_keluar='$cairan_keluar',sisa_priming='$sisa_priming',cairan_drip='$cairan_drip',darah='$darah',wash_out='$wash_out',jumlah='$jumlah',jenis_transfusi='$jenis_transfusi',cc_transfusi='$cc_transfusi',jumlah_transfusi='$jumlah_transfusi',no_seri1='$no_seri1',no_seri2='$no_seri2',no_seri3='$no_seri3',laboratorium='$laboratorium',foto_thorax='$foto_thorax',ekg='$ekg',jam_pemberian='$jam_pemberian',kondisi_setelah='$kondisi_setelah',jam_setelah='$jam_setelah',td_setelah='$td_setelah',nadi_setelah='$nadi_setelah',suhu_setelah='$suhu_setelah',rr_setelah='$rr_setelah',catatan_hemodialisis1='$catatan_hemodialisis1',catatan_hemodialisis2='$catatan_hemodialisis2',tgl_selanjutnya='$tgl_selanjutnya',jam_selanjutnya='$jam_selanjutnya',terapi='$terapi',hemodialisis_pertama='$hemodialisis_pertama',hemodialisis_terakhir='$hemodialisis_terakhir',dializer='$dializer',jenis_dialisat='$jenis_dialisat',lama_dialisis='$lama_dialisis',kecepatan_darah='$kecepatan_darah',akses_vaskuler='$akses_vaskuler',heparinisasi='$heparinisasi',transfusi_terakhir='$transfusi_terakhir',lab_terakhir='$lab_terakhir',tgl_traveling='$tgl_traveling',hb_traveling='$hb_traveling',ureum_traveling='$ureum_traveling',hiv_traveling='$hiv_traveling',gds_traveling='$gds_traveling',creatinin_traveling='$creatinin_traveling',hbs_traveling='$hbs_traveling',hcv_traveling='$hcv_traveling',catatan='$catatan',urine='$urine',muntah='$muntah',ultra='$ultra',minum='$minum',bbkering='$bbkering',tbadan='$tbadan',ktv='$ktv',dokter='$dokter',reuse='$reuse_ke',tcv='$tcv',avbl='$avbl',total_volume='$total_volume'  where id='".$_REQUEST['txtId']."'";
		//echo $sql;
	$ex=mysql_query($sql);
	if($ex){
		mysql_query("delete from b_ms_hemodialisis_detail where id_hemodialisis='".$_REQUEST['txtId']."'");
		$i=0;
			foreach($jam as $key){
				 $sqlD="INSERT INTO b_ms_hemodialisis_detail VALUES ('','".$_REQUEST['txtId']."','$jam[$i]','$td[$i]','$nadi[$i]','$rr[$i]','$suhu[$i]','$qb[$i]','$ufg[$i]','$ufr[$i]','$uf[$i]','$tek[$i]','$tmp[$i]','$heparin[$i]','$keterangan[$i]')";
				mysql_query($sqlD);
				$i++;
				}
				
			echo "Data berhasil disimpan !";
			}else{
				echo mysql_error();
				echo "Data gagal disimpan !";
			}
	break;
	case 'hapus':
		$sqlh="delete from b_ms_hemodialisis_detail where id_hemodialisis='".$_REQUEST['txtId']."'";
		$hapus=mysql_query($sqlh);
		if($hapus){
			$sqlh2="delete from b_ms_hemodialisis where id='".$_REQUEST['txtId']."'";
			$ex=mysql_query($sqlh2);
			//echo $sqlh2;
			if($ex){
				echo "Data berhasil dihapus !";
				
				}else{
				echo "Data gagal dihapus !";
				}
			
			}else{
				
				}
	break;
		
}
?>
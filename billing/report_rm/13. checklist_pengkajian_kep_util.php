<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="tgl_act";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$level = ($_REQUEST['level']=='')?1:$_REQUEST['level'];
$kodeAk=$_REQUEST["kodeAk"];
$nama = $_REQUEST['nama'];
$nama = str_replace(chr(5),'&',$nama);
if($_GET['ktgr'] == 4){
    $cakupan = $_GET['cakupan'];
}
else{
    $cakupan = 0;
}
//===============================
$statusProses='';
$alasan='';
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$tind=$_REQUEST['txt_tind'];
	$rad_thd=$_REQUEST['rad_thd'];
	$txt_nama=$_REQUEST['txt_nama'];
	$txt_umur=$_REQUEST['txt_umur'];
	$rad_lp=$_REQUEST['rad_lp'];
	$txt_alamat=$_REQUEST['txt_alamat'];
	$txt_tlp=$_REQUEST['txt_tlp'];
	$txt_ktp=$_REQUEST['txt_ktp'];
	$txt_rawat=$_REQUEST['txt_rawat'];
	$txt_rekam=$_REQUEST['txt_rekam'];
	$txt_resiko=$_REQUEST['txt_resiko'];
	$idUsr=$_REQUEST['idUsr'];
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_fom_tolak_tind_medis(pelayanan_id,kunjungan_id,tindakan,terhadap,nama,umur,sex,alamat,no_tlp,no_ktp,dirawat,no_rm,resiko,tgl_act,user_act) VALUES('$idPel','$idKunj','$tind','$rad_thd','$txt_nama','$txt_umur','$rad_lp','$txt_alamat','$txt_tlp','$txt_ktp','$txt_rawat','$txt_rekam','$txt_resiko',CURDATE(),'$idUsr')";
		$ex=mysql_query($sql);
	break;
	case 'edit':
	break;
	case 'hapus':
	break;
		
}


	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	
	$sql="SELECT b.*,bmp.nama,bmp.no_rm,pp.nama AS nama_usr FROM b_fom_chk_perawat b
LEFT JOIN b_pelayanan bp ON bp.id=b.pelayanan_id
LEFT JOIN b_ms_pasien bmp ON bmp.id=bp.pasien_id
LEFT JOIN b_ms_pegawai pp ON pp.id=b.user_act
WHERE b.pelayanan_id='$idPel' ".$filter." order by ".$sorting;
	
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$jmldata=mysql_num_rows($rs);
	if ($page=="" || $page=="0") $page=1;
	$tpage=($page-1)*$perpage;
	if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
	if ($page>1) $bpage=$page-1; else $bpage=1;
	if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
	$sql=$sql." limit $tpage,$perpage";
	//echo $sql;
	$thd=array(1=>'Sendiri',2=>'Suami',3=>'Istri',4=>'Ortu',5=>'Ayah',6=>'Ibu',7=>'Wali',8=>'Anak Saya');
	$rs=mysql_query($sql);
	$i=($page-1)*$perpage;
	$dt=$totpage.chr(5);
	$protase='';
	$dirawat='';
	$alergi='';
	$TD='';
	$frek_umum='';
	$BAK='';
	$muntah='';
	$hemat='';
	$turgor='';
	$edema='';
	$BAB='';
	$melena='';
	$invasif='';
	$plebitis='';
	$kulit='';
	$turgor_2='';
	$endema_2='';
	$kebiasaan='';
	$termoregulasi='';
	$nutrisi='';
	$cairan='';
	$eliminasiU='';
	$eliminasiA='';
	$psikiatrik='';
	$tranfusi='';
	$penyakit='';
		
	while ($rows=mysql_fetch_array($rs)){
		$i++;
		$protase=explode('|',$rows['alat_protase']);
		$dirawat=explode('|',$rows['dirawat']);
		$alergi=explode('|',$rows['alergi']);
		$tranfusi=explode('|',$rows['tranfusi']);
		$penyakit=explode('|',$rows['penyakit_klg']);
		$TD=explode('|',$rows['TD']);
		$frek_umum=explode('|',$rows['frek_umum']);
		$BAK=explode('|',$rows['BAK']);
		$muntah=explode('|',$rows['muntah']);
		$hemat=explode('|',$rows['hematemeis']);
		$turgor=explode('|',$rows['turgor']);
		$edema=explode('|',$rows['edema']);
		$BAB=explode('|',$rows['BAB']);
		$melena=explode('|',$rows['melena']);
		$invasif=explode('|',$rows['invasif']);
		$plebitis=explode('|',$rows['plebitis']);
		$kulit=explode('|',$rows['kulit']);
		$turgor_2=explode('|',$rows['turgor_2']);
		$endema_2=explode('|',$rows['edema_2']);
		$kebiasaan=explode('|',$rows['kebiasaan']);
		$termoregulasi=explode('|',$rows['g_termoregulasi']);
		$nutrisi=explode('|',$rows['g_keb_nutrisi']);
		$cairan=explode('|',$rows['g_vol_cairan']);
		$eliminasiU=explode('|',$rows['g_eliminasi_u']);
		$eliminasiA=explode('|',$rows['g_eliminasi_a']);
		$psikiatrik=explode('|',$rows['g_psikiatrik']);
		
		
		$radchk=$rows['melalui'].','.
		$rows['menggunakan'].','.
		$protase[0].','.
		$rows['gelang'].','.
		$dirawat[0].','.
		$alergi[0].','.
		$tranfusi[0].','.
		$tranfusi[1].','.
		$penyakit[0].','.
		$rows['motorik'].','.
		$rows['berbicara'].','.
		$rows['penglihatan'].','.
		$rows['pendengaran'].','.
		$rows['suara_nafas'].','.
		$rows['sputum'].','.
		$rows['kawin'].','.
		$rows['makan'].','.
		$rows['asites'].','.
		$turgor[0].','.
		$edema[0].','.
		$BAB[0].','.
		$rows['peristaltik'].','.
		$rows['masalah_tdr'].','.
		$rows['traksi'].','.
		$rows['gibs'].','.
		$invasif[0].','.
		$rows['mulut'].','.
		$rows['gigi_palsu'].','.
		$kulit[0].','.
		$turgor_2[0].','.
		$endema_2[0].','.
		$rows['rambut'].','.
		$kebiasaan[0].','.
		$rows['emosi'].','.
		$termoregulasi[1].','.
		$nutrisi[1].','.
		$cairan[1].','.
		$eliminasiU[1].','.
		$eliminasiA[1].','.
		$psikiatrik[1].','.
		$plebitis[0].'*=*'. // batas radio dan checj box
		$penyakit[1].','.
		$rows['g_cerebral'].','.
		$rows['g_gas'].','.
		$rows['g_jln_nafas'].','.
		$termoregulasi[0].','.
		$nutrisi[0].','.
		$cairan[0].','.
		$eliminasiU[0].','.
		$eliminasiA[0].','.
		$rows['g_mobilitas'].','.
		$rows['g_integritas'].','.
		$rows['g_rawat_diri'].','.
		$psikiatrik[0].','.
		$rows['g_nyeri']
			;
		
		$sisanya=tglSQL($rows['tgl_kaji']).'|'.
		$rows['jam_kaji'].'|'.
		$rows['diantar'].'|'.
		$protase[1].'|'.
		$rows['penyakit_skg'].'|'.
		$dirawat[1].'|'.
		$dirawat[2].'|'.
		$dirawat[3].'|'.
		$rows['pengobatan'].'|'.
		$alergi[1].'|'.
		$rows['tinggi_badan'].'|'.
		$rows['berat_badan'].'|'.
		$TD[0].'|'.
		$TD[1].'|'.
		$TD[2].'|'.
		$TD[3].'|'.
		$frek_umum[0].'|'.
		$frek_umum[1].'|'.
		$BAK[0].'|'.
		$BAK[1].'|'.
		$muntah[0].'|'.
		$muntah[1].'|'.
		$muntah[2].'|'.
		$hemat[0].'|'.
		$hemat[1].'|'.
		$turgor[1].'|'.
		$edema[1].'|'.
		$BAB[1].'|'.
		$BAB[2].'|'.
		$melena[0].'|'.
		$melena[1].'|'.
		$rows['faktur'].'|'.
		$rows['jatuh'].'|'.
		$invasif[1].'|'.
		$rows['infus'].'|'.
		$plebitis[1].'|'.
		$kulit[1].'|'.
		$kulit[2].'|'.
		$kulit[3].'|'.
		$turgor_2[1].'|'.
		$endema_2[1].'|'.
		$kebiasaan[1].'|'.
		$rows['skala_nyeri'].'|'.
		tglSQL($rows['tgl_cerebral']).'|'.
		tglSQL($rows['tgl_gas']).'|'.
		tglSQL($rows['tgl_jln_nafas']).'|'.
		tglSQL($rows['tgl_termoregulasi']).'|'.
		tglSQL($rows['tgl_keb_nutrisi']).'|'.
		tglSQL($rows['tgl_vol_cairan']).'|'.
		tglSQL($rows['tgl_eliminasi_u']).'|'.
		tglSQL($rows['tgl_eliminasi_a']).'|'.
		tglSQL($rows['tgl_mobilitas']).'|'.
		tglSQL($rows['tgl_integritas']).'|'.
		tglSQL($rows['tgl_rawat_diri']).'|'.
		tglSQL($rows['tgl_psikiatrik']).'|'.
		tglSQL($rows['tgl_nyeri']);
		
		$dt.=$rows["id"].'|'.$radchk.'|'.$sisanya.chr(3).number_format($i,0,",","").chr(3).$rows["no_rm"].chr(3).tglSQL($rows["tgl_terima"]).chr(3).$rows["jam_terima"].chr(3).$rows["diagnosis"].chr(3).tglSQL($rows["tgl_act"]).chr(3).$rows["nama_usr"].chr(6);
	}
	
	if ($dt!=$totpage.chr(5)){
		$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
		$dt=str_replace('"','\"',$dt);
	}
	mysql_free_result($rs);

mysql_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
echo $dt;
?>
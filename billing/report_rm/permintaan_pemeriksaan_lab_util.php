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
	
	$sql="SELECT b.*,bmp.nama,bmp.no_rm,pp.nama AS nama_usr FROM b_form_pemeriksaan_lab b
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
	
	$isi='';
		
	while ($rows=mysql_fetch_array($rs)){
		$i++;
		$isi=explode('|',$rows['isi']);		

		$chk=$isi[0].','.$isi[1].','.$isi[2].','.$isi[3].','.$isi[4].','.$isi[5].','.$isi[6].','.$isi[7].','.$isi[8].','.$isi[9].','.$isi[10].','.
		$isi[11].','.$isi[12].','.$isi[13].','.$isi[14].','.$isi[15].','.$isi[16].','.$isi[17].','.$isi[18].','.$isi[19].','.$isi[20].','.
		$isi[21].','.$isi[22].','.$isi[23].','.$isi[24].','.$isi[25].','.$isi[26].','.$isi[27].','.$isi[28].','.$isi[29].','.$isi[30].','.
		$isi[31].','.$isi[32].','.$isi[33].','.$isi[34].','.$isi[35].','.$isi[36].','.$isi[37].','.$isi[38].','.$isi[39].','.$isi[40].','.
		$isi[41].','.$isi[42].','.$isi[43].','.$isi[44].','.$isi[45].','.$isi[46].','.$isi[47].','.$isi[48].','.$isi[49].','.$isi[50].','.
		$isi[51].','.$isi[52].','.$isi[53].','.$isi[54].','.$isi[55].','.$isi[56].','.$isi[57].','.$isi[58].','.$isi[59].','.$isi[60].','.
		$isi[61].','.$isi[62].','.$isi[63].','.$isi[64].','.$isi[65].','.$isi[66].','.$isi[67].','.$isi[68].','.$isi[69].','.$isi[70].','.
		$isi[71].','.$isi[72].','.$isi[73].','.$isi[74].','.$isi[75].','.$isi[76].','.$isi[77].','.$isi[78].','.$isi[79].','.$isi[80].','.
		$isi[81].','.$isi[82].','.$isi[83].','.$isi[84].','.$isi[85].','.$isi[86].','.$isi[87].','.$isi[88].','.$isi[89].','.$isi[90].','.
		$isi[91].','.$isi[92].','.$isi[93].','.$isi[94].','.$isi[95].','.$isi[96].','.$isi[97].','.$isi[98].','.$isi[99].','.$isi[100].','.
		$isi[101].','.$isi[102].','.$isi[103].','.$isi[104].','.$isi[105].','.$isi[106].','.$isi[107].','.$isi[108].','.$isi[109].','.$isi[110].','.
		$isi[111].','.$isi[112].','.$isi[113].','.$isi[114].','.$isi[115].','.$isi[116].','.$isi[117].','.$isi[118].','.$isi[119].','.$isi[120].','.
		$isi[121].','.$isi[122].','.$isi[123].','.$isi[124].','.$isi[125].','.$isi[126].','.$isi[127].','.$isi[128].','.$isi[129].','.$isi[130].','.
		$isi[131].','.$isi[132].','.$isi[133].','.$isi[134].','.$isi[135].','.$isi[136].','.$isi[137].','.$isi[138].','.$isi[139].','.$isi[140].','.
		$isi[141].','.$isi[142].','.$isi[143].','.$isi[144].','.$isi[145].','.$isi[146].','.$isi[147].','.$isi[148].','.$isi[149].','.$isi[150].','.
		$isi[151].','.$isi[152].','.$isi[153].','.$isi[154].','.$isi[155].','.$isi[156].','.$isi[157].','.$isi[158].','.$isi[159].','.$isi[160].','.
		$isi[161].','.$isi[162].','.$isi[163].','.$isi[164].','.$isi[165].','.$isi[166].','.$isi[167].','.$isi[168].','.$isi[169].','.$isi[170].','.
		$isi[171].','.$isi[172].','.$isi[173].','.$isi[174].','.$isi[175].','.$isi[176].','.$isi[177].','.$isi[178].','.$isi[179].','.$isi[180].','.
		$isi[181].','.$isi[182].','.$isi[183].','.$isi[184].','.$isi[185].','.$isi[186];
		
		$sisanya= $rows['no_formulir'];
		
		$dt.=$rows["id"].'|'.$sisanya.'|'.$chk.chr(3).number_format($i,0,",","").chr(3).$rows["no_rm"].chr(3).$rows["no_formulir"].chr(3).tglSQL($rows["tgl_terima"]).chr(3).$rows["jam_terima"].chr(3).tglSQL($rows["tgl_act"]).chr(3).$rows["nama_usr"].chr(6);
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
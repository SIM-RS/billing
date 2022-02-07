<?php
include("../../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$unit=$_REQUEST['unit'];
$defaultsort="luka_id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$idUser=$_REQUEST['idUser'];
	$idPasien=$_REQUEST['idPasien'];
	$riwayat_alergi=$_REQUEST['riwayat_alergi']; 
	$luka1=$_REQUEST['luka1'];
	$lukaisi=$_REQUEST['lukaisi']; 
	$luka2=$_REQUEST['luka2'];
	$etio=$_REQUEST['etio'];
	$etioisi=$_REQUEST['etioisi']; 
	$klinis=$_REQUEST['klinis'];
	$klinisisi=$_REQUEST['klinisisi'];
	$kulit=$_REQUEST['kulit'];
	$kulitisi=$_REQUEST['kulitisi']; 
	$nyeri=$_REQUEST['nyeri']; 
	$nyeriisi=$_REQUEST['nyeriisi']; 
	$eksudat=$_REQUEST['eksudat']; 
	$tipeeksudat=$_REQUEST['tipeeksudat'];
	$tipeeksudatisi=$_REQUEST['tipeeksudatisi']; 
	$bau=$_REQUEST['bau'];
	$lab=$_REQUEST['lab'];
	$tgllab=$_REQUEST['tgllab'];
	 $z=explode("-",$tgllab);
	$tgllab=$z[2]."-".$z[1]."-".$z[0];
	$hasillab=$_REQUEST['hasillab']; 
	$penanganan=$_REQUEST['penanganan']; 
	$analgesik=$_REQUEST['analgesik'];
	$tindakan=$_REQUEST['tindakan'];
	$braden=$_REQUEST['braden']; 
	$stadium=$_REQUEST['stadium']; 
	$persepsi=$_REQUEST['persepsi']; 
	$mobilitas=$_REQUEST['mobilitas']; 
	$kelembaban=$_REQUEST['kelembaban']; 
	$nutrisi=$_REQUEST['nutrisi'];
	$aktifitas=$_REQUEST['aktifitas']; 
	$gesekan=$_REQUEST['gesekan'];
	$posisi=$_REQUEST['posisi'];
	$posisiisi=$_REQUEST['posisiisi']; 
	$beritahu=$_REQUEST['beritahu'];
	$hubungi=$_REQUEST['hubungi'];
	$kajian=$_REQUEST['kajian'];
	$deskripsi=$_REQUEST['deskripsi']; 
	$gauze=$_REQUEST['gauze'];
	$film=$_REQUEST['film'];
	$tullegrass=$_REQUEST['tullegrass']; 
	$hydrogel=$_REQUEST['hydrogel'];
	$silver=$_REQUEST['silver'];
	$hidrocoloid=$_REQUEST['hidrocoloid']; 
	$hidrofiber=$_REQUEST['hidrofiber'];
	$alginate=$_REQUEST['alginate'];
	$foam=$_REQUEST['foam']; 
	$lain1=$_REQUEST['lain1']; 
	$dressingisi=$_REQUEST['dressingisi'];
	$dressingisi2=$_REQUEST['dressingisi2']; 
	$sacrum=$_REQUEST['sacrum'];
	$throchanter=$_REQUEST['throchanter']; 
	$auriculas=$_REQUEST['auriculas'];
	$heeld=$_REQUEST['heeld']; 
	$throchaler=$_REQUEST['throchaler']; 
	$malelolusd=$_REQUEST['malelolusd'];
	$heels=$_REQUEST['heels'];
	$throchaterd=$_REQUEST['throchaterd']; 
	$maleoluss=$_REQUEST['maleoluss'];
	$occipitalis=$_REQUEST['occipitalis']; 
	$throchaters=$_REQUEST['throchaters']; 
	$lain2=$_REQUEST['lain2'];
	$dekubitusisi=$_REQUEST['dekubitusisi']; 
	$auriculad=$_REQUEST['auriculad']; 
	$mastatis=$_REQUEST['mastatis'];
	$madinamik=$_REQUEST['madinamik']; 
	$bantal=$_REQUEST['bantal']; 
	$lain3=$_REQUEST['lain3']; 
	$penunjangisi=$_REQUEST['penunjangisi']; 
	$albumin=$_REQUEST['albumin']; 
	$hb=$_REQUEST['hb'];
	$suhu=$_REQUEST['suhu']; 
	$td=$_REQUEST['td'];
	$lain4=$_REQUEST['lain4'];
	$hslpemeriksaanisi=$_REQUEST['hslpemeriksaanisi'];
	$ttperawat=$_REQUEST['ttperawat'];
	$ttkepala=$_REQUEST['ttkepala'];
	
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		$sqlTambah="INSERT INTO lbr_pngkajian_luka 
(kunjungan_id, pelayanan_id, tgl_act, user_act, riwayat_alergi, luka1, lukaisi, luka2, etio, etioisi, klinis, klinisisi, kulit, kulitisi, nyeri, nyeriisi, eksudat, tipeeksudat, tipeeksudatisi, bau, lab, tgllab, hasillab, penanganan, analgesik, tindakan, braden, stadium, persepsi, mobilitas, kelembaban, nutrisi, aktifitas, gesekan, posisi, posisiisi, beritahu, hubungi, kajian, deskripsi, gauze, film, tullegrass, hydrogel, silver, hidrocoloid, hidrofiber, alginate, foam, lain1, dressingisi, dressingisi2, sacrum, throchanter, auriculas, heeld, throchaler, malelolusd, heels, throchaterd, maleoluss, occipitalis, throchaters, lain2, dekubitusisi, auriculad, mastatis, madinamik, bantal, lain3, penunjangisi, albumin, hb, suhu, td, lain4, hslpemeriksaanisi, ttperawat, ttkepala) 
VALUES 
('$idKunj', '$idPel', CURDATE(), '$idUser', '$riwayat_alergi', '$luka1', '$lukaisi', '$luka2', '$etio', '$etioisi', '$klinis', '$klinisisi', '$kulit', '$kulitisi', '$nyeri', '$nyeriisi', '$eksudat', '$tipeeksudat', '$tipeeksudatisi', '$bau', '$lab', '$tgllab', '$hasillab', '$penanganan', '$analgesik', '$tindakan', '$braden', '$stadium', '$persepsi', '$mobilitas', '$kelembaban', '$nutrisi', '$aktifitas', '$gesekan', '$posisi', '$posisiisi', '$beritahu', '$hubungi', '$kajian', '$deskripsi', '$gauze', '$film', '$tullegrass', '$hydrogel', '$silver', '$hidrocoloid', '$hidrofiber', '$alginate', '$foam', '$lain1', '$dressingisi', '$dressingisi2', '$sacrum', '$throchanter', '$auriculas', '$heeld', '$throchaler', '$malelolusd', '$heels', '$throchaterd', '$maleoluss', '$occipitalis', '$throchaters', '$lain2', '$dekubitusisi', '$auriculad', '$mastatis', '$madinamik', '$bantal', '$lain3', '$penunjangisi', '$albumin', '$hb', '$suhu', '$td', '$lain4', '$hslpemeriksaanisi', '$ttperawat', '$ttkepala')";
		//echo $sqlTambah;
		$rs=mysql_query($sqlTambah);
		break;
	case 'hapus':
		$sqlHapus="delete from lbr_pngkajian_luka where luka_id='".$_REQUEST['txtId']."'";
		mysql_query($sqlHapus);
		break;
	case 'edit':
		$sqlSimpan="update lbr_pngkajian_luka set
kunjungan_id='$idKunj', 
pelayanan_id='$idPel',  
tgl_act=CURDATE(), 
user_act='$idUser',
riwayat_alergi='$riwayat_alergi', 
luka1='$luka1', 
lukaisi='$lukaisi', 
luka2='$luka2', 
etio='$etio', 
etioisi='$etioisi', 
klinis='$klinis', 
klinisisi='$klinisisi', 
kulit='$kulit', 
kulitisi='$kulitisi', 
nyeri='$nyeri', 
nyeriisi='$nyeriisi', 
eksudat='$eksudat', 
tipeeksudat='$tipeeksudat',
tipeeksudatisi='$tipeeksudatisi', 
bau='$bau', 
lab='$lab', 
tgllab='$tgllab', 
hasillab='$hasillab', 
penanganan='$penanganan', 
analgesik='$analgesik', 
tindakan='$tindakan', 
braden='$braden', 
stadium='$stadium', 
persepsi='$persepsi', 
mobilitas='$mobilitas', 
kelembaban='$kelembaban', 
nutrisi='$nutrisi', 
aktifitas='$aktifitas', 
gesekan='$gesekan', 
posisi='$posisi', 
posisiisi='$posisiisi', 
beritahu='$beritahu', 
hubungi='$hubungi', 
kajian='$kajian', 
deskripsi='$deskripsi', 
gauze='$gauze', 
film='$film', 
tullegrass='$tullegrass', 
hydrogel='$hydrogel', 
silver='$silver', 
hidrocoloid='$hidrocoloid', 
hidrofiber='$hidrofiber', 
alginate='$alginate', 
foam='$foam', 
lain1='$lain1', 
dressingisi='$dressingisi', 
dressingisi2='$dressingisi2', 
sacrum='$sacrum', 
throchanter='$throchanter', 
auriculas='$auriculas', 
heeld='$heeld', 
throchaler='$throchaler', 
malelolusd='$malelolusd', 
heels='$heels', 
throchaterd='$throchaterd', 
maleoluss='$maleoluss', 
occipitalis='$occipitalis', 
throchaters='$throchaters', 
lain2='$lain2', 
dekubitusisi='$dekubitusisi', 
auriculad='$auriculad', 
mastatis='$mastatis', 
madinamik='$madinamik', 
bantal='$bantal', 
lain3='$lain3', 
penunjangisi='$penunjangisi', 
albumin='$albumin', 
hb='$hb', 
suhu='$suhu', 
td='$td', 
lain4='$lain4', 
hslpemeriksaanisi='$hslpemeriksaanisi',
ttperawat='$ttperawat', 
ttkepala='$ttkepala'
where luka_id='".$_REQUEST['txtId']."'";
//echo $sqlSimpan;
		$rs=mysql_query($sqlSimpan);
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

if($grd == "true")
{	
	$sql="SELECT DISTINCT 
  z.*,
  DATE_FORMAT(z.tgllab, '%d-%m-%Y') tgl_lab
FROM
lbr_pngkajian_luka z
WHERE z.kunjungan_id='$idKunj' AND z.pelayanan_id='$idPel' $filter GROUP BY luka_id order by ".$sorting;
	
}


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

$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);
$info=array(1=>'dengan kacamata',2=>'tanpa kacamata',0=>'-');

if($grd == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$sisipan=$rows["luka_id"]."|".$rows["luka1"]."|".$rows["luka2"]."|".$rows["etio"]."|".$rows["klinis"]."|".$rows["kulit"]."|".$rows["nyeri"]."|".$rows["eksudat"]."|".$rows["tipeeksudat"]."|".$rows["bau"]."|".$rows["lab"]."|".$rows["analgesik"]."|".$rows["braden"]."|".$rows["stadium"]."|".$rows["persepsi"]."|".$rows["mobilitas"]."|".$rows["kelembaban"]."|".$rows["nutrisi"]."|".$rows["aktifitas"]."|".$rows["gesekan"]."|".$rows["posisi"]."|".$rows["beritahu"]."|".$rows["hubungi"]."|".$rows["kajian"]."|".$rows["penanganan"]."|".$rows["tindakan"]."|".$rows["tgl_lab"]."|".$rows["dressingisi"]."|".$rows["dekubitusisi"]."|".$rows["penunjangisi"]."|".$rows["hslpemeriksaanisi"]."|".$rows["gauze"]."|".$rows["film"]."|".$rows["tullegrass"]."|".$rows["hydrogel"]."|".$rows["silver"]."|".$rows["hidrocoloid"]."|".$rows["hidrofiber"]."|".$rows["alginate"]."|".$rows["foam"]."|".$rows["lain1"]."|".$rows["sacrum"]."|".$rows["throchanter"]."|".$rows["auriculas"]."|".$rows["heeld"]."|".$rows["throchaler"]."|".$rows["malelolusd"]."|".$rows["heels"]."|".$rows["throchaterd"]."|".$rows["maleoluss"]."|".$rows["occipitalis"]."|".$rows["throchaters"]."|".$rows["lain2"]."|".$rows["auriculad"]."|".$rows["mastatis"]."|".$rows["madinamik"]."|".$rows["bantal"]."|".$rows["lain3"]."|".$rows["albumin"]."|".$rows["hb"]."|".$rows["suhu"]."|".$rows["td"]."|".$rows["lain4"]."|".$rows["riwayat_alergi"]."|".$rows["lukaisi"]."|".$rows["etioisi"]."|".$rows["klinisisi"]."|".$rows["kulitisi"]."|".$rows["nyeriisi"]."|".$rows["tipeeksudatisi"]."|".$rows["hasillab"]."|".$rows["posisiisi"]."|".$rows["dressingisi2"]."|".$rows["ttperawat"]."|".$rows["ttkepala"];
		$dt.=$sisipan.chr(3).number_format($i,0,",","").chr(3).$rows["riwayat_alergi"].chr(3).$rows["deskripsi"].chr(6);
	}
}

if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1);
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
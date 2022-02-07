<?php
include('../../koneksi/konek.php');

$act = $_REQUEST['act'];
$id = $_REQUEST['idx'];

$id_kunjungan = $_REQUEST['id_kunjungan'];
$id_pelayanan = $_REQUEST['id_pelayanan'];

$tgl_rawat = tglSQL($_REQUEST['tgl_rawat']);
$tgl_pindah = tglSQL($_REQUEST['tgl_pindah']);

$dokter1 = $_REQUEST['dokter1'];
$dokter2 = $_REQUEST['dokter2'];

$indikasi = $_REQUEST['indikasi'];
$kesadaran = $_REQUEST['kesadaran'];

$diagnosa = $_REQUEST['diagnosa'];
$tekanan = $_REQUEST['tekanan'];
$pernafasan = $_REQUEST['pernafasan'];
$nadi = $_REQUEST['nadi'];
$suhu = $_REQUEST['suhu'];
$berat_badan = $_REQUEST['berat_badan'];
$tinggi_badan = $_REQUEST['tinggi_badan'];

//===alat bantu===//
$alat0 = $_REQUEST['alat0'];
$alat1 = $_REQUEST['alat1'];
$alat2 = $_REQUEST['alat2'];
$alat3 = $_REQUEST['alat3'];
$alat4 = $_REQUEST['alat4'];
$alat5 = $_REQUEST['alat5'];
$alat_bantu = "$alat0,$alat1,$alat2,$alat3,$alat4,$alat5";
$alat_bantu_ket = $_REQUEST['alat_bantu_ket'];
//================//
$tindakan_operasi = $_REQUEST['tindakan_operasi'];

//===Kemampuan Mobilisasi===//
$kemampuan0 = $_REQUEST['kemampuan0'];
$kemampuan1 = $_REQUEST['kemampuan1'];
$kemampuan2 = $_REQUEST['kemampuan2'];
$kemampuan3 = $_REQUEST['kemampuan3'];
$kemampuan = "$kemampuan0,$kemampuan1,$kemampuan2,$kemampuan3";
$kemampuan_ket = $_REQUEST['kemampuan_ket'];

//===Tingkat Ketergantungan===//
$tingkat0 = $_REQUEST['tingkat0'];
$tingkat1 = $_REQUEST['tingkat1'];
$tingkat2 = $_REQUEST['tingkat2'];
$tingkat = "$tingkat0,$tingkat1,$tingkat2";
//===============================//
$radiologi = $_REQUEST['radiologi'];

$thorax = $_REQUEST['thorax'];
$thorax_jum = $_REQUEST['thorax_jum'];

$thorax = $_REQUEST['thorax'];
$thorax_jum = $_REQUEST['thorax_jum'];

$ct = $_REQUEST['ct'];
$ct_jum = $_REQUEST['ct_jum'];

$lain = $_REQUEST['lain'];
$lain_ket = $_REQUEST['lain_ket'];

$echo = $_REQUEST['echo'];
$echo_jum = $_REQUEST['echo_jum'];

$eeg = $_REQUEST['eeg'];
$eeg_jum = $_REQUEST['eeg_jum'];

$usg = $_REQUEST['usg'];
$usg_jum = $_REQUEST['usg_jum'];

$lab = $_REQUEST['lab'];
$lab_jum = $_REQUEST['lab_jum'];
//=============================
$barang0 = $_REQUEST['barang0'];
$barang1 = $_REQUEST['barang1'];
$barang_pribadi = "$barang0,$barang1";

$tanda0 = $_REQUEST['tanda0'];
$tanda1 = $_REQUEST['tanda1'];
$tanda2 = $_REQUEST['tanda2'];
$tanda_bukti = "$tanda0,$tanda1,$tanda2";
$tanda_bukti_ket = $_REQUEST['tanda_bukti_ket'];

$perawat_terima = $_REQUEST['perawat_terima'];
$pj_shift = $_REQUEST['pj_shift'];
$perawat_serah = $_REQUEST['perawat_serah'];


if($act=='add')
{
	$q = "insert into b_form_serahterima(id_kunjungan,id_pelayanan,tgl_rawat,tgl_pindah,dokter1,dokter2,indikasi,kesadaran,diagnosa,tekanan,pernafasan,nadi,suhu,berat_badan,tinggi_badan,alat_bantu,alat_bantu_ket,tindakan_operasi,kemampuan,kemampuan_ket,tingkat,radiologi,thorax,thorax_jum,ct,ct_jum,lain,lain_ket,echo,echo_jum,eeg,eeg_jum,usg,usg_jum,lab,lab_jum,barang_pribadi,tanda_bukti,tanda_bukti_ket,perawat_terima,pj_shift,perawat_serah)values('$id_kunjungan','$id_pelayanan','$tgl_rawat','$tgl_pindah','$dokter1','$dokter2','$indikasi','$kesadaran','$diagnosa','$tekanan','$pernafasan','$nadi','$suhu','$berat_badan','$tinggi_badan','$alat_bantu','$alat_bantu_ket','$tindakan_operasi','$kemampuan','$kemampuan_ket','$tingkat','$radiologi','$thorax','$thorax_jum','$ct','$ct_jum','$lain','$lain_ket','$echo','$echo_jum','$eeg','$eeg_jum','$usg','$usg_jum','$lab','$lab_jum','$barang_pribadi','$tanda_bukti','$tanda_bukti_ket','$perawat_terima','$pj_shift','$perawat_serah')";
	mysql_query($q);
	
	
	
	$qq = "select id from b_form_serahterima order by id desc limit 1";
	$dd = mysql_fetch_array(mysql_query($qq));
	$id_serahterima = $dd['id'];
	
	//============================================== insert tabel dinamis 1 ============================
	$nama_obat = $_REQUEST['nama_obat'];
	$dosis = $_REQUEST['dosis'];
	$jumlah = $_REQUEST['jumlah'];
	$obat_sisa = $_REQUEST['obat_sisa'];
	$tot = count($nama_obat);
	for($i=0;$i<$tot;$i++)
	{
		$q1 = "insert into b_form_serahterima_obat(id_serahterima,nama_obat,dosis,jumlah,obat_sisa)values('$id_serahterima','$nama_obat[$i]','$dosis[$i]','$jumlah[$i]','$obat_sisa[$i]')";
		mysql_query($q1);
	}
	
	//============================================== insert tabel dinamis 2 ============================
	$pesanan = $_REQUEST['pesanan'];
	$keterangan = $_REQUEST['keterangan'];
	$instruksi = $_REQUEST['instruksi'];
	$tot2 = count($pesanan);
	for($j=0;$j<$tot2;$j++)
	{
		$q2 = "insert into b_form_serahterima_catatan(id_serahterima,pesanan,keterangan,instruksi)values('$id_serahterima','$pesanan[$j]','$keterangan[$j]','$instruksi[$j]')";
		mysql_query($q2);
	}

}
else if($act=='edit')
{
	$q = "update b_form_serahterima set 
	id_kunjungan='$id_kunjungan',
	id_pelayanan='$id_pelayanan',
	tgl_rawat='$tgl_rawat',
	tgl_pindah='$tgl_pindah',
	dokter1='$dokter1',
	dokter2='$dokter2',
	indikasi='$indikasi',
	kesadaran='$kesadaran',
	diagnosa='$diagnosa',
	tekanan='$tekanan',
	pernafasan='$pernafasan',
	nadi='$nadi',
	suhu='$suhu',
	berat_badan='$berat_badan',
	tinggi_badan='$tinggi_badan',
	alat_bantu='$alat_bantu',
	alat_bantu_ket='$alat_bantu_ket',
	tindakan_operasi='$tindakan_operasi',
	kemampuan='$kemampuan',
	kemampuan_ket='$kemampuan_ket',
	tingkat='$tingkat',
	radiologi='$radiologi',
	thorax='$thorax',
	thorax_jum='$thorax_jum',
	ct='$ct',
	ct_jum='$ct_jum',
	lain='$lain',
	lain_ket='$lain_ket',
	echo='$echo',
	echo_jum='$echo_jum',
	eeg='$eeg',
	eeg_jum='$eeg_jum',
	usg='$usg',
	usg_jum='$usg_jum',
	lab='$lab',
	lab_jum='$lab_jum',
	barang_pribadi='$barang_pribadi',
	tanda_bukti='$tanda_bukti',
	tanda_bukti_ket='$tanda_bukti_ket',
	perawat_terima='$perawat_terima',
	pj_shift='$pj_shift',
	perawat_serah='$perawat_serah' where id = '$id'";
	
	//============================================== update/insert tabel dinamis 1 ============================
	$id1 = $_REQUEST['id1'];
	$nama_obat = $_REQUEST['nama_obat'];
	$dosis = $_REQUEST['dosis'];
	$jumlah = $_REQUEST['jumlah'];
	$obat_sisa = $_REQUEST['obat_sisa'];
	
	$tot = count($nama_obat);
	for($i=0;$i<$tot;$i++)
	{
		if($id1[$i]!="")
		{
			$q1 = "update b_form_serahterima_obat set nama_obat='$nama_obat[$i]',dosis='$dosis[$i]',jumlah='$jumlah[$i],obat_sisa='$obat_sisa[$i]' where id='$id1[$i]'";
		}
		else
		{
			$q1 = "insert into b_form_serahterima_obat(id_serahterima,nama_obat,dosis,jumlah,obat_sisa)values('$id_serahterima','$nama_obat[$i]','$dosis[$i]','$jumlah[$i]','$obat_sisa[$i]')";
		}
		mysql_query($q1);
	}
	
	if(isset($_REQUEST['list_hapus']))
	{
		$list1 = $_REQUEST['list_hapus'];
		$aa = explode(",",$list1);
		$jum_aa = count($aa);
		for($x=1;$x<$jum_aa;$x++)
		{
			mysql_query("delete from b_form_serahterima_obat where id='$aa[$x]'");
		}
	}
	
	//============================================== update/insert tabel dinamis 2 ============================
	$id2 = $_REQUEST['id2'];
	$pesanan = $_REQUEST['pesanan'];
	$keterangan = $_REQUEST['keterangan'];
	$instruksi = $_REQUEST['instruksi'];
	$tot2 = count($pesanan);
	for($j=0;$j<$tot2;$j++)
	{
		if($id2[$i]!="")
		{
			$q2 = "update b_form_serahterima_catatan set pesanan='$pesanan[$j]',keterangan='$keterangan[$j]',instruksi='$instruksi[$j]' where id = '$id2[$j]'";
		}
		else
		{
			$q2 = "insert into b_form_serahterima_catatan(id_serahterima,pesanan,keterangan,instruksi)values('$id_serahterima','$pesanan[$j]','$keterangan[$j]','$instruksi[$j]')";
		}
		mysql_query($q2);
	}
	if(isset($_REQUEST['list_hapus2']))
	{
		$list2 = $_REQUEST['list_hapus2'];
		$bb = explode(",",$list2);
		$jum_bb = count($bb);
		for($y=1;$y<$jum_bb;$y++)
		{
			mysql_query("delete from b_form_serahterima_catatan where id='$bb[$y]'");
		}
	}
}
?>
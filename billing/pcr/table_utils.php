<?php 
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}

include("../koneksi/konek.php");

$grd = $_REQUEST['grd'];

// WHERE
//                 (p.nama LIKE '{$nama}%' OR p.no_rm = '{$no_rm}')

$sortDefault = "ORDER BY p.nama ASC";
$filterSql = "";
$page=$_REQUEST["page"];

if($_REQUEST['filter'] != ''){
$filter = explode('|', mysql_real_escape_string($_REQUEST['filter']));
if($filter[0] == 'p.nama') $filterSql = " WHERE {$filter[0]} LIKE '{$filter[1]}%'";
else $filterSql = " WHERE {$filter[0]} = '{$filter[1]}'";
}


switch ($grd) {
	case "getDataPasienPcr":
		$sql = "SELECT
				hp.id AS id_hasil,
				p.id AS id_pasien,
				hp.id_pelayanan,
				hp.id_kunjungan,
				hp.kategori,
				p.nama AS nama_pasien,
				p.no_rm,
				p.sex,
				p.tgl_lahir,
				p.alamat,
				hp.no_registrasi_lab,
				hp.status_cek_pcr,
				kp.kso_id
				FROM
					b_hasil_pcr hp
					INNER JOIN b_ms_pasien p ON p.id = hp.id_pasien
					LEFT JOIN b_kunjungan k ON k.id = hp.id_kunjungan
					LEFT JOIN b_pelayanan pel ON pel.id = hp.id_pelayanan
					LEFT JOIN b_ms_kso_pasien kp ON kp.pasien_id = hp.id_pasien
				".$filterSql."
				ORDER BY
					p.nama ASC";

		break;
	
	default:
		// code...
		break;
}

//paginatiaon
$query = mysql_query($sql);
$jumlahData = mysql_num_rows($query);

if($page == "" || $page == 0) $page = 1;

$totalPage = ($page - 1) * $perpage;

if($jumlahData % $perpage > 0) $totalpage = floor($jumlahData / $perpage) + 1;
else $totalpage = floor($jumlahData / $perpage);

if($page > 1) $bpage = $page - 1; else $bpage = 1;
if($page < $totalpage) $npage = $page + 1; else $npage = $totalpage;

$sql = $sql . " LIMIT $totalPage,$perpage";
$query = mysql_query($sql);
$i = ($page - 1) * $perpage;

$data = $totalpage.chr(5);

switch ($grd) {
	case "getDataPasienPcr":
		while($rows = mysql_fetch_assoc($query)){
			if($rows['status_cek_pcr'] == "" || $rows['status_cek_pcr'] == "-"){
				$no_rm = "<span style='font-weight : 500;color:red' >" . $rows['no_rm']. '</span>';
				$nama_pasien = "<span style='font-weight : 500;color:red' >" . $rows['nama_pasien']. '</span>';
				$tgl_lahir = "<span style='font-weight : 500;color:red' >" . $rows['tgl_lahir']. '</span>';
				$status_cek_pcr = "<p style='font-weight : 500;color:red'>" . $rows['status_cek_pcr'] . '</p>';
				$jenisKelamin = $rows['sex'] == 'L' ? "<span style='font-weight : 500;color:red' >Laki - laki</span>" : "<span style='font-weight : 500;color:red' >Perempuan</span>";
				$no_registrasi_lab = "<span style='font-weight : 500;color:red' >" . $rows['no_registrasi_lab']. '</span>';
				$kategori = "";
				if($rows['kategori'] == 1) $kategori = "Swab Biasa";
				else $kategori = "Swab Antigen";

			}else{
				$no_rm = $rows['no_rm'];
				$nama_pasien = $rows['nama_pasien'];
				$tgl_lahir = $rows['tgl_lahir'];
				$status_cek_pcr = $rows['status_cek_pcr'];
				$jenisKelamin = $rows['sex'] == 'L' ? 'Laki - laki' : 'Perempuan';
				$no_registrasi_lab = $rows['no_registrasi_lab'];
				$kategori = "";
				if($rows['kategori'] == 1) $kategori = "Swab Biasa";
				else $kategori = "Swab Antigen";
			}
			$i++;
			$data .= $rows['id_hasil'].'|'.$rows['id_pasien'].'|'.$rows['id_pelayanan'].'|'.$rows['id_kunjungan'].'|'.$rows['no_rm'].'|'.$rows['kso_id'].'|'.$rows['nama_pasien'].'|'.$rows['no_registrasi_lab']. chr(3) . $i . chr(3) . $no_rm . chr(3) . $nama_pasien . chr(3) . $no_registrasi_lab . chr(3) . $tgl_lahir . chr(3) . $jenisKelamin . chr(3) . $status_cek_pcr . chr(3) . $kategori . chr(6);
		}
		break;
	
	default:
		// code...
		break;
}

if ($data != $totalpage.chr(5))
{
	$data = substr($data,0,strlen($data)-1);
	$data = str_replace('"','\"',$data);
}

echo $data;

?>
<?php
include("../koneksi/konek.php");
//$userAdmin=$_SESSION['userIdAdmin'];
$id1=$_GET['id1'];
$com=$_GET['com'];
$sel=$_GET['sel'];
$kata = $_REQUEST['term'];

if($com == "txtAlat")
{	

	$sql = "SELECT mb.idbarang, mb.kodebarang, mb.namabarang, mb.idsatuan
FROM $dbcssd.cssd_ms_alat ma
LEFT JOIN $dbaset.as_ms_barang mb
ON mb.idbarang = ma.idbarang WHERE ma.tipe=0 AND TRIM(mb.namabarang) LIKE '%$kata%' order by mb.namabarang";
	//echo $sql;
	$kueri = mysql_query($sql);
	while($d=mysql_fetch_array($kueri)){
		$data[] = array(
			'label' => $d['namabarang'],
			'txtAlat' => $d['namabarang'],
			'txtAlat2' => $d['idbarang']
		);
	}
	
	if(empty($data)){
				$data[]= array(
			'label' => 'Tidak ada data',
			'txtAlat' => '',
			'txtAlat2' => ''
		);
	}
echo json_encode($data);
flush();
}

if($com == "txtLaundry")
{	

	$sql = "SELECT mb.idbarang, mb.kodebarang, mb.namabarang, mb.idsatuan
FROM $dbcssd.cssd_ms_alat ma
LEFT JOIN $dbaset.as_ms_barang mb
ON mb.idbarang = ma.idbarang WHERE ma.tipe=1 AND TRIM(mb.namabarang) LIKE '%$kata%' order by mb.namabarang";
	//echo $sql;
	$kueri = mysql_query($sql);
	while($d=mysql_fetch_array($kueri)){
		$data[] = array(
			'label' => $d['namabarang'],
			'txtAlat' => $d['namabarang'],
			'txtAlat2' => $d['idbarang']
		);
	}
	if(empty($data)){
				$data[]= array(
			'label' => 'Tidak ada data',
			'txtAlat' => '',
			'txtAlat2' => ''
		);
	}
echo json_encode($data);
flush();
}

if($com == "txtPeg")
{	

	$sql = "SELECT p.id, p.nama
FROM b_ms_pegawai p
INNER JOIN $dbcssd.cssd_job_order co
ON co.user_jo = p.id
WHERE TRIM(p.nama) like '%$kata%' 
GROUP BY co.user_jo
order by p.nama";
	$kueri = mysql_query($sql);
	while($d=mysql_fetch_array($kueri)){
		$data[] = array(
			'label' => $d['nama'],
			'NmPsh' => $d['nama'],
			'Rek_id' => $d['id']
		);
	}
echo json_encode($data);
flush();
}
?>
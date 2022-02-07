<?php 
//include("../../sesi.php");
include("../../koneksi/konek.php");

    if($_REQUEST['act']=="edit"){
		/* $qUpd = "SELECT id, nama FROM b_ms_instansi WHERE nama='".$_REQUEST['namaperusahaan']."'";
		$sUpd = mysql_query($qUpd);
		$wUpd = mysql_fetch_array($sUpd);
		if(mysql_num_rows($sUpd)>0){
			$qUpd1 = "UPDATE b_ms_instansi SET nama='".$_REQUEST['namaperusahaan']."' WHERE id='".$wUpd['id']."'";
			$sUpd1 = mysql_query($qUpd1);
			//$wUpd1 = mysql_fetch_array($sUpd1);
		}else{		
			$qUpdate = "INSERT INTO b_ms_instansi (nama) VALUES ('".$_REQUEST['namaperusahaan']."')";
			$sUpdate = mysql_query($qUpdate);
			//$wUpdate = mysql_fetch_array($sUpdate);
		} */
		
		$qUpd2 = "SELECT id, nama FROM b_ms_instansi WHERE id='".$_REQUEST['namaperusahaan']."'";
		$sUpd2 = mysql_query($qUpd2);
		$wUpd2 = mysql_fetch_array($sUpd2); 
		
		$qUpd3 = "UPDATE b_ms_kso_pasien SET instansi_id='".$wUpd2['id']."', nama_peserta='".$_REQUEST['namapeserta']."', no_anggota='".$_REQUEST['nopeserta']."' WHERE pasien_id='".$_REQUEST['pasienId']."'";
		$sUpd3 = mysql_query($qUpd3);
		//$wUpd3 = mysql_fetch_array($sUpd3);
        echo $_REQUEST['nopeserta']."||".$wUpd2['nama']."||".$_REQUEST['namapeserta'];
	}else{
		$qDg = "SELECT md.id, md.nama FROM b_diagnosa_rm d
				INNER JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
				WHERE d.pelayanan_id='".$_REQUEST['pelayananId']."' ";
		$sDg = mysql_query($qDg);
		while($wDg = mysql_fetch_array($sDg)){
		echo $wDg['nama'].',';
		}
	}


?>
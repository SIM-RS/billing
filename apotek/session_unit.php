<?php
//$cid=mysqli_real_escape_string($konek,$_REQUEST["cid"]);
function getaUnit($id1,$f1){
global $konek;
	$f = mysqli_real_escape_string($konek,$f1);
	$id = mysqli_real_escape_string($konek,$id1);
	$s="select $f from a_unit where UNIT_ID='".$id."'";
	$q=mysqli_query($konek,$s);
	$w=mysqli_fetch_array($q);
	return $w[$f];
}

function cekAccessUnit($u_tipe,$u_user){
global $konek;
	$ret=true;
	$q=getSessionUnit($u_tipe,$u_user,'count');
	if($q==0){
		$ret=false;
	}
	return $ret;
}

function getNUnit($u_tipe,$u_user){
global $konek;
	$q=getSessionUnit($u_tipe,$u_user,'count');
	return $q;
}


function getSessionUnit($u_tipe1,$u_user1,$var1){
global $konek;
$u_tipe=mysqli_real_escape_string($konek,$u_tipe1);
$u_user=mysqli_real_escape_string($konek,$u_user1);
$var=mysqli_real_escape_string($konek,$var1);
	$sUnit="SELECT un.UNIT_ID,un.UNIT_NAME,un.UNIT_KODE
	FROM a_unit un
	INNER JOIN a_user_unit usn ON un.UNIT_ID=usn.unit_id 
	INNER JOIN a_user us ON usn.user_id=us.kode_user
	WHERE un.UNIT_TIPE='".$u_tipe."' AND un.UNIT_ISAKTIF=1 AND us.kode_user=$u_user AND un.UNIT_ID AND un.UNIT_ID NOT IN(8,9) 
	ORDER BY un.UNIT_NAME ASC";
	// Menambahkan Not In 8, untuk tidak menampilkan depo Apotek NOT IN (8)
	//mellydecyber
	$qUnit = mysqli_query($konek,$sUnit);
	$nUnit = mysqli_num_rows($qUnit);
	
	if ($nUnit>0){
		if($_GET['zxcvunit']==''){
			if($_SESSION["ses_idunit_temp"]!='')
			{   
				//$idunit = $_SESSION["ses_idunit_temp"];
				$idunit=mysqli_real_escape_string($konek,$_SESSION["ses_idunit_temp"]);
				//$namaunit = getaUnit($idunit,'UNIT_NAME');
				$namaunit=mysqli_real_escape_string($konek,getaUnit($idunit,'UNIT_NAME'));
				//$kodeunit = getaUnit($idunit,'UNIT_KODE');
				$kodeunit=mysqli_real_escape_string($konek,getaUnit($idunit,'UNIT_KODE'));
			}
			else
			{
				$sUnit1 = $sUnit." LIMIT 1";
				$qUnit1 = mysqli_query($konek,$sUnit1);
				$rwUnit1 = mysqli_fetch_array($qUnit1);
				$_SESSION["ses_idunit_temp"] = $rwUnit1['UNIT_ID'];
				
				//$idunit = $_SESSION["ses_idunit_temp"];
				$idunit=mysqli_real_escape_string($konek,$_SESSION["ses_idunit_temp"]);
				//$namaunit = getaUnit($idunit,'UNIT_NAME');
				$namaunit=mysqli_real_escape_string($konek,getaUnit($idunit,'UNIT_NAME'));
				//$kodeunit = getaUnit($idunit,'UNIT_KODE');
				$kodeunit=mysqli_real_escape_string($konek,getaUnit($idunit,'UNIT_KODE'));
			}
		}
		else{
			$_SESSION["ses_idunit_temp"] = $_GET['zxcvunit'];
			//$idunit = $_SESSION["ses_idunit_temp"];
			$idunit=mysqli_real_escape_string($konek,$_SESSION["ses_idunit_temp"]);
			//$namaunit = getaUnit($idunit,'UNIT_NAME');
			$namaunit=mysqli_real_escape_string($konek,getaUnit($idunit,'UNIT_NAME'));
			//$kodeunit = getaUnit($idunit,'UNIT_KODE');
			$kodeunit=mysqli_real_escape_string($konek,getaUnit($idunit,'UNIT_KODE'));
		}
	}
	
	if($var=='id') $ret=$idunit;
	else if($var=='kode') $ret=$kodeunit;
	else if($var=='combo') $ret=$qUnit;
	else if($var=='count') $ret=$nUnit;	
	else $ret=$namaunit;
	return $ret;
}


?>
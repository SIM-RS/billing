<?php
session_start();
include "../sesi.php";
include("../koneksi/konek.php");
$idKunj=$_GET['idKunj'];
$userId=$_GET['userId'];
$sqlKunj="SELECT k.kso_id FROM b_kunjungan k WHERE k.id='$idKunj'";
$rsKunj=mysql_query($sqlKunj);
$rwKunj=mysql_fetch_array($rsKunj);
if($rwKunj['kso_id']=='38' || $rwKunj['kso_id']=='39' || $rwKunj['kso_id']=='46' || $rwKunj['kso_id']=='53' || $rwKunj['kso_id']=='64'){
	$jdlSKP="SKP JAMKESDA INAP";
	$cpar="kamar";
	if ($rwKunj['kso_id']=='53'){
		$jdlSKP="SKP JAMPERSAL";
		$cpar="jampersal";
	}
    $sqlUser="SELECT p.nama,pu.unit_id FROM b_ms_pegawai p
            INNER JOIN b_ms_pegawai_unit pu ON p.id=pu.ms_pegawai_id
            WHERE p.id='$userId' AND pu.unit_id=108";
    $rsUser=mysql_query($sqlUser);
    if(mysql_num_rows($rsUser)>0){
        ?>
        <input id="skpJamkesdaKmr" name="skpJamkesdaKmr" type="button" value="<?php echo $jdlSKP; ?>" onClick="skp('<?php echo $idKunj;?>','<?php echo $cpar; ?>')" />
        <?php
    }
}
?>
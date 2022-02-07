<?php
include("../koneksi/konek.php");
$idtr=$_REQUEST['idtr'];
$newMAId=$_REQUEST['newMAId'];
$IdCCRVKSOPBF=$_REQUEST['IdCCRVKSOPBF'];

$dt="";
//============action====================
$nma='';
$kdma='';

$sql="UPDATE jurnal_sem SET FK_SAK=$newMAId,CC_RV_KSO_PBF_UMUM_ID=$IdCCRVKSOPBF WHERE TR_ID=$idtr";
$rs=mysql_query($sql);
if (mysql_errno()<=0){
	$sql="SELECT * FROM ma_sak WHERE MA_ID=$newMAId";
	$rs1=mysql_query($sql);
	$rw1=mysql_fetch_array($rs1);
	$kdma=$rw1['MA_KODE'];
	$nma=$rw1['MA_NAMA'];
	$jenisMA=$rw1['CC_RV_KSO_PBF_UMUM'];
	
	$nCCRVKSOPBF='';
	$kdCCRVKSOPBF='';
	if ($IdCCRVKSOPBF>0){
		switch ($jenisMA){
			case 1:
				$sql="SELECT * FROM ak_ms_unit WHERE id=$IdCCRVKSOPBF";
				$rs1=mysql_query($sql);
				$rw1=mysql_fetch_array($rs1);
				$nCCRVKSOPBF=$rw1['nama'];
				$kdCCRVKSOPBF=$rw1['kode'];
				break;
			case 2:
				$sql="SELECT * FROM $dbbilling.b_ms_kso WHERE id=$IdCCRVKSOPBF";
				$rs1=mysql_query($sql);
				$rw1=mysql_fetch_array($rs1);
				$nCCRVKSOPBF=$rw1['nama'];
				$kdCCRVKSOPBF=$rw1['kode_ak'];
				break;
			case 3:
				$sql="SELECT * FROM $dbapotek.a_pbf WHERE PBF_ID=$IdCCRVKSOPBF";
				$rs1=mysql_query($sql);
				$rw1=mysql_fetch_array($rs1);
				$nCCRVKSOPBF=$rw1['PBF_NAMA'];
				$kdCCRVKSOPBF=$rw1['PBF_KODE_AK'];
				break;
			case 4:
				$sql="SELECT * FROM $dbaset.as_ms_rekanan WHERE idrekanan=$IdCCRVKSOPBF";
				$rs1=mysql_query($sql);
				$rw1=mysql_fetch_array($rs1);
				$nCCRVKSOPBF=$rw1['namarekanan'];
				$kdCCRVKSOPBF=$rw1['koderekanan'];
				break;
		}
	}
	$dt=$kdma.$kdCCRVKSOPBF."|".$nma." - ".$nCCRVKSOPBF;
}
mysql_close($konek);
echo $dt;
?>
<?php
include("../koneksi/konek.php");
$diagnosa_id=$_REQUEST['id_diagnosa_ICD_RM'];
$ms_diagnosa_id=$_REQUEST['ms_diagnosa_ICD_RM'];
$kasus_baru=$_REQUEST['kasus_baru'];
$user_act=$_REQUEST['user_act'];
$txtCatatan=$_REQUEST['txtCatatan'];

switch(strtolower($_REQUEST['act'])) {
	case 'updateicdxrm':
		$sCek="select * from b_diagnosa_rm where diagnosa_id='".$diagnosa_id."'";
		$qCek=mysql_query($sCek);
		
		if(mysql_num_rows($qCek)==0){
			$sIns="insert into b_diagnosa_rm(diagnosa_id,ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,tgl_act,user_act)
			select diagnosa_id,$ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,now(),$user_act from b_diagnosa where diagnosa_id='".$diagnosa_id."'";
			mysql_query($sIns);
			if(mysql_affected_rows()>0){
				$res="ok";	
			}
			else{
				$res="error";
			}	
		}
		else{
			$sId="select id from b_diagnosa_rm where diagnosa_id='".$diagnosa_id."'";
			$qId=mysql_query($sId);
			$rwId=mysql_fetch_array($qId);
			$diagnosa_rm_id=$rwId['id'];
			
			$sInsert="insert into b_diagnosa_rm_act(diagnosa_rm_id,catatan,tgl_act,user_act) values ('$diagnosa_rm_id','$txtCatatan',NOW(),'$user_act')";
			mysql_query($sInsert);
			
			$sUp="update b_diagnosa_rm set ms_diagnosa_id=$ms_diagnosa_id where diagnosa_id='".$diagnosa_id."'";
			mysql_query($sUp);
			if(mysql_affected_rows()>0){
				$res="ok";	
			}
			else{
				$res="error";	
			}
			
		}
		
		echo $res;
		return;
		
		break;
	case 'updateicd9cm':
		$sCek="select * from b_tindakan_icd9cm where b_tindakan_id='".$diagnosa_id."'";
		$qCek=mysql_query($sCek);
		
		if(mysql_num_rows($qCek)==0){
			$sIns="insert into b_tindakan_icd9cm(b_tindakan_id,kode_icd_9cm,user_act,tgl_act)
			values('".$diagnosa_id."','$ms_diagnosa_id','$user_act',NOW())";
			//echo $sIns."<br>";
			mysql_query($sIns);
			if(mysql_affected_rows()>0){
				$res="ok";	
			}
			else{
				$res="error";	
			}	
		}
		else{
			$sId="select id from b_tindakan_icd9cm where b_tindakan_id='".$diagnosa_id."'";
			$qId=mysql_query($sId);
			$rwId=mysql_fetch_array($qId);
			$tindakan_icd9cm_id=$rwId['id'];
			
			$sInsert="insert into b_tindakan_icd9cm_act (tindakan_icd9cm_id,catatan,tgl_act,user_act) values ('$tindakan_icd9cm_id','$txtCatatan',NOW(),'$user_act')";
			mysql_query($sInsert);
			
			$sUp="update b_tindakan_icd9cm set kode_icd_9cm='$ms_diagnosa_id',user_act='$user_act',tgl_act=NOW() where b_tindakan_id='".$diagnosa_id."'";
			//echo $sUp."<br>";
			mysql_query($sUp);
			if(mysql_affected_rows()>0){
				$res="ok";	
			}
			else{
				$res="error";	
			}
		}
		
		echo $res;
		return;
		break;
		case 'updatekasusicdxrm':
		$sCek="select * from b_diagnosa_rm where diagnosa_id='".$diagnosa_id."'";
		$qCek=mysql_query($sCek);
		
		if(mysql_num_rows($qCek)==0){
			$sIns="insert into b_diagnosa_rm(diagnosa_id,ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,tgl_act,user_act)
			select diagnosa_id,ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,'$kasus_baru',now(),$user_act from b_diagnosa where diagnosa_id='".$diagnosa_id."'";
			mysql_query($sIns);
			if(mysql_affected_rows()>0){
				$res="ok";	
			}
			else{
				$res="error";
			}	
		}
		else{
			$sUp="update b_diagnosa_rm set kasus_baru=$kasus_baru where diagnosa_id='".$diagnosa_id."'";
			mysql_query($sUp);
			if(mysql_affected_rows()>0){
				$res="ok";	
			}
			else{
				$res="error";	
			}
		}
		
		echo $res;
		return;
		break;
}
?>
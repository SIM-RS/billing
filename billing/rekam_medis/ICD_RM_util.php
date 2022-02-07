<?php
include("../koneksi/konek.php");
$diagnosa_id=$_REQUEST['id_diagnosa_ICD_RM'];
$ms_diagnosa_id=$_REQUEST['ms_diagnosa_ICD_RM'];
$ms_diagnosa_id_cdgn=$_REQUEST['ms_diagnosa_ICD_RM_cdgn'];
$kasus_baru=$_REQUEST['kasus_baru'];
$user_act=$_REQUEST['user_act'];
$txtCatatan=$_REQUEST['txtCatatan'];
$fdata=$_REQUEST['fdata'];
$cek_degger=$_REQUEST['cek_degger'];
$id_degger=$_REQUEST['id_degger'];
$isinyaid=$_REQUEST['isinyaid'];
$kunjungan_id=$_REQUEST['kunjungan_id'];
$pelayanan_id=$_REQUEST['pelayanan_id'];

switch(strtolower($_REQUEST['act'])) {
	case 'updateicdxrm':
		if($diagnosa_id==0){
			$sCek="select * from b_diagnosa_rm where degger_id=0 and id='".$id_degger."'";
			// $sCek="select * from b_diagnosa where degger_id=0 and diagnosa_id='".$id_degger."'";
		}else{
			$sCek="select * from b_diagnosa_rm where degger_id=0 and diagnosa_id='".$diagnosa_id."' and kunjungan_id='".$kunjungan_id."'";
			// $sCek="select * from b_diagnosa where degger_id=0 and diagnosa_id='".$diagnosa_id."' and kunjungan_id='".$kunjungan_id."'";
		}
		//echo $sCek;
		$qCek=mysql_query($sCek);
		
		if($diagnosa_id==0){
			$sCek2="select ms_diagnosa_id from b_diagnosa_rm where degger_id=0 and id='".$id_degger."'";
			//$sCek2="select ms_diagnosa_id_rm from b_diagnosa where degger_id=0 and diagnosa_id='".$id_degger."'";
		}else{
			$sCek2="select ms_diagnosa_id from b_diagnosa_rm where degger_id=0 and diagnosa_id='".$diagnosa_id."'";
			//$sCek2="select ms_diagnosa_id_rm from b_diagnosa where degger_id=0 and diagnosa_id='".$diagnosa_id."'";
		}
		//echo $sCek2;
		$qCek2=mysql_query($sCek2);
		$cekLagi=mysql_fetch_array($qCek2);
		
		if(mysql_num_rows($qCek)==0){
			/* $sUpdt = "UPDATE b_diagnosa SET
						ms_diagnosa_id_rm = {$ms_diagnosa_id},
						tgl_act_rm = NOW(),
						user_act_rm = {$user_act}
					WHERE diagnosa_id = {$diagnosa_id}";
			mysql_query($sUpdt); */
			
			$sIns="insert into b_diagnosa_rm(diagnosa_id,ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,tgl_act,user_act)
			select diagnosa_id,$ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,now(),$user_act from b_diagnosa where diagnosa_id='".$diagnosa_id."'";
			//echo $sIns."<br>";
			mysql_query($sIns);
			
			$idterakhir = mysql_insert_id();	//id terakhir jika sebagai degger
			
			if($cek_degger=='1'){	//cek apakah degger & asterix
				$arfdata=explode("**",$fdata);
				for ($i=0;$i<count($arfdata);$i++)
				{
					$arfvalue=explode("|",$arfdata[$i]);
					$sql="insert into b_diagnosa_rm(diagnosa_id,ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,tgl_act,user_act,degger_id)
					select diagnosa_id,$arfvalue[0],diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,now(),$user_act,$idterakhir from b_diagnosa where diagnosa_id='".$diagnosa_id."'";
					//echo $sql."<br>";
					$rs1=mysql_query($sql);
				}
			}	//akhir degger & asterix
			
			if(mysql_affected_rows()>0)
				$res="ok";	
			else
				$res="error 2";
		}
		else {//update icdrm
			/*$sId="select id from b_diagnosa_rm where diagnosa_id='".$diagnosa_id."'";
			$qId=mysql_query($sId);
			$rwId=mysql_fetch_array($qId);
			$diagnosa_rm_id=$rwId['id'];*/
			if($cekLagi['ms_diagnosa_id'] == '0'){
				//$sInsert="insert into b_diagnosa_rm_act(diagnosa_rm_id,catatan,tgl_act,user_act) values ('$id_degger','$txtCatatan',NOW(),'$user_act')";
				$sInsert="insert into b_diagnosa_rm_act
				(diagnosa_rm_id,catatan,tgl_act,user_act,ms_diagnosa_id_lama,ms_diagnosa_id_baru,diagnosa_id,degger_id,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru)
				SELECT '$id_degger','$txtCatatan',NOW(),'$user_act',ms_diagnosa_id AS ms_diagnosa_id_lama,'$ms_diagnosa_id',diagnosa_id,degger_id,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru FROM b_diagnosa_rm WHERE id = '".$id_degger."' ";
				//echo $sInsert."<br/>";
				mysql_query($sInsert);
				
				$sUp="update b_diagnosa_rm set ms_diagnosa_id='$ms_diagnosa_id' where id='".$id_degger."'";
				//echo $sUp."<br/>";
				mysql_query($sUp);
			} else {
				if($ms_diagnosa_id != $ms_diagnosa_id_cdgn && $id_degger!= ""){
					//$sInsert="insert into b_diagnosa_rm_act(diagnosa_rm_id,catatan,tgl_act,user_act) values ('$id_degger','$txtCatatan',NOW(),'$user_act')";
					$sInsert="insert into b_diagnosa_rm_act
					(diagnosa_rm_id, catatan, tgl_act, user_act, ms_diagnosa_id_lama, ms_diagnosa_id_baru, diagnosa_id, degger_id, kunjungan_id, pelayanan_id, tgl, user_id, type_dokter, primer, akhir, klinis, banding, mati, kasus_baru)
					SELECT '$id_degger','$txtCatatan',NOW(),'$user_act',ms_diagnosa_id AS ms_diagnosa_id_lama,'$ms_diagnosa_id', diagnosa_id, degger_id, kunjungan_id, pelayanan_id, tgl, user_id, type_dokter, primer, akhir, klinis, banding, mati, kasus_baru 
					FROM b_diagnosa_rm WHERE id = '".$id_degger."' ";
					//secho $sInsert."<br/>";
					mysql_query($sInsert);
					
					$sUp="update b_diagnosa_rm set ms_diagnosa_id = '$ms_diagnosa_id' where id = '".$id_degger."'";
					//echo $sUp."<br/>";
					mysql_query($sUp);
				}
			}
			$catatan = "";
			if($cek_degger=='1'){	//cek apakah degger & asterix
				$arfdata=explode("**",$fdata);
		
				//script dibawah utk cek asterix ada atau dihapus
				/*$ceklah=explode("---",$isinyaid);
				for ($z=0;$z<count($ceklah)-1;$z++)
				{
				
				
				for ($i=0;$i<count($arfdata);$i++)
				{
					$arfvalue=explode("|",$arfdata[$i]);
					
					if($arfvalue[2]==$ceklah[$z]){
					//echo $ceklah[$z]."<br><br>";
					$ada = $ceklah[$z];
					}
					
				}
				
				if($ceklah[$z]!=$ada){
				$query="DELETE FROM b_diagnosa_rm WHERE id = '$ceklah[$z]'";
				//echo $query;
				mysql_query($query);
				}
						
				}*/
			
				for ($i=0;$i<count($arfdata);$i++)
				{
					$arfvalue=explode("|",$arfdata[$i]);
					/*if($arfvalue[4]=='1'){
						$sql="insert into b_diagnosa_rm_act
						(diagnosa_rm_id,catatan,tgl_act,user_act,ms_diagnosa_id_lama,ms_diagnosa_id_baru,diagnosa_id,degger_id,hapus)
						SELECT '$arfvalue[2]','$arfvalue[1]',NOW(),'$user_act',ms_diagnosa_id AS ms_diagnosa_id_lama,'',diagnosa_id,degger_id,'1' FROM b_diagnosa_rm WHERE id = '".$arfvalue[2]."' ";
							
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
						
						$sql2="DELETE FROM b_diagnosa_rm WHERE id='".$arfvalue[2]."'";
						//echo $sql2."<br>";
						$rs12=mysql_query($sql2);	
					}else{*/
					  if($arfvalue[0]!=$arfvalue[3]){
						if($arfvalue[2]!=''){	
						  if($arfvalue[0]!=''){
							if($arfvalue[1]!=''){
							//$sql="insert into b_diagnosa_rm_act(diagnosa_rm_id,catatan,tgl_act,user_act) values ('$arfvalue[2]','$arfvalue[1]',NOW(),'$user_act')";
							$sql="insert into b_diagnosa_rm_act
							(diagnosa_rm_id,catatan,tgl_act,user_act,ms_diagnosa_id_lama,ms_diagnosa_id_baru,diagnosa_id,degger_id,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru)
							SELECT '$arfvalue[2]','$arfvalue[1]',NOW(),'$user_act',ms_diagnosa_id AS ms_diagnosa_id_lama,'$arfvalue[0]',diagnosa_id,degger_id,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru FROM b_diagnosa_rm WHERE id = '".$arfvalue[2]."' ";
							
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
						
							$sql2="update b_diagnosa_rm set ms_diagnosa_id='".$arfvalue[0]."' where id='".$arfvalue[2]."'";
							//echo $sql2."<br>";
							$rs12=mysql_query($sql2);
							$catatan = "";
							}else{
								$x="SELECT CONCAT(a.kode,' - ',a.nama) diag FROM b_ms_diagnosa a INNER JOIN b_diagnosa_rm b ON a.id = b.ms_diagnosa_id WHERE b.id = '$arfvalue[2]' ";
								//echo $x="SELECT * b_diagnosa_rm b ON a.id = b.ms_diagnosa_id WHERE b.id = '$arfvalue[2]' ";
								$z=mysql_query($x);
								$mysq=mysql_fetch_array($z);
								$catatan = "Anda diwajibkan mengisi catatan pada ".$mysq['diag'];
							}
						  }
						}else{
						 if($diagnosa_id==0){
							$sql2="insert into b_diagnosa_rm
							(diagnosa_id,ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,tgl_act,user_act,degger_id) values
							('0','$arfvalue[0]','','$kunjungan_id','$pelayanan_id','','','','','','','','','',now(),'$user_act','$id_degger')";
						 }else{
							$sql2="insert into b_diagnosa_rm(diagnosa_id,ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,tgl_act,user_act,degger_id)
							select diagnosa_id,'$arfvalue[0]',diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,now(),'$user_act','$id_degger' from b_diagnosa where diagnosa_id='".$diagnosa_id."'";
						 }
							
							//echo $sql2."<br>";
							$rs12=mysql_query($sql2);
						}
					  }
					//}
				}
			
			}	//akhir degger & asterix
			if($catatan!=''){
					$res=$catatan;	
			}else{
				if(mysql_affected_rows()>0){
					$res="ok";	
				}
				else{
					$res="error 3";	
				}
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
				$res="error 4";	
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
				$res="error 5";	
			}
		}
		
		echo $res;
		return;
		break;
		case 'updatekasusicdxrm':
		$sCek="select * from b_diagnosa_rm where degger_id=0 and diagnosa_id='".$diagnosa_id."'";
		$qCek=mysql_query($sCek);
		
		if(mysql_num_rows($qCek)==0){
			$sIns="insert into b_diagnosa_rm(diagnosa_id,ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,tgl_act,user_act)
			select diagnosa_id,'0',diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,'$kasus_baru',now(),$user_act from b_diagnosa where diagnosa_id='".$diagnosa_id."'";
			//echo $sIns;
			mysql_query($sIns);
			if(mysql_affected_rows()>0){
				$res="ok";	
			}
			else{
				$res="error 6";
			}	
		}
		else{
			$sUp="update b_diagnosa_rm set kasus_baru=$kasus_baru where degger_id=0 and diagnosa_id='".$diagnosa_id."'";
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
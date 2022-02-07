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
$txtPrioritas=$_REQUEST['txtPrioritas'];
$txtPrioritas_cdgn=$_REQUEST['txtPrioritas_cdgn'];
$id_diag_rm=$_REQUEST['id_diag_rm'];
$cek_id_kasus=$_REQUEST['cek_id_kasus'];

switch(strtolower($_REQUEST['act'])) {
	case 'updateicdxrm':
		$sCek="select * from b_diagnosa_rm where degger_id=0 and id='".$id_degger."'";
		//echo $sCek;
		$qCek=mysql_query($sCek);
		
		$sCek2="select ms_diagnosa_id from b_diagnosa_rm where degger_id=0 and id='".$id_degger."'";
		//echo $sCek2;
		$qCek2=mysql_query($sCek2);
		$cekLagi=mysql_fetch_array($qCek2);
		//$qCek=0;
		
		if(mysql_num_rows($qCek)==0){
			$sIns="insert into b_diagnosa_rm
			(diagnosa_id,ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,tgl_act,user_act) values
			('0',$ms_diagnosa_id,'',$kunjungan_id,$pelayanan_id,'','','','$txtPrioritas','','','','','2',now(),$user_act)";
			//echo $sIns."<br>";
			mysql_query($sIns);
			
			$idterakhir = mysql_insert_id();	//id terakhir jika sebagai degger
	if($cek_degger=='1'){	//cek apakah degger & asterix
			$arfdata=explode("**",$fdata);
			for ($i=0;$i<count($arfdata);$i++)
			{
				$arfvalue=explode("|",$arfdata[$i]);
					$sql="insert into b_diagnosa_rm
					(diagnosa_id,ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,tgl_act,user_act,degger_id) values
					('0',$arfvalue[0],'',$kunjungan_id,$pelayanan_id,'','','','$txtPrioritas','','','','','2',now(),$user_act,$idterakhir)";
					//echo $sql."<br>";
					$rs1=mysql_query($sql);
			}
	}	//akhir degger & asterix
			
			if(mysql_affected_rows()>0){
				$res="ok";	
			}
			else{
				$res="error";
			}	
		}
		else{//update icdrm
			/*$sId="select id from b_diagnosa_rm where diagnosa_id='".$diagnosa_id."'";
			$qId=mysql_query($sId);
			$rwId=mysql_fetch_array($qId);
			$diagnosa_rm_id=$rwId['id'];*/
		  if($cekLagi['ms_diagnosa_id'] == '0'){
			//$sInsert="insert into b_diagnosa_rm_act(diagnosa_rm_id,catatan,tgl_act,user_act) values ('$id_degger','$txtCatatan',NOW(),'$user_act')";
			$sInsert="insert into b_diagnosa_rm_act
			(diagnosa_rm_id,catatan,tgl_act,user_act,ms_diagnosa_id_lama,ms_diagnosa_id_baru,diagnosa_id,degger_id,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru)
			SELECT '$id_degger','$txtCatatan',NOW(),'$user_act',ms_diagnosa_id AS ms_diagnosa_id_lama,'$ms_diagnosa_id',diagnosa_id,degger_id,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,'$txtPrioritas',akhir,klinis,banding,mati,kasus_baru FROM b_diagnosa_rm WHERE id = '".$id_degger."' ";
			//echo $sInsert."<br/>";
			mysql_query($sInsert);
			
			$sUp="update b_diagnosa_rm set ms_diagnosa_id='$ms_diagnosa_id',primer='$txtPrioritas' where id='".$id_degger."'";
			//echo $sUp."<br/>";
			mysql_query($sUp);
		  }else
		  if($ms_diagnosa_id != $ms_diagnosa_id_cdgn){
			//$sInsert="insert into b_diagnosa_rm_act(diagnosa_rm_id,catatan,tgl_act,user_act) values ('$id_degger','$txtCatatan',NOW(),'$user_act')";
			$sInsert="insert into b_diagnosa_rm_act
			(diagnosa_rm_id,catatan,tgl_act,user_act,ms_diagnosa_id_lama,ms_diagnosa_id_baru,diagnosa_id,degger_id,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru)
			SELECT '$id_degger','$txtCatatan',NOW(),'$user_act',ms_diagnosa_id AS ms_diagnosa_id_lama,'$ms_diagnosa_id',diagnosa_id,degger_id,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,'$txtPrioritas',akhir,klinis,banding,mati,kasus_baru FROM b_diagnosa_rm WHERE id = '".$id_degger."' ";
			//secho $sInsert."<br/>";
			mysql_query($sInsert);
			
			$sUp="update b_diagnosa_rm set ms_diagnosa_id='$ms_diagnosa_id',primer='$txtPrioritas' where id='".$id_degger."'";
			//echo $sUp."<br/>";
			mysql_query($sUp);
		  }else
		  if($txtPrioritas != $txtPrioritas_cdgn){
			//$sInsert="insert into b_diagnosa_rm_act(diagnosa_rm_id,catatan,tgl_act,user_act) values ('$id_degger','$txtCatatan',NOW(),'$user_act')";
			$sInsert="insert into b_diagnosa_rm_act
			(diagnosa_rm_id,catatan,tgl_act,user_act,ms_diagnosa_id_lama,ms_diagnosa_id_baru,diagnosa_id,degger_id,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru)
			SELECT '$id_degger','$txtCatatan',NOW(),'$user_act',ms_diagnosa_id AS ms_diagnosa_id_lama,'$ms_diagnosa_id',diagnosa_id,degger_id,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,'$txtPrioritas',akhir,klinis,banding,mati,kasus_baru FROM b_diagnosa_rm WHERE id = '".$id_degger."' ";
			//secho $sInsert."<br/>";
			mysql_query($sInsert);
			
			$sUp="update b_diagnosa_rm set ms_diagnosa_id='$ms_diagnosa_id',primer='$txtPrioritas' where id='".$id_degger."'";
			//echo $sUp."<br/>";
			mysql_query($sUp);
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
						SELECT '$arfvalue[2]','$arfvalue[1]',NOW(),'$user_act',ms_diagnosa_id AS ms_diagnosa_id_lama,'$arfvalue[0]',diagnosa_id,degger_id,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,'$txtPrioritas',akhir,klinis,banding,mati,kasus_baru FROM b_diagnosa_rm WHERE id = '".$arfvalue[2]."' ";
						
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
					
						$sql2="update b_diagnosa_rm set ms_diagnosa_id='".$arfvalue[0]."',primer='$txtPrioritas' where id='".$arfvalue[2]."'";
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
					 //if($diagnosa_id==0){
						$sql2="insert into b_diagnosa_rm
						(diagnosa_id,ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,tgl_act,user_act,degger_id) values
						('0','$arfvalue[0]','','$kunjungan_id','$pelayanan_id','','','','$txtPrioritas','','','','','',now(),'$user_act','$id_degger')";
					 /*}else{
						$sql2="insert into b_diagnosa_rm(diagnosa_id,ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,tgl_act,user_act,degger_id)
						select diagnosa_id,'$arfvalue[0]',diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,now(),'$user_act','$id_degger' from b_diagnosa where diagnosa_id='".$diagnosa_id."'";
					 }*/
						
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
					$res="error";	
				}
			}
		}
		
		echo $res;
		return;
		
		break;
	case 'updateicdxrm2':
		$sCek="SELECT * FROM b_diagnosa_rm WHERE id = '".$cek_id_kasus."'";
		//echo $sCek;
		$qCek=mysql_query($sCek);
		
		if(mysql_num_rows($qCek)!=0){
			$que="INSERT INTO b_diagnosa_rm_act
			(diagnosa_rm_id,catatan,tgl_act,user_act,ms_diagnosa_id_lama,diagnosa_id,degger_id,hapus,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru)
			SELECT id,'Penghapusan Pada Degger Sehingga Menghapus Asterix Untuk Diagnosa Manual',NOW(),'".$user_act."',ms_diagnosa_id AS ms_diagnosa_id_lama,diagnosa_id,degger_id,'1',kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru FROM b_diagnosa_rm WHERE degger_id = '".$cek_id_kasus."'";
				//echo $que."<br>";
				mysql_query($que);

			$query = "DELETE FROM b_diagnosa_rm WHERE degger_id='".$cek_id_kasus."'";
				//echo $query."<br>";
				mysql_query($query);
				
			$que2="INSERT INTO b_diagnosa_rm_act
			(diagnosa_rm_id,catatan,tgl_act,user_act,ms_diagnosa_id_lama,diagnosa_id,degger_id,hapus,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru)
			SELECT id,'Penghapusan Diagnosa Manual',NOW(),'".$user_act."',ms_diagnosa_id AS ms_diagnosa_id_lama,diagnosa_id,degger_id,'1',kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru FROM b_diagnosa_rm WHERE id = '".$cek_id_kasus."'";
				//echo $que2."<br>";
				mysql_query($que2);

			$query2 = "DELETE FROM b_diagnosa_rm WHERE id='".$cek_id_kasus."'";
				//echo $query2."<br>";
				mysql_query($query2);	
		}
			
				if(mysql_affected_rows()>0){
					$res="ok2";	
				}
				else{
					$res="error2";	
				}
		
		echo $res;
		return;
		
		break;
	case 'updateicd9cm_JANGAN':
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
		$sCek="select * from b_diagnosa_rm where id='".$id_diag_rm."'";
		$qCek=mysql_query($sCek);
		
		if(mysql_num_rows($qCek)==0){
		 if($diagnosa_id==0){
			$sIns="insert into b_diagnosa_rm
			(diagnosa_id,ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,tgl_act,user_act) values
			('0','0','','$kunjungan_id','$pelayanan_id','','','','','','','','','$kasus_baru',now(),$user_act)";
		 }else{
			$sIns="insert into b_diagnosa_rm(diagnosa_id,ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,kasus_baru,tgl_act,user_act)
			select diagnosa_id,'0',diagnosa_manual,kunjungan_id,pelayanan_id,tgl,user_id,type_dokter,primer,akhir,klinis,banding,mati,'$kasus_baru',now(),$user_act from b_diagnosa where diagnosa_id='".$diagnosa_id."'";
		 }
			mysql_query($sIns);
			if(mysql_affected_rows()>0){
				$res="ok";	
			}
			else{
				$res="error";
			}	
		}
		else{
			$sUp="update b_diagnosa_rm set kasus_baru=$kasus_baru where id='".$id_diag_rm."'";
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
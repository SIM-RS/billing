<?php
include("../koneksi/konek.php");


$ParentKode=trim($_REQUEST['parentKode']);
if($ParentKode==''){
	$parentId=0;
	$parentLevel=0;      
}
else{
	$parentId=$_REQUEST['parentId'];
	if($parentId=='') $parentId=0;
	$parentLevel=$_REQUEST['parentLvl'];
	if ($parentLevel=="") $parentLevel=0;      
	
}
$lvl=$_REQUEST['level'];

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
            
            $kode=$_REQUEST['parentKode'].$_REQUEST['kode'];
           
		mysql_query("select * from b_ms_menu where kode='".$kode."'");
		if(mysql_affected_rows()>0){
			echo "Data Sudah Ada!";
		}
		else{
			$sqlTambah="insert into b_ms_menu (kode,nama,level,parent_id,parent_kode,url)
				values('".$kode."','".$_REQUEST['nama']."','".$_REQUEST['level']."','".$_REQUEST['parentId']."','".$_REQUEST['parentKode']."','".$_REQUEST['url']."')";
			$rs=mysql_query($sqlTambah);
                  //echo $sqlTambah."<br/>";
                  //echo mysql_error();
			/*if ($parentId>0){
				$sql="update b_ms_menu set islast=0 where id=$parentId";
				//echo $sql;
				$rs=mysql_query($sql);
			}*/
			//echo "ok";
		}
		break;
	case 'hapus':
		mysql_query("select * from b_ms_menu where parent_id='".$_REQUEST['id']."'");
		if(mysql_affected_rows()>0){
			echo "Data merupakan induk! ".$_REQUEST['id'];
		}
		else{
			$sql="delete from b_ms_menu where id='".$_REQUEST['id']."'";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			/*
                  $sql1="select * from b_ms_menu where parent_id=".$parentId;
			//echo $sql1."<br>";
			$rs2=mysql_query($sql1);
			if (mysql_num_rows($rs2)<=0){
				$sql2="update b_ms_menu set islast=1 where id=".$parentId;
				//echo $sql2."<br>";
				$rs3=mysql_query($sql2);
			}
                  */
			//echo "ok";
		}		
		break;
	case 'simpan':
           
            $kode=$_REQUEST['parentKode'].$_REQUEST['kode'];
            
		$sql="select * from b_ms_menu where kode='$kode' and nama='".$_REQUEST['nama']."' and level=$lvl and parent_id=$parentId and parent_kode='$ParentKode' and url='".$_REQUEST['url']."'";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "Data Sudah Ada!";
		}else{
			$sql="select * from b_ms_menu where id='".$_REQUEST['id']."'";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			if ($rows=mysql_fetch_array($rs)){
				$cparent=$rows["parentId"];
				$clvl=$rows["level"]-1;
				$cmkode=$rows["kode"];								
			}
			//echo "cparent=".$cparent.",clvl=".$clvl.",cmkode=".$cmkode.",cislast=".$cislast."<br>";
			if ($cparent!=$parentId){
				$cur_lvl=$lvl-$clvl;
				if ($cur_lvl>0) $cur_lvl="+".$cur_lvl;
				//$sql="update b_ms_menu set islast=0 where id=".$parentId;
				//echo $sql."<br>";
				//$rs=mysql_query($sql);
				$sql="update b_ms_menu set kode='$kode',nama='".$_REQUEST['nama']."',level=$lvl,parent_id=$parentId,parent_kode='$ParentKode',url='".$_REQUEST['url']."' where id='".$_REQUEST['id']."'";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if ($cislast==0){
					$sql="update b_ms_menu set kode=CONCAT('$kode',right(kode,length(kode)-length('$cmkode'))),parent_kode=CONCAT('$kode',right(parent_kode,length(parent_kode)-length('$cmkode'))),level=".$cur_lvl." where left(kode,length('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
				}
				/*
                        $sql="select * from b_ms_menu where parent_id=$cparent";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if (mysql_num_rows($rs)<=0){
					$sql="update b_ms_menu set islast=1 where id=".$cparent;
					//echo $sql."<br>";
					$rs1=mysql_query($sql);
				}
                        */
			}else{	
				$sql="update b_ms_menu set kode='$kode',nama='".$_REQUEST['nama']."',level=$lvl,parent_id=$parentId,parent_kode='$ParentKode',url='".$_REQUEST['url']."',aktif='".$cekAktif."' where id='".$_REQUEST['id']."'";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if (($kode_ma!=$cmkode) && ($cislast==0)){
					$sql="update b_ms_menu set kode=CONCAT('$kode',right(kode,length(kode)-length('$cmkode'))),parent_kode=CONCAT('$kode',right(parent_kode,length(parent_kode)-length('$cmkode'))) where left(kode,length('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
				}
			}
			//echo "ok";
		}
		mysql_free_result($rs1);
		break;
}
mysql_free_result($rs);
mysql_close($konek);
?>
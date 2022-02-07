<?php
include("../koneksi/konek.php");
$perpage=100;
$grdtab5=$_REQUEST['grdtab5'];
//$id=$_REQUEST['id'];

//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="UNIT_KODE";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$userId = $_REQUEST['userId'];
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//$tgl = tglSQL($_REQUEST['tgl_lahir']); 
$aktif = 1;
//===============================

//$id = explode(",",$_REQUEST['id']);
if($grdtab5 == "false"){
   switch(strtolower($_REQUEST['act']))
   {
      case 'tambah':
      //for($i=0;$i<(sizeof($id)-1);$i++)
      //{
	    //$sqlCek = "select * from b_ms_pegawai_unit where unit_id='".$id[$i]."' and ms_pegawai_id='".$_REQUEST['idPeg']."'";
	    $sqlCek = "select * from a_user_unit where unit_id='".$_REQUEST['id']."' and user_id='".$_REQUEST['idPeg']."'";
	    $rsCek = mysqli_query($konek,$sqlCek);
	    if(mysqli_num_rows($rsCek)==0)
	    {
		  $sqlTambah = "INSERT INTO a_user_unit (user_id,unit_id) values('".$_REQUEST['idPeg']."','".$_REQUEST['id']."')";
		  $rs=mysqli_query($konek,$sqlTambah);
		  $res = mysqli_affected_rows($konek);
	    }
      //}
      break;
		   
      case 'hapus':
      //$sqlHapus="delete from b_ms_pegawai_unit where id='".$_REQUEST['rowid']."'";
      $sqlHapus="delete from a_user_unit where user_id='".$_REQUEST['idPeg']."' and unit_id = '".$_REQUEST['id']."'";
      $rs=mysqli_query($konek,$sqlHapus);
      $res = mysqli_affected_rows($konek);
      break;   
   }
   /**/if($res > 0){
      $res = "Update berhasil.";
   }
   else if($res == 0){
      //$res = "Data tidak berubah.";
   }
   else{
      $res = "Update gagal.";
   }
   echo $res;
}
else{
   if ($filter!=""){
	   $filter=explode("|",$filter);
	   $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
   }
   
   if ($sorting==""){
	   $sorting=$defaultsort;
   }
   
   if($grdtab5 == "true")
   {
	   /*$sql="select * from
	   (SELECT u.id
	   ,if((select id from b_ms_pegawai_unit where unit_id=u.id and ms_pegawai_id='".$_REQUEST['idPeg']."') is null,false,true) as pil
	   ,u.kode,u.nama FROM b_ms_unit u where u.islast=1) as t1 ".$filter." order by ".$sorting;*/
	   $sql = "SELECT * FROM (SELECT u.UNIT_ID, u.UNIT_NAME, IF( t1.UNIT_ID IS NULL , 0, 1 ) AS pil, u.UNIT_KODE, tp.TIPE
		  FROM a_unit u
		  INNER JOIN a_tipe tp ON tp.TIPE_ID = u.UNIT_TIPE
		  LEFT JOIN (
		  SELECT *
		  FROM a_user_unit pu
		  WHERE user_id ='".$_REQUEST['idPeg']."'
		  ) AS t1 ON u.UNIT_ID = t1.unit_id
		  WHERE UNIT_ISAKTIF =1) AS t2 $filter order by $sorting";
   }
   
   
   //echo $sql."<br>";
   $rs=mysqli_query($konek,$sql);
   $jmldata=mysqli_num_rows($rs);
   if ($page=="" || $page=="0") $page=1;
   $tpage=($page-1)*$perpage;
   if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
   if ($page>1) $bpage=$page-1; else $bpage=1;
   if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
   $sql=$sql." limit $tpage,$perpage";
   //echo $sql;
   
   $rs=mysqli_query($konek,$sql);
   $i=($page-1)*$perpage;
   $dt=$totpage.chr(5);
   
   if($grdtab5 == "true")
   {
	   while ($rows=mysqli_fetch_array($rs))
	   {
		   $i++;
		   $dt.=$rows["UNIT_ID"].'|'.$rows["pil"].chr(3).number_format($i,0,",","").chr(3).$rows["pil"].chr(3).$rows["UNIT_KODE"].chr(3).$rows["TIPE"].chr(3).$rows["UNIT_NAME"].chr(6);
	   }
   }
   
   if ($dt!=$totpage.chr(5)){
		   $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
		   $dt=str_replace('"','\"',$dt);
	   }
   
   mysqli_free_result($rs);
   mysqli_close($konek);
   header("Cache-Control: no-cache, must-revalidate" );
   header("Pragma: no-cache" );
   if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	   header("Content-type: application/xhtml+xml");
   }else{
	   header("Content-type: text/xml");
   }
   echo $dt;
}
?>
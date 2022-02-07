<?php
include("../koneksi/konek.php");
$grdtab6=$_REQUEST['grdtab6'];
//$id=$_REQUEST['id'];

//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="kode";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$userId = $_REQUEST['userId'];
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tgl = tglSQL($_REQUEST['tgl_lahir']); 
$aktif = 1;
//===============================

//$id = explode(",",$_REQUEST['id']);
if($grdtab6 == "false"){
   switch(strtolower($_REQUEST['act']))
   {
      case 'tambah':
      //for($i=0;$i<(sizeof($id)-1);$i++)
      //{
	    //$sqlCek = "select * from b_ms_pegawai_unit where unit_id='".$id[$i]."' and ms_pegawai_id='".$_REQUEST['idPeg']."'";
	    $sqlCek = "select * from b_ms_menu_report_rm_akses where menu_id='".$_REQUEST['id']."' and pegawai_id='".$_REQUEST['idPeg']."'";
	    $rsCek = mysqli_query($konek,$sqlCek);
	    if(mysqli_num_rows($rsCek)==0)
	    {
		  $sqlTambah = "INSERT INTO b_ms_menu_report_rm_akses (pegawai_id,menu_id) values('".$_REQUEST['idPeg']."','".$_REQUEST['id']."')";
		  $rs=mysqli_query($konek,$sqlTambah);
		  $res = mysqli_affected_rows($konek);
	    }
      //}
      break;
		   
      case 'hapus':
      //$sqlHapus="delete from b_ms_pegawai_unit where id='".$_REQUEST['rowid']."'";
      $sqlHapus="delete from b_ms_menu_report_rm_akses where pegawai_id='".$_REQUEST['idPeg']."' and menu_id = '".$_REQUEST['id']."'";
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
   
   if($grdtab6 == "true")
   {
	   $sql = "SELECT * FROM (SELECT u.id, u.nama, IF( t1.id IS NULL , 0, 1 ) AS pil, u.kode
		  FROM b_ms_menu_report_rm u
		  LEFT JOIN (
		  SELECT *
		  FROM b_ms_menu_report_rm_akses pu
		  WHERE pegawai_id ='".$_REQUEST['idPeg']."'
		  ) AS t1 ON u.id = t1.menu_id
		  WHERE islast =1) AS t2 $filter order by $sorting";
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
   
   if($grdtab6 == "true")
   {
	   while ($rows=mysqli_fetch_array($rs))
	   {
		   $i++;
		   $dt.=$rows["id"].'|'.$rows["pil"].chr(3).number_format($i,0,",","").chr(3).$rows["pil"].chr(3).$rows["kode"].chr(3).$rows["nama"].chr(6);
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
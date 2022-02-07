<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$kid=$_REQUEST["kid"];
$sql="SELECT * FROM a_mitra WHERE KELOMPOK_ID=$kid";
$rs=mysqli_query($konek,$sql);
$jmldata=mysqli_num_rows($rs);
if (($jmldata>1)||($jmldata==0)) $p="<option value='0' class='txtinput'>SEMUA</option>"; else $p="";
while ($rows=mysqli_fetch_array($rs)){
	$p .="<option value='".$rows["IDMITRA"]."' class='txtinput'>".$rows["NAMA"]."</option>";
}
mysqli_close($konek);
echo $p;
?>
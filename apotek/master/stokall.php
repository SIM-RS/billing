<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$username = $_SESSION["username"];
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$unit_id=$_REQUEST['unit_id'];
$unit_name=$_REQUEST['unit_name'];
$unit_tipe=$_REQUEST['unit_tipe'];
$unit_isaktif=$_REQUEST['unit_isaktif'];

convert_var($username,$unit_id,$unit_name,$unit_tipe,$unit_isaktif);
//====================================================================

//Set Status Aktif atau Tidak====
$status=$_REQUEST['status'];

// ==============================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
//$defaultsort="o.OBAT_NAMA,m.ID";
$defaultsort="OBAT_NAMA,KEPEMILIKAN_ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
convert_var($status,$page,$sorting,$filter);
if ($status=="") $status=1;
/*
$kelas=$_REQUEST['kelas'];if ($kelas=="") $fkelas=""; else{ if ($filter=="") $fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'"; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";}
$golongan=$_REQUEST['golongan'];if ($golongan=="") $fgolongan=""; else{ if (($filter=="")&&($fkelas=="")) $fgolongan=" WHERE o.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND o.OBAT_GOLONGAN='$golongan'";}
$jenis=$_REQUEST['jenis'];if ($jenis=="") $fjenis=""; else { if (($filter=="")&&($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE o.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND o.OBAT_KELOMPOK=$jenis";}
*/
$kelas=$_REQUEST['kelas'];
$golongan=$_REQUEST['golongan'];
$jenis=$_REQUEST['jenis'];
$kategori=$_REQUEST['kategori'];

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

convert_var($kelas,$golongan,$jenis,$kategori,$act);

if ($kelas=="") $fkelas=""; else $fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'";
if ($golongan=="") $fgolongan=""; else{ if ($fkelas=="") $fgolongan=" WHERE o.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND o.OBAT_GOLONGAN='$golongan'";}
if ($jenis=="") $fjenis=""; else { if (($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE o.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND o.OBAT_KELOMPOK=$jenis";}
if ($kategori=="") $fkategori=""; else { if (($fkelas=="")&&($fgolongan=="")&&($fjenis=="")) $fkategori=" WHERE o.OBAT_KATEGORI=$kategori"; else $fkategori=" AND o.OBAT_KATEGORI=$kategori";}
//===============================



switch ($act){
	
}
//Aksi Save, Edit, Delete Berakhir ============================================
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<!-- Script Pop Up Window -->
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
</script>
<!-- Script Pop Up Window Berakhir -->
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 12px}
-->
</style>
</head>
<body>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="unit_id" id="unit_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
  <p><span class="jdltable">STOK SELURUH UNIT</span>
  		
      <table>
        <tr> 
          <td align="center" class="txtinput">Kelas </td>
          <td align="center" class="txtinput">: 
            <select name="kelas" id="kelas" class="txtinput" onChange="location='?f=../master/stokall.php&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value">
              <option value="" class="txtinput"<?php if ($kelas=="") echo " selected";?>>SEMUA</option>
              <?
			  $k1="SEMUA";
		  $qry="SELECT * FROM a_kelas ORDER BY KLS_KODE";
		  $exe=mysqli_query($konek,$qry);
		  while($show=mysqli_fetch_array($exe)){ 
		  	$lvl=$show["KLS_LEVEL"];
			$tmp="";
			for ($i=1;$i<$lvl;$i++) $tmp .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$tmp .=$show['KLS_NAMA'];
		  ?>
              <option value="<?=$show['KLS_KODE'];?>" class="txtinput"<?php if ($kelas==$show['KLS_KODE']){echo " selected";$k1=$show['KLS_NAMA'];}?>><?php echo $tmp;?></option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Kategori </td>
          <td align="center" class="txtinput">: 
            <select name="kategori" id="kategori" class="txtinput" onChange="location='?f=../master/stokall.php&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value">
              <option value="" class="txtinput"<?php if ($kategori=="") echo " selected";?>>SEMUA</option>
              <?
			  $f1="SEMUA";
			  $qry="SELECT * FROM a_obat_kategori";
			  $exe=mysqli_query($konek,$qry);
			  while($show=mysqli_fetch_array($exe)){ 
			  ?>
              <option value="<?=$show['id'];?>" class="txtinput"<?php if ($kategori==$show['id']){echo " selected";$f1=$show['kategori'];}?>><?php echo $show['kategori'];?></option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Golongan </td>
          <td align="center" class="txtinput">: 
            <select name="golongan" id="golongan" class="txtinput" onChange="location='?f=../master/stokall.php&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value">
              <option value="" class="txtinput"<?php if ($golongan==""){echo " selected";$g1="SEMUA";}?>>SEMUA</option>
              <option value="N" class="txtinput"<?php if ($golongan=="N"){echo " selected";$g1="Narkotika";}?>>Narkotika</option>
              <option value="P" class="txtinput"<?php if ($golongan=="P"){echo " selected";$g1="Pethidine";}?>>Pethidine</option>
              <option value="M" class="txtinput"<?php if ($golongan=="M"){echo " selected";$g1="Morphine";}?>>Morphine</option>
              <option value="Psi" class="txtinput"<?php if ($golongan=="Psi"){echo " selected";$g1="Psikotropika";}?>>Psikotropika</option>
              <option value="B" class="txtinput"<?php if ($golongan=="B"){echo " selected";$g1="Obat Bebas";}?>>Obat 
              Bebas</option>
              <option value="BT" class="txtinput"<?php if ($golongan=="BT"){echo " selected";$g1="Bebas Terbatas";}?>>Bebas 
              Terbatas</option>
              <option value="K" class="txtinput"<?php if ($golongan=="K"){echo " selected";$g1="Obat Keras";}?>>Obat 
              Keras</option>
              <option value="AK" class="txtinput"<?php if ($golongan=="AK"){echo " selected";$g1="Alkes";}?>>Alkes</option>
            </select></td>
        </tr>
        <tr>
          <td align="center" class="txtinput">Jenis</td>
          <td align="center" class="txtinput">: 
            <select name="jenis" id="jenis" class="txtinput" onChange="location='?f=../master/stokall.php&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value">
              <option value="" class="txtinput">SEMUA</option>
              <?php 
			  $j1="SEMUA";
			  $sql="select * from a_obat_jenis";
			  $rs=mysqli_query($konek,$sql);
			  while ($rows=mysqli_fetch_array($rs)){
			  ?>
              <option value="<?php echo $rows['obat_jenis_id']; ?>" class="txtinput"<?php if ($jenis==$rows['obat_jenis_id']){echo " selected";$j1=$rows['obat_jenis'];}?>><?php echo $rows['obat_jenis']; ?></option>
              <?php }?>
            </select></td>
        </tr>
      </table>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="25" height="25" class="tblheaderkiri">No</td>
          <td class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Obat</td>
          <td width="100" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="unit1" width="46" class="tblheader" onClick="ifPop.CallFr(this);">GD</td>
          <td id="unit2" width="46" class="tblheader" onClick="ifPop.CallFr(this);">AP-RS</td>
          <!-- <td id="unit3" width="46" class="tblheader" onClick="ifPop.CallFr(this);">AP-Krakatau</td>
          <td id="unit4" width="46" class="tblheader" onClick="ifPop.CallFr(this);">AP-BICT</td> -->
          <!--td id="unit5" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP4</td>
          <td id="unit6" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP5</td>
          <td id="unit11" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP6</td>
          <td id="unit11" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP7</td>
          <td id="unit11" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP8</td>
          <td id="unit11" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP10</td>
          <td id="unit12" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP11</td-->
          <td id="unit5" width="46" class="tblheader" onClick="ifPop.CallFr(this);">PR</td>
          <td id="unit6" width="46" class="tblheader" onClick="ifPop.CallFr(this);">FS</td>
          <td id="total" width="51" class="tblheader" onClick="ifPop.CallFr(this);">Total</td>
          <td id="ntotal" width="61" class="tblheader" onClick="ifPop.CallFr(this);">Nilai</td>
        </tr>
        <?php 
		$jfilter="";
	  if ($filter!=""){
	  	$jfilter=$filter;
	  	$filter=explode("|",$filter);
	  	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	$sql="SELECT q.idobat as obat_id,q.OBAT_NAMA obat,q.NAMA kepemilikan,q.KEPEMILIKAN_ID,SUM(q.unit1) AS unit1,SUM(q.unit2) AS unit2, q.nilai,
		/* SUM(q.unit3) AS unit3,SUM(q.unit4) AS unit4 */SUM(q.unit5) AS unit5,SUM(q.unit6) AS unit6,SUM(q.ntotal) AS ntotal,SUM(q.total) AS total
		FROM (SELECT DISTINCT p.idobat,p.OBAT_NAMA,ak.NAMA,
		IF (p.KEPEMILIKAN_ID<>ak.ID OR p.KEPEMILIKAN_ID IS NULL,ak.ID,p.KEPEMILIKAN_ID) AS KEPEMILIKAN_ID,
		IF (p.KEPEMILIKAN_ID<>ak.ID OR p.unit1 IS NULL,0,p.unit1) AS unit1,
		IF (p.KEPEMILIKAN_ID<>ak.ID OR p.unit2 IS NULL,0,p.unit2) AS unit2,
    /* Ismul 06/07/2019
		IF (p.KEPEMILIKAN_ID<>ak.ID OR p.unit3 IS NULL,0,p.unit3) AS unit3,
		IF (p.KEPEMILIKAN_ID<>ak.ID OR p.unit4 IS NULL,0,p.unit4) AS unit4,
    */
		IF (p.KEPEMILIKAN_ID<>ak.ID OR p.unit5 IS NULL,0,p.unit5) AS unit5,
		IF (p.KEPEMILIKAN_ID<>ak.ID OR p.unit6 IS NULL,0,p.unit6) AS unit6,
		IF (p.KEPEMILIKAN_ID<>ak.ID OR p.ntotal IS NULL,0,p.ntotal) AS ntotal,
		IF (p.KEPEMILIKAN_ID<>ak.ID OR p.nilai_total IS NULL,0,p.nilai_total) AS nilai,
		IF (p.KEPEMILIKAN_ID<>ak.ID OR p.total IS NULL,0,p.total) AS total
		FROM (SELECT o.OBAT_ID AS idobat,o.OBAT_NAMA,v.*,unit1+unit2/* +unit3+unit4 */+unit5+unit6 AS total 
		FROM (SELECT * FROM a_obat WHERE OBAT_ISAKTIF=1) AS o LEFT JOIN vstokall AS v ON v.obat_id=o.OBAT_ID  
		LEFT JOIN a_kelas AS kls ON o.KLS_ID=kls.KLS_ID".$fkelas.$fgolongan.$fjenis.$fkategori.") AS p LEFT JOIN (SELECT *FROM a_kepemilikan WHERE aktif=1)ak ON 1=1) AS q ".$filter."
		GROUP BY q.idobat,q.KEPEMILIKAN_ID ORDER BY ".$sorting;
	//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";
	//echo $sql2;
	  $rs=mysqli_query($konek,$sql2);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
		
		 $n="SELECT SUM( a_stok.nilai) nilai FROM a_stok
INNER JOIN a_unit ON  a_stok.`unit_id` = a_unit.`UNIT_ID` where a_stok.obat_id=".$rows['obat_id']." and a_stok.kepemilikan_id = ".$rows['KEPEMILIKAN_ID']." AND a_unit.unit_tipe<>3 AND a_unit.UNIT_ID NOT IN(8,9)";
	// echo $sql2."<br>";
	  $n1=mysqli_query($konek,$n);
	  $n2=mysqli_fetch_array($n1);
	  $nilai=$n2['nilai'];
		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td align="left" class="tdisi"><?php echo $rows['obat']; ?></td>
          <td class="tdisi"><?php echo $rows['kepemilikan']; ?></td>
          <td align="right" class="tdisi"> 
		  
		  <a href="../master/kartu_stok_gd.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=12" onClick="NewWindow(this.href,'name','1200','500','yes');return false"> 
            <?php echo $rows['unit1']; ?></a></td>
          <td align="right" class="tdisi"> <a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=7" onClick="NewWindow(this.href,'name','900','500','yes');return false"> 
            <?php echo $rows['unit2']; ?></a></td>
          <!-- Ismul 06/08/2019
          <td align="right" class="tdisi"> <a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=8" onClick="NewWindow(this.href,'name','900','500','yes');return false"> 
            <?php echo $rows['unit3']; ?></a></td>
          <td align="right" class="tdisi"> <a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=9" onClick="NewWindow(this.href,'name','900','500','yes');return false"> 
            <?php echo $rows['unit4']; ?></a></td>
          -->
          <td align="right" class="tdisi"> <a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=16" onClick="NewWindow(this.href,'name','900','500','yes');return false"> 
            <?php echo $rows['unit5']; ?></a></td>
          <td align="right" class="tdisi"> <a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=14" onClick="NewWindow(this.href,'name','900','500','yes');return false"> 
            <?php echo $rows['unit6']; ?></a></td>
          <td align="right" class="tdisi"><?php echo $rows['total']; ?></td>
          <td align="right" class="tdisi"><?php echo number_format($nilai,0,",","."); ?></td>
        </tr>
        <?php // $jml_tot+=$nilai;
	  }
	 // $jml_tot=0;
	  mysqli_free_result($rs);
	  //$sql2="select sum(ntotal) as jml_tot from vstokall as v,a_kepemilikan as m,a_obat as o where o.OBAT_ID=v.obat_id and m.ID=v.kepemilikan_id".$filter;
	  $sql2="select if (sum(p2.ntotal) is null,0,sum(p2.ntotal)) as jml_tot from (".$sql.") as p2";
	  //echo $sql2."<br>";
	  $rs=mysqli_query($konek,$sql2);
	  $show=mysqli_fetch_array($rs);
	 $jml_tot=$show['jml_tot'];
	  
	  
	  
	  ?>
        <tr>
          <td colspan="2"><span class="style1">Ket:GD=Gudang; AP=Apotik; PR=Produksi; 
            FS=Floor Stock;</span></td>
          <td colspan="6" align="right"><span class="style1"><strong>Nilai Total 
            :&nbsp;&nbsp;</strong></span></td>
          <td colspan="2" align="right"><span class="style1"><strong><?php echo number_format($jml_tot,0,",","."); ?></strong></span></td>
        </tr>
        <tr> 
          <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="5" align="left"><div align="left" class="textpaging">Ke 
              Halaman: 
              <input type="text" name="keHalaman" id="keHalaman" class="txtcenter" size="2" autocomplete="off">
              <button type="button" style="cursor:pointer" onClick="act.value='paging';page.value=+keHalaman.value;document.form1.submit();"><IMG SRC="../icon/go.png" border="0" width="10" height="15" ALIGN="absmiddle"></button>
            </div></td>
          <td colspan="4" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
        <tr> 
          <td colspan="11" align="center"> <BUTTON type="button" onClick="OpenWnd('../master/stokall_print.php?user=<?php echo $username; ?>&filter=<?php echo $jfilter; ?>&sorting=<?php echo $sorting; ?>&kelas=<?php echo $kelas; ?>&golongan=<?php echo $golongan; ?>&jenis=<?php echo $jenis; ?>&kategori=<?php echo $kategori; ?>&k1=<?php echo $k1; ?>&g1=<?php echo $g1; ?>&j1=<?php echo $j1; ?>&f1=<?php echo $f1; ?>',1000,800,'childwnd',true);" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak 
            Stok </BUTTON>
            &nbsp; <BUTTON type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?> onClick="OpenWnd('../master/stokall_Excell.php?filter=<?php echo $jfilter; ?>&sorting=<?php echo $sorting; ?>&kelas=<?php echo $kelas; ?>&golongan=<?php echo $golongan; ?>&jenis=<?php echo $jenis; ?>&kategori=<?php echo $kategori; ?>&k1=<?php echo $k1; ?>&g1=<?php echo $g1; ?>&j1=<?php echo $j1; ?>&f1=<?php echo $f1; ?>',600,450,'childwnd',true);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export 
            ke File Excell</BUTTON></td>
        </tr>
      </table>
    </div>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
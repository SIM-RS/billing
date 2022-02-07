<?php 
// Koneksi =================================
include("../sesi.php"); 
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_d=$_REQUEST['tgl_d'];
if ($tgl_d=="")	$tgl_d=$tgl;
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$tgl_s=$_REQUEST['tgl_s'];
if ($tgl_s=="")	$tgl_s=$tgl;
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";

?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <div id="listma" style="display:block">
      <p><span class="jdltable">LAPORAN TOTAL PEMAKAIAN OBAT / ALKES RUANGAN</span></p>
		
      <table width="500" align="center">
        <tr> 
          <td align="center" class="txtinput">UNIT FARMASI <input type="hidden" id="unit_farmasi" name="unit_farmasi" value="<?php echo $idunit; ?>"></td>
          <td align="center" class="txtinput">: 
		  <select name="unit_farmasi" id="unit_farmasi" class="txtinput">
              <option value="" class="txtinput" style="font-style:italic; font-weight:bold">ALL UNIT</option>
			  <?
		  $qry="SELECT * FROM a_unit WHERE UNIT_TIPE=2 AND UNIT_ISAKTIF=1 ORDER BY UNIT_NAME";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
		  	$i++;
			if (($idunit1=="")&&($i==1)) $idunit1=$show['UNIT_ID'];
		  ?>
              <option value="<?=$show['UNIT_ID'];?>" class="txtinput" <?php if($idunit==$show['UNIT_ID']) echo "selected"; ?>><?php echo $show['UNIT_NAME'];?></option>
          <? }?>
          </select>
          </td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">KEPEMILIKAN </td>
          <td align="center" class="txtinput">: 
            <select name="kepemilikan_id" id="kepemilikan_id" class="txtinput">
              <option value="" class="txtinput" style="font-style:italic; font-weight:bold">SEMUA</option>
              <?php
              $sql = "select * from a_kepemilikan";
			  $qsql = mysqli_query($konek,$sql);
			  while($data=mysqli_fetch_array($qsql)){
              ?>
              <option value="<?php echo $data['ID']; ?>" class="txtinput"><?php echo $data['NAMA']; ?></option>
              <?php
			  }
			  ?>
           </select></td>
        </tr>
        <tr style="display:none"> 
          <td align="center" class="txtinput">RUANGAN </td>
          <td align="center" class="txtinput">: 
            <select name="idunit" id="idunit" class="txtinput">
              <option value="" class="txtinput" style="font-style:italic; font-weight:bold">SEMUA</option>
			  <?
		  $qry="SELECT * FROM a_unit WHERE UNIT_TIPE=3 AND UNIT_ISAKTIF=1 ORDER BY UNIT_NAME";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
		  	$i++;
			if (($idunit1=="")&&($i==1)) $idunit1=$show['UNIT_ID'];
		  ?>
              <option value="<?=$show['UNIT_ID'];?>" class="txtinput"><?php echo $show['UNIT_NAME'];?></option>
          <? }?>
          </select></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">GOLONGAN </td>
          <td align="center" class="txtinput">: 
            <select name="golongan_id" id="golongan_id" class="txtinput">
              <option value="" class="txtinput" style="font-style:italic; font-weight:bold">SEMUA</option>
              <?php
              $sql = "select * from a_obat_golongan order by golongan";
			  $qsql = mysqli_query($konek,$sql);
			  while($gol=mysqli_fetch_array($qsql)){
              ?>
              <option value="<?php echo $gol['kode']; ?>" class="txtinput"><?php echo $gol['golongan']; ?></option>
              <?php
			  }
			  ?>
           </select></td>
        </tr>
         <tr> 
          <td align="center" class="txtinput">PERIODE </td>
          <td align="center" class="txtinput">: 
            <select name="tipe_lap" id="tipe_lap" class="txtinput" onChange="changeTipe(this.value);">
              <option value="1" class="txtinput">PER TANGGAL</option>
              <option value="2" class="txtinput">BULANAN</option>
           </select></td>
        </tr>
        <tr id="trTanggal"> 
          <td colspan="2"> <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/> 
            &nbsp;s/d 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/> 
            <button type="submit" style="cursor:pointer"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
        </tr>
        <tr id="trBulan" style="display:none"> 
          <td colspan="2">
          <?php
		  $bl=date('m');
		  ?>
          	<select class="txtinput" id="bln1" name="bln1">
            	<option value="01" <?php if($bl=='01') echo "selected"; ?> >Januari</option>
                <option value="02" <?php if($bl=='02') echo "selected"; ?> >Pebruari</option>
                <option value="03" <?php if($bl=='03') echo "selected"; ?> >Maret</option>
                <option value="04" <?php if($bl=='04') echo "selected"; ?> >April</option>
                <option value="05" <?php if($bl=='05') echo "selected"; ?> >Mei</option>
                <option value="06" <?php if($bl=='06') echo "selected"; ?> >Juni</option>
                <option value="07" <?php if($bl=='07') echo "selected"; ?> >Juli</option>
                <option value="08" <?php if($bl=='08') echo "selected"; ?> >Agustus</option>
                <option value="09" <?php if($bl=='09') echo "selected"; ?> >September</option>
                <option value="10" <?php if($bl=='10') echo "selected"; ?> >Oktober</option>
                <option value="11" <?php if($bl=='11') echo "selected"; ?> >Nopember</option>
                <option value="12" <?php if($bl=='12') echo "selected"; ?> >Desember</option>
            </select><select class="txtinput" id="thn1" name="thn1">
            	<?php
				$ta=date('Y');
				for($i=$ta-10;$i<=$ta;$i++){
				?>
            	<option value="<?php echo $i; ?>" <?php if($ta==$i) echo "selected"; ?> ><?php echo $i; ?></option>
                <?php
				}
				?>
            </select>
            &nbsp;s/d&nbsp;<select class="txtinput" id="bln2" name="bln2">
            <?php
		  	$bl=date('m');
		  	?>
            	<option value="01" <?php if($bl=='01') echo "selected"; ?> >Januari</option>
                <option value="02" <?php if($bl=='02') echo "selected"; ?> >Pebruari</option>
                <option value="03" <?php if($bl=='03') echo "selected"; ?> >Maret</option>
                <option value="04" <?php if($bl=='04') echo "selected"; ?> >April</option>
                <option value="05" <?php if($bl=='05') echo "selected"; ?> >Mei</option>
                <option value="06" <?php if($bl=='06') echo "selected"; ?> >Juni</option>
                <option value="07" <?php if($bl=='07') echo "selected"; ?> >Juli</option>
                <option value="08" <?php if($bl=='08') echo "selected"; ?> >Agustus</option>
                <option value="09" <?php if($bl=='09') echo "selected"; ?> >September</option>
                <option value="10" <?php if($bl=='10') echo "selected"; ?> >Oktober</option>
                <option value="11" <?php if($bl=='11') echo "selected"; ?> >Nopember</option>
                <option value="12" <?php if($bl=='12') echo "selected"; ?> >Desember</option>
            </select><select class="txtinput" id="thn2" name="thn2">
            	<?php
				$ta=date('Y');
				for($i=$ta-10;$i<=$ta;$i++){
				?>
            	<option value="<?php echo $i; ?>" <?php if($ta==$i) echo "selected"; ?> ><?php echo $i; ?></option>
                <?php
				}
				?>
            </select>
            <button type="submit" style="cursor:pointer">  
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
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
<script>
function changeTipe(par){
	if(par=='1'){
		document.getElementById('trTanggal').style.display = 'table-row';
		document.getElementById('trBulan').style.display = 'none';
		document.form1.target = 'rpt_per_tanggal_pemakaian_obat';
		document.form1.action = 'rpt_per_tanggal_pemakaian_obat.php';
	}
	else if(par=='2'){
		document.getElementById('trBulan').style.display = 'table-row';
		document.getElementById('trTanggal').style.display = 'none';
		document.form1.target = 'rpt_per_bulan_pemakaian_obat';
		document.form1.action = 'rpt_per_bulan_pemakaian_obat.php';
	}
}
changeTipe(1);
</script>
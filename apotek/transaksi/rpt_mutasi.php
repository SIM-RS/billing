<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_d=explode("-",$tgl);
$ta=$tgl_d[2];
$bulan=(substr($tgl_d[1],0,1)=="0")?substr($tgl_d[1],1,1):$tgl_d[1];
$tgl_d='01-'.$tgl_d[1].'-'.$tgl_d[2];

convert_var($ta,$tgl_d);
//$tgl_d1=explode("-",$tgl_d);
//$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
//$tgl_s=$_REQUEST['tgl_s'];
$tgl_s=$tgl;
//$tgl_s1=explode("-",$tgl_s);
//$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
//$th=explode("-",$tgl);
//$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan emperkenalkan untuk melakukan ACT===
$idunit1=$_REQUEST['idunit'];
convert_var($idunit1);
if ($idunit1=="") $idunit1=$idunit;
//echo $idunit1."<br>";
//$kelas=$_REQUEST['kelas'];if ($kelas=="") $fkelas=""; else{ if ($idunit1=="0") $fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'"; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";}
//$golongan=$_REQUEST['golongan'];if ($golongan=="") $fgolongan=""; else{ if (($idunit1=="0")&&($kelas=="")) $fgolongan=" WHERE ao.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";}
//$jenis=$_REQUEST['jenis'];if ($jenis=="") $fjenis=""; else { if (($idunit1=="0")&&($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE ao.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";}
$kategori='';

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="t6.OBAT_NAMA,t6.KEPEMILIKAN_ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
convert_var($page,$sorting,$filter,$act);
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
function PrintArea(fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
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
	src="../theme/sort1.php" scrolling="no"
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
      <p><span class="jdltable">LAPORAN MUTASI OBAT</span></p>
		
      <table>
        <tr> 
          <td align="center"><span class="txtinput">Unit </span> </td>
          <td align="left">: 
            <select name="idunit" id="idunit" class="txtinput">
              <option value="0" label="ALL UNIT" class="txtinput"<?php if ($idunit1=="0") echo "selected";?>>ALL 
              UNIT</option>
              <?
		  $qry="select * from a_unit where (UNIT_TIPE<>3 AND UNIT_TIPE<>4) and UNIT_ISAKTIF=1 AND UNIT_ID NOT IN(8,9)";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
		  	$i++;
			if (($idunit1=="")&&($i==1)) $idunit1=$show['UNIT_ID'];
		  ?>
              <option value="<?php echo $show['UNIT_ID'];?>" label="<?php echo $show['UNIT_NAME'];?>" class="txtinput"<?php if ($idunit1==$show['UNIT_ID']) echo "selected";?>> 
              <?php echo $show['UNIT_NAME'];?></option>
              <? }?>
            </select> </td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center"><span class="txtinput">Kepemilikan</span></td>
          <td align="left">: 
            <select name="kpid" id="kpid" class="txtinput">
              <option value="0" label="SEMUA" class="txtinput">SEMUA</option>
              <?
			  $kpid1="SEMUA";
		  $qry="SELECT * FROM a_kepemilikan WHERE AKTIF=1";
		  $exe=mysqli_query($konek,$qry);
		  while($show=mysqli_fetch_array($exe)){ 
			$tmp=$show['NAMA'];
		  ?>
              <option value="<?php echo $show['ID'];?>" label="<?php echo $tmp;?>" class="txtinput"><?php echo $tmp;?></option>
              <? }?>
            </select></td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center"><span class="txtinput">Kelas </span></td>
          <td colspan="2" align="left">: 
            <select name="kelas" id="kelas" class="txtinput">
              <option value="" label="SEMUA" class="txtinput"<?php if ($kelas=="") echo " selected";?>>SEMUA</option>
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
              <option value="<?php echo $show['KLS_KODE'];?>" label="<?php echo $tmp;?>" class="txtinput"<?php if ($kelas==$show['KLS_KODE']){echo " selected";$k1=$show['KLS_NAMA'];}?>><?php echo $tmp;?></option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td align="center"><span class="txtinput">Golongan</span></td>
          <td align="left">: 
            <select name="golongan" id="golongan" class="txtinput">
              <option value="" label="SEMUA" class="txtinput"<?php if ($golongan==""){echo " selected";$g1="SEMUA";}?>>SEMUA</option>
              <option value="N" label="Narkotika" class="txtinput"<?php if ($golongan=="N"){echo " selected";$g1="Narkotika";}?>>Narkotika</option>
              <option value="P" label="Pethidine" class="txtinput"<?php if ($golongan=="P"){echo " selected";$g1="Pethidine";}?>>Pethidine</option>
              <option value="M" label="Morphine" class="txtinput"<?php if ($golongan=="M"){echo " selected";$g1="Morphine";}?>>Morphine</option>
              <option value="Psi" label="Psikotropika" class="txtinput"<?php if ($golongan=="Psi"){echo " selected";$g1="Psikotropika";}?>>Psikotropika</option>
              <option value="B" label="Obat Bebas" class="txtinput"<?php if ($golongan=="B"){echo " selected";$g1="Obat Bebas";}?>>Obat 
              Bebas</option>
              <option value="BT" label="Bebas Terbatas" class="txtinput"<?php if ($golongan=="BT"){echo " selected";$g1="Bebas Terbatas";}?>>Bebas 
              Terbatas</option>
              <option value="K" label="Obat Keras" class="txtinput"<?php if ($golongan=="K"){echo " selected";$g1="Obat Keras";}?>>Obat 
              Keras</option>
              <option value="AK" label="Alkes" class="txtinput"<?php if ($golongan=="AK"){echo " selected";$g1="Alkes";}?>>Alkes</option>
            </select></td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center" class="txtcenter">Jenis</td>
          <td align="center" class="txtinput">: &nbsp;<select name="jenis" id="jenis" class="txtinput">
              <option value="" label="SEMUA" class="txtinput">SEMUA</option>
              <?php 
			  $j1="SEMUA";
			  $sql="select * from a_obat_jenis";
			  $rs=mysqli_query($konek,$sql);
			  while ($rows=mysqli_fetch_array($rs)){
			  ?>
              <option value="<?php echo $rows['obat_jenis_id']; ?>" label="<?php echo $rows['obat_jenis']; ?>" class="txtinput"<?php if ($jenis==$rows['obat_jenis_id']){echo " selected";$j1=$rows['obat_jenis'];}?>><?php echo $rows['obat_jenis']; ?></option>
              <?php }?>
            </select></td>
          <td align="center" class="txtinput">&nbsp;</td>
        </tr>
		<tr>
			<td align="center" class="txtinput">Kategori Obat</td>
			<td align="center" class="txtinput">:&nbsp;
				<select name="kategori" id="kategori" class="txtinput" onChange="location='?f=buku_penjualan.php&idunit='+idunit.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&kategori='+kategori.value+'&bentuk='+bentuk.valuk" >
				<option value="" class="txtinput"<?php if ($kategori==""){echo " selected";$f1="SEMUA";}?>>SEMUA</option>
				  <?php 
				  $j1="SEMUA";
				  $sql="select * from a_obat_kategori";
				  $rs=mysqli_query($konek,$sql);
				  while ($rows=mysqli_fetch_array($rs)){
				  ?>
				  <option value="<?php echo $rows['id']; ?>" class="txtinput"<?php if ($kategori==$rows['id']){echo " selected";$f1=$rows['kategori'];}?>><?php echo $rows['kategori']; ?></option>
				  <?php }?>
				</select>
			</td>
		</tr>
		<tr>
			<td align="center" class="txtinput">Bentuk Obat</td>
			<td align="center" class="txtinput">:&nbsp;
				<select name="bentuk" id="bentuk" class="txtinput" onChange="location='?f=buku_penjualan.php&idunit='+idunit.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&kategori='+kategori.value+'&bentuk='+bentuk.valuk" >
				<option value="" class="txtinput"<?php if ($bentuk==""){echo " selected";$f1="SEMUA";}?>>SEMUA</option>
				  <?php 
				  $j1="SEMUA";
				  $sql="select * from a_bentuk";
				  $rs=mysqli_query($konek,$sql);
				  while ($rows=mysqli_fetch_array($rs)){
				  ?>
				  <option value="<?php echo $rows['BENTUK']; ?>" class="txtinput"<?php if ($bentuk==$rows['BENTUK']){echo " selected";$f1=$rows['BENTUK'];}?>><?php echo $rows['BENTUK']; ?></option>
				  <?php }?>
				</select>
			</td>
		</tr>
        <tr>
          <td colspan="3" align="center" class="txtcenter">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" class="txtcenter">Kategori</td>
          <td align="center" class="txtinput">: &nbsp;<select name="periode" id="periode" class="txtinput" onChange="if (this.value==2){document.getElementById('trperiode').style.visibility='visible'}else{document.getElementById('trperiode').style.visibility='collapse'}">
              <option value="1" class="txtinput">Bulanan</option>
              <option value="2" class="txtinput">Periode</option>
            </select></td>
          <td align="center" class="txtinput">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" class="txtinput">&nbsp;</td>
          <td colspan="2" align="left">&nbsp;&nbsp;<select name="bulan" id="bulan" class="txtinput">
              <option value="1" label="Januari"<?php if ($bulan==1) echo " selected";?> class="txtinput">Januari</option>
              <option value="2" label="Pebruari"<?php if ($bulan==2) echo " selected";?> class="txtinput">Pebruari</option>
              <option value="3" label="Maret"<?php if ($bulan==3) echo " selected";?> class="txtinput">Maret</option>
              <option value="4" label="April"<?php if ($bulan==4) echo " selected";?> class="txtinput">April</option>
              <option value="5" label="Mei"<?php if ($bulan==5) echo " selected";?> class="txtinput">Mei</option>
              <option value="6" label="Juni"<?php if ($bulan==6) echo " selected";?> class="txtinput">Juni</option>
              <option value="7" label="Juli"<?php if ($bulan==7) echo " selected";?> class="txtinput">Juli</option>
              <option value="8" label="Agustus"<?php if ($bulan==8) echo " selected";?> class="txtinput">Agustus</option>
              <option value="9" label="September"<?php if ($bulan==9) echo " selected";?> class="txtinput">September</option>
              <option value="10" label="Oktober"<?php if ($bulan==10) echo " selected";?> class="txtinput">Oktober</option>
              <option value="11" label="Nopember"<?php if ($bulan==11) echo " selected";?> class="txtinput">Nopember</option>
              <option value="12" label="Desember"<?php if ($bulan==12) echo " selected";?> class="txtinput">Desember</option>
            </select>&nbsp;<select name="tahun" id="tahun" class="txtinput">
            <?php for ($i=1;$i<7;$i++){?>
              <option value="<?php echo $ta+$i-5; ?>" class="txtinput"<?php if ($i==5) echo " selected";?>><?php echo $ta+$i-5; ?></option>
            <?php }?>
            </select></td>
        </tr>
        <tr id="trperiode" style="visibility:collapse">
          <td align="right" class="txtright">s/d</td>
          <td colspan="2" align="left">&nbsp;&nbsp;<select name="bulan1" id="bulan1" class="txtinput">
              <option value="1" label="Januari"<?php if ($bulan==1) echo " selected";?> class="txtinput">Januari</option>
              <option value="2" label="Pebruari"<?php if ($bulan==2) echo " selected";?> class="txtinput">Pebruari</option>
              <option value="3" label="Maret"<?php if ($bulan==3) echo " selected";?> class="txtinput">Maret</option>
              <option value="4" label="April"<?php if ($bulan==4) echo " selected";?> class="txtinput">April</option>
              <option value="5" label="Mei"<?php if ($bulan==5) echo " selected";?> class="txtinput">Mei</option>
              <option value="6" label="Juni"<?php if ($bulan==6) echo " selected";?> class="txtinput">Juni</option>
              <option value="7" label="Juli"<?php if ($bulan==7) echo " selected";?> class="txtinput">Juli</option>
              <option value="8" label="Agustus"<?php if ($bulan==8) echo " selected";?> class="txtinput">Agustus</option>
              <option value="9" label="September"<?php if ($bulan==9) echo " selected";?> class="txtinput">September</option>
              <option value="10" label="Oktober"<?php if ($bulan==10) echo " selected";?> class="txtinput">Oktober</option>
              <option value="11" label="Nopember"<?php if ($bulan==11) echo " selected";?> class="txtinput">Nopember</option>
              <option value="12" label="Desember"<?php if ($bulan==12) echo " selected";?> class="txtinput">Desember</option>
            </select>&nbsp;<select name="tahun1" id="tahun1" class="txtinput">
            <?php for ($i=1;$i<7;$i++){?>
              <option value="<?php echo $ta+$i-5; ?>" class="txtinput"<?php if ($i==5) echo " selected";?>><?php echo $ta+$i-5; ?></option>
            <?php }?>
            </select></td>
        </tr>
        <tr> 
          <td colspan="3"><BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            <BUTTON type="button" onClick="BukaWndExcell(1);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export 
            ke File Excell</BUTTON>&nbsp;<!--BUTTON type="button" onClick="BukaWndExcell(2);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export 
            ke File Excell (+Nilai)</BUTTON--></td>
        </tr>
      </table>	  
    </div>
</form>
</div>
</body>
<script>
function HProsen(a,b,c,d){
var e;
	//alert(b.value+'|'+c.value+'|'+d.value);
	if (a==1){
		e=b.value*c.value/100;
		d.value=(b.value)*1+e;
	}else if (a==2){
		e=((d.value)*1-(b.value)*1)*100/b.value;
		c.value=e;
	}
}

function BukaWndExcell(p){
//alert(bulan.value);
var tipe=document.getElementById('periode').value;
var bulan=document.getElementById('bulan').value;
var bentuk=document.getElementById('bentuk').value;
var bulann=document.getElementById('bulan').options[document.getElementById('bulan').options.selectedIndex].label;
var bulan1=document.getElementById('bulan1').value;
var bulan1n=document.getElementById('bulan1').options[document.getElementById('bulan1').options.selectedIndex].label;
var tahun=document.getElementById('tahun').value;
var tahun1=document.getElementById('tahun1').value;
var idunit1=idunit.value;
var fkpid=kpid.value;
var k1=kelas.options[kelas.options.selectedIndex].label;
var g1=golongan.options[golongan.options.selectedIndex].label;
var j1=jenis.options[jenis.options.selectedIndex].label;
var kpid1=kpid.options[kpid.options.selectedIndex].label;
	//alert('../transaksi/rpt_mutasi_excell.php?tipe='+tipe+'&bulan='+bulan+'&tahun='+tahun+'&bulan1='+bulan1+'&tahun1='+tahun1+'&idunit1='+idunit1+'&kpid='+fkpid+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kpid1='+kpid1+'&k1='+k1+'&g1='+g1+'&j1='+j1);
	if (p==1){
		OpenWnd('../transaksi/rpt_mutasi_excell.php?tipe='+tipe+'&bulan='+bulan+'&bulann='+bulann+'&tahun='+tahun+'&bulan1='+bulan1+'&bulan1n='+bulan1n+'&tahun1='+tahun1+'&idunit1='+idunit1+'&kpid='+fkpid+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kpid1='+kpid1+'&k1='+k1+'&g1='+g1+'&j1='+j1+'&kategori='+kategori.value+'&bentuk='+bentuk,600,450,'childwnd',true);
	}else if (p==2){
		OpenWnd('../transaksi/rpt_mutasi_nilai_excell.php?tipe='+tipe+'&bulan='+bulan+'&bulann='+bulann+'&tahun='+tahun+'&bulan1='+bulan1+'&bulan1n='+bulan1n+'&tahun1='+tahun1+'&idunit1='+idunit1+'&kpid='+fkpid+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kpid1='+kpid1+'&k1='+k1+'&g1='+g1+'&j1='+j1+'&bentuk='+bentuk,600,450,'childwnd',true);
	}
}
</script>
</html>
<?php 
mysqli_close($konek);
?>
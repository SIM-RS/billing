<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_REQUEST['idunit'];
$idunit1=$_SESSION["ses_idunit"];
if ($idunit=="") $idunit=$idunit1;
$obat_id=$_REQUEST['obat_id'];
$kepemilikan_id=$_REQUEST['kepemilikan_id'];
$idminmax=$_REQUEST['idminmax'];
$smin=$_REQUEST['smin'];
$smax=$_REQUEST['smax'];
$kelas=$_REQUEST['kelas'];if ($kelas=="") $fkelas=""; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";
/* $golongan=$_REQUEST['golongan'];if ($golongan=="") $fgolongan=""; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";
$jenis=$_REQUEST['jenis'];if ($jenis=="") $fjenis=""; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";
$kategori=$_REQUEST['kategori'];if ($kategori=="") $fkategori=""; else $fkategori=" AND ao.OBAT_KATEGORI=$kategori";
$stok_S = $_REQUEST['stok_S']; */
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ao.OBAT_NAMA,ak.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
//Aksi Save, Edit, Delete Berakhir ============================================
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<style type="text/css">
	body{
		background:#EAF0F0;
	}
</style>
</head>
<body>
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

<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="idminmax" id="idminmax" type="hidden" value="">
  <input name="smin" id="smin" type="hidden" value="">
  <input name="smax" id="smax" type="hidden" value="">
  <input name="obat_id" id="obat_id" type="hidden" value="">
  <input name="kepemilikan_id" id="kepemilikan_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <div id="listma" style="display:block">
<p><span class="jdltable">DAFTAR STOK OBAT / ALKES</span> 
      <table>
		<?php
        /*<tr>
          <td align="center" class="txtinput">Kategori</td>
          <td align="center" class="txtinput">:
            <select name="kategori" id="kategori" class="txtinput" onChange="location='?f=../transaksi/list_obat_bill.php&idunit='+idunit.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&stok_S='+stok_S.value">
            <option value="" class="txtinput"<?php if ($kategori==""){echo " selected";$f1="SEMUA";}?>>SEMUA</option>
              <?php 
			  $j1="SEMUA";
			  $sql="select * from a_obat_kategori";
			  $rs=mysqli_query($konek,$sql);
			  while ($rows=mysqli_fetch_array($rs)){
			  ?>
              <option value="<?php echo $rows['id']; ?>" class="txtinput"<?php if ($kategori==$rows['id']){echo " selected";$f1=$rows['kategori'];}?>><?php echo $rows['kategori']; ?></option>
              <?php }?>
            </select></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Golongan </td>
          <td align="center" class="txtinput">: 
            <select name="golongan" id="golongan" class="txtinput" onChange="location='?f=../transaksi/list_obat_bill.php&idunit='+idunit.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&stok_S='+stok_S.value">
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
            <select name="jenis" id="jenis" class="txtinput" onChange="location='?f=../transaksi/list_obat_bill.php&idunit='+idunit.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&stok_S='+stok_S.value">
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
		<tr>
			<td align="center" class="txtinput">Stok</td>
			<td align="center" class="txtinput">:
				<select name="stok_S" id="stok_S" onChange="location='?f=../transaksi/list_obat_bill.php&idunit='+idunit.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&stok_S='+stok_S.value">
					<option value="0" <?php echo ($_REQUEST['stok_S']=='0')?'selected':''; ?>>Kosong</option>
					<option value="1" <?php echo ($_REQUEST['stok_S']=='1' || $_REQUEST['stok_S']=="")?'selected':''; ?> >Ada</option>
				</select>
			</td>
		</tr>*/
		?>
      </table>	  
      <table width="98%" border="0" cellpadding="1" cellspacing="0">
		<tr> 
          <td align="center" colspan="2" class="txtinput">Unit </td>
          <td align="center" colspan="4" class="txtinput">: 
            <select name="idunit" id="idunit" class="txtinput" disabled onChange="location='?f=../transaksi/list_obat_bill.php&idunit='+idunit.value+'&kelas='+kelas.value">
              <?php
		  $qry="select * from a_unit where UNIT_TIPE=2 AND UNIT_ISAKTIF=1";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
		  	$i++;
			if (($idunit=="")&&($i==1)) $idunit=$show['UNIT_ID'];
		  ?>
              <option value="<?=$show['UNIT_ID'];?>" class="txtinput"<?php if ($idunit==$show['UNIT_ID']) {echo "selected"; $nunit1=$show['UNIT_NAME'];}?>> 
              <?php echo $show['UNIT_NAME'];?></option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td align="center" colspan="2" class="txtinput">Kelas </td>
          <td align="center" colspan="4" class="txtinput">: 
            <select name="kelas" id="kelas" class="txtinput" onChange="location='?f=../transaksi/list_obat_bill.php&idunit='+idunit.value+'&kelas='+kelas.value+'&kepemilikan=<?php echo $_REQUEST['kepemilikan']; ?>'">
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
			<td colspan="6">&nbsp;</td>
		</tr>
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat </td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat </td>
          <td id="kategori" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kategori</td>
          <!--td id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td-->
          <td id="QTY_STOK" width="65" class="tblheader" onClick="ifPop.CallFr(this);">Stok</td>
	<?php
        /*<td width="65" class="tblheader">Min 
            Stok </td>
          <td width="65" class="tblheader">Max 
            Stok </td>
          <td id="nilai" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Nilai</td>
        </tr>*/
	?>
        <?php 
	  $jfilter="";
	  if ($filter!=""){
	  	$jfilter=$filter;
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  /*$sql="SELECT ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ak.ID,ak.NAMA,ap.QTY_STOK,ap.nilai 
FROM (SELECT OBAT_ID,KEPEMILIKAN_ID,SUM(QTY_STOK) AS QTY_STOK,IF(TIPE_TRANS=4,SUM(FLOOR(QTY_STOK*HARGA_BELI_SATUAN)),SUM(FLOOR((QTY_STOK*HARGA_BELI_SATUAN-(DISKON*QTY_STOK*HARGA_BELI_SATUAN/100)) * 1.1))) AS nilai 
FROM a_penerimaan WHERE UNIT_ID_TERIMA=$idunit AND STATUS=1 AND QTY_STOK>0 
GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS ap INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON ap.KEPEMILIKAN_ID=ak.ID 
LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID WHERE ao.OBAT_ISAKTIF=1".$filter.$fkelas.$fgolongan.$fjenis.$fkategori." 
ORDER BY ".$sorting;*/
		$fil = " AND (ap.QTY_STOK<>0 OR ap.QTY_STOK=0)";
		/* if($_REQUEST['stok_S']=='0'){
			$fil = " AND ap.QTY_STOK=0";
		} */
	  /* $sql="SELECT ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ok.kategori,ak.ID,ak.NAMA,ap.QTY_STOK,ap.nilai 
FROM (SELECT OBAT_ID,KEPEMILIKAN_ID,SUM(QTY_STOK) AS QTY_STOK,SUM(IF(((TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100) OR (NILAI_PAJAK<=0)),(/* FLOOR (QTY_STOK*HARGA_BELI_SATUAN * (1 - (`DISKON` / 100)))),(/* FLOOR ((QTY_STOK*HARGA_BELI_SATUAN-(DISKON*QTY_STOK*HARGA_BELI_SATUAN/100)) * 1.1)))) AS nilai 
FROM a_penerimaan WHERE UNIT_ID_TERIMA=$idunit AND STATUS=1 AND QTY_STOK>=0 
GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS ap INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON ap.KEPEMILIKAN_ID=ak.ID 
LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID
LEFT JOIN a_obat_kategori ok ON ok.id = ao.OBAT_KATEGORI
WHERE ao.OBAT_ISAKTIF=1".$fil.$filter.$fkelas." 
ORDER BY ".$sorting; */
	$sql = "SELECT 
  ao.OBAT_ID,
  ao.OBAT_KODE,
  ao.OBAT_NAMA,
  ao.OBAT_SATUAN_KECIL,
  /* SUM(ap.QTY_STOK) QTY_STOK, */
  ok.kategori
FROM
  a_obat ao 
  /* LEFT JOIN a_penerimaan ap 
    ON ap.OBAT_ID = ao.OBAT_ID  */
  LEFT JOIN a_kelas kls 
    ON ao.KLS_ID = kls.KLS_ID 
  LEFT JOIN a_obat_kategori ok 
    ON ok.id = ao.OBAT_KATEGORI
  /* INNER JOIN a_kepemilikan ak 
    ON ap.KEPEMILIKAN_ID=ak.ID */
WHERE ao.OBAT_ISAKTIF = 1 
  AND (ao.OBAT_KODE <> '' AND ao.OBAT_NAMA <> '') 
  /*AND ap.UNIT_ID_TERIMA = '{$idunit}' */
  {$filter}{$fkelas}
GROUP BY ao.OBAT_ID,
  ao.KEPEMILIKAN_ID 
ORDER BY ao.OBAT_NAMA";
	  //echo $sql;
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";
	  $ckp_id = $_REQUEST['kepemilikan'];
	  $rs=mysqli_query($konek,$sql2);
	  $i=($page-1)*$perpage;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$cid=$rows['OBAT_ID'];
		$ckpid=$rows['ID'];
		$sql="SELECT IFNULL(SUM(qty_stok),0) QTY_STOK FROM $dbapotek.a_stok WHERE unit_id=$idunit AND obat_id=$cid AND kepemilikan_id=$ckp_id";
		$rsSt = mysqli_query($konek,$sql);
		$rwSt = mysqli_fetch_array($rsSt);
		/* $sql2="SELECT * FROM a_min_max_stok WHERE obat_id=$cid AND kepemilikan_id=$ckpid AND unit_id=$idunit";
		$rs1=mysqli_query($konek,$sql2);
		$idminmax=0;
		$stokmin=0;
		$stokmax=0;
		if ($rows1=mysqli_fetch_array($rs1)){
			$idminmax=$rows1["min_max_id"];
			$stokmin=$rows1["min_stok"];
			$stokmax=$rows1["max_stok"];
		} */
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onclick="fSetValue(window.opener,'idObat*-*<?php echo $cid; ?>*|*txtNmObat*-*<?php echo str_replace("'","",str_replace('"',"",$rows['OBAT_NAMA'])); ?>'); window.close();"> 
          <td height="20" class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left" ><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['kategori']; ?></td>
          <!--td class="tdisi"><?php //echo $rows['NAMA']; ?></td-->
          <td class="tdisi"><?php echo $rwSt['QTY_STOK'];?></td>
    <?php
		  /*<td class="tdisi"><span title="Klik Untuk Mengubah Data Stok Minimum" class="minmax" onClick="<?php if ($idunit==$idunit1){?>var vsmin = prompt('Masukkan Stok Minimum', '<?php echo $stokmin; ?>');if (vsmin!=null){document.getElementById('idminmax').value='<?php echo $idminmax; ?>';document.getElementById('smin').value=vsmin;document.getElementById('smax').value='<?php echo $stokmax; ?>';document.getElementById('kepemilikan_id').value='<?php echo $ckpid; ?>';document.getElementById('obat_id').value='<?php echo $cid; ?>';document.forms[0].submit();}<?php }else{?>alert('Anda Tidak Boleh Mengubah Data Stok Minimum Unit Lain');<?php }?>"><?php echo $stokmin;?></span></td>
          <td class="tdisi"><span title="Klik Untuk Mengubah Data Stok Minimum" class="minmax" onClick="<?php if ($idunit==$idunit1){?>var vsmax = prompt('Masukkan Stok Maximum', '<?php echo $stokmax; ?>');if (vsmax!=null){document.getElementById('idminmax').value='<?php echo $idminmax; ?>';document.getElementById('smin').value='<?php echo $stokmin; ?>';document.getElementById('smax').value=vsmax;document.getElementById('kepemilikan_id').value='<?php echo $ckpid; ?>';document.getElementById('obat_id').value='<?php echo $cid; ?>';document.forms[0].submit();}<?php }else{?>alert('Anda Tidak Boleh Mengubah Data Stok Maximum Unit Lain');<?php }?>"><?php echo $stokmax;?></span></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['nilai'],0,",",".");?></td>*/
	?>
        </tr>
        <?php 
	  }
	  //$ntotal=0;
	  //$sql2="select if (sum(p2.nilai) is null,0,sum(p2.nilai)) as ntotal from (".$sql.") as p2";
	  //echo $sql2."<br>";
	  //$rs=mysqli_query($konek,$sql2);
	  //if ($rows=mysqli_fetch_array($rs)) $ntotal=$rows['ntotal'];
	  //mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="1" align="left"><div align="left" class="textpaging">Ke Halaman:
		  <input type="text" name="keHalaman" id="keHalaman" class="txtcenter" size="2" autocomplete="off">
		  <button type="button" style="cursor:pointer" onClick="act.value='paging';page.value=+keHalaman.value;document.form1.submit();"><IMG SRC="../icon/go.png" border="0" width="10" height="15" ALIGN="absmiddle"></button></div></td>
          <td colspan="2" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
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
</script>
</html>
<?php 
mysqli_close($konek);
?>
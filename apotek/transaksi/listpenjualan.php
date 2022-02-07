<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_REQUEST['idunit'];
$idunit1=$_SESSION["ses_idunit"];
if ($idunit=="") $idunit=$idunit1;
$obat_id=$_REQUEST['obat_id'];
$kepemilikan_id=$_REQUEST['kepemilikan_id'];
$stok=$_REQUEST['stok'];
$stok1=$_REQUEST['stok1'];
$ket=$_REQUEST['ket'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ao.OBAT_NAMA";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
	case "save":
		$sql="select OBAT_ID from a_penerimaan where OBAT_ID=$obat_id and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$kepemilikan_id limit 1";
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		if ($rows=mysqli_fetch_array($rs)){
			echo "<script>alert('Obat Tersebut Sudah Ada');</script>";
		}else{
			$sql="select * from a_harga where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id";
			$rs=mysqli_query($konek,$sql);
			$hargab=0;
			$hargaj==0;
			if ($rows1=mysqli_fetch_array($rs)){
				$hargab=$rows1["HARGA_BELI_SATUAN"];
				$hargaj=$rows1["HARGA_JUAL_SATUAN"];
			}
			$sql="insert into a_penerimaan(OBAT_ID,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,TANGGAL_ACT,TANGGAL,QTY_SATUAN,QTY_STOK,HARGA_BELI_SATUAN,HARGA_JUAL,TIPE_TRANS,STATUS) values($obat_id,$idunit,$kepemilikan_id,$iduser,now(),'$tgl2',$stok,$stok,$hargab,$hargaj,5,1)";
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
		}
		break;
	case "edit":
		if ($stok1>$stok){
			$selisih=$stok1-$stok;
			$sql="select * from a_penerimaan where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id and UNIT_ID_TERIMA=$idunit and QTY_STOK>0 order by TANGGAL,ID";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			$ok="false";
			while (($rows=mysqli_fetch_array($rs)) && ($ok=="false")){
				$qty=$rows["QTY_STOK"];
				$cid=$rows["ID"];
				if ($qty>$selisih){
					$ok=="true";
					$sql="update a_penerimaan set QTY_STOK=QTY_STOK-$selisih where ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);					
				}else{
					$selisih=$selisih-$qty;
					$sql="update a_penerimaan set QTY_STOK=0 where ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);										
				}
			}
		}else{
			$selisih=$stok-$stok1;
			$sql="select * from a_penerimaan where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id and UNIT_ID_TERIMA=$idunit and QTY_STOK>0 order by TANGGAL,ID desc limit 1";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			if ($rows=mysqli_fetch_array($rs)){
				$cid=$rows["ID"];
				$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$selisih where ID=$cid";
				//echo $sql;
				$rs1=mysqli_query($konek,$sql);					
			}
		}
		break;
/* 	case "delete":
		$sql="delete from a_harga where HARGA_ID=$harga_id";
		$rs=mysqli_query($konek,$sql);
		//echo $sql;
		break; */
}
//Aksi Save, Edit, Delete Berakhir ============================================
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
<p><span class="jdltable">DAFTAR STOK OBAT / ALKES</span> 
      <table width="98%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td width="242"><span class="txtinput">Unit : </span>
            <select name="idunit" id="idunit" class="txtinput" onChange="location='?f=../transaksi/stok_view.php&idunit='+idunit.value">
              <?
		  $qry="select * from a_unit where UNIT_TIPE<>3 and UNIT_ISAKTIF=1";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
		  	$i++;
			if (($idunit=="")&&($i==1)) $idunit=$show['UNIT_ID'];
		  ?>
              <option value="<?=$show['UNIT_ID'];?>" class="txtinput"<?php if ($idunit==$show['UNIT_ID']) echo "selected";?>> <?php echo $show['UNIT_NAME'];?></option>
              <? }?>
            </select></td>
          <td width="677" align="right">
		  <!--BUTTON type="button" onClick="document.getElementById('input').style.display='block'; fSetValue(window,'act*-*save*|*stok*-*')"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON-->
		  </td>
	    </tr>
	</table>
      <table width="98%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat </td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat </td>
          <td id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Pabrik</td>
          <td id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="QTY_STOK" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Stok</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select ao.*,apa.PABRIK,ak.NAMA,sum(ap.QTY_STOK) as QTY_STOK from a_penerimaan ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID left join a_pabrik apa on ao.PABRIK_ID=apa.PABRIK_ID where UNIT_ID_TERIMA=$idunit and ao.OBAT_ISAKTIF=1 and STATUS=1 and QTY_STOK>0".$filter." group by ao.OBAT_ID,ak.ID order by ".$sorting;
	  //echo $sql;
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
	  //echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
		$arfvalue="act*-*edit*|*stok1*-*".$rows['QTY_STOK']."*|*obat_id*-*".$rows['OBAT_ID']."*|*kepemilikan_id*-*".$rows['KEPEMILIKAN_ID']."*|*stok*-*".$rows['QTY_STOK'];
		
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*harga_id*-*".$rows['HARGA_ID'];
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['PABRIK']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['QTY_STOK'];?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="5" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
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
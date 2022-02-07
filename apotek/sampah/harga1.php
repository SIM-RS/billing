<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$harga_id=$_REQUEST['harga_id'];
$obat_id=$_REQUEST['obatid'];
$kepemilikan_id=$_REQUEST['kepemilikan_id'];
$harga_netto=$_REQUEST['harga_netto'];
$untung=$_REQUEST['untung'];
$harga_jual=$_REQUEST['harga_jual'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="HARGA_ID DESC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
	case "save":
		$sql="select * from a_harga where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id";
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		if ($rows=mysqli_fetch_array($rs)){
			echo "<script>alert('Obat Tersebut Sudah Ada Harganya');</script>";
		}else{
			$sql="insert into a_harga(OBAT_ID,KEPEMILIKAN_ID,HARGA_BELI_SATUAN,PROFIT,HARGA_JUAL_SATUAN,TGL_UPDATE,USER_ID) values($obat_id,$kepemilikan_id,$harga_netto,$untung,$harga_jual,now(),$iduser)";
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
		}
		break;
	case "edit":
		$sql="select * from a_harga where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id";
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		if ($rows=mysqli_fetch_array($rs)){
			$idbaru=$rows["HARGA_ID"];
			if ($idbaru==$harga_id){
				$sql="update a_harga set OBAT_ID=$obat_id,KEPEMILIKAN_ID=$kepemilikan_id,HARGA_BELI_SATUAN=$harga_netto,PROFIT=$untung,HARGA_JUAL_SATUAN=$harga_jual,TGL_UPDATE=now(),USER_ID=$iduser where HARGA_ID=$harga_id";
				//echo $sql;
				$rs=mysqli_query($konek,$sql);
			}else{
				echo "<script>alert('Obat Tersebut Sudah Ada Harganya');</script>";			
			}
		}else{
			$sql="update a_harga set OBAT_ID=$obat_id,KEPEMILIKAN_ID=$kepemilikan_id,HARGA_BELI_SATUAN=$harga_netto,PROFIT=$untung,HARGA_JUAL_SATUAN=$harga_jual,TGL_UPDATE=now(),USER_ID=$iduser where HARGA_ID=$harga_id";
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
		}
		break;
	case "delete":
		$sql="delete from a_harga where HARGA_ID=$harga_id";
		$rs=mysqli_query($konek,$sql);
		//echo $sql;
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
var RowIdx;
var fKeyEnt;
function suggest(e,par){
var keywords=par.value;//alert(keywords);
	if(keywords==""){
		document.getElementById('divobat').style.display='none';
	}else{
		var key;
		if(window.event) {
		  key = window.event.keyCode; 
		}
		else if(e.which) {
		  key = e.which;
		}
		//alert(key);
		if (key==38 || key==40){
			var tblRow=document.getElementById('tblObat').rows.length;
			if (tblRow>0){
				//alert(RowIdx);
				if (key==38 && RowIdx>0){
					RowIdx=RowIdx-1;
					document.getElementById(RowIdx+1).className='itemtableReq';
					if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
				}else if (key==40 && RowIdx<tblRow){
					RowIdx=RowIdx+1;
					if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
					document.getElementById(RowIdx).className='itemtableMOverReq';
				}
			}
		}else if (key==13){
			if (RowIdx>0){
				if (fKeyEnt==false){
					fSetObat(document.getElementById(RowIdx).lang);
				}else{
					fKeyEnt=false;
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			RowIdx=0;
			fKeyEnt=false;
			Request('../transaksi/obatlist.php?aKepemilikan=0&idunit=<?php echo $idunit; ?>&aKeyword='+keywords , 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}

function fSetObat(par){
var cdata=par.split("*|*");
var tbl = document.getElementById('tblJual');
var tds;
	document.forms[0].obatid.value=cdata[1];
	document.forms[0].txtObat.value=cdata[2];
	document.getElementById('divobat').style.display='none';
}
</script>
</head>
<body>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="harga_id" id="harga_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none">
      <p class="jdltable">Input Data Harga Obat / Alkes</p>
      <table width="50%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
        <tr> 
          <td width="120">Nama Obat</td>
          <td width="10">:</td>
          <td ><input name="obatid" id="obat_id" type="hidden" value="">
		   <input type="text" name="txtObat" id="obat_nama" class="txtinput" size="65" onKeyUp="suggest(event,this);" autocomplete="off" /></td>
        </tr>
        <tr> 
          <td>Kepemilikan</td>
          <td>:</td>
          <td ><select name="kepemilikan_id" id="kepemilikan_id" class="txtinput">
          <?
		  $qry="select * from a_kepemilikan where aktif=1";
		  $exe=mysqli_query($konek,$qry);
		  while($show=mysqli_fetch_array($exe)){ 
		  ?>
              <option value="<?=$show['ID'];?>" class="txtinput"> <?php echo $show['NAMA'];?></option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td>Harga Netto</td>
          <td>:</td>
          <td ><input name="harga_netto" type="text" class="txtright" id="harga_netto" size="11" maxlength="11" onKeyUp="HProsen(1,harga_netto,untung,harga_jual)" ></td>
        </tr>
        <tr> 
          <td>Keuntungan</td>
          <td>:</td>
          <td ><input name="untung" type="text" class="txtright" id="untung" size="4" maxlength="4" onKeyUp="HProsen(1,harga_netto,untung,harga_jual)" >
            %</td>
        </tr>
        <tr> 
          <td>Harga Jual</td>
          <td>:</td>
          <td ><input name="harga_jual" type="text" class="txtright" id="harga_jual" size="11" maxlength="11" onKeyUp="HProsen(2,harga_netto,untung,harga_jual)" ></td>
        </tr>
      </table>
  <p><BUTTON type="button" onClick="if (ValidateForm('harga_netto,untung,harga_jual','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
      <p><span class="jdltable">DAFTAR HARGA OBAT</span> 
      <table width="98%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td width="242">&nbsp; </td>
          <td width="677" align="right">
		  <BUTTON type="button" onClick="document.getElementById('input').style.display='block'; fSetValue(window,'act*-*save*|*kode_mitra*-**|*nama*-**|*discount*-*')"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON>
		  </td>
	    </tr>
	</table>
      <table width="98%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat </td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat </td>
          <td id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="HARGA_BELI_SATUAN" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Harga<br>
            Netto </td>
          <td id="PROFIT" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Profit<br>(%)</td>
          <td id="harga_j" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Harga<br>Jual </td>
          <td class="tblheader" colspan="2" width="60">Proses</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ah.*,ah.HARGA_BELI_SATUAN+(ah.HARGA_BELI_SATUAN*ah.PROFIT/100) as harga_j,ak.NAMA from a_obat ao inner join a_harga ah on ao.OBAT_ID=ah.OBAT_ID inner join a_kepemilikan ak on ah.KEPEMILIKAN_ID=ak.ID where OBAT_ISAKTIF=1".$filter." order by ".$sorting;
	  //echo $sql;
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";

	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
		$arfvalue="act*-*edit*|*harga_id*-*".$rows['HARGA_ID']."*|*obat_id*-*".$rows['OBAT_ID']."*|*obat_nama*-*".$rows['OBAT_NAMA']."*|*kepemilikan_id*-*".$rows['KEPEMILIKAN_ID']."*|*harga_netto*-*".$rows['HARGA_BELI_SATUAN']."*|*untung*-*".$rows['PROFIT']."*|*harga_jual*-*".$rows['harga_j'];
		
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*harga_id*-*".$rows['HARGA_ID'];
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="right"><?php echo $rows['HARGA_BELI_SATUAN']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['PROFIT']; ?></td>
          <td class="tdisi" align="right"><?php echo $rows['harga_j'];?></td>
          <td width="30" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
          <td width="30" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="6" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
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
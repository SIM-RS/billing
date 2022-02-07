<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$minta_id=$_REQUEST['minta_id'];
$no_minta=$_REQUEST['no_minta'];
$no_gdg=$_REQUEST['no_gdg'];
$no_terima=$_REQUEST['no_terima'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="am.tgl,am.permintaan_id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
 	case "save":
		$fdata=$_REQUEST['fdata'];
		$arfvalue=explode("**",$fdata);
		for ($j=0;$j<count($arfvalue);$j++){
			$arfdata=explode("|",$arfvalue[$j]);
			if ($arfdata[4]>$arfdata[5]){
				$sql="update a_minta_obat set qty_terima=qty_terima+$arfdata[5] where permintaan_id=$arfdata[2]";
				$rs=mysqli_query($konek,$sql);
				$sql="select * from a_minta_obat where permintaan_id=$arfdata[2] and qty>qty_terima";
				$rs=mysqli_query($konek,$sql);
				if ($rows=mysqli_fetch_array($rs)){
					$sql="update a_minta_obat set status=2 where permintaan_id=$arfdata[2]";
					$rs1=mysqli_query($konek,$sql);
				}else{
					$sql="update a_minta_obat set status=3 where permintaan_id=$arfdata[2]";
					$rs1=mysqli_query($konek,$sql);
				}
				$jml=$arfdata[4]-$arfdata[5];
				$sql="select *,QTY_STOK as qty from a_penerimaan where NOKIRIM='$no_gdg' and FK_MINTA_ID=$arfdata[2] and UNIT_ID_TERIMA=$idunit order by ID desc";
				$rs=mysqli_query($konek,$sql);
				$done=0;
				while (($rows=mysqli_fetch_array($rs))&&($done==1)){
					$qty=$rows['qty'];
					$cid=$rows['ID'];
					$pid=$rows['ID_LAMA'];
					if ($qty>$jml){
						$done=1;
						$sql="update a_penerimaan set QTY_SATUAN=QTY_SATUAN-$jml,QTY_STOK=QTY_STOK-$jml where ID=$cid";
						$rs1=mysqli_query($konek,$sql);
						$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$jml where ID=$pid";
						$rs1=mysqli_query($konek,$sql);
					}else if ($qty==$jml){
						$done=1;
						$sql="delete from a_penerimaan where ID=$cid";
						$rs1=mysqli_query($konek,$sql);
						$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$jml where ID=$pid";
						$rs1=mysqli_query($konek,$sql);
					}else{
						$jml=$jml-$qty;
						$sql="delete from a_penerimaan where ID=$cid";
						$rs1=mysqli_query($konek,$sql);
						$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$qty where ID=$pid";
						$rs1=mysqli_query($konek,$sql);
					}
				}
			}
			$sql="update a_penerimaan set STATUS=1 where NOKIRIM='$no_gdg' and FK_MINTA_ID=$arfdata[2] and UNIT_ID_TERIMA=$idunit";
			$rs=mysqli_query($konek,$sql);
		}
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
$sql="select distinct date_format(am.tgl,'%d/%m/%Y') as tgl_minta,date_format(ap.TANGGAL,'%d/%m/%Y') as tgl_gdg from a_penerimaan ap inner join a_minta_obat am on ap.FK_MINTA_ID=am.permintaan_id where am.no_bukti='$no_minta' and ap.NOKIRIM='$no_gdg'";
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	$tgl_minta=$rows["tgl_minta"];
	$tgl_gdg=$rows["tgl_gdg"];
}
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
	<input name="fdata" id="fdata" type="hidden" value="">
	<input name="no_minta" id="no_minta" type="hidden" value="<?php echo $no_minta; ?>">
	<input name="no_gdg" id="no_gdg" type="hidden" value="<?php echo $no_gdg; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <div id="listma" style="display:block">
      <p><span class="jdltable">DETAIL PENGIRIMAN GUDANG</span></p>
	  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="120">No Penerimaan</td>
          <td width="290">: <?php echo $no_terima; ?></td>
          <td width="112">No Permintaan</td>
          <td width="215">: <?php echo $no_minta; ?></td>
          <td width="124">No Kirim Gudang</td>
          <td width="145">: <?php echo $no_gdg; ?></td>
        </tr>
        <tr> 
          <td width="120">Tgl Penerimaan</td>
          <td>: <?php echo $tgl_terima; ?></td>
          <td>Tgl Permintaan</td>
          <td>: <?php echo $tgl_minta; ?></td>
          <td>Tgl Kirim Gudang</td>
          <td>: <?php echo $tgl_gdg; ?></td>
        </tr>
        <!--tr>
			<td>Unit</td>
			<td>: <?php //echo $nunit; ?></td>
		</tr-->
      </table>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat</td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
          <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>
            Minta</td>
          <td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Terima </td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,am.*,date_format(am.tgl,'%d/%m/%Y') as tgl1,NAMA from a_minta_obat am inner join a_obat ao on am.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on am.kepemilikan_id=ak.ID where am.unit_id=$idunit and month(am.tgl)=$bulan and year(am.tgl)=$ta".$filter." order by ".$sorting;
	  $sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ap.FK_MINTA_ID,ak.ID,ak.NAMA,am.qty,sum(ap.QTY_SATUAN) as QTY_SATUAN from a_penerimaan ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID inner join a_minta_obat am on ap.FK_MINTA_ID=am.permintaan_id where ap.NOKIRIM='$no_gdg' group by ao.OBAT_ID,ao.OBAT_KODE,ak.NAMA,ap.FK_MINTA_ID";
	  //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
//	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
/*		$arfvalue="act*-*edit*|*stok1*-*".$rows['QTY_STOK']."*|*obat_id*-*".$rows['OBAT_ID']."*|*kepemilikan_id*-*".$rows['KEPEMILIKAN_ID']."*|*stok*-*".$rows['QTY_STOK'];
		
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*minta_id*-*".$rows['permintaan_id'];
*/
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['qty']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['QTY_SATUAN']; ?></td>
          <!--td width="30" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'<?php //echo $arfvalue; ?>');"></td-->
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="4" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
      </table>
    </div>
		<p align="center">
            <!--BUTTON type="button" onClick=""><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Terima&nbsp;&nbsp;</BUTTON-->
            &nbsp;<BUTTON type="reset" onClick="location='?f=list_penerimaan.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          </p>
</form>
</div>
</body>
<script>
function fSubmit(){
var cdata='';
var x;
	if (document.form1.chkitem.length){
		for (var i=0;i<document.form1.chkitem.length;i++){
			if (document.form1.chkitem[i].checked==true){
				cdata +=document.form1.chkitem[i].value+'|'+document.form1.qty_terima[i].value+'**';
			}
		}
		if (cdata!=""){
			cdata=cdata.substr(0,cdata.length-2);
		}else{
			alert("Pilih Item Obat Yg Mau Diterima Terlebih Dahulu !");
			return false;
		}
	}else{
		if (document.form1.chkitem.checked==false){
			alert("Pilih Item Obat Yg Mau Diterima Terlebih Dahulu !");
			return false;
		}
		cdata +=document.form1.chkitem.value+'|'+document.form1.qty_terima.value;
	}
	//alert(cdata);
	document.form1.fdata.value=cdata;
	document.form1.submit();
}
</script>
</html>
<?php 
mysqli_close($konek);
?>
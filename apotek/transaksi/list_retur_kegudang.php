<?php 
include("../sesi.php");
include("../koneksi/konek.php"); 
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_ctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
//$th=explode("-",$tgl);
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//$bulan=$_REQUEST['bulan'];
$bulan=$_REQUEST['bulan'];
if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];
//$bulan=$_REQUEST['bulan'];

if ($ta=="") $ta=$th[2];

//====================================================================
//Paging,Sorting dan Filter======
//$page=$_REQUEST["page"];
$page=mysqli_real_escape_string($konek,$_REQUEST['page']);
$defaultsort="ID_RETUR desc";
//$sorting=$_REQUEST["sorting"];
$sorting=mysqli_real_escape_string($konek,$_REQUEST['sorting']);
//$filter=$_REQUEST["filter"];
$filter=mysqli_real_escape_string($konek,$_REQUEST['filter']);
//===============================
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script>
	function PrintArea(PrintArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(PrintArea).innerHTML);
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>

<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
		  <form name="form1" method="post" action="">
			<input name="act" id="act" type="hidden" value="save">
			<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
			<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
			<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
			<!--	PRINT OUT DAFTAR PENGHAPUSAN OBAT	-->
			<div id="PrintArea" style="display:none">
			<link rel="stylesheet" href="../theme/print.css" type="text/css" />
			  
    <p align="center" class="jdltable"><b>RETURN OBAT KE GUDANG</b><br>Unit : <?php echo $namaunit; ?><br>
	<span class="txtcenter">( Bulan :
				  <?php 
				  if ($bulan=="1") echo "Januari";
				  elseif ($bulan=="2") echo "Pebruari";
				  elseif ($bulan=="3") echo "Maret";
				  elseif ($bulan=="4") echo "April";
				  elseif ($bulan=="5") echo "Mei";
				  elseif ($bulan=="6") echo "Juni";
				  elseif ($bulan=="7") echo "Juli";
				  elseif ($bulan=="8") echo "Agustus";
				  elseif ($bulan=="9") echo "September";
				  elseif ($bulan=="10") echo "Oktober";
				  elseif ($bulan=="11") echo "Nopember";
				  elseif ($bulan=="12") echo "Desember";
				   ?></span><span class="txtcenter">&nbsp;&nbsp;&nbsp;Tahun : <?php echo $ta;?> )</span>
	  </p>
    <table width="96%" border="0" cellpadding="1" cellspacing="0" align="center">
      <tr class="headtable"> 
        <td width="30" height="25" class="tblheaderkiri">No</td>
        <td id="NO_RETUR" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tgl. 
          Return</td>
        <td id="TGL_RETUR" width="160" class="tblheader" onClick="ifPop.CallFr(this);">No.Return</td>
        <td id="OBAT_NAMA" class="tblheader"  onClick="ifPop.CallFr(this);">Nama 
          Obat</td>
        <td width="90" class="tblheader" id="OBAT_NAMA"  onClick="ifPop.CallFr(this);">Kepemilikan</td>
        <td id="QTY" width="47" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
        <td id="ALASAN" width="250" class="tblheader" onClick="ifPop.CallFr(this);">Alasan</td>
      </tr>
      <?php 
			  if ($filter!=""){
				$filter=explode("|",$filter);
				$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
			  }
			  if ($sorting=="") $sorting=$defaultsort;
			  $sql="Select a_retur_togudang.*,a_unit.UNIT_NAME,a_obat.OBAT_NAMA,k.NAMA From a_retur_togudang Inner Join a_obat ON a_retur_togudang.OBAT_ID = a_obat.OBAT_ID Inner Join a_unit ON a_retur_togudang.UNIT_ID = a_unit.UNIT_ID inner join a_kepemilikan k on a_retur_togudang.KEPEMILIKAN_ID=k.ID where a_retur_togudang.UNIT_ID=$idunit and month(TGL_RETUR)=$bulan and year(TGL_RETUR)=$ta".$filter." order by ".$sorting;
			  //echo $sql."<br>";
			  $rs=mysqli_query($konek,$sql);
			  $i=0;
			  while ($rows=mysqli_fetch_array($rs)){
				$i++;
			  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo date("d/m/Y",strtotime($rows['TGL_RETUR'])); ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NO_RETUR']; ?></td>
        <td class="tdisi" align="left" style="font-size:12px;">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
        <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['QTY']; ?></td>
        <td class="tdisi" align="left" style="font-size:12px;">&nbsp;<?php echo $rows['ALASAN']; ?></td>
      </tr>
      <?php 
			  }
			  mysqli_free_result($rs);
			  ?>
    </table>
			  <p class="txtinput"  style="padding-right:50px; text-align:right">
			  <?php echo "<b>&raquo; Tgl Cetak:</b> ".$tgl_ctk." <b>- User:</b> ".$username; ?>
			  </p>
			  </div>
			<!-- PRINTOUT PENGHAPUSAN BERAKHIR -->
			
			<div id="listma" style="display:block">
			<link rel="stylesheet" href="../theme/print.css" type="text/css" />
			  
    <p align="center" class="jdltable"><b>RETURN OBAT KE GUDANG </b><br>Unit : <?php echo $namaunit; ?></p> 
			  
    <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
                  <td colspan="6"><span class="txtinput">Bulan : </span>
                      <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=../transaksi/list_retur_kegudang.php&bulan='+bulan.value+'&ta='+ta.value">
                        <option value="1" class="txtinput"<?php if ($bulan=="1") echo "selected";?>>Januari</option>
                        <option value="2" class="txtinput"<?php if ($bulan=="2") echo "selected";?>>Pebruari</option>
                        <option value="3" class="txtinput"<?php if ($bulan=="3") echo "selected";?>>Maret</option>
                        <option value="4" class="txtinput"<?php if ($bulan=="4") echo "selected";?>>April</option>
                        <option value="5" class="txtinput"<?php if ($bulan=="5") echo "selected";?>>Mei</option>
                        <option value="6" class="txtinput"<?php if ($bulan=="6") echo "selected";?>>Juni</option>
                        <option value="7" class="txtinput"<?php if ($bulan=="7") echo "selected";?>>Juli</option>
                        <option value="8" class="txtinput"<?php if ($bulan=="8") echo "selected";?>>Agustus</option>
                        <option value="9" class="txtinput"<?php if ($bulan=="9") echo "selected";?>>September</option>
                        <option value="10" class="txtinput"<?php if ($bulan=="10") echo "selected";?>>Oktober</option>
                        <option value="11" class="txtinput"<?php if ($bulan=="11") echo "selected";?>>Nopember</option>
                        <option value="12" class="txtinput"<?php if ($bulan=="12") echo "selected";?>>Desember</option>
                      </select>
                      <span class="txtinput">Tahun : </span>
                      <select name="ta" id="ta" class="txtinput" onChange="location='?f=../transaksi/list_retur_kegudang.php&bulan='+bulan.value+'&ta='+ta.value">
                        <?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
                        <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
                        <? }?>
                    </select></td>
                  <td width="530" align="right" colspan="6"><BUTTON type="button" onClick="location='?f=../transaksi/retur_kegudang.php'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah Retur </BUTTON></td>
                </tr>
              </table>
		      
    <table width="99%" border="0" align="center" cellpadding="1" cellspacing="0">
      <tr class="headtable"> 
        <td width="30" height="25" class="tblheaderkiri">No</td>
        <td id="TGL_RETUR" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tgl 
          Return</td>
        <td id="NO_RETUR" width="160" class="tblheader" onClick="ifPop.CallFr(this);">No. 
          Return</td>
        <td id="OBAT_NAMA" class="tblheader"  onClick="ifPop.CallFr(this);">Nama 
          Obat</td>
        <td width="90" class="tblheader" id="OBAT_NAMA"  onClick="ifPop.CallFr(this);">Kepemilikan</td>
        <td id="QTY" width="45" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
        <td id="ALASAN" width="250" class="tblheader" onClick="ifPop.CallFr(this);">Alasan</td>
        <!--td class="tblheader" width="30">Detail</td-->
      </tr>
      <?php 
/* 			  if ($filter!=""){
				$filter=explode("|",$filter);
				$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
			  }
			  if ($sorting=="") $sorting=$defaultsort; */
			  $sql="Select a_retur_togudang.*,a_unit.UNIT_NAME,a_obat.OBAT_NAMA,k.NAMA From a_retur_togudang Inner Join a_obat ON a_retur_togudang.OBAT_ID = a_obat.OBAT_ID Inner Join a_unit ON a_retur_togudang.UNIT_ID = a_unit.UNIT_ID inner join a_kepemilikan k on a_retur_togudang.KEPEMILIKAN_ID=k.ID where a_retur_togudang.UNIT_ID=$idunit and month(TGL_RETUR)=$bulan and year(TGL_RETUR)=$ta".$filter." order by ".$sorting;
			//  echo $sql."<br>";
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
			  while ($rows=mysqli_fetch_array($rs)){
				$i++;
			  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="center">&nbsp;<?php echo date("d/m/Y",strtotime($rows['TGL_RETUR'])); ?></td>
        <td class="tdisi" align="center"><?php echo $rows['NO_RETUR']; ?></td>
        <td class="tdisi" align="left">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
        <td class="tdisi" align="center">&nbsp;<?php echo $rows['QTY']; ?></td>
        <td class="tdisi" align="left">&nbsp;<?php echo $rows['ALASAN']; ?></td>
        <!--td width="30" class="tdisi"><img src="../icon/lihat.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'<?php //echo $arfvalue; ?>');"></td-->
        <!--td width="30" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="<?php //if ($istatus<>0){?>alert('Data Tidak Boleh Dihapus');<?php //}else{?>if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php //echo $arfhapus; ?>');document.form1.submit();}<?php //}?>"></td-->
      </tr>
      <?php 
			  }
			  mysqli_free_result($rs);
			  ?>
    </table>
		    </div>
			   
  <table width="99%" border="0" align="center">
<tr> 
                  <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
                      <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
                  <td colspan="3" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
                    <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
                    <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
                    <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
                  </td>
                </tr>
			</table>
			<p align="center">
              <BUTTON type="button" onClick="PrintArea('PrintArea','#')" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Daftar Retur</BUTTON>
          	</p>
		</form>
</body>
</html>
<?php 
mysqli_close($konek);
?>
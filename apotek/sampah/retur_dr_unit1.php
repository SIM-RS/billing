<?php 
include("../sesi.php");
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
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ID_RETUR desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
 	case "delete":
		$sql="delete from a_minta_obat where permintaan_id=$minta_id";
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
<meta http-equiv="refresh" content="5000" >
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
	<input name="minta_id" id="minta_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <div id="listma" style="display:block">
      <p><span class="jdltable">DAFTAR RETUR DARI UNIT</span></p>
      <table width="60%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td colspan="6"><span class="txtinput">Bulan : </span> 
            <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=../gudang/retur_dr_unit.php&bulan='+bulan.value+'&ta='+ta.value">
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
            <select name="ta" id="ta" class="txtinput" onChange="location='?f=../gudang/retur_dr_unit.php&bulan='+bulan.value+'&ta='+ta.value">
            <?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
              <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
            <? }?>
            </select></td>
          <td width="20%" colspan="6" align="right">
		  <!--BUTTON type="button" onClick="location='?f=minta_obat.php'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Buat Permintaan Baru</BUTTON-->		  </td>
	    </tr>
	</table>
      <table width="60%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="tgl" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td id="no_bukti" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Retur </td>
          <td id="UNIT_NAME" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Unit</td>
          <td width="100" class="tblheader" onClick="ifPop.CallFr(this);">Status</td>
          <td class="tblheader" colspan="3" width="30">Proses</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="Select a_retur_togudang.*, a_penerimaan.NOTERIMA, a_unit.UNIT_NAME, obat.NAMA From a_retur_togudang Inner Join a_unit ON a_retur_togudang.UNIT_ID = a_unit.UNIT_ID Inner Join a_penerimaan ON a_retur_togudang.PENERIMAAN_ID = a_penerimaan.ID Inner Join obat ON a_retur_togudang.OBAT_ID = obat.OBAT_ID where month(a_retur_togudang.TGL_RETUR)=$bulan and year(a_retur_togudang.TGL_RETUR)=$ta".$filter." order by ".$sorting;
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
	  //$arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$no_bukti=$rows['no_bukti'];
		$iunit=$rows['UNIT_ID'];
/* 		$sql="select t2.* from (select am1.*,if (t1.jml is null,0,t1.jml) as qty_kirim from a_minta_obat am1 left join (select ap.FK_MINTA_ID,sum(ap.QTY_SATUAN) as jml from a_penerimaan ap inner join a_minta_obat am on ap.FK_MINTA_ID=am.permintaan_id where ap.UNIT_ID_KIRIM=$idunit and ap.UNIT_ID_TERIMA=$iunit and ap.TIPE_TRANS=1 and am.no_bukti='$no_bukti' group by ap.FK_MINTA_ID) as t1 on am1.permintaan_id=t1.FK_MINTA_ID where am1.no_bukti='$no_bukti') as t2 where t2.qty>t2.qty_kirim";
		//echo $sql."<br>";
		$rs1=mysqli_query($konek,$sql);
		$qty_kurang=0;
		if ($rows1=mysqli_fetch_array($rs1)){
			$qty_kurang=1;
		}
		$sql="select distinct am.status,am.qty-am.qty_terima as qty_sisa from a_minta_obat am where am.no_bukti='$no_bukti' and am.unit_id=$iunit order by am.status desc";
		//echo $sql."<br>";
		$rs1=mysqli_query($konek,$sql);
		$jmlrow=mysqli_num_rows($rs1);
		if ($rows1=mysqli_fetch_array($rs1)){
			$istatus=$rows1['status'];
			$qty_sisa=$rows1['qty_sisa'];
		} */
		switch ($istatus){
			case 0:
				if(a_retur_togudang['STATUS']==0) $cstatus="Blm Diterima";
				break;
			case 1:
				if (a_retur_togudang['STATUS']==1) $cstatus="Diterima";
				break;
		}
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo date("d/m/Y",strtotime($rows['TGL_RETUR'])); ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NO_RETUR'] ?></td>
          <td class="tdisi" align="center"><?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="center"><?php echo $cstatus; ?></td>
          <td width="25" class="tdisi"><img src="../icon/lihat.gif" border="0" width="25" height="25" align="absmiddle" class="proses" title="Klik Untuk Melihat Permintaan Obat" onClick="location='?f=../gudang/retur_dariunit_detail&no_minta=<?php echo $no_bukti; ?>&tgl_minta=<?php echo $rows['tgl1']; ?>&iunit=<?php echo $rows['UNIT_NAME']; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>'"></td>
          <td width="25" class="tdisi"><img src="../icon/glossary.gif" border="0" width="18" height="18" align="absmiddle" class="proses" title="Klik Untuk Melihat Daftar Obat Yg Sudah Dikirimkan" onClick="location='?f=../gudang/list_sdh_dikirim_detail&no_minta=<?php echo $no_bukti; ?>&tgl_minta=<?php echo $rows['tgl1']; ?>&iunit=<?php echo $rows['UNIT_NAME']; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>'"></td>
          <td width="25" class="tdisi"><img src="../icon/published.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengirim Permintaan Obat" onClick="<?php if ($qty_kurang==0){?>alert('Obat Yg Diminta Sudah Dikirim Semua !');<?php }else{?>location='?f=../gudang/list_permintaan_detail.php&no_minta=<?php echo $rows['no_bukti']; ?>&tgl_minta=<?php echo $rows['tgl1']; ?>&iunit=<?php echo $iunit; ?>&nunit=<?php echo $rows['UNIT_NAME']; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>'<?php }?>"></td>
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

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
$bulan=$_REQUEST['bulan'];
$ta=$_REQUEST['ta'];
$minta_id=$_REQUEST['minta_id'];
convert_var($tgl2,$idunit,$bulan,$ta,$minta_id);
if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
if ($ta=="") $ta=$th[2];

//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="no_produksi desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
convert_var($page,$sorting,$filter,$act);
//echo $act;

switch ($act){
 	case "delete":
		$sql="delete from a_minta_obat where peminjaman_id=$minta_id";
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
      <p><span class="jdltable">DAFTAR OBAT / BHP YANG SUDAH DIPRODUKSI</span></p>
      <table width="60%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td width="315"><span class="txtinput">Bulan : </span> 
            <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=../produksi/list_produksi_obat.php&bulan='+document.forms[0].bulan.value+'&ta='+document.forms[0].ta.value">
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
            <select name="ta" id="ta" class="txtinput" onChange="location='?f=../produksi/list_produksi_obat.php&bulan='+document.forms[0].bulan.value+'&ta='+document.forms[0].ta.value">
            <?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
              <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
            <? }?>
            </select></td>
          <td width="272" align="right">
		  <BUTTON type="button" onClick="location='?f=../produksi/produksi_obat.php'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle"> 
            Produksi Obat Baru</BUTTON>
		  </td>
	    </tr>
	</table>
      <table width="60%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="tgl1" width="60" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td id="no_produksi" width="120" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Bukti</td>
          <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td width="95" class="tblheader">Nilai Total Bahan Produksi</td>
          <td width="90" class="tblheader">Nilai Total Hasil Produksi</td>
          <td width="30" class="tblheader">Proses</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select * from (select date_format(apr.tgl,'%d/%m/%Y') as tgl1,apr.no_produksi,sum(apr.qty_lama*ap.HARGA_BELI_SATUAN) as ndasar from a_produksi apr inner join a_penerimaan ap on apr.id_lama=ap.ID where month(apr.tgl)=$bulan and year(apr.tgl)=$ta group by apr.no_produksi) as t1 inner join (select ap.NOKIRIM,ak.ID,ak.NAMA,sum(ap.QTY_SATUAN*ap.HARGA_BELI_SATUAN) as nhasil from a_penerimaan ap inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID where TIPE_TRANS=4 and month(TANGGAL)=$bulan and year(TANGGAL)=$ta group by NOKIRIM,NAMA) as t2 on t1.no_produksi=t2.NOKIRIM".$filter." order by ".$sorting;
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
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['no_produksi']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['ndasar'],2,",","."); ?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['nhasil'],2,",","."); ?></td>
          <td class="tdisi" align="center"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Melihat Detail Produksi" onClick="location='?f=../produksi/produksi_obat.php&no_produksi=<?php echo $rows['no_produksi']; ?>&tgl_produksi=<?php echo $rows['tgl1']; ?>&kp_id=<?php echo $rows['ID']; ?>&isview=true';"></td>
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
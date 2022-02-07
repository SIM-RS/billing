<?php 
include("../sesi.php"); 
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//$idunit=$_SESSION["ses_idunit"];
$idunit = mysqli_real_escape_string($konek,$_SESSION["ses_idunit"]);
//$bulan=$_REQUEST['bulan'];
$bulan=mysqli_real_escape_string($konek,$_REQUEST['bulan']);
if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
//$ta=$_REQUEST['ta'];
$ta=mysqli_real_escape_string($konek,$_REQUEST['ta']);
if ($ta=="") $ta=$th[2];
//$no_bukti=$_REQUEST['no_bukti'];
$no_bukti=mysqli_real_escape_string($konek,$_REQUEST['no_bukti']);
//====================================================================
//Paging,Sorting dan Filter======
//$page=$_REQUEST["page"];
$page=mysqli_real_escape_string($konek,$_REQUEST['page']);
$defaultsort="a.ID desc";
//$sorting=$_REQUEST["sorting"];
$sorting=mysqli_real_escape_string($konek,$_REQUEST['sorting']);
//$filter=$_REQUEST["filter"];
$filter=mysqli_real_escape_string($konek,$_REQUEST['filter']);
//===============================

//Aksi Save, Edit Atau Delete =========================================
//$act=$_REQUEST['act']; // Jenis Aksi
$act=mysqli_real_escape_string($konek,$_REQUEST['act']);
//echo $act;

switch ($act){
 	case "delete":
		$sql="select a.ID from a_penerimaan a where a.ID='$no_bukti' and a.QTY_STOK<>a.QTY_SATUAN";
		$rs=mysqli_query($konek,$sql);
		
		if (mysqli_num_rows($rs)>0){
			echo "<script>alert('Data Tdk Boleh Dihapus Karena Obat Sudah Terpakai !');</script>";
		}else{
			$sql="delete from a_penerimaan where ID='$no_bukti' and UNIT_ID_TERIMA=$idunit";
			$rs=mysqli_query($konek,$sql);
			//echo $sql;
		}
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
	<input name="no_bukti" id="no_bukti" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <div id="listma" style="display:block">
      <p><span class="jdltable">DAFTAR RETURN OBAT SISA RAWATAN </span></p>
      <table width="81%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td width="342"><span class="txtinput">Bulan : </span> 
            <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=../apotik/list_return_sisa_rawatan.php&bulan='+bulan.value+'&ta='+ta.value">
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
            <select name="ta" id="ta" class="txtinput" onChange="location='?f=../apotik/list_return_sisa_rawatan.php&bulan='+bulan.value+'&ta='+ta.value">
            <?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
              <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
            <? }?>
            </select></td>
          <td width="258" align="right">
		  <BUTTON type="button" onClick="location='?f=../transaksi/return_sisa_rawatan.php'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Buat Penerimaan Baru</BUTTON>
		  </td>
	    </tr>
	</table>
      <table width="81%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="39" height="25" class="tblheaderkiri">No</td>
          <td id="tgl1" width="114" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td id="NOTERIMA" width="286" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Penerimaan</td>
          <td width="295" class="tblheader" id="b.OBAT_NAMA" onClick="ifPop.CallFr(this);">OBAT </td>
          <td id="" width="111" class="tblheader">Jumlah</td>
          <td id="" width="56" class="tblheader">Hapus</td>
          <!--td class="tblheader" width="30">Proses</td-->
        </tr>
        <?php 
		//echo "asdasd";
		if ($filter!=""){
			$filter=explode("|",$filter);
			$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
		}
		if ($sorting=="") $sorting=$defaultsort;
		//$sql="select distinct am.no_bukti,date_format(am.tgl,'%d/%m/%Y') as tgl1, a_unit.UNIT_NAME, a_unit.UNIT_ID,k.NAMA from a_minta_obat am Inner Join a_unit ON am.unit_tujuan = a_unit.UNIT_ID INNER JOIN a_kepemilikan k ON am.kepemilikan_id=k.ID where am.unit_id=$idunit and month(am.tgl)=$bulan and year(am.tgl)=$ta".$filter." order by ".$sorting;
		
		$sql="select a.*,date_format(a.TANGGAL,'%d/%m/%Y') as tgl1,b.OBAT_NAMA 
		from a_penerimaan a
		inner join a_obat b ON a.OBAT_ID=b.OBAT_ID
		where a.TIPE_TRANS=11 and a.UNIT_ID_TERIMA=$idunit AND month(a.TANGGAL) = $bulan AND year(a.TANGGAL) = $ta ".$filter." order by ".$sorting;;
		
		
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
			$arfhapus="act*-*delete*|*no_bukti*-*".$rows['ID'];
			$c_no_bukti=$rows['no_bukti'];
			$sql=" select distinct status
					from a_minta_obat where no_bukti='$c_no_bukti' order by status DESC ";
			
			$rs1=mysqli_query($konek,$sql);
			$jml_row=mysqli_num_rows($rs1);
			$tmpStat = 0;
		

			
		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NOTERIMA']; ?></td>
          <td class="tdisi" align="left"> &nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['QTY_SATUAN']; ?></td>
          <td width="56" class="tdisi" align="center"><img src="../icon/hapus.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus Permintaan" onClick="<?php if ($istatus==0){?>if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}<?php }else{?>alert('Data Permintaan Tdk Boleh Dihapus, Karena Obat Sudah Dikirim !');<?php }?>"></td>
        </tr>
        <?php 
		}
		mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="3" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;          </td>
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
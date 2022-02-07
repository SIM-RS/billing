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
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="no_bukti desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
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
      <p><span class="jdltable">DAFTAR OBAT DIPINJAM</span> 
      <table width="70%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td colspan="6"><span class="txtinput">Bulan : </span> 
            <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=list_dipinjam.php&bulan='+document.forms[0].bulan.value+'&ta='+document.forms[0].ta.value">
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
            <select name="ta" id="ta" class="txtinput" onChange="location='?f=list_dipinjam.php&bulan='+document.forms[0].bulan.value+'&ta='+document.forms[0].ta.value">
            <?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
              <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
            <? }?>
            </select></td>
          <td align="right" colspan="6">
		  <!--BUTTON type="button" onClick="location='?f=pinjam_obat.php'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Buat Peminjaman Baru</BUTTON-->
		  </td>
	    </tr>
	</table>
      <table width="70%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="tgl" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td id="no_bukti" width="140" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Permintaan </td>
          <td id="UNIT_NAME" class="tblheader" onClick="ifPop.CallFr(this);">Unit 
            Peminjam</td>
          <td width="100" class="tblheader">Status</td>
          <td colspan="3" id="status" width="30" class="tblheader">Proses</td>
          <!--td class="tblheader" width="30">Proses</td-->
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select distinct apo.unit_id,no_bukti,date_format(tgl,'%d/%m/%Y') as tgl1,UNIT_NAME from a_pinjam_obat apo inner join a_unit on apo.unit_id=a_unit.UNIT_ID where unit_tujuan=$idunit and month(tgl)=$bulan and year(tgl)=$ta".$filter." order by ".$sorting;
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
	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$no_bukti=$rows['no_bukti'];
		$sql="select distinct status from a_pinjam_obat where no_bukti='$no_bukti' order by status desc";
		$rs1=mysqli_query($konek,$sql);
		$jmlrec=mysqli_num_rows($rs1);
		if ($rows1=mysqli_fetch_array($rs1)){
			$istatus=$rows1['status'];
			switch ($istatus){
				case 0:
					$cstatus="Menunggu";
					$cevent1="alert('Belum Ada Obat Yang Dipinjamkan');";
					$cevent2="location='?f=list_dipinjam_detail.php&no_bukti=".$rows['no_bukti']."&iunit=".$rows['UNIT_NAME']."&tgl_pinjam=".$rows['tgl1']."&bulan=".$bulan."&ta=".$ta."';";
					break;
				case 1:
					if ($jmlrec>1){
						$cstatus="Dikirim(-)";
						$cevent1="location='?f=list_sdh_dipinjam_detail&no_bukti=".$rows['no_bukti']."&iunit=".$rows['UNIT_NAME']."&tgl_pinjam=".$rows['tgl1']."&bulan=".$bulan."&ta=".$ta."';";
						$cevent2="location='?f=list_dipinjam_detail.php&no_bukti=".$rows['no_bukti']."&iunit=".$rows['UNIT_NAME']."&tgl_pinjam=".$rows['tgl1']."&bulan=".$bulan."&ta=".$ta."';";
					}else{
						$cstatus="Dikirim";
						$cevent1="location='?f=list_sdh_dipinjam_detail&no_bukti=".$rows['no_bukti']."&iunit=".$rows['UNIT_NAME']."&tgl_pinjam=".$rows['tgl1']."&bulan=".$bulan."&ta=".$ta."';";
						$cevent2="alert('Obat Yang Mau Dipinjam Sudah Dikirimkan Semua');";
					}
					break;
				case 2:
					if ($jmlrec>1){
						$cstatus="Diterima(-)";
						$cevent1="location='?f=list_sdh_dipinjam_detail&no_bukti=".$rows['no_bukti']."&iunit=".$rows['UNIT_NAME']."&tgl_pinjam=".$rows['tgl1']."&bulan=".$bulan."&ta=".$ta."';";
						$cevent2="location='?f=list_dipinjam_detail.php&no_bukti=".$rows['no_bukti']."&iunit=".$rows['UNIT_NAME']."&tgl_pinjam=".$rows['tgl1']."&bulan=".$bulan."&ta=".$ta."';";
					}else{
						$cstatus="Diterima";
						$cevent1="location='?f=list_sdh_dipinjam_detail&no_bukti=".$rows['no_bukti']."&iunit=".$rows['UNIT_NAME']."&tgl_pinjam=".$rows['tgl1']."&bulan=".$bulan."&ta=".$ta."';";
						$cevent2="alert('Obat Yang Dipinjam Sudah Diterima Semua');";
					}
					break;
/*				case 3:
					$cstatus="Diterima";
					break;
*/
			}
		}
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['no_bukti']; ?></td>
          <td class="tdisi"><?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="center"><?php echo $cstatus; ?></td>
          <td width="30" class="tdisi"><img src="../icon/lihat.gif" border="0" width="25" height="25" align="absmiddle" class="proses" title="Klik Untuk Melihat Detail Obat Yg Dipinjam" onClick="location='?f=list_dipinjam_detail.php&isview=true&no_bukti=<?php echo $rows['no_bukti']; ?>&iunit=<?php echo $rows['UNIT_NAME']; ?>&tgl_pinjam=<?php echo $rows['tgl1']; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>';"></td>
          <td width="30" class="tdisi"><img src="../icon/glossary.gif" border="0" width="18" height="18" align="absmiddle" class="proses" title="Klik Untuk Melihat Detail Obat Yg Sudah Dipinjamkan" onClick="<?php echo $cevent1; ?>"></td>
          <td width="30" class="tdisi"><img src="../icon/published.gif" border="0" width="18" height="18" align="absmiddle" class="proses" title="Klik Untuk Meminjamkan Obat" onClick="<?php echo $cevent2; ?>"></td>
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
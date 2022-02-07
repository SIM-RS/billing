<?php 
include("../sesi.php"); 
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$minta_id=$_REQUEST['minta_id'];
$jns_pasien=$_REQUEST['jns_pasien'];if($jns_pasien=="" OR $jns_pasien=="0") $jns_p=""; else $jns_p="and a_kepemilikan.ID=$jns_pasien";
$tgl_d=$_REQUEST['tgl_d'];
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
$tgl_s=$_REQUEST['tgl_s'];
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";
$status=$_REQUEST['status']; if($status=="") $status="1";
//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
$defaultsort="p.TGL_RETUR DESC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

/* $sql="SELECT * FROM a_retur_biaya";
$rs=mysqli_query($konek,$sql);
$biaya_retur=0;
if ($rows=mysqli_fetch_array($rs)) $biaya_retur=$rows['biaya_potong']; */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" /><strong></strong>
</head>

<body>
<script>
var arrRange=depRange=[];
</script>
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
<script>
	function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:70px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs1.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 200px; visibility: hidden">
</iframe>
<div align="center">
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
	<form name="form1" method="post" action="">
	<input name="act" id="act" type="hidden" value="save">
	<input name="minta_id" id="minta_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	
	<div id="view" style="display:block">
	  <p><span class="jdltable"> DAFTAR RETURN PENJUALAN<br>
        Unit : <?php echo $namaunit; ?></span> 
	  <table width="50%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td>
		  	Tgl Periode : 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_d']<>'') echo $_GET['tgl_d']; else echo $tgl;?>" onchange="location='?f=../apotik/list_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/> 
            &nbsp;s/d&nbsp;</input> 
			<input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" onchange="location='?f=../apotik/list_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value" value="<?php if ($_GET['tgl_s']<>'') echo $_GET['tgl_s']; else echo $tgl;?>" ></input> 
            <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" /></input>
		  	<button type="button" onclick="location='?f=../apotik/list_retur_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button>
		  </td>
        </tr>
      </table>
      <table width="99%" align="center" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td id="" width="30" height="25" class="tblheaderkiri" onclick="">No</td>
          <td id="TGL_ACT" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Tgl 
            Return </td>
          <td id="NO_RETUR" width="60" class="tblheader" onclick="ifPop.CallFr(this);">No 
            Return</td>
          <td id="NO_PENJUALAN" width="60" class="tblheader" onclick="ifPop.CallFr(this);">No 
            Penjualan </td>
          <td id="NAMA_PASIEN" class="tblheader" onclick="ifPop.CallFr(this);">Nama 
            Pasien </td>
          <td width="200" class="tblheader" id="m.NAMA" onclick="ifPop.CallFr(this);">KSO</td>
          <td width="90" class="tblheader" id="NAMA" onclick="ifPop.CallFr(this);">Kepemilikan</td>
          <td width="30" class="tblheader" id="SHIFT_RETUR" onclick="ifPop.CallFr(this);">Shift</td>
          <td width="90" class="tblheader">Nilai Return</td>
          <td width="30" class="tblheader">Act</td>
          <!--td class="tblheader" width="30">Proses</td-->
        </tr>
        <?php 
	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  	if ($_GET['tgl_d']=='') $tgl_1=$tgl2; else $tgl_1=$tgl_de;
	  	if ($_GET['tgl_s']=='') $tgl_2=$tgl2; else $tgl_2=$tgl_se;
 		$sql="SELECT DATE_FORMAT(p.TGL_RETUR,'%d/%m/%Y') AS tgl1,p.TGL,p.NO_RETUR,p.NO_PASIEN,p.NO_PENJUALAN,p.SHIFT_RETUR,
			SUM(FLOOR(p.QTY_RETUR*p.HARGA_SATUAN*(100-p.BIAYA_RETUR)/100)) AS NRETUR, p.NAMA_PASIEN,k.NAMA,m.NAMA KSO FROM a_penjualan p 
			INNER JOIN a_penerimaan ap ON p.PENERIMAAN_ID=ap.ID INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID 
			INNER JOIN a_kepemilikan k ON p.JENIS_PASIEN_ID=k.ID LEFT JOIN a_mitra m ON p.KSO_ID=m.IDMITRA 
			WHERE DATE(p.TGL_RETUR) BETWEEN '$tgl_1' AND '$tgl_2' AND p.UNIT_ID=$idunit AND p.QTY_RETUR>0".$filter." 
			GROUP BY NO_PASIEN,NO_PENJUALAN ORDER BY ".$sorting;
		$sql = "SELECT DATE_FORMAT(p.TGL_RETUR, '%d/%m/%Y') AS tgl1,
				  p.TGL, p.NO_RETUR, p.NO_PASIEN, p.NO_PENJUALAN, p.SHIFT_RETUR, SUM(rp.nilai) NRETUR,
				  p.NAMA_PASIEN, k.NAMA, m.NAMA KSO 
				FROM a_return_penjualan rp
				INNER JOIN a_penjualan p ON p.ID = rp.idpenjualan
				INNER JOIN a_penerimaan ap ON p.PENERIMAAN_ID = ap.ID 
				INNER JOIN a_obat ao ON ap.OBAT_ID = ao.OBAT_ID 
				INNER JOIN a_kepemilikan k ON p.JENIS_PASIEN_ID = k.ID 
				LEFT JOIN a_mitra m ON p.KSO_ID = m.IDMITRA 
				WHERE DATE(p.TGL_RETUR) BETWEEN '$tgl_1' AND '$tgl_2'
				  AND p.UNIT_ID = $idunit
				  AND p.QTY_RETUR > 0 
				  {$filter}
				GROUP BY NO_PASIEN,
				  NO_PENJUALAN 
				ORDER BY {$sorting}";
		// echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql2);
	  $isi=mysqli_num_rows($rs);
	  $i=($page-1)*$perpage;
	  while ($rows=mysqli_fetch_array($rs)){
		$i++;
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NO_RETUR']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NO_PENJUALAN']; ?></td>
          <td align="left" class="tdisi"><?php echo $rows['NAMA_PASIEN']; ?></td>
          <td align="left" class="tdisi">&nbsp;<?php echo $rows['KSO']; ?></td>
          <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['SHIFT_RETUR']; ?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['NRETUR'],0,",","."); ?></td>
          <td class="tdisi" align="center"><a href="../newreport/kwi_retur_new.php?no_retur=<?php echo $rows['NO_RETUR']; ?>&no_penjualan=<?php echo $rows['NO_PENJUALAN'];?>&sunit=<?php echo $idunit; ?>&no_pasien=<?php echo $rows['NO_PASIEN']; ?>&tgl=<?php echo $rows['TGL']; ?>" onclick="NewWindow(this.href,'name','550','500','yes');return false"><img src="../icon/lihat.gif" border="0" width="16" height="16" align="absmiddle" title="Klik Untuk Melihat Detail"></a></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  $sql2="select if (sum(t1.NRETUR) is null,0,sum(t1.NRETUR)) as HARTOT from (".$sql.") as t1";
	  $hs=mysqli_query($konek,$sql2);
	  $hartot=0;
	  $show=mysqli_fetch_array($hs);
	  $hartot=$show['HARTOT'];
	  ?>
        <tr> 
          <td colspan="8" align="right" class="txtright">Jumlah Total</td>
          <td align="right" class="txtright">&nbsp;<? echo number_format($hartot,0,",","."); ?></td>
          <td width="2">&nbsp;</td>
        </tr>
      </table>
	<table width="99%" align="center" border="0" cellpadding="1" cellspacing="0">
      <tr>
        <td colspan="" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
        <td colspan="" align="right"><img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onclick="document.form1.act.value='paging';document.form1.page.value='1';document.form1.submit();" /> <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $bpage; ?>';document.form1.submit();" /> <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $npage; ?>';document.form1.submit();" /> <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $totpage; ?>';document.form1.submit();" />&nbsp;&nbsp; </td>
      </tr>
	<tr>
	 <td align="center" colspan="2"><a class="navText" href='#' onclick='PrintArea("idArea","#")'>&nbsp;
		<BUTTON type="button" <?php  if($isi==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" onclick="document.getElementById('idArea').style.display='block'">&nbsp;Cetak Retur Penjualan</BUTTON>
	 </a></td>
		</tr>
		</table>
	</div>
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	  <p align="center"><span class="jdltable"> DAFTAR RETURN PENJUALAN<br>
        Unit : <?php echo $namaunit; ?><br></span><span class="txtcenter">( <?php echo $_GET['tgl_d'];?> s/d <?php echo $_GET['tgl_s'];?> )</span> 
	  <table width="99%" align="center" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td width="80" class="tblheader">Tgl Return </td>
          <td width="60" class="tblheader">No Return</td>
          <td width="60" class="tblheader">No Penjualan</td>
          <td class="tblheader">Nama Pasien</td>
          <td width="250" class="tblheader">KSO</td>
          <td width="90" class="tblheader">Kepemilikan</td>
          <td width="30" class="tblheader">Shift</td>
          <td width="90" class="tblheader">Nilai Return</td>
        </tr>
        <?php 
	  //echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  $isi=mysqli_num_rows($rs);
	  $p=0;
	  while ($rows=mysqli_fetch_array($rs)){
		$p++;
		
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $p; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NO_RETUR']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NO_PENJUALAN']; ?></td>
          <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['NAMA_PASIEN']; ?></td>
          <td class="tdisi" align="left" style="font-size:12px;">&nbsp;<?php echo $rows['KSO']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['SHIFT_RETUR']; ?></td>
          <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['NRETUR'],0,",","."); ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr class=""> 
          <td colspan="5"></td>
          <td class="txtright" align="right">&nbsp;</td>
          <td class="txtright" align="right">Jumlah Total</td>
          <td class="txtright" align="right">&nbsp;</td>
          <td class="txtright" align="right" style="font-size:12px;">&nbsp;<? echo number_format($hartot,0,",","."); ?></td>
        </tr>
      </table>
	</div>
</form>
</div>
</body>
</html>

<?php 
include("../sesi.php");

//$username = $_SESSION["username"];
$username=mysqli_real_escape_string($konek,$_SESSION["username"]);
//$password = $_SESSION["password"];
$password=mysqli_real_escape_string($konek,$_SESSION["password"]);
//$idunit = $_SESSION["ses_idunit"];
$idunit=mysqli_real_escape_string($konek,$_SESSION["ses_idunit"]);
//$namaunit = $_SESSION["ses_namaunit"];
$namaunit=mysqli_real_escape_string($konek,$_SESSION["ses_namaunit"]);
//$kodeunit = $_SESSION["ses_kodeunit"];
$kodeunit=mysqli_real_escape_string($konek,$_SESSION["ses_kodeunit"]);
//$iduser = $_SESSION["iduser"];
$iduser=mysqli_real_escape_string($konek,$_SESSION["iduser"]);
//$unit_tipe = $_SESSION["ses_unit_tipe"];
$unit_tipe=mysqli_real_escape_string($konek,$_SESSION["ses_unit_tipe"]);
//$kategori = $_SESSION["kategori"];
$kategori=mysqli_real_escape_string($konek,$_SESSION["kategori"]);

//Jika Tidak login, maka lempar ke index utk login dulu =========
if (empty ($username) AND empty ($password)){
	header("Location: ../../index.php");
	exit();
}
//==============================================================
if ($unit_tipe<>4){
	//header("Location: ../../index.php");
	//exit();
}
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//$idunit=$_SESSION["ses_idunit"];
$idunit=mysqli_real_escape_string($konek,$_SESSION["ses_idunit"]);
//$bulan=$_REQUEST['bulan'];
$bulan=mysqli_real_escape_string($konek,$_REQUEST['bulan']);
if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];

//$ta=$_REQUEST['ta'];
$ta=mysqli_real_escape_string($konek,$_REQUEST['ta']);
if ($ta=="") $ta=$th[2];
//$minta_id=$_REQUEST['minta_id'];
//$spph_id=$_REQUEST['spph_id'];
$spph_id=mysqli_real_escape_string($konek,$_REQUEST['spph_id']);
//====================================================================
//Paging,Sorting dan Filter======
//$page=$_REQUEST["page"];
$page=mysqli_real_escape_string($konek,$_REQUEST['page']);
$defaultsort="s.tgl desc,spph_id desc";
//$sorting=$_REQUEST["sorting"];
$sorting=mysqli_real_escape_string($konek,$_REQUEST['sorting']);
//$filter=$_REQUEST["filter"];
$filter=mysqli_real_escape_string($konek,$_REQUEST['filter']);
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
 	case "delete":
	//	$sql="delete from a_minta_obat where permintaan_id=$minta_id";
		$sql="delete from a_spph where no_spph='$spph_id'";
		$rs=mysqli_query($konek,$sql);
		//echo $sql;
		break;
}
?>
<html>
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<div align="center">
<?php //include("header.php");?>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
<tr align="center" valign="top">
	<td width="1000" height="470" align="center">
		<iframe height="72" width="130" name="sort"
			id="sort"
			src="../theme/sort.php" scrolling="no"
			frameborder="0"
			style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
		</iframe>
		<div align="center">
		  <form name="form1" method="post" action="">
			<input name="act" id="act" type="hidden" value="save">
			<input name="spph_id" id="spph_id" type="hidden" value="">
			<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
			<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
			<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
			<div id="listma" style="display:block">
			  <p><span class="jdltable">DAFTAR SPPH</span> 
              <table width="80%" cellpadding="0" cellspacing="0" border="0">
				<tr>
				  <td colspan="6"><span class="txtinput">Bulan : </span> 
					<select name="bulan" id="bulan" class="txtinput" onChange="window.location='?f=../mc/spph.php&bulan='+bulan.value+'&ta='+ta.value">
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
					<select name="ta" id="ta" class="txtinput" onChange="location='?f=../mc/spph.php&bulan='+bulan.value+'&ta='+ta.value">
					<?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
					  <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
					<? }?>
					</select></td>
				  <td width="530" align="right" colspan="6">
				  <BUTTON type="button" onClick="location='?f=../mc/spph_baru.php'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Buat SPPH Baru</BUTTON>
				  </td>
				</tr>
			</table>
			  <table width="80%" border="0" cellpadding="1" cellspacing="0">
                <tr class="headtable"> 
                  <td width="33" height="25" class="tblheaderkiri">No</td>
                  <td id="tgl" width="81" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
                  <td id="no_spph" width="150" class="tblheader" onClick="ifPop.CallFr(this);">No 
                    SPPH</td>
                  <td class="tblheader" id="PBF_NAMA" onClick="ifPop.CallFr(this);">PBF</td>
                  <td width="100" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
                  <td width="120" class="tblheader">Total</td>
                  <td colspan="3" class="tblheader">Proses</td>
                  <!--td class="tblheader" width="30">Proses</td-->
                </tr>
                <?php 
			  if ($filter!=""){
				$filter=explode("|",$filter);
				$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
			  }
			  if ($sorting=="") $sorting=$defaultsort;
			  $sql="select tgl,date_format(tgl,'%d/%m/%Y') as tgl1,no_spph,p.pbf_id,PBF_NAMA,ak.ID,ak.NAMA,SUM(qty_kemasan * pagu) AS total from a_spph s inner join a_pbf p on s.pbf_id=p.PBF_ID inner join a_kepemilikan ak on s.kepemilikan_id=ak.ID where month(s.tgl)=$bulan and year(s.tgl)=$ta".$filter."  group by no_spph order by ".$sorting;
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
				$arfhapus="act*-*delete*|*spph_id*-*".$rows['no_spph'];
			  ?>
                <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
                  <td class="tdisikiri"><?php echo $i; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['tgl1']; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['no_spph']; ?></td>
                  <td class="tdisi" align="left"><?php echo $rows['PBF_NAMA']; ?></td>
                  <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
                  <td align="right" class="tdisi"><?php echo number_format($rows['total'],0,",","."); ?></td>
                  <td width="28" class="tdisi"><img src="../icon/lihat.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Melihat Detail SPPH" onClick="location='?f=../mc/spph_detail.php&no_spph=<?php echo $rows['no_spph']; ?>&tgl_spph=<?php echo $rows['tgl1']; ?>&pbf_id=<?php echo $rows['pbf_id']; ?>&pbf=<?php echo $rows['PBF_NAMA']; ?>&kp_id=<?php echo $rows['ID']; ?>&kp_nama=<?php echo $rows['NAMA']; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>'"></td>
                  <td width="28" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="location='?f=../mc/spph_edit.php&no_spph=<?php echo $rows['no_spph']; ?>&tgl_spph=<?php echo $rows['tgl1']; ?>&pbf_id=<?php echo $rows['pbf_id']; ?>&pbf=<?php echo $rows['PBF_NAMA']; ?>&kp_id=<?php echo $rows['ID']; ?>&kp_nama=<?php echo $rows['NAMA']; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>'"></td>
                  <td width="28" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data ?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
                </tr>
                <?php 
			  }
			  $sql="select sum(t1.total) as total from (select tgl,date_format(tgl,'%d/%m/%Y') as tgl1,no_spph,p.pbf_id,PBF_NAMA,ak.ID,ak.NAMA,SUM(qty_kemasan * pagu) AS total from a_spph s inner join a_pbf p on s.pbf_id=p.PBF_ID inner join a_kepemilikan ak on s.kepemilikan_id=ak.ID where month(s.tgl)=$bulan and year(s.tgl)=$ta".$filter." group by no_spph) as t1";
			  //echo $sql."<br>";
			  $rs=mysqli_query($konek,$sql);
			  $total=0;
			  if ($rows=mysqli_fetch_array($rs)) $total=$rows['total'];
			  mysqli_free_result($rs);
			  ?>
                <tr> 
                  <td colspan="5" class="txtright">Total :</td>
                  <td class="txtright"><?php echo number_format($total,0,",","."); ?></td>
                  <td colspan="3">&nbsp;</td>
                </tr>
                <tr> 
                  <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
                      <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
                  <td align="right" colspan="6"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
                    <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
                    <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
                    <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp; 
                  </td>
                </tr>
              </table>
			</div>
		</form>
		</div>
	</td>
</tr>
</table>
</div>
<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
<script language="JavaScript" src="../theme/js/dropdown.js"></script>
<script language="JavaScript1.2">mmLoadMenus();</script>
</body>
</html>
<?php 
mysqli_close($konek);
?>
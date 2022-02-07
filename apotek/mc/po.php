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
$idunit=$_SESSION["ses_idunit"];
//$bulan=$_REQUEST['bulan'];
$bulan=mysqli_real_escape_string($konek,$_REQUEST['bulan']);
if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
//$ta=$_REQUEST['ta'];
$ta=mysqli_real_escape_string($konek,$_REQUEST['ta']);
if ($ta=="") $ta=$th[2];
//$minta_id=$_REQUEST['minta_id'];
//$no_po=$_REQUEST['no_po'];
$no_po=mysqli_real_escape_string($konek,$_REQUEST['no_po']);
//$no_spph=$_REQUEST['no_spph'];
$no_spph=mysqli_real_escape_string($konek,$_REQUEST['no_spph']);
//====================================================================
//Paging,Sorting dan Filter======
//$page=$_REQUEST["page"];
$page=mysqli_real_escape_string($konek,$_REQUEST['page']);
$defaultsort="TANGGAL desc,no_po desc";
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
		$sql="SELECT * FROM a_po WHERE NO_PO='$no_po' AND (QTY_KEMASAN_TERIMA>0 OR QTY_SATUAN_TERIMA>0 OR STATUS=1)";
		$rs=mysqli_query($konek,$sql);
		//echo $sql;
		$jmldata=mysqli_num_rows($rs);
		if ($jmldata>0){
			echo "<script>alert('Data Obat Dalam PO, Sudah Ada Yg Pernah Diterima. Jadi Tdk Boleh Dihapus !');</script>";
			//exit();
		}else{
			$sql="delete from a_po where NO_PO='$no_po'";
			$rs=mysqli_query($konek,$sql);
			//echo $sql;
			$sql="update a_spph set status=0 where no_spph='$no_spph'";
			$rs=mysqli_query($konek,$sql);
			//echo $sql;
		}
		break;
}
?>
<html>
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<div align="center">
<?php //include("header.php");?>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
<tr align="center" valign="top">
	<td align="center" height="470">
		<iframe height="72" width="130" name="sort"
			id="sort"
			src="../theme/sort.php" scrolling="no"
			frameborder="0"
			style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
		</iframe>
		<div align="center">
		  <form name="form1" method="post" action="">
			<input name="act" id="act" type="hidden" value="save">
			<input name="no_po" id="no_po" type="hidden" value="">
			<input name="no_spph" id="no_spph" type="hidden" value="">
			<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
			<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
			<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
			<div id="listma" style="display:block">
			  <p><span class="jdltable">DAFTAR PURCHASE ORDER</span> 
              <table width="98%" cellpadding="0" cellspacing="0" border="0">
                <tr>
				  <td colspan="6"><span class="txtinput">Bulan : </span> 
					<select name="bulan" id="bulan" class="txtinput" onChange="location='?f=../mc/po.php&bulan='+bulan.value+'&ta='+ta.value">
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
					<select name="ta" id="ta" class="txtinput" onChange="location='?f=../mc/po.php&bulan='+bulan.value+'&ta='+ta.value">
					<?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
					  <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
					<? }?>
					</select></td>
				  <td width="530" align="right" colspan="6">
				  <div style="display:none">
				  <BUTTON type="button" onClick="location='?f=../mc/po_baru.php&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>&page=<?php echo $page; ?>'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Buat 
                    PO Baru</BUTTON>&nbsp;
					</div>
					<BUTTON type="button" onClick="location='?f=../mc/po_baru_non_spph.php&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>&page=<?php echo $page; ?>'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Buat 
                    PO Baru Tanpa SPPH</BUTTON>
					
				  </td>
				</tr>
			</table>
			  <table width="98%" border="0" cellpadding="1" cellspacing="0">
                <tr class="headtable"> 
                  <td width="32" height="25" class="tblheaderkiri">No</td>
                  <td id="tgl" width="81" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
                  <td id="no_po" width="140" class="tblheader" onClick="ifPop.CallFr(this);">No 
                    PO </td>
                  <td id="no_spph" width="160" class="tblheader" onClick="ifPop.CallFr(this);">No 
                    SPPH </td>
                  <td id="a_po.KET" width="150" class="tblheader" onClick="ifPop.CallFr(this);">No SPK</td>
                  <td class="tblheader" id="PBF_NAMA" onClick="ifPop.CallFr(this);">PBF</td>
                  <td width="100" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
                  <td colspan="4" class="tblheader">Proses</td>
                  <!--td class="tblheader" width="30">Proses</td-->
                </tr>
                <?php 
			  if ($filter!=""){
				$filter=explode("|",$filter);
				$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
			  }
			  if ($sorting=="") $sorting=$defaultsort;
			  $sql="select distinct date_format(TANGGAL,'%d/%m/%Y') as tgl1,date_format(TANGGAL,'%d-%m-%Y') as tgl2,no_po,a_po.KET,UPDT_H_NETTO,TERMASUK_PPN,a_po.pbf_id,PBF_NAMA,no_spph,k.ID,k.NAMA from a_po inner join a_pbf on a_po.pbf_id=a_pbf.pbf_id left join a_spph on a_spph.spph_id=a_po.FK_SPPH_ID inner join a_kepemilikan k on a_po.KEPEMILIKAN_ID=k.ID where month(TANGGAL)=$bulan and year(TANGGAL)=$ta".$filter." group by no_po order by ".$sorting;
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
				$arfhapus="act*-*delete*|*no_po*-*".$rows['no_po']."*|*no_spph*-*".$rows['no_spph'];
			  ?>
                <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
                  <td class="tdisikiri"><?php echo $i; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['tgl1']; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['no_po']; ?></td>
                  <td class="tdisi" align="center">&nbsp;<?php echo $rows['no_spph']; ?></td>
                  <td id="<?php echo $rows['no_po']; ?>" class="tdisi" align="center" style="cursor:pointer" title="Klik Untuk Mengubah No SPK" onClick="IsiNoSPK(this);"><?php echo (($rows['KET']=='')?'&nbsp;':$rows['KET']); ?></td>
                  <td class="tdisi" align="left"><?php echo $rows['PBF_NAMA']; ?></td>
                  <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
                  <td width="31" class="tdisi"><img src="../icon/lihat.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Melihat Detail PO" onClick="location='?f=../mc/po_detail.php&no_po=<?php echo $rows['no_po']; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>&page=<?php echo $page; ?>'"></td>
                  <td width="31" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="location='?f=../mc/po_edit.php&no_po=<?php echo $rows['no_po']; ?>&no_spph=<?php echo $rows['no_spph']; ?>&tgl_po=<?php echo $rows['tgl2']; ?>&pbf_id=<?php echo $rows['pbf_id']; ?>&pbf=<?php echo $rows['PBF_NAMA']; ?>&kp_id=<?php echo $rows['ID']; ?>&kp_nama=<?php echo $rows['NAMA']; ?>&chk_ppn1=<?php echo $rows['TERMASUK_PPN']; ?>&updt_harga=<?php echo $rows['UPDT_H_NETTO']; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>&page=<?php echo $page; ?>'"></td>
                  <td width="30" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data ?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
                </tr>
                <?php 
			  }
			  mysqli_free_result($rs);
			  ?>
                <tr> 
                  <td colspan="5" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
                      <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
                  <td align="right" colspan="6"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
                    <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
                    <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
                    <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;                  </td>
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
<script>
function trim(str){
    return str.replace(/^\s+|\s+$/g,'');
}

function IsiNoSPK(p){
	var tmpnospk=p.innerHTML;
	var nospk = prompt('Masukkan No SPK', (tmpnospk=='&nbsp;')?'':tmpnospk);
	if (nospk!=null && trim(nospk)!=tmpnospk){
		if (trim(nospk)=='' && (tmpnospk=='&nbsp;' || tmpnospk=='')){
			alert("Masukkan No SPK / Nota Dinas Terlebih Dahulu !");
		}else{
			Request("../gudang/utils.php?act=UpdateSPK&noSPK="+trim(nospk)+"&noSPKLama="+tmpnospk+"&noPO="+p.id,p.id,"","GET","NOLOAD");
		}
	}
}
</script>
</body>
</html>
<?php 
mysqli_close($konek);
?>
<?php
session_start();
// Koneksi =================================
include("../sesi.php"); 
include("../koneksi/konek.php");
// Get ID  =================================
$iduser=$_SESSION['userId'];
$isview=$_REQUEST['isview'];
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$iunit=$_REQUEST['iunit'];
$act=$_REQUEST['act'];
$no_terima=$_REQUEST['no_terima'];
$tgl_terima = gmdate('Y-m-d',mktime(date('H')+7));
$no_terima2=$no_terima;
$tgl_terima2=$tgl_terima;
$no_terima1=$_GET['no_terima1'];
$tgl_terima1=$_GET['tgl_terima1'];
$no_minta=$_REQUEST['no_minta'];
$no_kirim=$_REQUEST['no_kirim'];
$tgl_kirim_awal=$_REQUEST['tgl_kirim'];
if ($tgl_kirim_awal!=""){
	$tgl_kirim=explode("/",$tgl_kirim_awal);
	$tgl_kirim1=$tgl_kirim[2]."-".$tgl_kirim[1]."-".$tgl_kirim[0];
}
if ($tgl_terima1!=""){
	$tgl_terima=explode("/",$tgl_terima1);
	$tgl_terima1=$tgl_terima[2]."-".$tgl_terima[1]."-".$tgl_terima[0];
}

$id_terima=$_REQUEST['id_terima'];
if(!empty($id_terima) && !empty($iunit)){
	$qry = "select UNIT_NAME from $dbapotek.a_unit where UNIT_TIPE=2 and UNIT_ISAKTIF=1 and UNIT_ID = '$iunit'";
	$exe = mysql_fetch_array(mysql_query($qry));
	$nama_unit = $exe['UNIT_NAME'];
	
	$sql= "select UNIT_KODE from $dbapotek.a_unit where UNIT_ID='$id_terima'";
	$query = mysql_fetch_array(mysql_query($sql));
	$kodeunit = $query['UNIT_KODE'];
}

switch ($act){
 	case "save":
		$sql="select NOTERIMA from $dbapotek.a_penerimaan where UNIT_ID_TERIMA=$id_terima and NOTERIMA like '$kodeunit/PT/$th[2]-$th[1]/%' order by right(NOTERIMA,4) desc limit 1";
		$rs=mysql_query($sql);
		if ($rows=mysql_fetch_array($rs)){
			$no_terima=$rows["NOTERIMA"];
			$arno_terima=explode("/",$no_terima);
			$tmp=$arno_terima[3]+1;
			$ctmp=$tmp;
			for ($i=0;$i<(4-strlen($tmp));$i++) $ctmp="0".$ctmp;
			$no_terima="$kodeunit/PT/$th[2]-$th[1]/$ctmp";
		}else{
			$no_terima="$kodeunit/PT/$th[2]-$th[1]/0001";
		}
	
		$fdata=$_REQUEST['fdata'];
		$arfvalue=explode("**",$fdata);
		for ($j=0;$j<count($arfvalue);$j++){
			$arfdata=explode("|",$arfvalue[$j]);
			//echo $arfdata[1]."-".$arfdata[2]."<br>";
			if ($arfdata[1]==$arfdata[2]){
				$sql="update $dbapotek.a_penerimaan set USER_ID_TERIMA=$iduser,NOBUKTI='$no_minta',NOTERIMA='$no_terima',STATUS=1,TGL_TERIMA='$tgl_terima',TGL_TERIMA_ACT='$tgl_act' where NOKIRIM='$no_kirim' and OBAT_ID=$arfdata[0]";
				//echo $sql."<br>";
				$rs=mysql_query($sql);				
			}else{
				$selisih=$arfdata[1]-$arfdata[2];
				$sql="select * from $dbapotek.a_penerimaan where NOKIRIM='$no_kirim' and OBAT_ID=$arfdata[0] order by ID desc";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				$ok="false";
				$selisih1=0;
				while (($rows=mysql_fetch_array($rs)) && ($ok=="false")){
					$cid=$rows['ID'];
					$cid_lama=$rows['ID_LAMA'];
					$cid_pinjam=$rows['FK_MINTA_ID'];
					$cstok=$rows['QTY_SATUAN'];
					if ($cstok>=$selisih){
						$ok=="true";
						if ($cstok>$selisih){
							$sql="update $dbapotek.a_penerimaan set QTY_SATUAN=QTY_SATUAN-$selisih , QTY_STOK=QTY_STOK-$selisih where ID=$cid";
						}else{
							$sql="delete from $dbapotek.a_penerimaan where ID=$cid";
						}
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
						$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK+$selisih where ID=$cid_lama";
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
						$sql="update $dbapotek.a_pinjam_obat set qty_kirim=qty_kirim-$selisih where peminjaman_id=$cid_pinjam";
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
					}else{
						$selisih=$selisih-$cstok;
						$sql="delete from $dbapotek.a_penerimaan where ID=$cid";
						//echo $sql."<br>";						
						$rs1=mysql_query($sql);
						$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK+$cstok where ID=$cid_lama";
						//echo $sql."<br>";
						$rs1=mysql_query($sql);					
						$sql="update $dbapotek.a_pinjam_obat set qty_kirim=qty_kirim-$cstok where peminjaman_id=$cid_pinjam";
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
					}
				}			
				$sql="update $dbapotek.a_penerimaan set USER_ID_TERIMA=$iduser,NOBUKTI='$no_minta',NOTERIMA='$no_terima',STATUS=1,TGL_TERIMA='$tgl_terima',TGL_TERIMA_ACT='$tgl_act' where NOKIRIM='$no_kirim' and OBAT_ID=$arfdata[0]";
				//echo $sql."<br>";
				$rs=mysql_query($sql);				
			}
		}
		$sql="update $dbapotek.a_pinjam_obat api inner join (select distinct FK_MINTA_ID,sum(QTY_STOK) as jml from $dbapotek.a_penerimaan where NOKIRIM='$no_kirim' group by FK_MINTA_ID) as t1 on api.peminjaman_id=t1.FK_MINTA_ID set api.qty_terima=qty_terima+t1.jml";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		$sql="update $dbapotek.a_pinjam_obat api inner join (select distinct FK_MINTA_ID from $dbapotek.a_penerimaan where NOKIRIM='$no_kirim') as t1 on api.peminjaman_id=t1.FK_MINTA_ID set api.status=2 where api.qty_terima>=api.qty";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<!-- untuk ajax-->
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<!-- end untuk ajax-->
<!--dibawah ini diperlukan untuk menampilkan popup-->
<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
<script type="text/javascript" src="../theme/prototype.js"></script>
<script type="text/javascript" src="../theme/effects.js"></script>
<script type="text/javascript" src="../theme/popup.js"></script>
<!--diatas ini diperlukan untuk menampilkan popup-->
<script>
var bln = '<?php echo date('m'); ?>';
var thn = '<?php echo date('Y'); ?>';
var arrRange=depRange=[];
</script>
<title>Daftar Peminjaman Obat</title>
</head>

<body>
<div align="center">
<?php
	include("../header1.php");
?>
<iframe height="72" width="130" name="sort"
id="sort"
src="../theme/dsgrid_sort.php" scrolling="no"
frameborder="0"
style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div style="display:block;">
<?php
	if($isview == "false"){
?>	
<table width="1000px" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;PROSES PENERIMAAN OBAT</td>
	</tr>
</table>
<form name="form1" method="post" action="">
  	<input name="act" id="act" type="text" placeholder="act" value="save">
	<input name="fdata" id="fdata" type="text" placeholder="fdata" value="">
	<input name="isview" id="isview" type="text" placeholder="isview" value="<?php echo $isview; ?>">
	<input name="iunit" id="iunit" type="text" placeholder="iunit" value="<?php echo $iunit; ?>">
	<input name="no_kirim" id="no_minta" type="text" placeholder="no_kirim" value="<?php echo $no_kirim; ?>">
	<input name="no_terima1" id="no_terima1" type="text" placeholder="no_terima1" value="<?php echo $no_terima1; ?>">
	<input name="tgl_terima1" id="tgl_terima1" type="text" placeholder="tgl_terima1" value="<?php echo $tgl_terima1; ?>">
<div id="pilihan" style="background:#EAF0F0; width:1000px; text-align:left;">
<table width="1000px">
	<tr>
		<td colspan="5" align="center"><h2>DETAIL PEMINJAMAN OBAT DARI UNIT <?php echo strtoupper($nama_unit); ?></h2></td>
	</tr>
	<tr>
	  <td width="40">&nbsp;</td>
	  <!--td width="120">No Penerimaan</td>
	  <td width="290">: 
		<input name="no_terima" type="text" id="no_terima" size="25" maxlength="30" class="txtcenter" readonly="true" value="<?php //echo $no_terima; ?>"></td--->
	  <td width="112">No Pengiriman</td>
	  <td width="215">: <?php echo $no_kirim; ?></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>Tgl Pengiriman</td>
	  <td>: <?php echo $tgl_kirim_awal; ?></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>Tgl Penerimaan</td>
	  <td>: 
		<input name="tgl_terima" type="text" id="tgl_terima" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl; ?>"> 
		<input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_terima,depRange);" /> 
	  </td>
	  <td>&nbsp;</td>
	  <td align="right" style="padding-right:50px;">
		<BUTTON type="button" onClick="if(ValidateForm('qty_terima','ind')){fSubmit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Terima&nbsp;&nbsp;</BUTTON>
		&nbsp;<BUTTON type="reset" onClick="location='list_pinjam_terima.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
	  </td>
	</tr>
</table>
</div>	
<table width="1000px" border="0" cellspacing="1" cellpadding="0" align="center" class="tabel">
	<tr>
		<td colspan="4" align="center">
			<div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
			<div id="paging" style="width:900px;"></div>
		</td>
	</tr>
	<tr>
		<td colspan="4" align="center">&nbsp;</td>
	</tr>
</table>
</form>
<?php } else {?>
<table width="1000px" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;PROSES PENERIMAAN OBAT</td>
	</tr>
</table>
<table width="1000px" border="0" cellspacing="1" cellpadding="0" align="center" class="tabel">
	<tr>
		<td colspan="4" align="center">
			<div id="coba" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
			<div id="paging2" style="width:900px;"></div>
		</td>
	</tr>
	<tr>
		<td colspan="4" align="center">&nbsp;</td>
	</tr>
</table>
<?php }?>
</div>
</div>
<script type="text/javascript">
	//alert("isi_terima_detail_util.php?grd=2&no_kirim=<?=$no_kirim?>&id_terima=<?=$id_terima?>&bulan=<?=$tgl_kirim[1]?>&tahun=<?=$tgl_kirim[2]?>");
<?php
	if($isview == "false"){
?>	
	var a=new DSGridObject("gridbox");
	a.setHeader("DAFTAR OBAT");	
	a.setColHeader("No,Kode Obat,Nama Obat,Satuan,Kepemilikan,Kepemilikan Asal,Qty Minta,QTY Kirim,Qty Terima");
	a.setIDColHeader(",OBAT_KODE,OBAT_NAMA,OBAT_SATUAN_KECIL,NAMA,NAMA1,qty,qty_kirim,");
	a.setColWidth("50,70,200,80,100,100,60,60,80");
	a.setCellAlign("center,center,left,center,center,center,center,center,center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	//a.attachEvent("onRowClick","ambilData");
	a.baseURL("isi_terima_detail_util.php?grd=1&no_kirim=<?=$no_kirim?>&id_terima=<?=$id_terima?>&bulan=<?=$tgl_kirim[1]?>&tahun=<?=$tgl_kirim[2]?>");
	a.Init();
<?php
	}else{
?>	
	var b1 = new DSGridObject("coba");
	b1.setHeader("DAFTAR OBAT");	
	b1.setColHeader("No, Kode Obat, Nama Obat, Satuan, Kepemilikan, Kepemilikan Asal, Qty Minta, Qty Terima");
	b1.setIDColHeader(", OBAT_KODE, OBAT_NAMA, OBAT_SATUAN_KECIL, NAMA, NAMA1, qty, qty_terima");
	b1.setColWidth("50,70,200,80,100,100,60,60");
	b1.setCellAlign("center,center,left,center,center,center,center,center");
	b1.setCellHeight(20);
	b1.setImgPath("../icon");
	b1.setIDPaging("paging2");
	//b.attachEvent("onRowClick","ambilData");
	b1.baseURL("isi_terima_detail_util.php?grd=2&no_kirim=<?=$no_kirim?>&id_terima=<?=$id_terima?>&bulan=<?=$tgl_terima[1]?>&tahun=<?=$tgl_terima[2]?>");
	b1.Init();
<?php
	}
?>
	
	function goFilterAndSort(grd){
		if (grd=="gridbox"){
			a.loadURL("isi_terima_detail_util.php?grd=1&no_kirim=<?=$no_kirim?>&id_terima=<?=$id_terima?>&bulan=<?=$tgl_kirim[1]?>&tahun=<?=$tgl_kirim[2]?>&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		} else if (grd=="gridbox2"){
			b.loadURL("isi_terima_detail_util.php?grd=2&no_kirim=<?=$no_kirim?>&id_terima=<?=$id_terima?>&bulan=<?=$tgl_kirim[1]?>&tahun=<?=$tgl_kirim[2]?>&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
		}
	}
	
	function fSubmit(){
	var cdata='';
	var x;
		if (document.form1.qty_terima.length){
			for (var i=0;i<document.form1.qty_terima.length;i++){
				cdata +=document.form1.qty_kirim[i].value+'|'+document.form1.qty_terima[i].value+'**';
			}
			if (cdata!=""){
				cdata=cdata.substr(0,cdata.length-2);
			}else{
				alert("Isikan Jml Item Obat Yg Mau Diterima Terlebih Dahulu !");
				return false;
			}
		}else{
			if (document.form1.qty_terima.value==""){
				alert("Isikan Jml Item Obat Yg Mau Diterima Terlebih Dahulu !");
				return false;
			}
			cdata +=document.form1.qty_kirim.value+'|'+document.form1.qty_terima.value;
		}
		//alert(cdata);
		document.form1.fdata.value=cdata;
		document.form1.submit();
	}
</script>
</body>
</html>

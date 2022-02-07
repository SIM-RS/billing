<?php
include("../sesi.php"); 
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit1=$_SESSION["ses_idunit"];
$idunit=$_REQUEST['idunit'];if ($idunit=="") $idunit=$idunit1;
if($idunit=="0" OR $idunit=="1") $junit=" AND a.UNIT_ID<>20"; else $junit=" AND a.UNIT_ID=$idunit";
/*$sql="select UNIT_NAME from a_unit where UNIT_ID=$idunit";
$rs=mysqli_query($konek,$sql);
$u=mysqli_fetch_array($rs);
$unit=$u['UNIT_NAME'];*/
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$minta_id=$_REQUEST['minta_id'];
$jns_pasien=$_REQUEST['jns_pasien'];if($jns_pasien=="" OR $jns_pasien=="0") $jns_p=""; else $jns_p=" and u.status_inap=$jns_pasien";
$kategori=$_REQUEST['kategori'];if ($kategori=="") $fkategori=""; else $fkategori=" AND ao.OBAT_KATEGORI=$kategori";

$tgl_d=$_REQUEST['tgl_d'];
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
$tgl_s=$_REQUEST['tgl_s'];
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";
//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
$defaultsort="a.TGL DESC,a.ID DESC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<script language="JavaScript" src="../theme/js/mod.js"></script>
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
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" /><strong></strong>
</head>
<body>
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:20px; text-align:right;'>");
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
	src="../theme/sort1.php" scrolling="no"
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
      <p><span class="jdltable">BUKU PENJUALAN 
        <select name="idunit" id="idunit" class="txtinput" onchange="location='?f=../apotik/buku_penjualan.php&idunit='+this.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&kategori='+kategori.value">
          <option value="0" class="txtinput">ALL UNIT</option>
          <?
		  $unit="ALL UNIT";
		  $qry="select * from a_unit where UNIT_TIPE=2 and UNIT_ISAKTIF=1";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
		  	$i++;
			//if (($idunit=="")&&($i==1)) $idunit=$show['UNIT_ID'];
		  ?>
          <option value="<?=$show['UNIT_ID'];?>" class="txtinput"<?php if ($idunit==$show['UNIT_ID']){echo "selected";$unit=$show['UNIT_NAME'];}?>> 
          <?php echo $show['UNIT_NAME'];?></option>
          <? }?>
        </select>
        </span> 
      <table width="48%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
		<tr> 
          <td width="127">Tanggal Periode</td>
          <td colspan="2">: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_d']<>'') echo $_GET['tgl_d']; else echo $tgl;?>" onchange="location='?f=../apotik/buku_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value" /></input>
			<input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/>&nbsp;&nbsp;</input>s/d&nbsp;&nbsp;<input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" onchange="location='?f=../apotik/buku_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value" value="<?php if ($_GET['tgl_s']<>'') echo $_GET['tgl_s']; else echo $tgl;?>" ></input> 
			<input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" /></input>
		  </td>
		</tr>
		<tr>
			<td>Kategori Obat</td>
			<td colspan="2">:
				<select name="kategori" id="kategori" class="txtinput" onChange="location='?f=buku_penjualan.php&idunit='+idunit.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&kategori='+kategori.value" >
				<option value="" class="txtinput"<?php if ($kategori==""){echo " selected";$f1="SEMUA";}?>>SEMUA</option>
				  <?php 
				  $j1="SEMUA";
				  $sql="select * from a_obat_kategori";
				  $rs=mysqli_query($konek,$sql);
				  while ($rows=mysqli_fetch_array($rs)){
				  ?>
				  <option value="<?php echo $rows['id']; ?>" class="txtinput"<?php if ($kategori==$rows['id']){echo " selected";$f1=$rows['kategori'];}?>><?php echo $rows['kategori']; ?></option>
				  <?php }?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="127">Jenis Pasien </td>
            <td width="162">: 
			<select name="jns_pasien" id="jns_pasien" class="txtinput" onchange="location='?f=buku_penjualan.php&idunit='+idunit.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&kategori='+kategori.value">
                <option value="0" class="txtinput">All Pasien</option>
                <option value="1" class="txtinput"<?php if ($jns_pasien=="1") echo "selected";?>>Rawat Inap</option>
                <option value="2" class="txtinput"<?php if ($jns_pasien=="2") echo "selected";?>>Rawat Jalan</option>
                <option value="3" class="txtinput"<?php if ($jns_pasien=="3") echo "selected";?>>IGD</option>
              </select>			  </td>
			<td width="194" >
			  <button type="button" onclick="location='?f=../apotik/buku_penjualan.php&idunit='+idunit.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&kategori='+kategori.value">
			  <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button></td>
	    </tr>		
	</table>
      <table width="98%" align="center" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="a.TGL" width="70" class="tblheader" onclick="ifPop.CallFr(this);">Tgl 
            Act</td>
          <td id="NO_PENJUALAN" width="70" class="tblheader" onclick="ifPop.CallFr(this);">No 
            Penjualan</td>
          <td width="150" class="tblheader" id="NAMA_PASIEN" onclick="ifPop.CallFr(this);">Nama 
            Pasien</td>
          <td id="OBAT_NAMA" class="tblheader" onclick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="ok.kategori" width="82" class="tblheader" onclick="ifPop.CallFr(this);">Kategori</td>
          <td id="ak.NAMA" width="82" class="tblheader" onclick="ifPop.CallFr(this);">Kepemilikan</td>
          <td width="40" class="tblheader">Qty</td>
          <td id="u.UNIT_NAME" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Harga</td>
          <td id="u.UNIT_NAME" width="90" class="tblheader" onclick="ifPop.CallFr(this);">Poli<br>
            (Ruangan)</td>
          <td id="DOKTER" width="90" class="tblheader" onclick="ifPop.CallFr(this);">Dokter</td>
          <!--td class="tblheader" width="30">Proses</td-->
        </tr>
        <?php 
		$ifilter="";
	  if ($filter!=""){
	  $jfilter=$filter;
	  	$tfilter=explode("*-*",$filter);
		$filter="";
		for ($k=0;$k<count($tfilter);$k++){
			$ifilter=explode("|",$tfilter[$k]);
			$filter .=" and ".$ifilter[0]." like '%".$ifilter[1]."%'";
			//echo $filter."<br>";
		}
	  }
/*	  if ($filter!=""){
		$filter=explode("|",$filter);
		if ($filter[0]=="USER") $filter[0]="(select username from a_user where kode_user=a_penjualan.USER_ID)";
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
*/
	  if ($sorting=="") $sorting=$defaultsort;
	  	if ($_GET['tgl_d']=='') $tgl_1=$tgl2; else $tgl_1=$tgl_de;
	  	if ($_GET['tgl_s']=='') $tgl_2=$tgl2; else $tgl_2=$tgl_se;
	  $sql="SELECT DATE_FORMAT(a.TGL,'%d/%m/%Y') AS tgl1,a.NO_PENJUALAN,ok.kategori,a.NAMA_PASIEN,ao.OBAT_NAMA,SUM(a.QTY_JUAL-a.QTY_RETUR) AS QTY_JUAL,
		ak.NAMA,u.UNIT_NAME,SUM(a.QTY_JUAL-a.QTY_RETUR)*HARGA_SATUAN AS H_JUAL,a.DOKTER FROM a_penjualan a INNER JOIN a_penerimaan ap ON a.PENERIMAAN_ID=ap.ID INNER JOIN a_obat ao 
		ON ap.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON a.JENIS_PASIEN_ID=ak.ID
		LEFT JOIN (SELECT * FROM a_unit WHERE UNIT_TIPE=3) AS u ON a.RUANGAN=u.UNIT_ID
		LEFT JOIN a_obat_kategori ok ON ok.id = ao.OBAT_KATEGORI
		WHERE a.TGL BETWEEN '$tgl_1' AND '$tgl_2'".$junit.$jns_p.$filter.$fkategori."
		GROUP BY a.NO_PENJUALAN,a.TGL,ap.OBAT_ID
		ORDER BY ".$sorting;
	//echo $sql."<br>";
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
	  $i=($page-1)*$perpage;
	  $tmpNP='';
	  while ($rows=mysqli_fetch_array($rs)){
		//$i++;
		//$jRetur=$rows['jRetur'];
		//$tCaraBayar=$rows['CARA_BAYAR'];
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
		<?php
			if($tmpNP != $rows['NO_PENJUALAN']){
		?>
          <td class="tdisikiri"><?php echo ++$i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NO_PENJUALAN']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['NAMA_PASIEN']; ?></td>
		<?php
			} else {
		?>
		  <td class="tdisikiri">&nbsp;</td>
          <td class="tdisi" align="center">&nbsp;</td>
          <td class="tdisi" align="center">&nbsp;</td>
          <td class="tdisi" align="left">&nbsp;</td>
		<?php
			}
			$tmpNP = $rows['NO_PENJUALAN'];
		?>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['kategori']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['QTY_JUAL']; ?></td>
          <td align="right" class="tdisi"><?php echo number_format($rows['H_JUAL'],0,",","."); ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi">&nbsp;<?php echo $rows['DOKTER']; ?></td>
          <?php if ($tCaraBayar==4){?>
          <?php }?>
        </tr>
        <?php
	 //$hartot=$hartot+$rows['HARGA_TOTAL'];
	  }
	  mysqli_free_result($rs);
	  $sql2="select sum(t1.QTY_JUAL) as jtot,sum(t1.H_JUAL) as totjual from (".$sql.")as t1";
	  $hs=mysqli_query($konek,$sql2);
	  $jtot=0;$totjual=0;
	  $show=mysqli_fetch_array($hs);
	  $jtot=$show['jtot'];
	  $totjual=$show['totjual'];
	  //$sql2="SELECT COUNT(t2.NO_RESEP) AS jml_resep FROM (SELECT DISTINCT t1.NO_RESEP FROM (".$sql.") AS t1) AS t2";
	  //$rs=mysqli_query($konek,$sql2);
	  //$totresep=0;
	  //if ($rows=mysqli_fetch_array($rs))	$totresep=$rows['jml_resep'];  
	  ?>
        <tr> 
          <td colspan="7"  align="right" class="txtright">Jumlah Total &nbsp; 
          </td>
          <td align="center" class="txtcenter"><?php echo number_format($jtot,0,",","."); ?></td>
          <td align="right" class="txtright"><?php echo number_format($totjual,0,",","."); ?></td>
          <td colspan="2" align="right" class="txtright">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="6"  align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="4" align="right" class="txtright"><img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onclick="document.form1.act.value='paging';document.form1.page.value='1';document.form1.submit();" /> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $bpage; ?>';document.form1.submit();" /> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $npage; ?>';document.form1.submit();" /> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $totpage; ?>';document.form1.submit();" />&nbsp;&nbsp; 
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="10"><a class="navText" href='#' onclick='PrintArea("idArea","#")'>&nbsp; 
            <button type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><img src="../icon/printer.png" border="0" width="16" height="16" align="absmiddle" />&nbsp;Cetak 
            Buku Penjualan</button>
            </a>&nbsp;<BUTTON type="button" onClick="BukaWndExcell();" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export 
            ke File Excell</BUTTON></td>
        </tr>
      </table>
	</div>
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	  <p align="center"><span class="jdltable">BUKU PENJUALAN <? echo strtoupper($unit) ?></span> 
      <table width="48%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="177" class="txtcenter">( <?php if ($_GET['tgl_d']!="") echo $_GET['tgl_d']; else echo $tgl;?> s/d 
            <?php if ($_GET['tgl_s']!="") echo $_GET['tgl_s']; else echo $tgl;?> ) </td>
        </tr>
        <tr> 
          <td width="127" class="txtcenter">Jenis Pasien : 
            <?
					if ($jns_pasien==""){
						echo "ALL PASIEN";
					}else{
					  $qry="select ID,NAMA from a_kepemilikan where AKTIF=1 and ID=$jns_pasien order by ID";
					  $exe=mysqli_query($konek,$qry);
					  $show=mysqli_fetch_array($exe);
					  //echo $qry."<br>";
					  if ($show['NAMA']=="") echo "ALL PASIEN"; else echo $show['NAMA'];
					}
					?>
          </td>
        </tr>
      </table>
      <table width="98%" align="center" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td id="" width="31" height="25" class="tblheaderkiri" onclick="">No</td>
          <td id="TGL_ACT" width="70" class="tblheader" onclick="">Tgl Act</td>
          <td id="NO_KUNJUNGAN" width="70" class="tblheader">No Penjualan</td>
          <td width="150" class="tblheader" id="NAMA_PASIEN">Nama Pasien</td>
          <td id="NAMA_PASIEN" class="tblheader">Nama Obat</td>
          <td id="kategori" width="82" class="tblheader">Kategori</td>
          <td id="NAMA" width="82" class="tblheader">Kepemilikan</td>
          <td width="40" class="tblheader" id="NAMA_PASIEN">Qty</td>
          <td id="NAMA" width="80" class="tblheader">Harga</td>
          <td id="NAMA" width="120" class="tblheader">Poli<br>
            (Ruangan)</td>
          <td id="SUM_SUB_TOTAL" width="160" class="tblheader">Dokter</td>
          <!--td class="tblheader" width="30">Proses</td-->
        </tr>
        <?php 
	  $rs=mysqli_query($konek,$sql);
	  $p=0;
	  $tmpNP = "";
	  while ($rows=mysqli_fetch_array($rs)){
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
		<?php
			if($tmpNP != $rows['NO_PENJUALAN']){
		?>
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo ++$p; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NO_PENJUALAN']; ?></td>
          <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['NAMA_PASIEN']; ?></td>
		<?php
			} else {
		?>
		  <td class="tdisikiri" align="center" style="font-size:12px;">&nbsp;</td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;</td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;</td>
          <td class="tdisi" align="left" style="font-size:12px;">&nbsp;</td>
		<?php
			}
			$tmpNP = $rows['NO_PENJUALAN'];
		?>
          <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['kategori']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['QTY_JUAL']; ?></td>
          <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['H_JUAL'],0,",","."); ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['DOKTER']; ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="7"  align="right" class="txtright">Jumlah Total &nbsp; 
          </td>
          <td align="right" class="txtright"><?php echo number_format($jtot,0,",","."); ?></td>
          <td align="right" class="txtright"><?php echo number_format($totjual,0,",","."); ?></td>
          <td colspan="2" align="right" class="txtright">&nbsp;</td>
        </tr>
      </table>
	</div>
    </form>
  </div>
</body>
<script language="javascript">
function BukaWndExcell(){
var tgld=tgl_d.value;
var tgls=tgl_s.value;
var idunit1=idunit.value;
var jpasien=jns_pasien.value;
	//alert('../apotik/buku_penjualan_excell.php?tgl_d='+tgld+'&tgl_s='+tgls+'&idunit1='+idunit1+'&jns_pasien='+jpasien);
	OpenWnd('../apotik/buku_penjualan_excell.php?tgl_d='+tgld+'&tgl_s='+tgls+'&idunit1='+idunit1+'&jns_pasien='+jpasien+'&filter=<?php echo $jfilter; ?>&sorting=<?php echo $sorting; ?>&kategori=<?php echo $kategori; ?>',600,450,'childwnd',true);
}
</script>
</html>

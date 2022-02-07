<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$username = $_SESSION["username"];
$tgl_ctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
convert_var($username,$tgl_ctk);
//================================================
$cid=$_REQUEST['obat_id'];
$ckpid=$_REQUEST['kepemilikan_id'];
$cunit_id=$_REQUEST['unit_id'];
$tgl_d=$_REQUEST["tgl_d"];
$tgl_s=$_REQUEST["tgl_s"];
convert_var($cid,$ckpid,$cunit_id,$tgl_d,$tgl_s);


if ($tgl_d=="") $tgl_d=gmdate('01-m-Y',mktime(date('H')+7));
$tgl_d1=explode("-",$tgl_d);$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
if ($tgl_s=="") $tgl_s=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_s1=explode("-",$tgl_s);$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ID DESC";
$order = $_REQUEST['order'];
$sorting=$_REQUEST["sorting"];
$ob=$_GET['obat_id'];
$un=$_GET['unit_id'];
$kep=$_GET['kepemilikan_id'];

convert_var($page,$sorting,$order,$ob,$un);
convert_var($kep);
//===============================
   //Ambil Nama Obat----
  $qryObat=mysqli_query($konek,"select OBAT_NAMA,OBAT_KODE,OBAT_SATUAN_KECIL from a_obat where OBAT_ID=$ob");
  $rowsObat=mysqli_fetch_array($qryObat);
  //------------
  //Ambil nama Unit
  $qryUnit=mysqli_query($konek,"select UNIT_NAME from a_unit where UNIT_ID=$un");
  $rowsUnit=mysqli_fetch_array($qryUnit);
  $qryKep=mysqli_query($konek,"select NAMA from a_kepemilikan where ID=$kep");
  $rowsKep=mysqli_fetch_array($qryKep);
?>
<html>
<head>
<title>Kartu Stok</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/print.css" type="text/css" /></head>
<script>
	function PrintArea(printOut,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=900,resizable,scrollbars')
	winpopup.document.write(document.getElementById(printOut).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tgl_ctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<body>
<script>
var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="unit_id" id="unit_id" type="hidden" value="<?php echo $cunit_id; ?>">
  <input name="obat_id" id="obat_id" type="hidden" value="<?php echo $cid; ?>">
  <input name="kepemilikan_id" id="kepemilikan_id" type="hidden" value="<?php echo $ckpid; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
	  <table>
        <tr>
			<td>
				<input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /></input>
        		<input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/>
				&nbsp;s/d 
				<input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /></input>
        		<input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
			</td>
			<td rowspan="2">
				<button type="button" onClick="location='?f=../master/kartu_stok.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&unit_id='+unit_id.value+'&obat_id='+obat_id.value+'&kepemilikan_id='+kepemilikan_id.value"> <!-- +'&order='+order.value -->
				<img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button>
			</td>
		</tr>
		<!--tr>
			<td style="font-size:12px;">
				Order by : <select name="order" id="order">
					<option value="0" <?php //if($order != 1) echo "selected";?> >Tanggal KS</option>
					<option value="1" <?php //if($order == 1) echo "selected";?> >ID KS</option>
				</select>
			</td>
		</tr-->
	  </table>
	  <p><span style="font-size:16px;font-weight:bold">K A R T U &nbsp;P E R S E D I A A N </span></p>
      <table width="98%" style="font-size:12px; font-weight:bold"  >
        <tr>
          <td width="163">UNIT</td>
          <td width="26">:</td>
          <td width="757"><?php echo $rowsUnit['UNIT_NAME'];?></td>
          <td width="127">N. REK </td>
          <td width="18">:</td>
          <td width="221">&nbsp;</td>
        </tr>
        <tr>
          <td width="163">NAMA BARANG </td>
          <td width="26">:</td>
          <td width="757"><?php echo $rowsObat['OBAT_NAMA'];?></td>
          <td>KODE BARANG </td>
          <td>:</td>
          <td><?php echo $rowsObat['OBAT_KODE'];?></td>
        </tr>
        <tr>
          <td>SATUAN</td>
          <td>:</td>
          <td><?php echo $rowsObat['OBAT_SATUAN_KECIL'];?></td>
          <td>No. KARU </td>
          <td>:</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>PERIODE</td>
          <td>:</td>
          <td><?php echo $tgl_d; ?>&nbsp;s/d&nbsp;<?php echo $tgl_s; ?></td>
          <td>LEMBAR</td>
          <td>:</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="98%" border="1" align="center" cellpadding="1" cellspacing="0" style="border-collapse:collapse; font-size:12px">
        <tr style="font-weight:bold" align="center" bgcolor="#CCCCCC">
          <td width="105" rowspan="2" >TANGGAL</td> 
          <td width="90" rowspan="2" >NO. BUKTI </td>
          <td width="232" rowspan="2" >URAIAN</td>
          <td height="25" colspan="3" >PEMBELIAN</td>
          <td colspan="3" >PEMAKAIAN</td>
          <td colspan="3" >SISA</td>
        </tr>
        <tr bgcolor="#CCCCCC"  align="center" style="font-weight:bold">
          <td width="69" height="23" >BOX FLS </td>
          <td width="91" >@ Rp</td>
          <td width="97" >JUMLAH</td>
          <td width="72" >BOX FLS </td>
          <td width="92" >@ Rp </td>
          <td width="107" >JUMLAH</td>
          <td width="103" >BOX FLS </td>
          <td width="86" >@ Rp </td>
          <td width="116" >JUMLAH</td>
        </tr>
        <?php 
		/* if ($sorting=="" && $order == 0){
			$sorting=$defaultsort;
		} else if ($sorting=="" && $order == 1){
			$sorting='ID DESC';
		} */
		
		if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT ID,
	  
	   OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR ,SUM(DEBET) DEBET, SUM(KREDIT) KREDIT,STOK_AFTER,
	   KET,USER_ID,fkid,tipetrans,HARGA_SATUAN_AWAL,NILAI_TOTAL,HARGA_SATUAN
	  
	   FROM (select *from a_kartustok  where OBAT_ID=".$cid." AND KEPEMILIKAN_ID=".$ckpid." AND UNIT_ID=".$cunit_id." AND DATE(TGL_ACT) BETWEEN '$tgl_d1' AND '$tgl_s1' order by id desc) t
	  
	  group by NO_BUKTI,KET,TGL_TRANS,OBAT_ID
	  
	   ORDER BY ".$sorting;
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";
		//echo $sql2;
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  $rs=mysqli_query($konek,$sql2);
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		//$nrata2=($rows['STOK_AFTER']==0)?0:$rows['NILAI_TOTAL']/$rows['STOK_AFTER'];
		
		$cqty=($rows['DEBET']>=$rows['KREDIT'])?($rows['DEBET']-$rows['KREDIT']):($rows['KREDIT']-$rows['DEBET']);
		
		if ($rows["fkid"]==0){
			$sqlTrans="SELECT MAX(HARGA_BELI_SATUAN) AS harga FROM a_harga WHERE OBAT_ID=".$cid." AND KEPEMILIKAN_ID=".$ckpid;
		}else{
			$sqlTrans="SELECT IF(NILAI_PAJAK<=0,HARGA_BELI_SATUAN * (1-(DISKON/100)),HARGA_BELI_SATUAN * (1-(DISKON/100)) /* 1.1*/) AS harga 
FROM a_penerimaan WHERE ID=".$rows["fkid"];
		}
		$rsTrans=mysqli_query($konek,$sqlTrans);
		$rwTrans=mysqli_fetch_array($rsTrans);
		
		
		if ($rows["tipetrans"]==0){
			$hrg = $rows["HARGA_SATUAN_AWAL"];
		}else{	
			$hrg = $rows["HARGA_SATUAN"];
		}
		
		
	  ?>
        <tr>
          <td  align="center" style="font-size:12px;"><?php echo date("d/m/Y",strtotime($rows['TGL_ACT'])); ?></td> 
          <td  align="center" style="font-size:12px;"><?php  echo $rows['NO_BUKTI'];?></td>
          <td  align="left" style="font-size:12px;">&nbsp;
			<?php
				  if($un==7){
				  $funit = " AND p.cabang_id = 1";
				  }elseif($un==8){
				  $funit = " AND p.cabang_id = 2";
				  }else{
				  $funit = " AND p.cabang_id = 3";
				  }
			
			
				$ket = explode(" ",$rows['KET']);
				if($ket[0]=='Jual:' && $rows["ID"] < 94165){
				
					$par = explode('-',$ket[1]);
					$sqlPas = "select nama from {$dbbilling}.b_ms_pasien p where p.no_rm = '".$par[1]."' $funit "; 
					$dataPas = mysqli_fetch_object(mysqli_query($konek,$sqlPas));
					//echo $sqlPas;
					echo $rows['KET'];
					echo "<br />&nbsp;Nama Pasien: ".$dataPas->nama;
					
					
				} else {
					echo $rows['KET'];
					
					}
			
			?>		  </td>
          <td  align="center" style="font-size:12px;"><?php if($rows['DEBET']>0) echo $rows['DEBET'];?></td>
          <td  align="right" style="font-size:12px;"><?php if($rows['DEBET']>0) echo number_format($rows["HARGA_SATUAN"],2,",",".");?>           &nbsp;</td>
          <td  align="right" style="font-size:12px;"><?php if($rows['DEBET']>0) echo number_format($rows["HARGA_SATUAN"]*$rows['DEBET'],2,",",".");?>&nbsp;</td>
          <td  align="center" style="font-size:12px;"><?php if($rows['KREDIT']>0)  echo $rows['KREDIT'];?></td>
          <td  align="right" style="font-size:12px;"><?php if($rows['KREDIT']>0) echo number_format($rows["HARGA_SATUAN"],2,",",".");?>&nbsp;</td>
          <td  align="right" style="font-size:12px;"><?php if($rows['KREDIT']>0) echo number_format($rows["HARGA_SATUAN"]*$rows['KREDIT'],2,",",".");?>&nbsp;</td>
          <td  align="center" style="font-size:12px;"><?php echo $rows['STOK_AFTER'];?></td>
          <td  align="right" style="font-size:12px;"><?php if($rows["NILAI_TOTAL"]>0) { echo number_format( $rows["NILAI_TOTAL"]/$rows['STOK_AFTER'],2,",",".");}else{echo '0';};?>&nbsp;</td>
          <td  align="right" style="font-size:12px;"><?php echo number_format($rows['NILAI_TOTAL'],2,",",".");?>&nbsp;</td>
        </tr>
        <?php 
	  }
	  $sql2="select if (sum(t2.DEBET) is null,0,sum(t2.DEBET)) as totDebit,if (sum(t2.KREDIT) is null,0,sum(t2.KREDIT)) as totKredit from (".$sql.") as t2";
	  // echo $sql2;
	  $rs=mysqli_query($konek,$sql2);
	  $totDebit=0;
	  $totKredit=0;
	  if ($rows=mysqli_fetch_array($rs)){
		  $totDebit=$rows["totDebit"];
		  $totKredit=$rows["totKredit"];
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="3" align="right"  style="font-size:12px;">Total&nbsp;</td>
          <td  align="center" style="font-size:12px;"><?php echo $totDebit;?></td>
          <td  align="right" style="font-size:12px;">&nbsp;</td>
          <td  align="right" style="font-size:12px;">&nbsp;</td>
          <td  align="center" style="font-size:12px;"><?php echo $totKredit;?></td>
          <td  align="right" style="font-size:12px;">&nbsp;</td>
          <td  align="right" style="font-size:12px;">&nbsp;</td>
          <td  align="right" style="font-size:12px;">&nbsp;</td>
          <td  align="right" style="font-size:12px;">&nbsp;</td>
          <td  align="right" style="font-size:12px;">&nbsp;</td>
        </tr>
      </table>
	  <table width="98%" align="center">
        <tr> 
        <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		<td width="111" colspan="3" align="right">
		
		<button title="Halaman Pertama" onClick="document.form1.submit();act.value='paging';page.value='1';"><<</button>
		<button title="Halaman Sebelumnya" onClick="document.form1.submit();act.value='paging';page.value='<?php echo $bpage; ?>';"><</button>
		<button title="Halaman Berikutnya" onClick="document.form1.submit();act.value='paging';page.value='<?php echo $npage; ?>';">></button>
		<button title="Halaman Terakhir" onClick="document.form1.submit();act.value='paging';page.value='<?php echo $totpage; ?>';">>></button>
		</td>
      </tr>
	</table>
	<p>
        <BUTTON type="button" <?php  if($i==0) echo "disabled='disabled'"; ?> onClick="PrintArea('printOut','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Kartu Stok</BUTTON>
	  <!--BUTTON type="button" <?php  //if($i==0) echo "disabled='disabled'"; ?> onClick="OpenWnd('../master/jualall_qty_excell.php?tgl_d1=<?php //echo $tgl_d1; ?>&tgl_s1=<?php //echo $tgl_s1; ?>&filter=<?php //echo $filter; ?>&sorting=<?php //echo $sorting; ?>',600,450,'childwnd',true);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON-->
	&nbsp;&nbsp;&nbsp;
	<BUTTON type="button" onClick="javascript:window.close();"><IMG SRC="../icon/del.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tutup&nbsp;</BUTTON>
	</p>
    </div>
	 <div id="printOut" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	
    <div align="left" style="padding-left:12px;" > <span style="font-size:12px;font-weight:bold"> PT. PELABUHAN INDONESIA I (PERSERO) </span><br>
        <span style="font-size:14px;font-weight:bold"> RUMAH SAKIT PELABUHAN MEDAN</span><br>
        <span style="font-size:10px;font-weight:bold; text-decoration:underline">Jl. Stasiun No 92 Telp. (161) 6941927 - 6940120 Belawan</span></div>
 
  <p align="center" style="font-size:16px;font-weight:bold">K A R T U &nbsp;P E R S E D I A A N </p>
  <table width="98%"  style="font-size:12px; font-weight:bold"  >
  	<tr>
  	  <td width="163">UNIT</td>
  	  <td width="26">:</td>
  	  <td width="757"><?php echo $rowsUnit['UNIT_NAME'];?></td>
  	  <td width="127">N. REK </td>
	  <td width="18">:</td>
	  <td width="221">&nbsp;</td>
	  </tr>
  	<tr>
  	  <td width="163">NAMA BARANG </td>
  	  <td width="26">:</td>
  	  <td width="757"><?php echo $rowsObat['OBAT_NAMA'];?></td>
  	  <td>KODE BARANG </td>
	  <td>:</td>
	  <td><?php echo $rowsObat['OBAT_KODE'];?></td>
	  </tr>
  	<tr>
  	  <td>SATUAN</td>
  	  <td>:</td>
  	  <td><?php echo $rowsObat['OBAT_SATUAN_KECIL'];?></td>
  	  <td>No. KARU </td>
  	  <td>:</td>
  	  <td>&nbsp;</td>
  	  </tr>
  	<tr>
  	  <td>PERIODE</td>
  	  <td>:</td>
  	  <td><?php echo $tgl_d; ?>&nbsp;s/d&nbsp;<?php echo $tgl_s; ?></td>
  	  <td>LEMBAR</td>
	    <td>:</td>
	    <td>&nbsp;</td>
	    </tr>
  </table>
  
  <table width="98%"  border="1" cellpadding="1" cellspacing="0" align="center" style="border-collapse:collapse; font-size:12px">
        <tr style="background:#CCCCCC; font-weight:bold;" align="center" >
          <td width="80" rowspan="2" id="TGL_ACT">TANGGAL</td>
          <td width="71" rowspan="2" id="KET" >NO. BUKTI </td>
          <td width="272" rowspan="2" id="KET" >URAIAN</td>
          <td height="26" colspan="3" id="DEBET" >PPEMBELIAN</td>
          <td colspan="3" id="DEBET" >PEMAKAIAN</td>
          <td colspan="3" id="DEBET" >SISA</td>
        </tr>
        <tr style="background:#CCCCCC; font-weight:bold;" align="center">
          <td width="72" id="DEBET" >BOX FLS </td>
          <td width="92" id="DEBET" >@ Rp </td>
          <td width="97" id="DEBET" >JUMLAH</td>
          <td width="75" id="DEBET" >BOX FLS </td>
          <td width="91" id="DEBET" >@ Rp </td>
          <td width="108" id="DEBET" >JUMLAH</td>
          <td width="73" id="DEBET" >BOX FLS </td>
          <td width="92" id="DEBET" >@ Rp </td>
          <td width="121" id="DEBET" >JUMLAH</td>
        </tr>
	  <?php 
	  //$sql="SELECT * FROM a_kartustok where OBAT_ID=".$_GET['obat_id']." AND KEPEMILIKAN_ID=".$_GET['kepemilikan_id']." AND UNIT_ID=".$_GET['unit_id']." ORDER BY ID desc";
	  $rs=mysqli_query($konek,$sql);
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
		$cqty=($rows['DEBET']>=$rows['KREDIT'])?($rows['DEBET']-$rows['KREDIT']):($rows['KREDIT']-$rows['DEBET']);
		if ($rows["fkid"]==0){
			$sqlTrans="SELECT MAX(HARGA_BELI_SATUAN) AS harga FROM a_harga WHERE OBAT_ID=".$cid." AND KEPEMILIKAN_ID=".$ckpid;
		}else{
			$sqlTrans="SELECT IF(NILAI_PAJAK<=0,HARGA_BELI_SATUAN * (1-(DISKON/100)),HARGA_BELI_SATUAN * (1-(DISKON/100)) /* 1.1*/) AS harga 
FROM a_penerimaan WHERE ID=".$rows["fkid"];
		}
		$rsTrans=mysqli_query($konek,$sqlTrans);
		$rwTrans=mysqli_fetch_array($rsTrans);
		
		if ($rows["tipetrans"]==0){
			$hrg = $rows["HARGA_SATUAN_AWAL"];
		}else{	
			$hrg = $rows["HARGA_SATUAN"];
		}
	  ?>
      <tr onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
		<td  align="center" style="font-size:12px;"><?php echo date("d/m/Y",strtotime($rows['TGL_ACT'])); ?></td>
        <td  align="left" style="font-size:12px;"><?php  echo $rows['NO_BUKTI'];?></td>
        <td  align="left" style="font-size:12px;">&nbsp;<?php echo $rows['KET']; ?></td>
        <td  align="center" style="font-size:12px;"><?php if($rows['DEBET']>0) echo $rows['DEBET'];?></td>
        <td  align="right" style="font-size:12px;"><?php if($rows['DEBET']>0) echo number_format($rows["HARGA_SATUAN"],2,",",".");?>&nbsp;</td>
        <td  align="right" style="font-size:12px;"><?php if($rows['DEBET']>0) echo number_format($rows["HARGA_SATUAN"]*$rows['DEBET'],2,",",".");?>&nbsp;</td>
        <td  align="center" style="font-size:12px;"><?php if($rows['KREDIT']>0)  echo $rows['KREDIT'];?></td>
        <td  align="right" style="font-size:12px;"><?php if($rows['KREDIT']>0) echo number_format($rows["HARGA_SATUAN"],2,",",".");?>
          &nbsp;</td>
        <td  align="right" style="font-size:12px;"><?php if($rows['KREDIT']>0) echo number_format($rows["HARGA_SATUAN"]*$rows['KREDIT'],2,",",".");?>
          &nbsp;</td>
        <td  align="center" style="font-size:12px;"><?php echo $rows['STOK_AFTER'];?></td>
        <td  align="right" style="font-size:12px;"><?php if($rows["NILAI_TOTAL"]>0) { echo number_format( $rows["NILAI_TOTAL"]/$rows['STOK_AFTER'],2,",",".");}else{echo '0';};?>
          &nbsp;</td>
        <td  align="right" style="font-size:12px;"><?php echo number_format($rows['NILAI_TOTAL'],2,",",".");?>&nbsp;</td>
      </tr>
	  <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="3" align="right"  style="font-size:12px;">Total&nbsp;</td>
          <td  align="right" style="font-size:12px;"><?php echo $totDebit;?></td>
          <td  align="right" style="font-size:12px;">&nbsp;</td>
          <td  align="right" style="font-size:12px;">&nbsp;</td>
          <td  align="right" style="font-size:12px;"><?php echo $totKredit;?></td>
          <td  align="right" style="font-size:12px;">&nbsp;</td>
          <td  align="right" style="font-size:12px;">&nbsp;</td>
          <td  align="right" style="font-size:12px;">&nbsp;</td>
          <td  align="right" style="font-size:12px;">&nbsp;</td>
          <td  align="right" style="font-size:12px;">&nbsp;</td>
        </tr>
    </table>
    </div>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
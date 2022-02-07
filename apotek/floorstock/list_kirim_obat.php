<?php 
include("../sesi.php"); 
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
$tgl_ctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$bulan=$_REQUEST['bulan'];
$ta=$_REQUEST['ta'];
convert_var($tgl2,$tgl_ctk,$idunit,$bulan,$ta);
if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
if ($ta=="") $ta=$th[2];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ap.TANGGAL DESC,ap.NOKIRIM DESC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; 
convert_var($page,$sorting,$filter);

// Jenis Aksi
//echo $act;
switch ($act){
	case "del":
		$cid=$_REQUEST["cid"];
		$cid_lama=$_REQUEST["cid_lama"];
		$cqty=$_REQUEST["cqty"];
		$cobatid=$_REQUEST["cobatid"];
		$ckpid=$_REQUEST["ckpid"];
		$cnokirim=$_REQUEST["cnokirim"];
		convert_var($cid,$cid_lama,$cqty,$cobatid,$ckpid);
		convert_var($cnokirim);
		//$sql="select * from a_penerimaan where ID=$cid";
		$sql="SELECT * FROM a_penerimaan WHERE OBAT_ID=$cobatid AND KEPEMILIKAN_ID=$ckpid AND NOKIRIM='$cnokirim' ORDER BY ID";
		//echo $sql."<br>";
		$rs1=mysqli_query($konek,$sql);
		while ($rows1=mysqli_fetch_array($rs1)){
			$cid=$rows1["ID"];
			$cid_lama=$rows1["ID_LAMA"];
			$cqty=$rows1["QTY_SATUAN"];
			$ch_satuan=$rows1['HARGA_BELI_SATUAN'];
			$cdiskon=$rows1['DISKON'];
			$ctipetrans=$rows1['TIPE_TRANS'];
			$cnpajak=$rows1['NILAI_PAJAK'];
			if (($cnpajak<=0) || ($ctipetrans==4) || ($ctipetrans==5) || ($ctipetrans==100)){
				$ch_satuan=$ch_satuan * (1-($cdiskon/100));
			}else{
				$ch_satuan=$ch_satuan * (1-($cdiskon/100)) /* 1.1*/;
			}
		
			$sql="UPDATE a_penerimaan SET QTY_STOK=QTY_STOK+$cqty WHERE ID=$cid_lama";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			//$sql="DELETE FROM a_penerimaan WHERE ID=$cid";
			$sql="UPDATE a_penerimaan SET QTY_SATUAN=0,QTY_STOK=0 WHERE ID=$cid";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			$sql="DELETE FROM a_penjualan WHERE PENERIMAAN_ID=$cid";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			$sql="SELECT * FROM a_kartustok WHERE UNIT_ID=$idunit AND OBAT_ID=$cobatid AND KEPEMILIKAN_ID=$ckpid AND fkid=$cid";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			if ($rows=mysqli_fetch_array($rs)){
				$ckartuid=$rows["ID"];
				$cket=str_replace("Out","Out(-)",$rows["KET"]);
			}
			$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS stok_after,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) /* 1.1*/)),0) AS ntot FROM a_penerimaan WHERE OBAT_ID=$cobatid AND KEPEMILIKAN_ID=$ckpid AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
			$rs=mysqli_query($konek,$sql);
			$cstok_lama=0;
			$cnilai_lama=0;
			if ($rows=mysqli_fetch_array($rs)){
				$cstok_lama=$rows['stok_after'];
				$cnilai_lama=$rows['ntot'];
			}
			$sql="INSERT INTO A_KARTUSTOK (OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) VALUES ($cobatid,$ckpid,$idunit,CURDATE(),NOW(),'$cnokirim',$cstok_lama-$cqty,0,-$cqty,$cstok_lama,'$cket',$iduser,$cid,1,$ch_satuan,$cnilai_lama)";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			//Stok Penerima
			$sql="SELECT IFNULL(COUNT(id),0) cAda FROM a_stok WHERE unit_id=$idunit AND obat_id=$cobatid AND kepemilikan_id=$ckpid";
			$rs=mysqli_query($konek,$sql);
			$rw1=mysqli_fetch_array($rs);
			if ($rw1["cAda"]>0){
				$sql="UPDATE a_stok SET qty_stok=$cstok_lama,nilai=$cnilai_lama,tgl_act=NOW() WHERE unit_id=$idunit AND obat_id=$cobatid AND kepemilikan_id=$ckpid";
			}else{
				$sql="INSERT INTO a_stok(unit_id,obat_id,kepemilikan_id,qty_stok,nilai,tgl_act) 
				VALUES($idunit,$cobatid,$ckpid,$cstok_lama,$cnilai_lama,NOW())";
			}
			$rs=mysqli_query($konek,$sql);
		}
		break;
}
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script>
	function PrintArea(printOut,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(printOut).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tgl_ctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
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
  	<input name="cid" id="cid" type="hidden" value="">
	<input name="cid_lama" id="cid_lama" type="hidden" value="">
  	<input name="cobatid" id="cobatid" type="hidden" value="">
  	<input name="ckpid" id="ckpid" type="hidden" value="">
  	<input name="cqty" id="cqty" type="hidden" value="">
    <input name="cnokirim" id="cnokirim" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
<!-- PRINT OUT -->
    <div id="printOut" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css">
      <p align="center"><span class="jdltable">DAFTAR PENGELUARAN OBAT KE RUANGAN (POLI)</span> 
      <table width="99%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td colspan="6"><span class="txtinput">Bulan :
		  	<?php if ($bulan=="1") echo "Januari";
				  elseif ($bulan=="2") echo "Pebruari";
				  elseif ($bulan=="3") echo "Maret";
				  elseif ($bulan=="4") echo "April";
				  elseif ($bulan=="5") echo "Mei";
				  elseif ($bulan=="6") echo "Juni";
				  elseif ($bulan=="7") echo "Juli";
				  elseif ($bulan=="8") echo "Agustus";
				  elseif ($bulan=="9") echo "September";
				  elseif ($bulan=="10") echo "Oktober";
				  elseif ($bulan=="11") echo "Nopember";
				  elseif ($bulan=="12") echo "Desember";
			?>
		  </span> 
			&nbsp;&nbsp;
            <span class="txtinput">Tahun : <?php echo $ta;?></span>
		</td>
       </tr>
	</table>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="32" height="25" class="tblheaderkiri">No</td>
          <td id="TANGGAL" width="81" class="tblheader" onClick="ifPop.CallFr(this);">Tgl 
            Kirim </td>
          <td id="NOKIRIM" width="141" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Kirim</td>
          <td width="327" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td width="91" class="tblheader" id="OBAT_SATUAN_KECIL" onClick="ifPop.CallFr(this);">Satuan 
            Kecil</td>
          <td id="UNIT_NAME" width="180" class="tblheader" onClick="ifPop.CallFr(this);">Poli 
            Tujuan</td>
          <td id="qty" width="41" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
          <td width="90" class="tblheader" onClick="ifPop.CallFr(this);">Nilai</td>
          <!--td class="tblheader" width="30"></td-->
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ap.ID,ap.ID_LAMA,ap.TANGGAL,ap.UNIT_ID_TERIMA,ap.KEPEMILIKAN_ID,a_unit.UNIT_NAME,ap.NOKIRIM,sum(ap.QTY_SATUAN) as qty,SUM(ap.QTY_SATUAN*ap.HARGA_BELI_SATUAN) AS nilai,date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1,NAMA from a_penerimaan ap inner join a_obat ao on ap.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on ap.kepemilikan_id=ak.ID Inner Join a_unit ON ap.UNIT_ID_TERIMA = a_unit.UNIT_ID INNER JOIN a_penjualan p ON ap.ID=p.PENERIMAAN_ID where ap.UNIT_ID_KIRIM=$idunit and ap.TIPE_TRANS=1 AND a_unit.UNIT_TIPE in (2,3) and month(ap.TANGGAL)=$bulan and year(ap.TANGGAL)=$ta".$filter." group by ap.OBAT_ID,ap.NOKIRIM,ap.KEPEMILIKAN_ID order by ".$sorting;
	 //echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  $jmldata=mysqli_num_rows($rs);
	  $i=0;
	  $totnilai=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$totnilai+=$rows['nilai'];
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px"><?php echo $i; ?></td>
          <td class="tdisi" align="center" style="font-size:12px"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px"><?php echo $rows['NOKIRIM']; ?></td>
          <td class="tdisi" align="left" style="font-size:12px"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px"><?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px"><?php echo $rows['qty']; ?></td>
          <td class="tdisi" align="right" style="font-size:12px"><?php echo number_format($rows['nilai'],0,",","."); ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr>
          <td colspan="7" align="right" style="font-size:12px">Total&nbsp;</td>
          <td align="right" style="font-size:12px"><?php echo number_format($totnilai,0,",","."); ?></td>
        </tr>
      </table>
	</div>
<!--Print Out Berakhir -->
	<div id="listma" style="display:block">
      <p><span class="jdltable">DAFTAR PENGELUARAN OBAT KE RUANGAN (POLI)</span> 
      <table width="99%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td colspan="6"><span class="txtinput">Bulan : </span> 
            <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=list_kirim_obat.php&bulan='+document.forms[0].bulan.value+'&ta='+document.forms[0].ta.value">
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
            <select name="ta" id="ta" class="txtinput" onChange="location='?f=list_kirim_obat.php&bulan='+document.forms[0].bulan.value+'&ta='+document.forms[0].ta.value">
            <?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
              <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
            <? }?>
            </select></td>
          <td width="658" align="right" colspan="6">
		  <BUTTON type="button" onClick="location='?f=../floorstock/mutasi.php'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Buat 
            Pengeluaran Baru</BUTTON>
		  </td>
	    </tr>
	</table>
      
    <table width="99%" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable"> 
        <td width="32" height="25" class="tblheaderkiri">No</td>
        <td id="TANGGAL" width="81" class="tblheader" onClick="ifPop.CallFr(this);">Tgl 
          Kirim </td>
        <td id="NOKIRIM" width="141" class="tblheader" onClick="ifPop.CallFr(this);">No 
          Kirim</td>
        <td width="327" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
          Obat</td>
        <td width="91" class="tblheader" id="OBAT_SATUAN_KECIL" onClick="ifPop.CallFr(this);">Satuan 
          Kecil</td>
        <td id="UNIT_NAME" width="180" class="tblheader" onClick="ifPop.CallFr(this);">Poli 
          Tujuan</td>
        <td id="qty" width="41" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
        <td id="qty" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Nilai</td>
        <td id="qty" width="41" class="tblheader" onClick="ifPop.CallFr(this);">Act</td>
        <!--td class="tblheader" width="30"></td-->
      </tr>
      <?php 
	  //echo $sql."<br>";
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
	  $sql2=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql2);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="center"><?php echo $rows['tgl1']; ?></td>
        <td class="tdisi" align="center"><?php echo $rows['NOKIRIM']; ?></td>
        <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
        <td class="tdisi" align="center"><?php echo $rows['UNIT_NAME']; ?></td>
        <td class="tdisi" align="center"><?php echo $rows['qty']; ?></td>
        <td class="tdisi" align="right"><?php echo number_format($rows['nilai'],0,",","."); ?></td>
        <td class="tdisi" align="center"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" title="Klik Untuk Menghapus" style="cursor:pointer" onClick="if (confirm('Yakin Ingin Menghapus Data Pengeluaran Obat ?')){act.value='del';cid.value='<?php echo $rows['ID']; ?>';cid_lama.value='<?php echo $rows['ID_LAMA']; ?>';cobatid.value='<?php echo $rows['OBAT_ID']; ?>';ckpid.value='<?php echo $rows['KEPEMILIKAN_ID']; ?>';cqty.value='<?php echo $rows['qty']; ?>';cnokirim.value='<?php echo $rows['NOKIRIM']; ?>';form1.submit();}"></td>
      </tr>
      <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr>
          <td colspan="7" align="right" style="font-size:12px">Total&nbsp;</td>
          <td align="right" style="font-size:12px"><?php echo number_format($totnilai,0,",","."); ?></td>
          <td align="right" style="font-size:12px">&nbsp;</td>
        </tr>
      <tr> 
        <td colspan="4" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
            <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
        <td colspan="6" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
          <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
          <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
          <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;        </td>
      </tr>
    </table>
    </div>
</form>
	<BUTTON type="button" onClick="PrintArea('printOut','#')" <?php if($jmldata==0) echo 'disabled';?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Daftar Pengeluaran&nbsp;&nbsp;</BUTTON>
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
<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglSkrg1=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tglSkrg=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tglSkrg);
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0"?substr($th[1],1,1):$th[1]);
$bulan=explode("|",$bulan);
$tgl4=$_REQUEST['tglinput'];$tgl4=explode("-",$tgl4);
$tgl=$tgl4[2]."-".$tgl4[1]."-".$tgl4[0];

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$kepemilikan_id=$_REQUEST['kepemilikan_id'];
$obat_id=$_REQUEST['obat_id'];
$qty=$_REQUEST['qty'];
$nokirim=$_REQUEST['nokirim'];
$unit_id=$_REQUEST['unit_id'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="apn.TANGGAL,apn.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
	case "save":
			$sql="select sum(QTY_STOK) QTY_STOK from a_penerimaan where OBAT_ID=$obat_id and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$kepemilikan_id and QTY_STOK>0 and STATUS=1 group by OBAT_ID";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			if ($rows=mysqli_fetch_array($rs)){
				$jml=$rows["QTY_STOK"];
				if ($jml>$qty){
					$sql="select * from a_penerimaan where OBAT_ID=$obat_id and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$kepemilikan_id and QTY_STOK>0 and STATUS=1 order by TANGGAL,ID";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					$ok="false";
					while (($rows1=mysqli_fetch_array($rs1))&&($ok=="false")){
						$cid=$rows1["ID"];
						$jml=$rows1["QTY_STOK"];
						$pbf_id=$rows1["PBF_ID"];
						$batch=$rows1["BATCH"];
						$expired=$rows1["EXPIRED"];
						$KEMASAN=$rows1["KEMASAN"];
						$QTY_PER_KEMASAN=$rows1["QTY_PER_KEMASAN"];
						$HARGA_BELI_SATUAN=$rows1["HARGA_BELI_SATUAN"];
						$DISKON=$rows1["DISKON"];
						$EXTRA_DISKON=$rows1["EXTRA_DISKON"];
						$DISKON_TOTAL=$rows1["DISKON_TOTAL"];
						$NILAI_PAJAK=$rows1["NILAI_PAJAK"];
						$JENIS=$rows1["JENIS"];
						if ($jml>$qty){
							$sql="insert into a_penerimaan(OBAT_ID,ID_LAMA,PBF_ID,UNIT_ID_KIRIM,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,NOKIRIM,TANGGAL_ACT,TANGGAL,BATCH,EXPIRED,KEMASAN,QTY_PER_KEMASAN,QTY_SATUAN,QTY_STOK,HARGA_BELI_TOTAL,HARGA_BELI_SATUAN,DISKON,EXTRA_DISKON,DISKON_TOTAL,NILAI_PAJAK,JENIS,TIPE_TRANS,STATUS) values($obat_id,$cid,$pbf_id,$idunit,$unit_id,$kepemilikan_id,$iduser,'$nokirim','$tglSkrg1','$tgl','$batch','$expired','$KEMASAN',$QTY_PER_KEMASAN,$qty,$qty,$qty*$HARGA_BELI_SATUAN,$HARGA_BELI_SATUAN,$DISKON,$EXTRA_DISKON,$DISKON_TOTAL,$NILAI_PAJAK,$JENIS,1,1)";
							//echo $sql."<br>";
							$rs=mysqli_query($konek,$sql);
							$sql="update a_penerimaan set QTY_STOK=QTY_STOK-$qty where ID=$cid";
							//echo $sql."<br>";
							$rs=mysqli_query($konek,$sql);
							$ok="true";
						}else{
							$sql="insert into a_penerimaan(OBAT_ID,ID_LAMA,PBF_ID,UNIT_ID_KIRIM,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,NOKIRIM,TANGGAL_ACT,TANGGAL,BATCH,EXPIRED,KEMASAN,QTY_PER_KEMASAN,QTY_SATUAN,QTY_STOK,HARGA_BELI_TOTAL,HARGA_BELI_SATUAN,DISKON,EXTRA_DISKON,DISKON_TOTAL,NILAI_PAJAK,JENIS,TIPE_TRANS,STATUS) values($obat_id,$cid,$pbf_id,$idunit,$unit_id,$kepemilikan_id,$iduser,'$nokirim','$tglSkrg1','$tgl','$batch','$expired','$KEMASAN',$QTY_PER_KEMASAN,$jml,$jml,$jml*$HARGA_BELI_SATUAN,$HARGA_BELI_SATUAN,$DISKON,$EXTRA_DISKON,$DISKON_TOTAL,$NILAI_PAJAK,$JENIS,1,1)";
							//echo $sql;
							$rs=mysqli_query($konek,$sql);
							$sql="update a_penerimaan set QTY_STOK=0 where ID=$cid";
							//echo $sql;
							$rs=mysqli_query($konek,$sql);
							$qty=$qty-$jml;
						}
					}
				}else{
					echo "<script>alert('Stok Obat Tersebut Tdk Mencukupi !');</script>";
				}
			}else{
				echo "<script>alert('Stok Obat Tersebut Tdk Ada !');</script>";
			}
		break;
	case "edit":
			$sql="update a_pbf set PBF_NAMA='$pbf_nama',PBF_ALAMAT='$pbf_alamat',PBF_TELP='$pbf_telp',PBF_FAX='$pbf_fax',PBF_KONTAK='$pbf_kontak',PBF_ISAKTIF=$pbf_isaktif where PBF_ID=$pbf_id";
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
		break;
	case "delete":
		$sql="select * from a_penerimaan where OBAT_ID=$obat_id and UNIT_ID_TERIMA=$unit_id and KEPEMILIKAN_ID=$kepemilikan_id and TANGGAL='$tgl' and TIPE_TRANS=1 order by TANGGAL,ID";
		$rs=mysqli_query($konek,$sql);
		//echo $sql."<br>";
		$iddel="";
		while ($rows=mysqli_fetch_array($rs)){
			$cid_lama=$rows["ID_LAMA"];
			$jml=$rows["QTY_STOK"];
			$iddel .=$rows["ID"].",";
			$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$jml where ID=$cid_lama";
			//echo $sql."<br>";
			$rs1=mysqli_query($konek,$sql);
		}
		if ($iddel!="") $iddel=substr($iddel,0,strlen($iddel)-1);
		$sql="delete from a_penerimaan where ID in ($iddel)";
		$rs=mysqli_query($konek,$sql);
		//echo $sql."<br>";
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
<script>
var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs1.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 500px; visibility: hidden">
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
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:block">
      <p class="jdltable">Mutasi Obat Dari Gudang </p>
      <table width="71%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
        <tr> 
          <td width="16%">Tanggal</td>
          <td width="0%">:</td>
          <td width="30%"><input name="tglinput" type="text" id="tglinput" size="11" maxlength="10" readonly="true" value="<?=$tglSkrg;?>" class="txtcenter" /> 
            <input type="button" name="ButtonTglInput" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tglinput,depRange);" /> 
          </td>
          <td width="13%">Nomor</td>
          <td width="0%">:</td>
          <td width="48%" ><input name="nokirim" type="text" id="nokirim" class="txtinput" size="15" ></td>
        </tr>
        <tr> 
          <td>Kepemilikan</td>
          <td>:</td>
          <td colspan="4"><select name="kepemilikan_id" id="kepemilikan_id" class="txtinput">
              <?
		  $qry="Select * from a_kepemilikan where aktif=1";
		  $exe=mysqli_query($konek,$qry);
		  while($show=mysqli_fetch_array($exe)){ 
		  ?>
              <option value="<?=$show['ID'];?>" class="txtinput"<?php if ($kepemilikan_id==$show['ID']) echo " selected";?>> 
              <?=$show['NAMA'];?>
              </option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td>Nama Obat</td>
          <td>:</td>
          <td colspan="4"><select name="obat_id" id="obat_id" class="txtinput">
              <?
		  $qry="Select * from a_obat where OBAT_ISAKTIF=1 order by OBAT_NAMA";
		  $exe=mysqli_query($konek,$qry);
		  while($show=mysqli_fetch_array($exe)){ 
		  ?>
              <option value="<?=$show['OBAT_ID'];?>" class="txtinput"> 
              <?=$show['OBAT_NAMA'];?>
              </option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td>Jumlah</td>
          <td>:</td>
          <td ><input name="qty" type="text" id="qty" size="6" class="txtcenter" ></td>
          <td>Unit Tujuan </td>
          <td>:</td>
          <td ><select name="unit_id" id="unit_id" class="txtinput">
              <?
		  $qry="Select * from a_unit where UNIT_TIPE<>1 and UNIT_TIPE<>1 and UNIT_ISAKTIF=1";
		  $exe=mysqli_query($konek,$qry);
		  while($show=mysqli_fetch_array($exe)){ 
		  ?>
              <option value="<?=$show['UNIT_ID'];?>" class="txtinput"> 
              <?=$show['UNIT_NAME'];?>
              </option>
              <? }?>
            </select></td>
        </tr>
      </table>
  <p><BUTTON type="button" onClick="if (ValidateForm('qty','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:<?=$listALL;?>">
    <p><span class="jdltable">DAFTAR MUTASI OBAT DARI GUDANG</span></p>
    <table width="95%" cellpadding="0" cellspacing="0" border="0">
	<tr class="txtinput">
		<td width="567">Bulan
		  <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=../transaksi/mutasi.php&unit='+unit.value+'&ta='+ta.value+'&amp;bulan='+bulan.value">
              <option value="1|Januari"<?php if ($bulan[0]=="1") echo " selected";?>>Januari</option>
              <option value="2|Pebruari"<?php if ($bulan[0]=="2") echo " selected";?>>Pebruari</option>
              <option value="3|Maret"<?php if ($bulan[0]=="3") echo " selected";?>>Maret</option>
              <option value="4|April"<?php if ($bulan[0]=="4") echo " selected";?>>April</option>
              <option value="5|Mei"<?php if ($bulan[0]=="5") echo " selected";?>>Mei</option>
              <option value="6|Juni"<?php if ($bulan[0]=="6") echo " selected";?>>Juni</option>
              <option value="7|Juli"<?php if ($bulan[0]=="7") echo " selected";?>>Juli</option>
              <option value="8|Agustus"<?php if ($bulan[0]=="8") echo " selected";?>>Agustus</option>
              <option value="9|September"<?php if ($bulan[0]=="9") echo " selected";?>>September</option>
              <option value="10|Oktober"<?php if ($bulan[0]=="10") echo " selected";?>>Oktober</option>
              <option value="11|Nopember"<?php if ($bulan[0]=="11") echo " selected";?>>Nopember</option>
              <option value="12|Desember"<?php if ($bulan[0]=="12") echo " selected";?>>Desember</option>
            </select>
  &nbsp;Tahun
  <select name="ta" id="ta" class="txtinput" onChange="location='?f=../transaksi/mutasi.php&unit='+unit.value+'&ta='+this.value+'&bulan='+bulan.value">
    <?php for ($i=$ta-2;$i<$ta+2;$i++){?>
    <option value="<?php echo $i; ?>" <?php if ($i==$ta) echo "selected"; ?>><?php echo $i; ?></option>
    <?php }?>
  </select>
        </td>
		<td width="140" align="right">
		<!--BUTTON type="button" onClick="document.getElementById('input').style.display='block';document.getElementById('listOneFaktur').style.display='block';document.getElementById('listma').style.display='none';fSetValue(window,'act*-*save*|*obat_id*-**|*pbf_id*-**|*kepemilikan_id*-**|*nokirim*-**|*noterima*-**|*nobukti*-**|*tglinput*-**|*batch*-**|*expired*-**|*qty_kemasan*-**|*qty_per_kemasan*-**|*harga_beli_total*-**|*harga_beli_satuan*-**|*diskon*-**|*extra_diskon*-**|*harga_jual*-**|*ket*-**|*nilai_pajak*-**|*jenis*-*')"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON-->		</td>
	</tr>
	</table>
  <!-- TAMPILAN TABEL DAFTAR ISI PENERIMAAN -->
  <div id="listma" style="display:block">
      <table width="800" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td id="ID" width="20" class="tblheaderkiri" onClick="ifPop.CallFr(this);">No</td>
          <td id="TANGGAL" width="60" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td id="NOKIRIM" width="80" class="tblheader" onClick="ifPop.CallFr(this);">No.Gd</td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="QTY_SATUAN" width="35" class="tblheader" onClick="ifPop.CallFr(this);">Jml</td>
          <td id="UNIT_NAME" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Unit<br>Tujuan</td>
          <td class="tblheader" colspan="2" width="30">Proses</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;

	  $sql="select apn.OBAT_ID,apn.TANGGAL,apn.NOKIRIM,sum(apn.QTY_SATUAN) QTY_SATUAN,ao.OBAT_KODE,ao.OBAT_NAMA,ak.ID,ak.NAMA,au.UNIT_ID,au.UNIT_NAME from a_penerimaan apn inner join a_obat ao on apn.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on apn.KEPEMILIKAN_ID=ak.ID inner join a_unit au on apn.UNIT_ID_TERIMA=au.UNIT_ID where month(apn.TANGGAL)=$bulan[0] and year(apn.TANGGAL)=$ta and apn.UNIT_ID_KIRIM=$idunit".$filter." group by apn.OBAT_ID,ak.ID,au.UNIT_ID order by ".$sorting;
	  //echo $sql;
 		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";

	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$arfvalue="act*-*edit*|*tglinput*-*".date("d-m-Y",strtotime($rows['TANGGAL']))."*|*nokirim*-*".$rows['NOKIRIM']."*|*obat_id*-*".$rows['OBAT_ID']."*|*kepemilikan_id*-*".$rows['ID']."*|*qty*-*".$rows['QTY_SATUAN']."*|*unit_id*-*".$rows['UNIT_ID'];
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
		
		$arfhapus="act*-*delete*|*tglinput*-*".date("d-m-Y",strtotime($rows['TANGGAL']))."*|*nokirim*-*".$rows['NOKIRIM']."*|*obat_id*-*".$rows['OBAT_ID']."*|*kepemilikan_id*-*".$rows['ID']."*|*unit_id*-*".$rows['UNIT_ID'];
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo date("d/m/Y",strtotime($rows['TANGGAL'])); ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['NOKIRIM']; ?></td>
          <td align="left" class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['QTY_SATUAN']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['UNIT_NAME']; ?></td>
          <!--td class="tdisi" width="30"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="fSetValue(parent,'<?php //echo $arfvalue; ?>');parent.document.getElementById('input').style.display='block'; parent.document.getElementById('listOneFaktur').style.display='none';"></td-->
          <td class="tdisi" width="30"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data No. <?=$i;?>?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="4" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="4" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
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
</html>
<?php 
mysqli_close($konek);
?>
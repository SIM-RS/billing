<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$no_gdg=$_REQUEST['no_gdg'];
$no_faktur=$_REQUEST['no_faktur'];

convert_var($tglctk,$tgl,$tgl_act,$no_gdg,$no_faktur);
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="tgl1 desc,NOTERIMA desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
convert_var($page,$filter,$sorting);

//===============================
//Convert tgl di URL menjadi YYYY-mm-dd ==============================
$tgl_d=$_REQUEST['tgl_d']; 
$tgl_s=$_REQUEST['tgl_s']; 
convert_var($tgl_d,$tgl_s);

if ($tgl_d=="") $tgl_d=$tgl;
$d=explode("-",$tgl_d);
$tgl_1="$d[2]-$d[1]-$d[0]";
if ($tgl_s=="") $tgl_s=$tgl;
$s=explode("-",$tgl_s);
$tgl_2="$s[2]-$s[1]-$s[0]";
convert_var($tgl_1,$tgl_2);


//===========================================================
$milik=$_REQUEST['milik'];
$jenis=$_REQUEST['jenis'];
$kategori=$_REQUEST['kategori'];
$pbf=$_REQUEST['pbf'];
$cmbCaraBayar=$_REQUEST['cmbCaraBayar'];
convert_var($milik,$jenis,$kategori);//cmbCaraBayar

 
if($milik=="" OR $milik=="0") $kep=""; else $kep=" and a_p.KEPEMILIKAN_ID=$milik ";
if($jenis=="") $jenis="0";
$jns=" and a_p.JENIS=$jenis ";


if ($jenis=="" OR $jenis==0) { 
$join = " INNER ";
}else{
$join = " LEFT ";
}


if ($kategori=="") $fkategori=""; else $fkategori=" AND o.OBAT_BENTUK='$kategori'";
if ($pbf=="" OR $pbf==0) $fpbf=""; else $fpbf=" AND a_pbf.PBF_ID='$pbf'";

//f ($cb==0) $cb="0"; else $fcb=" AND apo.cara_bayar_po=$cb";

//if($cmbCaraBayar=="" OR cmbCaraBayar=="0") $cmbCaraBayar="";
if($cmbCaraBayar=="" OR $cmbCaraBayar=="0") $fcb=""; else $fcb=" AND apo.cara_bayar_po=$cmbCaraBayar ";

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
convert_var($kep,$jns,$fkategori,$act);


$sql="select distinct NOTERIMA,ap.NOBUKTI,date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1,ap.HARGA_BELI_TOTAL,ap.DISKON_TOTAL,(ap.HARGA_BELI_TOTAL-ap.DISKON_TOTAL) as H_DISKON,(ap.HARGA_BELI_TOTAL-ap.DISKON_TOTAL)+ap.NILAI_PAJAK as TOTAL,ap.NILAI_PAJAK,ap.UPDT_H_NETTO,ap.HARI_J_TEMPO,a_pbf.PBF_ID,PBF_NAMA,no_po from a_penerimaan ap inner join a_po on ap.FK_MINTA_ID=a_po.ID inner join a_pbf on ap.PBF_ID=a_pbf.PBF_ID where ap.NOTERIMA='$no_gdg' and ap.NOBUKTI='$no_faktur'";
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	$no_po=$rows["no_po"];
	$no_faktur=$rows["NOBUKTI"];
	$tgl_gdg=$rows["tgl1"];
	$h_tot=$rows["HARGA_BELI_TOTAL"];
	$diskon_tot=$rows["DISKON_TOTAL"];
	$h_diskon=$rows["H_DISKON"];
	$total=$rows["TOTAL"];
	$ppn=$rows["NILAI_PAJAK"];
	$pbf=$rows["PBF_NAMA"];
	$pbf_id=$rows["PBF_ID"];
	$updt_h_netto=$rows["UPDT_H_NETTO"];
	$j_tempo=$rows["HARI_J_TEMPO"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../../theme/js/mod.js"></script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(cetak,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=800,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(cetak).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 200px; visibility: hidden">
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
	<input name="fdata" id="fdata" type="hidden" value="">
	<input name="updt_harga" id="updt_harga" type="hidden" value="0">
	<input name="pbf_id" id="pbf_id" type="hidden" value="<?php echo $pbf_id; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<div id="view" style="display:block">
	  <p align="center"><span class="jdltable">PENERIMAAN GUDANG</span></p>
		<table width="53%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
		  <tr>
		    <td>Jenis Penerimaan</td>
		    <td>:
            <select name="jenis" id="jenis" class="txtinput" onChange="location='?f=../gudang/penerimaan_detail_report.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&milik='+milik.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&cmbCaraBayar='+cmbCaraBayar.value+'&amp;pbf='+pbf.value">
                <option value="0"<?php if ($jenis=="0") {echo " selected='selected'";$njenis="Pembelian PBF";}?> class="txtinput">Pembelian PBF</option>
                <option value="1"<?php if ($jenis=="1") {echo " selected='selected'";$njenis="Konsinyasi";}?> class="txtinput">Konsinyasi</option>
                <option value="2"<?php if ($jenis=="2") {echo " selected='selected'";$njenis="Hibah/Bantuan";}?> class="txtinput">Hibah/Bantuan</option>
                <option value="3"<?php if ($jenis=="3") {echo " selected='selected'";$njenis="Return PBF";}?> class="txtinput">Return PBF</option>
              </select></td>
	      </tr>
			<tr>
			<td width="127">Jenis Kepemilikan </td>
            <td>: 
			<select name="milik" id="milik" class="txtinput" onChange="location='?f=../gudang/penerimaan_detail_report.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&milik='+milik.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&cmbCaraBayar='+cmbCaraBayar.value+'&amp;pbf='+pbf.value">
                <option value="0" class="txtinput">All Kepemilikan</option>
                <?
				$nmilik="ALL KEPEMILIKAN";
				$qry="Select * from a_kepemilikan where a_kepemilikan.AKTIF=1 order by a_kepemilikan.ID";
				$exe=mysqli_query($konek,$qry);
				while($show=mysqli_fetch_array($exe)){ 
				?>
                <option value="<?php echo $show['ID']; ?>" class="txtinput"<?php if ($milik==$show['ID']){echo "selected";$nmilik=$show['NAMA'];}?>><?php echo $show['NAMA']; ?></option>
                <? }?>
              </select>			  			  </td>
		  </tr>	
		    <tr>
		      <td>PBF</td>
		      <td>: 
		        <select name="select" id="pbf" class="txtinput" onchange="location='?f=../gudang/penerimaan_detail_report.php&amp;tgl_d='+tgl_d.value+'&amp;tgl_s='+tgl_s.value+'&amp;milik='+milik.value+'&amp;jenis='+jenis.value+'&amp;kategori='+kategori.value+'&amp;cmbCaraBayar='+cmbCaraBayar.value+'&amp;pbf='+pbf.value" >
                  <option value="" class="txtinput"<?php if ($kategori==""){echo " selected";$f2="SEMUA";}?>>SEMUA</option>
                  <?php 
				  $j1="SEMUA";
				  $sql="select * from a_pbf";
				  $rs=mysqli_query($konek,$sql);
				  while ($rows=mysqli_fetch_array($rs)){
				  ?>
                  <option value="<?php echo $rows['PBF_ID']; ?>" class="txtinput"<?php if ($pbf==$rows['PBF_ID']){echo " selected";$f2=$rows['PBF_NAMA'];}?>><?php echo $rows['PBF_NAMA']; ?></option>
                  <?php }?>
                </select></td>
	      </tr>
		    <tr>
		      <td>Cara Bayar </td>
		      <td>: 
			  
			    <select name="cmbCaraBayar" id="cmbCaraBayar" class="txtinput" onChange="location='?f=../gudang/penerimaan_detail_report.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&milik='+milik.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&cmbCaraBayar='+cmbCaraBayar.value+'&amp;pbf='+pbf.value">
				  		<option value="0" <?php if ($cmbCaraBayar=="0") {echo " selected='selected'";$ncb="Semua";}?> >Semua</option>
						<option value="1" <?php if ($cmbCaraBayar=="1") {echo " selected='selected'";$ncb="Tunai";}?>>Tunai</option>
						<option value="2" <?php if ($cmbCaraBayar=="2") {echo " selected='selected'";$ncb="Kredit";}?>>Kredit</option>
						<option value="3" <?php if ($cmbCaraBayar=="3") {echo " selected='selected'";$ncb="Uang Muka";}?>>Uang Muka</option>
				</select>			  </td>
	      </tr>
	      <tr>
		  	<td>Bentuk Obat</td>
		  	<td>:
				<select name="kategori" id="kategori" class="txtinput" onChange="location='?f=../gudang/penerimaan_detail_report.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&milik='+milik.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&cmbCaraBayar='+cmbCaraBayar.value+'&amp;pbf='+pbf.value" >
				<option value="" class="txtinput"<?php if ($kategori==""){echo " selected";$f1="SEMUA";}?>>SEMUA</option>
				  <?php 
				  $j1="SEMUA";
				  $sql="select * from a_bentuk";
				  $rs=mysqli_query($konek,$sql);
				  while ($rows=mysqli_fetch_array($rs)){
				  ?>
				  <option value="<?php echo $rows['BENTUK']; ?>" class="txtinput"<?php if ($kategori==$rows['BENTUK']){echo " selected";$f1=$rows['BENTUK'];}?>><?php echo $rows['BENTUK']; ?></option>
				  <?php }?>
				</select>			</td>
		  </tr>
		  <tr> 
			  <td width="127">Tanggal Periode</td>
			  <td>: 
				<input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d;?>" /></input>
			<input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/></input>&nbsp;s/d&nbsp;
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s;?>" >
            </input> 
			<input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" /></input>
            <button type="button" onClick="location='?f=../gudang/penerimaan_detail_report.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&milik='+milik.value+'&kategori='+kategori.value+'&cmbCaraBayar='+cmbCaraBayar.value+'&amp;pbf='+pbf.value">
			  <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button></td>
		  </tr>
	</table>
	  <table id="tblpenerimaan" width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="26" height="25" class="tblheaderkiri">No</td>
          <!-- tambahan sementara -->
          <td id="tgl1" width="53" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td id="NOTERIMA" width="63" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Gudang</td>
          <td id="NOBUKTI" width="48" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Faktur </td>
          <td width="39" class="tblheader" id="PBF_NAMA" onClick="ifPop.CallFr(this);">PBF</td>
          <!-- Selesai-->
          <td width="74" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
		  <td id="kategori" width="84" class="tblheader" onClick="ifPop.CallFr(this);"> 
            Kategori</td>
          <td width="82" class="tblheader">Kepemilikan</td>
          <td id="qty_kemasan" width="57" class="tblheader" onClick="ifPop.CallFr(this);">Expired 
            Date</td>
          <td id="QTY_SATUAN" width="37" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
          <td id="KEMASAN" width="47" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
          <td id="HARGA_BELI_SATUAN" width="45" class="tblheader" onClick="ifPop.CallFr(this);">Hrg 
            Sat</td>
          <td id="subtotal" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Sub 
            Total </td>
          <td id="DISKON" width="41" class="tblheader" onClick="ifPop.CallFr(this);">Disk 
            (%) </td>
          <td width="30" class="tblheader" onClick="">DPP</td>
          <td width="39" class="tblheader" onClick="">Pajak</td>
          <td width="97" class="tblheader" onClick="">DPP+PPN</td>
        </tr>
        <?php 
		$jfilter="";
	  if ($filter!=""){
	  	$jfilter=$filter;
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	 
	  $sql="SELECT a_p.*,ok.kategori,ab.BENTUK,DATE_FORMAT(a_p.TANGGAL,'%d/%m/%Y') AS tgl1,DATE_FORMAT(a_p.EXPIRED,'%d/%m/%Y') AS tgl2,apo.cara_bayar_po,
			a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN AS subtotal,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100) AS dpp,
			(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0)) AS ppn,
			(((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100)+(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0))) AS dpp_ppn,
			o.OBAT_KODE,o.OBAT_NAMA,k.NAMA, PBF_NAMA, sd.nama sumberdana
			FROM a_penerimaan a_p INNER JOIN a_obat o ON a_p.OBAT_ID=o.OBAT_ID INNER JOIN a_kepemilikan k ON a_p.KEPEMILIKAN_ID=k.ID 
			$join JOIN a_pbf ON a_p.PBF_ID=a_pbf.PBF_ID LEFT JOIN (SELECT id, nama FROM a_sumber_dana) sd ON sd.id = a_p.SUMBER_DANA
			LEFT JOIN a_obat_kategori ok ON ok.id = o.OBAT_KATEGORI
			LEFT JOIN a_bentuk ab ON ab.BENTUK = o.OBAT_BENTUK
			$join join a_po apo ON a_p.FK_MINTA_ID = apo.ID
			WHERE a_p.TIPE_TRANS=0 AND a_p.TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'".$kep.$fpbf.$jns.$filter.$fcb.$fkategori." 
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
//	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
		$i++;
		$kemasan=$rows['kemasan'];
		$satuan=$rows['satuan'];
		$qty_kemasan=$rows['QTY_KEMASAN'];
		$spph_id=$rows['spph_id'];
		$obat_id=$rows['obat_id'];
		//$dpp=$rows['subtotal']-(($rows['subtotal']*$rows['DISKON'])/100);
		$dpp=$rows['dpp'];
		//$ppn=($rows['NILAI_PAJAK']>0)?($dpp*10/100):0;
		$ppn=$rows['ppn'];
		$dpp_ppn=$dpp+$ppn;
	  ?>
        <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['NOTERIMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['NOBUKTI']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['PBF_NAMA']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['kategori']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['tgl2']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['QTY_SATUAN']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['SATUAN']; ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format($rows['HARGA_BELI_SATUAN'],2,",","."); ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format($rows['subtotal'],2,",","."); ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['DISKON']; ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format($dpp,2,",","."); ?></td>
          <td class="tdisi" align="right"><?php echo number_format($ppn,2,",","."); ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format($dpp_ppn,2,",","."); ?></td>
        </tr>
        <?php 
	  }
	  $sql2="select if (sum(p2.subtotal) is null,0,sum(p2.subtotal)) as tsubtot,if (sum(p2.dpp) is null,0,sum(p2.dpp)) as tdpp,if (sum(p2.ppn) is null,0,sum(p2.ppn)) as tppn,if (sum(p2.dpp_ppn) is null,0,sum(p2.dpp_ppn)) as tdpp_ppn from (".$sql.") as p2";
	  //echo $sql2."<br>";
	  $rs=mysqli_query($konek,$sql2);
	  if ($rows=mysqli_fetch_array($rs)){
	  	$tsubtot=$rows["tsubtot"];
		$tdpp=$rows["tdpp"];
		$tppn=$rows["tppn"];
		$tdpp_ppn=$rows["tdpp_ppn"];
	  }
	  mysqli_free_result($rs);
	  ?>
	  	<tr class="txtinput">
	  		<td class="tdisikiri" colspan="12" align="right">Total&nbsp;</td>
			<td class="tdisi" align="right"><?php echo number_format($tsubtot,2,",","."); ?></td>
			<td class="tdisi" align="right">&nbsp;</td>
			<td class="tdisi" align="right"><?php echo number_format($tdpp,2,",","."); ?></td>
			<td class="tdisi" align="right"><?php echo number_format($tppn,2,",","."); ?></td>
			<td class="tdisi" align="right"><?php echo number_format($tdpp_ppn,2,",","."); ?></td>
	  	</tr>
      </table>
    </div>
	  <div id="cetak" style="display:none">
	  <link rel="stylesheet" href="../theme/print.css" type="text/css" />
	  <!--p align="center"><span class="jdltable">PENERIMAAN GUDANG</span></p-->
      <table width="48%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td align="center">PENERIMAAN GUDANG</td>
        </tr>
        <tr>
          <td align="center">(<?php echo $tgl_d." s/d ".$tgl_s;?>)</td>
		</tr>
        <tr> 
          <td align="center">Kepemilikan : <? echo $nmilik; ?></td>
		</tr>
      </table>
	  <table id="tblpenerimaan" width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="34" height="25" class="tblheaderkiri">No</td>
          <!-- tambahan sementara -->
          <td id="tgl1" width="55" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td id="NOTERIMA" width="66" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Gudang</td>
          <td id="NOBUKTI" width="63" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Faktur </td>
          <td width="28" class="tblheader" id="PBF_NAMA" onClick="ifPop.CallFr(this);">PBF</td>
		  <!-- Selesai-->
          <td width="79" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="kategori" width="84" class="tblheader" onClick="ifPop.CallFr(this);"> 
            <p>Kategori</p></td>
          <td id="NAMA" width="84" class="tblheader" onClick="ifPop.CallFr(this);"> 
            <p>Kepemilikan</p></td>
          <td id="qty_kemasan" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Expired 
            Date</td>
          <td id="QTY_SATUAN" width="26" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
          <td id="KEMASAN" width="49" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
          <td id="HARGA_BELI_SATUAN" width="53" class="tblheader" onClick="ifPop.CallFr(this);">Hrg 
            Sat</td>
          <td id="subtotal" width="71" class="tblheader" onClick="ifPop.CallFr(this);">Sub 
            Total </td>
          <td id="DISKON" width="71" class="tblheader" onClick="ifPop.CallFr(this);">Disk 
            (%) </td>
          <td width="54" class="tblheader" onClick="">DPP</td>
          <td width="54" class="tblheader" onClick="">Pajak</td>
          <td width="54" class="tblheader" onClick="">DPP+PPN</td>
        </tr>
        <?php 
	  //echo $sql."<br>";
		 //$sql="select a_p.*,date_format(a_p.TANGGAL,'%d/%m/%Y') as tgl1,date_format(a_p.EXPIRED,'%d/%m/%Y') as tgl2,a_p.HARGA_KEMASAN*QTY_KEMASAN as subtotal,o.OBAT_KODE,o.OBAT_NAMA,k.NAMA, PBF_NAMA,a_p.KEMASAN,a_p.NILAI_PAJAK from a_penerimaan a_p inner join a_obat o on a_p.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_p.KEPEMILIKAN_ID=k.ID inner join a_pbf on a_p.PBF_ID=a_pbf.PBF_ID where a_p.TIPE_TRANS=0 AND a_p.TANGGAL between '$tgl_1' and '$tgl_2'".$kep.$filter." order by ".$sorting;
		//echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	 
//	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
		$p++;
		$kemasan=$rows['kemasan'];
		$satuan=$rows['satuan'];
		$qty_kemasan=$rows['QTY_KEMASAN'];
		$spph_id=$rows['spph_id'];
		$obat_id=$rows['obat_id'];
		//$dpp=$rows['subtotal']-(($rows['subtotal']*$rows['DISKON'])/100);
		$dpp=$rows['dpp'];
		//$ppn=($rows['NILAI_PAJAK']>0)?($dpp*10/100):0;
		$ppn=$rows['ppn'];
		$dpp_ppn=$dpp+$ppn;
	  ?>
        <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $p; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['NOTERIMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['NOBUKTI']; ?></td>
          <td class="tdisi" align="left" style="font-size:12px;">&nbsp;<?php echo $rows['PBF_NAMA']; ?></td>
		  <td class="tdisi" align="left" style="font-size:12px;">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['kategori']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['tgl2']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['QTY_SATUAN']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['SATUAN']; ?></td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($rows['HARGA_BELI_SATUAN'],2,",","."); ?></td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($rows['subtotal'],2,",","."); ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['DISKON']; ?></td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($dpp,2,",","."); ?></td>
          <td class="tdisi" align="right" style="font-size:12px;"> 
            <?php number_format($ppn,2,",","."); ?>          </td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($dpp_ppn,2,",","."); ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
	  	<tr class="txtinput">
	  		<td class="tdisikiri" colspan="12" align="right" style="font-size:12px;">Total&nbsp;</td>
			<td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($tsubtot,2,",","."); ?></td>
			<td class="tdisi" align="right" style="font-size:12px;">&nbsp;</td>
			<td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($tdpp,2,",","."); ?></td>
			<td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($tppn,2,",","."); ?></td>
			<td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($tdpp_ppn,2,",","."); ?></td>
	  	</tr>
      </table>
	  </div>
	  
    <table width="744px">
      <tr> 
          <td width="400" colspan="" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
          <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td width="344" colspan="12" align="right"><img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onclick="document.form1.act.value='paging';document.form1.page.value='1';document.form1.submit();" /><img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp; </td>
        </tr>
    </table>
	
			<p align="center">
			<a class="navText" href='#' onclick='PrintArea("cetak","#")'>
              <BUTTON type="button" onClick="" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Penerimaan&nbsp;&nbsp;</BUTTON></a>
            &nbsp;<BUTTON type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?> onClick="OpenWnd('../gudang/penerimaan_detail_report_Excell.php?milik='+milik.value+'&nmilik=<?php echo $nmilik; ?>&jenis='+jenis.value+'&njenis=<?php echo $njenis; ?>&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&filter=<?php echo $jfilter; ?>&sorting=<?php echo $sorting; ?>&kategori=<?php echo $kategori; ?>&cmbCaraBayar=<?php echo $cmbCaraBayar; ?>&pbf=<?php echo $pbf; ?>',600,450,'childwnd',true);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON>
          	</p>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
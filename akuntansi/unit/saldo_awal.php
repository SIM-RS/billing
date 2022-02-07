<?php 
// Koneksi =================================
include("../sesi.php");
include("../koneksi/konek.php");
//============================================
$qstr_ma="par=id_sak*kode_sak*nama_sak*idccrvpbfumum";
$_SESSION["PATH_MS_MA"]="?".$qstr_ma;
//========Tahun====
$th=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$th);

// ==============================

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$saldo_id=$_REQUEST["saldo_id"];
$id_sak=$_REQUEST["id_sak"];
$inpbulan=$_REQUEST["inpbulan"];
$inpta=$_REQUEST["inpta"];
$idccrvpbfumum=$_REQUEST["idccrvpbfumum"];
$fk_idunit=0;
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0"?substr($th[1],1,1):$th[1]);
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$saldo_awal=$_REQUEST["saldo_awal"];
//====================================================================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="s.SALDO_ID DESC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
// echo $inpbulan."".$inpta;
switch ($act){
	case "save":
			$sql="insert into saldo(FK_MAID,CC_RV_KSO_PBF_UMUM_ID,FK_IDUNIT,BULAN,TAHUN,SALDO_AWAL,flag) values($id_sak,'$idccrvpbfumum',$fk_idunit,$inpbulan,$inpta,'$saldo_awal','$flag')"; //decyber_saldo
			//echo $sql;
			$rs=mysql_query($sql);
		break;
	case "edit":
			$sql="update saldo set FK_MAID='$id_sak',CC_RV_KSO_PBF_UMUM_ID='$idccrvpbfumum',FK_IDUNIT=$fk_idunit,BULAN='$inpbulan',TAHUN='$inpta', SALDO_AWAL='$saldo_awal' where SALDO_ID=$saldo_id";
			//echo $sql;
			$rs=mysql_query($sql);
		break;
	case "delete":
		$sql="delete from saldo where saldo_id=$saldo_id";
		$rs=mysql_query($sql);
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
<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
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
    <input name="saldo_id" id="saldo_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none">
      <table width="75%" border="0" cellpadding="0" cellspacing="0" class="txtinput" align="center">
        <tr>
          <td colspan="3" align="center"><span class="jdltable">INPUT SALDO AWAL</span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td>Kode Rekening</td>
          <td>:</td>
          <td><input name="kode_sak" type="text" id="kode_sak" class="txtinput" size="20" maxlength="20" readonly="true" value="<?php echo $kode_ma; ?>" />
              <input type="button" name="Button" value="..." class="txtcenter" onClick="OpenWnd('tree_fksak_saldoAwal.php?<?php echo $qstr_ma; ?>',800,500,'msma',true)" /></td>
        </tr>
        <tr>
          <td>Nama Rekening</td>
          <td>:</td><input name="id_sak" type="hidden" id="id_sak" class="txtinput" readonly="true" />
          <input name="idccrvpbfumum" type="hidden" id="idccrvpbfumum" class="txtinput" readonly="true" />
          <td><textarea name="nama_sak" cols="75" rows="2" readonly="true" class="txtinput" id="nama_sak"><?php echo $ma; ?></textarea></td>
		</tr>
		<tr>
		<td>Saldo Awal</td>
		  <td>:</td>
		  <td>
            <select name="inpbulan" id="inpbulan" class="txtinput">
              <option value="1">Januari</option>
              <option value="2" <?php if ($bulan==2) echo "selected";?>>Pebruari</option>
              <option value="3" <?php if ($bulan==3) echo "selected";?>>Maret</option>
              <option value="4" <?php if ($bulan==4) echo "selected";?>>April</option>
              <option value="5" <?php if ($bulan==5) echo "selected";?>>Mei</option>
              <option value="6" <?php if ($bulan==6) echo "selected";?>>Juni</option>
              <option value="7" <?php if ($bulan==7) echo "selected";?>>Juli</option>
              <option value="8" <?php if ($bulan==8) echo "selected";?>>Agustus</option>
              <option value="9" <?php if ($bulan==9) echo "selected";?>>September</option>
              <option value="10" <?php if ($bulan==10) echo "selected";?>>Oktober</option>
              <option value="11" <?php if ($bulan==11) echo "selected";?>>Nopember</option>
              <option value="12" <?php if ($bulan==12) echo "selected";?>>Desember</option>
            </select>
            <select name="inpta" id="inpta" class="txtinput">
              <?php for ($i=$ta-2;$i<$ta+2;$i++){?>
              <option value="<?php echo $i; ?>" <?php if ($i==$ta) echo "selected"; ?>><?php echo $i; ?></option>
              <?php }?>
			</select></td>
			  </tr>
        <tr>
          <td>Saldo Awal</td>
          <td>:</td>
          <td><input name="saldo_awal" id="saldo_awal" type="text" class="txtright"size="15" />
&nbsp;&nbsp;        </tr>
      </table>
      <p><BUTTON type="button" onClick="if (ValidateForm('bulan,ta,id_sak,saldo_awal','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
 <p><span class="jdltable">DAFTAR SALDO AWAL </span>
  <table width="90%" cellpadding="0" cellspacing="0" border="0">
		<tr>
          <td width="337" class="txtinput">Bulan
            <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=saldo_awal&idma='+id_sak.value+'&kode_ma=<?php echo $kode_ma; ?>&islast=<?php echo $islast; ?>&ta='+ta.value+'&bulan='+bulan.value">
              <option value="1">Januari</option>
              <option value="2" <?php if ($bulan==2) echo "selected";?>>Pebruari</option>
              <option value="3" <?php if ($bulan==3) echo "selected";?>>Maret</option>
              <option value="4" <?php if ($bulan==4) echo "selected";?>>April</option>
              <option value="5" <?php if ($bulan==5) echo "selected";?>>Mei</option>
              <option value="6" <?php if ($bulan==6) echo "selected";?>>Juni</option>
              <option value="7" <?php if ($bulan==7) echo "selected";?>>Juli</option>
              <option value="8" <?php if ($bulan==8) echo "selected";?>>Agustus</option>
              <option value="9" <?php if ($bulan==9) echo "selected";?>>September</option>
              <option value="10" <?php if ($bulan==10) echo "selected";?>>Oktober</option>
              <option value="11" <?php if ($bulan==11) echo "selected";?>>Nopember</option>
              <option value="12" <?php if ($bulan==12) echo "selected";?>>Desember</option>
            </select>
            <select name="ta" id="ta" class="txtinput" onChange="location='?f=saldo_awal&idma='+id_sak.value+'&kode_ma=<?php echo $kode_ma; ?>&islast=<?php echo $islast; ?>&ta='+this.value+'&bulan='+bulan.value">
              <?php for ($i=$ta-2;$i<$ta+2;$i++){?>
              <option value="<?php echo $i; ?>" <?php if ($i==$ta) echo "selected"; ?>><?php echo $i; ?></option>
              <?php }?>
            </select></td>
          <td width="387" align="right">
		  <BUTTON type="button" onClick="document.getElementById('input').style.display='block'; fSetValue(window,'act*-*save*|*saldo_id*-**|*bulan*-*<?php echo $bulan; ?>*|*ta*-*<?php echo $ta; ?>*|*id_sak*-**|*kode_sak*-**|*nama_sak*-**|*saldo_awal*-*')"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON>
		  </td>
	    </tr>
	</table>
    <table width="90%" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable">
        <td id="SALDO_ID" width="56" class="tblheaderkiri" onClick="ifPop.CallFr(this);">No</td>
        <td id="MA_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kode Rekening</td>
        <td id="FK_MAID" class="tblheader" onClick="ifPop.CallFr(this);">Nama Rekening</td>
		<td id="BULAN" width="60" class="tblheader" onClick="ifPop.CallFr(this);">Bulan</td>
		<td id="TAHUN" width="60" class="tblheader" onClick="ifPop.CallFr(this);">Tahun</td>
		<td id="SALDO_AWAL" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Saldo Awal</td>
        <td class="tblheader" colspan="2">Proses</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="Select saldo.*, ma_sak.MA_KODE as kode_sak, ma_sak.MA_NAMA as nama_sak From saldo inner join ma_sak ON saldo.FK_MAID = ma_sak.MA_ID".$filter." ORDER BY ".$sorting;
	  $sql="SELECT s.*, ma.MA_KODE AS kode_sak, ma.MA_NAMA AS nama_sak,ma.CC_RV_KSO_PBF_UMUM 
FROM saldo s INNER JOIN ma_sak ma ON s.FK_MAID = ma.MA_ID WHERE s.BULAN=$bulan AND s.TAHUN=$ta AND s.flag = '$flag'
".$filter." ORDER BY ".$sorting; //decyber_saldo
	//   echo $sql;
		$rs=mysql_query($sql);
		$jmldata=mysql_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";

	  $rs=mysql_query($sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
		$txtKode=$rows['kode_sak'];
		$txtNama=$rows['nama_sak'];
		if ($rows['CC_RV_KSO_PBF_UMUM_ID']>0){
			switch($rows['CC_RV_KSO_PBF_UMUM']){
				case 1:
					//$sql="SELECT * FROM ak_ms_unit WHERE id='".$rows['CC_RV_KSO_PBF_UMUM_ID']."'";
					$sql="SELECT * FROM ak_ms_beban_jenis WHERE id='".$rows['CC_RV_KSO_PBF_UMUM_ID']."'";
					$rs1=mysql_query($sql);
					$rw1=mysql_fetch_array($rs1);
					$txtKode.=$rw1['kode'];
					$txtNama.="<br>(".$rw1['nama'].")";
					break;
				case 2:
					$sql="SELECT * FROM $dbbilling.b_ms_kso WHERE id='".$rows['CC_RV_KSO_PBF_UMUM_ID']."'";
					$rs1=mysql_query($sql);
					$rw1=mysql_fetch_array($rs1);
					$txtKode.=$rw1['kode_ak'];
					$txtNama.="<br>(".$rw1['nama'].")";
					break;
				case 3:
					$sql="SELECT * FROM $dbapotek.a_pbf WHERE PBF_ID='".$rows['CC_RV_KSO_PBF_UMUM_ID']."'";
					$rs1=mysql_query($sql);
					$rw1=mysql_fetch_array($rs1);
					$txtKode.=$rw1['PBF_KODE_AK'];
					$txtNama.="<br>(".$rw1['PBF_NAMA'].")";
					break;
				case 4:
					$sql="SELECT * FROM $dbaset.as_ms_rekanan WHERE idrekanan='".$rows['CC_RV_KSO_PBF_UMUM_ID']."'";
					$rs1=mysql_query($sql);
					$rw1=mysql_fetch_array($rs1);
					$txtKode.=$rw1['koderekanan'];
					$txtNama.="<br>(".$rw1['namarekanan'].")";
					break;
			}
		}
		$saldo_awal=($rows['SALDO_AWAL']>0)?number_format($rows['SALDO_AWAL'],0,",","."):"(".number_format(-1*$rows['SALDO_AWAL'],0,",",".").")";
		$arfvalue="act*-*edit*|*saldo_id*-*".$rows['SALDO_ID']."*|*bulan*-*".$rows['BULAN']."*|*ta*-*".$rows['TAHUN']."*|*id_sak*-*".$rows['FK_MAID']."*|*kode_sak*-*".$rows['kode_sak']."*|*nama_sak*-*".$rows['nama_sak']."*|*saldo_awal*-*".$rows['SALDO_AWAL'];
		
		 $arfvalue=str_replace('"',chr(3),$arfvalue);

		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*saldo_id*-*".$rows['SALDO_ID'];
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="left"><?php echo $txtKode; ?></td>
        <td class="tdisi" align="left"><?php echo $txtNama; ?></td>
		<td align="center" class="tdisi"><?php echo $rows['BULAN']; ?></td>
		<td class="tdisi" align="center"><?php echo $rows['TAHUN']; ?></td>
		<td align="right" class="tdisi"><?php echo $saldo_awal; ?></td>
        <td width="20" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';document.getElementById('listma').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
        <td width="20" class="tdisi">
		<img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}">		</td>
      </tr>
	  <?php 
	  }
	  mysql_free_result($rs);
	  ?>
      <tr> 
        <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		<td colspan="5" align="right">
		<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;		</td>
      </tr>
    </table>
    </div>
</form>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>
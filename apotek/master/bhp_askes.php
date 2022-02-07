<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$obat_id=$_REQUEST['obat_id'];
$obat_kode=$_REQUEST['obat_kode'];
$obat_nama=$_REQUEST['obat_nama'];
$pabrik_id=$_REQUEST['pabrik_id'];
$obat_dosis=$_REQUEST['obat_dosis'];
$obat_satuan_besar=$_REQUEST['obat_satuan_besar'];
$obat_satuan_kecil=$_REQUEST['obat_satuan_kecil'];
$isi_satuan_kecil=$_REQUEST['isi_satuan_kecil'];
$obat_bentuk=$_REQUEST['obat_bentuk'];
$kls_id=$_REQUEST['kls_id'];
$obat_kategori=$_REQUEST['obat_kategori'];
$obat_golongan=$_REQUEST['obat_golongan'];
$habis_pakai=$_REQUEST['habis_pakai'];
$jenis_obat=$_REQUEST['jenis_obat'];
$kode_paten=$_REQUEST['kode_paten'];
$id_paten=$_REQUEST['id_paten'];
if ($id_paten=="") $id_paten="0";
$obat_isaktif=$_REQUEST['obat_isaktif'];

//====================================================================
//Set Status Aktif atau Tidak====
$status=$_REQUEST['status'];
if ($status=="") $status=1;
// ==============================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="OBAT_KODE desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
//Paging,Sorting dan Filter======
$page1=$_REQUEST["page1"];
$defaultsort1="OBAT_KODE desc";
$sorting1=$_REQUEST["sorting1"];
$filter1=$_REQUEST["filter1"];

convert_var($obat_id,$obat_kode,$obat_nama,$pabrik_id,$obat_dosis);
convert_var($obat_satuan_besar,$obat_satuan_kecil,$isi_satuan_kecil,$obat_bentuk,$kls_id);
convert_var($obat_kategori,$obat_golongan,$habis_pakai,$jenis_obat,$kode_paten);
convert_var($id_paten,$obat_isaktif,$status,$page,$sorting);
convert_var($filter,$page1,$sorting1,$filter1,$act);


//===============================


//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['aksi']; // Jenis Aksi ==================================
//echo $act;
switch ($act){
	case "kanan":
			$fdata = explode("|",$_REQUEST['tempID']);
			for($i=0;$i<count($fdata)-1;$i++){
				$sql="insert into a_obat_askes_bhp (obat_id) values ('$fdata[$i]')";
				$rs=mysqli_query($konek,$sql);
			}
		break;
	case "kiri":
			$fdata = explode("|",$_REQUEST['tempID']);
			for($i=0;$i<count($fdata)-1;$i++){
				$sql="delete from a_obat_askes_bhp where id=".$fdata[$i];
				$rs=mysqli_query($konek,$sql);
			}
		break;
}
//Aksi Save, Edit, Delete Berakhir =====================================
$sql="SELECT MAX(OBAT_KODE)+1 AS maxkode FROM a_obat";
$rs=mysqli_query($konek,$sql);
$cmkode=1;
if ($rows=mysqli_fetch_array($rs)){
	$cmkode=$rows["maxkode"];
}
$mkode=$cmkode;
for ($i=0;$i<(8-strlen($cmkode));$i++){
	$mkode="0".$mkode;
}
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<SCRIPT language="JavaScript" src="../theme/js/tip.js"></SCRIPT>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<DIV id="TipLayer" style="visibility:hidden;position:absolute; z-index:1000; top:-100;"></DIV>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort1.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="left">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="obat_id" id="obat_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
  <p>
      <table width="99%" cellpadding="0" cellspacing="0" border="0">
        <tr>
		  <td width="570" style="padding-left:5px;"><span class="jdltable">DATA MASTER OBAT</span></td>
		  <td><span class="jdltable">DATA OBAT BHP ASKES</span></td>
	    </tr>
		<!--tr style="display:none">
          <td>&nbsp;Status&nbsp;:&nbsp;
            <select name="status" class="txtinput" id="status" onChange="location='?f=../master/obat&status='+this.value">
              <option value="1">Aktif</option>
              <option value="0"<?php if ($status=="0") echo " selected";?>>Tdk Aktif&nbsp;</option>
       	  </select>		  </td>
          <td>&nbsp;</td>
        </tr-->
	</table>
    <table cellpadding="0" cellspacing="0" width="1000"> 
    <tr>
      <td width="450" align="left" style="padding-left:5px;">
      <table width="100%" border="0" cellpadding="1" cellspacing="0" style="float:left">
        <tr class="headtable">
          <td id="tbl1.OBAT_ID" width="38" class="tblheaderkiri" onClick="cek()"><input type="checkbox" id="cek_all" name="cek_all"></td>
          <td width="91" class="tblheader" id="OBAT_KODE" onClick="ifPop.CallFr(this);">Kode 
            Obat </td>
          <td id="tbl1.OBAT_NAMA" width="296" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat </td>
          <!--td id="PABRIK" width="122" class="tblheader" onClick="ifPop.CallFr(this);">Pabrik </td-->
          <!--td id="OBAT_SATUAN_BESAR" width="51" class="tblheader" onClick="ifPop.CallFr(this);">Satuan Besar</td-->
          <!--td id="ISI_SATUAN_KECIL" width="47" class="tblheader" onClick="ifPop.CallFr(this);">Isi Satuan</td-->
          <td id="tbl1.OBAT_BENTUK" width="95" class="tblheader" onClick="ifPop.CallFr(this);">Bentuk</td>
        </tr>
        <?php 
/*	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }*/
	  if ($filter!=""){
	  	$tfilter=explode("*-*",$filter);
		$filter="";
		for ($k=0;$k<count($tfilter);$k++){
			$ifilter=explode("|",$tfilter[$k]);
			$filter .=" and ".$ifilter[0]." like '%".$ifilter[1]."%'";
			//echo $filter."<br>";
		}
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT
  tbl1.OBAT_ID,
  tbl1.OBAT_KODE,
  tbl1.OBAT_NAMA,
  tbl1.OBAT_KODE,
  tbl1.OBAT_BENTUK,
  tbl2.id
FROM (SELECT
        a_obat.*,
        a_pabrik.PABRIK,
        a_kelas.KLS_NAMA,
        aoj.obat_jenis,
        aog.golongan,
        aok.kategori
      FROM a_obat
        LEFT JOIN a_pabrik
          ON a_obat.PABRIK_ID = a_pabrik.PABRIK_ID
        LEFT JOIN a_kelas
          ON a_obat.KLS_ID = a_kelas.KLS_ID
        LEFT JOIN a_obat_kategori aok
          ON a_obat.OBAT_KATEGORI = aok.id
        LEFT JOIN a_obat_golongan aog
          ON a_obat.OBAT_GOLONGAN = aog.kode
        LEFT JOIN a_obat_jenis aoj
          ON a_obat.OBAT_KELOMPOK = aoj.obat_jenis_id
      WHERE OBAT_ISAKTIF = 1) AS tbl1
  LEFT JOIN (SELECT
               bhp.id,
               o.OBAT_ID,
               o.OBAT_KODE,
               o.OBAT_NAMA,
               o.OBAT_BENTUK
             FROM a_obat o
               INNER JOIN a_obat_askes_bhp bhp
                 ON bhp.obat_id = o.OBAT_ID) AS tbl2
    ON tbl1.OBAT_ID = tbl2.OBAT_ID
WHERE tbl2.id IS NULL ".$filter." ORDER BY tbl1.OBAT_NAMA";
	  //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=20;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
		//echo $sql;
		
	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  $c = 0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
		$arfvalue="act*-*edit*|*obat_id*-*".$rows['OBAT_ID']."*|*obat_kode*-*".$rows['OBAT_KODE']."*|*obat_nama*-*".$rows['OBAT_NAMA']."*|*obat_dosis*-*".$rows['OBAT_DOSIS']."*|*obat_satuan_kecil*-*".$rows['OBAT_SATUAN_KECIL']."*|*obat_bentuk*-*".$rows['OBAT_BENTUK']."*|*kls_id*-*".$rows['KLS_ID']."*|*kls_nama*-*".$rows['KLS_NAMA']."*|*obat_kategori*-*".$rows['OBAT_KATEGORI']."*|*jenis_obat*-*".$rows['OBAT_KELOMPOK']."*|*obat_golongan*-*".$rows['OBAT_GOLONGAN']."*|*obat_isaktif*-*".$rows['OBAT_ISAKTIF']."*|*id_paten*-*".$rows['ID_PATEN']."*|*kode_paten*-*".$rows['KODE_PATEN'];
		
		 $id_paten=$rows["ID_PATEN"];
		 $obat_kat=$rows["OBAT_KATEGORI"];
		 $txtpaten="";
		 if ($obat_kat==1 or $obat_kat==2 or $obat_kat==4){
		 	$sql="SELECT * FROM a_obat WHERE OBAT_ID IN ($id_paten)";
			//echo $sql."<br>";
			$rs1=mysqli_query($konek,$sql);
			while ($rows1=mysqli_fetch_array($rs1)){
				$txtpaten .=$rows1["OBAT_KODE"]." - ".$rows1["OBAT_NAMA"]."<br>";
			}
			mysqli_free_result($rs1);
		 }
		 
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*obat_id*-*".$rows['OBAT_ID'];
	  ?>
					  	  <script>
							Text[<?php echo $i; ?>]=["Obat Patennya","<?php echo $txtpaten; ?>"];
							Style=["white","black","#000099","#E8E8FF","","","","","","","","","","",400,"",2,2,10,10,51,0.5,75,"simple","gray"];			
							applyCssFilter()
						  </script>
        <input type="hidden" id="arf<?php echo $i; ?>" value="<?php echo $arfvalue; ?>" />
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><input type="checkbox" id="<?php echo "cekbox_".$c; ?>" name="<?php echo "cekbox"; ?>" value="<?php echo $rows['OBAT_ID']; ?>"></td>
          <td class="tdisi"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
          <td align="center" class="tdisi">&nbsp;<?php echo $rows['OBAT_BENTUK']; ?></td> 
        </tr>
        <?php 
		$c++;
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;Hal. 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td align="right" colspan="2"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"><img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();"> 
          </td>
        </tr>
      </table>
      </td>
      <td align="center">
      <input type="hidden" id="aksi" name="aksi">
      <input type="hidden" id="tempID" name="tempID">
      <button type="button" onClick="kekanan()">=></button><br><br>
      <button type="button" onClick="kekiri()"><=</button>
      </td>
      <td width="450" align="right" style="vertical-align:top">
      <table width="100%" border="0" cellpadding="1" cellspacing="0" style="float:right; margin-right:5px;">
        <tr class="headtable">
          <td id="OBAT_ID" width="38" class="tblheaderkiri" onClick="cek2()"><input type="checkbox" id="cek_all2" name="cek_all2"></td>
          <td width="91" class="tblheader" id="OBAT_KODE" onClick="ifPop.CallFr(this);">Kode 
            Obat </td>
          <td id="OBAT_NAMA" width="296" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat </td>
          <!--td id="PABRIK" width="122" class="tblheader" onClick="ifPop.CallFr(this);">Pabrik </td-->
          <!--td id="OBAT_SATUAN_BESAR" width="51" class="tblheader" onClick="ifPop.CallFr(this);">Satuan Besar</td-->
          <!--td id="ISI_SATUAN_KECIL" width="47" class="tblheader" onClick="ifPop.CallFr(this);">Isi Satuan</td-->
          <td id="OBAT_BENTUK" width="95" class="tblheader" onClick="ifPop.CallFr(this);">Bentuk</td>
        </tr>
        <?php 
/*	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }*/
	  if ($filter!=""){
	  	$tfilter=explode("*-*",$filter);
		$filter="";
		for ($k=0;$k<count($tfilter);$k++){
			$ifilter=explode("|",$tfilter[$k]);
			$filter .=" and ".$ifilter[0]." like '%".$ifilter[1]."%'";
			//echo $filter."<br>";
		}
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT bhp.id,o.OBAT_ID,o.OBAT_KODE,o.OBAT_NAMA,o.OBAT_BENTUK FROM a_obat o INNER JOIN a_obat_askes_bhp bhp ON bhp.obat_id=o.OBAT_ID ORDER BY o.OBAT_NAMA";
	  //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=20;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
		//echo $sql;
		
	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  $c = 0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
		$arfvalue="act*-*edit*|*obat_id*-*".$rows['OBAT_ID']."*|*obat_kode*-*".$rows['OBAT_KODE']."*|*obat_nama*-*".$rows['OBAT_NAMA']."*|*obat_dosis*-*".$rows['OBAT_DOSIS']."*|*obat_satuan_kecil*-*".$rows['OBAT_SATUAN_KECIL']."*|*obat_bentuk*-*".$rows['OBAT_BENTUK']."*|*kls_id*-*".$rows['KLS_ID']."*|*kls_nama*-*".$rows['KLS_NAMA']."*|*obat_kategori*-*".$rows['OBAT_KATEGORI']."*|*jenis_obat*-*".$rows['OBAT_KELOMPOK']."*|*obat_golongan*-*".$rows['OBAT_GOLONGAN']."*|*obat_isaktif*-*".$rows['OBAT_ISAKTIF']."*|*id_paten*-*".$rows['ID_PATEN']."*|*kode_paten*-*".$rows['KODE_PATEN'];
		
		 $id_paten=$rows["ID_PATEN"];
		 $obat_kat=$rows["OBAT_KATEGORI"];
		 $txtpaten="";
		 if ($obat_kat==1 or $obat_kat==2 or $obat_kat==4){
		 	$sql="SELECT * FROM a_obat WHERE OBAT_ID IN ($id_paten)";
			//echo $sql."<br>";
			$rs1=mysqli_query($konek,$sql);
			while ($rows1=mysqli_fetch_array($rs1)){
				$txtpaten .=$rows1["OBAT_KODE"]." - ".$rows1["OBAT_NAMA"]."<br>";
			}
			mysqli_free_result($rs1);
		 }
		 
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*obat_id*-*".$rows['OBAT_ID'];
	  ?>
					  	  <script>
							Text[<?php echo $i; ?>]=["Obat Patennya","<?php echo $txtpaten; ?>"];
							Style=["white","black","#000099","#E8E8FF","","","","","","","","","","",400,"",2,2,10,10,51,0.5,75,"simple","gray"];			
							applyCssFilter()
						  </script>
        <input type="hidden" id="arf<?php echo $i; ?>" value="<?php echo $arfvalue; ?>" />
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><input type="checkbox" id="<?php echo "cekbox2_".$c; ?>" name="<?php echo "cekbox2"; ?>" value="<?php echo $rows['id']; ?>"></td>
          <td class="tdisi"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
          <td align="center" class="tdisi">&nbsp;<?php echo $rows['OBAT_BENTUK']; ?></td> 
        </tr>
        <?php 
		$c++;
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;Hal. 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td align="right" colspan="2"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"><img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();"> 
          </td>
        </tr>
      </table>
      </td>
      </tr>
      </table>
  </div>
  </form>
</div>
</body>
<script>
	function fSetVariabel(p){
		fSetValue(window,document.getElementById(p).value);
	}
	
	function cek(){
		var jml = document.getElementsByName('cekbox').length;
		//alert(jml);
		for(var i=0;i<jml;i++){
			if(document.getElementById('cek_all').checked)
				document.getElementById('cekbox_'+i).checked=true;
			else
				document.getElementById('cekbox_'+i).checked=false;
		}
	}
	
	function cek2(){
		var jml = document.getElementsByName('cekbox2').length;
		//alert(jml);
		for(var i=0;i<jml;i++){
			if(document.getElementById('cek_all2').checked)
				document.getElementById('cekbox2_'+i).checked=true;
			else
				document.getElementById('cekbox2_'+i).checked=false;
		}
	}
	
	function kekanan(){
		var jml = document.getElementsByName('cekbox').length;
		var temp='';
		for(var i=0;i<jml;i++){
			if(document.getElementById('cekbox_'+i).checked){
				temp=document.getElementById('cekbox_'+i).value+"|"+temp;
			}
		}
		document.getElementById('aksi').value = 'kanan';
		document.getElementById('tempID').value = temp;
		document.form1.submit();
	}
	
	function kekiri(){
		var jml = document.getElementsByName('cekbox2').length;
		var temp='';
		for(var i=0;i<jml;i++){
			if(document.getElementById('cekbox2_'+i).checked){
				temp=document.getElementById('cekbox2_'+i).value+"|"+temp;
			}
		}
		//alert(temp);
		document.getElementById('aksi').value = 'kiri';
		document.getElementById('tempID').value = temp;
		document.form1.submit();
	}
</script>
</html>
<?php 
mysqli_close($konek);
?>
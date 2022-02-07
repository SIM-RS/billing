<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$username=$_REQUEST['user'];
//====================================================================
//Paging,Sorting dan Filter======
$defaultsort="o.OBAT_NAMA,m.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$kelas=$_REQUEST['kelas'];if ($kelas=="") $fkelas=""; else{ if ($filter=="") $fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'"; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";}
$golongan=$_REQUEST['golongan'];if ($golongan=="") $fgolongan=""; else{ if (($filter=="")&&($fkelas=="")) $fgolongan=" WHERE o.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND o.OBAT_GOLONGAN='$golongan'";}
$jenis=$_REQUEST['jenis'];if ($jenis=="") $fjenis=""; else { if (($filter=="")&&($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE o.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND o.OBAT_KELOMPOK=$jenis";}
$kategori=$_REQUEST['kategori'];if ($kategori=="") $fkategori=""; else { if (($fkelas=="")&&($fgolongan=="")&&($fjenis=="")) $fkategori=" WHERE o.OBAT_KATEGORI=$kategori"; else $fkategori=" AND o.OBAT_KATEGORI=$kategori";}
$g1=$_REQUEST['g1'];
$k1=$_REQUEST['k1'];
$j1=$_REQUEST['j1'];
$f1=$_REQUEST['f1'];
//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
?>
<html>
<head>
<title>Laporan Stok All Unit</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<link rel="stylesheet" href="../theme/print.css" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 12px}
-->
</style>
</head>
<body>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="unit_id" id="unit_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
  <p><span class="jdltable">STOK SELURUH UNIT<br>KELAS : <?php echo $k1; ?><br>KATEGORI : <?php echo $f1; ?><br>GOLONGAN : <?php echo $g1; ?><br>JENIS : <?php echo $j1; ?><br>TGL : <?php echo $tgl; ?></span></p>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="33" height="25" class="tblheaderkiri">No</td>
          <td width="494" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Obat</td>
          <td width="104" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="unit1" width="67" class="tblheader" onClick="ifPop.CallFr(this);">GD</td>
          <td id="unit2" width="67" class="tblheader" onClick="ifPop.CallFr(this);">AP-RS</td>
          <td id="unit3" width="61" class="tblheader" onClick="ifPop.CallFr(this);">AP-Krakatau</td>
          <td id="unit4" width="62" class="tblheader" onClick="ifPop.CallFr(this);">AP-BICT</td>
          <td id="unit17" width="56" class="tblheader" onClick="ifPop.CallFr(this);">PR</td>
          <td id="unit20" width="51" class="tblheader" onClick="ifPop.CallFr(this);">FS</td>
          <td id="total" width="42" class="tblheader" onClick="ifPop.CallFr(this);">Total</td>
          <td id="ntotal" width="52" class="tblheader" onClick="ifPop.CallFr(this);">Nilai</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	 $sql="SELECT o.OBAT_NAMA AS obat,m.NAMA AS kepemilikan,v.*,unit1+unit2+unit3+unit4+unit5+unit6+unit7+unit8+unit9+unit11+unit12+unit17+unit20 AS total 
		FROM vstokall AS v INNER JOIN a_obat AS o ON v.obat_id=o.OBAT_ID INNER JOIN a_kepemilikan AS m ON v.kepemilikan_id=m.ID 
		LEFT JOIN a_kelas AS kls ON o.KLS_ID=kls.KLS_ID".$filter.$fkelas.$fgolongan.$fjenis.$fkategori."
		ORDER BY ".$sorting;
	 //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;	
		
	$n="select SUM(nilai) nilai from a_stok where obat_id=".$rows['obat_id']." and kepemilikan_id = ".$rows['KEPEMILIKAN_ID']." ";
	//  echo $sql2."<br>";
	  $n1=mysqli_query($konek,$n);
	  $n2=mysqli_fetch_array($n1);
	  $nilai=$n2['nilai'];	
		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td align="center" class="tdisikiri"><?php echo $i; ?></td>
          <td align="left" class="tdisi"><?php echo $rows['obat']; ?></td>
          <td align="center" class="tdisi"><?php echo $rows['kepemilikan']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['unit1']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['unit2']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['unit3']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['unit4']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['unit5']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['unit6']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['total']; ?></td>
          <td align="right" class="tdisi"><?php echo number_format($nilai,0,",","."); ?></td>
        </tr>
        <?php   $jml_tot+=$nilai;
	  }
	//  $jml_tot=0;
	  //$sql2="select sum(ntotal) as jml_tot from vstokall as v,a_kepemilikan as m,a_obat as o where o.OBAT_ID=v.obat_id and m.ID=v.kepemilikan_id".$filter;
	  $sql2="select if (sum(p2.ntotal) is null,0,sum(p2.ntotal)) as jml_tot from (".$sql.") as p2";
	  //echo $sql2."<br>";
	  $rs=mysqli_query($konek,$sql2);
	  $show=mysqli_fetch_array($rs);
	 // $jml_tot=$show['jml_tot'];
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="7"><span class="style1">Ket:GD=Gudang; AP=Apotik; PR=Produksi; 
            FS=Floor Stock;</span></td>
          <td colspan="2" align="right"><span class="style1"><strong>Nilai Total 
            :&nbsp;&nbsp;</strong></span></td>
          <td colspan="2" align="right"><span class="style1"><strong><?php echo number_format($jml_tot,0,",","."); ?></strong></span></td>
        </tr>
      </table>
		<p class='txtinput'  style='padding-right:25px; text-align:right;'>
		<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>
		</p>

    </div>
</form>
</div>
<script>
 window.print();window.close();
</script>
</body>
</html>
<?php 
mysqli_close($konek);
?>
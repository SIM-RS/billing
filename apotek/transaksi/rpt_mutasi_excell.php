<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//Paging,Sorting dan Filter======
$tipe=$_REQUEST['tipe'];
$bulan=$_REQUEST['bulan'];
convert_var($tglctk,$tgl,$tglact,$tipe,$bulan);

$bulann=$_REQUEST['bulann'];
$tahun=$_REQUEST['tahun'];
$bulan1=$_REQUEST['bulan1'];
$bulan1n=$_REQUEST['bulan1n'];
$tahun1=$_REQUEST['tahun1'];
convert_var($bulann,$tahun,$bulan1,$bulan1n,$tahun1);

//$defaultsort="t6.OBAT_NAMA,t6.KEPEMILIKAN_ID";
$idunit1=$_REQUEST['idunit1'];
convert_var($idunit1);
$unitn="ALL UNIT";
if ($idunit1!="0"){
	$sql="SELECT * FROM a_unit WHERE UNIT_ID=".$idunit1;
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		$unitn=$rows["UNIT_NAME"];
	}
}
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$kpid=$_REQUEST['kpid'];
$kelas=$_REQUEST['kelas'];
$golongan=$_REQUEST['golongan'];
convert_var($sorting,$filter,$kpid,$kelas,$golongan);
$jenis=$_REQUEST['jenis'];
$kategori=$_REQUEST['kategori'];
$bentuk=$_REQUEST['bentuk'];
convert_var($jenis,$kategori);

if ($kpid=="0") $filter=""; else $filter=" AND KEPEMILIKAN_ID=".$kpid;
if ($bentuk=="") $fbentuk=""; else $fbentuk=" WHERE ao.OBAT_BENTUK='$bentuk'";
if ($kelas=="") $fkelas=""; else{$fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'";}
if ($golongan=="") $fgolongan=""; else{ if ($kelas=="") $fgolongan=" WHERE ao.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";}
if ($jenis=="") $fjenis=""; else { if (($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE ao.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";}

if ($kategori==""){ $fkategori=""; }
else { 
	if(($fkelas!="")&&($fgolongan!="")&&($fjenis!="")){
		$fkategori=" AND ao.OBAT_KATEGORI=$kategori"; 
	} else {
		$fkategori=" WHERE ao.OBAT_KATEGORI=$kategori"; 
	}
}
//echo $fkategori;
$kpid1=$_REQUEST['kpid1'];
$g1=$_REQUEST['g1'];
$k1=$_REQUEST['k1'];
$j1=$_REQUEST['j1'];
convert_var($kpid1,$g1,$k1,$j1);

$dKat = '';
if($kategori!=''){
	$sqlKat = "select UPPER(kategori) kategori from a_obat_kategori where id = ".$kategori;
	$queryKat = mysqli_query($konek,$sqlKat) or die (mysqli_error($konek));
	$dKat = mysqli_fetch_array($queryKat);
} else {
	$dKat['kategori'] = "SEMUA";
}

//===============================

require_once('../Excell/Writer.php');

$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('Mutasi_Obat_'.$bulann.'_'.$tahun.'.xls');

$worksheet=&$workbook->addWorksheet('Lap_Mutasi_Obat');
$worksheet->setPaper("letter");

$worksheet->setMargins_LR(0.2);
$worksheet->setMargins_TB(0.2);
$columnWidth = 10;
if ($idunit1=="0"){
	$worksheet->setColumn (0, 0, 3);
	$worksheet->setColumn (1, 1, 25);
	$worksheet->setColumn (2, 2, 10);
	$worksheet->setColumn (3, 3, 10);
	$worksheet->setColumn (4, 4, 5);
	$worksheet->setColumn (5, 5, 11);
	$worksheet->setColumn (6, 17, 3);
	$worksheet->setColumn (18, 18, 5);
	$worksheet->setColumn (19, 19, 11);
}else{
	$worksheet->setColumn (0, 0, 3);
	$worksheet->setColumn (1, 1, 25);
	$worksheet->setColumn (2, 2, 10);
	$worksheet->setColumn (3, 3, 10);
	$worksheet->setColumn (4, 4, 5);
	$worksheet->setColumn (5, 5, 11);
	$worksheet->setColumn (6, 15, 3);
	$worksheet->setColumn (16, 16, 5);
	$worksheet->setColumn (17, 17, 11);
}

$sheetTitleFormat =& $workbook->addFormat(array('size'=>10,'align'=>'center'));
$UnitTitleFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left'));
$UnitTitleFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TLBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_BR =& $workbook->addFormat(array('size'=>8,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>8,'align'=>'center'));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center'));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left'));
$regularFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1));
$regularFormatRF =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

$column = 0;
$row    = 0;


$worksheet->write($row, 6, "LAPORAN MUTASI OBAT", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 6, "UNIT : $unitn", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 6, "KEPEMILIKAN : $kpid1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 6, "KELAS : $k1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 6, "GOLONGAN : $g1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 6, "JENIS : $j1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 6, "KATEGORI OBAT : ".$dKat['kategori'], $sheetTitleFormat);
$row += 1;
if ($tipe=="1"){
	$worksheet->write($row, 6, "PERIODE : ".strtoupper($bulann)." ".$tahun, $sheetTitleFormat);
}else{
	$worksheet->write($row, 6, "PERIODE : ".strtoupper($bulann)." ".$tahun." s/d ".strtoupper($bulan1n)." ".$tahun1, $sheetTitleFormat);
}

$row += 1;
if ($idunit1=="0"){
	$worksheet->write($row, $column, "No", $columnTitleFormat);
	$worksheet->write($row, $column+1, "Nama Obat", $columnTitleFormat);
	$worksheet->write($row, $column+2, "Kategori", $columnTitleFormat);
	$worksheet->write($row, $column+3, "Bentuk", $columnTitleFormat);
	$worksheet->write($row, $column+4, "Saldo Awal", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+5, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+4,$row,$column+5);
	$worksheet->write($row, $column+6, "Masuk", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+7, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+8, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+9, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+10, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+11, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+12, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+13, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+14, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+15, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+16, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+17, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+6,$row,$column+17);
	$worksheet->write($row, $column+18, "Keluar", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+19, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+20, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+21, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+22, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+23, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+24, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+25, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+26, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+27, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+28, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+29, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+18,$row,$column+29);
	$worksheet->write($row, $column+30, "Adj", $columnTitleFormat);
	$worksheet->write($row, $column+31, "Saldo Akhir", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+32, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+31,$row,$column+32);
}else{
	$worksheet->write($row, $column, "No", $columnTitleFormat);
	$worksheet->write($row, $column+1, "Nama Obat", $columnTitleFormat);
	$worksheet->write($row, $column+2, "Kategori", $columnTitleFormat);
	$worksheet->write($row, $column+3, "Bentuk", $columnTitleFormat);
	$worksheet->write($row, $column+4, "Saldo Awal", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+5, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+4,$row,$column+5);
	$worksheet->write($row, $column+6, "Masuk", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+7, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+8, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+9, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+10, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+11, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+12, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+13, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+14, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+15, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+6,$row,$column+15);
	$worksheet->write($row, $column+16, "Keluar", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+17, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+18, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+19, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+20, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+21, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+22, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+23, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+24, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+25, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+16,$row,$column+25);
	$worksheet->write($row, $column+26, "Adj", $columnTitleFormat);
	$worksheet->write($row, $column+27, "Saldo Akhir", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+28, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+27,$row,$column+28);
}
$row += 1;

if ($idunit1=="0"){
	$worksheet->writeBlank($row, $column, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column,$row,$column);
	$worksheet->writeBlank($row, $column+1, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column+1,$row,$column+1);
	$worksheet->writeBlank($row, $column+2, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column+2,$row,$column+2);
	$worksheet->writeBlank($row, $column+3, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column+3,$row,$column+3);
	$worksheet->write($row, $column+4, "Qty", $columnTitleFormat);
	$worksheet->write($row, $column+5, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+6, "Pbf", $columnTitleFormat);
	$worksheet->write($row, $column+7, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+8, "Prod", $columnTitleFormat);
	$worksheet->write($row, $column+9, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+10, "Unit", $columnTitleFormat);
	$worksheet->write($row, $column+11, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+12, "Milik", $columnTitleFormat);
	$worksheet->write($row, $column+13, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+14, "Ret", $columnTitleFormat);
	$worksheet->write($row, $column+15, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+16, "Sisa", $columnTitleFormat);
	$worksheet->write($row, $column+17, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+18, "Jual", $columnTitleFormat);
	$worksheet->write($row, $column+19, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+20, "Prod", $columnTitleFormat);
	$worksheet->write($row, $column+21, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+22, "Unit", $columnTitleFormat);
	$worksheet->write($row, $column+23, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+24, "Ret", $columnTitleFormat);
	$worksheet->write($row, $column+25, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+26, "Milik", $columnTitleFormat);
	$worksheet->write($row, $column+27, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+28, "Hapus", $columnTitleFormat);
	$worksheet->write($row, $column+29, "Nilai", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+30, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column+30,$row,$column+30);
	$worksheet->write($row, $column+31, "Qty", $columnTitleFormat);
	$worksheet->write($row, $column+32, "Nilai", $columnTitleFormat);
}else{
	$worksheet->writeBlank($row, $column, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column,$row,$column);
	$worksheet->writeBlank($row, $column+1, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column+1,$row,$column+1);
	$worksheet->writeBlank($row, $column+2, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column+2,$row,$column+2);
	$worksheet->writeBlank($row, $column+3, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column+3,$row,$column+3);
	$worksheet->write($row, $column+4, "Qty", $columnTitleFormat);
	$worksheet->write($row, $column+5, "Nilai", $columnTitleFormat);
	if ($idunit1=="16"){
		$worksheet->write($row, $column+6, "Prod", $columnTitleFormat);
		$worksheet->write($row, $column+7, "Nilai", $columnTitleFormat);
	}else{
		$worksheet->write($row, $column+6, "Pbf", $columnTitleFormat);
		$worksheet->write($row, $column+7, "Nilai", $columnTitleFormat);
	}
	$worksheet->write($row, $column+8, "Unit", $columnTitleFormat);
	$worksheet->write($row, $column+9, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+10, "Milik", $columnTitleFormat);
	$worksheet->write($row, $column+11, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+12, "Ret", $columnTitleFormat);
	$worksheet->write($row, $column+13, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+14, "Sisa", $columnTitleFormat);
	$worksheet->write($row, $column+15, "Nilai", $columnTitleFormat);
	if ($idunit1=="16"){
		$worksheet->write($row, $column+16, "Prod", $columnTitleFormat);
		$worksheet->write($row, $column+17, "Nilai", $columnTitleFormat);
	}else{
		$worksheet->write($row, $column+16, "Jual", $columnTitleFormat);
		$worksheet->write($row, $column+17, "Nilai", $columnTitleFormat);
	}
		
	$worksheet->write($row, $column+18, "Unit", $columnTitleFormat);
	$worksheet->write($row, $column+19, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+20, "Ret", $columnTitleFormat);
	$worksheet->write($row, $column+21, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+22, "Milik", $columnTitleFormat);
	$worksheet->write($row, $column+23, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+24, "Hapus", $columnTitleFormat);
	$worksheet->write($row, $column+25, "Nilai", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+26, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column+26,$row,$column+26);
	$worksheet->write($row, $column+27, "Qty", $columnTitleFormat);
	$worksheet->write($row, $column+28, "Nilai", $columnTitleFormat);
}

$row++; 

  if ($sorting=="") $sorting=$defaultsort;
  if ($tipe=="1"){
	  if ($idunit1=="0"){
	  	$sql="SELECT ao.OBAT_NAMA,
		  ao.OBAT_BENTUK,
		  ak.NAMA,
		  ok.kategori,
		  SUM( arpt.QTY_AWAL ) AS QTY_AWAL,
		  SUM(
		  FLOOR( arpt.NILAI_AWAL )) AS NILAI_AWAL,
		  SUM( arpt.PBF ) AS PBF,
		  SUM(arpt.PBF_NILAI) AS PBF_NILAI,
		  SUM( arpt.UNIT_IN ) AS UNIT_IN,
		  SUM( arpt.UNIT_IN_NILAI ) AS UNIT_IN_NILAI,
		  SUM( arpt.MILIK_IN ) AS MILIK_IN,
		  SUM( arpt.MILIK_IN_NILAI ) AS MILIK_IN_NILAI,
		  SUM( arpt.RETURN_IN ) AS RETURN_IN,
		  SUM( arpt.RETURN_IN_NILAI ) AS RETURN_IN_NILAI,
		  SUM( arpt.PRODUKSI_IN ) AS PRODUKSI_IN,
		  SUM( arpt.PRODUKSI_IN_NILAI ) AS PRODUKSI_IN_NILAI,
		  SUM( arpt.JUAL ) AS JUAL,
		  SUM( arpt.JUAL_NILAI ) AS JUAL_NILAI,
		  SUM( arpt.UNIT_OUT ) AS UNIT_OUT,
		  SUM( arpt.UNIT_OUT_NILAI ) AS UNIT_OUT_NILAI,
		  SUM( arpt.RETURN_OUT ) AS RETURN_OUT,
		  SUM( arpt.RETURN_OUT_NILAI ) AS RETURN_OUT_NILAI,
		  SUM( arpt.MILIK_OUT ) AS MILIK_OUT,
		  SUM( arpt.MILIK_OUT_NILAI ) AS MILIK_OUT_NILAI,
		  SUM( arpt.HAPUS ) AS HAPUS,
		  SUM( arpt.HAPUS_NILAI ) AS HAPUS_NILAI,
		  SUM( arpt.PRODUKSI_OUT ) AS PRODUKSI_OUT,
		  SUM( arpt.PRODUKSI_OUT_NILAI ) AS PRODUKSI_OUT_NILAI,
		  SUM( arpt.ADJUST ) AS ADJUST,
		  SUM( arpt.QTY_AKHIR ) AS QTY_AKHIR,
		  SUM(
		  FLOOR( arpt.NILAI_AKHIR )) AS NILAI_AKHIR,
		  SUM(arpt.SISA_IN) AS SISA_IN,
		  SUM(arpt.SISA_IN_NILAI) AS SISA_IN_NILAI 
FROM (SELECT * FROM a_rpt_mutasi WHERE BULAN=$bulan AND TAHUN=$tahun".$filter.") AS arpt 
INNER JOIN (SELECT * FROM a_obat WHERE OBAT_ISAKTIF=1) ao ON arpt.OBAT_ID=ao.OBAT_ID 
INNER JOIN a_kepemilikan ak ON arpt.KEPEMILIKAN_ID=ak.ID 
LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID
LEFT JOIN a_obat_kategori ok ON ok.id = ao.OBAT_KATEGORI
".$fkelas.$fgolongan.$fjenis.$fbentuk.$fkategori." 
GROUP BY arpt.OBAT_ID,arpt.KEPEMILIKAN_ID ORDER BY ao.OBAT_NAMA,ak.ID";
	  }else{
		$sql="SELECT ao.OBAT_NAMA,ao.OBAT_BENTUK,ak.NAMA,ok.kategori,arpt.* 
FROM (SELECT * FROM a_rpt_mutasi WHERE BULAN=$bulan AND TAHUN=$tahun AND UNIT_ID=$idunit1".$filter.") AS arpt 
INNER JOIN (SELECT * FROM a_obat WHERE OBAT_ISAKTIF=1) ao ON arpt.OBAT_ID=ao.OBAT_ID 
INNER JOIN a_kepemilikan ak ON arpt.KEPEMILIKAN_ID=ak.ID 
LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID  
LEFT JOIN a_obat_kategori ok ON ok.id = ao.OBAT_KATEGORI
".$fkelas.$fgolongan.$fjenis.$fbentuk.$fkategori." ORDER BY ao.OBAT_NAMA,ak.ID";
	  }
  }else{
  	  if ($bulan<10) $tgl_awal=$tahun."-0".$bulan; else $tgl_awal=$tahun."-".$bulan;
	  if ($bulan1<10) $tgl_akhir=$tahun1."-0".$bulan1; else $tgl_akhir=$tahun1."-".$bulan1;
	  if ($idunit1=="0"){
		$sql="SELECT ao.OBAT_NAMA,ao.OBAT_BENTUK,ak.NAMA,ok.kategori,arpt.* FROM 
(SELECT OBAT_ID,KEPEMILIKAN_ID,SUM(QTY_AWAL1) AS QTY_AWAL,SUM(FLOOR(NILAI_AWAL1)) AS NILAI_AWAL,SUM(PBF) AS PBF,
SUM(UNIT_IN) AS UNIT_IN,SUM(MILIK_IN) AS MILIK_IN,SUM(RETURN_IN) AS RETURN_IN,SUM(PRODUKSI_IN) AS PRODUKSI_IN,
SUM(JUAL) AS JUAL,SUM(UNIT_OUT) AS UNIT_OUT,SUM(RETURN_OUT) AS RETURN_OUT,SUM(MILIK_OUT) AS MILIK_OUT,SUM(HAPUS) AS HAPUS,
SUM(PRODUKSI_OUT) AS PRODUKSI_OUT,SUM(ADJUST) AS ADJUST,SUM(QTY_AKHIR1) AS QTY_AKHIR,SUM(FLOOR(NILAI_AKHIR1)) AS NILAI_AKHIR FROM 
(SELECT *,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan."',QTY_AWAL,0) AS QTY_AWAL1,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan."',NILAI_AWAL,0) AS NILAI_AWAL1,
IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan1."',QTY_AKHIR,0) AS QTY_AKHIR1,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan1."',NILAI_AKHIR,0) AS NILAI_AKHIR1
FROM a_rpt_mutasi WHERE (CONCAT(TAHUN,'-',IF (BULAN<10,CONCAT('0',BULAN),BULAN)) 
BETWEEN '$tgl_awal' AND '$tgl_akhir')".$filter.") AS tmp1 GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS arpt 
INNER JOIN (SELECT * FROM a_obat WHERE OBAT_ISAKTIF=1) ao ON arpt.OBAT_ID=ao.OBAT_ID 
INNER JOIN a_kepemilikan ak ON arpt.KEPEMILIKAN_ID=ak.ID 
LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID 
LEFT JOIN a_obat_kategori ok ON ok.id = ao.OBAT_KATEGORI
".$fkelas.$fgolongan.$fjenis.$fbentuk.$fkategori." ORDER BY ao.OBAT_NAMA,ak.ID";
	  }else{
		$sql="SELECT ao.OBAT_NAMA,ao.OBAT_BENTUK,ak.NAMA,ok.kategori,arpt.* FROM 
(SELECT OBAT_ID,KEPEMILIKAN_ID,SUM(QTY_AWAL1) AS QTY_AWAL,SUM(FLOOR(NILAI_AWAL1)) AS NILAI_AWAL,SUM(PBF) AS PBF,
SUM(UNIT_IN) AS UNIT_IN,SUM(MILIK_IN) AS MILIK_IN,SUM(RETURN_IN) AS RETURN_IN,SUM(PRODUKSI_IN) AS PRODUKSI_IN,
SUM(JUAL) AS JUAL,SUM(UNIT_OUT) AS UNIT_OUT,SUM(RETURN_OUT) AS RETURN_OUT,SUM(MILIK_OUT) AS MILIK_OUT,SUM(HAPUS) AS HAPUS,
SUM(PRODUKSI_OUT) AS PRODUKSI_OUT,SUM(ADJUST) AS ADJUST,SUM(QTY_AKHIR1) AS QTY_AKHIR,SUM(FLOOR(NILAI_AKHIR1)) AS NILAI_AKHIR FROM 
(SELECT *,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan."',QTY_AWAL,0) AS QTY_AWAL1,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan."',NILAI_AWAL,0) AS NILAI_AWAL1,
IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan1."',QTY_AKHIR,0) AS QTY_AKHIR1,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan1."',NILAI_AKHIR,0) AS NILAI_AKHIR1
FROM a_rpt_mutasi WHERE UNIT_ID=$idunit1".$filter." AND CONCAT(TAHUN,'-',IF (BULAN<10,CONCAT('0',BULAN),BULAN)) 
BETWEEN '$tgl_awal' AND '$tgl_akhir') AS tmp1 GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS arpt 
INNER JOIN (SELECT * FROM a_obat WHERE OBAT_ISAKTIF=1) ao ON arpt.OBAT_ID=ao.OBAT_ID 
INNER JOIN a_kepemilikan ak ON arpt.KEPEMILIKAN_ID=ak.ID 
LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID 
LEFT JOIN a_obat_kategori ok ON ok.id = ao.OBAT_KATEGORI
".$fkelas.$fgolongan.$fbentuk.$fjenis.$fkategori." ORDER BY ao.OBAT_NAMA,ak.ID";
	  }
  }

//echo $sql."<br>";

$rs=mysqli_query($konek,$sql);
if ($idunit1=="0"){
	while ($rows=mysqli_fetch_array($rs)){
		$qty_trans=$rows['QTY_AWAL']+$rows['PBF']+$rows['PRODUKSI_IN']+$rows['UNIT_IN'];
		$qty_trans+=$rows['MILIK_IN']+$rows['RETURN_IN']+$rows['JUAL']+$rows['PRODUKSI_OUT'];
		$qty_trans+=$rows['UNIT_OUT']+$rows['RETURN_OUT']+$rows['MILIK_OUT']+$rows['HAPUS'];
		$qty_trans+=$rows['ADJUST']+$rows['QTY_AKHIR'];
		if ($qty_trans<>0){
			$qty_akhir=$rows['QTY_AKHIR'];
			$nilai_akhir=floor($rows['NILAI_AKHIR']);
			$kode_obat=$rows['OBAT_KODE'];
			$worksheet->write($row, 0, $row-9, $regularFormatC);
			$worksheet->write($row, 1, $rows['OBAT_NAMA'], $regularFormat);
			$worksheet->write($row, 2, $rows['kategori'], $regularFormatC);
			$worksheet->write($row, 3, $rows['OBAT_BENTUK'], $regularFormatC);
			$worksheet->write($row, 4, $rows['QTY_AWAL'], $regularFormatR);
			$worksheet->write($row, 5, floor($rows['NILAI_AWAL']), $regularFormatRF);
			$worksheet->write($row, 6, $rows['PBF'], $regularFormatR);
			$worksheet->write($row, 7, $rows['PBF_NILAI'], $regularFormatR);
			$worksheet->write($row, 8, $rows['PRODUKSI_IN'], $regularFormatR);
			$worksheet->write($row, 9, $rows['PRODUKSI_IN_NILAI'], $regularFormatR);
			$worksheet->write($row, 10, $rows['UNIT_IN'], $regularFormatR);
			$worksheet->write($row, 11, $rows['UNIT_IN_NILAI'], $regularFormatR);
			$worksheet->write($row, 12, $rows['MILIK_IN'], $regularFormatR);
			$worksheet->write($row, 13, $rows['MILIK_IN_NILAI'], $regularFormatR);
			$worksheet->write($row, 14, $rows['RETURN_IN'], $regularFormatR);
			$worksheet->write($row, 15, $rows['RETURN_IN_NILAI'], $regularFormatR);
			$worksheet->write($row, 16, $rows['SISA_IN'], $regularFormatR);
			$worksheet->write($row, 17, $rows['SISA_IN_NILAI'], $regularFormatR);
			$worksheet->write($row, 18, $rows['JUAL'], $regularFormatR);
			$worksheet->write($row, 19, $rows['JUAL_NILAI'], $regularFormatR);
			$worksheet->write($row, 20, $rows['PRODUKSI_OUT'], $regularFormatR);
			$worksheet->write($row, 21, $rows['PRODUKSI_OUT_NILAI'], $regularFormatR);
			$worksheet->write($row, 22, $rows['UNIT_OUT'], $regularFormatR);
			$worksheet->write($row, 23, $rows['UNIT_OUT_NILAI'], $regularFormatR);
			$worksheet->write($row, 24, $rows['RETURN_OUT'], $regularFormatR);
			$worksheet->write($row, 25, $rows['RETURN_OUT_NILAI'], $regularFormatR);
			$worksheet->write($row, 26, $rows['MILIK_OUT'], $regularFormatR);
			$worksheet->write($row, 27, $rows['MILIK_OUT_NILAI'], $regularFormatR);
			$worksheet->write($row, 28, $rows['HAPUS'], $regularFormatR);
			$worksheet->write($row, 29, $rows['HAPUS_NILAI'], $regularFormatR);
			$worksheet->write($row, 30, $rows['ADJUST'], $regularFormatR);
			$worksheet->write($row, 31, $qty_akhir, $regularFormatR);
			$worksheet->write($row, 32, $nilai_akhir, $regularFormatRF);
			$row++;
		}
	}
	$worksheet->write($row, 3, "Total Saldo Awal", $regularFormatR);
	$worksheet->writeBlank($row, 4, $regularFormatR);
	$worksheet->mergeCells($row,3,$row,4);
	$worksheet->write($row, 5, '=Sum(F11:F'.$row.')', $regularFormatRF);
	$worksheet->write($row, 29, "Total Saldo Akhir", $regularFormatR);
	$worksheet->writeBlank($row, 30, $regularFormatR);
	$worksheet->writeBlank($row, 31, $regularFormatR);
	$worksheet->mergeCells($row,29,$row,31);
	$worksheet->write($row, 32, '=Sum(AG11:AG'.$row.')', $regularFormatRF);
	//$worksheet->write($row, 22, '=Sum(W10:U'.$row.')', $regularFormatRF);
}else{
	while ($rows=mysqli_fetch_array($rs)){
		$qty_trans=$rows['QTY_AWAL']+$rows['UNIT_IN']+$rows['MILIK_IN']+$rows['RETURN_IN']+$rows['UNIT_OUT'];
		$qty_trans+=$rows['RETURN_OUT']+$rows['MILIK_OUT']+$rows['HAPUS']+$rows['ADJUST']+$rows['QTY_AKHIR'];
		if ($idunit1=="17"){
			$qty_trans+=$rows['PRODUKSI_IN']+$rows['PRODUKSI_OUT'];
		}else{
			$qty_trans+=$rows['PBF']+$rows['JUAL'];
		}
		if ($qty_trans<>0){
			$qty_akhir=$rows['QTY_AKHIR'];
			$nilai_akhir=floor($rows['NILAI_AKHIR']);
			$kode_obat=$rows['OBAT_KODE'];
			$worksheet->write($row, 0, $row-8, $regularFormatC);
			$worksheet->write($row, 1, $rows['OBAT_NAMA'], $regularFormat);
			$worksheet->write($row, 2, $rows['kategori'], $regularFormatC);
			$worksheet->write($row, 3, $rows['OBAT_BENTUK'], $regularFormatC);
			$worksheet->write($row, 4, $rows['QTY_AWAL'], $regularFormatR);
			$worksheet->write($row, 5, floor($rows['NILAI_AWAL']), $regularFormatRF);
			if ($idunit1=="16"){
				$worksheet->write($row, 6, $rows['PRODUKSI_IN'], $regularFormatR);
				$worksheet->write($row, 7, $rows['PRODUKSI_IN_NILAI'], $regularFormatR);
			}else{
				$worksheet->write($row, 6, $rows['PBF'], $regularFormatR);
				$worksheet->write($row, 7, $rows['PBF_NILAI'], $regularFormatR);
			}
				
			
			$worksheet->write($row, 8, $rows['UNIT_IN'], $regularFormatR);
			$worksheet->write($row, 9, $rows['UNIT_IN_NILAI'], $regularFormatR);
			$worksheet->write($row, 10, $rows['MILIK_IN'], $regularFormatR);
			$worksheet->write($row, 11, $rows['MILIK_IN_NILAI'], $regularFormatR);
			$worksheet->write($row, 12, $rows['RETURN_IN'], $regularFormatR);
			$worksheet->write($row, 13, $rows['RETURN_IN_NILAI'], $regularFormatR);
			$worksheet->write($row, 14, $rows['SISA_IN'], $regularFormatR);
			$worksheet->write($row, 15, $rows['SISA_IN_NILAI'], $regularFormatR);
			if ($idunit1=="16"){
				$worksheet->write($row, 16, $rows['PRODUKSI_OUT'], $regularFormatR);
				$worksheet->write($row, 17, $rows['PRODUKSI_OUT_NILAI'], $regularFormatR);
			}else{
				$worksheet->write($row, 16, $rows['JUAL'], $regularFormatR);
				$worksheet->write($row, 17, $rows['JUAL_NILAI'], $regularFormatR);
			}	
			$worksheet->write($row, 18, $rows['UNIT_OUT'], $regularFormatR);
			$worksheet->write($row, 19, $rows['UNIT_OUT_NILAI'], $regularFormatR);
			$worksheet->write($row, 20, $rows['RETURN_OUT'], $regularFormatR);
			$worksheet->write($row, 21, $rows['RETURN_OUT_NILAI'], $regularFormatR);
			$worksheet->write($row, 22, $rows['MILIK_OUT'], $regularFormatR);
			$worksheet->write($row, 23, $rows['MILIK_OUT_NILAI'], $regularFormatR);
			$worksheet->write($row, 24, $rows['HAPUS'], $regularFormatR);
			$worksheet->write($row, 25, $rows['HAPUS_NILAI'], $regularFormatR);
			$worksheet->write($row, 26, $rows['ADJUST'], $regularFormatR);
			$worksheet->write($row, 27, $qty_akhir, $regularFormatR);
			$worksheet->write($row, 28, $nilai_akhir, $regularFormatRF);
			$row++;
		}
	}
	$worksheet->write($row, 3, "Total Saldo Awal", $regularFormatR);
	$worksheet->writeBlank($row, 4, $regularFormatR);
	$worksheet->mergeCells($row,3,$row,4);
	$worksheet->write($row, 5, '=Sum(F11:F'.$row.')', $regularFormatRF);
	// $worksheet->write($row,16,"Total Saldo Keluar",$regularFormatR);
	// $worksheet->writeBlank($row, 17, $regularFormatR);
	// $worksheet->writeBlank($row, 18, $regularFormatR);
	// $worksheet->mergeCells($row,16,$row,18);
	// $worksheet->write($row,19,'=Sum(T11:T'.$row.')', $regularFormatRF);
	$worksheet->write($row, 24, "Total Saldo Akhir", $regularFormatR);
	$worksheet->writeBlank($row, 25, $regularFormatR);
	$worksheet->writeBlank($row, 26, $regularFormatR);
	$worksheet->writeBlank($row, 27, $regularFormatR);
	$worksheet->mergeCells($row,24,$row,27);
	//$worksheet->write($row, 20, '=Sum(U10:S'.$row.')', $regularFormatRF);
	$worksheet->write($row, 28, '=Sum(AC11:AC'.$row.')', $regularFormatRF);

}

$workbook->close();

/*echo $sql="SELECT ao.OBAT_NAMA,ao.OBAT_BENTUK,ak.NAMA,ok.kategori,arpt.* 
FROM (SELECT * FROM a_rpt_mutasi WHERE BULAN=$bulan AND TAHUN=$tahun AND UNIT_ID=$idunit1".$filter.") AS arpt 
INNER JOIN (SELECT * FROM a_obat WHERE OBAT_ISAKTIF=1) ao ON arpt.OBAT_ID=ao.OBAT_ID 
INNER JOIN a_kepemilikan ak ON arpt.KEPEMILIKAN_ID=ak.ID 
LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID  
LEFT JOIN a_obat_kategori ok ON ok.id = ao.OBAT_KATEGORI
".$fkelas.$fgolongan.$fjenis.$fbentuk.$fkategori." ORDER BY ao.OBAT_NAMA,ak.ID";*/


mysqli_free_result($rs);
mysqli_close($konek);
?>
<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
convert_var($tglctk,$tgl,$tglact);
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//Paging,Sorting dan Filter======
//$defaultsort="ao.OBAT_NAMA,ak.NAMA";
$milik=$_REQUEST["milik"];
$nmilik=$_REQUEST["nmilik"];
$jenis=$_REQUEST['jenis'];
$kategori=$_REQUEST['kategori'];
$pbf=$_REQUEST['pbf'];
$cmbCaraBayar=$_REQUEST['cmbCaraBayar'];
convert_var($milik,$nmilik,$jenis,$kategori);

if(($milik=="")||($milik=="0")) $kep=""; else $kep=" and a_p.KEPEMILIKAN_ID=$milik ";
if($jenis=="") $jenis="0";
if ($kategori=="") $fkategori=""; else $fkategori=" AND ab.OBAT_BENTUK='$kategori'";
if ($cmbCaraBayar=="" OR $cmbCaraBayar==0) $fcb=""; else $fcb=" AND apo.cara_bayar_po='$cmbCaraBayar'";
if ($pbf=="" OR $pbf==0) $fpbf=""; else $fpbf=" AND a_pbf.PBF_ID='$pbf'";
$jns=" and a_p.JENIS=$jenis ";
convert_var($kep,$fkategori,$jns);

$njenis=$_REQUEST["njenis"];
$tgl_d=$_REQUEST["tgl_d"];
$tgl_s=$_REQUEST["tgl_s"];
convert_var($njenis,$tgl_d,$tgl_s);

if ($jenis=="" OR $jenis==0) { 
$join = " INNER ";
}else{
$join = " LEFT ";
}

$tgl_1=explode("-",$tgl_d);
$tgl_1=$tgl_1[2]."-".$tgl_1[1]."-".$tgl_1[0];
$tgl_2=explode("-",$tgl_s);
$tgl_2=$tgl_2[2]."-".$tgl_2[1]."-".$tgl_2[0];


$defaultsort1="tgl1 desc,NOTERIMA desc";
$defaultsort="a_pbf.PBF_NAMA,tgl1,NOTERIMA";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

convert_var($tgl_1,$tgl_2,$sorting,$filter);
//===============================
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Penerimaan_PBF.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Penerimaan_PBF');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 4);//no
$worksheet->setColumn (1, 1, 10);//tgl
$worksheet->setColumn (2, 2, 18);//no terima
$worksheet->setColumn (3, 3, 15);//no faktur
$worksheet->setColumn (4, 4, 12);//kepemilikan
$worksheet->setColumn (5, 5, 12);//sumberdana
$worksheet->setColumn (6, 6, 25);//nama obat
$worksheet->setColumn (7, 7, 10);//expired
$worksheet->setColumn (8, 8, 10);//expired
$worksheet->setColumn (9, 9, 5);//qty
$worksheet->setColumn (10, 10, 10);//sat
$worksheet->setColumn (11, 11, 15);//hrg_sat
$worksheet->setColumn (12, 12, 13);//subtotal
$worksheet->setColumn (13, 13, 6);//disk(%)
$worksheet->setColumn (14, 14, 13);//DPP - PPN
$worksheet->setColumn (15, 16, 14);//DPP+PPN
//$worksheet->setColumn (0, $numColumns, $columnWidth);

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>14,'align'=>'center'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1,'textWrap'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'yellow','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'yellow','pattern'=>1,'numFormat'=>'#,##0.00'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'yellow','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','textWrap'=>1));
$regularFormatL =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0.00'));
$regularFormatRB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0.00'));
$regularFormatLNoWrapB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'left'));
$regularFormatCNoWrapB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'center'));
$regularFormatRNoWrapB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'right'));
$gsTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'green','pattern'=>1,'numFormat'=>'#,##0.00'));

/*Speadsheet writer is in format y,x (row, column)
 *  column1  |  column2 |  column3
 *   (0,0)      (0,1)      (0,2) */

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
$worksheet->write($row, 7, "LAPORAN PENERIMAAN OBAT", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 7, "JENIS PENERIMAAN : ".$njenis, $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 7, "KEPEMILIKAN : ".$nmilik, $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 7, "TGL : ".$tgl_d." s/d ".$tgl_s, $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "No", $columnTitleFormat);
$worksheet->write($row, $column+1, "Tgl", $columnTitleFormat);
$worksheet->write($row, $column+2, "No Terima", $columnTitleFormat);
$worksheet->write($row, $column+3, "No Faktur", $columnTitleFormat);
$worksheet->write($row, $column+4, "Kepemilikan", $columnTitleFormat);
$worksheet->write($row, $column+5, "Sumber Dana", $columnTitleFormat);
$worksheet->write($row, $column+6, "Nama Obat", $columnTitleFormat);
$worksheet->write($row, $column+7, "Kategori", $columnTitleFormat);
$worksheet->write($row, $column+8, "Exp Date", $columnTitleFormat);
$worksheet->write($row, $column+9, "Qty", $columnTitleFormat);
$worksheet->write($row, $column+10, "Satuan", $columnTitleFormat);
$worksheet->write($row, $column+11, "Hrg Satuan", $columnTitleFormat);
$worksheet->write($row, $column+12, "Sub Total", $columnTitleFormat);
$worksheet->write($row, $column+13, "Disk (%)", $columnTitleFormat);
$worksheet->write($row, $column+14, "DPP", $columnTitleFormat);
$worksheet->write($row, $column+15, "PPN", $columnTitleFormat);
$worksheet->write($row, $column+16, "DPP+PPN", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;
  if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
  }
  	if ($sorting==""){
  		$sorting=$defaultsort;
	}elseif ($sorting==$defaultsort1){
		$sorting=$defaultsort;
	}
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
		WHERE a_p.TIPE_TRANS=0 AND a_p.TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'".$kep.$fcb.$fpbf.$jns.$filter.$fkategori." 
		ORDER BY ".$sorting;
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
$npbf="";
$no_terima="";
$gtsubtot=0;
$gtdpp=0;
$gtppn=0;
$gtdpp_ppn=0;
while ($rows=mysqli_fetch_array($rs)){
	if ($npbf!=$rows['PBF_NAMA']){
		if ($npbf!=""){
			$worksheet->write($row, 12, $tsubtot_perfaktur, $regularFormatRB);
			$worksheet->write($row, 14, $tdpp_perfaktur, $regularFormatRB);
			$worksheet->write($row, 15, $tppn_perfaktur, $regularFormatRB);
			$worksheet->write($row, 16, $tdpp_ppn_perfaktur, $regularFormatRB);
			$row++;

			$worksheet->write($row, 0, "", $sTotFormatR);
			$worksheet->write($row, 1, "", $sTotFormatR);
			$worksheet->write($row, 2, "", $sTotFormatR);
			$worksheet->write($row, 3, "", $sTotFormatR);
			$worksheet->write($row, 4, "", $sTotFormatR);
			$worksheet->write($row, 5, "", $sTotFormatR);
			$worksheet->write($row, 6, "", $sTotFormatR);
			$worksheet->write($row, 7, "", $sTotFormatR);
			$worksheet->write($row, 8, "", $sTotFormatR);
			$worksheet->write($row, 9, "", $sTotFormatR);
			$worksheet->write($row, 10, "", $sTotFormatR);
			$worksheet->write($row, 11, "Total ".$npbf." : ", $sTotFormatR);
			$worksheet->write($row, 12, $tsubtot, $sTotFormatR);
			$worksheet->write($row, 13, "", $sTotFormatR);
			$worksheet->write($row, 14, $tdpp, $sTotFormatR);
			$worksheet->write($row, 15, $tppn, $sTotFormatR);
			$worksheet->write($row, 16, $tdpp_ppn, $sTotFormatR);
			$gtsubtot +=$tsubtot;
			$gtdpp +=$tdpp;
			$gtppn +=$tppn;
			$gtdpp_ppn +=$tdpp_ppn;
			$row++;
			$row++;			
		}
		$worksheet->write($row, 0, $rows['PBF_NAMA'], $regularFormatLNoWrapB);
		$npbf=$rows['PBF_NAMA'];
		$i=0;
		$tsubtot=0;
		$tdpp=0;
		$tppn=0;
		$tdpp_ppn=0;
		$row++;
	}
	if ($no_terima!=$rows['NOTERIMA']){
		$i++;
		if ($i>1){
			$worksheet->write($row, 12, $tsubtot_perfaktur, $regularFormatRB);
			$worksheet->write($row, 14, $tdpp_perfaktur, $regularFormatRB);
			$worksheet->write($row, 15, $tppn_perfaktur, $regularFormatRB);
			$worksheet->write($row, 16, $tdpp_ppn_perfaktur, $regularFormatRB);
			$row++;
		}
		$tsubtot_perfaktur=0;
		$tdpp_perfaktur=0;
		$tppn_perfaktur=0;
		$tdpp_ppn_perfaktur=0;
		$no_terima=$rows['NOTERIMA'];
		$worksheet->write($row, 0, $i, $regularFormatC);
		$worksheet->write($row, 1, $rows['tgl1'], $regularFormatC);
		$worksheet->write($row, 2, $no_terima, $regularFormatC);
		$worksheet->write($row, 3, $rows['NOBUKTI'], $regularFormatC);
		$worksheet->write($row, 4, $rows['NAMA'], $regularFormatC);
	}
	$worksheet->write($row, 5, $rows['sumberdana'], $regularFormatL);
	$worksheet->write($row, 6, $rows['OBAT_NAMA'], $regularFormatL);
	$worksheet->write($row, 7, $rows['kategori'], $regularFormatC);
	$worksheet->write($row, 8, $rows['tgl2'], $regularFormatC);
	$worksheet->write($row, 9, $rows['QTY_SATUAN'], $regularFormatC);
	$worksheet->write($row, 10, $rows['SATUAN'], $regularFormatC);
	$worksheet->write($row, 11, $rows['HARGA_BELI_SATUAN'], $regularFormatR);
	$worksheet->write($row, 12, $rows['subtotal'], $regularFormatR);
	$worksheet->write($row, 13, $rows['DISKON'], $regularFormatC);
	//$dpp=$rows['subtotal']-(($rows['subtotal']*$rows['DISKON'])/100);
	$dpp=$rows['dpp'];
	$worksheet->write($row, 14, $dpp, $regularFormatR);
	//$ppn=($rows['NILAI_PAJAK']>0)?($rows['subtotal']*10/100):0;
	$ppn=$rows['ppn'];
	$worksheet->write($row, 15, $ppn, $regularFormatR);
	$dpp_ppn=$dpp+$ppn;
	$worksheet->write($row, 16, $dpp_ppn, $regularFormatR);

	$tsubtot_perfaktur +=$rows['subtotal'];
	$tdpp_perfaktur +=$dpp;
	$tppn_perfaktur +=$ppn;
	$tdpp_ppn_perfaktur +=$dpp_ppn;
	
	$tsubtot +=$rows['subtotal'];
	$tdpp +=$dpp;
	$tppn +=$ppn;
	$tdpp_ppn +=$dpp_ppn;
	$row++;
}

$worksheet->write($row, 12, $tsubtot_perfaktur, $regularFormatRB);
$worksheet->write($row, 14, $tdpp_perfaktur, $regularFormatRB);
$worksheet->write($row, 15, $tppn_perfaktur, $regularFormatRB);
$worksheet->write($row, 16, $tdpp_ppn_perfaktur, $regularFormatRB);
$row++;

$worksheet->write($row, 0, "", $sTotFormatR);
$worksheet->write($row, 1, "", $sTotFormatR);
$worksheet->write($row, 2, "", $sTotFormatR);
$worksheet->write($row, 3, "", $sTotFormatR);
$worksheet->write($row, 4, "", $sTotFormatR);
$worksheet->write($row, 5, "", $sTotFormatR);
$worksheet->write($row, 6, "", $sTotFormatR);
$worksheet->write($row, 7, "", $sTotFormatR);
$worksheet->write($row, 8, "", $sTotFormatR);
$worksheet->write($row, 9, "", $sTotFormatR);
$worksheet->write($row, 10, "", $sTotFormatR);
$worksheet->write($row, 11, "Total ".$npbf." : ", $sTotFormatR);
$worksheet->write($row, 12, $tsubtot, $sTotFormatR);
$worksheet->write($row, 13, "", $sTotFormatR);
$worksheet->write($row, 14, $tdpp, $sTotFormatR);
$worksheet->write($row, 15, $tppn, $sTotFormatR);
$worksheet->write($row, 16, $tdpp_ppn, $sTotFormatR);
$gtsubtot +=$tsubtot;
$gtdpp +=$tdpp;
$gtppn +=$tppn;
$gtdpp_ppn +=$tdpp_ppn;
$row++;
$row++;

$worksheet->write($row, 0, "", $gsTotFormatR);
$worksheet->write($row, 1, "", $gsTotFormatR);
$worksheet->write($row, 2, "", $gsTotFormatR);
$worksheet->write($row, 3, "", $gsTotFormatR);
$worksheet->write($row, 4, "", $gsTotFormatR);
$worksheet->write($row, 5, "", $gsTotFormatR);
$worksheet->write($row, 6, "", $gsTotFormatR);
$worksheet->write($row, 7, "", $gsTotFormatR);
$worksheet->write($row, 8, "", $gsTotFormatR);
$worksheet->write($row, 9, "", $gsTotFormatR);
$worksheet->write($row, 10, "", $gsTotFormatR);
$worksheet->write($row, 11, "GRAND TOTAL : ", $gsTotFormatR);
$worksheet->write($row, 12, $gtsubtot, $gsTotFormatR);
$worksheet->write($row, 13, "", $gsTotFormatR);
$worksheet->write($row, 14, $gtdpp, $gsTotFormatR);
$worksheet->write($row, 15, $gtppn, $gsTotFormatR);
$worksheet->write($row, 16, $gtdpp_ppn, $gsTotFormatR);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>
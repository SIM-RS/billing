<?php
session_start();
include("../../koneksi/konek.php");
//set_time_limit(3000000);
//==========Menangkap filter data====
$stsPas = $_REQUEST['StatusPas0'];
//if($stsPas>0) $fKso=" b_kunjungan.kso_id = '".$stsPas."' ";
$jnsLay = $_REQUEST['JnsLayananDenganInap'];
$tmpLay = $_REQUEST['TmpLayananInapSaja'];
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("G:i");

$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$waktu = $_POST['cmbWaktu'];
if($waktu == 'Harian'){
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$waktu = " AND DATE(b_kunjungan.tgl_pulang) = '$tglAwal2' ";
	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
}else if($waktu == 'Bulanan'){
	$bln = $_POST['cmbBln'];
	$thn = $_POST['cmbThn'];
	$waktu = " AND month(b_kunjungan.tgl_pulang) = '$bln' and year(b_kunjungan.tgl_pulang) = '$thn' ";
	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
}else{
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	$waktu = " AND DATE(b_kunjungan.tgl_pulang) between '$tglAwal2' and '$tglAkhir2' ";
	
	$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	$range = "BETWEEN '".$tglAwal[2]."-".$tglAwal[1]."-".$tglAwal[0]."' AND '".$tglAkhir[2]."-".$tglAkhir[1]."-".$tglAkhir[0]."'";
}

	
if($_REQUEST['TmpLayanan']!=0){
	$sqlUnit2 = "SELECT nama,inap FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	$fTmpLay = " AND p.unit_id=".$_REQUEST['TmpLayanan'];
	$inap = $rwUnit2['inap'];
}else
	$fTmpLay = " AND p.jenis_layanan=".$_REQUEST['JnsLayanan'];

	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);

if($_REQUEST['cmbKsr']!=0){
	
	$fKsr = " AND b.user_act=".$_REQUEST['cmbKsr'];
}

if($_REQUEST['StatusPas']!=0){
	$sqlKso = "SELECT id,nama from b_ms_kso where id = ".$_REQUEST['StatusPas'];
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	$fKso = " AND k.kso_id = ".$_REQUEST['StatusPas'];
}

$kasir = $_REQUEST['cmbKasir2'];
$nmKasir = $_REQUEST['nmKsr'];
$fkasir="";
if ($nmKasir!=0) $fkasir=" AND b.user_act='$nmKasir'";

$qKsr = "SELECT id, nama FROM b_ms_unit WHERE id = '".$kasir."'";
$rsKsr = mysql_query($qKsr);
$rwKsr = mysql_fetch_array($rsKsr);

$sqlKasir = "SELECT id, nama FROM b_ms_pegawai WHERE id = '".$nmKasir."'";
$rsKasir = mysql_query($sqlKasir);
$rwKasir = mysql_fetch_array($rsKasir);


$periode = $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2]." S/D ".$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
$period = "BETWEEN '$tglAwal2' AND '$tglAkhir2'";

//===============================
require_once('../Excell/Writer.php');

$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('rekap_penerimaan_kasir_rawat_inap.xls');

$worksheet=&$workbook->addWorksheet('Laporan_rekap_penerimaan');
$worksheet->setPaper("letter");

$worksheet->setMargins_LR(0.2);
$worksheet->setMargins_TB(0.2);
$columnWidth = 25;

	$worksheet->setColumn (0, 0, 5);
	$worksheet->setColumn (0, 1, 30);
	$worksheet->setColumn (2, 50, 15);


$sheetTitleFormat =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center'));
$UnitTitleFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left'));
$UnitTitleFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TLBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_LBR =& $workbook->addFormat(array('size'=>8,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TLR =& $workbook->addFormat(array('size'=>8,'top'=>1,'left'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TR =& $workbook->addFormat(array('size'=>8,'top'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_BR =& $workbook->addFormat(array('size'=>8,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>8,'align'=>'center','background-color'=>'yellow'));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center'));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left'));
$sTotFormatCF =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center','textWrap'=>1,'numFormat'=>'#,##0'));
$sTotFormatRF =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));
$regularFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1));
$regularFormatRF =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

$column = 0;
$row = 0;

$worksheet->write($row, $column, "Rumah Sakit Umum Daerah Kabupaten Sidoarjo", $UnitTitleFormat);
$row += 1;
$worksheet->write($row, $column, "Jl. Mojopahit 667 Sidoarjo", $UnitTitleFormat);
$row += 1;
$worksheet->write($row, $column, "Telepon (031) 8961649", $UnitTitleFormat);
$row += 1;
$worksheet->write($row, $column, "Sidoarjo", $UnitTitleFormat);
$row += 2;

$sql_kasir = "SELECT DISTINCT mp.id, mp.nama FROM b_bayar b
		INNER JOIN b_ms_pegawai mp ON b.user_act = mp.id
		WHERE b.kasir_id = '$kasir' $fkasir AND b.tgl $period ORDER BY mp.nama";

$kueri_kasir = mysql_query($sql_kasir);
$jml_kasir = mysql_num_rows($kueri_kasir);
$m=($jml_kasir*2)+1;

$worksheet->write($row, 1, "LAPORAN REKAPITULASI PENERIMAAN KASIR RAWAT INAP", $sheetTitleFormat);
//$worksheet->writeBlank($row, 6, $sheetTitleFormat);
//$worksheet->writeBlank($row, 7, $sheetTitleFormat);
$worksheet->mergeCells($row,1,$row,$m+2);
$row += 1;
$worksheet->write($row, 1, "PERIODE ".strtoupper($periode), $sheetTitleFormat);
$worksheet->mergeCells($row,1,$row,$m+2);
$row += 2;

$worksheet->write($row,$column,"No.",$UnitTitleFormatC);
$worksheet->write($row,$column+1,"Nama Rawat Inap.",$UnitTitleFormatC);
$worksheet->write($row,$column+2,"Nama Kasir Rawat Inap.",$UnitTitleFormatC);

$worksheet->writeBlank($row,$column+$m,$UnitTitleFormatC);
$worksheet->mergeCells($row,$column+2,$row,$column+$m);
$worksheet->write($row,$column+$m+1,"Jumlah",$UnitTitleFormatC);
$worksheet->writeBlank($row,$column+$m+2,$UnitTitleFormatC);
$worksheet->mergeCells($row,$column+$m+1,$row,$column+$m+2);
$row += 1;

$worksheet->writeBlank($row,$column,$UnitTitleFormatC);
$worksheet->mergeCells($row-1,$column,$row,$column);
$worksheet->writeBlank($row,$column+1,$UnitTitleFormatC);
$worksheet->mergeCells($row-1,$column+1,$row,$column+1);

$column = 1;
for($i=1;$i<=$jml_kasir;$i++){
	$result=mysql_fetch_array($kueri_kasir);
	$idKasir[$i]=$result['id'];
	$nama[$i]=$result['nama'];
	$subTotuang[$i]=0;
	$subTotiur[$i]=0;
	
	$column+=1;
	$worksheet->write($row,$column,$nama[$i],$UnitTitleFormatC);
	$column+=1;
	$worksheet->writeBlank($row,$column,$UnitTitleFormatC);
	$worksheet->mergeCells($row,$column-1,$row,$column);
}

$column += 1;
$worksheet->write($row,$column,"Pasien",$UnitTitleFormatC);
$worksheet->write($row,$column+1,"Uang",$UnitTitleFormatC);

$row += 1;
$column = 0;

$worksheet->writeBlank($row,$column,$UnitTitleFormatC);
$worksheet->writeBlank($row,$column+1,$UnitTitleFormatC);
$column = 1;
for($i=1;$i<=$jml_kasir;$i++){
	$column += 1;
	$worksheet->write($row,$column,"Umum",$UnitTitleFormatC);
	$column += 1;
	$worksheet->write($row,$column,"IUR",$UnitTitleFormatC);
}

$row += 1;

$sql = "SELECT DISTINCT mu.id,mu.nama FROM (SELECT * FROM b_bayar b WHERE kasir_id = '$kasir' $fkasir AND tgl $period) b
	INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id
	INNER JOIN b_tindakan t ON bt.tindakan_id = t.id
	INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id
	INNER JOIN b_ms_unit mu ON p.unit_id = mu.id 
	WHERE bt.tipe=0 AND bt.nilai>0 ORDER BY mu.nama";
$kueri = mysql_query($sql);
$no = 1;
$total = 0;$totalPx = 0;
while($poli = mysql_fetch_array($kueri)){
	$column = 0;
	$worksheet->write($row,$column,$no,$regularFormat);
	$column += 1;
	$worksheet->write($row,$column,$poli['nama'],$regularFormat);
	//$total = 0;

	//$kueri_kasir2 = mysql_query($sql_kasir);
	$stotal = 0;
	for($i=1;$i<=$jml_kasir;$i++){
		//$kas = mysql_fetch_array($kueri_kasir2);
		//bayar tindakan
		$sql = "SELECT IFNULL(SUM(IF (p.kso_id=1,bt.nilai,0)),0) AS nilai,IFNULL(SUM(IF (p.kso_id=1,0,bt.nilai)),0) AS iur FROM (SELECT * FROM b_bayar WHERE kasir_id = '$kasir' AND user_act = '".$idKasir[$i]."' AND tgl $period) b
		INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id
		INNER JOIN b_tindakan t ON bt.tindakan_id = t.id
		INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id
		INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=0 AND mu.id = '".$poli['id']."'";
		//echo $sql."<br>";
		$queri = mysql_query($sql);
		$dat = mysql_fetch_array($queri);
		$uang[$i]=$dat[0];
		$iur[$i]=$dat[1];
		//bayar kamar
		$sql = "SELECT IFNULL(SUM(IF (p.kso_id=1,bt.nilai,0)),0) AS nilai,IFNULL(SUM(IF (p.kso_id=1,0,bt.nilai)),0) AS iur FROM (SELECT * FROM b_bayar WHERE kasir_id = '$kasir' AND user_act = '".$idKasir[$i]."' AND tgl $period) b
		INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id
		INNER JOIN b_tindakan_kamar t ON bt.tindakan_id = t.id
		INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id
		INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=1 AND mu.id = '".$poli['id']."'";
		//echo $sql."<br>";
		$queri = mysql_query($sql);
		$dat = mysql_fetch_array($queri);
		$uang[$i]+=$dat[0];
		$iur[$i]+=$dat[1];
		$subTotuang[$i]+=$uang[$i];
		$subTotiur[$i]+=$iur[$i];
		$stotal += $uang[$i] + $iur[$i];
	
		$column += 1;
		$worksheet->write($row,$column,$uang[$i],$regularFormatRF);
		$column += 1;
		$worksheet->write($row,$column,$iur[$i],$regularFormatRF);
	}
	
	$total += $stotal;
	
	$sql2 = "SELECT
	  IFNULL(COUNT(DISTINCT p.kunjungan_id),0) AS jumlah
	FROM (SELECT *
		  FROM b_bayar b
		  WHERE kasir_id = '$kasir' $fkasir
			  AND tgl $period) b
	  INNER JOIN b_bayar_tindakan bt
		ON b.id = bt.bayar_id
	  INNER JOIN b_tindakan t
		ON bt.tindakan_id = t.id
	  INNER JOIN b_pelayanan p
		ON t.pelayanan_id = p.id
	  INNER JOIN b_ms_unit mu
		ON p.unit_id = mu.id
	WHERE bt.tipe=0 AND mu.id = '".$poli['id']."'";
	
	$queri2=mysql_query($sql2);
	$data2=mysql_fetch_array($queri2);
	$totalPx += $data2['jumlah'];
	
	$column += 1;
	$worksheet->write($row,$column,$data2['jumlah'],$regularFormatC);
	$column += 1;
	$worksheet->write($row,$column,$stotal,$regularFormatRF);
	
	$row += 1;
	$no++;
}

$column = 1;
$worksheet->write($row,$column,"Jumlah",$regularFormatR);
for($i=1;$i<=$jml_kasir;$i++){
	$column += 1;
	$worksheet->write($row,$column,$subTotuang[$i],$sTotFormatRF);
	$column += 1;
	$worksheet->write($row,$column,$subTotiur[$i],$sTotFormatRF);
	$subTot[$i]=$subTotuang[$i]+$subTotiur[$i];
}

$column += 1;
$worksheet->write($row,$column,$totalPx,$sTotFormatCF);
$column += 1;
$worksheet->write($row,$column,$total,$sTotFormatRF);

$row += 1;
$column = 1;
$worksheet->write($row,$column,"Sub Total (Umum + Iur)",$regularFormatR);
for($i=1;$i<=$jml_kasir;$i++){
	$column += 2;
	$worksheet->write($row,$column,$subTot[$i],$sTotFormatRF);
}

$workbook->close();
mysql_free_result($result);
mysql_close($konek);
?>
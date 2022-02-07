<?php 
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	
	$sqlUnit1 = "SELECT nama,inap FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	$inap = $rwUnit1['inap'];
	
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

$qKsr = "SELECT id, nama FROM b_ms_unit WHERE id = '".$kasir."'";
$rsKsr = mysql_query($qKsr);
$rwKsr = mysql_fetch_array($rsKsr);

$sqlKasir = "SELECT id, nama FROM b_ms_pegawai WHERE id = '".$nmKasir."'";
$rsKasir = mysql_query($sqlKasir);
$rwKasir = mysql_fetch_array($rsKasir);


$periode = $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2]." S/D ".$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
$period = "BETWEEN '$tglAwal2' AND '$tglAkhir2'";

if($_REQUEST['export']=='excel'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="Laporan_rinci.xls"');
}


//===============================
require_once('../Excell/Writer.php');

$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('RINCIAN_PENERIMAAN_KASIR_RAWAT_INAP_BERDASARKAN_AKHIR_LAYANAN.xls');

$worksheet=&$workbook->addWorksheet('Laporan_rinci');
$worksheet->setPaper("letter");

$worksheet->setMargins_LR(0.2);
$worksheet->setMargins_TB(0.2);
$columnWidth = 25;

	$worksheet->setColumn (0, 0, 5);
	$worksheet->setColumn (1, 1, 8);
	$worksheet->setColumn (2, 2, 25);
	$worksheet->setColumn (3, 4, 15);
	$worksheet->setColumn (5, 5, 25);
	$worksheet->setColumn (6, 6, 15);
	$worksheet->setColumn (7, 7, 10);
	$worksheet->setColumn (8, 8, 18);
	$worksheet->setColumn (7, 31, 10);
	$worksheet->setColumn (32, 32, 18);
	$worksheet->setColumn (33, 33, 10);
	$worksheet->setColumn (34, 34, 18);
	$worksheet->setColumn (35, 38, 12);

$sheetTitleFormat =& $workbook->addFormat(array('size'=>10,'align'=>'center'));
$UnitTitleFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left'));
$UnitTitleFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TLBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_BR =& $workbook->addFormat(array('size'=>8,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>8,'align'=>'center','bgColor'=>'red','color'=>'white','height'=>25));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center'));

$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left'));
$regularFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1));
$regularFormatRF =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

$garisAtas =& $workbook->addFormat(array('size'=>8,'align'=>'left','top'=>1));
$textBold1 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left'));
$textBold2 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center'));
$textBold3 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right'));

$textBiasa1 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'left'));
$textBiasa2 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'center'));
$textBiasa3 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'left','padding-left'=>'5'));
$textBiasa4 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'right','numFormat'=>'#,##0'));
$textBiasa5 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'right','padding-right'=>'5'));
$textBiasa6 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right','numFormat'=>'#,##0'));
$textBiasa7 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right','numFormat'=>'#,##0','top'=>1));
$textBiasa8 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'right','numFormat'=>'#,##0'));

$column = 0;
$row = 0;


$worksheet->write($row, 2, "RINCIAN PENERIMAAN KASIR RAWAT INAP", $sheetTitleFormat);
$worksheet->writeBlank($row, 3, $UnitTitleFormat);
$worksheet->writeBlank($row, 4, $UnitTitleFormat);
$worksheet->mergeCells($row,2,$row,4);
$row += 1;
$worksheet->write($row, 2, "BERDASARKAN AKHIR LAYANAN", $sheetTitleFormat);
$worksheet->writeBlank($row, 3, $UnitTitleFormat);
$worksheet->writeBlank($row, 4, $UnitTitleFormat);
$worksheet->mergeCells($row,2,$row,4);
$row += 1;
$worksheet->write($row, 2, $periode, $sheetTitleFormat);
$worksheet->writeBlank($row, 3, $UnitTitleFormat);
$worksheet->writeBlank($row, 4, $UnitTitleFormat);
$worksheet->mergeCells($row,2,$row,4);
$row += 1;


//====================Header Field====================//
$worksheet->write($row, $column, "NO", $columnTitleFormat);
$worksheet->write($row, $column+1, "", $columnTitleFormat);
$worksheet->write($row, $column+2, "URAIAN", $columnTitleFormat);
$worksheet->write($row, $column+3, "MRS", $columnTitleFormat);
$worksheet->write($row, $column+4, "KRS", $columnTitleFormat);
$worksheet->write($row, $column+5, "STATUS", $columnTitleFormat);
$worksheet->write($row, $column+6, "NILAI", $columnTitleFormat);
//$worksheet->write($row, $column+6, "NILAI", $columnTitleFormat);


	$sql_kasir = "SELECT DISTINCT
	  mp.id,
	  mp.nama
		FROM b_bayar b
	  INNER JOIN b_ms_pegawai mp
		ON b.user_act = mp.id
	WHERE b.kasir_id = '83'
		AND b.tgl $period
	ORDER BY mp.nama";
	//echo $sql_kasir;
	$kueri_kasir = mysql_query($sql_kasir);
	$jml_kasir = mysql_num_rows($kueri_kasir);
	$abjad = 'A';
while($kasir=mysql_fetch_array($kueri_kasir))
{
$tt=0;	
$worksheet->write($row+1, $column, $abjad, $textBold2);
$worksheet->write($row+1, $column+2, $kasir['nama'], $textBold1);
$row+=1;

$sql = "SELECT DISTINCT t2.unit_id id,t2.nama FROM (SELECT * FROM (SELECT p.id,p.kunjungan_id,p.unit_id, mu.nama 
FROM (SELECT * FROM b_bayar WHERE kasir_id = '83' AND user_act ='$kasir[id]' 
AND tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
INNER JOIN b_ms_unit mu ON p.unit_id = mu.id 
WHERE mu.inap = '1' AND bt.tipe=0
UNION
SELECT p.id,p.kunjungan_id,p.unit_id, mu.nama 
FROM (SELECT * FROM b_bayar WHERE kasir_id = '83' AND user_act ='$kasir[id]' 
AND tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan_kamar tk ON bt.tindakan_id = tk.id INNER JOIN b_pelayanan p ON tk.pelayanan_id = p.id 
INNER JOIN b_ms_unit mu ON p.unit_id = mu.id 
WHERE mu.inap = '1' AND bt.tipe=1) AS t ORDER BY t.kunjungan_id,t.id DESC) AS t2 GROUP BY t2.kunjungan_id";
			//echo $sql."<br>";
			$kueri = mysql_query($sql);
			$no = 1;
			while($poli=mysql_fetch_array($kueri))
			{
			$worksheet->write($row+1, $column, $no, $textBold2);
			$worksheet->write($row+1, $column+2, $poli['nama'], $textBold1);
			$row+=1;
			
			
//======MENAMPILKAN PASIEN==========
$q_pasien="SELECT mp.nama ps_nama,k.id FROM (SELECT DISTINCT t1.kunjungan_id,t1.unit_id,t1.nama 
FROM (SELECT DISTINCT p.id,p.kunjungan_id,p.unit_id, mu.nama FROM (SELECT * FROM b_bayar WHERE kasir_id = '83' AND user_act ='$kasir[id]' 
AND tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE mu.inap = '1' AND bt.tipe=0 ORDER BY p.kunjungan_id,p.id DESC) AS t1 GROUP BY t1.kunjungan_id) t2
INNER JOIN b_kunjungan k ON t2.kunjungan_id=k.id INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id
WHERE t2.unit_id='$poli[id]'";
	//echo $q_pasien."<br>";
	$sql_pasien = mysql_query($q_pasien);
	$i=1;
	$t=0;
	while($data_pasien=mysql_fetch_array($sql_pasien))
	{
		$sqlKamar="SELECT date_format(k.tgl_in,'%d-%m-%Y') tgl_in,date_format(k.tgl_out,'%d-%m-%Y') tgl_out FROM b_pelayanan p INNER JOIN b_tindakan_kamar k ON p.id=k.pelayanan_id WHERE p.kunjungan_id='".$data_pasien['id']."' ORDER BY p.id";
		$rsKamar=mysql_query($sqlKamar);
		$rwKamar=mysql_fetch_array($rsKamar);
		$mrs=$rwKamar["tgl_in"];
		$krs=$rwKamar["tgl_out"];
		while ($rwKamar=mysql_fetch_array($rsKamar)){
			$krs=$rwKamar["tgl_out"];
		}
		
		$sqlKSO="SELECT kso.nama FROM b_pelayanan p INNER JOIN b_ms_kso kso ON p.kso_id=kso.id WHERE p.kunjungan_id='".$data_pasien['id']."' AND p.unit_id='$poli[id]'";
		$rsKSO=mysql_query($sqlKSO);
		$rwKSO=mysql_fetch_array($rsKSO);
		
		$sqlBayar="SELECT IFNULL(SUM(t1.nilai),0) AS nilai 
FROM (SELECT bt.id,bt.nilai FROM (SELECT * FROM b_bayar WHERE kasir_id = '83' AND user_act ='$kasir[id]' 
AND tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
WHERE p.kunjungan_id='".$data_pasien['id']."' AND bt.tipe=0 AND bt.nilai>0
UNION
SELECT bt.id,bt.nilai FROM (SELECT * FROM b_bayar WHERE kasir_id = '83' AND user_act ='$kasir[id]' 
AND tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan_kamar t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
WHERE p.kunjungan_id='".$data_pasien['id']."' AND bt.tipe=1 AND bt.nilai>0) AS t1";
		$rsBayar=mysql_query($sqlBayar);
		$rwBayar=mysql_fetch_array($rsBayar);
		
  $worksheet->write($row+1, $column+1, $i, $textBiasa5);
  $worksheet->write($row+1, $column+2, $data_pasien['ps_nama'], $textBiasa3);
  $worksheet->write($row+1, $column+3, $mrs, $textBiasa3);
  $worksheet->write($row+1, $column+4, $krs, $textBiasa3);
  $worksheet->write($row+1, $column+5, $rwKSO['nama'], $textBiasa3);
  $worksheet->write($row+1, $column+6, $rwBayar['nilai'], $textBiasa4);
  
  $i++;
  $t += $rwBayar['nilai'];
  $tot += $rwBayar['nilai'];
  $row+=1;
  } 
  $worksheet->write($row+1, $column+7, $t, $textBiasa6);
			
			$no++;
			$tt+=$t;
			$row+=1;
			}

			$sql = "SELECT DISTINCT id,nama FROM (SELECT DISTINCT t.kunjungan_id,t.unit_id id,t.nama FROM (SELECT p.id,p.kunjungan_id,p.unit_id, mu.nama,
(SELECT DISTINCT kunjungan_id FROM b_pelayanan WHERE jenis_kunjungan=3 AND kunjungan_id=p.kunjungan_id) kunjId 
FROM (SELECT * FROM b_bayar WHERE kasir_id = '83' AND user_act ='$kasir[id]' AND tgl $period) b 
INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id INNER JOIN b_tindakan t ON bt.tindakan_id = t.id 
INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=0) AS t
WHERE t.kunjId IS NULL ORDER BY t.kunjungan_id,t.id DESC) AS t1 GROUP BY t1.kunjungan_id";
			//echo $sql."<br>";
			$kueri = mysql_query($sql);
			//$no = 1;
			while($poli=mysql_fetch_array($kueri))
			{
			$worksheet->write($row+1, $column, $no, $textBold2);
			$worksheet->write($row+1, $column+2, $poli['nama'], $textBold1);
			$row+=1;
			
			
//======MENAMPILKAN PASIEN==========
$q_pasien="SELECT mp.nama ps_nama,k.id FROM (SELECT * FROM (SELECT DISTINCT t.kunjungan_id,t.unit_id,t.nama FROM (SELECT p.id,p.kunjungan_id,p.unit_id, mu.nama,
(SELECT DISTINCT kunjungan_id FROM b_pelayanan WHERE jenis_kunjungan=3 AND kunjungan_id=p.kunjungan_id) kunjId 
FROM (SELECT * FROM b_bayar WHERE kasir_id = '83' AND user_act ='$kasir[id]' AND tgl $period) b 
INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id INNER JOIN b_tindakan t ON bt.tindakan_id = t.id 
INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=0) AS t
WHERE t.kunjId IS NULL ORDER BY t.kunjungan_id,t.id DESC) AS t1 GROUP BY t1.kunjungan_id) t2
INNER JOIN b_kunjungan k ON t2.kunjungan_id=k.id INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id
WHERE t2.unit_id='$poli[id]'";
	//echo $q_pasien."<br>";
	$sql_pasien = mysql_query($q_pasien);
	$i=1;
	$t=0;
	while($data_pasien=mysql_fetch_array($sql_pasien))
	{
		$sqlKamar="SELECT date_format(k.tgl_in,'%d-%m-%Y') tgl_in,date_format(k.tgl_out,'%d-%m-%Y') tgl_out FROM b_pelayanan p INNER JOIN b_tindakan_kamar k ON p.id=k.pelayanan_id WHERE p.kunjungan_id='".$data_pasien['id']."' ORDER BY p.id";
		$rsKamar=mysql_query($sqlKamar);
		$rwKamar=mysql_fetch_array($rsKamar);
		$mrs=$rwKamar["tgl_in"];
		$krs=$rwKamar["tgl_out"];
		while ($rwKamar=mysql_fetch_array($rsKamar)){
			$krs=$rwKamar["tgl_out"];
		}
		
		$sqlKSO="SELECT kso.nama FROM b_pelayanan p INNER JOIN b_ms_kso kso ON p.kso_id=kso.id WHERE p.kunjungan_id='".$data_pasien['id']."' AND p.unit_id='$poli[id]'";
		$rsKSO=mysql_query($sqlKSO);
		$rwKSO=mysql_fetch_array($rsKSO);
		
		$sqlBayar="SELECT IFNULL(SUM(t1.nilai),0) AS nilai 
FROM (SELECT bt.id,bt.nilai FROM (SELECT * FROM b_bayar WHERE kasir_id = '83' AND user_act ='$kasir[id]' 
AND tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
WHERE p.kunjungan_id='".$data_pasien['id']."' AND bt.tipe=0 AND bt.nilai>0) AS t1";
		$rsBayar=mysql_query($sqlBayar);
		$rwBayar=mysql_fetch_array($rsBayar);
		
  $worksheet->write($row+1, $column+1, $i, $textBiasa5);
  $worksheet->write($row+1, $column+2, $data_pasien['ps_nama'], $textBiasa3);
  $worksheet->write($row+1, $column+3, $mrs, $textBiasa3);
  $worksheet->write($row+1, $column+4, $krs, $textBiasa3);
  $worksheet->write($row+1, $column+5, $rwKSO['nama'], $textBiasa3);
  $worksheet->write($row+1, $column+6, $rwBayar['nilai'], $textBiasa4);
  
  $i++;
  $t += $rwBayar['nilai'];
  $tot += $rwBayar['nilai'];
  $row+=1;
  } 
  $worksheet->write($row+1, $column+7, $t, $textBiasa6);
			
			$no++;
			$tt+=$t;
			$row+=1;
			}

	 $worksheet->write($row+1, $column+5, "SubTotal : ", $textBold3);
	 $worksheet->write($row+1, $column+7, $tt, $textBiasa7);
	 $row+=1;
	
$abjad++;
$row+= 1;
}
$row+= 1;
$worksheet->write($row, $column+5, "Total :", $textBold3);
$worksheet->write($row, $column+6, "", $textBiasa7);
$worksheet->write($row, $column+7, $tot, $textBiasa7);


$row+= 4;
$xx = "Tgl Cetak : $date_now Jam : $jam";
$worksheet->write($row, $column+5, $xx, $textBiasa8);
$worksheet->writeBlank($row, $column+6, $UnitTitleFormat);
$worksheet->writeBlank($row, $column+7, $UnitTitleFormat);
$worksheet->mergeCells($row,$column+5,$row,$column+7);

$row+= 1;
$worksheet->write($row, $column+5, "Yang Mencetak", $textBiasa8);
$worksheet->writeBlank($row, $column+6, $UnitTitleFormat);
$worksheet->writeBlank($row, $column+7, $UnitTitleFormat);
$worksheet->mergeCells($row,$column+5,$row,$column+7);

$row+= 5;
$worksheet->write($row, $column+5, $rwPeg['nama'], $textBiasa6);
$worksheet->writeBlank($row, $column+6, $UnitTitleFormat);
$worksheet->writeBlank($row, $column+7, $UnitTitleFormat);
$worksheet->mergeCells($row,$column+5,$row,$column+7);


$workbook->close();
mysql_free_result($rsPenjamin);
mysql_free_result($rsTmp);
mysql_close($konek);
?>
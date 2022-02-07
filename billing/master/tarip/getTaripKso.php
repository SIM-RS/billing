<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
require_once('Excell/Writer.php');

$idKso = $_REQUEST['kso'];
$idUnit = $_REQUEST['cmbUnitKelMcu'];

$sqlTindakan = mysql_query("SELECT id,nama FROM b_ms_tindakan ORDER BY nama ASC");
$sqlKso = mysql_fetch_assoc(mysql_query("SELECT id,nama FROM b_ms_kso WHERE id = {$idKso}"));
$sqlTempatLayanan = mysql_fetch_assoc(mysql_query("SELECT id,nama FROM b_ms_unit WHERE id = {$idUnit}"));
$banyak = mysql_num_rows($sqlTindakan);
$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('Tarif Export Kso Tempat Layanan.xls');
$worksheet = &$workbook->addWorksheet('Lab Pcr');
$worksheet->setLandscape();
$columnWidth = 10;
$sheetTitleFormat = &$workbook->addFormat(array('size' => 14, 'align' => 'center'));
$columnTitleFormat = &$workbook->addFormat(array('bold' => 1,'size' => 9, 'vAlign' => 'vcenter','align'=>'center','fontFamily'=>'Calibri','border'=>1));
$sTotFormatC = &$workbook->addFormat(array('bold' => 1, 'size' => 10, 'align' => 'center', 'fgcolor' => 'grey', 'pattern' => 1));
$sTotFormatR = &$workbook->addFormat(array('bold' => 1, 'size' => 10, 'align' => 'right', 'fgcolor' => 'grey', 'pattern' => 1));
$sTotFormatL = &$workbook->addFormat(array('bold' => 1, 'size' => 10, 'align' => 'left', 'fgcolor' => 'grey', 'pattern' => 1));
$regularFormat = &$workbook->addFormat(array('size' => 9, 'align' => 'left','fontFamily'=>'Calibri','border'=>1,'vAlign' => 'vcenter'));
$regularFormatC = &$workbook->addFormat(array('size' => 9, 'align' => 'center','border'=>1,'fontFamily'=>'Calibri','vAlign' => 'vcenter'));
$regularFormatCB = &$workbook->addFormat(array('size' => 9, 'align' => 'center','fontFamily'=>'Calibri','vAlign' => 'vcenter'));
$regularFormatR = &$workbook->addFormat(array('size' => 9, 'align' => 'center', 'textWrap' => 1,'border'=>1));
$regularFormatL = &$workbook->addFormat(array('size' => 9, 'align' => 'left',));

$regularFormatRF = &$workbook->addFormat(array('size' => 9, 'align' => 'right', 'textWrap' => 1, 'numFormat' => '#,##0'));
$column = 0;
$row    = 0;
$worksheet->write($row, $column++, "ID Tindakan", $columnTitleFormat);
$worksheet->write($row, $column++, "Nama Tindakan", $columnTitleFormat);
$worksheet->write($row, $column++, "ID Kso", $columnTitleFormat);
$worksheet->write($row, $column++, "Nama Kso", $columnTitleFormat);
$worksheet->write($row, $column++, "ID Tempat Layanan", $columnTitleFormat);
$worksheet->write($row, $column++, "Nama Tempat Layanan", $columnTitleFormat);
$sqlKelas = "SELECT id,nama FROM b_ms_kelas";
$queryKelas = mysql_query($sqlKelas);
while($rows = mysql_fetch_assoc($queryKelas)){
    $worksheet->write($row, $column, $rows['id'], $columnTitleFormat);
    for($i = 1; $i <= $banyak; $i++){
        $worksheet->write($row + $i, $column, $rows['id'], $regularFormat);
    }
    $column++;
    $worksheet->write($row, $column++, $rows['nama'], $columnTitleFormat);
}

$row = 1;
$column = 0;
while($rows = mysql_fetch_assoc($sqlTindakan)){
    $worksheet->write($row, $column++, $rows['id'], $regularFormat);
    $worksheet->write($row, $column++, $rows['nama'], $regularFormat);
    $worksheet->write($row, $column++, $sqlKso['id'], $regularFormat);
    $worksheet->write($row, $column++, $sqlKso['nama'], $regularFormat);
    $worksheet->write($row, $column++, $sqlTempatLayanan['id'], $regularFormat);
    $worksheet->write($row, $column++, $sqlTempatLayanan['nama'], $regularFormat);
    $column = 0;
    $row++;
}
$workbook->close();
?>
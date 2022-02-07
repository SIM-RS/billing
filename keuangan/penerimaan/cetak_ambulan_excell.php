<?php
	include('../sesi.php');
	$tgl=gmdate('d-m-Y',mktime(date('H')+7));
	include("../koneksi/konek.php");
	require_once('../Excell/Writer.php');
	
	$bln = ($_REQUEST['bln']!='')?$_REQUEST['bln']:$_REQUEST['cmbBln'];
	$thn = ($_REQUEST['thn']!='')?$_REQUEST['thn']:$_REQUEST['cmbThn'];
	$arrBln = array('1'=>'Januari','2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	
	$fwaktu = "AND MONTH(a.tgl_setor) = '$bln' AND YEAR(a.tgl_setor) = '$thn' ";
	$defaultsort = "a.tgl ASC";
	//Creating a workbook
	$workbook = new Spreadsheet_Excel_Writer();

	//Sending HTTP headers
	$workbook->send('Laporan Penerimaan Ambulan.xls');

	//Creating a worksheet
	$worksheet=&$workbook->addWorksheet('Laporan Penerimaan Ambulan');
	$worksheet->setLandscape();

	//set all columns same width
	$columnWidth = 15;
	$worksheet->setColumn (0, 1, 15);
	$worksheet->setColumn (2, 3, 20);
	$worksheet->setColumn (4, 4, 40);
	$worksheet->setColumn (5, 6, 25);
	//$worksheet->setColumn (0, $numColumns, $columnWidth);
	 
	//Setup different styles
	$sheetTitleFormat =& $workbook->addFormat(array('size'=>12));
	$sheetTitleFormatC =& $workbook->addFormat(array('size'=>12,'align'=>'center'));
	$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>11,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
	$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
	$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'grey','pattern'=>1,'numFormat'=>'#,##0.00'));
	$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'grey','pattern'=>1));
	$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1));
	$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','textWrap'=>1));
	$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0.00'));
	$regularFormatI =& $workbook->addFormat(array('italic'=>1,'size'=>9,'align'=>'left','textWrap'=>1));
	$sTotTitleL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left'));
	$sTotTitleC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center'));
	$sTotTitleR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','numFormat'=>'#,##0.00'));

	/*Speadsheet writer is in format y,x (row, column)
	 *  column1  |  column2 |  column3
	 *   (0,0)      (0,1)      (0,2) */

	$column = 0;
	$row    = 0;

	$title4="( ".$arrBln[$bln]."  {$thn} )";
	//Write sheet title in upper left cell
	$worksheet->write($row, 3, "", $sheetTitleFormatC);
	$row += 1;
	$worksheet->write($row, 3, $namaRS, $sheetTitleFormatC);
	$row += 1;
	$worksheet->write($row, 3, "LAPORAN PENERIMAAN AMBULAN", $sheetTitleFormatC);
	$row += 1;
	$worksheet->write($row, 3, "$title4", $sheetTitleFormatC);
	//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
	$row += 1;
	$worksheet->write($row, $column, "NO.URUT", $columnTitleFormat);
	$worksheet->write($row, $column+1, "TANGGAL PELAYANAN", $columnTitleFormat);
	$worksheet->write($row, $column+2, "TANGGAL SETOR", $columnTitleFormat);
	$worksheet->write($row, $column+3, "JAM", $columnTitleFormat);
	$worksheet->write($row, $column+4, "TIPE AMBULAN", $columnTitleFormat);
	$worksheet->write($row, $column+5, "NO BUKTI", $columnTitleFormat);
	$worksheet->write($row, $column+6, "NILAI (Rp.)", $columnTitleFormat);
	$worksheet->write($row, $column+7, "PETUGAS", $columnTitleFormat);
	$row += 1;

	$i=1;
	$sql = "SELECT DATE_FORMAT(a.tgl,'%d-%m-%Y') tgl, DATE_FORMAT(a.tgl_setor,'%d-%m-%Y') tgl_setor, DATE_FORMAT(a.tgl_setor,'%H:%i') jam_setor,
				   IF(a.ambulan_tipe = 0, 'Jenazah', 'Rescue') nama, a.no_bukti, a.nilai, u.username
			FROM k_ambulan a
			INNER JOIN k_ms_user u
			   ON u.id = a.user_act
			WHERE 0 = 0 {$fwaktu}
			ORDER BY {$defaultsort}";
	echo $sql;
	$q = mysql_query($sql);
	$total = 0;
	while($d = mysql_fetch_array($q))
	{
		$total += $d['nilai'];

		$worksheet->write($row, 0, $i, $regularFormatC);
		$worksheet->write($row, 1, $d['tgl'], $regularFormatC);
		$worksheet->write($row, 2, $d['tgl_setor'], $regularFormatC);
		$worksheet->write($row, 3, $d['jam_setor'], $regularFormatC);
		$worksheet->write($row, 4, $d['nama'], $regularFormatL);
		$worksheet->write($row, 5, $d['no_bukti'], $regularFormatR);
		$worksheet->write($row, 6, $d['nilai'], $regularFormatR);
		$worksheet->write($row, 7, $d['username'], $regularFormatR);
		$i++;
		$row += 1;
	}
	$worksheet->write($row, 0, '', $regularFormatC);
	$worksheet->write($row, 1, '', $regularFormatC);
	$worksheet->write($row, 2, '', $regularFormatC);
	$worksheet->write($row, 3, '', $regularFormatC);
	$worksheet->write($row, 4, '', $regularFormatL);
	$worksheet->write($row, 5, '', $regularFormatR);
	$worksheet->write($row, 6, 'TOTAL', $regularFormatR);
	$worksheet->write($row, 7, "SUM(H6:".($row-1).")", $regularFormatR);
	$workbook->close();
?>
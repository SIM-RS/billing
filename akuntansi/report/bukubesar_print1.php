<?php 
// Koneksi =================================
include "../sesi.php";
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//===============================
$idma=$_REQUEST['idma'];if ($idma=="") $idma="0";
$ccrvpbfumum=$_REQUEST['ccrvpbfumum'];if ($ccrvpbfumum=="") $ccrvpbfumum="0";
$idccrvpbfumum=$_REQUEST['idccrvpbfumum'];if ($idccrvpbfumum=="") $idccrvpbfumum="0";
$cc_islast=$_REQUEST['cc_islast'];if ($cc_islast=="") $cc_islast="0";
$kode_ma=$_REQUEST['kode_ma'];
$cislast=$_REQUEST['cislast'];if ($cislast=="") $cislast="1";
$all_unit=$_REQUEST['all_unit'];if ($all_unit=="") $all_unit="0";
$ta=$_REQUEST['ta'];
$bulan=explode("|",$_REQUEST['bulan']);
$idunit=explode("|",$_REQUEST['idunit']);
$tgl1="01/".(($bulan[0]<10)?"0".$bulan[0]:$bulan[0])."/".$ta;

$ma=$_REQUEST['ma'];
$sql="select * from ma_sak where ma_id=$idma";
$rs1=mysql_query($sql);
if ($rows=mysql_fetch_array($rs1)){
	$kode_ma=$rows["MA_KODE"];
	$ma=trim($rows["MA_NAMA"]);
	$ckso_type=$rows["MA_TYPE"];
}
$saldoawal=0;
if ($idccrvpbfumum!="0"){
	switch ($ccrvpbfumum){
		case 1:
			$sql="SELECT * FROM ak_ms_unit WHERE id='$idccrvpbfumum'";
			//echo $sql."<br>";
	
			$rscc=mysql_query($sql);
			if ($rows=mysql_fetch_array($rscc)){
				$kode_cc=$rows["kode"];
				$kode_ma.=$kode_cc;
				$ma=trim($rows["nama"]);
				$sql="SELECT IFNULL(SUM(SALDO_AWAL),0) AS SALDO_AWAL FROM saldo s INNER JOIN ma_sak ma ON s.FK_MAID=ma.MA_ID INNER JOIN ak_ms_unit mu ON s.CC_RV_KSO_PBF_UMUM_ID=mu.id WHERE s.bulan=$bulan[0] AND s.tahun=$ta AND s.FK_MAID=$idma AND mu.kode LIKE '$kode_cc%'";
				$rs1=mysql_query($sql);
				if ($rows1=mysql_fetch_array($rs1)){
					$saldoawal=$rows1['SALDO_AWAL'];
				}
			}
			break;
		case 2:
			$sql="SELECT kode_ak kode,nama FROM $dbbilling.b_ms_kso WHERE id='$idccrvpbfumum'";
			//echo $sql."<br>";
			$rscc=mysql_query($sql);
			if ($rows=mysql_fetch_array($rscc)){
				$kode_cc=$rows["kode"];
				$kode_ma.=$kode_cc;
				$ma=trim($rows["nama"]);
				$sql="SELECT IFNULL(SUM(SALDO_AWAL),0) AS SALDO_AWAL FROM saldo s INNER JOIN ma_sak ma ON s.FK_MAID=ma.MA_ID INNER JOIN $dbbilling.b_ms_kso mu ON s.CC_RV_KSO_PBF_UMUM_ID=mu.id WHERE s.bulan=$bulan[0] AND s.tahun=$ta AND s.FK_MAID=$idma AND mu.id='$idccrvpbfumum'";
				$rs1=mysql_query($sql);
				if ($rows1=mysql_fetch_array($rs1)){
					$saldoawal=$rows1['SALDO_AWAL'];
				}
			}
			break;
		case 3:
			$sql="SELECT PBF_KODE_AK kode,PBF_NAMA nama FROM $dbapotek.a_pbf WHERE PBF_ID='$idccrvpbfumum'";
			//echo $sql."<br>";
			$rscc=mysql_query($sql);
			if ($rows=mysql_fetch_array($rscc)){
				$kode_cc=$rows["kode"];
				$kode_ma.=$kode_cc;
				$ma=trim($rows["nama"]);
				$sql="SELECT IFNULL(SUM(SALDO_AWAL),0) AS SALDO_AWAL FROM saldo s INNER JOIN ma_sak ma ON s.FK_MAID=ma.MA_ID INNER JOIN $dbapotek.a_pbf mu ON s.CC_RV_KSO_PBF_UMUM_ID=mu.PBF_ID WHERE s.bulan=$bulan[0] AND s.tahun=$ta AND s.FK_MAID=$idma AND mu.PBF_ID='$idccrvpbfumum'";
				$rs1=mysql_query($sql);
				if ($rows1=mysql_fetch_array($rs1)){
					$saldoawal=$rows1['SALDO_AWAL'];
				}
			}
			break;
		case 4:
			$sql="SELECT koderekanan kode,namarekanan nama FROM $dbaset.as_ms_rekanan WHERE idrekanan='$idccrvpbfumum'";
			//echo $sql."<br>";
			$rscc=mysql_query($sql);
			if ($rows=mysql_fetch_array($rscc)){
				$kode_cc=$rows["kode"];
				$kode_ma.=$kode_cc;
				$ma=trim($rows["nama"]);
				$sql="SELECT IFNULL(SUM(SALDO_AWAL),0) AS SALDO_AWAL FROM saldo s INNER JOIN ma_sak ma ON s.FK_MAID=ma.MA_ID INNER JOIN $dbaset.as_ms_rekanan mu ON s.CC_RV_KSO_PBF_UMUM_ID=mu.idrekanan WHERE s.bulan=$bulan[0] AND s.tahun=$ta AND s.FK_MAID=$idma AND mu.idrekanan='$idccrvpbfumum'";
				//echo $sql."<br>";
				$rs1=mysql_query($sql);
				if ($rows1=mysql_fetch_array($rs1)){
					$saldoawal=$rows1['SALDO_AWAL'];
				}
			}
			break;
	}
}else{
	$sql="SELECT IFNULL(SUM(SALDO_AWAL),0) AS SALDO_AWAL FROM saldo INNER JOIN ma_sak ON FK_MAID=MA_ID WHERE bulan=$bulan[0] AND tahun=$ta AND MA_KODE LIKE '$kode_ma%'";
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	if ($rows=mysql_fetch_array($rs)){
		$saldoawal=$rows['SALDO_AWAL'];
	}
}

$tot=0;
$stotd=0;
$stotk=0;
$totd=0;
$totk=0;

require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();
//Sending HTTP headers
$workbook->send('Buku_Besar_'.$bulan[0].'-'.$ta.'_'.$kode_ma.'.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet($kode_ma);
//Set a paper
$worksheet->setPaper(5);
//$worksheet->setLandscape();
$worksheet->setMargins_LR(0.25);
$worksheet->setMargins_TB(0.25);
//set all columns same width
$columnWidth = 10;

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>11,'align'=>'left'));
$UnitTitleFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left'));
$UnitTitleFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TLBR =& $workbook->addFormat(array('size'=>9,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TBR =& $workbook->addFormat(array('size'=>9,'top'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_BR =& $workbook->addFormat(array('size'=>9,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1,'textWrap'=>1,'vAlign'=>'vcenter'));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'grey','pattern'=>1));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'grey','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1));
$regularFormatRF =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0.00##'));
$regularFormatF =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1,'numFormat'=>'#0'));

$column = 0;
$row    = 0;

//$row=0;

if (($cislast=="1" && $ccrvpbfumum=="0") || ($cc_islast=="1" && $ccrvpbfumum!="0")){
	//Write sheet title in upper left cell
	$worksheet->write($row, 0, "SISTEM KEUANGAN ".$namaRS, $sheetTitleFormat);
	$row += 1;
	$worksheet->write($row, 0, "LAPORAN", $sheetTitleFormat);
	$worksheet->write($row, 3, ": BUKU BESAR ".strtoupper($bulan[1])." ".$ta, $sheetTitleFormat);
	$row += 1;
	$worksheet->write($row, 0, "KODE REKENING", $sheetTitleFormat);
	$worksheet->write($row, 3, ": ".$kode_ma." - ".$ma, $sheetTitleFormat);
	$row += 1;
	//Write each datapoint to the sheet starting one row beneath
	$worksheet->setColumn (0, 0, 3);
	$worksheet->setColumn (1, 1, 10);
	$worksheet->setColumn (2, 2, 11);
	$worksheet->setColumn (3, 3, 40);
	$worksheet->setColumn (4, 5, 15);
	//$worksheet->setColumn (0, $numColumns, $columnWidth);
	$worksheet->write($row, 0, "No", $columnTitleFormat);
	$worksheet->write($row, 1, "Tgl", $columnTitleFormat);
	$worksheet->write($row, 2, "No. Bukti", $columnTitleFormat);
	$worksheet->write($row, 3, "Uraian", $columnTitleFormat);
	$worksheet->write($row, 4, "Debit", $columnTitleFormat);
	$worksheet->write($row, 5, "Kredit", $columnTitleFormat);
	$row++;
	
	$worksheet->write($row, 0, 1, $regularFormatC);
	$worksheet->write($row, 1, $tgl1, $regularFormatC);
	$worksheet->write($row, 2, "-", $regularFormatC);
	$worksheet->write($row, 3, "Saldo Awal", $regularFormat);
	$worksheet->write($row, 4, ($saldoawal>0)?$saldoawal:0, $regularFormatRF);
	$worksheet->write($row, 5, ($saldoawal>0)?0:($saldoawal * -1), $regularFormatRF);
	$row++;

	if ($ccrvpbfumum=="0"){
		$strSQL="Select ma_sak.MA_ID, ma_sak.MA_KODE, ma_sak.MA_NAMA,ma_sak.MA_PARENT,1 as MA_ISLAST,date_format(TGL,'%d/%m/%Y') as tgl1,j.TR_ID,j.NO_TRANS,j.TGL,j.NO_KW,j.URAIAN,j.DEBIT,j.KREDIT,j.D_K From jurnal j Inner Join ma_sak ON j.FK_SAK = ma_sak.MA_ID where MA_ID = $idma and month(tgl)=$bulan[0] and year(tgl)=$ta order by TGL,TR_ID";
	}else{
		$strSQL="Select ma_sak.MA_ID, ma_sak.MA_KODE, ma_sak.MA_NAMA,ma_sak.MA_PARENT,1 as MA_ISLAST,date_format(TGL,'%d/%m/%Y') as tgl1,j.TR_ID,j.NO_TRANS,j.TGL,j.NO_KW,j.URAIAN,j.DEBIT,j.KREDIT,j.D_K From jurnal j Inner Join ma_sak ON j.FK_SAK = ma_sak.MA_ID where MA_ID = $idma AND j.CC_RV_KSO_PBF_UMUM_ID='$idccrvpbfumum' and month(tgl)=$bulan[0] and year(tgl)=$ta order by TGL,TR_ID";
	}
	//echo $strSQL."<br>";
	$rs = mysql_query($strSQL);
	$i=2;
	$xStart=$row+1;
	while ($rows=mysql_fetch_array($rs)){
		$makode=$rows["MA_KODE"];
		$uraian=$rows['URAIAN'];
		$cparent=$rows['MA_PARENT'];
		$worksheet->write($row, 0, $i, $regularFormatC);
		$worksheet->write($row, 1, $rows['tgl1'], $regularFormatC);
		$worksheet->write($row, 2, $rows['NO_KW'], $regularFormatC);
		$worksheet->write($row, 3, $uraian, $regularFormat);
		$worksheet->write($row, 4, $rows['DEBIT'], $regularFormatRF);
		$worksheet->write($row, 5, $rows['KREDIT'], $regularFormatRF);

		$stotd+=$rows['DEBIT'];
		$stotk+=$rows['KREDIT'];

		$row++;
		$i++;
	}
	
	$tot=$saldoawal+$stotd-$stotk;
	if ($tot>0){
		$totd=$tot;
	}else{
		$totk=$tot * (-1);
	}

	if ($i>2){
		$worksheet->write($row, 3, "Sub Total", $regularFormatR);
		$worksheet->write($row, 4, '=Sum(E'.$xStart.':E'.$row.')', $regularFormatRF);
		$worksheet->write($row, 5, '=Sum(F'.$xStart.':F'.$row.')', $regularFormatRF);
	}else{
		$worksheet->write($row, 3, "Sub Total", $regularFormatR);
		$worksheet->write($row, 4, 0, $regularFormatRF);
		$worksheet->write($row, 5, 0, $regularFormatRF);
	}
	$row++;
	
	$worksheet->write($row, 3, "Saldo Akhir", $regularFormatR);
	$worksheet->write($row, 4, (($totd>0)?'=E'.($xStart-1).'-F'.($xStart-1).'+E'.$row.'-F'.$row:(($totd==0)?0:"")), $regularFormatRF);
	$worksheet->write($row, 5, (($totk>0)?'=F'.($xStart-1).'-E'.($xStart-1).'+F'.$row.'-E'.$row:""), $regularFormatRF);
	//$worksheet->write($row, 4, (($totd>0)?$totd:(($totd==0)?0:"")), $regularFormatRF);
	//$worksheet->write($row, 5, (($totk>0)?$totk:""), $regularFormatRF);
}else{
	//Write sheet title in upper left cell
	$worksheet->write($row, 0, "SISTEM KEUANGAN ".$namaRS, $sheetTitleFormat);
	$row += 1;
	$worksheet->write($row, 0, "LAPORAN", $sheetTitleFormat);
	$worksheet->write($row, 2, ": BUKU BESAR ".strtoupper($bulan[1])." ".$ta, $sheetTitleFormat);
	$row += 1;
	$worksheet->write($row, 0, "KODE REKENING", $sheetTitleFormat);
	$worksheet->write($row, 2, ": ".$kode_ma." - ".$ma, $sheetTitleFormat);
	$row += 1;
	//Write each datapoint to the sheet starting one row beneath
	$worksheet->setColumn (0, 0, 4);
	$worksheet->setColumn (1, 1, 16);
	$worksheet->setColumn (2, 2, 50);
	$worksheet->setColumn (3, 4, 15);
	$worksheet->write($row, 0, "No", $columnTitleFormat);
	$worksheet->write($row, 1, "Kode Akun", $columnTitleFormat);
	$worksheet->write($row, 2, "Nama Akun", $columnTitleFormat);
	$worksheet->write($row, 3, "Debit", $columnTitleFormat);
	$worksheet->write($row, 4, "Kredit", $columnTitleFormat);
	$row++;

	$worksheet->write($row, 0, 1, $regularFormatC);
	$worksheet->write($row, 1, "-", $regularFormatC);
	$worksheet->write($row, 2, "Saldo Awal", $regularFormat);
	$worksheet->write($row, 3, ($saldoawal>0)?$saldoawal:0, $regularFormatRF);
	$worksheet->write($row, 4, ($saldoawal>0)?0:($saldoawal * -1), $regularFormatRF);
	$row++;

	if ($ccrvpbfumum=="0"){
		$strSQL="select * from ma_sak where MA_PARENT=$idma order by MA_KODE";
	}else{
		switch($ccrvpbfumum){
			case 1:
				//$strSQL="SELECT * FROM ak_ms_unit WHERE parent_id='$idccrvpbfumum' ORDER BY kode";
				if (substr($kode_ma,0,1)=="4"){
					$strSQL="SELECT * FROM ak_ms_unit WHERE parent_id='$idccrvpbfumum' AND LEFT(kode,2)<>'08' ORDER BY kode";
				}else{
					$strSQL="SELECT * FROM ak_ms_unit WHERE parent_id='$idccrvpbfumum' ORDER BY kode";
				}
				break;
			case 2:
				$ckso_filter=" AND type=0";
				if ($ckso_type==1){
					$ckso_filter=" AND type=1";
				}
				$strSQL="SELECT * FROM $dbbilling.b_ms_kso WHERE id>1".$ckso_filter." ORDER BY kode_ak";
				break;
			case 3:
				$strSQL="SELECT * FROM $dbapotek.a_pbf ORDER BY PBF_KODE_AK";
				break;
			case 4:
				$strSQL="SELECT * FROM $dbaset.as_ms_rekanan ORDER BY koderekanan";
				break;
		}
   }
	$rs = mysql_query($strSQL);
	//echo $strSQL."<br>";
	$i=2;
	$xStart=$row+1;
	while ($rows=mysql_fetch_array($rs)){
		$cdebit=0;
		$ckredit=0;
		if ($ccrvpbfumum=="0"){
			$ckode=$rows['MA_KODE'];
			$cid=$rows['MA_ID'];
			$cislast=$rows['MA_ISLAST'];
			$tccrvpbfumum=$rows['CC_RV_KSO_PBF_UMUM'];
			$dkode=$ckode;
			$dma=$rows['MA_NAMA'];
			$cc_islast=0;
			$sql="select if (sum(DEBIT) is null,0,sum(DEBIT)) as DEBIT,if (sum(KREDIT) is null,0,sum(KREDIT)) as KREDIT from jurnal inner join ma_sak on FK_SAK=MA_ID where MA_KODE like '$ckode%' and month(TGL)=$bulan[0] and year(TGL)=$ta";
			$rs1=mysql_query($sql);
			if ($rows1=mysql_fetch_array($rs1)){
				$cdebit=$rows1['DEBIT'];
				$ckredit=$rows1['KREDIT'];
			}
		}else{				
			$ckode=$kode_ma;
			$cid=$idma;
			$cislast=1;
			switch($ccrvpbfumum){
				case 1:
					$idccrvpbfumum=$rows['id'];
					$dkode=$kode_ma.$rows['kode'];
					$dma=$rows['nama'];
					$cc_islast=$rows['islast'];
					$sql="select if (sum(DEBIT) is null,0,sum(DEBIT)) as DEBIT,if (sum(KREDIT) is null,0,sum(KREDIT)) as KREDIT FROM jurnal j INNER JOIN ma_sak ON FK_SAK=MA_ID INNER JOIN ak_ms_unit mu ON j.CC_RV_KSO_PBF_UMUM_ID=mu.id where MA_ID='$idma' AND mu.kode LIKE '".$rows['kode']."%' and month(TGL)=$bulan[0] and year(TGL)=$ta";
					break;
				case 2:
					$idccrvpbfumum=$rows['id'];
					$dkode=$kode_ma.$rows['kode_ak'];
					$dma=$rows['nama'];
					$cc_islast=1;
					$sql="select if (sum(DEBIT) is null,0,sum(DEBIT)) as DEBIT,if (sum(KREDIT) is null,0,sum(KREDIT)) as KREDIT FROM jurnal j INNER JOIN ma_sak ON FK_SAK=MA_ID where MA_ID='$idma' AND j.CC_RV_KSO_PBF_UMUM_ID='".$idccrvpbfumum."' and month(TGL)=$bulan[0] and year(TGL)=$ta";
					break;
				case 3:
					$idccrvpbfumum=$rows['PBF_ID'];
					$dkode=$kode_ma.$rows['PBF_KODE_AK'];
					$dma=$rows['PBF_NAMA'];
					$cc_islast=1;
					$sql="select if (sum(DEBIT) is null,0,sum(DEBIT)) as DEBIT,if (sum(KREDIT) is null,0,sum(KREDIT)) as KREDIT FROM jurnal j INNER JOIN ma_sak ON FK_SAK=MA_ID where MA_ID='$idma' AND j.CC_RV_KSO_PBF_UMUM_ID='".$idccrvpbfumum."' and month(TGL)=$bulan[0] and year(TGL)=$ta";
					break;
				case 4:
					$idccrvpbfumum=$rows['idrekanan'];
					$dkode=$kode_ma.$rows['koderekanan'];
					$dma=$rows['namarekanan'];
					$cc_islast=1;
					$sql="select if (sum(DEBIT) is null,0,sum(DEBIT)) as DEBIT,if (sum(KREDIT) is null,0,sum(KREDIT)) as KREDIT FROM jurnal j INNER JOIN ma_sak ON FK_SAK=MA_ID where MA_ID='$idma' AND j.CC_RV_KSO_PBF_UMUM_ID='".$idccrvpbfumum."' and month(TGL)=$bulan[0] and year(TGL)=$ta";
					break;
			}
			//echo $sql."<br>";
			$rs1=mysql_query($sql);
			if ($rows1=mysql_fetch_array($rs1)){
				$cdebit=$rows1['DEBIT'];
				$ckredit=$rows1['KREDIT'];
			}
		}
		$stotd+=$cdebit;
		$stotk+=$ckredit;
		
		$worksheet->write($row, 0, $i, $regularFormatC);
		$worksheet->write($row, 1, "'".$dkode, $regularFormatC);
		$worksheet->write($row, 2, $dma, $regularFormat);
		$worksheet->write($row, 3, $cdebit, $regularFormatRF);
		$worksheet->write($row, 4, $ckredit, $regularFormatRF);
		$row++;
		$i++;
	}
	
	$tot=$saldoawal+$stotd-$stotk;
	if ($tot>0){
		$totd=$tot;
	}else{
		$totk=$tot * (-1);
	}

	$worksheet->write($row, 2, "Sub Total", $regularFormatR);
	$worksheet->write($row, 3, '=Sum(D'.$xStart.':D'.$row.')', $regularFormatRF);
	$worksheet->write($row, 4, '=Sum(E'.$xStart.':E'.$row.')', $regularFormatRF);
	$row++;
	
	$worksheet->write($row, 2, "Saldo Akhir", $regularFormatR);
	$worksheet->write($row, 3, (($totd>0)?'=D'.($xStart-1).'-E'.($xStart-1).'+D'.$row.'-E'.$row:(($totd==0)?0:"")), $regularFormatRF);
	$worksheet->write($row, 4, (($totk>0)?'=E'.($xStart-1).'-D'.($xStart-1).'+E'.$row.'-D'.$row:""), $regularFormatRF);
	//$worksheet->write($row, 3, (($totd>0)?$totd:(($totd==0)?0:"")), $regularFormatRF);
	//$worksheet->write($row, 4, (($totk>0)?$totk:""), $regularFormatRF);
}

$workbook->close();
mysql_free_result($rs);
mysql_close($konek);
?>
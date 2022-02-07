<?php 
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$kso = $_REQUEST['kso'];
$kson = $_REQUEST['kson'];
if ($kso=="0") $kson="SEMUA";
$ckso = $kso;
$tipe=$_REQUEST['tipe'];
$tipePend=$_REQUEST['tipePend'];
$bayar=$_REQUEST['bayar'];
$unit_id=$_REQUEST['unit_id'];
$unitN=$_REQUEST['unitN'];
$jenis_layananN=$_REQUEST['jenis_layananN'];
$unit_id=$_REQUEST['unit_id'];
$inap=$_REQUEST['inap'];
$tgl_d=tglSQL($_REQUEST['tgl_d']);
$waktu = " and t.tgl = '$tgl_d' ";
if($tipePend==1){
    $fTipe = "AND t.tipe_pendapatan = '1' ";
    $fTipe2 = "AND tk.tipe_pendapatan = '1' ";
	$wkbook="Pengurang_";
	$wksheet="Pengurang Billing";
	if ($bayar==1){
		$fbayar=" AND t.bayar_pasien>0";
		$fbayar2=" AND tk.bayar_pasien>0";
		$captionRpt="LAPORAN PENGURANG PENDAPATAN SUDAH TERBAYAR";
	}else{
		$fbayar=" AND t.bayar_pasien=0";
		$fbayar2=" AND tk.bayar_pasien=0";
		$captionRpt="LAPORAN PENGURANG PENDAPATAN BELUM TERBAYAR";
	}
}else{
    $fTipe = "AND t.tipe_pendapatan = '0' ";
    $fTipe2 = "AND tk.tipe_pendapatan = '0' ";
	$fbayar="";
	$fbayar2="";
	$wkbook="Pendapatan_";
	$wksheet="Pendapatan Billing";
	$captionRpt="LAPORAN PENDAPATAN";
}

//Paging,Sorting dan Filter======
$defaultsort="k.id";
$sorting=$_REQUEST["sorting"];
//===============================
require_once('../Excell/Writer.php');
switch ($tipe){
	case "1":
		$pel=" RAWAT JALAN";
		$wkbook.="RWT_JALAN";
		break;
	case "2":
		$pel=" RAWAT INAP";
		$wkbook.="RWT_INAP";
		break;
	case "3":
		$pel=" IGD";
		$wkbook.="IGD";
		break;
	case "4":
		$pel="";
		$wkbook.="UNIT_LAYANAN";
		break;
}

$workbook = new Spreadsheet_Excel_Writer();
$workbook->send($wkbook.'_'.tglSQL($tgl_d).'.xls');
$worksheet=&$workbook->addWorksheet($wksheet);
$worksheet->setPaper("letter");
//$worksheet->setPaper(5);
//$worksheet->setLandscape();
$worksheet->setMargins_LR(0.2);
$worksheet->setMargins_TB(0.2);
$columnWidth = 10;
if($tipe != 4){
	$worksheet->setColumn (0, 0, 3);
	$worksheet->setColumn (1, 2, 9);
	$worksheet->setColumn (3, 3, 8);
	$worksheet->setColumn (4, 5, 20);
	$worksheet->setColumn (6, 11, 10);
}else{
	$worksheet->setColumn (0, 0, 3);
	$worksheet->setColumn (1, 2, 9);
	$worksheet->setColumn (3, 3, 8);
	$worksheet->setColumn (4, 6, 20);
	$worksheet->setColumn (7, 12, 10);
}

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>10,'align'=>'center'));
$UnitTitleFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left'));
$UnitTitleFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TLBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_BR =& $workbook->addFormat(array('size'=>8,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>8,'align'=>'center','textWrap'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center'));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left'));
$sTotFormatCF =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center','textWrap'=>1,'numFormat'=>'#,##0'));
$sTotFormatRF =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));
$sTotFormatLF =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left','textWrap'=>1,'numFormat'=>'#,##0'));
$regularFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1));
$regularFormatRF =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
$worksheet->write($row, 5, $captionRpt.$pel, $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "KSO : $kson", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "TGL : ".tglSQL($tgl_d), $sheetTitleFormat);
if ($tipe == 4){
	$row += 1;
	$worksheet->write($row, 5, "JENIS LAYANAN : ".$jenis_layananN, $sheetTitleFormat);
	$row += 1;
	$worksheet->write($row, 5, "TEMPAT LAYANAN : ".$unitN, $sheetTitleFormat);
}
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;

if($tipe != 4){
	$worksheet->write($row, $column, "No", $columnTitleFormat);
	$worksheet->write($row, $column+1, "Tgl Kunjungan", $columnTitleFormat);
	$worksheet->write($row, $column+2, "Tgl Pulang", $columnTitleFormat);
	$worksheet->write($row, $column+3, "No RM", $columnTitleFormat);
	$worksheet->write($row, $column+4, "Nama", $columnTitleFormat);
	$worksheet->write($row, $column+5, "Tempat Layanan", $columnTitleFormat);
	$worksheet->write($row, $column+6, "TARIF RS", $columnTitleFormat);
	$worksheet->write($row, $column+7, "Biaya Pasien", $columnTitleFormat);
	$worksheet->write($row, $column+8, "Tarif KSO", $columnTitleFormat);
	$worksheet->write($row, $column+9, "Iur Bayar", $columnTitleFormat);
	$worksheet->write($row, $column+10, "Selisih", $columnTitleFormat);
}else{
	$worksheet->write($row, $column, "No", $columnTitleFormat);
	$worksheet->write($row, $column+1, "Tgl Kunjungan", $columnTitleFormat);
	$worksheet->write($row, $column+2, "Tgl Pulang", $columnTitleFormat);
	$worksheet->write($row, $column+3, "No RM", $columnTitleFormat);
	$worksheet->write($row, $column+4, "Nama", $columnTitleFormat);
	$worksheet->write($row, $column+5, "Tempat Layanan", $columnTitleFormat);
	$worksheet->write($row, $column+6, "Unit Asal", $columnTitleFormat);
	$worksheet->write($row, $column+7, "TARIF RS", $columnTitleFormat);
	$worksheet->write($row, $column+8, "Biaya Pasien", $columnTitleFormat);
	$worksheet->write($row, $column+9, "Tarif KSO", $columnTitleFormat);
	$worksheet->write($row, $column+10, "Iur Bayar", $columnTitleFormat);
	$worksheet->write($row, $column+11, "Selisih", $columnTitleFormat);
}
$row += 1;
//Write each datapoint to the sheet starting one row beneath
//$row=0;
/*  if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
  }*/
if ($sorting=="") {
	$sorting=$defaultsort;
	if($tipe != 'lain2') {
		$sorting = 'tgl';
	}
}

switch($tipe){
    case '1':
		//rawat jalan
		$sql = "select * from (select k.id,u.nama as unit,date_format(k.tgl,'%d-%m-%Y') as tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,ps.no_rm,ps.nama as pasien,t1.* from (SELECT gab.pelayanan_id,SUM(gab.biayaRS) AS biayaRS,SUM(gab.biaya_kso) AS biaya_kso,SUM(gab.biaya_pasien) AS biaya_pasien,SUM(gab.bayar_kso) AS bayar_kso,SUM(gab.bayar_pasien) AS bayar_pasien FROM (SELECT DISTINCT t.id,t.pelayanan_id,(qty*biaya) AS biayaRS,(qty*biaya_kso) AS biaya_kso,(qty*biaya_pasien) AS biaya_pasien,bayar_kso,bayar-bayar_kso AS bayar_pasien,p.kunjungan_id 
		FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
        INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal=mu.id
        WHERE (mu.parent_id <> 44 and mu.inap = 0 and p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 and u.parent_id <> 44)) AND t.kso_id='$kso' AND t.tgl='$tgl_d') AS gab GROUP BY gab.kunjungan_id) t1
 inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
 inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
 inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
 inner join $dbbilling.b_ms_unit u on u.id = p.unit_id) t1 order by $sorting";
 		break;
    case '2':
		//rawat inap
		$sql = "SELECT * FROM (SELECT k.id,t2.pelayanan_id,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,
mp.no_rm,mp.nama AS pasien,SUM(t2.biayaRS) AS biayaRS,SUM(t2.biaya_kso) AS biaya_kso,
SUM(t2.biaya_pasien) AS biaya_pasien,SUM(t2.bayar) bayar,SUM(t2.bayar_kso) bayar_kso,SUM(t2.bayar_pasien) bayar_pasien 
FROM (SELECT t.pelayanan_id,t.kunjungan_id,SUM(t.biaya*t.qty) AS biayaRS,SUM(t.biaya_kso*t.qty) AS biaya_kso,
SUM(t.biaya_pasien*t.qty) AS biaya_pasien,SUM(t.bayar) bayar,SUM(t.bayar_kso) bayar_kso,SUM(t.bayar_pasien) bayar_pasien
FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
WHERE t.kso_id='$kso' AND t.jenis_kunjungan='3' AND t.tgl='$tgl_d' GROUP BY t.kunjungan_id
UNION
SELECT t1.id pelayanan_id,t1.kunjungan_id,SUM(t1.qty*t1.tarip) biayaRS,SUM(t1.qty*t1.beban_kso) biaya_kso,
SUM(t1.qty*t1.beban_pasien) biaya_pasien,SUM(t1.bayar) bayar,SUM(t1.bayar_kso) bayar_kso,SUM(t1.bayar_pasien) bayar_pasien
FROM (SELECT t1.id,t1.kunjungan_id,IF(t1.status_out=0,IF(t1.tgl_out IS NULL,1,IF(DATEDIFF(t1.tgl_out,t1.tgl_in)=0,1,IF(DATE(t1.tgl_out)='$tgl_d',0,1))),
IF(t1.tgl_out IS NULL,1,IF(DATEDIFF(t1.tgl_out,'$tgl_d')=0,0,1))) AS qty,
t1.tarip,t1.beban_kso,t1.beban_pasien,t1.bayar,t1.bayar_kso,t1.bayar_pasien
FROM (SELECT p.kunjungan_id,p.id,p.unit_id_asal,tk.tgl_in,IFNULL(tk.tgl_out,k.tgl_pulang) AS tgl_out,
tk.tarip,tk.beban_kso,tk.beban_pasien,tk.bayar,tk.bayar_kso,tk.bayar_pasien,tk.status_out 
FROM $dbbilling.b_tindakan_kamar tk INNER JOIN $dbbilling.b_pelayanan p ON tk.pelayanan_id=p.id
INNER JOIN $dbbilling.b_kunjungan k ON p.kunjungan_id=k.id
WHERE DATE(tk.tgl_in)<='$tgl_d' AND (DATE(tk.tgl_out) >='$tgl_d' OR tk.tgl_out IS NULL) 
AND (DATE(k.tgl_pulang) >='$tgl_d' OR k.tgl_pulang IS NULL) AND p.kso_id='$kso' AND tk.aktif=1) AS t1) AS t1 
GROUP BY t1.kunjungan_id) AS t2 INNER JOIN $dbbilling.b_kunjungan k ON t2.kunjungan_id=k.id 
INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id=mp.id 
GROUP BY t2.kunjungan_id) AS t3 $filter ORDER BY $sorting";
 		break;
    case '3':
		//igd
		$sql = "select * from (select k.id,u.nama as unit,date_format(k.tgl,'%d-%m-%Y') as tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,ps.no_rm,ps.nama as pasien,t1.* from (SELECT gab.pelayanan_id,SUM(gab.biayaRS) AS biayaRS,SUM(gab.biaya_kso) AS biaya_kso,SUM(gab.biaya_pasien) AS biaya_pasien,
				SUM(gab.bayar_kso) AS bayar_kso,SUM(gab.bayar_pasien) AS bayar_pasien FROM
				(SELECT DISTINCT t.id,p.kunjungan_id,t.pelayanan_id,(qty*biaya) AS biayaRS,(qty*biaya_kso) AS biaya_kso,(qty*biaya_pasien) AS biaya_pasien,
				bayar_kso,bayar-bayar_kso AS bayar_pasien
				FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
				INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal=mu.id
				WHERE (mu.parent_id = 44 and mu.inap = 0 and p.unit_id not IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=1) or p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 and u.parent_id = 44)) AND t.kso_id='$kso' AND t.tgl='$tgl_d'
				) AS gab GROUP BY gab.kunjungan_id
				) t1
				inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
				inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
				inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
				inner join $dbbilling.b_ms_unit u on u.id = p.unit_id) t1 order by $sorting";
 		break;
	case '4':
		//Per Tempat Layanan
	  if($kso == 0){
		 $kso = "";
	  }
	  else{
		 if($inap == 1){
			$ksoP = " and t.kso_id = '$kso' ";
		 }
		 $kso = " AND t.kso_id='$kso' ";
	  }
	  if($inap == 0){
		 //non-inap
		 $sql = "select * from (select k.id,u.nama as unit,date_format(k.tgl,'%d-%m-%Y') as tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,ps.no_rm,ps.nama as pasien, ua.nama as unit_asal,t1.* from (SELECT gab.pelayanan_id,SUM(gab.biayaRS) AS biayaRS,SUM(gab.biaya_kso) AS biaya_kso,SUM(gab.biaya_pasien) AS biaya_pasien,
				SUM(gab.bayar_kso) AS bayar_kso,SUM(gab.bayar_pasien) AS bayar_pasien FROM
				(SELECT DISTINCT t.id,t.pelayanan_id,(qty*biaya) AS biayaRS,(qty*biaya_kso) AS biaya_kso,(qty*biaya_pasien) AS biaya_pasien,
				bayar_kso,bayar-bayar_kso AS bayar_pasien
				FROM $dbbilling.b_tindakan_ak t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
				INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id
				WHERE mu.id='$unit_id' $kso AND t.tgl='$tgl_d' $fTipe $fbayar
				) AS gab GROUP BY gab.pelayanan_id
				) t1
				inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
				inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
				inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
				inner join $dbbilling.b_ms_unit u on u.id = p.unit_id
				inner join $dbbilling.b_ms_unit ua on ua.id = p.unit_id_asal
				group by k.id) t1 order by $sorting";
	  }
	  else{
		 //inap
		$sql="SELECT * FROM (SELECT k.id,t2.pelayanan_id,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,mp.no_rm,mp.nama AS pasien,
mu.nama unit_asal,SUM(t2.biayaRS) AS biayaRS,SUM(t2.biaya_kso) AS biaya_kso,SUM(t2.biaya_pasien) AS biaya_pasien,
SUM(t2.bayar) AS bayar,SUM(t2.bayar_kso) AS bayar_kso,SUM(t2.bayar_pasien) AS bayar_pasien 
FROM (SELECT pl.id pelayanan_id,pl.kunjungan_id,'$unit_id' AS unit_id,pl.unit_id_asal,SUM(t.qty*t.biaya) biayaRS,SUM(t.qty*t.biaya_kso) biaya_kso,
SUM(t.qty*t.biaya_pasien) biaya_pasien,SUM(t.bayar) bayar,SUM(t.bayar_kso) bayar_kso,SUM(t.bayar_pasien) bayar_pasien
FROM $dbbilling.b_pelayanan pl INNER JOIN $dbbilling.b_tindakan_ak t ON t.pelayanan_id = pl.id 
WHERE pl.unit_id='$unit_id' AND t.tgl = '$tgl_d' $kso $fTipe $fbayar GROUP BY pl.id
UNION
SELECT t1.id pelayanan_id,t1.kunjungan_id,'$unit_id' AS unit_id,t1.unit_id_asal,SUM(t1.qty*t1.tarip) biayaRS,SUM(t1.qty*t1.beban_kso) biaya_kso,SUM(t1.qty*t1.beban_pasien) biaya_pasien,
SUM(t1.bayar) bayar,SUM(t1.bayar_kso) bayar_kso,SUM(t1.bayar_pasien) bayar_pasien
FROM (SELECT t1.id,t1.kunjungan_id,t1.unit_id_asal,
IF(t1.status_out=0,IF(t1.tgl_out IS NULL,1,IF(DATEDIFF(t1.tgl_out,t1.tgl_in)=0,1,IF(DATE(t1.tgl_out)='$tgl_d',0,1))),
IF(t1.tgl_out IS NULL,1,IF(DATEDIFF(t1.tgl_out,'$tgl_d')=0,0,1))) AS qty,
t1.tarip,t1.beban_kso,t1.beban_pasien,t1.bayar,t1.bayar_kso,t1.bayar_pasien
FROM (SELECT p.id,p.kunjungan_id,p.unit_id_asal,t.tgl_in,IFNULL(t.tgl_out,k.tgl_pulang) AS tgl_out,
t.tarip,t.beban_kso,t.beban_pasien,t.bayar,t.bayar_kso,if(t.bayar_pasien>=t.tarip,t.tarip,0) bayar_pasien,t.status_out 
FROM $dbbilling.b_tindakan_kamar_ak t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
INNER JOIN $dbbilling.b_kunjungan k ON k.id=p.kunjungan_id
WHERE p.unit_id='$unit_id' $fTipe $fbayar AND DATE(t.tgl_in)<='$tgl_d' AND (DATE(t.tgl_out) >='$tgl_d' OR t.tgl_out IS NULL) 
AND (DATE(k.tgl_pulang) >='$tgl_d' OR k.tgl_pulang IS NULL) $ksoP AND t.aktif=1) AS t1) AS t1 GROUP BY t1.id) AS t2
INNER JOIN $dbbilling.b_kunjungan k ON t2.kunjungan_id=k.id INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id=mp.id 
INNER JOIN $dbbilling.b_ms_unit mu ON t2.unit_id_asal=mu.id GROUP BY t2.pelayanan_id) t3 $filter ORDER BY $sorting";
	  }
		break;
}
//echo $sql."<br>";
$rs=mysql_query($sql);
$i=0;
$tmpLay = '';
while ($rows=mysql_fetch_array($rs)){
	$i++;
	 if($tipe != 4){
		if($tipe == 1){
			$sqlX = "SELECT DISTINCT mu.nama
			FROM $dbbilling.b_tindakan t
		INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
		INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id = mu.id
			WHERE (mu.parent_id <> 44 and mu.inap = 0 and p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 and u.parent_id <> 44))
		AND t.kso_id='$kso' AND t.tgl='$tgl_d' and p.kunjungan_id = '".$rows["id"]."'";
		}
		else if($tipe == 2){
			$sqlX = "SELECT *
			FROM (SELECT
				  u.nama
				FROM (SELECT distinct
					   pelayanan_id
					 FROM $dbbilling.b_tindakan t inner join $dbbilling.b_pelayanan p on t.pelayanan_id = p.id
					 inner join $dbbilling.b_ms_unit mu on mu.id = p.unit_id_asal
					 WHERE p.kunjungan_id = '".$rows["id"]."'
						AND t.tgl = '$tgl_d' and (mu.inap = 1
							OR p.unit_id IN(SELECT
										  u.id
										FROM $dbbilling.b_ms_unit u
										WHERE u.inap = 1))
						UNION SELECT distinct
										pelayanan_id
									  FROM $dbbilling.b_tindakan_kamar tk inner join $dbbilling.b_pelayanan p on tk.pelayanan_id = p.id
									  WHERE p.kunjungan_id = '".$rows["id"]."'
										  AND date(tk.tgl_in) <= '$tgl_d'
										  AND (date(tk.tgl_out) >= '$tgl_d'
												OR tk.tgl_out IS NULL)) t
						INNER JOIN $dbbilling.b_pelayanan p
						  ON t.pelayanan_id = p.id
						INNER JOIN $dbbilling.b_ms_unit u
						  ON p.unit_id = u.id) t1";
		}
		else if($tipe == 3){
			$sqlX = "SELECT DISTINCT u.nama
			   FROM $dbbilling.b_tindakan t
			   INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
			   INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal = mu.id
			   inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
			   inner join $dbbilling.b_ms_unit u on p.unit_id = u.id
			   WHERE (mu.inap = 0 and u.inap = 0
			   and k.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 and u.parent_id = 44))
				AND t.tgl='$tgl_d' and p.kunjungan_id = '".$rows["id"]."'";
				//AND t.kso_id='$kso'
		}
		
		$rsX = mysql_query($sqlX);
		while($rowsX = mysql_fetch_array($rsX)){
			$tmpLay .= $rowsX['nama'].', ';
		}
		$tmpLay = substr($tmpLay,0,strlen($tmpLay)-2);
	 }
	 else{
		$unit_asal = $rows['unit_asal'];
		$tmpLay = $rows['unit'];
	 }

	$tPerda=$rows["biayaRS"];
	if ($ckso=="1"){
		$tKSO=0;
		$tPx=$tPerda;
		$tIur=0;
	}else{
		$tKSO=$rows["biaya_kso"];
		$tPx=0;
		$tIur=$rows["biaya_pasien"];
	}
	$tSelisih=$tPerda-($tKSO+$tPx+$tIur);

	if($tipe != 4){
		$worksheet->write($row, 0, $i, $regularFormatC);
		$worksheet->write($row, 1, $rows["tgl"], $regularFormatC);
		$worksheet->write($row, 2, $rows["tgl_p"], $regularFormatC);
		$worksheet->write($row, 3, $rows["no_rm"], $regularFormatC);
		$worksheet->write($row, 4, $rows["pasien"], $regularFormat);
		$worksheet->write($row, 5, $tmpLay.$unit_asal, $regularFormat);
		$worksheet->write($row, 6, $tPerda, $regularFormatRF);
		$worksheet->write($row, 7, $tPx, $regularFormatRF);
		$worksheet->write($row, 8, $tKSO, $regularFormatRF);
		$worksheet->write($row, 9, $tIur, $regularFormatRF);
		$worksheet->write($row, 10, $tSelisih, $regularFormatRF);
		$row++;
		$tmpLay = '';
	}else{
		$worksheet->write($row, 0, $i, $regularFormatC);
		$worksheet->write($row, 1, $rows["tgl"], $regularFormatC);
		$worksheet->write($row, 2, $rows["tgl_p"], $regularFormatC);
		$worksheet->write($row, 3, $rows["no_rm"], $regularFormatC);
		$worksheet->write($row, 4, $rows["pasien"], $regularFormat);
		$worksheet->write($row, 5, $tmpLay, $regularFormat);
		$worksheet->write($row, 6, $unit_asal, $regularFormat);
		$worksheet->write($row, 7, $tPerda, $regularFormatRF);
		$worksheet->write($row, 8, $tPx, $regularFormatRF);
		$worksheet->write($row, 9, $tKSO, $regularFormatRF);
		$worksheet->write($row, 10, $tIur, $regularFormatRF);
		$worksheet->write($row, 11, $tSelisih, $regularFormatRF);
		$row++;
		$tmpLay = '';
	}
}

if($tipe != 4){
	$worksheet->write($row, 5, "Sub Total", $sTotFormatR);
	$worksheet->write($row, 6, '=Sum(G5:G'.$row.')', $sTotFormatRF);
	$worksheet->write($row, 7, '=Sum(H5:H'.$row.')', $sTotFormatRF);
	$worksheet->write($row, 8, '=Sum(I5:I'.$row.')', $sTotFormatRF);
	$worksheet->write($row, 9, '=Sum(J5:J'.$row.')', $sTotFormatRF);
	$worksheet->write($row, 10, '=Sum(K5:K'.$row.')', $sTotFormatRF);
}else{
	$worksheet->write($row, 6, "Sub Total", $sTotFormatR);
	$worksheet->write($row, 7, '=Sum(H7:H'.$row.')', $sTotFormatRF);
	$worksheet->write($row, 8, '=Sum(I7:I'.$row.')', $sTotFormatRF);
	$worksheet->write($row, 9, '=Sum(J7:J'.$row.')', $sTotFormatRF);
	$worksheet->write($row, 10, '=Sum(K7:K'.$row.')', $sTotFormatRF);
	$worksheet->write($row, 11, '=Sum(L7:L'.$row.')', $sTotFormatRF);
}
$workbook->close();
mysql_free_result($rs);
mysql_close($konek);
?>
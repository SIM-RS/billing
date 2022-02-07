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
$tgl_d1=$_REQUEST['tgl_d1'];
$tgl_d=explode("-",$tgl_d1);
$tgl_d=$tgl_d[2]."-".$tgl_d[1]."-".$tgl_d[0];
$tgl_s1=$_REQUEST['tgl_s1'];
$tgl_s=explode("-",$tgl_s1);
$tgl_s=$tgl_s[2]."-".$tgl_s[1]."-".$tgl_s[0];

$defaultsort="t6.OBAT_NAMA,t6.KEPEMILIKAN_ID";
$idunit1=$_REQUEST['idunit1'];
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
$kpid=$_REQUEST['kpid'];if ($kpid=="0") $filter=""; else $filter=" AND t6.KEPEMILIKAN_ID=".$kpid;
$kelas=$_REQUEST['kelas'];if ($kelas=="") $fkelas=""; else{ if ($idunit1=="0") $fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'"; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";}
$golongan=$_REQUEST['golongan'];if ($golongan=="") $fgolongan=""; else{ if (($idunit1=="0")&&($kelas=="")) $fgolongan=" WHERE ao.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";}
$jenis=$_REQUEST['jenis'];if ($jenis=="") $fjenis=""; else { if (($idunit1=="0")&&($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE ao.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";}
$kpid1=$_REQUEST['kpid1'];
$g1=$_REQUEST['g1'];
$k1=$_REQUEST['k1'];
$j1=$_REQUEST['j1'];
//===============================
require_once('../Excell/Writer.php');

$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('Mutasi_Obat_'.$tgl_s.'.xls');

$worksheet=&$workbook->addWorksheet('Stok Obat');
$worksheet->setPaper(5);
//$worksheet->setLandscape();
$worksheet->setMargins_LR(0);
$worksheet->setMargins_TB(0.2);
$columnWidth = 10;
$worksheet->setColumn (0, 0, 4);
$worksheet->setColumn (1, 1, 17);
$worksheet->setColumn (2, 2, 9);
$worksheet->setColumn (3, 3, 4);
$worksheet->setColumn (4, 4, 10);
$worksheet->setColumn (5, 7, 4);
$worksheet->setColumn (8, 8, 4);
$worksheet->setColumn (9, 10, 4);
$worksheet->setColumn (11, 11, 4);
$worksheet->setColumn (12, 13, 4);
$worksheet->setColumn (14, 14, 3);
$worksheet->setColumn (15, 15, 4);
$worksheet->setColumn (16, 16, 11);

//Setup different styles
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

//Write sheet title in upper left cell
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
$worksheet->write($row, 6, "TGL : ".$tgl_d." s/d ".$tgl_s, $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "No", $columnTitleFormat);
$worksheet->write($row, $column+1, "Nama Obat", $columnTitleFormat);
$worksheet->write($row, $column+2, "Milik", $columnTitleFormat);
$worksheet->write($row, $column+3, "Saldo Awal", $columnTitleFormat);
$worksheet->writeBlank($row, $column+4, $columnTitleFormat);
$worksheet->mergeCells($row,$column+3,$row,$column+4);
$worksheet->write($row, $column+5, "Masuk", $columnTitleFormat);
$worksheet->writeBlank($row, $column+6, $columnTitleFormat);
$worksheet->writeBlank($row, $column+7, $columnTitleFormat);
$worksheet->writeBlank($row, $column+8, $columnTitleFormat);
$worksheet->mergeCells($row,$column+5,$row,$column+8);
$worksheet->write($row, $column+9, "Keluar", $columnTitleFormat);
$worksheet->writeBlank($row, $column+10, $columnTitleFormat);
$worksheet->writeBlank($row, $column+11, $columnTitleFormat);
$worksheet->writeBlank($row, $column+12, $columnTitleFormat);
$worksheet->writeBlank($row, $column+13, $columnTitleFormat);
$worksheet->mergeCells($row,$column+9,$row,$column+13);
$worksheet->write($row, $column+14, "Adj", $columnTitleFormat);
$worksheet->write($row, $column+15, "Saldo Akhir", $columnTitleFormat);
$worksheet->writeBlank($row, $column+16, $columnTitleFormat);
$worksheet->mergeCells($row,$column+15,$row,$column+16);
$row += 1;

$worksheet->writeBlank($row, $column, $columnTitleFormat);
$worksheet->mergeCells($row-1,$column,$row,$column);
$worksheet->writeBlank($row, $column+1, $columnTitleFormat);
$worksheet->mergeCells($row-1,$column+1,$row,$column+1);
$worksheet->writeBlank($row, $column+2, $columnTitleFormat);
$worksheet->mergeCells($row-1,$column+2,$row,$column+2);
$worksheet->write($row, $column+3, "Qty", $columnTitleFormat);
$worksheet->write($row, $column+4, "Nilai", $columnTitleFormat);
$worksheet->write($row, $column+5, "Pbf", $columnTitleFormat);
$worksheet->write($row, $column+6, "Unit", $columnTitleFormat);
$worksheet->write($row, $column+7, "Milik", $columnTitleFormat);
$worksheet->write($row, $column+8, "Ret", $columnTitleFormat);
$worksheet->write($row, $column+9, "Jual", $columnTitleFormat);
$worksheet->write($row, $column+10, "Unit", $columnTitleFormat);
$worksheet->write($row, $column+11, "Ret", $columnTitleFormat);
$worksheet->write($row, $column+12, "Milik", $columnTitleFormat);
$worksheet->write($row, $column+13, "Hapus", $columnTitleFormat);
$worksheet->writeBlank($row, $column+14, $columnTitleFormat);
$worksheet->mergeCells($row-1,$column+14,$row,$column+14);
$worksheet->write($row, $column+15, "Qty", $columnTitleFormat);
$worksheet->write($row, $column+16, "Nilai", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;
/*  if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
  }*/
  if ($sorting=="") $sorting=$defaultsort;
/*  if ($idunit1=="0"){
	$sql="SELECT t6.* FROM (SELECT SUM(tmp.qty_awal) AS qty_awal,SUM(tmp.nilai_awal) AS nilai_awal,tmp.OBAT_ID,tmp.KEPEMILIKAN_ID,
		tmp.OBAT_NAMA,tmp.NAMA,tmp.MAXID_AKHIR,SUM(tmp.qty_akhir) AS qty_akhir,SUM(tmp.nilai_akhir) AS nilai_akhir,
		SUM(tmp.pbf) AS pbf,SUM(tmp.unit_in) AS unit_in,SUM(tmp.milik_in) AS milik_in,SUM(tmp.rt_rsp) AS rt_rsp,
		SUM(tmp.rsp) AS rsp,SUM(tmp.unit_out) AS unit_out,SUM(tmp.rt) AS rt,SUM(tmp.milik_out) AS milik_out,
		SUM(tmp.hapus) AS hapus,SUM(tmp.adj) AS adj
		FROM (SELECT IF (t4.STOK_AFTER IS NULL,0,t4.STOK_AFTER) AS qty_awal,
		IF (t4.NILAI_TOTAL IS NULL,0,t4.NILAI_TOTAL) AS nilai_awal, t5.PID1,t5.OBAT_ID,t5.KEPEMILIKAN_ID,t5.OBAT_NAMA,t5.NAMA,
		IF (t5.PID IS NULL,0,t5.PID) AS PID,IF (t5.MAXID_AKHIR IS NULL,0,t5.MAXID_AKHIR) AS MAXID_AKHIR, 
		IF (t5.qty_akhir IS NULL,IF (t4.STOK_AFTER IS NULL,0,t4.STOK_AFTER),t5.qty_akhir) AS qty_akhir,
		IF (t5.nilai_akhir IS NULL,IF (t4.NILAI_TOTAL IS NULL,0,t4.NILAI_TOTAL),t5.nilai_akhir) AS nilai_akhir,IF (t5.pbf IS NULL,0,t5.pbf) AS pbf, 
		IF (t5.unit_in IS NULL,0,t5.unit_in) AS unit_in,IF (t5.milik_in IS NULL,0,t5.milik_in) AS milik_in,
		IF (t5.rt_rsp IS NULL,0,t5.rt_rsp) AS rt_rsp, IF (t5.rsp IS NULL,0,t5.rsp) AS rsp,
		IF (t5.unit_out IS NULL,0,t5.unit_out) AS unit_out,IF (t5.rt IS NULL,0,t5.rt) AS rt, 
		IF (t5.milik_out IS NULL,0,t5.milik_out) AS milik_out,IF (t5.hapus IS NULL,0,t5.hapus) AS hapus,
		IF (t5.adj IS NULL,0,t5.adj) AS adj FROM (SELECT t1.*,k1.* 
		FROM (SELECT g1.*,ao.OBAT_NAMA,ake.NAMA FROM (SELECT DISTINCT CONCAT(ak.OBAT_ID,'-',ak.KEPEMILIKAN_ID,'-',ak.UNIT_ID) AS PID1,ak.OBAT_ID,ak.KEPEMILIKAN_ID
		FROM a_kartustok ak) AS g1 INNER JOIN a_obat ao ON g1.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ake ON g1.KEPEMILIKAN_ID=ake.ID LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID".$fkelas.$fgolongan.$fjenis.") AS t1 
		LEFT JOIN (SELECT CONCAT(b1.OBAT_ID,'-',b1.KEPEMILIKAN_ID,'-',b1.UNIT_ID) AS PID,b1.ID AS MAXID_AKHIR,b1.STOK_AFTER AS qty_akhir,
		b1.NILAI_TOTAL AS nilai_akhir, 
		SUM(IF (b1.UNIT_ID=17,IF (b1.tipetrans=4,IF (b1.DEBET IS NULL,0,b1.DEBET),0),IF (b1.tipetrans=0,IF (b1.DEBET IS NULL,0,b1.DEBET),0))) AS pbf, 
		SUM(IF (((b1.tipetrans=1 OR b1.tipetrans=2) AND (b1.UNIT_ID_KIRIM<>b1.UNIT_ID_TERIMA)),IF (b1.DEBET IS NULL,0,b1.DEBET),0)) AS unit_in, 
		SUM(IF ((b1.tipetrans=2 AND b1.UNIT_ID_KIRIM=b1.UNIT_ID_TERIMA),IF (b1.DEBET IS NULL,0,b1.DEBET),0)) AS milik_in, 
		SUM(IF ((b1.tipetrans=6 OR b1.tipetrans=7),IF (b1.KREDIT IS NULL,0,b1.KREDIT * -1),0)) AS rt_rsp, 
		SUM(IF (b1.UNIT_ID=17,IF (b1.tipetrans=4,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0),IF (b1.tipetrans=8,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0))) AS rsp, 
		SUM(IF (b1.tipetrans=1,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS unit_out, 
		SUM(IF ((b1.tipetrans=9 OR b1.tipetrans=7),IF (b1.DEBET IS NULL,0,b1.DEBET * -1),0)) AS rt, 
		SUM(IF (b1.tipetrans=2,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS milik_out, 
		SUM(IF (b1.tipetrans=10,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS hapus, 
		SUM(IF (b1.tipetrans=5,IF (b1.DEBET-b1.KREDIT IS NULL,0,b1.DEBET-b1.KREDIT),0)) AS adj 
		FROM (SELECT ak.*,ap.UNIT_ID_KIRIM,ap.UNIT_ID_TERIMA FROM a_kartustok ak LEFT JOIN a_penerimaan ap ON ak.fkid=ap.ID 
		WHERE DATE(ak.TGL_ACT) BETWEEN '$tgl_d1' AND '$tgl_s1' ORDER BY TGL_ACT DESC,ID DESC) AS b1
		GROUP BY b1.OBAT_ID,b1.KEPEMILIKAN_ID,b1.UNIT_ID) AS k1 ON t1.PID1=k1.PID) AS t5
		LEFT JOIN (SELECT CONCAT(t3.OBAT_ID,'-',t3.KEPEMILIKAN_ID,'-',t3.UNIT_ID) AS PID2,t3.STOK_AFTER,t3.NILAI_TOTAL 
		FROM (SELECT * FROM a_kartustok WHERE DATE(TGL_ACT)<'$tgl_d1' ORDER BY TGL_ACT DESC,ID DESC) AS t3 
		GROUP BY t3.OBAT_ID,t3.KEPEMILIKAN_ID,t3.UNIT_ID) AS t4 ON t5.PID1=t4.PID2) AS tmp 
		GROUP BY tmp.OBAT_ID,tmp.KEPEMILIKAN_ID) AS t6 WHERE (t6.qty_awal>0 OR t6.qty_akhir>0 OR ((t6.pbf+t6.unit_in+t6.milik_in+t6.rt_rsp+t6.rsp+t6.unit_out+t6.rt+t6.milik_out+t6.hapus+t6.adj)>0))".$filter." 
		ORDER BY ".$sorting;
  }else{
	$sql="SELECT t6.* FROM (SELECT IF (t4.MAXID IS NULL,0,t4.MAXID) AS MAXID_AWAL,
		IF (t4.STOK_AFTER IS NULL,0,t4.STOK_AFTER) AS qty_awal,IF (t4.NILAI_TOTAL IS NULL,0,t4.NILAI_TOTAL) AS nilai_awal,
		t5.PID1,t5.OBAT_ID,t5.KEPEMILIKAN_ID,t5.OBAT_NAMA,t5.NAMA,IF (t5.PID IS NULL,0,t5.PID) AS PID,IF (t5.MAXID_AKHIR IS NULL,0,t5.MAXID_AKHIR) AS MAXID_AKHIR,
		IF (t5.qty_akhir IS NULL,t4.STOK_AFTER,t5.qty_akhir) AS qty_akhir,IF (t5.nilai_akhir IS NULL,t4.NILAI_TOTAL,t5.nilai_akhir) AS nilai_akhir,IF (t5.pbf IS NULL,0,t5.pbf) AS pbf,
		IF (t5.unit_in IS NULL,0,t5.unit_in) AS unit_in,IF (t5.milik_in IS NULL,0,t5.milik_in) AS milik_in,IF (t5.rt_rsp IS NULL,0,t5.rt_rsp) AS rt_rsp,
		IF (t5.rsp IS NULL,0,t5.rsp) AS rsp,IF (t5.unit_out IS NULL,0,t5.unit_out) AS unit_out,IF (t5.rt IS NULL,0,t5.rt) AS rt,
		IF (t5.milik_out IS NULL,0,t5.milik_out) AS milik_out,IF (t5.hapus IS NULL,0,t5.hapus) AS hapus,IF (t5.adj IS NULL,0,t5.adj) AS adj 
		FROM (SELECT t1.*,t2.* FROM (SELECT DISTINCT CONCAT(ak.OBAT_ID,ak.KEPEMILIKAN_ID) AS PID1,ak.OBAT_ID,ak.KEPEMILIKAN_ID,ao.OBAT_NAMA,ake.NAMA 
		FROM a_kartustok ak INNER JOIN a_obat ao ON ak.OBAT_ID=ao.OBAT_ID 
		INNER JOIN a_kepemilikan ake ON ak.KEPEMILIKAN_ID=ake.ID LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID 
		WHERE ak.UNIT_ID=$idunit1".$fkelas.$fgolongan.$fjenis." 
		ORDER BY ao.OBAT_NAMA,ake.ID) AS t1 LEFT JOIN 
		(SELECT CONCAT(b1.OBAT_ID,b1.KEPEMILIKAN_ID) AS PID,b1.ID AS MAXID_AKHIR,b1.STOK_AFTER AS qty_akhir,b1.NILAI_TOTAL AS nilai_akhir,
		SUM(IF (b1.UNIT_ID=17,IF (b1.tipetrans=4,IF (b1.DEBET IS NULL,0,b1.DEBET),0),IF (b1.tipetrans=0,IF (b1.DEBET IS NULL,0,b1.DEBET),0))) AS pbf, 
		SUM(IF (((b1.tipetrans=1 OR b1.tipetrans=2) AND (b1.UNIT_ID_KIRIM<>$idunit1)),IF (b1.DEBET IS NULL,0,b1.DEBET),0)) AS unit_in, 
		SUM(IF ((b1.tipetrans=2 AND b1.UNIT_ID_KIRIM=$idunit1),IF (b1.DEBET IS NULL,0,b1.DEBET),0)) AS milik_in,
		SUM(IF ((b1.tipetrans=6 OR b1.tipetrans=7),IF (b1.KREDIT IS NULL,0,b1.KREDIT * -1),0)) AS rt_rsp,
		SUM(IF (b1.UNIT_ID=17,IF (b1.tipetrans=4,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0),IF (b1.tipetrans=8,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0))) AS rsp,
		SUM(IF (b1.tipetrans=1,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS unit_out,
		SUM(IF ((b1.tipetrans=9 OR b1.tipetrans=7),IF (b1.DEBET IS NULL,0,b1.DEBET * -1),0)) AS rt,
		SUM(IF (b1.tipetrans=2,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS milik_out,
		SUM(IF (b1.tipetrans=10,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS hapus,
		SUM(IF (b1.tipetrans=5,IF (b1.DEBET-b1.KREDIT IS NULL,0,b1.DEBET-b1.KREDIT),0)) AS adj 
		FROM (SELECT ak.*,ap.UNIT_ID_KIRIM FROM a_kartustok ak LEFT JOIN a_penerimaan ap ON ak.fkid=ap.ID 
		WHERE ak.UNIT_ID=$idunit1 AND DATE(ak.TGL_ACT) BETWEEN '$tgl_d1' AND '$tgl_s1' 
		ORDER BY TGL_ACT DESC,ID DESC) AS b1 
		GROUP BY b1.OBAT_ID,b1.KEPEMILIKAN_ID) AS t2 ON t1.PID1=t2.PID) AS t5 LEFT JOIN 
		(SELECT CONCAT(t3.OBAT_ID,t3.KEPEMILIKAN_ID) AS PID2,ID AS MAXID,t3.OBAT_ID,t3.KEPEMILIKAN_ID,t3.STOK_AFTER,t3.NILAI_TOTAL FROM (SELECT * FROM a_kartustok WHERE UNIT_ID=$idunit1 AND DATE(TGL_ACT)<'$tgl_d1' ORDER BY TGL_ACT DESC,ID DESC) AS t3 GROUP BY t3.OBAT_ID,t3.KEPEMILIKAN_ID) 
		AS t4 ON t4.PID2=t5.PID1) AS t6 WHERE (t6.qty_awal>0 OR t6.qty_akhir>0 OR ((t6.pbf+t6.unit_in+t6.milik_in+t6.rt_rsp+t6.rsp+t6.unit_out+t6.rt+t6.milik_out+t6.hapus+t6.adj)>0))".$filter." 
		ORDER BY ".$sorting;
  }*/
	  if ($idunit1=="0"){
	  	$sql="SELECT t6.*,IF (t6.qty_awal=0,0,t6.nilai_awal) AS nilai_awal1,IF (t6.qty_akhir=0,0,t6.nilai_akhir) AS nilai_akhir1 
			FROM (SELECT SUM(tmp.qty_awal) AS qty_awal,SUM(tmp.nilai_awal) AS nilai_awal,tmp.OBAT_ID,tmp.KEPEMILIKAN_ID,
			tmp.OBAT_NAMA,tmp.NAMA,tmp.MAXID_AKHIR,SUM(tmp.qty_akhir) AS qty_akhir,SUM(tmp.nilai_akhir) AS nilai_akhir,
			SUM(tmp.pbf) AS pbf,SUM(tmp.unit_in) AS unit_in,SUM(tmp.milik_in) AS milik_in,SUM(tmp.rt_rsp) AS rt_rsp,
			SUM(tmp.rsp) AS rsp,SUM(tmp.unit_out) AS unit_out,SUM(tmp.rt) AS rt,SUM(tmp.milik_out) AS milik_out,
			SUM(tmp.hapus) AS hapus,SUM(tmp.adj) AS adj
			FROM (SELECT IF (t4.STOK_AFTER IS NULL,0,IF (t4.STOK_AFTER<=0,0,t4.STOK_AFTER)) AS qty_awal,
			IF (t4.NILAI_TOTAL IS NULL,0,IF (((t4.NILAI_TOTAL<=0) OR (t4.STOK_AFTER<=0)),0,FLOOR(t4.NILAI_TOTAL))) AS nilai_awal, t5.PID1,t5.OBAT_ID,t5.KEPEMILIKAN_ID,
			t5.OBAT_NAMA,t5.NAMA,IF (t5.PID IS NULL,0,t5.PID) AS PID,IF (t5.MAXID_AKHIR IS NULL,0,t5.MAXID_AKHIR) AS MAXID_AKHIR, 
			IF (t5.qty_akhir IS NULL,IF (((t4.STOK_AFTER<=0) OR (t4.STOK_AFTER IS NULL)),0,t4.STOK_AFTER),IF (t5.qty_akhir<=0,0,t5.qty_akhir)) AS qty_akhir,
			IF (t5.nilai_akhir IS NULL,IF (((t4.NILAI_TOTAL<=0) OR (t4.NILAI_TOTAL IS NULL) OR (t4.STOK_AFTER<=0)),0,FLOOR(t4.NILAI_TOTAL)),IF (((t5.nilai_akhir<=0) OR (t5.qty_akhir<=0)),0,FLOOR(t5.nilai_akhir))) AS nilai_akhir,
			IF (t5.pbf IS NULL,0,t5.pbf) AS pbf, IF (t5.unit_in IS NULL,0,t5.unit_in) AS unit_in,IF (t5.milik_in IS NULL,0,t5.milik_in) AS milik_in,
			IF (t5.rt_rsp IS NULL,0,t5.rt_rsp) AS rt_rsp, IF (t5.rsp IS NULL,0,t5.rsp) AS rsp,
			IF (t5.unit_out IS NULL,0,t5.unit_out) AS unit_out,IF (t5.rt IS NULL,0,t5.rt) AS rt, 
			IF (t5.milik_out IS NULL,0,t5.milik_out) AS milik_out,IF (t5.hapus IS NULL,0,t5.hapus) AS hapus,
			IF (t5.adj IS NULL,0,t5.adj) AS adj FROM (SELECT t1.*,k1.* 
			FROM (SELECT g1.*,ao.OBAT_NAMA,ake.NAMA FROM (SELECT DISTINCT CONCAT(ak.OBAT_ID,'-',ak.KEPEMILIKAN_ID,'-',ak.UNIT_ID) AS PID1,ak.OBAT_ID,ak.KEPEMILIKAN_ID
			FROM a_kartustok ak) AS g1 INNER JOIN a_obat ao ON g1.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ake ON g1.KEPEMILIKAN_ID=ake.ID LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID".$fkelas.$fgolongan.$fjenis.") AS t1 
			LEFT JOIN (SELECT CONCAT(b1.OBAT_ID,'-',b1.KEPEMILIKAN_ID,'-',b1.UNIT_ID) AS PID,b1.ID AS MAXID_AKHIR,b1.STOK_AFTER AS qty_akhir,
			b1.NILAI_TOTAL AS nilai_akhir, 
			SUM(IF (b1.UNIT_ID=17,IF (b1.tipetrans=4,IF (b1.DEBET IS NULL,0,b1.DEBET),0),IF (b1.tipetrans=0,IF (b1.DEBET IS NULL,0,b1.DEBET),0))) AS pbf, 
			SUM(IF (((b1.tipetrans=1 OR b1.tipetrans=2) AND (b1.UNIT_ID_KIRIM<>b1.UNIT_ID_TERIMA)),IF (b1.DEBET IS NULL,0,b1.DEBET),0)) AS unit_in, 
			SUM(IF ((b1.tipetrans=2 AND b1.UNIT_ID_KIRIM=b1.UNIT_ID_TERIMA),IF (b1.DEBET IS NULL,0,b1.DEBET),0)) AS milik_in, 
			SUM(IF ((b1.tipetrans=6 OR b1.tipetrans=7),IF (b1.KREDIT IS NULL,0,b1.KREDIT * -1),0)) AS rt_rsp, 
			SUM(IF (b1.UNIT_ID=17,IF (b1.tipetrans=4,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0),IF (b1.tipetrans=8,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0))) AS rsp, 
			SUM(IF (b1.tipetrans=1,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS unit_out, 
			SUM(IF ((b1.tipetrans=9 OR b1.tipetrans=7),IF (b1.DEBET IS NULL,0,b1.DEBET * -1),0)) AS rt, 
			SUM(IF (b1.tipetrans=2,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS milik_out, 
			SUM(IF (b1.tipetrans=10,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS hapus, 
			SUM(IF (b1.tipetrans=5,IF (b1.DEBET-b1.KREDIT IS NULL,0,b1.DEBET-b1.KREDIT),0)) AS adj 
			FROM (SELECT ak.*,ap.UNIT_ID_KIRIM,ap.UNIT_ID_TERIMA FROM a_kartustok ak LEFT JOIN a_penerimaan ap ON ak.fkid=ap.ID 
			WHERE DATE(ak.TGL_ACT) BETWEEN '$tgl_d1' AND '$tgl_s1' ORDER BY TGL_ACT DESC,ID DESC) AS b1
			GROUP BY b1.OBAT_ID,b1.KEPEMILIKAN_ID,b1.UNIT_ID) AS k1 ON t1.PID1=k1.PID) AS t5
			LEFT JOIN (SELECT CONCAT(t3.OBAT_ID,'-',t3.KEPEMILIKAN_ID,'-',t3.UNIT_ID) AS PID2,t3.STOK_AFTER,t3.NILAI_TOTAL 
			FROM (SELECT * FROM a_kartustok WHERE DATE(TGL_ACT)<'$tgl_d1' ORDER BY TGL_ACT DESC,ID DESC) AS t3 
			GROUP BY t3.OBAT_ID,t3.KEPEMILIKAN_ID,t3.UNIT_ID) AS t4 ON t5.PID1=t4.PID2) AS tmp 
			GROUP BY tmp.OBAT_ID,tmp.KEPEMILIKAN_ID) AS t6 WHERE (t6.qty_awal>0 OR t6.qty_akhir>0 OR ((t6.pbf+t6.unit_in+t6.milik_in+t6.rt_rsp+t6.rsp+t6.unit_out+t6.rt+t6.milik_out+t6.hapus+t6.adj)>0))".$filter." 
			ORDER BY ".$sorting;
	  }else{
		$sql="SELECT t6.*,IF (t6.qty_awal=0,0,t6.nilai_awal) AS nilai_awal1,IF (t6.qty_akhir=0,0,t6.nilai_akhir) AS nilai_akhir1 
			FROM (SELECT IF (t4.MAXID IS NULL,0,t4.MAXID) AS MAXID_AWAL,
			IF (t4.STOK_AFTER IS NULL,0,IF (t4.STOK_AFTER<=0,0,t4.STOK_AFTER)) AS qty_awal,IF (t4.NILAI_TOTAL IS NULL,0,IF (((t4.NILAI_TOTAL<=0) OR (t4.STOK_AFTER<=0)),0,t4.NILAI_TOTAL)) AS nilai_awal,
			t5.PID1,t5.OBAT_ID,t5.KEPEMILIKAN_ID,t5.OBAT_NAMA,t5.NAMA,IF (t5.PID IS NULL,0,t5.PID) AS PID,IF (t5.MAXID_AKHIR IS NULL,0,t5.MAXID_AKHIR) AS MAXID_AKHIR,
			IF (t5.qty_akhir IS NULL,IF (t4.STOK_AFTER<=0,0,t4.STOK_AFTER),IF (t5.qty_akhir<=0,0,t5.qty_akhir)) AS qty_akhir,
			IF (t5.nilai_akhir IS NULL,IF (((t4.NILAI_TOTAL<=0) OR (t4.STOK_AFTER<=0)),0,t4.NILAI_TOTAL),IF (((t5.nilai_akhir<=0) OR (t5.qty_akhir<=0)),0,t5.nilai_akhir)) AS nilai_akhir,IF (t5.pbf IS NULL,0,t5.pbf) AS pbf,
			IF (t5.unit_in IS NULL,0,t5.unit_in) AS unit_in,IF (t5.milik_in IS NULL,0,t5.milik_in) AS milik_in,IF (t5.rt_rsp IS NULL,0,t5.rt_rsp) AS rt_rsp,
			IF (t5.rsp IS NULL,0,t5.rsp) AS rsp,IF (t5.unit_out IS NULL,0,t5.unit_out) AS unit_out,IF (t5.rt IS NULL,0,t5.rt) AS rt,
			IF (t5.milik_out IS NULL,0,t5.milik_out) AS milik_out,IF (t5.hapus IS NULL,0,t5.hapus) AS hapus,IF (t5.adj IS NULL,0,t5.adj) AS adj 
			FROM (SELECT t1.*,t2.* FROM (SELECT DISTINCT CONCAT(ak.OBAT_ID,ak.KEPEMILIKAN_ID) AS PID1,ak.OBAT_ID,ak.KEPEMILIKAN_ID,ao.OBAT_NAMA,ake.NAMA 
			FROM a_kartustok ak INNER JOIN a_obat ao ON ak.OBAT_ID=ao.OBAT_ID 
			INNER JOIN a_kepemilikan ake ON ak.KEPEMILIKAN_ID=ake.ID LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID 
			WHERE ak.UNIT_ID=$idunit1".$fkelas.$fgolongan.$fjenis.") AS t1 LEFT JOIN 
			(SELECT CONCAT(b1.OBAT_ID,b1.KEPEMILIKAN_ID) AS PID,b1.ID AS MAXID_AKHIR,b1.STOK_AFTER AS qty_akhir,b1.NILAI_TOTAL AS nilai_akhir,
			SUM(IF (b1.UNIT_ID=17,IF (b1.tipetrans=4,IF (b1.DEBET IS NULL,0,b1.DEBET),0),IF (b1.tipetrans=0,IF (b1.DEBET IS NULL,0,b1.DEBET),0))) AS pbf, 
			SUM(IF (((b1.tipetrans=1 OR b1.tipetrans=2) AND (b1.UNIT_ID_KIRIM<>$idunit1)),IF (b1.DEBET IS NULL,0,b1.DEBET),0)) AS unit_in, 
			SUM(IF ((b1.tipetrans=2 AND b1.UNIT_ID_KIRIM=$idunit1),IF (b1.DEBET IS NULL,0,b1.DEBET),0)) AS milik_in,
			SUM(IF ((b1.tipetrans=6 OR b1.tipetrans=7),IF (b1.KREDIT IS NULL,0,b1.KREDIT * -1),0)) AS rt_rsp,
			SUM(IF (b1.UNIT_ID=17,IF (b1.tipetrans=4,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0),IF (b1.tipetrans=8,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0))) AS rsp,
			SUM(IF (b1.tipetrans=1,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS unit_out,
			SUM(IF ((b1.tipetrans=9 OR b1.tipetrans=7),IF (b1.DEBET IS NULL,0,b1.DEBET * -1),0)) AS rt,
			SUM(IF (b1.tipetrans=2,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS milik_out,
			SUM(IF (b1.tipetrans=10,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS hapus,
			SUM(IF (b1.tipetrans=5,IF (b1.DEBET-b1.KREDIT IS NULL,0,b1.DEBET-b1.KREDIT),0)) AS adj 
			FROM (SELECT ak.*,ap.UNIT_ID_KIRIM FROM a_kartustok ak LEFT JOIN a_penerimaan ap ON ak.fkid=ap.ID 
			WHERE ak.UNIT_ID=$idunit1 AND DATE(ak.TGL_ACT) BETWEEN '$tgl_d1' AND '$tgl_s1' 
			ORDER BY TGL_ACT DESC,ID DESC) AS b1 
			GROUP BY b1.OBAT_ID,b1.KEPEMILIKAN_ID) AS t2 ON t1.PID1=t2.PID) AS t5 LEFT JOIN 
			(SELECT CONCAT(t3.OBAT_ID,t3.KEPEMILIKAN_ID) AS PID2,ID AS MAXID,t3.OBAT_ID,t3.KEPEMILIKAN_ID,t3.STOK_AFTER,t3.NILAI_TOTAL FROM (SELECT * FROM a_kartustok WHERE UNIT_ID=$idunit1 AND DATE(TGL_ACT)<'$tgl_d1' ORDER BY TGL_ACT DESC,ID DESC) AS t3 GROUP BY t3.OBAT_ID,t3.KEPEMILIKAN_ID) 
			AS t4 ON t4.PID2=t5.PID1) AS t6 WHERE (t6.qty_awal>0 OR t6.qty_akhir>0 OR ((t6.pbf+t6.unit_in+t6.milik_in+t6.rt_rsp+t6.rsp+t6.unit_out+t6.rt+t6.milik_out+t6.hapus+t6.adj)>0))".$filter." 
			ORDER BY ".$sorting;
	  }

//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	$qty_akhir=$rows['qty_awal']+$rows['pbf']+$rows['unit_in']+$rows['milik_in']+$rows['rt_rsp']-$rows['rsp']-$rows['unit_out']-$rows['rt']-$rows['milik_out']-$rows['hapus']+$rows['adj'];
	$nilai_akhir1=floor($rows['nilai_akhir1']);
	//$nilai_akhir1=floor($rows['nilai_akhir']);
	if ($qty_akhir<=0){
		$qty_akhir=0;
		//$nilai_akhir1=0;
	}
	if ($nilai_akhir1<=0){
		$qty_akhir=0;
		//$nilai_akhir1=0;
	}
	$kode_obat=$rows['OBAT_KODE'];
	$worksheet->write($row, 0, $row-8, $regularFormatC);
	$worksheet->write($row, 1, $rows['OBAT_NAMA'], $regularFormat);
	$worksheet->write($row, 2, $rows['NAMA'], $regularFormatC);
	$worksheet->write($row, 3, $rows['qty_awal'], $regularFormatR);
	$worksheet->write($row, 4, floor($rows['nilai_awal1']), $regularFormatRF);
	$worksheet->write($row, 5, $rows['pbf'], $regularFormatR);
	$worksheet->write($row, 6, $rows['unit_in'], $regularFormatR);
	$worksheet->write($row, 7, $rows['milik_in'], $regularFormatR);
	$worksheet->write($row, 8, $rows['rt_rsp'], $regularFormatR);
	$worksheet->write($row, 9, $rows['rsp'], $regularFormatR);
	$worksheet->write($row, 10, $rows['unit_out'], $regularFormatR);
	$worksheet->write($row, 11, $rows['rt'], $regularFormatR);
	$worksheet->write($row, 12, $rows['milik_out'], $regularFormatR);
	$worksheet->write($row, 13, $rows['hapus'], $regularFormatR);
	$worksheet->write($row, 14, $rows['adj'], $regularFormatR);
	//$worksheet->write($row, 15, $rows['qty_akhir'], $regularFormatR);
	$worksheet->write($row, 15, $qty_akhir, $regularFormatR);
	$worksheet->write($row, 16, $nilai_akhir1, $regularFormatRF);
	$row++;
}
$worksheet->write($row, 2, "Total Saldo Awal", $regularFormatR);
$worksheet->writeBlank($row, 3, $regularFormatR);
$worksheet->mergeCells($row,2,$row,3);
$worksheet->write($row, 4, '=Sum(E10:E'.$row.')', $regularFormatRF);
$worksheet->write($row, 13, "Total Saldo Akhir", $regularFormatR);
$worksheet->writeBlank($row, 14, $regularFormatR);
$worksheet->writeBlank($row, 15, $regularFormatR);
$worksheet->mergeCells($row,13,$row,15);
$worksheet->write($row, 16, '=Sum(Q10:Q'.$row.')', $regularFormatRF);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>

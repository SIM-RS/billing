<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tglSql = $_REQUEST['tgl'];

function query($konek, $sql)
{
    $sql = mysqli_query($konek, $sql) or die(mysqli_error($konek));
    return $sql;
}

function fetch($query)
{
    $query = mysqli_fetch_assoc($query);
    return $query;
}

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//Paging,Sorting dan Filter======
//$defaultsort="ao.OBAT_NAMA,ak.NAMA";
$defaultsort="o.OBAT_NAMA,m.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$kelas=$_REQUEST['kelas'];
$golongan=$_REQUEST['golongan'];
$jenis=$_REQUEST['jenis'];
$kategori=$_REQUEST['kategori'];

convert_var($defaultsort,$sorting,$kelas,$golongan,$jenis);
convert_var($kategori);

if ($kelas=="") $fkelas=""; else{ if ($filter=="") $fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'"; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";}
if ($golongan=="") $fgolongan=""; else{ if (($filter=="")&&($fkelas=="")) $fgolongan=" WHERE o.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND o.OBAT_GOLONGAN='$golongan'";}
if ($jenis=="") $fjenis=""; else { if (($filter=="")&&($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE o.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND o.OBAT_KELOMPOK=$jenis";}
if ($kategori=="") $fkategori=""; else { if (($fkelas=="")&&($fgolongan=="")&&($fjenis=="")) $fkategori=" WHERE o.OBAT_KATEGORI=$kategori"; else $fkategori=" AND o.OBAT_KATEGORI=$kategori";}

$g1=$_REQUEST['g1'];
$k1=$_REQUEST['k1'];
$j1=$_REQUEST['j1'];
$f1=$_REQUEST['f1'];

convert_var($g1,$k1,$j1,$f1);
//===============================
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Stok_Harian_Gudang'.$tgl.'.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Stok Obat');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 10);
$worksheet->setColumn (1, 1, 35);
$worksheet->setColumn (2, 2, 12);
$worksheet->setColumn (3, 16, 10);
$worksheet->setColumn (17, 17, 13);
//$worksheet->setColumn (0, $numColumns, $columnWidth);

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>14,'align'=>'center'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>11,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'grey','pattern'=>1));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'grey','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1));
$regularFormatRF =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

/*Speadsheet writer is in format y,x (row, column)
 *  column1  |  column2 |  column3
 *   (0,0)      (0,1)      (0,2) */

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
$worksheet->write($row, 4, "LAPORAN STOK OBAT HARIAN GUDANG", $sheetTitleFormat);
$row += 1;
// $worksheet->write($row, 4, "UNIT : ALL UNIT", $sheetTitleFormat);
// $row += 1;
// $worksheet->write($row, 4, "KELAS : $k1", $sheetTitleFormat);
// $row += 1;
// $worksheet->write($row, 4, "KATEGORI : $f1", $sheetTitleFormat);
// $row += 1;
// $worksheet->write($row, 4, "GOLONGAN : $g1", $sheetTitleFormat);
// $row += 1;
// $worksheet->write($row, 4, "JENIS : $j1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 4, "TGL : ".$tgl, $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "Kode Obat", $columnTitleFormat);
$worksheet->write($row, $column+1, "Nama Obat", $columnTitleFormat);
// $worksheet->write($row, $column+2, "Expired", $columnTitleFormat);
// $worksheet->write($row, $column+3, "Batch", $columnTitleFormat);
// $worksheet->write($row, $column+4, "AP-RS", $columnTitleFormat);
$worksheet->write($row, $column+2, "Stok Gudang Sebelumnya", $columnTitleFormat);
$worksheet->write($row, $column+3, "Stok Gudang Terkini", $columnTitleFormat);
// $worksheet->write($row, $column+6, "AP-BICT", $columnTitleFormat);

// $worksheet->write($row, $column+7, "PR", $columnTitleFormat);
// $worksheet->write($row, $column+8, "FS", $columnTitleFormat);
// $worksheet->write($row, $column+5, "Harga Beli Satuan", $columnTitleFormat);
$worksheet->write($row, $column+4, "Nilai", $columnTitleFormat);
// $worksheet->write($row, $column+7, "Nilai", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;
  if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
  }
  if ($sorting=="") $sorting=$defaultsort;
 // $sql="SELECT o.OBAT_KODE,o.OBAT_NAMA AS obat,m.NAMA AS kepemilikan,v.*,unit1+unit3 AS total 
	// FROM vstokall AS v INNER JOIN (SELECT * FROM a_obat WHERE OBAT_ISAKTIF=1) AS o ON v.obat_id=o.OBAT_ID INNER JOIN a_kepemilikan AS m ON v.kepemilikan_id=m.ID 
	// LEFT JOIN a_kelas AS kls ON o.KLS_ID=kls.KLS_ID".$filter.$fkelas.$fgolongan.$fjenis.$fkategori."
	// ORDER BY ".$sorting;

	 $sql = "SELECT
     q.idobat AS obat_id,
     q.OBAT_KODE,
     q.OBAT_NAMA obat,
     q.NAMA kepemilikan,
     q.KEPEMILIKAN_ID,
     SUM( q.unit1 ) AS unit1,
     q.nilai,
     SUM( q.ntotal ) AS ntotal,
     SUM( q.total ) AS total 
 FROM
     (
     SELECT DISTINCT
         p.idobat,
         p.OBAT_KODE,
         p.OBAT_NAMA,
         ak.NAMA,
     IF
         ( p.KEPEMILIKAN_ID <> ak.ID OR p.KEPEMILIKAN_ID IS NULL, ak.ID, p.KEPEMILIKAN_ID ) AS KEPEMILIKAN_ID,
     IF
         ( p.KEPEMILIKAN_ID <> ak.ID OR p.unit1 IS NULL, 0, p.unit1 ) AS unit1,
     IF
         ( p.KEPEMILIKAN_ID <> ak.ID OR p.ntotal IS NULL, 0, p.ntotal ) AS ntotal,
     IF
         ( p.KEPEMILIKAN_ID <> ak.ID OR p.nilai_total IS NULL, 0, p.nilai_total ) AS nilai,
     IF
         ( p.KEPEMILIKAN_ID <> ak.ID OR p.total IS NULL, 0, p.total ) AS total 
     FROM
         (
         SELECT
             o.OBAT_ID AS idobat,
             o.OBAT_KODE,
             o.OBAT_NAMA,
             v.*,
             unit1 AS total 
         FROM
             ( SELECT * FROM a_obat WHERE OBAT_ISAKTIF = 1 ) AS o
             LEFT JOIN vstokhariangudang AS v ON v.obat_id = o.OBAT_ID
             LEFT JOIN a_kelas AS kls ON o.KLS_ID = kls.KLS_ID 
         ) AS p
         LEFT JOIN ( SELECT * FROM a_kepemilikan WHERE aktif = 1 ) ak ON 1 = 1 
     ) AS q 
 GROUP BY
     q.idobat,
     q.KEPEMILIKAN_ID 
 ORDER BY
     OBAT_NAMA,
     KEPEMILIKAN_ID";
   
// echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
    $sqlStok = "SELECT
                    q.idobat AS obat_id,
                    q.OBAT_NAMA obat,
                    q.STOK_BEFOR,
                    q.HARGA_BELI_SATUAN,
                    ( SELECT EXPIRED FROM a_penerimaan WHERE OBAT_ID = q.idobat ORDER BY ID DESC LIMIT 1 ) AS EXPIRED,
                    ( SELECT BATCH FROM a_penerimaan WHERE OBAT_ID = q.idobat ORDER BY ID DESC LIMIT 1 ) AS BATCH 
                FROM
                    (
                    SELECT DISTINCT
                        p.idobat,
                        p.OBAT_NAMA,
                        ak.NAMA,
                        p.STOK_BEFOR,
                        p.HARGA_BELI_SATUAN 
                    FROM
                        (
                        SELECT
                            o.OBAT_ID AS idobat,
                            o.OBAT_NAMA as obat_nama,
                            ak.STOK_BEFOR,
                            ah.HARGA_BELI_SATUAN
                        FROM
                            ( SELECT * FROM a_obat WHERE OBAT_ISAKTIF = 1 ) AS o

                            LEFT JOIN a_kelas AS kls ON o.KLS_ID = kls.KLS_ID
                            LEFT JOIN a_harga AS ah ON ah.OBAT_ID = o.OBAT_ID
                            INNER JOIN ( SELECT OBAT_ID, STOK_BEFOR FROM a_kartustok WHERE UNIT_ID = 12 AND TGL_TRANS = '{$tglSql}' ORDER BY TGL_ACT ASC ) AS ak ON ak.OBAT_ID = o.OBAT_ID 
                        ) AS p
                        JOIN ( SELECT * FROM a_kepemilikan WHERE aktif = 1 ) ak ON 1 = 1 
                    )  AS q  WHERE q.idobat = {$rows['obat_id']}
                GROUP BY
                    q.idobat 
                ORDER BY
                    q.OBAT_NAMA";
    $stok_terkini = fetch(query($konek, $sqlStok));
    $n="SELECT
            SUM( a_stok.nilai ) nilai 
        FROM
            a_stok
            INNER JOIN a_unit ON a_stok.`unit_id` = a_unit.`UNIT_ID` 
        WHERE
            a_stok.obat_id = ".$rows['obat_id']." 
            AND a_stok.kepemilikan_id = ".$rows['KEPEMILIKAN_ID']." 
            AND a_unit.unit_tipe <> 3 
            AND a_unit.UNIT_ID = 12";

// echo $sql2."<br>";
    $n1=mysqli_query($konek,$n);
    $n2=mysqli_fetch_array($n1);
    $nilai=$rows['ntotal'];
    if($nilai == '' or $nilai == NULL or $nilai == 0){
        $nilai = 0;
    }
    $stok = 0;
    // $sqlStok = "SELECT qty_stok FROM a_stok WHERE unit_id = 12 AND obat_id = '{$rows['obat_id']}'";
    // $stok_terkini = mysqli_fetch_array(mysqli_query($konek, $sqlStok));

    if($stok_terkini['STOK_BEFOR'] == '' || $stok_terkini['STOK_BEFOR'] == NULL){
        $stok = $rows['unit1'];
    }else{
        $stok = $stok_terkini['STOK_BEFOR'];
    }
	
    $kode_obat = $rows['OBAT_KODE'];
	$worksheet->write($row, 0, "'$kode_obat'", $regularFormatC);
	$worksheet->write($row, 1, $rows['obat'], $regularFormat);
    // $worksheet->write($row, 2, $rows['EXPIRED'], $regularFormat);
	// $worksheet->write($row, 3, $rows['BATCH'], $regularFormat);
    $worksheet->write($row, 2, $stok, $regularFormatR);
	$worksheet->write($row, 3, $rows['unit1'], $regularFormatR);
	// $worksheet->write($row, 4, $rows['unit2'], $regularFormatR);
	// $worksheet->write($row, 5, $rows['HARGA_BELI_SATUAN'], $regularFormatRF);
	// $worksheet->write($row, 6, $rows['unit4'], $regularFormatR);
	// $worksheet->write($row, 7, $rows['unit5'], $regularFormatR);
	// $worksheet->write($row, 8, $rows['unit6'], $regularFormatR);
	$worksheet->write($row, 4, $nilai, $regularFormatRF);
	// $worksheet->write($row, 7, $harga['HARGA_BELI_SATUAN'], $regularFormatRF);
	// $totaln = ($jml_stok == 0) ? 0 : $harga['HARGA_BELI_SATUAN'] * $jml_stok;
	// $worksheet->write($row, 7, $totaln, $regularFormatRF);
	$row++;


}
$worksheet->write($row, 3, "TOTAL", $regularFormatR);
$worksheet->write($row, 4, '=Sum(E5:E'.$row.')', $regularFormatRF);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>
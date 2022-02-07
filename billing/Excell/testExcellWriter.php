<?php
/*This require call will be different depending on how your PEAR
 *is installed. The below call works with the zipped test PEAR
 *files I have provided if your script is in the same folder as
 *the zipped PEAR folder.
 *Normally, If you have PEAR installed correctly, you would
 *use the call: require_once('../Spreadsheet/Excel/Writer.php'); */
require_once('Writer.php');
 
/* Data to be inserted into excel in an array of arrays
 * Each array is the avg monthly temp of a different city */
$data = array ( array ( "City" => "Seattle",
	"Jan" => 46, "Feb" => 50, "Mar" => 53, "Apr" => 58,
	"May" => 64, "Jun" => 70, "Jul" => 75, "Aug" => 76,
	"Sep" => 70, "Oct" => 60, "Nov" => 51, "Dec" => 46 ),
	array ( "City" => "New York",
	"Jan" => 39, "Feb" => 42, "Mar" => 50, "Apr" => 60,
	"May" => 71, "Jun" => 79, "Jul" => 85, "Aug" => 83,
	"Sep" => 76, "Oct" => 64, "Nov" => 54, "Dec" => 44 ),
	array ( "City" => "San Francisco",
	"Jan" => 56, "Feb" => 59, "Mar" => 61, "Apr" => 64,
	"May" => 67, "Jun" => 70, "Jul" => 71, "Aug" => 72,
	"Sep" => 73, "Oct" => 70, "Nov" => 62, "Dec" => 56 )
);
 
$sheetTitle = "Monthly Average High Temperature By City";
 
/*We know the keys of each sub-array are the same, so
 *extract them from the first sub-array and set them
 *to be our column titles */
$columnTitles = array_keys($data[0]);
$numColumns = count($columnTitles);
 
//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();
 
//Sending HTTP headers
$workbook->send('Search_Export.xls');
 
//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Export');
$worksheet->setLandscape();
 
//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, $numColumns, $columnWidth);
 
//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('bold'=>1,
  'size'=>10));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,
  'top'=>1,
  'bottom'=>1 ,
  'size'=>9));
$regularFormat =& $workbook->addFormat(array('size'=>9,
  'align'=>'left',
  'textWrap'=>1));
 
/*Speadsheet writer is in format y,x (row, column)
 *  column1  |  column2 |  column3
 *   (0,0)      (0,1)      (0,2) */
 
$column = 0;
$row    = 0;
 
//Write sheet title in upper left cell
$worksheet->write($row, $column, $sheetTitle, $sheetTitleFormat);
 
 
//Write column titles two rows beneath sheet title
$row += 2;
foreach ($columnTitles as $title) {
  $worksheet->write($row, $column, $title, $columnTitleFormat);
  $column++;
}
 
//Write each datapoint to the sheet starting one row beneath
$row++;
foreach ($data as $subArrayKey => $subArray) {
  //Loop through each row
  $column = 0;
  foreach ($subArray as $value) {
    //Loop through each row's columns
    $worksheet->write($row, $column, $value, $regularFormat);
    $column++;
  }
  $row++;
}
$workbook->close();
?>
<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
$iduser=$_SESSION['userId'];
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<!-- untuk ajax-->
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<!-- end untuk ajax-->
<!--dibawah ini diperlukan untuk menampilkan popup-->
<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
<script type="text/javascript" src="../theme/prototype.js"></script>
<script type="text/javascript" src="../theme/effects.js"></script>
<script type="text/javascript" src="../theme/popup.js"></script>
<!--diatas ini diperlukan untuk menampilkan popup-->
<script>
var bln = '<?php echo date('m'); ?>';
var thn = '<?php echo date('Y'); ?>';
</script>
<title>Daftar Stok Obat</title>
</head>

<body>
<div align="center">
<?php
	include("../koneksi/konek.php");
	include("../header1.php");
?>
<iframe height="72" width="130" name="sort"
id="sort"
src="../theme/dsgrid_sort.php" scrolling="no"
frameborder="0"
style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div style="display:block;">
	
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;DAFTAR STOK OBAT</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="1" cellpadding="0" align="center" class="tabel">
  <tr>
    <td width="73">&nbsp;</td>
    <td width="162">&nbsp;</td>
    <td width="150">&nbsp;</td>
    <td width="271">&nbsp;</td>
    <td width="159">&nbsp;</td>
    <td width="154">&nbsp;</td>
    <td width="73">&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td>Jenis Layanan&nbsp;</td>
    <td colspan="2">
    <select id="cmbJnsLay" class="txtinput" onchange="berubah()" >
	<?php
    $sql="SELECT distinct m.id,m.nama,m.inap FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
            where ms_pegawai_id=".$_SESSION['userId'].") as t1
            inner join b_ms_unit u on t1.unit_id=u.id
            inner join b_ms_unit m on u.parent_id=m.id WHERE m.kategori=2 order by nama";
	$sql="SELECT * FROM (SELECT DISTINCT m.id,m.nama,m.inap,m.nama AS urut FROM (SELECT DISTINCT b.unit_id FROM b_ms_pegawai_unit b
			WHERE ms_pegawai_id=".$_SESSION['userId'].") AS t1
			INNER JOIN b_ms_unit u ON t1.unit_id=u.id
			INNER JOIN b_ms_unit m ON u.parent_id=m.id 
			WHERE m.kategori=2 
			UNION
			SELECT 'far','FARMASI',0,'1' AS urut) AS gab
			ORDER BY urut";
    $rs=mysql_query($sql);
    while($rw=mysql_fetch_array($rs)) {
        ?>
    <option value="<?php echo $rw['id'];?>" lang="<?php echo $rw['inap'];?>" ><?php echo $rw['nama'];?></option>
        <?php
    }
    ?>
     </select>
     </td>
    <td>&nbsp;</td>		
    <td>&nbsp; 
    
    </td>
    <td>&nbsp;</td>
  </tr>
   <tr>
	<td>&nbsp;</td>
    <td>Tempat Layanan&nbsp;</td>
    <td colspan="2">
    <select id="cmbTmpLay" class="txtinput" onchange="refresGrid()"></select>
    </td>		
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td colspan="5">
		<div id="gridbox" style="width:100%; height:500px; background-color:white; overflow:hidden;"></div>
		<div id="paging" style="width:900px;"></div>	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
  </table>
</div>
</div>
</body>
<script>
	
	var a=new DSGridObject("gridbox");
	a.setHeader("STOK OBAT");	
	a.setColHeader("NO,KODE OBAT,NAMA OBAT,KEPEMILIKAN,STOK,MIN STOK,MAX STOK,NILAI");
	a.setIDColHeader(",OBAT_KODE,OBAT_NAMA,,,");
	a.setColWidth("50,70,280,100,100,100,100,100");
	a.setCellAlign("center,center,left,left,center,center,center,right");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowClick","ambilData");
	a.baseURL("stok_view_util.php?tmpLay=0");
	a.Init();

	
	Request('../combo_utils.php?id=cmbJnsLayStokView&value=<?php echo $_SESSION['userId'];?>','cmbJnsLay','','GET',berubah);
	function berubah(){
		Request('../combo_utils.php?id=cmbTmpLayStokView&value=<?php echo $_SESSION['userId'];?>,'+ document.getElementById('cmbJnsLay').value,'cmbTmpLay','','GET',refresGrid,'noLoad');
	}

	function goFilterAndSort(grd){
		if (grd=="gridbox"){
			a.loadURL("stok_view_util.php?unit_id="+document.getElementById('cmbTmpLay').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		}
	}
	
	function refresGrid(){
		var url="stok_view_util.php?unit_id="+document.getElementById('cmbTmpLay').value;
		a.loadURL(url,"","GET");
	}
</script>
</html>
<?php 
mysql_close($konek);
?>
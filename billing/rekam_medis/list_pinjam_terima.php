<?php
session_start();
// Koneksi =================================
include("../sesi.php"); 
include("../koneksi/konek.php");
// Get ID  =================================
$iduser=$_SESSION['userId'];
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$bulan=date('m');
$TmpLay = $_REQUEST["cmbTmpLay"];
if(!empty($TmpLay)){
	$sql= "select UNIT_KODE, UNIT_ID from $dbapotek.a_unit where unit_billing='$TmpLay'";
	$query = mysql_fetch_array(mysql_query($sql));
	$idunit = $query['UNIT_ID'];
	$kodeunit = $query['UNIT_KODE'];
}
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
var arrRange=depRange=[];
</script>
<title>Daftar Peminjaman Obat</title>
</head>

<body>
<div align="center">
<?php
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
		<td height="30">&nbsp;DAFTAR PENERIMAAN OBAT</td>
	</tr>
</table>
<div id="pilihan" style="background:#EAF0F0; width:1000px; padding-top:20px; text-align:left;">
<table style="margin-left:50px;">
	<tr>
		<td width="150px">Jenis Layanan&nbsp;:</td>
		<td>
			<select id="cmbJnsLay" class="txtinput" onchange="berubah()" >
				<?php
					$sql="SELECT distinct m.id,m.nama,m.inap FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
							where ms_pegawai_id=".$_SESSION['userId'].") as t1
							inner join b_ms_unit u on t1.unit_id=u.id
							inner join b_ms_unit m on u.parent_id=m.id WHERE m.kategori=2 order by nama";
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
		<td width="80px">Bulan :</td>
		<td>
			<select name="bulan" id="bulan" class="txtinput" onChange="refresGrid()">
				<option value="01" class="txtinput"<?php if ($bulan=="1") echo "selected";?>>Januari</option>
				<option value="02" class="txtinput"<?php if ($bulan=="2") echo "selected";?>>Pebruari</option>
				<option value="03" class="txtinput"<?php if ($bulan=="3") echo "selected";?>>Maret</option>
				<option value="04" class="txtinput"<?php if ($bulan=="4") echo "selected";?>>April</option>
				<option value="05" class="txtinput"<?php if ($bulan=="5") echo "selected";?>>Mei</option>
				<option value="06" class="txtinput"<?php if ($bulan=="6") echo "selected";?>>Juni</option>
				<option value="07" class="txtinput"<?php if ($bulan=="7") echo "selected";?>>Juli</option>
				<option value="08" class="txtinput"<?php if ($bulan=="8") echo "selected";?>>Agustus</option>
				<option value="09" class="txtinput"<?php if ($bulan=="9") echo "selected";?>>September</option>
				<option value="10" class="txtinput"<?php if ($bulan=="10") echo "selected";?>>Oktober</option>
				<option value="11" class="txtinput"<?php if ($bulan=="11") echo "selected";?>>Nopember</option>
				<option value="12" class="txtinput"<?php if ($bulan=="12") echo "selected";?>>Desember</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Tempat Layanan&nbsp;:</td>
		<td><select id="cmbTmpLay" class="txtinput" onchange="refresGrid()"></select></td>
		<td width="100px">&nbsp;</td>
		<td>Tahun :</td>
		<td>
			<select name="tahun" id="tahun" class="txtinput" onChange="refresGrid()">
				<?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
				  <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==date('Y')) echo "selected";?>><?php echo $i;?></option>
				<? }?>
			</select>
		</td>
	</tr>
</table>
</div>
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
    <td colspan="5">
		<div id="gridbox" style="width:900px; height:500px; background-color:white; overflow:hidden;"></div>
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
	function terima(no_kirim,iunit,tgl_kirim,no_terima1,isview,tgl_terima1,no_minta,id_terima){
		location="isi_terima_detail.php?no_kirim="+no_kirim+"&iunit="+iunit+"&tgl_kirim="+tgl_kirim+"&no_terima1="+no_terima1+"&isview="+isview+"&tgl_terima1="+tgl_terima1+"&no_minta="+no_minta+"&id_terima="+id_terima;
	}
	function terima2(no_kirim,isview,id_terima,tgl_terima1){
		location="isi_terima_detail.php?no_kirim="+no_kirim+"&isview="+isview+"&id_terima="+id_terima+"&tgl_terima1="+tgl_terima1;
	}
	
	var a=new DSGridObject("gridbox");
	a.setHeader("DAFTAR PENERIMAAN OBAT");	
	a.setColHeader("No,Tanggal Kirim,No Permintaan,No Kirim,Unit Pengirim,Status,Proses");
	a.setIDColHeader(",tgl1,NOKIRIM,NOTERIMA,UNIT_NAME,status,");
	a.setColWidth("50,70,280,100,100,100");
	a.setCellAlign("center,center,left,left,center,center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	//a.attachEvent("onRowClick","ambilData");
	a.baseURL("list_pinjam_terima_util.php?tmpLay=112");
	a.Init();

	
	function berubah(){
		Request('../combo_utils.php?id=cmbTmpLay&value=<?php echo $_SESSION['userId'];?>,'+ document.getElementById('cmbJnsLay').value,'cmbTmpLay','','GET',refresGrid,'noLoad');
	}

	function goFilterAndSort(grd){
		if (grd=="gridbox"){
			a.loadURL("list_pinjam_terima_util.php?unit_id="+document.getElementById('cmbTmpLay').value+"&bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('tahun').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		}
	}
	
	function refresGrid(){
		var url="list_pinjam_terima_util.php?unit_id="+document.getElementById('cmbTmpLay').value+"&bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('tahun').value;
		//alert(url);
		a.loadURL(url,"","GET");
	}
	
	berubah();
</script>
</body>
<html>
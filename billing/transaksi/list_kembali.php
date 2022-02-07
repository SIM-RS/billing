<?php
session_start();
include("../sesi.php");
$userId = $_SESSION['userId'];
if(!isset($userId) || $userId == ''){
    header('location:../index.php');
}
include '../koneksi/konek.php';
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$minta_id=$_REQUEST['minta_id'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ap.NOKIRIM desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
 	case "delete":
		$sql="delete from $dbapotek.a_minta_obat where peminjaman_id=$minta_id";
		$rs=mysql_query($sql);
		//echo $sql;
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
?>
<html>
<head>
<title>Daftar Pengembalian Obat</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link type="text/css" rel="stylesheet" href="../theme/mod.css" />
	<script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
	<script type="text/javascript" src="../theme/js/ajax.js"></script>	
</head>
<body>
<? include("../header1.php"); ?>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30" style="padding-left:5px;">DAFTAR PENGEMBALIAN OBAT</td>
	</tr>
</table>	
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="padding-left:25px; width:120px;">
			<span>Jenis Layanan : </span>
		</td>
		<td style="width:200px;">
			<select id="cmbJnsLay" class="txtinput" onChange="isiCombo('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+this.value,'','cmbTmpLay',gantiGrid);" >
				<?php
					$sql = "SELECT distinct m.id,m.nama,m.inap FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
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
		<td>
			<span>Bulan : </span> 
            <select name="bulan" id="bulan" class="txtinput" onChange="gantiGrid()">
				<option value="01" class="txtinput"<?php if ($bulan=="01") echo "selected";?>>Januari</option>
				<option value="02" class="txtinput"<?php if ($bulan=="02") echo "selected";?>>Pebruari</option>
				<option value="03" class="txtinput"<?php if ($bulan=="03") echo "selected";?>>Maret</option>
				<option value="04" class="txtinput"<?php if ($bulan=="04") echo "selected";?>>April</option>
				<option value="05" class="txtinput"<?php if ($bulan=="05") echo "selected";?>>Mei</option>
				<option value="06" class="txtinput"<?php if ($bulan=="06") echo "selected";?>>Juni</option>
				<option value="07" class="txtinput"<?php if ($bulan=="07") echo "selected";?>>Juli</option>
				<option value="08" class="txtinput"<?php if ($bulan=="08") echo "selected";?>>Agustus</option>
				<option value="09" class="txtinput"<?php if ($bulan=="09") echo "selected";?>>September</option>
				<option value="10" class="txtinput"<?php if ($bulan=="10") echo "selected";?>>Oktober</option>
				<option value="11" class="txtinput"<?php if ($bulan=="11") echo "selected";?>>Nopember</option>
				<option value="12" class="txtinput"<?php if ($bulan=="12") echo "selected";?>>Desember</option>
            </select>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="padding-left:25px;">
			<span>Tempat Layanan : </span>
		</td>
		<td>
			<select id="cmbTmpLay" class="txtinput" lang="" onchange="this.lang=this.value;gantiGrid()">
			</select>
		</td>
		<td>
            <span>Tahun : </span> 
            <select name="tahun" id="tahun" class="txtinput" onChange="gantiGrid()">
				<?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
					<option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
				<? }?>
            </select>
		</td>
		<td align="right" style="padding-right:25px;">
			<BUTTON type="button" onClick="location='obat_kembali.php'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Pengembalian Obat</BUTTON>
		</td>
	</tr>
	<tr>
		<td colspan="4" align="center" style="padding-top:10px;">
			<div id="gridbox" style="width:950px; height:350px; background-color:white; overflow:hidden;"></div>
			<div id="paging" style="width:950px;"></div>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
</div>
</body>
<script type="text/javascript">
	Request('../combo_utils.php?id=cmbTmpLay&value=<?php echo $_SESSION['userId'];?>,'+ document.getElementById('cmbJnsLay').value,'cmbTmpLay','','GET','','noLoad');
	function isiCombo(id,val,defaultId,targetId,evloaded){
		
		if(targetId=='' || targetId==undefined){
			targetId=id;
		}
		if(document.getElementById(targetId)==undefined){
			alert('Elemen target dengan id: \''+targetId+'\' tidak ditemukan!');
        }else{
			Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
		}
	}
	
	function btnProses(nokirim){
		//alert(nokirim);
		location='obat_kembali.php?no_kirim='+nokirim+'&isview=true';
	}
	function gantiGrid(){
		a.loadURL("pengembalian_obat_utils.php?grd=true&idunit="+document.getElementById('cmbTmpLay').value+"&bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('tahun').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");		
	}
	function goFilterAndSort(grd){
		if (grd=="gridbox"){	
			a.loadURL("pengembalian_obat_utils.php?grd=true&idunit="+document.getElementById('cmbTmpLay').value+"&bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('tahun').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		}
	}
	var a=new DSGridObject("gridbox");
        a.setHeader("DATA PENGEMBALIAN OBAT");
        a.setColHeader("NO,TANGGAL,NO KIRIM,UNIT TUJUAN,STATUS,PROSES");
        a.setIDColHeader(",TANGGAL,NOKIRIM,UNIT_NAME,,");
        a.setColWidth("50,100,200,250,200,100");
        a.setCellAlign("center,center,left,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        //a.attachEvent("onRowClick","ambilData");
		a.baseURL("pengembalian_obat_utils.php?grd=true&idunit="+document.getElementById('cmbTmpLay').value+"&bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('tahun').value);
		a.Init();
</script>
</html>
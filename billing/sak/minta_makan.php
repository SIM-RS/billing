<?php
session_start();
include("../sesi.php");

$date_now=gmdate('d-m-Y H:i:s',mktime(date('H')+7));
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$date_skr=explode('-',$date_now);
$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');

$userId = $_SESSION['userId'];
if(!isset($userId) || $userId == ''){
    header('location:../index.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Cache-Control" content="no-cache, must-revalidate" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
		<script type="text/JavaScript" language="JavaScript" src="../include/jquery/jquery-1.9.1.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script src="../theme/dhtmlxcalendar.js" type="text/javascript"></script>
        <!--dibawah ini diperlukan untuk menampilkan menu dropdown-->
		<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
        <script language="JavaScript" src="../theme/js/dropdown.js"></script>
        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!-- end untuk ajax-->
		<script type="text/JavaScript">
			var arrRange = depRange = [];
		</script>		
		<title>Permintaan Makan</title>
	</head>
<body onload="loadTmpLay();">
	<input type="hidden" id="txtId" name="txtId" />
	<input type="hidden" id="act" name="act" />
	<input type="hidden" id="id_pasien" name="id_pasien">
	<input type="hidden" id="id_pelayanan" name="id_pelayanan">
	<input type="hidden" id="id_kamar" name="id_kamar">
	<iframe height="193" width="168" name="gToday:normal:agenda.js"
		id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
		style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
	</iframe>
	<iframe height="72" width="130" name="sort"
		id="sort" src="../theme/dsgrid_sort.php" scrolling="no" frameborder="0"
		style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
	</iframe>
<div align="center">
	<?php 	
		include("../koneksi/konek.php");
		include("../header1.php");
	?>
	<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
		<tr>
			<td height="30">&nbsp;PERMINTAAN MAKAN</td>
		</tr>
	</table>
	<table width="1000" align="center" cellpadding="0" cellspacing="0" class="tabel">
	<tr>
	<td>
		<table border="0" cellpadding="0" cellspacing="0" class="tabel" width="972" align="center">
			<tr>
				<td>
					<fieldset>
						<legend style="color:#0033FF;" align="center">RUANG</legend>
						<table width="800">
							<tr>
								<td width="110">Tanggal</td>
								<td width="10">:</td>
								<td>
									<input type="text" id="tanggal" name="tanggal" class="txtcenter" size="10" value="<?php echo date('d-m-Y'); ?>" onchange="reloadGrid();" />&nbsp;&nbsp;
									<img src="../icon/archive1.gif" width="20" align="absmiddle" style="cursor:pointer; vertical-align:middle" onclick="gfPop.fPopCalendar(document.getElementById('tanggal'),depRange,reloadGrid);" />
								</td>
								<td></td>
							</tr>
							<tr>
								<td width="100">Jenis Layanan</td>
								<td>:</td>
								<td> 	
									<select id="JnsLayanan" name="JnsLayanan" onchange="isiCombo('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+this.value,'','cmbTmpLay',reloadGrid);" class="txtinput">
										<?php
											$query = "select id,nama from b_ms_unit where aktif=1 and level=1 and inap = 1";
											$rs = mysql_query($query);
											while($row=mysql_fetch_array($rs)){
										?>
											<option value="<?php echo $row['id'];?>"><?php echo $row['nama']; ?></option>
										<?php
											}
										?>
									</select>
								</td>
								<td></td>
							</tr>
							<tr>
								<td width="100">Tempat Layanan </td><td>:</td>
								<td width="400"> 
									<select name="cmbTmpLay" id="cmbTmpLay" tabindex="27" class="txtinput" onchange="reloadGrid()"></select>
								</td>
								<td align="right" width="300">
									<button onclick="showReport()">
										<img src="../icon/printButton.jpg" align="absmiddle" width="25" height="25" />&nbsp;Cetak Permintaan Makan
									</button>
								</td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td align="left" width="320" colspan="2">
					<fieldset>				
					<legend style="color:#0033FF;" align="center">DAFTAR PERMINTAAN MAKAN PASIEN</legend>
					<input type="hidden" id="id" name="id" />
					<div id="gridboxPasien" style="width:943px; height:330px; background-color:white; overflow:hidden;"></div>
					<div id="pagingPasien" style="width:943px; display:block;"></div>	
				</td>
            </tr>
		</table>
</div>
<div id="popGrPet" style="display:none; width:429px" class="popup">
	<div align="right"><img src="../icon/close.png" align="absmiddle" class="popup_closebox" style="cursor:pointer"></div>
	<table width="409" align="center" cellpadding="3" cellspacing="0">
		<tr style="display:none">
			<td width="159">Tanggal</td>
			<td width="248">
				<input type="text" id="tgl" name="tgl" size="10" value="<?php echo date('d-m-Y'); ?>" />&nbsp;&nbsp;
				<img src="../icon/archive1.gif" width="20" align="absmiddle" style="cursor:pointer; vertical-align:middle" onclick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" />
			</td>
		</tr>
		<tr>
			<td>Jenis Makanan</td>
			<td>
				<input type="hidden" id="id_makan" name="id_makan">
				<input type="hidden" id="pasiso" name="pasiso">
				<select id="makanan" name="makanan">
					<?php
						$j="SELECT id,kode,nama from $dbgizi.gz_ms_menu_jenis";
						$kueri=mysql_query($j);
						while($row=mysql_fetch_array($kueri)){
					?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
					<?php
						}
					?>
				</select>
			</td>
		</tr>
		<tr id="trNoBed" style="visibility:collapse">
			<td>No Bed</td>
			<td><select name="bed" id="bed"></select></td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td><textarea id="ket" name="ket"></textarea></td>
		</tr>
		<tr>
			<td height="50" valign="bottom" colspan="2" align="center">
				<button id="sim" name="sim" value="simpan" type="button" style="cursor:pointer" class="popup_closebox" onclick="act()">
					<img src="../images/cek.png" width="20" align="absmiddle" />&nbsp;&nbsp;OK&nbsp;&nbsp;
				</button>&nbsp;&nbsp;
				<button id="del" name="del" value="delete" type="button" style="cursor:pointer" class="popup_closebox" onclick="del()">
					<img src="../images/remove.png" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus&nbsp;&nbsp;
				</button>
			</td>
		</tr>
	</table>
</div>
</body>
</html>
<script>
var nobed='';
function isiCombo(id,val,defaultId,targetId,evloaded){
	if(targetId=='' || targetId==undefined){
		targetId=id;
	}
	Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',reloadGrid);
}
function loadTmpLay(){
	isiCombo('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+document.getElementById('JnsLayanan').value,'','cmbTmpLay',reloadGrid);
}
function isiBad(id_kamar,val){
	isiCombo3('cmbBad',id_kamar+','+val,'','bed');
}		
function isiCombo3(id,val,defaultId,targetId,evloaded,targetWindow){
	if(targetId=='' || targetId==undefined){
		targetId=id;
	}
	//alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'',parent.window);
	Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId+'&loop1=1',targetId,'','GET',evloaded,'',parent.window);
}

function reloadGrid(){
	//alert('pasien_util.php?tanggal='+document.getElementById('tanggal').value+"&unitId="+document.getElementById('cmbTmpLay').value);
	pas.loadURL('pasien_util.php?tanggal='+document.getElementById('tanggal').value+"&unitId="+document.getElementById('cmbTmpLay').value,"","GET");
}	
function popup1(){
	if(document.getElementById('id_makan').value==''){
		document.getElementById('sim').innerHTML='<img src="../images/cek.png" width="20" align="absmiddle" />&nbsp;&nbsp;OK&nbsp;&nbsp;';
		document.getElementById('act').value='simpan';
		document.getElementById('del').style.display = 'none';
	}
	else{
		document.getElementById('sim').innerHTML='<img src="../images/cek.png" width="20" align="absmiddle" />&nbsp;&nbsp;Update&nbsp;&nbsp;';
		document.getElementById('act').value='update';
		document.getElementById('del').style.display = 'table-row';
	}
	new Popup('popGrPet',null,{modal:true,position:'center',duration:1});
	document.getElementById('popGrPet').popup.show();
}
function showReport(){

	var id_pelayanan = document.getElementById('JnsLayanan').value;
	var id_kamar = document.getElementById('cmbTmpLay').value;
	var tgl=document.getElementById('tanggal').value;
	//window.open('lap_minta_mkn.php?id_pasien='+id_pasien+'&no_rm='+id_kamar+'&tgl='+tgl+'&JnsLay='+JnsLayanan+'&TmpLay='+cmbTmpLay);
	window.open('lap_minta_makan.php?unit_id='+document.getElementById('cmbTmpLay').value+'&tgl='+tgl+'&id_pelayanan='+id_pelayanan+'&id_kamar='+id_kamar);

}


var pas = new DSGridObject("gridboxPasien");
pas.setHeader("DATA PASIEN",false);
pas.setColHeader("NO RM,NAMA PASIEN,DIAGNOSA,KELAS,KAMAR - BED,PAGI,SIANG,SORE");
pas.setIDColHeader("no_rm,pasien,DIAGNOSA,KELAS,KAMAR,PAGI,SIANG,SORE");
pas.setColWidth("70,150,120,50,110,125,125,125");
pas.setCellAlign("center,left,left,center,left,center,center,center");
pas.setCellType("txt,txt,txt,txt,txt,txt,txt,txt");
pas.setCellHeight(30);
pas.setImgPath("../icon");
pas.setIDPaging("pagingPasien");
pas.attachEvent("onRowClick","ambilPasien");
pas.baseURL("pasien_util.php?unitId=0");
pas.Init();

function pagi(id_pasien,id_kamar){
	var isi = document.getElementById('pagi_'+id_pasien).lang;
	var data = isi.split('|');
	document.getElementById('pasiso').value=1;
	document.getElementById('id_makan').value=data[2];
	document.getElementById('makanan').value=data[0];
	//document.getElementById('bed').value=data[3];
	var kete = data[1].replace("(","");
	kete = kete.replace(")","");
	document.getElementById('ket').value=kete;
	isiBad(id_kamar,data[3]);
	popup1();
}

function siang(id_pasien,id_kamar,id_kelas){
	var isi = document.getElementById('siang_'+id_pasien).lang;
	var data = isi.split('|');
	document.getElementById('pasiso').value=2;
	document.getElementById('id_makan').value=data[2];
	document.getElementById('makanan').value=data[0];
	//document.getElementById('bed').value=data[3];
	var kete = data[1].replace("(","");
	kete = kete.replace(")","");
	document.getElementById('ket').value=kete;
	isiBad(id_kamar,data[3]);
	popup1();
}

function sore(id_pasien,id_kamar,id_kelas){
	var isi = document.getElementById('sore_'+id_pasien).lang;
	var data = isi.split('|');
	document.getElementById('pasiso').value=3;
	document.getElementById('id_makan').value=data[2];
	document.getElementById('makanan').value=data[0];
	//document.getElementById('bed').value=data[3];
	var kete = data[1].replace("(","");
	kete = kete.replace(")","");
	document.getElementById('ket').value=kete;
	isiBad(id_kamar,data[3]);
	popup1();
}

function ambilPasien(){
	var sisipan=pas.getRowId(pas.getSelRow()).split("|");
	document.getElementById("id_pasien").value=sisipan[0];
	document.getElementById("id_pelayanan").value=sisipan[1];
	document.getElementById("id_kamar").value=sisipan[2];
	//document.getElementById("nobed").value=sisipan[4];
	nobed=sisipan[4];
	//alert(pas.getRowId(pas.getSelRow()));
}

var cmbUtilsURL='../combo_utils.php';
	
var userIdAskep = '<?php echo $userIdAskep; ?>';
function isicmbTmpLay(){
	//alert('masuk');
	CmbChange("JnsLayanan",document.getElementById("JnsLayanan").value);
}

function del(){
	if(confirm('Are you sure?')){
		var id=document.getElementById('id_makan').value;
		var tambahan = "act=hapus&id="+id;
		pas.loadURL('pasien_util.php?tanggal='+document.getElementById('tanggal').value+"&unitId="+document.getElementById('cmbTmpLay').value+"&"+tambahan,"","GET");
		//alert('pasien_util.php?tanggal='+document.getElementById('tanggal').value+"&unitId="+document.getElementById('cmbTmpLay').value+"&"+tambahan);
	}
}

function  act(){
		var par = document.getElementById('act').value;
	
		var id=document.getElementById('id_makan').value;
		var id_pel=document.getElementById('id_pelayanan').value;
		var id_pas=document.getElementById('id_pasien').value;
		var id_kamar=document.getElementById('id_kamar').value;
		var tgl=document.getElementById('tgl').value;
		var makanan=document.getElementById('makanan').value;
		var ket=document.getElementById('ket').value;
		//var bed=document.getElementById('bed').value;
		var bed=nobed;
		var pasiso=document.getElementById('pasiso').value;
		
		var tambahan = "act="+par+"&id_pel="+id_pel+"&id_pas="+id_pas+"&id_kamar="+id_kamar+"&tgl="+tgl+"&makanan="+makanan+"&ket="+ket+"&id="+id+"&pasiso="+pasiso+"&bed="+bed;
		//alert('pasien_util.php?tanggal='+document.getElementById('tanggal').value+"&unitId="+document.getElementById('cmbTmpLay').value+"&"+tambahan);
		pas.loadURL('pasien_util.php?tanggal='+document.getElementById('tanggal').value+"&unitId="+document.getElementById('cmbTmpLay').value+"&"+tambahan,"","GET");
}

function goFilterAndSort(grd){
if (grd=="gridboxPasien"){			
	pas.loadURL("pasien_util.php?tanggal="+document.getElementById('tanggal').value+"&unitId="+document.getElementById('cmbTmpLay').value+"&filter="+pas.getFilter()+"&sorting="+pas.getSorting()+"&page="+pas.getPage(),"","GET");
	}
}
</script>


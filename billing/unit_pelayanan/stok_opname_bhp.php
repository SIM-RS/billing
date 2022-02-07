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
<title>Stok Opname BHP</title>
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
		<td height="30">&nbsp;STOK OPNAME BHP</td>
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
    <td>&nbsp;
    
    </td>
    <td>Bulan</td>		
    <td> 
    <?php
	$bulan=date('m');
	?>
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
    <td>&nbsp;</td>
  </tr>
   <tr>
	<td>&nbsp;</td>
    <td>Tempat Layanan&nbsp;</td>
    <td>
    <select id="cmbTmpLay" class="txtinput" onchange="refresGrid()"></select>
    </td>
    <td>&nbsp;
    
    </td>		
    <td>Tahun</td>
    <td>
    <select name="ta" id="ta" class="txtinput" onChange="refresGrid()">
            <?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
              <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==date('Y')) echo "selected";?>><?php echo $i;?></option>
            <? }?>
    </select>
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <tr>
	<td colspan="6" align="right"><button type="button" id="btnTambah" onclick="isiStokOpname()" style="cursor:pointer"><img src="../icon/add.gif" width="20" align="absmiddle" />&nbsp;Tambah</button>&nbsp;<button type="button" id="btnLap" onclick="cetakLap()" style="cursor:pointer"><img src="../icon/printButton.png" width="20" align="absmiddle" />&nbsp;Cetak Laporan</button></td>
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

<div id="stokOp" style="display:none" class="popup">
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 265px; top: 80px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="" style="float:right; cursor: pointer" />
<table width="500" border="0" cellspacing="1" cellpadding="0" align="center">
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
 <tr>
  <td width="50">&nbsp;</td>
  <td width="200">Nama Obat</td>
  <td width="10">:</td>
  <td><input name="sdh_so" id="sdh_so" type="hidden" value=""><input name="obat_id" id="obat_id" type="hidden" value=""><input type="text" name="obat_nama" id="obat_nama" class="txtinput" size="30" onKeyUp="suggest(event,this);" autocomplete="off" /> 
  </td>
  <td width="10">&nbsp;</td>
</tr>
<tr> 
<td>&nbsp;</td>
  <td>Kepemilikan</td>
  <td>:</td>
  <td ><select name="kepemilikan_id" id="kepemilikan_id" class="txtinput">
      <?
  $qry="select * from $dbapotek.a_kepemilikan where aktif=1";
  $exe=mysql_query($qry);
  while($show=mysql_fetch_array($exe)){ 
  ?>
      <option value="<?php echo $show['ID'];?>" class="txtinput"> 
      <?php echo $show['NAMA'];?></option>
      <? }?>
    </select></td>
    <td>&nbsp;</td>
</tr>
<tr> 
<td>&nbsp;</td>
  <td>Stok Opname</td>
  <td>:</td>
  <td ><input name="stok" type="text" class="txtcenter" id="stok" size="8" maxlength="11" ></td>
  <td>&nbsp;</td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr> 
   <td colspan="5" align="center"><button type="button" id="btnSimpan" value="edit" onclick="act(this.value);">Simpan</button>&nbsp;&nbsp;<button type="button" id="btnBatal" onclick="batal()">Batal</button></td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
</table>
</div>
</body>
<script>
	
	var a=new DSGridObject("gridbox");
	a.setHeader("STOK OPNAME BHP");	
	a.setColHeader("NO,KODE OBAT,NAMA OBAT,KEPEMILIKAN,STOK,ADJUST,SDH STOK OPNAME,PROSES");
	a.setIDColHeader(",OBAT_KODE,OBAT_NAMA,,,");
	a.setColWidth("30,50,160,70,70,80,70,70");
	a.setCellAlign("center,center,left,left,right,center,center,center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowClick","ambilData");
	//a.onLoaded(cekData);
	a.baseURL("stok_opname_bhp_util.php?tmpLay=0&bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('ta').value);
	//alert("stok_opname_bhp_util.php?tmpLay=0&bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('ta').value);
	a.Init();

function act(ac){
	var url="stok_opname_bhp_util.php?tmpLay="+document.getElementById('cmbTmpLay').value+"&bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('ta').value;
	var tambahan="&iduser=<?php echo $iduser; ?>&act="+ac+"&obat_id="+document.getElementById('obat_id').value+"&kepemilikan_id="+document.getElementById('kepemilikan_id').value+"&stok="+document.getElementById('stok').value+"&sdh_so="+document.getElementById('sdh_so').value;
	url = url + tambahan;
	//alert(url);
	a.loadURL(url,"","GET");
	document.getElementById('stokOp').popup.hide();
}

var RowIdx;
var fKeyEnt;
function suggest(e,par){
var keywords=par.value;//alert(keywords);
	if(keywords==""){
		document.getElementById('divobat').style.display='none';
	}else{
		var key;
		if(window.event) {
		  key = window.event.keyCode; 
		}
		else if(e.which) {
		  key = e.which;
		}
		//alert(key);
		if (key==38 || key==40){
			var tblRow=document.getElementById('tblObat').rows.length;
			if (tblRow>0){
				//alert(RowIdx);
				if (key==38 && RowIdx>0){
					RowIdx=RowIdx-1;
					document.getElementById(RowIdx+1).className='itemtableReq';
					if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
				}else if (key==40 && RowIdx<tblRow){
					RowIdx=RowIdx+1;
					if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
					document.getElementById(RowIdx).className='itemtableMOverReq';
				}
			}
		}else if (key==13){
			if (RowIdx>0){
				if (fKeyEnt==false){
					fSetObat(document.getElementById(RowIdx).lang);
				}else{
					fKeyEnt=false;
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			RowIdx=0;
			fKeyEnt=false;
			Request('daftarobat.php?aKeyword='+keywords , 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}

function fSetObat(par){
	var cdata=par.split("*|*");
	document.getElementById('obat_id').value=cdata[1];
	document.getElementById('obat_nama').value=cdata[2];	
	document.getElementById('divobat').style.display='none';
}

function batal(){
	document.getElementById('obat_id').value='';
	document.getElementById('obat_nama').value='';
	document.getElementById('kepemilikan_id').value='5';
	document.getElementById('stok').value='';
	document.getElementById('sdh_so').value='0';
	document.getElementById('stokOp').popup.hide();
}

function isiStokOpname(){
	document.getElementById('obat_id').value='';
	document.getElementById('obat_nama').value='';
	document.getElementById('kepemilikan_id').value='5';
	document.getElementById('stok').value='';
	document.getElementById('sdh_so').value='0';
	document.getElementById('obat_nama').disabled='';
	//document.getElementById('kepemilikan_id').disabled='false';
	document.getElementById('btnSimpan').value='save';
	new Popup('stokOp',null,{modal:true,position:'center',duration:1});
	document.getElementById('stokOp').popup.show();
}

function showPop(baris){
	if(bln!=document.getElementById('bulan').value || thn!=document.getElementById('ta').value){
		alert('Data Stok Opname Terdahulu Tidak Boleh Diubah !');
		return false;
	}
	
	var sisip=a.getRowId(baris).split('|');
	document.getElementById('obat_id').value=sisip[0];
	document.getElementById('obat_nama').value=a.cellsGetValue(baris,3);
	document.getElementById('kepemilikan_id').value=sisip[1];
	document.getElementById('stok').value=sisip[2];
	document.getElementById('sdh_so').value=sisip[3];
	document.getElementById('obat_nama').disabled='true';
	//document.getElementById('kepemilikan_id').disabled='false';
	document.getElementById('btnSimpan').value='edit';
	new Popup('stokOp',null,{modal:true,position:'center',duration:1});
	document.getElementById('stokOp').popup.show();
}
	
	function berubah(){
		Request('../combo_utils.php?id=cmbTmpLayStokOpname&value=<?php echo $_SESSION['userId'];?>,'+ document.getElementById('cmbJnsLay').value,'cmbTmpLay','','GET',refresGrid,'noLoad');
	}

	function goFilterAndSort(grd){
		if (grd=="gridbox"){
			a.loadURL("stok_opname_bhp_util.php?tmpLay="+document.getElementById('cmbTmpLay').value+"&bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('ta').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		}
	}
	
	function refresGrid(){
	var url="stok_opname_bhp_util.php?tmpLay="+document.getElementById('cmbTmpLay').value+"&bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('ta').value;
		a.loadURL(url,"","GET");
		//alert(url);
		if(bln!=document.getElementById('bulan').value || thn!=document.getElementById('ta').value){
			document.getElementById('btnTambah').disabled = 'true';
		}
		else{
			document.getElementById('btnTambah').disabled = '';
		}
	}
	
	function cetakLap(){
		window.open("lap_stok_opname_bhp.php?jnsLay="+document.getElementById('cmbJnsLay').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('ta').value,"","GET");
	}
	
	berubah();	
</script>
</html>
<?php 
mysql_close($konek);
?>
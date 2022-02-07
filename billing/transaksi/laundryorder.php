<?php 
//session_start();
include("../sesi.php");
?>
<?php
//session_start();
include("../koneksi/konek.php");
$userIdLaundry=$_SESSION['userId'];
//if ($userIdLaundry==""){
	//header("location:index.php?err=Silahkan Login Terlebih Dahulu !");
//}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../theme/popup.js"></script>
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<link type="text/css" rel="stylesheet" href="../default.css"/>
<link type="text/css" rel="stylesheet" href="../include/jquery/themes/base/ui.all.css"/>
<!-------------------------------------------------------------------->
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
<script type="text/javascript" src="../theme/js/tab-view.js"></script>
<link rel="STYLESHEET" type="text/css" href="../theme/codebase/dhtmlxtabbar.css">
<script  src="../theme/codebase/dhtmlxcommon.js"></script>
<script  src="../theme/codebase/dhtmlxtabbar.js"></script>
<script type="text/javascript" src="../jquery.js"></script>
<!--<script type="text/javascript" src="../menu.js"></script>-->

<script src="../include/jquery/ui/jquery.ui.core.js"></script>
<script src="../include/jquery/ui/jquery.ui.widget.js"></script>
<script src="../include/jquery/external/jquery.bgiframe-2.1.2.js"></script>
<script src="../include/jquery/ui/jquery.ui.mouse.js"></script>
<script src="../include/jquery/ui/jquery.ui.draggable.js"></script>
<script src="../include/jquery/ui/jquery.ui.position.js"></script>
<script src="../include/jquery/ui/jquery.ui.resizable.js"></script>
<script src="../include/jquery/ui/jquery.ui.dialog.js"></script>
<script src="../include/jquery/ui/jquery.ui.tabs.js"></script>
<script src="../include/jquery/ui/jquery.ui.autocomplete.js"></script>
<script src="../js/jquery.form.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laundry</title>
</head>

<body>
 <script type="text/JavaScript">
                var arrRange = depRange = [];
				</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
                    id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                    style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
<iframe height="72" width="130" name="sort"
id="sort"
src="../theme/dsgrid_sort.php" scrolling="no"
frameborder="0"
style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
<?php 
include("../header1.php");
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
    $th=explode("-",$tgl);
?>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;LAUNDRY</td>
                </tr>
            </table>
<table width="1000" align="center" cellpadding="0" cellspacing="0" class="tabel">
<tr><td>&nbsp;</td></tr>
<tr>
	<td  align="center">
	<?php
$z=mysql_num_rows(mysql_query("select * from b_ms_group_petugas where ms_group_id=55 and ms_pegawai_id='".$_SESSION['userId']."'"));
	//ms_group_id=6  ->  Hanya petugas CSSD Laundry yg bisa buka
	if($z==1){?>

<table width="959" align="center" cellpadding="0" cellspacing="0" class="tbl">
	<tr>
		<td>&nbsp;</td>
	</tr>
    <tr>
    <td colspan="2" style="padding-left:20px;font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;">
    
                        <fieldset style="width: 200px;display:inline-table;">
                            <legend>
                                Bulan<span style="padding-left: 50px; color: #fcfcfc;">&ensp;</span>Tahun
                            </legend>
                            <select style="width:100px; height:25px;" id="blnZ" name="blnZ" onchange="filterZ()" class="txtinputreg">
                                <option value="1" <?php echo $th[1]==1?'selected="selected"':'';?> >Januari</option>
                                <option value="2" <?php echo $th[1]==2?'selected="selected"':'';?> >Februari</option>
                                <option value="3" <?php echo $th[1]==3?'selected="selected"':'';?> >Maret</option>
                                <option value="4" <?php echo $th[1]==4?'selected="selected"':'';?> >April</option>
                                <option value="5" <?php echo $th[1]==5?'selected="selected"':'';?> >Mei</option>
                                <option value="6" <?php echo $th[1]==6?'selected="selected"':'';?> >Juni</option>
                                <option value="7" <?php echo $th[1]==7?'selected="selected"':'';?> >Juli</option>
                                <option value="8" <?php echo $th[1]==8?'selected="selected"':'';?> >Agustus</option>
                                <option value="9" <?php echo $th[1]==9?'selected="selected"':'';?> >September</option>
                                <option value="10" <?php echo $th[1]==10?'selected="selected"':'';?> >Oktober</option>
                                <option value="11" <?php echo $th[1]==11?'selected="selected"':'';?> >Nopember</option>
                                <option value="12" <?php echo $th[1]==12?'selected="selected"':'';?> >Desember</option>
                            </select>&nbsp;
                            <select style="width:70px; height:25px;"  id="thnZ" name="thnZ" onchange="filterZ()" class="txtinputreg">
                                <?php
                                for ($i=($th[2]-5);$i<($th[2]+3);$i++) {
                                    ?>
                                <option value="<?php echo $i; ?>" class="txtinput" <?php if ($i==$th[2]) echo "selected";?>><?php echo $i;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </fieldset>&nbsp;&nbsp;
                        <fieldset id="fldBayar" style="width: 155px;display:inline-table;">
                            <legend>
                                Status
                            </legend>
                            <select style="width:100px; height:25px;" id="stOrdZ" name="stOrdZ" onchange="filterZ()" class="txtinputreg">
                                <option value="">Semua&nbsp;</option>
                                <option value="0">Permohonan&nbsp;</option>
                                <option value="1">Proses&nbsp;</option>
                                <option value="2">Selesai&nbsp;</option>
                            </select>
                        </fieldset>
                        <br/><br/>
                    </td>
    </tr>
    
	<tr>
		<td>
			<input type="hidden" id="idPtgsZ" name="idPtgsZ" value="<?=$_SESSION['userId']?>" />        
			<!--<input type="hidden" id="id2" name="id2" />
            <input type="hidden" id="status_jo2" name="status_jo2" />
            <input type="hidden" id="tglSelesai2" name="tglSelesai2" />
            <input type="hidden" id="kdWo2" name="kdWo2" />
            <input type="hidden" id="nmUnit2" name="nmUnit2" />
            <input type="hidden" id="nmBrg2" name="nmBrg2" />
            <input type="hidden" id="idZ" name="idZ" />
            <input type="hidden" id="status_joZ" name="status_joZ" />
            <input type="hidden" id="tglSelesai" name="tglSelesai" />
            <input type="hidden" id="kdWo" name="kdWo" />
            <input type="hidden" id="nmUnit" name="nmUnit" />
            <input type="hidden" id="nmBrg" name="nmBrg" />-->
            <div id="gridboxZ" style="width:900px; height:300px; background-color:white; overflow:hidden; margin:auto;"></div>
			<div id="pagingZ" style="width:900px; display:block; margin:auto;"></div>

		</td>
	</tr>
	</table>

<?php }else{?>

<table width="959" align="center" cellpadding="0" cellspacing="0" class="tbl">
	<tr>
		<td width="957" align="center">
			<fieldset style="width:880px; margin:auto;">
			<table width="565" align="center" cellpadding="3" cellspacing="0">
			<tr>
				<td width="125">Nomor JO</td>
				<td width="426">
<?php
$q="SELECT MAX(IF(no_jo IS NULL,0,no_jo))+1 AS no_jo FROM $dbcssd.cssd_job_order";
$s=mysql_query($q);
$cmkode=1;
if ($rows=mysql_fetch_array($s))
{
	$cmkode=$rows["no_jo"];
}
$mkode=$cmkode;
for ($i=0;$i<(8-strlen($cmkode));$i++)
{
	$mkode="0".$mkode;
}
?>
				<input type="hidden" id="idOrder" name="idOrder" />
				<input type="text" id="kdOrder" name="kdOrder" size="7" value="<?=$mkode;?>" readonly="true"/><input type="hidden" id="kdOrder2" name="kdOrder2" size="7" />
				</td>
			</tr>
			<tr>
				<td>Tanggal</td>
				<td>
				<input type="text" id="tglOrder" name="tglOrder" size="10" readonly="true" value="<?=date('d-m-Y')?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglOrder'),depRange);"/>				</td>
			</tr>
			
			<!--<tr>
				<td>Tipe Job Order</td>
				<td>
				<select name="tipeOrder" id="tipeOrder">
				  <option value="0">Alat Kedokteran</option>
				  <option value="1">Pakaian, Sprei, Selimut, dsb</option>
                
                </select>
				</td>
			</tr>-->
			<tr>
				<td>Nama Unit</td>
				<td>
				<select name="idUnit" id="idUnit" style="width:200px;">
                      <?php
                $qry = "SELECT 
    mu.id,
    mu.kode,
    mu.nama 
  FROM
    b_ms_unit mu 
    INNER JOIN b_ms_pegawai_unit pu 
      ON pu.unit_id = mu.id  
  WHERE mu.islast = 1 
    AND mu.level = 2 
    AND mu.kategori = 2
    AND mu.inap=1
    AND mu.aktif=1
    AND pu.ms_pegawai_id = '".$_SESSION['userId']."'";
                $exe = mysql_query($qry);
                while($show= mysql_fetch_array ($exe)){
                ?>
                      <option value="<?=$show['id'];?>"> 
                      <?=$show['nama'];?>
                      </option>
                      <? }?>
                    </select></td>
			</tr>
            <tr>
				<td>Nama Laundry</td>
				<td>
				<input id="idAlat" name="idAlat" size="10" type="hidden" /><!--<input type="text" id="kdAlat" name="kdAlat" size="20" readonly="true" />--><input type="text" id="nmAlat" name="nmAlat" style="width:200px;" />
				</td>
			</tr>
            <!--<tr>
				<td>Status</td>
				<td>
				<select name="statusOrder" id="statusOrder">
				  <option value="0">Permohonan</option>
				  <option value="1">Proses</option>
                  <option value="2">Selesai</option>
                </select>
				</td>
			</tr>-->
            <tr>
				<td>Jumlah</td>
				<td>
				<input type="text" id="jmlh" name="jmlh" size="5" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
				<button type="button" id="save" name="save" value="simpan2" onclick="act1(this.value)" style="cursor:pointer"><img src="../icon/save.gif" width="25" height="25" align="absmiddle" />&nbsp;Tambah</button>&nbsp;&nbsp;
			<button type="button" id="batal" name="batal" style="cursor:pointer" onclick="kosong()"><img src="../icon/back.png" width="25" height="25" align="absmiddle" />&nbsp;Batal</button>&nbsp;&nbsp;
			<button type="button" id="delete" name="delete" onclick="del()" disabled="disabled" style="cursor:pointer"><img src="../icon/delete2.gif" width="25" height="25" align="absmiddle" />&nbsp;Hapus</button></td>
			</tr>
			</table>
			</fieldset>
		</td>
	</tr>
    <tr>
    <td colspan="2" style="padding-left:20px;font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;">
    
                        <fieldset style="width: 200px;display:inline-table;">
                            <legend>
                                Bulan<span style="padding-left: 50px; color: #fcfcfc;">&ensp;</span>Tahun
                            </legend>
                            <select style="width:100px; height:25px;" id="bln" name="bln" onchange="filter()" class="txtinputreg">
                                <option value="1" <?php echo $th[1]==1?'selected="selected"':'';?> >Januari</option>
                                <option value="2" <?php echo $th[1]==2?'selected="selected"':'';?> >Februari</option>
                                <option value="3" <?php echo $th[1]==3?'selected="selected"':'';?> >Maret</option>
                                <option value="4" <?php echo $th[1]==4?'selected="selected"':'';?> >April</option>
                                <option value="5" <?php echo $th[1]==5?'selected="selected"':'';?> >Mei</option>
                                <option value="6" <?php echo $th[1]==6?'selected="selected"':'';?> >Juni</option>
                                <option value="7" <?php echo $th[1]==7?'selected="selected"':'';?> >Juli</option>
                                <option value="8" <?php echo $th[1]==8?'selected="selected"':'';?> >Agustus</option>
                                <option value="9" <?php echo $th[1]==9?'selected="selected"':'';?> >September</option>
                                <option value="10" <?php echo $th[1]==10?'selected="selected"':'';?> >Oktober</option>
                                <option value="11" <?php echo $th[1]==11?'selected="selected"':'';?> >Nopember</option>
                                <option value="12" <?php echo $th[1]==12?'selected="selected"':'';?> >Desember</option>
                            </select>&nbsp;
                            <select style="width:70px; height:25px;"  id="thn" name="thn" onchange="filter()" class="txtinputreg">
                                <?php
                                for ($i=($th[2]-5);$i<($th[2]+3);$i++) {
                                    ?>
                                <option value="<?php echo $i; ?>" class="txtinput" <?php if ($i==$th[2]) echo "selected";?>><?php echo $i;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </fieldset>&nbsp;&nbsp;
                        <fieldset id="fldBayar" style="width: 155px;display:inline-table;">
                            <legend>
                                Status
                            </legend>
                            <select style="width:100px; height:25px;" id="stOrd" name="stOrd" onchange="filter()" class="txtinputreg">
                                <option value="">Semua&nbsp;</option>
                                <option value="0">Permohonan&nbsp;</option>
                                <option value="1">Proses&nbsp;</option>
                                <option value="2">Selesai&nbsp;</option>
                            </select>
                        </fieldset>
                        <br/><br/>
                    </td>
    </tr>
    
	<tr>
		<td>
			<input type="hidden" id="idPtgs" name="idPtgs" value="<?=$_SESSION['userId']?>" />        
			<input type="hidden" id="id2" name="id2" />
            <input type="hidden" id="id" name="id" />
			<div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden; margin:auto;"></div>
			<div id="paging" style="width:900px; display:block; margin:auto;"></div>
		</td>
	</tr>
	</table>

<?php }?>
	</td>
</tr>
<!--<tr>
		<td colspan="2" align="center" width="1024" height="50" class="h1" bgcolor="#FFFFFF"><img src="../images/home_03.png"></td>
  </tr>-->
</table>
<table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
<tr height="30">
                    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
                    <td>&nbsp;</td>
                    <td align="right"><a href="../../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" /></a>&nbsp;</td>
                </tr>
            </table>
<div id="clik"></div>
<div id="clik1"></div>

</div>

<div id="dialog-modal" title="Proses JO" style="display:none; font:12px tahoma;">
<table width="410" align="center" cellpadding="3" cellspacing="0">
<tr>
	<td width="110">Nomor WO</td>
	<td width="300"><?php
$q="SELECT MAX(IF(no_wo IS NULL,0,no_wo))+1 AS no_wo FROM $dbcssd.cssd_job_order";
$s=mysql_query($q);
$cmkode=1;
if ($rows=mysql_fetch_array($s))
{
	$cmkode=$rows["no_wo"];
}
$mkode=$cmkode;
for ($i=0;$i<(8-strlen($cmkode));$i++)
{
	$mkode="0".$mkode;
}
?><input type="text" id="kdWo" name="kdWo" style="width:70px;" value="<?=$mkode;?>" readonly="true"/><input type="hidden" id="status_joZ" name="status_joZ" /><input type="hidden" id="idZ" name="idZ" />
<input type="hidden" id="idZ" name="idZ" /></td>
</tr>
<tr>
			  <td width="120">Tanggal Selesai</td>
				<td width="290">
				<input type="text" id="tglSelesai" name="tglSelesai" size="10" readonly="true" value="<?=date('d-m-Y')?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglSelesai'),depRange);"/>				</td>
			  </tr>
<tr>
	<td width="120">Nama Unit</td>
	<td width="290"><input type="text" id="nmUnit" name="nmUnit" size="40" readonly="true"/></td>
</tr>
<tr>
<td width="120">Nama Barang</td>
<td width="290"><input type="text" id="nmBrg" name="nmBrg" size="40" readonly="true"/></td>			  
</tr>
<tr>
	<td width="250" align="center" style="padding-top:20px" colspan="2"><button id="tampil" name="tampil" onClick="simpen()" style="cursor:pointer" class="popup_closebox"><img src="../icon/saveButton.jpg" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan </button></td>
</tr>
</table>
</div>

<div id="dialog-modal2" title="Selesai" style="display:none; font:12px tahoma;">
<table width="410" align="center" cellpadding="3" cellspacing="0">
<tr>
	<td width="110">Nomor WO</td>
	<td width="300"><input type="text" id="kdWo2" name="kdWo2" style="width:70px;" value="<?=$mkode;?>" readonly="true"/><input type="hidden" id="status_jo2" name="status_jo2" /><input type="hidden" id="id2" name="id2" /></td>
</tr>
<tr>
			  <td width="120">Tanggal Selesai</td>
				<td width="290">
				<input type="text" id="tglSelesai2" name="tglSelesai2" size="10" readonly="true" value="<?=date('d-m-Y')?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglSelesai2'),depRange);"/>				</td>
			  </tr>
<tr>
	<td width="120">Nama Unit</td>
	<td width="290"><input type="text" id="nmUnit2" name="nmUnit2" size="40" readonly="true"/></td>
</tr>
<tr>
<td width="120">Nama Barang</td>
<td width="290"><input type="text" id="nmBrg2" name="nmBrg2" size="40" readonly="true"/></td>			  
</tr>
<tr>
	<td width="250" align="center" style="padding-top:20px" colspan="2"><button id="tampil" name="tampil" onClick="simpen2()" style="cursor:pointer" class="popup_closebox"><img src="../icon/saveButton.jpg" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan </button></td>
</tr>
</table>
</div>
</body>
<script language="javascript">

<?php
$z=mysql_num_rows(mysql_query("select * from b_ms_group_petugas where ms_group_id=55 and ms_pegawai_id='".$_SESSION['userId']."'"));
	//ms_group_id=6  ->  Hanya petugas CSSD Laundry yg bisa buka
	if($z==1){?>
	
	function goFilterAndSort(abc){
	if (abc=="gridboxZ"){
		gd9.loadURL("joborderUtils.php?grd=order2&tipejo=1&stOrd=&bln=&thn=&petugas=<?=$_SESSION['userId']?>&filter="+gd9.getFilter()+"&sorting="+gd9.getSorting()+"&page="+gd9.getPage(),"","GET");
		//alert("tindakanUtils.php?grd=tindakan_nic&filter="+gd9.getFilter()+"&sorting="+gd9.getSorting()+"&page="+gd9.getPage())
	}
} 

var gd9 = new DSGridObject("gridboxZ");
gd9.setHeader("Data Job Order",true);
gd9.setColHeader("No,Tanggal,Nomor JO,Tanggal Selesai,Nomor WO,Nama Unit,Nama Barang,Tipe Job Order,Nama Pemohon,Jumlah,Status,Action");
gd9.setIDColHeader(",tgl,no_jo,tgl_selesai,no_wo,nama,namabarang,tipe,namauser,qty,stat,");
gd9.setColWidth("30,90,90,90,90,150,150,100,150,50,90,70");
gd9.setCellAlign("center,center,left,center,left,left,left,center,left,center,center,center");
gd9.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
gd9.setCellHeight(20);
gd9.setImgPath("../icon");
gd9.setIDPaging("pagingZ");
//gd9.onLoaded(konfirmasi);
gd9.attachEvent("onRowClick","ambilIdZ");
gd9.attachEvent("onRowClick","ambilIdZ2");
gd9.baseURL("joborderUtils.php?grd=order2&tipejo=1&stOrd=&bln=&thn=&petugas=<?=$_SESSION['userId']?>");
gd9.Init();

function filterZ(){
        var bln = document.getElementById('blnZ').value;
        var thn = document.getElementById('thnZ').value;
		var stOrd = document.getElementById('stOrdZ').value;

				//alert(url);
        gd9.loadURL("joborderUtils.php?grd=order2&tipejo=1&petugas=<?=$_SESSION['userId']?>&stOrd="+stOrd+"&bln="+bln+"&thn="+thn,'','GET');
        }
		
function ambilIdZ(){
	var sisipan=gd9.getRowId(gd9.getSelRow()).split("|");
	document.getElementById('idZ').value=sisipan[0];
	document.getElementById('status_joZ').value=sisipan[1];
	document.getElementById('tglSelesai').value='<?=date('d-m-Y')?>';
	//document.getElementById('tglSelesai').value=sisipan[2];
	/*var sip=sisipan[3];
	alert(sip);
	if(sip!=null){
	document.getElementById('kdWo').value=sisipan[3];}*/
	document.getElementById('kdWo').value=gd9.cellsGetValue(gd9.getSelRow(),5);
	document.getElementById('nmUnit').value=gd9.cellsGetValue(gd9.getSelRow(),6);
	document.getElementById('nmBrg').value=gd9.cellsGetValue(gd9.getSelRow(),7);
}

function ambilIdZ2(){
	var sisipan=gd9.getRowId(gd9.getSelRow()).split("|");
	//alert(sisipan[0]);
	document.getElementById('id2').value=sisipan[0];
	document.getElementById('status_jo2').value=sisipan[1];
	//document.getElementById('tglSelesai').value='<?=date('d-m-Y')?>';
	document.getElementById('tglSelesai2').value=sisipan[2];
	/*var sip=sisipan[3];
	alert(sip);
	if(sip!=null){
	document.getElementById('kdWo').value=sisipan[3];}*/
	document.getElementById('kdWo2').value=gd9.cellsGetValue(gd9.getSelRow(),5);
	document.getElementById('nmUnit2').value=gd9.cellsGetValue(gd9.getSelRow(),6);
	document.getElementById('nmBrg2').value=gd9.cellsGetValue(gd9.getSelRow(),7);
}

function proses()
{
	ambilIdZ();
	generate_kodeZ();
	tampilPop();
}

function selesai()
{
	ambilIdZ2();
	tampilPop2();
}

function tampilPop(){
	/*new Popup('jaga',null,{modal:true,position:'center',duration:1});
	document.getElementById('jaga').popup.show();*/
	$("#dialog-modal" ).dialog({
		height: 230,
		width: 450,
		show: "slow",
		modal: true
		});
}

function tampilPop2(){
	/*new Popup('jaga',null,{modal:true,position:'center',duration:1});
	document.getElementById('jaga').popup.show();*/
	$("#dialog-modal2" ).dialog({
		height: 230,
		width: 450,
		show: "slow",
		modal: true
		});
}

function generate_kodeZ()
{
	$.get('GenerateKode_v2.php', function(data) {
	$('#kdWo').val(data);
	//alert('Load was performed.');
	});
	
/*	var dataString = "";
$.ajax({
	type: "POST",
	url: "GenerateKode_v2.php",
	data: dataString,
	success: function(msg)
		{
			alert(msg);
		}
		
		
		});*/
}

function simpen(){
	var id=document.getElementById('idZ').value;
	var kdWo=document.getElementById('kdWo').value;
	var status_jo=document.getElementById('status_joZ').value;
	var idPtgs=document.getElementById('idPtgsZ').value;
	var tglSelesai=document.getElementById('tglSelesai').value;
gd9.loadURL("joborderUtils.php?cssd=1&grd=order2&tipejo=1&stOrd=&bln=&thn=&petugas=<?=$_SESSION['userId']?>&idPtgs="+idPtgs+"&id="+id+"&kdWo="+kdWo+"&tglSelesai="+tglSelesai+"&statusOrder="+status_jo,'','GET');
		generate_kodeZ();	
}

function simpen2(){
	var id=document.getElementById('id2').value;
	var kdWo=document.getElementById('kdWo2').value;
	var status_jo=document.getElementById('status_jo2').value;
	var idPtgs=document.getElementById('idPtgsZ').value;
	var tglSelesai=document.getElementById('tglSelesai2').value;
gd9.loadURL("joborderUtils.php?cssd=1&grd=order2&tipejo=1&stOrd=&bln=&thn=&petugas=<?=$_SESSION['userId']?>&idPtgs="+idPtgs+"&id="+id+"&kdWo="+kdWo+"&tglSelesai="+tglSelesai+"&statusOrder="+status_jo,'','GET');
		generate_kodeZ();	
}
	
<?php }else{?>

function  act1(li){
	
	if(document.getElementById('idUnit').value=='' || document.getElementById('idAlat').value=='' ){
		alert('Pengisian form belum lengkap !')
		return false;
	}else{
	var idUnit=document.getElementById('idUnit').value;
	var idAlat=document.getElementById('idAlat').value;
	var id=document.getElementById('id').value;
	var kdOrder=document.getElementById('kdOrder').value;
	var tglOrder=document.getElementById('tglOrder').value;
	
	
	var jmlh=document.getElementById('jmlh').value;
	var idPtgs=document.getElementById('idPtgs').value;
	switch (li){
	case "simpan2":
	case "update":
		//alert("tindakanUtils.php?grdTindCic=1&grd=tindakan_nic&act1="+li+"&idNic="+idNic+"&idTind="+idTind+"&id="+id);
		gd3.loadURL("joborderUtils.php?grdTindCic=1&grd=order&petugas=<?=$_SESSION['userId']?>&act1="+li+"&idPtgs="+idPtgs+"&id="+id+"&idUnit="+idUnit+"&idAlat="+idAlat+"&kdOrder="+kdOrder+"&tglOrder="+tglOrder+"&jmlh="+jmlh,'','GET');
		kosong();
		document.getElementById('save').value='simpan2';
		generate_kode();
		break;
	}
}
}
function goFilterAndSort(abc){
	if (abc=="gridbox"){
		gd3.loadURL("joborderUtils.php?grd=order&petugas=<?=$_SESSION['userId']?>&filter="+gd3.getFilter()+"&sorting="+gd3.getSorting()+"&page="+gd3.getPage(),"","GET");
		//alert("tindakanUtils.php?grd=tindakan_nic&filter="+gd3.getFilter()+"&sorting="+gd3.getSorting()+"&page="+gd3.getPage())
	}
} 
function ambilId(){
	var sisipan=gd3.getRowId(gd3.getSelRow()).split("|");
	var statusjo = sisipan[8];
	if(statusjo==2 || statusjo==1){alert('Anda tidak bisa mengubah data setelah diproses oleh petugas CSSD Laundry');}
	else{
	document.getElementById('id').value=sisipan[0];
	document.getElementById('idUnit').value=sisipan[3];
	
	document.getElementById('idAlat').value=sisipan[5];
	
	document.getElementById('nmAlat').value=gd3.cellsGetValue(gd3.getSelRow(),5);
	document.getElementById('tglOrder').value=gd3.cellsGetValue(gd3.getSelRow(),2);
	document.getElementById('kdOrder').value=gd3.cellsGetValue(gd3.getSelRow(),3);
	document.getElementById('jmlh').value=gd3.cellsGetValue(gd3.getSelRow(),8);
	document.getElementById('save').value='update';
	document.getElementById('save').innerHTML='<img src="../icon/edit.gif" width="25" height="25" align="absmiddle" />&nbsp;Ubah';
	document.getElementById('delete').innerHTML='<img src="../icon/delete.gif" width="25" height="25" align="absmiddle" />&nbsp;Hapus';
	document.getElementById('delete').disabled=false;
	}
}
function kosong(){
	document.getElementById('id').value='';
	document.getElementById('idOrder').value='';
	document.getElementById('kdOrder').value='';
	document.getElementById('tglOrder').value='<?=date('d-m-Y')?>';
	
	document.getElementById('idUnit').value='';
	
	
	document.getElementById('idAlat').value='';
	
	document.getElementById('nmAlat').value='';
	document.getElementById('jmlh').value='';
	document.getElementById('save').innerHTML='<img src="../icon/save.gif" width="25" height="25" align="absmiddle" />&nbsp;Tambah';
	document.getElementById('delete').innerHTML='<img src="../icon/delete2.gif" width="25" height="25" align="absmiddle" />&nbsp;Hapus';
	document.getElementById('delete').disabled=true;
	document.getElementById('save').value='simpan2';
	generate_kode();
}
function del(){
	var id=document.getElementById('id').value;
	if(confirm("Apakah anda yakin ingin menghapus data ini ?"))
	gd3.loadURL("joborderUtils.php?grdTindCic=1&grd=order&petugas=<?=$_SESSION['userId']?>&act1=hapus&id="+id,'','GET');
	gd3.Init();
	document.getElementById('save').innerHTML='<img src="../icon/save.gif" width="25" height="25" align="absmiddle" />&nbsp;Tambah';
	document.getElementById('delete').innerHTML='<img src="../icon/delete2.gif" width="25" height="25" align="absmiddle" />&nbsp;Hapus';
	document.getElementById('delete').disabled=true;
	document.getElementById('id').value='';
	document.getElementById('idOrder').value='';
	document.getElementById('kdOrder').value=document.getElementById('kdOrder2').value;
	document.getElementById('tglOrder').value='<?=date('d-m-Y')?>';
	
	document.getElementById('idUnit').value='';
	
	
	document.getElementById('idAlat').value='';
	
	document.getElementById('nmAlat').value='';
	document.getElementById('jmlh').value='';
	document.getElementById('save').value='simpan2';
	generate_kode();
}

function konfirmasi(key,val){
	var tangkap,proses,tombolSimpan,tombolHapus;
	//alert(val);
	if (val!=undefined && val!='' && val!='*|*'){
		
		tangkap=val.split("*|*");
		if(tangkap[0]=='simpan2'){
			if(tangkap[1]=='Data sudah ada'){
				alert("Data sudah ada !");
			}else{
				alert("Data berhasil disimpan...");
			}
		}
		//proses=tangkap[0];
		//alert(tombolSimpan=tangkap[1]);
		//tombolHapus=tangkap[2];
	}
}

var gd3 = new DSGridObject("gridbox");
gd3.setHeader("Data Job Order",true);
gd3.setColHeader("No,Tanggal,Nomor JO,Nama Unit,Nama Barang,Tipe Job Order,Nama Pemohon,Jumlah,Tanggal Selesai,Nomor WO,Status");
gd3.setIDColHeader(",tgl,no_jo,nama,namabarang,tipe,namauser,qty,tgl_selesai,no_wo,stat");
gd3.setColWidth("30,90,100,150,150,100,150,50,90,90,90");
gd3.setCellAlign("center,center,left,left,left,center,left,center,center,left,center");
gd3.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
gd3.setCellHeight(20);
gd3.setImgPath("../icon");
gd3.setIDPaging("paging");
gd3.onLoaded(konfirmasi);
gd3.attachEvent("onRowClick","ambilId");
gd3.baseURL("joborderUtils.php?grd=order&petugas=<?=$_SESSION['userId']?>");
gd3.Init();

function clik(a,b,c){
	document.getElementById('idUnit').value=a;
	
	
}
function clik1(d,e,f){
	document.getElementById('idAlat').value=d;
	
	document.getElementById('nmAlat').value=f;
}

function generate_kode()
{
	$.get('GenerateKode.php', function(data) {
	$('#kdOrder').val(data);
	//alert('Load was performed.');
	});
}

function filter(){
        var bln = document.getElementById('bln').value;
        var thn = document.getElementById('thn').value;
		var stOrd = document.getElementById('stOrd').value;

				//alert(url);
        gd3.loadURL("joborderUtils.php?grd=order&petugas=<?=$_SESSION['userId']?>&stOrd="+stOrd+"&bln="+bln+"&thn="+thn,'','GET');
        }
		
/*function suggest(e,par){
var keywords=par.value;
	//alert(keywords);
	//alert(par.offsetLeft);
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  var i;
  if (jmlRow > 4){
  	i=par.parentNode.parentNode.rowIndex-2;
  }else{
  	i=0;	
  }
  //alert(jmlRow+'-'+i);
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
			Request('../transaksi/obatlist_hapus.php?idunit=<?php echo $idunit; ?>&aKeyword='+keywords+'&no='+i , 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}*/
</script>
<script>	
$(function(){
	$("#nmAlat").autocomplete
		({
            source:'isi_combo.php?com=txtLaundry', 
			minLength:3,
       		keydown: function( event, ui ) 
			{
                $( "#nmAlat" ).val( ui.item.txtAlat);
				$( "#idAlat" ).val( ui.item.txtAlat2);
				return false;
			},
			select: function( event, ui ) 
			{
				$( "#nmAlat" ).val( ui.item.txtAlat);
				$( "#idAlat" ).val( ui.item.txtAlat2);
				return false;
			}
        });
});
<? }?>
</script>
</html>

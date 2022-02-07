<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<!--dibawah ini diperlukan untuk menampilkan popup-->
<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
<script type="text/javascript" src="../theme/prototype.js"></script>
<script type="text/javascript" src="../theme/effects.js"></script>
<script type="text/javascript" src="../theme/popup.js"></script>
<!--diatas ini diperlukan untuk menampilkan popup-->

<title>Diagnosis</title>
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
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;FORM DIAGNOSIS ICD</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="1" cellpadding="0" class="tabel" align="center">
 
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right">Kode Induk</td>	<td>
      <input id="txtParentKode"  name="txtParentKode" type="text" size="20" maxlength="20" style="text-align:center" value="<?php echo $ParentKode; ?>" readonly="true" class="txtcenter"> 
      <input type="button"  class="btninput" id="btnParent" name="btnParent" value="..." title="Pilih Induk" onClick="OpenWnd('diagnosis1_tree_view.php?<?php echo $qstr_ma_sak; ?>',800,500,'msma',true)">             
	Level
	<input id="txtLevel" name="txtLevel" size="5" class="txtinput" />
	<input type="hidden" id="txtParentId" name="txtParentId" size="5" />
	<input type="hidden" id="txtParentLvl" name="txtParentLvl" size="6" />
      
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td align="right">Kode Diagnosis ICD</td>
	<input id="txtId" type="hidden" name="txtId"  class="txtinput"/>
    <td><input size="24" id="txtKode" name="txtKode"  type="text" class="txtinput"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr> 
  <tr>
    <td>&nbsp;</td>
    <td align="right">Diagnosis ICD</td>
    <td><input size="60" id="txtDiag" name="txtDiag"  class="txtinput"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Golongan</td>
    <td>
	<input size="40"  type="hidden" id="dg_kode" name="dg_kode"  class="txtinput"/>
	<input size="40" id="txtGol" name="txtGol"  class="txtinput"/>&nbsp;<img src="../icon/table.gif" width="20" align="absmiddle" style="cursor:pointer; vertical-align:middle" <?php echo $rows['DG_NAMA'];?> onclick="isiDataRM();" title="Pilih Golongan" /></td>
    <!--td>
                                <div id="grdIsiDataRM" type="hidden" style="width:450px; height:200px; padding-bottom:10px; background-color:white;"></div>
                                <!--div id="pagingIsiDataRM" style="width:450px;"></div-->
          </td>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Penyakit Menular</td>
    <td>&nbsp;<select id="cmbKodeAlert" name="cmbKodeAlert"  class="txtinput">
    	<option value="0">-</option>
    	<?php 
		$sql="SELECT kdg_id,kdg_nama FROM b_ms_diagnosa_gambar WHERE tipe=1 AND kdg_aktif=1";
		$rs=mysql_query($sql);
		while ($rw=mysql_fetch_array($rs)){
		?>
		<option value="<?php echo $rw["kdg_id"]; ?>"><?php echo $rw["kdg_nama"]; ?></option>
        <?php 
		}
		?>
	</select></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <!-- <tr>
    <td>&nbsp;</td>
    <td align="right">Flag</td>
    <td>&nbsp; -->
		<input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="40" tabindex="3" value="<?php echo $flag; ?>"/>
		<!-- </td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr> -->
  <tr>
  	<td>&nbsp;</td>
	<td align="right">Surveilance&nbsp;</td>
	<td>&nbsp;<select id="cmbSur" name="cmbSur"  class="txtinput">
		<option value="0">Tidak</option>
		<option value="1">Ya</option>
	</select>
	&nbsp;Status:<label><input type="checkbox" id="isAktif" name="isAktif"  class="txtinput"/>&nbsp;&nbsp;Aktif</label>	</td>
	<td></td>
	<td>&nbsp;</td>
  </tr>  
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>
		<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
		<input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);"  class="tblHapus"/>
		<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>	</td>
	<td><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="window.location='diagnosis2_tree.php'" class="tblViewTree">Tampilan Tree</button></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">
		<div id="gridbox" style="width:925px; height:330px; background-color:white; overflow:hidden;"></div>
		<div id="paging" style="width:925px;"></div>			</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="50%">&nbsp;</td>
    <td align="right" width="20%"><!--input type="button" disabled="disabled" value="&nbsp;&nbsp;&nbsp;< 1&nbsp;&nbsp;&nbsp;">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;> 2&nbsp;&nbsp;&nbsp;" onclick="location='diagnosis2.php?id='+document.getElementById('txtId').value;"--></td>
    <td width="5%">&nbsp;</td>
  </tr>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" bgcolor="#008484" width="1000">
  <tr height="30">
    <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  </tr>
</table>
</div>
<div id="divIsiDataRM" style="display:none;width:520px" class="popup" >
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="batal('btnBatalIsiDataRM')" style="float:right; cursor: pointer" />
                <fieldset>
                        <input id="cmbIsiDataRM" type ="hidden" name="cmbIsiDataRM" class="txtinput" onchange="evCmbDataRM();">
                        </input>
                      <td>
                                <div id="grdIsiDataRM" style="width:500px; height:200px; padding-bottom:10px; background-color:white;"></div>
                                <div id="pagingi" style="width:500px;"></div>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
</body>
<script>
	function simpan(action)
	{
		if(ValidateForm('txtKode,txtDiag,txtLevel,cmbSur,isAktif','ind','txtGol'))
		{
			var id = document.getElementById("txtId").value;
			var kode = document.getElementById("txtKode").value;
			var nama = document.getElementById("txtDiag").value;
			var level = document.getElementById("txtLevel").value;
			var parentId = document.getElementById("txtParentId").value;
			var parentKode = document.getElementById("txtParentKode").value;
			var sur = document.getElementById("cmbSur").value;
			var dg_kode = document.getElementById("dg_kode").value;
			var emergency = document.getElementById("cmbKodeAlert").value;
			var golongan = document.getElementById("txtGol").value;
			var flag = document.getElementById("flag").value;
			//alert(golongan);
			if(golongan==''){
				dg_kode = '';
			}
			//alert(kode.replace(/\+/g,'plus'));
			if(document.getElementById("isAktif").checked == true)
			{
				var aktif = 1;
			}
			else
			{
				var aktif = 0;
			}
			//alert("diag_utils.php?grd=true&act="+action+"&id="+id+"&kode="+kode+"&nama="+nama+"&level="+level+"&parentId="+parentId+"&parentKode="+parentKode+"&sur="+sur+"&aktif="+aktif+"&kdgol="+dg_kode+"&emergency="+emergency);
			a.loadURL("diag_utils.php?grd=true&act="+action+"&id="+id+"&kode="+kode.replace(/\+/g,'plus')+"&nama="+nama+"&level="+level+"&parentId="+parentId+"&parentKode="+parentKode+"&sur="+sur+"&aktif="+aktif+"&flag="+flag+"&kdgol="+dg_kode+"&emergency="+emergency,"","GET");
			document.getElementById("txtKode").value = '';
			document.getElementById("txtDiag").value = '';
			document.getElementById("txtLevel").value = '';
			document.getElementById("txtParentId").value = '';
			document.getElementById("txtParentKode").value = '';
			document.getElementById("cmbSur").value = '';
			document.getElementById("txtGol").value = '';
			document.getElementById("isAktif").checked = false;
		}
	}
	
	function ambilData()
	{
		//dg_kode
		var sisip=a.getRowId(a.getSelRow()).split("|");
		//alert(a.cellsGetValue(a.getSelRow(),10));
		var p="txtId*-*"+(sisip[0])+"*|*txtKode*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*txtDiag*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*txtLevel*-*"+a.cellsGetValue(a.getSelRow(),4)+"*|*txtParentKode*-*"+a.cellsGetValue(a.getSelRow(),6)+"*|*txtParentLvl*-**|*txtParentId*-*"+a.cellsGetValue(a.getSelRow(),5)+"*|*txtGol*-*"+a.cellsGetValue(a.getSelRow(),10)+"*|*dg_kode*-*"+a.cellsGetValue(a.getSelRow(),12)+"*|*cmbSur*-*"+((a.cellsGetValue(a.getSelRow(),7)=='Ya')?1:0)+"*|*isAktif*-*"+((a.cellsGetValue(a.getSelRow(),9)=='Aktif')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false*|*cmbKodeAlert*-*"+sisip[1];
		fSetValue(window,p);
	}
	
	function hapus()
	{
		var rowid = document.getElementById("txtId").value;
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if(confirm("Anda yakin menghapus Diagnosis "+a.cellsGetValue(a.getSelRow(),3)))
		{
			a.loadURL("diag_utils.php?grd=true&act=hapus&rowid="+rowid,"","GET");
		}
		
		document.getElementById("txtGol").value = '';
		document.getElementById("txtKode").value = '';
		document.getElementById("txtDiag").value = '';
		document.getElementById("txtLevel").value = '';
		document.getElementById("txtParentId").value = '';
		document.getElementById("txtParentKode").value = '';
		document.getElementById("cmbKodeAlert").value = '0';
		document.getElementById("cmbSur").value = '';
		document.getElementById('btnSimpan').value= 'Tambah';
		document.getElementById("isAktif").checked = false;
	}
	
	function batal()
	{
		var p="txtId*-**|*txtKode*-**|*txtDiag*-**|*txtLevel*-**|*txtParentLvl*-**|*txtParentId*-**|*txtParentKode*-**|*cmbKodeAlert*-*0*|*cmbSur*-**|*isAktif*-*false*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
		fSetValue(window,p);		
	}
	
	function goFilterAndSort(grd){
		if (grd=="gridbox"){
			a.loadURL("diag_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
			//a.loadURL("golongan.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
			 //alert("golongan.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting());
		}
		if (grd=="grdIsiDataRM")
		{
			//alert("golongan.php?grd=true&filter="+ai.getFilter()+"&sorting="+ai.getSorting()+"&page="+ai.getPage());
			ai.loadURL("golongan.php?grd=true&filter="+ai.getFilter()+"&sorting="+ai.getSorting()+"&page="+ai.getPage(),"","GET");
		}
	}
	var a=new DSGridObject("gridbox");
	a.setHeader("DIAGNOSIS");
	a.setColHeader("NO,KODE ICD,DIAGNOSIS ICD,LEVEL,PARENT ID,PARENT KODE,SURVEILANCE,ISLAST,STATUS AKTIF,GOL.,STATUS EMERGENCY");
	a.setIDColHeader(",kode,nama,level,,,,,,,kdg_nama");
	a.setColWidth("50,75,150,75,75,75,75,75,75,100,100");
	a.setCellAlign("center,left,left,center,center,center,center,center,center,left,center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowClick","ambilData");
	a.baseURL("diag_utils.php?grd=true");
	a.Init();
		
	function isiDataRM(){
		window.scroll(0,0);
		new Popup('divIsiDataRM',null,{modal:true,position:'center',duration:1});
		document.getElementById('divIsiDataRM').popup.show();
	}
	
	function tarikDataRM(){
			document.getElementById('dg_kode').value=ai.cellsGetValue(ai.getSelRow(),2);
			document.getElementById('txtGol').value=ai.cellsGetValue(ai.getSelRow(),3);
			document.getElementById('divIsiDataRM').popup.hide();
	}	
			
	var ai=new DSGridObject("grdIsiDataRM");
	ai.setHeader("DIAGNOSIS");
	ai.setColHeader("NO,KODE,NAMA GOLONGAN");
	ai.setIDColHeader(",DG_KODE,DG_NAMA");
	ai.setColWidth("50,100,150");
	ai.setCellAlign("center,left,left");
	ai.setCellHeight(20);
	ai.setImgPath("../icon");
	ai.setIDPaging("pagingi");
	ai.attachEvent("onRowClick","tarikDataRM");
	ai.baseURL("golongan.php?grd=true");
	ai.Init();
</script>
</html>

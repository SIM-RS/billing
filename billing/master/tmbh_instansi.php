<?php
session_start();
include("../sesi.php");
?>
<?php
	//session_start();
?><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>

<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
<script type="text/javascript" src="../theme/js/tab-view.js"></script>
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<title>Form Penjamin</title>
</head>



<div align="center">
<?php
	include("../koneksi/konek.php");
	include("../header1.php");
	$ksoId = $_REQUEST['ksoId'];
	$qKso = "SELECT id, nama FROM b_ms_kso WHERE id = '$ksoId'";
	$sKso = mysql_query($qKso);
	$wKso = mysql_fetch_array($sKso);
?>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30" style="text-transform:uppercase;">&nbsp;DETAIL DATA INSTANSI</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">  
  <tr>
  		<td><input id="cada" name="cada" type="hidden" value="0" />
        <input id="instansiId" name="instansiId" type="hidden" value="<?php echo $instansiId;?>" /></td>
  </tr>
  <tr>
  		<td align="center">
        <table width="60%" align="center" border="0" cellpadding="0" cellspacing="4" class="tabel">
            <tr>
                <td width="30%">Kode</td>
                <td align="center" width="5%">:</td>
                <td width="65%"><input type="hidden" id="txtId" name="txtId" /><input id="txtKode" name="txtKode" size="16"  /></td>
            </tr>
            <tr>
                <td>Nama Instansi</td>
                <td align="center">:</td>
                <td><input id="txtNama" name="txtNama" size="50" /></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td align="center">:</td>
                <td><input id="txtAlamat" name="txtAlamat" size="50" style="height:50;"></td>
            </tr>
            <tr>
                <td>Kota</td>
                <td align="center">:</td>
                <td><input id="txtKota" name="txtKota" size="50"></td>
            </tr>
            <tr>
                <td>No Telepon</td>
                <td align="center">:</td>
                <td><input id="txtTlp" name="txtTlp" size="24" /></td>
            </tr>
            <tr>
                <td>Status</td>
                <td align="center">:</td>
                <td><input id="rd1" name="rd" type="radio" value="1">&nbsp;Aktif&nbsp;&nbsp;&nbsp;<input id="rd0" name="rd" type="radio" value="0" checked="checked">&nbsp;Tidak</td>
            </tr>
            <tr>
                <td colspan="3" height="30" align="center">
				<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
				<input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus"/>
				<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>
				<!--button id="btnSimpanInstansi" name="btnSimpanInstansi" onClick="simpan(this.id);"><img src="../icon/add.gif" width="16" height="16">&nbsp;Tambah</button>&nbsp;
				<button id="btnHapusInstansi" name="btnHapusInstansi" onclick="hapus(this.title);" disabled="disabled"><img src="../icon/add.gif" width="16" height="16">&nbsp;Hapus</button>&nbsp;
				<button id="btnBatal" name="btnBatal" onclick="batal(this.id)"><img src="../icon/add.gif" width="16" height="16">&nbsp;Batal</button--></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>         
        </td>
  </tr>
  <tr>
  		<td align="right" style="padding-right:50px;"><button id="btnKembali" name="btnKembali" onClick="location='detail_kso.php?ksoId=<?php echo $ksoId; ?>'"><img src="../icon/prev.gif" width="12" height="12" />&nbsp;Kembali</button>
  </tr>
  <tr>
  		<td align="center"><div id="gridbox" style="width:900px; height:300px; background-color:white;"></div>
		<div id="paging" style="width:900px;"></div></td>
  </tr>
</table>
</div>
<script>

	function simpan(action)
	{
		if(ValidateForm('txtKode,txtNama,txtAlamat,txtKota,txtTlp','ind'))
		{
			var instansiId = document.getElementById("txtId").value;
			var kode = document.getElementById("txtKode").value;
			var nama = document.getElementById("txtNama").value;
			var alamat = document.getElementById("txtAlamat").value;
			var kota = document.getElementById("txtKota").value;
			var telp = document.getElementById("txtTlp").value;
			if(document.getElementById("rd1").checked==true && document.getElementById("rd0").checked==false){
				var aktif=document.getElementById("rd1").value;
			}
			else if(document.getElementById("rd0").checked==true && document.getElementById("rd1").checked==false){
				var aktif=document.getElementById("rd0").value;
			}
			
			//alert("penjamin_utils.php?grd=21&act="+action+"&instansiId="+instansiId+"&kode="+kode+"&nama="+nama+"&alamat="+alamat+"&kota="+kota+"&telp="+telp+"&aktif="+aktif);
			aGrid.loadURL("penjamin_utils.php?grd=21&act="+action+"&instansiId="+instansiId+"&kode="+kode+"&nama="+nama+"&alamat="+alamat+"&kota="+kota+"&telp="+telp+"&aktif="+aktif,"","GET");
						
			batal()
		}
	}
	
	function hapus()
	{
		var instansiId = document.getElementById("txtId").value;
		var icada = document.getElementById("cada").value;
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if (icada=="1"){
			alert("Instansi Ini Sudah Ada Datanya, Jadi Tidak Boleh Dihapus !");
			return false;
		}
		
		if(confirm("Anda yakin menghapus Penjamin "+aGrid.cellsGetValue(aGrid.getSelRow(),3)))
		{
			//alert("penjamin_utils.php?grd=21&act=hapus&instansiId="+instansiId);
			aGrid.loadURL("penjamin_utils.php?grd=21&act=hapus&instansiId="+instansiId,"","GET");
		}
		
			batal()
	}
	
	function ambilData(){
		var sisip=aGrid.getRowId(aGrid.getSelRow()).split("|");
		//alert(sisip[0]);
		var p ="txtId*-*"+sisip[0]+"*|*cada*-*"+sisip[1]+"*|*txtKode*-*"+aGrid.cellsGetValue(aGrid.getSelRow(),2)+"*|*txtNama*-*"+aGrid.cellsGetValue(aGrid.getSelRow(),3)+"*|*txtAlamat*-*"+aGrid.cellsGetValue(aGrid.getSelRow(),4)+"*|*txtKota*-*"+aGrid.cellsGetValue(aGrid.getSelRow(),5)+"*|*txtTlp*-*"+aGrid.cellsGetValue(aGrid.getSelRow(),6)+"*|*rd0*-*"+((aGrid.cellsGetValue(aGrid.getSelRow(),7)=='1')?'false':'true')+"*|*rd1*-*"+((aGrid.cellsGetValue(aGrid.getSelRow(),7)=='1')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
		fSetValue(window,p);
		//document.getElementById('btnHapusInstansi').disabled = false;
		//document.getElementById('btnSimpanInstansi').value = "Simpan";
	}
	
	function batal()
	{
		var p="txtId*-**|*txtKode*-**|*txtNama*-**|*txtAlamat*-**|*txtKota*-**|*txtTlp*-**|*rd0*-*true*|*rd1*-*false*-**|*btnSimpan*-*Tambah*|*btnHapus*-*true";
		fSetValue(window,p);		
	}
	
	
    var instansiId = document.getElementById('instansiId').value;
    aGrid=new DSGridObject("gridbox");
	aGrid.setHeader("DATA PENJAMIN");	
	aGrid.setColHeader("NO,KODE,NAMA,ALAMAT,KOTA,NO TELEPON,STATUS");
	aGrid.setIDColHeader(",,nama,,,,");
	aGrid.setColWidth("50,75,250,250,100,100,75");
	aGrid.setCellAlign("center,center,left,left,left,left,center");
	aGrid.setCellHeight(20);
	aGrid.setImgPath("../icon");
	aGrid.setIDPaging("paging");
	aGrid.attachEvent("onRowClick","ambilData");
	aGrid.baseURL("penjamin_utils.php?grd=21&instansiId="+instansiId);
    //alert("penjamin_utils.php?grd=20&ksoId="+idKso);
	aGrid.Init();
</script>
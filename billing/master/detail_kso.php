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
<title>Detail Penjamin</title>
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
		<td height="30" style="text-transform:uppercase;">&nbsp;DETAIL PENJAMIN <?php echo $wKso["nama"];?></td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">  
  <tr>
  		<td><input id="txtKsoId" name="txtKsoId" type="hidden" value="<?php echo $ksoId;?>" /></td>
  </tr>
  <tr>
  		<td align="center">
        <table width="60%" align="center" border="0" cellpadding="0" cellspacing="4" class="tabel">
            <tr>
                <td width="30%">No RM</td>
                <td align="center" width="5%">:</td>
                <td width="65%"><input type="hidden" id="txtId" name="txtId" /><input id="txtNoRm" name="txtNoRm" size="16"  /></td>
            </tr>
            <tr>
                <td>Nama Pasien</td>
                <td align="center">:</td>
                <td><input id="txtPasien" name="txtPasien" readonly="readonly" size="50" /></td>
            </tr>
            <tr>
                <td>Instansi</td>
                <td align="center">:</td>
                <td><select id="cmbIns" name="cmbIns">
					<?php
							$qIns = "SELECT id, nama FROM b_ms_instansi WHERE aktif=1";
							$sIns = mysql_query($qIns);
							while($wIns = mysql_fetch_array($sIns)){
					?>
					<option value="<?php echo $wIns['id'];?>" <?php if($_REQUEST['cmbStatus']==$wIns['nama']) echo 'selected';?>><?php echo $wIns['nama'];?></option>
					<?php
							}
					?>
				</select>&nbsp;<input type="button" id="btnIns" name="btnIns" value="Tambah" onclick="location='tmbh_instansi.php?ksoId=<?php echo $ksoId;?>'" /></td>
            </tr>
            <tr>
                <td>Nama Peserta</td>
                <td align="center">:</td>
                <td><input id="txtPeserta" name="txtPeserta" size="50" /></td>
            </tr>
            <tr>
                <td>No Anggota</td>
                <td align="center">:</td>
                <td><input id="txtNo" name="txtNo" size="24" /></td>
            </tr>
            <tr>
                <td>Status Peserta</td>
                <td align="center">:</td>
                <td><select id="cmbStatus" name="cmbStatus">
					<option value="ANAK KE 1">Anak Ke 1</option>
					<option value="ANAK KE 2">Anak Ke 2</option>
					<option value="ISTRI">Istri</option>
					<option value="PESERTA">Peserta</option>
					<option value="SUAMI">Suami</option>
				</select></td>
            </tr>
            <tr>
                <td colspan="3" height="30" style="padding-left:200px;"><input type="button" id="btnUpdate" name="btnUpdate" value="Update" onclick="update()" class="tblTambah"/>&nbsp;<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></td>
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
  		<td align="right" style="padding-right:50px;"><button id="btnKembali" name="btnKembali" onclick="location='penjamin.php'"><img src="../icon/prev.gif" width="12" height="12" />&nbsp;Kembali</button>
  </tr>
  <tr>
  		<td align="center"><div id="gridbox" style="width:900px; height:300px; background-color:white;"></div>
		<div id="paging" style="width:900px;"></div></td>
  </tr>
</table>
</div>
<script>
	function ambilData(){
		var sisip=aGrid.getRowId(aGrid.getSelRow()).split("|");
		//alert(sisip[0]);
		var p ="txtId*-*"+sisip[0]+"*|*txtNoRm*-*"+aGrid.cellsGetValue(aGrid.getSelRow(),2)+"*|*txtPasien*-*"+aGrid.cellsGetValue(aGrid.getSelRow(),3)+"*|*cmbIns*-*"+aGrid.cellsGetValue(aGrid.getSelRow(),5)+"*|*txtPeserta*-*"+aGrid.cellsGetValue(aGrid.getSelRow(),6)+"*|*txtNo*-*"+aGrid.cellsGetValue(aGrid.getSelRow(),7)+"*|*cmbStatus*-*"+aGrid.cellsGetValue(aGrid.getSelRow(),8);
		fSetValue(window,p);
	}
	
	function update(){
		if(ValidateForm('txtPasien','ind'))
		{
			var id = document.getElementById("txtId").value;
			var instansi_id = document.getElementById("cmbIns").value;
			var no_anggota = document.getElementById("txtNo").value;
			var st_anggota = document.getElementById("cmbStatus").value;
			var nama_peserta = document.getElementById("txtPeserta").value;			
			//alert("penjamin_utils.php?grd=20&act=update&id="+id+"&ksoId="+idKso+"&instansi_id="+instansi_id+"&no_anggota="+no_anggota+"&st_anggota="+st_anggota+"&nama_peserta="+nama_peserta);
			aGrid.loadURL("penjamin_utils.php?grd=20&act=update&id="+id+"&ksoId="+idKso+"&instansi_id="+instansi_id+"&no_anggota="+no_anggota+"&st_anggota="+st_anggota+"&nama_peserta="+nama_peserta,"","GET");
						
			batal()
		}
			//aGrid.Init();
	}
	
	
	function batal()
	{
		var p="txtId*-**|*txtNoRm*-**|*txtPasien*-**|*cmbIns*-**|*txtPeserta*-**|*txtNo*-**|*cmbStatus*-**";
		fSetValue(window,p);		
	}
	
    var idKso = document.getElementById('txtKsoId').value;
    aGrid=new DSGridObject("gridbox");
	aGrid.setHeader("DATA PASIEN PENJAMIN");	
	aGrid.setColHeader("NO,NO RM,NAMA PASIEN,ALAMAT,INSTANSI,NAMA PESERTA,NO ANGGOTA,STATUS PESERTA");
	aGrid.setIDColHeader(",no_rm,nama,,,,,");
	aGrid.setColWidth("50,75,200,250,200,200,120,100");
	aGrid.setCellAlign("center,center,left,left,left,left,left,left");
	aGrid.setCellHeight(20);
	aGrid.setImgPath("../icon");
	aGrid.setIDPaging("paging");
	aGrid.attachEvent("onRowClick","ambilData");
	aGrid.baseURL("penjamin_utils.php?grd=20&ksoId="+idKso);
    //alert("penjamin_utils.php?grd=20&ksoId="+idKso);
	aGrid.Init();
</script>
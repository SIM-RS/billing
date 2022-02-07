<?php
	include '../sesi.php';
	include '../koneksi/konek.php';
	if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') 
	{
		echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
		window.location='/simrs-tangerang/aset/';
		</script>";
	}
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
    <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
    <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
    <link type="text/css" rel="stylesheet" href="../default.css"/>
    <title>Stok Awal Inventaris</title>
</head>

<body>
    <div align="center">
    <iframe height="72" width="130" name="sort"
        id="sort"
        src="../theme/dsgrid_sort.php" scrolling="no"
        frameborder="0"
        style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
    </iframe>
	<?php
    include("../header.php");
    ?>
    <div>
        <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td align="center">
            		<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
            			<tr>
            				<td height="30" valign="bottom" align="right">
                                <input type="hidden" id="txtId" name="txtId" />
                                <img alt="tambah" style="cursor: pointer" src="../images/tambah.png" onClick="location='detailOpname_inventaris.php?act=add'" />&nbsp;&nbsp;
                                <img alt="edit" style="cursor: pointer" src="../images/edit.gif" onClick="goedit();" />&nbsp;&nbsp;
                                <img alt="hapus" style="cursor: pointer" src="../images/hapus.gif" id="btnHapusInventaris" name="btnHapus" onClick="hapus();" />&nbsp;
            				</td>
            			</tr>
            			<tr>
            				<td>&nbsp;</td>
            			</tr>
            			<tr>
            				<td align="center">
            					<div id="gridbox" style="width:900px; height:290px; background-color:white; overflow:hidden;"></div>
            					<div id="paging" style="width:900px;"></div>
            				</td>
            			</tr>
        			</table>
    			<div><img alt="" src="../images/foot.gif" width="1000" height="45" /></div>
    			</td>
    		</tr>
    	</table>
    </div>
    </div>
</body>

<script type="text/javascript" language="javascript">

	function ambilData()
	{
		var p="txtId*-*"+(rek.getRowId(rek.getSelRow()));
		fSetValue(window,p);
	}
	
	function goedit(){
		if(document.getElementById('txtId').value != '' && document.getElementById('txtId').value != null)
		{
			location='detailOpname_inventaris.php?act=edit&opname_id='+document.getElementById('txtId').value;
		}
		else
		{
			alert('Pilih dulu Stok Inventaris yang akan diedit.');
		}
	}
			
	function hapus()
	{
		var rowid = document.getElementById("txtId").value;
		//alert(rek.cellsGetValue(rek.getSelRow(),10);
		if(confirm("Anda yakin menghapus Perolehan "+rek.cellsGetValue(rek.getSelRow(),2)+" Kode Barang "+rek.cellsGetValue(rek.getSelRow(),10)+"?"))
		{
			rek.loadURL("utils.php?pilihan=opnameInv&act=hapus_opnameInv&opname_id="+rowid,"","GET");
		}
	}
			
	function goFilterAndSort(pilihan){
		if (pilihan=="gridbox")
		{
			rek.loadURL("utils.php?pilihan=opnameInv&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage(),"","GET");
		}
	}
			
	var rek=new DSGridObject("gridbox");
	rek.setHeader(".: Data Stok Awal Barang Inventaris :.");
	rek.setColHeader("No,Tanggal,Kode Barang,Noseri,Nama Barang,Type/Spesifikasi,Tahun Pengadaan,Asal Usul,Nilai Perolehan (Rp),Nilai Buku (Rp),Nama Unit,Nama Lokasi");
	rek.setIDColHeader(",inv_opname.tgl,as_ms_barang.kodebarang,,as_ms_barang.namabarang,,inv_opname.thn_beli,,,,,,,");
	rek.setColWidth("50,100,100,100,200,100,100,100,100,100,100,150");
	rek.setCellAlign("center,center,left,center,left,center,center,center,right,right,left,left");
	rek.setCellHeight(20);
	rek.setImgPath("../icon");
	rek.setIDPaging("paging");
	rek.attachEvent("onRowClick","ambilData");
	rek.baseURL("utils.php?pilihan=opnameInv");
	rek.Init();
</script>
</html>
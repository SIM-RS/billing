<?php
include '../sesi.php';
include '../koneksi/konek.php'; 
//max_execution_time = 100
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/aset/';
        </script>";
}
//"idunit*kodeunit*namaunit";
?>
<?php  include ("../header.php"); ?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: KIB Tanah :.</title>
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
            include ('tanah_mutasi.php');
           
            ?>
				<div align="center" id="tutup" style="display:block">
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="850" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
                                <tr>
                                    <td height="30" valign="bottom" align="right">
									<button type="button" id="ctkxls" name="ctkxls" onClick="ctkKIB_Tnhxls()" style="cursor:pointer"><img src="../icon/excel_logo.png" width="23" height="23" style="vertical-align:middle">&nbsp;Export Ke Excel</button>&nbsp;
									<button type="button" id="ctktnh" name="ctktnh" onClick="ctkKIB_Tnh()" style="cursor:pointer"><img src="../icon/article.gif" style="vertical-align:middle">&nbsp;Cetak KIB Tanah</button>&nbsp;
                                        <input type="hidden" id="txtId" name="txtId" />
										<input type="hidden" id="kd" name="kd">
                                        <!--img src="../images/tambah.png" onclick="location='#.php'" /-->&nbsp;&nbsp;
                                        <img alt="edit" style="cursor: pointer" title="View Barang" src="../images/edit.gif" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;} edit();"/>&nbsp;&nbsp;
                                        <img alt="Mutasi Barang" style="cursor: pointer" title="Mutasi Barang" src="../icon/mutasi.gif" id="btnHapusTanah" name="btnHapus" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}mutasi()" />&nbsp;
                                       <img alt="hapus" src="../images/hapus.gif" style="cursor: pointer" id="btnHapusPO" name="btnHapus" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}OpenWnd('tanah_hapus.php?id='+txtId.value,650,280,'Daftar Ruangan',true);" />&nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div id="gridbox" style="width:876px; height:200px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging" style="width:876px;"></div>
                                    </td>
                                </tr>
                            </table>
                            <?php
                            include '../footer.php';
                            ?>
                            <!--div><img alt="" src="../images/foot.gif" width="1000" height="45" /></div-->
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
    <script type="text/javascript" language="JavaScript">
		function ctkKIB_Tnh(){
		//var kode=document.getElementById('kodeunitlama').value=grid.cellsGetValue(grid.getSelRow(),2);
			window.open('../Laporan/lap_kibTanah.php');
		}
		function ctkKIB_Tnhxls(){
			window.open('../Laporan/lap_kibTanah.php?jenislap=XLS');
		}
		function ambilData(){
		var sisipan=grid.getRowId(grid.getSelRow()).split("|");
		document.getElementById('txtId').value=sisipan[0];
		document.getElementById('kd').value=grid.cellsGetValue(grid.getSelRow(),2)
		grid.Init();
}
	   function edit(){
			window.location='detailTanah.php?act=view&id_kib='+document.getElementById('txtId').value;
        }
		
		function mutasi(){
			document.getElementById('idmutasi').style.display='block';
			document.getElementById('tutup').style.display='none';
			grid.Init();
			var sisipan=grid.getRowId(grid.getSelRow()).split("|");
			document.getElementById('idUnit').value=sisipan[2];
			document.getElementById('txtId').value=sisipan[0];
			document.getElementById('idUnit_lama').value=sisipan[3];
			document.getElementById('kodeunitlama').value=grid.cellsGetValue(grid.getSelRow(),2);
		}
        function goFilterAndSort(tanah){
            if (tanah=="gridbox"){
                grid.loadURL("tanah_util.php?kode=true&filter="+grid.getFilter()+"&sorting="+grid.getSorting()+"&page="+grid.getPage(),"","GET");
            }
        }

        var grid=new DSGridObject("gridbox");
        grid.setHeader(".: Kartu Inventaris Barang - Tanah :.");
        grid.setColHeader("No,Kode Unit,Kode Brg,No Seri,Nama Barang,Luas (m2),Tahun Pengadaan,Asal Barang,Lokasi");
        grid.setIDColHeader(",kodeunit,kodebarang,noseri,namabarang,luas,thn_pengadaan,asalusul,alamat");
        grid.setColWidth("40,150,150,50,200,75,75,100,200");
        grid.setCellAlign("center,center,center,center,left,center,center,center,left");
        grid.setCellHeight(20);
        grid.setImgPath("../icon");
        grid.setIDPaging("paging");
        grid.attachEvent("onRowClick","ambilData");
        grid.baseURL("tanah_util.php?kode=true");
        grid.Init();
		//alert("utils_seri.php?pilihan=tanah");
    </script>
</html>

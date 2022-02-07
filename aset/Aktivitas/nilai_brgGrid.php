<?php
include '../sesi.php';
include '../koneksi/konek.php'; 
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/simrs-tangerang/aset/';
                        </script>";
}
?>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
		<script>
			var arrRange=depRange=[];
			</script>
	<body>
		<div>
<iframe height="72" width="130" name="sort"
			id="sort"
			src="../theme/dsgrid_sort.php" scrolling="no"
			frameborder="0"
			style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>		
		 <table align="center" bgcolor="#FFFBF0" width="200" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;
						</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="800" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div id="gridbox" style="width:750px; height:300px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging" style="width:750px;"></div>
                                    </td>
                                </tr>
                            </table>
                            <?php
                           // include '../footer.php';
                            ?>
                        </td>
                    </tr>
                </table>
				</div>
	</body>
	<script>
	
	function ambilData(){
	window.opener.setNilai(rek.getRowId(rek.getSelRow()));
	window.close();
	}
	function goFilterAndSort(grdRek)
        {
            //alert(grd);
            if (grdRek=="gridbox"){
                //alert("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
                rek.loadURL("nilai_utils.php?pil=seri&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage(),"","GET");
				//alert("nilai_utils.php?pil=seri&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage());
            }
        }
	
		
	var rek=new DSGridObject("gridbox");
        rek.setHeader(".: Data Perubahan Seri :.");
        rek.setColHeader("No,Tahun Pengadaan,Kode Barang,Nama barang");
        rek.setIDColHeader(",thn_pengadaan,kodebarang,namabarang");
        rek.setColWidth("50,100,300,");
        rek.setCellAlign("center,center,left");
        rek.setCellHeight(20);
        rek.setImgPath("../icon");
        rek.setIDPaging("paging");
        rek.attachEvent("onRowClick","ambilData");
        rek.baseURL("nilai_utils.php?pil=seri");
        rek.Init();
	</script>
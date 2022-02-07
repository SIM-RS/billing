<?php
	include("../sesi.php");
	include '../koneksi/konek.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update Kwitansi</title>
    <meta charset="UTF-8">
    <script type="text/JavaScript" language="JavaScript" src="../include/jquery/jquery-1.9.1.js"></script>
  <link type="text/css" rel="stylesheet" href="../theme/mod.css">
  <link rel="stylesheet" href="../theme/bs/bootstrap.min.css">
  <script language="JavaScript" src="../theme/js/dsgrid.js"></script>
  <script language="JavaScript" src="../theme/js/mod.js"></script>
  <link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
  <script type="text/javascript" src="../theme/js/tab-view.js"></script>
  <script type="text/javascript" src="../theme/js/ajax.js"></script>
  <!--dibawah ini diperlukan untuk menampilkan popup-->
  <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
  <script type="text/javascript" src="../theme/prototype.js"></script>
  <script type="text/javascript" src="../theme/effects.js"></script>
  <script type="text/javascript" src="../theme/popup.js"></script>

  <!-- <script type="text/javascript" src="../pembayaran/datatables/jQuery-3.3.1/jquery-3.3.1.js"></script> -->
  <script type="text/javascript" src="../theme/bs/bootstrap.min.js"></script>
    <style>
    	.font-size-14{
    		font-size: 14px;
    	}
    </style>
</head>

<body>
    <div align="center">
        <?php include("../header1.php"); ?>
            <iframe height="72" width="130" name="sort" id="sort" src="../theme/dsgrid_sort.php" scrolling="no" frameborder="0" style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
            <tr>
                <td height="30">&nbsp;RM 2.7 P. BEDAH</td>
            </tr>
        </table>
        <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="left">
                    <select name="tahun" id="tahun">
                        <?php for($i = date('Y'); $i > date('Y') - 5; $i--){ ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php } ?>
                    </select>
					<div id="dataRmPdalam" style="width: 1000px;height: 200px;"></div>
		            <div id="pagingDataRmPdalam" style="width: 1000px;height: 100px;"></div>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
    <script>
        var kwitansi = new DSGridObject("dataRmPdalam");
            kwitansi.setHeader("Data Kwitansi");
            kwitansi.setColHeader("No Pembayaran,Nama Pasien,Tanggal Bayar,Nilai,Action");
            kwitansi.setIDColHeader("b.no_kwitansi,p.nama,,,");
            kwitansi.setColWidth("100,100,100,100,100");
            kwitansi.setCellAlign("center,left,center,center,center");
            kwitansi.setCellHeight(30);
            kwitansi.setImgPath("../icon");
            kwitansi.setIDPaging("pagingDataRmPdalam");
            kwitansi.baseURL("grid.php?tahun="+document.getElementById('tahun').value);
            kwitansi.Init();
        function spawn(){
            kwitansi.baseURL("grid.php?tahun="+document.getElementById('tahun').value, "GET");
            kwitansi.Init();
        }

        function deleteData(val){
            let dataVal = val.split('|');
            if(confirm('Yakin ingin menghapus kwitansi pembayaran ' + dataVal[1] + ' ini ?')){
                jQuery.ajax({
                    url : 'utils.php',
                    method : 'post',
                    data : {
                        id : dataVal[0],
                        no_kwitansi : dataVal[1],
                    },
                    dataType: 'json',
                    success:function(data){
                        if(data.status == 1){
                            alert('Berhasil Menghapus Kwitansi');
                            spawn();
                        }
                        else{ 
                            alert('Gagal Menghapus Kwitansi');
                        }
                    }
                });
            }
        }

        function goFilterAndSort(grd) {
            kwitansi.loadURL("grid.php?&filter=" + kwitansi.getFilter() + "&sorting=" + kwitansi.getSorting() + "&page=" + kwitansi.getPage() + "&tahun="+document.getElementById('tahun').value,"" ,"GET");
        }
    </script>
</body>
</html>

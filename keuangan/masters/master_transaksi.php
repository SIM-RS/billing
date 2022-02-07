<?php
include '../secured_sess.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta http-equiv="Cache-Control" content="no-cache, must-revalidate" />
        <title>.: Master Transaksi :.</title>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <link type="text/css" href="../menu.css" rel="stylesheet" />
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../menu.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
    </head>
    <?php
    include("../koneksi/konek.php");
    $tgl=gmdate('d-m-Y',mktime(date('H')+7));
    $th=explode("-",$tgl);
    ?>
    <body bgcolor="#808080" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <style>
            .tbl
            { font-family:Arial, Helvetica, sans-serif;
              font-size:12px;}
            </style>
            <script type="text/JavaScript">
                var arrRange = depRange = [];
            </script>
        <iframe height="72" width="130" name="sort"
                id="sort"
                src="../theme/dsgrid_sort.php" scrolling="no"
                frameborder="0"
                style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        <div align="center"><?php include("../header.php");?></div>
        <div align="center">
            <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAEFF3">
                <tr>
                    <td height="50">&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top" align="center">
                        <table width="750" border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold">
                            <tr>
                                <td width="50%" style="padding-left:150px;" height="30">Jenis Transaksi</td>
                                <td width="50%">:&nbsp;
                                    <select id="cmbTipe" name="cmbTipe" class="txtinputreg">
                                        <option value="1">Pendapatan</option>
                                        <option value="2">Pengeluaran</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:150px;">Kode Transaksi</td>
                                <td>:&nbsp;
                                    <input id="txtKode" name="txtKode" size="20" class="txtinputreg" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:150px;">Nama</td>
                                <td>:&nbsp;
                                    <input id="txtNama" name="txtNama" size="20" class="txtinputreg" type="text" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" height="50" valign="middle">
					<input type="hidden" id="id" name="id" />
                        <button id="btnSimpan" name="btnSimpan" type="submit" class="tblBtn" onclick="simpan()">Tambah</button>
                        <button id="btnHapus" name="btnHapus" type="submit" class="tblBtn" onclick="hapus()">Hapus</button>
                        <button class="tblBtn" onclick="batal()">Batal</button>
                    </td>
                </tr>
                <tr id="trGrid">
                    <td valign="top" align="center">
                        <div id="divGrid" align="center" style="width:500px; height:250px;">
                            <!--iframe id="ifKso" style="width:925px; height:250px; border:0px;"></iframe-->
                        </div>
                    </td>
                </tr>
                <tr><td style="padding-top:10px"><?php include("../footer.php");?></td></tr>
            </table>
        </div>
    </body>
    <script type="text/javascript" language="javascript">
        var melakukan = '', first_load = 1;
        
        function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
            //alert('combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId);
        }

        function simpan(){
		if(document.getElementById('txtNama').value == ''){
			alert("Nama transaksi harus diisi.");
			return;
		}
            if(melakukan == ''){
                melakukan = 'add';
            }
		  document.getElementById('btnSimpan').disabled = true;
		  document.getElementById('btnHapus').disabled = true;
            var id = document.getElementById('id').value;
            var tipe = document.getElementById('cmbTipe').value;
            var kode = document.getElementById('txtKode').value;
            var nama = document.getElementById('txtNama').value;
            
            var url = "mt_utils.php?pilihan=ms_transaksi&act="+melakukan+"&tipe="+tipe+"&kode="+kode+"&nama="+nama+"&id="+id;

		  //alert(url)
            grid.loadURL(url,'','GET');
        }
	   
	   function hapus(){
		document.getElementById('btnSimpan').disabled = true;
		document.getElementById('btnHapus').disabled = true;
		if(grid.getRowId(grid.getSelRow()) == ''){
			alert('Pilih dulu data yang akan dihapus.');
			return;
		}
		if(confirm("Data master transaksi "+grid.cellsGetValue(grid.getSelRow(),2)+" akan dihapus.\nAnda yakin?")){
			var id = document.getElementById('id').value;
			var url = "mt_utils.php?pilihan=ms_transaksi&act=hapus&id="+id;
			
			grid.loadURL(url, '', 'GET');
		}
		else{
			document.getElementById('btnSimpan').disabled = false;
			document.getElementById('btnHapus').disabled = false;
		}
	   }

        function batal(){
		  document.getElementById('btnSimpan').disabled = false;
		  document.getElementById('btnHapus').disabled = true;
            document.getElementById('btnSimpan').innerHTML = 'Tambah';
            document.getElementById('id').value = '';
            document.getElementById('txtNama').value = '';
            document.getElementById('txtKode').value = '';
            melakukan = '';
        }
	   
        function grid_act(){
		  document.getElementById('btnHapus').disabled = false;
            melakukan = 'edit';
            document.getElementById('btnSimpan').innerHTML = 'Simpan';
		  var sisip = grid.getRowId(grid.getSelRow()).split('|');
		  /*
		  sisip[0] = id
		  sisip[1] = tipe
		  */
		  //no,tgl,nobukti,jenis trans,nilai,keterangan
            document.getElementById('id').value = sisip[0];
            document.getElementById('cmbTipe').value = sisip[1];
            document.getElementById('txtKode').value = grid.cellsGetValue(grid.getSelRow(),2);
            document.getElementById('txtNama').value = grid.cellsGetValue(grid.getSelRow(),3);
        }
	   
	   function grid_loaded(){
            batal();
	   }
        
	   function goFilterAndSort(grd){
            if (grd=="divGrid"){
                grid.loadURL("mt_utils.php?pilihan=ms_transaksi&filter="+grid.getFilter()+"&sorting="+grid.getSorting()+"&page="+grid.getPage(),"","GET");
            }
        }

        grid=new DSGridObject("divGrid");
        grid.setHeader("DATA MASTER TRANSAKSI");
        grid.setColHeader("NO,KODE,NAMA,TIPE TRANSAKSI");
        grid.setIDColHeader(",kode,nama,tipenya");
        grid.setColWidth("30,100,205,100");
        grid.setCellAlign("center,center,left,center");
        grid.setCellHeight(20);
        grid.setImgPath("../icon");
        grid.onLoaded(grid_loaded);
        //grid.setIDPaging("pagingGrid");
        grid.attachEvent("onRowClick","grid_act");
        grid.baseURL("mt_utils.php?pilihan=ms_transaksi");
        grid.Init();
        //+"&supplier="+document.getElementById('cmbSup').value
    </script>
</html>

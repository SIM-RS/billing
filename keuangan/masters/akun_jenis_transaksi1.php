<?php
include '../secured_sess.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta http-equiv="Cache-Control" content="no-cache, must-revalidate" />
        <title>.: Jenis Transaksi :.</title>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <link type="text/css" href="../menu.css" rel="stylesheet" />
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../menu.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
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
                                <input type="hidden" id="txtId" name="txtId" />
                                    <select id="cmbTipe" name="cmbTipe" class="txtinputreg" onchange="change(this.value)">
                                        <option value="1">&nbsp;Pendapatan&nbsp;&nbsp;</option>
                                        <option value="2">&nbsp;Pengeluaran&nbsp;</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" style="padding-left:150px;" height="30">Nama Transaksi</td>
                                <td width="50%">:&nbsp;
                                    <select id="cmbNama" name="cmbNama" class="txtinputreg">
                                       
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:150px;">Kode Rekening Akuntansi</td>
                                <td>:&nbsp;
                                    <input type="hidden" id="id_ma_sak" name="id_ma_sak" />
                                    <input id="kode_ma_sak" name="kode_ma_sak" size="20" class="txtinputreg" type="text" readonly="readonly" />&nbsp;<img src="../icon/view_tree.gif" align="absmiddle" style="cursor:pointer" onclick="OpenWnd('tree_ma_view_sak.php?par=id_ma_sak*kode_ma_sak*nama_ma_sak',800,500,'msma',true)" />
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:150px;">&nbsp;</td>
                                <td>&nbsp;&nbsp;
                                    <textarea id="nama_ma_sak" name="nama_ma_sak" class="txtcenterreg" style="text-align:justify; width:250px" readonly="readonly"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:150px;">Debet / Kredit</td>
                                <td>:&nbsp;
                                    <select id="cmbDK" class="txtinputreg">
                                    	<option value="D">&nbsp;Debet&nbsp;&nbsp;</option>
                                        <option value="K">&nbsp;Kredit&nbsp;&nbsp;</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" height="50" valign="middle">
                        <button id="btnSimpan" name="btnSimpan" type="submit" class="tblBtn" onclick="simpan(this.value)" value="add">Tambah</button>
                        <button id="btnHapus" name="btnHapus" type="submit" class="tblBtn" onclick="hapus()">Hapus</button>
                        <button class="tblBtn" onclick="batal()">Batal</button>
                    </td>
                </tr>
                <tr id="trGrid">
                    <td valign="top" align="center">
                        <div id="divGrid" align="center" style="width:900px; height:250px;">
                        </div>
                    </td>
                </tr>
                <tr><td style="padding-top:10px"><?php include("../footer.php");?></td></tr>
            </table>
        </div>
        
    </body>
    <script type="text/javascript" language="javascript">
	    isiCombo('cmbTransaksi',document.getElementById('cmbTipe').value,0,'cmbNama');
		function change(tipe){
			isiCombo('cmbTransaksi',tipe,0,'cmbNama');
		}
		function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }

        function simpan(act){
			document.getElementById('btnSimpan').disabled = true;
		 	document.getElementById('btnHapus').disabled = true;
            var id = document.getElementById('txtId').value;
            var id_ma_sak = document.getElementById('id_ma_sak').value;
			var dk = document.getElementById('cmbDK').value;
			var id_transaksi = document.getElementById('cmbNama').value;  
            
			
            var url = "ajt_util.php?act="+act+"&id="+id+"&id_ma_sak="+id_ma_sak+"&dk="+dk+'&id_transaksi='+id_transaksi;
            alert(url);
			//grid.loadURL(url,'','GET');
        }
		
		function hapus(){
			if(document.getElementById('txtId').value=='' || document.getElementById('txtId').value==null){
				alert('Mana yang ingin di hapus?');
				return false;
			}
			grid.loadURL('ajt_util.php?act=del&id='+document.getElementById('txtId').value,'','GET');
		}
	   
        function batal(){
		    document.getElementById('btnSimpan').disabled = false;
		    document.getElementById('btnHapus').disabled = true;
            document.getElementById('btnSimpan').innerHTML = 'Tambah';
			document.getElementById('btnSimpan').value = 'add';
            document.getElementById('txtId').value = '';
            document.getElementById('kode_ma_sak').value = '';
            document.getElementById('nama_ma_sak').innerHTML = '';
            document.getElementById('cmbDK').value = 'D';
        }
	   
        function grid_act(){
		    document.getElementById('btnHapus').disabled = false;
            document.getElementById('btnSimpan').innerHTML = 'Simpan';
			document.getElementById('btnSimpan').value = 'edit';
			
		    var sisip = grid.getRowId(grid.getSelRow()).split('|');
            document.getElementById('txtId').value = sisip[0];
			document.getElementById('id_ma_sak').value = sisip[2];
            document.getElementById('kode_ma_sak').value = grid.cellsGetValue(grid.getSelRow(),2);
            document.getElementById('nama_ma_sak').innerHTML = grid.cellsGetValue(grid.getSelRow(),3);
			document.getElementById('cmbDK').value = sisip[1];
        }
	   
	   function goFilterAndSort(grd){
            if (grd=="divGrid"){
                grid.loadURL("mt_utils.php?pilihan=ms_transaksi&filter="+grid.getFilter()+"&sorting="+grid.getSorting()+"&page="+grid.getPage(),"","GET");
            }
        }

        grid=new DSGridObject("divGrid");
        grid.setHeader("DATA MASTER TRANSAKSI");
        grid.setColHeader("NO,KODE REKENING,NAMA REKENING,TIPE TRANSAKSI,NAMA TRANSAKSI,DEBET/KREDIT");
        grid.setIDColHeader(",kode,nama,tipenya");
        grid.setColWidth("30,60,205,100,130,100");
        grid.setCellAlign("center,center,left,center,left,center");
        grid.setCellHeight(20);
        grid.setImgPath("../icon");
        grid.onLoaded(batal);
        grid.attachEvent("onRowClick","grid_act");
        grid.baseURL("ajt_util.php");
        grid.Init();

    </script>
</html>

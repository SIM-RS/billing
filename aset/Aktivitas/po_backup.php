<?php
include '../sesi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/aset/';
                        </script>";
}
date_default_timezone_set("Asia/Jakarta");
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: PO :.</title>
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
                            <table width="850" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
                                <tr>
                                    <td height="30" valign="bottom" align="right">
									<div style="float:left; width:250px; margin-left:-25px;">
									<form action="">
									<select name="bulan" id="bulan" class="txtinput" onChange="goFilterAndSort('gridbox')">
									  <option value="01" class="txtinput"<?php if ($bulan=="1") echo "selected";?>>Januari</option>
									  <option value="02" class="txtinput"<?php if ($bulan=="2") echo "selected";?>>Pebruari</option>
									  <option value="03" class="txtinput"<?php if ($bulan=="3") echo "selected";?>>Maret</option>
									  <option value="04" class="txtinput"<?php if ($bulan=="4") echo "selected";?>>April</option>
									  <option value="05" class="txtinput"<?php if ($bulan=="5") echo "selected";?>>Mei</option>
									  <option value="06" class="txtinput"<?php if ($bulan=="6") echo "selected";?>>Juni</option>
									  <option value="07" class="txtinput"<?php if ($bulan=="7") echo "selected";?>>Juli</option>
									  <option value="08" class="txtinput"<?php if ($bulan=="8") echo "selected";?>>Agustus</option>
									  <option value="9" class="txtinput"<?php if ($bulan=="9") echo "selected";?>>September</option>
									  <option value="10" class="txtinput"<?php if ($bulan=="10") echo "selected";?>>Oktober</option>
									  <option value="11" class="txtinput"<?php if ($bulan=="11") echo "selected";?>>Nopember</option>
									  <option value="12" class="txtinput"<?php if ($bulan=="12") echo "selected";?>>Desember</option>
									</select>                                        
									 Tahun : 
									<select name="ta" id="ta" class="txtinput" onChange="goFilterAndSort('gridbox')">
									<?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
									  <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?>
									  </option>
									  <?php }?>
									  </select>
									  </form>
									  </div>
									<button type="button" onClick="Cetak_PO();" style="cursor: pointer">
                            <img alt="add" src="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Cetak Daftar PO
                        </button>
					<input type="hidden" id="txtId" name="txtId" />
                                        <input type="hidden" id="no_po" name="no_po" />
                                        <img alt="tambah" src="../images/tambah.png" style="cursor: pointer" onClick="location='detailPo.php?act=add'" />&nbsp;&nbsp;
                                        <img alt="edit" src="../images/edit.gif" style="cursor: pointer" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){
					alert('Pilih dulu PO yang akan diedit.');return;}location='detailPo.php?act=edit&no_po='+document.getElementById('no_po').value;" />&nbsp;&nbsp;
                                        <img alt="hapus" src="../images/hapus.gif" style="cursor: pointer" id="btnHapusPO" name="btnHapus" onClick="hapus();" />&nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div id="gridbox" style="width:950px; height:200px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging" style="width:950px;"></div>
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

	function Cetak_PO(){	    
	    var bln_po=document.getElementById('bulan').value;
	    var thn_po=document.getElementById('ta').value;
	    if(bln_po=='' || thn_po==''){
		alert("Silakan pilih data terlebih dahulu!");
	    }else{
		window.open('po_cetak.php?bln_po='+bln_po+'&thn_po='+thn_po,'Cetak_PO');
	    }
	}
	
        function ambilData()
        {
            var p="txtId*-*"+(rek.getRowId(rek.getSelRow()))+"*|*no_po*-*"+rek.cellsGetValue(rek.getSelRow(),3);
            fSetValue(window,p);
        }

        function hapus()
        {
            var rowid = document.getElementById("txtId").value;
            if(confirm("Anda yakin menghapus PO "+rek.cellsGetValue(rek.getSelRow(),2))){
                rek.loadURL("utils.php?pilihan=po&act=hapus_po&id="+rowid,"","GET");
            }
        }


        function goFilterAndSort(pilihan){
            if (pilihan=="gridbox")
            {
                rek.loadURL("utils.php?pilihan=po&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage()+"&bln="+document.getElementById('bulan').value+"&ta="+document.getElementById('ta').value,"","GET");
            }
			//alert ("utils.php?pilihan=po&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage()+"&bln="+document.getElementById('bulan').value+"&ta="+document.getElementById('ta').value);
        }

        var rek=new DSGridObject("gridbox");
        rek.setHeader(".: Data PO :.");
        rek.setColHeader("No,Tanggal,No PO,Judul PO,Rekanan,Exp Kirim,Biaya");
        //Jenis Barang,Jml Kemasan,Kemasan Diterima
        rek.setIDColHeader(",tgl_po,no_po,judul,vendor_id,exp_kirim,biaya");
        //,tipebarang,qty_kemasan,qty_kemasan_terima
        rek.setColWidth("50,100,100,250,200,100,100");
        rek.setCellAlign("center,center,center,left,left,center,right");
        rek.setCellHeight(20);
        rek.setImgPath("../icon");
        rek.setIDPaging("paging");
        rek.attachEvent("onRowClick","ambilData");
        rek.baseURL("utils.php?pilihan=po&bln="+document.getElementById('bulan').value+"&ta="+document.getElementById('ta').value);
        rek.Init();
        //alert("utils.php?pilihan=po&bln="+document.getElementById('bulan').value+"&ta="+document.getElementById('ta').value);
    </script>
</html>
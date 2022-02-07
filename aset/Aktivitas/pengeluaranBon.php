<?php
include '../sesi.php';
include '../koneksi/konek.php'; 
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/aset/';
        </script>";
}
date_default_timezone_set("Asia/Jakarta");
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: Pengeluaran Bon :.</title>
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
            <table align="center" width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFBF0">
                <tr>
                    <td height="20" colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4" align="center" style="font-size:16px;">DAFTAR PENGELUARAN BON</td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="45%">
                        <span class="txtinput">BULAN : </span>
                        <select name="bulan" class="txt" id="bulan" onChange="filter()">
                            <option value="1" class="txtinput"<?php if ($th[1]=="1") echo "selected";?>>Januari</option>
                            <option value="2" class="txtinput"<?php if ($th[1]=="2") echo "selected";?>>Pebruari</option>
                            <option value="3" class="txtinput"<?php if ($th[1]=="3") echo "selected";?>>Maret</option>
                            <option value="4" class="txtinput"<?php if ($th[1]=="4") echo "selected";?>>April</option>
                            <option value="5" class="txtinput"<?php if ($th[1]=="5") echo "selected";?>>Mei</option>
                            <option value="6" class="txtinput"<?php if ($th[1]=="6") echo "selected";?>>Juni</option>
                            <option value="7" class="txtinput"<?php if ($th[1]=="7") echo "selected";?>>Juli</option>
                            <option value="8" class="txtinput"<?php if ($th[1]=="8") echo "selected";?>>Agustus</option>
                            <option value="9" class="txtinput"<?php if ($th[1]=="9") echo "selected";?>>September</option>
                            <option value="10" class="txtinput"<?php if ($th[1]=="10") echo "selected";?>>Oktober</option>
                            <option value="11" class="txtinput"<?php if ($th[1]=="11") echo "selected";?>>Nopember</option>
                            <option value="12" class="txtinput"<?php if ($th[1]=="12") echo "selected";?>>Desember</option>
                        </select>
                        
                        <select name="ta" class="txt" id="ta" onChange="filter()">
                            <?php
                            for ($i=($th[2]-5);$i<($th[2]+1);$i++){
                                ?>
                            <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$th[2]) echo "selected";?>><?php echo $i;?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <input type="hidden" id="id" name="id" />
                    </td>
                    <td width="45%" align="right">
                        <button type="button" onClick="location='pengeluaranBon_detil.php?act=add'" style="cursor: pointer">
                            <img alt="add" src="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Pengeluaran Baru
                        </button>
                        <button type="button" style="cursor: pointer" onClick="if(document.getElementById('id').value == '' || document.getElementById('id').value == null){alert('Pilih dulu Penerimaan yang akan diedit.');return;}location='pengeluaranBon_detil.php?act=edit&id='+document.getElementById('id').value;">
                            <img alt="add" src="../icon/edit.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Detail Pengeluaran
                        </button>
                    </td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4" align="center">
                        <div id="gridbox" style="width:900px; height:290px; background-color:white; overflow:hidden;"></div>
						<div id="total_bon" style="width:900px; height:20px; padding:5px; background-color:white; overflow:hidden; text-align:right; padding-right:40px;"></div>
                        <div id="paging" style="width:900px;"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                <?php
                include '../footer.php';
                ?>
                    </td>
                </tr>
            </table>
        </div>
    </body>
    <script type="text/javascript" language="javascript">
        function filter()
        {
            var bln = document.getElementById("bulan").value;
            var thn = document.getElementById("ta").value;
            //alert("utils.php?pilihan=penerimaanpo&bln="+bln+"&thn="+thn);
            po.loadURL("pengeluaranBon_util.php?bln="+bln+"&thn="+thn,"","GET");
        }

        function goFilterAndSort(grd)
        {
            var bln = document.getElementById("bulan").value;
            var thn = document.getElementById("ta").value;
            if (grd=="gridbox")
			{
                po.loadURL("pengeluaranBon_util.php?bln="+bln+"&thn="+thn+"&filter="+po.getFilter()+"&sorting="+po.getSorting()+"&page="+po.getPage(),"","GET");
            }
        }
        
        function balikTgl(tgl){
            var part = tgl.split("-");
            var temp=part[2]+"-"+part[1]+"-"+part[0];
            return temp;
        }
        
        function ambilData()
        {
            var sisip = po.getRowId(po.getSelRow()).split('*|*');            
            var p="id*-*"+(balikTgl(po.cellsGetValue(po.getSelRow(),4))+'|'+po.cellsGetValue(po.getSelRow(),5)+'|'+po.cellsGetValue(po.getSelRow(),6)+'|'+po.cellsGetValue(po.getSelRow(),2)+'|'+sisip[1]+'|'+sisip[2]+'|'+sisip[0]+'|'+po.cellsGetValue(po.getSelRow(),3));
            fSetValue(window,p);
        }

        var po=new DSGridObject("gridbox");
        po.setHeader(".: DAFTAR PENGELUARAN BON :.");
        po.setColHeader("NO,TGL.KELUAR,NOMOR KELUAR,TGL.BON,NOMOR BON,PERUNTUKAN,NILAI");
        po.setIDColHeader(",k.tgl_gd,k.no_gd,k.tgl_transaksi,k.kode_transaksi,u.namaunit,k.nilai");
        po.setColWidth("50,100,130,100,130,250,100");
        po.setCellAlign("center,center,center,center,center,left,right");
        po.setCellHeight(20);
		po.onLoaded(loading);
        po.setImgPath("../icon");
        po.setIDPaging("paging");
        po.attachEvent("onRowClick","ambilData");
        //alert("utils.php?pilihan=keluarbon&bln="+document.getElementById("bulan").value+"&thn="+document.getElementById("ta").value);
        po.baseURL("pengeluaranBon_util.php?bln="+document.getElementById("bulan").value+"&thn="+document.getElementById("ta").value);
        po.Init();
		
		
		function loading()
		{
			setTimeout("cek_total_bon()",400);
		}
		
		function cek_total_bon()
		{
			var bln = document.getElementById("bulan").value;
			var thn = document.getElementById("ta").value;
			var dataString = "bln="+bln+"&thn="+thn+"&filter="+po.getFilter()+"&sorting="+po.getSorting()+"&page="+po.getPage();//alert(dataString)
			$.ajax({
			type: "POST",
			url: "cetak_total_bon.php",
			data: dataString,
			success: function(msg)
				{
					//alert(msg);
					document.getElementById("total_bon").innerHTML= '<b>Total Nilai</b> : '+msg;
				}
				});
		}
		
		
    </script>
</html>

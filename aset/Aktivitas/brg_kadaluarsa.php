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
        <title>.: Barang Kadaluarsa :.</title>
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
                    <td colspan="4" align="center" style="font-size:16px;">DAFTAR BARANG KADALUARSA</td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="45%">
                        <span class="txt">BULAN : </span>
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
                    <td width="45%" align="right">&nbsp;
                        
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
            po.loadURL("kadaluarsa_utils.php?bln="+bln+"&thn="+thn,"","GET");
        }

        function goFilterAndSort(grd)
        {
            var bln = document.getElementById("bulan").value;
            var thn = document.getElementById("ta").value;
            if (grd=="gridbox"){
                po.loadURL("kadaluarsa_utils.php?bln="+bln+"&thn="+thn+"&filter="+po.getFilter()+"&sorting="+po.getSorting()+"&page="+po.getPage(),"","GET");
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
		function batalKan(kode){
		    var bln = document.getElementById("bulan").value;
            var thn = document.getElementById("ta").value;
			//alert(kode);
			po.loadURL("kadaluarsa_utils.php?act=batalkan&kodeT="+kode+"&bln="+bln+"&thn="+thn,"","GET");
			//alert("kadaluarsa_utils.php?act=batalkan&kodeT="+kode+"&bln="+bln+"&thn="+thn);
		}

        var po=new DSGridObject("gridbox");
        po.setHeader(".: DAFTAR BARANG KADALUARSA :.");
        po.setColHeader("NO,TGL BON,NOMOR BON,PERUNTUKAN,STATUS,ACTION");
        po.setIDColHeader(",tgl_transaksi,kode_transaksi,namaunit,k.stt,");
        po.setColWidth("50,150,150,300,100,");
        po.setCellAlign("center,center,center,center,center,center,");
        po.setCellHeight(20);
        po.setImgPath("../icon");
        po.setIDPaging("paging");
        po.attachEvent("onRowClick","ambilData");
		//alert("kadaluarsa_utils.php?bln="+document.getElementById("bulan").value+"&thn="+document.getElementById("ta").value);
        po.baseURL("kadaluarsa_utils.php?bln="+document.getElementById("bulan").value+"&thn="+document.getElementById("ta").value);
        po.Init();
    </script>
</html>

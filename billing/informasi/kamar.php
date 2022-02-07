<?php
session_start();
include "../sesi.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <title>Informasi Kamar</title>
    </head>

    <body>
        <div align="center">
            <?php
			include("../koneksi/konek.php");
            include("../header1.php");
                    ?>
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;INFORMASI KAMAR</td>
                </tr>
            </table>
            <table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
                <tr>
                    <td colspan="7">&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="20%" align="right">Jenis Layanan :</td>
                    <td width="20%">&nbsp;
                        <select id="JnsLayanan" name="JnsLayanan" onchange="showTmpLay(this.value)" class="txtinput">
                            <?php
                            $query = "select id,nama from b_ms_unit where aktif=1 and level=1 and inap = 1 and id<>68";
                            $rs = mysql_query($query);
                            while($row=mysql_fetch_array($rs)){
                            ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['nama']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                    <td width="10%">&nbsp;</td>
                    <td width="20%" align="right"></td>
                    <td width="20%"></td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Tempat Layanan :</td>
                    <td>&nbsp;
                        <select id="TmpLayanan" name="TmpLayanan" onchange="showTabel()" class="txtinput">
                        </select>
                    </td>
                    <td>&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="5" align="center">
                        <div id="gridbox" style="width:900px; height:350px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="7">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="7">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="7">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="7">&nbsp;</td>
                </tr>
            </table>
            <table border="0" class="hd2" width="1000">
                <tr>
                    <td><input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right"><input type="button" value="&nbsp;&nbsp;&nbsp;Cetak&nbsp;&nbsp;&nbsp;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a></td>
                </tr>
            </table>
        </div>
    </body>
    <script type="text/JavaScript" language="JavaScript">
        //isiCombo('JnsLayanan','','','',showTmpLay);
        function showTmpLay(val){
            isiCombo('TmpLayanan',val,'','',showTabel);
        }
        //isiCombo('cmbKlasi');
        function isiCombo(id,val,defaultId,targetId,evloaded){
            //alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET');
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
        }

        function showTabel(){
            //alert("tabel_utils.php?grdkmr=true&jns="+document.getElementById('JnsLayanan').value+"&unit_id="+document.getElementById('TmpLayanan').value);
            //alert("tabel_utils.php?grdkmr=true&unit_id="+document.getElementById('TmpLayanan').value);
			a.loadURL("tabel_utils.php?grdkmr=true&unit_id="+document.getElementById('TmpLayanan').value,"","GET");
            //&jns="+document.getElementById('JnsLayanan').value+"
            //+"&cmbKlasi="+document.getElementById('cmbKlasi').value
        }
        function goFilterAndSort(grd){
            //alert(grd);
            if (grd=="gridbox"){
                a.loadURL("tabel_utils.php?grdkmr=true&unit_id="+document.getElementById('TmpLayanan').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
                //&jns="+document.getElementById('JnsLayanan').value+"
            }
        }
        showTmpLay(document.getElementById('JnsLayanan').value);
        var a=new DSGridObject("gridbox");
        a.setHeader("DATA KAMAR");
        a.setColHeader("NO,KAMAR,KELAS,TARIF,JUMLAH TEMPAT TIDUR,JUMLAH TEMPAT TIDUR TOTAL,JUMLAH KAMAR TERPAKAI,JUMLAH KAMAR YANG TERSEDIA");
        a.setIDColHeader(",kamar,,,,,,,");
        a.setColWidth("50,200,100,90,80,80,80,80,80");
        a.setCellAlign("center,left,center,right,center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowDblClick","tes1");
        a.baseURL("tabel_utils.php?grdkmr=true&unit_id="+document.getElementById('TmpLayanan').value);
            //&jns="+document.getElementById('JnsLayanan').value+"
        a.Init();
    </script>
</html>
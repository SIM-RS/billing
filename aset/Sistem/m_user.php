<?
include '../sesi.php';
?>
<?php
include '../koneksi/konek.php';
if(isset($_SESSION['userid']) && $_SESSION['userid'] != '') {
    $query = "select usertype from as_ms_user where userid = '".$_SESSION['userid']."' and usertype = 'A'";
    $rs = mysql_query($query);
    $res = mysql_affected_rows();
    if($res > 0) {
        $permit = '';
    }
    else {
        $permit = 'none';
    }
}
else {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/logistic/';
                        </script>";
}
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>Manajemen User</title>
    </head>

    <body>
	<iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
        <div align="center">
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
                                <tr style="display: <?php echo $permit;?>">
                                    <td height="30" valign="bottom" align="right">
                                        <input type="hidden" id="txtId" name="txtId" />
                                        <img alt="tambah" style="cursor: pointer" src="../images/tambah.png" onClick="location='detail_m_user.php?act=add'" />&nbsp;&nbsp;
                                        <img alt="edit" style="cursor: pointer" src="../images/edit.gif" onClick="location='detail_m_user.php?act=edit&iduser='+document.getElementById('txtId').value" />&nbsp;&nbsp;
                                        <img alt="hapus" style="cursor: pointer" src="../images/hapus.gif" id="btnHapus" name="btnHapus" onClick="hapus();" />&nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div id="gridbox" style="width:975px; height:275px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging" style="width:975px;"></div>
                                    </td>
                                </tr>
                            </table>
                            <?php
                            include '../footer.php';
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
    <script type="text/javascript" language="javascript">
        function ambilData()
        {
            var p="txtId*-*"+(brg.getRowId(brg.getSelRow()));
            fSetValue(window,p);
        }

        function hapus()
        {
            var rowid = document.getElementById("txtId").value;
            var userid = brg.cellsGetValue(brg.getSelRow(),1);

            if("<?php echo isset($_SESSION['userid']);?>" == true){
                if(confirm("Anda yakin menghapus User "+brg.cellsGetValue(brg.getSelRow(),2)))
                {
                    if(userid == "<?php echo $_SESSION['userid'];?>"){
                        alert("Anda tidak dapat menghapus user anda sendiri.");
                        return;
                    }
                    /*new Ajax.Request(
                    "user_proc.php?act=authority_check&userid="+rowid,
                    {
                        method: 'get',
                        onComplete: function(r)
                        {
                            var hsl = r.responseText;
                        }
                    });*/
                    brg.loadURL("utils_utils.php?pilihan=m_user&act=hapus_user&rowid="+rowid,"","GET");
                }
            }
            else{
                alert('Session anda habis, silakan login ulang.');
                window.location = "/simrs-tangerang/aset";
            }
        }

        function goFilterAndSort(grd)
        {
            //alert(grd);
            if (grd=="gridbox"){
               //alert("utils_utils.php?pilihan=m_user&filter="+brg.getFilter()+"&sorting="+brg.getSorting()+"&page="+brg.getPage());
                brg.loadURL("utils_utils.php?pilihan=m_user&filter="+brg.getFilter()+"&sorting="+brg.getSorting()+"&page="+brg.getPage(),"","GET");
            }
        }

        var brg=new DSGridObject("gridbox");
        brg.setHeader(".: Data Management User :.");
        brg.setColHeader("No,Login,Nama,Tipe,Unit,Alamat,Telp,Email,Status");
        brg.setIDColHeader(",userid,username,usertype,namaunit,address,telp,email,");
        brg.setColWidth("30,90,170,30,160,170,100,180,100");
        brg.setCellAlign("center,left,left,center,left,left,center,center,center");
        brg.setCellHeight(20);
        brg.setImgPath("../icon");
        brg.setIDPaging("paging");
        brg.attachEvent("onRowClick","ambilData");
        brg.baseURL("utils_utils.php?pilihan=m_user");
        brg.Init();
    </script>
</html>

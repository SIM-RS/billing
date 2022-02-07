<?php
include '../sesi.php';
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
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
                        window.location='/simrs-tangerang/aset/';
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
        <title>Perubahan</title>
    </head>

    <body>
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
                                        <img alt="tambah" style="cursor: pointer" src="../images/tambah.png" onClick="location='detailPerubahan.php?act=add'" />&nbsp;&nbsp;
                                        <img alt="edit" style="cursor: pointer" src="../images/edit.gif" onClick="location='detailPerubahan.php?act=edit&idperubahan='+document.getElementById('txtId').value" />&nbsp;&nbsp;
                                        <img alt="hapus" style="cursor: pointer" src="../images/hapus.gif" id="btnHapus" name="btnHapus" onClick="hapus();" />&nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div id="gridbox" style="width:825px; height:200px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging" style="width:825px;"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><u>Keterangan</u></strong></td>
                                </tr>
                                <tr>
                                    <td nowrap>
                                        <strong>Jenis </strong> ( 201 = Pengurangan Nilai | 202 = Penambahan Nilai | 204 = Koreksi | 209 = Opname )
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
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
                if(confirm("Anda yakin menghapus Data Perubahan "+brg.cellsGetValue(brg.getSelRow(),7)))
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
                    brg.loadURL("utils.php?pilihan=perubahan&act=hapus_perubahan&rowid="+rowid,"","GET");
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
                //alert("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
                brg.loadURL("utils.php?pilihan=perubahan&filter="+brg.getFilter()+"&sorting="+brg.getSorting()+"&page="+brg.getPage(),"","GET");
            }
        }

        var brg=new DSGridObject("gridbox");
        brg.setHeader(".: Data Perubahan :.");
        brg.setColHeader("ID,Unit,Tgl,T/K,Jenis,Kode,Nama Barang,No.Ref,Lokasi,Void");
        //a.setIDColHeader(",kode,nama,aktif");
        brg.setColWidth("20,50,100,25,50,75,150,70,80,30");
        brg.setCellAlign("center,center,center,center,center,center,left,center,left,center");
        brg.setCellHeight(20);
        brg.setImgPath("../icon");
        brg.setIDPaging("paging");
        brg.attachEvent("onRowClick","ambilData");
        brg.baseURL("utils.php?pilihan=perubahan");
        brg.Init();
    </script>
</html>

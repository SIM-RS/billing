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
                        window.location='/simrs-tangerang/aset/';
                        </script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>Setting Akses Menu</title>
    </head>
    
    <body>
        <?php
            include("../header.php");
        ?>
        
        <div align="center">
            <div id="divbarang" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" colspan=2 class="jdltable">
                            HAK AKSES MENU
                        </td>
                    </tr>
                    <tr>
                        <td align="center" width=100>
                            Nama User :
                        </td>
                        <td>
                            <select id="cmbUser" name="cmbUser" class='txt'>
                            <?php
                            //$sql = "select jns_id,jns from as_jenis_surat";
                            $sql="SELECT id,username FROM as_ms_user WHERE STATUS=1 ORDER BY username";
                            $rsJ = mysql_query($sql);
                            while($rowJ = mysql_fetch_array($rsJ)){
                                echo "<option value='".$rowJ['id']."' ";
                                if($rowJ['id'] == $rows1['jenis_surat']){
                                    echo "selected";
                                }
                                echo " >".$rowJ['username']."</option>";
                            }
                            ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2 class="tdlabel" height=50> </td>
                    </tr>
                </table>
                
                <table align="center" bgcolor="#FFFBF0" width="1000" border="1" cellpadding="0" cellspacing="0">
                    <tr class="header" valign="middle">
                        <td height=25 width=160><input type="checkbox" name="chkSstem" id="chkSistem" /> Sistem</td>
                        <td width=160><input type="checkbox" name="chk" id="chk"/>Master</td>
                        <td width=160><input type="checkbox" name="chk" id="chk"/>RTP</td>
                        <td width=160><input type="checkbox" name="chk" id="chk"/>Gudang</td>
                        <td width=160><input type="checkbox" name="chk" id="chk"/>UPB</td>
                        <td width=160><input type="checkbox" name="chk" id="chk"/>Laporan</td>
                        <td width=160><input type="checkbox" name="chk" id="chk"/>Logout</td>
                    </tr>
                    <tr class="label">
                        <td><input type="checkbox" name="chk" id="chk"/>Info User</td>
                        <td><input type="checkbox" name="chk" id="chk"/>Kode Barang</td>
                        <td><input type="checkbox" name="chk" id="chk"/>PO</td>
                        <td><input type="checkbox" name="chk" id="chk"/>Penerimaan Barang</td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                        <td></td>
                    </tr>
                    <tr class="label">
                        <td><input type="checkbox" name="chk" id="chk"/>Ganti Password</td>
                        <td><input type="checkbox" name="chk" id="chk"/>Unit Kerja</td>
                        <td><input type="checkbox" name="chk" id="chk"/>Bon Barang</td>
                        <td><input type="checkbox" name="chk" id="chk"/>Pengeluaran Bon</td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                    </tr>
                    <tr class="label">
                        <td><input type="checkbox" name="chk" id="chk"/>Manajemen User</td>
                        <td><input type="checkbox" name="chk" id="chk"/>Gedung</td>
                        <td><input type="checkbox" name="chk" id="chk"/>Tagihan</td>
                        <td><input type="checkbox" name="chk" id="chk"/>Stok Opname</td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                    </tr>
                    <tr class="label">
                        <td><input type="checkbox" name="chk" id="chk"/>Setting Global</td>
                        <td><input type="checkbox" name="chk" id="chk"/>Sumber Dana</td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                    </tr>
                    <tr class="label">
                        <td><input type="checkbox" name="chk" id="chk"/>Setting Akses Menu</td>
                        <td><input type="checkbox" name="chk" id="chk"/>Ruangan</td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                    </tr>
                    <tr class="label">
                        <td></td>
                        <td><input type="checkbox" name="chk" id="chk"/>Rekanan</td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                        <td><input type="checkbox" name="chk" id="chk"/></td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
    
</html>

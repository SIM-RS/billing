<?php
include '../secured_sess.php';
include '../sesi.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta http-equiv="Cache-Control" content="no-cache, must-revalidate" />
        <title>.: Manajemen User :.</title>
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
    ?>
    <body bgcolor="#808080" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
            <script type="text/JavaScript">
                var arrRange = depRange = [];
            </script>
            <iframe height="193" width="168" name="gToday:normal:agenda.js"
                    id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                    style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
        <style type="text/css">
            .tbl
            { font-family:Arial, Helvetica, sans-serif;
              font-size:12px;}
            </style>
            <div align="center"><?php include("../header.php");?></div>
            <div align="center">
                <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAEFF3">
                    <tr>
                        <td height="50">&nbsp;</td>
                    </tr>
                    <tr id="trGrid">
                        <td valign="top" align="center">
                            <fieldset style="width:600px">
                            <legend style="margin-left:530px">
                                <img src="../icon/add16.gif" alt="Add User" title="Tambah User" id="btn_add" style="cursor:pointer" onclick="act(this)" />
                                <img src="../icon/edit.gif" alt="Edit User" title="Edit User" id="btn_edit" style="cursor:pointer" onclick="act(this)" />
                                <img src="../icon/del16.gif" alt="Delete User" title="Hapus User" id="btn_del" style="cursor:pointer" onclick="act(this)" />
                            </legend>
                            <div id="divGrid" align="center" style="width:580px; height:250px;">
                            </div>
                        </fieldset><br />
                    </td>
                </tr>
                <tr id="trDet" style="display:none">
                    <td style="padding-left:350px;">
                        <table>
                            <tr>
                                <td>
                                    Nama
                                </td>
                                <td>
                                    :
                                </td>
                                <td>
                                    <input type="hidden" id="hidId" name="hidId" />
                                    <input type="text" id="txtName" name="txtName" class="txtleft" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    User Name
                                </td>
                                <td>
                                    :
                                </td>
                                <td>
                                    <input type="text" id="txtUser" name="txtUser" class="txtleft" />
                                </td>
                            </tr>
                            <!-- <tr>
                                <td>
                                    Flag
                                </td>
                                <td>
                                    :
                                </td>
                                <td> -->
                                <input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="17" value="<?php echo $flag; ?>"/>
                                <!-- </td>
                            </tr> -->
                            <tr>
                                <td>
                                    Hak Akses
                                </td>
                                <td>
                                    :
                                </td>
                                <td>
                                    <select id="cmbHak" name="cmbHak" class="txtleft">
                                        <option value="0">Keuangan</option>
                                        <option value="1">Admin</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <label style="font-size:11px; font-style:italic">
                                        <input type="checkbox" onchange="act(this)" id="chkPass" />ganti password
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Password
                                </td>
                                <td>
                                    :
                                </td>
                                <td>
                                    <input type="password" id="txtPass" name="txtPass" class="txtleft" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Confirm Password
                                </td>
                                <td>
                                    :
                                </td>
                                <td>
                                    <input type="password" id="txtConf" name="txtConf" class="txtleft" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2'>&nbsp;
                                    
                                </td>
                                <td>
                                    <span id="divTmp" style="display: none"></span>
                                    <input type="button" id="btn_save" class="tblbtn" value="Simpan" onclick="act(this)" />
                                    <input type="button" id="btn_cancel" class="tblbtn" value="Batal" onclick="act(this)" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td><?php include("../footer.php");?></td></tr>
            </table>
            <?php include("../laporan/report_form.php");?>
        </div>
    </body>
    <script type="text/javascript">
        var melakukan = '';
        function act(par){
            var tmp = grid.getRowId(grid.getSelRow()).split('|');
            var hak = "<?php echo $_SESSION['hak']; ?>";
            if(hak == 0){
                document.getElementById('cmbHak').disabled = true;
                if(tmp[0] != "<?php echo $_SESSION['id'];?>"){
                    alert('Anda tidak memiliki hak akses untuk menambah, mengubah dan menghapus data.\nHak akses anda hanya mengubah user anda sendiri.');
                    return;
                }
            }
            
            switch(par.id){
                case 'btn_add':
                    melakukan = 'add';
                    document.getElementById('trDet').style.display = 'table-row';
                    document.getElementById('trGrid').style.display = 'none';
                    document.getElementById('chkPass').disabled = true;
                    document.getElementById('txtPass').disabled = false;
                    break;
                case 'btn_edit':
                    if(grid.getSelRow(grid.getRowId()) == ''){
                        alert('Pilih dulu user yang akan diedit');
                    }
                    melakukan = 'edit';
                    var tmp = grid.getRowId(grid.getSelRow()).split('|');
                    document.getElementById('txtUser').value = grid.cellsGetValue(grid.getSelRow(), 2);
                    document.getElementById('txtName').value = grid.cellsGetValue(grid.getSelRow(), 3);

                    /*document.getElementById('txtPass').value = tmp[1];
                    document.getElementById('txtConf').value = tmp[1];*/
                    document.getElementById('hidId').value = tmp[0];
                    document.getElementById('cmbHak').value = tmp[1];
                    document.getElementById('trDet').style.display = 'table-row';
                    document.getElementById('trGrid').style.display = 'none';
                    document.getElementById('chkPass').disabled = false;
                    document.getElementById('txtPass').disabled = true;
                    document.getElementById('txtConf').disabled = true;
                    break;
                case 'btn_del':
                    if(grid.getSelRow(grid.getRowId()) == ''){
                        alert('Pilih dulu user yang akan dihapus');
                    }
                    if(confirm(grid.cellsGetValue(grid.getSelRow(), 2)+" akan dihapus.\nAnda yakin?")){
                        if(tmp[0] == "<?php echo $_SESSION['id'];?>"){
                            alert('Anda tidak bisa menghapus user anda sendiri.');
                            return;
                        }
                        grid.loadURL("users_utils.php?pilihan=view_user&act="+par.id+"&id="+tmp[0],'','GET');
                    }
                    break;
                case 'btn_save':
                    var user = document.getElementById('txtUser').value;
                    var name = document.getElementById('txtName').value;
                    var pass = document.getElementById('txtPass').value;
                    var conf = document.getElementById('txtConf').value;
                    var hak_akses = document.getElementById('cmbHak').value;
                    var chk = document.getElementById('chkPass');
                    var id = document.getElementById('hidId').value;

                    if(pass != conf){
                        alert("Password dengan konfirmasinya tidak sama.");
                        return false;
                    }
                    if(user == '' || name =='' || pass == '' && (chk.checked == true || chk.disabled == true) ){
                        alert("Semua field harus diisi.");
                        return false;
                    }
                    Request("users_utils.php?act=cekUser&id="+id+"&user="+user, 'divTmp', '', 'GET'
                    , function(){
                        if(document.getElementById('divTmp').innerHTML <= 0){
                            grid.loadURL("users_utils.php?pilihan=view_user&act="+par.id+"&which="+melakukan+"&user="+user
                                         +"&name="+name+"&chk="+chk.checked+"&id="+id+"&pass="+pass+"&hak_akses="+hak_akses,'','GET');
                        }
                        else{
                            alert("Username tersebut sudah digunakan, pilih username yang lain.");
                            return false;
                        }
                    });
                    break;
                case 'btn_cancel':
                    melakukan = '';
                    document.getElementById('txtUser').value = '';
                    document.getElementById('txtName').value = '';
                    document.getElementById('txtPass').value = '';
                    document.getElementById('txtConf').value = '';
                    document.getElementById('cmbHak').disabled = false;
                    document.getElementById('txtConf').disabled = false;
                    document.getElementById('chkPass').checked = false;
                    document.getElementById('chkPass').disabled = false;
                    document.getElementById('trDet').style.display = 'none';
                    document.getElementById('trGrid').style.display = 'table-row';
                    break;
                case 'chkPass':
                    if(par.checked){
                        document.getElementById('txtPass').disabled = false;
                        document.getElementById('txtConf').disabled = false;
                    }
                    else{
                        document.getElementById('txtPass').disabled = true;
                        document.getElementById('txtConf').disabled = true;
                    }
                    break;
            }
        }

        function cekLoad(){
            if(melakukan == 'add' || melakukan == 'edit'){
                act(document.getElementById('btn_cancel'));
            }
        }

        grid=new DSGridObject("divGrid");
        grid.setHeader("DATA USER");
        grid.setColHeader("NO,USERNAME,NAMA,HAK AKSES");
        //grid.setIDColHeader(",username,tgl_out,nama,");
        grid.setColWidth("30,100,150,90");
        grid.setCellAlign("center,center,left,center");
        grid.setCellHeight(20);
        grid.setImgPath("../icon");
        grid.onLoaded(cekLoad);
        //grid.setIDPaging("pagingGrid");
        //grid.attachEvent("onRowClick","ambilDataKamar");
        //grid.baseURL("tindiag_utils.php?grd4=true&kunjungan_id="+getIdKunj+"&unit_id="+getIdUnit);
        grid.baseURL("users_utils.php?pilihan=view_user");
        grid.Init();
		
        var th_skr = "<?php echo $date_skr[2];?>";
        var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
		var fromHome=<?php echo $fromHome ?>;
    </script>
<script src="../report_form.js" type="text/javascript" language="javascript"></script>
</html>
<?
include '../sesi.php';
?>
<?php
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
if(isset($_POST['act']) && $_POST['act'] != '') {
    if($_POST['act'] == 'edit') {
        $query = "update as_lokasi set
            idunit = '".$_POST['cmb_unit']."', kodelokasi = '".$_POST['txt_kodeRuang']."', namalokasi = '".$_POST['txt_namaRuang']."', idtipelokasi = '".$_POST['cmb_tipeRuang']."'
            , idgedung = '".$_POST['cmb_gedung']."', luas = '".$_POST['txt_luas']."', kapasitas = '".$_POST['txt_kapasitas']."'
            , jumlahkursi = '".$_POST['txt_jmlKursi']."', deskripsi = '".$_POST['txt_catatan']."', penanggungnip = '".$_POST['txt_nipPj1']."', penanggungnama = '".$_POST['txt_namaPj1']."'
            , penanggungnip2 = '".$_POST['txt_nipPj2']."', penanggungnama2 = '".$_POST['txt_namaPj2']."', t_userid = '".$_SESSION['userid']."', t_updatetime = now(), t_ipaddress = '".$_SERVER['REMOTE_ADDR']."'
            where idlokasi = '".$_GET['idruangan']."'";
    }
    else if($_POST['act'] == 'add') {
        $query = "insert into as_lokasi (idunit,kodelokasi,namalokasi,idtipelokasi
                                        ,idgedung,luas,kapasitas,jumlahkursi
                                        ,deskripsi,penanggungnip,penanggungnama,penanggungnip2
                                        ,penanggungnama2,t_userid,t_updatetime,t_ipaddress)
                values ('".$_POST['cmb_unit']."', '".$_POST['txt_kodeRuang']."', '".$_POST['txt_namaRuang']."', '".$_POST['cmb_tipeRuang']."'
                        , '".$_POST['cmb_gedung']."', '".$_POST['txt_luas']."', '".$_POST['txt_kapasitas']."', '".$_POST['txt_jmlKursi']."'
                        , '".$_POST['txt_catatan']."', '".$_POST['txt_nipPj1']."', '".$_POST['txt_namaPj1']."', '".$_POST['txt_nipPj2']."'
                        , '".$_POST['txt_namaPj2']."', '".$_SESSION['userid']."', now(), '".$_SERVER['REMOTE_ADDR']."')";
    }
    
	$rs = mysql_query($query);
    $res = mysql_affected_rows();
    if($res > 0) {
        if($_POST['act'] == 'add') {
            $act = "Penambahan data berhasil.";
        }
        else {
            $act = "Edit data berhasil.";
        }
        echo "<script>alert('$act');</script>";
        if($_POST['act'] == 'edit') {
            echo "<script>window.location = 'ruangan.php';</script>";
        }
    }
    else {
        echo "<script>
            alert('Terdapat kesalahan input, coba periksa kembali.');
            </script>";
    }
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>Detil Ruangan</title>
    </head>
    <body>
        <div align="center">
            <?php
            include '../header.php';
            $act = $_GET['act'];
            $par = "act=$act";
            if($act == 'edit') {
                $idruangan = $_GET['idruangan'];
                $par .= "&idruangan=$idruangan";
            }
            ?>
            <div>
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table cellspacing=0 cellpadding="4" width="450" align="center">
                                <tr>
                                    <td height="30" colspan="3" valign="bottom" align="right">
                                        <button class="Enabledbutton" id="backbutton" onClick="location='ruangan.php'" title="Back" style="cursor:pointer">
                                            <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Back to List
                                        </button>
                                        <!--button class="Disabledbutton" disabled=true id="editbutton" name="editbutton" onClick="goEdit()" title="Edit" style="cursor:pointer">
                                            <img alt="back" src="../images/editsmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Edit Record
                                        </button-->
                                        <button type="submit" class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="save()" title="Save" style="cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Save Record
                                        </button>
                                        <button class="Disabledbutton" id="undobutton" onClick="location='detailRuangan.php?<?php echo $par;?>'" title="Cancel / Refresh" style="cursor:pointer">
                                            <img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Undo/Refresh
                                        </button>
                                        <!--button class="Enabledbutton" id="deletebutton" onClick="goDelete()" title="Delete" style="cursor:pointer;">
                                            <img alt="delete" src="../images/deletesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Delete
                                        </button-->
                                    </td>
                                </tr>
                                <form action="" method="post" onSubmit="return ValidateForm('txt_koderuangan,txt_namaruangan,txt_thnbangun,txt_nourut','Ind');" id="form_ruangan" >
                                    <tr>
                                        <td colspan="3" class="header">
                                            .: Data Ruang/Lokasi :.
                                            <input type="hidden" id="act" name="act" value="<?php echo $act;?>">
                                        </td>
                                    </tr>
                                    <?php
                                    if($_GET['act'] == 'edit') {
                                        $query = "select idunit,kodelokasi,namalokasi,idtipelokasi,idgedung,luas,kapasitas,jumlahkursi,deskripsi
                ,penanggungnip,penanggungnama,penanggungnip2,penanggungnama2,t_userid,t_updatetime
                from as_lokasi where idlokasi = '".$_GET['idruangan']."'";
                                        $rs = mysql_query($query);
                                        $i = 0;
                                        $rows = mysql_fetch_array($rs);
                                        $unit = $rows["idunit"];
                                        $kode = $rows["kodelokasi"];
                                        $namaRuang = $rows["namalokasi"];
                                        $tipeRuang = $rows["idtipelokasi"];
                                        $gedung = $rows["idgedung"];
                                        $luas = $rows["luas"];
                                        $kapasitas = $rows["kapasitas"];
                                        $jmlKursi = $rows["jumlahkursi"];
                                        $nipPj1 = $rows["penanggungnip"];
                                        $namaPj1 = $rows["penanggungnama"];
                                        $nipPj2 = $rows["penanggungnip2"];
                                        $namaPj2 = $rows["penanggungnama2"];
                                        $catatan = $rows["deskripsi"];
                                    }
                                    ?>

                                    <tr>
                                        <td colspan='2' width=200 height=20 align='left' class='label' style='cursor:pointer;' >
                                            Unit / Sat Ker
                                        </td>
                                        <td width=250 class='contright' align='center'>
                                            <select id='cmb_unit' name='cmb_unit' class='txtmustfilled'>
                                                <option value=''></option>
                                                <?php
                                                $qUnit = "select * from as_ms_unit order by kodeunit";
                                               /* if ($_SESSION['usertype']!="A") {
                                                    if ($_SESSION['usertype']=="P")
                                                        $qUnit .= " and idunit='" . $_SESSION["refidunit"] . "'";
                                                    if ($_SESSION['usertype']=="F")
                                                        $qUnit .= " and (idunit='" . $_SESSION["refidunit"] . "' or idunit in (select idunit from $schema.ms_unit where parentunit='" . $_SESSION["refidunit"] . "'))";
                                                }*/
                                                $qUnit .= " order by idunit";
                                                $rsUnit = mysql_query($qUnit);
                                                while($rowUnit = mysql_fetch_array($rsUnit)) {
                                                    echo "<option value='".$rowUnit['idunit']."' ";
                                                    if($rowUnit['idunit'] == $unit) {
                                                        echo "selected ";
                                                    }
                                                    echo ">".$rowUnit['namaunit']."</option>";
                                                }
                                                //<input type='text' name='cmb_unit' id='cmb_unit' size='45' class='txtmustfilled' value='$unit'>
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td colspan='2' align='left' class='label' style='cursor:pointer;' >
                                            Kode Ruang
                                        </td>
                                        <td align='left' class='contright'>
                                            <input type='text' name='txt_kodeRuang' id='txt_kodeRuang' size='45' class='txtmustfilled' value='<?php echo $kode;?>'>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td colspan='2' align='left' class='label' style='cursor:pointer;' >
                                            Nama Ruang
                                        </td>
                                        <td align='left' class='contright'>
                                            <input type='text' name='txt_namaRuang' id='txt_namaRuang' size='45' class='txtmustfilled' value='<?php echo $namaRuang;?>'>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td colspan='2' align='left' class='label' style='cursor:pointer;' >
                                            Tipe Ruang
                                        </td>
                                        <td align='left' class='contright'>
                                            <select id='cmb_tipeRuang' name='cmb_tipeRuang' class='txtmustfilled'>
                                                <option value=''></option>
                                                <?php
                                                $qUnit = "select idtipelokasi,keterangan from as_ms_tipelokasi";
                                                $rsUnit = mysql_query($qUnit);
                                                while($rowUnit = mysql_fetch_array($rsUnit)) {
                                                    echo "<option value='".$rowUnit['idtipelokasi']."' ";
                                                    if($rowUnit['idtipelokasi'] == $tipeRuang) {
                                                        echo "selected ";
                                                    }
                                                    echo ">".$rowUnit['keterangan']."</option>";
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td colspan='2' align='left' class='label' style='cursor:pointer;' >
                                            Gedung
                                        </td>
                                        <td align='left' class='contright'>
                                            <select id='cmb_gedung' name='cmb_gedung' class='txt'>
                                                <option value=''></option>
                                                <?php
                                                $qUnit = "select idgedung,namagedung from as_ms_gedung";
                                                $rsUnit = mysql_query($qUnit);
                                                while($rowUnit = mysql_fetch_array($rsUnit)) {
                                                    echo "<option value='".$rowUnit['idgedung']."' ";
                                                    if($rowUnit['idgedung'] == $gedung) {
                                                        echo "selected ";
                                                    }
                                                    echo ">".$rowUnit['namagedung']."</option>";
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td colspan='2' align='left' class='label' style='cursor:pointer;' >
                                            Luas Ruangan
                                        </td>
                                        <td align='left' class='contright'>
                                            <input type='text' name='txt_luas' id='txt_luas' size='15' class='txtmustfilled' value='<?php echo $luas;?>'> M&sup2;
                                        </td>
                                    </tr>
                                    <tr >
                                        <td colspan='2' align='left' class='label' style='cursor:pointer;' >
                                            Kapasitas
                                        </td>
                                        <td align='left' class='contright'>
                                            <input type='text' name='txt_kapasitas' id='txt_kapasitas' size='15' class='txtmustfilled' value='<?php echo $kapasitas;?>'> Orang
                                        </td>
                                    </tr>
                                    <tr >
                                        <td colspan='2' align='left' class='label' style='cursor:pointer;' >
                                            Jumlah Kursi
                                        </td>
                                        <td align='left' class='contright'>
                                            <input type='text' name='txt_jmlKursi' id='txt_jmlKursi' size='15' class='txtmustfilled' value='<?php echo $jmlKursi;?>'> Buah
                                        </td>
                                    </tr>
                                    <tr >
                                        <td align='left' rowspan='2' class='label' style='cursor:pointer;' >
                                            Pj Ruangan 1
                                        </td>
                                        <td align='left' class='sublabel' style='cursor:pointer;' >
                                            NIP
                                        </td>
                                        <td align='left' class='contright'>
                                            <input type='text' name='txt_nipPj1' id='txt_nipPj1' size='45' class='txt' value='<?php echo $nipPj1;?>'>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td align='left' class='sublabel' style='cursor:pointer;' >
                                            Nama
                                        </td>
                                        <td align='left' class='contright'>
                                            <input type='text' name='txt_namaPj1' id='txt_namaPj1' size='45' class='txt' value='<?php echo $namaPj1;?>'>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td align='left' rowspan='2' class='label' style='cursor:pointer;' >
                                            Pj Ruangan 2
                                        </td>
                                        <td align='left' class='sublabel' style='cursor:pointer;' >
                                            NIP
                                        </td>
                                        <td align='left' class='contright'>
                                            <input type='text' name='txt_nipPj2' id='txt_nipPj2' size='45' class='txt' value='<?php echo $nipPj2;?>'>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td align='left' class='sublabel' style='cursor:pointer;' >
                                            Nama
                                        </td>
                                        <td align='left' class='contright'>
                                            <input type='text' name='txt_namaPj2' id='txt_namaPj2' size='45' class='txt' value='<?php echo $namaPj2;?>'>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td colspan='2' align='left' class='label' style='cursor:pointer;' >
                                            Catatan Khusus
                                        </td>
                                        <td align='left' class='contright'>
                                            <input type='text' name='txt_catatan' id='txt_catatan' size='45' class='txt' value='<?php echo $catatan;?>'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='header2' colspan='3'>&nbsp;</td>
                                    </tr>
                                    <?php
                                    //==================================END LOOP ========================================
                                    // end else
                                    if (mysql_affected_rows()==0 && $_GET['act'] == 'edit') {
                                        echo "<tr valign=center height=25><td align=center colspan=3><b>No record found.</b></td></tr>";
                                    }
                                    ?>
                                </form>
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
        function save(){
            if(ValidateForm("cmb_unit,txt_kodeRuang,txt_namaRuang","ind") == true){
                //cmb_unit,txt_kodeRuang,txt_namaRuang,cmb_tipeRuang,cmb_gedung,txt_luas,txt_kapasitas,txt_nipPj1,txt_namaPj1,txt_nipPj2,txt_namaPj2,txt_catatan
                form_ruangan.submit();		
            }
        }
    </script>
</html>
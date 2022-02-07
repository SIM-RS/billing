<?
include '../sesi.php';
?>
<?php
include("../koneksi/konek.php");
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
$id = $_GET['idrekanan'];
if(isset($_POST['act']) && $_POST['act'] != '') {
    $act = $_POST['act'];

    $koderekanan =  $_POST["koderekanan"];
    $namarekanan =  $_POST["namarekanan"];
    $idtipesupplier =  $_POST["idtipesupplier"];
    $alamat =  $_POST["alamat"];
    $alamat2 =  $_POST["alamat2"];
    $telp =  $_POST["telp"];
    $telp2 =  $_POST["telp2"];
    $kodepos =  $_POST["kodepos"];
    $kota =  $_POST["kota"];
    $negara =  $_POST["negara"];
    $hp =  $_POST["hp"];
    $fax =  $_POST["fax"];
    $email =  $_POST["email"];
    $contactperson =  $_POST["contactperson"];
    $deskripsi =  $_POST["deskripsi"];
    $npwp =  $_POST["npwp"];
    $fp =  $_POST["fp"];
    $siupp =  $_POST["siupp"];
    $status = $_POST["status"];

    $t_userid = $_SESSION['userid'];
    $t_ipaddress = $_SERVER['REMOTE_ADDR'];
    if($act == 'add') {
	$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Insert Master Reknan','insert into as_ms_rekanan (koderekanan, namarekanan, idtipesupplier, alamat, alamat2, telp, telp2, kodepos, kota, negara, fax, email, hp, contactperson, deskripsi, npwp, fp, siupp,status, t_userid, t_ipaddress, t_updatetime)values($koderekanan, $namarekanan, $idtipesupplier, $alamat, $alamat2, $telp, $telp2,$kodepos,$kota,$negara,$fax,$email,$hp,$contactperson,$deskripsi,$npwp,$fp,$siupp,$status,$t_userid,$t_ipaddress, now())','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns);
					
        $query = "insert into as_ms_rekanan (koderekanan, namarekanan, idtipesupplier, alamat, alamat2, telp, telp2, kodepos, kota, negara, fax
        , email, hp, contactperson, deskripsi, npwp, fp, siupp,status
        , t_userid, t_ipaddress, t_updatetime)
                values
                ('$koderekanan', '$namarekanan', '$idtipesupplier', '$alamat', '$alamat2', '$telp', '$telp2', '$kodepos', '$kota', '$negara', '$fax'
        , '$email', '$hp', '$contactperson', '$deskripsi', '$npwp', '$fp', '$siupp', '$status'
        , '$t_userid', '$t_ipaddress', now())";
    }
    else if($act == 'edit') {
		$sqlIns2="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Update Master Reknan','update as_ms_rekanan set koderekanan = $koderekanan, namarekanan = $namarekanan, idtipesupplier = $idtipesupplier, alamat = $alamat, alamat2 = $alamat2
                , telp = $telp, telp2 = $telp2, kodepos = $kodepos, kota = $kota, negara = $negara, fax = $fax, email = $email, hp = $hp
                , contactperson = $contactperson, deskripsi = $deskripsi, npwp = $npwp, fp = $fp, siupp = $siupp, status = $status
                , t_userid = $t_userid, t_ipaddress = $t_ipaddress, t_updatetime = now()
                where idrekanan = $id','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns2);
        $query = "update as_ms_rekanan set koderekanan = '$koderekanan', namarekanan = '$namarekanan', idtipesupplier = '$idtipesupplier', alamat = '$alamat', alamat2 = '$alamat2'
                , telp = '$telp', telp2 = '$telp2', kodepos = '$kodepos', kota = '$kota', negara = '$negara', fax = '$fax', email = '$email', hp = '$hp'
                , contactperson = '$contactperson', deskripsi = '$deskripsi', npwp = '$npwp', fp = '$fp', siupp = '$siupp', status = '$status'
                , t_userid = '$t_userid', t_ipaddress = '$t_ipaddress', t_updatetime = now()
                where idrekanan = '$id'";
    }
    $rs = mysql_query($query);
    $res = mysql_affected_rows();
    if($act == 'edit') {
        if($res > 0) {
            echo "<script>
                alert('Data berhasil diubah.');
                window.location = 'rekanan.php';
                </script>";
        }
        else if($res == 0) {
            echo "<script>alert('Data tidak ada yang berubah.');</script>";
        }
        else {
            echo "<script>alert('Terdapat kesalahan pada input anda.$res');</script>";
        }
    }
    else if($act == 'add') {
        if($res > 0) {
            echo "<script>
                alert('Data Telah Berhasil Disimpan.');
                </script>";
        }
        else if($res == 0) {
            echo "<script>alert('Data gagal dimasukan.');</script>";
        }
        else {
            echo "<script>alert('Terdapat kesalahan pada input anda.$res');</script>";
        }
    }
}
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <title>Detail Rekanan</title>
    </head>

    <body>
        <div align="center">
            <?php
            include("../header.php");
            $act = $_GET['act'];
            $par = "act=$act";
            if($act == 'edit') {
                $par .= "&idrekanan=$id";
                $query = "SELECT idrekanan,koderekanan,namarekanan,idtipesupplier,alamat,alamat2,telp,telp2,kodepos,kota,negara,hp,fax,email,contactperson,deskripsi,status,npwp,fp,siupp
                        FROM as_ms_rekanan 
                        WHERE idrekanan = '".$id."'";
                $rs = mysql_query($query);
                $rows = mysql_fetch_array($rs);
            }
            ?>
            <div align="center">
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="625" border="0" cellspacing="0" cellpadding="2" align="center">
                                <tr>
                                    <td height="30" colspan="2" valign="bottom" align="right">
                                        <button class="Enabledbutton" id="backbutton" onClick="location='rekanan.php'" title="Back" style="cursor:pointer">
                                            <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Back to List
                                        </button>
                                        <button type="button" class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="save()" title="Save" style="cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Save Record
                                        </button>
                                        <button class="Disabledbutton" id="undobutton" onClick="location='detailRekanan.php?<?php echo $par;?>'" title="Cancel / Refresh" style="cursor:pointer">
                                            <img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Undo/Refresh
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" height="28" class="header">.: Data Rekanan / Supplier :.</td>
                                </tr>
                                <form action="" id="form1" name="form1" method="post" onSubmit="return ValidateForm('idrekanan,namarekanan,idtipesupplier,email','Ind')">
                                    <tr>
                                        <td width="25%" height="20" class="label">&nbsp;Kode Rekanan</td>
                                        <td width="75%" class="content">&nbsp;
                                            <input type="hidden" name="act" id="act" value="<?php echo $act;?>" />
                                            <input name="koderekanan" type="text" class="txtmustfilled" id="koderekanan" value="<?php echo $rows["koderekanan"]; ?>" size="20" maxlength="10" style="text-transform:uppercase;" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Nama Rekanan</td>
                                        <td class="content">&nbsp;
                                            <input name="namarekanan" type="text" class="txtmustfilled" id="namarekanan" value="<?php echo $rows["namarekanan"]; ?>" size="50" maxlength="50" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Tipe Supplier</td>
                                        <td class="content">&nbsp;
                                            <select id="idtipesupplier" class="txtmustfilled" name="idtipesupplier">
                                                <option value=""></option>
                                                <?php
                                                $query = "SELECT keterangan,idtipesupplier from as_tiperekanan order by idtipesupplier";
                                                $rs = mysql_query($query);
                                                while($row = mysql_fetch_array($rs)){
                                                ?>
                                                <option value="<?php echo $row['idtipesupplier'];?>" <?php if($row['idtipesupplier'] == $rows['idtipesupplier']) echo 'selected';?> ><?php echo $row['keterangan'];?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Status</td>
                                        <td class="content">&nbsp;
                                            <select name="status" class="txt" id="status">
                                                <option value="1" <?php if ($rows["status"]!=0) echo "selected" ?>>Aktif</option>
                                                <option value="0" <?php if ($rows["status"]==0) echo "selected" ?>>Non Aktif</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="28" colspan="2" class="header2">&nbsp;Kontak</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Alamat</td>
                                        <td class="content">&nbsp;
                                            <input name="alamat" type="text" class="txt" id="alamat" value="<?php echo $rows["alamat"]; ?>" size="60" maxlength="100" />
                                            <br />&nbsp;
                                            <input name="alamat2" type="text" class="txt" id="alamat2" value="<?php echo $rows["alamat2"]; ?>" size="60" maxlength="100" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Telp</td>
                                        <td class="content">&nbsp;
                                            <input name="telp" type="text" class="txt" id="telp" value="<?php echo $rows["telp"]; ?>" size="20" maxlength="15" />
                                            <br />&nbsp;
                                            <input name="telp2" type="text" class="txt" id="telp2" value="<?php echo $rows["telp2"]; ?>" size="20" maxlength="15" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;HP</td>
                                        <td class="content">&nbsp;
                                            <input name="hp" type="text" class="txt" id="hp" value="<?php echo $rows["hp"]; ?>" size="20" maxlength="15" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Email</td>
                                        <td class="content">&nbsp;
                                            <input name="email" type="text" class="txtmustfilled" onFocus="email_validation(this.value)" onKeyUp="email_validation(this.value)" id="email" value="<?php echo $rows["email"]; ?>" size="50" maxlength="50" />
                                            <span id="span_valid" style="font-size: 10px; font-style: italic; color: gray"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Fax</td>
                                        <td class="content">&nbsp;
                                            <input name="fax" type="text" class="txt" id="fax" value="<?php echo $rows["fax"]; ?>" size="20" maxlength="15" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Kode Pos</td>
                                        <td class="content">&nbsp;
                                            <input name="kodepos" type="text" class="txt" id="kodepos" value="<?php echo $rows["kodepos"]; ?>" size="10" maxlength="5" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Kota, Negara</td>
                                        <td class="content">&nbsp;
                                            <input name="kota" type="text" class="txt" id="kota" value="<?php echo $rows["kota"]; ?>" size="20" maxlength="15" />,&nbsp;
                                            <input name="negara" type="text" class="txt" id="negara" value="<?php echo $rows["negara"]; ?>" size="20" maxlength="15" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Contact Person</td>
                                        <td class="content">&nbsp;
                                            <input name="contactperson" type="text" class="txt" id="contactperson" value="<?php echo $rows["contactperson"]; ?>" size="50" maxlength="50" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="28" colspan="2" class="header2">&nbsp;Keterangan Tambahan</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;N.P.W.P</td>
                                        <td class="content">&nbsp;
                                            <input name="npwp" type="text" class="txt" id="npwp" value="<?php echo $rows["npwp"]; ?>" size="50" maxlength="20" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;No Faktur Pajak</td>
                                        <td class="content">&nbsp;
                                            <input name="fp" type="text" class="txt" id="fp" value="<?php echo $rows["fp"]; ?>" size="50" maxlength="20" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;S.I.U.P.P</td>
                                        <td class="content">&nbsp;
                                            <input name="siupp" type="text" class="txt" id="siupp" value="<?php echo $rows["siupp"]; ?>" size="50" maxlength="20" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Catatan Khusus</td>
                                        <td class="content">&nbsp;
                                            <textarea name="deskripsi" cols="60" rows="5" class="txt" id="deskripsi"><?php echo $rows["deskripsi"]; ?></textarea>
                                        </td>
                                    </tr>
                                </form>
                                <tr>
                                    <td colspan="2" class="header2">&nbsp;</td>
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
    <script type="text/JavaScript" language="JavaScript">
        function save(){
            if(email_validation(document.getElementById('email').value) == true){
                if(ValidateForm('koderekanan,namarekanan,idtipesupplier,email','Ind') == true){
                    document.getElementById('form1').submit();
                }
            }
            else{
                alert('Email Tidak Valid.');
                document.getElementById('email').focus();
            }
        }

        function email_validation(email){
            var valid = validateEmailv2(email);
            if(email != ''){
                if(valid == true){
                    document.getElementById('span_valid').innerHTML = 'Email Valid.';
                    return true;
                }
                else{
                    document.getElementById('span_valid').innerHTML = 'Email Tidak Valid.';
                    return false;
                }
            }
            else{
                document.getElementById('span_valid').innerHTML = '';
            }
        }

        function validateEmailv2(email)
        {
            // a very simple email validation checking.
            // you can add more complex email checking if it helps
            if(email.length <= 0)
            {
                return true;
            }
            var splitted = email.match("^(.+)@(.+)$");
            if(splitted == null) return false;
            if(splitted[1] != null )
            {
                var regexp_user=/^\"?[\w-_\.]*\"?$/;
                if(splitted[1].match(regexp_user) == null) return false;
            }
            if(splitted[2] != null)
            {
                var regexp_domain=/^[\w-\.]*\.[A-Za-z]{2,4}$/;
                if(splitted[2].match(regexp_domain) == null)
                {
                    var regexp_ip =/^\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\]$/;
                    if(splitted[2].match(regexp_ip) == null) return false;
                }// if
                return true;
            }
            return false;
        }
    </script>
</html>
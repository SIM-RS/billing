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
$type = $_SESSION["usertype"];
$id = $_REQUEST['idbarang'];
$back_addr = "kode_brg.php";
if(isset($_GET['origin']) && $_GET['origin'] != '') {
    $back_addr = "treeBarang.php";
}
if(isset($_POST['act']) && $_POST['act'] != '') {
    $act = $_POST['act'];
    $kodebarang = $_POST["kodebarang"];
    $namabarang = $_POST["namabarang"];
    $tipebarang = $_POST["tipebarang"];
    $level = $_POST["level"];
    $mru = $_POST["mru"];
    $statuskode = $_POST["statuskode"];
    $metodedepresiasi = $_POST["metodedepresiasi"];
    $stddeppct = $_POST["stddeppct"];
    //$stddepamt = $_POST["stddepamt"];
    $lifetime = $_POST["lifetime"];
    //$nilairesidu = $_POST["nilairesidu"];
    $akunaset = $_POST["akunaset"];
    $akundep = $_POST["akundep"];
    $akunakdep = $_POST["akunakdep"];
    $akundisloss = $_POST["akundisloss"];
    //akundep=>akun.pengadaan,akundep=>akun.pemakaian,akundisloss=>akun.penghapusan
    //$akundisgain = $_POST["akundisgain"];
    //$akunmaintenance = $_POST["akunmaintenance"];
    //$akunlease = $_POST["akunlease"];
    $idsatuan = $_POST["satuan"];
    $tipe = $_GET["tipe"];

    $t_userid = $_SESSION['userid'];
    $t_ipaddress = $_SERVER['REMOTE_ADDR'];

    if($act == 'add') {
	$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Insert Master Barang','insert into as_ms_barang (kodebarang,namabarang,tipebarang,level,metodedepresiasi,stddeppct,akunaset,akunpengadaan,akunpemakaian,akunhapus,idsatuan,t_userid,t_updatetime,t_ipaddress,tipe)values(".$kodebarang.",".$namabarang.", ".$tipebarang.", ".$level.", ".$metodedepresiasi.",".$stddeppct.",".$akunaset.",".$akundep.",".$akunakdep.",".$akundisloss.",".$idsatuan.",". $t_userid.", now(), ".$t_ipaddress.", ".$tipe.")','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns);
        $query = "insert into as_ms_barang (kodebarang,namabarang,tipebarang,level,metodedepresiasi,stddeppct
            ,akunaset,akunpengadaan,akunpemakaian,akunhapus,idsatuan,t_userid,t_updatetime,t_ipaddress,tipe)
                values
                ('$kodebarang', '$namabarang', '$tipebarang', '$level', '$metodedepresiasi','$stddeppct'
                , '$akunaset', '$akundep', '$akunakdep', '$akundisloss', '$idsatuan', '$t_userid', now(), '$t_ipaddress', '$tipe')";
    }
    else if($act == 'edit') {
	$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Update Master Barang','update as_ms_barang set kodebarang = ".$kodebarang.", namabarang = ".$namabarang.", tipebarang = ".$tipebarang.", level = ".$level."
				,  metodedepresiasi =".$metodedepresiasi.", stddeppct =".$stddeppct."
                , akunaset = ".$akunaset.", akunpengadaan = ".$akundep.", akunpemakaian = ".$akunakdep."
                , akunhapus =".$akundisloss.", idsatuan = ".$idsatuan.", t_userid = ".$t_userid.", t_updatetime = now(), t_ipaddress = ".$t_ipaddress.", tipe = ".$tipe."
            where idbarang = ".$id."','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns);
        $query = "update as_ms_barang set kodebarang = '$kodebarang', namabarang = '$namabarang', tipebarang = '$tipebarang', level = '$level'
				,  metodedepresiasi = '$metodedepresiasi', stddeppct = '$stddeppct'
                ,lifetime='$lifetime', akunaset = '$akunaset', akunpengadaan = '$akundep', akunpemakaian = '$akunakdep'
                , akunhapus = '$akundisloss', idsatuan = '$idsatuan', t_userid = '$t_userid', t_updatetime = now(), t_ipaddress = '$t_ipaddress', tipe = '$tipe'
            where idbarang = $id";
    }
    $rs = mysql_query($query);
    $res = mysql_affected_rows();
    if($act == 'edit') {
        if($res > 0) {
           echo "<script>
                alert('Data berhasil diubah.');
                window.location = '$back_addr';
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
                alert('Data Telah Berhasil Tersimpan..');
                window.location = '$back_addr';
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
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <title>.: Kode Barang :.</title>
    </head>

    <body>
        <div align="center">
            <?php
            include("../header.php");
            $act = $_GET['act'];
            $par = "act=$act";
            if($act == 'edit') {
                $par .= "&idbarang=$id";
                $query = "SELECT idbarang,kodebarang,namabarang,idsatuan,akunpemakaian ,akunhapus,tipebarang,level,mru,statuskode,metodedepresiasi,akunpengadaan,stddeppct,lifetime,akunaset,akundep,akunakdep,akundisloss,akundisgain,akunmaintenance,akunlease FROM as_ms_barang WHERE idbarang = '$id'";
                $rs = mysql_query($query);
                $rows = mysql_fetch_array($rs);
            }

            if($_GET['tipe'] == 1)
                $view_tipe = '';
            else
                $view_tipe = 'none';

            ?>
            <div>
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="625" border="0" cellspacing="0" cellpadding="2" align="center">
                                <tr>
                                    <td height="30" colspan="2" valign="bottom" align="right">
                                        <button class="Enabledbutton" id="backbutton" onClick="location='<?php echo $back_addr;?>'" title="Back" style="cursor:pointer">
                                            <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Back to List
                                        </button>
                                        <button type="button" class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="save()" title="Save" 
										style="cursor:pointer;visibility:<? if($type=="G") echo "hidden"; else echo "visible"; ?>">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Save Record
                                        </button>
                                        <button class="Disabledbutton" id="undobutton" onClick="location='<?php echo $_SERVER['REQUEST_URI'];?>'" title="Cancel / Refresh" style="cursor:pointer">
                                            <img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Undo/Refresh
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" height="28" class="header">.: Data Kode Barang :.</td>
                                </tr>
                                <form action="" id="form1" name="form1" method="post">
                                    <input type="hidden" name="act" id="act" value="<?php echo $act;?>" />
                                    <tr>
                                        <td width="40%" height="20" class="label">&nbsp;Kode Barang</td>
                                        <td width="60%" class="content">&nbsp;
                                            <input type="text" id="kodebarang" name="kodebarang" class="txtmustfilled" value="<?php echo $rows['kodebarang']; ?>" onKeyUp="cekstring()" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Nama Barang</td>
                                        <td class="content">&nbsp;
                                            <input type="text" id="namabarang" name="namabarang" class="txtmustfilled" value="<?php echo $rows['namabarang']; ?>" size="60"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Satuan</td>
                                        <td class="content">&nbsp;
                                            <select name="satuan" id="satuan" class="txt">
                                                <?php
                                                $query = "select idsatuan from as_ms_satuan order by nourut";
                                                $rs = mysql_query($query);
                                                while($row = mysql_fetch_array($rs)) {
                                                    ?>
                                                <option value="<?php echo $row['idsatuan']; ?>" <?php if($row['idsatuan'] == $rows['idsatuan']) echo 'selected';?> ><?php echo $row['idsatuan']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Tipe Barang</td>
                                        <td class="content">&nbsp;
                                            <select name="tipebarang" class="txt" id="tipebarang">
                                                <?php
                                                if($view_tipe == '') {
                                                    ?>
                                                <option value="TT" <?php if ($rows["tipebarang"]=="TT") echo "selected"; ?>>TT - Tetap</option>
                                                    <?php
                                                }
                                                else {
                                                    ?>
                                                <option value="HP" <?php if ($rows["tipebarang"]=="HP") echo "selected"; ?>>HP - Habis Pakai</option>
                                                    <?php
                                                }
                                                ?>
                                                <!--option value="TT" < ?php if ($rows["tipebarang"]=="TT") echo "selected"; ?>>TT - Tetap</option>
                                                <option value="BG" < ?php if ($rows["tipebarang"]=="BG") echo "selected"; ?>>BG - Bergerak</option>
                                                <option value="HP" < ?php if ($rows["tipebarang"]=="HP") echo "selected"; ?>>HP - Habis Pakai</option>
                                                <option value="IT" < ?php if ($rows["tipebarang"]=="IT") echo "selected"; ?>>IT - Intangible</option>
                                                <option value="BH" < ?php if ($rows["tipebarang"]=="BH") echo "selected"; ?>>BH - Hidup</option-->
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Level</td>
                                        <td class="content">&nbsp;
                                           <input type="text" id="level" name="level" class="txtmustfilled" value="" />
                                        </td>
                                    </tr>
                                    <!--tr>
                                        <td height="20" class="label">&nbsp;Show on list</td>
                                        <td class="content">&nbsp;
                                            <select name="mru" class="txt" id="mru">
                                                <option value="1" <?php if ($rows["mru"] != 0) echo "selected"; ?>>Show</option>
                                                <option value="0" <?php if ($rows["mru"] == 0) echo "selected"; ?>>Hide</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Status Kode</td>
                                        <td class="content">&nbsp;
                                            <select name="statuskode" class="txt" id="statuskode">
                                                <option value="N" <?php if ($rows["statuskode"]=="N") echo "selected"; ?>>Normal</option>
                                                <option value="B" <?php if ($rows["statuskode"]=="B") echo "selected"; ?>>Baru</option>
                                                <option value="X" <?php if ($rows["statuskode"]=="X") echo "selected"; ?>>Hapus</option>
                                            </select>
                                        </td>
                                    </tr-->
                                    <?php
                                    if($_GET['tipe'] == 1) {
                                        ?>
                                    <tr>
                                        <td height="28" colspan="2" class="header2">&nbsp;Informasi Depresiasi / Penyusutan</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Metode Depresiasi</td>
                                        <td class="content">&nbsp;
                                            <select name="metodedepresiasi" class="txt" id="metodedepresiasi">
                                                <option value="NN" <?php if ($rows["metodedepresiasi"]=="NN") echo "selected"; ?>>NN - Tidak Susut</option>
                                                <option value="SL" <?php if ($rows["metodedepresiasi"]=="SL") echo "selected"; ?>>SL - Garis Lurus</option>
                                                <option value="RB" <?php if ($rows["metodedepresiasi"]=="RB") echo "selected"; ?>>RB - Saldo Menurun</option>
                                                <option value="DD" <?php if ($rows["metodedepresiasi"]=="DD") echo "selected"; ?>>DD - Double Declining</option>
                                                <option value="SY" <?php if ($rows["metodedepresiasi"]=="SY") echo "selected"; ?>>SY - Sum of Years</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;A. Prosentase Dep.</td>
                                        <td class="content">&nbsp;
                                            <input name="stddeppct" type="text" class="txt" id="stddeppct" value="<?php echo $rows["stddeppct"]; ?>" size="10" maxlength="5" />&nbsp;%
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td height="20" class="label">&nbsp;C. Life Time</td>
                                        <td class="content">&nbsp;
                                            <input name="lifetime" type="text" class="txt" id="lifetime" value="<?php echo $rows["lifetime"]; ?>" size="10" maxlength="5" />&nbsp;bulan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="28" colspan="2" class="header2">&nbsp;Kode Rekening Keuangan</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Persediaan </td>
                                        <td class="content">&nbsp;
                                            <input name="akunaset" type="text" class="txt" id="akunaset" value="<?php echo $rows["akunaset"]; ?>" size="50" maxlength="30" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Pengadaan</td>
                                        <td class="content">&nbsp;
                                            <input name="akundep" type="text" class="txt" id="akundep" value="<?php echo $rows["akunpengadaan"]; ?>" size="50" maxlength="30" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Pemakaian </td>
                                        <td class="content">&nbsp;
                                            <input name="akunakdep" type="text" class="txt" id="akunakdep" value="<?php echo $rows["akunpemakaian"]; ?>" size="50" maxlength="30" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Penghapusan </td>
                                        <td class="content">&nbsp;
                                            <input name="akundisloss" type="text" class="txt" id="akundisloss" value="<?php echo $rows["akunhapus"]; ?>" size="50" maxlength="30" />
                                        </td>
                                    </tr>
                                    <!--tr>
                                        <td height="20" class="label">&nbsp;Akun. Disposal Gain</td>
                                        <td class="content">&nbsp;
                                            <input name="akundisgain" type="text" class="txt" id="akundisgain" value="<?php echo $rows["akundisgain"]; ?>" size="50" maxlength="30" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Maintenance</td>
                                        <td class="content">&nbsp;
                                            <input name="akunmaintenance" type="text" class="txt" id="akunmaintenance" value="<?php echo $rows["akunmaintenance"]; ?>" size="50" maxlength="30" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Lease</td>
                                        <td class="content">&nbsp;
                                            <input name="akunlease" type="text" class="txt" id="akunlease" value="<?php echo $rows["akunlease"]; ?>" size="50" maxlength="30" />
                                        </td>
                                    </tr-->
                                        <?php
                                    }
                                    ?>
                                </form>
                                <tr>
                                    <td colspan="2" class="header2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;
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
    <script type="text/JavaScript" language="JavaScript">
	cekstring();
        function save(){
            if(ValidateForm('kodebarang,namabarang','Ind') == true){
                document.getElementById('form1').submit();
            }
        }
        function cekstring(){
		//alert('aaaaaa');
			var jml='';
			var cek=document.getElementById('kodebarang').value.split('.');
			jml=cek.length;
			if(document.getElementById('kodebarang').value=='')
			jml='';
			document.getElementById('level').value=jml;
		}
		
    </script>
</html>
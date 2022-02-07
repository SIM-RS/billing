<?php
include '../sesi.php';
include("../koneksi/konek.php");
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                window.location='$def_loc';
                </script>";
}
$id_kib_seri = explode('|',$_GET['id_kib']);
if(isset($_POST['act']) && $_POST['act'] != '') {
    $act = $_POST['act'];
    $t_userid = $_SESSION["userid"];
    $t_updatetime = date("Y-m-d H:i:s");
    $t_ipaddress =  $_SERVER['REMOTE_ADDR'];
    if($act == 'Save') {
        $konskategori = $_POST["konskategori"];
        $panjang = $_POST["panjang"];
        $lebar = $_POST["lebar"];
        $statushukum = $_POST["statushukum"];
        $nokibtanah = $_POST["nokibtanah"];
        $suratsertifikat =  $_POST["suratsertifikat"];
        $sertifikattgl =  tglSQL($_POST["sertifikattgl"]);
        $surat3 =  $_POST["surat3"];
        $alamat =  $_POST["alamat"];
        $kelurahan =  $_POST["kelurahan"];
        $kecamatan =  $_POST["kecamatan"];
        $kotamadya =  $_POST["kotamadya"];
        $caraperolehan = $_POST["caraperolehan"];
        $diperolehdari = $_POST["diperolehdari"];
        //$tahunperolehan= $_POST["tahunperolehan"];
        $hargasatuan = $_POST["hargasatuan"];
        $dasarharga = $_POST["dasarharga"];
        $manama = $_POST["manama"];
        $idsumberdana = $_POST["idsumberdana"];
        $namapengurus = $_POST["namapengurus"];
        $alamatpengurus = $_POST["alamatpengurus"];
        $catpengisi = $_POST["catpengisi"];
        $namapetugas = $_POST["namapetugas"];
        $jabatanpetugas = $_POST["jabatanpetugas"];
        $tgldisetujui = tglSQL($_POST["tgldisetujui"]);
        $namapetugas2 = $_POST["namapetugas2"];
        $jabatanpetugas2 = $_POST["jabatanpetugas2"];
        $tgldiisi = tglSQL($_POST["tgldiisi"]);

        $query = "update as_kib set konskategori = '$konskategori', panjang = '$panjang', lebar = '$lebar', statushukum = '$statushukum', nokibtanah = '$nokibtanah'
                , suratsertifikat = '$suratsertifikat', sertifikattgl = '$sertifikattgl', surat3 = '$surat3', alamat = '$alamat', kelurahan = '$kelurahan'
                , kecamatan = '$kecamatan', kotamadya = '$kotamadya', caraperolehan = '$caraperolehan', diperolehdari = '$diperolehdari', hargasatuan = '$hargasatuan'
                , dasarharga = '$dasarharga', manama = '$manama', idsumberdana = '$idsumberdana', namapengurus = '$namapengurus', alamatpengurus = '$alamatpengurus'
                , catpengisi = '$catpengisi', namapetugas = '$namapetugas', jabatanpetugas = '$jabatanpetugas', tgldisetujui = '$tgldisetujui', namapetugas2 = '$namapetugas2'
                , jabatanpetugas2 = '$jabatanpetugas2', tgldiisi = '$tgldiisi', t_userid = '$t_userid', t_updatetime = '$t_updatetime', t_ipaddress = '$t_ipaddress'
                where id_kib = $id_kib_seri[0]";
            
        /*$strUpdate = "select konskategori,panjang,lebar,statushukum,nokibtanah,suratsertifikat,sertifikattgl,surat3,alamat,kelurahan,";
            $strUpdate .= "kecamatan,kotamadya,caraperolehan,diperolehdari,hargasatuan,dasarharga,";
            $strUpdate .= "manama,idsumberdana,namapengurus,alamatpengurus,catpengisi,";
            $strUpdate .= "namapetugas,jabatanpetugas,tgldisetujui,namapetugas2,jabatanpetugas2,tgldiisi,t_userid,t_updatetime,t_ipaddress from in_kib where id_kib=$r_idkib";*/

        $rs = mysql_query($query);
        $res = mysql_affected_rows();
        $err = mysql_error();
        if(!isset($err) || $err == '') {
            $keadaanalat= $_POST["keadaanalat"];
            $catperlengkapan= $_POST["catperlengkapan"];
            $kondisiperolehan= $_POST["kondisiperolehan"];

            $query = "update as_seri set keadaanalat = '$keadaanalat',catperlengkapan = '$catperlengkapan',kondisiperolehan = '$kondisiperolehan'
                    , t_updatetime = '$t_updatetime', t_ipaddress = '$t_ipaddress'
                    where idseri = $id_kib_seri[1]";
            $rs = mysql_query($query);
            $res = mysql_affected_rows()+$res;
            $err = mysql_error();
            if(isset($err) && $err != '') {
                echo "<script>
                    alert('Terdapat kesalahan : $err');
                    </script>";
            }
            else {
                if($res > 0) {
                    echo "<script>
                    alert('Data berhasil diubah.');
                    </script>";
                }
                else if($res == 0) {
                    echo "<script>
                    alert('Data tidak ada yang berubah.');
                    </script>";
                }
                else {
                    echo "<script>
                    alert('Terdapat kesalahan, periksa kembali input anda.$res');
                    </script>";
                }
            }
        }
        else {
            echo "<script>
                alert('Terdapat kesalahan : $err');
                </script>";
        }
    }
    else if($act == 'Delete') {
        $query = "delete from as_seri where idseri = ".$id_kib_seri[1];
        /*"update as_seri set void = 1, tglhapus = date_format(now(),'%Y-%m-%d'), t_userid = '$t_userid'
                    , t_updatetime = '$t_updatetime', t_ipaddress = '$t_ipaddress'
                    where idseri = ".$id_kib_seri[1];*/
        
        $rs = mysql_query($query);
        $res = mysql_affected_rows();
        if($res > 0) {
            echo "<script>
                alert('Berhasil menghapus data.');
                window.location = 'tanah.php';
                </script>";
        }
        else if($res == 0) {
            echo "<script>
                alert('Gagal menghapus data.');
                </script>";
        }
        else {
            echo "<script>
                alert('Terdapat kesalahan. $res');
                </script>";
        }
    }
}
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <title>.: KIB Jalan :.</title>
    </head>
    <body>
        <div align="center">
            <?php
            include("../header.php");
            $act = $_GET['act'];
            if($act == 'edit') {
                $vis_view = 'none';
                $vis_edit = '';
            }
            else {
                $vis_view = '';
                $vis_edit = 'none';
            }
            $par = "?act=$act";
            if(isset($id_kib_seri[0]) && $id_kib_seri[0] != '') {
                $par .= "&id_kib=$id_kib_seri[0]|$id_kib_seri[1]";
            }

            $sqljln = "SELECT b.kodebarang,b.namabarang,u.namaunit,u.kodeunit,k.id_kib,konskategori,catperlengkapan,
                        k.panjang,k.lebar,k.nokibtanah,k.suratlain,noseri,suratsertifikat,sertifikattgl,
                        k.alamat,k.kelurahan,k.kecamatan,k.kotamadya,keadaanalat,statushukum,surat3,kondisiperolehan,
                        k.caraperolehan,k.diperolehdari,k.hargasatuan,k.dasarharga,k.idsumberdana,manama,
                        k.namapengurus,k.alamatpengurus,k.catpengisi,k.namapetugas,k.jabatanpetugas,date_format(k.tgldisetujui,'%d-%m-%Y') as tgldisetujui,
                        k.namapetugas2,k.jabatanpetugas2,date_format(k.tgldiisi,'%d-%m-%Y') as tgldiisi,keterangan
                        FROM as_kib k
                        INNER JOIN as_transaksi t ON t.idtransaksi = k.idtransaksi
                        INNER JOIN as_ms_barang b ON b.idbarang = t.idbarang
                        INNER JOIN as_ms_unit u ON u.idunit = t.idunit
                        LEFT JOIN as_ms_sumberdana s ON s.idsumberdana = k.idsumberdana
                        inner join as_seri se on t.idtransaksi = se.idtransaksi
                        WHERE LEFT(b.kodebarang,2) = 04 AND k.id_kib = '".$id_kib_seri[0]."' and se.idseri = '".$id_kib_seri[1]."'";
            $dtjln = mysql_query($sqljln);
            $rwjln = mysql_fetch_array($dtjln);
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
                        <button class="Enabledbutton" id="backbutton" onClick="backTo();" title="Back" style="cursor:pointer">
                            <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                            Back to List
                        </button>
                        <button class="EnabledButton" id="editButton" name="editButton" onClick="action(this.title)" title="Edit" style="cursor:pointer"><!--location='editMesin.php?id_kib=<-?php echo $id_kib_seri_seri[0];?>'-->
                            <img alt="edit" src="../images/editsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                            Edit Record
                        </button>
                        <button class="DisabledButton" id="saveButton" onClick="action(this.title)" title="Save" style="display: none;cursor:pointer">
                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                            Save Record
                        </button>
                        <button class="Disabledbutton" id="undobutton" disabled onClick="location='detailJalan.php<?php echo $par?>'" title="Cancel / Refresh" style="cursor:pointer">
                            <img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
                            Undo/Refresh
                        </button>
                        <button class="EnabledButton" id="deleteButton" onClick="action(this.title)" title="Hapus Data" style="cursor:pointer">
                            <img alt="void" src="../images/deletesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                            Void
                        </button>
                    </td>
                </tr>
            </table>
            <div id="div_view" style="display: <?php echo $vis_view;?>"
                 <table width="625" border="0" cellspacing="0" cellpadding="2" align="center">
                    <tr>
                        <td colspan="2" class="header">.: Kartu Inventaris Barang : Jalan, Irigasi Dan Jaringan - Detail :.</td>
                    </tr>
                    <tr>
                        <td width="40%" class="label">&nbsp;Unit Kerja</td>
                        <td width="60%" class="content">&nbsp;
                            <?php echo $rwjln['namaunit'];?>&nbsp;(<?php echo $rwjln['kodeunit']; ?>)
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kode Barang - Seri</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['kodebarang'].' - '.$rwjln["noseri"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama Barang</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['namabarang'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;I. UNIT BARANG</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Konstruksi</td>
                        <td class="content">&nbsp;
                            <?php
                            switch($rwjln["konskategori"]) {
                                case 1: echo 'Aspal';
                                    break;
                                case 2: echo 'Beton';
                                    break;
                                case 3: echo 'Paving';
                                    break;
                                case 4: echo 'Makadam';
                                    break;
                                case 5: echo 'Semen';
                                    break;
                                case 6: echo 'Beton Beraspal';
                                    break;
                                case 7: echo 'Tanah Liat';
                                    break;
                                case 8: echo 'Lainnya';
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Panjang</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['panjang']; ?>&nbsp;Km
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Lebar</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['lebar']; ?>&nbsp;m
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kondisi Barang</td>
                        <td class="content">&nbsp;
                            <?php
                            switch($rwjln['keadaanalat']) {
                                case 1: echo 'Baik';
                                    break;
                                case 2: echo 'Kurang Baik';
                                    break;
                                case 3: echo 'Rusak Berat';
                                    break;
                                case 4: echo 'Tidak Berfungsi';
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Status Tanah</td>
                        <td class="content">&nbsp;
                            <?php
                            switch($rwjln['statushukum']) {
                                case 1: echo 'Tanah Pemda/Pemkot';
                                    break;
                                case 2: echo 'Tanah Negara';
                                    break;
                                case 3: echo 'Tanah Hak Ulayat';
                                    break;
                                case 4: echo 'Tanah Hak Milik';
                                    break;
                                case 5: echo 'Tanah Hak Guna Bangunan';
                                    break;
                                case 6: echo 'Tanah Hak Pakai';
                                    break;
                                case 7: echo 'Tanah Hak Pengelolaan';
                                    break;
                                case 8: echo 'Lainnya';
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;No KIB Tanah</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['nokibtanah']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Surat Kepemilikan No</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['suratsertifikat'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Surat Kepemilikan Tgl</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['sertifikattgl'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Surat-Surat Lainnya</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['surat3']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Alamat</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['alamat'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kelurahan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['kelurahan'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kecamatan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['kecamatan'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kab/Kodya</td>
                        <td class="content">&nbsp;
                            <?php
                            echo $rwjln['kotamadya'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;II. PENGADAAN</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Cara Perolehan</td>
                        <td class="content">&nbsp;
                            <?php
                            $aCaraPerolehan = array('','Dibeli','Hibah','Dll');
                            echo $aCaraPerolehan[$rwjln['caraperolehan']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Diperoleh Dari</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['diperolehdari'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kondisi Perolehan</td>
                        <td class="content">&nbsp;
                            <?php 
                            switch($rwjln['kondisiperolehan']){
                                case 1: echo 'Baik';
                                break;
                                case 2: echo 'Kurang Baik';
                                break;
                                case 3: echo 'Rusak Berat';
                                break;
                                case 4: echo 'Tidak Berfungsi';
                                break;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Harga</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['hargasatuan'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Dasar Harga</td>
                        <td class="content">&nbsp;
                            <?php
                            $aDasarHarga = array('','Pemborongan','Taksiran');
                            echo $aDasarHarga[$rwjln['dasarharga']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Mata Anggaran</td>
                        <td class="content">&nbsp;
                            <?php
                            echo $rwjln['keterangan'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;No MA</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['manama'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;III. PENGURUS BARANG</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama/Jabatan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['namapengurus'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Alamat</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['alamatpengurus'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;IV. BAGIAN-BAGIAN LAIN/PERLENGKAPAN</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Catatan Perlengkapan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['catperlengkapan'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Catatan Pengisi</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['catpengisi'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;DISETUJUI OLEH</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['namapetugas'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Jabatan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['jabatanpetugas'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Tanggal</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['tgldisetujui'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;DIISI OLEH</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['namapetugas2'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Jabatan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['jabatanpetugas2'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Tanggal</td>
                        <td class="content">&nbsp;
                            <?php echo $rwjln['tgldiisi'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;</td>
                    </tr>
                </table>
            </div>
            <div id="div_edit" style="display: <?php echo $vis_edit;?>">
                <form id="form1" name="form1" action="" method="post">
                    <table width="650" border=0 cellspacing=0 cellpadding="4" bgcolor="#EDF1FE">
                        <tr>
                            <td height="25" colspan="3" align="center" class="header">
                                .: Kartu Inventaris Barang : Jalan, Irigasi Dan Jaringan - Detail :.
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Unit Kerja </td>
                            <td width="504" colspan="2" class="content">
                                <input name="kodeunit" type="text" class="txtunedited" id="kodeunit" value="<?php echo $rwjln["kodeunit"]; ?>" size="20" maxlength="15" readonly />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" width="134">Kode Barang </td>
                            <td colspan="2" class="content">
                                <input name="kodebarang" type="text" class="txtunedited" id="kodebarang" value="<?php echo $rwjln["kodebarang"]; ?>" size="20" maxlength="15" readonly />
                                <input name="noseri" type="text" class="txtunedited" id="noseri" value="<?php echo $rwjln["noseri"]; ?>" size="10" maxlength="5" readonly />
                            </td>
                        </tr>
                        <tr>
                            <td class="label"> Nama Barang </td>
                            <td class="content">
                                <input name="namabarang" type="text" class="txtunedited" id="namabarang" value="<?php echo $rwjln["namabarang"]; ?>" size="50" maxlength="50" readonly />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">I. UNIT BARANG </td>
                        </tr>
                        <tr>
                            <td class="label">Konstruksi</td>
                            <td class="content">
                                <select name="konskategori" class="txt" id="select2">
                                    <option value="1" <?php if ($rwjln["konskategori"]==1) echo "selected"; ?>>1 - Aspal</option>
                                    <option value="2" <?php if ($rwjln["konskategori"]==2) echo "selected"; ?>>2 - Beton</option>
                                    <option value="3" <?php if ($rwjln["konskategori"]==3) echo "selected"; ?>>3 - Paving</option>
                                    <option value="4" <?php if ($rwjln["konskategori"]==4) echo "selected"; ?>>4 - Makadam</option>
                                    <option value="5" <?php if ($rwjln["konskategori"]==5) echo "selected"; ?>>5 - Semen</option>
                                    <option value="6" <?php if ($rwjln["konskategori"]==6) echo "selected"; ?>>6 - Beton Beraspal</option>
                                    <option value="7" <?php if ($rwjln["konskategori"]==7) echo "selected"; ?>>7 - Tanah Liat</option>
                                    <option value="8" <?php if ($rwjln["konskategori"]==8) echo "selected"; ?>>8 - Lainnya</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Panjang</td>
                            <td class="content">
                                <input name="panjang" type="text" class="txt" id="panjang" value="<?php echo $rwjln["panjang"]; ?>" size="10" maxlength="4" /> Km
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Lebar</td>
                            <td class="content">
                                <input name="lebar" type="text" class="txt" id="lebar" value="<?php echo $rwjln["lebar"]; ?>" size="10" maxlength="2" /> m
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Kondisi Barang </td>
                            <td class="content">
                                <select name="keadaanalat" class="txt" id="keadaanalat">
                                    <option value="1" <?php if ($rwjln["keadaanalat"]==1) echo "selected"; ?>>1 - Baik</option>
                                    <option value="2" <?php if ($rwjln["keadaanalat"]==2) echo "selected"; ?>>2 - Kurang Baik</option>
                                    <option value="3" <?php if ($rwjln["keadaanalat"]==3) echo "selected"; ?>>3 - Rusak Berat</option>
                                    <option value="4" <?php if ($rwjln["keadaanalat"]==4) echo "selected"; ?>>4 - Tidak Berfungsi</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Status Tanah</td>
                            <td class="content">
                                <select name="statushukum" class="txt" id="statushukum">
                                    <option value="1" <?php if ($rwjln["statushukum"]==1) echo "selected"; ?>>1 - Tanah Pemda/Pemkot</option>
                                    <option value="2" <?php if ($rwjln["statushukum"]==2) echo "selected"; ?>>2 - Tanah Negara</option>
                                    <option value="3" <?php if ($rwjln["statushukum"]==3) echo "selected"; ?>>3 - Tanah Hak Ulayat</option>
                                    <option value="4" <?php if ($rwjln["statushukum"]==4) echo "selected"; ?>>4 - Tanah Hak Milik</option>
                                    <option value="5" <?php if ($rwjln["statushukum"]==5) echo "selected"; ?>>5 - Tanah Hak Guna Bangunan</option>
                                    <option value="6" <?php if ($rwjln["statushukum"]==6) echo "selected"; ?>>6 - Tanah Hak Pakai</option>
                                    <option value="7" <?php if ($rwjln["statushukum"]==7) echo "selected"; ?>>7 - Tanah Hak Pengelolaan</option>
                                    <option value="8" <?php if ($rwjln["statushukum"]==8) echo "selected"; ?>>8 - Lainnya</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Nomor KIB Tanah</td>
                            <td class="content">
                                <input name="nokibtanah" type="text" class="txt" id="alamat" value="<?php echo $rwjln["nokibtanah"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" height="28">Surat Kepemilikan No</td>
                            <td class="content">
                                <input name="suratsertifikat" type="text" class="txt" id="suratsertifikat" value="<?php echo $rwjln["suratsertifikat"]; ?>" size="75" maxlength="100" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" height="28">Surat Kepemilikan Tgl</td>
                            <td class="content">
                                <input name="sertifikattgl" type="text" class="txt" id="sertifikattgl" value="<?php echo date("d-m-Y",strtotime($rwjln["sertifikattgl"])); ?>" size="20" maxlength="15" />
                                <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('sertifikattgl'),depRange);" />
                                <font color="#666666"><em>(dd-mm-yyyy)</em></font>
                            </td>
                        </tr>
                        <tr>
                            <td class="label" height="28">Surat 3 </td>
                            <td class="content">
                                <input name="surat3" type="text" class="txt" id="surat12" value="<?php echo $rwjln["surat3"]; ?>" size="75" maxlength="100" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" height="28">Alamat</td>
                            <td class="content">
                                <input name="alamat" type="text" class="txt" id="surat13" value="<?php echo $rwjln["alamat"]; ?>" size="75" maxlength="100" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" height="28">Kelurahan</td>
                            <td class="content">
                                <input name="kelurahan" type="text" class="txt" id="kelurahan" value="<?php echo $rwjln["kelurahan"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" height="28">Kecamatan</td>
                            <td class="content">
                                <input name="kecamatan" type="text" class="txt" id="kecamatan" value="<?php echo $rwjln["kecamatan"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" height="28">Kab/Kodya</td>
                            <td class="content">
                                <input name="kotamadya" type="text" class="txt" id="kotamadya" value="<?php echo $rwjln["kotamadya"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">II. PENGADAAN </td>
                        </tr>

                        <tr>
                            <td class="label">Cara Perolehan</td>
                            <td class="content">
                                <select name="caraperolehan" class="txt" id="select8">
                                    <option value="1" <?php if ($rwjln["caraperolehan"]==1) echo "selected" ?>>1 - Pembelian</option>
                                    <option value="2" <?php if ($rwjln["caraperolehan"]==2) echo "selected" ?>>2 - Hibah</option>
                                    <option value="3" <?php if ($rwjln["caraperolehan"]==3) echo "selected" ?>>3 - dll</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Diperoleh Dari </td>
                            <td class="content">
                                <input name="diperolehdari" type="text" class="txt" id="gambarjumlah" value="<?php echo $rwjln["diperolehdari"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" class="label">Kondisi Perolehan </td>
                            <td class="content">
                                <select name="kondisiperolehan" class="txt" id="kondisiperolehan">
                                    <option value="1" <?php if ($rwjln["kondisiperolehan"]==1) echo "selected" ?>>1 - Baik</option>
                                    <option value="2" <?php if ($rwjln["kondisiperolehan"]==2) echo "selected" ?>>2 - Kurang Baik</option>
                                    <option value="3" <?php if ($rwjln["kondisiperolehan"]==3) echo "selected" ?>>3 - Rusak Berat</option>
                                    <option value="4" <?php if ($rwjln["kondisiperolehan"]==4) echo "selected" ?>>4 - Tidak Berfungsi</option>
                                </select>
                            </td>
                        </tr>
                        <!--tr>
                          <td class="label">Tahun Perolehan </td>
                          <td class="content"><input name="tahunperolehan" type="text" class="txt" id="tahunperolehan" value="<?php echo $rwjln["tahunperolehan"]; ?>" size="10" maxlength="4">
                            <font color="#666666"><em>(yyyy)</em></font></td>
                        </tr-->
                        <tr>
                            <td class="label">Harga</td>
                            <td class="content">
                                <input name="hargasatuan" type="text" class="txt" id="hargasatuan" value="<?php echo $rwjln["hargasatuan"]; ?>" size="20" maxlength="15" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Dasar Harga </td>
                            <td class="content">
                                <select name="dasarharga" class="txt" id="select10">
                                    <option value="1" <?php if ($rwjln["dasarharga"]==1) echo "selected" ?>>1 - Pemborongan</option>
                                    <option value="2" <?php if ($rwjln["dasarharga"]==2) echo "selected" ?>>2 - Taksiran</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Mata Anggaran </td>
                            <td class="content">
                                <select id="idsumberdana" name="idsumberdana" class="txt">
                                    <option value=''></option>
                                    <?php
                                    $query = "SELECT idsumberdana,keterangan from as_ms_sumberdana order by nourut";
                                    $rs = mysql_query($query);
                                    while($row = mysql_fetch_array($rs)) {
                                        echo "<option value='".$row['idsumberdana']."' ";
                                        if($row['idsumberdana'] == $rwjln['idsumberdana']){
                                            echo 'selected';
                                        }
                                        echo ">".$row['keterangan']."</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">No MA </td>
                            <td class="content">
                                <input name="manama" type="text" class="txt" id="manama" value="<?php echo $rwjln["manama"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">III. PENGURUS BARANG </td>
                        </tr>
                        <tr>
                            <td class="label">Nama / Jabatan </td>
                            <td class="content">
                                <input name="namapengurus" type="text" class="txt" id="namapengurus" value="<?php echo $rwjln["namapengurus"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Alamat</td>
                            <td class="content">
                                <input name="alamatpengurus" type="text" class="txt" id="alamatpengurus" value="<?php echo $rwjln["alamatpengurus"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">IV. BAGIAN-BAGIAN LAIN/PERLENGKAPAN </td>
                        </tr>
                        <tr>
                            <td class="label">Catatan Perlengkapan </td>
                            <td class="content">
                                <textarea class="txt" name="catperlengkapan" cols="60" rows="3" id="catperlengkapan"><?php echo $rwjln["catperlengkapan"]; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Catatan Pengisi </td>
                            <td class="content">
                                <textarea class="txt" name="catpengisi" cols="60" rows="3" id="catpengisi"><?php echo $rwjln["catpengisi"]; ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" class="header2">DISETUJUI OLEH </td>
                        </tr>
                        <tr>
                            <td class="label">Nama</td>
                            <td class="content">
                                <input name="namapetugas" type="text" class="txt" id="namapetugas" value="<?php echo $rwjln["namapetugas"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Jabatan</td>
                            <td class="content">
                                <input name="jabatanpetugas" type="text" class="txt" id="jabatanpetugas" value="<?php echo $rwjln["jabatanpetugas"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Tanggal</td>
                            <td class="content">
                                <input name="tgldisetujui" type="text" class="txt" id="tgldisetujui" value="<?php echo date("d-m-Y",strtotime($rwjln["tgldisetujui"])); ?>" readonly size="20" maxlength="15" />
                                <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgldisetujui'),depRange);" />
                                <font color="#666666"><em>(dd-mm-yyyy)</em></font>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">DIISI OLEH </td>
                        </tr>
                        <tr>
                            <td class="label">Nama</td>
                            <td class="content">
                                <input name="namapetugas2" type="text" class="txt" id="namapetugas2" value="<?php echo $rwjln["namapetugas2"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Jabatan</td>
                            <td class="content">
                                <input name="jabatanpetugas2" type="text" class="txt" id="jabatanpetugas2" value="<?php echo $rwjln["jabatanpetugas2"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Tanggal</td>
                            <td class="content">
                                <input name="tgldiisi" type="text" class="txt" id="tgldiisi" value="<?php echo date("d-m-Y",strtotime($rwjln["tgldiisi"])); ?>" readonly size="20" maxlength="15" />
                                <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgldiisi'),depRange);" />
                                <font color="#666666"><em>(dd-mm-yyyy)</em></font>
                            </td>
                        </tr>
                        <tr>
                            <td height="25" colspan="3" class="footer">&nbsp;</td>
                        </tr>
                    </table>
                    <input type="hidden" name="act" id="act" />
                </form>
            </div>
                        <div><img src="../images/foot.gif" width="1000" height="45"></div>
            </td>

  </tr>
</table>
            </div>
        </div>
    </body>
    <iframe height="193" width="168" name="gToday:normal:agenda.js"
            id="gToday:normal:agenda.js"
            src="../theme/popcjs.php" scrolling="no"
            frameborder="1"
            style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
    </iframe>
    <script type="text/javascript" language="javascript">
        var arrRange=depRange=[];
        function action(choose){
            switch(choose){
                case 'Edit':
                    document.getElementById('undobutton').disabled = false;
                    document.getElementById('deleteButton').disabled = true;
                    document.getElementById('div_view').style.display = 'none';
                    document.getElementById('div_edit').style.display = '';
                    document.getElementById('saveButton').style.display = '';
                    document.getElementById('editButton').style.display = 'none';
                    break;
                case 'Delete':
                    if(confirm("Yakin akan menghapus data ini?")){
                        document.getElementById('act').value = choose;
                        document.getElementById('form1').submit();
                    }
                    break;
                case 'Save':
                    document.getElementById('act').value = choose;
                    document.getElementById('form1').submit();
                    break;
            }
        }
        function backTo(){
            if('<?php echo $_REQUEST['from']?>' == '')
            {
                location='jalan.php';
            }else{
                location='<?php echo $_REQUEST['from']."?unit=".$_REQUEST['unit']."&lokasi=".$_REQUEST['lokasi']."&namaunit=".$_REQUEST['namaunit']."&namalokasi=".$_REQUEST['namalokasi']."&baris=".$_REQUEST['baris'];?>';
            }
        }
        
    </script>
</html>

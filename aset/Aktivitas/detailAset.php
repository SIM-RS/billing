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
    $act = $_POST["act"];
    $t_userid = $_SESSION["userid"];
    $t_updatetime = date("Y-m-d H:i:s");
    $t_ipaddress =  $_SERVER['REMOTE_ADDR'];
    if ($act=="Save") {
        $kodebarang = $_POST['kodebarang'];
        switch (substr($kodebarang, 0, 5)) {
            case "05.17" :
                $judul = $_POST["judul"];
                $spesifikasi = $_POST["spesifikasi"];
                $part = " judul = '$judul', spesifikasi = '$spesifikasi', ";
                break;
            case "05.18" :
                $asaldaerah = $_POST["asaldaerah"];
                $pencipta = $_POST["pencipta"];
                $bahan = $_POST["bahan"];
                $part = " asaldaerah = '$asaldaerah', pencipta = '$pencipta', bahan = '$bahan', ";
                break;
            case "05.19" :
                $jenisbarang = $_POST["jenisbarang"];
                $ukuran = $_POST["ukuran"];
                $ukuran_satuan = $_POST["ukuran_satuan"];
                $part = " jenisbarang = '$jenisbarang', ukuran = '$ukuran', ukuran_satuan = '$ukuran_satuan', ";
                break;
        }

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

        echo $query = "update as_kib set $part caraperolehan = '$caraperolehan'
                    , diperolehdari = '$diperolehdari', hargasatuan = '$hargasatuan', dasarharga = '$dasarharga', manama = '$manama'
                    , idsumberdana = '$idsumberdana', namapengurus = '$namapengurus', alamatpengurus = '$alamatpengurus', catpengisi = '$catpengisi'
                    , namapetugas = '$namapetugas', jabatanpetugas = '$jabatanpetugas', tgldisetujui = '$tgldisetujui', namapetugas2 = '$namapetugas2'
                    , jabatanpetugas2 = '$jabatanpetugas2', tgldiisi = '$tgldiisi'
                    , t_userid = '$t_userid', t_updatetime = '$t_updatetime', t_ipaddress = '$t_ipaddress'
                    where id_kib = $id_kib_seri[0]";

        /*$strUpdate = "select judul,spesifikasi,asaldaerah,pencipta,bahan,jenisbarang,ukuran,ukuran_satuan,caraperolehan,diperolehdari,";
		$strUpdate .= "hargasatuan,dasarharga,manama,idsumberdana,namapengurus,alamatpengurus,catpengisi,namapetugas,";
		$strUpdate .= "jabatanpetugas,tgldisetujui,namapetugas2,jabatanpetugas2,tgldiisi,t_userid,t_updatetime,t_ipaddress
               from in_kib where id_kib=$r_idkib";*/

        $rs = mysql_query($query);
        $res = mysql_affected_rows();
        $err = mysql_error();
        if(!isset($err) || $err == '') {
            /*if (isset($_POST['keadaanalat1']) && $_POST["keadaanalat1"] != "")
                $keadaanalat = $_POST["keadaanalat1"];
            else if (isset($_POST['keadaanalat2']) && $_POST["keadaanalat2"]!="")
                $keadaanalat = $_POST["keadaanalat2"];
            else
                $keadaanalat = $_POST["keadaanalat3"];*/
            $keadaanalat = $_POST["keadaanalat"];
            $catperlengkapan = $_POST["catperlengkapan"];
            $kondisiperolehan = $_POST["kondisiperolehan"];

            $query = "update as_seri set keadaanalat = '$keadaanalat',catperlengkapan = '$catperlengkapan',kondisiperolehan = '$kondisiperolehan'
                    , t_userid = '$t_userid', t_updatetime = '$t_updatetime', t_ipaddress = '$t_ipaddress'
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
                window.location = 'aset.php';
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
        <title>KIB Aset Tetap</title>
    </head>

    <body>
        <div>
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>&nbsp;</td>

                </tr>
                <tr>
                    <td align="center">
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

                            $query = "select kodeunit,namaunit,kodebarang,namabarang,idseri,noseri,catperlengkapan,keadaanalat,kondisiperolehan,k.*,keterangan
                    from as_seri s inner join as_transaksi t on s.idtransaksi=t.idtransaksi
                    inner join as_ms_unit u on u.idunit=t.idunit
                    inner join as_ms_barang b on b.idbarang=t.idbarang
                    inner join as_kib k on k.idtransaksi=t.idtransaksi
                    left join as_ms_sumberdana ams on k.idsumberdana = ams.idsumberdana
                    where k.id_kib = '".$id_kib_seri[0]."' and s.idseri = '".$id_kib_seri[1]."'";

                            $rs = mysql_query($query);
                            $rows = mysql_fetch_array($rs);

                            $div_buku = "none";
                            $div_budaya = "none";
                            $div_ternak = "none";

                            switch (substr($rows['kodebarang'], 0,5)) {
                                case "05.17" :
                                    $div_buku = "block";
                                    break;
                                case "05.18" :
                                    $div_budaya = "block";
                                    break;
                                case "05.19" :
                                    $div_ternak = "block";
                                    break;
                            }
                            ?>
                            <table width="625" border="0" cellspacing="0" cellpadding="2" align="center">
                                <tr>
                                    <td height="30" colspan="2" valign="bottom" align="right">
                                        <button class="Enabledbutton" id="backbutton" onClick="backTo();" title="Back" style="cursor:pointer">
                                            <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Back to List
                                        </button>
                                        <button class="EnabledButton" id="editButton" name="editButton" onClick="action(this.title)" title="Edit" style="cursor:pointer"><!--location='editMesin.php?id_kib=<-?php echo $id_kib_seri[0];?>'-->
                                            <img alt="edit" src="../images/editsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Edit Record
                                        </button>
                                        <button class="DisabledButton" id="saveButton" onClick="action(this.title)" title="Save" style="display: none;cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Save Record
                                        </button>
                                        <button class="Disabledbutton" id="undobutton" disabled onClick="location='detailAset.php<?php echo $par?>'" title="Cancel / Refresh" style="cursor:pointer">
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
                            <div id="div_view" style="display: <?php echo $vis_view;?>">
                                <table width="600" border=0 cellspacing=0 cellpadding="4" bgcolor="#EDF1FE">
                                    <tr>
                                        <td height="25" colspan="2" align="center" class="header">
                                            .: Kartu Inventaris Barang : Aset Tetap Lainnya - Detail :.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Unit Kerja </td>
                                        <td class="content">&nbsp;
                                            <?php echo $rows["namaunit"]; ?>
                                            (
                                            <?php echo $rows["kodeunit"]; ?>
                                            )
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="148" class="label">Kode Barang - Seri</td>
                                        <td width="442" class="content">&nbsp;
                                            <?php echo $rows["kodebarang"].' - '.str_pad($rows["noseri"], 4, "0", STR_PAD_LEFT); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label"> Nama Barang </td>
                                        <td class="content">&nbsp;
                                            <?php echo $rows["namabarang"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="header2">I. UNIT BARANG </td>
                                    </tr>
                                </table>
                                <div id="buku" style="display: <?php echo $div_buku;?>;">
                                    <table width="600" border=0 cellspacing=0 cellpadding="4" bgcolor="#EDF1FE">
                                        <tr>
                                            <td width="148" class="label">Judul Buku / Pencipta</td>
                                            <td width="442" class="content">&nbsp;
                                                <?php echo $rows["judul"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label">Spesifikasi</td>
                                            <td class="content">&nbsp;
                                                <?php echo $rows["spesifikasi"]; ?>
                                            </td>
                                        </tr>
                                        <!--tr>
                                            <td class="label" valign="top">Kondisi Barang </td>
                                            <td class="content">&nbsp;
                                                <-?php
                                                switch ($rows["keadaanalat"]) {
                                                    case 1 : echo "Baik";
                                                        break;
                                                    case 2 : echo "Rusak Ringan";
                                                        break;
                                                    case 3 : echo "Rusak Berat";
                                                        break;
                                                    case 4 : echo "Tidak Berfungsi";
                                                        break;
                                                }
                                                ?>
                                            </td>
                                        </tr-->
                                    </table>
                                </div>
                                <div id="budaya" style="display: <?php echo $div_budaya;?>;">
                                    <table width="600" border=0 cellspacing=0 cellpadding="4" bgcolor="#EDF1FE">
                                        <tr>
                                            <td width="148" class="label">Asal Daerah</td>
                                            <td width="442" class="content">&nbsp;
                                                <?php echo $rows["asaldaerah"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label">Pencipta</td>
                                            <td class="content">&nbsp;
                                                <?php echo $rows["pencipta"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label">Bahan</td>
                                            <td class="content">&nbsp;
                                                <?php echo $rows["bahan"]; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="ternak" style="display: <?php echo $div_ternak;?>;">
                                    <table width="600" border=0 cellspacing=0 cellpadding="4" bgcolor="#EDF1FE">
                                        <tr>
                                            <td width="148" class="label">Jenis</td>
                                            <td width="442" class="content">&nbsp;
                                                <?php echo $rows["jenisbarang"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label">Ukuran</td>
                                            <td class="content">&nbsp;
                                                <?php echo $rows["ukuran"].' '.$rows["ukuran_satuan"]; ?>
                                            </td>
                                        </tr>
                                        <!--tr>
                                            <td class="label" valign="top">Kondisi Barang </td>
                                            <td class="content">&nbsp;
                                                <-?php
                                                switch ($rows["keadaanalat"]) {
                                                    case 1 : echo "Baik";
                                                        break;
                                                    case 2 : echo "Rusak Ringan";
                                                        break;
                                                    case 3 : echo "Rusak Berat";
                                                        break;
                                                    case 4 : echo "Tidak Berfungsi";
                                                        break;
                                                }
                                                ?>
                                            </td>
                                        </tr-->
                                    </table>
                                </div>
                                <table width="600" border=0 cellspacing=0 cellpadding="4" bgcolor="#EDF1FE">
                                    <tr>
                                        <td class="label" valign="top">Kondisi Barang </td>
                                        <td class="content">&nbsp;
                                            <?php
                                            switch ($rows["keadaanalat"]) {
                                                case 1 : echo "Baik";
                                                    break;
                                                case 2 : echo "Rusak Ringan";
                                                    break;
                                                case 3 : echo "Rusak Berat";
                                                    break;
                                                case 4 : echo "Tidak Berfungsi";
                                                    break;
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="header2">II. PENGADAAN BARANG </td>
                                    </tr>
                                    <tr>
                                        <td width="148" class="label" valign="top">Cara Perolehan</td>
                                        <td width="442" class="content">&nbsp;
                                            <?php
                                            switch ($rows["caraperolehan"]) {
                                                case 1 : echo "Pembelian";
                                                    break;
                                                case 2 : echo "Hibah";
                                                    break;
                                                case 3 : echo "dll";
                                                    break;
                                                default : echo "";
                                                    break;
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Diperoleh Dari </td>
                                        <td class="content">&nbsp;
                                            <?php echo $rows["diperolehdari"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="label">Kondisi Perolehan </td>
                                        <td class="content">&nbsp;
                                            <?php
                                            switch ($rows["kondisiperolehan"]) {
                                                case 1 : echo "Baik";
                                                    break;
                                                case 2 : echo "Rusak Ringan";
                                                    break;
                                                case 3 : echo "Rusak Berat";
                                                    break;
                                                case 4 : echo "Tidak Berfungsi";
                                                    break;
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <!--tr>
                                        <td valign="top">Tahun Perolehan </td>
                                        <td class="content"><-?php echo $rows["tahunperolehan"]; ?>
                                        </td>
                                    </tr-->
                                    <tr>
                                        <td valign="top" class="label">Harga</td>
                                        <td class="content">&nbsp;
                                            <?php echo number_format($rows["hargasatuan"],2); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="label">Dasar Harga </td>
                                        <td class="content">&nbsp;
                                            <?php
                                            switch ($rows["dasarharga"]) {
                                                case 1 : echo "Pemborongan";
                                                    break;
                                                case 2 : echo "Taksiran";
                                                    break;
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="label">Mata Anggaran </td>
                                        <td class="content">&nbsp;
                                            <?php echo $rows["keterangan"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="label">No MA </td>
                                        <td class="content">&nbsp;
                                            <?php echo $rows["manama"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="header2">III. PENGURUS BARANG </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="label">Nama / Jabatan </td>
                                        <td class="content">&nbsp;
                                            <?php echo $rows["namapengurus"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="label">Alamat</td>
                                        <td class="content">&nbsp;
                                            <?php echo $rows["alamatpengurus"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="header2">IV. BAGIAN-BAGIAN LAIN/PERLENGKAPAN
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="label">Catatan Perlengkapan </td>
                                        <td class="content">&nbsp;
                                            <?php echo $rows["catperlengkapan"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="label">Catatan Pengisi </td>
                                        <td class="content">&nbsp;
                                            <?php echo $rows["catpengisi"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="header2">DISETUJUI OLEH </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="label">Nama</td>
                                        <td class="content">&nbsp;
                                            <?php echo $rows["namapetugas"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="label">Jabatan</td>
                                        <td class="content">&nbsp;
                                            <?php echo $rows["jabatanpetugas"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="label">Tanggal</td>
                                        <td class="content">&nbsp;
                                            <?php
                                            if ($rows["tgldisetujui"])
                                                echo date("d M y",strtotime($rows["tgldisetujui"]));
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="header2">DIISI OLEH </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="label">Nama</td>
                                        <td class="content">&nbsp;
                                            <?php echo $rows["namapetugas2"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="label">Jabatan</td>
                                        <td class="content">&nbsp;
                                            <?php echo $rows["jabatanpetugas2"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="label">Tanggal</td>
                                        <td class="content">&nbsp;
                                            <?php if ($rows["tgldiisi"])
                                                echo date("d M y",strtotime($rows["tgldiisi"]));
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="25" colspan="2" class="footer">&nbsp;</td>
                                    </tr>
                                </table>
                            </div>
                            <div id="div_edit" style="display: <?php echo $vis_edit;?>;">
                                <form id="form1" name="form1" action="" method="post">
                                    <table width="650" border=0 cellspacing=0 cellpadding="4" bgcolor="#EDF1FE">
                                        <tr>
                                            <td height="25" colspan="3" align="center" class="header">
                                                .: Kartu Inventaris Barang : Tanah - Detail :.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label">Unit Kerja </td>
                                            <td width="504" colspan="2" class="content">
                                                <input name="kodeunit" type="text" class="txtunedited" id="kodeunit" value="<?php echo $rows["kodeunit"]; ?>" size="20" maxlength="15" readonly />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="134" class="label">Kode Barang </td>
                                            <td colspan="2" class="content">
                                                <input name="kodebarang" type="text" class="txtunedited" id="kodebarang" value="<?php echo $rows["kodebarang"]; ?>" size="20" maxlength="15" readonly />
                                                <input name="noseri" type="text" class="txtunedited" id="noseri" value="<?php echo $rows["noseri"]; ?>" size="10" maxlength="5" readonly />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label"> Nama Barang </td>
                                            <td class="content">
                                                <input name="namabarang" type="text" class="txtunedited" id="namabarang" value="<?php echo $rows["namabarang"]; ?>" size="50" maxlength="50" readonly />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="header2">I. UNIT BARANG </td>
                                        </tr>
                                    </table>
                                    <div id="bukuForm" style="display: <?php echo $div_buku;?>">
                                        <table width="650" border=0 cellspacing=0 cellpadding="4" bgcolor="#EDF1FE">
                                            <tr>
                                                <td width="138" class="label" valign="top">Judul Buku / Pencipta</td>
                                                <td class="content">
                                                    <textarea class="txt" name="judul" cols="50" rows="3" id="judul"><?php echo $rows["judul"]; ?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" class="label">Spesifikasi</td>
                                                <td class="content">
                                                    <textarea class="txt" name="spesifikasi" cols="50" rows="3" id="spesifikasi"><?php echo $rows["spesifikasi"]; ?></textarea>
                                                </td>
                                            </tr>
                                            <!--tr>
                                                <td valign="top" class="label">Kondisi barang </td>
                                                <td class="content">
                                                    <select name="keadaanalat1" class="txt" id="keadaanalat1">
                                                        <option value="1" <-?php if ($rows["keadaanalat"]==1) echo "selected" ?>>1 - Baik</option>
                                                        <option value="2" <-?php if ($rows["keadaanalat"]==2) echo "selected" ?>>2 - Rusak Ringan</option>
                                                        <option value="3" <-?php if ($rows["keadaanalat"]==3) echo "selected" ?>>3 - Rusak Berat</option>
                                                        <option value="4" <-?php if ($rows["keadaanalat"]==4) echo "selected" ?>>4 - Tidak Berfungsi</option>
                                                    </select>
                                                </td>
                                            </tr-->
                                        </table>
                                    </div>
                                    <div id="budayaForm" style="display: <?php echo $div_budaya;?>">
                                        <table width="650" border=0 cellspacing=0 cellpadding="4" bgcolor="#EDF1FE">
                                            <tr>
                                                <td width="138" class="label">Asal Daerah</td>
                                                <td class="content">
                                                    <input name="asaldaerah" type="text" class="txt" id="asaldaerah" value="<?php echo $rows["asaldaerah"]; ?>" size="50" maxlength="100" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">Pencipta</td>
                                                <td class="content">
                                                    <input name="pencipta" type="text" class="txt" id="pencipta" value="<?php echo $rows["pencipta"]; ?>" size="50" maxlength="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" class="label">Bahan</td>
                                                <td class="content">
                                                    <textarea class="txt" name="bahan" cols="50" rows="3" id="bahan"><?php echo $rows["bahan"]; ?></textarea>
                                                </td>
                                            </tr>
                                            <!--tr>
                                                <td valign="top" class="label">Kondisi barang </td>
                                                <td class="content">
                                                    <select name="keadaanalat2" class="txt" id="keadaanalat2">
                                                        <option value="1" <-?php if ($rows["keadaanalat"]==1) echo "selected" ?>>1 - Baik</option>
                                                        <option value="2" <-?php if ($rows["keadaanalat"]==2) echo "selected" ?>>2 - Rusak Ringan</option>
                                                        <option value="3" <-?php if ($rows["keadaanalat"]==3) echo "selected" ?>>3 - Rusak Berat</option>
                                                        <option value="4" <-?php if ($rows["keadaanalat"]==4) echo "selected" ?>>4 - Tidak Berfungsi</option>
                                                    </select>
                                                </td>
                                            </tr-->
                                        </table>
                                    </div>
                                    <div id="ternakForm" style="display: <?php echo $div_ternak;?>">
                                        <table width="650" border=0 cellspacing=0 cellpadding="4" bgcolor="#EDF1FE">
                                            <tr>
                                                <td width="138" class="label">Jenis</td>
                                                <td class="content">
                                                    <input name="jenisbarang" type="text" class="txt" id="jenisbarang" value="<?php echo $rows["jenisbarang"]; ?>" size="50" maxlength="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">Ukuran</td>
                                                <td class="content">
                                                    <input name="ukuran" type="text" class="txt" id="ukuran" value="<?php echo $rows["ukuran"]; ?>" size="10" maxlength="6" />
                                                    <select name="ukuran_satuan" id="ukuran_satuan">
                                                        <option value=""></option>
                                                        <?php
                                                        $query = "SELECT idsatuan from as_ms_satuan order by nourut";
                                                        $rs = mysql_query($query);
                                                        while($row = mysql_fetch_array($rs)) {
                                                            echo "<option value='".$row['idsatuan']."' ";
                                                            if($row['idsatuan'] == $rows['ukuran_satuan']) {
                                                                echo 'selected';
                                                            }
                                                            echo ">".$row['idsatuan']."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <table width="650" border=0 cellspacing=0 cellpadding="4" bgcolor="#EDF1FE">
                                        <tr>
                                            <td valign="top" class="label">Kondisi barang </td>
                                            <td class="content">
                                                <select name="keadaanalat" class="txt" id="keadaanalat">
                                                 <option value=''>Pilih Kondisi Barang</option>
                                                    <option value="1" <?php if ($rows["keadaanalat"]==1) echo "selected" ?>>1 - Baik</option>
                                                    <option value="2" <?php if ($rows["keadaanalat"]==2) echo "selected" ?>>2 - Rusak Ringan</option>
                                                    <option value="3" <?php if ($rows["keadaanalat"]==3) echo "selected" ?>>3 - Rusak Berat</option>
                                                    <option value="4" <?php if ($rows["keadaanalat"]==4) echo "selected" ?>>4 - Tidak Berfungsi</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="header2">II. PENGADAAN </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="label">Cara Perolehan</td>
                                            <td class="content">
                                                <select name="caraperolehan" class="txt" id="select8">
                                                 <option value=''>Pilih Cara Perolehan</option>
                                                    <option value="1" <?php if ($rows["caraperolehan"]==1) echo "selected" ?>>1 - Pembelian</option>
                                                    <option value="2" <?php if ($rows["caraperolehan"]==2) echo "selected" ?>>2 - Hibah</option>
                                                    <option value="3" <?php if ($rows["caraperolehan"]==3) echo "selected" ?>>3 - Pembebasan</option>
                                                    <option value="4" <?php if ($rows["caraperolehan"]==4) echo "selected" ?>>4 - Sebelum 1945</option>
                                                    <option value="5" <?php if ($rows["caraperolehan"]==5) echo "selected" ?>>5 - Tukar Menukar</option>
                                                    <option value="6" <?php if ($rows["caraperolehan"]==6) echo "selected" ?>>6 - Cara Lain</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label">Diperoleh Dari </td>
                                            <td class="content">
                                                <input name="diperolehdari" type="text" class="txt" id="gambarjumlah" value="<?php echo $rows["diperolehdari"]; ?>" size="50" maxlength="50" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="label">Kondisi Perolehan </td>
                                            <td class="content">
                                                <select name="kondisiperolehan" class="txt" id="select9">
                                                 <option value=''>Pilih Kondisi Perolehan</option>
                                                    <option value="1" <?php if ($rows["kondisiperolehan"]==1) echo "selected"; ?>>1 - Ada Bangunan</option>
                                                    <option value="2" <?php if ($rows["kondisiperolehan"]==2) echo "selected"; ?>>2 - Siap Dibangun</option>
                                                    <option value="3" <?php if ($rows["kondisiperolehan"]==3) echo "selected"; ?>>3 - Belum Dibangun</option>
                                                    <option value="4" <?php if ($rows["kondisiperolehan"]==4) echo "selected"; ?>>4 - Tidak dapat dibangun</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <!--tr>
                                            <td valign="top" class="label">Tahun Perolehan </td>
                                            <td class="content">
                                                <input name="tahunperolehan" type="text" class="txt" id="tahunperolehan" value="<-?php echo $rows["tahunperolehan"]; ?>" size="10" maxlength="4" />
                                                <font color="#666666"><em>(yyyy)</em></font>
                                            </td>
                                        </tr-->
                                        <tr>
                                            <td valign="top" class="label">Harga</td>
                                            <td class="content">
                                                <input name="hargasatuan" type="text" class="txt" id="hargasatuan" value="<?php echo $rows["hargasatuan"]; ?>" size="20" maxlength="15" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="label">Dasar Harga </td>
                                            <td class="content">
                                                <select name="dasarharga" class="txt" id="select10">
                                                 <option value=''>Pilih Dasar Harga</option>
                                                    <option value="1" <?php if ($rows["dasarharga"]==1) echo "selected"; ?>>1 - Pemborongan</option>
                                                    <option value="2" <?php if ($rows["dasarharga"]==2) echo "selected"; ?>>2 - Taksiran</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="label">Mata Anggaran </td>
                                            <td class="content">
                                                <select id="idsumberdana" name="idsumberdana" class="txt">
                                                    <option value=''>Pilih Mata Anggaran</option>
                                                    <?php
                                                    $query = "SELECT idsumberdana,keterangan from as_ms_sumberdana order by nourut";
                                                    $rs = mysql_query($query);
                                                    while($row = mysql_fetch_array($rs)) {
                                                        echo "<option value='".$row['idsumberdana']."' ";
                                                        if($row['idsumberdana'] == $rows['idsumberdana'])
                                                            echo 'selected';
                                                        echo ">".$row['keterangan']."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="label">No MA </td>
                                            <td class="content">
                                                <input name="manama" type="text" class="txt" id="manama" value="<?php echo $rows["manama"]; ?>" size="50" maxlength="50" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="header2">III. PENGURUS BARANG </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="label">Nama / Jabatan </td>
                                            <td class="content">
                                                <input name="namapengurus" type="text" class="txt" id="namapengurus" value="<?php echo $rows["namapengurus"]; ?>" size="50" maxlength="50" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="label">Alamat</td>
                                            <td class="content">
                                                <input name="alamatpengurus" type="text" class="txt" id="alamatpengurus" value="<?php echo $rows["alamatpengurus"]; ?>" size="50" maxlength="50" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="header2">IV. BAGIAN-BAGIAN LAIN/PERLENGKAPAN </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="label">Catatan Perlengkapan </td>
                                            <td class="content">
                                                <textarea name="catperlengkapan" cols="60" class="txt" rows="3" id="catperlengkapan"><?php echo $rows["catperlengkapan"]; ?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="label">Catatan Pengisi </td>
                                            <td class="content">
                                                <textarea name="catpengisi" cols="60" rows="3" class="txt" id="catpengisi"><?php echo $rows["catpengisi"]; ?></textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" class="header2">DISETUJUI OLEH </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="label">Nama</td>
                                            <td class="content">
                                                <input name="namapetugas" type="text" class="txt" id="namapetugas" value="<?php echo $rows["namapetugas"]; ?>" size="50" maxlength="50" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="label">Jabatan</td>
                                            <td class="content">
                                                <input name="jabatanpetugas" type="text" class="txt" id="jabatanpetugas" value="<?php echo $rows["jabatanpetugas"]; ?>" size="50" maxlength="50" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="label">Tanggal</td>
                                            <td class="content">
                                                <input name="tgldisetujui" readonly type="text" class="txt" id="tgldisetujui" value="<?php if(isset($rows["tgldisetujui"])) echo date("d-m-Y",strtotime($rows["tgldisetujui"])); ?>" size="20" maxlength="15" />
                                                <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgldisetujui'),depRange);" />
                                                <font color="#666666"><em>(dd-mm-yyyy)</em></font>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="header2">DIISI OLEH </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="label">Nama</td>
                                            <td class="content">
                                                <input name="namapetugas2" type="text" class="txt" id="namapetugas2" value="<?php echo $rows["namapetugas2"]; ?>" size="50" maxlength="50" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="label">Jabatan</td>
                                            <td class="content">
                                                <input name="jabatanpetugas2" type="text" class="txt" id="jabatanpetugas2" value="<?php echo $rows["jabatanpetugas2"]; ?>" size="50" maxlength="50" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="label">Tanggal</td>
                                            <td class="content">
                                                <input name="tgldiisi" readonly type="text" class="txt" id="tgldiisi" value="<?php if(isset($rows["tgldiisi"])) echo date("d-m-Y",strtotime($rows["tgldiisi"])); ?>" size="20" maxlength="15" />
                                                <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgldiisi'),depRange);" />
                                                <font color="#666666"><em>(dd-mm-yyyy)</em></font>
                                            </td>
                                        </tr>
                                        <input type="hidden" id="act" name="act" />
                                        <tr>
                                            <td height="25" colspan="3" class="footer">&nbsp;</td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <div><img alt="" src="../images/foot.gif" width="1000" height="45" /></div>
                    </td>
                </tr>
            </table>
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
                location='aset.php';
            }else{
                location='<?php echo $_REQUEST['from']."?unit=".$_REQUEST['unit']."&lokasi=".$_REQUEST['lokasi']."&namaunit=".$_REQUEST['namaunit']."&namalokasi=".$_REQUEST['namalokasi']."&baris=".$_REQUEST['baris'];?>';
            }
        }
    </script>
</html>
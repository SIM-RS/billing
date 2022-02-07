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
        $jenisbang = $_POST["jenisbang"];
        $tipebang = $_POST["tipebang"];
        $golbang = $_POST["golbang"];
        $kelasbang = $_POST["kelasbang"];
        $tglbangun = tglSQL($_POST["tglbangun"]);
        $statushukum = $_POST["statushukum"];
        $nopersil = $_POST["nopersil"];
        $ijinbangno = $_POST["ijinbangno"];
        $ijinbangtgl = tglSQL($_POST["ijinbangtgl"]);
        $gambarno = $_POST["gambarno"];
        $gambarmacam = $_POST["gambarmacam"];
        $gambarskala = $_POST["gambarskala"];
        $gambarjumlah = $_POST["gambarjumlah"];
        $nokibtanah = $_POST["nokibtanah"];
        $suratsertifikat =  $_POST["suratsertifikat"];
        $sertifikattgl =  tglSQL($_POST["sertifikattgl"]);
        $surat3 =  $_POST["surat3"];
        $alamat =  $_POST["alamat"];
        $kelurahan =  $_POST["kelurahan"];
        $kecamatan =  $_POST["kecamatan"];
        $kotamadya =  $_POST["kotamadya"];
        $konskategori = $_POST["konskategori"];
        $konsatap = $_POST["konsatap"];
        $konskusen = $_POST["konskusen"];
        $konsrangka = $_POST["konsrangka"];
        $konspondasi = $_POST["konspondasi"];
        $konsdinding = $_POST["konsdinding"];
        $konsplafon = $_POST["konsplafon"];
        $konslantai = $_POST["konslantai"];
        $jumlahlantai = $_POST["jumlahlantai"];
        $luaslantai = $_POST["luaslantai"];
        $luasbangunan = $_POST["luasbangunan"];
        $luaslantai1 = $_POST["luaslantai1"];
        $luaslantai2 = $_POST["luaslantai2"];
        $luaslantai3 = $_POST["luaslantai3"];
        $luaslantai4 = $_POST["luaslantai4"];
        $luaslantai5 = $_POST["luaslantai5"];
        $luaslantai6 = $_POST["luaslantai6"];
        $luaslantai7 = $_POST["luaslantai7"];
        $luaslantai8 = $_POST["luaslantai8"];
        $caraperolehan = $_POST["caraperolehan"];
        $diperolehdari = $_POST["diperolehdari"];
        //$tahunperolehan = $_POST["tahunperolehan"];
        $hargasatuan = $_POST["hargasatuan"];
        $dasarharga = $_POST["dasarharga"];
        $idsumberdana = $_POST["idsumberdana"];
        $manama = $_POST["manama"];
        $namapengurus = $_POST["namapengurus"];
        $alamatpengurus = $_POST["alamatpengurus"];
        $catpengisi = $_POST["catpengisi"];
        $namapetugas = $_POST["namapetugas"];
        $jabatanpetugas = $_POST["jabatanpetugas"];
        $tgldisetujui = tglSQL($_POST["tgldisetujui"]);
        $namapetugas2 = $_POST["namapetugas2"];
        $jabatanpetugas2 = $_POST["jabatanpetugas2"];
        $tgldiisi = tglSQL($_POST["tgldiisi"]);

        $query = "update as_kib set jenisbang = '$jenisbang', tipebang = '$tipebang', golbang = '$golbang', kelasbang = '$kelasbang', tglbangun = '$tglbangun'
                        , statushukum = '$statushukum', nopersil = '$nopersil', ijinbangno = '$ijinbangno', ijinbangtgl = '$ijinbangtgl', gambarno = '$gambarno'
                        , gambarmacam = '$gambarmacam', gambarskala = '$gambarskala', gambarjumlah = '$gambarjumlah', nokibtanah = '$nokibtanah'
                        , suratsertifikat = '$suratsertifikat', sertifikattgl = '$sertifikattgl', surat3 = '$surat3', alamat = '$alamat', kelurahan = '$kelurahan'
                        , kecamatan = '$kecamatan', kotamadya = '$kotamadya', konskategori = '$konskategori', konsatap = '$konsatap', konskusen = '$konskusen'
                        , konsrangka = '$konsrangka', konspondasi = '$konspondasi', konsdinding = '$konsdinding', konsplafon = '$konsplafon', konslantai = '$konslantai'
                        , jumlahlantai = '$jumlahlantai', luaslantai = '$luaslantai', luasbangunan = '$luasbangunan', luaslantai1 = '$luaslantai1'
                        , luaslantai2 = '$luaslantai2', luaslantai3 = '$luaslantai3', luaslantai4 = '$luaslantai4', luaslantai5 = '$luaslantai5'
                        , luaslantai6 = '$luaslantai6', luaslantai7 = '$luaslantai7', luaslantai8 = '$luaslantai8', caraperolehan = '$caraperolehan'
                        , diperolehdari = '$diperolehdari', hargasatuan = '$hargasatuan', dasarharga = '$dasarharga', idsumberdana = '$idsumberdana', manama = '$manama'
                        , namapengurus = '$namapengurus', alamatpengurus = '$alamatpengurus', catpengisi = '$catpengisi', namapetugas = '$namapetugas'
                        , jabatanpetugas = '$jabatanpetugas', tgldisetujui = '$tgldisetujui', namapetugas2 = '$namapetugas2', jabatanpetugas2 = '$jabatanpetugas2'
                        , tgldiisi = '$tgldiisi', t_userid = '$t_userid', t_updatetime = '$t_updatetime', t_ipaddress = '$t_ipaddress' where id_kib = $id_kib_seri[0]";

//        $strUpdate = "select jenisbang,tipebang,golbang,kelasbang,tglbangun,statushukum,nopersil,ijinbangno,ijinbangtgl,gambarno,gambarmacam,gambarskala,";
//		$strUpdate .= "gambarjumlah,nokibtanah,suratsertifikat,sertifikattgl,surat3,alamat,kelurahan,kecamatan,kotamadya,konskategori,konsatap,konskusen,konsrangka,";
//		$strUpdate .= "konspondasi,konsdinding,konsplafon,konslantai,jumlahlantai,luaslantai,luasbangunan,luaslantai1,luaslantai2,luaslantai3,luaslantai4,";
//		$strUpdate .= "luaslantai5,luaslantai6,luaslantai7,luaslantai8,caraperolehan,diperolehdari,hargasatuan,";
//		$strUpdate .= "dasarharga,idsumberdana,manama,namapengurus,alamatpengurus,catpengisi,";
//		$strUpdate .= "namapetugas,jabatanpetugas,tgldisetujui,namapetugas2,jabatanpetugas2,tgldiisi,t_userid,t_updatetime,t_ipaddress from as_kib where id_kib=$r_idkib";
        $rs = mysql_query($query);
        $res = mysql_affected_rows();
        $err = mysql_error();
        if(!isset($err) || $err == '') {
            $keadaanalat = $_POST["keadaanalat"];
            $catperlengkapan = $_POST["catperlengkapan"];
            $kondisiperolehan = $_POST["kondisiperolehan"];

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
                window.location = 'konstruksi.php';
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
        <title>KIB Konstruksi</title>
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
            $query = "select kodeunit,namaunit,kodebarang,namabarang,idseri,noseri,catperlengkapan,keadaanalat,kondisiperolehan,k.*,keterangan,k.idsumberdana
                    from as_seri s inner join as_transaksi t on s.idtransaksi=t.idtransaksi
                    inner join as_ms_unit u on u.idunit=t.idunit
                    inner join as_ms_barang b on b.idbarang=t.idbarang
                    inner join as_kib k on k.idtransaksi=t.idtransaksi
                    left join as_ms_sumberdana ams on k.idsumberdana = ams.idsumberdana
                    where k.id_kib = '".$id_kib_seri[0]."' and s.idseri = '".$id_kib_seri[1]."'";
            /*$sqltnh = "SELECT b.kodebarang,b.namabarang,u.namaunit,u.kodeunit,k.id_kib,noseri,
                    k.jenistanah,k.peruntukan,k.luastanah,k.alamat,k.statushukum,k.suratukur,k.suratgirik,
                    k.suratsertifikat,date_format(k.sertifikattgl,'%d-%m-%Y') as sertifikattgl,k.suratakte,k.suratskpt,k.suratlain,
                    k.gambarno,k.gambarmacam,k.gambarskala,k.gambarjumlah,k.macampersil,k.macampemanfaatan,k.macamnonpersil,k.macamjenisnonpersil,
                    k.caraperolehan,k.diperolehdari,date_format(k.tglperolehan,'%d-%m-%Y') as tglperolehan,k.hargasatuan,k.dasarharga,k.manama,keterangan
                    ,k.namapengurus,k.alamatpengurus,k.catpengisi,k.namapetugas,k.jabatanpetugas,date_format(k.tgldisetujui,'%d-%m-%Y') as tgldisetujui
                    ,k.namapetugas2,k.jabatanpetugas2,date_format(k.tgldiisi,'%d-%m-%Y') as tgldiisi,s.catperlengkapan,kondisiperolehan,keadaanalat,k.idsumberdana
                    FROM as_kib k
                    INNER JOIN as_transaksi t ON t.idtransaksi = k.idtransaksi
                    INNER JOIN as_ms_barang b ON b.idbarang = t.idbarang
                    INNER JOIN as_ms_unit u ON u.idunit = t.idunit
                    inner join as_seri s on t.idtransaksi = s.idtransaksi
                    left join as_ms_sumberdana d on k.idsumberdana = d.idsumberdana
                    WHERE k.id_kib = '".$id_kib_seri[0]."' and s.idseri = '".$id_kib_seri[1]."'";*/
            $dttnh = mysql_query($query);
            $rows = mysql_fetch_array($dttnh);
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
                        <button class="EnabledButton" id="editButton" name="editButton" onClick="action(this.title)" title="Edit" style="cursor:pointer"><!--location='editMesin.php?id_kib=<-?php echo $id_kib_seri[0];?>'-->
                            <img alt="edit" src="../images/editsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                            Edit Record
                        </button>
                        <button class="DisabledButton" id="saveButton" onClick="action(this.title)" title="Save" style="display: none;cursor:pointer">
                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                            Save Record
                        </button>
                        <button class="Disabledbutton" id="undobutton" disabled onClick="location='detailKonstruksi.php<?php echo $par?>'" title="Cancel / Refresh" style="cursor:pointer">
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
                <table width="625" border="0" cellspacing="0" cellpadding="2" align="center">
                    <tr>
                        <td colspan="2" class="header">.: Kartu Inventaris Barang : Konstruksi Dalam Pengerjaan :.</td>
                    </tr>
                    <tr>
                        <td width="40%" class="label">&nbsp;Unit Kerja</td>
                        <td width="60%" class="content">&nbsp;
                            <?php echo $rows['namaunit'];?>&nbsp;(<?php echo $rows['kodeunit']; ?>)
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kode Barang - Seri</td>
                        <td class="content">&nbsp;
                            <?php echo $rows['kodebarang'].' - '.$rows['noseri'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama Barang</td>
                        <td class="content">&nbsp;
                            <?php echo $rows['namabarang'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;I. UNIT BARANG</td>
                    </tr>
                    <tr>
                        <td class="label">Jenis Bangunan</td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rows["jenisbang"]) {
                                case 1 : echo "Rumah Tinggal";
                                    break;
                                case 2 : echo "Rumah Sementara";
                                    break;
                                case 3 : echo "Wisma";
                                    break;
                                case 4 : echo "Asrama";
                                    break;
                                case 5 : echo "Mess";
                                    break;
                                default : break;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Tipe Bangunan </td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rows["tipebang"]) {
                                case 1 : echo "A";
                                    break;
                                case 2 : echo "B";
                                    break;
                                case 3 : echo "C";
                                    break;
                                case 4 : echo "D";
                                    break;
                                case 5 : echo "E";
                                    break;
                                default : break;
                            }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Golongan</td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rows["golbang"]) {
                                case 1 : echo "Gol I";
                                    break;
                                case 2 : echo "Gol II";
                                    break;
                                case 3 : echo "Gol III";
                                    break;
                                default :
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Kelas</td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rows["kelasbang"]) {
                                case 1 : echo "IA";
                                    break;
                                case 2 : echo "I";
                                    break;
                                case 3 : echo "II";
                                    break;
                                case 4 : echo "III";
                                    break;
                                case 5 : echo "IV";
                                    break;
                                default :
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label" valign="top">Kondisi Bangunan </td>
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
                        <td class="label">Tgl Bangun </td>
                        <td class="content">&nbsp;
                            <?php if ($rows["tglbangun"])
                                echo date("d-m-Y",strtotime($rows["tglbangun"]));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Status Hukum </td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rows["statushukum"]) {
                                case 1 : echo "Hak Guna Usaha";
                                    break;
                                case 2 : echo "Hak Milik";
                                    break;
                                case 3 : echo "Hak Guna Bangunan";
                                    break;
                                case 4 : echo "Hak Pakai";
                                    break;
                                case 5 : echo "Hak Sewa Bangunan";
                                    break;
                                case 6 : echo "Hak Membuka Tanah";
                                    break;
                                case 7 : echo "Hak Sewa Tanah Pertanian";
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">No Persil </td>
                        <td class="content">&nbsp;
                            <?php echo $rows["nopersil"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Ijin Bangunan No </td>
                        <td class="content">&nbsp;
                            <?php echo $rows["ijinbangno"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Ijin Bangunan Tgl </td>
                        <td class="content">&nbsp;
                            <?php
                            if ($rows["ijinbangtgl"])
                                echo date("d M Y",strtotime($rows["ijinbangtgl"]));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Gambar No </td>
                        <td class="content">&nbsp;
                            <?php echo $rows["gambarno"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Gambar Macam </td>
                        <td class="content">&nbsp;
                            <?php echo $rows["gambarmacam"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Gambar Skala </td>
                        <td class="content">&nbsp;
                            <?php echo $rows["gambarskala"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Gambar Jumlah </td>
                        <td class="content">&nbsp;
                            <?php echo $rows["gambarjumlah"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label" height="28">Nomor KIB Tanah </td>
                        <td class="content">&nbsp;

                            <?php echo $rows["nokibtanah"]; ?></td>
                    </tr>
                    <tr>

                        <td class="label" height="28">Dokumen Nomor</td>
                        <td class="content">&nbsp;
                            <?php echo $rows["suratsertifikat"]; ?>
                        </td>
                    </tr>
                    <tr>

                        <td class="label" height="28">Dokumen Tgl</td>
                        <td class="content">&nbsp;
                            <?php if ($rows["sertifikattgl"])
                                echo date("d-m-Y",strtotime($rows["sertifikattgl"]));
                            ?>
                        </td>
                    </tr>
                    <tr>

                        <td class="label" height="28">Surat Kerja Lainnya</td>
                        <td class="content">&nbsp;
                            <?php echo $rows["surat3"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label" height="28">Alamat</td>
                        <td class="content">&nbsp;
                            <?php echo $rows["alamat"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Kelurahan</td>
                        <td class="content">&nbsp;
                            <?php
                            echo $rows["kelurahan"];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Kecamatan</td>
                        <td class="content">&nbsp;
                            <?php echo $rows["kecamatan"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Kab/Kodya</td>
                        <td class="content">&nbsp;
                            <?php echo $rows["kotamadya"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">II. KONSTRUKSI</td>
                    </tr>
                    <tr>
                        <td valign="top" class="label">Kategori</td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rows["konskategori"]) {
                                case 1 : echo "Permanen";
                                    break;
                                case 2 : echo "Semi Permanen";
                                    break;
                                case 3 : echo "Darurat";
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label">Atap</td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rows["konsatap"]) {
                                case 1 : echo "Beton";
                                    break;
                                case 2 : echo "Seng";
                                    break;
                                case 3 : echo "Asbes";
                                    break;
                                case 4 : echo "Sirap";
                                    break;
                                case 5 : echo "Genteng";
                                    break;
                                case 6 : echo "Lainnya";
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label">Kusen</td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rows["konskusen"]) {
                                case 1 : echo "Kayu";
                                    break;
                                case 2 : echo "Aluminium";
                                    break;
                                case 3 : echo "Lainnya";
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label">Rangka</td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rows["konsrangka"]) {
                                case 1 : echo "Besi";
                                    break;
                                case 2 : echo "Kayu Lapis";
                                    break;
                                case 3 : echo "Beton";
                                    break;
                                case 4 : echo "Lainnya";
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label">Pondasi</td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rows["konspondasi"]) {
                                case 1 : echo "Beton";
                                    break;
                                case 2 : echo "Batu Kali";
                                    break;
                                case 3 : echo "Tiang Pancang";
                                    break;
                                case 4 : echo "Lainnya";
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label">Dinding</td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rows["konsdinding"]) {
                                case 1 : echo "Kayu";
                                    break;
                                case 2 : echo "Tembok";
                                    break;
                                case 3 : echo "Bambu";
                                    break;
                                case 4 : echo "Lainnya";
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label">Plafon</td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rows["konsplafon"]) {
                                case 1 : echo "Beton";
                                    break;
                                case 2 : echo "Kayu";
                                    break;
                                case 3 : echo "Bambu";
                                    break;
                                case 4 : echo "Asbes";
                                    break;
                                case 5 : echo "Akustik";
                                    break;
                                case 6 : echo "Lainnya";
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label">Lantai</td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rows["konslantai"]) {
                                case 1 : echo "Tegel";
                                    break;
                                case 2 : echo "Flur";
                                    break;
                                case 3 : echo "Marmer";
                                    break;
                                case 4 : echo "Teraso";
                                    break;
                                case 5 : echo "Keramik";
                                    break;
                                case 6 : echo "Lainnya";
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label">Jumlah Lantai</td>
                        <td class="content">&nbsp;
                            <?php echo $rows["jumlahlantai"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label">Luas Lantai Total </td>
                        <td class="content">&nbsp;
                            <?php echo $rows["luaslantai"]; ?> m2
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label">Luas Bangunan Total</td>
                        <td class="content">&nbsp;
                            <?php echo $rows["luasbangunan"]; ?> m2
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label">Luas Lt 1 </td>
                        <td class="content">&nbsp;
                            <?php echo $rows["luaslantai1"]; ?> m2
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label">Luas Lt 2 </td>
                        <td class="content">&nbsp;
                            <?php echo $rows["luaslantai2"]; ?> m2
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label">Luas Lt 3 </td>
                        <td class="content">&nbsp;
                            <?php echo $rows["luaslantai3"]; ?> m2
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label">Luas Lt 4 </td>
                        <td class="content">&nbsp;
                            <?php echo $rows["luaslantai4"]; ?> m2
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label">Luas Lt 5 </td>
                        <td class="content">&nbsp;
                            <?php echo $rows["luaslantai5"]; ?> m2
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Luas Lt 6 </td>
                        <td class="content">&nbsp;
                            <?php echo $rows["luaslantai6"]; ?> m2
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Luas Lt 7 </td>
                        <td class="content">&nbsp;
                            <?php echo $rows["luaslantai7"]; ?> m2
                        </td>
                    </tr>

                    <tr>
                        <td valign="top" class="label">Luas Lt 8 </td>
                        <td class="content">&nbsp;
                            <?php echo $rows["luaslantai8"]; ?> m2
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;III. PENGADAAN</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Cara Perolehan</td>
                        <td class="content">&nbsp;
                            <?php
                            $aCrPerolehan = array('','Pembelian','Hibah','Pembebasan','Sebelum 1945','Tukar Menukar','Cara Lain');
                            echo $aCrPerolehan[$rows['caraperolehan']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Diperoleh Dari</td>
                        <td class="content">&nbsp;
                            <?php echo $rows['diperolehdari'];?></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kondisi Perolehan</td>
                        <td class="content">&nbsp;
                            <?php
                            $konper = array('','Ada Bangunan','Siap Dibangun','Belum Dibangun','Tidak dapat dibangun');
                            echo $konper[$rows['kondisiperolehan']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Harga</td>
                        <td class="content">&nbsp;
                            <?php echo $rows['hargasatuan'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Dasar Harga</td>
                        <td class="content">&nbsp;
                            <?php
                            $aDsrHrg = array('','Pemborongan','Taksiran');
                            echo $aDsrHrg[$rows['dasarharga']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Mata Anggaran</td>
                        <td class="content">&nbsp;
                            <?php
                            echo $rows['keterangan'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;No MA</td>
                        <td class="content">&nbsp;
                            <?php echo $rows['manama'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;IV. PENGURUS BARANG</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama/Jabatan</td>
                        <td class="content">&nbsp;
                            <?php echo $rows['namapengurus'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Alamat</td>
                        <td class="content">&nbsp;
                            <?php echo $rows['alamatpengurus'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;V. BAGIAN-BAGIAN LAIN/PERLENGKAPAN</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Catatan Perlengkapan</td>
                        <td class="content">&nbsp;
                            <?php echo $rows['catperlengkapan'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Catatan Pengisi</td>
                        <td class="content">&nbsp;
                            <?php echo $rows['catpengisi'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;DISETUJUI OLEH</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama</td>
                        <td class="content">&nbsp;
                            <?php echo $rows['namapetugas'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Jabatan</td>
                        <td class="content">&nbsp;
                            <?php echo $rows['jabatanpetugas'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Tanggal</td>
                        <td class="content">&nbsp;
                            <?php echo $rows['tgldisetujui'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;DIISI OLEH</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama</td>
                        <td class="content">&nbsp;
                            <?php echo $rows['namapetugas2'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Jabatan</td>
                        <td class="content">&nbsp;
                            <?php echo $rows['jabatanpetugas2'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Tanggal</td>
                        <td class="content">&nbsp;
                            <?php echo $rows['tgldiisi'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;</td>
                    </tr>
                </table>
            </div>
            <div id="div_edit" style="display: <?php echo $vis_edit;?>;">
                <form id="form1" name="form1" action="" method="post">
                    <table width="650" border=0 cellspacing=0 cellpadding="4" bgcolor="#EDF1FE">
                        <tr>
                            <td height="25" colspan="3" align="center" class="header">
                                .: Kartu Inventaris Barang : Konstruksi Dalam Pengerjaan :.
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
                        <tr>
                            <td class="label">Jenis Bangunan </td>
                            <td class="content">
                                <select name="jenisbang" class="txt" id="jenisbang">
                                    <option value="1" <?php if ($rows["jenisbang"]==1) echo "selected"; ?>>1 - Rumah Tinggal</option>
                                    <option value="2" <?php if ($rows["jenisbang"]==2) echo "selected"; ?>>2 - Rumah Sementara</option>
                                    <option value="3" <?php if ($rows["jenisbang"]==3) echo "selected"; ?>>3 - Wisma</option>
                                    <option value="4" <?php if ($rows["jenisbang"]==4) echo "selected"; ?>>4 - Asrama</option>
                                    <option value="5" <?php if ($rows["jenisbang"]==5) echo "selected"; ?>>5 - Mess</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Tipe Bangunan</td>
                            <td class="content">
                                <select name="tipebang" class="txt" id="select2">
                                    <option value="1" <?php if ($rows["tipebang"]==1) echo "selected"; ?>>1 - A</option>
                                    <option value="2" <?php if ($rows["tipebang"]==2) echo "selected"; ?>>2 - B</option>
                                    <option value="3" <?php if ($rows["tipebang"]==3) echo "selected"; ?>>3 - C</option>
                                    <option value="4" <?php if ($rows["tipebang"]==4) echo "selected"; ?>>4 - D</option>
                                    <option value="5" <?php if ($rows["tipebang"]==5) echo "selected"; ?>>5 - E</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Golongan </td>
                            <td class="content">
                                <select name="golbang" class="txt" id="golbang">
                                    <option value="1" <?php if ($rows["golbang"]==1) echo "selected"; ?>>1 - I</option>
                                    <option value="2" <?php if ($rows["golbang"]==2) echo "selected"; ?>>2 - II</option>
                                    <option value="3" <?php if ($rows["golbang"]==3) echo "selected"; ?>>3 - III</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Kelas </td>
                            <td class="content">
                                <select name="kelasbang" class="txt" id="select4">
                                    <option value="1" <?php if ($rows["kelasbang"]==1) echo "selected"; ?>>1 - I A</option>
                                    <option value="2" <?php if ($rows["kelasbang"]==2) echo "selected"; ?>>2 - I</option>
                                    <option value="3" <?php if ($rows["kelasbang"]==3) echo "selected"; ?>>3 - II</option>
                                    <option value="4" <?php if ($rows["kelasbang"]==4) echo "selected"; ?>>4 - III</option>
                                    <option value="5" <?php if ($rows["kelasbang"]==5) echo "selected"; ?>>5 - IV</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Kondisi Bangunan </td>
                            <td class="content">
                                <select name="keadaanalat" class="txt" id="keadaanalat">
                                    <option value="1" <?php if ($rows["keadaanalat"]==1) echo "selected" ?>>1 - Baik</option>
                                    <option value="2" <?php if ($rows["keadaanalat"]==2) echo "selected" ?>>2 - Rusak Ringan</option>
                                    <option value="3" <?php if ($rows["keadaanalat"]==3) echo "selected" ?>>3 - Rusak Berat</option>
                                    <option value="4" <?php if ($rows["keadaanalat"]==4) echo "selected" ?>>4 - Tidak Berfungsi</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Tgl Bangun </td>
                            <td class="content">
                                <input name="tglbangun" type="text" class="txt" id="tglbangun" value="<?php echo date("d-m-Y",strtotime($rows["tglbangun"])); ?>" readonly size="15" maxlength="15" />
                                <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglbangun'),depRange);" /> <font size=1 color=gray><i>(dd-mm-YYYY)</i></font>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Status Hukum </td>
                            <td class="content">
                                <select name="statushukum" class="txt" id="statushukum">
                                    <option value="1" <?php if ($rows["statushukum"]==1) echo "selected" ?>>1 - Hak Guna Usaha</option>
                                    <option value="2" <?php if ($rows["statushukum"]==2) echo "selected" ?>>2 - Hak Milik</option>
                                    <option value="3" <?php if ($rows["statushukum"]==3) echo "selected" ?>>3 - Hak Guna Bangunan</option>
                                    <option value="4" <?php if ($rows["statushukum"]==4) echo "selected" ?>>4 - Hak Pakai</option>
                                    <option value="5" <?php if ($rows["statushukum"]==5) echo "selected" ?>>5 - Hak Sewa untuk Bangunan</option>
                                    <option value="6" <?php if ($rows["statushukum"]==6) echo "selected" ?>>6 - Hak Membuka Tanah</option>
                                    <option value="7" <?php if ($rows["statushukum"]==7) echo "selected" ?>>7 - Hak Sewa Tanah Pertanian</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">No Persil </td>
                            <td class="content">
                                <input name="nopersil" type="text" class="txt" id="alamat" value="<?php echo $rows["nopersil"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Ijin Bang. No </td>
                            <td class="content">
                                <input name="ijinbangno" type="text" class="txt" id="nopersil" value="<?php echo $rows["ijinbangno"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Ijin Bang. Tgl. </td>
                            <td class="content">
                                <input name="ijinbangtgl" type="text" class="txt" id="ijinbangtgl" value="<?php echo date("d-m-Y",strtotime($rows["ijinbangtgl"])); ?>" readonly size="20" maxlength="15" />
                                <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('ijinbangtgl'),depRange);" /> <font size=1 color=gray><i>(dd-mm-YYYY)</i></font>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Gambar No </td>
                            <td class="content">
                                <input name="gambarno" type="text" class="txt" id="suratlain" value="<?php echo $rows["gambarno"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Gambar Macam </td>
                            <td class="content">
                                <input name="gambarmacam" type="text" class="txt" id="gambarno" value="<?php echo $rows["gambarmacam"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Gambar Skala </td>
                            <td class="content">
                                <input name="gambarskala" type="text" class="txt" id="gambarno2" value="<?php echo $rows["gambarskala"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Gambar Jumlah </td>
                            <td class="content">
                                <input name="gambarjumlah" type="text" class="txt" id="gambarno3" value="<?php echo $rows["gambarjumlah"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" height="28">No KIB Tanah </td>
                            <td class="content">
                                <input name="nokibtanah" type="text" class="txt" id="ijinbangno" value="<?php echo $rows["nokibtanah"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" height="28">Dokumen Nomor</td>
                            <td class="content">
                                <input name="suratsertifikat" type="text" class="txt" id="suratsertifikat" value="<?php echo $rows["suratsertifikat"]; ?>" size="75" maxlength="100" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" height="28">Dokumen Tgl</td>
                            <td class="content">
                                <input name="sertifikattgl" type="text" class="txt" id="sertifikattgl" value="<?php echo date("d-m-Y",strtotime($rows["sertifikattgl"])); ?>" size="20" maxlength="15" />
                                <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('sertifikattgl'),depRange);" />
                                <font size=1 color=gray><i>(dd-mm-YYYY)</i></font>
                            </td>
                        </tr>
                        <tr>
                            <td class="label" height="28">Surat Kerja Lainnya</td>
                            <td class="content">
                                <input name="surat3" type="text" class="txt" id="surat12" value="<?php echo $rows["surat3"]; ?>" size="75" maxlength="100" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" height="28">Alamat</td>
                            <td class="content">
                                <input name="alamat" type="text" class="txt" id="surat13" value="<?php echo $rows["alamat"]; ?>" size="75" maxlength="100" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" height="28">Kelurahan</td>
                            <td class="content">
                                <input name="kelurahan" type="text" class="txt" id="kelurahan" value="<?php echo $rows["kelurahan"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" height="28">Kecamatan</td>
                            <td class="content">
                                <input name="kecamatan" type="text" class="txt" id="kecamatan" value="<?php echo $rows["kecamatan"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" height="28">Kab/Kodya</td>
                            <td class="content">
                                <input name="kotamadya" type="text" class="txt" id="kotamadya" value="<?php echo $rows["kotamadya"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">II. KONSTRUKSI </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Kategori</td>
                            <td class="content">
                                <select name="konskategori" class="txt" id="select5">
                                    <option value="1" <?php if ($rows["konskategori"]==1) echo "selected"; ?>>1 - Permanen</option>
                                    <option value="2" <?php if ($rows["konskategori"]==2) echo "selected"; ?>>2 - Semi Permanen</option>
                                    <option value="3" <?php if ($rows["konskategori"]==3) echo "selected"; ?>>3 - Darurat</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Atap</td>
                            <td class="content">
                                <select name="konsatap" class="txt" id="select6">
                                    <option value="1" <?php if ($rows["konsatap"]==1) echo "selected"; ?>>1 - Beton</option>
                                    <option value="2" <?php if ($rows["konsatap"]==2) echo "selected"; ?>>2 - Seng</option>
                                    <option value="3" <?php if ($rows["konsatap"]==3) echo "selected"; ?>>3 - Asbes</option>
                                    <option value="4" <?php if ($rows["konsatap"]==4) echo "selected"; ?>>4 - Sirap</option>
                                    <option value="5" <?php if ($rows["konsatap"]==5) echo "selected"; ?>>5 - Genteng</option>
                                    <option value="6" <?php if ($rows["konsatap"]==6) echo "selected"; ?>>6 - Lainnya</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Kusen</td>
                            <td class="content">
                                <select name="konskusen" class="txt" id="select7">
                                    <option value="1" <?php if ($rows["konskusen"]==1) echo "selected"; ?>>1 - Kayu</option>
                                    <option value="2" <?php if ($rows["konskusen"]==2) echo "selected"; ?>>2 - Alumunium</option>
                                    <option value="3" <?php if ($rows["konskusen"]==3) echo "selected"; ?>>3 - Lainnya</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Rangka </td>
                            <td class="content">
                                <select name="konsrangka" class="txt" id="select13">
                                    <option value="1" <?php if ($rows["konsrangka"]==1) echo "selected"; ?>>1 - Besi</option>
                                    <option value="2" <?php if ($rows["konsrangka"]==2) echo "selected"; ?>>2 - Kayu Lapis</option>
                                    <option value="3" <?php if ($rows["konsrangka"]==3) echo "selected"; ?>>3 - Beton</option>
                                    <option value="4" <?php if ($rows["konsrangka"]==4) echo "selected"; ?>>4 - Lainnya</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Pondasi</td>
                            <td class="content">
                                <select name="konspondasi" class="txt" id="select14">
                                    <option value="1"  <?php if ($rows["konspondasi"]==1) echo "selected"; ?>>1 - Beton</option>
                                    <option value="2" <?php if ($rows["konspondasi"]==2) echo "selected"; ?>>2 - Batu Kali</option>
                                    <option value="3" <?php if ($rows["konspondasi"]==3) echo "selected"; ?>>3 - Tiang Pancang</option>
                                    <option value="4" <?php if ($rows["konspondasi"]==4) echo "selected"; ?>>4 - Lainnya</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Dinding </td>
                            <td class="content">
                                <select name="konsdinding" class="txt" id="select15">
                                    <option value="1" <?php if ($rows["konsdinding"]==1) echo "selected"; ?>>1 - Kayu</option>
                                    <option value="2" <?php if ($rows["konsdinding"]==2) echo "selected"; ?>>2 - Tembok</option>
                                    <option value="3" <?php if ($rows["konsdinding"]==3) echo "selected"; ?>>3 - Bambu</option>
                                    <option value="4" <?php if ($rows["konsdinding"]==4) echo "selected"; ?>>4 - Lainnya</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Plafon </td>
                            <td class="content">
                                <select name="konsplafon" class="txt" id="select16">
                                    <option value="1" <?php if ($rows["konsplafon"]==1) echo "selected"; ?>>1 - Beton</option>
                                    <option value="2" <?php if ($rows["konsplafon"]==2) echo "selected"; ?>>2 - Kayu</option>
                                    <option value="3" <?php if ($rows["konsplafon"]==3) echo "selected"; ?>>3 - Bambu</option>
                                    <option value="4" <?php if ($rows["konsplafon"]==4) echo "selected"; ?>>4 - Asbes</option>
                                    <option value="5" <?php if ($rows["konsplafon"]==5) echo "selected"; ?>>5 - Akustik</option>
                                    <option value="6" <?php if ($rows["konsplafon"]==6) echo "selected"; ?>>6 - Lainnya</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Lantai </td>
                            <td class="content">
                                <select name="konslantai" class="txt" id="select17">
                                    <option value="1" <?php if ($rows["konslantai"]==1) echo "selected"; ?>>1 - Tegel</option>
                                    <option value="2" <?php if ($rows["konslantai"]==2) echo "selected"; ?>>2 - Flur</option>
                                    <option value="3" <?php if ($rows["konslantai"]==3) echo "selected"; ?>>3 - Bambu</option>
                                    <option value="4" <?php if ($rows["konslantai"]==4) echo "selected"; ?>>4 - Teraso</option>
                                    <option value="5" <?php if ($rows["konslantai"]==5) echo "selected"; ?>>5 - Keramik</option>
                                    <option value="6" <?php if ($rows["konslantai"]==6) echo "selected"; ?>>6 - Lainnya</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="label" valign="top">Jumlah Lantai</td>
                            <td class="content">
                                <input name="jumlahlantai" type="text" class="txt" id="jumlahlantai" value="<?php echo $rows["jumlahlantai"]; ?>" size="10" maxlength="4" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" valign="top">Luas Lantai Total </td>
                            <td class="content">
                                <input name="luaslantai" type="text" class="txt" id="luaslantai" value="<?php echo $rows["luaslantai"]; ?>" size="20" maxlength="10" /> m2
                            </td>
                        </tr>
                        <tr>
                            <td class="label" valign="top">Luas Bangunan Total</td>
                            <td class="content">
                                <input name="luasbangunan" type="text" class="txt" id="luasbangunan" value="<?php echo $rows["luasbangunan"]; ?>" size="20" maxlength="10" /> m2
                            </td>
                        </tr>
                        <tr>
                            <td class="label" valign="top">Luas Lt 1 </td>
                            <td class="content">
                                <input name="luaslantai1" type="text" class="txt" id="luaslantai1" value="<?php echo $rows["luaslantai1"]; ?>" size="20" maxlength="10" /> m2
                            </td>
                        </tr>
                        <tr>
                            <td class="label" valign="top">Luas Lt 2 </td>
                            <td class="content">
                                <input name="luaslantai2" type="text" class="txt" id="luaslantai2" value="<?php echo $rows["luaslantai2"]; ?>" size="20" maxlength="10" /> m2
                            </td>
                        </tr>
                        <tr>
                            <td class="label" valign="top">Luas Lt 3 </td>
                            <td class="content">
                                <input name="luaslantai3" type="text" class="txt" id="luaslantai3" value="<?php echo $rows["luaslantai3"]; ?>" size="20" maxlength="10" /> m2
                            </td>
                        </tr>
                        <tr>
                            <td class="label" valign="top">Luas Lt 4 </td>
                            <td class="content">
                                <input name="luaslantai4" type="text" class="txt" id="luaslantai4" value="<?php echo $rows["luaslantai4"]; ?>" size="20" maxlength="10" /> m2
                            </td>
                        </tr>
                        <tr>
                            <td class="label" valign="top">Luas Lt 5 </td>
                            <td class="content">
                                <input name="luaslantai5" type="text" class="txt" id="luaslantai5" value="<?php echo $rows["luaslantai5"]; ?>" size="20" maxlength="10" /> m2
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Luas Lt 6 </td>
                            <td class="content">
                                <input name="luaslantai6" type="text" class="txt" id="luaslantai6" value="<?php echo $rows["luaslantai6"]; ?>" size="20" maxlength="10" /> m2
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Luas Lt 7 </td>
                            <td class="content">
                                <input name="luaslantai7" type="text" class="txt" id="luaslantai7" value="<?php echo $rows["luaslantai7"]; ?>" size="20" maxlength="10" /> m2
                            </td>
                        </tr>

                        <tr>
                            <td class="label" valign="top">Luas Lt 8 </td>
                            <td class="content">
                                <input name="luaslantai8" type="text" class="txt" id="luaslantai8" value="<?php echo $rows["luaslantai8"]; ?>" size="20" maxlength="10" /> m2
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">III. PENGADAAN </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Cara Perolehan</td>
                            <td class="content">
                                <select name="caraperolehan" class="txt" id="select8">
                                    <option value="1" <?php if ($rows["caraperolehan"]==1) echo "selected" ?>>1 - Pembelian</option>
                                    <option value="2" <?php if ($rows["caraperolehan"]==2) echo "selected" ?>>2 - Hibah</option>
                                    <option value="3" <?php if ($rows["caraperolehan"]==3) echo "selected" ?>>3 - dll</option>
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
                            <td class="label" valign="top">Kondisi Perolehan </td>
                            <td class="content">
                                <select name="kondisiperolehan" class="txt" id="select9">
                                    <option value="1" <?php if ($rows["kondisiperolehan"]==1) echo "selected" ?>>1 - Baik</option>
                                    <option value="2" <?php if ($rows["kondisiperolehan"]==2) echo "selected" ?>>2 - Rusak Ringan</option>
                                    <option value="3" <?php if ($rows["kondisiperolehan"]==3) echo "selected" ?>>3 - Rusak Berat</option>
                                    <option value="4" <?php if ($rows["kondisiperolehan"]==4) echo "selected" ?>>4 - Tidak Berfungsi</option>
                                </select>
                            </td>
                        </tr>
                        <!--tr>
                          <td valign="top">Tahun Perolehan </td>
                          <td class="content"><input name="tahunperolehan" type="text" class="txt" id="tahunperolehan" value="<?php echo $rows["tahunperolehan"]; ?>" size="10" maxlength="4">
                            <font color="#666666"><em>(yyyy)</em></font></td>
                        </tr-->
                        <tr>
                            <td class="label" valign="top">Harga</td>
                            <td class="content">
                                <input name="hargasatuan" type="text" class="txt" id="hargasatuan" value="<?php echo $rows["hargasatuan"]; ?>" size="20" maxlength="15" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" valign="top">Dasar Harga </td>
                            <td class="content">
                                <select name="dasarharga" class="txt" id="select10">
                                    <option value="1" <?php if ($rows["dasarharga"]==1) echo "selected" ?>>1 - Pemborongan</option>
                                    <option value="2" <?php if ($rows["dasarharga"]==2) echo "selected" ?>>2 - Taksiran</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label" valign="top">Mata Anggaran </td>
                            <td class="content">
                                <select id="idsumberdana" name="idsumberdana" class="txt">
                                    <option value=''></option>
                                    <?php
                                    $query = "SELECT idsumberdana,keterangan from as_ms_sumberdana order by nourut";
                                    $rs = mysql_query($query);
                                    while($row = mysql_fetch_array($rs)) {
                                        echo "<option value='".$row['idsumberdana']."' ";
                                        if($row['idsumberdana'] == $rows['idsumberdana']) {
                                            echo 'selected';
                                        }
                                        echo ">".$row['keterangan']."</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label" valign="top">No MA </td>
                            <td class="content">
                                <input name="manama" type="text" class="txt" id="manama" value="<?php echo $rows["manama"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">IV. PENGURUS BARANG </td>
                        </tr>
                        <tr>
                            <td class="label" valign="top">Nama / Jabatan </td>
                            <td class="content">
                                <input name="namapengurus" type="text" class="txt" id="namapengurus" value="<?php echo $rows["namapengurus"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label" valign="top">Alamat</td>
                            <td class="content">
                                <input name="alamatpengurus" type="text" class="txt" id="alamatpengurus" value="<?php echo $rows["alamatpengurus"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">V. KEADAAN FISIK SAAT PENCATATAN </td>
                        </tr>
                        <tr>
                            <td class="label" valign="top">Bangunan</td>
                            <td class="content">
                                <select name="keadaanbarang" class="txt" id="select12">
                                    <option value="1" <?php if ($rows["keadaanbang"]==1) echo "selected" ?>>1 - Baik</option>
                                    <option value="2" <?php if ($rows["keadaanbang"]==2) echo "selected" ?>>2 - Rusak Ringan</option>
                                    <option value="3" <?php if ($rows["keadaanbang"]==3) echo "selected" ?>>3 - Rusak Berat</option>
                                    <option value="4" <?php if ($rows["keadaanbang"]==4) echo "selected" ?>>4 - Tidak Berfungsi</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label" valign="top">Perlengkapan</td>
                            <td class="content">
                                <input name="keadaanperlengkapan" type="text" class="txt" id="keadaanperlengkapan" value="<?php echo $rows["keadaanperlengkapan"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">VI. BAGIAN-BAGIAN LAIN/PERLENGKAPAN </td>
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
                                <input name="tgldisetujui" type="text" class="txt" id="tgldisetujui" value="<?php echo date("d-m-Y",strtotime($rows["tgldisetujui"])); ?>" size="20" maxlength="15" />
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
                                <input name="tgldiisi" type="text" class="txt" id="tgldiisi" value="<?php echo date("d-m-Y",strtotime($rows["tgldiisi"])); ?>" size="20" maxlength="15" />
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
            <table><tr><td height="10"></td></tr></table>
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
                location='konstruksi.php';
            }else{
                location='<?php echo $_REQUEST['from']."?unit=".$_REQUEST['unit']."&lokasi=".$_REQUEST['lokasi']."&namaunit=".$_REQUEST['namaunit']."&namalokasi=".$_REQUEST['namalokasi']."&baris=".$_REQUEST['baris'];?>';
            }
        }
        
    </script>
</html>

<?php
include '../sesi.php';
include("../koneksi/konek.php");
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
$id_kib_seri = explode('|', $_GET['id_kib']);
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
        $tahunalat = $_POST["tahunbangun"];
        $statushukum = $_POST["statushukum"];
        $nopersil = $_POST["nopersil"];
        $ijinbangno = $_POST["ijinbangno"];
        $ijinbangtgl = tglSQL($_POST["ijinbangtgl"]);
        $gambarno = $_POST["gambarno"];
        $gambarmacam = $_POST["gambarmacam"];
        $gambarskala = $_POST["gambarskala"];
        $gambarjumlah = $_POST["gambarjumlah"];
        $nokibtanah = $_POST["nokibtanah"];
        $surat1 =  $_POST["surat1"];
        $surat2 =  $_POST["surat2"];
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
        $luaslantai1 = $_POST["luaslantai1"];
        $luaslantai2 = $_POST["luaslantai2"];
        $luaslantai3 = $_POST["luaslantai3"];
        $luaslantai4 = $_POST["luaslantai4"];
        $luaslantai5 = $_POST["luaslantai5"];
        $luaslantai6 = $_POST["luaslantai6"];
        $luaslantai7 = $_POST["luaslantai7"];
        $luaslantai8 = $_POST["luaslantai8"];
        $luasbangunan = $_POST["luasbangunan"];
        $caraperolehan = $_POST["caraperolehan"];
        $diperolehdari = $_POST["diperolehdari"];
        //$tahunperolehan = $_POST["tahunperolehan"];
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


        $keadaanalat = $_POST["keadaanalat"];
        $catperlengkapan = $_POST["catperlengkapan"];
        $kondisiperolehan = $_POST["kondisiperolehan"];

        // Update Record
        $query = "update as_kib set jenisbang = '$jenisbang', tipebang = '$tipebang', golbang = '$golbang', kelasbang = '$kelasbang', tahunalat = '$tahunalat'
            , statushukum = '$statushukum', nopersil = '$nopersil', ijinbangno = '$ijinbangno', ijinbangtgl = '$ijinbangtgl', gambarno = '$gambarno'
            , gambarmacam = '$gambarmacam', gambarskala = '$gambarskala', gambarjumlah = '$gambarjumlah', nokibtanah = '$nokibtanah', surat1 = '$surat1'
            , surat2 = '$surat2', surat3 = '$surat3', alamat = '$alamat', kelurahan = '$kelurahan', kecamatan = '$kecamatan', kotamadya = '$kotamadya'
            , konskategori = '$konskategori', konsatap = '$konsatap', konskusen = '$konskusen', konsrangka = '$konsrangka', konspondasi = '$konspondasi'
            , konsdinding = '$konsdinding', konsplafon = '$konsplafon', konslantai = '$konslantai', jumlahlantai = '$jumlahlantai', luaslantai = '$luaslantai'
            , luaslantai1 = '$luaslantai1', luaslantai2 = '$luaslantai2', luaslantai3 = '$luaslantai3', luaslantai4 = '$luaslantai4', luaslantai5 = '$luaslantai5'
            , luaslantai6 = '$luaslantai6', luaslantai7 = '$luaslantai7', luaslantai8 = '$luaslantai8', luasbangunan = '$luasbangunan', caraperolehan = '$caraperolehan'
            , diperolehdari = '$diperolehdari', dasarharga = '$dasarharga', idsumberdana = '$idsumberdana', hargasatuan = '$hargasatuan', manama = '$manama'
            , namapengurus = '$namapengurus', alamatpengurus = '$alamatpengurus', catpengisi = '$catpengisi', namapetugas = '$namapetugas'
            , jabatanpetugas = '$jabatanpetugas', tgldisetujui = '$tgldisetujui', namapetugas2 = '$namapetugas2', jabatanpetugas2 = '$jabatanpetugas2'
            , tgldiisi = '$tgldiisi', t_userid = '$t_userid', t_updatetime = '$t_updatetime', t_ipaddress = '$t_ipaddress'
            where id_kib = $id_kib_seri[0]";

        /*//*$strUpdate = "select jenisbang,tipebang,golbang,kelasbang,tahunalat,statushukum,nopersil,ijinbangno,ijinbangtgl,gambarno,gambarmacam,gambarskala,";
        $strUpdate .= "gambarjumlah,nokibtanah,surat1,surat2,surat3,alamat,kelurahan,kecamatan,kotamadya,konskategori,konsatap,konskusen,konsrangka,";
        $strUpdate .= "konspondasi,konsdinding,konsplafon,konslantai,jumlahlantai,luaslantai,luaslantai1,luaslantai2,luaslantai3,luaslantai4,";
        $strUpdate .= "luaslantai5,luaslantai6,luaslantai7,luaslantai8,luasbangunan,caraperolehan,diperolehdari,";
        $strUpdate .= "dasarharga,idsumberdana,hargasatuan,manama,namapengurus,alamatpengurus,catpengisi,";
        $strUpdate .= "namapetugas,jabatanpetugas,tgldisetujui,namapetugas2,jabatanpetugas2,tgldiisi,t_userid,t_updatetime,t_ipaddress
         * from in_kib
         *  where id_kib=$r_idkib";*/

        $rs = mysql_query($query);
        $res = mysql_affected_rows();
        $err = mysql_error();
        if(!isset($err) || $err == '') {
            $keadaanalat = $_POST["keadaanalat"];
            $catperlengkapan = $_POST["catperlengkapan"];
            $kondisiperolehan = $_POST["kondisiperolehan"];

            $query = "update as_seri set keadaanalat = '$keadaanalat', catperlengkapan = '$catperlengkapan', kondisiperolehan = '$kondisiperolehan'
                    , t_userid = '$t_userid', t_updatetime = '$t_updatetime', t_ipaddress = '$t_ipaddress'
                    where idseri = $id_kib_seri[0]";
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
                window.location = 'gedung.php';
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
        <title>KIB Gedung</title>
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

            echo $sqlgdg = "SELECT b.kodebarang,b.namabarang,u.namaunit,u.kodeunit,k.id_kib,
                        k.jenisbang,k.tipebang,k.golbang,k.kelasbang,tahunalat,
                        k.nopersil,k.ijinbangno,date_format(k.ijinbangtgl,'%d-%m-%Y') as ijinbangtgl,k.gambarno,k.gambarmacam,k.gambarskala,k.gambarjumlah,
                        k.nokibtanah,k.surat1,k.surat2,k.surat3,k.alamat,k.kelurahan,k.kecamatan,k.kotamadya,
                        k.konskategori,k.konsatap,k.konskusen,k.konsrangka,k.konspondasi,k.konsdinding,k.konsplafon,
                        k.konslantai,k.jumlahlantai,k.luaslantai,k.luasbangunan,k.luaslantai1,k.luaslantai2,k.luaslantai3,
                        k.luaslantai4,k.luaslantai5,k.luaslantai6,k.luaslantai7,k.luaslantai8,catperlengkapan,
                        k.caraperolehan,k.diperolehdari,k.hargasatuan,k.dasarharga,k.idsumberdana,noseri,
                        k.namapengurus,k.alamatpengurus,k.catpengisi,k.namapetugas,k.jabatanpetugas,k.tgldisetujui,
                        k.namapetugas2,k.jabatanpetugas2,k.tgldiisi,keadaanalat,statushukum,kondisiperolehan,keterangan,manama
                        FROM as_kib k
                        INNER JOIN as_transaksi t ON t.idtransaksi = k.idtransaksi
                        INNER JOIN as_ms_barang b ON b.idbarang = t.idbarang
                        LEFT JOIN as_ms_unit u ON u.idunit = t.idunit
                        LEFT JOIN as_ms_sumberdana s ON s.idsumberdana = k.idsumberdana
                        inner join as_seri se on t.idtransaksi = se.idtransaksi
                        WHERE LEFT(b.kodebarang,2) = 03 AND k.id_kib = '".$id_kib_seri[0]."' and idseri = '".$id_kib_seri[1]."'";
            $dtgdg = mysql_query($sqlgdg);
            $rwgdg = mysql_fetch_array($dtgdg);
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
                        <button class="Disabledbutton" id="undobutton" disabled onClick="location='detailGedung.php<?php echo $par?>'" title="Cancel / Refresh" style="cursor:pointer">
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
                        <td colspan="2" class="header">.: Kartu Inventaris Barang : Gedung Dan Bangunan - Detail :.</td>
                    </tr>
                    <tr>
                        <td width="40%" class="label">&nbsp;Unit Kerja</td>
                        <td width="60%" class="content">&nbsp;
                        <?php echo $rwgdg['namaunit'];?>&nbsp;(<?php echo $rwgdg['kodeunit']; ?>)
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kode Barang - Seri</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['kodebarang'].' - '.$rwgdg['noseri'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama Barang</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['namabarang'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;I. UNIT BARANG</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Jenis Bangunan</td>
                        <td class="content">&nbsp;
                            <?php
                            $jenisBang=array('','Rumah Tinggal','Rumah Sementara','Wisma','Asrama','Mess');
                            echo $jenisBang[$rwgdg['jenisbang']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Tipe Bangunan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwgdg['tipebang'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Golongan</td>
                        <td class="content">&nbsp;
                            <?php
                            $aGol=array('','I','II','III');
                            echo $aGol[$rwgdg['golbang']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kelas</td>
                        <td class="content">&nbsp;
                            <?php
                            $aKelas=array('','IA','I','II','III','IV');
                            echo $aKelas[$rwgdg['kelasbang']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kondisi Bangunan</td>
                        <td class="content">&nbsp;
                        <?php
                        $konbang = array('','Baik','Rusak Ringan','Rusak Berat','Tidak Berfungsi');
                        echo $konbang[$rwgdg['keadaanalat']];
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Tahun Bangun</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['tahunalat'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Status Tanah</td>
                        <td class="content">&nbsp;
                            <?php
                            $statushukum = array('','Hak Guna Usaha','Hak Milik','Hak Guna Bangunan','Hak Pakai','Hak Sewa untuk Bangunan','Hak Membuka Tanah','Hak Sewa Tanah Pertanian');
                            echo $statushukum[$rwgdg['statushukum']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;No. Persil</td>
                        <td class="content">&nbsp;
                            <?php echo $rwgdg['nopersil'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Ijin Bangunan No</td>
                        <td class="content">&nbsp;
                            <?php echo $rwgdg['ijinbangno'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Ijin Bangunan Tgl</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['ijinbangtgl'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Gambar No</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['gambarno'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Gambar Macam</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['gambarmacam'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Gambar Skala</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['gambarskala'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Gambar Jumlah</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['gambarjumlah'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nomor KIB Tanah</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['nokibtanah'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Surat-Surat 1</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['surat1'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Surat-Surat 2</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['surat2'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Surat-Surat 3</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['surat3'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Alamat</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['alamat'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kelurahan</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['kelurahan'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kecamatan</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['kecamatan'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kab/Kodya</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['kotamadya'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;II. KONSTRUKSI</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kategori</td>
                        <td class="content">&nbsp;
                            <?php
                            $aKat = array('','Permanen','Semi Permanen','Darurat');
                            echo $aKat[$rwgdg['konskategori']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Atap</td>
                        <td class="content">&nbsp;
                            <?php
                            $aAtap = array('','Beton','Seng','Asbes','Sirap','Genteng','Lainnya');
                            echo $aAtap[$rwgdg['konsatap']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kusen</td>
                        <td class="content">&nbsp;
                            <?php
                            $aKusen = array('','Kayu','Alumunium','Lainnya');
                            echo $aKusen[$rwgdg['konskusen']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Rangka</td>
                        <td class="content">&nbsp;
                            <?php
                            $aRangka = array('','Besi','Kayu Lapis','Beton','Lainnya');
                            echo $aRangka[$rwgdg['konsrangka']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Pondasi</td>
                        <td class="content">&nbsp;
                            <?php
                            $aPondasi = array('','Beton','Batu Kali','Tiang Pancang','Lainnya');
                            echo $aPondasi[$rwgdg['konspondasi']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Dinding</td>
                        <td class="content">&nbsp;
                            <?php
                            $aDinding = array('','Kayu','Tembok','Bambu','Lainnya');
                            echo $aDinding[$rwgdg['konsdinding']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Plafon</td>
                        <td class="content">&nbsp;
                            <?php
                            $aPlafon = array('','Beton','Kayu','Bambu','Asbes','Akustik','Lainnya');
                            echo $aPlafon[$rwgdg['konsplafon']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Lantai</td>
                        <td class="content">&nbsp;
                            <?php
                            $aLantai = array('','Tegel','Flur','Bambu','Teraso','Keramik','Lainnya');
                            echo $aLantai[$rwgdg['konslantai']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Jumlah Lantai</td>
                        <td class="content">&nbsp;
                            <?php echo $rwgdg['jumlahlantai'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Luas Lantai Total</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['luaslantai'];?>&nbsp;m&sup2;
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Luas Bangunan Total</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['luasbangunan'];?>&nbsp;m&sup2;
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Luas Lt 1</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['luaslantai1'];?>&nbsp;m&sup2;
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Luas Lt 2</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['luaslantai2'];?>&nbsp;m&sup2;
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Luas Lt 3</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['luaslantai3'];?>&nbsp;m&sup2;
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Luas Lt 4</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['luaslantai4'];?>&nbsp;m&sup2;
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Luas Lt 5</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['luaslantai5'];?>&nbsp;m&sup2;
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Luas Lt 6</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['luaslantai6'];?>&nbsp;m&sup2;
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Luas Lt 7</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['luaslantai7'];?>&nbsp;m&sup2;
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Luas Lt 8</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['luaslantai8'];?>&nbsp;m&sup2;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;III. PENGADAAN</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Cara Perolehan</td>
                        <td class="content">&nbsp;
                            <?php
                            $aCaraPerolehan = array('','Dibeli','Hibah','Dll');
                            echo $aCaraPerolehan[$rwgdg['caraperolehan']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Diperoleh Dari</td>
                        <td class="content">&nbsp;
                            <?php echo $rwgdg['diperolehdari'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kondisi Perolehan</td>
                        <td class="content">&nbsp;
                        <?php
                        $konbang = array('','Baik','Rusak Ringan','Rusak Berat','Tidak Berfungsi');
                        echo $konbang[$rwgdg['kondisiperolehan']];
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Harga</td>
                        <td class="content">&nbsp;<?php echo $rwgdg['hargasatuan'];?></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Dasar Harga</td>
                        <td class="content">&nbsp;
                            <?php
                            $aDasarHarga = array('','Pemborongan','Taksiran');
                            echo $aDasarHarga[$rwgdg['dasarharga']];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Mata Anggaran</td>
                        <td class="content">&nbsp;
                            <?php
                            echo $rwgdg['keterangan'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;No MA</td>
                        <td class="content">&nbsp;
                            <?php echo $rwgdg['manama'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;IV. PENGURUS BARANG</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama/Jabatan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwgdg['namapengurus'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Alamat</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['alamatpengurus'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;V. BAGIAN-BAGIAN LAIN/PERLENGKAPAN</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Catatan Perlengkapan</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['catperlengkapan'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Catatan Pengisi</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['catpengisi'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;DISETUJUI OLEH</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['namapetugas'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Jabatan</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['jabatanpetugas'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Tanggal</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['tgldisetujui'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;DIISI OLEH</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['namapetugas2'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Jabatan</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['jabatanpetugas2'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Tanggal</td>
                        <td class="content">&nbsp;
                        <?php echo $rwgdg['tgldiisi'];?>
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
                                .: Kartu Inventaris Barang : Gedung Dan Bangunan - Detail :.
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Unit Kerja </td>
                            <td width="504" colspan="2" class="content">
                                <input name="idunit" type="text" class="txtunedited" id="idbarang3" value="<?php echo $rwgdg["kodeunit"]; ?>" size="20" maxlength="15" readonly />
                            </td>
                        </tr>
                        <tr>
                            <td width="134" class="label">Kode Barang </td>
                            <td colspan="2" class="content">
                                <input name="idbarang" type="text" class="txtunedited" id="idbarang" value="<?php echo $rwgdg["kodebarang"]; ?>" size="20" maxlength="15" readonly />
                                <input name="noseri" type="text" class="txtunedited" id="noseri" value="<?php echo $rwgdg["noseri"]; ?>" size="10" maxlength="5" readonly />
                            </td>

                        </tr>
                        <tr>
                            <td class="label"> Nama Barang </td>
                            <td class="content">
                                <input name="namabarang" type="text" class="txtunedited" id="ukuran" value="<?php echo $rwgdg["namabarang"]; ?>" size="50" maxlength="50" readonly />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="SubHeaderBG">I. UNIT BARANG </td>
                        </tr>
                        <tr>
                            <td class="label">Jenis Bangunan</td>
                            <td class="content">
                                <select name="jenisbang" class="txt" id="jenisbang">
                                	<option>Pilih Jenis Bangunan</option>
                                    <option value="1" <?php if ($rwgdg["jenisbang"]==1) echo "selected"; ?>>1 - Rumah Tinggal</option>
                                    <option value="2" <?php if ($rwgdg["jenisbang"]==2) echo "selected"; ?>>2 - Rumah Sementara</option>
                                    <option value="3" <?php if ($rwgdg["jenisbang"]==3) echo "selected"; ?>>3 - Wisma</option>
                                    <option value="4" <?php if ($rwgdg["jenisbang"]==4) echo "selected"; ?>>4 - Asrama</option>
                                    <option value="5" <?php if ($rwgdg["jenisbang"]==5) echo "selected"; ?>>5 - Mess</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Tipe Bangunan </td>
                            <td class="content">
                                <select name="tipebang" class="txt" id="select2">
                                	<option>Pilih Tipe Bangunan</option>
                                    <option value="1" <?php if ($rwgdg["tipebang"]==1) echo "selected"; ?>>1 - A</option>
                                    <option value="2" <?php if ($rwgdg["tipebang"]==2) echo "selected"; ?>>2 - B</option>
                                    <option value="3" <?php if ($rwgdg["tipebang"]==3) echo "selected"; ?>>3 - C</option>
                                    <option value="4" <?php if ($rwgdg["tipebang"]==4) echo "selected"; ?>>4 - D</option>
                                    <option value="5" <?php if ($rwgdg["tipebang"]==5) echo "selected"; ?>>5 - E</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="label">Golongan</td>
                            <td class="content">
                                <select name="golbang" class="txt" id="golbang">
                                	<option>Pilih Golongan Bangunan</option>
                                    <option value="1" <?php if ($rwgdg["golbang"]==1) echo "selected"; ?>>1 - I</option>
                                    <option value="2" <?php if ($rwgdg["golbang"]==2) echo "selected"; ?>>2 - II</option>
                                    <option value="3" <?php if ($rwgdg["golbang"]==3) echo "selected"; ?>>3 - III</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Kelas</td>
                            <td class="content">
                                <select name="kelasbang" class="txt" id="select4">
                               		<option>Pilih Kelas Bangunan</option>
                                    <option value="1" <?php if ($rwgdg["kelasbang"]==1) echo "selected"; ?>>1 - I A</option>
                                    <option value="2" <?php if ($rwgdg["kelasbang"]==2) echo "selected"; ?>>2 - I</option>
                                    <option value="3" <?php if ($rwgdg["kelasbang"]==3) echo "selected"; ?>>3 - II</option>
                                    <option value="4" <?php if ($rwgdg["kelasbang"]==4) echo "selected"; ?>>4 - III</option>
                                    <option value="5" <?php if ($rwgdg["kelasbang"]==5) echo "selected"; ?>>5 - IV</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Kondisi Bangunan </td>
                            <td class="content">
                                <select name="keadaanalat" class="txt" id="keadaanalat">
                                	<option>Pilih Kondisi Bangunan</option>
                                    <option value="1" <?php if ($rwgdg["keadaanalat"]==1) echo "selected"; ?>>1 - Baik</option>
                                    <option value="2" <?php if ($rwgdg["keadaanalat"]==2) echo "selected"; ?>>2 - Rusak Ringan</option>
                                    <option value="3" <?php if ($rwgdg["keadaanalat"]==3) echo "selected"; ?>>3 - Rusak Berat</option>
                                    <option value="4" <?php if ($rwgdg["keadaanalat"]==4) echo "selected"; ?>>4 - Tidak Berfungsi</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Tahun Bangun </td>
                            <td class="content">
                                <input name="tahunbangun" type="text" class="txt" id="suratukur" value="<?php echo $rwgdg["tahunalat"]; ?>" size="10" maxlength="4" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Status Tanah </td>
                            <td class="content">
                                <select name="statushukum" class="txt" id="statushukum">
			                        <option>Pilih Status Tanah</option>
                                    <option value="1" <?php if ($rwgdg["statushukum"]==1) echo "selected" ?>>1 - Hak Guna Usaha</option>
                                    <option value="2" <?php if ($rwgdg["statushukum"]==2) echo "selected" ?>>2 - Hak Milik</option>
                                    <option value="3" <?php if ($rwgdg["statushukum"]==3) echo "selected" ?>>3 - Hak Guna Bangunan</option>
                                    <option value="4" <?php if ($rwgdg["statushukum"]==4) echo "selected" ?>>4 - Hak Pakai</option>
                                    <option value="5" <?php if ($rwgdg["statushukum"]==5) echo "selected" ?>>5 - Hak Sewa untuk Bangunan</option>
                                    <option value="6" <?php if ($rwgdg["statushukum"]==6) echo "selected" ?>>6 - Hak Membuka Tanah</option>
                                    <option value="7" <?php if ($rwgdg["statushukum"]==7) echo "selected" ?>>7 - Hak Sewa Tanah Pertanian</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">No Persil </td>
                            <td class="content">
                                <input name="nopersil" type="text" class="txt" id="alamat" value="<?php echo $rwgdg["nopersil"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Ijin Bang. No </td>
                            <td class="content">
                                <input name="ijinbangno" type="text" class="txt" id="nopersil" value="<?php echo $rwgdg["ijinbangno"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Ijin Bang. Tgl. </td>
                            <td class="content">
                                <input name="ijinbangtgl" type="text" class="txt" id="ijinbangtgl" value="<?php echo date("d-m-Y",strtotime($rwgdg["ijinbangtgl"])); ?>" size="20" maxlength="15" />
                                <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('ijinbangtgl'),depRange);" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Gambar No </td>
                            <td class="content">
                                <input name="gambarno" type="text" class="txt" id="suratlain" value="<?php echo $rwgdg["gambarno"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Gambar Macam </td>
                            <td class="content">
                                <input name="gambarmacam" type="text" class="txt" id="gambarno" value="<?php echo $rwgdg["gambarmacam"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Gambar Skala </td>
                            <td class="content">
                                <input name="gambarskala" type="text" class="txt" id="gambarno2" value="<?php echo $rwgdg["gambarskala"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Gambar Jumlah </td>
                            <td class="content">
                                <input name="gambarjumlah" type="text" class="txt" id="gambarno3" value="<?php echo $rwgdg["gambarjumlah"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td height="28" class="label">No KIB Tanah </td>
                            <td class="content">
                                <input name="nokibtanah" type="text" class="txt" id="ijinbangno" value="<?php echo $rwgdg["nokibtanah"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td height="28" class="label">Surat 1 </td>
                            <td class="content">
                                <input name="surat1" type="text" class="txt" id="nokibtanah" value="<?php echo $rwgdg["surat1"]; ?>" size="75" maxlength="100" />
                            </td>
                        </tr>
                        <tr>
                            <td height="28" class="label">Surat 2 </td>
                            <td class="content">
                                <input name="surat2" type="text" class="txt" id="surat1" value="<?php echo $rwgdg["surat2"]; ?>" size="75" maxlength="100" />
                            </td>
                        </tr>
                        <tr>
                            <td height="28" class="label">Surat 3 </td>
                            <td class="content">
                                <input name="surat3" type="text" class="txt" id="surat12" value="<?php echo $rwgdg["surat3"]; ?>" size="75" maxlength="100" />
                            </td>
                        </tr>
                        <tr>
                            <td height="28" class="label">Alamat</td>
                            <td class="content">
                                <input name="alamat" type="text" class="txt" id="surat13" value="<?php echo $rwgdg["alamat"]; ?>" size="75" maxlength="100" />
                            </td>
                        </tr>
                        <tr>
                            <td height="28" class="label">Kelurahan</td>
                            <td class="content">
                                <input name="kelurahan" type="text" class="txt" id="kelurahan" value="<?php echo $rwgdg["kelurahan"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td height="28" class="label">Kecamatan</td>
                            <td class="content">
                                <input name="kecamatan" type="text" class="txt" id="kecamatan" value="<?php echo $rwgdg["kecamatan"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td height="28" class="label">Kab/Kodya</td>
                            <td class="content">
                                <input name="kotamadya" type="text" class="txt" id="kotamadya" value="<?php echo $rwgdg["kotamadya"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">II. KONSTRUKSI</td>
                        </tr>
                        <tr>
                            <td class="label">Kategori</td>
                            <td class="content">
                                <select name="konskategori" class="txt" id="select5">
                                	<option>Pilih Kategori Konstruksi</option>
                                    <option value="1" <?php if ($rwgdg["konskategori"]==1) echo "selected"; ?>>1 - Permanen</option>
                                    <option value="2" <?php if ($rwgdg["konskategori"]==2) echo "selected"; ?>>2 - Semi Permanen</option>
                                    <option value="3" <?php if ($rwgdg["konskategori"]==3) echo "selected"; ?>>3 - Darurat</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Atap</td>
                            <td class="content">
                                <select name="konsatap" class="txt" id="select6">
                                	<option>Pilih Atap Konstruksi</option>
                                    <option value="1" <?php if ($rwgdg["konsatap"]==1) echo "selected"; ?>>1 - Beton</option>
                                    <option value="2" <?php if ($rwgdg["konsatap"]==2) echo "selected"; ?>>2 - Seng</option>
                                    <option value="3" <?php if ($rwgdg["konsatap"]==3) echo "selected"; ?>>3 - Asbes</option>
                                    <option value="4" <?php if ($rwgdg["konsatap"]==4) echo "selected"; ?>>4 - Sirap</option>
                                    <option value="5" <?php if ($rwgdg["konsatap"]==5) echo "selected"; ?>>5 - Genteng</option>
                                    <option value="6" <?php if ($rwgdg["konsatap"]==6) echo "selected"; ?>>6 - Lainnya</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Kusen</td>
                            <td class="content">
                                <select name="konskusen" class="txt" id="select7">
                                	<option>Pilih Kusen Konstruksi</option>
                                    <option value="1" <?php if ($rwgdg["konskusen"]==1) echo "selected"; ?>>1 - Kayu</option>
                                    <option value="2" <?php if ($rwgdg["konskusen"]==2) echo "selected"; ?>>2 - Alumunium</option>
                                    <option value="3" <?php if ($rwgdg["konskusen"]==3) echo "selected"; ?>>3 - Lainnya</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Rangka</td>
                            <td class="content">
                                <select name="konsrangka" class="txt" id="select13">
                                	<option>Pilih Rangka Konstruksi</option>
                                    <option value="1" <?php if ($rwgdg["konsrangka"]==1) echo "selected"; ?>>1 - Besi</option>
                                    <option value="2" <?php if ($rwgdg["konsrangka"]==2) echo "selected"; ?>>2 - Kayu Lapis</option>
                                    <option value="3" <?php if ($rwgdg["konsrangka"]==3) echo "selected"; ?>>3 - Beton</option>
                                    <option value="4" <?php if ($rwgdg["konsrangka"]==4) echo "selected"; ?>>4 - Lainnya</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Pondasi</td>
                            <td class="content">
                                <select name="konspondasi" class="txt" id="select14">
                                	<option>Pilih Pondasi Konstrusi</option>
                                    <option value="1"  <?php if ($rwgdg["konspondasi"]==1) echo "selected"; ?>>1 - Beton</option>
                                    <option value="2" <?php if ($rwgdg["konspondasi"]==2) echo "selected"; ?>>2 - Batu Kali</option>
                                    <option value="3" <?php if ($rwgdg["konspondasi"]==3) echo "selected"; ?>>3 - Tiang Pancang</option>
                                    <option value="4" <?php if ($rwgdg["konspondasi"]==4) echo "selected"; ?>>4 - Lainnya</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Dinding</td>
                            <td class="content">
                                <select name="konsdinding" class="txt" id="select15">
                                	<option>Pilih Dinding Konstruksi</option>
                                    <option value="1" <?php if ($rwgdg["konsdinding"]==1) echo "selected"; ?>>1 - Kayu</option>
                                    <option value="2" <?php if ($rwgdg["konsdinding"]==2) echo "selected"; ?>>2 - Tembok</option>
                                    <option value="3" <?php if ($rwgdg["konsdinding"]==3) echo "selected"; ?>>3 - Bambu</option>
                                    <option value="4" <?php if ($rwgdg["konsdinding"]==4) echo "selected"; ?>>4 - Lainnya</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Plafon</td>
                            <td class="content">
                                <select name="konsplafon" class="txt" id="select16">
                                	<option>Pilih Plavon Konstruksi</option>
                                    <option value="1" <?php if ($rwgdg["konsplafon"]==1) echo "selected"; ?>>1 - Beton</option>
                                    <option value="2" <?php if ($rwgdg["konsplafon"]==2) echo "selected"; ?>>2 - Kayu</option>
                                    <option value="3" <?php if ($rwgdg["konsplafon"]==3) echo "selected"; ?>>3 - Bambu</option>
                                    <option value="4" <?php if ($rwgdg["konsplafon"]==4) echo "selected"; ?>>4 - Asbes</option>
                                    <option value="5" <?php if ($rwgdg["konsplafon"]==5) echo "selected"; ?>>5 - Akustik</option>
                                    <option value="6" <?php if ($rwgdg["konsplafon"]==6) echo "selected"; ?>>6 - Lainnya</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Lantai</td>
                            <td class="content">
                                <select name="konslantai" class="txt" id="select17">
                                	<option>Pilih Lantai Konstruksi</option>
                                    <option value="1" <?php if ($rwgdg["konslantai"]==1) echo "selected"; ?>>1 - Tegel</option>
                                    <option value="2" <?php if ($rwgdg["konslantai"]==2) echo "selected"; ?>>2 - Flur</option>
                                    <option value="3" <?php if ($rwgdg["konslantai"]==3) echo "selected"; ?>>3 - Bambu</option>
                                    <option value="4" <?php if ($rwgdg["konslantai"]==4) echo "selected"; ?>>4 - Teraso</option>
                                    <option value="5" <?php if ($rwgdg["konslantai"]==5) echo "selected"; ?>>5 - Keramik</option>
                                    <option value="6" <?php if ($rwgdg["konslantai"]==6) echo "selected"; ?>>6 - Lainnya</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Jumlah Lantai</td>
                            <td class="content">
                                <input name="jumlahlantai" type="text" class="txt" id="jumlahlantai" value="<?php echo $rwgdg["jumlahlantai"]; ?>" size="10" maxlength="4" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Luas Lantai Total </td>
                            <td class="content">
                                <input name="luaslantai" type="text" class="txt" id="luaslantai" value="<?php echo $rwgdg["luaslantai"]; ?>" size="20" maxlength="10" /> m&sup2;
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Luas Bangunan Total</td>
                            <td class="content">
                                <input name="luasbangunan" type="text" class="txt" id="luasbangunan" value="<?php echo $rwgdg["luasbangunan"]; ?>" size="20" maxlength="10" /> m&sup2;
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Luas Lt 1 </td>
                            <td class="content">
                                <input name="luaslantai1" type="text" class="txt" id="luaslantai1" value="<?php echo $rwgdg["luaslantai1"]; ?>" size="20" maxlength="10" /> m&sup2;
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Luas Lt 2 </td>
                            <td class="content">
                                <input name="luaslantai2" type="text" class="txt" id="luaslantai2" value="<?php echo $rwgdg["luaslantai2"]; ?>" size="20" maxlength="10" /> m&sup2;
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Luas Lt 3 </td>
                            <td class="content">
                                <input name="luaslantai3" type="text" class="txt" id="luaslantai3" value="<?php echo $rwgdg["luaslantai3"]; ?>" size="20" maxlength="10" /> m&sup2;
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Luas Lt 4 </td>
                            <td class="content">
                                <input name="luaslantai4" type="text" class="txt" id="luaslantai4" value="<?php echo $rwgdg["luaslantai4"]; ?>" size="20" maxlength="10" /> m&sup2;
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Luas Lt 5 </td>
                            <td class="content">
                                <input name="luaslantai5" type="text" class="txt" id="luaslantai5" value="<?php echo $rwgdg["luaslantai5"]; ?>" size="20" maxlength="10" /> m&sup2;
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Luas Lt 6 </td>
                            <td class="content">
                                <input name="luaslantai6" type="text" class="txt" id="luaslantai6" value="<?php echo $rwgdg["luaslantai6"]; ?>" size="20" maxlength="10" /> m&sup2;
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Luas Lt 7 </td>
                            <td class="content">
                                <input name="luaslantai7" type="text" class="txt" id="luaslantai7" value="<?php echo $rwgdg["luaslantai7"]; ?>" size="20" maxlength="10" /> m&sup2;
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Luas Lt 8 </td>
                            <td class="content">
                                <input name="luaslantai8" type="text" class="txt" id="luaslantai8" value="<?php echo $rwgdg["luaslantai8"]; ?>" size="20" maxlength="10" /> m&sup2;
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">II. PENGADAAN </td>
                        </tr>
                        <tr>
                            <td class="label">Cara Perolehan</td>
                            <td class="content">
                                <select name="caraperolehan" class="txt" id="select8">
                                	<option>Pilih Cara Perolehan</option>
                                    <option value="1" <?php if ($rwgdg["caraperolehan"]==1) echo "selected" ?>>1 - dibeli</option>
                                    <option value="2" <?php if ($rwgdg["caraperolehan"]==2) echo "selected" ?>>2 - hibah</option>
                                    <option value="3" <?php if ($rwgdg["caraperolehan"]==3) echo "selected" ?>>3 - dll</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Diperoleh Dari </td>
                            <td class="content">
                                <input name="diperolehdari" type="text" class="txt" id="gambarjumlah" value="<?php echo $rwgdg["diperolehdari"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>

                        <tr>
                            <td class="label">Kondisi Perolehan </td>
                            <td class="content">
                                <select name="kondisiperolehan" class="txt" id="select9">
                                	<option>Pilih Kondisi Perolehan</option>
                                    <option value="1" <?php if ($rwgdg["kondisiperolehan"]==1) echo "selected" ?>>1 - Baik</option>
                                    <option value="2" <?php if ($rwgdg["kondisiperolehan"]==2) echo "selected" ?>>2 - Rusak Ringan</option>
                                    <option value="3" <?php if ($rwgdg["kondisiperolehan"]==3) echo "selected" ?>>3 - Rusak Berat</option>
                                    <option value="4" <?php if ($rwgdg["kondisiperolehan"]==4) echo "selected" ?>>4 - Tidak Berfungsi</option>
                                </select>
                            </td>
                        </tr>
                        <!--tr>
                          <td class="label">Tahun Perolehan </td>
                          <td class="content"><input name="tahunperolehan" type="text" class="txt" id="tahunperolehan" value="<?php echo $rwgdg["tahunperolehan"]; ?>" size="10" maxlength="4">
                            <font color="#666666"><em>(yyyy)</em></font></td>
                        </tr-->
                        <tr>
                            <td class="label">Harga</td>
                            <td class="content">
                                <input name="hargasatuan" type="text" class="txt" id="hargasatuan" value="<?php echo $rwgdg["hargasatuan"]; ?>" size="20" maxlength="15" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Dasar Harga </td>
                            <td class="content">
                                <select name="dasarharga" class="txt" id="select10">
                                	<option>Pilih Dasar Harga</option>
                                    <option value="1" <?php if ($rwgdg["dasarharga"]==1) echo "selected" ?>>1 - Pemborongan</option>
                                    <option value="2" <?php if ($rwgdg["dasarharga"]==2) echo "selected" ?>>2 - Taksiran</option>
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
                                        echo "<option value='".$row['idsumberdana']."'";
                                        if($rwgdg['idsumberdana'] == $row['idsumberdana']){
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
                                <input name="manama" type="text" class="txt" id="manama" value="<?php echo $rwgdg["manama"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="SubHeaderBG">III. PENGURUS BARANG </td>
                        </tr>
                        <tr>
                            <td class="label">Nama / Jabatan </td>
                            <td class="content">
                                <input name="namapengurus" type="text" class="txt" id="namapengurus" value="<?php echo $rwgdg["namapengurus"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Alamat</td>
                            <td class="content">
                                <input name="alamatpengurus" type="text" class="txt" id="alamatpengurus" value="<?php echo $rwgdg["alamatpengurus"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">IV. BAGIAN-BAGIAN LAIN/PERLENGKAPAN </td>
                        </tr>
                        <tr>
                            <td class="label">Catatan Perlengkapan </td>
                            <td class="content">
                                <textarea class="txt" name="catperlengkapan" cols="60" rows="3" id="catperlengkapan"><?php echo $rwgdg["catperlengkapan"]; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Catatan Pengisi </td>
                            <td class="content">
                                <textarea class="txt" name="catpengisi" cols="60" rows="3" id="catpengisi"><?php echo $rwgdg["catpengisi"]; ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" class="header2">DISETUJUI OLEH</td>
                        </tr>
                        <tr>
                            <td class="label">Nama</td>
                            <td class="content">
                                <input name="namapetugas" type="text" class="txt" id="namapetugas" value="<?php echo $rwgdg["namapetugas"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Jabatan</td>
                            <td class="content">
                                <input name="jabatanpetugas" type="text" class="txt" id="jabatanpetugas" value="<?php echo $rwgdg["jabatanpetugas"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Tanggal</td>
                            <td class="content">
                                <input name="tgldisetujui" type="text" class="txt" id="tgldisetujui" readonly value="<?php echo date("d-m-Y",strtotime($rwgdg["tgldisetujui"])); ?>" size="20" maxlength="15" />
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
                                <input name="namapetugas2" type="text" class="txt" id="namapetugas2" value="<?php echo $rwgdg["namapetugas2"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Jabatan</td>
                            <td class="content">
                                <input name="jabatanpetugas2" type="text" class="txt" id="jabatanpetugas2" value="<?php echo $rwgdg["jabatanpetugas2"]; ?>" size="50" maxlength="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Tanggal</td>
                            <td class="content">
                                <input name="tgldiisi" type="text" class="txt" id="tgldiisi" readonly value="<?php echo date("d-m-Y",strtotime($rwgdg["tgldiisi"])); ?>" size="20" maxlength="15" />
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
        </div>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
                    <div><img src="../images/foot.gif" width="1000" height="45" /></div>
            </td>

  </tr>
</table>
            </div>
    </body>
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
                location='gedung.php';
            }else{
                location='<?php echo $_REQUEST['from']."?unit=".$_REQUEST['unit']."&lokasi=".$_REQUEST['lokasi']."&namaunit=".$_REQUEST['namaunit']."&namalokasi=".$_REQUEST['namalokasi']."&baris=".$_REQUEST['baris'];?>';
            }
        }
    </script>
</html>

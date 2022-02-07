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
        $jenistanah = $_POST["jenistanah"];
        $peruntukan = $_POST["peruntukan"];
        $luastanah = $_POST["luastanah"];
        $alamat = $_POST["alamat"];
        $statushukum = $_POST["statushukum"];
        $suratukur = $_POST["suratukur"];
        $suratgirik = $_POST["suratgirik"];
        $suratsertifikat = $_POST["suratsertifikat"];
        $sertifikattgl = tglSQL($_POST["sertifikattgl"]);
        $suratakte = $_POST["suratakte"];
        $suratskpt = $_POST["suratskpt"];
        $suratlain = $_POST["suratlain"];
        $gambarno = $_POST["gambarno"];
        $gambarmacam = $_POST["gambarmacam"];
        $gambarskala = $_POST["gambarskala"];
        $gambarjumlah = $_POST["gambarjumlah"];
        $macampersil = $_POST["macampersil"];
        $macampemanfaatan = $_POST["macampemanfaatan"];
        $macamnonpersil = $_POST["macamnonpersil"];
        $macamjenisnonpersil = $_POST["macamjenisnonpersil"];
        $caraperolehan = $_POST["caraperolehan"];
        $diperolehdari = $_POST["diperolehdari"];
        $tglperolehan = tglSQL($_POST["tglperolehan"]);
        $hargasatuan = $_POST["hargasatuan"];
        $dasarharga = $_POST["dasarharga"];
        $idsumberdana = $_POST["idsumberdana"];
        $manama = $_POST["manama"];
        $mano = $_POST["mano"];
        $namapengurus = $_POST["namapengurus"];
        $alamatpengurus = $_POST["alamatpengurus"];
        $catperlengkapan = $_POST["catperlengkapan"];
        $catpengisi = $_POST["catpengisi"];
        $namapetugas = $_POST["namapetugas"];
        $jabatanpetugas = $_POST["jabatanpetugas"];
        $tgldisetujui = tglSQL($_POST["tgldisetujui"]);
        $namapetugas2 = $_POST["namapetugas2"];
        $jabatanpetugas2 = $_POST["jabatanpetugas2"];
        $tgldiisi = tglSQL($_POST["tgldiisi"]);

        $query = "update as_kib set jenistanah = '$jenistanah', peruntukan = '$peruntukan', luastanah = '$luastanah', alamat = '$alamat'
                , statushukum = '$statushukum', suratukur = '$suratukur', suratgirik = '$suratgirik', suratsertifikat = '$suratsertifikat'
                , sertifikattgl = '$sertifikattgl', suratakte = '$suratakte', suratskpt = '$suratskpt', suratlain = '$suratlain', gambarno = '$gambarno'
                , gambarmacam = '$gambarmacam', gambarskala = '$gambarskala', gambarjumlah = '$gambarjumlah', macampersil = '$macampersil'
                , macampemanfaatan = '$macampemanfaatan', macamnonpersil = '$macamnonpersil', macamjenisnonpersil = '$macamjenisnonpersil'
                , caraperolehan = '$caraperolehan', diperolehdari = '$diperolehdari', tglperolehan = '$tglperolehan', dasarharga = '$dasarharga'
                , hargasatuan = '$hargasatuan', idsumberdana = '$idsumberdana', manama = '$manama', mano = '$mano', namapengurus = '$namapengurus'
                , alamatpengurus = '$alamatpengurus', catpengisi = '$catpengisi', namapetugas = '$namapetugas', jabatanpetugas = '$jabatanpetugas'
                , tgldisetujui = '$tgldisetujui', namapetugas2 = '$namapetugas2', jabatanpetugas2 = '$jabatanpetugas2', tgldiisi = '$tgldiisi'
                , t_userid = '$t_userid', t_updatetime = '$t_updatetime', t_ipaddress = '$t_ipaddress'
                where id_kib = $id_kib_seri[0]";

//        $query = "insert into jenistanah,peruntukan,luastanah,alamat,statushukum,suratukur,suratgirik,suratsertifikat,sertifikattgl,suratakte,suratskpt,suratlain,gambarno,gambarmacam,gambarskala,";
//        $query .= "gambarjumlah,macampersil,macampemanfaatan,macamnonpersil,macamjenisnonpersil,caraperolehan,diperolehdari,tglperolehan,";
//        $query .= "dasarharga,hargasatuan,idsumberdana,manama,mano,namapengurus,alamatpengurus,";
//        $query .= "catpengisi,namapetugas,jabatanpetugas,tgldisetujui,namapetugas2,jabatanpetugas2,tgldiisi,t_userid,t_updatetime,t_ipaddress from in_kib where id_kib=$r_idkib";
        $rs = mysql_query($query);
        $res = mysql_affected_rows();
        $err = mysql_error();
        if(!isset($err) || $err == '') {
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
        <title>KIB Tanah</title>
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

            $sqltnh = "SELECT b.kodebarang,b.namabarang,u.namaunit,u.kodeunit,k.id_kib,noseri,
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
                    WHERE k.id_kib = '".$id_kib_seri[0]."' and s.idseri = '".$id_kib_seri[1]."'";
            $dttnh = mysql_query($sqltnh);
            $rwtnh = mysql_fetch_array($dttnh);
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
                        <button class="Enabledbutton" id="backbutton" onClick="backTo()" title="Back" style="cursor:pointer">
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
                        <button class="Disabledbutton" id="undobutton" disabled onClick="location='detailTanah.php<?php echo $par?>'" title="Cancel / Refresh" style="cursor:pointer">
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
                        <td colspan="2" class="header">.: Kartu Inventaris Barang : Tanah - Detail :.</td>
                    </tr>
                    <tr>
                        <td width="40%" class="label">&nbsp;Unit Kerja</td>
                        <td width="60%" class="content">&nbsp;
                            <?php echo $rwtnh['namaunit'];?>&nbsp;(<?php echo $rwtnh['kodeunit']; ?>)                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kode Barang - Seri</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['kodebarang'].' - '.$rwtnh['noseri'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama Barang</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['namabarang'];?>                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;I. UNIT BARANG</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Jenis Tanah</td>
                        <td class="content">&nbsp;
                        <?php
                            $aJenisTanah = array('','Persil','Non Persil');
							
                            echo $aJenisTanah[$rwtnh['jenistanah']];
                            ?></td>
                  </tr>
                    <tr>
                        <td class="label">&nbsp;Peruntukkan</td>
                        <td class="content">&nbsp;
                            <?php
                            $aPeruntukkan = array('','Kantor','Gudang','Bengkel','Laboratorium','Rumah','Mess','Gd Pendidikan','Poliklinik','Jalan','Lapangan','Lainnya');
                            echo $aPeruntukkan[$rwtnh['peruntukan']];
                            ?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Luas Tanah</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['luastanah'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kondisi Tanah</td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rwtnh["keadaanalat"]) {
                                case 1 : echo "Ada Bangunan";
                                    break;
                                case 2 : echo "Siap Dibangun";
                                    break;
                                case 3 : echo "Belum Dibangun";
                                    break;
                                case 4 : echo "Tidak Dapat Dibangun";
                                    break;
                            }
                            ?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Alamat/Lokasi</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['alamat'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Status Hukum</td>
                        <td class="content">&nbsp;
                            <?php
                            $aStatusHukum = array('','Hak Guna Usaha','Hak Milik','Hak Guna Bangunan','Hak Pakai','Hak Sewa untuk Bangunan','Hak Membuka Tanah','Hak Sewa Tanah Pertanian');
                            echo $aStatusHukum[$rwtnh['statushukum']];
                            ?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Surat Ukur No.</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['suratukur'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Surat Girik No</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['suratgirik'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Surat Sertifikat No.</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['suratsertifikat'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Surat Sertifikat Tgl.</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['sertifikattgl'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Surat Akte No.</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['suratakte'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;SKPT No.</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['suratskpt'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Surat Lain</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['suratlain'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Gambar No</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['gambarno'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Gambar Macam</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['gambarmacam'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Gambar Skala</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['gambarskala'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Gambar Jumlah</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['gambarjumlah'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Macam Persil</td>
                        <td class="content">&nbsp;
                            <?php
                            $aMacamPersil = array('','Kelas I','Kelas II','Kelas III','Kelas IV');
                            echo $aMacamPersil[$rwtnh['macampersil']];
                            ?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Pemanfaatan</td>
                        <td class="content">&nbsp;
                            <?php
                            $aPemanfaatan = array('','Rumah','Kantor','Lainnya');
                            echo $aPemanfaatan[$rwtnh['macampemanfaatan']];
                            ?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Macam Non Persil</td>
                        <td class="content">&nbsp;
                            <?php
                            $aMacamNonPersil = array('','Kelas I','Kelas II','Kelas III','Kelas IV');
                            echo $aMacamNonPersil[$rwtnh['macamnonpersil']];
                            ?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Jenis Kelas</td>
                        <td class="content">&nbsp;
                            <?php
                            $aJnsKls = array('','Tanah Kering','Tanah Basah');
                            echo $aJnsKls[$rwtnh['macamjenisnonpersil']];
                            ?>                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;II. PENGADAAN</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Cara Perolehan</td>
                        <td class="content">&nbsp;
                            <?php
                            $aCrPerolehan = array('','Pembelian','Hibah','Pembebasan','Sebelum 1945','Tukar Menukar','Cara Lain');
                            echo $aCrPerolehan[$rwtnh['caraperolehan']];
                            ?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Diperoleh Dari</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['diperolehdari'];?></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kondisi Perolehan</td>
                        <td class="content">&nbsp;
                            <?php
                            $konper = array('','Ada Bangunan','Siap Dibangun','Belum Dibangun','Tidak dapat dibangun');
                            echo $konper[$rwtnh['kondisiperolehan']];
                            ?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Tgl Perolehan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['tglperolehan'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Harga</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['hargasatuan'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Dasar Harga</td>
                        <td class="content">&nbsp;
                            <?php
                            $aDsrHrg = array('','Pemborongan','Taksiran');
                            echo $aDsrHrg[$rwtnh['dasarharga']];
                            ?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Mata Anggaran</td>
                        <td class="content">&nbsp;
                            <?php
                            echo $rwtnh['keterangan'];
                            ?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;No MA</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['manama'];?>                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;III. PENGURUS BARANG</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama/Jabatan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['namapengurus'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Alamat</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['alamatpengurus'];?>                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;IV. BAGIAN-BAGIAN LAIN/PERLENGKAPAN</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Catatan Perlengkapan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['catperlengkapan'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Catatan Pengisi</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['catpengisi'];?>                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;DISETUJUI OLEH</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['namapetugas'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Jabatan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['jabatanpetugas'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Tanggal</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['tgldisetujui'];?>                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;DIISI OLEH</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['namapetugas2'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Jabatan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['jabatanpetugas2'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Tanggal</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['tgldiisi'];?>                        </td>
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
                                .: Kartu Inventaris Barang : Tanah - Detail :.                            </td>
                        </tr>
                        <tr>
                            <td class="label">Unit Kerja </td>
                            <td width="504" colspan="2" class="content">
                                <input name="kodeunit" type="text" class="txtunedited" id="kodeunit" value="<?php echo $rwtnh["kodeunit"]; ?>" size="20" maxlength="15" readonly />                            </td>
                        </tr>
                        <tr>
                            <td width="134" class="label">Kode Barang </td>
                            <td colspan="2" class="content">
                                <input name="kodebarang" type="text" class="txtunedited" id="kodebarang" value="<?php echo $rwtnh["kodebarang"]; ?>" size="20" maxlength="15" readonly />
                                <input name="noseri" type="text" class="txtunedited" id="noseri" value="<?php echo $rwtnh["noseri"]; ?>" size="10" maxlength="5" readonly />                            </td>
                        </tr>
                        <tr>
                            <td class="label"> Nama Barang </td>
                            <td class="content">
                                <input name="namabarang" type="text" class="txtunedited" id="namabarang" value="<?php echo $rwtnh["namabarang"]; ?>" size="50" maxlength="50" readonly />                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">I. UNIT BARANG </td>
                        </tr>
                        <tr>
                            <td class="label">Jenis Tanah </td>
                            <td class="content"><select name="jenistanah" class="txt" id="jenistanah">
                              <option value=''>Pilih Jenis Tanah</option>
                              <option value="1" <?php if ($rwtnh["jenistanah"]==1) echo "selected" ?>>1 - Persil</option>
                              <option value="2" <?php if ($rwtnh["jenistanah"]==2) echo "selected" ?>>2 - Non Persil</option>
                            </select></td>
                      </tr>
                        <tr>
                            <td class="label">Peruntukkan</td>
                            <td class="content">
                                <select name="peruntukan" class="txt" id="select2">
                                <option value=''>Pilih Pruntukan</option>
                                    <option value="1" <?php if ($rwtnh["peruntukan"]==1) echo "selected" ?>>1 - Kantor</option>
                                    <option value="2" <?php if ($rwtnh["peruntukan"]==2) echo "selected" ?>>2 - Gudang</option>
                                    <option value="3" <?php if ($rwtnh["peruntukan"]==3) echo "selected" ?>>3 - Bengkel</option>
                                    <option value="4" <?php if ($rwtnh["peruntukan"]==4) echo "selected" ?>>4 - Laboratorium</option>
                                    <option value="5" <?php if ($rwtnh["peruntukan"]==5) echo "selected" ?>>5 - Rumah</option>
                                    <option value="6" <?php if ($rwtnh["peruntukan"]==6) echo "selected" ?>>6 - Mess</option>
                                    <option value="7" <?php if ($rwtnh["peruntukan"]==7) echo "selected" ?>>7 - Gd Pendidikan</option>
                                    <option value="8" <?php if ($rwtnh["peruntukan"]==8) echo "selected" ?>>8 - Poliklinik</option>
                                    <option value="9" <?php if ($rwtnh["peruntukan"]==9) echo "selected" ?>>9 - Jalan</option>
                                    <option value="10" <?php if ($rwtnh["peruntukan"]==10) echo "selected" ?>>10 - Lapangan</option>
                                    <option value="11" <?php if ($rwtnh["peruntukan"]==11) echo "selected" ?>>11 - Lainnya</option>
                                </select>                            </td>
                        </tr>
                        <tr>
                            <td class="label">Luas Tanah </td>
                            <td class="content">
                                <input name="luastanah" type="text" class="txt" id="luastanah" value="<?php echo $rwtnh["luastanah"]; ?>" size="10" maxlength="6" /> m2                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Kondisi Tanah </td>
                            <td class="content">
                                <select name="keadaanalat" class="txt" id="keadaanalat">
                                <option value=''>Pilih Kondisi Tanah</option>
                                    <option value="1" <?php if ($rwtnh["keadaanalat"]==1) echo "selected" ?>>1 - Ada Bangunan</option>
                                    <option value="2" <?php if ($rwtnh["keadaanalat"]==2) echo "selected" ?>>2 - Siap Dibangun</option>
                                    <option value="3" <?php if ($rwtnh["keadaanalat"]==3) echo "selected" ?>>3 - Belum Dibangun</option>
                                    <option value="4" <?php if ($rwtnh["keadaanalat"]==4) echo "selected" ?>>4 - Tidak Dapat Dibangun</option>
                                </select>                            </td>
                        </tr>
                        <tr>
                            <td class="label">Alamat / Lokasi </td>
                            <td class="content">
                                <input name="alamat" type="text" class="txt" id="namabarang3" value="<?php echo $rwtnh["alamat"]; ?>" size="75" maxlength="100" />                            </td>
                        </tr>
                        <tr>
                            <td class="label">Status Hukum </td>
                            <td class="content">
                                <select name="statushukum" class="txt" id="select3">
                                <option value=''>Pilih Status Hukum</option>
                                    <option value="1" <?php if ($rwtnh["statushukum"]==1) echo "selected" ?>>1 - Hak Guna Usaha</option>
                                    <option value="2" <?php if ($rwtnh["statushukum"]==2) echo "selected" ?>>2 - Hak Milik</option>
                                    <option value="3" <?php if ($rwtnh["statushukum"]==3) echo "selected" ?>>3 - Hak Guna Bangunan</option>
                                    <option value="4" <?php if ($rwtnh["statushukum"]==4) echo "selected" ?>>4 - Hak Pakai</option>
                                    <option value="5" <?php if ($rwtnh["statushukum"]==5) echo "selected" ?>>5 - Hak Sewa untuk Bangunan</option>
                                    <option value="6" <?php if ($rwtnh["statushukum"]==6) echo "selected" ?>>6 - Hak Membuka Tanah</option>
                                    <option value="7" <?php if ($rwtnh["statushukum"]==7) echo "selected" ?>>7 - Hak Sewa Tanah Pertanian</option>
                                </select>                            </td>
                        </tr>
                        <tr>
                            <td class="label">Surat Ukur No. </td>
                            <td class="content">
                                <input name="suratukur" type="text" class="txt" id="alamat" value="<?php echo $rwtnh["suratukur"]; ?>" size="75" maxlength="100" />                            </td>
                        </tr>
                        <tr>
                            <td class="label">Surat Girik No </td>
                            <td class="content">
                                <input name="suratgirik" type="text" class="txt" id="alamat2" value="<?php echo $rwtnh["suratgirik"]; ?>" size="75" maxlength="100" />                            </td>
                        </tr>
                        <tr>
                            <td class="label">Surat Sertifikat No. </td>
                            <td class="content">
                                <input name="suratsertifikat" type="text" class="txt" id="alamat3" value="<?php echo $rwtnh["suratsertifikat"]; ?>" size="75" maxlength="100" />                            </td>
                        </tr>
                        <tr>
                            <td class="label">Surat Sertifikat Tgl. </td>
                            <td class="content">
                                <input name="sertifikattgl" type="text" class="txt" readonly id="sertifikattgl" value="<?php echo date("d-m-Y",strtotime($rwtnh["sertifikattgl"])); ?>" size="20" maxlength="15" />
                                <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('sertifikattgl'),depRange);" />
                                <font color="#666666"><em>(dd-mm-yyyy)</em></font>                            </td>
                        </tr>
                        <tr>
                            <td class="label">Surat Akte No. </td>
                            <td class="content">
                                <input name="suratakte" type="text" class="txt" id="alamat4" value="<?php echo $rwtnh["suratakte"]; ?>" size="75" maxlength="100" />                            </td>
                        </tr>
                        <tr>
                            <td class="label">SKPT No. </td>
                            <td class="content">
                                <input name="suratskpt" type="text" class="txt" id="alamat5" value="<?php echo $rwtnh["suratskpt"]; ?>" size="75" maxlength="100" />                            </td>
                        </tr>
                        <tr>
                            <td class="label">Surat Lain </td>
                            <td class="content">
                                <input name="suratlain" type="text" class="txt" id="alamat6" value="<?php echo $rwtnh["suratlain"]; ?>" size="75" maxlength="100" />                            </td>
                        </tr>
                        <tr>
                            <td class="label">Gambar No </td>
                            <td class="content">
                                <input name="gambarno" type="text" class="txt" id="suratlain" value="<?php echo $rwtnh["gambarno"]; ?>" size="50" maxlength="50" />                            </td>
                        </tr>
                        <tr>
                            <td class="label">Gambar Macam </td>
                            <td class="content">
                                <input name="gambarmacam" type="text" class="txt" id="gambarno" value="<?php echo $rwtnh["gambarmacam"]; ?>" size="50" maxlength="50" />                            </td>
                        </tr>
                        <tr>
                            <td class="label">Gambar Skala </td>
                            <td class="content">
                                <input name="gambarskala" type="text" class="txt" id="gambarno2" value="<?php echo $rwtnh["gambarskala"]; ?>" size="50" maxlength="50" />                            </td>
                        </tr>
                        <tr>
                            <td class="label">Gambar Jumlah </td>
                            <td class="content">
                                <input name="gambarjumlah" type="text" class="txt" id="gambarno3" value="<?php echo $rwtnh["gambarjumlah"]; ?>" size="50" maxlength="50" />                            </td>
                        </tr>
                        <tr>
                            <td height="28" class="label">Macam Persil </td>
                            <td class="content">
                                <select name="macampersil" class="txt" id="macampersil">
                                <option value=''>Pilih Macam Persil</option>
                                    <option value="1" <?php if ($rwtnh["macampersil"]==1) echo "selected" ?>>Kelas I</option>
                                    <option value="2" <?php if ($rwtnh["macampersil"]==2) echo "selected" ?>>Kelas II</option>
                                    <option value="3" <?php if ($rwtnh["macampersil"]==3) echo "selected" ?>>Kelas III</option>
                                    <option value="4" <?php if ($rwtnh["macampersil"]==4) echo "selected" ?>>Kelas IV</option>
                                </select>                            </td>
                        </tr>
                        <tr>
                            <td class="label">Pemanfaatan</td>
                            <td class="content">
                                <select name="macampemanfaatan" class="txt" id="select4">
                                <option value=''>Pilih Pemanfaatan</option>
                                    <option value="1" <?php if ($rwtnh["macampemanfaatan"]==1) echo "selected" ?>>1 - Rumah</option>
                                    <option value="2" <?php if ($rwtnh["macampemanfaatan"]==2) echo "selected" ?>>2 - Kantor</option>
                                    <option value="3" <?php if ($rwtnh["macampemanfaatan"]==3) echo "selected" ?>>3 - Lainnya</option>
                                </select>                            </td>
                        </tr>
                        <tr>
                            <td class="label">Macam Non Persil</td>
                            <td class="content">
                                <select name="macamnonpersil" class="txt" id="select7">
                                <option value=''>Pilih Macam Non Persil</option>
                                    <option value="1" <?php if ($rwtnh["macamnonpersil"]==1) echo "selected" ?>>Kelas I</option>
                                    <option value="2" <?php if ($rwtnh["macamnonpersil"]==2) echo "selected" ?>>Kelas II</option>
                                    <option value="3" <?php if ($rwtnh["macamnonpersil"]==3) echo "selected" ?>>Kelas III</option>
                                    <option value="4" <?php if ($rwtnh["macamnonpersil"]==4) echo "selected" ?>>Kelas IV</option>
                                </select>                            </td>
                        </tr>
                        <tr>
                            <td class="label">Jenis Kelas </td>
                            <td class="content">
                                <select name="macamjenisnonpersil" class="txt" id="select6">
                                <option value=''>Pilih Jenis Kelas</option>
                                    <option value="1" <?php if ($rwtnh["macamjenisnonpersil"]==1) echo "selected" ?>>1 - Tanah Kering</option>
                                    <option value="2" <?php if ($rwtnh["macamjenisnonpersil"]==2) echo "selected" ?>>2 - Tanah Basah</option>
                                </select>                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">II. PENGADAAN </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Cara Perolehan</td>
                            <td class="content">
                                <select name="caraperolehan" class="txt" id="select8">
                                <option value=''>Pilih Cara Perolehan</option>
                                    <option value="1" <?php if ($rwtnh["caraperolehan"]==1) echo "selected" ?>>1 - Pembelian</option>
                                    <option value="2" <?php if ($rwtnh["caraperolehan"]==2) echo "selected" ?>>2 - Hibah</option>
                                    <option value="3" <?php if ($rwtnh["caraperolehan"]==3) echo "selected" ?>>3 - Pembebasan</option>
                                    <option value="4" <?php if ($rwtnh["caraperolehan"]==4) echo "selected" ?>>4 - Sebelum 1945</option>
                                    <option value="5" <?php if ($rwtnh["caraperolehan"]==5) echo "selected" ?>>5 - Tukar Menukar</option>
                                    <option value="6" <?php if ($rwtnh["caraperolehan"]==6) echo "selected" ?>>6 - Cara Lain</option>
                                </select>                            </td>
                        </tr>
                        <tr>
                            <td class="label">Diperoleh Dari </td>
                            <td class="content">
                                <input name="diperolehdari" type="text" class="txt" id="gambarjumlah" value="<?php echo $rwtnh["diperolehdari"]; ?>" size="50" maxlength="50" />                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Kondisi Perolehan </td>
                            <td class="content">
                                <select name="kondisiperolehan" class="txt" id="select9">
                                <option value=''>Pilih Kondisi Perolehan</option>
                                    <option value="1" <?php if ($rwtnh["kondisiperolehan"]==1) echo "selected" ?>>1 - Ada Bangunan</option>
                                    <option value="2" <?php if ($rwtnh["kondisiperolehan"]==2) echo "selected" ?>>2 - Siap Dibangun</option>
                                    <option value="3" <?php if ($rwtnh["kondisiperolehan"]==3) echo "selected" ?>>3 - Belum Dibangun</option>
                                    <option value="4" <?php if ($rwtnh["kondisiperolehan"]==4) echo "selected" ?>>4 - Tidak dapat dibangun</option>
                                </select>                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Tgl Perolehan </td>
                            <td class="content">
                                <input name="tglperolehan" type="text" class="txt" readonly id="diperolehdari" value="<?php echo date("d-m-Y",strtotime($rwtnh["tglperolehan"])); ?>" size="20" maxlength="15" />
                                <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('diperolehdari'),depRange);" />
                                <font color="#666666"><em>(dd-mm-yyyy)</em></font>                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Harga</td>
                            <td class="content">
                                <input name="hargasatuan" type="text" class="txt" id="hargasatuan" value="<?php echo $rwtnh["hargasatuan"]; ?>" size="20" maxlength="15" />                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Dasar Harga </td>
                            <td class="content">
                                <select name="dasarharga" class="txt" id="select10">
                                <option value=''>Pilih Dasar Harga</option>
                                    <option value="1" <?php if ($rwtnh["dasarharga"]==1) echo "selected" ?>>1 - Pemborongan</option>
                                    <option value="2" <?php if ($rwtnh["dasarharga"]==2) echo "selected" ?>>2 - Taksiran</option>
                                </select>                            </td>
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
                                </select>                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">No MA </td>
                            <td class="content">
                                <input name="manama" type="text" class="txt" id="manama" value="<?php echo $rwtnh["manama"]; ?>" size="50" maxlength="50" />                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">III. PENGURUS BARANG </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Nama / Jabatan </td>
                            <td class="content">
                                <input name="namapengurus" type="text" class="txt" id="namapengurus" value="<?php echo $rwtnh["namapengurus"]; ?>" size="50" maxlength="50" />                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Alamat</td>
                            <td class="content">
                                <input name="alamatpengurus" type="text" class="txt" id="alamatpengurus" value="<?php echo $rwtnh["alamatpengurus"]; ?>" size="50" maxlength="50" />                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">IV. BAGIAN-BAGIAN LAIN/PERLENGKAPAN </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Catatan Perlengkapan </td>
                            <td class="content">
                                <textarea name="catperlengkapan" cols="60" class="txt" rows="3" id="catperlengkapan"><?php echo $rwtnh["catperlengkapan"]; ?></textarea>                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Catatan Pengisi </td>
                            <td class="content">
                                <textarea name="catpengisi" cols="60" rows="3" class="txt" id="catpengisi"><?php echo $rwtnh["catpengisi"]; ?></textarea>                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" class="header2">DISETUJUI OLEH </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Nama</td>
                            <td class="content">
                                <input name="namapetugas" type="text" class="txt" id="namapetugas" value="<?php echo $rwtnh["namapetugas"]; ?>" size="50" maxlength="50" />                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Jabatan</td>
                            <td class="content">
                                <input name="jabatanpetugas" type="text" class="txt" id="jabatanpetugas" value="<?php echo $rwtnh["jabatanpetugas"]; ?>" size="50" maxlength="50" />                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Tanggal</td>
                            <td class="content">
                                <input name="tgldisetujui" type="text" class="txt" id="tgldisetujui" value="<?php echo date("d-m-Y",strtotime($rwtnh["tgldisetujui"])); ?>" size="20" maxlength="15" />
                                <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgldisetujui'),depRange);" />
                                <font color="#666666"><em>(dd-mm-yyyy)</em></font>                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="header2">DIISI OLEH </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Nama</td>
                            <td class="content">
                                <input name="namapetugas2" type="text" class="txt" id="namapetugas2" value="<?php echo $rwtnh["namapetugas2"]; ?>" size="50" maxlength="50" />                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Jabatan</td>
                            <td class="content">
                                <input name="jabatanpetugas2" type="text" class="txt" id="jabatanpetugas2" value="<?php echo $rwtnh["jabatanpetugas2"]; ?>" size="50" maxlength="50" />                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="label">Tanggal</td>
                            <td class="content">
                                <input name="tgldiisi" type="text" class="txt" id="tgldiisi" value="<?php echo date("d-m-Y",strtotime($rwtnh["tgldiisi"])); ?>" size="20" maxlength="15" />
                                <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgldiisi'),depRange);" />
                                <font color="#666666"><em>(dd-mm-yyyy)</em></font>                            </td>
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
                location='tanah.php';
            }else{
                location='<?php echo $_REQUEST['from']."?unit=".$_REQUEST['unit']."&lokasi=".$_REQUEST['lokasi']."&namaunit=".$_REQUEST['namaunit']."&namalokasi=".$_REQUEST['namalokasi']."&baris=".$_REQUEST['baris'];?>';
            }
        }
    </script>
</html>

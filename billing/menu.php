<link type="text/css" rel="stylesheet" href="menuh.css">
<style type="text/css">
    #container{
        height: 36px;
        position: relative;
    }

    #container ul{
        padding: 0;
        margin: 0;
        list-style: none;
    }

    #container ul li{
        height: 36px;
        width: 150px;
        display: block;
        margin-right: 2px;
        float: left;
        text-align: center;
    }

    #container ul li a{
        font-size:14px;
        color:white;
        font-weight:bold;
        font-family:Arial, Helvetica, sans-serif;
        text-decoration: none;
        height:27px;
        padding-top:9px;
        display:block;
    }

    #container ul li ul li a{
        font-size:12px;
        color:white;
        font-weight:bold;
        font-family:Arial, Helvetica, sans-serif;
        text-decoration: none;
        height:27px;
        padding-top:9px;
        display:block;
    }

    #container ul li a.green{
        background:url('images/green.jpg') bottom left no-repeat;
        /*text-shadow:1px 1px #274400;*/
        height: 34px;
        margin-left: -0.5em;
        margin-top: -0.8em;
    }

    #container ul li a.green:hover{
        background:url('images/green.jpg') center left no-repeat;
    }

    #container ul li a.green:active{
        background:url('images/green.jpg') top left no-repeat;
    }
    .asd
    {
        text-decoration: none;
        font-family: arial, verdana, san-serif;
        font-size: 13px; color: #4234ff;
    }
    
    .txtinputan
    {
        background-color:#056604;
        color:#ffffff;
        border:2px inset #ffffff;
    }
    
    .btninputan
    {
        background-color:#056604;
        color:#ffffff;
        border:3px outset #ffffff;
    }

    #menuh ul li{float:left; width: 100%;}
    #menuh a{height:1%;font:bold 0.7em/1.4em arial, sans-serif;}
</style>

<table style="vertical-align: top" cellpadding=0 cellspacing=0 width=1000 border=0 align="center">
    <tr>
        <td colspan=2 style="background-color:transparent; ">
            <div id='container' align="left">
                <div align="left" style="float:left;" id='menuh'>
                    <ul style="margin-right: .3em; ">
                        <li class='top_parent'>
                            <!--img src="images/home_02.gif" border="0" align="middle" style="text-align:right" /-->
                            <a href="#" class="green">Data Master</a>
                            <ul>
                                <li>
                                    <a class="asd" href="master/tmpt_layanan.php">Tempat Layanan</a>
                                </li>
                                <li>
                                    <a class="asd" href="master/pelaksana_layanan.php">Pelaksana Layanan</a>
                                </li>
                                <li class="parent">
                                    <a href="#" class="asd">Tarif</a>
                                    <img alt="arrow" style="float: right; margin-top: -1.5em; margin-right: 2em;" src="icon/arrows.gif" />&nbsp;
                                    <ul>
                                        <li>
                                            <a class="asd" href="master/pendukung_tarif.php">Pendukung Tarif</a>
                                        </li>
                                        <!--li>
                                            <a class="asd" href="master/tarif1.php">Tarif</a>
                                        </li-->
                                        <li>
                                              <a class="asd" href="master/kamar.php">Kamar</a>                                              
                                        </li>
                                        <!--li>
                                            <a class="asd" href="master/set_Dist_komp.php">Setting Distribusi Komponen</a>
                                        </li-->
                                        <!--li>
                                            <a class="asd" href="master/set_kls_tamb.php">Setting Kelas Tambahan</a>
                                        </li-->
                                        <!--li>
                                            <a class="asd" href="master/set_tarif_tmpt_lay.php">Setting Tarif Tempat Layanan</a>
                                        </li-->
                                        <!--li>
                                            <a class="asd" href="master/set_klasifikasi_penunjang.php">Setting Klasifikasi Penunjang</a>
                                        </li-->
                                        <!--li>
                                            <a class="asd" href="master/set_tarif_tindakan.php">Setting Tarif Tindakan Harian</a>
                                        </li-->
                                    </ul>
                                </li>
								<li class="parent">
									<a href="master/tindakan.php" class="asd">Tindakan</a>
									<!--img alt="arrow" style="float:right; margin-top:-1.5em; margin-right:2em;" src="icon/arrows.gif" /-->&nbsp;
									<!--ul>
										<li>
											<a class="asd" href="master/tindakan.php">Tindakan</a>
										</li>
										<li>
											<a class="asd" href="master/tindakan_kls.php">Tindakan Kelas</a>
										</li>
										<li>
											<a class="asd" href="master/tindakan_komp.php">Tindakan Komponen</a>
                                                            </li>
									</ul-->
								</li>
                                <li>
                                    <a class="asd" href="master/penjamin.php">Penjamin</a>
                                </li>
                                <li class="parent">
                                    <a href="#" class="asd">Referensi Medik</a>
                                    <img alt="arrow" style="float: right; margin-top: -1.5em; margin-right: 2em;" src="icon/arrows.gif" />&nbsp;
                                    <ul>
                                        <li>
                                            <a class="asd" href="master/diagnosis1.php">Diagnosis</a>
                                        </li>
                                        <li>
                                            <a class="asd" href="master/set_diagnosis.php">Setting Diagnosis Tempat Layanan</a>
                                        </li>
                                        <li>
                                            <a class="asd" href="master/kasus1.php">Kasus</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="asd" href="master/ref_gizi.php">Referensi Gizi</a>
                                </li>
                                <li>
                                    <a class="asd" href="master/ref_umum.php">Referensi Umum</a>
                                </li>
                                <li>
                                    <a class="asd" href="master/ref_wilayah_prof.php">Referensi Wilayah</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul style="margin-right: .3em; ">
                        <li class="top_parent">
                            <!--img src="images/home_03.gif"-->
                            <a href="#" class="green">Setting</a>
                            <ul>
                                <li>
                                    <a class=asd href="setting/aplikasi.php">Aplikasi</a>
                                </li>
                                <li>
                                    <a class="asd" href="setting/pengguna.php">Petugas/Operator</a>
                                </li>
                                <li>
                                    <a class=asd href="#">Ganti Password</a>
                                </li>
                                <li class="parent">
                                    <a href="" class="asd">Tema</a>
                                    <img alt="arrow" style="float: right; margin-top: -1.5em; margin-right: 2em;" src="icon/arrows.gif" />&nbsp;
                                    <ul>
                                        <li>
                                            <a class="asd" href="">Warna</a>
                                        </li>
                                        <li>
                                            <a class="asd" href="">Gambar</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul style="margin-right: .3em; ">
                        <li class="top_parent">
                            <!--img src="images/home_04.gif"-->
                            <a href="#" class="green">Transaksi</a>
                            <ul>
                                <li>
                                    <a class=asd href="loket/registrasi.php">Registrasi/Kunjungan</a>
                                </li>
                                <li>
                                    <a class=asd href="unit_pelayanan/koreksi.php">Koreksi/Pindah Tempat Tidur</a>
                                </li>
								<li>
									<a class="asd" href="unit_pelayanan/PelayananKunjungan.php">Pelayanan Kunjungan</a>
								</li>
                                <!--li>
                                    <a class=asd href="unit_pelayanan/tindakan.php">Tindakan</a>
                                </li>
                                <li>
                                    <a class=asd href="unit_pelayanan/diagnosa.php">Medik</a>
                                </li-->
                                <li>
                                    <a class=asd href="pembayaran/pembayaran.php">Pembayaran</a>
                                </li>
                                <li>
                                    <a class=asd href="unit_pelayanan/lain-lain.php">Lain-Lain</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul style="margin-right: .3em; ">
                        <li class="top_parent">
                            <!--img src="images/home_05.gif"-->
                            <a href="#" class="green">Laporan</a>
                            <ul>
                                <li>
                                    <a class=asd href="laporan/kasir.php">Kasir</a>
                                </li>
                                <li>
                                    <a class=asd href="laporan/tempat_layanan.php">Tempat Layanan</a>
                                </li>
                                <li>
                                    <a class=asd href="laporan/rekam_medik.php">Rekam Medik</a>
                                </li>
                                <li>
                                    <a class=asd href="laporan/pelaksana_layanan.php">Pelaksana Layanan</a>
                                </li>
                                <li>
                                    <a class=asd href="laporan/keuangan.php">Keuangan</a>
                                </li>
                                <li>
                                    <a class=asd href="laporan/manajemen.php">Manajemen</a>
                                </li>
                                <li>
                                    <a class=asd href="laporan/penjamin.php">Penjamin</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul style="margin-right: .3em; ">
                        <li class="top_parent">
                            <!--img src="images/home_06.gif"-->
                            <a href="#" class="green">Informasi</a>
                            <ul>
                                <li>
                                    <a class=asd href="informasi/kunjungan.php">Kunjungan</a>
                                </li>
                                <li>
                                    <a class=asd href="informasi/riwayat_kunj.php">Riwayat Kunjungan</a>
                                </li>
                                <li>
                                    <a class=asd href="informasi/pelaksana_lay.php">Pelaksana Layanan</a>
                                </li>
                                <li>
                                    <a class=asd href="informasi/tarif.php">Tarif</a>
                                </li>
                                <li>
                                    <a class=asd href="informasi/kamar.php">Kamar</a>
                                </li>
                                <li>
                                    <a class=asd href="informasi/pasien_sdh_plng.php">Pasien Sudah Pulang</a>
                                </li>
                                <li>
                                    <a class=asd href="informasi/pasien_blm_plng.php">Pasien Belum Pulang</a>
                                </li>
                                <li>
                                    <a class=asd href="informasi/kinerja_petugas.php">Kinerja Petugas</a>
                                </li>
                                <li>
                                    <a class=asd href="informasi/aktifitas_petugas.php">Aktifitas Petugas</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul style="margin-right: .3em; ">
                        <li class="top_parent">
                            <!--img src="images/home_07.gif"-->
                            <a href="#" class="green">Antrian</a>
                            <ul>
                                <li>
                                    <a class=asd href="antrian/kunjungan.php">Kunjungan</a>
                                </li>
                                <li>
                                    <a class=asd href="antrian/medik_pasien.php">Medik Pasien</a>
                                </li>
                                <li>
                                    <a class=asd href="antrian/pembayaran.php">Pembayaran</a>
                                </li>
                                <li>
                                    <a class=asd href="antrian/penunjang.php">Permintaan Penunjang</a>
                                </li>
                                <li>
                                    <a class=asd href="antrian/status_medik.php">Status Medik Pasien</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <div style="margin-left: 700px; margin-top: -18px">
                        <form id="formLogin" action="login_proc.php" method="post" onsubmit="return cekLogin();">
                        <table border="0">
                            <tr>
                                <td align="right">
                                    <fieldset style="padding-top: 0px; padding-bottom: 2px; padding-right: 2px; padding-left: 2px">
                                        <legend style="color: #005500">Login</legend>
                                        <input class="txtinputan" type="text" size="8" id="txtUser" name="txtUser" value="User ID" onfocus="if(this.value == 'User ID') this.value=''" onblur="if(this.value=='') this.value = 'User ID'" />
                                        <input class="txtinputan" type="text" size="8" id="txtPass" name="txtPass" value="Password" onfocus="if(this.value == 'Password'){ this.value=''; this.type='password';}" onblur="if(this.value=='') {this.type = 'text'; this.value = 'Password';}" />
                                        <input class="btninputan" type="submit" value="login" />
                                    </fieldset>
                                </td>
                            </tr>
                        </table>
                        </form>
                        <script>
                            function cekLogin(){
                                if(document.getElementById('txtUser').value=='User ID' || document.getElementById('txtPass').value=='Password'){
                                    alert('Silakan isi username dan password!');
                                    return false;
                                }
                                else{
                                    return true;
                                }
                            }
                        </script>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>


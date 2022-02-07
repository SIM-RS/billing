
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>Edit KIB Alat/Mesin</title>
    </head>

    <body>
        <script type="text/javascript">
            var arrRange=depRange=[];
        </script>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
        <div align="center">
            <?php
            include("../header.php");
            include("../koneksi/konek.php");
            $id_kib = $_REQUEST['id_kib'];
            $batgl = explode('-',$_REQUEST['txtbatgl']);
            $batgl = $batgl[2].'-'.$batgl[1].'-'.$batgl[0];
            $tgldisetujui = explode('-',$_REQUEST['txttgldisetujui']);
            $tgldisetujui = $tgldisetujui[2].'-'.$tgldisetujui[1].'-'.$tgldisetujui[0];
            $tgldiisi = explode('-',$_REQUEST['txttgldiisi']);
            $tgldiisi = $tgldiisi[2].'-'.$tgldiisi[1].'-'.$tgldiisi[0];
            if($_REQUEST["act"]=="save") {
                $sql_update="UPDATE as_kib SET jenisbarang='".$_REQUEST["txtjenisbarang"]."',merk='".$_REQUEST["txtmerk"]."',tipe='".$_REQUEST["txttipe"]."',spesifikasi='".$_REQUEST["txtspesifikasi"]."',tahunalat='".$_REQUEST["txttahunalat"]."',caraperolehan='".$_REQUEST["cmbcaraperolehan"]."',diperolehdari='".$_REQUEST["txtdiperolehdari"]."',dasarpengadaan='".$_REQUEST["cmbdasarpengadaan"]."',hargasatuan='".$_REQUEST["txthargasatuan"]."',dasarharga='".$_REQUEST["cmbdasarharga"]."',sumberdana='".$_REQUEST["cmbsumberdana"]."',bano='".$_REQUEST['txtbano']."',batgl='".$batgl."',surat1='".$_REQUEST['txtsurat1']."',surat2='".$_REQUEST['txtsurat2']."',namapengurus='".$_REQUEST["txtnamapengurus"]."',alamatpengurus='".$_REQUEST["txtalamatpengurus"]."',catpengisi='".$_REQUEST["txtcatpengisi"]."',namapetugas='".$_REQUEST["txtnamapetugas"]."',jabatanpetugas='".$_REQUEST["txtjabatanpetugas"]."',tgldisetujui='".$tgldisetujui."',namapetugas2='".$_REQUEST["txtnamapetugas2"]."',jabatanpetugas2='".$_REQUEST["txtjabatanpetugas2"]."',tgldiisi='".$tgldiisi."' WHERE id_kib=$id_kib";
                $exe_update=mysql_query($sql_update);
                if($exe_update>0) {
                    echo "<script>alert('Data Telah Berhasil Tersimpan..');
			window.location= 'tanah.php';
			</script>";
                }
            }

            $sqlmsn = "SELECT b.kodebarang,b.namabarang,u.namaunit,u.kodeunit,k.id_kib,
k.jenisbarang,k.merk,k.tipe,k.spesifikasi,k.tahunalat,k.caraperolehan,k.diperolehdari,
k.dasarpengadaan,k.hargasatuan,k.dasarharga,s.keterangan AS sumberdana,k.bano,k.batgl,
k.surat1,k.surat2,k.namapengurus,k.alamatpengurus,k.catpengisi,k.namapetugas,
k.jabatanpetugas,k.tgldisetujui,k.namapetugas2,k.jabatanpetugas2,k.tgldiisi
FROM as_kib k
INNER JOIN as_transaksi t ON t.idtransaksi = k.idtransaksi
INNER JOIN as_ms_barang b ON b.idbarang = t.idbarang
INNER JOIN as_ms_unit u ON u.idunit = t.idunit
LEFT JOIN as_ms_sumberdana s ON s.idsumberdana = k.idsumberdana
WHERE LEFT(b.kodebarang,2) = 02 AND k.id_kib = '".$id_kib."'";
            $dtmsn = mysql_query($sqlmsn);
            $rwmsn = mysql_fetch_array($dtmsn);

            ?>
            <div id="div_view">
            <form name="form1" id="form1" action="" method="post">
                <input name="act" id="act" type="hidden" />
                
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
                            <button class="Enabledbutton" id="backbutton" type="button" onClick="location='mesin.php'" title="Back" style="cursor:pointer">
                                <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                		Back to List
                            </button>
                            <button class="Enabledbutton" id="btnSimpan" name="btnSimpan" onclick="document.getElementById('act').value='save';form1.submit()" title="Save" style="cursor:pointer">
                                <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Save Record
                            </button>
                            <button class="Disabledbutton" id="undobutton" disabled="true" onClick="location='editMesin.php'" title="Cancel / Refresh" style="cursor:pointer">
                                <img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                Undo/Refresh
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header">.: Kartu Inventaris Barang : Peralatan Dan Mesin - Detail :. (Edit Mode)</td>
                    </tr>
                    <tr>
                        <td width="40%" class="label">&nbsp;Unit Kerja</td>
                        <td width="60%" class="content">&nbsp;<input id="txtkodeunit" name="txtkodeunit" value="<?php echo $rwmsn['kodeunit']; ?>" style="background-color:#99FFFF;" size="24"/></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kode Barang - Seri</td>
                        <td class="content">&nbsp;<input id="txtkodebarang" name="txtkodebarang" value="<?php echo $rwmsn['kodebarang'];?>" size="24" style="background-color:#99FFFF;"/></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama Barang</td>
                        <td class="content">&nbsp;<input id="txtnamabarang" name="txtnamabarang" value="<?php echo $rwmsn['namabarang'];?>" size="50" style="background-color:#99FFFF;" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;I. UNIT BARANG</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Jenis Alat/Kendaraan</td>
                        <td class="content">&nbsp;<input id="txtjenisbarang" name="txtjenisbarang" value="<?php echo $rwmsn['jenisbarang'];?>" size="50" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Merk</td>
                        <td class="content">&nbsp;<input id="txtmerk" name="txtmerk" size="50" value="<?php echo $rwmsn['merk'];?>" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Tipe Alat/Kendaraan</td>
                        <td class="content">&nbsp;<input id="txttipe" name="txttipe" size="50" value="<?php echo $rwmsn['tipe'];?>" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Spesifikasi/CC</td>
                        <td class="content">&nbsp;<textarea id="txtspesifikasi" name="txtspesifikasi" cols="50">Ukuran:&nbsp;<?php echo $rwmsn['spesifikasi'];?></textarea></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Tahun Alat/Kendaraan</td>
                        <td class="content">&nbsp;<input id="txttahun" name="txttahun" size="16" value="<?php echo $rwmsn['tahunalat'];?>" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kondisi Alat/Kendaraan</td>
                        <td class="content">&nbsp;<!--select id="cmbkonsalat" name="cmbkonsalat">
				<option <?php if($rwmsn['kosalat'] == 1) echo 'selected'; ?> value="1">1 - Baik & Baru</option>
				<option <?php if($rwmsn['kosalat'] == 2) echo 'selected'; ?> value="2">2 - Baik & Berfungsi</option>
				<option <?php if($rwmsn['kosalat'] == 3) echo 'selected'; ?> value="3">3 - Rusak</option>
						</select--></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;No. Pabrik</td>
                        <td class="content">&nbsp;<input size="50" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;No. Seri Rangka</td>
                        <td class="content">&nbsp;<input size="50" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;No. Seri Mesin</td>
                        <td class="content">&nbsp;<input size="50" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;No. Polisi</td>
                        <td class="content">&nbsp;<input size="50" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;No. BPKB</td>
                        <td class="content">&nbsp;<input size="50" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;II. PENGADAAN</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Cara Perolehan</td>
                        <td class="content">&nbsp;
                            <select id="cmbcaraperolehan" name="cmbcaraperolehan">
                                <option <?php if($rwmsn['caraperolehan'] == 1) echo 'selected'; ?> value="1">1 - Pembelian</option>
                                <option <?php if($rwmsn['caraperolehan'] == 2) echo 'selected'; ?> value="2">2 - Hibah</option>
                                <option <?php if($rwmsn['caraperolehan'] == 3) echo 'selected'; ?> value="3">3 - Pembebasan</option>
                                <option <?php if($rwmsn['caraperolehan'] == 4) echo 'selected'; ?> value="4">4 - Sebelum 1945</option>
                                <option <?php if($rwmsn['caraperolehan'] == 5) echo 'selected'; ?> value="5">5 - Tukar Menukar</option>
                                <option <?php if($rwmsn['caraperolehan'] == 6) echo 'selected'; ?> value="6">6 - Cara Lain</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Diperoleh Dari</td>
                        <td class="content">&nbsp;<input id="txtdiperolehdari" name="txtdiperolehdari" value="<?php echo $rwmsn['diperolehdari'];?>" size="50" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Berdasarkan</td>
                        <td class="content">&nbsp;<select id="cmbdasarpengadaan" name="cmbdasarpengadaan">
                                <option <?php if($rwmsn['dasarpengadaan'] == 1) echo 'selected'; ?> value="1">1 - Kontrak</option>
                                <option <?php if($rwmsn['dasarpengadaan'] == 2) echo 'selected'; ?> value="2">2 - SPK</option>
                                <option <?php if($rwmsn['dasarpengadaan'] == 3) echo 'selected'; ?> value="3">3 - Order</option>
                                <option <?php if($rwmsn['dasarpengadaan'] == 4) echo 'selected'; ?> value="4">4 - SK</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nomor</td>
                        <td class="content">&nbsp;<input size="50" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kondisi Perolehan</td>
                        <td class="content">&nbsp;<!--select id="cmbkonsperolehan" name="cmbkonsperolehan">
				<option <?php if($rwmsn['konsperolehan'] == 1) echo 'selected'; ?> value="1">1 - Baik & Baru</option>
				<option <?php if($rwmsn['konsperolehan'] == 2) echo 'selected'; ?> value="2">2 - Baik & Berfungsi</option>
				<option <?php if($rwmsn['konsperolehan'] == 3) echo 'selected'; ?> value="3">3 - Rusak</option>
						</select--></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Harga Perolehan</td>
                        <td class="content">&nbsp;<input id="txthargasatuan" name="txthargasatuan" value="<?php echo $rwmsn['hargasatuan'];?>" size="24" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Dasar Harga</td>
                        <td class="content">&nbsp;<select id="cmbdasarharga" name="cmbdasarharga">
                                <option <?php if($rwmsn['dasarharga'] == 1) echo 'selected'; ?> value="1">1 - C & F</option>
                                <option <?php if($rwmsn['dasarharga'] == 2) echo 'selected'; ?> value="2">2 - CIF Baik</option>
                                <option <?php if($rwmsn['dasarharga'] == 3) echo 'selected'; ?> value="3">3 - FOB</option>
                                <option <?php if($rwmsn['dasarharga'] == 4) echo 'selected'; ?> value="4">4 - Ex Factory (LN)</option>
                                <option <?php if($rwmsn['dasarharga'] == 5) echo 'selected'; ?> value="1">5 - Lokal</option>
                                <option <?php if($rwmsn['dasarharga'] == 6) echo 'selected'; ?> value="1">6 - Taksiran</option>
                                <option <?php if($rwmsn['dasarharga'] == 7) echo 'selected'; ?> value="1">7 - Lain</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Sumber Dana</td>
                        <td class="content">&nbsp;<select name="cmbsumberdana" id="cmbsumberdana">
<?php
$sqlsd=mysql_query("SELECT idsumberdana,keterangan FROM as_ms_sumberdana");
                                while($showsd=mysql_fetch_array($sqlsd)) {
                                    ?>
                                <option <?php if($rwmsn['sumberdana'] == $showsd['idsumberdana']) echo 'selected';?> value="<?=$showsd['idsumberdana'];?>"><?=$showsd['keterangan'];?></option>
                                    <?php } ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;BA Serah Terima No.</td>
                        <td class="content">&nbsp;<input id="txtbano" name="txtbano" value="<?php echo $rwmsn['bano'];?>" size="50" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;BA Tanggal</td>
                        <td class="content">&nbsp;<input id="txtbatgl" name="txtbatgl" value="<?php echo $rwmsn['batgl'];?>" size="24" class="txtunedited" readonly readonly />
                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtbatgl'),depRange);" />
                            <font size=1 color=gray><i>(dd-mm-yyyy)</i></font></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Surat 1</td>
                        <td class="content">&nbsp;<input id="txtsurat1" name="txtsurat1" value="<?php echo $rwmsn['surat1'];?>" size="50" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Surat 2</td>
                        <td class="content">&nbsp;<input id="txtsurat2" name="txtsurat2" size="50" value="<?php echo $rwmsn['surat2'];?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;III. PENGURUS BARANG</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama/Jabatan</td>
                        <td class="content">&nbsp;<input id="txtnamapengurus" name="txtnamapengurus" value="<?php echo $rwmsn['namapengurus'];?>" size="50" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Alamat</td>
                        <td class="content">&nbsp;<input id="txtalamatpengurus" name="txtalamatpengurus" value="<?php echo $rwmsn['alamatpengurus'];?>" size="50" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;IV. BAGIAN-BAGIAN LAIN/PERLENGKAPAN</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Catatan Perlengkapan</td>
                        <td class="content">&nbsp;<textarea id="txtcatperlengkapan" name="txtcatperlengkapan" cols="50"></textarea></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Catatan Pengisi</td>
                        <td class="content">&nbsp;<textarea id="txtcatpengisi" name="txtcatpengisi" cols="50"><?php echo $rwmsn['catpengisi'];?></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;DISETUJUI OLEH</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama</td>
                        <td class="content">&nbsp;<input id="txtnamapetugas" name="txtnamapetugas" value="<?php echo $rwmsn['namapetugas'];?>" size="50" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Jabatan</td>
                        <td class="content">&nbsp;<input id="txtjabatanpetugas" name="txtjabatanpetugas" size="50" value="<?php echo $rwmsn['jabatanpetugas'];?>" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Tanggal</td>
                        <td class="content">&nbsp;<input id="txttgldisetujui" name="txttgldisetujui" value="<?php echo $rwmsn['tgldisetujui'];?>" size="24" class="txtunedited" readonly readonly />
                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txttgldisetujui'),depRange);" />
                            <font size=1 color=gray><i>(dd-mm-yyyy)</i></font></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;DIISI OLEH</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama</td>
                        <td class="content">&nbsp;<input id="txtnamapetugas2" name="txtnamapetugas2" value="<?php echo $rwmsn['namapetugas2'];?>" size="50" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Jabatan</td>
                        <td class="content">&nbsp;<input id="txtjabatanpetugas2" name="txtjabatanpetugas2" size="50" value="<?php echo $rwmsn['jabatanpetugas2'];?>" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Tanggal</td>
                        <td class="content">&nbsp;<input id="txttgldiisi" name="txttgldiisi" value="<?php echo $rwmsn['tgldiisi'];?>" size="24" class="txtunedited" readonly readonly />
                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txttgldiisi'),depRange);" />
                            <font size=1 color=gray><i>(dd-mm-yyyy)</i></font></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;</td>
                    </tr>
                </table>
                <table><tr><td height="10"></td></tr></table>
            <div><img src="../images/foot.gif" width="1000" height="45"></div>
            </td>

  </tr>
</table>
            </div>
            </form>
            </div>
            <div id="div_edit">
                
            </div>
        </div>
    </body>
</html>
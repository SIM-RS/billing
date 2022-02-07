<?php
session_start();
include("../../sesi.php");
?>
<?php
include("../../koneksi/konek.php");
$JenisLayanan = $_REQUEST['jnsLay'];
$TempatLayanan = $_REQUEST['tmptLay'];
$StatusPasien = $_REQUEST['stsPas'];
$sqlDiv = "SELECT (SELECT nama FROM b_ms_unit WHERE id = '".$JenisLayanan."') AS Jenis, 
			(SELECT nama FROM b_ms_unit WHERE id = '".$TempatLayanan."') AS Tempat,
			(SELECT nama FROM b_ms_kso WHERE id = '".$StatusPasien."') AS statuspasien
			FROM b_kunjungan k
			INNER JOIN b_ms_unit u ON u.id = k.unit_id
			INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
			GROUP BY kso.nama";
$rsDiv = mysql_query($sqlDiv);
$rwDiv = mysql_fetch_array($rsDiv);
?>
<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" onClick="document.getElementById('div_laporan').popup.hide()" />
<fieldset ><legend align="center">Laporan Tempat Layanan</legend>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td  onclick="lap1()" class="report">&nbsp;Buku Register Pasien</td>
            <td >&nbsp;<a href="Tempat Layanan/PengirimanKonsul.php" target="_blank">Pengiriman Konsul</a></td>
        </tr>
        <tr>
            <td onclick="lap2()" class="report">&nbsp;Buku Diagnosis Pasien</td>
            <td onclick="lap4()" class="report">&nbsp;Rujukan Penunjang Medik</td>
        </tr>
        <tr>
            <td onclick="lap3()" class="report">&nbsp;Buku Tindakan Pasien</td>
            <td>&nbsp;<a href="" target="_blank">Kegiatan Pelayanan</a></td>
        </tr>
        <tr>
            <td>&nbsp;<a href="Tempat Layanan/PenerimaanKonsul.php" target="_blank">Penerimaan Konsul</a></td>
            <td>&nbsp;<a href="" target="_blank">Kunjungan Tempat Layanan</a></td>
        </tr>
        <tr>
            <td >&nbsp;<a href="" target="_blank">Cara Masuk Pasien Berdasarkan Tempat Layanan</a></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td >&nbsp;<a href="" target="_blank">Detail Asal Rujukan Pasien Berdasarkan Tempat Layanan</a></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td >&nbsp;<a href="" target="_blank">Cara Bayar Pasien Berdasarkan Tempat Layanan</a></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td >&nbsp;<a href="" target="_blank">Kasus Penyakit Pasien Berdasarkan Tempat Layanan</a></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td >&nbsp;<a href="" target="_blank">Cara Keluar Pasien Berdasarkan Tempat Layanan</a></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td >&nbsp;<a href="" target="_blank">Kunjungan Pasien Berdasarkan Penjamin Pasien</a></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td >&nbsp;<a href="" target="_blank">Asal Pasien Berdasarkan Penjamin Pasien</a></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;<a href="" target="_blank">Kasus Penyakit Pasien Berdasarkan Penjamin Pasien</a></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td >&nbsp;<a href="" target="_blank">Cara Keluar Pasien Berdasarkan Penjamin Pasien</a></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;<a href="" target="_blank">Diagnosis Tempat Layanan</a></td>
            <td>&nbsp;<a href="" target="_blank">10 Diagnosis Terbanyak</a></td>
        </tr>
        <tr>
            <td>&nbsp;<a href="" target="_blank">Grafik 10 Diagnosis Terbanyak</a></td>
            <td>&nbsp;<a href="" target="_blank">Pendapatan Tempat Layanan</a></td>
        </tr>
        <tr>
            <td >&nbsp;<a href="" target="_blank">Penerimaan Tempat Layanan (Semua Pasien)</a></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td >&nbsp;<a href="" target="_blank">Penerimaan Tempat Layanan (Pasien Pulang)</a></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;<a href="" target="_blank">Klaim Jaminan Tempat Layanan</a></td>
            <td>&nbsp;<a href="" target="_blank">Blangko Kelengkapan Berkas</a></td>
        </tr>
        <tr>
            <td>&nbsp;<a href="" target="_blank">Pendapatan Medik Operatif</a></td>
            <td>&nbsp;<a href="" target="_blank">Penerimaan Medik Operatif</a></td>
        </tr>
        <tr>
            <td>&nbsp;<a href="" target="_blank">Klaim Jaminan Medik Operatif</a></td>
            <td>&nbsp;<a href="" target="_blank">Kegiatan Medik Operatif</a></td>
        </tr>
        <tr>
            <td>&nbsp;<a href="" target="_blank">Pasien MRS</a></td>
            <td>&nbsp;<a href="" target="_blank">Pasien KRS</a></td>
        </tr>
        <tr>
            <td >&nbsp;<a href="" target="_blank">Rincian Pendapatan Layanan Pasien Pulang</a></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td >&nbsp;<a href="" target="_blank">Rekap Pendapatan Tempat Layanan Pasien Pulang</a></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td >&nbsp;<a href="" target="_blank">Rekap Pendapatan Per Tgl Kunjungan Tempat Layanan</a></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td >&nbsp;<a href="" target="_blank">Rekap Pendapatan Per Pelaksana Tempat Layanan</a></td>
            <td>&nbsp;</td>
        </tr>
    </table>

    <!--backup by fidi-->
    <!--table width="650px" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                    <td width="50%" onclick="lap1()" style="cursor:pointer;">&nbsp;Buku Register Pasien</td>
                    <td width="50%">&nbsp;<a href="Tempat Layanan/PengirimanKonsul.php" target="_blank">Pengiriman Konsul</a></td>
		</tr>
            <tr>
                    <td onclick="lap2()" style="cursor:pointer;">&nbsp;Buku Diagnosis Pasien</td>
                    <td onclick="lap4()" style="cursor:pointer;">&nbsp;Rujukan Penunjang Medik</td>
		</tr>
            <tr>
                    <td onclick="lap3()" style="cursor:pointer;">&nbsp;Buku Tindakan Pasien</td>
                    <td>&nbsp;<a href="" target="_blank">Kegiatan Pelayanan</a></td>
		</tr>
            <tr>
                    <td>&nbsp;<a href="Tempat Layanan/PenerimaanKonsul.php" target="_blank">Penerimaan Konsul</a></td>
                    <td>&nbsp;<a href="" target="_blank">Kunjungan Tempat Layanan</a></td>
		</tr>
            <tr>
                    <td colspan="2">&nbsp;<a href="" target="_blank">Cara Masuk Pasien Berdasarkan Tempat Layanan</a></td>
		</tr>
            <tr>
                    <td colspan="2">&nbsp;<a href="" target="_blank">Detail Asal Rujukan Pasien Berdasarkan Tempat Layanan</a></td>
		</tr>
            <tr>
                    <td colspan="2">&nbsp;<a href="" target="_blank">Cara Bayar Pasien Berdasarkan Tempat Layanan</a></td>
		</tr>
            <tr>
                    <td colspan="2">&nbsp;<a href="" target="_blank">Kasus Penyakit Pasien Berdasarkan Tempat Layanan</a></td>
		</tr>
            <tr>
                    <td colspan="2">&nbsp;<a href="" target="_blank">Cara Keluar Pasien Berdasarkan Tempat Layanan</a></td>
		</tr>
            <tr>
                    <td colspan="2">&nbsp;<a href="" target="_blank">Kunjungan Pasien Berdasarkan Penjamin Pasien</a></td>
		</tr>
            <tr>
                    <td colspan="2">&nbsp;<a href="" target="_blank">Asal Pasien Berdasarkan Penjamin Pasien</a></td>
		</tr>
            <tr>
                    <td colspan="2">&nbsp;<a href="" target="_blank">Kasus Penyakit Pasien Berdasarkan Penjamin Pasien</a></td>
		</tr>
            <tr>
                    <td colspan="2">&nbsp;<a href="" target="_blank">Cara Keluar Pasien Berdasarkan Penjamin Pasien</a></td>
		</tr>
            <tr>
                    <td>&nbsp;<a href="" target="_blank">Diagnosis Tempat Layanan</a></td>
                    <td>&nbsp;<a href="" target="_blank">10 Diagnosis Terbanyak</a></td>
		</tr>
            <tr>
                    <td>&nbsp;<a href="" target="_blank">Grafik 10 Diagnosis Terbanyak</a></td>
                    <td>&nbsp;<a href="" target="_blank">Pendapatan Tempat Layanan</a></td>
		</tr>
            <tr>
                    <td colspan="2">&nbsp;<a href="" target="_blank">Penerimaan Tempat Layanan (Semua Pasien)</a></td>
		</tr>
            <tr>
                    <td colspan="2">&nbsp;<a href="" target="_blank">Penerimaan Tempat Layanan (Pasien Pulang)</a></td>
		</tr>
            <tr>
                    <td>&nbsp;<a href="" target="_blank">Klaim Jaminan Tempat Layanan</a></td>
                    <td>&nbsp;<a href="" target="_blank">Blangko Kelengkapan Berkas</a></td>
		</tr>
            <tr>
                    <td>&nbsp;<a href="" target="_blank">Pendapatan Medik Operatif</a></td>
                    <td>&nbsp;<a href="" target="_blank">Penerimaan Medik Operatif</a></td>
		</tr>
            <tr>
                    <td>&nbsp;<a href="" target="_blank">Klaim Jaminan Medik Operatif</a></td>
                    <td>&nbsp;<a href="" target="_blank">Kegiatan Medik Operatif</a></td>
		</tr>
            <tr>
                    <td>&nbsp;<a href="" target="_blank">Pasien MRS</a></td>
                    <td>&nbsp;<a href="" target="_blank">Pasien KRS</a></td>
		</tr>
            <tr>
                    <td colspan="2">&nbsp;<a href="" target="_blank">Rincian Pendapatan Layanan Pasien Pulang</a></td>
		</tr>
            <tr>
                    <td colspan="2">&nbsp;<a href="" target="_blank">Rekap Pendapatan Tempat Layanan Pasien Pulang</a></td>
		</tr>
            <tr>
                    <td colspan="2">&nbsp;<a href="" target="_blank">Rekap Pendapatan Per Tgl Kunjungan Tempat Layanan</a></td>
		</tr>
            <tr>
                    <td colspan="2">&nbsp;<a href="" target="_blank">Rekap Pendapatan Per Pelaksana Tempat Layanan</a></td>
		</tr>
	</table-->
</fieldset>
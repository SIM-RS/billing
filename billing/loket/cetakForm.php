<?php
session_start();
include("../sesi.php");
?>
<title>Formulir Verifikasi Dan Kendali Pelayanan</title>
<?php
include("../koneksi/konek.php");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("H:i:s");

$userId = $_REQUEST['userId'];
$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = $userId";
$rsPeg = mysql_query($sqlPeg);
$rwPeg = mysql_fetch_array($rsPeg);

$qUnit = "SELECT nama FROM b_ms_unit WHERE id = '".$_REQUEST['Unit']."'";
$rsUnit = mysql_query($qUnit);
$rwUnit = mysql_fetch_array($rsUnit);

$qPas = "SELECT p.no_rm, p.nama, p.sex, DATE_FORMAT(p.tgl_lahir,'%d-%m-%Y') AS tgllahir,
			k.umur_thn, (SELECT nama FROM b_ms_kso WHERE id = k.kso_id) AS namapenjamin,
			k.no_sjp, DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tglmasuk
			FROM b_ms_pasien p
			INNER JOIN b_kunjungan k ON k.pasien_id = p.id
			WHERE p.id = '".$_REQUEST['idPas']."'
			AND k.id = '".$_REQUEST['idKunj']."'";
$rsPas = mysql_query($qPas);
$rwPas = mysql_fetch_array($rsPas);
?>
<table width="700" border="0" cellpadding="0" cellspacing="0" align="left">
    <tr>
        <td colspan="3" align="center">FORMULIR VERIFIKASI DAN KENDALI PELAYANAN<BR><?php echo $rwUnit['nama'] ;?></td>
    </tr>
    <tr height="30">
        <td width="60%" style="border-bottom:1px solid;">&nbsp;Nama RS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;<?=$namaRS?></td>
        <td width="20%" style="border-bottom:1px solid;">&nbsp;Kode RS : 35.150.15</td>
        <td width="20%" align="right" style="border-bottom:1px solid;">Kode RS : B &nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3">
            <table width="100%" align="center" border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td width="30%">&nbsp;No. Rekam Medik</td>
                    <td width="50%">&nbsp;:&nbsp;<?php echo $rwPas['no_rm'];?></td>
                    <td width="20%" align="right">Kasus : B / L&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;Nama Pasien / JK</td>
                    <td colspan="2">&nbsp;:&nbsp;<?php echo $rwPas['nama'];?>&nbsp;/&nbsp;<?php echo $rwPas['sex'];?></td>
                </tr>
                <tr>
                    <td>&nbsp;Tanggal Lahir</td>
                    <td colspan="2">&nbsp;:&nbsp;<?php echo $rwPas['tgllahir'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Usia : <?php echo $rwPas['umur_thn'];?>&nbsp;tahun</td>
                </tr>
                <tr>
                    <td>&nbsp;Model Pembayaran</td>
                    <td colspan="2">&nbsp;:&nbsp;<?php echo $rwPas['namapenjamin'];?></td>
                </tr>
                <tr>
                    <td>&nbsp;No. SKP</td>
                    <td colspan="2">&nbsp;:&nbsp;<?php echo $rwPas['no_sjp'];?></td>
                </tr>
                <tr>
                    <td>&nbsp;Tanggal Masuk</td>
                    <td colspan="2">&nbsp;:&nbsp;<?php echo $rwPas['tglmasuk'];?></td>
                </tr>
                <tr>
                    <td>&nbsp;Cara Pulang</td>
                    <td colspan="2">&nbsp;:&nbsp;1. sembuh / 2. dirujuk / 3. pulang paksa</td>
                </tr>
                <tr>
                    <td>&nbsp;Berat Lahir</td>
                    <td colspan="2">&nbsp;:&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> gram</td>
                </tr>
                <tr>
                    <td>&nbsp;Total Biaya</td>
                    <td colspan="2"><table width="500" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
                            <tr>
                                <td width="25%" style="border-bottom:1px solid; border-left:2px solid; border-top:2px solid" align="center">Biaya Perawatan</td>
                                <td width="25%" style="border-bottom:1px solid; border-left:1px solid; border-top:2px solid" align="center">Biaya Obat</td>
                                <td width="25%" style="border-bottom:1px solid; border-left:1px solid; border-top:2px solid" align="center">Biaya PMI</td>
                                <td width="25%" style="border-bottom:1px solid; border-left:1px solid; border-top:2px solid; border-right:2px solid;" align="center">Total Biaya</td>
                            </tr>
                            <tr height="40">
                                <td style="border-bottom:2px solid; border-left:2px solid;">&nbsp;</td>
                                <td style="border-bottom:2px solid; border-left:1px solid;">&nbsp;</td>
                                <td style="border-bottom:2px solid; border-left:1px solid;">&nbsp;</td>
                                <td style="border-bottom:2px solid; border-left:1px solid; border-right:2px solid;">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;Surat Rujukan</td>
                    <td colspan="2">&nbsp;:&nbsp;1. Tidak Ada / 2. Ada</td>
                </tr>
                <tr>
                    <td>&nbsp;Diagnosis Utama/Kode</td>
                    <td colspan="2"><table width="500" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="50%" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;</td>
                                <td align="right" width="50%" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid; border-right:1px solid;">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;Diagnosis Sekunder/Kode</td>
                    <td colspan="2"><table width="500" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="80%" height="20" style="border-top:2px solid; border-left:2px solid; border-bottom:1px solid;">&nbsp;</td>
                                <td width="20%" style="border-top:2px solid; border-right:2px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td height="20" style="border-left:2px solid; border-bottom:2px solid;">&nbsp;</td>
                                <td style="border-left:1px solid; border-bottom:2px solid; border-right:2px solid;">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;Tindakan/Kode</td>
                    <td colspan="2"><table width="500" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="80%" height="20" style="border-top:2px solid; border-left:2px solid; border-bottom:1px solid;">&nbsp;</td>
                                <td width="20%" style="border-top:2px solid; border-right:2px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td height="20" style="border-left:2px solid; border-bottom:2px solid;">&nbsp;</td>
                                <td style="border-left:1px solid; border-bottom:2px solid; border-right:2px solid;">&nbsp;</td>
                            </tr>
                        </table></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right" colspan="2">
                        <table width="250">
                            <tr>
                                <td><?=$kotaRS?>, <?php echo $date_now;?>&nbsp;Jam&nbsp;<?php echo $jam;?></td>
                            </tr>
                            <tr>
                                <td>Dokter Penanggung jawab,</td>
                            </tr>
                            <tr>
                                <td height="50">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="border-bottom:2px solid;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr id="trTombol">      
                    <td colspan="4" class="noline" align="center">
                        <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
                        <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<script type="text/JavaScript">

    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
            //if(confirm('Anda yakin mau mencetak Forumulir Verifikasi ini?')){
                setTimeout('window.print()','1000');
                setTimeout('window.close()','2000');
            /*}
            else{
                tombol.style.visibility='visible';
            }*/
        }
    }
</script>
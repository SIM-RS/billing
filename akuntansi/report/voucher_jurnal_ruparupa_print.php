<?php

?>

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Bukti Jurnal Rupa-Rupa</title>
</head>

<body>
    <style>
         

        .table1 td {
            padding: 3px;
        }

        .table3 {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .table3 td,
        .table3 th {
            border: 1px solid black;
            padding: 8px;
        }


        .table3 th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }

        tr a {
            text-decoration: none;
            color: #000000;
        }

        .tblheaderkiri {
            padding: 8px;
            border-top: 1px solid #003520;
            border-right: none;
            border-bottom: 1px solid #003520;
            border-left: 1px solid #003520;
            font-weight: bold;
        }

        .tblheaderkanan {
            padding: 8px;
            border-top: 1px solid #003520;
            border-right: 1px solid #003520;
            border-bottom: 1px solid #003520;
            border-left: none;
            font-weight: bold;
        }

        .tblheader {
            padding: 8px;
            border-top: 1px solid #003520;
            border-right: none;
            border-bottom: 1px solid #003520;
            border-left: none;
            font-weight: bold;
        }

        .tblfooterkiri {
            padding: 8px;
            border: 1px solid #003520;
            font-weight: bold;
        }

        .tblfooter {
            padding: 8px;
            border-top: 1px solid #003520;
            border-right: 1px solid #003520;
            border-bottom: 1px solid #003520;
            border-left: none;
            font-weight: bold;
        }

        .jumlah {
            border-top: 1px dashed #003520;

            border-bottom: 1px dashed #003520;
            border-right: 1px solid #203C42;

        }

        .tdisi {
            padding-top: 8px;
            padding-right: 8px;
            padding-left: 8px;
            border-top: none;
            border-right: 1px solid #203C42;
            border-left: none;
            /*font-size: 11px;
            /*text-align: left;*/
        }

        .tdisikiri {
            padding-left: 8px;
            border-top: none;
            border-right: 1px solid #203C42;
            border-left: 1px solid #203C42;
        }

        .tdisibawah {
            border-top: 1px solid #003520;
            border-bottom: 1px solid #003520;
            border-right: 1px solid #003520;
        }
        
    </style>

    <!-- START TABLE SATU -->
    <table width="1038" height="258" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="3"><img src="../images/logo_br.png" width="300" height="55" align="left" />
                <p align="right"><b>NO. BUKTI : </b> ................................</p>
            </td>
        </tr>
        <tr align="center">
            <td colspan="2">
                <p style="font-size:16px; font-weight:bold"><u>BUKTI JURNAL RUPA - RUPA</u></p>
                <p style="font-size:16px; font-weight:bold"><?php echo $title_tgl; ?>
            </td>
        </tr>

        <tr>
            <td width="515" align="right">CURRENCY : IDR &nbsp;</td>
        </tr>
        <tr style="vertical-align:top">
            <td height="40">
                <div class="box" style="border: 1px solid black; padding: 8px;">
                    <table class="table1" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">

                        <tr style="vertical-align:top">
                            <td width="25">1. </td>
                            <td width="350">Harap dibukukan mutasi atas transaksi sebagai berikut</td>
                            <td>:</td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr style="vertical-align:top">
                            <td width="25">2. </td>
                            <td width="350">Nilai</td>
                            <td>:</td>
                            <td>Rp 2.000.000,00</td>
                            <td></td>
                        </tr>

                        <tr style="vertical-align:top">
                            <td width="25">3. </td>
                            <td width="350">Terbilang</td>
                            <td>:</td>
                            <td>Dua juta rupiah, ...............</td>
                        </tr>

                        <tr style="vertical-align:top">
                            <td width="25">4. </td>
                            <td width="350">Uraian</td>
                            <td>:</td>
                            <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ea pariatur perspiciatis
                                facere magnam, corporis nam odio mollitia aspernatur debitis culpa sint voluptatum ut
                                omnis consequuntur? Debitis ullam modi tempore natus!</td>
                        </tr>

                        <tr style="vertical-align:top">
                            <td width="25">5. </td>
                            <td width="350">Bukti Pendukung</td>
                            <td>:</td>
                            <td>Terlampir</td>
                        </tr>

                    </table>
                </div>
                <!-- END TABLE SATU -->

                <!-- START TABLE DUA -->
                <p style="font-size:16px; font-weight:bold" align="center">KODE DAN NAMA REKENING</p>

                <table class="table2" width="1030" border="0" cellpadding="0" cellspacing="0"
                    style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
                    <tr align="center">
                        <td width="25" class="tblheaderkiri">No.</td>
                        <td width="500" class="tblheader">KODE REKENING</td>
                        <td class="tblheader">DEBET BUKU JURNAL</td>
                        <td class="tblheaderkanan">KREDIT BUKU JURNAL</td>
                    </tr>
                    <!-- tbody -->
                    <tr>
                        <td width="25" class="tdisikiri">1. </td>
                        <td class="tdisi">834. 01. 00.00 . 09.99.00.04</td>
                        <td class="tdisi">Rp 2.000.000,00</td>
                        <td class="tdisi">Rp -</td>
                    </tr>
                    <tr>
                        <td class="tdisikiri">2. </td>
                        <td class="tdisi">834. 01. 00.00 . 09.99.00.04</td>
                        <td class="tdisi">Rp -</td>
                        <td class="tdisi">Rp 2.000.000,00</td>
                    </tr>
                    <tr>
                        <td class="tdisikiri">3. </td>
                        <td class="tdisi"></td>
                        <td class="tdisi">Rp -</td>
                        <td class="tdisi">Rp -</td>
                    </tr>
                    <tr>
                        <td class="tdisikiri">4. </td>
                        <td class="tdisi"></td>
                        <td class="tdisi">Rp -</td>
                        <td class="tdisi">Rp -</td>
                    </tr>
                    <tr>
                        <td class="tdisikiri">3. </td>
                        <td class="tdisi"></td>
                        <td class="tdisi">Rp -</td>
                        <td class="tdisi">Rp -</td>
                    </tr>
                    <tr>
                        <td class="tdisikiri">4. </td>
                        <td class="tdisi"></td>
                        <td class="tdisi">Rp -</td>
                        <td class="tdisi">Rp -</td>
                    </tr>
                    <tr>
                        <td class="tdisikiri">3. </td>
                        <td class="tdisi"></td>
                        <td class="tdisi">Rp -</td>
                        <td class="tdisi">Rp -</td>
                    </tr>
                    <tr>
                        <td class="tdisikiri">4. </td>
                        <td class="tdisi"></td>
                        <td class="tdisi">Rp -</td>
                        <td class="tdisi">Rp -</td>
                    </tr>
                    <!-- #tbody -->
                    <!-- tfoot -->
                    <tr>
                        <td class="tblfooterkiri" colspan="2" align="right">Jumlah</td>
                        <td class="tblfooter">Rp -</td>
                        <td class="tblfooter">Rp 2.000.000,00</td>
                    </tr>
                    <!-- #tfoot -->
                </table>
                <!-- END TABLE DUA -->

                <!-- START TABLE TIGA -->
                <table width="1030" class="table3"
                    style="font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-top:15px;">
                    <tr align="center">
                        <td rowspan="2">Tahapan</td>
                        <td colspan="2">Masuk</td>
                        <td colspan="2">Keluar</td>
                        <!-- ttd -->
                        <td rowspan="6"><br>Belawan, .... .............. <?= date(Y);?><br>
                            PT. PRIMA HUSADA CIPTA MEDAN<br>
                            GENERAL MANAGER KEUANGAN DAN UMUM<br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <b>NADLIN, S.E</b></td>
                    </tr>
                    <tr>
                        <td width="50px">Tgl</td>
                        <td width="50px">Prf</td>
                        <td width="50px">Tgl</td>
                        <td width="50px">Prf</td>
                    </tr>
                    <tr>
                        <td>Pembuat</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Verifikasi</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>D1</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>D2</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>D3</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td rowspan="3" align="center">
                            <b>UANG TELAH DITERIMA OLEH : </b><br><br><br><br>
                            (........................................................................)</td>
                    </tr>
                    
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="6" align="center"><b>K E T E R A N G A N</b></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border-right:none; border-bottom:none; border-right:none;">a. Status Posting</td>
                        <td style="border-left:none; border-right:none; border-bottom:none; border-right:none;" >:</td>
                        <td style="border-left:none; border-bottom:none; border-right:none;">-</td>
                        <td rowspan="2" align="center" style="border-left:none;">
                            <b> c. Paraf Petugas Posting </b><br><br><br><br>
                            (........................................................................)</td>
                    </tr>
                    <tr>
                    <td colspan="3" style="border-right:none; border-top:none; border-right:none;">b. Tanggal Posting</td>
                        <td style="border-left:none; border-right:none; border-top:none; border-right:none;">:</td>
                        <td style="border-left:none; border-top:none; border-right:none;">-</td>
                    </tr>
                </table>
                <!-- END TABLE TIGA -->



            <a>JRR</a>
            </td>
            <td>

            </td>
        </tr>
    </table>

    <p id="p_print" align="center"><button type="button"
            onclick="document.getElementById('p_print').style.display='none';window.print();window.close();"><img
                src="../icon/printer.png" height="16" width="16" border="0" align="absmiddle" />&nbsp;
            Cetak</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" onclick="window.close();"><img
                src="../icon/back.png" height="16" width="16" border="0" align="absmiddle" />&nbsp; Tutup</button></p>
</body>

</html>
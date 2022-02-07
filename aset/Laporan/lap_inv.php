<?php
session_start();
// is valid users
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
$r_formatlap = $_POST["formatlap"];

switch ($r_formatlap) {
    case "XLS" :
        Header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Laporan Inventaris_'.date('d-m-Y').'.xls"');
        break;
    case "WORD" :
        Header("Content-Type: application/msword");
		header('Content-Disposition: attachment; filename="Laporan Inventaris_'.date('d-m-Y').'.doc"');
        break;
    default :
        Header("Content-Type: text/html");
        break;
}

if (isset($_POST["submit"])) {
    $r_cmbperolehan = $_POST["cmbperolehan"];
    if ($r_cmbperolehan=="1") {
        $strTGL="select min(tgltransaksi) as awal,max(tgltransaksi) as akhir from as_transaksi";
        $rs = mysql_query($strTGL);
        $rowTgl = mysql_fetch_array($rs);
        $r_tglawal=$rowTgl["awal"];
        $r_tglakhir=$rowTgl["akhir"];
    }else {
        $r_tglawal = tglSQL($_POST["tglawal"]);
        $r_tglakhir = tglSQL($_POST["tglakhir"]);
    }
    $r_idunit = $_POST["idunit"];
}
?>
<html>
    <head>
        <title>Laporan Kartu Inventaris Barang</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <?php if($r_formatlap != 'XLS' && $r_formatlap != 'WORD'){ ?>
			<link href="../theme/report.css" rel="stylesheet" type="text/css" />
		<?php } ?>
    </head>
    <body>
        
        <p align="center"><strong><font size="4" face="Times New Roman, Times, serif">KARTU INVENTARIS BARANG (KIB)</font><br />
                <font size="3" face="Times New Roman, Times, serif"><?php echo $_POST['kategori_kib']; ?></font></strong>
            <?php
            if ($r_cmbperolehan=="2") {
                ?>
            <br />
            <font size="3" face="Times New Roman, Times, serif">
                (<?php echo date("d M Y",strtotime($r_tglawal));  ?> - <?php echo date("d M Y",strtotime($r_tglakhir));  ?>)
            </font>
                <?php
            }
            ?></p>
        <?php include "lap_header.php"; ?>   
        <?php
        $strSetting="select * from as_setting";
        $rsSetting = mysql_query($strSetting);
        $r_kodepropinsi=13;
        $r_kodepemda=26;
        $rowSetting = mysql_fetch_array($rsSetting);
        $r_kodepropinsi=$rowSetting["kodepropinsi"];
        $r_kodepemda=$rowSetting["kodekota"];

        //echo $r_tglakhir."<br />";
        $jmlth = substr($r_tglakhir,0,4)-substr($r_tglawal,0,4);
        //echo $jmlth; 
        for ($jm=0;$jm<=$jmlth;$jm++) {
            if ($jm==$jmlth) {
                if ($jmlth==0) {
                    $awl=$r_tglawal;
                    $akhr=$r_tglakhir;
                }else {
                    $awl=(substr($akhr,0,4)+1)."-01-01";
                    $akhr=$r_tglakhir;
                }
            }else {
                if ($jm==0) {
                    $awl=$r_tglawal;
                    $akhr=substr($awl,0,4)."-12-31";
                }else {
                    $awl=(substr($akhr,0,4)+1)."-01-01";
                    $akhr=substr($awl,0,4)."-12-31";
                }
            }
            $flt="tgltransaksi between '$awl' and '$akhr'";
            //echo $flt."<br />";
            $th = substr($awl,2,2);
//	}
/*//A
$strSQL .="from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit ";
$strSQL .="inner join as_kib k on t.idtransaksi=k.idtransaksi
inner join as_ms_barang b on t.idbarang=b.idbarang ";
$strSQL .="inner join as_seri s on t.idtransaksi=s.idtransaksi
where substring(kodebarang,1,3)='01.' and $flt and t.idunit=$r_idunit
and b.tipe=1 order by id_kib,noseri";

//B
$strSQL .="from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit";
$strSQL .="inner join as_kib k on t.idtransaksi=k.idtransaksi
inner join as_ms_barang b on t.idbarang=b.idbarang ";
$strSQL .="inner join as_seri s on t.idtransaksi=s.idtransaksi ";
$strSQL .="where t.idunit=$r_idunit and substring(kodebarang,1,3)='02.' and $flt and b.tipe=1
order by id_kib,noseri";

//C
$strSQL = "from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit
inner join as_kib k on t.idtransaksi=k.idtransaksi
inner join as_ms_barang b on t.idbarang=b.idbarang
inner join as_seri s on t.idtransaksi=s.idtransaksi
where t.idunit=$r_idunit and substring(kodebarang,1,3)='03.'
and $flt and b.tipe=1
order by id_kib,noseri";

//D
$strSQL = "from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit
inner join as_kib k on t.idtransaksi=k.idtransaksi
inner join as_ms_barang b on t.idbarang=b.idbarang
inner join as_seri s on t.idtransaksi=s.idtransaksi
where t.idunit=$r_idunit and substring(kodebarang,1,3)='04.'
and $flt and b.tipe=1 order by id_kib,noseri";

//E
$strSQL = "from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit
inner join as_kib k on t.idtransaksi=k.idtransaksi
inner join as_ms_barang b on t.idbarang=b.idbarang
inner join as_seri s on t.idtransaksi=s.idtransaksi
where t.idunit=$r_idunit and substring(kodebarang,1,3)='05.'
and $flt and b.tipe=1 order by id_kib,noseri";

//F
$strSQL = "from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit
inner join as_kib k on t.idtransaksi=k.idtransaksi
inner join as_ms_barang b on t.idbarang=b.idbarang
inner join as_seri s on t.idtransaksi=s.idtransaksi
where t.idunit=$r_idunit and substring(kodebarang,1,3)='06.'
and $flt and b.tipe=1 order by id_kib,noseri";*/

switch(substr($_POST['kategori_kib'],0,1)){
    case 'A':$unitnya='01.';
        break;
    case 'B':$unitnya='02.';
        break;
    case 'C':$unitnya='03.';
        break;
    case 'D':$unitnya='04.';
        break;
    case 'E':$unitnya='05.';
        break;
    case 'F':$unitnya='06.';
        break;
}
            if ($r_idunit=="0")
                $strUnit="select u.idunit,kodeunit,namaunit,namapanjang
                from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit
                inner join as_ms_barang b on t.idbarang=b.idbarang
                where u.idunit<>0 and substring(kodebarang,1,3)='$unitnya' and $flt
                order by kodeunit";
            else
                $strUnit="select u.idunit,kodeunit,namaunit,namapanjang
                from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit
                inner join as_ms_barang b on t.idbarang=b.idbarang
                where u.idunit=$r_idunit or parentunit=$r_idunit
                or parentunit in
                (select idunit from as_ms_unit where parentunit=$r_idunit)
                and substring(kodebarang,1,3)='$unitnya' and $flt
                order by kodeunit";
            //echo $strUnit;
            $rsUnit = mysql_query($strUnit);
            while ($rowsUnit = mysql_fetch_array($rsUnit)) {
                $r_idunit=$rowsUnit["idunit"];
                //	echo $rowsUnit["kodeunit"]."<br />";
                $r_kodeunit="";
                 $r_kodeunit .=$rowsUnit["kodeunit"];
                //echo strlen($r_kodeunit);
                //echo $r_kodeunit;
                if (strlen($r_kodeunit)==2) $r_kodeunit .=".00.00";
                elseif (strlen($r_kodeunit)==5) $r_kodeunit .=".00";

                //$r_kodeunit="12.".$r_kodepropinsi.".".$r_kodepemda.".".substr($rowsUnit["kodeunit"],0,6).$th.substr($rowsUnit["kodeunit"],5,3);
                $r_kodeunit="12.".$r_kodepropinsi.".".$r_kodepemda.".".substr($r_kodeunit,0,6).$th.substr($r_kodeunit,5,3);
                //	echo $r_kodeunit;
                switch (substr($_POST['kategori_kib'],0,1)) {
                    case "A" :		// KIB - TANAH
					 ?>
	<table border=0 width="1300">
	<tr>
	    <td width="970" align="right"><strong>No. Kode Lokasi</strong></td>
	    <td >:</td>
         <td align="right">
	    <strong>
		  <?php echo $r_kodeunit; ?>
			-
	<?php
		echo $rowsUnit["namaunit"];
	?>
	</strong>
	</td>
	</tr>
	</table>
	<br />
                                 
        <table border=1 cellspacing="0" cellpadding="4" class="GridStyle" width="1300">
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td width="32" rowspan="3">
                    <font size="-2"><br />
                        No</font>
                </td>
                <td width="148" rowspan="3">
                    <font size="-2"><br />
                        Jenis Barang/Nama Barang</font>
                </td>
                <td height="22" colspan="2">
                    <font size="-2">Nomor</font>
                </td>
                <td width="49" rowspan="3"><br />
                    Luas (M&sup2;)</td>
                <td width="56" rowspan="3">
                    <font size="-2"><br />
                        Tahun Pengadaan</font>
                </td>
                <td width="167" rowspan="3">
                    <font size="-2"><br />
                        Letak/Alamat</font>
                </td>
                <td height="22" colspan="3">
                    <font size="-2">Status Tanah</font>
                </td>
                <td width="61" rowspan="3">
                    <font size="-2"><br />
                        Penggunaan</font>
                </td>
                <td width="55" rowspan="3">
                    <font size="-2"><br />
                        Asal Usul</font>
                </td>
                <td width="110" rowspan="3">
                    <font size="-2"><br />
                        Harga<br />
                        (Rp)</font>
                </td>
                <td width="128" rowspan="3">
                    <font size="-2"><br />
                        Keterangan</font>
                </td>
            </tr>
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td width="82" rowspan="2"><font size="-2">Kode Barang</font></td>
                <td width="63" rowspan="2"><font size="-2">Register</font></td>
                <td width="75" rowspan="2"><font size="-2">Hak</font></td>
                <td height="10" colspan="2"><font size="-2">Sertifikat</font></td>
            </tr>
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td width="56" height="10"><font size="-2">Tanggal</font></td>
                <td width="97" height="10"><font size="-2">Nomor</font></td>
            </tr>
            <tr align="center" valign="top" bgcolor="#FFFFCC" class="SubHeaderBW">
                <td height="10"><font size="-2">1</font></td>
                <td height="10"><font size="-2">2</font></td>
                <td height="10"><font size="-2">3</font></td>
                <td height="10"><font size="-2">4</font></td>
                <td height="10"><font size="-2">5</font></td>
                <td height="10"><font size="-2">6</font></td>
                <td height="10"><font size="-2">7</font></td>
                <td height="10"><font size="-2">8</font></td>
                <td height="10"><font size="-2">9</font></td>
                <td height="10"><font size="-2">10</font></td>
                <td height="10"><font size="-2">11</font></td>
                <td height="10"><font size="-2">12</font></td>
                <td height="10"><font size="-2">13</font></td>
                <td height="10"><font size="-2">14</font></td>
            </tr>
			    <?php
                        $strSQL="select kodeunit,namapanjang,namabarang,kodebarang,noseri,luastanah,tgltransaksi,substring(tglperolehan,1,4) as thn_pengadaan,alamat,";
                        $strSQL .="statushukum,suratsertifikat,sertifikattgl,macampemanfaatan as penggunaan,caraperolehan as asalusul,hargasatuan,catpengisi as ket ";
                        $strSQL .="from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit ";
                        $strSQL .="inner join as_kib k on t.idtransaksi=k.idtransaksi inner join as_ms_barang b on t.idbarang=b.idbarang ";
                        $strSQL .="inner join as_seri s on t.idtransaksi=s.idtransaksi where substring(kodebarang,1,3)='01.' and $flt and t.idunit=$r_idunit and b.tipe=1 order by id_kib,noseri";
                        //$strSQL."<br />";
                        $rs = mysql_query($strSQL);
                        if (mysql_affected_rows() > 0) { // Iterating through record
			   
                                $j = 0;
                                $totalharga=0;
                                while ($rows = mysql_fetch_array($rs)) {
                                    if ($j % 2) $rowStyle = "NormalBG";  else $rowStyle = "AlternateBG";
                                    $j++;
                                    $totalharga +=$rows["hargasatuan"];
                                    ?>
            <tr class="<?php echo $rowStyle ?>" valign="top">
                <td align="center">
                                            <?php
                                            echo $j;
                                            ?>
                </td>
                <td align="left">
                                            <?php
                                            echo $rows["namabarang"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo $rows["kodebarang"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo str_pad($rows["noseri"], 4, "0", STR_PAD_LEFT);
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo $rows["luastanah"];
                                            ?>
                </td>
                <td align="center">
                    <font size=1>
                                                <?php
                                                echo substr($rows["tgltransaksi"],0,4);
                                                ?>
                    </font>
                </td>
                <td align="left" class="<?php echo $cellStyle ?>">
                                            <?php
                                            echo $rows["alamat"];
                                            ?>
                </td>
                <td align="center" class="<?php echo $cellStyle ?>">
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
                <td align="center" class="<?php echo $cellStyle ?>">
                                            <?php
                                            if ($rows["sertifikattgl"])
                                                echo date("d/m/Y",strtotime($rows["sertifikattgl"]));
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo $rows["suratsertifikat"];
                                            ?>
                </td>
                <td align="left">
                                            <?php
                                            switch ($rows["penggunaan"]) {
                                                case 1 : echo "Rumah";
                                                    break;
                                                case 2 : echo "Kantor";
                                                    break;
                                                case 3 : echo "Lainnya";
                                                    break;
                                            }
                                            ?>
                </td>
                <td align="left">
                                            <?php
                                            switch ($rows["asalusul"]) {
                                                case 1 : echo "Pembelian";
                                                    break;
                                                case 2 : echo "Hibah";
                                                    break;
                                                case 3 : echo "Pembebasan";
                                                    break;
                                                case 4 : echo "Sebelum 1945";
                                                    break;
                                                case 5 : echo "Tukar Menukar";
                                                    break;
                                                case 6 : echo "Cara Lain";
                                                    break;
                                            }
                                            ?>
                </td>
                <td align="right">
                                            <?php
                                            echo number_format($rows["hargasatuan"],0,",",".");
                                            ?>
                </td>
                <td align="left">
                                            <?php
                                            echo $rows["ket"];
                                            ?>
                </td>
            </tr>
                                    <?php
                                } // end while
                                ?>
            <tr>
                <td class="HeaderBW" colspan="2">&nbsp;</td>
                <td class="HeaderBW" colspan="10" align="left">J U M L A H ................................................................</td>
                <td align="right" class="HeaderBW"><?php echo number_format($totalharga,0,",","."); ?></td>
                <td class="HeaderBW">&nbsp;</td>
            </tr>
        </table>
        <br />
        <br />
        <table border=0 cellspacing="0" cellpadding="0" width="1300">
            <tr>
                <td align="center"><strong>MENGETAHUI<br />KEPALA SKPD<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
                <td width="100">&nbsp;</td>

                <td align="center"><strong>.........................,.........................................<br />PENGURUS BARANG<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
            </tr>
        </table><br /><br /><br /><br />
                            <?php
                        } // end

                        break;
                    case "B" :		// KIB - PERALATAN DAN MESIN
					?>
        <table border=0 width="1300">
            <tr>
                <td width="970" ><strong>No. Kode Lokasi</strong></td>
                <td >:</td>
                <td>
                    <strong>
                        <?php
                        echo $r_kodeunit;
                        ?>
                        -
                        <?php
                        echo $rowsUnit["namaunit"];
                        ?>
                    </strong>
                </td>
            </tr>
        </table>
        <br />
        <table border=1 cellspacing="0" cellpadding="4" class="GridStyle" width="1300">
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td width="34" rowspan="2">
                    <font size="-2"><br />No</font>
                </td>
                <td width="88" rowspan="2">
                    <font size="-2"><br />Kode Barang</font>
                </td>
                <td rowspan="2"><font size="-2">Nama Barang<br />(Jenis Barang)</font>
                </td>
                <td width="50" rowspan="2">
                    <font size="-2">Nomor Register</font>
                </td>
                <td width="82" rowspan="2">
                    <font size="-2"><br />Merk/Type</font>
                </td>
                <td width="81" rowspan="2">
                    <font size="-2"><br />Ukuran/CC</font>
                </td>
                <td width="49" rowspan="2">
                    <font size="-2"><br />Bahan</font>
                </td>
                <td width="50" rowspan="2">
                    <font size="-2">Tahun<br />Pembelian</font>
                </td>
                <td height="10" colspan="5">
                    <font size="-2">Nomor</font>
                </td>
                <td width="75" rowspan="2">
                    <font size="-2">Asal Usul<br />Cara Perolehan</font>
                </td>
                <td width="110" rowspan="2">
                    <font size="-2">
                        Harga<br />
                        (Rp)
                    </font>
                </td>
                <td width="98" rowspan="2"><font size="-2"><br />Keterangan</font></td>
            </tr>
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td width="50" height="10">
                    <font size="-2">Pabrik</font>
                </td>
                <td width="57" height="10">
                    <font size="-2">Rangka</font>
                </td>
                <td width="44" height="10">
                    <font size="-2">Mesin</font>
                </td>
                <td width="43" height="10">
                    <font size="-2">Polisi</font>
                </td>
                <td width="44" height="10">
                    <font size="-2">BPKB</font>
                </td>
            </tr>
            <tr align="center" valign="top" bgcolor="#FFFFCC" class="SubHeaderBW">
                <td height="10">
                    <font size="-2">1</font>
                </td>
                <td height="10">
                    <font size="-2">2</font>
                </td>
                <td height="10">
                    <font size="-2">3</font>
                </td>
                <td height="10">
                    <font size="-2">4</font>
                </td>
                <td height="10">
                    <font size="-2">5</font>
                </td>
                <td height="10">
                    <font size="-2">6</font>
                </td>
                <td height="10">
                    <font size="-2">7</font>
                </td>
                <td height="10">
                    <font size="-2">8</font>
                </td>
                <td height="10">
                    <font size="-2">9</font>
                </td>
                <td height="10">
                    <font size="-2">10</font>
                </td>
                <td height="10">
                    <font size="-2">11</font>
                </td>
                <td height="10">
                    <font size="-2">12</font>
                </td>
                <td height="10">
                    <font size="-2">13</font>
                </td>
                <td height="10">
                    <font size="-2">14</font>
                </td>
                <td height="10">
                    <font size="-2">15</font>
                </td>
                <td height="10">
                    <font size="-2">16</font>
                </td>
            </tr>
                                <?php
                        $strSQL="select kodeunit,namapanjang,namabarang,kodebarang,noseri,k.merk,tipe,k.spesifikasi,bahan,tgltransaksi,tahunperolehan,";
                        $strSQL .="nopabrik,norangka,nopol,nomesin,nobpkb,caraperolehan as asalusul,hargasatuan,catpengisi as ket ";
                        $strSQL .="from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit inner join as_kib k on ";
                        $strSQL .="t.idtransaksi=k.idtransaksi inner join as_ms_barang b on t.idbarang=b.idbarang ";
                        $strSQL .="inner join as_seri s on t.idtransaksi=s.idtransaksi ";
                        $strSQL .="where t.idunit=$r_idunit and substring(kodebarang,1,3)='02.' and $flt and b.tipe=1 order by id_kib,noseri";
                        //$strSQL."<br />";
                        $rs = mysql_query($strSQL);
                        if (mysql_affected_rows() > 0) {
                            
                                // Iterating through record
                                $j = 0;
                                $totalharga=0;
                                while ($rows = mysql_fetch_array($rs)) {
                                    if ($j % 2) $rowStyle = "NormalBG";  else $rowStyle = "AlternateBG";
                                    $j++;
                                    $totalharga +=$rows["hargasatuan"];
                                    ?>
            <tr class="<?php echo $rowStyle ?>" valign="top">
                <td align="center">
                                            <?php
                                            echo $j;
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo $rows["kodebarang"];
                                            ?>
                </td>
                <td align="left">
                                            <?php
                                            echo $rows["namabarang"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo str_pad($rows["noseri"], 4, "0", STR_PAD_LEFT);
                                            ?>
                </td>
                <td align="left">
                                            <?php
                                            echo $rows["merk"].', '. $rows["tipe"];
                                            ?>
                </td>
                <td align="center">
                    <font size=1>
                                                <?php
                                                echo $rows["spesifikasi"];
                                                ?>
                    </font>
                </td>
                <td align="left" class="<?php echo $cellStyle ?>">
                                            <?php
                                            echo $rows["bahan"];
                                            ?>
                </td>
                <td align="center" class="<?php echo $cellStyle ?>">
                                            <?php
                                            echo substr($rows["tgltransaksi"],0,4);
                                            ?>
                </td>
                <td align="center" class="<?php echo $cellStyle ?>">
                                            <?php
                                            echo $rows["nopabrik"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo $rows["norangka"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo $rows["nomesin"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo $rows["nopol"];
                                            ?>
                </td>
                <td align="right">
                                            <?php
                                            echo $rows["nobpkb"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            switch ($rows["asalusul"]) {
                                                case 1 : echo "Hadiah";
                                                    break;
                                                case 2 : echo "Beli";
                                                    break;
                                                case 3 : echo "Dibuat";
                                                    break;
                                                case 4 : echo "dll";
                                                    break;
                                            }
                                            ?>
                </td>
                <td align="right">
                                            <?php
                                            echo number_format($rows["hargasatuan"],0,",",".");
                                            ?>
                </td>
                <td align="left">
                                            <?php
                                            echo $rows["ket"];
                                            ?>
                </td>
            </tr>
                                    <?php
                                } // end while
                                ?>
            <tr>
                <td class="HeaderBW" colspan="2">&nbsp;</td>
                <td class="HeaderBW" colspan="12" align="left">J U M L A H ................................................................</td>
                <td align="right" class="HeaderBW"><?php echo number_format($totalharga,0,",","."); ?></td>
                <td class="HeaderBW">&nbsp;</td>
            </tr>
        </table>
        <br />
        <br />
        <table border=0 cellspacing="0" cellpadding="0" width="1300">
            <tr>
                <td align="center"><strong>MENGETAHUI<br />KEPALA SKPD<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
                <td width="100">&nbsp;</td>

                <td align="center"><strong>.........................,.........................................<br />PENGURUS BARANG<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
            </tr>
        </table><br /><br /><br /><br />
                            <?php
                        } // end

                        break;
                    case "C" :		// KIB - GEDUNG DAN BANGUNAN
					 ?>
        <table border=0 width="1300">
            <tr>
                <td width="970"><strong>No. Kode Lokasi</strong></td>
                <td >:</td>
                <td>
                    <strong>
                        <?php echo $r_kodeunit; ?> - <?php echo $rowsUnit["namaunit"]; ?>
                    </strong>
                </td>
            </tr>
        </table>
        <br />
        <table border=1 cellspacing="0" cellpadding="4" class="GridStyle" width="1300">
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td width="27" rowspan="2"><font size="-2"><br />No</font></td>
                <td rowspan="2"><font size="-2">Nama Barang<br />(Jenis Barang)</font></td>
                <td height="10" colspan="2"><font size="-2">Nomor</font></td>
                <td width="49" rowspan="2"><font size="-2">Kondisi Bangunan<br />(B, KB, RB)</font></td>
                <td height="10" colspan="2"><font size="-2">Konstruksi Bangunan</font></td>
                <td width="45" rowspan="2"><font size="-2">Luas Lantai<br />(M&sup2;)</font></td>
                <td width="140" rowspan="2"><font size="-2">Letak/Lokasi<br />Alamat</font></td>
                <td height="10" colspan="2"><font size="-2">Dokumen Gedung</font></td>
                <td width="45" rowspan="2"><font size="-2">Luas Bangunan<br />(M&sup2;)</font></td>
                <td width="72" rowspan="2"><font size="-2"><br />Status Tanah</font></td>
                <td width="67" rowspan="2"><font size="-2">Nomor<br />Kode Tanah</font></td>
                <td width="62" rowspan="2"><font size="-2"><br />Asal Usul</font></td>
                <td width="110" rowspan="2"><font size="-2"><br />
                        Harga</font></td>
                <td width="78" rowspan="2"><font size="-2"><br />Keterangan</font></td>
            </tr>
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td width="60" height="10"><font size="-2">Kode Nomor</font></td>
                <td width="40" height="10"><font size="-2">Register</font></td>
                <td width="50" height="10"><font size="-2">Bertingkat / Tidak</font></td>
                <td width="45" height="10"><font size="-2">Beton / Tidak</font></td>
                <td width="50" height="10"><font size="-2">Tanggal</font></td>
                <td width="60" height="10"><font size="-2">Nomor</font></td>
            </tr>
            <tr align="center" valign="top" bgcolor="#FFFFCC" class="SubHeaderBW">
                <td height="10"><font size="-2">1</font></td>
                <td height="10"><font size="-2">2</font></td>
                <td height="10"><font size="-2">3</font></td>
                <td height="10"><font size="-2">4</font></td>
                <td height="10"><font size="-2">5</font></td>
                <td height="10"><font size="-2">6</font></td>
                <td height="10"><font size="-2">7</font></td>
                <td height="10"><font size="-2">8</font></td>
                <td height="10"><font size="-2">9</font></td>
                <td height="10"><font size="-2">10</font></td>
                <td height="10"><font size="-2">11</font></td>
                <td height="10"><font size="-2">12</font></td>
                <td height="10"><font size="-2">13</font></td>
                <td height="10"><font size="-2">14</font></td>
                <td height="10"><font size="-2">15</font></td>
                <td height="10"><font size="-2">16</font></td>
                <td height="10"><font size="-2">17</font></td>
            </tr>
                                <?php
                        $strSQL="select kodeunit,namapanjang,namabarang,kodebarang,noseri,keadaanalat,jumlahlantai,konsatap,konsrangka,konspondasi,luaslantai,alamat,kelurahan,kecamatan,kotamadya,ijinbangtgl,ijinbangno,luasbangunan,statushukum,nokibtanah,caraperolehan as asalusul,hargasatuan,catpengisi as ket from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit inner join as_kib k on t.idtransaksi=k.idtransaksi inner join as_ms_barang b on t.idbarang=b.idbarang inner join as_seri s on t.idtransaksi=s.idtransaksi where t.idunit=$r_idunit and substring(kodebarang,1,3)='03.' and $flt and b.tipe=1 order by id_kib,noseri";
                        $rs = mysql_query($strSQL);
                        if(mysql_affected_rows() > 0) {
                           
                                // Iterating through record
                                $j = 0;
                                $totalharga=0;
                                while($rows = mysql_fetch_array($rs)) {
                                    if ($j % 2) $rowStyle = "NormalBG";  else $rowStyle = "AlternateBG";
                                    $j++;
                                    $totalharga +=$rows["hargasatuan"];
                                    ?>
            <tr class="<?php echo $rowStyle ?>" valign="top">
                <td align="center">
                                            <?php
                                            echo $j;
                                            ?>
                </td>
                <td align="left">
                                            <?php
                                            echo $rows["namabarang"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo $rows["kodebarang"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo str_pad($rows["noseri"], 4, "0", STR_PAD_LEFT);
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            switch ($rows["keadaanalat"]) {
                                                case 1 : echo "B";
                                                    break;
                                                case 2 : echo "KB";
                                                    break;
                                                case 3 : echo "RB";
                                                    break;
                                                case 4 : echo "TB";
                                                    break;
                                            }
                                            ?>
                </td>
                <td align="center">
                    <font size=1>
                                                <?php
                                                if ($rows["jumlahlantai"]>1)
                                                    echo "Bertingkat";
                                                else
                                                    echo "Tidak";
                                                ?>
                    </font>
                </td>
                <td align="center" class="<?php echo $cellStyle ?>">
                                            <?php
                                            if ($rows["konsrangka"]==3 && $rows["konspondasi"]==1 )
                                                echo "Beton";
                                            else
                                                echo "Tidak";
                                            ?>
                </td>
                <td align="center" class="<?php echo $cellStyle ?>">
                                            <?php
                                            echo
                                            $rows["luaslantai"];
                                            ?>
                </td>
                <td align="left" class="<?php echo $cellStyle ?>">
                                            <?php
                                            echo $rows["alamat"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            if ($rows["ijinbangtgl"])
                                                echo date("d/m/Y",strtotime($rows["ijinbangtgl"]));
                                            ?>
                </td>
                <td align="center"><?php echo $rows["ijinbangno"]; ?></td>
                <td align="center">
                                            <?php
                                            echo $rows["luasbangunan"];
                                            ?>
                </td>
                <td align="center">
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
                <td align="center">
                                            <?php
                                            echo $rows["nokibtanah"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            switch ($rows["asalusul"]) {
                                                case 1 : echo "dibeli";
                                                    break;
                                                case 2 : echo "hibah";
                                                    break;
                                                case 3 : echo "dll";
                                                    break;
                                                default : echo "dll";
                                                    break;
                                            }
                                            ?>
                </td>
                <td align="right">
                                            <?php
                                            echo number_format($rows["hargasatuan"],0,",",".");
                                            ?>
                </td>
                <td align="left">
                                            <?php
                                            echo $rows["ket"];
                                            ?>
                </td>
            </tr>
                                    <?php
                                } // end while
                                ?>
            <tr>
                <td class="HeaderBW" colspan="2">&nbsp;</td>
                <td class="HeaderBW" colspan="13" align="left">J U M L A H ................................................................</td>
                <td align="right" class="HeaderBW"><?php echo number_format($totalharga,0,",","."); ?></td>
                <td class="HeaderBW">&nbsp;</td>
            </tr>
        </table>
        <br />
        <br />
        <table border=0 cellspacing="0" cellpadding="0" width="1300">
            <tr>
                <td align="center"><strong>MENGETAHUI<br />KEPALA SKPD<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
                <td width="100">&nbsp;</td>

                <td align="center"><strong>.........................,.........................................<br />PENGURUS BARANG<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
            </tr>
        </table><br /><br /><br /><br />
                            <?php
                        } // end

                        break;
                    case "D" :		// KIB - JALAN, IRIGASI DAN JARINGAN
					?>
        <table border=0 width="1300">
            <tr>
                <td width="970" ><strong>No. Kode Lokasi</strong></td>
                <td>:</td>
                <td>
                    <strong>
                        <?php
                        echo $r_kodeunit;
                        ?>
                        -
                        <?php
                        echo $rowsUnit["namaunit"];
                        ?>
                    </strong>
                </td>
            </tr>
        </table>
        <br />
        <table border=1 cellspacing="0" cellpadding="4" class="GridStyle" width="1300">
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td rowspan="2"><font size="-2">No</font></td>
                <td rowspan="2"><font size="-2">Nama Barang<br />(Jenis Barang)</font></td>
                <td height="10" colspan="2"><font size="-2">Nomor</font></td>
                <td rowspan="2"><font size="-2"><br />Konstruksi</font></td>
                <td rowspan="2"><font size="-2">Panjang<br />(Km)</font></td>
                <td rowspan="2"><font size="-2">Lebar<br />(M)</font></td>
                <td rowspan="2"><font size="-2">Luas<br />(M&sup2;)</font></td>
                <td rowspan="2"><font size="-2"><br />Letak/Lokasi</font></td>
                <td height="10" colspan="2"><font size="-2">Dokumen</font></td>
                <td rowspan="2"><font size="-2"><br />Status Tanah</font></td>
                <td rowspan="2"><font size="-2">Nomor<br />Kode Tanah</font></td>
                <td rowspan="2"><font size="-2"><br />Asal Usul</font></td>
                <td width="110" rowspan="2"><font size="-2"><br />
                        Harga</font></td>
                <td rowspan="2"><font size="-2">Kondisi<br />(B, KB, RB)</font></td>
                <td rowspan="2"><font size="-2"><br />Keterangan</font></td>
            </tr>
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td height="10"><font size="-2">Kode Barang</font></td>
                <td height="10"><font size="-2">Register</font></td>
                <td height="10"><font size="-2">Tanggal</font></td>
                <td height="10"><font size="-2">Nomor</font></td>
            </tr>
            <tr align="center" valign="top" bgcolor="#FFFFCC" class="SubHeaderBW">
                <td height="10"><font size="-2">1</font></td>
                <td height="10"><font size="-2">2</font></td>
                <td height="10"><font size="-2">3</font></td>
                <td height="10"><font size="-2">4</font></td>
                <td height="10"><font size="-2">5</font></td>
                <td height="10"><font size="-2">6</font></td>
                <td height="10"><font size="-2">7</font></td>
                <td height="10"><font size="-2">8</font></td>
                <td height="10"><font size="-2">9</font></td>
                <td height="10"><font size="-2">10</font></td>
                <td height="10"><font size="-2">11</font></td>
                <td height="10"><font size="-2">12</font></td>
                <td height="10"><font size="-2">13</font></td>
                <td height="10"><font size="-2">14</font></td>
                <td height="10"><font size="-2">15</font></td>
                <td height="10"><font size="-2">16</font></td>
                <td height="10"><font size="-2">17</font></td>
            </tr>
                                <?php
                        $strSQL="select kodeunit,namapanjang,namabarang,kodebarang,noseri,konskategori,panjang,lebar,panjang*lebar*1000 as luas,alamat,kelurahan,kecamatan,kotamadya,suratsertifikat,sertifikattgl,statushukum,nokibtanah,caraperolehan as asalusul,hargasatuan,keadaanalat,catpengisi as ket from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit inner join as_kib k on t.idtransaksi=k.idtransaksi inner join as_ms_barang b on t.idbarang=b.idbarang inner join as_seri s on t.idtransaksi=s.idtransaksi where t.idunit=$r_idunit and substring(kodebarang,1,3)='04.' and $flt and b.tipe=1 order by id_kib,noseri";
                        $rs = mysql_query($strSQL);
                        if(mysql_affected_rows() > 0) {
                            
                                // Iterating through record
                                $j = 0;
                                $totalharga=0;
                                while($rows = mysql_fetch_array($rs)) {
                                    if ($j % 2) $rowStyle = "NormalBG";  else $rowStyle = "AlternateBG";
                                    $j++;
                                    $totalharga +=$rows["hargasatuan"];
                                    ?>
            <tr class="<?php echo $rowStyle ?>" valign="top">
                <td align="center">
                                            <?php
                                            echo $j;
                                            ?>
                </td>
                <td align="left">
                                            <?php
                                            echo $rows["namabarang"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo $rows["kodebarang"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo str_pad($rows["noseri"], 4, "0", STR_PAD_LEFT);
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            switch ($rows["konskategori"]) {
                                                case 1 : echo "Aspal";
                                                    break;
                                                case 2 : echo "Beton";
                                                    break;
                                                case 3 : echo "Paving";
                                                    break;
                                                case 4 : echo "Makadam";
                                                    break;
                                                case 5 : echo "Semen";
                                                    break;
                                                case 6 : echo "Beton Beraspal";
                                                    break;
                                                case 7 : echo "Tanah Liat";
                                                    break;
                                                case 8 : echo "Lainnya";
                                                    break;
                                                default : break;
                                            }
                                            ?>
                </td>
                <td align="center">
                    <font size=1>
                                                <?php
                                                echo $rows["panjang"];
                                                ?>
                    </font>
                </td>
                <td align="center" class="<?php echo $cellStyle ?>">
                                            <?php
                                            echo $rows["lebar"];
                                            ?>
                </td>
                <td align="left" class="<?php echo $cellStyle ?>">
                                            <?php
                                            echo $rows["luas"];
                                            ?>
                </td>
                <td align="left" class="<?php echo $cellStyle ?>">
                                            <?php
                                            echo $rows["alamat"].', '.$rows["kelurahan"].', '.$rows["kecamatan"]; ?></td>
                <td align="center">
                                            <?php
                                            if ($rows["sertifikattgl"])
                                                echo date("d/m/Y",strtotime($rows["sertifikattgl"]));
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo $rows["suratsertifikat"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            switch ($rows["statushukum"]) {
                                                case 1 : echo "Tanah Pemda/Pemkot";
                                                    break;
                                                case 2 : echo "Tanah Negara";
                                                    break;
                                                case 3 : echo "Tanah Hak Ulayat";
                                                    break;
                                                case 4 : echo "Tanah Hak Milik";
                                                    break;
                                                case 5 : echo "Tanah Hak Guna Bangunan";
                                                    break;
                                                case 6 : echo "Tanah Hak Pakai";
                                                    break;
                                                case 7 : echo "Tanah Hak Pengelolaan";
                                                    break;
                                                case 8 : echo "Lainnya";
                                                    break;
                                                default : break;
                                            }
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo $rows["nokibtanah"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            switch ($rows["asalusul"]) {
                                                case 1 : echo "Pembelian";
                                                    break;
                                                case 2 : echo "Hibah";
                                                    break;
                                                case 3 : echo "dll";
                                                    break;
                                                default : echo "dll";
                                                    break;
                                            }
                                            ?>
                </td>
                <td align="right">
                                            <?php
                                            echo number_format($rows["hargasatuan"],0,",",".");
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            switch ($rows["keadaanalat"]) {
                                                case 1 : echo "B";
                                                    break;
                                                case 2 : echo "KB";
                                                    break;
                                                case 3 : echo "RB";
                                                    break;
                                                case 4 : echo "TB";
                                                    break;
                                            }
                                            ?>
                </td>
                <td align="left">
                                            <?php
                                            echo $rows["ket"];
                                            ?>
                </td>
            </tr>
                                    <?php
                                } // end while
                                ?>
            <tr>
                <td class="HeaderBW" colspan="2">&nbsp;</td>
                <td class="HeaderBW" colspan="12" align="left">J U M L A H ................................................................</td>
                <td align="right" class="HeaderBW"><?php echo number_format($totalharga,0,",","."); ?></td>
                <td class="HeaderBW" colspan="2">&nbsp;</td>
            </tr>
        </table>
        <br />
        <br />
        <table border=0 cellspacing="0" cellpadding="0" width="1300">
            <tr>
                <td align="center"><strong>MENGETAHUI<br />KEPALA SKPD<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
                <td width="100">&nbsp;</td>

                <td align="center"><strong>.........................,.........................................<br />PENGURUS BARANG<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
            </tr>
        </table><br /><br /><br /><br />
                            <?php
                        } // end

                        break;
                    case "E" :		// KIB - ASET TETAP LAINNYA
					?>
                         <table border=0 width="1300">
                            <tr>
                                <td width="970" ><strong>No. Kode Lokasi</strong></td>
                                <td >:</td>
                                <td>
                                    <strong>
                                        <?php echo $r_kodeunit; ?> - <?php echo $rowsUnit["namaunit"]; ?>
                                    </strong>
                                </td>
                            </tr>
                         </table>
        <br />
        <table border=1 cellspacing="0" cellpadding="4" class="GridStyle" width="1300">
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td rowspan="2"><font size="-2"><br />No</font></td>
                <td rowspan="2"><font size="-2">Nama Barang<br />(Jenis Barang)</font></td>
                <td height="10" colspan="2"><font size="-2">Nomor</font></td>
                <td height="10" colspan="2"><font size="-2">Buku/Perpustakaan</font></td>
                <td height="10" colspan="3"><font size="-2">Barang Bercorak Kesenian/Kebudayaan</font></td>
                <td height="10" colspan="2"><font size="-2">Hewan/Ternak dan Tumbuhan</font></td>
                <td rowspan="2"><font size="-2"><br />Jumlah</font></td>
                <td rowspan="2"><font size="-2">Tahun Cetak<br />Pembelian</font></td>
                <td rowspan="2"><font size="-2">Asal Usul<br />Cara Perolehan</font></td>
                <td width="110" rowspan="2"><font size="-2"><br />
                        Harga</font></td>
                <td rowspan="2"><font size="-2"><br />Keterangan</font></td>
            </tr>
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td height="10"><font size="-2">Kode Barang</font></td>
                <td height="10"><font size="-2">Register</font></td>
                <td height="10"><font size="-2">Judul/Pencipta</font></td>
                <td height="10"><font size="-2">Spesifikasi</font></td>
                <td height="10"><font size="-2">Asal Daerah</font></td>
                <td height="10"><font size="-2">Pencipta</font></td>
                <td height="10"><font size="-2">Bahan</font></td>
                <td height="10"><font size="-2">Jenis</font></td>
                <td height="10"><font size="-2">Ukuran</font></td>
            </tr>
            <tr align="center" valign="top" bgcolor="#FFFFCC" class="SubHeaderBW">
                <td height="10"><font size="-2">1</font></td>
                <td height="10"><font size="-2">2</font></td>
                <td height="10"><font size="-2">3</font></td>
                <td height="10"><font size="-2">4</font></td>
                <td height="10"><font size="-2">5</font></td>
                <td height="10"><font size="-2">6</font></td>
                <td height="10"><font size="-2">7</font></td>
                <td height="10"><font size="-2">8</font></td>
                <td height="10"><font size="-2">9</font></td>
                <td height="10"><font size="-2">10</font></td>
                <td height="10"><font size="-2">11</font></td>
                <td height="10"><font size="-2">12</font></td>
                <td height="10"><font size="-2">13</font></td>
                <td height="10"><font size="-2">14</font></td>
                <td height="10"><font size="-2">15</font></td>
                <td height="10"><font size="-2">16</font></td>
            </tr>
                                <?php
                        $strSQL="select kodeunit,namapanjang,namabarang,kodebarang,noseri,judul,k.spesifikasi,asaldaerah,pencipta,bahan,jenisbarang,k.ukuran,ukuran_satuan,tgltransaksi,tahunperolehan,caraperolehan as asalusul,hargasatuan,catpengisi as ket from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit inner join as_kib k on t.idtransaksi=k.idtransaksi inner join as_ms_barang b on t.idbarang=b.idbarang inner join as_seri s on t.idtransaksi=s.idtransaksi where t.idunit=$r_idunit and substring(kodebarang,1,3)='05.' and $flt and b.tipe=1 order by id_kib,noseri";
                        $rs = mysql_query($strSQL);
                        if(mysql_affected_rows() > 0) {
                            
                                // Iterating through record
                                $j = 0;
                                $totalharga=0;
                                while($rows = mysql_fetch_array($rs)) {
                                    if ($j % 2) $rowStyle = "NormalBG";  else $rowStyle = "AlternateBG";
                                    $j++;
                                    $totalharga +=$rows["hargasatuan"];
                                    ?>
            <tr class="<?php echo $rowStyle ?>" valign="top">
                <td align="center">
                                            <?php
                                            echo $j;
                                            ?>
                </td>
                <td align="left">
                                            <?php
                                            echo $rows["namabarang"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo $rows["kodebarang"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo str_pad($rows["noseri"], 4, "0", STR_PAD_LEFT);
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo $rows["judul"];
                                            ?>
                </td>
                <td align="center"><font size=1>
                                                <?php
                                                echo $rows["spesifikasi"];
                                                ?>
                    </font></td>
                <td align="left" class="<?php echo $cellStyle ?>">
                                            <?php
                                            echo $rows["asaldaerah"];
                                            ?>
                </td>
                <td align="left" class="<?php echo $cellStyle ?>">
                                            <?php
                                            echo $rows["pencipta"];
                                            ?>
                </td>
                <td align="left" class="<?php echo $cellStyle ?>">
                                            <?php
                                            echo $rows["bahan"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo $rows["jenisbarang"];
                                            ?>
                </td>
                <td align="center">
                                            <?php echo $rows["ukuran"].' '.$rows["ukuran_satuan"]; ?>
                </td>
                <td align="center"> 1 </td>
                <td align="center">
                                            <?php
                                            echo substr($rows["tgltransaksi"],0,4);
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            switch ($rows["asalusul"]) {
                                                case 1 : echo "Pembelian";
                                                    break;
                                                case 2 : echo "Hibah";
                                                    break;
                                                case 3 : echo "dll";
                                                    break;
                                                default : echo "dll";
                                                    break;
                                            }
                                            ?>
                </td>
                <td align="right">
                                            <?php
                                            echo number_format($rows["hargasatuan"],0,",",".");
                                            ?>
                </td>
                <td align="left">
                                            <?php
                                            echo $rows["ket"];
                                            ?>
                </td>
            </tr>
                                    <?php
                                } // end while
                                ?>
            <tr>
                <td class="HeaderBW" colspan="2">&nbsp;</td>
                <td class="HeaderBW" colspan="12" align="left">J U M L A H ................................................................</td>
                <td align="right" class="HeaderBW"><?php echo number_format($totalharga,0,",","."); ?></td>
                <td class="HeaderBW">&nbsp;</td>
            </tr>
        </table>
        <br />
        <br />
        <table border=0 cellspacing="0" cellpadding="0" width="1300">
            <tr>
                <td align="center"><strong>MENGETAHUI<br />KEPALA SKPD<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
                <td width="100">&nbsp;</td>

                <td align="center"><strong>.........................,.........................................<br />PENGURUS BARANG<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
            </tr>
        </table><br /><br /><br /><br />
                            <?php
                        } // end

                        break;
                    case "F" :		// KIB - KONSTRUKSI DALAM PENGERJAAN
					?>
        <table border=0 width="1300">
            <tr>
                <td width="970" ><strong>No. Kode Lokasi</strong></td>
                <td >:</td>
                <td>
                    <strong>
                        <?php echo $r_kodeunit; ?> - <?php echo $rowsUnit["namaunit"]; ?>
                    </strong>
                </td>
            </tr>
        </table>
        <br />
        <table border=1 cellspacing="0" cellpadding="4" class="GridStyle" width="1300">
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td width="20" rowspan="2" valign="middle"><font size="-2">No</font></td>
                <td rowspan="2" valign="middle"><font size="-2">Jenis Barang<br />(Nama Barang)</font></td>
                <td width="50" rowspan="2" valign="middle"><font size="-2">Bangunan<br />
                        (P, SP, D)</font></td>
                <td height="10" colspan="2"><font size="-2">Konstruksi Bangunan</font></td>
                <td width="50" rowspan="2" valign="middle"><font size="-2">Luas<br />(M&sup2;)</font></td>
                <td width="90" rowspan="2" valign="middle"><font size="-2">Letak<br />/Lokasi Alamat</font></td>
                <td height="10" colspan="2" valign="middle"><font size="-2">Dokumen</font></td>
                <td width="70" rowspan="2" valign="middle"><font size="-2">Tanggal Bangun</font></td>
                <td width="100" rowspan="2" valign="middle"><font size="-2">Status Tanah</font></td>
                <td width="94" rowspan="2" valign="middle"><font size="-2">Nomor<br />Kode Tanah</font></td>
                <td width="110" rowspan="2" valign="middle"><font size="-2">Asal-usul Pembiayaan</font></td>
                <td width="110" rowspan="2" valign="middle"><font size="-2">Nilai Kontrak<br />(Rp)</font></td>
                <td width="79" rowspan="2" valign="middle"><font size="-2">Ket</font></td>
            </tr>
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td width="60" height="10" valign="middle"><font size="-2">Bertingkat<br />/Tidak</font></td>
                <td width="50" height="10" valign="middle"><font size="-2">Beton<br />/Tidak</font></td>
                <td width="70" height="10" valign="middle"><font size="-2">Tanggal</font></td>
                <td width="90" height="10" valign="middle"><font size="-2">Nomor</font></td>
            </tr>
            <tr align="center" valign="top" bgcolor="#FFFFCC" class="SubHeaderBW">
                <td height="10"><font size="-2">1</font></td>
                <td height="10"><font size="-2">2</font></td>
                <td height="10"><font size="-2">3</font></td>
                <td height="10"><font size="-2">4</font></td>
                <td height="10"><font size="-2">5</font></td>
                <td height="10"><font size="-2">6</font></td>
                <td height="10"><font size="-2">7</font></td>
                <td height="10"><font size="-2">8</font></td>
                <td height="10"><font size="-2">9</font></td>
                <td height="10"><font size="-2">10</font></td>
                <td height="10"><font size="-2">11</font></td>
                <td height="10"><font size="-2">12</font></td>
                <td height="10"><font size="-2">13</font></td>
                <td height="10"><font size="-2">14</font></td>
                <td height="10"><font size="-2">15</font></td>
            </tr>
                                <?php
                       $strSQL="select kodeunit,namapanjang,namabarang,kodebarang,konskategori,jumlahlantai,konsrangka,konspondasi,luasbangunan,alamat,kelurahan,kecamatan,kotamadya,sertifikattgl,suratsertifikat,tglbangun,statushukum,nokibtanah,idsumberdana,hargasatuan,catpengisi as ket from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit inner join as_kib k on t.idtransaksi=k.idtransaksi inner join as_ms_barang b on t.idbarang=b.idbarang inner join as_seri s on t.idtransaksi=s.idtransaksi where t.idunit=$r_idunit and substring(kodebarang,1,3)='06.' and $flt and b.tipe=1 order by id_kib,noseri";
                        $rs = mysql_query($strSQL);
                        if(mysql_affected_rows() > 0) {
                                // Iterating through record
                                $j = 0;
                                $totalharga=0;
                                while($rows = mysql_fetch_array($rs)) {
                                    if ($j % 2) $rowStyle = "NormalBG";  else $rowStyle = "AlternateBG";
                                    $j++;
                                    $totalharga +=$rows["hargasatuan"];
                                    ?>
            <tr class="<?php echo $rowStyle ?>" valign="top">
                <td align="center">
                                            <?php
                                            echo $j;
                                            ?>
                </td>
                <td align="left">
                                            <?php
                                            echo $rows["namabarang"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            switch ($rows["konskategori"]) {
                                                case 1 : echo "P";
                                                    break;
                                                case 2 : echo "SP";
                                                    break;
                                                case 3 : echo "D";
                                                    break;
                                            }
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            if ($rows["jumlahlantai"]>1)
                                                echo "Bertingkat";
                                            else
                                                echo "Tidak"; ?>
                </td>
                <td align="center"><font size=1>
                                                <?php
                                                if ($rows["konsrangka"]==3 && $rows["konspondasi"]==1 )
                                                    echo "Beton";
                                                else
                                                    echo "Tidak";
                                                ?>
                    </font></td>
                <td align="center" valign="top" class="<?php echo $cellStyle ?>">
                                            <?php
                                            echo $rows["luasbangunan"];
                                            ?>
                </td>
                <td align="left" class="<?php echo $cellStyle ?>">
                                            <?php
                                            echo $rows["alamat"].', '.$rows["kelurahan"].', '.$rows["kecamatan"];
                                            ?>
                </td>
                <td align="center" class="<?php echo $cellStyle ?>">
                                            <?php
                                            if ($rows["sertifikattgl"])
                                                echo date("d/m/Y",strtotime($rows["sertifikattgl"]));
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo $rows["suratsertifikat"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            if ($rows["tglbangun"])
                                                echo date("d/m/Y",strtotime($rows["tglbangun"]));
                                            ?>
                </td>
                <td align="center">
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
                <td align="center">
                                            <?php
                                            echo $rows["nokibtanah"];
                                            ?>
                </td>
                <td align="center">
                                            <?php
                                            echo $rows["idsumberdana"];
                                            ?>
                </td>
                <td align="right">
                                            <?php
                                            echo number_format($rows["hargasatuan"],0,",",".");
                                            ?>
                </td>
                <td align="left">
                                            <?php
                                            echo $rows["ket"];
                                            ?>
                </td>
            </tr>
                                    <?php
                                } // end while
                                ?>
            <tr>
                <td class="HeaderBW" colspan="2">&nbsp;</td>
                <td class="HeaderBW" colspan="11" align="left">J U M L A H ................................................................</td>
                <td align="right" class="HeaderBW"><?php echo number_format($totalharga,0,",","."); ?></td>
                <td class="HeaderBW">&nbsp;</td>
            </tr>
        </table>
        <br />
        <br />
        <table border=0 cellspacing="0" cellpadding="0" width="1300">
            <tr>
                <td align="center"><strong>MENGETAHUI<br />KEPALA SKPD<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
                <td width="100">&nbsp;</td>

                <td align="center"><strong>.........................,.........................................<br />PENGURUS BARANG<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
            </tr>
        </table>
                            <?php
                        } // end

                        break;
                    default :
                        break;
                }
            }
        }
        ?>
    </body>
</html>
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
        break;
    case "WORD" :
        Header("Content-Type: application/msword");
        break;
    default :
        Header("Content-Type: text/html");
        break;
}

if (isset($_POST["submit"])) {
    $r_cmbperolehan = $_POST["cmbperolehan"];
	$idbarang = $_POST["idbarang"];
	$kodebarang = $_POST["kodebarang"];
	$namabarang = $_POST["namabarang"];
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
   // $r_idunit = $_POST["idunit"];
}
?>
<html>
    <head>
        <title>Laporan Kartu Stok</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="../theme/report.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <p align="center"><strong><font size="4" face="Times New Roman, Times, serif">Laporan Kartu Stok Barang</font><br />
                <font size="3" face="Times New Roman, Times, serif"><?php //echo $_POST['kategori_kib']; ?></font></strong>
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

            //if ($r_idunit=="0")
			// $strUnit="select idunit,kodeunit,namaunit,namapanjang from as_ms_unit where idunit<>0 order by kodeunit";
          /*  else $strUnit="select idunit,kodeunit,namaunit,namapanjang from as_ms_unit where idunit=$r_idunit or parentunit=$r_idunit or parentunit in (select idunit from as_ms_unit where parentunit=$r_idunit) order by kodeunit";*/
            //echo $strUnit;
           // $rsUnit = mysql_query($strUnit);
          //  while ($rowsUnit = mysql_fetch_array($rsUnit)) {
               // $r_idunit=$rowsUnit["idunit"];
                //	echo $rowsUnit["kodeunit"]."<br />";
              //  $r_kodeunit="";
              //   $r_kodeunit .=$rowsUnit["kodeunit"];
                //echo strlen($r_kodeunit);
                //echo $r_kodeunit;
             //   if (strlen($r_kodeunit)==2) $r_kodeunit .=".00.00";
             //   elseif (strlen($r_kodeunit)==5) $r_kodeunit .=".00";

                //$r_kodeunit="12.".$r_kodepropinsi.".".$r_kodepemda.".".substr($rowsUnit["kodeunit"],0,6).$th.substr($rowsUnit["kodeunit"],5,3);
              //  $r_kodeunit="12.".$r_kodepropinsi.".".$r_kodepemda.".".substr($r_kodeunit,0,6).$th.substr($r_kodeunit,5,3);
                //	echo $r_kodeunit;
                //switch (substr($_POST['kategori_kib'],0,1)) {
                   // case "A" :		// KIB - TANAH
					 ?>
	<table border=0 width="698">
	<tr>
	    <td colspan="3"><strong>Kode Barang</strong></td>
	    <td width="583" colspan="7">:
	    <strong><?php echo $kodebarang;?></strong>	</td>
	</tr>
	</table>
	<table width="698" border=0>
      <tr>
        <td colspan="3"><strong>Nama Barang</strong></td>
        <td width="583" colspan="7">: <strong><?php echo $namabarang;?></strong> </td>
      </tr>
    </table>
	<table width="698" border=0>
      <tr>
        <td colspan="3"><strong>Periode</strong></td>
        <td width="583" colspan="7">: <strong><?php echo date("d M Y",strtotime($r_tglawal));  ?> - <?php echo date("d M Y",strtotime($r_tglakhir));  ?></strong> </td>
      </tr>
    </table>
	<br />
                                 
<table border=1 cellspacing="0" cellpadding="4" class="GridStyle" width="1000%">
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td width="32" rowspan="2">
                    <font size="-2"><br />
                        No</font>                </td>
                <td width="148" rowspan="2">
                    <font size="-2"><br />
                    Waktu</font>                </td>
                <td height="22" colspan="4">
                    <font size="-2">Stok</font></td>
                <td height="22" colspan="4"><font size="-2">Nilai</font></td>
                <td width="110" rowspan="2">
                    <font size="-2"><br />
                        Keterangan</font>                </td>
            </tr>
            
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
              <td width="67"><font size="-2">Awal</font></td>
              <td width="67"><font size="-2">Masuk</font></td>
              <td width="86"><font size="-2">Keluar</font></td>
              <td width="67"><font size="-2">Sisa</font></td>
              <td width="82"><font size="-2">Awal</font></td>
              <td width="82"><font size="-2">Masuk</font></td>
              <td width="82"><font size="-2">Keluarl</font></td>
              <td width="63"><font size="-2">Akhir</font></td>
            </tr>
            <tr align="center" valign="top" bgcolor="#FFFFCC" class="SubHeaderBW">
                <td height="10"><font size="-2">1</font></td>
                <td height="10"><font size="-2">2</font></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td height="10"><font size="-2">3</font></td>
                <td height="10"><font size="-2">4</font></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td height="10"><font size="-2">5</font></td>
              <td height="10"><font size="-2">6</font></td>
                <td height="10"><font size="-2">7</font></td>
            </tr>
			    <?php
                        $strSQL="select kodeunit,namapanjang,namabarang,kodebarang,noseri,luastanah,tgltransaksi,substring(tglperolehan,1,4) as thn_pengadaan,alamat,";
                        $strSQL .="statushukum,suratsertifikat,sertifikattgl,macampemanfaatan as penggunaan,caraperolehan as asalusul,hargasatuan,catpengisi as ket ";
                        $strSQL .="from as_ms_unit u inner join as_transaksi t on u.idunit=t.idunit ";
                        $strSQL .="inner join as_kib k on t.idtransaksi=k.idtransaksi inner join as_ms_barang b on t.idbarang=b.idbarang ";
                        $strSQL .="inner join as_seri s on t.idtransaksi=s.idtransaksi where substring(kodebarang,1,3)='01.' and $flt and t.idunit=$r_idunit and b.tipe=1 order by id_kib,noseri";
                         echo $strSQL."<br />";
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
                                            ?>                </td>
                <td align="left">
                                            <?php
                                            echo $rows["namabarang"];
                                            ?>                </td>
                <td align="center">&nbsp;</td>
                <td align="center">&nbsp;</td>
                <td align="center">
                                            <?php
                                            echo $rows["kodebarang"];
                                            ?>                </td>
                <td align="center">
                                            <?php
                                            echo str_pad($rows["noseri"], 4, "0", STR_PAD_LEFT);
                                            ?>                </td>
                <td align="center">&nbsp;</td>
                <td align="center">&nbsp;</td>
                <td align="center">
                                            <?php
                                            echo $rows["luastanah"];
                                            ?>                </td>
                <td align="center">
                    <font size=1>
                                                <?php
                                                echo substr($rows["tgltransaksi"],0,4);
                                                ?>
                    </font>                </td>
              <td align="left" class="<?php echo $cellStyle ?>"><div align="center">
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
              </div></td>
                
            </tr>
                                    <?php
                                } // end while
                                ?>
            <tr>
                <td class="HeaderBW" colspan="2">&nbsp;</td>
                <td class="HeaderBW" colspan="13" align="left">J U M L A H ................................................................</td>
            </tr>
    </table>
<br />
        <br />
        <table border=0 cellspacing="0" cellpadding="0" width="1057">
<tr>
                <td width="400" align="center"><strong>MENGETAHUI<br />
        KEPALA SKPD<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
        <td width="100">&nbsp;</td>

                <td width="802" align="center"><strong>.........................,.........................................<br />
        PENGURUS BARANG<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
          </tr>
        </table><br /><br /><br /><br />
                            <?php
                        } // end
                       // break;
                  //  case "B" :		// KIB - PERALATAN DAN MESIN
           // }
        }
        ?>
</body>
</html>
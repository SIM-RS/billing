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
    $r_tglawal = tglSQL($_POST["tglawal"]);
    $r_tglakhir = tglSQL($_POST["tglakhir"]);
}
?>
<html>
    <head>
        <title>Laporan Pengadaan Barang Pakai Habis</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="../theme/report.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <table width="405" border="0">
          <tr>
            <td width="133"><strong>SKPD</strong></td>
            <td width="180">: <strong>Rumah Sakit Umum Daerah</strong></td>
          </tr>
          <tr>
            <td><strong>KABUPATEN / KOTA</strong></td>
            <td>:<strong> Kabupaten Sidoarjo</strong></td>
          </tr>
          <tr>
            <td><strong>PROPINSI</strong></td>
            <td>:<strong> Jawa Timur</strong></td>
          </tr>
        </table>
<p align="center"><strong><font size="4" face="Times New Roman, Times, serif">LAPORAN PENGADAAN BARANG PAKAI HABIS</font><br />
                <font size="3" face="Times New Roman, Times, serif"><?php //echo $_POST['kategori_kib']; ?></font></strong>
            <?php
            //if ($r_cmbperolehan=="2") {
                ?>
            <br />
            <font size="3" face="Times New Roman, Times, serif">
                (<?php echo date("d M Y",strtotime($r_tglawal));  ?> - <?php echo date("d M Y",strtotime($r_tglakhir));  ?>)
            </font>
                <?php
            //}
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
        /*for ($jm=0;$jm<=$jmlth;$jm++) {
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
	}

            if ($r_idunit=="0") $strUnit="select idunit,kodeunit,namaunit,namapanjang from as_ms_unit where idunit<>0 order by kodeunit";
            else $strUnit="select idunit,kodeunit,namaunit,namapanjang from as_ms_unit where idunit=$r_idunit or parentunit=$r_idunit or parentunit in (select idunit from as_ms_unit where parentunit=$r_idunit) order by kodeunit";
            $strUnit;
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
                //switch (substr($_POST['kategori_kib'],0,1)) {
                   // case "A" :		// KIB - TANAH
				   */
					 ?>
	<table border=0 width="698">
	<!--tr>
	    <td colspan="3"><strong>No. Kode Lokasi</strong></td>
	    <td width="583" colspan="7">:
	    <strong>
		  <?php echo $r_kodeunit; ?>
			-
	<?php
		echo $rowsUnit["namaunit"];
	?>
	</strong>
	</td>
	</tr-->
	</table>
	<br />
                                 
        <table border=1 cellspacing="0" cellpadding="4" class="GridStyle" width="100%">
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td width="25" rowspan="2"><font size="-2"><br />No</font></td>
                <td width="150" rowspan="2"><font size="-2"><br />Jenis Barang yang di beli</font></td>
                <td height="22" colspan="2"><font size="-2">Kontrak Jual Beli / Surat Pesanan Perintah Kerja</font></td>
                <td height="22" colspan="2"><font size="-2">SKO / SPMU / KWITANSI</font></td>
                <td height="22" colspan="4"><font size="-2">Jumlah</font></td>
                <td rowspan="2"><font size="-2"><br />Dipergunakan Pada Unit</font></td>
                <td width="80" rowspan="2"><font size="-2"><br />Keterangan</font></td>
            </tr>
            
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
              <td width="75"><font size="-2">Tanggal</font></td>
              <td width="120"><font size="-2">Nomor</font></td>
              <td width="75"><font size="-2">Tanggal</font></td>
              <td width="120"><font size="-2">Nomor</font></td>
              <td width="75"><font size="-2">Banyaknya</font></td>
			  <td width="75"><font size="-2">Satuan</font></td>
              <td width="71" height="10"><font size="-2">Harga Satuan (Rp.)</font></td>
              <td width="82" height="10"><font size="-2">Jumlah Harga (Rp.)</font></td>
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
                <td height="10"><font size="-2">12</font></td>
		<td height="10"><font size="-2">13</font></td>
            </tr>
			    <?php
                            
						$strSQL="SELECT 
						brg.namabarang,
						po.jenis_surat,
						po.tgl_po,
						po.no_po,
						po.qty_satuan,
						po.satuan,
						po.harga_satuan,
						po.total,
						rek.namarekanan,
						IF(u.namaunit IS NULL,'-',u.namaunit) namaunit
						FROM as_po po
						INNER JOIN as_ms_barang brg
						ON brg.idbarang = po.ms_barang_id
						INNER JOIN as_ms_rekanan rek 
						ON rek.idrekanan = po.vendor_id
						LEFT JOIN as_ms_unit u 
						ON u.idunit=po.unit_id
						WHERE po.tgl_po BETWEEN '$r_tglawal' AND '$r_tglakhir' AND brg.tipe=2
						ORDER BY po.tgl_po,po.no_po,brg.namabarang";
                         //echo "<br>". $strSQL."<br />";
                        $rs = mysql_query($strSQL);
                        //if (mysql_affected_rows() > 0) { // Iterating through record
			   
                                $j = 0;
                                $totalharga=0;
                                $totalgeneral=0;
                                while ($rows = mysql_fetch_array($rs)) {
                                    if ($j % 2) $rowStyle = "NormalBG";  else $rowStyle = "AlternateBG";
                                    $j++;
                                    $totalharga +=$rows["total"];
                                    ?>
            <tr class="<?php echo $rowStyle ?>" valign="top">
                <td align="center"><?php echo $j;?></td>
                <td align="left"><?php
                                            echo $rows["namabarang"];
                                            ?>                </td>
                <td align="center">
                                            <?php
                                            echo $rows["tgl_po"];
                                            ?>                </td>
                <td align="center">
                                            <?php
                                            echo str_pad($rows["no_po"], 4, "0", STR_PAD_LEFT);
                                            ?>                </td>
                <td align="center">
                                            <?php
                                            echo '-';
                                            ?>                </td>
                <td align="center">
                    <font size=1>
                                                <?php
                                                echo '-';
												//echo substr($rows["no_faktur"],0,4);
                                                ?>
                    </font>                </td>
                <td align="left" class="<?php echo $cellStyle ?>"><div align="center"><font size=1>
                  								<?php
                                                echo $rows["qty_satuan"];
                                                ?>
              </font></div></td>
	      
                <td align="left" class="<?php echo $cellStyle ?>"><div align="center"><font size=1>
                  								<?php
                                                echo $rows["satuan"];
                                                ?>
              </font></div></td>
                <td align="right" class="<?php echo $cellStyle ?>"><font size=1>
                  <?php
                                                echo number_format($rows["harga_satuan"],0,'','.');
                                                ?>
                </font></td>
<td align="right" class="<?php echo $cellStyle ?>"><font size=1>
  <?php
                                                echo number_format($rows["total"],0,'','.');
                                                
                                                ?>
</font></td>
<td align="center">
                                            <?php
                                            echo $rows["namaunit"];
                                            ?></td>
                <td align="left">&nbsp;</td>
            </tr>
                                    <?php
                                    $totalgeneral +=$rows["harga_total"];
                                } // end while
                                ?>
            <tr>
                <td class="HeaderBW" colspan="2">&nbsp;</td>
                <td class="HeaderBW" colspan="7" align="left">J U M L A H ................................................................</td>
                <td align='right' class="HeaderBW">&nbsp;<?php echo number_format($totalharga,0,'','.');?></td>
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

                <td align="center"><strong>Sidoarjo,.........................................<br />PENGURUS BARANG<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
            </tr>
        </table><br /><br /><br /><br />
                            <?php
                        //} // end
                       // break;
                  //  case "B" :		// KIB - PERALATAN DAN MESIN
            //}
        //}
        ?>
    </body>
</html>
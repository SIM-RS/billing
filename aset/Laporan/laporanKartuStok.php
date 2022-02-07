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
    //$r_cmbperolehan = $_POST["cmbperolehan"];
	$idbarang = $_POST["idbarang"];
	$kodebarang = $_POST["kodebarang"];
	$namabarang = $_POST["namabarang"];
    
 
/*    if ($r_cmbperolehan=="1") {
        $strTGL="SELECT waktu,jml_awal,jml_masuk,jml_keluar,jml_sisa,nilai_awal,nilai_masuk,
        nilai_keluar,nilai_sisa,ket FROM as_kstok WHERE barang_id=$idbarang";
        $rs = mysql_query($strTGL);
        //$rowTgl = mysql_fetch_array($rs);
        echo $rowTgl;
    }else {
        */
        $r_tglawal = tglSQL($_POST["tglawal"]);
        $r_tglakhir = tglSQL($_POST["tglakhir"]);
        $strTGL="SELECT waktu,jml_awal,jml_masuk,jml_keluar,jml_sisa,nilai_awal,nilai_masuk,
        nilai_keluar,nilai_sisa,ket FROM as_kstok WHERE barang_id=$idbarang AND DATE(waktu) 
        BETWEEN '$r_tglawal' AND '$r_tglakhir' ORDER BY waktu";
        $rs = mysql_query($strTGL);
		echo mysql_error();
        
      // echo $strTGL;
 //   }
    
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<title>LAPORAN KARTU STOK BARANG</title>
<style type="text/css">
<!--
.a {
	font-family: Arial, Helvetica, sans-serif;
}
.a {
	font-weight: bold;
	font-size: 16px;
}
.b {
	font-family: Arial, Helvetica, sans-serif;
}
b {
	font-weight: bold;
}
b {
	font-weight: bold;
}
b {
	font-weight: bold;
}
c {
	font-weight: bold;
}
.b {
	font-size: 24px;
}
b {
	font-weight: bold;
}
.b tr td {
	font-weight: bold;
}
.d {
	font-weight: bold;
	font-size: 18px;
}
.d {
	font-size: 16px;
}
-->
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<a  href='javascript:print(document)'>cetak
    
</a>
	<table  align="center">
        <tr>
            <br />
            <td class="b">
                KARTU STOK BARANG 
            </td>
        </tr>
        <tr>
            <td>
            <br />
            <br />
            </td>
        </tr>
        <tr>
            <table class="a">
                <tr>
                    <td>
                        Kode Barang
                    </td>
                    <td>&nbsp;&nbsp;:</td>
                    <td> 
                        <?php echo $kodebarang;?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Nama Barang
                    </td>
                    <td>&nbsp;&nbsp;:</td>
                    <td>
                        <?php echo $namabarang; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Periode
                    </td>
                    <td>&nbsp;&nbsp;:</td>
                    <td><?php echo tglSQL($r_tglawal); ?>&nbsp; s/d &nbsp;<?php echo tglSQL($r_tglakhir); ?></td>
                </tr>
            </table>
        </tr>
        <tr>
            <br />
        </tr>
    </table>
    <table border="0" cellpadding="1" cellspacing="0" width="1102" align="center" class="d">
        <tr>
            <td width="1100">
                <table width="1248" border="1" cellspacing="0" >
                    <tr>
                      <td width="38" rowspan="2">
                          <center>
                            No
                      </center></td>
                      <td width="138" rowspan="2">
                          <center>
                            Waktu
                      </center></td>
                      <td class="d" colspan="5"><div align="center">Jumlah Stok</div></td>
                      <td colspan="5"><div align="center">Nilai</div></td>
                      <td width="110" rowspan="2"><div align="center">Keterangan </div></td>
                    </tr>
                    <tr>
                      <td width="60"><div align="center">awal </div></td>
                      <td width="60"><div align="center">masuk</div></td>
                      <td width="60"><div align="center">koreksi</div></td>
                      <td width="60"><div align="center">keluar</div></td>
                      <td width="60"><div align="center">sisa </div></td>
                      <td width="60"><div align="center">awal</div></td>
                      <td width="60"><div align="center">masuk</div></td>
                      <td width="60"><div align="center">keluar</div></td>
					  <td width="60"><div align="center">koreksi</div></td>
                      <td width="60"><div align="center">sisa</div></td>
                    </tr>
					</table>
					<div style=" 
 left:100px;
 top:100px; 
 width:1250px;
 height:300px;
 background-color:#ffffff;
 overflow:auto;">
<table width="1233" border="1" cellspacing="0">
					<?php
                        $i=1;
                        //echo $strTGL;
                        $jmlSawal=0;
						$jmlSmasuk=0;
						$jmlSkeluar=0;
						$jmlSsisa=0;
						$jmlNawal=0;
						$jmlNmasuk=0;
						$jmlNkeluar=0;
						$jmlNsisa=0;
                        while ($rowTgl = mysql_fetch_array($rs)){                                                                        
						$jmlSawal+=$rowTgl["jml_awal"];
						$jmlSmasuk+=$rowTgl["jml_masuk"];
						$jmlSkeluar+=$rowTgl["jml_keluar"];
						$jmlSsisa+=$rowTgl["jml_sisa"];
						$jmlNawal+=$rowTgl["nilai_awal"];
						$jmlNmasuk+=$rowTgl["nilai_masuk"];
						$jmlNkeluar+=$rowTgl["nilai_keluar"];
						$jmlNsisa+=$rowTgl["nilai_sisa"];

					?>
					
                    <tr>
                      <td width="38" align="center"><?=$i++; ?></td>
                      <td width="138" align="center"><? $tg= explode(" ",$rowTgl["waktu"]); $tglData=$tg[0]; echo tglSQL($tglData); ?></td>
                      <td width="60"><center><?=number_format($rowTgl["jml_awal"],0,'.','.'); ?></center></td>
                      <td width="60"><center><?=number_format($rowTgl["jml_masuk"],0,'.','.'); ?></center></td>
                      <td width="60"><center><?=number_format($rowTgl["jml_keluar"],0,'.','.'); ?></center></td>
					  <td width="60"><center><?="&nbsp;"?></center></td>
                      <td width="60"><center><?=number_format($rowTgl["jml_sisa"],0,'.','.'); ?></center></td>
                      <td width="60"><center><?=number_format($rowTgl["nilai_awal"],0,'.','.'); ?></center></td>
                      <td width="60"><center><?=number_format($rowTgl["nilai_masuk"],0,'.','.'); ?></center></td>
                      <td width="60"><center><?=number_format($rowTgl["nilai_keluar"],0,'.','.'); ?></center></td>
					  <td width="60"><center><?="&nbsp;"?></center></td>
                      <td width="60"><center><?=number_format($rowTgl["nilai_sisa"],0,'.','.'); ?></center></td>
                      <td width="60"><center><?=$rowTgl["ket"]; ?></center></td>
                    </tr>
				
                    <?php } ?>
              </table>


</div>		
<table width="1233" border="1" cellspacing="0">
                    <tr>
                      <td width="38" align="center" style="border-right:0px"></td>
                      <td width="138" align="center" style="border-left:0px">Jumlah</td>
                      <td width="60"><center><?php //number_format($jmlSawal,0,'.','.'); ?></center></td>
                      <td width="60"><center><?=number_format($jmlSmasuk,0,'.','.'); ?></center></td>
                      <td width="60"><center><?=number_format($jmlSkeluar,0,'.','.'); ?></center></td>
					  <td width="60"><center><?="&nbsp;"?></center></td>
                      <td width="60"><center><?php //number_format($jmlSsisa,0,'.','.'); ?></center></td>
                      <td width="60"><center><?php //number_format($jmlNawal,0,'.','.'); ?></center></td>
                      <td width="60"><center><?=number_format($jmlNmasuk,0,'.','.'); ?></center></td>
                      <td width="60"><center><?=number_format($jmlNkeluar,0,'.','.'); ?></center></td>
					  <td width="60"><center><?="&nbsp;"?></center></td>
                      <td width="60"><center><?php //number_format($jmlNsisa,0,'.','.'); ?></center></td>
                      <td width="60"><center><?=$rowTgl["ket"]; ?></center></td>
                    </tr>
              </table>	  
          </td>
        </tr>
</table>
</body>
</html>

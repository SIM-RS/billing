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
		header('Content-Disposition: attachment; filename="KartuStok_'.date('d-m-Y').'.xls"');
        break;
    case "WORD" :
        Header("Content-Type: application/msword");
		header('Content-Disposition: attachment; filename="KartuStok_'.date('d-m-Y').'.doc"');
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
        $strTGL="SELECT * /* waktu,jml_awal,jml_masuk,jml_keluar,jml_sisa,nilai_awal,nilai_masuk,
        nilai_keluar,nilai_sisa,ket,koreksi */ FROM as_kstok WHERE barang_id=$idbarang AND DATE(waktu) 
        BETWEEN '$r_tglawal' AND '$r_tglakhir' ORDER BY waktu ASC, stok_id ASC";
		//echo $strTGL;
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
	<style type="text/css">
		#KartuStok{
			border:1px solid #000;
			border-collapse: collapse;
			border-spacing: 0;
			width:100%;
		}
		#KartuStok thead{
			font-weight:bold;
			text-align:center;
		}
		#KartuStok tbody{
		}
		#KartuStok td{
			padding:3px;
			border:1px solid #000;
		}
	</style>
	<table id="KartuStok">
		<thead>
			<tr>
				<td width="38" rowspan="2">No</td>
				<td width="60" rowspan="2">Waktu</td>
				<td colspan="5">Jumlah Stok</div></td>
				<td colspan="5">Nilai</div></td>
				<td width="200" rowspan="2">Keterangan </div></td>
			</tr>
			<tr>
				<td width="50">awal</td>
				<td width="50">masuk</td>
				<td width="50">koreksi</td>
				<td width="50">keluar</td>
				<td width="50">sisa </td>
				<td width="50">awal</td>
				<td width="50">masuk</td>
				<td width="50">koreksi</td>
				<td width="50">keluar</td>
				<td width="50">sisa</td>
			</tr>
		</thead>
		<tbody>
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
				<td width="60" align="center"><? $tg= explode(" ",$rowTgl["waktu"]); $tglData=$tg[0]; echo tglSQL($tglData); ?></td>
				<td width="60" align="center"><?=number_format($rowTgl["jml_awal"],0,'.','.'); ?></td>
				<td width="60" align="center"><?=number_format($rowTgl["jml_masuk"],0,'.','.'); ?></td>
				<td width="60" align="center"><?=$rowTgl["koreksi"]; ?></td>
				<td width="60" align="center"><?=number_format($rowTgl["jml_keluar"],0,'.','.'); ?></td>
				<td width="60" align="center"><?=number_format($rowTgl["jml_sisa"],0,'.','.'); ?></td>
				<td width="60" align="right"><?=number_format($rowTgl["nilai_awal"],0,'.','.'); ?></td>
				<td width="60" align="right"><?=number_format($rowTgl["nilai_masuk"],0,'.','.'); ?></td>
				<td width="60" align="center"><?=$rowTgl["koreksi"]; ?></td>
				<td width="60" align="right"><?=number_format($rowTgl["nilai_keluar"],0,'.','.'); ?></td>
				<td width="60" align="right"><?=number_format($rowTgl["nilai_sisa"],0,'.','.'); ?></td>
				<td width="60" align="left"><?=$rowTgl["ket"]; ?></td>
			</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<td width="138" align="right" colspan="2">Jumlah</td>
				<td width="60" align="center"><?php //number_format($jmlSawal,0,'.','.'); ?></td>
				<td width="60" align="center"><?=number_format($jmlSmasuk,0,'.','.'); ?></td>
				<td width="60" align="center"><?="&nbsp;"?></td>
				<td width="60" align="center"><?=number_format($jmlSkeluar,0,'.','.'); ?></td>
				<td width="60" align="center"><?php //number_format($jmlSsisa,0,'.','.'); ?></td>
				<td width="60" align="center"><?php //number_format($jmlNawal,0,'.','.'); ?></td>
				<td width="60" align="right"><?=number_format($jmlNmasuk,0,'.','.'); ?></td>
				<td width="60" align="center"><?="&nbsp;"?></td>
				<td width="60" align="right"><?=number_format($jmlNkeluar,0,'.','.'); ?></td>
				<td width="60" align="center"><?="&nbsp;"?></td>
				<td width="60" align="left"><?=$rowTgl["ket"]; ?></td>
			</tr>
		</tfoot>
	</table>
</body>
</html>

<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("G:i:s");
$userId = $_REQUEST['userId'];
$loketId = $_REQUEST['loketId'];
/*$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = $userId";
$rsPeg = mysql_query($sqlPeg);
$rwPeg = mysql_fetch_array($rsPeg);*/
?>
<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--head>
<title>Loket</title>
<link type="text/css" rel="stylesheet" href="../theme/print.css">
</head-->
<body onLoad="cetak(document.getElementById('trTombol'));">
<table border="0" cellpadding="2" cellspacing="2" width="6cm" height="4cm" align="left" class="kwi">
    <tr>
        <td width="133">&nbsp;</td>
        <td width="169">&nbsp;</td>
        <td width="67">&nbsp;</td>
        <td width="200">&nbsp;</td>
    </tr>
    <!--tr>
        <td colspan="4" style="border-bottom:1px solid; font-family: verdana">
            <b>
                <?=$pemkabRS?><br>
                <?=$namaRS?><br>
                <?=$alamatRS?><br>
                Telepon <?=$tlpRS?>
            </b>
        </td>
    </tr-->
    <?php
    $sql1 = "SELECT p.no_rm, k.no_billing, p.nama, CONCAT(p.alamat,', ', bmu.nama) AS alamat, k.unit_id, u.nama AS namaunit, date_format(k.tgl,'%d-%m-%Y') as tgl, k.kso_id, kso.nama AS status, k.id, p.rt, p.rw,  bp.no_antrian, k.tgl, DATE_FORMAT(k.tgl_act, '%d-%m-%Y') AS tgl_new, DATE_FORMAT(k.tgl_act, '%k:%i:%s') AS jam_new, bmp.nama AS nm_input, DATE_FORMAT(p.tgl_lahir, '%d-%m-%Y') AS tgl_lahir
                FROM b_ms_pasien p
                INNER JOIN b_kunjungan k ON k.pasien_id = p.id
				INNER JOIN b_pelayanan bp ON bp.kunjungan_id = k.id 
                INNER JOIN b_ms_unit u ON u.id = k.unit_id
                INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
				INNER JOIN b_ms_pegawai bmp ON k.user_act = bmp.id
				INNER JOIN b_ms_wilayah bmu ON k.kec_id = bmu.id
				INNER JOIN b_ms_wilayah bmu1 ON k.kab_id = bmu1.id
                WHERE k.id = '".$_REQUEST['idKunj']."'";
	//echo $sql1."<br>";
    $rs1 = mysql_query($sql1);
    $rw1 = mysql_fetch_array($rs1);
	
    $sql1 = "SELECT mp.nama FROM b_pelayanan p INNER JOIN b_ms_pegawai mp ON p.dokter_tujuan_id=mp.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND p.unit_id='".$rw1["unit_id"]."'";
	//echo $sql1."<br>";
    $rs2 = mysql_query($sql1);
    $rw2 = mysql_fetch_array($rs2);
    ?>
   <!-- <tr>
        <td style="font-size:10px; font-weight: bold; font-family: verdana;">No Registrasi</td>
        <td style="font-size:10px; font-weight: bold; font-family: verdana;" colspan="3">:&nbsp;<?php echo $rw1['no_antrian'];?></td>
        <!--<td style="font-size:10px; font-family: verdana;">&nbsp;</td>
        <td style="font-size:10px; font-family: verdana;">&nbsp;</td>-->
    <!-- </tr>
    <tr>
        <td style="font-size:10px; font-weight: bold; font-family: verdana;">NRM</td>
        <td style="font-size:10px; font-weight: bold; font-family: verdana;" colspan="3">:&nbsp;<?php echo $rw1['no_rm'];?></td>
       <!-- <td style="font-size:10px; font-family: verdana;">&nbsp;</td>
        <td style="font-size:10px; font-family: verdana;">&nbsp;</td>-->
     <!--</tr>
    <tr>
        <td style="font-size:10px; font-family: verdana; font-weight: bold">Nama</td>
        <td colspan="3" style="text-transform:uppercase; font-family: verdana; font-size:13px; font-weight: bold">:&nbsp;<?php echo $rw1['nama'];?></td>
    </tr>
    <!--tr>
        <td style="font-size:10px; font-family: verdana">Alamat</td>
        <td colspan="3" style="text-transform:uppercase; font-family: verdana; font-size:10px">:&nbsp;<?php echo $rw1['alamat'];?>&nbsp;rt <?php echo $rw1['rt'];?>&nbsp;rw <?php echo $rw1['rw'];?></td>
    </tr-->
     <!--<tr>
        <td style="font-size:10px; font-weight:bold; font-family: verdana">Kunjungan</td>
        <td colspan="3" style="font-size:12px; font-weight:bold; font-family: verdana">:&nbsp;<?php echo $rw1['namaunit'];?></td>
        <!--<td>&nbsp;</td>-->
    <!-- </tr>
    <tr>
        <td style="font-size:10px; font-weight:bold; font-family: verdana">Dokter</td>
        <td colspan="3" style="font-size:12px; font-weight:bold; font-family: verdana">:&nbsp;<?php echo $rw2['nama'];?></td>
      <!--  <td>&nbsp;</td>-->
    <!-- </tr>
    <tr>
        <td style="font-size:10px; font-weight:bold; font-family: verdana">Tanggal</td>
        <td colspan="3" style="font-size:12px; font-weight:bold; font-family: verdana">:&nbsp;<?php echo $rw1['tgl_new'];?></td>
       <!-- <td>&nbsp;</td>-->
     <!--</tr>
    <tr>
        <td style="font-size:10px; font-weight:bold; font-family: verdana">Jam</td>
        <td colspan="3" style="font-size:12px; font-weight:bold; font-family: verdana">:&nbsp;<?php echo $rw1['jam_new'];?></td>
        <!--<td>&nbsp;</td>-->
     <!--</tr>
    <tr>
        <td style="font-size:10px; font-weight:bold; font-family: verdana">Petugas Input</td>
        <td colspan="3" style="font-size:12px; font-weight:bold; font-family: verdana">:&nbsp;<?php echo $rw1['nm_input'];?></td>
        <!--<td>&nbsp;</td>-->
    <!-- </tr>
    <tr>
        <td colspan="4"><img src="../../barcode/create.php?norm=<?php echo $rw1['no_rm'];?>" /></td>
    </tr>-->
    <tr>
        <td colspan="4" style="font-size:9px;" align="center"><?php echo $rw1['no_rm'];?></td>
    </tr>
    <tr>
        <td colspan="4" align="center" style="font-size:9px;"><b><?php echo $rw1['nama'];?></b></td>
    </tr>
    <tr>
        <td colspan="4" align="center" style="font-size:9px;"><?php echo $rw1['tgl_lahir'];?></td>
    </tr>
    <tr>
        <td colspan="4" align="center" style="font-size:9px;"><?php echo $rw1['alamat'];?></td>
    </tr>
    <tr>
        <td colspan="4" align="center"><img width="100mm" src="../../barcode/create.php?norm=<?php echo $rw1['no_rm'];?>" /></td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr id="trTombol">
        <td colspan="4" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr>
</table>
</body>
<script type="text/JavaScript">
    // define progress listener object
    /*var progressListener = {
	stateIsRequest:false,
	QueryInterface : function(aIID) {
	    if (aIID.equals(Components.interfaces.nsIWebProgressListener) ||
	    aIID.equals(Components.interfaces.nsISupportsWeakReference) ||
	    aIID.equals(Components.interfaces.nsISupports))
	    return this;
	    throw Components.results.NS_NOINTERFACE;
	},
	onStateChange : function(aWebProgress, aRequest, aStateFlags, aStatus) {
	alert('State Change -> State Flags:'+aStateFlags+' Status:'+aStatus);
	return 0;
	},
	onLocationChange : function(aWebProgress, aRequest, aLocation) {
	return 0;
	},
	onProgressChange : function(aWebProgress, aRequest,
	aCurSelfProgress, aMaxSelfProgress,
	aCurTotalProgress, aMaxTotalProgress){
	alert('Self Current:'+aCurSelfProgress+' Self Max:'+aMaxSelfProgress
	+' Total Current:'+aCurTotalProgress+' Total Max:'+aMaxTotalProgress);
	},
	onStatusChange : function(aWebProgress, aRequest, aStateFlags, aStatus) {
	alert('Status Change -> State Flags:'+aStateFlags+' Status:'+aStatus);
	},
	onSecurityChange : function(aWebProgress, aRequest, aState){}
	// onLinkIconAvailable : function(a){}
    };
*/
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
            /*if(confirm('Anda yakin mau mencetak Kwitansi ini?')){
		// set portrait orientation
		jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
		// set top margins in millimeters
		jsPrintSetup.setOption('marginTop', 15);
		jsPrintSetup.setOption('marginBottom', 15);
		jsPrintSetup.setOption('marginLeft', 20);
		jsPrintSetup.setOption('marginRight', 10);
		// set page header
		jsPrintSetup.setOption('headerStrLeft', 'My custom header');
		jsPrintSetup.setOption('headerStrCenter', '');
		jsPrintSetup.setOption('headerStrRight', '&PT');
		// set empty page footer
		jsPrintSetup.setOption('footerStrLeft', '');
		jsPrintSetup.setOption('footerStrCenter', '');
		jsPrintSetup.setOption('footerStrRight', '');
		// clears user preferences always silent print value
		// to enable using 'printSilent' option
		jsPrintSetup.clearSilentPrint();
		// Suppress print dialog (for this context only)
		jsPrintSetup.setOption('printSilent', 1);
		// Do Print
		// When print is submitted it is executed asynchronous and
		// script flow continues after print independently of completetion of print process!
		
		// next commands

		jsPrintSetup.setPrinter('EPSON LX-300+ /II');
		//jsPrintSetup.setPrinter('PDF Complete');
		//jsPrintSetup.setPrintProgressListener(progressListener);
		jsPrintSetup.setSilentPrint(true);
		jsPrintSetup.print();
		jsPrintSetup.setSilentPrint(false);
		window.close();
            }
            else{
                tombol.style.visibility='visible';
            }*/
                window.print();
                window.close();
        }
    }
</script>
</html>
<?php 
mysql_close($konek);
?>

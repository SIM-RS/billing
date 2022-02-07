<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("G:i:s");
$userId = $_REQUEST['userId'];
$loketId = $_REQUEST['loketId'];
$idPas = $_REQUEST['idPas'];
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
<body onLoad="">
<table border="0" cellpadding="2" cellspacing="2" width="300" height="4cm" align="left" class="kwi">
    <?php
    $sql1 = "SELECT p.no_rm, p.nama, CONCAT(p.alamat,', ', bmu.nama) AS alamat, p.rt, p.rw,p.tgl_lahir
			FROM b_ms_pasien p
			INNER JOIN b_kunjungan k ON k.pasien_id = p.id
			INNER JOIN b_ms_wilayah bmu ON p.kec_id = bmu.id
			INNER JOIN b_ms_wilayah bmu1 ON p.kab_id = bmu1.id
			  WHERE k.id = '".$_REQUEST['idKunj']."'";
	//echo $sql1."<br>";/*WHERE p.id = '".$idPas."'";*/
    $rs1 = mysql_query($sql1);
    $rw1 = mysql_fetch_array($rs1);
	
    /*$sql1 = "SELECT mp.nama FROM b_pelayanan p INNER JOIN b_ms_pegawai mp ON p.dokter_tujuan_id=mp.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND p.unit_id='".$rw1["unit_id"]."'";
	//echo $sql1."<br>";
    $rs2 = mysql_query($sql1);
    $rw2 = mysql_fetch_array($rs2);*/
    ?>
    <tr>
        <td colspan="4" style="font-size:9px;" align="left"><b><?php echo $rw1['no_rm'];?></b></td>
        <td rowspan="4"><img width="140mm" src="../../barcode/create.php?norm=<?php echo $rw1['no_rm'];?>" /></td>
    </tr>
    <tr>
        <td colspan="4" width="200" align="left" style="font-size:9px;"><b><?php echo $rw1['nama'];?></b></td>
    </tr>
    <tr>
        <td colspan="4" align="left" style="font-size:9px;"><b><?php echo $rw1['tgl_lahir'];?></b></td>
    </tr>
    <tr>
        <!-- <td colspan="4" align="left" style="font-size:12px;"><?php echo $rw1['alamat'];?></td> -->
    </tr>
    <tr>
       
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
		var tmpShrinkToFit;
        tombol.style.visibility='collapse';
        /*if(tombol.style.visibility=='collapse'){
			//if(confirm('Anda yakin mau mencetak Kwitansi ini?')){*/
			try{
				// set portrait orientation
				//jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
				// set top margins in millimeters
				jsPrintSetup.setOption('marginTop', 0);
				jsPrintSetup.setOption('marginBottom', 0);
				jsPrintSetup.setOption('marginLeft', 0);
				jsPrintSetup.setOption('marginRight', 0);
				// set page header
				jsPrintSetup.setOption('headerStrLeft', '');
				jsPrintSetup.setOption('headerStrCenter', '');
				jsPrintSetup.setOption('headerStrRight', '');
				// set empty page footer
				jsPrintSetup.setOption('footerStrLeft', '');
				jsPrintSetup.setOption('footerStrCenter', '');
				jsPrintSetup.setOption('footerStrRight', '');
    
				//jsPrintSetup.setOption('paperHeight','4');
				//jsPrintSetup.setOption('paperWidth','5');
				// clears user preferences always silent print value
				// to enable using 'printSilent' option
				jsPrintSetup.clearSilentPrint();
				jsPrintSetup.setOption('printSilent', 0);
				// Suppress print dialog (for this context only)
				//jsPrintSetup.setOption('printSilent', 1);
				// Do Print
				// When print is submitted it is executed asynchronous and
				// script flow continues after print independently of completetion of print process!
				
				// next commands
				tmpShrinkToFit=jsPrintSetup.getOption('shrinkToFit');
				//alert(tmpShrinkToFit);
				jsPrintSetup.setOption('shrinkToFit','1');
		
				//jsPrintSetup.setPrinter('EPSON LX-300+ /II');
				//jsPrintSetup.setPrinter('PDF Complete');
				//jsPrintSetup.setPrintProgressListener(progressListener);
				//jsPrintSetup.setSilentPrint(true);
				jsPrintSetup.print();
				//alert(jsPrintSetup.getOption('shrinkToFit'));
				jsPrintSetup.setOption('shrinkToFit',tmpShrinkToFit);
				//alert(jsPrintSetup.getOption('shrinkToFit'));
				//jsPrintSetup.clearSilentPrint();
				window.close();
			//}else{
            //    tombol.style.visibility='visible';
            //}*/
			}catch(e){
				window.location='../addon/jsprintsetup-0.9.2.xpi';
                //window.print();
                //window.close();
			}
        //}
    }
</script>
</html>
<?php 
mysql_close($konek);
?>

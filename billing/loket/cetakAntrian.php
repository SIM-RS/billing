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
<title>Loket</title>
<link type="text/css" rel="stylesheet" href="../theme/print.css">
<table width="266" border="0" align="left" cellpadding="2" cellspacing="2" class="kwi">
    
    <tr>
      <td width="45" align="center" style="border-bottom:1px solid; font-size:12px; font-family: Arial, Helvetica, sans-serif"><img src="../images/logo.png" width="39" height="37" />                  </td>
      <td width="207" style="border-bottom:1px solid; font-weight:bold; font-size:13px; font-family: Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;<?=$namaRS?><br/><?=$alamatRS?>&nbsp;Belawan</td>
    </tr>
    <?php
    $sql1 = "SELECT p.no_rm, k.no_billing, p.nama, p.alamat, k.unit_id, u.nama AS namaunit, date_format(k.tgl_act,'%d-%m-%Y Jam : %h:%i') as tgl, k.kso_id, kso.nama AS status, k.id, p.rt, p.rw,pe.no_antrian,peg.nama as nama_peg, peg2.nama dokter
                FROM b_ms_pasien p
                INNER JOIN b_kunjungan k ON k.pasien_id = p.id
                INNER JOIN b_ms_unit u ON u.id = k.unit_id
                INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
				INNER JOIN b_pelayanan pe ON k.id = pe.kunjungan_id
				INNER JOIN b_ms_pegawai peg ON k.user_act=peg.id
				LEFT JOIN b_ms_pegawai peg2 on pe.dokter_tujuan_id=peg2.id
                WHERE k.id = '".$_REQUEST['idKunj']."'
				order by pe.id ASC";
	//echo $sql1."<br>";
    $rs1 = mysql_query($sql1);
    $rw1 = mysql_fetch_array($rs1);
    ?>
    <tr>
      <td style=" font-size:12px; font-weight:bold; font-family: Arial, Helvetica, sans-serif">Tgl</td>
      <td style="  font-size:12px; font-weight:bold; font-family: Arial, Helvetica, sans-serif">:&nbsp;<?php echo $rw1['tgl'];?></td>
    </tr>
    <tr>
        <td style="font-size:12px; font-weight:bold;  font-family: Arial, Helvetica, sans-serif;">No RM</td>
        <td style="font-size:12px; font-weight:bold; font-family: Arial, Helvetica, sans-serif;">:&nbsp;<?php echo $rw1['no_rm'];?></td>
    </tr>
    <tr>
        <td style="font-size:12px; font-weight:bold; font-family: Arial, Helvetica, sans-serif; ">Nama</td>
        <td style="text-transform:uppercase; font-weight:bold; font-family: Arial, Helvetica, sans-serif; font-size:13px; ">:&nbsp;<?php echo $rw1['nama'];?></td>
    </tr>
    <tr>
        <td style="font-size:12px; font-weight:bold; font-family: Arial, Helvetica, sans-serif">Dokter</td>
        <td style="text-transform:uppercase;  font-weight:bold; font-family: Arial, Helvetica, sans-serif; font-size:12px">:&nbsp;<?php echo $rw1['dokter'];?><!--<?php echo $rw1['alamat'];?>&nbsp;rt <?php echo $rw1['rt'];?>&nbsp;rw <?php echo $rw1['rw'];?>--></td>
    </tr>
    <tr>
        <td style="font-size:12px; font-weight:bold;  font-family: Arial, Helvetica, sans-serif">Klinik</td>
        <td style="font-size:12px; font-weight:bold;  font-family: Arial, Helvetica, sans-serif">:&nbsp;<?php echo $rw1['namaunit'];?></td>
    </tr>
 
    <tr>
      <td colspan="2" align="center" style=" border-bottom:1px solid; font-weight:bold; border-top:1px solid; border-left:1px solid; border-right:1px solid; solid; font-size:12px;  font-family: Arial, Helvetica, sans-serif"><?php echo $rw1['status'];?></td>
    </tr>
    <tr>
      <td colspan="2" align="center" style="font-size:15px; font-weight:bold; font-family: Arial, Helvetica, sans-serif">No Antrian : </td>
    </tr>
    <tr>
      <td colspan="2" align="center" style="font-size:60px; font-weight:bold; font-family: Arial, Helvetica, sans-serif"><?php echo (strlen($rw1['no_antrian'])==1)? '0'.$rw1['no_antrian'] : $rw1['no_antrian'];?></td>
    </tr>
	<tr>
      <td colspan="2" align="center" style="font-size:16px; border-bottom:1px dashed; font-weight:bold; font-family: Arial, Helvetica, sans-serif"><?php echo $rw1['namaunit'];?> </td>
    </tr>

    <!--tr>
        <td>&nbsp;</td>
        <td colspan="3" style="text-decoration:underline; font-family: Arial, Helvetica, sans-serif; font-size:10px; padding-right:50px" align="right">(<?php echo $rwKasir['nama']; ?>)</td>
    </tr-->
    <!--tr>
        <td>&nbsp;< ?php echo $jam;?></td>
        <td colspan="3" align="right">&nbsp;Operator&nbsp;&nbsp;&nbsp;< ?php echo $rwPeg['nama'];?></td>
    </tr-->
    <tr>
      <td colspan="2" style="border-bottom:1px dashed; font-weight:bold; font-size:13px; border-right:15px; font-family: Arial, Helvetica, sans-serif"  b><div align="justify">Bila nomor antrian anda terlewat, mohon menghubungi petugas Poliklinik untuk mendapatkan nomor antrian baru</div></td>
    </tr>
    <tr>
        <td colspan="2" style=" font-size:11px; font-weight:bold; font-family: Arial, Helvetica, sans-serif" align="center"><?php echo $rw1['nama_peg'];?> <br/><?php echo $rw1['tgl'];?>&nbsp;&nbsp;</td>
    </tr>
    <tr id="trTombol">
        <td colspan="2" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
</table>
<script type="text/JavaScript">
    // define progress listener object
    var progressListener = {
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
<?php 
mysql_close($konek);
?>

<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
include("../koneksi/konek.php");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("G:i:s");
$userId = $_GET['petugas'];
$tindakan_id = $_GET['tindakan_id'];
$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = $userId";
$rsPeg = mysql_query($sqlPeg);
$rwPeg = mysql_fetch_array($rsPeg);
?>
<title>Jasa Visite</title>
<link type="text/css" rel="stylesheet" href="../theme/print.css">
<table border="0" cellpadding="2" cellspacing="2" align="left" class="kwi">
    <tr>
        <td colspan="2" style="font-family: verdana; padding-top:30px;">
            <b>
                <?=$pemkabRS?><br>
                <?=$namaRS?><br>
                <?=$alamatRS?><br>
                Telepon <?=$tlpRS?>
            </b>
        </td>
    </tr>
    <?php
    $sql1 = "select no_rm,p.nama as nama_pasien, p.alamat as alamat_pasien, peg.nama as nama_dokter, uj.nama as jenis_layanan, ut.nama as tempat_layanan
            , date_format(t.tgl, '%d-%m-%y') as tgl, mt.nama as nama_tindakan, ke.nama as nama_kelas, t.biaya
            from b_tindakan t inner join b_pelayanan pe on t.pelayanan_id = pe.id
			inner join b_kunjungan k on pe.kunjungan_id = k.id
			inner join b_ms_tindakan_kelas tk on t.ms_tindakan_kelas_id = tk.id
            inner join b_ms_tindakan mt on tk.ms_tindakan_id = mt.id
            inner join b_ms_kelas ke on tk.ms_kelas_id = ke.id
            inner join b_ms_pasien p on k.pasien_id = p.id
            inner join b_ms_pegawai peg on t.user_id = peg.id
            inner join b_ms_unit uj on pe.jenis_layanan = uj.id
            inner join b_ms_unit ut on pe.unit_id = ut.id
            where t.id = '$tindakan_id'";
	//echo $sql1."<br>";
    $rs1 = mysql_query($sql1);
    $rw1 = mysql_fetch_array($rs1);
    ?>
    <tr>
        <td width="150" style="font-size:14px; font-weight: bold; font-family: verdana;">NRM</td>
        <td width="400" style="font-size:14px; font-weight: bold; font-family: verdana;">:&nbsp;<?php echo $rw1['no_rm'];?></td>
        <!--td style="font-size:10px; font-family: verdana;">No. Billing</td>
        <td style="font-size:10px; font-family: verdana;">:&nbsp;< ?php echo $rw1['no_billing'];?></td-->
    </tr>
    <tr>
        <td style="font-size:13px; font-family: verdana; font-weight: bold">Nama</td>
        <td style="text-transform:uppercase; font-family: verdana; font-size:13px; font-weight: bold">:&nbsp;
		<?php echo $rw1['nama_pasien'];?>
        </td>
    </tr>
    <tr>
        <td style="font-size:10px; font-family: verdana">Alamat</td>
        <td style="text-transform:uppercase; font-family: verdana; font-size:10px">:&nbsp;
        <?php echo $rw1['alamat_pasien'];?>
        <!--.'  rt '.$rw1['rt'].'  rw '.$rw1['rw']-->
        </td>
    </tr>
    <tr>
        <td colspan=2>
            <hr>
        </td>
    </tr>
    <tr>
        <td style="font-size:12px; font-weight:bold; font-family: verdana">Dokter</td>
        <td colspan="2" style="font-size:12px; font-weight:bold; font-family: verdana">:&nbsp;
		<?php echo $rw1['nama_dokter'];?>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td style="font-size:10px; font-family: verdana">Jenis Layanan</td>
        <td style="font-size:10px; font-family: verdana">:&nbsp;
		<?php echo $rw1['jenis_layanan'];?>
        </td>
        <!--td style="font-size:10px; font-family: verdana">Status Ps</td>
        <td style="font-size:10px; font-family: verdana">:&nbsp;< ?php echo $rw1['status'];?></td-->
    </tr>
    <tr>
        <td style="font-size:10px; font-family: verdana">
            Tempat Layanan
        </td>
        <td style="font-size:10px; font-family: verdana">:&nbsp;
            <?php echo $rw1['tempat_layanan'];?>
        </td>
    </tr>
    <tr>
        <td style="font-size:10px; font-family: verdana">
            Tanggal
        </td>
        <td style="font-size:10px; font-family: verdana">:&nbsp;
            <?php echo $rw1['tgl'];?>
        </td>
    </tr>
    <tr>
        <td style="font-size:10px; font-family: verdana">
            Pelayanan
        </td>
        <td style="font-size:10px; font-family: verdana">:&nbsp;
            <?php echo $rw1['nama_tindakan'];?>
        </td>
    </tr>
    <tr>
        <td style="font-size:10px; font-family: verdana">
            Biaya
        </td>
        <td style="font-size:10px; font-family: verdana">:&nbsp;
            <?php echo $rw1['biaya'];?>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="right" style="font-size:10px; font-family: verdana; padding-right:30px">Tanggal Cetak <?php echo $date_now.' Jam '.date('H:i:s');?></td>
    </tr>
    <!--tr>
        <td height="50">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
    </tr>
    < ?php
	$sqlKasir = "select nama from b_ms_pegawai where username = '".$_SESSION['userName']."' and id = '".$_SESSION['userId']."'";
	$rsKasir = mysql_query($sqlKasir);
	$rwKasir = mysql_fetch_array($rsKasir);
    ?-->
    <tr>
        <td colspan="2" align="right" style="font-family: verdana; padding-right:30px">Petugas Cetak</td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top:100px; text-decoration:underline; font-family: verdana; font-size:10px; padding-right:30px" align="right">(<?php echo $rwPeg['nama']; ?>)</td>
    </tr>
    <!--tr>
        <td>&nbsp;< ?php echo $jam;?></td>
        <td colspan="3" align="right">&nbsp;Operator&nbsp;&nbsp;&nbsp;< ?php echo $rwPeg['nama'];?></td>
    </tr>
    <tr>
        <td colspan="4" style="font-weight:bold; font-size:10px; font-family: verdana" align="center">"Bukti pembayaran ini juga berlaku sebagai kuitansi"</td>
    </tr-->
    <tr id="trTombol">
        <td colspan="2" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr>
</table>
<?php
mysql_free_result($rsPeg);
mysql_free_result($rs1);
mysql_close($konek);
?>
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
		// set portrait orientation
		/*jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
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
		jsPrintSetup.setSilentPrint(false);*/
                window.print();
                window.close();
        }
    }
</script>
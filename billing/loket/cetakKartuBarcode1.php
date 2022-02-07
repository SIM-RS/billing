<?php
//include("../sesi.php");
?>
<?php
include("../koneksi/konek.php");
?>
<title>Kartu Pasien</title>
<script type="text/JavaScript" language="JavaScript" src="../theme/js/formatPrint.js"></script>
<link type="text/css" rel="stylesheet" href="../theme/print.css">
<?php
$sql = "SELECT p.no_rm, p.nama, DATE_FORMAT(p.tgl_lahir,'%d-%m-%Y') AS tgllahir, p.sex, p.alamat, p.rt, p.rw,
			(SELECT nama FROM b_ms_wilayah WHERE id = p.kab_id) AS kabupaten
			FROM b_ms_pasien p
			WHERE p.id = '".$_REQUEST['idPas']."'";
$rs = mysql_query($sql);
$rw = mysql_fetch_array($rs);

$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$tgl = explode('-',$rw['tgllahir']);
$tgllahir = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
?>
<table width="400" border="0" cellpadding="0" cellspacing="1" class="kwi" style="font-size: 12px">
    <tr id="header">
        <td colspan="4" align="center"></td>
    </tr>
    <tr id="header1">
        <td width="15%">&nbsp;</td>
        <td colspan="3" style="border-top:2px solid; font-weight:400;padding-top:10px;" align="center"></td>
    </tr>
    <tr>
        <td width="18%" colspan="2" >&nbsp;</td>
        <td width="2%">&nbsp;</td>
        <td width="62%" >&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" >&nbsp;</td>
        <td>&nbsp;</td>
        <td style="text-transform:uppercase;font-size: 10px">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" height="40">&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" >&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4" style="padding-left:10px" >&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4" style="padding-left:10px;font-size:18px;font-family:Verdana, Arial, Helvetica, sans-serif" ><b><?php echo $rw['no_rm'];?></b></td>
    </tr>
    <tr>
        <td colspan="4" style="padding-left:10px;font-size:18px;font-family:Verdana, Arial, Helvetica, sans-serif" ><b><?php echo $rw['nama'];?></b></td>
    </tr>
    <tr>
        <td colspan="4" style="padding-left:10px" >&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4" style="padding-left:20px" ><img src="../../barcode/create.php?norm=<?php echo $rw['no_rm'];?>" />&nbsp;<input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
    </tr>
    
    <!--tr id="trTombol">
        <td colspan="4" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr-->
</table>
<script type="text/JavaScript">
	/*try{
	formatKartu();
	}catch(e){
	window.location='../addon/jsprintsetup.xpi';
	}*/
    function cetak(tombol){
        //tombol.style.visibility='collapse';
		//document.getElementById("trTombol").style.visibility='collapse';
		document.getElementById("btnPrint").style.visibility='hidden';
		document.getElementById("btnTutup").style.visibility='hidden';
		header.style.visibility='hidden';
		header1.style.visibility='hidden';
        //if(tombol.style.visibility=='collapse'){
            //if(confirm('Anda yakin mau mencetak Kartu Pasien ini?')){
                window.print();
                window.close();
            //}
            //else{
                //tombol.style.visibility='visible';
				//header.style.visibility='visible';
				//header1.style.visibility='visible';
            //}
	    /*try{
		    mulaiPrint();		  
	    }
	    catch(e){
		    window.print();
	    }
	    */
        //}
    }
</script>
<?php 
mysql_close($konek);
?>
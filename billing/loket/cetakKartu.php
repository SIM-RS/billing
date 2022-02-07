<?php

session_start();

include("../sesi.php");

?>
<?php
include("../koneksi/konek.php");
$idpas=$_REQUEST['idPas'];
$tmpLayanan=$_REQUEST['tmpLayanan'];
$statusPas=$_REQUEST['statusPas'];
$hakKelas=$_REQUEST['hakKelas'];
$asal=$_REQUEST['asalMsk'];
$userId=$_REQUEST['userId'];
$tglKun = tglSQL($_REQUEST['tglKun']); 
?>
<title>Kartu Pasien</title>
<script type="text/JavaScript" language="JavaScript" src="../theme/js/formatPrint.js"></script>
<link type="text/css" rel="stylesheet" href="../theme/print.css">
<?php

$sqlGetKunj="select max(id) as id from b_kunjungan where pasien_id=$idpas and user_act=$userId";
			//echo $sqlGetKunj."<br>";
			$rsGetKunj=mysql_query($sqlGetKunj);
			$rwGetKunj=mysql_fetch_array($rsGetKunj);
			$kunjungan_id=$rwGetKunj['id'];
			$idKunj=$kunjungan_id;

			$cJenisKunj=1;
			
			if ($inap == 1){
				$cJenisKunj=3;
			}else if ($jnsLayanan=="44"){
				$cJenisKunj=2;
			}

$sqlGetpel="select max(id) as id from b_pelayanan where kunjungan_id='".$rwGetKunj['id']."' and user_act=$userId";
				//echo $sqlGetpel."<br>";
				$rsGetPel=mysql_query($sqlGetpel);
				$rwGetPel=mysql_fetch_array($rsGetPel);
				
$sqlTarip = "select tarip from b_ms_tindakan_kelas where id=846";
        $rsTarip= mysql_query($sqlTarip);
        $rowTarip = mysql_fetch_array($rsTarip);
        $tarip = $rowTarip['tarip'];

if($statusPas == 1) {
	$beban_pasien = $tarip;
	$beban_kso = 0;
}else{
	$beban_pasien =0;
	$beban_kso =  $tarip;
}

$bayar_pasien = 0;
$bayar_kso = 0;
$bayar = 0;
$lunas = 0;

$sqlRetribusi="insert into b_tindakan (ms_tindakan_kelas_id,ms_tindakan_unit_id,jenis_kunjungan,kunjungan_id,pelayanan_id,kso_id,kso_kelas_id,tgl,biaya,biaya_pasien,biaya_kso,bayar,bayar_kso,bayar_pasien,lunas,user_id,type_dokter,tgl_act,user_act,unit_act) 
values('846','".$tmpLayanan."','".$cJenisKunj."','".$rwGetKunj['id']."',".$rwGetPel['id'].",'".$statusPas."','".$hakKelas."','$tglKun','$tarip','$beban_pasien','$beban_kso',".$bayar.",'$bayar_kso','$bayar_pasien','$lunas','".$_REQUEST['dokter']."','".$_REQUEST['dokterPengganti']."',NOW(),$userId,$asal)";
//echo $sqlRetribusi."<br>";
mysql_query($sqlRetribusi);



$sql = "SELECT p.no_rm, p.nama, DATE_FORMAT(p.tgl_lahir,'%d-%m-%Y') AS tgllahir, p.sex, p.alamat, p.rt, p.rw,
			(SELECT nama FROM b_ms_wilayah WHERE id = p.kab_id) AS kabupaten
			FROM b_ms_pasien p
			WHERE p.id = '".$_REQUEST['idPas']."'";
$rs = mysql_query($sql);
$rw = mysql_fetch_array($rs);


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
<table width="500" border="0" cellpadding="0" cellspacing="1" class="kwi" style="font-size: 10px">
     <tr>
            <td colspan="5" align="center">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="5" align="center">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="5" align="center">&nbsp;</td>
    </tr>
    <tr id="header">
        <td colspan="5" align="center"><?php echo strtoupper($namaRS);?><br><b><?php echo strtoupper($tipe_kotaRS)." ".strtoupper($kotaRS);?></b><br><span style="font-size:12px"><?php echo "Telp. ".$tlpRS;?></span></td>
    </tr>
    <tr id="header1">
        <td width="15%">&nbsp;</td>
        <td colspan="3" style="border-top:2px solid; font-weight:400;padding-top:10px;" align="center">KARTU IDENTITAS BEROBAT</td>
        <td width="8%">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" style="font-size:16px">&nbsp;&nbsp;&nbsp;Nomor</td>
        <td width="2%" style="font-size:146x">:&nbsp;</td>
        <td colspan="2" width="62%" style="font-size:16px">&nbsp;<b><?php echo $rw['no_rm'];?></b></td>
        <!--<td>&nbsp;</td>-->
    </tr>
    <tr>
        <td colspan="2" style="font-size:16px">&nbsp;&nbsp;&nbsp;Nama</td>
        <td style="font-size:16px">:&nbsp;</td>
        <td colspan="2" style="text-transform:uppercase;font-size: 16px">&nbsp;<?php echo $rw['nama'];?></td>
        <!--<td>&nbsp;</td>-->
    </tr>
    <tr>
        <td colspan="2" style="font-size:16px" >&nbsp;&nbsp;&nbsp;Tgl Lahir</td>
        <td style="font-size:16px">:&nbsp;</td>
        <td colspan="2" style="font-size:16px">&nbsp;<?php echo $tgl[0]." ".$arrBln[$tgl[1]]." ".$tgl[2]?></td>
        <!--<td>&nbsp;</td>-->
    </tr>
    <tr>
        <td colspan="2" style="font-size:16px">&nbsp;&nbsp;&nbsp;Jenis Kelamin</td>
        <td style="font-size:16px">:&nbsp;</td>
        <td colspan="2" style="font-size:16px">&nbsp;<?php echo $rw['sex'];?></td>
        <!--<td>&nbsp;</td>-->
    </tr>
    <tr>
        <td colspan="2" style="font-size:16px">&nbsp;&nbsp;&nbsp;Alamat</td>
        <td style="font-size:16px">:&nbsp;</td>
        <td colspan="2" rowspan="2" style="text-transform:uppercase; font-size: 10px" valign="top">&nbsp;<?php echo $rw['alamat'];?>&nbsp;RT <?php echo $rw['rt']?>/<?php echo $rw['rw']?>,&nbsp;<?php echo $rw['kabupaten'];?></td>
        <!--<td>&nbsp;</td>-->
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td width="18%">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" class="noline" align="center"><img src="../../barcode/create.php?norm=<?php echo $rw['no_rm'];?>" /></td>
    </tr>
    <tr id="trTombol">
        <td colspan="4" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr>
</table>
<script type="text/JavaScript">
	/*try{
	formatKartu();
	}catch(e){
	window.location='../addon/jsprintsetup.xpi';
	}*/
    function cetak(tombol){
        tombol.style.visibility='collapse';
		header.style.visibility='hidden';
		header1.style.visibility='hidden';
		document.getElementById("header1").style.visibility='hidden';
        if(tombol.style.visibility=='collapse'){
            //if(confirm('Anda yakin mau mencetak Kartu Pasien ini?')){
               // window.print();
			   cetakKartu12();
               //window.close();
				//cetakB();
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
        }
    }
</script>
<?php 
mysql_close($konek);
?>
<?php
session_start();
// is valid users
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') 
{
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
$r_formatlap = $_POST["formatlap"];

switch ($r_formatlap) 
{
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

if (isset($_POST["submit"])) 
{    
    $r_tglawal = tglSQL($_POST["tglawal"]);
    $r_tglakhir = tglSQL($_POST["tglakhir"]);   
}
?>
<html>
    <head>
        <title>Laporan Penerimaan Habis Pakai</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="../theme/report.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
	<table width="1300" align="center">
	<tr>
	<td>
        <table width="405" border="0">
          <tr>
            <td width="133"><strong>SKPD</strong></td>
            <td width="262">: <strong>Rumah Sakit Umum Daerah</strong></td>
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
<p align="center"><strong><font style="font:bold 16px tahoma;">PENERIMAAN BARANG PAKAI HABIS</font><br />
                <font size="3" face="Times New Roman, Times, serif"><?php //echo $_POST['kategori_kib']; ?></font></strong>
            <?php
            //if ($r_cmbperolehan=="2") {
                ?>
            <br />
            <font style="font:14px tahoma;">
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
//	}

            if ($r_idunit=="0") $strUnit="select idunit,kodeunit,namaunit,namapanjang from as_ms_unit where idunit<>0 order by kodeunit";
            else $strUnit="select idunit,kodeunit,namaunit,namapanjang from as_ms_unit where idunit=$r_idunit or parentunit=$r_idunit or parentunit in (select idunit from as_ms_unit where parentunit=$r_idunit) order by kodeunit";
            //echo $strUnit;
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
        */			 ?>
	
        <div style="width:auto; border:0px solid #CCCCCC; height:auto;">                         
        <table width="1300" border=1 cellpadding="4" cellspacing="0" style="border:1px solid #999999; border-collapse:collapse;">
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td rowspan="2">
                    <font size="-2"><br />
                        No</font>                </td>
              <td rowspan="2">
                    <font size="-2"><br />
              Terima Tanggal</font>                </td>
                    <td  rowspan="2">
                    <font size="-2"><br />
                    Dari</font>                </td>
                <td height="22" colspan="2">
                    <font size="-2">Dokumen / Faktur</font></td>
                <td height="22" colspan="3"><font size="-2">Dasar Penerimaan</font></td>
                <td  rowspan="2"><font size="-2"><br />
                Nama Barang</font></td>
                <td  rowspan="2"><font size="-2"><br />
                Jumlah</font></td>
                <td rowspan="2"><font size="-2"><br />
                Satuan</font></td>
                <td rowspan="2"><font size="-2"><br />
                Harga Satuan (Rp.)</font></td>
                <td  rowspan="2"><font size="-2"><br />
                Jumlah Harga (Rp.)</font></td>
                <td  colspan="2"><font size="-2">Bukti Penerimaan Berita Acara / Surat Penerimaan</font></td>
                <td rowspan="2">
                    <font size="-2"><br />
                    Keterangan</font></td>
            </tr>
            
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
              <td height="10"><font size="-2">Tanggal</font></td>
              <td ><font size="-2">Nomor</font></td>
              <td ><font size="-2">Jenis Surat</font></td>
              <td ><font size="-2">Tanggal</font></td>
              <td><font size="-2">Nomor</font></td>
              <td  height="10"><font size="-2">Tanggal</font></td>
              <td ><font size="-2">Nomor</font></td>
            </tr>
            <tr align="center" valign="top" bgcolor="#FFFFCC" class="SubHeaderBW">
                <td width="3%" height="10"><font size="-2">1</font></td>
                <td width="6%" height="10"><font size="-2">2</font></td>
                <td width="13%" height="10"><font size="-2">3</font></td>
                <td width="6%" height="10"><font size="-2">4</font></td>
                <td width="6%"><font size="-2">5</font></td>
                <td width="6%" height="10"><font size="-2">6</font></td>
                <td width="6%" height="10"><font size="-2">7</font></td>
                <td width="6%" height="10"><font size="-2">8</font></td>
                <td width="8%"><font size="-2">9</font></td>
                <td width="4%"><font size="-2">10</font></td>
                <td width="6%"><font size="-2">11</font></td>
                <td width="6%"><font size="-2">12</font></td>
                <td width="6%" height="10"><font size="-2">13</font></td>
                <td width="6%"><font size="-2">14</font></td>
                <td width="6%" height="10"><font size="-2">15</font></td>
                <td width="6%" height="10"><font size="-2">16</font></td>
            </tr>
		</table>
		</div>
		<div style="width:1298px; border:1px solid #999999; border-top:0px; height:350px; overflow-y:auto; font:11px tahoma;">
		<?php
				
	   $strSQL ="select m.tgl_terima,r.namarekanan,m.tgl_faktur,m.no_faktur,p.jenis_surat,p.no_po,m.satuan_unit,
		p.tgl_po,m.jml_msk,b.namabarang,m.harga_unit,(m.jml_msk*m.harga_unit) as jumlah_harga,m.no_gudang,u.namaunit
		from as_masuk m
		inner join as_ms_barang b on m.barang_id=b.idbarang
		inner join as_po p on m.po_id=p.id
		inner join as_ms_rekanan r on p.vendor_id=r.idrekanan
		left join as_ms_unit u on p.unit_id=u.idunit
		where m.tgl_terima between '$r_tglawal' and '$r_tglakhir' and b.tipe=2 ";
		 //echo $strSQL."<br />";
		$rs = mysql_query($strSQL);
		if (mysql_affected_rows() > 0) 
		{ // Iterating through record
	   
			$j = 0;
			$totalharga=0;
			$totalgeneral=0;
			while ($rows = mysql_fetch_array($rs)) 
			{
				if ($j % 2) $rowStyle = "NormalBG";  else $rowStyle = "AlternateBG";
				$j++;
				$totalharga +=$rows["harga_unit"];
			?>
			<div style="width:1275px; border:0px; height:auto; float:left; <? if($j%2!=0){echo "background:#EEEEEE";}else{echo "background:#FFFFFF";}?>">
				<div style="width:31px; float:left; border:1px solid #999999; border-left:0px; border-top:0px; min-height:28px; padding:3px; text-align:center"><?php echo $j;?></div>
				<div style="width:71px; float:left; border:1px solid #999999; border-left:0px; border-top:0px; min-height:28px; padding:3px;"><?php echo tglSQL($rows["tgl_terima"]);?></div>
				<div style="width:162px; float:left; border:1px solid #999999; border-left:0px; border-top:0px; min-height:28px; padding:3px;"><?php echo $rows["namarekanan"];?></div>
				<div style="width:71px; float:left; border:1px solid #999999; border-left:0px; border-top:0px; min-height:28px; padding:3px;"><?php echo tglSQL($rows["tgl_faktur"]);?></div>
				<div style="width:71px; float:left; border:1px solid #999999; border-left:0px; border-top:0px; min-height:28px; padding:3px;"><?php echo $rows["no_faktur"];?></div>
				<div style="width:71px;; float:left; border:1px solid #999999; border-left:0px; border-top:0px; min-height:28px; padding:3px;"><?php echo $rows["jenis_surat"];?></div>
				<div style="width:71px; float:left; border:1px solid #999999; border-left:0px; border-top:0px; min-height:28px; padding:3px;"><?php echo tglSQL($rows["tgl_po"]);?></div>
				<div style="width:71px; float:left; border:1px solid #999999; border-left:0px; border-top:0px; min-height:28px; padding:3px; word-wrap:break-word;"><?php echo $rows["no_po"];?></div>
				<div style="width:97px; float:left; border:1px solid #999999; border-left:0px; border-top:0px; min-height:28px; padding:3px; word-wrap:break-word;"><?php echo $rows["namabarang"];?></div>
				<div style="width:45px; float:left; border:1px solid #999999; border-left:0px; border-top:0px; min-height:28px; padding:3px;"><?php echo $rows["jml_msk"];?></div>
				<div style="width:71px; float:left; border:1px solid #999999; border-left:0px; border-top:0px; min-height:28px; padding:3px;"><?php echo $rows["satuan_unit"];?></div>
				<div style="width:71px; float:left; border:1px solid #999999; border-left:0px; border-top:0px; min-height:28px; padding:3px; text-align:right;"><?php echo number_format($rows["harga_unit"],0,'','.');?></div>
				<div style="width:71px; float:left; border:1px solid #999999; border-left:0px; border-top:0px; min-height:28px; padding:3px; text-align:right;"><?php
				$total = $rows["jumlah_harga"];
				echo number_format($total,0,'','.');
				$totalgeneral +=$total;
				?>
				</div>
				<div style="width:71px; float:left; border:1px solid #999999; border-left:0px; border-top:0px; min-height:28px; padding:3px; text-align:right;"><?php echo $rows["tgl_terima"];?></div>
				<div style="width:71px; float:left; border:1px solid #999999; border-left:0px; border-top:0px; min-height:28px; padding:3px; word-wrap:break-word;"><?php echo $rows["no_gudang"];?></div>
				<div style="width:47px; float:left; border:1px solid #999999; border-left:0px; border-top:0px; min-height:28px; padding:3px; text-align:right;"><?php echo $rows["namaunit"];?></div>
			</div>
			<?php
			} // end while
		}
			?>
		</div>
		<div style="width:auto; border:0px solid #CCCCCC; height:auto;">
        <table width="1300">
		    <tr>
                <td class="HeaderBW" colspan="2">&nbsp;</td>
                <td class="HeaderBW" colspan="10" align="left">J U M L A H ................................................................</td>
                <td width="115" align="right" class="HeaderBW"><?php echo number_format($totalgeneral,0,'','.');?></td>
                <td width="82" colspan="2" class="HeaderBW">&nbsp;</td>
            </tr>
      </table>
	  </div><br>
		<div style="width:auto; border:0px solid #CCCCCC; height:auto;">
        <table border=0 cellspacing="0" cellpadding="0" width="1300">
            <tr>
                <td align="center"><strong>MENGETAHUI<br />KEPALA SKPD<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
                <td width="100">&nbsp;</td>

                <td align="center"><strong>.........................,.........................................<br />PENGURUS BARANG<br /><br /><br /><br />(...............................)<br />
                        NIP. .......................</strong></td>
            </tr>
        </table>
		
	  </div>
    </body>
</html>
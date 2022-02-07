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
		header('Content-Disposition: attachment; filename="Laporan_Keluar_Habis_Pakai_'.date('d-m-Y').'.xls"');
        break;
    case "WORD" :
        Header("Content-Type: application/msword");
		header('Content-Disposition: attachment; filename="Laporan_Keluar_Habis_Pakai_'.date('d-m-Y').'.doc"');
        break;
    default :
        Header("Content-Type: text/html");
        break;
}

if (isset($_POST["submit"])) {
        $r_tglawal = tglSQL($_POST["tglawal"]);
        $r_tglakhir = tglSQL($_POST["tglakhir"]);
        $namaunit= $_POST[namaunit];
        $idunit=$_POST[idunit];
}
?>
<html>
    <head>
        <title>Laporan Pengeluaran BPH</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <?php if($r_formatlap != 'XLS' && $r_formatlap != 'WORD'){ ?>
			<link href="../theme/report.css" rel="stylesheet" type="text/css" />
		<?php } ?>
    </head>
    <body>
    <table width="334" border="0">
      <tr>
        <td width="133"><strong>SKPD</strong></td>
        <td width="191">: <strong>Rumah Sakit Umum Daerah</strong></td>
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
     
    </p>
    <p>&nbsp;</p>
    <p align="center"><strong><font size="4" face="Times New Roman, Times, serif">LAPORAN PENGELUARAN BARANG PAKAI HABIS</font><br />
          <font size="3" face="Times New Roman, Times, serif">
            <?php //echo $_POST['kategori_kib']; ?>
    </font></strong>
        <?php
            //if ($r_cmbperolehan=="2") {
                ?>
        <br />
        <font size="3" face="Times New Roman, Times, serif"> (<?php echo date("d M Y",strtotime($r_tglawal));  ?> - <?php echo date("d M Y",strtotime($r_tglakhir));  ?>) </font>
        <?php
            //}
            ?>
    </p>
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
        */?>
    <!--table border=0 width="698">
      <tr>
        <td colspan="3"><strong>
          <?php
		echo $rowsUnit["namaunit"];
	?>
        </strong></td>
        <td width="583" colspan="7">&nbsp;</td>
      </tr>
    </table-->
    <br />
	<table width="100%" cellpadding="0" cellspacing="0" >
		<tr>
			<td width="8%"><strong>Nama Unit</strong></td>
			<td width="92%">:&nbsp;<strong><?php if ($idunit==0){echo "Semua";} else{echo $namaunit;} ?></strong></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
	<table border=1 cellspacing="0" cellpadding="4" class="GridStyle" width="100%">
		<tr align="center" valign="middle" bgcolor="#CCCCCC" class="HeaderBW">
			<td width="30px" rowspan="2">No.</td>
			<td colspan="2">Pengeluaran</td>
			<td colspan="2">BON</td>
			<td width="150" rowspan="2">Peruntukan</td>
			<td width="50" rowspan="2">Jumlah</td>
			<td width="250" rowspan="2">Naman Barang</td>
			<td rowspan="2">Total Nilai<br />( RP )</td>
			<td rowspan="2">Keterangan</td>
		</tr>
		<tr align="center" valign="middle" bgcolor="#CCCCCC" class="HeaderBW">
			<td>No</td>
			<td>Tanggal</td>
			<td>No</td>
			<td>Tanggal</td>
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
		</tr>
		<?php
			if($idunit!=0){
				$change="u.namaunit =  '$namaunit' and ";
			}
			function totalNilai($kode,$tgl,$r_tglakhir){
				$SQL_ = "SELECT SUM(k.nilai) total_nilai
						FROM
						  as_keluar k 
						  INNER JOIN as_ms_barang b 
							ON k.barang_id = b.idbarang 
						  LEFT JOIN as_ms_unit u 
							ON k.unit_id = u.idunit 
						WHERE {$change} k.tgl_transaksi = '{$tgl}' 
						  AND k.kode_transaksi = '{$kode}'
						  AND b.tipe = 2 
						  AND k.jml_klr > 0";
				$hasil = mysql_fetch_array(mysql_query($SQL_));
				return $hasil['total_nilai'];
			}
			$strSQL = "SELECT k.no_gd, k.tgl_gd, k.kode_transaksi, k.tgl_transaksi, u.namaunit,
						  k.jml_klr, b.namabarang, k.nilai, k.petugas_gudang
						FROM
						  as_keluar k 
						  INNER JOIN as_ms_barang b 
							ON k.barang_id = b.idbarang 
						  LEFT JOIN as_ms_unit u 
							ON k.unit_id = u.idunit 
						WHERE {$change} k.tgl_transaksi BETWEEN '{$r_tglawal}' 
						  AND '{$r_tglakhir}' 
						  AND b.tipe = 2 
						  AND k.jml_klr > 0
						  AND stt = 1
						GROUP BY k.kode_transaksi, k.barang_id 
						ORDER BY k.tgl_gd DESC, k.no_gd DESC";
			$query = mysql_query($strSQL);
			$i = 1;
			$jum = 0;
			while($data = mysql_fetch_array($query)){
				$jum += $data['nilai'];
		?>
				<tr>
					<td align="center"><?=$i++?></td>
					<td align="center"><?=$data['no_gd']?></td>
					<td align="center"><?=tglSQL($data['tgl_gd'])?></td>
					<td align="center"><?=$data['kode_transaksi']?></td>
					<td align="center"><?= tglSQL($data['tgl_transaksi'])?></td>
					<td align="center"><?=$data['namaunit']?></td>
					<td align="center"><?=$data['jml_klr']?></td>
					<td align="left"><?=$data['namabarang']?></td>
					<td align="right"><?=number_format($data['nilai'],0,'','.')//totalNilai($data['kode_transaksi'],$data['tgl_gd'],$change)?></td>
					<td align="center"><?=$data['petugas_gudang']?></td>
				</tr>
		<?php
			}
		?>
		<tr>
			<td align='right' colspan="8"><b>J U M L A H &nbsp;&nbsp;&nbsp;</b></td>
			<td align="right"><b><?=number_format($jum,0,'','.')?></b></td>
		</tr>
	</table>
    <br />
    <br />
    <table border=0 cellspacing="0" cellpadding="0" width="1300">
      <tr>
        <td align="center"><strong>MENGETAHUI<br />
          KEPALA SKPD<br />
          <br />
          <br />
          <br />
          (...............................)<br />
          NIP. .......................</strong></td>
        <td width="100">&nbsp;</td>
        <td align="center"><strong>.........................,.........................................<br />
          PENGURUS BARANG<br />
          <br />
          <br />
          <br />
          (...............................)<br />
          NIP. .......................</strong></td>
      </tr>
    </table>
    <br />
    <br />
    <br />
    <br />
    <?php
                        //} // end
                       // break;
                  //  case "B" :		// KIB - PERALATAN DAN MESIN
            //}
        //}
        ?>
    </body>
</html>
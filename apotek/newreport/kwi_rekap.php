<?php 
session_start();
$username = $_SESSION["username"];
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$no_bayar=$_REQUEST['no_bayar'];
$jamin=$_REQUEST['jamin'];
$nopasien=$_REQUEST['nopasien'];
?>
	<div id="idArea" style="display:block">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	<p align="center"><span class="jdltable">DATA PELAYANAN RESEP / OBAT</span>  
<table width="48%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="177" class="txtcenter"></td>
        </tr>
      
      <table width="1204" align="center" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td id="" width="33" height="25" class="tblheaderkiri" onClick="">No</td>
          <td id="TGL_ACT" width="71" class="tblheader" onClick="">Tgl</td>
          <td id="NO_KUNJUNGAN" width="71" class="tblheader">No Penjualan</td>
          <td id="NO_PASIEN" width="61" class="tblheader">No RM</td>
          <td width="259" class="tblheader" id="NAMA_PASIEN">Nama Pasien</td>
          <td id="am.NAMA" width="204" class="tblheader">KSO</td>
          <td id="UNIT_NAME" width="120" class="tblheader">Unit Farmasi</td>
          <td id="UNIT_NAME" width="120" class="tblheader">Ruangan<br>
            (Poli)</td>
          <td id="SUM_SUB_TOTAL" width="81" class="tblheader">Nilai Awal</td>
          <td id="SUM_SUB_TOTAL" width="81" class="tblheader">Nilai Retur</td>
          <td id="SUM_SUB_TOTAL" width="81" class="tblheader">Sub Total </td>
        </tr>
        <?php 
	if($jamin==0){	
	$sql="SELECT 
			   DATE_FORMAT(ap.TGL,'%d-%m-%Y') AS tgl1,
			   ap.NO_PENJUALAN,
			   ap.NO_PASIEN,
			   ap.NAMA_PASIEN,
			   ap.DOKTER,
			   au.UNIT_NAME UNIT_AP,
			   au1.UNIT_NAME,
			   am.NAMA AS KSO,
			   SUM(FLOOR((ap.QTY_JUAL-ap.QTY_RETUR)*ap.HARGA_NETTO)) AS HARGA_NETTO,
			   SUM(ap.QTY_JUAL*ap.HARGA_SATUAN-FLOOR(ap.QTY_RETUR*ap.HARGA_SATUAN*((100-ap.BIAYA_RETUR)/100))) AS HARGA_TOTAL_, 
			   ap.`HARGA_TOTAL` NILAI_AWAL, 
			   SUM(FLOOR(ap.QTY_RETUR * ap.HARGA_SATUAN * ( (100- ap.BIAYA_RETUR) / 100) ) ) NILAI_RETUR, 
			   ap.`HARGA_TOTAL` - SUM( FLOOR(ap.QTY_RETUR * ap.HARGA_SATUAN * ( (100- ap.BIAYA_RETUR) / 100) ) ) AS HARGA_TOTAL, 
			   SUM(ap.QTY_RETUR) AS jRetur
			FROM a_kredit_utang ku
			  INNER JOIN a_penjualan ap
				ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
				  AND ku.UNIT_ID = ap.UNIT_ID
				  AND ku.NORM = ap.NO_PASIEN
			  INNER JOIN a_unit au
				ON ap.UNIT_ID = au.UNIT_ID
			  LEFT JOIN a_unit au1
				ON ap.RUANGAN = au1.UNIT_ID
			  INNER JOIN a_mitra am
				ON ap.KSO_ID = am.IDMITRA
			WHERE ku.NO_BAYAR = '$no_bayar'
			GROUP BY ap.NO_PENJUALAN,ap.UNIT_ID,ap.NAMA_PASIEN,ap.USER_ID";
	}else{
		
	$sql="SELECT * FROM a_penjualan ap WHERE ap.`NO_PASIEN`='$nopasien' ORDER BY ap.id DESC LIMIT 1";
	$rs=mysqli_query($konek,$sql);
	$rs1=mysqli_fetch_array($rs);
	
	$sql="SELECT 
		  DATE_FORMAT(ap.TGL, '%d-%m-%Y') AS tgl1,
		  ap.NO_PENJUALAN,
		  ap.NO_PASIEN,
		  ap.NAMA_PASIEN,
		  ap.DOKTER,
		  au.UNIT_NAME UNIT_AP,
		  au1.UNIT_NAME,
		  am.NAMA AS KSO,
		  SUM(
			FLOOR(
			  (ap.QTY_JUAL - ap.QTY_RETUR) * ap.HARGA_NETTO
			)
		  ) AS HARGA_NETTO,
		  SUM(
			ap.QTY_JUAL * ap.HARGA_SATUAN - FLOOR(
			  ap.QTY_RETUR * ap.HARGA_SATUAN * ((100- ap.BIAYA_RETUR) / 100)
			)
		  ) AS HARGA_TOTAL_,
		  ap.`HARGA_TOTAL` NILAI_AWAL,
		  SUM(
			FLOOR(
			  ap.QTY_RETUR * ap.HARGA_SATUAN * ((100- ap.BIAYA_RETUR) / 100)
			)
		  ) NILAI_RETUR,
		  ap.`HARGA_TOTAL` - SUM(
			FLOOR(
			  ap.QTY_RETUR * ap.HARGA_SATUAN * ((100- ap.BIAYA_RETUR) / 100)
			)
		  ) AS HARGA_TOTAL,
		  SUM(ap.QTY_RETUR) AS jRetur 
		FROM
		a_penjualan ap 
		  INNER JOIN a_unit au 
			ON ap.UNIT_ID = au.UNIT_ID 
		  LEFT JOIN a_unit au1 
			ON ap.RUANGAN = au1.UNIT_ID 
		  INNER JOIN a_mitra am 
			ON ap.KSO_ID = am.IDMITRA 
		WHERE ap.NO_PASIEN = '$nopasien'
		  AND ap.KSO_ID <>2
		GROUP BY ap.NO_PENJUALAN,
		  ap.UNIT_ID,
		  ap.NAMA_PASIEN,
		  ap.USER_ID ";
	}
	 //echo $sql."<br>";
	  
	  $sql2="select sum(t1.HARGA_TOTAL) as HARTOT from (".$sql.")as t1";
	  $hs=mysqli_query($konek,$sql2);
	  $hartot=0;
	  $show=mysqli_fetch_array($hs);
	  $hartot=$show['HARTOT'];
	  
	  $rs=mysqli_query($konek,$sql);
	  $p=0;
	  while ($rows=mysqli_fetch_array($rs)){
		$p++;
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $p; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NO_PENJUALAN']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['NO_PASIEN']; ?></td>
          <td class="tdisi" align="left" style="font-size:12px;">&nbsp;<?php echo $rows['NAMA_PASIEN']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['KSO']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['UNIT_AP']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['NILAI_AWAL'],2,",","."); ?></td>
          <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['NILAI_RETUR'],2,",","."); ?></td>
          <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['HARGA_TOTAL'],2,",","."); ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="3"  align="right" class="txtright">&nbsp;</td>
          <td colspan="5" align="right" class="txtright">Jumlah Total &nbsp; </td>
          <td align="right" class="txtright">&nbsp;</td>
          <td align="right" class="txtright">&nbsp;</td>
          <td align="right" class="txtright">&nbsp;<? echo number_format($hartot,2,",","."); ?>&nbsp;</td>
        </tr>
      </table>
      <p class='txtinput'  style='padding-right:20px; text-align:right;'><?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?></p>
      <p id="btn" align="center"><BUTTON type="button" onClick="document.getElementById('btn').style.display='none';window.print();/*window.printZebra();*/window.close();"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">Cetak</BUTTON></p>
	</div>
<?php 
mysqli_close($konek);
?>

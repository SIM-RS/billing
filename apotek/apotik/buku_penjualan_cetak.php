<?php
include("../sesi.php"); 
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//Paging,Sorting dan Filter======
$tgl_d=$_REQUEST['tgl_d'];
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$tgl_s=$_REQUEST['tgl_s'];
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
$jns_pasien=$_REQUEST['jns_pasien'];
$idunit1=$_REQUEST['idunit1'];
$kso_id=$_REQUEST['kso_id'];
if($idunit1=="0" OR $idunit1=="1") $junit=" AND a.UNIT_ID<>20"; else $junit=" AND a.UNIT_ID=$idunit1";

if($jns_pasien=="" OR $jns_pasien=="0") $jns_p=""; else $jns_p="  and (pel.jenis_kunjungan=$jns_pasien)";


$kategori=$_REQUEST['kategori'];if ($kategori=="") $fkategori=""; else $fkategori=" AND ao.OBAT_KATEGORI=$kategori";
if($kso_id=="0"){ $fkso="";} else{ $fkso=" AND a.KSO_ID=$kso_id";}


$defaultsort="a.TGL DESC,a.ID DESC";
$unitn="ALL UNIT";
if ($idunit1!="0"){
	$sql="SELECT * FROM a_unit WHERE UNIT_ID=".$idunit1;
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		$unitn=$rows["UNIT_NAME"];
	}
}
$kso = "All KSO";
if ($kso_id!="0"){
	$sql="SELECT * FROM a_mitra WHERE idmitra=".$kso_id;
	//echo $sql;
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		$kso=$rows["NAMA"];
	}
}
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
if ($filter!=""){
	$tfilter=explode("*-*",$filter);
	$filter="";
	for ($k=0;$k<count($tfilter);$k++){
		$ifilter=explode("|",$tfilter[$k]);
		$filter .=" and ".$ifilter[0]." like '%".$ifilter[1]."%'";
		//echo $filter."<br>";
	}
  }
  
  if ($sorting=="") $sorting=$defaultsort;

/* $sql="SELECT DATE_FORMAT(a.TGL,'%d/%m/%Y') AS tgl1,ok.kategori,a.NO_PENJUALAN,a.NAMA_PASIEN,ao.OBAT_NAMA,SUM(a.QTY_JUAL-a.QTY_RETUR) AS QTY_JUAL,ak.NAMA,u.UNIT_NAME,SUM(a.QTY_JUAL-a.QTY_RETUR)*HARGA_SATUAN AS H_JUAL,a.DOKTER 
FROM a_penjualan a 
INNER JOIN a_penerimaan ap ON a.PENERIMAAN_ID=ap.ID 
INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID 
INNER JOIN a_kepemilikan ak ON a.JENIS_PASIEN_ID=ak.ID 
LEFT JOIN (SELECT * FROM a_unit WHERE UNIT_TIPE=3) AS u ON a.RUANGAN=u.UNIT_ID 
LEFT JOIN a_obat_kategori ok ON ok.id = ao.OBAT_KATEGORI
WHERE a.TGL BETWEEN '$tgl_d1' AND '$tgl_s1'".$junit.$jns_p.$filter.$fkategori." GROUP BY a.NO_PENJUALAN,a.TGL,ap.OBAT_ID ORDER BY ".$sorting; */
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Cetak Buku Penjualan</title>
	<style type="text/css">
		body{
			font-family:Verdana,Arial,Helvetica,sans-serif;
			font-size:12px;
		}
		table{
			width:100%;
			border-collapse:collapse;
		}
		table th, table td{
			border:1px solid #000;
			padding:5px;
		}		
	</style>
</head>
<body>
<p align="center" style="font-weight:bold; font-size:14px;">LAPORAN BUKU PENJUALAN<br />UNIT : <?php echo $unitn; ?><br />TGL : <?php echo $tgl_d." s/d ".$tgl_s; ?> <br />KSO : <?php echo $kso; ?> </p>
<p align="center" style="font-weight:bold; font-size:14px;">&nbsp;</p>
<table>
	<thead>
		<tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>No Penjualan</th>
			<th>Nama Pasien</th>
			<th>Nama Obat</th>
			<th>Kategori</th>
			<th>Kepemilikan</th>
			<th>Qty</th>
			<th>Harga</th>
			<th>PPN</th>
			<th>Harga + PPN </th>
			<th>Poli (Ruangan)</th>
			<th>Dokter</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	
	
		$sjml = "SELECT COUNT(DISTINCT a.NO_PENJUALAN) jml
				FROM a_penjualan a
				INNER JOIN a_penerimaan ap ON a.PENERIMAAN_ID = ap.ID 
				INNER JOIN a_obat ao ON ap.OBAT_ID = ao.OBAT_ID 
				INNER JOIN a_kepemilikan ak ON a.JENIS_PASIEN_ID = ak.ID 
				LEFT JOIN (SELECT * FROM a_unit WHERE UNIT_TIPE = 3) AS u ON a.RUANGAN = u.UNIT_ID 
				LEFT JOIN a_obat_kategori ok ON ok.id = ao.OBAT_KATEGORI
				  left join rspelindo_billing.b_pelayanan pel on a.NO_KUNJUNGAN=pel.id  
				WHERE a.TGL BETWEEN '{$tgl_d1}' AND '{$tgl_s1}'".$junit.$jns_p.$filter.$fkso.$fkategori."
				ORDER BY ".$sorting;
		$djml = mysqli_fetch_array(mysqli_query($konek,$sjml));
		$jmlPenj = $djml['jml'];
		//echo "<br />";
		
		 $sql = "SELECT 
			  DATE_FORMAT(a.TGL, '%d/%m/%Y') AS tgl1,
			  a.NO_PENJUALAN, ok.kategori, a.NAMA_PASIEN, ao.OBAT_NAMA,
			  SUM(a.QTY_JUAL - a.QTY_RETUR) AS QTY_JUAL,
			  ak.NAMA, u.UNIT_NAME,
			  SUM((a.QTY_JUAL - a.QTY_RETUR) * a.HARGA_SATUAN) AS H_JUAL,
			  a.DOKTER, ao.OBAT_ID, a.ID,
			 (a.PPN/100) * SUM(a.QTY_JUAL* a.HARGA_SATUAN) AS PPN_NILAI
			FROM
			  a_penjualan a 
			  INNER JOIN a_penerimaan ap ON a.PENERIMAAN_ID = ap.ID 
			  LEFT JOIN a_obat ao ON ap.OBAT_ID = ao.OBAT_ID 
			  INNER JOIN a_kepemilikan ak ON a.JENIS_PASIEN_ID = ak.ID 
			  LEFT JOIN (SELECT * FROM a_unit WHERE UNIT_TIPE = 3) AS u ON a.RUANGAN = u.UNIT_ID 
			  LEFT JOIN a_obat_kategori ok ON ok.id = ao.OBAT_KATEGORI 
			    left join rspelindo_billing.b_pelayanan pel on a.NO_KUNJUNGAN=pel.id  
			WHERE a.TGL BETWEEN '{$tgl_d1}' AND '{$tgl_s1}'".$junit.$jns_p.$fkso.$filter.$fkategori."
			GROUP BY a.NO_PENJUALAN, ap.OBAT_ID
			ORDER BY ".$sorting;
			//echo  $sql ;
		$i=0;
		$rs = mysqli_query($konek,$sql);
		
		
		
	 $sql3="SELECT COUNT(t1.NO_PENJUALAN) AS tot_obat FROM (".$sql.") AS t1";
	  $rs3=mysqli_query($konek,$sql3);
	  $tot=mysqli_fetch_array($rs3);
	  $tot_obat=$tot['tot_obat'];
		
		
		while ($rows=mysqli_fetch_array($rs)){
			//$i++;
			//$jRetur=$rows['jRetur'];
			//$tCaraBayar=$rows['CARA_BAYAR'];
	?>
		<tr> 
		<?php
			if($tmpNP != $rows['NO_PENJUALAN']){
		?>
			<td align="center"><?php echo ++$i; ?></td>
			<td align="center"><?php echo $rows['tgl1']; ?></td>
			<td align="center"><?php echo $rows['NO_PENJUALAN']; ?></td>
			<td align="left"><?php echo $rows['NAMA_PASIEN']; ?></td>
		<?php
			} else {
		?>
			<td align="center">&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td align="left">&nbsp;</td>
		<?php
			}
			$tmpNP = $rows['NO_PENJUALAN'];
		?>
			<td align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
			<td align="center"><?php echo $rows['kategori']; ?></td>
			<td align="center"><?php echo $rows['NAMA']; ?></td>
			<td align="center"><?php echo $rows['QTY_JUAL']; ?></td>
			<td align="right"><?php echo number_format($rows['H_JUAL'],0,",","."); ?></td>
			<td align="right"><?php echo number_format($rows['PPN_NILAI'],0,",","."); ?></td>
			<td align="right"><?php echo number_format($rows['H_JUAL']+$rows['PPN_NILAI'],0,",","."); ?></td>
			<td align="center"><?php echo $rows['UNIT_NAME']; ?></td>
			<td align="left"><?php echo $rows['DOKTER']; ?></td>
		</tr>
	<?php
		 //$hartot=$hartot+$rows['HARGA_TOTAL'];
		}
		$sql2="select sum(t1.QTY_JUAL) as jtot,sum(t1.H_JUAL) as totjual,sum(t1.PPN_NILAI) as totppn from (".$sql.")as t1";
		$hs=mysqli_query($konek,$sql2);
		$jtot=0;$totjual=0;
		$show=mysqli_fetch_array($hs);
		$jtot=$show['jtot'];
		$totjual=$show['totjual'];
		$totppn=$show['totppn'];
	?>
		<tr> 
			<td colspan="4"  align="center">Jumlah Item Obat = <?php echo $tot_obat;?> ,&nbsp;&nbsp; Jumlah Resep = <?php echo $jmlPenj;?></td>
			<td  align="right">&nbsp;</td>
			<td  align="right">&nbsp;</td>
			<td  align="right">&nbsp;</td>
			<td align="center"><?php echo number_format($jtot,0,",","."); ?></td>
			<td align="right"><?php echo number_format($totjual,0,",","."); ?></td>
			<td align="right"><?php echo number_format($totppn,0,",","."); ?></td>
			<td align="right"><?php echo number_format($totjual+$totppn,0,",","."); ?></td>
			<td colspan="4" align="right"></td>
        </tr>
	</tbody>
</table>
<script type="text/javascript">
	window.print();
	window.close();
</script>
</body>
</html>
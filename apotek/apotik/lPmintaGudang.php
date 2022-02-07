<?
include("../sesi.php"); 
include("../koneksi/konek.php");

header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="rekapitulasi_register.xls"');

$defaultsort="ap.NOTERIMA";
$unit_tujuan=$_REQUEST['unit_tujuan']; if(($unit_tujuan=="0")||($unit_tujuan=="")) $unit_tj=""; else $unit_tj="and ap.UNIT_ID_KIRIM=$unit_tujuan";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$idunit=$_SESSION["ses_idunit"];

$tgl_d=$_REQUEST['tgl_d'];
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";

$tgl_s=$_REQUEST['tgl_s'];
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";

if ($sorting=="") $sorting=$defaultsort;
if ($_GET['tgl_d']=='') $tgl_1=0; else $tgl_1=$tgl_de;
if ($_GET['tgl_s']=='') $tgl_2=0; else $tgl_2=$tgl_se;
$sql="Select date_format(ap.TGL_TERIMA,'%d/%m/%Y') as tgl1,ap.NOTERIMA,sum(ap.QTY_SATUAN) as QTY_SATUAN,sum(FLOOR(ap.QTY_SATUAN*ap.HARGA_BELI_SATUAN)) as HARGA_BELI_TOTAL,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA,au.UNIT_NAME,amo.qty,ah1.HARGA_JUAL_SATUAN,QTY_SATUAN*ah1.HARGA_JUAL_SATUAN AS tot_kirim From a_penerimaan ap inner Join a_unit au ON au.UNIT_ID = ap.UNIT_ID_KIRIM inner Join a_obat ao ON ap.OBAT_ID = ao.OBAT_ID inner Join a_kepemilikan ak ON ak.ID = ap.KEPEMILIKAN_ID INNER JOIN a_minta_obat amo ON ap.FK_MINTA_ID = amo.permintaan_id INNER JOIN a_harga ah1 ON ap.OBAT_ID = ah1.OBAT_ID AND ap.KEPEMILIKAN_ID = ah1.KEPEMILIKAN_ID where ap.UNIT_ID_TERIMA=$idunit AND ap.TIPE_TRANS=1 and ap.QTY_SATUAN>0 and ap.STATUS=1 AND au.UNIT_ID = 1 and ap.TANGGAL between '$tgl_1' and '$tgl_2'".$unit_tj.$filter." group by ap.NOTERIMA,ao.OBAT_NAMA,ak.NAMA order by ".$sorting;

$rs=mysqli_query($konek,$sql);
$jmldata=mysqli_num_rows($rs);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<div id="cetak">
<!--<link rel="stylesheet" href="../theme/print.css" type="text/css" />
-->	  <table width="30%" align="center" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td colspan="2" align="center" class="jdltable"><p>LAPORAN PENERIMAAN 
              OBAT DARI GUDANG<br>
              UNIT : <?php echo $namaunit; ?></p></td>
        </tr>
        <tr> 
          <td colspan="2" align="center">( <?php echo $_GET['tgl_d'];?> s/d <?php echo $_GET['tgl_s'];?> 
            ) </td>
        </tr>
        <tr> 
          <td colspan="2" align="center">Unit Pengirim : 
            <?
	  			$qry = "select UNIT_NAME from a_unit where UNIT_ID=$unit_tujuan";
				$exe = mysqli_query($konek,$qry);
				$show= mysqli_fetch_array($exe);
				//echo $qry;
				echo $show['UNIT_NAME'];
				if ($show['UNIT_NAME']=="") echo "ALL UNIT";
			?>
          </td>
        </tr>
      </table>
      <table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
        <!--<tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="TANGGAL" width="75" class="tblheader" onclick="ifPop.CallFr(this);">Tgl Terima</td>
          <td align="center" id="a_penerimaan.ID" width="160" class="tblheader" onclick="ifPop.CallFr(this);">No 
            Terima</td>
          <td align="center" id="UNIT_NAME" width="130" class="tblheader" onclick="ifPop.CallFr(this);">Unit Pengirim</td>
          <td align="center" id="OBAT_KODE" width="70" class="tblheader" onclick="ifPop.CallFr(this);">Kode</td>
          <td id="OBAT_NAMA" class="tblheader" onclick="ifPop.CallFr(this);">Obat</td>
          <td align="center" id="NAMA" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Kepemilikan</td>
          <td width="40" class="tblheader" id="QTY_SATUAN" onclick="ifPop.CallFr(this);">QTY</td>
          <td id="HARGA_BELI_TOTAL" width="90" class="tblheader" onclick="ifPop.CallFr(this);">Total</td>
        </tr>-->
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td align="center" id="OBAT_KODE" width="70" class="tblheader" onclick="ifPop.CallFr(this);">Kode</td>
          <td id="OBAT_NAMA" class="tblheader" onclick="ifPop.CallFr(this);">Obat</td>
          <td align="center" id="NAMA" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Satuan</td>
          <td align="center" id="NAMA" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Kepemilikan</td>
          <td width="40" class="tblheader" id="QTY_SATUAN" onclick="ifPop.CallFr(this);">QTY Minta</td>
          <td width="40" class="tblheader" id="QTY_SATUAN" onclick="ifPop.CallFr(this);">QTY Kirim</td>
          <td id="HARGA_BELI_TOTAL" width="90" class="tblheader" onclick="ifPop.CallFr(this);">Harga Satuan</td>
          <td id="HARGA_BELI_TOTAL" width="90" class="tblheader" onclick="ifPop.CallFr(this);">Total</td>
        </tr>
        <?php 
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
	  $i=0;
	  $subT1 = 0;
	  $tglkrm="";
	  $no_krm="";
	  $unit_t="";
	  while ($rows=mysqli_fetch_array($rs)){
		$no_krm1=($no_krm==$rows['NOTERIMA'])?"&nbsp;":$rows['NOTERIMA'];
		if ($no_krm1!="&nbsp;"){
			$i++;
			$i1=$i;
			$tglx=$rows['tgl1'];
			$unit_t1=$rows['UNIT_NAME'];
		}else{
			$i++;
			$i1=$i;
			//$i1="&nbsp;";
			$tglx="&nbsp;";
			$unit_t1="&nbsp;";
		}
		
		$tglkrm=$rows['tgl1'];
		$no_krm=$rows['NOTERIMA'];
		$unit_t=$rows['UNIT_NAME'];
	  ?>
        <!--<tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i1; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $tglx; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $no_krm1; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $unit_t1; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['QTY_SATUAN']; ?></td>
          <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['HARGA_BELI_TOTAL'],0,",","."); ?></td>
        </tr>-->
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i1; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['qty']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['QTY_SATUAN']; ?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['HARGA_JUAL_SATUAN'],0,",","."); ?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['tot_kirim'],0,",",".");$subT1 += $rows['tot_kirim'];?></td>
        </tr>
		
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
	    <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td colspan="8" align="right" class="tdisikiri">Sub Total&nbsp;&nbsp;</td>
          <td class="tdisi" align="right"><?php echo number_format($subT1,0,",","."); ?></td>
        </tr>
      </table>
	</div>
</body>
</html>
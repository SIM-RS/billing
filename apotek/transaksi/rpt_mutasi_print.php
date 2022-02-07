<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl_d=$_REQUEST['tgl_d'];
if ($tgl_d=="")	$tgl_d=$tgl;
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$tgl_s=$_REQUEST['tgl_s'];
if ($tgl_s=="")	$tgl_s=$tgl;
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan emperkenalkan untuk melakukan ACT===
$username = $_REQUEST['username'];
$idunit1=$_REQUEST['idunit'];
if ($idunit1=="") $idunit1=$idunit;
$kelas=$_REQUEST['kelas'];if ($kelas=="") $fkelas=""; else{ if ($idunit1=="0") $fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'"; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";}
$golongan=$_REQUEST['golongan'];if ($golongan=="") $fgolongan=""; else{ if (($idunit1=="0")&&($kelas=="")) $fgolongan=" WHERE ao.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";}
$jenis=$_REQUEST['jenis'];if ($jenis=="") $fjenis=""; else { if (($idunit1=="0")&&($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE ao.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";}
$g1=$_REQUEST['g1'];
$k1=$_REQUEST['k1'];
$j1=$_REQUEST['j1'];
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="t6.OBAT_NAMA,t6.KEPEMILIKAN_ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
?>
<html>
<head>
<title>Laporan Mutasi Obat</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/print.css" type="text/css" />
</head>
<body>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <div id="listma" style="display:block">
      <span class="jdltable">LAPORAN MUTASI OBAT</span>
		
      <table>
        <tr> 
          <td align="left"><span class="txtinput">Unit </span></td>
          <td align="left"><span class="txtinput"> : 
            <?
		   	  if ($idunit1=="0"){
			  	  echo "ALL UNIT";
			  }else{
				  $qry="select * from a_unit where UNIT_ID=$idunit1";
				  $exe=mysqli_query($konek,$qry);
				  if ($show=mysqli_fetch_array($exe)){ 
					echo $show['UNIT_NAME'];
				  }
			  }
		  ?>
            </span> </td>
        </tr>
        <tr> 
          <td align="left"><span class="txtinput">Kelas </span></td>
          <td align="left"><span class="txtinput">: <?php echo $k1; ?></span></td>
        </tr>
        <tr> 
          <td align="left"><span class="txtinput">Golongan </span></td>
          <td align="left"><span class="txtinput">: <?php echo $g1; ?></span></td>
        </tr>
        <tr> 
          <td align="left"><span class="txtinput">Jenis</span></td>
          <td align="left"><span class="txtinput">: <?php echo $j1; ?></span></td>
        </tr>
        <tr> 
          <td colspan="2" align="center" class="txtcenter"><?php echo "(".$tgl_d; ?>&nbsp;s/d&nbsp;<?php echo $tgl_s.")"; ?></td>
        </tr>
      </table>	  
      <table width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" rowspan="2" class="tblheaderkiri">No</td>
          <td rowspan="2" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
            Obat </td>
          <td width="80" rowspan="2" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td height="25" colspan="2" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Saldo 
            Awal </td>
          <td colspan="4" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Masuk 
          </td>
          <td colspan="5" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Keluar</td>
          <td width="40" rowspan="2" class="tblheader" id="QTY_STOK" onClick="ifPop.CallFr(this);">Adj</td>
          <td colspan="2" class="tblheader" id="nilai" onClick="ifPop.CallFr(this);">Saldo 
            Akhir </td>
        </tr>
        <tr class="headtable"> 
          <td width="40" height="25" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Qty</td>
          <td width="80" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Nilai</td>
          <td width="40" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Pbf</td>
          <td width="40" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Unit</td>
          <td width="40" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Milik</td>
          <td width="40" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Ret 
            Rsp</td>
          <td width="40" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Rsp</td>
          <td width="40" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Unit</td>
          <td width="40" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Ret</td>
          <td width="40" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Milik</td>
          <td width="40" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Hapus</td>
          <td width="40" class="tblheader" id="nilai" onClick="ifPop.CallFr(this);">Qty</td>
          <td width="80" class="tblheader" id="nilai" onClick="ifPop.CallFr(this);">Nilai</td>
        </tr>
        <?php 
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
	  if ($idunit1=="0"){
	  	$sql="SELECT t6.* FROM (SELECT SUM(tmp.qty_awal) AS qty_awal,SUM(tmp.nilai_awal) AS nilai_awal,tmp.OBAT_ID,tmp.KEPEMILIKAN_ID,
			tmp.OBAT_NAMA,tmp.NAMA,tmp.MAXID_AKHIR,SUM(tmp.qty_akhir) AS qty_akhir,SUM(tmp.nilai_akhir) AS nilai_akhir,
			SUM(tmp.pbf) AS pbf,SUM(tmp.unit_in) AS unit_in,SUM(tmp.milik_in) AS milik_in,SUM(tmp.rt_rsp) AS rt_rsp,
			SUM(tmp.rsp) AS rsp,SUM(tmp.unit_out) AS unit_out,SUM(tmp.rt) AS rt,SUM(tmp.milik_out) AS milik_out,
			SUM(tmp.hapus) AS hapus,SUM(tmp.adj) AS adj
			FROM (SELECT IF (t4.STOK_AFTER IS NULL,0,t4.STOK_AFTER) AS qty_awal,
			IF (t4.NILAI_TOTAL IS NULL,0,t4.NILAI_TOTAL) AS nilai_awal, t5.PID1,t5.OBAT_ID,t5.KEPEMILIKAN_ID,t5.OBAT_NAMA,t5.NAMA,
			IF (t5.PID IS NULL,0,t5.PID) AS PID,IF (t5.MAXID_AKHIR IS NULL,0,t5.MAXID_AKHIR) AS MAXID_AKHIR, 
			IF (t5.qty_akhir IS NULL,IF (t4.STOK_AFTER IS NULL,0,t4.STOK_AFTER),t5.qty_akhir) AS qty_akhir,
			IF (t5.nilai_akhir IS NULL,IF (t4.NILAI_TOTAL IS NULL,0,t4.NILAI_TOTAL),t5.nilai_akhir) AS nilai_akhir,IF (t5.pbf IS NULL,0,t5.pbf) AS pbf, 
			IF (t5.unit_in IS NULL,0,t5.unit_in) AS unit_in,IF (t5.milik_in IS NULL,0,t5.milik_in) AS milik_in,
			IF (t5.rt_rsp IS NULL,0,t5.rt_rsp) AS rt_rsp, IF (t5.rsp IS NULL,0,t5.rsp) AS rsp,
			IF (t5.unit_out IS NULL,0,t5.unit_out) AS unit_out,IF (t5.rt IS NULL,0,t5.rt) AS rt, 
			IF (t5.milik_out IS NULL,0,t5.milik_out) AS milik_out,IF (t5.hapus IS NULL,0,t5.hapus) AS hapus,
			IF (t5.adj IS NULL,0,t5.adj) AS adj FROM (SELECT t1.*,k1.* 
			FROM (SELECT g1.*,ao.OBAT_NAMA,ake.NAMA FROM (SELECT DISTINCT CONCAT(ak.OBAT_ID,'-',ak.KEPEMILIKAN_ID,'-',ak.UNIT_ID) AS PID1,ak.OBAT_ID,ak.KEPEMILIKAN_ID
			FROM a_kartustok ak) AS g1 INNER JOIN a_obat ao ON g1.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ake ON g1.KEPEMILIKAN_ID=ake.ID LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID".$fkelas.$fgolongan.$fjenis.") AS t1 
			LEFT JOIN (SELECT CONCAT(b1.OBAT_ID,'-',b1.KEPEMILIKAN_ID,'-',b1.UNIT_ID) AS PID,b1.ID AS MAXID_AKHIR,b1.STOK_AFTER AS qty_akhir,
			b1.NILAI_TOTAL AS nilai_akhir, 
			SUM(IF (b1.UNIT_ID=17,IF (b1.tipetrans=4,IF (b1.DEBET IS NULL,0,b1.DEBET),0),IF (b1.tipetrans=0,IF (b1.DEBET IS NULL,0,b1.DEBET),0))) AS pbf, 
			SUM(IF (((b1.tipetrans=1 OR b1.tipetrans=2) AND (b1.UNIT_ID_KIRIM<>b1.UNIT_ID_TERIMA)),IF (b1.DEBET IS NULL,0,b1.DEBET),0)) AS unit_in, 
			SUM(IF ((b1.tipetrans=2 AND b1.UNIT_ID_KIRIM=b1.UNIT_ID_TERIMA),IF (b1.DEBET IS NULL,0,b1.DEBET),0)) AS milik_in, 
			SUM(IF ((b1.tipetrans=6 OR b1.tipetrans=7),IF (b1.KREDIT IS NULL,0,b1.KREDIT * -1),0)) AS rt_rsp, 
			SUM(IF (b1.UNIT_ID=17,IF (b1.tipetrans=4,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0),IF (b1.tipetrans=8,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0))) AS rsp, 
			SUM(IF (b1.tipetrans=1,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS unit_out, 
			SUM(IF ((b1.tipetrans=9 OR b1.tipetrans=7),IF (b1.DEBET IS NULL,0,b1.DEBET * -1),0)) AS rt, 
			SUM(IF (b1.tipetrans=2,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS milik_out, 
			SUM(IF (b1.tipetrans=10,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS hapus, 
			SUM(IF (b1.tipetrans=5,IF (b1.DEBET-b1.KREDIT IS NULL,0,b1.DEBET-b1.KREDIT),0)) AS adj 
			FROM (SELECT ak.*,ap.UNIT_ID_KIRIM,ap.UNIT_ID_TERIMA FROM a_kartustok ak LEFT JOIN a_penerimaan ap ON ak.fkid=ap.ID 
			WHERE DATE(ak.TGL_ACT) BETWEEN '$tgl_d1' AND '$tgl_s1' ORDER BY TGL_ACT DESC,ID DESC) AS b1
			GROUP BY b1.OBAT_ID,b1.KEPEMILIKAN_ID,b1.UNIT_ID) AS k1 ON t1.PID1=k1.PID) AS t5
			LEFT JOIN (SELECT CONCAT(t3.OBAT_ID,'-',t3.KEPEMILIKAN_ID,'-',t3.UNIT_ID) AS PID2,t3.STOK_AFTER,t3.NILAI_TOTAL 
			FROM (SELECT * FROM a_kartustok WHERE DATE(TGL_ACT)<'$tgl_d1' ORDER BY TGL_ACT DESC,ID DESC) AS t3 
			GROUP BY t3.OBAT_ID,t3.KEPEMILIKAN_ID,t3.UNIT_ID) AS t4 ON t5.PID1=t4.PID2) AS tmp 
			GROUP BY tmp.OBAT_ID,tmp.KEPEMILIKAN_ID) AS t6 WHERE (t6.qty_awal>0 OR t6.qty_akhir>0 OR ((t6.pbf+t6.unit_in+t6.milik_in+t6.rt_rsp+t6.rsp+t6.unit_out+t6.rt+t6.milik_out+t6.hapus+t6.adj)>0))".$filter." 
			ORDER BY ".$sorting;
	  }else{
		$sql="SELECT t6.* FROM (SELECT IF (t4.MAXID IS NULL,0,t4.MAXID) AS MAXID_AWAL,
			IF (t4.STOK_AFTER IS NULL,0,t4.STOK_AFTER) AS qty_awal,IF (t4.NILAI_TOTAL IS NULL,0,t4.NILAI_TOTAL) AS nilai_awal,
			t5.PID1,t5.OBAT_ID,t5.KEPEMILIKAN_ID,t5.OBAT_NAMA,t5.NAMA,IF (t5.PID IS NULL,0,t5.PID) AS PID,IF (t5.MAXID_AKHIR IS NULL,0,t5.MAXID_AKHIR) AS MAXID_AKHIR,
			IF (t5.qty_akhir IS NULL,t4.STOK_AFTER,t5.qty_akhir) AS qty_akhir,IF (t5.nilai_akhir IS NULL,t4.NILAI_TOTAL,t5.nilai_akhir) AS nilai_akhir,IF (t5.pbf IS NULL,0,t5.pbf) AS pbf,
			IF (t5.unit_in IS NULL,0,t5.unit_in) AS unit_in,IF (t5.milik_in IS NULL,0,t5.milik_in) AS milik_in,IF (t5.rt_rsp IS NULL,0,t5.rt_rsp) AS rt_rsp,
			IF (t5.rsp IS NULL,0,t5.rsp) AS rsp,IF (t5.unit_out IS NULL,0,t5.unit_out) AS unit_out,IF (t5.rt IS NULL,0,t5.rt) AS rt,
			IF (t5.milik_out IS NULL,0,t5.milik_out) AS milik_out,IF (t5.hapus IS NULL,0,t5.hapus) AS hapus,IF (t5.adj IS NULL,0,t5.adj) AS adj 
			FROM (SELECT t1.*,t2.* FROM (SELECT DISTINCT CONCAT(ak.OBAT_ID,ak.KEPEMILIKAN_ID) AS PID1,ak.OBAT_ID,ak.KEPEMILIKAN_ID,ao.OBAT_NAMA,ake.NAMA 
			FROM a_kartustok ak INNER JOIN a_obat ao ON ak.OBAT_ID=ao.OBAT_ID 
			INNER JOIN a_kepemilikan ake ON ak.KEPEMILIKAN_ID=ake.ID LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID 
			WHERE ak.UNIT_ID=$idunit1".$fkelas.$fgolongan.$fjenis." 
			ORDER BY ao.OBAT_NAMA,ake.ID) AS t1 LEFT JOIN 
			(SELECT CONCAT(b1.OBAT_ID,b1.KEPEMILIKAN_ID) AS PID,b1.ID AS MAXID_AKHIR,b1.STOK_AFTER AS qty_akhir,b1.NILAI_TOTAL AS nilai_akhir,
			SUM(IF (b1.UNIT_ID=17,IF (b1.tipetrans=4,IF (b1.DEBET IS NULL,0,b1.DEBET),0),IF (b1.tipetrans=0,IF (b1.DEBET IS NULL,0,b1.DEBET),0))) AS pbf, 
			SUM(IF (((b1.tipetrans=1 OR b1.tipetrans=2) AND (b1.UNIT_ID_KIRIM<>$idunit1)),IF (b1.DEBET IS NULL,0,b1.DEBET),0)) AS unit_in, 
			SUM(IF ((b1.tipetrans=2 AND b1.UNIT_ID_KIRIM=$idunit1),IF (b1.DEBET IS NULL,0,b1.DEBET),0)) AS milik_in,
			SUM(IF ((b1.tipetrans=6 OR b1.tipetrans=7),IF (b1.KREDIT IS NULL,0,b1.KREDIT * -1),0)) AS rt_rsp,
			SUM(IF (b1.UNIT_ID=17,IF (b1.tipetrans=4,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0),IF (b1.tipetrans=8,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0))) AS rsp,
			SUM(IF (b1.tipetrans=1,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS unit_out,
			SUM(IF ((b1.tipetrans=9 OR b1.tipetrans=7),IF (b1.DEBET IS NULL,0,b1.DEBET * -1),0)) AS rt,
			SUM(IF (b1.tipetrans=2,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS milik_out,
			SUM(IF (b1.tipetrans=10,IF (b1.KREDIT IS NULL,0,b1.KREDIT),0)) AS hapus,
			SUM(IF (b1.tipetrans=5,IF (b1.DEBET-b1.KREDIT IS NULL,0,b1.DEBET-b1.KREDIT),0)) AS adj 
			FROM (SELECT ak.*,ap.UNIT_ID_KIRIM FROM a_kartustok ak LEFT JOIN a_penerimaan ap ON ak.fkid=ap.ID 
			WHERE ak.UNIT_ID=$idunit1 AND DATE(ak.TGL_ACT) BETWEEN '$tgl_d1' AND '$tgl_s1' 
			ORDER BY TGL_ACT DESC,ID DESC) AS b1 
			GROUP BY b1.OBAT_ID,b1.KEPEMILIKAN_ID) AS t2 ON t1.PID1=t2.PID) AS t5 LEFT JOIN 
			(SELECT CONCAT(t3.OBAT_ID,t3.KEPEMILIKAN_ID) AS PID2,ID AS MAXID,t3.OBAT_ID,t3.KEPEMILIKAN_ID,t3.STOK_AFTER,t3.NILAI_TOTAL FROM (SELECT * FROM a_kartustok WHERE UNIT_ID=$idunit1 AND DATE(TGL_ACT)<'$tgl_d1' ORDER BY TGL_ACT DESC,ID DESC) AS t3 GROUP BY t3.OBAT_ID,t3.KEPEMILIKAN_ID) 
			AS t4 ON t4.PID2=t5.PID1) AS t6 WHERE (t6.qty_awal>0 OR t6.qty_akhir>0 OR ((t6.pbf+t6.unit_in+t6.milik_in+t6.rt_rsp+t6.rsp+t6.unit_out+t6.rt+t6.milik_out+t6.hapus+t6.adj)>0))".$filter." 
			ORDER BY ".$sorting;
	  }
	  //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$i=0;
	  $tsaldo_awal=0;
	  $tsaldo_akhir=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
//		$cidobat=$rows['OBAT_ID'];		
//		$cidkp=$rows['KEPEMILIKAN_ID'];
		$qty_awal=$rows['qty_awal'];
		$saldo_awal=$rows['nilai_awal'];
		$pbf=$rows['pbf'];
		$unit_in=$rows['unit_in'];
		$milik_in=$rows['milik_in'];
		$rt_rsp=$rows['rt_rsp'];
		$rsp=$rows['rsp'];
		$unit_out=$rows['unit_out'];
		$rt=$rows['rt'];
		$milik_out=$rows['milik_out'];
		$hapus=$rows['hapus'];
		$adj=$rows['adj'];
		$qty_akhir=$rows['qty_akhir'];
		$saldo_akhir=$rows['nilai_akhir'];
		$tsaldo_awal=$tsaldo_awal+floor($saldo_awal);
		$tsaldo_akhir=$tsaldo_akhir+floor($saldo_akhir);
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td align="center" class="tdisikiri" style="font-size:12px;"><?php echo $i; ?></td>
          <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $qty_awal; ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo number_format($saldo_awal,0,",",".");?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $pbf; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $unit_in; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $milik_in; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rt_rsp; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rsp; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $unit_out; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rt; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $milik_out; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $hapus; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $adj;?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $qty_akhir; ?></td>
          <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($saldo_akhir,0,",",".");?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
	  	<tr class="txtinput">
          <td colspan="4" align="right">Total Saldo Awal&nbsp;</td>
          <td align="right"><?php echo number_format($tsaldo_awal,0,",",".");?></td>
		  <td colspan="11" align="right">Total Saldo Akhir&nbsp;</td>
		  <td align="right"><?php echo number_format($tsaldo_akhir,0,",",".");?></td>
		</tr>
        <tr> 
          <td colspan="17" class="txtright"><b>&raquo; Tgl Cetak : </b><?php echo $tglctk ?><b> - User : </b><? echo $username; ?>&nbsp;&nbsp;</td>
        </tr>
      </table>
    </div>
</form>
</div>
<script>
 window.print();
 window.close();
</script>
</body>
<script>
function HProsen(a,b,c,d){
var e;
	//alert(b.value+'|'+c.value+'|'+d.value);
	if (a==1){
		e=b.value*c.value/100;
		d.value=(b.value)*1+e;
	}else if (a==2){
		e=((d.value)*1-(b.value)*1)*100/b.value;
		c.value=e;
	}
}
</script>
</html>
<?php 
mysqli_close($konek);
?>
<?php 
include("../sesi.php"); 
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",mysqli_real_escape_string($konek,$tgl));
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//$idunit=$_SESSION["ses_idunit"];
$idunit=mysqli_real_escape_string($konek,$_SESSION["ses_idunit"]);
//$bulan=$_REQUEST['bulan'];
$bulan=mysqli_real_escape_string($konek,$_REQUEST["bulan"]);
if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
//$ta=$_REQUEST['ta'];
$ta=mysqli_real_escape_string($konek,$_REQUEST["ta"]);
if ($ta=="") $ta=$th[2];
//$minta_id=$_REQUEST['minta_id'];
$minta_id=mysqli_real_escape_string($konek,$_REQUEST["minta_id"]);
//====================================================================
//Paging,Sorting dan Filter======
//$page=$_REQUEST["page"];
$page=mysqli_real_escape_string($konek,$_REQUEST["page"]);
$defaultsort="ko.tgl_act desc";
//$sorting=$_REQUEST["sorting"];
$sorting=mysqli_real_escape_string($konek,$_REQUEST["sorting"]);
//$filter=$_REQUEST["filter"];
$filter=mysqli_real_escape_string($konek,$_REQUEST["filter"]);
//===============================

//Aksi Save, Edit Atau Delete =========================================
//$act=$_REQUEST['act']; // Jenis Aksi
$act=mysqli_real_escape_string($konek,$_REQUEST["act"]);
//echo $act;

switch ($act){
 	case "delete":
		$sql="delete from a_minta_obat where permintaan_id=$minta_id";
		$rs=mysqli_query($konek,$sql);
		//echo $sql;
		break;
	case "tolak":
		$no_minta = $_REQUEST['no_minta'];
		$no_kirim = $_REQUEST['no_kirim'];
		$tgl_kirim = $_REQUEST['tgl_kirim'];
		$tgl_minta = $_REQUEST['tgl_minta'];
		//$munit = $_REQUEST['unit'];
		$alasan = $_REQUEST['alasan'];
		
		$sqlP = "select ap.*, IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot
				from a_penerimaan ap 
				where ap.NOKIRIM = '{$no_kirim}' AND ap.TANGGAL = '{$tgl_kirim}' AND ap.TIPE_TRANS = 1 AND ap.UNIT_ID_TERIMA = '{$idunit}'
				AND STATUS = 1";
		$queryP = mysqli_query($konek,$sqlP);
		if(mysqli_num_rows($queryP) > 0){
			while($dataP = mysqli_fetch_array($queryP)){
				$stokL = ($dataP['QTY_SATUAN']*1);
				$nilaiL = ($dataP['ntot']*1);
				
				$uPenrL = "update a_penerimaan ap 
							set
								ap.QTY_STOK = (ap.QTY_STOK + {$stokL})
							where ap.ID = ".$dataP['ID_LAMA'].";";
				$qPenrL = mysqli_query($konek,$uPenrL);
				//echo $uPenrL."<br />";
				
				$uPenrP = "update a_penerimaan ap 
							set
								ap.QTY_STOK = 0,
								ap.STATUS = 8,
								ap.USER_ID_TERIMA = '{$iduser}',
								ap.TGL_TERIMA_ACT = NOW(),
								ap.TGL_TERIMA = CURDATE()
							where ap.ID = ".$dataP['ID'];
				//echo $uPenrP."<br />";
				$qPenrP = mysqli_query($konek,$uPenrP);
			}
			
			// update status a_kirim_obat
			$sqlK = "UPDATE a_kirim_obat ko
					 SET ko.stat = 8
					 WHERE ko.no_minta = '{$no_minta}'
					   AND ko.no_kirim = '{$no_kirim}'
					   AND tgl_kirim = '{$tgl_kirim}'";
			$queryK = mysqli_query($konek,$sqlK) or die(mysqli_error($konek));
			
			$sql = "UPDATE a_minta_obat
					SET a_minta_obat.status = '8',
						alasan = '{$alasan}'
					WHERE no_bukti = '{$no_minta}'
					  AND unit_id = '{$idunit}'";
			$query = mysqli_query($konek,$sql);
			$jml = mysqli_affected_rows($konek);
			if($jml > 0){
				echo "<script type='text/javascript'>
							alert('Pengiriman Berhasil Di Tolak!');
							location='?f=../apotik/list_penerimaan.php';
						</script>";
			}
		}
}
//Aksi Save, Edit, Delete Berakhir ============================================
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
  <form name="form1" method="post" action="">
  	<input name="act" id="act" type="hidden" value="save">
	<input name="minta_id" id="minta_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <div id="listma" style="display:block">
      <p><span class="jdltable">DAFTAR PENGIRIMAN OBAT DARI UNIT LAIN</span></p> 
      <table width="80%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td colspan="6"><span class="txtinput">Bulan : </span> 
            <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=../apotik/list_penerimaan.php&bulan='+bulan.value+'&ta='+ta.value">
              <option value="1" class="txtinput"<?php if ($bulan=="1") echo "selected";?>>Januari</option>
              <option value="2" class="txtinput"<?php if ($bulan=="2") echo "selected";?>>Pebruari</option>
              <option value="3" class="txtinput"<?php if ($bulan=="3") echo "selected";?>>Maret</option>
              <option value="4" class="txtinput"<?php if ($bulan=="4") echo "selected";?>>April</option>
              <option value="5" class="txtinput"<?php if ($bulan=="5") echo "selected";?>>Mei</option>
              <option value="6" class="txtinput"<?php if ($bulan=="6") echo "selected";?>>Juni</option>
              <option value="7" class="txtinput"<?php if ($bulan=="7") echo "selected";?>>Juli</option>
              <option value="8" class="txtinput"<?php if ($bulan=="8") echo "selected";?>>Agustus</option>
              <option value="9" class="txtinput"<?php if ($bulan=="9") echo "selected";?>>September</option>
              <option value="10" class="txtinput"<?php if ($bulan=="10") echo "selected";?>>Oktober</option>
              <option value="11" class="txtinput"<?php if ($bulan=="11") echo "selected";?>>Nopember</option>
              <option value="12" class="txtinput"<?php if ($bulan=="12") echo "selected";?>>Desember</option>
            </select>
            <span class="txtinput">Tahun : </span> 
            <select name="ta" id="ta" class="txtinput" onChange="location='?f=../apotik/list_penerimaan.php&bulan='+bulan.value+'&ta='+ta.value">
            <?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
              <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
            <? }?>
            </select></td>
          <td align="right" colspan="6">
		  <!--BUTTON type="button" onClick="location='?f=minta_obat.php'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Buat Permintaan Baru</BUTTON-->
		  </td>
	    </tr>
	</table>
      <table width="80%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="tgl" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td id="no_minta" width="200" class="tblheader" onClick="ifPop.CallFr(this);">No Permintaan </td>
          <td id="no_kirim" width="200" class="tblheader" onClick="ifPop.CallFr(this);">No Kirim</td>
          <td width="100" class="tblheader" id="UNIT_NAME" onClick="ifPop.CallFr(this);">Unit 
            Pengirim </td>
          <td id="" width="60" class="tblheader" onClick="">Status</td>
          <td class="tblheader" width="30">Proses</td>
          <td class="tblheader" width="30">Tolak</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT t2.* FROM (SELECT t1.*,au.UNIT_ID,au.UNIT_NAME FROM (SELECT DISTINCT DATE_FORMAT(ap.TANGGAL,'%d/%m/%Y') AS tgl1, ap.TANGGAL, DATE_FORMAT(ap.TGL_TERIMA,'%d/%m/%Y') AS tgl2,
ap.NOKIRIM,ap.NOTERIMA,ap.STATUS,am.no_bukti,SUM(am.qty) AS qty_minta,SUM(qty_terima) AS qty_terima,ap.UNIT_ID_KIRIM 
FROM (SELECT * FROM a_penerimaan WHERE UNIT_ID_TERIMA=$idunit AND TIPE_TRANS=1 AND MONTH(TANGGAL)=$bulan AND YEAR(TANGGAL)=$ta) AS ap INNER JOIN a_minta_obat am ON ap.FK_MINTA_ID=am.permintaan_id 
GROUP BY ap.NOKIRIM,am.no_bukti ORDER BY $sorting) AS t1 INNER JOIN a_unit au ON t1.UNIT_ID_KIRIM=au.UNIT_ID) AS t2".$filter;

		$sql = "SELECT ko.tgl_kirim, DATE_FORMAT(ko.tgl_kirim, '%d/%m/%Y') tgl, mo.tgl tgl_minta,
				  DATE_FORMAT(mo.tgl, '%d/%m/%Y') AS tgl1, ko.no_kirim, ko.no_minta, ko.unit_kirim,
				  u.UNIT_NAME,u.UNIT_ID,
				  /* ifnull(ko.stat, if(ap.STATUS = 1, 2, if(ap.STATUS = 0, 1, ap.STATUS))) stats1, */
				  IF(ko.stat IS NOT NULL, ko.stat, IF(ap.STATUS = 1, 2, IF(ap.STATUS = 0, 1, ap.STATUS))) AS `status`
				FROM a_kirim_obat ko
				INNER JOIN a_minta_obat mo
				   ON mo.permintaan_id = ko.minta_id
				INNER JOIN a_unit u 
					ON u.UNIT_ID = ko.unit_kirim 
				INNER JOIN a_penerimaan ap
				   ON ap.NOKIRIM = ko.no_kirim
				WHERE ko.unit_tujuan = '{$idunit}'
				  AND MONTH(ko.tgl_kirim) = '{$bulan}'
				  AND YEAR(ko.tgl_kirim) = '{$ta}' AND ap.AKTIF=1
				  {$filter}
				GROUP BY ko.no_kirim, ko.no_minta
				ORDER BY {$sorting}";
		// echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$istatus=$rows['status'];
		switch ($istatus){
			/* case 0:
				$cstatus="Dikirim";
				$lnk="?f=../apotik/list_penerimaan_detail.php&no_minta=".$rows['no_minta']."&no_gdg=".$rows['no_kirim']."&iunit_krm=".$rows['UNIT_NAME']."&idunit_krm=".$rows['UNIT_ID']."&page=".$page."&bulan=".$bulan."&ta=".$ta;
				break;
			case 1:
				if ($rows['qty_minta']>$rows['qty_terima']) $cstatus="Diterima(-)"; else $cstatus="Diterima";
				$lnk="?f=../apotik/list_penerimaan_detail.php&no_minta=".$rows['no_minta']."&no_gdg=".$rows['no_kirim']."&iunit_krm=".$rows['UNIT_NAME']."&isview=true"."&page=".$page."&bulan=".$bulan."&ta=".$ta;
				break; */
			case 1:
				$cstatus="Dikirim";
				$lnk="?f=../apotik/list_penerimaan_detail.php&no_minta=".$rows['no_minta']."&no_gdg=".$rows['no_kirim']."&iunit_krm=".$rows['UNIT_ID']."&idunit_krm=".$rows['UNIT_ID']."&page=".$page."&bulan=".$bulan."&ta=".$ta;
				break;
			case 2:
				if ($rows['qty_minta']>$rows['qty_terima']) $cstatus="Diterima(-)"; else $cstatus="Diterima";
				$lnk="?f=../apotik/list_penerimaan_detail.php&no_minta=".$rows['no_minta']."&no_gdg=".$rows['no_kirim']."&iunit_krm=".$rows['UNIT_ID']."&isview=true"."&page=".$page."&bulan=".$bulan."&ta=".$ta;
				break;
			case 8:
				$cstatus = "Ditolak"; 
				$lnk = "";
		}
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['no_minta']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['no_kirim']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="center"><?php echo $cstatus; ?></td>
          <td class="tdisi"><!--img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Melihat Detail Pengiriman Obat/Alkes" onClick="location='<?php echo $lnk; ?>'"-->
			<?php if($istatus != '8'){?>
				<img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Melihat Detail Pengiriman Obat/Alkes" onClick="location='<?php echo $lnk; ?>'">
			<?php } else { echo "-"; } ?>
		  </td>
		  <td class="tdisi">
				<?php if($istatus == '1'){?>
				<img src="../icon/cancel.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menolak Permintaan Obat" onClick="if(confirm('Yakin ingin Menolak Permintaan?')){tolakk('?act=tolak&f=../apotik/list_penerimaan.php&no_kirim=<?php echo $rows['no_kirim']; ?>&tgl_kirim=<?php echo $rows['tgl_kirim']; ?>&no_minta=<?php echo $rows['no_minta']; ?>&tgl_minta=<?php echo $rows['tgl1']; ?>&iunit=<?php echo $iunit; ?>&nunit=<?php echo $rows['UNIT_NAME']; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>')}">
				<?php } else { echo "-"; } ?>
		  </td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="4" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
      </table>
    </div>
</form>
</div>
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

function tolakk(par){
	var alas = prompt('Masukkan Alasan Penolakan', '');
	if(alas == null || (alas) == ''){
		alert("Masukkan Alasan Penolakan Terlebih dahulu !");
	} else {
		location=par+'&alasan='+alas;
	}
}
</script>
</html>
<?php 
mysqli_close($konek);
?>
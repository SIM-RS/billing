<?php 
include("../sesi.php");
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",mysqli_real_escape_string($konek,$tgl));
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//$idunit=$_SESSION["ses_idunit"];
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
$defaultsort="am.permintaan_id desc";
//$sorting=$_REQUEST["sorting"];
$sorting=mysqli_real_escape_string($konek,$_REQUEST["sorting"]);
//$filter=$_REQUEST["filter"];
$filter=mysqli_real_escape_string($konek,$_REQUEST["filter"]);
//Aksi Save, Edit Atau Delete =========================================
//$act=$_REQUEST['act']; // Jenis Aksi
$act=mysqli_real_escape_string($konek,$_REQUEST["act"]);
//$statPer = $_REQUEST['stat'];
$statPer=mysqli_real_escape_string($konek,$_REQUEST["statPer"]);
//echo $act;

switch ($act){
 	case "delete":
		$sql="delete from a_minta_obat where permintaan_id=$minta_id";
		$rs=mysqli_query($konek,$sql);
		//echo $sql;
		break;
	case "tolak":
		$no_minta = $_REQUEST['no_minta'];
		$munit = $_REQUEST['iunit'];
		$alasan = $_REQUEST['alasan'];
		$sql = "UPDATE a_minta_obat
				SET a_minta_obat.status = '9',
					alasan = '{$alasan}'
				WHERE no_bukti = '{$no_minta}'
				  AND unit_id = '{$munit}'";
		$query = mysqli_query($konek,$sql);
		$jml = mysqli_affected_rows($konek);
		if($jml > 0){
			echo "<script type='text/javascript'>
						alert('Permintaan Berhasil Di Tolak!');
						location='?f=../gudang/list_permintaan.php';
					</script>";
		}
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<meta http-equiv="refresh" content="5000" >
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
      <p><span class="jdltable">DAFTAR PERMINTAAN UNIT</span> 
      <table width="80%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td colspan="6"><span class="txtinput">Bulan : </span> 
            <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=../gudang/list_permintaan.php&bulan='+bulan.value+'&ta='+ta.value+'&stat='+statPer.value">
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
            <select name="ta" id="ta" class="txtinput" onChange="location='?f=../gudang/list_permintaan.php&bulan='+bulan.value+'&ta='+ta.value+'&stat='+statPer.value">
            <?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
              <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
            <? }?>
            </select></td>
          <td width="20%" colspan="6" align="right">
			<span class="txtinput">Status : </span> 
			<select name="statPer" id="statPer" onChange="location='?f=../gudang/list_permintaan.php&bulan='+bulan.value+'&ta='+ta.value+'&stat='+statPer.value">
				<option value="0" <?php if($statPer == 0 || $statPer == '') echo 'selected'; else echo '';?> >Semua</option>
				<option value="1" <?php if($statPer == 1) echo 'selected'; else echo '';?> >Belum Dikirim</option>
				<option value="2" <?php if($statPer == 2) echo 'selected'; else echo '';?> >Dikirim</option>
				<!--option value="3" <?php if($statPer == 3) echo 'selected'; else echo '';?>>Dikirim Sebagian</option-->
				<option value="4" <?php if($statPer == 4) echo 'selected'; else echo '';?>>Diterima</option>
				<!--option value="5" <?php if($statPer == 5) echo 'selected'; else echo '';?>>Diterima Sebagian</option-->
			</select>
		  <!--BUTTON type="button" onClick="location='?f=minta_obat.php'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Buat Permintaan Baru</BUTTON-->		  </td>
	    </tr>
	</table>
      <table width="80%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="tgl" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td id="no_bukti" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Permintaan </td>
          <td id="UNIT_NAME" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Unit</td>
          <td id="NAMA" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td width="100" class="tblheader" onClick="ifPop.CallFr(this);">Status</td>
          <td class="tblheader" colspan="3" width="30">Proses</td>
          <td class="tblheader" width="30">Tolak</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  
	  $statPer = $_REQUEST['stat'];
	  $statusPer = "";
	  
	  switch($statPer){
			case 0: //Semua
				$statusPer = '';
				break;
			case 1: //Belum Dikirim
				$statusPer = ' WHERE t1.blm_dikirim <> 0 AND t1.dikirim = 0 AND t1.diterima = 0';
				break;
			case 2: //Dikirim
				$statusPer = ' WHERE t1.dikirim <> 0 AND t1.diterima = 0'; //WHERE t1.blm_dikirim = 0 AND t1.dikirim <> 0 AND t1.diterima = 0
				break;
			case 3: //Dikirim Sebagian
				$statusPer = ' WHERE t1.blm_dikirim <> 0 AND t1.dikirim <> 0 AND t1.diterima = 0';
				break;
			case 4: //Diterima
				$statusPer = ' WHERE t1.diterima <> 0';
				break;
			case 5: //Diterima Sebagian
				$statusPer = ' WHERE t1.dikirim <> 0 AND t1.diterima <> 0';
				break;
		}
	  /* $sql="select distinct date_format(am.tgl,'%d/%m/%Y') as tgl1,am.no_bukti,au.UNIT_ID,au.UNIT_NAME,ak.NAMA 
	  COUNT(CASE WHEN am.status = 0 THEN am.status END) blm_dikirim,
	  COUNT(CASE WHEN am.status = 1 THEN am.status END) dikirim,
	  COUNT(CASE WHEN am.status = 2 THEN am.status END) diterima
	  from a_minta_obat am inner join a_unit au on am.unit_id=au.UNIT_ID inner join a_kepemilikan ak on am.kepemilikan_id=ak.ID where month(am.tgl)=$bulan and year(am.tgl)=$ta and am.unit_tujuan=$idunit".$filter." {$statusPer} order by ".$sorting; */
	  
	  $sql ="
		SELECT *
		FROM(SELECT
			  DATE_FORMAT(am.tgl, '%d/%m/%Y') AS tgl1,
			  am.no_bukti,
			  au.UNIT_ID,
			  au.UNIT_NAME,
			  ak.NAMA,
			  COUNT(CASE WHEN am.status = 0 THEN am.status END) blm_dikirim,
			  COUNT(CASE WHEN am.status = 1 THEN am.status END) dikirim,
			  COUNT(CASE WHEN am.status = 2 THEN am.status END) diterima
			FROM
			  a_minta_obat am 
			  INNER JOIN a_unit au 
				ON am.unit_id = au.UNIT_ID 
			  INNER JOIN a_kepemilikan ak 
				ON am.kepemilikan_id = ak.ID 
			WHERE MONTH(am.tgl) = {$bulan} 
			  AND YEAR(am.tgl) = {$ta} 
			  AND am.unit_tujuan = {$idunit} 
			  {$filter}
			GROUP BY am.no_bukti
			ORDER BY $sorting ) t1
		$statusPer
	  ";
	  //echo $sql."<br>";
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
	  //$arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$no_bukti=$rows['no_bukti'];
		$iunit=$rows['UNIT_ID'];
/*		$sql="select t2.* from (select am1.*,if (t1.jml is null,0,t1.jml) as qty_kirim from a_minta_obat am1 left join (select ap.FK_MINTA_ID,sum(ap.QTY_SATUAN) as jml from a_penerimaan ap inner join a_minta_obat am on ap.FK_MINTA_ID=am.permintaan_id where ap.UNIT_ID_KIRIM=$idunit and ap.UNIT_ID_TERIMA=$iunit and ap.TIPE_TRANS=1 and am.no_bukti='$no_bukti' group by ap.FK_MINTA_ID) as t1 on am1.permintaan_id=t1.FK_MINTA_ID where am1.no_bukti='$no_bukti') as t2 where t2.qty>t2.qty_kirim";
		//echo $sql."<br>";
		$rs1=mysqli_query($konek,$sql);
		$qty_kurang=0;
		if ($rows1=mysqli_fetch_array($rs1)){
			$qty_kurang=1;
		}*/
		
		$sql="select am.status, SUM(am.qty-am.qty_terima) as qty_sisa
		from a_minta_obat am where am.no_bukti='$no_bukti' and am.unit_id=$iunit 
		group by status
		order by am.status asc";
		//echo $sql."<br>";
		$rs1=mysqli_query($konek,$sql);
		$jmlrow=mysqli_num_rows($rs1);
		$tmpStat = 0;
		
		while($rows1=mysqli_fetch_array($rs1)){
			$istatus=$rows1['status'];
			$qty_sisa=$rows1['qty_sisa'];
			switch($rows1['status']){
				case 2:
					$tmpStat = 2;
					break;
				case 8:
					$tmpStat = 8;
					break;
			}
		}
		
		$istatus = ($tmpStat > 0) ? $tmpStat : $istatus;
		
		switch ($istatus){
			case 0:
				$cstatus="Blm Dikirim";
				break;
			case 1:
				if ($jmlrow==1) $cstatus="Dikirim"; else $cstatus="Dikirim(-)";
				break;
			case 2:
				if (($jmlrow==1)&&($qty_sisa<=0)) $cstatus="Diterima"; else $cstatus="Diterima(-)";
				break;
			case 7:
				$cstatus = "Dikirim(-)";
				break;
			case 8:
				$cstatus = "Dikirim - Ditolak";
				break;
			case 9:
				$cstatus = "Diminta - Ditolak";
				break;
		}
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center"><?php echo $no_bukti; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $cstatus; ?></td>
          <td width="25" class="tdisi"><img src="../icon/lihat.gif" border="0" width="25" height="25" align="absmiddle" class="proses" title="Klik Untuk Melihat Permintaan Obat" onClick="location='?f=../gudang/isi_permintaan_detail&no_minta=<?php echo $no_bukti; ?>&tgl_minta=<?php echo $rows['tgl1']; ?>&iunit=<?php echo $rows['UNIT_NAME']; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>&page=<?php echo $page; ?>'"></td>
          <td width="25" class="tdisi"><img src="../icon/glossary.gif" border="0" width="18" height="18" align="absmiddle" class="proses" title="Klik Untuk Melihat Daftar Obat Yg Sudah Dikirimkan" onClick="location='?f=../gudang/list_sdh_dikirim_detail&no_minta=<?php echo $no_bukti; ?>&tgl_minta=<?php echo $rows['tgl1']; ?>&iunit=<?php echo $rows['UNIT_NAME']; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>&page=<?php echo $page; ?>'"></td>
          <td width="25" class="tdisi">
			<?php if($istatus != 9){ ?>
			<img src="../icon/published.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengirim Permintaan Obat" onClick="<?php if ($cstatus=="Diterima"){?>alert('Obat Yg Diminta Sudah Dikirim Semua !');<?php }else{?>location='?f=../gudang/list_permintaan_detail.php&no_minta=<?php echo $rows['no_bukti']; ?>&tgl_minta=<?php echo $rows['tgl1']; ?>&iunit=<?php echo $iunit; ?>&nunit=<?php echo $rows['UNIT_NAME']; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>&page=<?php echo $page; ?>'<?php }?>">
			<?php } else { echo '-'; }?>
		  </td>
		  <td width="25" class="tdisi">
				<?php if($istatus == '0'){?>
				<img src="../icon/cancel.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menolak Permintaan Obat" onClick="if(confirm('Yakin ingin Menolak Permintaan?')){
					tolakk('?act=tolak&f=../gudang/list_permintaan.php&no_minta=<?php echo $rows['no_bukti']; ?>&tgl_minta=<?php echo $rows['tgl1']; ?>&iunit=<?php echo $iunit; ?>&nunit=<?php echo $rows['UNIT_NAME']; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>');
				}">
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
          <td colspan="6" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;          </td>
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

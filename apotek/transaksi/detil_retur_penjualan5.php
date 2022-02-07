<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
//===============TANGGALAN===================
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tglSkrg=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tglSkrg);
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0"?substr($th[1],1,1):$th[1]);
$bulan=explode("|",$bulan);
//=========================================
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$id=$_REQUEST['id'];
$no_penjualan=$_REQUEST['no_penjualan'];
if($_GET['nama_pasien']=="") $nama_pasien=0; else $nama_pasien=$_GET['nama_pasien'];
$no_retur=$_REQUEST['no_retur'];
$no_returPrint=$no_retur;
$obat_id=$_REQUEST['obat_id'];
if($_GET['pbf']==""){$pbf_id=0;}else{$pbf_id=$_GET['pbf'];}
$no_retur=$_REQUEST['no_retur'];
$tgl_s=$_REQUEST['tgl_s'];
	$s=explode("-",$tgl_s);
	$tgl_se=trim($s[2])."-".trim($s[1])."-".trim($s[0]);
$tgl_d=$_REQUEST['tgl_d'];
	$d=explode("-",$tgl_d);
	$tgl_de=trim($d[2])."-".trim($d[1])."-".trim($d[0]);
$qty_satuan=$_REQUEST['qty_satuan'];
$status=1;
//====================================================================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ID DESC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act."<br>";

switch ($act){
	case "save":
	for ($i = 0; $i < count($qty_satuan); $i++)
	  {
		//Cek apakah data yg dimasukkan melebihi stok
		$sqlCekQty="SELECT QTY_JUAL FROM a_penjualan WHERE ID=$id[$i]";
		$exeCekQty=mysqli_query($konek,$sqlCekQty);
		$showCekQty=mysqli_fetch_array($exeCekQty);
		//echo $showCekQty['QTY_SATUAN']."<BR>";
		if($qty_satuan[$i]>$showCekQty['QTY_JUAL'])
			{
			echo "<script> alert('Maaf, Quantity yang anda masukkan melebihi stok, Silahkan Ulangi!') </script>";
			}else{	
			$sql="update a_penjualan SET NO_RETUR='$no_retur',TGL_RETUR='$tgl_act', QTY_RETUR=$qty_satuan[$i],QTY=QTY_JUAL-$qty_satuan[$i] WHERE ID=$id[$i]";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			}
		}
		/*$sql2="SELECT SUM(SUB_TOTAL) FROM a_penjualan WHERE no_penjualan ='$no_penjualan' and UNIT_ID=$idunit";
		$exe2=mysqli_query($konek,$sql2);
		$show2=mysqli_fetch_array($exe2);
		//echo $sql2."<br>";
		$perbarui="UPDATE a_penjualan SET SUM_SUB_TOTAL=".$show2['SUM(SUB_TOTAL)']." WHERE no_penjualan ='$no_penjualan' and UNIT_ID=$idunit";
		$aksi=mysqli_query($konek,$perbarui);
		//echo $perbarui."<br>"; 
		 echo "<script>if ($rs){location='?f=../transaksi/retur_penjualan.php';}</script>"; */
		break;

}
//Aksi Save, Edit, Delete Berakhir ============================================
?>
<!-- Script Pop Up Window -->
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
</script>
<?php if($act=="save"){
//==Jika dalam keadaan simpan====== ?>
<style type="text/css">
.style1 { font-family: "Courier New", Courier, monospace; font-size:14px; }
</style>

<!-- UNTUK DI PRINT OUT -->
<div id="idArea" style="display:block;">
<?php for ($i = 0; $i < count($no_penjualan); $i++){
 
	$qrySingle="SELECT a_penjualan.*,a_kepemilikan.NAMA,a_user.username from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_user on a_penjualan.USER_ID=a_user.kode_user WHERE a_penjualan.NO_PENJUALAN=$no_penjualan[$i] and UNIT_ID=$idunit";
	$exeSingle=mysqli_query($konek,$qrySingle);
	//echo $qrySingle;
	$showSingle=mysqli_fetch_array($exeSingle);
	?>
	<!--link rel="stylesheet" href="../theme/print.css" type="text/css"/-->

		<table width="413" height="113" border="0" align="left" cellpadding="0" cellspacing="0" class="style1">
         <tr class="style1">
            <td height="45" colspan="2" class="style1" style="font-size:16px"><b><?=$namaRS;?><br>
            <?=$alamatRS;?></b><hr size="1" color="#000000"></td>
          </tr>
          <tr>
            <td colspan="2">
			<?php $u="select UNIT_NAME from a_unit where UNIT_ID='$idunit'";
				//echo $u;
				$rsu=mysqli_query($konek,$u);
				$row=mysqli_fetch_array($rsu);
				echo $row['UNIT_NAME'];
			?>&nbsp;</td>
            </tr>
          <tr>
		  
            <td>No. Kwitansi </td>
            <td>: <?php echo $showSingle['NO_PENJUALAN']; ?></td>
          </tr>
            <td width="162">Tanggal</td>
            <td width="180">: <?php echo date("d/m/y H:i:s",strtotime($showSingle['TGL_ACT'])); ?></td>
          </tr>
          <tr>
            <td>No. Kunjungan</td>
            <td>: <?php echo $showSingle['NO_KUNJUNGAN']; ?></td>
          </tr>
          <tr >
            <td>No Rekam Medis</td>
            <td>: <?php echo $showSingle['NO_PASIEN']; ?></td>
          </tr>
          <tr>
            <td >Nama Pasien </td>
            
      <td >: <?php echo $showSingle['NAMA_PASIEN']; ?></td>
          </tr>
          <tr>
            <td >Jenis Pasien</td>
            <td >: <?php echo $showSingle['NAMA']; ?></td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" ><table width="414" border="0" cellpadding="0" cellspacing="0" align="left">
            <?php 
				  $sqlPrint="SELECT a_penjualan.ID,NO_PENJUALAN,TGL_ACT,NO_KUNJUNGAN,NO_PASIEN,NAMA_PASIEN,JENIS_PASIEN_ID,a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,HARGA_SATUAN,a_penjualan.QTY from a_penjualan Inner Join a_penerimaan ON a_penjualan.PENERIMAAN_ID = a_penerimaan.ID Inner Join a_obat ON a_penerimaan.OBAT_ID = a_obat.OBAT_ID where a_penjualan.NO_PENJUALAN='$no_penjualan[$i]' and UNIT_ID=$idunit group by NO_PENJUALAN,TGL,NO_KUNJUNGAN,NO_PASIEN,NAMA_PASIEN,JENIS_PASIEN_ID,a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,HARGA_SATUAN ";
				  //echo $sqlPrint;
				  $exePrint=mysqli_query($konek,$sqlPrint);
				  $i=1;
				  //$showPrint=mysqli_fetch_array($exePrint);
				  while($showPrint=mysqli_fetch_array($exePrint)){
				  ?>
            <tr>
              <td width="42" align="center" class="style1"><?php echo $i++ ?></td>
              <td width="328" class="style1"><?php echo $showPrint['OBAT_NAMA']; ?></td>
              <td width="44" class="style1"><?php echo $showPrint['QTY']; ?></td>
            </tr>
            <?  } ?>
           
            <tr>
              <td colspan="4" align="right" class="style1">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4" align="right" class="style1">Harga Total : Rp. <?php echo number_format($showSingle['HARGA_TOTAL'],2,",","."); ?></td>
            </tr>
            <tr>
				<?php 
/*       function kekata($x) {
          $x = abs($x);
          $angka = array("", "satu", "dua", "tiga", "empat", "lima",
          "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
          $temp = "";
          if ($x <12) {
              $temp = " ". $angka[$x];
          } else if ($x <20) {
              $temp = kekata($x - 10). " belas";
          } else if ($x <100) {
              $temp = kekata($x/10)." puluh". kekata($x % 10);
          } else if ($x <200) {
              $temp = " seratus" . kekata($x - 100);
          } else if ($x <1000) {
              $temp = kekata($x/100) . " ratus" . kekata($x % 100);
          } else if ($x <2000) {
              $temp = " seribu" . kekata($x - 1000);
          } else if ($x <1000000) {
              $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
          } else if ($x <1000000000) {
              $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
          } else if ($x <1000000000000) {
              $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
          } else if ($x <1000000000000000) {
              $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
          }      
              return $temp;
      }
      function terbilang($x, $style=4) {
          if($x<0) {
              $hasil = "minus ". trim(kekata($x));
          } else {
              $hasil = trim(kekata($x));
          }      
          switch ($style) {
              case 1:
                  $hasil = strtoupper($hasil);
                  break;
              case 2:
                  $hasil = strtolower($hasil);
                  break;
              case 3:
                  $hasil = ucwords($hasil);
                  break;
              default:
                  $hasil = ucfirst($hasil);
                  break;
          }      
          return $hasil;
      }
	  $bilangan= $showSingle['HARGA_TOTAL'];
	  $bilangan=terbilang($bilangan,3);
	  
	  //=====Bilangan setelah koma=====
	  $sakKomane=explode(".",$showSingle['HARGA_TOTAL']);
	  $koma=$sakKomane[1];
	  $koma=terbilang($koma,3);
	  if($sakKomane[1]<>"") $koma= "Koma ".$koma."&nbsp;";
 */      ?>
             <td colspan="4" align="right" class="style1"><?php //echo $bilangan."&nbsp;".$koma."Rupiah";?></td>
            </tr>
            <tr>
              <td colspan="4" align="right" class="style1" style="padding-right:5px;;text-align:left">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4" align="right" class="style1" style="padding-right:5px;;text-align:left">Kasir : <?php echo $showSingle['username']; ?></td>
            </tr>
		  <tr>
              <td colspan="4" align="right" style="padding-right:5px;font-size:18px"><div align="left"><span style="font-size:14px; "><em>Bukti pembayaran ini juga berlaku sebagai kwitansi</em></span></div></td>
          </tr>
          </table>
		  </div>
	<?php  } ?>
	<p align="center">
	<a class="navText" href="../report/kwi_retur.php?no_penjualan=<?php echo $no_penjualan[$i];?>&sunit=<?php echo $idunit; ?>"  onClick="NewWindow(this.href,'name','500','500','yes');return false">
    <BUTTON type="button"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Retur No.Penjualan <?php echo $no_penjualan[$i];?></BUTTON></a>
</p>&nbsp;<BUTTON type="button" onClick="location='?f=../transaksi/retur_penjualan.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali Ke Daftar &nbsp;</BUTTON>
	</p>
<?php 
//==Jika Dalam keadaan Disimpan berakhir===	
}else{
	$sql="select NO_RETUR from a_penjualan where NO_RETUR<>0 order by NO_RETUR desc limit 1";
	$rs=mysqli_query($konek,$sql);
	$rows=mysqli_fetch_array($rs);
	$nortr="000001";
	$cek=mysqli_num_rows($rs);
	//echo "$cek<br>";
	if ($cek>0) {
	$nortr=(int)$rows['NO_RETUR']+1;
	$noretur=(string)$nortr;
			if (strlen($noretur)<6){
			for ($i=0;$i<(6-strlen($noretur));$i++) $nortr="0".$nortr;
		}
	}

?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<!-- Script Pop Up Window Berakhir -->
<script language="JavaScript" type="text/JavaScript">
var RowIdx;
var fKeyEnt;
function suggest(e,par){
var keywords=par.value;//alert(keywords);
	if(keywords==""){
		document.getElementById('divobat').style.display='none';
	}else{
		var key;
		if(window.event) {
		  key = window.event.keyCode; 
		}
		else if(e.which) {
		  key = e.which;
		}
		//alert(key);
		if (key==38 || key==40){
			var tblRow=document.getElementById('pasienlist_penj').rows.length;
			if (tblRow>0){
				//alert(RowIdx);
				if (key==38 && RowIdx>0){
					RowIdx=RowIdx-1;
					document.getElementById(RowIdx+1).className='itemtableReq';
					if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
				}else if (key==40 && RowIdx<tblRow){
					RowIdx=RowIdx+1;
					if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
					document.getElementById(RowIdx).className='itemtableMOverReq';
				}
			}
		}else if (key==13){
			if (RowIdx>0){
				if (fKeyEnt==false){
					fSetObat(document.getElementById(RowIdx).lang);
				}else{
					fKeyEnt=false;
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			RowIdx=0;
			fKeyEnt=false;
			Request('../transaksi/pasienlist_penj.php?aKepemilikan=0&aKeyword='+keywords , 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}

function fSetObat(par){
var cdata=par.split("*|*");
var tbl = document.getElementById('tblJual');
var tds;
	document.forms[0].nama_pasien.value=cdata[1];
	document.forms[0].no_pasien.value=cdata[2];
	document.getElementById('divobat').style.display='none';
}
</script>

<script>
var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs1.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>

<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 100px; width:325px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<div align="center"> 
  <div id="input" style="display:block">
      <p class="jdltable">Detil Retur Penjualan </p>
	 <form name="form1" method="post" action="">
	<input name="act" id="act" type="hidden" value="save">
	<input name="retur_penjualan_id" id="retur_penjualan_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
      <table width="851" border="0" align="center" cellpadding="0" cellspacing="0" class="txtinput">
         <tr>
            <td width="203">Nama Pasien</td>
            <td width="11">:</td>
            <td colspan="2">
			<input name="nama_pasien" size="50" id="nama_pasien" value="<?php echo $_GET['nama_pasien']; ?>" class="txtinput" onKeyUp="suggest(event,this);" autocomplete="off">
		   <!--button class="txtcenter" onClick="location='?f=../transaksi/detil_retur_penjualan.php&no_penjualan='+no_penjualan.value"><img src="../icon/go.png" height="16" width="16"></button-->			</td>
        </tr>
		  <tr>
            <td height="25">No. Retur </td>
		    <td>:</td>
		    <td colspan="2" ><input name="no_retur" id="no_retur" value="<? echo "$nortr"; ?>" class="txtinput" type="text" readonly="true"></td>
	    </tr>
		  <tr>
		    
          <td height="25">No. Rekam Medis</td>
		    <td>:</td>
		    <td colspan="2" ><input name="no_pasien" id="no_pasien" value="<?php echo $_GET['no_pasien']; ?>" class="txtinput" readonly="true" type="text"></td>
	    </tr>
		  <tr>
            <td height="25">Data mulai tgl </td>
		    <td>:</td>
		    <td width="317" >
			<input name="tgl_s" id="tgl" size="11" maxlength="10" readonly="true" value="<?php if($_GET['tgl_s']<>"") echo "$tgl_s";else echo "$tglSkrg";?> " class="txtcenter" />
            <input type="button" name="ButtonTgl" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />
			&nbsp; s/d &nbsp;
			<input name="tgl_d" id="tgl" size="11" maxlength="10" readonly="true" value="<?php if($_GET['tgl_d']<>"") echo "$tgl_d";else echo "$tglSkrg";?> " class="txtcenter" />
            <input type="button" name="ButtonTgl" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />
			</td>
	        <td width="320" >
			<!--button class="txtcenter" onClick="location='?f=../transaksi/detil_retur_penjualan.php&nama_pasien='+nama_pasien.value+'&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value"><img src="../icon/go.png" height="16" width="16"></button-->			
	          <input type="button" value="&raquo; OK" name="checkbox" onClick="location='?f=../transaksi/detil_retur_penjualan.php&nama_pasien='+nama_pasien.value+'&no_pasien='+no_pasien.value+'&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value">
	        </td>
	    </tr>
		  <tr>
		    <td height="25">&nbsp;</td>
		    <td>&nbsp;</td>
		    <td colspan="2" >&nbsp;</td>
	    </tr>
        <tr>
          <td colspan="4"><table border="0" cellpadding="0" cellspacing="0" align="center">
            <tr class="headtable">
              <td width="89" class="tblheaderkiri" id="TGL" onClick="ifPop.CallFr(this);">Tanggal</td>
              <td width="130" class="tblheader" id="NO_PENJUALAN" onClick="ifPop.CallFr(this);">No. Penjualan </td>
              <td width="170" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama Obat </td>
              <td width="106" class="tblheader" id="HARGA_SATUAN" onClick="ifPop.CallFr(this);">Harga Satuan </td>
              <td width="90" class="tblheader" id="QTY_JUAL" onClick="ifPop.CallFr(this);">Qty Jual </td>
              <td colspan="2" class="tblheader" id="QTY_RETUR" onClick="ifPop.CallFr(this);">Qty Retur </td>
              <td width="47" class="tblheader" id="QTY" onClick="ifPop.CallFr(this);">Qty </td>
              <td width="132" class="tblheader" id="HARGA_SATUAN" onClick="ifPop.CallFr(this);">Subtotal </td>
              <!--td><input name="checkSedoyo" type="checkbox" value="" onClick="fCheckAll(checkSedoyo,pilihobat)"></td-->
            </tr>
           <?php
			if ($filter!=""){
			$filter=explode("|",$filter);
			$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  		}
	  		if ($sorting=="") $sorting=$defaultsort;
		   $sql="Select a_penjualan.*, a_obat.OBAT_ID,a_obat.OBAT_NAMA From a_penjualan Inner Join a_penerimaan ON a_penjualan.PENERIMAAN_ID = a_penerimaan.ID Inner Join a_obat ON a_penerimaan.OBAT_ID = a_obat.OBAT_ID WHERE a_penjualan.NAMA_PASIEN ='$nama_pasien' and UNIT_ID=$idunit and TGL between '$tgl_se' and '$tgl_de'".$filter." order by " .$sorting; 
		   //echo $sql;
		   $exe=mysqli_query($konek,$sql);
		   $i=0;
		   while ($show=mysqli_fetch_array($exe)){
		   $ngitung=$i++;
           ?>
            <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
			  <input type="hidden" name="id[]" id="id<?php echo $ngitung; ?>" value="<?php echo $show['ID'];?>" disabled="disabled">
              <td class="tdisikiri"><?php echo date("d/m/Y",strtotime($show['TGL'])); ?></td>
              <td class="tdisi"><?php echo $show['NO_PENJUALAN']; ?></td>
			  <input type="hidden" name="no_penjualan[]" id="no_penjualan<?php echo $ngitung; ?>" value="<?php echo $show['NO_PENJUALAN'];?>" disabled="disabled">
			  
              <td class="tdisi"><?php echo $show['OBAT_NAMA'];?>
              <input type="hidden" name="obat_id[]" id="obat_id<?php echo $ngitung; ?>" value="<?php echo $show['OBAT_ID'];?>" disabled="disabled"></td>
			  
              <td class="tdisi" align="right">Rp. <?php echo number_format($show['HARGA_SATUAN'],2,",","."); ?></td>
              <td class="tdisi"><?php echo $show['QTY_JUAL'];?></td>
              <td width="47" align="right" class="tdisi"><input name="qty_satuan[]" size="5" class="txtinput" id="qty_satuan<?=$ngitung?>" value="<?=$show['QTY_RETUR']?>" disabled="disabled">              </td>
              <td width="40" class="tdisi"><input name="pilihobat" type="checkbox" value="" onClick="if (this.checked==true){document.getElementById('id<?=$ngitung;?>').disabled='';document.getElementById('no_penjualan<?=$ngitung;?>').disabled='';document.getElementById('obat_id<?=$ngitung;?>').disabled='';document.getElementById('qty_satuan<?=$ngitung;?>').disabled='';}else{document.getElementById('id<?=$ngitung;?>').disabled='disabled'; document.getElementById('no_penjualan<?=$ngitung;?>').disabled='disabled';document.getElementById('obat_id<?=$ngitung;?>').disabled='disabled';document.getElementById('qty_satuan<?=$ngitung;?>').disabled='disabled';}">
			</td>
			  <td class="tdisi"><?php echo $show['QTY'];?></td>
			  <td class="tdisi" align="right">Rp. <?php echo number_format($show['HARGA_SATUAN']*$show['QTY'],2,",","."); ?></td>
            </tr>
			
            <? 
			$hartot=$hartot+($show['HARGA_SATUAN']*$show['QTY']);
			//echo "<br>".$hartot."<br>";
			}
			?>
			 <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
			 	<td class="tdisikiri" colspan="9" align="right"><b>Total = Rp. <?php echo number_format($hartot,2,",","."); ?></b></td>
			 </tr>
          </table></td>
        </tr>
      </table>
      <p align="center">
        <BUTTON type="button" onClick="if(ValidateForm('nama_pasien','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>
         <BUTTON type="reset" onClick="location='?f=../transaksi/retur_penjualan.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
    </form>
  </div>
</div>

</body>
</html>
<?php 
}
mysqli_close($konek);
?>
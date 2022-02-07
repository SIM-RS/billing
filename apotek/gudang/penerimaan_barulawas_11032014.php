<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$bln_po=$_REQUEST['bln_po'];
if ($bln_po=="") $bln_po=(substr($tgl,3,1)=="0")?substr($tgl,4,1):substr($tgl,3,2);
$th_po=$_REQUEST['th_po'];
if ($th_po=="") $th_po=substr($tgl,6,4);
$th_skrg=substr($tgl,6,4);
$no_gdg=$_REQUEST['no_gdg'];
$no_po=$_REQUEST['no_po'];
$kp_nama=$_REQUEST['kp_nama'];
$kp_id=$_REQUEST['kepemilikan_id'];
$no_faktur=$_REQUEST['no_faktur'];
$h_j_tempo=$_REQUEST['h_j_tempo'];
$tgl_gdg=$_REQUEST['tgl_gdg'];
if ($tgl_gdg=="") $tgl_gdg=$tgl;
$th=explode("-",$tgl_gdg);
$tgl2="$th[2]-$th[1]-$th[0]";

//$isview=$_REQUEST['isview'];
$h_tot=$_REQUEST['h_tot'];
$disk_tot=$_REQUEST['disk_tot'];
$h_diskon=$_REQUEST['h_diskon'];
$ppn=$_REQUEST['ppn'];
$total=$_REQUEST['total'];
$pbf_id=$_REQUEST['pbf_id'];
$updt_harga=$_REQUEST['updt_harga'];

//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="a_po.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
 	case "save":
		$msgupdt="";
		$aharga=$_REQUEST['aharga'];
		$idPemeriksa=$_REQUEST['idPemeriksa'];
		$fdata=$_REQUEST['fdata'];
		
		$sql="select * from a_penerimaan where UNIT_ID_TERIMA=$idunit and NOTERIMA='$no_gdg'";
		$rs=mysqli_query($konek,$sql);
		$tmpuser="";
		if ($rows=mysqli_fetch_array($rs)){
			$tmpuser=$rows["USER_ID_TERIMA"];
			if ($tmpuser!=$iduser){
				$sql="select NOTERIMA from a_penerimaan where UNIT_ID_TERIMA=$idunit and NOTERIMA like '$kodeunit/RCV/$th[2]-$th[1]/%' order by NOTERIMA desc limit 1";
				$rs1=mysqli_query($konek,$sql);
				if ($rows1=mysqli_fetch_array($rs1)){
					$no_gdg=$rows1["NOTERIMA"];
					$arno_gdg=explode("/",$no_gdg);
					$tmp=$arno_gdg[3]+1;
					$ctmp=$tmp;
					for ($i=0;$i<(4-strlen($tmp));$i++) $ctmp="0".$ctmp;
					$no_gdg="$kodeunit/RCV/$th[2]-$th[1]/$ctmp";
				}else{
					$no_gdg="$kodeunit/RCV/$th[2]-$th[1]/0001";
				}
			}
		}
		
		if ($tmpuser!=$iduser){
			if ($idPemeriksa!=""){
				$idPemeriksa=explode("|",$idPemeriksa);
				for ($i=0;$i<(count($idPemeriksa)-1);$i++){
					$qry="INSERT INTO ".$dbapotek.".a_penerimaan_pemeriksa(pemeriksa_id,no_gudang,tgl,user_act) VALUES($idPemeriksa[$i],'$no_gdg','$tgl2',$iduser)";
					$rs=mysqli_query($konek,$qry);
				}
			}
			
			$arfdata=explode("**",$fdata);
			$sql="SELECT DATE_ADD('$tgl2', INTERVAL $h_j_tempo DAY) as tgl";
			$rs=mysqli_query($konek,$sql);
			if ($rows=mysqli_fetch_array($rs)) $tgl_j_tempo=$rows['tgl'];
			for ($i=0;$i<count($arfdata);$i++){
				$arfvalue=explode("|",$arfdata[$i]);
				$tgl_exp=explode('-',$arfvalue[3]);
				$tgl_exp=$tgl_exp[2].'-'.$tgl_exp[1].'-'.$tgl_exp[0];
				//=======Cek apakah Qty pakai sudah sama dengan 0===
				$qry="select QTY_PAKAI from a_po where ID=$arfvalue[0]";
				//echo $qry;
				$exe=mysqli_query($konek,$qry);
				$rows=mysqli_fetch_array($exe);
				//Jika QTY SATUAN yang di order >  dari QTY_PAKAI, maka data tidak boleh di insert
				if ($rows['QTY_PAKAI']-$arfvalue[4] < 0){
					echo "<script>alert('Maaf, Quantity satuan yang anda minta melebihi jatah yang ada')</script>";
					echo "<script>location='?f=penerimaan_baru&no_po=".$_GET['no_po']."'</script>";
					exit();
				}	
				$sql="insert into ".$dbapotek.".a_penerimaan(OBAT_ID,FK_MINTA_ID,PBF_ID,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_TERIMA,NOKIRIM,NOTERIMA,NOBUKTI,TANGGAL_ACT,TANGGAL,TGL_J_TEMPO,HARI_J_TEMPO,BATCH,EXPIRED,QTY_KEMASAN,KEMASAN,HARGA_KEMASAN,QTY_PER_KEMASAN,QTY_SATUAN,SATUAN,QTY_STOK,HARGA_BELI_TOTAL,HARGA_BELI_SATUAN,DISKON,DISKON_TOTAL,NILAI_PAJAK,UPDT_H_NETTO,JENIS,TIPE_TRANS,STATUS) values($arfvalue[1],$arfvalue[0],$pbf_id,$idunit,$arfvalue[2],$iduser,'$no_faktur','$no_gdg','$no_faktur',NOW(),'$tgl2','$tgl_j_tempo',$h_j_tempo,'','$tgl_exp',$arfvalue[4],'$arfvalue[5]',$arfvalue[6],$arfvalue[7],$arfvalue[8],'$arfvalue[9]',$arfvalue[8],$h_tot,$arfvalue[10],$arfvalue[12],$disk_tot,$ppn,$updt_harga,$arfvalue[14],0,1)";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
				$status=0;
				$sql="update ".$dbapotek.".a_po set QTY_KEMASAN_TERIMA=QTY_KEMASAN_TERIMA+$arfvalue[4],QTY_PAKAI=QTY_PAKAI-$arfvalue[4],QTY_SATUAN_TERIMA=QTY_SATUAN_TERIMA+QTY_PER_KEMASAN*$arfvalue[4] where ID=$arfvalue[0]";
				$rs1=mysqli_query($konek,$sql);
				//Jika QTY_PAKAI sudah sama dengan 0, maka update status po jadi
				if ($rows['QTY_PAKAI']-$arfvalue[4]==0){
					$sql2="update ".$dbapotek.".a_po set status=1 where ID=$arfvalue[0]";
					$aksi=mysqli_query($konek,$sql2);
				}
				//========== Tambahan 16-12-2009========U/ pesan kalo harga di lock dan harga baru lebih tinggi dr harga netto
				//harga_lama=$arfvalue[15],$lock_harga=$arfvalue[16]============
				$hrg_baru=($arfvalue[11]-$arfvalue[13])/$arfvalue[8];
				if ($ppn!="0"){
					$hrg_baru=$hrg_baru+($hrg_baru*0.1);
				}
				$profit=0;
/*				if ($hrg_baru>$arfvalue[15]){
					if ($arfvalue[16]=="1"){
						$sql="SELECT OBAT_KODE,OBAT_NAMA FROM a_obat WHERE OBAT_ID=$arfvalue[1]";
						$rs1=mysqli_query($konek,$sql);
						$rows1=mysqli_fetch_array($rs1);
						$msgupdt .="Obat : ".$rows1["OBAT_KODE"]." - ".$rows1["OBAT_NAMA"]." - ".$kp_nama."<br>";
					}else{
						switch ($arfvalue[2]){
							case "1":
								if ($hrg_baru<=100000) $profit=15; else $profit=10;
								break;
							case "2":
								if ($hrg_baru<=50000) $profit=20; 
								elseif ($hrg_baru<=250000) $profit=15; 
								elseif ($hrg_baru<=500000) $profit=10; 
								elseif ($hrg_baru<=1000000) $profit=5; 
								else $profit=2;
								break;
							case "3":
								if ($hrg_baru<50000) $profit=20; else $profit=15;
								break;
							case "4":
								if ($hrg_baru<50000) $profit=20; else $profit=15;
								break;
							case "5":
								$profit=0;
								break;
						}
						
						$sql="SELECT * FROM a_harga WHERE OBAT_ID=$arfvalue[1] AND KEPEMILIKAN_ID=$arfvalue[2]";
						$rs1=mysqli_query($konek,$sql);
						if (mysqli_num_rows($rs1)>0){					
							$sql="UPDATE ".$dbapotek.".a_harga SET HARGA_BELI_SATUAN=$hrg_baru,PROFIT=$profit,HARGA_JUAL_SATUAN=$hrg_baru+($profit*$hrg_baru/100) WHERE OBAT_ID=$arfvalue[1] AND KEPEMILIKAN_ID=$arfvalue[2]";
						}else{
							$sql="INSERT INTO ".$dbapotek.".a_harga(OBAT_ID,KEPEMILIKAN_ID,HARGA_BELI_SATUAN,PROFIT,HARGA_JUAL_SATUAN,TGL_UPDATE,USER_ID,lock_harga) VALUES($arfvalue[1],$arfvalue[2],$hrg_baru,$profit,$hrg_baru+($profit*$hrg_baru/100),'$tgl_act',$iduser,0)";
						}
						$rs1=mysqli_query($konek,$sql);					
					}
				}*/
			}
		}
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
if ($act!="save"){
	$sql="select NOTERIMA from a_penerimaan where UNIT_ID_TERIMA=$idunit and NOTERIMA like '$kodeunit/RCV/$th[2]-$th[1]/%' order by NOTERIMA desc limit 1";
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		$no_gdg=$rows["NOTERIMA"];
		$arno_gdg=explode("/",$no_gdg);
		$tmp=$arno_gdg[3]+1;
		$ctmp=$tmp;
		for ($i=0;$i<(4-strlen($tmp));$i++) $ctmp="0".$ctmp;
		$no_gdg="$kodeunit/RCV/$th[2]-$th[1]/$ctmp";
	}else{
		$no_gdg="$kodeunit/RCV/$th[2]-$th[1]/0001";
	}
	
	$sql="select distinct NO_PO,date_format(TANGGAL,'%d/%m/%Y') as tgl1,HARGA_BELI_TOTAL,DISKON_TOTAL,(HARGA_BELI_TOTAL-DISKON_TOTAL) as H_DISKON,(HARGA_BELI_TOTAL-DISKON_TOTAL)+NILAI_PAJAK as TOTAL,NILAI_PAJAK,UPDT_H_NETTO,a_pbf.PBF_ID,PBF_NAMA,no_spph,k.NAMA,k.ID,TERMASUK_PPN from a_po inner join a_spph on a_po.FK_SPPH_ID=a_spph.spph_id inner join a_pbf on a_po.PBF_ID=a_pbf.PBF_ID inner join a_kepemilikan k on a_po.KEPEMILIKAN_ID=k.ID where a_po.no_po='$no_po'";
	//echo $sql."<br>";
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		$no_spph=$rows["no_spph"];
		$tgl_po=$rows["tgl1"];
		$ppn=$rows["NILAI_PAJAK"];
		$pbf=$rows["PBF_NAMA"];
		$pbf_id=$rows["PBF_ID"];
		$kp_nama=$rows['NAMA'];
		$kp_id=$rows['ID'];
		$updt_h_netto=$rows["UPDT_H_NETTO"];
		$inc_ppn=$rows["TERMASUK_PPN"];
		
		$sql="SELECT * FROM a_po_pemeriksa WHERE no_po='$no_po'";
		$rs1=mysqli_query($konek,$sql);
		$rw1=mysqli_fetch_array($rs1);
		$pemeriksa_tipe=$rw1["pemeriksa_tipe"];
		if ($pemeriksa_tipe=="") $pemeriksa_tipe=1;
		
		$sql="SELECT * FROM a_pemeriksa WHERE tipe='$pemeriksa_tipe'";
		$rs1=mysqli_query($konek,$sql);
		$pemeriksa="";
		while ($rw1=mysqli_fetch_array($rs1)){
			$pemeriksa .='<label style="cursor:pointer;"><input type="checkbox" name="pemeriksa" lang="'.$rw1["pemeriksa"].'" value="'.$rw1["id"].'" />'.$rw1["pemeriksa"]."</label><br>";
		}
	}
}else{
	//$sql="select distinct NO_PO,date_format(TANGGAL,'%d/%m/%Y') as tgl1,HARGA_BELI_TOTAL,DISKON_TOTAL,(HARGA_BELI_TOTAL-DISKON_TOTAL) as H_DISKON,(HARGA_BELI_TOTAL-DISKON_TOTAL)+NILAI_PAJAK as TOTAL,NILAI_PAJAK,UPDT_H_NETTO,a_pbf.PBF_ID,PBF_NAMA,no_spph,k.NAMA,k.ID,TERMASUK_PPN from a_po inner join a_spph on a_po.FK_SPPH_ID=a_spph.spph_id inner join a_pbf on a_po.PBF_ID=a_pbf.PBF_ID inner join a_kepemilikan k on a_po.KEPEMILIKAN_ID=k.ID where a_po.no_po='$no_po'";
	$sql="SELECT * FROM a_pbf WHERE PBF_ID=$pbf_id";
	//echo $sql."<br>";
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		/*$no_spph=$rows["no_spph"];
		$tgl_po=$rows["tgl1"];
		$ppn=$rows["NILAI_PAJAK"];
		$pbf=$rows["PBF_NAMA"];
		$pbf_id=$rows["PBF_ID"];
		$kp_nama=$rows['NAMA'];
		$kp_id=$rows['ID'];
		$updt_h_netto=$rows["UPDT_H_NETTO"];
		$inc_ppn=$rows["TERMASUK_PPN"];*/
		$pbf=$rows["PBF_NAMA"];
	}
}
?>
<html>
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script>
	function PrintArea(printArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1200,resizable,scrollbars')
	winpopup.document.write(document.getElementById(printArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>

<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<script>
function HitungQtySatuan(i){
var qtyKmsn,qtyPerKmsn;
	if (document.form1.chkItem.length){
		if (document.form1.qty_kemasan[i].value=="" || document.form1.qty_kemasan[i].value==" "){
			qtyKmsn=0;
			qtyPerKmsn=0;
		}else{
			qtyKmsn=document.form1.qty_kemasan[i].value*1;
			qtyPerKmsn=document.form1.qty_per_kemasan[i].value*1;
		}
		
		document.form1.qty_satuan[i].value=qtyKmsn*qtyPerKmsn;
	}else{
		if (document.form1.qty_kemasan.value=="" || document.form1.qty_kemasan.value==" "){
			qtyKmsn=0;
			qtyPerKmsn=0;
		}else{
			qtyKmsn=document.form1.qty_kemasan.value*1;
			qtyPerKmsn=document.form1.qty_per_kemasan.value*1;
		}
		
		document.form1.qty_satuan.value=qtyKmsn*qtyPerKmsn;
	}
}

function HitungSubTotal(i){
var qtyKmsn,hKmsn;
	if (document.form1.chkItem.length){
		if (document.form1.qty_kemasan[i].value=="" || document.form1.qty_kemasan[i].value==" "){
			qtyKmsn=0;
			hKmsn=0;
		}else{
			qtyKmsn=document.form1.qty_kemasan[i].value*1;
			hKmsn=document.form1.h_kemasan[i].value*1;
		}
		
		document.form1.sub_tot[i].value=qtyKmsn*hKmsn;
	}else{
		if (document.form1.qty_kemasan.value=="" || document.form1.qty_kemasan.value==" "){
			qtyKmsn=0;
			hKmsn=0;
		}else{
			qtyKmsn=document.form1.qty_kemasan.value*1;
			hKmsn=document.form1.h_kemasan.value*1;
		}
		
		document.form1.sub_tot.value=qtyKmsn*hKmsn;
	}
	HitunghTot();
}

function HitungHargaSatuan(i){
var tmp,qtyKmsn,hKmsn;
	if (document.form1.chkItem.length){
		if (document.form1.h_kemasan[i].value=="" || document.form1.h_kemasan[i].value==" "){
			hKmsn=0;
		}else{
			hKmsn=document.form1.h_kemasan[i].value*1;
		}

		if (document.form1.qty_per_kemasan[i].value=="" || document.form1.qty_per_kemasan[i].value==" "){
			qtyKmsn=0;
		}else{
			qtyKmsn=document.form1.qty_per_kemasan[i].value*1;
		}
		
		if (qtyKmsn==0){
			tmp=0;
		}else{
			tmp=hKmsn/qtyKmsn;
		}
		document.form1.h_satuan[i].value=tmp.toFixed(2)*1;
	}else{
		tmp=(document.form1.h_kemasan.value*1)/(document.form1.qty_per_kemasan.value*1);
		document.form1.h_satuan.value=tmp.toFixed(2)*1;
	}
}

function HitunghTot(){
var tmp=0;
	if (document.form1.chkItem.length){
		for (var i=0;i<document.form1.obat_id.length;i++){
			if (document.form1.chkItem[i].checked){
				tmp +=(document.form1.sub_tot[i].value*1);
			}
		}
		document.form1.h_tot.value=tmp.toFixed(2)*1;
	}else{
		if (document.form1.chkItem.checked){
			tmp=(document.form1.sub_tot.value*1);
		}
		document.form1.h_tot.value=tmp.toFixed(2)*1;
	}
	tmp=tmp-(document.form1.disk_tot.value*1);
	document.form1.h_diskon.value=tmp.toFixed(2)*1;
	if (document.form1.plus_ppn.value=="1"){
		tmp=0;
	}else{
		tmp=tmp*10/100;
	}
	document.form1.ppn.value=tmp.toFixed(2)*1;
	document.form1.total.value=(document.form1.h_diskon.value*1)+tmp;
}

function HitunghDiskonTot(){
var tmp=0;
	if (document.form1.chkItem.length){
		for (var i=0;i<document.form1.obat_id.length;i++){
			if (document.form1.chkItem[i].checked){
				tmp +=(document.form1.diskon_rp[i].value*1);
			}
		}
		document.form1.disk_tot.value=tmp.toFixed(2)*1;
	}else{
		if (document.form1.chkItem.checked){
			tmp=(document.form1.diskon_rp.value*1);
		}
		document.form1.disk_tot.value=tmp.toFixed(2)*1;
	}
	tmp=(document.form1.h_tot.value*1)-tmp;
	document.form1.h_diskon.value=tmp.toFixed(2)*1;
	if (document.form1.plus_ppn.value=="1"){
		tmp=0;
	}else{
		tmp=tmp*10/100;
	}
	document.form1.ppn.value=tmp.toFixed(2)*1;
	document.form1.total.value=(document.form1.h_diskon.value*1)+tmp;
}

function HitungDiskon(i,j){
var tmp;
	//alert('diskon');
	if (document.form1.chkItem.length){
		if (j==1){
			tmp=((document.form1.sub_tot[i].value*1)*(document.form1.diskon[i].value*1))/100;
			document.form1.diskon_rp[i].value=tmp.toFixed(2)*1;
		}else{
			tmp=((document.form1.diskon_rp[i].value*1)*100/(document.form1.sub_tot[i].value*1));
			document.form1.diskon[i].value=tmp.toFixed(2)*1;
		}
		if (document.form1.plus_ppn.value=="1"){
			document.form1.dpp_ppn[i].value=document.form1.sub_tot[i].value;
			tmp=(document.form1.sub_tot[i].value*1)*100/110;
			document.form1.dpp[i].value=tmp.toFixed(2)*1;
		}else{
			tmp=(document.form1.sub_tot[i].value*1)-(document.form1.diskon_rp[i].value*1);
			document.form1.dpp[i].value=tmp.toFixed(2)*1;
			tmp=(document.form1.sub_tot[i].value*1)-(document.form1.diskon_rp[i].value*1)+(((document.form1.sub_tot[i].value*1)-(document.form1.diskon_rp[i].value*1))/10);
			document.form1.dpp_ppn[i].value=tmp.toFixed(2)*1;
		}
	}else{
		if (j==1){
			tmp=((document.form1.sub_tot.value*1)*(document.form1.diskon.value*1))/100;
			document.form1.diskon_rp.value=tmp.toFixed(2)*1;
		}else{
			tmp=((document.form1.diskon_rp.value*1)*100/(document.form1.sub_tot.value*1));
			document.form1.diskon.value=tmp.toFixed(2)*1;
		}
		if (document.form1.plus_ppn.value=="1"){
			document.form1.dpp_ppn.value=document.form1.sub_tot.value;
			tmp=(document.form1.sub_tot.value*1)*100/110;
			document.form1.dpp.value=tmp.toFixed(2)*1;
		}else{
			tmp=(document.form1.sub_tot.value*1)-(document.form1.diskon_rp.value*1);
			document.form1.dpp.value=tmp.toFixed(2)*1;
			tmp=(document.form1.sub_tot.value*1)-(document.form1.diskon_rp.value*1)+(((document.form1.sub_tot.value*1)-(document.form1.diskon_rp.value*1))/10);
			document.form1.dpp_ppn.value=tmp.toFixed(2)*1;
		}
	}
	HitunghDiskonTot();
}

function fSubmit(){
var cdata='';
var x;
//	alert(document.form1.chkItem.length);
	//alert(document.getElementById('idPemeriksa').value);
	if (document.form1.chkItem.length){
		for (var i=0;i<document.form1.chkItem.length;i++){
			if (document.form1.chkItem[i].checked){
				if (document.form1.expired[i].value==''){
					alert('Isikan Expired Date Dari Item Obat !');
					document.form1.expired[i].focus();
					return false;
				}
				if ((document.form1.qty_per_kemasan[i].value=='')||(document.form1.qty_per_kemasan[i].value=='0')){
					alert('Isi Per Kemasan Dari Item Obat, Salah !');
					document.form1.qty_per_kemasan[i].focus();
					return false;
				}
				cdata +=document.form1.chkItem[i].value+'|'+document.form1.kepemilikan_id.value+'|'+document.form1.expired[i].value+'|'+document.form1.qty_kemasan[i].value+'|'+document.form1.kemasan[i].value+'|'+document.form1.h_kemasan[i].value+'|'+document.form1.qty_per_kemasan[i].value+'|'+document.form1.qty_satuan[i].value+'|'+document.form1.satuan[i].value+'|'+document.form1.h_satuan[i].value+'|'+document.form1.sub_tot[i].value+'|'+document.form1.diskon[i].value+'|'+document.form1.diskon_rp[i].value+'|'+document.form1.jenis[i].value+'|'+document.form1.aharga[i].value+'**';
			}
		}
		if (cdata!=""){
			cdata=cdata.substr(0,cdata.length-2);
		}else{
			alert("Pilih Item Obat Yg Mau Diterima Terlebih Dahulu !");
			return false;
		}
	}else if (document.form1.chkItem.checked){
		if (document.form1.expired.value==''){
			alert("Isikan Expired Date Dari Item Obat !");
			document.form1.expired.focus();
			return false;
		}
		if ((document.form1.qty_per_kemasan.value=='')||(document.form1.qty_per_kemasan.value=='0')){
			alert('Isi Per Kemasan Dari Item Obat, Salah !');
			document.form1.qty_per_kemasan.focus();
			return false;
		}
		
		cdata +=document.form1.chkItem.value+'|'+document.form1.kepemilikan_id.value+'|'+document.form1.expired.value+'|'+document.form1.qty_kemasan.value+'|'+document.form1.kemasan.value+'|'+document.form1.h_kemasan.value+'|'+document.form1.qty_per_kemasan.value+'|'+document.form1.qty_satuan.value+'|'+document.form1.satuan.value+'|'+document.form1.h_satuan.value+'|'+document.form1.sub_tot.value+'|'+document.form1.diskon.value+'|'+document.form1.diskon_rp.value+'|'+document.form1.jenis.value+'|'+document.form1.aharga.value;
	}else{
		alert("Pilih Item Obat Yg Mau Diterima Terlebih Dahulu !");
		return false;
	}
	//alert(cdata);
	document.form1.fdata.value=cdata;
	document.form1.submit();
}

function crosscekHarga(){
var cdata='';
//	alert(document.form1.chkItem.length);
	if (document.form1.chkItem.length){
		for (var i=0;i<document.form1.chkItem.length;i++){
			if (document.form1.chkItem[i].checked){
				cdata +=document.form1.chkItem[i].value+'|'+document.form1.h_kemasan[i].value+'|'+document.form1.diskon[i].value+'**';
			}
		}
	}else{
		if (document.form1.chkItem.checked){
			cdata +=document.form1.chkItem.value+'|'+document.form1.h_kemasan.value+'|'+document.form1.diskon.value+'**';
		}
	}
	//alert(cdata);
	if (cdata!=""){
		cdata=cdata.substr(0,cdata.length-2);
		ReqCrossCheckHarga("crossCekutils.php?fdata="+cdata);
	}else{
		alert("Pilih Item Barang Terlebih Dahulu !");
		return false;
	}
}

ReqCrossCheckHarga = function(vUrl) {
  //alert("tes"); 
  var pos = -1;
  for (var i=0; i<reqCekXML.length; i++) {
    if (reqCekXML[i].available == 1) { 
      pos = i; 
      break; 
	}
  }

  if (pos == -1) { 
    pos = reqCekXML.length; 
    reqCekXML[pos] = new newRequestCekXML(1); 
  }

  if (reqCekXML[pos].xmlhttp) {
    reqCekXML[pos].available = 0;
    reqCekXML[pos].xmlhttp.open("GET" , vUrl, true);
	reqCekXML[pos].xmlhttp.onreadystatechange = function() {
	  if (typeof(reqCekXML[pos]) != 'undefined' && 
		reqCekXML[pos].available == 0 && 
		reqCekXML[pos].xmlhttp.readyState == 4) {
		  if (reqCekXML[pos].xmlhttp.status == 200 || reqCekXML[pos].xmlhttp.status == 304) {
		  		//var xdc=reqCekXML[pos].xmlhttp.responseText.split(String.fromCharCode(3));
				alert(reqCekXML[pos].xmlhttp.responseText);
		  } else {
				reqCekXML[pos].xmlhttp.abort();
		  }
		  reqCekXML[pos].available = 1;
	  }
	}
	
	if (window.XMLHttpRequest) {
	  reqCekXML[pos].xmlhttp.send(null);
	} else if (window.ActiveXObject) {
	  reqCekXML[pos].xmlhttp.send();
	}
  }
  return false;
}

function ShowPop(){
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
}

function PilihPemeriksa(){
var tmpPemeriksa="",tmpNamaPemeriksa="";;
	if (document.frmPemeriksa.pemeriksa.length){
		for (var i=0;i<document.frmPemeriksa.pemeriksa.length;i++){
			if (document.frmPemeriksa.pemeriksa[i].checked){
				tmpPemeriksa=tmpPemeriksa+document.frmPemeriksa.pemeriksa[i].value+"|";
				//alert(document.frmPemeriksa.pemeriksa[i].lang);
				tmpNamaPemeriksa=tmpNamaPemeriksa+document.frmPemeriksa.pemeriksa[i].lang+"\n";
			}
		}
		
		if (tmpNamaPemeriksa!="") tmpNamaPemeriksa=tmpNamaPemeriksa.substr(0,tmpNamaPemeriksa.length-1);
	}else{
		if (document.frmPemeriksa.pemeriksa.checked){
			tmpPemeriksa=document.frmPemeriksa.pemeriksa.value+"|";
			tmpNamaPemeriksa=document.frmPemeriksa.pemeriksa.lang;
		}
	}
	
	if (tmpPemeriksa==""){
		alert("Pilih Petugas Pemeriksa Terlebih Dahulu !");
		return;
	}
	//alert(tmpNamaPemeriksa);
	document.getElementById('pemeriksa').value=tmpNamaPemeriksa;
	document.getElementById('idPemeriksa').value=tmpPemeriksa;
	$('popup_div1').popup.hide();
}
</script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<?php 
if ($act=="save"){
	$sql="SELECT p.* FROM a_penerimaan_pemeriksa pp INNER JOIN a_pemeriksa p ON pp.pemeriksa_id=p.id 
			WHERE pp.no_gudang='$no_gdg' AND pp.tgl='$tgl2' AND pp.user_act='$iduser'";
	$rsP=mysqli_query($konek,$sql);
	$nama_pemeriksa="";
	while ($rwP=mysqli_fetch_array($rsP)){
		$nama_pemeriksa .="&nbsp;".$rwP["pemeriksa"]."<br>";
	}
	if ($nama_pemeriksa!="") $nama_pemeriksa=substr($nama_pemeriksa,0,strlen($nama_pemeriksa)-1)
?>
<div align="center">
<!-- Print Out -->
	<div id="printArea" style="display:block">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	  <p align="center"><span class="jdltable">PENERIMAAN GUDANG</span></p>
	  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
       
		<tr> 
          <td width="115">No Penerimaan</td>
          <td width="260">: <?php echo $no_gdg; ?>            </td>
          <td width="93">Harga Total</td>
          <td width="224">: <?php echo number_format($h_tot,2,",","."); ?>            </td>
          <td width="113">PPN (10%)</td>
          <td width="214">: <?php echo number_format($ppn,2,",","."); ?>            </td>
        </tr>
        <tr> 
          <td width="115">Tgl Penerimaan</td>
          <td>: <?php echo $tgl_gdg; ?>                      </td>
          <td>Diskon Total</td>
          <td>: <?php echo number_format($disk_tot,2,",","."); ?>           </td>
          <td>T O T A L</td>
          <td>: <?php echo number_format($total,2,",","."); ?>            </td>
        </tr>
        <tr> 
          <td>No PO</td>
          <td>: <?php echo $no_po; ?></td>
          
        <td>Harga Diskon</td>
          <td>: <?php echo number_format($h_diskon,2,",","."); ?>            </td>
          <td>Jatuh Tempo</td>
          
        <td>: <?php echo $h_j_tempo; ?> hari </td>
        </tr>
        <tr> 
          <td>No Faktur</td>
          <td>: <?php echo $no_faktur; ?>            </td>
          <td>PBF</td>
          <td>: <?php echo $pbf; ?></td>
          
        <td>Kepemilikan</td>
          
        <td>: <?php echo $kp_nama; ?></td>
        </tr>
        <tr>
          <td>Pemeriksa</td>
          <td colspan="5">: <?php echo $nama_pemeriksa; ?></td>
        </tr>
      </table>
	  
    <table id="tblpenerimaan" width="99%" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable"> 
        <td width="30" height="25" class="tblheaderkiri">No</td>
        <td id="OBAT_KODE" width="60" class="tblheader">Kode Obat</td>
        <td id="OBAT_NAMA" class="tblheader">Nama Obat</td>
        <td id="qty_kemasan" width="30" class="tblheader">Expired Date</td>
        <td id="qty_kemasan" width="30" class="tblheader"> <p>Qty Ke masan </p></td>
        <td id="kemasan" width="60" class="tblheader">Kemasan</td>
        <td width="40" class="tblheader">Harga Kemasan </td>
        <td width="40" class="tblheader">Isi / Ke masan</td>
        <td width="40" class="tblheader">Qty Satuan </td>
        <td width="60" class="tblheader">Satuan</td>
        <td width="50" class="tblheader">Harga Satuan </td>
        <td width="60" class="tblheader">Sub Total </td>
        <td width="30" class="tblheader">Disk (%) </td>
        <td width="50" class="tblheader">Diskon (Rp) </td>
      	<td width="61" class="tblheader">DPP</td>
      	<td width="61" class="tblheader">DPP+PPN</td>
      </tr>
      <?php 
	  $sql="select a_p.*,date_format(a_p.EXPIRED,'%d/%m/%Y') as tgl2,a_p.HARGA_KEMASAN*QTY_KEMASAN as subtotal,o.OBAT_KODE,o.OBAT_NAMA,k.NAMA from a_penerimaan a_p inner join a_obat o on a_p.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_p.KEPEMILIKAN_ID=k.ID where a_p.NOTERIMA='$no_gdg' AND a_p.NOBUKTI='$no_faktur' order by a_p.ID";
	  //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
	  while ($rows=mysqli_fetch_array($rs)){
	  $i=0;
		$i++;
		$kemasan=$rows['kemasan'];
		$satuan=$rows['satuan'];
		$qty_kemasan=$rows['QTY_KEMASAN'];
		$spph_id=$rows['spph_id'];
		$obat_id=$rows['obat_id'];
		if ($ppn>0){
			$dpp=$rows['subtotal']-(($rows['subtotal']*$rows['DISKON'])/100);
			$dpp_ppn=$dpp+($dpp/10);
		}else{
			$dpp_ppn=$rows['subtotal'];
			$dpp=$dpp_ppn*100/110;
		}
	  ?>
      <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
        <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><input name="spph_id" type="hidden" value="<?php echo $spph_id; ?>"> 
          <input name="obat_id" type="hidden" value="<?php echo $obat_id; ?>"> 
          <?php echo $rows['OBAT_KODE']; ?></td>
        <td class="tdisi" align="left" style="font-size:12px;">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['tgl2']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $qty_kemasan; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['KEMASAN']; ?></td>
        <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($rows['HARGA_KEMASAN'],2,",","."); ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['QTY_PER_KEMASAN']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['QTY_SATUAN']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['SATUAN']; ?></td>
        <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($rows['HARGA_BELI_SATUAN'],2,",","."); ?></td>
        <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($rows['subtotal'],2,",","."); ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['DISKON']; ?></td>
        <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format((($rows['subtotal']*$rows['DISKON'])/100),2,",","."); ?></td>
        <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($dpp,2,",","."); ?></td>
        <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($dpp_ppn,2,",","."); ?></td>
      </tr>
      <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
    </table>
	</div>
	<!--vPrint Out Selesai -->
    <br>
  <!--p align="center">Penerimaan Gudang Dgn No Penerimaan : <?php echo $no_gdg; ?> 
    Sudah Disimpan</p-->
	<?php if ($msgupdt!="") echo "<span class='txtinput'>".$msgupdt."Harga Penerimaan Baru Lebih Besar dari Master Harga, Tapi Tdk Bisa Diupdate karena di-Lock<br></span>"; ?>
	<p align="center">
	<BUTTON type="button" onClick='PrintArea("printArea","#")'><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
    Penerimaan&nbsp;&nbsp;</BUTTON>
	&nbsp;
    <BUTTON type="button" onClick="location='?f=penerimaan.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Daftar 
    Penerimaan&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
  </p>
</div>
<?php }else{?>
<script>
var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden"> 
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
  <form name="form1" method="post" action="">
	<input name="act" id="act" type="hidden" value="save">
	<input name="fdata" id="fdata" type="hidden" value="">
	<input name="updt_harga" id="updt_harga" type="hidden" value="0">
	<input name="pbf_id" id="pbf_id" type="hidden" value="<?php echo $pbf_id; ?>">
	<input name="kp_nama" id="kp_nama" type="hidden" value="<?php echo $kp_nama; ?>">
	<input name="kepemilikan_id" id="kepemilikan_id" type="hidden" value="<?php echo $kp_id; ?>">
	<input name="plus_ppn" id="plus_ppn" type="hidden" value="<?php echo $inc_ppn; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <input type="hidden" name="idPemeriksa" id="idPemeriksa" value="">
	<div id="listma" style="display:block">
	  <p><span class="jdltable">PENERIMAAN GUDANG</span></p>
	  <table width="1150" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="107">No Penerimaan</td>
          <td width="320">: 
            <input name="no_gdg" type="text" id="no_gdg" size="25" maxlength="30" class="txtcenter" readonly="true" value="<?php echo $no_gdg; ?>">          </td>
          <td width="90">Harga Total</td>
          <td width="180">: 
            <input name="h_tot" type="text" class="txtright" id="h_tot" value="<?php echo $h_tot; ?>" size="15" readonly="true">          </td>
          <td width="85">PPN (10%)</td>
          <td width="115">: 
            <input name="ppn" type="text" class="txtright" id="ppn2" value="<?php echo $ppn; ?>" size="15" readonly="true"></td>
        </tr>
        <tr> 
          <td width="107">Tgl Penerimaan</td>
          <td>: 
            <input name="tgl_gdg" type="text" id="tgl_gdg" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_gdg; ?>"> 
            <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" <?php echo $DisableBD; ?> onClick="gfPop.fPopCalendar(this.form.tgl_gdg,depRange);" />          </td>
          <td>Diskon Total</td>
          <td>: 
            <input name="disk_tot" type="text" class="txtright" id="disk_tot" value="<?php echo $diskon_tot; ?>" size="15" readonly="true"></td>
          <td>T O T A L</td>
          <td>: 
            <input name="total" type="text" class="txtright" id="total" value="<?php echo $total; ?>" size="15" readonly="true"></td>
        </tr>
        <tr> 
          <td colspan="2"><table border="0" cellpadding="1" cellspacing="0" class="txtinput" width="427"><tr><td width="72">Tgl & No PO</td>
          <td width="140">: 
            <select name="bln_po" id="bln_po" class="txtinput" onChange="location='?f=penerimaan_baru.php&bln_po='+bln_po.value+'&th_po='+th_po.value"><option value="1" class="txtinput">Januari</option>
          <option value="2" class="txtinput"<?php if ($bln_po==2) echo " selected";?>>Pebruari</option>
          <option value="3" class="txtinput"<?php if ($bln_po==3) echo " selected";?>>Maret</option>
          <option value="4" class="txtinput"<?php if ($bln_po==4) echo " selected";?>>April</option>
          <option value="5" class="txtinput"<?php if ($bln_po==5) echo " selected";?>>Mei</option>
          <option value="6" class="txtinput"<?php if ($bln_po==6) echo " selected";?>>Juni</option>
          <option value="7" class="txtinput"<?php if ($bln_po==7) echo " selected";?>>Juli</option>
          <option value="8" class="txtinput"<?php if ($bln_po==8) echo " selected";?>>Agustus</option>
          <option value="9" class="txtinput"<?php if ($bln_po==9) echo " selected";?>>September</option>
          <option value="10" class="txtinput"<?php if ($bln_po==10) echo " selected";?>>Oktober</option>
          <option value="11" class="txtinput"<?php if ($bln_po==11) echo " selected";?>>Nopember</option>
          <option value="12" class="txtinput"<?php if ($bln_po==12) echo " selected";?>>Desember</option>
          </select>
          <select name="th_po" id="th_po" class="txtinput" onChange="location='?f=penerimaan_baru.php&bln_po='+bln_po.value+'&th_po='+th_po.value">
          <?php for ($i=$th_skrg-2;$i<=$th_skrg;$i++){?>
          <option value="<?php echo $i;?>" class="txtinput"<?php if ($th_po==$i) echo " selected";?>><?php echo $i;?></option>
          <?php }?>
          </select></td></tr></table>
            <select name="no_po" id="no_po" class="txtinput" onChange="location='?f=penerimaan_baru.php&no_po='+no_po.value+'&bln_po='+bln_po.value+'&th_po='+th_po.value">
              <option value="" class="txtinput">Pilih PO</option>
              <?
					  $qry="SELECT DISTINCT no_po,PBF_NAMA,k.NAMA FROM a_po INNER JOIN a_pbf ON a_po.PBF_ID=a_pbf.PBF_ID INNER JOIN a_spph sp ON a_po.FK_SPPH_ID=sp.spph_id INNER JOIN a_kepemilikan k ON a_po.KEPEMILIKAN_ID=k.ID WHERE YEAR(TANGGAL)=$th_po AND MONTH(TANGGAL)=$bln_po AND a_po.STATUS=0 ORDER BY no_po";
					  $exe=mysqli_query($konek,$qry);
					  while($show=mysqli_fetch_array($exe)){ 
					?>
              <option value="<?php echo $show['no_po']; ?>" class="txtinput"<?php if ($no_po==$show['no_po']) echo " selected";?>><?php echo $show['no_po']." - ".$show['PBF_NAMA']." - ".$show['NAMA']; ?></option>
              <? }?>
            </select></td>
          <td>Harga Diskon</td>
          <td>: 
            <input name="h_diskon" type="text" class="txtright" id="h_diskon" value="<?php echo $h_diskon; ?>" size="15" readonly="true"></td>
          <td>Jatuh Tempo</td>
          <td>: 
            <input name="h_j_tempo" type="text" class="txtcenter" id="h_j_tempo" value="21" size="3" maxlength="2">
            hari </td>
        </tr>
        <tr> 
          <td>No Faktur</td>
          <td>: 
            <input name="no_faktur" type="text" id="no_faktur" size="25" maxlength="30" class="txtinput" autocomplete="off"></td>
          <td colspan="2">PBF : <?php echo $pbf; ?></td>
          <td>Kepemilikan</td>
          <td>: <?php echo $kp_nama; ?></td>
        </tr>
        <tr>
          <td>Pemeriksa</td>
          <td>:
          	<textarea id="pemeriksa" name="pemeriksa" cols="35" readonly autocomplete="off"></textarea>&nbsp;
<!--            <input name="pemeriksa" type="text" id="pemeriksa" size="45" readonly class="txtinput" autocomplete="off">&nbsp;-->
            <input type="button" name="plhPemeriksa" value=" ... " class="txtcenter" style="cursor:pointer" title="Klik Untuk Memilih Petugas Pemeriksa" onClick="ShowPop();" />
          </td>
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <!--tr>
			<td>Unit</td>
			<td>: <?php //echo $nunit; ?></td>
		</tr-->
      </table>
	  <table id="tblpenerimaan" width="1150" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="20" class="tblheader"> 
            <input type="checkbox" name="chkAll" id="chkAll" value="" onClick="fCheckAll(chkAll,chkItem);HitunghDiskonTot();HitunghTot();" style="cursor:pointer" title="Pilih Semua">          </td>
          <td id="OBAT_NAMA" class="tblheader">Nama Obat</td>
          <td id="qty_kemasan" width="70" class="tblheader">Expired Date</td>
          <td id="qty_kemasan" width="30" class="tblheader"> <p>Qty Ke masan </p></td>
          <td id="kemasan" width="50" class="tblheader">Kemasan</td>
          <td width="40" class="tblheader">Harga Kemasan </td>
          <td width="40" class="tblheader">Isi / Ke masan</td>
          <td width="40" class="tblheader">Qty Satuan </td>
          <td width="50" class="tblheader">Satuan</td>
          <td width="50" class="tblheader">Harga Satuan </td>
          <td width="60" class="tblheader">Sub Total </td>
          <td width="30" class="tblheader">Disk (%) </td>
          <td width="50" class="tblheader">Diskon (Rp) </td>
          <td width="50" class="tblheader">DPP</td>
          <td width="50" class="tblheader">DPP+PPN</td>
        </tr>
        <?php 
	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select a_po.*,a_po.HARGA_KEMASAN*QTY_KEMASAN as subtotal,o.OBAT_KODE,o.OBAT_NAMA,k.NAMA from a_po inner join a_obat o on a_po.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_po.KEPEMILIKAN_ID=k.ID where a_po.NO_PO='$no_po' and a_po.status=0".$filter." order by ".$sorting;
	  //echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
		$i++;
		$kemasan=$rows['KEMASAN'];
		$satuan=$rows['SATUAN'];
		$qty_kemasan=$rows['QTY_PAKAI'];
		$po_id=$rows['ID'];
		$obat_id=$rows['OBAT_ID'];
		$sql="SELECT * FROM a_harga WHERE OBAT_ID=$obat_id AND KEPEMILIKAN_ID=$kp_id ORDER BY HARGA_BELI_SATUAN DESC";
		//echo $sql."<br>";
		$rs1=mysqli_query($konek,$sql);
		$harga_lama=0;
		$lock_harga=0;
		if ($rows1=mysqli_fetch_array($rs1)){
			$harga_lama=$rows1["HARGA_BELI_SATUAN"];
			$lock_harga=$rows1["lock_harga"];
		}
	  ?>
        <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"> <input type="checkbox" name="chkItem" value="<?php echo $po_id.'|'.$obat_id; ?>" onClick="HitunghDiskonTot();HitunghTot();"></td>
          <td class="tdisi" align="left"><!--input name="po_id" type="hidden" value="<?php //echo $po_id; ?>"--> 
            <input name="obat_id" type="hidden" value="<?php echo $obat_id; ?>"><input name="jenis" type="hidden" value="<?php echo $rows['JENIS']; ?>">
			<input name="aharga" type="hidden" value="<?php echo $harga_lama.'|'.$lock_harga; ?>">
            <?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><input name="expired" type="text" class="txtcenter" id="expired" value="" size="11" maxlength="10" autocomplete="off"></td>
          <td class="tdisi" align="center"><input name="qty_kemasan" type="text" id="qty_kemasan" class="txtcenter" size="3" value="<?php echo $qty_kemasan; ?>" onKeyUp="HitungQtySatuan(<?php echo ($i-1); ?>);HitungSubTotal(<?php echo ($i-1); ?>);HitungDiskon(<?php echo ($i-1); ?>,1);" autocomplete="off"></td>
          <td class="tdisi" align="center"> <input name="kemasan" class="txtinput" id="kemasan" value="<?php echo $rows['KEMASAN']; ?>" size="12">          </td>
          <td class="tdisi" align="right"><input name="h_kemasan" type="text" class="txtright" id="h_kemasan" onKeyUp="HitungSubTotal(<?php echo ($i-1); ?>);HitungHargaSatuan(<?php echo ($i-1); ?>);HitungDiskon(<?php echo ($i-1); ?>,1);" value="<?php echo $rows['HARGA_KEMASAN']; ?>" size="8" autocomplete="off"></td>
          <td class="tdisi" align="center"><input name="qty_per_kemasan" type="text" class="txtcenter" id="qty_per_kemasan" onKeyUp="HitungQtySatuan(<?php echo ($i-1); ?>);HitungHargaSatuan(<?php echo ($i-1); ?>);" value="" size="3" autocomplete="off"></td>
          <td class="tdisi" align="center"><input name="qty_satuan" type="text" class="txtcenter" id="qty_satuan" onKeyUp="" value="<?php echo $rows['QTY_SATUAN']; ?>" size="5" autocomplete="off" readonly="true"></td>
          <td class="tdisi" align="center"> <input name="satuan" id="satuan" value="<?php echo $rows['SATUAN'];?>" type="text" size="7">          </td>
          <td class="tdisi" align="right"><input name="h_satuan" type="text" class="txtright" id="h_satuan" onKeyUp="" value="0" size="7" autocomplete="off" readonly="true"></td>
          <td class="tdisi" align="right"><input name="sub_tot" type="text" class="txtright" id="sub_tot" onKeyUp="" value="<?php echo $rows['subtotal']; ?>" size="8" readonly="true"></td>
          <td class="tdisi" align="center"><input name="diskon" type="text" class="txtcenter" id="diskon" onKeyUp="HitungDiskon(<?php echo ($i-1); ?>,1);" value="<?php echo $rows['DISKON']; ?>" size="3" autocomplete="off"></td>
          <td class="tdisi" align="right"><input name="diskon_rp" type="text" class="txtright" id="diskon_rp" onKeyUp="HitungDiskon(<?php echo ($i-1); ?>,2);" value="<?php echo (($rows['subtotal']*$rows['DISKON'])/100); ?>" size="7" autocomplete="off"></td>
          <td class="tdisi" align="right"><input name="dpp" type="text" class="txtright" id="dpp" value="" size="7" readonly></td>
          <td class="tdisi" align="right"><input name="dpp_ppn" type="text" class="txtright" id="dpp_ppn" value="" size="8" readonly></td>
        </tr>
        <script>
		HitungQtySatuan(<?php echo ($i-1); ?>);HitungSubTotal(<?php echo ($i-1); ?>);HitungDiskon(<?php echo ($i-1); ?>,1);
		</script>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
      </table>
	</div>
		<p align="center">
	  <BUTTON type="button" onClick="if (ValidateForm('no_faktur','ind')){fSubmit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Simpan&nbsp;&nbsp;</BUTTON>
			&nbsp;<BUTTON type="reset" onClick="location='?f=penerimaan.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>&nbsp;&nbsp;<BUTTON type="button" onClick="crosscekHarga()">&nbsp;&nbsp;Cross Cek Harga Terakhir&nbsp;&nbsp;</BUTTON>
		  </p>
</form>
</div>
<?php 
}
?>
<div id="popup_div1" class="popup" style="width:380px;display:none;">
    <div style="float:right; cursor:pointer" class="popup_closebox">
        <img src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
		<br>
		<fieldset>
			<legend>Petugas Pemeriksa</legend>
            	<form name="frmPemeriksa">
				<table width="350" align="center">
					<tr>
                    	<td>
                        	<?php echo $pemeriksa; ?>
                        </td>
					</tr>
					<tr>
						<td align="center"><input type="button" value="   Pilih   " onClick="PilihPemeriksa()" /></td>
					</tr>
				</table>
                </form>
		</fieldset>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
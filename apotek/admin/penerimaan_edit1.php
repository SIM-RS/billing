<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$bulan=$_REQUEST['bulan'];
$ta=$_REQUEST['ta'];
$no_gdg=$_REQUEST['no_gdg'];
$no_po=$_REQUEST['no_po'];
$kp_nama=$_REQUEST['kp_nama'];
$kp_id=$_REQUEST['kepemilikan_id'];
$tipe=$_REQUEST['tipe'];
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
$defaultsort="a_p.ID";
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
		$fdata=$_REQUEST['fdata'];
		$arfdata=explode("**",$fdata);
		$sql="SELECT DATE_ADD('$tgl2', INTERVAL $h_j_tempo DAY) as tgl";
		$rs=mysqli_query($konek,$sql);
		if ($rows=mysqli_fetch_array($rs)) $tgl_j_tempo=$rows['tgl'];
		
		$cekEdit="";
		for ($i=0;$i<count($arfdata);$i++){
			$arfvalue=explode("|",$arfdata[$i]);
			$sql="SELECT o.OBAT_NAMA FROM a_penerimaan ap INNER JOIN a_obat o ON ap.OBAT_ID=o.OBAT_ID WHERE ID_LAMA=$arfvalue[0]";
			//echo $sql."<br>";
			$rsCek=mysqli_query($konek,$sql);
			if (mysqli_num_rows($rsCek)>0){
				$rwCek=mysqli_fetch_array($rsCek);
				$cekEdit.=$rwCek["OBAT_NAMA"].", ";
			}
		}
		
		if ($cekEdit!=""){
			$cekEdit="Obat : ".substr($cekEdit,0,strlen($cekEdit)-2)." Sudah Dipakai Transaksi. Jadi Tdk Boleh diEdit.";
			$cekEdit=str_replace('"','\"',$cekEdit);
			$cekEdit=str_replace("\'","\'",$cekEdit);
			echo "<script>alert('$cekEdit');</script>";
		}else{
			//===========update htot, diskon_tot,nilai_pajak=================
			$sql="update a_penerimaan set TGL_J_TEMPO='$tgl_j_tempo',HARI_J_TEMPO=$h_j_tempo,HARGA_BELI_TOTAL=$h_tot,DISKON_TOTAL=$disk_tot,NILAI_PAJAK=$ppn where NOTERIMA='$no_gdg' AND NOBUKTI='$no_faktur'";
			//echo $sql."<br>";
			$rs1=mysqli_query($konek,$sql);
			
			for ($i=0;$i<count($arfdata);$i++){
				$arfvalue=explode("|",$arfdata[$i]);
				$tgl_exp=explode('-',$arfvalue[3]);
				$tgl_exp=$tgl_exp[2].'-'.$tgl_exp[1].'-'.$tgl_exp[0];
				//=======Hitung Ulang PO yg sdh dikirim===
				$sql="SELECT ap.*,po.QTY_KEMASAN QTY_KEMASAN_PO,po.QTY_KEMASAN_TERIMA QTY_KEMASAN_TERIMA_PO,po.QTY_PAKAI QTY_PAKAI_PO FROM a_penerimaan ap LEFT JOIN a_po po ON ap.FK_MINTA_ID=po.ID WHERE ap.ID=$arfvalue[0]";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
				$rw1=mysqli_fetch_array($rs1);
				$idAP=$rw1["ID"];
				$idminta=$rw1["FK_MINTA_ID"];
				$idOBAT=$rw1["OBAT_ID"];
				$idKP=$rw1["KEPEMILIKAN_ID"];
				$qtyKemasan=$rw1["QTY_KEMASAN"];
				$qtyKemasanPO=$rw1["QTY_KEMASAN_PO"];
				$qtyKemasanTerimaPO=$rw1["QTY_KEMASAN_TERIMA_PO"];
				$qtyPakaiPO=$rw1["QTY_PAKAI_PO"];
				$qtySatuan=$rw1["QTY_SATUAN"];
				$hargaSatuan=$rw1["HARGA_BELI_SATUAN"];
				$diskon=$rw1["DISKON"];
				$ppnLama=$rw1["NILAI_PAJAK"];
				
				$NewqtyKemasan=$arfvalue[4];
				$NewqtyPerKemasan=$arfvalue[7];
				$NewqtySatuan=$arfvalue[8];
				$NewhargaSatuan=$arfvalue[10];
				$Newdiskon=$arfvalue[12];
				$Newppn=$ppn;
				
				$qtyKemasanSelisih=$qtyKemasan-$NewqtyKemasan;
				$qtySatuanSelisih=$qtySatuan-$NewqtySatuan;
				$hargaSatuanSelisih=$hargaSatuan-$NewhargaSatuan;
				$diskonSelisih=$diskon-$Newdiskon;
				
				if ($ppn>0){
					$NilaiTransSelisih=($qtySatuan * $hargaSatuan * (1-($diskon/100)) * 1.1) - ($NewqtySatuan * $NewhargaSatuan * (1-($Newdiskon/100)) * 1.1);
				}else{
					$NilaiTransSelisih=($qtySatuan * $hargaSatuan * (1-($diskon/100))) - ($NewqtySatuan * $NewhargaSatuan * (1-($Newdiskon/100)));
				}
				//=======Cek apakah Qty pakai sudah sama dengan 0===
				//$sql="update a_penerimaan set NOTERIMA='$no_gdg',NOBUKTI='$no_faktur',TGL_J_TEMPO='$tgl_j_tempo',HARI_J_TEMPO=$h_j_tempo,EXPIRED='$tgl_exp',QTY_KEMASAN=$NewqtyKemasan,KEMASAN='$arfvalue[5]',HARGA_KEMASAN=$arfvalue[6],QTY_PER_KEMASAN=$NewqtyPerKemasan,QTY_SATUAN=$NewqtySatuan,QTY_STOK=$NewqtySatuan,SATUAN='$arfvalue[9]',HARGA_BELI_TOTAL=$h_tot,HARGA_BELI_SATUAN=$NewhargaSatuan,DISKON=$Newdiskon,DISKON_TOTAL=$disk_tot,NILAI_PAJAK=$ppn,UPDT_H_NETTO=$updt_harga,JENIS=$arfvalue[14] where ID=$arfvalue[0]";
				$sql="update a_penerimaan set TGL_J_TEMPO='$tgl_j_tempo',HARI_J_TEMPO=$h_j_tempo,EXPIRED='$tgl_exp',QTY_KEMASAN=$NewqtyKemasan,KEMASAN='$arfvalue[5]',HARGA_KEMASAN=$arfvalue[6],QTY_PER_KEMASAN=$NewqtyPerKemasan,QTY_SATUAN=$NewqtySatuan,QTY_STOK=$NewqtySatuan,SATUAN='$arfvalue[9]',HARGA_BELI_TOTAL=$h_tot,HARGA_BELI_SATUAN=$NewhargaSatuan,DISKON=$Newdiskon,DISKON_TOTAL=$disk_tot,NILAI_PAJAK=$ppn,UPDT_H_NETTO=$updt_harga,JENIS=$arfvalue[14] where ID=$arfvalue[0]";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
				//===== Update Kartu Stok Yg Salah =====
				$sql="SELECT * FROM a_kartustok WHERE fkid=$idAP AND tipetrans=0";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
				$rw1=mysqli_fetch_array($rs1);
				$idKS=$rw1["ID"];
				$tgl_actKS=$rw1["TGL_ACT"];
				
				$sql="UPDATE a_kartustok SET DEBET=DEBET-$qtySatuanSelisih,STOK_AFTER=STOK_AFTER-$qtySatuanSelisih,NILAI_TOTAL=NILAI_TOTAL-$NilaiTransSelisih WHERE OBAT_ID=$idOBAT AND KEPEMILIKAN_ID=$idKP AND UNIT_ID=$idunit AND ID=$idKS";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
				$sql="UPDATE a_kartustok SET STOK_BEFOR=STOK_BEFOR-$qtySatuanSelisih,STOK_AFTER=STOK_AFTER-$qtySatuanSelisih,NILAI_TOTAL=NILAI_TOTAL-$NilaiTransSelisih WHERE OBAT_ID=$idOBAT AND KEPEMILIKAN_ID=$idKP AND UNIT_ID=$idunit AND ID>$idKS AND TGL_ACT>='$tgl_actKS'";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);

				if ($idminta>0){
					//==========Hitung Ulang PO yg sdh dikirim========
					//Jika QTY_PAKAI sudah sama dengan 0, maka update status po jadi 1
					$statusPO="";
					if ($qtyPakaiPO+$qtyKemasanSelisih==0){
						$statusPO=",STATUS=1";
					}
					
					$sql="UPDATE a_po SET QTY_KEMASAN_TERIMA=QTY_KEMASAN_TERIMA-$qtyKemasanSelisih,QTY_PAKAI=QTY_PAKAI+$qtyKemasanSelisih,QTY_SATUAN_TERIMA=QTY_SATUAN_TERIMA-$qtySatuanSelisih".$statusPO." WHERE ID=$idminta";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					//========== Tambahan 16-12-2009========U/ pesan kalo harga di lock dan harga baru lebih tinggi dr harga netto
					//harga_lama=$arfvalue[15],$lock_harga=$arfvalue[16]============
					$hrg_baru=($arfvalue[11]-$arfvalue[13])/$arfvalue[8];
					if ($ppn!="0"){
						$hrg_baru=$hrg_baru+($hrg_baru*0.1);
					}
					if ($hrg_baru>$arfvalue[15]){
						if ($arfvalue[16]=="1"){
							$sql="SELECT OBAT_KODE,OBAT_NAMA FROM a_obat WHERE OBAT_ID=$arfvalue[1]";
							$rs1=mysqli_query($konek,$sql);
							$rows1=mysqli_fetch_array($rs1);
							$msgupdt .="Obat : ".$rows1["OBAT_KODE"]." - ".$rows1["OBAT_NAMA"]." - ".$kp_nama."<br>";
						}else{
							if ($hrg_baru<=100000) $profit=20;
							else if ($hrg_baru<=500000) $profit=15;
							else $profit=5;
							
							$sql="SELECT * FROM a_harga WHERE OBAT_ID=$arfvalue[1] AND KEPEMILIKAN_ID=$arfvalue[2]";
							$rs1=mysqli_query($konek,$sql);
							if (mysqli_num_rows($rs1)>0){					
								$sql="UPDATE a_harga SET HARGA_BELI_SATUAN=$hrg_baru,PROFIT=$profit,HARGA_JUAL_SATUAN=$hrg_baru+($profit*$hrg_baru/100) WHERE OBAT_ID=$arfvalue[1] AND KEPEMILIKAN_ID=$arfvalue[2]";
							}else{
								$sql="INSERT INTO a_harga(OBAT_ID,KEPEMILIKAN_ID,HARGA_BELI_SATUAN,PROFIT,HARGA_JUAL_SATUAN,TGL_UPDATE,USER_ID,lock_harga) VALUES($arfvalue[1],$arfvalue[2],$hrg_baru,$profit,$hrg_baru+($profit*$hrg_baru/100),'$tgl_act',$iduser,0)";
							}
							//echo $sql."<br>";
							$rs1=mysqli_query($konek,$sql);					
						}
					}
				}
			}
		}
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
$sql="select distinct NOTERIMA,ap.NOBUKTI,ap.USER_ID_TERIMA,ap.TANGGAL,ap.KEPEMILIKAN_ID,date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1,ap.HARGA_BELI_TOTAL,ap.DISKON_TOTAL,(ap.HARGA_BELI_TOTAL-ap.DISKON_TOTAL) as H_DISKON,(ap.HARGA_BELI_TOTAL-ap.DISKON_TOTAL)+ap.NILAI_PAJAK as TOTAL,ap.NILAI_PAJAK,ap.UPDT_H_NETTO,ap.HARI_J_TEMPO,ap.JENIS,IF(ap.PBF_ID=0,ap.KET,a_pbf.PBF_NAMA) as PBF_NAMA,a_pbf.PBF_ID,no_po,k.NAMA,TERMASUK_PPN from a_penerimaan ap left join a_po on ap.FK_MINTA_ID=a_po.ID left join a_pbf on ap.PBF_ID=a_pbf.PBF_ID inner join a_kepemilikan k on ap.KEPEMILIKAN_ID=k.ID where ap.NOTERIMA='$no_gdg' and ap.NOBUKTI='$no_faktur'";
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	$no_po=$rows["no_po"];
	$no_faktur=$rows["NOBUKTI"];
	$user_entry=$rows["USER_ID_TERIMA"];
	$tgl_asli=$rows["TANGGAL"];
	$tgl_gdg=$rows["tgl1"];
	$h_tot=$rows["HARGA_BELI_TOTAL"];
	$diskon_tot=$rows["DISKON_TOTAL"];
	$h_diskon=$rows["H_DISKON"];
	$total=$rows["TOTAL"];
	$ppn=$rows["NILAI_PAJAK"];
	$pbf=$rows["PBF_NAMA"];
	$pbf_id=$rows["PBF_ID"];
	$kp_id=$rows["KEPEMILIKAN_ID"];
	$kp_nama=$rows["NAMA"];
	$updt_h_netto=$rows["UPDT_H_NETTO"];
	$j_tempo=$rows["HARI_J_TEMPO"];
	$jenis=$rows["JENIS"];
	$inc_ppn=$rows["TERMASUK_PPN"];
	
	$sql="SELECT p.* FROM a_penerimaan_pemeriksa pp INNER JOIN a_pemeriksa p ON pp.pemeriksa_id=p.id 
			WHERE pp.no_gudang='$no_gdg' AND pp.tgl='$tgl_asli' AND pp.user_act='$user_entry'";
	$rsP=mysqli_query($konek,$sql);
	$rwP=mysqli_fetch_array($rsP);
	$id_pemeriksa=$rwP["id"];
	$nama_pemeriksa=$rwP["pemeriksa"];
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
function SetEnDisAttribut(i){
	if (document.form1.obat_id.length){
		if (document.form1.chkItem[i].checked){
			document.form1.expired[i].readOnly=false;
			document.form1.qty_kemasan[i].readOnly=false;
			document.form1.qty_per_kemasan[i].readOnly=false;
			document.form1.h_kemasan[i].readOnly=false;
			document.form1.diskon[i].readOnly=false;
			document.form1.diskon_rp[i].readOnly=false;
		}else{
			document.form1.expired[i].readOnly=true;
			document.form1.qty_kemasan[i].readOnly=true;
			document.form1.qty_per_kemasan[i].readOnly=true;
			document.form1.h_kemasan[i].readOnly=true;
			document.form1.diskon[i].readOnly=true;
			document.form1.diskon_rp[i].readOnly=true;
			
			document.form1.expired[i].value=document.form1.expired[i].lang;
			document.form1.qty_kemasan[i].value=document.form1.qty_kemasan[i].lang;
			document.form1.qty_per_kemasan[i].value=document.form1.qty_per_kemasan[i].lang;
			document.form1.h_kemasan[i].value=document.form1.h_kemasan[i].lang;
			document.form1.diskon[i].value=document.form1.diskon[i].lang;
			document.form1.diskon_rp[i].value=document.form1.diskon_rp[i].lang;
			
			HitungQtySatuan(i);
			HitungHargaSatuan(i);
			HitungSubTotal(i);
			HitungDiskon(i,1);
			
		}
	}else{
		if (document.form1.chkItem.checked){
			document.form1.expired.readOnly=false;
			document.form1.qty_kemasan.readOnly=false;
			document.form1.qty_per_kemasan.readOnly=false;
			document.form1.h_kemasan.readOnly=false;
			document.form1.diskon.readOnly=false;
			document.form1.diskon_rp.readOnly=false;
		}else{
			document.form1.expired.readOnly=true;
			document.form1.qty_kemasan.readOnly=true;
			document.form1.qty_per_kemasan.readOnly=true;
			document.form1.h_kemasan.readOnly=true;
			document.form1.diskon.readOnly=true;
			document.form1.diskon_rp.readOnly=true;
			
			document.form1.expired.value=document.form1.expired.lang;
			document.form1.qty_kemasan.value=document.form1.qty_kemasan.lang;
			document.form1.qty_per_kemasan.value=document.form1.qty_per_kemasan.lang;
			document.form1.h_kemasan.value=document.form1.h_kemasan.lang;
			document.form1.diskon.value=document.form1.diskon.lang;
			document.form1.diskon_rp.value=document.form1.diskon_rp.lang;
			
			HitungQtySatuan(i);
			HitungHargaSatuan(i);
			HitungSubTotal(i);
			HitungDiskon(i,1);
		}
	}
}

function HitungQtySatuan(i){
	if (document.form1.obat_id.length){
		document.form1.qty_satuan[i].value=(document.form1.qty_kemasan[i].value*1)*(document.form1.qty_per_kemasan[i].value*1);
	}else{
		document.form1.qty_satuan.value=(document.form1.qty_kemasan.value*1)*(document.form1.qty_per_kemasan.value*1);
	}
}

function HitungSubTotal(i){
	if (document.form1.obat_id.length){
		document.form1.sub_tot[i].value=(document.form1.qty_kemasan[i].value*1)*(document.form1.h_kemasan[i].value*1);
	}else{
		document.form1.sub_tot.value=(document.form1.qty_kemasan.value*1)*(document.form1.h_kemasan.value*1);
	}
	HitunghTot();
}

function HitungHargaSatuan(i){
var tmp;
	if (document.form1.obat_id.length){
		tmp=(document.form1.h_kemasan[i].value*1)/(document.form1.qty_per_kemasan[i].value*1);
		document.form1.h_satuan[i].value=tmp.toFixed(2)*1;
	}else{
		tmp=(document.form1.h_kemasan.value*1)/(document.form1.qty_per_kemasan.value*1);
		document.form1.h_satuan.value=tmp.toFixed(2)*1;
	}
}

function HitunghTot(){
var tmp=0;
	if (document.form1.obat_id.length){
		for (var i=0;i<document.form1.obat_id.length;i++){
			//if (document.form1.chkItem[i].checked){
				tmp +=(document.form1.sub_tot[i].value*1);
			//}
		}
		document.form1.h_tot.value=tmp.toFixed(2)*1;
	}else{
		//if (document.form1.chkItem.checked){
			tmp=(document.form1.sub_tot.value*1);
		//}
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
	if (document.form1.obat_id.length){
		for (var i=0;i<document.form1.obat_id.length;i++){
			//if (document.form1.chkItem[i].checked){
				tmp +=(document.form1.diskon_rp[i].value*1);
			//}
		}
		document.form1.disk_tot.value=tmp.toFixed(2)*1;
	}else{
		//if (document.form1.chkItem.checked){
			tmp=(document.form1.diskon_rp.value*1);
		//}
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
	if (document.form1.obat_id.length){
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
	if (document.form1.obat_id.length){
		for (var i=0;i<document.form1.obat_id.length;i++){
			if (document.form1.chkItem[i].checked){
				if (document.form1.expired[i].value==''){
					alert('Isikan Expired Date Dari Item Obat !');
					document.form1.expired[i].focus();
					return false;
				}
				cdata +=document.form1.po_id[i].value+'|'+document.form1.obat_id[i].value+'|'+document.form1.kepemilikan_id.value+'|'+document.form1.expired[i].value+'|'+document.form1.qty_kemasan[i].value+'|'+document.form1.kemasan[i].value+'|'+document.form1.h_kemasan[i].value+'|'+document.form1.qty_per_kemasan[i].value+'|'+document.form1.qty_satuan[i].value+'|'+document.form1.satuan[i].value+'|'+document.form1.h_satuan[i].value+'|'+document.form1.sub_tot[i].value+'|'+document.form1.diskon[i].value+'|'+document.form1.diskon_rp[i].value+'|'+document.form1.jenis[i].value+'|'+document.form1.aharga[i].value+'**';
			}
		}
		if (cdata!=""){
			cdata=cdata.substr(0,cdata.length-2);
		}else{
			alert("Pilih Item Obat Yg Mau Diterima Terlebih Dahulu !");
			return false;
		}
	//}else if (document.form1.chkItem.checked){
	}else{
		if (document.form1.chkItem.checked){
			if (document.form1.expired.value==''){
				alert("Isikan Expired Date Dari Item Obat !");
				document.form1.expired.focus();
				return false;
			}
			cdata +=document.form1.po_id.value+'|'+document.form1.obat_id.value+'|'+document.form1.kepemilikan_id.value+'|'+document.form1.expired.value+'|'+document.form1.qty_kemasan.value+'|'+document.form1.kemasan.value+'|'+document.form1.h_kemasan.value+'|'+document.form1.qty_per_kemasan.value+'|'+document.form1.qty_satuan.value+'|'+document.form1.satuan.value+'|'+document.form1.h_satuan.value+'|'+document.form1.sub_tot.value+'|'+document.form1.diskon.value+'|'+document.form1.diskon_rp.value+'|'+document.form1.jenis.value+'|'+document.form1.aharga.value;
		}else{
			alert("Pilih Item Obat Yg Mau Diterima Terlebih Dahulu !");
			return false;
		}
	}
	//alert(cdata);
	document.form1.fdata.value=cdata;
	document.form1.submit();
}
</script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<?php if ($act=="save"){?>
<div align="center">
<!-- Print Out -->
	<div id="printArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	  <p align="center"><span class="jdltable">PENERIMAAN GUDANG</span></p>
	  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
       
		<tr> 
          <td width="115">No Penerimaan</td>
          <td width="260">: <?php echo $no_gdg; ?>
            </td>
          <td width="93">Harga Total</td>
          <td width="224">: <?php echo number_format($h_tot,2,",","."); ?>
            </td>
          <td width="113">PPN (10%)</td>
          <td width="214">: <?php echo number_format($ppn,2,",","."); ?>
            </td>
        </tr>
        <tr> 
          <td width="115">Tgl Penerimaan</td>
          <td>: <?php echo $tgl_gdg; ?>
                      </td>
          <td>Diskon Total</td>
          <td>: <?php echo number_format($disk_tot,2,",","."); ?>
           </td>
          <td>T O T A L</td>
          <td>: <?php echo number_format($total,2,",","."); ?>
            </td>
        </tr>
        <tr> 
          <td>No PO</td>
          <td>: <?php echo $no_po; ?></td>
          
        <td>Harga Diskon</td>
          <td>: <?php echo number_format($h_diskon,2,",","."); ?>
            </td>
          <td><?php if ($tipe=="2") echo "Cara Perolehan"; else echo "Jatuh Tempo";?></td>
          
        <td>: <?php if ($tipe=="2"){if ($jenis=="1") echo "Konsinyasi"; else echo "Hibah/Bantuan";}else echo $h_j_tempo." hari"; ?></td>
        </tr>
        <tr> 
          <td>No Faktur</td>
          <td>: <?php echo $no_faktur; ?>
            </td>
          <td><?php if ($tipe=="2") echo "Asal Perolehan"; else echo "PBF";?></td>
          <td>: <?php echo $pbf; ?></td>
          
        <td>Kepemilikan</td>
          
        <td>: <?php echo $kp_nama; ?></td>
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
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
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
  <p align="center">Penerimaan Gudang Dgn No Penerimaan : <?php echo $no_gdg; ?> 
    Sudah Disimpan</p>
	<?php if ($msgupdt!="") echo "<span class='txtinput'>".$msgupdt."Harga Penerimaan Baru Lebih Besar dari Master Harga, Tapi Tdk Bisa Diupdate karena di-Lock<br></span>"; ?>
	<p align="center">
	<BUTTON type="button" onClick='PrintArea("printArea","#")'><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
    Penerimaan&nbsp;&nbsp;</BUTTON>
	&nbsp;
    <BUTTON type="button" onClick="location='?f=penerimaan.php&tipe=<?php echo $tipe; ?>'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Daftar 
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
	<input name="tipe" id="tipe" type="hidden" value="<?php echo $tipe; ?>">
    <input name="updt_harga" id="updt_harga" type="hidden" value="0">
	<input name="pbf_id" id="pbf_id" type="hidden" value="<?php echo $pbf_id; ?>">
	<input name="kp_nama" id="kp_nama" type="hidden" value="<?php echo $kp_nama; ?>">
	<input name="kepemilikan_id" id="kepemilikan_id" type="hidden" value="<?php echo $kp_id; ?>">
	<input name="plus_ppn" id="plus_ppn" type="hidden" value="<?php echo $inc_ppn; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
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
          <td width="110">PPN (10%)</td>
          <td width="115">: 
            <input name="ppn" type="text" class="txtright" id="ppn2" value="<?php echo $ppn; ?>" size="15" readonly="true"></td>
        </tr>
        <tr> 
          <td width="107">Tgl Penerimaan</td>
          <td>: 
            <input name="tgl_gdg" type="text" id="tgl_gdg" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_gdg; ?>"> 
            <!--input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_gdg,depRange);" /-->          </td>
          <td>Diskon Total</td>
          <td>: 
            <input name="disk_tot" type="text" class="txtright" id="disk_tot" value="<?php echo $diskon_tot; ?>" size="15" readonly="true"></td>
          <td>T O T A L</td>
          <td>: 
            <input name="total" type="text" class="txtright" id="total" value="<?php echo $total; ?>" size="15" readonly="true"></td>
        </tr>
        <tr> 
          <td>No PO </td>
          <td>: <input name="no_po" type="text" id="no_po" size="25" maxlength="30" class="txtcenter" readonly="true" value="<?php echo $no_po; ?>"></td>
          <td>Harga Diskon</td>
          <td>: 
            <input name="h_diskon" type="text" class="txtright" id="h_diskon" value="<?php echo $h_diskon; ?>" size="15" readonly="true"></td>
          <td><?php if ($tipe=="2") echo "Cara Perolehan"; else echo "Jatuh Tempo";?></td>
          <td>: 
            <?php if ($tipe=="2"){?><input name="h_j_tempo" type="hidden" class="txtcenter" id="h_j_tempo" value="0" size="3" maxlength="2"><?php if ($jenis==1) echo "Konsinyasi"; elseif ($jenis==2) echo "Hibah/Bantuan"; else echo "Return PBF";}else{?><input name="h_j_tempo" type="text" class="txtcenter" id="h_j_tempo" value="<?php echo $j_tempo; ?>" size="3" maxlength="2"> hari<?php }?>            </td>
        </tr>
        <tr> 
          <td>No Faktur</td>
          <td>: 
            <input name="no_faktur" type="text" readonly class="txtinput" id="no_faktur" value="<?php echo $no_faktur; ?>" size="25" maxlength="30" autocomplete="off"></td>
          <td colspan="2"><?php if ($tipe=="2") echo "Asal Perolehan"; else echo "PBF";?> : <?php echo $pbf; ?></td>
          <td>Kepemilikan</td>
          <td>: <?php echo $kp_nama; ?></td>
        </tr>
        <tr>
          <td>Pemeriksa</td>
          <td>:
            <select name="cmbpemeriksa" id="cmbpemeriksa" class="txtinput" disabled>
            <?php 
			$sql="SELECT * FROM a_pemeriksa WHERE aktif=1";
			$rsP=mysqli_query($konek,$sql);
			while ($rwP=mysqli_fetch_array($rsP)){
			?>
              <option value="<?php echo $rwP['id']; ?>"<?php if ($id_pemeriksa==$rwP['id']) echo " selected"; ?> class="txtinput"><?php echo $rwP['pemeriksa']; ?></option>
            <?php 
			}
			?>
            </select>
          </td>
          <?php
		  $sPenerima="SELECT 
					  a_u.username 
					FROM
					  a_penerimaan a_p 
					  INNER JOIN a_user a_u 
						ON a_u.kode_user = a_p.USER_ID_TERIMA 
					WHERE a_p.NOTERIMA = '$no_gdg' 
					  AND a_p.NOBUKTI = '$no_faktur' 
					  AND a_p.UNIT_ID_TERIMA = 1 
					  AND a_p.UNIT_ID_KIRIM = 0 
					ORDER BY a_p.ID LIMIT 1";
			$qPenerima=mysqli_query($konek,$sPenerima);
			$rwPenerima=mysqli_fetch_array($qPenerima);
		  ?>
          <td colspan="2">Penerima : <?php echo $rwPenerima['username']; ?></td>
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
          <td id="OBAT_KODE" width="20" class="tblheader"> Pilih
            <!--input type="checkbox" name="chkAll" id="chkAll" value="" onClick="fCheckAll(chkAll,chkItem);HitunghDiskonTot();HitunghTot();" style="cursor:pointer" title="Pilih Semua"-->
          </td>
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
      	  <td width="61" class="tblheader">DPP</td>
      	  <td width="61" class="tblheader">DPP+PPN</td>
        </tr>
        <?php 
	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select a_p.*,date_format(a_p.EXPIRED,'%d-%m-%Y') as tgl2,a_p.HARGA_KEMASAN*QTY_KEMASAN as subtotal,o.OBAT_KODE,o.OBAT_NAMA,k.NAMA from a_penerimaan a_p inner join a_obat o on a_p.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_p.KEPEMILIKAN_ID=k.ID where a_p.NOTERIMA='$no_gdg' AND a_p.NOBUKTI='$no_faktur' AND a_p.UNIT_ID_TERIMA=$idunit AND a_p.UNIT_ID_KIRIM=0".$filter." order by ".$sorting;
	  //echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
		$i++;
		$kemasan=$rows['KEMASAN'];
		$satuan=$rows['SATUAN'];
		$qty_kemasan=$rows['QTY_KEMASAN'];
		$spph_id=$rows['spph_id'];
		$obat_id=$rows['OBAT_ID'];
		$exp_date=$rows['tgl2'];
		$po_id=$rows['ID'];
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
          <td class="tdisi" align="center"> <input type="checkbox" name="chkItem" value="<?php echo $po_id.'|'.$obat_id; ?>" onClick="SetEnDisAttribut(<?php echo ($i-1); ?>);HitunghDiskonTot();HitunghTot();"></td>
          <td class="tdisi" align="left"><input name="po_id" type="hidden" value="<?php echo $po_id; ?>"> 
            <input name="obat_id" type="hidden" value="<?php echo $obat_id; ?>"><input name="jenis" type="hidden" value="<?php echo $rows['JENIS']; ?>">
			<input name="aharga" type="hidden" value="<?php echo $harga_lama.'|'.$lock_harga; ?>">
            <?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><input name="expired" readonly type="text" class="txtcenter" id="expired" lang="<?php echo $rows['tgl2']; ?>" value="<?php echo $rows['tgl2']; ?>" size="11" maxlength="10" autocomplete="off"></td>
          <td class="tdisi" align="center"><input name="qty_kemasan" type="text" readonly id="qty_kemasan" class="txtcenter" size="3" lang="<?php echo $qty_kemasan; ?>" value="<?php echo $qty_kemasan; ?>" onKeyUp="HitungQtySatuan(<?php echo ($i-1); ?>);HitungSubTotal(<?php echo ($i-1); ?>);HitungDiskon(<?php echo ($i-1); ?>,1);" autocomplete="off"></td>
          <td class="tdisi" align="center"> <input name="kemasan" class="txtinput" id="kemasan" value="<?php echo $rows['KEMASAN']; ?>" size="12"> 
          </td>
          <td class="tdisi" align="right"><input name="h_kemasan" type="text" readonly class="txtright" id="h_kemasan" onKeyUp="HitungSubTotal(<?php echo ($i-1); ?>);HitungHargaSatuan(<?php echo ($i-1); ?>);HitungDiskon(<?php echo ($i-1); ?>,1);" lang="<?php echo $rows['HARGA_KEMASAN']; ?>" value="<?php echo $rows['HARGA_KEMASAN']; ?>" size="8" autocomplete="off"></td>
          <td class="tdisi" align="center"><input name="qty_per_kemasan" type="text" readonly class="txtcenter" id="qty_per_kemasan" onKeyUp="HitungQtySatuan(<?php echo ($i-1); ?>);HitungHargaSatuan(<?php echo ($i-1); ?>);" lang="<?php echo $rows['QTY_PER_KEMASAN']; ?>" value="<?php echo $rows['QTY_PER_KEMASAN']; ?>" size="3" autocomplete="off"></td>
          <td class="tdisi" align="center"><input name="qty_satuan" type="text" class="txtcenter" id="qty_satuan" onKeyUp="" value="<?php echo $rows['QTY_SATUAN']; ?>" size="5" autocomplete="off" readonly="true"></td>
          <td class="tdisi" align="center"> <input name="satuan" id="satuan" value="<?php echo $rows['SATUAN'];?>" type="text" size="7"> 
          </td>
          <td class="tdisi" align="right"><input name="h_satuan" type="text" class="txtright" id="h_satuan" onKeyUp="" value="<?php echo $rows['HARGA_BELI_SATUAN']; ?>" size="7" autocomplete="off" readonly="true"></td>
          <td class="tdisi" align="right"><input name="sub_tot" type="text" class="txtright" id="sub_tot" onKeyUp="" value="<?php echo $rows['subtotal']; ?>" size="8" readonly="true"></td>
          <td class="tdisi" align="center"><input name="diskon" type="text" readonly class="txtcenter" id="diskon" onKeyUp="HitungDiskon(<?php echo ($i-1); ?>,1);" lang="<?php echo $rows['DISKON']; ?>" value="<?php echo $rows['DISKON']; ?>" size="3" autocomplete="off"></td>
          <td class="tdisi" align="right"><input name="diskon_rp" type="text" readonly class="txtright" id="diskon_rp" onKeyUp="HitungDiskon(<?php echo ($i-1); ?>,2);" lang="<?php echo (($rows['subtotal']*$rows['DISKON'])/100); ?>" value="<?php echo (($rows['subtotal']*$rows['DISKON'])/100); ?>" size="7" autocomplete="off"></td>
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
			&nbsp;<BUTTON type="reset" onClick="location='?f=penerimaan.php&tipe=<?php echo $tipe; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
		  </p>
</form>
</div>
<?php 
}
?>
</body>

</html>
<?php 
mysqli_close($konek);
?>
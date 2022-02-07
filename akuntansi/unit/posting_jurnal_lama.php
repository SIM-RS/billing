<?php 
include("../koneksi/konek.php");
include("../sesi.php");

$th=gmdate('d-m-Y',mktime(date('H')+7));
$th5=$th;
//$th=date('d-m-Y');
$th=explode("-",$th);
$sekarang = gmdate('Y-m-d',mktime(date('H')+7));

//Untuk Input ID FK_SAK
$id_sak=$_REQUEST['id_sak'];
$fkBebanJenis=$_REQUEST['id_BebanJenis'];
$pCC_RV_KSO_PBF_UMUM=$_REQUEST['pCC_RV_KSO_PBF_UMUM'];
$id_CC=$_REQUEST['id_CC'];
$cc_rv_id=$_REQUEST['cc_rv_id'];
$id_tr=$_REQUEST['id_tr'];
$kepada = $_REQUEST['kepada'];
$alamat = $_REQUEST['alamat'];

//Input FK_SAK berakhir
if ($_REQUEST['fk_kodeTrans']=="") $fk_kodeTrans=0; else $fk_kodeTrans=$_REQUEST['fk_kodeTrans'];
if ($_REQUEST['fk_TipeTrans']=="") $fk_TipeTrans=0; else $fk_TipeTrans=$_REQUEST['fk_TipeTrans'];
$arfvalue=$_GET['arfvalue'];
$kodepilih=$_REQUEST['kodepilih'];
if(isset($_REQUEST['stts'])){
	$stts = $_REQUEST['stts'];
}else{
	$stts = 0;
}
$iduser=$_SESSION['akun_iduser'];
$cuser=$_REQUEST['cuser'];if ($cuser=="") $cuser=$iduser;
$userKategori=$_SESSION['akun_kategori'];
$StyleEvSpan="";
if ($userKategori=="1"){
	$StyleEvSpan="";
}
$cidTotK=0;
$cmbVer=$_REQUEST['cmbVer'];
$fk_jnsTrans=$_REQUEST['fk_jnsTrans'];if ($fk_jnsTrans=="") $fk_jnsTrans=0;
$pid_jnsTrans=$_REQUEST['pid_jnsTrans'];if ($pid_jnsTrans=="") $pid_jnsTrans=0;
$pid_BebanJenis=$_REQUEST['idBebanJenis'];if ($pid_BebanJenis=="") $pid_BebanJenis=0;
$fk_TipeJurnal=$_REQUEST['fk_TipeJurnal'];if ($fk_TipeJurnal=="") $fk_TipeJurnal=0;
$strBJenis="";
if ($pid_BebanJenis>0) $strBJenis=" AND (detil_transaksi.fk_ms_beban_jenis = '$pid_BebanJenis' OR detil_transaksi.fk_ms_beban_jenis = 0)";
$fk_kodeTrans=$_REQUEST['fk_kodeTrans'];if ($fk_kodeTrans=="") $fk_kodeTrans=0;
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0"?substr($th[1],1,1):$th[1]);
$bulan=explode("|",$bulan);
$tgl4=$_REQUEST['tgl'];$tgl4=explode("-",$tgl4);
$tgl=$tgl4[2]."-".$tgl4[1]."-".$tgl4[0];
//$tgl=$_REQUEST[tgl];
if (($_REQUEST['nokw']!="") && ($_REQUEST['nokw']!=" ")){
	$_SESSION["tnokw"]=$_REQUEST['nokw'];
}elseif ($_REQUEST['nokw']==" "){
	$_SESSION["tnokw"]="";
}
if (($_REQUEST['uraian']!="") && ($_REQUEST['uraian']!=" ")){
	$_SESSION["turaian"]=$_REQUEST['uraian'];
}elseif ($_REQUEST['uraian']==" "){
	$_SESSION["turaian"]="";
}
if ($_REQUEST['tgl']!=""){
	$_SESSION["tskrg"]=$_REQUEST['tgl'];
}elseif ($_SESSION["tskrg"]==""){
	$_SESSION["tskrg"]=date("d-m-Y",strtotime($sekarang));
}
$tnokw=$_SESSION["tnokw"];
$turaian=$_SESSION["turaian"];
$tskrg=$_SESSION["tskrg"];
//Convert tgl di URL menjadi YYYY-mm-dd ==============================
if ($_REQUEST['tgl_s']!=""){
	$_SESSION["tgl_s"]=$_REQUEST['tgl_s'];
}elseif ($_SESSION["tgl_s"]==""){
	$_SESSION["tgl_s"]=gmdate('d-m-Y',mktime(date('H')+7));
}
if ($_REQUEST['tgl_d']!=""){
	$_SESSION["tgl_d"]=$_REQUEST['tgl_d'];
}elseif ($_SESSION["tgl_d"]==""){
	$_SESSION["tgl_d"]=gmdate('d-m-Y',mktime(date('H')+7));
}
$tgl_s=$_SESSION["tgl_s"];
//$tgl_s=$_REQUEST['tgl_s'];
//if ($tgl_s=="") $tgl_s=gmdate('d-m-Y',mktime(date('H')+7));
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";
$tgl_1=$tgl_se;

$tgl_d=$_SESSION["tgl_d"];
//$tgl_d=$_REQUEST['tgl_d'];
//if ($tgl_d=="") $tgl_d=gmdate('d-m-Y',mktime(date('H')+7));
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
$tgl_2=$tgl_de;
//===========================================================

//Tabel Jurnal
$tr_id=$_REQUEST['tr_id'];if ($tr_id=="") $tr_id="0";
$notrans=$_GET['notrans'];if ($notrans=="") $notrans="0";
$no_trans=$_REQUEST['no_trans'];
$nokw=$_REQUEST['nokw'];
$nokw_lama=$_REQUEST['nokw_lama'];
$uraian=$_REQUEST['uraian'];
//$nilai = explode("|",$_REQUEST['nilaiH']);
$nilai =$_REQUEST['nilai'];
$dk=$_REQUEST['dk'];

$qstr_ma_sak="par=id_sak*kode_sak*nama_sak*id_CC";
$qstr_CC="par=id_CC*namaCC";

$page=$_REQUEST["page"];
$defaultsort="NO_TRANS DESC,TR_ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//$filter=$_POST["filter"];
//echo "filter=".$filter."<br>";
$act=$_REQUEST['act'];if ($act=="paging") $no_trans="0";
//echo $act;
switch ($act){
	case "edit":
		$sql="SELECT * FROM m_tipe_jurnal WHERE id_tipe=$fk_TipeTrans";
		$rs=mysql_query($sql);
		if ($rows=mysql_fetch_array($rs)){
			$fk_IdRek=$rows["idrek"];
		}
		$sum1=0;
		$sum2=0;
		for ($i = 0; $i < count($nilai); $i++)
			{
			//Nilainya masuk kemana?, debet atau kredit??
				if ($dk[$i]=='D') {			//Debet
					$nilai1=$nilai[$i];
					$nilai2=0;
					$sum1=$sum1+$nilai1;
				}else{						//Kredit
					$nilai1=0;	
					$nilai2=$nilai[$i];
					$sum2=$sum2+$nilai2;				
				}
			}
			//echo $sum1;
			//echo $sum2;
		//Jika Nilai Total Debet dan Kredit sama,	
		//if($sum1==$sum2)
		if(($sum1==$sum2) || (($fk_TipeTrans!=0) && ($fk_TipeTrans!="0"))){
			if (($fk_TipeTrans!=0) && ($fk_TipeTrans!="0")){
				$sql2="SELECT MAX(NO_TRANS) AS ntrans FROM jurnal_Sem WHERE NO_KW='$nokw_lama' AND FK_TRANS=$fk_jnsTrans";
				//echo $sql2."<br>";
				$rs=mysql_query($sql2);
				if ($rsrow=mysql_fetch_array($rs)){
					$tmaxnotrans=$rsrow["ntrans"]+1;
				}
			}
		//Maka Lakukan replace nilai data baru..
			for ($i = 0; $i < count($nilai); $i++){
				//Nilainya masuk kemana?, debet atau kredit??
				if ($dk[$i]=='D') {			//Debet
					$nilai1=$nilai[$i];
					$nilai2=0;
					$dk_out="K";
				}else{						//Kredit
					$nilai1=0;			
					$nilai2=$nilai[$i];
					$dk_out="D";
				}
				if (($fk_TipeTrans==0) || ($fk_TipeTrans=="0")){
					$sql2="update JURNAL_sem set fk_sak=$id_sak[$i],tgl='$tgl',no_kw='$nokw',uraian='$uraian',debit=$nilai1,kredit=$nilai2,tgl_act='$sekarang',fk_iduser=$iduser,d_k='$dk[$i]',CC_RV_KSO_PBF_UMUM_ID='$id_CC[$i]',KEPADA='$kepada',ALAMAT='$alamat' WHERE tr_id=".$id_tr[$i]; //decyber_jurnal
					//echo $sql2."<br>";
					$rs=mysql_query($sql2);
				}else{
					if($nilai1>0 OR $nilai2>0){
						$sql2="select * from jurnal_sem WHERE fk_sak=$id_sak[$i] and NO_KW='$nokw_lama' AND FK_TRANS=$fk_jnsTrans AND  CC_RV_KSO_PBF_UMUM_ID='$id_CC[$i]'";
						//echo $sql2."<br>";
						$rs=mysql_query($sql2);
						if ($rsrow=mysql_fetch_array($rs)){
							$tnotrans=$rsrow["NO_TRANS"];
							$tlasttrans=$rsrow["FK_LAST_TRANS"];
							$sql2="update JURNAL_sem set no_kw='$nokw',tgl='$tgl',uraian='$uraian',debit=$nilai1,kredit=$nilai2,tgl_act='$sekarang',fk_iduser=$iduser,d_k='$dk[$i]',KEPADA='$kepada',ALAMAT='$alamat' WHERE fk_sak=$id_sak[$i] and FK_TRANS=$fk_jnsTrans and NO_TRANS=$tnotrans and NO_KW='$nokw_lama' AND CC_RV_KSO_PBF_UMUM_ID='$id_CC[$i]'"; //decyber_jurnal
							//echo $sql2."<br>";
							$rs1=mysql_query($sql2);
							$sql2="update JURNAL_SEM set no_kw='$nokw',tgl='$tgl',uraian='$uraian',debit=$nilai2,kredit=$nilai1,tgl_act='$sekarang',fk_iduser=$iduser,d_k='$dk_out',KEPADA='$kepada',ALAMAT='$alamat' WHERE fk_sak=$fk_IdRek and FK_TRANS=$fk_jnsTrans and NO_TRANS=$tnotrans and NO_KW='$nokw_lama' AND FK_LAST_TRANS='$tlasttrans'";//decyber_jurnal
							//echo $sql2."<br>";
							$rs1=mysql_query($sql2);
						}else{
							$tnotrans=$tmaxnotrans;
							$tmaxnotrans++;
							$sql2="insert into JURNAL_SEM(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,MS_BEBAN_JENIS_ID,CC_RV_KSO_PBF_UMUM_ID,KEPADA,ALAMAT,flag) values($tnotrans,$id_sak[$i],'$tgl','$nokw','$uraian',$nilai1,$nilai2,'$sekarang',$iduser,'$dk[$i]',$fk_TipeTrans,$fk_jnsTrans,$pid_jnsTrans[$i],'$fkBebanJenis[$i]','$id_CC[$i]','$kepada','$alamat','$flag')"; //decyber_jurnal
							//echo $sql2."<br>";
							$rs1=mysql_query($sql2);
							$sql2="insert into JURNAL_SEM(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,KEPADA,ALAMAT,flag) values($tnotrans,$fk_IdRek,'$tgl','$nokw','$uraian',$nilai2,$nilai1,'$sekarang',$iduser,'$dk_out',$fk_TipeTrans,$fk_jnsTrans,$pid_jnsTrans[$i],'$kepada','$alamat','$flag')";
							//echo $sql2."<br>";
							$rs1=mysql_query($sql2);
						}
					}
				}
			}
				/*echo "<script>location='?f=transaksi&fk_jnsTrans=0&arfvalue=0&bulan=$_GET[bulan]&ta=$_GET[ta]'</script>";*/
			$fk_kodeTrans=0;
			$fk_jnsTrans=0;
			$arfvalue='0';
			$pid_jnsTrans=0;
		}else{?>
		<script>
		alert ("Maaf, Total Debet dan Kredit Anda Haruslah Sama, Silahkan Edit Data Dengan Benar");
		</script>
		<? }
		//if ($rs>0){ header("location:'f=transaksi&fk_jnsTrans=0&arfvalue=0&notrans=0'");}
		break;
	case "posting":
        $no_transaksi = $_REQUEST['notrans'];
        // hafiz - tgl posting
		$tgl_posting_popup = $_REQUEST['tgl_posting_popup'];
				
        $sql = "select * from jurnal_sem where no_trans = $no_transaksi AND move = 0";
        // echo $sql;
        $rs = mysql_query($sql);
        // if($rs==FALSE){
        //     echo mysql_error();
        // }
 
        // $rw = mysql_fetch_array($rs);
        while ($rw=mysql_fetch_array($rs)){
            // echo "<pre>";
            // var_dump($rw);
            // echo "</pre>";
          
            $sql= mysql_query("insert into jurnal(FK_ID_AK_POSTING, FK_ID_POSTING, FK_ID_USER_APP, NO_TRANS, NO_PASANGAN, FK_SAK, TGL, TGL_VERIFIKASI, NO_KW, KEPADA, ALAMAT, URAIAN, DEBIT, KREDIT, TGL_ACT, FK_IDUSER, D_K, TIPE_JURNAL, JENIS, FK_TRANS, FK_LAST_TRANS, STATUS, NO_BUKTI, MS_BEBAN_JENIS_ID, CC_RV_KSO_PBF_UMUM_ID, CC_RV_ID, KSO_ID, PBF_ID, VENDOR_ID, SELISIH, PAJAK, POSTING, VERIFIKASI, flag) VALUES ('".$rw['FK_ID_AK_POSTING']."','".$rw['FK_ID_POSTING']."','".$rw['FK_ID_USER_APP']."','".$rw['NO_TRANS']."','".$rw['NO_PASANGAN']."','".$rw['FK_SAK']."','".$tgl_posting_popup."','".$rw['TGL_VERIFIKASI']."','".$rw['NO_KW']."','".$rw['KEPADA']."','".$rw['ALAMAT']."','".$rw['URAIAN']."','".$rw['DEBIT']."','".$rw['KREDIT']."','".$rw['TGL_ACT']."','".$rw['FK_IDUSER']."','".$rw['D_K']."','".$rw['TIPE_JURNAL']."','".$rw['JENIS']."','".$rw['FK_TRANS']."','".$rw['FK_LAST_TRANS']."','".$rw['STATUS']."','".$rw['NO_BUKTI']."','".$rw['MS_BEBAN_JENIS_ID']."','".$rw['CC_RV_KSO_PBF_UMUM_ID']."','".$rw['CC_RV_ID']."','".$rw['KSO_ID']."','".$rw['PBF_ID']."','".$rw['VENDOR_ID']."','".$rw['SELISIH']."','".$rw['PAJAK']."','".$rw['POSTING']."','".$rw['VERIFIKASI']."','".$rw['flag']."')"); //decyber_jurnal
						// echo $sql."<br>batas";
            // $rs=mysql_query($sql);
            // echo "<br>";
            if($sql){
                mysql_query("update jurnal_sem set move = 1 where NO_TRANS = $no_transaksi");
            }
          
        //     if($rs==FALSE){
        //     echo mysql_error();
        // }
            
        }
    break;
    case "unposting":
				$no_transaksi = $_REQUEST['notrans'];
        $tr_id = $_REQUEST['tr_id'];
				
        $sql = "select * from jurnal_sem where tr_id = $tr_id AND no_trans = $no_transaksi AND move = 1";
        // echo $sql;
        $rs = mysql_query($sql);
        // if($rs==FALSE){
        //     echo mysql_error();
        // }
 
        // $rw = mysql_fetch_array($rs);
        while ($rw=mysql_fetch_array($rs)){
            // echo "<pre>";
            // var_dump($rw);
            // echo "</pre>";
          
            $sql= mysql_query("delete from jurnal where NO_TRANS = $no_transaksi"); //decyber_jurnal
						// echo $sql."<br>batas";
            // $rs=mysql_query($sql);
            // echo "<br>";
            if($sql){
                mysql_query("update jurnal_sem set move = 0 where NO_TRANS = $no_transaksi");
            }
        //     if($rs==FALSE){
        //     echo mysql_error();
        // }
            
        }
    break;
	case "delete":
		$nokw1=$_REQUEST["nokw1"];
		$sql="delete from jurnal_Sem where no_trans=$no_trans and NO_KW='$nokw1'";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		$pid_jnsTrans=0;
		break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="JavaScript" src="../theme/js/mod.js"></script>
<!-- untuk ajax-->
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<!--====================popup======================================-->
<link rel="stylesheet" type="text/css" href="../theme/li/popup.css" />
<script type="text/javascript" src="../theme/li/prototype.js"></script>
<script type="text/javascript" src="../theme/li/effects.js"></script>
<script type="text/javascript" src="../theme/li/popup.js"></script>
<title>Posting Jurnal</title>
<link href="../theme/simkeu.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?=$fkBebanJenis;?>
<script>
var arrRange=depRange=[];

function FormatNum(num,dec){
var k=num.toString();
var g=""; 	
var p=0;
var sisa=0;
var tmp;
var x="";
	if (k.indexOf('.')>-1){
		x=k.substr(k.indexOf('.')+1,k.length-k.indexOf('.'));
		k=k.substr(0,k.indexOf('.'));
		if (x.length>dec){
			var d;
			for (var j=x.length;j>dec;j--){
				d=x.substr(j-1,1);
				//alert(parseInt(d));
				if ((parseInt(d)+sisa)>4){
					sisa=1;
				}else{
					sisa=0;
				}
			}
			//alert(sisa);
			x=x.substr(0,dec);
			var m=(parseInt(x)+sisa).toString();
			if (m.length>x.length){
				k=(parseInt(k)+1).toString();
				x=m.substr(1,dec);
			}else{
				x=m;
			}
		}else if (x.length<dec){
			for (var h=0;h<(dec-x.length);h++) x=x+"0";
		}
	}else{
		for (var h=0;h<dec;h++) x=x+"0";
	}
	if (x=="") k=k; else k=k+'.'+x;
	//alert(k);
	return k;
}

function FormatNumberFloat(num,dec,dec_char,dec_char_asal){
var k=num.toString();
var g="";
var p=0;
var sisa=0;
var tmp;
var x="";
	if (k.indexOf(dec_char_asal)>-1){
		x=k.substr(k.indexOf(dec_char_asal)+1,k.length-k.indexOf(dec_char_asal));
		k=k.substr(0,k.indexOf(dec_char_asal));
		if (x.length>dec){
			var d;
			for (var j=x.length;j>dec;j--){
				d=x.substr(j-1,1);
				//alert(parseInt(d));
				if ((parseInt(d)+sisa)>4){
					sisa=1;
				}else{
					sisa=0;
				}
			}
			//alert(sisa);
			x=x.substr(0,dec);
			var m=(parseInt(x)+sisa).toString();
			if (m.length>x.length){
				k=(parseInt(k)+1).toString();
				x=m.substr(1,dec);
			}else{
				x=m;
			}
		}else if (x.length<dec){
			for (var h=0;h<(dec-x.length);h++) x=x+"0";
		}
	}else{
		for (var h=0;h<dec;h++) x=x+"0";
	}
	if (x=="") k=FormatNumberFloor(k,"."); else k=FormatNumberFloor(k,".")+dec_char+x;
	//alert(k);
	return k;
}

function FormatNumberFloor(num,thousand_char){
var k=num.toString();
var tmp;
var x="";
	if (k.length>3){
		while (k.length>3){
			x=thousand_char+k.substr(k.length-3,3)+x;
			k=k.substr(0,k.length-3);
		}
		tmp=k+x;
		if (tmp.substr(0,2)=="-.") tmp="-"+tmp.substr(2,tmp.length-2);
	}else{
		tmp=k;
	}
	return tmp;
}

function cari(e,par){
var totD=0,totK=0;
var key;
	if(window.event) {
	  key = window.event.keyCode; 
	}
	else if(e.which) {
	  key = e.which;
	}
	if (isNaN(par.value)){
		alert("Data Yang Dimasukkan Harus Angka !");
		return false;
	}
	//alert(par.value);
	for (var it=0;it<document.form1.nilai.length;it++){
		//alert(document.form1.dk[it].value);
		if (document.form1.dk[it].value=="D"){
			totD+=document.form1.nilai[it].value*1;
		}else{
			totK+=document.form1.nilai[it].value*1;
		}
	}
	
	if ((document.getElementById("cidTotK").value) * 1 > 0){
		document.form1.nilai[(((document.getElementById("cidTotK").value) * 1) - 1)].value=totD;
		totK=totD;
	}
	//alert(totD+" - "+totK);
	document.getElementById("totdebit").innerHTML=FormatNumberFloat(totD,2,",",".");
	document.getElementById("totkredit").innerHTML=FormatNumberFloat(totK,2,",",".");
}

function spnClick(p){
	bersih();
	document.getElementById("lastTR_ID").value=p;
	window.scroll(0,0);
	new Popup('popGrPet',null,{modal:true,position:'center',duration:1});
	document.getElementById('popGrPet').popup.show();
}

function addAtributOnklikButonSim2(value){
	var sim2 = document.getElementById('sim2');
	var data_atributType = sim2.getAttribute("onclick");
	data_atributType = data_atributType + '&tgl_posting_popup=' + value + "';";
	sim2.setAttribute('onclick', data_atributType);
}

function postingClick(data_atribut){
	bersih();
	window.scroll(0,0);
	new Popup('popPostingTgl',null,{modal:true,position:'center',duration:1});
	// ambil data atribut url
	var data_atributType = data_atribut.getAttribute("data-url");
	document.getElementById('sim2').setAttribute('onclick', data_atributType);
	document.getElementById('popPostingTgl').popup.show();
}

function bersih(){
	document.getElementById("lastTR_ID").value="";
	document.getElementById("newMAId").value="";
	document.getElementById("newMAKode").value="";
	document.getElementById("newMAIdCCRVPBFKSO").value="0";
	document.getElementById("newKRek").value="Pilih Kode Rekening";
	document.getElementById("spnEvReqNewMA").innerHTML='';
}

function SimpanNewMA(){
var url;
	var nMAId=document.getElementById("newMAId").value;
	var IdCCRV=document.getElementById("newMAIdCCRVPBFKSO").value;
	var idtr=document.getElementById("lastTR_ID").value;
	url='newMA_utils.php?idtr='+idtr+'&newMAId='+nMAId+'&IdCCRVKSOPBF='+IdCCRV;
	//alert(url);
	Request(url, 'spnEvReqNewMA', '', 'GET',
	function(){
		var cd=document.getElementById("spnEvReqNewMA").innerHTML;
		//alert(document.getElementById("spnEvReqNewMA").innerHTML);
		if (cd!=""){
			//alert(cd);
			cd=cd.split('|');
			document.getElementById("EditableTrKode"+idtr).innerHTML=cd[0];
			document.getElementById("EditableTrMA"+idtr).innerHTML=cd[1];
			//alert(cd[0]);
			//alert(cd[1]);
		}
	},'NoLoad');
}

function tes(){
	
}
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 500px; visibility: hidden">
</iframe>

<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 500px; visibility: hidden">
</iframe>
<span id="spnEvReqNewMA" style="display:none"></span>
<!-- POPUP TANGGAL POSTING -->
<div id="popPostingTgl" style="display:none; width:500px;height:auto" class="popup">
        <table width="490" align="center" cellpadding="3" cellspacing="0">
        <tr>
            <td colspan="2" class="font" align="center">&nbsp;</td>
        </tr>
        <tr>
            <td class="font">Tanggal Posting</td>
            <td>:&nbsp; <input type="date" name="tgl_posting_popup" onchange="addAtributOnklikButonSim2(this.value)"></td>
        </tr>
        <tr>
            <td colspan="2" align="center" height="50" valign="bottom"><button id="sim2" name="sim2" value="simpan" type="button" style="cursor:pointer" class="popup_closebox"><img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Posting</button>&nbsp;&nbsp;<button type="button" id="batal" name="batal" class="popup_closebox" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button></td>
        </tr>
				</table>
</div>
<!-- #POPUP TANGGAL POSTING -->
<div id="popGrPet" style="display:none; width:500px;height:auto" class="popup">
    	<input type="hidden" id="lastTR_ID" name="lastTR_ID" />
        <input type="hidden" id="newMAId" name="newMAId" />
        <input type="hidden" id="newMAKode" name="newMAKode" />
        <input type="hidden" id="newMAIdCCRVPBFKSO" name="newMAIdCCRVPBFKSO" />
        <?php 
		$vpar="newMAId*newMAKode*newKRek*newMAIdCCRVPBFKSO";
		?>
        <table width="490" align="center" cellpadding="3" cellspacing="0">
        <tr>
            <td colspan="2" class="font" align="center">&nbsp;</td>
        </tr>
        <tr>
            <td class="font">Kode Rekening</td>
            <td>:&nbsp;<input type="text" id="newKRek" readonly="readonly" size="45" value="Pilih Kode Rekening" />&nbsp;<input type="button" value=".." onClick="OpenWnd('tree_ma_ajax.php?par=<?php echo $vpar; ?>',800,500,'mstre',true)" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center" height="50" valign="bottom"><button id="sim" name="sim" value="simpan" type="button" style="cursor:pointer" class="popup_closebox" onClick="SimpanNewMA(this.value)"><img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan</button>��<button type="button" id="batal" name="batal" class="popup_closebox" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button></td>
        </tr>
        </table>
</div>
<div align="center" style="margin-top:10px;">
	<input name="f" id="f" type="hidden" value="transaksi">
	<form name="form1" method="POST" action="">
	<input name="act" id="act" type="hidden" value="<?php if ($arfvalue=='edit'){echo 'edit';}else{echo 'save';}?>">
    <input name="kodepilih" id="kodepilih" type="hidden" value="<?php echo $kodepilih; ?>">
	<input name="tr_id" id="tr_id" type="hidden" value="">
    <input type="hidden" name="no_trans" id="no_trans" value="<?php echo $notrans; ?>" />
    <input type="hidden" name="nokw1" id="nokw1" value="" />
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
<div id="input" style="display:block;">
   
     
<!-- Ending Transaksi Jurnal -->
<!-- Menampilkan Data Dalam Tabel -->
<div id="listjurnal" style="margin-top:15px"><br>
    <table width="99%" border="0" cellpadding="2" cellspacing="0">
      <tr> 
        <td colspan="11"><div align="center"><span class="jdltable">Posting Journal 
            </span></div></td>
      </tr>
      <tr> 
        <td colspan="11">&nbsp;</td>
      </tr>
      <tr>
	  <td colspan="11" valign="middle" class="txtinput">Data dientry Oleh : 
	    <select name="cuser" id="cuser" class="txtinput" onChange="location='?f=transaksi.php&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value+'&cuser='+cuser.value+'&cmbVer='+cmbVer.value+'&kodepilih=<?php echo $kodepilih; ?>'">
        	<option value="0">ALL USER</option>
        <?php 
		$sql="SELECT * FROM user_master WHERE kategori=2";
		$rs=mysql_query($sql);
		while ($rows=mysql_fetch_array($rs)){
		?>
        	<option value="<?php echo $rows['kode_user']; ?>"<?php if ($cuser==$rows['kode_user']) echo ' selected';?>><?php echo strtoupper($rows['username']); ?></option>
        <?php 
		}
		?>
		<option value="<?php echo $rows['kode_user']; ?>"<?php if ($cuser==$rows['kode_user']) echo ' selected';?>><?php echo strtoupper($rows['username']); ?></option>
	      </select>
				Status
		 <select name="stts" id="stts" class="txtinput">
			<?php if($stts == 0){ ?>
        	<option value="0" selected>Belum Posting</option>
					<option value="1">Sudah Posting</option>
			<?php }else{ ?>
					<option value="0">Belum Posting</option>
					<option value="1"  selected>Sudah Posting</option>
			<?php } ?>
					</select>
        
        	
	      <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Status Verifikasi :
	      <select id="cmbVer" name="cmbVer" onChange="location='?f=transaksi.php&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value+'&cuser='+cuser.value+'&cmbVer='+cmbVer.value+'&kodepilih=<?php echo $kodepilih; ?>';">
		<option value="" <?php echo ($cmbVer=='')?'selected':'' ?> >Semua</option>
		<option value="1" <?php echo ($cmbVer=='1')?'selected':'' ?> >Sudah</option>
		<option value="0" <?php echo ($cmbVer=='0')?'selected':'' ?> >Belum</option>
	      </select-->
	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tanggal :
        <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" />
        </input>	
       	  <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>&nbsp;&nbsp;&nbsp;</input>
       	  s/d&nbsp;&nbsp;&nbsp; 
          <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d;?>" >
          </input> 
   	    <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />       	  </input>		
		<button type="button" onClick="location='?f=posting_jurnal.php&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value+'&cuser='+cuser.value+'&stts='+stts.value+'&kodepilih=<?php echo $kodepilih; ?>'">
		<img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button>
	  <!--button type="button" id="btnAdd" name="btnAdd" onClick="document.getElementById('input').style.display='block';">
		<img src="../icon/add.gif" height="16" width="16" border="0" />&nbsp; Tambah
	  </button-->
	  </td>
      </tr>
      <tr class="headtable">
        <td width="30" class="tblheaderkiri">No</td>
        <td id="NO_TRANS" width="25" class="tblheader" onClick="ifPop.CallFr(this);">No 
          Trans</td>
        <td id="TGL" width="60" class="tblheader" onClick="ifPop.CallFr(this);">Tgl</td>
        <td id="NO_KW" width="80" class="tblheader" onClick="ifPop.CallFr(this);">No 
          Bukti</td>
        <td id="MA_KODE" width="70" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
          COA</td>
        <td width="250" class="tblheader" id="MA_NAMA" onClick="ifPop.CallFr(this);">NAMA COA</td>
        <td class="tblheader" id="URAIAN" onClick="ifPop.CallFr(this);">Uraian</td>
        <td id="DEBIT" width="60" class="tblheader" onClick="ifPop.CallFr(this);">Debet</td>
        <td id="KREDIT" width="60" class="tblheader" onClick="ifPop.CallFr(this);">Kredit</td>
        <td class="tblheader" colspan="3">Proses</td>
      </tr>
      <?php 
	  $cfilter=$filter;
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  if ($cuser=="0") $fuser=""; else $fuser=" AND FK_IDUSER=".$cuser;
		if ($cmbVer=="0"){ $fver=" AND STATUS='".$cmbVer."' "; }else if($cmbVer=="1"){ $fver=" AND STATUS='".$cmbVer."' "; }else{ $fver="";}
		// echo $stts;
		if($kodepilih == 3){
			$sqlQ="Select jurnal_sem.*, ma_sak.MA_KODE, ma_sak.MA_KODE_KP, ma_sak.MA_NAMA, ma_sak.FK_MA, ma_sak.CC_RV_KSO_PBF_UMUM From jurnal_sem Inner Join ma_sak ON jurnal_sem.FK_SAK = ma_sak.MA_ID where TGL between '$tgl_1' and '$tgl_2' AND VERIFIKASI=1 ".$fuser.$fver.$filter." AND flag = '$flag' AND move = $stts AND jurnal_sem.TIPE_JURNAL IN ($kodepilih,0) order by ".$sorting;
		}else{
		$sqlQ="Select jurnal_Sem.*, ma_sak.MA_KODE, ma_sak.MA_KODE_KP, ma_sak.MA_NAMA, ma_sak.FK_MA, ma_sak.CC_RV_KSO_PBF_UMUM From jurnal_sem Inner Join ma_sak ON jurnal_sem.FK_SAK = ma_sak.MA_ID where TGL between '$tgl_1' and '$tgl_2' AND VERIFIKASI=1 ".$fuser.$fver.$filter." AND flag = '$flag' AND move = $stts AND jurnal_sem.TIPE_JURNAL = $kodepilih order by ".$sorting;
		}
	  // echo $sqlQ."<br>";
		$rs=mysql_query($sqlQ);
		$jmldata=mysql_num_rows ($rs);
		if (($page=="")||($page=="0")) $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sqlQ." limit $tpage,$perpage";

	  $rs=mysql_query($sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  $trk=0;
	  while ($rows=mysql_fetch_array ($rs)){
	  	$i++;
		$cposting=$rows["POSTING"];
		$arfvalue="act*-*edit*|*tr_id*-*".$rows['TR_ID']."*|*tgl*-*".$itgl."*|*uraian*-*".$rows['URAIAN']."*|*nokw*-*".$rows['NO_KW']."*|*nilai*-*".$rows['KREDIT']."*|*j_trans*-*".$rows['JTRANS_ID'];
		
		$arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
		$ccrvpbf=$rows['CC_RV_KSO_PBF_UMUM'];
		$ketcc="";
		$txtKodeMA=$rows['MA_KODE_KP'];
		
		if ($rows['MS_BEBAN_JENIS_ID']>0){
			$sql="SELECT * FROM ak_ms_beban_jenis WHERE id=".$rows['MS_BEBAN_JENIS_ID'];
			$rscc=mysql_query($sql);
			$rwcc=mysql_fetch_array($rscc);
			$ketcc=" - ".$rwcc["nama"];
			$txtKodeMA.=" .".$rwcc["kode"];
		}else{
			$txtKodeMA.=" ";
		}
		switch ($ccrvpbf){
			/*case 1:
				$sql="SELECT * FROM ak_ms_unit WHERE tipe=1 AND id=".$rows['CC_RV_ID'];
				$rscc=mysql_query($sql);
				$rwcc=mysql_fetch_array($rscc);
				$ketcc=" - ".$rwcc["nama"];
				$txtKodeMA.=$rwcc["kode"];
				break;*/
			case 2:
				$sql="SELECT * FROM $dbbilling.b_ms_kso WHERE id=".$rows['CC_RV_KSO_PBF_UMUM_ID'];
				$rscc=mysql_query($sql);
				$rwcc=mysql_fetch_array($rscc);
				$ketcc=" - ".$rwcc["nama"];
				$txtKodeMA.=$rwcc["kode_ak"];
				break;
			case 3:
				$sql="SELECT * FROM $dbapotek.a_pbf WHERE PBF_ID=".$rows['CC_RV_KSO_PBF_UMUM_ID'];
				$rscc=mysql_query($sql);
				$rwcc=mysql_fetch_array($rscc);
				$ketcc=" - ".$rwcc["PBF_NAMA"];
				//$txtKodeMA.=$rwcc["PBF_KODE_AK"];
				break;
			case 4:
				$sql="SELECT * FROM $dbaset.as_ms_rekanan WHERE idrekanan=".$rows['CC_RV_KSO_PBF_UMUM_ID'];
				$rscc=mysql_query($sql);
				$rwcc=mysql_fetch_array($rscc);
				$ketcc=" - ".$rwcc["namarekanan"];
				//$txtKodeMA.=$rwcc["koderekanan"];
				break;
		}
		$status=$rows['STATUS'];
		if ($status>0){
			$trk=$rows['FK_MA'];
		}else{
			if ($trk==$rows['FK_SAK']) $status=1;
		}
		$sql="select * from ma_sak where MA_ID=".$rows['FK_SAK'];
		//echo $sql;
		$rs1=mysql_query($sql);
		if ($rows1=mysql_fetch_array($rs1)) $ma_n1=$rows1["MA_NAMA"]; else $ma_n1="";
		$arfhapus="act*-*delete*|*tr_id*-*".$rows['TR_ID']."*|*no_trans*-*".$rows['NO_TRANS']."*|*nokw1*-*".$rows['NO_KW'];
		?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi"><span id="idNoTrans<?php echo $rows['TR_ID']; ?>"<?php echo $StyleEvSpan; ?> title="Klik Untuk Mencetak Bukti Jurnal" style="cursor:pointer;text-decoration:underline;color:#0000FF" onClick="spnNoTransClick('<?php echo $rows['NO_TRANS']."|".$rows['NO_KW']; ?>',<?php echo $rows['TIPE_JURNAL']; ?>);"><?php echo $rows['NO_TRANS']; ?></span></td>
        <td class="tdisi"><?php echo date("d/m/Y",strtotime($rows['TGL'])); ?></td>
        <td class="tdisi">&nbsp;<?php echo $rows['NO_KW']; ?></td>
        <td class="tdisi"><span id="EditableTrKode<?php echo $rows['TR_ID']; ?>"<?php echo $StyleEvSpan; ?> title="Klik Untuk Mengubah Kode Rekening Jurnal ( Untuk Pembetulan Jurnal )" style="cursor:pointer;text-decoration:underline;color:#0000FF" onClick="spnClick(<?php echo $rows['TR_ID']; ?>);"><?php echo $txtKodeMA; ?></span></td>
        <td id="EditableTrMA<?php echo $rows['TR_ID']; ?>" align="left" class="tdisi"><?php echo $rows['MA_NAMA'].$ketcc; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['URAIAN']; ?></td>
        <td class="tdisi" align="right"><?php echo number_format($rows['DEBIT'],2,",","."); ?></td>
        <td class="tdisi" align="right"><?php echo number_format($rows['KREDIT'],2,",","."); ?></td>
        <?php
		if ($rows['JENIS']==0){
			$ijtrans=$rows['FK_LAST_TRANS'];
		}else{
			$ijtrans=$rows['FK_TRANS'];
		}
		$sqlKode=mysql_query("select JTRANS_KODE from jenis_transaksi where JTRANS_ID=".$ijtrans);
	  	$exe=mysql_fetch_array($sqlKode);
		?>
        
				<?php if($stts == 0){ ?>
					<td width="25" class="tdisi"><IMG SRC="../icon/save.ico" border="0" width="16" height="16" ALIGN="absmiddle" class="proses" title="Posting Jurnal" onClick="postingClick(this);" data-url="location='?f=posting_jurnal&fk_jnsTrans=<?=$ijtrans;?>&fk_kodeTrans=<?=$exe['JTRANS_KODE'];?>&act=posting&notrans=<?=$rows['NO_TRANS'];?>&pid_jnsTrans=<?php echo $rows['FK_LAST_TRANS']; ?>&nokw=<?php echo $rows['NO_KW']; ?>&page=<?php echo $page; ?>&tgl_s=<?=$tgl_s;?>&tgl_d=<?=$tgl_d;?>&kodepilih=<?php echo $kodepilih; ?>&cuser=<?php echo $cuser; ?>"></td>
					<td width="25" class="tdisi"><IMG SRC="../icon/edit.gif" border="0" width="16" height="16" ALIGN="absmiddle" class="proses" title="Klik Untuk Mengubah Data Transaksi" onClick="if (<?php echo $cposting; ?>==1){alert('Data Jurnal Tidak Boleh Diubah/Dihapus Karena Berasal Dari Posting Transaksi');}else{location='?f=transaksi&fk_jnsTrans=<?=$ijtrans;?>&fk_kodeTrans=<?=$exe['JTRANS_KODE'];?>&arfvalue=edit&notrans=<?=$rows['NO_TRANS'];?>&pid_jnsTrans=<?php echo $rows['FK_LAST_TRANS']; ?>&nokw=<?php echo $rows['NO_KW']; ?>&page=<?php echo $page; ?>&tgl_s=<?=$tgl_s;?>&tgl_d=<?=$tgl_d;?>&kodepilih=<?php echo $kodepilih; ?>&cuser=<?php echo $cuser; ?>';}"></td>
					<td width="25" class="tdisi"><IMG SRC="../icon/del.gif" border="0" width="16" height="16" ALIGN="absmiddle" class="proses" title="Klik Untuk Menghapus Data Transaksi" onClick="if (<?php echo $cposting; ?>==1){alert('Data Jurnal Tidak Boleh Diubah/Dihapus Karena Berasal Dari Posting Transaksi');}else{if (confirm('Yakin Ingin Menghapus Data Dengan No. Transaksi <?=$rows['NO_TRANS'];?> ?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}}"></td>
			<?php }else{ ?>
				<td width="25" class="tdisi" colspan="2"><IMG SRC="../icon/del.gif" border="0" width="16" height="16" ALIGN="absmiddle" class="proses" title="UnPosting Jurnal" onClick="location='?f=posting_jurnal&fk_jnsTrans=<?=$ijtrans;?>&tr_id=<?=$rows['TR_ID'];?>&act=unposting&notrans=<?=$rows['NO_TRANS'];?>&pid_jnsTrans=<?php echo $rows['FK_LAST_TRANS']; ?>&nokw=<?php echo $rows['NO_KW']; ?>&page=<?php echo $page; ?>&tgl_s=<?=$tgl_s;?>&tgl_d=<?=$tgl_d;?>&kodepilih=<?php echo $kodepilih; ?>&cuser=<?php echo $cuser; ?>';"></td>
			<?php } ?>
			
        
      </tr>
      <?php 
	  }
	  mysql_free_result ($rs);
	  //if ($page==$totpage){
	  //$sql="select sum(debit) as stotd, sum(kredit) as stotk from jurnal where TGL between '$tgl_1' and '$tgl_2'";
	  $sql="select sum(debit) as stotd, sum(kredit) as stotk from ($sqlQ) as t1";
	  $rs=mysql_query($sql);
	  //echo $sql;
	  $stotd=0;
	  $stotk=0;	
	  if ($rows=mysql_fetch_array($rs)){
	  	$stotd=$rows["stotd"];
		$stotk=$rows["stotk"];	
	  }
	  mysql_free_result($rs);
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td class="tdisikiri" colspan="7" align="right" height="30"><strong>Subtotal&nbsp;&nbsp;</strong></td>
        <td class="tdisi" align="right" height="30"><strong><?php echo number_format($stotd,2,",","."); ?></strong></td>
        <td class="tdisi" align="right"><strong><?php echo number_format($stotk,2,",","."); ?></strong></td>
        <td class="tdisi" colspan="3">&nbsp;</td>
      </tr>
      <?php 
	//}
	?>
      <tr> 
        <td colspan="4" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
            <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
        <td colspan="3" align="left" class="textpaging">Ke Halaman: 
          <input type="text" name="keHalaman" id="keHalaman" class="txtinput" size="1"> 
          <button type="button" onClick="act.value='paging';page.value=keHalaman.value;document.form1.submit();"><IMG SRC="../icon/go.png" border="0" width="10" height="15" ALIGN="absmiddle"></button></td>
        <td colspan="4" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
          <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
          <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
          <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;        </td>
      </tr>
    </table>
  <p><BUTTON type="button" onClick="window.open('../report/journal_print.php?&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value+'&filter=<?php echo $cfilter;?>&sorting=<?php echo $sorting;?>'+'&idunit=<?php echo $idunit.'|'.$usrname; ?>&cuser='+cuser.value)"<?php if ($i==0) echo " disabled";?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Cetak Jurnal</strong>&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
</div>
</form>
<script>
	function ReSetup(){
		alert(document.getElementById("divTblTrans").style.height);
	}
	
	function spnNoTransClick(noTrans_noKw,tipeJ){
		//alert(noTrans_noKw);
		switch(tipeJ){
			case 0:
				window.open("../../keuangan/laporan/jurnal/bukti_jurnal_rupa_rupa.php?status_posting=0&notrans_kw="+noTrans_noKw+"&status_posting=0");
				break;
			case 1:
				window.open("../report/voucher_penerimaan_print.php?status_posting=0&notrans_kw="+noTrans_noKw);
				break;
			case 2:
				window.open("../report/voucher_pengeluaran_print.php?status_posting=0&notrans_kw="+noTrans_noKw+"&status_posting=0");
				break;
			case 3:
				window.open("../../keuangan/laporan/jurnal/bukti_jurnal_rupa_rupa.php?status_posting=0&notrans_kw="+noTrans_noKw+"&status_posting=0");
				break;
			case 4:
				window.open("../../keuangan/laporan/jurnal/bukti_jurnal_rupa_rupa_penjualan_obat.php?status_posting=0&notrans_kw="+noTrans_noKw+"&status_posting=0");
				break;
			case 5:
				window.open("../report/voucher_pembelian_print.php?status_posting=0&notrans_kw="+noTrans_noKw+"&status_posting=0");
				break;
		}
	}
	
</script>
</body>
</html>
<?php 
mysql_close($konek);
?>
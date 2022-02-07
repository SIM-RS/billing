<?php 
// Koneksi =================================
include("../sesi.php"); 
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
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
<div id="divpasien" align="left" style="position:absolute; z-index:1; left: 200px; top: 25px; width:700px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
  <form name="form1" method="post" action="catatan_pemberian_obat.php" target="_blank">
  <input name="act" id="act" type="hidden" value="save">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <input type="hidden" id="kunjungan_id" name="kunjungan_id">
    <div id="listma" style="display:block">
      <p><span class="jdltable">CATATAN PEMBERIAN OBAT</span></p>
		
      <table align="center">
        <tr id="trTanggal"> 
          <td colspan="2"> <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/> 
            &nbsp;s/d 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">No. RM </td>
          <td align="center" class="txtinput">: <input type="text" id="txtNo_rm" name="txtNo_rm" class="txtinput" size="8" maxlength="8" onKeyUp="cari(event,this,1);" autocomplete="off" ></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Nama Pasien</td>
          <td align="center" class="txtinput">: <input type="text" id="txtNama" name="txtNama" class="txtinput" size="30" onKeyUp="cari(event,this,2);" autocomplete="off" ></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Unit </td>
          <td align="center" class="txtinput">: 
            <select name="idunit" id="idunit" class="txtinput">
              <option value="0">SEMUA</option>
			  <?
		  $qry="SELECT * FROM a_unit WHERE UNIT_TIPE=2 AND UNIT_ISAKTIF=1";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
		  	$i++;
			if (($idunit1=="")&&($i==1)) $idunit1=$show['UNIT_ID'];
		  ?>
              <option value="<?=$show['UNIT_ID'];?>" class="txtinput"<?php if ($idunit==$show['UNIT_ID']) {echo "";$nunit1=$show['UNIT_NAME'];}?>> 
              <?php echo $show['UNIT_NAME'];?></option>
              <? }?>
            </select></td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
        	<td><button type="button" style="cursor:pointer" onClick="view_cpo()"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
        </tr>
      </table>	  
    </div>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
<script>
function view_cpo(){
	document.forms[0].submit();
}

var RowIdx;
var fKeyEnt;
var keyCari;
function cari(e,par,p){
var keywords=par.value;
var key;
	if(window.event) {
	  key = window.event.keyCode; 
	}
	else if(e.which) {
	  key = e.which;
	}
	if ((keywords=="")||(key==27)){
		document.getElementById('divpasien').style.display='none';
	}else if (key==13){
		if (document.getElementById('divpasien').style.display=='none'){
			RowIdx=0;
			fKeyEnt=false;
			keyCari=keywords;
			document.getElementById('divpasien').innerHTML='';
			//alert('list_pasien.php?aKeyword='+keywords+'&pil='+p);
			Request('list_pasien.php?aKeyword='+keywords+'&pil='+p+'&tgl_d='+document.getElementById('tgl_d').value+'&tgl_s='+document.getElementById('tgl_s').value, 'divpasien', '', 'GET' );
			fSetPosisi(document.getElementById('divpasien'),par);
			document.getElementById('divpasien').style.display='block';
		}else{
			if (RowIdx>0){
				if (fKeyEnt==false){
					fSetPasien(document.getElementById(RowIdx).lang,1);
				}else{
					fKeyEnt=false;
				}
			}else{
				fKeyEnt=false;
				if (keyCari!=keywords){
					keyCari=keywords;
					Request('list_pasien.php?aKeyword='+keywords+'&pil='+p+'&tgl_d='+document.getElementById('tgl_d').value+'&tgl_s='+document.getElementById('tgl_s').value, 'divpasien', '', 'GET' );
				}
			}
		}
	}else if (key==38 || key==40){
		var tblRow=document.getElementById('tblPasien').rows.length;
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
	}
}

function fSetPasien(par,ap){
	var tpar=par;
	var cdata;
	var x;
	while (tpar.indexOf(String.fromCharCode(5))>0){
		tpar=tpar.replace(String.fromCharCode(5),"'");
	}
	while (tpar.indexOf(String.fromCharCode(3))>0){
		tpar=tpar.replace(String.fromCharCode(3),'"');
	}
	//alert(tpar);
	cdata=tpar.split("*|*");
	document.getElementById('divpasien').style.display='none';
	document.forms[0].txtNo_rm.value=cdata[0];
	document.forms[0].txtNama.value=cdata[1];
	document.forms[0].kunjungan_id.value=cdata[2];
}

</script>
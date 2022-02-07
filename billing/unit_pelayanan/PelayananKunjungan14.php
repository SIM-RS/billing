<?php
include("../sesi.php");
include '../koneksi/konek.php';
$userId = $_SESSION['userId'];
$sql="SELECT * FROM b_ms_group_petugas WHERE ms_pegawai_id='$userId' AND ms_group_id in (49)"; //IN (10,45,46,15)
$rs=mysql_query($sql);
$disableKunj = "disabled";
$cssdisplay = "display:none;";
$admin = 0;
if ((mysql_num_rows($rs)>0)){ //&& ($backdate!="0")
	$disableKunj="";
	$cssdisplay = "";
	$admin = '1';
}
$tglSekarangg=gmdate('d-m-Y',mktime(date('H')+7));

$sql1="SELECT * FROM b_ms_reference WHERE stref = 35";
$rs1=mysql_query($sql1);
$drs1 = mysql_fetch_array($rs1);
$sumur = $drs1['nama'];

if($sumur=='')
{
	$sumur = 15;
}
?>
<?php
/*
btnSimpanRujukUnit -> jalan ke jalan / inap ke jalan / jalan ke inap
//inap -> jalan ke inap
document.getElementById('lgnJudul').innerHTML di set 'MRS'
//non inap diset selainnya -> jalan ke jalan / inap ke jalan

btnSimpanKamar -> inap ke inap
//
*/
//session_start();
$spesialis = $_SESSION['spesialis'];
if(!isset($userId) || $userId == ''){
    header('location:../../index.php');
}
//echo $_SESSION['userId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
        <script type="text/javascript" src="../theme/js/tab-view.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
		<script type="text/JavaScript" language="JavaScript" src="../include/jquery/jquery-1.9.1.js"></script>
		<script type="text/JavaScript" language="JavaScript" src="../include/jquery/jquery.form.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="javascript" src="../loket/jquery.maskedinput.js"></script>
        <!--script src="../theme/dhtmlxcalendar.js" type="text/javascript"></script-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!--dibawah ini diperlukan untuk menampilkan menu dropdown-->
		<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
        <!--<script language="JavaScript" src="../theme/js/dropdown.js"></script>-->
        <?php include("dropdown.php"); ?>

		<link rel="stylesheet" type="text/css" href="jquery_multiselect/jquery.multiselect.css" />
		<link rel="stylesheet" type="text/css" href="jquery_multiselect/style.css" />

        <link rel="stylesheet" type="text/css" href="jquery_multiselect/jquery-ui.css" />
        <!--<script type="text/javascript" src="jquery_multiselect/jquery.js"></script>-->
        <script type="text/javascript" src="jquery_multiselect/jquery-ui.min.js"></script>
        <script type="text/javascript" src="jquery_multiselect/src/jquery.multiselect.js"></script>
		
        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
        <!--diatas ini diperlukan untuk menampilkan popup-->
        <style type="text/css" media="all">
			<!--
				td .head{ padding:5pt 0pt 5pt 15pt; text-decoration:underline; }
				td .isi{ padding:5pt 13pt 5pt 13pt; width:15; }
			-->
			/* DS Grid CSS */
			.GridLoading { display: none; float: left; position: absolute; background: rgba( 255, 255, 255, .8 ); }
			.GridLoading img { margin-top: 60px; margin-left: 430px; }
		</style>
        <script>
		
		
		
		
		var anamnesa_cor,anamnesa_pulmo,anamnesa_inspeksi,anamnesa_auskultasi,anamnesa_palpasi,anamnesa_perkusi,anamnesa_ekstremitas='';
		
		var mTab = '';
		var sRujuk = 0;
		function cekLab(a){
			//alert(a);
			
			if((a==57) && (jQuery("#cmbTmpLay").val()==58)){
				mTab.setTabCaption2("ANAMNESIS,DIAGNOSIS,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL LAB");
				document.getElementById('tab_laborat').style.display='block';
				document.getElementById('tab_radiologi').style.display='none';
				document.getElementById('tab_labPA').style.display='none';
				mTab.setTabCaptionWidth("0,0,180,180,0,180");
				mTab.setTabDisplay("false,false,true,true,false,true,2");
				
				//jQuery("#btnRujukUnit").hide();
				jQuery("#btnRujukRS").hide();
				jQuery("#btnIzin").hide();
				jQuery("#ctkVis").hide();
				//jQuery("#btnIsiDataRM").hide();
				jQuery("#ctkRad").hide();
				jQuery("#ctkAmpRad").hide();
				//-jQuery("#btnMutasi").hide();
				jQuery("#btnIsiDataRM12").hide();
				jQuery("#btnIsiDataRM13").hide();
				jQuery("#btnMRS").hide();
				jQuery("#sampel").show();
				jQuery("#sampel1").show();
				jQuery("#validasi").hide();
				
				var id1 = "<? echo $userId;?>";
				jQuery("#cmbDokHsl").val(id1);
				if(jQuery("#cmbDokHsl").val()==id1)
				{
					jQuery("#cmbDokHsl").attr("disabled","disabled");
				}else{
					jQuery("#cmbDokHsl").removeAttr("disabled");
				}
				
				//document.getElementById('trDiagnosaKlinis').style.display='none';
				/*
				mTab.setTabCaption2("DIAGNOSA,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL LAB");
				mTab.setTabDisplay("true,true,true,true,true,3");
				document.getElementById('tab_laborat').style.display='block';
				document.getElementById('tab_radiologi').style.display='none';
				*/
			}
			else if((a==57) && (jQuery("#cmbTmpLay").val()==59)){
				mTab.setTabCaption2("ANAMNESIS,DIAGNOSIS,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL LAB");
				document.getElementById('tab_laborat').style.display='none';
				document.getElementById('tab_radiologi').style.display='none';
				document.getElementById('tab_labPA').style.display='block';
				mTab.setTabCaptionWidth("0,0,180,180,0,180");
				mTab.setTabDisplay("false,false,true,true,false,true,2");
				
				//jQuery("#btnRujukUnit").hide();
				jQuery("#btnRujukRS").hide();
				jQuery("#btnIzin").hide();
				jQuery("#ctkVis").hide();
				//jQuery("#btnIsiDataRM").hide();
				jQuery("#ctkRad").hide();
				jQuery("#ctkAmpRad").hide();
				//-jQuery("#btnMutasi").hide();
				jQuery("#btnIsiDataRM12").hide();
				jQuery("#btnIsiDataRM13").hide();
				jQuery("#btnMRS").hide();
				jQuery("#sampel").show();
				jQuery("#sampel1").show();
				jQuery("#validasi").hide();
				
				var id1 = "<? echo $userId;?>";
				jQuery("#cmbDokLabPa").val(id1);
				if(jQuery("#cmbDokLabPa").val()==id1)
				{
					jQuery("#cmbDokLabPa").attr("disabled","disabled");
				}else{
					jQuery("#cmbDokLabPa").removeAttr("disabled");
				}
				
				//document.getElementById('trDiagnosaKlinis').style.display='none';
				/*
				mTab.setTabCaption2("DIAGNOSA,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL LAB");
				mTab.setTabDisplay("true,true,true,true,true,3");
				document.getElementById('tab_laborat').style.display='block';
				document.getElementById('tab_radiologi').style.display='none';
				*/
			}
			else if(a==60){	
				mTab.setTabCaption2("ANAMNESIS,DIAGNOSIS,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL RADIOLOGI");
				document.getElementById('tab_laborat').style.display='none';
				document.getElementById('tab_radiologi').style.display='block';
				document.getElementById('tab_labPA').style.display='none';
				mTab.setTabCaptionWidth("0,0,180,180,0,180");
				mTab.setTabDisplay("false,false,true,true,false,true,2");
				
				jQuery("#btnRujukUnit").show();
				jQuery("#btnRujukRS").show();
				jQuery("#btnIzin").show();
				jQuery("#ctkVis").show();
				//jQuery("#btnIsiDataRM").show();
				jQuery("#ctkRad").show();
				jQuery("#ctkAmpRad").show();
				jQuery("#btnIsiDataRM12").show();
				jQuery("#btnIsiDataRM13").show();
				jQuery("#btnMRS").hide();
				//-jQuery("#btnMutasi").hide();
				jQuery("#sampel").hide();
				jQuery("#sampel1").hide();
				jQuery("#validasi").hide();
				jQuery("#validasi").hide();
				jQuery("#validasi").hide();
				//-jQuery("#btnMutasi").hide();
				jQuery("#btnLab").hide();
				//jQuery("#btnIsiDataRM").hide();
				jQuery("#ctkLab").hide();
				jQuery("#btnIzin").hide();
				
				//jQuery("#btnCCekOut").hide();
				
				var id1 = "<? echo $userId;?>";
				jQuery("#cmbDokHslRad").val(id1);
				if(jQuery("#cmbDokHslRad").val()==id1)
				{
					jQuery("#cmbDokHslRad").attr("disabled","disabled");
				}else{
					jQuery("#cmbDokHslRad").removeAttr("disabled");
				}
				
				jQuery("#workList").show();
				
				//document.getElementById('trDiagnosaKlinis').style.display='table-row';
				/*
				mTab.setTabCaption2("DIAGNOSA,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL RADIOLOGI");
				mTab.setTabDisplay("true,true,true,true,true,3");
				document.getElementById('tab_radiologi').style.display='block';
				document.getElementById('tab_laborat').style.display='none';
				*/
			}else if(a==129){	
				mTab.setTabCaption2("ANAMNESIS,DIAGNOSIS,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL LAB");
				document.getElementById('tab_laborat').style.display='block';
				document.getElementById('tab_radiologi').style.display='none';
				document.getElementById('tab_labPA').style.display='none';
				mTab.setTabCaptionWidth("0,0,180,0,0,0");
				mTab.setTabDisplay("false,false,true,false,false,false,2");
				
				//jQuery("#btnRujukUnit").hide();
				jQuery("#btnRujukRS").hide();
				jQuery("#btnIzin").hide();
				jQuery("#ctkVis").hide();
				//jQuery("#btnIsiDataRM").hide();
				jQuery("#ctkRad").hide();
				jQuery("#ctkAmpRad").hide();
				//-jQuery("#btnMutasi").hide();
				jQuery("#btnIsiDataRM12").hide();
				jQuery("#btnIsiDataRM13").hide();
				jQuery("#btnMRS").hide();
				jQuery("#sampel").show();
				jQuery("#sampel1").show();
				jQuery("#validasi").hide();
				
				var id1 = "<? echo $userId;?>";
				jQuery("#cmbDokHsl").val(id1);
				if(jQuery("#cmbDokHsl").val()==id1)
				{
					jQuery("#cmbDokHsl").attr("disabled","disabled");
				}else{
					jQuery("#cmbDokHsl").removeAttr("disabled");
				}
			}else{
				if(document.getElementById("cmbJnsLay").value != 44 && document.getElementById("cmbJnsLay").value != 27 && document.getElementById("cmbJnsLay").value != 68 && document.getElementById("cmbJnsLay").value != 94 && document.getElementById("cmbJnsLay").value != 62)
				{
					mTab.setTabCaption2("ANAMNESIS,DIAGNOSIS,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL LAB");
					mTab.setTabCaptionWidth("180,180,180,180,180,0");
					//mTab.setTabCaption2("DIAGNOSA,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL LAB");
					mTab.setTabDisplay("true,true,true,true,true,false,0");
					//jQuery("#soap1").hide();
					//jQuery("#anam").show();
					document.getElementById('soap1').style.display='none';
					document.getElementById('anam').style.display='block';
				}else{
					mTab.setTabCaption2("SOAPIER,DIAGNOSIS,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL LAB");
					mTab.setTabCaptionWidth("180,180,180,180,180,0");
					mTab.setTabDisplay("true,true,true,true,true,false,0");
					//jQuery("#soap1").show();
					//jQuery("#anam").hide();
					document.getElementById('soap1').style.display='block';
					document.getElementById('anam').style.display='none';
				}
				//mTab.setTabPage("diagnosa.php,tindakan.php,resep.php,pemakaian_bhp.php,laborat_radiologi.php");
				document.getElementById('tab_laborat').style.display='none';
				document.getElementById('tab_radiologi').style.display='none';
				document.getElementById('tab_labPA').style.display='none';
				
				jQuery("#btnRujukUnit").show();
				jQuery("#btnRujukRS").show();
				jQuery("#btnIzin").show();
				jQuery("#ctkVis").show();
				//jQuery("#btnIsiDataRM").show();
				jQuery("#ctkRad").show();
				jQuery("#ctkAmpRad").show();
				jQuery("#btnIsiDataRM12").show();
				jQuery("#btnIsiDataRM13").show();
				//-jQuery("#btnMutasi").show();
				jQuery("#btnLab").show();
				//jQuery("#btnIsiDataRM").show();
				jQuery("#ctkLab").show();
				jQuery("#btnIzin").show();
				//jQuery("#btnMutasi").show();
				jQuery("#workList").hide();
				jQuery("#sampel").hide();
				jQuery("#sampel1").hide();
				jQuery("#validasi").hide();
				//document.getElementById('trDiagnosaKlinis').style.display='none';
			}
			//alert(document.getElementById('trDiagnosaKlinis').style.display);
			
			//alert('anam='+document.getElementById('anam').style.display);
			//alert('soap='+document.getElementById('soap1').style.display);
			
			cekLockRM();
		}
		
		function cekPenunjang(a){
			// alert(a);
			if(a==57 || a==66 || a==60 || a==61 || a==65 || a==46 || a==58 || a==59){
				//mTab.setTabCaption2("TINDAKAN,PEMAKAIAN BHP,HASIL LAB,DIAGNOSA,RESEP");
				//mTab.setTabPage("tindakan.php,pemakaian_bhp.php,laborat_radiologi.php?hsl=lab,diagnosa.php,resep.php");
				//mTab.setTabDisplay("true,true,true,false,false,3");
				//alert("");
				jQuery(".diag1").hide();
				//jQuery(".resep1").hide();
				jQuery("#btnMRS").hide();
			}else{
				jQuery(".diag1").show();
				//jQuery(".resep1").show();
				//jQuery(".resep1").show();
			}
		}
		
		function cekSpesialis1(a){
			// alert(a);
			// if(a==129){
				//mTab.setTabCaption2("TINDAKAN,PEMAKAIAN BHP,HASIL LAB,DIAGNOSA,RESEP");
				//mTab.setTabPage("tindakan.php,pemakaian_bhp.php,laborat_radiologi.php?hsl=lab,diagnosa.php,resep.php");
				//mTab.setTabDisplay("true,true,true,false,false,3");
				//alert("");
				// jQuery(".diag1").hide();
				//jQuery(".resep1").hide();
			// }else{
				jQuery(".diag1").show();
				//jQuery(".resep1").show();
			// }
		}
	
	/*auto Height iframe by ridl00*/ 	
	function resizeIframe(obj) {
		jQuery("#popup_iframe").height(450);
	var a = obj.contentWindow.document.body.scrollHeight
		//a+=30;
    	obj.style.height = a + 'px';
		if(a<heightOvr){
			document.getElementById('popup_overlay').style.height=(heightOvr+100)+'px';
		}else if(a != 0){
			document.getElementById('popup_overlay').style.height=(a+100)+'px';
		}
  	}
	
	var heightOvr=0;	
	function loadHeight(){
		heightOvr=document.body.scrollHeight;
	}
	
	function alertsize(pixels){
    pixels+=10;
	jQuery(".framex").animate({height:pixels+"px"},'slow');
	if(pixels<heightOvr){
			window.scrollTo(0,0);
		}else{
			document.getElementById('popup_overlay').style.height=(pixels+100)+'px';		
		}
	}
	function resizeAwal() {
		jQuery("#div_popup_iframe").height();
		jQuery("#popup_iframe").height(430);
		//jQuery("#popup_iframe").css({ height: heightOvr + "px"});
		//document.getElementById('popup_iframe').style.height = a + 'px';
		cekKonsen();
	}
	
	/*fucntion cekAwal1()
	{
		cekLab(document.getElementById("cmbJnsLay").value);
		cekInap(document.getElementById("cmbJnsLay").options[document.getElementById("cmbJnsLay")..options.selectedIndex].lang);
		isiCombo('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+document.getElementById("cmbJnsLay")..value,'','cmbTmpLay',evLang2);
		cekPenunjang(document.getElementById("cmbJnsLay").value);
	}*/
	/*end*/
		</script>
        
        <title>Pelayanan Kunjungan</title>
    </head>
	
	

    <body onload="setJam();loadUlang();cekSentPar();loadHeight();">
    <span id="spnTab0" style="display:none"></span>
    <span id="spnTab1" style="display:none"></span>
    <span id="spnTab2" style="display:none"></span>
    <span id="spnTab3" style="display:none"></span>
    <span id="spnTab4" style="display:none"></span>
    <span id="HslSpInap" style="display:none"></span>
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
        <iframe height="72" width="130" name="sort"
                id="sort"
                src="../theme/dsgrid_sort.php" scrolling="no"
                frameborder="0"
                style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
        <div id="popGrPet" style="display:none; width:600px;height:auto" class="popup">
<div id="divobat_edit" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
        <table width="590" align="center" cellpadding="3" cellspacing="0">
        <tr>
            <td colspan="2" class="font" align="center">&nbsp;</td>
        </tr>
        <tr id="trObat">
            <td class="font">Nama Obat</td>
            <td>:&nbsp;<input type="text" id="newObat" size="65" onKeyUp="suggestObat2(event,this);" autocomplete="off" /></td>
        </tr>
        <tr id="trFarmasi" style="visibility:collapse">
            <td class="font">Unit</td>
            <td>:&nbsp;<select id="IdFarmasiRujuk">
            	<?php 
				$sql="SELECT * FROM a_unit WHERE UNIT_TIPE=2 AND UNIT_ID<>$idunit AND UNIT_ISAKTIF=1";
				$rs=mysql_query($sql);
				while ($rw=mysql_fetch_array($rs)){
				?>
            	<option value="<?php echo $rw['UNIT_ID']; ?>"><?php echo $rw['UNIT_NAME']; ?></option>
                <?php 
				}
				?>
            </select></td>
        </tr>
        <tr id="trCaraBayar" style="visibility:collapse;">
            <td class="font">Cara Bayar</td>
            <td>:&nbsp;<select id="IdCaraBayar">
            	<?php 
				$sql="SELECT * FROM a_cara_bayar WHERE aktif=1";
				$rs=mysql_query($sql);
				while ($rw=mysql_fetch_array($rs)){
				?>
            	<option value="<?php echo $rw['id']; ?>"><?php echo $rw['nama']; ?></option>
                <?php 
				}
				?>
            </select></td>
        </tr>
        <tr>
            <td colspan="2" align="center" height="50" valign="bottom"><button id="sim" name="sim" value="simpan" type="button" style="cursor:pointer" class="popup_closebox" onClick="SimpanNewObat()"><img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan</button>  <button type="button" id="batal" name="batal" class="popup_closebox" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button></td>
        </tr>
        </table>
</div>
<input name="fdata" id="fdata" type="hidden" value=""/>
        <input name="smeninggal" id="smeninggal" type="hidden" value=""/>
        <div id="divKunj" align="center" style="display:block;">
            <?php
            include("../koneksi/konek.php");
            include("../header1.php");
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            $time_now=gmdate('H:i:s',mktime(date('H')+7));
            $tglGet=$_REQUEST['tgl'];
			$bl=date('m');
			$th=date('Y');
			$q1="SELECT no_minta FROM ".$dbbank_darah.".bd_permintaan_unit WHERE no_minta LIKE 'BD/MT/$th-$bl/%' ORDER BY no_minta DESC LIMIT 1";
			//echo $q1."<br>";
			$rs1=mysql_query($q1);
			if ($rows1=mysql_fetch_array($rs1)){
				$no_minta=$rows1["0"];
				$ctmp=explode("/",$no_minta);
				$dtmp=$ctmp[3]+1;
				$ctmp=$dtmp;
				for ($i=0;$i<(5-strlen($dtmp));$i++) $ctmp="0".$ctmp;
				$no_pakai="BD/MT/$th-$bl/$ctmp";
			}else{
				$no_pakai="BD/MT/$th-$bl/00001";
			}
            ?>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#008484"  class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM PELAYANAN KUNJUNGAN</td>
					<?php 
					$qAkses = "SELECT DISTINCT ms_menu_id,mm.nama,mm.url FROM b_ms_group_petugas gp INNER JOIN b_ms_group_akses mga ON gp.ms_group_id = mga.ms_group_id INNER JOIN b_ms_menu mm ON mga.ms_menu_id=mm.id WHERE gp.ms_pegawai_id=$userId AND mga.ms_menu_id IN (37,39,42)";
					$rsAkses = mysql_query($qAkses);
					if(mysql_num_rows($rsAkses)>1){
					?>
					<td align="right">
						<select name="cmbLink" id="cmbLink" onchange="location=this.value" class="txtinputreg">
							<option>-- PILIH --</option>
							<?php while($rwMenu = mysql_fetch_array($rsAkses)){?>
							<option value="<?php echo '../'.$rwMenu['url']?>"><?php echo $rwMenu['nama']?></option>
							<?php } ?>
						</select>&nbsp;&nbsp;&nbsp;
					</td>
					<?php }?>
                </tr>
            </table>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" align="center" class="tabel">
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="45%">&nbsp;</td>
                    <td width="45%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <fieldset>
                            <table width="90%" align="center">
                                <tr id="trTgl">
                                    <td height="30">Tanggal</td>
                                    <td align="center">:</td>
                                    <td>
                                        <input id="txtTgl" name="txtTgl" readonly size="11" class="txtcenter" type="text" value="<?php if($tglGet=='') {
                                            echo $date_now;
                                        }
                                        else {
                                            echo $tglGet;
                                        }
                                        ?>" />&nbsp;<input type="button" name="btnTgl" id="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange,saring);"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jenis Layanan</td>
                                    <td>:</td>
                                    <td>
                                        <select id="cmbJnsLay" class="txtinput" onchange="cekLab(this.value);cekInap(this.options[this.options.selectedIndex].lang);isiCombo('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+this.value,'','cmbTmpLay',evLang2);cekPenunjang(this.value);tampilKet(this.value);" >
                                            <?php
                                            $sql="SELECT distinct m.id,m.nama,m.inap FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
                                                    where ms_pegawai_id=".$_SESSION['userId'].") as t1
                                                    inner join b_ms_unit u on t1.unit_id=u.id
                                                    inner join b_ms_unit m on u.parent_id=m.id WHERE m.kategori=2 order by nama";
													
                                            $rs=mysql_query($sql);
                                            while($rw=mysql_fetch_array($rs)) {
                                                ?>
                                            <option value="<?php echo $rw['id'];?>" lang="<?php echo $rw['inap'];?>" ><?php echo $rw['nama'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tempat Layanan</td>
                                    <td>:</td>
                                    <td>
                                        <select id="cmbTmpLay" class="txtinput" lang="" onchange="this.lang=this.value;evLang2();" style="width:250px;">
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                    <td align="center">
                        <table>
                            <tr>
                                <td>
                                    <input type="button" id="dtlPas" name="dtlPas" value="Detail Pelayanan Pasien" class="tblBtn" disabled="disabled" onclick="detail();" style="width:250px;height:40px;"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <button id="updtPas" name="updtPas" class="tblBtn" disabled="disabled" onclick="updatePas();" style="width:250px;height:40px;">
                                        Update Status Pasien<br />>> Sudah Dilayani
                                    </button>
                                </td>
                            </tr>
                            <tr id="trKonsulDokter" style="display:none">
                                <td>
                                    <input type="button" id="btListKonDok" name="btListKonDok" value="Daftar Konsul Dokter" class="tblBtn" onclick="ListKonsulDokter()" style="width:250px;height:40px;"/>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">
                        <fieldset>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                <tr id="trDilayani">
                                    <td align="left">
                                        Status dilayani :
                                        <select id="cmbDilayani" onchange="saring();" class="txtinput">
                                            <option value="0" selected="selected">BELUM</option>
                                            <option value="1">SUDAH</option>
                                            <option value="2">BATAL BERKUNJUNG</option>
                                            <option value="">SEMUA</option>
                                        </select>&nbsp;
                                        <span id="spnCmbDokterUnit">Dokter :
                                        <select id="cmbDokterUnit" onchange="saring2();" class="txtinput" style="width:150px">
                                         
                                        </select></span>&nbsp;
					<span style="padding-left:20px">
					No. RM :
					<input id="txtFilter" name="txtFilter" size="10" class="txtcenter" onkeyup="filterNoRM(event,this)" onfocus="fSetFocus(this);" />
					<!--input id="txtFilter" name="txtFilter" size="10" class="txtcenter" onkeyup="filter(event,this)" /-->
					<input id="btnFilter" name="btnFilter" type="button" class="tblBtn" value="Find" style="display:none" onclick="filter(event,this)" />
					</span>
				    </td>
				</tr>
                                <tr>
                                    <td align="left">
                                        <div id="gridbox" style="width:925px; height:270px; background-color:white; overflow:hidden;">
                                        	<div id="gridbox-loading" class="GridLoading"><img src="../icon/loading3.gif" /></div>
                                        </div>
                                        <div id="paging" style="width:925px;"></div>
                                    <div id="divketerangan" style="display:none">
                                    <small>
                                    <table width="300" border="0">
                                      <tr>
                                        <td colspan="4">Keterangan :</td>
                                      </tr>
                                      <tr>
                                        <td bgcolor="#0000FF" width="5%">&nbsp;</td>
                                        <td>Approve 3</td>
                                        <td bgcolor="#000000" width="5%">&nbsp;</td>
                                        <td>Belum di Approve</td>
                                      </tr>
                                    </table>
                                    </small>
                                    </div>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td bordercolor="#FF3300" style="font-weight:bold;">
				<!--	
					<div id="a_lab" style="display:none; color:#FF3300">
					<marquee behavior="alternate" direction="left">
					<?php 
					//$t = $_REQUEST['txtTgl'];
					echo $sql="SELECT CONCAT(COUNT(dilayani), ' Kunjungan Belum Dilayani') jumlah FROM b_pelayanan WHERE dilayani=0 AND unit_id=58 /*AND  DATE_FORMAT(tgl,'%d-%m-%Y')='$t' */ "; 
					$sql1=mysql_query($sql);
					$rows=mysql_fetch_array($sql1);
					echo $jumlah=$rows['jumlah'];
					
					
					
					?>
					</marquee>
					</div>-->

					</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>

	<!-- rerep -->
	<div id="divResep" style="display:none; width: 900px;" class="popup">
	    <fieldset>
		<legend style="font-size: 14px; font-weight: bold;">Form Tambah Resep</legend>
		<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="tutupPopResep();" style="float:right; cursor: pointer" />
		<table width="850" border="0" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td width="2%">&nbsp;</td>
			<td width="13%">&nbsp;</td>
			<td width="80%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
		</tr>
		<tr id="trNoResep" style="visibility:collapse">
			<td>&nbsp;</td>
			<td align="right">No Resep</td>
			<td>&nbsp;<input id="noResep" name="noResep" size="12" class="txtinput" disabled="disabled" /><input type="hidden" id="tglResep" name="tglResep" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr id="trTglResep">
			<td>&nbsp;</td>
			<td align="right">Tgl Resep</td>
			<td>
				&nbsp;<input name="tglResepB" type="text" id="tglResepB" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tglSekarangg?>" /> 
				<input type="button" name="btnTgl" id="btnTgl" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tglResepB'),depRange,tidak);" />			</td>
			<td>&nbsp;</td>
		</tr>
        <tr>
			<td>&nbsp;</td>
			<td align="right">Diagnosa&nbsp;</td>
			<td>&nbsp;<select id="cmbDiagR" name="cmbDiagR" class="txtinput"></select></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">Apotek&nbsp;</td>
			<td>&nbsp;<select id="cmbApotek" name="cmbApotek" onchange="suggestObat(event,document.getElementById('txtNmObat'))" class="txtinput"><option></option></select>
            <label><input type="checkbox" id="chkIter" value="1" onclick="fKlikChkIter(this)"/>Iter Resep</label>&nbsp;<input id="txtJmlIter" name="txtJmlIter" size="3" class="txtcenter" style="display:none">            </td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right" valign="middle">Nama Obat&nbsp;</td>
			<td>&nbsp;<input id="txtNmObat" name="txtNmObat" size="60" class="txtinput" onKeyUp="suggestObat(event,this);" autocomplete="off">
            <div id="divobat" align="left" style="position:absolute; z-index:1; height: 230px; width:400px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>
            <textarea id="txtAreaNmObat" name="txtAreaNmObat" cols="60" rows="3" style="display:none;"></textarea><input id="idObat" name="idObat" type="hidden" /><input id="hargajual" name="hargajual" type="hidden" /><input id="hargabeli" name="hargabeli" type="hidden" />&nbsp;<!--joker-->
			<a id="obatBill" href="javascript:divobat.style.display='none'; OpenWnd('../../apotek/transaksi/list_obat_bill.php?idunit='+cmbApotek.value+'&kepemilikan='+getKepemilikan,800,500,'msma',true);">List Obat</a>
			<br />
			<label><input type="checkbox" id="chkObatManual" value="0" onclick="fKlikChkObatManual(this)"/>Manual</label></td>
		  <td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">Racikan&nbsp;</td>
			<td><input type="checkbox" id="chRacikan" name="chRacikan" class="txtinput" onclick="CekRacikan(this);"></td>
			<td>&nbsp;</td>
		</tr>
        <tr>
			<td>&nbsp;</td>
			<td align="right">DTD&nbsp;</td>
			<td><input type="checkbox" id="chDtd" name="chDtd" class="txtinput" onclick=""></td>
			<td>&nbsp;</td>
		</tr>
		<tr id="trRacikan" style="visibility:collapse">
			<td>&nbsp;</td>
			<td align="right">Racikan ke-&nbsp;</td>
			<td>&nbsp;<select id="noRacikan" name="noRacikan" class="txtinput">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            	</select>			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">Jumlah&nbsp;</td>
			<td>&nbsp;<input id="txtJml" name="txtJml" size="3" class="txtcenter">&nbsp;
                <!--label><input type="checkbox" id="chRacikan" name="chRacikan" class="txtinput" onclick="CekRacikan(this);"> Racikan</label-->			
                &nbsp;
            <span id="bobatN" style="display:none;">
            	Bentuk Racikan :
            <select id="bobat1" name="bobat1" class="txtinput">
            <?
				$query12 = "select * from b_ms_bobat";
				$exec12 = mysql_query($query12);
				while($dquery12 = mysql_fetch_array($exec12))
				{
					?>
                    	<option id="<? echo $dquery12['id']."ben";?>" value="<? echo $dquery12['id'];?>"><? echo $dquery12['nama'];?></option>
                    <?
				}
            ?>
            </select>
            </span>          </td>
			<td>&nbsp;</td>
		</tr>
		<tr id="trJmlBahan" style="visibility:collapse">
			<td>&nbsp;</td>
			<td align="right">Jumlah Bahan&nbsp;</td>
			<td>&nbsp;<input id="txtJmlBahan" name="txtJmlBahan" size="3" class="txtcenter">&nbsp;
				<select id="satuanRacikan" name="satuanRacikan" class="txtinput" style="visibility:hidden">
                <?php 
				$sql="SELECT * FROM $dbapotek.a_satuan_racikan WHERE aktif=1";
				$rs=mysql_query($sql);
				while ($rw=mysql_fetch_array($rs)){
				?>
                <option value="<?php echo $rw['nama']; ?>"><?php echo $rw['nama']; ?></option>
                <?php 
				}
				?>
            	</select>&nbsp;
                <!--label><input type="checkbox" id="chRacikan" name="chRacikan" class="txtinput" onclick="CekRacikan(this);"> Racikan</label-->			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">Ket Dosis&nbsp;</td>
			<td>&nbsp;<span id="spnKetDosis"><select id="txtDosis" name="txtDosis" class="txtinput">
                <?php 
				$sql="SELECT * FROM $dbapotek.a_dosis WHERE aktif=1";
				$rs=mysql_query($sql);
				while ($rw=mysql_fetch_array($rs)){
				?>
                <option value="<?php echo $rw['nama']; ?>"><?php echo $rw['nama']; ?></option>
                <?php 
				}
				?>
            	</select></span>&nbsp;<input type="checkbox" id="yeah" class="txtinput" onchange="gantiDosis(this);" style="cursor:pointer" />&nbsp;Lainnya            </td>
			<td>&nbsp;</td>
		</tr>
        <tr>
			<td>&nbsp;</td>
			<td align="right">Digunakan Selama (hari) :&nbsp;</td>
			<td>&nbsp;<input id="txtJmlHari" name="txtJmlHari" size="3" class="txtcenter"></td>
			<td>&nbsp;</td>
		</tr>
		<!--<tr>
			<td>&nbsp;</td>
			<td align="right">Ket Dosis&nbsp;</td>
			<td>&nbsp;<input id="txtDosis" name="txtDosis" size="30" class="txtinput"></td>
			<td>&nbsp;</td>
		</tr>-->
		<tr>
			<td>&nbsp;</td>
			<td align="right">Dokter&nbsp;</td>
			<td>&nbsp;<select id="cmbDokResep" name="cmbDokResep" class="txtinput" onkeypress="setDok('btnSimpanResep',event);" onchange="setSemDokter(this.value);">
					<option value="">-Dokter-</option>
				</select>
		<label><input type="checkbox" id="chkDokterPenggantiResep" value="1" onchange="gantiDokter('cmbDokResep',this.checked);"/>Dokter Pengganti</label>		</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="padding:10px;">&nbsp;<input id="idResep" name="idResep" type="hidden">
				<input id="txtStok" name="txtStok" type="hidden">
				<input type="button" id="btnSimpanResep" name="btnSimpanResep" value="Tambah" onclick="simpan(this.value,this.id,'txtNmObat');" class="tblTambah"/>
				<input type="button" id="btnHapusResep" name="btnHapusResep" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
				<input type="button" id="btnBatalResep" name="btnBatalResep" value="Batal" onclick="batal(this.id)" class="tblBatal"/></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="2" align="center">
				<div id="gridboxResep" style="width:850px; height:150px; background-color:white;"></div>
				<br>
				<div id="pagingResep" style="width:850px;"></div>			</td>
			<td>&nbsp;</td>
		</tr>
		</table>
	    </fieldset>
	</div>
	<!-- resep -->

  <div id="divTarikRujuk" style="display:none; width: 950px;" class="popup">
	    <fieldset>
		<legend style="font-size: 14px; font-weight: bold;">Form Ambil Pasien</legend>
		<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="batal('btnBatalTarikRujuk')" style="float:right; cursor: pointer" />
		<table>
		    <tr>
			<td valign="bottom" height="28">
			    Jenis Layanan			</td>
			<td id="tdJns" height=30 valign="bottom">			</td>
			<td rowspan="2">
			    <table id="div_ifinap" style="display:none">
				<tr>
				    <td align="right">Kelas :</td>
				    <td><select name="cmbKelas" id="cmbKelas_ifinap" tabindex="28" class="txtinput" onchange="isiPindahKamar();"></select></td>
				</tr>
				<tr>
				    <td width="162" align="right">Kamar :</td>
				    <td >
					<select name="cmbKamar" id="cmbKamar_ifinap" tabindex="26" class="txtinput" onchange=""></select>
					<span id="spanTarifPindah_ifinap" ></span>				    </td>
				</tr>
				<tr id="trpindah1">
				    <td align="right">Tanggal Masuk :</td>
				    <td>
					<input type="text" class="txtcenter" readonly="readonly" name="TglMasuk" id="TglMasuk_ifinap" size="11" value="<?php echo $date_now;?>"/>
					<input type="button" class="btninput" id="btnTglMasuk_ifinap" name="btnTglMasuk" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('TglMasuk_ifinap'),depRange,fungsikosong);" />				    </td>
				</tr>
				<tr id="trpindah2">
				    <td align="right">Jam Masuk :</td>
				    <td>
					<input type="text" class="txtcenter" readonly="readonly" name="JamMasuk" id="JamMasuk_ifinap" size="5" maxlength="5" value=""/>
					<label><input type="checkbox" id="chkManual_ifinap" name="chkManual" onclick="setManual('ifinap')"/>set manual</label>				    </td>
				</tr>
			    </table>			</td>
		    </tr>
		    <tr>
			<td valign="top" height="28">
			    Tempat Layanan			</td>
			<td valign="top" id="tdTmp"></td>
		    </tr>
		</table>
		<input type="button" class="tblBtn" onclick="getPas()" value="Rujuk Pasien ke Unit Ini" />
		<input type="hidden" id="act_tarik" />
		<span id="spanTar1" style="display:none"></span>
		<div id="gridbox_tarik" style="width:925px; height:270px; background-color:white; overflow:hidden;"></div>
		<div id="paging_tarik" style="width:925px;"></div>
	    </fieldset>
	</div>
		
<div id="div_popup_iframe" style="display:none;width:1200px" class="popup">
			<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; display:none; cursor: pointer" />
			<img alt="close" src="../icon/x.png" width="32" onclick="document.getElementById('div_popup_iframe').popup.hide();resizeAwal();" style="float:right; cursor: pointer" />
			<fieldset>
				<legend id="legend_popup_iframe"></legend>
				<iframe id="popup_iframe" class="framex" src="" onload="javascript:resizeIframe(this);" style="width:100%; height:400px; border:none;" ></iframe>
			</fieldset>
	</div>
        
<div id="div_popup_tind" style="display:none;width:980px" align="center" class="popup">
<!--<div id="tindak1" style="display:none"></div>-->
<div id="cek"><img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" /></div>
<?php //include("tindak.php"); ?>
<div id="divtind" align="center" style="position:absolute; z-index:1; width:1000; overflow: scroll; border:1px solid; background-color: #CCCCCC;"></div>
</div>
		
       <div id="divListKonsulDokter" style="display:none;width:700px" class="popup">
       <span id="spnHasilKonDok" style="display:none"></span>
       <span id="spnCekKonDok" style="display:none"></span>
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
                <fieldset><legend>DAFTAR KONSUL DOKTER</legend>
                    <table border=0>
                        <tr>
                        	<td>&nbsp;Status dilayani : <select id="cmbStatusKonDok" name="cmbStatusKonDok" onchange="viewListKonsulDokter()">
                            	<option value="0">BELUM</option>
                                <option value="1">SUDAH</option>
                                <option value="2">SEMUA</option>
                            </select>                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <div id="gridboxListKonDok" style="width:650px; height:250px; padding-bottom:10px; background-color:white;"></div>
                                <br />
                                <div id="pagingListKonDok" style="width:650px;"></div>                            </td>
                        </tr>
                    </table>
                </fieldset>
    </div> 
        
<!--div detil pelayanan-->
      <div id="divDetil" align="center" style="display:none;">
        <?php include("hasil_pemeriksaan/view_hasil.php");?>
            <div id="divRujukUnit" style="display:none;width:700px" class="popup">
          
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="batal('btnBatalRujukUnit')" style="float:right; cursor: pointer" />
                <fieldset><legend id="lgnJudul"></legend>
                    <table border=0>
                        <tr>
                            <td width="162" align="right">Jenis Layanan :</td>
                            <td >
                                <select id="JnsLayanan" class="txtinput" onchange="cekRujukInap(this.options[this.options.selectedIndex].lang);if (document.getElementById('lgnJudul').innerHTML=='MRS'){isiCombo('TmpLayananInapSaja',this.value,'','TmpLayanan',isiKelas);}else{isiTmpLayananKonsul();}"></select>                            </td>
                        </tr>
                        <tr>
                            <td align="right">Tempat Layanan :</td>
                            <td><select name="TmpLayanan" id="TmpLayanan" tabindex="27" class="txtinput"  onchange="isiKelas();"></select></td>
                        </tr>
						<tr id="trTindakanLab" style='display:none;'>
							<td align="right">Pemeriksaan Lab :</td>
							<td>
								<span class="tblBtn" style="padding:3px;" onclick="load_popup_iframe_TindLab('PEMERIKSAAN LAB','tindakanLab/index.php','tidak')">
									<label for="imgTL" style="vertical-align:middle;">Pemeriksaan</label>
									<img id="imgTL" src="../icon/ok.png" alt="" width="16" height="16" style="vertical-align:middle;" />								</span>							</td>
						</tr>
                        <tr id="trTindakanRad" style='display:none;'>
							<td align="right">Pemeriksaan Radiologi :</td>
							<td>
                            	<input type="hidden" id="keyTindRad" name="keyTindRad" />
								<span class="tblBtn" style="padding:3px;" onclick="load_popup_iframe_TindLab('TINDAKAN RADIOLOGI','tindakanRad/index.php','tidak')">
									<label for="imgTR" style="vertical-align:middle;">Tindakan</label>
									<img id="imgTR" src="../icon/ok.png" alt="" width="16" height="16" style="vertical-align:middle;" />								</span>							</td>
						</tr>
                        <tr id="trMintaDarah" style='display:none;'>
							<td align="right">Permintaan Darah :</td>
							<td>
								<span class="tblBtn" style="padding:3px;" onclick="isiMintaDarah()">
									<label for="imgBD" style="vertical-align:middle;">List Darah</label>
									<img id="imgTR" src="../icon/ok.png" alt="" width="16" height="16" style="vertical-align:middle;" />								</span>							</td>
						</tr>
                        <tr id="trKelasRujuk">
                            <td align="right">Kelas :</td>
                            <td><select name="cmbKelasRujuk" id="cmbKelasRujuk" tabindex="28" class="txtinput" onchange="isiKamar();"></select></td>
                        </tr>
                        <tr id="trKamarRujuk" style="display:none">
                            <td align="right">Kamar :</td>
                            <td>
                                <select name="cmbKamarRujuk" id="cmbKamarRujuk" tabindex="29" class="txtinput"></select>
                                <span id="spanTarif" ></span>                            </td>
                        </tr>
                         <tr id="trTglRujuk">
                            <td align="right">Tanggal Rujuk :</td>
                            <td>
                            <input id="txtTglK" name="txtTglK" readonly size="11" class="txtcenter" type="text" value="<?php if($tglGet=='') {
                                            echo $date_now;
                                        }
                                        else {
                                            echo $tglGet;
                                        }
                                        ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onclick="gfPop.fPopCalendar(document.getElementById('txtTglK'),depRange,cekKonsul);"/>                            </td>
                        </tr>
                        <tr>
                            <td align="right">Keterangan Rujuk :</td>
                            <td><textarea id="txtKetRujuk" name="txtKetRujuk" cols="35" rows="2" class="txtinput"></textarea></td>
                        </tr>
                        <tr>
                            <td align="right">Dokter Perujuk :</td>
                            <td>
                                <select id="cmbDokRujukUnit" name="cmbDokRujukUnit" class="txtinput" onchange="">
                                    <option value="">-Dokter-</option>
                                </select>
                                <label><input type="checkbox" id="chkDokterPenggantiRujukUnit" value="1" onchange="gantiDokter('cmbDokRujukUnit',this.checked);"/>Dokter Pengganti</label>                            </td>
                        </tr>
                        <tr id="trDokTujuanUnit" style="">
                            <td align="right">Dokter Tujuan :</td>
                            <td>
                                <select id="cmbDokTujuanUnit" name="cmbDokTujuanUnit" class="txtinput" onchange="">
                                    <option value="">-Dokter-</option>
                                </select>
                                <label><input type="checkbox" id="chkDokterPenggantiTujuanUnit" value="1" onchange="gantiDokterTujuan('cmbDokTujuanUnit',this.checked);"/>Dokter Pengganti</label>                            </td>
                        </tr>
						<tr id="pnlCTOTujuanUnit" style="visibility: hidden;">
                            <td id="tdSpemeriksaan" align="right" style="color:#FF3300;font-weight:bold;">Status Pemeriksaan :</td>
                            <td>
								<select id="chkCTOTujuanUnit" name="chkCTOTujuanUnit" class="txtinput" onchange="">
									<option value="0">-</option>
									<option value="1">Cito</option>
									<option value="2">Elektif</option>
									<option value="3">Serial</option>
									<!--option value="4">Pasien Kalangan Sendiri Dengan Code</option-->
								</select>
								<!--input type="checkbox" id="chkCTOTujuanUnit" value="1"/-->
							</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
								<input type="hidden" id="keyTindLab" name="keyTindLab" />
                                <input type="hidden" id="idRujukUnit" name="idRujukUnit"/>
                                <input type="button" id="btnSimpanRujukUnit" name="btnSimpanRujukUnit" value="Tambah" onclick="simpan(this.value,this.id);" class="tblTambah"/>
                                <input type="button" id="btnHapusRujukUnit" name="btnHapusRujukUnit" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
				<input type="button" id="btnBatalRujukUnit" value="Batal" onclick="batal(this.id)" class="tblBtn" />
                                <input type="button" id="btnSpInap" name="btnSpInap" value="SURAT PERINTAH INAP" class="tblBtn" onclick="spInap()" />
                                <input id="cetak" name="cetak" type="button" value="DATA PASIEN MRS" onClick="cetak()" class="tblBtn" />
                                <input type="button" id="prmhnk" value="PRMHNN KONSUL" onClick="cetak_rm('../report_rm/Form_RSU/2.permohonankonsultasi.php')" class="tblBtn" />
								<input id="cAntrian" name="cAntrian" type="button" value="CETAK ANTRIAN" onClick="cetakAntrian()" class="tblBtn" />
                                <input type="button" id="ctkLabRadPerKonsul" name="ctkLabRadPerKonsul" value="CETAK HASIL LAB" onclick="viewListKonsul(57);" class="tblBtn"/><!--etakHslLabRad();-->
                                <input type="button" id="cetak_rujuk" name="cetak_rujuk" value="CETAK RUJUK" onclick="RujukLabRad();" class="tblBtn"/>                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div id="gridboxRujukUnit" style="width:650px; height:250px; padding-bottom:10px; background-color:white;"></div>
                                <div id="pagingRujukUnit" style="width:650px;"></div>                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
            
            <div id="divKonsulDokter" style="display:none;width:700px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="batal('btnBatalKonDok')" style="float:right; cursor: pointer" />
                <fieldset><legend>KONSUL DOKTER SPESIALIS</legend>
                    <table border=0>
                        <tr>
                            <td width="162" align="right">Jenis Layanan :</td>
                            <td><select id="JnsLayananKonDok" name="JnsLayananKonDok" class="txtinput" onchange="isiTmpLayananKonDok(this.value)"></select></td>
                        </tr>
                        <tr>
                            <td align="right">Tempat Layanan :</td>
                            <td><select name="TmpLayananKonDok" id="TmpLayananKonDok" tabindex="27" class="txtinput" onchange="isicmbDokKonDok(this.value)"></select></td>
                        </tr>
                        <tr>
                            <td align="right">Dokter :</td>
                            <td>
                                <select id="cmbDokKonDok" name="cmbDokKonDok" class="txtinput">
                                    <option value="">-Dokter-</option>
                                </select>                            </td>
                        </tr>
						<tr>
                            <td align="right">Keterangan :</td>
                            <td><textarea id="txtKetKonDok" name="txtKetKonDok" cols="35" rows="2" class="txtinput"></textarea></td>
                        </tr>
                        <tr>
                            <td align="right">Dokter Perujuk :</td>
                            <td>
                                <select id="cmbDokRujukDokter" name="cmbDokRujukDokter" class="txtinput" onchange="">
                                    <option value="">-Dokter-</option>
                                </select>
                                <label><input type="checkbox" id="chkDokterPenggantiRujukDokter" value="1" onchange="gantiDokter('cmbDokRujukDokter',this.checked);"/>Dokter Pengganti</label>                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
								<input type="button" id="btnSimpanKonDok" name="btnSimpanKonDok" value="Tambah" onclick="simpan(this.value,this.id);" class="tblTambah"/>
                                <input type="button" id="btnHapusKonDok" name="btnHapusKonDok" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
                                <input type="button" id="btnBatalKonDok" value="Batal" onclick="batal(this.id)" class="tblBtn" />
                                <input type="button" value="PRMHNN KONSUL" onClick="cetak_konsul_dokter()" class="tblBtn" />                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="hidden" id="kondokId" name="kondokId" />
                                <div id="gridboxKonDok" style="width:650px; height:250px; padding-bottom:10px; background-color:white;"></div>
                                <div id="pagingKonDok" style="width:650px;"></div>                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
            
            
			
            <div id="divIsiDataRM" style="display:none;width:900px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="batal('btnBatalIsiDataRM')" style="float:right; cursor: pointer" />
              <fieldset>
                    <legend id="lgnIsiDataRM">ISI DATA RM :&nbsp;
                        <select id="cmbIsiDataRM" name="cmbIsiDataRM" class="txtinput" onchange="evCmbDataRM();">
                        </select>
                    </legend>
                    <div id="ContentRM">                    </div>
                   	<table border=0 align="center">
                        <tr>
                            <td align="center">
                                <input type="hidden" id="idIsiDataRM" name="idIsiDataRM"/>
                                <input type="button" id="btnSimpanIsiDataRM" name="btnSimpanIsiDataRM" value="Tambah" onclick="ActIsiDataRM(this,this.value);" class="tblTambah"/>
                                <input type="button" id="btnHapusIsiDataRM" name="btnHapusIsiDataRM" value="Hapus" onclick="ActIsiDataRM(this,this.value);" disabled="disabled" class="tblHapus"/>
				<input type="button" id="btnBatalIsiDataRM" value="Batal" onclick="ActIsiDataRM(this,this.value);" class="tblBtn" />                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="grdIsiDataRM" style="width:450px; height:200px; padding-bottom:10px; background-color:white;"></div>
                                <!--div id="pagingIsiDataRM" style="width:450px;"></div-->                            </td>
                        </tr>
                    </table>
              </fieldset>
            </div>
            
            <div id="pKhusus" style="display:none;width:500px" class="popup">
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="batal('btnBatalIsiDataRM')" style="float:right; cursor: pointer" />
             <fieldset>
             	<legend id="lgnIsiDataRM">Perlakuan Khusus&nbsp;</legend>
                <table border=0 align="center">
                	<tr>
                         <td align="left"><input type="checkbox" id="psnKomplain" name="psnKomplain"/>Pasien Potensi Komplain</td>
                    </tr>
                    <tr>
                         <td align="left"><input type="checkbox" id="psnPemilik" name="psnPemilik"/>Pasien Adalah Pemilik Rumah Sakit</td>
                    </tr>
                    <tr>
                         <td align="left"><input type="checkbox" id="psnPejabat" name="psnPejabat"/>Pasien Adalah Pejabat</td>
                    </tr>
                    <tr>
                         <td align="center"><input type="button" id="btnSimpanPerlakuan" name="btnSimpanPerlakuan" value="Simpan" onclick="simpanPerlakuan();" class="tblTambah"/></td>
                    </tr>
                </table>
             </fieldset>
            </div>
            
            <div id="divIsiAnamnesa" style="display:none;width:980px" class="popup">
            	<?php include("anamnesa.php"); ?>
            </div>
            
            <div id="divRiwayatAlergi" style="display:none; width:500px" class="popup">
            	<?php include("riwayat_alergi.php"); ?>
            </div>
             <div id="divPemeriksaanFisik" style="display:none; width:500px" class="popup">
            	<?php include("pemeriksaan_fisik.php"); ?>
            </div>
			<div id="divCaraKeluar" style="display:none; width:500px" class="popup">
            	<?php include("cara_keluar.php"); ?>
            </div>
            <div id="divKeadaanKeluar" style="display:none; width:500px" class="popup">
            	<?php include("keadaan_keluar.php"); ?>
            </div>
            
            
            <div id="divIsiSOAPIER" style="display:none; width:980px;" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="new_soap=0" style="float:right; cursor: pointer" />
              <fieldset>
                    <legend>S O A P</legend>
                    <?php include("soap_v2.php"); ?>
			  </fieldset>
            </div>
            
            <div id="divInform_konsen" style="display:none;width:1100px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="new_soap=0" style="float:right; cursor: pointer" />
              <fieldset>
                    <legend>INFORM KONSEN</legend>
                    <iframe id="iframe_inform" class="framex" src="" onload="javascript:resizeIframe(this);" style="width:100%; height:400px; border:none;" ></iframe>
                    <?php //include '../report_rm/1.inform_konsen.php'; ?>
			  </fieldset>
            </div>
            
              <div id="divPenolakan_medis" style="display:none;width:1200px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="new_soap=0" style="float:right; cursor: pointer" />
              <fieldset>
                    <legend>PENOLAKAN TINDAKAN MEDIS</legend>
                    <iframe id="iframe_tolak_medis" class="framex" src="" onload="javascript:resizeIframe(this);" style="width:100%; height:400px; border:none;" ></iframe>
			  </fieldset>
            </div>
            
            
             <div id="divPeriksa_mata" style="display:none;width:1200px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="new_soap=0" style="float:right; cursor: pointer" />
              <fieldset>
                    <legend>SURAT KETERANGAN PEMERIKSAAN MATA</legend>
                    <iframe id="iframe_Periksa_mata" class="framex" src="" onload="javascript:resizeIframe(this);" style="width:100%; height:400px; border:none;" ></iframe>
			  </fieldset>
            </div>
            
            <div id="divResep_mata" style="display:none;width:1200px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="new_soap=0" style="float:right; cursor: pointer" />
              <fieldset>
                    <legend>RESEP KACAMATA</legend>
                    <iframe id="iframe_Resep_mata" class="framex" src="" onload="javascript:resizeIframe(this);" style="width:100%; height:400px; border:none;" ></iframe>
			  </fieldset>
            </div>
            
            <div id="divMed_wanita" style="display:none;width:1200px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="new_soap=0" style="float:right; cursor: pointer" />
              <fieldset>
                    <legend>FORM MEDICAL CHECK UP STATUS UP BEDAH (WANITA)</legend>
                    <iframe id="iframe_Med_wanita" class="framex" src="" onload="javascript:resizeIframe(this);" style="width:100%; height:400px; border:none;" ></iframe>
			  </fieldset>
            </div>
            
            <div id="divMed_dental" style="display:none;width:1200px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="new_soap=0" style="float:right; cursor: pointer" />
              <fieldset>
                    <legend>FORM MEDICAL CHECK UP STATUS UP (DENTAL)</legend>
                    <iframe id="iframe_Med_dental" class="framex" src="" onload="javascript:resizeIframe(this);" style="width:100%; height:400px; border:none;" ></iframe>
			  </fieldset>
            </div>
            
            <div id="divResum_medis" style="display:none;width:1200px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="new_soap=0" style="float:right; cursor: pointer" />
              <fieldset>
                    <legend>FORM RESUM MEDIS</legend>
                    <iframe id="iframe_Resum_medis" class="framex" src="" onload="javascript:resizeIframe(this);" style="width:100%; height:400px; border:none;" ></iframe>
			  </fieldset>
            </div>
            
            <div id="div_PgwsBayi" style="display:none;width:1200px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="new_soap=0" style="float:right; cursor: pointer" />
              <fieldset>
                    <legend>FORM PENGAWASAN BAYI</legend>
                    <iframe id="iframe_PgwsBayi" class="framex" src="" onload="javascript:resizeIframe(this);" style="width:100%; height:400px; border:none;" ></iframe>
			  </fieldset>
            </div>
            
            <div id="div_Neonatus" style="display:none;width:1200px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="new_soap=0" style="float:right; cursor: pointer" />
              <fieldset>
                    <legend>NEONATUS DISCHARGE</legend>
                    <iframe id="iframe_Neonatus" class="framex" src="" onload="javascript:resizeIframe(this);" style="width:100%; height:400px; border:none;" ></iframe>
			  </fieldset>
            </div>
            
             <div id="div_Peng_luka" style="display:none;width:1200px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="new_soap=0" style="float:right; cursor: pointer" />
              <fieldset>
                    <legend>FORM PENGKAJIAN LUKA</legend>
                    <iframe id="iframe_Peng_luka" class="framex" src="" onload="javascript:resizeIframe(this);" style="width:100%; height:400px; border:none;" ></iframe>
			  </fieldset>
            </div>
            
<!-- ============= Div Permintaan Bank Darah ============= -->  
            <div id="MintaDarah" style="display:none" class="popup">
            <div id="DapatDarah" style="display:none"></div>
        
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="batal('btnBatalIsiDataRM')" style="float:right; cursor: pointer" />
            <fieldset>
            	<legend>PERMINTAAN DARAH</legend>
                <form id="form_darah" name="form_darah">
                 <input id="id_pel" name="id_pel" type="hidden"  />
                <input id="idkso" name="idkso" type="hidden" value="1" />
            	<table width="100%" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                <tr>
                    <td>
                    <table width="50%" align="center" cellpadding="3" cellspacing="0">
                    <tr>
                        <td width="26%">Tanggal</td>
                        <td width="74%"><input type="text" id="tglDarah" class="txtinput2" name="tglDarah" size="10" value="<?php if($_REQUEST['act']=='edit') echo tglSQL($edit['tgl']); else echo date('d-m-Y'); ?>" />&nbsp;&nbsp;<img src="../icon/archive1.gif" width="20" align="absmiddle" style="cursor:pointer; vertical-align:middle" onclick="gfPop.fPopCalendar(document.getElementById('tglDarah'),depRange,fungsikosong);" /></td>
                    </tr>
                    <tr>
                        <td width="26%">No Permintaan</td>
                        <td width="74%"><div id="temp_no_minta" style="display:none"> </div><input type="text" class="txtinput2" id="no_bukti" name="no_bukti" size="22" value="<?php if($_REQUEST['act']=='edit') echo $edit['no_bukti']; else echo $no_pakai; ?>"  /></td>
                    </tr>
                    <tr style="display:none">
                        <td width="26%">Dokter</td>
                        <td width="74%">
                        <select id="id_dokter2" name="id_dokter2" class="txtinput2">
                        <?php
                            /*$d = "select id,nama from ".$dbbilling.".b_ms_pegawai p where p.pegawai_jenis=8 order by nama";
                            $dd = mysql_query($d);
                            while($dktr = mysql_fetch_array($dd)){ */
                        ?>
                           <!-- <option value="<?php echo $dktr['id']; ?>"><?php echo $dktr['nama']; ?></option>-->
                         <?php
                           /* }*/
                         ?>
                        </select>
                        <input type="hidden" id="id_dokter" name="id_dokter" value="<?php echo $userId; ?>" />                        </td>
                    </tr>
                    <tr>
                        <td width="26%">Gol. darah</td>
                        <td width="74%">
                        <select id="golongan" name="golongan" class="txtinput2">
                        <option value="0"> - </option>
                        <?php
                            $g = "select id,golongan from ".$dbbank_darah.".bd_ms_gol_darah";
                            $gg = mysql_query($g);
                            while($gol = mysql_fetch_array($gg)){ 
                        ?>
                            <option value="<?php echo $gol['id']; ?>"><?php echo $gol['golongan']; ?></option>
                        <?php
                            }
                        ?>
                        </select>                        </td>
                    </tr>
                    <tr>
                        <td width="26%">Rhesus</td>
                        <td width="74%">
                        <select id="rhesus" name="rhesus" class="txtinput2">
                        <option value="0"> </option>
                        <option value="+">+</option>
                        <option value="-">-</option>
                        </select>                        </td>
                    </tr>
                    <tr>
                        <td width="26%">Sifat Permintaan</td>
                        <td width="74%">
                        <select id="sifat" name="sifat" class="txtinput2" onchange="detailPil();">
                            <option value="1">Biasa</option>
                            <option value="2">Cito</option>
                            <option value="3">Persiapan operasi</option>
                        </select>                        </td>
                    </tr>
                    <tr>
                        <td width="26%">Alasan Tranfusi</td>
                        <td width="74%">
                        <input type="text" class="txtinput2" id="alasan1" name="alasan1" size="22"/>                        </td>
                    </tr>
                    <tr>
                        <td width="26%">Petugas Bank Darah</td>
                        <td width="74%">
                        <input type="text" class="txtinput2" id="petugas1" name="petugas1" size="22"/>                        </td>
                    </tr>
                    <tr id="ket_sifat" style="visibility:hidden"> 
                        <td width="26%"></td>
                        <td width="74%">Tanggal <input type="text" id="tggl" name="tggl" class="txtinput2" onclick="gfPop.fPopCalendar(document.getElementById('tggl'),depRange,fungsikosong);" size="10" value="" /> Jam <input type="text" name="jam" id="jam" class="txtinput2" size="3" value="" /><font style="color:#F00; font-style:italic">hh:mm</font></td>
                    </tr>	
                    </table>                    </td>
                </tr>
                <tr>
                    <td colspan="2" valign="top"></td>
                </tr>
                <tr>
                    <td>
                        <table width="60%" align="center" cellpadding="0" cellspacing="0" id="tblJual">
                        <tr>
                            <td height="20" colspan="9" align="right" style="padding-right:15px; padding-bottom:5px"><img src="../icon/edit_add.png" align="absmiddle" style="cursor:pointer" width="25" onClick="addRowToTable();" /></td>
                        </tr>
                        <tr class="headtable">
                            <td width="10%" class="tblheaderkiri">No.</td>
                            <td width="10%" class="tblheader">Kode</td>
                            <td width="10%" class="tblheader">Jenis</td>
                            <td style="display:none" width="5%" class="tblheader">Gol Darah</td>
                            <td style="display:none" width="5%" class="tblheader">Rhesus</td>
                            <td width="5%" class="tblheader">Jumlah</td>
                            <td width="15%" class="tblheader">Kemasan</td>
                            <td width="10%" class="tblheader">Biaya</td>
                            <td width="10%" class="tblheader">Proses</td>
                        </tr>      
                        <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
                            <td class="tdisikiri" align="center">1</td>
                            <td class="tdisi"><input id="kode" name="kode" type="text" size="10" value="<?php echo $edit['kode_darah']; ?>" onkeyup="suggestBag(event,this);" autocomplete="off"/><div id="divbag" align="left" style="position:absolute; z-index:0; height: 200px; width: 500px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div><input type="hidden" id="id_pr" name="id_pr" value="<?php ?>"><input type="hidden" name="idpn" id="idpn" value="<?php echo $edit['id_penerimaan']; ?>"><input type="hidden" id="idkode" name="idkode" value="<?php echo $edit['id_darah']; ?>"></td>
                            <td class="tdisi"><input id="jenis" name="jenis" type="text" size="30" value="<?php echo $edit['jenis_darah']; ?>" readonly="readonly" /></td>
                            <td style="display:none" class="tdisi"><input type="hidden" id="idgoldar" name="idgoldar" value="<?php echo $edit['id_goldar']; ?>"><input id="gol" name="gol" type="text" size="5" value="<?php echo $edit['golongan']; ?>" readonly="readonly" /></td>
                            <td style="display:none" class="tdisi"><input type="hidden" id="idresus" name="idresus" value="<?php echo $edit['id_resus']; ?>"><input id="resus" name="resus" type="text" size="5" value="<?php echo $edit['rhesus']; ?>" readonly="readonly" /></td>
                            <td class="tdisi"><input type="text" id="jumlah" name="jumlah" style="text-align:center" autocomplete="off" size="3" onkeyup="hitungBiaya(this);" /></td>
                            <td class="tdisi"><input type="text" id="kemasan" name="kemasan" size="10" value="Kantong" readonly="readonly" /></td>
                            <td class="tdisi"><input type="hidden" id="t_biaya" name="t_biaya" /><input type="text" id="biaya" name="biaya" style="text-align:right" size="10" value="<?php if($edit['id_kso']==4 || $edit['id_kso']==6) echo $edit['biaya_askes']; else echo $edit['biaya']; ?>" readonly="readonly" /><input type="hidden" id="b_umum" name="b_umum" value="<?php echo $edit['biaya']; ?>" /><input type="hidden" id="b_askes" name="b_askes"  value="<?php echo $edit['biaya_askes']; ?>"/></td>
                            <td class="tdisi"><img src="../icon/erase.png" width="16" align="absmiddle" title="Klik Untuk Menghapus" class="proses" onClick="removeRowFromTable(this);"/></td>
                        </tr>
                        </table>
                        <table width="60%" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="right">Total&nbsp;:&nbsp;</td>
                                <td width="20%" align="right"><input type="hidden" id="total" name="total"><span id="spntotal">0</span></td>
                            </tr>
                        </table>                    </td>
                </tr>
                <tr id="trBD_edit">
                    <td align="center">
                    <button type="button" id="btSimpan" name="btSimpan" value="tambah" onclick="actMintaDarah(this.value);" style="cursor:pointer; display:none"><img src="../icon/add.gif" width="20" align="absmiddle" />Simpan</button>
                    <button type="button" id="btBatal" name="btBatal" onclick="batall();" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;Batal</button>
                    <button type="button" id="btHapus" name="btHapus" value="Hapus" onclick="hapuss();" disabled="disabled" style="cursor:pointer"><img src="../icon/delete2.gif" align="absmiddle" width="20" />&nbsp;Hapus</button>
                    <button type="button" id="btCetak" name="btCetak" value="Cetak" onclick="cetakPermintaanDarah();" style="cursor:pointer"><img src="../icon/printer.png" align="absmiddle" width="20" />&nbsp;Cetak</button>
                    <button type="button" id="Pndah" name="Pndah" value="PERMINTAAN DARAH CITO" onclick="bukaCITO();" style="cursor:pointer; display:none;">&nbsp;PERMINTAAN DARAH CITO</button></td>
                </tr>
                <tr id="trBD_add">
                	<td align="center">
                    <button type="button" id="btOKBD" name="btOKBD" value="Simpan" onclick="document.getElementById('MintaDarah').popup.hide();" style="cursor:pointer"><img src="../icon/save.gif" width="20" align="absmiddle" />Simpan</button>
                    <button type="button" id="btBatal" name="btBatal" onclick="batall();" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;Reset</button>                    </td>
                </tr>
            <tr>
                <td height="20"></td>
            </tr>
            <tr id="trBD_grid">
            <td align="center">
            <div id="gbMintaDarah" style="width:750px; height:150px; background-color:white; overflow:hidden;"></div>
            <div id="pagingMD" style="width:750px;"></div></td>
            </tr>
                </table>
                </td>
            </tr>
            <tr>
                <td height="28" background="../images/main-bg.png" style="background-repeat:repeat-x;">&nbsp;</td>
            </tr>
            </table>
            </form>
            </fieldset>
            </div>
<!-- ============= Div Permintaan Bank Darah ============= -->                        
          <div id="divCtkVis" style="display:none; width:500px;" class="popup">
				<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
				<fieldset><legend>Cetak Visite Dokter</legend>
					<table width="460" border="0">
						<tr>
							<td width="20%">DOKTER</td>
							<td width="5%" align="center">:</td>
							<td width="75%"><select id="cmbDokVisite" name="cmbDokVisite" class="txtinput" ></select></td>
						</tr>
						<tr>
							<td colspan="3" align="center"><button id="ctkVisite" name="ctkVisite" onclick="cetakVisite()">CETAK VIISTE</button></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>				
				</fieldset>
</div>

            <div id="divRujukRS" style="display:none;width:500px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
			<!---button name="checkTerima" id="checkTerima">Checklist Terima Pasien Inap</button>
			<button name="checkKeluar" id="checkKeluar">Checklist Pasien Inap Keluar</button--->
              <fieldset><legend>Pasien Keluar</legend>
                    <table border=0 width="460">
                        <tr>
                            <td width="162" align="right"><a href="javascript:void(0)" onClick="detailCK()">Cara Keluar</a> :</td>
                            <td>
                                <select id="cmbCaraKeluar" class="txtinput" onchange="caraKeluar(this.value);cekTombol();"></select>                            </td>
                        </tr>
                        <tr>
                            <td align="right"><a href="javascript:void(0)" onclick="detailKK()">Keadaan Keluar :</a></td>
                            <td>
                                <select id="cmbKeadaanKeluar" class="txtinput" onchange="keadaanKeluar(this.value);">
                                    <option value="Perlu kontrol kembali">Perlu kontrol kembali</option>
									<option value="Sembuh">Sembuh</option>
                                </select>                            </td>
                        </tr>
                        <tr>
                            <td align="right">Kasus :</td>
                            <td>
                                <select id="cmbKasus" class="txtinput">
                                    <option value="1">Baru</option>
                                    <option value="0">Lama</option>
                                </select>                            </td>
                        </tr>
                        <tr id="trEmergency">
                            <td align="right">Status Emergency :</td>
                            <td>
                                <select id="cmbEmergency" class="txtinput"></select>                            </td>
                        </tr>
                        <tr id="trKondisiPasien">
                            <td align="right">Kondisi Pasien :</td>
                            <td>
                                <select id="cmbKondisiPasien" class="txtinput"></select>                            </td>
                        </tr>
                        <tr id="trkrs1">
                            <td align="right">Tanggal Pulang :</td>
                            <td>
                            <input type="text" class="txtcenter" readonly="readonly" name="TglMasuk" id="TglKrs" size="11" value="<?php echo $date_now;?>"/>
                            <input type="button" id="btnTglKrs" name="btnTglMasuk" value=" V " class="btnTglKrs" disabled="disabled" onClick="gfPop.fPopCalendar(document.getElementById('TglKrs'),depRange,fungsikosong);" />                            </td>
                        </tr>
                        <tr id="trkrs2">
                            <td align="right">Jam Pulang :</td>
                            <td>
                            <input type="text" class="txtcenter" readonly="readonly" name="JamMasuk" id="JamKrs" size="5" maxlength="5" value=""/>
                            <label><input type="checkbox" id="chkManualKrs" name="chkManual" <?php echo $DisableBD; ?> onclick="setManual('krs')"/>set manual</label>                            </td>
                        </tr>
                        <tr id="trRujukRS" style="visibility:collapse">
                            <td width="162" align="right">RS Rujukan :</td>
                            <td >
                                <select name="cmbRS" id="cmbRS" tabindex="26" class="txtinput" onchange=""></select>                            </td>
                        </tr>
                        <tr id="trRujukRSKet" style="visibility:collapse">
                            <td align="right">Keterangan Rujuk :</td>
                            <td>
                                <textarea id="txtKetRujukRS" name="txtKetRujukRS"  cols="35" rows="2" class="txtinput"></textarea>                            </td>
                        </tr>
                        <tr>
                            <td align="right">Dokter :</td>
                            <td>
                                <select id="cmbDokRujukRS" name="cmbDokRujukRS" class="txtinput" onchange="setDok(this.value)">
                                    <option value="">-Dokter-</option>
                                </select>
                                <label><input type="checkbox" id="chkDokterPenggantiRujukRS" value="1" onchange="gantiDokter('cmbDokRujukRS',this.checked);"/>Dokter Pengganti</label>                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            
                            <td colspan="2" align="center">
                                <input type="hidden" id="idRujukRS" name="idRujukRS"/>
                                <input type="button" id="btnSimpanRujukRS" name="btnSimpanRujukRS" value="Tambah" onclick="simpan(this.value,this.id);" class="tblTambah"/>
                                <input type="button" id="btnHapusRujukRS" name="btnHapusRujukRS" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
                                <!--<input type="button" id="btnBatalRujukRS" value="Batal" onclick="batal(this.id)" class="tblBtn" />-->
                                <input type="button" id="btnBatalRujukRS" value="Batal" onclick="batalkrsan()" class="tblBtn" />
                                <input type="button" id="btnCetakKRS" name="btnCetakKRS" value="Cetak KRS" onclick="cetakKRS()" class="tblBtn" style="display:none;"/>
                                <input type="button" id="btnSpInap" name="btnSpInap" value="SP Inap" class="tblBtn" onclick="window.open('krs.php','_blank')" style="display:none;" />
                                <input type="button" id="btnMati" name="btnMati" value="Surat Keterangan Meninggal" class="tblBtn" onclick="cetak_mati()" style="display:none;" />
								<input type="button" id="btnMati" name="btnMati" value="Check List Pasien Pulang" class="tblBtn" onclick="checkList()" />                            </td>
                        </tr>
                        <tr>                   	
                            <td colspan="2" align="center"><select class="txtinput" id="cmbCetakKRS">
                            	<option value="MRS">SP Inap</option>
                                <option value="Meninggal">Surat Keterangan Meninggal</option>
                                <option value="Atas Ijin Dokter">Check List Pasien Pulang</option>
                                <option value="APS">APS</option>
                                <option value="Dirujuk">Rujukan</option>
                            </select>&nbsp;<input type="button" value="Cetak" id="btnKrs" class="tblBtn" onclick="btnCetakLapKRS();" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <div id="gridboxRujukRS" style="width:450px; height:150px; padding-bottom:10px; background-color:white;"></div>
                                <div id="pagingRujukRS" style="width:450px;"></div>                            </td>
                        </tr>
                    </table>
              </fieldset>
            </div>
            <div id="divSetKamar" style="display:none;width:500px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
              <fieldset><legend>Pindah Kamar</legend>
                    <table border=0>
                        <tr>
                            <td align="right">Jenis Layanan</td>
                            <td>
                                <select id="cmbJL" class="txtinput" onchange="isiCmbTL()"></select>                            </td>
                        </tr>
                        <tr>
                            <td align="right">Tempat Layanan</td>
                            <td>
                                <select id="cmbTL" class="txtinput" onchange="isiKelasKamar(this.value);"></select>                            </td>
                        </tr>
                        <tr>
                            <td align="right">Kelas :</td>
                            <td><select name="cmbKelas" id="cmbKelas" tabindex="28" class="txtinput" onchange="isiPindahKamar();"></select></td>
                        </tr>
                        <tr id="cmbKamarN">
                            <td width="162" align="right">Kamar :</td>
                            <td >
                                <select name="cmbKamar" id="cmbKamar" tabindex="26" class="txtinput" onchange=""></select>
                                <span id="spanTarifPindah" ></span>                            </td>
                        </tr>
                        <tr>
                            <td align="right">Tanggal Masuk :</td>
                            <td>
                                <input type="text" class="txtcenter" readonly="readonly" name="TglMasuk" id="TglMasuk" size="11" value="<?php echo $date_now;?>"/>
                                <input type="button" class="btninput" id="btnTglMasuk" name="btnTglMasuk" disabled="disabled" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('TglMasuk'),depRange,fungsikosong);" />                            </td>
                        </tr>
                        <tr>
                            <td align="right">Jam Masuk :</td>
                            <td>
                                <input type="hidden" id="jamServer" name="jamServer" value="<?php echo $time_now;?>"/>

                                <input type="text" class="txtcenter" readonly="readonly" name="JamMasuk" id="JamMasuk" size="5" maxlength="5" value=""/>
                                <label><input type="checkbox" id="chkManual" name="chkManual" <?php echo $DisableBD; ?> onclick="setManual()"/>set manual</label>                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="hidden" id="idSetKamar" name="idSetKamar"/>
                                <input type="button" id="btnSimpanKamar" name="btnSimpanKamar" value="Tambah" onclick="simpan(this.value,this.id);" class="tblTambah"/>
                                <input type="button" id="btnHapusKamar" name="btnHapusKamar" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
				<input type="button" id="btnBatalKamar" value="Batal" onclick="batal(this.id)" class="tblBtn" />
                                <input type="button" value="CETAK" onClick="load_popup_iframe('FORM SERAH TERIMA PINDAH RUANG','../report_rm/pindah_ruang/index.php')" class="tblBtn" />                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div id="gridboxKamar" style="width:450px; height:250px; padding-bottom:10px; background-color:white;"></div>
                                <div id="pagingkamar" style="width:450px;"></div>                            </td>
                        </tr>
                    </table>
              </fieldset>
            </div>
            <div id="divSetLab" style="display:none;width:450px;" class="popup">
            <div id="divDlm"></div>
				<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
                <fieldset>
                    <legend>Nomor Spesimen</legend>
					<span id="spLab" style="display:none"></span>
                    <table border="0" cellpadding="0" cellspacing="0" align="center">
                        <tr>
                            <td width="50%" align="center" height="30">Nomor Spesimen&nbsp;:</td>
                            <td width="50%">&nbsp;&nbsp;&nbsp;<input id="txtLab" name="txtLab" size="8" onkeypress="smp(event)"></td>
                        </tr>
                    </table>
                </fieldset>
            </div>
			<!--NOMOR REGISTRASI-->
            <div id="divSetLab2" style="display:none;width:450px;" class="popup">
            <div id="divDlm2"></div>
				<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
                <fieldset>
                    <legend>Nomor Registrasi</legend>
					<span id="spLab" style="display:none"></span>
                    <table border="0" cellpadding="0" cellspacing="0" align="center">
                        <tr>
                            <td width="50%" align="center" height="30">Nomor Registrasi&nbsp;:</td>
                            <td width="50%">&nbsp;&nbsp;&nbsp;<input id="txtLab2" name="txtLab2" size="8" onkeypress="smp2(event)"></td>
                        </tr>
                    </table>
                </fieldset>
            </div>
			<!-- END -->
            <div id="divIzin" style="display:none;width:450px;" class="popup">
            <div id="divDlm"></div>
				<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
                <fieldset>
                    <legend>SURAT KETERANGAN</legend>
					<span id="spLab" style="display:none"></span>
                    <table border="0" cellpadding="0" cellspacing="0" align="left">
						<tr>
                            <td width="60%" align="left" height="30">Jenis Keterangan&nbsp;:</td>
                            <td width="40%">
                            <select id="jns12" class="jns12" name="jsn12" onChange="jatobChange()">
                            <option value="Sakit">Sakit</option>
                            <option value="Sehat">Sehat</option>
                            </select>                            </td>
                        </tr>
                        <tr>
                            <td width="60%" align="left" height="30"><div id="div_sakit" style="display:none;">Lama Istirahat&nbsp;:</div><div id="div_sehat" style="display:none;">Untuk Keperluan&nbsp;:</div></td>
                            <td width="40%"><div id="div_sakit2"><input id="txtIzin" name="txtIzin" size="20" style="display:none;" onkeypress=""></div> </td>
                        </tr>
                        <tr>
                        	<td colspan="2" align="center"><input type="button" value="Cetak Surat Keterangan" onclick="cetak_izin()" /></td>
                        </tr>
                    </table>
                </fieldset>
            </div>
            <div id="divSetMutasi" style="display:none;width:500px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
              <fieldset><legend>Pindah Tempat Layanan (MUTASI)</legend>
                    <table border=0>
                        <tr>
                            <td width="162" align="right">Jenis Layanan :</td>
                            <td >
                                <select id="JnsLayananMutasi" class="txtinput" onchange="isiCombo('TmpLayanan',this.value,'','TmpLayananMutasi')">
                                    <?php
                                    $sql="SELECT distinct m.id,m.nama,m.inap FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
					where ms_pegawai_id=".$_SESSION['userId'].") as t1
					inner join b_ms_unit u on t1.unit_id=u.id
					inner join b_ms_unit m on u.parent_id=m.id order by nama";
                                    $rs=mysql_query($sql);
                                    while($rw=mysql_fetch_array($rs)) {
                                        ?>
                                    <option value="<?php echo $rw['id'];?>" lang="<?php echo $rw['inap'];?>" ><?php echo $rw['nama'];?></option>
                                        <?php
                                    }
                                    ?>
                                </select>                            </td>
                        </tr>
                        <tr>
                            <td align="right">Tempat Layanan :</td>
                            <td>
                                <select name="TmpLayananMutasi" id="TmpLayananMutasi" tabindex="27" class="txtinput"  onchange=""></select>                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="button" id="btnSimpanMutasi" name="btnSimpanMutasi" value="Simpan Mutasi" onclick="simpanMutasi();" class="popup_closebox"/>
				<input type="button" id="btnBatalMutasi" value="Batal" onclick="batal(this.id)" class="tblBtn" />
                                <input type="button" value="Cetak Kwitansi" onclick="cetakKwitansi()" />                            </td>
                        </tr>
                    </table>
              </fieldset>
            </div>
			<div id="divSetNoSEP" style="display:none;width:450px;" class="popup">
				<div id="divSetNoSEP_Dlm" style="display:none;"></div>
				<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
                <fieldset>
                    <legend id="lgn_SetNoSEP">Nomor SEP</legend>
					<span id="spSetNoSEP" style="display:none"></span>
                    <table width="370" border="0" cellpadding="0" cellspacing="0" align="center">
                        <tr>
                            <td id="lbl_SetNoSEP" width="100" align="center" height="30">Tgl SEP&nbsp;:</td>
                            <td>&nbsp;&nbsp;&nbsp;<input id="txtSetTglSEP" name="txtSetTglSEP" class="txtcenter" size="11" readonly="readonly" value="<?php echo $tgl_SEP;?>"/>
                              <input type="button" id="BtnSetTglSEP" name="BtnSetTglSEP" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('txtSetTglSEP'),depRange);" /></td>
                        </tr>
                        <tr>
                            <td id="lbl_SetNoSEP" align="center" height="30">No SEP&nbsp;:</td>
                            <td>&nbsp;&nbsp;&nbsp;<input id="txtSetNoSEP" name="txtSetNoSEP" size="35"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><br /><input name="BtnUpdtSetNoSEP" id="BtnUpdtSetNoSEP" type="button" value="   Simpan   " class="tblBtn" onclick="SimpanInputNoSEP();" /></td>
                        </tr>
                    </table>
                </fieldset>
            </div>
			
			<!-- =====tambahan dpjp + pav===== -->
            <div id="divSetDPJP" style="display:none;width:450px;" class="popup">
            <div id="divSetDPJP_Dlm" style="display:none;"></div>
				<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
                <fieldset>
                    <legend id="lgn_SetDPJP">DPJP</legend>
					<span id="spSetDPJP" style="display:none"></span>
                    <table width="370" border="0" cellpadding="0" cellspacing="0" align="center">
                        <tr>
                            <td id="lbl_SetNoSEP" align="center" height="30">DPJP&nbsp;:</td>
                            <td>&nbsp;&nbsp;&nbsp;<select id="cmb_dpjp"><option> - </option></select></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><br /><input name="BtnUpdtSetDPJP" id="BtnUpdtSetDPJP" type="button" value="   Simpan   " class="tblBtn" onclick="SimpanInputDPJP();" /></td>
                        </tr>
                    </table>
                </fieldset>
            </div>
            <div align="center">
          <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#008484"  class="hd2">
                    <tr>
                        <td height="30">&nbsp;DETAIL PASIEN &nbsp; Tempat Pelayanan : <input type="text" id="txtPelUnit" value="" readonly="readonly" class="txtinput"/> <span id="spanKam"></span></td>
                        <td>
                            <img alt="close" src="../icon/close.png" onClick="cekHLab();" border="0" style="cursor:pointer; float:right" />
                        </td>
                    </tr>
              </table>
                <table width="1000" border="0" cellpadding="0" cellspacing="0" class="tabel" align="center">
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="90%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <fieldset>
                                <table width="100%" align="center" border="0" cellpadding="1" cellspacing="1" class="tabel">
                                    <tr>
                                        <td width="7%">&nbsp;No RM</td>
                                        <td width="15%">:
					<input id="txtNo" onfocus="cekAwal();fSetFocus(this);" onblur="cekAkhir();" name="txtNo" size="12" value="" onkeyup="filter(event,this)" class="txtinput" />&nbsp;
					</td>
                                        <td width="6%">&nbsp;Nama</td>
                                        <td width="28%">: <input id="txtNama" name="txtNama" size="28" value=""  class="txtinput" readonly="readonly" />&nbsp;</td>
                                        <td width="42%" >&nbsp;Lhr&nbsp;: <input id="txtTglLhr" name="txtTglLhr" size="10" value="" class="txtinput"  readonly="readonly"/>&nbsp;Umur&nbsp;:&nbsp;<input id="txtUmur" name="txtUmur" size="12" value="" class="txtinput" />&nbsp;&nbsp;&nbsp;L/P&nbsp;:&nbsp;<input id="txtSex" name="txtSex" size="2" value="" readonly="readonly" class="txtinput" /></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top">&nbsp;Ortu</td>
                                        <td style="vertical-align:top">: <input id="txtOrtu" name="txtOrtu" size="12" value=""  readonly="readonly" class="txtinput" />&nbsp;
										</td>
                                        <td valign="top">&nbsp;Alamat</td>
                                        <td rowspan="2" valign="top"><span style="vertical-align:top">:</span> <textarea id="txtAlmt" name="txtAlmt" cols="28" rows="2" readonly="readonly" class="txtinput" ></textarea></td>
                                        <td rowspan="2" valign="top"><span style="vertical-align:top">&nbsp;<a href="javascript:void(0)" onClick="detailRA()">R. Alergi</a>&nbsp;:&nbsp;</span>&nbsp;<textarea id="txtRA" name="txtRA" cols="28" rows="2" readonly="readonly" class="txtinput" ></textarea></td>
                                    </tr>
   									<tr>
                                        <td valign="top">&nbsp;<a href="javascript:void(0)" onClick="gantiNoTelp()">Telp</a>&nbsp;&nbsp;</span></td>
                                        <td>: <input id="txtNoTelp" name="txtNoTelp" size="12" value=""  readonly="readonly" class="txtinput" />&nbsp;
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
									<tr>
                                        <td style="vertical-align:top">&nbsp;Agama</td>
                                        <td style="vertical-align:top">: <input id="txtAgama" name="txtAgama" size="12" value=""  readonly="readonly" class="txtinput" />&nbsp;
											<br />
											<span id="spnNoTelp" style="display:none;"></span>
											<div id="loadGambar"></div>
											<div id="loadGambar1"></div>
											<div id="uCheckout" style="display:none"></div>
										</td>
                                        <td colspan="3">
											<span id="trPlatfon" style="display:none;">
												&nbsp;Plafon: <a id="nPlatfon" href="javascript:void(0)" onclick="fSetPlatfon();">0</a><span id="resPlatfon" style="display:none"></span>
											</span>
										</td>
                                    </tr>
									<tr id="trGrouper">
										<td colspan="4">&nbsp;Kode Grouper: 
											<span id="spnGrouper" title="Klik Untuk Mengubah Kode Grouper" style="cursor:pointer;color:#FF0000;font-weight:bold;" onclick="cekInputDiagnosa();/*fSetKodeGrouper();*/">[&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]</span>
											<span id="resGrouper" style="display:none"></span>
										</td>
										<td valign="top">
											No SEP : <span id="spnNoSEP" title="Klik Untuk Mengubah No SEP" style="cursor:pointer;color:#FF0000;font-weight:bold;" onclick="cekInputNoSEP();">[&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]</span><span id="resNoSEP" style="display:none"></span>
										</td>
									</tr>
									<!-- =====tambahan dpjp + pav===== -->
                                    <tr>
                                    	<td>&nbsp;DPJP</td>
                                        <td colspan="4">: <span id="spn_dpjp" title="Klik Untuk Mengubah DPJP" style="cursor:pointer;color:#FF0000;font-weight:bold;" onclick="cekInputDPJP();">[&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]</span><span id="resDPJP" style="display:none"></span></td>
                                    </tr>									
                                    <!--<tr>
                                        <td valign="top">&nbsp;<a href="javascript:void(0)" onClick="gantiNoTelp()">Telp</a>&nbsp;&nbsp;</span></td>
                                        <td>: <input id="txtNoTelp" name="txtNoTelp" size="12" value=""  readonly="readonly" class="txtinput" />&nbsp;
                                        <br />
                                        <span id="spnNoTelp" style="display:none;"></span>
										<div id="loadGambar"></div>
                                        <div id="loadGambar1"></div>
                                        <div id="uCheckout" style="display:none"></div>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>-->
									<!--<tr>
                                        <td colspan="5" align="center">
										
										</td>
                                    </tr>-->
									<!--<tr>
                                        <td colspan="5" align="center">&nbsp;
										
										</td>
                                    </tr>-->
									
									<tr>
                                    	<td>&nbsp;</td>
                                    </tr>
				    				<tr>
										<td colspan="5" align="center" style="color:#203C42; font-weight:bold; font-size: 14px" id="tdStat"></td>
				    				</tr>
                                </table>
                            </fieldset>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="padding:10px;">			    
					<input type="button" id="btnRujukUnit" name="btnRujukUnit" value="KONSUL" onclick="rujukUnit(this.value)" class="tblBtn"/>
                   <div  style="display:none;">
				   
				    <input type="button" id="btnKonDok" name="btnKonDok" value="KONSUL DOKTER" onclick="konsulDokter()" class="tblBtn"/>
					
					</div>
					
					<input type="button" id="btnRujukRS" name="btnRujukRS" value="KRS" onclick="rujukRS()" class="tblBtn"/>
				    
					<!--input type="button" id="btnRekamMds" name="btnRekamMds" value="REKAM MEDIS" onclick="rekamMedis()" class="tblBtn"/-->
					<input type="button" id="btnRekamMds" name="btnRekamMds" value="RIWAYAT PASIEN" onclick="rekamMedis()" class="tblBtn"/>
					<input type="button" id="btnSetKamar" name="btnSetKamar" value="PINDAH KAMAR" onclick="setKamar()" style="display:none;" class="tblBtn"/>
				   
				<!--	<input type="button" id="btnMutasi" name="btnMutasi" value="RUJUK"  onclick="konsulDokter();" class="tblBtn"/>-->
<!--                    <input type="button" id="btnMutasi" name="btnMutasi" value="MUTASI" onclick="setMutasi();" class="tblBtn"/>-->
					<input type="button" id="btnMRS" name="btnMRS" value="MRS" onclick="rujukUnit(this.value)" class="tblBtn"/>
				   
					<input type="button" id="btnResume" name="btnResume" value="RESUME MEDIS" onclick="resumeMedis()" class="tblBtn"/>
					<input type="button" id="btnVer" name="btnVer" value="VERIFIKASI INAP" class="tblBtn" onclick="window.open('verifikasiInap.php?idKunj='+getIdKunj+'&idUnit='+getIdUnit,'_blank')" style="display:none" />
				   
					<input type="button" id="btnCtkRincian" name="btnCtkRincian" value="RINCIAN TINDAKAN" style="cursor:pointer" onMouseOver="MM_showMenu(window.mm_menu_0814123211_0,0,20,null,'btnCtkRincian');" onMouseOut="MM_startTimeout();" class="tblBtn"/>
					<input type="button" id="btnLab" name="btnLab" value="NOMOR SPESIMEN" onclick="cetakLab();" class="tblBtn"/>
					<!--input type="button" id="btnLab2" name="btnLab2" value="NOMOR REGISTRASI" onclick="cetakLab2();" class="tblBtn"/-->
				    
                    <input type="button" id="btnIzin" name="btnIzin" value="SURAT KETERANGAN" onclick="cetakIzin();" class="tblBtn"/>
                    
					<input name="UpdStatusPx" id="UpdStatusPx" type="button" value="UBAH STATUS Px" class="tblBtn" onclick="PopUpdtStatus();" />
					<input name="ctkVis" id="ctkVis" type="button" value="CETAK VISITE" class="tblBtn" onclick="ctkVis();" />
					<input type="button" id="btnPasienPulang" name="btnPasienPulang" value="PASIEN PULANG" onclick="simpan(this.value,this.id);" class="tblBtn" style="display:none;"/>
                            
			    <input type="button" id="btnBatalPulang" name="btnBatalPulang" value="PASIEN BATAL PULANG" onclick="hapus(this.id);" class="tblBtn"/>
                <!--input type="button" id="btnIsiDataRM" name="btnIsiDataRM" value="ISI DATA RM" onclick="isiDataRM();" class="tblBtn"/-->
			    <input type="button" id="btnDarah" name="btnDarah" value="PERMINTAAN DARAH" class="tblBtn" onclick="isiMintaDarah()" style="display:none" />
                <input type="button" id="ctkLab" name="ctkLab" value="HASIL LAB" onclick="viewListKonsul(57);" class="tblBtn"/><!--cetakHasilLabAll()-->
				<input type="button" id="htrLab" name="htrLab" value="HISTORY HASIL LAB" onclick="viewListKonsul('history');" class="tblBtn"/>
                <input type="button" id="ctkRad" name="ctkLab" value="HASIL RADIOLOGI" onclick="cetakHasilRadAll();" class="tblBtn"/>
                <input type="button" id="ctkAmpRad" name="ctkLab" value="CETAK AMPLOP RADIOLOGI" onclick="cetakAmplopRad();" class="tblBtn"/><br/>
				<input type="button" id="btnCtkFrm" name="btnCtkFrm" value="REPORT RM" style="cursor:pointer" onMouseOver="MM_showMenu(window.mm_menu_0814123211_5,0,20,null,'btnCtkFrm');" onMouseOut="MM_startTimeout();" class="tblBtn"/>
                <div style="display:none"><input type="button" id="btnIsiDataRM12" name="btnIsiDataRM" value="ANAMNESA &amp; PEMERIKSAAN FISIK" onclick="isiAnamnesa();" class="tblBtn"/></div>
                <div style="display:none"><input type="button" id="btnIsiDataRM13" name="btnIsiDataRM" value="SOAPIER" onclick="isiSOAPIER();" class="tblBtn"/></div>
                <input type="button" style="display:none;" id="btnIsiDataRM14" name="btnIsiDataRM" value="LOCK TINDAKAN" onclick="keluar12();" class="tblBtn" />
                <input type="button" id="btnIsiDataRM15" name="btnIsiDataRM" value="PERLAKUAN KHUSUS" onclick="tampilPerlakuan();" class="tblBtn" />
                <input type="button" id="btnIsiDataRM16" name="btnIsiDataRM" value="TATA TERTIB RAWAT INAP" onclick="tatib();" class="tblBtn" />
                <input type="button" id="btnCekOut" name="btnCekOut" value="CHECK OUT" onclick="simpan(this.value,this.id);" class="tblBtn"/>
                <input type="button" id="btnCCekOut" name="btnCCekOut" value="CANCEL CHECK OUT" onclick="simpan(this.value,this.id);" class="tblBtn"/>
                <!--input type="button" id="btnIsiDataRM17" name="btnIsiDataRM" value="SURAT BALASAN KONSUL" onclick="balasan();" class="tblBtn" /-->
				<input type="button" id="btnIsiDataRM18" name="btnIsiDataRM" value="BATAL BERKUNJUNG" <?php echo $disableKunj; ?> onclick="kunjung();" class="tblBtn" />
                <input style="display:none;" type="button" id="btnIsiDataRM19" name="btnIsiDataRM" value="JADI BERKUNJUNG"  <?php echo $disableKunj; ?> onclick="kunjung1();" class="tblBtn" />
                <input type="button" id="sampel" name="sampel" value="PENGAMBILAN SAMPEL LAB" onclick="sampel();" class="tblBtn" />
                 <input type="button" id="sampel1" name="sampel1" value="PENGGUNAAN LIST PEMERIKSAAN" onclick="sListPemeriksaan();" class="tblBtn" />
                <input style="display:none;" type="button" id="validasi" name="validasi" value="VALIDASI PEMERIKSAAN LAB" onclick="validasi();" class="tblBtn" />
                <input type="button" id="workList" name="workList" value="MODALITY WORK LIST RADIOLOGI" onclick="workList();" class="tblBtn" style="display:none;" />
                <input type="button" id="rawatbersama" name="btnIsiDataRM" value="RAWAT BERSAMA" onclick="rawatbrg();" class="tblBtn" />
				<?php
			    $sVer="SELECT p.id ,g.nama AS grup FROM b_ms_group_petugas gp
				    INNER JOIN b_ms_group g ON g.id=gp.ms_group_id
				    INNER JOIN b_ms_pegawai p ON p.id=gp.ms_pegawai_id
				    WHERE (g.nama LIKE '%VERIFIKATOR%' OR g.nama LIKE '%CIO%' OR g.ket LIKE '%VERIFIKATOR%')
				    AND p.id='$userId'";
			    $rsVer=mysql_query($sVer);
			    $hidden="none";
			    if(mysql_num_rows($rsVer)>0){
				$rwVer=mysql_fetch_array($rsVer);				
				$vid=$rwVer['id'];
				$hidden="block";
			    }
			    ?>
			    <button type="button" id="btnVerifikasi" name="btnVerifikasi" style="display:<?php echo $hidden;?>" onclick="verifikasi(<?php echo $vid?>);" class="tblBtn">
			    VERIFIKASI (belum)
			    </button>			   
			</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td align="center"><div class="TabView" id="TabView" style="width:900px; height:500px"></div></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                <!--table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                    <tr>
                        <td height="30">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" class="btninput" /></td>
                        <td>&nbsp;</td>
                        <td align="right"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" onClick="showDetil()" />&nbsp;</td>
                    </tr>
                </table-->
            </div>
    </div>
        <div id="divUpdtStatus" style="display:none;width:450px; height:250px" align="center" class="popup">
        	<span id="inpEvUpdt" style="display:none"></span>
            <span id="spnTglInap" style="display:none"></span>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td><img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right;cursor: pointer" /></td>
                </tr>
                <tr>
                    <td align="center">
                    	<table border="0" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td class="txtinputNoBgColor">Status Pasien</td>
                              <td class="txtinputNoBgColor" width="10" align="center">&nbsp;:</td>
                                <td>
                                	<select id="statusPx" name="statusPx" class="txtinput" onchange="fChangeStatusPx(this.value)">
                                    <?php 
									$sql="SELECT id,nama FROM b_ms_kso WHERE aktif=1 ORDER BY nama";
									$rs=mysql_query($sql);
									while ($rw=mysql_fetch_array($rs)){
									?>
                                    	<option value="<?php echo $rw['id']; ?>"><?php echo $rw['nama']; ?></option>
                                    <?php 
									}
									?>
                                    </select>                                </td>
                            </tr>
                        	<tr style="visibility:visible">
                            	<td class="txtinputNoBgColor">Jenis Kunjungan</td>
                              	<td class="txtinputNoBgColor" width="10" align="center">&nbsp;:</td>
                                <td>
                                	<select id="jenisKunj" name="jenisKunj" class="txtinput" onchange="if (this.value=='1') document.getElementById('TglSJP').value=getTgl_Inap; else document.getElementById('TglSJP').value=getTgl_sjp;">
                                        <option value="1">Rawat Inap ( RI )</option>
                                    	<option value="2">Semua ( IGD, RJ, RI )</option>
                                    </select>                            	</td>
                            </tr>
                        	<tr>
                            	<td class="txtinputNoBgColor"><span id="spnTglSJP">Tgl SJP/SKP</span></td>
                              <td class="txtinputNoBgColor" width="10" align="center">&nbsp;:</td>
                                <td><input type="text" class="txtcenter" name="TglSJP" readonly id="TglSJP" size="11" value="<?php echo $date_now;?>"/>
                              <input type="button" id="ButtonTglSJP" name="ButtonTglSJP" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('TglSJP'),depRange,fungsikosong);" /></td>
                            </tr>
                        	<tr id="trnosjp">
                              <td class="txtinputNoBgColor">No SJP/SKP</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td><input type="text" class="txtinput" name="NoSJP" id="NoSJP" size="20" /></td>
                        	</tr>
                        	<tr id="trNoJaminan">
                              <td class="txtinputNoBgColor">No Anggota</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td><input type="text" class="txtinput" name="NoJaminan" id="NoJaminan" size="20" /></td>
                      	  </tr>
                        	<tr id="trHakKelas">
                              <td class="txtinputNoBgColor">Hak Kelas</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td><select id="cmbHakKelas" name="cmbHakKelas" class="txtinput">
                                <?php 
									$sql="SELECT * FROM b_ms_kelas WHERE id IN (2,3,4,5,6,7,8,9) AND aktif=1";
									$rs=mysql_query($sql);
									while ($rw=mysql_fetch_array($rs)){
									?>
                                <option value="<?php echo $rw['id']; ?>"><?php echo $rw['nama']; ?></option>
                                <?php 
									}
									?>
                              </select></td>
                      	  </tr>
                        	<tr id="trnmPeserta">
                        	  <td class="txtinputNoBgColor">Nama Peserta</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td><input type="text" class="txtinput" name="nmPeserta" id="nmPeserta" size="30" /></td>
                      	  </tr>
                        	<tr id="trStatusPenj">
                              <td class="txtinputNoBgColor">Status Jaminan&nbsp;</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td><select name="StatusPenj" id="StatusPenj" class="txtinputreg">
                                    <option value="ANAK KE 1">Anak Ke 1</option>
                                    <option value="ANAK KE 2">Anak Ke 2</option>
                                    <option value="ISTRI">Istri</option>
                                    <option value="PESERTA">Peserta</option>
                                    <option value="SUAMI">Suami</option>
                                </select></td>
                       	  </tr>
                        </table>                  </td>
                </tr>
                <tr>
                    <td align="center"><br /><input name="BtnUpdtStatusPx" id="BtnUpdtStatusPx" type="button" value="Update Status" class="tblBtn" onclick="goUpdtStatusPx()" /></td>
                </tr>
            </table>
        </div> 
        <div id="divPilihKamar" style="display:none;width:350px; height:120px" align="center" class="popup">
          <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td><img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right;cursor: pointer" /></td>
                </tr>
                <tr>
                    <td align="center">
                    	<table border="0" cellpadding="0" cellspacing="0">
                        	<tr>
                              <td class="txtinputNoBgColor">Kamar&nbsp;</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td><select name="kamarPx" id="kamarPx" class="txtinputreg" onchange="isiBad()">
                                </select></td>
                       	  </tr>
						  <tr>
                              <td class="txtinputNoBgColor">No Bed&nbsp;</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td><select name="no_kamar" id="no_kamar" class="txtinputreg">
                                </select></td>
                       	  </tr>
                        </table>                  </td>
                </tr>
                <tr>
                    <td align="center"><br /><input name="BtnPilihKamarPx" id="BtnPilihKamarPx" type="button" value="Pilih Kamar" class="tblBtn" onclick="PilihKamarPx()" /></td>
                </tr>
          </table>
        </div>
        
        <div id="divValidasiLab" style="display:none;width:350px; height:150px" align="center" class="popup">
          <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td><img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right;cursor: pointer" /></td>
                </tr>
                <tr>
                    <td align="center">
                    	<!--<table border="0" cellpadding="0" cellspacing="0">
                          <tr id="tapp1">
                        	  <td><input type="checkbox" id="app1" class="app1" value="1" /> &nbsp;Aprove 1</td>
                       	  </tr>
						  <tr id="tapp2">
                        	  <td><input type="checkbox" id="app2" class="app2" value="1" disabled="disabled" /> &nbsp;Aprove 2</td>
                       	  </tr>
                          <tr id="tapp3">
                        	  <td><input type="checkbox" id="app3" class="app3" value="1" disabled="disabled" /> &nbsp;Aprove 3</td>
                       	  </tr>
                        </table>  -->                </td>
                </tr>
                <tr>
                    <td align="center"><br /><input name="BtnValidasiLab" id="BtnValidasiLab" type="button" value="Simpan" class="tblBtn" onclick="SimpanValidasiLab()" /></td>
                </tr>
          </table>
        </div>
        
        <div id="divSampel" style="display:none;width:600px;" align="center" class="popup">
          <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td><img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right;cursor: pointer" /></td>
                </tr>
                <tr>
                    <td align="center">
                    	<table border="0" cellpadding="0" cellspacing="0">
                        	<tr>
                              <td class="txtinputNoBgColor">Tanggal Pengambilan&nbsp;</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td>&nbsp;<input id="tglPengambilan" name="tglPengambilan" readonly size="11" class="txtcenter" type="text" value="<?php if($tglGet=='') {
                                            echo $date_now;
                                        }
                                        else {
                                            echo $tglGet;
                                        }
                                        ?>" />&nbsp;<input type="button" name="btnTgl1" value="&nbsp;V&nbsp;" class="txtcenter" onclick="gfPop.fPopCalendar(document.getElementById('tglPengambilan'),depRange,tidak);"/></td>
                       	  </tr>
						  <tr>
                              <td class="txtinputNoBgColor">Jam (HH:MM)&nbsp;</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td>&nbsp;<input id="jamPengambilan" name="jamPengambilan" size="11" class="txtcenter" type="text" value="" /></td>
                       	  </tr>
                           <tr>
                              <td class="txtinputNoBgColor">Catatan Pasien&nbsp;</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td>&nbsp;<textarea id="txtNPasien" name="txtNPasien" class="txtinput" ></textarea></td>
                       	  </tr>
                          <tr>
                              <td class="txtinputNoBgColor">Catatan Lab&nbsp;</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td>&nbsp;<textarea id="txtNLab" name="txtNLab" class="txtinput" ></textarea></td>
                       	  </tr>
                        </table>                  </td>
                </tr>
                <tr>
                    <td align="center"><br /><input name="BtnSampel" id="BtnSampel" type="button" value="Simpan" class="tblBtn" onclick="SimpanSampel()" /></td>
                </tr>
          </table>
        </div>
        
        <div id="divWorkList" style="display:none;width:500px;" align="center" class="popup">
          <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td><img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right;cursor: pointer" /></td>
                </tr>
                <tr>
                    <td align="center">
                    <table border="0" cellpadding="0" cellspacing="0">
                        	<tr>
                              <td class="txtinputNoBgColor">Tanggal Periksa&nbsp;</td>
                              <td class="txtinputNoBgColor">&nbsp;<input id="txtTgl21" name="txtTgl21" readonly size="11" class="txtcenter" type="text" value="<?php if($tglGet=='') {
                                            echo $date_now;
                                        }
                                        else {
                                            echo $tglGet;
                                        }
                                        ?>" />&nbsp;<input type="button" name="btnTgl1" value="&nbsp;V&nbsp;" class="txtcenter" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl21'),depRange,tidak);"/></td>
                       	  </tr>
                          <tr>
                              <td class="txtinputNoBgColor">Dokter Pemeriksa&nbsp;</td>
                              <td class="txtinputNoBgColor">&nbsp;<select id="cmbDokRad" name="cmbDokRad" class="txtinput" onkeypress="" onchange="">
		<option value="">-Dokter-</option>
		</select>
		<label><input type="checkbox" id="chkDokterPenggantiRad" value="1" onchange="gantiDokter('cmbDokDiag',this.checked);"/>Dokter Pengganti</label></td>
                       	  </tr>
                          <tr>
                              <td class="txtinputNoBgColor">Keterangan&nbsp;</td>
                              <td class="txtinputNoBgColor">&nbsp;<textarea id="txtKetRad" name="txtKetRad" cols="33" rows="2" class="txtinput" ></textarea></td>
                       	  </tr>
                          <tr>
                              <td class="txtinputNoBgColor">&nbsp;</td>
                              <td class="txtinputNoBgColor">&nbsp;</td>
                       	  </tr>
                          <tr>
                              <td colspan="2" height="30" style=" background-color: #06F; color: #FFF;" align="center"><b>Jenis Pemeriksaan</b></td>
                       	  </tr>
                      </table>
                    	<table border="0" cellpadding="0" cellspacing="0">
                         <?
							  	$query1 = "SELECT * FROM b_ms_work_list WHERE aktif = 1";
								$dquery1 = mysql_query($query1);
								while($rquery1 = mysql_fetch_array($dquery1))
								{
						?>
                        	<tr>
                              <td class="txtinputNoBgColor">&nbsp;
                              		<input type="checkbox" name="workList" id="<? echo $rquery1['kode']?>" />&nbsp; <? echo $rquery1['nama']?>                              </td>
                       	  </tr>
                         <?
								}
						?>
                        </table>                  </td>
                </tr>
                <tr>
                    <td align="center"><br /><input name="saveworkList" id="saveworkList" type="button" value="Simpan" class="tblBtn" onclick="saveworkList()" /><br />
                    <input name="transferworkList" disabled="disabled" id="transferworkList" type="button" value="Transfer Menuju PACS" class="tblBtn" onclick="transferPACS()" />                    </td>
                </tr>
          </table>
        </div>
        
        <div id="divPacs" style="display:none;width:900px;" align="center" class="popup">
        <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right;cursor: pointer" />
          <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td align="right">&nbsp;
						<button onclick="setPacs()" id="set_pacs_id" style="margin-right:25px;">Set Pacs</button>					</td>
                </tr>
                <tr>
                	<td align="center">
						<span id="loadPacs" style="display:none; overflow:auto; background:white; margin-left: 10px; padding:50px 335px 50px 335px; opacity:0.5; position:absolute; margin-left:10px;"><img src="../icon/loading2.gif" alt="loading" height="100px"/></span>
                    	<div id="gridboxPacs" style="width:850px; height:170px; background-color:white;"></div>
            			<br/>
            			<div id="pagingPacs" style="width:850px;"></div>					</td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                </tr>
                <!--tr>
                	<td align="center">
                    	<div id="gridboxPacs_I" style="width:850px; height:170px; background-color:white;"></div>
            			<br/>
            			<div id="pagingPacs_I" style="width:850px;"></div>                    </td>
                </tr-->
                <tr>
                	<td>&nbsp;</td>
                </tr>
          </table>
        </div>
        
        <div id="divKetBatal" style="display:none;width:700px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="tutup_ket_batal()" style="float:right; cursor: pointer" />
                <fieldset><legend>Batal Berkunjung</legend>
                    <table border=0>
                        <tr>
                            <td width="162" align="right">Keterangan :</td>
                            <td >
                                <input type="text" size="60" id="ket_batal" name="ket_batal" class="txtinput" ></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="button" id="save_ket_batal" name="save_ket_batal" value="SIMPAN" onclick="simpan_batal();" class="tblBtn"/>
                                <input type="button" id="cancel_batal" name="cancel_batal" value="BATAL" onclick="tutup_ket_batal();" class="tblBtn"/>                            </td>
                        </tr>
                    </table>
                </fieldset>
    </div>
        
        <div id="divCheckList" style="display:none;width:850px" class="popup">
			<? include 'list_pasien_pulang/form_list_pasien_pulang.php'; ?>
		</div>
		<div id="divCheckListTerima" style="display:none;width:850px" class="popup">
			<? include '../report_rm/9.check_list_pnrmn.php'; ?>
		</div>
	</body>
	<script type="text/JavaScript" language="JavaScript" src="list_pasien_pulang/javascript_form_list_pasien_pulang.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../report_rm/listterima.js"></script>
    <!--script kunjungan-->
	<?php include("tindakan/labrad_script.php");?>
    <script type="text/JavaScript" language="JavaScript">
	var cabang = 1;
	function tidak(){
		return false;
	}
	jQuery(document).ready(function(){
		jQuery("#jamPengambilan").mask("99:99");
		var admin = <?php echo $admin; ?>;
		if(admin == 1){
			document.getElementById("UpdStatusPx").disabled=false;
			jQuery('#UpdStatusPx').removeAttr('disabled');
		} else {
			document.getElementById("UpdStatusPx").disabled=false;
		}
	});
	
	function showTindLab(val){
		if(val == 58){
			jQuery('#trTindakanLab').css('display', 'table-row');
			jQuery('#trTindakanRad').css('display', 'none');
			jQuery('#trMintaDarah').css('display', 'none');
		}else if(val == 61){
			jQuery('#trTindakanLab').css('display', 'none');
			jQuery('#trTindakanRad').css('display', 'table-row');
			jQuery('#trMintaDarah').css('display', 'none');
		}else if(val == 130){
			jQuery('#trMintaDarah').css('display', 'table-row');
			jQuery('#trTindakanLab').css('display', 'none');
			jQuery('#trTindakanRad').css('display', 'none');
		}else{
			jQuery('#trTindakanLab').css('display', 'none');
			jQuery('#trTindakanRad').css('display', 'none');
			jQuery('#trMintaDarah').css('display', 'none');
		}
	}
	
        var unitId=0;
        var inap,txtTgl,cmbTmpLay,cmbDilayani;
        var jenisUnitId=0;
        var getIdPasien,getIdPel,getIdKunj,getIdUnit,getIdKelas,getUmur,getKsoId,getKsoKelasId,getIdKelasKunj,getDilayani,getKelas_id,getKamarNama,getKamarId,getTgl_sjp,getTgl_Inap,getNoSJP,getNoJaminan,getNoPasien,getTglOut,getcNoSJPInap,getcTglSJP,getcTglSJPInap;
		<!-- =====tambahan dpjp + pav===== -->
		var getIsPenunjang;
        var getVerifikasi,getVerifikator;
		var idPelKonsul;
		var getJenisKunjungan;

	function disabledFilterPelayananKunjungan(){
		jQuery('#btnTgl').prop({ disabled : true });
		jQuery('#cmbJnsLay').prop({ disabled : true });
		jQuery('#cmbTmpLay').prop({ disabled : true });
		jQuery('#cmbDilayani').prop({ disabled : true });
		jQuery('#txtFilter').prop({ disabled : true });
		jQuery('#dtlPas').prop({ disabled : true });
		jQuery('#updtPas').prop({ disabled : true });
	}
	
	function enabledFilterPelayananKunjungan(){
		jQuery('#btnTgl').prop({ disabled : false });
		jQuery('#cmbJnsLay').prop({ disabled : false });
		jQuery('#cmbTmpLay').prop({ disabled : false });
		jQuery('#cmbDilayani').prop({ disabled : false });
		jQuery('#txtFilter').prop({ disabled : false });
	}
		
	function addLoadGridKunjungan(){
		disabledFilterPelayananKunjungan();
		jQuery('#gridbox-loading').css({ width : jQuery('#gridbox').width() , height : jQuery('#gridbox').height() });
		jQuery('#gridbox-loading').css({ display : 'block' });
	}
	
	function removeLoadGridKunjungan(){
		jQuery('#gridbox-loading').css({ display : 'none' });
		enabledFilterPelayananKunjungan();
	}

	function cekInap(label){
            //alert(label);
            if(label=='1'){
                document.getElementById('trTgl').style.visibility='collapse';
                document.getElementById('trDilayani').style.visibility='visible';
                document.getElementById('btnSetKamar').style.display='inline';
                document.getElementById('btnMRS').disabled=true;
                document.getElementById('btnVer').style.display='inline';
				document.getElementById('btnDarah').style.display='none';
				
				//bagus
                //document.getElementById('btnRujukRS').disabled=false;
				//jQuery('#btnRujukRS').removeAttr('disabled');
				
				//mTab.setTabCaption2("SOAPIER,DIAGNOSIS,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL LAB");
				//mTab.setTabCaptionWidth("180,180,180,180,180,0");
				//mTab.setTabDisplay("true,true,true,true,true,false,0");
				//document.getElementById('tab_laborat').style.display='none';
				//document.getElementById('tab_radiologi').style.display='none';
				//document.getElementById('btnIsiDataRM14').style.display='none';
				jQuery("#btnIsiDataRM14").hide();
				//jQuery("#soap1").show();
				//jQuery("#anam").hide();
				
				//Bagus
				//jQuery("#btnPasienPulang").show();
				jQuery("#btnPasienPulang").hide();
				jQuery("#btnIsiDataRM16").show();
				jQuery("#ctkVis").show();
				//-jQuery("#btnMutasi").hide();
				jQuery("#btnKonDok").show();
				jQuery("#rawatbersama").show();
            }
            else{
                document.getElementById('trTgl').style.visibility='visible';
                document.getElementById('trDilayani').style.visibility='visible';
                document.getElementById('btnSetKamar').style.display='none';
                document.getElementById('btnMRS').disabled = false;
				jQuery('#btnMRS').removeAttr('disabled');
                document.getElementById('btnVer').style.display='none';
				document.getElementById('btnDarah').style.display='none';
				
				//Bagus
                //document.getElementById('btnRujukRS').disabled=false;
				//jQuery('#btnRujukRS').removeAttr('disabled');
				
				/*mTab.setTabCaption2("ANAMNESIA,DIAGNOSA,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL LAB");
				mTab.setTabCaptionWidth("180,180,180,180,180,0");
				mTab.setTabDisplay("true,true,true,true,true,false,0");
				document.getElementById('tab_laborat').style.display='none';
				document.getElementById('tab_radiologi').style.display='none';*/
				jQuery("#btnIsiDataRM14").hide();
				//jQuery("#soap1").hide();
				//jQuery("#anam").show();
				jQuery("#btnPasienPulang").hide();
				jQuery("#btnIsiDataRM16").hide();
				jQuery("#ctkVis").hide();
				//-jQuery("#btnMutasi").show();
				jQuery("#btnKonDok").hide();
				jQuery("#rawatbersama").hide();
            }
        }
        
		function fChangeStatusPx(p){
			if (p=="1"){
				document.getElementById('trnosjp').style.visibility='collapse';
				document.getElementById('trNoJaminan').style.visibility='collapse';
				document.getElementById('trHakKelas').style.visibility='collapse';
				document.getElementById('trStatusPenj').style.visibility='collapse';
				document.getElementById('trnmPeserta').style.visibility='collapse';
				document.getElementById('spnTglSJP').innerHTML='Tgl Mulai Berubah';
			}else{
				document.getElementById('trnosjp').style.visibility='visible';
				document.getElementById('trNoJaminan').style.visibility='visible';
				document.getElementById('trHakKelas').style.visibility='visible';
				document.getElementById('trStatusPenj').style.visibility='visible';
				document.getElementById('trnmPeserta').style.visibility='visible';
				document.getElementById('spnTglSJP').innerHTML='Tgl SJP/SKP';
			}
			
			if (p=="38" || p=="39" || p=="46" || p=="53"){
				document.getElementById('cmbHakKelas').value=4;
			}
			
			/*if (p=="38" || p=="1"){
				document.getElementById('jenisKunj').innerHTML='<option value="1">Rawat Inap (RI)</option><option value="2">Semua (IGD,RJ,RI)</option>';
				document.getElementById('TglSJP').value=getTgl_Inap;
			}else{
				document.getElementById('jenisKunj').innerHTML='<option value="1">Rawat Inap (RI)</option>';
				document.getElementById('TglSJP').value=getTgl_Inap;
			}*/
			
			/*if (p=="1"){
				document.getElementById('jenisKunj').value=2;
				document.getElementById('TglSJP').value=getTgl_sjp;
			}else{*/
				document.getElementById('jenisKunj').value=1;
				document.getElementById('TglSJP').value=getTgl_Inap;
			//}
		}
        
		function goUpdtStatusPx(){
		var userId='<?php echo $_SESSION['userId']; ?>';
		var cstatusPx=document.getElementById('statusPx').value;
		var cTglSJP=document.getElementById('TglSJP').value;
		var cNoSJP=document.getElementById('NoSJP').value;
		var cNoJaminan=document.getElementById('NoJaminan').value;
		var ccmbHakKelas=document.getElementById('cmbHakKelas').value;
		var cStatusPenj=document.getElementById('StatusPenj').value;
		var cnmPeserta=document.getElementById('nmPeserta').value;
		var cJenisKunj=document.getElementById('jenisKunj').value;
			/*i++;
			if (i==6) i=1;
			fSetValue(window,"statusPx*-*"+i);
			fChangeStatusPx(document.getElementById('statusPx').value);*/
			var url="updtStatusPx_utils.php?idKunj="+getIdKunj+"&cstatusPx="+cstatusPx+"&cTglSJP="+cTglSJP+"&cNoSJP="+cNoSJP+"&cNoJaminan="+cNoJaminan+"&ccmbHakKelas="+ccmbHakKelas+"&cStatusPenj="+cStatusPenj+"&IdPasien="+getIdPasien+"&cnmPeserta="+cnmPeserta+"&cJenisKunj="+cJenisKunj+"&idPel="+getIdPel+"&idUser="+<?=$userId?>;
			//alert(url);
			document.getElementById('inpEvUpdt').innerHTML="";
			document.getElementById('BtnUpdtStatusPx').disabled=true;
			Request(url , "inpEvUpdt", "", "GET",evUpdtStatusPx,"");
		}
		
		function evUpdtStatusPx(){
			if (document.getElementById('inpEvUpdt').innerHTML=="" || document.getElementById('inpEvUpdt').innerHTML!="Proses Update Berhasil !"){
				alert("Update Status Pasien Gagal !");
			}else{
				alert(document.getElementById('inpEvUpdt').innerHTML);
			}
		}
		
		<!-- =====tambahan dpjp + pav===== -->
		function cekInputDPJP(){
			var cdpjp = document.getElementById('spn_dpjp').innerHTML;
			if (getIsPenunjang==1){
				alert("Unit Penunjang Tidak Boleh Mengubah Data DPJP !");
				return false;
			}
			cdpjp=cdpjp.replace('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',"");
			cdpjp=cdpjp.replace("[","");
			cdpjp=cdpjp.replace("]","");
			cdpjp=cdpjp.replace(/^\s+|\s+$/gm,'');
			//document.getElementById('txtSetNoSEP').value=nSEP;
			new Popup('divSetDPJP',null,{modal:true,position:'center',duration:1});
            document.getElementById('divSetDPJP').popup.show();
		}
		
		function SimpanInputDPJP(){
			var urlDPJP;
			var iDPJP = document.getElementById('cmb_dpjp').value;
			urlDPJP="updtDPJP_utils.php?act=update&idKunj="+getIdKunj+"&idPel="+getIdPel+"&dpjp="+iDPJP;
			//alert(urlDPJP);
			Request(urlDPJP, "resDPJP", "", "GET",function(){
				var tmpDPJP=document.getElementById('resDPJP').innerHTML;
				//alert(tmpDPJP);
				tmpDPJP=tmpDPJP.split("|");
				if (document.getElementById('resDPJP').innerHTML=="" || tmpDPJP[0]!="OK"){
					alert("Proses Update DPJP Gagal !");
				}else{
					document.getElementById('spn_dpjp').innerHTML="[ "+tmpDPJP[1]+" ]";
					alert("Proses Update DPJP Berhasil !");
				}
				
				document.getElementById('divSetDPJP').popup.hide();
			},"noLoad");
		}
		
		function ViewDPJP(){
			var urlDPJP="updtDPJP_utils.php?act=view&idKunj="+getIdKunj+"&idPel="+getIdPel;
			//alert(urlDPJP);
			document.getElementById('spn_dpjp').innerHTML="[&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]";
			Request(urlDPJP, "resDPJP", "", "GET",function(){
				var tmpDPJP=document.getElementById('resDPJP').innerHTML;
				//alert(tmpDPJP);
				tmpDPJP=tmpDPJP.split("|");
				if (tmpDPJP[0]=="OK"){
					document.getElementById('spn_dpjp').innerHTML="[ "+tmpDPJP[1]+" ]";
				}
				
			},"noLoad");
		}
		
		function PopUpdtStatus()
        {
			fSetValue(window,"statusPx*-*"+getKsoId+"*|*TglSJP*-*"+getTgl_sjp+"*|*NoSJP*-*"+getNoSJP+"*|*NoJaminan*-*"+getNoJaminan+"*|*cmbHakKelas*-*"+getKsoKelasId+"*|*StatusPenj*-*"+getStatusPenj+"*|*nmPeserta*-*"+getnmPeserta);
			/*if (getKsoId==39){
				fSetValue(window,"cmbHakKelas*-*4");
			}*/
			fChangeStatusPx(document.getElementById('statusPx').value);
            new Popup('divUpdtStatus',null,{modal:true,position:'center',duration:1});
            document.getElementById('divUpdtStatus').popup.show();
        }

        function cekSentPar(){
			//alert("<?php echo $_POST['sentPar']?>");
            if('<?php echo $_POST['sentPar']?>' != '' && '<?php echo isset($_POST['sentPar'])?>' == 1){
                var sentPar = '<?php echo $_POST['sentPar'];?>'.split('*|*');
				if(sentPar[5]!=1){
					document.getElementById('aharef').href = "http://<?php echo $_SERVER['HTTP_HOST'].$base_addr;?>/billing/informasi/riwayat_kunj.php";
				} else if(sentPar[5]==1){
					document.getElementById('aharef').href = "http://<?php echo $_SERVER['HTTP_HOST'].$base_addr;?>/billing/informasi/riwayat_kunj_rad.php";
				}
                document.getElementById('cmbJnsLay').value = sentPar[1];
                document.getElementById('txtTgl').value =  sentPar[3];
                document.getElementById('txtFilter').value = sentPar[0];
                isiCombo('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+sentPar[1],sentPar[2],'',evLang2);
                //document.getElementById('cmbTmpLay').value = sentPar[2];
            }
        }

        var a1;
        function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
			var idArr = targetId.split(',');
			var longArr = idArr.length;
			if(longArr > 1){
				for(var nr = 0; nr < longArr; nr++)
					if(document.getElementById(idArr[nr])==undefined){
						alert('Elemen target dengan id: \''+idArr[nr]+'\' tidak ditemukan!');
						return false;
					}
			}
			else{
				if(document.getElementById(targetId)==undefined){
					alert('Elemen target dengan id: \''+targetId+'\' tidak ditemukan!');
					return false;
				}
			}
			
			if(targetId=='cmbDokterUnit')
			{
				Request('../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId+"&cabang="+cabang,targetId,'','GET',evloaded);
			}else{
				Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId+"&cabang="+cabang,targetId,'','GET',evloaded);
			}
        }
        isiCombo('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+document.getElementById('cmbJnsLay').value,'','',evLang);
		
        function evLang(){
            //document.getElementById('cmbTmpLay').lang=document.getElementById('cmbTmpLay').value;
            //alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
            inap=document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
            //alert(inap);
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
			if (document.getElementById('cmbTmpLay').value==122 || document.getElementById('cmbTmpLay').value==123 || document.getElementById('cmbJnsLay').value==57){
				document.getElementById('btnFilter').style.display = 'inline-table';
			}else{
				document.getElementById('btnFilter').style.display = 'none';
			}
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
            txtTgl=document.getElementById('txtTgl').value;
            cmbTmpLay=document.getElementById('cmbTmpLay').value;
            cmbDilayani=document.getElementById('cmbDilayani').value;
            cekInap(inap);
			if(inap == 1){
				document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value=''>SEMUA</option><option value='-1'>SUDAH KELUAR</option>";
			}else{
				document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value='2'>BATAL BERKUNJUNG</option><option value=''>SEMUA</option>";
			}

            //document.getElementById('cmbTmpLay').lang=document.getElementById('cmbTmpLay').value;
          //  alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
            unitId=document.getElementById('cmbTmpLay').value;
            jenisUnitId=document.getElementById('cmbJnsLay').value;
			
            //unitId=document.getElementById('cmbTmpLay').value;
            jenisUnitId=document.getElementById('cmbJnsLay').value;
            showGrid();
			/* Edit Ajax ID Array */
            /* isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokRujukUnit');
			isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokRujukRS'); */
			isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokRujukUnit,cmbDokRujukRS');
			//isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokRujukUnit',cekLogPelaksana);
			
            isiCombo('cmbRS');
			//=====tambahan dpjp + pav=====
			isiCombo('cmbDokDPJP',unitId,'','cmb_dpjp');
			//isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokRujukRS',cekLogPelaksana);
            if(document.getElementById('cmbJnsLay').options[document.getElementById('cmbJnsLay').options.selectedIndex].lang=='1'){
                isiCombo('cmbCaraKeluar','','','cmbCaraKeluar',gantiCaraKeluar);
            }
            else{
                isiCombo('cmbCaraKeluar','APS','','cmbCaraKeluar',gantiCaraKeluar);
            }
			
			Request("pelayanankunjungan_utils.php?act=cmbDokterUnit&saring=true&no_rm=&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&inap="+inap+"&dilayani="+document.getElementById('cmbDilayani').value+"&jnsLay="+document.getElementById('cmbJnsLay').value,'cmbDokterUnit','','GET',cekLogPelaksanaB);
			//alert('1');
			
			//isiCombo('cmbDok',unitId,'<?php $userId; ?>','cmbDokterUnit',cekLogPelaksanaB);
			isiCombo('cmbIsiDataRM',document.getElementById('cmbTmpLay').value,'','cmbIsiDataRM',evCmbDataRM);
			cekPenunjang(document.getElementById('cmbJnsLay').value);
			cekLab(document.getElementById('cmbJnsLay').value);
        }
		
		function tampilKet(x){
			if(document.getElementById('cmbJnsLay').value=='57')
			{
				//document.getElementById('divketerangan').style.display = 'block';
			}
			else
			{
				document.getElementById('divketerangan').style.display = 'none';
			}
		}
		
		function gantiCaraKeluar(){
			//caraKeluar(document.getElementById('cmbCaraKeluar').value);
			isiCombo('cmbKeadaanKeluar',document.getElementById('cmbCaraKeluar').value,'','cmbKeadaanKeluar');	
		}
		function gantiKeadaanKeluar(){
			keadaanKeluar(document.getElementById('cmbKeadaanKeluar').value);	
		}
		
		function ActIsiDataRM(objRM,par){
			switch (objRM.id){
				case "btnSimpanIsiDataRM":	//action utk simpan data RM
					//alert('simpan isi data RM');
					
					//alert(document.getElementById('cmbIsiDataRM').value);napTerapi,stt_nikah,usia_pakai,akibat
					switch (document.getElementById('cmbIsiDataRM').value){
						case "1":	//---NAPZA---
							var trapi=document.getElementById('trapi').value;
							var sttKwn=document.getElementById('sttKwn').value;
							var napzaDigunakan=document.getElementById('napzaDigunakan').value;
							var usia=document.getElementById('usia').value;
							var akibat=document.getElementById('akibat').value;
							var id=document.getElementById('idMaster').value;
							grdRM.loadURL("../rm/napza_utils.php?grd=grdIsiDataRM&act="+par+"&idPel="+getIdPel+"&napTerapi="+trapi+"&stt_nikah="+sttKwn+"&usia_pakai="+usia+"&akibat="+akibat+"&napza="+napzaDigunakan+"&kunjId="+getIdKunj+"&id="+id,"","GET");
							break;
						case "2":	//---GIZI BURUK---
							var bb = document.getElementById('bb').value;
							var tb = document.getElementById('tb').value;
							var statusGizi = document.getElementById('statusGizi').value;
							var tindakan = document.getElementById('tindakan').value;
							var hasilTindakan = document.getElementById('hasilTindakan').value;
							var id = document.getElementById('txtId').value;
							grdRM.loadURL("../rm/gizi_buruk_utils.php?grd=grdIsiDataRM&act="+par+"&id="+id+"&kunjId="+getIdKunj+"&idPel="+getIdPel+"&bb="+bb+"&tb="+tb+"&status_gizi_id="+statusGizi+"&tindakan="+tindakan+"&hasil_tindakan_id="+hasilTindakan,"","GET");
							break;
							//pelaku,tgl,jam,tmpt,kekerasan,tipe
						case "3":	
							var pelaku=document.getElementById('pelaku').value;
							var tgl=document.getElementById('tgl').value;
							var jam=document.getElementById('jam').value;
							var tmpt=document.getElementById('tmpt').value;
							var kekerasan=document.getElementById('kekerasan').value;
							var id=document.getElementById('idKekerasan').value;
							var tipe=document.getElementById('tipe').value;
							grdRM.loadURL("../rm/kekerasan_pa_util.php?grd=grdIsiDataRM&act="+par+"&idPel="+getIdPel+"&pelaku="+pelaku+"&tgl="+tgl+"&jam="+jam+"&tmpt="+tmpt+"&kekerasan="+kekerasan+"&kunjId="+getIdKunj+"&id="+id+"&tipe="+tipe,"","GET");
							btlKekerasan();
							break;
						case "4":	//---CAMPAK---
							var dosis = document.getElementById('dosis').value;
							var vaks = document.getElementById('vaks').value;
							var tglDemam = document.getElementById('tglDemam').value;
							var tglRash = document.getElementById('tglRash').value;
							var vita = document.getElementById('vita').value;
							var keadaan = document.getElementById('keadaan').value;
							var id = document.getElementById('txtId').value;
							grdRM.loadURL("../rm/campak_utils.php?grd=grdIsiDataRM&act="+par+"&id="+id+"&kunjId="+getIdKunj+"&idPel="+getIdPel+"&dosis="+dosis+"&vaks="+vaks+"&tglDemam="+tglDemam+"&tglRash="+tglRash+"&vita="+vita+"&keadaan="+keadaan,"","GET");
							break;
						case "5":	//---Pneumonia---
							var resiko = document.getElementById('resiko').value;
							var id = document.getElementById('idResiko').value;
							grdRM.loadURL("../rm/pneumonia_util.php?grd=grdIsiDataRM&act="+par+"&id="+id+"&kunjId="+getIdKunj+"&idPel="+getIdPel+"&resiko="+resiko+"&id="+id,"","GET");
							btlPneumonia();
							break;
						case "6":	//---KB---
							var jenisKB=document.getElementById('cmbKontrasepsi').value;
							var baru=document.getElementById('cmbPeserta').value;
							var binaan=document.getElementById('cmbBinaan').value;
							var kbgagal=(document.getElementById('chkKBGagal').checked==true)?"1":"0";
							var efek=document.getElementById('cmbEfekSamping').value;
							var komplikasi=document.getElementById('cmbKomplikasi').value;
							var gantiKB=0;
							var KBdari=0;
							var KBke=0;
							if (document.getElementById('chkGantiKB').checked){
								gantiKB=1;
								KBdari=document.getElementById('cmbKontrasepsiLama').value;
								KBke=document.getElementById('cmbKontrasepsiBaru').value;
							}
							var infertil=document.getElementById('cmbInfertil').value;
							var id=document.getElementById('txtIdKB').value;
							//alert("../rm/kb_utils.php?grd=grdIsiDataRM&act="+par+"&idPel="+getIdPel+"&jenisKB="+jenisKB+"&baru="+baru+"&binaan="+binaan+"&kbgagal="+kbgagal+"&efek="+efek+"&komplikasi="+komplikasi+"&gantiKB="+gantiKB+"&KBdari="+KBdari+"&KBke="+KBke+"&infertil="+infertil+"&kunjId="+getIdKunj+"&id="+id);
							grdRM.loadURL("../rm/kb_utils.php?grd=grdIsiDataRM&act="+par+"&idPel="+getIdPel+"&jenisKB="+jenisKB+"&baru="+baru+"&binaan="+binaan+"&kbgagal="+kbgagal+"&efek="+efek+"&komplikasi="+komplikasi+"&gantiKB="+gantiKB+"&KBdari="+KBdari+"&KBke="+KBke+"&infertil="+infertil+"&kunjId="+getIdKunj+"&id="+id,"","GET");
							break;
						case "7":	//---MATERNAL PERINATAL---
							var idMaternal = document.getElementById('jeniskasus').value;
							//alert('maternal='+idMaternal);
							grdRM.loadURL("../rm/maternal_perinatal_utils.php?grd=grdIsiDataRM&act="+par+"&id="+id+"&kunjId="+getIdKunj+"&idPel="+getIdPel+"&idMaternal="+idMaternal,"","GET");
							break;
						case "8":	//---KIA---
							var idKia = document.getElementById('kia_jenis').value;
							var idKiaDetail = document.getElementById('kia_detail').value;
							//alert('maternal='+idMaternal);
							grdRM.loadURL("../rm/kia_utils.php?grd=grdIsiDataRM&act="+par+"&id="+id+"&kunjId="+getIdKunj+"&idPel="+getIdPel+"&idKia="+idKia+"&idKiaDetail="+idKiaDetail,"","GET");
							break;
						case "9":	//---ASUHAN GIZI ANAK---
							var txtId_asuhan_gizi_anak = document.getElementById('txtId_asuhan_gizi_anak').value;
							var txtbb = document.getElementById('txtbb').value;
							var txttb = document.getElementById('txttb').value;
							var txtbbtb = document.getElementById('txtbbtb').value;
							var txtAsupanMakan = document.getElementById('txtAsupanMakan').value;
							var txtKesan = document.getElementById('txtKesan').value;
							var txtAsuhanGiziLanjut = document.getElementById('txtAsuhanGiziLanjut').value;
							var txtDiagPeny = document.getElementById('txtDiagPeny').value;
							var txtDiitDokter = document.getElementById('txtDiitDokter').value;
							grdRM.loadURL("../rm/asuhan_gizi_anak_utils.php?grd=grdIsiDataRM&act="+par+"&id="+txtId_asuhan_gizi_anak+"&kunjId="+getIdKunj+"&idPel="+getIdPel+"&txtbb="+txtbb+"&txttb="+txttb+"&txtbbtb="+txtbbtb+"&txtAsupanMakan="+txtAsupanMakan+"&txtKesan="+txtKesan+"&txtAsuhanGiziLanjut="+txtAsuhanGiziLanjut+"&txtDiagPeny="+txtDiagPeny+"&txtDiitDokter="+txtDiitDokter,"","GET");
							batalAGA();
							break;
					}
					break;
				case "btnHapusIsiDataRM":
					switch (document.getElementById('cmbIsiDataRM').value){
					case '1':
						var id = document.getElementById('idMaster').value;
						grdRM.loadURL("../rm/napza_utils.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						btlnz();
						//grdRM.loadURL("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						break;
					case '2':
						var id = document.getElementById('txtId').value;
						grdRM.loadURL("../rm/gizi_buruk_utils.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						batalGB();
						//grdRM.loadURL("../rm/gizi_buruk_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//return false;
						break;
					case '3':
						var id = document.getElementById('idKekerasan').value;
						grdRM.loadURL("../rm/kekerasan_pa_util.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						btlKekerasan();
						//grdRM.loadURL("../rm/kekerasan_pa_util.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						break;
					case '4':
						var id = document.getElementById('txtId').value;
						grdRM.loadURL("../rm/campak_utils.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						batalCampak();
						//grdRM.loadURL("../rm/campak_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						break;
					case '5':
						var id = document.getElementById('idResiko').value;
						grdRM.loadURL("../rm/pneumonia_util.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						btlPneumonia();
						//grdRM.loadURL("../rm/pneumonia_util.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						break;
					case '6':
						var id = document.getElementById('txtIdKB').value;
						grdRM.loadURL("../rm/pneumonia_util.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						break;
					case '7':
						var id = document.getElementById('txtId').value;
						grdRM.loadURL("../rm/maternal_perinatal_utils.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						batalMP();
						//grdRM.loadURL("../rm/maternal_perinatal_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//return false;
						break;
					case '8':
						var id = document.getElementById('txtId').value;
						grdRM.loadURL("../rm/kia_utils.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						batalKIA();
						//grdRM.loadURL("../rm/kia_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//return false;
						break;
					case '9':
						var id = document.getElementById('txtId_asuhan_gizi_anak').value;
						grdRM.loadURL("../rm/asuhan_gizi_anak_utils.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						batalAGA();
						//grdRM.loadURL("../rm/kia_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//return false;
						break;
						}
					break;
					
				case "btnBatalIsiDataRM":
					switch (document.getElementById('cmbIsiDataRM').value){
					case '1':
						btlnz();
					break;
					case '2':
						batalGB();
					break;
					case '3':
						btlKekerasan();
					break;
					case '4':
						batalCampak();
					break;
					case '5':
						btlPneumonia();
					break;
					case '7':
						batalMP();
					break;
					case '8':
						batalKIA();
					break;
					case '9':
						batalAGA();
					break;
					}
					break;
			}
		}
		
		function evCmbDataRM(){
			switch (document.getElementById('cmbIsiDataRM').value){
				case "1" :	// NAPZA
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='500px';
					Request('../rm/napza.php?idPel='+getIdPel,'ContentRM','','GET');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='860px';
						grdRM.setColHeader("NO,TERAPI,STATUS NIKAH,NAPZA YG DIGUNAKAN,USIA PERTAMA PAKAI NAPZA,PENYEBAB NAPZA");
						grdRM.setIDColHeader(",terapi,status_nikah,napza,usia_pakai,akibat");
						grdRM.setColWidth("30,120,80,200,200,200");
						grdRM.setCellAlign("center,center,center,left,center,center");
						grdRM.attachEvent("onRowClick","tarikDataRM");
						grdRM.onLoaded(tarikDataRMLoad);
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel);
						grdRM.loadURL("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel)
					}
					break;
				case "2" :	// GIZI BURUK
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='500px';
					Request('../rm/gizi_buruk.php?idPel='+getIdPel,'ContentRM','','GET');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='800px';
						grdRM.setColHeader("NO,BB,TB,STATUS GIZI,TINDAKAN,HASIL");
						//grdRM.setIDColHeader(",terapi,status,napza,usia,penyebab,cara_pakai");
						grdRM.setColWidth("30,80,80,300,400,180");
						grdRM.setCellAlign("center,center,center,left,center,center");
						grdRM.attachEvent("onRowClick","ambilDataGiziBuruk");
						//grdRM.onLoaded(tarikDataRM);
						grdRM.loadURL("../rm/gizi_buruk_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
					}
					break;
					//KEKERASAN 
					case "3":
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='510px';
					Request('../rm/kekerasan_pa.php?idPel='+getIdPel,'ContentRM','','GET');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='880px';
						grdRM.setColHeader("NO,PELAKU,TANGGAL,TEMPAT KEJADIAN,KEKERASAN YG DIALAMI,KORBAN");
						grdRM.setIDColHeader(",pelaku,tgl,tempat,kekerasan,tipe_kekerasan");
						grdRM.setColWidth("30,120,100,200,300,100");
						grdRM.setCellAlign("center,center,center,left,left,center");
						grdRM.attachEvent("onRowClick","ambilId");
						grdRM.onLoaded(tarikDataRMLoad);
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel);
						grdRM.loadURL("../rm/kekerasan_pa_util.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel)
					}
					break;
				case "4" :	// Campak
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='500px';
					Request('../rm/campak.php?idPel='+getIdPel,'ContentRM','','GET');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='800px';
						grdRM.setColHeader("NO,DOSIS,VAKSINASI TERAKHIR,Tanggal Demam,Tanggal Rash,Vitamin A,Keadaan Sekarang");
						//grdRM.setIDColHeader(",terapi,status,napza,usia,penyebab,cara_pakai");
						grdRM.setColWidth("30,80,80,100,100,100,100");
						grdRM.setCellAlign("center,center,center,center,center,center,center");
						grdRM.attachEvent("onRowClick","ambilDataCampak");
						//grdRM.onLoaded(tarikDataRM);
						grdRM.loadURL("../rm/campak_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
					}
					break;
					case "5" :	// Pneumonia
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='400px';
					Request('../rm/pneumonia.php?idPel='+getIdPel,'ContentRM','','GET');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='560px';
						grdRM.setColHeader("NO,Faktor Resiko");
						grdRM.setIDColHeader(",faktor_resiko");
						grdRM.setColWidth("30,500");
						grdRM.setCellAlign("center,left");
						grdRM.attachEvent("onRowClick","ambilId1");
						grdRM.onLoaded(tarikDataRMLoad);
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel);
						grdRM.loadURL("../rm/pneumonia_util.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel)
					}
					break;
					case "6" :	// KB
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='520px';
					Request('../rm/kb.php?idPel='+getIdPel,'ContentRM','','GET');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='560px';
						grdRM.setColHeader("NO,Jenis Kontrasepsi,Peserta,Binaan,KB Gagal,Efek Samping,Komplikasi,Ganti KB,Infertil");
						grdRM.setIDColHeader(",jenis,peserta,binaan,kb_gagal,efek_samping,komplikasi,ganti_kb,infertil");
						grdRM.setColWidth("30,150,100,80,80,150,150,160,120");
						grdRM.setCellAlign("center,center,center,center,left,left,center,center,center");
						//grdRM.attachEvent("onRowClick","ambilIdKB");
						//grdRM.onLoaded(tarikDataRMLoad);
						//alert("../rm/kb_util.php?grd=grdIsiDataRM&idPel="+getIdPel);
						grdRM.loadURL("../rm/kb_util.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel)
					}
					break;
					case "7" :	// MATERNAL PERINATAL
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='400px';
					Request('../rm/maternal_perinatal.php?idPel='+getIdPel,'ContentRM','','GET');
					//isiCombo2('jnskasus','1','','jeniskasus');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='600px';
						grdRM.setColHeader("NO,Jenis Kesakitan, Jenis Kasus");
						//grdRM.setIDColHeader(",terapi,status,napza,usia,penyebab,cara_pakai");
						grdRM.setColWidth("50,200,200");
						grdRM.setCellAlign("center,left,left");
						grdRM.attachEvent("onRowClick","ambilDataMP");
						//grdRM.onLoaded(tarikDataRM);
						grdRM.loadURL("../rm/maternal_perinatal_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
					}
					break;
					case "8" :	// KIA
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='400px';
					Request('../rm/kia.php?idPel='+getIdPel,'ContentRM','','GET');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='600px';
						grdRM.setColHeader("NO,Jenis Pelayanan,Detail");
						//grdRM.setIDColHeader(",terapi,status,napza,usia,penyebab,cara_pakai");
						grdRM.setColWidth("50,200,200");
						grdRM.setCellAlign("center,left,left");
						grdRM.attachEvent("onRowClick","ambilDataKIA");
						//grdRM.onLoaded(tarikDataRM);
						grdRM.loadURL("../rm/kia_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
					}
					break;
					case "9" :	// ASUHAN GIZI ANAK
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='700px';
					Request('../rm/asuhan_gizi_anak.php?idPel='+getIdPel,'ContentRM','','GET');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='860px';
						grdRM.setColHeader("NO,BB,TB,BB/TB,ASUPAN MAKANAN,KESAN,ASUHAN GIZI LANJUT,DIAGNOSA PENYAKIT,DIIT DOKTER");
						grdRM.setIDColHeader(",,,,,,,,");
						grdRM.setColWidth("30,120,80,200,200,200,200,200,200");
						grdRM.setCellAlign("center,center,center,left,center,center,center,center,center");
						grdRM.attachEvent("onRowClick","ambilDataAGA");
						grdRM.onLoaded(tarikDataRMLoad);
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel);
						grdRM.loadURL("../rm/asuhan_gizi_anak_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel)
					}
					break;
			}
		}
		
		function GantiKBClick(){
			if (document.getElementById('chkGantiKB').checked){
				document.getElementById('trKbLama').style.visibility='visible';
				document.getElementById('trKbBaru').style.visibility='visible';
			}else{
				document.getElementById('trKbLama').style.visibility='collapse';
				document.getElementById('trKbBaru').style.visibility='collapse';
			}
		}
		
		function tarikDataRM(){
			sisipan=grdRM.getRowId(grdRM.getSelRow()).split("|");
			document.getElementById('idMaster').value=sisipan[0]
			document.getElementById('trapi').value=sisipan[3];
			document.getElementById('sttKwn').value=sisipan[5];
			document.getElementById('napzaDigunakan').value=sisipan[1];
			document.getElementById('usia').value=sisipan[4];
			document.getElementById('akibat').value=sisipan[2];
			document.getElementById('btnSimpanIsiDataRM').value='Update';
			document.getElementById('btnHapusIsiDataRM').disabled=false;
			jQuery('#btnHapusIsiDataRM').removeAttr('disabled');
		}
		
		function ambilId(){
		var sampingan = grdRM.getRowId(grdRM.getSelRow()).split("|");
		document.getElementById('idKekerasan').value = sampingan[0];
		document.getElementById('pelaku').value = sampingan[1];
		var tanggal=grdRM.cellsGetValue(grdRM.getSelRow(),3);
		var pecah=tanggal.split(" ")
		var t=pecah[0].split("-");
		var tglOk=t[2]+"-"+t[1]+"-"+t[0];
		var t2=pecah[1].split(":");
		var jmOk=t2[0]+":"+t2[1];
		document.getElementById('tgl').value=tglOk;
		document.getElementById('jam').value=jmOk;
		document.getElementById('tmpt').value=grdRM.cellsGetValue(grdRM.getSelRow(),4);
		document.getElementById('kekerasan').value=grdRM.cellsGetValue(grdRM.getSelRow(),5);
		document.getElementById('tipe').value=grdRM.cellsGetValue(grdRM.getSelRow(),6);
		document.getElementById('btnSimpanIsiDataRM').value='Update';
		document.getElementById('btnHapusIsiDataRM').disabled=false;
		jQuery('#btnHapusIsiDataRM').removeAttr('disabled');
		}
		
		function ambilId1(){
		var sampingan1 = grdRM.getRowId(grdRM.getSelRow()).split("|");
		document.getElementById('idResiko').value = sampingan1[0];
		document.getElementById('resiko').value = sampingan1[1];
		document.getElementById('btnSimpanIsiDataRM').value='Update';
		document.getElementById('btnHapusIsiDataRM').disabled=false;
		jQuery('#btnHapusIsiDataRM').removeAttr('disabled');
		}
		
		function ambilDataGiziBuruk(){
			var ids = grdRM.getRowId(grdRM.getSelRow()).split("|");
			document.getElementById('txtId').value = ids[0];
			//alert(ids[0]);
			var beratbadan = grdRM.cellsGetValue(grdRM.getSelRow(),2);
			var tinggibadan = grdRM.cellsGetValue(grdRM.getSelRow(),3);
			var statusgizi = grdRM.cellsGetValue(grdRM.getSelRow(),4);
			var tindakan = grdRM.cellsGetValue(grdRM.getSelRow(),5);
			var hasil = grdRM.cellsGetValue(grdRM.getSelRow(),6);
			document.getElementById('bb').value = beratbadan;
			document.getElementById('tb').value = tinggibadan;
			document.getElementById('statusGizi').value = statusgizi;
			document.getElementById('tindakan').value = tindakan;
			document.getElementById('hasilTindakan').value = hasil;
			document.getElementById('btnSimpanIsiDataRM').value = 'simpan';
			document.getElementById('btnHapusIsiDataRM').disabled = false;
			jQuery('#btnHapusIsiDataRM').removeAttr('disabled');
		}
		
		function ambilDataCampak(){
			var ids = grdRM.getRowId(grdRM.getSelRow()).split("|");
			document.getElementById('txtId').value = ids[0];
			//alert(ids[0]);
			var dosis = grdRM.cellsGetValue(grdRM.getSelRow(),2);
			var vaks = grdRM.cellsGetValue(grdRM.getSelRow(),3);
			var tglDemam = grdRM.cellsGetValue(grdRM.getSelRow(),4);
			var tglRash = grdRM.cellsGetValue(grdRM.getSelRow(),5);
			var vita = grdRM.cellsGetValue(grdRM.getSelRow(),6);
			var keadaan = grdRM.cellsGetValue(grdRM.getSelRow(),7);
			document.getElementById('dosis').value = dosis;
			document.getElementById('vaks').value = vaks;
			document.getElementById('tglDemam').value = tglDemam;
			document.getElementById('tglRash').value = tglRash;
			document.getElementById('vita').value = vita;
			document.getElementById('keadaan').value = keadaan;
			document.getElementById('btnSimpanIsiDataRM').value = 'simpan';
			document.getElementById('btnHapusIsiDataRM').disabled = false;
			jQuery('#btnHapusIsiDataRM').removeAttr('disabled');
		}
		
		function ambilDataKIA(){
			var ids = grdRM.getRowId(grdRM.getSelRow()).split("|");
			document.getElementById('txtId').value = ids[0];
			var idKiaJenis = ids[1];
			var idKiaDetail = ids[2];
			//alert(ids[0]+' '+ids[1]+' '+ids[2]);
			document.getElementById('kia_jenis').value = idKiaJenis;
			isiCombo2('detailKIA',idKiaJenis,'','kia_detail');
			document.getElementById('kia_detail').value = idKiaDetail;
			document.getElementById('btnSimpanIsiDataRM').value = 'simpan';
			document.getElementById('btnHapusIsiDataRM').disabled = false;
			jQuery('#btnHapusIsiDataRM').removeAttr('disabled');
			
			if(idKiaJenis==3 || idKiaJenis==5){
				document.getElementById('kiadetail').style.display = 'table-row';
			}
			else{
				document.getElementById('kiadetail').style.display = 'none';
			}
		}
		
		function ambilDataAGA(){
			var ids = grdRM.getRowId(grdRM.getSelRow()).split("|");
			document.getElementById('btnSimpanIsiDataRM').value = 'simpan';
			document.getElementById('btnHapusIsiDataRM').disabled = false;
			jQuery('#btnHapusIsiDataRM').removeAttr('disabled');
			
			document.getElementById('txtId_asuhan_gizi_anak').value=ids[0];
			document.getElementById('txtbb').value=grdRM.cellsGetValue(grdRM.getSelRow(),2);
			document.getElementById('txttb').value=grdRM.cellsGetValue(grdRM.getSelRow(),3);
			document.getElementById('txtbbtb').value=grdRM.cellsGetValue(grdRM.getSelRow(),4);
			document.getElementById('txtAsupanMakan').value=grdRM.cellsGetValue(grdRM.getSelRow(),5);
			document.getElementById('txtKesan').value=grdRM.cellsGetValue(grdRM.getSelRow(),6);
			document.getElementById('txtAsuhanGiziLanjut').value=grdRM.cellsGetValue(grdRM.getSelRow(),7);
			document.getElementById('txtDiagPeny').value=grdRM.cellsGetValue(grdRM.getSelRow(),8);
			document.getElementById('txtDiitDokter').value=grdRM.cellsGetValue(grdRM.getSelRow(),9);
		}
		
		function batalGB(){
			document.getElementById('bb').value = '';
			document.getElementById('tb').value = '';
			document.getElementById('statusGizi').value = '';
			document.getElementById('tindakan').value = '';
			document.getElementById('hasilTindakan').value = '';
			document.getElementById('btnSimpanIsiDataRM').value = 'tambah';
			document.getElementById('btnHapusIsiDataRM').disabled = true;
		}
		
		function batalMP(){
			document.getElementById('btnSimpanIsiDataRM').value = 'tambah';
			document.getElementById('btnHapusIsiDataRM').disabled = true;
		}
		
		function batalKIA(){
			document.getElementById('btnSimpanIsiDataRM').value = 'tambah';
			document.getElementById('btnHapusIsiDataRM').disabled = true;
		}
		
		function batalAGA(){
			document.getElementById('btnSimpanIsiDataRM').value = 'tambah';
			document.getElementById('btnHapusIsiDataRM').disabled = true;
			document.getElementById('txtId_asuhan_gizi_anak').value='';
			document.getElementById('txtbb').value='';
			document.getElementById('txttb').value='';
			document.getElementById('txtbbtb').value='';
			document.getElementById('txtAsupanMakan').value='';
			document.getElementById('txtKesan').value='';
			document.getElementById('txtAsuhanGiziLanjut').value='';
			document.getElementById('txtDiagPeny').value='';
			document.getElementById('txtDiitDokter').value='';
		}
		
		function batalCampak(){
			document.getElementById('dosis').value = '';
			document.getElementById('vaks').value = '';
			document.getElementById('tglDemam').value = '<?php echo $date_now; ?>';
			document.getElementById('tglRash').value = '<?php echo $date_now; ?>';
			document.getElementById('vita').value = '';
			document.getElementById('keadaan').value = '';
			document.getElementById('btnSimpanIsiDataRM').value = 'tambah';
			document.getElementById('btnHapusIsiDataRM').disabled = true;
		}
		
        function btlnz(){
			document.getElementById('')
			document.getElementById('btnHapusIsiDataRM').disabled=true;
			document.getElementById('btnSimpanIsiDataRM').value='Tambah';
		}
		
		function btlKekerasan(){
			document.getElementById('tgl').value='';
			document.getElementById('jam').value='';
			document.getElementById('tmpt').value='';
			document.getElementById('kekerasan').value='';
			document.getElementById('btnHapusIsiDataRM').disabled=true;
			document.getElementById('btnSimpanIsiDataRM').value='Tambah';
		}
		
		function btlPneumonia(){
			document.getElementById('btnHapusIsiDataRM').disabled=true;
			document.getElementById('btnSimpanIsiDataRM').value='Tambah';
		}
		
		function tarikDataRMLoad(key,val){
		var tangkap,proses,tombolSimpan,tombolHapus;
		//alert(val);
			if (val!=undefined && val!='' && val!='*|*'){
				tangkap=val.split("*|*");
				if(tangkap[0]=='tambah'){
					alert("Data berhasil disimpan...");
				}else{
					alert("Data berhasil diubah...");
				}
			}
		}   
		
		var rajall = 0;
		
		function evLang2(){
			addLoadGridKunjungan();
			var selCmbDilayani=0;
			if (document.getElementById('cmbDilayani')) selCmbDilayani=document.getElementById('cmbDilayani').options.selectedIndex;
			if (selCmbDilayani>2) selCmbDilayani=0;
	    	//tentangTarik();
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
			if (document.getElementById('cmbTmpLay').value==122 || document.getElementById('cmbTmpLay').value==123 || document.getElementById('cmbJnsLay').value==57){
				document.getElementById('btnFilter').style.display = 'inline-table';
			}else{
				document.getElementById('btnFilter').style.display = 'none';
			}
			
		/*	if(document.getElementById('cmbJnsLay').value==57)
			{
				document.getElementById('a_lab').style.display = 'none';////
			
			}else{
			
				document.getElementById('a_lab').style.display = 'none';
			} */
			
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
            inap=document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
			
			if(inap == 1){
				document.getElementById('btnMRS').style.display = 'none';
				rajall = 0;
				document.getElementById('UpdStatusPx').style.display = 'inline-table';
				document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value=''>SEMUA</option><option value='-1'>SUDAH KELUAR</option>";
				document.getElementById('spnCmbDokterUnit').style.display='none';
			}
			else{
				document.getElementById('btnMRS').style.display = 'inline-table';
				if (document.getElementById('cmbJnsLay').value==44){
					rajall = 0;
					document.getElementById('UpdStatusPx').style.display = 'inline-table';
				}else{
					rajall = 1;
					if(<?php echo $admin; ?> == 1){
						document.getElementById('UpdStatusPx').style.display = 'inline';
					} else {
						document.getElementById('UpdStatusPx').style.display = 'none';
					}
				}
				document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value='2'>BATAL BERKUNJUNG</option><option value=''>SEMUA</option>";
				document.getElementById('spnCmbDokterUnit').style.display='inline-table';
			}
			//alert(selCmbDilayani);
			document.getElementById('cmbDilayani').options.selectedIndex=selCmbDilayani;
			if('<?php echo isset($_POST['sentPar'])?>' == 0){
				document.getElementById('txtFilter').value = "";
			}
			else if('<?php echo isset($_POST['sentPar'])?>' == 1){
				var sentPar = "<?php echo $_POST['sentPar']?>".split('*|*');
				document.getElementById('cmbDilayani').value = sentPar[4];
			}
            txtTgl=document.getElementById('txtTgl').value;
            cmbTmpLay=document.getElementById('cmbTmpLay').value;
            cmbDilayani=document.getElementById('cmbDilayani').value;
            //document.getElementById('cmbTmpLay').lang=document.getElementById('cmbTmpLay').value;
            //alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
            unitId=document.getElementById('cmbTmpLay').value;
            jenisUnitId=document.getElementById('cmbJnsLay').value;
            cekInap(inap);
            saring();
            /* isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokRujukUnit',cekLogPelaksana);
			isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokRujukRS',cekLogPelaksana); */
			isiCombo('cmbDok',unitId,'','cmbDokTind',refreshDok);
			isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokRujukUnit,cmbDokRujukRS,cmbDokDiag,cmbDokResep,id_dokter,cmbDokRad',cekLogPelaksana);
			isiCombo('cmbRS');
            if(document.getElementById('cmbJnsLay').options[document.getElementById('cmbJnsLay').options.selectedIndex].lang=='1'){
                isiCombo('cmbCaraKeluar','','','cmbCaraKeluar',gantiCaraKeluar);
            }
            else{
                isiCombo('cmbCaraKeluar','APS','','cmbCaraKeluar',gantiCaraKeluar);
            }
            /* isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokTind',cekLogPelaksana);
            isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokDiag',cekLogPelaksana);
            isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokResep',cekLogPelaksana);
			isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','id_dokter',cekLogPelaksana);
			isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokRad',cekLogPelaksana); */
			//=====tambahan dpjp + pav=====
			isiCombo('cmbDokDPJP',unitId,'','cmb_dpjp');
			/*
			if(jenisUnitId==27){
			}
			*/
			cekPenunjang(document.getElementById("cmbTmpLay").value);
			
			Request("pelayanankunjungan_utils.php?act=cmbDokterUnit&saring=true&no_rm=&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&inap="+inap+"&dilayani="+document.getElementById('cmbDilayani').value+"&jnsLay="+document.getElementById('cmbJnsLay').value,'cmbDokterUnit','','GET',cekLogPelaksanaB);
			//isiCombo('cmbDok',unitId,'<?php $userId; ?>','cmbDokterUnit',cekLogPelaksanaB);
        }
	
		var dokter_tindakan='';
        function showGrid(){
			
            a1 = new DSGridObject("gridbox");
            a1.setHeader("DATA KUNJUNGAN PASIEN");
            a1.setColHeader("NO ANTRIAN,TGL,KETERANGAN,NO RM,NAMA,L/P,PENJAMIN,ASAL KUNJUNGAN,ALAMAT,T.LHR,NAMA ORTU");
            a1.setIDColHeader("no_antrian,,,no_rm,nama,,namakso,,,nama_ortu,alamat");
            a1.setColWidth("80,80,80,70,200,30,150,140,250,70,100");
            a1.setCellAlign("center,center,center,left,left,center,center,center,center,center,left");
            a1.setCellHeight(20);
            a1.setImgPath("../icon");
            a1.setIDPaging("paging");
            a1.attachEvent("onRowClick","ambilDataPasien");
            a1.attachEvent("onRowDblClick","detail");
            a1.onLoaded(ambilDataPasien);
	    //var no_rm = document.getElementById('txtFilter').value;
            //alert("pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+no_rm+"&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&dilayani="+document.getElementById('cmbDilayani').value);
            //alert("pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+document.getElementById('txtFilter').value+"&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&dilayani="+document.getElementById('cmbDilayani').value);
			a1.baseURL("pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+document.getElementById('txtFilter').value+"&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&dilayani="+document.getElementById('cmbDilayani').value+"&jnsLay="+document.getElementById('cmbJnsLay').value);
            a1.Init();
	    
	    	tariky = new DSGridObject("gridbox_tarik");
            tariky.setHeader("DATA KUNJUNGAN PASIEN");
            tariky.setColHeader("NO ANTRIAN,TGL,NO RM,NAMA,L/P,PENJAMIN,ASAL KUNJUNGAN,UNIT SEKARANG");
            tariky.setIDColHeader("no_antrian,,no_rm,nama,,,,");
            tariky.setColWidth("80,80,80,200,30,150,140,140");
            tariky.setCellAlign("center,center,center,left,center,center,center,center");
            tariky.setCellHeight(20);
            tariky.setImgPath("../icon");
            tariky.setIDPaging("paging_tarik");
            tariky.attachEvent("onRowClick","tarikDataPasien");
            tariky.attachEvent("onRowDblClick","getPas");
            tariky.onLoaded(tarikDataPasien);
            tariky.baseURL("pelayanankunjungan_utils.php?grd=tarik&no_rm="+document.getElementById('txtFilter').value+"&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&dilayani="+document.getElementById('cmbDilayani').value);
            tariky.Init();
			
	    	grdRM = new DSGridObject("grdIsiDataRM");
            grdRM.setHeader("DATA REKAM MEDIS");
            grdRM.setColHeader("NO,TERAPI,STATUS NIKAH,NAPZA YG DIGUNAKAN,USIA PERTAMA PAKAI NAPZA,PENYEBAB NAPZA,CARA PAKAI");
            //grdRM.setIDColHeader(",terapi,status,napza,usia,penyebab,cara_pakai");
            grdRM.setColWidth("30,80,80,200,30,150,140");
            grdRM.setCellAlign("center,center,center,left,center,center,center");
            grdRM.setCellHeight(20);
            grdRM.setImgPath("../icon");
            //grdRM.setIDPaging("paging_tarik");
            //grdRM.attachEvent("onRowClick","tarikDataPasien");
            //grdRM.onLoaded(tarikDataPasien);
            grdRM.baseURL("../rm/napza_utils.php?grd=grdIsiDataRM&idPel=0");
            grdRM.Init();
			
			pacs_S=new DSGridObject("gridboxPacs");
			pacs_S.setHeader("DATA SERIES SERVER PACS");
			pacs_S.setColHeader("NO,NO RM,KETERANGAN,VIEW,ID PACS,TANGGAL,WAKTU");
			pacs_S.setIDColHeader(",,,,,");
			pacs_S.setColWidth("50,100,250,60,400,100,100");
			pacs_S.setCellAlign("center,center,left,center,center,center,center");
			pacs_S.setCellHeight(20);
			pacs_S.setImgPath("../icon");
			pacs_S.onLoaded(detailPacs);
			//pacs_S.setIDPaging("pagingPacs");
			pacs_S.attachEvent("onRowClick","detailPacs");
			pacs_S.Init();
			
			pacs_I=new DSGridObject("gridboxPacs_I");
			pacs_I.setHeader("DATA IMAGE SERVER PACS");
			pacs_I.setColHeader("NO,TANGGAL,STUDY,FRAME,PIXEL MATRIX,VIEW");
			pacs_I.setIDColHeader(",,,,,");
			pacs_I.setColWidth("50,100,250,100,250,100");
			pacs_I.setCellAlign("center,center,left,center,left,center");
			pacs_I.setCellHeight(20);
			pacs_I.setImgPath("../icon");
			//pacs_S.onLoaded(konfirmasi);
			//pacs_I.setIDPaging("pagingPacs_I");
			pacs_I.attachEvent("onRowClick","");
			pacs_I.Init();
        }
	
	var getAllPosibilities = 0;
	
	function fSetFocus(obj){
		obj.setSelectionRange(0, 8);
	}
	
	function filterNoRM(ev,par){
		if(ev.which==13){
			if(isNaN(par.value) == true || par.value == ''){
				alert("Masukan Nomor Rekam Medis Dengan Benar !");
				return;
			}
			
			getAllPosibilities = 2;
			saring();
		}else if (par.value == ''){
			evLang2();
		}
	}
	
	function filter(ev,par){
	    var no_rm, local_getAllPosibilities;
	    if(ev.which==13 || ev.which == 1){
			if(ev.which == 1){
				no_rm = document.getElementById('txtFilter').value;
			}
			else if(ev.which == 13){
				no_rm = par.value;
			}
			else if(ev == 'pass'){
				no_rm = globNo_rm;
			}
		
			if(isNaN(no_rm) == true || no_rm == ''){
				alert("Masukan Nomor Rekam Medik dengan benar.");
				return;
			}
			if(par.id == 'txtNo'){
				local_getAllPosibilities = getAllPosibilities = 2;
			}
			else{
				local_getAllPosibilities = getAllPosibilities = 1;
			}
			no_rm = no_rm;
			Request("pelayanankunjungan_utils.php?grd=true&act=tarikMang&saring=true&no_rm="+no_rm+"&saringan="+txtTgl+"&tmpLay="+cmbTmpLay+"&inap="+inap+"&dilayani=", "spanTar1", "", "GET"
		, function(){
		    var tmp = document.getElementById('spanTar1').innerHTML;
		    //alert("pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+no_rm+"&saringan="+txtTgl+"&tmpLay="+cmbTmpLay+"&inap="+inap+"&dilayani=")
		    a1.loadURL("pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+no_rm+"&saringan="+txtTgl+"&tmpLay="+cmbTmpLay+"&inap="+inap+"&dilayani=","","GET");
		    
		    if(tmp == 0){
			if(local_getAllPosibilities == 1){
			    if(ev.which == 1){
				document.getElementById('tdTmp').innerHTML = ':&nbsp;&nbsp;'+document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].innerHTML;
				document.getElementById('tdJns').innerHTML = ':&nbsp;&nbsp;'+document.getElementById('cmbJnsLay').options[document.getElementById('cmbJnsLay').options.selectedIndex].innerHTML;
				
				if(inap == 1){
				    isiCombo('cmbKelasKamar',document.getElementById('cmbTmpLay').value,'','cmbKelas_ifinap',isiPindahKamar_ifinap);
				    document.getElementById('div_ifinap').style.display = 'block';
				}
				else{
				    document.getElementById('div_ifinap').style.display = 'none';
				}
				Request("pelayanankunjungan_utils.php?grd=tarik&act=tarikMang&no_rm="+no_rm,'spanTar1','', 'GET'
				, function(){
				    tmp = document.getElementById('spanTar1').innerHTML;
				    if(tmp > 0){
					//alert("pelayanankunjungan_utils.php?grd=tarik&no_rm="+no_rm+"&inapnya="+inap);
					tariky.loadURL("pelayanankunjungan_utils.php?grd=tarik&no_rm="+no_rm+"&inapnya="+inap,'','GET');
					new Popup('divTarikRujuk',null,{modal:true,position:'center',duration:1});
					document.getElementById('divTarikRujuk').popup.show();
				    }
				    else{
					alert("Pasien dengan no RM "+no_rm+" belum diregistrasi atau sudah dipulangkan, silahkan registrasi pasien terlebih dahulu.");
				    }
				}
				,'OK');
			    }
			}
			else{
			    alert("Pasien dengan Nomor Rekam Medik "+no_rm+" tidak ada.");
			    //document.getElementById('txtNo').value
			    no_rm = globNo_rm;
			    //a1.cellsGetValue(a1.getSelRow(),3);
			    document.getElementById('txtNo').value = no_rm;
			}
		    }
		}
		, 'OK');
	    }
	}
	
	function getPas(){
	    var unitAs = tariky.cellsGetValue(tariky.getSelRow(),8);
	    while(unitAs.search('&nbsp;') == true){
		unitAs = unitAs.replace('&nbsp;',' ');
	    }
	    var namPas = tariky.cellsGetValue(tariky.getSelRow(),4);
	    while(namPas.search('&nbsp;') == true){
		namPas = namPas.replace('&nbsp;',' ');
	    }
	    var unitTu = document.getElementById('tdTmp').innerHTML;
	    while(unitTu.search('&nbsp;') == true){
		unitTu = unitTu.replace('&nbsp;',' ');
	    }
	    unitTu = unitTu.replace('&nbsp;',' ');
	    var id = document.getElementById('act_tarik').value;
	    var teks;
	    if(id == 'btnSimpanKamar'){
			teks = " memindah kamar ";
	    }
	    else{
			teks = " merujuk ";
	    }
	    
	    if(confirm("Anda akan"+teks+namPas+", dari unit "+unitAs+", menuju Unit "+unitTu
		      +".\nAnda yakin?")){
		document.getElementById('txtFilter').value = '';
		var jamMasuk_ifinap = document.getElementById("JamMasuk_ifinap").value.replace(' ','');
		var tmp;
		if(inap == 1){
		    tmp = document.getElementById('cmbKamar_ifinap').options[document.getElementById('cmbKamar_ifinap').options.selectedIndex].lang;
		}
		var idKelas = document.getElementById('cmbKelas_ifinap').value;
		var idKamar = document.getElementById('cmbKamar_ifinap').value;
		var tglMasuk = document.getElementById('TglMasuk_ifinap').value;
		var jamMasuk = document.getElementById("jamServer").value.replace(' ','');
		var isManual = document.getElementById('chkManual_ifinap').checked==true?1:0;
		var userId = '<?php echo $_SESSION['userId']?>';
		var jnsLayKamar = document.getElementById('cmbJnsLay').value;
		var tmpLayKamar = document.getElementById('cmbTmpLay').value;
		var isDokPengganti = '';//document.getElementById('chkDokterPengganti_ifinap').checked==true?1:0;
		var ketRujukUnit = '';//document.getElementById('').value;
		var idDokRujukUnit = '';//document.getElementById('').value;
		var kamar = tariky.getRowId(tariky.getSelRow()).split("|");
		//alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang)
		if(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang == 1){
		  //->jika unit tujuan inap,maka harus validasi:
		  //1.perujuk bukan unit penunjang, eg. lab,rad,dsb
		  //2.jika dalam kunjungan tersebut terdapat kunjungan di unit inap lain yang tgl_out nya masih null (aktif)
		  //		, maka perujuknya harus unit tersebut.
		  if(kamar[16] == 1){//->penunjang
		    alert("Unit "+unitAs+" adalah unit penunjang, tidak bisa merujuk ke inap (MRS).");
		    return;
		  }
		  ///////////////////belum selesai,menunggu daftar unit inap yang tidak menutup kamar asal.
		  for(var i=0; i<tariky.getMaxRow(); i++){
		    var cari_perujuk_inap = tariky.getRowId(i+1).split("|");
		    //dalam looping ini mencari kunjungan pasien ke unit yang termasuk inap,
		    //jika ada maka harus unit itu yang jadi unit perujuk.
		    if(cari_perujuk_inap[17] == '' && cari_perujuk_inap[13] == 1){//--> jika tgl_out kosong & unit pasien merupakan inap
			   //if(cari_perujuk_inap[3] != kamar[3]){//->jika unit dari baris grid yang dipilih != unit baris grid yang dilooping
			   if(tariky.getSelRow() != i+1){//->jika baris grid yang dipilih != baris grid dalam looping
				    //cari_perujuk_inap[3]->unit data grid yang dilooping
				    //kamar[3]->unit baris grid yang dipilih (diklik)
				  var cari_unitAs = tariky.cellsGetValue(i+1,8);
				  if(cari_perujuk_inap[2] == kamar[2]){ //-> cek kunjungan_id sama atau tidak
				    //kalau kunjungan_id sama, maka untuk mrs/pindah kamar harus dari unit yang aktif (tempat pasien menginap sekarang)
				    alert("Kunjungan pasien "+namPas+" aktif di "+cari_unitAs+".\nUntuk MRS ke "+unitTu+", pilih "+cari_unitAs+" sebagai unit perujuk.");
				    return;
				  }
				  else{
				    //kalau kunjungan_id berbeda, maka muncul konfirmasi untuk tetap merujuk dari unit yang dipilih
				    //atau dari unit pasien aktif menginap.
				    if(confirm("Pasien "+namPas+" aktif menginap di "+cari_unitAs+" pada kunjungan lain.\nTetap merujuk dari "+unitAs+"?")){
					   
				    }
				    else{
					   return;
				    }
				  }
			   }
		    }
		  }
		}
		//jangan lupa dihapus kalo selesai
		//return;
	   //finish
		var url;
		switch(id){
		    case 'btnSimpanKamar':
			/*if(tariky.getRowId(tariky.getSelRow())!=''){
			    alert("Satu pasien hanya bisa dipindahkamarkan satu kali.");
			    return false;
			}*/
			if(idKamar == kamar[15]){//->id kamar tujuan & id kamar asal sama
			    alert("Anda tidak dapat memindahkamarkan pasien ke kamar yang sama.");
			    return false;
			}
			if(kamar[11] == 2){//->status dilayani
			    alert("Pasien ini sudah dipindahkamarkan ke kamar lain, tidak bisa dipindahkamarkan lagi.");
			    return false;
			}
			var tmp = document.getElementById('cmbKamar_ifinap').options[document.getElementById('cmbKamar_ifinap').options.selectedIndex].lang;
			//alert(jamMasuk);
			if(ValidateForm("JamMasuk_ifinap",'ind')){
			    var jamSplit=jamMasuk_ifinap.split(':');
			    if(jamSplit.length!=2){
					alert('Format Jam Salah!');
					return false;
			    }
			    if(isNaN(jamSplit[0]) || isNaN(jamSplit[1]) || jamSplit[0]=='' || jamSplit[1]==''  || jamSplit[0].length!=2 || jamSplit[1].length!=2){
					alert('Format Jam Salah!');
					return false;
			    }
			    jamMasuk_ifinap=jamMasuk_ifinap+':'+time[2];
			    getIdKelas=idKelas;
			    url = "tindiag_utils.php?grd4=true&act=tambah&kunjungan_id="+getIdKunj+"&smpn="+id+"&tarip="+tmp+"&ksoId="+getKsoId
				+"&pasienId="+getIdPasien+"&pelayanan_id="+getIdPel+"&kamar_id="+idKamar+"&kamar_lama="+kamar[15]+"&tglMasuk="+tglMasuk
				+"&jamMasuk="+jamMasuk_ifinap+"&isManual="+isManual+"&userId="+userId+"&unitAsal="+getIdUnit
				+"&tmpLayKamar="+tmpLayKamar+"&jnsLayKamar="+jnsLayKamar+"&kelasId="+idKelas+"&unit_id="+getIdUnit;
			}
			break;
		    case 'btnSimpanRujukUnit':                       
			if(inap==1){//document.getElementById('lgnJudul').innerHTML=='MRS'
			    if(kamar[11] == 2){
					alert("Pasien ini sudah dipindahkamarkan ke kamar lain, tidak bisa merujuk untuk inap lagi.");
					return false;
			    }
			    
				url = "tindiag_utils.php?grd2=true&isInap=1&act=tambah&smpn="+id+"&tarip="+tmp+"&kamar="+idKamar
				+"&pasienId="+getIdPasien+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&ket="+ketRujukUnit
				+"&idDok="+idDokRujukUnit+"&jnsLay="+jnsLayKamar+"&tmpLay="+tmpLayKamar+"&unitAsal="+getIdUnit
				+"&kelas="+idKelas+"&userId="+userId+"&isDokPengganti="+isDokPengganti+"&ksoId="+getKsoId;
			}
			else{
			    if(kamar[3] == tmpLayKamar){
					alert("Pasien ini sudah terdaftar di unit anda.");
					return false;
			    }
			    
				url = "tindiag_utils.php?grd2=true&isInap=0&act=tambah&smpn="+id
				+"&kunjungan_kelas_id="+getIdKelasKunj+"&kelas_id="+getKelas_id+"&pasienId="+getIdPasien
				+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&ket="+ketRujukUnit+"&idDok="+idDokRujukUnit
				+"&jnsLay="+jnsLayKamar+"&tmpLay="+tmpLayKamar+"&unitAsal="+getIdUnit+"&unit_pelaksana="+getIdUnit
				+"&kelas="+idKelas+"&ksoId="+getKsoId+"&ksoKelasId="+getKsoKelasId+"&userId="+userId
				+"&isDokPengganti="+isDokPengganti;
			}
			break;
		}
		//alert(url);
		Request(url+"&pullMR=tarikMang","spanTar1",'',"GET",closePop,'OK');
	    }
	}
	
	function closePop(){
	    document.getElementById('divTarikRujuk').popup.hide();
	    saring();
	}
	
	function tarikDataPasien(par){
            if(tariky.getRowId(tariky.getSelRow())!=''){
                var sisip=tariky.getRowId(tariky.getSelRow()).split("|");
                getIdPasien=sisip[0]; //id pasien;
                getIdPel=sisip[1]; //id pelayanan;
                getIdKunj=sisip[2]; //id kunjungan;
                getIdUnit=sisip[3]; //id unit;
                getIdKelas=sisip[4]; //id kelas;
                getUmur=sisip[5]; //umur pasien;
                getKsoId=sisip[6];
                getKsoKelasId=sisip[7];
                getKepemilikan=sisip[8];
                getIdKelasKunj=sisip[10];
                getInap = sisip[13];
                getKelas_id = sisip[12]; //kelas id
                getDilayani=sisip[11];
		
		document.getElementById('trpindah1').style.display = 'none';
		document.getElementById('trpindah2').style.display = 'none';
	       if(getInap == 1){
		    if(getInap == inap){
			// 1 = 1 -> inap ke inap = pindah kamar
			document.getElementById('trpindah1').style.display = 'table-row';
			document.getElementById('trpindah2').style.display = 'table-row';
			document.getElementById('act_tarik').value = "btnSimpanKamar";
		    }
		    else{
			// 1 != 0 -> inap ke jalan = rujuk
			//document.getElementById('lgnJudul').innerHTML=='non-MRS';
			document.getElementById('act_tarik').value = "btnSimpanRujukUnit";
		    }
	       }
	       else{
		    if(getInap == inap){
			// 0 = 0 -> jalan ke jalan = rujuk
			//document.getElementById('lgnJudul').innerHTML=='non-MRS';
			document.getElementById('act_tarik').value = "btnSimpanRujukUnit";
		    }
		    else{
			// 0 = 1 -> jalan ke inap = rujuk inap
			//document.getElementById('lgnJudul').innerHTML=='MRS';
			document.getElementById('act_tarik').value = "btnSimpanRujukUnit";
		    }
		}
	    }
	}

	var globNo_rm = '';
	var asalmasuk,getIdDokPerujuk,getIdDokTujuan1,getBatal;
	function ambilDataPasien(key,val){
		removeLoadGridKunjungan();
		// alert("<?php echo ",".$idKsoJR.","; ?>".indexOf(','+getKsoId+','));
		var tmp;
		//var xxx;
		//alert('asd');
		//alert("key="+key+", val="+val);
		if (val!=undefined){
			tmp=val.split("*|*");
			if (tmp[1]!=""){
				alert(tmp[1]);
			}
		}
		
		hslexpertise();
		
		var admin = <? echo $admin;?>;
		
		jQuery("#jamDiagB").mask("99:99");
		
		time=document.getElementById('jamServer').value.split(':');
		var tjam=parseInt((time[0].substr(0,1)=='0')?time[0].substr(1,1):time[0]);
		var tmenit=parseInt((time[1].substr(0,1)=='0')?time[1].substr(1,1):time[1]);
		var tdetik=parseInt((time[2].substr(0,1)=='0')?time[2].substr(1,1):time[2]);
		
		jQuery("#jamDiagB").val(tjam+":"+tmenit);
		
		
		if(admin==1)
		{
			jQuery("#tglJamDiag").show();
		}else{
			//alert(admin);
			jQuery("#tglJamDiag").hide();
		}
		
		document.getElementById('ctkLabRadPerKonsul').style.visibility='collapse';
		document.getElementById('cetak_rujuk').style.visibility='collapse';
		//-document.getElementById("btnMutasi").disabled=false;///
		//-jQuery("#btnMutasi").hide();
		amplopradio();
		
		//alert(a1.getRowId(a1.getSelRow()));
		
		jQuery("#rawatbersama").load("rawat_bersama.php?cek=true&id_pelayanan="+getIdPel);
		
		if(a1.getRowId(a1.getSelRow())!=''){
			
			var sisip=a1.getRowId(a1.getSelRow()).split("|");
			var admin = <?php echo $admin; ?>;
			cabang = sisip[40];
			idPelKonsul = sisip[30];
			getIdDokTujuan1 = sisip[31];
			
			//alert(sisip[29]);
			
			if(sisip[29]==1)
			{
				document.getElementById("btnCekOut").disabled=true;
				if(admin==1){
					document.getElementById("btnCCekOut").disabled=false;
					jQuery('#btnCCekOut').removeAttr('disabled');
				}
				//-document.getElementById("btnMutasi").disabled=false;
				//-jQuery('#btnMutasi').removeAttr('disabled');
				if(document.getElementById("cmbTmpLay").value == 61)
				{
					document.getElementById("btnTmbh").disabled=false;
				}else{
					document.getElementById("btnTmbh").disabled=false;//mael
				}
			}else{
				document.getElementById("btnCekOut").disabled=false;
				jQuery('#btnCekOut').removeAttr('disabled');
				if(admin==1){
					document.getElementById("btnCCekOut").disabled=true;
				}
				//-document.getElementById("btnMutasi").disabled=false;///
				document.getElementById("btnTmbh").disabled=false;
				//jQuery('#btnTmbh').removeAttr('disabled');//mael
			}
			
			
			asalmasuk = sisip[27];
			getIdDokPerujuk = sisip[28];
			getInap = sisip[13];
			getDilayani=sisip[11];
			//alert(a1.cellsGetValue(a1.getSelRow(),2));
			var regex = /(<([^>]+)>)/ig;
			/*var txtNo = a1.cellsGetValue(a1.getSelRow(),4);
			txtNo = txtNo.replace(regex, "");*/
			var p = '';
			
			getIdPasien=sisip[0]; //id pasien;
			getIdPel=sisip[1]; //id pelayanan;
			getIdKunj=sisip[2]; //id kunjungan;
			getIdUnit=sisip[3]; //id unit;
			getIdKelas=sisip[4]; //id kelas;
			getUmur=sisip[5]; //umur pasien;
			getKsoId=sisip[6];
			getKsoKelasId=sisip[7];
			getKepemilikan=sisip[8];
			getIdKelasKunj=sisip[10];
			getNoPasien=a1.cellsGetValue(a1.getSelRow(),4);
			
			getKelas_id = sisip[12]; //kelas id
			
			getKamarId = sisip[15];// = kamar_id;
			//sisip[16] = kamar_nama;
			<!-- =====tambahan dpjp + pav===== -->
			getIsPenunjang = sisip[18];
			//=========tambahan by joker==================
			getIsPenunjang = sisip[18];
			getTgl_sjp = sisip[19];
			Request('pelayanankunjungan_utils.php?act=getTglInap&idKunj='+getIdKunj,'spnTglInap','','GET',
				function(){
					getTgl_Inap = document.getElementById('spnTglInap').innerHTML;
				},'ok');
			//xxx=a1.cellsGetValue(a1.getSelRow(),2).split(" ");
			//getTgl_Inap = xxx[0];
			getNoSJP = sisip[20];
			getcTglSJP = sisip[37];
			getcTglSJPInap = sisip[38];
			getcNoSJPInap = sisip[39];
			
			getNoJaminan = sisip[21];
			getStatusPenj = sisip[22];
			getnmPeserta = sisip[23];
			//=========tambahan==================
			//=========tambahan by fidi untuk tombol verifikasi=========//
			getVerifikasi = sisip[24];
			getVerifikator = sisip[25];
			getTglOut = sisip[26];
			
			if(sisip[32] == 1)
			{
				getBatal = sisip[32];				
			}else{
				getBatal = "";
			}
			getJenisKunjungan = sisip[34];
			
			if(getInap == 1 && getDilayani == 1){
			/*p ="txtNo*-*"+a1.cellsGetValue(a1.getSelRow(),4).replace(regex, "")+"*|*txtNama*-*"+a1.cellsGetValue(a1.getSelRow(),5)+"*|*txtTglLhr*-*"+a1.cellsGetValue(a1.getSelRow(),11)+"*|*txtUmur*-*"+sisip[5]+"*|*txtSex*-*"+a1.cellsGetValue(a1.getSelRow(),6)+"*|*txtOrtu*-*"+a1.cellsGetValue(a1.getSelRow(),12)+"*|*txtPelUnit*-*"+sisip[9]+"*|*nomorLab*-*"+sisip[14];*/
				if(document.getElementById('cmbDilayani').value=='-1' || document.getElementById('cmbDilayani').value==''){
					p ="txtNo*-*"+a1.cellsGetValue(a1.getSelRow(),4).replace(regex, "")+"*|*txtNama*-*"+a1.cellsGetValue(a1.getSelRow(),5).replace(regex, "")+"*|*txtTglLhr*-*"+a1.cellsGetValue(a1.getSelRow(),10).replace(regex, "")+"*|*txtUmur*-*"+sisip[5]+"*|*txtAgama*-*"+sisip[35]+"*|*txtSex*-*"+a1.cellsGetValue(a1.getSelRow(),6).replace(regex, "")+"*|*txtOrtu*-*"+a1.cellsGetValue(a1.getSelRow(),11).replace(regex, "")+"*|*txtPelUnit*-*"+sisip[9]+"*|*nomorLab*-*"+sisip[14];	
				}
				else{
					p ="txtNo*-*"+a1.cellsGetValue(a1.getSelRow(),4).replace(regex, "")+"*|*txtNama*-*"+a1.cellsGetValue(a1.getSelRow(),5).replace(regex, "")+"*|*txtTglLhr*-*"+a1.cellsGetValue(a1.getSelRow(),11).replace(regex, "")+"*|*txtUmur*-*"+sisip[5]+"*|*txtAgama*-*"+sisip[35]+"*|*txtSex*-*"+a1.cellsGetValue(a1.getSelRow(),6).replace(regex, "")+"*|*txtOrtu*-*"+a1.cellsGetValue(a1.getSelRow(),12).replace(regex, "")+"*|*txtPelUnit*-*"+sisip[9]+"*|*nomorLab*-*"+sisip[14];
				}
			}
			else{
			/*p ="txtNo*-*"+a1.cellsGetValue(a1.getSelRow(),4)+"*|*txtNama*-*"+a1.cellsGetValue(a1.getSelRow(),5)+"*|*txtTglLhr*-*"+a1.cellsGetValue(a1.getSelRow(),10)+"*|*txtUmur*-*"+sisip[5]+"*|*txtSex*-*"+a1.cellsGetValue(a1.getSelRow(),6)+"*|*txtOrtu*-*"+a1.cellsGetValue(a1.getSelRow(),11)+"*|*txtPelUnit*-*"+sisip[9]+"*|*nomorLab*-*"+sisip[14];*/
				p ="txtNo*-*"+a1.cellsGetValue(a1.getSelRow(),4).replace(regex, "")+"*|*txtNama*-*"+a1.cellsGetValue(a1.getSelRow(),5).replace(regex, "")+"*|*txtTglLhr*-*"+a1.cellsGetValue(a1.getSelRow(),10).replace(regex, "")+"*|*txtUmur*-*"+sisip[5]+"*|*txtSex*-*"+a1.cellsGetValue(a1.getSelRow(),6).replace(regex, "")+"*|*txtOrtu*-*"+a1.cellsGetValue(a1.getSelRow(),11).replace(regex, "")+"*|*txtPelUnit*-*"+sisip[9]+"*|*nomorLab*-*"+sisip[14]+"*|*txtAgama*-*"+sisip[35];
			}
			
			//alert('masuk1');
			//alert(getKsoId);
			if (getKsoId==<?php echo $idKsoBPJS; ?>){
				document.getElementById('trGrouper').style.display = 'table-row';
				if (sisip[36]=="-"){
					document.getElementById('spnGrouper').innerHTML="[&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+sisip[36]+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]";
				}else{
					document.getElementById('spnGrouper').innerHTML="[ "+sisip[36]+" ]";
				}
			}else{
				document.getElementById('trGrouper').style.display = 'none';
			}
			
			if(getInap == 1){
				document.getElementById('spanKam').innerHTML = " &nbsp;&nbsp;Kamar : "+sisip[16];
				//if(getKsoId==<?php echo $idKsoJR; ?>){
				if("<?php echo ",".$idKsoJR.","; ?>".indexOf(','+getKsoId+',')>-1){
					Request("updtPlatfon_utils.php?act=view&idKunj="+getIdKunj, "resPlatfon", "", "GET",function(){
						document.getElementById('nPlatfon').innerHTML=document.getElementById('resPlatfon').innerHTML;	
					},"noLoad");
					document.getElementById('trPlatfon').style.display = 'table-row';
				}
				else{
					document.getElementById('trPlatfon').style.display = 'none';
				}
				
				//cekJmlTind();
				
				if (getcNoSJPInap==""){
					document.getElementById('spnNoSEP').innerHTML="[&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]";
					//document.getElementById('txtSetTglSEP').value=getcTglSJP;
					document.getElementById('txtSetTglSEP').value="";
					document.getElementById('txtSetNoSEP').value="";
				}else{
					document.getElementById('spnNoSEP').innerHTML="[ "+getcNoSJPInap+" ]";
					document.getElementById('txtSetTglSEP').value=getcTglSJPInap;
					document.getElementById('txtSetNoSEP').value=getcNoSJPInap;
				}
			}
			else{
				// alert('lalilu');
				document.getElementById('spanKam').innerHTML = "";
				//document.getElementById('trGrouper').style.display = 'none';
				document.getElementById('trPlatfon').style.display = 'none';
				
				if (getNoSJP==""){
					document.getElementById('spnNoSEP').innerHTML="[&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]";
					document.getElementById('txtSetTglSEP').value="";
					document.getElementById('txtSetNoSEP').value="";
				}else{
					document.getElementById('spnNoSEP').innerHTML="[ "+getNoSJP+" ]";
					document.getElementById('txtSetTglSEP').value=getcTglSJP;
					document.getElementById('txtSetNoSEP').value=getNoSJP;
				}
			}
			
			fSetValue(window,p);
			document.getElementById('txtNoTelp').value=sisip[33];
			//alert('masuk');
			
			if(getInap == 1 && getDilayani == 1){
				if(document.getElementById('cmbDilayani').value=='-1' || document.getElementById('cmbDilayani').value==''){
					document.getElementById('txtAlmt').innerHTML=a1.cellsGetValue(a1.getSelRow(),9).replace(regex, "");
				}
				else{
					document.getElementById('txtAlmt').innerHTML=a1.cellsGetValue(a1.getSelRow(),10).replace(regex, "");		
				}
			}
			else{
				document.getElementById('txtAlmt').innerHTML=a1.cellsGetValue(a1.getSelRow(),9).replace(regex, "");
			}
			
			cekVerifikasi();
			cekLockRM();
			cekKonsen();
			//===================================================//
			isiCombo('cmbKamar',getIdUnit+','+getIdKelas);
			//alert(getIdUnit);
			//isiCombo('JnsLayanan','',document.getElementById('cmbJnsLay').value,'',isiTmpLayanan);
			if(sisip[18] == 1){
				document.getElementById('btnMRS').disabled = true;
			}
			else{
				document.getElementById('btnMRS').disabled = false;
				jQuery('#btnMRS').removeAttr('disabled');
			}
			
			if(getInap == 1 && getDilayani == 1){
				if(document.getElementById('cmbDilayani').value=='-1' || document.getElementById('cmbDilayani').value==''){
					document.getElementById('tdStat').innerHTML = '<blink>'+a1.cellsGetValue(a1.getSelRow(),7).replace(regex, "")+'</blink>';
				}
				else
				{
					document.getElementById('tdStat').innerHTML = '<blink>'+a1.cellsGetValue(a1.getSelRow(),8).replace(regex, "")+'</blink>';	
				}
			}
			else{
				document.getElementById('tdStat').innerHTML = '<blink>'+a1.cellsGetValue(a1.getSelRow(),7).replace(regex, "")+'</blink>';
			}
	
			if(getInap == 1){
				document.getElementById('spanKam').innerHTML = " &nbsp;&nbsp;Kamar : "+sisip[16];
			}
			else{
				document.getElementById('spanKam').innerHTML = "";
			}
			//isiTmpLayanan();
			isiTmpLayananMutasi();

			isiCombo('cmbKelasKamar',document.getElementById('cmbTL').value,sisip[4],'cmbKelas',isiPindahKamar);

			isiCombo('JnsLayananDenganInap','',document.getElementById('cmbJnsLay').value,'cmbJL',isiCmbTL);

			if(getDilayani==1 || getDilayani == 2){
				//document.getElementById('btnMutasi').disabled=true;
			}
			else{
				//document.getElementById('btnMutasi').disabled=false;
			}
                
			if(getIdUnit=='58' || getIdUnit=='59'){
				document.getElementById('btnLab').disabled = false;
				jQuery('#btnLab').removeAttr('disabled');
				document.getElementById('divLab').style.display = 'block';
			}
			else{
				document.getElementById('btnLab').disabled = true;
				document.getElementById('divLab').style.display = 'none';
			}

			if(getIdUnit=='45'){//jika unit IGD
				isiCombo('cmbKasusIGD','','','cmbKasus');
				isiCombo('cmbEmergency');
				isiCombo('cmbKondisiPasien');
				document.getElementById('trEmergency').style.visibility='visible';
				document.getElementById('trKondisiPasien').style.visibility='visible';
			}
			else{
				document.getElementById('cmbKasus').innerHTML='<option value="1">Baru</option><option value="0">Lama</option>';
				document.getElementById('trEmergency').style.visibility='collapse';
				document.getElementById('trKondisiPasien').style.visibility='collapse';
			}
			
			
			//alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
		   	if(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang=='1'){
				if(getDilayani!='0'){
					document.getElementById('dtlPas').disabled=false;
					jQuery('#dtlPas').removeAttr('disabled');
					document.getElementById('updtPas').disabled=true;
				}
				else{
					document.getElementById('dtlPas').disabled=true;
					document.getElementById('updtPas').disabled=false;
					jQuery('#updtPas').removeAttr('disabled');
				}
			}
			else{
				document.getElementById('dtlPas').disabled=false;
				jQuery('#dtlPas').removeAttr('disabled');
				document.getElementById('updtPas').disabled=true;
			}
		
			//alert("tindiag_utils.php?grd1=true&pelayanan_id="+sisip[1]);
			f.loadURL("tindiag_utils.php?grd=true&pelayanan_id="+sisip[1],"","GET");
			//alert("tindiag_utils.php?grd1=true&pelayanan_id="+sisip[1]);
			b.loadURL("tindiag_utils.php?grd1=true&pelayanan_id="+sisip[1]+"&kunjungan_id="+sisip[2],"","GET");
			c.loadURL("tindiag_utils.php?grd2=true&kunjungan_id="+sisip[2]+"&unitAsal="+getIdUnit+"&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage(),"","GET");
            
			//alert("tindiag_utils.php?grd3=true&kunjungan_id="+sisip[2]+"&pelayanan_id="+sisip[1]);
			d.loadURL("tindiag_utils.php?grd3=true&kunjungan_id="+sisip[2]+"&pelayanan_id="+sisip[1],"","GET");
			e.loadURL("tindiag_utils.php?grd4=true&kunjungan_id="+sisip[2]+"&unit_id="+sisip[3],"","GET");
			//resep
			//r.loadURL("tindiag_utils.php?grdResep=true&pelayanan_id="+sisip[1],"","GET");
			aResep.loadURL("tindiag_utils.php?grdRsp1=true&pelayanan_id="+sisip[1],"","GET");
			bhp.loadURL("bhp_utils.php?pelayanan_id_bhp="+sisip[1],"","GET");
			
			kd.loadURL("kondok_utils.php?pelayanan_id="+sisip[1],"","GET");
			
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokTind',refreshDok);
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokDiag,cmbDokResep,cmbDokHsl,cmbDokHslRad,cmbDokAnamnesa',cekLogPelaksana);
			/* isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokTind',cekLogPelaksana);
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokDiag',cekLogPelaksana);
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokResep',cekLogPelaksana);
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokHsl',cekLogPelaksana);
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokHslRad',cekLogPelaksana);
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokAnamnesa',cekLogPelaksana); */
			
			Request('riwayat_alergi_util.php?act=view_last&idpasien='+getIdPasien,'hsl_RA_terakhir','','GET',loadRATerakhir,'noLoad');
			
			//raga lab
			if((document.getElementById('cmbJnsLay').value==57) && (document.getElementById('cmbTmpLay').value==58)){
				//alert("hasilLab_utils.php?grd=true&pelayanan_id="+sisip[1]);
				isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokHsl',cekLogPelaksana);
				lab.loadURL("hasilLab_utils.php?grd=true&pelayanan_id="+sisip[1],"","GET");
			}
			
			//bagus lab
			if((document.getElementById('cmbJnsLay').value==57) && (document.getElementById('cmbTmpLay').value==59)){
				//alert("hasilLab_utils.php?grd=true&pelayanan_id="+sisip[1]);
				isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokLabPa',cekLogPelaksana);
				//lapPa.loadURL("hasilRad_utils.php?grd=true&pelayanan_id="+sisip[1],"","GET");
			}
			
			//raga rad
			if(document.getElementById('cmbJnsLay').value==60){
				isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokHslRad',cekLogPelaksana);
				//alert("hasilRad_utils.php?grd=true&pelayanan_id="+sisip[1]);
				rad.loadURL("hasilRad_utils.php?grd=true&pelayanan_id="+sisip[1],"","GET");
				document.getElementById('ketRujuk_rad').innerHTML=a1.cellsGetValue(a1.getSelRow(),3);
			}
			
			if(document.getElementById('cmbJnsLay').value==57){
				isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokLabPa',cekLogPelaksana);
				//alert("hasilRad_utils.php?grd=true&pelayanan_id="+sisip[1]);
				//lapPa.loadURL("hasilRad_utils.php?grd=true&pelayanan_id="+sisip[1],"","GET");
				lapPa.loadURL("hasilLab_utils.php?grd=LPA&pelayanan_id="+sisip[1],"","GET");
				document.getElementById('ketRujuk_labPA').innerHTML=a1.cellsGetValue(a1.getSelRow(),3);
			}
			
			//penyebab kecelakaan
			//document.getElementById('chkPenyebabKecelakaan').checked = 'false';
			jQuery("#chkPenyebabKecelakaan").prop('checked',false);
			if(document.getElementById('cmbTmpLay').value==45){
				document.getElementById('pil_PK').style.display='inline';
			}
			else{
				document.getElementById('pil_PK').style.display='none';
			}
			
			isiCombo('cmbApotek_ruangan',getIdUnit,'','cmbApotek');
	 
			if("<?php echo isset($_POST['sentPar'])?>" == 1 && document.getElementById('txtFilter').value != ''){
			   detail();
			}
			
			//var vinap=document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
			if(getInap == 1)
			{
				jQuery("#btnIsiDataRM12").hide();
				jQuery("#btnIsiDataRM13").show();
				
			}else if(getInap == 0){
				jQuery("#btnIsiDataRM12").show();
				jQuery("#btnIsiDataRM13").hide();
				
				if(document.getElementById('cmbJnsLay').value==57 || document.getElementById('cmbJnsLay').value==60){
					jQuery("#btnIsiDataRM12").hide();
					jQuery("#btnIsiDataRM13").hide();
				}
			}
		}
		else{
			document.getElementById('dtlPas').disabled=true;
			document.getElementById('updtPas').disabled=true;
		}
	    
	    if(getAllPosibilities == 2){
			//melakukan pengecekan, jika setelah grid diload menghasilkan 1 data pasien,maka akan langsung masuk pada pelayanan.
			//jika > 1 maka user disuruh memilih dulu pasien yang mana yang akan diproses.
			//jika = 0 maka akan dilakukan pengecekan apakah unit user inap atau tidak.
			//jika inap dan jika unit asal pasien juga inap, maka action yang dilakukan adalah pindah kamar
			//jika inap dan jika unit asal pasien bukan inap, maka action yang dilakukan rujuk inap
			//jika bukan inap maka action yang dilakukan rujuk unit
			var jmlHal = a1.getMaxPage();
			var jmlOrg = a1.getMaxRow();
			if(jmlHal == 1 && jmlOrg == 1){
				if(getInap == 1){
					if(getDilayani == 1){
						detail();
					}
					else{
						updatePas(getAllPosibilities);
					}
				}
				else{
					detail();
				}
			}
			else if(jmlHal == 0){
				//alert("Pasien dengan Nomor Rekam Medik "+document.getElementById('txtNo').value+" tidak ada.");
				//var no_rm = a1.cellsGetValue(a1.getSelRow(),3);
				document.getElementById('txtNo').value = globNo_rm;
			}
			getAllPosibilities = 0;
		}
		
		// alert(cabang);
		//alert('ambil='+document.getElementById("btnTmbh").disabled);
	}

	function loadUlang(){
		if(document.getElementById('divKunj').style.display=='block'){
			//alert(cmbDilayani);
			goFilterAndSort('gridbox');
			//alert('refresh');
			setTimeout("loadUlang()","120000");
		}
	}
	
	function cekHLab(){
		jQuery("#loadGambar1").load("update_in_out.php?id_pelayanan="+getIdPel+"&cekLabN=true",'',function(){
			document.getElementById('divDetil').style.display='none';
			document.getElementById('divKunj').style.display='block';
			document.getElementById('txtFilter').value='';
			loadUlang();
			document.getElementById('chkTind').checked=false;
			showUnit(false);
			document.getElementById('txtFilter').focus();
			cekValidasiLab();
			
		});	
	}
	
	function saring(){
		//alert('saring');         
		//isiCombo('cmbDok',unitId,'<?php $userId; ?>','cmbDokterUnit',cekLogPelaksanaB);   
		txtTgl=document.getElementById('txtTgl').value;
		cmbTmpLay=document.getElementById('cmbTmpLay').value;
		cmbDilayani=document.getElementById('cmbDilayani').value;
		//document.getElementById('cmbTmpLay').lang=document.getElementById('cmbTmpLay').value;
		//alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
		unitId=document.getElementById('cmbTmpLay').value;
		jenisUnitId=document.getElementById('cmbJnsLay').value;
		if(cmbDilayani == -1 && inap == 1 || inap == 0){
			document.getElementById('trTgl').style.visibility='visible';
		}
		else{
			document.getElementById('trTgl').style.visibility='collapse';
		}
		//for anastesi
		//alert(cmbTmpLay);
		if(cmbTmpLay == 6 || cmbTmpLay == 7 || cmbTmpLay == 13 || cmbTmpLay == 18 || cmbTmpLay == 47 || cmbTmpLay == 63 || cmbTmpLay == 72 || cmbTmpLay == 45 ){
			document.getElementById('div_an').style.display = 'table-cell';
		}
		else{
			document.getElementById('div_an').style.display = 'none';
		}
		var no_rm = document.getElementById('txtFilter').value;
		
		
		var url = "pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+no_rm+"&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&no_rm="+no_rm+"&inap="+inap+"&dilayani="+document.getElementById('cmbDilayani').value+"&jnsLay="+document.getElementById('cmbJnsLay').value;
		
		
		a1.setSorting('');
		a1.setFilter('');
		
		//alert(url)
		//a1.loadURL(url,"","GET");
		
		
		
		
		//mukti
		if(inap==1 && document.getElementById('cmbDilayani').value==1){
			a1.setColHeader("NO ANTRIAN,TGL,KETERANGAN,NO RM,NAMA,L/P,KAMAR,PENJAMIN,ASAL KUNJUNGAN,ALAMAT,T.LHR,NAMA ORTU");
            a1.setIDColHeader("no_antrian,,,no_rm,nama,,kamar,namakso,,,nama_ortu,alamat");
            a1.setColWidth("80,80,80,70,200,30,100,150,140,250,70,100");
            a1.setCellAlign("center,center,center,left,left,center,center,center,center,center,center,left");			
		}
		else{
			a1.setColHeader("NO ANTRIAN,TGL,KETERANGAN,NO RM,NAMA,L/P,PENJAMIN,ASAL KUNJUNGAN,ALAMAT,T.LHR,NAMA ORTU");
            a1.setIDColHeader("no_antrian,,,no_rm,nama,,namakso,,,nama_ortu,alamat");
            a1.setColWidth("80,80,80,70,200,30,150,140,250,70,100");
            a1.setCellAlign("center,center,center,left,left,center,center,center,center,center,left");
		}
		a1.loadURL(url,"","GET");
		
		Request("pelayanankunjungan_utils.php?act=cmbDokterUnit&saring=true&no_rm=&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&inap="+inap+"&dilayani="+document.getElementById('cmbDilayani').value+"&jnsLay="+document.getElementById('cmbJnsLay').value,'cmbDokterUnit','','GET',cekLogPelaksanaB);
	}
	
	function saring2(){     
		txtTgl=document.getElementById('txtTgl').value;
		cmbTmpLay=document.getElementById('cmbTmpLay').value;
		cmbDilayani=document.getElementById('cmbDilayani').value;
		
		var no_rm = document.getElementById('txtFilter').value;
		var url = "pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+no_rm+"&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&no_rm="+no_rm+"&inap="+inap+"&dilayani="+document.getElementById('cmbDilayani').value+"&jnsLay="+document.getElementById('cmbJnsLay').value+"&dokterUnit="+document.getElementById('cmbDokterUnit').value;
		a1.loadURL(url,"","GET");
	}
	
	function SimpanSampel()
	{
		jQuery("#loadGambar1").load("update_sampel.php?id_pelayanan="+getIdPel+"&tglPengambilan="+jQuery("#tglPengambilan").val()+"&jamPengambilan="+jQuery("#jamPengambilan").val()+"&cpasien="+escape(jQuery("#txtNPasien").val())+"&clab="+escape(jQuery("#txtNLab").val()),'',function(){
			alert("Berhasil disimpan");
			//document.getElementById("transferworkList").disabled = true;
		});
	}
	
	function SimpanValidasiLab()
	{
		var acc = 0;
		/* if(document.getElementById("app3").checked == true)
		{
			acc = 3;
		}else if(document.getElementById("app2").checked == true){
			acc = 2;
		}else if(document.getElementById("app1").checked == true){
			acc = 1;
		}
		jQuery("#loadGambar1").load("update_sampel.php?id_pelayanan="+getIdPel+"&acc="+acc+"&isAcc=true",'',function(){
			//alert("App Berhasil");
			if(acc+1 <= 3)
			{
				if(acc+1 == 2)
				{
					document.getElementById("app2").disabled = false;
					jQuery('#app2').removeAttr('disabled');
					document.getElementById("app3").disabled = true;
				}else if(acc+1 == 3){
					document.getElementById("app3").disabled = false;
					jQuery('#app3').removeAttr('disabled');
				}
			}
			
			if(acc == 0)
			{
				document.getElementById("app2").disabled = true;
				document.getElementById("app3").disabled = true;
			}
			//document.getElementById("transferworkList").disabled = true;
		}); */
		if(document.getElementById("app1").checked == true)
		{
			if(confirm("Apakah Anda Yakin Ingin Approve Hasil Pemeriksaan?")){
				acc = 1;
				//alert("hasil_pemeriksaan/verif_hasil_utils.php?id_pelayanan="+getIdPel+"&acc="+acc+"&isAcc=true&userId=<?php echo $userId; ?>");
				//jQuery("#btnIsiDataRM18").load("hasil_pemeriksaan/verif_hasil_utils.php?id_pelayanan="+getIdPel+"&acc="+acc+"&isAcc=true&userId=<?php echo $userId; ?>");
				jQuery("#loadGambar1").load("update_sampel.php?id_pelayanan="+getIdPel+"&acc="+acc+"&isAcc=true",'');
				// Request("hasil_pemeriksaan/verif_hasil_utils.php?id_pelayanan="+getIdPel+"&acc="+acc+"&isAcc=true&userId=<?php echo $userId; ?>",'temp_lab','','GET','','noload');
			}else{
				document.getElementById("app1").checked = false;
			}
		}else{
			if(confirm("Apakah Anda Yakin Ingin Batal Approve Hasil Pemeriksaan?")){
				acc = 0;
				//alert("hasil_pemeriksaan/verif_hasil_utils.php?id_pelayanan="+getIdPel+"&acc="+acc+"&isAcc=true&userId=<?php echo $userId; ?>");
				//jQuery("#btnIsiDataRM18").load("hasil_pemeriksaan/verif_hasil_utils.php?id_pelayanan="+getIdPel+"&acc="+acc+"&isAcc=true&userId=<?php echo $userId; ?>");
				jQuery("#loadGambar1").load("update_sampel.php?id_pelayanan="+getIdPel+"&acc="+acc+"&isAcc=true",'');
				//Request("hasil_pemeriksaan/verif_hasil_utils.php?id_pelayanan="+getIdPel+"&acc="+acc+"&isAcc=true&userId=<?php echo $userId; ?>",'temp_lab','','GET','','noload');
			}else{
				document.getElementById("app1").checked = true;
			}
		}
	}
	
	function cekValidasiLab()
	{
		//alert(getIdPel);
		jQuery("#loadGambar1").load("update_in_out.php?id_pelayanan="+getIdPel+"&valLab=true&userId=<? echo $userId;?>");
	}
	
	var dtrmLama = '';
	function cekAwal()
	{
		dtrmLama = jQuery("#txtNo").val();
		jQuery("#txtNo").val('');
	}
	
	function cekAkhir()
	{
		if(jQuery("#txtNo").val() == '')
		{
			jQuery("#txtNo").val(dtrmLama);
		}
	}
	
	function rawatbrg(){
		jQuery("#rawatbersama").load("rawat_bersama.php?cek=aksi&id_pelayanan="+getIdPel);
		document.getElementById("rawatbersama").disabled = true;
	}
	
	function kunjung(){
		new Popup('divKetBatal',null,{modal:true,position:'center',duration:1});
		document.getElementById('divKetBatal').popup.show();
		
		/*jQuery("#btnIsiDataRM18").load("batal_kunjungan.php?cek=true&id_pelayanan="+getIdPel+"&unit="+document.getElementById("cmbTmpLay").value);	
		getBatal = "1";
		cekLockRM();*/
	}
	
	function tutup_ket_batal(){
		document.getElementById('ket_batal').value='';
		document.getElementById('divKetBatal').popup.hide();
		
	}
	
	function simpan_batal(){
	var ket_batal = document.getElementById('ket_batal').value;
	  if((ket_batal=='') || (ket_batal==null)){
		alert('Anda Harus Menginsikan Keterangan Batal Berkunjung !');
	  }else{
		jQuery("#btnIsiDataRM18").load("batal_kunjungan.php?cek=true&id_pelayanan="+getIdPel+"&unit="+document.getElementById("cmbTmpLay").value+"&ket_batal="+encodeURIComponent(ket_batal));	
		getBatal = "1";
		tutup_ket_batal();
		cekLockRM();
	  }
	}
	
	function kunjung1(){
		jQuery("#btnIsiDataRM19").load("batal_kunjungan.php?cek=true&id_pelayanan="+getIdPel+"&unit="+document.getElementById("cmbTmpLay").value);	
		getBatal = "";
		cekLockRM();
	}
	
	function detail(){
		//alert("one click");
		
		<!-- =====tambahan dpjp + pav===== -->
		ViewDPJP();
		
		var url = "pacs_utils.php?no_rm=";
		//pacs_S.loadURL(url,'','GET');
		document.getElementById("txtTglK").value = "<? echo $date_now;?>"
		document.getElementById("tglTindak").value = "<? echo $date_now;?>"
		
		jQuery("#smeninggal").val("0");
		var idPasien1 = "<? echo $spesialis;?>";
		isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','id_dokter',default1);
		isiCombo('cmbDiagRes',getIdKunj,'<?php echo $userId; ?>','cmbDiagR',default1);
		cekLogPelaksana();
		amplopradio();
		var cmbTmpLay = document.getElementById("cmbTmpLay").value;
		//alert(cmbTmpLay);
		
		hslexpertise();
		
		if(document.getElementById("cmbJnsLay").value != 44)
		{
			jQuery("#chkPenyebabKecelakaan").hide();
			jQuery("#cmbPenyebab").hide();
			//document.getElementById("chkPenyebabKecelakaan").checked = 'false';
			jQuery("#chkPenyebabKecelakaan").prop('checked',false);
		}else{
			jQuery("#chkPenyebabKecelakaan").show();
		}
		
		if((document.getElementById("cmbJnsLay").value == 57) || (document.getElementById("cmbJnsLay").value == 60) || (document.getElementById("cmbJnsLay").value == 129))
		{
			cekLab(document.getElementById("cmbJnsLay").value);
		}
		
		//jQuery("#btnIsiDataRM18").load("batal_kunjungan.php?id_pelayanan="+getIdPel+"&unit="+document.getElementById("cmbTmpLay").value);
		cekInap(document.getElementById("cmbJnsLay").options[document.getElementById("cmbJnsLay").options.selectedIndex].lang);
		
		//alert(idPasien1);
		jQuery("#loadGambar").html("");
		jQuery("#loadGambar1").load("update_in_out.php?id_pelayanan="+getIdPel+"&in=true",'',function(){
			cekValidasiLab();
		});
		/*jQuery("#loadGambar1").load("update_in_out.php?cmbTmpLay="+cmbTmpLay+"&krs=true",'',function(){
			
		}*/
		
		jQuery("#loadGambar").load("gambar1.php?id_pasien="+getIdPasien);
	    globNo_rm = a1.cellsGetValue(a1.getSelRow(),4);
	    //alert(document.getElementById('dtlPas').disabled);
	    if (document.getElementById('dtlPas').disabled==false){
		    document.getElementById('divKunj').style.display='none';
		    document.getElementById('divDetil').style.display='block';
		    //mTab.refreshTab();
	    }
	    //document.getElementById('btnPasienPulang').style.display = 'none';
	    document.getElementById('btnBatalPulang').style.display = 'none';
         //pasien yang pindah kamar, tombol pasien pulang / batal pulang tidak akan muncul.
	    if(getDilayani != 2 && inap == 1){
			if(document.getElementById('cmbDilayani').value == -1){
				document.getElementById('btnBatalPulang').style.display = 'inline-table';
				document.getElementById('btnPasienPulang').style.display = 'none';
			}
			else{
				//bagus
				//document.getElementById('btnPasienPulang').style.display = 'inline-table';
				document.getElementById('btnPasienPulang').style.display = 'none';
				document.getElementById('btnBatalPulang').style.display = 'none';
			}
	    }
		if(idPasien1==0)
		{
			//alert("");
			//jQuery("#btnPasienPulang").hide();
			//alert(jQuery("#btnPasienPulang").val());
		}else{
			//Bagus
			//jQuery("#btnPasienPulang").show();
			jQuery("#btnPasienPulang").hide();
		}
		
		if(jQuery("#cmbTmpLay").val() == 8)
		{
			//jQuery("#KL").hide();
			//jQuery("#ab").show();
			//jQuery("#txtAbdomen").show();
			//jQuery("#gen").hide();
		}else if(jQuery("#cmbTmpLay").val() == 4 || jQuery("#cmbTmpLay").val() == 10){
			//jQuery("#ab").hide();
			//jQuery("#txtAbdomen").hide();
			//jQuery("#KL").show();
			//jQuery("#gen").show();
		}else{
			//jQuery("#KL").show();
			//jQuery("#ab").show();
			//jQuery("#txtAbdomen").show();
			//jQuery("#gen").show();
			cekLockRM();
			if(getBatal == 1)
			{
				//getBatal = sisip[32];				
				jQuery("#btnIsiDataRM18").hide();
				jQuery("#btnIsiDataRM19").show();
				//alert("");
			}else{
				//alert();//getBatal = "";
				if(jQuery("#cmbJnsLay").val() == 94 || jQuery("#cmbJnsLay").val() == 68 || jQuery("#cmbJnsLay").val() == 27){ //hidden batal berkunjung
				jQuery("#btnIsiDataRM18").hide();	
				}else{
					if(getDilayani==0){
					jQuery("#btnIsiDataRM18").show();
					}else{
					jQuery("#btnIsiDataRM18").hide();	
					}
				}
				
				jQuery("#btnIsiDataRM19").hide();
			}
		}
		
		cekSpesialis1('<? echo $spesialis;?>');
		
		jQuery("#rawatbersama").load("rawat_bersama.php?cek=true&id_pelayanan="+getIdPel);
		//alert(getIdPel);
		//alert(idPasien1);
		subj1.loadURL("soap_utils.php?grd=1&idPel="+getIdPel,'','GET');
		anam1.loadURL("tindiag_utils.php?grdAnamnesa=true&pasien_id="+getIdPasien,'','GET');
		var s = b.getRowId(b.getSelRow()).split("|");
		//alert(s);
		//document.getElementById("btnTmbh").disabled = true;
		//belum fix
		/* if(s !== null)
		{
			document.getElementById("btnTmbh").disabled = false;
			jQuery('#btnTmbh').removeAttr('disabled');
		} */
		
		if (getDilayani==0 && getInap==0){
			if (asalmasuk=='loket'){
				//resumeMedis();
			}else{
				//pop_prmhhn_konsul();
			}
		}else if (getDilayani==0 && getInap==1){
			updatePas();
		}else if (getDilayani==1 && getInap==1){
			//( vUrl , vTarget, vForm, vMethod,evl,noload)
			Request('tindiag_utils.php?act=getspinap&pelayanan_id='+getIdPel,'HslSpInap','','GET',function(){
				if(document.getElementById('HslSpInap').innerHTML=='0'){
					//pop_spinap();
				}
			});
		}
		
		if(document.getElementById("btnCekOut").disabled)
		{
			//alert("tes222");
			document.getElementById("btnRujukRS").disabled=false;
			jQuery("#btnRujukUnit").hide();
			jQuery("#btnSetKamar").hide();
			jQuery("#btnMRS").hide();
		}else{
			document.getElementById("btnRujukRS").disabled=false;///
			jQuery("#btnRujukUnit").show();
			if(jQuery("#cmbJnsLay").val()==27)
			{
				jQuery("#btnSetKamar").show();
			}else{
				jQuery("#btnMRS").show();
			}
		}
	}
	
	function default1()
	{
		var idPasien1 = "<? echo $spesialis;?>";
		var idPasien2 = "<? echo $userId ;?>";
		
		if(idPasien1!=0)
		{
			jQuery("#id_dokter").val(idPasien2);
			jQuery("#id_dokter").attr("disabled","disabled");
		}

	}
	function updatePas(gap){
		//alert(getIdUnit+','+getIdKelas);
		isiCombo('cmbKamar',getIdUnit+','+getIdKelas,'','kamarPx',isiBad);
		new Popup('divPilihKamar',null,{modal:true,position:'center',duration:1});
		document.getElementById('divPilihKamar').popup.show();
	}
	
	function saveworkList(){
		var nilai = "";
		var sex = "";
		var tgl12 = jQuery("#txtTgl21").val();
		var dokRad = jQuery("#cmbDokRad").val();
		var txtKetR = jQuery("#txtKetRad").val();
		
		/*alert(tgl12+"\n"+dokRad+"\n"+txtKetR);
		return false;*/
		<?
			$query1 = "SELECT * FROM b_ms_work_list WHERE aktif = 1";
			$dquery1 = mysql_query($query1);
			while($rquery1 = mysql_fetch_array($dquery1))
			{
				?>
					if(document.getElementById("<? echo $rquery1['kode']?>").checked==true)
					{
						nilai += "<? echo $rquery1['kode']?>|";
					}
				<?
			}
		?>
		
		if(jQuery("#txtSex").val() == "L")
		{
			sex = "M";
		}else{
			sex = "F";
		}
		//alert(nilai);
		//alert(nilai+"\n"+studyuid+"\n"+getIdPel+"\n"+getIdKunj+"\n"+jQuery("#txtNo").val()+"\n"+sex+"\n"+jQuery("#txtNama").val());
		jQuery("#loadGambar1").load("workList.php?id_pelayanan="+getIdPel+"&tipe=1&data12="+nilai+"&id_kunjungan="+getIdKunj+"&tgl12="+tgl12+"&dokRad="+dokRad+"&txtKetR="+txtKetR+"&studyuid="+studyuid+"&no_rm="+jQuery("#txtNo").val()+"&sex="+sex+"&nama="+jQuery("#txtNama").val(),'',function(){
			alert("penyimpanan work list berhasil");
			document.getElementById("transferworkList").disabled = false;
			jQuery('#transferworkList').removeAttr('disabled');
		});
	}
	
	var studyuid;
	var passIdpacs,pacsuuid;
	function show_pacs(){
		//alert(getNoPasien);
		document.getElementById("set_pacs_id").style.display="inline";
		var PatientId = getNoPasien;
		passIdpacs = '';
		pacsuuid = '';
		document.getElementById('loadPacs').style.display = 'block';
		//PatientId = 'XsaDYa';
		//var url = "../pacs/tes_rad_utils.php?grd=SERIES&remoteAE=<?php echo $remoteAE; ?>&act=list&QueryLevel=SERIES&Modality=&PatientId="+PatientId+"&PatientName=&StudyId=&StudyIuid=&SeriesIuid=&SOPIuid=&tipe=data";
		var url = "pacs_utils.php?no_rm="+PatientId;
		pacs_S.loadURL(url,'','GET');
		new Popup('divPacs',null,{modal:true,position:'center',duration:1});
		document.getElementById('divPacs').popup.show();
	}
	
	function show_pacs_tind(){
		//alert(getNoPasien);
		document.getElementById("set_pacs_id").style.display="none";
		var PatientId = getNoPasien;
		passIdpacs = '';
		pacsuuid = '';
		document.getElementById('loadPacs').style.display = 'block';
		//PatientId = 'XsaDYa';
		//var url = "../pacs/tes_rad_utils.php?grd=SERIES&remoteAE=<?php echo $remoteAE; ?>&act=list&QueryLevel=SERIES&Modality=&PatientId="+PatientId+"&PatientName=&StudyId=&StudyIuid=&SeriesIuid=&SOPIuid=&tipe=data";
		var url = "pacs_utils.php?no_rm="+PatientId;
		pacs_S.loadURL(url,'','GET');
		new Popup('divPacs',null,{modal:true,position:'center',duration:1});
		document.getElementById('divPacs').popup.show();
	}
	
	function imageRad(norm,idpacs){
		//OpenWnd('http://192.10.30.35:8080/pacs/images/'+norm+'/'+idpacs+'/preview.html',900,600,'msma',true);
		var url = "<?php echo $base_addr_pacs; ?>"+norm+'/'+idpacs+'/preview.html';
		var h = "700";
		var w = "1010";
		var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
		var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
		window.open(url,'','height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',titlebar=no,toolbar=no,location=no,status=no,menubar=no,resizable');
	}
	
	function detailPacs(){
		var PatientId = getNoPasien;
		//PatientId = 'XsaDYa';
		var data_PACS = pacs_S.getRowId(pacs_S.getSelRow()).split("|");
		//var Series_IUID = data_PACS[0];
		//alert(pacs_S.getRowId(pacs_S.getSelRow()));
		passIdpacs = data_PACS[0];
		pacsuuid = data_PACS[1];
		document.getElementById('loadPacs').style.display = 'none';
		jQuery('#normPass').val('');
		jQuery('#pacsuuid').val('');
		var set = '<img src="../icon/cancel.gif" alt="pacsStat" width="12px" />';
		jQuery('#statPacs').html(set);
		//var Study_IUID = data_PACS[1];
		//var url = "../pacs/tes_rad_utils.php?grd=IMAGE&remoteAE=<?php echo $remoteAE; ?>&act=list&QueryLevel=IMAGE&Modality=&PatientId="+PatientId+"&PatientName=&StudyId=&StudyIuid=&SeriesIuid="+Series_IUID+"&SOPIuid=&tipe=data";
		//pacs_I.loadURL(url,'','GET');
	}
	
	function setPacs(){
		if(pacsuuid!=''){
			jQuery('#normPass').val(passIdpacs);
			jQuery('#pacsuuid').val(pacsuuid);
			document.getElementById('divPacs').popup.hide();
			var set = '<img src="../icon/ok.png" alt="pacsStat" width="12px" />';
			jQuery('#statPacs').html(set);
		} else {
			alert('Pilih terlebih dahulu hasil Pacs!');
		}
	}
	
	function view_pacs(i){
		//alert(pacs_I.getSelRow());
		var data_I = pacs_I.getRowId(i).split("|");
		var norm=data_I[0];
		var studyIUD=data_I[1];
		var seriesIUD=data_I[2];
		var sopIUD=data_I[3];
		var modality=data_I[4];
		
		var h = "600";
		var w = "800";
		var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
		var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
		
		var param = "remoteAE=<?php echo $remoteAE; ?>&act=get&QueryLevel=&PatientName=&PatientId="+norm+"&Modality="+modality+"&StudyId=&StudyIuid="+studyIUD+"&SeriesIuid="+seriesIUD+"&SOPIuid="+sopIUD+"&tipe=data";
		var url="<?php echo $url_pacs ?>"+param;
		
		window.open(url,'','height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',titlebar=no,toolbar=no,location=no,status=no,menubar=no,resizable');
	}
	
	function transferPACS()
	{
		jQuery("#loadGambar1").load("workList.php?id_pelayanan="+getIdPel+"&tipe=0&no_rm="+jQuery("#txtNo").val(),'',function(){
			alert("transfer worklist ke PACS berhasil");
			document.getElementById("transferworkList").disabled = true;
		});
	}
	
	function sampel(){
		new Popup('divSampel',null,{modal:true,position:'center',duration:1});
		document.getElementById('divSampel').popup.show();
	}
	
	function sListPemeriksaan(){
		alert("Under Construction");
	}
	
	function validasi()
	{
		new Popup('divValidasiLab',null,{modal:true,position:'center',duration:1});
		document.getElementById('divValidasiLab').popup.show();
	}
	
	function workList(){
		//alert(getIdUnit+','+getIdKelas);
		//isiCombo('cmbKamar',getIdUnit+','+getIdKelas,'','kamarPx',isiBad);
		var d = new Date();
		studyuid = "1.2.826.0.1.3680043.2.737."+jQuery("#txtNo").val();
		//alert(getIdPel+"\n"+getIdKunj+"\n"+jQuery("#txtNo").val()+"\n"+studyuid);
		new Popup('divWorkList',null,{modal:true,position:'center',duration:1});
		document.getElementById('divWorkList').popup.show();
	}
	
	function isiBad()
	{
		//alert("");
		var idK = document.getElementById('kamarPx').value;
		//alert(idK);
		isiCombo3('cmbBad',idK+','+getIdKelas,'','no_kamar');
	}
	
	function PilihKamarPx(gap){
	var url;
		if(confirm("Anda yakin ingin mengubah status dilayani pada pasien ini?")){
			var inap = document.getElementById('cmbJnsLay').options[document.getElementById('cmbJnsLay').options.selectedIndex].lang;
			var no_rm = document.getElementById('txtFilter').value;
			var noBad12 = document.getElementById('no_kamar').value;
			url="pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+no_rm+"&act=update&pelayanan_id="+getIdPel+"&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&inap="+inap+"&dilayani="+document.getElementById('cmbDilayani').value+"&pilihKamar="+document.getElementById('kamarPx').value+"&no_bad="+noBad12;
			//alert(url);
			a1.loadURL(url,"","GET");
			document.getElementById('divPilihKamar').popup.hide();
			//detail();
			//pop_spinap();
		}
	    else{
			if(gap == 2){
				document.getElementById('divDetil').style.display='none';
				document.getElementById('divKunj').style.display='block';
				loadUlang();
				document.getElementById('chkTind').checked=false;
				showUnit(false);
				//filter('pass',globNo_rm);
			}
	    }
	}
    </script>

    <!--script detil pelayanan-->
    <script type="text/JavaScript" language="JavaScript">
	function cekLogPelaksana(){
		if(document.getElementById('cmbDokTind').value==<?php echo $userId; ?>){
			disPelakasana(true);	
		}
		else{
			disPelakasana(false);
			/*
			jQuery("#cmbDokTind").val(getIdDokTujuan1);
			if(document.getElementById('cmbDokTind').value==getIdDokTujuan1){
				setCombo(getIdDokTujuan1);
				disPelakasana(true);	
			}else{
				disPelakasana(false);
			}
			*/
		}
	}
	
	function cekLogPelaksanaB(){
		/*
		jQuery("#cmbDokterUnit").val(<?php $userId; ?>);
		if(document.getElementById('cmbDokterUnit').value==<?php $userId; ?>){
			document.getElementById('cmbDokterUnit').disabled = true;
			saring2();
		}
		else{
			document.getElementById('cmbDokterUnit').disabled = false;
		}
		*/
	}
	
	function setCombo(val1)
	{
		jQuery('#cmbDokRujukUnit').val(val1);
		jQuery('#cmbDokRujukRS').val(val1);
		jQuery('#cmbDokDiag').val(val1);
		jQuery('#cmbDokResep').val(val1); 
		jQuery('#cmbDokTind').val(val1);
		jQuery('#cmbDokAnamnesa').val(val1);
		jQuery('#cmbDokHsl').val(val1);
		jQuery('#cmbDokHslRad').val(val1);
				
		jQuery('#chkDokterPenggantiDiag').val(val1);
		jQuery('#chkDokterPenggantiResep').val(val1);
		jQuery('#chkDokterPenggantiTind').val(val1);
		jQuery('#chkDokterPenggantiRujukUnit').val(val1);
		jQuery('#chkDokterPenggantiRujukRS').val(val1);
		jQuery('#chkDokterPenggantiAnamnesa').val(val1);
	}
	
	function disPelakasana(disabel){
		/*document.getElementById('cmbDokRujukUnit').disabled = */document.getElementById('cmbDokRujukRS').disabled = /*document.getElementById('cmbDokDiag').disabled = */document.getElementById('cmbDokResep').disabled = document.getElementById('cmbDokTind').disabled = document.getElementById('cmbDokAnamnesa').disabled = document.getElementById('cmbDokHsl').disabled = document.getElementById('cmbDokHslRad').disabled = disabel;
		
		/*document.getElementById('chkDokterPenggantiDiag').disabled = */document.getElementById('chkDokterPenggantiResep').disabled = document.getElementById('chkDokterPenggantiTind').disabled = /*document.getElementById('chkDokterPenggantiRujukUnit').disabled =*/ document.getElementById('chkDokterPenggantiRujukRS').disabled = document.getElementById('chkDokterPenggantiAnamnesa').disabled = disabel;
	}
	
	function gantiDokter(comboDokter,statusCek,disabel){
		if(statusCek==true){
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokTind',refreshDok);
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokRujukUnit,cmbDokRujukDokter,cmbDokRujukRS,cmbDokDiag,cmbDokResep,cmbDokAnamnesa,cmbDokSOAPIER,cmbDokRad');
			/* isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokRujukDokter');
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokRujukRS');
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokDiag');
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokResep');
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokAnamnesa');
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokSOAPIER');
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokRad'); */
			//isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'',comboDokter);
		}
		else{
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokTind',refreshDok);
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokRujukUnit,cmbDokRujukDokter,cmbDokRujukRS,cmbDokDiag,cmbDokResep,cmbDokAnamnesa,cmbDokSOAPIER,cmbDokRad');
			/* isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokRujukDokter');
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokRujukRS');
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokDiag');
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokResep');
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokAnamnesa');
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokSOAPIER');
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokRad'); */
			//isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,comboDokter,'');
		}
		document.getElementById('chkDokterPenggantiRad').checked = document.getElementById('chkDokterPenggantiDiag').checked = document.getElementById('chkDokterPenggantiResep').checked = document.getElementById('chkDokterPenggantiTind').checked = document.getElementById('chkDokterPenggantiRujukUnit').checked = document.getElementById('chkDokterPenggantiRujukDokter').checked = document.getElementById('chkDokterPenggantiRujukRS').checked = document.getElementById('chkDokterPenggantiAnamnesa').checked = document.getElementById('chkDokterPenggantiSOAPIER').checked = statusCek;
	}
		
	function setManual(val){
		if(val == 'ifinap'){
			if(document.getElementById('chkManual_ifinap').checked==true){
				document.getElementById('JamMasuk_ifinap').readOnly=false;
				document.getElementById('btnTglMasuk_ifinap').disabled=false;
				jQuery('#btnTglMasuk_ifinap').removeAttr('disabled');
			}
			else{
				document.getElementById('JamMasuk_ifinap').readOnly=true;
				document.getElementById('btnTglMasuk_ifinap').disabled=true;
			}
		}
		else if(val == 'krs') {
			if(document.getElementById('chkManualKrs').checked==true){
				//alert("");
				document.getElementById('JamKrs').readOnly=false;
				jQuery('#JamKrs').removeAttr('disabled');
				document.getElementById('btnTglKrs').disabled=false;
				jQuery('.btnTglKrs').removeAttr('disabled');
			}
			else{
				document.getElementById('JamKrs').readOnly=true;
				document.getElementById('btnTglKrs').disabled=true;
				jQuery('.btnTglKrs').attr('disabled','true');
			}
		}
		else {
			if(document.getElementById('chkManual').checked==true){
				document.getElementById('JamMasuk').readOnly=false;
				jQuery('#JamMasuk').removeAttr('disabled');
				document.getElementById('btnTglMasuk').disabled=false;
				jQuery('#btnTglMasuk').removeAttr('disabled');
			}
			else{
				document.getElementById('JamMasuk').readOnly=true;
				document.getElementById('btnTglMasuk').disabled=true;
			}
		}
	}

	var time;
	var tanggal=document.getElementById('TglMasuk').value.split("-");
	var tanggal_ifinap=document.getElementById('TglMasuk_ifinap').value.split("-");
	var tanggalKrs=document.getElementById('TglKrs').value.split("-");
	var tmpTgl=tanggal;
	var ttgl=parseInt((tanggal[0].substr(0,1)=='0')?tanggal[0].substr(1,1):tanggal[0]);
	var tbln=parseInt((tanggal[1].substr(0,1)=='0')?tanggal[1].substr(1,1):tanggal[1]);
	var tthn=parseInt((tanggal[2].substr(0,1)=='0')?tanggal[2].substr(1,1):tanggal[2]);

	function setJam(){
		time=document.getElementById('jamServer').value.split(':');
		var tjam=parseInt((time[0].substr(0,1)=='0')?time[0].substr(1,1):time[0]);
		var tmenit=parseInt((time[1].substr(0,1)=='0')?time[1].substr(1,1):time[1]);
		var tdetik=parseInt((time[2].substr(0,1)=='0')?time[2].substr(1,1):time[2]);
		//alert(tjam+':'+tmenit+':'+tdetik);
		tdetik+=1;
		if((tdetik)>=60){
			tdetik=tdetik-60;
			tmenit++;
			if(tmenit>=60){
				tmenit=tmenit-60;
				tjam++;
				if(tjam==24){
					tjam=0;
					ttgl++;
					if(tbln==1 || tbln==3 || tbln==5 || tbln==7 || tbln==8 || tbln==10 || tbln==12){
						if(ttgl>31){
							ttgl=1;
							tbln++;
						}
					}
					else if(tbln==4 || tbln==6 || tbln==9 || tbln==11){
						if(ttgl>30){
							ttgl=1;
							tbln++;
						}
					}
					else{
						if((tthn % 4)==0){
							if(ttgl>29){
								ttgl=1;
								tbln++;
							}
						}
						else{
							if(ttgl>28){
								ttgl=1;
								tbln++;
							}
						}
					}
					if(tbln>12){
						tbln=1;
						tthn++;
					}
				}
			}
		}
		if(tjam<10){
			time[0]='0'+tjam;
		}
		else{
			time[0]=tjam;
		}
		if(tmenit<10){
			time[1]='0'+tmenit;
		}
		else{
			time[1]=tmenit;
		}
		if(tdetik<10){
			time[2]='0'+tdetik;
		}
		else{
			time[2]=tdetik;
		}

		if(ttgl<10){
			tanggal[0]='0'+ttgl;
		}
		else{
			tanggal[0]=ttgl;
		}
		if(tbln<10){
			tanggal[1]='0'+tbln;
		}
		else{
			tanggal[1]=tbln;
		}
		if(tthn<10){
			tanggal[2]='0'+tthn;
		}
		else{
			tanggal[2]=tthn;
		}
		
		tmpTgl=tanggal[0]+'-'+tanggal[1]+'-'+tanggal[2];
		document.getElementById('jamServer').value=time[0]+':'+time[1]+':'+time[2];
		
		if(document.getElementById('chkManual_ifinap').checked==false){
			document.getElementById('JamMasuk_ifinap').value=time[0]+':'+time[1];
		}
		
		if(document.getElementById('chkManual').checked==false){
			document.getElementById('JamMasuk').value=time[0]+':'+time[1];
			document.getElementById('TglMasuk').value=tmpTgl;
		}
		
		if(document.getElementById('chkManualKrs').checked==false){
			document.getElementById('JamKrs').value=time[0]+':'+time[1];
			document.getElementById('TglKrs').value=tmpTgl;
		}
		//alert(tjam+':'+tmenit+':'+tdetik);
		setTimeout("setJam()","1000");
	}
	
	function konsulDokter(){
		isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokRujukDokter');
		isiCombo('JnsLayananKonDok','','','JnsLayananKonDok',function(){
			isiCombo('TmpLayananKonDok',document.getElementById('JnsLayananKonDok').value,'','TmpLayananKonDok',function(){
				isiCombo('cmbDok',document.getElementById('TmpLayananKonDok').value,'','cmbDokKonDok');	
			});	
		});
		new Popup('divKonsulDokter',null,{modal:true,position:'center',duration:1});
		document.getElementById('divKonsulDokter').popup.show();
	}
	
	function ListKonsulDokter(){
		var cmbStatusKonDok = document.getElementById('cmbStatusKonDok').value;
		lkd.loadURL("listkondok_utils.php?dokter_id=<?php echo $userId; ?>&dilayani="+cmbStatusKonDok,"","GET");
		new Popup('divListKonsulDokter',null,{modal:true,position:'center',duration:1});
		document.getElementById('divListKonsulDokter').popup.show();
	}
	
	function viewListKonsulDokter(){
		var cmbStatusKonDok = document.getElementById('cmbStatusKonDok').value;
		lkd.loadURL("listkondok_utils.php?dokter_id=<?php echo $userId; ?>&dilayani="+cmbStatusKonDok,"","GET");
	}
	
	function detilKonsulDokter(i){
		var sisipan=lkd.getRowId(i).split("|");
		window.open('../report_rm/Form_RSU/2.permohonankonsultasi_dokter.php?idKunj='+sisipan[2]+'&idKon='+sisipan[0]+'&idPel1='+sisipan[1]+'&idPasien='+sisipan[3]+'&idUser=<?php echo $userId;?>',"_blank");
	}
	
	function updateKonsulDokter(){
		var idReport = lkd.getRowId(parseInt(lkd.getSelRow()-1)+1).split('|');
		var id='';
		var act='';
		
		if(lkd.obj.childNodes[0].childNodes[parseInt(lkd.getSelRow())-1].childNodes[7].childNodes[0].checked){
			id = idReport[0]; 
			act = 'tambah';
		}
		else{
			id = idReport[0];
			act = 'hapus';
		}

		Request('listkondok_utils.php?act='+act+'&id='+id, 'spnHasilKonDok', '', 'GET',viewListKonsulDokter);
	}
	
	cekKonsulDokter();
	setInterval('cekKonsulDokter()',30000);
	function cekKonsulDokter(){
		Request('listkondok_utils.php?act=cek&dokter_id=<?php echo $userId; ?>', 'spnCekKonDok', '', 'GET', function(){
			if(document.getElementById('spnCekKonDok').innerHTML>0){
				document.getElementById('trKonsulDokter').style.display='table-row';	
			}
			else{
				document.getElementById('trKonsulDokter').style.display='none';
			}
		});
	}
	
	function isiTmpLayananKonDok(u){
		isiCombo('TmpLayananKonDok',u,'','TmpLayananKonDok',function(){
			isiCombo('cmbDok',document.getElementById('TmpLayananKonDok').value,'','cmbDokKonDok');	
		});	
	}
	
	function isicmbDokKonDok(u){
		isiCombo('cmbDok',u,'','cmbDokKonDok');	
	}

	function rujukUnit(tombol){
		//alert(tombol);
		document.getElementById('lgnJudul').innerHTML=tombol;
		//document.getElementById('trDokTujuanUnit').style.display='none';
		jQuery("#prmhnk").show();
		if(tombol=='MRS'){
			sRujuk = 0;
			//jQuery("#trTglRujuk").hide();
	//alert("tindiag_utils.php?grd2=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit+"&isInap=1&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage());
			isiCombo('JnsLayananDenganInap','<?php echo $_SESSION['userId'];?>',document.getElementById('cmbJnsLay').value,'JnsLayanan',isiTmpLayanan);
			c.loadURL("tindiag_utils.php?grd2=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit+"&sRujuk="+sRujuk+"&isInap=1&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage(),"","GET");
			//+"&pasienId="+getIdPasien
			document.getElementById('btnSpInap').style.display="block";
			if(getIdUnit==45){
				document.getElementById('trDokTujuanUnit').style.display='table-row';
			}
		}else if(tombol=='RUJUK')
		{
			sRujuk = 1;
			jQuery("#trTglRujuk").hide();
			jQuery("#prmhnk").hide();
			isiCombo('JnsLayananRujuk','<?php echo $_SESSION['userId'];?>',document.getElementById('cmbJnsLay').value,'JnsLayanan',isiTmpLayananKonsul);
			//alert("tindiag_utils.php?grd2=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit+"&isInap=0&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage());
			c.loadURL("tindiag_utils.php?grd2=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit+"&sRujuk="+sRujuk+"&isInap=0&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage(),"","GET");
			//+"&pasienId="+getIdPasien
			document.getElementById('btnSpInap').style.display="none";
		}
		else{
			sRujuk = 0;
			jQuery("#trTglRujuk").show();
			isiCombo('JnsLayananKonsul','<?php echo $_SESSION['userId'];?>',document.getElementById('cmbJnsLay').value,'JnsLayanan',isiTmpLayananKonsul);
			//alert("tindiag_utils.php?grd2=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit+"&isInap=0&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage());
			c.loadURL("tindiag_utils.php?grd2=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit+"&sRujuk="+sRujuk+"&isInap=0&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage(),"","GET");
			//+"&pasienId="+getIdPasien
			document.getElementById('btnSpInap').style.display="none";
		}
		
		
		//ambilDataRujukUnit();
		new Popup('divRujukUnit',null,{modal:true,position:'center',duration:1});
		document.getElementById('divRujukUnit').popup.show();
	}
	
	function pop_spinap(){
	var url="spinap.php";
		//alert(idPelKonsul)getIdPel;
		window.open(url+'?idKunj='+getIdKunj+'&dokter_id='+getIdDokPerujuk+'&getIdPel='+getIdPel,'_blank');
	}
	
	function pop_prmhhn_konsul(){
	var url="../report_rm/Form_RSU/2.permohonankonsultasi.php";
		//alert(idPelKonsul)getIdPel;
		window.open(url+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPel1='+idPelKonsul+'&idPasien='+getIdPasien+'&idUser=<?php echo $userId;?>','_blank');
	}
	
	function cetak_rm(url){
		//alert(idPelKonsul)getIdPel;
		window.open(url+'?idKunj='+getIdKunj+'&idPel='+idPelKonsul+'&idPel1='+getIdPel+'&idPasien='+getIdPasien+'&idUser=<?php echo $userId;?>','_blank');
	}
	
	function cetak_konsul_dokter(){
		var sisipan=kd.getRowId(kd.getSelRow()).split("|");
		window.open('../report_rm/Form_RSU/2.permohonankonsultasi_dokter.php?idKunj='+getIdKunj+'&idKon='+sisipan[0]+'&idPel1='+getIdPel+'&idPasien='+getIdPasien+'&idUser=<?php echo $userId;?>',"_blank");	
	}
		
/*	function cetakRincian(p){
		var tmpLay = document.getElementById('txtPelUnit').value;
		if (p==0){
			window.open('RincianTindakan.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap,'_blank');
		}
		else if(p==1){
			window.open('RincianTindakanKSO.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=0','_blank');
		}
		else if(p==2){
			window.open('RincianTindakanLab.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tmpLay='+tmpLay,'_blank');
		}
		else if(p==3){
			window.open('RincianTindakanKSO.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=1','_blank');
		}
		else if(p==4){
			window.open('RincianTindakanKSO.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2','_blank');
		}
		else if(p==5){
			window.open('RincianTindakanRad.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tmpLay='+tmpLay,'_blank');
		}
		else if(p==6){
			window.open('RincianTindakanHd.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tmpLay='+tmpLay,'_blank');
		}
		else if(p==7){
			window.open('RincianTindakanKSO.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=0&for=1','_blank');
		}
		else if(p==8){
			window.open('RincianTindakanKSO.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=1&for=1','_blank');
		}
		else if(p==9){
			window.open('RincianTindakanKSO.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2&for=1','_blank');
		}
		else if(p==10){
			window.open('RincianTindakanKSO_Detail.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2','_blank');
		}
		else if(p==11){
			window.open('RincianTindakanKSO_Detail.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2&for=1','_blank');
		}
		else if(p==12){
			window.open('RincianObatKSO.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2','_blank');
		}
		else if(p==13){
			window.open('RincianTindakanObatKSO.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2','_blank');
		}
		else if(p==14){
			window.open('../pembayaran/tagihanKlaim.php?kunjungan_id='+getIdKunj+'&idbayar=0&idUser=<?php echo $userId;?>&jenisKasir=0','_blank');
		}
	}*/
	
	function cetakRincian(p){
		//alert(p);
	var tmpLay = document.getElementById('txtPelUnit').value;
	var file1,file2,file3,file4,file5,file6,file7,file8;
		file1="RincianTindakan.php";
		file2="RincianTindakanKSO.php";
		file3="RincianTindakanLab.php";
		file4="RincianTindakanRad.php";
		file5="RincianTindakanHd.php";
		file6="RincianTindakanKSO_Detail.php";
		file7="RincianObatKSO.php";
		file8="RincianTindakanObatKSO.php";
		
		if (getKsoId==<?php echo $idKsoBPJS; ?>){
			file2="RincianTindakanKSO_BPJS.php";
			file7="RincianObatKSO.php";
			file8="RincianTindakanObatKSO_BPJS.php";
		}
		//else if(getKsoId==<?php echo $idKsoJR; ?>){
		else if("<?php echo ",".$idKsoJR.","; ?>".indexOf(','+getKsoId+',')>-1){
			file2="RincianTindakanKSO_JR.php";
			file7="RincianObatKSO.php";
			file8="RincianTindakanObatKSO_JR.php";
		}
		
		if (p==0){
			window.open(file1+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap,'_blank');
		}
		else if(p==1){
			window.open(file2+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=0','_blank');
		}
		else if(p==2){
			window.open(file3+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tmpLay='+tmpLay,'_blank');
		}
		else if(p==3){
			window.open(file2+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=1','_blank');
		}
		else if(p==4){
			window.open(file2+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2','_blank');
		}
		else if(p==5){
			window.open(file4+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tmpLay='+tmpLay,'_blank');
		}
		else if(p==6){
			window.open(file5+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tmpLay='+tmpLay,'_blank');
		}
		else if(p==7){
			window.open(file2+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=0&for=1','_blank');
		}
		else if(p==8){
			window.open(file2+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=1&for=1','_blank');
		}
		else if(p==9){
			window.open(file2+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2&for=1','_blank');
		}
		else if(p==10){
			window.open(file6+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2','_blank');
		}
		else if(p==11){
			window.open(file6+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2&for=1','_blank');
		}
		else if(p==12){
			window.open(file7+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=0','_blank');
		}
		else if(p==13){
			window.open(file8+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=0','_blank');
		}
		else if(p==14){
			window.open('../pembayaran/tagihanKlaim.php?kunjungan_id='+getIdKunj+'&idbayar=0&idUser=<?php echo $userId;?>&jenisKasir=0','_blank');
		}
		else if(p==15){
			window.open(file8+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=1','_blank');
		}
		else if(p==16){
			window.open(file8+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2','_blank');
		}
		else if(p==20){
			window.open('RincianTindakanKSO_BPJS_fix.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=0','_blank');
		}
		else if(p==21){
			window.open('RincianTindakanKSO_BPJS_fix.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=1','_blank');
		}
		else if(p==22){
			window.open('RincianTindakanKSO_BPJS_fix.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2','_blank');
		}
		else if(p==23){
			window.open('RincianTindakanObatKSO_BPJS_fix.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=0','_blank');
		}
		else if(p==24){
			window.open('RincianTindakanObatKSO_BPJS_fix.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=1','_blank');
		}
		else if(p==25){
			window.open('RincianTindakanObatKSO_BPJS_fix.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2','_blank');
		}
		else if(p==101){
			//window.open('RincianTindakanAll.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&tipe=0','_blank');
			window.open('RincianTindakanAllPel.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&tipe=0','_blank');
		}
		else if(p==102){
			//window.open('RincianTindakanAll.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&tipe=1','_blank');
			window.open('RincianTindakanAllPel.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&tipe=1','_blank');
		}
		else if(p==103){
			//window.open('RincianTindakanAll.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&tipe=2','_blank');
			window.open('RincianTindakanAllPel.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&tipe=2','_blank');
		}
		else if(p==104){
			window.open('form_konfirmasi_krs.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&tipe=2','_blank');
		}
		else if(p==105){
			window.open('RincianObatAll.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&tipe=0','_blank');
		}
		else if(p==106){
			window.open('RincianObatAll.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&tipe=1','_blank');
		}
		else if(p==107){
			window.open('RincianObatAll.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&tipe=2','_blank');
		}
		else if(p==108){
			//window.open('RekapTindakanAll.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&tipe=0','_blank');
			window.open('RekapTindakanAllPel.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&tipe=0','_blank');
		}
		else if(p==109){
			//window.open('RekapTindakanAll.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&tipe=1','_blank');
			window.open('RekapTindakanAllPel.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&tipe=1','_blank');
		}
		else if(p==110){
			//window.open('RekapTindakanAll.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&tipe=2','_blank');
			window.open('RekapTindakanAllPel.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&tipe=2','_blank');
		}
	}
	
	function resumeMedis(){
		if(getJenisKunjungan=='3'){
			window.open('resumemedis_inap.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPasien='+getIdPasien,'_blank');
		}
		else if(getJenisKunjungan=='2'){
			window.open('resumemedis_igd.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPasien='+getIdPasien,'_blank');
		}
		else{
			window.open('resumemedis.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPasien='+getIdPasien,'_blank');
		}
		/*
		var inap = document.getElementById('cmbJnsLay').options[document.getElementById('cmbJnsLay').options.selectedIndex].lang;
		var jenislayanan=document.getElementById('cmbJnsLay').value;
		if(inap=='1' || jenislayanan=='44'){
			window.open('resumemedis_inap.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPasien='+getIdPasien+'&jenislayanan='+jenislayanan,'_blank');
		}
		else{
			window.open('resumemedis.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPasien='+getIdPasien,'_blank');
		}
		*/
	}

	function rujukRS(){
		new Popup('divRujukRS',null,{modal:true,position:'center',duration:1});
		document.getElementById('divRujukRS').popup.show();
		batalkrsan();
		goFilterAndSort("gridboxRujukRS");
		/*Request('../pembayaran/cekUnitOut.php?idKunj='+getIdKunj,'uCheckout','','GET',function(){
					//alert("Unit "+document.getElementById('uCheckout').innerHTML+" Belum Checkout. Kwitansi tidak dapat dicetak");
		});*/
	}
	
	function checkList(){
		new Popup('divCheckList',null,{modal:true,position:'center',duration:1});
		document.getElementById('divCheckList').popup.show(); 		
		jQuery('#divCheckList').load('list_pasien_pulang/form_list_pasien_pulang.php?idKunjCheckList='+getIdKunj+'&idPelCheckList='+getIdPel+'&idUserCheckList=<?=$_SESSION['userId']?>');
	}		
	function closeDivCheckList(){
		document.getElementById('divCheckList').popup.hide();
	}
	
	function checkListTerima(){
		new Popup('divCheckListTerima',null,{modal:true,position:'center',duration:1});
		document.getElementById('divCheckListTerima').popup.show(); 		
		jQuery('#divCheckListTerima').load('../report_rm/9.check_list_pnrmn.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?=$_SESSION['userId']?>');
	}
	function closeDivCheckListTerima(){
		document.getElementById('divCheckListTerima').popup.hide();
	}	
	
	function isiDataRM(){
		window.scroll(0,0);
		evCmbDataRM();
		new Popup('divIsiDataRM',null,{modal:true,position:'center',duration:1});
		document.getElementById('divIsiDataRM').popup.show();
	}
	
	function simpanPerlakuan()
	{
		var kon1;
		
		if(document.getElementById('psnKomplain').checked){
			kon1 = "2";
		}else{
			kon1 = "0";
		}
		if(document.getElementById('psnPemilik').checked){
			kon1 += ",3";
		}else{
			kon1 += ",0";
		}
		if(document.getElementById('psnPejabat').checked){
			kon1 += ",10";
		}else{
			kon1 += ",0";
		}
		jQuery("#loadGambar1").load("update_in_out.php?getIdPasien="+getIdPasien+"&kh=true&kon1="+kon1,'',function(){
			alert("update status berhasil");
			jQuery("#loadGambar").load("gambar1.php?id_pasien="+getIdPasien);
		});
	}
	
	function tampilPerlakuan()
	{
		window.scroll(0,0);
		new Popup('pKhusus',null,{modal:true,position:'center',duration:1});
		document.getElementById('pKhusus').popup.show();
	}
	
	function cekR(a)
	{
		//alert(a.id);
		if((a.checked == true) && (a.id == "pup2"))
		{
			document.getElementById("bentukP").disabled = false;
			jQuery('#bentukP').removeAttr('disabled');
			document.getElementById("ukuranP").disabled = false;
			jQuery('#ukuranP').removeAttr('disabled');
			document.getElementById("cahayaP").disabled = false;
			jQuery('#cahayaP').removeAttr('disabled');
		}else if((a.checked == false) && (a.id == "pup2"))
		{
			document.getElementById("bentukP").disabled = true;
			document.getElementById("ukuranP").disabled = true;
			document.getElementById("cahayaP").disabled = true;
		}else if((a.checked == true) && (a.id == "pup3"))
		{
			//alert(a.id);
			document.getElementById("kakuP").disabled = true;
			document.getElementById("lasequeP").disabled = true;
			document.getElementById("karningP").disabled = true;
		}else if((a.checked == true) && (a.id == "pup4"))
		{
			document.getElementById("kakuP").disabled = false;
			jQuery('#kakuP').removeAttr('disabled');
			document.getElementById("lasequeP").disabled = true;
			document.getElementById("karningP").disabled = true;
		}else if((a.checked == false) && (a.id == "pup4"))
		{
			document.getElementById("kakuP").disabled = true;
		}else if((a.checked == true) && (a.id == "pup5"))
		{
			document.getElementById("lasequeP").disabled = false;
			jQuery('#lasequeP').removeAttr('disabled');
			document.getElementById("kakuP").disabled = true;
			document.getElementById("karningP").disabled = true;
		}else if((a.checked == false) && (a.id == "pup5"))
		{
			document.getElementById("lasequeP").disabled = true;
		}else if((a.checked == true) && (a.id == "pup6"))
		{
			document.getElementById("karningP").disabled = false;
			jQuery('#karningP').removeAttr('disabled');
			document.getElementById("kakuP").disabled = true;
			document.getElementById("lasequeP").disabled = true;
		}else if((a.checked == false) && (a.id == "pup6"))
		{
			document.getElementById("karningP").disabled = true;
		}else if((a.checked == true) && (a.id == "pup8"))
		{
			document.getElementById("persisP").disabled = false;
			jQuery('#persisP').removeAttr('disabled');
		}else if((a.checked == false) && (a.id == "pup8"))
		{
			document.getElementById("persisP").disabled = true;
		}else if((a.checked == true) && (a.id == "pup10"))
		{
			document.getElementById("sensorikP").disabled = false;
			jQuery('#sensorikP').removeAttr('disabled');
		}else if((a.checked == false) && (a.id == "pup10"))
		{
			document.getElementById("sensorikP").disabled = true;
		}
	}
	
	function isiAnamnesa(){
		batalAnamnesa();
		var admin = <? echo $admin;?>;
		
		time=document.getElementById('jamServer').value.split(':');
		var tjam=parseInt((time[0].substr(0,1)=='0')?time[0].substr(1,1):time[0]);
		var tmenit=parseInt((time[1].substr(0,1)=='0')?time[1].substr(1,1):time[1]);
		var tdetik=parseInt((time[2].substr(0,1)=='0')?time[2].substr(1,1):time[2]);
		
		//alert(tjam+":"+tmenit);
		//alert(admin);
		
		jQuery("#jamAnamB").mask("99:99");
		jQuery("#jamAnamB").val(tjam+":"+tmenit);
		
		if(admin!=1)
		{
			jQuery("#trtglAnam").hide();
		}else{
			jQuery("#trtglAnam").show();
		}
		
		jQuery("#nmPA").text(jQuery("#txtNama").val());
		jQuery("#nmRM").text(jQuery("#txtNo").val());
		jQuery("#umrPA").text(jQuery("#txtUmur").val());
		jQuery("#almt").text(jQuery("#txtAlmt").val());
		
		jQuery("#loadGambar1").load("update_in_out.php?getIdPasien="+getIdPasien+"&anamnes=true");
		
		window.scroll(0,0);
		new Popup('divIsiAnamnesa',null,{modal:true,position:'center',duration:1});
		document.getElementById('divIsiAnamnesa').popup.show();
		document.getElementById('popup_overlay').style.height='900px';
		anam.loadURL('tindiag_utils.php?grdAnamnesa=true&pasien_id='+getIdPasien,'','GET');
		anamnesa_kepala_leher.multiselect('uncheckAll');
		anamnesa_cor.multiselect('uncheckAll');
		anamnesa_pulmo.multiselect('uncheckAll');
		anamnesa_inspeksi.multiselect('uncheckAll');
		anamnesa_auskultasi.multiselect('uncheckAll');
		anamnesa_palpasi.multiselect('uncheckAll');
		anamnesa_perkusi.multiselect('uncheckAll');
		anamnesa_ekstremitas.multiselect('uncheckAll');
		document.getElementById('btnDeleteAnamnesa').disabled=true;
		batalAnamnesa();
		
	}
	
	function isiSOAPIER(){
		fResetSOP();
		gantiJenis(1);
		subj.loadURL("soap_utils.php?grd=1&idPel="+getIdPel,'','GET');
		/*Obj.loadURL("soap_utils.php?grd=2&idPel="+getIdPel,'','GET');
		Ass.loadURL("soap_utils.php?grd=3&idPel="+getIdPel,'','GET');
		Plan.loadURL("soap_utils.php?grd=4&idPel="+getIdPel,'','GET');
		gi.loadURL("soap_utils.php?grd=5&idPel="+getIdPel,'','GET');
		ge.loadURL("soap_utils.php?grd=6&idPel="+getIdPel,'','GET');
		gr.loadURL("soap_utils.php?grd=7&idPel="+getIdPel,'','GET');*/
		window.scroll(0,0);
		new Popup('divIsiSOAPIER',null,{modal:true,position:'center',duration:1});
		document.getElementById('divIsiSOAPIER').popup.show();
		document.getElementById('popup_overlay').style.height='900px';
	}
	
	function isiSOAPIER1(){
		if(ssoap != 1)
		{
			fResetSOP();
		}
		//fResetSOP();
		gantiJenis(1);
		subj.loadURL("soap_utils.php?grd=1&idPel="+getIdPel,'','GET');
		/*Obj.loadURL("soap_utils.php?grd=2&idPel="+getIdPel,'','GET');
		Ass.loadURL("soap_utils.php?grd=3&idPel="+getIdPel,'','GET');
		Plan.loadURL("soap_utils.php?grd=4&idPel="+getIdPel,'','GET');
		gi.loadURL("soap_utils.php?grd=5&idPel="+getIdPel,'','GET');
		ge.loadURL("soap_utils.php?grd=6&idPel="+getIdPel,'','GET');
		gr.loadURL("soap_utils.php?grd=7&idPel="+getIdPel,'','GET');*/
		window.scroll(0,0);
		new Popup('divIsiSOAPIER',null,{modal:true,position:'center',duration:1});
		document.getElementById('divIsiSOAPIER').popup.show();
		document.getElementById('popup_overlay').style.height='900px';
	}
	
	function keluar12()
	{
		if(confirm("apakah anda yakin melakukan LOCK TINDAKAN ?"))
		{
			jQuery("#loadGambar1").load("update_in_out.php?id_pelayanan="+getIdPel+"&in=false",'',function(){
				alert("TIndakan berhasil di lock");
			});
		}
	}
	
	function pkhusus()
	{
		/*jQuery("#loadGambar1").load("update_in_out.php?getIdPasien="+getIdPasien+"&kh=true",'',function(){
			alert("");
		});*/
	}
	
	function isInform_Konsen(){
		window.scroll(0,0);
		jQuery('#iframe_inform').attr('src',"../report_rm/1.inform_konsen.php?idKunj="+getIdKunj+"&idPel="+getIdPel+"&idUsr=<?=$userId?>");
		new Popup('divInform_konsen',null,{modal:true,position:'top',duration:1});
		document.getElementById('divInform_konsen').popup.show();
	}
	
	function isTolakMedis(){
		window.scroll(0,0);
		jQuery('#iframe_tolak_medis').attr('src',"../report_rm/Form_RSU_2/penolakan_tind_medis_form.php?idKunj="+getIdKunj+"&idPel="+getIdPel+"&idUsr=<?=$userId?>");
		new Popup('divPenolakan_medis',null,{modal:true,position:'top',duration:1});
		document.getElementById('divPenolakan_medis').popup.show();
	}
	
	function isPeriksaMata(){
		window.scroll(0,0);
		jQuery('#iframe_Periksa_mata').attr('src',"../report_rm/Form_RSU_2/s_ket_periksa_mata.php?idKunj="+getIdKunj+"&idPel="+getIdPel+"&idPasien="+getIdPasien+"&idUsr=<?=$userId?>");
		new Popup('divPeriksa_mata',null,{modal:true,position:'top',duration:1});
		document.getElementById('divPeriksa_mata').popup.show();
	}
	
	function isResepMata(){
		window.scroll(0,0);
		jQuery('#iframe_Resep_mata').attr('src',"../report_rm/Form_RSU_2/resep_kcmta_form.php?idKunj="+getIdKunj+"&idPel="+getIdPel+"&idUsr=<?=$userId?>");
		new Popup('divResep_mata',null,{modal:true,position:'top',duration:1});
		document.getElementById('divResep_mata').popup.show();
	}
	function isBdhWanita(){
		window.scroll(0,0);
		jQuery('#iframe_Med_wanita').attr('src',"../report_rm/Form_RSU_2/med_chckup_stat_bdh_wnta_form.php?idKunj="+getIdKunj+"&idPel="+getIdPel+"&idUsr=<?=$userId?>");
		new Popup('divMed_wanita',null,{modal:true,position:'top',duration:1});
		document.getElementById('divMed_wanita').popup.show();
	}
	function isBdhDental(){
		window.scroll(0,0);
		jQuery('#iframe_Med_dental').attr('src',"../report_rm/Form_RSU_2/l_med_chckup_stat_dental.php?idKunj="+getIdKunj+"&idPel="+getIdPel+"&idUsr=<?=$userId?>");
		new Popup('divMed_dental',null,{modal:true,position:'top',duration:1});
		document.getElementById('divMed_dental').popup.show();
	}
	function isResumMedis(){
		window.scroll(0,0);
		jQuery('#iframe_Resum_medis').attr('src',"../report_rm/Form_RSU_2/resum_medis_form.php?idKunj="+getIdKunj+"&idPel="+getIdPel+"&idUsr=<?=$userId?>");
		new Popup('divResum_medis',null,{modal:true,position:'top',duration:1});
		document.getElementById('divResum_medis').popup.show();
	}
	function isPgwsBayi(){
		window.scroll(0,0);
		jQuery('#iframe_PgwsBayi').attr('src',"../report_rm/Form_RSU_2/pngwsn_khsus_bayi.php?idKunj="+getIdKunj+"&idPel="+getIdPel+"&idUsr=<?=$userId?>");
		new Popup('div_PgwsBayi',null,{modal:true,position:'top',duration:1});
		document.getElementById('div_PgwsBayi').popup.show();
	}
	function isNeonatus(){
		window.scroll(0,0);
		jQuery('#iframe_Neonatus').attr('src',"../report_rm/Form_RSU_2/neonatus_discharge_form.php?idKunj="+getIdKunj+"&idPel="+getIdPel+"&idUsr=<?=$userId?>");
		new Popup('div_Neonatus',null,{modal:true,position:'top',duration:1});
		document.getElementById('div_Neonatus').popup.show();
	}
	function isPenkajianLuka(){
		window.scroll(0,0);
		jQuery('#iframe_Peng_luka').attr('src',"../report_rm/Form_RSU_2/lb_pengkajian_luka.php?idKunj="+getIdKunj+"&idPel="+getIdPel+"&idUsr=<?=$userId?>");
		new Popup('div_Peng_luka',null,{modal:true,position:'top',duration:1});
		document.getElementById('div_Peng_luka').popup.show();
	}
	
	var fidRujukUnit = 0;
	function lihatPemeriksaan2(id){
		//alert('test');
		var tmpJnsLay = jQuery('#cmbJnsLay').val();
		var leg = "";
		var url = "";
		var view = "";
		if(tmpJnsLay == 60){
			leg = "DATA PEMERIKSAAN RAD";
			url = "tindakanRad/index.php?idPel="+id;
		}else if(tmpJnsLay == 57){
			leg = "DATA PEMERIKSAAN LAB";
			url = "tindakanLab/index.php?idPel="+id;
		}
		load_popup_iframe_TindLab(leg,url,view);
	}
	
	function lihatPemeriksaan(id,viewPem = false){
		// 	alert(viewPem);
		var tmpJnsLay = jQuery('#cmbJnsLay').val();
		var leg = "";
		var url = "";
		var view = "";
		if(tmpJnsLay == 60){
			//leg = "DATA PEMERIKSAAN RAD";
			//url = "tindak.php?cek=1&idPel="+id;
			Request('tindak.php?cek=1&idPel='+id+'&isView='+viewPem , 'divtind', '', 'GET');
			//jQuery("#tindak1").load("tindak.php?cek=1&idPel="+id);
		}else if(tmpJnsLay == 57){
			//leg = "DATA PEMERIKSAAN LAB";
			//url = "tindak.php?cek=2&idPel="+id;
			Request('tindakan/tindak.php?cek=2&idPel='+id+'&isView='+viewPem , 'divtind', '', 'GET',function(){
				if (viewPem == false)
					isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','cmbDokHslD');
			});
			//jQuery("#tindak1").load("tindak.php?cek=2&idPel="+id);
		}else if(tmpJnsLay == 129){
			//leg = "DATA PEMERIKSAAN LAB";
			//url = "tindak.php?cek=2&idPel="+id;
			Request('tindak.php?cek=3&idPel='+id+'&isView='+viewPem , 'divtind', '', 'GET');
			//jQuery("#tindak1").load("tindak.php?cek=2&idPel="+id);
		}
		new Popup('div_popup_tind',null,{modal:true,position:'top',duration:1});
		document.getElementById('div_popup_tind').popup.show();
		//load_popup_iframe_Tindak(leg,url,view);
	}
	
	function setPemeriksaan(){
		var tmpJnsLay = jQuery('#cmbJnsLay').val();
		var idLabRad = getIdPel;
		if(tmpJnsLay == 60 || tmpJnsLay == 57){
			lihatPemeriksaan(idLabRad);
		}
	}
	
	function menutup(){
	document.getElementById('div_popup_tind').popup.hide();
	document.getElementById('divobat').style.display='none';	
	}
	
	function gantiLabel(){
		if(fidRujukUnit == 0){
			jQuery("label[for='imgTL']").text("Pemeriksaan");
			jQuery("label[for='imgTR']").text("Tindakan");
			jQuery("label[for='imgBD']").text("List Darah");
		}else{
			jQuery("label[for='imgTL']").text("Update Pemeriksaan");
			jQuery("label[for='imgTR']").text("Update Tindakan");
			jQuery("label[for='imgBD']").text("Update List Darah");
		}
	}
	function getidRujukTindakanLab(id){
		//alert(id);
		jQuery('#keyTindLab').val(id);
		document.getElementById('div_popup_iframe').popup.hide();
	}
	function load_popup_iframe_TindLab(leg,url,view){
		var jupuk = "";
		var tmpLayLab = jQuery('#TmpLayanan').val();
		window.scroll(0,0);
		if(view == "tidak"){
			jupuk = "?idKunj="+getIdKunj+"&idPel="+fidRujukUnit+"&idUsr=<?=$userId?>&view=tidak&tmpLayLab="+tmpLayLab+"&kelasId="+getIdKelas;
		}else{
			jupuk = "&idKunj="+getIdKunj+"&idUsr=<?=$userId?>&view=&kelasId="+getIdKelas;
		}
		//alert(jupuk);
		jQuery('#legend_popup_iframe').html(leg);
		//alert(url+jupuk);
		jQuery('#popup_iframe').attr('src',url+jupuk);
		new Popup('div_popup_iframe',null,{modal:true,position:'top',duration:1});
		document.getElementById('div_popup_iframe').popup.show();
	}
	function load_popup_iframe(leg,url){
		window.scroll(0,0);
		jQuery('#legend_popup_iframe').html(leg);
		jQuery('#popup_iframe').attr('src',url+"?idKunj="+getIdKunj+"&idPel="+getIdPel+"&idUsr=<?=$userId?>");
		new Popup('div_popup_iframe',null,{modal:true,position:'top',duration:1});
		document.getElementById('div_popup_iframe').popup.show();
	}
	
	function isiMintaDarah(){
		Request('minta_no_permintaan_darah.php','temp_no_minta','','GET',proses_isi_minta_darah,'NoLoad');
	}
	
	function proses_isi_minta_darah(){
		//alert('minta_darah_util.php?idpelayanan='+getIdPel);
		//document.getElementById('no_bukti').value=document.getElementById('temp_no_minta').innerHTML;
		//alert('minta_darah_util.php?idpelayanan='+getIdPel);
		if(fidRujukUnit==0 || fidRujukUnit==''){
			document.getElementById('trBD_add').style.display='table-row';
			document.getElementById('trBD_edit').style.display='none';
			//document.getElementById('trBD_grid').style.display='none';
		}
		else{
			document.getElementById('trBD_add').style.display='none';
			document.getElementById('trBD_edit').style.display='table-row';
			//document.getElementById('trBD_grid').style.display='table-row';
		}
		
		
		md.loadURL('minta_darah_util.php?idpelayanan='+getIdPel+'&idpelayanan_inserted='+fidRujukUnit,'','GET');
		batall();
		window.scroll(0,0);
		new Popup('MintaDarah',null,{modal:true,position:'center',duration:1});
		document.getElementById('btCetak').disabled=true;
		document.getElementById('MintaDarah').popup.show();
		
		
		
		//document.getElementById('divDetil').style.display = 'none';
		//document.getElementById('MintaDarah').style.display = 'block';
	}
	
	//resep
	var resep_baru=0,actPopResep;
	function tambahResep(){
		resep_baru=1;
		actPopResep="tambah";
		document.getElementById('chRacikan').checked=false;
		document.getElementById('chkIter').checked=false;
		document.getElementById('txtJmlIter').value='';
		document.getElementById('txtJmlIter').style.display='none';
		document.getElementById('tglResepB').value='<?php echo $tglSekarangg; ?>';
		CekRacikan(document.getElementById('chRacikan'));
		//document.getElementById('trNoResep').style.display='none';
		document.getElementById('cmbApotek').disabled=false;
		jQuery('#cmbApotek').removeAttr('disabled');
		
		document.getElementById('tglResepB').disabled=false;
		jQuery('#tglResepB').removeAttr('disabled');
		document.getElementById('btnTgl').disabled=false;
		jQuery('#btnTgl').removeAttr('disabled');

		document.getElementById('chkIter').disabled=false;
		jQuery('#chkIter').removeAttr('disabled');
		document.getElementById('txtJmlIter').readOnly=false;
		new Popup('divResep',null,{modal:true,position:'center',duration:1});
		document.getElementById('divResep').popup.show();
		r.loadURL("tindiag_utils.php?grdResep=true&pelayanan_id=0","","GET");
		document.getElementById('txtNmObat').focus();
		if(jQuery("#cmbTmpLay").val()==45)
		{
			jQuery("#cmbApotek").val(3);
		}else{
			jQuery("#cmbApotek").val(2);
		}
		//jQuery("cmbApotek").val(2);
		document.getElementById("cmbApotek").disabled = false;
	}
	
	function fKlikChkIter(obj){
		if (obj.checked){
			document.getElementById('txtJmlIter').style.display = 'table-row';
		}else{
			document.getElementById('txtJmlIter').style.display = 'none';
		}
	}
	<!--joker-->
	function fKlikChkObatManual(obj){
		if (obj.checked){
			document.getElementById('txtNmObat').style.display='none';
			document.getElementById('txtAreaNmObat').style.display='table-row';
			document.getElementById('obatBill').style.display='none';
			//document.getElementById('txtNmObat').style.visibility='collapse';
			//document.getElementById('txtAreaNmObat').style.visibility='table-row';
		}else{
			document.getElementById('txtNmObat').style.display='table-row';
			document.getElementById('txtAreaNmObat').style.display='none';
			document.getElementById('obatBill').style.display='inline';
			//document.getElementById('txtNmObat').style.visibility='table-row';
			//document.getElementById('txtAreaNmObat').style.visibility='collapse';
		}
		CekRacikan(document.getElementById('chRacikan'));
	}
	
	function CekRacikan(obj){
		if (obj.checked && document.getElementById('chkObatManual').checked==false){
			document.getElementById('satuanRacikan').style.visibility='visible';
			document.getElementById('trRacikan').style.visibility='visible';
			document.getElementById('trJmlBahan').style.visibility='visible';
			jQuery("#bobatN").show();
		}else if(obj.checked && document.getElementById('chkObatManual').checked==true){
			jQuery("#bobatN").show();
			document.getElementById('satuanRacikan').style.visibility='collapse';
			document.getElementById('trRacikan').style.visibility='collapse';
			document.getElementById('trJmlBahan').style.visibility='collapse';
		}else{
			document.getElementById('satuanRacikan').style.visibility='collapse';
			document.getElementById('trRacikan').style.visibility='collapse';
			document.getElementById('trJmlBahan').style.visibility='collapse';
			jQuery("#bobatN").hide();
		}
	}
	//resep
	function editResep(){
	var noResep=document.getElementById('noResep').value;
	var apotek_id=document.getElementById('cmbApotek').value;
	var url,sisip;
		if (noResep=="undefined"){
			alert("Pilih Resep Terlebih Dahulu !");
			return false;
		}else{
			sisip = aResep.getRowId(aResep.getSelRow()).split("|");
			tgl_resep = sisip[1];
			var admin = <?php echo $admin; ?>;
			if(admin == 1){
				var tgl2R = sisip[1].split('-');
				document.getElementById('tglResepB').value = tgl2R[2]+'-'+tgl2R[1]+'-'+tgl2R[0];
			}
			resep_baru=0;
			actPopResep="edit";
			document.getElementById('chRacikan').checked=false;
			CekRacikan(document.getElementById('chRacikan'));
			//document.getElementById('trNoResep').style.display='none';
			document.getElementById('cmbApotek').disabled=true;
			document.getElementById('tglResepB').disabled=true;
			document.getElementById('btnTgl').disabled=true;
			document.getElementById('chkIter').disabled=true;
			document.getElementById('txtJmlIter').readOnly=true;
			new Popup('divResep',null,{modal:true,position:'center',duration:1});
			document.getElementById('divResep').popup.show();
			url="tindiag_utils.php?grdResep=true&pelayanan_id="+getIdPel+"&noResep="+noResep+"&apotek="+apotek_id+"&tgl_resep="+tgl_resep;
			//alert(url);
			r.loadURL(url,"","GET");
			document.getElementById('txtNmObat').focus();
		}
	}
	//resep
	
	function rujukN()
	{
		sRujuk = 1;
		rujukUnit('RUJUK');
	}

	function setKamar(){
		new Popup('divSetKamar',null,{modal:true,position:'center',duration:1});
		document.getElementById('divSetKamar').popup.show();
		if(jQuery("#cmbTmpLay").val()==jQuery("#cmbTL").val())
		{
			jQuery("#cmbKamarN").show();
		}else{
			jQuery("#cmbKamarN").hide();
		}
	}
	
	function rekamMedis(){
		window.open('rekamMedis.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPasien='+getIdPasien,'rekam_medis');
	}
	
	function setMutasi(){
		new Popup('divSetMutasi',null,{modal:true,position:'center',duration:1});
		document.getElementById('divSetMutasi').popup.show();
	}
        
	function ctkVis(){
		isiCombo('cmbDokVisite',getIdPel,'');
		new Popup('divCtkVis',null,{modal:true,position:'center',duration:1});
		document.getElementById('divCtkVis').popup.show();
	}
	
	function cetakVisite(){
		var dokter = document.getElementById('cmbDokVisite').value;
		var userId='<?php echo $_SESSION['userId']?>';
		//alert(dokter);
	   window.open('cetakVisite.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPasien='+getIdPasien+'&idDokter='+dokter+'&userId='+userId,'cetak_visite');
	}
	
	function cetakLab(){
		new Popup('divSetLab',null,{modal:true,position:'center',duration:1});
		document.getElementById('divSetLab').popup.show();
		setTimeout("document.getElementById('txtLab').focus()","100");
	}
//NO REGISTRASI
	function cetakLab2(){
		new Popup('divSetLab2',null,{modal:true,position:'center',duration:1});
		document.getElementById('divSetLab2').popup.show();
		setTimeout("document.getElementById('txtLab').focus()","100");
	}
	
	function cetakIzin()
	{
		new Popup('divIzin',null,{modal:true,position:'center',duration:1});
		document.getElementById('divIzin').popup.show();
		setTimeout("document.getElementById('txtIzin').focus()","100");
	}
	
	function cekTombol()
	{
		var tbl = jQuery("#cmbCaraKeluar").val();
		if(tbl=="Meninggal" || tbl=="Dirujuk" || tbl=="APS" || tbl=="Atas Ijin Dokter")
		{
			document.getElementById("btnKrs").disabled = false;
			jQuery('#btnKrs').removeAttr('disabled');
		}else{
			document.getElementById("btnKrs").disabled = true;
		}
	}
	
	function caraKeluar(val){
		isiCombo('cmbKeadaanKeluar',val,'','cmbKeadaanKeluar');	
		document.getElementById('cmbCetakKRS').disabled=false;
		jQuery('#cmbCetakKRS').removeAttr('disabled');
		if(val=="Dirujuk"){ /*dirujuk ke RS*/
			//document.getElementById('tabel_rs').style.visibility='visible';
			document.getElementById('trRujukRS').style.visibility='visible';
			document.getElementById('trRujukRSKet').style.visibility='visible';
//			document.getElementById('cmbKeadaanKeluar').innerHTML='<option value="dirujuk">dirujuk</option>';
			document.getElementById('btnCetakKRS').style.display='table-cell';
			//document.getElementById('btnMati').style.display='none';
			document.getElementById('cmbCetakKRS').value=val;
		}
		else if(val == "Meninggal"){/*meninggal*/
			//document.getElementById('tabel_rs').style.visibility='collapse';
			document.getElementById('trRujukRS').style.visibility='collapse';
			document.getElementById('trRujukRSKet').style.visibility='collapse';
			//document.getElementById('cmbKeadaanKeluar').innerHTML="<option value='Meninggal'>Meninggal</option><option value='Meninggal < 48 jam'>Meninggal < 48 jam</option><option value='Meninggal > 48 jam'>Meninggal > 48 jam</option><option value='Meninggal sebelum dirawat'>Meninggal sebelum dirawat</option>";
			document.getElementById('btnCetakKRS').style.display='none';
			//document.getElementById('btnMati').style.display='table-cell';
			document.getElementById('cmbCetakKRS').value=val;
		}
		else if(val == "Pulang Paksa"){/*Pulang Paksa*/
			//document.getElementById('tabel_rs').style.visibility='collapse';
			document.getElementById('trRujukRS').style.visibility='collapse';
			document.getElementById('trRujukRSKet').style.visibility='collapse';
//			document.getElementById('cmbKeadaanKeluar').innerHTML="<option value='Karena Biaya'>Karena Biaya</option><option value='Karena Keluarga'>Karena Keluarga</option><option value='Karena Keadaan Pasien'>Karena Keadaan Pasien</option><option value='Karena Pelayanan'>Karena Pelayanan</option>";
			document.getElementById('btnCetakKRS').style.display='none';
			//document.getElementById('btnMati').style.display='none';
			document.getElementById('cmbCetakKRS').value='APS';
		}
		else{
//			document.getElementById('cmbKeadaanKeluar').innerHTML='<option value="Perlu kontrol kembali">Perlu kontrol kembali</option><option value="Sembuh">Sembuh</option>';
			//document.getElementById('tabel_rs').style.visibility='collapse';
			document.getElementById('trRujukRS').style.visibility='collapse';
			document.getElementById('trRujukRSKet').style.visibility='collapse';
			document.getElementById('btnCetakKRS').style.display='none';
			//document.getElementById('btnMati').style.display='none';
			document.getElementById('cmbCetakKRS').value=val;
		}
		document.getElementById('cmbCetakKRS').disabled=true;
	}

	function cetakKRS(){
		window.open('krs.php','_blank');
	}
	
	function cekRad(a){
		if(a==60){
			document.getElementById('frameRad').style.display='table-row';
		}
		else{
			document.getElementById('frameRad').style.display='none';
		}
	}

	mTab=new TabView("TabView");
	mTab.setTabCaption("ANAMNESIS,DIAGNOSIS,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL LAB");
	mTab.setTabCaptionWidth("180,180,180,180,180,180");
	mTab.setTabDisplay("true,true,true,true,true,false,0");
	mTab.onLoaded(showgrid);
	mTab.setTabPage("anamnesia.php,diagnosa.php,tindakan.php,resep.php,pemakaian_bhp.php,laborat_radiologi.php");
	var c,e,f,b,d,r,aResep,aDet,bhp,anam1,subj1,sanam,ssoap;

	function showgrid()
	{
		jQuery(function(){
			dokter_tindakan = jQuery("#cmbDokTind").multiselect({
				header: false,
				minWidth: 250
			});
		});
			
		//alert("tes");
		//var sisip=a1.getRowId(a1.getSelRow()).split("|");
		//alert(a1.getSelRow());
		f=new DSGridObject("gridboxTind");
		f.setHeader("DATA TINDAKAN PASIEN");
		f.setColHeader("NO,TANGGAL,TINDAKAN,KELAS,BIAYA,JUMLAH,SUBTOTAL,DOKTER,PETUGAS INPUT,KETERANGAN");
		f.setIDColHeader(",tanggal,nama,,,,,,dokter,");
		f.setColWidth("30,100,250,75,75,75,75,200,175,150");
		f.setCellAlign("center,center,left,center,right,center,right,left,left,left");
		f.setCellHeight(20);
		f.setImgPath("../icon");
		f.setIDPaging("pagingTind");
		f.attachEvent("onRowClick","ambilDataTind");
		f.attachEvent("onRowDblClick","printReport");
		f.onLoaded(konfirmasi);
		/*if (a1.){
			var sisip=a1.getRowId(a1.getSelRow()).split("|");
		}*/
		//if(sisip[0]==''){
			f.baseURL("tindiag_utils.php?grd=true&pelayanan_id=0");
		//}else{
		//	f.baseURL("tindiag_utils.php?grd=true&pelayanan_id="+sisip[1]);
		//}
		f.Init();

		b=new DSGridObject("gridbox1");
		b.setHeader("DATA DIAGNOSA PASIEN");
		b.setColHeader("NO,TANGGAL,DIAGNOSA,BANDING,DOKTER,PRIORITAS,AKHIR,KLINIS,UNIT");
		b.setIDColHeader(",,nama,,dokter,,,,");
		b.setColWidth("30,100,250,80,180,100,70,70,70");
		b.setCellAlign("center,center,left,center,left,center,center,center,center");
		b.setCellHeight(20);
		b.setImgPath("../icon");
		b.onLoaded(konfirmasi);
		b.setIDPaging("paging1");
		b.attachEvent("onRowClick","ambilDataDiag");
		//if(sisip[0]==''){
			b.baseURL("tindiag_utils.php?grd1=true&pelayanan_id=0");
		//}else{
		//    b.baseURL("tindiag_utils.php?grd1=true&pelayanan_id="+sisip[1]);
		//}
		b.Init();
		
		//resep
		r=new DSGridObject("gridboxResep");
		r.setHeader("DATA RESEP PASIEN");
		r.setColHeader("NO,NAMA OBAT,JUMLAH,RACIKAN,DOSIS,DOKTER");
		r.setIDColHeader(",OBAT_NAMA,,,,");
		r.setColWidth("30,200,50,110,180,150");
		r.setCellAlign("center,left,center,center,left,left");
		r.setCellType("txt,txt,txt,txt,txt,txt");
		r.setCellHeight(20);
		r.setImgPath("../icon");
		r.onLoaded(konfirmasi);
		r.setIDPaging("pagingResep");
		r.attachEvent("onRowClick","ambilDataResep");
		r.baseURL("tindiag_utils.php?grdResep=true&pelayanan_id=0");
		r.Init();

		//resep
		aResep=new DSGridObject("gridboxResepAwal");
		aResep.setHeader("DATA RESEP");
		aResep.setColHeader("NO,NO RESEP,ITER RESEP,TANGGAL,APOTEK,STATUS");
		aResep.setIDColHeader(",,,,,");
		aResep.setColWidth("50,100,100,100,150,100");
		aResep.setCellAlign("center,center,center,center,left,center");
		aResep.setCellType("txt,txt,txt,txt,txt,txt,chk");
		aResep.setCellHeight(20);
		aResep.setImgPath("../icon");
		aResep.onLoaded(ambilDataResepDetail);
		//aResep.setIDPaging("pagingResepAwal");
		aResep.attachEvent("onRowClick","ambilDataResepDetail");
		aResep.baseURL("tindiag_utils.php?grdRsp1=true&pelayanan_id=0");
		aResep.Init();
		//----joker----
		aDet=new DSGridObject("gridboxResepDetail");
		aDet.setHeader("DATA OBAT DALAM RESEP");
		/*aDet.setColHeader("NO,NAMA OBAT,JUMLAH,RACIKAN,DOSIS,DOKTER,STOK,PROSES");
		aDet.setIDColHeader(",OBAT_NAMA,,,,,,");
		aDet.setColWidth("30,200,40,80,180,150,50,50");
		aDet.setCellAlign("center,left,center,center,left,left,center,center");
		aDet.setCellType("txt,txt,txt,txt,txt,txt,txt,txt");*/
		aDet.setColHeader("NO,NAMA OBAT,JUMLAH,RACIKAN,DOSIS,DOKTER,STOK");
		aDet.setIDColHeader(",OBAT_NAMA,,,,,");
		aDet.setColWidth("30,200,40,80,180,150,50");
		aDet.setCellAlign("center,left,center,center,left,left,center");
		aDet.setCellType("txt,txt,txt,txt,txt,txt,txt");
		aDet.setCellHeight(20);
		aDet.setImgPath("../icon");
		//aDet.onLoaded(konfirmasi);
		//aDet.setIDPaging("pagingResepDetail");
		//aDet.attachEvent("onRowClick");
		aDet.baseURL("tindiag_utils.php?grdRsp2=true&pelayanan_id=0&apotek_id=0");
		aDet.Init();
		
		//resep
		
		bhp = new DSGridObject("gridbox_bhp");
		bhp.setHeader("DATA PEMAKAIAN BHP");
		bhp.setColHeader("NO,TGL,NAMA BAHAN,KEPEMILIKAN,JUMLAH,KETERANGAN");
		bhp.setIDColHeader(",TGL,OBAT_NAMA,NAMA,,KET");
		bhp.setColWidth("40,130,270,100,50,250");
		bhp.setCellAlign("center,center,left,left,center,left");
		bhp.setCellType("txt,txt,txt,txt,txt,txt");
		bhp.setCellHeight(20);
		bhp.setImgPath("../icon");
		//bhp.onLoaded(konfirmasi);
		bhp.setIDPaging("paging_bhp");
		bhp.attachEvent("onRowClick","ambil_bhp");
		bhp.baseURL("bhp_utils.php?pelayanan_id_bhp="+getIdPel);				
		bhp.Init();

		// laboratorium
		lab=new DSGridObject("gridboxHsl");
		lab.setHeader("DATA HASIL LABORATORIUM PASIEN");
		lab.setColHeader("NO,TANGGAL,TINDAKAN,HASIL,NORMAL,KETERANGAN,DOKTER");
		lab.setIDColHeader(",tanggal,nama,hasil,,ket,");
		lab.setColWidth("30,100,300,100,100,75,150");
		lab.setCellAlign("center,center,left,center,right,center,right");
		lab.setCellHeight(20);
		lab.setImgPath("../icon");
		lab.onLoaded(konfirmasi);
		lab.setIDPaging("pagingHsl");
		lab.attachEvent("onRowClick","ambilDataHsl");
		if(getIdPel==''){
			lab.baseURL("hasilLab_utils.php?grd=true&pelayanan_id=0");
		}else{
			lab.baseURL("hasilLab_utils.php?grd=true&pelayanan_id="+getIdPel);
		}
		lab.Init();	
		
		// radiologi
		rad=new DSGridObject("gridboxHslRad");
		rad.setHeader("DATA HASIL RADIOLOGI PASIEN");
		rad.setColHeader("NO,TANGGAL,HASIL,DOKTER");
		rad.setIDColHeader(",,,");
		rad.setColWidth("30,100,300,100");
		rad.setCellAlign("center,center,left,left");
		rad.setCellHeight(20);
		rad.setImgPath("../icon");
		rad.onLoaded(konfirmasi);
		rad.setIDPaging("pagingHslRad");
		rad.attachEvent("onRowClick","ambilDataHslRad");
		
		lapPa=new DSGridObject("gridboxHslPa");
		lapPa.setHeader("DATA HASIL PEMERIKSAAN PASIEN");
		lapPa.setColHeader("NO,TANGGAL,MAKROSKOPIK,MIKROSKOPIK,KESIMPULAN,DOKTER");
		lapPa.setIDColHeader(",,,,,");
		lapPa.setColWidth("30,100,150,150,150,100");
		lapPa.setCellAlign("center,center,left,left,left,left");
		lapPa.setCellHeight(20);
		lapPa.setImgPath("../icon");
		lapPa.onLoaded(konfirmasi);
		lapPa.setIDPaging("pagHslPa");
		lapPa.attachEvent("onRowClick","ambilDataHslPa");
		if(getIdPel==''){
			lapPa.baseURL("hasilLab_utils.php?grd=LPA&pelayanan_id=0");
		}else{
			lapPa.baseURL("hasilLab_utils.php?grd=LPA&pelayanan_id="+getIdPel);
		}
		lab.Init();	
		
		anam1=new DSGridObject("gridbox1_1");
		anam1.setHeader("DATA ANAMNESA");
		anam1.setColHeader("NO,TANGGAL,DOKTER");
		anam1.setIDColHeader(",TGL,");
		anam1.setColWidth("30,100,350");
		anam1.setCellAlign("center,center,left");
		anam1.setCellHeight(20);
		anam1.setImgPath("../icon");
		//anam1.onLoaded(konfirmasi);
		anam1.setIDPaging("paging1_1");
		anam1.attachEvent("onRowClick","ambilDataAnamnesa1");
		anam1.baseURL("tindiag_utils.php?grdAnamnesa=true&pasien_id="+getIdPasien);
		anam1.Init();
		
		subj1 = new DSGridObject("gridbox1_2");
		subj1.setHeader(" ",false);
		subj1.setColHeader("No,Tanggal,Nama Dokter/Perawat,S,O,A,P,I,E,R");
		subj1.setIDColHeader(",,nama,,,,,,,");
		subj1.setColWidth("40,70,255,100,100,100,100,100,100,100");
		subj1.setCellAlign("center,center,left,left,left,left,left,left,left,left");
		subj1.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
		subj1.setCellHeight(20);
		subj1.setImgPath("../icon");
		subj1.setIDPaging("paging1_2");
		subj1.attachEvent("onRowClick","ambilIdS1");
		subj1.baseURL("soap_utils.php?grd=1&idPel="+getIdPel);
		subj1.Init();
	
		if(getIdPel==''){
			rad.baseURL("hasilRad_utils.php?grd=true&pelayanan_id=0");
		}else{
			rad.baseURL("hasilRad_utils.php?grd=true&pelayanan_id="+getIdPel);
		}
		rad.Init();
		
		isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','cmbDokTind',function(){
			dokter_tindakan.multiselect('refresh');
		});
		isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','cmbDokDiag,cmbDokResep,cmbDokHsl,cmbDokHslRad,id_dokter');
		/* isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','cmbDokResep');
		isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','cmbDokHsl');
		isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','cmbDokHslRad');
		isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','id_dokter'); */

		isiCombo('JnsLayanan','','1','jnsLay',isiTmpLayanan2);
		function isiTmpLayanan2(){
			isiCombo('TmpLayanan',document.getElementById('jnsLay').value,'','tmpLay');
		}
		isiCombo('cmbApotek');
	  
		Request("tindiag_utils.php?act=dok_an","dok_anastesi",'','GET');
		cekLab(document.getElementById('cmbJnsLay').value);
	}
	
	function EditObat(p){
	var tmp=p.split("|");
		//alert('edit obat : '+p);
		IdResepPop=tmp[0];
		kpPop=tmp[1];
		//qtyPop=tmp[2];
		tRow=tmp[3];
		document.getElementById('trFarmasi').style.visibility="collapse";
		document.getElementById('trCaraBayar').style.visibility="collapse";
		document.getElementById('trObat').style.visibility="visible";
		document.getElementById('newObat').value="";
		new Popup('popGrPet',null,{modal:true,position:'center',duration:1});
		document.getElementById('popGrPet').popup.show();
		document.getElementById('newObat').focus();
		
		clearTimeout(fReload);
		fReload=setTimeout("AutoRefresh()", 120000);
	}

	function refreshDok(){
		dokter_tindakan.multiselect('refresh');
	}
	
	function setUnitLagi(){
		setUnit(document.getElementById('tmpLay').value);
	}

	function showUnit(cek){
		var keywords=document.getElementById('txtTind').value;
		if(cek){
			document.getElementById('trUnit').style.visibility='visible';
			//alert("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+document.getElementById('tmpLay').value);
			Request("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+((document.getElementById('chkTind').checked==true)?document.getElementById('tmpLay').value:unitId)+
				"&jenisLay="+((document.getElementById('chkTind').checked==true)?document.getElementById('jnsLay').value:jenisUnitId)+"&inap="+getInap+"&pelayananId="+getIdPel, 'divtindakan', '', 'GET');
			//isiCombo('cmbDok',document.getElementById('tmpLay').value,'','cmbDokTind');
		}
		else {
			document.getElementById('trUnit').style.visibility='collapse';
			//alert("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+document.getElementById('cmbTmpLay').value);
			Request("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+((document.getElementById('chkTind').checked==true)?document.getElementById('tmpLay').value:unitId)+
				"&jenisLay="+((document.getElementById('chkTind').checked==true)?document.getElementById('jnsLay').value:jenisUnitId)+"&inap="+getInap+"&pelayananId="+getIdPel, 'divtindakan', '', 'GET');
			//isiCombo('cmbDok',unitId,'','cmbDokTind');
		}
		//document.getElementById('divtindakan').style.display='none';
	}

	function setUnit(val){
		var keywords=document.getElementById('txtTind').value;
		Request("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+val, 'divtindakan', '', 'GET');
		if(document.getElementById('btnSimpanTind').value=="Simpan"){
			document.getElementById('txtTind').value='';
		}
		//isiCombo('cmbDok',val,'','cmbDokTind');
	}

	var inapkah=0;
	function cekRujukInap(isinap){
		if (document.getElementById('JnsLayanan').value == 57 || document.getElementById('JnsLayanan').value == 60)
			document.getElementById('pnlCTOTujuanUnit').style.visibility = 'visible';
		else
			document.getElementById('pnlCTOTujuanUnit').style.visibility = 'collapse';
		
		
		if(isinap==1){
			inapkah=1;
			document.getElementById('trKelasRujuk').style.visibility='visible';
			document.getElementById('trKamarRujuk').style.visibility='visible';
		}
		else{
			inapkah=0;
			document.getElementById('trKelasRujuk').style.visibility='collapse';
			document.getElementById('trKamarRujuk').style.visibility='collapse';
		}
	}

	function isiTmpLayanan(){
		//isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value,getIdUnit,'',isiKelas);
		isiCombo('TmpLayananInapSaja',document.getElementById('JnsLayanan').value,getIdUnit,'TmpLayanan',isiKelas);
		cekRujukInap(document.getElementById('JnsLayanan').options[document.getElementById('JnsLayanan').options.selectedIndex].lang);
		showTindLab(document.getElementById('TmpLayanan').value);
	}

	function isiTmpLayananKonsul(){
		isiCombo('TmpLayananBukanInap',document.getElementById('JnsLayanan').value,getIdUnit,'TmpLayanan',isiKelas);
		cekRujukInap(document.getElementById('JnsLayanan').options[document.getElementById('JnsLayanan').options.selectedIndex].lang);
		showTindLab(document.getElementById('TmpLayanan').value);
	}

	function isiTmpLayananMutasi(){
		isiCombo('TmpLayanan',document.getElementById('JnsLayananMutasi').value,getIdUnit,'TmpLayananMutasi');
	}

	function isiKelas(){
		var sisipan=c.getRowId(c.getSelRow()).split("|");
		//alert(getKsoId);
		if (getKsoId=='38' || getKsoId=='39' || getKsoId=='46'){
			isiCombo('cmbKelasKamarJamkesmas',document.getElementById('TmpLayanan').value,sisipan[5],'cmbKelasRujuk',isiKamar);
		}else{
			isiCombo('cmbKelasKamar',document.getElementById('TmpLayanan').value,sisipan[5],'cmbKelasRujuk',isiKamar);
		}
		
		isiCombo('cmbDok',document.getElementById('TmpLayanan').value,'','cmbDokTujuanUnit','no');
		
		showTindLab(document.getElementById('TmpLayanan').value);
		document.getElementById('pnlCTOTujuanUnit').style.display = "none";
		// alert(document.getElementById('TmpLayanan').value);
		if(document.getElementById('TmpLayanan').value == '58'){
			document.getElementById('pnlCTOTujuanUnit').style.display = "table-row";
		}
	}
	
	function isiKelas2(){
		var sisipan=c.getRowId(c.getSelRow()).split("|");
		//alert(getKsoId);
		if (getKsoId=='38' || getKsoId=='39' || getKsoId=='46'){
			isiCombo('cmbKelasKamarJamkesmas',document.getElementById('TmpLayanan').value,sisipan[5],'cmbKelasRujuk',isiKamar);
		}else{
			isiCombo('cmbKelasKamar',document.getElementById('TmpLayanan').value,sisipan[5],'cmbKelasRujuk',isiKamar);
		}
		
		//isiCombo('cmbDok',document.getElementById('TmpLayanan').value,'','cmbDokTujuanUnit','no');
		
		showTindLab(document.getElementById('TmpLayanan').value);
	}
	
	function gantiDokterTujuan(comboDokter,statusCek){
		if(statusCek==true){
			isiCombo('cmbDokPengganti',document.getElementById('TmpLayanan').value,'','cmbDokTujuanUnit');
		}
		else{
			isiCombo('cmbDok',document.getElementById('TmpLayanan').value,'','cmbDokTujuanUnit');
		}
			
	}

	function isiKamar(){
		var sisipan=c.getRowId(c.getSelRow()).split("|");
		isiCombo('cmbKamar',document.getElementById('TmpLayanan').value+','+document.getElementById('cmbKelasRujuk').value,sisipan[6],'cmbKamarRujuk',setTarif);
	}

	function setTarif(){
		document.getElementById('spanTarif').innerHTML = document.getElementById('cmbKamarRujuk').options[document.getElementById('cmbKamarRujuk').options.selectedIndex].lang;
	}

	function isiPindahKamar(){
		isiCombo('cmbKamar',document.getElementById('cmbTL').value+','+document.getElementById('cmbKelas').value,'','cmbKamar',setTarifPindah);
	}
	
	function isiPindahKamar_ifinap(){
	    isiCombo('cmbKamar',document.getElementById('cmbTmpLay').value+','+document.getElementById('cmbKelas_ifinap').value,'','cmbKamar_ifinap',setTarifIfInap);
	}
	
	function setTarifIfInap(){
	    document.getElementById('spanTarifPindah_ifinap').innerHTML = document.getElementById('cmbKamar_ifinap').options[document.getElementById('cmbKamar_ifinap').options.selectedIndex].lang;
	}

	function setTarifPindah(){
		document.getElementById('spanTarifPindah').innerHTML = document.getElementById('cmbKamar').options[document.getElementById('cmbKamar').options.selectedIndex].lang;
	}

	function isiKelasKamar(unit){
		if (getKsoId=='38' || getKsoId=='39' || getKsoId=='46'){
			isiCombo('cmbKelasKamarJamkesmas',unit,'','cmbKelas',isiPindahKamar);
		}else{
			isiCombo('cmbKelasKamar',unit,'','cmbKelas',isiPindahKamar);
		}
		
		if(jQuery("#cmbTmpLay").val()==jQuery("#cmbTL").val())
		{
			jQuery("#cmbKamarN").show();
		}else{
			jQuery("#cmbKamarN").hide();
		}
	}

	function isiKelasKamar2(){
		isiKelasKamar(document.getElementById('cmbTL').value);
	}

	function isiCmbTL(){
		isiCombo('TmpLayananInapSaja',document.getElementById('cmbJL').value,'','cmbTL',isiKelasKamar2);
		if(jQuery("#cmbTmpLay").val()==jQuery("#cmbTL").val())
		{
			jQuery("#cmbKamarN").show();
		}else{
			jQuery("#cmbKamarN").hide();
		}
	}

	//Tindakan
	var RowIdx1;
	var fKeyEnt1;
	function suggest1(e,par){
		var keywords=par.value;//alert(keywords);
		if(e == 'cariTind'){
			if(document.getElementById('divtindakan').style.display == 'block'){
				document.getElementById('divtindakan').style.display='none';
			}
			else{
				Request("tindakanlist.php?findAll=true&aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+((document.getElementById('chkTind').checked==true)?document.getElementById('tmpLay').value:unitId)+"&jenisLay="+((document.getElementById('chkTind').checked==true)?document.getElementById('jnsLay').value:jenisUnitId)+"&inap="+getInap+"&pelayananId="+getIdPel+"&allKelas="+all, 'divtindakan', '', 'GET');
				if (document.getElementById('divtindakan').style.display=='none') fSetPosisi(document.getElementById('divtindakan'),par);
				document.getElementById('divtindakan').style.display='block';
			}
		}
		else{
		
			if(keywords==""){
				document.getElementById('divtindakan').style.display='none';
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
					var tblRow=document.getElementById('tblTindakan').rows.length;
					if (tblRow>0){
						//alert(RowIdx1);
						if (key==38 && RowIdx1>0){
							RowIdx1=RowIdx1-1;
							document.getElementById('lstTind'+(RowIdx1+1)).className='itemtableReq';
							if (RowIdx1>0) document.getElementById('lstTind'+RowIdx1).className='itemtableMOverReq';
						}
						else if (key == 40 && RowIdx1 < tblRow){
							RowIdx1=RowIdx1+1;
							if (RowIdx1>1) document.getElementById('lstTind'+(RowIdx1-1)).className='itemtableReq';
							document.getElementById('lstTind'+RowIdx1).className='itemtableMOverReq';
						}
					}
				}else if (key==13){
					//alert('masuk tindakan');
					if (RowIdx1>0){
						if (fKeyEnt1==false){
							fSetTindakan(document.getElementById('lstTind'+RowIdx1).lang);
						}
						else{
							fKeyEnt1=false;
						}
					}
				}else if (key!=27 && key!=37 && key!=39){
					RowIdx1=0;
					fKeyEnt1=false;
					var all=0;
					if(key==123){
						all=1;
					}
					//alert("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+((document.getElementById('chkTind').checked==true)?document.getElementById('tmpLay').value:unitId));
					//alert(getIdKelas);
					Request("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+((document.getElementById('chkTind').checked==true)?document.getElementById('tmpLay').value:unitId)+
						"&jenisLay="+((document.getElementById('chkTind').checked==true)?document.getElementById('jnsLay').value:jenisUnitId)+"&inap="+getInap+"&pelayananId="+getIdPel+"&allKelas="+all, 'divtindakan', '', 'GET');
					if (document.getElementById('divtindakan').style.display=='none')
						fSetPosisi(document.getElementById('divtindakan'),par);
					document.getElementById('divtindakan').style.display='block';
				}
			}
		
		}
	}

	function fSetTindakan(par){
		var cdata=par.split("*|*");
		//alert(cdata);
		document.getElementById("tindakan_id").value=cdata[0];
		document.getElementById("mtId").value=cdata[4];
		document.getElementById("txtTind").value=cdata[1];
		document.getElementById("txtBiaya").value=cdata[3];
		document.getElementById("txtBiayaAskes").value=cdata[6];
		document.getElementById("tdKelas").innerHTML=cdata[5];
		document.getElementById("akUnit").value=cdata[8];
		document.getElementById('divtindakan').style.display='none';
		
		if(cdata[7]==1){
		document.getElementById('txtBiaya').readOnly=false;
		
		}else{
		document.getElementById('txtBiaya').readOnly=true;
		}
		
		if(document.getElementById('txtQty').value==''){
			document.getElementById('txtQty').value='1';
		}
		
		if (cdata[4]=="750"){
			document.getElementById('cmbDokTind').value="584";
		}else if (cdata[4]=="742" || cdata[4]=="746" || cdata[4]=="747" || cdata[4]=="748"){
			document.getElementById('cmbDokTind').value="612";
		}else if (cdata[4]=="743" || cdata[4]=="744"){
			document.getElementById('cmbDokTind').value="581";
		}
		
		document.getElementById('cmbDokTind').focus();
	}
		
	//Diagnosa
	var RowIdx;
	var fKeyEnt;
	function suggest(e,par){
		if(document.getElementById('chkICD_manual').checked){
			return false;	
		}
		
		var keywords=par.value;//alert(keywords);
		if(e == 'cariDiag'){
			if(document.getElementById('divdiagnosa').style.display == 'block'){
				document.getElementById('divdiagnosa').style.display='none';
			}
			else{
				if(document.getElementById('chkPenyebabKecelakaan').checked==true){
					Request('diagnosalist.php?findAll=true&aKeyword='+keywords+'&unitId='+unitId+'&PK=1' , 'divdiagnosa', '', 'GET' );	
				}
				else{
					Request('diagnosalist.php?findAll=true&aKeyword='+keywords+'&unitId='+unitId+'&PK=0' , 'divdiagnosa', '', 'GET' );
				}
				if (document.getElementById('divdiagnosa').style.display=='none') fSetPosisi(document.getElementById('divdiagnosa'),par);
				document.getElementById('divdiagnosa').style.display='block';
			}
		}
		else{
			if(keywords==""){
				document.getElementById('divdiagnosa').style.display='none';
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
					var tblRow=document.getElementById('tblDiagnosa').rows.length;
					if (tblRow>0){
						//alert(RowIdx);
						if (key==38 && RowIdx>0){
							RowIdx=RowIdx-1;
							document.getElementById('lstDiag'+(RowIdx+1)).className='itemtableReq';
							if (RowIdx>0) document.getElementById('lstDiag'+RowIdx).className='itemtableMOverReq';
						}else if (key == 40 && RowIdx < tblRow){
							RowIdx=RowIdx+1;
							if (RowIdx>1) document.getElementById('lstDiag'+(RowIdx-1)).className='itemtableReq';
							document.getElementById('lstDiag'+RowIdx).className='itemtableMOverReq';
						}
					}
				}
				else if (key==13){
					if (RowIdx>0){
						if (fKeyEnt==false){
							fSetPenyakit(document.getElementById('lstDiag'+RowIdx).lang);
						}else{
							fKeyEnt=false;
						}
					}
				}
				else if (key!=27 && key!=37 && key!=39){
					RowIdx=0;
					fKeyEnt=false;
					if(document.getElementById('chkPenyebabKecelakaan').checked==true){
						Request('diagnosalist.php?aKeyword='+keywords+'&unitId='+unitId+'&PK=1', 'divdiagnosa', '', 'GET' );
					}
					else{
						Request('diagnosalist.php?aKeyword='+keywords+'&unitId='+unitId+'&PK=0', 'divdiagnosa', '', 'GET' );
					}
					if (document.getElementById('divdiagnosa').style.display=='none') fSetPosisi(document.getElementById('divdiagnosa'),par);
					document.getElementById('divdiagnosa').style.display='block';
				}
			}
		}
	}

	function fSetPenyakit(par){
		var cdata=par.split("*|*");
		document.getElementById("diagnosa_id").value=cdata[0];
		document.getElementById("txtDiag").value=cdata[1];
		document.getElementById('divdiagnosa').style.display='none';
		
		//penyebab kecelakaan
		if(document.getElementById('chkPenyebabKecelakaan').checked){
			Request('../combo_utils.php?id=PenyebabKecelakaan&value='+cdata[2],'cmbPenyebab','','GET');
			document.getElementById('trPenyebab').style.display = 'table-row';
		}
		else{
			document.getElementById('trPenyebab').style.display = 'none';
		}
		
		document.getElementById('cmbDokDiag').focus();
	}

	//Obat Resep
	var RowIdxObat;
	var fKeyEntObat;
	function suggestObat(e,par){
		var keywords=par.value;
		if(keywords==""){
			document.getElementById('divobat').style.display='none';
		}
		else{
			if(par.value.length > 2){
				var key;
				if(window.event) {
					key = window.event.keyCode;
				}
				else if(e.which) {
					key = e.which;
				}
				//alert(key);
				if (key==38 || key==40){
					var tblRow=document.getElementById('tblObat').rows.length;
					if (tblRow>0){
						//alert(RowIdx);
						if (key==38 && RowIdxObat>0){
							RowIdxObat=RowIdxObat-1;
							document.getElementById(RowIdxObat+1).className='itemtableReq';
							if (RowIdxObat>0) document.getElementById(RowIdxObat).className='itemtableMOverReq';
						}
						else if (key == 40 && RowIdxObat < tblRow){
							RowIdxObat=RowIdxObat+1;
							if (RowIdxObat>1) document.getElementById(RowIdxObat-1).className='itemtableReq';
							document.getElementById(RowIdxObat).className='itemtableMOverReq';
						}
					}
				}
				else if (key==13){
					if (RowIdxObat>0){
						if (fKeyEntObat==false){
							fSetObat(document.getElementById(RowIdxObat).lang);
						}
						else{
							fKeyEntObat=false;
						}
					}
				}
				else if (key!=27 && key!=37 && key!=39){
					fKeyEntObat=false;
					if (key==123){
						/*RowIdxObat=0;
						Request('obatlist.php?aKepemilikan=0&aHarga='+getKepemilikan+'&idapotek='+document.getElementById('cmbApotek').value+'&aKeyword='+keywords, 'divobat', '', 'GET' );*/
					}
					else if (key==120){
						//alert(RowIdxObat);
					}
					else{
						RowIdxObat=0;
						Request('obatlist.php?aKepemilikan='+getKepemilikan+'&aHarga='+getKepemilikan+'&idapotek='+document.getElementById('cmbApotek').value+'&aKeyword='+keywords, 'divobat', '', 'GET' );
					}
					if (document.getElementById('divobat').style.display=='none')
						//document.getElementById('divobat').style.top='135px';
						fSetPosisi(document.getElementById('divobat'),par);
					document.getElementById('divobat').style.display='block';
				}
			}
		}
	}
	
	function suggestObat2(e,par){
	var keywords=par.value;//alert(keywords);
	var i=1;
		//alert(par.offsetLeft);
		if(keywords.length<2){
			document.getElementById('divobat_edit').style.display='none';
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
				var tblRow=document.getElementById('tblObat').rows.length;
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
						fSetObat2(document.getElementById(RowIdx).lang);
					}else{
						fKeyEnt=false;
					}
				}
			}else if (key!=27 && key!=37 && key!=39 && key!=9){
				fKeyEnt=false;
				if (key==123){
					RowIdx=0;
					//alert('obatlist2.php?aKepemilikan=0&aHarga='+getKepemilikan+'&idapotek='+document.getElementById('cmbApotek').value+'&aKeyword='+keywords+'&no='+i);
					Request('obatlist2.php?aKepemilikan=0&aHarga='+getKepemilikan+'&idapotek='+document.getElementById('cmbApotek').value+'&aKeyword='+keywords+'&no='+i , 'divobat_edit', '', 'GET' );
				}else if (key==120){
					alert(RowIdx);
				}else{
					RowIdx=0;
					//alert('obatlist2.php?aKepemilikan='+getKepemilikan+'&aHarga='+getKepemilikan+'&idapotek='+document.getElementById('cmbApotek').value+'&aKeyword='+keywords+'&no='+i);
					Request('obatlist2.php?aKepemilikan='+getKepemilikan+'&aHarga='+getKepemilikan+'&idapotek='+document.getElementById('cmbApotek').value+'&aKeyword='+keywords+'&no='+i , 'divobat_edit', '', 'GET' );
				}
				if (document.getElementById('divobat_edit').style.display=='none'){
					//fSetPosisi(document.getElementById('divobat'),par);
					document.getElementById('divobat_edit').style.left="135px";
					document.getElementById('divobat_edit').style.top="55px";
				}
				document.getElementById('divobat_edit').style.display='block';
			}
		}
		
	}

	
	//resep
	function fSetObat(par){
		var cdata=par.split("*|*");
		document.getElementById("idObat").value = cdata[1];
		document.getElementById("txtNmObat").value = cdata[2];
		document.getElementById("hargajual").value = cdata[4];
		document.getElementById("hargabeli").value = cdata[7];
		//document.getElementById("txtStok").value = cdata[5];
		document.getElementById('divobat').style.display='none';
		document.getElementById('txtJml').focus();
	}
	
	function fSetObat2(par){
		var tpar=par;
		var cdata;
		while (tpar.indexOf(String.fromCharCode(5))>0){
			tpar=tpar.replace(String.fromCharCode(5),"'");
		}
		while (tpar.indexOf(String.fromCharCode(3))>0){
			tpar=tpar.replace(String.fromCharCode(3),'"');
		}
		cdata=tpar.split("*|*");
		tObat=cdata[1];
		tKpid=cdata[7];
		tHNetto=cdata[9];
		tHJual=cdata[4];
		tQtyStok=cdata[5];
		//tQty=qtyPop;
		document.getElementById('divobat_edit').style.display='none';
		document.getElementById('newObat').value=cdata[2];
	}
	
	function SimpanNewObat(){
		var tmp,no_resep,act,fdata;
		tmp = r.getRowId(r.getSelRow()).split('|');
		no_resep = tmp[2];
		if (document.getElementById('trObat').style.visibility=="visible"){
			if (confirm('Yakin Ingin Mengubah Resep ?')){
				//rDet.loadURL(url,"","GET");
				var cid=aDet.getRowId(tRow).split("|");
				var newId=cid[0]+"|"+tHJual+"|"+tHNetto+"|"+cid[3]+"|"+tKpid+"|"+tObat+"|"+cid[6];
				var stot=cid[3]*tHJual;
				
				aDet.cellsSetValue(tRow,2,document.getElementById('newObat').value);
				aDet.cellsSetValue(tRow,7,tQtyStok);
				aDet.setRowId(tRow,newId);
				HitungTot();
				document.getElementById('popGrPet').popup.hide();
			}
		}else if (document.getElementById('trFarmasi').style.visibility=="visible"){
			act="act=kirimUnit&idunitRujuk="+document.getElementById('IdFarmasiRujuk').value+"&no_rm="+tmp[3]+"&IdPel="+tmp[4];
			url="../transaksi/utils.php?"+act+"&grd=true&no_resep="+no_resep+"&status="+document.getElementById('cmbDilayani').value+"&idunit=<?php echo $idunit; ?>&iduser=<?php echo $iduser; ?>&tanggal="+document.getElementById('txtTgl').value;
			if (confirm('Yakin Ingin Mengirim Resep ke Unit Lain ?')){
				r.loadURL(url,"","GET");
				document.getElementById('popGrPet').popup.hide();
			}
		}else{
			act="act=UbahCaraBayar&newIdCarabayar="+document.getElementById('IdCaraBayar').value+"&no_rm="+tmp[3]+"&IdPel="+tmp[4];
			url="../transaksi/utils.php?"+act+"&grd=true&no_resep="+no_resep+"&status="+document.getElementById('cmbDilayani').value+"&idunit=<?php echo $idunit; ?>&iduser=<?php echo $iduser; ?>&tanggal="+document.getElementById('txtTgl').value;
			if (confirm('Yakin Ingin Mengubah Cara Bayar Pasien ?')){
				r.loadURL(url,"","GET");
				document.getElementById('popGrPet').popup.hide();
			}
		}
		
		clearTimeout(fReload);
		fReload=setTimeout("AutoRefresh()", 120000);
	}
	
	function CheckedObat(k){
		//alert(aDet.obj.childNodes[0].childNodes[k-1].childNodes[5].childNodes[0].checked);
		if (aDet.obj.childNodes[0].childNodes[k-1].childNodes[7].childNodes[0].checked){
			if (parseFloat(aDet.obj.childNodes[0].childNodes[k-1].childNodes[6].innerHTML) < parseFloat(aDet.obj.childNodes[0].childNodes[k-1].childNodes[2].innerHTML)){
				alert("Stok Obat Yang Mau Dibeli Tdk Mencukupi !");
				aDet.obj.childNodes[0].childNodes[k-1].childNodes[7].childNodes[0].checked=false;
				return false;
			}else if (parseFloat(aDet.obj.childNodes[0].childNodes[k-1].childNodes[2].childNodes[0].innerHTML)==0){
				alert("Jumlah Obat Yang Mau Dibeli Tdk Boleh 0 !");
				aDet.obj.childNodes[0].childNodes[k-1].childNodes[7].childNodes[0].checked=false;
				return false;
			}
		}
		
		HitungTotObat();	
	}
	
	function ValidasiText(p){
	var tmp=p;
		while (tmp.indexOf('.')>-1){
			tmp=tmp.replace('.','');
		}
		while (tmp.indexOf(',')>-1){
			tmp=tmp.replace(',','.');
		}
		return tmp;
	}
	
	function HitungTotObat(){
		var tmp=0;
		var sisip;
		document.getElementById('tot_harga').value="0";
		for (var k=0;k<aDet.getMaxRow();k++){
			if (aDet.obj.childNodes[0].childNodes[k].childNodes[7]){
				if (aDet.obj.childNodes[0].childNodes[k].childNodes[7].childNodes[0].checked){
					sisip=aDet.getRowId(k+1).split('|');
					tmp=tmp+parseFloat(ValidasiText(sisip[7]));
				}
			}
		}
		document.getElementById('tot_harga').value=tmp;
	}
	
	function saveResep(){
		var tmp,url;
		
		tmp="";
		for (var k=0;k<aDet.getMaxRow();k++){
			if (aDet.obj.childNodes[0].childNodes[k].childNodes[7].childNodes[0].checked && aDet.obj.childNodes[0].childNodes[k].childNodes[7].childNodes[0].disabled==false){
				tmp+=aDet.getRowId(k+1)+"*|*";
			}
		}

		if (tmp==""){
			alert("Pilih Item Obat Yang Mau Dibeli !");
			document.getElementById('btnSimpan').disabled=false;
			jQuery('#btnSimpan').removeAttr('disabled');
			return false;
		}else{
			tmp=tmp.substr(0,tmp.length-3);
		}
		
		url='tindiag_utils.php?grdRsp2=true&pelayanan_id='+getIdPel+'&apotek_id='+document.getElementById('cmbApotek').value+'&tgl_resep='+document.getElementById('tglResep').value+'&smpn=btnSimpanResepObat&act=tambah&idPel='+getIdPel+'&no_rm='+getNoPasien+'&no_resep='+document.getElementById('noResep').value+'&subtotal='+document.getElementById('tot_harga').value+'&fdata='+tmp+"&idunit="+getIdUnit+"&iduser=<?php echo $_SESSION['userId']; ?>&shift=0&tanggal="+document.getElementById('tglResep').value;
		//alert(url);

		if (confirm('Apakah Data Sudah Benar?')){
			aDet.loadURL(url,'','GET');
		}else{
			
		}
		
	}

	function smp(ev)
	{
	       if(ev.which==13)
	       simpan(document.getElementById('txtLab').value,'btnSimpanLab','txtLab');
	}

	function smp2(ev)
	{
		//alert (ev.which);
	       if(ev.which==13)
	       simpan(document.getElementById('txtLab2').value,'btnSimpanLab2','txtLab2');
	}
	
	
	function jatobChange(){
	
	if(document.getElementById('jns12').value=='Sehat')
        {
                document.getElementById('div_sakit').style.display='none';
                document.getElementById('div_sehat').style.display='inline-block';
                document.getElementById('div_sakit2').style.display='inline-block';
                document.getElementById('txtIzin').style.display='inline-block';
        }else{
                document.getElementById('div_sakit').style.display='none';
                document.getElementById('div_sakit2').style.display='none';
                document.getElementById('div_sehat').style.display='none';
        }
	}
	function cetak_izin_bak()
	{
		if(jQuery("#txtIzin").val()=="")
		{
			alert("Isi Lama Izin Terlebih Dahulu");
			return false;
		}
		
		//var inap = document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
		//alert(getIdPel+"-"+getIdKunj+"-"+inap+"-"+jQuery("#txtIzin").val());
		if(document.getElementById('jns12').value=='Sakit')
		{
			window.open('sk_sakit.php?idPel='+getIdPel+'&idKunj='+getIdKunj+'&jml='+jQuery("#txtIzin").val()+'&jns1='+jQuery("#jns12").val()+'&idUser=<?php echo $userId;?>');
		}else{
			window.open('s_sehat.php?idPel='+getIdPel+'&idKunj='+getIdKunj+'&jml='+jQuery("#txtIzin").val()+'&jns1='+jQuery("#jns12").val()+'&idUser=<?php echo $userId;?>');
		}
		jQuery("#txtIzin").val("");
	}
	
	function cetak_izin()
	{
			if(jQuery("#txtIzin").val()=="" && jQuery("#jns12").val()=='Sehat')
			{
					alert("Isi Keperluan Surat Keterangan Sehat");
					return false;
			}

			//var inap = document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
			//alert(getIdPel+"-"+getIdKunj+"-"+inap+"-"+jQuery("#txtIzin").val());
			if(document.getElementById('jns12').value=='Sakit')
			{
					window.open('sk_sakit_form.php?idPel='+getIdPel+'&idKunj='+getIdKunj+'&jml='+jQuery("#txtIzin").val()+'&jns1='+jQuery("#jns12").val()+'&idUser=<?php
echo $userId;?>');
			}else{
					window.open('s_sehat.php?idPel='+getIdPel+'&idKunj='+getIdKunj+'&jml='+jQuery("#txtIzin").val()+'&jns1='+jQuery("#jns12").val()+'&idUser=<?php
echo $userId;?>');
			}
			jQuery("#txtIzin").val("");
	}

	
	function cetak_mati()
	{
		
		window.open('s_mati.php?idPel='+getIdPel+'&idKunj='+getIdKunj+'&idUser=<?php echo $userId;?>');
		
	}
	
	function batalHslLabPa(){
		document.getElementById("idTindHslLabPa").value="";
		document.getElementById("txtMakros").value="";
		document.getElementById("txtMikros").value="";
		document.getElementById("txtKesimpulan").value="";
		document.getElementById("txtAnjuran").value="";
		document.getElementById("cmbDokLabPa").selectedIndex="";
		document.getElementById("btnSimpanHslLabPa").value="Tambah";
		var p= "btnHapusHslLabPa*-*true";
		fSetValue(window,p);
		document.getElementById('frameRad').contentWindow.kensel();
	}
	
	var eksyennya = '';
	function simpan(action,id,cek)
	{
		//alert(action+'-'+id);
		//if(ValidateForm("tindakan_id,txtBiaya,txtQty",'ind'))
		//{
		var userId='<?php echo $_SESSION['userId']?>';
		var idTind = document.getElementById("tindakan_id").value;
		var tind = document.getElementById("txtTind").value;
		var biaya = document.getElementById("txtBiaya").value;
		var biayaAskes = document.getElementById("txtBiayaAskes").value;
		var qty = document.getElementById("txtQty").value;
		var ket = document.getElementById("txtKet").value;
		var exprt = document.getElementById("txtExprt").value;
		var idBaru = document.getElementById("id_tind").value;
		var idDok = document.getElementById("cmbDokTind").value;
		var idDokDiag = document.getElementById("cmbDokDiag").value;
		var isDokPengganti = 0;
		var isDokTujuanPengganti = 0;

		var jnsLayRujukUnit = document.getElementById("JnsLayanan").value;
		var tmpLayRujukUnit = document.getElementById("TmpLayanan").value;
		var ketRujukUnit = document.getElementById("txtKetRujuk").value;
		var idDokRujukUnit = document.getElementById("cmbDokRujukUnit").value;
		var idDokTujuanUnit = document.getElementById("cmbDokTujuanUnit").value;
		var idRujukUnit = document.getElementById("idRujukUnit").value;
		var idKelasRujukUnit = getIdKelas; //kelas diambil dari kunjungan
		var idKamarRujukUnit = '';
		if(inapkah==1){
			var idKelasRujukUnit = document.getElementById("cmbKelasRujuk").value;
			var idKamarRujukUnit = document.getElementById("cmbKamarRujuk").value;
		}

		//var jnsLayRujukRS=document.getElementById("JnsLayananRS").value;
		//var tmpLayRujukRS=document.getElementById("TmpLayananRS").value;
		var idRS = document.getElementById("cmbRS").value;
		var ketRujukRS = document.getElementById("txtKetRujukRS").value;
		var idDokRujukRS = document.getElementById("cmbDokRujukRS").value;
		var idRujukRS = document.getElementById("idRujukRS").value;
		var caraKeluar = document.getElementById("cmbCaraKeluar").value;
		var keadaanKeluar = document.getElementById("cmbKeadaanKeluar").value;
		var kasus = document.getElementById("cmbKasus").value;
		var emergency = document.getElementById("cmbEmergency").value;
		var kondisiPasien = 0;//document.getElementById("cmbKondisiPasien").value;

		var tmpLayKamar = document.getElementById("cmbTL").value;
		var jnsLayKamar = document.getElementById("cmbJL").value;
		var idSetKamar = document.getElementById("idSetKamar").value;
		var idKelas = document.getElementById("cmbKelas").value;
		var idKamar = document.getElementById("cmbKamar").value;
		var tglMasuk = document.getElementById("TglMasuk").value;
		var jamMasuk = document.getElementById("JamMasuk").value.replace(' ','');
		var jamKrs = document.getElementById("JamKrs").value.replace(' ','');
		var isManual = document.getElementById('chkManual').checked;

		var idDiag = document.getElementById("id_diag").value;
		var diag = document.getElementById("txtDiag").value;
		var diag_id = document.getElementById("diagnosa_id").value;
		if(document.getElementById('chkPenyebabKecelakaan').checked){
			diag_id = document.getElementById('cmbPenyebab').value;
		}
		//alert(diag_id);
		var isPrimer = document.getElementById("cmbUtama").value;
		var isAkhir = 0;
		if(document.getElementById('chkAkhir').checked){
			isAkhir = 1;
		}
		var isKlinis = 0;
		if(document.getElementById('chkKlinis').checked){
			isKlinis = 1;
		}
		var isMati = 0;
		if(document.getElementById('chkMati').checked){
			isMati = 1;
		}
		/*var isBanding = 0;
		if(document.getElementById('chkBanding').checked){
			isBanding = 1;
		}*/
		
		/*var isPrimer = 1;
		if(document.getElementById("chkUtama").checked == false){
			isPrimer = 0;
		}*/
		var tglKrs = document.getElementById('TglKrs').value;

		var idResep = document.getElementById("idResep").value;
		var namaobat = document.getElementById("txtNmObat").value;
		var stok = document.getElementById("txtStok").value;
		var jumlah = document.getElementById("txtJml").value;
		var satRacikan = document.getElementById("satuanRacikan").value;
		var cnoRacikan = document.getElementById("noRacikan").value;
		var dokter = document.getElementById("cmbDokResep").value;
		var apotek = document.getElementById("cmbApotek").value;
		var idObat = document.getElementById("idObat").value;
		var netto = document.getElementById("hargajual").value;
		var satuan = document.getElementById("hargabeli").value;
		var inap = document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
		var cTglNow="<?php echo $pTglSkrg; ?>";
		var racikan = "0";
		var jmlBahan = "0";
		var keyTindLab = document.getElementById("keyTindLab").value;
		var diagResep = document.getElementById("cmbDiagR").value;
		var akUnit = document.getElementById("akUnit").value;
		
		if(document.getElementById("chRacikan").checked == true){
			racikan = cnoRacikan;
			jmlBahan = document.getElementById("txtJmlBahan").value;
		}
		var url;
		
		switch(id){
			case 'btnSimpanKonDok':
				var kondokId = document.getElementById("kondokId").value;
				var txtKetKondok = document.getElementById("txtKetKonDok").value;
				var cmbDokKonDok = document.getElementById("cmbDokKonDok").value;
				var idDokRujukDokter = document.getElementById("cmbDokRujukDokter").value;
				if(document.getElementById("chkDokterPenggantiRujukDokter").checked == true){
					isDokPengganti = 1;
				}
				url = "kondok_utils.php?act="+action+"&smpn="+id+"&pelayanan_id="+getIdPel+"&kondokId="+kondokId+"&txtKetKondok="+txtKetKondok+"&cmbDokKonDok="+cmbDokKonDok+"&idDokRujukDokter="+idDokRujukDokter+"&isDokPengganti="+isDokPengganti;
				kd.loadURL(url,"","GET");
				break;
			case 'btnSimpanHslRad':
				var id = document.getElementById("id_hasil_rad").value;
				var txtHslRad = document.getElementById("txtHslRad").value.replace(/\r\n|\r|\n/g,"<br />");
				var cmbDokHsl = document.getElementById("cmbDokHslRad").value;
				var norm = document.getElementById("normPass").value;
				var pacsId = document.getElementById("pacsuuid").value;
				
				//if(document.getElementById('frameRad').contentWindow.file_upload==''){
				 //alert('belum lengkap');
				//}
				//file_upload
				tambahRadiologi = true;
				document.getElementById('frameRad').contentWindow.aplod(action,id,getIdPel,txtHslRad,cmbDokHsl,userId,norm,pacsId);
				
				/*
				if (action=="Simpan"){
					var cTglTind=rad.cellsGetValue(rad.getSelRow(),2);
					cTglTind=cTglTind.split(" ");
					cTglTind=cTglTind[0].split("-");
					cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];	
				}
				
				
				if(ValidateForm("txtTind_hsl",'ind')){
					var url = "hasilRad_utils.php?grd=true&act="+action+"&smpn="+id+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj
					+"&idTind="+tindakan_id_hsl+"&id="+idTindHsl+"&user_act="+cmbDokHsl+"&ket="+txtKetHsl+"&hasil="+txtHsl+"&normal="+normal;
					//alert(url);
					rad.loadURL(url,"","GET");
					batalHsl();
				}
				*/
			break;
			case 'btnSimpanHslLabPa':
				var idTindHsl = document.getElementById("idTindHslLabPa").value;
				var txtMakros = document.getElementById("txtMakros").value.replace(/\r\n|\r|\n/g,"<br />");
				var txtMikros = document.getElementById("txtMikros").value.replace(/\r\n|\r|\n/g,"<br />");
				var txtKesimpulan = document.getElementById("txtKesimpulan").value.replace(/\r\n|\r|\n/g,"<br />");
				var txtAnjuran = document.getElementById("txtAnjuran").value.replace(/\r\n|\r|\n/g,"<br />");
				var cmbDokLabPa = document.getElementById("cmbDokLabPa").value;
				//var normal = document.getElementById("idNormal").value;
				/*if (action=="Simpan"){
					var cTglTind=lab.cellsGetValue(lab.getSelRow(),2);
					cTglTind=cTglTind.split(" ");
					cTglTind=cTglTind[0].split("-");
					cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];
					
				}*/
				
				if(ValidateForm("txtMakros",'ind')){
					url = "hasilLab_utils.php?grd=LPA&act="+action+"&smpn="+id+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj
					+"&id="+idTindHsl+"&cmbDokLabPa="+cmbDokLabPa+"&txtMakros="+txtMakros+"&txtMikros="+txtMikros+"&txtKesimpulan="+txtKesimpulan+"&txtAnjuran="+txtAnjuran;
					//alert(url);
					lapPa.loadURL(url,"","GET");
					//alert("Tes aja");
					batal('btnSimpanHslLabPa');
				}
			break;
			case 'btnSimpanHsl':
				var idTindHsl = document.getElementById("idTindHsl").value;
				var tindakan_id_hsl = document.getElementById("tindakan_id_hsl").value;
				var txtHsl = document.getElementById("txtHsl").value;
				var txtKetHsl = document.getElementById("txtKetHsl").value;
				var cmbDokHsl = document.getElementById("cmbDokHsl").value;
				var normal = document.getElementById("idNormal").value;
				if (action=="Simpan"){
					var cTglTind=lab.cellsGetValue(lab.getSelRow(),2);
					cTglTind=cTglTind.split(" ");
					cTglTind=cTglTind[0].split("-");
					cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];
					
				}
				
				if(ValidateForm("txtTind_hsl",'ind')){
					url = "hasilLab_utils.php?grd=true&act="+action+"&smpn="+id+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj
					+"&idTind="+tindakan_id_hsl+"&id="+idTindHsl+"&user_act="+cmbDokHsl+"&ket="+txtKetHsl+"&hasil="+txtHsl+"&normal="+normal;
					//alert(url);
					lab.loadURL(url,"","GET");
					batalHsl();
				}
			break;
			case 'btnSimpanTind':
				
				if (action=="Simpan"){
					var cTglTind=f.cellsGetValue(f.getSelRow(),2);
					cTglTind=cTglTind.split(" ");
					cTglTind=cTglTind[0].split("-");
					cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];
					/*if (cTglNow>cTglTind){
						alert("Data Tindakan Yang Dientry Sudah Lebih Dari 24 Jam, Jadi Tidak Boleh DiUbah !");
						batal("btnBatalTind");
						return false;
					}*/
				}
				if(ValidateForm("tindakan_id,txtBiaya,txtQty",'ind')){
					var dok_an = '';
					if(cmbTmpLay == 6 || cmbTmpLay == 7 || cmbTmpLay == 13 || cmbTmpLay == 18 || cmbTmpLay == 47 || cmbTmpLay == 63 || cmbTmpLay == 45 || cmbTmpLay == 72){
						if(document.form_an.chk_an){
							if(document.form_an.chk_an.length){
							   for(var i=0; i<document.form_an.chk_an.length; i++){
								  if(document.form_an.chk_an[i].checked == true){
									 dok_an += document.form_an.hid_id_an[i].value+',';
								  }
							   }
							}
							else{
							   dok_an = document.getElementById('hid_id_an').value;
							}
						}
						dok_an = dok_an.substring(0,dok_an.length-1);
					}
					if(document.getElementById("chkDokterPenggantiTind").checked == true){
						isDokPengganti = 1;
					}
					document.getElementById(id).disabled = true;
					
					/* tambahan */
					var j_dok=0;
					var ar_dok='';
					for (x=0;x<document.getElementById('cmbDokTind').length;x++){
						// alert(document.form_dokter_tindakan.cmbDokTind[x].selected);
						if(document.form_dokter_tindakan.cmbDokTind[x].selected){
							j_dok++;
							ar_dok += document.form_dokter_tindakan.cmbDokTind[x].value+",";	
						}
					}
					
					var b_dok=0;
					if(j_dok>1){
						b_dok=1;	
					}
					// alert(ar_dok+" | "+document.getElementById('cmbDokTind').length);
					/* ========*/
					
					if(idDok == '' || ar_dok == ''){
						alert("Pilih terlebih dahulu dokter pelaksana tindakan!");
						document.getElementById(id).disabled = false;
						return false;
					}
					
					//joker
					var icd9cm='false';
					if (document.getElementById("tdKelas").innerHTML=='') icd9cm='true';
					
					var tglTindak = document.getElementById("tglTindak").value;
					
					if(document.getElementById('chkTind').checked){
						url = "tindiag_utils.php?grd=true&act="+action+"&smpn="+id+"&id="+idBaru+"&inap="+inap+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&kunjungan_kelas_id="+getIdKelasKunj+"&kelas_id="+getKelas_id+"&idTind="+idTind+"&tind="+tind+"&biaya="+biaya+"&biayaAskes="+biayaAskes+"&qty="+qty+"&ket="+ket+"&exprt="+encodeURIComponent(exprt)+"&idDok="+idDok+"&isDokPengganti="+isDokPengganti+"&unitId="+document.getElementById('tmpLay').value+"&unit_pelaksana="+getIdUnit+"&ksoId="+getKsoId+"&ksoKelasId="+getKsoKelasId+"&userId="+userId+"&anastesi="+dok_an+"&icd9cm="+icd9cm+"&tgltindak="+tglTindak+'&b_dok='+b_dok+'&ar_dok='+ar_dok+'&akUnit='+akUnit;
					}
					else {
						url = "tindiag_utils.php?grd=true&act="+action+"&smpn="+id+"&id="+idBaru+"&inap="+inap+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&kunjungan_kelas_id="+getIdKelasKunj+"&kelas_id="+getKelas_id+"&idTind="+idTind+"&tind="+tind+"&biaya="+biaya+"&biayaAskes="+biayaAskes+"&qty="+qty+"&ket="+ket+"&exprt="+encodeURIComponent(exprt)+"&idDok="+idDok+"&isDokPengganti="+isDokPengganti+"&unitId="+unitId+"&ksoId="+getKsoId+"&ksoKelasId="+getKsoKelasId+"&userId="+userId+"&unit_pelaksana="+getIdUnit+"&anastesi="+dok_an+"&icd9cm="+icd9cm+"&tgltindak="+tglTindak+'&b_dok='+b_dok+'&ar_dok='+ar_dok+'&akUnit='+akUnit;
					}
					// alert(url);
					f.loadURL(url,"","GET");
					//batal('btnBatalTind');
				}
				break;

			case 'btnSimpanDiag'://---jokerdiag---
				var fdiagBanding="";
				var iddiagBanding=document.getElementsByName("idtxtDiagBanding");
				var objdiagBanding=document.getElementsByName("txtDiagBanding");
				var objdiagBandingCdgn=document.getElementsByName("txtDiagBandingCdgn");
				//alert(objdiagBanding.length);
				
				var tglDIagBN = jQuery("#TglDiagB").val();
				var jamDiagBN = jQuery("#jamDiagB").val();
				
				if (objdiagBanding.length){
					for (var it=0;it<objdiagBanding.length;it++){
						fdiagBanding +=iddiagBanding[it].value+"|"+objdiagBanding[it].value+"|"+objdiagBandingCdgn[it].value+"*|*";
					}
				}else{
					fdiagBanding=iddiagBanding[0].value+"|"+objdiagBanding[0].value+"|"+objdiagBandingCdgn[0].value+"*|*";
				}
				if(document.getElementById("chkICD_manual").checked){
					//if(ValidateForm("diagnosa_id",'ind')){
						if(document.getElementById("chkDokterPenggantiDiag").checked == true){
							isDokPengganti = 1;
						}
						document.getElementById(id).disabled = true;
						url = "tindiag_utils.php?grd1=true&act="+action+"&smpn="+id+"&id="+idDiag+"&pasienId="+getIdPasien+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&idDiag="+diag_id+"&diagnosa="+encodeURIComponent(diag)+"&idDok="+idDokDiag+"&isDokPengganti="+isDokPengganti+"&userId="+userId+"&isPrimer="+isPrimer+"&isAkhir="+isAkhir+"&isKlinis="+isKlinis+"&fdiagBanding="+fdiagBanding+"&isManual=1&isMati="+isMati+"&TglDiagB="+jQuery("#TglDiagB").val()+"&jamDiagB="+jQuery("#jamDiagB").val();
						//alert(url);
						b.loadURL(url,"","GET");
						document.getElementById("txtDiag").value = '';
						//jQuery("#loadGambar").load("gambar1.php?id_pasien="+getIdPasien);
						//batal('btnBatalDiag');
					//}
				}
				else{
					if(ValidateForm("diagnosa_id",'ind')){
						if(document.getElementById("chkDokterPenggantiDiag").checked == true){
							isDokPengganti = 1;
						}
						document.getElementById(id).disabled = true;
						url = "tindiag_utils.php?grd1=true&act="+action+"&smpn="+id+"&id="+idDiag+"&pasienId="+getIdPasien+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&idDiag="+diag_id+"&diagnosa="+encodeURIComponent(diag)+"&idDok="+idDokDiag+"&isDokPengganti="+isDokPengganti+"&userId="+userId+"&isPrimer="+isPrimer+"&isAkhir="+isAkhir+"&isKlinis="+isKlinis+"&fdiagBanding="+fdiagBanding+"&isManual=0&isMati="+isMati+"&TglDiagB="+jQuery("#TglDiagB").val()+"&jamDiagB="+jQuery("#jamDiagB").val();
						//alert(url);
						b.loadURL(url,"","GET");
						document.getElementById("txtDiag").value = '';
						//jQuery("#loadGambar").load("gambar1.php?id_pasien="+getIdPasien);
						//batal('btnBatalDiag');
					}
				}
				break;

			case 'btnSimpanLab':
				var noLab = document.getElementById('txtLab').value;
				if(ValidateForm("txtLab",'ind')){
					//document.getElementById(id).disabled = true;
					//alert("noLab.php?pelayanan_id="+getIdPel+"&noLab="+noLab);
					Request("noLab.php?pelayanan_id="+getIdPel+"&noLab="+noLab,'divDlm', '', 'GET', tutupLab);
					//document.getElementById('nomorLab').value = action;
				}
				break;
				
			case 'btnSimpanLab2':			
				var noReg = document.getElementById('txtLab2').value;
				if(ValidateForm("txtLab2",'ind')){
					//document.getElementById(id).disabled = true;
					//alert("noReg.php?pelayanan_id="+getIdPel+"&noReg="+noReg,'divDlm2', '', 'GET', tutupLab);
					Request("noReg.php?pelayanan_id="+getIdPel+"&noReg="+noReg,'divDlm2', '', 'GET', tutupLab2);
					//document.getElementById('nomorLab').value = action;
				}
				break;

			case 'btnSimpanResep':	//simpan resep
				<!--joker-->
				//alert("");
				var ttxtAreaNmObat=encodeURIComponent(document.getElementById('txtAreaNmObat').value);
				var bobat = document.getElementById("bobat1").value;
				var jhobat = document.getElementById("txtJmlHari").value;
				var tglResB = '';
				var sdtd = 0;
				var admin = <?php echo $admin; ?>;
				//if(admin == 1){
					tglResB = document.getElementById("tglResepB").value;
				//}
				if(document.getElementById("txtJmlHari").value == '')
				{
					jhobat = 1;
				}
				if(document.getElementById("chRacikan").checked == false)
				{
					bobat = 0;
				}
				if(ValidateForm("txtJml,cmbApotek",'ind')){
					if (document.getElementById("chkObatManual").checked == false){
						if (document.getElementById('idObat').value==""){
							alert("Pilih Obat Terlebih Dahulu !");
							return false;
						}
						ttxtAreaNmObat="";
					}else{
						if (document.getElementById('chRacikan').checked==false){
							alert("Entry Obat Manual Hanya Boleh Untuk Obat Racikan !");
							return false;
						}
						idObat="0";
					}
					if(document.getElementById("chkDokterPenggantiResep").checked == true){
						isDokPengganti = 1;
					}
					if(document.getElementById("chDtd").checked == true){
						sdtd = 1;
					}
					var tdosis=document.getElementById('txtDosis').value;
					//alert(sdtd);
					/*if (document.getElementById("chkDosisManual").checked == true){
						tdosis=document.getElementById('txtDosis1').value;
					}*/
					var iterResep=0;
					if (document.getElementById("chkIter").checked == true){
						//iterResep=1;
						//alert(document.getElementById('txtJmlIter').value);
						if (isNaN(document.getElementById('txtJmlIter').value) || (document.getElementById('txtJmlIter').value=="0") || (document.getElementById('txtJmlIter').value=="")){
							alert("Isikan Jumlah Iter Resep Dengan Benar !");
							return false;
						}
						iterResep=document.getElementById('txtJmlIter').value;
					}

					document.getElementById(id).disabled = true;
					url = "tindiag_utils.php?grdResep=true&act="+action+"&unit_id="+document.getElementById('cmbTmpLay').value+"&smpn="+id+"&id="+idResep+"&idObat="+idObat+"&noResep="+document.getElementById('noResep').value+"&pelayanan_id="+getIdPel+"&idPas="+getIdPasien+"&ksoId="+getKsoId+"&kunjungan_id="+getIdKunj+"&apotek="+apotek+"&nama="+namaobat+"&stok="+stok+"&jumlah="+jumlah+"&txtDosis="+tdosis+"&dokter="+dokter+"&isracikan="+racikan+"&jmlBahan="+jmlBahan+"&satRacikan="+satRacikan+"&tgl_resep="+tgl_resep+"&isDokPengganti="+isDokPengganti+"&resep_baru="+resep_baru+"&iterResep="+iterResep+"&diagResep="+diagResep+"&bobat="+bobat+"&ttxtAreaNmObat="+ttxtAreaNmObat+"&jhobat="+jhobat+"&sdtd="+sdtd+"&tglResepB="+tglResB;
					//alert(url);
					r.loadURL(url,"","GET");
				}
				//document.getElementById('cmbApotek').value = "";
				document.getElementById('txtNmObat').value = "";
				document.getElementById('txtAreaNmObat').value = "";
				document.getElementById('txtJmlHari').value = "";
				document.getElementById('btnSimpanResep').value = "Tambah";
				document.getElementById("chRacikan").checked = false;
				document.getElementById("chDtd").checked = false;
				//document.getElementById('txtDosis').value = "";
				if (document.getElementById('chRacikan').checked==false){
					document.getElementById('txtJml').value = "";
					document.getElementById('txtDosis').value = "";
					//document.getElementById('cmbDokResep').value = "";
					//document.getElementById('chRacikan').checked = false;
				}
				break;

			case 'btnSimpanRujukUnit':			
				var detailRad = 'ada';
				var unit12 = document.getElementById('TmpLayanan').value;
				var sumur1 = <? echo $sumur;?>;
				var thnumur = document.getElementById('txtUmur').value.split(" th,");
				var umursmw = document.getElementById('txtUmur').value;
				if((tmpLayRujukUnit == 61 || jnsLayRujukUnit == 60) || (tmpLayRujukUnit == 59)){
					if(ketRujukUnit==''){
						detailRad = 'kosong';
					}
				}
				// cito = 0;
				var tglRujuk = document.getElementById('txtTglK').value;
				var cmbSPemeriksaan = document.getElementById("chkCTOTujuanUnit").value;
				/* if(document.getElementById('chkCTOTujuanUnit').checked == true)
					cito = 1; */
				if (tmpLayRujukUnit != 58){
					cmbSPemeriksaan = 0;
					// alert(tmpLayRujukUnit);
					document.getElementById('pnlCTOTujuanUnit').style.display = 'none';
				}/* else if (cmbSPemeriksaan == 0){
					alert("Pilih Status Pemeriksaan Terlebih Dahulu !");
					return false;
				}*/
			
				//alert(keyTindLab);
				//alert(document.getElementById("JnsLayanan").value);
				if((document.getElementById("JnsLayanan").value == 68) && (document.getElementById("txtSex").value.toLowerCase() == "l"))
				{
					//alert("pasein tersebut tidak dapat dirawat di ruang bersalin");
					//return false;
				}
				var tmp = document.getElementById('cmbKamarRujuk').options[document.getElementById('cmbKamarRujuk').options.selectedIndex].lang;
				if(document.getElementById("chkDokterPenggantiRujukUnit").checked == true){
					isDokPengganti = 1;
				}
				if(document.getElementById("chkDokterPenggantiTujuanUnit").checked == true){
					isDokTujuanPengganti = 1;
				}
				
				//alert(sumur1);alert(thnumur[0]);alert(unit12);alert(umursmw);
				if(document.getElementById('lgnJudul').innerHTML=='MRS'){
					if(c.getRowId(c.getSelRow())!=''){
						alert("Satu pasien hanya bisa di-MRS-kan satu kali.");
						return false;
					}
					if ((idKamarRujukUnit=="") || (idKamarRujukUnit=="0") || (idKamarRujukUnit==undefined)){
						alert("Pilih Kamar Terlebih Dahulu ! (Kamar Penuh)");
						return false;
					}
					
					else if ((jnsLayRujukUnit=="") || (jnsLayRujukUnit=="0") || (jnsLayRujukUnit==undefined) || (tmpLayRujukUnit=="0") || (tmpLayRujukUnit=="0") || (tmpLayRujukUnit==undefined)){
						alert("Pilih Unit Tujuan MRS Dengan Benar !");
						return false;
					}else if(detailRad == "kosong"){
						alert("Keterangan Rujuk Tidak Boleh Kosong, Harus Di isi!");
						return false;
					}else if((sumur1 <= thnumur[0] || umursmw == "0 th, 0 bl, 0 hr" ) && unit12 == 15)
					{
						alert("Pasien Tersebut Tidak Dapat Mengunjungi Tempat Layanan yang Anda Pilih, lakukan entriyan dengan benar");
						return false;
					}else if(document.getElementById('txtSex').value == "L" && (unit12 == 8 || unit12 == 9))
					{
						alert("Anda Salah Dalam Melakukan Entriyan Pasien Laki - Laki ke Tempat Layanan, Lakukan Entry Kembali dng Benar");
						return false;
					}else{
						document.getElementById(id).disabled = true;
						url = "tindiag_utils.php?grd2=true&isInap=1&act="+action+"&smpn="+id+"&id="+idRujukUnit+"&tarip="+tmp+"&pasienId="+getIdPasien+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&ket="+ketRujukUnit+"&idDok="+idDokRujukUnit+"&ksoId="+getKsoId+"&jnsLay="+jnsLayRujukUnit+"&tmpLay="+tmpLayRujukUnit+"&unitAsal="+getIdUnit+"&kelas="+idKelasRujukUnit+"&kamar="+idKamarRujukUnit+"&tarip="+tmp+"&userId="+userId+"&isDokPengganti="+isDokPengganti+"&idDokTujuan="+idDokTujuanUnit+"&isDokTujuanPengganti="+isDokTujuanPengganti+'&cito='+cmbSPemeriksaan+'&sRujuk='+sRujuk+'&tglRujuk='+tglRujuk;
						//alert(url);
						c.loadURL(url,"","GET");
					}
				}
				else{
					if(document.getElementById('cmbTmpLay').value == tmpLayRujukUnit){
						alert("Anda tidak dapat merujuk pasien ke unit anda sendiri.");
						return false;
					}
					if ((jnsLayRujukUnit=="") || (jnsLayRujukUnit=="0") || (jnsLayRujukUnit==undefined) || (tmpLayRujukUnit=="0") || (tmpLayRujukUnit=="0") || (tmpLayRujukUnit==undefined)){
						alert("Pilih Unit Tujuan Konsul Dengan Benar !");
						return false;
					}if(detailRad == "kosong"){
						alert("Keterangan Rujuk Tidak Boleh Kosong, Harus di Isi!");
						return false;
					}
					
					if((sumur1 <= thnumur[0] || umursmw == "0 th, 0 bl, 0 hr" ) && unit12 == 15)
					{
						alert("Pasien Tersebut Tidak Dapat Mengunjungi Tempat Layanan yang Anda Pilih, lakukan entriyan dengan benar");
						return false;
					}else if(document.getElementById('txtSex').value == "L" && (unit12 == 8 || unit12 == 9))
					{
						alert("Anda Salah Dalam Melakukan Entriyan Pasien Laki - Laki ke Tempat Layanan, Lakukan Entry Kembali dng Benar");
						return false;
					}else{
						document.getElementById(id).disabled = true;
						url = "tindiag_utils.php?grd2=true&isInap=0&act="+action+"&smpn="+id+"&id="+idRujukUnit+"&kunjungan_kelas_id="+getIdKelasKunj+"&kelas_id="+getKelas_id+"&pasienId="+getIdPasien+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&ket="+ketRujukUnit+"&idDok="+idDokRujukUnit+"&jnsLay="+jnsLayRujukUnit+"&tmpLay="+tmpLayRujukUnit+"&unitAsal="+getIdUnit+"&unit_pelaksana="+getIdUnit+"&kelas="+idKelasRujukUnit+"&ksoId="+getKsoId+"&ksoKelasId="+getKsoKelasId+"&userId="+userId+"&isDokPengganti="+isDokPengganti+'&keyTindLab='+keyTindLab+"&idDokTujuan="+idDokTujuanUnit+"&isDokTujuanPengganti="+isDokTujuanPengganti+'&cito='+cmbSPemeriksaan+'&sRujuk='+sRujuk+'&tglRujuk='+tglRujuk;
						//alert(url);
						c.loadURL(url,"","GET");
					}
				}
				var p="idRujukUnit*-**|*txtKetRujuk*-**|*keyTindLab*-*";
				fSetValue(window,p);
				document.getElementById("txtTglK").value = "<? echo $date_now;?>";
				break;
			case 'btnSimpanRujukRS':
			
				//alert(document.getElementById('uCheckout').innerHTML);
				/*if(document.getElementById('uCheckout').innerHTML!="")
				{
					alert("unit "+document.getElementById('uCheckout').innerHTML+" belum checkout, Yang berakibat pada 
					kasir tidak dapat mencetak kwitansi");
					return false;
				}*/
			
				if(d.getRowId(d.getSelRow())!=''){
					alert("Satu pasien hanya bisa di-KRS-kan satu kali.");
					return false;
				}
				if(document.getElementById('trRujukRS').style.visibility!='visible'){
					idRS=0;
				}
				if(ValidateForm("JamKrs",'ind')){
					document.getElementById(id).disabled = true;
					var jamSplit=jamKrs.split(':');
					if(jamSplit.length!=2){
						alert('Format Jam Salah!');
						return false;
					}
					if(isNaN(jamSplit[0]) || isNaN(jamSplit[1]) || jamSplit[0]=='' || jamSplit[1]==''  || jamSplit[0].length!=2 || jamSplit[1].length!=2){
						alert('Format Jam Salah!');
						return false;
					}
					jamMasuk=jamMasuk+':'+time[2];
					getIdKelas=idKelas;
					url = "tindiag_utils.php?grd3=true&act="+action+"&smpn="+id+"&id="+idRujukRS+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&isManual="+document.getElementById('chkManualKrs').checked+"&tglKrs="+tglKrs+"&jamKrs="+jamKrs+"&caraKeluar="+caraKeluar+"&keadaanKeluar="+keadaanKeluar+"&kasus="+kasus+"&emergency="+emergency+"&kondisi="+kondisiPasien+"&ket="+ketRujukRS+"&idDok="+idDokRujukRS+"&idRS="+idRS+"&userId="+userId+"&getIdPasien="+getIdPasien;
					//alert(url);
					d.loadURL(url,"","GET");
					
					jQuery("#spanTar1").text("Berhasil dipulangkan");
					pasPulN();
					fSetValue(window,'btnHapusRujukRS*-*true');
				}
				break;
			case 'btnSimpanKamar':
				/*if(e.getRowId(e.getSelRow())!=''){
					alert("Satu pasien hanya bisa dipindahkamarkan satu kali.");
					return false;
				}*/
		
				var kamar = a1.getRowId(a1.getSelRow()).split("|");
				/*if(idKamar == getKamarId){
					alert("Anda tidak dapat memindahkamarkan pasien ke kamar yang sama.");
					return false;
				}*/
				if(document.getElementById('cmbKamar').value==0){
					alert('Maaf, Tidak Ada Kamar Yang Kosong !');
					return false;
				}
				var tmp = document.getElementById('cmbKamar').options[document.getElementById('cmbKamar').options.selectedIndex].lang;
				//alert(jamMasuk);
				if(ValidateForm("JamMasuk",'ind')){
					document.getElementById(id).disabled = true;
					var jamSplit=jamMasuk.split(':');
					if(jamSplit.length!=2){
						alert('Format Jam Salah!');
						return false;
					}
					if(isNaN(jamSplit[0]) || isNaN(jamSplit[1]) || jamSplit[0]=='' || jamSplit[1]==''  || jamSplit[0].length!=2 || jamSplit[1].length!=2){
						alert('Format Jam Salah!');
						return false;
					}
					jamMasuk=jamMasuk+':'+time[2];
					getIdKelas=idKelas;
					eksyennya = 'pindah kamar';
					url = "tindiag_utils.php?grd4=true&act="+action+"&ksoId="+getKsoId+"&kunjungan_id="+getIdKunj+"&smpn="+id+"&id="+idSetKamar+"&tarip="+tmp+"&pasienId="+getIdPasien+"&pelayanan_id="+getIdPel+"&kamar_id="+idKamar+"&kamar_lama="+getKamarId+"&tglMasuk="+tglMasuk+"&jamMasuk="+jamMasuk+"&isManual="+isManual+"&userId="+userId+"&unitAsal="+getIdUnit+"&tmpLayKamar="+tmpLayKamar+"&jnsLayKamar="+jnsLayKamar+"&kelasId="+idKelas+"&kelas_lama="+kamar[17]+"&unit_id="+getIdUnit;
					//alert(url);
					e.loadURL(url,"","GET");
					fSetValue(window,'btnHapusKamar*-*true');
				}
				break;
			case 'btnPasienPulang':
				if(confirm("Anda akan memulangkan pasien "+document.getElementById('txtNama').value+".\nAnda yakin?")){
					Request("tindiag_utils.php?act=tambah&smpn="+id+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel,'spanTar1','','GET',pasPulN,'ok');
				}
				break;
			case 'btnCekOut':
				if(confirm("Anda akan men-checkout pasien "+document.getElementById('txtNama').value+".\nAnda yakin?")){
					Request("tindiag_utils.php?act=tambah&smpn="+id+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&userId=<?php echo $_SESSION['userId'];?>",'spanTar1','','GET',function(){
						alert(document.getElementById('spanTar1').innerHTML);
						document.getElementById('btnCekOut').disabled=true;	
						var admin = <?php echo $admin; ?>;
						if(admin == 1){
							document.getElementById('btnCCekOut').disabled=false;
							jQuery('#btnCCekOut').removeAttr('disabled');
						}
						//-document.getElementById('btnMutasi').disabled=false;
						//-jQuery('#btnMutasi').removeAttr('disabled');
						jQuery("#loadGambar1").load("update_in_out.php?id_pelayanan="+getIdPel+"&in=false");
						getTglOut = 1;
						document.getElementById("btnRujukRS").disabled = false;///
						jQuery("#btnRujukUnit").hide();
						jQuery("#btnSetKamar").hide();
						jQuery("#btnMRS").hide();
						cekLockRM();
					},'ok');
				}
				break;
			case 'btnCCekOut':
				if(confirm("Anda akan membatalkan checkout pasien "+document.getElementById('txtNama').value+".\nAnda yakin?")){
					Request("tindiag_utils.php?act=tambah&smpn="+id+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&userId=<?php echo $_SESSION['userId'];?>",'spanTar1','','GET',function(){
						alert(document.getElementById('spanTar1').innerHTML);
						document.getElementById('btnCekOut').disabled=false;
						jQuery('#btnCekOut').removeAttr('disabled');
						document.getElementById('btnCCekOut').disabled=true;
						//-document.getElementById('btnMutasi').disabled=false;
						//jQuery('#btnMutasi').removeAttr('disabled');
						//jQuery("#loadGambar1").load("update_in_out.php?id_pelayanan="+getIdPel+"&in=true");
						getTglOut = 0;	
						cekLockRM();
						
						document.getElementById("btnRujukRS").disabled = false;
						jQuery("#btnRujukUnit").show();
						if(jQuery("#cmbJnsLay").val()==27)
						{
							jQuery("#btnSetKamar").show();
						}else{
							jQuery("#btnMRS").show();
						}
					},'ok');
				}
				break;
		}
	}
	
	function pasPulN(){
		
		var admin = <? echo $admin?>;
		alert(document.getElementById("spanTar1").innerHTML);
		if(admin==1)
		{
			document.getElementById('btnBatalPulang').style.display = 'inline-table';
		}else{
			document.getElementById('btnBatalPulang').style.display = 'none';
		}
	    //alert("Pasien "+document.getElementById('txtNama').value+" "+document.getElementById('spanTar1').innerHTML);
	    /*if(document.getElementById('spanTar1').innerHTML == 'Berhasil dipulangkan'){
			document.getElementById('btnBatalPulang').style.display = 'inline-table';
			document.getElementById('btnPasienPulang').style.display = 'none';
	    }
	    else{
			document.getElementById('btnBatalPulang').style.display = 'none';
			//document.getElementById('btnPasienPulang').style.display = 'inline-table';
	    }*/
	}
	
	function pasPul(){
	    alert("Pasien "+document.getElementById('txtNama').value+" "+document.getElementById('spanTar1').innerHTML);
	    if(document.getElementById('spanTar1').innerHTML == 'Berhasil dipulangkan'){
			document.getElementById('btnBatalPulang').style.display = 'inline-table';
			document.getElementById('btnPasienPulang').style.display = 'none';
	    }
	    else{
			document.getElementById('btnBatalPulang').style.display = 'none';
			document.getElementById('btnPasienPulang').style.display = 'inline-table';
	    }
	}
        
	function tutupLab(){
	var tmpNoLab=document.getElementById('txtLab').value;
		setTimeout("document.getElementById('divDlm').innerHTML = ''","2000");
		setTimeout("document.getElementById('txtLab').value = ''","2000");
		if (document.getElementById('divDlm').innerHTML == 'Update Berhasil'){
			document.getElementById('nomorLab').value = tmpNoLab;
			setTimeout("document.getElementById('divSetLab').popup.hide()","1000");
		}
	}

	function tutupLab2(){
	var tmpNoLab=document.getElementById('txtLab2').value;
		setTimeout("document.getElementById('divDlm2').innerHTML = ''","2000");
		setTimeout("document.getElementById('txtLab2').value = ''","2000");
		if (document.getElementById('divDlm2').innerHTML == 'Update Berhasil'){
			document.getElementById('nomorLab2').value = tmpNoLab;
			setTimeout("document.getElementById('divSetLab2').popup.hide()","1000");
		}
	}
	
	function cetakKwitansi(){
		window.open('../loket/cetakLoket.php?idPas='+getIdPasien+'&idKunj='+getIdKunj+'&userId=<?php echo $_SESSION['userId'];?>','Kwitansi');
	}

	function simpanMutasi(){            
		var unitLama = document.getElementById('cmbTmpLay').value;
		var unitBaru=document.getElementById('TmpLayananMutasi').value;
		var no_rm = document.getElementById('txtFilter').value;
		var url="";
		url="pelayanankunjungan_utils.php?grd=true&act=simpan&no_rm="+no_rm+"&unitBaru="+unitBaru+"&unitLama="+unitLama+"&userId=<?php echo $_SESSION['userId']; ?>"+"&id="+getIdPel+"&kunjungan_id="+getIdKunj+"&saring=true&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&inap="+inap+"&dilayani="+document.getElementById('cmbDilayani').value;
		//alert(url);
		a1.loadURL(url,"","GET");
		document.getElementById('divDetil').style.display='none';
		document.getElementById('divKunj').style.display='block';
	}

	function ambilDataTind()
	{
		batal('btnBatalTind');
		var sisip=f.getRowId(f.getSelRow()).split("|");
		if(sisip[17]=='1') return false;
		//alert(sisip[1]);
		
		//alert(getTglOut);
		if(getTglOut != 0)
		{
			var p ="id_tind*-*"+sisip[0]+"*|*tindakan_id*-*"+sisip[1]+"*|*txtTind*-*"+sisip[11]+"*|*txtBiaya*-*"+sisip[13]+"*|*txtQty*-*"+sisip[14]+"*|*txtKet*-*"+sisip[15]+"*|*tglTindak*-*"+sisip[16]+"*|*btnSimpanTind*-*Tambah*|*btnHapusTind*-*true*|*btnSimpanTind*-*true";				
		}else{
			var p ="id_tind*-*"+sisip[0]+"*|*tindakan_id*-*"+sisip[1]+"*|*txtTind*-*"+sisip[11]+"*|*txtBiaya*-*"+sisip[13]+"*|*txtQty*-*"+sisip[14]+"*|*txtKet*-*"+sisip[15]+"*|*tglTindak*-*"+sisip[16]+"*|*btnSimpanTind*-*Simpan*|*btnHapusTind*-*false";
		}
		fSetValue(window,p);
		
		document.getElementById('txtExprt').value=urldecode(sisip[18]);
		document.getElementById('akUnit').value=urldecode(sisip[21]);
		
		if(sisip[17]=='1'){
			document.getElementById('tglTindak').value='<?=date('d-m-Y')?>';
		}
		
		document.getElementById("tdKelas").innerHTML=sisip[12];
		if(unitId!=sisip[2]){
			document.getElementById('chkTind').checked=true;
			document.getElementById('trUnit').style.visibility='visible';
			fSetValue(window,"jnsLay*-*"+sisip[3]+"*|*tmpLay*-*"+sisip[2]);
				
		}else{
			document.getElementById('chkTind').checked=false;
			document.getElementById('trUnit').style.visibility='collapse';
			isiCombo('JnsLayanan','',sisip[3],'jnsLay');
			isiCombo('TmpLayanan',sisip[3],sisip[2],'tmpLay');
			//document.getElementById('cmbDokTind').value=sisip[4];
		}
		
		if(document.getElementById('cmbDokTind').disabled==false){
			if(sisip[7] == 0){
				//isiCombo('cmbDok',sisip[2],sisip[4],'cmbDokTind');
				/* isiCombo('cmbDok',unitId,sisip[4],'cmbDokTind'); */
				isiCombo('cmbDok',unitId,sisip[4],'cmbDokTind',function(){
					if(sisip[19] == 1){
						var dok_ = sisip[20].split(',');
						for(var i=0; i<dok_.length; i++){
							for (x=0;x<document.getElementById('cmbDokTind').length;x++){
								if(document.form_dokter_tindakan.cmbDokTind[x].value==dok_[i]){
									document.form_dokter_tindakan.cmbDokTind[x].selected=true;	
								}
							}
						}
					}
					dokter_tindakan.multiselect('refresh');
					
				});
				document.getElementById('chkDokterPenggantiTind').checked = false;
			}
			else{
				//isiCombo('cmbDokPengganti',sisip[2],sisip[4],'cmbDokTind');
				// isiCombo('cmbDokPengganti',unitId,sisip[4],'cmbDokTind');
				isiCombo('cmbDokPengganti',unitId,sisip[4],'cmbDokTind',function(){					
					if(sisip[19] == 1){
						var dok_ = sisip[20].split(',');
						for(var i=0; i<dok_.length; i++){
							for (x=0;x<document.getElementById('cmbDokTind').length;x++){
								if(document.form_dokter_tindakan.cmbDokTind[x].value==dok_[i]){
									document.form_dokter_tindakan.cmbDokTind[x].selected=true;	
								}
							}
						}
					}
					dokter_tindakan.multiselect('refresh');
					
				});
				document.getElementById('chkDokterPenggantiTind').checked = true;
			}
		}
		
		var unitUserId = document.getElementById('cmbTmpLay').value;
		if(sisip[6]!=unitUserId){
			document.getElementById('chkTind').disabled=true;
			document.getElementById('txtTind').disabled = true;
			document.getElementById('txtBiaya').disabled = true;
			document.getElementById('txtQty').disabled = true;
		}
		else{
			document.getElementById('chkTind').disabled=false;
			jQuery('#chkTind').removeAttr('disabled');
			document.getElementById('txtTind').disabled = false;
			jQuery('#txtTind').removeAttr('disabled');
			document.getElementById('txtBiaya').disabled = false;
			jQuery('#txtBiaya').removeAttr('disabled');
			document.getElementById('txtQty').disabled = false;
			jQuery('#txtQty').removeAttr('disabled');
		}
	  
	  	//for anastesi
	  	if(cmbTmpLay == 6 || cmbTmpLay == 7 || cmbTmpLay == 13 || cmbTmpLay == 18 || cmbTmpLay == 47 || cmbTmpLay == 63){
		 	if(sisip[9] != ''){
				var dok_an = sisip[9].split(',');
				for(var i=0; i<dok_an.length; i++){
					document.getElementById('chk_an_'+dok_an[i]).checked = true;
				}
		 	}
	  	}
		
		
		//radiologi
		/*
		if(document.getElementById('cmbJnsLay').value==60){
			document.getElementById('div_rad').style.display='none';
			document.getElementById('div_gb_rad').style.display='block';
			Request('ambil_gb_radiologi.php?id='+sisip[0],'div_gb_rad','','GET');
		}
		*/
		
		cekKonsen();
	}
        
	function printReport(){
		var sisip=f.getRowId(f.getSelRow()).split("|");
		if(sisip[8] == '13'){
			window.open('visite.php?tindakan_id='+sisip[0]+'&petugas=<?php echo $_SESSION['userId'];?>');
			batal('btnBatalTind');
		}
	}
	
	function cekKonsen()
	{
		//alert("");
		//jQuery("#loadGambar1").load("update_in_out.php?id_pelayanan="+getIdPel+"&konsen=true");
	}
	
	function cekLockRM()
	{
		//alert("");
		var cekU = "<? echo $disableKunj;?>";
		var p;
		if(((getTglOut == 1) || (getBatal == 1)) && (typeof getTglOut != "undefined"))
		{
			p ="btnSimpanDiag*-*Tambah*|*btnHapusDiag*-*true*|*btnSimpanDiag*-*true";
			document.getElementById("btnRujukUnit").disabled = true;	
			document.getElementById("btnSimpan_bhp").value = "Tambah";	
		}else{
			p ="btnSimpanDiag*-*Tambah*|*btnHapusDiag*-*true*|*btnSimpanDiag*-*false";
			document.getElementById("btnRujukUnit").disabled = false;
			jQuery('#btnRujukUnit').removeAttr('disabled');
		}
		fSetValue(window,p);
		//alert(getTglOut+'\n'+getBatal);
		
		if((getTglOut == 1) || (getBatal == 1) && (typeof getTglOut != "undefined"))
		{
			//alert("masuk 12 "+getTglOut);
			p ="btnSimpanTind*-*Tambah*|*btnHapusTind*-*true*|*btnSimpanTind*-*true";
			if(document.getElementById("cmbTmpLay").value == 61)
			{
				document.getElementById("btnTmbh").disabled = false;
			}else{
				document.getElementById("btnTmbh").disabled = false;//mael
			}
			//jQuery('#btnTmbh').Attr('disabled');
			document.getElementById("btnEditResep").disabled = true;
			document.getElementById("btnTmbhAnam").disabled = true;
			document.getElementById("btnSimpan_bhp").disabled = true;
			document.getElementById("btnHapus_bhp").disabled = true;
			jQuery("#btnCCekOut").show();
			//jQuery("#btnRujukUnit").hide();
			//document.getElementById("btnRujukRS").disabled = false;
			//alert("");	
		}else{
			p ="btnSimpanTind*-*Tambah*|*btnHapusTind*-*true*|*btnSimpanTind*-*false";
			document.getElementById("btnTmbh").disabled = false;
			//jQuery('#btnTmbh').removeAttr('disabled');
			document.getElementById("btnTmbhAnam").disabled = false;
			jQuery('#btnTmbhAnam').removeAttr('disabled');
			document.getElementById("btnSimpan_bhp").disabled = false;
			jQuery('#btnSimpan_bhp').removeAttr('disabled');
			document.getElementById("btnHapus_bhp").disabled = false;	
			jQuery('#btnHapus_bhp').removeAttr('disabled');
			jQuery("#btnCCekOut").hide();
			
			//document.getElementById("btnRujukRS").disabled = false;
			
			//jQuery("#btnRujukUnit").show();  //diganti dengan js dibawah berikut
			/*KONSUL OFF PENUNJANG*/
			if (document.getElementById('cmbJnsLay').value==57 || document.getElementById('cmbJnsLay').value==60){
				//jQuery("#btnRujukUnit").hide();
				//document.getElementById("btnRujukUnit").disabled = true;
			}else{
				//jQuery("#btnRujukUnit").show();
				//document.getElementById("btnRujukRS").disabled = true;
				//document.getElementById("btnRujukUnit").disabled = false;
				//jQuery('#btnRujukUnit').removeAttr('disabled');
			}
			/*AKHIR KONSUL OFF PENUNJANG*/
			
			if(b.getMaxPage() > 0){
				document.getElementById("btnTmbh").disabled = false;
				//jQuery('#btnTmbh').removeAttr('disabled');
			}
			else{
				if(document.getElementById("cmbTmpLay").value == 61)
				{
					document.getElementById("btnTmbh").disabled = false;
				}else{
					document.getElementById("btnTmbh").disabled = false;//mael
				}
			}
		}
		fSetValue(window,p);
		//alert(cekU);
		
		if(cekU=="disabled")
		{
			jQuery("#btnCCekOut").hide();
		}else{
			jQuery("#btnCCekOut").show();
		}
			
	}

	function ambilDataDiag()
	{
		batal('btnBatalDiag');
		var sisip=b.getRowId(b.getSelRow()).split("*-||-*");
		if(sisip[12]=='1') return false;
		
		var diagbdg = sisip[16];
		document.getElementById('TotDiagBanding').value = sisip[16];
		if(diagbdg>1){
			for(var i=0;i<diagbdg-1;i++){
				fTambahDiagBanding();
			}
		}
		
		var p;
		//alert(getTglOut);
		if(getTglOut != 0)
		{
			p ="cmbUtama*-*"+sisip[4]+"*|*btnSimpanDiag*-*Tambah*|*btnHapusDiag*-*true*|*btnSimpanDiag*-*true";
			/*jQuery("#btnSimpanDiag").val("Tambah");
			jQuery("#btnHapusDiag").prop('disabled', true);
			jQuery("#btnSimpanDiag").prop('disabled', true);	*/
		}else{
			p ="cmbUtama*-*"+sisip[4]+"*|*btnSimpanDiag*-*Simpan*|*btnHapusDiag*-*false";
		}

		fSetValue(window,p);
		//alert(b.getRowId(b.getSelRow()));
		//+"*|*cmbDokDiag*-*"+sisip[1]
		
		if(sisip[8]==0){
			//document.getElementById('chkPenyebabKecelakaan').checked = 'false';
			jQuery("#chkPenyebabKecelakaan").prop('checked',false);
			document.getElementById('diagnosa_id').value = sisip[2];
			document.getElementById('id_diag').value = sisip[0];
			document.getElementById('txtDiag').value = sisip[13];
			document.getElementById('trPenyebab').style.display='none';
		}
		else{
			//document.getElementById('chkPenyebabKecelakaan').checked = 'true';
			jQuery("#chkPenyebabKecelakaan").prop('checked',true);
			document.getElementById('diagnosa_id').value = sisip[6];
			document.getElementById('id_diag').value = sisip[0];
			document.getElementById('txtDiag').value = sisip[7];
			Request('../combo_utils.php?id=PenyebabKecelakaan&value='+sisip[6]+'&defaultId='+sisip[2],'cmbPenyebab','','GET');
			document.getElementById('trPenyebab').style.display='table-row';
		}
		
		if(sisip[5]==1){
			document.getElementById('chkAkhir').checked='true';
		}
		else{
			document.getElementById('chkAkhir').checked='';
		}
		
		if(sisip[9]==1){
			document.getElementById('chkKlinis').checked='true';
		}
		else{
			document.getElementById('chkKlinis').checked='';
		}
		
		if(sisip[14]==1){
			document.getElementById('chkMati').checked='true';
		}
		else{
			document.getElementById('chkMati').checked='';
		}
		
		if(sisip[10]==1){
			//document.getElementById('chkBanding').checked='true';
		}
		else{
			//document.getElementById('chkBanding').checked='';
		}
		
		if(sisip[11]==1){
			document.getElementById('chkICD_manual').checked='true';
		}
		else{
			document.getElementById('chkICD_manual').checked='';
		}
		
		if(document.getElementById('cmbDokDiag').disabled==false){
			if(sisip[3] == 0){
				isiCombo('cmbDok',unitId,sisip[1],'cmbDokDiag');
				document.getElementById('chkDokterPenggantiDiag').checked = false;
			}
			else{
				isiCombo('cmbDokPengganti',unitId,sisip[1],'cmbDokDiag');
				document.getElementById('chkDokterPenggantiDiag').checked = true;
			}
		}
		
		//document.getElementById('chkDokterPenggantiDiag').checked = sisip[3];
		cekKonsen();
		
		document.forms['form_diag'].idtxtDiagBanding.value="";
		document.forms['form_diag'].txtDiagBanding.value="";
		document.forms['form_diag'].txtDiagBandingCdgn.value="";
		
		if(diagbdg!=0){
			if(diagbdg!=1){
			//alert(diagbdg);
				for (var a=0;a<diagbdg;a++){
					var isiin=sisip[15].split("*|||*");
					var ok=isiin[a].split("*||*");
					//alert(ok[0]);
					document.forms['form_diag'].idtxtDiagBanding[a].value=ok[0];
					document.forms['form_diag'].txtDiagBanding[a].value=ok[13];
					document.forms['form_diag'].txtDiagBandingCdgn[a].value=ok[13];
				}
			}else{
				var isiin=sisip[15].split("*|||*");
				var ok=isiin[0].split("*||*");
				//alert(ok);
				document.forms['form_diag'].elements['idtxtDiagBanding'].value=ok[0];
				document.forms['form_diag'].elements['txtDiagBanding'].value=ok[13];
				document.forms['form_diag'].elements['txtDiagBandingCdgn'].value=ok[13];
			}
		}
	}
	
	function cekInputDiagnosa(){
		Request('tindiag_utils.php?act=cekndiagnosa&pelayanan_id='+getIdPel, 'resGrouper', '', 'GET', function(){
			if(document.getElementById('resGrouper').innerHTML>0){
				fSetKodeGrouper();
			}
			else{
				alert('Diagnosa Pasien belum diisi !');	
			}
		}, 'noload');
	}
	
	function fSetKodeGrouper(){
		var kode_lama = document.getElementById('spnGrouper').innerHTML;
		var kode_group,url;
		kode_lama=kode_lama.replace('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',"");
		kode_lama=kode_lama.replace("[","");
		kode_lama=kode_lama.replace("]","");
		kode_lama=kode_lama.replace(/^\s+|\s+$/gm,'');
		//alert(kode_lama);
		kode_group = prompt('Masukkan Kode Grouper', kode_lama);
		if (kode_group!=null && kode_group!=kode_lama){
			//alert(kode_group);
			url="updtKodeGrouper_utils.php?idKunj="+getIdKunj+"&idPel="+getIdPel+"&kode_grouper="+kode_group;
			//alert(url);
			document.getElementById('inpEvUpdt').innerHTML="";
			Request(url , "inpEvUpdt", "", "GET",evUpdtKodeGrouper,"");
		}
	}
	
	function evUpdtKodeGrouper(){
		var tmpDt=document.getElementById('inpEvUpdt').innerHTML;
		tmpDt=tmpDt.split("|");
		if (document.getElementById('inpEvUpdt').innerHTML=="" || tmpDt[0]!="Proses Update Berhasil !"){
			alert("Update Status Pasien Gagal !");
		}else{
			document.getElementById('spnGrouper').innerHTML="[ "+tmpDt[1]+" ]";
			alert("Proses Update Berhasil !");
		}
	}
	
	function fSetPlatfon(){
		var nPlatfon = document.getElementById('nPlatfon').innerHTML;
		var nilai = prompt('Masukkan Nilai Platfon', nPlatfon);
		if(nilai!=null){
			//alert("updtPlatfon_utils.php?act=update&idKunj="+getIdKunj+"&biaya_kso="+nilai+"&user_act=<?=$userId?>");
			Request("updtPlatfon_utils.php?act=update&idKunj="+getIdKunj+"&biaya_kso="+nilai+"&user_act=<?=$userId?>", "resPlatfon", "", "GET",function(){
				document.getElementById('nPlatfon').innerHTML=document.getElementById('resPlatfon').innerHTML;	
			},"noLoad");
		}
	}
		
	/* SETSJP */
	function cekInputNoSEP(){
		var nSEP = document.getElementById('spnNoSEP').innerHTML;
		nSEP=nSEP.replace('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',"");
		nSEP=nSEP.replace("[","");
		nSEP=nSEP.replace("]","");
		nSEP=nSEP.replace(/^\s+|\s+$/gm,'');
		document.getElementById('txtSetNoSEP').value=nSEP;
		new Popup('divSetNoSEP',null,{modal:true,position:'center',duration:1});
		document.getElementById('divSetNoSEP').popup.show();
	}
	
	function SimpanInputNoSEP(){
		var iNoSEP = document.getElementById('txtSetNoSEP').value;
		var iTglSEP = document.getElementById('txtSetTglSEP').value;
		if (iNoSEP=="" || iTglSEP==""){
			alert("Tgl SEP & No SEP Harus Diisi !");
			return false;
		}
			//alert("updtNoSEP_utils.php?act=update&idKunj="+getIdKunj+"&NoSEP="+iNoSEP+"&user_act=<?=$userId?>");
		Request("updtNoSEP_utils.php?act=update&idKunj="+getIdKunj+"&NoSEP="+iNoSEP+"&TglSEP="+iTglSEP+"&inap="+getInap+"&user_act=<?=$userId?>", "resNoSEP", "", "GET",function(){
			var iResNoSEP=document.getElementById('resNoSEP').innerHTML;
			iResNoSEP=iResNoSEP.split("|");
			alert(iResNoSEP[0]);
			if (iResNoSEP[1]!=""){
				if (getInap=="1"){
					getcTglSJPInap = iTglSEP;
					getcNoSJPInap = iResNoSEP[1];
				}else{
					getNoSJP = iResNoSEP[1];
					getcTglSJP = iTglSEP;
				}
				document.getElementById('spnNoSEP').innerHTML="[ "+iResNoSEP[1]+" ]";
			}
			document.getElementById('divSetNoSEP').popup.hide();
		},"noLoad");
	}
		
	//Resep
	var tgl_resep;

	function ambilDataResep()
	{
		var sisipan=r.getRowId(r.getSelRow()).split("|");
		//alert(sisipan);
		//alert(sisipan[9]);
		if(sisipan[19]=='1') return false;
		
		var p ="idResep*-*"+sisipan[0]+"*|*cmbDiagR*-*"+sisipan[9]+"*|*cmbApotek*-*"+sisipan[5]+"*|*txtNmObat*-*"+sisipan[15]+"*|*txtStok*-*"+sisipan[4]+"*|*txtJml*-*"+sisipan[16]+"*|*txtDosis*-*"+sisipan[17]+"*|*chRacikan*-*"+((sisipan[18]=='1')?'true':'false')+"*|*idObat*-*"+sisipan[2]+"*|*btnSimpanResep*-*Simpan*|*btnHapusResep*-*false";
		fSetValue(window,p);
		var xxx = sisipan[10];
		var xxx2 = sisipan[11];
		var xxx3 = sisipan[17];
		//alert(sisipan[12]);
		if(sisipan[12] != '')
		{
			document.getElementById("chkObatManual").checked = true;
			jQuery("#txtNmObat").hide();
			jQuery("#txtAreaNmObat").show();
			jQuery("#txtAreaNmObat").val(sisipan[12]);
				jQuery("#bobatN").show();
				jQuery('satuanRacikan').hide();
				jQuery('trRacikan').hide();
				jQuery('trJmlBahan').hide();
		}else{
			document.getElementById("chkObatManual").checked = false;
			jQuery("#txtNmObat").show();
			jQuery("#txtAreaNmObat").hide();
			jQuery("#txtAreaNmObat").val(sisipan[12]);
				//jQuery("#bobatN").show();
				jQuery('satuanRacikan').hide();
				jQuery('trRacikan').hide();
				jQuery('trJmlBahan').hide();
		}
		//document.getElementById("bobat1").value = sisipan[13];
		jQuery("#bobat1").val(sisipan[13]);
		jQuery("#txtJmlHari").val(sisipan[14]);
		if(sisipan[20]==1)
		{
			document.getElementById("chDtd").checked = true;
		}else{
			document.getElementById("chDtd").checked = false;
		}
		//alert(xxx);
		//+"*|*cmbDokResep*-*"+sisipan[6]
		
		ahah(xxx,xxx2,xxx3);
		
		/*if((r.cellsGetValue(r.getSelRow(),4).search('Racikan')!=-1) && (sisipan[12] != ''))
		{
			document.getElementById("chRacikan").checked = true;
			jQuery('satuanRacikan').hide();
			jQuery('txtJmlBahan').hide();
			//jQuery('txtJmlBahan').hide();
			//alert("");
		}else if((r.cellsGetValue(r.getSelRow(),4).search('Racikan')!=-1) && (sisipan[12] == '')){
			document.getElementById("chRacikan").checked = true;
		}
		else{
			document.getElementById("chRacikan").checked = false;
		}*/
		
		if(document.getElementById('cmbDokResep').disabled==false){
			if(sisipan[7] == 0){
				isiCombo('cmbDok',unitId,sisipan[6],'cmbDokResep');
				document.getElementById('chkDokterPenggantiResep').checked = false;
			}
			else{
				isiCombo('cmbDokPengganti',unitId,sisipan[6],'cmbDokResep');
				document.getElementById('chkDokterPenggantiResep').checked = true;
			}
		}
	}

	function ahah(oh,no,ah){
		//alert(oh);
		if((oh==1)  && (document.getElementById("chkObatManual").checked == false)){
			document.getElementById('satuanRacikan').style.visibility='visible';
			document.getElementById('trRacikan').style.visibility='visible';
			document.getElementById('trJmlBahan').style.visibility='visible';
			document.getElementById('txtJmlBahan').value=no;
			//document.getElementById('txtDosis').value=ah;
			document.getElementById('chRacikan').checked=true;
			jQuery("#bobatN").show();
			document.getElementById('yeah').checked=true;
			document.getElementById('spnKetDosis').innerHTML='<input id="txtDosis" name="txtDosis" size="30" value"'+ah+'" class="txtinput">';
			document.getElementById('txtDosis').value=ah;
			//document.getElementById('txtDosis').focus();
		}else if((oh==1) && (document.getElementById("chkObatManual").checked == true)){
			//alert("");
			document.getElementById('satuanRacikan').style.visibility='collapse';
			document.getElementById('trRacikan').style.visibility='collapse';
			document.getElementById('trJmlBahan').style.visibility='collapse';
			document.getElementById("chRacikan").checked = true;
			document.getElementById('txtJmlBahan').value=no;
			
			document.getElementById('yeah').checked=true;
			jQuery("#bobatN").show();
			document.getElementById('spnKetDosis').innerHTML='<input id="txtDosis" name="txtDosis" size="30" value"'+ah+'" class="txtinput">';
			document.getElementById('txtDosis').value=ah;
		}else{
			document.getElementById('satuanRacikan').style.visibility='collapse';
			document.getElementById('trRacikan').style.visibility='collapse';
			document.getElementById('trJmlBahan').style.visibility='collapse';
			
			document.getElementById('spnKetDosis').innerHTML='<select id="txtDosis" name="txtDosis" class="txtinput"><?php 
															$sql="SELECT * FROM $dbapotek.a_dosis WHERE aktif=1";
															$rs=mysql_query($sql);
															while ($rw=mysql_fetch_array($rs)){
															?><option value="<?php echo $rw['nama']; ?>"><?php echo $rw['nama']; ?></option><?php 
															}
															?></select>';
		}
	}

	<!-- Script Pop Up Window -->
	var win = null;
	function NewWindow(mypage,myname,w,h,scroll){
		LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
		TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
		settings =
		'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
		win = window.open(mypage,myname,settings)
	}
	<!-- Script Pop Up Window Berakhir -->
	function OpenDosis(){
		var url;
		no_resep=document.getElementById('noResep').value;
	    url="../../apotek/report/kwi_dosis.php?no_penjualan=&idpel="+getIdPel+"&no_resep="+no_resep+"&sunit="+document.getElementById('cmbApotek').value+"&no_pasien="+document.getElementById("txtNo").value+"&tgl="+document.getElementById('tglResep').value;
		NewWindow(url,'name','1000','500','yes');
		//return false;
	}
	
	//resep
	function ambilDataResepDetail(){
		
		var sisip = aResep.getRowId(aResep.getSelRow()).split("|");
		var admin = "<? echo $admin;?>";
		/*var no_resep = aResep.cellsGetValue(aResep.getSelRow(),2);
		var Idapotek = aResep.getRowId(aResep.getSelRow());*/
		//tgl_resep = sisip[1];
		document.getElementById('tglResep').value=sisip[1];
		document.getElementById('noResep').value=sisip[2];
		document.getElementById('cmbApotek').value=sisip[0];
		document.getElementById('detail_resep').style.display = 'block';
		if(sisip[3]==3){
			document.getElementById('btnSave').disabled='';
			jQuery('#btnSave').removeAttr('disabled');
		}
		else{
			document.getElementById('btnSave').disabled=true;
		}
		
		if(sisip[4]==0){
			document.getElementById('btnEditResep').disabled='';
			jQuery('#btnEditResep').removeAttr('disabled');
		}
		else{
			if(admin==1)
			{
				jQuery('#btnEditResep').removeAttr('disabled');
			}else{
				document.getElementById('btnEditResep').disabled=true;
			}
			//document.getElementById('btnEditResep').disabled=true;
		}
		document.getElementById('txtJmlIter').readOnly=true;
		if (sisip[5]>0){
			document.getElementById('chkIter').checked=true;
			document.getElementById('txtJmlIter').value=sisip[5];
			document.getElementById('txtJmlIter').style.display = 'table-row';
		}else{
			document.getElementById('chkIter').checked=false;
			document.getElementById('txtJmlIter').style.display = 'none';
		}
		// btnEditResep
		//alert("tindiag_utils.php?grdRsp2=true&no_resep="+no_resep);
		aDet.loadURL("tindiag_utils.php?grdRsp2=true&pelayanan_id="+getIdPel+"&no_resep="+sisip[2]+"&apotek_id="+sisip[0]+"&tgl_resep="+sisip[1],"","GET");
		
		if(getTglOut != 0)
		{
			if(admin==1)
			{
				jQuery('#btnEditResep').removeAttr('disabled');
			}else{
				document.getElementById('btnEditResep').disabled=true;
			}
			//document.getElementById("btnEditResep").disabled = true;
		}else{
			//document.getElementById("btnEditResep").disabled = false;
		}
	}
	
	function tutupPopResep(){
		batal('btnBatalResep');
		//if (actPopResep=="tambah"){
			aResep.loadURL("tindiag_utils.php?grdRsp1=true&pelayanan_id="+getIdPel,"","GET");
		/*}else{
			ambilDataResepDetail();
		}*/
	}
	//resep
	
	function ambilDataKonDok(){
		var sisipan=kd.getRowId(kd.getSelRow()).split("|");
		
		document.getElementById('kondokId').value=sisipan[0];
		document.getElementById('txtKetKonDok').value=sisipan[1];
		document.getElementById('btnHapusKonDok').disabled=false;
		jQuery('#btnHapusKonDok').removeAttr('disabled');
	}
	
	function ambilDataRujukUnit(){
	var sisipan,p;
		//alert(c.getRowId(c.getSelRow()));
		document.getElementById('cetak').disabled = false;
		jQuery('#cetak').removeAttr('disabled');
		document.getElementById('ctkLabRadPerKonsul').style.visibility='collapse';		
		document.getElementById('cetak_rujuk').style.visibility='collapse';		
		if (c.getMaxPage()>0){
			sisipan=c.getRowId(c.getSelRow()).split("|");
			//alert(idPelKonsul);
			fidRujukUnit = sisipan[0];
			idPelKonsul = sisipan[0];
			gantiLabel();
			showTindLab(sisipan[2]);
			p ="idRujukUnit*-*"+sisipan[0]+"*|*JnsLayanan*-*"+sisipan[1]+"*|*TmpLayanan*-*"+sisipan[2]+"*|*btnHapusRujukUnit*-*false";
			fSetValue(window,p);
			isiCombo('TmpLayanan', sisipan[1], sisipan[2], 'TmpLayanan', '');
			//alert(sisipan[0]);+"*|*cmbDokRujukUnit*-*"+sisipan[3]
			document.getElementById('txtKetRujuk').value = c.cellsGetValue(c.getSelRow(),6);
			
			if(document.getElementById('cmbDokRujukUnit').disabled==false){
				if(sisipan[4] == 0){
					isiCombo('cmbDok',unitId,sisipan[3],'cmbDokRujukUnit');
					document.getElementById('chkDokterPenggantiRujukUnit').checked = false;
				}
				else{
					isiCombo('cmbDokPengganti',unitId,sisipan[3],'cmbDokRujukUnit');
					document.getElementById('chkDokterPenggantiRujukUnit').checked = true;
				}
			}
			
			if(sisipan[9] == 0){
				isiCombo('cmbDok',sisipan[2],sisipan[8],'cmbDokTujuanUnit');
				document.getElementById('chkDokterPenggantiTujuanUnit').checked = false;
			}
			else{
				isiCombo('cmbDokPengganti',sisipan[2],sisipan[8],'cmbDokTujuanUnit');
				document.getElementById('chkDokterPenggantiTujuanUnit').checked = true;
			}
			
			if (sisipan[1]==57){
				document.getElementById('ctkLabRadPerKonsul').value="HASIL LAB";
				document.getElementById('cetak_rujuk').value="RUJUK LAB";
				document.getElementById('ctkLabRadPerKonsul').style.visibility='visible';
				document.getElementById('cetak_rujuk').style.visibility='visible';
			}else if (sisipan[1]==60){
				document.getElementById('ctkLabRadPerKonsul').value="HASIL RAD";
				document.getElementById('cetak_rujuk').value="RUJUK RAD";
				document.getElementById('ctkLabRadPerKonsul').style.visibility='visible';
				document.getElementById('cetak_rujuk').style.visibility='visible';
			}
			
			if(document.getElementById('JnsLayanan').value == 57 || document.getElementById('JnsLayanan').value == 60)
				document.getElementById('pnlCTOTujuanUnit').style.visibility = 'visible';			
			else
				document.getElementById('pnlCTOTujuanUnit').style.visibility = 'visible';
			
			
			// if(sisipan[10] == 1)
				// document.getElementById('chkCTOTujuanUnit').checked = true;
				document.getElementById('chkCTOTujuanUnit').value = sisipan[10];
			// else
				// document.getElementById('chkCTOTujuanUnit').checked = false;
		}
		
		
		
		if(document.getElementById('trKamarRujuk').style.visibility == 'visible'){
			setTimeout('isiKelas2()',1000);
		}
	}

	function ambilDataRujukRS(){
		//alert(c.getRowId(c.getSelRow()));
		//cmbEmergency cmbKondisiPasien     chkDokterPenggantiRujukRS
		var sisipan=d.getRowId(d.getSelRow()).split("|");
	    var waktu = d.cellsGetValue(d.getSelRow(),2).split(' ');
	    waktu[1] = waktu[1].substr(0,5);
	    document.getElementById('chkManualKrs').checked = true;
	    caraKeluar(d.cellsGetValue(d.getSelRow(),3));
        var p ="idRujukRS*-*"+sisipan[0]+"*|*cmbRS*-*"+sisipan[1]+"*|*cmbCaraKeluar*-*"+d.cellsGetValue(d.getSelRow(),3)+"*|*TglKrs*-*"+waktu[0]+"*|*JamKrs*-*"+waktu[1]+"*|*cmbKeadaanKeluar*-*"+sisipan[4]+"*|*cmbKasus*-*"+sisipan[5]+"*|*cmbRS*-*"+sisipan[1]+"*|*btnHapusRujukRS*-*false";
        fSetValue(window,p);
		//+"*|*cmbDokRujukRS*-*"+sisipan[2]
		
		if(document.getElementById('cmbDokRujukRS').disabled==false){
			if(sisipan[3] == 0){
				isiCombo('cmbDok',unitId,sisipan[2],'cmbDokRujukRS');
				document.getElementById('chkDokterPenggantiRujukRS').checked = false;
			}
			else{
				isiCombo('cmbDokPengganti',unitId,sisipan[2],'cmbDokRujukRS');
				document.getElementById('chkDokterPenggantiRujukRS').checked = true;
			}
		}
		
	    document.getElementById('txtKetRujukRS').innerHTML = d.cellsGetValue(d.getSelRow(),10);
	}

	function ambilDataKamar(){
		//alert(e.getRowId(e.getSelRow()));
		var sisipan=e.getRowId(e.getSelRow()).split("|");
		var p ="idSetKamar*-*"+sisipan[0]+"*|*cmbJL*-*"+sisipan[5]+"*|*btnHapusKamar*-*false";
		fSetValue(window,p);
		isiCombo('TmpLayananInapSaja',sisipan[5],sisipan[4],'cmbTL');
		isiCombo('cmbKelasKamar',sisipan[4],sisipan[2],'cmbKelas');
		isiCombo('cmbKamar',sisipan[4]+','+sisipan[2],sisipan[1],'cmbKamar');
	}
	
	function ambilDataHslPa()
	{
		var sisip = lapPa.getRowId(lapPa.getSelRow()).split("|");
		//alert(sisip);
		batal('btnSimpanHslLabPa');
		document.getElementById("idTindHslLabPa").value=sisip[0];
		document.getElementById("txtKesimpulan").value=sisip[3].replace(/<br\s?\/?>/g,"\n");
		document.getElementById("txtMikros").value=sisip[2].replace(/<br\s?\/?>/g,"\n");
		document.getElementById("txtAnjuran").value=sisip[4].replace(/<br\s?\/?>/g,"\n");
		document.getElementById("txtMakros").value=sisip[1].replace(/<br\s?\/?>/g,"\n");
		jQuery("#cmbDokLabPa").val(sisip[5]);
		
		//var disHapus = "true";
		/*if(sisip[8]=='0'){
			disHapus = 'true';
		}*/
		//btnSimpanTind*-*Simpan*|*btnHapusTind*-*false;
		document.getElementById("btnSimpanHslLabPa").value="Simpan";
		//document.getElementById("btnHapusHslLabPa").disabled=false;
		//document.getElementById("btnHapusHsl").style.disabled=false;
		var p= "btnHapusHslLabPa*-*false";
		fSetValue(window,p);
	}
	
	function ambilDataHslRad()
	{
		var sisip = rad.getRowId(rad.getSelRow()).split("|");
		//alert(sisip);
		batalHslRad();
		document.getElementById("id_hasil_rad").value=sisip[0];
		document.getElementById("txtHslRad").value=sisip[1].replace(/<br\s?\/?>/g,"\n");
		document.getElementById("cmbDokHslRad").value=sisip[2];
		//btnSimpanTind*-*Simpan*|*btnHapusTind*-*false;
		var hapusRad = false;
		if(sisip[4]=='0'){
			hapusRad = true;
		}
		document.getElementById("btnSimpanHslRad").value="Simpan";
		//document.getElementById("btnHapusHsl").style.disabled=false;
		var p= "btnHapusHslRad*-*"+hapusRad;
		fSetValue(window,p);
	}
	
	
	function batalHslRad(){
		document.getElementById("id_hasil_rad").value="";
		document.getElementById("txtHslRad").value="";
		document.getElementById("cmbDokHslRad").selectedIndex="";
		document.getElementById("btnSimpanHslRad").value="Tambah";
		jQuery('#normPass').val('');
		jQuery('#pacsuuid').val('');
		var set = '<img src="../icon/cancel.gif" alt="pacsStat" width="12px" />';
		jQuery('#statPacs').html(set);
		var p= "btnHapusHslRad*-*true";
		fSetValue(window,p);
		document.getElementById('frameRad').contentWindow.kensel();
	}

	function spInap(){
		var sisipan=c.getRowId(c.getSelRow()).split("|");
		//alert('spInap.php?idKunj='+getIdKunj+'&dokter_id='+sisipan[3]);
		window.open('spinap.php?idKunj='+getIdKunj+'&dokter_id='+sisipan[3]+'&getIdPel='+getIdPel,'spInap');
		//&idUser=<?php echo $_SESSION['userId']?>'+'
	}
		
	function cetak()
	{
		var sisipan=c.getRowId(c.getSelRow()).split("|");
		window.open('cetakKamar.php?idPas='+getIdPasien+'&idKunj='+getIdKunj+'&idPel='+sisipan[0]+'&dokter_id='+sisipan[3]+'&userId=<?php echo $_SESSION['userId'];?>','cetakKamar');
	}
	
	function cetakAntrian()
	{
		var sisipan=c.getRowId(c.getSelRow()).split("|");
		window.open('../loket/cetakAntrian.php?idPas='+getIdPasien+'&idKunj='+getIdKunj+'&idPel='+sisipan[0]+'&dokter_id='+sisipan[3]+'&userId=<?php echo $_SESSION['userId'];?>','cetakAntrian');
	}
	
	
	//window.open('cetakAntrian.php?idPas='+cIdPas+'&loketId='+document.getElementById('asal').value+'&idKunj='+cIdKunj+'&userId=<?php echo $userId;?>','_blank');
	
		
	function hapus(id)
	{
		var rowidTind = document.getElementById("id_tind").value;
		var rowidDiag = document.getElementById("id_diag").value;
		var rowidRujukUnit = document.getElementById("idRujukUnit").value;
		var rowidRujukRS = document.getElementById("idRujukRS").value;
		var rowidKamar = document.getElementById("idSetKamar").value;
		var rowidResep = document.getElementById("idResep").value;
		var tmpLayRujukUnit = document.getElementById("TmpLayanan").value;
		var userId='<?php echo $_SESSION['userId']?>';
		var unitUserId=document.getElementById('cmbTmpLay').value;
		var cTglNow="<?php echo $pTglSkrg; ?>";

		//resep
		var url;

		switch(id)
		{
			case 'btnHapusKonDok':
				var sisip=kd.getRowId(kd.getSelRow()).split("|");
				var kondokId=document.getElementById('kondokId').value;
				
				kd.loadURL("kondok_utils.php?act=hapus&hps="+id+"&kondokId="+sisip[0]+"&pelayanan_id="+getIdPel,'',"GET");
				batal('btnSimpanKonDok');
				break;
			case 'btnHapusHslRad':
				var sisip=rad.getRowId(rad.getSelRow()).split("|");
				//var rowHsl = document.getElementById("idTindHsl").value;
				var cTglTind=sisip[3];
				//cTglTind=cTglTind.split(" ");
				//cTglTind=cTglTind[0].split("-");
				//cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];
				//alert(cTglTind);
					if (cTglNow>cTglTind && getTglOut==1){
						alert("Data Yang Dientry Sudah Lebih Dari 24 Jam, Jadi Tidak Boleh Dihapus !");
					}else{
						if(confirm("Anda Yakin Ingin Menghapus Hasil Radiologi ini ?")){
							document.getElementById(id).disabled = true;
							//alert("hasilLab_utils.php?grd=true&act=hapus&hps="+id+"&id="+sisip[0]+"&pelayanan_id="+getIdPel);
							rad.loadURL("hasilRad_utils.php?grd=true&act=hapus&hps="+id+"&rowid="+sisip[0]+"&pelayanan_id="+getIdPel,'',"GET");
							//alert("tindiag_utils.php?grd=true&act=hapus&hps="+id+"&pelayanan_id="+getIdPel+"&rowid="+rowidTind+"&unit_id="+unitUserId);
							//batal('btnBatalTind');
							//batalHslRad();
						}
					}
					
			break;
			case 'btnHapusHsl':
				var sisip=lab.getRowId(lab.getSelRow()).split("|");
				var rowHsl = document.getElementById("idTindHsl").value;
				var cTglTind=lab.cellsGetValue(lab.getSelRow(),2);
				cTglTind=cTglTind.split(" ");
				//cTglTind=cTglTind[0].split("-");
				//cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];
				//alert(cTglTind);
					if (cTglNow>cTglTind[0]){
						alert("Data Tindakan Yang Dientry Sudah Lebih Dari 24 Jam, Jadi Tidak Boleh Dihapus !");
					}else{
						if(confirm("Anda Yakin Ingin Menghapus Hasil laboratorium "+lab.cellsGetValue(lab.getSelRow(),3))){
							document.getElementById(id).disabled = true;
							//alert("hasilLab_utils.php?grd=true&act=hapus&hps="+id+"&id="+sisip[0]+"&pelayanan_id="+getIdPel);
							lab.loadURL("hasilLab_utils.php?grd=true&act=hapus&hps="+id+"&rowid="+sisip[0]+"&pelayanan_id="+getIdPel,'',"GET");
							//alert("tindiag_utils.php?grd=true&act=hapus&hps="+id+"&pelayanan_id="+getIdPel+"&rowid="+rowidTind+"&unit_id="+unitUserId);
							//batal('btnBatalTind');
							batalHsl();
						}
					}
					
			break;
			case 'btnHapusHslLabPa':
				var sisip=lapPa.getRowId(lapPa.getSelRow()).split("|");
				var rowHsl = document.getElementById("idTindHslLabPa").value;
				var cTglTind=lapPa.cellsGetValue(lapPa.getSelRow(),2);
				cTglTind=cTglTind.split(" ");
				//cTglTind=cTglTind[0].split("-");
				//cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];
				//alert(cTglTind);
					if (cTglNow>cTglTind[0]){
						alert("Data Tindakan Yang Dientry Sudah Lebih Dari 24 Jam, Jadi Tidak Boleh Dihapus !");
					}else{
						if(confirm("Anda Yakin Ingin Menghapus Hasil laboratorium "+lapPa.cellsGetValue(lapPa.getSelRow(),3))){
							document.getElementById(id).disabled = true;
							//alert("hasilLab_utils.php?grd=true&act=hapus&hps="+id+"&id="+sisip[0]+"&pelayanan_id="+getIdPel);
							lapPa.loadURL("hasilLab_utils.php?grd=LPA&act=hapus&hps="+id+"&rowid="+sisip[0]+"&pelayanan_id="+getIdPel,'',"GET");
							//alert("tindiag_utils.php?grd=true&act=hapus&hps="+id+"&pelayanan_id="+getIdPel+"&rowid="+rowidTind+"&unit_id="+unitUserId);
							//batal('btnBatalTind');
							batal('btnSimpanHslLabPa');
						}
					}
					
			break;
			case 'btnHapusTind':
				var sisip=f.getRowId(f.getSelRow()).split("|");
				var cTglTind=f.cellsGetValue(f.getSelRow(),2);
				cTglTind=cTglTind.split(" ");
				cTglTind=cTglTind[0].split("-");
				cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];
				//alert(sisip[6]+' '+unitUserId);
				if(sisip[6]!=unitUserId){
					alert('Tindakan Retribusi Tidak Bisa Dihapus!');
				}
				else{
					if (cTglNow>cTglTind){
						alert("Data Tindakan Yang Dientry Sudah Lebih Dari 24 Jam, Jadi Tidak Boleh Dihapus !");
					}else{
						if(confirm("Anda Yakin Ingin Menghapus Tindakan "+sisip[11])){
							document.getElementById(id).disabled = true;
							//joker
							f.loadURL("tindiag_utils.php?grd=true&act=hapus&hps="+id+"&pelayanan_id="+getIdPel+"&rowid="+rowidTind+"&unit_id="+unitUserId+"&userId="+userId+"&ms_tindakan_id_icd9cm="+sisip[10],'',"GET");
							//alert("tindiag_utils.php?grd=true&act=hapus&hps="+id+"&pelayanan_id="+getIdPel+"&rowid="+rowidTind+"&unit_id="+unitUserId+"&userId="+userId+"&ms_tindakan_id_icd9cm="+sisip[10]);
							//batal('btnBatalTind');
						}
					}
				}
				batal('btnBatalTind');
				break;

			case 'btnHapusDiag':
				var sisipan=b.getRowId(b.getSelRow()).split("|");
				if(confirm("Anda yakin menghapus Diagnosa "+sisipan[13])){
					document.getElementById(id).disabled = true;
					//alert("tindiag_utils.php?grd1=true&act=hapus&hps="+id+"&rowid="+rowidDiag);
					b.loadURL("tindiag_utils.php?grd1=true&act=hapus&hps="+id+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&rowid="+rowidDiag,"","GET");
				}
				document.getElementById("txtDiag").value = '';
				break;

			case 'btnHapusResep':	//resep
				if(confirm("Anda yakin menghapus Obat Ini ?"))
				{
					var sisip=r.getRowId(r.getSelRow()).split("|");
					var apotek = document.getElementById("cmbApotek").value;

					document.getElementById(id).disabled = true;
					url="tindiag_utils.php?grdResep=true&pelayanan_id="+getIdPel+"&act=hapus&hps="+id+"&rowid="+rowidResep+"&noResep="+document.getElementById('noResep').value+"&apotek="+apotek+"&tgl_resep="+sisip[8];
					//alert(url);
					r.loadURL(url,"","GET");
				}
				break;

			case 'btnHapusRujukUnit':
				var isInap = 0;
				if(confirm("Anda yakin menghapus rujukan ke unit "+c.cellsGetValue(c.getSelRow(),3))){
					document.getElementById(id).disabled = true;
					if(document.getElementById('lgnJudul').innerHTML=='MRS'){
						isInap = 1;
					}
					//alert("tindiag_utils.php?grd2=true&act=hapus&hps="+id+"&isInap="+isInap+"&kunjungan_id="+getIdKunj+"&pasienId="+getIdPasien+"&tmpLay="+tmpLayRujukUnit+"&pelayanan_id="+getIdPel+"&unitAsal="+getIdUnit+"&rowid="+rowidRujukUnit);
					c.loadURL("tindiag_utils.php?grd2=true&act=hapus&hps="+id+"&isInap="+isInap+"&kunjungan_id="+getIdKunj+"&pasienId="+getIdPasien+"&tmpLay="+tmpLayRujukUnit+"&pelayanan_id="+getIdPel+"&unitAsal="+getIdUnit+"&rowid="+rowidRujukUnit+"&sRujuk="+sRujuk,"","GET");
					batal('btnSimpanRujukUnit');
				}
				break;
				
			case 'btnHapusRujukRS':
				if(confirm("Anda yakin menghapus KRS ini?")){
					document.getElementById(id).disabled = true;
					//alert("tindiag_utils.php?grd3=true&act=hapus&hps="+id+"&kunjungan_id="+getIdKunj+"&rowid="+rowidRujukRS+"&userId="+userId);
					d.loadURL("tindiag_utils.php?grd3=true&act=hapus&hps="+id+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&rowid="+rowidRujukRS+"&userId="+userId+"&getIdPasien="+getIdPasien,"","GET");
				}
				break;
			case 'btnHapusKamar':
				if(confirm("Anda yakin menghapus data pindah kamar ke "+e.cellsGetValue(e.getSelRow(),4)+" pada "+e.cellsGetValue(e.getSelRow(),2)) ){
					document.getElementById(id).disabled = true;
					//alert("tindiag_utils.php?grd4=true&act=hapus&hps="+id+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&rowid="+rowidKamar+"&unit_id="+getIdUnit);
					e.loadURL("tindiag_utils.php?grd4=true&act=hapus&hps="+id+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&rowid="+rowidKamar+"&unit_id="+getIdUnit,"","GET");
					fSetValue(window,'btnHapusKamar*-*true');
				}
				break;
			case 'btnBatalPulang':
				if(confirm("Pasien "+document.getElementById('txtNama').value+" batal dipulangkan.\nAnda yakin?")){
					Request("tindiag_utils.php?act=hapus&hps="+id+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel,'spanTar1','','GET',pasPulN,'ok');
				}
				break;
		}
	}

	function batal(id){	
	//alert(id);	
	
		if((getTglOut == 1) || (getBatal == 1))
		{
			return false;
		}
		
		if (id != undefined && id != ""){
			if (document.getElementById(id)) {
				document.getElementById(id).disabled = false;
				jQuery('#'+id).removeAttr('disabled');
			}
		}
		switch(id){
			case 'btnBatalKonDok':
				document.getElementById('btnHapusKonDok').disabled=true;
				document.getElementById('kondokId').value='';
				document.getElementById('txtKetKonDok').value='';
				break;
			case 'btnSimpanKonDok':
				document.getElementById('btnHapusKonDok').disabled=true;
				document.getElementById('kondokId').value='';
				document.getElementById('txtKetKonDok').value='';
				break;
			case 'btnSimpanHslRad':
				batalHslRad();
				break;
			case 'btnHapusHslRad':
				batalHslRad();
				break;
			case 'btnSimpanHslLabPa':
				batalHslLabPa();
				break;
			case 'btnSimpanTind':
				batal('btnBatalTind');
				break;
			case 'btnHapusTind':
				break;
			case 'btnBatalTind':
				if(cmbTmpLay == 6 || cmbTmpLay == 7 || cmbTmpLay == 13 || cmbTmpLay == 18 || cmbTmpLay == 47 || cmbTmpLay == 63){
					if(document.form_an.chk_an){
					   if(document.form_an.chk_an.length){
						  for(var i=0; i<document.form_an.chk_an.length; i++){
							 document.form_an.chk_an[i].checked = false;
						  }
					   }
					   else{
						  document.form_an.chk_an.checked = false;
					   }
					}
				}
				
				for (x=0;x<document.getElementById('cmbDokTind').length;x++){
					document.form_dokter_tindakan.cmbDokTind[x].selected = '';
				}
				dokter_tindakan.multiselect('refresh');
				
				var p="id_tind*-**|*txtTind*-**|*txtBiaya*-**|*txtKet*-**|*txtQty*-**|*chkTind*-*false*|*btnSimpanTind*-*Tambah*|*btnSimpanTind*-*false*|*btnHapusTind*-*true";
				fSetValue(window,p);
				
				document.getElementById('txtExprt').value=''
				document.getElementById('akUnit').value='';
				
				document.getElementById('chkTind').disabled=false;
				document.getElementById('txtTind').disabled = false;
				document.getElementById('txtBiaya').disabled = false;
				document.getElementById('txtQty').disabled = false;
				document.getElementById("tdKelas").innerHTML="";
				document.getElementById('trUnit').style.visibility='collapse';
				document.getElementById('txtTind').focus();
				unitId=document.getElementById('cmbTmpLay').value;
				document.getElementById('tglTindak').value='<?php echo date('d-m-Y');?>';
				
				// radiologi
				if(document.getElementById('cmbJnsLay').value==60 && tambahRadiologi==false){
					document.getElementById('frameRad').contentWindow.kensel();
				}
				tambahRadiologi = false;
				
				/*
				if(document.getElementById('cmbJnsLay').value==60){
					document.getElementById('div_rad').style.display='block';
					document.getElementById('div_gb_rad').style.display='none';
				}
				*/
				// akir radiologi
				break;
			case 'btnSimpanDiag':
			case 'btnHapusDiag':
			case 'btnBatalDiag'://----jokerdiag--
				var p="diagnosa_id*-**|*txtDiag*-**|*btnSimpanDiag*-*Tambah*|*btnSimpanDiag*-*false*|*btnHapusDiag*-*true";
				fSetValue(window,p);
				//document.getElementById('chkPenyebabKecelakaan').checked='false';
				jQuery("#chkPenyebabKecelakaan").prop('checked',false);
				document.getElementById('trPenyebab').style.display='none';
				document.getElementById('chkAkhir').checked='';
				document.getElementById('chkKlinis').checked='';
				document.getElementById('chkMati').checked='';
				//document.getElementById('chkBanding').checked='';
				document.getElementById('chkICD_manual').checked='';
				
				var tbl=document.getElementById('tbl_tab_diag');
				var objDiagBanding=document.getElementsByName('txtDiagBanding');
				if (objDiagBanding.length>1){
					for (var j=objDiagBanding.length;j>1;j--){
						tbl.deleteRow(4+j);
					}
				}
				/*for (var j=0;j<objDiagBanding.length;j++){
					objDiagBanding[j].value="";
				}*/
				objDiagBanding[0].value="";
				
				break;
				//resep
			case 'btnSimpanResep':
				batal('btnBatalResep');
				break;
			case 'btnHapusResep':
				break;
			case 'btnBatalResep':
				var p = "idResep*-**|*txtNmObat*-**|*btnSimpanResep*-*Tambah*|*btnSimpanResep*-*false*|*btnHapusResep*-*true";
				fSetValue(window,p);
				document.getElementById('chRacikan').checked=false;
				//document.getElementById('btnTmbh').disabled=false;
				document.getElementById('chDtd').checked=false;
				if (document.getElementById('chRacikan').checked==false){
					document.getElementById('txtJml').value = "";
				}
				//document.getElementById('tglResepB').value = '<?php $tglSekarangg; ?>';
				document.getElementById('txtDosis').value = "";
				document.getElementById('txtJmlHari').value = "";
				document.getElementById('txtNmObat').focus();
				document.getElementById('chRacikan').checked==false;
				document.getElementById('chDtd').checked==false;
				//aResep.loadURL("tindiag_utils.php?grdRsp1=true&pelayanan_id="+getIdPel,"","GET");
				break;
			case 'btnSimpanRujukUnit':
				fidRujukUnit = 0;
				var p = "idRujukUnit*-**|*btnSimpanRujukUnit*-*Tambah*|*btnSimpanRujukUnit*-*false*|*btnHapusRujukUnit*-*true*|*keyTindLab*-*";
				fSetValue(window,p);
				document.getElementById('txtKetRujuk').value = '';
				gantiLabel();
				break;
			case 'btnBatalRujukUnit':
				fidRujukUnit = 0;
				var p = "idRujukUnit*-**|*btnSimpanRujukUnit*-*Tambah*|*btnSimpanRujukUnit*-*false*|*btnHapusRujukUnit*-*true*|*keyTindLab*-*";
				fSetValue(window,p);
				document.getElementById('txtKetRujuk').value = '';
				document.getElementById("txtTglK").value = "<? echo $date_now;?>"
				gantiLabel();
				break;
			case 'btnBatalRujukRS':
				var p = "idRujukUnit*-**|*btnSimpanRujukRS*-*Tambah*|*chkManualKrs*-*false*|*btnSimpanRujukRS*-*false*|*btnHapusRujukRS*-*true";
				fSetValue(window,p);
				document.getElementById('txtKetRujuk').value = '';
				isiCombo('cmbCaraKeluar','','','cmbCaraKeluar',gantiCaraKeluar);
				document.getElementById('cmbKasus').value = '1';
				document.getElementById('TglKrs').value = '<?php echo date('d-m-Y')?>';
				document.getElementById('JamKrs').value = '<?php echo date('H:i')?>';
				//alert();
				break;
			case 'btnBatalKamar':
				var p = "idRujukUnit*-**|*btnSimpanKamar*-*Tambah*|*btnSimpanKamar*-*false*|*btnHapusKamar*-*true";
				fSetValue(window,p);
				document.getElementById('txtKetRujuk').value = '';
				break;
			case 'btnBatalMutasi':
				var p = "idRujukUnit*-**|*btnSimpanMutasi*-*false";
				fSetValue(window,p);
				document.getElementById('txtKetRujuk').value = '';
				break;
		}
	}

	function setDok(ke,ev){
		fSetValue(window,"cmbDokDiag*-*"+ke+"*|*cmbDokTind*-*"+ke+"*|*cmbDokRujukRS*-*"+ke+"*|*cmbDokRujukUnit*-*"+ke+"*|*cmbDokResep*-*"+ke);
		if(ev && ev.which==13) document.getElementById(ke).focus();
	}
	
	function setSemDokter(id1)
	{
		jQuery("#cmbDokDiag").val(id1);
		// jQuery("#cmbDokTind").val(id1);
		jQuery("#cmbDokRujukRS").val(id1);
		jQuery("#cmbDokRujukUnit").val(id1);
		jQuery("#cmbDokResep").val(id1);
		jQuery("#cmbDokHsl").val(id1);
		jQuery("#cmbDokHslRad").val(id1);
		//alert(id1+"\n"+jQuery("#cmbDokTind").val(id1));
	}
	
	function cekDokter(){
	var tindId=document.getElementById('mtId').value;
		//alert(tindId);
		if (tindId=="750"){
			document.getElementById('cmbDokTind').value="584";
		}else if (tindId=="742" || tindId=="746" || tindId=="747" || tindId=="748"){
			document.getElementById('cmbDokTind').value="612";
		}else if (tindId=="743" || tindId=="744"){
			document.getElementById('cmbDokTind').value="581";
		}
	}
	    
	function cekVerifikasi(){
		if(getVerifikasi=='1'){
			document.getElementById("btnVerifikasi").innerHTML="VERIFIKASI (sudah)";
			document.getElementById("btnVerifikasi").style.backgroundColor="#00ff00";
		}else{
			document.getElementById("btnVerifikasi").innerHTML="VERIFIKASI (belum)";
			document.getElementById("btnVerifikasi").style.backgroundColor="#ff0000";
		}
	}
	    
	function verifikasi(vid){
		Request("verifikasi_utils.php?act=verifikasi&pelayanan_id="+getIdPel+"&verifikator="+vid,'btnVerifikasi','','GET');
		if(document.getElementById("btnVerifikasi").innerHTML='VERIFIKASI (sudah)'){
			document.getElementById("btnVerifikasi").style.backgroundColor="#00ff00";
		}else{
			document.getElementById("btnVerifikasi").style.backgroundColor="#ff0000";
		}
	}

	function goFilterAndSort(grd){
		//alert(grd);
		if (grd=="gridbox"){
			var no_rm = document.getElementById('txtFilter').value;
			//alert("pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+no_rm+"&saringan="+txtTgl+"&tmpLay="+cmbTmpLay+"&inap="+inap+"&dilayani="+cmbDilayani+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage());
			a1.loadURL("pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+no_rm+"&saringan="+txtTgl+"&tmpLay="+cmbTmpLay+"&inap="+inap+"&dilayani="+cmbDilayani+"&jnsLay="+document.getElementById('cmbJnsLay').value+"&dokterUnit="+document.getElementById('cmbDokterUnit').value+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage(),"","GET");
		}
		else if (grd=="gridboxTind"){
			f.loadURL("tindiag_utils.php?grd=true&pelayanan_id="+getIdPel+"&filter="+f.getFilter()+"&no_rm="+no_rm+"&sorting="+f.getSorting()+"&page="+f.getPage(),"","GET");
		}
		else if (grd=="gridbox1"){
			b.loadURL("tindiag_utils.php?grd1=true&pelayanan_id="+getIdPel+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
		}
		else if (grd=="gridboxRujukUnit"){
			//alert("tindiag_utils.php?grd2=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit+"&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage());
			c.loadURL("tindiag_utils.php?grd2=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit+"&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage(),"","GET");
		}
		else if (grd=="gridboxRujukRS"){
			//alert("tindiag_utils.php?grd3=true&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&filter="+d.getFilter()+"&sorting="+d.getSorting()+"&page="+d.getPage());
			d.loadURL("tindiag_utils.php?grd3=true&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&filter="+d.getFilter()+"&sorting="+d.getSorting()+"&page="+d.getPage(),"","GET");
		}
		else if (grd=="gridboxKamar"){
			e.loadURL("tindiag_utils.php?grd4=true&kunjungan_id="+getIdKunj+"&unit_id="+getIdUnit+"&filter="+e.getFilter()+"&sorting="+e.getSorting()+"&page="+e.getPage(),"","GET");
		}
		else if(grd=="gridboxResep"){	//resep
			//alert("tindiag_utils.php?grdResep=true&kunjungan_id="+getIdKunj+"&filter="+r.getFilter()+"&sorting="+r.getSorting()+"&page="+r.getPage());
			r.loadURL("tindiag_utils.php?grdResep=true&pelayanan_id="+getIdPel+"&filter="+r.getFilter()+"&sorting="+r.getSorting()+"&page="+r.getPage(),"","GET");
		}
		else if (grd=="gridboxAnamnesa"){
			anam.loadURL("tindiag_utils.php?grdAnamnesa=true&pasien_id="+getIdPasien+"&filter="+anam.getFilter()+"&sorting="+anam.getSorting()+"&page="+anam.getPage(),"","GET");
		}
		else if (grd=="gridbox1_1"){
			anam1.loadURL("tindiag_utils.php?grdAnamnesa=true&pasien_id="+getIdPasien+"&filter="+anam1.getFilter()+"&sorting="+anam1.getSorting()+"&page="+anam1.getPage(),"","GET");
		}
		else if(grd=="gridboxListKonDok"){
			lkd.loadURL("listkondok_utils.php?dokter_id=<?php echo $userId; ?>&dilayani="+document.getElementById('cmbStatusKonDok').value+"&filter="+lkd.getFilter()+"&sorting="+lkd.getSorting()+"&page="+lkd.getPage(),"","GET");
		}
	}

	var tambahRadiologi=false;
	var glob_pelayanan_id_inserted='';
	function konfirmasi(key,val){
		var tangkap,proses,tombolSimpan,tombolHapus,msg,id_tindakan_radiologi,pelayanan_id_inserted,unit_id_inserted;
		//alert(val+'-'+key);
		if (val!=undefined){
			tangkap=val.split("*|*");
			proses=tangkap[0];
			tombolSimpan=tangkap[1];
			tombolHapus=tangkap[2];
			msg=tangkap[3];
			id_tindakan_radiologi=tangkap[4];
			tgl_resep = tangkap[5];
			pelayanan_id_inserted = tangkap[6];
			glob_pelayanan_id_inserted = pelayanan_id_inserted;
			unit_id_inserted = tangkap[7];
		}
		//alert(proses+'-'+key);
		if(key=='Error'){
			if(proses=='tambah'){
				if(tombolSimpan=='btnSimpanTind'){
					if (msg==""){
						alert('Retribusi belum diverifikasi oleh Dokter!');
					}else{
						alert(msg);
					}
				}
				else if(tombolSimpan=='btnSimpanKamar'){
					alert('Pindah kamar gagal!');
				}
				else if(tombolSimpan=='btnSimpanRujukUnit'){
					if(document.getElementById('lgnJudul').innerHTML=='MRS'){
						alert('Pasien Sudah Berkunjung Ke Unit Pelayanan Tersebut dan Belum Pulang !');
					}else{
						alert('Pasien Hari Ini Sudah Berkunjung Ke Unit Pelayanan Tersebut !');
					}
				}
				else if(tombolSimpan=='btnSimpanDiag'){
					alert(msg);
				}
				else{
					alert("Gagal Memasukan Data ke Database.");
				}
			}
			else if(proses=='simpan'){
				alert('Simpan Gagal');
			}
			else if(proses=='hapus'){
				if(tombolHapus=='btnHapusRujukUnit'){
					alert('Hapus Gagal karena pasien sudah dilayani!');
				}
				else if(tombolHapus=='btnHapusTind'){
					alert(msg);
				}
				else{
				   alert('Hapus gagal.');
				}
			}
		}
		else{
			//document.getElementById('btnMutasi').disabled= true;
			if(proses=='tambah'){
				alert('Simpan Berhasil');
				if(tombolSimpan=='btnSimpanTind'){
					document.getElementById('txtTind').focus();
				}
				else if(tombolSimpan=='btnSimpanDiag'){
					document.getElementById('txtDiag').focus();
				}
				else if(tombolSimpan=='btnSimpanResep'){	//resep
					document.getElementById('txtNmObat').focus();
					resep_baru=0;
					document.getElementById('noResep').value=msg;
					document.getElementById('cmbApotek').disabled=true;
					document.getElementById('tglResepB').disabled=true;
					document.getElementById('btnTgl').disabled=true;
					document.getElementById("chkIter").disabled=true;
					document.getElementById('txtJmlIter').readOnly=true;
					//document.getElementById('trNoResep').style.display='table-row';
				}
				else if(tombolSimpan == 'btnSimpanKamar'){
					document.getElementById('spanKam').innerHTML = " &nbsp;&nbsp;Kamar : "+document.getElementById('cmbKamar').options[document.getElementById('cmbKamar').options.selectedIndex].innerHTML;
				}
				else if(tombolSimpan == 'btnSimpanRujukUnit'){
					ambilDataRujukUnit();
					if(unit_id_inserted=='130'){
						actMintaDarah('tambah');	
					}
				} else if(tombolSimpan == 'btnSimpanHslRad'){
					batalHslRad();
					
					var url = "pacs_utils.php?no_rm="+PatientId;
					pacs_S.loadURL(url,'','GET');
				} else if(tombolSimpan == 'btnSimpanHslLab'){
					f.loadURL("tindiag_utils.php?grd=true&pelayanan_id="+getIdPel,"","GET");
				}
			}
			else if(proses=='simpan'){
				alert('Simpan Berhasil');
			}
			else if(proses=='hapus'){
				alert('Hapus Berhasil');
				if(tombolHapus == 'btnHapusRujukUnit'){
					ambilDataRujukUnit();
				}
			}
		}
		if(proses == 'hapus'){
			batal(tombolHapus);
		}
		else{
			//alert(tombolSimpan);
			batal(tombolSimpan);
		}
		//shall be deleted after function works!!!
		if(eksyennya == 'pindah kamar'){
			//alert('Pindah kamar berhasil.');
			if(document.getElementById('cmbTmpLay').value == document.getElementById("cmbTL").value){
				document.getElementById('spanKam').innerHTML = " &nbsp;&nbsp;Kamar : "+document.getElementById('cmbKamar').options[document.getElementById('cmbKamar').options.selectedIndex].innerHTML;
			}
			eksyennya = '';
		}
		jQuery("#loadGambar").load("gambar1.php?id_pasien="+getIdPasien);
		anam1.loadURL("tindiag_utils.php?grdAnamnesa=true&pasien_id="+getIdPasien,'','GET');
		//alert(b.getMaxRow());
		
		//alert(b.getMaxPage());
		if(b.getMaxPage() > 0)
		{
			document.getElementById("btnTmbh").disabled = false;
			jQuery('#btnTmbh').removeAttr('disabled');
			//document.getElementById("btnSimpanTind").disabled = false;
			isiCombo('cmbDiagRes',getIdKunj,'<?php echo $userId; ?>','cmbDiagR',default1);
			cekLockRM();
		}else{
			//alert("");
			if(document.getElementById("cmbTmpLay").value == 61)
			{
				document.getElementById("btnTmbh").disabled = false;
			}else{
				document.getElementById("btnTmbh").disabled =false;//mael
			}
			//alert(document.getElementById("btnTmbh").disabled);
			//document.getElementById("btnSimpanTind").disabled = true;
			isiCombo('cmbDiagRes',getIdKunj,'<?php echo $userId; ?>','cmbDiagR',default1);
		}
		
		
		if((getTglOut != 0) && (getTglOut != " ") && (typeof getTglOut != "undefined"))
		{
			//alert(getTglOut+" 1");
			//p ="btnSimpanTind*-*Tambah*|*btnHapusTind*-*true*|*btnSimpanTind*-*true";
			if(document.getElementById("cmbTmpLay").value == 61)
			{
				document.getElementById("btnTmbh").disabled = false;
			}else{
				document.getElementById("btnTmbh").disabled = false;//mael
			}
			//document.getElementById("btnEditResep").disabled = true;		
		}
		
		if(ket==1)
		{
			document.getElementById("btnSimpanDiag").value="Simpan";
			ket=0;
		}else{
			document.getElementById("btnSimpanDiag").value="Tambah";
		}
		//jQuery("#btnIsiDataRM18").load("batal_kunjungan.php?id_pelayanan="+getIdPel+"&unit="+document.getElementById("cmbTmpLay").value);
	}
//========================tambahan raga=====================
	function CmbChange2(p,q){
			switch(p){
				case "kesakitan":
					isiCombo2('jnskasus',q,'','jeniskasus');
					break;
			}
	}
	
	function lihatDetail(p,q){
			switch(p){
				case "kia_jenis":
					isiCombo2('detailKIA',q,'','kia_detail');
					if(q==3 || q==5){
						document.getElementById('kiadetail').style.display = 'table-row';
					}
					else{
						document.getElementById('kiadetail').style.display = 'none';
					}
					break;
			}
	}
	
	function isiCombo2(id,val,defaultId,targetId,evloaded,targetWindow){
		if(targetId=='' || targetId==undefined){
			targetId=id;
		}
		//alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'',parent.window);
		Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId+"&cabang="+cabang,targetId,'','GET',evloaded,'',parent.window);
	}
	
	function isiCombo3(id,val,defaultId,targetId,evloaded,targetWindow){
		if(targetId=='' || targetId==undefined){
			targetId=id;
		}
		//alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'',parent.window);
		Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId+'&loop1=1'+"&cabang="+cabang,targetId,'','GET',evloaded,'',parent.window);
	}
	
	function detailPil(){
	//alert(document.getElementById('sifat').value);
	var sifat = document.getElementById('sifat').value;
	if(sifat==1 || sifat==2){
		document.getElementById('ket_sifat').style.visibility='hidden';
		}
	if(sifat==3){
		document.getElementById('ket_sifat').style.visibility='visible';
		}
	}
	<!---------------------------------------------addRowTable-------------------------------------->
function addRowToTable()
{
	kedua=1;
//use browser sniffing to determine if IE or Opera (ugly, but required)
	var isIE = false;
	if(navigator.userAgent.indexOf('MSIE')>0){isIE = true;}
//	alert(navigator.userAgent);
//	alert(isIE);
  var tbl = document.getElementById('tblJual');
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow;
  var row = tbl.insertRow(lastRow);
  	//row.id = 'row'+(iteration-1);
  	row.className = 'itemtableA';
	//row.setAttribute('class', 'itemtable');
	row.onmouseover = function(){this.className='itemtableAMOver';};
	row.onmouseout = function(){this.className='itemtableA';};
	//row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
	//row.setAttribute('onMouseOut', "this.className='itemtable'");
  
  // left cell
  var cellLeft = row.insertCell(0);
  var textNode = document.createTextNode(iteration-1);
  cellLeft.className = 'tdisikiri';
  cellLeft.appendChild(textNode);

  
  // right cell
  cellRight = row.insertCell(1);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'id_pr';
	el.id = 'id_pr';
  	
  }else{
  	el = document.createElement('<input name="id_pr" />');
  }
  el.type = 'hidden';
  cellRight.appendChild(el);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'idpn';
	el.id = 'idpn';
  	
  }else{
  	el = document.createElement('<input name="idpn" />');
  }
  el.type = 'hidden';
  cellRight.appendChild(el);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'idkode';
	el.id = 'idkode';
  	
  }else{
  	el = document.createElement('<input name="idkode" />');
  }
  el.type = 'hidden';
  cellRight.appendChild(el);
  
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'kode';
	el.id = 'kode';
	el.setAttribute('OnKeyUp', "suggestBag(event,this);");
	el.setAttribute('autocomplete', "off");
	 	
  }else{
  	el = document.createElement('<input name="kode" id="kode" onkeyup="suggestBag(event, this);" autocomplete="off"/>');
  }
  el.type = 'text';
  el.size = 10;
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  cellRight = row.insertCell(2);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'jenis';
	el.id = 'jenis';
	el.readOnly = true;
  	
  }else{
  	el = document.createElement('<input name="jenis" id="jenis" readonly="readonly"/>');
  }
  el.type = 'text';
  el.size = 30;
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellRight = row.insertCell(3);
  cellRight.style.display='none';
 if(!isIE){
  	el = document.createElement('input');
  	el.name = 'idgoldar';
	el.id = 'idgoldar';
  	
  }else{
  	el = document.createElement('<input name="idgoldar" />');
  }
  el.type = 'hidden';
  cellRight.appendChild(el);
  
 if(!isIE){
  	el = document.createElement('input');
  	el.name = 'gol';
	el.id = 'gol';
	el.readOnly = true;
  	
  }else{
  	el = document.createElement('<input name="gol" id="gol" readonly="readonly"/>');
  }
  el.type = 'text';
  el.size = 5;
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellRight = row.insertCell(4);
  cellRight.style.display='none';
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'idresus';
	el.id = 'idresus';
  	
  }else{
  	el = document.createElement('<input name="idresus" />');
  }
  el.type = 'hidden';
  cellRight.appendChild(el);
  
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'resus';
	el.id = 'resus';
	el.readOnly = true;
  	
  }else{
  	el = document.createElement('<input name="resus" id="resus" readonly="readonly"/>');
  }
  el.type = 'text';
  el.size = 5;
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellRight = row.insertCell(5);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'jumlah';
	el.id = 'jumlah';
	el.setAttribute('OnKeyUp', "hitungBiaya(this);");
	el.setAttribute('autocomplete', "off");
  	
  }else{
  	el = document.createElement('<input name="jumlah" id="jumlah" onkeyup="hitungBiaya(this);" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 3;
  el.className = 'textcenter';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

cellRight = row.insertCell(6);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'kemasan';
	el.id = 'kemasan';
	el.value = 'Kantong';
	el.readOnly = true;
  	
  }else{
  	el = document.createElement('<input name="kemasan" id="kemasan" value="Kantong" readonly="readonly" />');
  }
  el.type = 'text';
  el.size = 10;
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

cellRight = row.insertCell(7);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'biaya';
	el.id = 'biaya';
	el.value = '0';
	el.readOnly = true;  	
  }else{
  	el = document.createElement('<input name="biaya" id="biaya" value="0" align="right" readonly="readonly" />');
  }
  el.type = 'text';
  el.size = 10;
  el.className = 'textright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 't_biaya';
	el.id = 't_biaya';
  	
  }else{
  	el = document.createElement('<input name="t_biaya" id="t_biaya" />');
  }
  el.type = 'hidden';
  el.size = 10;
  cellRight.appendChild(el);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'b_umum';
	el.id = 'b_umum';
  	
  }else{
  	el = document.createElement('<input name="b_umum" id="b_umum" />');
  }
  el.type = 'hidden';
  el.size = 10;
  cellRight.appendChild(el);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'b_askes';
	el.id = 'b_askes';
  	
  }else{
  	el = document.createElement('<input name="b_askes" id="b_askes" />');
  }
  el.type = 'hidden';
  el.size = 10;
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(8);
  if(!isIE){
  	el = document.createElement('img');
  	el.setAttribute('onClick','removeRowFromTable(this);');
  }else{
  	el = document.createElement('<img name="img" onClick="removeRowFromTable(this);"/>');
  }
  el.src = '../icon/erase.png';
  el.border = "0";
  el.width = "16";
  el.height = "16";
  el.className = 'proses';
  el.align = "absmiddle";
  el.title = "Klik Untuk Menghapus";
  
//  cellRight.setAttribute('class', 'tdisi');
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  document.form_darah.kode[iteration-2].focus();
}

function removeRowFromTable(cRow)
{
	//alert(cRow.parentNode.parentNode.rowIndex);
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  if (jmlRow > 2){
  	var i=cRow.parentNode.parentNode.rowIndex;
  //if (i>2){
	  tbl.deleteRow(i);
	  var lastRow = tbl.rows.length;
	  for (var i=2;i<lastRow;i++){
		var tds = tbl.rows[i].getElementsByTagName('td');
		tds[0].innerHTML=i-1;
	  }
	  //HitungTot();
  }
}

//==========================
var RowIdx;
var fKeyEnt;

function suggestBag(e,par){
var keywords=par.value;//alert(keywords);
	//alert(par.offsetLeft);
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  var i;
  if (jmlRow > 2){
  	i=par.parentNode.parentNode.rowIndex-2;
  }else{
  	i=0;	
  }
  //alert(jmlRow+'-'+i);
	if(keywords==""){
		document.getElementById('divbag').style.display='none';
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
			var tblRow=document.getElementById('tblbag').rows.length;
			if (tblRow>0){
				//alert(RowIdx);
				if (key==38 && RowIdx>0){
					RowIdx=RowIdx-1;
					document.getElementById(RowIdx+1).className='itemtableReq';
					if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
				}else if (key==40 && RowIdx<tblRow){
					//alert('asd');
					RowIdx=RowIdx+1;
					if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
					document.getElementById(RowIdx).className='itemtableMOverReq';
				}
			}
		}else if (key==13){
			if (RowIdx>0){
				if (fKeyEnt==false){
					ValNamaBag(document.getElementById(RowIdx).lang);
				}else{
					fKeyEnt=false;
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			RowIdx=0;
			fKeyEnt=false;
			ReqAddr='suggest_kodebag.php?keyword='+keywords+'&gol='+document.getElementById('golongan').value+'&no='+i;
			//alert(ReqAddr);
			Request(ReqAddr , 'divbag', '', 'GET' );		
			if (document.getElementById('divbag').style.display=='none') {	
				fSetPosisi_darah(document.getElementById('divbag'),par);
			}
			document.getElementById('divbag').style.display='block';
		}
	}
}

var kedua=0;
function ValNamaBag(par){
	var cdata=par.split("|");
	//var tbl = document.getElementById('tblJual');
	//alert(par);
	if(document.form_darah.idkode.length==undefined){
		kedua=0;
	}
	if ((cdata[0]*1)==0){
		if(kedua==1){
			//document.forms[0].idP[(cdata[0]*1)].value=cdata[1];
			document.form_darah.idpn[(cdata[0])].value=cdata[1];
			//document.form_darah.bag[(cdata[0])].value=cdata[2];
			document.form_darah.idkode[(cdata[0])].value=cdata[3];
			document.form_darah.kode[(cdata[0])].value=cdata[4];
			document.form_darah.jenis[(cdata[0])].value=cdata[5];
			document.form_darah.idgoldar[(cdata[0])].value=cdata[6];
			if(getKsoId != 4 && getKsoId != 6)
				document.form_darah.t_biaya[(cdata[0])].value=cdata[8];
			else
				document.form_darah.t_biaya[(cdata[0])].value=cdata[9];
			document.form_darah.b_umum[(cdata[0])].value=cdata[8];
			document.form_darah.b_askes[(cdata[0])].value=cdata[9];
			document.form_darah.gol[(cdata[0])].value=cdata[7];
			document.form_darah.idresus[(cdata[0])].value=cdata[10];
			document.form_darah.resus[(cdata[0])].value=cdata[11];
			document.form_darah.jumlah[(cdata[0])].focus();
		}
		if(kedua==0){
			document.form_darah.idpn.value=cdata[1];
			//document.form_darah.bag.value=cdata[2];
			document.form_darah.idkode.value=cdata[3];
			document.form_darah.kode.value=cdata[4];
			document.form_darah.jenis.value=cdata[5];	
			document.form_darah.idgoldar.value=cdata[6];
			if(getKsoId != 4 && getKsoId != 6)
				document.form_darah.t_biaya.value=cdata[8];
			else
				document.form_darah.t_biaya.value=cdata[9];
			document.form_darah.b_umum.value=cdata[8];
			document.form_darah.b_askes.value=cdata[9];
			document.form_darah.gol.value=cdata[7];
			document.form_darah.idresus.value=cdata[10];
			document.form_darah.resus.value=cdata[11];
			document.form_darah.jumlah.focus();
			
			kedua=1;
		}
	}else{
		//document.forms[0].idP[(cdata[0]*1)].value=cdata[1];
		document.form_darah.idpn[(cdata[0])].value=cdata[1];
		//document.form_darah.bag[(cdata[0])].value=cdata[2];
		document.form_darah.idkode[(cdata[0])].value=cdata[3];
		document.form_darah.kode[(cdata[0])].value=cdata[4];
		document.form_darah.jenis[(cdata[0])].value=cdata[5];
		document.form_darah.idgoldar[(cdata[0])].value=cdata[6];
		if(getKsoId != 4 && getKsoId != 6)
			document.form_darah.t_biaya[(cdata[0])].value=cdata[8];
		else
			document.form_darah.t_biaya[(cdata[0])].value=cdata[9];
		document.form_darah.b_umum[(cdata[0])].value=cdata[8];
		document.form_darah.b_askes[(cdata[0])].value=cdata[9];
		document.form_darah.gol[(cdata[0])].value=cdata[7];
		document.form_darah.idresus[(cdata[0])].value=cdata[10];
		document.form_darah.resus[(cdata[0])].value=cdata[11];
		document.form_darah.jumlah[(cdata[0])].focus();
	}
	document.getElementById('divbag').style.display='none';
	hitungTot();
}

function hitungTot(){
	var ctot=0;
	if (document.form_darah.idkode.length > 1){
		for (var i=0;i<document.form_darah.idkode.length;i++){
			ctot+=document.form_darah.t_biaya[i].value*document.form_darah.jumlah[i].value;
		}
	}else{
		ctot+=document.form_darah.t_biaya.value*document.form_darah.jumlah.value;
	}
	document.getElementById('spntotal').innerHTML=ctot;
}

function hitungBiaya(jml){
	if (document.form_darah.idkode.length > 1){
		for (var i=0;i<document.form_darah.idkode.length;i++){
			var biaya = document.form_darah.t_biaya[i].value * document.form_darah.jumlah[i].value;
			document.form_darah.biaya[i].value = biaya;
		}
	}
	else if(document.form_darah.idkode.length==undefined){
		var biaya = document.form_darah.t_biaya.value * document.form_darah.jumlah.value;
		document.form_darah.biaya.value = biaya;
	}
	hitungTot();
}

function actMintaDarah(aksi){
	if(document.form_darah.idkode.length==undefined){
		if(document.form_darah.kode.value==''||document.form_darah.jenis.value==''||document.form_darah.jumlah.value==''){
			alert('masih ada data yang kosong');
			return false;
		}
	}
	if (document.form_darah.idkode.length > 1){
		for(var it=document.form_darah.id_pr.length;it>0;it--){
			if(document.form_darah.kode[it-1].value==''||document.form_darah.jenis[it-1].value==''||document.form_darah.jumlah[it-1].value==''){
				alert('masih ada data yang kosong');
				return false;
			}
		}
	}
	
	var cdata='';
	var ctemp='';
	if (document.form_darah.idkode.length > 1){
		for (var i=0;i<document.form_darah.idkode.length;i++){
			temp=document.form_darah.idkode[i].value+'|'+document.form_darah.idgoldar[i].value+'|'+document.form_darah.idresus[i].value+'|'+document.form_darah.biaya[i].value+'|'+document.form_darah.jumlah[i].value+'|'+document.form_darah.b_umum[i].value+'|'+document.form_darah.id_pr[i].value+"**";
			ctemp=ctemp+temp;
		}
		cdata=ctemp;
		document.getElementById('fdata').value=cdata;
	}
	else if(document.form_darah.idkode.length==undefined){
		temp=document.form_darah.idkode.value+'|'+document.form_darah.idgoldar.value+'|'+document.form_darah.idresus.value+'|'+document.form_darah.biaya.value+'|'+document.form_darah.jumlah.value+'|'+document.form_darah.b_umum.value+'|'+document.form_darah.id_pr.value+"**";
		document.getElementById('fdata').value=temp;
	}
	Request('minta_no_permintaan_darah.php','temp_no_minta','','GET',proses_minta_darah(aksi),'NoLoad');
	jQuery("#loadGambar1").load("minta_no_permintaan_darah1.php");
}

var glob_no_minta = '';
function proses_minta_darah(aksi){
	var idkunjungan = getIdKunj;
	var idpelayanan = getIdPel;
	var tgl = document.getElementById('tglDarah').value;
	//alert(aksi);
	var no_minta;
	if(aksi=='tambah'){
		no_minta = document.getElementById('temp_no_minta').innerHTML;
	}
	else {
		no_minta = document.getElementById('no_bukti').value;
	}
	glob_no_minta=no_minta;
	document.getElementById('no_bukti').value = document.getElementById('temp_no_minta').innerHTML;
	var id_dokter = document.getElementById('id_dokter').value;
	var sifat = document.getElementById('sifat').value;
	var tggl = document.getElementById('tggl').value;
	var jam = document.getElementById('jam').value;
	var fdata = document.getElementById('fdata').value;
	var alasan1 = document.getElementById('alasan1').value;
	var petugas1 = document.getElementById('petugas1').value;
	var rhesus = document.getElementById('rhesus').value;
	//Request('minta_darah_util.php?act=tambah&idkunjungan='+idkunjungan+'&idpelayanan='+idpelayanan+'&idkso='+getKsoId+'&tgl='+tgl+'&no_minta='+no_minta+'&id_dokter='+id_dokter+'&sifat='+sifat+'&fdata='+fdata,'DapatDarah','','GET');
	//alert('minta_darah_util.php?act='+aksi+'&idkunjungan='+idkunjungan+'&idpelayanan='+idpelayanan+'&idkso='+getKsoId+'&tgl='+tgl+'&no_minta='+no_minta+'&id_dokter='+id_dokter+'&sifat='+sifat+'&tggl='+tggl+'&jam='+jam+'&fdata='+fdata);
	md.loadURL('minta_darah_util.php?act='+aksi+'&idkunjungan='+idkunjungan+'&idpelayanan='+idpelayanan+'&idkso='+getKsoId+'&tgl='+tgl+'&no_minta='+no_minta+'&id_dokter='+id_dokter+'&sifat='+sifat+'&tggl='+tggl+'&jam='+jam+'&fdata='+fdata+'&alasan1='+alasan1+'&petugas1='+petugas1+'&rhesus='+encodeURIComponent(rhesus)+'&idpelayanan_inserted='+glob_pelayanan_id_inserted,'','GET');
	batall();
	document.getElementById('btCetak').disabled=false;	
	jQuery('#btCetak').removeAttr('disabled');//alert('minta_darah_util.php?act=tambah&idkunjungan='+idkunjungan+'&idpelayanan='+idpelayanan+'&idkso='+getKsoId+'&tgl='+tgl+'&no_minta='+no_minta+'&id_dokter='+id_dokter+'&sifat='+sifat+'&fdata='+fdata);
	//jQuery('#btnTmbh').removeAttr('disabled');
	//alert('minta_darah_util.php?act=tambah&idkunjungan='+idkunjungan+'&idpelayanan='+idpelayanan+'&idkso='+getKsoId+'&tgl='+tgl+'&no_minta='+no_minta+'&id_dokter='+id_dokter+'&sifat='+sifat+'&fdata='+fdata);
	//window.open('../../bank_darah/bd/permintaan_darah_untuk_transfusi.php?idpel='+idpelayanan+'&idkunj='+idkunjungan);
	md.loadURL('minta_darah_util.php?idpelayanan='+idpelayanan+'&idpelayanan_inserted='+glob_pelayanan_id_inserted,'','GET');
}

function cetakPermintaanDarah(){
	var idkunjungan = getIdKunj;
	var idpelayanan = getIdPel;
	var cito = document.getElementById("sifat").value;
	var idUsr = "<? echo userId;?>";
	window.open('../report_rm/Form_RSU/formulir_permintaan_darah.php?idPel='+idpelayanan+'&idKunj='+idkunjungan+'&no_minta='+glob_no_minta+'&idUsr='+idUsr+'&cito='+cito);
}


md=new DSGridObject("gbMintaDarah");
md.setHeader("PERMINTAAN DARAH");
md.setColHeader("NO,TGL,NO PERMINTAAN,KODE,JENIS,JUMLAH");
md.setIDColHeader(",,,,,");
md.setColWidth("30,80,150,50,150,50");
md.setCellAlign("center,center,left,left,left,center");
md.setCellHeight(20);
md.setImgPath("../icon");
md.setIDPaging("pagingMD");
md.attachEvent("onRowClick","ambilMD");
md.baseURL("minta_darah_util.php?idpelayanan=0");
md.Init();


function ambilMD(){
	var ids = md.getRowId(md.getSelRow()).split("|");
	//alert(ids[9]+"\n"+ids[10]);
	document.getElementById('id_pr').value = ids[0];
	document.getElementById('idkode').value = ids[1];
	document.getElementById('idgoldar').value = ids[2];
	document.getElementById('idresus').value = ids[3];
	document.getElementById('alasan1').value = ids[9];
	document.getElementById('petugas1').value = ids[10];
	document.getElementById('btHapus').disabled=false;
	jQuery('#btHapus').removeAttr('disabled');
	document.getElementById('btSimpan').value = 'update';
	document.getElementById('btSimpan').style.display='inline';
	document.getElementById('btSimpan').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Update';
    document.getElementById('btHapus').innerHTML='<img src="../icon/delete.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
	document.form_darah.sifat.value = ids[7];
	document.form_darah.kode.value = md.cellsGetValue(md.getSelRow(),4);
	document.form_darah.jenis.value = md.cellsGetValue(md.getSelRow(),5);
	jQuery("#rhesus").val(ids[11]);
	if(getKsoId==4 || getKsoId==6){
		document.getElementById('t_biaya').value = ids[6];
	}
	else{
		document.getElementById('t_biaya').value = ids[5];
	}
	document.getElementById('jumlah').value = md.cellsGetValue(md.getSelRow(),6);
	document.getElementById('biaya').value = document.getElementById('t_biaya').value * document.getElementById('jumlah').value;
	document.form_darah.tglDarah.value = md.cellsGetValue(md.getSelRow(),2);
	document.form_darah.no_bukti.value = md.cellsGetValue(md.getSelRow(),3);
	glob_no_minta = md.cellsGetValue(md.getSelRow(),3);
	//document.form_darah.id_dokter.value = ids[8];
	//document.form_darah.gol.value = md.cellsGetValue(md.getSelRow(),6);
	//document.form_darah.resus.value = md.cellsGetValue(md.getSelRow(),7);
	document.form_darah.b_umum.value=ids[5];
	document.form_darah.b_askes.value=ids[6];
	document.getElementById('spntotal').innerHTML=ids[5];
	//var dosis = grdRM.cellsGetValue(grdRM.getSelRow(),2);
}

function batall(){
	if (document.form_darah.idkode.length > 1){
		for(var i=document.form_darah.idkode.length;i>=2;i--){			
			var del=i+1;
			var tbl=document.getElementById('tblJual');
			tbl.deleteRow(del);
		}
	}
	/*
	document.getElementById('idkode').value = '';
	document.getElementById('idgoldar').value = '';
	document.getElementById('idresus').value = '';
	document.getElementById('t_biaya').value = '';
	document.getElementById('jumlah').value = '';
	document.getElementById('biaya').value = '';
	*/
	
	document.form_darah.idkode.value='';
	document.form_darah.idgoldar.value='';
	document.form_darah.idresus.value='';
	document.form_darah.t_biaya.value='';
	document.form_darah.jumlah.value='';
	document.form_darah.biaya.value='';
	
	
	document.form_darah.tglDarah.value = '<?php echo date('d-m-Y'); ?>';
	document.form_darah.no_bukti.value = document.getElementById('temp_no_minta').innerHTML;
	document.form_darah.kode.value = '';
	document.form_darah.jenis.value = '';
	document.form_darah.gol.value = '';
	document.form_darah.resus.value = '';
	document.form_darah.b_umum.value='';
	document.form_darah.b_askes.value='';
	document.getElementById("alasan1").value = "";
	document.getElementById("petugas1").value = "";
	/*
	document.getElementById('btHapus').disabled=true;
	document.getElementById('btSimpan').value = 'tambah';
	document.getElementById('btSimpan').innerHTML='<img src="../icon/add.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan';
    document.getElementById('btHapus').innerHTML='<img src="../icon/delete2.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
	*/
	
	document.getElementById('spntotal').innerHTML='0';
	
	document.form_darah.btHapus.disabled=true;
	document.form_darah.btSimpan.value='tambah';
	document.getElementById('btSimpan').style.display='none';
	document.form_darah.btSimpan.innerHTML='<img src="../icon/add.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan';
	document.form_darah.btHapus.innerHTML='<img src="../icon/delete2.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
}

function hapuss(){
	var id=document.form_darah.id_pr.value;
	var no_bukti=document.form_darah.no_bukti.value;
	if(document.form_darah.id_pr.value=='' || document.form_darah.id_pr.value==null){
		alert("Pilih data yang akan dihapus terlebih dahulu.. !")
	}else{
		if(confirm("Apakah anda yakin ingin menghapus data ini ?")){
			md.loadURL("minta_darah_util.php?act=hapus&id="+id+"&idpelayanan="+getIdPel+"&no_minta="+no_bukti+"&idpelayanan_inserted="+fidRujukUnit,"","GET");
			md.loadURL("minta_darah_util.php?idpelayanan="+getIdPel+"&idpelayanan_inserted="+fidRujukUnit,"","GET");
		}
	}
	batall();
}

function ambilDataListKonsul(){
	
}

//========================tambahan raga=====================

	/* lk=new DSGridObject("gbListKonsul");
	lk.setHeader("DATA KONSUL LAB");
	lk.setColHeader("NO,TGL,UNIT,UNIT PERUJUK,DOKTER,KETERANGAN,PENGINPUT,STATUS");
	lk.setIDColHeader(",,unit,,dokter,,,");
	lk.setColWidth("30,80,100,100,200,150,150,150");
	lk.setCellAlign("center,center,left,left,left,left,left,left,center");
	lk.setCellHeight(20);
	lk.setImgPath("../icon");
	//lk.onLoaded(konfirmasi);
	lk.setIDPaging("pgListKonsul");
	lk.attachEvent("onRowClick","ambilDataListKonsul");
	lk.baseURL("tindiag_utils.php?grdListKonsul=true&UnitKonsul=0&kunjungan_id=0&unitAsal=0");
	lk.Init(); */
	
	lk=new DSGridObject("gbListKonsul");
	lk.setHeader("DATA KONSUL LAB");
	lk.setColHeader("NO,TGL,UNIT,UNIT PERUJUK,DOKTER,STATUS,PENGINPUT,KETERANGAN");
	lk.setIDColHeader(",,unit,,dokter,,,");
	lk.setColWidth("30,80,100,100,140,150,150,150");
	lk.setCellAlign("center,center,left,left,left,left,left,left,center");
	lk.setCellHeight(20);
	lk.setImgPath("../icon");
	//lk.onLoaded(konfirmasi);
	lk.setIDPaging("pgListKonsul");
	lk.attachEvent("onRowClick","ambilDataListKonsul");
	lk.baseURL("tindiag_utils.php?grdListKonsul=true&UnitKonsul=0&kunjungan_id=0&unitAsal=0");
	lk.Init();
	
	
	c=new DSGridObject("gridboxRujukUnit");
	c.setHeader("DATA RUJUK UNIT");
	c.setColHeader("NO,TGL,UNIT,DOKTER,DOKTER TUJUAN,KETERANGAN");
	c.setIDColHeader(",,unit,dokter,doktertujuan,");
	c.setColWidth("30,80,100,200,200,150");
	c.setCellAlign("center,center,left,left,left,left");
	c.setCellHeight(20);
	c.setImgPath("../icon");
	c.onLoaded(konfirmasi);
	//c.setIDPaging("pagingRujukUnit");
	c.attachEvent("onRowClick","ambilDataRujukUnit");
	c.baseURL("tindiag_utils.php?grd2=true&kunjungan_id=0&unitAsal=0");
	//c.baseURL("tindiag_utils.php?grd2=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit);
	//pasienId="+getIdPasien
	c.Init();
	
	kd=new DSGridObject("gridboxKonDok");
	kd.setHeader("DATA KONSUL DOKTER");
	kd.setColHeader("NO,TGL,DOKTER,KETERANGAN");
	kd.setIDColHeader(",,dokter,");
	kd.setColWidth("30,100,200,150");
	kd.setCellAlign("center,left,left,left,left");
	kd.setCellHeight(20);
	kd.setImgPath("../icon");
	kd.onLoaded(konfirmasi);
	kd.attachEvent("onRowClick","ambilDataKonDok");
	kd.baseURL("kondok_utils.php?pelayanan_id=0");
	kd.Init();
	
	lkd=new DSGridObject("gridboxListKonDok");
	lkd.setHeader("DAFTAR KONSUL DOKTER");
	lkd.setColHeader("NO,TGL,NO RM,NAMA,UNIT,KET,DETIL,DILAYANI");
	lkd.setIDColHeader(",tgl,no_rm,nama,unit,ket,,");
	lkd.setColWidth("30,100,80,200,150,300,50,40");
	lkd.setCellAlign("center,center,center,left,left,left,center,center");
	lkd.setCellType("txt,txt,txt,txt,txt,txt,txt,chk");
	lkd.setCellHeight(20);
	lkd.setImgPath("../icon");
	lkd.setIDPaging("pagingListKonDok");
	lkd.onLoaded(konfirmasi);
	lkd.attachEvent("onRowClick","updateKonsulDokter");
	lkd.baseURL("listkondok_utils.php?dokter_id=<?php echo $userId; ?>&dilayani="+document.getElementById('cmbStatusKonDok').value);
	lkd.Init();

	d=new DSGridObject("gridboxRujukRS");
	d.setHeader("DATA KELUAR RUMAH SAKIT");
	d.setColHeader("NO,TANGGAL,CARA KELUAR,KEADAAN KELUAR,KASUS,RUMAH SAKIT,DOKTER,EMERGENCY,KONDISI PASIEN,KETERANGAN");
	d.setIDColHeader(",,cara_keluar,keadaan_keluar,kasus,rs,dokter,emergency,kondisi,ket");
	d.setColWidth("30,80,100,150,70,200,150,150,100,100");
	d.setCellAlign("center,center,center,center,left,left,left,center,center,left");
	d.setCellHeight(20);
	d.setImgPath("../icon");
	d.onLoaded(konfirmasi);
	//d.setIDPaging("pagingRujukRS");
	d.attachEvent("onRowClick","ambilDataRujukRS");
	//alert("tindiag_utils.php?grd3=true&kunjungan_id="+getIdKunj);
	d.baseURL("tindiag_utils.php?grd3=true&kunjungan_id=0");
	//d.baseURL("tindiag_utils.php?grd3=true&kunjungan_id="+getIdKunj);
	d.Init();

	e=new DSGridObject("gridboxKamar");
	e.setHeader("DATA SET KAMAR");
	e.setColHeader("NO,TGL MASUK,TGL KELUAR,KAMAR,BIAYA");
	e.setIDColHeader(",tgl_in,tgl_out,nama,");
	e.setColWidth("30,150,150,100,100");
	e.setCellAlign("center,center,center,left,right");
	e.setCellHeight(20);
	e.setImgPath("../icon");
	e.onLoaded(konfirmasi);
	//d.setIDPaging("pagingRujukRS");
	e.attachEvent("onRowClick","ambilDataKamar");
	//e.baseURL("tindiag_utils.php?grd4=true&kunjungan_id="+getIdKunj+"&unit_id="+getIdUnit);
	e.baseURL("tindiag_utils.php?grd4=true&kunjungan_id=0&unit_id=0");
	e.Init();
	
	anam=new DSGridObject("gridboxAnamnesa");
	anam.setHeader("DATA ANAMNESA");
	anam.setColHeader("NO,TANGGAL,DOKTER");
	anam.setIDColHeader(",TGL,");
	anam.setColWidth("30,100,350");
	anam.setCellAlign("center,center,left");
	anam.setCellHeight(20);
	anam.setImgPath("../icon");
	anam.onLoaded(konfirmasi);
	anam.setIDPaging("pagingAnamnesa");
	anam.attachEvent("onRowClick","ambilDataAnamnesa");
	anam.baseURL("tindiag_utils.php?grdAnamnesa=true&pasien_id="+getIdPasien);
	anam.Init();
	
	var RowIdxObat2;
	function suggestObat_bhp(e,par){
		var id_unit = document.getElementById('cmbTmpLay').value;
		var keywords=par.value;
		if(keywords==""){
			document.getElementById('divobat_bhp').style.display='none';
		}
		else{
			if(par.value.length > 1){
				var key;
				if(window.event) {
					key = window.event.keyCode;
				}
				else if(e.which) {
					key = e.which;
				}
				//alert(key);
				if (key==38 || key==40){
					var tblRow=document.getElementById('tblObat').rows.length;
					if (tblRow>0){
						//alert(RowIdx);
						if (key==38 && RowIdxObat2>0){
							RowIdxObat2=RowIdxObat2-1;
							document.getElementById(RowIdxObat2+1).className='itemtableReq';
							if (RowIdxObat2>0) document.getElementById(RowIdxObat2).className='itemtableMOverReq';
						}
						else if (key == 40 && RowIdxObat2 < tblRow){
							RowIdxObat2=RowIdxObat2+1;
							if (RowIdxObat2>1) document.getElementById(RowIdxObat2-1).className='itemtableReq';
							document.getElementById(RowIdxObat2).className='itemtableMOverReq';
						}
					}
				}
				else if (key==13){
					if (RowIdxObat2>0){
						if (fKeyEntObat==false){
							fSetObat(document.getElementById(RowIdxObat2).lang);
						}
						else{
							fKeyEntObat=false;
						}
					}
				}
				else if (key!=27 && key!=37 && key!=39){
					fKeyEntObat=false;
					if (key==123){
						RowIdxObat2=0;
						Request('obatlist_bhp.php?id_unit='+id_unit+'&aKeyword='+keywords, 'divobat_bhp', '', 'GET' );
					}
					else if (key==120){
						//alert(RowIdxObat2);
					}
					else{
						RowIdxObat2=0;
						Request('obatlist_bhp.php?id_unit='+id_unit+'&aKeyword='+keywords, 'divobat_bhp', '', 'GET' );
					}
					if (document.getElementById('divobat_bhp').style.display=='none')
						//document.getElementById('divobat_bhp').style.top='305px';
						fSetPosisi(document.getElementById('divobat_bhp'),par);
					document.getElementById('divobat_bhp').style.display='block';
					/* RowIdxObat2=0;
								fKeyEntObat=false;
								//alert('obatlist.php?aKeyword='+keywords+'&idapotek='+document.getElementById('cmbApotek').value);
								Request('obatlist.php?aKeyword='+keywords+'&idapotek='+document.getElementById('cmbApotek').value+'&kepemilikanId='+getKepemilikan, 'divobat_bhp', '', 'GET' );
								if (document.getElementById('divobat_bhp').style.display=='none') fSetPosisi(document.getElementById('divobat_bhp'),par);
								document.getElementById('divobat_bhp').style.display='block'; */
				}
			}
		}
	}
	
	function fSetObat_bhp(par){//menampilkan obat/bahan
		var id_unit = document.getElementById('cmbTmpLay').value;
		var data_bhp=par.split("*|*");
		document.getElementById("penerimaan_id_bhp").value = data_bhp[1];
		document.getElementById("obat_id_bhp").value = data_bhp[2];
		document.getElementById("unit_id_terima_bhp").value = data_bhp[3];
		document.getElementById("kepemilikan_id_bhp").value = data_bhp[11];
		document.getElementById("nama_bahan").value = data_bhp[4];
		//document.getElementById("kepemilikan_id_bhp").value = getKepemilikan;
		document.getElementById("unit_id_bhp").value = getIdUnit;
		
		document.getElementById("kso_id_bhp").value = getKsoId;
		document.getElementById("pelayanan_id_bhp").value = getIdPel;
		document.getElementById("no_pas").value = document.getElementById("txtNo").value;
		document.getElementById("nama_pas").value = document.getElementById("txtNama").value;
		document.getElementById("alamat_pas").value = document.getElementById("txtAlmt").value;
		document.getElementById("h_satuan").value = data_bhp[9];
		//var totalnya = parseFloat(data_bhp[8])*parseFloat(data_bhp[9]);
		//document.getElementById("h_total").value = totalnya;
		document.getElementById("user_act_bhp").value = <?=$userId;?>
		
		
		document.getElementById('divobat_bhp').style.display='none';
		//alert(document.getElementById("statusPx").value);
//		document.getElementById('btnSimpanResep').focus();
	}
	
	function cCekOut(id)
	{
		getTglOut=0;
		cekLockRM();
	}
	
	function simpan_bhp(act){
		var nama_bahan = document.getElementById("nama_bahan").value;
		var penerimaan_id_bhp = document.getElementById("penerimaan_id_bhp").value;
		var obat_id_bhp = document.getElementById("obat_id_bhp").value;
		var unit_id_terima_bhp = document.getElementById("unit_id_terima_bhp").value;
		var kepemilikan_id_bhp = document.getElementById("kepemilikan_id_bhp").value
		var unit_id_bhp = document.getElementById("unit_id_bhp").value;
		var kso_id_bhp = document.getElementById("kso_id_bhp").value;
		var tggl_bhp = document.getElementById("tggl_bhp").value;
		//var tggl_act_bhp = document.getElementById("tggl_act_bhp").value;
		var pelayanan_id_bhp = document.getElementById("pelayanan_id_bhp").value;
		var no_pas = document.getElementById("no_pas").value;
		var nama_pas = document.getElementById("nama_pas").value;
		var alamat_pas = document.getElementById("alamat_pas").value;   
		var jumlah_bhp = document.getElementById("jumlah_bhp").value;
		var h_satuan = document.getElementById("h_satuan").value;
		//var h_total = document.getElementById("h_total").value;
		var keterangan_bhp = document.getElementById("keterangan_bhp").value;
		var user_act_bhp = document.getElementById("user_act_bhp").value;
		var status_bhp = document.getElementById("status_bhp").value;
		if(nama_bahan=="" || jumlah_bhp=="")
		{
			alert('Pengisian Form Kurang Lengkap !');
		}
		else
		{
			if(act=='Tambah')
			{
				var url_bhp = "bhp_utils.php?act="+act+"&penerimaan_id_bhp="+penerimaan_id_bhp+"&obat_id_bhp="+obat_id_bhp+"&kepemilikan_id_bhp="+kepemilikan_id_bhp+"&unit_id_bhp="+unit_id_bhp+"&kso_id_bhp="+kso_id_bhp+"&tggl_bhp="+tggl_bhp+"&pelayanan_id_bhp="+pelayanan_id_bhp+"&no_pas="+no_pas+"&nama_pas="+nama_pas+"&alamat_pas="+alamat_pas+"&jumlah_bhp="+jumlah_bhp+"&h_satuan="+h_satuan+"&keterangan_bhp="+keterangan_bhp+"&user_act_bhp="+user_act_bhp+"&status_bhp="+status_bhp+"&unit_id_terima_bhp="+unit_id_terima_bhp+"&pelayanan_id_bhp="+getIdPel;
			}
			if(act=='Update')
			{
				var id_bhp = document.getElementById("id_bhp").value;
				var url_bhp = "bhp_utils.php?act="+act+"&id_bhp="+id_bhp+"&penerimaan_id_bhp="+penerimaan_id_bhp+"&obat_id_bhp="+obat_id_bhp+"&kepemilikan_id_bhp="+kepemilikan_id_bhp+"&jumlah_bhp="+jumlah_bhp+"&h_satuan="+h_satuan+"&keterangan_bhp="+keterangan_bhp+"&user_act_bhp="+user_act_bhp+"&status_bhp="+status_bhp+"&pelayanan_id_bhp="+getIdPel+"&jmlbu="+jmlbu+"&unit_id_bhp="+getIdUnit;
			}
		}
		//alert(url_bhp);
		
		bhp.loadURL(url_bhp,"","GET");
		batal_bhp()
	}
	var jmlbu;
		
		function ambil_bhp(){//alert(bhp.getRowId(bhp.getSelRow()));
		var sisip=bhp.getRowId(bhp.getSelRow()).split("|");
		var id = sisip[0];
		
			document.getElementById("btnSimpan_bhp").value = 'Update';
			document.getElementById("btnHapus_bhp").disabled = false;
			jQuery('#btnHapus_bhp').removeAttr('disabled');
			
			document.getElementById("id_bhp").value = sisip[0];
			document.getElementById("penerimaan_id_bhp").value = sisip[1];
			document.getElementById("obat_id_bhp").value = sisip[2];
			document.getElementById("kepemilikan_id_bhp").value = sisip[3];
			document.getElementById("user_act_bhp").value = sisip[4];
			if(sisip[5]=='1')
			{
				document.getElementById("status_bhp").checked = true;
				document.getElementById("status_bhp").value = '1';
			}
			else
			{
				document.getElementById("status_bhp").checked = false;
				document.getElementById("status_bhp").value = '0';
			}
			document.getElementById("h_satuan").value = sisip[6];
			//document.getElementById("nama_bahan").readOnly = true;
			document.getElementById("nama_bahan").disabled = true;
			document.getElementById("nama_bahan").value = bhp.cellsGetValue(bhp.getSelRow(),3);
			document.getElementById("jumlah_bhp").value = bhp.cellsGetValue(bhp.getSelRow(),5);
			jmlbu=bhp.cellsGetValue(bhp.getSelRow(),5);
			document.getElementById("keterangan_bhp").value = bhp.cellsGetValue(bhp.getSelRow(),6);
			cekKonsen();
			if(getTglOut != 0)
			{
				cekLockRM();
			}
		}
		
		function batal_bhp(){
			document.getElementById("btnSimpan_bhp").value = 'Tambah';
			document.getElementById("btnHapus_bhp").disabled = true;
			
			document.getElementById("id_bhp").value = '';
			document.getElementById("penerimaan_id_bhp").value = '';
			document.getElementById("obat_id_bhp").value = '';
			document.getElementById("kepemilikan_id_bhp").value = '';
			document.getElementById("user_act_bhp").value = '';
			document.getElementById("nama_bahan").value = '';
			document.getElementById("h_satuan").value = '';
			document.getElementById("jumlah_bhp").value = '';
			document.getElementById("keterangan_bhp").value = '';
			document.getElementById("status_bhp").value = '0';
			document.getElementById("status_bhp").checked = false;
			document.getElementById("nama_bahan").disabled = false;
		}
		
		function hapus_bhp(act){
		var id_bhp = document.getElementById("id_bhp").value;
		var kepemilikan_id_bhp = document.getElementById("kepemilikan_id_bhp").value;
		var obat_id_bhp = document.getElementById("obat_id_bhp").value;
		var jumlah_bhp = document.getElementById("jumlah_bhp").value;
		var unit_id_bhp = getIdUnit;
		var url_bhp = "bhp_utils.php?pelayanan_id_bhp="+getIdPel+"&act="+act+"&id_bhp="+id_bhp+"&unit_id_bhp="+unit_id_bhp+"&kepemilikan_id_bhp="+kepemilikan_id_bhp+"&obat_id_bhp="+obat_id_bhp+"&jumlah_bhp="+jumlah_bhp;
			//alert(url_bhp);
			bhp.loadURL(url_bhp,"","GET");
			batal_bhp();
		}
		
		function ganti_status_bhp(val)
		{
			if(val=='0')
			{
				document.getElementById("status_bhp").value = '1';
			}
			if(val=='1')
			{
				document.getElementById("status_bhp").value = '0';
			}
		}
		
// penambahan hasil lab
	function suggestHsl(e,par){
		var keywords=par.value;//alert(keywords);
		if(keywords=="" || keywords.length<1){
			document.getElementById('divtindakanHsl').style.display='none';
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
				var tblRow=document.getElementById('tblTindakanHsl').rows.length;
				if (tblRow>0){
					//alert(RowIdx1);
					if (key==38 && RowIdx1>0){
						RowIdx1=RowIdx1-1;
						document.getElementById('lstTindHsl'+(RowIdx1+1)).className='itemtableReq';
						if (RowIdx1>0) document.getElementById('lstTindHsl'+RowIdx1).className='itemtableMOverReq';
					}
					else if (key == 40 && RowIdx1 < tblRow){
						RowIdx1=RowIdx1+1;
						if (RowIdx1>1) document.getElementById('lstTindHsl'+(RowIdx1-1)).className='itemtableReq';
						document.getElementById('lstTindHsl'+RowIdx1).className='itemtableMOverReq';
					}
				}
			}else if (key==13){
				//alert('masuk tindakan');
				if (RowIdx1>0){
					if (fKeyEnt1==false){
						fSetHsl(document.getElementById('lstTindHsl'+RowIdx1).lang);
					}
					else{
						fKeyEnt1=false;
					}
				}
			}else if (key!=27 && key!=37 && key!=39){
				RowIdx1=0;
				fKeyEnt1=false;
				var all=0;
				if(key==123){
					all=1;
				}
				//alert("tindakanlist_lab.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&pelayananId="+getIdPel+"lp="+document.getElementById('txtSex').value);
				//alert("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+((document.getElementById('chkTind').checked==true)?document.getElementById('tmpLay').value:unitId));
				var umurthn = document.getElementById("txtUmur").value;
				
				Request("tindakanlist_lab.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&pelayananId="+getIdPel+"&lp="+document.getElementById('txtSex').value+"&umur="+umurthn, 'divtindakanHsl', '', 'GET');
				if (document.getElementById('divtindakanHsl').style.display=='none')
					fSetPosisi(document.getElementById('divtindakanHsl'),par);
				document.getElementById('divtindakanHsl').style.display='block';
			}
		}
	}
	
	function fSetHsl(par){
		var cdata=par.split("|");
		document.getElementById("idNormal").value=cdata[0];
		document.getElementById("tindakan_id_hsl").value=cdata[1];
		document.getElementById("txtTind_hsl").value=cdata[2];
		document.getElementById("normal").innerHTML=cdata[3];
		document.getElementById('divtindakanHsl').style.display='none';
		
	}
	
	function cetakHslLabRad(){
		if (document.getElementById('ctkLabRadPerKonsul').value=="HASIL LAB"){
			cetakHsl();
		}else if (document.getElementById('ctkLabRadPerKonsul').value=="HASIL RAD"){
			cetakHasilRadAll();
		}
	}
	
	function RujukLabRad(){
		if (document.getElementById('cetak_rujuk').value=="RUJUK LAB"){
			cetakRujukLab();
		}else if (document.getElementById('cetak_rujuk').value=="RUJUK RAD"){
			cetakRujukRad();
		}
	}
	function cetakHsl(){
		window.open('hasil_pemeriksaan/hasil_laborat.php?idKunj='+getIdKunj+'&idPel='+getIdPel,'_blank');
	}
	
	function cetakHslPA(){
		window.open('hasil_laboratPA.php?idKunj='+getIdKunj+'&idPel='+getIdPel,'_blank');
	}

	function cetakRujukLab(){
		window.open('../report_rm/laporan_lab.php?idKunj='+getIdKunj+'&idPel='+fidRujukUnit,'_blank');
	}

	function cetakRujukRad(){
		window.open('../report_rm/laporan_rad.php?idKunj='+getIdKunj+'&idPel='+fidRujukUnit,'_blank');
	}
	
	function batalHsl(){
		var idTindHsl = document.getElementById("idTindHsl").value="";
		var tindakan_id_hsl = document.getElementById("tindakan_id_hsl").value="";
		var txtHsl = document.getElementById("txtHsl").value="";
		var txtKetHsl = document.getElementById("txtKetHsl").value="";
		var cmbDokHsl = document.getElementById("cmbDokHsl").selectedIndex="";
		var normal = document.getElementById("idNormal").value="";
		document.getElementById("normal").innerHTML="";
		document.getElementById("txtTind_hsl").value="";
		document.getElementById("btnSimpanHsl").value="Tambah";
		//document.getElementById("btnHapusHsl").style.disabled=false;
		var p= "btnHapusHsl*-*true";
		fSetValue(window,p);
	}
	
	function ambilDataHsl()
	{
		var sisip = lab.getRowId(lab.getSelRow()).split("|");
		//alert(sisip);
		batalHsl();
		document.getElementById("idTindHsl").value=sisip[0];
		document.getElementById("tindakan_id_hsl").value=sisip[3];
		document.getElementById("txtHsl").value=sisip[2];
		document.getElementById("txtKetHsl").value=sisip[7];
		document.getElementById("cmbDokHsl").value=sisip[6];
		document.getElementById("idNormal").value=sisip[4];
		document.getElementById("normal").innerHTML=sisip[5];
		document.getElementById("txtTind_hsl").value=sisip[1];
		
		var disHapus = "false";
		if(sisip[8]=='0'){
			disHapus = 'true';
		}
		//btnSimpanTind*-*Simpan*|*btnHapusTind*-*false;
		document.getElementById("btnSimpanHsl").value="Simpan";
		//document.getElementById("btnHapusHsl").style.disabled=false;
		var p= "btnHapusHsl*-*"+disHapus;
		fSetValue(window,p);
	}
	
	function showgrid2(){
		//alert('sip');
		//showgrid();
		//isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','cmbDokHsl');
	}
	
	var actTree;
	function loadtree(p,act,par)
	{		
		var a=p.split("*-*");
		//alert(a[0]+'act='+act+'&par='+par+'&gid='+document.getElementById(a[2]).value);
		if(act=='Tambah' || act=='Simpan' || act=='Hapus'){
			actTree=act;
			Request ( a[0]+'act='+act+'&par='+par+'&gid='+document.getElementById(a[2]).value+a[3]+'&cnt='+a[4] , a[1], '', 'GET',berhasil,'no');
		}
		else{			
			Request ( a[0]+'act='+act+'&par='+par+'&gid='+document.getElementById(a[2]).value+a[3]+'&cnt='+a[4] , a[1], '', 'GET');
			//isiCombo('cmbGroup','','','cmbGroup');
		}
	}
	
	function berhasil(){
		batalSetting();		
		alert(actTree+' Berhasil!');
	}
	
	function cetakHasilLabAll(){
		window.open('hasil_laborat_all.php?idKunj='+getIdKunj+'&idPel='+getIdPel,'_blank');
	}
	
	function tatib(){
		window.open('../report_rm/Form_RSU/37.tatatertib.php?idKunj='+getIdKunj+'&idPel='+getIdPel,'_blank');
	}
	function balasan(){
		window.open('../report_rm/Form_RSU/3.suratbalasan.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?=$_SESSION['userId'];?>','_blank');
	}
	
	function cetakHasilRadAll(){
		window.open('hasil_radiologi_all.php?idKunj='+getIdKunj+'&idPel='+getIdPel,'_blank');
	}
	
	function cetakAmplopRad(){
		window.open('AmpRad.php?idKunj='+getIdKunj+'&idPel='+getIdPel,'_blank');
	}
	
	function bukaCITO(){
		window.open('../report_rm/Form_RSU/formulir_permintaan_darah_form.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUsr=<?php echo $userId;?>','_blank');
	}
	
	function cetakHasilRad(){
		var sisip = rad.getRowId(rad.getSelRow()).split("|");
		window.open('hasil_radiologi.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&id_hasil_rad='+sisip[0],'_blank');
	}
	
	function cekPenyebabKecelakaan(){
		//batal('btnBatalDiag');
		var p="diagnosa_id*-**|*txtDiag*-**|*btnSimpanDiag*-*Tambah*|*btnSimpanDiag*-*false*|*btnHapusDiag*-*true";
		fSetValue(window,p);
		//document.getElementById('chkPenyebabKecelakaan').checked='';
		//document.getElementById('trPenyebab').style.display='none';
		document.getElementById('chkAkhir').checked='';
		
		if(document.getElementById('chkPenyebabKecelakaan').checked){
			//document.getElementById('trPrioritas').style.display = 'none';
			//document.getElementById('trDiagnosaAkhir').style.display = 'none';
			//document.getElementById('trPenyebab').style.display = 'table-row';
		}
		else{
			//document.getElementById('trPrioritas').style.display = 'table-row';
			//document.getElementById('trDiagnosaAkhir').style.display = 'table-row';
			document.getElementById('trPenyebab').style.display = 'none';
		}
	}
	
	function cekICD_manual(){
		document.getElementById('divdiagnosa').style.display = 'none';
		if(document.getElementById('chkICD_manual').checked){
		
		}
		else{
		
		}	
	}
	//---jokerdiag----
	function fChkBanding(obj){
	var tbl = document.getElementById('tbl_tab_diag');
	var i=obj.parentNode.parentNode.parentNode.rowIndex;
		//alert(i);
		if (i==6){
			if (obj.checked==true){
				document.getElementById('txtDiagBanding').style.display = 'table-row';
				document.getElementById('btnTambahDiagBanding').style.display = 'table-row';
			}else{
				document.getElementById('txtDiagBanding').style.display = 'none';
				document.getElementById('btnTambahDiagBanding').style.display = 'none';
			}
		}else{
			tbl.deleteRow(i);
		}
	}
	
	/*function fTambahDiagBanding(){
	var isIE = false;
	var tbl = document.getElementById('tbl_tab_diag');
	var lastRow = tbl.rows.length;
		//alert('tambah banding');
		if(navigator.userAgent.indexOf('MSIE')>0){isIE = true;}
  		var row = tbl.insertRow(lastRow-5);
		var cellLeft = row.insertCell(0);
		
		// right cell
		var cellRight = row.insertCell(1);
		var textNode = document.createTextNode("Diagnosa Banding : ");
		//cellLeft.className = 'tdisikiri';
		cellRight.appendChild(textNode);
		
		cellRight = row.insertCell(2);
		cellRight.colspan="3";
		/*cellRight.innerHTML="<label><input type=\"checkbox\" id=\"chkBanding\" name=\"chkBanding\" checked=\"checked\" onchange=\"fChkBanding(this);\" /> Ya</label>&nbsp;<input id=\"txtDiagBanding\" name=\"txtDiagBanding\" type=\"text\" size=\"48\" autocomplete=\"off\" class=\"txtinput\" style=\"display:table-row\" />";*/
		/*cellRight.innerHTML="<input id=\"txtDiagBanding\" name=\"txtDiagBanding\" type=\"text\" size=\"48\" autocomplete=\"off\" class=\"txtinput\" />";
	}*/
	
	function fTambahDiagBanding(){
	var isIE = false;
	var tbl = document.getElementById('tbl_tab_diag');
	var lastRow = tbl.rows.length;
		//alert('tambah banding');
		if(navigator.userAgent.indexOf('MSIE')>0){isIE = true;}
  		var row = tbl.insertRow(lastRow-6);
		var cellRight = row.insertCell(0);
		
		// right cell
		var cellRight = row.insertCell(1);
		var textNode = document.createTextNode("Diagnosa Banding");
		
		cellRight.appendChild(textNode);
		cellRight.align="left";
		cellRight = row.insertCell(2);
		cellRight.colspan="3";
		/*cellRight.innerHTML="<label><input type=\"checkbox\" id=\"chkBanding\" name=\"chkBanding\" checked=\"checked\" onchange=\"fChkBanding(this);\" /> Ya</label>&nbsp;<input id=\"txtDiagBanding\" name=\"txtDiagBanding\" type=\"text\" size=\"48\" autocomplete=\"off\" class=\"txtinput\" style=\"display:table-row\" />";*/
		cellRight.innerHTML=": <input id=\"idtxtDiagBanding\" name=\"idtxtDiagBanding\" type=\"hidden\" size=\"48\" autocomplete=\"off\" class=\"txtinput idtxtDiagBanding2\" /><input id=\"txtDiagBanding\" name=\"txtDiagBanding\" type=\"text\" size=\"48\" autocomplete=\"off\" class=\"txtinput txtDiagBanding2\" /><input id=\"txtDiagBandingCdgn\" name=\"txtDiagBandingCdgn\" type=\"hidden\" size=\"48\" autocomplete=\"off\" class=\"txtinput txtDiagBanding2\" /> <img width=\"16\" height=\"16\" align=\"absmiddle\" border=\"0\" onclick=\"if (confirm('Yakin Ingin Menghapus Data?')){fHapusDiagBanding(this);}\" title=\"Klik Untuk Menghapus\" class=\"proses\" src=\"../icon/del.gif\">";
	}
	
	var ket="";
	
	function fHapusDiagBanding(cRow)
	{
	  var tbl = document.getElementById('tbl_tab_diag');
	  var jmlRow = tbl.rows.length;
	  //alert(jmlRow);
		var i=cRow.parentNode.parentNode.rowIndex;
	    //alert(i);
		var y=i-6;
		var isi=document.forms['form_diag'].idtxtDiagBanding[y].value;
		jQuery("#loadHapusDiagnosa").load("updateDiagBanding.php?in=true&id="+isi+"&user_act=<?php echo $userId; ?>");
		b.loadURL("tindiag_utils.php?grd1=true&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj,"","GET");
		  tbl.deleteRow(i);
		  var lastRow = tbl.rows.length;
		  ket=1;
		  //alert(lastRow);
		  document.getElementById("btnSimpanDiag").value="Simpan";
	}
	
	function fHapusDiagBandingRst(cRow)
	{
	  var tbl = document.getElementById('tbl_tab_diag');
	  var jmlRow = tbl.rows.length;
	  //alert(jmlRow);
		var i=cRow.parentNode.parentNode.rowIndex;
	    //alert(i);
	
	  if(jmlRow==13){
		var isi=document.forms['form_diag'].elements['idtxtDiagBanding'].value;
		jQuery("#loadHapusDiagnosa").load("updateDiagBanding.php?in=true&id="+isi+"&user_act=<?php echo $userId; ?>");
		b.loadURL("tindiag_utils.php?grd1=true&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj,"","GET");
		
		document.forms['form_diag'].elements['idtxtDiagBanding'].value='';
		document.forms['form_diag'].elements['txtDiagBanding'].value='';
		document.forms['form_diag'].elements['txtDiagBandingCdgn'].value='';
	  }else{
		var cekDiagBgd = document.getElementById("TotDiagBanding").value;
			if(cekDiagBgd>1){
			//bagus
			//alert(document.forms['form_diag'].idtxtDiagBanding[0].value);
			//var isi=document.forms['form_diag'].idtxtDiagBanding[0].value;
			
			var isi=document.forms['form_diag'].idtxtDiagBanding.value;
			jQuery("#loadHapusDiagnosa").load("updateDiagBanding.php?in=true&id="+isi+"&user_act=<?php echo $userId; ?>");
			b.loadURL("tindiag_utils.php?grd1=true&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj,"","GET");
			
			//bagus
				/*document.forms['form_diag'].idtxtDiagBanding[0].value='';
				document.forms['form_diag'].txtDiagBanding[0].value='';
				document.forms['form_diag'].txtDiagBandingCdgn[0].value='';*/
			document.forms['form_diag'].idtxtDiagBanding.value='';
			document.forms['form_diag'].txtDiagBanding.value='';
			document.forms['form_diag'].txtDiagBandingCdgn.value='';
				
			}else if(cekDiagBgd==1){
			var isi=document.forms['form_diag'].elements['idtxtDiagBanding'].value;
			jQuery("#loadHapusDiagnosa").load("updateDiagBanding.php?in=true&id="+isi+"&user_act=<?php echo $userId; ?>");
			b.loadURL("tindiag_utils.php?grd1=true&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj,"","GET");
			
				document.forms['form_diag'].elements['idtxtDiagBanding'].value='';
				document.forms['form_diag'].elements['txtDiagBanding'].value='';
				document.forms['form_diag'].elements['txtDiagBandingCdgn'].value='';
			}
	  }
	  ket=1;
	}
	
	function hapus_foto_radiologi(a,b){
		if(b==1){ // 1=insert lagi
			Request('act_radiologi.php?act=delete&id='+a,'temp_rad','','GET',insertRadLagi(a),'noload');
		}
		else{
			Request('act_radiologi.php?act=delete&id='+a,'temp_rad','','GET');
		}
	}
	
	function insertRadLagi(a){
		var userId='<?php echo $_SESSION['userId']?>';
		tambahRadiologi = true;
		document.getElementById('frameRad').contentWindow.aplod('add',a,userId);
	}
	
	function afterRad(str){
		alert(str);
		document.getElementById("id_hasil_rad").value="";
		document.getElementById("txtHslRad").value="";
		document.getElementById("cmbDokHslRad").selectedIndex="";
		document.getElementById("btnSimpanHslRad").value="Tambah";
		var p= "btnHapusHslRad*-*true";
		fSetValue(window,p);
		rad.loadURL("hasilRad_utils.php?grd=true&pelayanan_id="+getIdPel,"","GET");
	}
	
	function simpan_tanpa_gambar(act){
		var userId='<?php echo $_SESSION['userId']?>';		
		var id = document.getElementById("id_hasil_rad").value;
		var txtHslRad = document.getElementById("txtHslRad").value.replace(/\r\n|\r|\n/g,"<br />");
		var cmbDokHsl = document.getElementById("cmbDokHslRad").value;
		var norm = document.getElementById("normPass").value;
		var pacsid = document.getElementById("pacsuuid").value;
     						
		rad.loadURL("hasilRad_utils.php?grd=true&smpn=btnSimpanHslRad&pelayanan_id="+getIdPel+"&act="+act+"&id="+id+"&txtHslRad="+txtHslRad+"&cmbDokHsl="+cmbDokHsl+"&userId="+userId+"&norm="+norm+"&pacsid="+pacsid,"","GET");
	}
	
	function ReportRm(no)
	{
		var noRM = document.getElementById("txtNo").value;
		var nama = document.getElementById("txtNama").value;
		var umur = document.getElementById("txtUmur").value;
		var sex = document.getElementById("txtSex").value;
		var alamat = document.getElementById("txtAlmt").value;
		var tgl = document.getElementById("txtTglLhr").value;
		var kamar = document.getElementById("txtPelUnit").value;
		//alert(getKelas_id);
		
		//var tambahan = "nama="+nama+"&umur="+umur+"&sex="+sex+"&alamat="+alamat+"&noRM="+noRM+"&tgl="+tgl+"&kamar="+kamar+"&kelas_id="+getKelas_id;
		//alert(tambahan);
		var tambahan = 'idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+"&kelas_id="+getKelas_id;
		//alert(coba);
		if(no==1)
		{
			var url = '../report_rm/1.inform_konsen.php?'+tambahan; 
		}
		else if(no==2)
		{
			var url = '../report_rm/2.APS.php?'+tambahan;
		}
		else if(no==3)
		{
			var url = '../report_rm/3.ctt_asuhan_gizi.php?'+tambahan; 
		}
		else if(no==4)
		{
			var url = '../report_rm/4.srt_kenal_lahir.php?'+tambahan; 
		}
		else if(no==5)
		{
			var url = '../report_rm/5.monitpring_ESO.php?'+tambahan; 
		}
		else if(no==6)
		{
			var url = '../report_rm/6.check_list_cath.php?'+tambahan; 
		}
		else if(no==7)
		{
			var url = '../report_rm/7.rujukan.php?'+tambahan; 
		}
		else if(no==8)
		{
			//var url = '../report_rm/8.rencana_harian.php?'+tambahan;
			var url = '../report_rm/rencana_harian_perawat/rencana_perawat.php?'+tambahan;
		}
		else if(no==9)
		{
			//var url = '../report_rm/9.check_list_pnrmn.php?'+tambahan;
			var dohkah = 1;
		}
		else if(no==10)
		{
			var url = '../report_rm/10.lap_kejadian_form.php?'+tambahan; 
		}
		else if(no==11)
		{
			var url = '../report_rm/11.pesanan_post.php?'+tambahan; 
		}
		else if(no==12)
		{
			var url = '../report_rm/12.persetujuan_transfusi.php?'+tambahan; 
		}
		else if(no==13)
		{
			var url = '../report_rm/13. checklist_pengkajian_kep.php?'+tambahan; 
		}
		else if(no==14)
		{
			var url = '../report_rm/14.resume_kep_form.php?'+tambahan; 
		}
		else if(no==15)
		{
			var url = '../report_rm/15.rekam_medis.php?'+tambahan; 
		}
		else if(no==16)
		{
			var url = '../report_rm/16.Chart_ICU.php?'+tambahan; 
		}
		else 
		{
			var url = '../report_rm/17.obs_harian_bayi.php?'+tambahan; 
		}
		if(dohkah != 1){
			window.open(url);
		} else {
			checkListTerima();
		}
	}
	
	function saveAnamnesa(aksinya){
		
	   var KUNJ_ID=getIdKunj;
	   var PEL_ID=getIdPel;
	   var PEGAWAI_ID=document.getElementById('cmbDokAnamnesa').value;
	   var KU=document.getElementById('txtKU').value;
	   var SOS=document.getElementById('txtAS').value;
	   var RPS=document.getElementById('txtRPS').value
	   var RPD=document.getElementById('txtRPD').value;
	   var RPK=document.getElementById('txtRPK').value;
	   var KUM=document.getElementById('txtKUM').value;
	   var RA=document.getElementById('txtRA').value;
	   var GCS=document.getElementById('txtGCS').value;
	   var KESADARAN=document.getElementById('cmbKesadaran').value;
	   var TENSI=document.getElementById('txtTensi').value;
	   var RR=document.getElementById('txtRR').value;
	   var NADI=document.getElementById('txtNadi').value;
	   var SUHU=document.getElementById('txtSuhu').value;
	   var TB=document.getElementById('txtTB').value;
	   var BB=document.getElementById('txtBB').value;
	   var GIZI=document.getElementById('cmbStatusGizi').value;
	   var TENSI_DIASTOLIK=document.getElementById('txtTensi1').value;
	   var LEHER=document.getElementById('txtLeher').value.replace(/\r\n|\r|\n/g,"<br />");
	   var ABDOMEN=document.getElementById('txtAbdomen').value.replace(/\r\n|\r|\n/g,"<br />");
	   var GENITALIA=document.getElementById('txtGen').value.replace(/\r\n|\r|\n/g,"<br />");
	   var THORAX=document.getElementById('txtThorax').value.replace(/\r\n|\r|\n/g,"<br />");
	   
	    var ar_cmbKepalaLeher = document.getElementById('cmbKepalaLeher').value.replace(/\r\n|\r|\n/g,"<br />");
		var ar_cmbCor = document.getElementById('cmbCor').value.replace(/\r\n|\r|\n/g,"<br />");
	   	var ar_cmbPulmo = document.getElementById('cmbPulmo').value.replace(/\r\n|\r|\n/g,"<br />");
	   	var ar_cmbInspeksi = document.getElementById('cmbInspeksi').value;
	   	var ar_cmbPalpasi = document.getElementById('cmbPalpasi').value;
	   	var ar_cmbAuskultasi = document.getElementById('cmbAuskultasi').value;
	    var ar_cmbPerkusi = document.getElementById('cmbPerkusi').value;
	    var ar_cmbEkstremitas = document.getElementById('cmbEkstremitas').value.replace(/\r\n|\r|\n/g,"<br />");
		 //alert("1");
		var txtPenunjangN = document.getElementById('txtPenunjangN').value.replace(/\r\n|\r|\n/g,"<br />");
		var txtprognososN = document.getElementById('txtprognososN').value.replace(/\r\n|\r|\n/g,"<br />");
		var sMentalis = document.getElementById('sMentalis').value.replace(/\r\n|\r|\n/g,"<br />");
		//alert("2");
		//alert(document.getElementById('cmbCor').value.replace(/\r\n|\r|\n/g,"<br />"));
		//return false;		
		var pupil=trmeningeal=ncraniales=sensorik=rPatologis=otonom=pkhusus=mkia=mkaa=mkib=mkab=rfisiokia=rfisiokaa=rfisiokib=NPS=rfisiokab="";
		
		if(document.getElementById("pup1").checked == true)
		{
			pupil = "dbm";
		}
		
		if((document.getElementById("pup2").checked == true) && (jQuery("#bentukP").val() != ""))
		{
			pupil = jQuery("#bentukP").val()+','+jQuery("#ukuranP").val()+','+jQuery("#cahayaP").val();
		}
		
		if(document.getElementById("pup3").checked == true)
		{
			trmeningeal = "dbm";
		}
		
		if((document.getElementById("pup4").checked == true) && (jQuery("#kakuP").val() != ""))
		{
			trmeningeal = "kaku,"+jQuery("#kakuP").val();
		}
		
		if((document.getElementById("pup5").checked == true) && (jQuery("#lasequeP").val() != ""))
		{
			trmeningeal = "laseque,"+jQuery("#lasequeP").val();
		}
		
		if((document.getElementById("pup6").checked == true) && (jQuery("#karningP").val() != ""))
		{
			trmeningeal = "karning,"+jQuery("#karningP").val();
		}
		
		if(document.getElementById("pup7").checked == true)
		{
			ncraniales = "Dbn";
		}
		
		if((document.getElementById("pup8").checked == true) && (jQuery("#persisP").val() != ""))
		{
			ncraniales = jQuery("#persisP").val();
		}
		
		if(document.getElementById("pup9").checked == true)
		{
			sensorik = "Dbn";
		}
		
		if((document.getElementById("pup10").checked == true)&& (jQuery("#sensorikP").val() != ""))
		{
			sensorik = jQuery("#sensorikP").val();
		}
		
		rPatologis = jQuery("#cmbPatologis").val();
		otonom = jQuery("#cmbOtonom").val();
		pkhusus = jQuery("#cmbPKhusus").val();
		
		mkia = jQuery("#mkiriatasP").val();
		mkaa = jQuery("#mkananatasP").val();
		mkib = jQuery("#mkiribawahP").val();
		mkab = jQuery("#mkananbawahP").val();
		
		rfisiokia = jQuery("#rkiriatasP").val();
		rfisiokaa = jQuery("#rkananatasP").val();
		rfisiokib = jQuery("#rkiribawahP").val();
		rfisiokab = jQuery("#rkananbawahP").val();
		
		lKepala = jQuery("#lKepala").val().replace(/\r\n|\r|\n/g,"<br />");
		sGiziI = jQuery("#sGiziI").val();
		kTelinga = jQuery("#kTelinga").val().replace(/\r\n|\r|\n/g,"<br />");
		kHidung = jQuery("#kHidung").val().replace(/\r\n|\r|\n/g,"<br />");
		kTenggorokan = jQuery("#kTenggorokan").val().replace(/\r\n|\r|\n/g,"<br />");
		
		rKelahiran = jQuery("#rKelahiran").val();
		rNutrisi = jQuery("#rNutrisi").val();
		rImunisasi = jQuery("#rImunisasi").val();
		rTumbuhKembang = jQuery("#rTumbuhKembang").val();
		
		rOAT = jQuery("#rOAT").val();
		rMerokok = jQuery("#rMerokok").val();
		rAsma = jQuery("#rAsma").val();
		
		rKU = jQuery("#rKU").val();
		rpsd = jQuery("#rpsd").val();
		rGPA = jQuery("#rGPA").val();
		
		TglAnamB  = jQuery("#TglAnamB ").val();
		jamAnamB = jQuery("#jamAnamB").val();
		
		uTinLanjut = jQuery("#uTinLanjut").val().replace(/\r\n|\r|\n/g,"<br />");
		
		NPS = jQuery("#txtNPS").val();
		var aMata = jQuery("#aMata").val().replace(/\r\n|\r|\n/g,"<br />");
		var kKelamin = jQuery("#kKelamin").val().replace(/\r\n|\r|\n/g,"<br />");
		//alert(pupil+";"+trmeningeal+";"+ncraniales+";"+sensorik+"#111w#;"+rPatologis+";"+otonom+";"+pkhusus+";"+mkia+";"+mkaa+";"+mkib+";"+mkab+";"+rfisiokia+";"+rfisiokaa+";"+rfisiokib+";"+rfisiokab);
		
		//return false;
		
		//alert(sensorik);
	   
		var url = 'tindiag_utils.php?id_anamnesa='+document.getElementById('id_anamnesa').value+'&KUNJ_ID='+KUNJ_ID+'&PEL_ID='+PEL_ID+'&PASIEN_ID='+getIdPasien+'&PEGAWAI_ID='+PEGAWAI_ID+'&KU='+encodeURIComponent(KU)+'&SOS='+encodeURIComponent(SOS)+'&RPS='+encodeURIComponent(RPS)+'&RPD='+encodeURIComponent(RPD)+'&RPK='+encodeURIComponent(RPK)+'&KUM='+encodeURIComponent(KUM)+'&RA='+encodeURIComponent(RA)+'&GCS='+encodeURIComponent(GCS)+'&KESADARAN='+encodeURIComponent(KESADARAN)+'&TENSI='+encodeURIComponent(TENSI)+'&+RR='+encodeURIComponent(RR)+'&NADI='+encodeURIComponent(NADI)+'&SUHU='+encodeURIComponent(SUHU)+'&TB='+encodeURIComponent(TB)+'&BB='+encodeURIComponent(BB)+'&GIZI='+encodeURIComponent(GIZI)+'&KL='+encodeURIComponent(ar_cmbKepalaLeher)+'&COR='+encodeURIComponent(ar_cmbCor)+'&PULMO='+encodeURIComponent(ar_cmbPulmo)+'&INSPEKSI='+encodeURIComponent(ar_cmbInspeksi)+'&PALPASI='+encodeURIComponent(ar_cmbPalpasi)+'&AUSKULTASI='+encodeURIComponent(ar_cmbAuskultasi)+'&PERKUSI='+encodeURIComponent(ar_cmbPerkusi)+'&EXT='+encodeURIComponent(ar_cmbEkstremitas)+'&THORAX='+encodeURIComponent(THORAX)+'&TglAnamB='+encodeURIComponent(TglAnamB)+'&jamAnamB='+encodeURIComponent(jamAnamB);
		
		anam.loadURL(url+'&act=data_anamnesa&action='+encodeURIComponent(aksinya)+'&grdAnamnesa=true&pasien_id='+encodeURIComponent(getIdPasien)+'&diastolik='+encodeURIComponent(TENSI_DIASTOLIK)+'&LEHER='+encodeURIComponent(LEHER)+'&ABDOMEN='+encodeURIComponent(ABDOMEN)+'&GENITALIA='+encodeURIComponent(GENITALIA)+'&pupil='+encodeURIComponent(pupil)+'&trmeningeal='+encodeURIComponent(trmeningeal)+'&ncraniales='+encodeURIComponent(ncraniales)+'&sensorik='+encodeURIComponent(sensorik)+'&rPatologis='+encodeURIComponent(rPatologis)+'&otonom='+encodeURIComponent(otonom)+'&pkhusus='+encodeURIComponent(pkhusus)+'&mkia='+encodeURIComponent(mkia)+'&mkaa='+encodeURIComponent(mkaa)+'&mkib='+encodeURIComponent(mkib)+'&mkab='+encodeURIComponent(mkab)+'&rfisiokia='+encodeURIComponent(rfisiokia)+'&rfisiokaa='+encodeURIComponent(rfisiokaa)+'&rfisiokib='+encodeURIComponent(rfisiokib)+'&rfisiokab='+encodeURIComponent(rfisiokab)+'&nps='+encodeURIComponent(NPS)+'&txtPenunjangN='+encodeURIComponent(txtPenunjangN)+'&txtprognososN='+encodeURIComponent(txtprognososN)+'&sMentalis='+encodeURIComponent(sMentalis)+'&lKepala='+encodeURIComponent(lKepala)+'&sGiziI='+encodeURIComponent(sGiziI)+'&kTelinga='+encodeURIComponent(kTelinga)+'&kHidung='+encodeURIComponent(kHidung)+'&kTenggorokan='+encodeURIComponent(kTenggorokan)+'&rKelahiran='+encodeURIComponent(rKelahiran)+'&rNutrisi='+encodeURIComponent(rNutrisi)+'&rImunisasi='+encodeURIComponent(rImunisasi)+'&rTumbuhKembang='+encodeURIComponent(rTumbuhKembang)+'&rOAT='+encodeURIComponent(rOAT)+'&rMerokok='+encodeURIComponent(rMerokok)+'&rAsma='+encodeURIComponent(rAsma)+'&rKU='+encodeURIComponent(rKU)+'&rpsd='+encodeURIComponent(rpsd)+'&rGPA='+encodeURIComponent(rGPA)+'&uTinLanjut='+encodeURIComponent(uTinLanjut)+'&aMata='+encodeURIComponent(aMata)+'&kKelamin='+encodeURIComponent(kKelamin),'','GET');
		batalAnamnesa();
	}
	
	function urldecode(str) {
  return decodeURIComponent((str + '')
    .replace(/%(?![\da-f]{2})/gi, function() {
      // PHP tolerates poorly formed escape sequences
      return '%25';
    })
    .replace(/\+/g, '%20'));
}

	
	function ambilDataAnamnesa(){
		
		//document.getElementById('btnSimpanAnamnesa').value='simpan';
		//document.getElementById('btnSimpanAnamnesa').innerHTML="<img src='../icon/save.gif' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Save</span>";
		//document.getElementById('btnDeleteAnamnesa').disabled=false;
		jQuery("#anamnesa").removeAttr("disabled");
		
		var sisip=anam.getRowId(anam.getSelRow()).split("|");
		document.getElementById('id_anamnesa').value=urldecode(sisip[0]);
		//document.getElementById('cmbDokAnamnesa').value=sisip[4];
		document.getElementById('txtKU').value=urldecode(sisip[5]);
		document.getElementById('txtAS').value=urldecode(sisip[6]);
		document.getElementById('txtRPS').value=urldecode(sisip[7]);
		document.getElementById('txtRPD').value=urldecode(sisip[8]);
		document.getElementById('txtRPK').value=urldecode(sisip[9]);
		//document.getElementById('txtRA').value=sisip[10];
		document.getElementById('txtKUM').value=urldecode(sisip[11]);
		document.getElementById('txtGCS').value=urldecode(sisip[12]);
		document.getElementById('cmbKesadaran').value=urldecode(sisip[13]);
		document.getElementById('txtTensi').value=urldecode(sisip[14]);
		document.getElementById('txtRR').value=urldecode(sisip[15]);
		document.getElementById('txtNadi').value=urldecode(sisip[16]);
		document.getElementById('txtSuhu').value=urldecode(sisip[17]);
		document.getElementById('txtBB').value=urldecode(sisip[18]);
		document.getElementById('cmbStatusGizi').value=urldecode(sisip[19]);
		document.getElementById('txtTensi1').value=urldecode(sisip[28]);
		document.getElementById('txtLeher').value=urldecode(sisip[29]).replace(/<br\s?\/?>/g,"\n");
		document.getElementById('txtAbdomen').value=urldecode(sisip[30]).replace(/<br\s?\/?>/g,"\n");
		document.getElementById('txtGen').value=urldecode(sisip[31]).replace(/<br\s?\/?>/g,"\n");
		document.getElementById('txtTB').value=urldecode(sisip[32]);
		document.getElementById('txtThorax').value=urldecode(sisip[33]).replace(/<br\s?\/?>/g,"\n");
		document.getElementById('cmbKepalaLeher').value=urldecode(sisip[20]).replace(/<br\s?\/?>/g,"\n");
		document.getElementById('cmbCor').value=urldecode(sisip[21]).replace(/<br\s?\/?>/g,"\n");
		document.getElementById('cmbPulmo').value=urldecode(sisip[22]).replace(/<br\s?\/?>/g,"\n");
		document.getElementById('cmbInspeksi').value=urldecode(sisip[23]);
		document.getElementById('cmbAuskultasi').value=urldecode(sisip[25]);
		document.getElementById('cmbPalpasi').value=urldecode(sisip[24]);
		document.getElementById('cmbPerkusi').value=urldecode(sisip[26]);
		document.getElementById('cmbEkstremitas').value=urldecode(sisip[27]).replace(/<br\s?\/?>/g,"\n");
		
		if(sisip[34]=="dbm")
		{
			document.getElementById('pup1').checked = true;
		}else if((sisip[34] != "dbm") && (sisip[34] != ""))
		{
			document.getElementById('pup2').checked = true;
			var data1 = urldecode(sisip[34].split(","));
			document.getElementById('bentukP').value = data1[0];
			document.getElementById('ukuranP').value = data1[1];
			document.getElementById('cahayaP').value = data1[2];
		}
		
		if(sisip[35]=="dbm")
		{
			document.getElementById('pup3').checked = true;
		}else if((sisip[35] != "dbm") && (sisip[35] != ""))
		{
			var data2 = urldecode(sisip[35].split(","));
			if(data2[0] == "kaku")
			{
				document.getElementById('pup4').checked = true;
				document.getElementById('kakuP').value = data2[1];
			}else if(data2[0] == "laseque")
			{
				document.getElementById('pup5').checked = true;
				document.getElementById('lasequeP').value = data2[1];
			}else if(data2[0] == "karning")
			{
				document.getElementById('pup6').checked = true;
				document.getElementById('karningP').value = data2[1];
			}
		}
		
		if(sisip[36]=="Dbn")
		{
			document.getElementById('pup7').checked = true;
		}else if((sisip[36] != "Dbn") && (sisip[36] != ""))
		{
			document.getElementById('pup8').checked = true;
			document.getElementById('persisP').value = urldecode(sisip[36]);
		}
		
		document.getElementById('cmbPatologis').value = urldecode(sisip[37]);
		
		if(sisip[38]=="Dbn")
		{
			document.getElementById('pup9').checked = true;
		}else if((sisip[38] != "Dbn") && (sisip[38] != ""))
		{
			document.getElementById('pup10').checked = true;
			document.getElementById('sensorikP').value = urldecode(sisip[38]);
		}
		
		document.getElementById('cmbOtonom').value = urldecode(sisip[39]);
		document.getElementById('cmbPKhusus').value = urldecode(sisip[40]);
		
		document.getElementById('mkiriatasP').value = urldecode(sisip[41]);
		document.getElementById('mkananatasP').value = urldecode(sisip[42]);

		document.getElementById('mkiribawahP').value = urldecode(sisip[43]);
		document.getElementById('mkananbawahP').value = urldecode(sisip[44]);
		
		document.getElementById('rkiriatasP').value = urldecode(sisip[45]);
		document.getElementById('rkananatasP').value = urldecode(sisip[46]);
		document.getElementById('rkiribawahP').value = urldecode(sisip[47]);
		document.getElementById('rkananbawahP').value = urldecode(sisip[48]);
		
		document.getElementById('txtNPS').value = urldecode(sisip[49]);
		
		document.getElementById('txtPenunjangN').value = urldecode(sisip[50]).replace(/<br\s?\/?>/g,"\n");
		document.getElementById('txtprognososN').value = urldecode(sisip[51]).replace(/<br\s?\/?>/g,"\n");
		document.getElementById('sMentalis').value = urldecode(sisip[52]).replace(/<br\s?\/?>/g,"\n");
		
		document.getElementById('lKepala').value = urldecode(sisip[53]).replace(/<br\s?\/?>/g,"\n");
		jQuery("#sGiziI").val(urldecode(sisip[54]));
		document.getElementById('kTelinga').value = urldecode(sisip[55]).replace(/<br\s?\/?>/g,"\n");
		document.getElementById('kHidung').value = urldecode(sisip[56]).replace(/<br\s?\/?>/g,"\n");
		document.getElementById('kTenggorokan').value = urldecode(sisip[57]).replace(/<br\s?\/?>/g,"\n");
		
		document.getElementById('rKelahiran').value = urldecode(sisip[58]);
		document.getElementById('rNutrisi').value = urldecode(sisip[59]);
		document.getElementById('rImunisasi').value = urldecode(sisip[60]);
		document.getElementById('rTumbuhKembang').value = urldecode(sisip[61]);
		
		document.getElementById('rOAT').value = urldecode(sisip[62]);
		document.getElementById('rMerokok').value = urldecode(sisip[63]);
		document.getElementById('rAsma').value = urldecode(sisip[64]);
		
		document.getElementById('rKU').value = urldecode(sisip[65]);
		document.getElementById('rpsd').value = urldecode(sisip[66]);
		document.getElementById('rGPA').value = urldecode(sisip[67]);
		document.getElementById('uTinLanjut').value = urldecode(sisip[68]).replace(/<br\s?\/?>/g,"\n");
		document.getElementById('aMata').value = urldecode(sisip[69]).replace(/<br\s?\/?>/g,"\n");
		document.getElementById('kKelamin').value = urldecode(sisip[70]).replace(/<br\s?\/?>/g,"\n");
		
		//alert(sisip[34]);
	}
	
	function ambilDataAnamnesa1(){
		
		//document.getElementById('btnSimpanAnamnesa').value='simpan';
		//document.getElementById('btnSimpanAnamnesa').innerHTML="<img src='../icon/save.gif' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Save</span>";
		//document.getElementById('btnDeleteAnamnesa').disabled=false;
		jQuery("#anamnesa").removeAttr("disabled");
		sanam = 1;

		var sisip=anam1.getRowId(anam1.getSelRow()).split("|");
		document.getElementById('id_anamnesa').value=sisip[0];
		//document.getElementById('cmbDokAnamnesa').value=sisip[4];
		document.getElementById('txtKU').value=sisip[5];
		document.getElementById('txtAS').value=sisip[6];
		document.getElementById('txtRPS').value=sisip[7];
		document.getElementById('txtRPD').value=sisip[8];
		document.getElementById('txtRPK').value=sisip[9];
		//document.getElementById('txtRA').value=sisip[10];
		document.getElementById('txtKUM').value=sisip[11];
		document.getElementById('txtGCS').value=sisip[12];
		document.getElementById('cmbKesadaran').value=sisip[13];
		document.getElementById('txtTensi').value=sisip[14];
		document.getElementById('txtRR').value=sisip[15];
		document.getElementById('txtNadi').value=sisip[16];
		document.getElementById('txtSuhu').value=sisip[17];
		document.getElementById('txtBB').value=sisip[18];
		document.getElementById('cmbStatusGizi').value=sisip[19];
		document.getElementById('txtTensi1').value=sisip[28];
		document.getElementById('txtLeher').value=sisip[29];
		document.getElementById('txtAbdomen').value=sisip[30];
		document.getElementById('txtGen').value=sisip[31];
		document.getElementById('txtTB').value=sisip[32];
		document.getElementById('txtThorax').value=sisip[33];
		document.getElementById('cmbKepalaLeher').value=sisip[20];
		document.getElementById('cmbCor').value=sisip[21];
		document.getElementById('cmbPulmo').value=sisip[22];
		document.getElementById('cmbInspeksi').value=sisip[23];
		document.getElementById('cmbAuskultasi').value=sisip[25];
		document.getElementById('cmbPalpasi').value=sisip[24];
		document.getElementById('cmbPerkusi').value=sisip[26];
		document.getElementById('cmbEkstremitas').value=sisip[27];
	}
	
	function deleteAnamnesa(){
		if(confirm('Apakah anda yakin?')){
			anam.loadURL('tindiag_utils.php?act=data_anamnesa&action=hapus&grdAnamnesa=true&pasien_id='+getIdPasien+'&id_anamnesa='+document.getElementById('id_anamnesa').value,'','GET');
			batalAnamnesa();
		}		
	}

	function batalAnamnesa(){
		sanam = 0;
		document.getElementById('btnDeleteAnamnesa').disabled=true;
		document.getElementById('btnSimpanAnamnesa').value='tambah';
		document.getElementById('btnSimpanAnamnesa').innerHTML="<img src='../icon/edit_add.png' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Add</span>";		
		document.getElementById('id_anamnesa').value = "";
		document.getElementById('cmbDokAnamnesa').value =  "";
		document.getElementById('txtKU').value = "";
		document.getElementById('txtAS').value = "";
		document.getElementById('txtRPS').value = "";
		document.getElementById('txtRPD').value = "";
		document.getElementById('txtRPK').value = "";
		document.getElementById('txtKUM').value = "";
		//document.getElementById('txtRA').value = "";
		document.getElementById('txtGCS').value = "";
		document.getElementById('cmbKesadaran').value = "";
		document.getElementById('txtTensi').value = "";
		document.getElementById('txtRR').value = "";
		document.getElementById('txtNadi').value = "";
		document.getElementById('txtSuhu').value = "";
		document.getElementById('txtTB').value = "";
		document.getElementById('txtBB').value = "";
		document.getElementById('txtLeher').value = "";
		document.getElementById('txtGen').value = "";
		document.getElementById('txtAbdomen').value = "";
		document.getElementById('txtTensi1').value = "";
		document.getElementById('cmbStatusGizi').value = "";
		document.getElementById('cmbKepalaLeher').value = "";
		document.getElementById('cmbCor').value = "";
		document.getElementById('cmbPulmo').value = "";
		document.getElementById('cmbInspeksi').value = "";
		document.getElementById('cmbAuskultasi').value = "";
		document.getElementById('cmbPalpasi').value = "";
		document.getElementById('cmbPerkusi').value = "";
		document.getElementById('cmbEkstremitas').value = "";
		document.getElementById('txtThorax').value = "";
		//jQuery("#anamnesa").attr("disabled","disabled");
		document.getElementById('bentukP').value = "";
		document.getElementById('ukuranP').value = "";
		document.getElementById('cahayaP').value = "";
		document.getElementById('kakuP').value = "";
		document.getElementById('lasequeP').value = "";
		document.getElementById('karningP').value = "";
		document.getElementById('persisP').value = "";
		document.getElementById('cmbPatologis').value = "";
		document.getElementById('cmbOtonom').value = "";
		document.getElementById('sensorikP').value = "";
		document.getElementById('cmbPKhusus').value = "";
		document.getElementById('mkiriatasP').value = "";
		document.getElementById('mkananatasP').value = "";
		document.getElementById('mkiribawahP').value = "";
		document.getElementById('mkananbawahP').value = "";
		document.getElementById('rkiriatasP').value = "";
		document.getElementById('rkananatasP').value = "";
		document.getElementById('rkiribawahP').value = "";
		document.getElementById('rkananbawahP').value = "";
		document.getElementById('txtNPS').value = "";
		
		document.getElementById('txtPenunjangN').value = "";
		document.getElementById('txtprognososN').value = "";
		document.getElementById('sMentalis').value = "";
		
		document.getElementById('lKepala').value = "";
		jQuery("#sGiziI").val("");
		document.getElementById('kTelinga').value ="";
		document.getElementById('kHidung').value = "";
		document.getElementById('kTenggorokan').value = "";
		
		document.getElementById('rKelahiran').value = "";
		document.getElementById('rNutrisi').value = "";
		document.getElementById('rImunisasi').value = "";
		document.getElementById('rTumbuhKembang').value = "";
		
		document.getElementById('rOAT').value = "";
		document.getElementById('rMerokok').value = "";
		document.getElementById('rAsma').value = "";
		
		document.getElementById('rKU').value = "";
		document.getElementById('rpsd').value = "";
		document.getElementById('rGPA').value = "";
		document.getElementById('aMata').value = "";
		document.getElementById('kKelamin').value = "";
		document.getElementById('uTinLanjut').value = "";
		
		document.getElementById('pup1').checked = false;
		document.getElementById('pup2').checked = false;
		document.getElementById('pup3').checked = false;
		document.getElementById('pup4').checked = false;
		document.getElementById('pup5').checked = false;
		document.getElementById('pup6').checked = false;
		document.getElementById('pup7').checked = false;
		document.getElementById('pup8').checked = false;
		document.getElementById('pup9').checked = false;
		document.getElementById('pup10').checked = false;
	}
	
	function cetak_resume()
	{
		var id_anamnesia1 = anam.getRowId(anam.getSelRow()).split("|");
		//var id_anamnesia1 = jQuery("#id_anamnesa").val();
		window.open('resumemedis.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPasien='+getIdPasien+'&id_anamnesa='+id_anamnesia1[0]+'&userId=<?php echo $userId; ?>','_blank');
	}
	
	function cetak_resume2()
	{
		var id_anamnesia1 = anam1.getRowId(anam1.getSelRow()).split("|");
		//var id_anamnesia1 = jQuery("#id_anamnesa").val();
		window.open('resumemedis.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPasien='+getIdPasien+'&id_anamnesa='+id_anamnesia1[0]+'&userId=<?php echo $userId; ?>','_blank');
	}
	
	function opnBls(){
		window.open("../report_rm/Form_RSU/3.suratbalasan.php?idPel="+getIdPel,"_blank");
		}
		
	function detailRA(){
		gRA.loadURL('riwayat_alergi_util.php?idpasien='+getIdPasien,'','GET');
		new Popup('divRiwayatAlergi',null,{modal:true,position:'center',duration:1});
    	document.getElementById('divRiwayatAlergi').popup.show();	
	}
	
	function closeRA(){
		Request('riwayat_alergi_util.php?act=view_last&idpasien='+getIdPasien,'hsl_RA_terakhir','','GET',loadRATerakhir,'noLoad');
		document.getElementById('divRiwayatAlergi').popup.hide();
	}
	
	function batalRA(){
		document.getElementById('txtRiwayatAlergi').value='';
		document.getElementById('id_riwayat_alergi').value='';
		document.getElementById('btnSimpanRA').value='tambah';
		document.getElementById('btnSimpanRA').innerHTML="<img src='../icon/edit_add.png' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Add</span>";
		document.getElementById('btnDeleteRA').disabled=true;	
	}
	
	function ambilRA(){
		var sisip=gRA.getRowId(gRA.getSelRow()).split("|");
		document.getElementById('txtRiwayatAlergi').value=sisip[1];
		document.getElementById('id_riwayat_alergi').value=sisip[0];
		document.getElementById('btnSimpanRA').value='simpan';
		document.getElementById('btnSimpanRA').innerHTML="<img src='../icon/save.gif' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Save</span>";
		document.getElementById('btnDeleteRA').disabled=false;	
	}
	
	function deleteRA(){
		var	id_riwayat_alergi=document.getElementById('id_riwayat_alergi').value;
		gRA.loadURL('riwayat_alergi_util.php?act=hapus&idpasien='+getIdPasien+'&id_riwayat_alergi='+id_riwayat_alergi,'','GET');
		batalRA();	
	}
	
	function saveRA(act){
		var txtRiwayatAlergi=document.getElementById('txtRiwayatAlergi').value;
		var	id_riwayat_alergi=document.getElementById('id_riwayat_alergi').value;
		gRA.loadURL('riwayat_alergi_util.php?act='+act+'&idpasien='+getIdPasien+'&txtRiwayatAlergi='+txtRiwayatAlergi+'&id_riwayat_alergi='+id_riwayat_alergi+'&userId=<?php echo $userId; ?>','','GET');
		batalRA();
	}
	
	//---------- S MASTER CARA KELUAR
	function detailCK(){
		gCK.loadURL('cara_keluar_util.php','','GET');
		new Popup('divCaraKeluar',null,{modal:true,position:'center',duration:1});
    	document.getElementById('divCaraKeluar').popup.show();	
	}
	
	function closeCK(){
		isiCombo('cmbCaraKeluar','','','cmbCaraKeluar',gantiCaraKeluar);
		document.getElementById('divCaraKeluar').popup.hide();
	}
	
	function batalCK(){
		document.getElementById('status').checked=false;
		document.getElementById('txtCaraKeluar').value='';
		document.getElementById('id_cara_keluar').value='';
		document.getElementById('btnSimpanCK').value='tambah';
		document.getElementById('btnSimpanCK').innerHTML="<img src='../icon/edit_add.png' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Add</span>";
		document.getElementById('btnDeleteCK').disabled=true;	
	}
	
	function ambilCK(){
		var sisip=gCK.getRowId(gCK.getSelRow()).split("|");
		var cek = sisip[2];
		if(cek==1){document.getElementById('status').checked=true;}
		else{document.getElementById('status').checked=false;}
		document.getElementById('txtCaraKeluar').value=sisip[1];
		document.getElementById('id_cara_keluar').value=sisip[0];
		document.getElementById('btnSimpanCK').value='simpan';
		document.getElementById('btnSimpanCK').innerHTML="<img src='../icon/save.gif' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Save</span>";
		document.getElementById('btnDeleteCK').disabled=false;	
	}
	
	function deleteCK(){
		var	id_cara_keluar=document.getElementById('id_cara_keluar').value;
		gCK.loadURL('cara_keluar_util.php?act=hapus&id_cara_keluar='+id_cara_keluar,'','GET');
		batalCK();	
	}
	//var status;
	function saveCK(act){
		if(document.getElementById('status').checked==true){
		status=1}else{status=0;};
		var txtCaraKeluar=document.getElementById('txtCaraKeluar').value;
		var	id_cara_keluar=document.getElementById('id_cara_keluar').value;
		gCK.loadURL('cara_keluar_util.php?act='+act+'&txtCaraKeluar='+txtCaraKeluar+'&id_cara_keluar='+id_cara_keluar+'&status='+status,'','GET');
		batalCK();
	}
	
	//---------- S MASTER CARA KELUAR
	
	//---------- S MASTER KEADAAN KELUAR------------------------
	function detailKK(){
		gKK.loadURL('keadaan_keluar_util.php?cara='+document.getElementById("cara_keluar").value,'','GET');
		new Popup('divKeadaanKeluar',null,{modal:true,position:'center',duration:1});
    	document.getElementById('divKeadaanKeluar').popup.show();	
	}
	function ganti111(){
		//gKK.loadURL('keadaan_keluar_util.php','','GET');
		gKK.loadURL('keadaan_keluar_util.php?cara='+document.getElementById("cara_keluar").value,'','GET');	
	}
	function closeKK(){
		//isiCombo('cmbKeadaanKeluar','','','cmbKeadaanKeluar',gantiKeadaanKeluar);
		caraKeluar(document.getElementById('cmbCaraKeluar').value);
		document.getElementById('divKeadaanKeluar').popup.hide();
	}
	
	function batalKK(){
		document.getElementById('status_keadaan').checked=false;
		document.getElementById('txtKeadaanKeluar').value='';
		document.getElementById('id_keadaan_keluar').value='';
		document.getElementById('btnSimpanKK').value='tambah';
		document.getElementById('btnSimpanKK').innerHTML="<img src='../icon/edit_add.png' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Add</span>";
		document.getElementById('btnDeleteKK').disabled=true;	
	}
	
	function ambilKK(){
		var sisip=gKK.getRowId(gKK.getSelRow()).split("|");
		var cek = sisip[3];
		if(cek==1){document.getElementById('status_keadaan').checked=true;}
		else{document.getElementById('status_keadaan').checked=false;}
		document.getElementById('txtKeadaanKeluar').value=sisip[2];
		document.getElementById('cara_keluar').value=sisip[1];
		document.getElementById('id_keadaan_keluar').value=sisip[0];
		document.getElementById('btnSimpanKK').value='simpan';
		document.getElementById('btnSimpanKK').innerHTML="<img src='../icon/save.gif' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Save</span>";
		document.getElementById('btnDeleteKK').disabled=false;	
	}
	
	function deleteKK(){
		var id_keadaan_keluar=document.getElementById('id_keadaan_keluar').value;
		gKK.loadURL('keadaan_keluar_util.php?act=hapus&id_keadaan_keluar='+id_keadaan_keluar+'&cara='+document.getElementById("cara_keluar").value,'','GET');
		batalKK();	
	}
	
	function saveKK(act){
		if(document.getElementById('status_keadaan').checked==true){
		status_keadaan=1}else{status_keadaan=0;};
		var txtKeadaanKeluar=document.getElementById('txtKeadaanKeluar').value;
		var cara_keluar=document.getElementById('cara_keluar').value;
		var id_keadaan_keluar=document.getElementById('id_keadaan_keluar').value;
		gKK.loadURL('keadaan_keluar_util.php?act='+act+'&cara_keluar='+cara_keluar+'&txtKeadaanKeluar='+txtKeadaanKeluar+'&id_keadaan_keluar='+id_keadaan_keluar+'&status_keadaan='+status_keadaan+'&cara='+document.getElementById("cara_keluar").value,'','GET');
		batalKK();
	}
	
	//---------- S MASTER KEADAAN KELUAR-----------------------
	
	/*edited ridl00*/
	function detailPF(tip,fil){
		document.getElementById('tipe_fisik').value=tip;
		document.getElementById('filter_fisik').value=fil;
		var tipex=document.getElementById('tipe_fisik').value;
		gPF.loadURL('pemeriksaan_fisik_util.php?tipex='+tipex,'','GET');
		new Popup('divPemeriksaanFisik',null,{modal:true,position:'center',duration:1});
    	document.getElementById('divPemeriksaanFisik').popup.show();	
	}
	
	function closePF(){
		document.getElementById('divPemeriksaanFisik').popup.hide();
		loadCmb(document.getElementById('filter_fisik').value,document.getElementById('tipe_fisik').value);
	}
	
	function batalPF(){
		document.getElementById('txt_nama_fisik').value='';
		document.getElementById('txt_urut_fisik').value='';
		document.getElementById('id_periksa_fisik').value='';
		document.getElementById('btnSimpanPF').value='tambah';
		document.getElementById('btnSimpanPF').innerHTML="<img src='../icon/edit_add.png' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Add</span>";
		document.getElementById('btnDeletePF').disabled=true;	
	}
	
	function ambilPF(){
		var sisip=gPF.getRowId(gPF.getSelRow()).split("|");
		document.getElementById('txt_nama_fisik').value=sisip[2];
		document.getElementById('txt_urut_fisik').value=sisip[1];
		document.getElementById('id_periksa_fisik').value=sisip[0];
		document.getElementById('btnSimpanPF').value='simpan';
		document.getElementById('btnSimpanPF').innerHTML="<img src='../icon/save.gif' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Save</span>";
		document.getElementById('btnDeletePF').disabled=false;	
	}
	
	function deletePF(){
		var tipex=document.getElementById('tipe_fisik').value;
		var id_periksa_fisik=document.getElementById('id_periksa_fisik').value;
		gPF.loadURL('pemeriksaan_fisik_util.php?act=hapus&tipex='+tipex+'&id_periksa_fisik='+id_periksa_fisik,'','GET');
		batalPF();	
	}
	
	function savePF(act){
		var txt_urut_fisik=document.getElementById('txt_urut_fisik').value;
		var txt_nama_fisik=document.getElementById('txt_nama_fisik').value;
		var id_periksa_fisik=document.getElementById('id_periksa_fisik').value;
		var tipex=document.getElementById('tipe_fisik').value;
		gPF.loadURL('pemeriksaan_fisik_util.php?act='+act+'&tipex='+tipex+'&txt_nama_fisik='+txt_nama_fisik+'&txt_urut_fisik='+txt_urut_fisik+'&id_periksa_fisik='+id_periksa_fisik+'&userId=<?php echo $userId; ?>','','GET');
		batalPF();
	}
	
	function loadCmb(fil,tip){
		jQuery("#"+fil).html('');
		jQuery("#hsl_cmb_PF").load("isi_combo.php?cmb=anamnesa&filter="+fil+"&tipex="+encodeURIComponent(tip),function(){
		anamnesa_kepala_leher.multiselect('refresh');
		anamnesa_cor.multiselect('refresh');
		anamnesa_pulmo.multiselect('refresh');
		anamnesa_inspeksi.multiselect('refresh');
		anamnesa_auskultasi.multiselect('refresh');
		anamnesa_palpasi.multiselect('refresh');
		anamnesa_perkusi.multiselect('refresh');
		anamnesa_ekstremitas.multiselect('refresh');
			
			});
		
	}
	/*edited ridl00*/
	
	function loadRATerakhir(){
		document.getElementById('txtRA').innerHTML = document.getElementById('hsl_RA_terakhir').innerHTML;	
	}
	
	function btnCetakLapKRS(){
		var x=document.getElementById('cmbCetakKRS').value;
		if(x=='MRS') window.open('spinap.php?idPel='+getIdPel+'&idKunj='+getIdKunj+'&idUser=<?php echo $userId;?>');
		else if(x=='Meninggal') cetak_mati();
		else if(x=='Atas Ijin Dokter') checkList();
		else if(x=='APS') ReportRm(2);
		else if(x=='Dirujuk') ReportRm(7);
	}
	
	function gantiDosis(c){
		if(c.checked){
			document.getElementById('spnKetDosis').innerHTML='<input id="txtDosis" name="txtDosis" size="30" class="txtinput">';
			document.getElementById('txtDosis').focus();
		}
		else{
			document.getElementById('spnKetDosis').innerHTML='<select id="txtDosis" name="txtDosis" class="txtinput"><?php 
															$sql="SELECT * FROM $dbapotek.a_dosis WHERE aktif=1";
															$rs=mysql_query($sql);
															while ($rw=mysql_fetch_array($rs)){
															?><option value="<?php echo $rw['nama']; ?>"><?php echo $rw['nama']; ?></option><?php 
															}
															?></select>';
		}
	}
	
	jQuery(function(){
		jQuery("#txtTensi, #txtNadi, #txtBB, #txtRR, #txtSuhu").keydown(function(e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if ( jQuery.inArray(e.keyCode,[46,8,9,27,13,190]) !== -1 ||
				 // Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) || 
				 // Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			} else {
				// Ensure that it is a number and stop the keypress
				if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105 )) {
					e.preventDefault(); 
				}   
			}
		});
	});
	
	function gantiNoTelp(){
		var notelp = prompt('Masukkan nomor telepon ?',document.getElementById('txtNoTelp').value);
		if(notelp!=null){
			//( vUrl , vTarget, vForm, vMethod,evl,noload)
			Request('pelayanankunjungan_utils.php?act=setNoTelp&idpasien='+getIdPasien+'&txttelp='+notelp,'spnNoTelp','','GET',function(){
				if(document.getElementById('spnNoTelp').innerHTML=='ok'){
					//alert(notelp);
					document.getElementById('txtNoTelp').value=notelp;	
				}
			});
		}
	}
	
	function amplopradio(){
		var amploprad = document.getElementById("cmbJnsLay").value;
		if(amploprad!=60){
			//document.getElementById("ctkAmpRad").disabled=true;
			document.getElementById("ctkAmpRad").style.display='none';
		}else{
			//document.getElementById("ctkAmpRad").disabled=false;
			document.getElementById("ctkAmpRad").style.display='inline';
		}
	}
	
	function fungsikosong(){
		return false;
	}
	
	function cekKonsul(){
		var tglK1 = document.getElementById("txtTglK").value;
		var tglK2 = tglK1.split('-');
		//var today = new Date(tglK2[2]+"-"+tglK2[1]+"-"+tglK2[0]);
		today = new Date(tglK2[2], tglK2[1] - 1, tglK2[0]-1);
		today.setDate(today.getDate()+1);
		var today1 = new Date();
		//alert(today+"\n"+today1);
		if(today>today1)
		{
			alert("Tidak bisa konsul maju... Pasien harus di kunjungkan ulang.");
			document.getElementById("txtTglK").value = "<? echo $date_now;?>";
		}
		
		return false;
		
	}
	
	function batalkrsan(){
	var p = "idRujukUnit*-**|*btnSimpanRujukRS*-*Tambah*|*chkManualKrs*-*false*|*btnSimpanRujukRS*-*false*|*btnHapusRujukRS*-*true";
	fSetValue(window,p);
	document.getElementById('txtKetRujuk').value = '';
	isiCombo('cmbCaraKeluar','','','cmbCaraKeluar',gantiCaraKeluar);
	document.getElementById('cmbKasus').value = '1';
	document.getElementById('TglKrs').value = '<?php echo date('d-m-Y')?>';
	document.getElementById('JamKrs').value = '<?php echo date('H:i')?>';
	}
	
	function hslexpertise(){
		if(document.getElementById('cmbJnsLay').value==60){
			document.getElementById('trExprt').style.visibility='visible';
			document.getElementById('trExprt_pacs').style.visibility='visible';
		}else{
			document.getElementById('trExprt').style.visibility='collapse';
			document.getElementById('trExprt_pacs').style.visibility='collapse';
		}	
	}
	</script>
    <script language="JavaScript1.2">mmLoadMenus();</script>
</html>

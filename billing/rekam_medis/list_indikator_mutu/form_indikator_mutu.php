<?php
	include("../../koneksi/konek.php");
	$kelas_id = $_REQUEST["kelas_id"];
	$idKunj=$_REQUEST['idKunj'];
	$jeniskasir=$_REQUEST['jenisKasir'];
	$idPel=$_REQUEST['idPel'];
	$inap=$_REQUEST['inap'];
	$all = $_REQUEST['all'];
	$idUser=$_REQUEST['idUsr'];
	
	$sql = "select * from b_form_indikatormutu where pelayanan_id = '$idPel' AND kunjungan_id = '$idKunj'";
	$query = mysql_num_rows(mysql_query($sql));
	$update = 0;
	$act = "Save";
	
	if($query > 0){
		$update = 1;
		$act = "Update";
		$isi = mysql_fetch_array(mysql_query($sql));
		$ugdlengkap = explode("||",$isi['ugd']);
		$subugd = explode(",",$ugdlengkap[1]);
		
		$obatjalan = explode("||",$isi['obatjalan']);
		$subobat = explode(',',$obatjalan[1]);
		
		$dokterrawat = explode("||",$isi['dokterrawat']);
		$subdokter = explode(',',$dokterrawat[1]);
		
		$tirahbaring = explode("||",$isi['tirahbaring']);
		
		$dekubitus = explode("||",$isi['dekubitus']);
		$subdeku = explode(",",$dekubitus[2]);
		$lastdeku = explode('_',$subdeku[5]);
		
		$transfusi = explode("||",$isi['transfusi']);
		
		$icu = explode("||",$isi['icu']);
		
		$operasi = explode("||",$isi['operasi']);
		$subope1 = explode("_",$operasi[1]);
		
		$subope2 = explode("&",$operasi[2]);
		$subope21 = explode(",",$subope2[1]);
		$lastsub21 = explode("_",$subope21[2]);
		
		$subope3 = explode("&",$operasi[3]);
		$subope31 = explode("-",$subope3[1]);
		
		$apendik = explode('||',$isi['apendik']);
		$subapendik = explode('_',$apendik[1]);
	}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Form Prosedur Pembedahan</title>
		<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
		<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
		<script type="text/JavaScript" language="JavaScript" src="../iframe.js"></script>
		<style type="text/css">
			#indikatormutu table{
				border-collapse:collapse;
				padding:10px;
			}
			#indikatormutu table label{
				display:inline-block;
				padding-left:10px;
			}
			#indikatormutu td.inputan:hover{
				background:#ececec;
			}
			#indikatormutu td.top{
				vertical-align:top;
			}
			#indikatormutu table td{
				padding:3px;
			}
			#indikatormutu input[type="text"]{
				width:100%;
				height:23px;
				padding-left:3px;
			}
			#indikatormutu input[type="text"]:disabled{
				border:1px solid #808080;
				background:#ececec;
			}
		</style>
		<script type="text/JavaScript" language="JavaScript" src="indikator_mutu.js?v=1"></script>
	</head>
	<body>
		<center>
        <div align="center">
		<b>CHECK LIST INDIKATOR MUTU</b>
		<form action="action_indikator.php" method="POST" id="indikatormutu" name="indikatormutu">
			<input type="hidden" id="idKunjMutu" name="idKunjMutu" value="<?=$idKunj?>"/>
			<input type="hidden" id="idPelMutu" name="idPelMutu" value="<?=$idPel?>"/>
			<input type="hidden" id="idUserMutu" name="idUserMutu" value="<?=$idUser?>"/>
			<input type="hidden" id="idMutu" name="idMutu" value="<?=$isi['mutu_id']?>"/>
			<input type="hidden" id="actMutu" name="actMutu" value="<?=$act?>"/>
			<table cellspacing="2" cellpadding="2" style="border:1px solid #000000;">
				<tr>
					<td width="5px" class="top">1.</td>
					<td width="300px" class="top">Apakah pemeriksaan di UGD lengkap? (anamnesa / pemeriksaan diagnostik, sesuai klinis pasien )</td>
					<td width="100px" class="inputan">
						<input type="radio" id="ugdlengkap1" name="ugdlengkap" onClick="document.getElementById('hcekugdleng').style.display = 'none'; document.getElementById('hcekugdleng1').style.display = 'none';" value="1" <?=($ugdlengkap[0]=='1')?"checked":"";
						?> /><label for="ugdlengkap1">Ya</label>
					</td>
					<td class="inputan">
						<input type="radio" id="ugdlengkap2" name="ugdlengkap"
						onclick="document.getElementById('hcekugdleng').style.display = 'table-row'; document.getElementById('hcekugdleng1').style.display = 'table-row';"
						value="0" <?=($ugdlengkap[0]== '0')?'checked':'';?> /><label for="ugdlengkap2">Tidak</label>
					</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr id="hcekugdleng" style="display:<?=($ugdlengkap[0] == '0')?'table-row':'none';?>;">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan="2" rowspan="2" class="top">Bila tidak lengkap yaitu......</td>
					<td class="inputan"><input type="checkbox" id="cekugdleng1" name="cekugdleng[1]" value="1" <?=($subugd[0]==1)?"checked":"";
					?>/><label for="cekugdleng1">Anamnesa</label></td>
					<td class="inputan"><input type="checkbox" id="cekugdleng2" name="cekugdleng[2]" value="1" <?=($subugd[1]==1)?"checked":"";
					?>/><label for="cekugdleng2">Laboratorium</label></td>
					<td></td>
					<td></td>
				</tr>
				<tr id="hcekugdleng1" style="display:<?=($ugdlengkap[0] == '0')?'table-row':'none';?>;">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td class="inputan"><input type="checkbox" id="cekugdleng3" name="cekugdleng[3]" value="1" <?=($subugd[2]==1)?"checked":"";
					?>/><label for="cekugdleng3">Radiologi</label></td>
					<td class="inputan"><input type="checkbox" id="cekugdleng4" name="cekugdleng[4]" value="1" <?=($subugd[3]==1)?"checked":"";
					?>/><label for="cekugdleng4">EKG</label></td>
					<td class="inputan"><input type="checkbox" id="cekugdleng5" name="cekugdleng[5]" value="1" <?=($subugd[4]==1)?"checked":"";
					?>/><label for="cekugdleng5">dll</label></td>
					<td></td>
				</tr>
				<tr>
					<td width="5px" class="top" rowspan="2">2.</td>
					<td width="300px" rowspan="2" class="top">Apakah pasien sebelumnya pernah berobat jalan di RS Pelindo I kurang dari 3 hari yang lalu?</td>
					<td class="inputan"><input type="radio" id="obatjalan1" name="obatjalan" onClick="document.getElementById('hobatjalan').style.visibility = '';" value="1"
					<?=($obatjalan[0]=='1')?'checked':'';?>
					/><label for="obatjalan1">Ya</label></td>
					<td class="inputan"><input type="radio" id="obatjalan2" name="obatjalan" value="0" onClick="document.getElementById('hobatjalan').style.visibility = 'hidden';"
					<?=($obatjalan[0]=='0')?'checked':'';?> 
					/><label for="obatjalan2">Tidak</label></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr id="hobatjalan" style="visibility:<?=($obatjalan[0] == '1')?'visible':'hidden';?>;">
					<td colspan="2" class="top">Bila jawaban ya, di</td>
					<td class="inputan"><input type="checkbox" id="cekOjalan1" name="cekOjalan[1]" value="1"
					<?=($subobat[0]=='1')?'checked':'';?>
					/><label for="cekOjalan1">UGD</label></td>
					<td class="inputan"><input type="checkbox" id="cekOjalan2" name="cekOjalan[2]" value="1"
					<?=($subobat[1]=='1')?'checked':'';?> 
					/><label for="cekOjalan2">Poliklinik</label></td>
					<td></td>
				</tr>
				<tr>
					<td width="5px" class="top">3.</td>
					<td width="300px" class="top">Apakah dokter yang merawat dihubungi kurang dari 30 menit sejak pasien masuk unit rawat inap?</td>
					<td class="inputan"><input type="radio" id="dokterrawat1" name="dokterrawat" value="1" onClick="document.getElementById('hdokterrawat').style.display = 'none'; document.getElementById('hdokterrawat1').style.display = 'none';" 
					<?=($dokterrawat[0] == '1')?'checked':'';?> 
					/><label for="dokterrawat1">Ya</label></td>
					<td class="inputan"><input type="radio" id="dokterrawat2" name="dokterrawat" value="0" onClick="document.getElementById('hdokterrawat').style.display = 'table-row'; document.getElementById('hdokterrawat1').style.display = 'table-row';" 
					<?=($dokterrawat[0] == '0')?'checked':'';?> 
					/><label for="dokterrawat2">Tidak</label></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr id="hdokterrawat" style="display:<?=($dokterrawat[0] == '0')?'table-row':'none';?>;">
					<td></td>
					<td></td>
					<td colspan="2" class="top" rowspan="2">Kapan dokter datang sejak dihubungi</td>
					<td class="inputan"><input type="checkbox" id="cekdokraw1" name="cekdokraw[1]" value="1" 
					<?=($subdokter[0] == '1')?'checked':'';?> 
					/><label for="cekdokraw1">0-30 menit</label></td>
					<td class="inputan"><input type="checkbox" id="cekdokraw2" name="cekdokraw[2]" value="1" 
					<?=($subdokter[1] == '1')?'checked':'';?> 
					/><label for="cekdokraw2">31-60 menit</label></td>
					<td class="inputan"><input type="checkbox" id="cekdokraw3" name="cekdokraw[3]" value="1" 
					<?=($subdokter[2] == '1')?'checked':'';?> 
					/><label for="cekdokraw3">61-90 menit</label></td>
					<td></td>
				</tr>
				<tr id="hdokterrawat1" style="display:<?=($dokterrawat[0] == '0')?'table-row':'none';?>;">
					<td></td>
					<td></td>
					<td class="inputan"><input type="checkbox" id="cekdokraw4" name="cekdokraw[4]" value="1" 
					<?=($subdokter[3] == '1')?'checked':'';?> 
					/><label for="cekdokraw4">91-120 menit</label></td>
					<td class="inputan"><input type="checkbox" id="cekdokraw5" name="cekdokraw[5]" value="1" 
					<?=($subdokter[4] == '1')?'checked':'';?> 
					/><label for="cekdokraw5">>120 menit</label></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td width="5px" class="top" rowspan="2">4.</td>
					<td width="300px" rowspan="2" class="top">Apakah karena keadaan umumnya pasien tirah baring?</td>
					<td class="inputan"><input type="radio" id="tirahbaring1" name="tirahbaring" value="1" onClick="document.getElementById('htirahbaring').style.visibility = '';" 
					<?=($tirahbaring[0] == '1')?'checked':'';?> 
					/><label for="tirahbaring1">Ya</label></td>
					<td class="inputan"><input type="radio" id="tirahbaring2" name="tirahbaring" value="0" onClick="document.getElementById('htirahbaring').style.visibility = 'hidden';" 
					<?=($tirahbaring[0] == '0')?'checked':'';?> 
					/><label for="tirahbaring2">Tidak</label></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr id="htirahbaring" style="visibility:<?=($tirahbaring[0] == '1')?'visible':'hidden';?>;">
					<td colspan="2" class="top" >Bila jawaban ya, sebutkan penyebab/diagnosa : </td>
					<td colspan="3" class="inputan"><input type="text" name="tirah" id="tirah" value="<?=$tirahbaring[1];?> "/></td>
				</tr>
				<tr>
					<td width="5px" class="top" >5.</td>
					<td width="300px" class="top">Apakah pasien terdapat luka dekubitus?</td>
					<td class="inputan"><input type="radio" id="lukadeku1" name="lukadeku" value="1" onClick="luka(1);" 
					<?=($dekubitus[0] == '1')?"checked":'';?> 
					/><label for="lukadeku1">Ya</label></td>
					<td class="inputan"><input type="radio" id="lukadeku2" name="lukadeku" value="0" onClick="luka(0);" 
					<?=($dekubitus[0] == '0')?"checked":'';?>  
					/><label for="lukadeku2">Tidak</label></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr id="hlukadeku" style="display:<?=($dekubitus[0] == '1')?"table-row":'none';?>;">
					<td></td>
					<td></td>
					<td colspan="2" class="top">Bila Jawaban Ya, Terjadi di</td>
					<td class="inputan"><input type="radio" id="dekubi1" name="dekubi" value="1" 
					<?=($dekubitus[1] == '1')?"checked":'';?> 
					/><label for="dekubi1">RS</label></td>
					<td class="inputan"><input type="radio" id="dekubi2" name="dekubi" value="0" 
					<?=($dekubitus[1] == '0')?"checked":'';?> 
					/><label for="dekubi2">Luar RS</label></td>
					<td></td>
				</tr>
				<tr id="hlukadeku1" style="display:<?=($dekubitus[0] == '1')?"table-row":'none';?>;">
					<td></td>
					<td></td>
					<td colspan="2" class="top">Lokasi (Bila Jawaban Ya)</td>
					<td class="inputan"><input type="checkbox" id="dekubitus1" name="dekubitus[1]" value="1" 
					<?=($subdeku[0] == '1')?"checked":'';?> 
					/><label for="dekubitus1">Bokong</label></td>
					<td class="inputan"><input type="checkbox" id="dekubitus2" name="dekubitus[2]" value="1" <?=($subdeku[1] == '1')?"checked":'';?> /><label for="dekubitus2">Punggung</label></td>
					<td class="inputan"><input type="checkbox" id="dekubitus3" name="dekubitus[3]" value="1" <?=($subdeku[2] == '1')?"checked":'';?> /><label for="dekubitus3">Siku</label></td>
				</tr>
				<tr id="hlukadeku2" style="display:<?=($dekubitus[0] == '1')?"table-row":'none';?>;">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="inputan"><input type="checkbox" id="dekubitus4" name="dekubitus[4]" value="1" <?=($subdeku[3] == '1')?"checked":'';?> /><label for="dekubitus4">Mata Kaki</label></td>
					<td class="inputan"><input type="checkbox" id="dekubitus5" name="dekubitus[5]" value="1" <?=($subdeku[4] == '1')?"checked":'';?> /><label for="dekubitus5">Tumit</label></td>
					<td></td>
				</tr>
				<tr id="hlukadeku3" style="display:<?=($dekubitus[0] == '1')?"table-row":'none';?>;">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="inputan"><input type="checkbox" id="dekubitus6" onClick="
					if(document.getElementById('dekubitus6').checked == true){
						document.getElementById('laindeku').disabled = false;
					} else {
						document.getElementById('laindeku').disabled = true;
					}
					" name="dekubitus[6]" value="1" <?=($lastdeku[0] == '1')?"checked":'';?> /><label for="dekubitus6">Lain-Lain</label></td>
					<td colspan="2" class="inputan"><input type="text" disabled id="laindeku" name="laindeku" value="<?=($lastdeku[0] == '1')?$lastdeku[1]:'';?>"/></td>
				</tr>
				<tr>
					<td width="5px" class="top">6.</td>
					<td width="300px" class="top">Apakah pasien dilakukan transfusi?</td>
					<td class="inputan"><input type="radio" id="tranfus1" name="tranfus" value="1" onClick="document.getElementById('htranfus').style.display='table-row'" <?=($transfusi[0] == '1')?"checked":'';?> /><label for="tranfus1">Ya</label></td>
					<td class="inputan"><input type="radio" id="tranfus2" name="tranfus" value="0" onClick="document.getElementById('htranfus').style.display='none'; document.getElementById('htranfusi').style.display='none';
						document.getElementById('htranfusi1').style.display='none';
						document.getElementById('htranfusi2').style.display='none';" <?=($transfusi[0] == '0')?"checked":'';?> /><label for="tranfus2">Tidak</label></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr id="htranfus" style="display:<?=($transfusi[0] == '1')?"table-row":'none';?>;">
					<td></td>
					<td></td>
					<td colspan="2" class="top">Bila Ya, Adakah reaksi post transfusi?</td>
					<td class="inputan"><input type="radio" id="tranfusi1" name="tranfusi" value="1"
						onclick="document.getElementById('htranfusi').style.display='table-row';
						document.getElementById('htranfusi1').style.display='table-row';
						document.getElementById('htranfusi2').style.display='table-row';" 
						<?=($transfusi[1] == '1')?"checked":'';?>
						/><label for="tranfusi1">Ya</label></td>
					<td class="inputan"><input type="radio" id="tranfusi2" name="tranfusi" value="0"
						onclick="document.getElementById('htranfusi').style.display='none';
						document.getElementById('htranfusi1').style.display='none';
						document.getElementById('htranfusi2').style.display='none';" 
					<?=($transfusi[1] == '0')?"checked":'';?> 
					/><label for="tranfusi2">Tidak</label></td>
					<td></td>
				</tr>
				<tr id="htranfusi" style="display:<?=($transfusi[1] == '1')?"table-row":'none';?>;">
					<td></td>
					<td></td>
					<td colspan="2" class="top">Bila Ya, Berupa:</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr id="htranfusi1" style="display:<?=($transfusi[1] == '1')?"table-row":'none';?>;">
					<td></td>
					<td></td>
					<td colspan="3" class="inputan"><input type="radio" id="transfusi1" name="transfusi" value="1" <?=($transfusi[2] == '1')?"checked":'';?> /><label for="transfusi1">Penyulit karena golongan darah tidak cocok</label></td>
					<td></td>
					<td></td>
				</tr>
				<tr id="htranfusi2" style="display:<?=($transfusi[1] == '1')?"table-row":'none';?>;">
					<td></td>
					<td></td>
					<td colspan="3" class="inputan"><input type="radio" id="transfusi2" name="transfusi" value="0" <?=($transfusi[2] == '0')?"checked":'';?> /><label for="transfusi2">Terjadi infeksi nosokomial</label></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td width="5px" class="top" rowspan="2">7.</td>
					<td width="300px" rowspan="2" class="top">Apakah pasien pindah ke ICU/ICCU setelah dirawat diruangan kurang dari 2 jam?</td>
					<td class="inputan"><input type="radio" id="ICU1" name="ICU" value="1" onClick="document.getElementById('hicu').style.visibility='';" <?=($icu[0] == '1')?"checked":'';?> /><label for="ICU1">Ya</label></td>
					<td class="inputan"><input type="radio" id="ICU2" name="ICU" value="0" onClick="document.getElementById('hicu').style.visibility='hidden';" <?=($icu[0] == '0')?"checked":'';?> /><label for="ICU2">Tidak</label></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr id="hicu" style="visibility:<?=($icu[0] == '1')?"visible":'hidden';?>;">
					<td colspan="2" class="top">Bila ya, masuk rawat melalui:</td>
					<td class="inputan"><input type="radio" id="ICCU1" name="ICCU" value="1" <?=($icu[1] == '1')?"checked":'';?> /><label for="ICCU1">UGD</label></td>
					<td class="inputan"><input type="radio" id="ICCU2" name="ICCU" value="0" <?=($icu[1] == '0')?"checked":'';?> /><label for="ICCU2">Praktek Dokter</label></td>
				</tr>
				<tr>
					<td width="5px" class="top">8.</td>
					<td width="300px" class="top">Apakah pasien dilakukan operasi elektif?</td>
					<td class="inputan"><input type="radio" id="ope1" name="ope" onClick="
						document.getElementById('hope').style.display = 'table-row';
						document.getElementById('hope1').style.display = 'table-row';
						document.getElementById('hope2').style.display = 'table-row';
						document.getElementById('hope3').style.display = 'table-row';
						document.getElementById('hope4').style.display = 'table-row';
						document.getElementById('hope5').style.display = 'table-row';
					" value="1" <?=($operasi[0] == '1')?"checked":'';?> /><label for="ope1">Ya</label></td>
					<td class="inputan"><input type="radio" id="ope2" name="ope" onClick="
						document.getElementById('hope').style.display = 'none';
						document.getElementById('hope1').style.display = 'none';
						document.getElementById('hope2').style.display = 'none';
						document.getElementById('hope3').style.display = 'none';
						document.getElementById('hope4').style.display = 'none';
						document.getElementById('hope5').style.display = 'none';
						document.getElementById('hpasca').style.display = 'none';
						document.getElementById('hpasca1').style.display = 'none';
						document.getElementById('hpasca2').style.display = 'none';
						document.getElementById('htinoper').style.display = 'none';
						document.getElementById('htinoper1').style.display = 'none';
					" value="0" <?=($operasi[0] == '0')?"checked":'';?> /><label for="ope2">Tidak</label></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="display:<?=($operasi[0] == '1')?"table-row":'none';?>;" id="hope">
					<td></td>
					<td></td>
					<td colspan="4" class="top" width="100px">Apakah terjadi infeksi luka operasi bersih pada operasi elektif?</td>
				</tr>
				<tr style="display:<?=($operasi[0] == '1')?"table-row":'none';?>;" id="hope1">
					<td></td>
					<td></td>
					<td class="inputan" colspan="4"><input type="radio" id="opera1" name="opera" value="1" 
					<?=($subope1[0] == '1')?"checked":'';?> onClick=" document.getElementById('iopera').disabled = false;" /><label for="opera1">Ya, Jenis Operasi : </label> <input type="text" <?=($subope1[0] == '1')?'':'disabled';?> style="display:inline; width:56%;" id="iopera" name="iopera" value="<?=($subope1[0] == '1')?$subope1[1]:'';?>"/></td>
				</tr>
				<tr style="display:<?=($operasi[0] == '1')?"table-row":'none';?>;" id="hope2">
					<td></td>
					<td></td>
					<td colspan="4" class="inputan"><input type="radio" id="opera2" name="opera" value="0" onClick=" document.getElementById('iopera').disabled = true;" 
					<?=($subope1[0] == '0')?"checked":'';?>
					/><label for="opera2">Tidak</label></td>
				</tr>
				<tr style="display:<?=($operasi[0] == '1')?"table-row":'none';?>;" id="hope3">
					<td></td>
					<td></td>
					<td colspan="4" class="top" width="80px">Apakah terjadi komplikasi pasca operasi elektif (diluar infeksi nosokomial)?</td>
				</tr>
				<tr style="display:<?=($operasi[0] == '1')?"table-row":'none';?>;" id="hope4">
					<td></td>
					<td></td>
					<td class="inputan"><input type="radio" id="pasca1" name="pasca" onClick="
						document.getElementById('hpasca').style.display = 'table-row';
						document.getElementById('hpasca1').style.display = 'table-row';
						document.getElementById('hpasca2').style.display = 'table-row';
					" value="1" <?=($subope2[0] == '1')?"checked":'';?> /><label for="pasca1">Ya</label></td>
					<td class="inputan"><input type="radio" id="pasca2" name="pasca" onClick="
						document.getElementById('hpasca').style.display = 'none';
						document.getElementById('hpasca1').style.display = 'none';
						document.getElementById('hpasca2').style.display = 'none';
					" value="0" <?=($subope2[0] == '0')?"checked":'';?> /><label for="pasca2">Tidak</label></td>
				</tr>
				<tr style="display:<?=($subope2[0] == '1')?"table-row":'none';?>;" id="hpasca">
					<td></td>
					<td></td>
					<td colspan="2" class="top" >Bila jawaban ya:</td>
				</tr>
				<tr style="display:<?=($subope2[0] == '1')?"table-row":'none';?>;" id="hpasca1">
					<td></td>
					<td></td>
					<td class="inputan" colspan="2" style="background:#ececec;"><input type="checkbox" id="pascaopera1" name="pascaopera[1]" value="1" <?=($subope21[0] == '1')?"checked":'';?> /><label for="pascaopera1">Sistem Sirkulasi Darah</label></td>
					<td class="inputan" colspan="2" style="background:#ececec;"><input type="checkbox" id="pascaopera2" name="pascaopera[2]" value="1" <?=($subope21[1] == '1')?"checked":'';?> /><label for="pascaopera2">Sistem Pernafasan</label></td>
				</tr>
				<tr style="display:<?=($subope2[0] == '1')?"table-row":'none';?>;" id="hpasca2">
					<td></td>
					<td></td>
					<td class="inputan" colspan="4" style="background:#ececec;"><input type="checkbox" id="pascaopera3" name="pascaopera[3]" value="1" <?=($lastsub21[0] == '1')?"checked":'';?> onClick="
					if(document.getElementById('pascaopera3').checked == true){
						document.getElementById('Lpascaopera').disabled = false;
					} else {
						document.getElementById('Lpascaopera').disabled = true;
					}" /><label for="pascaopera3">Lain-Lain : &nbsp;</label><input type="text" disabled id="Lpascaopera" name="Lpascaopera" style="width:25%;" value="<?=($lastsub21[0] == '1')?$lastsub21[1]:'';?>" /></td>
				</tr>
				<tr style="display:<?=($operasi[0] == '1')?"table-row":'none';?>;" id="hope5">
					<td></td>
					<td></td>
					<td colspan="2" class="top" width="100px"> 	Apakah tindakan operasi elektif dilakukan setelah masa tunggu > 24 jam?</td>
					<td class="inputan"><input type="radio" id="tinoper1" name="tinoper" onClick="
						document.getElementById('htinoper').style.display = 'table-row';
						document.getElementById('htinoper1').style.display = 'table-row';
					" value="1" <?=($subope3[0] == '1')?"checked":'';?> /><label for="tinoper1">Ya</label></td>
					<td class="inputan"><input type="radio" id="tinoper2" name="tinoper" onClick="
						document.getElementById('htinoper').style.display = 'none';
						document.getElementById('htinoper1').style.display = 'none';
					" value="0" <?=($subope3[0] == '0')?"checked":'';?> /><label for="tinoper2">Tidak</label></td>
				</tr>
				<tr style="display:<?=($subope3[0] == '1')?"table-row":'none';?>;" id="htinoper">
					<td></td>
					<td></td>
					<td colspan="4" class="top" style="background:#ececec;">Bila Jawaban Ya : <input type="text" name="Ltinnoper" id="Ltinnoper" style="width:45%;" value="<?=$subope31[0]?>" /></td>
				</tr>
				<tr style="display:<?=($subope3[0] == '1')?"table-row":'none';?>;" id="htinoper1">
					<td></td>
					<td></td>
					<td colspan="4" class="top" style="background:#ececec;">Jenis Operasi : <input type="text" name="jenisope" id="jenisope" style="width:45%;" value="<?=$subope31[1]?>"/></td>
				</tr>
				<tr>
					<td width="5px" class="top">9.</td>
					<td width="300px" class="top">Apakah pasien dilakukan operasi apendiktomi?</td>
					<td class="inputan"><input type="radio" id="apendik1" name="apendik" onClick="
					document.getElementById('hapendik').style.display = 'table-row';
					document.getElementById('hapendik1').style.display = 'table-row';
					document.getElementById('hapendik2').style.display = 'table-row';
					" value="1" <?=($apendik[0]=='1')?'checked':'';?> /><label for="apendik1">Ya</label></td>
					<td class="inputan"><input type="radio" id="apendik2" name="apendik" onClick="
					
					document.getElementById('hapendik').style.display = 'none';
					document.getElementById('hapendik1').style.display = 'none';
					document.getElementById('hapendik2').style.display = 'none';
					
					if(document.getElementById('IYapendik').value != ''){
						document.getElementById('Yapendik1').checked = true;
					} else {
						document.getElementById('Yapendik1').checked = false;
					}
					if(document.getElementById('ITapendik').value != ''){
						document.getElementById('Yapendik2').checked = true;
					} else {
						document.getElementById('Yapendik2').checked = false;
					}" value="0" <?=($apendik[0]=='0')?'checked':'';?> /><label for="apendik2">Tidak</label></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="display:<?=($apendik[0]=='1')?'table-row':'none';?>;" id="hapendik">
					<td></td>
					<td></td>
					<td colspan="2" class="top">Bila jawaban ya, apakah dilakukan pemeriksaan PA?</td>
				</tr>
				<tr style="display:<?=($apendik[0]=='1')?'table-row':'none';?>;" id="hapendik1">
					<td></td>
					<td></td>
					<td class="inputan" colspan="4"><input type="radio" id="Yapendik1" name="Yapendik" value="1" <?=($subapendik[0]=='1')?'checked':'';?> onClick="document.getElementById('IYapendik').disabled = false; document.getElementById('ITapendik').disabled = true;" /><label for="Yapendik1">Ya, Hasil : </label> <input type="text" name="IYapendik" id="IYapendik" style="width:45%" value="<?=($subapendik[0]=='1')?$subapendik[1]:'';?>" <?=($subapendik[0]=='1')?'':'disabled';?> /></td>
				</tr>
				<tr style="display:<?=($apendik[0]=='1')?'table-row':'none';?>;" id="hapendik2">
					<td></td>
					<td></td>
					<td class="inputan" colspan="4"><input type="radio" id="Yapendik2" name="Yapendik" value="0" <?=($subapendik[0]=='0')?'checked':'';?> onClick="document.getElementById('IYapendik').disabled = true; document.getElementById('ITapendik').disabled = false;"/><label for="Yapendik2">Tidak, Alasan : </label> <input type="text" name="ITapendik" id="ITapendik" style="width:45%" value="<?=($subapendik[0]=='0')?$subapendik[1]:'';?>" <?=($subapendik[0]=='0')?'':'disabled';?>/></td>
				</tr>
			</table>
			<div style="clear:both;"></div>
			<center style="margin-top:5px;">
				<?php
                    if($_REQUEST['report']!=1){
					?><input type="button" value="<?=$act?>" name="simpanmutu" id="simpanmutu" onClick="prosesIndikatorMutu();" /><?php }?>
				<input type="button" value="Cetak" id="cetakIM" name="cetakIM" onClick="cetakIMutu()"/>
			</center>
		</form>
        </div>
		</center>
<?php if($_REQUEST['report']==1){?>
<script> 
	jQuery('#ugdlengkap1').attr("disabled", "true");
	jQuery('#ugdlengkap2').attr("disabled", "true");
	jQuery('#obatjalan1').attr("disabled", "true");
	jQuery('#obatjalan2').attr("disabled", "true");
	jQuery('#dokterrawat1').attr("disabled", "true");
	jQuery('#dokterrawat2').attr("disabled", "true");
	jQuery('#tirahbaring1').attr("disabled", "true");
	jQuery('#tirahbaring2').attr("disabled", "true");
	jQuery('#lukadeku1').attr("disabled", "true");
	jQuery('#lukadeku2').attr("disabled", "true");
	jQuery('#tranfus1').attr("disabled", "true");
	jQuery('#tranfus2').attr("disabled", "true");
	jQuery('#ICU1').attr("disabled", "true");
	jQuery('#ICU2').attr("disabled", "true");
	jQuery('#ope1').attr("disabled", "true");
	jQuery('#ope2').attr("disabled", "true");
	jQuery('#apendik1').attr("disabled", "true");
	jQuery('#apendik2').attr("disabled", "true");
</script>
<?php }?>
	</body>
</html>
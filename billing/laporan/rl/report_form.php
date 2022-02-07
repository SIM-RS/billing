<?php
//include("../../sesi.php");
?>
<?php 
	include_once("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
    $date_skr=explode('-',$date_now);
?>
<script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>

<div id="popup_div1" class="popup" style="width:500px;display:none;">
    <div style="float:right; cursor:pointer" class="popup_closebox" onclick="tutupW()">
        <img src="../../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
		<br>
    <form id="form1" name="form1" action="kunjungan_pasien.php" method="post" target="_blank">
	<input id="user_act" name="user_act" type="hidden" value="<?php echo $_SESSION['userId']?>" />
		<fieldset>
			<legend>Kriteria Laporan</legend>
				<table width="450" align="center">
					<tr id="rwPilih">
						<td colspan="2" align="center"><select id="cmbWaktu" name="cmbWaktu" class="txtinput" onchange="setBln(this.value)">
						<option></option>
						<option value="Harian">Harian</option>
						<option value="Bulanan">Bulanan</option>
						<option value="Rentang Waktu">Rentang Waktu</option>
						</select></td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<div id="trHarian" style="display:none">
								<input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAwal2" name="tglAwal2" readonly="readonly"/>&nbsp;<input type="button" class="btninput" id="btnTglAwal" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAwal2'),depRange,ubah);" />
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
						<div id="trBulan" style="display:none">
						<select class="txtinput" id="cmbBln" name="cmbBln" onchange="bulanan()"><option></option></select>&nbsp;<select class="txtinput" id="cmbThn" name="cmbThn" onchange="bulanan()"><option></option></select>
						</div>
						</td>
					</tr>
					<tr>
					  <td colspan="2" align="center">
					  <div id="trPeriode" style="display:none">
					  Periode : <input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAwal" name="tglAwal" readonly="readonly"/>&nbsp;<input type="button" class="btninput" id="btnTglAwal" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAwal'),depRange);" />&nbsp;s.d.&nbsp;<input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAkhir" name="tglAkhir" />&nbsp;
						<input type="button" class="btninput" id="btnTglAkhir" name="btnTgl2" value=" V " onclick="gfPop.fPopCalendar(document.getElementById('tglAkhir'),depRange);" />
						</div>
						</td>
					</tr>
					<tr id="trTri">
						<td align="right">Tribulan</td>
						<td>&nbsp;<select name="cmbTri" id="cmbTri" class="txtinput">
							<option value="1">Tribulan I [Jan-Mar]</option>
							<option value="2">Tribulan II [Apr-Jun]</option>
							<option value="3">Tribulan III [Jul-Sept]</option>
							<option value="4">Tribulan IV [Okt-Dec]</option>
						</select>&nbsp;<select id="cmbThnTri" name="cmbThnTri" class="txtinput">
						<?php 
							$thSkr=$date_skr[2];
							$thAwal=$thSkr*1-5;
							$thAkhir=$thSkr*1+6;
							for($thAwal;$thAwal<$thAkhir;$thAwal++){
							
						?>
						<option value="<?php echo $thAwal?>" <?php if($thSkr==$thAwal) echo 'selected';?>><?php echo $thAwal?></option>
						<?php } ?></select></td>
					</tr>
                    <tr id="trTahun">
						<td align="right">Tahun</td>
						<td>&nbsp;<select id="cmbTahun" name="cmbTahun" class="txtinput">
						<?php
							$thSkr=$date_skr[2];
							$thAwal=$thSkr*1-5;
							$thAkhir=$thSkr*1+6;
							for($thAwal;$thAwal<$thAkhir;$thAwal++){			
						?>
						<option value="<?php echo $thAwal?>" <?php if($thSkr==$thAwal) echo 'selected';?>><?php echo $thAwal?></option>
						<?php } ?></select></td>
					</tr>
					<tr id="trJns">
						<td width="40%" align="right">Jenis Layanan</td>
						<td width="60%">&nbsp;<select name="JnsLayanan" id="JnsLayanan" tabindex="26" class="txtinput" onchange="change()"></select></td>
					</tr>
                    <tr id="trJns15">
						<td width="40%" align="right">Jenis Layanan</td>
						<td width="60%">&nbsp;<select name="JnsLayanan15" id="JnsLayanan15" tabindex="26" class="txtinput" onchange="change15()"></select></td>
					</tr>
					<!--tr id="rwJnsLay3">
						<td width="40%" align="right">Jenis Layanan</td>
						<td width="60%">&nbsp;<select name="JnsLayanan3" id="JnsLayanan3" tabindex="26" class="txtinput" onchange="isiCombo('TmpLayanan',this.value)"></select></td>
					</tr-->
					<!--tr id="rwJnsLayJln">
						<td width="40%" align="right">Jenis Layanan</td>
						<td width="60%">&nbsp;<select name="JnsLayananJln" id="JnsLayananJln" tabindex="26" class="txtinput" onchange="isiCombo('TmpLayanan',this.value)"></select></td>
					</tr-->
                    <tr id="trTmp15">
						<td width="40%" height="25" align="right">Tempat Layanan</td>
					  	<td width="60%">&nbsp;<select name="TmpLayanan15" id="TmpLayanan15" tabindex="27" class="txtinput"></select></td>
					</tr>
					<tr id="trTmp">
						<td width="40%" height="25" align="right">Tempat Layanan</td>
					  	<td width="60%">&nbsp;<select name="TmpLayanan" id="TmpLayanan" tabindex="27" class="txtinput"></select></td>
					</tr>
					<tr id="trTmpPsi">
						<td align="right">Tempat Layanan</td>
						<td>&nbsp;<select id="TmpLayananPsi" name="TmpLayananPsi" class="txtinput"></select>
					</tr>
					<tr id="trTmpJln">
						<td align="right">Tempat Layanan</td>
						<td>&nbsp;<select name="TmpLayananBukanInap" id="TmpLayananBukanInap" tabindex="27" class="txtinput"></select></td>
					</tr>
					<tr id="trJenis">
						<td align="right">Jenis Layanan</td>
						<td>&nbsp;<select id="cmbJenisLayanan" name="cmbJenisLayanan" class="txtinput" onchange="change()">
							<option value="0">RAWAT JALAN</option>
							<option value="1">RAWAT INAP</option>
						</select>
					</tr>
                    <tr id="trJenisM">
						<td align="right">Jenis Layanan</td>
						<td>&nbsp;<select id="cmbJenisLayananM" name="cmbJenisLayananM" class="txtinput" onchange="changeM()">
							<option value="1">RAWAT JALAN</option>
							<option value="3">RAWAT INAP</option>
                            <option value="2">RAWAT DARURAT</option>
						</select>
					</tr>
                    <tr id="trTempatM">
						<td align="right">Tempat Layanan</td>
						<td>&nbsp;<select id="cmbTempatLayananM" name="cmbTempatLayananM" class="txtinput"></select>
					</tr>
					<tr id="trTempat">
						<td align="right">Tempat Layanan</td>
						<td>&nbsp;<select id="cmbTempatLayanan" name="cmbTempatLayanan" class="txtinput"></select>
					</tr>
					<tr id="trPenunjang">
						<td align="right">Jenis Layanan</td>
						<td>&nbsp;<select name="cmbJnsPenunjang" id="cmbJnsPenunjang" class="txtinput" onchange="change()"></select></td>
					</tr>
					<tr id="tdPenunjang">
						<td align="right">Tempat Layanan</td>
						<td>&nbsp;<select id="cmbTmpPenunjang" name="cmbTmpPenunjang" class="txtinput"></select></td>
					</tr>
					<tr id="jnsInap">
						<td align="right">Jenis Layanan</td>
						<td>&nbsp;<select id="JnsLayananInapSaja" name="JnsLayananInapSaja" class="txtinput" onchange="change()"></select>						
					</tr>
					<tr id="tmpInap">
						<td align="right">Tempat Layanan</td>
						<td>&nbsp;<select id="TmpLayananInapSaja" name="TmpLayananInapSaja" class="txtinput"></select>
					</tr>
                    <tr id="trJnsInap">
						<td align="right">Jenis Layanan</td>
						<td>&nbsp;<select id="cmbJnsInap" name="cmbJnsInap" class="txtinput">
                        <option value="3">RAWAT INAP</option>
                        </select>						
					</tr>
					<tr id="trTmpInap">
						<td align="right">Tempat Layanan</td>
						<td>&nbsp;<select id="cmbTmpInap" name="cmbTmpInap" class="txtinput"></select>
					</tr>
					<tr id="rjri">
						<td align="right">Asal Kunjungan</td>
						<td>&nbsp;<select id="cmbAsal" name="cmbAsal" class="txtinput" onchange="keUnit()">
							<option value="0">RAWAT JALAN</option>
							<option value="1">RAWAT INAP</option>
						</select></td>
					</tr>
					<tr id="trLb">
						<td align="right">Unit</td>
						<td>&nbsp;<select id="cmbUnit" name="cmbUnit" class="txtinput">
							<option value="0">SEMUA</option>
							<option value="1">POLI</option>
							<option value="2">LAIN-LAIN</option>
						</select>
						</td>
					</tr>
					<tr id="stsKunj">
						<td align="right">Status Kunjungan</td>
						<td>&nbsp;<select id="cmbKunj" name="cmbKunj" class="txtinput">
							<option value="0">LAMA</option>
							<option value="1">BARU</option>
							<option value="2">PINDAHAN</option>
						</select></td>
					</tr>
					<tr id="stsKunj2">
						<td align="right">Status Kunjungan</td>
						<td>&nbsp;<select id="cmbKunj2" name="cmbKunj2" class="txtinput"  onchange="caraKeluar(this.options[this.options.selectedIndex].lang)">
							<!-- ASLI 
								<option value="0" lang="PULANG">PULANG</option>
								<option value="1" lang="MENINGGAL">MENINGGAL</option>
								<option value="2" lang="DIPINDAHKAN">DIPINDAHKAN</option>
							-->
						<?php 
							$sStatus = "SELECT id, nama 
										FROM (SELECT 
												nama AS id, nama, IF(nama = 'APS', CONCAT('z', nama), nama) temp 
												FROM
												b_ms_cara_keluar 
												WHERE aktif = 1) AS tbl 
										ORDER BY temp";
							$qStatus = mysql_query($sStatus);
							while($rStatus = mysql_fetch_array($qStatus)){
						?>
							<option value="<?=$rStatus['nama']?>" lang="<?php echo strtoupper($rStatus['nama']);?>">
								<?php echo strtoupper($rStatus['nama']);?>
							</option>
						<?php } ?>
							<option value="DIPINDAHKAN" lang="DIPINDAHKAN">DIPINDAHKAN</option>
						</select></td>
					</tr>
                    <tr id="trKeadaanKeluar">
						<td align="right">Keadaan Keluar</td>
						<td>&nbsp;<select id="cmbKeadaanKeluar" name="cmbKeadaanKeluar" class="txtinput">
							<option value="0">Semua</option>
                            <option value="Perlu kontrol kembali">Perlu kontrol kembali</option>
                            <option value="Sembuh">Sembuh</option>
						</select></td>
					</tr>
					<tr id="trD">
						<td align="right" width="40%">Diagnosa</td>
						<td width="60%"><input name="diagnosa_id" id="diagnosa_id" type="hidden">&nbsp;<input id="txtDiag" name="txtDiag" size="25" onKeyUp="suggest(event,this);" autocomplete="off" disabled="disabled"><label><input name="pakaiDiagnosa" type="checkbox" onchange="document.getElementById('txtDiag').disabled=this.checked;document.getElementById('txtDiag').value='';" checked="false" />semua</label>
						<div id="divdiagnosa" align="left" style="position:absolute; z-index:1; height: 230px; width:400px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>
						</td>
					</tr>
					<tr id="stsPas">
						<td width="40%" align="right">Status Pasien</td>
						<td width="60%">&nbsp;<select name="StatusPas" id="StatusPas" tabindex="22" class="txtinput"></select></td>
					</tr>
                    <tr id="trKecelakaan">
						<td align="right">Penyebab Kecelakaan</td>
						<td>&nbsp;<input type="checkbox" id="chkKecelakaan" name="chkKecelakaan" class="txtinput" />
					</tr>
					<!--tr>
						<td align="right">ICD X</td>
						<td><input size="16" id="txtIcdx" name="txticdx" class="txtinput"/></td>
					</tr>
					<tr>
						<td align="right">ICD IX</td>
						<td><input size="16" id="txtIcdix" name="txtIcdix" class="txtinput"/></td>
					</tr-->
					<tr>
						<td colspan="2"><input type="button" value="Tampilkan" onclick="submitLap()" style="float:right" /></td>
					</tr>
				</table>
		</fieldset>
        <input type="hidden" id="laporan"  />
    </form>
</div>
<script>
function caraKeluar(val){
	if(val=="MENINGGAL"){
		document.getElementById('trKeadaanKeluar').style.display='table-row';
		document.getElementById('cmbKeadaanKeluar').innerHTML="<option value='0'>Semua</option>"+
															  "<option value='Meninggal'>Meninggal</option>"+
															  "<option value='Meninggal < 48 jam'>Meninggal < 48 jam</option>"+
															  "<option value='Meninggal > 48 jam'>Meninggal > 48 jam</option>"+
															  "<option value='Meninggal sebelum dirawat'>Meninggal sebelum dirawat</option>";
	}
	else if(val=="DIRUJUK"){ 
		document.getElementById('trKeadaanKeluar').style.display='table-row';
		document.getElementById('cmbKeadaanKeluar').innerHTML='<option value="0">Semua</option>'+
															  '<option value="dirujuk">dirujuk</option>';
		
	}
	else if(val=="PULANG PAKSA"){ 
		document.getElementById('trKeadaanKeluar').style.display='table-row';
		document.getElementById('cmbKeadaanKeluar').innerHTML='<option value="0">Semua</option>'+
															  "<option value='Karena Biaya'>Karena Biaya</option>"+
															  "<option value='Karena Keluarga'>Karena Keluarga</option>"+
															  "<option value='Karena Keadaan Pasien'>Karena Keadaan Pasien</option>"+
															  "<option value='Karena Pelayanan'>Karena Pelayanan</option>";
		
	}
	else if(val=="DIPINDAHKAN"){
		document.getElementById('trKeadaanKeluar').style.display='none';	
	}else{
		document.getElementById('cmbKeadaanKeluar').innerHTML='<option value="0">Semua</option>'+
															  '<option value="Perlu kontrol kembali">Perlu kontrol kembali</option>'+
															  '<option value="Sembuh">Sembuh</option>';
		document.getElementById('trKeadaanKeluar').style.display='table-row';	
	}
}

function submitLap(){
	if(document.getElementById('laporan').value=='morbiditas'){
		if(document.getElementById('cmbJenisLayananM').value=='3'){
			document.form1.action = 'rl4a.php';
		}
		else if(document.getElementById('cmbJenisLayananM').value=='1'){
			document.form1.action = 'rl4b.php';
		}
		if(document.getElementById('cmbJenisLayananM').value=='2'){
			document.form1.action = 'rl4c.php';
		}
	}
	else if(document.getElementById('laporan').value=='morbiditasTL'){
		if(document.getElementById('chkKecelakaan').checked){
			document.form1.action = 'MorbiditasPK.php';
		}
		else{
			document.form1.action = 'Morbiditas.php';
		}
	}
	else if(document.getElementById('laporan').value=='RekapPasienMasuk'){
		if(document.getElementById('cmbJenisLayananM').value==3){
			document.form1.action = 'masukInap.php';
		}
		else{
			document.form1.action = 'masukJalan.php';
		}
	}
	else if(document.getElementById('laporan').value=='RekapPasienKeluar'){
		if(document.getElementById('cmbJenisLayananM').value==3){
			document.form1.action = 'keluarInap.php';
		}
		else{
			document.form1.action = 'keluarJalan.php';
		}
	}
	document.form1.submit();
}

tutupW();
function tutupW(){
	document.getElementById('laporan').value = '';
}


	var RowIdx;
	var fKeyEnt;
	function suggest(e,par){
		var keywords=par.value;//alert(keywords);
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
					//alert(RowIdx1);
					if (key==38 && RowIdx1>0){
						RowIdx1=RowIdx1-1;
						document.getElementById('lstDiag'+(RowIdx1+1)).className='itemtableReq';
						if (RowIdx1>0) document.getElementById('lstDiag'+RowIdx1).className='itemtableMOverReq';
					}
					else if (key == 40 && RowIdx1 < tblRow){
						RowIdx1=RowIdx1+1;
						if (RowIdx1>1) document.getElementById('lstDiag'+(RowIdx1-1)).className='itemtableReq';
						document.getElementById('lstDiag'+RowIdx1).className='itemtableMOverReq';
					}
				}
			}else if (key==13){
				//alert('masuk tindakan');
				if (RowIdx1>0){
					if (fKeyEnt1==false){
						fSetTindakan(document.getElementById('lstDiag'+RowIdx1).lang);
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
					Request('diagnosalist.php?aKeyword='+keywords, 'divdiagnosa', '', 'GET' );
					if (document.getElementById('divdiagnosa').style.display=='none') fSetPosisi(document.getElementById('divdiagnosa'),par);
					document.getElementById('divdiagnosa').style.display='block';
			}
		}
	}
	 
	function keUnit(){
		if(document.getElementById('cmbAsal').value == 1){
			document.getElementById('trLb').style.display = 'none';
		}else{
			document.getElementById('trLb').style.display = 'table-row';
		}
	}
	function fSetPenyakit(par){
		var cdata=par.split("*|*");
		document.getElementById("diagnosa_id").value=cdata[0];
		document.getElementById("txtDiag").value=cdata[1]+" - "+cdata[2];
		document.getElementById('divdiagnosa').style.display='none';
		document.getElementById('StatusPas').focus();
	}
</script>
<?php
	include("../../koneksi/konek.php");
	//$kelas_id = $_REQUEST["kelas_id"];
	$idKunj=$_REQUEST['idKunj'];
	//$jeniskasir=$_REQUEST['jenisKasir'];
	$idPel=$_REQUEST['idPel'];
	//$inap=$_REQUEST['inap'];
	//$all = $_REQUEST['all'];
	$idUser = $_REQUEST['idUsr'];
	$idBedah = $_REQUEST['idBedah'];
	$act = 'save';
	//$cek = 0;
	//$cek = mysql_num_rows(mysql_query($sql));
	
	function tanggal($a){
		if($a != ''){
			$tglA = explode('-',$a);
			$tglH = $tglA[2].'-'.$tglA[1].'-'.$tglA[0];
		}
		return $tglH;
	}
	
	if($idBedah != ''){
		$act = 'update';
		$sql = "select * from b_form_prosedur_bedah where idBedah = '$idBedah'";
		$isi = mysql_fetch_array(mysql_query($sql));
		$jenisOperasi = explode('|',$isi['JenisOperasi']);
		$tglOperasi = $isi['tglOperasi'];
		$PreOperasi = $isi['PreOperasi'];
		$LamaOperasi = $isi['LamaOperasi'];
		$ILO = explode('|',$isi['ILO']);
		$ISK = explode('|',$isi['ISK']);
		$ILI = explode('|',$isi['ILI']);
		$VAP = explode('|',$isi['VAP']);
		$bakteri = explode('|',$isi['Bakteri']);
		$bitus = explode('|',$isi['Dekubitus']);
	}
?>
<script type="text/JavaScript" language="JavaScript" src="pb_jquery.js?v=1.6"></script>
<form action="action_pb.php" method="POST" id="fProsedurBedah" name="fProsedurBedah">
	<input type="hidden" id="idKunjBedah" name="idKunjBedah" value="<?=$idKunj?>"/>
	<input type="hidden" id="idPelBedah" name="idPelBedah" value="<?=$idPel?>"/>
	<input type="hidden" id="idUserBedah" name="idUserBedah" value="<?=$idUser?>"/>
	<input type="hidden" id="idBedah" name="idBedah" value="<?=$isi['idBedah']?>"/>
	<input type="hidden" id="actBedah" name="actBedah" value="<?=$act?>"/>
	<input type="hidden" id="idDel" name="idDel" value=""/>
	<center>
	<table width="95%" style="margin-top:15px;">
		<tr>
			<td>Operasi</td>
			<td width="1%">:</td>
			<td><input type="text" name="operasi" id="operasi" style="width:100%;" value="<?=$isi['operasi']?>"/></td>
			<td>Tanggal</td>
			<td width="1%">:</td>
			<td><input type="text" name="tgl_operasi" id="tgl_operasi" size="10" readonly value="<?=($tglOperasi != '')?tanggal($tglOperasi):date('d-m-Y')?>"/><button onClick="gfPop.fPopCalendar(document.getElementById('tgl_operasi'),depRange); return false;">V</button></td>
		</tr>
		<tr>
			<td valign="top">Jenis Operasi</td>
			<td width="1%" valign="top">:</td>
			<td>
				<select name="jenisKotor" id="jenisKotor">
					<option value="1" <?=($jenisOperasi[0]=='1')?'selected':''?>>Bersih</option>
					<option value="0" <?=($jenisOperasi[0]=='0')?'selected':''?>>Kotor</option>
				</select> 
				<select name="jenisBesar" id="jenisBesar">
					<option value="1" <?=($jenisOperasi[1]=='1')?'selected':''?>>Besar</option>
					<option value="0" <?=($jenisOperasi[1]=='0')?'selected':''?>>Kecil</option>
				</select>
			</td>
			<td valign="top">Pre Operasi</td>
			<td width="1%" valign="top">:</td>
			<td valign="top">
				<select name="preOperasi" id="preOperasi">
					<option value="1" <?=($PreOperasi=='1')?'selected':''?>>Cukur</option>
					<option value="0" <?=($PreOperasi=='0')?'selected':''?>>Tidak Cukur</option>
				</select>
				<!--input type="radio" name="preOperasi" id="preOperasi1" value="1" <?//=($PreOperasi=='1')?'checked':''?>/><label for="preOperasi1">Cukur</label>
				<input type="radio" name="preOperasi" id="preOperasi2" value="0" <?//=($PreOperasi=='0')?'checked':''?>/><label for="preOperasi2">Tidak Cukur</label--->
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>Lama Operasi</td>
			<td>:</td>
			<td colspan="4"><input type="text" name="durasi" id="durasi" size="2" value="<?=$LamaOperasi?>"/> Jam</td>
		</tr>
	</table>
	<table class="border" width="95%">
		<thead>
		<tr>
			<th width="130px">Tanggal</th>
			<th width="250px">Ganti Balutan</th>
			<th width="250px">Keterangan</th>
			<th width="250px">Nama Jelas</th>
			<th width="25" align="center"><button class="addRowBalutan" name="tambahBalutan" id="tambahBalutan" onclick="return false;">+</button></th>
		</tr>
		</thead>
		<tbody class='ProsPembedahan'>
			<!---tr>
				<td colspan="5" style="font-size:10px; color:red; font-style:italic;">* Format Tanggal : 12-08-2013</td>
			</tr--->
		<?php
			if($idBedah != ''){
				$sqlBalutan = "select idSubBedah, DATE_FORMAT(tglBalutan,'%d-%m-%Y') as tanggal, balutan, keterangan, namaJelas, idBedah
								from b_form_sub_prosedur_bedah
								where idBedah = $idBedah";
				$queryBalutan = mysql_query($sqlBalutan);
				$i = 99;
				while($dataB = mysql_fetch_array($queryBalutan)){
		?>
				<tr class="item">
					<td style="display:none;">
						<input type="hidden" size="1" name="idSubBedah[]" id="idSubBedah" value="<?=$dataB['idSubBedah']?>"/>
					</td>
					<td align="center">
					<input type="hidden" size="1" name="idNo[]" id="idNo" value="<?=$i?>"/><input type="text" id="tglBalutan<?=$i?>" name="tglBalutan[<?=$i?>]" size="10" readonly value="<?=$dataB['tanggal']?>"/><button onClick="gfPop.fPopCalendar(document.getElementById('tglBalutan<?=$i?>'),depRange); return false;">V</button>
					</td>
					<td align="center"><input type="text" id="GantiBalutan" name="GantiBalutan[<?=$i?>]" style="width:100%;" value="<?=$dataB['balutan']?>"/></td>
					<td align="center"><input type="text" id="ketBalutan" name="ketBalutan[<?=$i?>]" style="width:100%;" value="<?=$dataB['keterangan']?>"/></td>
					<td align="center"><input type="text" id="namaBalutan" name="namaBalutan[<?=$i?>]" style="width:100%;" value="<?=$dataB['namaJelas']?>"/></td>
					<td align="center"><input type="button" value="-" class="delRowBalutan" name="hapusRowBalutan" id="hapusRowBalutan"></td>
				</tr>
		<?php
					$i++;
				}
			} else {
		?>
			<tr class="item">
				<td style="display:none;">
					<input type="hidden" size="1" name="idSubBedah[]" id="idSubBedah" value=""/>
				</td>
				<td align="center">
					<input type="hidden" size="1" name="idNo[]" id="idNo" value="0"/><input type="text" id="tglBalutan0" name="tglBalutan[0]" size="8" readonly value="<?=date('d-m-Y')?>"/><button onClick="gfPop.fPopCalendar(document.getElementById('tglBalutan0'),depRange); return false;">V</button>
				</td>
				<td align="center"><input type="text" id="GantiBalutan" name="GantiBalutan[0]" style="width:100%;"/></td>
				<td align="center"><input type="text" id="ketBalutan" name="ketBalutan[0]" style="width:100%;"/></td>
				<td align="center"><input type="text" id="namaBalutan" name="namaBalutan[0]" style="width:100%;"/></td>
				<td align="center"><input type="button" value="-" class="delRowBalutan" name="hapusRowBalutan" id="hapusRowBalutan"></td>
			</tr>
		<?php
			}
		?>
		</tbody>
	</table>
	<table width="95%">
		<tr>
			<th colspan="7">Komplikasi dan Infeksi Nosokamial</th>
		</tr>
		<tr>
			<td>ILO</td>
			<td>:</td>
			<td>
				<input type="radio" name="ILO" id="ILO1" value="1" onclick="disBL('tglILO|hariILO|butILO','false');" <?=($ILO[0]=='1')?'checked':''?>/><label for="ILO1">Ada</label>
				<input type="radio" name="ILO" id="ILO2" value="0" onclick="disBL('tglILO|hariILO|butILO','true');" <?=($ILO[0]=='0')?'checked':''?>/><label for="ILO2">Tidak Ada</label>
			</td>
			<td width="60px">Hari Ke :</td>
			<td><input type="number" name="hariILO" id="hariILO" size="3" style='text-align:center' value="<?=$ILO[1]?>" <?=($ILO[0]=='0')?'disabled':''?>/></td>
			<td width="130px">Tanggal Hasil Kultur :</td>
			<td><input type="text" name="tglILO" id="tglILO" size="10" readonly value="<?=$ILO[2]?>" <?=($ILO[0]=='0')?'disabled':''?>/><button id="butILO" onClick="gfPop.fPopCalendar(document.getElementById('tglILO'),depRange); return false;">V</button></td>
		</tr>
		<tr>
			<td>ISK</td>
			<td>:</td>
			<td>
				<input type="radio" name="ISK" id="ISK1" value="1" onclick="disBL('tglISK|hariISK|butISK','false');" <?=($ISK[0]=='1')?'checked':''?>/><label for="ISK1">Ada</label>
				<input type="radio" name="ISK" id="ISK2" value="0" onclick="disBL('tglISK|hariISK|butISK','true');" <?=($ISK[0]=='0')?'checked':''?>/><label for="ISK2">Tidak Ada</label>
			</td>
			<td>Hari Ke :</td>
			<td><input type="number" name="hariISK" id="hariISK" size="3" style='text-align:center' value="<?=$ISK[1]?>" <?=($ISK[0]=='0')?'disabled':''?>/></td>
			<td>Tanggal Hasil Kultur :</td>
			<td><input type="text" name="tglISK" id="tglISK" size="10" readonly value="<?=$ISK[2]?>" <?=($ISK[0]=='0')?'disabled':''?>/><button id='butISK' onClick="gfPop.fPopCalendar(document.getElementById('tglISK'),depRange); return false;">V</button></td>
		</tr>
		<tr>
			<td>ILI</td>
			<td>:</td>
			<td>
				<input type="radio" name="ILI" id="ILI1" value="1" onclick="disBL('tglILI|hariILI|butILI','false');" <?=($ILI[0]=='1')?'checked':''?>/><label for="ILI1">Ada</label>
				<input type="radio" name="ILI" id="ILI2" value="0" onclick="disBL('tglILI|hariILI|butILI','true');" <?=($ILI[0]=='0')?'checked':''?>/><label for="ILI2">Tidak Ada</label>
			</td>
			<td>Hari Ke :</td>
			<td><input type="number" name="hariILI" id="hariILI" size="3" style='text-align:center' value="<?=$ILI[1]?>" <?=($ILI[0]=='0')?'disabled':''?>/></td>
			<td>Tanggal Hasil Kultur :</td>
			<td><input type="text" name="tglILI" id="tglILI" size="10" readonly value="<?=$ILI[2]?>" <?=($ILI[0]=='0')?'disabled':''?>/><button id="butILI" onClick="gfPop.fPopCalendar(document.getElementById('tglILI'),depRange); return false;">V</button></td>
		</tr>
		<tr>
			<td>VAP</td>
			<td>:</td>
			<td>
				<input type="radio" name="VAP" id="VAP1" value="1" onclick="disBL('tglVAP|hariVAP|butVAP','false');" <?=($VAP[0]=='1')?'checked':''?>/><label for="VAP1">Ada</label>
				<input type="radio" name="VAP" id="VAP2" value="0" onclick="disBL('tglVAP|hariVAP|butVAP','true');" <?=($VAP[0]=='0')?'checked':''?>/><label for="VAP2">Tidak Ada</label>
			</td>
			<td>Hari Ke :</td>
			<td><input type="number" name="hariVAP" id="hariVAP" size="3" style='text-align:center' value="<?=$VAP[1]?>" <?=($VAP[0]=='0')?'disabled':''?>/></td>
			<td>Tanggal Hasil Kultur :</td>
			<td><input type="text" name="tglVAP" id="tglVAP" size="10" readonly value="<?=$VAP[2]?>" <?=($VAP[0]=='0')?'disabled':''?>/><button id="butVAP" onClick="gfPop.fPopCalendar(document.getElementById('tglVAP'),depRange); return false;">V</button></td>
		</tr>
		<tr>
			<td>Bakterinia/Sepsis</td>
			<td>:</td>
			<td>
				<input type="radio" name="bakteri" id="bakteri1" value="1" onclick="disBL('tglbakteri|haribakteri|butBakteri','false');" <?=($bakteri[0]=='1')?'checked':''?>/><label for="bakteri1">Ada</label>
				<input type="radio" name="bakteri" id="bakteri2" value="0" onclick="disBL('tglbakteri|haribakteri|butBakteri','true');" <?=($bakteri[0]=='0')?'checked':''?>/><label for="bakteri2">Tidak Ada</label>
			</td>
			<td>Hari Ke :</td>
			<td><input type="number" name="haribakteri" id="haribakteri" size="3" style='text-align:center' value="<?=$bakteri[1]?>" <?=($bakteri[0]=='0')?'disabled':''?>/></td>
			<td>Tanggal Hasil Kultur :</td>
			<td><input type="text" name="tglbakteri" id="tglbakteri" size="10" readonly value="<?=$bakteri[2]?>" <?=($bakteri[0]=='0')?'disabled':''?>/><button id="butBakteri" onClick="gfPop.fPopCalendar(document.getElementById('tglbakteri'),depRange); return false;">V</button></td>
		</tr>
		<tr>
			<td>Dekeubitus</td>
			<td>:</td>
			<td>
				<input type="radio" name="bitus" id="bitus1" value="1" onclick="disBL('tglbitus|haribitus|butBitus','false');" <?=($bitus[0]=='1')?'checked':''?>/><label for="bitus1">Ada</label>
				<input type="radio" name="bitus" id="bitus2" value="0" onclick="disBL('tglbitus|haribitus|butBitus','true');" <?=($bitus[0]=='0')?'checked':''?>/><label for="bitus2">Tidak Ada</label>
			</td>
			<td>Hari Ke :</td>
			<td><input type="number" name="haribitus" id="haribitus" size="3" style='text-align:center' value="<?=$bitus[1]?>" <?=($bitus[0]=='0')?'disabled':''?>/></td>
			<td>Tanggal Hasil Kultur :</td>
			<td><input type="text" name="tglbitus" id="tglbitus" size="10" readonly value="<?=$bitus[2]?>" <?=($bitus[0]=='0')?'disabled':''?>/><button id="butBitus" onClick="gfPop.fPopCalendar(document.getElementById('tglbitus'),depRange); return false;">V</button></td>
		</tr>
	</table>
	</center>
	<center style="margin-top:15px;">
		<input type="button" value="<?=$act?>" name="simpanBedah" id="simpanBedah" onclick="prosesPembedahan()"/>
		<input type="button" value="batal" name="batalBedah" id="batalBedah" onclick="batalPB();"/>
	</center>
</form>
<script type="text/javascript">
	function batalPB(){
		jQuery('.formstyle').load('form_pb.php?idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idUsr=<?=$idUser?>',{'doh': true});
		$('.formstyle').slideUp(1000,function(){
			//toggle();
			jQuery("#popup_iframe",top.document).css({height:328});
		});
		$('#tambahPB').css('display','inline'); //$('.formstyle').css('display','none');
	}
	jQuery(function(){
		jQuery("#hariILO, #hariISK, #hariILI, #hariVAP, #haribakteri, #haribitus").keydown(function(e) {
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
</script>
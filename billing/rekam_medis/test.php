<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
        <script type="text/javascript" src="../theme/js/tab-view.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <!--script src="../theme/dhtmlxcalendar.js" type="text/javascript"></script-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!--dibawah ini diperlukan untuk menampilkan menu dropdown-->
		<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
        <script language="JavaScript" src="../theme/js/dropdown.js"></script>

		<link rel="stylesheet" type="text/css" href="jquery_multiselect/jquery.multiselect.css" />
		<link rel="stylesheet" type="text/css" href="jquery_multiselect/style.css" />

        <link rel="stylesheet" type="text/css" href="jquery_multiselect/jquery-ui.css" />
        <script type="text/javascript" src="jquery_multiselect/jquery.js"></script>
        <script type="text/javascript" src="jquery_multiselect/jquery-ui.min.js"></script>
        <script type="text/javascript" src="jquery_multiselect/src/jquery.multiselect.js"></script>
		
        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>

<div id="divIsiAnamnesa" style="display:block;width:940px" class="popup">
            	<div id="hslAnamnesa" style="display:none"></div>
				<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
              <fieldset>
                    <legend id="lgnIsiDataRM">ANAMNESA</legend>
                    <div id=""></div>
                    <form id="form_isi_anamnesa" name="form_isi_anamnesa">
                   	<table border="0" cellpadding="0" cellspacing="0" align="center" width="900">
                        <tr>
                        	<td colspan="4">Pelaksana&nbsp;:&nbsp;
								<select id="cmbDokAnamnesa" name="cmbDokAnamnesa">
									<option>-</option>
								</select>
								<label><input type="checkbox" id="chkDokterPenggantiAnamnesa" value="1" onchange="gantiDokter('cmbDokAnamnesa',this.checked);"/>Dokter Pengganti</label>
							</td>
                        </tr>
                        <tr>
                        	<td colspan="4" style="padding-top:5px; text-decoration:underline;">I. ANAMNESA</td>
                        </tr>
						<tr>
							<td>Keluhan Utama</td>
							<td>Riwayat Penyakit Sekarang</td>
							<td>Riwayat Penyakit Dahulu</td>
							<td></td>
						</tr>
						<tr>
							<td><textarea id="txtKU" name="txtKU"></textarea></td>
							<td><textarea id="txtRPS" name="txtRPS"></textarea></td>
							<td><textarea id="txtRPD" name="txtRPD"></textarea></td>
							<td></td>
						</tr>
                        <tr>
							<td>Riwayat Penyakit Keluarga</td>
							<td>Anamnese Sosial</td>
							<td>Anamnese Riwayat Akhir</td>
							<td></td>
						</tr>
						<tr>
							<td><textarea id="txtRPK" name="txtRPK"></textarea></td>
							<td><textarea id="txtAS" name="txtAS"></textarea></td>
							<td><textarea id="txtRA" name="txtRA"></textarea></td>
							<td></td>
						</tr>
						<td>
							<td colspan="4" style="padding-bottom:5px;"></td>
						</td>
                        <tr>
                        	<td colspan="4" style="border-top:1px solid black; padding-top:5px; text-decoration:underline;">II. PEMERIKSAAN FISIK</td>
                        </tr>
						<tr>
							<td colspan="4">
								<table width="100%">
									<tr>
										<td width="50%">
											<table width="100%">
												<tr>
													<td>Keadaan Umum</td>
													<td>:&nbsp;<input type="text" id="txtKUM" name="txtKUM" /></td>
													<td>GCS</td>
													<td>:&nbsp;<input type="text" id="txtGCS" name="txtGCS" /></td>
												</tr>
												<tr>
													<td>Kesadaran</td>
													<td>:&nbsp;
														<select id="cmbKesadaran" name="cmbKesadaran">
															<?php
																$sKesadaran="select * from anamnese_pilih where tipe='Kesadaran'";
																$qKesadaran=mysql_query($sKesadaran);
																while($rwKes=mysql_fetch_array($qKesadaran)){
															?>
																<option value="<?php echo $rwKes['nama']; ?>"><?php echo $rwKes['nama']; ?></option>
															<?php
																}
															?>
														</select>
													</td>
													<td>Status Gizi</td>
													<td>:&nbsp;
														<select id="cmbStatusGizi" name="cmbStatusGizi">
															<?php
																$sGizi="select * from anamnese_pilih where tipe='Gizi'";
																$qGizi=mysql_query($sGizi);
																while($rwGizi=mysql_fetch_array($qGizi)){
															?>
																<option value="<?php echo $rwGizi['nama']; ?>"><?php echo $rwGizi['nama']; ?></option>
															<?php
																}
															?>
														</select>
													</td>
												</tr>
												<tr>
													<td colspan="4">
														<table width="100%">
															<tr>
																<td width="35">Tensi</td>
																<td width="55" align="center"><input type="text" size="5" id="txtTensi" name="txtTensi" /></td>
																<td width="55">mmHg</td>
																<td width="100"></td>
																<td width="35">Nadi</td>
																<td width="55" align="center"><input type="text" size="5" id="txtNadi" name="txtNadi" /></td>
																<td width="55">/Mnt</td>
																<td width="100"></td>
																<td width="35">BB</td>
																<td width="55" align="center"><input type="text" size="5" id="txtBB" name="txtBB" /></td>
																<td width="55">Kg</td>
															</tr>
															<tr>
																<td width="35">RR</td>
																<td width="55" align="center"><input type="text" size="5" id="txtRR" name="txtRR" /></td>
																<td width="55">/Mnt</td>
																<td width="100"></td>
																<td width="35">Suhu</td>
																<td width="55" align="center"><input type="text" size="5" id="txtSuhu" name="txtSuhu" /></td>
																<td width="55">°C</td>
																<td width="100"></td>
																<td width="35"></td>
																<td width="55" align="center"></td>
																<td width="55"></td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
										<td width="50%">
											<table width="100%">
												<tr>
													<td>Kepala Leher</td>
													<td>:&nbsp;
														<select id="cmbKepalaLeher" name="cmbKepalaLeher">
															<?php
																$s="select * from anamnese_pilih where tipe='Kepala Leher'";
																$q=mysql_query($s);
																while($rws=mysql_fetch_array($q)){
															?>
																<option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
															<?php
																}
															?>
														</select>
													</td>
													<td>Cor</td>
													<td>:&nbsp;
														<select id="cmbCor" name="cmbCor">
															<?php
																$s="select * from anamnese_pilih where tipe='COR'";
																$q=mysql_query($s);
																while($rws=mysql_fetch_array($q)){
															?>
																<option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
															<?php
																}
															?>
														</select>
													</td>
												</tr>
												<tr>
													<td>Pulmo</td>
													<td>:&nbsp;
														<select id="cmbPulmo" name="cmbPulmo">
															<?php
																$s="select * from anamnese_pilih where tipe='PULMO'";
																$q=mysql_query($s);
																while($rws=mysql_fetch_array($q)){
															?>
																<option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
															<?php
																}
															?>
														</select>
													</td>
													<td>Inspeksi</td>
													<td>:&nbsp;
														<select id="cmbInspeksi" name="cmbInspeksi">
														<?php
															$s="select * from anamnese_pilih where tipe='Inspeksi'";
															$q=mysql_query($s);
															while($rws=mysql_fetch_array($q)){
														?>
															<option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
														<?php
															}
														?>
														</select>
													</td>
												</tr>
												<tr>
													<td>Auskultasi</td>
													<td>:&nbsp;
														<select id="cmbAuskultasi" name="cmbAuskultasi">
														<?php
															$s="select * from anamnese_pilih where tipe='Auskultasi'";
															$q=mysql_query($s);
															while($rws=mysql_fetch_array($q)){
														?>
															<option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
														<?php
															}
														?>
														</select>
													</td>
													<td>Palpasi</td>
													<td>:&nbsp;
														<select id="cmbPalpasi" name="cmbPalpasi">
														<?php
															$s="select * from anamnese_pilih where tipe='Palpasi'";
															$q=mysql_query($s);
															while($rws=mysql_fetch_array($q)){
														?>
															<option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
														<?php
															}
														?>
														</select>
													</td>
												</tr>
												<tr>
													<td>Perkusi</td>
													<td>:&nbsp;
														<select id="cmbPerkusi" name="cmbPerkusi">
														<?php
															$s="select * from anamnese_pilih where tipe='Perkusi'";
															$q=mysql_query($s);
															while($rws=mysql_fetch_array($q)){
														?>
															<option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
														<?php
															}
														?>
														</select>
													</td>
													<td>Ekstremitas</td>
													<td>:&nbsp;
														<select id="cmbEkstremitas" name="cmbEkstremitas">
														<?php
															$s="select * from anamnese_pilih where tipe='Ext'";
															$q=mysql_query($s);
															while($rws=mysql_fetch_array($q)){
														?>
															<option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
														<?php
															}
														?>
														</select>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>							
						</tr>
                        <tr>                        	
                            <td colspan="4" align="center">
								<input type="hidden" id="id_anamnesa" name="id_anamnesa" />
								<button type="button" id="btnSimpanAnamnesa" name="btnSimpanAnamnesa" onClick="saveAnamnesa()">Save</button>
							</td>
                        </tr>                     
                    </table>
                    </form>
                </fieldset>
            </div>
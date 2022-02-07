<?php
include ("../koneksi/konek.php");
include("../sesi.php");
?>

<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
  	<td colspan="2" height="20">&nbsp;</td>
  </tr>
  <tr>
    <td width="40%" align="left">		
		  <div id="gridboxtab2" style="width:425px; height:350px; background-color:white; overflow:hidden;"></div>
		<div id="pagingtab2" style="width:425px;"></div>
	</td>
    <td width="60%">
		<table width="100%" cellpadding="1" cellspacing="1" border="0">
			<tr>
				<td width="40%" align="right">NIP:</td>
				<td width="60%">
				  <input type="text" id="txtNip" name="txtNip" size="32" class="txtinput" />
				  <input type="hidden" id="txtId" name="txtId" />
				</td>
			</tr>
			
			<tr>
				<td width="40%" align="right">SIP:</td>
				<td width="60%">
				  <input type="text" id="txtSip" name="txtSip" size="32" class="txtinput" />
				</td>
			</tr>
			<tr>
				<!-- <td align="right">Flag :&nbsp;</td> -->
				<td colspan="3"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
			</tr>
			<tr>
				<td width="40%" align="right">Nama Pelaksana:</td>
				<td width="60%"><input type="text" id="txtNama" name="txtNama" class="txtinput" size="32" /></td>
			</tr>
			
			<tr>
				<td width="40%" align="right">Tempat Lahir:</td>
				<td width="60%"><input type="text" id="txtTmpLhr" name="txtTmpLhr" class="txtinput" size="32" /></td>
			</tr>
			<tr>
				<td width="40%" align="right">Tanggal Lahir:</td>
				<td width="60%"><input type="text" class="txtcenter" name="txtTglLhr" id="txtTglLhr" size="11" tabindex="19" value="<?php echo $date_now;?>"/>
				<input type="button" name="ButtonTglLahir" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('txtTglLhr'),depRange);" />
				</td>
			</tr>
			<tr>
				<td width="40%" align="right">Alamat:</td>
				<td width="60%"><input type="text" id="txtAlamat" name="txtAlamat" class="txtinput" size="32" /></td>
			</tr>
			<tr>
				<td width="40%" align="right">Telepon:</td>
				<td width="60%"><input type="text" id="txtTelp" name="txtTelp" class="txtinput" size="10" onkeyup="if(isNaN(this.value)) alert('isi dengan angka saja');"/></td>
			</tr>
			<tr>
				<td width="40%" align="right">HP:</td>
				<td width="60%"><input type="text" id="txtHp" name="txtHp" class="txtinput" size="16" /></td>
			</tr>
			<tr>
				<td width="40%" align="right">Jenis Kelamin:</td>
				<td width="60%"><select id="cmbSex" name="cmbSex" class="txtinput">				
				<!--<option value=""></option>-->
				<option value="L">Laki-Laki</option>
				<option value="P">Perempuan</option>
				</select></td>
			</tr>
			<tr>
				<td width="40%" align="right">Agama:</td>
				<td width="60%"><select id="cmbAgama" name="cmbAgama" class="txtinput">
				<?php
				$sqlAg="select * from b_ms_agama where aktif=1 order by id";
				$rsAg=mysql_query($sqlAg);
				while($rwAg=mysql_fetch_array($rsAg)){
					?>
					<option value="<?php echo $rwAg['id'];?>"><?php echo $rwAg['agama'];?></option>
					<?php
				}
				?>
				</select></td>
			</tr>
			<!--tr>
				<td width="40%" align="right">Kualifikasi Pendidikan:</td>
				<td width="60%"><select id="cmbPend" name="cmbPend" class="txtinput">
					<?php
				$sqlPend="select * from b_ms_pendidikan where aktif=1 order by id";
				$rsPend=mysql_query($sqlPend);
				while($rwPend=mysql_fetch_array($rsPend)){
					?>
					<option value="<?php echo $rwPend['id'];?>"><?php echo $rwPend['nama'];?></option>
					<?php
				}
				?>
				</select></td>
			</tr-->
			<tr>
				<td width="40%" align="right">Jenis Kepegawaian:</td>
				<td width="60%"><select id="cmbPeg2" name="cmbPeg2" class="txtinput">
					<?php
				$sqlPeg2="SELECT * FROM b_ms_pegawai_jenis ORDER BY id ";
				$rsPeg2=mysql_query($sqlPeg2);
				while($rwPeg2=mysql_fetch_array($rsPeg2)){
					?>
					<option value="<?php echo $rwPeg2['id'];?>"><?php echo $rwPeg2['Nama'];?></option>
					<?php
				}
				?>
				</select></td>
			</tr>
			<tr>
				<td width="40%" align="right">Status Kepegawaian:</td>
				<td width="60%"><select id="cmbPeg" name="cmbPeg" class="txtinput">
					<?php
				$sqlPeg="select * from b_ms_pegawai_status where aktif=1 order by id";
				$rsPeg=mysql_query($sqlPeg);
				while($rwPeg=mysql_fetch_array($rsPeg)){
					?>
					<option value="<?php echo $rwPeg['id'];?>"><?php echo $rwPeg['status'];?></option>
					<?php
				}
				?>
				</select></td>
			</tr>
			<tr>
				<td width="40%" align="right">Spesialisasi:</td>
				<td width="60%"><select id="cmbSpe" name="cmbSpe" class="txtinput">
				<?php
				$sqlSpe="select * from b_ms_reference where stref=8 and aktif=1 order by id";
				$rsSpe=mysql_query($sqlSpe);
				while($rwSpe=mysql_fetch_array($rsSpe)){
					?>
					<option value="<?php echo $rwSpe['id'];?>"><?php echo $rwSpe['nama'];?></option>
					<?php
				}
				?>
				</select></td>
			</tr>
			<tr>
				<td align="right">&nbsp;Status Dalam Aplikasi:</td>
				<td><select id="cmbStatus" name="cmbStatus" onchange="set(this.value)" class="txtinput">
					<option value="0">Pelaksana Layanan</option>
					<option value="1">Administrator</option>
					<option value="2">Pelaksana dan Pengguna Aplikasi</option>
				</select></td>
			</tr>		
			<tr style="visibility:collapse" id="trtxtUid">
				<td width="40%" align="right">UID:</td>
				<td width="60%"><input type="text" id="txtUid" name="txtUid" size="32" class="txtinput"/></td>
			</tr>
			<tr style="visibility:collapse" id="trtxtPass">
				<td width="40%" align="right">Password:</td>
				<td width="60%"><input type="password" id="txtPass" name="txtPass" size="32" class="txtinput"/></td>
			</tr>
			<tr style="visibility:collapse" id="trtxtConPass">
				<td width="40%" align="right">Konfirmasi Password:</td>
				<td width="60%"><input type="password" id="txtConPass" name="txtConPass" size="32" class="txtinput"/></td>
			</tr>
			<tr>
			  <td align="right">Status</td>
			    <td>
				    <label><input type="checkbox" id="chAktif2" name="chAktif2" value="1" checked="checked">aktif</label>
			    </td>
			</tr>
			<tr>
			  <td></td>
			  <td>
				  <input type="button" id="btnSimpan2" name="btnSimpan2" value="Tambah" onclick="simpan(this.value,'tab2');" class="tblTambah"/>
				  <input type="button" id="btnHapus2" name="btnHapus2" value="Hapus" onclick="hapus('tab2');" disabled="disabled" class="tblHapus"/>
				  <input type="button" id="btnBatal2" name="btnBatal2" value="Batal" onclick="batal('tab2');" class="tblBatal"/>
			  </td>
			</tr>
		</table>
	</td>
  </tr>  
</table>
<?php 
mysql_close($konek);
?>
<?php
include("../koneksi/konek.php");
session_start();
include("../sesi.php");
$userId = $_SESSION['userId'];
$spesialis = $_SESSION['spesialis'];
?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
  <tr>
    <td colspan="7" align="center">
		<br/>
		<input type="hidden" id="id2"/>
		<table width="500" cellpadding="5">
        	<tr>
                <td align="right">Periode</td>
                <td colspan="5">&nbsp;<input type="text" class="txtcenterreg" id="tglAwal2" size="11" tabindex="22" value="<?php echo date('d-m-Y');?>"/>
                    <input type="button" id="buttontglAwal2" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tglAwal2'),depRange,ubahUnit3);" />
                    sampai
                    <input type="text" class="txtcenterreg" id="tglAkhir2" size="11" tabindex="22" value="<?php echo date('d-m-Y');?>"/>
                    <input type="button" id="buttontglAkhir2" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tglAkhir2'),depRange,ubahUnit3);" />
                </td>
 			</tr>
			<tr>
				<td width="50">Dokter</td>
				<td>: <?php //echo $spesialis."/".$userId;?>
					<select id="dokter_id2" class="txtinput">
						<?php
						if($spesialis==0){
						$sql = "select id, nama from b_ms_pegawai where aktif = 1 and spesialisasi_id != 0";
						}else{
						$sql = "select id, nama from b_ms_pegawai where aktif = 1 and id = '".$userId."'";
						}
						//$sql = "select id, nama from b_ms_pegawai where aktif = 1 and spesialisasi_id != 0";
						$query = mysql_query($sql);
						while($rows = mysql_fetch_assoc($query)){
							?>
							<option value="<?php echo $rows['id']; ?>"><?php echo $rows['nama']; ?></option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<!-- <tr>
				<td width="50">Flag</td>
				<td>:  -->
				<input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="15" tabindex="3" value="<?php echo $flag; ?>"/>
				<!-- </td>
			</tr> -->
			<tr>
				<td>Waktu</td>
				<td>: 
					<input type="text" id="mulai2" class="txtinput" style="width: 50px;"/> - 
					<input type="text" id="selesai2" class="txtinput" style="width: 50px;"/> <em>format 24:00</em>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="button" value="Simpan" id="btnTambah2" class="tblTambah" onclick="simpan2()"/>
					<input type="button" value="Hapus" id="btnHapus2" disabled="disabled" class="tblHapus" onclick="hapus2()"/>
					<input type="button" value="Batal" class="tblBatal" onclick="batal2()"/>
				</td>
			</tr>
		</table>
		<br/><br/>
	</td>
  </tr>
  <tr>
  	<td width="5%">&nbsp;</td>
    <td width="15%" align="right">Jenis Layanan</td>
    <td width="25%">&nbsp;<select id="cmbJnsLay3" class="txtinput" onchange="isiTmpLay3();">			 
		  </select></td>
    <td width="10%">&nbsp;</td>
    <td width="20%" align="right">Tempat Layanan</td>
    <td width="20%">&nbsp;<select id="TmpLayanan3" class="txtinput" lang="" onchange="ubahUnit3();"></select></td>
  	<td width="5%">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td colspan="5">
		<div id="gridboxtab3" style="width:900px; height:250px; background-color:white; overflow:hidden;"></div>
		<div id="pagingtab3" style="width:900px;"></div>
		</td>
  	<td>&nbsp;</td>
  </tr>
  </table>
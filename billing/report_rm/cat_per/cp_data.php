<?
include "../../koneksi/konek.php";
$id_kunjungan = $_REQUEST['idKunj'];
$id_pelayanan = $_REQUEST['idPel'];
$q = "select * from b_ms_cp where id_kunjungan='$id_kunjungan' and id_pelayanan='$id_pelayanan'"; //echo $q;
$s = mysql_query($q);
$j = mysql_num_rows($s); //echo "$j";
?>
<table width="1000" border="1" style="border-collapse:collapse;" bgcolor="#E8F8FF" class="atable" id="tabelku">
      <tr align="center" bgcolor="#9AD8FC">
        <td width="170">Tanggal / Jam </td>
        <td width="124">Profesi / Bagian </td>
        <td width="293">HASIL PEMERIKSAAN, ANALISIS, RENCANA PENATALAKSANAAN PASIEN <br />
          <br />
          <span style="font:10px Verdana, Arial, Helvetica, sans-serif">(Dituliskan dengan format SOAP/ADIME, disertai dengan Target yang Terukur, Evaluasi Hasil Tatalaksana dituliskan dalam Assessment, Harap bubuhkan Stempel Nama, dan Paraf Pada Setiap Akhir Catatan)</span></td>
        <td width="187">Instruksi Tenaga Kesehatan Termasuk Pasca Bedah / Prosedur <br />
          <span style="font:10px Verdana, Arial, Helvetica, sans-serif">(Instruksi Ditulis dengan Rinci dan Jelas)</span></td>
        <td width="142">VERIFIKASI DPJP <span style="font:10px Verdana, Arial, Helvetica, sans-serif">(Bubuhkan Stempel, Nama, Paraf, Tgl, Jam) (DPJP harus membaca seluruh rencana perawatan)</span> </td>
        <td width="44" valign="bottom">
          <input name="button" type="button" class="alternativeRow" value="(+)" style="cursor:pointer; background:#FFFF66; border:1px solid #FFCC33; padding:2px 3px;"/>        </td>
      </tr>
	  <?
	  if($j==0)
	  {
	  ?>
      <tr>
        <td><input type="text" name="tgl_ct[]" id="tgl_ct0" class="tgl_ct" size="17"  style="font:10px Verdana, Arial, Helvetica, sans-serif;"/></td>
        <td><input type="text" name="prof_ct[]" id="prof_ct" class="prof_ct" style="font:10px Verdana, Arial, Helvetica, sans-serif;" size="15" /></td>
        <td align="center"><input type="text" name="hasil_ct[]" id="hasil_ct" class="hasil_ct" style="font:10px Verdana, Arial, Helvetica, sans-serif;" size="35" /></td>
        <td><input type="text" name="instruksi_ct[]" id="instruksi_ct" class="instruksi_ct" style="font:10px Verdana, Arial, Helvetica, sans-serif;" size="25" /></td>
        <td><input type="text" name="veri_ct[]" id="veri_ct" class="veri_ct" style="font:10px Verdana, Arial, Helvetica, sans-serif;" size="20" /></td>
        <td align="center"><img src="cross.png" class="delRow" border="0" style="cursor:pointer;" onclick="del('0')"></td>
      </tr>
	  <?
	  }
	  else
	  {
	  	  $urutan = 0;
		  while($d = mysql_fetch_array($s))
		  {
	  ?>
		  <tr>
			<td>
			<input type="text" name="id_ct[]" id="id_ct" class="id_ct" size="5"  style="font:10px Verdana, Arial, Helvetica, sans-serif;" value="<?=$d['id'];?>"/>
			<input type="text" name="user_ct[]" id="id_ct" class="id_ct" size="5"  style="font:10px Verdana, Arial, Helvetica, sans-serif;" value="<?=$d['user_act'];?>"/>
			<input type="text" name="tgl_ct[]" id="tgl_ct<?=$urutan;?>" class="tgl_ct" size="17"  style="font:10px Verdana, Arial, Helvetica, sans-serif;" value="<?=tglJamSQL($d['tgl_ct']);?>"/></td>
			<td><input type="text" name="prof_ct[]" id="prof_ct<?=$urutan;?>" class="prof_ct" style="font:10px Verdana, Arial, Helvetica, sans-serif;" size="15" value="<?=$d['prof_ct'];?>" /></td>
			<td align="center"><input type="text" name="hasil_ct[]" id="hasil_ct<?=$urutan;?>" class="hasil_ct" style="font:10px Verdana, Arial, Helvetica, sans-serif;" size="35" value="<?=$d['hasil_ct'];?>" /></td>
			<td><input type="text" name="instruksi_ct[]" id="instruksi_ct<?=$urutan;?>" class="instruksi_ct" style="font:10px Verdana, Arial, Helvetica, sans-serif;" size="25" value="<?=$d['instruksi_ct'];?>" /></td>
			<td><input type="text" name="veri_ct[]" id="veri_ct<?=$urutan;?>" class="veri_ct" style="font:10px Verdana, Arial, Helvetica, sans-serif;" size="20" value="<?=$d['veri_ct'];?>" /></td>
			<td align="center"><img src="cross.png" class="delRow" border="0" style="cursor:pointer;" onclick="del('<?=$d['id'];?>')"></td>
		  </tr>
	 <?
	 	$urutan++;
	 	}
	 }
	 ?>
    </table>
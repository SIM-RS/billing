<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("G:i:s");
$userId = $_REQUEST['userId'];
$loketId = $_REQUEST['loketId'];
$idPas = $_REQUEST['idPas'];
$idKunj = $_REQUEST['idKunj'];
$sql = "SELECT * FROM (SELECT t1.*,n.nama AS jenis_layanan FROM 
(SELECT k.id,k.pasien_id,p.no_rm,p.no_ktp,k.no_billing,p.nama,p.tgl_lahir,p.alamat,p.rt,p.rw,p.desa_id,p.kec_id,p.kab_id,p.prop_id,
p.nama_ortu,p.nama_suami_istri,p.sex,p.pendidikan_id,p.pekerjaan_id,p.agama,p.telp,DATE(k.tgl) AS tgl,k.asal_kunjungan,
k.ket,k.umur_thn,k.umur_bln,k.umur_hr,k.jenis_layanan AS id_jenis_layanan,k.unit_id,u.nama AS tempat_layanan,k.kelas_id,l.nama AS kelas,l2.nama AS kso_kelas,k.status_penj,
k.kso_id,k.kso_kelas_id,tgl_sjp,no_sjp,no_anggota,kso.nama AS nama_kso,k.retribusi,inap,k.dilayani,k.dokter_tujuan_id,k.type_dokter_tujuan,
(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop 
FROM (SELECT k.*,pl.dilayani,pl.dokter_tujuan_id,pl.type_dokter_tujuan FROM b_kunjungan k INNER JOIN b_pelayanan pl ON k.id=pl.kunjungan_id 
WHERE pl.unit_id_asal='$loketId' AND k.id = '$idKunj') k INNER JOIN b_ms_pasien p ON k.pasien_id=p.id INNER JOIN b_ms_unit u ON k.unit_id=u.id 
INNER JOIN b_ms_kelas l ON k.kelas_id=l.id LEFT JOIN b_ms_kelas l2 ON k.kso_kelas_id=l2.id LEFT JOIN b_ms_kso kso ON kso.id=k.kso_id) AS t1 
INNER JOIN b_ms_unit n ON t1.id_jenis_layanan=n.id) AS gab";
$query = mysql_query($sql);
$rows = mysql_fetch_array($query);
?>
<title>KIUP</title>
<body onLoad="gantiUmur();">
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
                <tr>
                    <td colspan="7" align="center"><b>KARTU INDEX UTAMA PASIEN</b></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="5" align="right"><hr /></td>
                </tr>
                <tr>
                    <td width="9">&nbsp;</td>
                    <td width="152" align="right">No RM :&nbsp;</td>
                    <td width="213">
                        <u><?=$rows['no_rm']?></u>
                        <textarea cols="5" rows="5" style="display:none;" id="txtNoRM"></textarea>
                        <input id="txtIdPasien" name="txtIdPasien" type="hidden"/>
                        <input id="txtIdKunj" name="txtIdKunj" type="hidden"/>
                        <input id="IsNewPas" name="IsNewPas" value="" type="hidden"/>                    </td>
                    <td width="213">&nbsp;NIK :&nbsp;
                        <u><?=$rows['']?></u>
                        <input name="NoBiling" id="NoBiling" readonly tabindex="2" size="18" class="txtinputreg" style="display:none" />
                        <textarea cols="5" rows="5" id="txtNoBiling" name="txtNoBiling" style="display: none"></textarea>                    </td>
                    <td width="156" align="right">Nama Ortu :&nbsp;</td>
                    <td width="193"><u><?=$rows['nama_ortu']?></u></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Nama :&nbsp;</td>
                    <td colspan="2"><u><?=$rows['nama']?></u>                    </td>
                    <td align="right">Suami / Istri :&nbsp;</td>
                    <td><u><?=$rows['nama_suami_istri']?></u></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Jenis Kelamin :&nbsp;</td>
                    <td colspan="4"><u><?php if($rows['sex']=='L'){echo "Laki-Laki";}else{echo "Perempuan";}?></u>
                        <!--<select name="Gender" id="Gender" tabindex="4"  class="txtinputreg">
                            <option value="L">Laki-Laki</option>
                            <option value="P"></option></select>-->
                        &nbsp;&nbsp;&nbsp;Pendidikan :&nbsp;<u><?php $pend=mysql_fetch_array(mysql_query("select nama from b_ms_pendidikan where id='".$rows['pendidikan_id']."'")); echo $pend['nama'];?></u>
                        &nbsp;&nbsp;&nbsp;Pekerjaan :&nbsp;<u><?php $pek=mysql_fetch_array(mysql_query("select nama from b_ms_pekerjaan where id='".$rows['pekerjaan_id']."'")); echo $pek['nama'];?></u>                    </td>
                    <td width="44" align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="5" align="right"><hr /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Tgl Lahir :&nbsp;</td>
                    <td colspan="2">
                        <u><?=tglSQL($rows['tgl_lahir'])?></u><input type="hidden" style="text-align:center;" value="<?=tglSQL($rows['tgl_lahir'])?>" class="txtinputreg" name="tgl_lahir" id="tgl_lahir" size="3" tabindex="11"/>
                        &nbsp;&nbsp;Umur :&nbsp;<input type="text" style="text-align:center;" value="0" class="txtinputreg" name="th" id="th" size="3" tabindex="11" readonly="readonly"/>
                        &nbsp;Th&nbsp;&nbsp;<input type="text" style="text-align:center;" value="0" class="txtinputreg" name="Bln" id="Bln" size="3" tabindex="12" readonly="readonly"/>&nbsp;Bln
                        &nbsp;&nbsp;<input type="text" style="text-align:center;" value="0" class="txtinputreg" name="hari" id="hari" size="3" tabindex="12" readonly="readonly"/>&nbsp;Hr                    </td>
                    <td align="center" style="color:#666666">Kunjungan Pasien &nbsp;</td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Agama:&nbsp;</td>
                    <td colspan="2"><u><?php $agm=mysql_fetch_array(mysql_query("select agama from b_ms_agama where id='".$rows['agama']."'")); echo $agm['agama'];?></u>&nbsp;&nbsp;&nbsp; Telp. <u><?=$rows['telp']?></u></td>
                    <td align="right">Tgl Kunjungan :&nbsp;</td>
                    <td>
                        <u><?=tglSQL($rows['tgl'])?></u></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Alamat :&nbsp;</td>
                    <td colspan="2">
                        <u><?=$rows['alamat']?></u>
			RT. <u><?=$rows['rt']?></u>
			RW. <u><?=$rows['rw']?></u>
                        <div id="div_pasien" align="center" class="div_pasien"></div>                    </td>
                    <td align="right">Asal Masuk :&nbsp;</td>
                    <td>
                        <u><?php $asl=mysql_fetch_array(mysql_query("select nama from b_ms_asal_rujukan where id='".$rows['asal_kunjungan']."'")); echo $asl['nama'];?></u>                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Propinsi :&nbsp;</td>
                    <td colspan="2">
						<u><?php $prop=mysql_fetch_array(mysql_query("select nama from b_ms_wilayah where id='".$rows['prop_id']."'")); echo $prop['nama'];?></u>
                        <input name="cmbProp" id="cmbProp" type="hidden" />
						<div id="divautocomplete" align="left" style="position:absolute; z-index:1; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>
                        <!--select id="cmbProp" name="cmbProp" onChange="isiKab();" tabindex="18"  class="txtinputreg">
                        </select--></td>
                    <td align="right">Keterangan :&nbsp;</td>
                    <td><u><?=$rows['ket']?></u></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Kabupaten/Kota :&nbsp;</td>
                    <td colspan="2"> <u><?php $kab=mysql_fetch_array(mysql_query("select nama from b_ms_wilayah where id='".$rows['kab_id']."'")); echo $kab['nama'];?></u>
					<input name="cmbKab" id="cmbKab" type="hidden" class="txtinput" size="5" />
					<div id="divautocomplete_kab" align="left" style="position:absolute; z-index:1; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>
					<!--<select id="cmbKab" name="cmbKab" onChange="isiKec();" tabindex="19" class="txtinputreg"></select>--></td>
                    <td align="right">Status pasien :&nbsp;</td>
                    <td>
                        <u><?=$rows['nama_kso']?></u>                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Kecamatan :&nbsp;</td>
                    <td colspan="2">
					<u><?php $kec=mysql_fetch_array(mysql_query("select nama from b_ms_wilayah where id='".$rows['kec_id']."'")); echo $kec['nama'];?></u>
					<input name="cmbKec" id="cmbKec" type="hidden" class="txtinput" size="5" />
					<div id="divautocomplete_kec" align="left" style="position:absolute; z-index:1; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>
                        <!--<select id="cmbKec" name="cmbKec" onChange="isiCombo('cmbDesa',this.value);" tabindex="20" class="txtinputreg">
                        </select>-->                    </td>
                    <td align="right">Tgl SJP/SKP :&nbsp;</td>
                    <td><u><?=tglSQL($rows['tgl_sjp'])?></u></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Kelurahan/Desa :&nbsp;</td>
                    <td colspan="2">
					<u><?php $des=mysql_fetch_array(mysql_query("select nama from b_ms_wilayah where id='".$rows['desa_id']."'")); echo $des['nama'];?></u>
					<input name="cmbDesa" id="cmbDesa" type="hidden" class="txtinput" size="5" />
					<div id="divautocomplete_des" align="left" style="position:absolute; z-index:1; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>
                        <!--<select id="cmbDesa" name="cmbDesa" tabindex="21" class="txtinputreg">
                        </select> -->                   </td>
                    <td align="right">No SJP/SKP :&nbsp;</td>
                    <td><u><?=$rows['no_sjp']?></u></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3" align="right"><hr /></td>
                    <td align="right">Jenis Layanan :&nbsp;</td>
                    <td>
                        <u><?=$rows['jenis_layanan']?></u>                    </td>
                    <!--if(document.getElementById('NoRm').value=='' || document.getElementById('txtIdPasien').value == ''){getNoRM();}else{getNoBil();}-->
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right" style="color:#666666">Penjamin Pasien</td>
                    <td colspan="2">&nbsp;</td>
                    <td align="right">Tempat Layanan :&nbsp;</td>
                    <td>
                        <u><?=$rows['tempat_layanan']?></u>
                        <!--isiCombo('cmbKelasPasien',this.value,'','cmbKelas',setRetribusi);isiKamar-->
                        <input type="hidden" id="prev_inap" name="prev_inap" />
                        <!--input type="text" id="inap" name="inap" />
                        <textarea style="display: block" id="h_inap" name="h_inap"></textarea-->                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Penjamin :&nbsp;</td>
                    <td colspan="2"><input type="hidden" name="Penjamin" id="Penjamin" class="txtinputreg" />
                        <u><?=$rows['nama_kso']?></u>&nbsp;&nbsp;No Anggota :&nbsp;<u><?=$rows['no_anggota']?></u>                    </td>
                    <td align="right">Kelas :&nbsp;</td>
                    <td>
                        <u><?=$rows['kelas']?></u>                    </td><!--getInap();setRoom();-->
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Hak Kelas :&nbsp;</td>
                    <td colspan="2">
                        <u><?=$rows['kso_kelas']?></u>
			Status :&nbsp;
                        <u><?=$rows['status_penj']?></u>                    </td>
                        
                     <?php
					 $sRet="SELECT 
mt.nama,
mtk.tarip 
FROM b_ms_tindakan mt
INNER JOIN b_ms_tindakan_kelas mtk ON mtk.ms_tindakan_id=mt.id
INNER JOIN b_tindakan t ON t.ms_tindakan_kelas_id=mtk.id
INNER JOIN b_pelayanan p ON p.id=t.pelayanan_id
WHERE p.kunjungan_id='$idKunj' AND p.unit_id_asal='$loketId' AND mt.klasifikasi_id=11;";
$Ret=mysql_fetch_array(mysql_query($sRet));
					 ?>   
                    <td align="right" id="td_ret">
                        Retribusi :&nbsp;                    </td>
                    <td id="td_ret1">
                        <u><?=$Ret['nama']?></u>&nbsp;&nbsp;&nbsp;
                        <u><?=$Ret['tarip']?></u>
                        <input type="hidden" id="prev_retribusi" name="prev_retribusi" />                    </td>
                    <td align="right" id="td_room">
                        <?php if($rows['inap']!=0){?>Kamar :<?php }?>&nbsp;                    </td>
                    <td width="38" id="td_room1">
                        <?php if($rows['inap']!=0){?><select id="kamar" class="txtinputreg" onChange="setTarip('setThrough')" tabindex="33" name="kamar">
                        </select>
                        <span id="spanTarifKamar"></span>
                        <div id="div_room"></div><?php }?>
                        <!--  style="display: none"kamar diambil dari b_ms_kamar,b_ms_unit,b_ms_kelas, jika kelas diganti maka kamar ikut berubah display: none; -->                    </td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td colspan="2"></td>
                    <td align="right">Dokter :&nbsp;</td>
                    <td><u><?php $dok=mysql_fetch_array(mysql_query("select nama from b_ms_pegawai where id='".$rows['dokter_tujuan_id']."'")); echo $dok['nama'];?></u></td>
                </tr>
                <tr>
                  <td></td>
                  <td colspan="3" align="center">&nbsp;</td>
                  <td colspan="2" align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="6"></td>
                </tr>
                <tr>
                    <td>                    </td>
                                            <!--<td>
						<fieldset>
                            <legend>Loket</legend>
                            <select id="asal" name="asal" onChange="decUser();batal('1');" style="width:150" class="txtinputreg"></select>
                        </fieldset>
                        <fieldset>
                            <legend>User</legend>
                            <select id="userLog" name="UserLog" onChange="saring();batal('1');" style="width:150" class="txtinputreg"></select>
                        </fieldset>                    </td>-->
                    <td colspan="5" align="center"><table width="900px" border="1">
                      <tr align="center" bgcolor="#999999">
                        <td width="23">No</td>
                        <td width="70">No. RM</td>
                        <td width="137">Nama</td>
                        <td width="143">Alamat</td>
                        <td width="134">Dokter</td>
                        <td width="186">Diagnosa</td>
                        <td width="78">Tanggal Masuk</td>
                        <td width="77">Tanggal Keluar</td>
                      </tr>
                      <?php
					  $z=1;
					  $que="SELECT DISTINCT 
  p.nama,
  CONCAT(
    (
      CONCAT(
        (
          CONCAT(
            (CONCAT(p.alamat, ' RT.', p.rt)),
            ' RW.',
            p.rw
          )
        ),
        ', Desa ',
        w.nama
      )
    ),
    ', Kecamatan ',
    wi.nama
  ) alamat_,
  md.nama AS diag,
  peg.nama AS dokter,
  p.`no_rm`,
  DATE_FORMAT(kun.tgl_act, '%d-%m-%Y') tglawal,
  DATE_FORMAT(bpk.tgl_act, '%d-%m-%Y') tglakhir
FROM
  b_pelayanan k 
  INNER JOIN b_kunjungan kun 
    ON k.kunjungan_id = kun.id 
  INNER JOIN b_ms_pasien p 
    ON p.id = k.`pasien_id` 
  LEFT JOIN b_diagnosa diag 
    ON diag.kunjungan_id = kun.id 
  LEFT JOIN b_ms_diagnosa md 
    ON md.id = diag.ms_diagnosa_id 
  LEFT JOIN b_ms_unit u 
    ON k.unit_id = u.id 
  LEFT JOIN b_ms_kelas kel 
    ON kel.id = kun.kelas_id 
  LEFT JOIN b_ms_wilayah w 
    ON p.desa_id = w.id 
  LEFT JOIN b_ms_wilayah wi 
    ON p.kec_id = wi.id 
  LEFT JOIN b_tindakan bmt 
    ON kun.id = bmt.kunjungan_id 
    AND k.id = bmt.pelayanan_id 
  LEFT JOIN b_ms_pegawai peg 
    ON peg.id = bmt.user_act
  LEFT JOIN b_pasien_keluar bpk
    ON bpk.`kunjungan_id`=kun.id 
    AND bpk.`pelayanan_id`=k.id
WHERE kun.id = '".$idKunj."' ";
$x=mysql_query($que);
					  while($isi=mysql_fetch_array($x)){
					  ?>
                      <tr>
                        <td><?=$z?></td>
                        <td><u><?=$isi['no_rm']?></u></td>
                        <td><u><?=$isi['nama']?></u></td>
                        <td><u><?=$isi['alamat_']?></u></td>
                        <td><u><?=$isi['dokter']?></u></td>
                        <td><u><?=$isi['diag']?></u></td>
                        <td><u><?=$isi['tglawal']?></u></td>
                        <td><u><?=$isi['tglakhir']?></u></td>
                      </tr>
                      <?php
					  $z++;}
					  ?>                 
                    </table></td>
                    <!--td colspan="2"></td>
                    <td align="right">&nbsp;</td-->                </tr>
            <tr>
                  <td align="center" colspan="6">&nbsp;</td>
  </tr>
            <tr id="trTombol">
        <td align="center" colspan="6">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr>

            </table>
</body>
<script type="text/JavaScript">
    // define progress listener object
    
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
                window.print();
                window.close();
        }
    }
	
	function gantiUmur(){
            var val=document.getElementById('tgl_lahir').value;
			//alert(val);
            var dDate = new Date('<?php echo gmdate('Y,m,d',mktime(date('H')+7));?>');

            var tgl = val.split("-");
            var tahun = tgl[2];
            var bulan = tgl[1];
            var tanggal = tgl[0];
            //alert(tahun+", "+bulan+", "+tanggal);
            var Y = dDate.getFullYear();
            var M = dDate.getMonth()+1;
            var D = dDate.getDate();
            //alert(Y+", "+M+", "+D);
            Y = Y - tahun;
            M = M - bulan;
            D = D - tanggal;
            //M = pad(M+1,2,'0',1);
            //D = pad(D,2,'0',1);
            //alert(Y+", "+M+", "+D);
            if(D < 0){
                M -= 1;
                D = 30+D;
            }
            if(M < 0){
                Y -= 1;
                M = 12+M;
            }
            document.getElementById("th").value = Y;
            document.getElementById("Bln").value = M;
            document.getElementById("hari").value = D;
            //$("txtHari").value = D;
        }
</script>

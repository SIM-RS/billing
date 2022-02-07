<?
include('../../koneksi/konek.php');
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUser'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, an.`BB`, an.`TB`, pg.`id` AS id_user
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN `anamnese` an ON an.`KUNJ_ID`=pl.`kunjungan_id`
WHERE pl.id='$idPel'"; //$idPel
$dP=mysql_fetch_array(mysql_query($sqlP));

$sql2="SELECT
  b.`id`,
  a.`tgl_act` AS tgl_lab,
  c.`tgl_act` AS tgl_radiologi,
  d.`tgl_act` AS tgl_rm 
FROM
  `b_hasil_lab` a 
  INNER JOIN `b_pelayanan` b 
    ON a.`id_pelayanan` = b.`id` 
  INNER JOIN `b_hasil_rad` c 
    ON c.`pelayanan_id` = b.`id` 
  INNER JOIN `b_fom_resum_medis` d
ON d.`pelayanan_id` =b.`id` WHERE b.`id`='$idPel' GROUP BY a.`tgl_act` ";
$tgl2=mysql_fetch_array(mysql_query($sql2));	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>

        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
    <!-- untuk ajax-->
    
        <title>.:SURAT KUASA PEMBERIAN INFORMASI MEDIS:.</title>
        <style>
        body{background:#FFF;}
.kotak{
border:1px solid #000000;
width:20px;
height:20px;
vertical-align:middle; 
text-align:center;
}
    </style>
</head>

<body onload="">
<iframe height="72" width="130" name="sort"
    id="sort"
    src="../../theme/dsgrid_sort.php" scrolling="no"
    frameborder="0"
    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>

<div id="tampil_input" align="center" style="display:none
">
    <form action="" method="get" name="sk_info" id="sk_info">
    	<input type="hidden" id="act" name="act" value="hapus" /> 
		<input type="hidden" id="id" name="id" />
        <table width="925" >
          <tr>
            <th width="18" scope="col">&nbsp;</th>
            <th width="128" scope="col">&nbsp;</th>
            <th width="73" scope="col">&nbsp;</th>
            <th width="73" scope="col">&nbsp;</th>
            <th width="73" scope="col">&nbsp;</th>
            <th colspan="5" rowspan="4" scope="col" style="border:1px solid #000">SURAT KUASA PEMBERIAN<BR />INFORMASI MEDIS</th>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4"><div align="center"><strong>PEMERINTAH KOTA MEDAN</strong></div></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4"><div align="center"><strong>RUMAH SAKIT PELINDO I</strong></div></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
        </table>
          <br />
        </center>
        <center>
        <table width="925" style="border:1px solid #000; border-collapse:collapse">
          <tr>
            <th width="3" scope="col">&nbsp;</th>
            <th width="259" scope="col">&nbsp;</th>
            <th width="14" scope="col">&nbsp;</th>
            <th width="274" scope="col">&nbsp;</th>
            <th width="32" scope="col">&nbsp;</th>
            <th width="23" scope="col">&nbsp;</th>
            <th width="23" scope="col">&nbsp;</th>
            <th width="23" scope="col">&nbsp;</th>
            <th width="17" scope="col">&nbsp;</th>
            <th width="2" scope="col">&nbsp;</th>
            <th width="33" scope="col">&nbsp;</th>
            <th width="68" scope="col">&nbsp;</th>
            <th width="49" scope="col">&nbsp;</th>
            <th width="19" scope="col">&nbsp;</th>
            <th width="22" scope="col">&nbsp;</th>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="8">No. Permintaan Informasi Medis :</td>
            <td>
            <input name="no" type="text" id="no" size="7" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">Yang bertanda tangan dibawah ini :</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>Nama</td>
            <td>:</td>
            <td colspan="11"><label for="a"></label>
              <input name="nama" type="text" id="nama" size="35" /></td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Alamat</td>
            <td>:</td>
            <td rowspan="2"><label for="s"></label>
              <textarea name="alamat" id="alamat" cols="26" rows="2"></textarea></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>No.KTP</td>
            <td>:</td>
            <td colspan="11"><input name="noktp" type="text" id="noktp" size="35" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="14">Selaku : Pasien / Suami / Istri / Orang tua / Ayah / Ibu / Wali / Anak / Penanggung jawab *) yang mendapat ijin tertulis dari </td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>pasien</td>
            <td>:</td>
            <td width="274"><label for="as"></label>
              <select name="hubungan" id="hubungan">
              	<option>.:Hubungan dengan pasien:.</option>
                <option value="Pasien">Pasien</option>
                <option value="Suami">Suami</option>
                <option value="Isteri">Isteri</option>
                <option value="Orang Tua">Orang Tua</option>
                <option value="Ayah">Ayah</option>
                <option value="Ibu">Ibu</option>
                <option value="Wali">Wali</option>
                <option value="Anak">Anak</option>
                <option value="Penanggung Jawab">Penanggung Jawab</option>
              </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>Nama Pasien</td>
            <td>:</td>
            <td colspan="6"><?=$dP['nama'];?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nomor Rekam Medis</td>
            <td>:</td>
            <td colspan="6"><?=$dP['no_rm'];?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Tanggal Rawat</td>
            <td>:</td>
            <?
				$waktu =tglJamSQL($dP['tgl_act']);
				$tgl = explode(' ',$waktu);
			?>
            <td colspan="6"><?=$tgl[0];?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Dokter Yang Merawat</td>
            <td>:</td>
            <td colspan="6"><?=$dP['dr_rujuk'];?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td colspan="14">Selanjutnya pihak di atas disebut <strong>Pemberi Kuasa, </strong>dengan ini memberikan kuasa kepada :</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="14"><strong>RS Pelindo I, </strong>beralamat di . . . </td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="14">( Selanjutnya disebut <strong>Penerima Kuasa</strong> ) :</td>
            </tr>
          <tr>
            <td colspan="15"><div align="center"><strong>----------------------------------------------- K H U S U S --------------------------------------</strong><strong>----------</strong></div></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="14">Untuk memberikan informasi medis mengenai diri saya / pasien tersebut diatas *), baik secara lisan maupun tertulis, sesuai dengan kebijakan yang berlaku di lingkungan <strong>RS Pelindo I </strong>kepada :</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Perorangan / Perusahaan / Asuransi *)</td>
            <td>:</td>
            <td><label for="sa"></label>
              <select name="lingkungan" id="lingkungan">
                <option>.: Lingkungan :.</option>
                <option value="Perorangan">Perorangan</option>
                <option value="Perusahaan">Perusahaan</option>
                <option value="Asuransi">Asuransi</option>
            </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>Fotocopy hasil pemeriksaan yang diminta</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>1. Hasil Resume Medis tanggal</td>
            <td>:</td>
             <?
				$waktu2 =tglJamSQL($tgl2['tgl_rm']);
			?>
            <td><?=$waktu2;?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>2. Hasil Laboratorium tanggal</td>
            <td>:</td>
            <?
				$waktu2 =tglJamSQL($tgl2['tgl_lab']);
				$tgl_lab = explode(' ',$waktu2);
			?>
            <td><?=$tgl_lab[0];?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>3. Hasil Radiologi tanggal</td>
            <td>:</td>
            <?
				$waktu3 =tglJamSQL($tgl2['tgl_radiologi']);
				$tgl_rad = explode(' ',$waktu3);
			?>
            <td><?=$tgl_rad[0]?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>4. Hasil Lain-lain </td>
            <td>:</td>
            <td>-</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td colspan="14">Sehubungan dengan urusan tersebut diatas, maka dengan ini <strong>Pemberi Kuasa </strong>membebaskan <strong>Penerima Kuasa </strong>dari segala tuntutan atau konsekuensi hukum dari pihak ketiga, yang mungkin timbul sebagai akibat pelepasan informasi medis pasien tersebut.</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td colspan="13">
            	<center><input type="button" name="simpen" id="simpen" class="tblTambah" value="Simpan" onclick="simpan();document.getElementById('tampil_input').style.display='none'"/> 
              &nbsp;<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="bersihkan()" class="tblBatal"/>
             	</center>
            </td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          </table>
        </center>
 	</form>
</div>	
        
<div id="tampil_data" align="center">
<table width="925" border="0" cellpadding="4" style="font:12px tahoma;">
<td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="2">
                      <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" class="tblTambah" onclick="document.getElementById('tampil_input').style.display='block';document.getElementById('simpen').lang='simpan';document.getElementById('sk_info').reset();" />
                      
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" class="tblTambah" onclick="if(document.getElementById('id').value == '' || document.getElementById('id').value == null){alert('Pilih dulu yang akan diedit.')}else{document.getElementById('tampil_input').style.display='block';return};ambilData();" />
                      
                      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>    
                                      </td>
                    <td width="20%" align="right"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left" colspan="3">
                        <div id="gridbox" style=" height:300px;width:925px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:925px"></div></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
</table>

</div>
</body>
</html>

<script>


function cetak(){
	var rowid = document.getElementById("id").value;
		if(rowid==""){
			var rowidx =a.getRowId(a.getSelRow()).split('|');
			rowid=rowidx[0];
		 }
	window.open("34.sk_pemberianinformasimedis_cetak.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
	//alert("34.sk_pemberianinformasimedis_cetak.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>");
	
		
}

function goFilterAndSort(abc){
	if (abc=="gridbox"){
		//alert('filter cak');
		rek.loadURL("34.pemberianinformasimedis_util.php?id_pelayanan=<?=$idPel?>&kode=true&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage(),"","GET");
	}
} 


 var rek=new DSGridObject("gridbox");
        rek.setHeader(".:SURAT KUASA PEMBERIAN INFORMASI MEDIS:.");
        rek.setColHeader("NO,NAMA PASIEN, PENANGGUNG JAWAB,HUBUNGAN,ALAMAT,TGL INPUT,PENGGUNA");
        rek.setIDColHeader(",nama,nama_penanggung,hubungan,alamat,tgl_act,dr_rujuk");
        rek.setColWidth("25,130,100,100,200,100,100");
        rek.setCellAlign("center,left,center,center,left,center,center");
        rek.setCellHeight(20);
        rek.setImgPath("../../icon");
        rek.setIDPaging("paging");
        rek.attachEvent("onRowClick","ambilData");
        rek.baseURL("34.sk_pemberianinformasimedis_util.php?id_pelayanan=<?=$idPel?>&kode=true&saring=");
        rek.Init();
		



function hapus(){
	if(document.getElementById('id').value == '' || document.getElementById('id').value == null) {
		alert('Pilih Data Yang Akan Dihapus');
	}else{
		if (confirm('Apakah Anda yakin Ingin Menghapus Data ?'))
			var act =document.getElementById('simpen').lang='hapus';
			var id = $('#id').val();
			rek.loadURL("34.sk_pemberianinformasimedis_util.php?kode="+true+"&act="+act+"&id="+id+"&id_pelayanan="+'<?=$idPel; ?>','','GET');
			
	}
} 
function simpan(){
	var act = document.getElementById('simpen').lang;
	var id = $('#id').val();
	var id_pasien ='<?=$dP['id'];?>';
	var no = $('#no').val();
	var nama = $('#nama').val();
	var alamat = $('#alamat').val();
	var noktp = $('#noktp').val();
	var hubungan = $('#hubungan').val();
	var lingkungan = $('#lingkungan').val();		
	

	rek.loadURL("34.sk_pemberianinformasimedis_util.php?kode="+true+"&act="+act+"&id="+id+"&id_pasien="+id_pasien+"&id_pelayanan="+'<?=$idPel ;?>'+"&id_user="+'<?=$dP['id_user'];?>'+"&no="+no+"&nama="+nama+"&alamat="+alamat+"&noktp="+noktp+"&hubungan="+hubungan+"&lingkungan="+lingkungan,'','GET');
	bersihkan();
}		

function bersihkan(){
	document.getElementById('sk_info').reset();
	document.getElementById('tampil_input').style.display='none';
}

function ambilData(){
	var sisipan=rek.getRowId(rek.getSelRow()).split("|");
	document.getElementById('id').value=sisipan[0];
	$('#nama').val(rek.cellsGetValue(rek.getSelRow(),3));
	$('#hubungan').val(rek.cellsGetValue(rek.getSelRow(),4));
	$('#alamat').val(rek.cellsGetValue(rek.getSelRow(),5));
	$('#noktp').val(sisipan[1]);
	$('#lingkungan').val(sisipan[2]);
	$('#no').val(sisipan[3]);
	document.getElementById('no').disabled=true;
	document.getElementById('simpen').lang='update';
}

</script>
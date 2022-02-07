<?
include('../../koneksi/konek.php');
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUser'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, an.`BB`, an.`TB`,  an.`TENSI`, pg.`id` AS id_user
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN `anamnese` an ON an.`KUNJ_ID`=pl.`kunjungan_id`
WHERE pl.id='$idPel'"; //$idPel
$dP=mysql_fetch_array(mysql_query($sqlP));

$hl="SELECT 
  c.`nama`,
  a.`hasil`,
  a.`id` 
FROM
  `b_hasil_lab` a 
  INNER JOIN `b_ms_normal_lab` b 
    ON a.`id_normal` = b.`id` 
  INNER JOIN `b_ms_pemeriksaan_lab` c 
    ON b.`id_pemeriksaan_lab` = c.`id`
    WHERE A.`id_pelayanan`='$idPel'";
$hLab=mysql_fetch_array(mysql_query($hl));	
	
   
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
<script type="text/JavaScript">
	var arrRange = depRange = [];
</script>   
</script>  
       <script type="text/javascript" src="../js/jquery.timeentry.js"></script>
<script type="text/javascript">
$(function () 
{
	$('#jam').timeEntry({show24Hours: true, showSeconds: true});
});
</script>
 
        <title>.:Surat Keterangan DOA:.</title>
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
<iframe height="193" width="168" name="gToday:normal:agenda.js"
    id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
    style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
</iframe> 

<div id="tampil_input" align="center" style="display:blok">
    <form action="" method="get" name="gizi" id="gizi">
    	<input type="text" id="act" name="act" value="hapus" /> 
		<input type="text" id="id" name="id" />
    <BR>
        <center><table width="828" style="border:1px #000 solid; border-collapse:collapse">
          <tr>
            <th colspan="8" scope="col">&nbsp;</th>
          </tr>
          <tr>
            <th colspan="8" scope="col">SURAT KETERANGAN</th>
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
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">Dengan ini menerangkan bahwa,</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="17">&nbsp;</td>
            <td width="353">&nbsp;</td>
            <td width="9">&nbsp;</td>
            <td width="300">&nbsp;</td>
            <td width="94">&nbsp;</td>
            <td width="55">&nbsp;</td>
            <td width="84">&nbsp;</td>
            <td width="1">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nama</td>
            <td>:</td>
            <td> <?=$dP['nama'];?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>No. Rekam Medis</td>
            <td>:</td>
            <td><?=$dP['no_rm'];?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>TTL</td>
            <td>:</td>
            <td><?=tglSQL($dP['tgl_lahir']);?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Umur</td>
            <td>:</td>
            <td><?=$dP['usia'];?>&nbsp;
Tahun</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <?
			if($dP['sex']=='L'){
				$jk='Laki-laki';
			}else{
				$jk='Perempuan';
			}
			?>
            <td><?=$jk;?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Alamat</td>
            <td>:</td>
            <td><?=$dP['alamat'];?></td>
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
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="7">Tiba di Unit Gawat Darurat RS Pelindo I dalam keadaan sudah meninggal dunia.</td>
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
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Pada Tanggal</td>
            <td>:</td>
            <td>
            	<input name="tgl" type="text" id="tgl" tabindex="4" value="<?php echo $tanggal;?>" size="10" maxlength="15" readonly="true"/>
			<img alt="calender" style="cursor:pointer" border=0 src="../../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);">
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Pukul</td>
            <td>:</td>
            <td>
              <input name="jam" type="text" id="jam" size="10" />&nbsp;
            </td>
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
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6">Demikian surat keterangan ini dibuat, dan dipergunakan seperlunya.</td>
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
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><label for="penyakit"></label></td>
            <td colspan="2">Medan,</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">Dokter Pemeriksa,</td>
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
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">(&nbsp;<?=$dP['dr_rujuk'];?>&nbsp;)</td>
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
          </tr>
        </table></center>
        <br />
        <center><input type="button" name="simpen" id="simpen" class="tblTambah" value="Simpan" onclick="simpan();document.getElementById('tampil_input').style.display='none'"/> 
              &nbsp;<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="bersihkan()" class="tblBatal"/>
             	</center>
    </form>
</div>	

<div id="tampil_data" align="center">
<table width="755" border="0" cellpadding="4" style="font:12px tahoma;">
<td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="2">
                      <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" class="tblTambah" onclick="document.getElementById('tampil_input').style.display='block';document.getElementById('simpen').lang='simpan';document.getElementById('gizi').reset();" />
                      
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
                        <div id="gridbox" style=" height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging"></div></td>
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
			alert('Pilih data terlebih dahulu');
			var rowidx =a.getRowId(a.getSelRow()).split('|');
			rowid=rowidx[0];
		 }
	window.open("38.surat_keterangan_DOA_cetak.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
	
		
}

function goFilterAndSort(abc){
	if (abc=="gridbox"){
		//alert('filter cak');
		rek.loadURL("38.surat_keterangan_DOA_util.php?id_pelayanan=<?=$idPel?>&kode=true&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage(),"","GET");
	}
} 

function ambilData(){
	var sisipan=rek.getRowId(rek.getSelRow()).split("|");
	document.getElementById('id').value=sisipan[0];
	document.getElementById('jam').value=sisipan[1];
	var tanggal = rek.cellsGetValue(rek.getSelRow(),5);
	//alert(sisipan[1]);
	$('#tgl').val(tanggal);
	document.getElementById('simpen').lang='update';
}

function bersihkan(){
	document.getElementById('gizi').reset();
	document.getElementById('tampil_input').style.display='none';
}

 var rek=new DSGridObject("gridbox");
        rek.setHeader(".:SURAT KETERANGAN DOA:.");
        rek.setColHeader("NO,NAMA PASIEN, JENIS KELAMIN,UMUR,TANGGAL MASUK,TGL INPUT,PENGGUNA");
        rek.setIDColHeader(",nama,,usia,tanggal_masuk,tanggal_masuk,dr_rujuk");
        rek.setColWidth("25,130,100,100,200,100,100");
        rek.setCellAlign("center,left,center,center,left,center,center");
        rek.setCellHeight(20);
        rek.setImgPath("../../icon");
        rek.setIDPaging("paging");
        rek.attachEvent("onRowClick","ambilData");
        rek.baseURL("38.surat_keterangan_DOA_util.php?id_pelayanan=<?=$idPel?>&kode=true&saring=");
        rek.Init();
		

function simpan(){
	var act = document.getElementById('simpen').lang;
	var penyakit = $('#penyakit').val();
	var id = $('#id').val();
	var id_pasien ='<?=$dP['id'];?>';
	var tgl_masuk = $('#tgl').val();
	var jam_masuk = $('#jam').val();	
	
	rek.loadURL("38.surat_keterangan_DOA_util.php?kode="+true+"&act="+act+"&id="+id+"&tgl_masuk="+tgl_masuk+"&jam_masuk="+jam_masuk+"&id_pasien="+id_pasien+"&id_pelayanan="+'<?=$idPel ;?>'+"&id_user="+'<?=$dP['id_user'];?>','','GET');
	bersihkan();
}		

function hapus(){
	if(document.getElementById('id').value == '' || document.getElementById('id').value == null) {
		alert('Pilih Data Yang Akan Dihapus');
	}else{
		if (confirm('Apakah Anda yakin Ingin Menghapus Data ?'))
			var act =document.getElementById('simpen').lang='hapus';
			var id = $('#id').val();
			//alert("32.hasilanamnesadiet_util.php?kode="+true+"&act="+act+"&id="+id,'','GET');
			rek.loadURL("38.surat_keterangan_DOA_util.php?kode="+true+"&act="+act+"&id="+id+"&id_pelayanan="+'<?=$idPel; ?>','','GET');
			
	}
} 

</script>

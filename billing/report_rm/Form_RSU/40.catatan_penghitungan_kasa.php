<!--DB = b_form_catatan_penghitung , b_form_catatan_penghitung_detail-->
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
        <script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script type="text/JavaScript">
	var arrRange = depRange = [];
        </script>   
</script>  
       <script type="text/javascript" src="../js/jquery.timeentry.js"></script>
<script type="text/javascript">
$(function () 
{
	$('#jam').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam2').timeEntry({show24Hours: true, showSeconds: true});
});
</script>
    <!-- untuk ajax-->
    
        <title>.: CATATAN PERJITUNGAN KASA/ JARUM/ INSTRUMEN :.</title>
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
    <link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
</head>

<body >
<iframe height="193" width="168" name="gToday:normal:agenda.js"
    id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
    style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
</iframe> 
<iframe height="72" width="130" name="sort"
    id="sort"
    src="../../theme/dsgrid_sort.php" scrolling="no"
    frameborder="0"
    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>

<div id="form_in" align="center" style="display:blok">
    <form id="form1" name="form1" action="40.catatan_penghitung_kasa_act.php">
    	<input type="hidden" name="idPel" value="<?=$idPel?>" />
        <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
        <input type="hidden" name="idPsn" value="<?=$idPsn?>" />
        <input type="hidden" name="idUsr" value="<?=$idUsr?>" />
        <input type="hidden" name="txtId" id="txtId"/>
        <input type="hidden" name="act" id="act" value="tambah"/>
        <table align="center" cellpadding="2" cellspacing="0" style="border-collapse:collapse; border:1px solid #000000;" width="1150">
          <col width="40" />
          <col width="55" />
          <col width="64" span="9" />
          <tr>
            <td style="border-top:#000 1px solid;">&nbsp;</td>
            <td style="border-top:#000 1px solid;">&nbsp;</td>
            <td style="border-top:#000 1px solid;">&nbsp;</td>
            <td style="border-top:#000 1px solid;">&nbsp;</td>
            <td style="border-top:#000 1px solid;">&nbsp;</td>
            <td style="border-top:#000 1px solid;">&nbsp;</td>
            <td style="border-top:#000 1px solid;">&nbsp;</td>
            <td style="border-top:#000 1px solid;">&nbsp;</td>
            <td colspan="4" rowspan="8" style="border-top:#000 1px solid;"><table width="508" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
              <tr>
                <td width="135"><strong>Nama Pasien</strong></td>
                <td colspan="2">:
                  <?=$dP['nama'];?></td>
                <td width="99">&nbsp;</td>
              </tr>
              <tr>
                <td><strong>Tanggal Lahir</strong></td>
                <td width="68">:
                  <?=$dP['tgl_lahir'];?></td>
                <td width="76">Usia</td>
                <td>:
                  <?=$dP['usia'];?>
                  Thn</td>
              </tr>
              <tr>
                <td><strong>No. RM</strong></td>
                <td>:
                  <?=$dP['no_rm'];?></td>
                <td>No Registrasi </td>
                <td>:____________</td>
              </tr>
              <tr>
                <td><strong>Ruang Rawat/Kelas</strong></td>
                <td colspan="2">:
                  <?=$dP['nm_unit'];?>
                  /
                  <?=$dP['nm_kls'];?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><strong>Alamat</strong></td>
                <td colspan="2">:
                  <?=$dP['alamat'];?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4"><center>
                  <strong>(Tempelkan Sticker Identitas Pasien)</strong>
                </center></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td colspan="6" ><div align="center"><strong>PEMERINTAH KOTA MEDAN </strong></div></td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td colspan="6" ><div align="center"><strong>RUMAH SAKIT PELINDO I</strong></div></td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
           <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td colspan="2" ><strong>RUANG OPERASI</strong></td>
            <td ><strong>:</strong></td>
            <td ><label for="r_operasi"></label>
            <input type="text" name="r_operasi" id="r_operasi" /></td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td colspan="6" ><strong>CATATAN PENGHITUNGAN KASA/ JARUM/ INSTRUMEN</strong></td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td colspan="12" style="border-top:#000 1px solid;">&nbsp;</td>
          </tr>
          <tr>
            <td width="1">&nbsp;</td>
            <td colspan="10"><table style="font:12px tahoma; border:1px solid #000;">
              <tr>
                <td width="777" align="center"><div id="intable">
                  <table width="1060" border="1" id="tblkegiatan" cellpadding="2" style="border-collapse:collapse;">
                    <tr style="background:#338FC1">
                      <td colspan="12" align="right"><input type="button" name="button" id="button" value="Tambah" onclick="addRowToTable();return false;"/></td>
                    </tr>
                    <tr style="background:#6CF">
                      <td width="228" align="center"><strong>JENIS</strong></td>
                      <td width="163" align="center"><strong>JUMLAH AWAL</strong></td>
                      <td colspan="5" align="center"><strong>TAMBAHAN</strong></td>
                      <td width="149" align="center"><strong>JUMLAH<BR />SEMENTARA*</strong></td>
                      <td width="64" align="center"><strong>TAMBAHAN</strong></td>
                      <td width="44" align="center"><strong>JUMLAH<BR />AKHIR</strong></td>
                      <td width="210" align="center"><strong>KETERANGAN</strong></td>
                      <td width="16">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="center"><input name="jenis[]" type="text" id="jenis_0" size="35" /></td>
                      <td align="center"><input name="j_awal[]" type="text" id="j_awal_0" size="3" onkeyup="hitung(0)" /></td>
                      <td width="18" align="center"><input name="tambahan1[]" type="text" id="tambahan1_0" size="3" onkeyup="hitung(0)"/></td>
                      <td width="18" align="center"><input name="tambahan2[]" type="text" id="tambahan2_0" size="3" onkeyup="hitung(0)"/></td>
                      <td width="18" align="center"><input name="tambahan3[]" type="text" id="tambahan3_0" size="3" onkeyup="hitung(0)"/></td>
                      <td width="18" align="center"><input name="tambahan4[]" type="text" id="tambahan4_0" size="3" onkeyup="hitung(0)"/></td>
                      <td width="18" align="center"><input name="tambahan5[]" type="text" id="tambahan5_0" size="3" onkeyup="hitung(0)"/></td>
                      <td align="center"><input name="j_sementara[]" type="text" id="j_sementara_0" size="7" readonly="readonly" value="0" /></td>
                      <td align="center"><input name="tambahan[]" type="text" id="tambahan_0" size="3" onkeyup="hitung(0)" /></td>
                      <td align="center"><input name="j_akhir[]" type="text" id="j_akhir_0" size="7" readonly="readonly" value=0 /></td>
                      <td align="center"><input name="keterangan[]" type="text" id="keterangan_0" size="50" /></td>
                      <td align="center" valign="middle"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}" /></td>
                    </tr>
                  </table>
                </div></td>
              </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="153">&nbsp;</td>
            <td width="15"></td>
            <td width="189"></td>
            <td width="63"></td>
            <td width="18"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" rowspan="4"><table width="522" border="1" style="border-collapse:collapse">
              <tr>
                <th width="181" scope="col">&nbsp;</th>
                <th width="155" scope="col">Nama Jelas</th>
                <th width="164" scope="col">Tanda Tangan</th>
              </tr>
              <tr>
                <td>Ahli Bedah</td>
                <td><label for="a_bedah"></label>
                <input type="text" name="a_bedah" id="a_bedah" size="25" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Perawat Instrumen</td>
                <td><input type="text" name="p_instrumen" id="p_instrumen" size="25" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Perawat Sirkuler</td>
                <td><input type="text" name="p_sirkuler" id="p_sirkuler" size="25" /></td>
                <td>&nbsp;</td>
              </tr>
            </table>
            </td>
            <td></td>
            <td>Jumlah kasa</td>
            <td colspan="2">:
              <label>
                <input type="radio" name="jumlah_kasa" value="b" id="jumlah_kasa1"/>
                Benar</label> 
              
              <label>
                /
                <input type="radio" name="jumlah_kasa" value="t" id="jumlah_kasa2" />
              Tidak</label>
             
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td></td>
            <td>Jumlah jarum</td>
            <td colspan="2">: 
              
                <label>
                  <input type="radio" name="jumlah_jarum" value="b" id="jumlah_jarum1" />
                  Benar</label> 
                /
                <label>
                  <input type="radio" name="jumlah_jarum" value="t" id="jumlah_jarum2" />
                  Tidak</label>
                <br />
           </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td></td>
            <td>Jumlah Instrumen</td>
            <td colspan="2">:
             
              <label>
                  <input type="radio" name="jumlah_instrumen" value="b" id="jumlah_instrumen1" />
                  Benar</label> 
              /
                <label>
                  <input type="radio" name="jumlah_instrumen" value="t" id="jumlah_instrumen2" />
              Tidak</label>
                <br />
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td></td>
            <td>Jumlah pisau / <em>Blade</em></td>
            <td colspan="2">:
             
              <label>
                  <input type="radio" name="jumlah_pisau" value="b" id="jumlah_pisau1" />
                  Benar</label> 
              /
                <label>
                  <input type="radio" name="jumlah_pisau" value="t" id="jumlah_pisau2" />
              Tidak</label>
                <br />
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Lain-lain :..................</td>
            <td colspan="2">:</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Jenis Operasi</td>
            <td>:</td>
            <td><label for="j_operasi"></label>
            <input type="text" name="j_operasi" id="j_operasi" /></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Tanggal</td>
            <td>:</td>
            <td>
            	<input name="tgl" type="text" id="tgl" tabindex="4" value="<?php echo $tanggal;?>" size="10" maxlength="15" readonly="true"/>
				<img alt="calender" style="cursor:pointer" border=0 src="../../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);">
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Jam mulai</td>
            <td>:</td>
            <td> <input name="jam" type="text" id="jam" size="10" />&nbsp;
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3">* Jumlah sementara adalah jumlah sebelum kulit/ rongga ditutup</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Jam selesai</td>
            <td>:</td>
            <td>
            	 <input name="jam2" type="text" id="jam2" size="10" />&nbsp;
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td width="145"></td>
            <td width="7"></td>
            <td width="213"></td>
            <td width="12"></td>
            <td width="272"></td>
            <td width="12">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
    </form>
    
    <BR />
    <div align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></div>
</div>
<div id="tampil_data" align="center">
<p>&nbsp;</p>
<table width="755" border="0" cellpadding="4" style="font:12px tahoma;">
<td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="2"><?php
                    if($_REQUEST['report']!=1){
					?>
                      <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus2" name="btnHapus2" value="Edit" onclick="edit();" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>
                  <?php }?>                 </td>
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
                        <div id="paging" style=""></div></td>
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
function toggle() {
   // parent.alertsize(document.body.scrollHeight);
}

function simpan(action){
	if(ValidateForm('a_bedah','ind')){
	$("#form1").ajaxSubmit({
		  success:function(msg)
		  {
			alert(msg);
			batal();
			goFilterAndSort();
		  },
		});
	}
}


function hapus(){
	var rowid = document.getElementById("txtId").value;
	//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
	if(rowid==''){
			alert("Pilih data terlebih dahulu");
		}else if(confirm("Anda yakin menghapus data ini ?")){
			$('#act').val('hapus');
			$("#form1").ajaxSubmit({
			  success:function(msg)
			  {
				alert(msg);
				resetF();
				goFilterAndSort();
			  },
			});
		}
}

function edit(){
	var rowid = document.getElementById("txtId").value;
	//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
	if(rowid==''){
			alert("Pilih data terlebih dahulu");
	}else{
		$('#act').val('edit');
		$('#form_in').slideDown(1000,function(){
			toggle();
			});
		}
}

function batal(){
	resetF();
	$('#form_in').slideUp(1000,function(){
		toggle();
	});
}
		

function tambah(){
	resetF();
		$('#form_in').slideDown(1000,function(){
	toggle();
	});
}


function cetak(){
	 var rowid = document.getElementById("txtId").value;
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if(rowid==''){
			alert("Pilih data terlebih dahulu");
		}else{	
	window.open("40.catatan_penghitungan_kasa_cetak.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
		}
}



function removeRowFromTable(cRow)
{
	var tbl = document.getElementById('tblkegiatan');
	var jmlRow = tbl.rows.length;
	if (jmlRow > 3)
	{
		var i=cRow.parentNode.parentNode.rowIndex;
		//if (i>2){
		tbl.deleteRow(i);
		var lastRow = tbl.rows.length;
		for (var i=3;i<lastRow;i++)
		{
			var tds = tbl.rows[i].getElementsByTagName('td');
			//tds[0].innerHTML=i-2;
		}
	}
}

	var xx=0;
function addRowToTable()
	{
	 xx++;
		//use browser sniffing to determine if IE or Opera (ugly, but required)
		var isIE = false;
		if(navigator.userAgent.indexOf('MSIE')>0){
			isIE = true;
		}
		//	alert(navigator.userAgent);
		//	alert(isIE);
		var tbl = document.getElementById('tblkegiatan');
		var lastRow = tbl.rows.length;
		// if there's no header row in the table, then iteration = lastRow + 1
		var iteration = lastRow;
		var row = tbl.insertRow(lastRow);
		//row.id = 'row'+(iteration-1);
		row.className = 'itemtableA';
		//row.setAttribute('class', 'itemtable');
		row.onmouseover = function(){this.className='itemtableAMOver';};
		row.onmouseout = function(){this.className='itemtableA';};
		
		var cellRight = row.insertCell(0);
		var el;
		var tree;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			el.name = 'jenis[]';
			el.id = 'jenis_'+xx;
		}else{
			el = document.createElement('<input name="jenis[]" id="jenis_'+xx+'"/>');
		}
		el.type = 'text';
		el.value = '';
		el.size = 35;
		

		cellRight.className = 'tdisi';
		cellRight.appendChild(el);
		
		if("<?php echo $edit;?>" == true){
			//generate id
			if(!isIE){
				el = document.createElement('input');
				el.name = 'id';
				el.id = 'id';
			}else{
				el = document.createElement('<input name="id" id="id" />');
			}
			el.type = 'text';
			cellRight.className = 'tdisi';
			cellRight.appendChild(el);
		}

// right cell
		var cellRight = row.insertCell(1);
		var el;
		var tree;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			el.name = 'j_awal[]';
			el.id = 'j_awal_'+xx;
			el.setAttribute("onkeyup","hitung(xx)");
		}else{
			el = document.createElement('<input name="j_awal[]" id="j_awal_'+xx+'" onkeyup="hitung(xx)"/>');
		}
		el.type = 'text';
		el.value = '';
		el.size = 3;
		

		cellRight.className = 'tdisi';
		cellRight.appendChild(el);
		
// right cell
		var cellRight = row.insertCell(2);
		var el;
		var tree;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			el.name = 'tambahan1[]';
			el.id = 'tambahan1_'+xx;
			el.setAttribute("onkeyup","hitung(xx)");
		}else{
			el = document.createElement('<input name="tambahan1[]" id="tambahan1_'+xx+'" onkeyup="hitung(xx)"/>');
		}
		el.type = 'text';
		el.value = '';
		el.size = 3;

		cellRight.className = 'tdisi';
		cellRight.appendChild(el);
		
// right cell
		var cellRight = row.insertCell(3);
		var el;
		var tree;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			el.name = 'tambahan2[]';
			el.id = 'tambahan2_'+xx;
			el.setAttribute("onkeyup","hitung(xx)");
		}else{
			el = document.createElement('<input name="tambahan2[]" id="tambahan2_'+xx+'" onkeyup="hitung(xx)"/>');
		}
		el.type = 'text';
		el.value = '';
		el.size = 3;
		cellRight.className = 'tdisi';
		cellRight.appendChild(el);
		
// right cell
		var cellRight = row.insertCell(4);
		var el;
		var tree;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			el.name = 'tambahan3[]';
			el.id = 'tambahan3_'+xx;
			el.setAttribute("onkeyup","hitung(xx)");
		}else{
			el = document.createElement('<input name="tambahan3[]" id="tambahan3_'+xx+'" onkeyup="hitung(xx)"/>');
		}
		el.type = 'text';
		el.value = '';
		el.size = 3;

		cellRight.className = 'tdisi';
		cellRight.appendChild(el);

// right cell
		var cellRight = row.insertCell(5);
		var el;
		var tree;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			el.name = 'tambahan4[]';
			el.id = 'tambahan4_'+xx;
			el.setAttribute("onkeyup","hitung(xx)");
		}else{
			el = document.createElement('<input name="tambahan4[]" id="tambahan4_'+xx+'" onkeyup="hitung(xx)"/>');
		}
		
		el.type = 'text';
		el.value = '';
		el.size = 3;

		cellRight.className = 'tdisi';
		cellRight.appendChild(el);

		var cellRight = row.insertCell(6);
		var el;
		var tree;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			el.name = 'tambahan5[]';
			el.id = 'tambahan5_'+xx;
			el.setAttribute("onkeyup","hitung(xx)");
		}else{
			el = document.createElement('<input name="tambahan5[]" id="tambahan5_'+xx+'" onkeyup="hitung(xx)"/>');
		}
		
		el.type = 'text';
		el.value = '';
		el.size = 3;

		cellRight.className = 'tdisi';
		cellRight.appendChild(el);
		
		
		//Hitung
		
		
		var cellRight = row.insertCell(7);
		var el;
		var tree;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			el.name = 'j_sementara[]';
			el.id = 'j_sementara_'+xx;
			el.readonly=true;
			
			
		}else{
			el = document.createElement('<input name="j_sementara" id="j_sementara_'+xx+'"/>');
		}
		
		el.type = 'text';
		el.value = 0;
		el.size = 7;

		cellRight.className = 'tdisi';
		cellRight.appendChild(el);
		
		var cellRight = row.insertCell(8);
		var el;
		var tree;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			el.name = 'tambahan[]';
			el.id = 'tambahan_'+xx;
			el.setAttribute("onkeyup","hitung(xx)");
		}else{
			el = document.createElement('<input name="tambahan[]" id="tambahan_'+xx+'" onkeyup="hitung(xx)"/>');
		}
		
		el.type = 'text';
		el.value = '';
		el.size = 3;

		cellRight.className = 'tdisi';
		cellRight.appendChild(el);
		
		var cellRight = row.insertCell(9);
		var el;
		var tree;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			el.name = 'j_akhir[]';
			el.id = 'j_akhir_'+xx;
			el.readonly=true;
		}else{
			el = document.createElement('<input name="j_akhir[]" id="j_akhir_'+xx+'"/>');
		}
		
		el.type = 'text';
		el.value = 0;
		el.size = 7;

		cellRight.className = 'tdisi';
		cellRight.appendChild(el);
		
		var cellRight = row.insertCell(10);
		var el;
		var tree;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			el.name = 'keterangan[]';
			el.id = 'keterangan_'+xx;
		}else{
			el = document.createElement('<input name="keterangan[]" id="keterangan_'+xx+'"/>');
		}
		
		el.type = 'text';
		el.value = '';
		el.size = 50;

		cellRight.className = 'tdisi';
		cellRight.appendChild(el);
// right cell
		
// right cell
			cellRight = row.insertCell(11);
			if(!isIE){
				el = document.createElement('img');
				el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);setDisable("del")}');
			}else{
				el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
			}
			el.src = '../../icon/del.gif';
			el.border = "0";
			el.width = "16";
			el.height = "16";
			el.className = 'proses';
			el.align = "absmiddle";
			el.title = "Klik Untuk Menghapus";

			//  cellRight.setAttribute('class', 'tdisi');
			cellRight.className = 'tdisi';
			cellRight.appendChild(el);

}

function goFilterAndSort(grd){
	a.loadURL("40.catatan_penghitungan_kasa_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
}

function konfirmasi(key,val){
	//alert(val);
	/*var tangkap=val.split("*|*");
	var proses=tangkap[0];
	var alasan=tangkap[1];
	if(key=='Error'){
		if(proses=='hapus'){				
			alert('Tidak bisa menambah data karena '+alasan+'!');
		}              

	}
	else{
		if(proses=='tambah'){
			alert('Tambah Berhasil');
		}
		else if(proses=='simpan'){
			alert('Simpan Berhasil');
		}
		else if(proses=='hapus'){
			alert('Hapus Berhasil');
		}
	}*/

}

		
var a=new DSGridObject("gridbox");
a.setHeader("CATATAN PENGHITUNGAN KASA/ JARUM/ INSTRUMEN");
a.setColHeader("NO,NAMA PASIEN,JENIS OPERASI,RUANG OPERASI,TGL INPUT,PENGGUNA");
a.setIDColHeader(",nama,jenis_operasi,ruang_operasi,tgl_act,nama_user");
a.setColWidth("50,100,300,80,100,100");
a.setCellAlign("center,center,left,center,center,center");
a.setCellHeight(20);
a.setImgPath("../../icon");
a.setIDPaging("paging");
a.attachEvent("onRowClick","ambilData");
a.onLoaded(konfirmasi);
a.baseURL("40.catatan_penghitungan_kasa_util.php?idPel=<?=$idPel?>");
a.Init();

function ambilData(){		
	var sisip = a.getRowId(a.getSelRow()).split('|');
	$('#j_operasi').val(a.cellsGetValue(a.getSelRow(),3));
	$('#r_operasi').val(a.cellsGetValue(a.getSelRow(),4));
	$('#a_bedah').val(sisip[1]);
	$('#p_instrumen').val(sisip[2]);
	$('#p_sirkuler').val(sisip[3]);
	$('#tgl').val(sisip[4]);
	$('#jam').val(sisip[5]);
	$('#jam2').val(sisip[6]);
	$('#txtId').val(sisip[0]);
	$('#intable').load("40.tabel_catatan.php?type=cek&id="+sisip[0]);
	
	var jk = sisip[7];
	if(jk=='b'){
		document.getElementById('jumlah_kasa1').checked=true;
	}else if(jk=='t'){
		document.getElementById('jumlah_kasa2').checked=true;
	}
	
	var jj = sisip[8];
	if(jj=='b'){
		document.getElementById('jumlah_jarum1').checked=true;
	}else if(jj=='t'){
		document.getElementById('jumlah_jarum2').checked=true;
	}
	
	var ji = sisip[9];
	if(ji=='b'){
		document.getElementById('jumlah_instrumen1').checked=true;
	}else if(ji=='t'){
		document.getElementById('jumlah_instrumen2').checked=true;
	}
	
	var jp = sisip[10];
	if(jp=='b'){
		document.getElementById('jumlah_pisau1').checked=true;
	}else if(jp=='t'){
		document.getElementById('jumlah_pisau2').checked=true;
	}
	
	$('#act').val('edit');
	//alert(a.cellsGetValue(a.getSelRow(),3));
}

function hapus(){
	var rowid = document.getElementById("txtId").value;
	//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
	if(rowid==''){
			alert("Pilih data terlebih dahulu");
		}else if(confirm("Anda yakin menghapus data ini ?")){
			$('#act').val('hapus');
			$("#form1").ajaxSubmit({
			  success:function(msg)
			  {
				alert(msg);
				resetF();
				goFilterAndSort();
			  },
			});
		}

}
function resetF(){
	$('#act').val('tambah');
	$('#txtId').val('');
	document.getElementById("form1").reset();
	$('#intable').load("40.tabel_catatan.php?type=cek");
}

function hitung(x){
	
	var ja = parseInt($('#j_awal_'+x).val());
	var t1 = $('#tambahan1_'+x).val();
	var t2 = $('#tambahan2_'+x).val();
	var t3 = $('#tambahan3_'+x).val();
	var t4 = $('#tambahan4_'+x).val();
	var t5 = $('#tambahan5_'+x).val();
	var js = $('#j_sementara_'+x).val();
	var ta = $('#tambahan_'+x).val();
	var t1x, t2x, t3x, t4x, t5x, jax, jsx, tax;

	if(t1==''){
		t1x=0;
	}else{
		t1x=parseInt(t1);
	}
	
	if(t2==''){
		t2x=0;
	}else{
		t2x=parseInt(t2);
	}
	
	if(t3==''){
		t3x=0;
	}else{
		t3x=parseInt(t3);
	}
	
	if(t4==''){
		t4x=0;
	}else{
		t4x=parseInt(t4);
	}
	
	if(t5==''){
		t5x=0;
	}else{
		t5x=parseInt(t5);
	}
	
	if(ta==''){
		tax=0;
	}else{
		tax=parseInt(ta);
	}
	
	var sum = ja+t1x+t2x+t3x+t4x+t5x;
	$('#j_sementara_'+x).val(sum);
	
	var sumak = sum+tax;
	$('#j_akhir_'+x).val(sumak);
	
}

</script>
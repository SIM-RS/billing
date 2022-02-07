<?php
//session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/javascript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
<title>Pemakaian Obat</title>
<style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:80px;
	}
.textArea{ width:97%;}
body{background:#FFF;}
        </style>
</head>
<?
//include "setting.php";
?>
<style>

.gb{
	border-bottom:1px solid #000000;
}
</style>
<body>
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
<div align="center" id="form_in" style="display:none;">
<form name="form1" id="form1" action="pemakaian_obat_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="932" height="226" border="0" style="font:12px tahoma;">
  <tr>
    <td colspan="5" valign="middle"><img src="lambang.png" width="278" height="30" /></td>
    <td colspan="5" rowspan="2"><table width="350" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">:
          <?=$dP['nama'];?></td>
        <td width="75">&nbsp;</td>
        <td width="104">&nbsp;</td>
        </tr>
      <tr>
        <td>No. RM</td>
        <td>:
          <?=$dP['no_rm'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" valign="middle"><span style="font:bold 15px tahoma;">PEMAKAIAN OBAT/ALKES ANASTESI</span></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="102" >Tanggal</td>
    <td >:</td>
    <td colspan="3" ><label for="textfield"></label>
      <input name="tgl" type="text" id="tgl" size="10" onclick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" /></td>
    <td colspan="5" >&nbsp;</td>
  </tr>
  <tr>
    <td >Dokter</td>
    <td >:</td>
    <td colspan="6" ><select name="dokter" id="dokter">
      <option value="">Pilih</option>
      <?php
          $sql="select * from b_ms_pegawai where spesialisasi_id<>0";
          $query = mysql_query ($sql);
          while($data = mysql_fetch_array($query)){
		  ?>
      <option value="<?php echo $data['id'];?>" ><?php echo $data['nama']?></option>
      <?php
    	  }
	      ?>
    </select></td>
    <td width="90" >&nbsp;</td>
    <td width="2" >&nbsp;</td>
  </tr>
  <tr>
    <td >Jenis Operasi</td>
    <td >:</td>
    <td colspan="5" ><label for="textfield"></label>
      <input type="text" name="jenis_operasi" id="jenis_operasi" /></td>
    <td width="90" >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td width="7" >&nbsp;</td>
    <td width="229" >&nbsp;</td>
    <td width="143" >&nbsp;</td>
    <td width="133" >&nbsp;</td>
    <td width="90" >&nbsp;</td>
    <td width="90" >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="10">
  <form>
    <table width="919" height="202" align="center" cellspacing="0" >
      <col width="27" />
      <col width="64" />
      <col width="20" />
      <col width="138" />
      <col width="20" />
      <col width="64" />
      <col width="51" />
      <col width="99" />
      <col width="13" />
      <col width="92" />
      <col width="49" />
      <col width="58" />
      <col width="54" />
      <col width="37" />
      <tr height="20">
        <td width="423" height="20"><table width="500" border="1" style=" border-collapse:collapse">
          <tr>
            <td width="40" align="center"><strong>NO</strong></td>
            <td width="300" align="center"><strong>MEDICINE</strong></td>
            <td width="138" align="center"><strong>PEMAKAIAN</strong></td>
          </tr>
          <tr>
            <td align="center">1</td>
            <td>(SC) Methergin/Syntocinon</td>
            <td><label for="textfield2"></label>
              <input type="text" name="a" id="a" /></td>
          </tr>
          <tr>
            <td align="center">2</td>
            <td>(Sp) Mafcain Heavy/Buvanest</td>
            <td><label for="textfield5"></label>
              <input type="text" name="b" id="b" /></td>
          </tr>
          <tr>
            <td align="center">3</td>
            <td>Adona 50 Mg/Dicynon/Transamin</td>
            <td><label for="textfield6"></label>
              <input type="text" name="c" id="c" /></td>
          </tr>
          <tr>
            <td align="center">4</td>
            <td>Atropin Sulfat/Prostigmin/Efedrin</td>
            <td><label for="textfield7"></label>
              <input type="text" name="d" id="d" /></td>
          </tr>
          <tr>
            <td align="center">5</td>
            <td>Oradexon/Kalmetasan</td>
            <td><label for="textfield8"></label>
              <input type="text" name="e" id="e" /></td>
          </tr>
          <tr>
            <td align="center">6</td>
            <td>Dormicum/Midazolam</td>
            <td><label for="textfield9"></label>
              <input type="text" name="f" id="f" /></td>
          </tr>
          <tr>
            <td align="center">7</td>
            <td>Fentanyl/Sufenta/Pethidine/Morphin</td>
            <td><label for="textfield10"></label>
              <input type="text" name="g" id="g" /></td>
          </tr>
          <tr>
            <td align="center">8</td>
            <td>Fima Haes/Haemacel</td>
            <td><label for="textfield11"></label>
              <input type="text" name="h" id="h" /></td>
          </tr>
          <tr>
            <td align="center">9</td>
            <td>Ketalar</td>
            <td><label for="textfield12"></label>
              <input type="text" name="i" id="i" /></td>
          </tr>
          <tr>
            <td align="center">10</td>
            <td>Lidocain/Catapres</td>
            <td><label for="textfield13"></label>
              <input type="text" name="j" id="j" /></td>
          </tr>
          <tr>
            <td align="center">11</td>
            <td>Nad 25 Ml/100 Ml/250 Ml/500 Ml</td>
            <td><label for="textfield14"></label>
              <input type="text" name="k" id="k" /></td>
          </tr>
          <tr>
            <td align="center">12</td>
            <td>Narfoz 4 Mg/Narfoz 8 Mg/ Primperan</td>
            <td><label for="textfield15"></label>
              <input type="text" name="l" id="l" /></td>
          </tr>
          <tr>
            <td align="center">13</td>
            <td>Novalgin/Remopain/Tramal</td>
            <td><label for="textfield16"></label>
              <input type="text" name="m" id="m" /></td>
          </tr>
          <tr>
            <td align="center">14</td>
            <td>Rantin/Ranitidine</td>
            <td><label for="textfield17"></label>
              <input type="text" name="n" id="n" /></td>
          </tr>
          <tr>
            <td align="center">15</td>
            <td>Recofol/Pentothal</td>
            <td><label for="textfield18"></label>
              <input type="text" name="o" id="o" /></td>
          </tr>
          <tr>
            <td align="center">16</td>
            <td>Rl/Asering/Dex 5%/rd</td>
            <td><label for="textfield19"></label>
              <input type="text" name="p" id="p" /></td>
          </tr>
          <tr>
            <td align="center">17</td>
            <td>Xylocain Inj/Adrenalin</td>
            <td><label for="textfield20"></label>
              <input type="text" name="q" id="q" /></td>
          </tr>
          <tr>
            <td align="center">18</td>
            <td>Stesolid 5 Mg/10 Mg/Dumin 125 Mg/250 Rectal</td>
            <td><label for="textfield21"></label>
              <input type="text" name="r" id="r" /></td>
          </tr>
          <tr>
            <td align="center">19</td>
            <td>Tracrium/Esmeron/Roculax</td>
            <td><label for="textfield22"></label>
              <input type="text" name="s" id="s" /></td>
          </tr>
          <tr>
            <td align="center">20</td>
            <td>Vit. C/Vit. K</td>
            <td><label for="textfield23"></label>
              <input type="text" name="t" id="t" /></td>
          </tr>
          <tr>
            <td align="center">21</td>
            <td>Voltaren Supp/Pronalges Supp/Felden Supp</td>
            <td><label for="textfield24"></label>
              <input type="text" name="u" id="u" /></td>
          </tr>
        </table></td>
        <td width="13">&nbsp;</td>
        <td width="475" colspan="7" valign="top"><table width="500" border="1" align="right" style=" border-collapse:collapse">
          <tr>
            <td width="40" align="center"><strong>NO</strong></td>
            <td width="300" align="center"><strong>MEDICINE</strong></td>
            <td width="138" align="center"><strong>PEMAKAIAN</strong></td>
          </tr>
          <tr>
            <td align="center">1</td>
            <td>Spuit 1/3/5/10/20/50</td>
            <td><label for="textfield3"></label>
              <input type="text" name="v" id="v" /></td>
          </tr>
          <tr>
            <td align="center">2</td>
            <td>Ett 6,5/7/7,5</td>
            <td><label for="textfield25"></label>
              <input type="text" name="w" id="w" /></td>
          </tr>
          <tr>
            <td align="center">3</td>
            <td>Ett Nkk 6,5/7/7,5</td>
            <td><label for="textfield26"></label>
              <input type="text" name="x" id="x" /></td>
          </tr>
          <tr>
            <td align="center">4</td>
            <td>Ext. Tube/Discofic</td>
            <td><label for="textfield27"></label>
              <input type="text" name="y" id="y" /></td>
          </tr>
          <tr>
            <td align="center">5</td>
            <td>Intrafix/Tegaderm 1627/Swab Alkohol</td>
            <td><label for="textfield28"></label>
              <input type="text" name="z" id="z" /></td>
          </tr>
          <tr>
            <td align="center">6</td>
            <td>Vasofix 16/18/20</td>
            <td><label for="textfield29"></label>
              <input type="text" name="aa" id="aa" /></td>
          </tr>
          <tr>
            <td align="center">7</td>
            <td>Slang O2 Adult/Suction 12</td>
            <td><label for="textfield30"></label>
              <input type="text" name="bb" id="bb" /></td>
          </tr>
          <tr>
            <td align="center">8</td>
            <td>Elek Blue Sensor</td>
            <td><label for="textfield31"></label>
              <input type="text" name="cc" id="cc" /></td>
          </tr>
          <tr>
            <td align="center">9</td>
            <td>Gluve Steril No.7/7,5</td>
            <td><label for="textfield32"></label>
              <input type="text" name="dd" id="dd" /></td>
          </tr>
          <tr>
            <td align="center">10</td>
            <td>Ngt 14,16,18/Urine Bag</td>
            <td><label for="textfield33"></label>
              <input type="text" name="ee" id="ee" /></td>
          </tr>
          <tr>
            <td align="center">11</td>
            <td>Spinal 26 (Bb)</td>
            <td><label for="textfield34"></label>
              <input type="text" name="ff" id="ff" /></td>
          </tr>
          <tr>
            <td align="center">12</td>
            <td>Sevorene/Isoflurance</td>
            <td><label for="textfield35"></label>
              <input type="text" name="gg" id="gg" /></td>
          </tr>
          <tr>
            <td align="center">13</td>
            <td>Oxygen/N2O</td>
            <td><label for="textfield36"></label>
              <input type="text" name="hh" id="hh" /></td>
          </tr>
          <tr>
            <td align="center">14</td>
            <td>Rebreathing Slang</td>
            <td><label for="textfield37"></label>
              <input type="text" name="ii" id="ii" /></td>
          </tr>
          <tr>
            <td align="center">15</td>
            <td>Laringeal Mask (Lm)</td>
            <td><label for="textfield4"></label>
              <input type="text" name="jj" id="jj" /></td>
          </tr>
        </table></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td colspan="3" valign="top">Medan, <?php echo date("j F Y")?></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td colspan="3" align="center" valign="top">Perawat Ruangan</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td colspan="3" align="center" valign="top">(<strong><?=$dP['dr_rujuk'];?></strong>)</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
    </table>
    </form>
      <br>
      <div align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
        <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></div>
      </td>
  </tr>
</table>
</form>
</div>

<div id="tampil_data" align="center">
<table width="755" border="0" cellpadding="4" style="font:12px tahoma;">
<td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="2">
                      <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>                    </td>
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
                        <div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div></td>
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
<script type="text/javascript">

		function toggle() {
    //parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('tgl,dokter')){
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
        
        function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }

        //isiCombo('cakupan','','','cakupan','');

        /*function setCakupan(val){
            if(val == 4){
                document.getElementById('tr_cakupan').style.display = 'table-row';
            }
            else{
                document.getElementById('tr_cakupan').style.display = 'none';
            }
        }*/

        function ambilData(){		
            var sisip = a.getRowId(a.getSelRow()).split('|');
			//$('#txt_anjuran').val(a.cellsGetValue(a.getSelRow(),3));
			$('#id').val(sisip[0]);
			$('#tgl').val(sisip[1]);
			$('#dokter').val(sisip[2]);
			$('#jenis_operasi').val(sisip[3]);
			$('#a').val(sisip[4]);
			$('#b').val(sisip[5]);
			$('#c').val(sisip[6]);
			$('#d').val(sisip[7]);
			$('#e').val(sisip[8]);
			$('#f').val(sisip[9]);
			$('#g').val(sisip[10]);
			$('#h').val(sisip[11]);
			$('#i').val(sisip[12]);
			$('#j').val(sisip[13]);
			$('#k').val(sisip[14]);
			$('#l').val(sisip[15]);
			$('#m').val(sisip[16]);
			$('#n').val(sisip[17]);
			$('#o').val(sisip[18]);
			$('#p').val(sisip[19]);
			$('#q').val(sisip[20]);
			$('#r').val(sisip[21]);
			$('#s').val(sisip[22]);
			$('#t').val(sisip[23]);
			$('#u').val(sisip[24]);
			$('#v').val(sisip[25]);
			$('#w').val(sisip[26]);
			$('#x').val(sisip[27]);
			$('#y').val(sisip[28]);
			$('#z').val(sisip[29]);
			$('#aa').val(sisip[30]);
			$('#bb').val(sisip[31]);
			$('#cc').val(sisip[32]);
			$('#dd').val(sisip[33]);
			$('#ee').val(sisip[34]);
			$('#ff').val(sisip[35]);
			$('#gg').val(sisip[36]);
			$('#hh').val(sisip[37]);
			$('#ii').val(sisip[38]);
			$('#jj').val(sisip[39]);
			//cek(sisip[4]);
			$('#act').val('edit');
        }

        function hapus(){
            var rowid = document.getElementById("id").value;
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
            var rowid = document.getElementById("id").value;
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
			//resetF();
			$('#form_in').slideUp(1000,function(){
		//toggle();
		});
        }
		
		function resetF(){
			$('#act').val('tambah');
			$('#id').val('');
			document.form1.reset();
           
			//centang(1,'L')
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

        function goFilterAndSort(grd){
            //alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("pemakaian_obat_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Pemakaian Obat / Alkes Anestesi");
        a.setColHeader("NO,NO RM,Dokter,Jenis Operasi,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,,,,");
        a.setColWidth("50,100,300,300,100,100");
        a.setCellAlign("center,center,left,left,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("pemakaian_obat_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#form_in').slideDown(1000,function(){
		toggle();
		});
			
			}
		
		function cetak(){
		 var rowid = document.getElementById("id").value;
		 if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("pemakaian_obat_cetak.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}
		
		
		function cek(tes){
		var list=tes.split('*=*');
		var list1 = document.form1.elements['c_chk[]'];
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			var val=list[0].split(',');
			  if (list1[i].value==val[i])
			  {
			   list1[i].checked = true;
			  }else{
					list1[i].checked = false;
					}
		  }
		}
		}
		
/*function centang(tes,tes2){
		 var checkbox = document.form1.elements['rad_thd'];
		 var checkboxlp = document.form1.elements['rad_lp'];
		 
		 if ( checkbox.length > 0 )
		{
		 for (i = 0; i < checkbox.length; i++)
			{
			  if (checkbox[i].value==tes)
			  {
			   checkbox[i].checked = true;
			  }
		  }
		}
		if ( checkboxlp.length > 0 )
		{
		 for (i = 0; i < checkboxlp.length; i++)
			{
			  if (checkboxlp[i].value==tes2)
			  {
			   checkboxlp[i].checked = true;
			  }
		  }
		}
	}*/
    </script>
</html>

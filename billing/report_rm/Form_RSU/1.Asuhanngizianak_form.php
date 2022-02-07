<?php
//session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUsr'];
$qUser = "Select * from b_ms_pegawai where id = '$idUser'";
$execqUser = mysql_query($qUser);
$dUser = mysql_fetch_array($execqUser);
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk,
CONCAT((CONCAT((CONCAT((CONCAT(p.alamat,' RT.',p.rt)),' RW.',p.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama) alamat_, bk.umur_thn, bk.umur_bln
FROM b_pelayanan pl 
INNER JOIN b_kunjungan bk ON bk.id = pl.kunjungan_id
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_wilayah w
		ON p.desa_id = w.id
	LEFT JOIN b_ms_wilayah wi
		ON p.kec_id = wi.id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
WHERE pl.id='$idPel';";
//echo $sqlP;
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT DATE_FORMAT(tk.tgl_in, '%d-%m-%Y') AS tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
//echo $sqlKm;
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
        <!-- end untuk ajax-->
        <title>Asuhan Gizi</title>
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
    <body>
        <div align="center">
            <?php
           // include("../../header1.php");
            ?>
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
          <!--  <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM RESUM MEDIS</td>
                </tr>
            </table>-->
            <table width="1000" border="0" cellspacing="0" cellpadding="2" align="center" >
                <tr>
                    <td colspan="13">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="12" align="center"><div id="form_in" style=" display:none;">
                <form name="form1" id="form1" action="1.Asuhanngizianak_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUser?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
                
                <table width="775" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td width="153"><div align="right">Nama Pasien </div></td>
    <td width="9">:</td>
    <td width="299"><?=$dP['nama']?>&nbsp;&nbsp;<span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
  </tr>
  <tr>
    <td><div align="right">Tanggal Lahir </div></td>
    <td> : </td>
    <td><?=tglSQL($dP['tgl_lahir'])?> Usia : <?=$dP['umur_thn']?> Thn <?=$dP['umur_bln']?> Bln</td>
  </tr>
  <tr>
    <td><div align="right">No. RM </div></td>
    <td>:</td>
    <td><?=$dP['no_rm']?></td>
  </tr>
  <tr>
    <td><div align="right">Ruang Rawat/Kelas </div></td>
    <td>:</td>
    <td><?=$dP['nm_unit'];?>&nbsp;/&nbsp;<?=$dP['nm_kls'];?></td>
  </tr>
  <tr>
    <td><div align="right">Alamat</div></td>
    <td>:</td>
    <td><?=$dP['alamat_']?></td>
  </tr>
  <tr>
    <td colspan="13">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="13">Asuhan Gizi</td>
  </tr>
  
  <tr style="border:1px solid">
    <td colspan="13"><table cellspacing="0" cellpadding="2" style="border:1px solid #000000;">
      <col width="64" />
      <col width="20" />
      <col width="132" />
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
        <td height="20" width="65">A.</td>
        <td colspan="13">&nbsp;IDENTITAS UMUM</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">Nama</td>
        <td width="9">:</td>
        <td colspan="9" class="gb"><?=$dP['nama']?></td>
		<td width="15">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">No R.M</td>
        <td>:</td>
        <td colspan="9" class="gb"><?=$dP['no_rm']?></td>
		<td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">Umur</td>
        <td>:</td>
        <td colspan="9" class="gb"><?=$dP['umur_thn']?> Thn <?=$dP['umur_bln']?> Bln</td>
		<td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">Jenis Kelamin</td>
        <td>:</td>
        <td colspan="9" class="gb"><?=$dP['sex'];?></td>
		<td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">Ruang/Kelas</td>
        <td>:</td>
        <td colspan="9" class="gb"><?=$dP['nm_unit'];?>&nbsp;/&nbsp;<?=$dP['nm_kls'];?></td>
		<td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">Tanggal Masuk</td>
        <td>:</td>
        <td colspan="9" class="gb"><?=$dK['tgl_in'];?></td>
		<td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">Tanggal Skrining</td>
        <td>:</td>
        <td colspan="9" ><input type="text" id="tgl" name="tgl" onclick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" size="10"></input></td>
		<td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="14">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">B.</td>
        <td colspan="13">DATA ANTROPOMETRI</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">BB</td>
        <td>:</td>
        <td width="43" >
			<? 
				if($dP['bb2'] == "")
				{
					?>
                    <input type="text" id="nBB" name="nBB" size="5" class="txtInput" value="0" />
                    <?
				}else{
					echo $dP['bb2'];
				}
			?>
        </td>
        <td width="105" >kg</td>
        <td colspan="8">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td width="118">TB</td>
        <td width="22"></td>
        <td>:</td>
        <td >
			<? 
				if($dP['tb2'] == "")
				{
					?>
                    <input type="text" size="5" id="nTB" name="nTB" class="txtInput" value="0" />
                    <?
				}else{
					echo $dP['tb2'];
				}
			?>
        </td>
        <td >cm</td>
        <td colspan="8">&nbsp;</td>
      </tr>
	  <?php
	  if($dP['tb2'] == "")
	  {
		  $bagi=0;
	  }else{
		  $bagi=$dP['bb2']/$dP['tb2'];
	  }
	  ?>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">BB/TB</td>
        <td>:</td>
        <td ><input type="text" id="bbtb" name="bbtb" size="5" ></td>
        <td >(z-score)</td>
        <td colspan="8">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">LLA (Lingkar Lengan Atas)</td>
        <td>:</td>
        <td ><input type="text" id="lla" name="lla" size="5" ></td>
        <td >cm</td>
        <td colspan="8">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="14">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">C.&nbsp;</td>
        <td colspan="13">ASUPAN MAKANAN SEBELUM MASUK RUMAH SAKIT</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="12" ><textarea name="asupan_makanan" cols="45" rows="5" class="textArea" id="asupan_makanan"></textarea></td>
		<td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="14">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">D.</td>
        <td colspan="13">KESAN</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="13"><label for="kesan"></label>
          <select name="kesan" id="kesan">
           <option value="">Pilih</option>
            <option>Tidak Beresiko Malnutrisi</option>
            <option>Beresiko Malnutrisi</option>
            <option>Malnutrisi</option>
          </select></td>
        </tr>
      <tr height="20">
        <td height="20" colspan="14">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="13">PERLU ATAU TIDAK PERLU ASUHAN GIZI LANJUT</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="12"><textarea name="gizi_lanjut" cols="45" rows="5" class="textArea" id="gizi_lanjut"></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="14">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="14">Diagnosa penyakit :</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="12" ><table width="100%" border="0">
          <?php $sqlD="SELECT md.nama FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE d.kunjungan_id='$idKunj';";
$exD=mysql_query($sqlD);
while($dD=mysql_fetch_array($exD)){
?>
          <tr>
            <td ><?=$dD['nama']?></td>
          </tr>
          <?php }?>
          <tr>
            <td >&nbsp;</td>
          </tr>
        </table></td>
		<td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="14">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="14">Diit Dokter</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="12" ><textarea name="diit_dokter" cols="45" rows="5" class="textArea" id="diit_dokter"></textarea></td>
        <td>&nbsp;</td>
      </tr>
  <tr>
    <td colspan="14">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="14">Medan, <?=date('j ').getBulan(date('m')).date(' Y')?></td>
  </tr>
  <tr>
    <td colspan="14">Ahli Gizi : </td>
  </tr>
  <tr>
    <td height="55" colspan="14">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="14">(<strong>
      <?=$dUser['nama'];?>
    </strong>)</td>
  </tr>
  <tr>
    <td colspan="14">Tanda Tangan dan Nama Jelas </td>
  </tr>
	  </table></td>
  </tr>
</table>
             </form>   
             <div align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></div>
                </div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%"><?php
                    if($_REQUEST['report']!=1){
					?>
                        <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>
                  <?php }?></td>
                    <td width="20%"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
  <!--    <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr>
                    <td height="30">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;"/></td>
                    <td></td>
                    <td align="right">
                        <a href="<?=$host?>/simrs-tangerang/billing/index.php">
                            <input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;"/>
                        </a>&nbsp;
                    </td>
        </tr>
          </table>-->
        </div>
    </body>
<script type="text/javascript">

		function toggle() {
    parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('asupan_makanan')){
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
			$('#asupan_makanan').val(sisip[2]);
			$('#kesan').val(sisip[3]);
			$('#gizi_lanjut').val(sisip[4]);
			$('#diagnosa_gizi_anak').val(sisip[5]);
			$('#diit_dokter').val(sisip[6]);
			$('#bbtb').val(sisip[7]);
			$('#lla').val(sisip[8]);
			$('#nBB').val(sisip[9]);
			$('#nTB').val(sisip[10]);
			
			/*$('#txt_biokimia_eval').val(sisip[4]);
			$('#txt_fisik').val(sisip[5]);
			$('#txt_fisik_eval').val(sisip[6]);
			$('#txt_gizi').val(sisip[7]);
			$('#txt_gizi_eval').val(sisip[8]);
			$('#txt_RwytPersonal').val(sisip[9]);
			$('#txt_RwytPersonal_eval').val(sisip[10]);
			$('#txt_diagnosa').val(a.cellsGetValue(a.getSelRow(),3));
			$('#txt_intervensi').val(a.cellsGetValue(a.getSelRow(),4));
			$('#txt_monev').val(a.cellsGetValue(a.getSelRow(),5));*/
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
			resetF();
			$('#form_in').slideUp(1000,function(){
		toggle();
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
            a.loadURL("1.Asuhanngizianak_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Asuhan Gizi");
        a.setColHeader("NO,NO RM,Asupan,Gizi,Diagnosa Gizi,Diit Dokter,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,,,,");
        a.setColWidth("50,100,300,300,300,100,100,100");
        a.setCellAlign("center,center,left,left,left,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("1.Asuhanngizianak_util.php?idPel=<?=$idPel?>");
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
		window.open("1.Asuhanngizianak.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUser?>","_blank");
				//}
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

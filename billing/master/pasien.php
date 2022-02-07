<?php

include("../sesi.php");
?>
<?php
//session_start();
$userId = $_SESSION['userId'];
include '../koneksi/konek.php';
?>
<html>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <head>
        <title>Manajemen Data Pasien</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="Cache-Control" content="no-cache, must-revalidate" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <link rel="shortcut icon" href="../icon/favicon.ico" type="image/x-icon" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script src="../theme/dhtmlxcalendar.js" type="text/javascript"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!-- end untuk ajax-->
    </head>
    <body>
        <iframe height="72" width="130" name="sort"
                id="sort"
                src="../theme/dsgrid_sort.php" scrolling="no"
                frameborder="0"
                style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
        <div align="center">
            <?php
            //include "../header1.php";
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            ?>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2" align="center">
                <tr>
                    <td height="30" class="tblatas">&nbsp;FORM MANAJEMEN DATA PASIEN</td>
                    <td width="35" class="tblatas">
                        <a href="../index.php">
                            <img alt="close" src="../icon/x.png" style="cursor: pointer" border="0" width="32" />
                        </a>
                    </td>
                </tr>
            </table>
            <table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
                <tr>
                    <td colspan="7">&nbsp;</td>
                </tr>
                <tr>
                    <td width="9">&nbsp;</td>
                    <td width="98" align="right">No RM :&nbsp;</td>
                    <td width="247">
                        <input type="text" name="NoRm" id="NoRm" size="20" class="txtinputreg" tabindex="1" onKeyUp="listPasien(event,'show',this.id)"/>
                        <!--input type="button" value="NEW No RM" class="btninputreg" onClick="getNoRM()" /-->
                        <textarea cols="5" rows="5" style="display:none;" id="txtNoRM"></textarea>
                        <input id="txtIdPasien" name="txtIdPasien" type="hidden"/>
                        <input id="txtIdKsoPasien" name="txtIdKsoPasien" type="hidden"/>     
                    </td>
                    <td width="162">&nbsp;</td>
                    <td width="186" align="right">Nama Ortu :&nbsp;</td>
                    <td width="288"><input type="text" name="NmOrtu" id="NmOrtu" size="30" tabindex="7" class="txtinputreg" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">No. KTP :&nbsp;</td>
                    <td colspan="2"><input name="NoKTP" id="NoKTP" size="20" class="txtinputreg" tabindex="1"/>
                    </td>
                    <td align="right">Nama Suami / Istri :&nbsp;</td>
                    <td><input type="text"  class="txtinputreg" name="NmSuTri" id="NmSuTri" size="30" tabindex="8" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Nama :&nbsp;</td>
                    <td colspan="3"><input type="text" class="txtinputreg" name="Nama" id="Nama" size="40" tabindex="3" onKeyUp="listPasien(event,'show',this.id)"/></td>
                    <td align="right">&nbsp;</td>
                    <td width="5" align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Jenis Kelamin :&nbsp;</td>
                    <td><select name="Gender" id="Gender" tabindex="4"  class="txtinputreg">
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option></select>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right">Alamat :&nbsp;</td>
                    <td><input type="text" class="txtinputreg" name="Alamat" id="Alamat" size="30" onKeyUp="listPasien(event,'show',this.id)" tabindex="15" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Tgl Lahir :&nbsp;</td>
                    <td colspan="2">
                        <input type="text" class="txtcenter" readonly="readonly" name="TglLahir" id="TglLahir" size="11" tabindex="9" />
                        <input type="button" name="ButtonTglLahir" value=" V " tabindex="10" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('TglLahir'),depRange,gantiUmur);" />
                        &nbsp;&nbsp;Umur :&nbsp;<input type="text" style="text-align:center;" class="txtinputreg" name="th" id="th" size="3" tabindex="11" onKeyUp="gantiTgl()"/>
                        &nbsp;Th&nbsp;&nbsp;<input type="text" style="text-align:center;" class="txtinputreg" name="Bln" id="Bln" size="3" tabindex="12" onKeyUp="gantiTgl(this.id)"/>&nbsp;Bln
                    </td>
                    <td align="right">RT :&nbsp;</td>
                    <td align="left"><input type="text" class="txtinputreg" id="rt" name="rt" size="3" tabindex="16" />
			RW : <input type="text" class="txtinputreg" id="rw" name="rw" size="3" tabindex="17" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Agama :&nbsp;</td>
                    <td colspan="2"><select id="cmbAgama" tabindex="13" name="cmbAgama" class="txtinputreg">
                    <option>Islam</option>
                    </select>&nbsp;&nbsp;&nbsp;  </td>
                    
                    <td align="right">Propinsi :&nbsp;</td>
                    <td><select id="cmbProp" name="cmbProp" onChange="isiKab()" tabindex="18" class="txtinputreg">
                      <option value=''>-Propinsi-</option>
                    </select></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Telp :&nbsp;</td>
                    <td colspan="2">
                      

                        <div id="div_pasien" align="center" class="div_pasien"></div>
                   <input type="text" tabindex="14" class="txtinputreg" id="telp" name="telp" size="15"/> </td>
                    <td align="right">Kabupaten/Kota :&nbsp;</td>
                    <td><select id="cmbKab" name="cmbKab" onChange="isiKec()" tabindex="19" class="txtinputreg">
                            <option value=''>-Kabupaten-</option>
                        </select></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">&nbsp;Pendidikan :&nbsp;</td>
                    <td colspan="2"><select name="Pendidikan" id="Pendidikan" tabindex="5" class="txtinputreg"></select></td>
                    <td align="right">Kecamatan :&nbsp;</td>
                    <td><select id="cmbKec" name="cmbKec" onChange="isiDesa()" tabindex="20" class="txtinputreg">
                            <option value=''>-Kecamatan-</option>
                        </select></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">&nbsp;Pekerjaan :&nbsp;</td>
                    <td colspan="2"><select name="Pekerjaan" id="Pekerjaan" tabindex="6" class="txtinputreg"></select></td>
                    <td align="right">Kelurahan/Desa :&nbsp;</td>
                    <td><select id="cmbDesa" name="cmbDesa" tabindex="20" class="txtinputreg">
                            <option value=''>-Kelurahan/Desa-</option>
                        </select></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">&nbsp;Gol. Darah :&nbsp;</td>
                    <td colspan="2"><select name="darah" id="darah" tabindex="6" class="txtinputreg">
                    <option value="AB">AB</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="O">O</option>
                    </select></td>
                    <td align="right"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <!-- <td align="right">Flag :&nbsp;</td> -->
                    <td colspan="3"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="40" tabindex="3" value="<?php echo $flag; ?>"/></td>
                    <td align="right">&nbsp;</td>
                    <td width="5" align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right"></td>
                    <td colspan="2">
                        
                    </td>
                    <td align="right"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right"></td>
                    <td colspan="2">
                        
                    </td>
                    <td align="right"></td>
                    <td></td>
                </tr>
                <tr id="trnoAnggota">
                    <td>&nbsp;</td>
                    <td align="right">No Anggota :&nbsp;</td>
                    <td colspan="2">
                        <input name="NoAnggota" id="NoAnggota" tabindex="36" class="txtinputreg"/>
                    </td>
                    <td align="right">&nbsp;</td>
                    <td></td>
                </tr>
                <tr id="trHak">
                    <td>&nbsp;</td>
                    <td align="right">Hak Kelas :&nbsp;</td>
                    <td colspan="2">
                        <select name="HakKelas" id="HakKelas" tabindex="37" class="txtinputreg"></select>
			Status :&nbsp;
                        <select name="StatusPenj" id="StatusPenj" tabindex="38" class="txtinputreg">
                            <option value="ANAK KE 1">Anak Ke 1</option>
                            <option value="ANAK KE 2">Anak Ke 2</option>
                            <option value="ISTRI">Istri</option>
                            <option value="PESERTA">Peserta</option>
                            <option value="SUAMI">Suami</option>
                        </select>
                    </td>
                    <td align="right" id="td_ret">&nbsp;
                        
                    </td>
                    <td id="td_ret1"></td>
                    <td align="right" id="td_room"></td>
                    <td width="5" id="td_room1"></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td colspan="2"></td>
                    <td align="right">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        
                    </td>
                    <td colspan="2" align="center"></td>                  
                    <td colspan="2" align="center">
                        <button type="button" id="tambah" name="tambah" value="tambah" onClick="simpan(this.value)" style="cursor: pointer;"><img src="../icon/add.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Tambah</button>
                    <button type="button" id="batal" name="batal" onClick="batal()" style="cursor: pointer;"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button>
                    <button type="button" id="delet" name="delet" value="hapus" disabled="true" onClick="hapus()" style="cursor: pointer;"><img src="../icon/delete2.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" height="250"  align="center">
                     <fieldset style="width:952px; ">
                            <legend>Status Pasien :
                             <select name="StatusPas" id="StatusPas" tabindex="26" class="txtinputreg" onChange="saring();">
                            <option value="">-status pasien-</option>
                            </select>
                            </legend>                            
                        <div id="gridbox" style="width:950px; height:200px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:950px;"></div>                        
                     </fieldset>
                    </td>
                </tr>
            </table>
           
        </div>        
    </body>
    <script type="text/JavaScript" language="JavaScript">
        var arrRange=depRange=[];
         var RowIdx;
        var fKeyEnt;
        var cari=0;
        var keyword='';
       
       function listPasien(feel,how,txtId){
            /*var txtId = 'NoRm*|*Nama*|*Alamat';
                //var stuff = document.getElementById('NoRm').value+"*|*"+document.getElementById('Nama').value+"*|*"+document.getElementById('Alamat').value;*/
            var stuff=document.getElementById(txtId).value;
            if(how=='show'){
                if(feel.which==13 && keyword!=stuff){
                    keyword=stuff;
                    if(txtId != 'NoRm'){
                        stuff = document.getElementById('Nama').value+'<?php echo chr(3);?>'+document.getElementById('Alamat').value;
                        document.getElementById('div_pasien').style.display='block';
                        Request('../loket/pasien_list.php?act=cari&txt='+txtId+'&keyword='+stuff,'div_pasien','','GET');
                    }else{
                        document.getElementById('div_pasien').style.display='none';
                        Request('../loket/pasien_list.php?act=cari&txt='+txtId+'&keyword='+stuff,'div_pasien','','GET',GetPasienByNorm);
                    }
                    RowIdx=0;
                }
                else if ((feel.which==38 || feel.which==40) && document.getElementById('div_pasien').style.display=='block'){
                    //alert(feel.which);
                    //alert(keyword);
                    var tblRow=document.getElementById('pasien_table').rows.length;
                    if (tblRow>0){
                        //alert(RowIdx);
                        if (feel.which==38 && RowIdx>0){
                            RowIdx=RowIdx-1;
                            document.getElementById(RowIdx+1).className='itemtableReq';
                            if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
                        }else if (feel.which == 40 && RowIdx < tblRow){
                            RowIdx=RowIdx+1;
                            if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
                            document.getElementById(RowIdx).className='itemtableMOverReq';
                        }
                    }
                }
                else if (feel.which==13 && keyword==stuff && RowIdx>0){
                    setPasien(document.getElementById(RowIdx).lang);
                    keyword='';
                }
                if(feel.which==27 || stuff==''){
                    if(feel.which!= 27 && txtId != 'Norm' && (document.getElementById('Nama').value != '' || document.getElementById('Alamat').value != ''))
                        return;
                    document.getElementById('div_pasien').style.display='none';
                    keyword='';
                }
            }
        }
        
         var dataPasien = new Array();

        function setPasien(val){
            dataPasien=val.split("|");

            var p="txtIdPasien*-*"+dataPasien[0]+"*|*NoRm*-*"+dataPasien[1]+"*|*NmOrtu*-*"+dataPasien[11]+"*|*Nama*-*"+dataPasien[2]
                +"*|*NmSuTri*-*"+dataPasien[12]+"*|*Gender*-*"+dataPasien[13]+"*|*TglLahir*-*"+dataPasien[3]+"*|*Alamat*-*"+dataPasien[4]
                +"*|*cmbProp*-*"+dataPasien[10]+"*|*cmbKab*-*"+dataPasien[9]+"*|*cmbKec*-*"+dataPasien[8]+"*|*cmbDesa*-*"+dataPasien[7]
                +"*|*rt*-*"+dataPasien[5]+"*|*rw*-*"+dataPasien[6]+"*|*Pendidikan*-*"+dataPasien[14]+"*|*Pekerjaan*-*"+dataPasien[15]
                +"*|*cmbAgama*-*"+dataPasien[16]+"*|*telp*-*"+dataPasien[17]+"*|*StatusPas*-*"+dataPasien[18]
                +"*|*NoAnggota*-*"+dataPasien[20]+"*|*HakKelas*-*"+dataPasien[21]+"*|*StatusPenj*-*"+dataPasien[22];
            
            fSetValue(window,p);
            isiCombo('cmbKab',((dataPasien[10]!='')?dataPasien[10]:1),(dataPasien[9]!='')?dataPasien[9]:1182);
            isiCombo('cmbKec',dataPasien[9],dataPasien[8]);
            isiCombo('cmbDesa',dataPasien[8],dataPasien[7]);
            gantiUmur();
            document.getElementById('div_pasien').style.display='none';
            //alert(dataPasien[18]);
            
            
        }
        
         function GetPasienByNorm(){
            var tbl=document.getElementById('pasien_table');
            var crow=tbl.rows.length;
            if(crow==2){
                setPasien(document.getElementById('1').lang);
                //document.getElementById('AslMasuk').focus();
            }else{
                document.getElementById('div_pasien').style.display='block';
            }
        }
       
         function isiCombo(id,val,defaultId,targetId,evloaded){
          if(targetId=='' || targetId==undefined){
              targetId=id;
          }
          Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
         }

       
        isiCombo('Pendidikan');
        isiCombo('Pekerjaan');
        isiCombo('cmbProp');
        isiCombo('cmbKab');
        isiCombo('cmbKec');
        isiCombo('cmbDesa');
        isiCombo('cmbAgama');
        isiCombo('HakKelas','','','HakKelas');
        isiCombo('StatusPas','','','',saring);
		
		isiCombo('cmbProp','',(dataPasien[10]!=undefined)?dataPasien[10]:1);
        isiCombo('cmbKab',((dataPasien[10]!=undefined)?dataPasien[10]:1),(dataPasien[9]!=undefined)?dataPasien[9]:1182,'',isiKec);
        isiCombo('cmbKec',((dataPasien[9]!=undefined)?dataPasien[9]:1182),(dataPasien[8]!=undefined)?dataPasien[8]:1329);
        isiCombo('cmbDesa',((dataPasien[8]!=undefined)?dataPasien[8]:1329),(dataPasien[7]!=undefined)?dataPasien[7]:1336);
        
            function getNoRM(){
              //alert('registrasi_utils.php?act=getNoRM');
              Request('pasien_utils.php?act=getNoRM','txtNoRM','','GET',setNoRM,'ok');
            }
            function setNoRM(){
              document.getElementById('NoRm').value = document.getElementById('txtNoRM').value;
            }
            
            
            
             function gantiUmur(){
                var val=document.getElementById('TglLahir').value;
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
                //$("txtHari").value = D;
            
            }
            
            function gantiTgl(){
                var dDate = new Date('<?php echo gmdate('Y,m,d',mktime(date('H')+7));?>');
                var thn=(document.getElementById("th").value=='')?0:parseInt(document.getElementById("th").value);
                var bln=(document.getElementById("Bln").value=='')?0:parseInt(document.getElementById("Bln").value);
                if(bln>11){
                    var tmp = parseInt(bln/12);
                    if(thn == ''){
                        thn = tmp;
                    }
                    else{
                        thn = thn+tmp;
                    }
                    document.getElementById('th').value = thn;
                    tmp = bln%12;
                    bln = tmp;
                    document.getElementById('Bln').value = bln;
                }
                if(bln == ''){
                    document.getElementById('Bln').value = 0;
                }
            
                var Y = dDate.getFullYear()-thn;
                var M = dDate.getMonth()-bln+1;
                var D = dDate.getDate();
                //alert(D+"-"+M+"-"+Y);
                if(D < 0){
                    M -= 1;
                    D = 30+D;
                }
                if(M < 0){
                    Y -= 1;
                    M = 12+M;
                }
                var nDate = new Date(M+"/"+D+"/"+Y);
                Y = nDate.getFullYear();
                M = nDate.getMonth()+1;
                D = nDate.getDate();
				if (M<10) M='0'+M;
                nDate = D + "-" + M + "-" + Y;
                document.getElementById("TglLahir").value = nDate;
                //alert(val);
                //setKelompokUmur(nDate,$F("txtThn"));
            }
            
             function saring(){
			 	HideHakKelas()
				//alert("pasien_utils.php?grd=true&saring=true&saringan="+document.getElementById('StatusPas').value);
				a.loadURL("pasien_utils.php?grd=true&saring=true&saringan="+document.getElementById('StatusPas').value,"","GET");
        	}
			
		function HideHakKelas(){
			if (document.getElementById("StatusPas").value=="1"){
				document.getElementById("trnoAnggota").style.visibility="collapse";
				document.getElementById("trHak").style.visibility="collapse";
			}else{
				document.getElementById("trnoAnggota").style.visibility="visible";
				document.getElementById("trHak").style.visibility="visible";
			}
		}
        
		/*function cek(){
		Request('pasien_utils.php?act=cek','txtNoRM','','GET',setNoRM1,'ok');
		}*/
		
        function simpan(action){
			//alert(document.getElementById('tambah').value);
			//alert("id pasien="+document.getElementById('txtIdPasien').value);
			//alert("id kso="+document.getElementById('txtIdKsoPasien').value);
            if(ValidateForm('NoRm,NoKTP,Nama,TglLahir,Alamat','ind')){
			var idPasien = document.getElementById("txtIdPasien").value;
            var idKsoPasien = document.getElementById("txtIdKsoPasien").value;            
            var noRm = document.getElementById("NoRm").value;
            var nama = document.getElementById("Nama").value;
			var ktp = document.getElementById("NoKTP").value;
            var namaOrtu = document.getElementById("NmOrtu").value;
            var namaSuTri = document.getElementById("NmSuTri").value;
            var gender = document.getElementById("Gender").value;
            var agama = document.getElementById("cmbAgama").value;
            var pend = document.getElementById("Pendidikan").value;
            var pek = document.getElementById("Pekerjaan").value;
            var tglLhr = document.getElementById("TglLahir").value;
            var thn = document.getElementById("th").value;
            var bln = document.getElementById("Bln").value;                
            var alamat = document.getElementById("Alamat").value;
            var telp = document.getElementById("telp").value;
            var rt = document.getElementById("rt").value;
            var rw = document.getElementById("rw").value;               
            var prop = document.getElementById("cmbProp").value;
            var kab = document.getElementById("cmbKab").value;
            var statusPas = document.getElementById("StatusPas").value;
            var kec = document.getElementById("cmbKec").value;
            var desa = document.getElementById("cmbDesa").value;
            var noAnggota = document.getElementById("NoAnggota").value;
            var hakKelas = document.getElementById("HakKelas").value;
            var statusPenj = document.getElementById("StatusPenj").value;
			var drh = document.getElementById("darah").value;
            var flag = document.getElementById("flag").value;
            
             var url = "pasien_utils.php?grd=true&saring=true&saringan="+statusPas+"&act="+action+"&idPasien="+idPasien+"&idKsoPasien="+idKsoPasien+"&noRm="+noRm+"&ktp="+ktp+"&nama="+nama+
                    "&namaOrtu="+namaOrtu+"&namaSuTri="+namaSuTri+"&gender="+gender+"&agama="+agama+"&pend="+pend+"&pek="+pek+
                    "&tglLhr="+tglLhr+"&thn="+thn+"&bln="+bln+"&alamat="+alamat+"&rt="+rt+
                    "&rw="+rw+"&prop="+prop+"&kab="+kab+"&statusPas="+statusPas+
                    "&kec="+kec+"&desa="+desa+
                    "&noAnggota="+noAnggota+"&hakKelas="+hakKelas+"&statusPenj="+statusPenj+"&telp="+telp+"&darah="+drh+"&flag="+flag+"&userId=<?php echo $userId; ?>";

                a.loadURL(url,"","GET");
                //alert(url);
				//batal();
			}
        }
        
		function isiKab(){
            isiCombo('cmbKab',document.getElementById('cmbProp').value,'1182','',isiKec);
        	//document.getElementById('cmbKab').value = 'TUBAN';
		}

        function isiKec(){
			//alert(document.getElementById('cmbKab').value);
            isiCombo('cmbKec',document.getElementById('cmbKab').value,'','',isiDesa);
        }

        function isiDesa(){
            isiCombo('cmbDesa',document.getElementById('cmbKec').value);
        }
		
        function ambilData()
        {
			document.getElementById('tambah').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Update';
			document.getElementById('tambah').value='simpan';
			//alert(document.getElementById('delet').value);
			document.getElementById('delet').disabled=false;
			document.getElementById('delet').innerHTML='<img src="../icon/delete.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
			//document.getElementById('hapus').disabled=false;
			
			
            var sisipan=a.getRowId(a.getSelRow()).split("|");
            var p="txtIdPasien*-*"+sisipan[1]
            +"*|*txtIdKsoPasien*-*"+sisipan[0]
            +"*|*NoRm*-*"+sisipan[2]
            +"*|*Nama*-*"+sisipan[6]
            +"*|*NmOrtu*-*"+sisipan[12]
            +"*|*NmSuTri*-*"+sisipan[13]
            +"*|*Gender*-*"+sisipan[14]
            +"*|*cmbAgama*-*"+sisipan[17]
            +"*|*Pendidikan*-*"+sisipan[15]
            +"*|*Pekerjaan*-*"+sisipan[16]
            +"*|*TglLahir*-*"+sisipan[7]           
            +"*|*Alamat*-*"+sisipan[3]
            +"*|*telp*-*"+sisipan[18]
            +"*|*rt*-*"+sisipan[4]
            +"*|*rw*-*"+sisipan[5]
            +"*|*cmbProp*-*"+sisipan[11]
            //+"*|*cmbKab*-*"+sisipan[10]
            //+"*|*cmbKec*-*"+sisipan[9]            
            //+"*|*cmbDesa*-*"+sisipan[8]                        
            //+"*|*StatusPas*-*"+sisipan[20]
            +"*|*HakKelas*-*"+sisipan[21]
            +"*|*NoAnggota*-*"+sisipan[19]
            +"*|*StatusPenj*-*"+sisipan[23]
			+"*|*NoKTP*-*"+sisipan[22];
			//+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
			//alert(sisipan[23]);
            fSetValue(window,p);
            if(document.getElementById('TglLahir').value!=''){
                gantiUmur();
            }
			//document.getElementById('simpan').value='update';
			isiCombo('cmbKab',sisipan[11],sisipan[10]);
			isiCombo('cmbKec',sisipan[10],sisipan[9]);
			isiCombo('cmbDesa',sisipan[9],sisipan[8]);
			document.getElementById('darah').value = sisipan[24];
        }
        
        function batal()
        {
			document.getElementById('tambah').innerHTML='<img src="../icon/add.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Tambah';
			//alert(document.getElementById('delet').value);
			document.getElementById('tambah').value='tambah'; 
			document.getElementById('delet').disabled=true;
			document.getElementById('delet').innerHTML='<img src="../icon/delete2.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
			
            var p="txtIdPasien*-**|*txtIdKsoPasien*-**|*NoRm*-**|*Nama*-**|*NmOrtu*-**|*NmSuTri*-**|*Gender*-**|*cmbAgama*-**|*Pendidikan*-**|*Pekerjaan*-**|*StatusPas*-*1*|*TglLahir*-**|*th*-**|*Bln*-**|*Alamat*-**|*telp*-**|*rt*-**|*rw*-**|*cmbProp*-**|*cmbKab*-**|*StatusPas*-**|*cmbKec*-**|*cmbDesa*-**|*NoAnggota*-**|*HakKelas*-**|*StatusPenj*-**|*NoKTP*-*";
			//+"*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
            fSetValue(window,p);
        }
        
        function hapus()
        {
            var idPasien = document.getElementById("txtIdPasien").value;
			var idKsoPasien = document.getElementById("txtIdKsoPasien").value;
            if(confirm("Anda Yakin Ingin Menghapus Data Pasien ?"))
            {                
                a.loadURL("pasien_utils.php?grd=true&act=hapus&idPasien="+idPasien+"&idKsoPasien="+idKsoPasien+"&saring=true&saringan="+document.getElementById('StatusPas').value+"&userId=<?php echo $userId; ?>","","GET");
            }
            batal();
        }
         
        function konfirmasi(key,val){
			//alert(key+' - '+val);
			if (val!=undefined){
				var sisip=val.split("|");
				if(key=='Error'){
					if(sisip[0]=='tambah'){
						//alert('Tambah Gagal');
						alert(sisip[1]);
						if(sisip[1]!='Data No RM Pasien Sudah Ada !'){
							batal();
						}
					}else if(sisip[0]=='simpan'){
						//alert('Update Gagal');
						alert(sisip[1]);
						batal();
					}else if(sisip[0]=='hapus'){
						//alert('Hapus Gagal');
						alert(sisip[1]);
						batal();
					}
	
				}
				else{
					if(sisip[0]=='tambah')
						alert('Tambah Berhasil');
					else if(sisip[0]=='simpan')
						alert('Update Berhasil');
					else if(sisip[0]=='hapus')
						alert('Hapus Berhasil');
				}
			}
        }
        
        function goFilterAndSort(grd){
            //alert(grd);
            if (grd=="gridbox"){
                //alert("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
                a.loadURL("pasien_utils.php?grd=true&saring=true&saringan="+document.getElementById('StatusPas').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
            }
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("DATA PASIEN");
        a.setColHeader("NO,NO RM,NAMA,TGL LAHIR,PENJAMIN,HAK KELAS,ALAMAT");
        a.setIDColHeader(",no_rm,nama,tgl_lahir,nama_kso,kelas,alamat");
        a.setColWidth("50,80,250,80,150,80,360");
        a.setCellAlign("center,center,left,center,center,center,left");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.onLoaded(konfirmasi);
        //alert("pasien_utils.php?grd=true&saring=true&saringan="+document.getElementById('StatusPas').value);
        a.baseURL("pasien_utils.php?grd=true&saring=true&saringan="+document.getElementById('StatusPas').value);
        a.Init();
    </script>
</html>
<?php 
mysql_close($konek);
?>
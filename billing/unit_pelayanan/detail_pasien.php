<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
        <script type="text/javascript" src="../theme/js/tab-view.js"></script>

        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
        <!--diatas ini diperlukan untuk menampilkan popup-->

        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!-- end untuk ajax-->

        <title>Detail Pasien</title>
    </head>
    <script type="text/JavaScript">
        var arrRange=depRange=[];
    </script>
    <iframe height="193" width="168" name="gToday:normal:agenda.js"
            id="gToday:normal:agenda.js"
            src="../theme/popcjs.php" scrolling="no"
            frameborder="1"
            style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
    </iframe>
    <?php
    $date_now=gmdate('d-m-Y',mktime(date('H')+7));
    $time_now=gmdate('H:i:s',mktime(date('H')+7));
    ?>
    <body onload="setJam()">
        <div id="divRujukUnit" style="display:none;width:500px" class="popup">
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
            <fieldset><legend>Rujukan Unit</legend>
                <table border=0>
                    <tr>
                        <td width="162" align="right">Jenis Layanan :</td>
                        <td ><select name="JnsLayanan" id="JnsLayanan" tabindex="26" class="txtinput" onchange="isiCombo('TmpLayanan',this.value);this.title=this.value;"></select></td>

                    </tr>
                    <tr>
                        <td align="right">Tempat Layanan :</td>
                        <td><select name="TmpLayanan" id="TmpLayanan" tabindex="27" class="txtinput" ></select></td>

                    </tr>
                    <tr>
                        <td align="right">Keterangan Rujuk :</td>
                        <td><textarea id="txtKetRujuk" name="txtKetRujuk"  cols="35" rows="2" class="txtinput"></textarea></td>
                    </tr>
                    <tr>
                        <td align="right">Dokter Perujuk :</td>
                        <td><select id="cmbDokRujukUnit" name="cmbDokRujukUnit" class="txtinput" onchange="">
                                <option value="">-Dokter-</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="hidden" id="idRujukUnit" name="idRujukUnit"/>
                            <input type="button" id="btnSimpanRujukUnit" name="btnSimpanRujukUnit" value="Tambah" onclick="simpan(this.value,this.id);" class="tblTambah"/>
                            <input type="button" id="btnHapusRujukUnit" name="btnHapusRujukUnit" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
                            <!--input type="button" id="btnBatalRujukUnit" name="btnBatalRujukUnit" value="Batal" onclick="batal(this.id)" class="tblBatal"/-->
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="gridboxRujukUnit" style="width:450px; height:250px; padding-bottom:10px; background-color:white;"></div>
                            <div id="pagingRujukUnit" style="width:450px;"></div>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>

        <div id="divRujukRS" style="display:none;width:500px" class="popup">
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
            <fieldset><legend>Rujukan Rumah Sakit</legend>
                <table border=0>
                    <tr>
                        <td width="162" align="right">Rumah Sakit Rujukan :</td>
                        <td ><select name="cmbRS" id="cmbRS" tabindex="26" class="txtinput" onchange=""></select></td>
                    </tr>
                    <!--tr>
                            <td width="162" align="right">Jenis Layanan :</td>
                            <td ><select name="JnsLayananRS" id="JnsLayananRS" tabindex="26" class="txtinput" onchange="isiCombo('TmpLayanan',this.value,'','TmpLayananRS');this.title=this.value;"></select></td>

		</tr>
                    <tr>
                            <td align="right">Tempat Layanan :</td>
                            <td><select name="TmpLayananRS" id="TmpLayananRS" tabindex="27" class="txtinput" ></select></td>

		</tr-->
                    <tr>
                        <td align="right">Keterangan Rujuk :</td>
                        <td><textarea id="txtKetRujukRS" name="txtKetRujukRS"  cols="35" rows="2" class="txtinput"></textarea></td>
                    </tr>
                    <tr>
                        <td align="right">Dokter Perujuk :</td>
                        <td><select id="cmbDokRujukRS" name="cmbDokRujukRS" class="txtinput" onchange="">
                                <option value="">-Dokter-</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="hidden" id="idRujukRS" name="idRujukRS"/>
                            <input type="button" id="btnSimpanRujukRS" name="btnSimpanRujukRS" value="Tambah" onclick="simpan(this.value,this.id);" class="tblTambah"/>
                            <input type="button" id="btnHapusRujukRS" name="btnHapusRujukRS" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
                            <!--input type="button" id="btnBatalRujukRS" name="btnBatalRujukRS" value="Batal" onclick="batal(this.id)" class="tblBatal"/-->
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="gridboxRujukRS" style="width:450px; height:150px; padding-bottom:10px; background-color:white;"></div>
                            <div id="pagingRujukRS" style="width:450px;"></div>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <div id="divSetKamar" style="display:none;width:500px" class="popup">
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right;" />
            <fieldset><legend>Set Kamar</legend>
                <table border=0>
                    <tr>
                        <td width="162" align="right">Kamar :</td>
                        <td ><select name="cmbKamar" id="cmbKamar" tabindex="26" class="txtinput" onchange=""></select>
                        </td>

                    </tr>
                    <tr>
                        <td align="right">Tanggal Masuk :</td>
                        <td>
                            <input type="text" class="txtcenter" readonly="readonly" name="TglMasuk" id="TglMasuk" size="11" value="<?php echo $date_now;?>"/>
                            <input type="button" class="btninput" id="btnTglMasuk" name="btnTglMasuk" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('TglMasuk'),depRange);" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">Jam Masuk :</td>
                        <td>
                            <input type="hidden" id="jamServer" name="jamServer" value="<?php echo $time_now;?>"/>

                            <input type="text" class="txtcenter" readonly="readonly" name="JamMasuk" id="JamMasuk" size="5" maxlength="5" value=""/>
                            <label><input type="checkbox" id="chkManual" name="chkManual" onclick="setManual()"/>set manual</label>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="hidden" id="idSetKamar" name="idSetKamar"/>
                            <input type="button" id="btnSimpanKamar" name="btnSimpanKamar" value="Tambah" onclick="simpan(this.value,this.id);" class="tblTambah"/>
                            <input type="button" id="btnHapusKamar" name="btnHapusKamar" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
                            <!--input type="button" id="btnBatalRujukUnit" name="btnBatalRujukUnit" value="Batal" onclick="batal(this.id)" class="tblBatal"/-->
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="gridboxKamar" style="width:450px; height:250px; padding-bottom:10px; background-color:white;"></div>
                            <div id="pagingkamar" style="width:450px;"></div>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <div align="center">
            <?php
			include("../koneksi/konek.php");
            include("../header1.php");
            $id = $_REQUEST['id'];
            $pelayanan_id = $_REQUEST['pelayanan_id'];
            $kunjungan_id = $_REQUEST['kunjungan_id'];
            $pasienId = $_REQUEST['id'];
            $kelasId = $_REQUEST['kelas_id'];
            $tglKunjung=$_REQUEST['tgl'];
            $jnsLay=$_REQUEST['jnsLay'];
            $unit_id=$_REQUEST['unit_id'];
            $sql = "SELECT p.id, p.no_rm, p.nama, p.sex, p.tgl_lahir, p.nama_ortu, p.alamat,
			(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
			k.umur_thn, pl.id, k.id
			FROM b_ms_pasien p 
			INNER JOIN b_kunjungan k ON k.pasien_id = p.id
			INNER JOIN b_pelayanan pl ON k.id = pl.kunjungan_id
			WHERE p.id = '".$id."' and pl.id = '".$pelayanan_id."' and k.id = '".$kunjungan_id."' ";
            $dt = mysql_query($sql);
            $rw = mysql_fetch_array($dt);

            //$tgl = explode('-',$_GET['tgl_lahir']);
            //$tgl = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
            ?>

            <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#008484" style="color:#A8FFFF">
                <tr>
                    <td height="30">&nbsp;DETAIL PASIEN</td>
                </tr>
            </table>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="tabel" align="center">
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="90%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="90%" align="right"><img alt="close" src="../icon/close.png" onClick="location='PelayananKunjungan.php?tgl=<?php echo $tglKunjung;?>&jnsLay=<?php echo $jnsLay;?>&tmpLay=<?php echo $unit_id;?>'" border="0" style="cursor:pointer; float:right;" /></td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <fieldset>
                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="1" class="tabel">
                                <tr>
                                    <td width="10%">&nbsp;No RM</td>
                                    <td width="15%">: <input id="txtNo" name="txtNo" size="12" value="<?=$rw['no_rm']; ?>" class="txtinput" />&nbsp;</td>
                                    <td width="7%">&nbsp;Nama</td>
                                    <td colspan="2">: <input id="txtNama" name="txtNama" size="28" value="<?=$rw['nama']; ?>"  class="txtinput" />&nbsp;</td>
                                    <td colspan="3">&nbsp;Tanggal Lahir&nbsp;: <input id="txtTglLhr" name="txtTglLhr" size="12" value="<?=$rw['tgl_lahir']; ?>" class="txtinput" />&nbsp;&nbsp;&nbsp;Umur&nbsp;:&nbsp;<input id="txtUmur" name="txtUmur" size="4" value="<?=$rw['umur_thn'];?>" class="txtinput" />&nbsp;&nbsp;&nbsp;L/P&nbsp;:&nbsp;<input id="txtSex" name="txtSex" size="2" value="<?=$rw['sex']; ?>" class="txtinput" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;Nama Ortu</td>
                                    <td>: <input id="txtOrtu" name="txtOrtu" size="15" value="<?=$rw['nama_ortu']; ?>" class="txtinput" />&nbsp;</td>
                                    <td>&nbsp;Alamat</td>
                                    <td width="15%">: <input id="txtAlmt" name="txtAlmt" size="15" value="<?=$rw['alamat']; ?>" class="txtinput" />&nbsp;</td>
                                    <td width="7%"></td>
                                    <td width="21%">&nbsp;Desa : <input id="txtDesa" name="txtDesa" size="15" value="<?=$rw['desa'];?>" class="txtinput" />&nbsp;</td>
                                    <td width="7%">&nbsp;Kec</td>
                                    <td width="18%">: <input id="txtKec" name="txtKec" size="15" value="<?=$rw['kec'];?>" class="txtinput" />&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;Kab</td>
                                    <td>: <input id="txtKab" name="txtKab" size="15" value="<?=$rw['kab'];?>" class="txtinput" />&nbsp;</td>
                                    <td>&nbsp;Prop</td>
                                    <td>: <input id="txtProp" name="txtProp" size="15" value="<?=$rw['prop'];?>" class="txtinput" />&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>

                            </table>
                        </fieldset>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td style="padding:10px">
                        <input type="button" id="btnRujukUnit" name="btnRujukUnit" value="RUJUK UNIT" onclick="rujukUnit()"/>
                        <input type="button" id="btnRujukRS" name="btnRujukRS" value="RUJUK RS" onclick="rujukRS()"/>
                        <input type="button" id="btnRekamMds" name="btnRekamMds" value="REKAM MEDIS"/>
                        <?php
                        $cekInap="select inap from b_ms_unit where id='$unit_id'";
                        $rsInap=mysql_query($cekInap);
                        $rwInap=mysql_fetch_array($rsInap);
                        if($rwInap['inap']==1) {
                            ?>
                        <input type="button" id="btnSetKamar" name="btnSetKamar" value="SET KAMAR" onclick="setKamar()"/>
                            <?php
                        }
                        ?>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="center"><div class="TabView" id="TabView" style="width:900px; height:600px"></div></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" bgcolor="#008484" width="1000">
                <tr height="30">
                    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" class="btninput" /></td>
                    <td>&nbsp;</td>
                    <td align="right"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" onClick="location='PelayananKunjungan.php'" />&nbsp;</td>
                </tr>
            </table>
        </div>

    </body>
    <script type="text/JavaScript">
        function setManual(){
            if(document.getElementById('chkManual').checked==true){
                document.getElementById('JamMasuk').readOnly=false;
                document.getElementById('btnTglMasuk').disabled=false;
            }
            else{
                document.getElementById('JamMasuk').readOnly=true;
                document.getElementById('btnTglMasuk').disabled=true;

            }
        }
        var time;
        var tanggal=document.getElementById('TglMasuk').value.split("-");
        var tmpTgl=tanggal;
        var ttgl=parseInt((tanggal[0].substr(0,1)=='0')?tanggal[0].substr(1,1):tanggal[0]);
        var tbln=parseInt((tanggal[1].substr(0,1)=='0')?tanggal[1].substr(1,1):tanggal[1]);
        var tthn=parseInt((tanggal[2].substr(0,1)=='0')?tanggal[2].substr(1,1):tanggal[2]);
        function setJam(){
            time=document.getElementById('jamServer').value.split(':');
            var tjam=parseInt((time[0].substr(0,1)=='0')?time[0].substr(1,1):time[0]);
            var tmenit=parseInt((time[1].substr(0,1)=='0')?time[1].substr(1,1):time[1]);
            var tdetik=parseInt((time[2].substr(0,1)=='0')?time[2].substr(1,1):time[2]);
            //alert(tjam+':'+tmenit+':'+tdetik);
            tdetik+=1;
            if((tdetik)>=60){
                tdetik=tdetik-60;
                tmenit++;
                if(tmenit>=60){
                    tmenit=tmenit-60;
                    tjam++;
                    if(tjam==24){
                        tjam=0;
                        ttgl++;
                        if(tbln==1 || tbln==3 || tbln==5 || tbln==7 || tbln==8 || tbln==10 || tbln==12){
                            if(ttgl>31){
                                ttgl=1;
                                tbln++;
                            }
                        }
                        else if(tbln==4 || tbln==6 || tbln==9 || tbln==11){
                            if(ttgl>30){
                                ttgl=1;
                                tbln++;
                            }
                        }
                        else{
                            if((tthn % 4)==0){
                                if(ttgl>29){
                                    ttgl=1;
                                    tbln++;
                                }
                            }
                            else{
                                if(ttgl>28){
                                    ttgl=1;
                                    tbln++;
                                }
                            }
                        }
                        if(tbln>12){
                            tbln=1;
                            tthn++;
                        }
                    }
                }
            }
            if(tjam<10){
                time[0]='0'+tjam;
            }
            else{
                time[0]=tjam;
            }
            if(tmenit<10){
                time[1]='0'+tmenit;
            }
            else{
                time[1]=tmenit;
            }
            if(tdetik<10){
                time[2]='0'+tdetik;
            }
            else{
                time[2]=tdetik;
            }

            if(ttgl<10){
                tanggal[0]='0'+ttgl;
            }
            else{
                tanggal[0]=ttgl;
            }
            if(tbln<10){
                tanggal[1]='0'+tbln;
            }
            else{
                tanggal[1]=tbln;
            }
            if(tthn<10){
                tanggal[2]='0'+tthn;
            }
            else{
                tanggal[2]=tthn;
            }

            tmpTgl=tanggal[0]+'-'+tanggal[1]+'-'+tanggal[2];
            document.getElementById('jamServer').value=time[0]+':'+time[1]+':'+time[2];
            if(document.getElementById('chkManual').checked==false){
                document.getElementById('JamMasuk').value=time[0]+':'+time[1];
                document.getElementById('TglMasuk').value=tmpTgl;
            }
            //alert(tjam+':'+tmenit+':'+tdetik);
            setTimeout("setJam()","1000");
        }
        function rujukUnit(){
            new Popup('divRujukUnit',null,{modal:true,position:'center',duration:1});
            document.getElementById('divRujukUnit').popup.show();
        }
        function rujukRS(){

            new Popup('divRujukRS',null,{modal:true,position:'center',duration:1});

            document.getElementById('divRujukRS').popup.show();
        }
        function setKamar(){
            new Popup('divSetKamar',null,{modal:true,position:'center',duration:1});
            document.getElementById('divSetKamar').popup.show();
        }

        var mTab=new TabView("TabView");
        mTab.setTabCaption("TINDAKAN,DIAGNOSA");
        mTab.setTabCaptionWidth("450,450");
        mTab.onLoaded(showgrid);
        mTab.setTabPage("tindakan.php,diagnosa.php");

        var a;
        var b;
        var unitId=<?php echo $unit_id?>;
        function showgrid()
        {
            a=new DSGridObject("gridbox");
            a.setHeader("DATA TINDAKAN PASIEN");
            a.setColHeader("NO,KODE,TINDAKAN,BIAYA,JUMLAH,SUBTOTAL,DOKTER,KETERANGAN");
            //a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
            a.setColWidth("30,100,250,75,75,75,200,150");
            a.setCellAlign("center,center,left,right,center,right,left,left");
            a.setCellHeight(20);
            a.setImgPath("../icon");
            a.setIDPaging("paging");
            a.attachEvent("onRowClick","ambilDataTind");
            a.baseURL("tindiag_utils.php?grd=true&pelayanan_id=<?=$pelayanan_id;?>");
            a.Init();

            b=new DSGridObject("gridbox1");
            b.setHeader("DATA DIAGNOSA PASIEN");
            b.setColHeader("NO,KODE,DIAGNOSA,DOKTER");
            //a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
            b.setColWidth("30,60,300,200");
            b.setCellAlign("center,center,left,left");
            b.setCellHeight(20);
            b.setImgPath("../icon");
            b.setIDPaging("paging1");
            b.attachEvent("onRowClick","ambilDataDiag");
            b.baseURL("tindiag_utils.php?grd1=true&pelayanan_id=<?=$pelayanan_id;?>");
            b.Init();
            isiCombo('cmbDok','<?php echo $unit_id;?>','','cmbDokTind');
            isiCombo('cmbDok','<?php echo $unit_id;?>','','cmbDokDiag');



            isiCombo('JnsLayanan','','1','jnsLay',isiTmpLayanan2);
            function isiTmpLayanan2(){
                isiCombo('TmpLayanan',document.getElementById('jnsLay').value,'','tmpLay');
            }

        }



        function showUnit(cek){
            if(cek){
                document.getElementById('trUnit').style.visibility='visible';
                unitId=document.getElementById('tmpLay').value;

            } else {
                document.getElementById('trUnit').style.visibility='collapse';
                unitId=<?php echo $unit_id?>;
            }
            var keywords=document.getElementById('txtTind').value;
            Request("tindakanlist.php?aKeyword="+keywords+"&pasienId=<?=$pasienId;?>&kelasId=<?=$kelasId;?>&unitId="+unitId, 'divtindakan', '', 'GET');
            //document.getElementById('divtindakan').style.display='none';
        }

        function setUnit(val){
            unitId=val;
            var keywords=document.getElementById('txtTind').value;
            Request("tindakanlist.php?aKeyword="+keywords+"&pasienId=<?=$pasienId;?>&kelasId=<?=$kelasId;?>&unitId="+unitId, 'divtindakan', '', 'GET');
            if(document.getElementById('btnSimpanTind').value=="Simpan"){
                document.getElementById('txtTind').value='';
            }
            isiCombo('cmbDok',unitId,'','cmbDokTind');
        }

        isiCombo('JnsLayanan','','1','',isiTmpLayanan);
        function isiTmpLayanan(){
            isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value);
        }
        isiCombo('cmbDok','<?php echo $unit_id;?>','','cmbDokRujukUnit');

        isiCombo('cmbRS');
        isiCombo('cmbDok','<?php echo $unit_id;?>','','cmbDokRujukRS');
        isiCombo('cmbKamar','<?php echo $unit_id;?>,<?php echo $kelasId;?>');

        //Tindakan


        var RowIdx1;
        var fKeyEnt1;
        function suggest1(e,par){
            var keywords=par.value;//alert(keywords);
            if(keywords==""){
                document.getElementById('divtindakan').style.display='none';
            }else{
                var key;
                if(window.event) {
                    key = window.event.keyCode;
                }
                else if(e.which) {
                    key = e.which;
                }
                //alert(key);
                if (key==38 || key==40){
                    var tblRow=document.getElementById('tblTindakan').rows.length;
                    if (tblRow>0){
                        //alert(RowIdx1);
                        if (key==38 && RowIdx1>0){
                            RowIdx1=RowIdx1-1;
                            document.getElementById(RowIdx1+1).className='itemtableReq';
                            if (RowIdx1>0) document.getElementById(RowIdx1).className='itemtableMOverReq';
                        }else if (key == 40 && RowIdx1 < tblRow){
                            RowIdx1=RowIdx1+1;
                            if (RowIdx1>1) document.getElementById(RowIdx1-1).className='itemtableReq';
                            document.getElementById(RowIdx1).className='itemtableMOverReq';
                        }
                    }
                }else if (key==13){
                    if (RowIdx1>0){
                        if (fKeyEnt1==false){
                            fSetTindakan(document.getElementById(RowIdx1).lang);
                        }else{
                            fKeyEnt1=false;
                        }
                    }
                }else if (key!=27 && key!=37 && key!=39){
                    RowIdx1=0;
                    fKeyEnt1=false;
                    //alert("tindakanlist.php?aKeyword="+keywords+"&pasienId=<?=$pasienId;?>&kelasId=<?=$kelasId;?>&unitId="+unitId);
                    Request("tindakanlist.php?aKeyword="+keywords+"&pasienId=<?=$pasienId;?>&kelasId=<?=$kelasId;?>&unitId="+unitId, 'divtindakan', '', 'GET');
                    if (document.getElementById('divtindakan').style.display=='none') fSetPosisi(document.getElementById('divtindakan'),par);
                    document.getElementById('divtindakan').style.display='block';
                }
            }
        }

        function fSetTindakan(par){
            var cdata=par.split("*|*");
            document.getElementById("tindakan_id").value=cdata[0];
            document.getElementById("txtTind").value=cdata[1];
            document.getElementById("txtBiaya").value=cdata[3];
            document.getElementById('divtindakan').style.display='none';
            if(document.getElementById('txtQty').value==''){
                document.getElementById('txtQty').value='1';
            }
            document.getElementById('txtKet').focus();
            //alert(cdata[4]);
            /*if(cdata[4]=='2363'){
                        document.getElementById('trRujuk').style.visibility='visible';
                        isiCombo('JnsLayanan','','1');
                        setTimeout("isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value)","100");
                }
                else{
                        document.getElementById('trRujuk').style.visibility='collapse';
                        var p="TmpLayanan*-*0*|*JnsLayanan*-*0*|*txtKetRujuk*-*";
                        fSetValue(window,p);
                }*/
        }

        //Diagnosa
        var RowIdx;
        var fKeyEnt;
        function suggest(e,par){
            var keywords=par.value;//alert(keywords);
            if(keywords==""){
                document.getElementById('divdiagnosa').style.display='none';
            }else{
                var key;
                if(window.event) {
                    key = window.event.keyCode;
                }
                else if(e.which) {
                    key = e.which;
                }
                //alert(key);
                if (key==38 || key==40){
                    var tblRow=document.getElementById('tblDiagnosa').rows.length;
                    if (tblRow>0){
                        //alert(RowIdx);
                        if (key==38 && RowIdx>0){
                            RowIdx=RowIdx-1;
                            document.getElementById(RowIdx+1).className='itemtableReq';
                            if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
                        }else if (key == 40 && RowIdx < tblRow){
                            RowIdx=RowIdx+1;
                            if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
                            document.getElementById(RowIdx).className='itemtableMOverReq';
                        }
                    }
                }else if (key==13){
                    if (RowIdx>0){
                        if (fKeyEnt==false){
                            fSetPenyakit(document.getElementById(RowIdx).lang);
                        }else{
                            fKeyEnt=false;
                        }
                    }
                }else if (key!=27 && key!=37 && key!=39){
                    RowIdx=0;
                    fKeyEnt=false;
                    Request('diagnosalist.php?aKeyword='+keywords , 'divdiagnosa', '', 'GET' );
                    if (document.getElementById('divdiagnosa').style.display=='none') fSetPosisi(document.getElementById('divdiagnosa'),par);
                    document.getElementById('divdiagnosa').style.display='block';
                }
            }
        }

        function fSetPenyakit(par){
            var cdata=par.split("*|*");
            document.getElementById("diagnosa_id").value=cdata[0];
            document.getElementById("txtDiag").value=cdata[1];
            document.getElementById('divdiagnosa').style.display='none';
        }

        function simpan(action,id,cek)
        {

            //if(ValidateForm("tindakan_id,txtBiaya,txtQty",'ind'))
            //{
            var userId='<?php echo $_SESSION['userId']?>';
            var idTind = document.getElementById("tindakan_id").value;
            var tind = document.getElementById("txtTind").value;
            var biaya = document.getElementById("txtBiaya").value;
            var qty = document.getElementById("txtQty").value;
            var ket = document.getElementById("txtKet").value;
            var idBaru = document.getElementById("id_tind").value;
            var idDok=document.getElementById("cmbDokTind").value;

            var jnsLayRujukUnit=document.getElementById("JnsLayanan").value;
            var tmpLayRujukUnit=document.getElementById("TmpLayanan").value;
            var ketRujukUnit=document.getElementById("txtKetRujuk").value;
            var idDokRujukUnit=document.getElementById("cmbDokRujukUnit").value;
            var idRujukUnit = document.getElementById("idRujukUnit").value;

            //var jnsLayRujukRS=document.getElementById("JnsLayananRS").value;
            //var tmpLayRujukRS=document.getElementById("TmpLayananRS").value;
            var idRS=document.getElementById("cmbRS").value;
            var ketRujukRS=document.getElementById("txtKetRujukRS").value;
            var idDokRujukRS=document.getElementById("cmbDokRujukRS").value;
            var idRujukRS = document.getElementById("idRujukRS").value;

            var idSetKamar = document.getElementById("idSetKamar").value;
            var idKamar = document.getElementById("cmbKamar").value;
            var tglMasuk = document.getElementById("TglMasuk").value;
            var jamMasuk = document.getElementById("JamMasuk").value.replace(' ','');
            var isManual = document.getElementById('chkManual').checked;


            var idDiag = document.getElementById("diagnosa_id").value;
            var diag = document.getElementById("txtDiag").value;
            var diag_id = document.getElementById("id_diag").value;


            switch(id)
            {
                case 'btnSimpanTind':
                    if(ValidateForm("tindakan_id,txtBiaya,txtQty",'ind')){
                        //alert("tindiag_utils.php?grd=true&act="+action+"&smpn="+id+"&id="+idBaru+"&pelayanan_id=<?=$pelayanan_id;?>&kunjungan_id=<?=$kunjungan_id;?>&idTind="+idTind+"&tind="+tind+"&biaya="+biaya+"&qty="+qty+"&ket="+ket+"&idDok="+idDok);
                        a.loadURL("tindiag_utils.php?grd=true&act="+action+"&smpn="+id+"&id="+idBaru+"&pelayanan_id=<?=$pelayanan_id;?>&kunjungan_id=<?=$kunjungan_id;?>&idTind="+idTind+"&tind="+tind+"&biaya="+biaya+"&qty="+qty+"&ket="+ket+"&idDok="+idDok+"&unitId="+unitId+"&userId="+userId,"","GET");
                        batal('btnBatalTind');
                    }
                    break;

                case 'btnSimpanDiag':
                    if(ValidateForm("tindakan_id,txtBiaya,txtQty",'ind')){
                        //alert("tindiag_utils.php?grd1=true&act="+action+"&smpn="+id+"&id="+diag_id+"&pelayanan_id=<?=$pelayanan_id;?>&idDiag="+idDiag+"&diagnosa="+diag+"&idDok="+idDok);
                        b.loadURL("tindiag_utils.php?grd1=true&act="+action+"&smpn="+id+"&id="+diag_id+"&pelayanan_id=<?=$pelayanan_id;?>&idDiag="+idDiag+"&diagnosa="+diag+"&idDok="+idDok+"&userId="+userId,"","GET");
                        document.getElementById("txtDiag").value = '';
                    }
                    break;

                case 'btnSimpanRujukUnit':
                    //alert("tindiag_utils.php?grd2=true&act="+action+"&smpn="+id+"&id="+idRujukUnit+"&pasienId=<?php echo $pasienId;?>&kunjungan_id=<?php echo $kunjungan_id;?>&ket="+ketRujukUnit+"&idDok="+idDokRujukUnit+"&jnsLay="+jnsLayRujukUnit+"&tmpLay="+tmpLayRujukUnit+"&unitAsal=<?php echo $unit_id;?>&kelas=<?php echo $kelasId;?>&userId="+userId);
                    c.loadURL("tindiag_utils.php?grd2=true&act="+action+"&smpn="+id+"&id="+idRujukUnit+"&pasienId=<?php echo $pasienId;?>&kunjungan_id=<?php echo $kunjungan_id;?>&ket="+ketRujukUnit+"&idDok="+idDokRujukUnit+"&jnsLay="+jnsLayRujukUnit+"&tmpLay="+tmpLayRujukUnit+"&unitAsal=<?php echo $unit_id;?>&kelas=<?php echo $kelasId;?>&userId="+userId,"","GET");
                    break;
                case 'btnSimpanRujukRS':
                    //alert("tindiag_utils.php?grd3=true&act="+action+"&smpn="+id+"&id="+idRujukRS+"&pelayanan_id=<?php echo $pelayanan_id;?>&kunjungan_id=<?php echo $kunjungan_id;?>&ket="+ketRujukRS+"&idDok="+idDokRujukRS+"&idRS="+idRS+"&userId="+userId);
                    d.loadURL("tindiag_utils.php?grd3=true&act="+action+"&smpn="+id+"&id="+idRujukRS+"&pelayanan_id=<?php echo $pelayanan_id;?>&kunjungan_id=<?php echo $kunjungan_id;?>&ket="+ketRujukRS+"&idDok="+idDokRujukRS+"&idRS="+idRS+"&userId="+userId,"","GET");
                    break;
                case 'btnSimpanKamar':
                    //alert(jamMasuk);
                    if(ValidateForm("JamMasuk",'ind')){
                        var jamSplit=jamMasuk.split(':');
                        if(jamSplit.length!=2){
                            alert('Format Jam Salah!');
                            return false;
                        }
                        if(isNaN(jamSplit[0]) || isNaN(jamSplit[1]) || jamSplit[0]=='' || jamSplit[1]==''  || jamSplit[0].length!=2 || jamSplit[1].length!=2){
                            alert('Format Jam Salah!');
                            return false;
                        }
                        jamMasuk=jamMasuk+':'+time[2];
                        //alert("tindiag_utils.php?grd4=true&act="+action+"&smpn="+id+"&id="+idSetKamar+"&pelayanan_id=<?php echo $pelayanan_id;?>&kamar_id="+idKamar+"&tglMasuk="+tglMasuk+"&jamMasuk="+jamMasuk+"&userId="+userId);
                        e.loadURL("tindiag_utils.php?grd4=true&act="+action+"&smpn="+id+"&id="+idSetKamar+"&pelayanan_id=<?php echo $pelayanan_id;?>&kamar_id="+idKamar+"&tglMasuk="+tglMasuk+"&jamMasuk="+jamMasuk+"&isManual="+isManual+"&userId="+userId,"","GET");
                        fSetValue(window,'btnHapusKamar*-*true');
                    }
                    break;
                }

                //}
            }

            function ambilDataTind()
            {
                var sisip=a.getRowId(a.getSelRow()).split("|");
                //alert(sisip[1]);
                var p ="id_tind*-*"+sisip[0]+"*|*tindakan_id*-*"+sisip[1]+"*|*txtTind*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*txtBiaya*-*"+a.cellsGetValue(a.getSelRow(),4)+"*|*txtQty*-*"+a.cellsGetValue(a.getSelRow(),5)+"*|*txtKet*-*"+a.cellsGetValue(a.getSelRow(),8)+"*|*btnSimpanTind*-*Simpan*|*btnHapusTind*-*false";
                fSetValue(window,p);


                if(unitId!=sisip[2]){
                    document.getElementById('chkTind').checked=true;
                    document.getElementById('trUnit').style.visibility='visible';
                    fSetValue(window,"jnsLay*-*"+sisip[3]+"*|*tmpLay*-*"+sisip[2]);
                    isiCombo('cmbDok',sisip[2],sisip[4],'cmbDokTind');
                }else{
                    document.getElementById('chkTind').checked=false;
                    document.getElementById('trUnit').style.visibility='collapse';
                    isiCombo('JnsLayanan','',sisip[3],'jnsLay');
                    isiCombo('TmpLayanan',sisip[3],sisip[2],'tmpLay');
                    isiCombo('cmbDok',sisip[2],sisip[4],'cmbDokTind');
                }

            }

            function ambilDataDiag()
            {
                var p ="diagnosa_id*-*"+(b.getRowId(b.getSelRow()))+"*|*id_diag*-*"+b.cellsGetValue(b.getSelRow(),1)+"*|*txtDiag*-*"+b.cellsGetValue(b.getSelRow(),3)+"*|*cmbDokDiag*-*"+a.cellsGetValue(a.getSelRow(),4)+"*|*btnSimpanDiag*-*Simpan*|*btnHapusDiag*-*false";
                fSetValue(window,p);
            }

            function ambilDataRujukUnit(){
                //alert(c.getRowId(c.getSelRow()));
                var sisipan=c.getRowId(c.getSelRow()).split("|");
                var p ="idRujukUnit*-*"+sisipan[0]+"*|*JnsLayanan*-*"+sisipan[1]+"*|*TmpLayanan*-*"+sisipan[2]+"*|*cmbDokRujukUnit*-*"+sisipan[3]+"*|*btnHapusRujukUnit*-*false";
                //alert(c.cellsGetValue(c.getSelRow(),4));
                document.getElementById('txtKetRujuk').innerHTML=c.cellsGetValue(c.getSelRow(),4);
                fSetValue(window,p);
            }
            function ambilDataRujukRS(){
                //alert(c.getRowId(c.getSelRow()));
                var sisipan=d.getRowId(d.getSelRow()).split("|");
                var p ="idRujukRS*-*"+sisipan[0]+"*|*cmbRS*-*"+sisipan[1]+"*|*cmbDokRujukRS*-*"+sisipan[2]+"*|*btnHapusRujukRS*-*false";
                fSetValue(window,p);
            }

            function ambilDataKamar(){
                var sisipan=e.getRowId(e.getSelRow()).split("|");
                var p ="idSetKamar*-*"+sisipan[0]+"*|*cmbKamar*-*"+sisipan[1]+"*|*btnHapusKamar*-*false";
                fSetValue(window,p);
            }


            function hapus(id)
            {
                var rowidTind = document.getElementById("id_tind").value;
                var rowidDiag = document.getElementById("id_diag").value;
                var rowidRujukUnit = document.getElementById("idRujukUnit").value;
                var rowidRujukRS = document.getElementById("idRujukRS").value;
                var rowidKamar = document.getElementById("idSetKamar").value;

                switch(id)
                {
                    case 'btnHapusTind':
                        if(confirm("Anda yakin menghapus Tindakan "+a.cellsGetValue(a.getSelRow(),3)))
                        {
                            a.loadURL("tindiag_utils.php?grd=true&act=hapus&hps="+id+"&pelayanan_id=<?=$pelayanan_id;?>&rowid="+rowidTind,"","GET");
                            //alert("tindiag_utils.php?grd=true&act=hapus&hps="+id+"&pelayanan_id=<?=$pelayanan_id;?>&rowid="+rowidTind);
                        }
                        batal('btnBatalTind');
                        break;

                    case 'btnHapusDiag':
                        if(confirm("Anda yakin menghapus Diagnosa "+b.cellsGetValue(b.getSelRow(),3)))
                        {
                            //alert("tindiag_utils.php?grd1=true&act=hapus&hps="+id+"&rowid="+rowidDiag);
                            b.loadURL("tindiag_utils.php?grd1=true&act=hapus&hps="+id+"&pelayanan_id=<?=$pelayanan_id;?>&rowid="+rowidDiag,"","GET");
                        }
                        document.getElementById("txtDiag").value = '';
                        break;
                    case 'btnHapusRujukUnit':
                        if(confirm("Anda yakin menghapus rujukan ke unit "+c.cellsGetValue(c.getSelRow(),2))){
                            //alert("tindiag_utils.php?grd2=true&act=hapus&hps="+id+"&pasienId=<? echo $pasienId;?>&unitAsal=<?php echo $unit_id;?>&rowid="+rowidRujukUnit);
                            c.loadURL("tindiag_utils.php?grd2=true&act=hapus&hps="+id+"&pasienId=<? echo $pasienId;?>&unitAsal=<?php echo $unit_id;?>&rowid="+rowidRujukUnit,"","GET");
                        }
                        break;
                    case 'btnHapusRujukRS':
                        if(confirm("Anda yakin menghapus rujukan ke RS "+d.cellsGetValue(d.getSelRow(),2))){
                            //alert("tindiag_utils.php?grd2=true&act=hapus&hps="+id+"&pasienId=<? echo $pasienId;?>&unitAsal=<?php echo $unit_id;?>&rowid="+rowidRujukUnit);
                            d.loadURL("tindiag_utils.php?grd3=true&act=hapus&hps="+id+"&pelayanan_id=<? echo $pelayanan_id;?>&rowid="+rowidRujukRS,"","GET");
                        }
                        break;
                    case 'btnHapusKamar':
                        if(confirm("Anda yakin menghapus set kamar "+e.cellsGetValue(e.getSelRow(),3)+" pada "+e.cellsGetValue(e.getSelRow(),2)) ){
                            //alert("tindiag_utils.php?grd2=true&act=hapus&hps="+id+"&pasienId=<? echo $pasienId;?>&unitAsal=<?php echo $unit_id;?>&rowid="+rowidRujukUnit);
                            e.loadURL("tindiag_utils.php?grd4=true&act=hapus&hps="+id+"&pelayanan_id=<? echo $pelayanan_id;?>&rowid="+rowidKamar,"","GET");
                            fSetValue(window,'btnHapusKamar*-*true');
                        }
                        break;
                    }
                }

                function batal(id)
                {
                    switch(id)
                    {
                        case 'btnBatalTind':
                            var p="id_tind*-**|*txtTind*-**|*txtBiaya*-**|*txtKet*-**|*txtQty*-**|*chkTind*-*false*|*btnSimpanTind*-*Tambah*|*btnHapusTind*-*true";
                            fSetValue(window,p);
                            document.getElementById('trUnit').style.visibility='collapse';
                            unitId=<?php echo $unit_id?>;
                            break;

                        case 'btnBatalDiag':
                            var p="diagnosa_id*-**|*txtDiag*-**|*btnSimpanDiag*-*Tambah*|*btnHapusDiag*-*true";
                            fSetValue(window,p);
                            break;
                        }
                    }
                    function isiCombo(id,val,defaultId,targetId,evloaded){
                        //alert('pasien_list.php?act=combo&id='+id+'&value='+val);
                        if(targetId=='' || targetId==undefined){
                            targetId=id;
                        }
                        Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);

                    }

                    function setDok(ke,target){
                        isiCombo('cmbDok','<?php echo $unit_id;?>',ke,target);
                    }

                    function goFilterAndSort(grd){
                        //alert(grd);
                        if (grd=="gridbox"){
                            a.loadURL("tindiag_utils.php?grd=true&pelayanan_id=<?=$pelayanan_id;?>&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
                        }else if (grd=="gridbox1"){
                            b.loadURL("tindiag_utils.php?grd1=true&pelayanan_id=<?=$pelayanan_id;?>&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
                        }else if (grd=="gridboxRujukUnit"){
                            b.loadURL("tindiag_utils.php?grd2=true&pasienId=<? echo $pasienId;?>&unitAsal=<?php echo $unit_id;?>&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
                        }
                    }

                    var c=new DSGridObject("gridboxRujukUnit");
                    c.setHeader("DATA RUJUK UNIT");
                    c.setColHeader("NO,UNIT,DOKTER,KETERANGAN");
                    //c.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
                    c.setColWidth("30,100,200,150");
                    c.setCellAlign("center,left,left,left,left");
                    c.setCellHeight(20);
                    c.setImgPath("../icon");
                    //c.setIDPaging("pagingRujukUnit");
                    c.attachEvent("onRowClick","ambilDataRujukUnit");
                    c.baseURL("tindiag_utils.php?grd2=true&pasienId=<? echo $pasienId;?>&unitAsal=<?php echo $unit_id;?>");
                    c.Init();

                    var d=new DSGridObject("gridboxRujukRS");
                    d.setHeader("DATA RUJUK RUMAH SAKIT");
                    d.setColHeader("NO,RUMAH SAKIT,DOKTER,KETERANGAN");
                    //c.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
                    d.setColWidth("30,200,200,150");
                    d.setCellAlign("center,left,left,left,left");
                    d.setCellHeight(20);
                    d.setImgPath("../icon");
                    //d.setIDPaging("pagingRujukRS");
                    d.attachEvent("onRowClick","ambilDataRujukRS");
                    d.baseURL("tindiag_utils.php?grd3=true&pelayanan_id=<? echo $pelayanan_id;?>");
                    d.Init();

                    var e=new DSGridObject("gridboxKamar");
                    e.setHeader("DATA SET KAMAR");
                    e.setColHeader("NO,TGL MASUK,KAMAR,BIAYA");
                    //c.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
                    e.setColWidth("30,150,100,100");
                    e.setCellAlign("center,left,left,left");
                    e.setCellHeight(20);
                    e.setImgPath("../icon");
                    //d.setIDPaging("pagingRujukRS");
                    e.attachEvent("onRowClick","ambilDataKamar");
                    e.baseURL("tindiag_utils.php?grd4=true&pelayanan_id=<? echo $pelayanan_id;?>");
                    e.Init();

    </script>
</html>
<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
$user_id = $_SESSION['userId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>

        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
        <!--diatas ini diperlukan untuk menampilkan popup-->

        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!-- untuk ajax-->
        <style type="text/css">
            #komTab th{
                background-color:#6BF4ED;
                font-weight:bold;
            }
            #komTab tr:hover{
                background-color:#6EF202;
            }
        </style>
        <title>Form Tindakan Kelas</title>
    </head>

    <body>
        <div align="center">
            <?php
			include("../koneksi/konek.php");
            include("../header1.php");
            ?>
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM TINDAKAN KELAS</td>
                </tr>
            </table>
            <table width="1000" border="0" cellspacing="1" cellpadding="0" align="center" class="tabel">
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
                    <td align="right">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Tindakan&nbsp;</td>
                    <td>&nbsp;<select id="cmbTind" name="cmbTind" class="txtinput">
                            <?php
                            $rs = mysql_query("SELECT * FROM b_ms_tindakan");
                            while($rows=mysql_fetch_array($rs)):
                                ?>
                            <option value="<?=$rows["id"]?>"><?=$rows["nama"]?></option>
                            <?	endwhile;?>
                        </select></td>
                    <td align="right">
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Kelas&nbsp;</td>
                    <td>&nbsp;<select id="cmbKls" name="cmbKls" class="txtinput">
                            <?php
                            $dt = mysql_query("SELECT * FROM b_ms_kelas");
                            while($rw=mysql_fetch_array($dt)):
                                ?>
                            <option value="<?=$rw["id"]?>"><?=$rw["nama"]?></option>
                            <?	endwhile;?>
                        </select></td>
                    <td align="right"></td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Tarif&nbsp;</td>
                    <td>&nbsp;<input class="txtinput" id="txtTarif" name="txtTarif" size="16" readonly="readonly" value="0" />
                        <input type="button" value="set tarif" onclick="getTarif();" class="btninput"/>
                    </td>
                    <td align="right"></td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Status&nbsp;</td>
                    <td>&nbsp;<label><input type="checkbox" id="isAktif" name="isAktif" class="txtinput" />&nbsp;Aktif</label></td>
                    <td align="right">
                    </td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;<input id="txtId" type="hidden" name="txtId" /></td>
                    <td height="30">
                        <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" disabled="disabled" class="tblHapus"/>
                        <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>	</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>
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
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="5">
                        <div id="gridbox" style="width:925px; height:200px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:925px;"></div>	</td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="20%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="20%">&nbsp;</td>
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
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr height="30">
                    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" class="btninput"/></td>
                    <td>&nbsp;</td>
                    <td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" /></a>&nbsp;</td>
                </tr>
            </table>
        </div>
        <div id="div_tarif" style="display:none;width:300px" class="popup">
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
            <fieldset><legend>Komponen Tarif</legend>
                <table id="komTab" border="0">
                    <tr>
                        <th>komponen</th>
                        <th>harga</th>
                    </tr>
                    <?php
                    $sql3 = "SELECT id,kode,nama,tarip_default,aktif FROM b_ms_komponen where aktif=1";
                    $rs3 = mysql_query($sql3);
                    $i=0;
                    while($rw3 = mysql_fetch_array($rs3)) {
                        ?>
                    <tr>
                        <td><label><input type="checkbox" name="chKom" id="<?php echo "komp_".$i?>" value="<?php echo $rw3['id'];?>" onclick="setTarif(this,document.getElementById('<?php echo "hrgkom_".$i;?>'));"/>
                                    <?php echo $rw3['nama']?></label></td>
                        <td><input type="text" size="5" readonly="readonly" id='<?php echo "hrgkom_".$i;?>' value='<?php echo $rw3['tarip_default']?>' ondblclick="this.readOnly=false;" onblur="this.readOnly=true;simpanKom('<?php echo $rw3['id'];?>',this.value);" onkeyup="if(event.which==13){this.readOnly=true;simpanKom('<?php echo $rw3['id'];?>',this.value);}"/></td>
                    </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </table>
            </fieldset>
        </div>
    </body>
    <script type="text/JavaScript">
        function getTarif(){
            new Popup('div_tarif',null,{modal:true,position:'center',duration:1});
            document.getElementById('div_tarif').popup.show();
        }
        function setTarif(m,n)
        {

            if(m.checked==true)
            {

                document.getElementById('txtTarif').value = parseInt(document.getElementById('txtTarif').value) + parseInt(n.value);
            }
            else
            {
                document.getElementById('txtTarif').value = parseInt(document.getElementById('txtTarif').value) - parseInt(n.value);
            }
        }

        function simpanKom(id,harga){
            //alert(id+" "+harga);
            //alert("tindakan_kls_utils.php?act=simpanKomponen&id="+id+"&harga="+harga);
            var saveKom = new newRequest();
            saveKom.xmlhttp.open("GET","tindakan_kls_utils.php?act=simpanKomponen&id="+id+"&harga="+harga+"&user_id=<?php echo $user_id; ?>");
            saveKom.xmlhttp.onreadystatechange=function(){
                if(saveKom.xmlhttp.readyState==4){
                    var hsl = saveKom.xmlhttp.responseText;
                    if(hsl==1){
                        alert('update harga sukses');
                    }
                    else if(hsl==-1){
                        alert('update harga gagal');
                    }
                }
            }
            saveKom.xmlhttp.send(null);
        }

        function simpan(action)
        {

            var id = document.getElementById("txtId").value;
            var tind = document.getElementById("cmbTind").value;
            var kls = document.getElementById("cmbKls").value;
            var tarif = document.getElementById("txtTarif").value;

            var i=0,j=0;
            var param='';
            var getI=<?php echo $i;?>;
            //for(var i=0;i<getI;i++){
            while(i<getI){
                if(document.getElementById('komp_'+i).checked==true){
                    param+=document.getElementById('komp_'+i).value+'|'+document.getElementById('hrgkom_'+i).value+'-';
                }
                i++;
            }
            if(param!=''){
                param=param.substr(0,param.length-1);
            }
            //}

            if(document.getElementById("isAktif").checked == true)
            {
                var aktif = 1;
            }
            else
            {
                var aktif = 0;
            }



            //alert("tindakan_kls_utils.php?grd=true&act="+action+"&id="+id+"&tind="+tind+"&kls="+kls+"&tarif="+tarif+"&aktif="+aktif+"&param="+param);
            a.loadURL("tindakan_kls_utils.php?grd=true&act="+action+"&id="+id+"&tind="+tind+"&kls="+kls+"&tarif="+tarif+"&aktif="+aktif+"&param="+param+"&user_id=<?php echo $user_id; ?>","","GET");

            batal();


        }

        function ambilData()
        {
            batal();
            var terima=a.getRowId(a.getSelRow()).split('&');
            for(var i=1;i<terima.length;i++){
                var t=terima[i].split("|");
                for(var j=0;j<document.getElementsByName('chKom').length;j++){
                    if(document.getElementById('komp_'+j).value==t[1]){
                        document.getElementById('komp_'+j).checked=true;
                    }
                }
            }

            var p="txtId*-*"+terima[0]+"*|*cmbTind*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*cmbKls*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*txtTarif*-*"+a.cellsGetValue(a.getSelRow(),4)+"*|*isAktif*-*"+((a.cellsGetValue(a.getSelRow(),5)=='Aktif')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
            //alert(p);
            fSetValue(window,p);
        }

        function hapus()
        {
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
            if(confirm("Anda yakin menghapus Tindakan Kelas "+a.cellsGetValue(a.getSelRow(),3)))
            {
                a.loadURL("tindakan_kls_utils.php?grd=true&act=hapus&rowid="+rowid,"","GET");
            }

            document.getElementById("cmbTind").value = '';
            document.getElementById("cmbKls").value = '';
            document.getElementById("txtTarif").value = '';
            document.getElementById("isAktif").checked = false;
        }

        function batal()
        {
            var par='';
            var i=0;
            var getI=<?php echo $i;?>;
            while(i<getI){
                par+="*|*komp_"+i+"*-*false";
                i++;
            }

            var p="txtId*-**|*cmbTind*-**|*cmbKls*-**|*txtTarif*-*0"+par+"*|*isAktif*-*false*|*btnSimpan*-*Tambah*|*btnHapus*-*true";

            //alert(p);
            fSetValue(window,p);
        }

        function goFilterAndSort(grd){
            //alert(grd);
            if (grd=="gridbox"){
                //alert("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
                a.loadURL("tindakan_kls_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
            }/*else if (grd=="gridbox1"){
                        //alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
                        b.loadURL("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
                }*/
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("DATA TINDAKAN KELAS");
        a.setColHeader("NO,TINDAKAN,KELAS,TARIF,STATUS AKTIF");
        a.setIDColHeader(",tind,kls,,");
        a.setColWidth("50,120,100,100,75");
        a.setCellAlign("center,left,left,left,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.baseURL("tindakan_kls_utils.php?grd=true");
        a.Init();
    </script>
</html>

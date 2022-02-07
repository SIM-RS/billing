<?php
session_start();
include("../../sesi.php");
$qstr_ma_sak = "par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$cabang = ($_REQUEST['cabang'] > 0) ? $_REQUEST['cabang'] : 1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
    <script type="text/javascript" language="JavaScript" src="../../pembayaran/datatables/jQuery-3.3.1/jquery-3.3.1.js"></script>
    <link type="text/css" rel="stylesheet" href="../../theme/bs/bootstrap.min.css" />
    <script type="text/javascript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
    <!-- untuk ajax-->
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
    <script type="text/javascript" language="JavaScript" src="../../theme/bs/bootstrap.min.js"></script>
    <!-- end untuk ajax-->
    <title>Tempat Layanan</title>
</head>

<body>
    <div align="center">
        <?php
        include("../../koneksi/konek.php");
        include("../../header1.php");
        ?>
        <iframe height="72" width="130" name="sort" id="sort" src="../../theme/dsgrid_sort.php" scrolling="no" frameborder="0" style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
            <tr>
                <td height="30">&nbsp;FORM TEMPAT LAYANAN</td>
            </tr>
        </table>
        <table width="1000" border="0" cellspacing="0" cellpadding="2" align="center" class="tabel">
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>

            <tr>
                <td width="5%">&nbsp;</td>
                <td width="10%" align="right">Cabang</td>
                <td width="45%">
                    <select name="cabang" id="cabang" class="txtinput" onchange="changeCabang(this.value);">
                        <?php
                        /* $sCabang = "select id, nama from b_profil where aktif = 1";
								$qCabang = mysql_query($sCabang);
								if(mysql_num_rows($qCabang) > 0){
									while($dCab = mysql_fetch_array($qCabang)){
										$select = '';
										if($dCab['id'] == $cabang){
											$select = "selected";
										}
										echo "<option value='".$dCab['id']."' {$select}>".$dCab['nama']."</option>";
									}
								} else {
									echo "<option value='1'>Rumah Sakit</option>";
								} */
                        ?>
                    </select>
                </td>
                <td width="20%">&nbsp;</td>
                <td width="5%">&nbsp;</td>
            </tr>
            <tr>
                <td width="5%">&nbsp;</td>
                <td width="10%" align="right">Loket</td>
                <td width="45%">
                    <select id="txtLoket" name="txtLoket" onchange="setCakupan(this.value)" class="txtinput">
                        <?php
                        $sql = "SELECT * FROM b_ms_unit mu WHERE mu.kategori=1 AND mu.level=2 AND mu.aktif=1";
                        $rs = mysql_query($sql);
                        while ($rw = mysql_fetch_array($rs)) {
                            ?>
                            <option value="<?php echo $rw["id"]; ?>"><?php echo $rw["nama"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
                <td width="20%">&nbsp;</td>
                <td width="5%">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="right">
                    <button class="btn btn-sm btn-primary" type="button" data-target="#tambahRm" data-toggle="modal">TAMBAH RM</button>
                </td>
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
                    <div id="paging" style="width:900px;"></div>
                </td>
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
        <!--table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr>
                    <td height="30">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;"/></td>
                    <td></td>
                    <td align="right">
                        <a href="../index.php">
                            <input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;"/>
                        </a>&nbsp;
                    </td>
                </tr>
            </table-->
    </div>
    <div class="modal fade" id="tambahRm" tabindex="-1" aria-labelledby="tambahRmLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahRmLabel">Tambah RM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addRm">
                        <input type="hidden" name="idRm" id="idRm">
                        <div class="form-group">
                            <label for="">Nama Rm</label>
                            <input type="text" name="nama_rm" id="nama_rm" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Link</label>
                            <input type="text" name="link" id="link" class="form-control">
                        </div>
                    </form>

                    <div id="gridboxRM" style="width:750px; height:300px; background-color:white; overflow:hidden;"></div>
                    <div id="pagingRM" style="width:750px;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="resetAll()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-action" value="tambah" onclick="addNewRm(this.value)">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rmUnit" tabindex="-1" aria-labelledby="rmUnitLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rmUnitLabel">Tambah RM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="gridboxRMUnit" style="width:750px; height:300px; background-color:white; overflow:hidden;"></div>
                    <div id="pagingRMUnit" style="width:750px;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="resetAll()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-action" value="tambah" onclick="addNewRm(this.value)">Save</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    var a = new DSGridObject("gridbox");
    a.setHeader("UNIT PELAYANAN");
    a.setColHeader("KODE,NAMA,JENIS LAYANAN,STATUS INAP,ACTION");
    a.setIDColHeader("kode,nama,,,");
    a.setColWidth("100,300,250,100,100");
    a.setCellAlign("center,left,left,center,center");
    a.setCellHeight(20);
    a.setImgPath("../../icon");
    a.setIDPaging("paging");
    //a.attachEvent("onRowClick","ambilData");
    //a.onLoaded(konfirmasi);
    a.baseURL("utils.php?idloket=" + document.getElementById("txtLoket").value+"&grd=");
    a.Init();

    var b = new DSGridObject("gridboxRM");
    b.setHeader("RM");
    b.setColHeader("NAMA,LINK,");
    b.setIDColHeader(",");
    b.setColWidth("200,300,100");
    b.setCellAlign("center,left,center");
    b.setCellHeight(20);
    b.setImgPath("../../icon");
    b.setIDPaging("pagingRM");
    b.attachEvent("onRowClick","ambilData");
    b.baseURL("utils.php?grd=rm");
    b.Init();

    var c = new DSGridObject("gridboxRMUnit");
    c.setHeader("RM");
    c.setColHeader(",NAMA");
    c.setIDColHeader(",");
    c.setColWidth("50,300");
    c.setCellAlign("center,left");
    c.setCellHeight(20);
    c.setImgPath("../../icon");
    c.setIDPaging("pagingRMUnit");

    function addNewRm(val){
        let namaRm = jQuery('#nama_rm').val();
        let link = jQuery('#link').val();
        let id = jQuery('#idRm').val();
        jQuery.ajax({
            url : 'utils_act.php',
            method:'post',
            data:{
                id_rm : id,
                action : val,
                nama : namaRm,
                link : link,
            },
            dataType : 'json',
            success:function(data){
                if(data.status == 1){
                    alert(data.msg);
                    loadUlang();
                    resetAll();
                }else{
                    alert(data.msg);
                    resetAll();
                }
            }
        });
    }

    function loadUlang(){
        b.baseURL("utils.php?grd=rm");
        b.Init();
    }
    function update(obj) {
        //alert(obj.value+' - '+obj.checked);
        a.loadURL("utils.php?act=update&idloket=" + document.getElementById("txtLoket").value + "&idunit=" + obj.value + "&ischecked=" + obj.checked, "", "GET");
    }

    function isiCombo(id, val, defaultId, targetId, evloaded, all = 1) {
        if (targetId == '' || targetId == undefined) {
            targetId = id;
        }
        Request('../../combo_utils.php?all=' + all + '&id=' + id + '&value=' + val + '&defaultId=' + defaultId, targetId, '', 'GET', evloaded, 'ok');
    }

    function setCakupan(val) {
        var cab = document.getElementById('cabang').value;
        a.loadURL("utils.php?idloket=" + document.getElementById("txtLoket").value + "&cabang=" + cab, "", "GET");
    }

    function goFilterAndSort(grd) {
        //alert("utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
        a.loadURL("utils.php?idloket=" + document.getElementById("txtLoket").value + "&filter=" + a.getFilter() + "&sorting=" + a.getSorting() + "&page=" + a.getPage(), "", "GET");
    }

    function changeCabang(cab) {
        isiCombo('loketCabang', cab, 'txtLoket', 'txtLoket', lgrid);
    }

    function lgrid() {
        var cab = document.getElementById('cabang').value;
        a.loadURL("utils.php?idloket=" + document.getElementById("txtLoket").value + "&cabang=" + cab, "", "GET");
    }

    isiCombo('listcabang', '', '<?php echo $cabang; ?>', 'cabang', function() {
        isiCombo('loketCabang', document.getElementById('cabang').value, '', 'txtLoket', lgrid);
    }, 0);

    function resetAll(){
        document.getElementById('addRm').reset();
        jQuery('#btn-action').val('tambah');
        jQuery('#btn-action').html('Save');
    }

    function loadRmUnit(val){
        c.baseURL("utils.php?grd=rmUnit&id_unit="+val);
        c.Init();
    }

    function addRmUnit(elm,val){
        let action = "";
        if(elm.checked == false) action = "deleteRmUnit";
        else action = "tambahRmUnit";
        var pecah = val.split('|');
        jQuery.ajax({
            url: 'utils_act.php',
            method : 'post',
            data : {
                action : action,
                id_rm : pecah[1],
                id_unit : pecah[0],
            },
            dataType:'json',
            success:function(data){
                if(data.status == 1){
                    alert(data.msg);
                    loadRmUnit(pecah[0]);
                }else{
                    alert(data.msg);
                }
            }
        });
    }

    function ambilData(){
        let data = b.getRowId(b.getSelRow()).split("|");
        let idRm = data[0];
        let nama = data[1];
        let link = data[2];
        jQuery('#idRm').val(idRm);
        jQuery('#nama_rm').val(nama);
        jQuery('#link').val(link);
        jQuery('#btn-action').val('updateData');
        jQuery('#btn-action').html('ubah');
    }

    function deleteRm(val){
        jQuery.ajax({
            url: 'utils_act.php',
            method : 'post',
            data : {
                action : 'deleteRm',
                id_rm : val,
            },
            dataType: 'json',
            success:function(data){
                if(data.status == 1){
                    alert(data.msg);
                    loadUlang();
                    resetAll();
                }else{
                    alert(data.msg);
                    resetAll();
                }
            }
        });
    }
</script>

</html>
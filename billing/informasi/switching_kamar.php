<?php
session_start();
include "../sesi.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../pembayaran/datatables/bootstrap.css">

        <title>Switching Kamar</title>
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
                    <td height="30">&nbsp;SWITCHING KAMAR</td>
                </tr>
            </table>
            <table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center" id="div_masterkamar">
                <tr>
                    <td colspan="7" style="padding:2%">
                    <?php if ($_GET['msg']=='success'): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil!</strong> Kamar berhasil di switch.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php elseif ($_GET['msg'] == 'error'): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal!</strong> Kamar gagal di switch.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif ?>
                    </td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="20%" align="right">Jenis Layanan :</td>
                    <td width="20%">&nbsp;
                        <select id="JnsLayanan" name="JnsLayanan" onchange="showTmpLay(this.value)" class="txtinput">
                            <?php
                            $query = "select id,nama from b_ms_unit where aktif=1 and level=1 and inap = 1 and id<>68";
                            $rs = mysql_query($query);
                            while($row=mysql_fetch_array($rs)){
                            ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['nama']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                    <td width="10%">&nbsp;</td>
                    <td width="20%" align="right"></td>
                    <td width="20%"></td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Tempat Layanan :</td>
                    <td>&nbsp;
                        <select id="TmpLayanan" name="TmpLayanan" onchange="showTabel()" class="txtinput">
                        </select>
                    </td>
                    <td>&nbsp;</td>
                    <!-- <td align="right">&nbsp;</td> -->
                    <td>&nbsp;</td>
                    <td align="right">
                        <button type="button" id="btnSwitching" class="btn btn-primary btn-sm">
                            Set Switching Kamar
                        </button>
                    </td>
                    <!-- <td>&nbsp;</td> -->
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
                    <td colspan="5" align="center">
                        <div id="gridbox" style="width:900px; height:350px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="7">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="6" align="right">
                        <button type="button" id="btnRiwayatSwitching" class="btn btn-secondary btn-sm">
                            Riwayat Switching Kamar
                        </button>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="7">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="7">&nbsp;</td>
                </tr>
            </table>
            <table border="0" class="hd2" width="1000">
                <tr>
                    <td><input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalSwitching" tabindex="-1" role="dialog" aria-labelledby="modalSwitchingLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="switching_kamar_action.php" method="POST">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="modalSwitchingLabel">Switching Kamar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row" style="display:none">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Kamar</label>
                                        <input type="text" class="form-control" name="namakamar_pilihan" id="namakamar_pilihan" readonly="true">
                                        <input type="hidden" name="id_kamar_pilihan" id="id_kamar_pilihan">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Jumlah Bed Tersedia Saat Ini</label>
                                        <input type="text" class="form-control" id="jumlahbed_pilihan" readonly="true">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tempat Layanan Tujuan</label>
                                        <select id="jenis_layanan" name="jenis_layanan" onchange="showListKamar(this.value)" class="form-control">
                                            <option value="">Pilih Kelas Tempat Layanan</option>
                                            <?php
                                            $sql="select id, nama from b_ms_unit where aktif=1 and parent_id=27 order by nama";
                                            $rs = mysql_query($sql);
                                            while($row=mysql_fetch_array($rs)){
                                            ?>
                                                <option value="<?php echo $row['id'];?>"><?php echo $row['nama']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Kamar Tujuan</label>
                                        <select name="listKamarTujuan" id="listKamarTujuan" class="form-control">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Jumlah Bed Pindah</label>
                                        <input type="text" class="form-control" name="jumlahbedpindah" id="jumlahbedpindah" placeholder="Masukkan jumlah bed yang ingin di pindah" onkeyup="cekJumlahBed(this.value)" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Proses</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal History Switching -->
        <div class="modal fade" id="modalHistory" tabindex="-1" role="dialog" aria-labelledby="modalHistoryLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="switching_kamar_action.php" method="POST">
                        <div class="modal-header bg-secondary text-white">
                            <h5 class="modal-title" id="modalHistoryLabel">Riwayat Switching Kamar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php 
                                $swquery = mysql_query("SELECT sw.*, peg.nama FROM switching_history sw JOIN b_ms_pegawai peg ON peg.id = sw.user_id");
                            ?>
                            <ul class="list-group">
                                <?php while ($history = mysql_fetch_array($swquery)): ?>
                                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">Switching Kamar #<?= $history['id'] ?></h5>
                                            <small class="text-muted"><?= $history['tanggal'] ?></small>
                                        </div>
                                        <p class="mb-1"><?= $history['keterangan'] ?></p>
                                        <small class="text-muted"><?= $history['nama'] ?></small>
                                    </a>
                                <?php endwhile ?>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="../pembayaran/datatables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
        <script src="../pembayaran/datatables/jQuery-3.3.1/bootstrap.min.js"></script>
        <script src="../pembayaran/datatables/jQuery-3.3.1/popper.min.js"></script>
    </body>
    <script type="text/JavaScript" language="JavaScript">
        //isiCombo('JnsLayanan','','','',showTmpLay);
        function showTmpLay(val){
            isiCombo('TmpLayanan',val,'','',showTabel);
        }
        //isiCombo('cmbKlasi');
        function isiCombo(id,val,defaultId,targetId,evloaded){
            //alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET');
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
        }

        function showTabel(){
            //alert("tabel_utils.php?grdkmr=true&jns="+document.getElementById('JnsLayanan').value+"&unit_id="+document.getElementById('TmpLayanan').value);
            //alert("tabel_utils.php?grdkmr=true&unit_id="+document.getElementById('TmpLayanan').value);
			a.loadURL("tabel_utils.php?grdkmr=true&unit_id="+document.getElementById('TmpLayanan').value,"","GET");
            //&jns="+document.getElementById('JnsLayanan').value+"
            //+"&cmbKlasi="+document.getElementById('cmbKlasi').value
        }
        function goFilterAndSort(grd){
            //alert(grd);≈
            if (grd=="gridbox"){
                a.loadURL("tabel_utils.php?grdkmr=true&unit_id="+document.getElementById('TmpLayanan').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
                //&jns="+document.getElementById('JnsLayanan').value+"
            }
        }
        showTmpLay(document.getElementById('JnsLayanan').value);
        var a=new DSGridObject("gridbox");
        a.setHeader("DATA KAMAR");
        a.setColHeader("NO,KAMAR,KELAS,TARIF,JUMLAH TEMPAT TIDUR,JUMLAH TEMPAT TIDUR TOTAL,JUMLAH KAMAR TERPAKAI,JUMLAH KAMAR YANG TERSEDIA");
        a.setIDColHeader(",kamar,,,,,,,");
        a.setColWidth("50,200,100,90,80,80,80,80,80");
        a.setCellAlign("center,left,center,right,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowDblClick","tes1");
        a.baseURL("tabel_utils.php?grdkmr=true&unit_id="+document.getElementById('TmpLayanan').value);
            //&jns="+document.getElementById('JnsLayanan').value+"
        a.Init();

        function setSwitching(){		
            var sisipan=a.getRowId(a.getSelRow()).split("|");
            var idKamar = sisipan[0];

            document.getElementById("txtIdUnit").value = sisipan[1];
            if(document.getElementById("div_masterKamar").style.display=='block'){				
                document.getElementById("div_masterKamar").style.display='none';
                document.getElementById("div_switching").style.display='block';
            }
            else{
                document.getElementById("div_masterKamar").style.display='block';
                document.getElementById("div_switching").style.display='none';			
            }
        }
    </script>
    <script>
        $('#btnSwitching').on('click', function(){
            var sisipan=a.getRowId(a.getSelRow()).split("|");
            var namaKamar = a.cellsGetValue(a.getSelRow(),2);
            var bedTersedia = a.cellsGetValue(a.getSelRow(),8);
            var idKamar = sisipan[0];
            
            if (idKamar != "") {
                $('#modalSwitching').modal('show');
                $('#id_kamar_pilihan').val(idKamar);
                $('#namakamar_pilihan').val(namaKamar);
                $('#jumlahbed_pilihan').val(bedTersedia);
            } else {
                alert("Anda belum memilih data kamar!");
            }
        });

        $('#btnRiwayatSwitching').on('click', function(){
            $('#modalHistory').modal('show');
        });

        function showListKamar(idKelas){
            $("#listKamarTujuan").html("");
            var notin = $('#id_kamar_pilihan').val();
            $.ajax({
                url: "tabel_utils.php?getListKamar=true&unit_id="+idKelas+"&id_kamar_kecuali="+notin,
                cache: false,
                type: 'GET',
                success: function(html){
                    $("#listKamarTujuan").append(html);
                }
            });
        }

        function cekJumlahBed(value){
            var jumlahBedTersedia = $('#jumlahbed_pilihan').val();
            if (value > jumlahBedTersedia) {
                alert("Jumlah Bed Pindah tidak boleh melebihi Jumlah Bed Tersedia!");
            }
        }
    </script>
</html>
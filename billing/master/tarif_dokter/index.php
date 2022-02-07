<?php
session_start();
include("../../sesi.php");
?>
<?php
//session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <!-- <script src="pembayaran/datatables/$-3.3.1/"></script> -->
  <!-- <script type="text/JavaScript" language="JavaScript" src="../../include/$/$-1.9.1.js"></script> -->
  <script type="text/javascript" src="../../pembayaran/datatables/jQuery-3.3.1/jquery-3.3.1.js"></script>
  <link type="text/css" rel="stylesheet" href="../../theme/mod.css">
  <link rel="stylesheet" href="../../theme/bs/bootstrap.min.css">
  <script language="JavaScript" src="../../theme/js/dsgrid.js"></script>
  <script language="JavaScript" src="../../theme/js/mod.js"></script>
  <link rel="stylesheet" type="text/css" href="../../theme/tab-view.css" />
  <script type="text/javascript" src="../../theme/js/tab-view.js"></script>
  <script type="text/javascript" src="../../theme/js/ajax.js"></script>
  <!--dibawah ini diperlukan untuk menampilkan popup-->
  <link rel="stylesheet" type="text/css" href="../../theme/popup.css" />
  <script type="text/javascript" src="../../theme/prototype.js"></script>
  <script type="text/javascript" src="../../theme/effects.js"></script>
  <script type="text/javascript" src="../../theme/popup.js"></script>

  <script type="text/javascript" src="../../theme/bs/bootstrap.min.js"></script>


  <!--diatas ini diperlukan untuk menampilkan popup-->
  <title>Master Tarif Pembagian Dokter dan RS</title>
</head>

<body>
  <div align="center">
    <?php
    include("../../koneksi/konek.php");
    include("../../header1.php");
    $user_id = $_SESSION['userId'];
    $unit_id = $_SESSION['unitId'];
    ?>
    <iframe height="72" width="130" name="sort" id="sort" src="../../theme/dsgrid_sort.php" scrolling="no" frameborder="0" style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
    </iframe>
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
      <tr>
        <td height="30">&nbsp;FORM PEMBAGIAN TARIF DOKTER DAN RS</td>
      </tr>
    </table>
    <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="center">
          <!-- <div class="TabView" id="TabView" style="width: 950px; height: 650px;"></div> -->
          <div id="gridDokter" style="width: 800px;height: 300px;"></div>
          <div id="pagingGridDokter" style="width: 800px;height: 300px;"></div>


          <!-- Modal -->
          <div class="modal fade" id="setTarifDokterRs" tabindex="-1" aria-labelledby="setTarifDokterRsLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="setTarifDokterRsLabel">PEMBAGIAN TARIF DOKTER</h5>
                  <button type="button" onclick="document.getElementById('nilai').value = '';resetFormInput()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-left">
                  <input type="hidden" name="idDokter" id="idDokter">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Nama Dokter</label>
                        <input type="text" name="namaDokter" id="namaDokter" class="form-control">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Spesialis</label>
                        <input type="text" name="spesialis" id="spesialis" class="form-control">
                      </div>
                    </div>
                  </div>
                  <form id="input-data">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="">Pilih Jenis Pembagian Pendapatan</label>
                          <select name="presentase" id="presentase" class="form-control">
                            <option>-</option>
                            <option value="1">Presentase</option>
                            <option value="2">Nominal</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Jumlah Tindakan Guarantee</label>
                          <input class="form-control text-right" type="text" name="jumlahGuarantee" id="jumlahGuarantee">
                        </div>
                        <div class="form-group">
                          <label for="">Pilih Jenis Guarantee</label>
                          <select class="form-control" name="presentaseGurantee" id="presentaseGurantee">
                            <option>-</option>
                            <option value="1">Presentase</option>
                            <option value="2">Nominal</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label for="">Nilai Pembagian Pendapatan Dokter dan Rs</label>
                          <input type="number" name="nilai" id="nilai" class="form-control text-right">
                        </div>
                        <div class="form-group">
                          <label for="">Nominal Gurantee</label>
                          <input type="text" name="nominalGurantee" id="nominalGurantee" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="">Nilai Guarantee</label>
                          <input type="text" name="nilaiGuaranteeJenis" id="nilaiGuaranteeJenis" class="form-control text-right">
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="id_tarif_dokter" id="id_tarif_dokter">
                    <button class="btn btn-sm btn-danger" type="button" id="btn-cancel" style="display: none;" onclick="resetFormInput()">Cancel</button>
                    <button class="btn btn-sm btn-primary" type="button" id="btn-update" style="display: none;" onclick="updateGuarantee()">Update</button>
                  </form>
                  <div class="row">
                    <div class="col-6">
                      <div id="grdDataTindakan" style="width:100%; height:320px; background-color:white; overflow:auto; padding-bottom:20px;"></div>
                      <div id="pagingGrdDataTindakan" style="width:410px;"></div>
                    </div>
                    <div class="col-1 align-items-center">
                      <input type="button" id="btnRight" value="" onclick="pindahKanan()" class="tblRight">
                      <br>
                      <input type="button" id="btnLeft" value="" onclick="pindahKiri()" class="tblLeft">
                    </div>
                    <div class="col-5">
                      <div id="grdDataTindakanDokter" style="width:100%; height:320px; background-color:white; overflow:auto; padding-bottom:20px;"></div>
                      <div id="pagingGrdDataTindakanDokter" style="width:410px;"></div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button onclick="document.getElementById('nilai').value = '';resetFormInput()" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="guarantee" tabindex="-1" aria-labelledby="guaranteeLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="guaranteeLabel">Guarantee Dokter</h5>
                  <button type="button" class="close" onclick="document.getElementById('formGuarantee').reset();document.getElementById('btnSave').value = 'tambahGuarantee';" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-left">
                  <form id="formGuarantee">
                    <input type="hidden" name="idGuarantee" id="idGuarantee">
                    <div class="form-group">
                      <input type="hidden" name="idDokterGuarantee" id="idDokterGuarantee" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="">Nominal Gurantee</label>
                      <input type="text" name="nominalGurantee" id="nominalGurantee" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="">Presentase Gurantee</label>
                      <input type="text" name="presentaseGurantee" id="presentaseGurantee" class="form-control">
                    </div>
                    <div class="form-group">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="guranteeAktif">
                        <label class="form-check-label" for="guranteeAktif">
                          Aktif Guarantee
                        </label>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button onclick="document.getElementById('formGuarantee').reset();document.getElementById('btnSave').value = 'tambahGuarantee';" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" id="btnSave" value="tambahGuarantee" onclick="simpanGuarantee(this.value)" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
      <tr height="30">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </div>
</body>
<script>
  //grid
  let gridTarifDokter = new DSGridObject("gridDokter");
  gridTarifDokter.setHeader("DATA DOKTER");
  gridTarifDokter.setColHeader("No,Nama Dokter,Spesialis,Action");
  gridTarifDokter.setIDColHeader(",p.nama,r.nama,");
  gridTarifDokter.setColWidth("20,250,150,200");
  gridTarifDokter.setCellAlign("right,left,left,center");
  gridTarifDokter.setCellHeight(30);
  gridTarifDokter.setImgPath("../../icon");
  gridTarifDokter.setIDPaging("pagingGridDokter");
  gridTarifDokter.baseURL("utils.php?grd=dokterData");
  gridTarifDokter.Init();

  let ktmcu = new DSGridObject("grdDataTindakan");
  ktmcu.setHeader("DATA TINDAKAN");
  ktmcu.setColHeader("<input type='checkbox' id='chk_ktmcu' onchange='cek_all(this.id)' />,Nama Tindakan,Nama Penjamin,Kelas,Tarif,Kelompok,Klasifikasi");
  ktmcu.setIDColHeader(",tindakan,nama_penjamin,kelas,tarip,kelompok,klasifikasi");
  ktmcu.setColWidth("20,250,150,100,100,100,100");
  ktmcu.setCellAlign("left,left,left,center,right,center,center");
  ktmcu.setCellType("chk,txt,txt,txt,txt,txt,txt");
  ktmcu.setCellHeight(20);
  ktmcu.setImgPath("../../icon");
  ktmcu.setIDPaging("pagingGrdDataTindakan");

  let ktmcu2 = new DSGridObject("grdDataTindakanDokter");
  ktmcu2.setHeader("DATA TINDAKAN");
  ktmcu2.setColHeader("<input type='checkbox' id='chk_ktmcu' onchange='cek_all(this.id)' />,Nama Tindakan,Nama Penjamin,Kelas,Tarif,Kelompok,Klasifikasi");
  ktmcu2.setIDColHeader(",tindakan,nama_penjamin,kelas,tarip,kelompok,klasifikasi");
  ktmcu2.setColWidth("20,250,150,100,100,100,100");
  ktmcu2.setCellAlign("left,left,left,center,right,center,center");
  ktmcu2.setCellType("chk,txt,txt,txt,txt,txt,txt");
  ktmcu2.setCellHeight(20);
  ktmcu2.setImgPath("../../icon");
  ktmcu2.setIDPaging("pagingGrdDataTindakanDokter");
  ktmcu2.attachEvent("onRowClick", "ambilDataTindakanKelas");


  function ambilDataTindakanKelas() {
    let data = ktmcu2.getRowId(ktmcu2.getSelRow()).split("|");
    console.log(data);
    jQuery('#id_tarif_dokter').val(data[0])
    jQuery('#nilai').val(data[1]);
    jQuery('#presentase').val(data[2]);
    jQuery('#presentase').trigger('change');
    jQuery('#jumlahGuarantee').val(data[3]);
    jQuery('#nominalGurantee').val(data[4]);
    jQuery('#nilaiGuaranteeJenis').val(data[5]);
    jQuery('#presentaseGurantee').val(data[6]);
    jQuery('#presentaseGurantee').trigger('change');

    jQuery('#btn-cancel').show();
    jQuery('#btn-update').show();
  }

  function resetFormInput() {
    document.getElementById('input-data').reset();
    jQuery('#btn-cancel').hide();
    jQuery('#btn-update').hide();
  }

  function updateGuarantee() {
    let id = document.getElementById('id_tarif_dokter').value;
    let idDokter = document.getElementById('idDokter').value;
    let presentase = document.getElementById('presentase').value;
    let nilai = document.getElementById('nilai').value;
    //guarantee
    let jumlahGuarantee = document.getElementById('jumlahGuarantee').value;
    let nominalGurantee = document.getElementById('nominalGurantee').value;
    let jenisGuarantee = document.getElementById('presentaseGurantee').value;
    let nilaiGuarantee = document.getElementById('nilaiGuaranteeJenis').value;
    ktmcu2.loadURL("utils.php?grd=dataTindakanDokter&act=update&id=" + id + "&user_id=<?php echo $user_id; ?>" + "&dokterId=" + idDokter + "&nilai=" + nilai + "&presentase=" + presentase + "&jumlahGuarantee=" + jumlahGuarantee + "&nominalGuarantee=" + nominalGurantee + "&jenisGuarantee=" + jenisGuarantee + "&nilaiGuarantee=" + nilaiGuarantee, "", "GET");
    resetFormInput();
  }


  function setIdDokter(val) {
    let data = val.split('|');
    jQuery('#idDokter').val(data[0]);
    jQuery('#namaDokter').val(data[1]);
    jQuery('#spesialis').val(data[2]);
    ktmcu.baseURL("utils.php?grd=dataTindakan&dokterId=" + data[0]);
    ktmcu2.baseURL("utils.php?grd=dataTindakanDokter&dokterId=" + data[0]);
    ktmcu.Init();
    ktmcu2.Init();
  }

  function goFilterAndSort(grd) {
    if (grd == "grdDataTindakan") {
      ktmcu.loadURL("utils.php?grd=dataTindakan&filter=" + ktmcu.getFilter() + "&sorting=" + ktmcu.getSorting() + "&page=" + ktmcu.getPage() + "&dokterId=" + jQuery('#idDokter').val(), "", "GET");
    } else {
      gridTarifDokter.loadURL("utils.php?grd=dokterData&filter=" + gridTarifDokter.getFilter() + "&sorting=" + gridTarifDokter.getSorting() + "&page=" + gridTarifDokter.getPage(), "", "GET")
    }
  }

  function pindahKanan() {
    let idTin = '';
    let idDokter = document.getElementById('idDokter').value;
    let presentase = document.getElementById('presentase').value;
    let nilai = document.getElementById('nilai').value;

    //guarantee
    let jumlahGuarantee = document.getElementById('jumlahGuarantee').value;
    let nominalGurantee = document.getElementById('nominalGurantee').value;
    let jenisGuarantee = document.getElementById('presentaseGurantee').value;
    let nilaiGuarantee = document.getElementById('nilaiGuaranteeJenis').value;

    if (nilai == '' || nominalGurantee == '' || jumlahGuarantee == '' || nilaiGuarantee == '') return alert('Form harus di isi semua terlebih dahulu');
    for (var i = 0; i < ktmcu.obj.childNodes[0].rows.length; i++) {
      if (ktmcu.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked) {
        var getBaris = ktmcu.getRowId(parseInt(i) + 1).split("|");
        var barisId = getBaris[0];
        idTin += barisId + ',';
      }
    }
    if (idTin == '') {
      alert("Silakan pilih tindakan!");
    } else {
      var sisip = ktmcu.getRowId(ktmcu.getSelRow()).split("|");
      ktmcu2.loadURL("utils.php?grd=dataTindakanDokter&act=tambah&idTindakanKelas=" + idTin + "&user_id=<?php echo $user_id; ?>" + "&dokterId=" + idDokter + "&nilai=" + nilai + "&presentase=" + presentase + "&jumlahGuarantee=" + jumlahGuarantee + "&nominalGuarantee=" + nominalGurantee + "&jenisGuarantee=" + jenisGuarantee + "&nilaiGuarantee=" + nilaiGuarantee, "", "GET");

      ktmcu.loadURL("utils.php?grd=dataTindakan&dokterId=" + idDokter, "", "GET");
      document.getElementById('nilai').value = '';
      document.getElementById('input-data').reset();
      idTin = '';
    }
  }

  function pindahKiri() {
    let idTin = '';
    let idDokter = document.getElementById('idDokter').value;
    for (var i = 0; i < ktmcu2.obj.childNodes[0].rows.length; i++) {
      if (ktmcu2.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked) {
        var getBaris = ktmcu2.getRowId(parseInt(i) + 1).split("|");
        var barisId = getBaris[0];
        idTin += barisId + ',';
      }
    }
    if (idTin == '') {
      alert("Silakan pilih tindakan!");
    } else {
      var sisip = ktmcu2.getRowId(ktmcu2.getSelRow()).split("|");
      ktmcu2.loadURL("utils.php?grd=dataTindakanDokter&act=deleteTindakanDokter&idTindakanKelas=" + idTin + "&dokterId=" + idDokter, "", "GET");
      ktmcu.loadURL("utils.php?grd=dataTindakan&dokterId=" + idDokter, "", "GET");
      idTin = '';
    }
  }

  function setGuaranteeDokter(val) {
    let data = val.split('|');
    jQuery('#idDokterGuarantee').val(data[0]);
    $.ajax({
      url: 'utils.php',
      method: 'post',
      data: {
        dokterId: data[0],
        act: 'checkGuarantee',
      },
      dataType: 'json',
      success: function(data) {
        if (data.status == 1) {
          jQuery('#idGuarantee').val(data.id);
          jQuery('#nominalGurantee').val(data.nominal);
          jQuery('#presentaseGurantee').val(data.prosentase);
          document.getElementById('guranteeAktif').checked = data.aktif_guarantee ? true : false;
          document.getElementById('btnSave').value = 'updateGuarantee';
        } else {
          document.getElementById('idGuarantee').value = '';
          document.getElementById('nominalGurantee').value = '';
          document.getElementById('presentaseGurantee').value = '';
          document.getElementById('guranteeAktif').checked = data.aktif_guarantee ? true : false;
          document.getElementById('btnSave').value = 'tambahGuarantee';
        }
      }
    });
  }

  function simpanGuarantee(val) {
    let idDokter = jQuery('#idDokterGuarantee').val();
    let idGuarantee = jQuery('#idGuarantee').val();
    let nominal = jQuery('#nominalGurantee').val();
    let prosentase = jQuery('#presentaseGurantee').val();
    let aktif_guarantee = document.getElementById('guranteeAktif').checked ? 1 : 0;
    let user_id = <?php echo $user_id; ?>;
    if (nominal == '' || prosentase == '') return alert('Harap Isi form terlebih dahulu');
    $.ajax({
      url: 'utils.php',
      method: 'post',
      data: {
        id: idGuarantee,
        dokterId: idDokter,
        nominal: nominal,
        prosentase: prosentase,
        aktif_guarantee: aktif_guarantee,
        user_id: user_id,
        act: val,
      },
      dataType: 'json',
      success: function(data) {
        setGuaranteeDokter(idDokter);
      }
    });
  }
</script>
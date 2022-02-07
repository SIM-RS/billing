<?php
session_start();
include "../sesi.php";
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$userId = $_SESSION['userId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
		<script type="text/javascript" src="../theme/popup.js"></script>

        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>

        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../theme/bs/bootstrap.min.css">

        <title>Status Pasien Pcr</title>
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
                    <td class="p-5">
                        <button id="editStatusPcr" type="button" style="font-weight: 600;" class="btn btn-warning btn-sm float-right mb-2" data-target="#hasilPcr" data-toggle="modal">
                            Edit status pcr pasien
                        </button>
                        <button onclick="refreshGrid()" class="btn btn-primary">Refresh</button>
                        <div id="gridbox" style="width:900px; height:250px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Modal tindakan pcr klinik krakatau -->
		<div class="modal fade" id="hasilPcr" tabindex="-1" aria-labelledby="hasilPcrLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="hasilPcrLabel">HASIL PCR <span id="nama_pasien"></span></h5><br>
				<button type="button" class="btn btn-info ml-3" onclick="cetakHasilPcr()">Cetak Hasil</button>
				<button type="button" class="btn btn-info ml-3" onclick="cetakHasilPcrAntigen()">Cetak Antigen</button>
		        <button type="button" id="btnCloseModal" class="close" onclick="kosong()" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<div class="alert alert-primary">
		      		<span id="no_registrasi_lab"></span>
		      	</div>
		      	<form id="hasilPcrForm">		
			        <div class="row">
			        	<div class="col-6">
			        		<div class="form-group">
					        	<label for="">Status Cek Pcr</label>
					        	<select class="form-control" name="statusCekPcr" id="statusCekPcr">
					        		<option value="NEGATIF SARS-COV-2">Negatif</option>
					        		<option value="POSITIF SARS-COV-2">Positif</option>
					        	</select>
					        </div>
			        		<div class="form-group">
			        			<label for="">Tanggal Validasi</label>
			      				<div class="input-group">
			      					<input id="tglValidasi" name="tglValidasi" readonly size="11"  class="form-control" type="text" value="<?= $tglGet == '' ? $date_now : $tglGet ?>" />
			      					<div class="input-group-prepend">
			      						<input type="button" name="btnTglValidasi" id="btnTglValidasi" value="&nbsp;V&nbsp;" class="btn btn-sm btn-info" onclick="gfPop.fPopCalendar(document.getElementById('tglValidasi'),depRange);"/>
			      					</div>
			      				</div>
			      			</div>
			      			<div class="form-group">
			      				<label for="">Keterangan</label>
			      				<textarea name="keteranganHasilPcr" id="keteranganHasilPcr" class="form-control"></textarea>
			      			</div>
			        	</div>
			        	<div class="col-6">
			        		<div class="form-group">
					        	<label for="">Kriteria Pasien</label>
					        	<select name="kriteria_pasien" id="kriteria_pasien" class="form-control">
					        		<option value="Suspect">Suspect</option>
					        		<option value="Probable">Probable</option>
					        		<option value="Terkonfirmasi Positif">Terkonfirmasi Positif</option>
					        	</select>
					        </div>
			      			<div class="form-group">
					        	<label for="">Tanggal Diterima</label>
						        <div class="input-group">
						        	<input id="tglDiteriam" name="tglDiteriam" readonly size="11"  class="form-control" type="text" value="<?= $tglGet == '' ? $date_now : $tglGet ?>" />
				      				<div class="input-group-prepend">
				      					<input type="button" name="btnTglDiterima" id="btnTglDiterima" value="&nbsp;V&nbsp;" class="btn btn-sm btn-info" onclick="gfPop.fPopCalendar(document.getElementById('tglDiteriam'),depRange);"/>
				      				</div>
				      			</div>
			      			</div>
			        	</div>
			        </div>
		      		<input type="hidden" name="idHasilPcrForm" id="idHasilPcrForm">
		      		<input type="hidden" name="idPasien" id="idPasien">
		      		<input type="hidden" name="idPelayanan" id="idPelayanan">
		      		<input type="hidden" name="idKunjungan" id="idKunjungan">
		      		<input type="hidden" name="noRmPasien" id="noRmPasien">
		      		<input type="hidden" name="ksoIdPasien" id="ksoIdPasien">
		      	</form>
		      </div>
		      <div class="modal-footer">
		        <button onclick="kosong()" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <!-- <button class="btn btn-success" type="button" id="closeBillBtn">Close Bill</button> -->
		        <button onclick="editStatusHasilPcr()" id="saveDataBtn" value="tambah" type="button" class="btn btn-primary">Save</button>
		      </div>
		    </div>
		  </div>
		</div>
        <span id="spanTar1" style="display:none"></span>

        <script src="../pembayaran/datatables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
        <script src="../pembayaran/datatables/jQuery-3.3.1/bootstrap.min.js"></script>
        <script src="../pembayaran/datatables/jQuery-3.3.1/popper.min.js"></script>
    </body>
    <script type="text/JavaScript" language="JavaScript">

        function refreshGrid(){
            gridPcr.baseURL("table_utils.php?grd=getDataPasienPcr");
            gridPcr.Init();
        }

        var gridPcr = new DSGridObject("gridbox");
        gridPcr.setHeader("DATA KAMAR");
        gridPcr.setColHeader("NO,NO RM,NAMA,NO REGISTRASI LAB,TANGGAL LAHIR,JENIS KELAMIN,STATUS,KATEGORI");
        gridPcr.setIDColHeader(",p.no_rm,p.nama,,,,,");
        gridPcr.setColWidth("50,90,200,100,100,150,100");
        gridPcr.setCellAlign("center,center,left,center,center,center,left,center");
        gridPcr.setCellHeight(20);
        gridPcr.setImgPath("../icon");
        gridPcr.setIDPaging("paging");
        gridPcr.attachEvent("onRowClick","ambilDataHasil");
        gridPcr.attachEvent("onRowDblClick","ambilDataHasil2");
        gridPcr.baseURL("table_utils.php?grd=getDataPasienPcr");
        gridPcr.Init();

        function ambilDataHasil(){
	        let dataPcr = gridPcr.getRowId(gridPcr.getSelRow()).split('|');
        	$('#idHasilPcrForm').val(dataPcr[0]);
        	$('#idPasien').val(dataPcr[1]);
        	$('#idPelayanan').val(dataPcr[2]);
        	$('#idKunjungan').val(dataPcr[3]);
        	$('#noRmPasien').val(dataPcr[4]);
        	$('#ksoIdPasien').val(dataPcr[5]);
        	$('#nama_pasien').html(dataPcr[6]);
        	$('#no_registrasi_lab').html(dataPcr[7]);
        	$.ajax({
        		url : 'function_pcr.php',
        		method : 'post',
        		data: {
        			act : 'cekCekOut',
        			id_pelayanan : dataPcr[2],
        			id_kunjungan : dataPcr[3],
        		},
        		dataType : 'json',
        		success:function(data){
        			if(data.status == 0){
        				document.getElementById('closeBillBtn').disabled = true;
        			}else{
        				document.getElementById('closeBillBtn').disabled = false;
        			}
        		}
        	})
        }

        function ambilDataHasil2(){
        	let dataPcr = gridPcr.getRowId(gridPcr.getSelRow()).split('|');
        	$('#idHasilPcrForm').val(dataPcr[0]);
        	$('#idPasien').val(dataPcr[1]);
        	$('#idPelayanan').val(dataPcr[2]);
        	$('#idKunjungan').val(dataPcr[3]);
        	$('#noRmPasien').val(dataPcr[4]);
        	$('#ksoIdPasien').val(dataPcr[5]);
        	$('#nama_pasien').html(dataPcr[6]);
        	$('#no_registrasi_lab').html(dataPcr[7]);
        	$.ajax({
        		url : 'function_pcr.php',
        		method : 'post',
        		data: {
        			act : 'cekCekOut',
        			id_pelayanan : dataPcr[2],
        			id_kunjungan : dataPcr[3],
        		},
        		dataType : 'json',
        		success:function(data){
        			if(data.status == 0){
        				document.getElementById('closeBillBtn').disabled = true;
        			}else{
        				document.getElementById('closeBillBtn').disabled = false;
        			}
        		}
        	}).done(function(){
	        	$('#editStatusPcr').trigger('click');
        	});
        }

        var pcr2 = new DSGridObject("gridboxpcr");
        pcr2.setHeader("DATA HASIL PCR");
        pcr2.setColHeader("NO,NAMA,DOKTER PENGIRIM,TANGGAL SWAB,STATUS");
        pcr2.setIDColHeader("no,nama,dokter_pengirim,tanggal_swab,status_cek_pcr");
        pcr2.setColWidth("20,185,200,100");
        pcr2.setCellAlign("center,left,center,center,center");
        pcr2.setCellType("txt,txt,txt,txt,txt");
        pcr2.setCellHeight(20);
        pcr2.setImgPath("../icon");
        pcr2.setIDPaging("pagginationpcr");
        pcr2.attachEvent("onRowClick","ambilDataPcr");

        function editStatusHasilPcr(){
        	document.getElementById('saveDataBtn').disabled = true;
        	let userId = <?= $_SESSION['userId'] ?>;
        	let idHasilPcr = $('#idHasilPcrForm').val();
        	let idPasienPcr = $('#idPasien').val();
        	let status = $('#statusCekPcr').val();
        	let kriterPasien = $('#kriteria_pasien').val();
        	let tanggalValidasi = cnvTglSql($('#tglValidasi').val());
        	let tanggalDiterima = cnvTglSql($('#tglDiteriam').val());
        	let keterangan = $('#keteranganHasilPcr').val();

        	$.ajax({
        		url : 'function_pcr.php',
        		method : 'post',
        		data : {
        			id : idHasilPcr,
        			id_pasien : idPasienPcr,
        			status_cek_pcr : status, 
        			user_id : userId,
        			kriteria_pasien : kriterPasien,
        			tanggal_validasi : tanggalValidasi,
        			tanggal_diterima : tanggalDiterima,
        			keterangan : keterangan,
        			act : 'update',
        		},
        		dataType:'json',
        		success:function(data){
        			if(data.status == 1){
        				$('#btnCloseModal').trigger('click');
        				document.getElementById('hasilPcrForm').reset();
        				alert('berhasil update status pcr');
			        	document.getElementById('saveDataBtn').disabled = false;
			        	gridPcr.baseURL("table_utils.php?grd=getDataPasienPcr");
				        gridPcr.Init();
        			}else{
        				alert('gagal update status pcr');
			        	gridPcr.loadURL("table_utils.php?grd=getDataPasienPcr");

			        	document.getElementById('saveDataBtn').disabled = false;
        			}
        		}

        	});
        }

        function closeBill(){
        	let getIdKunj = $('#idKunjungan').val();
        	let getIdPel = $('#idPelayanan').val();
        	let getNoRmPasien = $('#noRmPasien').val();
        	let getKsoId = $('#ksoIdPasien').val();

        	$.ajax({
        		url : '../unit_pelayanan/tindiag_utils.php',
        		method:'get',
        		data:{
        			act : 'tambah',
        			smpn : 'btnCekOut',
        			kunjungan_id : getIdKunj,
        			pelayanan_id : getIdPel,
        			userId : <?= $_SESSION['userId'] ?>
        		},
        		success:function(data){
        			if(data == "Berhasil check out."){
        				getDataTagihanPasien(getIdKunj,getIdPel,getNoRmPasien,getKsoId)
        			}else{
        				alert(data);
        			}
        		}
        	});
        }

        function goFilterAndSort(grd){
            if (grd=="gridbox"){
                gridPcr.loadURL("table_utils.php?grd=getDataPasienPcr&filter="+gridPcr.getFilter()+"&sorting="+gridPcr.getSorting()+"&page="+gridPcr.getPage(),"","GET");
            }
        }

        function kosong(){
        	$('#idHasilPcrForm').val("");
        	$('#idPasien').val("");
        	document.getElementById('saveDataBtn').disabled = false;        	
        }

        function getDataTagihanPasien(getIdKunj,getIdPel,getNoRmPasien,getKsoId){
        console.log(getIdKunj);
        console.log(getIdPel);
        console.log(getNoRmPasien);
        console.log(getKsoId);

    	let dataKirim = {
			'titipan' : "",
			'tagihan' : '',
			'keringanan' : '',
			'jaminan_kso' : '',

		};
		$.ajax({
				url : '../unit_pelayanan/get_pembayaran_data.php',
				method :'post',
				data : {
					kasir : 81,
					keyword : getNoRmPasien,
				},
				dataType : 'json',
				success:function(data){
					let pecahDataTagihan = data.split('|');
					console.log(pecahDataTagihan);
					dataKirim.titipan = pecahDataTagihan[12];
					dataKirim.tagihan = pecahDataTagihan[7];
					dataKirim.keringanan = 0;
					dataKirim.jaminan_kso = pecahDataTagihan[14] == '' ? 0 : pecahDataTagihan[14];

					//setelah checkout pasien di pulangkan
					if(getKsoId == 1){
						Request("../unit_pelayanan/krs/pasienKRS_utils.php?act=tambah&smpn=btnPasienPulang&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&userId=<?php echo $userId;?>"+"&idKasir="+81,'spanTar1','','GET',function(){},'ok');	
					}else{
						Request("../unit_pelayanan/krs/pasienKRS_utils.php?act=tambah&smpn=btnPasienPulang&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&userId=<?php echo $userId;?>"+"&idKasir="+81,'spanTar1','','GET',function(){
							alert('Berhasil closebill pasien');
                            $.ajax({
                                url : 'function_pcr.php',
                                method : 'post',
                                data: {
                                    act : 'cekCekOut',
                                    id_pelayanan : getIdPel,
                                    id_kunjungan : getIdKunj,
                                },
                                dataType : 'json',
                                success:function(data){
                                    if(data.status == 0){
                                        document.getElementById('closeBillBtn').disabled = true;
                                    }else{
                                        document.getElementById('closeBillBtn').disabled = false;
                                    }
                                }
                            });
						},'ok');
					}
					//lalu setelah itu masukan ia ke pembayaran utils
					if(getKsoId == 1){
						url="../pembayaran/bayar_utils.php?versi=4&grd=true&act=Tambah&idBayar=&idKunj="+getIdKunj+"&idPel="+getIdPel+"&nobukti="+getNoRmPasien+"&tgl=<?= date('d-m-Y') ?>&tagihan="+dataKirim.tagihan+"&nilai="+dataKirim.tagihan+"&jaminan_kso="+dataKirim.jaminan_kso+"&titipan="+dataKirim.titipan+"&keringanan="+dataKirim.keringanan+"&dibayaroleh=&userId=<?php echo $userId;?>&tipe=0&idKasir=81&jenisKasir=1,57,60,64,66,62,44&ksoId="+getKsoId+"&bayarIGD=1&flag=1&retursisa=0&jenisKunj=1,1&unitId=232&statpembyrn=1";
						Request(url,'spanTar1','','GET',function(){
                            alert('Berhasil closebill pasien');
                            $.ajax({
                                url : 'function_pcr.php',
                                method : 'post',
                                data: {
                                    act : 'cekCekOut',
                                    id_pelayanan : getIdPel,
                                    id_kunjungan : getIdKunj,
                                },
                                dataType : 'json',
                                success:function(data){
                                    if(data.status == 0){
                                        document.getElementById('closeBillBtn').disabled = true;
                                    }else{
                                        document.getElementById('closeBillBtn').disabled = false;
                                    }
                                }
                            });
                        },'ok');	
					}
					
				}
		});
    }

    function cnvTglSql(date){
		let tanggal = date.split('-');
		return tanggal[2] + '-' + tanggal[1] + '-' + tanggal[0];
	}
    function cetakHasilPcr(){
        let idHasilPcr = $('#idHasilPcrForm').val();
        window.open('../unit_pelayanan/cetak_hasil_pcr.php?id='+idHasilPcr,'_blank');
    }
	function cetakHasilPcrAntigen(){
        let idHasilPcr = $('#idHasilPcrForm').val();
        window.open('../unit_pelayanan/cetak_hasil_pcr_antigen.php?id='+idHasilPcr,'_blank');
    }
    </script>
</html>
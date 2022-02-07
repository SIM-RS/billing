<?php
    include("../../sesi.php");
    include '../../koneksi/konek.php';
    include '../function/form.php';
    $dataPasien = getIndetitasPasien($_REQUEST['idKunj']);

    if (isset($_REQUEST["id"])) {
        mysql_query("DELETE FROM rm_12_1_resiko_jatuh_anak WHERE id = '{$_REQUEST['id']}'");
        echo "<script>window.location.href='index.php?idKunj=".$_REQUEST['idKunj']."&idPel=".$_REQUEST['idPel']."&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']."'</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Tarif Tindakan Kso</title>
    <link type="text/css" rel="stylesheet" href="../../theme/mod.css">
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
    <link rel="stylesheet" href="../../theme/bs/bootstrap.min.css">
    <script src="../../theme/bs/bootstrap.min.js"></script>
    <style>
        .font-size-14{
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div align="center">
        <?php include("../../header1.php"); ?>
        <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
            <tr>
                <td height="30">&nbsp;RM 12.1 ASESMEN RESIKO JATUH ANAK</td>
            </tr>
        </table>
        <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="left">
                    <div class="row">
                        <div class="col-6">
                            <?= textInput('No RM',['value'=>$dataPasien['no_rm'],'readonly'=>true,'class'=>'form-control font-size-14']) ?>
                            <?= textInput('Nama Pasien',['value'=>$dataPasien['nama'],'readonly'=>true,'class'=>'form-control font-size-14']) ?>
                        </div>
                        <div class="col-6">
                            <?= textInput('Tanggal Lahir',['value'=>$dataPasien['tgl_lahir'],'readonly'=>true,'class'=>'form-control font-size-14']) ?>
                            <?= textInput('Tanggal Lahir',['value'=>$dataPasien['alamat'],'readonly'=>true,'class'=>'form-control font-size-14']) ?>
                        </div>
                    </div>
                    <a style="color: white;" target="_blank" href="form.php?idKunj=<?= $_REQUEST['idKunj'] ?>&idPel=<?= $_REQUEST['idPel'] ?>&idPasien=&idUser=<?= $_REQUEST['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>"><button type="button"><img src="../../icon/add.gif" width="16" height="16">Tambah</button></a><br><br>
                    <div id="dataRmPdalam" style="width: 1000px;height: 200px;"></div>
                    <div id="pagingDataRmPdalam" style="width: 1000px;height: 100px;"></div>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
    <script>
        spawn();

        function spawn(){
            let gridTarifDokter = new DSGridObject("dataRmPdalam");
            gridTarifDokter.setHeader("RM ASESMEN RESIKO JATUH ANAK");
            gridTarifDokter.setColHeader("No,Tanggal Kunjungan,Tanggal Pelayanan,Tanggal Anamnesa,Tempat Layanan, Petugas,Action");
            gridTarifDokter.setIDColHeader(",k.tgl,p.tgl,pd.tgl,,peg.nama");
            gridTarifDokter.setColWidth("20,100,100,100,100,100,100");
            gridTarifDokter.setCellAlign("right,center,center,center,left,left");
            gridTarifDokter.setCellHeight(30);
            gridTarifDokter.setImgPath("../../icon");
            gridTarifDokter.setIDPaging("pagingDataRmPdalam");
            gridTarifDokter.baseURL("../function/grid_2.php?namaTable=rm_12_1_resiko_jatuh_anak&idPasien="+<?= $dataPasien['id'] ?>+"&idKunj="+<?= $_REQUEST['idKunj'] ?>+"&idPel="+<?= $_REQUEST['idPel'] ?>+"&idUser="+<?= $_REQUEST['idUser'] ?>+"&tmpLay="+<?= $_REQUEST['tmpLay'] ?>);
            gridTarifDokter.Init();
        }

        function deleteData(params) {
            var xhttp = new XMLHttpRequest();
            
            async function erase() {
                xhttp.open("GET", "index.php?id="+params+"&idPasien="+<?= $dataPasien['id'] ?>+"&idKunj="+<?= $_REQUEST['idKunj'] ?>+"&idPel="+<?= $_REQUEST['idPel'] ?>+"&idUser="+<?= $_REQUEST['idUser'] ?>+"&tmpLay="+<?= $_REQUEST['tmpLay'] ?>, true);
                xhttp.send();
                document.getElementById("dataRmPdalam").innerHTML = "";
                document.getElementById("pagingDataRmPdalam").innerHTML = "";
            }
            erase().then(spawn());
        }
            
    </script>
</body>
</html>
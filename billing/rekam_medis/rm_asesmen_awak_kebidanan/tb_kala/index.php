<?php 
    include("../../../sesi.php");
	include '../../../koneksi/konek.php';
	include '../../function/form.php';
    $dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
    $no = 1;
    $query = mysql_query("SELECT * FROM tb_kala WHERE id_pasien = '{$dataPasien['id']}' AND tipe = '1'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../../theme/bs/bootstrap.min.css">
    <title>Table KALA</title>
    <style>
        td{
            padding:5px;
        }
    </style>
</head>
<body style="margin:15px"><br>

    <button data-toggle="modal" data-target=".bd-example-modal-lg" type="button"><img src="../../../icon/add.gif" width="16" height="16"> Tambah Data</button> &emsp;
    <a href="index.php?idKunj=<?= $_REQUEST['idKunj'] ?>&idPel=<?= $_REQUEST['idPel'] ?>&idPasien=&idUser=<?= $_REQUEST['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>"><button type="button"><img src="../../../icon/edit.gif" width="16" height="16"> Jam 1</button></a> &emsp;
    <a href="index2.php?idKunj=<?= $_REQUEST['idKunj'] ?>&idPel=<?= $_REQUEST['idPel'] ?>&idPasien=&idUser=<?= $_REQUEST['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>"><button type="button"><img src="../../../icon/edit.gif" width="16" height="16"> Jam 2</button></a>
    
    <br><br>
    <center><h4>JAM 1 : TIAP 15 Menit</h4></center>
    <table class="text-center" border="1px" width="100%">
        <tr>
            <td>No</td>
            <td>Jam</td>
            <td>TENSI</td>
            <td>NADI</td>
            <td>SUHU</td>
            <td>RR</td>
            <td>TFU</td>
            <td>Konstraksi Uterus</td>
            <td>Pendarahan</td>
            <td>Aksi</td>
        </tr>
        <?php while($row = mysql_fetch_assoc($query)): ?>
        <tr>
            <td><?=$no;$no++;?></td>
            <td><?=$row['jam'];?></td>
            <td><?=$row['tensi'];?></td>
            <td><?=$row['nadi'];?></td>
            <td><?=$row['suhu'];?></td>
            <td><?=$row['rr'];?></td>
            <td><?=$row['tfu'];?></td>
            <td><?=$row['konstraksi'];?></td>
            <td><?=$row['pendarahan'];?></td>
            <td>
                <a href="edit.php?domain=index.php&id=<?= $row['id'] ?>&id_kunjungan=<?= $_REQUEST['idKunj'] ?>&idPel=<?= $_REQUEST['idPel'] ?>&idPasien=&idUser=<?= $_REQUEST['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>">
                    <button type="button"><img src="../../../icon/edit.gif" width="16" height="16"> Edit</button>
                    </a>&emsp;
                    <a href="credel.php?domain=index.php&delete=<?= $row['id'] ?>&id_kunjungan=<?= $_REQUEST['idKunj'] ?>&idPel=<?= $_REQUEST['idPel'] ?>&idPasien=&idUser=<?= $_REQUEST['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>">
                    <button type="button"><img src="../../../icon/del.gif" width="16" height="16"> Hapus</button>
                    </a>
            </td>
        </tr>
    <?php endwhile; ?>
    </table>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content container" style="padding:20px">
    <form action="credel.php" method="POST">
      <div class="row">
        <div class="col-6">
            Jam : <input class="form-control" type="time" name="jam" id=""> <br>
            Tensi : <input class="form-control" type="number" name="tensi" id=""> <br>
            Nadi : <input class="form-control" type="number" name="nadi" id=""> <br>
            Suhu : <input class="form-control" type="number" name="suhu" id=""> <br>
        </div>
        <div class="col-6">
            RR : <input class="form-control" type="text" name="rr" id=""> <br>
            TFU : <input class="form-control" type="text" name="tfu" id=""> <br>
            Konstraksi Uterus : <input class="form-control" type="text" name="konstraksi" id=""><br>
            Pendarahan : <br> <textarea class="form-control" name="pendarahan"></textarea> <br>
        </div>
      </div><br>

        <input type="hidden" name="id_kunjungan" value="<?= $_REQUEST['idKunj']; ?>">
        <input type="hidden" name="tipe" value="1">
        <input type="hidden" name="domain" value="index.php">
        <input type="hidden" name="id_pelayanan" value="<?= $_REQUEST['idPel']; ?>">
        <input type="hidden" name="id_user" value="<?= $_REQUEST['idUser']; ?>">
        <input type="hidden" name="tmpLay" value="<?= $_REQUEST['tmpLay']; ?>">
    
      <button style="width:100px" data-toggle="modal" data-target=".bd-example-modal-lg" type="submit"><img src="../../../icon/add.gif" width="16" height="16"> Simpan</button>
      </form>
    </div>
  </div>
</div>

<script type="text/JavaScript" language="JavaScript" src="../../../include/jquery/jquery-1.9.1.js"></script>
<script type="text/JavaScript" language="JavaScript" src="../../../theme/bs/bootstrap.min.js"></script>
</body>
</html>
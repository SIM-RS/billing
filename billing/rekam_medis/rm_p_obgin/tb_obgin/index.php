<?php 
    include("../../../sesi.php");
	include '../../../koneksi/konek.php';
	include '../../function/form.php';
    $dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
    $no = 1;
    $query = mysql_query("SELECT * FROM tb_riwayat_kehamilan WHERE id_pasien = {$dataPasien['id']}");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../../theme/bs/bootstrap.min.css">
    <title>Table OBGIN</title>
    <style>
        td{
            padding:5px;
        }
    </style>
</head>
<body style="margin:15px"><br>

    <button data-toggle="modal" data-target=".bd-example-modal-lg" type="button"><img src="../../../icon/add.gif" width="16" height="16"> Tambah Data</button>
    <br><br>
    <table class="text-center" border="1px" width="100%">
        <tr>
            <td rowspan="3">No</td>
            <td rowspan="3">Tgl Partus</td>
            <td colspan="3">Umur Hamil</td>
            <td rowspan="3">Jenis Partus</td>
            <td colspan="2">Penolong</td>
            <td colspan="3">Anak</td>
            <td colspan="3">Keadaan anak Sekarang</td>
            <td rowspan="3">Keterangan / Komplikasi</td>
            <td rowspan="3">Aksi</td>
        </tr>
        <tr>
            <td rowspan="2">Abortus</td>
            <td rowspan="2">Prematur</td>
            <td rowspan="2">Aterm</td>
            <td rowspan="2">Nakes</td>
            <td rowspan="2">Non</td>
            <td colspan="2">JK</td>
            <td rowspan="2">BBL</td>
            <td colspan="2">Hidup</td>
            <td rowspan="2">Meninggal</td>
        </tr>
        <tr>
            <td>♂</td>
            <td>♀</td>
            <td>Normal</td>
            <td>Cacat</td>
        </tr>
        <?php while($row = mysql_fetch_assoc($query)):?>
            <tr>
                <td><?=$no;$no++;?></td>
                <td><?=$row['tgl_partus'];?></td>
                <td><?=$row['abortus'];?></td>
                <td><?=$row['prematur'];?></td>
                <td><?=$row['aterm'];?></td>
                <td><?=$row['jenis_partus'];?></td>
                <td><?=$row['nakes'];?></td>
                <td><?=$row['non'];?></td>
                <?php if($row['jk'] == "perempuan"): ?>
                    <td><input readonly onclick="return false;" type="checkbox" /></td>
                    <td><input readonly onclick="return false;" type="checkbox" checked /></td>
                <?php else: ?>
                    <td><input readonly onclick="return false;" type="checkbox" checked /></td>
                    <td><input readonly onclick="return false;" type="checkbox" /></td>
                <?php endif; ?>
                <td><?=$row['non'];?></td>
                <td><?=$row['normal'];?></td>
                <td><?=$row['cacat'];?></td>
                <td><?=$row['meninggal'];?></td>
                <td><?=$row['ket'];?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>&id_kunjungan=<?= $_REQUEST['idKunj'] ?>&idPel=<?= $_REQUEST['idPel'] ?>&idPasien=&idUser=<?= $_REQUEST['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>">
                    <button type="button"><img src="../../../icon/edit.gif" width="16" height="16"> Edit</button>
                    </a>&emsp;
                    <a href="credel.php?delete=<?= $row['id'] ?>&id_kunjungan=<?= $_REQUEST['idKunj'] ?>&idPel=<?= $_REQUEST['idPel'] ?>&idPasien=&idUser=<?= $_REQUEST['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>">
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
            Tgl Partus : <input class="form-control" type="date" name="tgl_partus" id=""> <br>
            Abortus : <input class="form-control" type="text" name="abortus" id=""> <br>
            Prematur : <input class="form-control" type="text" name="prematur" id=""> <br>
            Aterm : <input class="form-control" type="text" name="aterm" id=""> <br>
            Jenis Partus : <input class="form-control" type="text" name="jenis_partus" id=""> <br>
            Normal : <input class="form-control" type="text" name="normal" id=""> <br>
            Cacat : <input class="form-control" type="text" name="cacat" id=""> <br>
        </div>
        <div class="col-6">
            Nakes : <input class="form-control" type="text" name="nakes" id=""> <br>
            Non : <input class="form-control" type="text" name="non" id=""> <br>
            JK : <select name="jk" id="">
                    <option value="laki-laki">Laki-Laki</option>
                    <option value="perempuan">Perempuan</option>
                </select> <br><br>
            BBL : <input class="form-control" type="text" name="bbl" id=""> <br>
            Meninggal : <input class="form-control" type="text" name="meninggal" id=""> <br>
            Keterangan : <br><textarea name="keterangan" cols="30" rows="10"></textarea> <br>
            
        </div>
      </div><br>

        <input type="hidden" name="id_kunjungan" value="<?= $_REQUEST['idKunj']; ?>">
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
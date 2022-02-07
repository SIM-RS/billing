<?php 
    include("../../../sesi.php");
	include '../../../koneksi/konek.php';
	include '../../function/form.php';
    $dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
    $no = 1;
    $query = mysql_query("SELECT * FROM tb_riwayat_persalinan WHERE id_pasien = {$dataPasien['id']}");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../../theme/bs/bootstrap.min.css">
    <title>Table Riwayat Persalinan</title>
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
				<td rowspan="2">No</td>
				<td rowspan="2">Tgl ,Bln & Thn Persalinan</td>
				<td rowspan="2">Tempat Persalinan</td>
				<td rowspan="2">Usia Kehamilan</td>
				<td rowspan="2">Jenis Persalinan</td>
				<td rowspan="2">Penolong</td>
				<td rowspan="2">Penyulit Kehamilan Persalinan , Nifas</td>
				<td colspan="3">Anak</td>
				<td rowspan="2">Opsi</td>
			</tr>
			<tr>
				<td>Jenis Kel</td>
				<td>BB/PB</td>
				<td>Keadaan</td>
			</tr>
            <?php while($row = mysql_fetch_assoc($query)): ?>
                <tr>
                    <td><?=$no;$no++;?></td>
                    <td><?=$row['tgl_persalinan'];?></td>
                    <td><?=$row['tempat'];?></td>
                    <td><?=$row['usia_kehamilan'];?></td>
                    <td><?=$row['jenis_persalinan'];?></td>
                    <td><?=$row['penolong'];?></td>
                    <td><?=$row['penyulit'];?></td>
                    <td><?=$row['jk'];?></td>
                    <td><?=$row['bb'];?></td>
                    <td><?=$row['keadaan'];?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>&id_kunjungan=<?= $_REQUEST['idKunj'] ?>&idPel=<?= $_REQUEST['idPel'] ?>&idPasien=&idUser=<?= $_REQUEST['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>">
                    <button type="button"><img src="../../../icon/edit.gif" width="16" height="16"> Edit</button>
                    </a><br><br>
                    <a href="credel.php?delete=<?= $row['id'] ?>&id_kunjungan=<?= $_REQUEST['idKunj'] ?>&id_pelayanan=<?= $_REQUEST['idPel'] ?>&idPasien=&id_user=<?= $_REQUEST['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>">
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
            Tgl Persalinan : <input class="form-control" type="date" name="tgl_persalinan" id=""> <br>
            Tempat Persalinan : <input class="form-control" type="text" name="tempat" id=""> <br>
            Usia Kehamilan : <input class="form-control" type="text" name="usia_kehamilan" id=""> <br>
            Jenis Persalinan : <input class="form-control" type="text" name="jenis_persalinan" id=""> <br>
        </div>
        <div class="col-6">
            Penolong : <input class="form-control" type="text" name="penolong" id=""> <br>
            Penyulit Kehamilan : <input class="form-control" type="text" name="penyulit" id=""> <br>
            Jenis Kelamin Anak : <select name="jk" id="">
                    <option value="Laki-laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select> <br><br>
            BB/PB Anak : <input class="form-control" type="text" name="bb" id=""> <br>
            Keadaan Anak : <textarea name="keadaan" class="form-control"></textarea> <br>
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
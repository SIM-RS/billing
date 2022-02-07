<?php 
    include '../../function/form.php';
	include '../../../koneksi/konek.php';
    $data = mysql_query("SELECT * FROM tb_riwayat_persalinan WHERE id = '{$_REQUEST['id']}'");
    $query = mysql_fetch_assoc($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../../theme/bs/bootstrap.min.css">
    <title>Edit Data</title>
</head>
<body class="container"><br>
    <form action="credel.php" method="POST">
      <div class="row">
        <div class="col-6">
            Tgl Persalinan : <input value="<?=$query['tgl_persalinan']?>" class="form-control" type="date" name="tgl_persalinan" id=""> <br>
            Tempat Persalinan : <input value="<?=$query['tempat']?>" class="form-control" type="text" name="tempat" id=""> <br>
            Usia Kehamilan : <input value="<?=$query['usia_kehamilan']?>" class="form-control" type="text" name="usia_kehamilan" id=""> <br>
            Jenis Persalinan : <input value="<?=$query['jenis_persalinan']?>" class="form-control" type="text" name="jenis_persalinan" id=""> <br>
        </div>
        <div class="col-6">
            Penolong : <input value="<?=$query['penolong']?>" class="form-control" type="text" name="penolong" id=""> <br>
            Penyulit Kehamilan : <input value="<?=$query['penyulit']?>" class="form-control" type="text" name="penyulit" id=""> <br>
            Jenis Kelamin Anak : <select name="jk" id="jk">
                    <option value="Laki-laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select> <br><br>
            BB/PB Anak : <input value="<?=$query['bb']?>" class="form-control" type="text" name="bb" id=""> <br>
            Keadaan Anak : <textarea name="keadaan" class="form-control"><?=$query['keadaan']?></textarea> <br>
        </div>
      </div><br>

        <input type="hidden" name="id_kunjungan" value="<?= $_REQUEST['id_kunjungan']; ?>">
        <input type="hidden" name="id" value="<?= $query['id']; ?>">
        <input type="hidden" name="id_pelayanan" value="<?= $_REQUEST['idPel']; ?>">
        <input type="hidden" name="id_user" value="<?= $_REQUEST['idUser']; ?>">
        <input type="hidden" name="tmpLay" value="<?= $_REQUEST['tmpLay']; ?>">
    
      <button style="width:100px" data-toggle="modal" data-target=".bd-example-modal-lg" type="submit"><img src="../../../icon/add.gif" width="16" height="16"> Edit</button>
  </form>
    <script type="text/JavaScript" language="JavaScript" src="../../../include/jquery/jquery-1.9.1.js"></script>

      <script>
        $('#jk').val('<?=$query['jk']?>');
      </script>
</body>
</html>
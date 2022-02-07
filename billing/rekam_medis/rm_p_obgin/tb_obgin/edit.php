<?php 
    include '../../function/form.php';
	include '../../../koneksi/konek.php';
    $data = mysql_query("SELECT * FROM tb_riwayat_kehamilan WHERE id = '{$_REQUEST['id']}'");
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
            Tgl Partus : <input value="<?= $query['tgl_partus'] ?>" class="form-control" type="date" name="tgl_partus" id=""> <br>
            Abortus : <input value="<?= $query['abortus'] ?>" class="form-control" type="text" name="abortus" id=""> <br>
            Prematur : <input value="<?= $query['prematur'] ?>" class="form-control" type="text" name="prematur" id=""> <br>
            Aterm : <input value="<?= $query['aterm'] ?>" class="form-control" type="text" name="aterm" id=""> <br>
            Jenis Partus : <input value="<?= $query['jenis_partus'] ?>" class="form-control" type="text" name="jenis_partus" id=""> <br>
            Normal : <input value="<?= $query['normal'] ?>" class="form-control" type="text" name="normal" id=""> <br>
            Cacat : <input value="<?= $query['cacat'] ?>" class="form-control" type="text" name="cacat" id=""> <br>
        </div>
        <div class="col-6">
            Nakes : <input value="<?= $query['nakes'] ?>" class="form-control" type="text" name="nakes" id=""> <br>
            Non : <input value="<?= $query['non'] ?>" class="form-control" type="text" name="non" id=""> <br>
            JK : <select name="jk" id="jk">
                    <option value="laki-laki">Laki-Laki</option>
                    <option value="perempuan">Perempuan</option>
                </select> <br><br>
            BBL : <input value="<?= $query['bbl'] ?>" class="form-control" type="text" name="bbl" id=""> <br>
            Meninggal : <input value="<?= $query['meninggal'] ?>" class="form-control" type="text" name="meninggal" id=""> <br>
            Keterangan :<br> <textarea name="keterangan" cols="30" rows="10"><?=$query['ket']?></textarea> <br>
            
        </div>
      </div><br>

        <input type="hidden" name="id_kunjungan" value="<?= $_REQUEST['id_kunjungan']; ?>">
        <input type="hidden" name="id_pelayanan" value="<?= $_REQUEST['idPel']; ?>">
        <input type="hidden" name="id_user" value="<?= $_REQUEST['idUser']; ?>">
        <input type="hidden" name="tmpLay" value="<?= $_REQUEST['tmpLay']; ?>">
        <input type="hidden" name="id" value="<?= $_REQUEST['id']; ?>">

      <button style="width:100px" data-toggle="modal" data-target=".bd-example-modal-lg" type="submit"><img src="../../../icon/add.gif" width="16" height="16"> Simpan</button>
      </form><br>

    <script type="text/JavaScript" language="JavaScript" src="../../../include/jquery/jquery-1.9.1.js"></script>

      <script>
        $('#jk').val('<?=$query['jk']?>');
      </script>
</body>
</html>
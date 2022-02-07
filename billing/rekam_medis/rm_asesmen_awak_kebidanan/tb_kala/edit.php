<?php 
    include '../../function/form.php';
	include '../../../koneksi/konek.php';
    $data = mysql_query("SELECT * FROM tb_kala WHERE id = '{$_REQUEST['id']}'");
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
            Jam : <input value="<?= $query['jam'] ?>" class="form-control" type="time" name="jam" id=""> <br>
            Tensi : <input value="<?= $query['tensi'] ?>" class="form-control" type="number" name="tensi" id=""> <br>
            Nadi : <input value="<?= $query['nadi'] ?>" class="form-control" type="number" name="nadi" id=""> <br>
            Suhu : <input value="<?= $query['suhu'] ?>" class="form-control" type="number" name="suhu" id=""> <br>
        </div>
        <div class="col-6">
            RR : <input value="<?= $query['rr'] ?>" class="form-control" type="text" name="rr" id=""> <br>
            TFU : <input value="<?= $query['tfu'] ?>" class="form-control" type="text" name="tfu" id=""> <br>
            Konstraksi Uterus : <input value="<?= $query['konstraksi'] ?>" class="form-control" type="text" name="konstraksi" id=""><br>
            Pendarahan : <input value="<?= $query['pendarahan'] ?>" class="form-control" type="text" name="pendarahan" id=""> <br>
        </div>
      </div><br>

        <input type="hidden" name="tipe" value="<?= $query['tipe']; ?>">
        <input type="hidden" name="domain" value="<?=$_REQUEST['domain']?>">
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
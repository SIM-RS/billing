<?php
    session_start();
    include("../sesi.php");
    include("../koneksi/konek.php");

    $userId = $_SESSION['userId'];
    if(!isset($userId) || $userId == ''){
        header('location:../index.php');
    }

    $id_bayar   = $_REQUEST['idbayar'];
    $act        = $_REQUEST['act'];
    $status     = $_REQUEST['status'];
    
    if ($act == 'upt_status') {
        # == Update status b_bayar
        $upt_status = mysql_query("UPDATE b_bayar SET bayar_ulang = '$status' WHERE id = '$id_bayar'");

        # == Update status
        switch ($status) {
            case 0:
                // == Insert ke tabel b_bayar_temp
                $backup_bbayar = mysql_query("INSERT INTO b_bayar_temp SELECT * FROM b_bayar WHERE id = '$id_bayar'");
                break;

            case 1:
                // == Ambil b_bayar_temp
                $b_bayar_temp = mysql_fetch_array(mysql_query("SELECT * FROM b_bayar_temp LIMIT 1"));
                // == Update b_bayar baru dengan b_bayar lama yg ada di b_bayar_temp
                // $query_update = "UPDATE b_bayar SET no_kwi_urutan = '".$b_bayar_temp['no_kwi_urutan']."', no_kwitansi = '".$b_bayar_temp['no_kwitansi']."', kasir_id = '".$b_bayar_temp['kasir_id']."', tgl = '".$b_bayar_temp['tgl']."', tgl_act = '".$b_bayar_temp['tgl_act']."', user_act = '".$b_bayar_temp['user_act']."' WHERE id='$id_bayar'";
                $query_update = "INSERT INTO b_bayar_temp SELECT * FROM b_bayar_temp LIMIT 1";
                // == Ekse
                $ekse = mysql_query($query_update);
                if ($ekse) {
                    mysql_query("DELETE FROM b_bayar_temp");
                }
                break;
            
            default:
                // == 
                break;
        }

        header("location: koreksi_tglbayar.php");
    } else {
        $sql = mysql_query("
            SELECT
                b.id,
                b.nobukti,
                b.no_kwitansi,
                b.tgl_act,
                pasien.nama, pasien.no_rm
            FROM
                b_bayar_temp b
                JOIN b_kunjungan kunj ON kunj.id = b.kunjungan_id 
                join b_ms_pasien pasien on pasien.id = kunj.pasien_id
            WHERE
                b.id = '$id_bayar'
        ");

        $data = mysql_fetch_array($sql);
    ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Edit Tgl Bayar</title>
            <link rel="stylesheet" href="datatables/bootstrap.css">
            <link rel="stylesheet" href="datatables/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
        </head>

        <body>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 mx-auto">

                        <h3 class="text-center mb-3 mt-3">Edit Tanggal Bayar</h3>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="">ID Bayar</label>
                                <input type="text" class="form-control" name="id_bayar" value="<?= $data['id'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Nomor Bukti</label>
                                <input type="text" class="form-control" name="no_bukti" value="<?= $data['nobukti'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Nomor Kwitansi</label>
                                <input type="text" class="form-control" name="no_kwitansi" value="<?= $data['no_kwitansi'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Bayar</label>
                                <div class="input-append date form_datetime">
                                    <input size="16" type="text" name="tgl_bayar" value="<?= $data['tgl_act'] ?>" class="form-control">
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>

                            <a href="koreksi_tglbayar.php" class="btn btn-danger">Back</a>
                            <input type="submit" value="submit" name="submit" class="btn btn-primary" />
                        </form>
                    </div>
                </div>
            </div>
        </body>
        <script src="datatables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
        <script src="datatables/jQuery-3.3.1/popper.min.js"></script>
        <script src="datatables/jQuery-3.3.1/bootstrap.min.js"></script>
        <script src="datatables/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript">
            $(".form_datetime").datetimepicker({
                format: "yyyy-mm-dd hh:ii:ss"
            });
        </script>

        </html>

        <?php 
            // var_dump($_POST);
            if (isset($_POST['submit'])) {
                $id_bayar = $_POST['id_bayar'];
                $no_bukti = $_POST['no_bukti'];
                $no_kwitansi = $_POST['no_kwitansi'];
                $tgl_bayar = $_POST['tgl_bayar'];

                $update_tglbayar = "UPDATE b_bayar SET tgl_act = '$tgl_bayar' WHERE id = '$id_bayar' AND nobukti = '$no_bukti' AND no_kwitansi = '$no_kwitansi'";
                $update = mysql_query($update_tglbayar);

                if (!$update) {
                    echo "Gagal Update";
                } else {
                    header("location: koreksi_tglbayar.php");
                }
            }
        }
        ?>
<?php
	session_start();
	include("../sesi.php");
?>
<html>
    <head>
        <title>Status Medik</title>
        <link type="text/css" href="../theme/print.css" rel="stylesheet"></link>
    </head>
    <body>
        <?php
        if(isset($_POST['btnPrint'])){
            include '../koneksi/konek.php';
            $jns = $_POST['JnsLayanan'];
            $tmp = $_POST['TmpLayanan'];
            $norm = $_POST['norm'];
            $nama = $_POST['nama'];
            $tglM = tglSQL($_POST['tglMsk']);
            $tglS = tglSQL($_POST['tglSelesai']);
            $status_m = $_POST['cmb_sm'];
            
            if($jns == 0){
                $fUnit = '';
            }
            else{
                if($tmp == 0){
                    $fUnit = " and k.jenis_layanan = ".$jns." ";
                }
                else{
                    $fUnit = " and k.unit_id = ".$tmp." ";
                }
            }
            
            if($norm == ''){
                $norm = '';
            }
            else{
                $norm = " and p.no_rm = '$norm' ";
            }
            
            if($nama == ''){
                $nama = '';
            }
            else{
                $nama = " and p.nama like '%$nama%' ";
            }
            
            if($status_m == '2'){
                $status_m = '';
            }
            else{
                if($status_m == 0){
                    $sb = 'Daftar Buku Riwayat Pasien yang Belum Kembali';
                }
                else{
                    $sb = 'Daftar Buku Riwayat Pasien yang Sudah Kembali';
                }
                $status_m = " and status_medik = '$status_m'";
            }
            ?>
            <table width="1000" border=0 cellpadding=0 cellspacing=0>
                <tr>
                    <td colspan="8" align="center" style="font-size:13px;padding-bottom:20px">
                        <b><?=$namaRS;?>
                        <br /><?=$alamatRS;?>
                        <br />Telepon <?=$tlpRS;?>
                        <br /><?=$kotaRS;?></b>
                    </td>
                </tr>
                <tr>
                    <td colspan="8" style="font-size:12px;">
                        <?php echo $sb;?>
                    </td>
                </tr>
                <tr>
                    <td width="30" style="font-size:12px;font-weight:bold" align="center" class="tblheaderkiri">
                        NO
                    </td>
                    <td width="80" style="font-size:12px;font-weight:bold" align="center" class="tblheader">
                        TGL KUNJUNGAN
                    </td>
                    <td width="70" style="font-size:12px;font-weight:bold" align="center" class="tblheader">
                        NO RM
                    </td>
                    <td width="150" style="font-size:12px;font-weight:bold" align="center" class="tblheader">
                        NAMA PASIEN
                    </td>
                    <td width="300" style="font-size:12px;font-weight:bold" align="center" class="tblheader">
                        ALAMAT
                    </td>
                    <td width="170" style="font-size:12px;font-weight:bold" align="center" class="tblheader">
                        POLI
                    </td>
                    <td width="100" style="font-size:12px;font-weight:bold" align="center" class="tblheader">
                        STATUS PASIEN
                    </td>
                    <td width="100" style="font-size:12px;font-weight:bold" align="center" class="tblheader">
                        PETUGAS
                    </td>
                </tr>
                <?php
                $sql = "select * from (select k.id, date_format(k.tgl_act,'%d-%m-%Y %H:%i:%s') as tgl, p.no_rm, p.nama, p.alamat, u.nama as poli, kso.nama as status, if(k.status_medik=1,true,false) as status_medik, pg.nama as pgw
                        from b_kunjungan k
                        inner join b_ms_pasien p on k.pasien_id = p.id
                        inner join b_ms_unit u on k.unit_id = u.id
                        inner join b_ms_kso kso on k.kso_id = kso.id
                        inner join b_ms_pegawai pg on k.user_act = pg.id
                        where k.tgl between '$tglM' and '$tglS' $fUnit $norm $nama $status_m) t1 order by tgl,nama";
                $rs = mysql_query($sql);
                $i=1;
                while($row = mysql_fetch_array($rs)){
                    $sqlIn = "select distinct nama from b_ms_unit u inner join b_pelayanan p on u.id = p.unit_id where p.kunjungan_id = '".$row['id']."'";
                    $rsIn = mysql_query($sqlIn);
                    $tmpx = '';
                    while($rowIn = mysql_fetch_array($rsIn)){
                        $tmpx .= $rowIn['nama'].', ';
                    }
                    $tmpx = substr($tmpx,0,strlen($tmpx)-2);
                ?>
                <tr>
                    <td class="tdisikiri" style="font-size:12px;">
                        <?php echo $i;?>&nbsp;
                    </td>
                    <td class="tdisi" style="font-size:12px;">
                        <?php
                        echo $row['tgl'];
                        ?>&nbsp;
                    </td>
                    <td class="tdisi" style="font-size:12px;">
                        <?php
                        echo $row['no_rm'];
                        ?>&nbsp;
                    </td>
                    <td class="tdisi" style="font-size:12px;">
                        <?php
                        echo $row['nama'];
                        ?>&nbsp;
                    </td>
                    <td class="tdisi" style="font-size:12px;">
                        <?php
                        echo $row['alamat'];
                        ?>&nbsp;
                    </td>
                    <td class="tdisi" style="font-size:12px;">
                        <?php
                        echo $tmpx;
                        ?>&nbsp;
                    </td>
                    <td class="tdisi" style="font-size:12px;">
                        <?php
                        echo $row['status'];
                        ?>&nbsp;
                    </td>
                    <td class="tdisi" style="font-size:12px;">
                        <?php
                        echo $row['pgw'];
                        ?>&nbsp;
                    </td>
                </tr>
                <?php
                $i++;
                }
                $sql = "select nama from b_ms_pegawai where id = '".$_REQUEST['p_id']."'";
                $rs = mysql_query($sql);
                $row = mysql_fetch_array($rs);
                $nama = $row['nama'];
                mysql_free_result($rs);
                ?>
            <tr>
               <td colspan="7" align="right">Tgl Cetak: <?php echo date('d-m-Y');?></td>
            </tr>
            <tr>
               <td colspan="7" align="right">Yang Mencetak</td>
            </tr>
            <tr id="trTombol">
               <td colspan="7" class="noline" align="center">
                   <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
                   <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
               </td>
           </tr>
            <tr>
               <td colspan="7" style="padding-top:30px;" align="right"><b><?php echo $nama;?></b>&nbsp;</td>
            </tr>
            </table>
        <?php
        }
        mysql_close($konek);
        ?>
    </body>
    <script>
        function cetak(tombol){
            tombol.style.visibility='hidden';
            if(tombol.style.visibility=='hidden'){
              /*try{
                   mulaiPrint();
              }
              catch(e){
                   window.print();
              }*/
              
              window.print();
              window.close();
            }
        }
    </script>
</html>
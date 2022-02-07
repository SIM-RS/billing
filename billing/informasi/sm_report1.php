<html>
    <head>
        <title>Status Medik</title>
		<script language="javascript" src="../jquery.js"></script>
        <script language="javascript" src="../print.js"></script>
        <link type="text/css" href="../theme/print.css" rel="stylesheet"></link>
    </head>
    <body>
        <?php
        if(!isset($_POST['btnPrint'])){
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
                $status_m = " and k.status_medik = '$status_m'";
            }
            ?>
            <table width="600" border=0 cellpadding=0 cellspacing=0>
                <!--<tr>
                    <td colspan="8" align="center" style="font-size:13px;padding-bottom:20px">
                        <b>Rumah Sakit Bhayangkara HS Samsoeri Mertodjoso Surabaya<br>
                        Jl. A Yani 116 Surabaya<br>
                        Telp. 031-8292227, Fax 031-8296602<br>
                        Surabaya</b>                    </td>
                </tr>-->
                <!--<tr>
                    <td colspan="8" style="font-size:12px;">
                        <?php echo $sb;?>
                    </td>
                </tr>-->
                <!--<tr>
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
                </tr>-->
                <?php
                $sql = "select * from (select k.id, date_format(k.tgl_act,'%d-%m-%Y %H:%i:%s') as tgl, p.no_rm, p.nama, p.sex, p.alamat, u.nama as poli, kso.nama as status, if(k.status_medik=1,true,false) as status_medik, pg.nama as pgw
                        from b_kunjungan k
                        inner join b_ms_pasien p on k.pasien_id = p.id
                        inner join b_ms_unit u on k.unit_id = u.id
                        inner join b_ms_kso kso on k.kso_id = kso.id
                        inner join b_ms_pegawai pg on k.user_act = pg.id
                        where k.tgl = CURDATE() and k.isbaru=0 $status_m and k.sprint=0 AND k.unit_id NOT IN(59,61)) t1 order by tgl,nama";
                $rs = mysql_query($sql);
				$jml1 = mysql_num_rows($rs);
                $i=1;
                while($row = mysql_fetch_array($rs)){
                    //$sqlIn = "select distinct nama from b_ms_unit u inner join b_pelayanan p on u.id = p.unit_id where p.kunjungan_id = '".$row['id']."'";
					$sqlIn = "SELECT DISTINCT u.nama,mp.nama dokter FROM b_ms_unit u INNER JOIN b_pelayanan p ON u.id = p.unit_id 
INNER JOIN b_ms_pegawai mp ON p.dokter_tujuan_id=mp.id WHERE p.kunjungan_id = '".$row['id']."'";
                    $rsIn = mysql_query($sqlIn);
                    $tmpx = '';
					$tdokter="";
                    while($rowIn = mysql_fetch_array($rsIn)){
                        $tmpx .= $rowIn['nama'].', ';
						$tdokter .= $rowIn['dokter'].', ';
                    }
                    $tmpx = substr($tmpx,0,strlen($tmpx)-2);
					$tdokter = substr($tdokter,0,strlen($tdokter)-2);
                ?>
                <tr>
                    <td class="tdisikiri" style="font-size:20px; border:none;">
                    Tanggal Kunjungan
                    </td>
                    <td class="tdisi" style="font-size:20px; border:none;">
                            <?php
                            echo $row['tgl'];
                            ?>&nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="tdisikiri" style="font-size:20px; border:none;">
                    No Rm
                    </td>
                    <td class="tdisi" style="font-size:20px; border:none;">
                            <?php
                            echo $row['no_rm'];
                            ?>&nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="tdisikiri" style="font-size:20px; border:none;">
                    Nama
                    </td>
                    <td class="tdisi" style="font-size:20px; border:none;">
                            <?php
                            echo $row['nama']." [".$row['sex']."]";
                            ?>&nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="tdisikiri" style="font-size:20px; border:none;">
                    Poli
                    </td>
                    <td class="tdisi" style="font-size:20px; border:none;">
                            <?php
								echo $tmpx;
							?>&nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="tdisikiri" style="font-size:20px; border:none;">
                    Dokter
                    </td>
                    <td class="tdisi" style="font-size:20px; border:none;">
                            <?php
                            echo $tdokter;
                            ?>&nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="tdisikiri" style="font-size:12px; border:none;" colspan="2">&nbsp;</td>
                </tr>
                
                <!--Tambahan Baru-->
                <tr>
                    <td class="tdisikiri" style="font-size:20px; border:none;">
                    Tanggal Kunjungan
                    </td>
                    <td class="tdisi" style="font-size:20px; border:none;">
                            <?php
                            echo $row['tgl'];
                            ?>&nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="tdisikiri" style="font-size:20px; border:none;">
                    No Rm
                    </td>
                    <td class="tdisi" style="font-size:20px; border:none;">
                            <?php
                            echo $row['no_rm'];
                            ?>&nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="tdisikiri" style="font-size:20px; border:none;">
                    Nama
                    </td>
                    <td class="tdisi" style="font-size:20px; border:none;">
                            <?php
                            echo $row['nama']." [".$row['sex']."]";
                            ?>&nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="tdisikiri" style="font-size:20px; border:none;">
                    Poli
                    </td>
                    <td class="tdisi" style="font-size:20px; border:none;">
                            <?php
								echo $tmpx;
							?>&nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="tdisikiri" style="font-size:20px; border:none;">
                    Dokter
                    </td>
                    <td class="tdisi" style="font-size:20px; border:none;">
                            <?php
                            echo $tdokter;
                            ?>&nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="tdisikiri" style="font-size:12px; border:none;" colspan="2">&nbsp;</td>
                </tr>
                <!--<tr>
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
                </tr>-->
                <?php
				$perintah = "update b_kunjungan set sprint = 1 where id = '$row[id]'";
				$exec1 = mysql_query($perintah);
                $i++;
                }
                $sql = "select nama from b_ms_pegawai where id = '".$_REQUEST['p_id']."'";
                $rs = mysql_query($sql);
                $row = mysql_fetch_array($rs);
                $nama = $row['nama'];
                mysql_free_result($rs);
                ?>
            <!--<tr>
               <td colspan="7" align="right">Tgl Cetak: <?php echo date('d-m-Y');?></td>
            </tr>
            <tr>
               <td colspan="7" align="right">Yang Mencetak</td>
            </tr>-->
            <tr id="trTombol">
               <td colspan="7" class="noline" align="center">
                  <!-- <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
                   <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>-->
               </td>
           </tr>
            <tr>
               <td colspan="7" style="padding-top:30px;" align="right"><b><?php echo $nama;?></b>&nbsp;</td>
            </tr>
            <tr>
               <td colspan="7" style="padding-top:30px;" align="right">&nbsp;</td>
            </tr>
            <tr>
               <td colspan="7" style="padding-top:30px;" align="right">&nbsp;</td>
            </tr>
            </table>
        <?php
        }
        mysql_close($konek);
        ?>
    </body>
    <script>
	window.onload=cetak1();
	
	function cetak1()
	{
		var sprint = <? echo $jml1;?>;
		
		if(sprint > 0)
		{
			//window.print();
			printForm();
		}
		//window.close();
		
		setTimeout(function(){window.close()},"5000");
	}
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
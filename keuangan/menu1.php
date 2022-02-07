<!--head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>.: Laporan Keuangan :.</title-->
        <!--link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <link type="text/css" href="../menu.css" rel="stylesheet" /-->
        <!--script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../menu.js"></script-->
        <!--link type="text/css" rel="stylesheet" href="../theme/mod.css"-->
        <!--script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script-->
    <!--/head-->
<style type="text/css">
* { margin:0;
    padding:0;
}
/*body { background:rgb(74,81,85); }*/

div#copyright {
    font:11px 'Trebuchet MS';
    color:#222;
    text-indent:30px;
    padding:0px 0 0 0;
}
div#copyright a { color:#aaa; }
div#copyright a:hover { color:#222; }
</style>
<?php
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$date_skr=explode('-',$date_now);
	if ($fromHome=="") $fromHome="0";
?>
<div id="menu">
    <ul class="menu">
        <li><a href="#" class="parent"><span>Masters</span></a>
            <ul style="width:130px">
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/masters/users.php"><span>Users</span></a></li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/masters/jenis_transaksi.php"><span>Jenis Transaksi</span></a></li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/masters/akun_jenis_transaksi.php"><span>Akun Jenis Trans.</span></a></li>
            </ul>
        </li>
        <li><a href="#" class="parent"><span>Pendapatan</span></a>
            <ul style="width:130px">
                <!--li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/pendapatan_billing.php?tipe=1"><span>Rawat Jalan</span></a></li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/pendapatan_billing.php?tipe=2"><span>Rawat Inap</span></a></li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/pendapatan_billing.php?tipe=3"><span>IGD</span></a></li-->
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/pendapatan_billing.php?tipe=4"><span>Unit Pelayanan</span></a>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/pendapatan_farmasi.php"><span>Unit Farmasi</span></a>
                </li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/pendapatan.php"><span>Lain-lain</span></a></li>
            </ul>
        </li>
        <li>
			<a href="#" class="parent"><span>Pengurang Pendapatan</span></a>
			<ul style="width:145px">
				<li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/pengurang_pendapatan.php?tipe=4&bayar=0"><span>Belum Terbayar</span></a></li>
				<li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/pengurang_pendapatan.php?tipe=4&bayar=1"><span>Sudah Terbayar</span></a></li>
			</ul>
		</li>
        <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/pengeluaran.php" class="parent"><span>Pengeluaran</span></a>
			 <ul style="width:155px">
					<li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/pemakaian_brg.php"><span>Pemakaian Barang</span></a></li>
					<li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/pengeluaran.php"><span>Pengeluaran Lain-lain</span></a></li>
				    <!--li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/pembayaran_kso.php?tipe=1"><span>Return Penjualan Obat</span></a>
                    </li>
				    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/pengeluaran.php"><span>Lain - Lain</span></a>
                    </li-->
			 </ul>
        </li>
	   <li>
			 <a href="#" class="parent"><span>Penerimaan</span></a>
			 <ul style="width:150px">
				    <li><a href="#" class="parent"><span>Penerimaan Tunai</span></a>
					   <ul style="margin: -38px 0 0 145px !important;width:130px">
						  <!--li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/pembayaran_kso.php?tipe=1"><span>Rawat Jalan</span></a></li>
						  <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/pembayaran_kso.php?tipe=2"><span>Rawat Inap</span></a></li>
						  <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/pembayaran_kso.php?tipe=3"><span>IGD</span></a></li-->
						  <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/penerimaan_tunai.php?tipe=1"><span>Bayar Px Umum</span></a></li>
						  <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/penerimaan_tunai.php?tipe=2"><span>Iur Bayar Px KSO</span></a></li>
                          <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/penerimaan_billing_kasir.php"><span>Setoran Kasir</span></a></li>
					   </ul>
				    </li>
				    <li>
						  <!--a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/penerimaan_px_umum.php?tipe=4"><span>Penerimaan Piutang</span></a-->
						  <a href="#" class="parent"><span>Penerimaan Piutang</span></a>
					   <ul style="margin: -38px 0 0 145px !important;width:120px">
						  <!--li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/penerimaan_px_umum.php?tipe=1"><span>Rawat Jalan</span></a></li>
						  <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/penerimaan_px_umum.php?tipe=2"><span>Rawat Inap</span></a></li>
						  <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/penerimaan_px_umum.php?tipe=3"><span>IGD</span></a></li>
						  <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/penerimaan_px_umum.php?tipe=4"><span>Per Unit Layanan</span></a></li-->
						  <li><a href="#"><span>Px Umum</span></a></li>
						  <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/penerimaan_piutang.php"><span>Klaim KSO</span></a></li>
					   </ul>
				    </li>
				    <li>
						  <a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/transaksi/penerimaan_setoran.php"><span>Penerimaan Setoran</span></a>
				    </li>
			 </ul>
	   </li>
        <li><a href="#" class="parent"><span>Laporan</span></a>
            <ul style="width:160px">
                <li><a href="#" class="parent"><span>Pendapatan</span></a>
                	<ul style="margin: -38px 0 0 145px !important;width:185px;">
                    	<li><a href="javascript:void(0)" onclick="popupReport(1,<?php echo $fromHome; ?>)"><span>Pendapatan Lain-lain</span></a></li>
                        <li><a href="javascript:void(0)" onclick="popupReport(111,<?php echo $fromHome; ?>)"><span>Rekap Pendapatan Lain-lain</span></a></li>
                        <!--li><a href="javascript:void(0)" onclick="popupReport(9,<?php echo $fromHome; ?>)"><span>Penjamin Pasien</span></a></li-->
                        <li><a href="javascript:void(0)" onclick="popupReport(4,<?php echo $fromHome; ?>)"><span>Rekap Pendapatan Blling</span></a></li>
                        <li><a href="javascript:void(0)" onclick="popupReport(5,<?php echo $fromHome; ?>)"><span>Rekap Pendapatan Farmasi</span></a></li>
                        <li><a href="javascript:void(0)" onclick="popupReport(51,<?php echo $fromHome; ?>)"><span>Rekap Pendapatan</span></a></li>
                    </ul>
                </li>
				<li><a href="#" class="parent"><span>Penerimaan</span></a>
                	<ul style="margin: -38px 0 0 145px !important;">
                    	<!--li><a href="javascript:void(0)" onclick="popupReport8()"><span>Penerimaan</span></a></li-->
                        <!--li><a href="javascript:void(0)" onclick="popupReport(7,<?php echo $fromHome; ?>)"><span>Penerimaan</span></a></li-->
                        <li><a href="javascript:void(0)" onclick="popupReport(7,<?php echo $fromHome; ?>)"><span>Penerimaan Lain-lain</span></a></li>
                        <!--li><a href="#"><span>Penerimaan Per Unit Layanan</span></a></li-->
                        <li><a href="#" onclick="popupReport(8,<?php echo $fromHome; ?>)"><span>Rekap Penerimaan Billing</span></a></li>
                        <li><a href="#" onclick="popupReport(81,<?php echo $fromHome; ?>)"><span>Rekap Penerimaan Farmasi</span></a></li>
                        <li><a href="#" onclick="popupReport(82,<?php echo $fromHome; ?>)"><span>Rekap Penerimaan</span></a></li>
                    </ul>
                </li>
                <li><a href="#" class="parent"><span>Pengeluaran</span></a>
                	<ul style="margin: -38px 0 0 145px !important;">
                    	<li><a href="javascript:void(0)" onclick="popupReport(12,<?php echo $fromHome; ?>)"><span>Rekap Return Obat</span></a></li>
                		<li><a href="javascript:void(0)" onclick="popupReport(2,<?php echo $fromHome; ?>)"><span>Pengeluaran Lain-Lain</span></a></li>
                        <!--li><a href="javascript:void(0)" onclick="popupReport(6,<?php echo $fromHome; ?>)"><span>Rekap Pengeluaran Lain2</span></a></li-->
                    </ul>
                </li>
                <li><a href="javascript:void(0)" class="parent"><span>Pengurang Pendapatan</span></a>
                	<ul style="margin: -38px 0 0 145px !important;width:135px;">
                    	<li><a href="javascript:void(0)" onclick="popupReport(13,<?php echo $fromHome; ?>)"><span>Belum Terbayar</span></a></li>
                		<li><a href="javascript:void(0)" onclick="popupReport(131,<?php echo $fromHome; ?>)"><span>Sudah Terbayar</span></a></li>
                    </ul>
                </li>
				<li><a href="javascript:void(0)" onclick="popupReport(10,<?php echo $fromHome; ?>)"><span>Pengajuan Klaim</span></a></li>
				<li><a href="javascript:void(0)" onclick="popupReport(112,<?php echo $fromHome; ?>)"><span>BKU</span></a></li>
				<li><a href="javascript:void(0)" onclick="popupReport(113,<?php echo $fromHome; ?>)"><span>Realisasi Anggaran</span></a></li>
                <!--li><a href="javascript:void(0)" onclick="popupReport3()"><span>Pendapatan Per Jenis Transaksi</span></a></li-->
            </ul>
        </li>
        <li class="last"><a href="http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $base_addr; ?>/user_logout.php"><span>Logout</span></a></li>
    </ul>
</div>
<div style="display:none"id="copyright">Copyright &copy; 2010 <a href="http://apycom.com/">Apycom jQuery Menus</a></div>

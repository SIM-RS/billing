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
	
?>
<div id="menu">
    <ul class="menu">
        <li><a href="#" class="parent"><span>Masters</span></a>
            <ul>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/masters/users.php"><span>Users</span></a></li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/masters/jenis_transaksi.php"><span>Jenis Transaksi</span></a></li>
            </ul>
        </li>
        <li><a href="#" class="parent"><span>Pendapatan</span></a>
            <ul>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/transaksi/pendapatan_billing.php?tipe=1"><span>Rawat Jalan</span></a></li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/transaksi/pendapatan_billing.php?tipe=2"><span>Rawat Inap</span></a></li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/transaksi/pendapatan_billing.php?tipe=3"><span>IGD</span></a></li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/transaksi/pendapatan_billing.php?tipe=4"><span>Per Unit Pelayanan</span></a>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/transaksi/pendapatan_farmasi.php"><span>Farmasi</span></a>
                    <!--ul>
                        <li><a href="http://< ?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/transaksi/pendapatan_farmasi.php"><span>Penjualan Obat</span></a></li>
                        <li><a href="http://< ?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/transaksi/return_penjualan.php"><span>Return Penjualan</span></a></li>
                        <li><a href="http://< ?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/transaksi/return_pbf.php"><span>Return PBF</span></a></li>
                    </ul-->
                </li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/transaksi/pendapatan.php"><span>Lain-lain</span></a></li>
            </ul>
        </li>
        <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/transaksi/pengeluaran.php" class="parent"><span>Pengeluaran</span></a>
        </li>
        <!--li><a href="#" class="parent"><span>Transaksi</span></a>
            <ul>
                <li><a href="http://< ?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/transaksi/pendapatan.php"><span>Pendapatan</span></a></li>
                <li><a href="http://< ?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/transaksi/pengeluaran.php"><span>Pengeluaran</span></a></li>
            </ul>
        </li-->
        <li><a href="#" class="parent"><span>Pembayaran KSO</span></a>
            <ul>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/transaksi/pembayaran_kso.php?tipe=1"><span>Rawat Jalan</span></a></li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/transaksi/pembayaran_kso.php?tipe=2"><span>Rawat Inap</span></a></li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/transaksi/pembayaran_kso.php?tipe=3"><span>IGD</span></a></li>
            </ul>
        </li>
        <li><a href="#" class="parent"><span>Laporan</span></a>
            <ul>
                <!--li><a href="#" class="parent"><span>Sub Item 1</span></a>
                    <ul>
                        <li><a href="#"><span>Sub Item 1.1</span></a></li>
                        <li><a href="#"><span>Sub Item 1.2</span></a></li>
                    </ul>
                </li>
                <li><a href="#" class="parent"><span>Sub Item 2</span></a>
                    <ul>
                        <li><a href="#"><span>Sub Item 2.1</span></a></li>
                        <li><a href="#"><span>Sub Item 2.2</span></a></li>
                    </ul>
                </li-->
                <li><a href="javascript:void(0)" onclick="popupReport1()"><span>Pendapatan</span></a></li>
                <li><a href="javascript:void(0)" onclick="popupReport2()"><span>Pengeluaran</span></a></li>
				<li><a href="javascript:void(0)" onclick="popupReport8()"><span>Penerimaan</span></a></li>
				<li><a href="javascript:void(0)" onclick="popupReport9()"><span>Pendapatan Penjamin Pasien</span></a></li>
				<li><a href="javascript:void(0)" onclick="popupReport10()"><span>Pengajuan Klaim</span></a></li>
                <!--li><a href="javascript:void(0)" onclick="popupReport3()"><span>Pendapatan Per Jenis Transaksi</span></a></li-->
                <li><a href="javascript:void(0)" onclick="popupReport4()"><span>Rekapitulasi Pendapatan</span></a></li>
                <li><a href="javascript:void(0)" onclick="popupReport7()"><span>Rekapitulasi Pengeluaran</span></a></li>
                <!--li><a href="javascript:void(0)" onclick="popupReport4()"><span>Rekapitulasi Pendapatan Harian</span></a></li>
                <li><a href="javascript:void(0)" onclick="popupReport5()"><span>Rekapitulasi Pendapatan Bulanan</span></a></li>
                <li><a href="#"><span>Sub Item 5</span></a></li>
                <li><a href="#"><span>Sub Item 6</span></a></li>
                <li><a href="#"><span>Sub Item 7</span></a></li-->
            </ul>
        </li>
        <!--li><a href="#"><span>Help</span></a></li>
        <li class="last"><a href="#"><span>Contacts</span></a></li-->
        <li class="last"><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/keuangan/user_logout.php"><span>Logout</span></a></li>
    </ul>
</div>
<div style="display:none"id="copyright">Copyright &copy; 2010 <a href="http://apycom.com/">Apycom jQuery Menus</a></div>

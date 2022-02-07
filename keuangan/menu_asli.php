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
        <li><a href="#" class="parent"><span>Master</span></a>
            <ul style="width:130px">
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/masters/users.php"><span>Users</span></a></li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/masters/jenis_transaksi.php"><span>Jenis Transaksi</span></a></li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/masters/akun_jenis_transaksi.php"><span>Akun Jenis Trans.</span></a></li>
            </ul>
        </li>
        <li><a href="#" class="parent"><span>View Transaksi</span></a>
            <ul style="width:140px">
                <!--li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/transaksi/pendapatan_billing.php?tipe=1"><span>Rawat Jalan</span></a></li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/transaksi/pendapatan_billing.php?tipe=2"><span>Rawat Inap</span></a></li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/transaksi/pendapatan_billing.php?tipe=3"><span>IGD</span></a></li-->
                <li><a href="#" class="parent"><span>Kunjungan Pasien</span></a>
                	<ul style="margin: -38px 0 0 125px !important;width:200px;">
                    	<li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/view_transaksi/view_transbytglkunjungan.php"><span>Berdasarkan Tgl Berkunjung</span></a></li>
                    	<li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/view_transaksi/view_transbykunjungan.php"><span>Kunjungan Masih Aktif</span></a></li>
                        <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/view_transaksi/view_transbykunjunganKRS.php"><span>Kunjungan Sudah Pulang (KRS)</span></a></li>
                    </ul>
                </li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/view_transaksi/pendapatan_billing.php?tipe=4"><span>Transaksi Billing</span></a></li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/view_transaksi/pendapatan_farmasi.php"><span>Transaksi Farmasi</span></a>
                </li>
            </ul>
        </li>
        <li><a href="#" class="parent"><span>Verifikasi Data</span></a>
            <ul style="width:150px">
                <li><a href="#" class="parent"><span>Penerimaan Kasir</span></a>
                    <ul style="margin: -38px 0 0 135px !important;width:170px">
                        <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/verifikasi_data/penerimaan_billing_kasir.php"><span>Penerimaan Kasir Billing</span></a></li>
                        <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/verifikasi_data/penerimaan_penjualan_obat.php"><span>Penerimaan Kasir Farmasi</span></a></li>
                    </ul>
        		</li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/verifikasi_data/pasienKRS.php"><span>Pasien KRS / Piutang</span></a></li>
            	<li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/verifikasi_data/penerimaan_diklit.php"><span>Penerimaan Diklit</span></a></li>
            	<!--li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/verifikasi_data/verifikasi_selisih_tarip.php"><span>Selisih Tarip</span></a></li-->
			</ul>
        </li>
        <li>
			<a href="#" class="parent"><span>Penerimaan</span></a>
			<ul style="width:155px">
				<li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/penerimaan/penerimaan_parkir.php"><span>Penerimaan Parkir</span></a></li>
				<li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/penerimaan/penerimaan_ambulan.php"><span>Penerimaan Ambulan</span></a></li>
                <!--li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/penerimaan/penerimaan_diklit.php"><span>Penerimaan Diklit</span></a></li-->
                <!--li><a href="#"><span>Penerimaan Diklit</span></a></li-->
				<li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/penerimaan/pendapatan.php"><span>Penerimaan Lainnya</span></a></li>
			</ul>
		</li>
        <li><a href="#" class="parent"><span>Pengeluaran</span></a>
			 <ul style="width:170px">
				    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/transaksi/f_return_pelayanan.php"><span>Retur Tindakan Billing</span></a>
                    </li>
                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/transaksi/f_return_pembayaran.php"><span>Retur Pembayaran Billing</span></a>
                    </li>
				    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/transaksi/returnObat.php"><span>Retur Penjualan Obat</span></a>
                    </li>
					<!--li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/transaksi/pemakaian_brg.php"><span>Pemakaian Barang</span></a></li-->
					<li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/transaksi/pengeluaran.php"><span>Pengeluaran Lainnya</span></a></li>
			 </ul>
        </li>
        <li><a class="parent" href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/bkm/bkm.php"><span>BKM</span></a></li>
	   	<li>
       		<a href="#" class="parent"><span>Klaim KSO/Piutang</span></a>
            <ul style="width:135px">
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/klaimKSO/pengajuan_Klaim.php"><span>Pengajuan Klaim</span></a></li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/klaimKSO/penerimaan_Klaim.php"><span>Penerimaan Klaim</span></a></li>
            </ul>
	   	</li>
        <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/transaksi/kas_bank.php"><span>KAS - BANK</span></a></li>
        <li><a href="#" class="parent"><span>Laporan</span></a>
            <ul style="width:160px">
                <li><a href="#" class="parent"><span>Pendapatan</span></a>
                	<ul style="margin: -38px 0 0 145px !important;width:185px;">
                        <li><a href="#" class="parent" onclick=""><span>Pendapatan Jasa Layanan</span></a>
                            <ul style="margin: -38px 0 0 168px !important;width:125px;">
                                <li><a href="#" class="parent" onclick=""><span>Billing</span></a>
                                    <ul style="margin: -38px 0 0 110px !important;width:115px;">
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(1,<?php echo $fromHome; ?>)"><span>Non Pavilyun</span></a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(2,<?php echo $fromHome; ?>)"><span>Pavilyun</span></a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(3,<?php echo $fromHome; ?>)"><span>Total</span></a></li>
                                    </ul>
                        		</li>
                                <li><a href="#" class="parent" onclick=""><span>Farmasi</span></a>
                                    <ul style="margin: -38px 0 0 110px !important;width:115px;">
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(4,<?php echo $fromHome; ?>)"><span>Non Pavilyun</span></a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(5,<?php echo $fromHome; ?>)"><span>Pavilyun</span></a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(6,<?php echo $fromHome; ?>)"><span>Total</span></a></li>
                                    </ul>
                            	</li>
                                <li><a href="#" class="parent" onclick=""><span>Billing + Farmasi</span></a>
                                    <ul style="margin: -38px 0 0 110px !important;width:115px;">
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(7,<?php echo $fromHome; ?>)"><span>Non Pavilyun</span></a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(8,<?php echo $fromHome; ?>)"><span>Pavilyun</span></a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(9,<?php echo $fromHome; ?>)"><span>Total</span></a></li>
                                    </ul>
                            	</li>
                        	</ul>
                        </li>
                        <li><a href="javascript:void(0)" onclick="popupReportNew(10,<?php echo $fromHome; ?>)"><span>Pendapatan Kerja Sama</span></a></li>
                        <li><a href="javascript:void(0)" onclick="popupReportNew(11,<?php echo $fromHome; ?>)"><span>Pendapatan Hibah</span></a></li>
						<li><a href="javascript:void(0)" onclick="popupReportNew(27,<?php echo $fromHome; ?>)"><span>Pendapatan Parkir</span></a></li>
						<li><a href="javascript:void(0)" onclick="popupReportNew(28,<?php echo $fromHome; ?>)"><span>Pendapatan Ambulan</span></a></li>
                        <li><a href="javascript:void(0)" onclick="popupReportNew(12,<?php echo $fromHome; ?>)"><span>Pendapatan Lain-Lain</span></a></li>
                        <li><a href="javascript:void(0)" onclick="popupReportNew(29,<?php echo $fromHome; ?>)"><span>Rekap Pendapatan</span></a></li>
                    </ul>
                </li>
                <li><a href="#" class="parent"><span>Penerimaan</span></a>
                	<ul style="margin: -38px 0 0 145px !important;width:185px;">
                        <li><a href="#" class="parent" onclick=""><span>Penerimaan Jasa Layanan</span></a>
                            <ul style="margin: -38px 0 0 168px !important;width:125px;">
                                <li><a href="#" class="parent" onclick=""><span>Billing</span></a>
                                    <ul style="margin: -38px 0 0 110px !important;width:115px;">
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(13,<?php echo $fromHome; ?>)"><span>Non Pavilyun</span></a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(14,<?php echo $fromHome; ?>)"><span>Pavilyun</span></a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(15,<?php echo $fromHome; ?>)"><span>Total</span></a></li>
                                    </ul>
                        		</li>
                                <li><a href="#" class="parent" onclick=""><span>Farmasi</span></a>
                                    <ul style="margin: -38px 0 0 110px !important;width:115px;">
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(16,<?php echo $fromHome; ?>)"><span>Non Pavilyun</span></a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(17,<?php echo $fromHome; ?>)"><span>Pavilyun</span></a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(18,<?php echo $fromHome; ?>)"><span>Total</span></a></li>
                                    </ul>
                            	</li>
                                <li><a href="#" class="parent" onclick=""><span>Billing + Farmasi</span></a>
                                    <ul style="margin: -38px 0 0 110px !important;width:115px;">
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(19,<?php echo $fromHome; ?>)"><span>Non Pavilyun</span></a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(20,<?php echo $fromHome; ?>)"><span>Pavilyun</span></a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReportNew(21,<?php echo $fromHome; ?>)"><span>Total</span></a></li>
                                    </ul>
                            	</li>
                        	</ul>
                        </li>
                        <li><a href="javascript:void(0)" onclick="popupReportNew(22,<?php echo $fromHome; ?>)"><span>Penerimaan Kerja Sama</span></a></li>
                        <li><a href="javascript:void(0)" onclick="popupReportNew(23,<?php echo $fromHome; ?>)"><span>Penerimaan Hibah</span></a></li>
						<li><a href="javascript:void(0)" onclick="popupReportNew(27,<?php echo $fromHome; ?>)"><span>Penerimaan Parkir</span></a></li>
						<li><a href="javascript:void(0)" onclick="popupReportNew(28,<?php echo $fromHome; ?>)"><span>Penerimaan Ambulan</span></a></li>
                        <li><a href="javascript:void(0)" onclick="popupReportNew(24,<?php echo $fromHome; ?>)"><span>Penerimaan Lain-Lain</span></a></li>
						<!--li><a href="javascript:void(0)" onclick="popupReportNew(30,<?php echo $fromHome; ?>)"><span>Rekap Penerimaan</span></a></li-->
                    </ul>
                </li>
				<!--li><a href="#" class="parent"><span>Penerimaan</span></a>
                	<ul style="margin: -38px 0 0 145px !important;">
                        <li><a href="javascript:void(0)" onclick="popupReport(7,<?php echo $fromHome; ?>)"><span>Penerimaan Lain-lain</span></a></li>
                        <li><a href="#" onclick="popupReport(8,<?php echo $fromHome; ?>)"><span>Rekap Penerimaan Billing</span></a></li>
                        <li><a href="#" onclick="popupReport(81,<?php echo $fromHome; ?>)"><span>Rekap Penerimaan Farmasi</span></a></li>
                        <li><a href="#" onclick="popupReport(82,<?php echo $fromHome; ?>)"><span>Rekap Penerimaan</span></a></li>
                    </ul>
                </li-->
                <li><a href="#" class="parent"><span>Pengeluaran</span></a>
                	<ul style="margin: -38px 0 0 145px !important;">
                    	<li><a href="javascript:void(0)" onclick="popupReport(12,<?php echo $fromHome; ?>)"><span>Rekap Retur Obat</span></a></li>
                		<li><a href="javascript:void(0)" onclick="popupReport(2,<?php echo $fromHome; ?>)"><span>Pengeluaran Lain-Lain</span></a></li>
                        <li><a href="javascript:void(0)" onclick="popupReport(99,<?php echo $fromHome; ?>)"><span>Retur Pelayanan</span></a></li>
                        <li><a href="javascript:void(0)" onclick="popupReport(98,<?php echo $fromHome; ?>)"><span>Retur Penjualan Obat</span></a></li>
                        <!--li><a href="javascript:void(0)" onclick="popupReport(6,<?php echo $fromHome; ?>)"><span>Rekap Pengeluaran Lain2</span></a></li-->
                    </ul>
                </li>
                <li><a href="javascript:void(0)" class="parent"><span>Pengurang Pendapatan</span></a>
                	<ul style="margin: -38px 0 0 145px !important;width:135px;">
                    	<li><a href="javascript:void(0)" onclick="popupReport(13,<?php echo $fromHome; ?>)"><span>Belum Terbayar</span></a></li>
                		<li><a href="javascript:void(0)" onclick="popupReport(131,<?php echo $fromHome; ?>)"><span>Sudah Terbayar</span></a></li>
                    </ul>
                </li>
				<li><a href="javascript:void(0)" class="parent"><span>Klaim KSO</span></a>
                	<ul style="margin: -38px 0 0 145px !important;width:135px;">
                    	<li><a href="javascript:void(0)" onclick="popupReportNew(25,<?php echo $fromHome; ?>)"><span>Pengajuan Klaim</span></a></li>
                		<li><a href="javascript:void(0)" onclick="popupReportNew(26,<?php echo $fromHome; ?>)"><span>Penerimaan Klaim</span></a></li>
                    </ul>
                </li>
				<li><a href="javascript:void(0)" onclick="popupReport(112,<?php echo $fromHome; ?>)"><span>BKU</span></a></li>
				<li><a href="javascript:void(0)" onclick="popupReport(113,<?php echo $fromHome; ?>)"><span>Realisasi Anggaran</span></a></li>
				<li><a href="javascript:void(0)" class="parent"><span>Pengembalian Retur</span></a>
                	<ul style="margin: -38px 0 0 145px !important;width:135px;">
                    	<li><a href="javascript:void(0)" onclick="popupReport(969,<?php echo $fromHome; ?>)"><span>Apotek</span></a></li>
						<li><a href="javascript:void(0)" onclick="popupReportNew(33,<?php echo $fromHome; ?>)"><span>Tindakan Billing</span></a></li>
						<li><a href="javascript:void(0)" onclick="popupReportNew(32,<?php echo $fromHome; ?>)"><span>Pembayaran Billing</span></a></li>
                    </ul>
                </li>
				<li><a href="javascript:void(0)" class="parent"><span>Setoran Kasir</span></a>
                	<ul style="margin: -38px 0 0 145px !important;width:135px;">
						<li><a href="javascript:void(0)" onclick="popupReportNew(31,<?php echo $fromHome; ?>)"><span>Per No Bukti</span></a></li>
                    </ul>
                </li>
                <!--li><a href="javascript:void(0)" onclick="popupReport3()"><span>Pendapatan Per Jenis Transaksi</span></a></li-->
            </ul>
        </li>
        <li class="last"><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/keuangan/user_logout.php"><span>Logout</span></a></li>
    </ul>
</div>
<div style="display:none"id="copyright">Copyright &copy; 2010 <a href="http://apycom.com/">Apycom jQuery Menus</a></div>

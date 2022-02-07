<?php
include '../sesi.php';
include '../koneksi/konek.php'; 
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/simrs-tangerang/aset/';
                        </script>";
}
$unit_opener="par=idunit*kodeunit*namaunit*idlokasi*kodelokasi";
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <title>.: Riwayat Pengeluaran Barang :.</title>
    </head>

    <body>
        <div align="center">
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
            <?php
            include "../header.php";
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            $tgl=explode("-",$date_now);
            $tgl1=$tgl[2]."-".$tgl[1]."-".$tgl[0];
			
            ?>
			<form id="form1" name="form1" action="../laporan/laporan_keluar_habis_pakai_scroll.php" method="post" target="_blank">
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="center"> Nama Unit : 
                    <input name="kodeunit" type="text" class="txtmustfilled" id="kodeunit" size="30" maxlength="15" readonly style="text-align:left; padding:2px; border:1px solid #999999;" />&nbsp;
                                        <img alt="tree" title='daftar unit kerja'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="OpenWnd('../Aktivitas/unit_tree.php?<?php echo $unit_opener; ?>',800,500,'Tree Unit',true)" />&nbsp;&nbsp;              
                                        <input type="checkbox" name="chkall" value="checkbox" onClick="if (this.checked==true) {document.getElementById('idunit').value='0';document.getElementById('kodeunit').value='0';}else{document.getElementById('idunit').value='';document.getElementById('kodeunit').value='';}" />
                                        Semua Unit Kerja				  </td>
                </tr>
                <tr>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                    <td height="350" valign="top" align="center">
					
					Periode :
                                    <input id="tglawal" name="tglawal" value="<?php echo $date_now;?>" readonly size="10" class="txtcenter"/>
                                    &nbsp;
                                    <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglawal'),depRange);" /> s/d                                
                                    <input id="tglakhir" name="tglakhir" value="<?php echo $date_now;?>" readonly="readonly" size="10" class="txtcenter"/>&nbsp;
                                    <img alt="calender" style="cursor:pointer" border="0" src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglakhir'),depRange);" />&nbsp;
									<input name="idunit" type="hidden" id="idunit" value="" />
									<input name="namaunit" type="hidden" id="namaunit" value="" />
									<input name="idlokasi" type="hidden" id="idlokasi" value="" />
									<input name="kodelokasi" type="hidden" id="kodelokasi" value="" />
									<input name="submit" type="submit" id="submit" value="Tampilkan" onClick=""/>
                                        <!--img border="0" width="16" height="10" /-->
                    				</td>
                </tr>
                <tr>
                    <td align="center"><div><img alt="" src="../images/foot.gif" width="1000" height="45" /></div>                    </td>
                </tr>
            </table>
			</form>	
        </div>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
    </body>
   
</html>
 <script type="text/JavaScript" language="JavaScript">
        var arrRange=depRange=[];

    </script>
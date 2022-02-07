<?php
session_start();
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
} 
//$unit_opener="par=idunit*kodeunit*namaunit*idlokasi*kodelokasi";
$barang_opener="par=idbarang*kodebarang*namabarang";
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: Laporan Kartu Stok :.</title>
    </head>

    <body>
        <div id="tree" style="display: none;"></div>
        <div align="center">
            <?php
            include '../header.php';
            ?>
            <table width="1000" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding-top: 10px;" align="center">
                        <form id="form1" name="form1" action="laporanKartuStok.php" method="post" target="Laporan Kartu Inventaris Barang">
                            <script>
                                        function showtree(){
                                            if(document.getElementById('treediv').style.display=='none'){
                                                document.getElementById('treediv').style.display='inline';
                                                }    
                                             else{
                                                document.getElementById('treediv').style.display='none';
                                                                                            
                                                                                             
                                             }                  
                                        }
                            </script>
                            <iframe scrolling="auto"  id="treediv" style="display: none;" width="1000" src="thing_tree.php?<?php echo $barang_opener; ?>"></iframe>
                            
                            <table width="600" border="0" cellspacing="0" cellpadding="4">
                                <tr align="center">
                                    <td colspan="2" class="header">
                                        <strong><font size="2">Laporan Kartu Stok</font></strong>
                                    </td>
                                </tr>
								<tr>
                                    <td class="label">
                                        <strong>Barang</strong>
                                    </td>
                                    <td class="content" width="493">
                                    <input name="idbarang" type="hidden" class="txtunedited" id="idbarang" value="<?php echo  $rows["idbarang"]; ?>" size="16" maxlength="14" readonly/>
                                    <input name="kodebarang" type="text" class="txtunedited" id="kodebarang" value="<?php echo  $rows["kodebarang"]; ?>" size="16" maxlength="14" readonly/>
                                    <input name="namabarang" type="text" class="txtunedited" id="namabarang" value="<?php echo  $rows["namabarang"]; ?>" size="30" maxlength="30" readonly/>
                <img alt="tree" title='Struktur tree kode barang'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="OpenWnd('thing_tree.php?<?php echo $barang_opener; ?>',800,500,'msma',true);"> </td>
                                </tr>
                                
                                <tr>
                                    <td class="label"><strong>Tanggal Perolehan</strong></td>
                                    <td class="content">
                                        <div id="a" >
                                            <input name="tglawal" type="text" class="txt" id="tglawal" tabindex="4" value="<?php echo date('d-m-Y');?>" size="15" maxlength="15" readonly />
                                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglawal'),depRange);" />
                                            <!--img alt="calender" name="imgtglawal" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onclick="javascript:show_calendar('form1.tglawal','dd-mm-yyyy',null,null,window.event);" /-->
                                            &nbsp;s/d&nbsp;
                                            <input name="tglakhir" type="text" class="txt" id="tglakhir" tabindex="4" value="<?php echo date('d-m-Y');?>" size="15" maxlength="15" readonly />
                                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglakhir'),depRange);" />
                                            <!--img alt="calender" name="imgtglakhir" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onclick="javascript:show_calendar('form1.tglakhir','dd-mm-yyyy',null,null,window.event);" /-->
                                            <font size=1 color=gray><i>(dd-mm-yyyy)</i></font>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"><strong>Format Laporan </strong></td>
                                    <td class="content"><select name="formatlap" class="txt" id="formatlap" tabindex="7">
                                            <option value="HTML">HTML</option>
                                            <option value="XLS">EXCEL</option>
                                            <option value="WORD">WORD</option>
                                        </select></td>
                                </tr>
                                <tr align="center">
                                    <td colspan="2" class="header2">
                                        <input name="submit" type="submit" id="submit" value="Tampilkan" onClick="if (document.getElementById('idbarang').value=='') {alert('Pilih Barang ');return false;}"/>
                                    </td>
                                </tr>
                            </table>
                            <input name="idunit" type="hidden" id="idunit" value="" />
                            <input name="namaunit" type="hidden" id="namaunit" value="" />
                            <input name="idlokasi" type="hidden" id="idlokasi" value="" />
                            <input name="kodelokasi" type="hidden" id="kodelokasi" value="" />
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        include '../footer.php';
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
    </body>
    <script type="text/JavaScript" language="JavaScript">
        var arrRange=depRange=[];
	
    </script>
</html>

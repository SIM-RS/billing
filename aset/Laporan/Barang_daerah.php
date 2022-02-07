<?php
session_start();
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
$tgl1=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl1);
 $ta=$th[2];
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: Laporan Barang Milik Daerah :.</title>
    </head>

    <body>
        <div id="tree" style="display: none;">
            
        </div>    
        
        <div align="center">
            <?php
            include '../header.php';
            ?>
            <table width="1000" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding-top: 10px;" align="center">
                    
                    <iframe id="treediv" scrolling="auto" style="display: none;" width="1000" src="../Aktivitas/unit_tree.php?<?php echo $unit_opener; ?>"></iframe>                                        
                                                        
                        <form id="form1" name="form1" action="laporan_milik_daerah.php" method="get" target="_blank">
                            <table width="600" border="0" cellspacing="0" cellpadding="4">
                                <tr align="center">
                                    <td colspan="2" class="header">
                                        <strong><font size="2">Laporan Barang Milik Daerah</font></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"><strong>Unit / Satuan Kerja </strong></td>
                                    <td class="content">
                                           <?
											$sq = mysql_query("select namadepartemen,kodedepartemen,dir_nama,dir_nip,pengurus_nama,pengurus_nip from as_setting");
											$t = mysql_fetch_array($sq);

										   ?>										   
                                        <input name="" type="text" class="txtmustfilled" id="" size="15" maxlength="15" readonly style="text-align:left;" value="<?php echo $t['kodedepartemen'];?>"/>
                                        <input name="" type="text" class="txtmustfilled" id="" size="25" maxlength="25" readonly style="text-align:left;" value="<?php echo $t['namadepartemen'];?>"/>
                                        <!--img alt="tree" title='daftar unit kerja'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="OpenWnd('../Aktivitas/unit_tree.php?<?php //echo $unit_opener; ?>',800,500,'msma',true)" /-->
                                        <!--img alt="tree" title='daftar unit kerja'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absmiddle" onclick="if (document.getElementById('kodeunit').value != '0') {show_treeunit();}" /-->
                                        <!--input type="checkbox" name="chkall" value="checkbox" onClick="if (this.checked==true) {document.getElementById('idunit').value='0';document.getElementById('kodeunit').value='0';}else{document.getElementById('idunit').value='';document.getElementById('kodeunit').value='';}" />
                                        Semua Unit Kerja<br /-->
                                                                                
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td width="139" class="label"><strong>Tahun </strong></td>
                                    <td width="439" class="content">
                                        <select name="thn" class="txt" id="thn" tabindex="2" onChange="">
                                            <?php for ($i=($th[2]-5);$i<($th[2]+1);$i++) { ?>
                                                    <option  value="<?php echo $i; ?>"<?php if ($i==$ta) echo "selected";?>>
                                                        <?php echo $i;?>
                                                    </option>
                                                    <?php } ?>
                                        </select>
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
									<input name="submit2" type="submit" id="submit2" value="Tampilkan" onClick="" /></td>
                                </tr>
                            </table>
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

<?php
include 'secured_sess.php';
include("koneksi/konek.php");
$fromHome="1";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>Module Keuangan</title>
        <link type="text/css" href="menu.css" rel="stylesheet" />
        <link type="text/css" rel="stylesheet" href="theme/mod.css" />
        <link type="text/css" href="menu.css" rel="stylesheet" />
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" src="menu.js"></script>
        <!--script type="text/javascript" src="theme/js/ajax.js"></script-->
        <script type="text/javascript" language="JavaScript" src="theme/js/dsgrid.js"></script>
        <script type="text/javascript" language="JavaScript" src="theme/js/ajax.js"></script>
        <script type="text/javascript" language="JavaScript" src="theme/js/mod.js"></script>
        <link rel="stylesheet" type="text/css" href="theme/popup.css" />
        <script type="text/javascript" src="theme/prototype.js"></script>
        <script type="text/javascript" src="theme/effects.js"></script>
        <script type="text/javascript" src="theme/popup.js"></script>
    </head>
<script>
	var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>

    <body bgcolor="#808080" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <div align="center">
            <table width="1000" id="table_01" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" width="1000">
                        <div align="center">
                            <?php include("header.php");
							include("laporan/report_form.php");?>
                            <div><?php include("main.php");?></div>
                            <div><?php include("footer.php");?></div>

                            <div></div>
                            <div align="left"></div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </body>
<script>
	var th_skr='<?php echo $date_skr[2];?>';
	var bl_skr='<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>';
	var fromHome=<?php echo $fromHome ?>;
</script>
<script src="report_form.js" type="text/javascript" language="javascript"></script>
</html>

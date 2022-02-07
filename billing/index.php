
</head>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SimRS</title>
		<link rel="shortcut icon" href="icon/favicon.ico" />
        <link type="text/css" href="menu.css" rel="stylesheet" />
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" src="menu.js"></script>
        <script language="javascript">
		function tampil1(a,b,d)
		{
			window.open("unit_pelayanan/rekamMedis.php?idKunj="+d+"&idPel="+b+"&idPasien="+a);
		}
		function tampil2(a,b,d)
		{
			window.open("unit_pelayanan/resumemedis.php?idKunj="+d+"&idPel="+b+"&idPasien="+a);
		}
		</script>
        <body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
            <!-- ImageReady Slices (SimRS.psd) -->
            <div align="center">
                <table align="center" id="Table_01" width="1000" height="600" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="1000" height="96"><?php include "header2.php";?></td>
                    </tr>
                    <tr>
                        <td width="1000" height="32">
                            <?php include "menu2.php";?>
                        </td>
                    </tr>
                    <tr>
                        <td width="1000" height="399" valign="top"><?php include "body1.php";?></td>
                    </tr>
                    <tr>
                        <td width="1000" valign="top">
                            <?php include "foot.php";?>
                            <div id="copyright" style="display:none">Copyright &copy; 2010 <a href="http://apycom.com/">Apycom jQuery Menus</a></div></td>
                    </tr>
                </table>
            </div>
            <!-- End ImageReady Slices -->
        </body>
</html>
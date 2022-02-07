<?
include("sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="theme/mod.css"></link>
        <script type="text/javascript" language="JavaScript" src="theme/js/dsgrid.js"></script>
            <style type="text/css" media="screen"> @import url("menuh.css"); </style>
            <!--[if lt IE 7]>
            <style type="text/css" media="screen">
            #menuh{float:none;}
            body{behavior:url(csshover.htc); font-size:100%;}
            #menuh ul li{float:left; width: 100%;}
            #menuh a{height:1%;font:bold 0.7em/1.4em arial, sans-serif;}
            </style>
            <![endif]-->
            <title>Sistem Informasi Manajemen <?=$namaRS?></title>
    </head>

    <body bgcolor="#80ABB5">
        <div align="center">
            <br/>
            <div style="width: 1010px; height: 518px; background-color: white; padding-top: 5px">
            <?php include("header.php");?>
            <table width="1000" border="0" style="background-image: url(images/bekgron36.jpg); height: 450px" cellspacing="0" cellpadding="0" align="center">
                <!--tr>
                  <td width="92" height="50" style="background-image:url(images/home_02.gif)">&nbsp;</td>
                  <td width="76" style="background-image:url(images/home_03.gif)">&nbsp;</td>
                  <td width="91" style="background-image:url(images/home_04.gif)">&nbsp;</td>
                  <td width="78" style="background-image:url(images/home_05.gif)">&nbsp;</td>
                  <td width="90" style="background-image:url(images/home_06.gif)">&nbsp;</td>
                  <td width="81" style="background-image:url(images/home_07.gif)">&nbsp;</td>
                  <td width="287" style="background-image:url(images/home_08.gif)">&nbsp;</td>
                </tr-->
                <!--tr>
                      <td colspan="7" align="center"><img src="images/home_01.gif" /></td>
                </tr-->
                <tr>
                    <td align="center" width="500" height="60" style="padding-top: 5px" valign="top">
                        <?php include("menu.php"); ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top" align="center">
                        
                    </td>
                </tr>
                <!--tr>
                    <td colspan="2" style="background-image: url(images/home_11.gif); background-repeat: no-repeat; ">
                        &nbsp;
                    </td>
                </tr-->
            </table>
            <span style="float: left; font-size: 10px; padding-top: 5px">Copy Right by Majapahit Cipta Mandiri &copy; 2010</span>
            <span style="float: right; font-size: 10px; padding-top: 5px">Designed by wsw36</span>
            </div>
        </div>
    </body>
</html>

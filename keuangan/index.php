<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>simkeu</title>
        <link rel="stylesheet" type="text/css" href="style2.css" media="screen" />
        <style type="text/css">
            <!--
            .style5 {color: #5f9420}
            .style8 {
                font-size: 16px;
                font-family: Tahoma;
                color: #a91d05;
                font-weight: bold;
            }
            .style12 {font-size: 14px; font-family: Tahoma; color: #1575c1; }
            -->
        </style>
    </head>

    <body bgcolor="#808080" onLoad="fOnLoad('<?php echo $err; ?>');">
        <div id="main_container">
            <div id="header"></div>
            <div id="main_content">
                <div id="right_content">
                    <div class="col2 maxheight">
                        <div class="indent">
                            <div class="indent1">
                                <p>&nbsp;</p>
                                <div id="block">
                                    <div class="t">
                                        <div class="b">
                                            <div class="r">
                                                <div class="l">
                                                    <div class="tr">
                                                        <div class="tl">
                                                            <div class="bl">
                                                                <div class="br">
                                                                    <div class="block"><div>
                                                                            <!--h2 align="center" class="style6">&nbsp;</h2-->
                                                                            <div class="indent" style="padding-top: 5px;">
                                                                                <form action="user_login.php" method="post" id="frmLogin" name="login">
                                                                                    <table width="283" border="0">
                                                                                        <tr>
                                                                                            <td width="14">&nbsp;</td>
                                                                                            <td width="88">
                                                                                                <span class="style8">User login</span>
                                                                                            </td>
                                                                                            <td width="167">&nbsp;</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td rowspan="2">&nbsp;</td>
                                                                                            <td><span class="style12">Login</span></td>
                                                                                            <td>
                                                                                                <input name="username" type="text" class="login_text" id="username" size="19" height="15" />
																			 <!-- onKeyUp="KeyEvent(event,this);"-->
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><span class="style12">Password</span></td>
                                                                                            <td>
                                                                                                <input name="password" type="password" class="login_text" id="password" size="19" height="15" />
																			 <!-- onKeyUp="KeyEvent(event,this);"-->
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>&nbsp;</td>
                                                                                            <td>&nbsp;</td>
                                                                                            <td align="left">
                                                                                                <input type="submit" name="Submit" value="Login" class="login_btn" onClick="GoSubmit();" />
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </form>
                                                                            </div>
                                                                            <p>
                                                                            </p>
                                                                        </div>
                                                                        <b></b>
                                                                        <div class="clear"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end of left content-->

                <div id="right__content">
                    <div></div>
                </div>
                <!--end of right content-->

                <div class="green_box">
                    <div class="clock"></div>
                    <div class="text_content">
                        <h1 class="style5">&nbsp;</h1>
                        <p class="green">Selamat datang dalam Sistem Informasi Manajeman Rumah Sakit Pelindo</p>
                    </div>
                    <div id="right_nav"><img src="images/login_21.png" width="103" height="78" />&nbsp;<img src="images/login_23.png" width="103" height="78" />&nbsp;<img src="images/login_23.gif" width="104" height="73" /></div>
                </div>

                <div style=" clear:both;"></div>
            </div><!--end of main content-->

            <div id="footer">
                <div class="footer_links">
                    <a href="http://www.digital-sense.net">powered by digital sense</a><a href="http://www.digital-sense.net"></a>
                </div>
            </div>

        </div> <!--end of main container-->
    </body>
</html>
<script type="text/javascript" language="javascript">
    function fOnLoad(pesan){
        document.forms[0].username.focus();
        if (pesan!="") alert(pesan);
    }

    function GoSubmit(){
        if (document.forms[0].username.value==""){
            alert("Isikan Username Anda Terlebih Dahulu !");
            document.forms[0].username.focus();
            return false;
        }
        if (document.forms[0].password.value==""){
            alert("Isikan Password Anda Terlebih Dahulu !");
            document.forms[0].password.focus();
            return false;
        }
        document.forms[0].submit();
    }
</script>
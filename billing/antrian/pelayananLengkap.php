<?php
//include "../sesi.php";
include "../koneksi/konek.php";
?>
<?php
	/*$hostname_conn = "localhost";
	//$hostname_conn = "192.168.1.2";
	$database_conn = "billing_tangerang";
	$username_conn = "root";
	$password_conn = "rsudsda";
	
	$konek=mysql_connect($hostname_conn,$username_conn,$password_conn);
	mysql_select_db($database_conn,$konek);*/
	
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$time_now=gmdate('H:i:s',mktime(date('H')+7));
	$tglGet=$_REQUEST['tgl'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>SimRS</title>
		<link type="text/css" href="menu.css" rel="stylesheet" />
		<link type="text/css" rel="stylesheet" href="../theme/modmod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
		<script type="text/javascript" src="../theme/js/ajax.js"></script>
	</head>
		<script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
        <body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="timedCount()">
            <!-- ImageReady Slices (SimRS.psd) -->
            <div align="center">
                <table align="center" id="Table_01" width="1280" height="600" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%" height="96"><?php include "header1.php";?></td>
                    </tr>
                    <tr>
                        <td width="100%" height="399" valign="top">
							<div align="center">
								<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#008484"  class="hd2">
									<tr>
										<td height="32" style="padding-left:20px; text-align:left; font-size:24px; text-transform:uppercase; color:#0000FF; font-weight:bold;">
											<input id="txtTgl" name="txtTgl" type="hidden" value="<?php echo $_REQUEST['txtTgl'];?>" />
											<input id="cmbDilayani" name="cmbDilayani" type="hidden" value="<?php echo $_REQUEST['cmbDilayani'];?>" />
										</td>
									</tr>
								</table>
								<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabel">
									<tr>
										<td>
											<fieldset>
												<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
													<tr>
														<td align="center">
															<div id="gridbox2" style="width:1250px; height:550px; background-color:white; overflow:hidden;"></div>
															<div id="paging" style="width:1250px; display:none;"></div>
														</td>
													</tr>
												</table>
											</fieldset>										
										</td>
									</tr>
								</table>
							</div>
						</td>
                    </tr>
                </table>
            </div>
            <!-- End ImageReady Slices -->
        </body>
	<script>
			this.grid = document.getElementById('gridbox2');
			this.grid.page=1;
			this.grid.maxpage=1;	
			
			var c=0;
			var t;
			var timer_is_on=0;
			
			function timedCount(){
				//document.getElementById('txt').value=c;
				c = c+1;
				if(c == 10){
					c = 0;
					nextnext();
				}
				t=setTimeout("timedCount()",1000);
			}
			
			function doTimer(){
				if(!timer_is_on){
					timer_is_on=1;
			  		timedCount();
			  	}
			}
			//setTimeout("nextnext()","1200");
			
			function nextnext(){
				if (document.getElementById('gridbox2').page < document.getElementById('gridbox2').maxpage){
					document.getElementById('gridbox2').page = document.getElementById('gridbox2').page + 1;
					goFilterAndSort('gridbox2');
				}else{
					document.getElementById('gridbox2').page = 1;
					goFilterAndSort('gridbox2');
				}
			}
			
			function goFilterAndSort(grd){
				if (grd=="gridbox2"){
					txtTgl = document.getElementById('txtTgl').value;
					cmbDilayani = document.getElementById('cmbDilayani').value;
					lgkp.loadURL("pelayanankunjungan_utils.php?grd=tarik&saring=false&filter="+lgkp.getFilter()+"&sorting="+lgkp.getSorting()+"&page="+lgkp.getPage(),"","GET");
				}
			}
		
			lgkp = new DSGridObject("gridbox2");
			lgkp.setHeader("DATA KUNJUNGAN PASIEN");
			lgkp.setColHeader("NO,NO RM,NAMA,L/P,PENJAMIN,TEMPAT LAYANAN,ALAMAT");
			lgkp.setIDColHeader(",no_rm,nama,,,,");
			lgkp.setColWidth("50,80,300,40,200,180,300");
			lgkp.setCellAlign("center,center,left,center,center,center,center");
			lgkp.setCellHeight(20);
			lgkp.setImgPath("../icon");
			lgkp.setIDPaging("paging");
			//lgkp.attachEvent("onRowClick","ambilDataPasien");
			//lgkp.attachEvent("onRowDblClick","detail");
			//lgkp.onLoaded(ambilDataPasien);
			lgkp.baseURL("pelayanankunjungan_utils.php?grd=tarik&saring=false");
			lgkp.Init();
	</script>
</html>
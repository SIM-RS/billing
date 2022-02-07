<?php
	//session_start();
	/*$hostname_conn = "localhost";
	//$hostname_conn = "192.168.1.2";
	$database_conn = "billing";
	$username_conn = "root";
	$password_conn = "rsudsda";
	$password_conn = "root";
	
	$konek=mysql_connect($hostname_conn,$username_conn,$password_conn);
	mysql_select_db($database_conn,$konek);*/
	include "../sesi.php";
	include '../koneksi/konek.php';
	$idunit=$_REQUEST['idunit'];
	if ($idunit=="") $idunit="2";
	
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
        <script type="text/JavaScript" language="JavaScript" src="theme/js/dsgrid.js"></script>
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
                        <td width="100%" height="96"><?php include "header.php";?></td>
                    </tr>
                    <tr>
                        <td width="100%" valign="top">
							<div align="center">
								<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#008484" class="hd2">
									<tr>
									<?php
											$sql = mysql_query("SELECT id, nama FROM b_ms_unit WHERE id='".$idunit."'");
											$rw = mysql_fetch_array($sql);
									?>
										<td height="32" style="padding-left:20px; text-align:left; font-size:22px; text-transform:uppercase; color:#0000FF; font-weight:bold;">
											<input id="txtTgl" name="txtTgl" type="hidden" value="<?php echo $_REQUEST['txtTgl'];?>" />
											<input id="idunit" name="idunit" type="hidden" value="<?php echo $idunit;?>" />
											<input id="cmbDilayani" name="cmbDilayani" type="hidden" value="<?php echo $_REQUEST['cmbDilayani'];?>" />
											Tempat Layanan : <select id="cmbTmpLay" class="txtinput" lang="" onchange="goFilterAndSort('gridbox');">
                                            <?
												$query1 = "SELECT * FROM b_ms_unit WHERE inap = 0 AND aktif = 1 AND LEVEL = 2 AND parent_id NOT IN (76,80) AND id NOT IN (122,126,128,130)";
												$execQuery1 = mysql_query($query1);
												while($dquery1 = mysql_fetch_array($execQuery1))
												{
													?>
                                                    	<option value="<? echo $dquery1['id'];?>"><? echo $dquery1['nama'];?></option>
                                                    <?
												}
											?>
                                        </select>
										<?php //echo $rw['nama']?>
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
															<div id="gridbox" style="width:1250px; height:590px; background-color:white; overflow:hidden;"></div>
															<div id="paging" style="width:1250px;display:none"></div>
														</td>
													</tr>
													<tr>
														<td>&nbsp;</td>
													</tr>
												</table>
											</fieldset>										
										</td>
									</tr>
								</table>
							</div>
						</td>
                    </tr>
					<tr>
                        <td width="100%" height="32" class="hd2" align="center">
							<!--div align="center">
								<font face="Georgia, Times New Roman, Times, serif" color="#0000FF">
									<b>
										<marquee width="70%" scrollamount="3" behavior="alternate">
											<?=$namaRS?>
										</marquee>
									</b>
								</font>
							</div-->
							<marquee align="absmiddle" direction="left" height="30" scrollamount="2" width="99%" class="mar" onfinish="">
							<?php
								$sM = "SELECT keterangan FROM b_running_text
										ORDER BY urutan";
								$rM = mysql_query($sM);
								while($wM = mysql_fetch_array($rM)){
								echo $wM['keterangan']."&nbsp;&nbsp;&nbsp;";
								}
							?>
							</marquee>
						</td>
                    </tr>
                </table>
            </div>
            <!-- End ImageReady Slices -->
        </body>
	<script>
			/*this.grid = document.getElementById('gridbox');
			this.grid.page=1;
			this.grid.maxpage=1;	
			*/
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
				/* if (document.getElementById('gridbox').page < document.getElementById('gridbox').maxpage){
					document.getElementById('gridbox').page = document.getElementById('gridbox').page + 1;
					goFilterAndSort('gridbox');
				}else{ */
					document.getElementById('gridbox').page = 1;
					goFilterAndSort('gridbox');
				//}
			}
			
			function goFilterAndSort(grd){
				if (grd=="gridbox"){
					cmbTmpLay = document.getElementById('idunit').value;
					antrian.loadURL("pelayanankunjungan_utils.php?grd=true&saring=true&idunit="+document.getElementById("cmbTmpLay").value+"&filter="+antrian.getFilter()+"&sorting="+antrian.getSorting()+"&page="+antrian.getPage(),"","GET");
				}
			}
		
			antrian = new DSGridObject("gridbox");
			antrian.setHeader("DATA KUNJUNGAN PASIEN");
			antrian.setColHeader("NO,NO RESEP,NO RM,NAMA,TEMPAT LAYANAN,CARA BAYAR,KEPEMILIKAN,UNIT");
			antrian.setIDColHeader(",no_rm,,nama,,,,");
			antrian.setColWidth("30,100,100,200,150,100,150,100");
			antrian.setCellAlign("center,center,center,left,center,center,center,center");
			antrian.setCellHeight(30);
			antrian.setImgPath("../icon");
			antrian.setIDPaging("paging");
			//antrian.attachEvent("onRowClick","ambilDataPasien");
			//antrian.attachEvent("onRowDblClick","detail");
			//antrian.onLoaded(ambilDataPasien);
			//alert("pelayanankunjungan_utils.php?grd=true&saring=true&tmpLay="+document.getElementById('idunit').value);
			//antrian.baseURL("pelayanankunjungan_utils.php?grd=true&saring=true&idunit=<?php echo $idunit; ?>");
			antrian.baseURL("pelayanankunjungan_utils.php?grd=true&saring=true&idunit="+document.getElementById("cmbTmpLay").value);
			antrian.Init();
	</script>
</html>
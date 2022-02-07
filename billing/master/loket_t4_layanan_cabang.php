<?php
session_start();
include("../sesi.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!-- end untuk ajax-->
        <title>Tempat Layanan</title>
    </head>
    <body>
        <div align="center">
            <?php
			include("../koneksi/konek.php");
            include("../header1.php");
            ?>
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM TEMPAT LAYANAN</td>
                </tr>
            </table>
            <table width="1000" border="0" cellspacing="0" cellpadding="2" align="center" class="tabel">
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="10%" align="right">Cabang</td>
                    <td width="45%">
                        <select name="cabang" id="cabang" class="txtinput" onchange="changeCabang(this.value);">
							<?php 
								$sCabang = "select id, nama from b_ms_cabang where aktif = 1";
								$qCabang = mysql_query($sCabang);
								if(mysql_num_rows($qCabang) > 0){
									while($dCab = mysql_fetch_array($qCabang)){
										$select = '';
										if($dCab['id'] == $cabang){
											$select = "selected";
										}
										echo "<option value='".$dCab['id']."' {$select}>".$dCab['nama']."</option>";
									}
								} else {
									echo "<option value='1'>Rumah Sakit</option>";
								}
							?>
						</select>
                    </td>
                    <td width="20%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
                </tr>
				<tr>
                    <td width="5%">&nbsp;</td>
                    <td width="10%" align="right">Loket</td>
                    <td width="45%">
                        <select id="txtLoket" name="txtLoket" onchange="setCakupan(this.value)" class="txtinput">
                        <?php 
						$sql="SELECT * FROM b_ms_unit mu WHERE mu.kategori=1 AND mu.level=2 AND mu.aktif=1";
						$rs=mysql_query($sql);
						while ($rw=mysql_fetch_array($rs)){
						?>
                            <option value="<?php echo $rw["id"]; ?>"><?php echo $rw["nama"]; ?></option>
                    	<?php 
						}
						?>
                        </select>
                    </td>
                    <td width="20%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
                </tr>
                
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left" colspan="3">
                        <div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
<!--table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr>
                    <td height="30">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;"/></td>
                    <td></td>
                    <td align="right">
                        <a href="../index.php">
                            <input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;"/>
                        </a>&nbsp;
                    </td>
                </tr>
            </table-->
        </div>
    </body>
    <script type="text/javascript">
        function update(obj){
			//alert(obj.value+' - '+obj.checked);
			a.loadURL("loket_t4_layanan_utils.php?act=update&idloket="+document.getElementById("txtLoket").value+"&idunit="+obj.value+"&ischecked="+obj.checked,"","GET");
        }
        
        function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }

        function setCakupan(val){
			a.loadURL("loket_t4_layanan_utils.php?idloket="+document.getElementById("txtLoket").value,"","GET");
        }

        function goFilterAndSort(grd){
            //alert("loket_t4_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("loket_t4_layanan_utils.php?idloket="+document.getElementById("txtLoket").value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
        }
		
		function changeCabang(cab){
			isiCombo('loketCabang',cab,'txtLoket','txtLoket',lgrid);
		}
		
		function lgrid(){
			var cab = document.getElementById('cabang').value;
			a.loadURL("loket_t4_layanan_utils.php?idloket="+document.getElementById("txtLoket").value+"&cabang="+cab,"","GET");
		}
		
		isiCombo('loketCabang',document.getElementById('cabang').value,'','txtLoket',lgrid);
        var a=new DSGridObject("gridbox");
        a.setHeader("UNIT PELAYANAN");
        a.setColHeader(",KODE,NAMA,JENIS LAYANAN,STATUS INAP");
        a.setIDColHeader(",kode,nama,,");
        a.setColWidth("50,100,300,250,100");
        a.setCellAlign("center,center,left,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        //a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("loket_t4_layanan_utils.php?idloket="+document.getElementById("txtLoket").value);
        a.Init();
    </script>
</html>

<?php 
include('../koneksi/konek.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<table width="915" align="center" cellpadding="0" cellspacing="0" class="tbl">
<tr>
	<td align="center" width="50%">
		<table width="100%" align="center" cellpadding="0" cellspacing="0">
		<!--tr>
			<td>
			<fieldset>
			<table>
			<tr>
				<td>Group Akses</td>
				<td>
				<select id="group" name="group" class="txtinput" onchange="cmb(this.value)">
				<?php 
					$sql="SELECT id,nama FROM b_ms_group WHERE aktif=1 ORDER BY nama";
					$rs=mysql_query($sql);
					while($rw=mysql_fetch_array($rs)){
				?>
					<option value="<?php echo $rw[0] ?>"><?php echo $rw[1] ?></option>
				<?php } ?>
				</select>
				</td>
			</tr>
			</table>	
			</fieldset>
			</td>
		</tr-->
		<tr>
		<td>
			<fieldset>
			<table width="100%" align="center">
			<tr>
				<td align="right">
                	<fieldset>
					<input type="hidden" id="idPeg" name="idPeg" />
                    <input type="hidden" id="idGrdClick" name="idGrdClick" />
					<img src="../icon/add16.gif" style="cursor:pointer" onclick="popup1()" title="add pegawai" />&nbsp;&nbsp;
					<img src="../icon/edit.gif" style="cursor:pointer" onclick="editPop()" title="edit pegawai" />&nbsp;&nbsp;
					<img src="../icon/hapus.gif" style="cursor:pointer" onclick="del()" title="hapus pegawai" />
                    </fieldset>
				</td>
				<td align="right">&nbsp;</td>
				<td align="left">
                    <fieldset>
                    <table>
                    <tr>
                        <td>Group Akses</td>
                        <td>
                        <select id="group" name="group" class="txtinput" onchange="cmb(this.value)">
                        <?php 
                            $sql="SELECT id,nama FROM b_ms_group WHERE aktif=1 ORDER BY nama";
                            $rs=mysql_query($sql);
                            while($rw=mysql_fetch_array($rs)){
                        ?>
                            <option value="<?php echo $rw[0] ?>"><?php echo $rw[1] ?></option>
                        <?php } ?>
                        </select>
                        </td>
                    </tr>
                    </table>	
                    </fieldset>
                </td>
			</tr>
			<tr>
				<td align="center">
					<fieldset>
						<table width="300" align="center">
						<tr>
							<td>
								<input type="hidden" id="tampung" name="tampung" />
								
								<div id="grid1" style="width:420px; height:400px;background-color:white;"></div>
								<div id="paging1" style=" width:420px;display:none"></div>
							</td>
						</tr>
						</table>
					</fieldset>
				</td>
				<td align="center">
					<button type="button" id="kanan" name="kanan" style="cursor:pointer" onclick="kanan()">>></button><br/><br/>
					<button type="button" id="kiri" name="kiri" style="cursor:pointer" onclick="kiri()" ><<</button>
				</td>
				<td align="center">
					<fieldset>
						<table width="300" align="center">
						<tr>
							<td>
								<div id="grid2" style="width:420px; height:400px;background-color:white;"></div>
								<div id="paging2" style=" width:420px; display:none"></div>
							</td>
						</tr>
						</table>
					</fieldset>
				</td>
			</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td height="20"></td>
</tr>
</table>
</body>
</html>
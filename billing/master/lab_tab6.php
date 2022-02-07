<?php
include("../koneksi/konek.php");
?>
 <table width="900" border="0" cellspacing="1" cellpadding="0" align="center">
 <tr>
   <td width="5%">&nbsp;</td>
   <td width="40%">&nbsp;</td>
   <td width="10%">&nbsp;</td>
   <td width="40%">&nbsp;</td>
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
   <td>
 <fieldset>
    <legend>Daftar Pemeriksaan Laborat</legend>
    <div id="grdtab6a" style="width:430px; height:380px; background-color:white; overflow:hidden;"></div><br />
    <div id="paging_grdtab6a" style="width:420px;"></div>
 </fieldset>
 </td>
<td align="center">         
    <input type="button" id="btnRight" value="" onclick="kelompokKanan()" class="tblRight"/>
    <br>
    <input type="button" id="btnLeft" value="" onclick="kelompokKiri()" class="tblLeft"/>
</td>
   <td>
<fieldset>
    <legend>Data Mapping Tindakan - Pemeriksaan Laborat</legend>
    <table>
    <tr>
        <td>
            Kelompok : <select id="kelompokLab" class="txtinput" onchange="fTind_Change(this);">
                <?php
					function getChild($parent_id, $separator = '-'){
						$sql = "SELECT l.id, l.nama_kelompok as nama, l.parent_id
							FROM b_ms_kelompok_tindakan_pemeriksaan_lab l 
							WHERE l.aktif = 1 AND l.parent_id = {$parent_id}
							ORDER BY l.id";
						$query = mysql_query($sql);
						if(mysql_num_rows($query) > 0){
							while($data = mysql_fetch_object($query)){
								echo "<option value='".$data->id."'>{$separator} ".$data->nama."</option>";
								getChild($data->id,$separator.'-');
							}
						}
					}
				
					$sql = "SELECT l.id, l.nama_kelompok as nama, l.parent_id
							FROM b_ms_kelompok_tindakan_pemeriksaan_lab l 
							WHERE l.aktif = 1 AND l.parent_id = 0
							ORDER BY l.id";
					$query = mysql_query($sql);
					while($data = mysql_fetch_object($query)){
						echo "<option value='".$data->id."'>".$data->nama."</option>";
						getChild($data->id);
					}				
				
                /* $sql="SELECT DISTINCT mt.id,mt.nama FROM b_ms_tindakan_unit mtu INNER JOIN b_ms_tindakan_kelas mtk ON mtu.ms_tindakan_kelas_id=mtk.id
INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id WHERE mtu.ms_unit_id=58 AND mt.aktif=1 ORDER BY mt.nama";
                $rs=mysql_query($sql);
                while($rw=mysql_fetch_array($rs)){
                    ?>
                    <option value="<?php echo $rw['id'];?>"><?php echo $rw['nama'];?></option>
                    <?php
                } */
                ?>
            </select>
        </td>
    </tr>
    </table>
    <div id="grdtab6b" style="width:430px; height:350px; background-color:white; overflow:hidden;"></div><br />
    <div id="paging_grdtab6b" style="width:420px;"></div>
    
    </fieldset>
 </td>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
 </tr>
 </table>
<table width="100%" height="100%" border="0" cellspacing="1" cellpadding="0" align="center" class="tabel">
         <tr>
           <td>&nbsp;</td>
           <td>
		 <fieldset>
			<legend>Daftar Tindakan</legend>
			<div id="gridbox" style="width:400px; height:340px; background-color:white; overflow:hidden;"></div>
			<div id="paging" style="width:410px;"></div>
            </fieldset>
	     </td>
		<td align="center">
			<input type="button" id="btnRight" value="" onclick="pindahKanan()" class="tblRight"/>
			<br>
			<input type="button" id="btnLeft" value="" onclick="pindahKiri()" class="tblLeft"/>
		</td>
           <td>
		<fieldset>
			<legend>Daftar Tindakan Tiap Tempat Pelayanan</legend>
			<table width="396">
			<tr>
			  <td width="59">Jenis</td>
			  <td width="325">:
                <select name="select" class="txtinput" id="cmbJnsLay" onchange="isiCombo('TmpLayanan',this.value,'','cmbUnit',ubahUnit)">
                  <?php
						/*$sql="SELECT distinct m.id,m.nama,m.inap FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b 
							where ms_pegawai_id=".$_SESSION['userId'].") as t1
							inner join b_ms_unit u on t1.unit_id=u.id
							inner join b_ms_unit m on u.parent_id=m.id order by nama";*/
						include("../koneksi/konek.php");
						$sql="SELECT distinct m.id,m.nama,m.inap FROM b_ms_unit m WHERE level=1 AND kategori=2 AND aktif=1 order by nama";
						$rs=mysql_query($sql);
						while($rw=mysql_fetch_array($rs)){
							?>
				  <option value="<?php echo $rw['id'];?>" label="<?php /*echo $rw['inap'];*/?>" title="<?php echo $rw['id'];?>"><?php echo $rw['nama'];?></option>
                  <?php
						}
						?>
                </select></td>
			  </tr>
			<tr>
				<td>Tempat </td>
				<td>:
					<select id="cmbUnit" class="txtinput" lang="" onchange="ubahUnit();">
			    </select>				</td>
			  </tr>
			</table>
			<!--select id="cmbUnit" class="txtinput" onchange="ubahUnit();">
				<?php
				/*
				$Qunit="SELECT id,nama FROM b_ms_unit where level=2";
				$RsUnit=mysql_query($Qunit);
				while($RwUnit=mysql_fetch_array($RsUnit)){
					?>
					<option value="<?php echo $RwUnit['id']?>"><?php echo $RwUnit['nama']?></option>
					<?php
				}
				*/
				?>
			</select-->
			
			<div id="gridbox2" style="width:400px; height:300px; background-color:white; overflow:hidden;"></div>
			<div id="paging2" style="width:410px;"></div>
			
            </fieldset>
	     </td>
           <td>&nbsp;</td>
        </tr>
	</table>
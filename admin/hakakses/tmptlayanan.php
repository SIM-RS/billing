<div id="Table_01">
<table width="925" border="0" cellpadding="0" cellspacing="0" align="center">
   <tr>
   	<td>&nbsp;
	</td>
   </tr>
   <tr>
      <td style="text-transform:uppercase; font-weight:bold; font-size:18px" align="center"><?php
		include("../inc/koneksi.php");
		$sql="select * from ms_modul where id=".$_REQUEST['modul'];
		$kueri=mysql_query($sql);
		$modl=mysql_fetch_array($kueri);
		mysql_free_result($kueri);
		mysql_close($conn);
		?>
		 <span><?php echo $modl['nama']; ?></span></td>
   </tr>
   <tr>
      <td>&nbsp;</td>
   </tr>
   <tr>
      <td style="padding-left:80px;">&nbsp;Nama Pengguna:&nbsp;&nbsp;&nbsp;<input id="txtIdPeg" type="hidden" value="<?=$_REQUEST['idPeg'];?>" /><input id="txtnm" type="text" size="50" class="txtinput" readonly="readonly" value="<?=$_REQUEST['namax'];?>"><span id="spanSuk"></span>
      </td>
   </tr>
   <tr>
      <td>&nbsp;</td>
   </tr>
   <tr>
      <td align="center">&nbsp;
	 
	 <div id="grid5" style="width:750px; height:375px; background-color:white;"></div><br />
	
      </td>
   </tr>
   <tr>
      <td>&nbsp;</td>
   </tr>
   <!--tr>
   		<td align="center">&nbsp;<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="masuk()" class="tblTambah"/></td>
   </tr-->
</table>
</div>
<script>

/*gd1 = new extGrid("gridboxtab5");        
gd1.setTitle(".: Daftar Grup :.");
gd1.setHeader("&nbsp,No,Kode,Nama,Keterangan,Status");
gd1.setColId(",NO,KODE,NAMA,KET,STATUS");
gd1.setColType("string,string,string,string,string,string");
gd1.setColWidth(",30,100,220,260,70");
gd1.setWidthHeight(700,400);
gd1.setClickEvent(ambilDatatab5);
gd1.baseURL("extgridgrp.php?modul=<?php echo $modul_id ?>&kode=true&saring=true&sharing=");                                    
gd1.init();*/

tab5=new extGrid("grid5");
tab5.setTitle("DATA HAK AKSES PEGAWAI");
tab5.setHeader("NO,,KODE,TIPE,NAMA TEMPAT LAYANAN");
tab5.setColId("NO,PIL,UNIT_KODE,TIPE,UNIT_NAME");
tab5.setColType("string,string,string,string,string");
tab5.setColWidth("50,60,150,150,300");
tab5.setColAlign("center,center,left,left,left");
tab5.setWidthHeight(820,395);
tab5.setClickEvent(ambilDatatab5);
tab5.baseURL("tmptlayanan_utils.php?grdtab5=true&idPeg="+document.getElementById('txtIdPeg').value);
tab5.init();

/*gdy = new extGrid("gridy");        
gdy.setTitle(".: Daftar Pegawai :.");
gdy.setHeader("&nbsp;,No,User Name,Nama,Setting");
gdy.setColId("CEK,NO,user_name,NAMA,SETTING");
gdy.setColType("string,string,string,string,string");
gdy.setColWidth("30,40,80,150,105");
gdy.setColAlign("center,center,left,left,center");
gdy.setWidthHeight(420,395);
gdy.setClickEvent(ambilDatatab5);
gdy.baseURL("group_petugasUtils.php");                
gdy.init();*/

function ambilDatatab5(){
var a = tab5.getSelRowId('idext').split('|'); //alert(a[0]);
}

function pilih(chk,id)
{
	if(chk==true)
	{
		var act='tambah';
	}
	else
	{
		var act='hapus'
	}
	tab5.reload("tmptlayanan_utils.php?grdtab5=true&idPeg="+document.getElementById('txtIdPeg').value+"&act="+act+"&id="+id);
}
</script>
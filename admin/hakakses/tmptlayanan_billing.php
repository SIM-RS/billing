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
   	<td>&nbsp;
	</td>
   </tr>
   <tr>
      <td style="padding-left:80px;">&nbsp;Nama Pengguna:&nbsp;&nbsp;&nbsp;<input id="txtIdPeg2" type="hidden" value="<?=$_REQUEST['idPeg'];?>" /><input id="txtnm2" type="text" size="50" class="txtinput" readonly="readonly" value="<?=$_REQUEST['namax'];?>"><span id="spanSuk"></span>
      </td>
   </tr>
   <tr>
      <td align="center" height="40"><span style="padding:3px; background:#009900; font:bold 12px Verdana, Arial, Helvetica, sans-serif; color:#FFFFFF; display:none;" id="resultx"></span></td>
   </tr>
   <tr>
      <td align="center">&nbsp;
	 
	 <div id="grid6" style="width:750px; height:375px; background-color:white;"></div><br />
	
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

tab6=new extGrid("grid6");
tab6.setTitle("DATA HAK AKSES PEGAWAI");
tab6.setHeader("NO,,KODE,NAMA TEMPAT LAYANAN");
tab6.setColId("NO,pil,kode,nama");
tab6.setColType("string,string,string,string");
tab6.setColWidth("50,100,200,400");
tab6.setColAlign("center,center,left,left");
tab6.setWidthHeight(820,395);
tab6.setClickEvent(ambilDatatab6);
tab6.baseURL("tmptlayanan_billing_utils.php?grdtab5=true&idPeg="+document.getElementById('txtIdPeg2').value);
tab6.init();

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

function ambilDatatab6(){
var a = tab6.getSelRowId('idext').split('|'); //alert(a[0]);
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
	//tab6.loadURL("tmptlayanan_billing_utils.php?grdtab6=true&idPeg="+document.getElementById('txtIdPeg2').value+"&act="+act+"&id="+id);
	var url = "tmptlayanan_set.php?grdtab6=true&idPeg="+document.getElementById('txtIdPeg2').value+"&act="+act+"&id="+id;
	jQuery.get(url,function(data){
	jQuery("#resultx").html(data);
	jQuery("#resultx").fadeIn(300);
	jQuery("#resultx").fadeOut(300);
	})
}
</script>
<?php
include("../sesi.php");
?><img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="display:none;" />

<table>
	<tr>
    	<td colspan="5"><img alt="close" src="../icon/x.png" width="32" onClick="closePF()" style="float:right; cursor: pointer" /></td>
    </tr>
	<tr>
        <td colspan="5" align="center" style="font-size:16px; font-weight:bold; text-decoration:underline">FORM MASTER DATA</td>
    </tr>
    <tr>
    	<td>No Urut</td>
    	<td><label for="txt_urut_fisik"></label>
   	    <input type="text" name="txt_urut_fisik" id="txt_urut_fisik" /></td>
    </tr>
    <tr>
    	<!-- <td>Flag</td> -->
    	<td><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" tabindex="3" value="<?php echo $flag; ?>"/></td>
    </tr>
    <tr>
      <td>Nama</td>
      <td><label for="txt_nama_fsik"></label>
      <input type="text" name="txt_nama_fisik" id="txt_nama_fisik" /></td>
    </tr>
    <tr> 
        <td colspan="5" align="center">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="5" align="center">
        <input type="hidden" id="id_periksa_fisik" name="id_periksa_fisik" />
        <input type="hidden" id="tipe_fisik" name="tipe_fisik" />
        <input type="hidden" id="filter_fisik" name="filter_fisik" />
                <button type="button" id="btnSimpanPF" name="btnSimpanPF" value="tambah" onClick="savePF(this.value)" style="cursor:pointer">
                    <img src="../icon/edit_add.png" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Add</span>
                </button>
                <button type="button" id="btnDeletePF" name="btnDeletePF" onClick="deletePF()" style="cursor:pointer">
                    <img src="../icon/del.gif" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Delete</span>
                </button>
                <button type="button" id="btnBatalPF" name="btnBatalPF" onClick="batalPF()" style="cursor:pointer">
                    <img src="../icon/back.png" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Cancel</span>
                </button></td>
    </tr>
	<tr>
    	<td colspan="5" align="center"><div id="gbPF" style="width:450px; height:150px; padding-bottom:20px; background-color:white;"></div>
                <div id="pgPF" style="width:450px;"></div></td>
    </tr>
</table>


<script>
gPF=new DSGridObject("gbPF");
gPF.setHeader("DAFTAR MASTER DATA");
gPF.setColHeader("NO,NO URUT,NAMA");
gPF.setIDColHeader(",,");
gPF.setColWidth("30,50,150");
gPF.setCellAlign("center,center,left");
gPF.setCellHeight(20);
gPF.setImgPath("../icon");
gPF.setIDPaging("pgPF");
gPF.attachEvent("onRowClick","ambilPF");
gPF.baseURL("pemeriksaan_fisik_util.php?idpasien=0");
gPF.Init();


</script>
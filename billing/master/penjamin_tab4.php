<?php
//session_start();
session_start();
include("../sesi.php");
include_once("../koneksi/konek.php");
?>
<div id="divPaket" style="display:block;position:relative;">
           <div id="divFormPaket">
               <table border="0" width="100%">
                  <tr>
                     <td width="25%"></td>
                     <td align="right"></td>
                     <td></td>
                     <td width="25%"></td>
                  </tr>
                  <tr>
                     <td></td>
                     <td align="right">Penjamin : </td>
                     <td align="left">
                        <select id="cmbKsoPaket" class="txtinput" onchange="document.getElementById('cmbKsoDataPaket').value=this.value;loadDataPaket();"></select>
                     </td>
                     <td></td>
                  </tr>
                  <tr>
                     <td width="25%"></td>
                     <td align="right">
                        Nama Paket :
                     </td>
                     <td>
                        <input type="hidden" id="txtIdPaket" name="txtIdPaket" class="txtinput"/>
                        <input type="text" id="txtPaket" name="txtPaket" class="txtinput"/>
                     </td>
                     <td width="25%"></td>
                  </tr>
                   <tr>
                     <td width="25%"></td>
                     <td align="right">
                        Nilai Jaminan :
                     </td>
                     <td>
                        <input type="text" id="txtNilaiPaket" name="txtNilaiPaket" class="txtinput"/>
                     </td>
                     <td width="25%"></td>
                  </tr>
                    <tr>
                     <td width="25%"></td>
                     <td align="right">
                        Instalasi :
                     </td>
                     <td>
                        <select id="cmbInstalPaket" name="cmbInstalPaket" class="txtinput">
                           <option value="0">Bebas</option>
                           <option value="1">Rawat Inap</option>
                           <option value="2">Non Rawat Inap</option>
                        </select>
                     </td>
                     <td width="25%"></td>
                  </tr>                    
                    <tr>
                     <td width="25%"></td>
                     <td align="right">
                        Status Paket :
                     </td>
                     <td>
                        <select id="cmbStatusPaket" name="cmbStatusPaket" class="txtinput">
                           <option value="0">Global</option>
                           <option value="1">Per Item Paket</option>
                        </select>
                     </td>
                     <td width="25%"></td>
                  </tr>
                    <tr>
                     <td width="25%"></td>
                     <td align="right">
                        Frekuensi :
                     </td>
                     <td>
                        <select id="cmbFrekPaket" name="cmbFrekPaket" class="txtinput">
                           <option value="0">Harian</option>
                           <option value="1">Bebas</option>
                        </select>
                     </td>
                     <td width="25%"></td>
                  </tr>
                  <!-- <tr>
                     <td width="25%"></td>
                     <td align="right">
                        Flag :
                     </td>
                     <td> -->
                     <input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="10" tabindex="3" value="<?php echo $flag; ?>"/>
                     <!-- </td>
                     <td width="25%"></td>
                  </tr -->
                   <tr>
                     <td width="25%"></td>
                     <td align="right"></td>
                     <td>
                        <input type="button" id="btnTambahPaket" name="btnTambahPaket" class="tblTambah" value="Tambah" onclick="simpanPaket(this.value);"/>
                        <input type="button" id="btnHapusPaket" name="btnHapusPaket" class="tblHapus" value="Hapus" onclick="hapusPaket()"/>
                        <input type="button" id="btnBatalPaket" name="btnBatalPaket" class="tblBatal" value="Batal" onclick="batalPaket()"/>
                     </td>
                     <td width="25%"></td>
                  </tr>
                   </table>
               </div>
               <div id="divDataPaket">
            <fieldset style="width:400px;"><legend>:Data Paket:</legend>
	     <table width="650" border="0">
	    <tr>
	    <td align="left">
               <select id="cmbKsoDataPaket" class="txtinput" style="display:none;" onchange="loadDataPaket();document.getElementById('cmbKsoPaket').value=this.value;"></select>
	    </td>
	    <td align="right">
	       <input type="button" id="btnSetDetailPaket"  class="tblBtn" value="Set Detail paket" lang="tutup" onclick="hide(this.lang);"/>
	    </td>
	   </tr>
	      </table>
	      <div id="gridbox6" style="width:650px; height:150px; background-color:white; "></div>
		<div id="paging6" style="width:600px;margin-top:20px;"></div>
            </fieldset>
           </div>
              
</div>
<div id="divDetilPaket" style="display:none;">
   <table>
      <tr>
         <td>
      <div id="gridbox7" style="width:400px; height:180px; vertical-align:bottom; "></div>
	<div id="paging7" style="width:410px;margin-top:20px;"></div>
      </td>
         <td><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="40" tabindex="3" value="<?php echo $flag; ?>"/>
            <input type="button" id="btnRightPaket" value="" onclick="pindahKananPaket()" class="tblRight"/>
        <br>
         <input type="button" id="btnLeftPaket" value="" onclick="pindahKiriPaket()" class="tblLeft"/>
         </td>
         <td>
             <div id="gridbox8" style="width:400px; height:180px; vertical-align:bottom;"></div>
	<div id="paging8" style="width:410px;margin-top:20px;"></div>
         </td>
         </tr>
      </table>
</div>
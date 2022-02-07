<style>
.tombol{
  background:skyblue;
  color:black;
  border-top:0;
  border-left:0;
  border-right:0;
  border-bottom:5px solid #2A80B9;
  padding:10px 20px;
  text-decoration:none;
  font-family:sans-serif;
  font-size:11pt;
}
</style>
<div id="tombol1">
                        <input id="kartu" name="kartu" type="button" value="Cetak Kartu" onClick="kartu()" class="tombol"/>
                        <input id="kartuB" name="kartuB" type="button" value="Cetak Barcode" onClick="kartuB()" />
                        <input id="cetak" name="cetak" type="button" value="Cetak Kwitansi" onClick="cetak()" />
                        <input id="cetakForm" name="cetakForm" type="button" value="Form Verifikasi" disabled="disabled" onClick="cetakForm()" />
                        <input id="spInap" name="spInap" type="button" value="SP INAP" disabled="disabled" onClick="spi()" style="display:none" />
                        <input name="UpdStatusPx" id="UpdStatusPx" type="button" value="UBAH STATUS Px" style="display:none" disabled onClick="PopUpdtStatus();" />
                        <input name="cetakDaftar" id="cetakDaftar" type="button" value="Bukti Daftar" onClick="cetakDaftar();" />
				    <input id="skpJamkesda" name="skpJamkesda" type="button" value="SKP JAMKESDA" disabled="disabled" onClick="skp()" style="display:none" />
				    <input id="skpJamkesdaKmr" name="skpJamkesdaKmr" type="button" value="SKP JAMKESDA INAP" disabled="disabled" onClick="skp('kamar')" style="display:none" />
                    <input id="sjpJampersal" name="sjpJampersal" type="button" value="SJP JAMPERSAL" disabled="disabled" onClick="skp('jampersal')" />
                    <input id="sjpAskes" name="sjpAskes" type="button" value="SEP BPJS FULL" disabled="disabled" onClick="print_sjp(1)" /><input id="sjpAskes_isi" name="sjpAskes" type="button" value="SEP BPJS ISI" disabled="disabled" onClick="print_sjp(2)" />
					<input class="btnRegis" id="sjpBPJS" name="sjpBPJS" type="button" value="SJP BPJS FULL" disabled="disabled" onClick="print_sjp_bpjs(1)"  style="display:none"/>
					<input class="btnRegis" id="sjpBPJS_isi" name="sjpBPJS_isi" type="button" value="SJP BPJS ISI" disabled="disabled" onClick="print_sjp_bpjs(2)" style="display:none" />
                    <!--input id="KIUP" name="KIUP" type="button" value="Cetak KIUP" onClick="kiup()" /-->
                    <input id="LabelP" name="LabelP" type="button" value="Cetak Label" onClick="cetak_label()" />
                    <input id="cetak2" name="cetak2" type="button" value="Cetak Antrian" onClick="cetak2()" />
                    </div>

                    					<!-- <style>
					.button-group,
.button-group li{
  display: inline-block;
  *display: inline;
  zoom: 1;
}
.button-group{
  font-size: 0; /* Inline block elements gap - fix */
  margin: 0;
  padding: 0;
  background: rgba(0, 0, 0, .04);
  border-bottom: 1px solid rgba(0, 0, 0, .07);
  padding: 7px;
  border-radius: 7px; 
}
.button-group li{
  margin-right: -1px; /* Overlap each right button border */
}
.button-group .button{
  font-size: 13px; /* Set the font size, different from inherited 0 */
  border-radius: 0; 
}
.button-group .button:active{
  box-shadow: 0 0 1px rgba(0, 0, 0, .2) inset,
              5px 0 5px -3px rgba(0, 0, 0, .2) inset,
              -5px 0 5px -3px rgba(0, 0, 0, .2) inset;   
}
.button-group li:first-child .button{
  border-radius: 3px 0 0 3px;
}
.button-group li:first-child .button:active{
  box-shadow: 0 0 1px rgba(0, 0, 0, .2) inset,
              -5px 0 5px -3px rgba(0, 0, 0, .2) inset;
}
.button-group li:last-child .button{
  border-radius: 0 3px 3px 0;
}
.button-group li:last-child .button:active{
  box-shadow: 0 0 1px rgba(0, 0, 0, .2) inset,
              5px 0 5px -3px rgba(0, 0, 0, .2) inset;
}

</style> -->
<style type="text/css">
.button {
	-moz-box-shadow:inset 0px 0px 0px 0px #ffffff;
	-webkit-box-shadow:inset 0px 0px 0px 0px #ffffff;
	box-shadow:inset 0px 0px 0px 0px #ffffff;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #f9f9f9), color-stop(1, #e9e9e9) );
	background:-moz-linear-gradient( center top, #f9f9f9 5%, #e9e9e9 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f9f9f9', endColorstr='#e9e9e9');
	background-color:#f9f9f9;
	-webkit-border-top-left-radius:11px;
	-moz-border-radius-topleft:11px;
	border-top-left-radius:11px;
	-webkit-border-top-right-radius:11px;
	-moz-border-radius-topright:11px;
	border-top-right-radius:11px;
	-webkit-border-bottom-right-radius:11px;
	-moz-border-radius-bottomright:11px;
	border-bottom-right-radius:11px;
	-webkit-border-bottom-left-radius:11px;
	-moz-border-radius-bottomleft:11px;
	border-bottom-left-radius:11px;
	text-indent:0px;
	border:3px solid #dcdcdc;
	display:inline-block;
	color:#666666;
	font-family:Arial;
	font-size:12px;
	font-weight:bold;
	font-style:normal;

	line-height:21px;
	width:126px;
	text-decoration:none;
	text-align:center;
	text-shadow:0px 0px 0px #ffffff;
}
.button:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #e9e9e9), color-stop(1, #f9f9f9) );
	background:-moz-linear-gradient( center top, #e9e9e9 5%, #f9f9f9 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#e9e9e9', endColorstr='#f9f9f9');
	background-color:#e9e9e9;
}.button:active {
	position:relative;
	top:1px;
}</style>
/* This button was generated using CSSButtonGenerator.com */
                   <!-- <ul class="button-group">
				   <li><input id="kartu" name="kartu" type="button" value="Cetak Kartu" onClick="kartu()" class="button"/></li>
				   <li>  <input id="kartuB" name="kartuB" type="button" value="Cetak Barcode" onClick="kartuB()"  class="button"/></li>
				   <li>   <input id="cetak" name="cetak" type="button" value="Cetak Kwitansi" onClick="cetak()"  class="button"/></li>
				   <li>   <input id="cetakForm" name="cetakForm" type="button" value="Form Verifikasi" disabled="disabled" onClick="cetakForm()"  class="button"/></li>
				   <li>   <input id="spInap" name="spInap" type="button" value="SP INAP" disabled="disabled" onClick="spi()" style="display:none"  class="button" /></li>
				   <li>   <input name="UpdStatusPx" id="UpdStatusPx" type="button" value="UBAH STATUS Px" style="display:none" disabled onClick="PopUpdtStatus();" /></li>
                   <li>    <input name="cetakDaftar" id="cetakDaftar" type="button" value="Bukti Daftar" onClick="cetakDaftar();"  class="button"/></li>
				   </ul>  
				   <ul class="button-group">
				  
				  
				   <li>  <input id="skpJamkesda" name="skpJamkesda" type="button" value="SKP JAMKESDA" disabled="disabled" onClick="skp()" style="display:none"  class="button"/></li>
				   <li> <input id="skpJamkesdaKmr" name="skpJamkesdaKmr" type="button" value="SKP JAMKESDA INAP" disabled="disabled" onClick="skp('kamar')" style="display:none"  class="button"/></li>
                   <li> <input id="sjpJampersal" name="sjpJampersal" type="button" value="SJP JAMPERSAL" disabled="disabled" onClick="skp('jampersal')"  class="button"/></li>
                   <li> <input id="sjpAskes" name="sjpAskes" type="button" value="SEP BPJS FULL" disabled="disabled" onClick="print_sjp(1)"  class="button"/><input id="sjpAskes_isi" name="sjpAskes" type="button" value="SEP BPJS ISI" disabled="disabled" onClick="print_sjp(2)"  class="button"/></li>
				   <li><input class="btnRegis" id="sjpBPJS" name="sjpBPJS" type="button" value="SJP BPJS FULL" disabled="disabled" onClick="print_sjp_bpjs(1)"  style="display:none" class="button"/></li>
				   <li><input class="btnRegis" id="sjpBPJS_isi" name="sjpBPJS_isi" type="button" value="SJP BPJS ISI" disabled="disabled" onClick="print_sjp_bpjs(2)" style="display:none"  class="button"/></li>
                    input id="KIUP" name="KIUP" type="button" value="Cetak KIUP" onClick="kiup()" 
                    <li><input id="LabelP" name="LabelP" type="button" value="Cetak Label" onClick="cetak_label()"  class="button"/></li>
                    <li><input id="cetak2" name="cetak2" type="button" value="Cetak Antrian" onClick="cetak2()"  class="button"/></li>
                    </ul>  -->
                    <input id="kartu" name="kartu" type="button" value="Cetak Kartu" onClick="kartu()" class="button"/>
                        <input id="kartuB" name="kartuB" type="button" value="Cetak Barcode" onClick="kartuB()"  class="button"/>
                        <input id="cetak" name="cetak" type="button" value="Cetak Kwitansi" onClick="cetak()"  class="button"/>
                        <input id="cetakForm" name="cetakForm" type="button" value="Form Verifikasi" disabled="disabled" onClick="cetakForm()"  class="button"/>
                        <input id="spInap" name="spInap" type="button" value="SP INAP" disabled="disabled" onClick="spi()" style="display:none"  class="button" />
                        <input name="UpdStatusPx" id="UpdStatusPx" type="button" value="UBAH STATUS Px" style="display:none" disabled onClick="PopUpdtStatus();" />
                        <input name="cetakDaftar" id="cetakDaftar" type="button" value="Bukti Daftar" onClick="cetakDaftar();"  class="button"/>
				    <input id="skpJamkesda" name="skpJamkesda" type="button" value="SKP JAMKESDA" disabled="disabled" onClick="skp()" style="display:none"  class="button"/>
				    <input id="skpJamkesdaKmr" name="skpJamkesdaKmr" type="button" value="SKP JAMKESDA INAP" disabled="disabled" onClick="skp('kamar')" style="display:none"  class="button"/>
                    <input id="sjpJampersal" name="sjpJampersal" type="button" value="SJP JAMPERSAL" disabled="disabled" onClick="skp('jampersal')"  class="button"/>
                    <input id="sjpAskes" name="sjpAskes" type="button" value="SEP BPJS FULL" disabled="disabled" onClick="print_sjp(1)"  class="button"/><input id="sjpAskes_isi" name="sjpAskes" type="button" value="SEP BPJS ISI" disabled="disabled" onClick="print_sjp(2)"  class="button"/>
					<input class="btnRegis" id="sjpBPJS" name="sjpBPJS" type="button" value="SJP BPJS FULL" disabled="disabled" onClick="print_sjp_bpjs(1)"  style="display:none" class="button"/>
					<input class="btnRegis" id="sjpBPJS_isi" name="sjpBPJS_isi" type="button" value="SJP BPJS ISI" disabled="disabled" onClick="print_sjp_bpjs(2)" style="display:none"  class="button"/>
                    <!--input id="KIUP" name="KIUP" type="button" value="Cetak KIUP" onClick="kiup()" /-->
                    <input id="LabelP" name="LabelP" type="button" value="Cetak Label" onClick="cetak_label()"  class="button"/>
                    <input id="cetak2" name="cetak2" type="button" value="Cetak Antrian" onClick="cetak2()"  class="button"/>
<div id="divListKonsul" style="display:none;width:900px" class="popup">
    <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
    <fieldset><legend id="lgnJudul"></legend>
        <table border=0>
            <tr>
                <td colspan="2" align="right"><button type="button" onclick="cetakHasil()" style="cursor:pointer;">Cetak</button></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" id="konsul_pelayanan_id" name="konsul_pelayanan_id" />
                    <div id="gbListKonsul" style="width:850px; height:250px; padding-bottom:10px; background-color:white;"></div>
                    <br />
                    <div id="pgListKonsul" style="width:850px;"></div>                            </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
    </fieldset>
</div>            
<div id="divListKonsulRad" style="display:none;width:900px" class="popup">
    <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
    <fieldset><legend id="lgnJudul"></legend>
        <table border=0>
            <tr>
                <td colspan="2" align="right"><button type="button" onclick="cetakHasilRad()" style="cursor:pointer;">Cetak</button></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" id="konsul_rad_pelayanan_id" name="konsul_rad_pelayanan_id" />
                    <input type="hidden" id="konsul_rad_hasil_id" name="konsul_rad_hasil_id" />
                    <div id="gbListKonsulRad" style="width:850px; height:250px; padding-bottom:10px; background-color:white;"></div>
                    <br />
                    <div id="pgListKonsulRad" style="width:850px;"></div></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
    </fieldset>
</div>
<script>
function viewListKonsul(x){
	if(x=='60'){
		document.getElementById('konsul_pelayanan_id').value=x;
		lkr.loadURL("hasil_pemeriksaan/view_hasil_utils.php?grdListKonsulRad=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit+"&UnitKonsul="+x,"","GET");
		new Popup('divListKonsulRad',null,{modal:true,position:'center',duration:1});
		document.getElementById('divListKonsulRad').popup.show();
	} else if(x == 'history'){
		window.open('hasil_pemeriksaan/history_hasillab.php?idKunj='+getIdKunj,'_blank');	
	} else{
		document.getElementById('konsul_pelayanan_id').value=x;
		lk.loadURL("hasil_pemeriksaan/view_hasil_utils.php?grdListKonsul=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit+"&UnitKonsul="+x,"","GET");
		new Popup('divListKonsul',null,{modal:true,position:'center',duration:1});
		document.getElementById('divListKonsul').popup.show();
	}
}

function cetakHasil(){
	var sisip=lk.getRowId(lk.getSelRow()).split("|");
	if(sisip[1]==57){
		window.open('hasil_pemeriksaan/hasil_laborat_all.php?idKunj='+getIdKunj+'&idPel='+sisip[0],'_blank');	
	}
	else if(sisip[1]==60){
		window.open('hasil_pemeriksaan/hasil_radiologi_all.php?idKunj='+getIdKunj+'&idPel='+sisip[0],'_blank');	
	}
	else{
		alert('Data Tidak Ada');
	}
}

function cetakHasilRad(){
	var sisip=lkr.getRowId(lkr.getSelRow()).split("|");
	window.open('hasil_pemeriksaan/hasil_radiologi.php?idKunj='+getIdKunj+'&idPel='+sisip[0]+'&id='+sisip[7],'_blank');
}
</script>
<script type="text/javascript">
	function LabRadAmbil(){
		var tmpJnsLay = jQuery('#cmbJnsLay').val();
		var cmbDokHsl = document.getElementById("cmbDokHsl").value;
		var Jkel = document.getElementById("txtSex").value;
		var cmbDokHslD = document.getElementById("cmbDokHslD").value;
		
		ambilLab();
		//return false;
		if(tmpJnsLay == 57){
			url = "hasil_pemeriksaan/hasilLab_utils.php?grd=true&act=tambah&smpn=btnSimpanHslLab&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&jk="+Jkel+"&user_act=<?php echo $userId; ?>&idSimpan="+tmpPilLab2+"&user_actD="+cmbDokHslD;
			//alert(url);
			lab.loadURL(url,"","GET");
			menutup();
			document.getElementById('terima_labrad').disabled = true;
			//getLabRad=1;
		}else if(tmpJnsLay == 60){
			url = "hasil_pemeriksaan/hasilRad_utils.php?grd=true&act=tambah&smpn=btnSimpanHslRad&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&jk="+Jkel+"&user_act=<?php echo $userId; ?>&idSimpan="+tmpPilLab2+"&user_actD="+cmbDokHslD;
			//alert(url);
			rad.loadURL(url,"","GET");
			menutup();
			document.getElementById('terima_labrad').disabled = true;
			//getLabRad=1;
		}
	}
	
	function ambilLab()
	{
		tmpPilLab="";
		jQuery(".LPemID").each(function(){
			if(this.checked)
			{
				if(tmpPilLab=="")
				{
					tmpPilLab=jQuery(this).val();
				}else{
					tmpPilLab+="|"+jQuery(this).val();
				}
			}
		});
		
		var tmpPilLab1= tmpPilLab.split('|');
		tmpPilLab2 = tmpPilLab1.join();
		//alert(tmpPilLab2);
	}
	
	function ambilLabAll()
	{
		if(document.getElementById("LPemIDAll").checked==true)
		{
			jQuery(".LPemID").each(function(){
				jQuery(this).prop('checked', true);
			});
		}else{
			jQuery(".LPemID").each(function(){
				jQuery(this).prop('checked', false);
			});
		}
	}
	
	function menutup(){
		document.getElementById('div_popup_tind').popup.hide();
		document.getElementById('divobat').style.display='none';	
	}
</script>
<?php
include("../sesi.php");
	include("../koneksi/konek.php");
	
	$tgl=gmdate('d-m-Y',mktime(date('H')+7));
	$th=explode("-",$tgl);
	$tgl2="$th[2]-$th[1]-$th[0]";
	//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
	$idunit=$_SESSION["ses_idunit"];
	$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
	$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
	$minta_id=$_REQUEST['minta_id'];
?>
<script type="text/JavaScript">
	var arrRange = depRange = [];
</script>
<!--====================popup======================================-->
<link rel="stylesheet" type="text/css" href="../theme/li/popup.css" />
<script type="text/javascript" src="../theme/li/prototype.js"></script>
<script type="text/javascript" src="../theme/li/effects.js"></script>
<script type="text/javascript" src="../theme/li/popup.js"></script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
		id="gToday:normal:agenda.js"
		src="../theme/popcjs.php" scrolling="no"
		frameborder="1"
		style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div id="popGrPet" style="display:none; width:600px;height:auto;background-color: #80514E;border: 5px solid #CC3366;" class="popup">
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
        <table width="590" align="center" cellpadding="3" cellspacing="0">
        <tr>
            <td colspan="2" class="font" align="center">&nbsp;</td>
        </tr>
        <tr id="trObat">
            <td class="font">Nama Obat</td>
            <td>:&nbsp;<input type="text" id="newObat" size="65" onKeyUp="suggest(event,this);" autocomplete="off" /></td>
        </tr>
		<tr id="trchRacikan" style="visibility:collapse">
			<td>Racikan</td>
			<td>:&nbsp;<input type="checkbox" id="chRacikan" name="chRacikan" class="txtinput" onclick="CekRacikan(this);"></td>
		</tr>
		<tr id="trRacikan" style="visibility:collapse">
			<td>Racikan ke-&nbsp;</td>
			<td>:&nbsp;<select id="noRacikan" name="noRacikan" class="txtinput">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            	</select>
			</td>
		</tr>
        <tr id="trQtyObat">
            <td class="font">Qty</td>
            <td>:&nbsp;<input type="text" id="newQtyObat" style="text-align:center;" size="3" autocomplete="off" /></td>
        </tr>
		<tr id="trJmlBahan" style="visibility:collapse">
			<td>Jumlah Bahan&nbsp;</td>
			<td>:&nbsp;<input id="txtJmlBahan" name="txtJmlBahan" size="3" class="txtcenter">&nbsp;
				<select id="satuanRacikan" name="satuanRacikan" class="txtinput" style="visibility:hidden">
                <?php 
				$sql="SELECT * FROM $dbapotek.a_satuan_racikan WHERE aktif=1";
				$rs=mysqli_query($konek,$sql);
				while ($rw=mysqli_fetch_array($rs)){
				?>
                <option value="<?php echo $rw['nama']; ?>"><?php echo $rw['nama']; ?></option>
                <?php 
				}
				?>
            	</select>&nbsp;
			</td>
		</tr>
		<tr id="trDosis" style="visibility:collapse">
			<td>Ket Dosis&nbsp;</td>
			<td>:&nbsp;<span id="spnKetDosis"><select id="txtDosis" name="txtDosis" class="txtinput">
                <?php 
				$sql="SELECT * FROM $dbapotek.a_dosis WHERE aktif=1";
				$rs=mysqli_query($konek,$sql);
				while ($rw=mysqli_fetch_array($rs)){
				?>
                <option value="<?php echo $rw['nama']; ?>"><?php echo $rw['nama']; ?></option>
                <?php 
				}
				?>
            	</select></span>&nbsp;<input type="checkbox" id="yeah" class="txtinput" onchange="gantiDosis(this);" style="cursor:pointer" />&nbsp;Lainnya
            </td>
		</tr>
        <tr id="trFarmasi" style="visibility:collapse">
            <td class="font">Unit</td>
            <td>:&nbsp;<select id="IdFarmasiRujuk">
            	<?php 
				$sql="SELECT * FROM a_unit WHERE UNIT_TIPE=2 AND UNIT_ID<>$idunit AND UNIT_ISAKTIF=1";
				$rs=mysqli_query($konek,$sql);
				while ($rw=mysqli_fetch_array($rs)){
				?>
            	<option value="<?php echo $rw['UNIT_ID']; ?>"><?php echo $rw['UNIT_NAME']; ?></option>
                <?php 
				}
				?>
            </select></td>
        </tr>
        <tr id="trCaraBayar" style="visibility:collapse;">
            <td class="font">Cara Bayar</td>
            <td>:&nbsp;<select id="IdCaraBayar">
            	<?php 
				$sql="SELECT * FROM a_cara_bayar WHERE aktif=1";
				$rs=mysqli_query($konek,$sql);
				while ($rw=mysqli_fetch_array($rs)){
				?>
            	<option value="<?php echo $rw['id']; ?>"><?php echo $rw['nama']; ?></option>
                <?php 
				}
				?>
            </select></td>
        </tr>
        <tr id="trKepemilikan" style="visibility:collapse;">
            <td class="font">Kepemilikan</td>
            <td>:&nbsp;<select id="IdKepemilikan">
            	<?php 
				$sql="SELECT * FROM a_kepemilikan WHERE AKTIF=1";
				$rs=mysqli_query($konek,$sql);
				while ($rw=mysqli_fetch_array($rs)){
				?>
            	<option value="<?php echo $rw['ID']; ?>"><?php echo $rw['NAMA']; ?></option>
                <?php 
				}
				?>
            </select></td>
        </tr>
        <tr>
            <td colspan="2" align="center" height="50" valign="bottom"><button id="tambah" name="tambah" value="tambah" type="button" style="cursor:pointer" onClick="TambahNewObat()"><img src="../icon/add.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Tambah</button>&nbsp;<button id="sim" name="sim" value="simpan" type="button" style="cursor:pointer" onClick="SimpanNewObat()"><img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan</button>&nbsp;<button type="button" id="batal" name="batal" class="popup_closebox" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button></td>
        </tr>
        <tr id="trlstNewObat">
            <td colspan="2" align="center"><textarea id="lstNewObat" cols="50" rows="3"></textarea></td>
        </tr>
        </table>
</div>
<div align="center" id="div_data">
	<table width="950" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
		<!--tr>
			<td height="30">&nbsp;</td>
		</tr-->
		<tr>
			<td height="50">Status Dilayani: 
			<select id="cmbDilayani" class="txtinput" onchange="ubahTgl()">
				<option value="0" selected="selected">BELUM</option>
				<option value="1">SUDAH</option>
				<!--option value="">SEMUA</option-->
			</select>&nbsp;&nbsp;&nbsp;Tgl Resep&nbsp;
			<input name="txtTgl" type="text" id="txtTgl" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl?>" /> 
      <input type="button" name="btnTgl" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange,ubahTgl);" />
      <BUTTON id="cetakResep" style="float:right" type="button" onClick="cetakResep();">&nbsp;COPY RESEP</BUTTON>
      <BUTTON id="btnMutasi" style="float:right" type="button" onClick="KirimUnit();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kirim >> Farmasi Lain</BUTTON>
          </td>
		</tr>
		<tr>
			<td align="center">
			<div id="gridbox" style="width:950px; height:220px; background-color:white;"></div>
			<div id="paging" style="width:950px;"></div>
            </td>
		</tr>
		<!--tr>
			<td>&nbsp;</td>
		</tr-->
	</table>
</div>
<div align="center" id="div_detail" style="display:block">
	<table width="950" border="0" cellspacing="0" cellpadding="0" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
		<tr style="visibility:collapse">
			<td align="center" height="28"><span id="spanSuk" style="display:none"></span></td>
		</tr>
		<tr>
			<td align="center">
            <IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="right" title="Klik Untuk Menambah Item Obat" style="padding-right:10px;padding-top:2px;cursor:pointer;" onclick="AddItemObatKlik()">
			<div id="gridboxDet" style="width:950px; height:200px; background-color:white;"></div><br>
			<!--div id="pagingDet" style="width:950px;"></div-->
            <table width="90%" border="0" cellpadding="0" cellspacing="0" align="center" class="txtinput">
              <input name="subtotal" type="hidden" id="subtotal" size="12" value="0" class="txtright" readonly="true" />
              <input name="embalage" type="hidden" id="embalage" size="12" value="0" class="txtright" onKeyUp="HitungTot()" />
              <input name="jasa_resep" type="hidden" id="jasa_resep" size="12" value="0" class="txtright" onKeyUp="HitungTot()" />
              <tr> 
                <td width="718">&nbsp;</td>
                <td width="97">TOTAL HARGA</td>
                <td> 
                  <input name="tot_harga" type="text" id="tot_harga" size="17" value="0" class="txtright" readonly="true" />
                </td>
              </tr>
              <tr>
                <td align="center" style="padding-left:200px"><BUTTON id="btnSimpan" type="button" onClick="prosesData();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>
                  <BUTTON id="btnKw" type="button" <?php  if($act<>'save') echo "disabled='disabled'"; ?> onClick="OpenKwitansi();"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak 
                  Penjualan</BUTTON></td>
                <td>BAYAR</td>
                <td><input name="bayar" type="text" id="bayar" size="17" value="0" class="txtright" onKeyUp="fBayar();" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>KEMBALI</td>
                <td><input name="kembali" type="text" id="kembali" size="17" value="0" class="txtright" readonly="true" /></td>
              </tr>
            </table><br />
            </td>
		</tr>
	</table>
</div>
<script>
	var RowIdx;
	var fKeyEnt;
	var keyCari;
	function suggest(e,par){
	var keywords=par.value;//alert(keywords);
	var i=1;
		//alert(par.offsetLeft);
		if(keywords.length<2){
			document.getElementById('divobat').style.display='none';
		}else{
			var key;
			if(window.event) {
			  key = window.event.keyCode; 
			}
			else if(e.which) {
			  key = e.which;
			}
			//alert(key);
			if (key==38 || key==40){
				var tblRow=document.getElementById('tblObat').rows.length;
				if (tblRow>0){
					//alert(RowIdx);
					if (key==38 && RowIdx>0){
						RowIdx=RowIdx-1;
						document.getElementById(RowIdx+1).className='itemtableReq';
						if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
					}else if (key==40 && RowIdx<tblRow){
						RowIdx=RowIdx+1;
						if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
						document.getElementById(RowIdx).className='itemtableMOverReq';
					}
				}
			}else if (key==13){
				if (RowIdx>0){
					if (fKeyEnt==false){
						fSetObat(document.getElementById(RowIdx).lang);
					}else{
						fKeyEnt=false;
					}
				}
			}else if (key!=27 && key!=37 && key!=39 && key!=9){
				fKeyEnt=false;
				if (key==123){
					RowIdx=0;
					Request('../transaksi/obatlistjual.php?aKepemilikan=0&aHarga='+kpPop+'&idunit=<?php echo $idunit; ?>&aKeyword='+keywords+'&no='+i , 'divobat', '', 'GET' );
				}else if (key==120){
					alert(RowIdx);
				}else{
					RowIdx=0;
					Request('../transaksi/obatlistjual.php?aKepemilikan='+kpPop+'&aHarga='+kpPop+'&idunit=<?php echo $idunit; ?>&aKeyword='+keywords+'&no='+i , 'divobat', '', 'GET' );
				}
				if (document.getElementById('divobat').style.display=='none'){
					//fSetPosisi(document.getElementById('divobat'),par);
					document.getElementById('divobat').style.left="135px";
					document.getElementById('divobat').style.top="55px";
				}
				document.getElementById('divobat').style.display='block';
			}
		}
		
		clearTimeout(fReload);
		fReload=setTimeout("AutoRefresh()", 120000);
	}

	var iRow;
	var no_penjualan,NoRM,tgltrans;
	var idunit="<?php echo $idunit; ?>";
	
	function ubahTgl(){
	var url="../transaksi/utils.php?grd=true&tanggal="+document.getElementById('txtTgl').value+"&status="+document.getElementById('cmbDilayani').value+"&idunit=<?php echo $idunit; ?>";
		if (document.getElementById('cmbDilayani').value=="0"){
		 	document.getElementById('btnMutasi').disabled=false;
		 	document.getElementById('btnSimpan').disabled=false;
		}else{
		 	document.getElementById('btnMutasi').disabled=true;
		 	document.getElementById('btnSimpan').disabled=true;
		}
		//alert(url);
		r.loadURL(url,"","GET");
		
		clearTimeout(fReload);
		fReload=setTimeout("AutoRefresh()", 120000);
	}
	
	<!-- Script Pop Up Window -->
	var win = null;
	function NewWindow(mypage,myname,w,h,scroll){
		LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
		TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
		settings =
		'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
		win = window.open(mypage,myname,settings)
	}
	<!-- Script Pop Up Window Berakhir -->
	
	var idpel = '0',no_resep='';
	function ambilData(key,val){
	var sisip;
	var url;
		//alert(key+"|"+val);
		if (val!=undefined && val!=""){
			sisip=val.split("|");
			no_penjualan=sisip[0];
			NoRM=sisip[1];
			tgltrans=sisip[2];
			document.getElementById('btnKw').disabled=false;
		}else if (document.getElementById('cmbDilayani').value=="0"){
			document.getElementById('btnKw').disabled=true;
			document.getElementById('btnSimpan').disabled=false;
			if (r.getMaxPage()>0){
				NoRM=r.cellsGetValue(r.getSelRow(),3);
			}
		}
		
		if (r.getMaxPage()>0){
			document.getElementById('div_detail').style.display = 'block';
			no_resep = r.cellsGetValue(r.getSelRow(),2);
			var www = r.getRowId(r.getSelRow()).split('|');
			var kepemilikan = www[1];
			idpel = www[4];
			
			if ((val==undefined || val=="") && document.getElementById('cmbDilayani').value=="1"){
				no_penjualan=www[5];
				NoRM=www[3];
				tgltrans=www[6];
				document.getElementById('btnKw').disabled=false;
			}
			
			url="../transaksi/utils.php?grdDet=true&no_resep="+no_resep+"&status="+document.getElementById('cmbDilayani').value+"&idunit=<?php echo $idunit; ?>&tanggal="+document.getElementById('txtTgl').value+"&idpel="+idpel+"&no_penj="+no_penjualan+"&no_rm="+NoRM+"&tgltrans="+tgltrans;
			//alert(url);
			rDet.loadURL(url,"","GET");
		}else{
			idpel = '0';
			no_resep = '';
			if (document.getElementById('btnKw').disabled==false){
				url="../transaksi/utils.php?grdDet=true&no_resep=&idpel=0&status="+document.getElementById('cmbDilayani').value+"&idunit=<?php echo $idunit; ?>&tanggal=00-00-0000";
				//alert(url);
				rDet.loadURL(url,"","GET");
			}else{
				document.getElementById('div_detail').style.display = 'none';
			}
		}
	}
	
	function cetakResep()
	{
	var sss = r.getRowId(r.getSelRow()).split('|');
	var idpel = sss[4];
	var no_resep = sss[2];
	var NoRM = r.cellsGetValue(r.getSelRow(),3);
	var tgl = document.getElementById('txtTgl').value;
	tgl = tgl.split('-');
	//alert(NoRM);
		//url="../report/kwi_dosis2.php?grdDet=true&no_resep="+no_resep+"&status="+document.getElementById('cmbDilayani').value+"&idunit=<?php echo $idunit; ?>&tanggal="+document.getElementById('txtTgl').value+"&idpel="+idpel+"&no_penj="+no_penjualan+"&no_rm="+NoRM+"&tgltrans="+tgltrans;
		url="../report/kwi_dosis2.php?no_penjualan=&idpel="+idpel+"&no_resep="+no_resep+"&sunit=<?php echo $idunit; ?>&no_pasien="+NoRM+"&tgl="+tgl[2]+"-"+tgl[1]+"-"+tgl[0];
		//alert(url);
		window.open(url);
	}
/*	function ambilData(key,val){
	var sisip;
	var url;
		//alert(key+"|"+val);
		if (val!=undefined && val!=""){
			sisip=val.split("|");
			no_penjualan=sisip[0];
			NoRM=sisip[1];
			tgltrans=sisip[2];
			document.getElementById('btnKw').disabled=false;
		}else if (document.getElementById('cmbDilayani').value=="0"){
			document.getElementById('btnKw').disabled=true;
			document.getElementById('btnSimpan').disabled=false;
			if (r.getMaxPage()){
				NoRM=r.cellsGetValue(r.getSelRow(),3);
			}else{
				NoRM='';
			}
		}
		//alert(r.getMaxPage());
		if (r.getMaxPage()>0){
			document.getElementById('div_detail').style.display = 'block';
			no_resep = r.cellsGetValue(r.getSelRow(),2);
			var www = r.getRowId(r.getSelRow()).split('|');
			var kepemilikan = www[1];
			idpel = www[4];
			
			if ((val==undefined || val=="") && document.getElementById('cmbDilayani').value=="1"){
				no_penjualan=www[5];
				NoRM=www[3];
				tgltrans=www[6];
				document.getElementById('btnKw').disabled=false;
			}
			
			url="../transaksi/utils.php?grdDet=true&no_resep="+no_resep+"&status="+document.getElementById('cmbDilayani').value+"&idunit=<?php echo $idunit; ?>&tanggal="+document.getElementById('txtTgl').value+"&no_penj="+no_penjualan+"&no_rm="+NoRM+"&tgltrans="+tgltrans;
			//alert(url);
			rDet.loadURL(url,"","GET");
		}else{
			//alert('a');
			if (document.getElementById('btnKw').disabled==false){
				url="../transaksi/utils.php?grdDet=true&no_resep=&status="+document.getElementById('cmbDilayani').value+"&idunit=<?php echo $idunit; ?>&tanggal=00-00-0000";
				//alert(url);
				rDet.loadURL(url,"","GET");
			}else{
				document.getElementById('div_detail').style.display = 'none';
			}
		}
	}*/
	
	function CheckedObat(k){
	var tmpId = rDet.getRowId(rDet.getSelRow()).split('|');
		if (rDet.obj.childNodes[0].childNodes[k-1].childNodes[9].childNodes[0].checked){
			if (parseFloat(rDet.obj.childNodes[0].childNodes[k-1].childNodes[4].innerHTML) < parseFloat(rDet.obj.childNodes[0].childNodes[k-1].childNodes[6].childNodes[0].innerHTML)){
				alert("Stok Obat Yang Mau Dibeli Tdk Mencukupi !");
				rDet.obj.childNodes[0].childNodes[k-1].childNodes[9].childNodes[0].checked=false;
				return false;
			}else if (parseFloat(rDet.obj.childNodes[0].childNodes[k-1].childNodes[6].childNodes[0].innerHTML)==0){
				alert("Jumlah Obat Yang Mau Dibeli Tdk Boleh 0 !");
				rDet.obj.childNodes[0].childNodes[k-1].childNodes[9].childNodes[0].checked=false;
				return false;
			}else if (tmpId[5]==0 && tmpId[6]==1){
				alert("Obat Racikan Ini, Dientry Manual !\r\nUntuk Melayani, Ganti Obatnya Terlebih Dahulu");
				rDet.obj.childNodes[0].childNodes[k-1].childNodes[9].childNodes[0].checked=false;
				return false;
			}
		}
		HitungTot();
	}
	
	function HitungTot(){
		var tmp=0;
		document.getElementById('tot_harga').value="0";
		for (var k=0;k<rDet.getMaxRow();k++){
			if (rDet.obj.childNodes[0].childNodes[k].childNodes[9]){
				if (rDet.obj.childNodes[0].childNodes[k].childNodes[9].childNodes[0].checked){
					//alert(rDet.obj.childNodes[0].childNodes[k].childNodes[9].childNodes[0].checked);
					tmp=tmp+parseFloat(ValidasiText(rDet.cellsGetValue(k+1,9)));
				}
			}
		}
		//alert(tmp);
		//rDet.cellSubTotalSetValue(9,FormatNumberFloor(tmp,"."));
		document.getElementById('tot_harga').value=FormatNumberFloor(tmp,".");
		document.getElementById('bayar').value=document.getElementById('tot_harga').value;
		fBayar();
		
		clearTimeout(fReload);
		fReload=setTimeout("AutoRefresh()", 120000);
	}
	
	function UbahCaraBayar(obj){
		document.getElementById('trFarmasi').style.visibility="collapse";
		document.getElementById('trCaraBayar').style.visibility="visible";
		document.getElementById('trKepemilikan').style.visibility="collapse";
		document.getElementById('trObat').style.visibility="collapse";
		document.getElementById('trchRacikan').style.visibility="collapse";
		document.getElementById('trRacikan').style.visibility="collapse";
		document.getElementById('trQtyObat').style.visibility="collapse";
		document.getElementById('trDosis').style.visibility="collapse";
		document.getElementById('trlstNewObat').style.visibility="collapse";
		document.getElementById('tambah').style.display="none";
		new Popup('popGrPet',null,{modal:true,position:'center',duration:1});
		document.getElementById('popGrPet').popup.show();
		document.getElementById('newObat').focus();
		
		clearTimeout(fReload);
		fReload=setTimeout("AutoRefresh()", 120000);
	}
	
	function UbahKepemilikan(obj){
		document.getElementById('trFarmasi').style.visibility="collapse";
		document.getElementById('trCaraBayar').style.visibility="collapse";
		document.getElementById('trKepemilikan').style.visibility="visible";
		document.getElementById('trObat').style.visibility="collapse";
		document.getElementById('trchRacikan').style.visibility="collapse";
		document.getElementById('trRacikan').style.visibility="collapse";
		document.getElementById('trQtyObat').style.visibility="collapse";
		document.getElementById('trDosis').style.visibility="collapse";
		document.getElementById('trlstNewObat').style.visibility="collapse";
		document.getElementById('tambah').style.display="none";
		new Popup('popGrPet',null,{modal:true,position:'center',duration:1});
		document.getElementById('popGrPet').popup.show();
		document.getElementById('newObat').focus();
		
		clearTimeout(fReload);
		fReload=setTimeout("AutoRefresh()", 120000);
	}
	
	function UbahQtyRsp(obj,isi,ya){
		//alert(obj.id);
		//alert(isi);
		var i=obj.id.split("-");
		var cid=rDet.getRowId(i[1]).split("|");
		var newId="";
		var jmlAsal=obj.innerHTML;
		var stot;
		var qtyUbahRsp = prompt('Masukkan Jumlah Obat Yg Diambil', jmlAsal);
		if (qtyUbahRsp!=null){
			if (qtyUbahRsp<=isi || ya==1){
			while (qtyUbahRsp.indexOf(",")>-1){
				qtyUbahRsp=qtyUbahRsp.replace(",",".");
			}
			obj.innerHTML=qtyUbahRsp;
			//alert(rDet.getRowId(i[1]));
			stot=parseFloat(qtyUbahRsp)*parseFloat(cid[1]);
			//alert(stot);
			rDet.cellsSetValue(i[1],9,FormatNumberFloor(parseInt(stot.toString()),"."));
			newId=cid[0]+"|"+cid[1]+"|"+cid[2]+"|"+qtyUbahRsp+"|"+cid[4]+"|"+cid[5]+"|"+cid[6];
			rDet.setRowId(i[1],newId);
			HitungTot();
			}
		}
		
		clearTimeout(fReload);
		fReload=setTimeout("AutoRefresh()", 120000);
	}
	
	function UpdateStatus(j){
		var sisip=rDet.getRowId(j).split("|");
		var act;
		//alert(rDet.getRowId(j)+' || '+j+' || '+rDet.getSelRow());
		iRow=j;
		if (rDet.obj.childNodes[0].childNodes[j-1].childNodes[9].childNodes[0].checked){
			act="tambah";
		}else{
			act="hapus";
		}
		document.getElementById('spanSuk').innerHTML='';
		url='../transaksi/utils.php?act='+act+'&idRes='+sisip[0];
		//alert(url);
		Request(url,'spanSuk','','GET',tampil);
	}
	
	function fBayar(){
	var r,s,t;
		r=ValidasiText(document.getElementById('bayar').value);
		s=ValidasiText(document.getElementById('tot_harga').value);
		
		if (isNaN(r)) r=0;
		if (isNaN(s)) s=0;
		
		t=parseFloat(r)-parseFloat(s);
		document.getElementById('bayar').value=FormatNumberFloor(parseInt(r),".");
		document.getElementById('kembali').value=FormatNumberFloor(t,".");
	}
	
	function ValidasiText(p){
	var tmp=p;
		while (tmp.indexOf('.')>-1){
			tmp=tmp.replace('.','');
		}
		while (tmp.indexOf(',')>-1){
			tmp=tmp.replace(',','.');
		}
		return tmp;
	}
	
	function prosesData(){
	var tmp,url;
	var tgl=document.getElementById('txtTgl').value;
	var sTot=ValidasiText(document.getElementById('tot_harga').value);
	var tgl_act=tgl;
	var sisip=r.getRowId(r.getSelRow()).split('|');
	var sisipDet;
		//alert(rDet.getMaxRow());
		document.getElementById('btnSimpan').disabled=true;
		tmp="";
		for (var k=0;k<rDet.getMaxRow();k++){
			if (rDet.obj.childNodes[0].childNodes[k].childNodes[9].childNodes[0].checked){
				tmp+=rDet.getRowId(k+1)+"*|*";
				//sisipDet=rDet.getRowId(k+1).split('|');
				//tmp+=sisipDet[0]+"|"+sisipDet[1]+"|"+sisipDet[2]+"|"+sisipDet[3]+"|"+sisipDet[4]+"|"+sisipDet[5]+"|"+sisipDet[6]+"*|*";
				//alert(rDet.cellsGetValue(k+1,7));
			}
		}
		
		if (tmp==""){
			alert("Pilih Item Obat Yang Mau Dibeli !");
			document.getElementById('btnSimpan').disabled=false;
			return false;
		}else{
			tmp=tmp.substr(0,tmp.length-3);
		}
		
		url='../transaksi/utils.php?grd=true&act=simpan&idPel='+sisip[4]+'&no_rm='+sisip[3]+'&no_resep='+sisip[2]+'&subtotal='+sTot+'&fdata='+tmp+"&idunit=<?php echo $idunit; ?>&iduser=<?php echo $iduser; ?>&shift=<?php echo $shift; ?>&tanggal="+tgl+"&status="+document.getElementById('cmbDilayani').value+"&tgl_act="+tgl_act;
		//alert(url);
		if (confirm('Apakah Data Sudah Benar?')){
			r.loadURL(url,"","GET");
			//document.getElementById('tot_harga').value="";
		}else{
			document.getElementById('btnSimpan').disabled=false;
		}
		
		clearTimeout(fReload);
		fReload=setTimeout("AutoRefresh()", 120000);
	}
	
	function OpenKwitansi(){
	var url="../report/kwi_retur.php?no_penjualan="+no_penjualan+"&sunit="+idunit+"&no_pasien="+NoRM+"&tgl="+tgltrans;
		NewWindow(url,'name','560','500','yes');
		//return false;
	}
	//----joker----
	var kpPop,IdResepPop,tObat,tKpid,tHNetto,tHJual,tQty,tQtyStok,tRow,tAct,bobat;
	function EditObat(p){
	var tmp=p.split("|");
	var tmpId = rDet.getRowId(rDet.getSelRow()).split('|');
		//alert('edit obat : '+p);
		tAct="edit";
		IdResepPop=tmp[0];
		kpPop=tmp[1];
		//qtyPop=tmp[2];
		tRow=tmp[3];
		bobat=tmp[4];
		
		document.getElementById('trlstNewObat').style.visibility="collapse";
		document.getElementById('tambah').style.display="none";
		if (tmpId[6]==0){
			document.getElementById('trFarmasi').style.visibility="collapse";
			document.getElementById('trCaraBayar').style.visibility="collapse";
			document.getElementById('trObat').style.visibility="visible";
			document.getElementById('trchRacikan').style.visibility="collapse";
			document.getElementById('trRacikan').style.visibility="collapse";
			document.getElementById('trQtyObat').style.visibility="collapse";
			document.getElementById('trJmlBahan').style.visibility="collapse";
			document.getElementById('trDosis').style.visibility="collapse";
		}else{
			document.getElementById('trFarmasi').style.visibility="collapse";
			document.getElementById('trCaraBayar').style.visibility="collapse";
			document.getElementById('trObat').style.visibility="visible";
			document.getElementById('trchRacikan').style.visibility="collapse";
			document.getElementById('trRacikan').style.visibility="collapse";
			document.getElementById('trQtyObat').style.visibility="visible";
			document.getElementById('trJmlBahan').style.visibility="collapse";
			document.getElementById('trDosis').style.visibility="collapse";
			if (tmpId[5]==0){
				document.getElementById('trlstNewObat').style.visibility="visible";
				document.getElementById('tambah').style.display="table-row";
			//}else{
			//	document.getElementById('trlstNewObat').style.visibility="collapse";
			}
		}
		tObat="";
		tmpNewIdSisip_lstNewObat="";
		document.getElementById('newObat').value="";
		document.getElementById('newQtyObat').value="";
		document.getElementById('lstNewObat').value="";
		document.getElementById('txtDosis').value=rDet.cellsGetValue(rDet.getSelRow(),3);
		new Popup('popGrPet',null,{modal:true,position:'center',duration:1});
		document.getElementById('popGrPet').popup.show();
		document.getElementById('newObat').focus();
		
		clearTimeout(fReload);
		fReload=setTimeout("AutoRefresh()", 120000);
	}
	
	function fSetObat(par){
	var tpar=par;
	var cdata;
		while (tpar.indexOf(String.fromCharCode(5))>0){
			tpar=tpar.replace(String.fromCharCode(5),"'");
		}
		while (tpar.indexOf(String.fromCharCode(3))>0){
			tpar=tpar.replace(String.fromCharCode(3),'"');
		}
		cdata=tpar.split("*|*");
		tObat=cdata[1];
		tKpid=cdata[7];
		tHNetto=cdata[9];
		tHJual=cdata[4];
		tQtyStok=cdata[5];
		//tQty=qtyPop;
		document.getElementById('divobat').style.display='none';
		document.getElementById('newObat').value=cdata[2];
		if (document.getElementById('trQtyObat').style.visibility=="visible"){
			document.getElementById('newQtyObat').focus();
		}
	}
	//----joker----
	var tmpNewIdSisip_lstNewObat="",ArrtmpNewIdSisip_lstNewObat,tmpNewIdSisip="",ArrtmpNewIdSisip;
	function TambahNewObat(){
	var tvalue=document.getElementById('lstNewObat').value;
	var tObatNama=document.getElementById('newObat').value;
	var tqty=document.getElementById('newQtyObat').value;
	var cketdosis=document.getElementById('txtDosis').value;
		if (tObat==""){
			alert("Pilih Obat Terlebih Dahulu !");
			return false;
		}
		tmpNewIdSisip_lstNewObat +=IdResepPop+"|"+tHJual+"|"+tHNetto+"|"+tqty+"|"+kpPop+"|"+tObat+"|"+"1"+"|"+cketdosis+"|"+tObatNama+"|"+tQtyStok+String.fromCharCode(3);
		document.getElementById('lstNewObat').value=tvalue+tObatNama+' : '+tqty+'\r\n';
		document.getElementById('newObat').value="";
		document.getElementById('newQtyObat').value="";
		tObat="";
		document.getElementById('newObat').focus();
	}
	
	function SimpanNewObat(){
		var tmp,no_resep,act,fdata,stot,cedit,cqtyRsp,cketdosis,d,tmpNewRow;
		tmp = r.getRowId(r.getSelRow()).split('|');
		no_resep = tmp[2];
		//alert(tmp[2]);
		
		if (tAct=="add"){
			if (confirm('Yakin Ingin Menambah Item Obat ?')){
				stot=(document.getElementById('newQtyObat').value)*tHJual;
				cedit="&nbsp;|&nbsp;<img src='../icon/edit.gif' border='0' width='16' height='16' align='absmiddle' title='Klik Untuk Mengubah Resep' onclick=EditObat('0|"+tmp[1]+"|"+cqtyRsp+"|"+(rDet.getMaxRow()+1)+"') />";
			
				cqtyRsp="<span id='qtyRsp-"+(rDet.getMaxRow()+1)+"' style='text-decoration:underline' title='Klik Untuk Mengubah Jumlah Obat Yg Diambil Pasien' onclick='UbahQtyRsp(this);'>"+document.getElementById('newQtyObat').value+"</span>";
				cketdosis=document.getElementById('txtDosis').value;
				d="<input type='checkbox' id='ch0' title='Centang Untuk Melayani Resep' onclick='CheckedObat("+(rDet.getMaxRow()+1)+");' />"+cedit;
				tmpNewIdSisip="0|"+tHJual+"|"+tHNetto+"|"+document.getElementById('newQtyObat').value+"|"+tmp[1]+"|"+tObat+"|"+"0"+"|"+cketdosis;
				tmpNewRow=tmpNewIdSisip+String.fromCharCode(3)+(rDet.getMaxRow()+1)+String.fromCharCode(3)+document.getElementById('newObat').value+String.fromCharCode(3)+cketdosis+String.fromCharCode(3)+"-"+String.fromCharCode(3)+tQtyStok+String.fromCharCode(3)+FormatNumberFloor(tHNetto,".")+String.fromCharCode(3)+cqtyRsp+String.fromCharCode(3)+FormatNumberFloor(tHJual,".")+String.fromCharCode(3)+FormatNumberFloor(stot,".")+String.fromCharCode(3)+d;
				rDet.AddRowItem(tmpNewRow);
			}
		}else if (tAct=="edit"){
			if (document.getElementById('trlstNewObat').style.visibility=="collapse"){
				/*act="act=editobat";
				fdata=IdResepPop+"|"+tObat+"|"+tKpid+"|"+tHNetto+"|"+tHJual;
				url="../transaksi/utils.php?"+act+"&fdata="+fdata+"&grdDet=true&no_resep="+no_resep+"&status="+document.getElementById('cmbDilayani').value+"&idunit=<?php echo $idunit; ?>&iduser=<?php echo $iduser; ?>&tanggal="+document.getElementById('txtTgl').value;
				//alert(url);*/
				if (confirm('Yakin Ingin Mengubah Resep ?')){
					//rDet.loadURL(url,"","GET");
					var cid=rDet.getRowId(tRow).split("|");
					var newId=cid[0]+"|"+tHJual+"|"+tHNetto+"|"+cid[3]+"|"+tKpid+"|"+tObat+"|"+cid[6];
					var stot=cid[3]*tHJual;
					rDet.cellsSetValue(tRow,9,FormatNumberFloor(stot,"."));
					rDet.cellsSetValue(tRow,2,document.getElementById('newObat').value);
					rDet.cellsSetValue(tRow,5,tQtyStok);
					rDet.cellsSetValue(tRow,6,FormatNumberFloor(tHNetto,"."));
					rDet.cellsSetValue(tRow,8,FormatNumberFloor(tHJual,"."));
					rDet.setRowId(tRow,newId);
					HitungTot();
					//document.getElementById('popGrPet').popup.hide();
				}
			}else{//----edit obat racikan manual----
				if (tmpNewIdSisip_lstNewObat==""){
					alert("Data Obat Yang Mau Disimpan Belum Ada !");
					return false;
				}else{
					if (confirm('Apakah Data Sudah Betul ?')){
						rDet.DeleteRowItem(tRow);
						ArrtmpNewIdSisip_lstNewObat=tmpNewIdSisip_lstNewObat.split(String.fromCharCode(3));
						for (var j=0;j<(ArrtmpNewIdSisip_lstNewObat.length-1);j++){
							//alert(ArrtmpNewIdSisip_lstNewObat[j]);
							ArrtmpNewIdSisip=ArrtmpNewIdSisip_lstNewObat[j].split("|");
							//alert(ArrtmpNewIdSisip[1]+"\n"+ArrtmpNewIdSisip[2]+"\n"+ArrtmpNewIdSisip[3]);
							tHJual=ArrtmpNewIdSisip[1];
							tHNetto=ArrtmpNewIdSisip[2];
							stot=(ArrtmpNewIdSisip[3])*tHJual;
							cedit="&nbsp;|&nbsp;<img src='../icon/edit.gif' border='0' width='16' height='16' align='absmiddle' title='Klik Untuk Mengubah Resep' onclick=EditObat('"+ArrtmpNewIdSisip[0]+"|"+ArrtmpNewIdSisip[4]+"|"+ArrtmpNewIdSisip[3]+"|"+(rDet.getMaxRow()+1)+"') />";
						
							cqtyRsp="<span id='qtyRsp-"+(rDet.getMaxRow()+1)+"' style='text-decoration:underline' title='Klik Untuk Mengubah Jumlah Obat Yg Diambil Pasien' onclick='UbahQtyRsp(this);'>"+ArrtmpNewIdSisip[3]+"</span>";
							cketdosis=ArrtmpNewIdSisip[7];
							d="<input type='checkbox' id='ch0' title='Centang Untuk Melayani Resep' onclick='CheckedObat("+(rDet.getMaxRow()+1)+");' />"+cedit;
							tmpNewIdSisip=ArrtmpNewIdSisip[0]+"|"+tHJual+"|"+tHNetto+"|"+ArrtmpNewIdSisip[3]+"|"+ArrtmpNewIdSisip[4]+"|"+ArrtmpNewIdSisip[5]+"|"+"1"+"|"+ArrtmpNewIdSisip[6];
							tmpNewRow=tmpNewIdSisip+String.fromCharCode(3)+(rDet.getMaxRow()+1)+String.fromCharCode(3)+ArrtmpNewIdSisip[8]+String.fromCharCode(3)+ArrtmpNewIdSisip[7]+String.fromCharCode(3)+"Racikan "+tRow+" "+bobat+String.fromCharCode(3)+ArrtmpNewIdSisip[9]+String.fromCharCode(3)+FormatNumberFloor(tHNetto,".")+String.fromCharCode(3)+ArrtmpNewIdSisip[3]+String.fromCharCode(3)+FormatNumberFloor(tHJual,".")+String.fromCharCode(3)+FormatNumberFloor(stot,".")+String.fromCharCode(3)+d;
							rDet.AddRowItem(tmpNewRow);
						}
						tmpNewIdSisip_lstNewObat="";
					}
				}
			}
		}else if (document.getElementById('trFarmasi').style.visibility=="visible"){
			act="act=kirimUnit&idunitRujuk="+document.getElementById('IdFarmasiRujuk').value+"&no_rm="+tmp[3]+"&IdPel="+tmp[4];
			url="../transaksi/utils.php?"+act+"&grd=true&no_resep="+no_resep+"&status="+document.getElementById('cmbDilayani').value+"&idunit=<?php echo $idunit; ?>&iduser=<?php echo $iduser; ?>&tanggal="+document.getElementById('txtTgl').value;
			if (confirm('Yakin Ingin Mengirim Resep ke Unit Lain ?')){
				r.loadURL(url,"","GET");
				//document.getElementById('popGrPet').popup.hide();
			}
		}else if (document.getElementById('trCaraBayar').style.visibility=="visible"){
			act="act=UbahCaraBayar&newIdCarabayar="+document.getElementById('IdCaraBayar').value+"&no_rm="+tmp[3]+"&IdPel="+tmp[4];
			url="../transaksi/utils.php?"+act+"&grd=true&no_resep="+no_resep+"&status="+document.getElementById('cmbDilayani').value+"&idunit=<?php echo $idunit; ?>&iduser=<?php echo $iduser; ?>&tanggal="+document.getElementById('txtTgl').value;
			if (confirm('Yakin Ingin Mengubah Cara Bayar Pasien ?')){
				r.loadURL(url,"","GET");
				//document.getElementById('popGrPet').popup.hide();
			}
		}else{
			act="act=UbahKepemilikan&newIdKepemilikan="+document.getElementById('IdKepemilikan').value+"&no_rm="+tmp[3]+"&IdPel="+tmp[4];
			url="../transaksi/utils.php?"+act+"&grd=true&no_resep="+no_resep+"&status="+document.getElementById('cmbDilayani').value+"&idunit=<?php echo $idunit; ?>&iduser=<?php echo $iduser; ?>&tanggal="+document.getElementById('txtTgl').value;
			if (confirm('Yakin Ingin Mengubah Kepemilikan Obat ?')){
				r.loadURL(url,"","GET");
				//document.getElementById('popGrPet').popup.hide();
			}
		}
		
		document.getElementById('popGrPet').popup.hide();
		clearTimeout(fReload);
		fReload=setTimeout("AutoRefresh()", 120000);
	}
	
	function KirimUnit(){
		//alert('kirim unit lain');
		document.getElementById('trFarmasi').style.visibility="visible";
		document.getElementById('trCaraBayar').style.visibility="collapse";
		document.getElementById('trKepemilikan').style.visibility="collapse";
		document.getElementById('trObat').style.visibility="collapse";
		document.getElementById('trchRacikan').style.visibility="collapse";
		document.getElementById('trRacikan').style.visibility="collapse";
		document.getElementById('trQtyObat').style.visibility="collapse";
		document.getElementById('trDosis').style.visibility="collapse";
		document.getElementById('trlstNewObat').style.visibility="collapse";
		document.getElementById('tambah').style.display="none";
		new Popup('popGrPet',null,{modal:true,position:'center',duration:1});
		document.getElementById('popGrPet').popup.show();
		document.getElementById('newObat').focus();
		
		clearTimeout(fReload);
		fReload=setTimeout("AutoRefresh()", 120000);
	}
	
	function AddItemObatKlik(){
	var tmp=r.getRowId(r.getSelRow()).split('|');
		//alert('edit obat : '+p);
		tAct="add";
		kpPop=tmp[1];
		document.getElementById('trFarmasi').style.visibility="collapse";
		document.getElementById('trCaraBayar').style.visibility="collapse";
		document.getElementById('trKepemilikan').style.visibility="collapse";
		document.getElementById('trObat').style.visibility="visible";
		document.getElementById('trchRacikan').style.visibility="visible";
		document.getElementById('trRacikan').style.visibility="collapse";
		document.getElementById('trQtyObat').style.visibility="visible";
		document.getElementById('trDosis').style.visibility="visible";
		document.getElementById('trDosis').style.visibility="visible";
		document.getElementById('trlstNewObat').style.visibility="collapse";
		document.getElementById('tambah').style.display="none";
		document.getElementById('newObat').value="";
		document.getElementById('newQtyObat').value="";
		tmpNewIdSisip_lstNewObat="";
		new Popup('popGrPet',null,{modal:true,position:'center',duration:1});
		document.getElementById('popGrPet').popup.show();
		document.getElementById('newObat').focus();
		
		clearTimeout(fReload);
		fReload=setTimeout("AutoRefresh()", 120000);
	}
	
	function CekRacikan(obj){
		if (obj.checked){
			document.getElementById('satuanRacikan').style.visibility='visible';
			document.getElementById('trRacikan').style.visibility='visible';
			document.getElementById('trJmlBahan').style.visibility='visible';
		}else{
			document.getElementById('satuanRacikan').style.visibility='collapse';
			document.getElementById('trRacikan').style.visibility='collapse';
			document.getElementById('trJmlBahan').style.visibility='collapse';
		}
	}
	
	function gantiDosis(c){
		if(c.checked){
			document.getElementById('spnKetDosis').innerHTML='<input id="txtDosis" name="txtDosis" size="30" class="txtinput">';
			document.getElementById('txtDosis').focus();
		}
		else{
			document.getElementById('spnKetDosis').innerHTML='<select id="txtDosis" name="txtDosis" class="txtinput"><?php 
															$sql="SELECT * FROM $dbapotek.a_dosis WHERE aktif=1";
															$rs=mysqli_query($konek,$sql);
															while ($rw=mysqli_fetch_array($rs)){
															?><option value="<?php echo $rw['nama']; ?>"><?php echo $rw['nama']; ?></option><?php 
															}
															?></select>';
		}
	}
	
	function tampil(){
		var data = document.getElementById('spanSuk').innerHTML;
		//alert(data[0]);
		if (data!=""){
			if (rDet.obj.childNodes[0].childNodes[iRow].childNodes[9].childNodes[0].checked){
				rDet.obj.childNodes[0].childNodes[iRow].childNodes[9].childNodes[0].checked=false;
			}else{
				rDet.obj.childNodes[0].childNodes[iRow].childNodes[9].childNodes[0].checked=true;
			}
			alert("Terjadi Error !");
		}
	}
	
	function goFilterAndSort(grd){
		var url;
		//alert(grd);
		if (grd=="gridbox"){
			url="../transaksi/utils.php?grd=true&tanggal="+document.getElementById('txtTgl').value+"&status="+document.getElementById('cmbDilayani').value+"&idunit=<?php echo $idunit; ?>"+"&filter="+r.getFilter()+"&sorting="+r.getSorting()+"&page="+r.getPage();
			//alert(url);
			r.loadURL(url,"","GET");
		}else if (grd=="gridboxDet"){
			var no_resep = r.cellsGetValue(r.getSelRow(),2);
			var www = r.getRowId(r.getSelRow()).split('|');
			var kepemilikan = www[1];
			url="../transaksi/utils.php?grdDet=true&tanggal="+document.getElementById('txtTgl').value+"&no_resep="+no_resep+"&idunit=<?php echo $idunit; ?>&kepemilikanId="+kepemilikan+"&filter="+rDet.getFilter()+"&sorting="+rDet.getSorting()+"&page="+rDet.getPage();
			rDet.loadURL(url,"","GET");
		}
		clearTimeout(fReload);
		fReload=setTimeout("AutoRefresh()", 120000);
	}
		
	r=new DSGridObject("gridbox");
	r.setHeader("DATA PASIEN");
	r.setColHeader("NO,NO RESEP,NO RM,NAMA PASIEN,TEMPAT LAYANAN,CARA BAYAR,KEPEMILIKAN,PENJAMIN PASIEN");
	r.setIDColHeader(",no_resep,no_rm,nama_pasien,unit,cara_bayar,kepemilikan,kso");
	r.setColWidth("30,60,70,200,150,80,100,200");
	r.setCellAlign("center,center,center,left,center,center,center,center");
	r.setCellType("txt,txt,txt,txt,txt,txt,txt,txt");
	r.setCellHeight(20);
	r.setImgPath("../icon");
	r.setIDPaging("paging");
	r.attachEvent("onRowClick","ambilData");
	r.onLoaded(ambilData);
	r.baseURL("../transaksi/utils.php?grd=true&tanggal="+document.getElementById('txtTgl').value+"&idunit=<?php echo $idunit; ?>"+"&status="+document.getElementById('cmbDilayani').value);
	r.Init();
	
	rDet=new DSGridObject("gridboxDet");
	rDet.setHeader("DATA RESEP PASIEN");
	rDet.setColHeader("NO,NAMA OBAT,DOSIS/KET,RACIK,STOK,HARGA NETTO,JML,HARGA SATUAN,SUBTOTAL,PROSES");
	//rDet.setSubTotal(",,,,,,,Total :&nbsp;,0,");
	rDet.setIDColHeader(",,,,,,,,,");
	rDet.setColWidth("30,200,150,150,50,70,50,70,80,60");
	rDet.setCellAlign("center,left,left,center,center,right,center,right,right,center");
	//rDet.setSubTotalAlign("center,center,left,center,center,right,center,right,right,center");
	rDet.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
	rDet.setCellHeight(20);
	rDet.setImgPath("../icon");
	rDet.onLoaded(HitungTot);
	//rDet.setIDPaging("pagingDet");
	//rDet.attachEvent("onRowClick","prosesData");
	rDet.baseURL("../transaksi/utils.php?grdDet=true&tanggal="+document.getElementById('txtTgl').value+"&idunit=<?php echo $idunit; ?>");
	rDet.Init();
	
	var fReload;
	
	function AutoRefresh(){
		goFilterAndSort("gridbox");
		fReload=setTimeout("AutoRefresh()", 120000);
	}
	
	fReload=setTimeout("AutoRefresh()", 120000);
</script>
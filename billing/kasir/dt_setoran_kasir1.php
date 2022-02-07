<?php
//include("../koneksi/konek.php");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));

$sql="select * from b_ms_pegawai where id = '".$_SESSION['userId']."'";
$rs=mysql_query($sql);
$rw=mysql_fetch_array($rs);

$nama_user=$rw['nama'];

$sql="SELECT id FROM b_ms_group_petugas mgp WHERE mgp.ms_pegawai_id='".$_SESSION['userId']."' AND ms_group_id='133'";
$rsGrp=mysql_query($sql);
$isVerifKasir=0;
$attReadOnly=" readonly";
if (mysql_num_rows($rsGrp)>0){
	$isVerifKasir=1;
	$attReadOnly="";
}
?>

<body>
<script type="text/JavaScript">
	var arrRange = depRange = [];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
id="sort"
src="../theme/dsgrid_sort.php" scrolling="no"
frameborder="0"
style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center" style="width:1000px;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td>
                <table width="100%">
                	<tr>
                		<td>&nbsp;</td>
                	</tr>
                	<tr>
                		<td align="center">
                			<table width="100%" border="0">
                			<tr>
                				<td colspan="3">
                					<fieldset>
                					<div id="ajax" name="ajax" style="display:none" ></div>		
                					<legend style="color:#0033FF;">Setoran Kasir</legend>
                					<table>
                						<tr>
                                        	<td>Tgl Transaksi</td>
                                            <td>: <input tabindex="2" onChange="getChange()" id="txtTglAwal" name="txtTglAwal" size="10" class="txtcenter" value="<?php echo $date_now;?>" onFocus="this.select();" onBlur="if(this.value==''){this.value='<?php echo $date_now;?>'}" onKeyUp="if(event.which==13){ cariLagi(); } else{}"/>
                    <img alt="tglAwal" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/simrs-pelindo/billing/icon/archive1.gif" onClick="gfPop.fPopCalendar(document.getElementById('txtTglAwal'),depRange,getChange);" style="cursor: pointer"/>
                    &nbsp;s/d :&nbsp;                                    
                    <input tabindex="3" onChange="getChange()" id="txtTglAkhir" name="txtTglAkhir"  size="10" class="txtcenter" value="<?php echo $date_now;?>" onFocus="this.select();" onBlur="if(this.value==''){this.value='<?php echo $date_now;?>'}" onKeyUp="if(event.which==13){ cariLagi(); } else{}"/>
                    <img alt="tglAkhir" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/simrs-pelindo/billing/icon/archive1.gif" onClick="gfPop.fPopCalendar(document.getElementById('txtTglAkhir'),depRange,getChange);" style="cursor: pointer"/>
                							</td>
                                            <td width="100">&nbsp;</td>
                                            <td>Tgl Setor</td>
                                            <td>: <input tabindex="2" onChange="getChange()" id="txtTglSetor" name="txtTglSetor" size="10" class="txtcenter" value="<?php echo $date_now;?>" onFocus="this.select();" onBlur="if(this.value==''){this.value='<?php echo $date_now;?>'}" onKeyUp="if(event.which==13){ cariLagi(); } else{}"/>
                    <img alt="tglSetor" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/simrs-pelindo/billing/icon/archive1.gif" onClick="gfPop.fPopCalendar(document.getElementById('txtTglSetor'),depRange,getChange);" style="cursor: pointer"/></td>
                						</tr>
                						<tr>
                                        	<td>Nama Kasir</td>
                                            <td>: <input type="hidden" value="<?=$_SESSION['userId'];?>" id="id_penyetor" name="id_penyetor" /><input type="text" id="nm_penyetor" <?php echo $attReadOnly; ?> name="nm_penyetor" value="<?=$nama_user;?>" size="35" onKeyUp="listKasir(event,'show',this.value)" /><div id="div_kasir" align="center" class="div_pasien"></div></td>
                							<td width="100">&nbsp;</td>
											<td>No. Slip Setor</td>
											<td>: <input type="number" name="noslipsetor" id="noslipsetor" value="1" style="text-align:right; width:40px;" onChange="if(this.value < 1 || this.value % 1 != 0 || this.value.indexOf('.') != -1 ){alert('Maaf Tidak Boleh Kurang dari 1 dan Tidak Boleh Angka Desimal!'); this.value = 1;}"/></td>
                                      	</tr>
										<tr>
											<td colspan="2"></td>
											<td width="100">&nbsp;</td>
											<td colspan="2">
											<button type="submit" id="btnCetak" name="btnCetak" style="cursor:pointer" onClick="cetak()">Cetak</button>
												<!--button type="submit" id="btnCetak" name="btnCetak" style="cursor:pointer" onClick="kwitansi()">Cetak Kwitansi</button-->
											</td>
										</tr>
                					</table>
                					</fieldset>
                          		</td>
                			</tr>
                			<tr>
                				<td>
                				<fieldset>				
                                <legend style="color:#0033FF;">Penerimaan Belum Disetor</legend>
                                <div id="gridkiri" style="width:450px; height:370px; background-color:white; overflow:hidden;"></div>
                                <div id="pagingb_kiri" style="width:450px;"></div>
                                <div id="total_kiri" style="width:450px;" align="right">TOTAL : 0</div>
                                </fieldset>
                				</td>
                				<td>
                				<input type="button" id="getKirib_kiri" name="getKirib_kiri" value=">>" onClick="getKirib_kiri()" />
                				<br /><br />
                				<input type="button" id="getkanan" name="getkanan" value="<<" onClick="getKananb_kiri()" />
                				</td>
                				<td>
                				<fieldset>				
                				<legend style="color:#0033FF;">Penerimaan Sudah Disetor</legend>
                				<div id="gridkanan" style="width:450px; height:370px; background-color:white; overflow:hidden;"></div>
                				<div id="pagingb_kanan" style="width:450px;"></div>
                                <div id="total_kanan" style="width:450px;" align="right">TOTAL : 0</div>
                				</fieldset>
                				</td>
                			</tr>
                            </table>
                		</td>
                	</tr>
                	<tr>
                    	<td>&nbsp;</td>
                	</tr>
                </table>
    		</td>
        </tr>
    </table>
</div>
<script>
var utils ='';

function cetak(){
	window.open('cetak_setoran.php?tgl='+document.getElementById('txtTglSetor').value+'&kasir='+document.getElementById("id_penyetor").value+"&filter="+b_kanan.getFilter());
}
function kwitansi(){
	window.open('kwitansi.php?tgl='+document.getElementById('txtTglSetor').value+'&kasir='+document.getElementById("id_penyetor").value+"&filter="+b_kanan.getFilter());
}
function getChange(){
	utils= "&tgl_a="+document.getElementById("txtTglAwal").value+"&tgl_b="+
	document.getElementById("txtTglAkhir").value+"&tgl_setor="+
	document.getElementById("txtTglSetor").value+"&user_setor="+document.getElementById("id_penyetor").value;
	//alert(utils);
	b_kiri.loadURL("setoran_kasir_util.php?grd=kiri"+utils,"","GET");
	b_kanan.loadURL("setoran_kasir_util.php?grd=kanan"+utils,"","GET");
}

function isiCombo(id,val,defaultId,targetId,evloaded){
	if(targetId=='' || targetId==undefined)
	{
		targetId=id;
	}
	Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,id,'','GET',evloaded);
}

function isiCombo1(id,val,defaultId,targetId,evloaded){
	if(targetId=='' || targetId==undefined)
	{
		targetId=id;
	}
	Request('../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,id,'','GET',evloaded);
}

var b_kanan='';
var b_kiri='';
function firstData(){
	utils= "&tgl_a="+document.getElementById("txtTglAwal").value+"&tgl_b="+
	document.getElementById("txtTglAkhir").value+"&tgl_setor="+
	document.getElementById("txtTglSetor").value+"&user_setor="+document.getElementById("id_penyetor").value;
	
	b_kiri = new DSGridObject("gridkiri");
	b_kiri.setHeader(" ",false);
	b_kiri.setColHeader("No,<input type='checkbox' id='check_kiri' name='check_kanan' onclick='selectallb_kiri(this.checked)' />,Tgl Bayar,No Kwi,No RM,Pasien,Nilai");
	b_kiri.setIDColHeader(",,,no_kwitansi,no_rm,nama,nilai");
	b_kiri.setColWidth("50,20,130,100,100,200,100");
	b_kiri.setCellAlign("center,center,center,center,center,left,center");
	b_kiri.setCellType("txt,chk,txt,txt,txt,txt,txt");
	b_kiri.setCellHeight(20);
	b_kiri.setImgPath("../icon");
	b_kiri.setIDPaging("pagingb_kiri");
	b_kiri.onLoaded(konfirmasi);
	b_kiri.attachEvent("onRowClick","getID");
	b_kiri.baseURL("setoran_kasir_util.php?grd=kiri"+utils);
	b_kiri.Init();
	
	b_kanan = new DSGridObject("gridkanan");
	b_kanan.setHeader(" ",false);
	b_kanan.setColHeader("No,<input type='checkbox' id='check_kanan' name='check_kanan' onclick='selectallb_kirids(this.checked)' />,Tgl Bayar,No Kwi,Tgl Setor,No RM,Pasien,Slip ke,Nilai,Disetor Oleh");
	b_kanan.setIDColHeader(",,,no_kwitansi,,no_rm,nama,slip_ke,nilai,nm_pegawai");
	b_kanan.setColWidth("40,20,130,100,75,80,200,50,100,100");
	b_kanan.setCellAlign("center,center,center,center,center,center,left,center,right,right");
	b_kanan.setCellType("txt,chk,txt,txt,txt,txt,txt,txt,txt,txt");
	b_kanan.setCellHeight(20);
	b_kanan.setImgPath("../icon");
	b_kanan.setIDPaging("pagingb_kanan");
	b_kanan.onLoaded(konfirmasi);
	b_kanan.attachEvent("onRowClick","getID");
	b_kanan.baseURL("setoran_kasir_util.php?grd=kanan"+utils);
	b_kanan.Init();	
}		
		
function goFilterAndSort(abc){
	utils= "&tgl_a="+document.getElementById("txtTglAwal").value+"&tgl_b="+
	document.getElementById("txtTglAkhir").value+"&tgl_setor="+
	document.getElementById("txtTglSetor").value+"&user_setor="+document.getElementById("id_penyetor").value;
	
	if (abc=="gridkiri"){
		b_kiri.loadURL("setoran_kasir_util.php?grd=kiri"+utils+"&filter="+b_kiri.getFilter()+"&sorting="+b_kiri.getSorting()+"&page="+b_kiri.getPage(),"","GET");
	}
	else if (abc=="gridkanan"){
		b_kanan.loadURL("setoran_kasir_util.php?grd=kanan"+utils+"&filter="+b_kanan.getFilter()+"&sorting="+b_kanan.getSorting()+"&page="+b_kanan.getPage(),"","GET");
	}
} 
		
function konfirmasi(key,val){
	
	var data=val.split(String.fromCharCode(1));
	if (val!=undefined){
		if(data[0]=='kiri'){
			document.getElementById('total_kiri').innerHTML="TOTAL : "+data[1];	
		}
		else if(data[0]=='kanan'){
			document.getElementById('total_kanan').innerHTML="TOTAL : "+data[1];
		}
	}
}
	
function getID(){
	
}

var data='';
function kirimkiri(){
	data='';
	for(var r = 0; r<b_kiri.getMaxRow();r++){
		var px = "nb_kiri"+r; 
		if(document.getElementById(px).checked){
			data += document.getElementById(px).value+"|";
		}
	}
}

function kirimkanan(){
	data='';
	for(var r = 0; r<b_kanan.getMaxRow();r++){
		var px = "nb_kanan"+r; 
		if(document.getElementById(px).checked){
			data += document.getElementById(px).value+"|";
		}
	}
}
	
function getKirib_kiri(){
	var data='';
	var nss = document.getElementById('noslipsetor').value; // No Slip Setor
	for(var r = 0; r<b_kiri.getMaxRow();r++){
		if(b_kiri.obj.childNodes[0].childNodes[r].childNodes[1].childNodes[0].checked){
			var zxc = b_kiri.getRowId(r+1);
			data += zxc+"|";	
		}
	}
	//alert(nss);
	Request("setoran_kasir_util.php?grd=kiri"+utils+"&act=kiri&data="+data+"&nss="+nss,"ajax","","GET",function(){
		document.getElementById('check_kiri').checked=false;
		document.getElementById('check_kanan').checked=false;
		b_kiri.loadURL("setoran_kasir_util.php?grd=kiri"+utils,"","GET");
		b_kanan.loadURL("setoran_kasir_util.php?grd=kanan"+utils,"","GET");
	});
}

function getKananb_kiri(){
	var data='';
	var nss = document.getElementById('noslipsetor').value; // No Slip Setor
	for(var r = 0; r<b_kanan.getMaxRow();r++){
		var px = "nb_kanan"+r;
		if(b_kanan.obj.childNodes[0].childNodes[r].childNodes[1].childNodes[0].checked){
			var zxc = b_kanan.getRowId(r+1);
			data += zxc+"|";	
		}
	}
	//alert(nss);
	//alert("setoran_kasir_util.php?grd=kiri"+utils+"&act=kanan&data="+data);
	Request("setoran_kasir_util.php?grd=kiri"+utils+"&act=kanan&data="+data+"&nss="+nss,"ajax","","GET",function(){
		document.getElementById('check_kiri').checked=false;
		document.getElementById('check_kanan').checked=false;
		b_kiri.loadURL("setoran_kasir_util.php?grd=kiri"+utils,"","GET");
		b_kanan.loadURL("setoran_kasir_util.php?grd=kanan"+utils,"","GET");
	});	
}
	
function selectallb_kiri(ac){
	for (var i=0;i<b_kiri.getMaxRow();i++){
		b_kiri.obj.childNodes[0].childNodes[i].childNodes[1].childNodes[0].checked=ac;
	}
}

function selectallb_kirids(ac){
	for (var i=0;i<b_kanan.getMaxRow();i++){
		b_kanan.obj.childNodes[0].childNodes[i].childNodes[1].childNodes[0].checked=ac;
	}
}

firstData();

var RowIdx;
var fKeyEnt;
var cari=0;
var keyword='';
function listKasir(feel,how,stuff){	
	if(how=='show'){
		if(feel.which==13  && keyword!=stuff){
			keyword=stuff;
			document.getElementById('div_kasir').style.display='block';
			Request('kasir_list.php?act=cari&keyword='+stuff,'div_kasir','','GET');
			RowIdx=0;
		}
		else if ((feel.which==38 || feel.which==40) && document.getElementById('div_kasir').style.display=='block'){
			//alert(feel.which);
			var tblRow=document.getElementById('kasir_table').rows.length;
			if (tblRow>0){
				//alert(RowIdx);
				if (feel.which==38 && RowIdx>0){
					RowIdx=RowIdx-1;
					document.getElementById(RowIdx+1).className='itemtableReq';
					if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
				}else if (feel.which == 40 && RowIdx < tblRow){
					RowIdx=RowIdx+1;
					if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
					document.getElementById(RowIdx).className='itemtableMOverReq';
				}
			}
		}
		else if (feel.which==13 && keyword==stuff && RowIdx>0){
			setKasir(document.getElementById(RowIdx).lang);
			keyword='';
		}
		if(feel.which==27 || stuff==''){
			document.getElementById('div_kasir').style.display='none';
		}
	}
}

var dataKasir = new Array();
//kurangnya: setelah delete pelayanan,jika pelayanan ga ada lagi,ga mau langsung delete kunjungan.
function setKasir(val)
{
	if(val == undefined || val == ''){
		dataKasir=document.getElementById('div_kasir').innerHTML.split("|");
	}
	else{
		dataKasir=val.split("|");
	}
	document.getElementById("id_penyetor").value=dataKasir[0];
	document.getElementById("nm_penyetor").value=dataKasir[1];
	document.getElementById('div_kasir').style.display='none';
	getChange();
}

</script>
</body>


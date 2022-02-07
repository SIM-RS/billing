<?
include("../sesi.php");
?>
<?php
//session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>

<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
<script type="text/javascript" src="../theme/js/tab-view.js"></script>
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<title>Form Penjamin</title>
</head>

<body>
<div align="center">
<?php
	include("../header1.php");
	include("../koneksi/konek.php");
	
	
?>
<script>
var arrRange=depRange=[];
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
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;FORM PENJAMIN</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="hidden" id="ksoId"/></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><div class="TabView" id="TabView" style="width: 940px; height: 500px;"></div></td>
  </tr>
 
  </table>
<table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
  	<td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
	<td>&nbsp;</td>
	<td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a>&nbsp;</td>
  </tr>
</table>
</div>
</body>
<script>
	var idKso,idPaket;
	var mTab=new TabView("TabView");
	mTab.setTabCaption("DATA PENJAMIN,LAYANAN TIDAK DIJAMIN,PAKET HP,PAKET TINDAKAN,TINDAKAN LUAR PAKET,PAKET AKOMODASI");
	mTab.setTabCaptionWidth("140,174,157,157,157,156");
	mTab.setTabDisplay("true,true,true,true,true,true,0");
	mTab.onLoaded(showgrid);
	mTab.setTabPage("penjamin_tab1.php,penjamin_tab2.php,penjamin_tab3.php,penjamin_tab4.php,penjamin_tab5.php,penjamin_tab6.php");
	
	//tabview_width("TabView","60,90,60");
	
	function simpan(action)
	{
		if(ValidateForm('txtPenjamin,txtAlmt,txtTlp,txtTlp,txtFax,txtKontak','ind'))
		{
			var id = document.getElementById("txtId").value;
			var nama = document.getElementById("txtPenjamin").value;
			var almt = document.getElementById("txtAlmt").value;
			var telp = document.getElementById("txtTlp").value;
			var fax = document.getElementById("txtFax").value;
			var kontak = document.getElementById("txtKontak").value;
			
			//alert("penjamin_utils.php?grd=true&act="+action+"&id="+id+"&kode=<?php echo $rw['kode']; ?>&nama="+nama+"&alamat="+almt+"&telp="+telp+"&fax="+fax+"&kontak="+kontak);
			a.loadURL("penjamin_utils.php?grd=1&act="+action+"&id="+id+"&kode=<?php echo $rw['kode']; ?>&nama="+nama+"&alamat="+almt+"&telp="+telp+"&fax="+fax+"&kontak="+kontak,"","GET");
			
			isiCombo('StatusPas','',idKso,'cmbKso',loadLayananTdkJamin);
			isiCombo('StatusPas','',idKso,'cmbKsoHP',loadPaketHP);
			isiCombo('StatusPas','',idKso,'cmbKsoDataPaket',loadDataPaket);
			isiCombo('StatusPas','',idKso,'cmbKsoPaket');
			isiCombo('StatusPas','',idKso,'cmbKsoLuarPaket');
			
			document.getElementById("txtPenjamin").value = '';
			document.getElementById("txtAlmt").value = '';
			document.getElementById("txtTlp").value = '';
			document.getElementById("txtFax").value = '';
			document.getElementById("txtKontak").value = '';
		}
	}

	function ambilData()
	{		
		var p="txtId*-*"+(a.getRowId(a.getSelRow()))+"*|*txtPenjamin*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*txtAlmt*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*txtTlp*-*"+a.cellsGetValue(a.getSelRow(),4)+"*|*txtFax*-*"+a.cellsGetValue(a.getSelRow(),5)+"*|*txtKontak*-*"+a.cellsGetValue(a.getSelRow(),6)+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
		fSetValue(window,p);
		
		document.getElementById('ksoId').value=a.getRowId(a.getSelRow());
		//idKso=document.getElementById('ksoId').value;
		//c.loadURL("penjamin_utils.php?grd=3&ksoId="+idKso,"","GET");
		//b.loadURL("penjamin_utils.php?grd=2&ksoId="+idKso,"","GET");
		//e.loadURL("penjamin_utils.php?grd=5&&ksoId="+idKso,"","GET");		
	}


	function hapus()
	{
		var rowid = document.getElementById("txtId").value;
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if(confirm("Anda yakin menghapus Penjamin "+a.cellsGetValue(a.getSelRow(),2)))
		{
			a.loadURL("penjamin_utils.php?grd=1&act=hapus&rowid="+rowid,"","GET");
		}
		
		document.getElementById("txtPenjamin").value = '';
		document.getElementById("txtAlmt").value = '';
		document.getElementById("txtTlp").value = '';
		document.getElementById("txtFax").value = '';
		document.getElementById("txtKontak").value = '';
	}
	
	function batal()
	{
		var p="txtId*-**|*txtPenjamin*-**|*txtAlmt*-**|*txtTlp*-**|*txtFax*-**|*txtKontak*-**|*btnSimpan*-*Tambah*|*btnHapus*-*true";
		fSetValue(window,p);		
	}
	
	
	
	
	var idTin='';
	function pindahKanan(){
		if(document.getElementById('cmbKso').value=='' ){
			alert('silakan pilih penjamin dahulu!');
		}
		else{
			for(var i=0;i<b.obj.childNodes[0].rows.length;i++){
				if(b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
					idTin+=b.getRowId(parseInt(i)+1)+',';	
				}
			}
			//alert(idTin);
			var idKso=document.getElementById('cmbKso').value;
			if(idTin==''){
				alert("Silakan pilih tindakan!");
			}
			else{
			//alert("penjamin_utils.php?grd=3&act=tambah&id="+idTin+"&ksoId="+idKso);
			
			c.loadURL("penjamin_utils.php?grd=3&act=tambah&id="+idTin+"&ksoId="+idKso,"","GET");
			b.loadURL("penjamin_utils.php?grd=2&ksoId="+idKso,"","GET");
			idTin='';
			}
		}
		
	}
	var idTdk='';
	function pindahKiri(){
		if(document.getElementById('cmbKso').value=='' ){
			alert('silakan pilih penjamin dahulu!');
		}
		else{
			for(var i=0;i<c.obj.childNodes[0].rows.length;i++){
				if(c.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
					idTdk+=c.getRowId(parseInt(i)+1)+',';	
				}
			}
			//alert(idTin);
			var idKso=document.getElementById('cmbKso').value;
			if(idTdk==''){
				alert("Silakan pilih tindakan!");
			}
			else{
			//alert("penjamin_utils.php?grd=3&act=hapus&id="+idTdk+"&ksoId="+idKso);
			
			c.loadURL("penjamin_utils.php?grd=3&act=hapus&id="+idTdk+"&ksoId="+idKso,"","GET");
			b.loadURL("penjamin_utils.php?grd=2&ksoId="+idKso,"","GET");
			idTdk='';
			}
		}		
		
	}
	////////////////////////////////////////////////////
	
	///////////////////////////////////////////////////
	function simpanHP(action){
		if(ValidateForm('txtNilaiJamin','ind'))
		{
			var id = document.getElementById("txtIdHP").value;
			var kelas = document.getElementById("cmbKelasHP").value;
			var nilai = document.getElementById("txtNilaiJamin").value;
			var idKso = document.getElementById("cmbKsoHP").value;
			
			//alert("penjamin_utils.php?grd=5&act="+action+"&ksoId="+idKso+"&id="+id+"&kelas="+kelas+"&nilai="+nilai);
			e.loadURL("penjamin_utils.php?grd=5&act="+action+"&ksoId="+idKso+"&id="+id+"&kelas="+kelas+"&nilai="+nilai,"","GET");
			batalHP();			
		}
	}
	
	function batalHP(){
		var p="txtIdHP*-**|*txtNilaiJamin*-**|*btnSimpanHP*-*Tambah*|*btnHapusHP*-*true";
		fSetValue(window,p);			
	}
	
	function ambilDataKelasKso(){
		var sisip=e.getRowId(e.getSelRow()).split("|");		
		var p="txtIdHP*-*"+sisip[0]+"*|*txtNilaiJamin*-*"+e.cellsGetValue(e.getSelRow(),2)+"*|*cmbKelasHP*-*"+sisip[1]+"*|*btnSimpanHP*-*Simpan*|*btnHapusHP*-*false";
		fSetValue(window,p);
	}
	
	function hapusHP()
	{
		var rowid = document.getElementById("txtIdHP").value;
		var idKso = document.getElementById("cmbKsoHP").value;
		if(confirm("Anda yakin menghapus paket "+e.cellsGetValue(e.getSelRow(),1)))
		{
			e.loadURL("penjamin_utils.php?grd=5&act=hapus&rowid="+rowid+"&ksoId="+idKso,"","GET");
		}
		batalHP();
	}
	///////////////////////////////////////////////////
	
	///////////////////////////////////////////////////
	function simpanPaket(action){
		if(ValidateForm('txtPaket,txtNilaiPaket,cmbInstalPaket,cmbStatusPaket,cmbFrekPaket','ind'))
		{
			var id = document.getElementById("txtIdPaket").value;
			var nama = document.getElementById("txtPaket").value;
			var nilai = document.getElementById("txtNilaiPaket").value;
			var instal = document.getElementById("cmbInstalPaket").value;
			var status = document.getElementById("cmbStatusPaket").value;
			var frekuensi = document.getElementById("cmbFrekPaket").value;
			var idKso = document.getElementById('cmbKsoPaket').value;
			//alert("penjamin_utils.php?grd=true&act="+action+"&id="+id+"&kode=<?php echo $rw['kode']; ?>&nama="+nama+"&alamat="+almt+"&telp="+telp+"&fax="+fax+"&kontak="+kontak);
			f.loadURL("penjamin_utils.php?grd=6&act="+action+"&ksoId="+idKso+"&id="+id+"&nama="+nama+"&nilai="+nilai+"&instal="+instal+"&status="+status+"&frekuensi="+frekuensi,"","GET");
			batalPaket();			
		}
	}
	
	function hapusPaket()
	{
		var idKso = document.getElementById('cmbKsoDataPaket').value;
		var rowid = document.getElementById("txtIdPaket").value;
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if(confirm("Anda yakin menghapus paket "+f.cellsGetValue(f.getSelRow(),1)))
		{
			f.loadURL("penjamin_utils.php?grd=6&act=hapus&rowid="+rowid+"&ksoId="+idKso,"","GET");
		}
		batalPaket();
	}
	
	function batalPaket(){
		var p="txtIdPaket*-**|*txtPaket*-**|*txtNilaiPaket*-**|*btnTambahPaket*-*Tambah*|*btnHapusPaket*-*true";
		fSetValue(window,p);			
	}
	
	function ambilDataPaket(){
		if(f.getRowId(f.getSelRow())!=''){
			var sisip=f.getRowId(f.getSelRow()).split("|");
			var p="txtIdPaket*-*"+sisip[0]+"*|*txtPaket*-*"+f.cellsGetValue(f.getSelRow(),1)+"*|*txtNilaiPaket*-*"+f.cellsGetValue(f.getSelRow(),2)+"*|*btnTambahPaket*-*Simpan*|*btnHapusPaket*-*false";
			
			fSetValue(window,p);
			if(f.cellsGetValue(f.getSelRow(),4)=='Bebas'){			
				document.getElementById("cmbInstalPaket").value='0';
			}
			else if(f.cellsGetValue(f.getSelRow(),4)=='Rawat Inap'){
				document.getElementById("cmbInstalPaket").value='1';
			}
			else if(f.cellsGetValue(f.getSelRow(),4)=='Non Rawat Inap'){
				document.getElementById("cmbInstalPaket").value='2';
			}
			
			if(f.cellsGetValue(f.getSelRow(),3)=='Global'){
				document.getElementById("cmbStatusPaket").value='0';
			}
			else if(f.cellsGetValue(f.getSelRow(),3)=='Per Item Paket'){
				document.getElementById("cmbStatusPaket").value='1';
			}
			
			if(f.cellsGetValue(f.getSelRow(),5)=='Harian'){
				document.getElementById("cmbFrekPaket").value='0';
			}
			if(f.cellsGetValue(f.getSelRow(),5)=='Bebas'){
				document.getElementById("cmbFrekPaket").value='1';
			}
			
		}else{
			document.getElementById('txtIdPaket').value=0;
		}
		setDetailPaket();
	}
	var idPaket=0;
	function setDetailPaket(){
		
		if(f.getRowId(f.getSelRow())!=''){
			var sisip=f.getRowId(f.getSelRow()).split("|");
			idPaket = sisip[0];
			
		}else{
			idPaket = 0;
		}
		
		h.loadURL("penjamin_utils.php?grd=8&paketId="+idPaket,"","GET");
		g.loadURL("penjamin_utils.php?grd=7&paketId="+idPaket,"","GET");
	}
	
	function hide(state){
		if(state=='tutup'){
			document.getElementById('divFormPaket').style.display='none';
			document.getElementById('btnSetDetailPaket').lang='buka';
			document.getElementById('btnSetDetailPaket').value='Kembali ke form paket';
			document.getElementById('cmbKsoDataPaket').style.display='block';
			document.getElementById('divDetilPaket').style.display='block';
		}
		else{
			document.getElementById('divFormPaket').style.display='block';
			document.getElementById('btnSetDetailPaket').lang='tutup';
			document.getElementById('btnSetDetailPaket').value='Set Detail Paket';
			document.getElementById('cmbKsoDataPaket').style.display='none';
			document.getElementById('divDetilPaket').style.display='none';
		}
	}
	
	var dataTind='';
	function pindahKananPaket(){		
		for(var i=0;i<g.obj.childNodes[0].rows.length;i++){
			if(g.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				dataTind+=g.getRowId(parseInt(i)+1)+',';	
			}
		}
		
		
		if(dataTind==''){
			alert("Silakan pilih tindakan!");
		}
		else{
		//alert("penjamin_utils.php?grd=3&act=tambah&id="+idTin+"&ksoId="+idKso);
		h.loadURL("penjamin_utils.php?grd=8&act=tambah&id="+dataTind+"&paketId="+idPaket,"","GET");
		g.loadURL("penjamin_utils.php?grd=7&paketId="+idPaket,"","GET");
		dataTind='';
		}
	}
	var dataDetil='';
	function pindahKiriPaket(){
		
		for(var i=0;i<h.obj.childNodes[0].rows.length;i++){
			if(h.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				dataDetil+=h.getRowId(parseInt(i)+1)+',';	
			}
		}
		
		if(dataDetil==''){
			alert("Silakan pilih tindakan!");
		}
		else{
			//alert("penjamin_utils.php?grd=5&act=hapus&idKelasKso="+idKelasKso+"&ksoId="+idKso);
			h.loadURL("penjamin_utils.php?grd=8&act=hapus&id="+dataDetil+"&paketId="+idPaket,"","GET");
			g.loadURL("penjamin_utils.php?grd=7&paketId="+idPaket,"","GET");
			dataDetil='';
		}
		
	}
	
	
	//////////////////////////////////////////////////
	////////////DILUAR PAKET//////////////////////////
	
	var dataTindLuar='';
	function pindahLuarPaketKanan(){		
		for(var i=0;i<l.obj.childNodes[0].rows.length;i++){
			if(l.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				dataTindLuar+=l.getRowId(parseInt(i)+1)+',';	
			}
		}
		
		
		if(dataTindLuar==''){
			alert("Silakan pilih tindakan!");
		}
		else{
			//alert("penjamin_utils.php?grd=10&act=tambah&id="+dataTindLuar+"&ksoId="+idKso);
		m.loadURL("penjamin_utils.php?grd=10&act=tambah&id="+dataTindLuar+"&ksoId="+idKso,"","GET");
		l.loadURL("penjamin_utils.php?grd=9&ksoId="+idKso,"","GET");
		dataTindLuar='';
		}
	}
	var dataTindLuarPaket='';
	function pindahLuarPaketKiri(){
		
		for(var i=0;i<m.obj.childNodes[0].rows.length;i++){
			if(m.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				dataTindLuarPaket+=m.getRowId(parseInt(i)+1)+',';	
			}
		}
		
		if(dataTindLuarPaket==''){
			alert("Silakan pilih tindakan!");
		}
		else{
			//alert("penjamin_utils.php?grd=10&act=tambah&id="+dataTindLuar+"&ksoId="+idKso);
			m.loadURL("penjamin_utils.php?grd=10&act=hapus&id="+dataTindLuarPaket+"&ksoId="+idKso,"","GET");
			l.loadURL("penjamin_utils.php?grd=9&ksoId="+idKso,"","GET");
			dataTindLuarPaket='';
		}
		
	}
	function editBiaya(){
		var biaya
		if(biaya=prompt('Edit biaya untuk tindakan '+m.cellsGetValue(m.getSelRow(),2),m.cellsGetValue(m.getSelRow(),3))){
			//alert(biaya);
			var idLuarPaket=m.getRowId(m.getSelRow());
			//alert("penjamin_utils.php?grd=10&act=editbiaya&id="+idLuarPaket+"&biaya="+biaya);
			m.loadURL("penjamin_utils.php?grd=10&act=editBiaya&ksoId="+idKso+"&id="+idLuarPaket+"&biaya="+biaya,"","GET");
		}
	}
	
	var dataAkomodasiKiri='';
	function pindahAkomodasiKanan(){		
		for(var i=0;i<n0.obj.childNodes[0].rows.length;i++){
			if(n0.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				dataAkomodasiKiri+=n0.getRowId(parseInt(i)+1)+',';	
			}
		}
		
		
		if(dataAkomodasiKiri==''){
			alert("Silakan pilih tindakan!");
		}
		else{
			//alert("penjamin_utils.php?grd=10&act=tambah&id="+dataTindLuar+"&ksoId="+idKso);
		n.loadURL("penjamin_utils.php?grd=12&act=tambah&id="+dataAkomodasiKiri+"&ksoId="+idKso,"","GET");
		n0.loadURL("penjamin_utils.php?grd=11&ksoId="+idKso,"","GET");
		dataAkomodasiKiri='';
		}
	}
	var dataAkomodasi='';
	function pindahAkomodasiKiri(){
		
		for(var i=0;i<n.obj.childNodes[0].rows.length;i++){
			if(n.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				dataAkomodasi+=n.getRowId(parseInt(i)+1)+',';	
			}
		}
		
		if(dataAkomodasi==''){
			alert("Silakan pilih tindakan!");
		}
		else{
			//alert("penjamin_utils.php?grd=10&act=tambah&id="+dataTindLuar+"&ksoId="+idKso);
			n.loadURL("penjamin_utils.php?grd=12&act=hapus&id="+dataAkomodasi+"&ksoId="+idKso,"","GET");
			n0.loadURL("penjamin_utils.php?grd=11&ksoId="+idKso,"","GET");
			dataAkomodasi='';
		}
		
	}
	/////////////////////////////////////////////////
	
	function goFilterAndSort(namaGrid){
		//alert(namaGrid);
		if (namaGrid=="gridbox"){
			//alert("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
			a.loadURL("penjamin_utils.php?grd=1&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		}else if (namaGrid=="gridbox2"){
			//alert("penjamin_utils.php?grd=2&ksoId="+idKso+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			b.loadURL("penjamin_utils.php?grd=2&ksoId="+idKso+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
		}else if (namaGrid=="gridbox3"){
			//alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			c.loadURL("penjamin_utils.php?grd=3&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage(),"","GET");
		
		}else if (namaGrid=="gridbox5"){
			//alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			e.loadURL("penjamin_utils.php?grd=5&ksoId="+idKso+"&filter="+e.getFilter()+"&sorting="+e.getSorting()+"&page="+e.getPage(),"","GET");
		}else if (namaGrid=="gridbox6"){
			//alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			f.loadURL("penjamin_utils.php?grd=6&ksoId="+idKso+"&filter="+f.getFilter()+"&sorting="+f.getSorting()+"&page="+f.getPage(),"","GET");
		}else if (namaGrid=="gridbox7"){
			//alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			g.loadURL("penjamin_utils.php?grd=7&paketId="+idPaket+"&filter="+g.getFilter()+"&sorting="+g.getSorting()+"&page="+g.getPage(),"","GET");
		}else if (namaGrid=="gridbox8"){
			//alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			h.loadURL("penjamin_utils.php?grd=8&paketId="+idPaket+"&filter="+h.getFilter()+"&sorting="+h.getSorting()+"&page="+h.getPage(),"","GET");
		}else if (namaGrid=="gridbox9"){
			//alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			l.loadURL("penjamin_utils.php?grd=9&ksoId="+idKso+"&filter="+l.getFilter()+"&sorting="+l.getSorting()+"&page="+l.getPage(),"","GET");
		}else if (namaGrid=="gridbox10"){
			//alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			m.loadURL("penjamin_utils.php?grd=10&ksoId="+idKso+"&filter="+m.getFilter()+"&sorting="+m.getSorting()+"&page="+m.getPage(),"","GET");
		}else if (namaGrid=="gridAkomodasiKiri"){
			//alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			n0.loadURL("penjamin_utils.php?grd=11&ksoId="+idKso+"&filter="+n0.getFilter()+"&sorting="+n0.getSorting()+"&page="+n0.getPage(),"","GET");
		}else if (namaGrid=="gridAkomodasi"){
			//alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			n.loadURL("penjamin_utils.php?grd=12&ksoId="+idKso+"&filter="+n.getFilter()+"&sorting="+n.getSorting()+"&page="+n.getPage(),"","GET");
		}
	}
	
	function isiCombo(id,val,defaultId,targetId,evloaded){
		
		if(targetId=='' || targetId==undefined){
			targetId=id;
		}
		if(document.getElementById(targetId)==undefined){
			alert('Elemen target dengan id: \''+targetId+'\' tidak ditemukan!');
		}else{
			Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
		}
		
	}
			
	function loadLayananTdkJamin(){
		idKso=document.getElementById('cmbKso').value;
		b.loadURL("penjamin_utils.php?grd=2&ksoId="+idKso,"","GET");
		c.loadURL("penjamin_utils.php?grd=3&ksoId="+idKso,"","GET");
	}
	
	function loadPaketHP(){
		idKso=document.getElementById('cmbKsoHP').value;
		e.loadURL("penjamin_utils.php?grd=5&ksoId="+idKso,"","GET");
	}
	
	function loadDataPaket(){
		idKso=document.getElementById('cmbKsoDataPaket').value;		
		f.loadURL("penjamin_utils.php?grd=6&ksoId="+idKso,"","GET");
	}
	function loadLuarPaket(){
		idKso=document.getElementById('cmbKsoLuarPaket').value;
		l.loadURL("penjamin_utils.php?grd=9&ksoId="+idKso,"","GET");
		m.loadURL("penjamin_utils.php?grd=10&ksoId="+idKso,"","GET");
	}
	function loadAkomodasi(){
		idKso=document.getElementById('cmbKsoAkomodasi').value;
		n0.loadURL("penjamin_utils.php?grd=11&ksoId="+idKso,"","GET");
		n.loadURL("penjamin_utils.php?grd=12&ksoId="+idKso,"","GET");
	}
	
	var a,b,c,e,f,g,h,l,m;
	function showgrid(){
		isiCombo('cmbKelas','','','cmbKelasHP');
		isiCombo('StatusPas','',idKso,'cmbKso',loadLayananTdkJamin);
		isiCombo('StatusPas','',idKso,'cmbKsoHP',loadPaketHP);
		isiCombo('StatusPas','',idKso,'cmbKsoDataPaket',loadDataPaket);
		isiCombo('StatusPas','',idKso,'cmbKsoPaket');
		isiCombo('StatusPas','',idKso,'cmbKsoLuarPaket');
		isiCombo('StatusPas','',idKso,'cmbKsoAkomodasi');
		
		a=new DSGridObject("gridbox");
		a.setHeader("DATA PENJAMIN");	
		a.setColHeader("KODE,NAMA PENJAMIN,ALAMAT,TELEPON,FAX,KONTAK");
		a.setIDColHeader("kode,nama,,,,");
		a.setColWidth("50,250,300,100,100,100");
		a.setCellAlign("center,left,left,left,left,left");
		a.setCellHeight(20);
		a.setImgPath("../icon");
		a.setIDPaging("paging");
		a.attachEvent("onRowClick","ambilData");
		a.baseURL("penjamin_utils.php?grd=1");
		a.Init();
		
		
		
		b=new DSGridObject("gridbox2");
		b.setHeader("DATA TINDAKAN");	
		b.setColHeader("Pilih,Nama Tindakan,Kelompok,Klasifikasi");
		b.setIDColHeader("pil,Nama,kelompok,klasifikasi");
		b.setColWidth("60,340,100,100");
		b.setCellAlign("center,left,center,center");
		b.setCellType("chk,txt,txt,txt");
		b.setCellHeight(20);
		b.setImgPath("../icon");
		b.setIDPaging("paging2");
		//b.attachEvent("onRowClick","ambilDataTindakan");
		b.baseURL("penjamin_utils.php?grd=2&ksoId="+idKso);
		b.Init();
		
		c=new DSGridObject("gridbox3");
		c.setHeader("Layanan Tidak Dijamin");	
		c.setColHeader("Pilih,Tindakan,Kelompok,Klasifikasi");
		c.setIDColHeader(",nama,kelompok,klasifikasi");
		c.setColWidth("60,300,100,100");
		c.setCellAlign("center,left,center,center");
		c.setCellType("chk,txt,txt,txt");
		c.setCellHeight(20);
		c.setImgPath("../icon");
		c.setIDPaging("paging3");
		//c.attachEvent("onRowClick","ambilDataTdk");
		c.baseURL("penjamin_utils.php?grd=3&ksoId="+idKso);
		c.Init();		
		
		
		e=new DSGridObject("gridbox5");
		e.setHeader("Kelas Yang dipilih");	
		e.setColHeader("Kelas,Jaminan");
		e.setIDColHeader(",nama");
		e.setColWidth("100,460");
		e.setCellAlign("center,left");
		e.setCellType("txt,txt");
		e.setCellHeight(20);
		e.setImgPath("../icon");
		e.setIDPaging("paging5");
		e.attachEvent("onRowClick","ambilDataKelasKso");
		e.baseURL("penjamin_utils.php?grd=5&ksoId="+idKso);
		e.Init();
		
		idKso = document.getElementById('cmbKsoDataPaket').value;
		f=new DSGridObject("gridbox6");
		f.setHeader("PAKET");	
		f.setColHeader("Nama Paket,Nilai,Status Paket,Instalasi,Frekuensi");
		f.setIDColHeader("nama,nilai,paket,instalasi,frekuensi");
		f.setColWidth("200,100,100,100,100");
		f.setCellAlign("left,right,center,center,center");
		f.setCellType("txt,txt,txt,txt,txt");
		f.setCellHeight(20);
		f.setImgPath("../icon");
		f.setIDPaging("paging6");
		f.attachEvent("onRowClick","ambilDataPaket");
		f.onLoaded(setDetailPaket);
		f.baseURL("penjamin_utils.php?grd=6&ksoId="+idKso);
		f.Init();
		
		g=new DSGridObject("gridbox7");
		g.setHeader("Tindakan");	
		g.setColHeader("Pilih,Nama tindakan,Kelompok,Klasifikasi");
		g.setIDColHeader(",nama,kelompok,klasifikasi");
		g.setColWidth("30,350,100,100");
		g.setCellAlign("left,left,center,center");
		g.setCellType("chk,txt,txt,txt");
		g.setCellHeight(20);
		g.setImgPath("../icon");
		g.setIDPaging("paging7");
		//g.attachEvent("onRowClick","ambilDetil");
		g.baseURL("penjamin_utils.php?grd=7&paketId="+idPaket);
		g.Init();
		
		h=new DSGridObject("gridbox8");
		h.setHeader("Detil paket tindakan yang dijamin");	
		h.setColHeader("Pilih,Nama tindakan,Kelompok,Klasifikasi");
		h.setIDColHeader(",nama,kelompok,klasifikasi");
		h.setColWidth("30,350,100,100");
		h.setCellAlign("left,left,center,center");
		h.setCellType("chk,txt,txt,txt");
		h.setCellHeight(20);
		h.setImgPath("../icon");
		h.setIDPaging("paging8");
		//h.attachEvent("onRowClick","ambilDetil");		
		h.baseURL("penjamin_utils.php?grd=8&paketId="+idPaket);
		h.Init();
		
		l=new DSGridObject("gridbox9");
		l.setHeader("Data Tindakan");	
		l.setColHeader("Pilih,Nama tindakan,Kelompok,Klasifikasi");
		l.setIDColHeader(",nama,kelompok,klasifikasi");
		l.setColWidth("30,350,100,100");
		l.setCellAlign("left,left,center,center");
		l.setCellType("chk,txt,txt,txt");
		l.setCellHeight(20);
		l.setImgPath("../icon");
		l.setIDPaging("paging9");		
		l.baseURL("penjamin_utils.php?grd=9&ksoId="+idKso);
		l.Init();
		
		m=new DSGridObject("gridbox10");
		m.setHeader("Data Tindakan Di Luar Paket");	
		m.setColHeader("Pilih,Nama tindakan,Kelompok,Klasifikasi,Biaya");
		m.setIDColHeader(",nama,kelompok,klasifikasi,nilai");
		m.setColWidth("30,250,100,100,100");
		m.setCellAlign("left,left,center,center,center");
		m.setCellType("chk,txt,txt,txt,txt");
		m.setCellHeight(20);
		m.setImgPath("../icon");
		m.setIDPaging("paging10");
		m.attachEvent("onRowDblClick","editBiaya");		
		m.baseURL("penjamin_utils.php?grd=10&ksoId="+idKso);
		m.Init();

		n0=new DSGridObject("gridAkomodasiKiri");
		n0.setHeader("Data Tindakan");	
		n0.setColHeader("Pilih,Nama tindakan,Kelompok,Klasifikasi");
		n0.setIDColHeader(",nama,kelompok,klasifikasi");
		n0.setColWidth("30,350,100,100");
		n0.setCellAlign("left,left,center,center");
		n0.setCellType("chk,txt,txt,txt");
		n0.setCellHeight(20);
		n0.setImgPath("../icon");
		n0.setIDPaging("pagingAkomodasiKiri");		
		n0.baseURL("penjamin_utils.php?grd=11&ksoId="+idKso);
		n0.Init();

		n=new DSGridObject("gridAkomodasi");
		n.setHeader("Data Tindakan Paket Akomodasi");	
		n.setColHeader("Pilih,Nama tindakan,Kelompok,Klasifikasi");
		n.setIDColHeader(",nama,kelompok,klasifikasi");
		n.setColWidth("30,250,100,100");
		n.setCellAlign("left,left,center,center");
		n.setCellType("chk,txt,txt,txt");
		n.setCellHeight(20);
		n.setImgPath("../icon");
		n.setIDPaging("pagingAkomodasi");
		n.baseURL("penjamin_utils.php?grd=12&ksoId="+idKso);
		n.Init();
	}
</script>
</html>

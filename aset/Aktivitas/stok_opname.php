<?php
include '../sesi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/simrs-tangerang/aset/';
                        </script>";
}include '../koneksi/konek.php'; 
/* $id=$_REQUEST['barang_id'];
if($id!=''){
	echo $stok_data="SELECT jml_sisa FROM as_kstok WHERE barang_id='".$id."' ORDER BY waktu DESC LIMIT 1";
	$f="SELECT harga_unit FROM as_masuk WHERE barang_id='".$id."' ORDER BY tgl_terima DESC LIMIT 1";
 	$query=mysql_query($stok_data);
	$row=mysql_fetch_array($query);
	//if($row['jml_sisa']!='') echo $row['jml_sisa']; else echo 'kosong';
	//$harga_unit=$row['harga_unit'];
 } */
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <title>.: Stok Opname :.</title>
    </head>

    <body>
        <div align="center">
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
            <?php
            include "../header.php";
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            $tgl=explode("-",$date_now);
            $tgl1=$tgl[2]."-".$tgl[1]."-".$tgl[0];
            ?>
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center">
                        <table width="850" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
                            <tr id="tr_form" style="display:none">
                                <td align="center">
                                    <table width="500">
                                        <tr>
                                            <td width="40%">
                                                Jenis Aset
                                            </td>
                                            <td width="60%">:
                                                <select id="cmb_jenis" onChange="on()">
                                                    <option value="1">Tetap</option>
                                                    <option value="2">Pakai Habis</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Nama Barang
                                            </td>
                                            <td>:
                                                <input type="text" id="nama_barang" size="30" onKeyUp="suggest(event,this);" />
                                                <div id="divbarang" style="width: 500px;position: absolute;height: 100px;overflow: auto; display: none"></div>
                                            </td>
                                        </tr>
										<tr>
											<td>Stok Data</td>
											<td>: <input type="text" id="stk_dt" name="stk_dt" size="8" readonly="true" value="<?php echo $row['jml_sisa'] ?> "></td>
										</tr>
                                        <tr>
                                            <td>
                                                Stok Opname
                                            </td>
                                            <td>:
                                                <input type="text" id="jml" size="8" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Harga Terakhir
                                            </td>
                                            <td>:
                                                <input type="text" id="harga" size="11" value="<?php echo $harga_unit ?>" />
                                                <input type="hidden" id="satuan"/>
                                            </td>
                                        </tr>
										<tr>
											<td colspan="2">&nbsp;</td>
										</tr>
                                        <tr>
                                            <td colspan="2" align="center">
                                                <input type="button" value="Tambah" id="btn_act" onClick="act(this)" />
                                                <input type="button" value="Batal" id="btn_can" onClick="act(this)" />
                                            </td>
                                        </tr>
										
                                    </table>
                                </td>
                            </tr>
							<tr>
								<td colspan="3" style="font-size: large" align="center">.: Stok Opname :.</td>
							</tr>
                            <tr>
                                <td height="30" valign="bottom" align="right">
								
                                    <input type="hidden" id="id" name="id" />
									<input type="hidden" id="barang_id" name="barang_id" />
									
                                    <button type="button" id="view" onClick="act(this)" style="cursor: pointer">
                                        <img alt="add" src="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                                        Tambah Data
                                    </button>
                                    <button type="button" id="edit" style="cursor: pointer" onClick="if(document.getElementById('id').value == '' || document.getElementById('id').value == null){alert('Pilih dulu Stok Opname yang akan diedit.');return;}act(this)">
                                        <img alt="add" src="../icon/edit.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                                        Edit Data
                                    </button>
                                    <!--button type="button" id="del" style="cursor: pointer" onclick="if(document.getElementById('id').value == '' || document.getElementById('id').value == null){alert('Pilih dulu data Stok Opname yang akan dihapus.');return;}act(this,document.getElementById('id').value);" >
                                        <img alt="hapus" style="cursor: pointer" src="../images/hapus.gif" id="btnHapusPO" name="btnHapus" onclick="hapus();" />
                                        Hapus Penerimaan
                                    </button-->
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;Periode Opname :
                                    <input id="txtTgl" name="txtTgl" value="<?php echo $date_now;?>" readonly size="10" class="txtcenter"/>&nbsp;
                                    <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange,filter);" />
                                </td>
                                <!--td>Bulan&nbsp;:&nbsp;
                                    <select name="cmbBln" class="txt" id="cmbBln" onchange="filter()">
                                        < ?php
                                        $arrBln=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
                                        for($i=1;$i<=12;$i++) {?>
                                        <option value="< ?php echo $i?>"< ?php if($tgl[1]==$i) echo 'selected';?>>< ?php echo $arrBln[$i]?></option>
                                            < ?php }?>
                                    </select>&nbsp;
                                    Tahun&nbsp;:&nbsp;
                                    <select name="cmbTh" class="txt" id="cmbTh" onchange="filter()">
                                        < ?php for($i=($tgl[2]-5);$i<$tgl[2]+6;$i++) {?>
                                        <option value="< ?php echo $i;?>"< ?php if($tgl[2]==$i) echo 'selected';?>>< ?php echo $i;?></option>
                                            < ?php }?>
                                    </select>
                                </td-->
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <div id="gridbox" style="width:843px; height:200px; background-color:white; overflow:hidden;"></div>
                                    <div id="paging" style="width:841px;"></div>
                                    <span id="spanxx" style="display: none"></span>
                                </td>
                            </tr>
                        </table>
                        <div><img alt="" src="../images/foot.gif" width="1000" height="45" /></div>
                    </td>
                </tr>

            </table>
        </div>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
    </body>
<script type="text/javascript" language="javascript">
//select barang query ambil dari mana?
//action save,edit delete
var arrRange=depRange=[];
function on(){
document.getElementById('barang_id').value='';
document.getElementById('nama_barang').value='';
}
function suggest(e, par){
var keywords=par.value;
if(par.id == 'cmb_jenis'){
	if(document.getElementById('nama_barang').value != ''){
		Request('baranglist.php?aKeywords='+document.getElementById('nama_barang').value+'&tipe='+keywords+'&act=opname' , 'divbarang', '', 'GET' );
		if (document.getElementById('divbarang').style.display=='none') fSetPosisi(document.getElementById('divbarang'),par);
		document.getElementById('divbarang').style.display='block';
		document.getElementById('nama_barang').focus();
	}
}
else{
	if(keywords==""){
		document.getElementById('divbarang').style.display='none';
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
		}
		else if (key==13){
			if (RowIdx>0){
				if (fKeyEnt==false){
					fSetObat(document.getElementById(RowIdx).lang);
				}else{
					fKeyEnt=false;
				}
			}
		}
		else if (key!=27 && key!=37 && key!=39){
			RowIdx=0;
			fKeyEnt=false;
			Request('baranglist.php?aKeywords='+keywords+'&tipe='+document.getElementById('cmb_jenis').value+'&act=opname' , 'divbarang', '', 'GET' );
			if (document.getElementById('divbarang').style.display=='none') fSetPosisi(document.getElementById('divbarang'),par); 
			document.getElementById('divbarang').style.display='block';
		}
	}
}
}

function fSetObat(par){
var tmp = par.split('*|*');
var id= document.getElementById('barang_id').value = tmp[0];
document.getElementById('nama_barang').value = tmp[2];
document.getElementById('stk_dt').value = tmp[4];
document.getElementById('harga').value = tmp[5];
document.getElementById('satuan').value = tmp[3];
document.getElementById('divbarang').style.display='none';
}

function ambilData(){
if(document.getElementById('tr_form').style.display == ''){
}
else{
	var tmp = rek.getRowId(rek.getSelRow()).split('*|*');
	var p="id*-*"+tmp[0]+"*|*barang_id*-*"+tmp[1]+"*|*cmb_jenis*-*"+tmp[2]+"*|*harga*-*"+tmp[3]+"*|*satuan*-*"+rek.cellsGetValue(rek.getSelRow(),4)+"*|*stk_dt*-*"+rek.cellsGetValue(rek.getSelRow(),5);
	p += "*|*nama_barang*-*"+rek.cellsGetValue(rek.getSelRow(),3)+"*|*jml*-*"+rek.cellsGetValue(rek.getSelRow(),6);
	fSetValue(window,p);

	}
}

function act(par,id){
var val = par.id;
if(par.id == undefined || par.id == ''){
	val = 'Batal';
}
switch(val){
	case 'btn_act':
		if(document.getElementById('barang_id').value == '' || (document.getElementById('jml').value == '' || isNaN(document.getElementById('jml').value)) || (document.getElementById('harga').value || isNaN(document.getElementById('harga').value)) == ''){
			alert("Masukkan dulu data barang, jumlah dan harga dengan benar.");
			return;
		}
		var id = document.getElementById('id').value;
		var barang_id = document.getElementById('barang_id').value;
		var qty = document.getElementById('jml').value;
		var harga = document.getElementById('harga').value;
		var tgl = document.getElementById('txtTgl').value;
		var usr_id = "<?php echo $_SESSION['id_user'];?>";
		var satuan = document.getElementById('satuan').value;
		var url = "utils.php?act=cek_opname&barang_id="+barang_id+"&tgl="+tgl;
		Request(url, 'spanxx', '', 'GET', function(){
			   
				if(document.getElementById('spanxx').innerHTML > 0 && par.value=="Tambah"){
					alert(document.getElementById('nama_barang').value+" sudah ada dalam stok opname.\nSilahkan edit data yang ada.");
					return;
				}else{
				}
				document.getElementById('spanxx').innerHTML = '';		   
				url = 'utils.php?pilihan=opname&tglTagihan='+tgl+'&act='+par.value+'_opname&id='+id+'&qty='+qty+'&harga='+harga+'&barang_id='+barang_id+'&usr_id='+usr_id+'&satuan='+satuan;
				rek.loadURL(url,'','GET'); 
				document.getElementById('tr_form').style.display = 'none';
			
		});
		
		break;
   
	case 'btn_can':
		document.getElementById('nama_barang').value = '';
		document.getElementById('jml').value = '';
		document.getElementById('stk_dt').value;
		document.getElementById('satuan').value = '';
		document.getElementById('id').value = '';
		document.getElementById('barang_id').value = '';
		document.getElementById('harga').value = '';
		document.getElementById('tr_form').style.display = 'none';
		document.getElementById('edit').disabled = false;
		document.getElementById('view').disabled = false;
		document.getElementById('btn_act').value = 'Tambah';
		
		break;
	case 'view':
		document.getElementById('edit').disabled = true;
		var p="id*-**|*barang_id*-**|*cmb_jenis*-**|*harga*-**|*satuan*-*";
		p += "*|*nama_barang*-**|*jml*-*";
		fSetValue(window,p);
		document.getElementById('tr_form').style.display = '';
		break;
	case 'edit':
		document.getElementById('btn_act').value = 'Update';
		document.getElementById('view').disabled = true;
		document.getElementById('tr_form').style.display = '';
		break;
	}
}

function filter(){
rek.loadURL("utils.php?pilihan=opname&tglTagihan="+document.getElementById('txtTgl').value,"","GET");
}

function goFilterAndSort(pilihan){
if (pilihan=="gridbox")
{
	rek.loadURL("utils.php?pilihan=opname&tglTagihan="+document.getElementById('txtTgl').value+"&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage(),"","GET");
}
}

function diLoad(){
act(document.getElementById('btn_can'));
}

var rek=new DSGridObject("gridbox");
rek.setHeader(".: Data Stok Opname :.");
rek.setColHeader("No,Kode,Nama Barang,Satuan,Stok Data,Stok Opname,Adj");
rek.setIDColHeader(",kodebarang,namabarang,idsatuan,stok_data,stok_opname,stok_adj");
rek.setColWidth("40,100,300,100,100,80,100");
rek.setCellAlign("center,left,left,center,right,right,right");
rek.setCellHeight(20);
rek.setImgPath("../icon");
rek.setIDPaging("paging");
rek.attachEvent("onRowClick","ambilData");
rek.onLoaded(diLoad);
rek.baseURL("utils.php?pilihan=opname&tglTagihan="+document.getElementById('txtTgl').value);
//alert ("utils.php?pilihan=opname&tglTagihan="+document.getElementById('txtTgl').value)
rek.Init();
</script>
</html>
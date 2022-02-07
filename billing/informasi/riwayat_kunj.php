<?php
	include "../sesi.php";
	$userId = $_SESSION['userId'];
	
	$cabang = ($_REQUEST['cabang'] != '') ? $_REQUEST['cabang'] : 0 ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script src="../theme/dhtmlxcalendar.js" type="text/javascript"></script>
<!-- untuk ajax-->
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<!-- end untuk ajax-->

<title>Informasi Riwayat Kunjungan Pasien</title>
</head>

<body>
<div align="center">
<?php
	include("../koneksi/konek.php");
	include("../header1.php");
?>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;INFORMASI RIWAYAT KUNJUNGAN PASIEN</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="1" cellpadding="0" class="tabel" align="center">
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td align="right">Instansi</td>
	<td colspan="2">
		&nbsp;<select name="cabang" id="cabang" class="txtinput" onchange="setDisable(2);" ></select>
	</td>
	<td colspan="5"></td>
  </tr>
  <tr>
	<td width="5%">&nbsp;</td>
    <td align="right" width="15%">Nomer RM</td>
    <td colspan="2">&nbsp;<input type="text" name="NoRm" id="NoRm" size="10" class="txtinputreg" tabindex="1" onkeyup="listPasien(event,'show',this.value,this.id)"/>
			<input type="hidden" id="hidRM" />
               <input id="txtIdKunj" name="txtIdKunj" type="hidden"/>&nbsp;<input type="button" value="reset" style="cursor:pointer" onclick="setDisable(2);" /></td>
			<input id="txtIdPel" name="txtIdPel" type="hidden"/>
    <td width="5%">&nbsp;</td>
    <td colspan="2" align="right">Nama Orang Tua</td>
    <td width="30%">&nbsp;<input name="NmOrtu" id="NmOrtu" size="25" class="txtinputreg" /></td>
  <td width="5%">&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td align="right">Nama</td>
    <td colspan="3">&nbsp;<input type="text" class="txtinputreg" name="Nama" id="Nama" size="40" tabindex="3" onkeyup="listPasien(event,'show',this.value,this.id)"/><div id="div_pasien" align="center" class="div_pasien"></div>
	</td>
    <td width="5%">&nbsp;</td>
    <td width="10%" align="right">Alamat</td>
    <td>&nbsp;<input id="txtalamat" name="txtalamat" size="40" class="txtinputreg"/></td>
  <td>&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td align="right">Jenis Kelamin</td>
    <td colspan="3">&nbsp;<select name="Gender" id="Gender" class="txtinputreg">
	<option value="L">Laki-Laki</option>
	<option value="P">Perempuan</option>
    </select>
    </td>
    
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="9">&nbsp;</td>
    </tr>
	<tr>
		<td>&nbsp;</td>
          <td colspan="7">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                 <tr>
                      <td width="50%" align="left" valign="bottom">
						<span id="spanJamkes"></span>
                        	<input type="button" value="Riwayat Tindakan" id="btnRiwayat" name="btnRiwayat" onclick="riwayat()" class="tblBtn" align="right"/><input type="button" value="Rincian Tindakan" id="btnRincian" name="btnRincian" onclick="rincian()" class="tblBtn" align="right"/>
                           <div id="gridboxRiw1" style="width:425px; height:150px; background-color:white; overflow:hidden;"></div>
                           <div id="pagingRiw1" style="width:425px;"></div>
                      </td>
                      <td width="50%" align="right" valign="top">
                            <input type="button" value="Hapus Kunjungan" id="btnDelKun" onclick="hapus('Kunjungan')" class="tblBtn" />
                          <div id="gridboxRiw2" style="width:425px; height:150px; background-color:white; overflow:hidden;"></div>
                          <div id="pagingRiw2" style="width:425px;"></div>
                      </td>
                 </tr>
            </table>
          </td>
          <td>&nbsp;</td>
     </tr>
  <tr>
  <td colspan="5" align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" align="center">
        
    </td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td colspan="7" align="center">
        <input style="float:right;margin-right:15px;" id="btnDelTin" type="button" onclick="hapus('Tindakan')" value="Hapus Tindakan" class="tblBtn" />
		<div id="gridboxRiw3" style="width:900px; height:150px; background-color:white; overflow:hidden;"></div>
		<div id="pagingRiw3" style="width:900px;"></div>
          <span id="spanRes" style="display:none"></span>
    </td>
  <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
    </tr>
	<tr>
    <td colspan="9">&nbsp;</td>
    </tr>	
  </table>
<form id="form36" action="../unit_pelayanan/PelayananKunjungan.php" method="post">
    <input type="hidden" id="sentPar" name="sentPar" />
</form>
  <!--table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a>&nbsp;</td>
  </tr>
</table-->
</div>
</body>
<script>
	var riw1;
	var riw2;
	var riw3;
	var ambilDataRiw2;
     var actx = '';
	
	function isiCombo(id,val,defaultId,targetId,evloaded,all = 1){
		if(targetId=='' || targetId==undefined){
			targetId=id;
		}
		Request('../combo_utils.php?all='+all+'&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
	}
	
	isiCombo('listcabang','','<?php echo $cabang; ?>','cabang','',1);
	
	function riwayat(){
        var sisip = riw1.getRowId(riw1.getSelRow()).split('|');
		window.open("riwayat_pelayanan.php?idKunj="+sisip[1]+"&idPas="+sisip[0],'_blank');
	}
	
	function rincian(){
		//alert(riw1.getRowId(riw1.getSelRow()));
        var sisip = riw1.getRowId(riw1.getSelRow()).split('|');
		var url="../unit_pelayanan/RincianTindakanKSO.php?idKunj="+sisip[1]+"&idPel="+document.getElementById('txtIdPel').value+"&idUser="+<?php echo $userId; ?>+"&inap=1&tipe=2&for=1";
		//if (sisip[2]=="1") 
		url="../unit_pelayanan/RincianTindakanAllPel.php?idKunj="+sisip[1]+"&idPel="+document.getElementById('txtIdPel').value+"&idUser="+<?php echo $userId; ?>+"&tipe=2";
		window.open(url,'_blank');
	}

     function hapus(item){
        var pasien = document.getElementById('Nama').value;
        actx = item;
        switch(item){
            case 'Kunjungan':
                if(riw2.getRowId(riw2.getSelRow()) == ''){
                    alert('Pilih dahulu data kunjungan yang akan dihapus.');
                    return;
                }
                var kunjungan = riw2.cellsGetValue(riw2.getSelRow(),3);
                if(confirm("Data kunjungan "+pasien+" ke "+kunjungan+" akan dihapus.\nAnda yakin?")){
                    if(riw3.getRowId(riw3.getSelRow()) != ''){
                        alert(pasien+' memiliki data tindakan pada kunjungan ini.\nHapus terlebih dahulu data tindakannya sebelum menghapus data kunjungannya.');
                        return;
                    }
                    //hidden[0] = pasien_id, hidden[1] = kunjungan_id, hidden[2] = pelayanan_id
                    var hidden = riw2.getRowId(riw2.getSelRow()).split('|');
                    var sisip = riw1.getRowId(riw1.getSelRow()).split('|');
                    
                    Request("tabel_utils.php?act=cekTindakan&pelayanan_id="+hidden[2],'spanRes','','GET'
                            ,function(){
                                if(document.getElementById('spanRes').innerHTML <= 0){
                                    /*alert("tabel_utils.php?act=hapusPel&idPel="+hidden[2]+"&grdRiw2=true&idKunj="+sisip[1]+"&idPas="+sisip[0]+"&filter="+riw2.getFilter()+"&sorting="+riw2.getSorting()+"&page="+riw2.getPage());*/
                                    riw2.loadURL("tabel_utils.php?act=hapusPel&idPel="+hidden[2]+"&grdRiw2=true&idKunj="+sisip[1]+"&idPas="+sisip[0]+"&filter="+riw2.getFilter()+"&sorting="+riw2.getSorting()+"&page="+riw2.getPage(),'','GET');
                                }
                                else{
                                    alert(pasien+' memiliki data tindakan pada pelayanan ini.\nHapus terlebih dahulu data tindakannya sebelum menghapus data kunjungannya.');
                                }
                            }
                           );
                }
                break;
            case 'Tindakan':
                if(riw3.getRowId(riw3.getSelRow()) == ''){
                    alert('Pilih dahulu data tindakan yang akan dihapus.');
                    return;
                }
                var tindakan = riw3.cellsGetValue(riw3.getSelRow(),3);
                if(confirm("Data tindakan tindakan "+tindakan+" pada "+pasien+" akan dihapus.\nAnda yakin?")){
                    var sisipan = riw2.getRowId(riw2.getSelRow()).split("|");	
                    //hidden[0] = kunjungan_id, hidden[1] = pelayanan_id, hidden[2] = tindakan_id
                    var hidden = riw3.getRowId(riw3.getSelRow()).split('|');
                    
                    Request("tabel_utils.php?act=cekBayar&tindakan_id="+hidden[2],'spanRes','','GET'
                            ,function(){
                                if(document.getElementById('spanRes').innerHTML <= 0){
                                    riw3.loadURL("tabel_utils.php?act=hapusTin&tindakan_id="+hidden[2]+"&grdRiw3=true&idPel="+sisipan[2]
                                     +"&filter="+riw3.getFilter()+"&sorting="+riw3.getSorting()+"&page="+riw3.getPage(),'','GET');
                                }
                                else{
                                    alert(pasien+" sudah melakukan pembayaran, tidak bisa menghapus tindakan.");
                                }
                            }
                    );
                }
                break;
        }
     }
     
	function goFilterAndSort(grd){
		//alert(grd);
		if (grd=="gridboxRiw1"){			
			riw1.loadURL("tabel_utils.php?grdRiw1=true&idKunj="+dataPasien[1]+"&idPas="+dataPasien[0]+"&cabang="+dataPasien[7]+"&filter="+riw1.getFilter()+"&sorting="+riw1.getSorting()+"&page="+riw1.getPage(),"","GET");
		}else if (grd=="gridboxRiw2"){
			var sisip = riw1.getRowId(riw1.getSelRow()).split("|");			
			riw2.loadURL("tabel_utils.php?grdRiw2=true&idKunj="+sisip[1]+"&idPas="+sisip[0]+"&filter="+riw2.getFilter()+"&sorting="+riw2.getSorting()+"&page="+riw2.getPage(),"","GET");
		}else if (grd=="gridboxRiw3"){
			var sisipan = riw2.getRowId(riw2.getSelRow()).split("|");			
			riw3.loadURL("tabel_utils.php?grdRiw3=true&idPel="+sisipan[2]+"&filter="+riw3.getFilter()+"&sorting="+riw3.getSorting()+"&page="+riw3.getPage(),"","GET");
		}
	}
	
	riw1 = new DSGridObject("gridboxRiw1");
	riw1.setHeader("RIWAYAT KUNJUNGAN");
	riw1.setColHeader("NO,TGL MASUK,TGL PULANG,TEMPAT LAYANAN,PENJAMIN");
	riw1.setIDColHeader(",tgl,tgl_pulang,tmptlay,penjamin");
	riw1.setColWidth("25,75,75,120,120");
	riw1.setCellAlign("center,center,center,left,left");
	riw1.setCellHeight(20);
	riw1.setImgPath("../icon");
	riw1.setIDPaging("pagingRiw1");
	riw1.attachEvent("onRowClick","ambilDataRiw1");
	riw1.onLoaded(ambilDataRiw1);
	riw1.baseURL("tabel_utils.php?grdRiw1=true");
	riw1.Init();
	
	riw2 = new DSGridObject("gridboxRiw2");
	riw2.setHeader("KUNJUNGAN KE TEMPAT LAYANAN");
	riw2.setColHeader("NO,TGL LAYANAN,TEMPAT LAYANAN,DOKTER,KELAS");
	riw2.setIDColHeader(",tgl,tmptlay,dokter,nama");
	riw2.setColWidth("25,75,120,100,75");
	riw2.setCellAlign("center,center,left,left,left");
	riw2.setCellHeight(20);
	riw2.setImgPath("../icon");
	riw2.setIDPaging("pagingRiw2");
	riw2.attachEvent("onRowClick","ambilDataRiw2");
	riw2.attachEvent("onRowDblClick","gotoServe");
	riw2.onLoaded(ambilDataRiw2);
	riw2.baseURL("tabel_utils.php?grdRiw2=true");
	riw2.Init();
	
	riw3 = new DSGridObject("gridboxRiw3");
	riw3.setHeader("DETAIL KUNJUNGAN");
	riw3.setColHeader("NO,TGL,TINDAKAN,KELAS,DOKTER,JML TINDAKAN,BIAYA,BAYAR,STATUS,KETERANGAN");
	riw3.setIDColHeader(",tgl,tind,kls,dokter,,biaya,bayar,status,");
	riw3.setColWidth("25,75,120,75,120,50,50,50,50,100");
	riw3.setCellAlign("center,center,left,center,left,center,right,tight,center,left");
	riw3.setCellHeight(20);
	riw3.setImgPath("../icon");
	riw3.setIDPaging("pagingRiw3");
	//riw3.attachEvent("onRowClick","ambilDataRiw3");
	riw3.baseURL("tabel_utils.php?grdRiw3=true");
	riw3.Init();
	
     function gotoServe(){
        if(riw2.getRowId(riw2.getSelRow()) != ''){
            var pasien = document.getElementById('Nama').value;
            var sisip = riw2.getRowId(riw2.getSelRow()).split('|');
            //sisip[7] = tanggal pulang
            //sisip[7] = pulang
            //sisip[6] = inap
            //sisip[5] = dilayani
            //sisip[4] = jenis layanan
            //sisip[3] = unit pelayanan
            //sisip[2] = pelayanan id
            //sisip[1] = kunjungan id
            //sisip[0] = pasien id
            //jika status inap = 1 tapi belum dilayani, harus update status pasien dulu.
            if(sisip[5] == 0 && sisip[6] == 1){
                alert(pasien+" belum dilayani, update status dilayani pasien terlebih dulu untuk bisa mengakses pelayanan dari sini.");
            }
            else{
                Request("tabel_utils.php?act=accessVerify&user_id=<?php echo $userId;?>&unit_id="+sisip[3],'spanRes','','GET'
                        ,function(){
                            if(document.getElementById('spanRes').innerHTML > 0){
                                var no_rm = document.getElementById('hidRM').value;
                                var tgl = riw2.cellsGetValue(riw2.getSelRow(),2);
                                if(sisip[5] == 2 || sisip[7] == 1){
                                    sisip[5] = -1;
                                }
                                if(sisip[7] == 1){
                                    tgl = sisip[8];
                                }
                                document.getElementById('sentPar').value = no_rm+'*|*'+sisip[4]+'*|*'+sisip[3]+'*|*'+tgl+'*|*'+sisip[5];
                                document.getElementById('form36').submit();
                            }
                            else{
                                alert("Anda tidak memiliki hak akses ke "+riw2.cellsGetValue(riw2.getSelRow(),3)+".");
                            }
                        }
                    );
            }
        }
     }
	
	var RowIdx;
	var fKeyEnt;
	var cari=0;
	var keyword='';
	var cabang = 1;
	function listPasien(feel,how,stuff,id){	
	//alert(how);
		cabang = document.getElementById('cabang').value;
		if(how=='show'){
			if(feel.which==13  && keyword!=stuff){
				keyword=stuff;
				if(id == 'NoRm')
				{
					String.prototype.lpad = function(padString, length) {
					var str = this;
					while (str.length < length)
						str = padString + str;
					return str;
					}
					
					var norm = stuff.lpad('0',8);
					stuff = norm;
				}
				//alert(norm);
					
				document.getElementById('div_pasien').style.display='block';
				Request('pasien_list.php?act=cari&keyword='+stuff+'&cabang='+cabang,'div_pasien','','GET');
				RowIdx=0;
			}
			else if ((feel.which==38 || feel.which==40) && document.getElementById('div_pasien').style.display=='block'){
				//alert(feel.which);
				var tblRow=document.getElementById('pasien_table').rows.length;
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
				setPasien(document.getElementById(RowIdx).lang);
				keyword='';
			}
			if(feel.which==27 || stuff==''){
				document.getElementById('div_pasien').style.display='none';
			}
		}
	}
	
	var dataPasien = new Array();
	//kurangnya: setelah delete pelayanan,jika pelayanan ga ada lagi,ga mau langsung delete kunjungan.
	function setPasien(val)
	{
        if(val == undefined || val == ''){
		dataPasien=document.getElementById('div_pasien').innerHTML.split("|");
        }
        else{
		dataPasien=val.split("|");
        }
		var p="txtIdKunj*-*"+dataPasien[1]+"*|*NoRm*-*"+dataPasien[2]+"*|*NmOrtu*-*"+dataPasien[4]+
		"*|*Nama*-*"+dataPasien[3]+"*|*txtalamat*-*"+dataPasien[5]+"*|*Gender*-*"+dataPasien[6]+"*|*hidRM*-*"+dataPasien[2];
		fSetValue(window,p);
		document.getElementById('div_pasien').style.display='none';
		riw1.loadURL("tabel_utils.php?grdRiw1=true&idKunj="+dataPasien[1]+"&idPas="+dataPasien[0]+"&cabang="+dataPasien[7],"","GET");
		setDisable(1);
	}
	
	function setDisable(a){
		if(a==1){
			document.getElementById('NoRm').disabled = true;
			document.getElementById('NmOrtu').disabled = true;
			document.getElementById('Nama').disabled = true;
			document.getElementById('txtalamat').disabled = true;
			document.getElementById('Gender').disabled = true;
			document.getElementById('cabang').disabled = true;
		}
		else if(a==2){
			document.getElementById('NoRm').value = '';
			document.getElementById('NmOrtu').value = '';
			document.getElementById('Nama').value = '';
			document.getElementById('txtalamat').value = '';
			
			document.getElementById('NoRm').disabled = '';
			document.getElementById('NmOrtu').disabled = '';
			document.getElementById('Nama').disabled = '';
			document.getElementById('txtalamat').disabled = '';
			document.getElementById('Gender').disabled = '';
			document.getElementById('cabang').disabled = false;
			
			riw1.loadURL("tabel_utils.php?grdRiw1=true","","GET");
			riw2.loadURL("tabel_utils.php?grdRiw2=true","","GET");
			riw3.loadURL("tabel_utils.php?grdRiw3=true","","GET");
			
			document.getElementById('NoRm').focus();
		}
		else{
			document.getElementById('NoRm').disabled = '';
			document.getElementById('NmOrtu').disabled = '';
			document.getElementById('Nama').disabled = '';
			document.getElementById('txtalamat').disabled = '';
			document.getElementById('Gender').disabled = '';
			document.getElementById('cabang').disabled = false;
		}
	}
	
	function skp(idKunj,par)
        {
		  var url = '../loket/skpJamkesda.php?idKunj='+idKunj+'&userId=<?php echo $userId;?>';
		  if(par == 'kamar'){
			 url += "&kamar=true";
		  }else if (par == 'jampersal'){
		  	 url += "&jampersal=true";
		  }
		  window.open(url,'_blank');             
        }
	
	function ambilDataRiw1()
	{
		var sisip = riw1.getRowId(riw1.getSelRow()).split("|");
		var p ="txtIdKunj*-*"+sisip[1];
		fSetValue(window,p);		
		//alert("tabel_utils.php?grdRiw2=true&idKunj="+sisip[1]+"&idPas="+sisip[0]);
		riw2.loadURL("tabel_utils.php?grdRiw2=true&idKunj="+sisip[1]+"&idPas="+sisip[0],"","GET");
		Request("cekJamkes.php?idKunj="+sisip[1]+"&userId=<?php echo $userId;?>",'spanJamkes',"","GET");
	}
	
	function ambilDataRiw2()
	{
		if(actx == 'Kunjungan'){
		    var sisip = riw1.getRowId(riw1.getSelRow()).split('|');
		    Request("tabel_utils.php?act=cekPelayanan&kunjungan_id="+sisip[1],'spanRes','','GET'
			,function(){
			    if(document.getElementById('spanRes').innerHTML <= 0){
                    riw1.loadURL("tabel_utils.php?act=hapusKun&grdRiw1=true&idKunj="+sisip[1]
				    +"&idPas="+dataPasien[0]+"&cabang="+dataPasien[7]+"&filter="+riw1.getFilter()+"&sorting="+riw1.getSorting()+"&page="+riw1.getPage(),'','GET');
			    }
			    /*else{
				alert(pasien+' memiliki data tindakan pada kunjungan ini.\nGagal menghapus kunjungan.');
			    }*/
			}
		       );
		    actx = '';
		}
		var sisipan = riw2.getRowId(riw2.getSelRow()).split("|");
		var p = "txtIdPel*-*"+sisipan[2];
		fSetValue(window,p);
		//alert("tabel_utils.php?grdRiw3=true&idPel="+sisipan[2]+"&unit="+sisipan[3]);
		riw3.loadURL("tabel_utils.php?grdRiw3=true&idPel="+sisipan[2]+"&unit="+sisipan[3],"","GET");
	}
	
     function ambilAkses(){
        if(document.getElementById('spanRes').innerHTML > '0'){
            document.getElementById('btnDelTin').style.display = 'block';
            document.getElementById('btnDelKun').style.visibility = 'collapse';
        }
        else{
            document.getElementById('btnDelTin').style.display = 'none';
            document.getElementById('btnDelKun').style.visibility = 'hidden';
        }
        if("<?php echo $_POST['hidKunId'];?>" != ''){
            Request('pasien_list.php?act=kiriman&kunjungan_id=<?php echo $_POST['hidKunId'];?>','div_pasien','','GET',setPasien);
            //document.getElementById('NoRm').value = "<?php echo $_POST['hidRM'];?>";
            //document.getElementById('NoRm').focus();
        }
     }
     Request("tabel_utils.php?act=getAkses&user_id=<?php echo $userId;?>",'spanRes','','GET',ambilAkses);
</script>
</html>

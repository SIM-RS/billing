<?php
include '../secured_sess.php';
include '../sesi.php';
$ma_ppn=394;
$ma_pph21=388;
$ma_pph22=389;
$ma_pph23=390;
$ma_pph26=391;
$ma_pph29=392;
$ma_pdaerah=858;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta http-equiv="Cache-Control" content="no-cache, must-revalidate" />
        <title>.: Pengeluaran :.</title>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <link type="text/css" href="../menu.css" rel="stylesheet" />
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../menu.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
	   <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
    </head>
    <?php
    include("../koneksi/konek.php");
    $tgl=gmdate('d-m-Y',mktime(date('H')+7));
    $th=explode("-",$tgl);
    ?>
    <body bgcolor="#808080" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <style>
            .tbl
            { font-family:Arial, Helvetica, sans-serif;
              font-size:12px;}
        </style>
            <script type="text/JavaScript">
                var arrRange = depRange = [];
            </script>
            <iframe height="193" width="168" name="gToday:normal:agenda.js"
                    id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                    style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
        <iframe height="72" width="130" name="sort"
                id="sort"
                src="../theme/dsgrid_sort.php" scrolling="no"
                frameborder="0"
                style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        
        <div align="center"><?php include("../header.php");?></div>
        <div align="center">
        	<span style="display:none" id="trSup2" name="trSup2"></span>
            <span style="display:none" id="trFak" name="trFak"></span>
            <span style="display:none" id="tdNilai" name="tdNilai"></span>
            <span style="display:none" id="trForm" name="trForm"></span>

            <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAEFF3">
           
                <tr>
                    <td height="50">&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top" align="center"
                    >
                        <table border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold">
                            <tr>
                            	<td width="130" style="padding-left:20px;" height="30">Jenis Transaksi</td>
                            	<td>:&nbsp;
                                <input type="hidden" id="txtIdTrans" name="txtIdTrans" value="0" />
                                <input type="hidden" id="txtIdMaSak" name="txtIdMaSak" value="0" />
                                <input type="hidden" id="txtIdJnsPeng" name="txtIdJnsPeng" value="0" />
                                <input type="hidden" id="txtKodeJnsPeng" name="txtKodeJnsPeng" value="0" />
                                <input type="text" id="txtJnsPeng" name="txtJnsPeng" class="txtinput" readonly="readonly" size="40" />&nbsp;&nbsp;<img src="../icon/view_tree.gif" align="absmiddle" style="cursor:pointer" onclick="OpenWnd('tree_jTrans.php?kodepilih=20',950,550,'msma',true)" /></td>
                            </tr>
                            <tr>
                                <td style="padding-left:20px;">Tanggal</td>
                                <td>:&nbsp;
                                    <input id="txtTgl" name="txtTgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange);"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:20px;">No Bukti</td>
                                <td>:&nbsp;
                                    <input id="txtNoBu" name="txtNoBu" class="txtinput" type="text" />
                                </td>
                            </tr>
                            <tr height="40">
                                <td id="tdNilai" style="padding-left:20px;font-weight:bold">Nilai</td>
                                <td>:&nbsp;
                                    <input type="text" id="nilai" name="nilai" size="11" onkeyup="zxc(this)" style="text-align:right;" class="txtinput"/></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding-left:20px;">
                                    Keterangan
                                </td>
                                <td valign="top"><span style="vertical-align:top">:</span>&nbsp;
                                    <textarea cols="36" id="txtArea" name="txtArea" class="txtinputreg"></textarea>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" height="50" valign="middle">
					<input type="hidden" id="id" name="id" />
                        <button id="btnSimpan" name="btnSimpan" type="submit" class="tblBtn" onclick="simpan()">Tambah</button>
                        <button id="btnHapus" name="btnHapus" type="submit" class="tblBtn" onclick="hapus()">Hapus</button>
                        <button class="tblBtn" onclick="batal()">Batal</button>
                    </td>
                </tr>
                <tr>
                    <td style="padding-left:20px;font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;">
                        <fieldset style="width: 155px;display:inline-table;">
                            <legend>
                                Bulan<span style="padding-left: 50px; color: #fcfcfc;">&ensp;</span>Tahun
                            </legend>
                            <select id="bln" name="bln" onchange="filter()" class="txtinputreg">
                                <option value="1" <?php echo $th[1]==1?'selected="selected"':'';?> >Januari</option>
                                <option value="2" <?php echo $th[1]==2?'selected="selected"':'';?> >Februari</option>
                                <option value="3" <?php echo $th[1]==3?'selected="selected"':'';?> >Maret</option>
                                <option value="4" <?php echo $th[1]==4?'selected="selected"':'';?> >April</option>
                                <option value="5" <?php echo $th[1]==5?'selected="selected"':'';?> >Mei</option>
                                <option value="6" <?php echo $th[1]==6?'selected="selected"':'';?> >Juni</option>
                                <option value="7" <?php echo $th[1]==7?'selected="selected"':'';?> >Juli</option>
                                <option value="8" <?php echo $th[1]==8?'selected="selected"':'';?> >Agustus</option>
                                <option value="9" <?php echo $th[1]==9?'selected="selected"':'';?> >September</option>
                                <option value="10" <?php echo $th[1]==10?'selected="selected"':'';?> >Oktober</option>
                                <option value="11" <?php echo $th[1]==11?'selected="selected"':'';?> >Nopember</option>
                                <option value="12" <?php echo $th[1]==12?'selected="selected"':'';?> >Desember</option>
                            </select>&nbsp;&nbsp;
                            <select id="thn" name="thn" onchange="filter()" class="txtinputreg">
                                <?php
                                for ($i=($th[2]-5);$i<($th[2]+1);$i++) {
                                    ?>
                                <option value="<?php echo $i; ?>" class="txtinput" <?php if ($i==$th[2]) echo "selected";?>><?php echo $i;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </fieldset>&nbsp;&nbsp;
                    </td>
                </tr>
                <tr id="trGrid">
                    <td valign="top" align="center">
                        <div id="divGrid" align="center" style="width:990px; height:250px; background-color:white;">
                        </div>
                        <div id="paging" style="width:990px;"></div>
                    </td>
                </tr>
                <tr><td style="padding-top:10px"><?php include("../footer.php");?></td></tr>
            </table>
        </div>
          <?php include("../laporan/report_form.php");?>
    </body>
    <script type="text/javascript" language="javascript">
        var melakukan = '', first_load = 1, bln_in, thn_in;//, bln_bef, thn_bef;
		var isFirstLoad = false;
	   
        function isiCombo(id,val,defaultId,targetId,evloaded){
	    	//alert(targetId);
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
            //alert('combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId);
        }

        function simpan(){
			if(document.getElementById('nilai').value == ''){
				alert("Nilai Transaksi Harus Diisi !");
				return;
			}
            if(melakukan == ''){
                melakukan = 'add';
            }
		  	document.getElementById('btnSimpan').disabled = true;
		  	document.getElementById('btnHapus').disabled = true;
            var id = document.getElementById('id').value;
            var tgl = document.getElementById('txtTgl').value;
            var nobukti = document.getElementById('txtNoBu').value;
            //var id_trans = document.getElementById('cmbPend').value;
			var id_trans = document.getElementById('txtIdTrans').value;
            var ket = document.getElementById('txtArea').value;
            var nilai = document.getElementById('nilai').value;
            var bln = document.getElementById('bln').value;
            var thn = document.getElementById('thn').value;
		  	var user_act = "<?php echo $_SESSION['id']; ?>";
			
			nilai=ValidasiText(nilai);
		
            var url = "kas_bank_utils.php?act="+melakukan+"&tgl="+tgl+"&id_trans="+id_trans+"&nobukti="+nobukti+"&ket="+ket+"&nilai="+nilai+"&user_act="+user_act+"&bln="+bln+"&thn="+thn+"&id="+id;
		  	//alert(url)
            grid.loadURL(url,'','GET');
			batal();
        }
	   
	   function hapus(){
		document.getElementById('btnSimpan').disabled = true;
		document.getElementById('btnHapus').disabled = true;
		if(grid.getRowId(grid.getSelRow()) == ''){
			alert('Pilih dulu data yang akan dihapus.');
			return;
		}
		if(confirm("Data "+grid.cellsGetValue(grid.getSelRow(),4)+" akan dihapus.\nAnda yakin?")){
			var bln = document.getElementById('bln').value;
			var thn = document.getElementById('thn').value;
			var id = document.getElementById('id').value;
			var url = "kas_bank_utils.php?act=hapus&id="+id+"&bln="+bln+"&thn="+thn;
			//alert(url);
			grid.loadURL(url, '', 'GET');
			batal();
		}
		else{
			document.getElementById('btnSimpan').disabled = false;
			document.getElementById('btnHapus').disabled = false;
		}
	   }
		
		function batal(){
		  	document.getElementById('btnSimpan').disabled = false;
		  	document.getElementById('btnHapus').disabled = true;
            document.getElementById('txtTgl').value = "<?php echo $tgl; ?>";
            document.getElementById('btnSimpan').innerHTML = 'Tambah';
            document.getElementById('id').value = '';
			document.getElementById('txtJnsPeng').value = '';
            document.getElementById('txtNoBu').value = '';
            document.getElementById('txtArea').value = '';
			document.getElementById('nilai').value = '';
			/*document.getElementById('txtidMA').value = '';
			document.getElementById('txtMA').value = '';
			document.getElementById('txtJnsPeng').value = '';*/
            melakukan = '';
        }
	   
        function grid_act(){
		  document.getElementById('btnHapus').disabled = false;
            melakukan = 'edit';
            document.getElementById('btnSimpan').innerHTML = 'Simpan';
		  var sisip = grid.getRowId(grid.getSelRow()).split('|');
            document.getElementById('id').value = sisip[0];
			document.getElementById('txtIdTrans').value = sisip[1];
            document.getElementById('txtTgl').value = grid.cellsGetValue(grid.getSelRow(),2);
            document.getElementById('txtNoBu').value = grid.cellsGetValue(grid.getSelRow(),3);
			document.getElementById('txtJnsPeng').value = grid.cellsGetValue(grid.getSelRow(),4);
            document.getElementById('txtArea').value = sisip[2];
            document.getElementById('nilai').value = grid.cellsGetValue(grid.getSelRow(),5);
        }
	   
	   function grid_loaded(){
	   	if (isFirstLoad == false){
			isFirstLoad = true;
			batal();
		}
	   }
	   
	   function filter(){
		var bln = document.getElementById('bln').value;
		var thn = document.getElementById('thn').value;
	   		grid.loadURL("kas_bank_utils.php?bln="+bln+"&thn="+thn,"","GET");
	   }

	   function goFilterAndSort(grd){
	   		if (grd=="divGrid"){
				var bln = document.getElementById('bln').value;
				var thn = document.getElementById('thn').value;
				
                grid.loadURL("kas_bank_utils.php?bln="+bln+"&thn="+thn+"&filter="+grid.getFilter()+"&sorting="+grid.getSorting()+"&page="+grid.getPage(),"","GET");
            }
       }

        grid=new DSGridObject("divGrid");
        grid.setHeader("DATA TRANSAKSI PENGELUARAN");
        grid.setColHeader("NO,TGL TRANSAKSI,NO BUKTI,JENIS TRANSAKSI,NILAI,KETERANGAN");
        grid.setIDColHeader(",tgl,no_bukti,nama_trans,nilai,ket");
        grid.setColWidth("30,70,120,180,80,250");
        grid.setCellAlign("center,center,center,left,right,left");
		grid.setCellType("txt,txt,txt,txt,txt,txt");
        grid.setCellHeight(20);
        grid.setImgPath("../icon");
        grid.onLoaded(grid_loaded);
        grid.setIDPaging("paging");
        grid.attachEvent("onRowClick","grid_act");
		grid.baseURL("kas_bank_utils.php?bln="+document.getElementById('bln').value+"&thn="+document.getElementById('thn').value);
        grid.Init();
        //+"&supplier="+document.getElementById('cmbSup').value
        var th_skr = "<?php echo $date_skr[2];?>";
        var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
		var fromHome=<?php echo $fromHome ?>;
    </script>
<script src="../report_form.js" type="text/javascript" language="javascript"></script>
<script>
	
	function zxc(par){
		var r=par.value;
		while (r.indexOf(".")>-1){
			r=r.replace(".","");
		}
		var nilai=FormatNumberFloor(parseInt(r),".");
		if(nilai=='NaN'){
			par.value = '';
		}
		else{
			par.value = nilai;
		}	
	}
	
	function ValidasiText(p){
	var tmp=p;
		while (tmp.indexOf('.')>0){
			tmp=tmp.replace('.','');
		}
		while (tmp.indexOf(',')>0){
			tmp=tmp.replace(',','.');
		}
		return tmp;
	}
	
	var t=0;
	function setSubTotal(){
		var tot = 0;
		for(var i=1;i<=gb.getMaxRow();i++){
			var id = gb.getRowId(i);
			if(document.getElementById('nilai_'+id).value!=''){
				r=document.getElementById('nilai_'+id).value;
				while (r.indexOf(".")>-1){
					r=r.replace(".","");
				}
				tot = tot + parseFloat(r);
			}
		}
		
		t=FormatNumberFloor(tot,".");
		gb.cellSubTotalSetValue(5,t);
		document.getElementById('nilai').value = t;
	}
	
    function qwerty(p){
	}
	
	function ngeload_grid_detil(b){
	}

</script>
</html>

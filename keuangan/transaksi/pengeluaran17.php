<?php
include("../sesi.php");
include '../secured_sess.php';
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
        <div id="popLayanan" style="display:none; width:1000px" class="popup" align="center">
            <table width="409" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
            <tr>
                <td class="font">
                	<div id="gd" align="center" style="width:1000px; height:500px; overflow:hidden; background-color:white;"></div>
                </td>
            </tr>
            <tr>
                <td height="50" valign="bottom" align="center"><button id="sim" name="sim" value="simpan" type="button" style="cursor:pointer" class="popup_closebox" onclick="getIdNilai()">&nbsp;&nbsp;OK&nbsp;&nbsp;</button>  <button type="button" id="batal" name="batal" class="popup_closebox" onclick="batalkan()" style="cursor:pointer">&nbsp;&nbsp;Batal&nbsp;&nbsp;</button></td>
            </tr>
            </table>
        </div>
        <div align="center">
            <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAEFF3">
                <tr>
                    <td height="50">&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top" align="center">
                        <table width="750" border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold">
                            <tr style="display:none">
                                <td width="50%" style="padding-left:150px;" height="30">Jenis Pengeluaran</td>
                                <td width="50%">:&nbsp;
                                    <select id="cmbPend" name="cmbPend" class="txtinput" onchange="changeType(this)">
                                        <?php
                                        $qPend = "SELECT id, nama
									FROM k_ms_transaksi
									WHERE tipe = 2";
                                        $rsPend = mysql_query($qPend);
                                        while($rwPend = mysql_fetch_array($rsPend)) {
                                            ?>
                                        <option value="<?php echo $rwPend['id'];?>"><?php echo $rwPend['nama']?></option>
                                            <?php } ?>
                                    </select>
                                    <input type="hidden" id="txtidmadpa" name="txtidmadpa" />
                                </td>
                            </tr>
                            <tr>
                            	<td width="50%" style="padding-left:150px;" height="30">Jenis Pengeluaran</td>
                            	<td>:&nbsp;
                                <input type="hidden" id="txtIdTrans" name="txtIdTrans" value="0" />
                                <input type="hidden" id="txtIdMaSak" name="txtIdMaSak" value="0" />
                                <input type="hidden" id="txtIdJnsPeng" name="txtIdJnsPeng" value="0" />
                                <input type="hidden" id="txtKodeJnsPeng" name="txtKodeJnsPeng" value="0" />
                                <input type="text" id="txtJnsPeng" name="txtJnsPeng" class="txtinput" readonly="readonly" size="40" />&nbsp;&nbsp;<img src="../icon/view_tree.gif" align="absmiddle" style="cursor:pointer" onclick="OpenWnd('tree_jTrans.php?kodepilih=14|16',950,550,'msma',true)" /></td>
                            </tr>
                            <tr>
                                <td width="50%" style="padding-left:150px;" height="30">Mata Anggaran</td>
                                <td width="50%">:&nbsp;
                                 <input type="hidden" id="txtidMA" name="txtidMA"  />
                                 <input type="text" id="txtMA" name="txtMA" class="txtinput" readonly="readonly" size="40" />&nbsp;&nbsp;<img src="../icon/view_tree.gif" align="absmiddle" style="cursor:pointer" onclick="OpenWnd('tree_mata_anggaran.php?id='+document.getElementById('txtIdJnsPeng').value+'&par=txtidMA*txtMA',800,500,'Tree Unit',true)" />
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:150px;">Tanggal</td>
                                <td>:&nbsp;
                                    <input id="txtTgl" name="txtTgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange);"/>
                                </td>
                            </tr>
                            <tr style="visibility:collapse">
                                <td style="padding-left:150px;">No Bukti</td>
                                <td>:&nbsp;
                                    <input id="txtNoBu" name="txtNoBu" class="txtinput" type="text" />
                                </td>
                            </tr>
                            <tr id="trJM" style="visibility:collapse">
                                <td style="padding-left:150px;">Jenis Layanan</td>
                                <td>:&nbsp;
                                    <select id="cmbJnsLay" name="cmbJnsLay" onchange="isiCombo('cmbTemLayCCRV', this.value, '', 'cmbTemLay')" class="txtinput">
                                    </select>
                                </td>
                            </tr>
                            <tr id="trTP" style="visibility:collapse">
                                <td style="padding-left:150px;">Tempat Layanan</td>
                                <td>:&nbsp;
                                    <select id="cmbTemLay" name="cmbTemLay" onchange="" class="txtinput">
                                    </select>
                                </td>
                            </tr>
                            <tr id="trSup1">
                                <td style="padding-left:150px;">Jenis Supplier</td>
                                <td>:&nbsp;
                                    <select id="cmbJenSup" name="cmbJenSup" onchange="fillSup(this.value);" class="txtinput">
                                        <option value="1">Supplier Obat</option>
                                        <option value="2">Supplier Barang</option>
                                    </select>
                                </td>
                            </tr>
                            <tr id="trSup2">
                                <td style="padding-left:150px;">Nama Supplier</td>
                                <td>:&nbsp;
                                    <select id="cmbSup" name="cmbSup" onchange="view_tab()" class="txtinput">
                                    </select>
                                </td>
                            </tr>
                            <tr id='trForm'>
                                <td style="padding-left:150px;font-weight:bold">Nilai SPK (SIM)</td>
                                <td>:&nbsp;
                                    <input type="text" id="nilaiSPK" name="nilaiSPK" readonly="readonly" size="11" style="text-align:right;" class="txtinput"/></td>
                            </tr>
                            <tr id='trForm1' height="40">
                                <td id="tdNilai" style="padding-left:150px;font-weight:bold">Nilai SPK (Tagihan)</td>
                                <td>:&nbsp;
                                    <input type="hidden" id="fdata" name="fdata" />
                                    <input type="text" id="nilai" name="nilai" size="11" onkeyup="zxc(this)" style="text-align:right;" class="txtinput"/> &nbsp;<img id="imgNilai" src="../icon/calculator_red.png" align="absmiddle" width="25" style="cursor:pointer;display:none;" onclick="popup1()" /></td>
                            </tr>
                            <tr id='trFak'>
                                <td style="padding-left:150px;font-weight:bold">No SPK/Nota Dinas
                                    <div id="div_faktur" style="width:auto;height:auto;overflow:auto;display:none;position:absolute"></div>
                                </td>
                                <td>:&nbsp;
                                    <input type="text" id="faktur" readonly name="faktur" style="text-align:center;" size='23' class="txtinput"/>
                                    <input type="button" id="btnFak" class="tblBtn" value="show" onclick="showDetail()" />
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding-left:150px;">
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
                <!--tr id="trDiv">
                    <td valign="top" align="center">
                        <div id="divsup" align="center" style="width:925px; overflow: hidden">
                            <!--iframe id="ifKso" style="width:925px; height:250px; border:0px;"></iframe height:250px;- ->
                        </div>
                    </td>
                </tr-->
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
                        <fieldset id="fldBayar" style="width: 155px;display:inline-table;">
                            <legend>
                                Status Posting
                            </legend>
                            <select id="stBayar" name="stBayar" onchange="filter()" class="txtinputreg">
                                <option value="0">Belum Posting&nbsp;</option>
                                <option value="1">Sudah Posting&nbsp;</option>
                                <option value="2">Semua&nbsp;</option>
                            </select>
                        </fieldset>
                        <span style="padding-left:280px"><button id="btnBayarPajak" name="btnBayarPajak" type="button" disabled="disabled" class="tblBtn" onclick="bayarPajak()">&nbsp;&nbsp;Bayar Pajak + Posting&nbsp;&nbsp;</button>&nbsp;&nbsp;<button id="btnBayar" name="btnBayar" type="button" disabled="disabled" class="tblBtn" onclick="bayar()">&nbsp;&nbsp;Bayar + Posting Akuntansi&nbsp;&nbsp;</button></span>
                    </td>
                </tr>
                <tr id="trGrid">
                    <td valign="top" align="center">
                        <div id="divGrid" align="center" style="width:990px; height:250px; background-color:white;">
                            <!--iframe id="ifKso" style="width:925px; height:250px; border:0px;"></iframe-->
                        </div>
                        <div id="paging" style="width:990px;"></div>
                    </td>
                </tr>
                <tr><td style="padding-top:10px"><?php include("../footer.php");?></td></tr>
            </table>
        </div>
        <div id="divPop" class="popup" style="width:450px;height:350px;display:none;">
            <fieldset>
                <legend style="float:right">
                    <div style="float:right; cursor:pointer" class="popup_closebox">
                        <img alt="close" src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
                </legend>
                <table border="0">
                    <tr>
                        <td style="padding-left:30px">No Bukti</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><input id="txtNoBuktiBayar" name="txtNoBuktiBayar" class="txtinput" type="text" size="30" /></td>
                    </tr>
                    <tr>
                        <td style="padding-left:30px">Tgl Bayar</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><input id="txtTglBayar" name="txtTglBayar" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTglBayar" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTglBayar'),depRange);"/></td>
                    </tr>
                    <tr>
                        <td style="padding-left:30px">Cara Bayar</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><select id="caraBayar" name="caraBayar" class="txtinputreg">
                                <option value="1">KAS&nbsp;</option>
                                <option value="2">BANK BENDAHARA PENGELUARAN</option>
                                <option value="3">BANK BLUD</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td style="padding-left:30px;vertical-align:top">Pajak</td>
                        <td style="vertical-align:top">&nbsp;:&nbsp;</td>
                        <td>
                        <fieldset>
                        	<table>
                            	<tr>
                                	<td>PPN</td>
                                    <td>:&nbsp;<input id="txtPPN" name="txtPPN" lang="<?php echo $ma_ppn; ?>" class="txtinput" type="text" value="" size="13" style="text-align:right" />&nbsp;</td>
                                </tr>
                            	<tr>
                                	<td>Pph 21</td>
                                    <td>:&nbsp;<input id="txtPph21" name="txtPph21" lang="<?php echo $ma_pph21; ?>" class="txtinput" type="text" size="13" style="text-align:right" />&nbsp;</td>
                                </tr>
                            	<tr>
                                	<td>Pph 22</td>
                                    <td>:&nbsp;<input id="txtPph22" name="txtPph22" lang="<?php echo $ma_pph22; ?>" class="txtinput" type="text" size="13" style="text-align:right" />&nbsp;</td>
                                </tr>
                            	<tr>
                                	<td>Pph 23</td>
                                    <td>:&nbsp;<input id="txtPph23" name="txtPph23" lang="<?php echo $ma_pph23; ?>" class="txtinput" type="text" size="13" style="text-align:right" />&nbsp;</td>
                                </tr>
                            	<tr>
                                	<td>Pph 26</td>
                                    <td>:&nbsp;<input id="txtPph26" name="txtPph26" lang="<?php echo $ma_pph26; ?>" class="txtinput" type="text" size="13" style="text-align:right" />&nbsp;</td>
                                </tr>
                            	<tr>
                                	<td>Pph 29</td>
                                    <td>:&nbsp;<input id="txtPph29" name="txtPph29" lang="<?php echo $ma_pph29; ?>" class="txtinput" type="text" size="13" style="text-align:right" />&nbsp;</td>
                                </tr>
                            	<tr>
                                	<td>P Daerah</td>
                                    <td>:&nbsp;<input id="txtpDaerah" name="txtpDaerah" lang="<?php echo $ma_pdaerah; ?>" class="txtinput" type="text" size="13" style="text-align:right" />&nbsp;</td>
                                </tr>
                            	<tr>
                                	<td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </fieldset></td>
                    </tr>
                    <!--tr>
                        <td style="padding-left:30px">Tgl Terima Pajak</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><input id="txtTglTerimaPajak" name="txtTglTerimaPajak" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                        <input type="button" name="btnTglBayar" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTglTerimaPajak'),depRange);"/></td>
                    </tr-->
                    <tr>
                        <td style="padding-left:30px">Tgl Bayar Pajak</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><input id="txtTglBayarPajak" name="txtTglBayarPajak" readonly size="11" class="txtcenter" type="text" value="" />&nbsp;
                        <input type="button" name="btnTglBayar" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTglBayarPajak'),depRange);"/></td>
                    </tr>
                    <tr>
                    	<td colspan="3" align="center" style="padding-left:30px">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td colspan="3" align="center" style="padding-left:30px"><button id="btnBayarPop" name="btnBayarPop" type="button" class="tblBtn" onclick="BayarPop()">&nbsp;&nbsp;Bayar&nbsp;&nbsp;</button></td>
                    </tr>
                </table>
            </fieldset>
        </div>
          <?php include("../laporan/report_form.php");?>
    </body>
    <script type="text/javascript" language="javascript">
        var melakukan = '', first_load = 1, bln_in, thn_in;//, bln_bef, thn_bef;
		var isFirstLoad = false;
	   
		var stBayar = document.getElementById('stBayar').value;
		var ViewBayar = 1;
		if (document.getElementById('fldBayar').style.display == 'none'){
			stBayar = 0;
			ViewBayar = 0;
		}

        function showDetail(){
	    	view_tab();
            if(document.getElementById('div_faktur').style.display == 'block'){
                document.getElementById('div_faktur').style.display = 'none';
				document.getElementById('btnFak').value='show';
            }
            else{
                document.getElementById('div_faktur').style.display = 'block';
				document.getElementById('btnFak').value='hide';
            }
	    
        }

        function fsetFaktur(par){
        var tmp = par.split('|');
            document.getElementById('faktur').value = tmp[4];
            document.getElementById('nilai').value = tmp[1];
			document.getElementById('nilaiSPK').value = tmp[1];
		  	bln_in = tmp[2];
		  	thn_in = tmp[3];
            document.getElementById('div_faktur').style.display = 'none';
	    	document.getElementById('btnFak').value='show';
        }

        function changeType(par){
            //alert(par.value);
			//alert(pecah);
			document.getElementById('txtidmadpa').value = par.value;
            document.getElementById('trJM').style.display = 'none';
            document.getElementById('trTP').style.display = 'none';
			document.getElementById('imgNilai').style.display = 'none';
            document.getElementById('trSup1').style.display = 'none';
            document.getElementById('trSup2').style.display = 'none';
            document.getElementById('trFak').style.display = 'none';
			//document.getElementById('fldBayar').style.display = 'none';
			//document.getElementById('btnBayar').style.display = 'none';
			document.getElementById('tdNilai').innerHTML = 'Nilai';
            document.getElementById('trForm').style.display = 'none';
            //document.getElementById('nilai').value = '';
            //document.getElementById('txtArea').value = '';
            //document.getElementById('trGrid').style.display = 'none';
            //document.getElementById('faktur').value = '';
            switch(par.value){
                case '11'://supplier
                    document.getElementById('trSup1').style.display = 'table-row';
                    document.getElementById('trSup2').style.display = 'table-row';
                    document.getElementById('trFak').style.display = 'table-row';
					//document.getElementById('fldBayar').style.display = 'inline-table';
					//document.getElementById('btnBayar').style.display = 'inline-table';
					document.getElementById('tdNilai').innerHTML = 'Nilai SPK (Tagihan)';
            		document.getElementById('trForm').style.display = 'table-row';
                    //document.getElementById('trGrid').style.display = 'table-row';
                    //view_tab();
                    break;
                case '12'://cleaning service
                case '13'://jasa taman
                    //document.getElementById('trForm').style.display = 'table-row';
                    //view_tab();
                    break;
                case '8'://gaji pns
                case '9'://pdam
                case '10'://listrik
                case '14'://perjalanan dinas
                case '15'://listrik
                case '17'://jasa medis
                case '18'://gaji non-pns
				if(first_load == 1){
					isiCombo('cmbJnsLayCCRV', '', '', 'cmbJnsLay'
					,function(){
					    isiCombo('cmbTemLayCCRV', document.getElementById('cmbJnsLay').value, '', 'cmbTemLay');
					});
					first_load = 0;
				}
                    //view_tab
                    document.getElementById('trJM').style.display = 'none';
                    document.getElementById('trTP').style.display = 'none';
					//document.getElementById('imgNilai').style.display = 'inline';
                    break;
                default :
                    //view_tab();
                    break;
            }
            view_tab();
        }

        

        function isiCombo(id,val,defaultId,targetId,evloaded){
	    	//alert(targetId);
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
            //alert('combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId);
        }

        function filter(par){
		var url;
            if(par == 'in'){
                var itxtTglAwal = document.getElementById('txtTglAwal').value;
                var itxtTglAkhir = document.getElementById('txtTglAkhir').value;
                var supplier = document.getElementById('cmbSup').value;
                var target = 'div_faktur';
                url = 'supplier.php?type=11&txtTglAwal='+itxtTglAwal+'&txtTglAkhir='+itxtTglAkhir+'&jenis_supplier=1&supplier='+supplier;
				//alert(url);
                Request(url,target,'','GET');
            }
            else{
                var bln = document.getElementById('bln').value;
                var thn = document.getElementById('thn').value;
				stBayar = document.getElementById('stBayar').value;
				ViewBayar = 1;
				if (document.getElementById('fldBayar').style.display == 'none'){
					stBayar = 0;
					ViewBayar = 0;
				}
				
				if (stBayar==1){
					document.getElementById('btnBayar').disabled=true;
				}else{
					document.getElementById('btnBayar').disabled=false;
				}
				url = "pengeluaran_utils.php?pilihan=pengeluaran&stBayar="+stBayar+"&ViewBayar="+ViewBayar+"&bln="+bln+"&thn="+thn;
				//alert(url);
                grid.loadURL(url,'','GET');
            }
        }
	
        function view_tab()
        {
            var bln = (document.getElementById('bln_in')==undefined)?document.getElementById('bln').value:document.getElementById('bln_in').value;
            var thn = (document.getElementById('thn_in')==undefined)?document.getElementById('thn').value:document.getElementById('thn_in').value;
            //var tipe = document.getElementById('cmbPend').value;
			var tipe = 11;
            var target = 'div_faktur';
            //var target = 'divsup';
            //document.getElementById('divsup').innerHTML = '';
            var url = 'supplier.php?type='+tipe+'&bln='+bln+'&thn='+thn;
            switch(tipe){
                case '11'://supplier
		    		var jenis_supplier = document.getElementById('cmbJenSup').value;
                    var supplier = document.getElementById('cmbSup').value;
					var itxtTglAwal = "";
					var itxtTglAkhir = "";
					var supplier = document.getElementById('cmbSup').value;
					if (document.getElementById('txtTglAwal')) itxtTglAwal = document.getElementById('txtTglAwal').value;
					if (document.getElementById('txtTglAkhir')) itxtTglAkhir = document.getElementById('txtTglAkhir').value;
					url += '&txtTglAwal='+itxtTglAwal+'&txtTglAkhir='+itxtTglAkhir+'&jenis_supplier='+jenis_supplier+'&supplier='+supplier;
                    //target = 'div_faktur';
                    //+"&supplier="+supplier
                    break;
                case '8'://gaji pns
                case '9'://pdam
                case '10'://listrik
                case '14'://perjalanan dinas
                case '15'://listrik
                case '17'://jasa medis
                case '18'://gaji non-pns
                    /*var jnsLay = document.getElementById('cmbJnsLay').value;
                    url += '&jenis_layanan='+jnsLay;*/
                    break;
            }
	    	//alert(url);
            Request(url,target,'','GET');
            //	document.getElementById('ifKso').src='kso.php?&kso='+kso+'&bln='+bln+'&thn='+thn;
        }

        function simpan(){
			if(document.getElementById('nilai').value == ''){
				alert("Nilai Pengeluaran Harus Diisi !");
				return;
			}
			if(document.getElementById('txtMA').value == ''){
				alert("Pilih Mata Anggaran Terlebih Dahulu !");
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
			var nilai_sim = document.getElementById('nilaiSPK').value;
            var bln = document.getElementById('bln').value;
            var thn = document.getElementById('thn').value;
		  	var user_act = "<?php echo $_SESSION['id']; ?>";
			var idMa = document.getElementById('txtidMA').value;
			stBayar = document.getElementById('stBayar').value;
			ViewBayar = 1;
			if (document.getElementById('fldBayar').style.display == 'none'){
				stBayar = 0;
				ViewBayar = 0;
			}
			
			/*while (nilai.indexOf(".")>-1){
				nilai=nilai.replace(".","");
			}
			
			while (nilai_sim.indexOf(".")>-1){
				nilai_sim=nilai_sim.replace(".","");
			}*/
			
			nilai=ValidasiText(nilai);
			nilai_sim=ValidasiText(nilai_sim);
		
            var url = "pengeluaran_utils.php?pilihan=pengeluaran&stBayar="+stBayar+"&ViewBayar="+ViewBayar+"&act="+melakukan+"&tgl="+tgl+"&id_trans="+id_trans+"&nobukti="+nobukti+"&ket="+ket+"&nilai="+nilai+"&nilai_sim="+nilai_sim+"&user_act="+user_act+"&bln="+bln+"&thn="+thn+"&idMa="+idMa+"&id="+id;

            if(document.getElementById('trSup2').style.display == 'table-row'){
				var jenis_supplier = document.getElementById('cmbJenSup').value;
                var suplier_id = document.getElementById('cmbSup').value;
                var nofaktur = document.getElementById('faktur').value;
			 	/*var bln_in = document.getElementById('bln_in').value;
			 	var thn_in = document.getElementById('thn_in').value;*/
                url += "&jenis_supplier="+jenis_supplier+"&suplier_id="+suplier_id+"&nofaktur="+nofaktur+"&bln_in="+bln_in+"&thn_in="+thn_in;
            }
            else if(document.getElementById('imgNilai').style.display == 'inline'){
				getIdNilai();
                //var jenis = document.getElementById('cmbJnsLay').value;
                //var tmp = document.getElementById('cmbTemLay').value;
				var fdata = document.getElementById('fdata').value;
				var id_ma_sak = document.getElementById('txtIdMaSak').value;
                url += "&jenis_layanan=0&unit_id=0&fdata="+fdata+"&id_ma_sak="+id_ma_sak;
            }
			
			if(document.getElementById('imgNilai').style.display == 'none' && cuma_satu==true){
				var id_ma_sak = document.getElementById('txtIdMaSak').value;
				var unit_id = document.getElementById('txtIdJnsPeng').value;
				url += "&id_ma_sak="+id_ma_sak+"&unit_id="+unit_id+"&cuma_satu=1";
			}
		  	//alert(url)
			//raga
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
		if(confirm("Data pengeluaran "+grid.cellsGetValue(grid.getSelRow(),4)+" akan dihapus.\nAnda yakin?")){
			var bln = document.getElementById('bln').value;
			var thn = document.getElementById('thn').value;
			var id = document.getElementById('id').value;
			stBayar = document.getElementById('stBayar').value;
			ViewBayar = 1;
			if (document.getElementById('fldBayar').style.display == 'none'){
				stBayar = 0;
				ViewBayar = 0;
			}
			var url = "pengeluaran_utils.php?pilihan=pengeluaran&stBayar="+stBayar+"&ViewBayar="+ViewBayar+"&act=hapus&id="+id+"&bln="+bln+"&thn="+thn;
			/*if(document.getElementById('trSup2').style.display == 'table-row'){
			    //var suplier_id = document.getElementById('cmbSup').value;
			    //var nofaktur = document.getElementById('faktur').value;
			    var bln_in = document.getElementById('bln_in').value;
			    var thn_in = document.getElementById('thn_in').value;
			    url += "&bln_in="+bln_in+"&thn_in="+thn_in;
			    //"&suplier_id="+suplier_id+"&nofaktur="+nofaktur+
			}*/
			//alert(url);
			grid.loadURL(url, '', 'GET');
			batal();
		}
		else{
			document.getElementById('btnSimpan').disabled = false;
			document.getElementById('btnHapus').disabled = false;
		}
	   }
		
		function bayarPajak(){
		}
		
		function bayar(){
            new Popup('divPop',null,{modal:true,position:'center',duration:0.5})
            $('divPop').popup.show();
		}
		
		function BayarPop(){
			var tmp='',idata='';
			var bln = document.getElementById('bln').value;
			var thn = document.getElementById('thn').value;
			var id = document.getElementById('id').value;
			var noBukti = document.getElementById('txtNoBuktiBayar').value;
			var TglBayar = document.getElementById('txtTglBayar').value;
			var TglBayarPajak = document.getElementById('txtTglBayarPajak').value;
			var tcaraBayar = document.getElementById('caraBayar').value;
			stBayar = document.getElementById('stBayar').value;
			ViewBayar = 1;
			
			if (document.getElementById('fldBayar').style.display == 'none'){
				stBayar = 0;
				ViewBayar = 0;
			}
			
			var url="pengeluaran_utils.php?pilihan=pengeluaran&stBayar="+stBayar+"&ViewBayar="+ViewBayar+"&id="+id+"&bln="+bln+"&thn="+thn+"&noBukti="+noBukti+"&TglBayar="+TglBayar+"&TglBayarPajak="+TglBayarPajak+"&tcaraBayar="+tcaraBayar;
			//alert(grid.cellsGetChecked(1,8));
			
			for (var i=0;i<grid.getMaxRow();i++){
				if (grid.cellsGetChecked(i+1,9)){
					//alert(a1.cellsGetValue(i+1,2));
					idata=grid.getRowId(i+1).split("|");
					tmp+=idata[0]+String.fromCharCode(6);
				}
			}
			
			//alert(tmp);
			//alert(String.fromCharCode(6));
			if (tmp!=""){
				var pajak='',msgalert='';
				if (document.getElementById('txtPPN').value!=""){
					pajak +=document.getElementById('txtPPN').lang+"|"+document.getElementById('txtPPN').value+String.fromCharCode(6);
					msgalert +="   - PPN = "+document.getElementById('txtPPN').value+" %\r\n";
				}
				if (document.getElementById('txtPph21').value!=""){
					pajak +=document.getElementById('txtPph21').lang+"|"+document.getElementById('txtPph21').value+String.fromCharCode(6);
					msgalert +="   - Pph21 = "+document.getElementById('txtPph21').value+" %\r\n";
				}
				if (document.getElementById('txtPph22').value!=""){
					pajak +=document.getElementById('txtPph22').lang+"|"+document.getElementById('txtPph22').value+String.fromCharCode(6);
					msgalert +="   - Pph22 = "+document.getElementById('txtPph22').value+" %\r\n";
				}
				if (document.getElementById('txtPph23').value!=""){
					pajak +=document.getElementById('txtPph23').lang+"|"+document.getElementById('txtPph23').value+String.fromCharCode(6);
					msgalert +="   - Pph23 = "+document.getElementById('txtPph23').value+" %\r\n";
				}
				if (document.getElementById('txtPph26').value!=""){
					pajak +=document.getElementById('txtPph26').lang+"|"+document.getElementById('txtPph26').value+String.fromCharCode(6);
					msgalert +="   - Pph26 = "+document.getElementById('txtPph26').value+" %\r\n";
				}
				if (document.getElementById('txtPph29').value!=""){
					pajak +=document.getElementById('txtPph29').lang+"|"+document.getElementById('txtPph29').value+String.fromCharCode(6);
					msgalert +="   - Pph29 = "+document.getElementById('txtPph29').value+" %\r\n";
				}
				if (document.getElementById('txtpDaerah').value!=""){
					pajak +=document.getElementById('txtpDaerah').lang+"|"+document.getElementById('txtpDaerah').value+String.fromCharCode(6);
					msgalert +="   - Pajak Daerah = "+document.getElementById('txtpDaerah').value+" %\r\n";
				}
				//alert(pajak);
				if (pajak!=""){
					pajak=pajak.substr(0,(pajak.length-1));
				}
				//alert(pajak);
				//alert(tmp);
				tmp=pajak+String.fromCharCode(5)+tmp.substr(0,(tmp.length-1));
				//alert(tmp);
				if (tmp.length>1024){
					alert("Data Yg Mau diBayarkan Terlalu Banyak !");
				}else{
					url+="&act=pengeluaranLain2&fdata="+tmp;
					
					if (msgalert==""){
						if (confirm("Data Yg Mau diBayarkan Tidak Ada Pajaknya !\r\n\r\nApakah Data Sudah Benar ?")){
							//alert(url);
							grid.loadURL(url,"","GET");
							batal();
						}
					}else{
						if (confirm("Data Yg Mau diBayarkan Terdapat Pajak :\r\n"+msgalert+'\r\n\r\nApakah Data Sudah Benar ?')){
							//alert(url);
							grid.loadURL(url,"","GET");
							batal();
						}
					}
				}
			}else{
				alert("Pilih Data Yg Mau diBayar Terlebih Dahulu !");
			}
			
			$('divPop').popup.hide();
		}
        
		function batal(){
		  	document.getElementById('btnSimpan').disabled = false;
		  	document.getElementById('btnHapus').disabled = true;
			document.getElementById('btnBayar').disabled = true;
            document.getElementById('txtTgl').value = "<?php echo $tgl; ?>";
            document.getElementById('btnSimpan').innerHTML = 'Tambah';
            document.getElementById('id').value = '';
            document.getElementById('txtNoBu').value = '';
            document.getElementById('txtArea').value = '';
            document.getElementById('nilaiSPK').value = '';
			document.getElementById('nilai').value = '';
            document.getElementById('faktur').value = '';
            document.getElementById('txtNoBuktiBayar').value = '';
			document.getElementById('imgNilai').style.display = 'none';
            //document.getElementById('trSup1').style.display = 'none';
            document.getElementById('trSup2').style.display = 'none';
            document.getElementById('trFak').style.display = 'none';
			//document.getElementById('fldBayar').style.display = 'none';
			document.getElementById('tdNilai').innerHTML = 'Nilai';
			document.getElementById('trForm').style.display = 'none';
            document.getElementById('txtPPN').value = '';
            document.getElementById('txtPph21').value = '';
            document.getElementById('txtPph22').value = '';
            document.getElementById('txtPph23').value = '';
            document.getElementById('txtPph26').value = '';
            document.getElementById('txtPph29').value = '';
			document.getElementById('txtidMA').value = '';
			document.getElementById('txtMA').value = '';
			document.getElementById('txtJnsPeng').value = '';
            document.getElementById('txtTglBayarPajak').value = '';
			for(var i=1;i<=gb.getMaxRow();i++){
				var id = gb.getRowId(i);
				if(document.getElementById('nilai_'+id)!=null)
					document.getElementById('nilai_'+id).value = '';
			}
			gb.cellSubTotalSetValue(5,'');
            melakukan = '';
            if(document.getElementById('div_faktur').style.display == ''){
                document.getElementById('div_faktur').style.display = 'none';
            }
		  	if(first_load == 1){
				changeType(document.getElementById('cmbPend'));
		  	}
        }
	   
        function grid_act(){
		  document.getElementById('btnHapus').disabled = false;
            melakukan = 'edit';
            document.getElementById('btnSimpan').innerHTML = 'Simpan';
		  var sisip = grid.getRowId(grid.getSelRow()).split('|');
		  /*
		  sisip[0] = id
		  sisip[1] = id_trans
		  sisip[2] = jenis_layanan
		  sisip[3] = unit_id
		  sisip[4] = ket
		  sisip[5] = no_faktur
		  sisip[6] = supplier_id
		  sisip[7] = nilai
		  */
		  //no,tgl,nobukti,jenis trans,nilai,keterangan
            document.getElementById('id').value = sisip[0];
            document.getElementById('cmbPend').value = sisip[1];
			document.getElementById('txtIdTrans').value = sisip[1];
		  	changeType(document.getElementById('cmbPend'));
            document.getElementById('txtTgl').value = grid.cellsGetValue(grid.getSelRow(),2);
            document.getElementById('txtNoBu').value = grid.cellsGetValue(grid.getSelRow(),3);
            document.getElementById('txtArea').value = sisip[4];
            document.getElementById('nilai').value = sisip[7];
            document.getElementById('faktur').value = sisip[5];
			document.getElementById('txtidMA').value = sisip[11];
			document.getElementById('txtMA').value = grid.cellsGetValue(grid.getSelRow(),5);
			//document.getElementById('btnBayar').disabled = true;
			//document.getElementById('btnBayar').disabled = false;
			document.getElementById('txtKodeJnsPeng').value = sisip[13];
			document.getElementById('txtIdJnsPeng').value = sisip[3];
			document.getElementById('txtIdMaSak').value = sisip[14];
			gb.loadURL("ngutils.php?jtrans_kode="+document.getElementById('txtKodeJnsPeng').value,'','GET');
			document.getElementById('txtJnsPeng').value = grid.cellsGetValue(grid.getSelRow(),4);
			if(sisip[16]=='1'){
				cuma_satu = false;
				document.getElementById('imgNilai').style.display = 'inline';
			}else{
				cuma_satu = true;
				document.getElementById('imgNilai').style.display = 'none';
			}
			
			if (sisip[9]==1 && sisip[15]==0){
				document.getElementById('btnBayar').disabled=false;
			}else{
				document.getElementById('btnBayar').disabled=true;
			}
			
			var r = document.getElementById('nilai').value;
			if(isNaN(r))
			{
				document.getElementById('nilai').value='0';
			}
			else
			{
				while (r.indexOf(".")>-1)
				{
					r=r.replace(".","");
				}
				document.getElementById('nilai').value=FormatNumberFloor(parseInt(r),".");
			}

		    if(sisip[1] == 11){
				document.getElementById('cmbJenSup').value = sisip[8];
				document.getElementById('nilaiSPK').value = sisip[10];
				//alert(sisip[9]);
				if(sisip[8]==1){
					isiCombo('cmbSup','',sisip[6],'cmbSup',view_tab);
				}
				else if(sisip[8]==2){
					isiCombo('cmbBar','',sisip[6],'cmbSup',view_tab);
				}
				//document.getElementById('cmbSup').value = sisip[6];
		    }
		    if(sisip[2] != ''){
				document.getElementById('cmbJnsLay').value = sisip[2];
				isiCombo('cmbTemLayCCRV', sisip[2], sisip[3], 'cmbTemLay');
				
				for(var i=1;i<=gb.getMaxRow();i++){
					var id = gb.getRowId(i);
					if(document.getElementById('nilai_'+id)!=null)
						document.getElementById('nilai_'+id).value='';
				}
				ftemp = '';
				ftot = '';
				ftemp = sisip[12];
				ftot = sisip[7];
		    }
        }
	   
	   function grid_loaded(){
	   	if (isFirstLoad == false){
			isFirstLoad = true;
			batal();
		}
	   }
		
		var ftemp = '';
		var ftot = '';
		function grid_loaded2(){
			//alert('sdfsd');
			var temp = ftemp.split('#');
			for(var i=1;i<=temp.size()-1;i++){
				var data = temp[i].split('*');
				//alert(data[1]);
				if(document.getElementById('nilai_'+data[1])!=null)
					document.getElementById('nilai_'+data[1]).value = FormatNumberFloor(data[2],".");
				//mukti
			}
			gb.cellSubTotalSetValue(5,FormatNumberFloor(ftot,"."));
		}
        /*function cekDiv(){
            if(document.getElementById('divsup').innerHTML == ''){
                document.getElementById('trDiv').style.display = 'none';
            }
            else{
                var tmp = document.getElementById('divsup').innerHTML.split(String.fromCharCode(3));
                document.getElementById('divsup').innerHTML = tmp[0];
                if(tmp[1] <= 100){
                    document.getElementById('divsup').style.height = tmp[1]*1+5+'px';
                    document.getElementById('divsup').style.overflow = 'auto';
                }
                else{
                    document.getElementById('divsup').style.height = '110px';
                    document.getElementById('divsup').style.overflow = 'scroll';
                }
                document.getElementById('trDiv').style.display = 'table-row';
            }
        }*/
	   function goFilterAndSort(grd){
	   		if (grd=="divGrid"){
				var bln = document.getElementById('bln').value;
				var thn = document.getElementById('thn').value;
				stBayar = document.getElementById('stBayar').value;
				ViewBayar = 1;
				if (document.getElementById('fldBayar').style.display == 'none'){
					stBayar = 0;
					ViewBayar = 0;
				}
				
                grid.loadURL("pengeluaran_utils.php?pilihan=pengeluaran&stBayar="+stBayar+"&ViewBayar="+ViewBayar+"&bln="+bln+"&thn="+thn+"&filter="+grid.getFilter()+"&sorting="+grid.getSorting()+"&page="+grid.getPage(),"","GET");
            }
			else if(grd=="gd"){
				gb.loadURL("ngutils.php?filter="+gb.getFilter()+"&sorting="+gb.getSorting()+"&page="+gb.getPage(),"","GET");
			}
       }
	
	function chkKlik(p){
	var cekbox=(p==true)?1:0;
		//alert(p);
		for (var i=0;i<grid.getMaxRow();i++){
			grid.cellsSetValue(i+1,9,cekbox);
		}
	}

        grid=new DSGridObject("divGrid");
        grid.setHeader("DATA TRANSAKSI PENGELUARAN");
        grid.setColHeader("NO,TGL TRANSAKSI,NO BUKTI,JENIS TRANSAKSI,MATA ANGGARAN,NILAI,KETERANGAN,VERIFIKASI,PILIH<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
        grid.setIDColHeader(",tgl,no_bukti,nama_trans,ma_nama,nilai,ket,verifikasi,");
        grid.setColWidth("30,70,120,180,150,80,250,100,60");
        grid.setCellAlign("center,center,center,center,center,right,left,center,center");
		grid.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,chk");
        grid.setCellHeight(20);
        grid.setImgPath("../icon");
        grid.onLoaded(grid_loaded);
        grid.setIDPaging("paging");
        grid.attachEvent("onRowClick","grid_act");
		grid.attachEvent("onRowDblClick","popup1");	
        //alert("pengeluaran_utils.php?pilihan=pengeluaran&stBayar="+stBayar+"&ViewBayar="+ViewBayar+"&bln="+document.getElementById('bln').value+"&thn="+document.getElementById('thn').value);
		grid.baseURL("pengeluaran_utils.php?pilihan=pengeluaran&stBayar="+stBayar+"&ViewBayar="+ViewBayar+"&bln="+document.getElementById('bln').value+"&thn="+document.getElementById('thn').value);
        grid.Init();
        //+"&supplier="+document.getElementById('cmbSup').value
        var th_skr = "<?php echo $date_skr[2];?>";
        var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
		var fromHome=<?php echo $fromHome ?>;
    </script>
<script src="../report_form.js" type="text/javascript" language="javascript"></script>
<script>
    isiCombo('cmbSup','','','cmbSup');
    function fillSup(par){	   
	    if(par=='1'){
			isiCombo('cmbSup','','','cmbSup',view_tab);
	    }
	    else if(par=='2'){
			isiCombo('cmbBar','','','cmbSup',view_tab);
	    }
    }
	
	function filterSPK(){
		filter('in');
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
	
	function AutoRefresh(){
		filter();
		setTimeout("AutoRefresh()", 180000);
	}
	
	setTimeout("AutoRefresh()", 180000);
	//****************************************************
	gb=new DSGridObject("gd");
	gb.setHeader("INPUT NILAI");
	gb.setColHeader("NO,KODE REKENING,NAMA REKENING,KETERANGAN,NILAI");
	gb.setSubTotal(",,,SubTotal :&nbsp;,0");
	gb.setSubTotalAlign("center,center,center,right,right");
	gb.setIDColHeader(",tbl.parent,tbl.kode,tbl.nama,");
	gb.setColWidth("30,70,170,200,100");
	gb.setCellAlign("center,left,left,left,center");
	gb.setCellType("txt,txt,txt,txt,txt");
	gb.setCellHeight(20);
	gb.setImgPath("../icon");
	gb.onLoaded(grid_loaded2);
	//gb.attachEvent("onRowClick","grid_act");
	gb.baseURL("ngutils.php?jtrans_kode=0");
	gb.Init();
        
	function popup1(){
		if(document.getElementById('imgNilai').style.display=='inline'){
			new Popup('popLayanan',null,{modal:true,position:'center',duration:1});
			document.getElementById('popLayanan').popup.show();
			
			//alert("ngutils.php?j_trans_kode="+document.getElementById('txtKodeJnsPeng').value);
			//gb.loadURL("ngutils.php?jtrans_kode="+document.getElementById('txtKodeJnsPeng').value,'','GET');
		}
	}
	
	function batalkan(){
		if(melakukan=='add'){
			for(var i=1;i<=gb.getMaxRow();i++){
				var id = gb.getRowId(i);
				document.getElementById('nilai_'+id).value='';
			}
			gb.cellSubTotalSetValue(5,0);
			document.getElementById('nilai').value = '';
		}
	}
	
	function getIdNilai(){
		var temp = '';
		for(var i=1;i<=gb.getMaxRow();i++){
			var id = gb.getRowId(i);
			if(document.getElementById('nilai_'+id).value!=''){
				r=document.getElementById('nilai_'+id).value;
				while (r.indexOf(".")>-1){
					r=r.replace(".","");
				}
				var tmp = document.getElementById('nilai_'+id).lang+"*"+r;
				temp = temp+"|"+tmp;
			}
		}
		document.getElementById('fdata').value = temp;
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
	
	function ngeload_grid_detil(par){
		ftemp = '';
		ftot = '';
		gb.loadURL("ngutils.php?jtrans_kode="+par,'','GET');
	}
	
	var cuma_satu = false;
	function qwerty(satu){
		if(satu=='1'){
			document.getElementById('imgNilai').style.display = 'none';
			cuma_satu = true;
		}
		else{
			cuma_satu = false;
			document.getElementById('imgNilai').style.display = 'inline';
		}
	}
</script>
</html>

<?php
include '../sesi.php';
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') 
{
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
if(isset($_POST['act']) && isset($_POST['txtObat'])) 
{
   	
	
	$aa = $_REQUEST['obatid'];
	$bb = $_REQUEST['txtUraian'];
	$cc = $_REQUEST['vendor_id'];
	$dd = $_REQUEST['jenis_surat'];
	$ee = $_REQUEST['no_po'];
	
	//cek no_po
	$cek_jum = mysql_num_rows(mysql_query("select no_po from as_po where no_po='$ee'"));
	if($cek_jum>0)
	{
		
		
		$dcek =  mysql_fetch_array(mysql_query("select no_po from as_po where no_po like '$exp%' order by id desc limit 1"));
		$xx = explode("/",$dcek['no_po']);
		
		$no = $xx[2]+1;
		$no_baru = sprintf("%04d",$no);
		
		$bom = explode("/",$ee);
		$exp = $bom[0]."/".$bom[1];
		$ee =  $exp."/".$no_baru;
	}
	//
	
	$ff = tglSQL($_REQUEST['tgl']);
	$gg = $_REQUEST['judul'];
	$hh = tglSQL($_REQUEST['exp_kirim']);
	$ii = $_REQUEST['txtJml'];
	$jj = $_REQUEST['satuan'];
	$kk = $_REQUEST['txtNilai'];
	$mm = $_REQUEST['txtTotal'];
	$nn = $_REQUEST['txtunit'];
	$oo = $_REQUEST['user'];
	$pp = $_REQUEST['veri'];
	
	$total_brg = count($_REQUEST['obatid']); //echo $total_brg;
		
	for($i=0;$i<$total_brg;$i++)
	{
		$ms_barang_id 	= $aa[$i];
		$uraian 		= $bb[$i];
		$vendor_id 		= $cc;
		$jenis_surat 	= $dd;
		$no_po 			= $ee;
		$tgl_po 		= $ff;
		$judul 			= $gg;
		$exp_kirim	 	= $hh;
		$qty_satuan		= $ii[$i];
		$satuan			= $jj[$i];
		$harga_satuan	= $kk[$i];
		$subtotal		= $kk[$i];
		$total			= $mm[$i];
		$peruntukan		= $nn[$i];
		$pembuat		= $oo;
		$verifikator	= $pp;
		//echo $ms_barang_id."<br>";	
		$query = "insert into as_po (ms_barang_id,uraian,vendor_id,jenis_surat,no_po,tgl_po,judul,exp_kirim,qty_satuan,satuan,harga_satuan,subtotal,total,peruntukan ,tgl_act,pembuat,verifikator) values ('$ms_barang_id','$uraian','$vendor_id','$jenis_surat','$no_po','$tgl_po','$judul','$exp_kirim','$qty_satuan','$satuan','$harga_satuan','$subtotal','$total','$peruntukan',NOW(),'$pembuat','$verifikator')";
		//echo $query ."<br>";
		if(mysql_query($query))
		{
			header("location:po.php");
		}
		else
		{
			echo "<script>alert('Input Data Gagal ');window.location='po.php'</script>";
		}
	}
		
    
	
}



$qry="select * from as_ms_satuan order by nourut";
$exe=mysql_query($qry);
$sel="";
$i=0;
while($show=mysql_fetch_array($exe)) 
{
    $sel .="sel.options[$i] = new Option('".$show['idsatuan']."', '".$show['idsatuan']."');";
    $i++;
}

$qry="select idunit, namaunit from as_ms_unit";
$exe=mysql_query($qry);
$selUnit="";
$i=0;
while($show=mysql_fetch_array($exe)) 
{
    $selUnit .="sel.options[$i] = new Option('".$show['namaunit']."', '".$show['idunit']."');";
    $i++;
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
       	
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
		<link rel="stylesheet" type="text/css" href="../theme/li/popup.css" />
		<!--<script type="text/javascript" src="../theme/li/prototype.js"></script>-->
		<script type="text/javascript" src="../theme/li/effects.js"></script>
		<script type="text/javascript" src="../theme/li/popup.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/li/popup2.js"></script>
		<script src="jquery-1.7.1.js"></script>
		<!--<script>jQuery.noConflict();</script>-->
		
        <title>.: PO :.</title>
    </head>
    <body onLoad="set_NO_PO('<?=$_REQUEST['act'];?>')">
        <?php
		include("popBrg.php");
        include '../header.php';
        $act = $_GET['act'];
        if($act == '') {
            $act = 'add';
        }
        ?>
        
        <div align="center">
       
            <div id="divbarang" align="left" style="position:absolute; z-index:65005; left: 200px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center">
                        <form name="form1" id="form1" method="post" action="">
                            <input name="act" id="act" type="hidden" value="<?php echo $act;?>">
                            <input name="fdata" id="fdata" type="hidden" value="">
                            <table width="98%" border="0">
                                <tr>
                                    <td>
                                        <div id="input" style="display:block" align="center">
                                            <table width="100%" border="0" cellpadding="1" cellspacing="1" align="center">
                                                <tr height="20">
                                                    <td class="tdlabel">Jenis Surat </td>
                                                    <td colspan="2">:
                                                        <!--input name="jenis_surat" id="jenis_surat" class="txtunedited" size="25" value="" /-->
                                                        <select id="jenis_surat" name="jenis_surat" class='txt'  onChange="set_NO_PO('<?=$_REQUEST['act'];?>')">
                                                            <?php
                                                            $sql = "select jns_id,jns from as_jenis_surat";
                                                            $rsJ = mysql_query($sql);
                                                            while($rowJ = mysql_fetch_array($rsJ)){
                                                                echo "<option value='".$rowJ['jns_id']."' ";
                                                                if($rowJ['jns_id'] == $rows1['jenis_surat']){
                                                                    echo "selected";
                                                                }
                                                                echo " >".$rowJ['jns']."</option>";
                                                            }
                                                            ?>
                                                        </select>                                                    </td>
                                                </tr>
                                                <tr height="20">
                                                    <td width="176" class="tdlabel">Tanggal&nbsp; </td>
                                                    <td colspan="2">:
                                                        <input name="tgl" type="text" class="txtunedited" id="tgl" tabindex="4" value="<?php if(isset($_REQUEST['tglPo']) && $_REQUEST['tglPo'] != '') echo $_REQUEST['tglPo'];else echo date('d-m-Y'); ?>" size="15" maxlength="15" readonly>
                                                        <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange,ganti_nmr);">                                                  </td>
                                                </tr>
                                                <tr height="20">
                                                    <td class="tdlabel">Nomor</td>
                                                  <td colspan="2">:
                                                        <input name="no_po" id="no_po" class="txt" size="25" value="<?php echo $no_po;?>" /></td>
                                                </tr>
                                                <tr height="20">
                                                    <td class="tdlabel">Supplier</td>
                                                    <td colspan="2">:
                                                        <select id="vendor_id" class="txt" name="vendor_id">
                                                            <?php
                                                            $query = "select idrekanan, namarekanan from as_ms_rekanan";
                                                            $rs = mysql_query($query);
                                                            while($row = mysql_fetch_array($rs)) {
                                                                ?>
                                                            <option value="<?php echo $row['idrekanan'];?>" <?php if($row['idrekanan'] == $vendor_id) echo 'selected';?>><?php echo $row['namarekanan'];?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>                                                    </td>
                                                </tr>
                                                
                                                <tr height="20">
                                                    <td class="tdlabel">Jatuh Tempo Pengiriman </td>
                                                    <td colspan="2">: 
                                                        <input name="exp_kirim" type="text" class="txtunedited" id="exp_kirim" tabindex="4" value="<?php if(isset($_REQUEST['tgl_expnya']) && $_REQUEST['tgl_expnya'] != '') echo $_REQUEST['tgl_expnya'];else echo date('d-m-Y'); ?>" size="15" maxlength="15" readonly>
                                                        <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('exp_kirim'),depRange);">                                                    </td>
                                                </tr>
                                                
                                                <tr height="20">
                                                    <td class="tdlabel">
							Judul PO                                                    </td>
                                                    <td width="795">
							: 
							  <input type="text" style="text-align:left" name="judul" id="judul" value="<?php echo $judul;?>" class="txt" size='75' />                                                  </td>
												  <!--td width="329" align="center"><input type="button" id="ctk" name="ctk" value="Cetak PO" onClick="window.open('cetak_po.php?jns='+jenis_surat.value+'&tgl='+tgl.value+'&nomor='+no_po.value+'&supplier='+vendor_id.value+'&tgl_kirim='+exp_kirim.value+'&jdl='+judul.value+'&no_po=<?php echo $no_po; ?>')"></td-->
                                                </tr>
												<tr height="20">
													<td>Pembuat</td>
													<td>: <input type="text" class="txt" size="12" readonly id="user" name="user" value="<?php echo $_SESSION['userid']?>"></td>
												</tr>
												<tr height="20">
													<td>Verifikator</td>
													<td>: 
													  <input type="text" class="txt" id="veri" name="veri" value="<?php echo $rows1['verifikator']?>"></td>
												</tr>
												<tr height="20">
												  <td>&nbsp;</td>
												  <td>&nbsp;</td>
											  </tr>
                                            </table>
                                        </div>

                                        <div style="width:975px; height: inherit; overflow:auto; ">
                                            
                                            <table id="tblJual" width="100%" border="0" cellpadding="1" cellspacing="1" align="center">
                                                <tr>
                                                    <td colspan="10" align="center" class="jdltable"><!--<hr size="1" color="#6194C7">--></td>
                                                </tr>
                                                <tr>
													<td colspan="2">&nbsp;													</td>
                                                    <td colspan="6" align="center" class="jdltable">
                                                        PURCHASE ORDER</td>
                                                
                                                    <td width="123" align="right" valign="bottom">&nbsp;</td>
													<td><input type="hidden" class="txt" readonly id="urutan_pop" name="urutan_pop" size="5" value="0">
                                                      <input name="button" type="button" style=" cursor:pointer; color:#FFFFFF; font-weight:bold; background: #009900; padding:3px; border:1px solid #003366;" onClick="addRowToTable();" value=" (+) List" /></td>
                                                </tr>
                                                <tr class="headtable" height=35>
                                                    <td width="19"  class="tblheaderkiri">No</td>
                                                    <td width="107" class="tblheader">Kode Barang</td>
                                                    <td width="334" class="tblheader">Nama Barang</td>
                                                    <td width="99" class="tblheader">Uraian</td>
                                                    <td width="37" class="tblheader">Jml</td>
                                                    <td width="41" class="tblheader">Satuan</td>
                                                    <td class="tblheader" width="63">Harga Satuan</td>
                                                    <!--td width="40" height="25" class="tblheader">Lain-lain</td-->
                                                    <!--td class="tblheader">Sub Total</td-->
                                                    <td width="66" class="tblheader">Total</td>
                                                    <td class="tblheader" align="center">Peruntukan</td>
                                                    <td width="86" class="tblheader">Proses</td>
                                                </tr>
                                                <?php
                                                if($edit == true) {
                                                    $sql = "select ap.*,id,ms_barang_id,uraian,kodebarang,ap.peruntukan,namabarang,vendor_id,namarekanan,no_po,date_format(tgl_po,'%d-%m-%Y') as tgl,satuan,qty_satuan,lain2,harga_satuan,unit_id,ab.idsatuan
                                                        from as_po ap inner join as_ms_barang ab on ap.ms_barang_id = ab.idbarang left join as_ms_rekanan ar on ap.vendor_id = ar.idrekanan
                                                        where no_po = '".$_GET['no_po']."' and tgl_po='".tglSQL($_GET['tglPo'])."' order by id asc"; //echo $sql;
                                                    $rs1 = mysql_query($sql);
                                                    $i = 0;
													$increment = 0;
                                                    while($rows1 = mysql_fetch_array($rs1)) {
													if($increment==0){
													$idbrg = $rows1['ms_barang_id'];
													}else{
													$idbrg .= "**".$rows1['ms_barang_id'];
													}
													$increment++;
                                                    $status = $rows1['status'];
                                                    	$visible = 'visible';
                                                    	$read = '';
                                                    	if($status==1){$visible='hidden';$read='readonly';}
                                                        ?>
                                                
                                                        <?php
                                                    }
                                                }
                                                else { //Ini digunakan untuk tampilan Add
                                                    ?>
                                                
                                                <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
                                                    <td class="tdisikiri" width="19">1                                                    </td>
                                                    <td class="tdisi" align="center" id="kode_0">-</td>
                                                    <td class="tdisi" align="center">
                                                        <input type="hidden" name="obatid[]" id="obatid_0" value="">
                                                        <input type="text" name="txtObat[]" id="txtObat_0" class="txtinput" size="20" readonly="true" onKeyUp="" autocomplete="off" /><img alt="tree" width="18" title='Struktur tree kode barang'  style="cursor:pointer" border=0 src="../images/backsmall.gif" align="absbottom" onClick="treebrg(this,0)">                                                    </td>
                                                     <td class="tdisi">
                                                        <input type="text" name="txtUraian[]" size="15" id="txtUraian_0" class="txtinput" autocomplete="off" />                                                    </td>
                                                    <td class="tdisi">
                                                        <input type="text" name="txtJml[]" id="txtJml_0" class="txtcenter" size="3" onKeyUp="hitung_perkalian(0);" autocomplete="off" />                                                    </td>
                                                    <td class="tdisi">
                                                        <input type="text" name="satuan[]" id="satuan_0" size="5" class="txtinput" readonly="readonly" />                                                    </td>
                                                    <td class="tdisi">
                                                        <input type="text" name="txtNilai[]" class="txtright" id="txtNilai_0" onKeyUp="hitung_perkalian(0);" size="10" autocomplete="off" />                                                    </td>
                                                        <input name="txtSubTotal[]" id="txtSubTotal_0" type="hidden" class="txtright" size="10" readonly="true" />
                                                    <!--/td-->
                                                    <td class="tdisi">
                                                        <input type="text" name="txtTotal[]" id="txtTotal_0" class="txtright sub_totalx" size="10" readonly autocomplete="off" /><!-- onKeyUp="AddRow(event,this,'txtTotal')"-->                                                    </td>
                                                    <td class="tdisi">
                                                    <!--input type="hidden" id="utk_unit_id" class="txtinput" name="utk_unit_id"--> 
                                                    <input type="text" name="txtunit[]" id="txtunit_0" class="txtinput" size="20" onKeyUp="" autocomplete="off" />
                                                        <!--img alt="tree" width="18" title='Struktur tree unit'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="treeunit(this);"-->                                                    </td>
                                                    <td class="tdisi">
                                                        <img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del');}">                                                    </td>
                                                </tr>
                                                    <?php
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                          </table>
                            <table width="90%" align="center">
                                <tr>
                                    <td width="88%" class="txtright">Total :</td>
                                    <td id="total" width="11%" align="right" class="txtright">0</td>
                                    <td width="1%">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td height="30" colspan="4" valign="bottom" align="center">
                                        <!--button type="button" class="Enabledbutton" id="btnDist" name="btnDist" onClick="activate()" title="Save" style="cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            DISTRIBUSI BIAYA LAIN-LAIN
                                        </button-->
                                        <button type="button" class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="save()" title="Save" style="cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Save Record
                                        </button>
                                        <button type="reset" class="Enabledbutton" id="backbutton" onClick="location='po.php'" title="Back" style="cursor:pointer">
                                            <img alt="cancel" src="../icon/cancel.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Cancel
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <?php
                        include '../footer.php';
                        ?>
                    </td>
                </tr>
            </table>
			
        </div>
    </body>
    <iframe height="193" width="168" name="gToday:normal:agenda.js"
            id="gToday:normal:agenda.js"
            src="../theme/popcjs.php" scrolling="no"
            frameborder="1"
            style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
    </iframe>
    <script type="text/javascript" language="javascript">
    	 /* var js = document.getElementById('jenis_surat').value;
    	  var nopo = document.getElementById('no_po').value;
		  var act = document.getElementById('act').value;
		  //alert(nopo);
    	  if(act=='edit'){
				for(var g=0;g<nopo.length;g++){
				//alert(nopo[g]);
						if(nopo[g]=='.'){
								nopo = nopo.substring(g+1,nopo.length);
																
								break;							
							}					
					}    	 
					}
    	  document.getElementById('no_po').value=js+"."+nopo;
    	  
    	  function setp(gap){
    	  var nopo = document.getElementById('no_po').value;
    	  	for(var g=0;g<nopo.length;g++){
						if(nopo[g]=='.'){
								nopo = nopo.substring(g+1,nopo.length);
								//alert(nopo);								
								break;							
							}					
					} 
    	  document.getElementById('no_po').value=gap+"."+nopo;    	  	
    	  	}*/
        var arrRange=depRange=[];
        var RowIdx;
        var fKeyEnt;
        /*
        function activate(){
            if(isNaN(document.getElementById('others').value) && document.getElementById('others').value != ''){
                alert('Biaya lain-lain hanya bisa diisi dengan angka.');
                document.getELementById('others').value = 0;
            }

            if (document.form1.txtSubTotal.length){
                for(var i=0; i<document.form1.txtSubTotal.length; i++){
                    //alert((document.form1.txtJml[i-1].value*1)*(document.form1.txtNilai[i-1].value*1));
                    document.form1.txtSubTotal[i].value=(document.form1.txtNilai[i].value*1);//(document.form1.txtJml[i-1].value*1)*(document.form1.txtNilai[i-1].value*1);
                }
                var cStot=0;
                for (var i=0;i<document.form1.txtSubTotal.length;i++){
                    //alert(document.form1.txtSubTot[i].value);
                    document.form1.txtTotal[i].value=(document.form1.txtJml[i].value*1)*(document.form1.txtNilai[i].value*1);
                    cStot +=(document.form1.txtTotal[i].value*1);
                }
                document.getElementById('total').innerHTML=cStot;
            }
            else{
                document.form1.txtSubTotal.value=(document.form1.txtNilai.value*1);
                //(document.form1.txtJml.value*1)*(document.form1.txtNilai.value*1);
                document.form1.txtTotal.value = (document.form1.txtJml.value*1)*(document.form1.txtNilai.value*1);
                document.getElementById('total').innerHTML = document.form1.txtTotal.value;
            }

            var totAll = document.getElementById('total').innerHTML;
            //var others = document.getElementById('others').value;
            var lain2, tmp, total = 0;
            //jml = a
            //harga = b 
            //total = c
            //lain2 = x
            //subtotal = b+((a*b/c)*x/a)
            //total = subtotal * a
            if(document.form1.txtSubTotal.length){
                var rowCount = document.form1.txtSubTotal.length;
                for(var i=0; i<rowCount; i++){
                    var nilai = (document.forms[0].txtNilai[i].value*1);
                    var jml = (document.forms[0].txtJml[i].value*1);
                    lain2 = (others*(nilai*jml)/totAll).toString().split('.');
                    if(lain2[1] != undefined){
                        lain2 = lain2[0]+'.'+lain2[1].substr(0, 2);
                    }
                    else{
                        lain2 = lain2[0];
                    }
                    lain2 = parseFloat(lain2);
                    document.forms[0].txtLain2[i].value = lain2;
                    //document.forms[0].txtSubTotal[i].value = nilai+lain2/(nilai*jml);
                    tmp = (nilai+lain2/jml).toString().split('.');
                    if(tmp[1] != undefined){
                        tmp = tmp[0]+'.'+tmp[1].substr(0,2);
                    }
                    else{
                        tmp = tmp[0];
                    }
                    tmp = parseFloat(tmp);
                    document.forms[0].txtSubTotal[i].value = tmp;
                    tmp = (nilai*jml+lain2).toString().split('.');
                    if(tmp[1] != undefined){
                        tmp = tmp[0]+'.'+tmp[1].substr(0,2);
                    }
                    else{
                        tmp = tmp[0];
                    }
                    tmp = parseFloat(tmp);
                    document.forms[0].txtTotal[i].value = tmp;
                    total += nilai*jml+lain2;
                }
                tmp = Math.round(total);
                total = tmp<total?total+1:tmp;
                document.getElementById('total').innerHTML = total;
            }
            else{
                var nilai = (document.getElementById('txtNilai').value*1);
                var jml = (document.getElementById('txtJml').value*1);
                lain2 = others*(jml*nilai)/totAll;
                document.form1.txtLain2.value = lain2;
                document.form1.txtTotal.value = nilai*jml+lain2;
                //document.getElementById('txtSubTotal').value = nilai+lain2/(nilai*jml);
                document.getElementById('txtSubTotal').value = nilai+lain2/jml;
                document.getElementById('total').innerHTML = nilai*jml+lain2;
            }
            document.getElementById('btnSimpan').disabled = false;
        }*/
		//function riz(){
			//window.location='po_detil.php?cmbIventaris='+document.getElementById('cmbfilter').value;
			//alert(cmbIventaris);
	//	}
		
        function setDisable(ev,par){
            if(ev == 'del'){
                document.getElementById('btnSimpan').disabled = false;
                return;
            }
            else if(isNaN(par.value)){
                alert('Input harus berupa angka.');
                //document.getElementById('btnSimpan').disabled = true;
            }
            var listNum = '8,46,96,97,98,99,100,101,102,103,104,105,110';
            listNum = listNum.split(',');
            for(var i=0; i<listNum.length; i++){
                if(ev.which == listNum[i]){
                    //document.getElementById('btnSimpan').disabled = true;
                    break;
                }
            }
        }
        function treebrg(rew,urutan)
		{
			//alert(urutan);
			document.getElementById('urutan_pop').value=urutan;
			
				Popup.showModal('popList',null,null,{'screenColor':'silver','screenOpacity':.6});
				return false;
				document.getElementById("nmBarang").value='';
				
        }
			
		function treeunit(par)
		{
			var tbl = document.getElementById('tblJual');
			var jmlRow = tbl.rows.length;
			var i;
			if (jmlRow > 4)
			{
				i=par.parentNode.parentNode.rowIndex-2;
			}
			else
			{
				i=0;
			}
			Popup.showModal('popList',null,null,{'screenColor':'silver','screenOpacity':.6});
			return false;
			document.getElementById("nmBarang").value='';
							
		}
     
		function fsetUnit(par)
		{
			if(par!="")
			{
				var cdata=par.split("*|*");
				var tbl = document.getElementById('tblJual');
				var tds;
				if ((cdata[0]*1)==0)
				{
					document.forms[0].utk_unit_id.value=cdata[1];
					alert(cdata[1])
					document.forms[0].txtunit.value=cdata[2];
				}
				else
				{
					var w;
					for (var x=0;x<document.forms[0].utk_unit_id.length-1;x++)
					{
						w=document.forms[0].utk_unit_id[x].value.split('|');
					   
					}
					document.forms[0].utk_unit_id[(cdata[0]*1)-1].value=cdata[1];
					document.forms[0].txtunit[(cdata[0]*1)-1].value=cdata[2];
				}
			}
		}
		
		/*function fSetObat(par)
		{
			if(par!="")
			{
				var cdata=par.split("*|*");
				var tbl = document.getElementById('tblJual');
				var tds;
				var baris = tbl.rows.length;
				if ((cdata[0]*1)==0)
				{
						if(baris==4)
						{
							document.forms[0].obatid.value=cdata[1];
							document.forms[0].txtObat.value=cdata[3];
							document.forms[0].satuan.value=cdata[4];
							tds = tbl.rows[3].getElementsByTagName('td');
						}
						else
						{
							document.forms[0].obatid[(cdata[0]*1)-1].value=cdata[1];
							document.forms[0].txtObat[(cdata[0]*1)-1].value=cdata[3];
							document.forms[0].satuan[(cdata[0]*1)-1].value=cdata[4];
							tds = tbl.rows[(cdata[0]*1)+3].getElementsByTagName('td');
						}//document.forms[0].txtHarga.value=cdata[4];
					//document.forms[0].satuan.focus();
				}
				else
				{
					var w;
					document.forms[0].obatid[(cdata[0]*1)].value=cdata[1];
					document.forms[0].txtObat[(cdata[0]*1)].value=cdata[3];
					document.forms[0].satuan[(cdata[0]*1)].value=cdata[4];
					tds = tbl.rows[(cdata[0]*1)+3].getElementsByTagName('td');
					//document.forms[0].txtHarga[(cdata[0]*1)-1].value=cdata[4];
					document.forms[0].satuan[(cdata[0]*1)-1].focus();
					//alert(cdata[1]);
				}
				tds[1].innerHTML=cdata[2];
				var no_p0 = document.getElementById('no_po').value;
				var no_p = no_p0.split('/');
				if(cdata[2].substring(0,2)=='03')
				{
							   no_p0 = "011/"+no_p[1]+"/"+no_p[2]+"/"+no_p[3];
				}
					document.getElementById('no_po').value = no_p0;
				//tds[3].innerHTML=cdata[3];
			
				document.getElementById('divbarang').style.display='none';
			}
		}*/
	<!--==============================================================================================================-->
	
var RowIdx3;
var fKeyEnt3;
var cmb=document.getElementById("CmbStt").value;

function list1(e,par){
var urutan = document.getElementById('urutan_pop').value;
//alert(urutan)
var keywords=par.value;//alert(keywords);
var i;
var tbl = document.getElementById('tblJual');
var jmlRow = tbl.rows.length;
if (jmlRow >= 4){
	i=par.parentNode.parentNode.rowIndex-1;
}else{
	i=0;
}
var nomer=jmlRow-4;
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
		if (key==38 || key==40)
		{
			var tblRow=document.getElementById('tblObat').rows.length;
			var row_data = tblRow-1;
			if (tblRow>0)
			{
				//alert(RowIdx3);
				if (key==38 && RowIdx3>0)
				{
					if(RowIdx3==0)
					{
						
					}
					else if(RowIdx3==1)
					{
						document.getElementById("list_"+RowIdx3).className='itemtableReq';
						RowIdx3=RowIdx3-1;
					}
					else
					{
						document.getElementById("list_"+RowIdx3).className='itemtableReq';
						RowIdx3=RowIdx3-1;
						document.getElementById("list_"+RowIdx3).className='itemtableMOverReq';
					}
				}
				else if (key==40 && RowIdx3<tblRow)
				{
					//alert(row_data)
					if (RowIdx3==0)
					{
						RowIdx3=RowIdx3+1;
						document.getElementById("list_"+RowIdx3).className='itemtableMOverReq';
					}
					else if (RowIdx3==row_data)
					{
						
					}
					else
					{
						document.getElementById("list_"+RowIdx3).className='itemtableReq';
						RowIdx3=RowIdx3+1;
						document.getElementById("list_"+RowIdx3).className='itemtableMOverReq';
					}
					
					
				}
			}
		}
		else if (key==13){
			if (RowIdx3>0){
				if (fKeyEnt3==false){
					ValNamaBag(document.getElementById("list_"+RowIdx3).lang);
				}else{
					fKeyEnt3=false;
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			RowIdx3=0;
			fKeyEnt3=false;
			if (document.getElementById('nmBarang').value.length>=3){
			Request('list_barang.php?aKeyword='+keywords+'&no='+nomer+'&cmb='+document.getElementById("CmbStt").value, 'divbarang', '', 'GET' );
			if (document.getElementById('divbarang').style.display=='none') fSetPosisi(document.getElementById('divbarang'),par);
			document.getElementById('divbarang').style.display='block';
			}
		}
	}
}
function ValNamaBag(par)
{
	var xx = document.getElementById('urutan_pop').value;//alert(xx)
	var cdata=par.split("|");
	document.getElementById('kode_'+xx).innerHTML=cdata[2];
	document.getElementById('obatid_'+xx).value=cdata[1];
	document.getElementById('txtObat_'+xx).value=cdata[3];
	document.getElementById('satuan_'+xx).value=cdata[4];
	document.getElementById('divbarang').style.display='none';
	Popup.hide('popList');
	/*if(par!="")
	{
		var cdata=par.split("|");
		var tbl = document.getElementById('tblJual');
		var tds;
		var baris = tbl.rows.length;
		if ((cdata[0]*1)==0)
		{
			if(baris==4)
			{
				document.forms[0].obatid.value=cdata[1];
				document.forms[0].txtObat.value=cdata[3];
				document.forms[0].satuan.value=cdata[4];
				tds = tbl.rows[3].getElementsByTagName('td');
			}
			else
			{
				document.forms[0].obatid[(cdata[0])].value=cdata[1];
				document.forms[0].txtObat[(cdata[0])].value=cdata[3];
				
			}
		}
		else
		{
			var w;
			document.forms[0].obatid[(cdata[0])].value=cdata[1];
			document.forms[0].txtObat[(cdata[0])].value=cdata[3];
			document.forms[0].satuan[(cdata[0])].value=cdata[4];
			tds = tbl.rows[(cdata[0]*1)+3].getElementsByTagName('td');
			document.forms[0].satuan[(cdata[0]*1)-1].focus();
		
		}
		tds[1].innerHTML=cdata[2];
		document.getElementById('divobat').style.display='none';
	}
	Popup.hide('popList');*/
}
	
	<!--==============================================================================================================-->
	<?
	if($_REQUEST['act']=='add')
	{
	?>
			var xx = 0;
			var tbl = document.getElementById('tblJual');
			//var jmlRow = tbl.rows.length; alert(jmlRow)
	<?	 
	}
	else
	{
	?>
		var tbl = document.getElementById('tblJual');
		var jmlRow = tbl.rows.length-2;
	<?
	}
	?>
	
	
        function addRowToTable()
        {
			xx++;
			//document.getElementById('urutan').value=xx;
            //use browser sniffing to determine if IE or Opera (ugly, but required)
            var isIE = false;
            if(navigator.userAgent.indexOf('MSIE')>0){
                isIE = true;
            }
            //	alert(navigator.userAgent);
            //	alert(isIE);
            var tbl = document.getElementById('tblJual');
            var lastRow = tbl.rows.length;
            // if there's no header row in the table, then iteration = lastRow + 1
            var iteration = lastRow;
            var row = tbl.insertRow(lastRow);
            //row.id = 'row'+(iteration-1);
            row.className = 'itemtableA';
            //row.setAttribute('class', 'itemtable');
            row.onmouseover = function(){this.className='itemtableAMOver';};
            row.onmouseout = function(){this.className='itemtableA';};
            //row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
            //row.setAttribute('onMouseOut', "this.className='itemtable'");

            // left cell
            var cellLeft = row.insertCell(0);
            var textNode = document.createTextNode(iteration-2);
            cellLeft.className = 'tdisikiri';
            cellLeft.appendChild(textNode);

            // right cell
            cellLeft = row.insertCell(1);
            textNode = document.createTextNode('-');
			cellLeft.id = 'kode_'+xx;
            cellLeft.className = 'tdisi';
            cellLeft.appendChild(textNode);

            // right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'obatid[]';
                el.id = 'obatid_'+xx;
            }else{
                el = document.createElement('<input name="obatid[]" id="obatid_'+xx+'"/>');
            }
            el.type = 'hidden';
            el.value = '';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

            if("<?php echo $edit;?>" == true){
                //generate id
                if(!isIE){
                    el = document.createElement('input');
                    el.name = 'id';
                    el.id = 'id';
                }else{
                    el = document.createElement('<input name="id" id="id_'+xx+'" />');
                }
                el.type = 'hidden';
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);
            }

            //generate txtobat
            if(!isIE){
                el = document.createElement('input');
               tree = new Image();
               tree.src="../images/backsmall.gif";
               tree.setAttribute('onclick', "treebrg(this,"+xx+");");
               tree.style.cursor = "pointer";
                el.name = 'txtObat[]';
                el.id = 'txtObat_'+xx;
                el.setAttribute('autocomplete', "off");
            }else{
                el = document.createElement('<input name="txtObat" id="txtObat_'+xx+'" onkeyup="" readonly autocomplete="off" />&nbsp;');
                tree = document.createElement('<img alt="tree" title="Struktur tree kode barang"  style="cursor:pointer" border=0 src="../images/backsmall.gif" align="absbottom" onClick="treebrg(this,'+xx+')">');
            }
            el.type = 'text';
            //el.id = 'txtObat'+(iteration-1);
            el.size = 20;
            tree.width = 17;
            tree.align = "absmiddle";
            el.setAttribute("readonly","true");
            el.className = 'txtinput';
            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
				//tree = document.createElement('<img alt="tree" title="Struktur tree kode barang"  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="treebrg()">');
				//tree.size = 10;
				cellRight.appendChild(tree);
            // right cell
            cellRight = row.insertCell(3);
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txtUraian[]';
                el.id = 'txtUraian_'+xx;                
                el.setAttribute('autocomplete', "off");
            }else{
                el = document.createElement('<input name="txtUraian" id="txtUraian_'+xx+'" autocomplete="off" />');
            }
            el.type = 'text';
            el.size = 15;
            el.className = 'txtinput';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
            
            // right cell
            cellRight = row.insertCell(4);
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txtJml[]';
                el.id = 'txtJml_'+xx;
                el.setAttribute('onKeyUp', "hitung_perkalian("+xx+")");
                el.setAttribute('autocomplete', "off");
            }else{
                el = document.createElement('<input name="txtJml" id="txtJml_'+xx+'" onKeyUp="hitung_perkalian('+xx+');" autocomplete="off" />');
            }
            el.type = 'text';
            el.size = 3;
            el.className = 'txtcenter';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
            
            if(!isIE){
                cellRightSel = row.insertCell(5);
                sel = document.createElement('input');
                sel.name = 'satuan[]';
                sel.id = 'satuan_'+xx;
                sel.size = 5;
                sel.setAttribute('readonly',"readonly");
                sel.className = "txtinput";
            }
            else{
                sel.document.createElement('<input name="satuan[]" id="satuan_'+xx+'" readonly="readonly" />');
            }

            cellRightSel.className = 'tdisi';
            cellRightSel.appendChild(sel);
                        

                        /*  cellLeft = row.insertCell(3);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
                         */
                        // right cell
                        cellRight = row.insertCell(6);
                        if(!isIE){
                            el = document.createElement('input');
                            el.name = 'txtNilai[]';
                            el.id = 'txtNilai_'+xx;
                            el.setAttribute('onKeyUp', "hitung_perkalian("+xx+")");
                            el.setAttribute('autocomplete', "off");
                        }else{
                            el = document.createElement('<input name="txtNilai" id="txtNilai_'+xx+'" onKeyUp="hitung_perkalian('+xx+');" autocomplete="off" />');
                        }
                        el.type = 'text';
                        el.size = 10;
                        el.className = 'txtright';

                        cellRight.className = 'tdisi';
                        cellRight.appendChild(el);

                        /*// right cell
                        cellRight = row.insertCell(6);
                        if(!isIE){
                            el = document.createElement('input');
                            el.name = 'txtLain2';
                            el.id = 'txtLain2';
                            el.setAttribute('readonly', "true");
                        }else{
                            el = document.createElement('<input name="txtLain2" readonly="true" />');
                        }
                        el.type = 'text';
                        el.size = 10;
                        el.className = 'txtright';

                        cellRight.className = 'tdisi';
                        cellRight.appendChild(el);
                        */

                        // right cell
                        //cellRight = row.insertCell(7);
                        if(!isIE){
                            el = document.createElement('input');
                            el.name = 'txtSubTotal[]';
                            el.id = 'txtSubTotal_'+xx;
                            el.setAttribute('readonly', "true");
                        }else{
                            el = document.createElement('<input name="txtSubTotal" id="txtSubTotal_'+xx+'" readonly="true" />');
                        }
                        el.type = 'hidden';
                        el.size = 5;
                        el.className = 'txtright';

                        cellRight.className = 'tdisi';
                        cellRight.appendChild(el);

                        // right cell
                        cellRight = row.insertCell(7);
                        if(!isIE){
                            el = document.createElement('input');
                            el.name = 'txtTotal[]';
                            el.id = 'txtTotal_'+xx;
                            el.setAttribute('readonly', "true");
                            //el.setAttribute('onKeyUp', "AddRow(event,this,'txtTotal')");
                            el.setAttribute('autocomplete', "off");
                        }else{
                            el = document.createElement('<input name="txtTotal[]" id="txtTotal_'+xx+'" readonly autocomplete="off" />');// onKeyUp="AddRow(event,this)"
                        }
                        el.type = 'text';
                        el.size = 10;
                        el.className = 'txtright sub_totalx';

                        cellRight.className = 'tdisi';
                        cellRight.appendChild(el);

             cellRightSel = row.insertCell(8);
			 el = document.createElement('input');
                el.name = 'txtunit[]';
                el.id = 'txtunit_'+xx;
                el.size = 20;
                el.setAttribute('autocomplete', "off");
                //el.setAttribute('readonly', "true");
                el.className = 'txtinput';
                //sel.align = "absmiddle";
                cellRightSel.className = 'tdisi';
                
                cellRightSel.appendChild(el);
                     //   sel = document.createElement('img');
                     //  sel.src = "../images/view_tree.gif"; 
                     //   sel.setAttribute("onclick","treeunit(this);");
                			//sel.border = "0";
                			//sel.width = 17;
                			//sel.style.cursor = "pointer";
            /*if(!isIE){
                el = document.createElement('input');
                el.name = 'txtunit[]';
                el.id = 'txtunit_'+xx;
            }else{
                el = document.createElement('<input name="txtunit[]" id="txtunit_'+xx+'"/>');
            }
            el.type = 'hidden';
            el.value = '';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

            if("<?php echo $edit;?>" == true){
                //generate id
                if(!isIE){
                    el = document.createElement('input');
                    el.name = 'id[]';
                    el.id = 'id_'+xx;
                }else{
                    el = document.createElement('<input name="id" id="id_'+xx+'" />');
                }
                el.type = 'hidden';
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);
            }
             el = document.createElement('input');
                el.name = 'txtunit[]';
                el.id = 'txtunit_'+xx;
                el.size = 20;
                el.setAttribute('autocomplete', "off");
                //el.setAttribute('readonly', "true");
                el.className = 'txtinput';
                //sel.align = "absmiddle";
                cellRightSel.className = 'tdisi';
                
                cellRightSel.appendChild(el);*/
                //cellRightSel.appendChild(sel);


                // right cell
                cellRight = row.insertCell(9);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);setDisable("del");setDisable("del")}"/>');
                }
                el.src = '../icon/del.gif';
                el.border = "0";
                el.width = "16";
                el.height = "16";
                el.className = 'proses';
                el.align = "absmiddle";
                el.title = "Klik Untuk Menghapus";

                //  cellRight.setAttribute('class', 'tdisi');
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);

                
				document.getElementById('txtObat_'+xx).focus();

                /*  // select cell
  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'satuan';
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
<?php
echo $sel;
?>
//  sel.options[0] = new Option('text zero', 'value0');
//  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
                 */
        //document.getElementById('btnSimpan').disabled = true;
    }

    function AddRow(e,par,el)
	{
        var key;
        //alert(document.form1.txtLain2.length);
        if(window.event) 
		{
            key = window.event.keyCode;
        }
        else if(e.which) 
		{
            key = e.which;
        }
        //alert(key);
        if (key==13){
            addRowToTable();
        }
        else
		{
            var tbl = document.getElementById('tblJual');
            var jmlRow = tbl.rows.length;
            var i;
            if (jmlRow > 4)
			{
                i=par.parentNode.parentNode.rowIndex-2;
            }
			else
			{
                i=0;
            }
            //alert(par.id);
            /*if(document.form1.txtLain2.length){
                //var i=par.parentNode.parentNode.rowIndex;
                //alert(par[i-2].id);
                var tbl = document.getElementById('tblJual');
                var jmlRow = tbl.rows.length;
                var i;
                if (jmlRow > 4){
                    i=par.parentNode.parentNode.rowIndex-2;
                }else{
                    i=0;
                }

                //document.forms[0].obatid[(cdata[0]*1)-1].value=cdata[1];
                //alert(document.getElementById(el[i-2]).id);
                if(document.forms[0].txtJml[i-1].id == el || document.forms[0].txtNilai[i-1].id == el){
                    HitungSubTot(par);
                }
                if(document.forms[0].txtJml[i-1].id == el || document.forms[0].txtTotal[i-1].id == el){
                    //HitungSatuan(par);
                }
            }
            else{*/
                if(par.id=='txtJml' || par.id=='txtNilai')
				{
                    HitungSubTot(par);
                }
                if(par.id=='txtJml' || par.id=='txtTotal')
				{
                    //HitungSatuan(par);
                }
            //}
        }
    }

    function removeRowFromTable(cRow)
	{
        var tbl = document.getElementById('tblJual');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 4)
		{
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=3;i<lastRow;i++)
			{
                var tds = tbl.rows[i].getElementsByTagName('td');
                tds[0].innerHTML=i-2;
            }
            hitung_grand_total();
        }
    }

    function HitungTot()
	{
        if (document.form1.txtSubTotal.length)
		{
            var cStot=0,tmp;
            for (var i=0;i<document.form1.txtSubTotal.length;i++)
			{
                //var lain2 = (document.form1.txtLain2[i].value*1)==0||(document.form1.txtLain2[i].value*1)==''?0:(document.form1.txtLain2[i].value*1);
                //alert(document.form1.txtSubTot[i].value);
                //tmp = ((document.form1.txtJml[i].value*1)*(document.form1.txtNilai[i].value*1)+lain2).toString();
                tmp = ((document.form1.txtJml[i].value*1)*(document.form1.txtNilai[i].value*1)).toString();
                tmp = tmp.split('.');
                if(tmp[1] != undefined)
				{
                    tmp = tmp[0]+'.'+tmp[1].substr(0,2);
                }
                else
				{
                    tmp = tmp[0];
                }
                tmp = parseFloat(tmp);
                document.form1.txtTotal[i].value=tmp;
                cStot +=(document.form1.txtTotal[i].value*1);
            }
            tmp = Math.round(cStot)<cStot?Math.round(cStot)+1:Math.round(cStot);
            document.getElementById('total').innerHTML=tmp;
            //alert(cStot);
        }
        else
		{
            document.form1.txtTotal.value=(document.form1.txtJml.value*1)*(document.form1.txtNilai.value*1);
            document.getElementById('total').innerHTML=document.form1.txtTotal.value;
        }
        if('<?php echo $edit;?>' == true)
		{
            document.getElementById('btnSimpan').disabled = false;
        }
    }

    function HitungSubTot(par)
	{
        //var tbl = document.getElementById('tblJual');
        //alert(i);
        if (document.form1.txtSubTotal.length)
		{
            //var i=par.parentNode.parentNode.rowIndex;
            var tbl = document.getElementById('tblJual');
            var jmlRow = tbl.rows.length;
            var i;
            if (jmlRow > 4)
			{
                i=par.parentNode.parentNode.rowIndex-2;
            }
			else
			{
                i=0;
            }
            //alert((document.form1.txtJml[i-1].value*1)*(document.form1.txtNilai[i-1].value*1));
            document.form1.txtSubTotal[i-1].value=(document.form1.txtNilai[i-1].value*1);//(document.form1.txtJml[i-1].value*1)*(document.form1.txtNilai[i-1].value*1);
        }
		else
		{
            document.form1.txtSubTotal.value=(document.form1.txtNilai.value*1)//(document.form1.txtJml.value*1)*(document.form1.txtNilai.value*1);
        }
        HitungTot();
    }

    function HitungSatuan(par)
	{
        //var tbl = document.getElementById('tblJual');
        var i=par.parentNode.parentNode.rowIndex;
        //alert(document.form1.txtLain2.length);
        if (document.form1.txtLain2.length)
		{
            document.form1.txtLain2[i-3].value=(document.form1.txtJml[i-3].value*1)*(document.form1.txtTotal[i-3].value*1);
        }
		else
		{
            document.form1.txtLain2.value=(document.form1.txtJml.value*1)*(document.form1.txtTotal.value*1);
        }
        HitungTot();
    }

    function save()
	{
        var cdata='';
        var ctemp;
        if (document.getElementById('no_po').value=="")
		{
            alert('Isikan No PO Terlebih Dahulu !');
            document.getElementById('no_po').focus();
            return false;
        }
		else if(document.getElementById('judul').value=="")
		{
            alert('Isikan Judul PO Terlebih Dahulu !');
           	document.getElementById('judul').focus();
            return false;
        }
		else if(document.getElementById('veri').value=="")
		{
            alert('Isikan Verifikator Terlebih Dahulu !');
           	document.getElementById('veri').focus();
            return false;
        }
		else
		{
        //ms_barang_id,vendor_id,no_po,tgl,satuan,qty_satuan,harga_satuan
        //satuan,qty_satuan,harga_satuan
        document.forms[0].fdata.value=cdata;
        //alert(document.forms[0].fdata.value);
        document.forms[0].submit();
		}
        //array buat fdata yang dikirim dengan yang ditangkap belum singkron
    }
    if('<?php echo $edit;?>' == true)
	{
        HitungTot();
    }
	
	function set_NO_PO(act)
	{
		//alert(act);
		if(act=='add')
		{
			var tgl = jQuery('#tgl').val(); 
			var jenis = jQuery('#jenis_surat').val();
			var url =  "get_NO_PO.php?act=add&jenis="+jenis+"&tgl="+tgl;
			jQuery.get(url, function(data)
			{
				
				jQuery('#no_po').val(data);
			});
			
		}
		else if(act=='edit')
		{
			var tgl = jQuery('#tgl').val();
			var jenis = jQuery('#jenis_surat').val(); 
			var no_po = "<?=$_REQUEST['no_po'];?>";
			var x = no_po.split("/");
			var jenis_awal = x[0];
			
			var url = "get_NO_PO.php?act=edit&jenis="+jenis+"&jenis_awal="+jenis_awal+"&no_po="+no_po+"&tgl="+tgl; //alert(url);
			
			jQuery.get(url, function(data)
			{
				//alert(data)
				jQuery('#no_po').val(data);
			});
			
		}
	}
	
	function ganti_nmr()
	{
		set_NO_PO('<?=$_REQUEST['act'];?>');
	}
	
	function hitung_perkalian(urutan)
	{
		var jml = document.getElementById('txtJml_'+urutan).value;
		var nilai = document.getElementById('txtNilai_'+urutan).value;
		
		var total = jml*nilai;
		
		document.getElementById('txtTotal_'+urutan).value = total;
		hitung_grand_total();
		
	}
	function hitung_grand_total()
	{
		var total = 0;
		$(".sub_totalx").each(function(){ 
		var st = $(this).val();//alert($(this).val());
		if(st==""){st=0;}
		total += parseFloat(st);
		});
		document.getElementById('total').innerHTML = total;
	}
    </script>
	
	
</html>
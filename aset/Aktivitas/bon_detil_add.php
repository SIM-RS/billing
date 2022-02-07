<?php
include '../sesi.php';
include '../koneksi/konek.php';
$user=$_SESSION['userid'];
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
$tgl = gmdate('d-m-Y',mktime(date('H')+7));
$th = explode('-', $tgl);
$tgl_sql = gmdate('Y-m-d',mktime(date('H')+7));

$unit_opener="par=idunit*kodeunit*namaunit*idlokasi*kodelokasi";
$barang_opener="par=idbarang*kodebarang*namabarang*satuan*txtStok";
if($_POST['act'] != '') 
{
    $tgl_bon = tglSQL($_POST["tgl"]);
    $fdata = $_POST["fdata"];
    $jenis_surat=$_POST["jenis_surat"];
    $no_bon = $_POST["no_bon"];
    $idunit=$_POST["idunit"];
    $idlokasi = $_POST["idlokasi"];
    $petugas_rtp = $_POST["petugas_rtp"];
    $petugas_unit = $_POST["petugas_unit"];
    $t_userid = $_SESSION["userid"];
    $t_updatetime = date("Y-m-d H:i:s");
    $t_ipaddress =  $_SERVER['REMOTE_ADDR'];

    $act = $_POST['act'];
    //echo $act;

    
    //pemecahan variabel untuk edit -> add/edit*********************************************************
    //pecah belum dicek,karena ada trouble pengiriman data saat dikurangi / ditambah
        // Insert Record
		//=======tambahan biar no bon berbeda jika ada 2 org yg kebetulan sedang input data=======
		 	$aaa="select kode_transaksi from as_keluar where month(tgl_transaksi)='$th[1]' and year(tgl_transaksi)='$th[2]' order by kode_transaksi desc limit 1";
			$bbb=mysql_query($aaa);
			if ($rows1=mysql_fetch_array($bbb)) 
			{
				$notrans=$rows1["kode_transaksi"];
				$ctmp=explode("/",$notrans);
				$dtmp=$ctmp[2]+1;
				$ctmp=$dtmp;
				$ctmp=sprintf("%04d",$ctmp);
				//for ($i=0; $i<(4-strlen($dtmp)); $i++)
				//    $ctmp = "0".$ctmp;
				$no_bon = "BON/$th[2]-$th[1]/$ctmp";
			}
			else 
			{
				$no_bon = "BON/$th[2]-$th[1]/0001";
			}
		//======================
		
        $fdata = explode('**', $fdata);
		$kodebarang = $_REQUEST['kodebarang'];
		$idbarang = $_REQUEST['idbarang'];
		$namabarang = $_REQUEST['namabarang'];
		$idlokasi = $_REQUEST['idlokasi'];
		$kodelokasi = $_REQUEST['kodelokasi'];
		$nmlokasi = $_REQUEST['nmlokasi'];
		$txtUraian = $_REQUEST['txtUraian'];
		$txtStok = $_REQUEST['txtStok'];
		$txtJml = $_REQUEST['txtJml'];
		$satuan = $_REQUEST['satuan'];
		
        $query = "insert into as_keluar(tgl_transaksi,kode_transaksi,unit_id,lokasi_id,petugas_rtp,petugas_unit,barang_id,jml_klr,satuan,klr_uraian) values ";
		
		for($i = 0; $i <= (count($kodebarang)-1); $i++)
		{
			if($i != (count($kodebarang)-1))
			{
				$query .= " ('$tgl_bon','$no_bon','$idunit','".$idlokasi[$i]."','$petugas_rtp','$petugas_unit','".$idbarang[$i]."','".$txtJml[$i]."','".$satuan[$i]."','".$txtUraian[$i]."'),";
			} 
			else 
			{
				$query .= " ('$tgl_bon','$no_bon','$idunit','".$idlokasi[$i]."','$petugas_rtp','$petugas_unit','".$idbarang[$i]."','".$txtJml[$i]."','".$satuan[$i]."','".$txtUraian[$i]."')";
			}
		}
        

        $rs = mysql_query($query);
        $err = mysql_error();
        if (isset ($err) && $err != '')
            echo "<script> alert(\"" . $err ."\" \"".$query. "\"); </script>";
            else echo "<script> alert('Data Berhasil Disimpan');window.location='bon.php'; </script>";
        //echo $query;

    

    //echo "idtransaksi=".$_POST['idtransaksi'].",refno=".$_POST['refno'].",kodeunit=".$_POST['kodeunit'].",kodelokasi=".$_POST['kodelokasi'].",buktino=".$_POST['buktino'].",tgltransaksi=".$_POST['tgltransaksi'].",tglpembukuan=".$_POST['tglpembukuan'].",tok=".$_POST['tok'].",nosk=".$_POST['nosk'].",sumberdana=".$_POST['sumberdana'].",tglsk=".$_POST['tglsk'].",void=".$_POST['void'].",refidrekanan=".$_POST['refidrekanan'].",namarekanan=".$_POST['namarekanan'].",namaunit=".$_POST['namaunit'].",idunit=".$_POST['idunit'].",idlokasi=".$_POST['idlokasi']."";
    //echo "idbarang=".$_POST['idbarang'].",=".",kodebarang=".$_POST['kodebarang'].",qtytransaksi=".$_POST['qtytransaksi'].",satuan=".$_POST['satuan'].",hargasatuan=".$_POST['hargasatuan'].",kurs=".$_POST['kurs'].",nilaikurs=".$_POST['nilaikurs'].",dasarharga=".$_POST['dasarharga'].",kondisi=".$_POST['kondisi']."";
}

$qry="select * from as_ms_satuan order by nourut";
$exe=mysql_query($qry);
$sel="";
$i=0;
while($show=mysql_fetch_array($exe)) {
    $sel .="sel.options[$i] = new Option('".$show['idsatuan']."', '".$show['idsatuan']."');";
    $i++;
}

$qry="select idunit, namaunit from as_ms_unit";
$exe=mysql_query($qry);
$selUnit="";
$i=0;
while($show=mysql_fetch_array($exe)) {
    $selUnit .="sel.options[$i] = new Option('".$show['namaunit']."', '".$show['idunit']."');";
    $i++;
}
if($_GET['no_bon'] != '' && isset($_GET['no_bon'])) {
    $sql = "select tgl_transaksi,petugas_rtp,petugas_unit,date_format(tgl_transaksi,'%d-%m-%Y') as tgl_transaksi,kode_transaksi,unit_id,lokasi_id,u.namaunit,u.kodeunit,l.kodelokasi,l.namalokasi
                from as_keluar k inner join as_ms_barang ab on k.barang_id = ab.idbarang
                left join as_ms_unit u on u.idunit=k.unit_id
                left join as_lokasi l on l.idlokasi=k.lokasi_id
                where kode_transaksi = '".$_GET['no_bon']."' and tgl_transaksi = '".$_GET['tgl_bon']."'
            order by klr_id asc";
    $rs1 = mysql_query($sql);
    $res = mysql_affected_rows();
    if($res > 0) {
        $edit = true;
        $rows1 = mysql_fetch_array($rs1);
        $tgl = $rows1['tgl_transaksi'];
        $petugas_rtp = $rows1['petugas_rtp'];
        $petugas_unit = $rows1['petugas_unit'];
        $no_bon = $rows1['kode_transaksi'];
        $lokasi_id = $rows1['lokasi_id'];
        $unit_id = $rows1['unit_id'];
        $namaunit=$rows1['namaunit'];
        $namalokasi=$rows1['namalokasi'];
        $kodeunit=$rows1['kodeunit'];
        $kodelokasi=$rows1['kodelokasi'];
        mysql_free_result($rs1);
    }
}
if($_GET['act']!='' && isset($_GET['act']) && $_GET['act']=='add'){
    $sql="select kode_transaksi from as_keluar where month(tgl_transaksi)='$th[1]' and year(tgl_transaksi)='$th[2]' order by kode_transaksi desc limit 1";
    $rs1=mysql_query($sql);
    if ($rows1=mysql_fetch_array($rs1)) {
        $notrans=$rows1["kode_transaksi"];
        $ctmp=explode("/",$notrans);
        $dtmp=$ctmp[2]+1;
        $ctmp=$dtmp;
	$ctmp=sprintf("%04d",$ctmp);
        //for ($i=0; $i<(4-strlen($dtmp)); $i++)
        //    $ctmp = "0".$ctmp;
        $no_bon = "BON/$th[2]-$th[1]/$ctmp";
    }
    else {
        $no_bon = "BON/$th[2]-$th[1]/0001";
    }
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
		<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <script type="text/javascript" language="JavaScript" src="../theme/li/popup2.js"></script>
        <title>.: BON DETAIL:.</title>
    </head>
    <body>
        <?php
        include ('../header.php');
		include("popBrg.php");
        $act = $_GET['act'];
        if($act == '') {
            $act = 'add';
        }
        ?>
        <div align="center">
           
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center">
                        <form name="form1" id="form1" method="post" action="" onSubmit="save()">
                            <input name="act" id="act" type="hidden" value="<?php echo $act;?>">
                            <input name="fdata" id="fdata" type="hidden" value="">
                            <table width="99%" border="0">
                                <tr>
                                    <td>
                                      <div id="input" style="display:block" align="center">
                                            <table width="58%" border="0" cellpadding="1" cellspacing="3" class="txtinput" style="border:2px solid #93C4EC;">
                                                <tr>
                                                  <td class="txtinput">&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td width="175" class="txtinput">&nbsp;Tanggal </td>
                                                    <td>:
                                                        <input name="tgl" type="text" class="txtunedited" style="text-align:center" id="tgl" tabindex="4" value="<?php if(isset($tgl) && $tgl != '') echo $tgl;else echo date('d-m-Y'); ?>" size="15" maxlength="15" readonly>
                                                        <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);">                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="txtinput">&nbsp;Nomor</td>
                                                    <td>:
                                                        <input name="no_bon" id="no_bon" class="txt" size="25" value="<?php echo $no_bon;?>" />                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="txtinput">&nbsp;Peruntukan</td>
                                                  <td>:                                                    
                                                        <input name="idunit" type="hidden" id="idunit" value="<?php echo  $unit_id; ?>">
                                                        <input name="namaunit" type="text" readonly id="namaunit" class="txtunedited" value="<?php echo  $namaunit; ?>">
                                                        <input name="kodeunit" type="hidden" class="txtunedited" readonly id="kodeunit" value="<?php echo  $rows["kodeunit"]; ?>" size="10" maxlength="15" >                                                                       
                                                        <img alt="tree" title='daftar unit kerja'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="OpenWnd('unit_treeBon_add.php?<?php echo $unit_opener; ?>',800,500,'msma',true)" />                                                    </td>
                                                </tr>
												<tr>
                                                    <td class="txtinput">&nbsp;Petugas RTP </td>
                                                    <td>:
                                                        <input name="petugas_rtp" id="petugas_rtp" readonly="true" class="txt" size="25" value="<?php echo $user;?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td class="txtinput">&nbsp;Penerima</td>
                                                    <td>
							: 
                                                        <input name="petugas_unit" id="petugas_unit" class="txt" size="25" value="<?php echo $petugas_unit;?>" />                                                    </td>
                                                </tr>
                                                <tr>
                                                  <td class="txtinput">&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                </tr>
                                            </table>
                                            <br>
                                      </div>

                                        <div style="width:950px; height: inherit; overflow:auto; ">
                                            <table id="tblJual" width="130%" border="0" cellpadding="1" cellspacing="1" align="center">
                                                <tr>
                                                    <td colspan="6" align="center" class="jdltable">&nbsp;</td>
													<td></td>
													<td></td>
													<td></td>
                                                </tr>
												<tr>
													<td colspan="2"></td>
                                                    <td colspan="3" align="center" class="jdltable">
                                                        BON BARANG </td>
                                                    <td align="right" valign="bottom">
													<input type="hidden" class="txt" readonly id="urutan_pop" name="urutan_pop" size="5" value="0">
                                                    <input name="button" type="button" style=" cursor:pointer; color:#FFFFFF; font-weight:bold; background: #009900; padding:3px; border:1px solid #003366;" onClick="addRowToTable();" value="(+) List" />
                                                    </td>
													<td></td>
													<td></td>
													<td></td>
                                                </tr>
                                                <tr class="headtable">
                                                    <td width="27" height="25" class="tblheaderkiri">No</td>
                                                    <td width="101" height="25" class="tblheader">Kode Barang</td>
                                                    <td width="220" height="25" class="tblheader">Nama Barang</td>   
													<td width="220" height="25" class="tblheader">Nama Lokasi</td>
                                                    <td width="" height="25" class="tblheader">Uraian</td>
													<td width="20" height="25" class="tblheader">Jml Stok </td>                                                    
                                                    <td width="" height="25" class="tblheader">Jml Bon </td>
                                                    <td width="" height="25" class="tblheader">Satuan</td>
                                                    <td width="40" height="25" class="tblheader">Proses</td>
                                                </tr>
                                                
                                                <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
                                                    <td class="tdisikiri" width="27">1
                                                    </td>
                                                    <td class="tdisi" id="kode" align="center"><input type="text" name="kodebarang[]" id="kodebarang_0" value="-" size="15" class="txtcenter"></td>
                                                    <td class="tdisi" align="center" width="220">
                                                        <input type="hidden" name="idbarang[]" id="idbarang_0" value="">
                                                        <input type="text" name="namabarang[]" id="namabarang_0" class="txtinput" onClick="lempar('<?php echo $barang_opener; ?>',this,0)" size="20" autocomplete="off" /><img alt="tree" width="17" title='Struktur tree kode barang'  style="cursor:pointer" border=0 src="../images/backsmall.gif" align="absbottom" onClick="lempar('<?php echo $barang_opener; ?>',this,0)">
                                                  </td>
												  <td class="tdisi" align="center" width="220">
                                                        <input type="hidden" name="idlokasi[]" id="idlokasi_0">
														<input type="hidden" name="kodelokasi[]" id="kodelokasi_0">
                                                        <input type="text" name="nmlokasi[]" id="nmlokasi_0" class="txtinput" onClick="OpenWnd('lokasi_treeBON.php?par=idlokasi*kodelokasi*nmlokasi',800,500,'msma',true,this)" size="20" autocomplete="off" />
                                                        <img alt="tree" width="17" title='Struktur tree lokasi'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="OpenWnd('lokasi_treeBon_add.php?par=idlokasi*kodelokasi*nmlokasi&no=0',800,500,'msma',true,this)">
                                                    </td>
                                                    <td class="tdisi"><input type="text" name="txtUraian[]" id="txtUraian_0" class="txtinput" autocomplete="off" /></td>
                                                     <td class="tdisi" width=""><input type="text" name="txtStok[]" id="txtStok_0" class="txtcenter" size="15" autocomplete="off" />
                                                    </td>
                                                    <td class="tdisi" width=""><input type="text" name="txtJml[]" id="txtJml_0" class="txtcenter" size="20" autocomplete="off" /></td>
                                                    <td class="tdisi" width=""><input type="text" id="satuan_0" name="satuan[]" class="txtinput" readonly/></td>
                                                    <td class="tdisi"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}">
                                                    </td>
                                                </tr>
                                                   
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <table width="90%" align="center">
                                <!--tr>
                                    <td width="88%" class="txtright">Total :</td>
                                    <td id="total" width="11%" align="right" class="txtright">0</td>
                                    <td width="1%">&nbsp;</td>
                                </tr-->
                                <tr>
                                    <td height="30" colspan="4" valign="bottom" align="center">
                                        <button type="button" class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="save()" title="Save" style="cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Save Record
                                        </button>
                                        <button type="reset" class="Enabledbutton" id="backbutton" onClick="location='bon.php'" title="Back" style="cursor:pointer">
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
        var arrRange=depRange=[];
        var RowIdx3;
        var fKeyEnt3;

        function setDisable(ev,par)
		{
            if(ev == 'del')
			{
                document.getElementById('btnSimpan').disabled = true;
                return;
            }
            else if(isNaN(par.value))
			{
                alert('Input harus berupa angka.');
                document.getElementById('btnSimpan').disabled = true;
            }
            var listNum = '8,46,96,97,98,99,100,101,102,103,104,105,110';
            listNum = listNum.split(',');
            for(var i=0; i<listNum.length; i++){cmbIventaris
                if(ev.which == listNum[i]){
                    document.getElementById('btnSimpan').disabled = true;
                    break;
                }
            }
        }
		
		//function riz(){
			//window.location='bon_detil.php?act=add&cmbIventaris='+document.getElementById('cmbfilter').value;
		//}
		function lempar(a,par,urutan)
		{
			document.getElementById('urutan_pop').value=urutan;
			/*var tbl = document.getElementById('tblJual');
            var jmlRow = tbl.rows.length;
            var i;
            if (jmlRow > 4)
			{
                i=par.parentNode.parentNode.rowIndex-3;
            }
			else
			{
                i=0;
            }
			if('<?=$idbrng;?>'=='')
			{
				var cekbrg='';
				for (var ipk=0;ipk<document.forms[0].idbarang.length;ipk++)
				{
					if(ipk==0)
					{
						cekbrg=document.forms[0].idbarang[ipk].value;
					}
					else
					{
						cekbrg+='**'+document.forms[0].idbarang[ipk].value;
					}
				}
				Popup.showModal('popList',null,null,{'screenColor':'silver','screenOpacity':.6});
				return false;
			}
			else
			{*/
				Popup.showModal('popList',null,null,{'screenColor':'silver','screenOpacity':.6});
			/*	return false;
			}*/
		
		}
		
		function lemparLokasi(a,par)
		{
			var tbl = document.getElementById('tblJual');
            var jmlRow = tbl.rows.length;
            var i;
            if (jmlRow > 4)
			{
                i=par.parentNode.parentNode.rowIndex-3;
            }
			else
			{
                i=0;
            }
			Popup.showModal('popList',null,null,{'screenColor':'silver','screenOpacity':.6});
			return false;
		}
		
        function list1(e,par){
			//alert(document.getElementById('nmBarang').value.length);
            var keywords=par.value;
            var tbl = document.getElementById('tblJual');
            var jmlRow = tbl.rows.length;
            var i;
            if (jmlRow >= 4){
                i=par.parentNode.parentNode.rowIndex-1;
            }else{
                i=0;
            }
           var nomer=jmlRow-4;
			//var cmb1=document.getElementById('cmbfilter').value;
		/* 	if(cmb1!='') */
			
			//alert(jmlRow+'-'+i);
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
					var row_data = tblRow-1;
					
                    if (tblRow>0)
					{
                        //alert(RowIdx3);
                        if (key==38)
						{
							if(RowIdx3==0)
							{
							
							}
							else if(RowIdx3==1)
							{
								document.getElementById('list_'+RowIdx3).className='itemtableReq';
								RowIdx3=0;
							}
							else
							{
								document.getElementById('list_'+RowIdx3).className='itemtableReq';
								RowIdx3=RowIdx3-1;
								document.getElementById('list_'+RowIdx3).className='itemtableMOverReq';
							}
                        }
						else if (key==40)
						{
							
                           if(RowIdx3==0)
							{
								RowIdx3=RowIdx3+1;
								document.getElementById('list_'+RowIdx3).className='itemtableMOverReq';
							}
							else if(RowIdx3==row_data)
							{
								
							}
							else
							{
								document.getElementById('list_'+RowIdx3).className='itemtableReq';
								RowIdx3=RowIdx3+1;
								document.getElementById('list_'+RowIdx3).className='itemtableMOverReq';
							}
                        }
                    }
                }
                else if (key==13){
                    if (RowIdx3>0){
                        if (fKeyEnt3==false){
                            ValNamaBag(document.getElementById('list_'+RowIdx3).lang);
                        }else{
                            fKeyEnt3=false;
                        }
                    }
                }
                else if (key!=27 && key!=37 && key!=39){
                    RowIdx3=0;
                    fKeyEnt3=false;
					if (document.getElementById('nmBarang').value.length>=3){
                    Request('list_barangBon.php?aKeyword='+keywords+'&no='+nomer+'&cmb='+document.getElementById('CmbStt').value, 'divbarang', '', 'GET' );
                    if (document.getElementById('divbarang').style.display=='none') fSetPosisi(document.getElementById('divbarang'),par);
                    document.getElementById('divbarang').style.display='block';
					}
                }
            }
        }
		
		function fsetLokasi(par)
		{
			var cdata=par.split("*|*");
			var xx = cdata[0];
			document.getElementById('idlokasi_'+xx).value = cdata[1];
			document.getElementById('kodelokasi_'+xx).value = cdata[2];
			document.getElementById('nmlokasi_'+xx).value = cdata[3];
		}
		
        function ValNamaBag(par)
		{
			var xx = document.getElementById('urutan_pop').value;//alert(xx)
			var cdata=par.split("|");
			
			document.getElementById('idbarang_'+xx).value=cdata[1];
			document.getElementById('kodebarang_'+xx).value=cdata[2];
			document.getElementById('namabarang_'+xx).value=cdata[3];
			document.getElementById('satuan_'+xx).value=cdata[4];
			document.getElementById('txtStok_'+xx).value=cdata[5];
			
			document.getElementById('nmBarang').value='';
			document.getElementById('divbarang').style.display='none';
			Popup.hide('popList');
		//alert(par);
			
		}
		
		var xx = 0;
        function addRowToTable()
        {
			xx++
			//use browser sniffing to determine if IE or Opera (ugly, but required)
            var isIE = false;
            if(navigator.userAgent.indexOf('MSIE')>0){
                isIE = true;
            }
            //	alert(navigator.userAgent);
            //	alert(isIE);
            var tbl = document.getElementById('tblJual');
            var lastRow = tbl.rows.length;
			//alert(lastRow);
            // if there's no header row in the table, then iteration = lastRow + 1
            var iteration = lastRow-3;
            //alert(iteration-3);
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
            //alert(iteration-2)
            //var textNode = document.createTextNode(iteration-2);
			var textNode = document.createTextNode(iteration+1);
            cellLeft.className = 'tdisikiri';
            cellLeft.appendChild(textNode);

            // right cell
            //cellLeft = row.insertCell(1);
            /* textNode = document.createTextNode('-');
            cellLeft.className = 'tdisi';
            cellLeft.appendChild(textNode); */
			
			var cellRight = row.insertCell(1);
            var el;
            //generate obatid
            
            //generate txtobat
            if(!isIE){
                el = document.createElement('input');
                el.name = 'kodebarang[]';
                el.id = 'kodebarang_'+xx;
            }else{
                el = document.createElement('<input name="kodebarang[]" id="kodebarang_'+xx+'" />');
            }
            el.type = 'text';
            //el.id = 'txtObat'+(iteration-1);
            el.size = 15;
            el.className = 'txtcenter';
			//el.align = "center";

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

            

            // right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'idbarang[]';
                el.id = 'idbarang_'+xx;
            }else{
                el = document.createElement('<input name="idbarang[]" id="idbarang_'+xx+'"/>');
            }
            el.type = 'hidden';
            el.value = '';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

            if("<?php echo $edit;?>" == true)
			{
                //generate id
                
                if(!isIE){
                    el = document.createElement('input');
                    el.name = 'id[]';
                    el.id = 'id_'+xx;
                }else{
                    el = document.createElement('<input name="id[]" id="id_'+xx+'" />');
                }
                el.type = 'text';
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);
            }

			 
			
			
            //generate txtobat
            if(!isIE){
                el = document.createElement('input');
                tree = new Image();
                tree.src="../images/backsmall.gif";
                //tree.setAttribute('onclick', "treebrg(this);");
                tree.style.cursor = "pointer";
                el.name = 'namabarang[]';
                el.id = 'namabarang_'+xx;
                tree.setAttribute('onClick', "lempar('<?php echo $barang_opener; ?>',this,"+xx+")");
                el.setAttribute('autocomplete', "off");
            }else{
                el = document.createElement('<input name="namabarang[]" id="namabarang_'+xx+'" onClick="lempar("+<?php echo $barang_opener; ?>+",this,'+xx+')" autocomplete="off" />');
            }
            el.type = 'text';
            //el.id = 'txtObat'+(iteration-1);
            el.size = 20;
            tree.width = 17;
            tree.align = "absmiddle";
            el.className = 'txtinput';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			cellRight.appendChild(tree);

            //generate max_item
			
			//menambahkan semuanya lokasi
			
            var cellRight = row.insertCell(3);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'idlokasi[]';
                el.id = 'idlokasi_'+xx;
            }else{
                el = document.createElement('<input name="idlokasi[]" id="idlokasi_'+xx+'"/>');
            }
            el.type = 'hidden';
            el.value = '';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'kodelokasi[]';
                el.id = 'kodelokasi_'+xx;
            }else{
                el = document.createElement('<input name="kodelokasi[]" id="kodelokasi_'+xx+'"/>');
            }
            el.type = 'hidden';
            el.value = '';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
            if(!isIE){
                el = document.createElement('input');
                tree = new Image();
                tree.src="../images/view_tree.gif";
                //tree.setAttribute('onclick', "treebrg(this);");
                tree.style.cursor = "pointer";
                el.name = 'nmlokasi[]';
                el.id = 'nmlokasi_'+xx;
                tree.setAttribute('onClick', "OpenWnd('lokasi_treeBON.php?par=idlokasi*kodelokasi*nmlokasi&i="+iteration+"',800,500,'msma',true,this)");
                el.setAttribute('autocomplete', "off");
            }else{
                el = document.createElement('<input name="namabarang" onClick="lemparLokasi("+<?php echo $barang_opener; ?>+",this)" autocomplete="off" />');
				el = document.createElement('<input name="namabarang[]" id="namabarang_'+xx+'" onClick="OpenWnd("lokasi_treeBON.php?par=idlokasi*kodelokasi*nmlokasi",this)" autocomplete="off" />');
            }
            el.type = 'text';
            //el.id = 'txtObat'+(iteration-1);
            el.size = 20;
            tree.width = 17;
            tree.align = "absmiddle";
            el.className = 'txtinput';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			cellRight.appendChild(tree);

            // right cell
            cellRight = row.insertCell(4);
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txtUraian[]';
                el.id = 'txtUraian_'+xx;
                //el.setAttribute('onKeyUp', "AddRow(event,this,'txtJml');setDisable(event,this);");
                //el.setAttribute('autocomplete', "off");
            }else{
                el = document.createElement('<input name="txtUraian[]" id="txtUraian_'+xx+'" />');
                //onKeyUp="AddRow(event,this);setDisable(event,this);" autocomplete="off" 
            }
            el.type = 'text';
            //el.size = 15;
            el.className = 'txtinput';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
            
            // right cell
            cellRight = row.insertCell(5);
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txtStok[]';
                el.id = 'txtStok_'+xx;
                //el.setAttribute('onKeyUp', "AddRow(event,this,'txtJml');setDisable(event,this);");
                //el.setAttribute('autocomplete', "off");
            }else{
                el = document.createElement('<input name="txtStok[]" id="txtStok_'+xx+'" />');
                //onKeyUp="AddRow(event,this);setDisable(event,this);" autocomplete="off" 
            }
            el.type = 'text';
            el.size = 15;
            el.className = 'txtcenter';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
            
            //dsfdsfdsf
            cellRight = row.insertCell(6);
            var el;
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txtJml[]';
                el.id = 'txtJml_'+xx;
                //el.setAttribute('onKeyUp', "AddRow(event,this,'txtJml');setDisable(event,this);");
                //el.setAttribute('autocomplete', "off");
            }else{
                el = document.createElement('<input name="txtJml[]" id="txtJml_'+xx+'" />');
                //onKeyUp="AddRow(event,this);setDisable(event,this);" autocomplete="off" 
            }
            el.type = 'text';
            el.size = 20;
            el.className = 'txtcenter';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

           var cellRight = row.insertCell(7);
            var el;
            //generate obatid
            
            //generate txtobat
            if(!isIE){
                el = document.createElement('input');
                el.name = 'satuan[]';
                el.id = 'satuan_'+xx;
            }else{
                el = document.createElement('<input name="satuan[]" id="satuan_'+xx+'" />');
            }
            el.type = 'text';
            //el.id = 'txtObat'+(iteration-1);
            el.size = 20;
            el.className = 'txtinput';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);


        cellRight = row.insertCell(8);
        if(!isIE){
            el = document.createElement('img');
            el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}');
            //setDisable("del")
        }else{
            el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
            //setDisable("del");
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

        //document.forms[0].namabarang[iteration-3].focus();
		//document.forms[0].namabarang[iteration-3].focus();

        /*  // select cell
                          var cellRightSel = row.insertCell(2);
                          var sel = document.createElement('select');
                          sel.name = 'satuan';
                          sel.className = "txtinput";
                          //sel.id = 'selRow'+iteration;
< ?php
echo $sel;
?>
                        //  sel.options[0] = new Option('text zero', 'value0');
                        //  sel.options[1] = new Option('text one', 'value1');
                          cellRightSel.appendChild(sel);
         */
    }

    /*function AddRow(e,par,el){
        var key;
        //alert(document.form1.txtLain2.length);
        if(window.event) {
            key = window.event.keyCode;
        }
        else if(e.which) {
            key = e.which;
        }
        //alert(key);
        if (key==13){
            addRowToTable();
        }
        else{
            var tbl = document.getElementById('tblJual');
            var jmlRow = tbl.rows.length;
            var i;
            if (jmlRow > 4){
                i=par.parentNode.parentNode.rowIndex-2;
            }else{
                i=0;
            }
            //alert(par.id);
            if(document.form1.txtLain2.length){
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
            else{
                if(par.id=='txtJml' || par.id=='txtNilai'){
                    HitungSubTot(par);
                }
                if(par.id=='txtJml' || par.id=='txtTotal'){
                    //HitungSatuan(par);
                }
            }
        }
    }*/

    function removeRowFromTable(cRow){
		
        var tbl = document.getElementById('tblJual');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 4){
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=3;i<lastRow;i++){
                var tds = tbl.rows[i].getElementsByTagName('td');
                tds[0].innerHTML=i-2;
            }
            //HitungTot();
        }
    }

    /*function HitungTot(){
        if (document.form1.txtSubTotal.length){
            var cStot=0;
            for (var i=0;i<document.form1.txtSubTotal.length;i++){
                //alert(document.form1.txtSubTot[i].value);
                document.form1.txtTotal[i].value=(document.form1.txtJml[i].value*1)*(document.form1.txtNilai[i].value*1);
                cStot +=(document.form1.txtSubTotal[i].value*1);
            }
            document.getElementById('total').innerHTML=cStot;
            //alert(cStot);
        }
        else{
            document.form1.txtTotal.value=(document.form1.txtJml.value*1)*(document.form1.txtNilai.value*1);
            document.getElementById('total').innerHTML=document.form1.txtSubTotal.value;
        }
    }

    function HitungSubTot(par){
        //var tbl = document.getElementById('tblJual');
        //alert(i);
        if (document.form1.txtSubTotal.length){
            //var i=par.parentNode.parentNode.rowIndex;
            var tbl = document.getElementById('tblJual');
            var jmlRow = tbl.rows.length;
            var i;
            if (jmlRow > 4){
                i=par.parentNode.parentNode.rowIndex-2;
            }else{
                i=0;
            }
            //alert((document.form1.txtJml[i-1].value*1)*(document.form1.txtNilai[i-1].value*1));
            document.form1.txtSubTotal[i-1].value=(document.form1.txtNilai[i-1].value*1);//(document.form1.txtJml[i-1].value*1)*(document.form1.txtNilai[i-1].value*1);
        }else{
            document.form1.txtSubTotal.value=(document.form1.txtNilai.value*1)//(document.form1.txtJml.value*1)*(document.form1.txtNilai.value*1);
        }
        HitungTot();
    }

    function HitungSatuan(par){
        //var tbl = document.getElementById('tblJual');
        var i=par.parentNode.parentNode.rowIndex;
        //alert(document.form1.txtLain2.length);
        if (document.form1.txtLain2.length){
            document.form1.txtLain2[i-3].value=(document.form1.txtJml[i-3].value*1)*(document.form1.txtTotal[i-3].value*1);
        }else{
            document.form1.txtLain2.value=(document.form1.txtJml.value*1)*(document.form1.txtTotal.value*1);
        }
        HitungTot();
    }*/

    function save(){
        /*var cdata='';
        var ctemp;
        if (document.forms[0].idunit.value==""){
        	 alert('Pilih Unit Terlebih Dahulu !');
            document.forms[0].idunit.focus();
            return false;
        	}
        if (document.forms[0].no_bon.value==""){
            alert('Isikan No Bon Terlebih Dahulu !');
            document.forms[0].no_bon.focus();
            return false;
        }
        if (document.forms[0].idbarang.length){
            for (var i=0;i<document.forms[0].idbarang.length;i++){
                ctemp=document.forms[0].idbarang[i].value;//.split('|');
                if (document.forms[0].idbarang[i].value==""){
                    alert('Pilih Barang Terlebih Dahulu !');
                    document.forms[0].namabarang[i].focus();
                    return false;
                }
                cdata += ctemp+'|'+document.forms[0].txtJml[i].value+'|'+document.forms[0].satuan[i].value+'|'+document.forms[0].txtUraian[i].value+'|'+document.forms[0].idlokasi[i].value;
                //7615|BUAH|11|220000|0|20000|20000|220000|72**2937|BUAH|12|360000|0|30000|30000|360000|16
                if("<?php echo $edit;?>" == true){
                    cdata += '|'+document.forms[0].id[i].value;
                }
                cdata += '**';

            }
           // alert(cdata);
            if (cdata != '')
                cdata=cdata.substr(0,cdata.length-2);
        }
        else{
            if (document.forms[0].idbarang.value==""){
                alert('Pilih Barang Terlebih Dahulu !');
                document.forms[0].namabarang.focus();
                return false;
            }
            ctemp=document.forms[0].idbarang.value;//.split('|');
            cdata=ctemp+'|'+document.forms[0].txtJml.value+'|'+document.forms[0].satuan.value+'|'+document.forms[0].txtUraian.value+'|'+document.forms[0].idlokasi.value;
            //alert(cdata);
            if("<?php echo $edit;?>" == true){
                cdata += '|'+document.forms[0].id.value;
            }
        }
        //ms_barang_id,vendor_id,no_bon,tgl,satuan,qty_satuan,hrg_satuan
        //satuan,qty_satuan,hrg_satuan
        document.forms[0].fdata.value=cdata;
        //alert(cdata);
        //alert(document.forms[0].fdata.value);
			//alert('a');        */
        document.forms[0].submit();
        //array buat fdata yang dikirim dengan yang ditangkap belum singkron
		//window.location='bon.php';
    }
	function set_unit(par)
	{
		//alert(par);
		var data = par.split('|');
		$("#idunit").val(data[0]);
		$("#namaunit").val(data[1]);
	}
    </script>
</html>
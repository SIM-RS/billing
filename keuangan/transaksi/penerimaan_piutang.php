<?php
include("../sesi.php");
include '../secured_sess.php';
$userId=$_SESSION['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>.: Penerimaan Piutang :.</title>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <link type="text/css" href="../menu.css" rel="stylesheet" />
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../menu.js"></script>
        <!--link type="text/css" rel="stylesheet" href="../theme/mod.css"-->
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
        <style type="text/css">
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
            <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAEFF3">
                <tr>
                    <td height="50">&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top" align="center">
                        <table width="750" border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold">
                            <tr height="30">
                                <td width="50%" style="padding-left:150px;" height="30">Penerimaan Klaim KSO</td>
                                <td width="50%">:&nbsp;<input type="hidden" id="txtId" name="txtId" />
                                	<select id="cmbKso" name="cmbKso" class="txtinput">
                                    	<?php
                                        $qPend = "SELECT id,nama FROM $dbbilling.b_ms_kso WHERE aktif=1 AND id<>1 ORDER BY nama";
                                        $rsPend = mysql_query($qPend);
                                        while($rwPend = mysql_fetch_array($rsPend)) {
                                        ?>
                                    	<option value="<?php echo $rwPend['id']?>"><?php echo $rwPend['nama']?></option>
                                        <?php 
										}
										?>
                                    </select>                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:150px;">Tanggal Penerimaan</td>
                                <td>:&nbsp;
                                    <input id="txtTgl" name="txtTgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange);"/>                                </td>
                            </tr>
                            <tr>
                              <td style="padding-left:150px;">Tanggal Klaim</td>
                              <td>:&nbsp;
                                <input id="txtTglKlaim" name="txtTglKlaim" readonly="readonly" size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;<input type="button" name="btnTgl3" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(document.getElementById('txtTglKlaim'),depRange);"/></td>
                            </tr>
                            <tr>
                              <td style="padding-left:150px;">No Bukti Klaim</td>
                              <td>:&nbsp;
                                  <input id="txtNoKlaim" name="txtNoKlaim" size="30" class="txtinputreg" type="text" />                              </td>
                            </tr>
                            <tr>
                                <td style="padding-left:150px;">No Bukti Terima</td>
                                <td>:&nbsp;
                                    <input id="txtNoBu" name="txtNoBu" size="30" class="txtinputreg" type="text" />                                </td>
                            </tr>                            
                            <!--tr height="30" id="trKSO">
                                <td style="padding-left:150px;">Nama KSO</td>
                                <td>:&nbsp;
                                    <select id="cmbKso" name="cmbKso" onchange="filter()" class="txtinputreg"></select>
                                </td>
                            </tr-->
                            <tr id="trForm">
                                <td style="padding-left:150px;">Nilai</td>
                                <td>:&nbsp;
                                    <input type="text" id="nilai" size="15" name="nilai" class="txtright"/></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding-left:150px;">
                                    Keterangan                                </td>
                                <td valign="top"><span style="vertical-align:top">:</span>&nbsp;
                                    <textarea cols="36" id="txtArea" name="txtArea" class="txtinputreg"></textarea>                                </td>
                            </tr>
                        </table>
                  </td>
                </tr>               
		<tr id="trPenControl">
                    <td align="center" height="50" valign="middle">
                        <button id="btnPenSimpan" name="btnPenSimpan" class="tblTambah" value="tambah" onclick="simpanPen()">Simpan</button>
                        <button id="btnPenHapus" name="btnPenHapus" class="tblHapus" disabled="true" value="hapus" onclick="hapusPen()">Hapus</button>
			<button id="btnPenBatal" name="btnPenBatal" class="tblBatal" onclick="batalPen()">Batal</button>
                    </td>
                </tr>
          <tr id="trCetak">
                    <td align="right" valign="middle" style="padding-right:50px;" >
                        <button id="btnPenSimpan" name="btnPenSimpan" value="tambah" onclick="cetakLap(0)"><img src="../icon/printer.png" height="20" align="absmiddle" />&nbsp;Cetak</button>
                        <button id="btnPenSimpan" name="btnPenSimpan" value="tambah" onclick="cetakLap(1)"><img src="../icon/printer.png" height="20" align="absmiddle" />&nbsp;Export ke Excel</button>
                    </td>
                </tr>      
		<tr id="trPen">		                        
                    <td align="center" >
			<fieldset style="width:900px">
			    <legend>
				<select id="blnPend" name="blnPend" onchange="goFilterAndSort('gridbox')" class="txtinputreg">
                                        <option value="1" <?php echo $th[1]==1?'selected="selected"':'';?>>Januari</option>
                                        <option value="2" <?php echo $th[1]==2?'selected="selected"':'';?>>Februari</option>
                                        <option value="3" <?php echo $th[1]==3?'selected="selected"':'';?>>Maret</option>
                                        <option value="4" <?php echo $th[1]==4?'selected="selected"':'';?>>April</option>
                                        <option value="5" <?php echo $th[1]==5?'selected="selected"':'';?>>Mei</option>
                                        <option value="6" <?php echo $th[1]==6?'selected="selected"':'';?>>Juni</option>
                                        <option value="7" <?php echo $th[1]==7?'selected="selected"':'';?>>Juli</option>
                                        <option value="8" <?php echo $th[1]==8?'selected="selected"':'';?>>Agustus</option>
                                        <option value="9" <?php echo $th[1]==9?'selected="selected"':'';?>>September</option>
                                        <option value="10" <?php echo $th[1]==10?'selected="selected"':'';?>>Oktober</option>
                                        <option value="11" <?php echo $th[1]==11?'selected="selected"':'';?>>Nopember</option>
                                        <option value="12" <?php echo $th[1]==12?'selected="selected"':'';?>>Desember</option>
                                    </select>
                                    <select id="thnPend" name="thnPend" onchange="goFilterAndSort('gridbox')" class="txtinputreg">
                                        <?php
                                        for ($i=($th[2]-5);$i<($th[2]+1);$i++) {
                                            ?>
                                        <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$th[2]) echo "selected";?>><?php echo $i;?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
			    </legend>
                        <div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div>
			</fieldset>
		    </td>                    
		</tr>
               
                <tr>
                    <td>
                        <?php include("../footer.php");?>
                    </td>
                </tr>
            </table>
        </div>
	   
          <?php include("../laporan/report_form.php");?>
    </body>
    <script type="text/JavaScript" language="JavaScript">
		function cetakLap(zxc){
			if(zxc==0){
				window.open('lap_penerimaan_piutang.php?bln='+document.getElementById('blnPend').value+'&thn='+document.getElementById('thnPend').value);
			}
			if(zxc==1){
				window.open('lap_penerimaan_piutang.php?expor=excel&bln='+document.getElementById('blnPend').value+'&thn='+document.getElementById('thnPend').value);
			}
		}
	
        function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
            //alert('combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId);
        }
        //isiCombo('cmbKso');

        function cekDiv(){//alert(document.getElementById('divKso').innerHTML=='kosong'?'kosong':'aneh');
            if((document.getElementById('divKso').innerHTML*1) == 1){
                //document.getElementById('trDiv').style.display = 'none';
		//document.getElementById('trPen').style.display = 'table-row';
            }
            else{
                var tmp = document.getElementById('divKso').innerHTML.split(String.fromCharCode(3));
                document.getElementById('divKso').innerHTML = tmp[0];
                if(tmp[1] < 150){
                    document.getElementById('divKso').style.height = tmp[1]*1+36+'px';
                    document.getElementById('divKso').style.overflow = 'auto';
                }
                else{
                    document.getElementById('divKso').style.height = '170px';
                    document.getElementById('divKso').style.overflow = 'scroll';
                }
                //document.getElementById('trDiv').style.display = 'table-row';
		//document.getElementById('trPen').style.display = 'none';
            }
        }       
	
	function ambilData(){
	    var sisipan = a.getRowId(a.getSelRow()).split("|");
	     var isian = "txtId*-*"+sisipan[0]
	     +"*|*txtTgl*-*"+a.cellsGetValue(a.getSelRow(),2)
	     +"*|*txtTglKlaim*-*"+a.cellsGetValue(a.getSelRow(),3)
	     +"*|*txtNoKlaim*-*"+a.cellsGetValue(a.getSelRow(),4)
	     +"*|*txtNoBu*-*"+a.cellsGetValue(a.getSelRow(),5)
	     +"*|*cmbKso*-*"+sisipan[1]
	     +"*|*nilai*-*"+a.cellsGetValue(a.getSelRow(),7)
	     +"*|*txtArea*-*"+a.cellsGetValue(a.getSelRow(),8);	     
	    fSetValue(window,isian);
	    document.getElementById("txtArea").value=a.cellsGetValue(a.getSelRow(),8);
	    document.getElementById("btnPenHapus").disabled=false;
	    document.getElementById("btnPenSimpan").value="simpan";
	}
	
	function simpanPen(){
	    var cmbPend = 1;
	    var userId = "<?php echo $userId;?>";
		var id = document.getElementById("txtId").value;
		var act = document.getElementById("btnPenSimpan").value;		
		var txtTgl = document.getElementById("txtTgl").value;
		var txtTglKlaim = document.getElementById("txtTglKlaim").value;
		var txtNoKlaim = document.getElementById("txtNoKlaim").value;		    
		var txtNoBu = document.getElementById("txtNoBu").value;		    
		var txtArea = document.getElementById("txtArea").value;
		var bln = document.getElementById('blnPend').value;
		var thn = document.getElementById('thnPend').value;
		var ksoId = document.getElementById("cmbKso").value;
		var txtBayar = document.getElementById("nilai").value;
		while (txtBayar.indexOf(".")>0){
			txtBayar=txtBayar.replace(".","");
		}
		while (txtBayar.indexOf(" ")>0){
			txtBayar=txtBayar.replace(" ","");
		}
		
		var param ="&rowid="+encodeURIComponent(id)
			+"&cmbPend="+encodeURIComponent(cmbPend)
			+"&ksoId="+encodeURIComponent(ksoId)
			+"&txtTgl="+encodeURIComponent(txtTgl)
			+"&txtTglKlaim="+encodeURIComponent(txtTglKlaim)
			+"&txtNoKlaim="+encodeURIComponent(txtNoKlaim)
			+"&txtNoBu="+encodeURIComponent(txtNoBu)
			+"&txtBayar="+encodeURIComponent(txtBayar)
			+"&txtArea="+encodeURIComponent(txtArea)
			+"&thn="+encodeURIComponent(thn)
			+"&bln="+encodeURIComponent(bln)
			+"&userId="+encodeURIComponent(userId);
			
		if (act=="simpan"){
			if(confirm("Anda Yakin Ingin Mengubah Data ?")){
	    		document.getElementById("btnPenSimpan").disabled=true;
				//alert("penerimaan_piutang_utils.php?grid=1&act="+act+param+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
				a.loadURL("penerimaan_piutang_utils.php?grid=1&act="+act+param+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
			}
		}else{
	    	document.getElementById("btnPenSimpan").disabled=true;
			//alert("penerimaan_piutang_utils.php?grid=1&act="+act+param+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
			a.loadURL("penerimaan_piutang_utils.php?grid=1&act="+act+param+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		}
	}
	
	function hapusPen(){
	    document.getElementById("btnPenHapus").disabled=true;
        var rowid = document.getElementById("txtId").value;
	    var act = document.getElementById("btnPenHapus").value;
	    var bln = document.getElementById('blnPend').value;
        var thn = document.getElementById('thnPend').value;
		if(confirm("Anda yakin menghapus data Tanggal "+a.cellsGetValue(a.getSelRow(),2))){
			a.loadURL("penerimaan_piutang_utils.php?grid=1&bln="+bln+"&thn="+thn+"&act="+act+"&rowid="+rowid,"","GET");
		}
        //batalPen();
    }
	
	function batalPen(){
	    var isian = "txtId*-**|*txtTgl*-*<?php echo $tgl;?>*|*txtNoKlaim*-**|*txtNoBu*-**|*nilai*-*";
	    fSetValue(window,isian);	    
	    document.getElementById("txtArea").value="";	    
	    document.getElementById("btnPenSimpan").value="tambah";
	    document.getElementById("btnPenHapus").disabled=true;
		document.getElementById("btnPenSimpan").disabled=false;
	}
	
	function konfirmasi(key,val){
        //alert(key+' - '+val);
		batalPen();
		if(val != undefined){
            var tangkap=val.split("*|*");
            var proses=tangkap[0];
            var alasan=tangkap[1];
			//alert(proses+" - "+alasan);
            if(key=='Error'){
                if(proses=='hapus'){				
                    alert('Tidak bisa menambah data karena '+alasan+'!');
                }              
            }
            else{
                if(proses=='tambah'){
                    alert('Tambah Berhasil');
                }
                else if(proses=='simpan'){
                    alert('Simpan Berhasil');
                }
                else if(proses=='hapus'){
                    alert('Hapus Berhasil');		    
                }
            }
		}
    }
	
	function goFilterAndSort(grd){
	     var bln = document.getElementById('blnPend').value;
         var thn = document.getElementById('thnPend').value;
            //alert("pendapatan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("penerimaan_piutang_utils.php?grid=1&bln="+bln+"&thn="+thn+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
    }
	
		var bln = document.getElementById('blnPend').value;
        var thn = document.getElementById('thnPend').value;
		var a=new DSGridObject("gridbox");
        a.setHeader("PENERIMAAN KLAIM KSO");
        a.setColHeader("NO,TANGGAL PENERIMAAN,TANGGAL KLAIM,NO PENGAJUAN KLAIM,NO PENERIMAAN KLAIM,KSO,NILAI,KET");
        a.setIDColHeader(",tgl,tglKlaim,noKlaim,no_bukti,nama,nilai,ket");
        a.setColWidth("40,80,80,100,100,250,100,200");
        a.setCellAlign("center,center,center,center,center,left,right,left");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.onLoaded(konfirmasi);
        a.baseURL("penerimaan_piutang_utils.php?grid=1&bln="+bln+"&thn="+thn);
		//alert("penerimaan_piutang_utils.php?grid=1&bln="+bln+"&thn="+thn);
        a.Init();

        var th_skr = "<?php echo $date_skr[2];?>";
        var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
		var fromHome=<?php echo $fromHome ?>;
    </script>
<script src="../report_form.js" type="text/javascript" language="javascript"></script>

</html>

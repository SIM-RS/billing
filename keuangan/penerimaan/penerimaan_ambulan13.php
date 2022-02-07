<?php
include '../secured_sess.php';
$userId=$_SESSION['id'];
$time_now=gmdate('H:i',mktime(date('H')+7));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>.: Pendapatan :.</title>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
		<link rel="stylesheet" type="text/css" href="../include/timepick/jquery.timeentry.css"> 
        <link type="text/css" href="../menu.css" rel="stylesheet" />
        <script type="text/javascript" src="../jquery.js"></script>
		<!--script type="text/javascript" src="../include/timepick/jquery.min.js"></script--> 
		<script type="text/javascript" src="../include/timepick/jquery.plugin.js"></script> 
		<script type="text/javascript" src="../include/timepick/jquery.timeentry.js"></script>
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
    <body bgcolor="#808080" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
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
                    <td height="20">&nbsp;</td>
                </tr>
				<tr>
					<td align="center" style="font-weight:bold; font-size:18px;">Form Penerimaan Ambulan</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
                <tr>
                    <td valign="top" align="center">
                        <table border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold">
							<tr>
								<td style="padding-left:30px;">Jenis Ambulance</td>
                                <td>:&nbsp;
									<select name="tipeKenda" id="tipeKenda" class="txtinput">
										<option value="0">Jenazah</option>
										<option value="1">Rescue</option>
									</select>
									<input type="hidden" name="txtId" id="txtId" />
								</td>
							</tr>
                            <tr>
                                <td style="padding-left:30px;">Tanggal Pemakaian</td>
                                <td>:&nbsp;
                                    <input id="txtTgl" name="txtTgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange);"/>
                                </td>
                            </tr>
							<tr>
                                <td style="padding-left:30px;">Tanggal Setor</td>
                                <td>:&nbsp;
                                    <input id="txtTglSet" name="txtTglSet" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onclick="gfPop.fPopCalendar(document.getElementById('txtTglSet'),depRange);"/>&nbsp;
                                    <input type="text" name="jam" id="jam" readonly class="txtinput" size="8"/>
									<script type="text/javascript">
										jQuery('#jam').timeEntry({
											show24Hours: true, 
											showSeconds: false,
											spinnerImage: '../include/timepick/spinnerDefault.png'
										});
										jQuery('#jam').timeEntry('setTime','<?php echo $time_now; ?>');
									</script>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:30px;">No Bukti</td>
                                <td>:&nbsp;
                                    <input id="txtNoBu" name="txtNoBu" size="30" class="txtinput" type="text" />
                                </td>
                            </tr>                            
                            <tr id="trForm">
                                <td style="padding-left:30px;">Nilai</td>
                                <td>:&nbsp;
                                    <input type="text" id="nilai" name="nilai" size="10" class="txtright"/></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding-left:30px;">
                                    Keterangan
                                </td>
                                <td valign="top"><span style="vertical-align:top">:</span>&nbsp;
                                    <textarea cols="36" id="txtArea" name="txtArea" class="txtinputreg"></textarea>
                                </td>
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
							<button onclick="cetak()" style=""><img src="../icon/printer.png" width="16px" alt="Cetak Laporan Pendapatan Parkir" />&nbsp;Cetak Laporan</button>
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
	function ambilData(){
	    var sisipan = a.getRowId(a.getSelRow()).split("|");
	     var isian = "txtId*-*"+sisipan[0]
	     +"*|*btnPenHapus*-*hapus*|*txtTgl*-*"+a.cellsGetValue(a.getSelRow(),2)
	     +"*|*txtTglSet*-*"+a.cellsGetValue(a.getSelRow(),3)
	     +"*|*jam*-*"+a.cellsGetValue(a.getSelRow(),4)
	     +"*|*txtNoBu*-*"+a.cellsGetValue(a.getSelRow(),5)
	     +"*|*tipeKenda*-*"+sisipan[1]
	     +"*|*nilai*-*"+a.cellsGetValue(a.getSelRow(),7);	     
	    fSetValue(window,isian);
	    document.getElementById("txtArea").value=a.cellsGetValue(a.getSelRow(),8);
	    document.getElementById("btnPenHapus").disabled=false;
	    document.getElementById("btnPenSimpan").value="simpan";
	}
	
	function simpanPen(){
	    var userId = "<?php echo $userId;?>";
		if(ValidateForm('tipeKenda,jam,txtTgl,txtNoBu,nilai,txtArea','ind')){
			var id = document.getElementById("txtId").value;
			var act = document.getElementById("btnPenSimpan").value;		
			var txtTglPar = document.getElementById("txtTgl").value;
			var txtTglSet = document.getElementById("txtTglSet").value;
			var jamSet = document.getElementById("jam").value;
			var tipeKenda = document.getElementById("tipeKenda").value;
			var txtNoBu = document.getElementById("txtNoBu").value;
			var nilai = document.getElementById("nilai").value;
			var txtArea = document.getElementById("txtArea").value;
			var bln = document.getElementById('blnPend').value;
			var thn = document.getElementById('thnPend').value;
			var param ="&rowid="+encodeURIComponent(id)
			+"&tipeKenda="+encodeURIComponent(tipeKenda)
			+"&txtTglPar="+encodeURIComponent(txtTglPar)
			+"&txtTglSet="+encodeURIComponent(txtTglSet)
			+"&jamSet="+encodeURIComponent(jamSet)
			+"&txtNoBu="+encodeURIComponent(txtNoBu)
			+"&nilai="+encodeURIComponent(nilai)
			+"&txtArea="+encodeURIComponent(txtArea)
			+"&bln="+encodeURIComponent(bln)
			+"&thn="+encodeURIComponent(thn)
			+"&userId="+encodeURIComponent(userId);
			//alert(param);
			var available = false;
			if(act=='simpan'){
				if(confirm("Anda yakin ingin mengubah data ini?")){
					available = true;
				}
			}else{
				available = true;
			}
			if(available){
				document.getElementById("btnPenSimpan").disabled=true;
				//alert("ambulance_utils.php?act="+act+param+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
				a.loadURL("ambulance_utils.php?grid=grid1&bln="+bln+"&thn="+thn+"&act="+act+param+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
				batalPen();
			}
		}
	}
	
	function hapusPen(){
		var rowid = document.getElementById("txtId").value;
		var act = document.getElementById("btnPenHapus").value;
		var bln = document.getElementById('blnPend').value;
		var thn = document.getElementById('thnPend').value;
		if(confirm("Anda yakin menghapus data Tanggal "+a.cellsGetValue(a.getSelRow(),2))){
			document.getElementById("btnPenHapus").disabled=true;
			a.loadURL("ambulance_utils.php?grid=grid1&bln="+bln+"&thn="+thn+"&act="+act+"&rowid="+rowid,"","GET");
			batalPen();
		}
	}
	
	function batalPen(){
	    var isian = "txtId*-**|*txtTgl*-*<?php echo $tgl;?>*|*txtTglSet*-*<?php echo $tgl;?>*|*txtNoBu*-**|*nilai*-**|*tipeKenda*-*0";
	    fSetValue(window,isian);	    
	    document.getElementById("txtArea").value="";	    
	    document.getElementById("jam").value="<?php echo $time_now; ?>";	    
	    document.getElementById("btnPenSimpan").value="tambah";
	    document.getElementById("btnPenHapus").disabled=true;
		document.getElementById("btnPenSimpan").disabled=false;
	}
	
	function konfirmasi(key,val){
            //alert(val);
		  if(val != undefined){
            var tangkap=val.split("*|*");
            var proses=tangkap[0];
            var alasan=tangkap[1];
            if(key=='Error'){
                if(proses=='hapus'){				
                    alert('Tidak bisa menambah data karena '+alasan+'!');
                }              

            }
            else{
                if(proses=='tambah'){
                    alert('Tambah Berhasil');
		    document.getElementById("btnPenSimpan").disabled=false;
                }
                else if(proses=='simpan'){
                    alert('Simpan Berhasil');
		    document.getElementById("btnPenSimpan").disabled=false;
                }
                else if(proses=='hapus'){
                    alert('Hapus Berhasil');		    
		    document.getElementById("btnPenHapus").disabled=true;
                }
            }
		}

        }
	
	function goFilterAndSort(grd){
		var bln = document.getElementById('blnPend').value;
		var thn = document.getElementById('thnPend').value;
		//alert("ambulance_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
		a.loadURL("ambulance_utils.php?grid=grid1&bln="+bln+"&thn="+thn+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
	}

	var bln = document.getElementById('blnPend').value;
	var thn = document.getElementById('thnPend').value;		
	var a=new DSGridObject("gridbox");
	a.setHeader("PENDAPATAN");
	a.setColHeader("NO,TGL PARKIR, TGL SETOR, JAM SETOR, NO BUKTI, JENIS AMBULAN, NILAI, KET, PETUGAS");
	a.setIDColHeader(",,,,no_bukti,nama,nilai,ket,username");
	a.setColWidth("40,80,80,50,100,250,80,300,100");
	a.setCellAlign("center,center,center,CENTER,left,left,right,left,center,center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowClick","ambilData");
	a.onLoaded(konfirmasi);
	a.baseURL("ambulance_utils.php?grid=grid1&bln="+bln+"&thn="+thn+"&tipe=lain2");
	a.Init();

	var th_skr = "<?php echo $date_skr[2];?>";
	var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
	var fromHome=<?php echo $fromHome ?>;
    </script>
<script src="../report_form.js" type="text/javascript" language="javascript"></script>

</html>

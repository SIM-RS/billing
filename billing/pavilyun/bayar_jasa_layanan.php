<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
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
<!--dibawah ini diperlukan untuk menampilkan menu dropdown-->
<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
<script language="JavaScript" src="../theme/js/dropdown.js"></script>
<title>Form Penjamin</title>
</head>

<body>
<div align="center">
<?php
	include("../koneksi/konek.php");
	include("../header1.php");
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
		<td height="30">PEMBAYARAN JASA PELAYANAN DOKTER
                
                  
                </td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td align="center" colspan="2">
            Periode Tindakan : 
            <input tabindex="2" id="txtTglAwal" name="txtTglAwal" size="10" class="txtcenter" value="<?php echo $date_now;?>" onFocus="this.select();" onBlur="if(this.value==''){this.value='<?php echo $date_now;?>'}" onkeyup="if(event.which==13){ cariLagi(); } else{}"/>
            <img alt="tglAwal" src="../icon/archive1.gif" onclick="gfPop.fPopCalendar(document.getElementById('txtTglAwal'),depRange,cariLagi);" style="cursor: pointer"/>
            &nbsp;sampai Tanggal bayar :&nbsp;                                    
            <input tabindex="3" id="txtTglAkhir" name="txtTglAkhir"  size="10" class="txtcenter" value="<?php echo $date_now;?>" onFocus="this.select();" onBlur="if(this.value==''){this.value='<?php echo $date_now;?>'}" onkeyup="if(event.which==13){ cariLagi(); } else{}"/>
            <img alt="tglAkhir" src="../icon/archive1.gif" onclick="gfPop.fPopCalendar(document.getElementById('txtTglAkhir'),depRange,cariLagi);" style="cursor: pointer"/>
            &nbsp;
            NAMA DOKTER:
            <select id="cmbDokPav" name="cmbDokPav" onchange="tampilkan();"></select>                
        </td>
    </tr>
     <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
   <tr>
      <td align="center" colspan="2">
        
         <div id="gridbox1" style="width:950px; height:200px;"></div>
		<div id="paging1" style="width:710px;"></div>
           
      </td>
   </tr>
    <tr>
    <td align="center" colspan="3">&nbsp;
        <span id="spLoader1" style="display:none;background-image:url(../images/ajax-loader-bar.gif);background-repeat:no-repeat;background-position:center;">Masih proses...</span>
    </td>
   </tr>
   <tr>
      <td align="left" width="400">&nbsp;
        <input type="button" id="btnUp" value="" onclick=" pindahKeAtas()" title="Pindahkan data dari tabel bawah ke tabel atas" class="tblUp"/>        
         <input type="button" id="btnBottom" value="" onclick="pindahKeBawah()" title="Pindahkan data dari tabel atas ke tabel bawah" class="tblBottom"/>         
      </td>
      <td align="left">
        <input type="button" id="btnCetakLap" name="btnCetakLap" value="CETAK LAPORAN" style="cursor:pointer" onMouseOver="MM_showMenu(window.mm_menu_0814123211_2,0,20,null,'btnCetakLap');" onMouseOut="MM_startTimeout();"/>
      </td>
   </tr>  
   <tr>
      <td align="center" colspan="2">        
       
          <div id="gridbox2" style="width:950px; height:200px;"></div>
		<div id="paging2" style="width:710px;"></div>            
      </td>
   </tr>
    <tr>
    <td align="center" colspan="3">&nbsp;
        <span id="spLoader2" style="display:none;background-image:url(../images/ajax-loader-bar.gif);background-repeat:no-repeat;background-position:center;">Masih proses...</span>
    </td>
   </tr>
</table>
</div>
</body>
</html>
<script>
    
    function cariLagi(){
        var tglAwal = document.getElementById("txtTglAwal").value;
        var tglAkhir = document.getElementById("txtTglAkhir").value;
        isiCombo('cmbDokPav',tglAwal+','+tglAkhir);
    }
    
    function cariBayar(){              
        tampilkan();
    }

    function loading(spanId,state){
        if(state){
            document.getElementById(spanId).style.display='block';
        }else{
            document.getElementById(spanId).style.display='none';
        }
    }
    
    function selesai1(){
        loading('spLoader1',false);
        loading('spLoader2',true);
		var dokter = document.getElementById("cmbDokPav").value;
        var tglAwal = document.getElementById("txtTglAwal").value;
        var tglAkhir = document.getElementById("txtTglAkhir").value;
        
		b.loadURL("bayar_jasa_layanan_utils.php?grd=2&dokter="+dokter+"&tglAwal="+tglAwal+"&tglAkhir="+tglAkhir,"","GET");
    }
    
    function selesai2(){
        loading('spLoader2',false);
    }
    //loading('spLoader1',true);
    
    function goFilterAndSort(grd){
        var dokter = document.getElementById("cmbDokPav").value;
        var tglAwal = document.getElementById("txtTglAwal").value;
        var tglAkhir = document.getElementById("txtTglAkhir").value;
		//alert(grd);
		if (grd=="gridbox1"){			
			a1.loadURL("bayar_jasa_layanan_utils.php?grd=1&dokter="+dokter+"&tglAwal="+tglAwal+"&tglAkhir="+tglAkhir+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage(),"","GET");
		}
        if (grd=="gridbox2"){			
			b.loadURL("bayar_jasa_layanan_utils.php?grd=2&dokter="+dokter+"&tglAwal="+tglAwal+"&tglAkhir="+tglAkhir+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
		}
	}
    
    var a1=new DSGridObject("gridbox1");
    a1.setHeader("DATA PASIEN BELUM BAYAR");	
    a1.setColHeader("pilih,NO,NO RM,NAMA PASIEN,PENJAMIN,MRS,KRS,POLI PAV.,KONSUL/VISITE,TINDAKAN");
    //a1.setIDColHeader("kode,nama,,,,");
    a1.setColWidth("30,30,60,200,100,70,70,80,90,80");
    a1.setCellAlign("center,center,left,left,center,center,center,right,right,right");
    a1.setCellType("chk,txt,txt,txt,txt,txt,txt,txt,txt,txt");
    a1.setCellHeight(20);
    a1.setImgPath("../icon");
    a1.setIDPaging("paging1");
    a1.onLoaded(selesai1);
    //a1.attachEvent("onRowClick","ambilData");
    //a1.baseURL("bayar_jasa_layanan_utils.php?grd=1");
    a1.Init();
    
</script>
<script>
    //loading('spLoader2',true);
    var b=new DSGridObject("gridbox2");
    b.setHeader("DATA PASIEN SUDAH BAYAR");	
    b.setColHeader("pilih,NO,NO RM,NAMA PASIEN,PENJAMIN,MRS,KRS,POLI PAV.,KONSUL/VISITE,TINDAKAN");
    //a1.setIDColHeader("kode,nama,,,,");
    b.setColWidth("30,30,60,200,100,70,70,80,90,80");
    b.setCellAlign("center,center,left,left,center,center,center,right,right,right");
    b.setCellType("chk,txt,txt,txt,txt,txt,txt,txt,txt,txt");
    b.setCellHeight(20);
    b.setImgPath("../icon");
    b.setIDPaging("paging2");
    b.onLoaded(selesai2);
    //a1.attachEvent("onRowClick","ambilData");
    //b.baseURL("bayar_jasa_layanan_utils.php?grd=2");
    b.Init();
    
</script>
<script>
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
    isiCombo('cmbDokPav',document.getElementById("txtTglAwal").value+','+document.getElementById("txtTglAkhir").value,'','',tampilkan);
    
    function tampilkan(){
        var dokter = document.getElementById("cmbDokPav").value;
        var tglAwal = document.getElementById("txtTglAwal").value;
        var tglAkhir = document.getElementById("txtTglAkhir").value;
        //alert("bayar_jasa_layanan_utils.php?grd=2&dokter="+dokter+"&bln="+bln+"&thn="+thn);
        loading('spLoader1',true);
        a1.loadURL("bayar_jasa_layanan_utils.php?grd=1&dokter="+dokter+"&tglAwal="+tglAwal+"&tglAkhir="+tglAkhir,"","GET");        
    }
    
    var pasienBelum='';
    function pindahKeBawah(){		
            for(var i=0;i<a1.obj.childNodes[0].rows.length;i++){
                    if(a1.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
                            pasienBelum+=a1.getRowId(parseInt(i)+1)+',';	
                    }
            }
            
            
            if(pasienBelum==''){
                alert("Silakan pilih pasien!");
            }
            else{
                //alert(pasienBelum);
                var dokter = document.getElementById("cmbDokPav").value;
                var tglAwal = document.getElementById("txtTglAwal").value;
                var tglAkhir = document.getElementById("txtTglAkhir").value;
                
                loading('spLoader1',true);
                //alert("bayar_jasa_layanan_utils.php?grd=1&act=tambah&id="+pasienBelum+"&dokter="+dokter+"&bln="+bln+"&thn="+thn);
                a1.loadURL("bayar_jasa_layanan_utils.php?grd=1&act=tambah&id="+pasienBelum+"&dokter="+dokter+"&tglAwal="+tglAwal+"&tglAkhir="+tglAkhir,"","GET");
               
                pasienBelum='';
            }
    }
    var pasienSudah='';
    function pindahKeAtas(){
            
            for(var i=0;i<b.obj.childNodes[0].rows.length;i++){
                    if(b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
                            pasienSudah+=b.getRowId(parseInt(i)+1)+',';	
                    }
            }
            
            if(pasienSudah==''){
                    alert("Silakan pilih pasien!");
            }
            else{
                //alert(pasienSudah);
                var dokter = document.getElementById("cmbDokPav").value;
                var tglAwal = document.getElementById("txtTglAwal").value;
                var tglAkhir = document.getElementById("txtTglAkhir").value;                
                loading('spLoader1',true);
                //alert("bayar_jasa_layanan_utils.php?grd=1&act=hapus&id="+pasienSudah+"&dokter="+dokter+"&bln="+bln+"&thn="+thn);                
                a1.loadURL("bayar_jasa_layanan_utils.php?grd=1&act=hapus&id="+pasienSudah+"&dokter="+dokter+"&tglAwal="+tglAwal+"&tglAkhir="+tglAkhir,"","GET");
                
                pasienSudah='';
            }
            
    }
    function cetakLaporan(val){
        var dokter = document.getElementById("cmbDokPav").value;
        var tglAwal = document.getElementById("txtTglAwal").value;
        var tglAkhir = document.getElementById("txtTglAkhir").value;
        if(val==0 || val==1){
            window.open('kwitansiPembayaran.php?jenis='+val+'&dokter='+dokter+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir,'_blank');
        }
	   else if(val==2 || val==3){
		window.open('kwitansiPembayaran_ono.php?jenis='+val+'&dokter='+dokter+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir,'_blank');
	   }
	   else if(val==4 || val==5){
		window.open('kwitansiPembayaran_bukanDokter.php?jenis='+val+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir,'_blank');
	   }
       else if(val==6 || val==7){
		window.open('kwitansiPembayaran_persalinan.php?dokter='+dokter+'&jenis='+val+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir,'_blank');
	   }
       else if(val==8){
		window.open('kwitansiPembayaran_PersalinanBukanDokter.php?jenis='+val+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir,'_blank');
	   }
    }
    mmLoadMenus();
</script>

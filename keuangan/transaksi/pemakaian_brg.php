<?php
include("../sesi.php");
include '../secured_sess.php';
$userId=$_SESSION['id'];
        ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>.: Pemakaian Bahan :.</title>
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
	include('pemakaian_brg_detail.php');
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
                    <td valign="top" align="center">
                        <table width="900" border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold">
                            <tr><td colspan="3">&nbsp;</td></tr>
                            <tr><td colspan="3" align="center">PEMAKAIAN BAHAN</td></tr>
									 <tr><td colspan="3">&nbsp;</td></tr>                            
                            <tr id="trBln">
                                <td width="43">
                                    Periode
                                </td>
                                <td>:&nbsp;
                                    <select id="bln" name="bln" onchange="filter()" class="txtinputreg">
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
                                    <select id="thn" name="thn" onchange="filter()" class="txtinputreg">goFilterAndSort('gridbox')
                                        <?php
                                        for ($i=($th[2]-5);$i<($th[2]+1);$i++) {
                                            ?>
                                        <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$th[2]) echo "selected";?>><?php echo $i;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    </td><td align="right">
                                    <!--button type="button" style="cursor: pointer" onClick="detailBhn()">
                            <img alt="add" src="../icon/edit.gif" border="0" onclick="" width="16" height="16" ALIGN="absmiddle" />
                            Detail Bahan
                        </button-->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr id="trPen">
                    <td align="center" >
                    <br>
                        <fieldset style="width:900px">
                        <input type="hidden" id="id" name="id" />
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
    </body>        
 <script type="text/javascript" >
 function filter()
        {
            var bln = document.getElementById("bln").value;
            var thn = document.getElementById("thn").value;
            //alert("utils.php?pilihan=penerimaanpo&bln="+bln+"&thn="+thn);
            po.loadURL("pemakaian_brg_utils.php?bln="+bln+"&thn="+thn,"","GET");
        }
        
        function balikTgl(tgl){
            var part = tgl.split("-");
            var temp=part[2]+"-"+part[1]+"-"+part[0];
            return temp;
        }
        
        function goFilterAndSort(grd)
        {
            var bln = document.getElementById("bln").value;
            var thn = document.getElementById("thn").value;
            if (grd=="gridbox"){
                po.loadURL("pemakaian_brg_utils.php?bln="+bln+"&thn="+thn+"&filter="+po.getFilter()+"&sorting="+po.getSorting()+"&page="+po.getPage(),"","GET");
            }
            else if (grd=="gridbox1"){
				var sisipan=po.getRowId(po.getSelRow()).split('*|*');
				var txtNoPen=document.getElementById('txtNoPen').value=sisipan[3]
				var txtTgl=document.getElementById('txtTgl').value=sisipan[5]
                po1.loadURL("pemakaian_brg_detil_util.php?no_gd="+txtNoPen+"&tgl="+txtTgl+"&filter="+po1.getFilter()+"&sorting="+po1.getSorting()+"&page="+po1.getPage(),"","GET");
            }
        
        }
        
      /*   function detailBhn(){
				if(document.getElementById('id').value==''){
						alert('pilih data terlebih dahulu');					
						return false;					
					}
					window.location='pemakaian_brg_detail.php?act=detail&id='+document.getElementById('id').value;        	
				//	alert('c');
        	} */
//var c = 0;
//var temp;
 function ambilData(){
 			var sisipan=po.getRowId(po.getSelRow()).split('*|*');
 			var txtNoPen=document.getElementById('txtNoPen').value=sisipan[3]
			var txtUntuk=document.getElementById('txtUntuk').value=sisipan[4]
			var txtTgl=document.getElementById('txtTgl').value=sisipan[5]
			var txtPenerima=document.getElementById('txtPenerima').value=sisipan[2]
			var txtPetGud=document.getElementById('txtPetGud').value=sisipan[1]
			
		
			po1.loadURL("pemakaian_brg_detil_util.php?no_gd="+txtNoPen+"&tgl="+txtTgl,"","GET");
			//alert("pemakaian_brg_detil_util.php?no_gd="+txtNoPen+"&tgl="+txtTgl);
			new Popup('divPop',null,{modal:true,position:'center',duration:0.5})
            $('divPop').popup.show();
			
			
           /*  var sisip = po.getRowId(po.getSelRow()).split('*|*');    
			//temp =  po.getRowId(po.getSelRow());     
            var p="id*-*"+(balikTgl(po.cellsGetValue(po.getSelRow(),4))+'|'+po.cellsGetValue(po.getSelRow(),3)+'|'+po.cellsGetValue(po.getSelRow(),6)+'|'+po.cellsGetValue(po.getSelRow(),2)+'|'+sisip[1]+'|'+sisip[2]+'|'+sisip[0]);
            fSetValue(window,p); */
        }

        
		
		var po=new DSGridObject("gridbox");
        po.setHeader(".: DAFTAR PEMAKAIAN BAHAN :.");
        po.setColHeader("NO,TGL.KELUAR,NOMOR KELUAR,TGL.BON,NOMOR BON,PERUNTUKAN,NILAI PENGELUARAN");
        po.setIDColHeader(",k.tgl_gd,k.no_gd,k.tgl_transaksi,k.no_transaksi,u.namaunit,");
        po.setColWidth("50,100,150,100,150,150,");
        po.setCellAlign("center,center,center,center,center,center,right");
        po.setCellHeight(20);
        po.setImgPath("../icon");
        po.setIDPaging("paging");
        po.attachEvent("onRowDblClick","ambilData");
        //alert("utils.php?pilihan=keluarbon&bln="+document.getElementById("bulan").value+"&thn="+document.getElementById("ta").value);
        po.baseURL("pemakaian_brg_utils.php?bln="+document.getElementById("bln").value+"&thn="+document.getElementById("thn").value);
        po.Init();
		
</script>       
</html>
        
        
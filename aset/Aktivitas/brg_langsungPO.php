<?php
include '../sesi.php';
include '../koneksi/konek.php'; 
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/aset/';
        </script>";
}
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: Daftar Penerimaan Barang Langsung :.</title>
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
            include("../header.php");
            ?>
            <table align="center" width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFBF0">
                <tr>
                    <td height="20" colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4" align="center" style="font-size:16px;">DAFTAR PENERIMAAN BARANG LANGSUNG</td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="35%">BULAN
                        
                        <select name="bulan" class="txt" id="bulan" onChange="filter()">
                            <option value="1" class="txtinput"<?php if ($th[1]=="1") echo "selected";?>>Januari</option>
                            <option value="2" class="txtinput"<?php if ($th[1]=="2") echo "selected";?>>Pebruari</option>
                            <option value="3" class="txtinput"<?php if ($th[1]=="3") echo "selected";?>>Maret</option>
                            <option value="4" class="txtinput"<?php if ($th[1]=="4") echo "selected";?>>April</option>
                            <option value="5" class="txtinput"<?php if ($th[1]=="5") echo "selected";?>>Mei</option>
                            <option value="6" class="txtinput"<?php if ($th[1]=="6") echo "selected";?>>Juni</option>
                            <option value="7" class="txtinput"<?php if ($th[1]=="7") echo "selected";?>>Juli</option>
                            <option value="8" class="txtinput"<?php if ($th[1]=="8") echo "selected";?>>Agustus</option>
                            <option value="9" class="txtinput"<?php if ($th[1]=="9") echo "selected";?>>September</option>
                            <option value="10" class="txtinput"<?php if ($th[1]=="10") echo "selected";?>>Oktober</option>
                            <option value="11" class="txtinput"<?php if ($th[1]=="11") echo "selected";?>>Nopember</option>
                            <option value="12" class="txtinput"<?php if ($th[1]=="12") echo "selected";?>>Desember</option>
                        </select>
                        <select name="ta" class="txt" id="ta" onChange="filter()">
                            <?php
                            for ($i=($th[2]-5);$i<($th[2]+1);$i++){
                                ?>
                            <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$th[2]) echo "selected";?>><?php echo $i;?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <input type="hidden" id="id" name="id" />
                    </td>
                    <td width="45%" align="right">
                        <!--button id="btnLapPen" disabled type="button" onClick="laporan()" style="cursor: pointer">
                            <img alt="add" src="../icon/article.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Laporan Penerimaan
                        </button-->
                        <!--button type="button" onClick="location='po_detail_lsg.php?act=add'" style="cursor: pointer">
                            <img alt="add" src="../icon/find.png" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Penerimaan Baru
                        </button-->
                        <button type="button" style="cursor: pointer" onClick="buatPO()">
                            <img alt="add" src="../icon/edit.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Pembuatan PO
                        </button>
                    </td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4" align="center">
                        <div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                <?php
                include '../footer.php';
                ?>
                    </td>
                </tr>
            </table>
            <form id="dt" method="post" action="buat_po.php">
            <input type="hidden" id="kirim" name="kirim"/>
            </form>
        </div>
    </body>
    <script type="text/javascript" language="javascript">
        function laporan(){
            var id = document.getElementById("id").value;
            window.open("reportBeritaAcara.php?id="+id,"lapPen");
        }
        
        function buatPO(){
				//alert(kirim);
				if(kirim==''){
						alert('data tidak boleh kosong');
						return false;					
					} 
					document.forms[0].kirim.value = kirim;
					document.forms[0].submit();
					       	
        	}
    
        function filter()
        {
            var bln = document.getElementById("bulan").value;
            var thn = document.getElementById("ta").value;
            //alert("utils.php?pilihan=penerimaanpo&bln="+bln+"&thn="+thn);
            po.loadURL("penerimaanPO_lsg_util.php?bln="+document.getElementById("bulan").value+"&thn="+document.getElementById("ta").value,"","GET");
        }

        function goFilterAndSort(grd)
        {
            var bln = document.getElementById("bulan").value;
            var thn = document.getElementById("ta").value;
            if (grd=="gridbox"){
                po.loadURL("penerimaanPO_lsg_util.php?bln="+document.getElementById("bulan").value+"&thn="+document.getElementById("ta").value+"&filter="+po.getFilter()+"&sorting="+po.getSorting()+"&page="+po.getPage(),"","GET");
            }
        }
        function ambilData()
        {
            var p="id*-*"+(po.cellsGetValue(po.getSelRow(),3)+'|'+po.cellsGetValue(po.getSelRow(),4)+'|'+po.cellsGetValue(po.getSelRow(),5));
            fSetValue(window,p);
           // document.getElementById("btnLapPen").disabled=false;
        }
        
        function chksemua(ap){
        	//alert(ap.checked);
				if(ap.checked==true){
					var f=po.getMaxRow();
					//alert(f);
					for(var r=1;r<=f;r++){
							document.getElementById("btn_"+r).checked=true;
							datakirim(document.getElementById("btn_"+r).value,document.getElementById("btn_"+r));
							//alert(document.getElementById("btn_"+r).value);
						}		
					}else{
						var f=po.getMaxRow();
					//alert(f);
					for(var r=1;r<=f;r++){
							document.getElementById("btn_"+r).checked=false;
							datakirim(document.getElementById("btn_"+r).value,document.getElementById("btn_"+r));
												
						}
				}        	
        	}
        	var kirim='';
        	function datakirim(dt,h){ 		
        		if(h.checked){
					 kirim=dt+'|'+kirim;
					}else{
					var f = kirim.split('|');
				   var ok='';					
					for(var t=0;t<f.length;t++){
							if(f[t]!=dt&&f[t]!=''){
										ok += f[t]+"|"; 							
								}						
						}
						kirim=ok;
					//	alert(ok);
					}
        		}

        var po=new DSGridObject("gridbox");
        po.setHeader(".: DAFTAR PENERIMAAN BARANG LANGSUNG :.");
        po.setColHeader("NO,&nbsp;<input type=\"checkbox\" onclick=\"chksemua(this);\">,TGL FAKTUR,NO FAKTUR,REKANAN,KODE BARANG,NAMA BARANG,SATUAN,JUMLAH,HARGA SATUAN,TOTAL");
        po.setIDColHeader(",,msk.tgl_faktur,msk.no_faktur,rek.namarekanan,brg.kodebarang,brg.namabarang,brg.idsatuan,po.qty_satuan,po.harga_satuan");
        po.setColWidth("50,50,100,100,150,150,200,100,100,150,150");
        po.setCellAlign("center,center,center,center,center,center,");
        //po.setCellType("txt,chk,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
        po.setCellHeight(20);
        po.setImgPath("../icon");
        po.setIDPaging("paging");
        po.attachEvent("onRowClick","ambilData");        
        //alert("penerimaanPO_util.php?bln="+document.getElementById("bulan").value+"&thn="+document.getElementById("ta").value);
        po.baseURL("penerimaanPO_lsg_util.php?bln="+document.getElementById("bulan").value+"&thn="+document.getElementById("ta").value);
        po.Init();
    </script>
</html>

<?php
include '../sesi.php';
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/simrs-tangerang/aset/';
                        </script>";
}
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <title>.: Riwayat Pengeluaran Barang :.</title>
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
            include "../header.php";
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            $tgl=explode("-",$date_now);
            $tgl1=$tgl[2]."-".$tgl[1]."-".$tgl[0];
			
            ?>
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center">
                        <table width="850" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
                            <tr>
                                <td height="30" valign="bottom" align="right">
                                    <input type="hidden" id="id" name="id" />
                                    <input type="hidden" id="barang_id" name="barang_id" />
                                                             </td>
                            </tr>
                            <tr>
                                <td>
                                    Periode :
                                    <input id="txtTgl" name="txtTgl" value="<?php echo $date_now;?>" readonly size="10" class="txtcenter"/>
                                    &nbsp;
                                    <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange,filter);" /> s/d                                
                                    <input id="txtTgl2" name="txtTgl2" value="<?php echo $date_now;?>" readonly="readonly" size="10" class="txtcenter"/>&nbsp;
                                    <img alt="calender" style="cursor:pointer" border="0" src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtTgl2'),depRange,filter);" />&nbsp;
									
									<button type="button" id="view" onClick="tampil()" style="cursor: pointer">
                                        <!--img border="0" width="16" height="10" /-->
                                        Tampilkan                                  </button>
									</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <div id="gridbox" style="width:950px; height:350px; background-color:white; overflow:hidden;"></div>
                                    <div id="paging" style="width:950px;"></div>
                                    <span id="spanxx" style="display: none"></span>                                </td>
                            </tr>
                        </table>
                        <div><img alt="" src="../images/foot.gif" width="1000" height="45" /></div>
                    </td>
                </tr>
            </table>
        </div>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
    </body>
    <script type="text/javascript" language="javascript">
        //select barang query ambil dari mana?
        //action save,edit delete
        function tampil(){
            //document.write("utils_riwayat_pengeluaran_barang.php?pilihan=penerimaan&tglawal="+document.getElementById('txtTgl').value+"&tglAkhir="+document.getElementById('txtTgl2').value);
            rek.loadURL("utils_riwayat_pengeluaran_barang.php?pilihan=penerimaan&tglAwal="+document.getElementById('txtTgl').value+"&tglAkhir="+document.getElementById('txtTgl2').value,"","GET");
			
        }
        var arrRange=depRange=[];
        function suggest(e, par){
            var keywords=par.value;//alert(keywords);
            //alert(par.offsetLeft);
            /*var tbl = document.getElementById('tblJual');
            var jmlRow = tbl.rows.length;
            var i;
            if (jmlRow > 4){
                i=par.parentNode.parentNode.rowIndex-2;
            }else{
                i=0;
            }*/
            //alert(jmlRow+'-'+i);
            if(par.id == 'cmb_jenis'){
                if(document.getElementById('nama_barang').value != ''){
                    Request('baranglist.php?aKeyword='+document.getElementById('nama_barang').value+'&tipe='+keywords+'&act=opname' , 'divbarang', '', 'GET' );
                    if (document.getElementById('divbarang').style.display=='none') fSetPosisi(document.getElementById('divbarang'),par);
                    document.getElementById('divbarang').style.display='block';
                    document.getElementById('nama_barang').focus();
                }
            }
            else{
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
                        if (tblRow>0){
                            //alert(RowIdx);
                            if (key==38 && RowIdx>0){
                                RowIdx=RowIdx-1;
                                document.getElementById(RowIdx+1).className='itemtableReq';
                                if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
                            }else if (key==40 && RowIdx<tblRow){
                                RowIdx=RowIdx+1;
                                if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
                                document.getElementById(RowIdx).className='itemtableMOverReq';
                            }
                        }
                    }
                    else if (key==13){
                        if (RowIdx>0){
                            if (fKeyEnt==false){
                                fSetObat(document.getElementById(RowIdx).lang);
                            }else{
                                fKeyEnt=false;
                            }
                        }
                    }
                    else if (key!=27 && key!=37 && key!=39){
                        RowIdx=0;
                        fKeyEnt=false;
                        Request('baranglist.php?aKeyword='+keywords+'&tipe='+document.getElementById('cmb_jenis').value+'&act=opname' , 'divbarang', '', 'GET' );
                        if (document.getElementById('divbarang').style.display=='none') fSetPosisi(document.getElementById('divbarang'),par);
                        document.getElementById('divbarang').style.display='block';
                    }
                }
            }
        }

        function fSetObat(par){
            var tmp = par.split('*|*');
            //$no."*|*".$rows['ms_barang_id']."*|*".$rows['kodebarang']."*|*".$rows['namabarang']."*|*".$rows['qty_stok']."*|*".$rows['harga_beli_satuan'];
            //*|*4*|*Kampung*|**|*01.01.01.01
            document.getElementById('barang_id').value = tmp[0];
            document.getElementById('nama_barang').value = tmp[2];
//            document.getElementById('jml').value = tmp[4];
//            document.getElementById('harga').value = tmp[5];
            document.getElementById('satuan').value = tmp[3];
            document.getElementById('divbarang').style.display='none';
        }

        function ambilData()
        {
            if(document.getElementById('btn_act').value == 'Tambah' && document.getElementById('tr_form').style.display == ''){
            }
            else{
                //$rows['opname_id'].'*|*'.$rows['barang_id'].'*|*'.$rows['tipe'].'*|*'.$rows['aharga']
                var tmp = rek.getRowId(rek.getSelRow()).split('*|*');
                var p="id*-*"+tmp[0]+"*|*barang_id*-*"+tmp[1]+"*|*cmb_jenis*-*"+tmp[2]+"*|*harga*-*"+tmp[3]+"*|*satuan*-*"+rek.cellsGetValue(rek.getSelRow(),4);
                p += "*|*nama_barang*-*"+rek.cellsGetValue(rek.getSelRow(),3)+"*|*jml*-*"+rek.cellsGetValue(rek.getSelRow(),6);
                fSetValue(window,p);
            }
        }

        function act(par,id){
            var val = par.id;
            if(par.id == undefined || par.id == ''){
                val = 'Batal';
            }
            switch(val){
                case 'btn_act':
                    if(document.getElementById('barang_id').value == '' || (document.getElementById('jml').value == '' || isNaN(document.getElementById('jml').value)) || (document.getElementById('harga').value || isNaN(document.getElementById('harga').value)) == ''){
                        alert("Masukkan dulu data barang, jumlah dan harga dengan benar.");
                        return;
                    }
                    var id = document.getElementById('id').value;
                    var barang_id = document.getElementById('barang_id').value;
                    var qty = document.getElementById('jml').value;
                    var harga = document.getElementById('harga').value;
                    var tgl = document.getElementById('txtTgl').value;
                    var usr_id = "<?php echo $_SESSION['id_user'];?>";
                    var satuan = document.getElementById('satuan').value;
                    var url = "utils.php?act=cek_opname&barang_id="+barang_id;
                    Request(url, 'spanxx', '', 'GET', function(){
                        if(document.getElementById('spanxx').innerHTML > 0){
                            alert(document.getElementById('nama_barang').value+" sudah ada dalam stok opname.\nSilakan edit data yang ada.");
                            return;
                        }
                        document.getElementById('spanxx').innerHTML = '';
                        url = 'utils_riwayat_pengeluaran_barang.php?pilihan=penerimaan&tglTagihan='+tgl+'&act='+par.value+'_opname&id='+id+'&qty='+qty+'&harga='+harga+'&barang_id='+barang_id+'&usr_id='+usr_id+'&satuan='+satuan;
                        //alert(url)
                        rek.loadURL(url,'','GET');
                    });
                    
                    break;
                /*case 'del':
                    if(confirm("Anda yakin menghapus Stok Opname "+rek.cellsGetValue(rek.getSelRow(),3))){
                        //alert("utils.php?pilihan=opname&bln="+document.getElementById('cmbBln').value+"&thn="+document.getElementById('cmbTh').value+"&act=hapus_pemakaian&id="+id);
                        var url = "utils_riwayat_pengeluaran_barang.php?pilihan=penerimaan&tglTagihan="+document.getElementById('txtTgl').value+"&act=hapus_opname&id="+id;
                        //alert(url)
                        rek.loadURL(url,"","GET");
                    }
                    break;*/
                case 'btn_can':
                    document.getElementById('nama_barang').value = '';
                    document.getElementById('jml').value = '';
                    document.getElementById('satuan').value = '';
                    document.getElementById('id').value = '';
                    document.getElementById('barang_id').value = '';
                    document.getElementById('harga').value = '';
                    document.getElementById('tr_form').style.display = 'none';
                    document.getElementById('edit').disabled = false;
                    //document.getElementById('del').disabled = false;
                    document.getElementById('view').disabled = false;
                    document.getElementById('btn_act').value = 'Tambah';
                    break;
                case 'view':
                    document.getElementById('edit').disabled = true;
                    //document.getElementById('del').disabled = true;
                    document.getElementById('tr_form').style.display = '';
                    break;
                case 'edit':
                    document.getElementById('btn_act').value = 'Simpan';
                    //document.getElementById('del').disabled = true;
                    document.getElementById('view').disabled = true;
                    document.getElementById('tr_form').style.display = '';
                    break;
            }
        }

        function filter(){
            rek.loadURL("utils_riwayat_pengeluaran_barang.php?pilihan=penerimaan&tglAwal="+document.getElementById('txtTgl').value,"","GET");
        }

        function goFilterAndSort(pilihan){
            if (pilihan=="gridbox")
            {
                rek.loadURL("utils_riwayat_pengeluaran_barang.php?pilihan=penerimaan&tglAwal="+document.getElementById('txtTgl').value+"&tglAkhir="+document.getElementById('txtTgl2').value+"&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage(),"","GET");
                //document.write("utils_riwayat_pengeluaran_barang.php?pilihan=penerimaan&tglAwal="+document.getElementById('txtTgl').value+"&tglAkhir="+document.getElementById('txtTgl2').value+"&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage());
            }   
        }

        function diLoad(){
            act(document.getElementById('btn_can'));
        }

        var rek=new DSGridObject("gridbox");
        rek.setHeader(".: Riwayat Pengeluaran Barang :.");
        rek.setColHeader("No,Tanggal,No.Keluar,Kode,Barang,Satuan,Jumlah,Unit,Lokasi,Petugas");
        rek.setIDColHeader(",,,kodebarang,namabarang,,,namaunit,namalokasi");
        rek.setColWidth("40,80,130,100,200,70,50,80,80,50");
        rek.setCellAlign("center,center,center,center,left,center,center,center,center,left");
        rek.setCellHeight(20);
        rek.setImgPath("../icon");
        rek.setIDPaging("paging");
        rek.attachEvent("onRowClick","ambilData");
        rek.onLoaded(diLoad);
        rek.baseURL("utils_riwayat_pengeluaran_barang.php?pilihan=penerimaan&tglAwal="+document.getElementById('txtTgl').value+"&tglAkhir="+document.getElementById('txtTgl2').value);
        rek.Init();
    </script>
</html>
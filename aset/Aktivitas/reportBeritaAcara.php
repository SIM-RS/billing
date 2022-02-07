<?php
include '../sesi.php';
// is valid users
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
$r_formatlap = $_POST["formatlap"];

switch ($r_formatlap) {
    case "XLS" :
        Header("Content-Type: application/vnd.ms-excel");
        break;
    case "WORD" :
        Header("Content-Type: application/msword");
        break;
    default :
        Header("Content-Type: text/html");
        break;
}
$getID = explode("|",$_REQUEST['id']); //echo $_REQUEST['id'];
$tglGD = $getID[3];
$noGudang = $getID[0];
$noFaktur = $getID[2];

$title="Berita Acara Penerimaan Barang";
$sData = "SELECT m.penerima,m.tgl_terima,m.no_gudang,m.tgl_faktur,m.no_faktur,m.exp_bayar,
r.namarekanan,r.alamat,r.bank,r.no_rek,b.kodebarang,b.namabarang,b.tipebarang,
m.msk_uraian,m.jml_msk,m.harga_unit,m.jml_msk*m.harga_unit AS subtotal 
FROM as_masuk m left JOIN as_po p ON p.id=m.po_id 
INNER JOIN as_ms_barang b ON b.idbarang=m.barang_id
left JOIN as_ms_rekanan r ON r.idrekanan=p.vendor_id
WHERE DATE_FORMAT(m.tgl_terima,'%d-%m-%Y')='$tglGD' AND m.no_faktur='$noFaktur' AND m.no_gudang='$noGudang'";

//echo $sData;
$rsData = mysql_query($sData);
 $i=0;
$total=0;
while($rwData=mysql_fetch_array($rsData)){
    $penerima = ifBlankNbsp($rwData['penerima']);
    $tglTerima = tglSQL($rwData['tgl_terima']);
    $noTerima = ifBlankNbsp($rwData['no_gudang']);
    $namaSupplier = ifBlankNbsp($rwData['namarekanan']);
    $alamat = ifBlankNbsp($rwData['alamat']);
    $bank = ifBlankNbsp($rwData['bank']);
    $noRek = ifBlankNbsp($rwData['no_rek']);
    $noFaktur = ifBlankNbsp($rwData['no_faktur']);
    $tglFaktur = tglSQL($rwData['tgl_faktur']);
    $expBayar = tglSQL($rwData['exp_bayar']);
    $kodebarang[$i]=ifBlankNbsp($rwData['kodebarang']);
    $namabarang[$i]=ifBlankNbsp($rwData['namabarang']);      
    $merk[$i] = ifBlankNbsp($rwData['msk_uraian']);
    $qty[$i] = ifBlankNbsp($rwData['jml_msk']);
    $harga[$i] = number_format(ifBlankNbsp($rwData['harga_unit']),0,",",".");
    $subtotal[$i] = number_format(ifBlankNbsp($rwData['subtotal']),0,",",".");
    $total+=$rwData['subtotal'];
    $i++;
    
}
function ifBlankNbsp($value){
    return ($value=='')?'&nbsp':$value;
    //return $value;
}
?>
<html>
    <head>
        <title><?php echo $title;?></title>
        <style>
            #tabel {
                border:solid 1px #000000;
            }
            #tabel th{
                text-align:center;
                border:solid 1px #000000;
                border-bottom:none;
                border-right:none;
                font:10pt verdana;
                background-color:#c0c0c0;
            }
            #tabel td{
                text-align:center;
                border:solid 1px #000000;
                border-bottom:none;
                border-right:none;
                font:9pt verdana;
                
            }
        </style>
    </head>
    <body>
        <table width="800" border="0">
            <tr>
                <td colspan="7" style="text-align:center;text-transform:uppercase;font: 14pt bold;"><?php echo $title;?></td>
            </tr>
            <tr>
                <td colspan="7" >&nbsp;</td>
            </tr>   
            <tr>
                <td width="15%">Tgl Penerimaan</td>
                <td width="1%">:</td>
                <td width="25%"><?php echo $tglTerima;?></td>
                <td>&nbsp;</td>
                <td width="25%">Tgl Faktur</td>
                <td width="1%">:</td>
                <td width="20%"><?php echo $tglFaktur;?></td>
            </tr>
            <tr>
                <td>No Penerimaan</td>
                <td>:</td>
                <td><?php echo $noTerima;?></td>
                <td>&nbsp;</td>
                <td>No Faktur</td>
                <td>:</td>
                <td><?php echo $noFaktur?></td>
            </tr>
             <tr>
                <td>Supplier</td>
                <td>:</td>
                <td><?php echo $namaSupplier;?></td>
                <td>&nbsp;</td>
                <td>Jatuh Tempo Pembayaran</td>
                <td>:</td>
                <td><?php echo $expBayar;?></td>
            </tr>
              <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?php echo $alamat;?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
               <tr>
                <td>Rekening</td>
                <td>:</td>
                <td><?php echo $bank." ".$noRek;?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
                <tr>
                <td colspan="7" >&nbsp;</td>
            </tr>
                 <tr>
                <td colspan="7" >&nbsp;</td>
            </tr>  
            <tr>
                <td colspan="7" >
                    <table id="tabel" width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Kode Barang</th>
                            <th width="25%">Nama Barang</th>
                            <th width="25%">Merk / Tipe</th>
                            <th width="5%">Qty</th>
                            <th width="13%">@Harga</th>
                            <th width="12%">Sub Total</th>
                        </tr>
                        <?php
                       for($k=0;$k<$i;$k++){
                       	if($qty[$k]>0){
                        ?>
                        <tr>
                            <td style="border-left:none;"><?php echo ($k+1);?></td>
                            <td style="text-align:left; padding-left:3px;"><?php echo $kodebarang[$k];?></td>
                            <td style="text-align:left; padding-left:3px;"><?php echo $namabarang[$k];?></td>
                            <td><?php echo $merk[$k];?></td>
                            <td><?php echo $qty[$k];?></td>
                            <td style="text-align:right;"><?php echo $harga[$k];?></td>
                            <td style="text-align:right;"><?php echo $subtotal[$k];?></td>
                        </tr>
                        <?php
                        }
                       }
                        ?>
                        <tr>
                            <td style="border-left:none;">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td style="text-align:right;font-size:10pt;font-weight:bold;">Total : </td>
                            <td style="text-align:right;font-size:10pt;font-weight:bold;"><?php echo number_format($total,0,",",".");?></td>
                        </tr>
                        <tr>
                            <td style="border-left:none;">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td style="text-align:right;font-size:10pt;font-weight:bold;">PPN 10% : </td>
                            <td style="text-align:center;font-size:10pt;font-weight:bold;font-style:italic;">Include</td>
                        </tr>
                        <tr>
                            <td style="border-left:none;">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td style="text-align:right;font-size:10pt;font-weight:bold;">Total + PPN : </td>
                            <td style="text-align:right;font-size:10pt;font-weight:bold;"><?php echo number_format($total,0,",",".");?></td>
                        </tr>
                    </table>
                </td>
            </tr>
             <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
             <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
             <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3" align="center"><?=$kotaRS;?>, <?php echo $tglTerima;?></td>                                
            </tr>
             <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3" align="center">Penerima,</td>
            </tr>
             <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
             <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
             <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3" align="center"><?php echo $penerima;?></td>
            </tr>
              <tr id="trButton">
                <td colspan="7" align="center">
                    <input type="button" id="btnCetak" name="btnCetak" value="CETAK" onClick="cetak()"/>
                    <input type="button" id="btnTutup" name="btnTutup" value="TUTUP" onClick="window.close();"/>
                </td>
            </tr>
        </table>
        <script>
            function cetak(){
                document.getElementById("trButton").style.display="none";
                if(document.getElementById("trButton").style.display="none"){                    
                    window.print();
                    window.close();
                    
                }
            }
        </script>
    </body>
</html>
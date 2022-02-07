<?php
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");

$page = $_REQUEST["page"];
//$defaultsort="o.OBAT_NAMA,m.ID";
$defaultsort = "TGL_ACT DESC";
// $sorting = $_REQUEST["sorting"];
$filter = $_REQUEST["filter"];
convert_var($page, $filter);


function query($konek, $sql)
{
    $sql = mysqli_query($konek, $sql) or die(mysqli_error($konek));
    return $sql;
}

function fetch($query)
{
    $query = mysqli_fetch_assoc($query);
    return $query;
}

$getTgl = $_REQUEST['tgl'];
$tgl = '';
if ($getTgl == '') {
    $tgl = date('Y-m-d');
    $tglAwal = explode('-', $tgl);
    $tglOut = $tglAwal[2] . '-' . $tglAwal[1] . '-' . $tglAwal[0];
} else {
    $tglExplode = explode('-', $getTgl);
    $tgl = $tglExplode[2] . '-' . $tglExplode[1] . '-' . $tglExplode[0];
    $tglAwal = explode('-', $tgl);
    $tglOut = $tglAwal[2] . '-' . $tglAwal[1] . '-' . $tglAwal[0];
}

/**
 * Filter pencarian data
 */
$jfilter = "";
if ($filter != "") {
    $jfilter = $filter;
    $filter = explode("|", $filter);
    $filter = "WHERE " . $filter[0] . " like '%" . $filter[1] . "%'";
}

$act = $_REQUEST['act']; // Jenis Aksi

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script language="JavaScript" src="../theme/js/mod.js"></script>
    <!-- Script Pop Up Window -->
    <script language="javascript">
        var win = null;

        function NewWindow(mypage, myname, w, h, scroll) {
            LeftPosition = (screen.width) ? (screen.width - w) / 2 : 0;
            TopPosition = (screen.height) ? (screen.height - h) / 2 : 0;
            settings =
                'height=' + h + ',width=' + w + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=' + scroll + ',resizable'
            win = window.open(mypage, myname, settings)
        }
    </script>

    <!-- Ini untuk tanggal -->
    <script>
        var arrRange = depRange = [];
    </script>
    <!-- Akhir Tanggal -->
</head>

<body>
    <iframe height="72" width="130" name="sort" id="sort" src="../theme/sort.php" scrolling="no" frameborder="0" style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
    </iframe>

    <iframe height="193" width="168" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="0" style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
    </iframe>
    <div class="title">
        Daftar Stok Harian Gudang
    </div>
    <div class="cari">
        <form name="form1" method="post" action="">
            <input type="text" name="tgl" id="tgl" maxlength="10" value="<?= $tglOut ?>" class="txtcenter" readonly>
            <button type="button" name="ButtonTglExpired" class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl,depRange);"> V</button>
            <button type="button" onclick="location='?f=../master/stok_harian_gudang.php&tgl='+tgl.value">
                <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp;
                Lihat</button>

            <input name="act" id="act" type="hidden" value="save">
            <input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
            <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">

    </div>
    <table width="100%" border="0" cellpadding="1" cellspacing="0" style="margin-left: 0; margin-top: 2%">
        <thead>
            <tr class="headtable">
                <th class="tblheader" onClick="ifPop.CallFr(this);">No</th>
                <th id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama Obat</th>
                <!-- <th id="expired" class="tblheader" onClick="ifPop.CallFr(this);">Expired</th> -->
                <!-- <th id="batch" class="tblheader" onClick="ifPop.CallFr(this);">Batch</th> -->
                <th id="STOK_AFTER" class="tblheader" onClick="ifPop.CallFr(this);">Stok Gudang Sebelumnya</th>
                <th id="qty_stok" class="tblheader" onclick="ifPop.CalLFr(this);">Stok Terkini</th>
                <th id="nilai_total" class="tblheader" onClick="ifPop.CallFr(this);">Nilai Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT
                        q.idobat AS obat_id,
                        q.OBAT_NAMA obat,
                        q.NAMA kepemilikan,
                        q.KEPEMILIKAN_ID,
                        SUM( q.unit1 ) AS unit1,
                        q.nilai,
                        SUM( q.ntotal ) AS ntotal,
                        SUM( q.total ) AS total 
                    FROM
                        (
                        SELECT DISTINCT
                            p.idobat,
                            p.OBAT_NAMA,
                            ak.NAMA,
                        IF
                            ( p.KEPEMILIKAN_ID <> ak.ID OR p.KEPEMILIKAN_ID IS NULL, ak.ID, p.KEPEMILIKAN_ID ) AS KEPEMILIKAN_ID,
                        IF
                            ( p.KEPEMILIKAN_ID <> ak.ID OR p.unit1 IS NULL, 0, p.unit1 ) AS unit1,
                        IF
                            ( p.KEPEMILIKAN_ID <> ak.ID OR p.ntotal IS NULL, 0, p.ntotal ) AS ntotal,
                        IF
                            ( p.KEPEMILIKAN_ID <> ak.ID OR p.nilai_total IS NULL, 0, p.nilai_total ) AS nilai,
                        IF
                            ( p.KEPEMILIKAN_ID <> ak.ID OR p.total IS NULL, 0, p.total ) AS total 
                        FROM
                            (
                            SELECT
                                o.OBAT_ID AS idobat,
                                o.OBAT_NAMA,
                                v.*,
                                unit1 AS total 
                            FROM
                                ( SELECT * FROM a_obat WHERE OBAT_ISAKTIF = 1 ) AS o
                                LEFT JOIN vstokhariangudang AS v ON v.obat_id = o.OBAT_ID
                                LEFT JOIN a_kelas AS kls ON o.KLS_ID = kls.KLS_ID 
                            ) AS p
                            LEFT JOIN ( SELECT * FROM a_kepemilikan WHERE aktif = 1 ) ak ON 1 = 1 
                        ) AS q ".$filter."  
                    GROUP BY
                        q.idobat,
                        q.KEPEMILIKAN_ID 
                    ORDER BY
                        OBAT_NAMA,
                        KEPEMILIKAN_ID";
            $total = 0;
            $jumlahData = 0;
            $query = query($konek, $sql);
            $jmldata = mysqli_num_rows($query);
            if ($page == "") $page = "1";
            $perpage = 50;
            $tpage = ($page - 1) * $perpage;
            if (($jmldata % $perpage) > 0) $totpage = floor($jmldata / $perpage) + 1;
            else $totpage = floor($jmldata / $perpage);
            if ($page > 1) $bpage = $page - 1;
            else $bpage = 1;
            if ($page < $totpage) $npage = $page + 1;
            else $npage = $totpage;
            $sql2 = " limit $tpage,$perpage";
            $query = query($konek, $sql . $sql2);
            $no = ($page-1)*$perpage;
            while ($val = fetch($query)) { ?>
                <?php $id_obat = $val['obat_id'] ?>
                <?php $sqlStok = "SELECT
                                        q.idobat AS obat_id,
                                        q.OBAT_NAMA obat,
                                        q.STOK_BEFOR,
                                        q.HARGA_BELI_SATUAN,
                                        ( SELECT EXPIRED FROM a_penerimaan WHERE OBAT_ID = q.idobat ORDER BY ID DESC LIMIT 1 ) AS EXPIRED,
                                        ( SELECT BATCH FROM a_penerimaan WHERE OBAT_ID = q.idobat ORDER BY ID DESC LIMIT 1 ) AS BATCH 
                                    FROM
                                        (
                                        SELECT DISTINCT
                                            p.idobat,
                                            p.OBAT_NAMA,
                                            ak.NAMA,
                                            p.STOK_BEFOR,
                                            p.HARGA_BELI_SATUAN 
                                        FROM
                                            (
                                            SELECT
                                                o.OBAT_ID AS idobat,
                                                o.OBAT_NAMA as obat_nama,
                                                ak.STOK_BEFOR,
                                                ah.HARGA_BELI_SATUAN
                                            FROM
                                                ( SELECT * FROM a_obat WHERE OBAT_ISAKTIF = 1 ) AS o

                                                LEFT JOIN a_kelas AS kls ON o.KLS_ID = kls.KLS_ID
                                                LEFT JOIN a_harga AS ah ON ah.OBAT_ID = o.OBAT_ID
                                                INNER JOIN ( SELECT OBAT_ID, STOK_BEFOR FROM a_kartustok WHERE UNIT_ID = 12 AND TGL_TRANS = '{$tgl}' ORDER BY TGL_ACT ASC ) AS ak ON ak.OBAT_ID = o.OBAT_ID 
                                            ) AS p
                                            JOIN ( SELECT * FROM a_kepemilikan WHERE aktif = 1 ) ak ON 1 = 1 
                                        )  AS q  WHERE q.idobat = {$id_obat}
                                    GROUP BY
                                        q.idobat 
                                    ORDER BY
                                        q.OBAT_NAMA";
                    $stok_terkini = fetch(query($konek, $sqlStok));
                  $nilai=$val['ntotal'];
                                ?>


                <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
                    <td class="tdisi"><?= ++$no ?></td>
                    <td class="tdisi" align="left"><?= $val['obat'] ?></td>
                    <!-- <td class="tdisi"><?php //$val['EXPIRED'] ?></td>
                    <td class="tdisi"><?php //$val['BATCH'] ?></td> -->
                    <td class="tdisi">
                        <?php 
                        if($stok_terkini['STOK_BEFOR'] == '' or $stok_terkini['STOK_BEFOR'] == null){ ?>
                            <a href="../master/kartu_stok_gd.php?obat_id=<?php echo $val['obat_id']; ?>&kepemilikan_id=1&unit_id=12" onClick="NewWindow(this.href,'name','1200','500','yes');return false">
                                <?= $val['unit1'] ?>
                            </a>

                        <?php    
                        }else{
                        ?>
                            <a href="../master/kartu_stok_gd.php?obat_id=<?php echo $val['obat_id']; ?>&kepemilikan_id=1&unit_id=12" onClick="NewWindow(this.href,'name','1200','500','yes');return false">
                                <?= $stok_terkini['STOK_BEFOR'] ?>
                            </a>
                        <?php
                        }
                        ?>
                    </td>
                    <td class="tdisi">
                        <a href="../master/kartu_stok_gd.php?obat_id=<?php echo $val['obat_id']; ?>&kepemilikan_id=1&unit_id=12" onClick="NewWindow(this.href,'name','1200','500','yes');return false">
                            <?= $val['unit1'] ?>
                        </a>
                    </td>
                    <td class="tdisi" align="right"><?= 'Rp. ' . number_format($nilai, 0, ',', '.') ?></td>
                <?php
                    $total += $val['HARGA_BELI_SATUAN'] * $stok_terkini['qty_stok'];
                    ++$jumlahData;
                } 
                $sql2="select if (sum(p2.ntotal) is null,0,sum(p2.ntotal)) as jml_tot from (".$sql.") as p2";
	            //echo $sql2."<br>";
	            $rs=mysqli_query($konek,$sql2);
	            $show=mysqli_fetch_array($rs);
	            $jml_tot=$show['jml_tot'];
                ?>
                
                </tr>
                <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
                    <td class="tdisi" colspan="4">Total</td>
                    <td class="tdisi">
                        <?=
                            'Rp. ' . number_format($jml_tot, 0, ',', '.');
                        ?>
                    </td>
                </tr>
        </tbody>
    </table>
    <div class="but">
        <BUTTON type="button" onClick="OpenWnd('../master/stok_harian_gudang_print.php?user=<?php echo $username; ?>&filter=<?php echo $jfilter; ?>&sorting=<?php echo $sorting; ?>&tgl=<?= $tglOut ?>',1000,800,'childwnd',true);" <?php if ($jmldata == 0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak
            Stok </BUTTON>
        <button type="button" <?php if ($jumlahData == 0) echo "disabled='disabled'"; ?> onClick="OpenWnd('../master/stok_harian_gudang_excell.php?filter=<?php echo $jfilter; ?>&sorting=<?php echo $sorting; ?>&tgl=<?= $tgl ?>',600,450,'childwnd',true);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export
            ke File Excell</button>
    </div>

    <div>
        <div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman
            <?php echo ($totpage == 0 ? "0" : $page); ?> dari <?php echo $totpage; ?></div>
        <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();">
        <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();">
        <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();">
        <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;
        </form>
    </div>
</body>

</html>
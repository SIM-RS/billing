<?php
include("../../sesi.php");
include("../../koneksi/konek.php");
// include
$sqlGetKso = "SELECT id,nama FROM b_ms_kso WHERE aktif = 1";
$query = mysql_query($sqlGetKso);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Tarif Tindakan Kso</title>
    <link type="text/css" rel="stylesheet" href="../../theme/mod.css">
    <script language="JavaScript" src="../../theme/js/dsgrid.js"></script>
    <script language="JavaScript" src="../../theme/js/mod.js"></script>
    <link rel="stylesheet" type="text/css" href="../../theme/tab-view.css" />
    <script type="text/javascript" src="../../theme/js/tab-view.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>

    <!--dibawah ini diperlukan untuk menampilkan popup-->
    <link rel="stylesheet" type="text/css" href="../../theme/popup.css" />
    <script type="text/javascript" src="../../theme/prototype.js"></script>
    <script type="text/javascript" src="../../theme/effects.js"></script>
    <script type="text/javascript" src="../../theme/popup.js"></script>
</head>

<body>
    <div align="center">
        <?php include("../../header1.php"); ?>
        <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
            <tr>
                <td height="30">&nbsp;EXCEL UPDATE TARIF KSO</td>
            </tr>
        </table>
        <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="center">
                    <form method="post" action="getTaripKso.php">
                        <table>
                            <tr>
                                <td>Pilih Kso</td>
                                <td>
                                    <select name="kso" id="kso">
                                        <?php while($rows = mysql_fetch_assoc($query)){ ?>
                                            <option value="<?= $rows['id'] ?>"><?= $rows['nama'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
								<td>Jenis</td>
								<td>
									<select name="select" class="txtinput" id="cmbJnsLayKelMcu" onchange="isiCombo('TmpLayanan',this.value,'','cmbUnitKelMcu')">
										<?php
										$sql="SELECT distinct m.id,m.nama,m.inap FROM b_ms_unit m WHERE level=1 AND kategori=2 AND aktif=1 order by nama";
										$rs=mysql_query($sql);
										while($rw=mysql_fetch_array($rs)){
											?>
											<option value="<?php echo $rw['id'];?>" label="<?php /*echo $rw['inap'];*/?>" title="<?php echo $rw['id'];?>">
												<?php echo $rw['nama'];?>	
											</option>

											<?php
										}
										?>
									</select>
								</td>
                            </tr>
                            <tr>
								<td>
									Tempat
								</td>
								<td>
									<select id="cmbUnitKelMcu" name="cmbUnitKelMcu" class="txtinput" lang=""></select>
								</td>
							</tr>
                            <tr>
                                <td>
                                    <button type="submit">Excel</button>
                                </td>
                            </tr>
                        </table>
                        
                    </form>
                    <div style="height: 500px;"></div>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
<script>
    isiCombo('TmpLayanan',document.getElementById('cmbJnsLayKelMcu').value,'','cmbUnitKelMcu');
    function isiCombo(id,val,defaultId,targetId){
        if(targetId=='' || targetId==undefined){
            targetId=id;
        }
        // alert(targetId);
        //alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET');
        Request('../../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET');
    }
</script>
</body>

</html>
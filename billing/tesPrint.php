<?php
	include("sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/print.css" media="print">
<title>.: Rincian Tagihan Pasien :.</title>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="left" class="kwi">
  <tr>
    <td colspan="2"><b><br/><?=$pemkabRS?><br>
							<?=$namaRS?><br>

							<?=$alamatRS?><br>
							Telepon <?=$tlpRS?><br/></b>&nbsp;</td>
  </tr>
  <tr>
    <!--td height="5" colspan="2" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td-->
    <td height="5" colspan="2"></td>
  </tr>
  <tr class="kwi">

    <!--td height="30" colspan="2" align="center" style="font-weight:bold"><u>&nbsp;Laporan Rincian Tagihan Pasien&nbsp;</u></td-->
    <td height="30" colspan="2" align="center"><u>&nbsp;Laporan Rincian Tagihan Pasien&nbsp;</u></td>
  </tr>
  <tr class="kwi">
    <td colspan="2">
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="11%">No RM</td>

				<!--td width="2%" align="center" style="font-weight:bold">:</td-->
                <td width="2%" align="center" >:</td>
				<td colspan="3">&nbsp;1262700</td>
				<td width="10%">Tgl Mulai</td>
				<!--td width="1%" align="center" style="font-weight:bold">:</td-->
                				<td width="1%" align="center" >:</td>
				<td width="30%">&nbsp;09 November 2010</td>

			</tr>
			<tr>
				<td width="11%">Nama Pasien </td>
				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td colspan="3">&nbsp;ratri suminar y nn</td>
				<td width="10%">Tgl Selesai </td>
				<td width="1%" align="center" style="font-weight:bold">:</td>

				<td width="30%">&nbsp;</td>
			</tr>
			<tr>
				<td width="11%">Alamat</td>
				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td colspan="3">&nbsp;pondok jati q no 52</td>
				<td width="10%">Kelas</td>

				<td width="1%" align="center" style="font-weight:bold">:</td>
				<td width="30%">&nbsp;non kelas</td>
			</tr>
			<tr>
				<td width="11%">&nbsp;</td>
				<td width="2%" align="center" style="font-weight:bold">&nbsp;</td>
				<td width="8%">Kel. / Desa </td>

				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td width="36%">&nbsp;<?=$kotaRS?></td>
				<td width="10%">&nbsp;</td>
				<td width="1%" align="center" style="font-weight:bold">&nbsp;</td>
				<td width="30%"></td>
			</tr>
			<tr>
				<td width="11%">&nbsp;</td>

				<td width="2%" align="center" style="font-weight:bold"></td>
				<td width="8%">RT / RW </td>
				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td width="36%">&nbsp;00 / 00</td>
				<td width="10%">&nbsp;</td>
				<td width="1%" align="center" style="font-weight:bold">&nbsp;</td>
				<td width="30%"></td>

			</tr>
			<tr>
				<td width="11%">Jenis Kelamin </td>
				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td colspan="3">&nbsp;p</td>
				<td width="10%">Status Pasien </td>
				<td width="1%" align="center" style="font-weight:bold">:</td>

				<td width="30%">&nbsp;askes komersial</td>
			</tr>
		</table>	</td>
  </tr>
  <tr class="kwi">
    <td height="30" colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>

				<td align="center" style="border:#000000 solid 1px; font-weight:bold">Tindakan</td>
				<td align="center" style="border:#000000 solid 1px; border-left:none; font-weight:bold">Tanggal</td>
				<td align="center" style="border:#000000 solid 1px; border-left:none; font-weight:bold">Jumlah</td>
				<td align="center" style="border:#000000 solid 1px; border-left:none; font-weight:bold">Biaya</td>
			</tr>
						<tr>
				<td align="left" style="padding-left:25px">P. THT</td>

				<td></td>
				<td></td>
				<td></td>
			</tr>
						<tr>
				<td align="left" style="padding-left:50px">ibnu malik, dr., sptht.</td>
				<td></td>
				<td></td>

				<td></td>
			</tr>
						<tr>
				<td align="left" style="padding-left:85px">r poli spesialis</td>
				<td align="center">&nbsp;09-11-2010</td>
				<td align="center">&nbsp;1</td>
				<td align="right">20.000&nbsp;</td>

			</tr>
									<tr>
				<td align="left" style="padding-left:60px">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px">Sub Total&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px">20.000&nbsp;</td>
			</tr>
						<tr>

				<td align="left" style="padding-left:60px; border-top:#000000 dotted 1px">&nbsp;</td>
				<td align="center" style="border-top:dotted #000000 1px">&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px">Total Biaya&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px">20.000&nbsp;</td>
			</tr>
						<!--tr>
				<td align="left" style="padding-left:60px;">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="right" style="font-weight:bold">Jaminan&nbsp;</td>
				<td align="right" style="font-weight:bold">&nbsp;</td>
			</tr-->
            			<tr>

			  <td height="19" align="left" style="padding-left:60px;">&nbsp;</td>
			  <td align="center">&nbsp;</td>
			  <td align="right" style="font-weight:bold">Dijamin KSO&nbsp;</td>
			  <td align="right" style="font-weight:bold">20.000&nbsp;</td>
		  </tr>
                                  			<tr>
				<td height="19" align="left" style="padding-left:60px;">&nbsp;</td>
				<td align="center">&nbsp;</td>

				<td align="right" style="font-weight:bold">Bayar&nbsp;</td>
				<td align="right" style="font-weight:bold">0&nbsp;</td>
			</tr>
			<tr>
				<td align="left" style="padding-left:60px;" height="2"></td>
				<td align="center"></td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px"></td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px"></td>

			<tr>
				<td align="left" style="padding-left:60px;">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px">Kurang&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px">0&nbsp;</td>
			</tr>
	</table>	</td>

  </tr>
  <tr>
    <td height="5" colspan="2" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr class="kwi">
    <td width="607">&nbsp;</td>

    <td width="293" style="font-weight:bold"><?=$kotaRS?>, 09 November 2010<br/>
    Petugas,<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( HERSYAM MAULANA, S.Kom )</td>
  </tr>
    <tr id="trTombol">
        <td colspan="2" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>

        </td>
    </tr>
</table>
<script type="text/JavaScript">

    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
            if(confirm('Anda Yakin Mau Mencetak Rician Tagihan Pembayaran ?')){
                setTimeout('window.print()','1000');
                setTimeout('window.close()','2000');
            }
            else{
                tombol.style.visibility='visible';
            }

        }
    }
</script>
</body>
</html>
<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUsr'];
$sqlP="SELECT pl.tgl as tgl2, mt.nama as nama_tindakan,p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,p.gol_darah as gol_darah2,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, a.ku as ku2, a.kesadaran as kes2,
a.bb as bb2, a.tensi as tensi2, a.rr as rr2, a.suhu as suhu2, a.nadi as nadi2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_tindakan t ON t.pelayanan_id=pl.id
LEFT JOIN b_ms_tindakan mt ON mt.id=t.id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id


WHERE pl.id='$idPel';";


$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
?>
<?php

$dG=mysql_fetch_array(mysql_query("select * from b_ms_pemakaian_alkes where id='$_REQUEST[id]'"));
?>
<style>
.kotak{
border:1px solid #000000;
width:20px;
height:20px;
vertical-align:middle; 
text-align:center;
}
.style15 {font-size: 12px}
.style16 {
	font-size: 16px;
	font-weight: bold;
}
</style>
<body>
<table width="800" border="0" align="center" style="font:12px tahoma;">
  <tr>
    <td><table width="950" height="891" border="0" style="font:12px tahoma;">
      <tr>
        <td colspan="5" style="font:PEMAKAIAN ALKES DAN OBAT KAMAR BEDAH 



TANGGAL

:

Nama Pasien

: 

TINDAKAN

:

No. RM

: 

DR. OPERATOR 

:





DR. ANASTESI 

:









NO.



NAMA ALKES 



JUMLAH



1

GAMMEX 6/6,5/7/7,5/8 



2

PROFEEL ORTHO 6/6,5/7/7,5/8 



3

PROFEEL LP 6,5/7 



4

TRANSOFIK



5

BETHADINE cc



6

ALKOHOL cc 



7

NEEDLE NO 



8

NETRAL PLATE 



9

BACTIGRAS/SUPRATULE/DARYATULE



10

MERSILK



11

POLISORB 



12

ULTRASOLB



13

SUPRASOB C 



14

BISTURI NO 



15

CHROMIC



16

MONOSYN



17

VICRYL 



18

PLAIN CUT GED 



19

SILKAM 



20

PREMILINE/PROLAINE/SURGIPRO



21

MONOCRYL 



22

PDS 2 



23

SECUREG 



24

KASSA 7,5 X 7,5 



25

KASSA X RAY 10 X 10 



26

KASSA 6 X 6 



27

KASSA LAPARATOMY 



28

UNDER PAD 







NO.



NAMA ALKES 



JUMLAH



29

PEMBALUT WANITA 



30

MASKER GOOGLE



31

TEGADERM 



32

PAPER GREEN 



33

FORMALIN



34

AQUABIDEST 1000cc 



35

ALKAZYM



36

HYPAFIX



37

BAROVAC PS/PP 



38

URINE BAG 



39

FOLEY CATHETER 



40

NGT



41

SYRINGE 



42

CATHETER TIP 



43

GUARDIX SOL 



44

GELITA SPON 



45

WI



46

NaCL



47

POLIGYP



48

POLIYBAN



49

TENSOCREPE/MEDICREPE



50

CONFORMING



51

MICROSHIELD



52

BETADINE



53

FROMALINE



54

CIDEX



55

PRASEPT



56

SUCTION CATHETER 







NO.



NAMA ALKES 



JUMLAH



57

HOGI GOWN 



58

T-SCRUB



59

FACE MASK 



60

MASKER KACA 



61

SURGICAL HAT 



62

SENSI GLOVE 



63

XYLOCAINE GEL / INSTILLAGEL 



64

UROGRAD



65

DISK DVD-ROOM 



66

H2O2



67

BOCAL PA 



68

RL



69

SURGIWEAR PATTIES 



70

BONE WAX 



71

MICROSCOP DRAPE 



72

SURGICEL



73

LINA PEN 



74

EXTERNAL DRAIN 



75

SUCTION CONECTING TUBE 



76

BAG SUCTION DISPOSIBLE 



77

EHITE APRON 











































12px









12px tahoma;"><div align="right" class="style16">PEMAKAIAN ALKES DAN OBAT KAMAR BEDAH </div></td>
      </tr>
      <tr>
        <td colspan="5"  style="font: 12px tahoma;"><table width="508" class="style15" border="0" align="right" cellpadding="4" bordercolor="#000000">
            <tr>
              <td width="124">TANGGAL</td>
              <td width="173">: 
                <?=tglSQL($dP['tgl2']);?></td>
              <td>Nama Pasien</td>
              <td>:
                <?=$dP['nama'];?></td>
            </tr>
            <tr>
              <td>TINDAKAN</td>
              <td>: 
                <?=$dP['nama_tindakan'];?></td>
              <td>No. RM</td>
              <td>:
                <?=$dP['no_rm'];?>
              </td>
            </tr>
            <tr>
              <td>DR. OPERATOR </td>
              <td>: </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>DR. ANASTESI </td>
              <td>:</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="5" style="font:bold 16px tahoma;">&nbsp;</td>
      </tr>
      <tr>
        <td width="303" height="731" valign="top" style="font:12px tahoma;"><table width="312" class="style15" border="1" style="border-collapse:collapse;">
            <tr>
              <td width="21"><div align="center"><strong>NO.</strong></div></td>
              <td width="208"><div align="center"><strong>NAMA ALKES </strong></div></td>
              <td width="61"><div align="center"><strong>JUMLAH</strong></div></td>
            </tr>
            <tr>
              <td><div align="center">1</div></td>
              <td> GAMMEX 6/6,5/7/7,5/8 </td>
              <td><div align="center">
                <?=$dG['gammex'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">2</div></td>
              <td>PROFEEL ORTHO 6/6,5/7/7,5/8 </td>
              <td><div align="center">
                <?=$dG['proffel_or'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">3</div></td>
              <td>PROFEEL LP 6,5/7 </td>
              <td><div align="center">
                <?=$dG['proffel_lp'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">4</div></td>
              <td>TRANSOFIK</td>
              <td><div align="center">
                <?=$dG['transofix'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">5</div></td>
              <td>BETHADINE
                <label>
                  <?=$dG['be'];?>
                  cc</label></td>
              <td><div align="center">
                <?=$dG['bhetadine'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">6</div></td>
              <td>ALKOHOL
                <?=$dG['al'];?>
                cc </td>
              <td><div align="center">
                <?=$dG['alkohol'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">7</div></td>
              <td>NEEDLE NO
                <?=$dG['ne'];?></td>
              <td><div align="center">
                <?=$dG['needle'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">8</div></td>
              <td>NETRAL PLATE </td>
              <td><div align="center">
                <?=$dG['netral'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">9</div></td>
              <td>BACTIGRAS/SUPRATULE/DARYATULE</td>
              <td><div align="center">
                <?=$dG['bactigras'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">10</div></td>
              <td>MERSILK</td>
              <td><div align="center">
                <?=$dG['mersilk'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">11</div></td>
              <td>POLISORB                
                <?=$dG['po'];?></td>
              <td><div align="center">
                <?=$dG['polisorb'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">12</div></td>
              <td>ULTRASOLB</td>
              <td><div align="center">
                <?=$dG['ultra'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">13</div></td>
              <td>SUPRASOB C </td>
              <td><div align="center">
                <?=$dG['supra'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">14</div></td>
              <td>BISTURI NO
                <?=$dG['bi'];?></td>
              <td><div align="center">
                <?=$dG['bisturi'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">15</div></td>
              <td>CHROMIC</td>
              <td><div align="center">
                <?=$dG['chromic'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">16</div></td>
              <td>MONOSYN</td>
              <td><div align="center">
                <?=$dG['monosyn'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">17</div></td>
              <td>VICRYL
                <?=$dG['vi'];?></td>
              <td><div align="center">
                <?=$dG['vircly'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">18</div></td>
              <td>PLAIN CUT GED </td>
              <td><div align="center">
                <?=$dG['plain'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">19</div></td>
              <td>SILKAM
                <?=$dG['si'];?></td>
              <td><div align="center">
                <?=$dG['silkam'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">20</div></td>
              <td>PREMILINE/PROLAINE/SURGIPRO</td>
              <td><div align="center">
                <?=$dG['premil'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">21</div></td>
              <td>MONOCRYL
                <?=$dG['mo'];?></td>
              <td><div align="center">
                <?=$dG['monocryl'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">22</div></td>
              <td>PDS 2
                <?=$dG['pd'];?></td>
              <td><div align="center">
                <?=$dG['pds'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">23</div></td>
              <td>SECUREG
                <?=$dG['se'];?></td>
              <td><div align="center">
                <?=$dG['secureg'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">24</div></td>
              <td>KASSA 7,5 X 7,5 </td>
              <td><div align="center">
                <?=$dG['kassa7'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">25</div></td>
              <td>KASSA X RAY 10 X 10 </td>
              <td><div align="center">
                <?=$dG['kassax'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">26</div></td>
              <td>KASSA 6 X 6 </td>
              <td><div align="center">
                <?=$dG['kassa6'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">27</div></td>
              <td>KASSA LAPARATOMY </td>
              <td><div align="center">
                <?=$dG['kassal'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">28</div></td>
              <td>UNDER PAD </td>
              <td><div align="center">
                <?=$dG['under'];?>
              </div></td>
            </tr>
        </table></td>
        <td width="1" valign="top" style="font:12px tahoma;">&nbsp;</td>
        <td width="309" valign="top" style="font: 12px tahoma;"><table width="309" class="style15" border="1"  style="border-collapse:collapse;">
            <tr>
              <td><div align="center"><strong>NO.</strong></div></td>
              <td><div align="center"><strong>NAMA ALKES </strong></div></td>
              <td><div align="center"><strong>JUMLAH</strong></div></td>
            </tr>
            <tr>
              <td width="27" class="style15"><div align="center">29</div></td>
              <td width="198" class="style15">PEMBALUT WANITA
                <?=$dG['pe'];?></td>
              <td width="62">
                <div align="center">
                  <?=$dG['pembalut'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">30</div></td>
              <td>MASKER GOOGLE</td>
              <td>
                <div align="center">
                  <?=$dG['masker'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">31</div></td>
              <td>TEGADERM
                <?=$dG['te'];?></td>
              <td>
                <div align="center">
                  <?=$dG['tega'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">32</div></td>
              <td>PAPER GREEN </td>
              <td>
                <div align="center">
                  <?=$dG['paper'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">33</div></td>
              <td>FORMALIN</td>
              <td>
                <div align="center">
                  <?=$dG['formalin'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">34</div></td>
              <td>AQUABIDEST 1000cc </td>
              <td>
                <div align="center">
                  <?=$dG['aqua'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">35</div></td>
              <td>ALKAZYM</td>
              <td>
                <div align="center">
                  <?=$dG['alkaz'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">36</div></td>
              <td>HYPAFIX</td>
              <td>
                <div align="center">
                  <?=$dG['hypafix'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">37</div></td>
              <td>BAROVAC PS/PP </td>
              <td>
                <div align="center">
                  <?=$dG['barovac'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">38</div></td>
              <td>URINE BAG </td>
              <td>
                <div align="center">
                  <?=$dG['urine'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">39</div></td>
              <td>FOLEY CATHETER </td>
              <td>
                <div align="center">
                  <?=$dG['foley'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">40</div></td>
              <td>NGT</td>
              <td>
                <div align="center">
                  <?=$dG['ngt'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">41</div></td>
              <td>SYRINGE
                <?=$dG['sy'];?></td>
              <td>
                <div align="center">
                  <?=$dG['syringe'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">42</div></td>
              <td>CATHETER TIP </td>
              <td>
                <div align="center">
                  <?=$dG['cat'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">43</div></td>
              <td>GUARDIX SOL </td>
              <td>
                <div align="center">
                  <?=$dG['gua'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">44</div></td>
              <td>GELITA SPON </td>
              <td>
                <div align="center">
                  <?=$dG['gel'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">45</div></td>
              <td>WI</td>
              <td>
                <div align="center">
                  <?=$dG['wi'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">46</div></td>
              <td>NaCL</td>
              <td>
                <div align="center">
                  <?=$dG['na'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">47</div></td>
              <td>POLIGYP</td>
              <td>
                <div align="center">
                  <?=$dG['poli'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">48</div></td>
              <td>POLIYBAN</td>
              <td>
                <div align="center">
                  <?=$dG['poliy'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">49</div></td>
              <td>TENSOCREPE/MEDICREPE</td>
              <td>
                <div align="center">
                  <?=$dG['tenso'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">50</div></td>
              <td>CONFORMING</td>
              <td>
                <div align="center">
                  <?=$dG['confo'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">51</div></td>
              <td>MICROSHIELD</td>
              <td>
                <div align="center">
                  <?=$dG['micro'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">52</div></td>
              <td>BETADINE</td>
              <td>
                <div align="center">
                  <?=$dG['beta'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">53</div></td>
              <td>FROMALINE</td>
              <td>
                <div align="center">
                  <?=$dG['formal'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">54</div></td>
              <td>CIDEX</td>
              <td>
                <div align="center">
                  <?=$dG['cidex'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">55</div></td>
              <td>PRASEPT</td>
              <td>
                <div align="center">
                  <?=$dG['pra'];?>
                  </div></td>
            </tr>
            <tr>
              <td height="18"><div align="center">56</div></td>
              <td>SUCTION CATHETER </td>
              <td>
                <div align="center">
                  <?=$dG['suction'];?>
                  </div></td>
            </tr>
        </table>
          <p class="style15">&nbsp;</p></td>
        <td width="2" style="font:bold 16px tahoma;">&nbsp;</td>
        <td width="288" valign="top" style="font:12px tahoma;"><table width="288"  class="style15" border="1" style="border-collapse:collapse;">
            <tr>
              <td><div align="center"><strong>NO.</strong></div></td>
              <td><div align="center"><strong>NAMA ALKES </strong></div></td>
              <td><div align="center"><strong>JUMLAH</strong></div></td>
            </tr>
            <tr>
              <td width="27"><div align="center">57</div></td>
              <td width="177">HOGI GOWN </td>
              <td width="62">
                <div align="center">
                  <?=$dG['hogi'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">58</div></td>
              <td>T-SCRUB</td>
              <td>
                <div align="center">
                  <?=$dG['tsc'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">59</div></td>
              <td>FACE MASK </td>
              <td>
                <div align="center">
                  <?=$dG['face'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">60</div></td>
              <td>MASKER KACA </td>
              <td>
                <div align="center">
                  <?=$dG['maskerk'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">61</div></td>
              <td>SURGICAL HAT </td>
              <td>
                <div align="center">
                  <?=$dG['surgical'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">62</div></td>
              <td>SENSI GLOVE </td>
              <td>
                <div align="center">
                  <?=$dG['sensi'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">63</div></td>
              <td>XYLOCAINE GEL / INSTILLAGEL </td>
              <td>
                <div align="center">
                  <?=$dG['xylo'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">64</div></td>
              <td>UROGRAD</td>
              <td>
                <div align="center">
                  <?=$dG['urog'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">65</div></td>
              <td>DISK DVD-ROOM </td>
              <td>
                <div align="center">
                  <?=$dG['disk'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">66</div></td>
              <td>H2O2</td>
              <td>
                <div align="center">
                  <?=$dG['h2o2'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">67</div></td>
              <td>BOCAL PA </td>
              <td>
                <div align="center">
                  <?=$dG['bocal'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">68</div></td>
              <td>RL</td>
              <td>
                <div align="center">
                  <?=$dG['rl'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">69</div></td>
              <td>SURGIWEAR PATTIES </td>
              <td>
                <div align="center">
                  <?=$dG['surgi'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">70</div></td>
              <td>BONE WAX </td>
              <td>
                <div align="center">
                  <?=$dG['bone'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">71</div></td>
              <td>MICROSCOP DRAPE </td>
              <td>
                <div align="center">
                  <?=$dG['micros'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">72</div></td>
              <td>SURGICEL</td>
              <td>
                <div align="center">
                  <?=$dG['surgicel'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">73</div></td>
              <td>LINA PEN </td>
              <td>
                <div align="center">
                  <?=$dG['lina'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">74</div></td>
              <td>EXTERNAL DRAIN </td>
              <td>
                <div align="center">
                  <?=$dG['exter'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">75</div></td>
              <td>SUCTION CONECTING TUBE </td>
              <td>
                <div align="center">
                  <?=$dG['suct'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">76</div></td>
              <td>BAG SUCTION DISPOSIBLE </td>
              <td>
                <div align="center">
                  <?=$dG['bag'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">77</div></td>
              <td>WHITE APRON </td>
              <td>
                <div align="center">
                  <?=$dG['white'];?>
                  </div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><div align="center"></div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><div align="center"></div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><div align="center"></div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><div align="center"></div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><div align="center"></div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><div align="center"></div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><div align="center"></div></td>
            </tr>
        </table></td>
      </tr>

    </table></td>
  </tr>
  <tr id="trTombol">
        <td class="noline" align="center">
                    
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
              <input id="btnTutup" type="button" value="Tutup" onClick="tutup();"/>    </td>
  </tr>
</table>
</body>
<script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Mencetak Fromulir Permintaan Darah ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
			
function tutup(){
	window.close();
	}
        </script>
</html>

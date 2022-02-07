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

$dG=mysql_fetch_array(mysql_query("select * from b_ms_pemakaian_alkes_oa where id='$_REQUEST[id]'"));
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
              <td>FENTANLY / MO / PETHIDINE</td>
              <td><div align="center">
                <?=$dG['fentanyl'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">2</div></td>
              <td>EPHEDRINE</td>
              <td><div align="center">
                <?=$dG['ephedrine'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">3</div></td>
              <td>EPHINEPRINE</td>
              <td><div align="center">
                <?=$dG['ephineprine'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">4</div></td>
              <td>ADONA/KALNEX/VIT K / DYCINON </td>
              <td><div align="center">
                <?=$dG['adona'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">5</div></td>
              <td>INVOMIT / GRANON</td>
              <td><div align="center">
                <?=$dG['invomit'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">6</div></td>
              <td>GASTRIDNE</td>
              <td><div align="center">
                <?=$dG['gastridine'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">7</div></td>
              <td>SA / PROSTIGMINE</td>
              <td><div align="center">
                <?=$dG['sa'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">8</div></td>
              <td>DORMICUN/SEDACUM</td>
              <td><div align="center">
                <?=$dG['dormicun'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">9</div></td>
              <td>MARCAIN HEAVY / BUVANES / DECAIN </td>
              <td><div align="center">
                <?=$dG['marcain'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">10</div></td>
              <td>PROPOFOL / RECOFOL / PRONES </td>
              <td><div align="center">
                <?=$dG['propofol'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">11</div></td>
              <td>CATAPRES</td>
              <td><div align="center">
                <?=$dG['catapres'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">12</div></td>
              <td>KETROBAT 30mg </td>
              <td><div align="center">
                <?=$dG['ketrobat'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">13</div></td>
              <td>ORASIC 100mg </td>
              <td><div align="center">
                <?=$dG['orasic'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">14</div></td>
              <td>FARMADOL</td>
              <td><div align="center">
                <?=$dG['farmadol'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">15</div></td>
              <td>DYNASTAT</td>
              <td><div align="center">
                <?=$dG['dynastat'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">16</div></td>
              <td>PROFENID / TRAMAL SUPP </td>
              <td><div align="center">
                <?=$dG['profeenid'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">17</div></td>
              <td>PARACETAMOL SUPP 125mg</td>
              <td><div align="center">
                <?=$dG['paracetamol'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">18</div></td>
              <td>STESOLID 5/10 </td>
              <td><div align="center">
                <?=$dG['stesolid'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">19</div></td>
              <td>LASIK</td>
              <td><div align="center">
                <?=$dG['lasik'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">20</div></td>
              <td>ROCULAX / TRACIUM / ECRON </td>
              <td><div align="center">
                <?=$dG['roculax'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">21</div></td>
              <td>KALMETHASON 4mg/5mg </td>
              <td><div align="center">
                <?=$dG['kalmetason'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">22</div></td>
              <td>SYNTONICON / METHERGINE </td>
              <td><div align="center">
                <?=$dG['syntonicon'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">23</div></td>
              <td>CITOTEX / GASTRUL </td>
              <td><div align="center">
                <?=$dG['citotex'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">24</div></td>
              <td>ALINAMIN F </td>
              <td><div align="center">
                <?=$dG['alinamin'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">25</div></td>
              <td>DOPAMIN / VASCON </td>
              <td><div align="center">
                <?=$dG['dopamin'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">26</div></td>
              <td>NOKOBA</td>
              <td><div align="center">
                <?=$dG['nokoba'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">27</div></td>
              <td>AMINOPHILLIN</td>
              <td><div align="center">
                <?=$dG['aminophilin'];?>
              </div></td>
            </tr>
            <tr>
              <td><div align="center">28</div></td>
              <td>SEVO / ISOFLURANE </td>
              <td><div align="center">
                <?=$dG['sevo'];?>
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
              <td width="198">O2 / N2O / AIR </td>
              <td width="62">
                <div align="center">
                  <?=$dG['o2'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">30</div></td>
              <td>IV LINE </td>
              <td>
                <div align="center">
                  <?=$dG['iv'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">31</div></td>
              <td>TEGADERM NO                
                <?=$dG['te'];?></td>
              <td>
                <div align="center">
                  <?=$dG['tegaderm'];?>
                </div></td>
            </tr>
            <tr>
              <td><div align="center">32</div></td>
              <td>TRHEEWAY
                
                <?=$dG['tr'];?></td>
              <td>
                <div align="center">
                  <?=$dG['trheeway'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">33</div></td>
              <td>ALKOHOL SWAB </td>
              <td>
                <div align="center">
                  <?=$dG['alkohol'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">34</div></td>
              <td>INFUS SET / BLOOD SET </td>
              <td>
                <div align="center">
                  <?=$dG['infus'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">35</div></td>
              <td>NASAL O2 </td>
              <td>
                <div align="center">
                  <?=$dG['nasal'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">36</div></td>
              <td>SIMPLE MASK </td>
              <td>
                <div align="center">
                  <?=$dG['simple'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">37</div></td>
              <td>NRM / RM </td>
              <td>
                <div align="center">
                  <?=$dG['nrm'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">38</div></td>
              <td>ELEKTRODA ADL / PED </td>
              <td>
                <div align="center">
                  <?=$dG['elektroda'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">39</div></td>
              <td>HANSAPLAST</td>
              <td>
                <div align="center">
                  <?=$dG['hansaplast'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">40</div></td>
              <td>SPINOCANT NO. 24 / NO. 27 </td>
              <td>
                <div align="center">
                  <?=$dG['spinocant'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">41</div></td>
              <td>PENCAN NO. 27 </td>
              <td>
                <div align="center">
                  <?=$dG['pencan'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">42</div></td>
              <td>GELOFUSAL / GELOFUSIN </td>
              <td>
                <div align="center">
                  <?=$dG['gelofusal'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">43</div></td>
              <td>RING AS / RL / D5% / RD </td>
              <td>
                <div align="center">
                  <?=$dG['ring'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">44</div></td>
              <td>NACL 25 / 100 / 500 </td>
              <td>
                <div align="center">
                  <?=$dG['nacl'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">45</div></td>
              <td>FUTROLIT / MANITOL </td>
              <td>
                <div align="center">
                  <?=$dG['futrolit'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">46</div></td>
              <td>HAES 130 / 200 </td>
              <td>
                <div align="center">
                  <?=$dG['haes'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">47</div></td>
              <td>TRIDEX 27A / 27B / PALAIN </td>
              <td>
                <div align="center">
                  <?=$dG['tridex'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">48</div></td>
              <td>EMLA SALEP </td>
              <td>
                <div align="center">
                  <?=$dG['emla'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">49</div></td>
              <td>KATETER TIP 50cc </td>
              <td>
                <div align="center">
                  <?=$dG['kateter'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">50</div></td>
              <td>EXTENSION TUBE 150cm </td>
              <td>
                <div align="center">
                  <?=$dG['extension'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">51</div></td>
              <td>XYLOCAIN JELLY </td>
              <td>
                <div align="center">
                  <?=$dG['xylocain'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">52</div></td>
              <td>NGT NO
                
                <?=$dG['ng'];?></td>
              <td>
                <div align="center">
                  <?=$dG['ngt'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">53</div></td>
              <td>CATH URINE NO
                
                <?=$dG['ca'];?></td>
              <td>
                <div align="center">
                  <?=$dG['cath'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">54</div></td>
              <td>URINE BAG </td>
              <td>
                <div align="center">
                  <?=$dG['urine'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">55</div></td>
              <td>SELANG SUCTION </td>
              <td>
                <div align="center">
                  <?=$dG['selang'];?>
                  </div></td>
            </tr>
            <tr>
              <td height="18"><div align="center">56</div></td>
              <td>CATHETER SUCTION NO
                
                <?=$dG['cat'];?></td>
              <td>
                <div align="center">
                  <?=$dG['catheter'];?>
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
              <td width="177">EET NO :
                <?=$dG['ee'];?></td>
              <td width="62">
                <div align="center">
                  <?=$dG['eetno'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">58</div></td>
              <td>EET NKK NO :
                <?=$dG['eet'];?></td>
              <td>
                <div align="center">
                  <?=$dG['ettnkk'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">59</div></td>
              <td>LMA NO :
                <?=$dG['lm'];?></td>
              <td>
                <div align="center">
                  <?=$dG['lma'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">60</div></td>
              <td>GUEDEL / NPA NO :
                <?=$dG['gu'];?></td>
              <td>
                <div align="center">
                  <?=$dG['guedel'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">61</div></td>
              <td>BACTERI FILTER </td>
              <td>
                <div align="center">
                  <?=$dG['bacteri'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">62</div></td>
              <td>BRETHING CIRCUIT </td>
              <td>
                <div align="center">
                  <?=$dG['brething'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">63</div></td>
              <td>BROADCED / CEFTRIAXONE </td>
              <td>
                <div align="center">
                  <?=$dG['broadced'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">64</div></td>
              <td>FLAGYL DRIPP </td>
              <td>
                <div align="center">
                  <?=$dG['flagyl'];?>
                  </div></td>
            </tr>
            <tr>
              <td><div align="center">65</div></td>
              <td>TEGEXRAM</td>
              <td>
                <div align="center">
                  <?=$dG['taxegram'];?>
                  </div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
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

<?php
include ("../koneksi/konek.php");
$notice="";
$norm=$_REQUEST['norm'];
$idPasien=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$IdUser=$_REQUEST['IdUser'];
$tabel=$_REQUEST['tabel'];
$jnsRwt=$_REQUEST['jnsRwt'];
$note=$_REQUEST['note'];

$id=$_REQUEST['id'];
$tgl = $_REQUEST['tgl'];
$idTind = $_REQUEST['idTind'];
$jml = $_REQUEST['jml'];
$biaya = $_REQUEST['biaya'];
$biayaKso = $_REQUEST['biayaKso'];
$biayaPasien = $_REQUEST['biayaPasien'];
$bayarPasien = $_REQUEST['bayarPasien'];

$unit = $_REQUEST['unit'];
$kamar = $_REQUEST['kamar'];
$kelas = $_REQUEST['kelas'];
$tglIn = $_REQUEST['tglIn'];
$tglOut = $_REQUEST['tglOut'];
$statusOut = $_REQUEST['statusOut'];
$bebanKso = $_REQUEST['bebanKso'];
$bebanPasien = $_REQUEST['bebanPasien'];

$kid=$_REQUEST['kid'];
$pulang=$_REQUEST['pulang'];
$tglSJP=$_REQUEST['tglSJP'];
$tglMsk=$_REQUEST['tglMsk'];
$tglPlg=$_REQUEST['tglPlg'];
$kelas_id=$_REQUEST['kelas_id'];
$baruLama=$_REQUEST['baruLama'];
$kso_id=$_REQUEST['kso_id'];
$kso_kelas_id=$_REQUEST['kso_kelas_id'];

$pid=$_REQUEST['pid'];
$pKsoId=$_REQUEST['pKsoId'];
$pKelasId=$_REQUEST['pKelasId'];
$pTgl=$_REQUEST['pTgl'];
$pTglKRS=$_REQUEST['pTglKRS'];
$dilayani=$_REQUEST['dilayani'];
switch(strtolower($tabel)){
    case 'kunjungan':
        if($_REQUEST['act']=='save'){
            $sqlUpdate="update b_kunjungan set pulang='$pulang',tgl_sjp=".(($tglSJP=='00-00-0000'||$tglSJP=='')?"(NULL)":"'".tglSQL($tglSJP)."'").",tgl=".(($tglMsk=='00-00-0000'||$tglMsk=='')?"(NULL)":"'".tglSQL($tglMsk)."'").",tgl_pulang=".(($tglPlg=='00-00-0000 00:00:00'||$tglPlg=='')?"(NULL)":"'".tglJamSQL($tglPlg)."'").",kelas_id='$kelas_id',isbaru='$baruLama',kso_id='$kso_id',kso_kelas_id='$kso_kelas_id' where id='$kid'";
            mysql_query($sqlUpdate);            
        }
        else if($_REQUEST['act']=='delete'){             
            $sqlDelete="delete from b_kunjungan where id='$kid'";
            //mysql_query($sqlDelete);            
        }
        $sql="SELECT k.id,k.jenis_layanan,n.nama AS jenis,unit_id,u.nama AS unit,u.inap,
                loket_id, i.nama AS loket,tgl,kelas_id,kso_id,kso_kelas_id,tgl_sjp,no_sjp,no_anggota,status_penj,nama_peserta,pulang,tgl_pulang,isbaru,verifikasi FROM b_kunjungan k
                INNER JOIN b_ms_unit u ON k.unit_id=u.id
                INNER JOIN b_ms_unit n ON k.jenis_layanan=n.id
                INNER JOIN b_ms_unit i ON k.loket_id=i.id
                WHERE (k.id)=$idKunj";
        $rs=mysql_query($sql);
        $rw=mysql_fetch_array($rs)
        ?>
        <table width="100%" border="0" style="font-size:12px; font-family:verdana;" class="tepi">
            <tr>
                <td>Jenis Layanan</td><td>:</td><td>&nbsp;<?php echo $rw['jenis'];?></td>
                <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                <td>Loket</td><td>:</td><td>&nbsp;<?php echo $rw['loket'];?></td>
                <td>Pulang</td><td>:</td><td>
                 <select id="cmbKPulang_<?php echo $rw['id'];?>" onchange="simpanKunjungan('<?php echo $rw['id'];?>');">
                    <option value="1" <?php echo ($rw['pulang']==1?'selected':'');?>>SUDAH</option>
                    <option value="0" <?php echo ($rw['pulang']==0?'selected':'');?>>BELUM</option>
                </select>
                </td>
                <td>TGL SJP</td><td>:</td><td>
                <input id="txtKTglSJP_<?php echo $rw['id'];?>" readonly="readonly" size="11" class="tglBox" value="<?php if($rw['tgl_sjp']!=null) echo tglSQL($rw['tgl_sjp']);?>"  onclick="NewCssCal('txtKTglSJP_<?php echo $rw['id'];?>','ddmmyyyy','arrow',false,24,false,
                simpanTgl=function() {
                    simpanKunjungan('<?php echo $rw['id'];?>');
                });"/> 
                </td>                
            </tr>
            <tr>
                <td>Tempat Layanan</td><td>:</td><td>&nbsp;<?php echo $rw['unit'];?></td>
                <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                <td>Tgl Masuk</td><td>:</td><td>
                 <!--input id="txtKTgl_<?php echo $rw['id'];?>" readonly="readonly" size="11" class="tglBox" value="<?php if($rw['tgl']!=null) echo tglSQL($rw['tgl']);?>"  onclick="NewCssCal('txtKTgl_<?php echo $rw['id'];?>','ddmmyyyy','arrow',false,24,false,
                simpanTgl=function() {
                    simpanKunjungan('<?php echo $rw['id'];?>');
                });"/--> 
                 <input id="txtKTgl_<?php echo $rw['id'];?>" readonly="readonly" size="11" class="tglBox" value="<?php if($rw['tgl']!=null) echo tglSQL($rw['tgl']);?>" /> 
                </td>
                <td>Tgl Pulang</td><td>:</td><td>
                <input id="txtKTglPlg_<?php echo $rw['id'];?>" readonly="readonly" size="20" class="tglBox" value="<?php if($rw['tgl_pulang']!=null) echo tglJamSQL($rw['tgl_pulang']);?>"  onclick="NewCssCal('txtKTglPlg_<?php echo $rw['id'];?>','ddmmyyyy','dropdown',true,24,false,
                simpanTgl=function() {
                    simpanKunjungan('<?php echo $rw['id'];?>');
                });"/>
                </td>
                <td>No SJP</td><td>:</td><td>&nbsp;<?php echo $rw['no_sjp'];?></td>
                <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                
            </tr>
            <tr>
                <td>Kelas</td><td>:</td><td>
                    <input type="hidden" id="txtKUnitId_<?php echo $rw['id'];?>" value="<?php echo $rw['unit_id'];?>"/>
                    <input type="hidden" id="txtKJenisId_<?php echo $rw['id'];?>" value="<?php echo $rw['jenis'];?>"/>
                    <input type="hidden" id="txtKKelasId_<?php echo $rw['id'];?>" value="<?php echo $rw['kelas_id'];?>"/>
                    <input type="hidden" id="txtKInap_<?php echo $rw['id'];?>" value="<?php echo $rw['inap'];?>"/>
                    <select id="cmbKKelas_<?php echo $rw['id'];?>" name="cmbKKelas_<?php echo $rw['id'];?>" onchange="simpanKunjungan('<?php echo $rw['id'];?>',this.value);"></select> 
                </td>
                <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                <td>Baru/Lama</td><td>:</td><td>
                <select id="cmbKBaruLama_<?php echo $rw['id'];?>" onchange="simpanKunjungan('<?php echo $rw['id'];?>');">
                    <option value="1" <?php echo ($rw['isbaru']==1?'selected':'');?>>BARU</option>
                    <option value="0" <?php echo ($rw['isbaru']==0?'selected':'');?>>LAMA</option>
                </select>                
                </td>                
                <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                <td>No Anggota</td><td>:</td><td>&nbsp;<?php echo $rw['no_anggota'];?></td>
                <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                
            </tr>
            <tr>
                <td>KSO</td><td>:</td><td  colspan="4">
                    <select id="cmbKKSO_<?php echo $rw['id'];?>" onchange="simpanKunjungan('<?php echo $rw['id'];?>')" disabled="disabled">
                        <?php
                        $sqlKKSO="SELECT id,nama FROM b_ms_kso WHERE aktif = 1 ORDER BY nama";
                        $rsKKSO=mysql_query($sqlKKSO);
                        while($rwKKSO=mysql_fetch_array($rsKKSO)){
                            ?>
                            <option value="<?php echo $rwKKSO['id'];?>" <?php echo ($rwKKSO['id']==$rw['kso_id']?'selected':'');?>><?php echo $rwKKSO['nama'];?></option>
                            <?php
                        }
                        
                        ?>
                    </select>
                </td>
                <td>Kelas KSO</td><td>:</td><td>
                <input id="txtKKelasKSO_<?php echo $rw['id'];?>" type="hidden" value="<?php echo $rw['kso_kelas_id'];?>"/>
                <select id="cmbKKelasKSO_<?php echo $rw['id'];?>" onchange="simpanKunjungan('<?php echo $rw['id'];?>')" disabled="disabled"></select>
                </td>
                <td>Status KSO</td><td>:</td><td>&nbsp;<?php echo $rw['status_penj'];?></td>
                <td>Nama Peserta</td><td>:</td><td colspan="4">&nbsp;<?php echo $rw['nama_peserta'];?></td>                
            </tr>
        <?php
        break;
    case 'pelayanan':
        if($_REQUEST['act']=='save'){
            $sqlUpdate="update b_pelayanan set kso_id='$pKsoId',kelas_id='$pKelasId',tgl=".(($pTgl=='00-00-0000'||$pTgl=='')?"(NULL)":"'".tglSQL($pTgl)."'").",tgl_krs=".(($pTglKRS=='00-00-0000'||$pTglKRS=='')?"(NULL)":"'".tglSQL($pTglKRS)."'").",dilayani='$dilayani' where id='$pid'";
            if(mysql_query($sqlUpdate)){ 
                $notice='Simpan Berhasil!';
            }
            else{
                $notice='Simpan Gagal!';
            }   
        }
        else if($_REQUEST['act']=='delete'){
			$sqldTind="SELECT * FROM b_tindakan WHERE pelayanan_id='$pid'";
			$rsdTind=mysql_query($sqldTind);
			if (mysql_num_rows($rsdTind)>0){
				$notice='Data Pelayanan Tdk Boleh Dihapus Karena Sudah Ada Data Tindakan !';
			}else{
				$sqlDelete="delete from b_pelayanan where id='$pid'";
				mysql_query($sqlDelete);
				$sqlUpdate=str_replace("'","''",$sqlDelete);
				$sql="INSERT INTO b_log_act(action,query,tgl_act,user_act) VALUES('Menghapus Data Pelayanan','$sqlUpdate',now(),'$IdUser')";
				mysql_query($sql);
			}
        }
        if($jnsRwt=='0'){
             $cek="SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
            WHERE b_pelayanan.kunjungan_id='$idKunj' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1";
            $rsCek=mysql_query($cek);
            if(mysql_num_rows($rsCek)>0){
                $sql="SELECT l.id,l.jenis_layanan,n.nama AS jenis,l.unit_id,u.nama AS unit,u.inap,l.unit_id_asal,m.nama AS asal,
                l.kso_id,l.kelas_id,l.tgl,l.tgl_krs,l.dilayani,l.dokter_id,l.no_lab,l.verifikasi,l.verifikator
                FROM b_pelayanan l
                INNER JOIN b_ms_unit u ON u.id=l.unit_id
                INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
                INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
                WHERE ( m.parent_id <> 44 AND n.inap = 0 
                AND l.unit_id IN( SELECT mu.id FROM b_ms_unit mu
                WHERE mu.inap = 0 AND mu.parent_id <> 44) AND l.kunjungan_id='$idKunj')
                AND l.id<(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
                WHERE b_pelayanan.kunjungan_id='$idKunj' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1)";
            }
            else{
                 $sql="SELECT l.id,l.jenis_layanan,n.nama AS jenis,l.unit_id,u.nama AS unit,u.inap,l.unit_id_asal,m.nama AS asal,
                l.kso_id,l.kelas_id,l.tgl,l.tgl_krs,l.dilayani,l.dokter_id,l.no_lab,l.verifikasi,l.verifikator
                FROM b_pelayanan l
                INNER JOIN b_ms_unit u ON u.id=l.unit_id
                INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
                INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
                WHERE ( m.parent_id <> 44 AND n.inap = 0 
                AND l.unit_id IN( SELECT mu.id FROM b_ms_unit mu
                WHERE mu.inap = 0 AND mu.parent_id <> 44) AND l.kunjungan_id='$idKunj')";
            }
        }
        else if($jnsRwt=='1'){
            $sql="SELECT l.id,l.jenis_layanan,n.nama AS jenis,l.unit_id,u.nama AS unit,u.inap,l.unit_id_asal,m.nama AS asal,
            l.kso_id,l.kelas_id,l.tgl,l.tgl_krs,l.dilayani,l.dokter_id,l.no_lab,l.verifikasi,l.verifikator
            FROM b_pelayanan l
            INNER JOIN b_ms_unit u ON u.id=l.unit_id
            INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
            INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
            WHERE l.kunjungan_id='$idKunj' 
            AND l.id>=(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
            WHERE b_pelayanan.kunjungan_id='$idKunj' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1)";
        }
        else if($jnsRwt=='2'){
            $sql="SELECT l.id,l.jenis_layanan,n.nama AS jenis,l.unit_id,u.nama AS unit,u.inap,l.unit_id_asal,m.nama AS asal,
            l.kso_id,l.kelas_id,l.tgl,l.tgl_krs,l.dilayani,l.dokter_id,l.no_lab,l.verifikasi,l.verifikator
            FROM b_pelayanan l
            INNER JOIN b_ms_unit u ON u.id=l.unit_id
            INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
            INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
            WHERE ( m.parent_id = 44 AND n.inap = 0 
            AND l.unit_id NOT IN( SELECT mu.id FROM b_ms_unit mu WHERE mu.inap = 1)
            OR l.unit_id IN (SELECT u.id FROM b_ms_unit u WHERE u.inap=0 AND u.parent_id = 44)) AND l.kunjungan_id='$idKunj'";
        }
        //echo $sql;        
        $rs=mysql_query($sql);
        //echo "<br>".mysql_error();
        ?>
        <table id="tblPelayanan" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size:12px; font-family:verdana;" class="tepi">        
        <?php
        $no=1;
        while($rw=mysql_fetch_array($rs)){
            ?>
            <tr>
                <input type="hidden" id="txtPId_<?php echo $no;?>" value="<?php echo $rw['id'];?>"/>
                <td id="pno_<?php echo $rw['id'];?>" align="center" class="tepi" width="2%"><?php echo $no;$no++?></td>
                <td id="pJenis_<?php echo $rw['id'];?>" align="center" class="tepi" width="5%"><?php echo $rw['jenis'];?></td>
                <td id="pUnit_<?php echo $rw['id'];?>" align="center" class="tepi" width="5%"><?php echo $rw['unit'];?></td>
                <td id="pAsal_<?php echo $rw['id'];?>" align="center" class="tepi" width="5%"><?php echo $rw['asal'];?></td>
                <td id="pKSO_<?php echo $rw['id'];?>" align="left" class="tepi" width="10%">
                <select id="cmbPKSO_<?php echo $rw['id'];?>" onchange="simpanPelayanan('<?php echo $rw['id'];?>')" disabled="disabled">
                        <?php
                        $sqlKKSO="SELECT id,nama FROM b_ms_kso WHERE aktif = 1 ORDER BY nama";
                        $rsKKSO=mysql_query($sqlKKSO);
                        while($rwKKSO=mysql_fetch_array($rsKKSO)){
                            ?>
                            <option value="<?php echo $rwKKSO['id'];?>" <?php echo ($rwKKSO['id']==$rw['kso_id']?'selected':'');?>><?php echo $rwKKSO['nama'];?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td id="pKelas_<?php echo $rw['id'];?>" align="left" class="tepi" width="10%">
                    <input type="hidden" id="txtPUnitId_<?php echo $rw['id'];?>" value="<?php echo $rw['unit_id'];?>"/>
                    <input type="hidden" id="txtPJenisId_<?php echo $rw['id'];?>" value="<?php echo $rw['jenis_layanan'];?>"/>
                    <input type="hidden" id="txtPKelasId_<?php echo $rw['id'];?>" value="<?php echo $rw['kelas_id'];?>"/>
                    <input type="hidden" id="txtPInap_<?php echo $rw['id'];?>" value="<?php echo $rw['inap'];?>"/>
                    <select id="cmbPKelas_<?php echo $rw['id'];?>" name="cmbPKelas_<?php echo $rw['id'];?>" onchange="simpanPelayanan('<?php echo $rw['id'];?>',this.value);"></select>                    
                </td>
                </td>
                <td id="pTgl_<?php echo $rw['id'];?>" align="left" class="tepi" width="5%">
                <!--input id="txtPTgl_<?php echo $rw['id'];?>" readonly="readonly" size="11" class="tglBox" value="<?php if($rw['tgl']!=null) echo tglSQL($rw['tgl']);?>"  onclick="NewCssCal('txtPTgl_<?php echo $rw['id'];?>','ddmmyyyy','arrow',false,24,false,
                simpanTgl=function() {
                    simpanPelayanan('<?php echo $rw['id'];?>');
                });"/-->
                <input id="txtPTgl_<?php echo $rw['id'];?>" readonly="readonly" size="11" class="tglBox" value="<?php if($rw['tgl']!=null) echo tglSQL($rw['tgl']);?>" />
                </td>
                <td id="pTglPlg_<?php echo $rw['id'];?>" align="left" class="tepi" width="5%">
                <input id="txtPTglPlg_<?php echo $rw['id'];?>" readonly="readonly" size="11" class="tglBox" value="<?php if($rw['tgl_krs']!=null) echo tglJamSQL($rw['tgl_krs']);?>"  onclick="NewCssCal('txtPTglPlg_<?php echo $rw['id'];?>','ddmmyyyy','dropdown',true,24,false,
                simpanTgl=function() {
                    simpanPelayanan('<?php echo $rw['id'];?>');
                });"/>
                </td>
                <td id="pDilayani_<?php echo $rw['id'];?>" align="left" class="tepi" width="5%">
                 <select id="cmbPDilayani_<?php echo $rw['id'];?>" onchange="simpanPelayanan('<?php echo $rw['id'];?>');">
                    <option value="0" <?php echo ($rw['dilayani']==0?'selected':'');?>>BELUM</option>
                    <option value="1" <?php echo ($rw['dilayani']==1?'selected':'');?>>SUDAH</option>
                    <option value="2" <?php echo ($rw['dilayani']==2?'selected':'');?>>PINDAH/KELUAR</option>
                </select>       
                </td>
                <td align="center" class="tepi" width="5%">
                    <img style="height:20px; width:20px; cursor:pointer;" src="../icon/del.gif" onclick="hapusPelayanan('<?php echo $rw['id'];?>');"/>
                </td>
            </tr>
            <?php
        }
        ?>
        <input type="hidden" id="txtPjml" value="<?php echo $no;?>"/>
        </table>
        <?php
        break;
    case 'tindakan':
		$fUser="";
		if ($IdUser!="") $fUser=",user_act='$IdUser'";
        if($_REQUEST['act']=='save'){
            echo $sqlUpdate="update b_tindakan set ms_tindakan_kelas_id='$idTind',tgl='".tglSQL($tgl)."',qty='$jml',biaya='$biaya',biaya_kso='$biayaKso',biaya_pasien='$biayaPasien',bayar='".$jml*$bayarPasien."',bayar_pasien='$bayarPasien'".$fUser." where id='$id'";
			//echo $sqlUpdate."<br>";
            if(mysql_query($sqlUpdate)){
                $notice='Simpan Berhasil!';
				$sqlUpdate=str_replace("'","''",$sqlUpdate);
				$sql="INSERT INTO b_log_act(action,query,tgl_act,user_act) VALUES('Mengubah Data Tindakan','$sqlUpdate',now(),'$IdUser')";
				mysql_query($sql);
            }
            else{
                $notice='Simpan Gagal!';
            }
        }
        else if($_REQUEST['act']=='delete'){             
            $sql="SELECT t.kunjungan_id,t.pelayanan_id,mu.nama unit,mt.nama,t.biaya,t.biaya_kso,t.biaya_pasien 
FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id 
INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE t.id='$id'";
            $rs=mysql_query($sql);
			$rw=mysql_fetch_array($rs);
			$cket="kunjungan_id=".$rw["kunjungan_id"].",pelayanan_id=".$rw["pelayanan_id"].",unit=".$rw["unit"].",tindakan=".$rw["nama"].",biaya=".$rw["biaya"].",biaya_kso=".$rw["biaya_kso"].",biaya_pasien=".$rw["biaya_pasien"];
            $sqlDelete="delete from b_tindakan where id='$id'";
            if(mysql_query($sqlDelete)){
                $notice='Hapus Berhasil!';
				$sqlDelete.=";ket -> ".$cket;
				$sqlDelete=str_replace("'","''",$sqlDelete);
				$sql="INSERT INTO b_log_act(action,query,tgl_act,user_act) VALUES('Menghapus Data Tindakan','$sqlDelete',now(),'$IdUser')";
				mysql_query($sql);
            }
            else{
                $notice='Hapus Gagal!';
            }           
        }        
        if($jnsRwt=='0'){
            $cek="SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
            WHERE b_pelayanan.kunjungan_id='$idKunj' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1";
            $rsCek=mysql_query($cek);
            if(mysql_num_rows($rsCek)>0){
                $sql="SELECT t.id,t.ms_tindakan_kelas_id,t.pelayanan_id,m.nama AS jenis ,
                l.unit_id,u.parent_id,u.nama AS unit,t.tgl,mt.nama AS tindakan,
                tk.ms_kelas_id,mk.nama AS kelas,t.qty AS jumlah, t.biaya,t.biaya_kso,t.biaya_pasien,t.bayar_pasien,t.verifikasi 
                FROM b_tindakan t 
                INNER JOIN b_kunjungan k ON k.id=t.kunjungan_id 
                INNER JOIN b_pelayanan l ON t.pelayanan_id = l.id 
                LEFT JOIN b_ms_unit n ON l.unit_id_asal = n.id 
                LEFT JOIN b_ms_unit u ON u.id=l.unit_id
                LEFT JOIN b_ms_unit m ON m.id=u.parent_id
                INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t.ms_tindakan_kelas_id 
                INNER JOIN b_ms_tindakan mt ON mt.id=tk.ms_tindakan_id 
                INNER JOIN b_ms_kelas mk ON mk.id=tk.ms_kelas_id 
                WHERE ( n.parent_id <> 44 AND n.inap = 0
                AND l.unit_id IN( SELECT mu.id FROM b_ms_unit mu
                WHERE mu.inap = 0 AND mu.parent_id <> 44) AND k.id='$idKunj') AND
                l.id<(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
                WHERE b_pelayanan.kunjungan_id='$idKunj' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1) ORDER BY mt.nama,t.id";
            }
            else{
                $sql="SELECT t.id,t.ms_tindakan_kelas_id,t.pelayanan_id,m.nama AS jenis ,
                l.unit_id,u.parent_id,u.nama AS unit,t.tgl,mt.nama AS tindakan,
                tk.ms_kelas_id,mk.nama AS kelas,t.qty AS jumlah, t.biaya,t.biaya_kso,t.biaya_pasien,t.bayar_pasien,t.verifikasi 
                FROM b_tindakan t 
                INNER JOIN b_kunjungan k ON k.id=t.kunjungan_id 
                INNER JOIN b_pelayanan l ON t.pelayanan_id = l.id 
                LEFT JOIN b_ms_unit n ON l.unit_id_asal = n.id 
                LEFT JOIN b_ms_unit u ON u.id=l.unit_id
                LEFT JOIN b_ms_unit m ON m.id=u.parent_id
                INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t.ms_tindakan_kelas_id 
                INNER JOIN b_ms_tindakan mt ON mt.id=tk.ms_tindakan_id 
                INNER JOIN b_ms_kelas mk ON mk.id=tk.ms_kelas_id 
                WHERE ( n.parent_id <> 44 AND n.inap = 0
                AND l.unit_id IN( SELECT mu.id FROM b_ms_unit mu
                WHERE mu.inap = 0 AND mu.parent_id <> 44) AND k.id='$idKunj')";
            }
        }
        elseif($jnsRwt=='1'){
            $sql="SELECT t.id,t.ms_tindakan_kelas_id,t.pelayanan_id,n.nama AS jenis ,
            p.unit_id,mu.parent_id,mu.nama AS unit,t.tgl,mt.nama AS tindakan,
            tk.ms_kelas_id,mk.nama AS kelas,t.qty AS jumlah, t.biaya,t.biaya_kso,t.biaya_pasien,t.bayar_pasien,t.verifikasi
            FROM b_pelayanan p 
            INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
            INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
            LEFT JOIN b_ms_unit n ON n.id=mu.parent_id
            INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t.ms_tindakan_kelas_id
            INNER JOIN b_ms_tindakan mt ON mt.id = tk.ms_tindakan_id
            INNER JOIN b_ms_kelas mk ON mk.id=tk.ms_kelas_id 
            WHERE p.kunjungan_id='$idKunj' 
            AND p.id>=(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
            WHERE b_pelayanan.kunjungan_id='$idKunj' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1) ORDER BY mt.nama,t.id";
        }
        elseif($jnsRwt=='2'){
            $sql="SELECT t.id,t.ms_tindakan_kelas_id,t.pelayanan_id,m.nama AS jenis ,
            p.unit_id,mu.parent_id,mu.nama AS unit,t.tgl,mt.nama AS tindakan,
            tk.ms_kelas_id,mk.nama AS kelas,t.qty AS jumlah, t.biaya,t.biaya_kso,t.biaya_pasien,t.bayar_pasien,t.verifikasi
            FROM b_tindakan t 
            INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
            INNER JOIN b_ms_unit mu ON p.unit_id_asal=mu.id
            INNER JOIN b_ms_unit n ON p.unit_id=n.id
            LEFT JOIN b_ms_unit m ON m.id=n.parent_id
            INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t.ms_tindakan_kelas_id 
            INNER JOIN b_ms_tindakan mt ON mt.id=tk.ms_tindakan_id 
            INNER JOIN b_ms_kelas mk ON mk.id=tk.ms_kelas_id 
            WHERE (mu.parent_id = 44 AND mu.inap = 0 
            AND p.unit_id NOT IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=1) 
            OR p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 AND u.parent_id = 44)) AND p.kunjungan_id='$idKunj'";
        }
        //echo $sql;
        $rs=mysql_query($sql);
        $jmlT=mysql_num_rows($rs);
        ?>
        <input type="hidden" id="txtJmlT" name="txtJmlT" value="<?php echo $jmlT;?>"/>
        <table id="tblTindakan" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size:12px; font-family:verdana;" class="tepi">
                                   
        
        <?php
        $no=1;
        while($rw=mysql_fetch_array($rs)){            
            ?>
            <tr id="<?php echo $rw['id'];?>">
                <td id="no_<?php echo $rw['id'];?>" align="center" class="isi" width="3%"  onmouseover="this.style.backgroundColor='#fed981';" onmouseout="this.style.backgroundColor='';"><?php echo $no;$no++?></td>
                <td id="jenis_<?php echo $rw['id'];?>" align="center" style="font-size:8px;" class="isi" width="7%"><?php echo $rw['jenis'];?></td>
                <td id="unit_<?php echo $rw['id'];?>" align="center"  style="font-size:8px;" class="isi" width="9%">
                    <input type="hidden" id="txtUnitId_<?php echo $rw['id'];?>" value="<?php echo $rw['unit_id'];?>"/>
                    <input type="hidden" id="txtJnsUnitId_<?php echo $rw['id'];?>" value="<?php echo $rw['parent_id'];?>"/>
                    <input type="hidden" id="txtPelId_<?php echo $rw['id'];?>" value="<?php echo $rw['pelayanan_id'];?>"/>
                    
                    <?php echo $rw['unit'];?>
                </td>
                <td id="tgl_<?php echo $rw['id'];?>" align="center" class="isi" width="8%">
                 <input id="txtTgl_<?php echo $rw['id'];?>" readonly="readonly" size="11" class="tglBox" value="<?php echo tglSQL($rw['tgl']);?>"  onclick="NewCssCal('txtTgl_<?php echo $rw['id'];?>','ddmmyyyy','arrow',false,24,false,
                simpanTgl=function() {
                    simpan('<?php echo $rw['id'];?>');
                });"/>
                 <!--input id="txtTgl_<?php echo $rw['id'];?>" size="11" class="tglBox" value="<?php echo tglSQL($rw['tgl']);?>" /-->    
                </td>
                <td id="tind_<?php echo $rw['id'];?>" align="left" class="isi" width="22%">
                    <input type="hidden" id="txtIdTind_<?php echo $rw['id'];?>" value="<?php echo $rw['ms_tindakan_kelas_id'];?>"/>
                    <input type="text" id="txtTind_<?php echo $rw['id'];?>" title="<?php echo $rw['tindakan'];?>" value="<?php echo $rw['tindakan'];?>" class="tindBok" readonly="readonly" ondblclick="aktif(this);" onblur="pasif(this);" onkeyup="aksi(event,this);"/>
                    <div id="divtindakan" style="position:absolute;"></div>
                </td>
                <td id="kelas_<?php echo $rw['id'];?>" align="left" class="isi" width="7%">
                    <input type="hidden" id="txtIdKelas_<?php echo $rw['id'];?>" value="<?php echo $rw['ms_kelas_id'];?>"/>
                   <input type="text" size="10" id="txtKelas_<?php echo $rw['id'];?>" readonly="readonly" value="<?php echo $rw['kelas'];?>" style="text-align:center;font-size:9px;"/>
                </td>
                <td id="jml_<?php echo $rw['id'];?>" align="center" class="isi" width="6%"><input type="text" size="2" id="txtJml_<?php echo $rw['id'];?>" title="<?php echo $rw['jumlah'];?>" value="<?php echo $rw['jumlah'];?>" style="text-align:center;" readonly="readonly" ondblclick="aktif(this);" onblur="pasif(this);" onkeyup="aksi(event,this);"/>
                
                </td>
                <td id="biaya_<?php echo $rw['id'];?>" align="right" class="isi" width="7%"><input type="text" id="txtBiaya_<?php echo $rw['id'];?>" value="<?php echo $rw['biaya'];?>" title="<?php echo $rw['biaya'];?>" style="text-align:right;" size="7" readonly="readonly"/></td>
                <td id="biayaKso_<?php echo $rw['id'];?>" align="right" class="isi" width="7%"><input type="text" id="txtBiayaKso_<?php echo $rw['id'];?>" value="<?php echo $rw['biaya_kso'];?>" title="<?php echo $rw['biaya_kso'];?>" style="text-align:right;" size="7"  readonly="readonly" ondblclick="aktif(this);" onblur="pasif(this);" onkeyup="aksi(event,this);"/></td>
                <td id="biayaPasien_<?php echo $rw['id'];?>" align="right" class="isi" width="7%"><input type="text" id="txtBiayaPasien_<?php echo $rw['id'];?>" value="<?php echo $rw['biaya_pasien'];?>" title="<?php echo $rw['biaya_pasien'];?>" style="text-align:right;"  size="7"  readonly="readonly" ondblclick="aktif(this);" onblur="pasif(this);" onkeyup="aksi(event,this);"/></td>
                <td id="bayarPasien_<?php echo $rw['id'];?>" align="right" class="isi" width="7%"><input type="text" id="txtBayarPasien_<?php echo $rw['id'];?>" value="<?php echo $rw['bayar_pasien'];?>" title="<?php echo $rw['bayar_pasien'];?>" style="text-align:right;"  size="7"  readonly="readonly" ondblclick="aktif(this);" onblur="pasif(this);" onkeyup="aksi(event,this);" /></td>
                <td align="center" class="isi" width="3%">
                    <input type="checkbox" id="chkVer_<?php echo $rw['id'];?>" onclick="if(this.checked){this.value='1';}else{this.value='0';} verifikasi('<?php echo $rw['id'];?>',this.value,'')" <?php echo ($rw['verifikasi']=='1')?"checked":"";?>/>
                </td>
                <td align="center" class="isi" width="4%">
                    <img style="height:20px; width:20px; cursor:pointer;" src="../icon/del.gif" onclick="hapus('tindakan','<?php echo $rw['id'];?>');"/>
                </td>
                
            </tr>         
            <?php
        }
        ?>
        </table>
        <?php
        mysql_free_result($rs);
        break;
    case 'tindakan_kamar':
        if($_REQUEST['act']=='save_kamar'){
            $sqlKmr="SELECT mk.nama,kt.tarip,mk.kode FROM b_ms_kamar mk INNER JOIN b_ms_kamar_tarip kt ON mk.id = kt.kamar_id
                WHERE kt.unit_id = '".$unit."' AND mk.aktif = 1 AND kt.kelas_id = '".$kelas."' AND kt.kamar_id='$kamar'";
            $rsKmr=mysql_query($sqlKmr);
            $rwKmr=mysql_fetch_array($rsKmr);
            $sql="update b_tindakan_kamar set kamar_id='$kamar',kode='".$rwKmr['kode']."',nama='".$rwKmr['nama']."',tarip='".$rwKmr['tarip']."', kelas_id='$kelas', tgl_in=".(($tglIn=='00-00-0000 00:00:00'||$tglIn=='')?"(NULL)":"'".tglJamSQL($tglIn)."'").",tgl_out=".(($tglOut=='00-00-0000 00:00:00'||$tglOut=='')?"(NULL)":"'".tglJamSQL($tglOut)."'").",beban_kso='$bebanKso',beban_pasien='$bebanPasien',status_out='$statusOut' where id='$id'";
            mysql_query($sql);           
			if (mysql_errno()==0){
				$sqlUpdate=str_replace("'","''",$sql);
				$sql="INSERT INTO b_log_act(action,query,tgl_act,user_act) VALUES('Mengubah Data Kamar','$sqlUpdate',now(),'$IdUser')";
				mysql_query($sql);
			}
        } else if($_REQUEST['act']=='delete_kamar'){            
            $sql="select * from b_tindakan_kamar where id='$id'";
            $rs=mysql_query($sql);
			$rw=mysql_fetch_array($rs);
			$cket="pelayanan_id=".$rw["pelayanan_id"].",unit_id_asal=".$rw["unit_id_asal"].",tgl_in='".$rw["tgl_in"]."',tgl_out='".$rw["tgl_out"]."',kamar_id=".$rw["kamar_id"].",kode=".$rw["kode"].",nama=".$rw["nama"].",tarip=".$rw["tarip"].",beban_kso=".$rw["beban_kso"].",beban_pasien=".$rw["beban_pasien"];
            $sql="delete from b_tindakan_kamar where id='$id'";
            mysql_query($sql);
			if (mysql_errno()==0){
				$sql.=";ket -> ".$cket;
				$sqlUpdate=str_replace("'","''",$sql);
				$sql="INSERT INTO b_log_act(action,query,tgl_act,user_act) VALUES('Menghapus Data Kamar','$sqlUpdate',now(),'$IdUser')";
				mysql_query($sql);
			}
        }else if($_REQUEST['act']=='tambah_kamar'){
            $pelayanan=explode("|",$_REQUEST['pelayanan']);
            $kamar = $_REQUEST['tkKamar'];
            $tarip = $_REQUEST['tarip'];
            $bayar = $_REQUEST['bayar'];
            $bayarPasien = $_REQUEST['bayarpasien'];
            
            $sqlKmr="SELECT kode,nama FROM b_ms_kamar WHERE id='$kamar'";
            $rsKmr=mysql_query($sqlKmr);
            $rwKmr=mysql_fetch_array($rsKmr);
            
            $insert="insert into b_tindakan_kamar (pelayanan_id,unit_id_asal,tgl_in,kamar_id,kode,nama,tarip,beban_kso,beban_pasien,kelas_id,bayar,bayar_pasien,lunas)
            values ('".$pelayanan[0]."','".$pelayanan[2]."','".$pelayanan[3]."','".$kamar."','".$rwKmr['kode']."','".$rwKmr['nama']."','".$tarip."',".($pelayanan[5]!='1'?$tarip:'0').",".($pelayanan[5]=='1'?$tarip:'0').",".$pelayanan[4].",".$bayar.",".$bayarPasien.",".($bayar<=$bayarPasien?'1':'0').") ";
            mysql_query($insert);
			if (mysql_errno()==0){
				$sqlUpdate=str_replace("'","''",$insert);
				$sql="INSERT INTO b_log_act(action,query,tgl_act,user_act) VALUES('Menambah Data Kamar','$sqlUpdate',now(),'$IdUser')";
				mysql_query($sql);
			}
        }
        $sql="SELECT tk.id,n.nama AS jenis,p.unit_id,mu.nama AS unit,mkls.nama AS kelas,tk.kelas_id,tk.kamar_id,mk.nama AS kamar ,mk.nama,tk.tgl_in,tk.tgl_out,
tk.tarip,tk.beban_kso,tk.beban_pasien,tk.status_out,tk.verifikasi
FROM b_pelayanan p 
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
LEFT JOIN b_ms_unit n ON n.id=mu.parent_id
LEFT JOIN b_ms_kamar mk ON mk.id=tk.kamar_id
LEFT JOIN b_ms_kelas mkls ON tk.kelas_id=mkls.id
WHERE p.kunjungan_id='$idKunj' 
AND p.id>=(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
WHERE b_pelayanan.kunjungan_id='$idKunj' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1) ORDER BY tk.id";
        $rs=mysql_query($sql);
        $jmlTK=mysql_num_rows($rs);
        ?>
        <input type="hidden" id="txtJmlTK" name="txtJmlTK" value="<?php echo $jmlTK;?>"/>
        <table id="tblTindakanKamar" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size:12px; font-family:verdana;" class="tepi">
           
        <?php
        $no=1;
        while($rw=mysql_fetch_array($rs)){
			$cDisAbled="";
			if ($pTglSkrg>tglSQL(tglSQL($rw['tgl_in']))){
				$cDisAbled=$DisableBD;
			}
            ?>
            <tr id="<?php echo $rw['id'];?>">
                <td id="no_<?php echo $rw['id'];?>" align="center" class="isi" width="2%"><?php echo $no;$no++?></td>
                <td id="jenis_<?php echo $rw['id'];?>" align="center" style="font-size:8px;" class="isi" width="10%"><?php echo $rw['jenis'];?></td>
                <td id="unit_<?php echo $rw['id'];?>" align="center" style="font-size:8px;" class="isi" width="12%">
                <input type="hidden" readonly="readonly" id="txtUnit_<?php echo $rw['id'];?>" name="txtUnit_<?php echo $rw['id'];?>" value="<?php echo $rw['unit_id'];?>"/>
                <?php echo $rw['unit'];?>
                </td>
                <td id="kamar_<?php echo $rw['id'];?>" align="center" style="font-size:8px;" class="isi" width="16%">
                    <select id="cmbKamar_<?php echo $rw['id'];?>" name="cmbKamar_<?php echo $rw['id'];?>" onchange="simpanKamar('<?php echo $rw['id'];?>');">
                        <?php
                    $sqlKamar="SELECT DISTINCT mk.id,mk.nama,kt.tarip AS lang FROM b_ms_kamar mk INNER JOIN b_ms_kamar_tarip kt ON mk.id = kt.kamar_id
                WHERE mk.unit_id = '".$rw['unit_id']."' AND mk.aktif = 1 AND kt.kelas_id = '".$rw['kelas_id']."'";
                $rsKamar=mysql_query($sqlKamar);
                while($rwKamar=mysql_fetch_array($rsKamar)){
                    ?>
                    <option value="<?php echo $rwKamar['id'];?>" <?php if($rwKamar['id']==$rw['kamar_id']) echo 'selected';?>><?php echo $rwKamar['nama'];?></option>
                    <?php
                }
                        ?>
                    </select>                    
                    
                </td>
                <td id="kelas_<?php echo $rw['id'];?>" align="center" style="font-size:8px;" class="isi" width="7%">
                <select id="cmbKelas_<?php echo $rw['id'];?>" name="cmbKelas_<?php echo $rw['id'];?>" <?php echo $cDisAbled; ?> onchange="simpanKelasKamar('<?php echo $rw['id'];?>',this.value);">
                    <?php
                    $sqlKelas="SELECT DISTINCT mk.id,mk.nama,kt.tarip FROM b_ms_kamar_tarip kt INNER JOIN b_ms_kelas mk ON kt.kelas_id = mk.id
                    INNER JOIN b_ms_kamar k ON kt.kamar_id=k.id WHERE k.unit_id = '".$rw['unit_id']."' ORDER BY mk.nama";
                    $rsKelas=mysql_query($sqlKelas);
                    while($rwKelas=mysql_fetch_array($rsKelas)){
                        ?>
                        <option value="<?php echo $rwKelas['id'];?>" <?php if($rwKelas['id']==$rw['kelas_id']) echo 'selected';?>><?php echo $rwKelas['nama'];?></option>
                        <?php
                    }
                    ?>
                </select>              
                </td>
                <td id="tglIn_<?php echo $rw['id'];?>" align="center" class="isi" width="9%">
                <!--input size="16" id="txtTglIn_<?php echo $rw['id'];?>" title="dobel klik untuk ubah" value="<?php echo tglJamSQL($rw['tgl_in']);?>" style="cursor:pointer;" ondblclick="NewCssCal('txtTglIn_<?php echo $rw['id'];?>','ddmmyyyy','dropdown',true,24,false,simpanTglIn=function() {
                    simpanKamar('<?php echo $rw['id'];?>');
                })"/-->                
                <input size="16" id="txtTglIn_<?php echo $rw['id'];?>" title="dobel klik untuk ubah" readonly="readonly" value="<?php echo tglJamSQL($rw['tgl_in']);?>" style="cursor:pointer;" ondblclick="NewCssCal('txtTglIn_<?php echo $rw['id'];?>','ddmmyyyy','dropdown',true,24,false,simpanTglIn=function() {
                    simpanKamar('<?php echo $rw['id'];?>');
                })" />                
                </td>
                <td id="tglOut_<?php echo $rw['id'];?>" align="center" class="isi" width="9%">
                <input size="16" id="txtTglOut_<?php echo $rw['id'];?>" title="dobel klik untuk ubah" readonly="readonly" value="<?php if($rw['tgl_out']!=null) echo tglJamSQL($rw['tgl_out']);?>" style="cursor:pointer;" ondblclick="NewCssCal('txtTglOut_<?php echo $rw['id'];?>','ddmmyyyy','dropdown',true,24,false,simpanTglOut=function() {
                    simpanKamar('<?php echo $rw['id'];?>');
                })"/>                
                </td>
                <td id="statusOut_<?php echo $rw['id'];?>" align="center" class="isi" width="6%">
                    <select id="cmbStatusOut_<?php echo $rw['id'];?>" title="pilih untuk ubah" onchange="simpanKamar('<?php echo $rw['id'];?>');">
                        <option value="0" <?php if($rw['status_out']=='0') echo 'selected';?>>Pulang</option>
                        <option value="1" <?php if($rw['status_out']=='1') echo 'selected';?>>Pindah</option>
                    </select>
                </td>
                <td id="tarip_<?php echo $rw['id'];?>" align="right" class="isi" width="6%"><?php echo $rw['tarip'];?></td>
                <td id="bebanKso_<?php echo $rw['id'];?>" align="right" class="isi" width="6%"><input type="text" id="txtBebanKso_<?php echo $rw['id'];?>" value="<?php echo $rw['beban_kso'];?>" title="<?php echo $rw['beban_kso'];?>" style="text-align:right;" size="7"  class="tindBox" readonly="readonly" ondblclick="aktif(this);" onblur="pasif(this);" onkeyup="aksi(event,this);"/></td>
                <td id="bebanPasien_<?php echo $rw['id'];?>" align="right" class="isi" width="6%"><input type="text" id="txtBebanPasien_<?php echo $rw['id'];?>" value="<?php echo $rw['beban_pasien'];?>" title="<?php echo $rw['beban_pasien'];?>" style="text-align:right;" size="7"  class="tindBox" readonly="readonly" ondblclick="aktif(this);" onblur="pasif(this);" onkeyup="aksi(event,this);"/></td>
                <td id="ver_<?php echo $rw['id'];?>" align="center" class="tepi" width="3%">
                    <input type="checkbox" id="chkVerKamar_<?php echo $rw['id'];?>" onclick="if(this.checked){this.value='1';}else{this.value='0';} verifikasi('<?php echo $rw['id'];?>',this.value,'yes')" <?php echo ($rw['verifikasi']=='1')?"checked":"";?>/>
                </td>                
                <td align="center" class="isi" width="4%">
                    <img style="height:20px; width:20px; cursor:pointer;" src="../icon/del.gif" onclick="hapus('tindakan_kamar','<?php echo $rw['id'];?>');"/>
                </td>
            </tr>         
            <?php
        }
        ?>
        </table>
        <?php
        mysql_free_result($rs);
        break;
    
   
    case 'catatan':
        $sqlNote="select note from b_catatan where kunjungan_id='$idKunj' and jenis_rawat='$jnsRwt'";
        $rsNote=mysql_query($sqlNote);
        $rwNote=mysql_fetch_array($rsNote);
        echo $rwNote['note'];
        break;
    case 'save_catatan':
        $sqlNote="select note from b_catatan where kunjungan_id='$idKunj' and jenis_rawat='$jnsRwt'";
        $rsNote=mysql_query($sqlNote);
        if(mysql_num_rows($rsNote)>0){
            $sql="update b_catatan set note='$note' where kunjungan_id='$idKunj' and jenis_rawat='$jnsRwt'";
        }else{
            $sql="insert into b_catatan (kunjungan_id,jenis_rawat,note) value ('$idKunj','$jnsRwt','$note') ";
        }        
        mysql_query($sql);        
        if(mysql_affected_rows()>0){
            echo 'simpan catatan berhasil';
        }else{
            echo 'simpan catatan gagal!';
        }      
        break;
   
     
}
mysql_close($konek);
?>
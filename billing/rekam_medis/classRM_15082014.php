<?php
	class rekam_medis{
		protected $idKunj = NULL;
		protected $idPel = NULL;
		
		public function __construct($kunjId, $pelId){
			$this->idKunj = $kunjId;
			$this->idPel = $pelId;
		}
		
		public function cekdiagnosa($id_kunj,$id_pel){
			//return $this->idKunj.' - '.$this->idPel;
			$sqlDiag="SELECT
						COUNT(CASE WHEN t1.icdrm <> '-' THEN t1.icdrm END) AS jml
					FROM (SELECT 
						IFNULL(
						  (SELECT 
							mdrm.kode 
						  FROM
							b_diagnosa_rm drm 
							INNER JOIN b_ms_diagnosa mdrm 
							  ON drm.ms_diagnosa_id = mdrm.id 
						  WHERE drm.diagnosa_id = d.diagnosa_id),
						  '-'
						) icdrm
					  FROM
						b_diagnosa d 
						LEFT JOIN b_ms_diagnosa md 
						  ON md.id = d.ms_diagnosa_id 
						INNER JOIN b_pelayanan pl 
						  ON pl.id = d.pelayanan_id 
						INNER JOIN b_ms_pegawai p 
						  ON p.id = d.user_id 
						INNER JOIN b_ms_unit mu 
						  ON pl.unit_id = mu.id 
					  WHERE d.kunjungan_id = '".$id_kunj."' AND d.pelayanan_id = '".$id_pel."') AS t1";
				$qDiag = mysql_query($sqlDiag);
				$Diag = mysql_fetch_array($qDiag);
				return $Diag['jml'];
				//return $sqlDiag."<br/><br/>";
		}
		public function cektindakan($id_pel){
			$sqlTind="SELECT
						COUNT(CASE WHEN t1.icd9cm <> '-' THEN t1.icd9cm END) AS jml
					FROM (SELECT 
					  IFNULL(
						(SELECT 
						  kode_icd_9cm 
						FROM
						  b_tindakan_icd9cm 
						WHERE b_tindakan_id = t.id),
						'-'
					  ) icd9cm 
					FROM
					  b_tindakan t 
					  INNER JOIN b_pelayanan pl 
						ON pl.id = t.pelayanan_id 
					  INNER JOIN b_ms_tindakan_kelas tk 
						ON tk.id = t.ms_tindakan_kelas_id 
					  INNER JOIN b_ms_kelas k 
						ON tk.ms_kelas_id = k.id 
					  INNER JOIN b_ms_tindakan tin 
						ON tin.id = tk.ms_tindakan_id 
					  LEFT JOIN b_ms_pegawai p 
						ON p.id = t.user_id 
					  LEFT JOIN b_ms_pegawai peg 
						ON peg.id = t.user_act 
					WHERE t.pelayanan_id = '".$id_pel."') t1";
			$qTind = mysql_query($sqlTind);
			$Tind = mysql_fetch_array($qTind);
			return $Tind['jml'];
			//return $sql."<br/><br/>";
		}
		public function setAnam($pasId){
			$sAnam = "select count(id) jml from b_cetak_anamnesa_log where pasien_id = {$pasId}";
			$Anam = mysql_fetch_array(mysql_query($sAnam));
			return $Anam['jml'];
		}
		
		public function setKunj(){
			$sqlKunj = "SELECT
					pl.id
					FROM b_pelayanan pl
					INNER JOIN b_ms_unit mu ON mu.id=pl.unit_id
					INNER JOIN b_ms_unit ma ON ma.id=pl.unit_id_asal
					LEFT JOIN b_ms_pegawai pg ON pg.id=pl.dokter_tujuan_id
					WHERE pl.kunjungan_id='".$this->idKunj."'";
			$qKunj = mysql_query($sqlKunj);
			$jmlKunj = mysql_num_rows($qKunj);
			$diag = $tind = '';
			$terset = 0;
			$warna = "#000";
			while($kunj = mysql_fetch_array($qKunj)){
				$diag = $this->cekdiagnosa($this->idKunj,$kunj['id']);
				$tind = $this->cektindakan($kunj['id']);
				if($diag > 0 || $tind > 0){
					$terset += 1;
				}
			}
			if($jmlKunj > $terset && $terset <> 0){
				$warna = "red";
			} else if ($jmlKunj == $terset){
				$warna = "blue";
			}
			
			return $warna;
			//return $this->idKunj.' - '.$this->idPel;
		}
		
		public function setWarna(){
			$warna = "black";
			$diag = $this->cekdiagnosa($this->idKunj,$this->idPel);
			$tind = $this->cektindakan($this->idPel);
			if($diag > 0 || $tind > 0){
				$warna = 'blue';
			}
			return $warna;
		}
	}
?>
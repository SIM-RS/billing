SELECT 
  pel.pasien_id id,
  pas.nama nama,
  IF(pel.cito = 0, 'biasa', 'cito') AS STATUS,
  tind.tindakan_lab_id,
  /* kel.id, */
  @a := IF(kel.parent_id <> 0,
  (SELECT kl.nama_kelompok
	FROM b_ms_kelompok_lab kl
	WHERE kl.id = kel.parent_id), kel.nama_kelompok
  ) parent1,
  IF(@a <> kel.nama_kelompok,kel.nama_kelompok,'') parent,
  /* kel.parent_id id_parent2,*/
  GROUP_CONCAT(periksa.nama) child,
  tind.status stat 
FROM
  b_pelayanan pel 
  INNER JOIN b_ms_pasien pas 
    ON pas.id = pel.pasien_id 
  INNER JOIN b_kunjungan kun 
    ON pel.kunjungan_id = kun.id 
  INNER JOIN b_tindakan_lab tind 
    ON tind.pelayanan_id = pel.id 
  LEFT JOIN b_ms_pemeriksaan_lab periksa 
    ON periksa.id = tind.pemeriksaan_id 
  INNER JOIN b_ms_kelompok_lab kel 
    ON kel.id = periksa.kelompok_lab_id 
WHERE pel.id = '104' 
  AND kun.id = '2' 
  AND tind.status = 0
GROUP BY kel.id, kel.parent_id
ORDER BY parent1, kel.parent_id;
SELECT * FROM b_kunjungan WHERE id = 38726; /* ~ sudah -> ubah id pasien ~ */
SELECT * FROM b_ms_pasien WHERE id = 19296;
SELECT * FROM b_pelayanan WHERE kunjungan_id = 38726; /* ~ sudah ~ */
SELECT * FROM anamnese WHERE pel_id IN (SELECT GROUP_CONCAT(id SEPARATOR ',') AS id_pelayanan FROM b_pelayanan WHERE kunjungan_id = 38726);  /* ~ sudah ~ */
SELECT * FROM b_resep WHERE kunjungan_id = 38726; /* ~ sudah ~ */
SELECT * FROM b_hasil_lab;
SELECT * FROM b_diagnosa;
SELECT * FROM b_tindakan;

SELECT * FROM a_penjualan WHERE NO_KUNJUNGAN = 76286; /* ~ ubdah no pasien ~ */


SELECT GROUP_CONCAT(id SEPARATOR ',') AS id_pelayanan FROM b_pelayanan WHERE kunjungan_id = 36783;
SELECT * FROM b_ms_unit WHERE id = 3;

36783,36963,38726;
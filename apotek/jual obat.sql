

select TGL,TGL_ACT,NO_PASIEN,NO_KUNJUNGAN,OBAT_NAMA,QTY,HARGA_SATUAN,SUM_SUB_TOTAL,DOKTER,RUANGAN
from a_penjualan,a_penerimaan, a_obat
where PENERIMAAN_ID=a_penerimaan .ID and
a_penerimaan.OBAT_ID=a_obat.OBAT_ID and unit_id=3
order by TGL desc
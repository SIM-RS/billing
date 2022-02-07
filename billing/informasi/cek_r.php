<?
include '../koneksi/konek.php';
$sql = "select * from (select k.id, date_format(k.tgl_act,'%d-%m-%Y %H:%i:%s') as tgl, p.no_rm, p.nama, p.alamat, u.nama as poli, kso.nama as status, if(k.status_medik=1,true,false) as status_medik, pg.nama as pgw
                        from b_kunjungan k
                        inner join b_ms_pasien p on k.pasien_id = p.id
                        inner join b_ms_unit u on k.unit_id = u.id
                        inner join b_ms_kso kso on k.kso_id = kso.id
                        inner join b_ms_pegawai pg on k.user_act = pg.id
                        where k.tgl = CURDATE() and k.isbaru=0 and k.sprint=0 AND k.unit_id NOT IN(59,61)) t1 order by tgl,nama";
$query = mysql_query($sql);
$jml = mysql_num_rows($query);
if($jml > 0)
{
	?>
	<script>
		window.open("sm_report1.php");
	</script>
    <?
}
?>
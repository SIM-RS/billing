<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$tgl=tglSQL(addslashes($_REQUEST['tgl']));
	$dokter=addslashes($_REQUEST['dokter']);
	$jenis_operasi=addslashes($_REQUEST['jenis_operasi']);
	$a=addslashes($_REQUEST['a']);
	$b=addslashes($_REQUEST['b']);
	$c=addslashes($_REQUEST['c']);
	$d=addslashes($_REQUEST['d']);
	$e=addslashes($_REQUEST['e']);
	$f=addslashes($_REQUEST['f']);
	$g=addslashes($_REQUEST['g']);
	$h=addslashes($_REQUEST['h']);
	$i=addslashes($_REQUEST['i']);
	$j=addslashes($_REQUEST['j']);
	$k=addslashes($_REQUEST['k']);
	$l=addslashes($_REQUEST['l']);
	$m=addslashes($_REQUEST['m']);
	$n=addslashes($_REQUEST['n']);
	$o=addslashes($_REQUEST['o']);
	$p=addslashes($_REQUEST['p']);
	$q=addslashes($_REQUEST['q']);
	$r=addslashes($_REQUEST['r']);
	$s=addslashes($_REQUEST['s']);
	$t=addslashes($_REQUEST['t']);
	$u=addslashes($_REQUEST['u']);
	$v=addslashes($_REQUEST['v']);
	$w=addslashes($_REQUEST['w']);
	$x=addslashes($_REQUEST['x']);
	$y=addslashes($_REQUEST['y']);
	$z=addslashes($_REQUEST['z']);
	$aa=addslashes($_REQUEST['aa']);
	$bb=addslashes($_REQUEST['bb']);
	$cc=addslashes($_REQUEST['cc']);
	$dd=addslashes($_REQUEST['dd']);
	$ee=addslashes($_REQUEST['ee']);
	$ff=addslashes($_REQUEST['ff']);
	$gg=addslashes($_REQUEST['gg']);
	$hh=addslashes($_REQUEST['hh']);
	$ii=addslashes($_REQUEST['ii']);
	$jj=addslashes($_REQUEST['jj']);
	$idUsr=$_REQUEST['idUsr'];
	/*$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=3;$i++){
		$pilihan.=$c_chk[$i].',';
		}*/
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_ms_pemakain_obat (
				pelayanan_id,
				tgl,
				dokter,
				jenis_operasi,
				a,
				b,
				c,
				d,
				e,
				f,
				g,
				h,
				i,
				j,
				k,
				l,
				m,
				n,
				o,
				p,
				q,
				r,
				s,
				t,
				u,
				v,
				w,
				x,
				y,
				z,
				aa,
				bb,
				cc,
				dd,
				ee,
				ff,
				gg,
				hh,
				ii,
				jj,
				tgl_act,
				user_act) 
				VALUES(
				'$idPel',
				'$tgl',
				'$dokter',
				'$jenis_operasi',
				'$a',
				'$b',
				'$c',
				'$d',
				'$e',
				'$f',
				'$g',
				'$h',
				'$i',
				'$j',
				'$k',
				'$l',
				'$m',
				'$n',
				'$o',
				'$p',
				'$q',
				'$r',
				'$s',
				'$t',
				'$u',
				'$v',
				'$w',
				'$x',
				'$y',
				'$z',
				'$aa',
				'$bb',
				'$cc',
				'$dd',
				'$ee',
				'$ff',
				'$gg',
				'$hh',
				'$ii',
				'$jj',	
				CURDATE(),
  				'$idUsr') ;";
		$ex=mysql_query($sql);
		//echo $sql;
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_ms_pemakain_obat SET pelayanan_id='$idPel',
		tgl='$tgl',
		dokter='$dokter',
		jenis_operasi='$jenis_operasi',
		a='$a',
		b='$b',
		c='$c',
		d='$d',
		e='$e',
		f='$f',
		g='$g',
		h='$h',
		i='$i',
		j='$j',
		k='$k',
		l='$l',
		m='$m',
		n='$n',
		o='$o',
		p='$p',
		q='$q',
		r='$r',
		s='$s',
		t='$t',
		u='$u',
		v='$v',
		w='$w',
		x='$x',
		y='$y',
		z='$z',
		aa='$aa',
		bb='$bb',
		cc='$cc',
		dd='$dd',
		ee='$ee',
		ff='$ff',
		gg='$gg',
		hh='$hh',
		ii='$ii',
		jj='$jj',
		tgl_act=CURDATE(),
		user_act='$idUsr' WHERE id='".$_REQUEST['id']."'";
		//echo $sql;
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo mysql_error();
				echo "Data gagal disimpan !";
				}
	break;
	case 'hapus':
		$sql="DELETE FROM b_ms_pemakain_obat WHERE id='".$_REQUEST['id']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>
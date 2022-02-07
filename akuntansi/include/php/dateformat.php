<?php
class DateFormat {
    function format($date, $format){
		$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
		$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$date = strtotime($date);
		switch($format){
			case 1:
				$res = $hari[date('w',$date)].', '.date('d',$date).' '.$bulan[date('n',$date)].' '.date('Y',$date);
				break;
			case 2:
				$res = date('d',$date).' '.$bulan[date('n',$date)].' '.date('Y',$date);
				break;
			case 3:
				$res = date('d',$date).' '.$bulan[date('n',$date)].' '.date('Y',$date)." ".date('H:i:s',$date);
				break;
			case 4:
				$res = $bulan[date('n',$date)].' '.date('Y',$date);
				break;
			default:
				$res = date("d-m-Y", $date);
		}
		return $res;
    }
	
	function defformat($date){
		$date = explode('-',$date);
		if(count($date)==3)
			return $date[2].'-'.$date[1].'-'.$date[0];
		else
			return '0000-00-00';
	}
	
    function day($i){
            $hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
            return $hari[$i];
    }

    function month($i){
        $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        return $bulan[$i];
    }

    function combo_month($id){
        $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        $combo = '<select id="'.$id.'" name="'.$id.'">';
        for($i=1;$i<=12;$i++){
            $combo .= '<option value="'.$i.'">'.$bulan[$i].'</option>';
        }
        $combo .= '</select>';
        return $combo;
    }

    function datediff($d1, $d2){
		$d1 = (is_string($d1) ? strtotime($d1) : $d1);
		$d2 = (is_string($d2) ? strtotime($d2) : $d2);
		$diff_secs = abs($d1 - $d2);
		$base_year = min(date("Y", $d1), date("Y", $d2));
		$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
		return array( "years" => date("Y", $diff) - $base_year,  "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,  "months" => date("n", $diff) - 1,  "days_total" => floor($diff_secs / (3600 * 24)),  "days" => date("j", $diff) - 1,  "hours_total" => floor($diff_secs / 3600),  "hours" => date("G", $diff),  "minutes_total" => floor($diff_secs / 60),  "minutes" => (int) date("i", $diff),  "seconds_total" => $diff_secs,  "seconds" => (int) date("s", $diff)  );
    }
}
?>
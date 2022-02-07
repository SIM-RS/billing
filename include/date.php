<?php

class date {
    function getStrBulan(){
        return $bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli"
            ,"Agustus","September","Oktober","November","Desember");
    }

    // from 'd-m-Y' to 'Y-m-d' and also from 'Y-m-d' to 'd-m-Y'
    function changeFormatDate($strDate){
        $dates = explode("-",$strDate);
        return $dates[2]."-".$dates[1]."-".$dates[0];
    }

    // format = 'd-m-Y' / 'Y-m-d'
    function getDateNow($format){
        return gmdate($format,mktime(date('H')+7));
    }

    function getMonthNow(){
        return gmdate('n',mktime(date('H')+7));
    }

    function getYearNow(){
        return gmdate('Y',mktime(date('H')+7));
    }

    function setComboBulan($idcombo, $idselected){
        $bulan = $this->getStrBulan();
        $htmlCombo = "<select name='".$idcombo."' id='".$idcombo."'>";
        for($i=0; $i<sizeof($bulan); $i++){
            $strSelected = "";
            if($idselected == $i+1) $strSelected = "selected";
            $htmlCombo .= "<option value='".($i+1)."' $strSelected>".$bulan[$i]."</option>";
        }
        $htmlCombo .= "</select>";
        return $htmlCombo;
    }

    function setComboTahun($idcombo, $thnSkr){
        $htmlCombo .= "<select name='".$idcombo."' id='".$idcombo."'>";
        for($i=$thnSkr-5; $i<$thnSkr+5; $i++){
            $strSelected = "";
            if($i == $thnSkr) $strSelected = "selected";
            $htmlCombo .= "<option value='".$i."' $strSelected>".$i."</option>";
        }
        $htmlCombo .= "</select>";
        return $htmlCombo;
    }
}
?>

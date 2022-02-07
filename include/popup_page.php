<?php
//require_once 'include/date.php';
class popup_page {
    // function to create popup pages ^_^
    /* struktur data array yang menjadi parameter :
     * $array(
     *      $array_content(
     *          jenis(text/bln/thn/tgl/combo/radio/textarea), label, nama/id,
     *          ukuran, isi(kalau combo/checkbox/radio), next(new_line/one_line)
     *      )
     * )
     */
    function createPopupPage($title,$target,$namepage,$element,$width = 450){
        $cdate = new date();
        $html = "<div id='popup_$namepage' class='popup' style='display:none;font-family:Arial, Helvetica, sans-serif;'>";
        $html .= "<div style='float:right; cursor:pointer' class='popup_closebox'>
            <img src='images/cancel.gif' height='16' width='16' align='absmiddle'/>Tutup</div>
            <h3 style='margin-bottom:5px;'>$title</h3>";
        $html .= "<form id='form_$namepage' method='post' action='laporan/r_$namepage.php' target='$target'>
        <div style='float:left'>            
            <table width='$width' border='0' cellpadding='3' cellspacing='1' class='tblbody'
            style='border:solid 1px #669999;background-color:#D3EFBA;font-size:12px;font-weight:bold;'>";

        $before = "";
        for($itr=0; $itr<sizeof($element); $itr++){
            $type = $element[$itr][0]; $label = $element[$itr][1];
            $name = $element[$itr][2]; $size = $element[$itr][3]; $next = $element[$itr][6];
            if($size == 0) $size = "100";
            if($type == "combo" || $type == "radio" || $type == "checkbox"){
                $content = $element[$itr][4];
                $idcontent = $element[$itr][5];
            }

            if($before == "one_line"){
                if($type != "radio" && $type != "checkbox")
                    $html .= "$label&nbsp;&nbsp;";
            }
            else
                $html .= "<tr valign='top'><td width='120'><b>".$label."</b></td><td>:</td><td>";

            if($type == "text"){
                $html .= "<input type='text' title='text' name='".$name."' id='$name' style='width:$size;height:25px;' />";
            }
            else if($type == "bln"){
                $html .= $cdate->setComboBulan($name, $cdate->getMonthNow());
            }
            else if($type == "thn"){
                $html .= $cdate->setComboTahun($name, $cdate->getYearNow());
            }
            else if($type == "combo"){
                $html .= "<select title='text' name='".$name."' id='$name' />";
                for($k=0; $k<=sizeof($content); $k++){
                    $html .= "<option value='".$idcontent[$k]."'>$content[$k]</option>";
                }
                $html .= "</select>";
            }
            else if($type == "tgl"){
                $html .= "<input type='text' title='tgl' class='txtcenter' maxlength='15' name='".$name."'
            id='$name' readonly='true' size='15' value='".$cdate->getDateNow("d-m-Y")."' style='height:25px;' />
                <input type='button' name='Button' value=' .. ' class='btnenabled tombol' onClick='gfPop.fPopCalendar(this.form.$name,depRange)'/>";
            }
            else if($type == "checkbox"){
                if(empty($content))
                    $html .= "<input type='checkbox' name='$name' id='$name'> $label";
                else{
                    for($z=0; $z<sizeof($content); $z++){
                        $html .= "<input type='checkbox' name='".$idcontent[$z]."' id='".$idcontent[$z]."'> $content[$z] <br>";
                    }
                }
            }
            else if($type == "textarea"){
                $html .= "<textarea id='".$name."' title='text' name='".$name."' cols='30'></textarea>";
            }

            if($next == "one_line")
                $html .= "&nbsp;&nbsp;&nbsp;";
            else
                $html .= "</td></tr>";

            $before = $next;
        }

        $html .= "<tr><td colspan='2'></td>
            <td>
              <input type='submit' id='btnSimpan$namepage' value='Tampilkan' onclick='' style='width:100px;' />
               <img src='images/excel_logo.png' width='30' onclick='' style='text-decoration:none; cursor:pointer' class='popup_closebox' />
            </td>
          </tr>";
        $html .= "</table></div></form>";
        $html .= "</div>";
        return $html;
    }
}
?>

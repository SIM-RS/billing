<?php

function inputField($type, $value, $check, $name){
	$html = '<input value="'.$value.'" name="'.$name.'" required class="needs-validation" type="'.$type.'" novalidate '.$check.'>';
	return $html;
}

function formOpen($id,$action){
	$html = '<form id="'.$id.'" action="'.$action.'" class="needs-validation" novalidate>';
	return $html;
}

function formClose(){
	$html = '</form>';
	return $html;
}

function submitButton($id,$class,$type,$name){
	$html = '<button type="'.$type.'" id="'.$id.'" class="'.$class.'">'.$name.'</button>';
	return $html;
}

function fetchStyle($style){
	$inlineStyle = "";
	foreach ($style as $key => $val) {
		$inlineStyle .= $key . ':' . $val . ';';
	}
	return $inlineStyle;
}
 
function yaTidak($label,$label1,$label2,$name,$terpilih = "Tidak",$inputHtml = ""){

	$js = "";
    $js .= "document.getElementById(\"" . ($name . '_hide') . "\").style.display = \"block\";";
    $js .= "document.getElementById(\"" . ($name . '_keterangan') . "\").value = \"\";";
    $jsBuka = " onClick='" . $js . "'";

    $js = "";
    $js .= "document.getElementById(\"" . ($name . '_hide') . "\").style.display = \"none\";";
    $js .= "document.getElementById(\"" . ($name . '_keterangan') . "\").value = \"\";";

    $jsTutup = " onClick='" . $js . "'";

	$html = '<div class="form-group">';
	$html .= '<label class="font-weight-bold">'.$label.'</label>';
	$html .= '<div class="form-check">';
	$html .= '<input class="form-check-input" type="radio" id="'.$name.'1" name="'.$name.'" value="'.$label1.'"'.$jsBuka . '>';
	$html .= '<label for="">'.$label1.'</label>';
	// $html .= '</div>';
	// $html .= '<div class="form-check">';
	$html .= '<input class="form-check-input ml-4" type="radio" id="'.$name.'2" name="'.$name.'" value="'.$label2.'"'.$jsTutup.'>';
	$html .= '<label class="ml-5" for="">'.$label2.'</label>';
	$html .= '</div>';
	if($terpilih == "Tidak") $html .= '<div id="'.$name.'_hide" style="display:none;">';
	else $html .= '<div id="'.$name.'_hide" style="display:block;">';
	$html .= $inputHtml;
	$html .= '</div>';
	$html .= '</div>';
	return $html;
}

function optionFetch($data){
	$option = "";
	foreach ($data as $key => $val) {
		$option .= '<option value="'.$key.'">'.$val.'</option>';
	}
	return $option;
}

function textInput($label,$att = []){
	$html = '<div class="form-group">';
	if($label != ''){
		$html .= '<label for="">'.$label.'</label>';			
	}
	$html .= '<input ';
	foreach($att as $key => $val) {
		$html .= $key . '="'.$val.'" ';		
	}
	$html .= '>';
	$html .= '<div class="invalid-feedback">'.$label.' wajib di isi</div>';
	$html .= '</div>';
	return $html;
}

// function textInput($title,$name,$class,$required = '',$style = []){
// 	$html = '<div class="form-group">';
// 	$html .= '<label for="'.$name.'">'.$title.'</label>';
// 	if(sizeof($style) > 0){
// 		$inlineStyle = fetchStyle($style);
// 	}
// 	$html .= '<input type="text" class="'.$class.'" id="'.$name.'" name="'.$name.'" style="'.$inlineStyle.'"'.$required.'>';
// 	$html .= '<div class="invalid-feedback">'.$title.' wajib di isi</div>';
// 	$html .= '</div>';
// 	return $html;
// }

function textNumber($title,$name,$class,$required = '',$style = []){
	$html = '<div class="form-group">';
	$html .= '<label for="'.$name.'">'.$title.'</label>';

	if(sizeof($style) > 0){
		$inlineStyle = fetchStyle($style);
	}
	$html .= '<input type="number" class="'.$class.'" id="'.$name.'" name="'.$name.'" style="'.$inlineStyle.'"'.$required.'>';
	$html .= '<div class="invalid-feedback">'.$title.' wajib di isi</div>';
	$html .= '</div>';
	return $html;	
}

function textArea($label,$att = []){
	$html = '<div class="form-group">';
	if($label != ''){
		$html .= '<label for="">'.$label.'</label>';			
	}
	$html .= '<textarea ';
	foreach($att as $key => $val) {
		$html .= $key . '="'.$val.'" ';		
	}
	$html .= '></textarea>';
	$html .= '<div class="invalid-feedback">'.$label.' wajib di isi</div>';
	$html .= '</div>';
	return $html;	
}

function select($label,$data,$att = []){
	$html = '<div class="form-group">';
	if(isset($att['input'])){
		$html .= '<div class="row"><div class="col-6">';	
	}
	if($label != ''){
		$html .= '<label>'.$label.'</label>';	
	}
	$html .= '<select ';
	foreach($att as $key => $val) {
		if($key == 'input') continue;
		$html .= $key . '="'.$val.'" ';		
	}
	$html .= '>'.optionFetch($data).'</select>';
	if(isset($att['input'])){
		$html .= '</div>'; 
		$html .= '<div class="col-6">';
		$html .= $att['input'];
		$html .= '</div></div>';

	}

	$html .= '</div>';
	return $html;	
}
 
function update($table, $id, $fields) {
    $set = '';
    $x = 1;

    foreach($fields as $name => $value) {
        $set .= "{$name} = \"{$value}\"";
        if($x < count($fields)) {
            $set .= ',';
        }
        $x++;
    }
    mysql_query("UPDATE {$table} SET {$set} WHERE id = {$id}");
}

function save($data,$table){
	$sql = "INSERT INTO $table";
	$field = "(";
	$value = "(";
	foreach($data as $fieldName => $val){
		$field .= $fieldName.',';
		$value .= "'". $val ."'" . ',';
	}
	$field = substr($field,0,-1);
	$value = substr($value,0,-1);

	$sql .= $field . ') VALUES' . $value . ')';
	return [mysql_query($sql),$sql];
}

function alertMessage($msg,$file){
	echo '<script type="text/javascript">alert("'.$msg.'");window.location = "'.$file.'"</script>';
}

function getIndetitasPasien($idKunjungan){
	$sql = "SELECT p.* FROM b_kunjungan k INNER JOIN b_ms_pasien p ON p.id = k.pasien_id WHERE k.id = {$idKunjungan}";
	return mysql_fetch_assoc(mysql_query($sql));
}

function selectedMultipleData($data){
	$dataBalik = "";
	for($i = 0; $i < sizeof($data); $i++){
		$dataBalik .= $data[$i] . '|';
	}
	$dataBalik = substr($dataBalik, 0,-1);
	return $dataBalik;
}

function cetakRiwayatPenyakit($data){
	$dataArr = explode('|',$data);
	$dataBalik = '';
	$dataArr = removeJikaKosong($dataArr);
	for($i = 0; $i < sizeof($dataArr); $i++){
	    $dataBalik .= $i == sizeof($dataArr) - 1 ? $dataArr[$i] : $dataArr[$i] . ', ';
	}
	return $dataBalik;
}

function removeJikaKosong($data){
    $arrTemp = [];
    for($i = 0; $i < sizeof($data); $i++){
        if($data[$i] == ""){
            continue;
        }else{
            array_push($arrTemp,$data[$i]);
        }
    }
    return $arrTemp;
}
?>
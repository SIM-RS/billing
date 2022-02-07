<?php
Function AngkaToRupiah($Angka) {
    $pj = strlen($Angka);

    switch($pj) {
        case 1: $AngkaToRupiah = SATUAN(intval($Angka));
            break;
        case 2: $AngkaToRupiah = PULUHAN(intval($Angka));
            break;
        case 3: $AngkaToRupiah = RATUSAN(intval($Angka));
            break;
        case 4: $AngkaToRupiah = RIBUAN(intval($Angka));
            break;
        case 5: $AngkaToRupiah = PULUHAN_RIBU($Angka);
            break;
        case 6: $AngkaToRupiah = RATUSAN_RIBU($Angka);
            break;
        case 7: $AngkaToRupiah = JUTAAN($Angka);
            break;
        case 8: $AngkaToRupiah = JUTAAN($Angka);
            break;
        case 9: $AngkaToRupiah = JUTAAN($Angka);
            break;
        case $pj >= 10: $AngkaToRupiah = MILIAR($Angka);
            break;
    }
    $AngkaToRupiah = $AngkaToRupiah." Rupiah";

    //$AngkaToRupiah = str_replace(' ', '', $AngkaToRupiah)." Rupiah";
    return $AngkaToRupiah;
}

Function SATUAN($Angka) {
    switch($Angka) {
        case 1: $SATUAN = " Satu";
            break;
        case 2: $SATUAN = " Dua";
            break;
        case 3: $SATUAN = " Tiga";
            break;
        case 4: $SATUAN = " Empat";
            break;
        case 5: $SATUAN = " Lima";
            break;
        case 6: $SATUAN = " Enam";
            break;
        case 7: $SATUAN = " Tujuh";
            break;
        case 8: $SATUAN = " Delapan";
            break;
        case 9: $SATUAN = " Sembilan";
            break;
    }
    return $SATUAN;
}

Function PULUHAN($Angka) {
    $HasilBagi = floor($Angka / 10);
    $Sisa = $Angka % 10;

    If($HasilBagi == 1) {
        If($Sisa == 0)
            $PULUHAN = " Sepuluh";
        ElseIf($Sisa == 1)
            $PULUHAN = " Sebelas";
        Else
            $PULUHAN = SATUAN($Sisa)." Belas";
    }
    Else {
        If($Sisa == 0)
            $PULUHAN = SATUAN($HasilBagi)." Puluh";
        Else
            $PULUHAN = SATUAN($HasilBagi)." Puluh".SATUAN($Sisa);
    }

    return $PULUHAN;
}

Function RATUSAN($Angka) {
    $HasilBagi = floor($Angka/100);
    $Sisa = $Angka % 100;

    If($HasilBagi == 1)
        $RATUSAN = " Seratus";
    Else
        $RATUSAN = SATUAN($HasilBagi)." Ratus";

    If ($Sisa > 0 && $Sisa < 10)
        $RATUSAN = $RATUSAN.SATUAN($Sisa);
    ElseIf($Sisa >= 10)
        $RATUSAN = $RATUSAN.PULUHAN($Sisa);
    return $RATUSAN;
}

Function RIBUAN($Angka) {
    $HasilBagi = floor($Angka/1000);
    $Sisa = $Angka % 1000;

    If($HasilBagi == 1)
        $RIBUAN = " Seribu";
    Else
        $RIBUAN = SATUAN($HasilBagi)." Ribu";

    If($Sisa >= 100)
        $RIBUAN = $RIBUAN.RATUSAN($Sisa);
    ElseIf($Sisa >= 10)
        $RIBUAN = $RIBUAN.PULUHAN($Sisa);
    ElseIf($Sisa > 0)
        $RIBUAN = $RIBUAN.SATUAN($Sisa);
    return $RIBUAN;
}

Function PULUHAN_RIBU($Angka) {
    $HasilBagi = floor($Angka/1000);
    $Sisa = $Angka % 1000;

    $PULUHAN_RIBU = PULUHAN($HasilBagi)." Ribu";

    If($Sisa >= 100)
        $PULUHAN_RIBU = $PULUHAN_RIBU.RATUSAN($Sisa);
    ElseIf($Sisa >= 10)
        $PULUHAN_RIBU = $PULUHAN_RIBU.PULUHAN($Sisa);
    ElseIf($Sisa > 0)
        $PULUHAN_RIBU = $PULUHAN_RIBU.SATUAN($Sisa);
    return $PULUHAN_RIBU;
}

Function RATUSAN_RIBU($Angka) {
    $HasilBagi = floor($Angka/1000);
    $Sisa = $Angka % 1000;

    $RATUSAN_RIBU = RATUSAN($HasilBagi)." Ribu";

    If($Sisa >= 100)
        $RATUSAN_RIBU = $RATUSAN_RIBU.RATUSAN($Sisa);
    ElseIf($Sisa >= 10)
        $RATUSAN_RIBU = $RATUSAN_RIBU.PULUHAN($Sisa);
    ElseIf($Sisa > 0)
        $RATUSAN_RIBU = $RATUSAN_RIBU.SATUAN($Sisa);
    return $RATUSAN_RIBU;
}

Function JUTAAN($Angka) {
    $HasilBagi = floor($Angka/1000000);
    $Sisa = $Angka % 1000000;

    If($HasilBagi < 10)
        $JUTAAN = SATUAN($HasilBagi)." Juta";
    ElseIf($HasilBagi < 100)
        $JUTAAN = PULUHAN($HasilBagi)." Juta";
    ElseIf($HasilBagi >= 100)
        $JUTAAN = RATUSAN($HasilBagi)." Juta";

    If($Sisa >= 100000)
        $JUTAAN = $JUTAAN.RATUSAN_RIBU($Sisa);
    ElseIf($Sisa >= 10000)
        $JUTAAN = $JUTAAN.PULUHAN_RIBU($Sisa);
    ElseIf($Sisa >= 1000)
        $JUTAAN = $JUTAAN.RIBUAN(intval($Sisa));
    ElseIf($Sisa >= 100)
        $JUTAAN = $JUTAAN.RATUSAN(intval($Sisa));
    ElseIf($Sisa >= 10)
        $JUTAAN = $JUTAAN.PULUHAN(intval($Sisa));
    ElseIf($Sisa > 0)
        $JUTAAN = $JUTAAN.SATUAN(intval($Sisa));
    return $JUTAAN;
}

Function MILIAR($Angka) {
    $HasilBagi = floor(($Angka / 1000)/1000000);
    $Sisa = ((($Angka / 1000) % 1000000) * 1000);

    If($HasilBagi < 10)
        $MILIAR = SATUAN(intval($HasilBagi))." Miliar";
    ElseIf($HasilBagi < 100)
        $MILIAR = PULUHAN(intval($HasilBagi))." Miliar";
    ElseIf($HasilBagi >= 100)
        $MILIAR = RATUSAN(intval($HasilBagi))." Miliar";

    If($Sisa >= 1000000)
        $MILIAR = $MILIAR.JUTAAN($Sisa);
    ElseIf($Sisa >= 100000)
        $JUTAAN = $JUTAAN.RATUSAN_RIBU($Sisa);
    ElseIf($Sisa >= 10000)
        $MILIAR = $MILIAR.PULUHAN_RIBU($Sisa);
    ElseIf($Sisa >= 1000)
        $MILIAR = $MILIAR.RIBUAN(intval($Sisa));
    ElseIf($Sisa >= 100)
        $MILIAR = $MILIAR.RATUSAN(intval($Sisa));
    ElseIf($Sisa >= 10)
        $MILIAR = $MILIAR.PULUHAN(intval($Sisa));
    ElseIf($Sisa > 0)
        $MILIAR = $MILIAR.SATUAN(intval($Sisa));
    return $MILIAR;
}

function cekNull($val){
    if(!isset($val) || $val == ''){
        return 0;
    }
    else{
        return $val;
    }
}
?>

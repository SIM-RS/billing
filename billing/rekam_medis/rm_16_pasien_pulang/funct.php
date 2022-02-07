  <?php

  function radio3($data, $name, $type, $class) {
        if (isset($_REQUEST['id']) || isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
        if ($data == "1") {
          return "<div class='col-4'>
              <ul>
                <li><input checked type='radio' required name='{$name}' value='1'>&nbsp;<u>Kelainan Bawaan/ Kongenital</u></li>
                <li>&emsp;&nbsp;Congenital Disorders</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='2'>&nbsp;<u>Gangguan Mental</u></li>
                <li>&emsp;&nbsp;Mental Disorders</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='3'>&nbsp;<u>Kesuburan/kehamilan</u></li>
                <li>&emsp;&nbsp;Fertility/Pregnancy</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='4'>&nbsp;<u>Kecelakaan kerja</u></li>
                <li>&emsp;&nbsp;Work Accident</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='5'>&nbsp;<u>Gangguan hormonal</u></li>
                <li>&emsp;&nbsp;Hormonal Disorder</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='6'>&nbsp;<u>Kosmetik / Estetika</u></li>
                <li>&emsp;&nbsp;Cosmetics / Estetics</li>
              </ul>
            </div>
          </div>";
        } elseif($data == "2") {
          return "<div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='1'>&nbsp;<u>Kelainan Bawaan/ Kongenital</u></li>
                <li>&emsp;&nbsp;Congenital Disorders</li>
              </ul><br>
               <ul>
                <li><input checked type='radio' required name='{$name}' value='2'>&nbsp;<u>Gangguan Mental</u></li>
                <li>&emsp;&nbsp;Mental Disorders</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='3'>&nbsp;<u>Kesuburan/kehamilan</u></li>
                <li>&emsp;&nbsp;Fertility/Pregnancy</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='4'>&nbsp;<u>Kecelakaan kerja</u></li>
                <li>&emsp;&nbsp;Work Accident</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='5'>&nbsp;<u>Gangguan hormonal</u></li>
                <li>&emsp;&nbsp;Hormonal Disorder</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='6'>&nbsp;<u>Kosmetik / Estetika</u></li>
                <li>&emsp;&nbsp;Cosmetics / Estetics</li>
              </ul>
            </div>
          </div>";
        } elseif($data == "3"){
            return "<div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='1'>&nbsp;<u>Kelainan Bawaan/ Kongenital</u></li>
                <li>&emsp;&nbsp;Congenital Disorders</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='2'>&nbsp;<u>Gangguan Mental</u></li>
                <li>&emsp;&nbsp;Mental Disorders</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input checked type='radio' required name='{$name}' value='3'>&nbsp;<u>Kesuburan/kehamilan</u></li>
                <li>&emsp;&nbsp;Fertility/Pregnancy</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='4'>&nbsp;<u>Kecelakaan kerja</u></li>
                <li>&emsp;&nbsp;Work Accident</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='5'>&nbsp;<u>Gangguan hormonal</u></li>
                <li>&emsp;&nbsp;Hormonal Disorder</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='6'>&nbsp;<u>Kosmetik / Estetika</u></li>
                <li>&emsp;&nbsp;Cosmetics / Estetics</li>
              </ul>
            </div>
          </div>";
        } elseif($data == "4"){
            return "<div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='1'>&nbsp;<u>Kelainan Bawaan/ Kongenital</u></li>
                <li>&emsp;&nbsp;Congenital Disorders</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='2'>&nbsp;<u>Gangguan Mental</u></li>
                <li>&emsp;&nbsp;Mental Disorders</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='3'>&nbsp;<u>Kesuburan/kehamilan</u></li>
                <li>&emsp;&nbsp;Fertility/Pregnancy</li>
              </ul><br>
               <ul>
                <li><input checked type='radio' required name='{$name}' value='4'>&nbsp;<u>Kecelakaan kerja</u></li>
                <li>&emsp;&nbsp;Work Accident</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='5'>&nbsp;<u>Gangguan hormonal</u></li>
                <li>&emsp;&nbsp;Hormonal Disorder</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='6'>&nbsp;<u>Kosmetik / Estetika</u></li>
                <li>&emsp;&nbsp;Cosmetics / Estetics</li>
              </ul>
            </div>
          </div>";
        } elseif($data == "5"){
            return "<div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='1'>&nbsp;<u>Kelainan Bawaan/ Kongenital</u></li>
                <li>&emsp;&nbsp;Congenital Disorders</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='2'>&nbsp;<u>Gangguan Mental</u></li>
                <li>&emsp;&nbsp;Mental Disorders</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='3'>&nbsp;<u>Kesuburan/kehamilan</u></li>
                <li>&emsp;&nbsp;Fertility/Pregnancy</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='4'>&nbsp;<u>Kecelakaan kerja</u></li>
                <li>&emsp;&nbsp;Work Accident</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input checked type='radio' required name='{$name}' value='5'>&nbsp;<u>Gangguan hormonal</u></li>
                <li>&emsp;&nbsp;Hormonal Disorder</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='6'>&nbsp;<u>Kosmetik / Estetika</u></li>
                <li>&emsp;&nbsp;Cosmetics / Estetics</li>
              </ul>
            </div>
          </div>";
        } else{
            return "<div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='1'>&nbsp;<u>Kelainan Bawaan/ Kongenital</u></li>
                <li>&emsp;&nbsp;Congenital Disorders</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='2'>&nbsp;<u>Gangguan Mental</u></li>
                <li>&emsp;&nbsp;Mental Disorders</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='3'>&nbsp;<u>Kesuburan/kehamilan</u></li>
                <li>&emsp;&nbsp;Fertility/Pregnancy</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='4'>&nbsp;<u>Kecelakaan kerja</u></li>
                <li>&emsp;&nbsp;Work Accident</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='5'>&nbsp;<u>Gangguan hormonal</u></li>
                <li>&emsp;&nbsp;Hormonal Disorder</li>
              </ul><br>
               <ul>
                <li><input checked type='radio' required name='{$name}' value='6'>&nbsp;<u>Kosmetik / Estetika</u></li>
                <li>&emsp;&nbsp;Cosmetics / Estetics</li>
              </ul>
            </div>
          </div>";
        }
    } else {
      return "<div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='1'>&nbsp;<u>Kelainan Bawaan/ Kongenital</u></li>
                <li>&emsp;&nbsp;Congenital Disorders</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='2'>&nbsp;<u>Gangguan Mental</u></li>
                <li>&emsp;&nbsp;Mental Disorders</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='3'>&nbsp;<u>Kesuburan/kehamilan</u></li>
                <li>&emsp;&nbsp;Fertility/Pregnancy</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='4'>&nbsp;<u>Kecelakaan kerja</u></li>
                <li>&emsp;&nbsp;Work Accident</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='5'>&nbsp;<u>Gangguan hormonal</u></li>
                <li>&emsp;&nbsp;Hormonal Disorder</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='6'>&nbsp;<u>Kosmetik / Estetika</u></li>
                <li>&emsp;&nbsp;Cosmetics / Estetics</li>
              </ul>
            </div>
          </div>";
    }
    
  }

  function radio2($data, $name, $type, $class){

    if (isset($_REQUEST['id']) || isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
        if ($data == "1") {
          return "<div class='col-4'>
              <ul>
                <li><input checked type='radio' required name='{$name}' value='1'>&nbsp;<u>Pulang atas indikasi medis</u></li>
                <li>&emsp;&nbsp;Accord on Medical Indication</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='2'>&nbsp;<u>Pindah/ Rujuk ke RS lain</u></li>
                <li>&emsp;&nbsp;Referred to Another Hospital</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='3'>&nbsp;<u>Pulang atas permintaan sendiri</u></li>
                <li>&emsp;&nbsp;Accord on Patient Request</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='4'>&nbsp;<u>Meninggal</u></li>
                <li>&emsp;&nbsp;Death</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='5'>&nbsp;<u>Pulang kondisi khusus</u></li>
                <li>&emsp;&nbsp;Accord on special condition</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='6'>&nbsp;<u>Lain-lain</u></li>
                <li>&emsp;&nbsp;Other</li>
              </ul>
            </div>
          </div>";
        } elseif($data == "2") {
          return "<div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='1'>&nbsp;<u>Pulang atas indikasi medis</u></li>
                <li>&emsp;&nbsp;Accord on Medical Indication</li>
              </ul><br>
               <ul>
                <li><input checked type='radio' required name='{$name}' value='2'>&nbsp;<u>Pindah/ Rujuk ke RS lain</u></li>
                <li>&emsp;&nbsp;Referred to Another Hospital</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='3'>&nbsp;<u>Pulang atas permintaan sendiri</u></li>
                <li>&emsp;&nbsp;Accord on Patient Request</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='4'>&nbsp;<u>Meninggal</u></li>
                <li>&emsp;&nbsp;Death</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='5'>&nbsp;<u>Pulang kondisi khusus</u></li>
                <li>&emsp;&nbsp;Accord on special condition</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='6'>&nbsp;<u>Lain-lain</u></li>
                <li>&emsp;&nbsp;Other</li>
              </ul>
            </div>
          </div>";
        } elseif($data == "3"){
            return "<div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='1'>&nbsp;<u>Pulang atas indikasi medis</u></li>
                <li>&emsp;&nbsp;Accord on Medical Indication</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='2'>&nbsp;<u>Pindah/ Rujuk ke RS lain</u></li>
                <li>&emsp;&nbsp;Referred to Another Hospital</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input checked type='radio' required name='{$name}' value='3'>&nbsp;<u>Pulang atas permintaan sendiri</u></li>
                <li>&emsp;&nbsp;Accord on Patient Request</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='4'>&nbsp;<u>Meninggal</u></li>
                <li>&emsp;&nbsp;Death</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='5'>&nbsp;<u>Pulang kondisi khusus</u></li>
                <li>&emsp;&nbsp;Accord on special condition</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='6'>&nbsp;<u>Lain-lain</u></li>
                <li>&emsp;&nbsp;Other</li>
              </ul>
            </div>
          </div>";
        } elseif($data == "4"){
            return "<div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='1'>&nbsp;<u>Pulang atas indikasi medis</u></li>
                <li>&emsp;&nbsp;Accord on Medical Indication</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='2'>&nbsp;<u>Pindah/ Rujuk ke RS lain</u></li>
                <li>&emsp;&nbsp;Referred to Another Hospital</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='3'>&nbsp;<u>Pulang atas permintaan sendiri</u></li>
                <li>&emsp;&nbsp;Accord on Patient Request</li>
              </ul><br>
               <ul>
                <li><input checked type='radio' required name='{$name}' value='4'>&nbsp;<u>Meninggal</u></li>
                <li>&emsp;&nbsp;Death</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='5'>&nbsp;<u>Pulang kondisi khusus</u></li>
                <li>&emsp;&nbsp;Accord on special condition</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='6'>&nbsp;<u>Lain-lain</u></li>
                <li>&emsp;&nbsp;Other</li>
              </ul>
            </div>
          </div>";
        } elseif($data == "5"){
            return "<div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='1'>&nbsp;<u>Pulang atas indikasi medis</u></li>
                <li>&emsp;&nbsp;Accord on Medical Indication</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='2'>&nbsp;<u>Pindah/ Rujuk ke RS lain</u></li>
                <li>&emsp;&nbsp;Referred to Another Hospital</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='3'>&nbsp;<u>Pulang atas permintaan sendiri</u></li>
                <li>&emsp;&nbsp;Accord on Patient Request</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='4'>&nbsp;<u>Meninggal</u></li>
                <li>&emsp;&nbsp;Death</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input checked type='radio' required name='{$name}' value='5'>&nbsp;<u>Pulang kondisi khusus</u></li>
                <li>&emsp;&nbsp;Accord on special condition</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='6'>&nbsp;<u>Lain-lain</u></li>
                <li>&emsp;&nbsp;Other</li>
              </ul>
            </div>
          </div>";
        } else{
            return "<div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='1'>&nbsp;<u>Pulang atas indikasi medis</u></li>
                <li>&emsp;&nbsp;Accord on Medical Indication</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='2'>&nbsp;<u>Pindah/ Rujuk ke RS lain</u></li>
                <li>&emsp;&nbsp;Referred to Another Hospital</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='3'>&nbsp;<u>Pulang atas permintaan sendiri</u></li>
                <li>&emsp;&nbsp;Accord on Patient Request</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='4'>&nbsp;<u>Meninggal</u></li>
                <li>&emsp;&nbsp;Death</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='5'>&nbsp;<u>Pulang kondisi khusus</u></li>
                <li>&emsp;&nbsp;Accord on special condition</li>
              </ul><br>
               <ul>
                <li><input checked type='radio' required name='{$name}' value='6'>&nbsp;<u>Lain-lain</u></li>
                <li>&emsp;&nbsp;Other</li>
              </ul>
            </div>
          </div>";
        }
    } else {
      return "<div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='1'>&nbsp;<u>Pulang atas indikasi medis</u></li>
                <li>&emsp;&nbsp;Accord on Medical Indication</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='2'>&nbsp;<u>Pindah/ Rujuk ke RS lain</u></li>
                <li>&emsp;&nbsp;Referred to Another Hospital</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='3'>&nbsp;<u>Pulang atas permintaan sendiri</u></li>
                <li>&emsp;&nbsp;Accord on Patient Request</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='4'>&nbsp;<u>Meninggal</u></li>
                <li>&emsp;&nbsp;Death</li>
              </ul>
            </div>

            <div class='col-4'>
              <ul>
                <li><input type='radio' required name='{$name}' value='5'>&nbsp;<u>Pulang kondisi khusus</u></li>
                <li>&emsp;&nbsp;Accord on special condition</li>
              </ul><br>
               <ul>
                <li><input type='radio' required name='{$name}' value='6'>&nbsp;<u>Lain-lain</u></li>
                <li>&emsp;&nbsp;Other</li>
              </ul>
            </div>
          </div>";
    }
    
  }

  function radio($data, $name, $type, $class){

    if (isset($_REQUEST['id']) || isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
        if ($data == "lk") {
          return "<input required checked type='radio' required name='{$name}' value='lk'>&nbsp;Laki-Laki&emsp;
                  <input required type='radio' required name='{$name}' value='pr'>&nbsp;Perempuan<br>
                  <span class='text-right'>Male</span>&emsp;&emsp;&emsp;&emsp;&nbsp;<span>Female</span>";
        } elseif($data == "pr") {
          return "<input required type='radio' required name='{$name}' value='lk'>&nbsp;Laki-Laki&emsp;
                  <input required checked type='radio' required name='{$name}' value='pr'>&nbsp;Perempuan<br>
                  <span class='text-right'>Male</span>&emsp;&emsp;&emsp;&emsp;&nbsp;<span>Female</span>";
        }
    } else {
      return "<input required type='radio' required name='{$name}' value='lk'>&nbsp;Laki-Laki&emsp;
                  <input required type='radio' required name='{$name}' value='pr'>&nbsp;Perempuan<br>
                  <span class='text-right'>Male</span>&emsp;&emsp;&emsp;&emsp;&nbsp;<span>Female</span>";
    }
    
  }

    function checkInput($data, $name, $class) {

      if (isset($_REQUEST['id']) || isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {

        if ($data == "" || $data == "#") {
          return "<input class='{$class}' name='{$name}' value='1' type='checkbox'>";
        } else {
          return "<input class='{$class}' type='checkbox' value='1' name='{$name}' checked>";
        }

    } else {
      return "<input class='{$class}' name='{$name}' value='1' type='checkbox'>";
    }
  }

  function input($data, $name, $type, $class){

    if (isset($_REQUEST['id'])) {

      if ($data == "" || $data == "#") {
        return "<input name='{$name}' class='{$class}' type='{$type}' />";
      } else {
        return "<input class='{$class}' name='{$name}' type='{$type}' value='{$data}' />";
      }

    } elseif(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
      if ($data == "" || $data == "#") {
        return "";
      } else {
        return $data;
      }
    } else {
      return "<input class='{$class}' name='{$name}' type='{$type}'/>";
    }
    
  }

  function area($data, $name, $class){

    if (isset($_REQUEST['id'])) {

      if ($data == "" || $data == "#") {
        return "<textarea class='form-control {$class}' name='{$name}'></textarea>";
      } else {
        return "<textarea class='form-control {$class}' name='{$name}'>{$data}</textarea>";
      }

    } elseif(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
      if ($data == "" || $data == "#") {
        return "";
      } else {
        return $data;
      }
    } else {
      return "<textarea class='form-control {$class}' name='{$name}'></textarea>";
    }
    
  }
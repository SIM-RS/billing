<?php

function radio1($data, $name) {
    if (isset($_REQUEST['id']) ||isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
        if ($data == "0") {
            return "<div class='col-6'>
                      <input type='radio' checked name='{$name}' onchange='changed1()' class='in1' value='0'> IMT > 20 (Obesitas >30) &emsp; <br>
                      <input type='radio' name='{$name}' onchange='changed1()' class='in1' value='1'> IMT 18.5- 20 &emsp; <br>
                      <input type='radio' name='{$name}' onchange='changed1()' class='in1' value='2'> IMT < 18.5 &emsp; <br>
                      </div>
                      <div class='col-6'>
                      = 0 <br>
                      = 1 <br>
                      = 2
                      </div>";
        } elseif($data == "1"){
            return "<div class='col-6'>
                      <input type='radio' name='{$name}' onchange='changed1()' class='in1' value='0'> IMT > 20 (Obesitas >30) &emsp; <br>
                      <input type='radio' checked name='{$name}' onchange='changed1()' class='in1' value='1'> IMT 18.5- 20 &emsp; <br>
                      <input type='radio' name='{$name}' onchange='changed1()' class='in1' value='2'> IMT < 18.5 &emsp; <br>
                      </div>
                      <div class='col-6'>
                      = 0 <br>
                      = 1 <br>
                      = 2
                      </div>";
        } else {
            return "<div class='col-6'>
                      <input type='radio' name='{$name}' onchange='changed1()' class='in1' value='0'> IMT > 20 (Obesitas >30) &emsp; <br>
                      <input type='radio' name='{$name}' onchange='changed1()' class='in1' value='1'> IMT 18.5- 20 &emsp; <br>
                      <input type='radio' checked name='{$name}' onchange='changed1()' class='in1' value='2'> IMT < 18.5 &emsp; <br>
                      </div>
                      <div class='col-6'>
                      = 0 <br>
                      = 1 <br>
                      = 2
                      </div>";
        }
    } else {
        return "<div class='col-6'>
                      <input type='radio' name='{$name}' onchange='changed1()' class='in1' value='0'> IMT > 20 (Obesitas >30) &emsp; <br>
                      <input type='radio' name='{$name}' onchange='changed1()' class='in1' value='1'> IMT 18.5- 20 &emsp; <br>
                      <input type='radio' name='{$name}' onchange='changed1()' class='in1' value='2'> IMT < 18.5 &emsp; <br>
                      </div>
                      <div class='col-6'>
                      = 0 <br>
                      = 1 <br>
                      = 2
                      </div>";
    }
}

function radio2($data, $name) {
    if (isset($_REQUEST['id']) || isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
        if ($data == "0") {
            return "<div class='col-6'>
                      <input class='in1' onchange='changed1()' value='0' checked type='radio' name='{$name}'>	BB Hilang < % &emsp; <br>
                      <input class='in1' onchange='changed1()' value='1' type='radio' name='{$name}'>	BB hilang 5- 10% &emsp; <br>
                      <input class='in1' onchange='changed1()' value='2' type='radio' name='{$name}'>	BB hilang > 10% &emsp; <br>
                      </div>
                      <div class='col-6'>
                      = 0 <br>
                      = 1 <br>
                      = 2
                      </div>";
        } elseif($data == "1"){
            return "<div class='col-6'>
                      <input class='in1' onchange='changed1()' value='0' type='radio' name='{$name}'>	BB Hilang < % &emsp; <br>
                      <input class='in1' onchange='changed1()' value='1' type='radio' checked name='{$name}'>	BB hilang 5- 10% &emsp; <br>
                      <input class='in1' onchange='changed1()' value='2' type='radio' name='{$name}'>	BB hilang > 10% &emsp; <br>
                      </div>
                      <div class='col-6'>
                      = 0 <br>
                      = 1 <br>
                      = 2
                      </div>";
        } else {
            return "<div class='col-6'>
                      <input class='in1' onchange='changed1()' value='0' type='radio' name='{$name}'>	BB Hilang < % &emsp; <br>
                      <input class='in1' onchange='changed1()' value='1' type='radio' name='{$name}'>	BB hilang 5- 10% &emsp; <br>
                      <input class='in1' onchange='changed1()' value='2' type='radio' checked name='{$name}'>	BB hilang > 10% &emsp; <br>
                      </div>
                      <div class='col-6'>
                      = 0 <br>
                      = 1 <br>
                      = 2
                      </div>";
        }
    } else {
        return "<div class='col-6'>
                      <input class='in1' onchange='changed1()' value='0' type='radio' name='{$name}'>	BB Hilang < % &emsp; <br>
                      <input class='in1' onchange='changed1()' value='1' type='radio' name='{$name}'>	BB hilang 5- 10% &emsp; <br>
                      <input class='in1' onchange='changed1()' value='2' type='radio' name='{$name}'>	BB hilang > 10% &emsp; <br>
                      </div>
                      <div class='col-6'>
                      = 0 <br>
                      = 1 <br>
                      = 2
                      </div>";
    }
}

function radio3($data, $name) {
    if (isset($_REQUEST['id']) || isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
        if ($data == "0") {
            return "<div class='col-6'>
                      <input onchange='changed1()' checked value='0' type='radio' name='{$name}' class='in1'>	Ada asupan nutrisi >5 hari &emsp; <br>
                      <input onchange='changed1()' value='2' type='radio' name='{$name}' class='in1'>	Tidak ada asupan nutrisi > 5 hari &emsp;
                      </div>
                      <div class='col-6'>
                      = 0 <br>
                      = 2
                      </div>";
        } else {
            return "<div class='col-6'>
                      <input onchange='changed1()' value='0' type='radio' name='{$name}' class='in1'>	Ada asupan nutrisi >5 hari &emsp; <br>
                      <input onchange='changed1()' checked value='2' type='radio' name='{$name}' class='in1'>	Tidak ada asupan nutrisi > 5 hari &emsp;
                      </div>
                      <div class='col-6'>
                      = 0 <br>
                      = 2
                      </div>";
        }
    } else {
        return "<div class='col-6'>
                      <input onchange='changed1()' value='0' type='radio' name='{$name}' class='in1'>	Ada asupan nutrisi >5 hari &emsp; <br>
                      <input onchange='changed1()' value='2' type='radio' name='{$name}' class='in1'>	Tidak ada asupan nutrisi > 5 hari &emsp;
                      </div>
                      <div class='col-6'>
                      = 0 <br>
                      = 2
                      </div>";
    }
}

function input($data, $name, $type, $class, $style){

    if (isset($_REQUEST['id'])) {

      if ($data == "#") {
        return "<input name='{$name}' class='{$class}' style='{$style}' type='{$type}' />";
      } else {
        // $int = (int)$data;
        return "<input class='{$class}' style='{$style}' name='{$name}' type='{$type}' value='{$data}' />";
      }

    } elseif(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
      if ($data == "#") {
        return "";
      } else {
        return $data;
      }
    } else {
      return "<input class='{$class}' style='{$style}' name='{$name}' type='{$type}'/>";
    }
    
  }
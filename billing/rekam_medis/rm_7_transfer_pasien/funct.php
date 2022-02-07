<?php

function area($data, $name, $class){

    if (isset($_REQUEST['id'])) {

      if ($data == "#") {
        return "<textarea class='form-control {$class}' name='{$name}'></textarea>";
      } else {
        return "<textarea class='form-control {$class}' name='{$name}'>{$data}</textarea>";
      }

    } elseif(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
      if ($data == "#") {
        return "";
      } else {
        return $data;
      }
    } else {
      return "<textarea class='form-control {$class}' name='{$name}'></textarea>";
    }
    
  }

    function checked($data) {
      if (isset($_REQUEST['cetak']) || isset($_REQUEST['pdf']) || isset($_REQUEST['id'])) {

        if ($data != "#") {
          return "checked";
        }
      }
    }

function input($data, $name, $type, $class, $style, $option = ""){

    if (isset($_REQUEST['id'])) {

      if ($data == "#") {
        return "<input name='{$name}' class='{$class}' style='{$style}' type='{$type}' {$option} />";
      } else {
        return "<input class='{$class}' style='{$style}' name='{$name}' type='{$type}' value='{$data}' {$option} />";
      }

    } elseif(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
      if ($data == "#") {
        return "";
      } else {
        return $data;
      }
    } else {
      return "<input class='{$class}' style='{$style}' name='{$name}' type='{$type} {$option}'/>";
    }
    
  }

  function radio($data, $name){

    if (isset($_REQUEST['id']) || isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {

      if ($data == "1") {
        return "<input checked type='radio' name='{$name}' value='1'> 1&emsp;<input type='radio' name='{$name}' value='2'> 2&emsp;<input type='radio' name='{$name}' value='3'> 3&emsp;<input type='radio' name='{$name}' value='4'> 4&emsp;<input type='radio' name='{$name}' value='5'> 5";
      } elseif($data == "2") {
        return "<input type='radio' name='{$name}' value='1'> 1&emsp;<input checked type='radio' name='{$name}' value='2'> 2&emsp;<input type='radio' name='{$name}' value='3'> 3&emsp;<input type='radio' name='{$name}' value='4'> 4&emsp;<input type='radio' name='{$name}' value='5'> 5";
      }elseif($data == "3") {
        return "<input type='radio' name='{$name}' value='1'> 1&emsp;<input type='radio' name='{$name}' value='2'> 2&emsp;<input checked type='radio' name='{$name}' value='3'> 3&emsp;<input type='radio' name='{$name}' value='4'> 4&emsp;<input type='radio' name='{$name}' value='5'> 5";
      }elseif($data == "4") {
        return "<input type='radio' name='{$name}' value='1'> 1&emsp;<input type='radio' name='{$name}' value='2'> 2&emsp;<input type='radio' name='{$name}' value='3'> 3&emsp;<input checked type='radio' name='{$name}' value='4'> 4&emsp;<input type='radio' name='{$name}' value='5'> 5";
      } else {
        return "<input type='radio' name='{$name}' value='1'> 1&emsp;<input type='radio' name='{$name}' value='2'> 2&emsp;<input type='radio' name='{$name}' value='3'> 3&emsp;<input type='radio' name='{$name}' value='4'> 4&emsp;<input type='radio' checked name='{$name}' value='5'> 5";
      }
    
  }else {
    return "<input type='radio' name='{$name}' value='1'> 1&emsp;<input type='radio' name='{$name}' value='2'> 2&emsp;<input type='radio' name='{$name}' value='3'> 3&emsp;<input type='radio' name='{$name}' value='4'> 4&emsp;<input type='radio' name='{$name}' value='5'> 5";
  }

}
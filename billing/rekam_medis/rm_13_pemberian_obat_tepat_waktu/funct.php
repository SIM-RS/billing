<?php

function input($data, $name, $type, $class, $style){

    if (isset($_REQUEST['id'])) {

      if ($data == "#") {
        return "<input name='{$name}' class='{$class}' style='{$style}' type='{$type}' />";
      } else {
        return "<input class='{$class}' style='{$style}' name='{$name}' type='{$type}' value='{$data}' />";
      }

    } elseif(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
      if ($data == "#") {
        return "";
      } else {
        return "{$data}";
      }
    } else {
      return "<input class='{$class}' style='{$style}' name='{$name}' type='{$type}'/>";
    }
    
  }
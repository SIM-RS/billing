  <?php
  
    function checked($data) {
      if (isset($_REQUEST['cetak']) || isset($_REQUEST['pdf']) || isset($_REQUEST['id'])) {
        if ($data != "#") {
          return "checked";
        }
      }
    }

  function input($data, $name, $type, $class, $style){

    if (isset($_REQUEST['id'])) {

      if ($data == "" || $data == "#") {
        return "<input name='{$name}' class='{$class}' style='{$style}' type='{$type}' />";
      } else {
        return "<input class='{$class}' name='{$name}' style='{$style}' type='{$type}' value='{$data}' />";
      }

    } elseif(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
      if ($data == "" || $data == "#") {
        return "";
      } else {
        return $data;
      }
    } else {
      return "<input class='{$class}' name='{$name}' type='{$type}' style='{$style}' />";
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
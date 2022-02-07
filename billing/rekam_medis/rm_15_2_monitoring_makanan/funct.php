 <?php     
    function inputSelect($name, $data){
    if (isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
        $html = $data;
        return $html;
    } elseif(isset($_REQUEST['id'])) {
        if ($data == '1') {
            $html = "<select name='{$name}' class='selects' required><option value='1'>1</option><option value='3/4'>3/4</option><option value='1/2'>1/2</option><option value='0'>0</option></select>";
            return $html;
        } elseif($data == '3/4'){
            $html = "<select name='{$name}' class='selects' required><option value='3/4'>3/4</option><option value='1'>1</option><option value='1/2'>1/2</option><option value='0'>0</option></select>";
            return $html;
        } elseif($data == '1/2'){
            $html = "<select name='{$name}' class='selects' required><option value='1/2'>1/2</option><option value='3/4'>3/4</option><option value='1'>1</option><option value='0'>0</option></select>";
            return $html;
        } else {
            $html = "<select name='{$name}' class='selects' required><option value='0'>0</option><option value='1/2'>1/2</option><option value='3/4'>3/4</option><option value='1'>1</option><option value='0'>0</option></select>";
            return $html;
        }
        
    } else {
        $html = "<select name='{$name}' class='selects' required><option value='1'>1</option><option value='3/4'>3/4</option><option value='1/2'>1/2</option><option value='0'>0</option></select>";
        return $html;
    }
}
  
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

    function input($data, $name, $type, $class){

    if (isset($_REQUEST['id'])) {

      if ($data == "#") {
        return "<input name='{$name}' class='{$class}' type='{$type}' />";
      } else {
        return "<input class='{$class}' name='{$name}' type='{$type}' value='{$data}' />";
      }

    } elseif(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
      if ($data == "#") {
        return "";
      } else {
        return $data;
      }
    } else {
      return "<input class='{$class}' name='{$name}' type='{$type}'/>";
    }
    
  }
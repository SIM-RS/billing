<?
   function removeSpecial($mystr) {
		$mystr=strtr($mystr,"%","~");
		$mystr=strtr($mystr,";","~");
		$mystr=strtr($mystr,"\\","~");
		$mystr=strtr($mystr,"'","~");
		$mystr=str_replace("--","~",$mystr);
		$mystr=strtr($mystr,"`","~");
		$mystr=strtr($mystr,"&","~");
		$mystr=strtr($mystr,"\"","~");
		$mystr = eregi_replace("~","",$mystr);
		return $mystr;
   }
   
    function removeSpecialCR($mystr) {
		$mystr=strtr($mystr,"%","~");
		$mystr=strtr($mystr,";","~");
		$mystr=strtr($mystr,"'","~");
		$mystr=strtr($mystr,"`","~");
		$mystr=str_replace("--","~",$mystr);
		$mystr=strtr($mystr,"&","~");
		$mystr=strtr($mystr,"\r","~");
		$mystr=strtr($mystr,"\n"," ");
		$mystr=strtr($mystr,"\"","~");
		$mystr = eregi_replace("~","",$mystr);
		return $mystr;
   }
   
   function CStrNull($item)
   {
	if (isset($item) and $item!="")
		return removeSpecial($item);
	else
		return "null";
   }

   function CStrNullQ($item)
   {
	if (isset($item) and $item!="")
		return "'".removeSpecial($item)."'";
	else
		return "null";
   }

   
   function CNumNull($item)
   {
	if (isset($item) and ($item==''))
		return "null";
	else
		return $item;
   }  

  function CDateInd($item)
   {
	if (isset($item) and $item!="") {
		$arrid = split ('[/.-]', $item);
		$t_dd = $arrid[0];
		$t_mm = $arrid[1];
		$t_yy = $arrid[2];
		return "$t_yy-$t_mm-$t_dd";
		
		}
	else
		return "null";
   }  
  
  
 ?>
  
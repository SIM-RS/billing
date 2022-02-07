<?php  
  /*********************************************/
  /*  PHP TreeMenu 1.1                         */
  /*                                           */
  /*  Author: Bjorge Dijkstra                  */
  /*  email : bjorge@gmx.net                   */
  /*                                           */  
  /*  Placed in Public Domain                  */
  /*                                           */  
  /*********************************************/

  /*********************************************/
  /*  Settings                                 */
  /*********************************************/
  /*                                           */      
  /*  $treefile variable needs to be set in    */
  /*  main file                                */
  /*                                           */ 
  /*********************************************/
  
  /*********************************************/
  /*                                           */
  /* - Multiple root node fix by Dan Howard    */
  /*                                           */
  /*********************************************/
  
  $browser=$_SERVER['HTTP_USER_AGENT'];
  
  if(isset($PATH_INFO)) {
	  $script       =  $PATH_INFO; 
  } else {
	  $script	=  $SCRIPT_NAME;
  }
  if(isset($imageDir))
 	{
	$img_expand   	= $imageDir."images/tree_expand.gif";
	$img_collapse 	= $imageDir."images/tree_collapse.gif";
	$img_line     	= $imageDir."images/tree_vertline.gif";  
	$img_split		= $imageDir."images/tree_split.gif";
	$img_end      	= $imageDir."images/tree_end.gif";
	$img_leaf     	= $imageDir."images/tree_leaf.gif";
	$img_spc      	= $imageDir."images/tree_space.gif";
		}else
		{
  $img_expand   = "images/tree_expand.gif";
  $img_collapse = "images/tree_collapse.gif";
  $img_line     = "images/tree_vertline.gif";  
  $img_split	= "images/tree_split.gif";
  $img_end      = "images/tree_end.gif";
  $img_leaf     = "images/tree_leaf.gif";
  $img_spc      = "images/tree_space.gif";
	}
  for ($i=0; $i<count($tree); $i++) {
     $expand[$i]=0;
     $visible[$i]=0;
     $levels[$i]=0;
  }

  /*********************************************/
  /*  Get Node numbers to expand               */
  /*********************************************/
 
  if ($p!="") $explevels = explode("|",$p);
  //echo $p;
  $i=0;
  while($i<count($explevels))
  {
    $expand[$explevels[$i]]=1;
    $i++;
  }
  
  /*********************************************/
  /*  Find last nodes of subtrees              */
  /*********************************************/
  
  $lastlevel=$maxlevel;
  for ($i=count($tree)-1; $i>=0; $i--)
  {
     if ( $tree[$i][0] < $lastlevel )
     {
       for ($j=$tree[$i][0]+1; $j <= $maxlevel; $j++)
       {
          $levels[$j]=0;
       }
     }
     if ( $levels[$tree[$i][0]]==0 )
     {
       $levels[$tree[$i][0]]=1;
       $tree[$i][4]=1;
     }
     else
       $tree[$i][4]=0;
     $lastlevel=$tree[$i][0];  
  }
  
  
  /*********************************************/
  /*  Determine visible nodes                  */
  /*********************************************/
  
// all root nodes are always visible
  for ($i=0; $i < count($tree); $i++) if ($tree[$i][0]==1) $visible[$i]=1;


  for ($i=0; $i < count($explevels); $i++)
  {
    $n=$explevels[$i];
    if ( ($visible[$n]==1) && ($expand[$n]==1) )
    {
       $j=$n+1;
       while ( $tree[$j][0] > $tree[$n][0] )
       {
         if ($tree[$j][0]==$tree[$n][0]+1) $visible[$j]=1;     
         $j++;
       }
    }
  }
  
  
  /*********************************************/
  /*  Output nicely formatted tree             */
  /*********************************************/
  
  for ($i=0; $i<$maxlevel; $i++) $levels[$i]=1;

  $maxlevel++;
  
  echo "<table cellspacing=0 cellpadding=0 border=0 cols=".($maxlevel+3)." width=100%>\n";
  echo "<tr>";
  for ($i=0; $i<$maxlevel; $i++) echo "<td width=16>&nbsp;</td>";
  if ($include_del==1)
  	if (strpos($browser,"MSIE")>0)
  		echo "<td width='100%'>&nbsp;</td><td width='50'>&nbsp;</td></tr>\n";
	else
  		echo "<td>&nbsp;</td><td width='50'>&nbsp;</td></tr>\n";
  else
  	echo "<td width=100%>&nbsp;</td></tr>\n";
  $cnt=0;
  $j=0;
  while ($cnt<count($tree))
  {
    
    if ($visible[$cnt])
    {
      /****************************************/
      /* start new row                        */
      /****************************************/      
      $j++;
      if ($j % 2) $rowStyle = "NormalBG";  else $rowStyle = "AlternateBG";
	  if ($tree[$cnt][6]==0) $rowStyle = "NonAktifBG";
      echo "<tr class='$rowStyle' onMouseOver=\"this.className='MoverBG'\" onMouseOut=\"this.className='$rowStyle'\">";
      
      /****************************************/
      /* vertical lines from higher levels    */
      /****************************************/
      $i=0;
      while ($i<$tree[$cnt][0]-1) 
      {
        if ($levels[$i]==1)
            echo "<td width=16><a name='$cnt'></a><img width='16' height='16' src=\"".$img_line."\"></td>";
        else
            echo "<td width=16><a name='$cnt'></a><img width='16' height='1' src=\"".$img_spc."\"></td>";
        $i++;
      }
      
      /****************************************/
      /* corner at end of subtree or t-split  */
      /****************************************/         
      if ($tree[$cnt][4]==1) 
      {
        echo "<td width=16><img width='16' height='16' src=\"".$img_end."\"></td>";
        $levels[$tree[$cnt][0]-1]=0;
      }
      else
      {
        echo "<td width=16><img width='16' height='16' src=\"".$img_split."\"></td>";                  
        $levels[$tree[$cnt][0]-1]=1;    
      } 
      
      /********************************************/
      /* Node (with subtree) or Leaf (no subtree) */
      /********************************************/
      if ($tree[$cnt+1][0]>$tree[$cnt][0])
      {
        
        /****************************************/
        /* Create expand/collapse parameters    */
        /****************************************/
        $i=0; if (strcmp($PATH_INFO,"?")>0) $params="&p="; else $params="?p=";
        while($i<count($expand))
        {
          if ( ($expand[$i]==1) && ($cnt!=$i) || ($expand[$i]==0 && $cnt==$i))
          {
            $params=$params.$i;
            $params=$params."|";
          }
          $i++;
        }
               
        if ($expand[$cnt]==0)
            echo "<td width=16><a href=\"".$script.$params."#$cnt\"><img width='16' height='16' src=\"".$img_expand."\" border=no></a></td>";
        else
            echo "<td width=16><a href=\"".$script.$params."#$cnt\"><img width='16' height='16' src=\"".$img_collapse."\" border=no></a></td>";         
      }
      else
      {
        /*************************/
        /* Tree Leaf             */
        /*************************/

        echo "<td width=16><img width='16' height='16' src=\"".$img_leaf."\"></td>";         
      }
      
      /****************************************/
      /* output item text                     */
      /****************************************/
	  if ($include_del==1){
		  if ($tree[$cnt][2]=="")
			  echo "<td align='left' colspan=".($maxlevel-$tree[$cnt][0])." class='tree_ma'>".$tree[$cnt][1]."</td><td>&nbsp;</td>";
		  elseif ($tree[$cnt][6]==0)
			  echo "<td align='left' colspan=".($maxlevel-$tree[$cnt][0])." class='tree_ma'><a href=\"".$tree[$cnt][2]."\" class='tree_ma1' target=\"".$tree[$cnt][3]."\">".$tree[$cnt][1]."</a></td><td>".(($tree[$cnt][5]>0)?"  [  <img src='icon/del.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Menghapus' onClick=\"if (confirm('Yakin Ingin Menghapus Data ?')){fSetValue(window,'".$tree[$cnt][7]."');document.form1.submit();}\">   ]":"&nbsp;")."</td>";
		  else
			  echo "<td align='left' colspan=".($maxlevel-$tree[$cnt][0])." class='tree_ma'><a href=\"".$tree[$cnt][2]."\" target=\"".$tree[$cnt][3]."\">".$tree[$cnt][1]."</a></td><td>".(($tree[$cnt][5]>0)?"  [  <img src='icon/del.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Menghapus' onClick=\"if (confirm('Yakin Ingin Menghapus Data ?')){fSetValue(window,'".$tree[$cnt][7]."');document.form1.submit();}\">   ]":"&nbsp;")."</td>";	  
			  
	  }else{
		  if ($tree[$cnt][2]=="")
			  echo "<td colspan=".($maxlevel-$tree[$cnt][0])." class='tree_ma'>".$tree[$cnt][1]."</td>";
		  elseif ($tree[$cnt][6]==0)
			  echo "<td colspan=".($maxlevel-$tree[$cnt][0])." class='tree_ma'><a href=\"".$tree[$cnt][2]."\" class='tree_ma1' target=\"".$tree[$cnt][3]."\">".$tree[$cnt][1]."</a></td>";
		  else
			  echo "<td colspan=".($maxlevel-$tree[$cnt][0])." class='tree_ma'><a href=\"".$tree[$cnt][2]."\" target=\"".$tree[$cnt][3]."\">".$tree[$cnt][1]."</a></td>";	  
			  //echo "tree5=".$tree[$cnt][5];
      }
	  /****************************************/
      /* end row                              */
      /****************************************/
             
      echo "</tr>\n";      
    }
    $cnt++;    
  }
  echo "</table>\n";
?>

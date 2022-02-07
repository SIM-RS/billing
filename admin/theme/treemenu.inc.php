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

  if(isset($PATH_INFO)) {
	  $script       =  $PATH_INFO; 
  } else {
	  $script	=  $SCRIPT_NAME;
  }

  $img_expand   = "../images/tree_expand.gif";
  $img_collapse = "../images/tree_collapse.gif";
  $img_line     = "../images/tree_vertline.gif";  
  $img_split	= "../images/tree_split.gif";
  $img_end      = "../images/tree_end.gif";
  $img_leaf     = "../images/tree_leaf.gif";
  $img_spc      = "../images/tree_space.gif";

// $expand=array();
// $visible=array();
// $levels=array();
// $explevels=array();
//echo count($tree)."<br>";
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
  echo "<tr valign='top'>";
  for ($i=0; $i<$maxlevel; $i++) echo "<td width=16></td>";
  echo "<td valign='top' width=100%>&nbsp;</td></tr>\n";
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
      echo "<tr valign='top' class=$rowStyle onMouseOver=\"this.className='MoverBG'\" onMouseOut=\"this.className='$rowStyle'\">";
      
      /****************************************/
      /* vertical lines from higher levels    */
      /****************************************/
      $i=0;
      while ($i<$tree[$cnt][0]-1) 
      {
        if ($levels[$i]==1)
            echo "<td><a name='$cnt'></a><img src=\"".$img_line."\"></td>";
        else
            echo "<td><a name='$cnt'></a><img src=\"".$img_spc."\"></td>";
        $i++;
      }
      
      /****************************************/
      /* corner at end of subtree or t-split  */
      /****************************************/         
      if ($tree[$cnt][4]==1) 
      {
        echo "<td><img src=\"".$img_end."\"></td>";
        $levels[$tree[$cnt][0]-1]=0;
      }
      else
      {
        echo "<td><img src=\"".$img_split."\"></td>";                  
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
            echo "<td><a href=\"".$script.$params."#$cnt\"><img src=\"".$img_expand."\" border=no></a></td>";
        else
            echo "<td><a href=\"".$script.$params."#$cnt\"><img src=\"".$img_collapse."\" border=no></a></td>";         
      }
      else
      {
        /*************************/
        /* Tree Leaf             */
        /*************************/

        echo "<td><img src=\"".$img_leaf."\"></td>";         
      }
      
      /****************************************/
      /* output item text                     */
      /****************************************/
      if ($tree[$cnt][2]=="")
          echo "<td colspan=".($maxlevel-$tree[$cnt][0])." class='tree_ma'>".$tree[$cnt][1]."</td>";
      else
          echo "<td colspan=".($maxlevel-$tree[$cnt][0])." class='tree_ma'><a href=\"".$tree[$cnt][2]."\" target=\"".$tree[$cnt][3]."\">".$tree[$cnt][1]."</a>".(($tree[$cnt][5]>0)?"  [  <img src='../icon/del.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Menghapus' onClick=\"if (confirm('Yakin Ingin Menghapus Data ?')){fSetValue(window,'act*-*delete*|*idma*-*".$tree[$cnt][5]."');document.form1.submit();}\">   ]":"")."</td>";
          //echo "tree5=".$tree[$cnt][5];
      /****************************************/
      /* end row                              */
      /****************************************/
              
      echo "</tr>\n";      
    }
    $cnt++;    
  }
  echo "</table>\n";
?>

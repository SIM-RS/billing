function addRowToTable(tblID,RowClsName,RowMouseOverClsName,RowMouseOutClsName,ColElement)
{
//use browser sniffing to determine if IE or Opera (ugly, but required)
	var isIE = false;
	if(navigator.userAgent.indexOf('MSIE')>0){isIE = true;}
//	alert(navigator.userAgent);
//	alert(isIE);
  var tbl = document.getElementById(tblID);
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow;
  var row = tbl.insertRow(lastRow);
  	//row.id = 'row'+(iteration-1);
  	row.className = RowClsName;
	//row.setAttribute('class', 'itemtable');
	row.onmouseover = function(){this.className=RowMouseOverClsName;};
	row.onmouseout = function(){this.className=RowMouseOutClsName;};
	//row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
	//row.setAttribute('onMouseOut', "this.className='itemtable'");
  var cellItem,NodeItem,ArElement;
  var ColEl=ColElement.split("||");
  	for (var it=0;it<ColEl.length;it++){
	  ArElement=ColEl[it].split("*|*");
	  cellItem = row.insertCell(it);
	  if (ArElement[0]=="textNode"){
	  	NodeItem = document.createTextNode(iteration-2);
	  }else if(ArElement[0]=="text"){
		  if(!isIE){
			NodeItem = document.createElement('input');
			NodeItem.name = 'obatid';
		  }else{
			NodeItem = document.createElement('<input name="obatid"/>');
		  }
		  NodeItem.type = 'text';
		  NodeItem.value = '';
	  }
	  cellItem.className = ArElement[1];
	  cellItem.appendChild(NodeItem);
	  
	  // right cell
	  cellItem = row.insertCell(1);
	  
	  cellItem.className = 'tdisi';
	  cellItem.appendChild(NodeItem);
	}
}
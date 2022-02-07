
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- end untuk ajax-->
<title>RESUM MEDIS</title>
	<style>
    .gb{
    border-bottom:1px solid #000000;
    }
    .inputan{
    width:80px;
    }
    .textArea{ width:97%;}
    body{background:#FFF;}
    </style>
    </head>
<body> 

<table width="781" border="1" id="tblObat" cellpadding="2" style="border-collapse:collapse;">
    <tr>
    	<td colspan="13" align="right"><input type="button" name="button" id="button" value="Tambah" onClick="addRowToTable();return false;"/></td>
    </tr>
    <tr>
        <td rowspan="2" align="center">Nama Obat</td>
        <td rowspan="2" align="center">Jumlah</td>
        <td rowspan="2" align="center">Dosis</td>
        <td rowspan="2" align="center">Frekuensi</td>
        <td rowspan="2" align="center">Cara Pemberian</td>
        <td colspan="6" align="center">Jam Pemberian</td>
        <td rowspan="2" align="center">Petunjuk Khusus</td>
        <td rowspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
    </tr>
    <tr>
        <td align="center"><label for="txt_obat[]"></label>
        <input name="txt_obat[]" type="text" class="inputan" id="txt_obat[]" /></td>
        <td align="center"><input name="txt_jumlah[]" type="text" id="txt_jumlah[]" size="5" /></td>
        <td align="center"><input name="txt_dosis[]" type="text" id="txt_dosis[]" size="5" /></td>
        <td align="center"><input name="txt_frek[]" type="text" id="txt_frek[]" size="5" /></td>
        <td align="center"><input name="txt_beri[]" type="text" class="inputan" id="txt_beri[]" /></td>
        <td align="center"><input name="txt_jam1[]" type="text" id="txt_jam1[]" size="5" /></td>
        <td align="center"><input name="txt_jam2[]" type="text" id="txt_jam2[]" size="5" /></td>
        <td align="center"><input name="txt_jam3[]" type="text" id="txt_jam3[]" size="5" /></td>
        <td align="center"><input name="txt_jam4[]" type="text" id="txt_jam4[]" size="5" /></td>
        <td align="center"><input name="txt_jam5[]" type="text" id="txt_jam5[]" size="5" /></td>
        <td align="center"><input name="txt_jam6[]" type="text" id="txt_jam6[]" size="5" /></td>
        <td align="center"><input name="txt_petunjuk[]" type="text" class="inputan" id="txt_petunjuk[]" /></td>
        <td align="center" valign="middle"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}"></td>
    </tr>
</table>
                      
             
    </body>
<script type="text/javascript">

	
 function addRowToTable()
        {
            //use browser sniffing to determine if IE or Opera (ugly, but required)
            var isIE = false;
            if(navigator.userAgent.indexOf('MSIE')>0){
                isIE = true;
            }
            //	alert(navigator.userAgent);
            //	alert(isIE);
            var tbl = document.getElementById('tblObat');
            var lastRow = tbl.rows.length;
            // if there's no header row in the table, then iteration = lastRow + 1
            var iteration = lastRow;
            var row = tbl.insertRow(lastRow);
            //row.id = 'row'+(iteration-1);
            row.className = 'itemtableA';
            //row.setAttribute('class', 'itemtable');
            row.onmouseover = function(){this.className='itemtableAMOver';};
            row.onmouseout = function(){this.className='itemtableA';};
           
            // right cell
            var cellRight = row.insertCell(0);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_obat[]';
                el.id = 'txt_obat[]';
            }else{
                el = document.createElement('<input name="txt_obat[]"/>');
            }
            el.type = 'text';
            el.className = 'inputan';
            el.value = '';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

            if("<?php echo $edit;?>" == true){
                //generate id
                if(!isIE){
                    el = document.createElement('input');
                    el.name = 'id';
                    el.id = 'id';
                }else{
                    el = document.createElement('<input name="id" id="id" />');
                }
                el.type = 'text';
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);
            }

 // right cell
            var cellRight = row.insertCell(1);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jumlah[]';
                el.id = 'txt_jumlah[]';
            }else{
                el = document.createElement('<input name="txt_jumlah[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;
            

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_dosis[]';
                el.id = 'txt_dosis[]';
            }else{
                el = document.createElement('<input name="txt_dosis[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(3);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_frek[]';
                el.id = 'txt_frek[]';
            }else{
                el = document.createElement('<input name="txt_frek[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;
            

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(4);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_beri[]';
                el.id = 'txt_beri[]';
            }else{
                el = document.createElement('<input name="txt_beri[]"/>');
            }
            el.type = 'text';
            el.value = '';
            el.className = 'inputan';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(5);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam1[]';
                el.id = 'txt_jam1[]';
            }else{
                el = document.createElement('<input name="txt_jam1[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(6);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam2[]';
                el.id = 'txt_jam2[]';
            }else{
                el = document.createElement('<input name="txt_jam2[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(7);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam3[]';
                el.id = 'txt_jam3[]';
            }else{
                el = document.createElement('<input name="txt_jam3[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(8);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam4[]';
                el.id = 'txt_jam4[]';
            }else{
                el = document.createElement('<input name="txt_jam4[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(9);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam5[]';
                el.id = 'txt_jam5[]';
            }else{
                el = document.createElement('<input name="txt_jam5[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(10);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam6[]';
                el.id = 'txt_jam6[]';
            }else{
                el = document.createElement('<input name="txt_jam6[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(11);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_petunjuk[]';
                el.id = 'txt_petunjuk[]';
            }else{
                el = document.createElement('<input name="txt_petunjuk[]"/>');
            }
            el.type = 'text';
            el.value = '';
            el.className = 'inputan';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
 // right cell
                cellRight = row.insertCell(12);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
                }
                el.src = '../../icon/del.gif';
                el.border = "0";
                el.width = "16";
                el.height = "16";
                el.className = 'proses';
                el.align = "absmiddle";
                el.title = "Klik Untuk Menghapus";

                //  cellRight.setAttribute('class', 'tdisi');
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);

               
  cellRightSel.appendChild(sel);
              
    }
function removeRowFromTable(cRow)
	{
        var tbl = document.getElementById('tblObat');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 4)
		{
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=3;i<lastRow;i++)
			{
                var tds = tbl.rows[i].getElementsByTagName('td');
                //tds[0].innerHTML=i-2;
            }
        }
    }
    </script>
    
</html>

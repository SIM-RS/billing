function fCheckAll(p,q){
	if (p.checked==true){
		if (q.length){
			for (var i=0;i<q.length;i++){
				if (!q[i].disabled) q[i].checked=true;
			}
		}else if (!q.disabled) q.checked=true;
		p.title='Tidak Dipilih Semua';
	}else{
		if (q.length){
			for (var i=0;i<q.length;i++) q[i].checked=false;
		}else q.checked=false;
		p.title='Pilih Semua';
	}
}

function fCheckAll1(p,q){
	if (p.checked==true){
		if (q.length){
			for (var i=0;i<q.length;i++) q[i].checked=true;
		}else if (!q.disabled) q.checked=true;
	}else{
		if (q.length){
			for (var i=0;i<q.length;i++) q[i].checked=false;
		}else q.checked=false;
	}
}

function fSubmit(p,q,r){
var t=false;
var issame='';
var issametmp='';
var chkke=0;
	if (q.length){
		var s='';
		var m='';
		for (var k=0;k<q.length;k++){
			if (q[k].checked==true){
				chkke++;
				s +=q[k].value+'**';
				if (chkke==1){
					issametmp=q[k].value.split('|');
					issame=issametmp[4];
					//alert(r.value);
					//alert(issame);
					if (r.value!="" && r.value!=issame){
						alert('Kategori Material Yang Dipilih Harus '+r.value+' !');
						return false;
					}
				}else{
					issametmp=q[k].value.split('|');
					//alert(issametmp[4]);
					if (issame!=issametmp[4]){
						alert('Kategori Material Yang Dipilih Harus Sama !');
						return false;
					}					
				}
			}
		}
		if (s==''){
			alert('Pilih Item Barang Terlebih Dahulu !');
			return false;
		}else{
			s=s.substr(0,s.length-2);
			var w=s.split('**');
			var x;
			var y=',';
			for (var j=0;j<w.length;j++){
				x=w[j].split('|');
				if (y.indexOf(','+x[1]+',')<0){
					y +=x[1]+',';
					for (var k=j+1;k<w.length;k++){
						z=w[k].split('|');
						if (x[1]==z[1]){
							x[0]=x[0]+','+z[0];
							x[2]=parseFloat(x[2])+parseFloat(z[2]);
							x[3]=(x[3]>z[3])?x[3]:z[3];
						}
					}
					m +=x[0]+'|'+x[1]+'|'+x[2]+'|'+x[3]+'||';
				}
			}
			m=m.substr(0,m.length-2);
			p.value=m;
			//alert(m);
			document.forms[0].submit();
		}
	}else if (q.checked==true){
		issametmp=q.value.split('|');
		if (r.value!="" && r.value!=issametmp[4]){
			alert('Kategori Material Yang Dipilih Harus '+r.value+' !');
			return false;
		}
		p.value=q.value;
		document.forms[0].submit();
	}else{
		alert('Pilih Item Barang Terlebih Dahulu !');
		return false;
	}
}

function fKirim(p,q,a,b){
var t=false;
var c='';
	if (q.length){
		var s='';
		var m='';
		for (var k=0;k<q.length;k++){
			if (q[k].checked==true){
				s +=q[k].value+'**';
				if (b[k].value==''||b[k].value=='0'){
					alert('Jumlah Barang Yg Mau Ditambahkan ke Item Pengiriman ke Bengkel Harus Lebih Dari 0 !');
					return false;
				}else{
					c +=b[k].value+'|';
				}
			}
		}
		if (s==''){
			alert('Pilih Item Barang Terlebih Dahulu !');
			return false;
		}else{
			s=s.substr(0,s.length-2);
			c=c.substr(0,c.length-1);
			var w=s.split('**');
			var x;
			var y=',';
			for (var j=0;j<w.length;j++){
				x=w[j].split('|');
				if (y.indexOf(','+x[1]+',')<0){
					y +=x[1]+',';
					for (var k=j+1;k<w.length;k++){
						z=w[k].split('|');
						if (x[1]==z[1]){
							x[0]=x[0]+','+z[0];
							x[2]=parseFloat(x[2])+parseFloat(z[2]);
							x[3]=(x[3]>z[3])?x[3]:z[3];
						}
					}
					m +=x[0]+'|'+x[1]+'|'+x[2]+'|'+x[3]+'||';
				}
			}
			m=m.substr(0,m.length-2);
			p.value=m;
			a.value=c;
			//alert(m);
			//alert(c);
			document.forms[0].submit();
		}
	}else if (q.checked==true){
		p.value=q.value;
		a.value=b.value;
		//alert(p.value);alert(a.value);
		document.forms[0].submit();
	}else{
		alert('Pilih Item Barang Terlebih Dahulu !');
		return false;
	}
}

function fTerimaPO(p,q,a,b,d){
var c='';
var e;
	if (q.length){
		var s='';
		var m='';
		for (var k=0;k<q.length;k++){
			if (q[k].checked==true){
				s +=q[k].value+'-';
				if (b[k].value==''){
					alert('Jumlah Barang Yg Diterima Harus Diisi !');
					return false;
				}else{
					c +=b[k].value+'-';
				}
//				alert(d);
//				alert(q[k].value);
/*				e=q[k].value.split('|');
//				alert(e[2]);
				if (e[2]!=d){
					alert('Tidak Boleh Menerima Material Kategori '+e[2]);
					return false;					
				}
*/			}
		}
		if (s==''){
			alert('Pilih Item Barang Terlebih Dahulu !');
			return false;
		}else{
			s=s.substr(0,s.length-1);
			c=c.substr(0,c.length-1);
			p.value=s;
			a.value=c;
			//alert(p.value);alert(a.value);
		}
	}else if (q.checked==true){
/*		e=q.value.split('|');
		if (e[2]!=d){
			alert('Tidak Boleh Menerima Material Kategori '+e[2]);
			return false;					
		}
*/
		if (b.value==''){
			alert('Jumlah Barang Yg Diterima Harus Diisi !');
			return false;
		}else{
			p.value=q.value;
			a.value=b.value;
			//alert(p.value);alert(a.value);
		}		
	}else{
		alert('Pilih Item Barang Terlebih Dahulu !');
		return false;
	}
}

function ReadfromText(a,b){
	if (b.length){
		alert('>1');
	}else{
		alert('=1');
	}
}

function fPilihItemPo(a,b){
var s='';
	if (b.length){
		for (var x=0;x<b.length;x++){
			if (b[x].checked==true) s +=b[x].value+'-';
		}
//		alert(s);
		if (s!=''){
			s=s.substr(0,s.length-1);
			a.value=s;
			document.forms[0].submit();
		}else{
			alert('Pilih Item Terlebih Dahulu !');
			return false;
		}
	}else{
		if (b.checked==false){
			alert('Pilih Item Terlebih Dahulu !');
			return false;
		}else{
			a.value=b.value;
			document.forms[0].submit();
		}
	}
}

function fSesEproc(a,b,c,d,p,q){
var e='';
var f='';
var g='';
var h,i;
	if (b.length){
		//alert(b.length);
		for (var j=0;j<b.length;j++){
			if (b[j].value!=''){
				i=b[j].value;
				h=i.split('-');				
				e +=h[2]+'-'+h[1]+'-'+h[0]+'|';
				f +=d[j].value+'|';
				g +=q[j].value+'|';
			}
		}
		if (e==''){
			alert('Isikan Tgl Session eProc Terlebih Dahulu !');
			return false;			
		}else{
			e=e.substr(0,e.length-1);
			f=f.substr(0,f.length-1);
			g=g.substr(0,g.length-1);
			a.value=e;
			c.value=f;
			p.value=g;
		}
	}else if (b.value!=''){
		//alert('jml=1');
		i=b.value;
		h=i.split('-');
		a.value=h[2]+'-'+h[1]+'-'+h[0];
		c.value=d.value;
		p.value=q.value;
	}else{
		alert('Isikan Tgl Session eProc Terlebih Dahulu !');
		return false;
	}
	//alert(a.value);alert(c.value);alert(p.value);
	document.forms[0].submit();
}

function fTerima(p,q,a){
var c=a.value.split('|');
	//alert(q.length);alert(a.value);
	if (q.length){
		var s='';
		for (var k=0;k<q.length;k++){
			s +=q[k].value+'-';
		}
		s=s.substr(0,s.length-1);
		var m=c[1].split('-');
		var n=s.split('-');
		var r=c[0].split('-');
		s='';
		for (var ix=0;ix<n.length;ix++){
			s +=r[ix]+'-'+n[ix]+'|';
		}
		p.value=s.substr(0,s.length-1);
		if (c[1]!=s){
			document.forms[0].sama.value='false';
		}
		//alert(p.value);
		document.forms[0].submit();
	}else{
		//alert(q.value);
		p.value=c[0]+'-'+q.value;
		if (q.value!=c[1]){
			document.forms[0].sama.value='false';
		}
		//alert(p.value);
		document.forms[0].submit();
	}
}

function fEnable(a,b){
var c=a.split(',');
var d=b.split('-');
	for (var i=0;i<c.length;i++){
		document.getElementById(c[i]).disabled='';
	}
	document.getElementById(d[0]).value=d[1];
}

function fDisable(a,b){
var c=a.split(',');
var d=b.split('-');
	for (var i=0;i<c.length;i++){
		document.getElementById(c[i]).disabled='disabled';
	}
	document.getElementById(d[0]).value=d[1];
}

function GoEditMs_Brg(p,q,r,s,t){
	//alert(p);alert(q);alert(r);alert(s);alert(t);
	document.forms[0].k_brg.value=q;
	document.forms[0].n_brg.value=r;
	document.forms[0].j_brg.value=s;
	//document.forms[0].cb_kat.value=t;
	document.forms[0].save.value="Update";
}

function ValidateForm(par,lng){
var arpar;
	//alert(par+'|'+lng);
	arpar=par.split(",");
	for (var i=0;i<arpar.length;i++){
		if (document.getElementById(arpar[i]).value==""){
			if (lng=="eng"){
				alert('Please, Fill Form Completely');
			}else{
				alert("Pengisian Form Belum Lengkap");
			}
			document.getElementById(arpar[i]).focus();
			return false;
		}
	}
	return true;
}

function EditForm(par){
var arpar,arfname,arfvalue;
	arpar=par.split("||");
	arfname=arpar[0].split(",");
	arfvalue=arpar[1].split("*-*");
	//alert(arpar[0]);alert(arpar[1]);
	for (var i=0;i<arfname.length;i++){
		//alert(arfvalue[i]);
		arfvalue[i]=arfvalue[i].replace(String.fromCharCode(5),"'");
		if (document.getElementById(arfname[i]).options){
			//alert(document.getElementById(arfname[i]).options.length);
			for (var j=0;j<document.getElementById(arfname[i]).options.length;j++){
				if (document.getElementById(arfname[i]).options[j].value==arfvalue[i]){
					document.getElementById(arfname[i]).options[j].selected=true;
					j=document.getElementById(arfname[i]).options.length;
				}
			}
		}else{
			//alert(document.getElementById(arfname[i]).type);
			//if (document.getElementById(arfname[i]).type=='checkbox'){
			//}else{
				document.getElementById(arfname[i]).value=arfvalue[i];
			//}
		}
	}
}

function getSelectedOption(opt) {
var selected = new Array();
var index = 0;
	for (var intLoop=0; intLoop < opt.length; intLoop++) {
		 if (opt[intLoop].selected) {
			index = selected.length;
			selected[index] = new Object;
			selected[index].value = opt[intLoop].value;
			selected[index].index = intLoop;
		 }
	}
	return selected;
}
   
function getSelectedCheck(opt) {
var selected = new Array();
var index = 0;
	if (opt.length){
		for (var intLoop = 0; intLoop < opt.length; intLoop++) {
		   if ((opt[intLoop].selected) ||
			   (opt[intLoop].checked)) {
			  index = selected.length;
			  selected[index] = new Object;
			  selected[index].value = opt[intLoop].value;
			  selected[index].index = intLoop;
		   }
		}
	}else{
		index = selected.length;
		selected[index] = new Object;
		if (opt.checked){
			selected[index].value = opt.value;
		}else{
		  	selected[index].value = "";
		}
		selected[index].index = 0;
	}
	return selected;
}

function outputSelectedOption(opt) {
var sel = getSelectedOption(opt);
var strSel = ",";
	for (var item in sel)       
	   strSel += sel[item].value + ",";
	if (strSel==",") strSel="";
	return strSel;
}

function outputSelectedCheck(opt) {
var sel = getSelectedCheck(opt);
var strSel = "";
	for (var item in sel)       
	   strSel += sel[item].value + ",";
	if (strSel!="") strSel=strSel.substr(0,strSel.length-1);
	return strSel;
}

function outputSelectedCheck1(opt) {
var sel = getSelectedCheck(opt);
var strSel = "";
var sama="";
var x;
	for (var item in sel){
	   strSel += sel[item].value + ",";
	   if (sama==""){
	   		x=sel[item].value;
			x=x.split("-");
	   		sama=x[1];	
	   }else{
	   		x=sel[item].value;
			x=x.split("-");
	   		if (sama!=x[1]){
				alert("Kode Mata Anggaran Yang Dipilih Tidak Sama !");
				return false;
			}	
	   }
	}
	if (document.getElementById("idma").value==""){
		document.getElementById("idma").value=sama;
	}else{
		if (document.getElementById("idma").value!=sama){
			alert("Kode Mata Anggaran Yang Dipilih Tidak Sama !");
			return false;
		}
	}
	if (strSel!="") strSel=strSel.substr(0,strSel.length-1);
	return strSel;
}

function Confirm(p){
var resp=confirm(p);
	return false;
}

function fSetValue(obj,par){
var tpar=par;
var vtpar;
	while (tpar.indexOf(String.fromCharCode(5))>0){
		tpar=tpar.replace(String.fromCharCode(5),"'");
	}
	while (tpar.indexOf(String.fromCharCode(3))>0){
		tpar=tpar.replace(String.fromCharCode(3),'"');
	}
	tpar=tpar.split('*|*');
	for (var i=0;i<tpar.length;i++){
		vtpar=tpar[i].split('*-*');
		//alert(vtpar[0]+"="+obj.document.getElementById(vtpar[0]).length);
		//alert(vtpar[1]);
		if (obj.document.getElementById(vtpar[0]).length){
			//alert(obj.document.getElementById(vtpar[0]).selected[j].value);
			for (var j=0;j<obj.document.getElementById(vtpar[0]).length;j++){
				//alert(obj.document.getElementById(vtpar[0])[j].value);
				if (obj.document.getElementById(vtpar[0])[j].value==vtpar[1]) obj.document.getElementById(vtpar[0]).selectedIndex=j;
			}
		}else{
			switch(obj.document.getElementById(vtpar[0]).type){
				case 'text':
					obj.document.getElementById(vtpar[0]).value=vtpar[1];
					break;
				case 'hidden':
					obj.document.getElementById(vtpar[0]).value=vtpar[1];
					break;
				case 'radio':
					if(vtpar[1]=='true')
					obj.document.getElementById(vtpar[0]).checked=true;
					else
					obj.document.getElementById(vtpar[0]).checked=false;
					break;
				case 'checkbox':
					if(vtpar[1]=='true')
					obj.document.getElementById(vtpar[0]).checked=true;
					else
					obj.document.getElementById(vtpar[0]).checked=false;					
					break;
				case 'button':
					if(vtpar[1]=='true')
					obj.document.getElementById(vtpar[0]).disabled=true;
					else if(vtpar[1]=='false')
					obj.document.getElementById(vtpar[0]).disabled=false;
					else
					obj.document.getElementById(vtpar[0]).value=vtpar[1];
					break;
			}
			
			
		}
	}
	//window.close();
}

function fSetValueArray(obj,par,idx){
var tpar=par;
var vtpar;
	while (tpar.indexOf(String.fromCharCode(5))>0){
		tpar=tpar.replace(String.fromCharCode(5),"'");
	}
	while (tpar.indexOf(String.fromCharCode(3))>0){
		tpar=tpar.replace(String.fromCharCode(3),'"');
	}
	tpar=tpar.split('*|*');
	//for (var i=0;i<tpar.length;i++){
		vtpar=tpar[0].split('*-*');
		obj.document.forms[0].id_sak[idx].value=vtpar[1];
		vtpar=tpar[1].split('*-*');
		obj.document.forms[0].kode_sak[idx].value=vtpar[1];
		vtpar=tpar[2].split('*-*');
		obj.document.forms[0].nama_sak[idx].value=vtpar[1];
		//obj.document.getElementById(vtpar[0])[idx].value=vtpar[1];
	//}
	//window.close();
}

function OpenWnd(tujuan,pWidth,pHeight,WindowName,args) {
	var features = "toolbar=false,menubar=false,status=false,resizeable=false,scrollbars=yes";
	var left = new Number((window.screen.width - pWidth) / 2);
	var top = new Number((window.screen.height - pHeight) / 2);
	features += ",width=" + pWidth.toString() + "px";
	features += ",left=" + left.toString() + "px";
	features += ",height=" + pHeight.toString() + "px";
	features += ",top=" + top.toString() + "px";
	window.open(tujuan, WindowName, features);
}

function fSetArchkjd(p){
var s="";
	for (var i=0;i<4;i++){
		//alert(document.form1.chkjd[i].checked);
		if (p[i].checked){
			s=s+"1-";
		}else{
			s=s+"0-";
		}
	}
	s=s.substr(0,s.length-1);
	document.form1.archkjd.value=s;
}

function fCekIsNaN(p){
var r=p.split("|");
var q;
	for (var j=0;j<r.length;j++){
		q=p.split(",");
		//for (var i=0;i<q.length;i++){
			if (isNaN(document.getElementById(q[1]).value)){
				alert("Input "+q[0]+" Harus Angka !");
				document.getElementById(q[1]).focus();
				return false;
			}
		//}
	}
	return true;
}

function fGetXYObj(aTag){
  var p=[0,0];
  while(aTag!=null){
  	p[0] +=aTag.offsetLeft;
  	p[1] +=aTag.offsetTop;
  	aTag=aTag.offsetParent;
  }
  return p;
}

function fSetPosisi(obj,pc){
  var p=fGetXYObj(pc);
  with (obj.style) {
  	left=p[0]-1;
	top=p[1]+pc.offsetHeight+1;
  }
}

function FormatNum(num,dec){
var k=num.toString();
var g="";
var p=0;
var sisa=0;
var tmp;
var x="";
	if (k.indexOf('.')>-1){
		x=k.substr(k.indexOf('.')+1,k.length-k.indexOf('.'));
		k=k.substr(0,k.indexOf('.'));
		if (x.length>dec){
			var d;
			for (var j=x.length;j>dec;j--){
				d=x.substr(j-1,1);
				//alert(parseInt(d));
				if ((parseInt(d)+sisa)>4){
					sisa=1;
				}else{
					sisa=0;
				}
			}
			//alert(sisa);
			x=x.substr(0,dec);
			var m=(parseInt(x)+sisa).toString();
			if (m.length>x.length){
				k=(parseInt(k)+1).toString();
				x=m.substr(1,dec);
			}else{
				x=m;
			}
		}else if (x.length<dec){
			for (var h=0;h<(dec-x.length);h++) x=x+"0";
		}
	}else{
		for (var h=0;h<dec;h++) x=x+"0";
	}
	if (x=="") k=k; else k=k+'.'+x;
	//alert(k);
	return k;
}

function FormatNumberFloat(num,dec,dec_char,dec_char_asal){
var k=num.toString();
var g="";
var p=0;
var sisa=0;
var tmp;
var x="";
	if (k.indexOf(dec_char_asal)>-1){
		x=k.substr(k.indexOf(dec_char_asal)+1,k.length-k.indexOf(dec_char_asal));
		k=k.substr(0,k.indexOf(dec_char_asal));
		if (x.length>dec){
			var d;
			for (var j=x.length;j>dec;j--){
				d=x.substr(j-1,1);
				//alert(parseInt(d));
				if ((parseInt(d)+sisa)>4){
					sisa=1;
				}else{
					sisa=0;
				}
			}
			//alert(sisa);
			x=x.substr(0,dec);
			var m=(parseInt(x)+sisa).toString();
			if (m.length>x.length){
				k=(parseInt(k)+1).toString();
				x=m.substr(1,dec);
			}else{
				x=m;
			}
		}else if (x.length<dec){
			for (var h=0;h<(dec-x.length);h++) x=x+"0";
		}
	}else{
		for (var h=0;h<dec;h++) x=x+"0";
	}
	if (x=="") k=k; else k=k+dec_char+x;
	//alert(k);
	return k;
}

function FormatNumberFloor(num,thousand_char){
var k=num.toString();
var tmp;
var x="";
	if (k.length>3){
		while (k.length>3){
			x=thousand_char+k.substr(k.length-3,3)+x;
			k=k.substr(0,k.length-3);
		}
		tmp=k+x;
		if (tmp.substr(0,2)=="-.") tmp="-"+tmp.substr(2,tmp.length-2);
	}else{
		tmp=k;
	}
	return tmp;
}

function SetFocus(e,par){
var tmp=par.split("|");
var keyp;
var pos;
	if(window.event) {
	  keyp = window.event.keyCode; 
	}
	else if(e.which) {
	  keyp = e.which;
	}
	//alert(keyp);
	if ((keyp==37)&&(tmp[0]!="")){
		if (o.createTextRange) {
			var r = document.selection.createRange().duplicate();
			r.moveEnd('character', o.value.length);
			if (r.text == '') pos=o.value.length;
			else pos=o.value.lastIndexOf(r.text);
		} else pos=o.selectionStart;
		if (pos==0){
			document.getElementById(tmp[0]).focus();
		}
	}else if((keyp==38)&&(tmp[1]!="")){
		document.getElementById(tmp[1]).focus();
	}else if((keyp==39)&&(tmp[2]!="")){
		if (o.createTextRange) {
			var r = document.selection.createRange().duplicate();
			r.moveStart('character', -o.value.length);
			pos=r.text.length;
		} else pos=o.selectionEnd;
		if (pos==o.value.length){
			document.getElementById(tmp[2]).focus();
		}
	}else if((keyp==40)&&(tmp[3]!="")){
		document.getElementById(tmp[3]).focus();
	}
}
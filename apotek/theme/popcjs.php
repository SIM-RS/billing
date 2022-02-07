<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><!-- This file is NON-EDITABLE! Any modification to this file must get authority from the author!!! --><title>PopCalendarXP 3.20, By Liming(Victor) Weng, email: popcal@yahoo.com</title>

<script language="JavaScript">
var gd=new Date();
var gToday=[gd.getFullYear(),gd.getMonth()+1,gd.getDate()];
var agenda=new Array;
var gfSelf=parent.document.getElementById(self.name);
var theme=self.name.split(":");
var gCurMonth=eval(theme[0]);

parent.gfPop=parent.frames[self.name];

function addEvent(date, message, color, action, imgsrc) {
  agenda[date] = new Array(message, color, action, imgsrc);
}

function popup(url, framename) {
  self.open(url,framename,gsPopConfig);
}

with (document) {
	write("<link rel='stylesheet' type='text/css' href='"+theme[1]+".css'>");
	write("<script language='JavaScript' src='"+theme[1]+".js'></scr"+"ipt>");
	write("<script language='JavaScript' src='"+theme[2]+"'></scr"+"ipt>");
}
</script><link rel="stylesheet" type="text/css" href="popcjs_data/normal.css"><script language="JavaScript" src="popcjs_data/normal.js"></script><script language="JavaScript" src="popcjs_data/agenda.js"></script></head>


<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onmouseup="self.status='';return true;">
<script language="JavaScript">
//*******************************************************
// PopCalendarXP 3.20 (emailware), by Liming(Victor) Weng
// Release date: 2001.6.20		Email: popcal@yahoo.com
// Notice:
// 1. This emailware is only free for private use, and must mail me first!
// 2. For any commercial use, contact me to pay a small amount of license fee.
// 3. Please respect my hard work. Any usage of or modification to this script without
//    the authorization from the author may be sued for a reimbursement up to USD$10,000 !!!
// 4. This script is unlicensed, report to the author if you find it on a commercial site.
//*******************************************************
var tanggal=new Date();

var gBegin=[tanggal.getFullYear()-100,1,1];	// Valid Range begin from [Year,Month,Date]
var gEnd=[tanggal.getFullYear()+10,12,31];	// Valid Range end at [Year,Month,Date]
//var	gBegin=[2003,1,1];	// Valid Range begin from [Year,Month,Date]
//var	gEnd=[2013,12,31];	// Valid Range end at [Year,Month,Date]
	
var gdBegin,gdEnd,gRange;
var gdSelect=[0,0,0];
var gcbMon,gcbYear;
var gdCtrl;
var gcTemp=gcBG;
var gCellSet=[];
var giSat=(gbEuroCal)?5:6;
var giSun=(gbEuroCal)?6:0;
var evDate='';
if (gbEuroCal)
	gWeekDay=[].concat(gWeekDay.slice(1), gWeekDay[0]);
var cal=[];
for (var i=0;i<6;i++)
  	cal[i]=[];

//****************************************************************************
// dateCtrl is the widget into which you want to put the selected date;
// range is an array in this format [RangeBeginDate, RangeEndDate {,disabledDate}]
//****************************************************************************
function fPopCalendar(dateCtrl,range,ev){
  var pc=dateCtrl;
  if (ev) evDate=ev;
  if (gdCtrl!=pc)
	gdCtrl=pc;
  else if (gfSelf.style.visibility=="visible") {
	fHideCal();
	return;
  }
  var s=fParseDate(gdCtrl.value);
  if (s==null) {
	s=eval(theme[0]);
	gdSelect=[0,0,0];
  } else
	gdSelect=s;
  fInitRange(range);
  if (!fSetCal(s[0], s[1])) {
  	fHideCal();
	return;
  }
  var p=fGetXY(pc);
  with (gfSelf.style) {
  	left=parseInt(p[0])-1+"px";
	top =parseInt(p[1])+pc.offsetHeight+1+"px";
	visibility="visible";
  }
}

function fHideCal() {
  with (gfSelf.style) {
	visibility="hidden";
	top=parseInt(top)-10; // for nn6 bug
  }
}

function fGetXY(aTag){
  var p=[0,0];
  while(aTag!=null){
  	p[0]+=aTag.offsetLeft;
  	p[1]+=aTag.offsetTop;
  	aTag=aTag.offsetParent;
  }
  return p;
}

//--------

function fInitRange(r) {
  gRange=r?r:[];
  var rb=gRange[0]?r[0]:gBegin;
  gdBegin=new Date(rb[0],rb[1]-1,rb[2]);
  var re=gRange[1]?r[1]:gEnd;
  gdEnd=new Date(re[0],re[1]-1,re[2]);
}

function fSetDate(y,m,d){
  var action=fGetAgenda([y,m,d])[2];
  if (!action)
	return;
  gCurMonth=[y,m];
  gdSelect=[y,m,d];
  gdCtrl.value=fFormatDate(y,m,d);
  fHideCal();
  eval(action);
}

function fParseDate(ds) {
  var r=null;
  var i;
  if (ds!=null) {
	var pd=ds.split(gsSplit);
	if (pd.length==3) {
		var m=pd[giDatePos==1?0:1];
		for (i=0; (i<12)&&(gMonths[i].substring(0,3).toLowerCase()!=m.substring(0,3).toLowerCase())&&(i+1!=m); i++);
		if (i<12) {
			var y=parseInt(pd[giDatePos==2?0:2].substring(0,4),10);
			var pf=Math.floor(gEnd[0]/100)*100;
			r=[y<100?y>gEnd[0]%100?pf-100+y:pf+y:y,i+1,parseInt(pd[giDatePos],10)];
		} else
			return null;
  	} else
		return null;
	var td=new Date(r[0],r[1]-1,r[2]);
	if (isNaN(td)||td.getMonth()!=r[1]-1)
		return null;
	gdCtrl.value=fFormatDate(r[0],r[1],r[2]);
  }
  return r;
}

function fGetAgenda(d) {
  var s=fCalibrate(d[0],d[1]);
  if (!fValidRange(s[0],s[1],d[2]))
	return [gsOutOfRange, gcBG];
  for (var i=2; i<gRange.length; i++)
	if (gRange[i][2]==d[2]&&gRange[i][1]==s[1]&&gRange[i][0]==s[0])
		return [gsOutOfRange, gcBG];
  var ag=fHoliday(s[0],s[1],d[2]);
  if (ag==null)
	ag=["",gcBG,gsAction];
  return ag;
}

function fValidRange(y,m,d) {
  var date=new Date(y,m-1,d);
  return (date>=gdBegin)&&(date<=gdEnd);
}

function fCalibrate(y,m) {
  if (m<1) { y--; m=12; }
  else if (m>12) { y++;	m=1; }
  return [y,m];
}

function fFormatDate(y,m,d){
  var M=gbDigital?m<10?"0"+m:m:gMonths[m-1];
  var D=gbDigital&&d<10?"0"+d:d;
  var sy=y%100;
  sy=sy<10?"0"+sy:sy;
  switch (giDatePos) {
	case 0: return D+gsSplit+M+gsSplit+(gbShortYear?sy:y);
	case 1: return M+gsSplit+D+gsSplit+(gbShortYear?sy:y);
	case 2: return (gbShortYear?sy:y)+gsSplit+M+gsSplit+D;
  }
}

function fBuildCal(y,m) {
  m=parseInt(m,10);
  var days=[31,31,(y%4==0&&y%100!=0||y%400==0)?29:28,31,30,31,30,31,31,30,31,30,31];
  var dCalDate=new Date(y,m-1,1);
  var iDayOfFirst=dCalDate.getDay();
  if (gbEuroCal)
	if (--iDayOfFirst<0)
		iDayOfFirst=6;
  var iOffsetLast=days[m-1]-iDayOfFirst+1;
  var iDate=1;
  var iNext=1;
  for (var d=0;d<7;d++)
	cal[0][d]=(d<iDayOfFirst)?[m-1,-(iOffsetLast+d)]:[m,iDate++];
  for (var w=1;w<6;w++)
  	for (var d=0;d<7;d++)
		cal[w][d]=(iDate<=days[m])?[m,iDate++]:[m+1,-(iNext++)];
  return cal;
}

function fCheckRange(y,m) {
  if (y>gEnd[0]||y<gBegin[0]||(y==gBegin[0]&&m<gBegin[1])||(y==gEnd[0]&&m>gEnd[1])) {
	alert(gsOutOfRange);
	if (gcbMon) gcbMon.options[gCurMonth[1]-1].selected=true;
	if (gcbYear) gcbYear.options[gCurMonth[0]-gBegin[0]].selected=true;
	return false;
  }
  return true;
}

//------------------

function fSetSelected(aCell) {
  var s=fGetSelected(aCell);
  fSetDate(s[0],s[1],s[2]);
  if (evDate!='') evDate();
}

function fGetSelected(aCell){
  var iOffset=0;
  var y=(gcbYear)?parseInt(gcbYear.value):gCurMonth[0];
  var m=(gcbMon)?parseInt(gcbMon.value):gCurMonth[1];
  aCell.bgColor=gcBG;
  with (aCell.firstChild){
  	var d=parseInt(innerHTML,10);
  	if (style.color==gcOtherDay)
		iOffset=(id<10)?-1:1;
	m+=iOffset;
	if (m<1) {
		y--;
		m=12;
	}else if (m>12){
		y++;
		m=1;
	}
	return [y,m,d];
  }
}


function fDrawCal() {
  var sTD=" width='"+giCellWidth+"' style='height:"+giCellHeight+";' ";
  var sDIV=" style='position:relative;height:"+(giCellHeight-4)+";width:"+giCellWidth+";' ";
  var id=0;
  with (document) {
	write("<tr>");
	for (var i=0; i<7; i++)
		write("<td class='CalHead' "+sTD+">"+gWeekDay[i]+"</td>");
	write("</tr>");
  	for (var w=1; w<7; w++) {
		write("<tr>");
		for (var d=0; d<7; d++) {
			write("<td "+sTD+"><div class='CalCell' "+sDIV+" onMouseOver='gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;' onMouseOut='this.style.backgroundColor=gcTemp?gcTemp:\"transparent\";' onclick='fSetSelected(this)'>");           //Coded by Liming Weng(Victor Won)  email:victorwon@netease.com
			write("<A id='"+(id++)+"' href='javascript:' onfocus='this.blur();' onclick='return false;' >00</A></div></td>")
		}
		write("</tr>");
	}
  }
}

function fUpdateCal(y,m) {
  var c=fBuildCal(y,m);
  var ag,d;
  for (var week=0; week<6; week++)
	for (var day=0; day<7; day++) {
		m=c[week][day][0];
		d=c[week][day][1];
		with (gCellSet[(7*week)+day]) {
			if (d<0) {
				style.color=gcOtherDay;
				d=-d;
			}else{
				style.color=(day==giSun)?gcSun:(day==giSat)?gcSat:gcWorkday;
			}
			innerHTML=d;
			ag=fGetAgenda([y,m,d]);
			parentNode.title=ag[0];
			style.textDecoration=(ag[2])?"none":"line-through";
			if (ag[3]) innerHTML+="<BR><IMG SRC='"+ag[3]+"' BORDER=0></IMG>";
			with (parentNode) {
				style.backgroundColor=(m==gCurMonth[1])?(gdSelect+''==[y,m,d])?gcToggle:(gToday+''==[y,m,d])?gcTodayBG:ag[1]:ag[1];
				style.backgroundColor=style.backgroundColor; // for nn6 bug
				parentNode.bgColor=ag[1];
				parentNode.bgColor=ag[1]; // for nn6 bug
			}
		}
	}
}

function fSetCal(y,m){
  if (!fCheckRange(y,m))
	return false;
  if (gcbMon) gcbMon.options[m-1].selected=true;
  if (gcbYear) gcbYear.options[y-gBegin[0]].selected=true;
  gCurMonth=[y,m];
  fUpdateCal(y,m);
  gfSelf.width=document.getElementById("popTable").offsetWidth;
  gfSelf.height=document.getElementById("popTable").offsetHeight;
  return true;
}

function fPrevMonth(){
  var m=gcbMon.value;
  var y=gcbYear.value;
  if (--m<1) { m=12; y--; }
  fSetCal(y,m);
}

function fNextMonth(){
  var m=gcbMon.value;
  var y=gcbYear.value;
  if (++m>12) { m=1; y++; }
  fSetCal(y,m);
}

fInitRange();
with (document) {
  write("<TABLE id='popTable' width=210 bgcolor='"+gcCalBG+"' cellspacing='0' cellpadding='3' border='0'>");
  if (!gbHideDC) {
	write("<TR><TD align='center'><input type='button' value='<' class='HeadBtn' onClick='fPrevMonth()'>");
	write("&nbsp;<select id='MonSelect' class='HeadBox' onChange='fSetCal(gcbYear.value, gcbMon.value)' Victor='Won'>");
	for (var i=0; i<12; i++)
		write("<option value='"+(i+1)+"'>"+gMonths[i]+"</option>");
	write("</SELECT><SELECT id='YearSelect' class='HeadBox' onChange='fSetCal(gcbYear.value, gcbMon.value)' Victor='Won'>");
	for(var i=gBegin[0];i<=gEnd[0];i++)
		write("<OPTION value='"+i+"'>"+i+"</OPTION>");
	write("</SELECT>&nbsp;<input type='button' value='>' class='HeadBtn' onclick='fNextMonth()'></TD></TR>");
	gcbMon=getElementById("MonSelect");
	gcbYear=getElementById("YearSelect");
  } else
	write("<TR><TD align='center' class='CalTitle'>"+eval(gsCalTitle)+"</TD></TR>");
  write("<TR><TD align='center'><DIV style='background:"+gcFrame+(gpicBG?" url("+gpicBG+") ":" ")+gsBGRepeat+";'><TABLE "+gsCalTable+" >");
  fDrawCal();
  gCellSet=getElementsByTagName("A");
  fUpdateCal(gCurMonth[0],gCurMonth[1]);
  write("</TABLE></DIV></TD></TR>");
  if (!gbHideToday) {
	write("<TR><TD align='center'>");
	write("<A id='AToday' href='javascript:' class='Today' onclick='fSetDate(gToday[0],gToday[1],gToday[2]);this.blur();return false;' onMouseOver='gcTemp=this.style.color;this.style.color=gcToggle;self.status=this.title;return true;' onMouseOut='this.style.color=gcTemp'>"+gsToday+"</A>");
	getElementById("AToday").title=fGetAgenda(gToday)[0];
	write("</TD></TR>");
  }
  write("</TABLE>");
}
</script>
<table id="popTable" bgcolor="#6699cc" cellspacing="0" cellpadding="3" border="0">
	<tbody>
		<tr>
			<td align="center">
				<input type="button" value="&lt;" class="HeadBtn" onClick="fPrevMonth()">&nbsp;
				<select id="MonSelect" class="HeadBox" onChange="fSetCal(gcbYear.value, gcbMon.value)">
					<option value="1">Jan</option>
				</select>
        		<select id="YearSelect" class="HeadBox" onChange="fSetCal(gcbYear.value, gcbMon.value)">
					<option value="2001">2001</option>
				</select>&nbsp;
				<input type="button" value="&gt;" class="HeadBtn" onClick="fNextMonth()">
			</td>
		</tr>
		<tr>
			<td align="center">
				<div style="background: gray none no-repeat scroll 0%; -moz-background-clip: initial; -moz-background-origin: initial; -moz-background-inline-policy: initial;">
					<table border="0" cellpadding="2" cellspacing="1">
						<tbody>
							<tr>
								<td class="CalHead" width="18" style="height: 18px;">S</td>
								<td class="CalHead" width="18" style="height: 18px;">M</td>
								<td class="CalHead" width="18" style="height: 18px;">T</td>
								<td class="CalHead" width="18" style="height: 18px;">W</td>
								<td class="CalHead" width="18" style="height: 18px;">T</td>
								<td class="CalHead" width="18" style="height: 18px;">F</td>
								<td class="CalHead" width="18" style="height: 18px;">S</td>
							</tr>
							<tr>
								<td bgcolor="#dddddd" width="18" style="height: 18px;">
								<div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"> 
                    <a style="color: silver; text-decoration: none;" id="0" href="javascript:" onFocus="this.blur();" onClick="return false;">27</a> 
                  </div></td><td bgcolor="#dddddd" width="18" style="height: 18px;">
								<div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"> 
                    <a style="color: silver; text-decoration: none;" id="1" href="javascript:" onFocus="this.blur();" onClick="return false;">28</a> 
                  </div>
								</td><td bgcolor="#dddddd" width="18" style="height: 18px;">
								<div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"> 
                    <a style="color: silver; text-decoration: none;" id="2" href="javascript:" onFocus="this.blur();" onClick="return false;">29</a> 
                  </div>
								</td>
								<td bgcolor="#dddddd" width="18" style="height: 18px;">
								<div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"> 
                    <a style="color: silver; text-decoration: none;" id="3" href="javascript:" onFocus="this.blur();" onClick="return false;">30</a> 
                  </div>
								</td>
								<td bgcolor="#dddddd" width="18" style="height: 18px;">
								<div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"> 
                    <a style="color: silver; text-decoration: none;" id="4" href="javascript:" onFocus="this.blur();" onClick="return false;">31</a> 
                  </div>
								</td>
								<td bgcolor="#dddddd" width="18" style="height: 18px;">
								<div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"> 
                    <a style="color: black; text-decoration: none;" id="5" href="javascript:" onFocus="this.blur();" onClick="return false;">1</a> 
                  </div>
								</td>
								<td bgcolor="#dddddd" width="18" style="height: 18px;">
								<div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"> 
                    <a style="color: darkcyan; text-decoration: none;" id="6" href="javascript:" onFocus="this.blur();" onClick="return false;">2</a> 
                  </div>
								</td>
							</tr>
							<tr>
								<td bgcolor="#dddddd" width="18" style="height: 18px;">
								<div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"> 
                    <a style="color: red; text-decoration: none;" id="7" href="javascript:" onFocus="this.blur();" onClick="return false;">3</a> 
                  </div>
								</td>
								<td bgcolor="#dddddd" width="18" style="height: 18px;">
									<div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"> 
                    <a style="color: black; text-decoration: none;" id="8" href="javascript:" onFocus="this.blur();" onClick="return false;">4</a> 
                  </div>
								</td>
								<td bgcolor="#dddddd" width="18" style="height: 18px;">
									<div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"> 
                    <a style="color: black; text-decoration: none;" id="9" href="javascript:" onFocus="this.blur();" onClick="return false;">5</a> 
                  </div>
								</td>
								<td bgcolor="lightsteelblue" width="18" style="height: 18px;">
									<div title="If you arrive on today, then your departure time will be confined!" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: lightsteelblue;" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"> 
                    <a style="color: black; text-decoration: none;" id="10" href="javascript:" onFocus="this.blur();" onClick="return false;">6</a> 
                  </div>
								</td>
								<td bgcolor="#dddddd" width="18" style="height: 18px;">
									<div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"> 
                    <a style="color: black; text-decoration: none;" id="11" href="javascript:" onFocus="this.blur();" onClick="return false;">7</a> 
                  </div>
								</td>
								<td bgcolor="#dddddd" width="18" style="height: 18px;">
									<div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"> 
                    <a style="color: black; text-decoration: none;" id="12" href="javascript:" onFocus="this.blur();" onClick="return false;">8</a> 
                  </div>
								</td>
								<td bgcolor="#dddddd" width="18" style="height: 18px;">
									<div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"> 
                    <a style="color: darkcyan; text-decoration: none;" id="13" href="javascript:" onFocus="this.blur();" onClick="return false;">9</a> 
                  </div>
								</td>
							</tr>
							<tr>
								<td bgcolor="#dddddd" width="18" style="height: 18px;">
									<div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"> 
                    <a style="color: red; text-decoration: none;" id="14" href="javascript:" onFocus="this.blur();" onClick="return false;">10</a> 
                  </div>
								</td>
								<td bgcolor="#dddddd" width="18" style="height: 18px;">
									<div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"> 
                    <a style="color: black; text-decoration: none;" id="15" href="javascript:" onFocus="this.blur();" onClick="return false;">11</a> 
                  </div>
								</td>
								<td bgcolor="skyblue" width="18" style="height: 18px;">
									<div title=" June 12, 2001
 PopCalendarXP 3.0 Unleashed! " class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: skyblue;" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: black; text-decoration: none;" id="16" href="javascript:" onFocus="this.blur();" onClick="return false;">12</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: black; text-decoration: none;" id="17" href="javascript:" onFocus="this.blur();" onClick="return false;">13</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: black; text-decoration: none;" id="18" href="javascript:" onFocus="this.blur();" onClick="return false;">14</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: black; text-decoration: none;" id="19" href="javascript:" onFocus="this.blur();" onClick="return false;">15</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: darkcyan; text-decoration: none;" id="20" href="javascript:" onFocus="this.blur();" onClick="return false;">16</a></div></td></tr><tr><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: red; text-decoration: none;" id="21" href="javascript:" onFocus="this.blur();" onClick="return false;">17</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: yellow;" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: black; text-decoration: none;" id="22" href="javascript:" onFocus="this.blur();" onClick="return false;">18</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: black; text-decoration: none;" id="23" href="javascript:" onFocus="this.blur();" onClick="return false;">19</a></div></td><td bgcolor="lightsteelblue" width="18" style="height: 18px;"><div title="If you depart on today, then your arrival time will be confined!" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: lightsteelblue;" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: black; text-decoration: none;" id="24" href="javascript:" onFocus="this.blur();" onClick="return false;">20</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: black; text-decoration: none;" id="25" href="javascript:" onFocus="this.blur();" onClick="return false;">21</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: black; text-decoration: none;" id="26" href="javascript:" onFocus="this.blur();" onClick="return false;">22</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: darkcyan; text-decoration: none;" id="27" href="javascript:" onFocus="this.blur();" onClick="return false;">23</a></div></td></tr><tr><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: red; text-decoration: none;" id="28" href="javascript:" onFocus="this.blur();" onClick="return false;">24</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: black; text-decoration: none;" id="29" href="javascript:" onFocus="this.blur();" onClick="return false;">25</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: black; text-decoration: none;" id="30" href="javascript:" onFocus="this.blur();" onClick="return false;">26</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: black; text-decoration: none;" id="31" href="javascript:" onFocus="this.blur();" onClick="return false;">27</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: black; text-decoration: none;" id="32" href="javascript:" onFocus="this.blur();" onClick="return false;">28</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: black; text-decoration: none;" id="33" href="javascript:" onFocus="this.blur();" onClick="return false;">29</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: darkcyan; text-decoration: none;" id="34" href="javascript:" onFocus="this.blur();" onClick="return false;">30</a></div></td></tr><tr><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: silver; text-decoration: none;" id="35" href="javascript:" onFocus="this.blur();" onClick="return false;">1</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: silver; text-decoration: none;" id="36" href="javascript:" onFocus="this.blur();" onClick="return false;">2</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: silver; text-decoration: none;" id="37" href="javascript:" onFocus="this.blur();" onClick="return false;">3</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: silver; text-decoration: none;" id="38" href="javascript:" onFocus="this.blur();" onClick="return false;">4</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: silver; text-decoration: none;" id="39" href="javascript:" onFocus="this.blur();" onClick="return false;">5</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: silver; text-decoration: none;" id="40" href="javascript:" onFocus="this.blur();" onClick="return false;">6</a></div></td><td bgcolor="#dddddd" width="18" style="height: 18px;"><div title="" class="CalCell" style="position: relative; height: 14px; width: 18px; background-color: rgb(221, 221, 221);" onMouseOver="gcTemp=this.style.backgroundColor;this.style.backgroundColor=gcToggle;self.status=this.title;return true;" onmouseout='this.style.backgroundColor=gcTemp?gcTemp:"transparent";' onClick="fSetSelected(this)"><a style="color: silver; text-decoration: none;" id="41" href="javascript:" onFocus="this.blur();" onClick="return false;">7</a></div></td></tr></tbody></table></div></td></tr><tr><td align="center"><a title="" id="AToday" href="javascript:" class="Today" onClick="fSetDate(gToday[0],gToday[1],gToday[2]);this.blur();return false;" onMouseOver="gcTemp=this.style.color;this.style.color=gcToggle;self.status=this.title;return true;" onMouseOut="this.style.color=gcTemp">Today : 31 Aug 2004</a></td></tr></tbody></table>
</body></html>

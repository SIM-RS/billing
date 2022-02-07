var gsAction="fDemoCheck(y,m,d);";	
/*addEvent("2001-5-13", "Disabled Date!", gcBG, null);
addEvent("2001-5-14", "You may customize me!", "gray", "popup('mailto:popcal@yahoo.com?subject=Excellent Calendar')");
addEvent("2001-6-6", "If you arrive on today, then your departure time will be confined!", "lightsteelblue", "fDemoArrive(y,m,d)");
addEvent("2001-6-20", "If you depart on today, then your arrival time will be confined!", "lightsteelblue", "fDemoDepart()");
addEvent("2001-6-12", " June 12, 2001 \n PopCalendarXP 3.0 Unleashed! ", "skyblue", gsAction+"popup('readme.txt');");
*/


function fHoliday(y,m,d) {
///// Uncomment any of the following two lines will give you special effect! ///
// if (m!=gCurMonth[1]||y!=gCurMonth[0]) return ["",gcOtherDay,null];	// hide the days of other months
// if (new Date(y,m-1,d+1)<gd) return ["",gcBG];	// cross-over the past days
////////////////////////////////////////////////////////////////////////////////

//  var r=agenda[y+"-"+m+"-"+d]; // Define your agenda date format here!!
//  if (r) return r;	// put this line to the end will lower the priority of agenda events.

  //if (m==12&&d==25)
//	r=["Merry Xmas!", "seagreen"];
  //else if (m==12&&d==26)
//	r=[" Boxing Day! \n Let's go shopping ... ", "skyblue", gsAction+"popup('readme.txt','main');"];
  //else if (m==10&&d==1)
//	r=[" China National Day! \n Let's enjoy a long vacation ... ", "skyblue", gsAction];

//  return r;
}


/////// Add your self-defined functions here ///////
var gdc, gmc, gyc;
function fDemoPop(dayc,monc,yearc,dateCtrl,range) {
  gdc=dayc; gmc=monc; gyc=yearc;
  dateCtrl.value=gdc.value+"-"+gmc.value+"-"+gyc.value;
  fPopCalendar(dateCtrl, range);
}
function fDemoCheck(y,m,d) {
  if (gdCtrl.name=="dc1") {
	with(parent.document.forms["demoform"]){gdc.value=d;gmc.value=m;gyc.value=y;};
	parent.depRange=[];
  }
  if (gdCtrl.name=="dc2")
	parent.arrRange=[];
}
function fDemoArrive(y,m,d) {
  if (gdCtrl.name=="dc1") {
	with(parent.document.forms["demoform"]){gdc.value=d;gmc.value=m;gyc.value=y;};
	parent.depRange=[[2001,6,10],[2001,6,20],[2001,6,13]];
  }
}
function fDemoDepart() {
  if (gdCtrl.name=="dc2")
	parent.arrRange=[[2001,6,1],[2001,6,10]];
}



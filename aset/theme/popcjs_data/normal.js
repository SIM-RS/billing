// --------------- From here you can config the options freely! ----------------
var gsPopConfig="top=200,left=200,width=400,height=200,scrollbars=1,resizable=1";	// the look of popup window

var gMonths=new Array("JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");
var gWeekDay=new Array("Mg","Sn","Sl","Rb","Km","Jm","St");
var gsToday="Today : "+gToday[2]+" "+gMonths[gToday[1]-1]+" "+gToday[0];	// The expression of Today-Part.

var giCellWidth=20;	// Calendar cell width;
var giCellHeight=18;	// Calendar cell height;
var gbHideDC=false;	// Replace the Date Controls at the top with gsCalTitle. If set true, gbCMFocus should be set to false!!
var gbHideToday=false;	// Remove the Today Part from the bottom
var gsCalTitle="(gMonths[gCurMonth[1]-1]+' '+gCurMonth[0])";	// dynamic statement to be eval-ed

//var tanggal=new Date();

//var gBegin=[tanggal.getFullYear()-5,1,1];	// Valid Range begin from [Year,Month,Date]
//var gEnd=[tanggal.getFullYear()+5,12,31];	// Valid Range end at [Year,Month,Date]
//var gBegin=[2003,1,1];	// Valid Range begin from [Year,Month,Date]
//var gEnd=[2013,12,31];	// Valid Range end at [Year,Month,Date]
var gsOutOfRange="The date is out of valid range!";	// Range Error Message

var gbEuroCal=false;	// Show European Calendar Layout - Sunday goes after Saturday
var gsSplit="-";	// Separator of date string, AT LEAST one char.
var giDatePos=0;	// Date format  0: D-M-Y ; 1: M-D-Y; 2: Y-M-D
var gbDigital=true;	// true: 01-05-2001 ; false: 1-May-2001
var gbShortYear=false;   // Set the year format in short, i.e. 79 instead of 1979

var gpicBG=null;	// url of background image
var gsBGRepeat="no-repeat";// repeat mode of background image, except NN4. [no-repeat,repeat,repeat-x,repeat-y]
var gcBG="#dddddd";	// Background color of the cells. Use "" for transparent!
var gcFrame="#666666";	// Frame color
var gsCalTable="border=0 cellpadding=2 cellspacing=1";	// the properties of calendar <table> tag
var gcCalBG="#eeeeee";	// Background color of the calendar

var gcTodayBG="white";	// The background highlight color of today
var gcSat="darkcyan";	// Saturday color
var gcSun="red";	// Sunday color
var gcWorkday="black";	// Workday color
var gcOtherDay="silver";	// The day color of other months
// gcOtherDay must be set in literal format, digital & rgb() format will not work in either NN6 or NN4!
var gcToggle="#FFFF66";	// highlight color of focused cell


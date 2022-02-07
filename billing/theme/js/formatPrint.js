function formatTagihan(){
    // set portrait orientation
    jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
    // set top margins in millimeters
    jsPrintSetup.setOption('marginTop', 0);
    jsPrintSetup.setOption('marginBottom', 0);
    jsPrintSetup.setOption('marginLeft', 0);
    jsPrintSetup.setOption('marginRight', 0);
    // set page header
    jsPrintSetup.setOption('headerStrLeft',' ');
    jsPrintSetup.setOption('headerStrCenter',' ');
    jsPrintSetup.setOption('headerStrRight',' ');
    // set empty page footer
    jsPrintSetup.setOption('footerStrLeft',' ');
    jsPrintSetup.setOption('footerStrCenter',' ');
    jsPrintSetup.setOption('footerStrRight',' ');
    
    jsPrintSetup.setOption('paperHeight','21.5');
    jsPrintSetup.setOption('paperWidth','18.5');
    // clears user preferences always silent print value
    // to enable using 'printSilent' option
    jsPrintSetup.clearSilentPrint();
    // Suppress print dialog (for this context only)
    //jsPrintSetup.setOption('printSilent', 1);
    // Do Print
    // When print is submitted it is executed asynchronous and
    // script flow continues after print independently of completetion of print process!
    
    // next commands
    jsPrintSetup.setOption('shrinkToFit','0');
    
    var namaPrinter = jsPrintSetup.getPrintersList().split(",");
    
    for(var i=0;i<namaPrinter.length;i++){
        if(namaPrinter[i].search('tagihan')!=-1){
            //alert(namaPrinter[i]);
            jsPrintSetup.setPrinter(namaPrinter[i]);
            break;
        }         
    }
}

function formatKuitansi(){
    jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
    jsPrintSetup.setOption('marginTop', 0);
    jsPrintSetup.setOption('marginBottom', 0);
    jsPrintSetup.setOption('marginLeft', 0);
    jsPrintSetup.setOption('marginRight', 0);
    jsPrintSetup.setOption('headerStrLeft', '');
    jsPrintSetup.setOption('headerStrCenter', '');
    jsPrintSetup.setOption('headerStrRight', '');
    jsPrintSetup.setOption('footerStrLeft', '');
    jsPrintSetup.setOption('footerStrCenter', '');
    jsPrintSetup.setOption('footerStrRight', '');
    jsPrintSetup.setPaperSizeUnit(jsPrintSetup.kPaperSizeInches);
    jsPrintSetup.setOption('paperHeight', '5.5');
    jsPrintSetup.setOption('paperWidth', '3.8');
    jsPrintSetup.clearSilentPrint();
    //jsPrintSetup.setOption('printSilent', 1);
    
    var namaPrinter = jsPrintSetup.getPrintersList().split(",");        
    for(var i=0;i<namaPrinter.length;i++){
        if(namaPrinter[i].search('kuitansi')!=-1){
            //alert(namaPrinter[i]);
            jsPrintSetup.setPrinter(namaPrinter[i]);
            break;
        }         
    }
}

function formatKartu(){
    //jsPrintSetup.setPaperSizeUnit(1);
       
    jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
    jsPrintSetup.setOption('marginTop', 0);
    jsPrintSetup.setOption('marginBottom', 0);
    jsPrintSetup.setOption('marginLeft', 0);
    jsPrintSetup.setOption('marginRight', 0);
    jsPrintSetup.setOption('headerStrLeft', '');
    jsPrintSetup.setOption('headerStrCenter', '');
    jsPrintSetup.setOption('headerStrRight', '');
    jsPrintSetup.setOption('footerStrLeft', '');
    jsPrintSetup.setOption('footerStrCenter', '');
    jsPrintSetup.setOption('footerStrRight', '');   
    //jsPrintSetup.setOption('paperHeight', '6.4');
    //jsPrintSetup.setOption('paperWidth', '9.5');
    jsPrintSetup.getOption('paperWidth');
    jsPrintSetup.clearSilentPrint();
    //jsPrintSetup.setOption('printSilent', 1);
    
    var namaPrinter = jsPrintSetup.getPrintersList().split(",");        
    for(var i=0;i<namaPrinter.length;i++){
        if(namaPrinter[i].search('kartu')!=-1){
            //alert(namaPrinter[i]);
            jsPrintSetup.setPrinter(namaPrinter[i]);
            break;
        }         
    }
}

function formatF4(){
    //jsPrintSetup.setPaperSizeUnit(1);
       
    jsPrintSetup.setOption('orientation', jsPrintSetup.kLandscapeOrientation);
    jsPrintSetup.setOption('marginTop', 0);
    jsPrintSetup.setOption('marginBottom', 0);
    jsPrintSetup.setOption('marginLeft', 0);
    jsPrintSetup.setOption('marginRight', 0);
    jsPrintSetup.setOption('headerStrLeft', '');
    jsPrintSetup.setOption('headerStrCenter', '');
    jsPrintSetup.setOption('headerStrRight', '');
    jsPrintSetup.setOption('footerStrLeft', '');
    jsPrintSetup.setOption('footerStrCenter', '');
    jsPrintSetup.setOption('footerStrRight', '');   
    jsPrintSetup.setOption('paperHeight', '33');
    jsPrintSetup.setOption('paperWidth', '21.5');
    jsPrintSetup.clearSilentPrint();
    //jsPrintSetup.setOption('printSilent', 1);
    
    var namaPrinter = jsPrintSetup.getPrintersList().split(",");        
    for(var i=0;i<namaPrinter.length;i++){
        if(namaPrinter[i].search('F4')!=-1){
            //alert(namaPrinter[i]);
            jsPrintSetup.setPrinter(namaPrinter[i]);
            break;
        }         
    }
}

function formatF4Portrait(){
    //jsPrintSetup.setPaperSizeUnit(1);
       
    jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
    jsPrintSetup.setOption('marginTop', '0');
    jsPrintSetup.setOption('marginBottom', '0');
    jsPrintSetup.setOption('marginLeft', '0');
    jsPrintSetup.setOption('marginRight', '0');
    jsPrintSetup.setOption('headerStrLeft', '');
    jsPrintSetup.setOption('headerStrCenter', '');
    jsPrintSetup.setOption('headerStrRight', '');
    jsPrintSetup.setOption('footerStrLeft', '');
    jsPrintSetup.setOption('footerStrCenter', '');
    jsPrintSetup.setOption('footerStrRight', '');   
    jsPrintSetup.setOption('paperHeight', '33.0');
    jsPrintSetup.setOption('paperWidth', '21.5');
    jsPrintSetup.clearSilentPrint();
    //jsPrintSetup.setOption('printSilent', 1);
    
    var namaPrinter = jsPrintSetup.getPrintersList().split(",");        
    for(var i=0;i<namaPrinter.length;i++){
        if(namaPrinter[i].search('F4')!=-1){
            //alert(namaPrinter[i]);
            jsPrintSetup.setPrinter(namaPrinter[i]);
            break;
        }         
    }
}

function formatLegal(){
    //jsPrintSetup.setPaperSizeUnit(1);
       
    jsPrintSetup.setOption('orientation', jsPrintSetup.kLandscapeOrientation);
    jsPrintSetup.setOption('marginTop', 0);
    jsPrintSetup.setOption('marginBottom', 0);
    jsPrintSetup.setOption('marginLeft', 0);
    jsPrintSetup.setOption('marginRight', 0);
    jsPrintSetup.setOption('headerStrLeft', '');
    jsPrintSetup.setOption('headerStrCenter', '');
    jsPrintSetup.setOption('headerStrRight', '');
    jsPrintSetup.setOption('footerStrLeft', '');
    jsPrintSetup.setOption('footerStrCenter', '');
    jsPrintSetup.setOption('footerStrRight', '');   
    jsPrintSetup.setPaperSizeUnit(jsPrintSetup.kPaperSizeInches);
    jsPrintSetup.setOption('paperHeight', '8.5');
    jsPrintSetup.setOption('paperWidth', '14');
    jsPrintSetup.clearSilentPrint();
    //jsPrintSetup.setOption('printSilent', 1);
    
    var namaPrinter = jsPrintSetup.getPrintersList().split(",");        
    for(var i=0;i<namaPrinter.length;i++){
        if(namaPrinter[i].search('F4')!=-1){
            //alert(namaPrinter[i]);
            jsPrintSetup.setPrinter(namaPrinter[i]);
            break;
        }         
    }
}

function cetakB()
{
	jsPrintSetup.setOption('orientation', jsPrintSetup.kLandscapeOrientation);
	//jsPrintSetup.undefinePaperSize(106);
	jsPrintSetup.definePaperSize(113, 113, "Custom", "Custom_Paper", "Custom PAPER", 20, 10, jsPrintSetup.kPaperSizeMillimeters);
	jsPrintSetup.setPaperSizeData(113);
	jsPrintSetup.print();    
    //jsPrintSetup.setSilentPrint(false);
   // window.close();
}

function cetakKartu12()
{
	var namaPrinter = jsPrintSetup.getPrintersList().split(",");
	//alert(namaPrinter);
    for(var i=0;i<namaPrinter.length;i++){
        if(namaPrinter[i].search('Evolis Badgy1')!=-1){
            //alert(namaPrinter[i]);
            jsPrintSetup.setPrinter(namaPrinter[i]);
            break;
        }         
    }
	
	jsPrintSetup.setOption('marginTop', 0);
    jsPrintSetup.setOption('marginBottom', 0);
    jsPrintSetup.setOption('marginLeft', 0);
    jsPrintSetup.setOption('marginRight', 0);
    // set page header
    jsPrintSetup.setOption('headerStrLeft',' ');
    jsPrintSetup.setOption('headerStrCenter',' ');
    jsPrintSetup.setOption('headerStrRight',' ');
    // set empty page footer
    jsPrintSetup.setOption('footerStrLeft',' ');
    jsPrintSetup.setOption('footerStrCenter',' ');
    jsPrintSetup.setOption('footerStrRight',' ');
	
	jsPrintSetup.setOption('orientation', jsPrintSetup.kLandscapeOrientation);
	//jsPrintSetup.setSilentPrint(true);
	jsPrintSetup.print();
	jsPrintSetup.setSilentPrint(false);
	window.close();
}

function mulaiPrint(){
    //jsPrintSetup.setPrintProgressListener(progressListener);
    //alert(jsPrintSetup.getPrinter());
    //jsPrintSetup.setSilentPrint(true);
    jsPrintSetup.print();    
    //jsPrintSetup.setSilentPrint(false);
    window.close();
}
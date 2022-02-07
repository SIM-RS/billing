/*!
 * Ext JS Library 3.2.1
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
 //function a(s)alert(s);
//if(Ext.isIE)alert('a');

 function extGrid (id){
    //this.idgrid=id;
    //alert(id);
    this.renderTo=document.getElementById(id);
    //alert(id);
    this.selectedRow=1; 
    this.grid;   
    this.renderTo.fnct="";
    this.headerName=[];
    this.coloumId=[];
	this.coloumAlign=[];
    this.coloumWidth=[];
    this.colType=[];
    this.coloumModel=[];
    this.coloumWidth=[];
    this.filterCol=[];
    this.filterOption=[];
    this.title="Master";
    this.url="";
    this.local=false;
    this.encode=false;
    this.rowData=[];
    this.gridHeight=0;
    this.gridWidth=0;
    var baris=0;
    this.loadURL=function(urlLoad,successText,reload){
		//alert('zx');
        if(this.grid!=undefined)gridstore=this.grid.getStore();
        //this.urlLoad=urlLoad;
        var urlTemp=urlLoad;
        reload=function(){      
            gridstore.proxy.conn.url=urlTemp;
            gridstore.reload();      
        }
    	var received = function (response) {    	   
            if(successText!="" && successText!=undefined){
				if(response.responseText!="")alert(response.responseText);else alert(successText);
			}
            if(reload && reload!=undefined){
				if(successText==''){
                reload();
				}else{
				gridstore.proxy.conn.url=this.url;
				gridstore.reload(); 
				}
				//alert("Loading... ok !!");
            }
			//alert(response.responseText);
    	}     //alert(this.urlLoad);
    	Ext.Ajax.request({
    	   url: urlLoad,
    	   success: received,
		  failure: function(f,a){
                                if (a.failureType === Ext.form.Action.CONNECT_FAILURE){
                                    Ext.Msg.alert('Failure', 'Server reported:'+a.response.status+' '+a.response.statusText);
                                }
                                if (a.failureType === Ext.form.Action.SERVER_INVALID){
                                    Ext.Msg.alert('Warning', a.result.errormsg);
                                }}
    	});
        
    }
    this.setHeader=function(str){
        this.headerName=str.split(",");        
    }
	this.setColAlign=function(str){
        this.coloumAlign=str.split(",");        
    }
    this.setWidthHeight=function(width,height){
        this.gridWidth=width;
        this.gridHeight=height;        
    }
    this.setColId=function(str){
        this.coloumId=str.split(",");
        
    }  
    this.setColWidth=function(str){
        this.coloumWidth=str.split(",");
        
    }      
    this.setColType=function(str){
		this.colType=str.split(",");        
	}
    this.baseURL=function(str){
        this.url=str;
    }
    this.setTitle=function(str){
        this.title=str;
    }
    this.setClickEvent=function(evt){
        this.renderTo.fnct=evt;
    }
    this.setColWidth=function(str){
        this.coloumWidth=str.split(",");
    }
    this.getSelRowIndex1=function(){
        return this.rowId;        
    }
    this.getSelRowIndex=function(){
        return baris;        
    }
    this.getSelRowId=function(uKey){
		//alert(rowId);
        if(uKey==undefined || uKey=="")uKey="idext";
        var idext=document.getElementById(uKey+rowId).value;
        return idext;        
    }
    this.getCellValue=function(row,col){ //alert(id);      
        var temp=this.grid.getView().getCell(row,col-1).innerHTML.split(">");
        var ntemp=temp[1].split("<");
        if(ntemp[0]=="&nbsp;")ntemp[0]="";
        return ntemp[0];
    }
    this.reload=function(url){    
        if(url!=undefined && url!=""){
            this.url=url;
            this.grid.getStore().url=url;
            this.grid.getStore().proxy.conn.url=url;
               
        }
        this.grid.getStore().load();//reload(); 
    }
    this.headerCount=0;
  //  this.rowId=0;
	this.colAlCount=0;
    this.store;
    this.init=function(){
        
        this.headerCount=this.headerName.length;
		this.colAlCount=this.coloumAlign.length;
        for(var i=0;i<this.headerCount;i++){
            this.coloumId.push({name:this.coloumId[i]});
            var type="";
			alignCol='left';
			if(this.colAlCount==this.headerCount){
				if(this.coloumAlign[i]!="")alignCol=this.coloumAlign[i];
			}
            if(this.colType[i].indexOf(":")>-1){//alert('a');
                type=this.colType[i].split(":");
                option=type[1].split("|");
                this.filterCol.push({type:type[0],dataIndex:this.coloumId[i],options:option});   
                this.coloumModel.push({dataIndex:this.coloumId[i],width:new Number(this.coloumWidth[i]),align:alignCol,header:"<div align='left'><b>"+this.headerName[i]+"</b></div>",id:this.coloumId[i],filter:{type:type[0],options:option,phpMode:true}});
            }else if(this.colType[i].length==0){//alert('b');               
                this.filterCol.push();   
                this.coloumModel.push({dataIndex:this.coloumId[i],width:new Number(this.coloumWidth[i]),align:alignCol,header:"<div align='left'><b>"+this.headerName[i]+"</b></div>",id:this.coloumId[i]});
            }else{//alert('c');
                this.filterCol.push({type:this.colType[i],dataIndex:this.coloumId[i]});   
                this.coloumModel.push({dataIndex:this.coloumId[i],width:new Number(this.coloumWidth[i]),align:alignCol,header:"<div align='left'><b>"+this.headerName[i]+"</b></div>",id:this.coloumId[i],filter:{type:this.colType[i]}});    
            }
            

        }
        this.store = new Ext.data.JsonStore({
            // store configs
            autoDestroy: true,
            proxy: new Ext.data.HttpProxy({url: this.url}),
            //url: this.url,
            remoteSort: true,
            
            //storeId: 'user',
            
            // reader configs            
            root: 'data',
            totalProperty: 'total',
            fields: this.coloumId            
        });
        this.filters = new Ext.ux.grid.GridFilters({
												  
            // encode and local configuration options defined previously for easier reuse
            encode: false, // json encode the filter query
            local: false,   // defaults to false (remote filtering)            
            filters:this.filterCol
        }); 
        this.createColModel = function (finish, start) {
            var columns =this.coloumModel;
            return new Ext.grid.ColumnModel({
                columns: columns.slice(start || 0, finish),
                defaults: {                    
                    sortable: true
                }
            });
        };
        function setRowIndex(i){
            this.rowId=i;       
        }
        
        if(this.renderTo.fnct!=""){
            var evtCl=this.renderTo.fnct;    
        }else{
            var evtCl=function(){alert(this.rowId);};
        }
        //alert(getID());
        //alert(this.renderTo.id);
        //this.ids=this.renderTo.id;
        this.grid = new Ext.grid.GridPanel({
            //id:this.ids,
            border: true,            
            store: this.store,
            forceFit:true,
            colModel: this.createColModel(this.headerCount),
            loadMask: false,
            plugins: [this.filters],                
            listeners: {
                render: {
                    fn: function(){                            
                        this.store.load({
                            params: {
                                start: 0,
                                limit: 50
                            }
                        });
                    }
                },
                rowclick: {
                    fn:function(grid,ind){
                        //alert(ind);
                        setRowIndex(ind);
                        baris = ind; 
                        //alert(getSelRowIndex1());
                        evtCl();                         
                    }
                }
            },        
            bbar: new Ext.PagingToolbar({
                store: this.store,
                pageSize: 50,
                plugins: [this.filters]
            })
            ,
            title:'<div align="center" >'+this.title+'</div>',
            width:this.gridWidth,
            height:this.gridHeight,
            renderTo: this.renderTo
        });        
        //this.grid=grid;
    }
}

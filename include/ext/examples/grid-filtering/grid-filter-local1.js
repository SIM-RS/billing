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
    this.coloumWidth=[];
    this.colType=[];
    this.coloumModel=[];
    this.coloumWidth=[];
	this.coloumAlign=[];
    this.filterCol=[];
    this.filterOption=[];
	this.lock=[];
	this.modelcol=null;
    this.title="Master";
    this.url="";
    this.local=false;
    this.encode=false;
    this.rowData=[];
    this.gridHeight=0;
    this.gridWidth=0;
    this.loadURL=function(urlLoad,successText,reload){
	//alert(urlLoad);
        if(this.grid!=undefined)gridstore=this.grid.getStore();
        //this.urlLoad=urlLoad;
        var urlTemp=urlLoad;
        reload=function(){      
            gridstore.proxy.conn.url=urlTemp;
            gridstore.reload();      
        }
    	var received = function (response) {    	   
            if(successText!="" && successText!=undefined)alert(successText);
            if(reload && reload!=undefined){
                //reload();
            }
			//alert(response.responseText);
    	}     //alert(this.urlLoad);
    	Ext.Ajax.request({
    	   url: urlLoad,
    	   success: received,
    	   failure: function (response) { }
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
	this.setModelCol=function(str){
        this.modelcol=str;        
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
	this.setLock=function(str){
		this.lock=str.split(",");        
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
    this.getSelRowIndex=function(){
        return rowId;        
    }
    this.getSelRowId=function(uKey){
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
    this.rowId=0;
    this.store;
    this.init=function(){
	if(this.modelcol=="lock"){
        this.modelcol= new Ext.ux.grid.LockingGridView();
        }else{
		this.modelcol=null;
		}
		this.headerCount=this.headerName.length;
		this.colAlCount=this.coloumAlign.length;
        for(var i=0;i<this.headerCount;i++){
            this.coloumId.push({name:this.coloumId[i]});
            var type="";
			alignCol='center';
			
			if(this.colAlCount==this.headerCount){
				//alert(this.coloumAlign[i]);
				if(this.coloumAlign[i]!="")alignCol=this.coloumAlign[i];
			}
			var a=false;
			
			if(this.lock[i]=='true'){
			a=true;
			}
            if(this.colType[i].indexOf(":")>-1){//alert('a');
                type=this.colType[i].split(":");
                option=type[1].split("|");
                this.filterCol.push({type:type[0],dataIndex:this.coloumId[i],options:option});   
                this.coloumModel.push({dataIndex:this.coloumId[i],locked: a,align:alignCol,width:new Number(this.coloumWidth[i]),header:"<b>"+this.headerName[i]+"</b>",id:this.coloumId[i],filter:{type:type[0],options:option,phpMode:true}});
            }else if(this.colType[i].length==0){               
                this.filterCol.push();   
                this.coloumModel.push({dataIndex:this.coloumId[i],locked: a,align:alignCol,width:new Number(this.coloumWidth[i]),header:"<b>"+this.headerName[i]+"</b>",id:this.coloumId[i]});
            }else{
                this.filterCol.push({type:this.colType[i],dataIndex:this.coloumId[i]});   
                this.coloumModel.push({dataIndex:this.coloumId[i],locked: a,align:alignCol,width:new Number(this.coloumWidth[i]),header:"<b>"+this.headerName[i]+"</b>",id:this.coloumId[i],filter:{type:this.colType[i]}});    
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
            return new Ext.ux.grid.LockingColumnModel({
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
            var evtCl=function(){};
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
                        setRowIndex(ind); 
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
			view: this.modelcol
			
            //renderTo: this.renderTo
        });        
        this.grid.render(this.renderTo);
    }
}

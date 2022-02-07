function isiCombo(id,val,defaultId,targetId,evloaded,targetWindow){
	if(targetId=='' || targetId==undefined){
		targetId=id;
	}
	Request(cmbUtilsURL+'?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'',parent.window);
}
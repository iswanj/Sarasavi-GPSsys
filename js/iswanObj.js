function mouseEvent(e){
	if(e){
		this.e = e;
	} else {
		this.e = window.event;
	}
	
	if(e.pageX){
		this.x = e.pageX;
	} else {
		this.x = e.clientX;
	}
	
	if(e.pageY){
		this.y = e.pageY;
	} else {
		this.y = e.clientY;
	}
	
	if(e.target){
		this.target = e.target;
	} else {
		this.target = e.srcElement;
	}
}

function addEventHandler(oNode,sEvt,fFunc,bCaptures){
	if(typeof (window.attachEvent) != "undefined")
		oNode.attachEvent("on" + sEvt, fFunc);
	else
		oNode.addEventListener(sEvt, fFunc, bCaptures);
}

function removeEventHandler(oNode, sEvt, fFunc, bCaptures){
	if(typeof (window.attachEvent) != "undefined")
		oNode.detachEvent("on" + sEvt, fFunc);
	else
		oNode.removeEventListener(sEvt, fFunc, bCaptures);                 
}
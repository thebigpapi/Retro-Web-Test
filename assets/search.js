function setChipset(ok, formtype, sel1, sel2, sel_lb, typ, chk) {
    var chipManuf = document.getElementById(sel1).childNodes;
	var lb1 = document.getElementById(sel_lb);
	var lb2 = document.getElementById(sel2);
	lb1.innerHTML = ls;
	lb2.style.display="none";
	if(chk)
    	var form = document.getElementsByName(formtype + "_motherboard")[0];
	else
		var form = document.getElementsByName(formtype)[0];
    if (window.XMLHttpRequest)
        var xhttp = new XMLHttpRequest();
    else if (window.ActiveXObject)
        var xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xhttp.onreadystatechange = function() {  
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var currentForm = document.getElementById(sel2);
            var parser = document.getElementById('hiddenDiv');
			var lb1 = document.getElementById(sel_lb);
			lb1.innerHTML="";
			currentForm.style.display="";
            parser.innerHTML = xhttp.responseText;
            var doc = document.getElementById(sel2);
            currentForm.innerHTML =  doc.innerHTML;
            parser.innerHTML="";
			setMinWidth(sel1, sel2);
        }
    };
	
	var chipsetManufacturer = chipManuf[0].value;
	if(ok)chipsetManufacturer = "";
    var params = formtype + typ + chipsetManufacturer;
    xhttp.open('POST', form.action, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
}
function setMinWidth(sel1, sel2, chk) {
	if (!document.getElementsByClassName || (document.all && !window.atob)) {return;}
	if(chk){
		document.getElementById(sel1).getElementsByTagName('select')[0].style.minWidth =
		document.getElementById("setchip1").getElementsByTagName('select')[0].offsetWidth + 'px';
	}
	if (document.getElementById(sel1).offsetTop == document.getElementById(sel2).parentNode.offsetTop) {
		document.getElementById(sel2).getElementsByTagName('select')[0].style.minWidth =
		document.getElementById(sel1).parentNode.parentNode.offsetWidth * 0.9 - 7
		- document.getElementById(sel1).offsetWidth + 'px';
		document.getElementById(sel2).parentNode.style.padding='';
	} else {
		document.getElementById(sel2).getElementsByTagName('select')[0].style.minWidth =
		document.getElementById(sel1).getElementsByTagName('select')[0].offsetWidth + 'px';
		document.getElementById(sel2).parentNode.style.padding='8px 0';
	}
}

/* execution starts HERE; detect the selects and determine the type of search page*/
var chk = 0;
if (document.getElementsByName("search[platform1]")[0])
	chk = 1;
var formtype = "search";
var chip = document.getElementById(formtype + '_chipsetManufacturer');

var rst = document.getElementById('rst-btn');
var lb2 = document.getElementById('setchip2');
if(chk){
	var cpu1 = document.getElementById(formtype + '_cpuSocket1');
	var cpu2 = document.getElementById(formtype + '_cpuSocket2');
	var lb3 = document.getElementById('setcpu2');
	var lb4 = document.getElementById('setcpu4');
}
/* compatibility for IE JS*/
if (window.XMLHttpRequest)
    var xhttp = new XMLHttpRequest();
else if (window.ActiveXObject)
    var xhttp = new ActiveXObject("Microsoft.XMLHTTP");
if (xhttp) { 
	document.getElementById(formtype + '_searchChipsetManufacturer').parentNode.innerHTML="";
	setMinWidth("setchip1", "setchip2");
	if(chk){
		document.getElementById(formtype + '_searchSocket1').parentNode.innerHTML="";
		document.getElementById(formtype + '_searchSocket2').parentNode.innerHTML="";
		setMinWidth("setcpu1", "setcpu2", chk);
		setMinWidth("setcpu3", "setcpu4", chk);
	}
}
rst.onclick= function() {
	setChipset(1,formtype, "setchip1", "setchip2", "setchip-lb", "[chipsetManufacturer]=", chk);
	if(chk){
		setChipset(1,formtype, "setcpu1", "setcpu2", "setcpu1-lb", "[cpuSocket1]=", chk);
		setChipset(1,formtype, "setcpu3", "setcpu4", "setcpu2-lb", "[cpuSocket2]=", chk);
	}
};
chip.onchange= function() {
	setChipset(0,formtype, "setchip1", "setchip2", "setchip-lb", "[chipsetManufacturer]=", chk);
};
if(chk){
	cpu1.onchange= function() {
		setChipset(0,formtype, "setcpu1", "setcpu2", "setcpu1-lb", "[cpuSocket1]=", chk);
	};
	cpu2.onchange= function() {
		setChipset(0,formtype, "setcpu3", "setcpu4", "setcpu2-lb", "[cpuSocket2]=", chk);
	};
}
window.onresize = function() {
	setMinWidth("setchip1", "setchip2");
	if(chk){
		setMinWidth("setcpu1", "setcpu2", chk);
		setMinWidth("setcpu3", "setcpu4", chk);
	}
}
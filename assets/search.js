function setChipset(ok, formtype, sel1, sel2, sel_lb, typ) {
    var chipManuf = document.getElementById(sel1).children[0];
	var lb1 = document.getElementById(sel_lb);
	var lb2 = document.getElementById(sel2);
	lb1.style.display="";
	lb2.style.display="none";
    var form = document.getElementsByName(formtype)[0];
    if (window.XMLHttpRequest)
        var xhttp = new XMLHttpRequest();
    else if (window.ActiveXObject)
        var xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xhttp.onreadystatechange = function() {  
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var currentForm = document.getElementById(sel2).children[0];
            var parser = document.getElementById('hiddenDiv');
			var lb1 = document.getElementById(sel_lb);
			var lb2 = document.getElementById(sel2);
			lb1.style.display="none";
			lb2.style.display="";
			lb2.style.width="70%";
            parser.innerHTML = xhttp.responseText;
            var doc = document.getElementById(sel2).children[0];
            currentForm.innerHTML =  doc.innerHTML;
            parser.innerHTML="";
        }
    };
	var chipsetManufacturer = chipManuf.value;
	if(ok)chipsetManufacturer = "";
    var params = formtype + typ + chipsetManufacturer;
    xhttp.open('POST', form.action, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
}

/* execution starts HERE; detect the selects and determine the type of search page*/
if (document.getElementsByName("search_motherboard")[0])
	var formtype = "search_motherboard";
else
	var formtype = "search";
var chip = document.getElementById(formtype + '_chipsetManufacturer');

var rst = document.getElementById('rst-btn');
var lb2 = document.getElementById('setchip2');
if(formtype != "search"){
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
    document.getElementById(formtype + '_searchChipsetManufacturer').outerHTML="";
	lb2.style.width="70%";
	if(formtype != "search"){
		document.getElementById(formtype + '_searchSocket1').outerHTML="";
		document.getElementById(formtype + '_searchSocket2').outerHTML="";
		lb3.style.width="70%";
		lb4.style.width="70%";
	}
}

/* event listeners*/
function addEvent(evnt, elem, func){
    if(elem.addEventListener)
        elem.addEventListener(evnt,func,false);
    else if(elem.attachEvent) {
        elem.attachEvent("on"+evnt,func);
    }
    else elem["on"+evnt] = func;
}
rst.onclick= function() {
	setChipset(1,formtype, "setchip1", "setchip2", "setchip-lb", "[chipsetManufacturer]=");
	if(formtype != "search"){
		setChipset(1,formtype, "setcpu1", "setcpu2", "setcpu1-lb", "[cpuSocket1]=");
		setChipset(1,formtype, "setcpu3", "setcpu4", "setcpu2-lb", "[cpuSocket2]=");
	}
};
chip.onchange= function() {
	setChipset(0,formtype, "setchip1", "setchip2", "setchip-lb", "[chipsetManufacturer]=");
};
if(formtype != "search"){
	cpu1.onchange= function() {
		setChipset(0,formtype, "setcpu1", "setcpu2", "setcpu1-lb", "[cpuSocket1]=");
	};
	cpu2.onchange= function() {
		setChipset(0,formtype, "setcpu3", "setcpu4", "setcpu2-lb", "[cpuSocket2]=");
	};
}
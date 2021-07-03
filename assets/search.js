function setChipset(ok, formtype, sel1, sel2, sel_lb, typ, chk) {
    var chipManuf = document.getElementById(sel1).childNodes;
	var lb1 = document.getElementById(sel_lb);
	var lb2 = document.getElementById(sel2);
	lb1.style.display="";
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
			lb1.style.display="none";
			currentForm.style.display="";
			currentForm.style.width="100%";
            parser.innerHTML = xhttp.responseText;
            var doc = document.getElementById(sel2);
            currentForm.innerHTML =  doc.innerHTML;
            parser.innerHTML="";
        }
    };
	
	var chipsetManufacturer = chipManuf[0].value;
	if(ok)chipsetManufacturer = "";
    var params = formtype + typ + chipsetManufacturer;
    xhttp.open('POST', form.action, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
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
    document.getElementById(formtype + '_searchChipsetManufacturer').outerHTML="";
	lb2.style.width="100%";
	if(chk){
		document.getElementById(formtype + '_searchSocket1').outerHTML="";
		document.getElementById(formtype + '_searchSocket2').outerHTML="";
		lb3.style.width="100%";
		lb4.style.width="100%";
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
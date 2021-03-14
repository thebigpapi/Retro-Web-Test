function setChipset(ok, formtype) {
    var chipManuf = document.getElementById(formtype + "_chipsetManufacturer");
    var form = document.getElementsByName(formtype)[0];
    if (window.XMLHttpRequest)
        var xhttp = new XMLHttpRequest();
    else if (window.ActiveXObject)
        var xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    xhttp.onreadystatechange = function() {  
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var currentForm = document.getElementById('chipset_div');
            var parser = document.getElementById('hiddenDiv');
			var lb1 = document.getElementById('setchip1');
			var lb2 = document.getElementById('setchip2');
			lb1.style.display="none";
			lb2.style.display="";
			lb2.style.width="70%";
            parser.innerHTML = xhttp.responseText;
            var doc = document.getElementById('chipset_div');
            currentForm.innerHTML =  doc.innerHTML;
            parser.innerHTML="";
        }
    };
	var chipsetManufacturer = chipManuf.value;
	if(ok)var chipsetManufacturer = "";
    var params = formtype + "[chipsetManufacturer]="+chipsetManufacturer;
    xhttp.open('POST', form.action, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
}

/* execution starts HERE; detect the selects and determine the type of search page*/
var lb1 = document.getElementById('setchip1');
var lb2 = document.getElementById('setchip2');
if (document.getElementsByName("search_motherboard")[0])
	var formtype = "search_motherboard";
else
	var formtype = "search";
var chip = document.getElementById(formtype + '_chipsetManufacturer');
var rst = document.getElementById('rst-btn');

/* compatibility for IE JS*/
if (window.XMLHttpRequest)
    var xhttp = new XMLHttpRequest();
else if (window.ActiveXObject)
    var xhttp = new ActiveXObject("Microsoft.XMLHTTP");
if (xhttp) { 
    document.getElementById(formtype + '_searchChipsetManufacturer').outerHTML="";
	lb2.style.width="70%";
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
	setChipset(1,formtype);
	lb1.style.display="";
	lb2.style.display="none";
};
chip.onchange= function() {
	setChipset(0,formtype);
	lb1.style.display="";
	lb2.style.display="none";
};
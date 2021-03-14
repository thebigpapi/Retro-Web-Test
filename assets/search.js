function setChipset(ok) {
    var chipManuf = document.getElementById("search_motherboard_chipsetManufacturer");
    var form = document.getElementsByName("search_motherboard")[0];
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
    var params = "search_motherboard[chipsetManufacturer]="+chipsetManufacturer;
    xhttp.open('POST', form.action, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
}
var lb1 = document.getElementById('setchip1');
var lb2 = document.getElementById('setchip2');
if (window.XMLHttpRequest)
    var xhttp = new XMLHttpRequest();
else if (window.ActiveXObject)
    var xhttp = new ActiveXObject("Microsoft.XMLHTTP");
if (xhttp) { 
    document.getElementById('search_motherboard_searchChipsetManufacturer').outerHTML="";
	lb2.style.width="70%";
}
var chip = document.getElementById('search_motherboard_chipsetManufacturer');
var rst = document.getElementById('rst-btn');
function addEvent(evnt, elem, func){
    if(elem.addEventListener)
        elem.addEventListener(evnt,func,false);
    else if(elem.attachEvent) {
        elem.attachEvent("on"+evnt,func);
    }
    else elem["on"+evnt] = func;
}
rst.onclick= function() {
	setChipset(1);
	lb1.style.display="";
	lb2.style.display="none";
};
chip.onchange= function() {
	setChipset(0);
	lb1.style.display="";
	lb2.style.display="none";
};
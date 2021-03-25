/* add-collection-widget.js - most of the JS code runs from here */

//function to add new widgets; written by computerguy08
function expand(id) { 
	//store the table widget DOM in list and newWidget, increment the counter
	var list = document.getElementById(id);
	var counter = list.getAttribute("data-widget-counter");
	var newWidget = list.getAttribute("data-prototype");
	newWidget = newWidget.replace(/__name__/g, counter);
	newWidget = newWidget.replace("/>", ">");
	counter++;
	//set the new increment, create the new widget and concatenate after list
	list.setAttribute("data-widget-counter", counter);
	var newElem = document.createElement('div');
	if(id == 'images-fields-list')
		newElem.setAttribute("class", "addform");
	if(id == 'motherboardBios-fields-list' || id == 'manuals-fields-list')
		newElem.setAttribute("style", "width:100%"); 
	newElem.innerHTML = newWidget;
	list.appendChild(newElem);	
}
// function used to check <select> duplicate options
function check_sel(id){
	var item = document.getElementById(id).children;
	var tp = 0;
	if(id == 'motherboardIoPorts-fields-list' || id == 'motherboardExpansionSlots-fields-list')tp = 1;
	var array1 = [];
	for (var i = 0; i < item.length; i++) {
		for(var j = 0; j < item[i].children[tp].options.length; j++){
			if(!array1[j])array1[j] = 0;
			if(item[i].children[tp].options[j].selected)array1[j] += 1;
			if(array1[j] > 1)return true;
		}
	}
	return false;
}
// function used to check for null file uploads or duplicate 
function check_E(){
	var manual = document.getElementById('manuals-fields-list').children;
	var photo = document.getElementById('images-fields-list').children;
	for (var i = 0; i < manual.length; i++) {
		if(manual[i].children[2].children[0].files[0] == null){
			if (manual[i].children[3].children[0].value == ''){
				alert("One of the file upload fields is empty! (manual entry no." + (i + 1) + ")");
				return false;
			}
		}
	}
	for (var i = 0; i < photo.length; i++) {
		if(photo[i].children[0].children[0].files[0] == null){
			if (photo[i].children[6].children[0].value == ''){
				alert("One of the file upload fields is empty! (image entry no." + (i + 1) + ")");
				return false;
			}
		}
	}
	if (check_sel('cpuSockets-fields-list')){
		alert("CPU sockets has duplicate entries!");
		return false;}
	if (check_sel('processorPlatformTypes-fields-list')){
		alert("CPU platform has duplicate entries!");
		return false;}
	if (check_sel('motherboardMaxRams-fields-list')){
		alert("Max system RAM has duplicate entries!");
		return false;}
	if (check_sel('cacheSize-fields-list')){
		alert("Cache has duplicate entries!");
		return false;}	 
	if (check_sel('motherboardIoPorts-fields-list')){
		alert("I/O ports has duplicate entries!");
		return false;}
	if (check_sel('motherboardExpansionSlots-fields-list')){
		alert("Expansion slots has duplicate entries!");
		return false;}
	if (check_sel('knownIssues-fields-list')){
		alert("Known issues has duplicate entries!");
		return false;}
	if (check_sel('motherboardProcessor-fields-list')){
		alert("CPU has duplicate entries!");
		return false;}
	if (check_sel('cpuSpeed-fields-list')){
		alert("FSB speed has duplicate entries!");
		return false;}
	if (check_sel('coprocessors-fields-list')){
		alert("NPU has duplicate entries!");
		return false;}
	return true;
}

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

/* execution starts HERE; detect the selects and determine the type of search page*
var lb1 = document.getElementById('setchip1');
var lb2 = document.getElementById('setchip2');
var cp1 = document.getElementById('cpuSockets-fields-list');
//var cp2 = document.getElementById(formtype + '_chipsetManufacturer');

/* compatibility for IE JS*
if (window.XMLHttpRequest)
    var xhttp = new XMLHttpRequest();
else if (window.ActiveXObject)
    var xhttp = new ActiveXObject("Microsoft.XMLHTTP");
if (xhttp) { 
    document.getElementById('cpuSockets-fields-list').outerHTML="";
}

/* event listeners*
function addEvent(evnt, elem, func){
    if(elem.addEventListener)
        elem.addEventListener(evnt,func,false);
    else if(elem.attachEvent) {
        elem.attachEvent("on"+evnt,func);
    }
    else elem["on"+evnt] = func;
}
cp1.onchange= function() {
	alert("test");
	//setChipset(0,formtype);

};*/
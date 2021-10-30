/* add-collection-widget.js - most of the JS code runs from here */

//function used to delete widgets
function remove(id) {
	id.parentNode.parentNode.removeChild(id.parentNode);
}
//function used to add new widgets
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
	if(id.indexOf('images-fields-list') != -1)
		newElem.setAttribute("class", "addform");
	if(id == 'motherboardBios-fields-list' || id == 'manuals-fields-list')
		newElem.setAttribute("style", "width:100%"); 
	newElem.innerHTML = newWidget;
	list.appendChild(newElem);	
}
// function used to check duplicate widgets
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
// function used to check for null file uploads or duplicate widgets
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
	if (check_sel('processors-fields-list')){
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
// function used to remove all CPU widgets
function removeCPU(id) {
    var cpuSel = document.getElementById(id);
	cpuSel.innerHTML = "";
	var status = document.getElementById("status-label");
	if (id == "processors-fields-list")
		status.textContent="Removed all CPUs";
	if (id == "coprocessors-fields-list")
		status.textContent="Removed all NPUs";
	
}
function addCPU(id) {
	var cpuSel = document.getElementById(id);
	cpuSel.innerHTML = "";
	var cp_cnt = 0;
	var counter = cpuSel.getAttribute("data-widget-counter");
	expand(id);
	while(cpuSel.children[0].children[0].children[cp_cnt])
		cp_cnt++;
	for(var i = 1; i < cp_cnt; i++){
		expand(id);
		cpuSel.children[i].children[0].children[i].selected = 'selected';
	}
	counter = cp_cnt;
	var status = document.getElementById("status-label");
	if (id == "processors-fields-list")
		status.textContent="Added " + counter + " CPUs";
	if (id == "coprocessors-fields-list")
		status.textContent="Added " + counter + " NPUs";
}

function clone_board() {
	if (confirm('Are you sure you want to clone this board ?')) {
		//replace the form URL
		var str = window.location.href;
		var frm = document.getElementsByName("add_motherboard")[0];
		frm.action = str.substring(0, str.search("admin")) + 'admin/manage/motherboards/motherboards/add';
		// remove all files
		var images = document.getElementById("images-fields-list");
		images.innerHTML = '';
		var bioses = document.getElementById("motherboardBios-fields-list");
		bioses.innerHTML = '';
		var manuals = document.getElementById("manuals-fields-list");
		manuals.innerHTML = '';
		// submit the page
		var save = document.getElementById("motherboard_form_save");
		save.click();
	}
}

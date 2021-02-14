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
	if(id != 'images-fields-list')
		newElem.setAttribute("style", "width:100%"); 
	newElem.innerHTML = newWidget;
	list.appendChild(newElem);	
}
// function used to check for null file uploads
function check_E(){
	var manuals = document.getElementById('manuals-fields-list');
	var photos = document.getElementById('images-fields-list');
	var manual = manuals.children;
	var photo = photos.children;
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
	return true;
}
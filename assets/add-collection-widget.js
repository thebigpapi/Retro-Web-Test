//function to add new widgets; written by computerguy08
function expand(id) { 
	//store the table widget DOM in list and newWidget, increment the counter
	var list = document.getElementById(id);
	var counter = list.getAttribute("data-widget-counter");
	var newWidget = list.getAttribute("data-prototype");
	//alert(newWidget);
	newWidget = newWidget.replace(/__name__/g, counter);
	newWidget = newWidget.replace("/>", ">");
	counter++;
	//set the new increment, create the new widget and concatenate after list's last child node
	list.setAttribute("data-widget-counter", counter);
	var newElem = document.createElement('div');
	newElem.setAttribute("style", "width:100%"); 
	//alert(newWidget);
	newElem.innerHTML = newWidget;
	//alert(newElem.innerHTML);
	//alert(list.innerHTML);
	var c = list.childNodes;
	//alert(newElem.innerHTML);
	list.appendChild(newElem);
	//alert(list.outerHTML);	
}
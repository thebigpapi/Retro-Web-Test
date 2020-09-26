var btn = document.getElementsByTagName("button");

for (var n = 0; n < btn.length; n++) {
	if (btn[n].className == "add-another-collection-widget") {
		btn[n].onclick = function() {
			var list = document.getElementById(this.getAttribute("data-list-selector").substr(1));

			// Try to find the counter of the list or use the length of the list
			var counter = list.getAttribute("data-widget-counter");

			// grab the prototype template
			var newWidget = list.getAttribute("data-prototype");

			// replace the "__name__" used in the id and name of the prototype
			// with a unique number
			newWidget = newWidget.replace(/__name__/g, counter);

			// Increase the counter
			counter++;

			// And store it, the length cannot be used if deleting widgets is allowed
			list.setAttribute("data-widget-counter", counter);

			var newDelButton = document.createElement('button');
			newDelButton.innerText = "Delete";
			newDelButton.onclick = function() {list.removeChild(newElem);return false;};

			// create a new list element and add it to the list
			var newElem = document.createElement('li');
			newElem.innerHTML = newWidget;
			newElem.appendChild(newDelButton);
			list.appendChild(newElem);	
		};
	}
}
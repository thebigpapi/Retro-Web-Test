var btn = document.getElementsByTagName("button");

for (var n = 0; n < btn.length; n++) {
	if (btn[n].className == "add-another-collection-widget") {
		btn[n].onclick = function() {
			var list = document.getElementById(this.getAttribute("data-list-selector").substr(1));
			var counter = list.getAttribute("data-widget-counter");
			var newWidget = list.getAttribute("data-prototype");

			newWidget = newWidget.replace(/__name__/g, counter);
			counter++;
			list.setAttribute("data-widget-counter", counter);

			var newDelButton = document.createElement('button');
			newDelButton.innerText = "Del";
			newDelButton.onclick = function() {list.removeChild(newElem);return false;};
			var newElem = document.createElement('tr');
			newElem.innerHTML = newWidget;
			newElem.appendChild(newDelButton);
			list.appendChild(newElem);	
		};
	}
	if (btn[n].className == "add-another-image") {
		btn[n].onclick = function() {
			var list = document.getElementById(this.getAttribute("data-list-selector").substr(1));
			var counter = list.getAttribute("data-widget-counter");
			var newWidget = list.getAttribute("data-prototype");
			newWidget = newWidget.replace(/__name__/g, counter);
			counter++;
			list.setAttribute("data-widget-counter", counter);
			var newElem = document.createElement('div');
			newElem.classList.add("addform");
			newElem.innerHTML = newWidget;
			list.appendChild(newElem);	
		};
	}
}

var buttons = document.getElementsByTagName("BUTTON");
    for(i = 0;i < buttons.length-1; i++)
    {
        if(buttons[i].className==="delbutton")
			if(buttons[i].parentElement.className==="bis-image")
				buttons[i].addEventListener('click', function () { this.parentElement.parentElement.remove(); });
			else
				buttons[i].addEventListener('click', function () { this.parentElement.remove(); });
		if(buttons[i].className==="delbutton-img")
			buttons[i].addEventListener('click', function () { this.parentElement.parentElement.remove(); });
			
    }
import { Controller } from 'stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {

    expandButton(event) {
        let list = document.getElementById(event.target.dataset.listId);
        this.expand(list);
    }

    expand(list) {
        //store the table widget DOM in list and newWidget, increment the counter
        let counter = list.getAttribute("data-widget-counter");
        let newWidget = list.getAttribute("data-prototype");
        newWidget = newWidget.replace(/__name__/g, counter);
        newWidget = newWidget.replace("/>", ">");
        counter++;
        //set the new increment, create the new widget and concatenate after list
        list.setAttribute("data-widget-counter", counter);
        let newElem = document.createElement('div');
        /*if (listId.indexOf('images-fields-list') != -1)
            newElem.setAttribute("class", "addform");
        if (listId == 'motherboardBios-fields-list' || listId == 'manuals-fields-list')
            newElem.setAttribute("style", "width:100%");*/
        newElem.innerHTML = newWidget;
        list.appendChild(newElem);
    }

    removeButton(event) {
        this.remove(event.target.parentNode);
    }

    remove(element) {
        console.log(element.id);
        element.parentNode.removeChild(element);
    }

    clearAllButton(event) {
        let list = document.getElementById(event.target.dataset.listId);
        this.clearAll(list);
    }

    clearAll(list) {
        let _this = this;
        while (list.children.length) {
            _this.remove(list.children[0]);
        }
        let status = document.getElementById("status-label");
        status.textContent = "Removed all elements";
    }

    addAllButton(event) {
        let list = document.getElementById(event.target.dataset.listId);
        this.addAll(list);
    }

    addAll(list) {
        let _this = this;

        _this.clearAll(list);
        let counter = list.getAttribute("data-widget-counter");
        _this.expand(list);
        let elementCount = list.children[0].children[0].length;
        console.log(list.children[0]);

        for (var i = 1; i < elementCount; i++) {
            _this.expand(list);
            list.children[i].children[0].children[i].selected = 'selected';
        }
        counter = elementCount;
        let status = document.getElementById("status-label");
        status.textContent = "Added " + counter + " elements";
    }

    add(event) {

        let button = event.target;

        for (let n = 0; n < button.length; n++) {
            if (button[n].className == "add-another-collection-widget") {
                button[n].onclick = function () {
                    let list = document.getElementById(this.getAttribute("data-list-selector").substr(1));

                    // Try to find the counter of the list or use the length of the list
                    let counter = list.getAttribute("data-widget-counter");

                    // grab the prototype template
                    let newWidget = list.getAttribute("data-prototype");

                    // replace the "__name__" used in the id and name of the prototype
                    // with a unique number
                    newWidget = newWidget.replace(/__name__/g, counter);

                    // Increase the counter
                    counter++;

                    // And store it, the length cannot be used if deleting widgets is allowed
                    list.setAttribute("data-widget-counter", counter);

                    let newDelButton = document.createElement('button');
                    newDelButton.innerText = "Delete";
                    newDelButton.onclick = function () { list.removeChild(newElem); return false; };

                    // create a new list element and add it to the list
                    let newElem = document.createElement('li');
                    newElem.innerHTML = newWidget;
                    newElem.appendChild(newDelButton);
                    list.appendChild(newElem);
                };
            }
        }
    }

    addold(event) {

        let btn = document.getElementsByTagName("button");

        for (let n = 0; n < btn.length; n++) {
            if (btn[n].className == "add-another-collection-widget") {
                btn[n].onclick = function () {
                    let list = document.getElementById(this.getAttribute("data-list-selector").substr(1));

                    // Try to find the counter of the list or use the length of the list
                    let counter = list.getAttribute("data-widget-counter");

                    // grab the prototype template
                    let newWidget = list.getAttribute("data-prototype");

                    // replace the "__name__" used in the id and name of the prototype
                    // with a unique number
                    newWidget = newWidget.replace(/__name__/g, counter);

                    // Increase the counter
                    counter++;

                    // And store it, the length cannot be used if deleting widgets is allowed
                    list.setAttribute("data-widget-counter", counter);

                    let newDelButton = document.createElement('button');
                    newDelButton.innerText = "Delete";
                    newDelButton.onclick = function () { list.removeChild(newElem); return false; };

                    // create a new list element and add it to the list
                    let newElem = document.createElement('li');
                    newElem.innerHTML = newWidget;
                    newElem.appendChild(newDelButton);
                    list.appendChild(newElem);
                };
            }
        }
    }

}
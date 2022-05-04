import { Controller } from 'stimulus';

export default class extends Controller {

    expandButton(event) {
        let list = document.getElementById(event.target.dataset.listId);
        this.expand(list);
    }
    addLink(){
        if(document.getElementById('chipsetParts-fields-list')){
            let list = document.getElementById('chipsetParts-fields-list').childNodes;
            for (let item of list) {
                if(item.nodeName == "DIV"){
                    if(item.children[2].href.substring(item.children[2].href.length -1) == "#")
                        item.children[2].href = "../../parts/" + item.children[0].value + "/edit";
                }
            }
        }
    }
    addLinkOverride(){
        let list = document.getElementById('chipsetParts-fields-list').childNodes;
        for (let item of list) {
            if(item.nodeName == "DIV"){
                item.children[2].href = "../../parts/" + item.children[0].value + "/edit";
            }
        }
    }
    /**
     * Add an element to the list
     * @param {*} list the list to interract with
     */
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
        newElem.setAttribute("class", "editor-row");
        newElem.setAttribute("style", "padding:0");
        if (list.id === 'images-fields-list' || list.id === 'chip.images-fields-list' || list.id === 'processingUnit.chip.images-fields-list')
            newElem.setAttribute("class", newElem.getAttribute("class") + " addform");
        if (list.id === 'motherboardBios-fields-list' || list.id === 'manuals-fields-list')
            newElem.setAttribute("style", newElem.getAttribute("style") + " width:100%");
        newElem.innerHTML = newWidget;
        list.appendChild(newElem);
        this.addLink();
    }

    removeButton(event) {
        let element = event.target.parentNode;
        let list = element.parentNode;
        this.remove(element, list);
    }
    removeButtonXtd(event) {
        let element = event.target.parentNode.parentNode.parentNode;
        let list = element.parentNode;
        this.remove(element, list);
    }

    /**
     * Remove the given element
     * @param {*} element 
     * @param {*} list
     */
    remove(element, list) {
        list.removeChild(element);
    }

    clearAllButton(event) {
        let list = document.getElementById(event.target.dataset.listId);
        this.clearAll(list);
    }

    /**
     * Remove each element from the list
     * @param {*} list 
     */
    clearAll(list) {
        let _this = this;
        while (list.children.length) {
            _this.remove(list.children[0], list);
        }
        let status = document.getElementById("status-label");
        status.textContent = "Removed all elements";
    }

    addAllButton(event) {
        let list = document.getElementById(event.target.dataset.listId);
        this.addAll(list);
    }

    /**
     * Add every possible element in the list
     * @param {*} list 
     */
    addAll(list) {
        let _this = this;

        _this.clearAll(list);
        let counter = list.getAttribute("data-widget-counter");
        _this.expand(list);
        let elementCount = list.children[0].children[0].length;
        console.log(list.children[0]);

        for (let i = 1; i < elementCount; i++) {
            _this.expand(list);
            list.children[i].children[0].children[i].selected = 'selected';
        }
        counter = elementCount;
        let status = document.getElementById("status-label");
        status.textContent = "Added " + counter + " elements";
    }
}
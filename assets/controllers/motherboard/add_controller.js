import { Controller } from 'stimulus';

export default class extends Controller {

    /**
     * Check a specific list for duplicates
     * @param {*} id 
     * @returns bool
     */
    checkList(id) {
        let list = document.getElementById(id);
        let tp = 0;
        if (id === 'motherboardIoPorts-fields-list' || id === 'motherboardExpansionSlots-fields-list') {
            tp = 1;
        }
        if(Object.keys(list.children).length == 0)
            return false;
        let array = Array().fill(0);
        
        for (let i=0; i< Object.keys(list.children).length; i++) {
            for (let j = 0; j < list.children[i].children[tp].options.length; j++) {
                let itm = list.children[i].children[tp].options[j];
                if (!array[itm.value]) {
                    array[itm.value] = 0;
                }
                if (itm.selected) {
                    array[itm.value] += 1;
                }
                if (array[itm.value] > 1) {
                    return true;
                }
            }
        }
        return false;
    }

    getslug() {
        let manuf = document.getElementById('motherboard_form_manufacturer');
        let name = document.getElementById('motherboard_form_name');
        let slug = document.getElementById('motherboard_form_slug');
        let string = manuf.options[manuf.selectedIndex].text;
        if(string == '')
            string = 'unknown ' + name.value;
        else
            string = string + ' ' + name.value;
        slug.value = string.replace(/[^a-z0-9_]+/gi, '-').replace(/^-|-$/g, '').toLowerCase().substring(0, 43);
    }
    /**
     * Check that everything is fine before submiting the board
     * @param {*} event 
     */
    check(event) {
        let _this = this;

        let error = false;
        let errorMessage = "";
        
        let manualList = document.getElementById('manuals-fields-list').children;
        for (let manual of manualList) {
            if (manual.children[2].children[0].files[0] == null) {
                if (manual.children[3].children[0].value == '') {
                    errorMessage += "One of the manual file upload fields is empty!\n";
                    error = true;
                }
            }
        }
        let miscList = document.getElementById('miscfile-fields-list').children;
        for (let misc of miscList) {
            if (misc.children[1].children[0].files[0] == null) {
                if (misc.children[2].children[0].value == '') {
                    errorMessage += "One of the misc file upload fields is empty!\n";
                    error = true;
                }
            }
        }
        let imageList = document.getElementById('images-fields-list').children;
        for (let image of imageList) {
            if (image.children[2].children[1].files[0] == null) {
                if (image.children[5].children[1].value == '') {
                    errorMessage += "One of the image file upload fields is empty!\n";
                    error = true;
                }
            }
        }
        let driverList = document.getElementById('drivers-fields-list').children;
        for (let driver of driverList) {
            if (!driver.children[0].children[0].value) {
                errorMessage += "One of the drivers is empty!\n";
                error = true;
            }
        }
        let aliasesList = document.getElementById('motherboardAliases-fields-list').children;
        for (let alias of aliasesList) {
            if (alias.children[0].children[0].value == "EMPTY") {
                errorMessage += "One of the aliases is empty!\n";
                error = true;
            }
        }
        let slug = document.getElementById('motherboard_form_slug');
        if(slug.value == '')
            this.getslug();
        if (_this.checkList('cpuSockets-fields-list')) {
            errorMessage += "CPU sockets has duplicate entries!\n";
            error = true;
        }
        if (_this.checkList('processorPlatformTypes-fields-list')) {
            errorMessage += "CPU family has duplicate entries!\n";
            error = true;
        }
        if (_this.checkList('motherboardMaxRams-fields-list')) {
            errorMessage += "Max system RAM has duplicate entries!\n";
            error = true;
        }
        if (_this.checkList('cacheSize-fields-list')) {
            errorMessage += "Cache has duplicate entries!\n";
            error = true;
        }
        if (_this.checkList('motherboardIoPorts-fields-list')) {
            errorMessage += "I/O ports has duplicate entries!\n";
            error = true;
        }
        if (_this.checkList('motherboardExpansionSlots-fields-list')) {
            errorMessage += "Expansion slots has duplicate entries!\n";
            error = true;
        }
        if (_this.checkList('knownIssues-fields-list')) {
            errorMessage += "Known issues has duplicate entries!\n";
            error = true;
        }
        if (_this.checkList('cpuSpeed-fields-list')) {
            errorMessage += "FSB speed has duplicate entries!\n";
            error = true;
        }
        if (error) {
            alert(errorMessage);
            event.preventDefault();
        }
    }
    /**
     * Save the motherboard
     */
    submit() {
        let submit_btn = document.getElementById("motherboard_form_save");
        this.checkAllCheckBoxes();
        submit_btn.click();
    }
    /**
     * Clone the motherboard
     */
    clone() {
        if (confirm('Are you sure you want to clone this board ?')) {
            //replace the form URL
            let str = window.location.href;
            let form = document.getElementsByName("add_motherboard")[0];
            form.action = str.substring(0, str.search("admin")) + 'admin/manage/motherboards/motherboards/add';
            // remove all files
            let images = document.getElementById("images-fields-list");
            images.innerHTML = '';
            let bioses = document.getElementById("motherboardBios-fields-list");
            bioses.innerHTML = '';
            let manuals = document.getElementById("manuals-fields-list");
            manuals.innerHTML = '';
            let redirections = document.getElementById("redirections-fields-list");
            redirections.innerHTML = '';
			let slug = document.getElementById('motherboard_form_slug');
			slug.value = "";
			window.history.replaceState({},'', window.location.origin + '/admin/manage/motherboards/motherboards/add');
        }
    }

    /**
     * Fetch CPU/NPU lists based on the parameters given by the user
     * @param {*} event 
     */
    updateProcessors(event) {
        event.preventDefault();
        let _this = this;
        let sockets = document.getElementById("cpuSockets-fields-list").children;
        let platforms = document.getElementById("processorPlatformTypes-fields-list").children;
        let frequencies = document.getElementById("cpuSpeed-fields-list").children;
        _this.checkAllCheckBoxes();
        let processors = document.getElementById("motherboard_form_processors").children;
        let coprocessors = document.getElementById("motherboard_form_coprocessors").children;
        let slug = document.getElementById("motherboard_form_slug");
        
        let form = _this.element;

        let params = new FormData();
        params.set(slug.name, slug.value);
        for (let socket of sockets) {
            let element = socket.children[0];
            params.set(element.name, element.value);
        }
        for (let platform of platforms) {
            let element = platform.children[0];
            params.set(element.name, element.value);
        }
        for (let frequency of frequencies) {
            let element = frequency.children[0];
            params.set(element.name, element.value);
        }
        for (let processor of processors) {
            if (processor.checked) {
                params.append(processor.name, processor.value);
            }
        }
        for (let coprocessor of coprocessors) {
            if (coprocessor.checked) {
                params.append(coprocessor.name, coprocessor.value);
            }
        }
        let cursor = document.getElementById("cpu-wait");
        cursor.style.display = "";
        (async () => {
            const rawResponse = await fetch(form.action, {
                method: 'POST',
                body: params
            });
            let parser = new DOMParser();
            //console.log(await rawResponse.text());
            let parsedResponse = parser.parseFromString(await rawResponse.text(), "text/html");
            document.getElementById("cpuSockets-fields-list").innerHTML = parsedResponse.getElementById("cpuSockets-fields-list").innerHTML;
            document.getElementById("processorPlatformTypes-fields-list").outerHTML = parsedResponse.getElementById("processorPlatformTypes-fields-list").outerHTML;
            document.getElementById("processorPlatformTypes-fields-list").innerHTML = parsedResponse.getElementById("processorPlatformTypes-fields-list").innerHTML;
            document.getElementById("cpuSpeed-fields-list").outerHTML = parsedResponse.getElementById("cpuSpeed-fields-list").outerHTML;
            document.getElementById("cpuSpeed-fields-list").innerHTML = parsedResponse.getElementById("cpuSpeed-fields-list").innerHTML;
            document.getElementById("motherboard_form_processors").outerHTML = parsedResponse.getElementById("motherboard_form_processors").outerHTML;
            document.getElementById("motherboard_form_processors").innerHTML = parsedResponse.getElementById("motherboard_form_processors").innerHTML;
            document.getElementById("motherboard_form_coprocessors").outerHTML = parsedResponse.getElementById("motherboard_form_coprocessors").outerHTML;
            document.getElementById("motherboard_form_coprocessors").innerHTML = parsedResponse.getElementById("motherboard_form_coprocessors").innerHTML;
            let new_platforms = document.getElementById("processorPlatformTypes-fields-list");
            for (let new_platform of new_platforms.children) {
                if (new_platform.children[2])
                    if (new_platform.children[2].nodeName == "UL")
                        new_platform.children[2].outerHTML = "";
            }
            this.initProcessorsFromDom(document);
            cursor.style.display = "none";


        })();

    }

    //Processors
    uncheckedProcessors = new Array();
    checkedProcessors = new Array();

    //Coprocessors
    uncheckedCoprocessors = new Array();
    checkedCoprocessors = new Array();

    connect() {
        this.initProcessorsFromDom(document);
    }

    initProcessorsFromDom(dom) {
        //Processors
        this.uncheckedProcessors = new Array();
        this.checkedProcessors = new Array();

        //Coprocessors
        this.uncheckedCoprocessors = new Array();
        this.checkedCoprocessors = new Array();

        let cpusTags = dom.getElementById('motherboard_form_processors');
        let npusTags = dom.getElementById('motherboard_form_coprocessors');

        cpusTags.childNodes.forEach(tag => {
            if (tag.tagName==="INPUT") {
                if (tag.checked) {
                    this.checkedProcessors.push({name:tag.labels[0].textContent, value:tag.value, tag});
                } else {
                    this.uncheckedProcessors.push({name:tag.labels[0].textContent, value:tag.value, tag});
                }
            }
        });

        npusTags.childNodes.forEach(tag => {
            if (tag.tagName==="INPUT") {
                if (tag.checked) {
                    this.checkedCoprocessors.push({name:tag.labels[0].textContent, value:tag.value, tag});
                } else {
                    this.uncheckedCoprocessors.push({name:tag.labels[0].textContent, value:tag.value, tag});
                }
            }
        });

        this.applyListsToSelects();
    }

    sortProcessors() {
        this.uncheckedProcessors.sort((a, b) => {
            return a.name >= b.name;
        });
        this.checkedProcessors.sort((a, b) => {
            return a.name >= b.name;
        });
    }

    sortCoprocessors() {
        this.uncheckedCoprocessors.sort((a, b) => {
            return a.name >= b.name;
        });
        this.checkedCoprocessors.sort((a, b) => {
            return a.name >= b.name;
        });
    }


    /**
     * Add all processors to the motherboard
     * @param {*} event 
     */
    addAllProcessors(event) {
        event.preventDefault();
        this.moveAllValuesToList(this.uncheckedProcessors, this.checkedProcessors);
    }

    /**
     * Add all selected processors to the motherboard
     * @param {*} event 
     */
    addAllSelectedProcessors(event) {
        event.preventDefault();
        this.moveSelectedValuesToList(document.getElementById('unchecked_processors'), this.uncheckedProcessors, this.checkedProcessors);
    }

    /**
     * Remove all selected processors from the motherboard
     * @param {*} event 
     */
    removeAllSelectedProcessors(event) {
        event.preventDefault();
        this.moveSelectedValuesToList(document.getElementById('checked_processors'), this.checkedProcessors, this.uncheckedProcessors);
    }

    /**
     * Remove processors from the motherboard
     * @param {*} event 
     */
    removeAllProcessors(event) {
        event.preventDefault();
        this.moveAllValuesToList(this.checkedProcessors, this.uncheckedProcessors);
    }

    /**
     * Add all coprocessors to the motherboard
     * @param {*} event 
     */
    addAllCoprocessors(event) {
        event.preventDefault();
        this.moveAllValuesToList(this.uncheckedCoprocessors, this.checkedCoprocessors);
    }

    /**
     * Add all selected coprocessors to the motherboard
     * @param {*} event 
     */
    addAllSelectedCoprocessors(event) {
        event.preventDefault();
        this.moveSelectedValuesToList(document.getElementById('unchecked_coprocessors'), this.uncheckedCoprocessors, this.checkedCoprocessors);
    }

    /**
     * Remove all selected coprocessors from the motherboard
     * @param {*} event 
     */
    removeAllSelectedCoprocessors(event) {
        event.preventDefault();
        this.moveSelectedValuesToList(document.getElementById('checked_coprocessors'), this.checkedCoprocessors, this.uncheckedCoprocessors);
    }

    /**
     * Remove coprocessors from the motherboard
     * @param {*} event 
     */
    removeAllCoprocessors(event) {
        event.preventDefault();
        this.moveAllValuesToList(this.checkedCoprocessors, this.uncheckedCoprocessors);
    }

    moveSelectedValuesToList(sourceSelect, source, destination) {
        [...sourceSelect.options]
        .filter(option => option.selected)
        .forEach(option => {
            let processor = source.filter(elt => elt.value === option.value)[0];
            source.splice(source.indexOf(processor), 1);
            destination.push(processor);
            option.remove();
        });
        this.applyListsToSelects();
    }

    moveAllValuesToList(source, destination) {
        destination.push(...source);
        source.splice(0, source.length);
        this.applyListsToSelects();
    }

    /**
     * Set the content of uncheckedProcessors[] and checkedProcessors[] to the two select lists
     */
    applyListsToSelects() {
        // Sort processors
        this.sortProcessors();
        this.sortCoprocessors();

        // Calculating max size of processor selects
        let cpuSize = this.uncheckedProcessors.length + this.checkedProcessors.length;
        let npuSize = this.uncheckedCoprocessors.length + this.checkedCoprocessors.length;

        this.applyListsToSelect(document.getElementById('unchecked_processors'), this.uncheckedProcessors, cpuSize);
        this.applyListsToSelect(document.getElementById('checked_processors'), this.checkedProcessors, cpuSize);
        this.applyListsToSelect(document.getElementById('unchecked_coprocessors'), this.uncheckedCoprocessors, npuSize);
        this.applyListsToSelect(document.getElementById('checked_coprocessors'), this.checkedCoprocessors, npuSize);
    }

    applyListsToSelect(select, list, size) {
        //Clearing select
        select.innerHTML = "";

        //Adding the processors from list to the list
        list.forEach(proc => {
            let option = document.createElement("option");
            option.value = proc.value;
            option.text = proc.name;
            select.add(option, null);
        });

        //Setting size to the select
        select.setAttribute('size', size);
    }

    checkAllCheckBoxes() {
        this.checkedProcessors.forEach(processor => {
            processor.tag.checked=true;
        });
        this.uncheckedProcessors.forEach(processor => {
            processor.tag.checked=false;
        });

        this.checkedCoprocessors.forEach(coprocessor => {
            coprocessor.tag.checked=true;
        });
        this.uncheckedCoprocessors.forEach(coprocessor => {
            coprocessor.tag.checked=false;
        });
    }
}

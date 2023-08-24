import { Controller } from 'stimulus';

export default class extends Controller {

    connect() {
        //this.initProcessorsFromDom(document);
    }

    getslug() {
        let manuf = document.getElementById('Motherboard_manufacturer');
        let name = document.getElementById('Motherboard_name');
        let slug = document.getElementById('Motherboard_slug');
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
        let slug = document.getElementById('Motherboard_slug');
        if(slug.value == '')
            this.getslug();

        for (let msgId of this.checkFile("Motherboard_manuals_", "_manualFile")){
            errorMessage += "Manual with title \"" + document.getElementById("Motherboard_manuals_" + msgId + "_link_name").value + "\" is missing the file!\n";
            error = true;
        }
        for (let msgId of this.checkFile("Motherboard_motherboardBios_", "_romFile")){
            if(document.getElementById("Motherboard_motherboardBios_" + msgId + "_boardVersion").value=="")
                errorMessage += "BIOS with POST string \"" + document.getElementById("Motherboard_motherboardBios_" + msgId + "_postString").value + "\" is missing the file!\n";
            else
                errorMessage += "BIOS with version \"" + document.getElementById("Motherboard_motherboardBios_" + msgId + "_postString").value + "\" is missing the file!\n";
            error = true;
        }
        for (let msgId of this.checkFile("Motherboard_miscFiles_", "_miscFile")){
            errorMessage += "Misc file with title \"" + document.getElementById("Motherboard_miscFiles_" + msgId + "_link_name").value + "\" is missing the file!\n";
            error = true;
        }
        for (let msgId of this.checkImageFile("Motherboard_images_", "_imageFile")){
            let creditor = document.getElementById("Motherboard_images_" + msgId + "_creditor")
            let type = document.getElementById("Motherboard_images_" + msgId + "_motherboardImageType")

            if(creditor.options[creditor.selectedIndex].text=="")
                errorMessage += "Image with type \"" + type.options[type.selectedIndex].text + "\" is missing the file!\n";
            else
                errorMessage += "Image with creditor \"" + creditor.options[creditor.selectedIndex].text + "\" is missing the file!\n";

            error = true;
        }
        if (error) {
            alert(errorMessage);
            event.preventDefault();
        }
    }

    checkFile(id, attribute) {
        let cnt = 0;
        let errorIDs = [];
        while(document.getElementById(id + cnt)){
            if (document.getElementById(id + cnt + attribute + "_file_link")==null && document.getElementById(id + cnt + attribute + "_file_new_file_name").innerHTML=="")
                errorIDs.push(cnt);
            cnt++;
        }
        return errorIDs;
    }
    checkImageFile(id, attribute) {
        let cnt = 0;
        let errorIDs = [];
        while(document.getElementById(id + cnt)){
            if (document.getElementById("ea-lightbox-" + id + cnt + attribute)==null && document.getElementById(id + cnt + attribute + "_file_new_file_name").innerHTML=="")
                errorIDs.push(cnt);
            cnt++;
        }
        return errorIDs;
    }
    submit() {
        let submit_btn = document.getElementsByClassName('action-saveAndReturn btn btn-primary action-save')[0];
        if (submit_btn.disabled)
            submit_btn.disabled=false;
        //this.checkAllCheckBoxes();
        submit_btn.click();
    }
    submitcontinue() {
        let submit_btn = document.getElementsByClassName('action-saveAndContinue btn btn-secondary action-save')[0];
        if (submit_btn.disabled)
            submit_btn.disabled=false;
        //this.checkAllCheckBoxes();
        submit_btn.click();
    }
    submitnewadd() {
        let submit_btn = document.getElementsByClassName('action-saveAndAddAnother btn btn-secondary action-save')[0];
        if (submit_btn.disabled)
            submit_btn.disabled=false;
        //this.checkAllCheckBoxes();
        submit_btn.click();
    }

    /**
     * Fetch CPU/NPU lists based on the parameters given by the user
     * @param {*} event 
     */
    updateProcessors(event) {
        event.preventDefault();
        let _this = this;
        _this.checkAllCheckBoxes();
        //let processors = document.getElementById("motherboard_form_processors").children;
        //let coprocessors = document.getElementById("motherboard_form_coprocessors").children;
        let slug = document.getElementById('Motherboard_slug');
        let form = _this.element;

        let params = new FormData();
        params.set(slug.name, slug.value);
        let cnt = 0;
        while(document.getElementById("Motherboard_cpuSockets_" + cnt)){
            let element = document.getElementById("Motherboard_cpuSockets_" + cnt);
            params.set(element.name, element.value);
            cnt++;
        }
        cnt = 0;
        while(document.getElementById("Motherboard_processorPlatformTypes_" + cnt)){
            let element = document.getElementById("Motherboard_processorPlatformTypes_" + cnt);
            params.set(element.name, element.value);
            cnt++;
        }
        cnt = 0;
        while(document.getElementById("Motherboard_cpuSpeed_" + cnt)){
            let element = document.getElementById("Motherboard_cpuSpeed_" + cnt);
            params.set(element.name, element.value);
            cnt++;
        }
        /*for (let processor of processors) {
            if (processor.checked) {
                params.append(processor.name, processor.value);
            }
        }
        for (let coprocessor of coprocessors) {
            if (coprocessor.checked) {
                params.append(coprocessor.name, coprocessor.value);
            }
        }*/
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
            console.log(parsedResponse);
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

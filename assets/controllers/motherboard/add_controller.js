import { Controller } from 'stimulus';

export default class extends Controller {

    /**
     * Check a specific list for duplicates
     * @param {*} id 
     * @returns bool
     */
    checkList(id) {
        let list = document.getElementById(id).children;
        let tp = 0;
        if (id === 'motherboardIoPorts-fields-list' || id === 'motherboardExpansionSlots-fields-list') {
            tp = 1;
        }
        let array = Array();
        for (let element of list) {
            for (let j = 0; j < element.children[tp].options.length; j++) {
                if (!array[j]) {
                    array[j] = 0;
                }
                if (element.children[tp].options[j].selected) {
                    array[j] += 1;
                }
                if (array[j] > 1) {
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
        let imageList = document.getElementById('images-fields-list').children;
        for (let image of imageList) {
            if (image.children[1].children[0].files[0] == null) {
                if (image.children[6].children[0].value == '') {
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
            errorMessage += "CPU platform has duplicate entries!\n";
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
        if (_this.checkList('processors-fields-list')) {
            errorMessage += "CPU has duplicate entries!\n";
            error = true;
        }
        if (_this.checkList('cpuSpeed-fields-list')) {
            errorMessage += "FSB speed has duplicate entries!\n";
            error = true;
        }
        if (_this.checkList('coprocessors-fields-list')) {
            errorMessage += "NPU has duplicate entries!\n";
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
            this.getslug();
            // submit the page
            this.submit();
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
        let processors = document.getElementById("processors-fields-list").children;
        let coprocessors = document.getElementById("coprocessors-fields-list").children;
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
            let element = processor.children[0];
            params.set(element.name, element.value);
        }
        for (let coprocessor of coprocessors) {
            let element = coprocessor.children[0];
            params.set(element.name, element.value);
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
            document.getElementById("processors-fields-list").outerHTML = parsedResponse.getElementById("processors-fields-list").outerHTML;
            document.getElementById("processors-fields-list").innerHTML = parsedResponse.getElementById("processors-fields-list").innerHTML;
            document.getElementById("coprocessors-fields-list").outerHTML = parsedResponse.getElementById("coprocessors-fields-list").outerHTML;
            document.getElementById("coprocessors-fields-list").innerHTML = parsedResponse.getElementById("coprocessors-fields-list").innerHTML;
            let new_platforms = document.getElementById("processorPlatformTypes-fields-list");
            for (let new_platform of new_platforms.children) {
                if (new_platform.children[2])
                    if (new_platform.children[2].nodeName == "UL")
                        new_platform.children[2].outerHTML = "";
            }
            let new_cpus = document.getElementById("processors-fields-list");
            for (let i = new_cpus.children.length - 1; i > 0; i -= 1) {
                if (new_cpus.children[i])
                    if (new_cpus.children[i].nodeName == "UL") {
                        new_cpus.children[i].outerHTML = "";
                        i -= 1;
                        new_cpus.children[i].outerHTML = "";
                    }
            }
            cursor.style.display = "none";


        })();

    }
}

import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        this.addLink();
    }
    addLink(){
        let list = document.getElementById('chipsetParts-fields-list').childNodes;
        list.forEach(function(item){ 
            if((item.nodeName == "DIV") && (item.children[2].href.substring(item.children[2].href.length -1) == "#")){
                item.children[2].href = "../../parts/" + item.children[0].value + "/edit";
            }
        });
    }
    /**
     * Check a specific list for duplicates
     * @param {*} id 
     * @returns bool
     */
    checkList(id) {
        let list = document.getElementById(id).children;
        let tp = 0;
        if (id == 'motherboardIoPorts-fields-list' || id == 'motherboardExpansionSlots-fields-list') {
            tp = 1;
        }
        let array = [];
        for (let i = 0; i < list.length; i++) {
            for (let j = 0; j < list[i].children[tp].options.length; j++) {
                if (!array[j]) {
                    array[j] = 0;
                }
                if (list[i].children[tp].options[j].selected) {
                    array[j] += 1;
                }
                if (array[j] > 1) {
                    return true;
                }
            }
        }
        return false;
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
        for (let i = 0; i < manualList.length; i++) {
            if (manualList[i].children[2].children[0].files[0] == null) {
                if (manualList[i].children[3].children[0].value == '') {
                    errorMessage += "One of the file upload fields is empty! (manual entry no." + (i + 1) + ")\n";
                    error = true;
                }
            }
        }

        let imageList = document.getElementById('images-fields-list').children;
        for (let i = 0; i < imageList.length; i++) {
            if (imageList[i].children[1].children[0].files[0] == null) {
                if (imageList[i].children[7].children[0].value == '') {
                    errorMessage += "One of the file upload fields is empty! (image entry no." + (i + 1) + ")\n";
                    error = true;
                }
            }
        }
        let driverList = document.getElementById('drivers-fields-list').children;
        for (let i = 0; i < driverList.length; i++) {
            if (!driverList[i].children[0].children[0].value) {
                errorMessage += "One of the drivers is empty! (entry no." + (i + 1) + ")\n";
                error = true;
            }
        }
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
        let submit_btn = document.getElementById("chipset_form_save");
        submit_btn.click();
    }
}

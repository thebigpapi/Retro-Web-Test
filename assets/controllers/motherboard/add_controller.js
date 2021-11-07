import { Controller } from 'stimulus';

export default class extends Controller {

    /**
     * Check a specific element
     * @param {*} id 
     * @returns bool
     */
    check_sel(id) {
        let item = document.getElementById(id).children;
        let tp = 0;
        if (id == 'motherboardIoPorts-fields-list' || id == 'motherboardExpansionSlots-fields-list') {
            tp = 1;
        }
        let array1 = [];
        for (let i = 0; i < item.length; i++) {
            for (let j = 0; j < item[i].children[tp].options.length; j++) {
                if (!array1[j]) {
                    array1[j] = 0;
                }
                if (item[i].children[tp].options[j].selected) {
                    array1[j] += 1;
                }
                if (array1[j] > 1) {
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

        console.log("Checking");
        let manual = document.getElementById('manuals-fields-list').children;
        let photo = document.getElementById('images-fields-list').children;
        for (let i = 0; i < manual.length; i++) {
            if (manual[i].children[2].children[0].files[0] == null) {
                if (manual[i].children[3].children[0].value == '') {
                    errorMessage += "One of the file upload fields is empty! (manual entry no." + (i + 1) + ")\n";
                    error = true;
                }
            }
        }
        for (let i = 0; i < photo.length; i++) {
            if (photo[i].children[0].children[0].files[0] == null) {
                if (photo[i].children[6].children[0].value == '') {
                    errorMessage += "One of the file upload fields is empty! (image entry no." + (i + 1) + ")\n";
                    error = true;
                }
            }
        }
        if (_this.check_sel('cpuSockets-fields-list')) {
            errorMessage += "CPU sockets has duplicate entries!\n";
            error = true;
        }
        if (_this.check_sel('processorPlatformTypes-fields-list')) {
            errorMessage += "CPU platform has duplicate entries!\n";
            error = true;
        }
        if (_this.check_sel('motherboardMaxRams-fields-list')) {
            errorMessage += "Max system RAM has duplicate entries!\n";
            error = true;
        }
        if (_this.check_sel('cacheSize-fields-list')) {
            errorMessage += "Cache has duplicate entries!\n";
            error = true;
        }
        if (_this.check_sel('motherboardIoPorts-fields-list')) {
            errorMessage += "I/O ports has duplicate entries!\n";
            error = true;
        }
        if (_this.check_sel('motherboardExpansionSlots-fields-list')) {
            errorMessage += "Expansion slots has duplicate entries!\n";
            error = true;
        }
        if (_this.check_sel('knownIssues-fields-list')) {
            errorMessage += "Known issues has duplicate entries!\n";
            error = true;
        }
        if (_this.check_sel('processors-fields-list')) {
            errorMessage += "CPU has duplicate entries!\n";
            error = true;
        }
        if (_this.check_sel('cpuSpeed-fields-list')) {
            errorMessage += "FSB speed has duplicate entries!\n";
            error = true;
        }
        if (_this.check_sel('coprocessors-fields-list')) {
            errorMessage += "NPU has duplicate entries!\n";
            error = true;
        }

        if (error) {
            alert(errorMessage);
            event.preventDefault();
        }
    }

    /**
     * Clone the motherboard
     */
    clone() {
        if (confirm('Are you sure you want to clone this board ?')) {
            //replace the form URL
            let str = window.location.href;
            let frm = document.getElementsByName("add_motherboard")[0];
            frm.action = str.substring(0, str.search("admin")) + 'admin/manage/motherboards/motherboards/add';
            // remove all files
            let images = document.getElementById("images-fields-list");
            images.innerHTML = '';
            let bioses = document.getElementById("motherboardBios-fields-list");
            bioses.innerHTML = '';
            let manuals = document.getElementById("manuals-fields-list");
            manuals.innerHTML = '';
            // submit the page
            let save = document.getElementById("motherboard_form_save");
            save.click();
        }
    }
}

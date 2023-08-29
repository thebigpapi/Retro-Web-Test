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
        if(document.getElementById(id + 0)==null)
            cnt = 1;
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
     * Fetch CPU family list based on the parameters given by the user
     */
    updateFamilies() {
        let params = [];
        let cnt = 0;
        if(document.getElementById("Motherboard_cpuSockets_0")==null)
            cnt = 1;
        // read CPU sockets
        while(document.getElementById("Motherboard_cpuSockets_" + cnt)){
            let element = document.getElementById("Motherboard_cpuSockets_" + cnt);
            params.push(element.value);
            cnt++;
        }
        cnt = 0;
        // fetch new platforms based on sockets
        let post = JSON.stringify(params)
        let platformArray = {};
        let url = window.location.origin + "/dashboard/getcpufamilies";
        let xhr = new XMLHttpRequest()
        xhr.open('POST', url, true)
        xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
        xhr.send(post);
        xhr.onload = function () {
            if(xhr.status === 200) {
                platformArray = JSON.parse(xhr.responseText);
                 // update existing selects
                while(document.getElementById("Motherboard_processorPlatformTypes_" + cnt)){
                    let element = document.getElementById("Motherboard_processorPlatformTypes_" + cnt);
                    let selectedValue = element.options[element.selectedIndex].value;
                    let selected = false;
                    let invalidOp = new Option("Invalid CPU family, reselect!",'');
                    invalidOp.setAttribute("selected", "selected");
                    element.innerHTML = "";
                    for(const key in platformArray){
                        let option = new Option(platformArray[key],key.slice(1));
                        if(key == selectedValue){
                            option.setAttribute("selected", "selected");
                            selected = true;
                        }
                        element.add(option);
                    }
                    /*if(!selected){
                        element.add(invalidOp);
                    }*/
                    cnt++;
                }
                // update data prototype selects
            }
        }
    }
}

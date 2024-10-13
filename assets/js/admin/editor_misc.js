msg = [];
entityImages = ['images', 'storageDeviceImages', 'entityImages'];
entityDocs = ['manuals', 'documentations', 'storageDeviceDocumentations', 'entityDocumentations'];
entityBios = ['motherboardBios', 'expansionCardBios'];
entityFile = ['miscFiles', 'storageDeviceMiscFiles', 'audioFiles']
allowedImages = ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'image/svg+xml'];
allowedDocs = ['application/pdf', 'application/x-pdf'];
allowedAudio = ['audio/mpeg', 'audio/ogg'];
// admin navbar buttons
if(slugbtn = document.getElementById('get-slug-btn'))
    slugbtn.addEventListener("click", () => getSlug(slugbtn.getAttribute('data-entity')), false);
if(saveretbtn = document.getElementById("js-save"))
    saveretbtn.addEventListener('click', () => submit("action-saveAndReturn"), false);
if(savecontbtn = document.getElementById("js-save-continue"))
    savecontbtn.addEventListener('click', () => submit("action-saveAndContinue"), false);
if(capacitybtn = document.getElementById("hdd-capacity-convert"))
    capacitybtn.addEventListener('click', () => convertSize("HardDrive_capacity", 1));
if(bufferbtn = document.getElementById("hdd-buffer-convert"))
    bufferbtn.addEventListener('click', () => convertSize("HardDrive_buffer", 1024));
getDate();
function getSlug(entity){
    let manuf = document.getElementById(entity + '_manufacturer');
    let name = document.getElementById(entity + '_name');
    let slug = document.getElementById(entity + '_slug');
    let string = manuf.options[manuf.selectedIndex].text;
    if(string == '')
        string = 'unknown ' + name.value;
    else
        string = string + ' ' + name.value;
    slug.value = string.replace(/[^a-z0-9_]+/gi, '-').replace(/^-|-$/g, '').toLowerCase().substring(0, 43);
}
function calculateSize(bytes){
    if      (bytes >= 1073741824) { bytes = (bytes / 1073741824).toFixed(2) + " GiB"; }
    else if (bytes >= 1048576)    { bytes = (bytes / 1048576).toFixed(2) + " MiB"; }
    else if (bytes >= 1024)       { bytes = (bytes / 1024).toFixed(2) + " KiB"; }
    else if (bytes > 1)           { bytes = bytes + " bytes"; }
    else if (bytes == 1)          { bytes = bytes + " byte"; }
    else                          { bytes = "0 bytes"; }
    return bytes;
}
function submit(name){
    entity = saveretbtn.getAttribute('data-entity');
    let save = document.getElementsByClassName(name)[0];
    let slug = document.getElementById(entity + "_slug");
    if(slug && slug.value == "")
        getSlug(entity);
    if(!setDate())
        return;
    validateCardTypes();
    if(!validateFiles(entity, save))
        return;
    if(entity != "ExpansionCard" && entity != "Chip" && entity != "LargeFile"){
        saveretbtn.setAttribute("disabled", "disabled");
        savecontbtn.setAttribute("disabled", "disabled");
        save.click();
        // if validation fails, enable buttons again
        if(document.getElementsByClassName('badge-danger').length > 0){
            saveretbtn.removeAttribute("disabled");
            savecontbtn.removeAttribute("disabled");
        }
    }
}
function validateCardTypes(){
    let cardTypeCollection = document.getElementById("ExpansionCard_type_collection");
    if(cardTypeCollection){
        let cardTypes = document.getElementsByClassName("ExpansionCard_type_cssid");
        if(cardTypes.length < 1){
            msg.push("Expansion card type is empty");
        }
        for(let type of cardTypes){
            let select = type.querySelector("select");
            if(select.value === ""){
                msg.push("Expansion card type is not set");
            }
        }
    }
}
function validateFiles(entity, save){
    for(const img of entityImages)
        validateEntityUpload(entity, img, "Image", 8388608)
    for(const doc of entityDocs)
        validateEntityUpload(entity, doc, "Document", 33554432)
    for(const bios of entityBios)
        validateEntityUpload(entity, bios, "BIOS", 33554432)
    for(const file of entityFile)
        validateEntityUpload(entity, file, "File", 67108864)
    if(msg.length == 0){
        save.setAttribute('data-valid', true);
        return true;
    }
    else{
        final = "";
        for(const error of msg){
            final += error + "\n";
        }
        alert(final);
        msg = []
        return false;
    }

}
function validateEntityUpload(entity, type, message, maxSize){
    let entityList = document.getElementsByClassName(entity + "_" + type + "_cssid")
    if(entityList.length == 0)
        return;
    for(let i=0; i<entityList.length; ++i){
        if(file = entityList[i].querySelectorAll("input[type=file]")[0].files[0]){
            if(file.size > maxSize){
                msg.push(message + " [" + file.name + "] is too big (" + calculateSize(file.size) + ")");
            }
            if(entityImages.includes(type) && !allowedImages.includes(file.type)){
                msg.push(message + " [" + file.name + "] is not allowed (JPG, PNG, GIF and SVG only)");
            }
            if(entityDocs.includes(type) && !allowedDocs.includes(file.type)){
                msg.push(message + " [" + file.name + "] is not allowed (PDF only)");
            }
            if(type == "audioFiles" && !allowedAudio.includes(file.type)){
                msg.push(message + " [" + file.name + "] is not allowed (MP3 and OGG only)");
            }
            if(type.toLowerCase().includes("documentations") || type.toLowerCase().includes("manuals"))
                if(entityList[i].querySelector('input[id*="_link_name"]').value == "")
                    msg.push(message + " [" + file.name + "] title is empty");
        }
        else{
            //images
            if(type.toLowerCase().includes("images") && entityList[i].querySelector('a[class*="ea-lightbox-thumbnail"]') == null)
                msg.push("Image [" + i + "] is empty");
            //docs
            if(type.toLowerCase().includes("documentations") || type.toLowerCase().includes("manuals")){
                let linkName = entityList[i].querySelector('input[id*="_link_name"]');
                let fileLink = entityList[i].querySelector('a[id*="_file_link"]');
                if(linkName.value != "" && fileLink == null)
                    msg.push("PDF [" + i + "] file is empty");
            }
        }
    }
    console.log("Checked: " + entity + " => " + type);
}
function getDate(){
    for(let widget of document.getElementsByClassName("releasedate-cssid")){
        let entity = widget.getAttribute("data-entity");
        let releaseDate = document.getElementById(entity + "_releaseDate").value;
        let datePrecision = document.getElementById(entity + "_datePrecision").value;
        let yearSel = widget.querySelectorAll("input[type=number]")[0];
        let monthSel = widget.querySelectorAll("input[type=number]")[1];
        let daySel = widget.querySelectorAll("input[type=number]")[2];
        yearSel.value = releaseDate.substring(0,4);
        if(datePrecision == "m" || datePrecision == "d"){
            monthSel.value = releaseDate.substring(5,7);
            if(datePrecision == "d")
                daySel.value = releaseDate.substring(8,10);
        }
    }
}
function setDate(){
    for(let widget of document.getElementsByClassName("releasedate-cssid")){
        let entity = widget.getAttribute("data-entity");
        let yearSel = widget.querySelectorAll("input[type=number]")[0].value;
        let monthSel = parseInt(widget.querySelectorAll("input[type=number]")[1].value);
        let daySel = parseInt(widget.querySelectorAll("input[type=number]")[2].value);
        let month = 1;
        let day = 1;
        let releaseDate = document.getElementById(entity + "_releaseDate");
        let datePrecision = document.getElementById(entity + "_datePrecision");
        if(!yearSel){
            if(releaseDate.value !== ""){
                releaseDate.value = "";
            }
            return true;
        }
        if(yearSel < 1970 || yearSel > 2100){
            alert("Invalid release date year!");
            return false;
        }
        if(monthSel){
            if(monthSel < 1 || monthSel > 12){
                alert("Invalid release date month!");
                return false;
            }
            if(daySel){
                datePrecision.value = "d";
                month = monthSel;
                day = daySel;
                if(daySel < 1 || daySel > 31){
                    alert("Invalid release date day!");
                    return false;
                }
            }
            else{
                datePrecision.value = "m";
                month = monthSel;
            }
        }
        else
            datePrecision.value = "y";
        releaseDate.value = yearSel + "-" + (month > 9 ? "" : "0") + month + "-" + (day > 9 ? "" : "0" ) + day;
    }
    return true;
}
function convertSize(el, f){
    let input = document.getElementById(el);
    let value = input.value;
    let factor = f;
    let numeric = value.replace(/[^0-9.,]+/, '');
    if(value.toUpperCase().includes("GB"))
        factor *= 1024;
    if(value.toUpperCase().includes("TB"))
        factor *= 1048576;
    //console.log(numeric, factor);
    input.value = (numeric * factor) | 0;
}

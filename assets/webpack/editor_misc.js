// admin navbar buttons
if(slugbtn = document.getElementById('get-slug-btn'))
    slugbtn.addEventListener("click", () => getSlug(slugbtn.getAttribute('data-entity')), false);
if(saveretbtn = document.getElementById("js-save"))
    saveretbtn.addEventListener('click', () => submit(saveretbtn.getAttribute('data-entity'), "action-saveAndReturn"), false);
if(savecontbtn = document.getElementById("js-save-continue"))
    savecontbtn.addEventListener('click', () => submit(savecontbtn.getAttribute('data-entity'), "action-saveAndContinue"), false);
msg = [];
entityImages = ['images', 'storageDeviceImages'];
entityDocs = ['manuals', 'documentations', 'storageDeviceDocumentations'];
entityBios = ['motherboardBios', 'expansionCardBios'];
entityFile = ['miscFiles', 'storageDeviceMiscFiles', 'audioFiles']
allowedImages = ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'image/svg+xml'];
allowedDocs = ['application/pdf', 'application/x-pdf'];
allowedAudio = ['audio/mpeg', 'audio/ogg'];
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
    if      (bytes >= 1073741824) { bytes = (bytes / 1073741824).toFixed(2) + " GB"; }
    else if (bytes >= 1048576)    { bytes = (bytes / 1048576).toFixed(2) + " MB"; }
    else if (bytes >= 1024)       { bytes = (bytes / 1024).toFixed(2) + " KB"; }
    else if (bytes > 1)           { bytes = bytes + " bytes"; }
    else if (bytes == 1)          { bytes = bytes + " byte"; }
    else                          { bytes = "0 bytes"; }
    return bytes;
}
function submit(entity, name){
    let save = document.getElementsByClassName(name)[0];
    if(!validateFiles(entity, save))
        return;
    if(entity != "ExpansionCard" && entity != "ExpansionChip"){
        save.click();
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
    console.log(entityList)
    if(entityList.length == 0)
        return true;
    for(let i=0; i<entityList.length; ++i){
        if(file = entityList[i].querySelectorAll("input[type=file]")[0].files[0]){
            console.log(file.type);
            if(file.size > maxSize){
                msg.push(message + " " + file.name + " is too big (" + calculateSize(file.size) + ")");
            }
            if(entityImages.includes(type) && !allowedImages.includes(file.type)){
                msg.push(message + " " + file.name + " is not allowed (JPG, PNG, GIF and SVG only)");
            }
            if(entityDocs.includes(type) && !allowedDocs.includes(file.type)){
                msg.push(message + " " + file.name + " is not allowed (PDF only)");
            }
            if(type == "audioFiles" && !allowedAudio.includes(file.type)){
                msg.push(message + " " + file.name + " is not allowed (MP3 and OGG only)");
            }
        }
    }
}

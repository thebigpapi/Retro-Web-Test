
//initialize tom-select
var settings = {
    plugins: {
        dropdown_input: {},
    },
    render: {
        option: function (data, escape) {
            return '<div>' + escape(data.text) + '</div>';
        },
        item: function (data, escape) {
            return '<div>' + escape(data.text) + '</div>';
        },
        option_create: function (data, escape) {
            return '<div class="create">Add <strong>' + escape(data.input) + '</strong>&hellip;</div>';
        },
        no_results: function (data, escape) {
            return '<div class="no-results">No results found for "' + escape(data.input) + '"</div>';
        },
        not_loading: function (data, escape) {
            // no default content
        },
        optgroup: function (data) {
            let optgroup = document.createElement('div');
            optgroup.className = 'optgroup';
            optgroup.appendChild(data.options);
            return optgroup;
        },
        optgroup_header: function (data, escape) {
            return '<div class="optgroup-header">' + escape(data.label) + '</div>';
        },
        loading: function (data, escape) {
            return '<div class="spinner"></div>';
        },
        dropdown: function () {
            return '<div></div>';
        }
    }
};
let fieldList = ["name", "version", "os-support", "os-arch", "date", "precision", "releasedate", "file"]
let createDriverBtn = document.getElementById('create-driver-btn');
let form = document.getElementById('edit-LargeFile-form');
let formtype = "edit-LargeFile-form";
if(!form){
    form = document.getElementById('new-LargeFile-form');
    formtype = "new-LargeFile-form";
}
if(form){
    if(saveretbtn = document.getElementById("js-save"))
        saveretbtn.addEventListener('click', () => fullDriverSubmit("saveAndReturn"), false);
    if(savecontbtn = document.getElementById("js-save-continue"))
        savecontbtn.addEventListener('click', () => fullDriverSubmit("saveAndContinue"), false);
    if(sdfgh = document.getElementById("js-readinf"))
        sdfgh.addEventListener('change', () => readInf(), false);
}
if(createDriverBtn){
    createDriverBtn.addEventListener('click', () => createContainer(), false);
}

// upload handler
function beginUpload(url, formData, container, type){
    let date = new Date()
    let bytesLoaded = 0
    let xhr = new XMLHttpRequest();
    xhr.open("POST", url);
    xhr.onprogress = function (e) {
        if (e.lengthComputable) {
            console.log(e.loaded + " / " + e.total)
        }
    }
    let speedText;
    let bar;
    let errorDiv = document.getElementById("driver-error-div");
    errorDiv.setAttribute("style", "display: none;")
    xhr.upload.addEventListener("progress", function (evt) {
        if (evt.lengthComputable) {
            bar = document.getElementById('progressBar');
            bar.value = evt.loaded;
            bar.max = evt.total;
            bar.innerHTML = evt.loaded / evt.total * 100;
            if (evt.loaded == evt.total) {
                showMessage("Processing ...");
            }
            else {
                let newdate = new Date()
                let speed = (evt.loaded - bytesLoaded) * (1000 / (newdate.getTime() - date.getTime()))
                if (speed > 1024)
                    if (speed > 1024 * 1024)
                        speedText = Number.parseFloat(speed / 1024 / 1024).toFixed(1) + "MB/s";
                    else
                        speedText = Number.parseFloat(speed / 1024).toFixed(1) + "KB/s";
                else
                    speedText = Math.round(speed) + "Bytes/sec";
                showMessage("Upload in progress ..." + speedText);
                date = newdate
                bytesLoaded = evt.loaded
            }
        }
    }, false);
    xhr.onloadstart = function (e) {
        bar = document.getElementById('progressBar')
        bar.hidden = false
        document.getElementsByClassName('action-saveAndReturn btn btn-primary action-save')[0].setAttribute('disabled', true);
    }
    xhr.onloadend = function (e) {
        document.getElementsByClassName('action-saveAndReturn btn btn-primary action-save')[0].removeAttribute('disabled');
        bar = document.getElementById('progressBar')
        bar.hidden = true
        if (xhr.status == 200) {
            if(xhr.responseText.startsWith("<!DOCTYPE HTML>")){
                showMessage("Uploaded!", false);
                if(container){
                    addDriver(container);
                }
                if(type == "saveAndReturn"){
                    window.onbeforeunload = null;
                    window.location = window.location.origin + "/drivers/" + url.substring(url.indexOf("entityId=") + 9);
                }
                if(type == "saveAndContinue"){
                    window.onbeforeunload = null;
                    window.location = url;
                }
            }
            else if(xhr.responseText.trim().startsWith('<!DOCTYPE html>')){
                let parser = new DOMParser();
                let doc = parser.parseFromString(xhr.responseText, "text/html");
                let oldContainer = document.getElementById('main');
                let parsedContainer = doc.getElementById('main');
                oldContainer.innerHTML = parsedContainer.innerHTML;
            }
            else{
                showMessage("Something exploded!", true);
                errorDiv.setAttribute("style", "display: block;")
                errorDiv.children[0].innerHTML = xhr.responseText;
            }
        }
        else if(xhr.status == 500){
            let parser = new DOMParser();
            let doc = parser.parseFromString(xhr.responseText, "text/html");
            showMessage(xhr.statusText, true);
            errorDiv.setAttribute("style", "display: block;")
            errorDiv.children[0].innerHTML = doc.getElementsByClassName('break-long-words exception-message')[0].innerHTML;
        }
        else if (xhr.status == 422){
            let parser = new DOMParser();
            let doc = parser.parseFromString(xhr.responseText, "text/html");
            let errors = "";
            for (let error of doc.getElementsByClassName("invalid-feedback")){
                errors += error.innerHTML + "\n";
            }
            showMessage("Invalid fields", true);
            errorDiv.setAttribute("style", "display: block;")
            errorDiv.children[0].innerHTML = errors;
        }
        else {
            showMessage("Error " + xhr.status + ": " + xhr.statusText, true);
        }
    }
    xhr.send(formData);
}

// mini driver editor
function createContainer(){
    let template = document.getElementById('create-driver-template');
    let container = document.getElementById('create-driver-container');
    if(container.innerHTML == "")
        container.innerHTML = template.innerHTML;
    else
        alert("Can only add one driver at a time!");
    populateFields();
    let save = document.getElementById('create-driver-save');
    save.addEventListener('click', () => miniDriverSubmit(), false);
}

function populateFields(){
    showMessage("Setting up, just a sec ...", false);
    for(const item of fieldList){
        let el = document.getElementsByClassName("newdriver-" + item + "-cssid")[0];
        el.setAttribute("id", "newdriver-" + item)
    }
    driverForm=document.createElement('FORM');
    driverForm.name='LargeFile';
    driverForm.method='POST';
    driverForm.action='#';
    driverForm.setAttribute("id", "newdriver-form");
    document.body.appendChild(driverForm);
    let list = [];
    fetch(window.location.origin + "/dashboard/getdriverfields", {
        redirect: 'follow',
        method: "GET",
    })
    .then(response => response.text())
    .then((responseText) => {
        list = JSON.parse(responseText);
        let os = document.getElementById("newdriver-os-support");
        let osArch = document.getElementById("newdriver-os-arch");
        for(const key of Object.keys(list[0])){
            let op = new Option(key, list[0][key]);
            os.add(op);
        }
        for(const key of Object.keys(list[1])){
            let op = new Option(key, list[1][key]);
            osArch.add(op);
        }
        osArch.setAttribute('id', "newdriver-os-arch");
        new TomSelect('#newdriver-os-support', settings);
        new TomSelect('#newdriver-os-arch', settings);
        osArch.tomselect.addOption({entityId: 1, entityAsString: "x86"})
        osArch.tomselect.addItem(1);
        os.tomselect.sync();
        osArch.tomselect.sync();
        driverForm.setAttribute("data-token", list[2]);
        showMessage("", false);
    }).catch(err => console.log("Driver fields request failed: " + err));
}

function miniDriverSubmit(){
    hideMessage();
    let name = document.getElementById("newdriver-name").value;
    let version = document.getElementById("newdriver-version").value;
    let os = getSelectValues(document.getElementById("newdriver-os-support"));
    let osArch = getSelectValues(document.getElementById("newdriver-os-arch"));
    let file = document.getElementById("newdriver-file");
    if(name == ""){
        alert("Driver name field is empty!");
        return;
    }
    if(file.files.length < 1){
        alert("Driver has no file attached!");
        return;
    }
    if(!setDriverDate()){
        return;
    }
    let container = document.getElementById('create-driver-container');
    let url = container.getAttribute("data-url");
    let driverForm = document.getElementById("newdriver-form");
    let formData = new FormData(driverForm);
    //grabbing the token
    fetch(url, {
        redirect: 'follow',
        method: "GET",
    })
    .then(response => response.text())
    .then((responseText) => {
        let parser = new DOMParser();
        let parsedResponse = parser.parseFromString(responseText, "text/html");
        let token = parsedResponse.getElementById("LargeFile__token").value;
        //setting up the form data
        formData.append("ea[newForm][btn]", "saveAndReturn");
        formData.append("LargeFile[name]", name);
        formData.append("LargeFile[fileVersion]", version);
        formData.append("LargeFile[releaseDate]", document.getElementById("newdriver-date").innerHTML);
        formData.append("LargeFile[datePrecision]", document.getElementById("newdriver-precision").innerHTML);
        for(let i=0; i<os.length; i++){
            formData.append("LargeFile[osFlags][" + (i+1) + "]", os[i]);
        }
        for(let i=0; i<osArch.length; i++){
            formData.append("LargeFile[osArchitecture][" + (i+1) + "]", osArch[i]);
        }
        formData.append("LargeFile[_token]", token);
        formData.append("LargeFile[file][file]", file.files[0]);
        //upload begins
        beginUpload(url, formData, container, null);
    }).catch(err => console.log("Driver form request failed: " + err));
}

function addDriver(container){
    let name = document.getElementById("newdriver-name").value;
    let version = document.getElementById("newdriver-version").value;
    let os = getSelectValues(document.getElementById("newdriver-os-support"));
    let entity = container.getAttribute("data-entity");
    let driverAddBtn = document.getElementById(entity + "_collection").previousElementSibling;
    driverAddBtn.click();
    let drivers = document.getElementsByClassName(entity + "_cssid");
    let driverSelect = drivers[drivers.length - 1].querySelector("select");
    fetch(window.location.origin + "/dashboard/finddriver?" + new URLSearchParams({"name": name, "version" : version, "os": os}), {
        redirect: 'follow',
        method: "GET"
    }).then(response => response.text())
    .then((res) => {
        result = JSON.parse(res);
        driverSelect.tomselect.addOption({entityId: Object.values(result)[0], entityAsString: Object.keys(result)[0]})
        driverSelect.tomselect.addItem(Object.values(result)[0]);
        driverSelect.tomselect.sync();
        console.log()
        if(Object.keys(result).length > 0){
            showMessage("Added to list succesfully!", false);
            container.innerHTML = "";
        }
        else{
            showMessage("Driver added, but could not be found by name!", true);
        }
    }).catch(err => console.log("Driver find failed: " + err));
}

// main driver editor
function fullDriverSubmit(type) {
    setArch();
    let file_name = document.getElementById('LargeFile_file_file_new_file_name');
    if(file_name.innerHTML != ""){
        let formData = new FormData(document.getElementById(formtype));
        formData.append("ea[newForm][btn]", type);
        beginUpload(window.location.href, formData, null, type);
        if(type == "saveAndReturn")
            window.onbeforeunload = null;
        if(type == "saveAndContinue"){
            window.onbeforeunload = null;
        }
    }
    else{
        let save = document.getElementsByClassName("action-" + type)[0];
        if(save.getAttribute('data-valid') == "true"){
            saveretbtn.setAttribute("disabled", "disabled");
            savecontbtn.setAttribute("disabled", "disabled");
            save.click();
            if(document.getElementsByClassName('badge-danger').length > 0){
                saveretbtn.removeAttribute("disabled");
                savecontbtn.removeAttribute("disabled");
            }
        }
    }
}

function setArch(){
    let arch = document.getElementsByClassName("LargeFile_osArchitecture_cssid");
    if(arch.length > 0)
        return;
    let addbtn = document.getElementById("LargeFile_osArchitecture_collection").previousElementSibling;
    addbtn.click();
    let id = arch[0].getAttribute("data-id");
    let archSelect = document.getElementById("LargeFile_osArchitecture_" + id);
    archSelect.value = 1;
    archSelect.tomselect.sync();
}

// INF parder
function readInf(){
    let input = document.getElementById("js-readinf");
    const [file] = input.files;
    const reader = new FileReader();
    reader.addEventListener("load", () => {processInf(reader.result)}, false);
    if (file) {
        reader.readAsText(file);
    }
}

function processInf(data){
    let venArray = [];
    let devArray = [];
    let found = data.indexOf("&DEV_");
    //console.log(found);
    while (found !== -1) {
        devArray.push(data.substring(found + 5, found + 9));
        venArray.push(data.substring(found - 4, found));
        found = data.indexOf("&DEV_", found + 1);
    }
    devArray = new Set(devArray);
    venArray = new Set(venArray);
    if(devArray.size < 1 || venArray.size < 1){
        showPciMessage("No PCI IDs were found!");
    }
    fetch(window.location.origin + "/dashboard/getchipspci", {
        method: "POST",
        body: JSON.stringify([Array.from(venArray), Array.from(devArray)])
    }).then(response => response.text())
    .then((text) => {
        addChips(JSON.parse(text));
    }).catch(err => console.log("Chip fill-in failed: " + err));
}

function addChips(chipArray){
    if(Object.keys(chipArray).length < 1){
        showPciMessage("No chips were found!");
        return;
    }
    let chipsAddBtn = document.getElementById("LargeFile_chips_collection").previousElementSibling;
    let chips = document.getElementsByClassName("LargeFile_chips_cssid");
    if(chips.length > 0){
        if(confirm("List is not empty, want to clear it?")){
            let list = document.getElementById("LargeFile_chips_collection").children[0].children[0].children[0].children[0];
            list.innerHTML = "";
        }
        else return;
    }
    for(const chip in chipArray){
        chipsAddBtn.click();
    }
    let idx = 0;
    for(let chip of chips){
        //console.log(Object.values(chipArray)[idx]);
        let chipSelect = chip.querySelector("select");
        //console.log(chipSelect)
        chipSelect.tomselect.addOption({entityId: Object.keys(chipArray)[idx], entityAsString: Object.values(chipArray)[idx]})
        chipSelect.tomselect.addItem(Object.keys(chipArray)[idx]);
        chipSelect.tomselect.sync();
        idx++;
    }
    showPciMessage("Added " + idx + " chips");
}

// auxiliary functions
function showPciMessage(message){
    let msg = document.getElementById("js-readinf-status");
    msg.innerHTML = message
}

function showMessage(message, warning){
    let msg = document.getElementById("newdriver-message");
    let img = document.getElementById("newdriver-message-img");
    msg.innerHTML = message
    if(warning)
        img.setAttribute("style","display:inline;");
}

function hideMessage(){
    let msg = document.getElementById("newdriver-message");
    let img = document.getElementById("newdriver-message-img");
    img.setAttribute("style","display:none;");
    msg.innerHTML = "";
}

function getSelectValues(select) {
    let result = [];
    let options = select && select.options;
    let opt;
    for (var i=0, iLen=options.length; i<iLen; i++) {
        opt = options[i];
        if (opt.selected) {
            result.push(opt.value || opt.text);
        }
    }
    return result;
}
function setDriverDate(){
    let widget = document.getElementById("newdriver-releasedate");
    let yearSel = widget.querySelectorAll("input[type=number]")[0].value;
    let monthSel = parseInt(widget.querySelectorAll("input[type=number]")[1].value);
    let daySel = parseInt(widget.querySelectorAll("input[type=number]")[2].value);
    let month = 1;
    let day = 1;
    let releaseDate = document.getElementById("newdriver-date");
    let datePrecision = document.getElementById("newdriver-precision");
    if(!yearSel){
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
            datePrecision.innerHTML = "d";
            month = monthSel;
            day = daySel;
            if(daySel < 1 || daySel > 31){
                alert("Invalid release date day!");
                return false;
            }
        }
        else{
            datePrecision.innerHTML = "m";
            month = monthSel;
        }
    }
    else
        datePrecision.innerHTML = "y";
    releaseDate.innerHTML = yearSel + "-" + (month > 9 ? "" : "0") + month + "-" + (day > 9 ? "" : "0" ) + day;
    return true;
}

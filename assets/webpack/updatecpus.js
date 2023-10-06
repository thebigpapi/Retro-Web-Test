if(updatecpubtn = document.getElementById('update-cpu-btn'))
    updatecpubtn.addEventListener("click", updateFamilies);
if(slugbtn = document.getElementById('get-slug-btn'))
    slugbtn.addEventListener("click", getslug);
if(mobobios = document.getElementsByClassName('mobo-bios')[0])
    addFileInput(mobobios);
function getslug() {
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

function updateFamilies() {
    console.log('triggered');
    let params = [];
    let cnt = 0;
    // read CPU sockets
    let sockets = document.getElementById('Motherboard_cpuSockets');
    if(!sockets){
        sockets = document.getElementById('Motherboard_cpuSockets_collection').children[0].children[0];
        if(sockets.innerHTML == "Empty"){
            alert("Error: no sockets added!");
            return;
        }
        sockets = document.getElementById('Motherboard_cpuSockets_collection').children[0].children[0].children[0].children[0];
    }
    if(sockets.childElementCount == 0){
        alert("Error: no sockets added!");
        return;
    }
    let socket_cnt = sockets.childElementCount;
    while(socket_cnt > 0){
        if(document.getElementById("Motherboard_cpuSockets_" + cnt)){
            let element = document.getElementById("Motherboard_cpuSockets_" + cnt);
            if(element.value)
                params.push(element.value);
            socket_cnt--;
        }
        cnt++;
    }
    if(params.length == 0){
        alert("Error: no sockets selected!");
        return;
    }
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
            updateWidget(platformArray);
            // update data prototype selects
            updatePrototype(platformArray);
        }
    }
}
function updateWidget(platformArray){
    let cnt = 0;
    let platforms = document.getElementById('Motherboard_processorPlatformTypes');
    if(!platforms){
        platforms = document.getElementById('Motherboard_processorPlatformTypes_collection').children[0].children[0];
        if(platforms.innerHTML == "Empty"){
            alert("Warning: no families added!");
            return;
        }
        platforms = document.getElementById('Motherboard_processorPlatformTypes_collection').children[0].children[0].children[0].children[0];
    }
    if(platforms.childElementCount == 0){
        alert("Warning: no families added!");
        return;
    }
    let platform_cnt = platforms.childElementCount;
    while(platform_cnt > 0){
        if(document.getElementById("Motherboard_processorPlatformTypes_" + cnt)){
            let element = document.getElementById("Motherboard_processorPlatformTypes_" + cnt);
            let selectedValue = element.value;
            let selected = false;
            let invalidOp = new Option("Invalid CPU family, reselect!",'');
            invalidOp.setAttribute("selected", "selected");
            element.innerHTML = "";
            for(const key in platformArray){
                let option = new Option(platformArray[key],key.slice(1));
                if(key.slice(1) == selectedValue){
                    option.setAttribute("selected", "selected");
                    selected = true;
                }
                element.add(option);
            }
            if(!selected){
                element.add(invalidOp);
            }
            platform_cnt--;
        }
        cnt++;
    }
}
function updatePrototype(platformArray){
    let widget = document.getElementById('mobo-cpu-families-form');
    let doc = document.createRange().createContextualFragment(widget.getAttribute('data-prototype'));
    let prototypeSelect = doc.getElementById('Motherboard_processorPlatformTypes___processorPlatformTypesname__');
    prototypeSelect.innerHTML = "";
    for(const key in platformArray){
        let option = new Option(platformArray[key],key.slice(1));
        prototypeSelect.add(option);
    }
    const serializer = new XMLSerializer();
    const document_fragment_string = serializer.serializeToString(doc);
    widget.setAttribute('data-prototype', document_fragment_string)
}
function addFileInput(element){
    let div = document.createElement('div');
    let input = document.createElement('input');
    let button = document.createElement('button');
    input.setAttribute('type', 'file');
    input.setAttribute('id', 'bios-bot-input');
    button.setAttribute('type', 'button');
    button.setAttribute('class', 'btn btn-secondary');
    button.innerHTML = "Get strings";
    button.addEventListener("click", readFile)
    div.innerHTML = "CSV ";
    div.setAttribute('class', 'bios-bot-csv-box');
    div.appendChild(input);
    div.appendChild(button);
    element.firstChild.appendChild(div);
}
function readFile(){
    if(confirm("BIOS strings are about to be changed, proceed?")){
        //do things
        let fr=new FileReader();
        let input = document.getElementById('bios-bot-input');
        fr.onload=function(){
            csv=csvToArray(fr.result);
            if(csv.length < 2){
                alert("Error: CSV is empty!");
                return;
            }
            processFile(csv);
        }
        if(!input.files[0]){
            alert("Error: no file selected!");
            return;
        }
        let extension = input.files[0].name.split('.').pop().toLowerCase();
        if(extension != "csv"){
            alert("Error: not a CSV file!");
            return;
        }
        fr.readAsText(input.files[0]);
    }
}
function processFile(csv){
    let bioses = document.getElementById('Motherboard_motherboardBios');
    if(!bioses){
        bioses = document.getElementById('Motherboard_motherboardBios_collection').children[0].children[0];
        if(bioses.innerHTML == "Empty"){
            alert("Error: no BIOSes added!");
            return;
        }
        bioses = document.getElementById('Motherboard_motherboardBios_collection').children[0].children[0].children[0].children[0];
    }
    if(bioses.childElementCount == 0){
        alert("Error: no BIOSes added!")
        return;
    }
    if(bioses.childElementCount < csv.length){
        alert("Error: there are more BIOSes in the CSV than in the editor!\nCSV: " + csv.length + "\neditor: " + bioses.childElementCount)
        return;
    }
    let bios_cnt = bioses.childElementCount;
    let cnt = 0;
    while(bios_cnt > 0){
        //read file name
        if(file = document.getElementById("Motherboard_motherboardBios_" + cnt + "_romFile_file_new_file_name")){
            let name = file.innerHTML.split(" (")[0];
            if(name == ""){
                if(link = document.getElementById("Motherboard_motherboardBios_" + cnt + "_romFile_file_link"))
                    name = link.getAttribute('title');
            }
            if(name != ""){
                let found = csv.find(item => item[0].includes(name));
                    /*function(str) {
                        return str.indexOf(name);
                    }
                );*/
                console.log(name, found);
                if(found){
                    document.getElementById("Motherboard_motherboardBios_" + cnt + "_postString").value = found[3].slice(1,-1);
                    document.getElementById("Motherboard_motherboardBios_" + cnt + "_boardVersion").value = found[4].slice(1,-1);
                    document.getElementById("Motherboard_motherboardBios_" + cnt + "_coreVersion").value = found[2].slice(1,-1);
                    let select = document.getElementById("Motherboard_motherboardBios_" + cnt + "_manufacturer");
                    const options = Array.from(select.options);
                    const optionToSelect = options.find(item => found[1].slice(1,-1).includes(item.text));
                    select.value = optionToSelect.value;
                    select.tomselect.sync();
                }
            }
            bios_cnt--;
        }
        cnt++;
    }
}
function csvToArray(csv) {
    let rows = csv.split('\"\n');
    // remove the header, not needed
    rows = rows.slice(1);
    let result = [];
    for (const row of rows) {
        let values = row.split(',');
        // remove metadata and ROMs, not needed
        values.pop();
        values.pop();
        result.push(values);
    }
    // remove last element (empty array)
    result.pop();
    return result;
}
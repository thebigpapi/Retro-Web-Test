
if(updatecpubtn = document.getElementById('update-cpu-btn')){
    updatecpubtn.addEventListener("click", updateFamilies);
    updatecpubtn.click();
}

function updateFamilies() {
    let params = [];
    let cnt = 0;
    // read CPU sockets
    let sockets = document.getElementById('Motherboard_cpuSockets');
    if(!sockets){
        sockets = document.getElementById('Motherboard_cpuSockets_collection').children[0].children[0];
        if(sockets.innerHTML == "Empty"){
            setMessage("Error: no sockets added!");
            return;
        }
        sockets = document.getElementById('Motherboard_cpuSockets_collection').children[0].children[0].children[0].children[0];
    }
    if(sockets.childElementCount == 0){
        setMessage("Error: no sockets added!");
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
        setMessage("Error: no sockets selected!");
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
            setMessage("CPU family count is now: " + Object.keys(platformArray).length);
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
            setMessage("Warning: no families added!");
            return;
        }
        platforms = document.getElementById('Motherboard_processorPlatformTypes_collection').children[0].children[0].children[0].children[0];
    }
    if(platforms.childElementCount == 0){
        setMessage("Warning: no families added!");
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
            element.tomselect.clearOptions();
            element.tomselect.sync();
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
function setMessage(msg){
    let message = document.getElementById('update-cpus-label');
    message.innerHTML = msg;
}